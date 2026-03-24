const crypto = require('crypto');
const express = require('express');
const bcrypt = require('bcryptjs');
const pool = require('../config/db');
const createMailer = require('../config/mailer');
const { setFlash } = require('../middleware/flash');

const router = express.Router();

async function verifyStoredPassword(plainPassword, storedPassword) {
  if (!storedPassword) {
    return false;
  }

  if (storedPassword.startsWith('$2')) {
    return bcrypt.compare(plainPassword, storedPassword);
  }

  return plainPassword === storedPassword;
}

function getMissingSmtpFields() {
  const required = ['SMTP_HOST', 'SMTP_USER', 'SMTP_PASS'];
  return required.filter((key) => !process.env[key] || !String(process.env[key]).trim());
}

router.get('/login', (req, res) => {
  res.render('auth/login', { title: 'Login' });
});

router.post('/login', async (req, res, next) => {
  try {
    const { email, password } = req.body;

    if (!email || !password) {
      setFlash(req, 'error', 'Email and password are required.');
      return res.redirect('/auth/login');
    }

    if (
      email === process.env.ADMIN_EMAIL &&
      password === process.env.ADMIN_PASSWORD
    ) {
      req.session.user = {
        email,
        isAdmin: true,
      };
      setFlash(req, 'success', 'Admin login successful.');
      return res.redirect('/admin');
    }

    const result = await pool.query('SELECT * FROM users WHERE email = $1', [email]);
    const user = result.rows[0];
    if (!user || !(await verifyStoredPassword(password, user.password))) {
      setFlash(req, 'error', 'Invalid email or password.');
      return res.redirect('/auth/login');
    }

    if (!user.password.startsWith('$2')) {
      const upgradedHash = await bcrypt.hash(password, 12);
      await pool.query('UPDATE users SET password = $1 WHERE id = $2', [upgradedHash, user.id]);
    }

    req.session.user = {
      id: user.id,
      email: user.email,
      address: user.address,
      country: user.country,
      isAdmin: false,
    };
    req.session.pending2FA = null;
    req.session.dev2FAPin = null;

    setFlash(req, 'success', 'Login successful.');

    return res.redirect('/');
  } catch (error) {
    return next(error);
  }
});

router.get('/signup', (req, res) => {
  res.render('auth/signup', { title: 'Sign Up' });
});

router.post('/signup', async (req, res, next) => {
  try {
    const { email, password, confirmPassword, address, country } = req.body;

    if (!email || !password || !confirmPassword || !address || !country) {
      setFlash(req, 'error', 'All fields are required.');
      return res.redirect('/auth/signup');
    }

    if (password !== confirmPassword) {
      setFlash(req, 'error', 'Passwords do not match.');
      return res.redirect('/auth/signup');
    }

    const result = await pool.query('SELECT id FROM users WHERE email = $1', [email]);
    const existingUser = result.rows[0];
    if (existingUser) {
      setFlash(req, 'error', 'That email address is already registered.');
      return res.redirect('/auth/signup');
    }

    const passwordHash = await bcrypt.hash(password, 12);
    await pool.query(
      'INSERT INTO users (email, password, address, country) VALUES ($1, $2, $3, $4)',
      [email, passwordHash, address, country]
    );

    setFlash(req, 'success', 'Account created. You can log in now.');
    return res.redirect('/auth/login');
  } catch (error) {
    return next(error);
  }
});

router.get('/verify-2fa', (req, res) => {
  setFlash(req, 'error', '2FA page is disabled in simplified auth mode.');
  return res.redirect('/auth/login');
});

router.post('/verify-2fa', async (req, res, next) => {
  setFlash(req, 'error', '2FA verification is disabled in simplified auth mode.');
  return res.redirect('/auth/login');
});

router.get('/forgot-password', (req, res) => {
  res.render('auth/forgot-password', { title: 'Forgot Password' });
});

router.post('/forgot-password', async (req, res, next) => {
  try {
    const { email } = req.body;
    if (!email) {
      setFlash(req, 'error', 'Email is required.');
      return res.redirect('/auth/forgot-password');
    }

    const result = await pool.query('SELECT id, email FROM users WHERE email = $1', [email]);
    const user = result.rows[0];
    if (!user) {
      setFlash(req, 'success', 'If that account exists, a reset link has been prepared.');
      return res.redirect('/auth/forgot-password');
    }

    const token = crypto.randomBytes(32).toString('hex');
    const tokenHash = crypto.createHash('sha256').update(token).digest('hex');
    const expiry = new Date(Date.now() + 30 * 60 * 1000);

    await pool.query(
      'UPDATE users SET reset_token_hash = $1, reset_token_expires_at = $2 WHERE id = $3',
      [tokenHash, expiry, user.id]
    );

    const resetLink = `${process.env.APP_URL || 'http://localhost:3000'}/auth/reset-password?token=${token}`;
    const missingSmtpFields = getMissingSmtpFields();
    if (missingSmtpFields.length) {
      setFlash(
        req,
        'error',
        `Password reset email is not configured. Missing: ${missingSmtpFields.join(', ')}.`
      );
      return res.redirect('/auth/forgot-password');
    }

    const mailer = createMailer();
    if (mailer) {
      await mailer.sendMail({
        from: process.env.MAIL_FROM || process.env.SMTP_USER,
        to: user.email,
        subject: 'Reset your Timeless Collectibles password',
        html: `<p>Use the link below to reset your password.</p><p><a href="${resetLink}">${resetLink}</a></p>`,
      });
    } else {
      setFlash(req, 'error', 'Password reset email sender initialization failed. Check .env SMTP values and restart the app.');
      return res.redirect('/auth/forgot-password');
    }

    setFlash(req, 'success', 'Reset link sent to your email.');
    return res.redirect('/auth/forgot-password');
  } catch (error) {
    return next(error);
  }
});

router.get('/reset-password', (req, res) => {
  if (!req.query.token) {
    setFlash(req, 'error', 'Missing reset token.');
    return res.redirect('/auth/forgot-password');
  }

  return res.render('auth/reset-password', { title: 'Reset Password', token: req.query.token });
});

router.post('/reset-password', async (req, res, next) => {
  try {
    const { token, password, confirmPassword } = req.body;

    if (!token || !password || !confirmPassword) {
      setFlash(req, 'error', 'All fields are required.');
      return res.redirect(`/auth/reset-password?token=${encodeURIComponent(token || '')}`);
    }

    if (password !== confirmPassword) {
      setFlash(req, 'error', 'Passwords do not match.');
      return res.redirect(`/auth/reset-password?token=${encodeURIComponent(token)}`);
    }

    const tokenHash = crypto.createHash('sha256').update(token).digest('hex');
    const result = await pool.query(
      'SELECT id, reset_token_expires_at FROM users WHERE reset_token_hash = $1',
      [tokenHash]
    );
    const user = result.rows[0];

    if (!user || !user.reset_token_expires_at || new Date(user.reset_token_expires_at).getTime() < Date.now()) {
      setFlash(req, 'error', 'Reset link is invalid or expired.');
      return res.redirect('/auth/forgot-password');
    }

    const passwordHash = await bcrypt.hash(password, 12);
    await pool.query(
      'UPDATE users SET password = $1, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = $2',
      [passwordHash, user.id]
    );

    setFlash(req, 'success', 'Password updated. You can log in now.');
    return res.redirect('/auth/login');
  } catch (error) {
    return next(error);
  }
});

router.post('/logout', (req, res) => {
  req.session.destroy(() => {
    res.redirect('/auth/login');
  });
});

module.exports = router;
