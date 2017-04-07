=== AWeber Web Form Plugin ===
Contributors: aweber
Donate link: http://www.aweber.com
Tags: email, marketing, email marketing, webform, web, form, aweber, mailing list, API, newsletter
Requires at least: 2.7.0
Tested up to: 3.9.1
Stable tag: 1.1.10

Allows you to install an AWeber web form on your WordPress blog and lets visitors subscribe to your list when commenting or registering on your blog.

== Description ==

Drag and drop web forms that you have created in your <a href="http://www.aweber.com" title="AWeber email marketing">AWeber email marketing</a> account into your blog, without having to log into your AWeber account or copy and paste anything! All you need is an AWeber account and a <a href="http://www.aweber.com/faq/questions/53">completed web form</a>.

In addition, you can allow visitors to your blog to sign up as they leave a comment or register, without having to fill out a separate web form. On your WordPress dashboard, you will be able to see how many people have signed up to your list by commenting, as well as keep up to date on the latest email marketing advice from AWeber's blog.

= Learn More About AWeber =

<a href="http://www.aweber.com/">AWeber</a> is an email marketing service that helps users to stay in contact with their website visitors, blog readers and customers. Take a look at <a href="http://www.aweber.com/email-marketing-features.htm">what AWeber has to offer</a> and get started with a brand new account for <a href="https://www.aweber.com/order.htm">just a dollar</a>.

= How Was This Widget Made? =

This widget was created using AWeber's API. To learn more about the API and create your own widgets and apps, visit <a href="http://labs.aweber.com">AWeber Labs</a>.

== Installation ==

If you have any trouble following the instructions below, please <a href="http://www.aweber.com/faq/questions/588/How+Do+I+Use+AWeber%27s+Webform+Widget+for+Wordpress%3F">consult our knowledge base for a walkthrough</a>.

If you're manually installing the widget as a .zip, make sure you upload it to "/wp-content/plugins/". Once installed, activate it on your Plugins page by clicking the Activate link.

To connect the widget to your AWeber account, first click AWeber Web Form under the Settings tab on the left of your Wordpress control panel.

On this page, click the link next to "Step 1".

You will be taken to a page asking you to authorize the connection between your AWeber account and the widget. Enter your login name and password here and hit the "Allow Access" button.

You'll be taken to a page with an authorization code (it will be a long string of characters) - simply highlight it and copy it to your clipboard.

Back in your Wordpress account, just paste the authorization code into the space provided and click the "Make Connection" button.

To allow people to subscribe to a list when you approve their comment or they register for your blog, first choose the list from the dropdown under the "Subscribe By Commenting" heading. Second, make sure that the appropriate subscribe methods are checked (via comments or blog registrations). Third, enter the text you'd like to appear next to the checkbox people will use to subscribe in the "Promotion Text" area (or simply leave the default "Sign up to our newsletter!" text). Once you're done, just hit the "Save" button.

To place your AWeber web form, head over to the Widgets page under Appearance on the left side of your Wordpress dashboard.

Simply drag the widget (it will show up under Available Widgets as "AWeber Web Form") into the widget area in which you'd like your form to appear.

Once the widget is in place, you can choose which form you would like to appear. Expand the AWeber Web Form widget's options by clicking the arrow to its right, then use the drop down menus to choose the list you want to work with, and the web form you'd like to place on your blog.

Then hit the "Save" button to save your changes, and your form will be installed on your blog.

Once you've set up the plugin to your satisfaction, you'll notice that you now have an AWeber pane on the home page your WordPress dashboard (you can see this by clicking "Dashboard" in the upper left). Here, you'll be able to keep up with the latest news and tips from AWeber's blog, as well as see how many people have subscribed by commenting on your posts.

= Having Trouble? =

If you don't see any available web forms, make sure you've selected the right list.

If you're in the list you want subscribers added to, but still don't see a web form that you can add, you'll need to <a href="https://www.aweber.com/login.htm">log in</a> to your AWeber account and <a href="http://www.aweber.com/faq/questions/53">create a web form</a> first.

