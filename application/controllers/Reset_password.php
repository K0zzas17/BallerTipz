<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class reset_password extends CI_Controller {
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
					redirect('login'); //if user already logined show main page
				}
			} else {
				$this->load->view('verify_email', $data); //if user has not login ask user to login
			}
		}else{
			$username = $this->session->userdata('username');
            redirect('login'); //if user already logined show main page
		}
		$this->load->view('template/footer');
	}
	
    public function reset_email() {
        $this->load->model('user_model');
        $this->load->helper('form');
		$this->load->helper('url');
        $this->load->library('email');
        $data['error'] = '';
		$this->load->view('template/header');

        $email = $this->input->post('email');
        if ($this->user_model->check_email($email)) {

            $this->email->from('reset-password@ballertipz.com', 'BallerTipz');
            $this->email->to($email);

            $this->email->subject('Password_reset ');
            $this->email->message('Click on the link to reset your password. '.base_url().'reset_password/new_password');

            $this->email->send();
        }
    }

    public function check_email() {
        $this->load->model('user_model');
        $this->load->helper('form');
		$this->load->helper('url');
        $data['error'] = '';
		$this->load->view('template/header');

        $email = $this->input->post('email');
        if ($this->user_model->check_email($email)) {
            $data['secret_question'] = $this->user_model->get_secret_question($email); 
            $data['email'] = $email;
            $this->load->view('account_verification', $data);
        } else {
            $data['error'] = "<div class=\"alert alert-danger text-center\" role=\"alert\"> Please input a valid email.</div> ";
            $this->load->view('verify_email', $data);
        }
        $this->load->view('template/footer');
    }

    public function check_details() {
        $this->load->model('user_model');
        $this->load->helper('form');
		$this->load->helper('url');
        $data['error'] = '';
       
        $this->load->view('template/header');
        $secret_answer = $this->input->post('secret_answer');
        $secret_question = $this->input->post('secret_question');
        $email = $this->input->post('email');

        if ($this->user_model->verify_account($email, $secret_question, $secret_answer)) {
            $data['email'] = $email;
            $this->load->view('new_password', $data);
        } else {
            $data['secret_question'] = $secret_question;
            $data['email'] = $email;
            $data['error'] = "<div class=\"alert alert-danger text-center\" role=\"alert\"> Answer is incorrect.</div> ";
            $this->load->view('account_verification', $data);
        }
            $this->load->view('template/footer');
    }

    public function change_password() {
        $this->load->model('file_model');
		$this->load->model('user_model');
		$data['profile_picture'] = $this->file_model->get_profile_picture();
        $this->load->helper('form');
		$this->load->helper('url');
        $data['error'] = '';
        $this->load->view('template/header');

        $password = $this->input->post('password');
        $password_2 = $this->input->post('password_2');
        $email = $this->input->post('email');

        if ($this->user_model->change_password($email, $password, $password_2)) {
            if ( $this->user_model->login($email, $password) )//check username and password correct
				{
					$user_data = array(
						'username' => $email,
						'logged_in' => true 	//create session variable
					);
					$this->session->set_userdata($user_data); //set user status to login in session
                    $data['valid'] = $this->user_model->get_validation($username);
					$this->load->view('welcome_message', $data); //if user already logined show main page
				}
        } else {
            $data['error'] = "<div class=\"alert alert-danger text-center\" role=\"alert\"> Please input a valid email.</div> ";
            $this->load->view('verify_email', $data);
        }

    }

}
?>
