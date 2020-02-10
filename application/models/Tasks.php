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

}

/* End of file tasks.php */
/* Location: ./application/models/tasks.php */