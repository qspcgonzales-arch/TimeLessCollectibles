const { Pool } = require('pg');
const dotenv = require('dotenv');

dotenv.config();

const isProduction = process.env.NODE_ENV === 'production';

const databaseUrl = process.env.DATABASE_URL || 'postgresql://postgres:postgres@localhost:5432/mstvhrxe_tcdb';

if (isProduction && !process.env.DATABASE_URL) {
  throw new Error('DATABASE_URL environment variable is required in production.');
}

const poolConfig = {
  connectionString: databaseUrl,
  ssl: isProduction
    ? {
        rejectUnauthorized: false,
      }
    : undefined,
};

const pool = new Pool(poolConfig);

pool.on('error', (error) => {
  console.error('[db] Unexpected error on idle client:', error);
});

const getDbRuntimeConfig = () => {
  try {
    const url = new URL(databaseUrl);
    return {
      host: url.hostname,
      port: url.port || 5432,
      database: url.pathname.replace(/^\//, ''),
      user: url.username,
      ssl: isProduction,
    };
  } catch (e) {
    return { connectionString: databaseUrl, ssl: isProduction };
  }
};

const logDbConfigSummary = () => {
  const cfg = getDbRuntimeConfig();
  if (cfg.host) {
    console.log(
      `[db] target=${cfg.host}:${cfg.port} database=${cfg.database} user=${cfg.user} ssl=${cfg.ssl}`
    );
  } else {
    console.log(`[db] using DATABASE_URL connection`);
  }
};

const testConnection = async () => {
  const client = await pool.connect();
  try {
    await client.query('SELECT 1 AS ok');
  } finally {
    client.release();
  }
};

module.exports = pool;
module.exports.getDbRuntimeConfig = getDbRuntimeConfig;
module.exports.logDbConfigSummary = logDbConfigSummary;
module.exports.testConnection = testConnection;
