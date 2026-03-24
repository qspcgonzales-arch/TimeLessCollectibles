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

const connectionUrl = pickEnv('DATABASE_URL', 'MYSQL_URL', 'JAWSDB_URL');
let parsedUrl;

if (connectionUrl) {
  try {
    parsedUrl = new URL(connectionUrl);
  } catch (error) {
    throw new Error('Invalid DATABASE_URL/MYSQL_URL format for MySQL connection.');
  }
}

const urlProtocol = parsedUrl ? parsedUrl.protocol.replace(':', '').toLowerCase() : '';
const urlSsl = urlProtocol === 'mysqls';
const urlHost = parsedUrl ? parsedUrl.hostname : undefined;
const urlPort = parsedUrl && parsedUrl.port ? Number(parsedUrl.port) : undefined;
const urlUser = parsedUrl && parsedUrl.username ? decodeURIComponent(parsedUrl.username) : undefined;
const urlPassword = parsedUrl && parsedUrl.password ? decodeURIComponent(parsedUrl.password) : undefined;
const urlDatabase = parsedUrl && parsedUrl.pathname ? parsedUrl.pathname.replace(/^\//, '') : undefined;

const host = pickEnv('DB_HOST', 'MYSQLHOST', 'MARIADB_HOST') || urlHost || (isProduction ? undefined : '127.0.0.1');
const port = Number(pickEnv('DB_PORT', 'MYSQLPORT') || urlPort || 3306);
const user = pickEnv('DB_USER', 'MYSQLUSER') || urlUser || (isProduction ? undefined : 'root');
const password = pickEnv('DB_PASSWORD', 'MYSQLPASSWORD') || urlPassword || '';
const database = pickEnv('DB_NAME', 'MYSQLDATABASE') || urlDatabase || (isProduction ? undefined : 'mstvhrxe_tcdb');
const connectTimeout = Number(process.env.DB_CONNECT_TIMEOUT_MS || 10000);
const sslEnabled = String(process.env.DB_SSL || (urlSsl ? 'true' : 'false')).toLowerCase() === 'true';

if (!Number.isFinite(port) || port <= 0) {
  throw new Error('Invalid DB_PORT value. It must be a positive number.');
}

if (!Number.isFinite(connectTimeout) || connectTimeout <= 0) {
  throw new Error('Invalid DB_CONNECT_TIMEOUT_MS value. It must be a positive number.');
}

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
  connectTimeout,
  ssl: sslEnabled
    ? {
        rejectUnauthorized,
      }
    : undefined,
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0,
});

const getDbRuntimeConfig = () => ({
  host,
  port,
  database,
  ssl: sslEnabled,
  rejectUnauthorized,
  connectTimeout,
  source: connectionUrl ? 'url+env' : 'env',
});

const logDbConfigSummary = () => {
  const cfg = getDbRuntimeConfig();
  console.log(
    `[db] target=${cfg.host}:${cfg.port} database=${cfg.database} ssl=${cfg.ssl} timeoutMs=${cfg.connectTimeout} source=${cfg.source}`
  );
};

const testConnection = async () => {
  const connection = await pool.getConnection();
  try {
    await connection.ping();
  } finally {
    connection.release();
  }
};

module.exports = pool;
module.exports.getDbRuntimeConfig = getDbRuntimeConfig;
module.exports.logDbConfigSummary = logDbConfigSummary;
module.exports.testConnection = testConnection;
