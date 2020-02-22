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


    public function task_report_add() {

        if (!$this->aauth->is_loggedin()) {
            redirect(base_url(''));
        }

        $data = array();
        $this->db->select('tid, t_title, t_code, t_status' );
        $this->db->from('tasks');

        $this->db->order_by('t_code', 'ASC');
        $tasks = $this->db->get()->result();
        
        $data['tasks']              = $tasks;

        $data['heading1']           = 'Add Task Report';
        $data['nav1']               = $this->currentUserGroup[0]->name;
        $data['users']              = $this->db->get("aauth_users")->result_array();
        $data['currentUser']        = $this->currentUser;
        $data['currentUserGroup']   = $this->currentUserGroup[0]->name;
        $data['inc_page']           = 'admin/reports/manual-report';

        $this->load->view('manager_layout', $data);

    }

    public function task_report_save() {        

        extract($_POST);

        $user_id        = $this->db->select("assignee")->from('tasks')->where('tid', $task_id )->get()->row('assignee');

        $date           = new DateTime( $date );
        $report_date    = $date->format('Y-m-d 13:25:14');

        $data = array(
            'task_id'   =>  $task_id,
            'user_id'   =>  $user_id,
            'berfore'   =>  $before,
            'after'     =>  $after,
            'status'    =>  $status,
            'reason'    =>  $reason,
            'created_at'=>  $report_date
        );

        $this->db->insert('reports', $data);

        redirect( $_SERVER['HTTP_REFERER'] );
    }
}