<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_user extends CI_Controller {
	public function index()
	{
        $data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$this->load->view('create_user', $data);
		$this->load->view('template/footer');
    }


	public function check_details()
	{
		$this->load->library('email');
		$this->load->model('user_model');
		$data['error']= "";
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

		$username = $this->input->post('username'); //getting username from  account creation form
		$email = $this->input->post('email'); //getting email from  account creation form
		$password = $this->input->post('password'); //getting password from  account creation form
		$password_2 = $this->input->post('password_2'); //getting second password to check similarity
		$secret_question = $this->input->post('secret_question'); //receive secret question
		$secret_answer = $this->input->post('secret_answer'); //receive secret answer

		if ($this->user_model->create_user($username, $email, $password, $password_2, $secret_question, $secret_answer)) {
			$token = $this->user_model->get_token($email);
			$user_data = array(
				'username' => $username,
				'logged_in' => true 	//create session variable
			);

			//Send email to newly created user
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
			$this->session->set_userdata($user_data); //set user status to login in session
			$status = $this->session->flashdata('email_sent');		
			redirect('login'); // direct user home page

		} else {
			{
				$data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> Details were not entered correctly.</div> ";
				$this->load->view('create_user', $data);	//if user exists or password is incorrect, show error msg
			}
		}
		
	}
}
    ?>