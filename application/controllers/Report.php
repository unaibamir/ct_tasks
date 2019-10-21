<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		if(!$this->aauth->is_loggedin())
			redirect(base_url(''));
		$this->currentUser = $this->aauth->get_user();
		$this->currentUserGroup = $this->aauth->get_user_groups();
	}

	public function daily()
	{
		$sql = "SELECT 
		T.*, 
		assignee.first_name as given,
		reporter.first_name as follow,
		D.c_name,
		R.berfore,
		R.after,
		R.status

		FROM `tasks` AS T
		LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee 
		LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter 
		LEFT JOIN departments AS D on D.cid = T.department_id
		LEFT JOIN reports AS R on R.task_id = T.tid";
		$tasks = $this->db->query($sql)->result();


		if (!empty($tasks))
		{
			$evening = $morning = $Ids = array();

			foreach ($tasks as $key => $value) 
			{
				if (!in_array($value->tid, $Ids))
				{
					$Ids[] = $value->tid;
					$morning[$value->tid] = $value;
					$evening[$value->tid] = $value;
				}

				if (!empty($value->berfore))
				{
					$morning[$value->tid]->morningReports['update'][] = $value->berfore;
					$morning[$value->tid]->morningReports['status'][] = $value->status;
				}

				if (!empty($value->after))
				{
					$evening[$value->tid]->eveningReports['update'][] = $value->after;
					$evening[$value->tid]->eveningReports['status'][] = $value->status;
				}
			}
		}

		
		$data['morning'] = $morning;
		$data['evening'] = $evening;

		$data['heading1'] = 'Daily Job Report View';
		$data['nav1'] = 'GEW Employee';
		$data['nav1'] = ($this->currentUserGroup[0]->name == 'Manager')? 'Manager' : 'GEW Employee';

		$data['currentUser'] = $this->currentUser;
		$data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page'] = 'report/daily'; // views/display.php page
        $this->load->view('manager_layout', $data);
	}

	public function monthly()
	{
		$data['CurrentMonthDates'] = $this->getCurrentMonthDates();
		$sql = "SELECT 
		T.*, 
		assignee.first_name as given,
		reporter.first_name as follow,
		D.c_name
		FROM `tasks` AS T
		LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee 
		LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter 
		LEFT JOIN departments AS D on D.cid = T.department_id";
		$data['tasks'] = $this->db->query($sql)->result();

		$sql = "SELECT * FROM `reports` WHERE is_deleted = 0 AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
		$data['currentMonthReports'] = $this->db->query($sql)->result();


		$data['heading1'] = 'Monthly Status';
		$data['nav1'] = ($this->currentUserGroup[0]->name == 'Manager')? 'Manager' : 'GEW Employee';

		$data['currentUser'] = $this->currentUser;
		$data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page'] = 'report/monthly'; // views/display.php page
        $this->load->view('manager_layout', $data);
	}


	public function getCurrentMonthDates()
	{
		$year = date('Y');
		$dates = array();

		date("L", mktime(0,0,0, 7,7, $year)) ? $days = 366 : $days = 365;
		for($i = 1; $i <= $days; $i++)
		{
			$month = date('m', mktime(0,0,0,1,$i,$year));
			$wk = date('W', mktime(0,0,0,1,$i,$year));
			$wkDay = date('D', mktime(0,0,0,1,$i,$year));
			$day = date('d', mktime(0,0,0,1,$i,$year));

			$dates[$month][$wk][$wkDay] = $day;
		}

		return $dates[date('m')];
	}

	public function add($task_id = 0)
	{
		if (empty($task_id))
		{
			redirect(base_url(''));
		}
		$this->load->library('form_validation');

		$sql = "SELECT T.*, D.c_name, assignee.first_name as given, reporter.first_name as follow FROM `tasks` AS T LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter LEFT JOIN departments AS D ON D.cid = T.department_id WHERE T.tid = ?";
		$data['task'] = $this->db->query($sql, array($task_id))->row();

		if (empty($data['task']))
		{
			redirect(base_url(''));
		}

		$sql = "SELECT * FROM `reports` WHERE task_id = ? AND DATE(created_at) = CURDATE()";
		$data['alreadReported'] = $this->db->query($sql, array($task_id))->row();

		$data['heading1'] = 'Task from';
		$data['nav1'] = 'GEW Employee';
		//$data['task_code'] = $this->generateRandomString(4);
		//select all department
		//$data['departments'] = $this->getDepartments();
		//select all employees
		//$data['employees'] = $this->getUsers('Employee');

		$data['currentUser'] = $this->currentUser;
		$data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page'] = 'report/add'; // views/task/add.php page
        $this->load->view('manager_layout', $data);
	}

	public function save()
	{
		$task_id = $this->input->post('task_id');
		//server validation
		$data = array(
			'task_id' => $this->input->post('task_id'),
			'berfore' => $this->input->post('befor'),
			'after' => $this->input->post('after'),
			'status' => $this->input->post('status')
		);

		$this->db->insert('reports', $data);
		//get task id and upload files

		redirect(base_url('report/history/'.$task_id));
	}

	public function history($task_id = 0)
	{
		if (empty($task_id))
		{
			redirect(base_url(''));
		}
		$this->load->library('form_validation');

		$sql = "SELECT T.*, D.c_name, assignee.first_name as given, reporter.first_name as follow FROM `tasks` AS T LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter LEFT JOIN departments AS D ON D.cid = T.department_id WHERE T.tid = ?";
		$data['task'] = $this->db->query($sql, array($task_id))->row();

		$sql = "SELECT * FROM reports WHERE task_id = ?";
		$data['taskHistory'] = $this->db->query($sql, array($task_id))->result();

		if (empty($data['task']))
		{
			redirect(base_url(''));
		}

		$data['heading1'] = 'Task History';
		$data['nav1'] = 'GEW Employee';

		$data['currentUser'] = $this->currentUser;
		$data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page'] = 'report/history'; // views/task/add.php page
        $this->load->view('manager_layout', $data);
	}
}
