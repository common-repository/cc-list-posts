=== CC-List-Posts ===
Contributors: ClearcodeHQ, PiotrPress
Tags: wp_list_posts, wp_list_pages, wp_get_archives, shortcode, pagination, sitemap, Clearcode, PiotrPress
Requires at least: 4.7
Tested up to: 5.9.2
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

This plugin adds similar to `wp_list_pages`, missing function and shortcode `wp_list_posts` with pagination support.

== Description ==

The CC-List-Posts plugin works out of the box.
There is no settings page for it.
After activation you can start using `wp_list_posts` function and/or shortcode with the parameters listed below.

_**Notice**: the plugin can be used with the `wp_link_pages` built-in functionality if you use `pagination` parameter with integer value._

= Defaults =
* **before**: (string) &lt;ul&gt;,
* **after**: (string) &lt;/ul&gt;,
* **link_before**: (string) _empty string_,
* **link_after**: (string) _empty string_,
* **type**: (string) postbypost,
* **echo**: (integer) 0,
* **pagination**: (boolean|integer) false,
* **format**: (string) html
* **type**: (string) monthly,
* **limit**: (string) _empty string_,
* **show_post_count**: (boolean) false,
* **order**: (string) DESC,
* **post_type**: (string) post

_**Notice**: plugin uses `wp_get_archives` function to list posts, so you can also use additional parameters. A full list is available at WordPress [codex](https://codex.wordpress.org/Function_Reference/wp_get_archives) page documentation._

= wp_list_posts parameter mapped to wp_get_archives =
* **link_before**: before
* **link_after**: after

= Default usage =

* **Function**: `wp_list_posts( array( 'pagination' => 50 ) )`
* **Shortcode**: `[wp_list_posts pagination=50]`

== Installation ==

= From your WordPress Dashboard =

1. Go to 'Plugins > Add New'
2. Search for 'CC-List-Posts'
3. Activate the plugin from the Plugin section on your WordPress Dashboard.

= From WordPress.org =

1. Download 'CC-List-Posts'.
2. Upload the 'CC-List-Posts' directory to your '/wp-content/plugins/' directory using your favorite method (ftp, sftp, scp, etc...)
3. Activate the plugin from the Plugin section in your WordPress Dashboard.

= Multisite =

The plugin can be activated and used for just about any use case.

* Activate at the site level to load the plugin on that site only.
* Activate at the network level for full integration with all sites in your network (this is the most common type of multisite installation).

== Screenshots ==

1. **CC-List-Posts Shortcode** - Visit the 'Post/Page Editor' and add [wp_list_posts] shortcode.

== Changelog ==

= 1.0.1 =
*Release date: 16.03.2022*

* Added PHP 8.0 support.

= 1.0.0 =
*Release date: 15.12.2016*

* First stable version of the plugin.