<?php
/**
 * The functions file is used to initialize everything in the theme.  It controls how the theme is loaded and 
 * sets up the supported features, default actions, and default filters.  If making customizations, users 
 * should create a child theme and make changes to its functions.php file (not this one).  Friends don't let 
 * friends modify parent theme files. ;)
 *
 * Child themes should do their setup on the 'after_setup_theme' hook with a priority of 11 if they want to
 * override parent theme features.  Use a priority of 9 if wanting to run before the parent theme.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume 
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package Prototype
 * @subpackage Functions
 * @version 0.3.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2010 - 2011, Justin Tadlock
 * @link http://themehybrid.com/themes/prototype
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Load the core theme framework. */
require_once( trailingslashit( TEMPLATEPATH ) . 'library/hybrid.php' );
$theme = new Hybrid();

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'prototype_theme_setup' );

/**
 * Theme setup function.  This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since 0.1.0
 */
function prototype_theme_setup() {

	/* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();

	/* Add theme support for core framework features. */
	add_theme_support( 'hybrid-core-menus', array( 'primary', 'secondary', 'subsidiary' ) );
	add_theme_support( 'hybrid-core-sidebars', array( 'primary', 'secondary', 'header', 'subsidiary', 'after-singular' ) );
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-theme-settings', array( 'about', 'footer' ) );
	add_theme_support( 'hybrid-core-drop-downs' );
	add_theme_support( 'hybrid-core-seo' );
	add_theme_support( 'hybrid-core-template-hierarchy' );

	/* Add theme support for framework extensions. */
	add_theme_support( 'theme-layouts', array( '1c', '2c-l', '2c-r', '3c-l', '3c-r', '3c-c' ) );
	add_theme_support( 'post-stylesheets' );
	add_theme_support( 'dev-stylesheet' );
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'breadcrumb-trail' );
	add_theme_support( 'cleaner-gallery' );

	/* Add theme support for WordPress features. */
	add_theme_support( 'automatic-feed-links' );
	add_custom_background();

	/* Add the search form to the secondary menu. */
	add_action( "{$prefix}_close_menu_secondary", 'get_search_form' );

	/* Embed width/height defaults. */
	add_filter( 'embed_defaults', 'prototype_embed_defaults' );

	/* Filter the sidebar widgets. */
	add_filter( 'sidebars_widgets', 'prototype_disable_sidebars' );
	add_action( 'template_redirect', 'prototype_one_column' );

	/* Set the content width. */
	hybrid_set_content_width( 600 );
}

/**
 * Function for deciding which pages should have a one-column layout.
 *
 * @since 0.1.0
 */
function prototype_one_column() {

	if ( !is_active_sidebar( 'primary' ) && !is_active_sidebar( 'secondary' ) )
		add_filter( 'get_theme_layout', 'prototype_theme_layout_one_column' );

	elseif ( is_attachment() && 'layout-default' == theme_layouts_get_layout() )
		add_filter( 'get_theme_layout', 'prototype_theme_layout_one_column' );
}

/**
 * Filters 'get_theme_layout' by returning 'layout-1c'.
 *
 * @since 0.2.0
 */
function prototype_theme_layout_one_column( $layout ) {
	return 'layout-1c';
}

/**
 * Disables sidebars if viewing a one-column page.
 *
 * @since 0.1.0
 */
function prototype_disable_sidebars( $sidebars_widgets ) {
	global $wp_query;

	if ( current_theme_supports( 'theme-layouts' ) ) {

		if ( 'layout-1c' == theme_layouts_get_layout() ) {
			$sidebars_widgets['primary'] = false;
			$sidebars_widgets['secondary'] = false;
		}
	}

	return $sidebars_widgets;
}

/**
 * Overwrites the default widths for embeds.  This is especially useful for making sure videos properly
 * expand the full width on video pages.  This function overwrites what the $content_width variable handles
 * with context-based widths.
 *
 * @since 0.1.0
 */
function prototype_embed_defaults( $args ) {

	if ( current_theme_supports( 'theme-layouts' ) ) {

		$layout = theme_layouts_get_layout();

		if ( 'layout-3c-l' == $layout || 'layout-3c-r' == $layout || 'layout-3c-c' == $layout )
			$args['width'] = 500;
		elseif ( 'layout-1c' == $layout )
			$args['width'] = 928;
		else
			$args['width'] = 600;
	}
	else
		$args['width'] = 600;

	return $args;
}

?>