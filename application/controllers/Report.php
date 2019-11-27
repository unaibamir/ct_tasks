<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        if (!$this->aauth->is_loggedin()) {
            redirect(base_url(''));
        }
        $this->currentUser = $this->aauth->get_user();
        $this->currentUserGroup = $this->aauth->get_user_groups();
        

        $this->load->helper(array('form', 'url', 'file', 'directory'));
    }

    public function daily()
    {

        $data["selected_task"] = isset($_GET["task_id"]) && !empty($_GET["task_id"]) ? $_GET["task_id"] : "" ;
        $data["selected_date"] = isset($_GET["report_date"]) && !empty($_GET["report_date"]) ? $_GET["report_date"] : "" ;


        $this->db->select('*');
        $this->db->from('reports');

        if (isset($_GET["employee_id"]) && !empty($_GET["employee_id"])) {
            $this->db->where('user_id', $_GET["employee_id"]);
        }

        if ($this->currentUserGroup[0]->name == "Employee") {
            $this->db->where('user_id', $this->currentUser->id);
        }

        if (!empty($data["selected_task"])) {
            $this->db->where('task_id', $data["selected_task"]);
        }

        if (!empty($data["selected_date"])) {
            $this->db->where("DATE(created_at)", date("Y-m-d", strtotime($data["selected_date"])));
        }
        
        /*$query      = $this->db->get_compiled_select();
        dd($query);*/
        
        $reports    = $this->db->get()->result();
        

        if (!empty($reports)) {
            foreach ($reports as $key => $report) {
                $this->db->select('*');
                $this->db->from('tasks');
                $this->db->where('tid', $report->task_id);
                $task = $this->db->get()->row();
                
                $report->task = $task;
            }
        }

        $data['reports'] = $reports;

        $this->db->select('*');
        $this->db->from('tasks');
        if ($this->currentUserGroup[0]->name == "Employee") {
            $this->db->where('assignee', $this->currentUser->id);
        }

        if (isset($_GET["employee_id"]) && !empty($_GET["employee_id"])) {
            $this->db->where('assignee', $_GET["employee_id"]);
        }
        $tasks = $this->db->get()->result();
        $data["tasks"]  =   $tasks;

        if (isset($_GET["employee_id"]) && !empty($_GET["employee_id"]) ) {
            $employee = $this->aauth->get_user($_GET["employee_id"]);
        }

        if( $this->currentUserGroup[0]->name == "Employee" ) {
            $employee = $this->currentUser;
        }

        $data["employee"] = isset($employee) && !empty($employee) ? $employee : false;

        $arr1 = $arr2 = $arr3 = array();

        if( !empty($data["employee"]) ) {
            $arr1 = array(
                "employee"  =>  $data["employee"]->id
            );
        }

        if( isset($_GET["report_date"]) && !empty($_GET["report_date"]) ) {
            $arr2 = array(
                "report_date"  =>  $_GET["report_date"]
            );
        }

        if( isset($_GET["task_id"]) && !empty($_GET["task_id"]) ) {
            $arr3 = array(
                "task_id"  =>  $_GET["task_id"]
            );
        }

        $url_arr = array_merge($arr1, $arr2, $arr3);
        $export_url = base_url( "report/export/daily/?" . http_build_query($url_arr) );
        $data["export_url"] = $export_url;

        $data['users'] = $this->db->get("aauth_users")->result_array();
        $data['heading1'] = 'Daily Job Report View';
        $data['nav1'] = 'GEW Employee';
        $data['nav1'] = ($this->currentUserGroup[0]->name == 'Manager')? 'Manager' : 'GEW Employee';

        $data['currentUser'] = $this->currentUser;
        $data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page'] = 'report/daily_new'; // views/display.php page
        $this->load->view('manager_layout', $data);
    }

    public function getCurrentMonthDates_old()
    {
        $year = date('Y');
        $dates = array();

        date("L", mktime(0, 0, 0, 7, 7, $year)) ? $days = 366 : $days = 365;
        for ($i = 1; $i <= $days; $i++) {
            $month = date('m', mktime(0, 0, 0, 1, $i, $year));
            $wk = date('W', mktime(0, 0, 0, 1, $i, $year));
            $wkDay = date('D', mktime(0, 0, 0, 1, $i, $year));
            $day = date('d', mktime(0, 0, 0, 1, $i, $year));

            $dates[$month][$wk][$wkDay] = $day;
        }

        return $dates[date('m')];
    }

    public function monthly()
    {

        $data['currentUser'] = $this->currentUser;
        $data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        
        $current_month  = date("F");
        $month_dates    = $this->getCurrentMonthDates();

        $data["month_dates"] = $month_dates;

        $sql = "SELECT T.*,
        giver.first_name as giver_f,
        giver.last_name as giver_l,
        assignee.first_name as assignee_f,
        assignee.last_name as assignee_l,
        reporter.first_name as follow_f,
        reporter.last_name as follow_l,
        D.c_name FROM `tasks` AS T
        LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee 
        LEFT JOIN aauth_users AS giver ON giver.id = T.given_by 
        LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter 
        LEFT JOIN departments AS D on D.cid = T.department_id";

        $sql = "SELECT T.*,  
        assignee.first_name as given,
        giver.first_name as given_f,
        giver.last_name as given_l,
        created_by.first_name as created_by_f,
        created_by.last_name as created_by_l,
        assignee.first_name as assignee_f,
        assignee.last_name as assignee_l,
        reporter.first_name as follow, 
        D.c_name FROM `tasks` AS T
		LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee 
		LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter 
        LEFT JOIN aauth_users AS giver ON giver.id = T.given_by 
        LEFT JOIN aauth_users AS created_by ON created_by.id = T.created_by 
		LEFT JOIN departments AS D on D.cid = T.department_id";

        if (isset($_GET["employee_id"]) && !empty($_GET["employee_id"])) {
            $sql .= " WHERE T.assignee = {$_GET["employee_id"]}";
        }

        $tasks = $this->db->query($sql)->result();
        $data['tasks'] = $tasks;


        // Counting Task    
        
        $this->db->from("tasks");
        $this->db->select(array("count(tasks.parent_id) as total"));
        $this->db->where(["tasks.parent_id" => 1 ]);
        if (isset($_GET["employee_id"]) && !empty($_GET["employee_id"])) $this->db->where([ "tasks.assignee" => $_GET["employee_id"] ]);
        if ($this->currentUserGroup[0]->name == "Employee") $this->db->where('tasks.assignee', $this->currentUser->id);
        $this->db->join('departments', 'departments.cid = tasks.department_id');
        $this->db->group_by("tasks.parent_id");
        $daily = $this->db->get()->result_array();

        $this->db->from("tasks");
        $this->db->select(array("count(tasks.parent_id) as total"));
        $this->db->where(["tasks.parent_id" => 2 ]);
        if (isset($_GET["employee_id"]) && !empty($_GET["employee_id"])) $this->db->where([ "tasks.assignee" => $_GET["employee_id"] ]);
        if ($this->currentUserGroup[0]->name == "Employee") $this->db->where('tasks.assignee', $this->currentUser->id);
        $this->db->join('departments', 'departments.cid = tasks.department_id');
        $this->db->group_by("tasks.parent_id");
        $weekly = $this->db->get()->result_array();

        $this->db->from("tasks");
        $this->db->select(array("count(tasks.parent_id) as total"));
        $this->db->where(["tasks.parent_id" => 3 ]);
        if (isset($_GET["employee_id"]) && !empty($_GET["employee_id"])) $this->db->where([ "tasks.assignee" => $_GET["employee_id"] ]);
        if ($this->currentUserGroup[0]->name == "Employee") $this->db->where('tasks.assignee', $this->currentUser->id);
        $this->db->join('departments', 'departments.cid = tasks.department_id');
        $this->db->group_by("tasks.parent_id");
        $monthly = $this->db->get()->result_array();

        $this->db->from("tasks");
        $this->db->select(array("count(tasks.parent_id) as total"));
        $this->db->where(["tasks.parent_id" => 4 ]);
        if (isset($_GET["employee_id"]) && !empty($_GET["employee_id"])) $this->db->where([ "tasks.assignee" => $_GET["employee_id"] ]);
        if ($this->currentUserGroup[0]->name == "Employee") $this->db->where('tasks.assignee', $this->currentUser->id);
        $this->db->join('departments', 'departments.cid = tasks.department_id');
        $this->db->group_by("tasks.parent_id");
        $one_time = $this->db->get()->result_array();
        
        $tasks_count = array(
            "daily"     =>  $daily,
            "weekly"    =>  $weekly,
            "monthly"   =>  $monthly,
            "one_time"  =>  $one_time
        );

        $data["tasks_count"] = $tasks_count;

        
        
        $data["month_date"] = isset($_GET["month"]) && !empty($_GET["month"]) ? $_GET["month"] : date('m');

        $sql_month_date = isset($_GET["month"]) && !empty($_GET["month"]) ? $_GET["month"] : "MONTH(CURRENT_DATE())";

        foreach ($tasks as $key => $task) {
            $sql = "SELECT * FROM `reports` WHERE task_id = '{$task->tid}' AND is_deleted = 0 AND MONTH(created_at) = {$sql_month_date} AND YEAR(created_at) = YEAR(CURRENT_DATE())";
            $report_result = $this->db->query($sql)->result();
            $task->reports = $report_result;
        }
        
        if (isset($_GET["employee_id"]) && !empty($_GET["employee_id"]) ) {
            $employee = $this->aauth->get_user($_GET["employee_id"]);
        }

        if( $this->currentUserGroup[0]->name == "Employee" ) {
            $employee = $this->currentUser;
        }

        $data["employee"] = isset($employee) && !empty($employee) ? $employee : false;

        $arr1 = $arr2 = $arr3 = array();

        if( !empty($data["employee"]) ) {
            $arr1 = array(
                "employee"  =>  $data["employee"]->id
            );
        }

        if( isset($_GET["month"]) && !empty($_GET["month"]) ) {
            $arr2 = array(
                "month"  =>  $_GET["month"]
            );
        }

        $url_arr = array_merge($arr1, $arr2, $arr3);
        $export_url = base_url( "report/export/monthly/?" . http_build_query($url_arr) );
        
        $data["export_url"] = $export_url;

        $data['heading1'] = 'Monthly Status';
        $data['nav1'] = ($this->currentUserGroup[0]->name == 'Manager') ? 'Manager' : 'GEW Employee';

        $data['inc_page'] = 'report/monthly_new';


        $this->load->view('manager_layout', $data);
    }

    public function getCurrentMonthDates()
    {
        $year = date('Y');
        $dates = array();

        date("L", mktime(0, 0, 0, 7, 7, $year)) ? $days = 366 : $days = 365;
        for ($i = 1; $i <= $days; $i++) {
            $month = date('m', mktime(0, 0, 0, 1, $i, $year));
            $wk = date('W', mktime(0, 0, 0, 1, $i, $year));
            $wkDay = date('D', mktime(0, 0, 0, 1, $i, $year));
            $day = date('d', mktime(0, 0, 0, 1, $i, $year));

            $dates[$month][$day] = $wkDay;
        }

        $month_num = isset($_GET["month"]) ? $_GET["month"] : date('m');

        $dates = $dates[ $month_num ];
        return $dates;
    }

    public function add($task_id = 0)
    {
        if (empty($task_id)) {
            redirect(base_url(''));
        }

        $this->load->library('form_validation');

        $sql = "SELECT T.*, D.c_name,
        assignee.first_name as given,
        reporter.first_name as follow FROM `tasks` AS T LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter LEFT JOIN departments AS D ON D.cid = T.department_id WHERE T.tid = ?";

        $sql = "SELECT T.*,
        giver.first_name as given_f,
        giver.last_name as given_l,
        created_by.first_name as created_by_f,
        created_by.last_name as created_by_l,
        assignee.first_name as assignee,
        assignee.last_name as assignee_l,
        reporter.first_name as follow,
        reporter.last_name as follow_l,

        D.c_name FROM `tasks` AS T
        LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee 
        LEFT JOIN aauth_users AS giver ON giver.id = T.given_by 
        LEFT JOIN aauth_users AS created_by ON created_by.id = T.created_by 
        LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter 
        LEFT JOIN departments AS D on D.cid = T.department_id  WHERE T.tid = ?";

        $task = $this->db->query($sql, array($task_id))->row();
        //dd($task);
        $data['task'] = $task;

        if (empty($data['task'])) {
            redirect(base_url(''));
        }

        $this->db->select('*');
        $this->db->from('files');
        $this->db->where('files.fid', $data['task']->attachment_id);
        $files = $this->db->get()->result_array();
        $data['task_files'] = $files;

        $sql = "SELECT * FROM `reports` WHERE task_id = ? AND DATE(created_at) = CURDATE()";
        $data['alreadReported'] = $this->db->query($sql, array($task_id))->row();

        $data["can_submit"] = true;
        $data['heading1'] = 'Task from';
        $data['nav1'] = 'GEW Employee';
        //$data['task_code'] = $this->generateRandomString(4);
        //select all department
        //$data['departments'] = $this->getDepartments();
        //select all employees
        //$data['employees'] = $this->getUsers('Employee');

        $today          = time();
        $start_date     = strtotime($task->start_date);
        $end_date       = !empty( $task->end_date ) ? strtotime($task->end_date) : time() + 86400;

        if ($today > $end_date) {
            $data["can_submit"] = false;
        }
        

        $data['currentUser'] = $this->currentUser;
        $data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page'] = 'report/add'; // views/task/add.php page
        
        $this->load->view('manager_layout', $data);
    }

    public function save()
    {
        
        $reason = !empty($this->input->post('reason')) ? $this->input->post('reason') : "";

        if( !empty($this->input->post('befor')) ) {
            $before = $this->input->post('befor');
        } else {
            $before = $this->config->item( "no_before" );
        }

        if( !empty($this->input->post('after')) ) {
            $after = $this->input->post('after');
        } else {
            $after = $this->config->item( "no_after" );
        }

        $task_id = $this->input->post('task_id');
        //server validation
        $data = array(
            'task_id'   => $this->input->post('task_id'),
            'user_id'   => $this->currentUser->id,
            'berfore'   => $before,
            'after'     => $after,
            'attachment_id' => 0,
            'status'    => $this->input->post('status'),
            'reason'    => $reason
        );

        $this->db->insert('reports', $data);

        $report_id = $this->db->insert_id();
        $task_id = $this->input->post('task_id');
        $status_array = array("H", "C", "F");

        if( !empty($_FILES["report_files"]) ) {

            $upload_path                = "uploads/tasks";

            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            $config['upload_path']      = $upload_path;
            $config['allowed_types']    = 'gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp|';

            $this->load->library('upload', $config);

            $file_count = 0;
            $file_ids   = array();

            foreach ($_FILES["report_files"] as $key => $file) {

                if( empty($file) || !isset($_FILES['report_files']['name'][$file_count])) {
                    continue;
                }
                
                $_FILES['attachments[]']['name']        = $_FILES['report_files']['name'][$file_count];
                $_FILES['attachments[]']['type']        = $_FILES['report_files']['type'][$file_count];
                $_FILES['attachments[]']['tmp_name']    = $_FILES['report_files']['tmp_name'][$file_count];
                $_FILES['attachments[]']['error']       = $_FILES['report_files']['error'][$file_count];
                $_FILES['attachments[]']['size']        = $_FILES['report_files']['size'][$file_count];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('attachments[]')) {

                    $file_data              = $this->upload->data();
                    $new_file['f_title']    = $file_data["client_name"];
                    $new_file['url']        = base_url("/{$upload_path}/{$file_data["file_name"]}");
                    $new_file['type']       = $file_data["file_type"];
                    $new_file['status']     = 0;
                    $new_file['is_deleted'] = 0;
                    $new_file['post_id']    = $report_id;
                    $new_file['post_type']  = "report";

                    $this->db->insert("files", $new_file);
                    $file_id = $this->db->insert_id();
                    $file_ids[] = $file_id;
                }
                
                $file_count++;
            }
        }

        $status = "";
        switch ($this->input->post('status')) {
            case 'Y':
                $status = "in-progress";
                break;

            case 'N':
                $status = "in-progress";
                break;

            case 'H':
                $status = "hold";
                break;

            case 'C':
                $status = "cancelled";
                break;

            case 'F':
                $status = "completed";
                break;
            
            default:
                $status = "";
                break;
        }
        
        $task_data = array(
            "t_status"  =>  $status,
            "t_reason"  =>  $reason,
            "end_date"  =>  $status == "completed" ? date( "Y-m-d H:i:s", time() ) : ""
        );
        
        $this->db->where('tid', $task_id);
        $this->db->update('tasks', $task_data);

        redirect(base_url('task/alert/?status=alert_success'));
        //redirect(base_url('report/history/'.$task_id));
    }

    public function history($task_id = 0)
    {
        if (empty($task_id)) {
            redirect(base_url(''));
        }

        $this->load->library('form_validation');

        /*$sql = "SELECT T.*, 
        D.c_name,
        assignee.first_name as given, 
        assignee.username as user_code, 
        reporter.first_name as follow 
        FROM `tasks` AS T 
        LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee 
        LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter 
        LEFT JOIN departments AS D ON D.cid = T.department_id WHERE T.tid = ?";
        $data['task'] = $this->db->query($sql, array($task_id))->row();*/

         $sql = "SELECT T.*,
        giver.first_name as given_f,
        giver.last_name as given_l,
        created_by.first_name as created_by_f,
        created_by.last_name as created_by_l,
        assignee.first_name as assignee,
        assignee.last_name as assignee_l,
        assignee.username as user_code, 
        reporter.first_name as follow,
        reporter.last_name as follow_l,
        D.c_name,

        D.c_name FROM `tasks` AS T
        LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee 
        LEFT JOIN aauth_users AS giver ON giver.id = T.given_by 
        LEFT JOIN aauth_users AS created_by ON created_by.id = T.created_by 
        LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter 
        LEFT JOIN departments AS D ON D.cid = T.department_id WHERE T.tid = ?";

        $task = $this->db->query($sql, array($task_id))->row();
        //dd($task);
        $data['task'] = $task;

        if (empty($data['task'])) {
            redirect(base_url(''));
        }

        $files = $task_files = array();
        $this->db->select('*');
        $this->db->from('files');
        $this->db->where('files.fid', $data['task']->attachment_id);
        $files = $this->db->get()->result_array();
        
        $this->db->select('*');
        $this->db->from('files');
        $this->db->where('files.post_id', $data['task']->tid);
        $task_files = $this->db->get()->result_array();

        $final_files = array_merge($files, $task_files);

        $data['task_files'] = $final_files;

        /*
        $sql = "SELECT * FROM reports WHERE task_id = ?";
        $task_history = $this->db->query($sql, array($task_id))->result();

        foreach ($task_history as $key => $history) {
            $this->db->select('*');
            $this->db->from('files');
            $this->db->where('files.fid', $history->attachment_id);
            $files = $this->db->get()->result_array();
            $history->files = $files;
        }*/

        if (strpos($data['task']->start_date, '0000-00-00') !== false
            || strpos($data['task']->end_date, '0000-00-00') !== false
            || empty($data['task']->start_date)  ) {
            redirect(base_url('/dashboard/?error'));
        }

        

        $start_date     = new DateTime($data['task']->start_date);
        $end_date       = new DateTime(!empty($data['task']->end_date) ? $data['task']->end_date : date('d-m-Y', time()));
        $end_date       = $end_date->modify("+1 day");


        $period = new DatePeriod($start_date, new DateInterval('P1D'), $end_date);
        $dates = array();
        foreach ($period as $key => $value) {
            $dates[] = $value->format('d-m-Y');
        }
        
        $data["dates"] = $dates;

        $dates_reports = array();

        foreach ($dates as $key => $date) {
            $report_files = '';
            $report = $this->db->select('*')
                        ->from('reports')
                        ->where("task_id", $task_id)
                        ->where("DATE(created_at)", date("Y-m-d", strtotime($date)))
                        ->get()->result();

            $dates_reports[$key]["date"]    = $date;
            $dates_reports[$key]["report"]  = isset($report[0]) && !empty($report[0]) ? $report[0] : new StdClass;

            if (isset($report[0]) && !empty($report[0])) {
                $this->db->select('*');
                $this->db->from('files');
                $this->db->where('files.fid', $report[0]->attachment_id);
                $files = $this->db->get()->result();
                


                $this->db->select('*');
                $this->db->from('files');
                $this->db->where('files.post_id', $report[0]->rid);
                $new_files = $this->db->get()->result();

                $report_files = array_merge($files, $new_files);
                
                $dates_reports[$key]["report"]->files  = isset($report_files) && !empty($report_files) ? $report_files : new StdClass;
            }
        }
        
        $data["dates_reports"] = $dates_reports;
        //dd($data["dates_reports"]);

        $data['heading1'] = 'Task History';
        $data['nav1'] = 'GEW Employee';

        $data['currentUser'] = $this->currentUser;
        $data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page'] = 'report/history'; // views/task/add.php page
        $this->load->view('manager_layout', $data);
    }



    public function export() {

        $type = $this->uri->segment(3);
        if( $type == "monthly" ) {
            $month = isset( $_GET["month"] ) ? $_GET["month"] : date('m');
            if( isset($_GET["employee"]) ) {            
                $this->getEmployeeMonthlyReport( $_GET["employee"], $month );
            } else {
                $this->getFullMonthlyReport( $month );
            }
        }

        if( $type == "daily" ) {
            $this->getDailyReport($_GET);
        }
    }

    public function getEmployeeMonthlyReport( $user_id, $month = "" ) {

        $employee       = $this->aauth->get_user($user_id);
        $current_month  = date("F");
        $month_dates    = $this->getCurrentMonthDates();
        $date_format    = $this->config->item('date_format');

        $job_types = array(
            1 => "Daily",
            2 => "Weekly",
            3 => "Monthly",
            4 => "One Time"
        );

        $sql = "SELECT T.*,
        giver.first_name as giver_f,
        giver.last_name as giver_l,
        reporter.first_name as follow_f,
        reporter.last_name as follow_l,
        D.c_name FROM `tasks` AS T
        LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee 
        LEFT JOIN aauth_users AS giver ON giver.id = T.given_by 
        LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter 
        LEFT JOIN departments AS D on D.cid = T.department_id";

        $sql = "SELECT T.*,  
        assignee.first_name as given,
        giver.first_name as given_f,
        giver.last_name as given_l,
        created_by.first_name as created_by_f,
        reporter.first_name as follow_f,
        reporter.last_name as follow_l,
        created_by.last_name as created_by_l,
        assignee.first_name as assignee_f,
        assignee.last_name as assignee_l,
        reporter.first_name as follow, 
        D.c_name FROM `tasks` AS T
        LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee 
        LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter 
        LEFT JOIN aauth_users AS giver ON giver.id = T.given_by 
        LEFT JOIN aauth_users AS created_by ON created_by.id = T.created_by 
        LEFT JOIN departments AS D on D.cid = T.department_id";

        $sql .= " WHERE T.assignee = {$user_id}";

        //$sql .= " LIMIT 0, 100";
        
        $tasks = $this->db->query($sql)->result();
        

        $month_date = !empty($month) ? $month : date('m');

        $sql_month_date = !empty($month) ? $month : "MONTH(CURRENT_DATE())";
        /*$sql = "SELECT * FROM `reports` WHERE is_deleted = 0 AND MONTH(created_at) = {$sql_month_date} AND YEAR(created_at) = YEAR(CURRENT_DATE())";
        $result = $this->db->query($sql)->result();*/

        foreach ($tasks as $key => $task) {
            $sql = "SELECT * FROM `reports` WHERE task_id = '{$task->tid}' AND is_deleted = 0 AND MONTH(created_at) = {$sql_month_date} AND YEAR(created_at) = YEAR(CURRENT_DATE())";
            $report_result = $this->db->query($sql)->result();
            $task->reports = $report_result;
        }

        //dd($tasks);


        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->setCellValue('A3', 'Task Code');
        $spreadsheet->getActiveSheet()->setCellValue('B3', 'Task Title');
        $spreadsheet->getActiveSheet()->setCellValue('C3', 'Given By');
        $spreadsheet->getActiveSheet()->setCellValue('D3', 'Follow Up');
        $spreadsheet->getActiveSheet()->setCellValue('E3', 'Job Type');
        $spreadsheet->getActiveSheet()->setCellValue('F3', 'Start Date');
        $spreadsheet->getActiveSheet()->setCellValue('G3', 'End Date');
        $spreadsheet->getActiveSheet()->setCellValue('H3', 'Status');

        $header_col = 9;
        $row = 3;
        foreach ($month_dates as $dig => $alpha) {
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow( $header_col, $row, $alpha .'-'. $dig );
            $header_col++;
        }

        $spreadsheet->getActiveSheet()->mergeCells('A1:B1');
        $spreadsheet->getActiveSheet()->setCellValue('A1', "Employee Name:" );
        $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('C1', $employee->first_name . ' ' . $employee->last_name );

        $spreadsheet->getActiveSheet()->mergeCells('F1:G1');
        $spreadsheet->getActiveSheet()->setCellValue('F1', "Employee Code:" );
        $spreadsheet->getActiveSheet()->getStyle("F1")->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('H1', $employee->username );

        $spreadsheet->getActiveSheet()->mergeCells('J1:K1');
        $spreadsheet->getActiveSheet()->setCellValue('J1', "Report Month:" );
        $spreadsheet->getActiveSheet()->getStyle("J1")->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('L1', date( "M, Y" ) );

        $spreadsheet->getActiveSheet()->getStyle("A3:AM3")->getFont()->setBold(true);

        $content_col = 4;

        foreach ($tasks as $key => $task) {
            
            $start_date = date($this->config->item('date_format'), strtotime($task->start_date));
            $end_date = !empty($task->end_date) ? date($this->config->item('date_format'), strtotime($task->end_date)) : "";
            
            $spreadsheet->getActiveSheet()->setCellValue('A' . $content_col , $task->t_code );
            $spreadsheet->getActiveSheet()->setCellValue('B' . $content_col , $task->t_title );

            if( !empty($task->given_f) ) {
                $spreadsheet->getActiveSheet()->setCellValue('C' . $content_col , $task->given_f . ' ' . $task->given_l );
            } else {
                $spreadsheet->getActiveSheet()->setCellValue('C' . $content_col , $task->created_by_f . ' ' . $task->created_by_l );
            }

            $spreadsheet->getActiveSheet()->setCellValue('D' . $content_col , $task->follow_f . ' ' . $task->follow_l );
            $spreadsheet->getActiveSheet()->setCellValue('E' . $content_col , $job_types[$task->parent_id] );
            $spreadsheet->getActiveSheet()->setCellValue('F' . $content_col , $start_date );
            $spreadsheet->getActiveSheet()->setCellValue('G' . $content_col , $end_date );
            $spreadsheet->getActiveSheet()->setCellValue('H' . $content_col , getStatusText($task->t_status) );
            

            $inner_col = 9;
            foreach ($month_dates as $date_dig => $date_alpha) {

                $current_date   = $date_dig . date("/{$month_date}/Y");
                $current_date_2 = strtotime(date($date_dig . "-{$month_date}-Y"));
                $start_date     = strtotime($task->start_date);
                $end_date       = strtotime($task->end_date);
                $output         = "-";

                if( !empty($task->reports) ) {
                    foreach ($task->reports as $report_key => $report) {
                        $report_date    = date($date_format, strtotime($report->created_at));
                        if ($current_date == $report_date) {
                            $output = $report->status;
                            break;
                        }
                    }
                }

                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow( $inner_col, $content_col, $output );
                $inner_col++;
            }
            
            $content_col++;
        }

        $writer = new Xlsx($spreadsheet);
 
        $filename = 'monthly-report-employee-' . $employee->username . substr(time(), 5);
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
    }

    public function getFullMonthlyReport( $month = "" ) {
        
        $data['currentUser']        = $this->currentUser;
        $data['currentUserGroup']   = $this->currentUserGroup[0]->name;
        $current_month  = date("F");
        $month_dates    = $this->getCurrentMonthDates();
        $date_format    = $this->config->item('date_format');

        $job_types = array(
            1 => "Daily",
            2 => "Weekly",
            3 => "Monthly",
            4 => "One Time"
        );

        $sql = "SELECT T.*,  
        assignee.first_name as given,
        giver.first_name as given_f,
        giver.last_name as given_l,
        created_by.first_name as created_by_f,
        reporter.first_name as follow_f,
        reporter.last_name as follow_l,
        created_by.last_name as created_by_l,
        assignee.first_name as assignee_f,
        assignee.last_name as assignee_l,
        reporter.first_name as follow, 
        D.c_name FROM `tasks` AS T
        LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee 
        LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter 
        LEFT JOIN aauth_users AS giver ON giver.id = T.given_by 
        LEFT JOIN aauth_users AS created_by ON created_by.id = T.created_by 
        LEFT JOIN departments AS D on D.cid = T.department_id";

        if( $this->currentUserGroup[0]->name == "Employee" ) {
            $sql .= " WHERE T.assignee = {$this->currentUser->id}";
        }

        $tasks = $this->db->query($sql)->result();

        $month_date = !empty($month) ? $month : date('m');

        $sql_month_date = !empty($month) ? $month : "MONTH(CURRENT_DATE())";

        foreach ($tasks as $key => $task) {
            $sql = "SELECT * FROM `reports` WHERE task_id = '{$task->tid}' AND is_deleted = 0 AND MONTH(created_at) = {$sql_month_date} AND YEAR(created_at) = YEAR(CURRENT_DATE())";
            $report_result = $this->db->query($sql)->result();
            $task->reports = $report_result;
        }

        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->setCellValue('A3', 'Task Code');
        $spreadsheet->getActiveSheet()->setCellValue('B3', 'Task Title');
        $spreadsheet->getActiveSheet()->setCellValue('C3', 'Assigned');
        $spreadsheet->getActiveSheet()->setCellValue('D3', 'Given By');
        $spreadsheet->getActiveSheet()->setCellValue('E3', 'Follow Up');
        $spreadsheet->getActiveSheet()->setCellValue('F3', 'Job Type');
        $spreadsheet->getActiveSheet()->setCellValue('G3', 'Start Date');
        $spreadsheet->getActiveSheet()->setCellValue('H3', 'End Date');
        $spreadsheet->getActiveSheet()->setCellValue('I3', 'Status');

        $header_col = 10;
        $row = 3;
        foreach ($month_dates as $dig => $alpha) {
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow( $header_col, $row, $alpha .'-'. $dig );
            $header_col++;
        }

        $spreadsheet->getActiveSheet()->mergeCells('A1:B1');
        $spreadsheet->getActiveSheet()->setCellValue('A1', "Report Month:" );
        $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('C1', date( "M, Y" ) );

        $spreadsheet->getActiveSheet()->getStyle("A3:AM3")->getFont()->setBold(true);

        $content_col = 4;

        foreach ($tasks as $key => $task) {
            
            $start_date = date($this->config->item('date_format'), strtotime($task->start_date));
            $end_date = !empty($task->end_date) ? date($this->config->item('date_format'), strtotime($task->end_date)) : "";
            
            $spreadsheet->getActiveSheet()->setCellValue('A' . $content_col , $task->t_code );
            $spreadsheet->getActiveSheet()->setCellValue('B' . $content_col , $task->t_title );
            $spreadsheet->getActiveSheet()->setCellValue('C' . $content_col , $task->assignee_f . ' ' . $task->assignee_l );
            if( !empty($task->given_f) ) {
                $spreadsheet->getActiveSheet()->setCellValue('C' . $content_col , $task->given_f . ' ' . $task->given_l );
            } else {
                $spreadsheet->getActiveSheet()->setCellValue('C' . $content_col , $task->created_by_f . ' ' . $task->created_by_l );
            }
            $spreadsheet->getActiveSheet()->setCellValue('E' . $content_col , $task->follow_f . ' ' . $task->follow_l );
            $spreadsheet->getActiveSheet()->setCellValue('F' . $content_col , $job_types[$task->parent_id] );
            $spreadsheet->getActiveSheet()->setCellValue('G' . $content_col , $start_date );
            $spreadsheet->getActiveSheet()->setCellValue('H' . $content_col , $end_date );
            $spreadsheet->getActiveSheet()->setCellValue('I' . $content_col , getStatusText($task->t_status) );
            

            $inner_col = 9;
            foreach ($month_dates as $date_dig => $date_alpha) {

                $current_date   = $date_dig . date("/{$month_date}/Y");
                $current_date_2 = strtotime(date($date_dig . "-{$month_date}-Y"));
                $start_date     = strtotime($task->start_date);
                $end_date       = strtotime($task->end_date);
                $output         = "-";

                if( !empty($task->reports) ) {
                    foreach ($task->reports as $report_key => $report) {
                        $report_date    = date($date_format, strtotime($report->created_at));
                        if ($current_date == $report_date) {
                            $output = $report->status;
                            break;
                        }
                    }
                }

                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow( $inner_col, $content_col, $output );
                $inner_col++;
            }
            
            $content_col++;
        }

        $writer = new Xlsx($spreadsheet);
 
        $filename = 'monthly-report-employee-' . date("M-Y") . substr(time(), 5);
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
    }

    public function getDailyReport($args) {

        $date_format    = $this->config->item('date_format');

        $users = $this->db->get("aauth_users")->result_array();

        $job_types = array(
            1 => "Daily",
            2 => "Weekly",
            3 => "Monthly",
            4 => "One Time"
        );

        $this->db->select('*');
        $this->db->from('reports');

        if (isset($args["employee"]) && !empty($args["employee"])) {
            $this->db->where('user_id', $args["employee"]);
        }

        if (!empty($args["task_id"])) {
            $this->db->where('task_id', $args["task_id"]);
        }

        if (!empty($args["report_date"])) {
            $this->db->where("DATE(created_at)", date("Y-m-d", strtotime($args["report_date"])));
        }
        
        /*$query      = $this->db->get_compiled_select();
        dd($query);*/
        
        $reports    = $this->db->get()->result();
        

        if (!empty($reports)) {
            foreach ($reports as $key => $report) {
                $this->db->select('*');
                $this->db->from('tasks');
                $this->db->where('tid', $report->task_id);
                $task = $this->db->get()->row();
                
                $report->task = $task;
            }
        }

        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->setCellValue('A3', 'Task Code');
        $spreadsheet->getActiveSheet()->setCellValue('B3', 'Task Description');
        $spreadsheet->getActiveSheet()->setCellValue('C3', 'Assigned');
        $spreadsheet->getActiveSheet()->setCellValue('D3', 'Given By');
        $spreadsheet->getActiveSheet()->setCellValue('E3', 'Follow Up');
        $spreadsheet->getActiveSheet()->setCellValue('F3', 'Job Type');
        $spreadsheet->getActiveSheet()->setCellValue('G3', 'Start Date');
        $spreadsheet->getActiveSheet()->setCellValue('H3', 'End Date');
        $spreadsheet->getActiveSheet()->setCellValue('I3', 'Report Date');
        $spreadsheet->getActiveSheet()->setCellValue('J3', 'Status');
        $spreadsheet->getActiveSheet()->setCellValue('K3', 'Before');
        $spreadsheet->getActiveSheet()->setCellValue('L3', 'After');
        $spreadsheet->getActiveSheet()->setCellValue('M3', 'Report Status');
        $spreadsheet->getActiveSheet()->setCellValue('N3', 'Report Remarks');


        $col_num = 4;
        foreach ($reports as $key => $report) {

            if (empty($report->task)) {
                continue;
            }

            $t_given = !empty($report->task->given_by) ? $report->task->given_by : $report->task->created_by;
            $given_by_key = array_search($t_given, array_column($users, "id"));
            $assigned_user_key =  array_search($report->task->assignee, array_column($users, "id"));

            $follow_user_key =  array_search($report->task->reporter, array_column($users, "id"));

            $start_date = date( $date_format , strtotime($report->task->start_date));
            $end_date = !empty($report->task->end_date) ? date( $date_format , strtotime($report->task->end_date)) : "";
            $report_date = date( $date_format , strtotime($report->created_at));

            $spreadsheet->getActiveSheet()->setCellValue('A'.$col_num, $report->task->t_code);
            $spreadsheet->getActiveSheet()->setCellValue('B'.$col_num, $report->task->t_description);
            $spreadsheet->getActiveSheet()->setCellValue('C'.$col_num, $users[$assigned_user_key]["first_name"] . " " . $users[$assigned_user_key]["last_name"]);
            $spreadsheet->getActiveSheet()->setCellValue('D'.$col_num, $users[$given_by_key]["first_name"] . " " . $users[$given_by_key]["last_name"]);
            $spreadsheet->getActiveSheet()->setCellValue('E'.$col_num, $users[$follow_user_key]["first_name"] . " " . $users[$follow_user_key]["last_name"]);
            $spreadsheet->getActiveSheet()->setCellValue('F'.$col_num, $job_types[$report->task->parent_id]);
            $spreadsheet->getActiveSheet()->setCellValue('G'.$col_num, $start_date);
            $spreadsheet->getActiveSheet()->setCellValue('H'.$col_num, $end_date);
            $spreadsheet->getActiveSheet()->setCellValue('I'.$col_num, $report_date);
            $spreadsheet->getActiveSheet()->setCellValue('J'.$col_num, getStatusText($report->task->t_status));
            $spreadsheet->getActiveSheet()->setCellValue('K'.$col_num, $report->berfore);
            $spreadsheet->getActiveSheet()->setCellValue('L'.$col_num, $report->after);
            $spreadsheet->getActiveSheet()->setCellValue('M'.$col_num, $report->status);
            $spreadsheet->getActiveSheet()->setCellValue('N'.$col_num, $report->reason);

            $col_num++;
        }

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        //$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        /*$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);*/
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        /*$spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);*/


        $spreadsheet->getActiveSheet()->getStyle("A3:N3")->getFont()->setBold(true);


        $writer = new Xlsx($spreadsheet);
 
        $filename = 'daily-report-' . date("D-M-Y") .'-'. substr(time(), 5);
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
    }
}
