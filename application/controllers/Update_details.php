<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class update_details extends CI_Controller {
	public function index()
	{
        $data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$this->load->view('update_profile', $data);
		$this->load->view('template/footer');
    }

    public function update_name() {
        $data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$this->load->view('update_name', $data);
		$this->load->view('template/footer');
    }

	public function update_name_details() 
	{ 
		$this->load->model('user_model'); //load user model	
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$given_name = $this->input->post('given_name'); //getting new name from login form
		$surname = $this->input->post('surname'); //getting new surname from login form
		
		
		if($this->session->userdata('logged_in')) { //Check if user is logged in, if not redirects to the login page
			//attempts to change user details

			if ($this->user_model->update_name($given_name, $surname)) {
				$data['error'] = "<div class=\"alert alert-success\" role=\"alert\"> Your details have successfully been changed! <a href='<?php echo base_url(); ?>my_account'>Return to your account page. </a></div>";
                $this->load->view("update_name", $data);
			} else {
				$data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Please change at least one field. <a href=''>Return to your account page. </a></div>";
				$this->load->view("update_name", $data);
				
			}
			$this->load->view("template/footer");
		} else {
			redirect('login');
		}

	}

	public function update_email() 
	{ 
		$this->load->model('user_model'); //load user model
		$data['update'] = "email";		
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$this->load->view("update_profile", $data);
		$this->load->view("template/footer");
	}

	public function update_contact_number() 
	{ 
		$this->load->model('user_model'); //load user model
		$data['update'] = "contact_number";		
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$this->load->view("update_profile", $data);
		$this->load->view("template/footer");
	}

	public function update_password() 
	{ 
		$this->load->model('user_model'); //load user model
		$data['update'] = "password";		
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$this->load->view("update_password", $data);
		$this->load->view("template/footer");
	}

	public function update_password_details() 
	{ 
		$this->load->model('user_model'); //load user model	
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');

		/* Retrieve form info using post */
		$old_password = $this->input->post('old_password');
		$new_password = $this->input->post('new_password'); 
		$new_password_verify = $this->input->post('new_password_verify');
		$username = $this->session->userdata('username');

		
		if($this->session->userdata('logged_in')) { //Check if user is logged in, if not redirects to the login page
			//attempts to change user details

			if ($this->user_model->update_password($username, $old_password, $new_password, $new_password_verify)) {
				$data['error'] = "<div class=\"alert alert-success\" role=\"alert\"> Your details have successfully been changed! <a href='<?php echo base_url(); ?>my_account'>Return to your account page. </a></div>";
                redirect("update_details", $data);
			} else {
				$data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> You enter the wrong old password. Please try again. <a href=''>Return to your account page. </a></div>";
				$this->load->view("update_password", $data);
				
			}
			$this->load->view("template/footer");
		} else {
			redirect('login');
		}
	}
}

    ?>