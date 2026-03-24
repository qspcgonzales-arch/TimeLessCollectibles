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
    const [orders] = await pool.query(
      `SELECT o.*, p.prodname, p.image, p.price, p.prodcategory
       FROM user_orders o
       JOIN products p ON p.ID = o.ProductID
       WHERE o.UserID = ?
       ORDER BY o.OrderID DESC`,
      [req.session.user.id]
    );

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
  const connection = await pool.getConnection();

  try {
    const selectedItems = extractCheckoutItems(req.body.items);

    if (!selectedItems.length) {
      setFlash(req, 'error', 'Select at least one cart item to checkout.');
      return res.redirect('/cart');
    }

    const productIds = [...new Set(selectedItems.map((item) => item.productId))];
    const [ownedCartRows] = await connection.query(
      `SELECT product_id FROM cart_items
       WHERE user_id = ?
       AND product_id IN (${productIds.map(() => '?').join(',')})`,
      [req.session.user.id, ...productIds]
    );

    const ownedIds = new Set(ownedCartRows.map((row) => row.product_id));
    const validItems = selectedItems.filter((item) => ownedIds.has(item.productId));

    if (!validItems.length) {
      setFlash(req, 'error', 'Selected cart items are invalid. Please refresh your cart.');
      return res.redirect('/cart');
    }

    await connection.beginTransaction();

    for (const item of validItems) {
      await connection.query(
        'INSERT INTO user_orders (UserID, ProductID, quantity, pending, delivering, delivered) VALUES (?, ?, ?, 1, 0, 0)',
        [req.session.user.id, item.productId, item.quantity]
      );
      await connection.query('DELETE FROM cart_items WHERE user_id = ? AND product_id = ?', [
        req.session.user.id,
        item.productId,
      ]);
    }

    await connection.commit();
    setFlash(req, 'success', 'Checkout complete. Your order is now pending.');
    return res.redirect('/orders');
  } catch (error) {
    await connection.rollback();
    return next(error);
  } finally {
    connection.release();
  }
});

module.exports = router;
