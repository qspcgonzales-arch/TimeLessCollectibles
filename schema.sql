-- Timeless Collectibles PostgreSQL Schema

-- Create tables

CREATE TABLE IF NOT EXISTS users (
  id SERIAL PRIMARY KEY,
  email VARCHAR(300) UNIQUE NOT NULL,
  password VARCHAR(300) NOT NULL,
  address VARCHAR(300),
  country VARCHAR(300),
  reset_token_hash VARCHAR(64) UNIQUE,
  reset_token_expires_at TIMESTAMP,
  "2FA_Pin" VARCHAR(6),
  "2FA_Expire" TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
  id VARCHAR(36) PRIMARY KEY,
  prodname VARCHAR(500) NOT NULL,
  prodcategory VARCHAR(500) NOT NULL,
  description VARCHAR(500),
  image VARCHAR(500),
  price INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS cart_items (
  id SERIAL PRIMARY KEY,
  user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
  product_id VARCHAR(36) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS user_orders (
  "OrderID" SERIAL PRIMARY KEY,
  "UserID" INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  "ProductID" VARCHAR(36) NOT NULL REFERENCES products(id),
  quantity INTEGER NOT NULL,
  pending BOOLEAN DEFAULT FALSE,
  delivering BOOLEAN DEFAULT FALSE,
  delivered BOOLEAN DEFAULT FALSE
);

-- Create indexes

CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);
CREATE INDEX IF NOT EXISTS idx_users_reset_token ON users(reset_token_hash);
CREATE INDEX IF NOT EXISTS idx_cart_items_user_id ON cart_items(user_id);
CREATE INDEX IF NOT EXISTS idx_cart_items_product_id ON cart_items(product_id);
CREATE INDEX IF NOT EXISTS idx_products_category ON products(prodcategory);
CREATE INDEX IF NOT EXISTS idx_user_orders_user_id ON user_orders("UserID");
CREATE INDEX IF NOT EXISTS idx_user_orders_product_id ON user_orders("ProductID");
