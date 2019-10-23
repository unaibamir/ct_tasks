<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php

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