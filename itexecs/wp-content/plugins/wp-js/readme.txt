=== WP JS ===
Contributors: Halmat Ferello
Tags: javascript, caching, optimization, gzip, post, posts
Requires at least: 2.5.1
Tested up to: 2.6.2
Stable tag: 2.0.6

Allows developers to compress (GZIP & JSMIN) JavaScript files as well as concatenate them into one single file.

== Description ==

This plugin will GZIP and JSMIN your JavaScript files as well as allowing the ability to put JavaScript files into a single file at the client's end. Cache expiry time can also be set in the admin page.

NEW:
* SECURITY PATCH - please update the plugin. (Thanks to Dario Caregnato)
* Will now work with Child Themes (Thanks to Wupperpirat)

Now in version 2.0 you can add JavaScript files to a specific page or post and putting all of them into one file.

Version 2.0

* Ability to add JavaScript files to specific page/post
* Improved security
* Reduced URL outputted

Example

`<script src="<?php wp_js('path/to/js/file.js'); ?>" type="text/javascript"></script>`

OR you can also concatenate the JavaScript files (comma separated)

`<script src="<?php wp_js('path/to/js/file.js, path/to/js/file2.js, path/to/js/file3.js'); ?>" type="text/javascript"></script>`

Visit the WP JS site for more information: http://www.halmatferello.com/lab/wp-js/

Try the CSS version of the this plugin: http://wordpress.org/extend/plugins/wp-css/

== Installation ==

1. Upload `wp-js` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Set the permissions for `/wp-js/` folder to `777`
1. Go to Settings > WP JS in the admin site. This setup the plugin.
1. Use `<?php wp_js('path/to/js/file.js'); ?>` to link to your JavaScript file. 

i.e. `<script src="<?php wp_js('path/to/js/file.js'); ?>" type="text/javascript"></script>`


== Frequently Asked Questions ==

= How should I code the URL inside the wp_js() function =

All the URLs must be relative to the current theme.

For example if your theme is default and you have javascript file called file.js inside this theme.

`<script src="<?php wp_js('file.js'); ?>" type="text/javascript"></script>`

If you had a file inside another folder within the current theme folder. For example, `theme/default/javascript`

`<script src="<?php wp_js('javascript/file.js'); ?>" type="text/javascript"></script>`


= Can I suggest an feature for the plugin? =

Of course, visit <a href="http://www.halmatferello.com/lab/wp-js/">WP JS Home Page</a>


= Are you available for hire? =

Yes I am, visit my <a href="http://www.halmatferello.com/services/">services</a> page to find out more.



== Screenshots ==

1. Tests were measured using a Firefox plugin called Firebug. Firefox was run a Mac Pro (2008) using OS X 10.5.3. Eight files were included in this test: builder.js, controls.js, dragdrop.js, effects.js, prototype.js, scriptaculous.js, slider.js and sound.js - all taken from the script.aculo.us website.
2. The default behaviour is to specify one file for WP JS to JSMIN and GZIP. `<script src="<?php wp_js('/javascript/global.js') ?>" type="text/javascript" charset="utf-8"></script>`
3. However it is also possible to combine several files together. It is very easy and only requires that you comma separate files inside the string parameter. `<script src="<?php wp_js('/javascript/sifr-addons.js,/javascript/sifr.js') ?>" type="text/javascript" charset="utf-8"></script>`
4. The admin section
5. Adding a JavaScript file to a specifc post