<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {
	public function index()
	{
		$this->load->model('file_model');
		$this->load->model('user_model');
		$data['profile_picture'] = $this->file_model->get_profile_picture();
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		

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
					$this->load->view('welcome_message', $data); //if user already logined show main page
				}
			} else {
				$this->load->view('login', $data); //if user has not login ask user to login
			}
		}else{
			$username = $this->session->userdata('username');
			$data['valid'] = $this->user_model->get_validation($username);
			$data['token'] = $this->user_model->get_token($username);

			//Checks if data is coming from email verification link

			$this->load->view('welcome_message', $data); //if user already logined show main page
		}
		$this->load->view('template/footer');
	}
	public function check_login()
	{
		$this->load->model('user_model');		//load user model
		$data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> Either the username or password is incorrect. <a href='create_user'>Click Here to create an account.</a></div> ";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$username = $this->input->post('username'); //getting username from login form
		$password = $this->input->post('password'); //getting password from login form
		$remember = $this->input->post('remember'); //getting remember checkbox from login form
		if(!$this->session->userdata('logged_in')){	//Check if user already login
			if ( $this->user_model->login($username, $password) )//check username and password
			{
				$user_data = array(
					'username' => $username,
					'logged_in' => true 	//create session variable
				);
				if($remember) { // if remember me is activated create cookie 5 mins for now
					set_cookie("username", $username, '300'); //set cookie username
					set_cookie("password", $password, '300'); //set cookie password
					set_cookie("remember", $remember, '300'); //set cookie remember
				}	
				$this->session->set_userdata($user_data); //set user status to login in session
				redirect('login'); // direct user home page
			} else
			{
				$this->load->view('login', $data);	//if username password incorrect, show error msg and ask user to login
			}
		} else {
			{
				redirect('login'); //if user already logged direct user to home page
			}
		$this->load->view('template/footer');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('logged_in'); //delete login status
		//Deletes cookies associated with user
		delete_cookie('remember');
		delete_cookie('username');
		delete_cookie('password');
		redirect('login'); // redirect user back to login
	}
}
?>
