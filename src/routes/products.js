const express = require('express');
const pool = require('../config/db');
const { CATEGORY_MAP, normalizeProduct } = require('../utils/catalog');

const router = express.Router();

router.get('/', async (req, res, next) => {
  try {
    const rawCategory = req.query.category;
    let category = rawCategory ? String(rawCategory).trim() : '';
    const categoryByLabel = Object.entries(CATEGORY_MAP).find(
      ([, label]) => label.toLowerCase() === category.toLowerCase()
    );

    if (categoryByLabel) {
      category = categoryByLabel[0];
    }

    if (!CATEGORY_MAP[category]) {
      category = '';
    }

    const search = req.query.search ? `%${req.query.search.trim()}%` : null;

    const conditions = [];
    const values = [];

    if (category) {
      conditions.push('prodcategory = ?');
      values.push(category);
    }

    if (search) {
      conditions.push('(prodname LIKE ? OR description LIKE ?)');
      values.push(search, search);
    }

    const whereClause = conditions.length ? `WHERE ${conditions.join(' AND ')}` : '';
    const [products] = await pool.query(
      `SELECT * FROM products ${whereClause} ORDER BY prodcategory ASC, prodname ASC`,
      values
    );

    res.render('products/index', {
      title: 'Products',
      products: products.map(normalizeProduct),
      categories: CATEGORY_MAP,
      activeCategory: category,
      searchTerm: req.query.search || '',
    });
  } catch (error) {
    next(error);
  }
});

router.get('/:id', async (req, res, next) => {
  try {
    const [[product]] = await pool.query('SELECT * FROM products WHERE ID = ?', [req.params.id]);

    if (!product) {
      return res.status(404).render('error', { title: 'Not Found', error: new Error('Product not found') });
    }

    return res.render('products/show', {
      title: product.prodname,
      product: normalizeProduct(product),
    });
  } catch (error) {
    return next(error);
  }
});

module.exports = router;
