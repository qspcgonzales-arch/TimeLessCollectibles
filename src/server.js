const app = require('./app');
const { logDbConfigSummary } = require('./config/db');

const port = Number(process.env.PORT || 3000);

try {
  app.listen(port, () => {
    console.log(`Timeless Collectibles app listening on port ${port}`);
    logDbConfigSummary();
    console.log('[db] Connection pool initialized (not pinging on startup to avoid stack overflow)');
  });
} catch (error) {
  console.error('Failed to start server:', error.message);
  process.exit(1);
}
