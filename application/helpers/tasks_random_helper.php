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

function task_list_link( $job_type ) {
    $base_url = base_url("/task/?");
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

		default:
			$text = "In Progress";
			break;
	}

	return $text;
}