=== Free CDN ===
Contributors: Phoenixheart
Donate link: http://www.phoenixheart.net/wp-plugins/free-cdn/
Tags: cdn, content delivery network, bandwidth, coral
Requires at least: 2.2
Tested up to: 3.0
Stable tag: 1.1.2

Rewrites your static files' URL's (JavaScripts, CSS, images etc.) so that they are served from [CoralCDN](http://www.coralcdn.org/) - a free P2P Content Delivery Network - instead of your own server, thus saves lots of bandwidth and improves availability. REQUIRES PHP >= 5

== Description ==
For busy websites, using a CDN (Content Delivery Network) to transfer static content such as images, javascripts, stylesheets, Flash etc. is highly recommended (as listed in Yahoo!'s [Best Practices for Speeding Up Your Web Site](http://developer.yahoo.com/performance/rules.html)) as it reduces server load and bandwidth thus improves stability and availability. 

There is a catch - Commerical CDN's like Akamai and Limelight are not cheap at all. Good news, we have an exception however - the free, P2P-based [CoralCDN](http://www.coralcdn.org/) allows us to take full advantage of a powereful CDN without spending a dime. How to use it? Well, basically, just append `.nyud.net` to the hostname of any URL, and that URL will be handled by Coral - simple. 

This plugin takes that simplicity one step further (or closer?) by rewriting your static files' URL's (JavaScripts, CSS, images etc.) so that they are served from Coral servers instead of your own. You don't have to touch anything! Just enable it, and boom! your static contents are handled with care by Coral's powerful server clusters. 

If you are paying bandwidth fee, this plugin hopefully helps with your bills. Even if you don't, enabling it may save your site in peak times.

== Features ==
* Just enable the plugin and call it done - no extra steps required!
* You can exclusively select the content types to be served through CoralCDN - currently supporting JS, CSS, images, inline background images, and &lt;object&gt;'s
* Additional URL's can be added as includes or excludes
* Debug mode gives you a good preview to make sure nothing goes wrong
* Works normally with other plugins. Especially useful if run along with WP Super Cache
* AJAX'ed admin section makes it quick and easy to adjust the settings

== Installation ==
As usual:

1. Download the plugin
1. Extract into a folder
1. Upload the entire to `wp-content/plugins/` directory of your WordPress installation
1. Enable it via Plugins panel
1. It should now work out of the box. If you want to tweak it a bit, head to Settings->Free CDN

== Frequently Asked Questions ==
= I just enabled Free CDN. Now my contents take longer than usual to be downloaded! =
The speed of downloading static contents is 100% decided by Coral servers. Depending on the server status, sometimes it may take a bit longer for the contents to be downloaded. If the performance is not satisfied, you may want to enable the plugin in certain peak times only. 

= My JavaScripts got broken! My cookies just don't work! [Insert error here] =
If your javascript doesn't work anymore, best bet is to uncheck "External JavaScript includes" from "Using CDN on these contents" option section. You can also enable Debug mode to see which files get involved, and try excluding them one by one to find out the problematic one and deal with it for good. 

= Why doesn't the plugin parse the external stylesheet and rewrite the background images there too? =
There should be no need. If the stylesheet got rewritten and is served through Coral, all relative (most commonly) background images defined inside it will be pulled from Coral servers too. 

= Everything went wrong! My site is now totally blank/ messed up! =
Looks like a plugin conflict. Try disabling your plugins one by one to find out which caused the problem.

== Screenshots ==
1. A peek of Options page
2. HTML source code in Debug, listing down the contents that would be served through Coral CDN

== History ==
* 1.1.2 Fix bug with non-default port
* 1.1.1 Minor security fix
* 1.1.0
1. Code optimization
1. Some bug fixes
1. Add PayPal Donate button ;)
* 1.0.0 Initial version