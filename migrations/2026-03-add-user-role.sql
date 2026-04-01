-- Add 'role' column to users table if it doesn't exist
ALTER TABLE users ADD COLUMN IF NOT EXISTS role VARCHAR(20) NOT NULL DEFAULT 'user';

-- Example: Set a user as staff (replace with actual user id or email)
-- UPDATE users SET role = 'staff' WHERE email = 'staffuser@example.com';

-- Example: Set a user as admin
-- UPDATE users SET role = 'admin' WHERE email = 'adminuser@example.com';
