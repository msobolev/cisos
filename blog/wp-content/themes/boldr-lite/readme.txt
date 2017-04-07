=== BOLDR LITE ===

Contributors: Iceable
Tags: black, blue, white, light, two-columns, right-sidebar, flexible-width, custom-header, custom-background, custom-menu, featured-images, full-width-template, sticky-post, theme-options, threaded-comments, translation-ready
Requires at least: 3.5
Tested up to: 3.9-RC1
Stable tag: 1.1.29

== ABOUT BOLDR LITE ==

BoldR Lite is a bold, responsive, magazine style theme for WordPress. Perfect for tech or design oriented blogs and creative business websites.
It features two widgetizable areas (sidebar and optional footer).

BoldR Lite is the lite version of BoldR Pro, which comes with many additional features and access to premium class pro support forum and can be found at http://www.iceablethemes.com

== GETTING STARTED ==

Once you activate the theme from your WordPress admin panel, you can visit the "Theme Options" page to quickly and easily upload your own logo and optionally set a custom favicon.
If you will be using a custom header image, you can also optionally choose to enable or disable it on your homepage, blog index pages, single post pages and individual pages.
It is highly recommended to set a menu (in appearance > menu) instead of relying on the default fallback menu. Doing so will automatically activate the dropdown version of your menu in responsive mode.
You can also set a custom menu to appear at the bottom right of your site. Note this footer menu doesn't support sub-menus, only top-level menu items will be displayed.

Additional documentation and free support forums can be found at http://www.iceablethemes.com under "support".

== SPECIAL FEATURES INSTRUCTIONS ==

* Footer widgets: The widgetizable footer is disabled by default. To activate it, simply go to Appearance > Widgets and drop some widgets in the "Footer" area, just like you would do for the sidebar. It is recommended to use 4 widgets in the footer, or no widgets at all to disable it.

Additional documentation and free support forums can be found at http://www.iceablethemes.com under "support".

== LICENSE ==

This theme is released under the terms of the GNU GPLv2 License.
Please refer to license.txt for more information.

== CREDITS ==

This theme bundles some third party javascript and jQuery plugins, released under GPL or GPL compatible licenses:
* hoverIntent: Copyright 2007, 2013 Brian Cherne. MIT License. http://cherne.net/brian/resources/jquery.hoverIntent.html
* superfish: Copyright 2013 Joel Birch. Dual licensed under the MIT and GPL licenses. http://users.tpg.com.au/j_birch/plugins/superfish/
* ru_RU, de_DE, es_ES and pt_BR translation files: see below.

All other files are copyright 2013-2014 Iceable Media.

== TRANSLATIONS ==

Currently available translations:

* French (fr_FR) translation: by Iceable Media
* Russian (ru_RU) translation: Thanks to Dmitriy Skalubo - http://wordpress.crimea.ua/
* German (de_DE) translation: Adapted from BoldR Pro translation by FromBeyond - info@frombeyond.de
* Spanish (es_ES) translation: por Chema Masip Diaz – http://www.pedaleapormadrid.es/ – chmadi@gmail.com
* Brazilian Portuguese (pt_BR) translation: Thanks to Rafael de Oliveira Stephano - http://rstephano.com.br - rafael@rstephano.com.br

Translating this theme into you own language is quick and easy, you will find a .POT file in the /languages folder to get you started. It contains about 40 strings only.
If you don't have a .po file editor yet, you can download Poedit from http://www.poedit.net/download.php - Poedit is free and available for Windows, Mac OS and Linux.

If you have translated this theme into your own language and are willing to share your translation with the community, please feel free to do so on the forums at http://www.iceablethemes.com
Your translation files will be added to the next update. Don't forget to leave your name, email address and/or website link so credits can be given to you!

== CHANGELOG ==

= 1.1.29 =
April 14th, 2014
* Fixed: Using sane defaults (No setting is saved in the database without explicit user action)
* Removed unused function boldr_get_settings()
* Tested with WordPress 3.9-RC1: no issue found

= 1.1.28 =
April 7th, 2014
* Fixed german translation: "Kein Kommentar" instead of "Nein Kommentar" based on user feedback
* Fixed typo in french translation "Votre recherche" instead of "Votre recherché"
* Updated .pot file
* Updated copyright note in all files (2013-2014)

= 1.1.27 =
March 31th, 2014
* Fixed missing strings from translation
* Webfonts loading (SSL/Non-SSL): removed is_ssl() check and let browsers determine which protocol to use
* Added paginated page support to page-full-width template

= 1.1.26 =
March 10th, 2014
* Loading webfonts with latin + latin extended subset to improve support for some foreign languages

= 1.1.25 =
February 26th, 2014
* Fixed minor issue in the code added to 1.1.24
* Updated fr_FR translation based on french speaking users feedback

= 1.1.24 =
February 17th, 2014
* Added paginated pages support

= 1.1.23 =
February 4th, 2014
* Added "Support and Feedback" in theme options
* Tested with WordPress 3.8.1

