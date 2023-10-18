<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class complete_profile extends CI_Controller {
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
					$this->load->view('complete_profile', $data); //if user already logined show main page
				}
			} else {
				$this->load->view('login', $data); //if user has not login ask user to login
			}
		}else{
			$username = $this->session->userdata('username');
			$data['valid'] = $this->user_model->get_validation($username);
			$this->load->view('complete_profile', $data); //if user already logined show main page
		}
		$this->load->view('template/footer');
	}

    //function allows user to complete details (first and last names, number and date of birth)
	public function submit_profile_details() 
	{
		$this->load->model('user_model');		//load user model
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');

		$given_name = $this->input->post('given_name'); //getting given from account update form
		$last_name = $this->input->post('surname'); //getting email from  account update form
		$dob = $this->input->post('dob'); //getting dob from  account update form
		$contact_number = $this->input->post('contact_number'); //getting contact number from  account update form
		
		if($this->session->userdata('logged_in')) { //Check if user is logged in, if not redirects to the login page
			if (!$this->user_model->complete_profile($given_name, $last_name, $dob, $contact_number)) {
                $data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> Please pick a valid date.</div> ";
				$this->load->view("complete_profile", $data);
			} else {
				$data['error']= "<div class=\"alert alert-success\" role=\"alert\"> Your account is complete. <a href='login'>Return to homepage.</a></div> ";
                $this->load->view("my_account", $data);
			}
		} else {
			redirect('login');
		}
		
	}


}
?>