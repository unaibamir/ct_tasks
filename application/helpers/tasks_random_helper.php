<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists("dd")) {
    function dd($data, $exit_data = true)
    {
        echo '<pre>' . print_r($data, true) . '</pre>';
        if ($exit_data == false)
            echo '';
        else
            exit;
    }
}


function job_type_state( $current_type, $job_type ) {
	
	if( $current_type == $job_type ) {
		$state = "active";
	} else {
		$state = "";
	}

	return $state;
}

function task_list_link( $job_type, $url = "/task/?" ) {
    $base_url = base_url( $url );
    /*if( isset($_GET["view"]) && !empty( $_GET["view"] ) ) {
        $base_url .= "/?view=". $job_type;
    }

    if( isset($_GET["employee_id"]) && !empty( $_GET["employee_id"] )) {
        $base_url .= "&employee_id=".$_GET["employee_id"];
    }*/

    $url_params_array = array(
        "view"          =>  $job_type,
        "employee_id"   =>  isset($_GET["employee_id"]) && !empty($_GET["employee_id"]) ? $_GET["employee_id"] : false
    );

    $url_params = http_build_query( $url_params_array );

    $url = $base_url . $url_params;

    return $url;
}


function getStatusText( $status = "in-progress" ) {
	$text = "";
	switch ($status) {
		case 'in-progress':
			$text = "In Progress";
			break;

		case 'hold':
			$text = "Hold";
			break;

		case 'cancelled':
			$text = "Cancelled";
			break;

		case 'completed':
			$text = "Finished";
			break;

		case 'pending':
			$text = "Pending";
			break;

		default:
			$text = "In Progress";
			break;
	}

	return $text;
}





/**
 * Maps a function to all non-iterable elements of an array or an object.
 *
 * This is similar to `array_walk_recursive()` but acts upon objects too.
 *
 * @since 4.4.0
 *
 * @param mixed    $value    The array, object, or scalar.
 * @param callable $callback The function to map onto $value.
 * @return mixed The value with the callback applied to all non-arrays and non-objects inside it.
 */
function map_deep( $value, $callback ) {
	if ( is_array( $value ) ) {
		foreach ( $value as $index => $item ) {
			$value[ $index ] = map_deep( $item, $callback );
		}
	} elseif ( is_object( $value ) ) {
		$object_vars = get_object_vars( $value );
		foreach ( $object_vars as $property_name => $property_value ) {
			$value->$property_name = map_deep( $property_value, $callback );
		}
	} else {
		$value = call_user_func( $callback, $value );
	}

	return $value;
}


/**
 * Parses a string into variables to be stored in an array.
 *
 * Uses {@link https://secure.php.net/parse_str parse_str()} and stripslashes if
 * {@link https://secure.php.net/magic_quotes magic_quotes_gpc} is on.
 *
 * @since 2.2.1
 *
 * @param string $string The string to be parsed.
 * @param array  $array  Variables will be stored in this array.
 */
function wp_parse_str( $string, &$array ) {
	parse_str( $string, $array );
	if ( get_magic_quotes_gpc() ) {
		$array = stripslashes_deep( $array );
	}
	/**
	 * Filters the array of variables derived from a parsed string.
	 *
	 * @since 2.3.0
	 *
	 * @param array $array The array populated with variables.
	 */
	$array = $array;
}

/**
 * Build URL query based on an associative and, or indexed array.
 *
 * This is a convenient function for easily building url queries. It sets the
 * separator to '&' and uses _http_build_query() function.
 *
 * @since 2.3.0
 *
 * @see _http_build_query() Used to build the query
 * @link https://secure.php.net/manual/en/function.http-build-query.php for more on what
 *       http_build_query() does.
 *
 * @param array $data URL-encode key/value pairs.
 * @return string URL-encoded string.
 */
function build_query( $data ) {
	return _http_build_query( $data, null, '&', '', false );
}


/**
 * Navigates through an array, object, or scalar, and removes slashes from the values.
 *
 * @since 2.0.0
 *
 * @param mixed $value The value to be stripped.
 * @return mixed Stripped value.
 */
function stripslashes_deep( $value ) {
	return map_deep( $value, 'stripslashes_from_strings_only' );
}

/**
 * Callback function for `stripslashes_deep()` which strips slashes from strings.
 *
 * @since 4.4.0
 *
 * @param mixed $value The array or string to be stripped.
 * @return mixed $value The stripped value.
 */
