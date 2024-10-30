<?php

/*
    Plugin Name: CC-List-Posts
    Plugin URI: https://wordpress.org/plugins/cc-list-posts
    Description: This plugin adds similar to `wp_list_pages`, missing function and shortcode `wp_list_posts` with pagination support.
    Version: 1.0.1
    Author: Clearcode
    Author URI: https://clearcode.cc
    Text Domain: cc-list-posts
    Domain Path: /languages/
    License: GPLv3
    License URI: http://www.gnu.org/licenses/gpl-3.0.txt

    Copyright (C) 2022 by Clearcode <http://clearcode.cc>
    and associates (see AUTHORS.txt file).

    This file is part of CC-List-Posts.

    CC-List-Posts is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    CC-List-Posts is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with CC-List-Posts; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

namespace Clearcode\List_Posts;

use Clearcode\List_Posts;

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'get_plugin_data' ) ) require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

foreach ( array( 'class-singleton.php', 'class-plugin.php', 'functions.php' ) as $file )
    require_once( plugin_dir_path( __FILE__ ) . $file );

if ( ! has_action( List_Posts::get( 'slug' ) ) ) do_action( List_Posts::get( 'slug' ), List_Posts::instance() );
