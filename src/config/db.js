const mysql = require('mysql2/promise');
const dotenv = require('dotenv');

dotenv.config();

const isProduction = process.env.NODE_ENV === 'production';

const pickEnv = (...keys) => {
  for (const key of keys) {
    const value = process.env[key];
    if (typeof value === 'string' && value.trim() !== '') {
      return value.trim();
    }
  }
  return undefined;
};

const useSsl = String(process.env.DB_SSL || 'false').toLowerCase() === 'true';
const rejectUnauthorized = String(process.env.DB_SSL_REJECT_UNAUTHORIZED || 'true').toLowerCase() === 'true';

const host = pickEnv('DB_HOST', 'MYSQLHOST', 'MARIADB_HOST') || (isProduction ? undefined : '127.0.0.1');
const port = Number(pickEnv('DB_PORT', 'MYSQLPORT') || 3306);
const user = pickEnv('DB_USER', 'MYSQLUSER') || (isProduction ? undefined : 'root');
const password = pickEnv('DB_PASSWORD', 'MYSQLPASSWORD') || '';
const database = pickEnv('DB_NAME', 'MYSQLDATABASE') || (isProduction ? undefined : 'mstvhrxe_tcdb');

if (isProduction) {
  const missingVars = [];
  if (!host) missingVars.push('DB_HOST');
  if (!user) missingVars.push('DB_USER');
  if (!database) missingVars.push('DB_NAME');

  if (missingVars.length > 0) {
    throw new Error(
      `Missing required database environment variables in production: ${missingVars.join(', ')}`
    );
  }

  const normalizedHost = host.toLowerCase();
  if (normalizedHost === 'localhost' || normalizedHost === '127.0.0.1') {
    throw new Error(
      'DB_HOST is set to localhost in production. Set DB_HOST to your managed MySQL host from your provider.'
    );
  }
}

const pool = mysql.createPool({
  host,
  port,
  user,
  password,
  database,
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
