# Wordpress Starter Kit

A starter kit for Wordpress projects.

## Install

Plugins:

- Advanced Custom Fields Pro
- Relevanssi - Add search logging excluding master
- Yoast SEO - Import settings or setup as per http://onlinemediamasters.com/yoast-wordpress-seo-tutorial/
- iThemes Security
- CMS Tree Page View
- Gravity Forms
- Velvet Blues Update URLs

Permalinks:

- Custom Structure - `/articles/%postname%/`
- Category base - archives
- Tag base - tags

wp-config:

- Revisions - `define('WP_POST_REVISIONS', 5);`
- Disable Editor - `define('DISALLOW_FILE_EDIT', true);`

After Launch:

- Turn on Relevanssi search logging
- robots.txt
- Add custom fields to index in Relevanssi
- Turn on backups in iThemes Security
- Check iThemes Security settings
- Add Google Analytics
- Update URLs
- Webmaster tools linked to Yoast SEO
- Submit XML sitemap
- Add minify plugin
- Update robots.txt sitemap URL
- Turn off WP_DEBUG mode

Known Issues:

- Gravity forms causes jQuery to load in `<head>` rather than the footer. Most likely done to not break conditional form statements.

TODO:

- Refactor Core Wordpress CSS styles
- Refactor print styles
- Refactor Helpers
- Add accordion and tab bar default JS + CSS (Shortcode)
- Clean up form styles and js