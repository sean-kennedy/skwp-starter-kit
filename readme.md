# Wordpress Starter Kit

A starter kit for Wordpress projects.

## Install

Update wp-config:

Revisions, Disable Editor

```
define('WP_POST_REVISIONS', 5);
define('DISALLOW_FILE_EDIT', true);
```

Update Permalinks:

- Custom Structure - `/articles/%postname%/`
- Category base - archives
- Tag base - tags

Install Plugins:

- Advanced Custom Fields Pro
- Relevanssi - Add search logging excluding master
- Yoast SEO - Import settings or setup as per http://onlinemediamasters.com/yoast-wordpress-seo-tutorial/
- iThemes Security
- CMS Tree Page View
- Gravity Forms
- Velvet Blues Update URLs
- White Label CMS
- Autoptimize (minification)
- EM Object Cache (query cache)
- Live Edit (front-end editing)

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
- White label logos for Wordpress (Whitelabel CMS plugin)

Known Issues:

- EM Object Cache in FileCache mode conflicts with ACF admin edit screen. To make changes to ACF fields disable FileCache mode.

TODO:

- Refactor print styles
- Add accordion and tab bar default JS + CSS (Shortcode)