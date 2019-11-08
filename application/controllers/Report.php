<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

        $this->load->helper(array('form', 'url', 'file','directory'));
    }

    public function daily()
    {
        $this->db->select('*');
        $this->db->from('reports');
        if (isset($_GET["employee_id"]) && !empty($_GET["employee_id"])) {
            $this->db->where('user_id', $_GET["employee_id"]);
        }

        if ($this->currentUserGroup[0]->name == "Employee") {
            $this->db->where('user_id', $this->currentUser->id);
        }

        $reports = $this->db->get()->result();

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

        $data['users'] = $this->db->get("aauth_users")->result_array();
        $data['heading1'] = 'Daily Job Report View';
        $data['nav1'] = 'GEW Employee';
        $data['nav1'] = ($this->currentUserGroup[0]->name == 'Manager')? 'Manager' : 'GEW Employee';

        $data['currentUser'] = $this->currentUser;
        $data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page'] = 'report/daily_new'; // views/display.php page
        $this->load->view('manager_layout', $data);
    }

    public function daily_old()
    {
        $sql = "SELECT 
		T.*, 
		assignee.first_name as given,
		reporter.first_name as follow,
		D.c_name,
		R.rid,
		R.berfore,
		R.after,
		R.status

		FROM `tasks` AS T
		LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee 
		LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter 
		LEFT JOIN departments AS D on D.cid = T.department_id
		LEFT JOIN reports AS R on R.task_id = T.tid";

        if (isset($_GET["employee_id"]) && !empty($_GET["employee_id"])) {
            $sql .= " WHERE T.assignee = {$_GET["employee_id"]}";
        }

        if ($this->currentUserGroup[0]->name == "Employee") {
            $sql .= " WHERE T.assignee = {$this->currentUser->id}";
        }
        
        $tasks = $this->db->query($sql)->result();


        $evening = $morning = $Ids = array();
        
        if (!empty($tasks)) {
            foreach ($tasks as $key => $value) {
                if (!in_array($value->tid, $Ids)) {
                    $Ids[] = $value->tid;
                    $morning[$value->tid] = $value;
                    $evening[$value->tid] = $value;
                }

                if (!empty($value->berfore)) {
                    $morning[$value->tid]->morningReports['update'][] = $value->berfore;
                    $morning[$value->tid]->morningReports['status'][] = $value->status;
                }

                if (!empty($value->after)) {
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

    public function monthly_old()
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

        $sql = "SELECT T.*,  assignee.first_name as given, reporter.first_name as follow, D.c_name FROM `tasks` AS T
		LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee 
		LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter 
		LEFT JOIN departments AS D on D.cid = T.department_id";

        if (isset($_GET["employee_id"]) && !empty($_GET["employee_id"])) {
            $sql .= " WHERE T.assignee = {$_GET["employee_id"]}";
        }

        $data['tasks'] = $this->db->query($sql)->result();
        
        /*$sql = "SELECT * FROM `reports` WHERE is_deleted = 0 AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";*/
        $data["month_date"] = isset($_GET["month"]) && !empty($_GET["month"]) ? $_GET["month"] : date('m');

        $sql_month_date = isset($_GET["month"]) && !empty($_GET["month"]) ? $_GET["month"] : "MONTH(CURRENT_DATE())";
        $sql = "SELECT * FROM `reports` WHERE is_deleted = 0 AND MONTH(created_at) = {$sql_month_date} AND YEAR(created_at) = YEAR(CURRENT_DATE())";
        $result = $this->db->query($sql)->result();
        $data['currentMonthReports'] = $result;

        $data['heading1'] = 'Monthly Status';
        $data['nav1'] = ($this->currentUserGroup[0]->name == 'Manager')? 'Manager' : 'GEW Employee';

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

        $sql = "SELECT T.*, D.c_name, assignee.first_name as given, reporter.first_name as follow FROM `tasks` AS T LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter LEFT JOIN departments AS D ON D.cid = T.department_id WHERE T.tid = ?";
        $task = $this->db->query($sql, array($task_id))->row();
        $data['task'] = $task;

        if (empty($data['task'])) {
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
    
        $file_id = 0;
        
        if (isset($_FILES["report_file"])) {
            $upload_path                = "uploads/tasks";
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }
            
            $file                       = array();
            $config['upload_path']      = $upload_path;
            $config['allowed_types']    = 'gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp|';

            $this->load->library('upload', $config);
            
            if (! $this->upload->do_upload('report_file')) {
            } else {
                $file_data          = $this->upload->data();
                //dd($file_data);
                $file['f_title']    = $file_data["client_name"];
                $file['url']        = base_url("/{$upload_path}/{$file_data["file_name"]}");
                $file['type']       = $file_data["file_type"];
                $file['status']     = 0;
                $file['is_deleted'] = 0;

                $this->db->insert("files", $file);
                $file_id = $this->db->insert_id();
            }
        }

        $task_id = $this->input->post('task_id');
        //server validation
        $data = array(
            'task_id' => $this->input->post('task_id'),
            'user_id' => $this->currentUser->id,
            'berfore' => $this->input->post('befor'),
            'after' => $this->input->post('after'),
            'attachment_id' => $file_id,
            'status' => $this->input->post('status'),
            'reason' => $this->input->post('reason')
        );

        $this->db->insert('reports', $data);

        $report_id = $this->db->insert_id();
        $task_id = $this->input->post('task_id');
        $status_array = array("H", "C", "F");

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
            "t_reason"  =>  $this->input->post('reason')
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

        $sql = "SELECT T.*, D.c_name, assignee.first_name as given, assignee.username as user_code, reporter.first_name as follow FROM `tasks` AS T LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter LEFT JOIN departments AS D ON D.cid = T.department_id WHERE T.tid = ?";
        $data['task'] = $this->db->query($sql, array($task_id))->row();

        $this->db->select('*');
        $this->db->from('files');
        $this->db->where('files.fid', $data['task']->attachment_id);
        $files = $this->db->get()->result_array();
        $data['task_files'] = $files;

        $sql = "SELECT * FROM reports WHERE task_id = ?";
        $task_history = $this->db->query($sql, array($task_id))->result();

        foreach ($task_history as $key => $history) {
            $this->db->select('*');
            $this->db->from('files');
            $this->db->where('files.fid', $history->attachment_id);
            $files = $this->db->get()->result_array();
            $history->files = $files;
        }

        /*$period = new DatePeriod(
            new DateTime($data['task']->start_date),
            new DateInterval('P1D'),
            new DateTime($data['task']->end_date)
        );

        foreach ($period as $key => $value) {
            dd($value->format('Y-m-d'), false);
        }
        dd($period, false);*/

        $data['taskHistory'] = $task_history;
        //dd($data['taskHistory']);

        if (empty($data['task'])) {
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
