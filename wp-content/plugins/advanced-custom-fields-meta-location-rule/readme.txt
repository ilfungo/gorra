=== Advanced Custom Fields: Meta Location Rule ===

Contributors: stupid_studio
Requires at least: 3.4.0
Tags: admin, advanced custom field, custom field, acf, meta, location rules
Tested up to: 3.8.1
Stable tag: 1.0.5
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

== Description ==

This add-on to [Advanced Custom Fields (ACF)](http://www.advancedcustomfields.com/) makes it possible to add location rules for the custom fields / meta fields of any post.

Using this plugin, you can create any custom field and make another set of custom fields, depend on the value of this custom field.

We decided to create this plugin, as we often face problems when trying to deploy our ACF fields from test to production, due to the nature of the other location rules. The built in location rules in ACF are mostly based on IDs, but IDs are rarely the same in test as in production.

This software is licensed under the GNU General Public License version 3. See gpl.txt included with this software for more detail.

Please note, that this plugin is an unofficial Advanced Custom Fields-plugin.

== Limitations ==

This plugin will currently not work with fields in:

 * Flexible Content Fields
 * Repeaters
 * On options pages
 * On taxonomy pages


== Installation ==

Install this plugin by searching for it in your plugins manager within your WordPress site.


== Usage ==

See the screenshots. It should be pretty self explainatory.


== Screenshots ==

1. Where to find the "Meta Field" while defining a location rule.
2. "Meta Field" filled with a key and a value.


== Wish list ==

 * Support for options pages.
 * Support for taxonomy pages.
 * More comparison operators, such as:
   * Less/more than
   * Before/after date


== Changelog ==

= 1.0.5 =
PHP 5.2-compability: Moved all functions from anonymous callbacks and into a class, solely to achieve PHP 5.2 compability.

= 1.0.4 =
Bugfix: When using radio and checkbox input types for the rule meta field, the wrong rule be used (missing check of which radio/checkbox was actually the checked one).

= 1.0.3 =
Bugfix: Removed reference to JS-serialization-function, which was used to serialize before saving.

= 1.0.2 =
Text updated

= 1.0.1 =
Cookie-hack replaced by a much cleaner approach and cookie-library dependency removed.

= 1.0.0 =
First stable release.