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

        $this->currentUser = $this->aauth->get_user();
        $this->currentUserGroup = $this->aauth->get_user_groups();

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

    public function view_users() {
        $users                  = $this->db->get("aauth_users")->result();
        $departments            = $this->getDepartments();

        $data['users']          = $users;
        $data['departments']    = $departments;
        $data['heading1']       = 'Tasks';
        $data['nav1']           = $this->currentUserGroup[0]->name;
        $data['currentUser']     = $this->currentUser;
        $data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page']       = 'admin/users/list';
        
        $this->load->view('manager_layout', $data);
    }

    public function change_pass( $user_id ) {
        dd($user_id);
    }


    public function view_tasks() {
        $data = array();

        $this->load->model('tasks');
        $tasks      = $this->tasks->get_all();
        $data['tasks']          = $tasks;

        $data['heading1']       = 'Tasks';
        $data['nav1']           = $this->currentUserGroup[0]->name;
        $data['users']          = $this->db->get("aauth_users")->result_array();
        $data['currentUser']     = $this->currentUser;
        $data['currentUserGroup'] = $this->currentUserGroup[0]->name;
        $data['inc_page']       = 'admin/tasks/list';

        $this->load->view('manager_layout', $data);
    }

    public function delete_task( $task_id ) {
        $this->db->delete('tasks', array('tid' => $task_id ));

        redirect( base_url('/admin/tasks') );
    }
}