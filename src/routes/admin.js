const path = require('path');
const express = require('express');
const multer = require('multer');
const { v4: uuidv4 } = require('uuid');
const pool = require('../config/db');
const { requireAdmin, requireStaff } = require('../middleware/auth');
const { setFlash } = require('../middleware/flash');
const { normalizeProduct, getStatusLabel, CATEGORY_MAP } = require('../utils/catalog');

const router = express.Router();

const upload = multer({
  storage: multer.diskStorage({
    destination: path.join(__dirname, '..', 'public', 'uploads'),
    filename: (req, file, cb) => {
      const extension = path.extname(file.originalname).toLowerCase();
      const slug = (req.body.prodname || 'product').replace(/[^a-z0-9]+/gi, '-').toLowerCase();
      cb(null, `${slug}-${Date.now()}${extension}`);
    },
  }),
  fileFilter: (req, file, cb) => {
    const allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    cb(null, allowed.includes(file.mimetype));
  },
  limits: {
    fileSize: 5 * 1024 * 1024,
  },
});

// Both admin and staff can access dashboard
router.get('/', (req, res, next) => {
  if (req.session.user && (req.session.user.isAdmin || req.session.user.isStaff)) {
    return next();
  }
  return res.redirect('/auth/login');
}, async (req, res, next) => {
  try {
    const result = await pool.query(
      `SELECT
         (SELECT COUNT(*) FROM products) AS "productCount",
         (SELECT COUNT(*) FROM users) AS "userCount",
         (SELECT COUNT(*) FROM user_orders) AS "orderCount"`
    );
    const stats = result.rows[0];

    res.render('admin/dashboard', {
      title: 'Admin Dashboard',
      stats,
    });
  } catch (error) {
    next(error);
  }
});

// Only admin can manage products
router.get('/products', requireAdmin, async (req, res, next) => {
  try {
    const result = await pool.query('SELECT * FROM products ORDER BY prodname ASC');
    const products = result.rows;
    res.render('admin/products', {
      title: 'Manage Products',
      products: products.map(normalizeProduct),
    });
  } catch (error) {
    next(error);
  }
});

router.post('/products', requireAdmin, upload.single('image'), async (req, res, next) => {
  try {
    const { prodname, prodcategory, description, price } = req.body;

    if (!CATEGORY_MAP[String(prodcategory || '').trim()]) {
      setFlash(req, 'error', 'Please select a valid product category.');
      return res.redirect('/admin/products');
    }

    if (!req.file) {
      setFlash(req, 'error', 'A product image is required.');
      return res.redirect('/admin/products');
    }

    await pool.query(
      'INSERT INTO products (id, prodname, prodcategory, description, image, price) VALUES ($1, $2, $3, $4, $5, $6)',
      [
        uuidv4(),
        prodname,
        String(prodcategory),
        String(description || '').replace(/\n/g, '<br />'),
        `/static/uploads/${req.file.filename}`,
        Number(price),
      ]
    );

    setFlash(req, 'success', 'Product created.');
    return res.redirect('/admin/products');
  } catch (error) {
    return next(error);
  }
});

router.post('/products/:id/delete', requireAdmin, async (req, res, next) => {

  try {
    await pool.query('DELETE FROM products WHERE id = $1', [req.params.id]);
    setFlash(req, 'success', 'Product deleted.');
    return res.redirect('/admin/products');
  } catch (error) {
    return next(error);
  }
});

// Both admin and staff can view/manage orders
router.get('/orders', requireStaff, async (req, res, next) => {
  try {
    const result = await pool.query(
      `SELECT o.orderid AS "OrderID", o.userid AS "UserID", o.productid AS "ProductID",
              o.quantity, o.pending, o.delivering, o.delivered,
              u.email, u.address, u.country, p.prodname, p.image, p.price
       FROM user_orders o
       JOIN users u ON u.id = o.userid
       JOIN products p ON p.id = o.productid
       ORDER BY o.orderid DESC`
    );
    const orders = result.rows;

    res.render('admin/orders', {
      title: 'Manage Orders',
      orders: orders.map((order) => ({ ...order, statusLabel: getStatusLabel(order) })),
    });
  } catch (error) {
    next(error);
  }
});

// Both admin and staff can update order status
router.post('/orders/:id/status', requireStaff, async (req, res, next) => {
  try {
    const status = req.body.status;
    const statusMap = {
      pending: [1, 0, 0],
      delivering: [0, 1, 0],
      delivered: [0, 0, 1],
    };

    if (!statusMap[status]) {
      setFlash(req, 'error', 'Invalid order status.');
      return res.redirect('/admin/orders');
    }

    await pool.query(
      'UPDATE user_orders SET pending = $1, delivering = $2, delivered = $3 WHERE orderid = $4',
      [...statusMap[status], req.params.id]
    );

    setFlash(req, 'success', 'Order status updated.');
    return res.redirect('/admin/orders');
  } catch (error) {
    return next(error);
  }
});

module.exports = router;
