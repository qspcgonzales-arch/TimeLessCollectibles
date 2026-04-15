const EMAIL_REGEX = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
// Characters that have no place in non-password text fields
const DANGEROUS_CHARS = /[<>"'`;]/g;

function sanitizeInputs(req, res, next) {
  if (!req.body || typeof req.body !== 'object') return next();

  for (const key of Object.keys(req.body)) {
    if (typeof req.body[key] !== 'string') continue;

    // Trim all string inputs
    req.body[key] = req.body[key].trim();

    // Strip dangerous chars from non-password fields
    if (key !== 'password' && key !== 'confirmPassword' && key !== 'newPassword') {
      req.body[key] = req.body[key].replace(DANGEROUS_CHARS, '');
    }
  }

  // Reject malformed email early
  if (req.body.email !== undefined && req.body.email !== '') {
    if (!EMAIL_REGEX.test(req.body.email)) {
      const { setFlash } = require('./flash');
      setFlash(req, 'error', 'Please enter a valid email address.');
      return res.redirect('back');
    }
  }

  next();
}

module.exports = sanitizeInputs;