function stripslashes_from_strings_only( $value ) {
	return is_string( $value ) ? stripslashes( $value ) : $value;
}

/**
 * Navigates through an array, object, or scalar, and encodes the values to be used in a URL.
 *
 * @since 2.2.0
 *
 * @param mixed $value The array or string to be encoded.
 * @return mixed $value The encoded value.
 */
function urlencode_deep( $value ) {
	return map_deep( $value, 'urlencode' );
}

/**
 * Navigates through an array, object, or scalar, and raw-encodes the values to be used in a URL.
 *
 * @since 3.4.0
 *
 * @param mixed $value The array or string to be encoded.
 * @return mixed $value The encoded value.
 */
function rawurlencode_deep( $value ) {
	return map_deep( $value, 'rawurlencode' );
}

/**
 * Navigates through an array, object, or scalar, and decodes URL-encoded values
 *
 * @since 4.4.0
 *
 * @param mixed $value The array or string to be decoded.
 * @return mixed $value The decoded value.
 */
function urldecode_deep( $value ) {
	return map_deep( $value, 'urldecode' );
}


/**
 * From php.net (modified by Mark Jaquith to behave like the native PHP5 function).
 *
 * @since 3.2.0
 * @access private
 *
 * @see https://secure.php.net/manual/en/function.http-build-query.php
 *
 * @param array|object  $data       An array or object of data. Converted to array.
 * @param string        $prefix     Optional. Numeric index. If set, start parameter numbering with it.
 *                                  Default null.
 * @param string        $sep        Optional. Argument separator; defaults to 'arg_separator.output'.
 *                                  Default null.
 * @param string        $key        Optional. Used to prefix key name. Default empty.
 * @param bool          $urlencode  Optional. Whether to use urlencode() in the result. Default true.
 *
 * @return string The query string.
 */
function _http_build_query( $data, $prefix = null, $sep = null, $key = '', $urlencode = true ) {
	$ret = array();

	foreach ( (array) $data as $k => $v ) {
		if ( $urlencode ) {
			$k = urlencode( $k );
		}
		if ( is_int( $k ) && $prefix != null ) {
			$k = $prefix . $k;
		}
		if ( ! empty( $key ) ) {
			$k = $key . '%5B' . $k . '%5D';
		}
		if ( $v === null ) {
			continue;
		} elseif ( $v === false ) {
			$v = '0';
		}

		if ( is_array( $v ) || is_object( $v ) ) {
			array_push( $ret, _http_build_query( $v, '', $sep, $k, $urlencode ) );
		} elseif ( $urlencode ) {
			array_push( $ret, $k . '=' . urlencode( $v ) );
		} else {
			array_push( $ret, $k . '=' . $v );
		}
	}

	if ( null === $sep ) {
		$sep = ini_get( 'arg_separator.output' );
	}

	return implode( $sep, $ret );
}


/**
 * Retrieves a modified URL query string.
 *
 * You can rebuild the URL and append query variables to the URL query by using this function.
 * There are two ways to use this function; either a single key and value, or an associative array.
 *
 * Using a single key and value:
 *
 *     add_query_arg( 'key', 'value', 'http://example.com' );
 *
 * Using an associative array:
 *
 *     add_query_arg( array(
 *         'key1' => 'value1',
 *         'key2' => 'value2',
 *     ), 'http://example.com' );
 *
 * Omitting the URL from either use results in the current URL being used
 * (the value of `$_SERVER['REQUEST_URI']`).
 *
 * Values are expected to be encoded appropriately with urlencode() or rawurlencode().
 *
 * Setting any query variable's value to boolean false removes the key (see remove_query_arg()).
 *
 * Important: The return value of add_query_arg() is not escaped by default. Output should be
 * late-escaped with esc_url() or similar to help prevent vulnerability to cross-site scripting
 * (XSS) attacks.
 *
 * @since 1.5.0
 *
 * @param string|array $key   Either a query variable key, or an associative array of query variables.
 * @param string       $value Optional. Either a query variable value, or a URL to act upon.
 * @param string       $url   Optional. A URL to act upon.
 * @return string New URL query string (unescaped).
 */
