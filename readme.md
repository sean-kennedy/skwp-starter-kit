# Wordpress Starter Kit

A starter kit for Wordpress projects.

## Install

Update wp-config:

Revisions, Disable Editor

```
define('WP_POST_REVISIONS', 5);
define('DISALLOW_FILE_EDIT', true);
define('FS_METHOD', 'direct');
```
Install Plugins:

- Advanced Custom Fields Pro
- ACF-Content Analysis for Yoast SEO
- Advanced Custom Fields: Link Picker
- Autoptimize (minification)
- CMS Tree Page View
- Disable Comments
- Gravity Forms
- iThemes Security
- Optimize Database after Deleting Revisions
- Relevanssi - Add search logging excluding master
- RICG Responsive Images
- SO Hide SEO Bloat
- Velvet Blues Update URLs
- Yoast SEO - Import settings or setup as per http://onlinemediamasters.com/yoast-wordpress-seo-tutorial/

After Launch:

- Turn on Relevanssi search logging
- Add custom fields to index in Relevanssi
- Turn on backups in iThemes Security
- Check iThemes Security settings
- Add Google Analytics
- Update URLs
- Webmaster tools linked to Yoast SEO
- Submit XML sitemap
- Update robots.txt sitemap URL
- Turn off WP_DEBUG mode
- Add favicon.ico
- Check Gravity Forms send fields and email addresses
- Resave ACF groups to ensure cache has been written to acf-cache folder

### SmoothState.js

Download and enqueue the latest smoothState.js and smoothState.css in functions.php. Incorporate js, css, footer.php and header.php files from `smoothstate-theme` folder into main theme folder.

### TODO:

- Refactor print styles
- Add accordion and tab bar default JS + CSS (Shortcode)