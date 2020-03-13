<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Task extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        if (!$this->aauth->is_loggedin()) {
            redirect(base_url('/'));
        }

        $this->currentUser = $this->aauth->get_user();
        $this->currentUserGroup = $this->aauth->get_user_groups();
        
        $this->load->helper(array('form', 'url', 'file','directory', 'date'));
        $this->load->library(array( 'user_agent', 'email' ));
    }

    public function index()
    {

        //$sql = "SELECT T.*, D.c_name FROM `tasks` AS T LEFT JOIN departments AS D on D.cid = T.department_id ORDER BY T.t_created_at ASC";

        //$view = !empty($this->input->get('view')) ? $this->input->get('view') : "daily";
        $employee_id = !empty($this->input->get('employee_id')) ? $this->input->get('employee_id') : false;

        $employee_id = false;

        if( !empty($this->input->get('employee_id')) ) {
            $employee_id = $this->input->get('employee_id');
        }

        if( $this->currentUserGroup[0]->name == "Employee" ) {
            $employee_id = $this->currentUser->id;
        }
        
        $this->db->select('*');
        $this->db->from('tasks');
        $this->db->join('departments', 'departments.cid = tasks.department_id', 'left');

        if ($employee_id) {
            $this->db->where('tasks.assignee', $employee_id);
        }
        
        if ($this->currentUserGroup[0]->name == "Employee") {
            $this->db->where('tasks.assignee', $this->currentUser->id);
        }

        if( $this->currentUserGroup[0]->name == "Manager" && $this->currentUser->cur_loc == "Fujairah" ) {
            $this->db->join('aauth_users', 'tasks.assignee = aauth_users.id');
            $this->db->where('aauth_users.cur_loc', "Fujairah");
        }
        
        /*switch ($view) {
            case "daily":
                $this->db->where('tasks.parent_id', 1);
                break;
            case "weekly":
                $this->db->where('tasks.parent_id', 2);
                break;
            case "monthly":
                $this->db->where('tasks.parent_id', 3);
                break;
            case "one-time":
                $this->db->where('tasks.parent_id', 4);
                break;
            default:
                $this->db->where('tasks.parent_id', 1);
                break;
        }*/

        //type filter start here 
        if( isset($_GET["type"]) && !empty($_GET["type"]) ) {
            if( $_GET["type"] == 99 ) {
                //$this->db->where('tasks.parent_id', $_GET["type"]);
            } else {
                $this->db->where('tasks.parent_id', $_GET["type"]);
            }
        } else {
            $this->db->where('tasks.parent_id', 1);
        }

        // date filters start
        if( isset($_GET["month"]) && !empty($_GET["month"]) ) {
            list( $year, $month )   =   explode("-", $_GET["month"]);

            $date = new DateTime( $year . '-' . $month );
            $date->modify('last day of this month');
            $full_date = $date->format('Y-m-d 23:59:59');

            //$this->db->where('MONTH(tasks.t_created_at)', $month);
            $this->db->where('tasks.t_created_at <= ', $full_date);
        }

        // status filter starts
        if (!isset($_GET["status"])) {
            $this->db->where_in('tasks.t_status', array( 'hold', 'in-progress' ) );
        } 
        else if (isset($_GET["status"]) && empty($_GET["status"])) {
            $this->db->where_in('tasks.t_status', array( 'hold',  'in-progress' ) );
        }
        else if (isset($_GET["status"]) && !empty($_GET["status"]) && $_GET["status"] != "all" ) {
            $this->db->where_in('tasks.t_status', array( $_GET["status"] ) );
        }
        else if (isset($_GET["status"]) && !empty($_GET["status"]) && $_GET["status"] == "all" ) {
            $this->db->where('tasks.t_status != ', "");
        }
        else {
            $this->db->where_in('tasks.t_status', array( 'hold', 'in-progress' ) );
        }



        $data["month_arg"] = isset($_GET["month"]) ? $_GET["month"] : "";

        $this->db->order_by('tasks.last_updated', 'DESC');

        if(  isset($_GET["testing"])) {
            $sql = $this->db->get_compiled_select();
            dd($sql);
        }
        
        $tasks = $this->db->get()->result();

        $data['tasks'] = $tasks;

        // Counting Task
        $daily = $weekly = $monthly = $one_time = 0;
        foreach ($tasks as $task) {
            if( $task->parent_id == 1 ) {
                $daily++;
            }

            if( $task->parent_id == 2 ) {
                $weekly++;
            }

            if( $task->parent_id == 3 ) {
                $monthly++;
            }

            if( $task->parent_id == 4 ) {
                $one_time++;
            }

        }
        
        $tasks_count = array(
            "daily"     =>  $daily,
            "weekly"    =>  $weekly,
            "monthly"   =>  $monthly,
            "one_time"  =>  $one_time
        );
        //dd($tasks_count);

        $data["tasks_count"] = $tasks_count;

        //select all department
        $data['departments'] = $this->getDepartments();
        //select all employees
        $data['employees'] = $this->getUsers('Employee');

        $data['heading1'] = 'Task Listing';
        $data['nav1'] = $this->currentUserGroup[0]->name;
        $data['users'] = $this->db->get("aauth_users")->result_array();
        $data['currentUser'] = $this->currentUser;
        $data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page'] = 'task/list'; // views/display.php page
        $this->load->view('manager_layout', $data);
    }


    public function delete( $task_id ) {
        $this->db->where('tid', $task_id)->delete("tasks");
        redirect( base_url('/task') );
    }

    public function add()
    {
        
        $this->load->library('form_validation');

        $data['heading1'] = 'Task from';
        $data['nav1'] = $this->currentUserGroup[0]->name;
        $data['task_code'] = $this->generateRandomString(4);
        //select all department
        $data['departments'] = $this->getDepartments();
        //select all employees
        $data['employees'] = $this->getUsers('Employee');


        //dd(str_pad(555, 4, '0', STR_PAD_LEFT));
        $sql = "SELECT tid FROM `tasks` ORDER BY `tasks`.`tid`  DESC LIMIT 0, 1";
        $last_task_id = $this->db->query($sql)->result_array();
        
        $last_task_id = str_pad($last_task_id[0]["tid"], 4, '0', STR_PAD_LEFT);
        $data["last_task_id"] = $last_task_id + 1;

        $employee_id = "";
        if ($this->currentUserGroup[0]->name == "Employee") {
            $employee_id = $this->currentUserGroup[0]->user_id;
        } else {
            $employee_id = isset($_GET["employee_id"]) && !empty($_GET["employee_id"]) ? $_GET["employee_id"] : "";
        }

        if (!empty($employee_id)) {
            $data[ 'employee_user' ] = $this->aauth->get_user($employee_id);
        }

        $data['employee_id'] = $employee_id;

        $data['currentUser'] = $this->currentUser;
        $data['currentUserGroup'] = $this->currentUserGroup[0]->name;

        $data['inc_page'] = 'task/add'; // views/task/add.php page
        $this->load->view('manager_layout', $data);
    }

    public function save() {

        if( !empty( $this->input->post('start_date') ) ) {
            $start_date_arr = explode("/", $this->input->post('start_date'));
            $start_date = $start_date_arr[0] . '-' . $start_date_arr[1] . '-' . $start_date_arr[2];
            $start_date = date("Y-m-d H:i:s", strtotime($start_date) );
        } else {
            $start_date = date("Y-m-d H:i:s", time() );
        }


        if( !empty( $this->input->post('end_date') ) ) {
            $end_date_arr = explode("/", $this->input->post('end_date'));
            $end_date = $end_date_arr[0] . '-' . $end_date_arr[1] . '-' . $end_date_arr[2];
            $end_date = date("Y-m-d 23:59:59", strtotime($end_date) );
        } else {
            //$end_date = date("Y-m-d H:i:s", mktime(0,0,0,12,31,date('Y') ));
            $end_date = "";
        }

        //server validation
        $data = array(
            't_title'         => $this->input->post('title'),
            't_code'          => $this->input->post('code'),
            'department_id'   => $this->input->post('department'),
            'parent_id'       => $this->input->post('parentId'),
            'assignee'        => $this->currentUserGroup[0]->name == "Employee" ? $this->currentUserGroup[0]->user_id : $this->input->post('assignee'),
            'reporter'        => $this->input->post('reporter'),
            'given_by'        => $this->input->post('given_by'),
            'attachment_id'   => 0,
            't_description'   => $this->input->post('description'),
            'start_date'      => $start_date,
            'end_date'        => $end_date,
            'created_by'      => $this->currentUser->id,
            't_status'        => "in-progress"
        );

        $this->db->insert('tasks', $data);
        $task_id = $this->db->insert_id();

        //get task id and upload files
        $file_ids   = array();
        if( !empty($_FILES["files"]) ) {

            $upload_path                = "uploads/tasks/task-{$task_id}";

            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            $config['upload_path']      = $upload_path;
            $config['allowed_types']    = 'gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp|';

            $this->load->library('upload', $config);

            $file_count = 0;

            foreach ($_FILES["files"] as $key => $file) {

                if( empty($file) || !isset($_FILES['files']['name'][$file_count])) {
                    continue;
                }
                
                $_FILES['attachments[]']['name']        = $_FILES['files']['name'][$file_count];
                $_FILES['attachments[]']['type']        = $_FILES['files']['type'][$file_count];
                $_FILES['attachments[]']['tmp_name']    = $_FILES['files']['tmp_name'][$file_count];
                $_FILES['attachments[]']['error']       = $_FILES['files']['error'][$file_count];
                $_FILES['attachments[]']['size']        = $_FILES['files']['size'][$file_count];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('attachments[]')) {

                    $file_data              = $this->upload->data();
                    $new_file['f_title']    = $file_data["client_name"];
                    $new_file['url']        = base_url("/{$upload_path}/{$file_data["file_name"]}");
                    $new_file['type']       = $file_data["file_type"];
                    $new_file['status']     = 0;
                    $new_file['is_deleted'] = 0;
                    $new_file['post_id']    = $task_id;
                    $new_file['post_type']  = "task";

                    $this->db->insert("files", $new_file);
                    $file_id = $this->db->insert_id();
                    $file_ids[] = $file_id;
                }
                
                $file_count++;
            }
        }

        $this->sent_assigned_email( compact('data', 'task_id', 'file_ids') );

        if ($this->currentUserGroup[0]->name == "Employee") {
            redirect(base_url('task/alert'));
        } else {
            redirect(base_url('task'));
        }
        
    }

    public function add_future_task() {
        $data = array();

        $sql                        = "SELECT tid FROM `tasks` ORDER BY `tasks`.`tid`  DESC LIMIT 0, 1";
        $last_task_id               = $this->db->query($sql)->result_array();
        
        $last_task_id               = str_pad($last_task_id[0]["tid"], 4, '0', STR_PAD_LEFT);
        $data["last_task_id"]       = $last_task_id + 1;

        //select all department
        $data['departments']        = $this->getDepartments();

        //select all employees
        $data['employees']          = $this->getUsers('Employee');
        $data['heading1']           = 'Add Future Task';
        $data['nav1']               = $this->currentUserGroup[0]->name;
        $data['task_code']          = $this->generateRandomString(4);
        $data['currentUser']        = $this->currentUser;
        $data['currentUserGroup']   = $this->currentUserGroup[0]->name;

        $data['inc_page']           = 'task/add_future_task';

        $this->load->view('manager_layout', $data);
    }

    public function save_future_task() {

        if( !empty( $this->input->post('start_date') ) ) {
            $start_date_arr = explode("/", $this->input->post('start_date'));
            $start_date = $start_date_arr[0] . '-' . $start_date_arr[1] . '-' . $start_date_arr[2];
            $start_date = date("Y-m-d H:i:s", strtotime($start_date) );
        } else {
            $start_date = date("Y-m-d H:i:s", time() );
        }


        if( !empty( $this->input->post('end_date') ) ) {
            $end_date_arr = explode("/", $this->input->post('end_date'));
            $end_date = $end_date_arr[0] . '-' . $end_date_arr[1] . '-' . $end_date_arr[2];
            $end_date = date("Y-m-d 23:59:59", strtotime($end_date) );
        } else {
            //$end_date = date("Y-m-d H:i:s", mktime(0,0,0,12,31,date('Y') ));
            $end_date = "";
        }

         //server validation
        $data = array(
            't_title'         => $this->input->post('title'),
            't_code'          => $this->input->post('code'),
            'department_id'   => $this->input->post('department'),
            'parent_id'       => $this->input->post('parentId'),
            'assignee'        => $this->currentUserGroup[0]->name == "Employee" ? $this->currentUserGroup[0]->user_id : $this->input->post('assignee'),
            'reporter'        => $this->input->post('reporter'),
            'given_by'        => $this->input->post('given_by'),
            'attachment_id'   => 0,
            't_description'   => $this->input->post('description'),
            'start_date'      => $start_date,
            'end_date'        => $end_date,
            'created_by'      => $this->currentUser->id,
            't_status'        => "pending"
        );
        
        $this->db->insert('tasks', $data);
        $task_id = $this->db->insert_id();

        //get task id and upload files
        $file_ids   = array();
        if( !empty($_FILES["files"]) ) {

            $upload_path                = "uploads/tasks/task-{$task_id}";

            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            $config['upload_path']      = $upload_path;
            $config['allowed_types']    = 'gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp|';

            $this->load->library('upload', $config);

            $file_count = 0;

            foreach ($_FILES["files"] as $key => $file) {

                if( empty($file) || !isset($_FILES['files']['name'][$file_count])) {
                    continue;
                }
                
                $_FILES['attachments[]']['name']        = $_FILES['files']['name'][$file_count];
                $_FILES['attachments[]']['type']        = $_FILES['files']['type'][$file_count];
                $_FILES['attachments[]']['tmp_name']    = $_FILES['files']['tmp_name'][$file_count];
                $_FILES['attachments[]']['error']       = $_FILES['files']['error'][$file_count];
                $_FILES['attachments[]']['size']        = $_FILES['files']['size'][$file_count];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('attachments[]')) {

                    $file_data              = $this->upload->data();
                    $new_file['f_title']    = $file_data["client_name"];
                    $new_file['url']        = base_url("/{$upload_path}/{$file_data["file_name"]}");
                    $new_file['type']       = $file_data["file_type"];
                    $new_file['status']     = 0;
                    $new_file['is_deleted'] = 0;
                    $new_file['post_id']    = $task_id;
                    $new_file['post_type']  = "task";

                    $this->db->insert("files", $new_file);
                    $file_id = $this->db->insert_id();
                    $file_ids[] = $file_id;
                }
                
                $file_count++;
            }
        }


        redirect( add_query_arg( 'message', 'task_saved', base_url('task')) );
    }

    public function assign()
    {
        
        extract($_POST);
        $task = $this->db->select('*')->from('tasks')->where('tid', $task_id)->get()->row();
        //dd($task);

        if( !empty( $this->input->post('start_date') ) ) {
            $start_date_arr = explode("/", $this->input->post('start_date'));
            $start_date = $start_date_arr[0] . '-' . $start_date_arr[1] . '-' . $start_date_arr[2];
            $start_date = date("Y-m-d H:i:s", strtotime($start_date) );
        } else {
            $start_date = date("Y-m-d H:i:s", time() );
        }


        if( !empty( $this->input->post('end_date') ) ) {
            $end_date_arr = explode("/", $this->input->post('end_date'));
            $end_date = $end_date_arr[0] . '-' . $end_date_arr[1] . '-' . $end_date_arr[2];
            $end_date = date("Y-m-d 23:59:59", strtotime($end_date) );
        } else {
            //$end_date = date("Y-m-d H:i:s", mktime(0,0,0,12,31,date('Y') ));
            $end_date = "";
        }

        //server validation
        $data = array(
            't_title'         => $this->input->post('title'),
            't_code'          => $this->input->post('code'),
            'department_id'   => $this->input->post('department'),
            'parent_id'       => $this->input->post('parentId'),
            'assignee'        => $this->currentUserGroup[0]->name == "Employee" ? $this->currentUserGroup[0]->user_id : $this->input->post('assignee'),
            'reporter'        => $this->input->post('reporter'),
            'given_by'        => $this->input->post('given_by'),
            'attachment_id'   => 0,
            't_description'   => nl2br( $this->input->post('description') ),
            'start_date'      => $start_date,
            'end_date'        => $end_date,
            'created_by'      => $this->currentUser->id,
            't_status'        => "in-progress"
        );

        //dd($data);

        $this->db->where('tid', $task_id);
        $this->db->update('tasks', $data);

        //get task id and upload files
        $file_ids   = array();
        if( !empty($_FILES["files"]) ) {

            $upload_path                = "uploads/tasks/task-{$task_id}";

            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            $config['upload_path']      = $upload_path;
            $config['allowed_types']    = 'gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|avi|mpeg|mp3|mp4|3gp|';

            $this->load->library('upload', $config);

            $file_count = 0;

            foreach ($_FILES["files"] as $key => $file) {

                if( empty($file) || !isset($_FILES['files']['name'][$file_count])) {
                    continue;
                }
                
                $_FILES['attachments[]']['name']        = $_FILES['files']['name'][$file_count];
                $_FILES['attachments[]']['type']        = $_FILES['files']['type'][$file_count];
                $_FILES['attachments[]']['tmp_name']    = $_FILES['files']['tmp_name'][$file_count];
                $_FILES['attachments[]']['error']       = $_FILES['files']['error'][$file_count];
                $_FILES['attachments[]']['size']        = $_FILES['files']['size'][$file_count];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('attachments[]')) {

                    $file_data              = $this->upload->data();
                    $new_file['f_title']    = $file_data["client_name"];
                    $new_file['url']        = base_url("/{$upload_path}/{$file_data["file_name"]}");
                    $new_file['type']       = $file_data["file_type"];
                    $new_file['status']     = 0;
                    $new_file['is_deleted'] = 0;
                    $new_file['post_id']    = $task_id;
                    $new_file['post_type']  = "task";

                    $this->db->insert("files", $new_file);
                    $file_id = $this->db->insert_id();
                    $file_ids[] = $file_id;
                }
                
                $file_count++;
            }
        }

        $this->sent_assigned_email( compact('data', 'task_id', 'file_ids') );

        if ($this->currentUserGroup[0]->name == "Employee") {
            redirect(base_url('task/alert'));
        } else {
            redirect(base_url('task'));
        }


    }

    public function history()
    {
        exit('commming soon!');
    }

    public function alert()
    {

        $data['nav1'] = 'GEW Employee';
        /*$sql = "SELECT T.*, D.c_name FROM `tasks` AS T LEFT JOIN departments AS D on D.cid = T.department_id WHERE T.assignee = ?";
        $data['tasks'] = $this->db->query($sql, $this->currentUser->id)->result();*/

        $view = !empty($this->input->get('view')) ? $this->input->get('view') : "daily";


        $this->db->select('*');
        $this->db->from('tasks');
        $this->db->join('departments', 'departments.cid = tasks.department_id');
        $this->db->where('tasks.assignee', $this->currentUser->id);

        /* switch ($view) {
            case "daily":
                $this->db->where('tasks.parent_id', 1);
                break;

            case "weekly":
                $this->db->where('tasks.parent_id', 2);
                break;

            case "monthly":
                $this->db->where('tasks.parent_id', 3);
                break;

            case "one-time":
                $this->db->where('tasks.parent_id', 4);
                break;
            
            default:
                $this->db->where('tasks.parent_id', 1);
                break;
		} */

		//type filter start here 
		if (isset($_GET["type"]) && !empty($_GET["type"])) {
			if ($_GET["type"] == 99) {
				//$this->db->where('tasks.parent_id', $_GET["type"]);
			} else {
				$this->db->where('tasks.parent_id', $_GET["type"]);
			}
		} else {
			$this->db->where('tasks.parent_id', 1);
		}

		// date filters start
		if (isset($_GET["month"]) && !empty($_GET["month"])) {
			list($year, $month)   =   explode("-", $_GET["month"]);
			$this->db->where('MONTH(tasks.t_created_at)', $month);
			$this->db->where('YEAR(tasks.t_created_at)', $year);
		}

		// status filter starts
		if (!isset($_GET["status"])) {
			$this->db->where_in('tasks.t_status', array('hold', 'in-progress'));
		} else if (isset($_GET["status"]) && empty($_GET["status"])) {
			$this->db->where_in('tasks.t_status', array('hold',  'in-progress'));
		} else if (isset($_GET["status"]) && !empty($_GET["status"]) && $_GET["status"] != "all") {
			$this->db->where_in('tasks.t_status', array($_GET["status"]));
		} else if (isset($_GET["status"]) && !empty($_GET["status"]) && $_GET["status"] == "all") {
			//$this->db->where('tasks.t_status', "");
		} else {
			$this->db->where_in('tasks.t_status', array('hold', 'in-progress'));
		}



		$data["month_arg"] = isset($_GET["month"]) ? $_GET["month"] : "";

        $this->db->order_by('tasks.t_created_at', 'DESC');

        $tasks = $this->db->get()->result();
        
        // Counting Task    
        
        $daily = $this->db->from("tasks")->select(array("count(tasks.parent_id) as total"))->where(['tasks.assignee' => $this->currentUser->id, "tasks.parent_id" => 1 ])->group_by("tasks.parent_id")->get()->result_array();
        $weekly = $this->db->from("tasks")->select(array("count(tasks.parent_id) as total"))->where(['tasks.assignee' => $this->currentUser->id, "tasks.parent_id" => 2 ])->group_by("tasks.parent_id")->get()->result_array();
        $monthly = $this->db->from("tasks")->select(array("count(tasks.parent_id) as total"))->where(['tasks.assignee' => $this->currentUser->id, "tasks.parent_id" => 3 ])->group_by("tasks.parent_id")->get()->result_array();
        $one_time = $this->db->from("tasks")->select(array("count(tasks.parent_id) as total"))->where(['tasks.assignee' => $this->currentUser->id, "tasks.parent_id" => 4 ])->group_by("tasks.parent_id")->get()->result_array();

        $daily = $this->db->from("tasks")
            ->select(array("count(tasks.parent_id) as total"))
            ->where(["tasks.parent_id" => 1, "tasks.assignee" => $this->currentUser->id ])
            ->join('departments', 'departments.cid = tasks.department_id')
            ->group_by("tasks.parent_id")
            ->get()->result_array();
        
        $weekly = $this->db->from("tasks")
            ->select(array("count(tasks.parent_id) as total"))
            ->where(["tasks.parent_id" => 2, "tasks.assignee" => $this->currentUser->id ])
            ->join('departments', 'departments.cid = tasks.department_id')
            ->group_by("tasks.parent_id")
            ->get()->result_array();
        $monthly = $this->db->from("tasks")
            ->select(array("count(tasks.parent_id) as total"))
            ->where(["tasks.parent_id" => 3, "tasks.assignee" => $this->currentUser->id ])
            ->join('departments', 'departments.cid = tasks.department_id')
            ->group_by("tasks.parent_id")
            ->get()->result_array();
        $one_time = $this->db->from("tasks")
            ->select(array("count(tasks.parent_id) as total"))
            ->where(["tasks.parent_id" => 4, "tasks.assignee" => $this->currentUser->id ])
            ->join('departments', 'departments.cid = tasks.department_id')
            ->group_by("tasks.parent_id")
            ->get()->result_array();
        
        $tasks_count = array(
            "daily"     =>  $daily,
            "weekly"    =>  $weekly,
            "monthly"   =>  $monthly,
            "one_time"  =>  $one_time
        );
        
        $data["tasks_count"] = $tasks_count;
        
        $currnet_date = date( 'Y-m-d', time() );

        //dd( $this->db->query('SELECT CURDATE()')->result_array() );
        foreach ($tasks as $key => $task) {

            //$reported = $this->db->query("SELECT * FROM `reports` WHERE task_id ={$task->tid} AND user_id = {$this->currentUser->id} AND DATE(created_at) = CURDATE()")->result_array();

            $query = "SELECT * FROM `reports` WHERE task_id = {$task->tid} AND user_id = {$this->currentUser->id} AND created_at LIKE '{$currnet_date}%'";
            $reported = $this->db->query( $query )->result_array();

            if (!empty($reported) && isset($reported[0])) {
                $task->reported = true;
            } else {
                $task->reported = false;
            }

            $files = $task_files = array();

            $this->db->select('*');
            $this->db->from('files');
            $this->db->where('files.fid', $task->attachment_id);
            $files = $this->db->get()->result_array();

            $this->db->select('*');
            $this->db->from('files');
            $this->db->where('files.post_id', $task->tid);
            $task_files = $this->db->get()->result_array();

            $final_files = array_merge($files, $task_files);
            $task->files = $final_files;

        }

        $data['tasks'] = $tasks;

        $data['heading1'] = 'EMPLOYEE CODE <h5>GEW - '.$this->currentUser->username.'</h5>';
        $data['nav1'] = $this->currentUserGroup[0]->name;

        $data['currentUser'] = $this->currentUser;
        $data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['users'] = $this->db->get("aauth_users")->result_array();
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

    public function getUsers($group)
    {
        $sql = "SELECT users.id, users.first_name, users.last_name FROM `aauth_groups` AS grp LEFT JOIN aauth_user_to_group AS grpusr ON grp.id = grpusr.group_id LEFT JOIN aauth_users AS users ON users.id = grpusr.user_id WHERE `name` = ?";
        //$res = $this->db->query($sql, array($group))->result();
        //echo $this->db->last_query();

        $this->db->select('aauth_users.id, aauth_users.first_name, aauth_users.last_name');
        $this->db->from('aauth_users');
        $this->db->join('aauth_user_to_group', 'aauth_users.id = aauth_user_to_group.user_id');
        $this->db->join('departments', 'departments.cid = aauth_users.dept_id', 'left');
        $this->db->where('aauth_user_to_group.group_id', 3);
        if( $this->currentUserGroup[0]->name == "Manager" && $this->currentUser->cur_loc == "Fujairah" ) {
            $this->db->where('aauth_users.cur_loc', "Fujairah");
        }

        $employees = $this->db->get()->result();
        
        return $employees;
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
        if (!empty($task_id)) {
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

    public function resume_submit() {

        if( !empty( $this->input->post('end_date') ) ) {
            $end_date_arr = explode("/", $this->input->post('end_date'));
            $end_date = $end_date_arr[0] . '-' . $end_date_arr[1] . '-' . $end_date_arr[2];
            $end_date = date("Y-m-d 23:59:59", strtotime($end_date) );
        } else {
            $end_date = "";
        }

        $this->db->set('end_date', $end_date);
        $this->db->set('t_status', "in-progress");

        $this->db->where('tid', $this->input->post("task_id"));
        $this->db->update('tasks');

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
            redirect('/task/alert', $this->agent->referrer() );
           
        }
        else
        {
            redirect(add_query_arg( array("status"=>"success", "msg"=>"task_update"), $this->agent->referrer() ));
        }

        //redirect(add_query_arg( array("status"=>"success", "msg"=>"task_update"), $this->agent->referrer() ));
        //redirect('/task/alert', $this->agent->referrer() );
    }

    public function sent_assigned_email( $data ) {

        $view = $files= array();
        $date_format = $this->config->item('date_format');
        $job_types = array(
            1 => "Daily",
            2 => "Weekly",
            3 => "Monthly",
            4 => "One Time"
        );

        extract($data);

        $assignee           =   $this->aauth->get_user( $data["assignee"] );

        $view["heading"]    =  "A new task has been assigned to you. Please see the details as below:";
        $view["task_title"] =   $data["t_title"];
        $view["task_code"]  =   $data["t_code"];
        $view["task_type"]  =   $job_types[$data["parent_id"]];
        $view["assigned_to"]=   $assignee->first_name ." ". $assignee->last_name;

        if( !empty($data["given_by"]) ) {
            $given_by               =   $this->aauth->get_user( $data["given_by"] );
            $view["assigned_by"]    =   $given_by->first_name ." ". $given_by->last_name;
        } else {
            $created_by             =   $this->aauth->get_user( $data["created_by"] );
            $view["assigned_by"]    =   $created_by->first_name ." ". $created_by->last_name;
        }

        $followup           =   $this->aauth->get_user( $data["reporter"] );
        $view["follow_up"]  =   $followup->first_name ." ". $followup->last_name;

        $department         =   $this->db->from("departments")->where(["cid" => $data["department_id"] ])->select("c_name")->get()->result_array();
        $view["department"] =   $department[0]["c_name"];
        $view["start_date"] =   date( $date_format, strtotime( $data["start_date"] ) );
        $view["end_date"]   =   date( $date_format, strtotime( $data["end_date"] ) );
        $view["status"]     =  "In Progress";

        if( !empty($file_ids) ) {
            $files          = $this->db->from("files")->where_in("fid", $file_ids)->get()->result_array();
            $view["files"]  = $files;
        }
        

        $view["inc_email"]  =  "emails/task_assigned";
        $content = $this->load->view('emails/layout', $view, true);

        $this->load->model( "user" );
        $user_email = $this->user->get_user_email( $assignee );
        
        $this->email->from($this->config->item( "from_email" ), $this->config->item( "from_name" ));
        $this->email->to( $user_email );

        $this->email->subject('New Task Assigned');
        $this->email->message($content);

        $this->email->send();

    }

    public function nov()
    {

        //$sql = "SELECT T.*, D.c_name FROM `tasks` AS T LEFT JOIN departments AS D on D.cid = T.department_id ORDER BY T.t_created_at ASC";


        $view = !empty($this->input->get('view')) ? $this->input->get('view') : "daily";
        $employee_id = !empty($this->input->get('employee_id')) ? $this->input->get('employee_id') : false;

        $employee_id = false;

        if( !empty($this->input->get('employee_id')) ) {
            $employee_id = $this->input->get('employee_id');
        }

        if( $this->currentUserGroup[0]->name == "Employee" ) {
            $employee_id = $this->currentUser->id;
        }
        
        $this->db->select('*');
        $this->db->from('tasks_nov');
        $this->db->join('departments', 'departments.cid = tasks_nov.department_id');
        
        switch ($view) {
            case "daily":
                $this->db->where('tasks_nov.parent_id', 1);
                break;
            case "weekly":
                $this->db->where('tasks_nov.parent_id', 2);
                break;
            case "monthly":
                $this->db->where('tasks_nov.parent_id', 3);
                break;
            case "one-time":
                $this->db->where('tasks_nov.parent_id', 4);
                break;
            default:
                $this->db->where('tasks_nov.parent_id', 1);
                break;
        }

        if ($employee_id) {
            $this->db->where('tasks_nov.assignee', $employee_id);
        }
        
        if ($this->currentUserGroup[0]->name == "Employee") {
            $this->db->where('tasks_nov.assignee', $this->currentUser->id);
        }

        if( $this->currentUserGroup[0]->name == "Manager" && $this->currentUser->cur_loc == "Fujairah" ) {
            $this->db->join('aauth_users', 'tasks_nov.assignee = aauth_users.id');
            $this->db->where('aauth_users.cur_loc', "Fujairah");
        }
        
        $tasks = $this->db->get()->result();

        $data['tasks'] = $tasks;

        // Counting Task
        $daily = $weekly = $monthly = $one_time = 0;
        foreach ($tasks as $task) {
            if( $task->parent_id == 1 ) {
                $daily++;
            }

            if( $task->parent_id == 2 ) {
                $weekly++;
            }

            if( $task->parent_id == 3 ) {
                $monthly++;
            }

            if( $task->parent_id == 4 ) {
                $one_time++;
            }

        }
        
        $tasks_count = array(
            "daily"     =>  $daily,
            "weekly"    =>  $weekly,
            "monthly"   =>  $monthly,
            "one_time"  =>  $one_time
        );
        
        $data["tasks_count"] = $tasks_count;

        $data['heading1'] = 'Task Listing';
        $data['nav1'] = $this->currentUserGroup[0]->name;
        $data['users'] = $this->db->get("aauth_users")->result_array();
        $data['currentUser'] = $this->currentUser;
        $data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page'] = 'task/list_nov'; // views/display.php page
        $this->load->view('manager_layout', $data);
    }
}
