=== Easy Admin CSS ===
Contributors: shlokjodha
Donate Link: http://www.phpczar.com/
Tags: css, styles, custom css, custom, Admin css,
Requires at least: 3.0.1
Tested up to: 3.8
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add Custom CSS to your WordPress site without any developer.

== Description ==

An easy-to-use WordPress Plugin to add custom CSS styles that override Plugin and Theme default styles into WordPress admin. This plugin is designed to meet the needs of administrators who would like to add their own CSS to their WordPress Admin.

**Allows Double Quotes and Single Quotes in CSS Selectors!**

**Features**

- No configuration needed
- Admin interface built on WordPress UI
- No Complicated database queries
- Extremely lightweight
- Thorough documentation
- Virtually no impact on site performance

== Installation ==

Install Easy Admin CSS just as you would any other WP Plugin:

1.  [Download Easy Admin CSS] from WordPress.org.

2.  Unzip the .zip file.

3.  Upload the Plugin folder (easy-admin-css/) to the wp-content/plugins folder.

4. Go to [Plugins Admin Panel](http://codex.wordpress.org/Administration_Panels#Plugins "Plugins Admin Panel") and find the newly uploaded Plugin, "Easy Admin CSS" in the list.

5. Click Activate Plugin to activate it.

[More help installing Plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins "WordPress Codex: Installing Plugins")

== Frequently Asked Questions ==

Find more help at the [Easy Admin CSS Wiki](http://www.phpczar.com/contactus/ "Easy Admin CSS Wiki")

= My Custom CSS isn't showing up =

There are several reasons this could be happening:

* Your CSS is targeting the wrong selector.

* Your CSS selectors aren't specific enough.

For instance, you may have:

	a {
		color: #f00;
	}

When you need:

	#content a {
		color: #f00;
	}

The specificity you need depends upon the CSS rules you are attempting to override.

* Your CSS isn't valid.

Please check your CSS at the [W3C CSS Validation Service](http://jigsaw.w3.org/css-validator/#validate_by_input+with_options" "W3C CSS Validation Service").

== Screenshots == 
1. screenshot-1.jpg


== Changelog ==

= 1.0.1 =
* Inital Release

== CREDIT ==

This plugin is created by Praveen Singh Shekhawat  - 

== CONTACT ==

Praveen Singh Shekhawat | WordPress King
Profile URL : http://www.phpczar.com/