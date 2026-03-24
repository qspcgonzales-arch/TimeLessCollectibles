const express = require('express');
const pool = require('../config/db');
const { requireAuth } = require('../middleware/auth');
const { setFlash } = require('../middleware/flash');
const { normalizeProduct } = require('../utils/catalog');

const router = express.Router();

router.get('/', requireAuth, async (req, res, next) => {
  try {
    const result = await pool.query(
      `SELECT c.ID AS cartItemId, c.product_id, p.*
       FROM cart_items c
       JOIN products p ON p.ID = c.product_id
       WHERE c.user_id = $1
       ORDER BY p.prodname ASC`,
      [req.session.user.id]
    );
    const items = result.rows;

    res.render('cart/index', {
      title: 'Your Cart',
      items: items.map((item) => ({ ...normalizeProduct(item), quantity: 1 })),
    });
  } catch (error) {
    next(error);
  }
});

router.post('/items/:productId', requireAuth, async (req, res, next) => {
  try {
    const productId = req.params.productId;
    const result = await pool.query(
      'SELECT ID FROM cart_items WHERE user_id = $1 AND product_id = $2',
      [req.session.user.id, productId]
    );
    const existing = result.rows[0];

    if (existing) {
      setFlash(req, 'error', 'That item is already in your cart.');
      return res.redirect(req.get('referer') || '/products');
    }

    await pool.query('INSERT INTO cart_items (user_id, product_id) VALUES ($1, $2)', [
      req.session.user.id,
      productId,
    ]);

    setFlash(req, 'success', 'Item added to cart.');
    return res.redirect('/cart');
  } catch (error) {
    return next(error);
  }
});

router.post('/items/:productId/delete', requireAuth, async (req, res, next) => {
  try {
    await pool.query('DELETE FROM cart_items WHERE user_id = $1 AND product_id = $2', [
      req.session.user.id,
      req.params.productId,
    ]);

    setFlash(req, 'success', 'Item removed from cart.');
    return res.redirect('/cart');
  } catch (error) {
    return next(error);
  }
});

module.exports = router;
