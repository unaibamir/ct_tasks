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

	public function resume_task( $data = array() ) {
		
	}

}

/* End of file tasks.php */
/* Location: ./application/models/tasks.php */