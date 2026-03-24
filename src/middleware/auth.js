function requireAuth(req, res, next) {
  if (!req.session.user) {
    return res.redirect('/auth/login');
  }

  return next();
}

function requireAdmin(req, res, next) {
  if (!req.session.user || !req.session.user.isAdmin) {
    return res.redirect('/auth/login');
  }

  return next();
}

module.exports = {
  requireAuth,
  requireAdmin,
};
