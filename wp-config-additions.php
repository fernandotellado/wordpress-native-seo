/**
 * SEO & GEO WORKSHOP — wp-config.php additions
 *
 * INSTRUCTIONS:
 * 1. Copy this entire block into your wp-config.php
 * 2. Place it BEFORE the line: "That's all, stop editing!"
 * 3. All constants are commented out by default
 */


// ============================================================
// REVISIONS — Limit to 5 per post (default: unlimited)
// Less revisions = cleaner database = faster queries
// ============================================================
// define( 'WP_POST_REVISIONS', 5 );


// ============================================================
// AUTOSAVE — Every 120 seconds instead of 60
// Reduces AJAX requests to the server
// ============================================================
// define( 'AUTOSAVE_INTERVAL', 120 );


// ============================================================
// TRASH — Empty after 15 days instead of 30
// Less accumulated content in the database
// ============================================================
// define( 'EMPTY_TRASH_DAYS', 15 );


// ============================================================
// FILE EDITOR — Disable code editor in admin panel
// Prevents direct PHP editing from the dashboard
// ============================================================
// define( 'DISALLOW_FILE_EDIT', true );


// ============================================================
// FORCE SSL — Always use HTTPS in admin area
// HTTPS is a confirmed ranking factor by Google
// ============================================================
// define( 'FORCE_SSL_ADMIN', true );


// ============================================================
// WP-CRON — Disable WordPress pseudo-cron
// WordPress cron runs on every page visit, affecting TTFB
// Replace with a real server cron pointing to wp-cron.php
// Replace with an alternate cron if hosting doesn't allow real cron jobs
// ============================================================
// define( 'DISABLE_WP_CRON', true );
// define( 'ALTERNATE_WP_CRON', true );


// ============================================================
// MEMORY — Increase PHP memory limits
// If server runs out of memory: 500 error, Google marks page as unavailable
// ============================================================
// define( 'WP_MEMORY_LIMIT', '256M' );
// define( 'WP_MAX_MEMORY_LIMIT', '512M' );


// ============================================================
// SCRIPT CONCATENATION — Combine and compress admin scripts
// Fewer HTTP requests in the admin panel
// ============================================================
// define( 'CONCATENATE_SCRIPTS', true );
// define( 'COMPRESS_SCRIPTS', true );
// define( 'COMPRESS_CSS', true );


// ============================================================
// DEBUG — ONLY for development, NEVER in production
// Exposes PHP errors that give info to attackers
// Can break visible HTML output
// ============================================================
// define( 'WP_DEBUG', true );
// define( 'WP_DEBUG_LOG', true );
// define( 'WP_DEBUG_DISPLAY', false );
