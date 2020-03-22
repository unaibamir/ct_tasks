<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Model {

	public function get_task( $task_id ) {
		$this->db->select('*');
		$this->db->from('tasks');
		$this->db->where('tid', $task_id);
		$task = $this->db->get()->result();

		return $task;
	}

	public function get_all() {
		$this->db->select('*');
		$this->db->from('tasks');
		$this->db->join('departments', 'departments.cid = tasks.department_id');
		$this->db->order_by('tid', 'ASC');
		$tasks = $this->db->get()->result();

		return $tasks;
	}

	public function resume_task( $data = array() ) {
		
	}

	public function getUserTasks( $user_id ) {

		$this->db->select('*');
        $this->db->from('tasks');
        $this->db->join('departments', 'departments.cid = tasks.department_id');
        $this->db->where('tasks.assignee', $user_id );

        //type filter start here 
        if (isset($_GET["type"]) && !empty($_GET["type"])) {
            if ($_GET["type"] == 99) {
                //$this->db->where('tasks.parent_id', $_GET["type"]);
            } else {
                $this->db->where('tasks.parent_id', $_GET["type"]);
            }
        } else {
            //$this->db->where('tasks.parent_id', 1);
        }

        // status filter starts
        $this->db->where_in('tasks.t_status', array('in-progress'));

        $this->db->order_by('tasks.t_created_at', 'DESC');

        $tasks = $this->db->get()->result();

        return $tasks;
	}

}

/* End of file tasks.php */
/* Location: ./application/models/tasks.php */