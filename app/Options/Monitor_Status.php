<?php

namespace Automattic\Jetpack_Inspect\Options;

use Automattic\Jetpack_Inspect\Async_Option\Async_Option_Template;

class Monitor_Status extends Async_Option_Template {

	public function sanitize( $value ): bool {
		return (bool) $value;
	}

	public function validate( $value ) {
		if ( ! is_bool( $value ) ) {
			return sprintf( __( "Status should be a 'boolean'. Received '%s'.", 'jetpack-inspect' ), gettype( $value ) );
		}
		return true;
	}

	public function transform( $value ) {
		return (bool) $value;
	}

	public function parse( $value ) {
		return filter_var( $value, FILTER_VALIDATE_BOOLEAN );
	}
}

