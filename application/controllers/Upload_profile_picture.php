<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class upload_profile_picture extends CI_Controller
{
    public function index()
    {
		$this->load->view('template/header'); 
    	if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array('username' => $username,'logged_in' => true );
					$this->session->set_userdata($user_data); //set user status to login in session
					$this->load->view('upload_profile_picture',array('error' => ' ')); //if user already logined show upload page
				}
			}else{
				redirect('login'); //if user already logined direct user to home page
			}
		}else{
			$this->load->view('upload_profile_picture',array('error' => ' ')); //if user already logined show login page
		}
		$this->load->view('template/footer');
    }

	//Uploads selected profile pic to database, makes it user's profile picture 
    public function do_upload() {
		$this->load->model('file_model');
        $config['upload_path'] = './uploads/profile_pictures';
		$config['allowed_types'] = 'jpg|png|jfif|jpeg';
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('userfile')) { //Checks if upload can be made based on the configuration detailed above
            $this->load->view('template/header');
            $data = array('error' => $this->upload->display_errors());
            $this->load->view('upload_profile_picture', $data);
            $this->load->view('template/footer');
			
        } else { //If so, resizes the image down to 100x100, and uploades it to the db. 
			$this->file_model->upload_profile_picture($this->upload->data('file_name'), $this->upload->data('full_path'),$this->session->userdata('username'));

			$config_2['source_image'] = $this->upload->data('full_path');
			$config_2['width'] = 250;
			$config_2['height'] = 500;
			$this->load->library('image_lib', $config_2);
			$this->image_lib->resize();


            $this->load->view('template/header');
            //$this->load->view('upload_profile_picture', array('error' => 'File upload success. <br/>'));
            redirect('my_account');
			$this->load->view('template/footer');
        }
	}

	
}


