<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $current_url = $this->uri->uri_string();

        if ($current_url != "auth/logout" && $this->aauth->is_loggedin()) {
            redirect(base_url('/dashboard'));
        }
    }



//load login screen
    public function index()
    {

        $this->load->view('login');
    }


//is_loggedin

    
    //Testing login
    public function login()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run()) {
            $user = $this->input->post('username');
            $password = $this->input->post('password');

            if ($this->aauth->login($user, $password)) {
                redirect(base_url('dashboard'));
            } else {
                $this->session->set_flashdata('login_error', $this->aauth->get_errors_array()[0]);
            }
        }
        $this->load->view('login');
    }

    public function logout()
    {
        $this->aauth->logout();
        redirect(base_url(''));
    }

    public function create_users()
    {
        $users_array = array(
            array(
                "email"     =>  "abdulazizhusain67@yahoo.com",
                "username"  =>  "102"
            ),
            array(
                "email"     =>  "greenworld1953@yahoo.com",
                "username"  =>  "101"
            ),
            array(
                "email"     =>  "zapozhanova@gmail.com",
                "username"  =>  "244"
            ),
            array(
                "email"     =>  "pa@gulfenviro.ae",
                "username"  =>  "156"
            ),
            array(
                "email"     =>  "immrsgracemalit@yahoo.com",
                "username"  =>  "138"
            ),
            array(
                "email"     =>  "khan_navid24@yahoo.co.in",
                "username"  =>  "150"
            ),
            array(
                "email"     =>  "harriettsakiwat@gmail.com",
                "username"  =>  "185"
            ),
            array(
                "email"     =>  "sales.gew@gulfenviro.ae",
                "username"  =>  "229"
            ),
            array(
                "email"     =>  "hassan.istaqlal786@gmail.com",
                "username"  =>  "228"
            ),
            array(
                "email"     =>  "rahulunni50@yahoo.com",
                "username"  =>  "129"
            ),
            array(
                "email"     =>  "zeeshanabc13@gmail.com",
                "username"  =>  "118"
            ),
            array(
                "email"     =>  "ajeesh98@gmail.com",
                "username"  =>  "148"
            ),
            array(
                "email"     =>  "zhrsha92@gmail.com",
                "username"  =>  "176"
            ),
            array(
                "email"     =>  "amir.nisar715@gmail.com",
                "username"  =>  "249"
            ),
            array(
                "email"     =>  "Developer@gulfenviro.ae",
                "username"  =>  "148"
            ),
            array(
                "email"     =>  "reda2010n@gmail.com",
                "username"  =>  "152"
            ),
            array(
                "email"     =>  "sideeghassan7@gmail.com",
                "username"  =>  "172"
            ),
            array(
                "email"     =>  "faseehmech@gmail.com",
                "username"  =>  "181"
            ),
            array(
                "email"     =>  "faalzir@gmail.com",
                "username"  =>  "169"
            ),
            array(
                "email"     =>  "samimasoodniazi@gmail.com",
                "username"  =>  "175"
            ),
            array(
                "email"     =>  "arjun.1219@gmail.com",
                "username"  =>  "174"
            ),
            array(
                "email"     =>  "sankarraj2325@gmail.com",
                "username"  =>  "222"
            ),
            array(
                "email"     =>  "ishtaiwi-4@hotmail.com",
                "username"  =>  "247"
            ),
            array(
                "email"     =>  "shahzad6283626@gmail.com",
                "username"  =>  "112"
            ),
            array(
                "email"     =>  "mohamadcharif1@hotmail.com",
                "username"  =>  "114"
            ),
            array(
                "email"     =>  "alishiha2011@yahoo.com",
                "username"  =>  "113"
            ),
            array(
                "email"     =>  "bilal_saleem1@hotmail.com",
                "username"  =>  "119"
            ),
            array(
                "email"     =>  "mellijored37@yahoo.com",
                "username"  =>  "133"
            ),
            array(
                "email"     =>  "fayyaz.hussain463@yahoo.com",
                "username"  =>  ""
            ),
            array(
                "email"     =>  "magestco@gmail.com",
                "username"  =>  "128"
            ),
            array(
                "email"     =>  "dieseldxb1@gmail.com",
                "username"  =>  "177"
            ),
            array(
                "email"     =>  "talat256@gmail.com",
                "username"  =>  ""
            ),
            array(
                "email"     =>  "melissa_manlangit02@yahoo.com",
                "username"  =>  "179"
            ),
            array(
                "email"     =>  "jemsbartolome28@yahoo.com",
                "username"  =>  "166"
            ),
            array(
                "email"     =>  "echooshussain@yahoo.com",
                "username"  =>  ""
            ),
            array(
                "email"     =>  "prakashkp726@gmail.com",
                "username"  =>  ""
            ),
            array(
                "email"     =>  "vas.vasilina@gmail.com",
                "username"  =>  "226"
            ),
            array(
                "email"     =>  "junaidey@live.com",
                "username"  =>  "145"
            ),
        );

        foreach ($users_array as $key => $user_array) {
            $email      = $user_array["email"];
            $username   = !empty($user_array["username"])? $user_array["username"] : rand(500, 600);
            $password   = "demo" . $username;

            $user_id = $this->aauth->create_user($email, $password, $username);
        }
    }
}
