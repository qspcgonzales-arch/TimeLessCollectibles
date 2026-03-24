const app = require('./app');
const { logDbConfigSummary } = require('./config/db');
const { initializeDatabase } = require('./config/bootstrap');

const port = Number(process.env.PORT || 3000);

async function startServer() {
  try {
    logDbConfigSummary();
    await initializeDatabase();

    app.listen(port, () => {
      console.log(`Timeless Collectibles app listening on port ${port}`);
    });
  } catch (error) {
    console.error('Failed to start server:', error);
    process.exit(1);
  }
}

startServer();
