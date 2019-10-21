<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
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
		//get_user_groups
		// create user
		/*$email = 'Muraleedharan@yopmail.com';
		$pass = 'demo123';
		$username = 'Muraleedharan';

		$userid = $this->aauth->create_user($email,$pass,$username);
		$rs = 		$this->aauth->remove_member($userid,'manager');
		$rs = $this->aauth->add_member($userid,'employee');
		echo $userid;
		var_dump($rs);exit('ssdas 24');*/


		//create permission
		//$this->aauth->create_perm('all_task');

		//allow certain permission to group
		//$this->aauth->allow_group('manager','all_task');

		/*
		if($this->aauth->is_group_allowed('add_task', 'manager')){
			echo "Hobbits are immortal";
		} else {
			echo "Hobbits are NOT immortal";
		}*/

		/*$rr = $this->aauth->get_user_groups();
		echo '<pre>';print_r($rr);
		exit('ssl');*/
		//get_user_groups
		//get_user_id

		if ($this->currentUserGroup[0]->name == 'Employee')
		{
			$data['heading1'] = 'EMPLOYEE CODE <h5>GEW - '.$this->currentUser->username.'</h5>';
			$data['heading2'] = 'Software Developer <h6 class="">'.$this->currentUser->first_name.' '.$this->currentUser->last_name.'</h6>'; 
			$data['nav1'] = 'GEW Employee';
		}
		else
		{
			$data['heading1'] = 'You\'re Login as <h3>Manager - Account</h3> ';
			$data['nav1'] = 'Manager';
		}

		$data['currentUser'] = $this->currentUser;
		$data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page'] = strtolower($this->currentUserGroup[0]->name).'/dashboard'; // views/display.php page
        $this->load->view('manager_layout', $data);
	}

}
