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
        $tasks = $this->db->get()->result();
        $data["tasks"]  =   $tasks;

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
        giver.first_name as giver_f,
        giver.last_name as giver_l,
        assignee.first_name as assignee_f,
        assignee.last_name as assignee_l,
        reporter.first_name as follow, 
        D.c_name FROM `tasks` AS T
		LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee 
		LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter 
        LEFT JOIN aauth_users AS giver ON giver.id = T.given_by 
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

        $sql = "SELECT T.*, D.c_name, assignee.first_name as given, reporter.first_name as follow FROM `tasks` AS T LEFT JOIN aauth_users AS assignee ON assignee.id = T.assignee LEFT JOIN aauth_users AS reporter ON reporter.id = T.reporter LEFT JOIN departments AS D ON D.cid = T.department_id WHERE T.tid = ?";
        $task = $this->db->query($sql, array($task_id))->row();
        $data['task'] = $task;

        if (empty($data['task'])) {
            redirect(base_url(''));
        }



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

        $today          = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $start_date     = strtotime($task->start_date);
        $end_date       = strtotime($task->end_date);

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
        
        $reason = !empty($this->input->post('reason')) ? $this->input->post('reason') : "";

        $task_id = $this->input->post('task_id');
        //server validation
        $data = array(
            'task_id' => $this->input->post('task_id'),
            'user_id' => $this->currentUser->id,
            'berfore' => $this->input->post('befor'),
            'after' => $this->input->post('after'),
            'attachment_id' => $file_id,
            'status' => $this->input->post('status'),
            'reason' => $reason
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
            "t_reason"  =>  $reason
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

        if (empty($data['task'])) {
            redirect(base_url(''));
        }

        /*$this->db->select('*');
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
                $report_files = $files;
                
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

        $month = isset( $_GET["month"] ) ? $_GET["month"] : date('m');
        if( isset($_GET["employee"]) ) {            
            $this->getEmployeeMonthlyReport( $_GET["employee"], $month );
        } else {
            $this->getFullMonthlyReport( $month );
        }

        /*$url_params = $this->uri->segment_array();
        if( $url_params[3] == "monthly" ) {
            if( $url_params[4] == "employee" ) {

                $this->getEmployeeMonthlyReport( $url_params[5] );
            } else {
                $this->getFullMonthlyReport();
            }
        }*/
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

        $sql .= " WHERE T.assignee = {$user_id}";

        //$sql .= " LIMIT 0, 100";
        
        $tasks = $this->db->query($sql)->result();
        

        $month_date = !empty($month) ? $month : date('m');

        $sql_month_date = !empty($month) ? $month : "MONTH(CURRENT_DATE())";
        $sql = "SELECT * FROM `reports` WHERE is_deleted = 0 AND MONTH(created_at) = {$sql_month_date} AND YEAR(created_at) = YEAR(CURRENT_DATE())";
        $result = $this->db->query($sql)->result();

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
            $spreadsheet->getActiveSheet()->setCellValue('C' . $content_col , $task->giver_f . ' ' . $task->giver_l );
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

                if (!empty($result)) {
                    foreach ($result as $report_key => $report) {
                        $report_date    = date($date_format, strtotime($report->created_at));
                        $report_date_2  = date('d-m-Y', strtotime($report->created_at));

                        if ($report->task_id == $task->tid && $current_date == $report_date) {
                            $output = $report->status;
                            //continue;
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

        if( $this->currentUserGroup[0]->name == "Employee" ) {
            $sql .= " WHERE T.assignee = {$this->currentUser->id}";
        }
        

        //$sql .= " LIMIT 0, 100";
        
        $tasks = $this->db->query($sql)->result();

        $month_date = !empty($month) ? $month : date('m');

        $sql_month_date = !empty($month) ? $month : "MONTH(CURRENT_DATE())";
        $sql = "SELECT * FROM `reports` WHERE is_deleted = 0 AND MONTH(created_at) = {$sql_month_date} AND YEAR(created_at) = YEAR(CURRENT_DATE())";
        $result = $this->db->query($sql)->result();

        //dd($tasks);


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

        /*$spreadsheet->getActiveSheet()->mergeCells('A1:B1');
        $spreadsheet->getActiveSheet()->setCellValue('A1', "Employee Name:" );
        $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('C1', $employee->first_name . ' ' . $employee->last_name );

        $spreadsheet->getActiveSheet()->mergeCells('F1:G1');
        $spreadsheet->getActiveSheet()->setCellValue('F1', "Employee Code:" );
        $spreadsheet->getActiveSheet()->getStyle("F1")->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('H1', $employee->username );*/

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
            $spreadsheet->getActiveSheet()->setCellValue('D' . $content_col , $task->giver_f . ' ' . $task->giver_l );
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

                if (!empty($result)) {
                    foreach ($result as $report_key => $report) {
                        $report_date    = date($date_format, strtotime($report->created_at));
                        $report_date_2  = date('d-m-Y', strtotime($report->created_at));

                        if ($report->task_id == $task->tid && $current_date == $report_date) {
                            $output = $report->status;
                            //continue;
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
}
