const path = require('path');
const fs = require('fs/promises');
const pool = require('./db');

async function initializeDatabase() {
  const schemaPath = path.join(__dirname, '..', '..', 'schema.sql');
  const schemaSql = await fs.readFile(schemaPath, 'utf8');

  await pool.query(schemaSql);

  const countResult = await pool.query('SELECT COUNT(*)::int AS count FROM products');
  const productCount = countResult.rows[0]?.count || 0;

  console.log(`[db] schema initialized; products=${productCount}`);
}

module.exports = {
  initializeDatabase,
};