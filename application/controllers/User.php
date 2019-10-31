<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if(!$this->aauth->is_loggedin())
            redirect(base_url(''));
        $this->currentUser = $this->aauth->get_user();
        $this->currentUserGroup = $this->aauth->get_user_groups();

    }

    public function getdepartmentusers($depatment_id) {

        $this->db->select('*');
        $this->db->from($this->config->item('aauth')["users"]);
        $this->db->where('dept_id', $depatment_id);
        $users = $this->db->get()->result_array();

        if( !empty( $users ) ) {
            $data = array();
            $counter = 1;
            $data[ 0 ]["name"]  = "Please Select";
            $data[ 0 ]["id"]    = "";
            foreach ( $users as $key => $user ) {
                $data[ $counter ]["name"]   = $user["first_name"] . ' ' . $user["last_name"];
                $data[ $counter ]["id"]     = $user["id"];
                $counter++;
            }
            echo json_encode(array(
                "status"    =>  true,
                "data"      =>  $data
            ));
        } else {
            echo json_encode(array(
                "status"    =>  false,
                "msg"       =>  "no_users_found"
            ));
        }
    }
}