const app = require('./app');

const port = Number(process.env.PORT || 3000);

app.listen(port, () => {
  console.log(`Timeless Collectibles app listening on port ${port}`);
});
