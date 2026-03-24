const mysql = require('mysql2/promise');
const dotenv = require('dotenv');

dotenv.config();

const useSsl = String(process.env.DB_SSL || 'false').toLowerCase() === 'true';
const rejectUnauthorized = String(process.env.DB_SSL_REJECT_UNAUTHORIZED || 'true').toLowerCase() === 'true';

const pool = mysql.createPool({
  host: process.env.DB_HOST || '127.0.0.1',
  port: Number(process.env.DB_PORT || 3306),
  user: process.env.DB_USER || 'root',
  password: process.env.DB_PASSWORD || '',
  database: process.env.DB_NAME || 'mstvhrxe_tcdb',
  ssl: useSsl
    ? {
        rejectUnauthorized,
      }
    : undefined,
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0,
});

module.exports = pool;
