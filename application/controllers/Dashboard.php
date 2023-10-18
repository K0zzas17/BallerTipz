<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
		$this->load->model('dashboard_model');
		$this->load->model('file_model');
		$this->load->helper('url_helper');
		$this->load->helper('form');
		$data['profile_picture'] = $this->file_model->get_profile_picture();
    }

	public function index()	{	
		$data['error']= "";
		$this->load->view('template/header');

		$data['user'] =  NULL;
		$data['ratings'] = NULL;
		$data['questions_asked'] =  NULL;
		$data['questions_answered'] = NULL;

		$user = $this->input->get('user');
		$ratings = $this->input->get('ratings');
        $questions_asked = $this->input->get('questions_asked');
		$questions_answered = $this->input->get('questions_answered');
		
		if(isset($user) && isset($ratings) && isset($questions_asked) && isset($questions_answered)) {
			$data['user'] = $user;
			$data['ratings'] = $ratings;
			$data['questions_asked'] = $questions_asked;
			$data['questions_answered'] = $questions_answered;
			$data['users'] = $this->dashboard_model->get_users($user, $ratings);
		}
		
		$username = $this->session->userdata('username');
			$data['valid'] = $this->user_model->get_validation($username);
			$data['token'] = $this->user_model->get_token($username);
		
		if (!$this->session->userdata('logged_in'))//check if user already login
		{
			if (get_cookie('remember')) { // check if user activate the "remember me" feature
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array(
						'username' => $username,
						'logged_in' => true 	//create session variable
					);
					$this->session->set_userdata($user_data); //set user status to login in session
					$data['valid'] = $this->user_model->get_validation($username);
					$data['token'] = $this->user_model->get_token($username);
					$this->load->view('dashboard', $data); //if user already logined show main page
				}
			} else {
				$this->load->view('login', $data); //if user has not login ask user to login
			}
		}else{
			$username = $this->session->userdata('username');
			$data['valid'] = $this->user_model->get_validation($username);
			$data['token'] = $this->user_model->get_token($username);

			//Checks if data is coming from email verification link
			$this->load->view('dashboard', $data); //if user already logined show main page
		}
		$this->load->view('template/footer');
	}

}
?>