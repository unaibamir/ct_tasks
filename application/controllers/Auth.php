<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
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

		if ($this->form_validation->run())
		{
			$user = $this->input->post('username');
			$password = $this->input->post('password');

			if($this->aauth->login($user, $password))
			{
				redirect(base_url('dashboard'));
			}
			else
			{
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
}
