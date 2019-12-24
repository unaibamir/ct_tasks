<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {

	public function get_user() {
	}

	public function get_user_email( $user ) {
		$user_email 	= false;

		if( !empty( $user ) && is_object( $user ) ) {
			$user 			= $user;
		} else {
			$user 			= $this->aauth->get_user( $user );
		}

		if( isset($user->company_email) && !empty($user->company_email) ) {
			$user_email = $user->company_email;
		} else {
			$user_email = $user->email;
		}
		return $user_email;
	}

}

/* End of file tasks.php */
/* Location: ./application/models/User.php */