<?php
/**
 *  * Advanced Custom Fields
 *
 * @package       ACF
 * @author        WP Engine
 *
 * @wordpress-plugin
 * Plugin Name:   WP Blueprint Mailer
 * Plugin URI:    https://github.com/WP-Blueprint/wp-blueprint-plugin-mailer
 * Description:   Customize WordPress with powerful, professional and intuitive fields.
 * Version:       1.0.0
 * Author:        WP Blueprint
 * Author URI:    https://wp-blueprint.dev/
 * Text Domain:   acf
 * Domain Path:   /lang
 */

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) :
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
endif;

if ( class_exists( 'WPBlueprint\\Plugins\\Mailer' ) ) :
	$mailer = new WPBlueprint\Plugins\Mailer();
	$mailer->register();
endif;
