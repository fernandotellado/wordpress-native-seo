# WordPress native SEO & GEO snippets

A collection of PHP snippets to handle SEO and GEO in WordPress without any SEO plugin. Each snippet uses native WordPress filters and actions — no third-party dependencies.

Based on the workshop ["Do you really need an SEO/GEO plugin for WordPress?"](https://europe.wordcamp.org/2026/session/do-you-really-need-an-seo-geo-plugin-for-wordpress/) at WordCamp Europe 2026 in Kraków.

## Two ways to use these snippets

### Option 1: Individual snippets

Pick only what you need. Each file is self-contained and can be added to your theme's `functions.php` or placed as a standalone mu-plugin in `wp-content/mu-plugins/`.

| File | What it does |
|---|---|
| `auto-meta-description.php` | Generates `<meta name="description">` from native WordPress fields: tagline (homepage), excerpt (posts/pages), term description (archives), bio (authors) |
| `clean-head.php` | Removes generator version, WLW manifest, RSD, shortlinks, REST API link, comment feeds, prev/next links from `<head>` |
| `disable-emojis.php` | Removes the emoji detection script and styles loaded on every page |
| `remove-query-strings.php` | Strips `?ver=` from CSS and JS URLs for better CDN caching |
| `disable-embeds.php` | Removes oEmbed REST route, discovery links, and host JavaScript |
| `restrict-rest-api.php` | Limits REST API access to authenticated users only |
| `customize-sitemap.php` | Removes tags, author archives (and optionally pages) from the native XML sitemap |
| `block-ai-training-bots.php` | Adds rules to the virtual robots.txt to block AI training crawlers (GPTBot, ClaudeBot, Google-Extended, CCBot, Bytespider) |
| `handle-low-value-archives.php` | Redirects author and date archives to homepage, adds noindex to search results and thin taxonomy archives |
| `small-seo-tweaks.php` | Enables excerpts on pages, disables self-pingbacks, sets a generic login error message |
| `open-graph-tags.php` | Generates Open Graph and Twitter Card meta tags from title, excerpt, and featured image |

### Option 2: All-in-one mu-plugin

Drop `ayudawp-seo-geo-tweaks.php` into `wp-content/mu-plugins/` and you get everything in a single file. Comment out any section you don't need.

This file includes all 14 optimizations organized in clear sections:

1. Head cleanup
2. Disable emojis
3. Remove query strings
4. Disable oEmbed/Embeds
5. Restrict REST API
6. Sitemap customization
7. Block AI training bots (robots.txt)
8. Auto meta description (all page types)
9. Open Graph and Twitter Card tags
10. Enable excerpts on pages
11. Disable self-pingbacks
12. Redirect low-value archives
13. Noindex rules (search, thin archives)
14. Generic login error message

## Installation

### As mu-plugin (recommended)

1. Create the folder `wp-content/mu-plugins/` if it doesn't exist
2. Copy `ayudawp-seo-geo-tweaks.php` (or individual snippet files) into it
3. Done — mu-plugins load automatically, no activation needed

### In functions.php

Copy the code from any snippet file into your **child theme's** `functions.php`. Don't edit the parent theme directly — updates will overwrite your changes.

## Requirements

- WordPress 5.5 or higher (for native sitemap support)
- PHP 7.4 or higher

## What about wp-config.php?

These snippets handle the PHP/filter side. For `wp-config.php` constants (revisions, autosave, trash, memory, cron, SSL, debug) and `.htaccess` rules (GZIP, caching, security headers), check the [complete reference guide](https://github.com/fernandotellado/wordpress-native-seo-geo).

## The meta description snippet explained

The `auto-meta-description.php` snippet deserves special attention. It replaces the core function of an SEO plugin — meta descriptions — with a single hook and zero configuration:

| Page type | Source field |
|---|---|
| Homepage | Tagline from Settings → General |
| Posts and pages | Manual excerpt, or trimmed content if no excerpt exists |
| Category/Tag/Custom taxonomy archives | Term description field |
| Author archives | Biographical info from user profile |

The only requirement: fill in the fields that WordPress already provides. If your tagline says "Just another WordPress site", that's your meta description. If your category has no description, it won't generate one. The snippet uses what you give it.

## Going further: plugins for the gaps

These snippets cover a lot, but there are things WordPress can't do natively. For those gaps, these free plugins complement the snippets:

| Gap | Plugin |
|---|---|
| Selective noindex per post/taxonomy/archive | [NoIndexer](https://wordpress.org/plugins/noindexer/) |
| Sitemap control without code | [Native Sitemap Customizer](https://wordpress.org/plugins/native-sitemap-customizer/) |
| Full Open Graph with edge cases | [Open Graph Tags](https://github.com/fernandotellado/open-graph-tags-wordpress) |
| Performance cleanup (zero config) | [WPO Tweaks](https://wordpress.org/plugins/wpo-tweaks/) |
| Cron/scheduled actions cleanup | [Easy Actions Scheduler Cleaner](https://wordpress.org/plugins/easy-actions-scheduler-cleaner-ayudawp/) |
| JSON-LD, llms.txt, Markdown for AI, bot analytics | [VigIA](https://wordpress.org/plugins/vigia/) |
| AI content signals, physical robots.txt | [AI Content Signals](https://wordpress.org/plugins/ai-content-signals/) |
| Share content with AI platforms | [AI Share & Summarize](https://wordpress.org/plugins/ai-share-summarize/) |

## License

GPL-2.0-or-later. Use, modify, and share freely.

## Author

[Fernando Tellado](https://ayudawp.com) — WordPress specialist since 2005.