function add_query_arg() {
	$args = func_get_args();
	if ( is_array( $args[0] ) ) {
		if ( count( $args ) < 2 || false === $args[1] ) {
			$uri = $_SERVER['REQUEST_URI'];
		} else {
			$uri = $args[1];
		}
	} else {
		if ( count( $args ) < 3 || false === $args[2] ) {
			$uri = $_SERVER['REQUEST_URI'];
		} else {
			$uri = $args[2];
		}
	}

	if ( $frag = strstr( $uri, '#' ) ) {
		$uri = substr( $uri, 0, -strlen( $frag ) );
	} else {
		$frag = '';
	}

	if ( 0 === stripos( $uri, 'http://' ) ) {
		$protocol = 'http://';
		$uri      = substr( $uri, 7 );
	} elseif ( 0 === stripos( $uri, 'https://' ) ) {
		$protocol = 'https://';
		$uri      = substr( $uri, 8 );
	} else {
		$protocol = '';
	}

	if ( strpos( $uri, '?' ) !== false ) {
		list( $base, $query ) = explode( '?', $uri, 2 );
		$base                .= '?';
	} elseif ( $protocol || strpos( $uri, '=' ) === false ) {
		$base  = $uri . '?';
		$query = '';
	} else {
		$base  = '';
		$query = $uri;
	}

	wp_parse_str( $query, $qs );
	$qs = urlencode_deep( $qs ); // this re-URL-encodes things that were already in the query string
	if ( is_array( $args[0] ) ) {
		foreach ( $args[0] as $k => $v ) {
			$qs[ $k ] = $v;
		}
	} else {
		$qs[ $args[0] ] = $args[1];
	}

	foreach ( $qs as $k => $v ) {
		if ( $v === false ) {
			unset( $qs[ $k ] );
		}
	}

	$ret = build_query( $qs );
	$ret = trim( $ret, '?' );
	$ret = preg_replace( '#=(&|$)#', '$1', $ret );
	$ret = $protocol . $base . $ret . $frag;
	$ret = rtrim( $ret, '?' );
	return $ret;
}



/**
 * Replaces double line-breaks with paragraph elements.
 *
 * A group of regex replaces used to identify text formatted with newlines and
 * replace double line-breaks with HTML paragraph tags. The remaining
 * line-breaks after conversion become <<br />> tags, unless $br is set to '0'
 * or 'false'.
 *
 * @param string $pee The text which has to be formatted.
 * @param bool $br Optional. If set, this will convert all remaining line-breaks after paragraphing. Default true.
 * @return string Text which has been converted into correct paragraph tags.
 */
function autop($pee, $br = true) {
  $pre_tags = array();

	if ( trim($pee) === '' )
		return '';

	$pee = $pee . "\n"; // just to make things a little easier, pad the end

	if ( strpos($pee, '<pre') !== false ) {
		$pee_parts = explode( '</pre>', $pee );
		$last_pee = array_pop($pee_parts);
		$pee = '';
		$i = 0;

		foreach ( $pee_parts as $pee_part ) {
			$start = strpos($pee_part, '<pre');

			// Malformed html?
			if ( $start === false ) {
				$pee .= $pee_part;
				continue;
			}

			$name = "<pre wp-pre-tag-$i></pre>";
			$pre_tags[$name] = substr( $pee_part, $start ) . '</pre>';

			$pee .= substr( $pee_part, 0, $start ) . $name;
			$i++;
		}

		$pee .= $last_pee;
	}

	$pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
	// Space things out a little
	$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|option|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|noscript|samp|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';
	$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
	$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
	$pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
	if ( strpos($pee, '<object') !== false ) {
		$pee = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $pee); // no pee inside object/embed
		$pee = preg_replace('|\s*</embed>\s*|', '</embed>', $pee);
	}
	$pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
	// make paragraphs, including one at the end
	$pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
	$pee = '';
	foreach ( $pees as $tinkle )
		$pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
	$pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
	$pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
	$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
	$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
	$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
	$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
	$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
	if ( $br ) {
		$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', create_function('$matches', 'return str_replace("\n", "<PreserveNewline />", $matches[0]);'), $pee);
		$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
		$pee = str_replace('<PreserveNewline />', "\n", $pee);
	}
	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
	$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
	$pee = preg_replace( "|\n</p>$|", '</p>', $pee );

	if ( !empty($pre_tags) )
		$pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);

	return $pee;
}