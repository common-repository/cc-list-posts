<?php

/*
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

if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! function_exists( 'wp_list_posts' ) ) {
    function wp_list_posts( $args = '' ) {
        return Clearcode\List_Posts::instance()->shortcode( $args );
    }
}
