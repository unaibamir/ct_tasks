<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller 
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


		$sql = "SELECT T.*, D.c_name, E.* FROM `tasks` AS T LEFT JOIN departments AS D on D.cid = T.department_id LEFT JOIN aauth_users AS E on E.id = T.assignee";
		$data['tasks'] = $this->db->query($sql)->result();
		//echo "<pre>";print_r($data['tasks']);exit;
		$data['heading1'] = 'Task Listing';
		$data['nav1'] = 'Manager';
		$data['users'] = $this->db->get("aauth_users")->result_array();

		$data['currentUser'] = $this->currentUser;
		$data['currentUserGroup'] = $this->currentUserGroup[0]->name;
		$data['inc_page'] = 'task/list'; // views/display.php page
		

        $this->load->view('manager_layout', $data);
    }

    public function add()
    {
    	$this->load->library('form_validation');

    	$data['heading1'] = 'Task from';
    	$data['nav1'] = 'Manager';
    	$data['task_code'] = $this->generateRandomString(4);
		//select all department
    	$data['departments'] = $this->getDepartments();
		//select all employees
		$data['employees'] = $this->getUsers('Employee');

    	$data['currentUser'] = $this->currentUser;
    	$data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page'] = 'task/add'; // views/task/add.php page
        $this->load->view('manager_layout', $data);
    }

    public function save()
    {
		//server validation
    	$data = array(
    		't_title' => $this->input->post('title'),
    		't_code' => $this->input->post('code'),
    		'department_id' => $this->input->post('department'),
    		'parent_id' => $this->input->post('parentId'),
    		'assignee' => $this->input->post('assignee'),
    		'reporter' => $this->input->post('reporter'),
			//'attachment_id' => $this->input->post('title'),
    		't_description' => $this->input->post('description'),
    		'start_date' =>$this->input->post('start_date'),
    		'end_date' => $this->input->post('end_date'),
    		'created_by' => (!empty($this->currentUser->id))? $this->currentUser->id: 0
    	);

    	$this->db->insert('tasks', $data);
		//get task id and upload files

    	redirect(base_url('task'));
    }

    public function assign()
    {
    	exit('commming soon!');
    }

    public function history()
    {
    	exit('commming soon!');
    }

    public function alert()
    {
    	$data['nav1'] = 'GEW Employee';
    	$sql = "SELECT T.*, D.c_name FROM `tasks` AS T LEFT JOIN departments AS D on D.cid = T.department_id WHERE T.assignee = ?";
    	$data['tasks'] = $this->db->query($sql, $this->currentUser->id)->result();

    	$data['heading1'] = 'EMPLOYEE CODE <h5>GEW - '.$this->currentUser->username.'</h5>';
    	$data['nav1'] = 'Manager';

    	$data['currentUser'] = $this->currentUser;
    	$data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page'] = 'task/alert'; // views/display.php page
        $this->load->view('manager_layout', $data);
    }


    public function getDepartments()
    {
		//$sql = "SELECT * FROM departments WHERE id = ? AND status = ? AND author = ?";
		//$res = $this->db->query($sql, array(3, 'live', 'Rick'));
    	$sql = "SELECT * FROM departments WHERE c_status = ?";
    	$res = $this->db->query($sql, array(1));

		//$this->db->error();
    	$res = $res->result();
    	return $res;
    }

    public function getUsers($group){
    	$sql = "SELECT users.id, users.first_name, users.last_name FROM `aauth_groups` AS grp LEFT JOIN aauth_user_to_group AS grpusr ON grp.id = grpusr.group_id LEFT JOIN aauth_users AS users ON users.id = grpusr.user_id WHERE `name` = ?";
    	$res = $this->db->query($sql, array($group))->result();
		//echo $this->db->last_query();

    	return $res;
    }

    public function generateRandomString($length = 10) 
    {
		//abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ
    	$characters = '0123456789';
    	$charactersLength = strlen($characters);
    	$randomString = '';
    	for ($i = 0; $i < $length; $i++) {
    		$randomString .= $characters[rand(0, $charactersLength - 1)];
    	}
    	return $randomString;
    }


    /*****************AJAX Calls****************/
    public function detail($task_id)
    {
    	if(!empty($task_id))
    	{
    		$sql = "SELECT T.*, D.c_name, assignee.first_name as given, reporter.first_name as follow FROM `tasks` AS T LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter LEFT JOIN departments AS D ON D.cid = T.department_id WHERE T.tid = ?";
    		$taskDetail = $this->db->query($sql, $task_id)->row();

    		echo "<div class='row'>
    		<div class='col-lg-12'>
    		<div class='card'>
    		<div class='card-body'>
    		<h3 class='card-subtitle mb-3 text-muted'>Task Details</h3> 

    		<div class='row'>
    		<div class='col-lg-6'>
    		<p class='card-title'><h6>Task-Code </h6>  ".$taskDetail->t_code."</b></p>
    		<p class='card-title'><h6> Start Date</h6>  ".$taskDetail->start_date."</b></p>
    		<p class='card-title'><h6>Given By </h6>  ".$taskDetail->given."</b></p>

    		</div>

    		<div class='col-lg-6'>
    		<p class='card-title'><h6>Task Title</h6> ".$taskDetail->t_title."</b></p>
    		<p class='card-title success'><h6>End Date </h6>  ".$taskDetail->end_date."</b></p>
    		<p class='card-title'><h6>Follow up </h6>  ".$taskDetail->follow."</b></p>

    		</div>
    		</div>

    		<div class='row'>
    		<div class='col-lg-12'>
    		<h6 class='card-subtitle mb-2 text-muted'>Task Details</h6>
    		<p class='card-text'>".$taskDetail->t_description."</p>
    		<a href='http://gdlp01.c-wss.com/gds/0/0300004730/02/eosrt3-eos1100d-im2-c-en.pdf' download>
    		<img src='https://freeiconshop.com/wp-content/uploads/edd/document-download-flat.png'  width='40' height='40'> View attachement</a>
    		</div>
    		</div>
    		</div>
    		</div>
    		</div>
    		</div>

    		<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModal' data-whatever='@mdo'>Quick View</button>";

    	}    	
    }
}