= 1.1.22 =
January 16th, 2014
* Added pt_BR translation files (kindly provided by Rafael de Oliveira Stephano)

= 1.1.21 =
January 2nd, 2014
* Updated tags for WordPress 3.8: fixed-layout and responsive-layout
* Updated screenshot to 880x660px for WordPress 3.8

= 1.1.20 =
December 13th, 2013
* Added spanish (es_ES) translation files.

= 1.1.19 =
November 25th, 2013
* Fixed select dropdown styling in Firefox (removes default FF arrow overlapping the custom styled arrow)

= 1.1.18 =
November 18th, 2013
* Bugfix: Appropriately use 'wp_enqueue_scripts' to enqueue CSS stylesheet
* Changed comment about removing credit link in footer.php (compliance)

= 1.1.17 =
November 8th, 2013
* Changed title attribute in footer credit link (WPTRT compliance)
* Removed logo from default settings: default now falls back to site title (WPTRT compliance)

= 1.1.16 =
November 5th, 2013
* Tested with WordPress 3.7.1
* Merged and minified CSS files into one for increased performances (uncompressed .dev.css version available for developpers under /css )
* Merged and minified JS files into one for increased performances (uncompressed .dev.js version available for developpers under /js )

= 1.1.15 =
October 21st, 2013
* Added editor style

= 1.1.14 =
October 2nd, 2013
* Enhanced empty search results page
* Updated .POT file
* Updated fr_FR translation

= 1.1.13 =
September 17th, 2013
* Merged header image code conditionals and moved to header.php
* Tested with WP 3.6.1.

= 1.1.12 =
September 10th, 2013
* Added: Option to disable responsive mode in Theme Options.

= 1.1.11 =
September 2nd, 2013
* Added: Dismissable admin notice warning users who have not set a primary menu (fallback menu is not responsive).

= 1.1.10 =
August 23th, 2013
* Fixed: Thumbnail display for single post causing occasional issue if not sized properly (happened when the image were uploaded while using another theme with different thumbnail size)
* Added: de_DE translation files.

= 1.1.9 =
August 5th, 2013
* Added: Option to choose whether blog index should display excerpt or full content for standard posts (other post formats always show full content).
* Fixed: Title for archive pages
* Updated: .POT file and fr_FR translation file.
* Tested with WP 3.6

= 1.1.8 =
July 25th, 2013
* CSS tidying up: moved all media queries (responsive mode) to a separate file for easier responsive mode disabling.

= 1.1.7 =
July 19th, 2013
* Fixed: Minor display issue in sub-footer in responsive mode
* Added: Option to display tagline on the top right
* Added: Tracking on link to BoldR Pro for statistics

= 1.1.6 =
July 9th, 2013
* Added: fr_FR translation files
* Added: ru_RU translation files (thanks to Dmitriy Skalubo - http://wordpress.crimea.ua/)

= 1.1.5 =
June 28th, 2013
* Tested with WordPress 3.5.2
* Further enhanced child-theme support (Stylesheets in /css folder can override the parent's versions)

= 1.1.4 =
June 19th, 2013
* Fixed: PT Sans webfont (used for content) were not enqueued properly
* Fixed: Webfonts enqueuing now supports SSL (https)

= 1.1.3 =
June 19th, 2013
* Enhanced child theme support by enqueueing style.css last, with get_stylesheet_directory_uri()
* Added: Option to use a text-based site title instead of an uploaded logo

= 1.1.2 =
June 3rd, 2013
* Added navigation links on attachment pages
* All navigation links texts are now translatable

= 1.1.1 =
May 31th, 2013
* Patched a little glitch in option framework (causing minor issues on new installations)
* Patched an issue with custom header display setting on new installations and homepage

= 1.1 =
May 28th, 2013
* Revision, enhancement and clean up of the whole code, in accordance with WP best practices
* Removed the slider which was using CPT (considered plugin territory by the WPTRT)
* Replaced the slider with WP custom header implementation
* Replaced background setting in custom option framework with WP built-in custom background
* Ability to show/hide custom header on front page, blog index, single posts and individual pages

= 1.0.2 =
May 2nd, 2013
* Fixed: Changed license to GPLv2 for improved compatibility
* Fixed: Escaping user-entered data before printing
* Fixed: Appropriately prefixed all custom functions
* Fixed: Proper enqueuing of google webfonts
* Fixed: "Previous" and "Next" posts links were mixed up on single post view
* Removed: Unnecessary enqueuing of jQuery
* Removed: Unnecessary use of function_exist() conditional
* Removed: Unused images files from the option framework
* Updated: Author URI

= 1.0.1 =
April 18th, 2013
* Fixed: Icefit Improved Excerpt enhanced to preserve some styling tags without breaking the markup
* Fixed: Option to enable/disable slider on blog index pages
* Added: Option to choose what content to display on blog index pages (Full content, WP default excerpt or Icefit improved excerpt)
* Added: /languages folder with default po and mo files and POT file for localization
* Changed: Updated Theme URI to BoldR Lite demo site

= 1.0 =
April 1st, 2013
* Initial release