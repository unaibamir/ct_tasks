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
}