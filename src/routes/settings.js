const express = require('express');
const bcrypt = require('bcryptjs');
const pool = require('../config/db');
const { requireAuth } = require('../middleware/auth');
const { setFlash } = require('../middleware/flash');

const router = express.Router();

router.get('/', requireAuth, async (req, res, next) => {
  try {
    const [[user]] = await pool.query(
      'SELECT id, email, address, country FROM users WHERE id = ?',
      [req.session.user.id]
    );

    req.session.user = { ...req.session.user, ...user };

    res.render('settings/index', {
      title: 'Settings',
      profile: user,
    });
  } catch (error) {
    next(error);
  }
});

router.post('/address', requireAuth, async (req, res, next) => {
  try {
    const { address, country } = req.body;
    await pool.query('UPDATE users SET address = ?, country = ? WHERE id = ?', [
      address,
      country,
      req.session.user.id,
    ]);

    req.session.user.address = address;
    req.session.user.country = country;
    setFlash(req, 'success', 'Address updated.');
    return res.redirect('/settings');
  } catch (error) {
    return next(error);
  }
});

router.post('/password', requireAuth, async (req, res, next) => {
  try {
    const { currentPassword, newPassword, confirmPassword } = req.body;
    const [[user]] = await pool.query('SELECT password FROM users WHERE id = ?', [req.session.user.id]);

    const currentMatches = user.password.startsWith('$2')
      ? await bcrypt.compare(currentPassword, user.password)
      : currentPassword === user.password;

    if (!currentMatches) {
      setFlash(req, 'error', 'Current password is incorrect.');
      return res.redirect('/settings');
    }

    if (!newPassword || newPassword !== confirmPassword) {
      setFlash(req, 'error', 'New password confirmation does not match.');
      return res.redirect('/settings');
    }

    const passwordHash = await bcrypt.hash(newPassword, 12);
    await pool.query('UPDATE users SET password = ? WHERE id = ?', [passwordHash, req.session.user.id]);

    setFlash(req, 'success', 'Password updated.');
    return res.redirect('/settings');
  } catch (error) {
    return next(error);
  }
});

module.exports = router;
