# Timeless Collectibles - Deployment Checklist

## Pre-Deployment Setup

### 1. **InfinityFree Account Setup**
- [ ] Create InfinityFree account at https://infinityfree.com
- [ ] Verify email and activate account
- [ ] Choose domain name (e.g., timeless.infinityfreeapp.com)
- [ ] Access cpPanel control panel

### 2. **MySQL Database Setup**
- [ ] Log into cpPanel
- [ ] Create MySQL database:
  - [ ] Database name: `mstvhrxe_tcdb` (or similar)
  - [ ] Username: Create new (e.g., `timeless_user`)
  - [ ] Password: Create strong password
- [ ] Record credentials:
  ```
  Host: localhost
  Database: _________________
  Username: _________________
  Password: _________________
  ```

### 3. **Import Database SQL File**
- [ ] Open phpMyAdmin from cpPanel
- [ ] Select your database
- [ ] Go to Import tab
- [ ] Upload: `mstvhrxe_tcdb.sql`
- [ ] Click "Go" to import
- [ ] Verify tables created: cart_items, products, users, user_orders

### 4. **Update Configuration Files**

**Edit `config.php` with your credentials:**
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'timeless_user');        // Your username
define('DB_PASS', 'YourPassword123!');     // Your password
define('DB_NAME', 'mstvhrxe_tcdb');        // Your database name
define('SITE_URL', 'https://yoursite.infinityfreeapp.com/');
```

### 5. **Locate All Database Files to Update**
These files may have hardcoded database credentials - UPDATE THEM:
- [ ] `session.php`
- [ ] `login.php`
- [ ] `signup.php`
- [ ] `add_to_cart.php`
- [ ] `delete_from_cart.php`
- [ ] `user_order_process.php`
- [ ] `adminorders3.php`
- [ ] Any file connecting to database

**Replace hardcoded credentials with:**
```php
include 'config.php';  // Add this at top of each file
// Then use $conn variable
```

### 6. **Email Configuration (PHPMailer)**
- [ ] Update `mailer.php` with Gmail/email credentials
- [ ] If using Gmail:
  - [ ] Enable 2FA on Gmail account
  - [ ] Generate App Password from Google Account Security
  - [ ] Use App Password in `mailer.php`

### 7. **Upload Files to Hosting**
- [ ] Use File Manager in cpPanel OR
- [ ] Use FTP client (FileZilla):
  - [ ] Get FTP credentials from cpPanel
  - [ ] Upload all PHP files
  - [ ] Upload assets folder (CSS, JS, images)
  - [ ] Upload PHPMailer folder
  - [ ] Create/upload `uploads` folder for product images

### 8. **Set File Permissions**
- [ ] Set folders to 755 (if needed via FTP)
  - [ ] uploads/
  - [ ] assets/
- [ ] Set PHP files to 644 (if needed)

### 9. **Test Website**
- [ ] Visit your domain: `https://yoursite.infinityfreeapp.com`
- [ ] Test product pages (plushies, figurines, cards, cartridges)
- [ ] Test login with sample account:
  - Email: `paularceo21@gmail.com`
  - Password: `Paul9900!`
- [ ] Test shopping cart functionality
- [ ] Test admin panel login
- [ ] Test password reset email functionality

### 10. **Security Checks**
- [ ] Remove `ALLFunctions.txt` from server (not needed for production)
- [ ] Remove SQL dump file if uploaded (security risk)
- [ ] Update admin credentials (change from "Admin101")
- [ ] Remove sample user data from database (optional)
- [ ] Set up HTTPS (most hosting provides free SSL)

### 11. **Performance Optimization**
- [ ] Enable caching if available
- [ ] Optimize product images
- [ ] Minify CSS/JS files

---

## Database Credentials (Save Securely!)
```
Host: localhost
Database: _______________
Username: _______________
Password: _______________
FTP Host: _______________
FTP User: _______________
FTP Pass: _______________
Domain: _______________
```

---

## Support Resources
- InfinityFree Help: https://support.infinityfree.net/
- phpMyAdmin Guide: https://www.phpmyadmin.net/
- MySQL Basics: https://dev.mysql.com/doc/

## Quick Troubleshooting
| Error | Solution |
|-------|----------|
| "Connection failed" | Check DB_HOST, DB_USER, DB_PASS in config.php |
| "Table not found" | Re-import SQL file or check database name |
| "No such file" | Check file path in include/require statements |
| "Email not sending" | Verify SMTP credentials in mailer.php |

