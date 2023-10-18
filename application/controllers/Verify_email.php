<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verify_email extends CI_Controller {
	public function index()
	{
        $data['error'] = "";
		$this->load->model('file_model');
		$this->load->model('user_model');
		$data['profile_picture'] = $this->file_model->get_profile_picture();
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
					
					if (get_token($username)) {
						$this->load->view('email_token_verify', $data);
					} //if user already logged in check if they've already completed their verification
					
					else {
						$data['valid'] = $this->user_model->get_validation($username);
						$this->load->view('welcome_message', $data);
					}
				}


			} else {
				$this->load->view('login', $data); //if user has not login ask user to login
			}
		} else {
			$username = $this->session->userdata('username');
			if ($this->user_model->get_token($username)) {
				$this->load->view('email_token_verify', $data);
			} //if user already logged in check if they've already completed their verification
			
			else {
				$data['valid'] = $this->user_model->get_validation($username);
				$data['token'] = $this->user_model->get_token($username);
				$this->load->view('welcome_message', $data);
			}
		}
		
		$this->load->view('template/footer');


    }

    public function verify() {
        $data['error']= "";
		$this->load->model('user_model');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		
		$token = $this->input->post('verify');
		$username = $this->session->userdata('username');
		if ($this->user_model->confirm_token($username, $token)) {
			$data['error']= '<div class="alert alert-success text-center" role="alert"> 
			You have successfully confirmed your email.</div> ';
			$this->load->view('email_token_verify', $data);
		} else {
			$data['error']= '<div class="alert alert-danger text-center\" role="alert"> 
			That\'s the wrong token. <a class="text-danger" href="#"><u>Re-send email verification.</u></a></div>';
			$this->load->view('email_token_verify', $data);
		}
		$this->load->view('template/footer');
    }

	public function send_verification() {
		$this->load->model('user_model');
		$this->load->model('file_model');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$this->load->library('email');

		$config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'mailhub.eait.uq.edu.au',
            'smtp_port' => 25,
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE ,
            'mailtype' => 'html',
            'starttls' => true,
            'newline' => "\r\n"
            );
           
		$this->email->initialize($config);

		$username = $this->session->userdata('username');
		$email = $this->user_model->get_email($username);
		$token = $this->user_model->get_token($username);
		
		$data['profile_picture'] = $this->file_model->get_profile_picture();
        $data['valid'] = $this->user_model->get_validation($username);
		$data['token'] = $token;
		//Send email to user		
		
		$this->email->from(get_current_user().'@student.uq.edu.au', 'BallerTipz');
		$this->email->to($email);
		$this->email->subject('verifiy email for BallerTipz');
		$this->email->message('Click on the link to verify your email. '.base_url().'verify_email'.' Here is your validation code: '.$token);

		if($this->email->send()) {
            $this->session->set_flashdata("email_sent","Email Sent successfully.");
		} else {
			$this->session->set_flashdata("email_sent","Email failed to send.");
		$this->load->view('template/footer');
		}
		redirect('login');
	}
}
    ?>