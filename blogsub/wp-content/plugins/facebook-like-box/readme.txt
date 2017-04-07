=== Facebook Like Box ===
Contributors: Marcos Esperon
Tags: facebook, like box
Requires at least: 2.5
Tested up to: 2.9
Stable tag: 0.1

Displays a Facebook Like Box. The Like Box is a social plugin that enables Facebook Page owners to attract and gain Likes from their own website. 

== Description ==

If you have a page in Facebook about your blog and want to show the Facebook Like Box with the recent updates and fans, just activate this widget or insert this line of code anywhere in your theme:

`<?php facebook_like_box('PROFILE_ID'); ?>`

If you want to change updates visibility, max. number of fans, width or css properties, just do this:

`<?php facebook_like_box('PROFILE_ID', 'STREAM', 'CONNECTIONS', 'WIDTH', 'HEIGHT', 'HEADER', 'LOCALE'); ?>`

Where:

- STREAM: Set to 1 to display stream stories in the Fan Box or 0 to hide stream stories. (Default value is 1.)

- CONNECTIONS: The number of fans to display in the Fan Box. Specifying 0 hides the list of fans in the Fan Box. You cannot display more than 100 fans. (Default value is 10 connections.)

- WIDTH: The width of the Fan Box in pixels. The Fan Box must be at least 200 pixels wide at minimum. (Default value is 300 pixels.)

- HEIGHT: Limits the height used by the widget.

- HEADER: Show/Hide Facebook logo bar.

- LOCALE: Facebook Locale (en_US, es_ES...).

== Installation ==

1. Upload the entire facebook-like-box folder to your wp-content/plugins/ directory.

2. Activate the plugin through the 'Plugins' menu in WordPress.

3. Visit http://www.facebook.com/pages/create.php to create a new page in Facebook.
   Then edit your page and obtain the PROFILE_ID from the adress bar.

4. Use this information to call the function inside your template or activate the widget.

== Screenshots ==
1. Facebook Like Box

3. Facebook Like Box - Copy your Page ID from adress bar

== Changelog ==  

= 0.1 =  
* Initial release.