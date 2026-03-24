const app = require('./app');
const { logDbConfigSummary, testConnection } = require('./config/db');

const port = Number(process.env.PORT || 3000);

app.listen(port, () => {
  console.log(`Timeless Collectibles app listening on port ${port}`);
  logDbConfigSummary();
  testConnection()
    .then(() => console.log('[db] startup ping successful'))
    .catch((error) => {
      console.error(`[db] startup ping failed: code=${error.code || 'UNKNOWN'} message=${error.message}`);
    });
});
