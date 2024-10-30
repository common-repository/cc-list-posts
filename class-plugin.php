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

namespace Clearcode;

use ReflectionClass;
use ReflectionMethod;

if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( __NAMESPACE__ . '\List_Posts' ) ) {
    class List_Posts extends List_Posts\Singleton {
        static protected $plugin = null;

        static public function get( $name = null ) {
            $path = plugin_dir_path( __FILE__ );
            $file = $path . 'plugin.php';
            $dir  = basename( $path );
            $url  = plugins_url( '', $file );

            if ( null === self::$plugin ) {
                self::$plugin = get_plugin_data( $file );
            }

            switch ( strtolower( $name ) ) {
                case 'file':
                    return $file;
                case 'dir':
                    return $dir;
                case 'path':
                    return $path;
                case 'url':
                    return $url;
                case 'slug':
                    return __CLASS__;
                case null:
                    return self::$plugin;
                default:
                    if ( ! empty( self::$plugin[ $name ] ) ) {
                        return self::$plugin[ $name ];
                    }

                    return null;
            }
        }

        public function __construct() {
            $class = new ReflectionClass( $this );
            foreach( $class->getMethods( ReflectionMethod::IS_PUBLIC ) as $method ) {
                if( $this->is_hook( $method->getName() ) ) {
                    $hook     = self::apply_filters( 'hook',     $this->get_hook( $method->getName() ), $class, $method );
                    $priority = self::apply_filters( 'priority', $this->get_priority( $method->getName() ), $class, $method );
                    $args     = self::apply_filters( 'args',     $method->getNumberOfParameters(), $class, $method );

                    add_filter( $hook, array( $this, $method->getName() ), $priority, $args );
                }
            }
        }

        protected function get_priority( $method ) {
            $priority = substr( strrchr( $method, '_' ), 1 );
            return is_numeric( $priority ) ? (int)$priority : 10;
        }

        protected function has_priority( $method ) {
            $priority = substr( strrchr( $method, '_' ), 1 );
            return is_numeric( $priority ) ? true : false;
        }

        protected function get_hook( $method ) {
            if( $this->has_priority( $method ) )
                $method = substr( $method, 0, strlen( $method ) - strlen( $this->get_priority( $method ) ) - 1 );
            if( $this->is_hook( $method ) )
                $method = substr( $method, 7 );
            return $method;
        }

        protected function is_hook( $method ) {
            foreach( array( 'filter_', 'action_' ) as $hook )
                if ( 0 === strpos( $method, $hook ) ) return true;
            return false;
        }

        static public function __( $text ) {
            return __( $text, self::get( 'textdomain' ) );
        }

        static public function apply_filters( $tag, $value ) {
            $args = func_get_args();
            $args[0] = self::get( 'slug' ) . '\\' . $args[0];

            return call_user_func_array( 'apply_filters', $args );
        }

        static public function get_template( $template, $vars = array() ) {
            $template = self::apply_filters( 'template', get_stylesheet_directory() . '/' . $template, $vars );
            if ( ! is_file( $template ) ) return false;

            $vars = self::apply_filters( 'vars', $vars, $template );
            if ( is_array( $vars ) ) extract( $vars, EXTR_SKIP );

            ob_start();
            include $template;
            return ob_get_clean();
        }

        public function shortcode( $args = '' ) {
            $args = wp_parse_args(
                $args,
                array(
                    'before'      => '<ul>',
                    'after'       => '</ul>',
                    'link_before' => '',
                    'link_after'  => '',
                    'type'        => 'postbypost',
                    'echo'        => 0,
                    'pagination'  => false,
                    'format'      => 'html'
                )
            );

            foreach( array( 'before', 'after' ) as $arg ) {
                $$arg = $args[$arg];
                $args[$arg] = $args['link_' . $arg];
                unset( $args['link_' . $arg] );
            }

            $posts = wp_get_archives( $args );
            $posts = explode( "\n", $posts );
            $posts = array_filter( $posts, 'trim' );

            $list = "$before\n";
            for( $i = 0; $i < count( $posts ); $i++ ) {
                if ( $i && $args['pagination'] && ( 0 === $i % $args['pagination'] ) ) {
                    $list .= "$after\n";
                    $list .= "<!--nextpage-->\n";
                    $list .= "$before\n";
                }
                $list .= $posts[$i] . "\n";
            }
            return $list . "$after\n";
        }

        public function filter_the_posts( $posts, $query ) {
            global $shortcode_tags;
            $shortcodes = $shortcode_tags;
            $shortcode_tags = null;

            $shortcode = self::apply_filters( 'shortcode', 'wp_list_posts' );
            add_shortcode( $shortcode, array( $this, 'shortcode' ) );

            foreach( $query->posts as $post )
                if( has_shortcode( $post->post_content, $shortcode ) )
                    $post->post_content = do_shortcode( $post->post_content );

            $shortcode_tags = array_merge( $shortcodes, $shortcode_tags );
            return $query->posts;
        }

        public function filter_plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {
            if ( empty( self::get( 'Name' )  ) ) return $plugin_meta;
            if ( empty( $plugin_data['Name'] ) ) return $plugin_meta;
            if ( self::get( 'Name' ) == $plugin_data['Name'] )
	            $plugin_meta[] = self::__( 'Author' ) . ' <a href="http://piotr.press" target="_blank">PiotrPress</a>';
            return $plugin_meta;
        }
    }
}
