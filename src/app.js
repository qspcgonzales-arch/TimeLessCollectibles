const path = require('path');
const express = require('express');
const session = require('express-session');
const methodOverride = require('method-override');
const dotenv = require('dotenv');

const { flashMiddleware } = require('./middleware/flash');
const mainRoutes = require('./routes');

dotenv.config();

const app = express();

// Needed behind reverse proxies on cloud hosts when secure cookies are enabled.
app.set('trust proxy', 1);

app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

app.use(express.urlencoded({ extended: true }));
app.use(express.json());
<<<<<<< Updated upstream
=======
// app.use(sanitizeInputs); // DEMO: disabled to show vulnerable state
>>>>>>> Stashed changes
app.use(methodOverride('_method'));
app.use(session({
  secret: process.env.SESSION_SECRET || 'change-me',
  resave: false,
  saveUninitialized: false,
  cookie: {
    httpOnly: true,
    sameSite: 'lax',
    secure: process.env.NODE_ENV === 'production',
    maxAge: 1000 * 60 * 60 * 2,
  },
}));
app.use(flashMiddleware);
app.use((req, res, next) => {
  res.locals.currentUser = req.session.user || null;
  res.locals.appUrl = process.env.APP_URL || 'http://localhost:3000';
  res.locals.paypalClientId = process.env.PAYPAL_CLIENT_ID || '';
  next();
});
app.use('/static', express.static(path.join(__dirname, 'public')));

app.get('/health', (req, res) => {
  res.status(200).json({ status: 'ok' });
});

app.use(mainRoutes);

app.use((err, req, res, next) => {
  console.error(err);
  res.status(500).render('error', { title: 'Server Error', error: err });
});

module.exports = app;
