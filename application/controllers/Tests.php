<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * summary
 */
class Tests extends CI_Controller
{
    /**
     * summary
     */
    public function __construct()
    {
        parent::__construct();

        $this->currentUser = $this->aauth->get_user();
        $this->currentUserGroup = $this->aauth->get_user_groups();
        
        $this->load->helper(array('form', 'url', 'file','directory', 'date'));
    }

    public function index() {
    	$this->db->select('*');
        $this->db->from('tasks');
        $tasks = $this->db->get()->result();

        foreach ($tasks as $task) {
        	$task_id = $task->tid;
        	$sql = "SELECT *  FROM `reports` WHERE `task_id` = {$task_id} ORDER BY created_at DESC LIMIT 0, 1";
        	$report = $this->db->query($sql)->row_array();
        	
        	if( !empty($report) ) {
        		$report_last_updated = $report["updated_at"];

        		$task_data = array( 
        			"last_updated"  =>  $report_last_updated
        		);
		        $this->db->where('tid', $task_id);
		        $this->db->update('tasks', $task_data);
        	}
        }
    }

    public function add_user(){
        
    }

    public function getCurrentMonthDates()
    {
        if( isset($_GET["month"]) && !empty($_GET["month"]) ) {
            list( $year, $month )   =   explode("-", $_GET["month"]);
        } else {
            $month  = date("m");
            $year   = date("Y");
        }
        $month_num = $month;
        $dates = array();

        date("L", mktime(0, 0, 0, 7, 7, $year)) ? $days = 366 : $days = 365;
        
        for ($i = 1; $i <= $days; $i++) {
            $month = date('m', mktime(0, 0, 0, 1, $i, $year));
            $wk = date('W', mktime(0, 0, 0, 1, $i, $year));
            $wkDay = date('D', mktime(0, 0, 0, 1, $i, $year));
            $day = date('d', mktime(0, 0, 0, 1, $i, $year));

            $dates[$month][$day] = $wkDay;
        }

        $dates = $dates[ $month_num ];
        return $dates;
    }


    public function get_reports_tasks() {

        $users      = $this->aauth->list_users("Employee");
        
        $reports    = $this->db->select('*')->from('reports');
        $reports    = $reports->join('tasks', 'tasks.tid = reports.task_id');
        $reports    = $reports->where( "reports.created_at BETWEEN '2019-12-01 00:00:00' AND '2019-12-31 23:59:59'" );
        $reports    = $reports->where( 'reports.user_id', $_GET["employee_id"] );
        $reports    = $reports->where( 'tasks.t_status', 'in-progress' );
        $reports    = $reports->get()->result();
        

        $tasks = array();

        foreach ($reports as $key => $report) {
            if( !isset( $tasks[$report->task_id] ) ) {

                $task                   =   new stdClass;
                $task->tid              = $report->task_id;
                $task->t_title          = $report->t_title;
                $task->t_code           = $report->t_code;
                $task->department_id    = $report->department_id;
                $task->parent_id        = $report->parent_id;
                $task->assignee         = $report->assignee;
                $task->given_by         = $report->given_by;
                $task->reporter         = $report->reporter;
                $task->t_status         = $report->t_status;
                $task->t_reason         = $report->t_reason;
                $task->t_description    = $report->t_description;
                $task->t_created_at     = $report->t_created_at;
                $task->t_updated_at     = $report->t_updated_at;
                $task->start_date       = $report->start_date;
                $task->end_date         = $report->end_date;
                $task->created_by       = $report->created_by;
                $task->last_updated     = $report->last_updated;

                $task->given_f = '';
                $task->given_l = '';
                $task->created_by_f = '';
                $task->created_by_l = '';
                $task->follow_f = '';
                $task->follow_l = '';

                foreach ($users as $user) {

                    if ($task->given_by == $user->id) {
                        $task->given_f = $user->first_name;
                        $task->given_l = $user->last_name;
                    }

                    if ($task->created_by == $user->id) {
                        $task->created_by_f = $user->first_name;
                        $task->created_by_l = $user->last_name;
                    }

                    if ($task->reporter == $user->id) {
                        $task->follow_f = $user->first_name;
                        $task->follow_l = $user->last_name;
                    }
                }

                $task->reports          = array();

                $tasks[$report->task_id] = $task;
                
            }
        }

        foreach ($tasks as $task_id => $task) {
            foreach ($reports as $report) {
                if( $report->task_id == $task_id ) {
                    array_push( $task->reports, $report );
                }
            }
        }
        //dd( $this->db->last_query() );
        //dd($tasks);
        /*
        if( !empty($tasks) ) {
            foreach ($tasks as $key => $task) {
                $sql = "SELECT * FROM `reports` WHERE task_id = '{$task->tid}' AND is_deleted = 0 AND MONTH(created_at) = 12 AND YEAR(created_at) = 2019";
                $report_result = $this->db->query($sql)->result();
                $task->reports = $report_result;
            }
        }*/

        

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

        $data['tasks'] = $tasks;

        $data["month_arg"] = isset($_GET["month"]) ? $_GET["month"] : "";

        $data['currentUser'] = $this->currentUser;
        $data['currentUserGroup'] = $this->currentUserGroup[0]->name;

        if (isset($_GET["employee_id"]) && !empty($_GET["employee_id"]) ) {
            $employee = $this->aauth->get_user($_GET["employee_id"]);
        }

        if( $this->currentUserGroup[0]->name == "Employee" ) {
            $employee = $this->currentUser;
        }

        $data["employee"] = isset($employee) && !empty($employee) ? $employee : false;
        
        $current_month  = date("F");
        $month_dates    = $this->getCurrentMonthDates();

        $data["month_dates"] = $month_dates;

        if( isset($_GET["month"]) && !empty($_GET["month"]) ) {
            list( $year, $month )   =   explode("-", $_GET["month"]);
        } else {
            $month  = date("m");
            $year   = date("Y");
        }

        $data["month_arg"] = isset($_GET["month"]) ? $_GET["month"] : "";

        $data["month_date"] = $month;
        $data["year_date"] = $year;

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
        if( isset($_GET["status"]) && !empty($_GET["status"]) ) {
            $arr3 = array(
                "status" => $_GET["status"]
            );
        }
        $url_arr = array_merge($arr1, $arr2, $arr3);
        $export_url = base_url( "report/export/monthly/?" . http_build_query($url_arr) );
        
        $data["export_url"] = $export_url;
        $current_url = base_url("report/monthly");
        $data["reset_url"]  = isset($_GET["employee_id"]) ? add_query_arg( "employee_id", $_GET["employee_id"], $current_url ) : $current_url ;

        $status_array = array(
            ''      =>  'Please Select Status',
            '1'     =>  'In Progress & On Hold',
            '2'     =>  'Cancelled & Finished'
        );
        $data['status_dropdown'] = $status_array;

        $data['heading1'] = 'Monthly Status';
        $data['nav1'] = ($this->currentUserGroup[0]->name == 'Manager') ? 'Manager' : 'GEW Employee';

        $data['inc_page'] = 'report/monthly_new';

        

        $this->load->view('manager_layout', $data);


    }
}