If you get an error when you try to save your changes to the "Subscribe By Commenting" section, make sure that you've selected a list from the first drop down menu - this is the list that people will be added to when they leave a comment or register for your blog and check the box to be added to your mailing list.

== Frequently Asked Questions ==

= How Do I Create a Web Form? =

For a step by step walkthrough on creating a web form, <a href="http://www.aweber.com/faq/questions/53">consult our knowledge base</a>.

= My Form Doesn't Fit in the Sidebar - How Do I Fix It? =

Wider forms may not fit perfectly at first, depending on the theme you are using for your blog. Luckily, you can easily resize your form in AWeber's web form generator.

<a href="http://www.aweber.com/faq/questions/336/How+Can+I+Resize+My+Form%3F">Take a look at our knowledge base for a tutorial</a>.

= I Created a Web Form, But I Can't Find it in the AWeber Web Form Widget. =

If you just created the web form, try refreshing the page and looking again.

Also, check any other lists that appear in the first drop down in the Web Form widget - it's important to make sure that you're working in the list you want subscribers to be added to.

= Someone Commented on My Blog, But They Weren't Added to My List. =

In order to prevent comment spammers from adding bad email addresses to your list, the plugin only adds comments that have been approved. Once a comment is manually or automatically approved, the person who left the comment will be added to your list.

= How Can I Adjust the Subscribe On Comment Checkbox's Position? =

Certain WordPress themes may have the option to change the position of the subscribe on comment checkbox. However, doing so requires manually editing the plugin code. If you are not comfortable doing this, please consult your web designer.

The file you need to edit is called aweber.php. Near the top of the file (around line 38), you will see comments instructing you on how to make the necessary changes. 

For more detail, please <a href="http://www.aweber.com/faq/questions/588#box">consult our knowledge base</a>.

== Screenshots ==

1. 
2. 
3. 

== Changelog ==
= 1.1.10 =
* Ensures that your website will load in the event that AWeber forms are unreachable by using asynchronous Javascript.
* AWeber highly recommends that you upgrade to this version.

= 1.1.9 =
* Update 'Tested up to' to 3.8.2

= 1.1.8 =
* Better error handling if AWeber API is unreachable.

= 1.1.7 =
* Added better feedback for authorizations when experiencing internet connectivity issues.

= 1.1.6 =
* Fixed issues with authentication

= 1.1.5 =
* Remove usage of deprecated split function.
* Make authentication error messages return more information to assist in troubleshooting api issues.
* Perform db cleanup when an authorization code is not valid.

= 1.1.4 =
* Fixed minor bugs with HTML and jQuery.

= 1.1.3 =
* Fixed disappearing admin bar in Dashboard.

= 1.1.2 =
* Subscribers will only be added on comments after the comment is approved.
* Comments added to aweber.php to adjust checkbox position for some WordPress themes.

= 1.1.1 =
* Modified error message when authentication fails to provide a link to reconnect your widget to an AWeber customer account.
* Changed the URL for the AWeber blog to prevent multiple redirects when the dashboard fetches the AWeber blog.

= 1.1 =
* Added the ability to add subscribers to a list via commenting and blog registration.
* Added an AWeber widget to the Dashboard that displays the latest posts from AWeber's email marketing blog as well as subscriber statistics for the subscribe by commenting feature.

= 1.0.4 =
* Fixed issue where PHP NOTICES where being raised for unset variables.  (credits: kangkor, Curtiss Grymala)

= 1.0.3 =
* Fixed issue where the webform widget would not refresh its drop-down lists properly when using the latest versions of WordPress.
* Fixed issue where the webform widget would not prompt for authentication when the app is disconnected from the AWeber customer account.

= 1.0.2 =
* Improved error handling during authorization process

= 1.0.1 =
* Remove reliance on #primary-widget-area in theme
* Add check for PHP 5.2+

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.1 =
* Add subscribers to a list by commenting and blog registrations.
* Added Dashboard widget that displays list statistics and AWeber blog updates.

= 1.0.1 =
* Bugfix to address loading issues with certain WordPress themes.

= 1.0 =
* Initial release.
