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
    }

    public function index()
    {

        //$sql = "SELECT T.*, D.c_name FROM `tasks` AS T LEFT JOIN departments AS D on D.cid = T.department_id ORDER BY T.t_created_at ASC";
        $view = !empty($this->input->get('view')) ? $this->input->get('view') : "daily";
        $employee_id = !empty($this->input->get('employee_id')) ? $this->input->get('employee_id') : false;
        
        $this->db->select('*');
        $this->db->from('tasks');
        $this->db->join('departments', 'departments.cid = tasks.department_id');
        
        switch ($view) {
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
        }

        if ($employee_id) {
            $this->db->where('tasks.assignee', $employee_id);
        }
        
        if ($this->currentUserGroup[0]->name == "Employee") {
            $this->db->where('tasks.assignee', $this->currentUser->id);
        }

        $tasks = $this->db->get()->result();
        
        $data['tasks'] = $tasks;

        $this->db->select(array(
            "tasks.parent_id as type",
            "count(tasks.parent_id) as total"
        ));
        $this->db->from("tasks");
        
        if ($employee_id) {
            $this->db->where('tasks.assignee', $employee_id);
        }
        
        if ($this->currentUserGroup[0]->name == "Employee") {
            $this->db->where('tasks.assignee', $this->currentUser->id);
        }

        $this->db->group_by("tasks.parent_id");
        $tasks_count = $this->db->get()->result_array();
        
        //dd($tasks_count, false);
        $data["tasks_count"] = $tasks_count;

        $data['heading1'] = 'Task Listing';
        $data['nav1'] = $this->currentUserGroup[0]->name;
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
            $end_date = date("Y-m-d H:i:s", strtotime($end_date) );
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
            'created_by'      => $this->currentUser->id
        );

        $this->db->insert('tasks', $data);
        $task_id = $this->db->insert_id();

        //get task id and upload files

        if( !empty($_FILES["files"]) ) {

            $upload_path                = "uploads/tasks";

            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            $config['upload_path']      = $upload_path;
            $config['allowed_types']    = 'gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp|';

            $this->load->library('upload', $config);

            $file_count = 0;
            $file_ids   = array();

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
        /*$sql = "SELECT T.*, D.c_name FROM `tasks` AS T LEFT JOIN departments AS D on D.cid = T.department_id WHERE T.assignee = ?";
        $data['tasks'] = $this->db->query($sql, $this->currentUser->id)->result();*/

        $view = !empty($this->input->get('view')) ? $this->input->get('view') : "daily";

        $this->db->select('*');
        $this->db->from('tasks');
        $this->db->join('departments', 'departments.cid = tasks.department_id');
        $this->db->where('tasks.assignee', $this->currentUser->id);

        switch ($view) {
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
        }

        $tasks = $this->db->get()->result();
    // Counting Task    
         $this->db->select(array(
            "tasks.parent_id as type",
            "count(tasks.parent_id) as total"
        ));
        $this->db->from("tasks");
        
        $this->db->where('tasks.assignee', $this->currentUser->id);

        $this->db->group_by("tasks.parent_id");
        $tasks_count = $this->db->get()->result_array();
        $data["tasks_count"] = $tasks_count;
        
        
        
        foreach ($tasks as $key => $task) {

            $reported = $this->db->query("SELECT * FROM `reports` WHERE task_id ={$task->tid} AND user_id = {$this->currentUser->id} AND DATE(created_at) = CURDATE()")->result_array();
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
}
