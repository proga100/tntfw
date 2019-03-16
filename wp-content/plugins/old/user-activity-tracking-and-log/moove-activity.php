<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *  Contributors: MooveAgency
 *  Plugin Name: User Activity Tracking and Log
 *  Plugin URI: http://www.mooveagency.com
 *  Description: This plugin gives you the ability to track user activity on your website.
 *  Version: 1.1.2
 *  Author: Moove Agency
 *  Author URI: http://www.mooveagency.com
 *  License: GPLv2
 *  Text Domain: user-activity-tracking-and-log
 */

define( 'MOOVE_UAT_VERSION', '1.1.2' );

register_activation_hook( __FILE__, 'moove_activity_activate' );
register_deactivation_hook( __FILE__, 'moove_activity_deactivate' );

/**
 * Set options page for the plugin
 */
function moove_set_options_values() {
	$settings   = get_option( 'moove_post_act' );
	$post_types = get_post_types( array( 'public' => true ) );
	unset( $post_types['attachment'] );
	if ( ! $settings ) :
		foreach ( $post_types as $post_type ) :
			if ( 1 !== $settings[ $post_type ] || ! isset( $settings[ $post_type ] ) ) :
				$settings[ $post_type ] = 0;
				update_option( 'moove_post_act', $settings );
			endif;
			if ( 1 !== $settings[ $post_type . '_transient' ] || ! isset( $settings[ $post_type . '_transient' ] ) ) :
				$settings[ $post_type . '_transient' ] = 7;
				update_option( 'moove_post_act', $settings );
			endif;
		endforeach;
	endif;
}

/**
 * Functions on plugin activation, create relevant pages and defaults for settings page.
 */
function moove_activity_activate() {
	moove_set_options_values();
}


/**
 * Function on plugin deactivation. It removes the pages created before.
 */
function moove_activity_deactivate() {
}

require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'moove-view.php';
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'moove-content.php';
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'moove-options.php';
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'moove-controller.php';
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'moove-actions.php';
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'moove-shortcodes.php';
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'moove-functions.php';

