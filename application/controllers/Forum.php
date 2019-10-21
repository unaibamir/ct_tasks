<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		if(!$this->aauth->is_loggedin())
			redirect(base_url(''));
		$this->currentUser = $this->aauth->get_user();
		$this->currentUserGroup = $this->aauth->get_user_groups();
	}

	public function index()
	{
		echo 'comming soon!';
		exit;
		/*$email = 'Muraleedharan@yopmail.com';
		$pass = 'demo123';
		$username = 'Muraleedharan';

		$userid = $this->aauth->create_user($email,$pass,$username);
		$rs = 		$this->aauth->remove_member($userid,'manager');
		$rs = $this->aauth->add_member($userid,'employee');
		echo $userid;
		var_dump($rs);exit('ssdas 24');*/

		/*$rr = $this->aauth->get_user_groups();
		echo '<pre>';print_r($rr);
		exit('ssl');*/
		//get_user_groups
		//get_user_id
		
		$data['currentUser'] = $this->aauth->get_user();
        $data['inc_page'] = 'task/list'; // views/display.php page
        $this->load->view('manager_layout', $data);
	}

}
