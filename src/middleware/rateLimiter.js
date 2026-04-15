const MAX_ATTEMPTS = 3;
const LOCKOUT_MS = 30 * 1000; // 30 seconds

// ip -> { count, lockedUntil }
const store = new Map();

function isLocked(ip) {
  const record = store.get(ip);
  if (!record || !record.lockedUntil) return false;
  if (Date.now() < record.lockedUntil) return true;
  // Lock expired — clean up
  store.delete(ip);
  return false;
}

function timeRemaining(ip) {
  const record = store.get(ip);
  if (!record || !record.lockedUntil) return '0 seconds';
  const ms = record.lockedUntil - Date.now();
  if (ms <= 0) return '0 seconds';
  const secs = Math.ceil(ms / 1000);
  return secs < 60 ? `${secs} second(s)` : `${Math.ceil(secs / 60)} minute(s)`;
}

function recordFailure(ip) {
  const record = store.get(ip) || { count: 0, lockedUntil: null };
  record.count += 1;
  if (record.count >= MAX_ATTEMPTS) {
    record.lockedUntil = Date.now() + LOCKOUT_MS;
    record.count = 0;
  }
  store.set(ip, record);
}

function clearFailures(ip) {
  store.delete(ip);
}

module.exports = { isLocked, timeRemaining, recordFailure, clearFailures };
