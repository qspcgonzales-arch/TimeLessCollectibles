const path = require('path');
const fs = require('fs/promises');
const pool = require('./db');

async function initializeDatabase() {
  const schemaPath = path.join(__dirname, '..', '..', 'schema.sql');
  const schemaSql = await fs.readFile(schemaPath, 'utf8');

  await pool.query(schemaSql);

  const countResult = await pool.query(`
    SELECT
      (SELECT COUNT(*)::int FROM products) AS products,
      (SELECT COUNT(*)::int FROM users) AS users,
      (SELECT COUNT(*)::int FROM cart_items) AS cart_items,
      (SELECT COUNT(*)::int FROM user_orders) AS user_orders
  `);
  const counts = countResult.rows[0] || {};

  console.log(
    `[db] schema initialized; products=${counts.products || 0} users=${counts.users || 0} cart_items=${counts.cart_items || 0} user_orders=${counts.user_orders || 0}`
  );
}

module.exports = {
  initializeDatabase,
};