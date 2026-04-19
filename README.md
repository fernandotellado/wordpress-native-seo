# WordPress native SEO and GEO — no plugins required

A complete collection of code snippets, constants, and server rules to handle SEO and GEO (Generative Engine Optimization) in WordPress without relying on SEO plugins.

Everything here uses native WordPress filters, actions, `wp-config.php` constants, and `.htaccess` rules. No third-party dependencies.

Based on the workshop ["Do you really need an SEO/GEO plugin for WordPress?"](https://europe.wordcamp.org/2026/session/do-you-really-need-an-seo-geo-plugin-for-wordpress/) by [Fernando Tellado](https://ayudawp.com) at WordCamp Europe 2026 in Kraków.

---

## Repository files

### All-in-one mu-plugin

| File | Description |
|---|---|
| [`ayudawp-seo-geo-tweaks.php`](ayudawp-seo-geo-tweaks.php) | All 14 PHP optimizations in a single file, active and ready for production. Drop it in `wp-content/mu-plugins/` and it works. Comment out any section you don't need. |

### Individual PHP snippets

Pick only what you need. Each file is self-contained and can be used as a standalone mu-plugin or added to your child theme's `functions.php`.

| File | What it does |
|---|---|
| [`auto-meta-description.php`](auto-meta-description.php) | Generates `<meta name="description">` from 4 native WordPress fields: tagline (homepage), excerpt (posts/pages), term description (archives), bio (authors) |
| [`clean-head.php`](clean-head.php) | Removes generator version, WLW manifest, RSD, shortlinks, REST API link, comment feeds, and prev/next links from `<head>` |
| [`disable-emojis.php`](disable-emojis.php) | Removes the emoji detection script and styles loaded on every page |
| [`disable-embeds.php`](disable-embeds.php) | Removes oEmbed REST route, discovery links, and host JavaScript |
| [`remove-query-strings.php`](remove-query-strings.php) | Strips `?ver=` from CSS and JS URLs for better CDN and proxy caching |
| [`restrict-rest-api.php`](restrict-rest-api.php) | Limits REST API access to authenticated users only — prevents public exposure of usernames and site data |
| [`customize-sitemap.php`](customize-sitemap.php) | Removes tags and author archives from the native WordPress XML sitemap |
| [`block-ai-training-bots.php`](block-ai-training-bots.php) | Adds rules to the virtual `robots.txt` to block AI training crawlers (GPTBot, ClaudeBot, Google-Extended, CCBot, Bytespider) while keeping search bots allowed |
| [`handle-low-value-archives.php`](handle-low-value-archives.php) | Redirects author and date archives to homepage (301), adds `noindex` to search results and thin taxonomy archives |
| [`small-seo-tweaks.php`](small-seo-tweaks.php) | Enables excerpts on pages, disables self-pingbacks, sets a generic login error message |
| [`open-graph-tags.php`](open-graph-tags.php) | Generates Open Graph (`og:title`, `og:description`, `og:image`, `og:url`) and Twitter Card tags from standard WordPress fields |

### Configuration reference files

These files contain constants and rules you copy into your existing WordPress configuration files. Everything is commented out — uncomment what you need.

| File | What it is | Where to use it |
|---|---|---|
| [`wp-config-additions.php`](wp-config-additions.php) | 10 constants: revisions, autosave, trash, file editor, SSL, WP-Cron, memory, script compression, debug | Copy contents into your `wp-config.php` before the line `/* That's all, stop editing! */` |
| [`htaccess-additions.txt`](htaccess-additions.txt) | 8 rule blocks: force HTTPS, GZIP compression, browser cache, protect wp-config.php, disable directory listing, block xmlrpc.php, block author scanning, security headers | Copy contents into your `.htaccess` after `# END WordPress`. Requires Apache with `mod_rewrite`, `mod_deflate`, `mod_expires`, `mod_headers`. |

---

## Installation

### Option 1: All-in-one mu-plugin (recommended)

1. Create the folder `wp-content/mu-plugins/` if it doesn't exist
2. Download [`ayudawp-seo-geo-tweaks.php`](ayudawp-seo-geo-tweaks.php) and place it there
3. Done — mu-plugins load automatically, no activation required
4. Open the file and comment out any section you don't need

### Option 2: Individual snippets

1. Download only the snippet files you need
2. Place them in `wp-content/mu-plugins/` (each file works independently)
3. Or copy the code into your **child theme's** `functions.php`

### wp-config.php constants

1. Open [`wp-config-additions.php`](wp-config-additions.php) and copy the constants you want
2. Paste them into your `wp-config.php` before the line that says `/* That's all, stop editing! */`
3. Uncomment each constant you want to activate

### .htaccess rules

1. Open [`htaccess-additions.txt`](htaccess-additions.txt) and copy the rule blocks you want
2. Paste them into your `.htaccess` **after** the `# END WordPress` block
3. Uncomment the rules you want to activate
4. These require Apache — they won't work on Nginx or on some local development environments

---

## The meta description snippet explained

The [`auto-meta-description.php`](auto-meta-description.php) snippet deserves special attention. It replaces the core function of most SEO plugins — meta descriptions — with a single WordPress hook:

| Page type | Source field | Where to edit it |
|---|---|---|
| Homepage | Tagline | Settings → General → Tagline |
| Posts and pages | Excerpt (or trimmed content) | Post sidebar → Excerpt |
| Category / Tag archives | Term description | Categories → Edit → Description |
| Author archives | Biographical info | Users → Profile → Biographical Info |

If a field is empty, no meta tag is generated for that page. The only requirement is filling in the fields that WordPress already provides.

---

## What these snippets cover

### Performance
- Remove emoji scripts and styles from every page
- Strip query strings from static resources for better caching
- Disable oEmbed scripts and REST routes
- Clean unnecessary tags from `<head>`
- Limit post revisions, autosave frequency, trash retention (wp-config.php)
- GZIP compression and browser cache rules (.htaccess)

### SEO
- Auto meta descriptions from native WordPress fields
- Open Graph and Twitter Card tags from title, excerpt, and featured image
- Customize the native XML sitemap (exclude tags, authors, pages)
- Redirect low-value archives (author, date) to homepage
- Add `noindex` to search results and thin taxonomy archives
- Clean permalink structure

### GEO (Generative Engine Optimization)
- Block AI training bots while keeping search and citation bots allowed
- Configure the virtual `robots.txt` for AI crawler management

### Security
- Restrict REST API to authenticated users
- Disable the file editor in admin
- Block `xmlrpc.php` and author scanning (.htaccess)
- Generic login error messages
- Security headers (.htaccess)
- Protect `wp-config.php` from direct access (.htaccess)

---

## Going further: plugins for the gaps

These snippets cover the code side, but there are things that benefit from a proper plugin with UI, ongoing updates, and deeper integration. All free:

### SEO
| Plugin | What it does |
|---|---|
| [NoIndexer](https://wordpress.org/plugins/noindexer/) | Selective `noindex` per post type, taxonomy, individual post, special pages, and feeds — with editor integration, Quick Edit, bulk actions, and automatic sitemap exclusion |
| [Native Sitemap Customizer](https://wordpress.org/plugins/native-sitemap-customizer/) | Visual control over the native WordPress XML sitemap |
| [Open Graph Tags](https://github.com/fernandotellado/open-graph-tags-wordpress) | Full Open Graph and Twitter Card implementation with edge cases |
| [SEO Read More Buttons](https://wordpress.org/plugins/seo-read-more-buttons-ayudawp/) | Control "Read More" button text and style in archives |

### Performance
| Plugin | What it does |
|---|---|
| [WPO Tweaks](https://wordpress.org/plugins/wpo-tweaks/) | All performance optimizations in this repo + critical CSS, deferred CSS, preconnect, lazy loading, database cleanup — zero configuration |
| [Easy Actions Scheduler Cleaner](https://wordpress.org/plugins/easy-actions-scheduler-cleaner-ayudawp/) | Clean up orphan scheduled tasks left by uninstalled plugins |

### GEO (Generative Engine Optimization)
| Plugin | What it does |
|---|---|
| [VigIA](https://wordpress.org/plugins/vigia/) | JSON-LD structured data, `llms.txt` generation, Markdown for AI agents, AI crawler analytics and blocking |
| [AI Content Signals](https://wordpress.org/plugins/ai-content-signals/) | Cloudflare's AI content signals standard, physical `robots.txt` with visual AI bot control |
| [AI Share & Summarize](https://wordpress.org/plugins/ai-share-summarize/) | Share buttons for AI platforms (ChatGPT, Claude, Perplexity...) that include your URL as source |

### WordPress 7 native AI
| Plugin | What it does |
|---|---|
| [AI Experiments](https://wordpress.org/plugins/ai/) | Official WordPress plugin: AI-powered alt text, excerpts, titles, content review with SEO suggestions |
| [AI Provider for OpenAI](https://wordpress.org/plugins/ai-provider-for-openai/) | OpenAI connector for WordPress AI infrastructure |
| [AI Provider for Anthropic](https://wordpress.org/plugins/ai-provider-for-anthropic/) | Anthropic/Claude connector for WordPress AI infrastructure |

### Security
| Plugin | What it does |
|---|---|
| [Vigilante](https://wordpress.org/plugins/vigilante/) | Basic security hardening |

---

## Requirements

- WordPress 5.5 or higher (for native sitemap support)
- PHP 7.4 or higher
- Apache with `mod_rewrite`, `mod_deflate`, `mod_expires`, `mod_headers` (for `.htaccess` rules only)

---

## Further reading

- [How to rank in Google AI Overviews](https://ayudawp.com/ai-overviews-google/)
- [SEO and AI: everything you need to know](https://ayudawp.com/seo-ia/)
- [Google's "Great Decoupling"](https://ayudawp.com/gran-desacoplamiento-google/)
- [llms.txt and llms-full.txt explained](https://ayudawp.com/llms-txt-llms-full-txt/)
- [Markdown for AI agents](https://ayudawp.com/markdown-agentes-ia/)
- [JSON-LD in WordPress](https://ayudawp.com/json-ld/)
- [Understanding TTFB](https://ayudawp.com/ttfb/)
- [The wp-config.php file: complete guide](https://ayudawp.com/wpconfig/)

---

## License

GPL-2.0-or-later. Use, modify, and share freely.

## Author

[Fernando Tellado](https://ayudawp.com) — WordPress specialist since 2005.

[AyudaWP.com](https://ayudawp.com) · [@fernandot](https://x.com/fernandot) · [YouTube](https://www.youtube.com/AyudaWordPressES)
