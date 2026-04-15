const express = require('express');
const pool = require('../config/db');
const { requireAuth } = require('../middleware/auth');
const { setFlash } = require('../middleware/flash');
const { getStatusLabel } = require('../utils/catalog');

const router = express.Router();

function extractCheckoutItems(itemsPayload) {
  if (!itemsPayload) {
    return [];
  }

  const rawItems = Array.isArray(itemsPayload)
    ? itemsPayload
    : typeof itemsPayload === 'object'
      ? Object.values(itemsPayload)
      : [itemsPayload];

  return rawItems
    .map((item) => {
      if (!item || typeof item !== 'object') {
        return null;
      }

      const productId = String(item.productId || '').trim();
      const quantity = Math.max(1, Number(item.quantity || 1));

      if (!productId) {
        return null;
      }

      return { productId, quantity };
    })
    .filter(Boolean);
}

router.get('/', requireAuth, async (req, res, next) => {
  try {
    const result = await pool.query(
      `SELECT o.orderid AS "OrderID", o.userid AS "UserID", o.productid AS "ProductID",
              o.quantity, o.pending, o.delivering, o.delivered,
              p.prodname, p.image, p.price, p.prodcategory
       FROM user_orders o
       JOIN products p ON p.id = o.productid
       WHERE o.userid = $1
       ORDER BY o.orderid DESC`,
      [req.session.user.id]
    );
    const orders = result.rows;

    res.render('orders/index', {
      title: 'Order History',
      orders: orders.map((order) => ({
        ...order,
        statusLabel: getStatusLabel(order),
      })),
    });
  } catch (error) {
    next(error);
  }
});

router.post('/checkout', requireAuth, async (req, res, next) => {
  const connection = await pool.connect();

  try {
    const selectedItems = extractCheckoutItems(req.body.items);

    if (!selectedItems.length) {
      setFlash(req, 'error', 'Select at least one cart item to checkout.');
      return res.redirect('/cart');
    }

    const productIds = [...new Set(selectedItems.map((item) => item.productId))];
    const placeholders = productIds.map((_, i) => `$${i + 2}`).join(',');
    const ownedResult = await connection.query(
      `SELECT product_id FROM cart_items
       WHERE user_id = $1
       AND product_id IN (${placeholders})`,
      [req.session.user.id, ...productIds]
    );
    const ownedCartRows = ownedResult.rows;

    const ownedIds = new Set(ownedCartRows.map((row) => row.product_id));
    const validItems = selectedItems.filter((item) => ownedIds.has(item.productId));

    if (!validItems.length) {
      setFlash(req, 'error', 'Selected cart items are invalid. Please refresh your cart.');
      return res.redirect('/cart');
    }

    await connection.query('BEGIN');

    for (const item of validItems) {
      await connection.query(
        'INSERT INTO user_orders (userid, productid, quantity, pending, delivering, delivered) VALUES ($1, $2, $3, TRUE, FALSE, FALSE)',
        [req.session.user.id, item.productId, item.quantity]
      );
      await connection.query('DELETE FROM cart_items WHERE user_id = $1 AND product_id = $2', [
        req.session.user.id,
        item.productId,
      ]);
    }

    await connection.query('COMMIT');
    setFlash(req, 'success', 'Checkout complete. Your order is now pending.');
    return res.redirect('/orders');
  } catch (error) {
    await connection.query('ROLLBACK');
    return next(error);
  } finally {
    connection.release();
  }
});

router.post('/:id/cancel', requireAuth, async (req, res, next) => {
  try {
    const result = await pool.query(
      'SELECT orderid, userid, pending FROM user_orders WHERE orderid = $1',
      [req.params.id]
    );
    const order = result.rows[0];

    if (!order) {
      setFlash(req, 'error', 'Order not found.');
      return res.redirect('/orders');
    }

    if (order.userid !== req.session.user.id) {
      setFlash(req, 'error', 'You are not authorized to cancel this order.');
      return res.redirect('/orders');
    }

    if (!order.pending) {
      setFlash(req, 'error', 'Only pending orders can be cancelled.');
      return res.redirect('/orders');
    }

    await pool.query('DELETE FROM user_orders WHERE orderid = $1', [req.params.id]);
    setFlash(req, 'success', 'Order cancelled successfully.');
    return res.redirect('/orders');
  } catch (error) {
    return next(error);
  }
});

module.exports = router;
