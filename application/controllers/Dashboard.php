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
		
		if ($this->currentUserGroup[0]->name == 'Employee')
		{

			$this->db->from('aauth_users');
			$this->db->where('id', $this->currentUserGroup[0]->id );
			$this->db->select('dept_id');
			$dept_id = $this->db->get()->row_array();

			$this->db->from('departments');
			$this->db->where('departments.cid', $dept_id["dept_id"]);
			$this->db->select('c_name');
			$emp_dept = $this->db->get()->row_array();
			
			if( !empty($emp_dept) ) {
				$emp_dept = $emp_dept["c_name"];
			} else {
				$emp_dept = "";
			}

			$data['heading1'] = 'EMPLOYEE CODE <h5>GEW - '.$this->currentUser->username.'</h5>';
			$data['heading2'] = $emp_dept .' <h6 class="">'.$this->currentUser->first_name.' '.$this->currentUser->last_name.'</h6>'; 
			$data['nav1'] = 'GEW Employee';
		}
		else
		{
			$data['heading1'] = 'You\'re Login as <h3>Manager <br> Account</h3> ';
			$data['nav1'] = 'Manager';
		}

		$data['currentUser'] = $this->currentUser;
		$data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page'] = strtolower($this->currentUserGroup[0]->name).'/dashboard'; // views/display.php page
        $this->load->view('manager_layout', $data);
	}

}
