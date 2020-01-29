<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * summary
 */
class Admin extends CI_Controller
{
    /**
     * summary
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form'));
    }

    public function index() {
    }

    public function getDepartments() {

        $this->db->select('*');
        $this->db->from('departments');
        $departments = $this->db->get()->result();

        return $departments;
    }

    public function add_user(){
        $departments = $this->getDepartments();
        $data = array();

        $data["departments"] = $departments;
        
        $this->load->view('admin/user-add', $data);
    }

    public function save_user() {

        $aauth = $this->config->item('aauth');
        $table_name = $aauth["users"];

        $user_id = $this->aauth->create_user( $_POST["email"], $_POST["password"], $_POST["username"] );

        $data = array(
            'first_name'    => $_POST["first_name"],
            'last_name'    => $_POST["last_name"],
            'cur_loc'    => $_POST["cur_loc"],
            'per_mon_no'    => $_POST["per_mon_no"],
            'last_name'    => $_POST["last_name"],
            'company_email'    => $_POST["company_email"],
            'com_mob_no'    => $_POST["com_mob_no"],
            'job_title'    => $_POST["job_title"],
            'dept_id'    => $_POST["dept_id"],
            'nationality'    => $_POST["nationality"],
        );

        $this->db->where('id', $user_id);
        $this->db->update( $table_name , $data);
    }
}