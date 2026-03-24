const express = require('express');
const pool = require('../config/db');
const authRoutes = require('./auth');
const productRoutes = require('./products');
const cartRoutes = require('./cart');
const orderRoutes = require('./orders');
const settingsRoutes = require('./settings');
const adminRoutes = require('./admin');
const { normalizeProduct } = require('../utils/catalog');

const router = express.Router();

router.get('/', async (req, res, next) => {
  try {
    const [products] = await pool.query(
      'SELECT * FROM products ORDER BY prodcategory ASC, prodname ASC LIMIT 8'
    );
    const [counts] = await pool.query(
      'SELECT prodcategory, COUNT(*) AS count FROM products GROUP BY prodcategory ORDER BY prodcategory ASC'
    );

    res.render('home', {
      title: 'Timeless Collectibles',
      featuredProducts: products.map(normalizeProduct),
      categoryCounts: counts,
    });
  } catch (error) {
    next(error);
  }
});

router.get('/about', (req, res) => {
  res.render('about', { title: 'About' });
});

router.use('/auth', authRoutes);
router.use('/products', productRoutes);
router.use('/cart', cartRoutes);
router.use('/orders', orderRoutes);
router.use('/settings', settingsRoutes);
router.use('/admin', adminRoutes);

module.exports = router;
