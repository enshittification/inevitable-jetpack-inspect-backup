<?php

use Automattic\Jetpack_Inspect\Async_Option\Async_Option;
use Automattic\Jetpack_Inspect\Async_Option\Registry;
use Automattic\Jetpack_Inspect\Options\Monitor_Status;
use Automattic\Jetpack_Inspect\Options\Observer_Settings;

/**
 * Functions to make it easier to interface with Async Option:
 */
function jetpack_inspect_register_option( $name, $handler = null, $default = false ) {
	$instance = Registry::get_instance( 'jetpack_inspect' )
	                    ->regsiter( $name, $handler );

	if ( false !== $default ) {
		$instance->set_default( $default );
	}

	return $instance;
}

/**
 * @param $name
 *
 * @return Async_Option
 */
function jetpack_inspect_option( $name ) {
	return Registry::get_instance( 'jetpack_inspect' )->get_option( $name );
}

function jetpack_inspect_get_option( $option ) {
	return jetpack_inspect_option( $option )->get();
}

function jetpack_inspect_update_option( $option, $value ) {
	return jetpack_inspect_option( $option )->set( $value );
}

/**
 * Register Options
 */
jetpack_inspect_register_option( 'monitor_status', Monitor_Status::class );

$observer_defaults = [
	"enabled" => true,
	"filter"  => "",
];
jetpack_inspect_register_option( 'observer_incoming', Observer_Settings::class, $observer_defaults );
jetpack_inspect_register_option( 'observer_outgoing', Observer_Settings::class, $observer_defaults );




add_action( 'admin_init', function() {

	add_action( get_plugin_page_hook( 'jetpack-inspect', 'admin' ), function() {
		Registry::get_instance( 'jetpack_inspect' )
		        ->attach_to_script( 'jetpack-inspect-main' );
	} );

} );

