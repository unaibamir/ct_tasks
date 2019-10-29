<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

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

		$this->db->select('*');
		$this->db->from('aauth_users');
		$this->db->join('aauth_user_to_group', 'aauth_users.id = aauth_user_to_group.user_id');
		$this->db->join('departments', 'departments.cid = aauth_users.dept_id', 'left');
		$this->db->where('aauth_user_to_group.group_id', 3);

		$employees = $this->db->get()->result();


		foreach ($employees as $key => $employee) {
			$employee_id 	= 	$employee->id;
	        
	        $this->db->from('tasks');
	        $this->db->where('tasks.assignee', $employee_id);
	        $total_tasks = $this->db->count_all_results();
	        $employee->tasks = $total_tasks;      

		}
		

		$data['employees'] = $employees;
		$data['heading1'] = 'Employees';
		$data['nav1'] = 'GEW Employee';
		$data['nav1'] = ($this->currentUserGroup[0]->name == 'Manager')? 'Manager' : 'GEW Employee';

		$data['currentUser'] = $this->currentUser;
		$data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page'] = 'employee/list'; // views/display.php page
        $this->load->view('manager_layout', $data);
	}

	public function all()
	{
		$employees = $this->aauth->list_users("Employee");

		foreach ($employees as $key => $employee) {
			$employee_id 	= 	$employee->id;
	        
	        $this->db->from('tasks');
	        $this->db->where('tasks.assignee', $employee_id);
	        $total_tasks = $this->db->count_all_results();
	        $employee->tasks = $total_tasks;

	        $this->db->from('departments');
	        $this->db->where('departments.cid', $employee->dept_id);
	        $this->db->select('c_name');
	        $emp_dept = $this->db->get()->row_array();
			$employee->department = is_array($emp_dept) && isset($emp_dept) ? $emp_dept["c_name"] : "";	        

		}
		//dd($employees);

		$data['employees'] = $employees;
		$data['heading1'] = 'Employees';
		$data['nav1'] = 'GEW Employee';
		$data['nav1'] = ($this->currentUserGroup[0]->name == 'Manager')? 'Manager' : 'GEW Employee';

		$data['currentUser'] = $this->currentUser;
		$data['currentUserGroup'] = $this->currentUserGroup[0]->name;

        $data['inc_page'] = 'employee/list-employees';
        $this->load->view('manager_layout', $data);
	}

}

/* End of file Employee.php */
/* Location: ./application/controllers/Employee.php */