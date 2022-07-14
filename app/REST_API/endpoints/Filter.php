<?php

namespace Automattic\Jetpack_Inspect\REST_API\Endpoints;

use Automattic\Jetpack_Inspect\Monitors;
use Automattic\Jetpack_Inspect\REST_API\Permissions\Current_User_Admin;

class Filter {
	public function name() {
		return 'filter';
	}

	public function request_methods() {
		return 'GET, POST';
	}

	public function response( $request ) {

		$remote_request = Monitors::get( 'remote_request' );
		if ( $request->get_method() === 'GET' ) {
			return rest_ensure_response( $remote_request->get_filter() );
		}

		$filter = $request->get_param( 'filter' );

		try {
			return rest_ensure_response( $remote_request->set_filter( $filter ) );
		} catch ( \Exception $e ) {
			return rest_ensure_response( [ 'error' => $e->getMessage() ] );
		}

	}

	public function permissions() {
		return array(
			new Current_User_Admin(),
		);
	}
}