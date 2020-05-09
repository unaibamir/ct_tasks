<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

		if( $this->currentUser->cur_loc == "Fujairah" ) {
			$this->db->where('aauth_users.cur_loc', "Fujairah");
		}

		if( $this->currentUser->cur_loc == "Jabel Ali" ) {
			$this->db->where('aauth_users.cur_loc', "Jabel Ali");
		}

		if( $this->currentUser->dept_id == 4 ) {
			$this->db->where('aauth_users.dept_id', 4 );
		}

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

		if( $this->currentUser->cur_loc == "Fujairah" ) {
			foreach ($employees as $key => $user) {
				if( $user->cur_loc != "Fujairah" ) {
					unset( $employees[$key] );
				}
			}
		}

		if( $this->currentUser->cur_loc == "Jabel Ali" ) {
			foreach ($employees as $key => $user) {
				if( $user->cur_loc != "Jabel Ali" ) {
					unset( $employees[$key] );
				}
			}
		}

		if( $this->currentUser->dept_id == 4 ) {
			foreach ($employees as $key => $user) {
				if( $user->dept_id != 4 ) {
					unset( $employees[$key] );
				}
			}
		}


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

	public function attendance() {
		if( $this->currentUserGroup[0]->name != "Manager" ) {
			redirect(base_url('dashboard'));
		}

		$this->db->select('*');
		$this->db->from('aauth_users');
		$this->db->join('aauth_user_to_group', 'aauth_users.id = aauth_user_to_group.user_id');
		$this->db->join('departments', 'departments.cid = aauth_users.dept_id');
		$this->db->where('aauth_user_to_group.group_id', 3);

		if( $this->currentUser->cur_loc == "Fujairah" ) {
			$this->db->where('aauth_users.cur_loc', "Fujairah");
		}

		if( $this->currentUser->cur_loc == "Jabel Ali" ) {
			$this->db->where('aauth_users.cur_loc', "Jabel Ali");
		}

		if( $this->currentUser->dept_id == 4 ) {
			$this->db->where('aauth_users.dept_id', 4 );
		}

		$users = $this->db->get()->result();


		$data['currentUser'] = $this->currentUser;
        $data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        
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
        $sql_month_date = $month;

        $date = new DateTime( $year . '-' . $month );
        $full_date_1 = $date->modify('first day of this month')->format('Y-m-d 00:00:00');
        $full_date_2 = $date->modify('last day of this month')->format('Y-m-d 23:59:59');

        $holidays = '';                
        for ($i = 0; $i < ((strtotime($full_date_2) - strtotime($full_date_1)) / 86400); $i++) {
            if(date('l',strtotime($full_date_1) + ($i * 86400)) == 'Friday') {
                $holidays++;
            }    
        }

        $data["total_days"]  = count( $month_dates );
        $data["holidays"]  = $holidays;
        $data["total_working_days"]  = $data["total_days"] - $holidays;

        
        // get task reports 
        $reports    = $this->db->select('*')->from('reports');
        $reports    = $reports->join('tasks', 'tasks.tid = reports.task_id');
        $reports    = $reports->where( "reports.created_at BETWEEN '{$full_date_1}' AND '{$full_date_2}'" );
        $reports    = $reports->order_by('t_created_at', 'ASC')->get()->result();
        
        foreach ($users as $user) {
        	
        	if( !isset($user->reports) ) {
        		$user->reports = array();
        	}

        	foreach ($reports as $key => $report) {
        		if( $report->user_id == $user->id ) {
        			array_push( $user->reports, $report );
        		}
        	}
        }

        $data["users"] = $users;

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
        if( isset($_GET["status"]) && !empty($_GET["status"]) ) {
            $arr3 = array(
                "status" => $_GET["status"]
            );
        }
        $url_arr = array_merge($arr1, $arr2, $arr3);
        $export_url = base_url( "employee/export/attendance?" . http_build_query($url_arr) );
        
        $data["export_url"] = $export_url;

        $current_url = base_url("employee/attendance");
        $data["reset_url"]  = isset($_GET["employee_id"]) ? add_query_arg( "employee_id", $_GET["employee_id"], $current_url ) : $current_url ;

        $data['heading1'] = 'Monthly Status';
        $data['nav1'] = ($this->currentUserGroup[0]->name == 'Manager') ? 'Manager' : 'GEW Employee';
        

        $data['inc_page'] = 'employee/attendance';


        $this->load->view('manager_layout', $data);

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

    public function export() {
    	$type = $this->uri->segment(3);

    	if( $type == "attendance" ) {
    		$month = isset( $_GET["month"] ) ? $_GET["month"] : date('m');
    		$this->getAttendanceReport( $month );
    	}
    }

    public function getAttendanceReport() {


    	$data['currentUser']        = $this->currentUser;
        $data['currentUserGroup']   = $this->currentUserGroup[0]->name;
        $current_month  = date("F");
        $month_dates    = $this->getCurrentMonthDates();
		$date_format    = $this->config->item('date_format');

		if (isset($_GET["month"]) && !empty($_GET["month"])) {
			list($year, $month)   =   explode("-", $_GET["month"]);
		} else {
			$month  = date("m");
			$year   = date("Y");
		}
		$sql_month_date = $month;

        $month_date = !empty($month) ? $month : date('m');

        $this->db->select('*');
		$this->db->from('aauth_users');
		$this->db->join('aauth_user_to_group', 'aauth_users.id = aauth_user_to_group.user_id');
		$this->db->join('departments', 'departments.cid = aauth_users.dept_id');
		$this->db->where('aauth_user_to_group.group_id', 3);

		if( $this->currentUser->cur_loc == "Fujairah" ) {
			$this->db->where('aauth_users.cur_loc', "Fujairah");
		}

		if( $this->currentUser->cur_loc == "Jabel Ali" ) {
			$this->db->where('aauth_users.cur_loc', "Jabel Ali");
		}

		if( $this->currentUser->dept_id == 4 ) {
			$this->db->where('aauth_users.dept_id', 4 );
		}

		$users = $this->db->get()->result();


		$date = new DateTime( $year . '-' . $month );
        $full_date_1 = $date->modify('first day of this month')->format('Y-m-d 00:00:00');
        $full_date_2 = $date->modify('last day of this month')->format('Y-m-d 23:59:59');

        $holidays = '';                
        for ($i = 0; $i < ((strtotime($full_date_2) - strtotime($full_date_1)) / 86400); $i++) {
            if(date('l',strtotime($full_date_1) + ($i * 86400)) == 'Friday') {
                $holidays++;
            }    
        }

        $total_days  = count( $month_dates );
        $holidays  = $holidays;
        $total_working_days  = $total_days - $holidays;
        
        // get task reports 
        $reports    = $this->db->select('*')->from('reports');
        $reports    = $reports->join('tasks', 'tasks.tid = reports.task_id');
        $reports    = $reports->where( "reports.created_at BETWEEN '{$full_date_1}' AND '{$full_date_2}'" );
        $reports    = $reports->order_by('t_created_at', 'ASC')->get()->result();
        
        foreach ($users as $user) {
        	
        	if( !isset($user->reports) ) {
        		$user->reports = array();
        	}

        	foreach ($reports as $key => $report) {
        		if( $report->user_id == $user->id ) {
        			array_push( $user->reports, $report );
        		}
        	}
        }


        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->setCellValue('A3', 'Employee Code');
        $spreadsheet->getActiveSheet()->setCellValue('B3', 'Name');
        $spreadsheet->getActiveSheet()->setCellValue('C3', 'Job Title');
        $spreadsheet->getActiveSheet()->setCellValue('D3', 'Department');

        $header_col = 5;
        $row = 3;
        foreach ($month_dates as $dig => $alpha) {
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow( $header_col, $row, $alpha .'-'. $dig );
            $header_col++;
        }

        $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow( $header_col++, $row, 'TD' );
        $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow( $header_col++, $row, 'H' );
        $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow( $header_col++, $row, '0' );
        $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow( $header_col++, $row, '1' );


        $spreadsheet->getActiveSheet()->mergeCells('A1:B1');
        $spreadsheet->getActiveSheet()->setCellValue('A1', "Employee Attendance:" );
        $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->setCellValue('C1', $month .', '. $year );

        $spreadsheet->getActiveSheet()->getStyle("A3:AM3")->getFont()->setBold(true);

        /*$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);*/

        $date_format = $this->config->item('date_format');

        $content_col = 4;
        $counter = 1;

        foreach ($users as $user) {
        	$spreadsheet->getActiveSheet()->setCellValue('A' . $content_col , $user->username );
        	$spreadsheet->getActiveSheet()->setCellValue('B' . $content_col , $user->first_name . ' ' . $user->last_name );
        	$spreadsheet->getActiveSheet()->setCellValue('C' . $content_col , $user->job_title );
        	$spreadsheet->getActiveSheet()->setCellValue('D' . $content_col , $user->c_name );

        	$inner_col = 5;
            $total_attendance = 0;
            foreach ($month_dates as $date_dig => $date_alpha) {
            	$current_date   = $date_dig . date("/{$month_date}/{$year}");
                $current_date_2 = strtotime(date($date_dig . "-{$month_date}-{$year}"));
                $output         = "0";

                if( !empty($user->reports) ) {
                    foreach ($user->reports as $report_key => $report) {
                        $report_date    = date($date_format, strtotime($report->created_at));
                        if ($current_date == $report_date) {
                            $output = "1";
                            $total_attendance++;
                            break;
                        }
                    }
                }

                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow( $inner_col, $content_col, $output );

            	$inner_col++;
            }

            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow( $inner_col++, $content_col, $total_days );
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow( $inner_col++, $content_col, $holidays );
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow( $inner_col++, $content_col, ( $total_days > $total_attendance ) ? $total_days - $total_attendance : "0" );
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow( $inner_col++, $content_col, $total_attendance );


        	$content_col++;
            $counter++;
        }


        $writer = new Xlsx($spreadsheet);
 
        $filename = 'monthly-employee-attendance-' . date("M-Y") . substr(time(), 5);
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');

    }

}

/* End of file Employee.php */
/* Location: ./application/controllers/Employee.php */