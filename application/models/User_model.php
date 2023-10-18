<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//put your code here
class User_model extends CI_Model {
	public function login($login, $password) {
		//Query for username or email and password to see if a result exists, returns true if it does
		$this->db->select('password')
		->group_start()
			->where('username', $login)
			->or_group_start()
				->or_where('email', $login)
			->group_end()
		->group_end();
		
		$query = $this->db->get('users');

		if($query->num_rows() == 1) {

			foreach ($query->result() as $tuple) {
				$hash = $tuple->password;
		}

			return (password_verify($password, $hash)); 		
		} else {
			false;
		} 
	}

	public function get_username($login) {
		$username = '';
		$this->db->select('username');
		$this->db->where('email', $login);
		$this->db->or_where('username', $login);
		$query = $this->db->get('users');

		if($query->num_rows() == 1) {
			foreach ($query->result() as $tuple) {
				$username = $tuple->username;
			}
		}

		return $username;
		
	}

	public function create_user($username, $email, $password, $password_2, $secret_question, $secret_answer) {
		// Validate
		$token = uniqid();
		$special_characters = array(
			'%', '&', '(', ')', '-', '=', '_', '+', ';', ':', "'", '"', ',', '<', '.', '>', '/'
		);

		//Checks that password length is greater than 7 and the password and password reconfirmation values are the same
		if($password == $password_2 && strlen($password) > 7) {
			//Checks password for at least one special character.
			foreach ($special_characters as $value) {
				if (strpos($password, $value)) {
					return false;
				}
			}

			$password_hash = password_hash($password, PASSWORD_DEFAULT);

			$user_data = array(
				'username' => $username,
				'email' => $email,
				'password' => $password_hash,
				'token' => $token,
				'secret_question' => $secret_question,
				'secret_answer' => $secret_answer
			);

			//Checks if username or email already exist in the user database
			$this->db->where('username', $username);
			$this->db->or_where('email', $email);

			$result = $this->db->get('users');
			
			if($result->num_rows() == 0) {
				
				$this->db->insert('users', $user_data);
				
				return true;
			} else {
				false;
			}
		} else {
			return false;
		}
	}
	
	public function complete_profile($given_name, $last_name, $dob, $contact_number) {
		$user_data = array(
			'given_name' => $given_name,
			'surname' => $last_name,
			'dob' => $dob,
			'contact_number' => $contact_number,
			'validated' => 1
		);

		if($contact_number > date("d/m/Y")) {
			return false;
		} else {

			$username = $this->session->userdata('username');
			$this->db->where('username', $username);

			$this->db->update('users', $user_data);
			return true;
		}
	}

	//Function updates the name, surname and dob of a user.
	public function update_name($given_name, $surname) {
	
		$new_given_name = array(
			'given_name' => $given_name
		);

		$new_surname = array(
			'surname' => $surname
		);	
		
		
		$username = $this->session->userdata('username');	 
		
		//Checks if form is empty; if not, sends false result which brings up an error message
		if (!($given_name == '' && $surname == '')) {

			if ($given_name != '') {
				$this->db->where('username', $username);
				$this->db->update('users', $new_given_name);
			}

			if ($surname != '') {
				$this->db->where('username', $username);
				$this->db->update('users', $new_surname);
			}

			return true;
		
		} else {
		
			return false;
		}
	}

	//Updates email for user
	public function update_email($given_name, $surname, $dob) {
	
		$new_given_name = array(
			'given_name' => $given_name
		);

		$new_surname = array(
			'surname' => $surname
		);	
		
		$new_dob = array(
			'dob' => $dob 
		);
		
		$username = $this->session->userdata('username');	 
		
		//Checks if form is empty; if not, sends false result which brings up an error message
		if (!($given_name == '' && $surname == '' && $dob == '')) {

			if ($given_name != '') {
				$this->db->where('username', $username);
				$this->db->update('users', $new_given_name);
			}

			if ($surname != '') {
				$this->db->where('username', $username);
				$this->db->update('users', $new_surname);
			}

			if ($dob != '') {
				$this->db->where('username', $username);
				$this->db->update('users', $new_dob);
			}
				
			return true;
		
		} else {
		
			return false;
		}
	}

	//Updates contact number for a user
	public function update_number($old_number, $surname, $dob) {
	
		$new_given_name = array(
			'given_name' => $given_name
		);

		$new_surname = array(
			'surname' => $surname
		);	
		
		$new_dob = array(
			'dob' => $dob 
		);
		
		$username = $this->session->userdata('username');	 
		
		//Checks if form is empty; if not, sends false result which brings up an error message
		if (!($given_name == '' && $surname == '' && $dob == '')) {

			if ($given_name != '') {
				$this->db->where('username', $username);
				$this->db->update('users', $new_given_name);
			}

			if ($surname != '') {
				$this->db->where('username', $username);
				$this->db->update('users', $new_surname);
			}

			if ($dob != '') {
				$this->db->where('username', $username);
				$this->db->update('users', $new_dob);
			}
				
			return true;
		
		} else {
		
			return false;
		}
	}
	
	//Updates password for  user
	public function update_password($login, $old_password, $new_password, $new_password_verify) {
	

		//Check that old password is the right one for the user.
		$this->db->select('*')
		->group_start()
			->where('username', $login)
			->or_where('email', $login)
		->group_end()
		->where("password", $old_password);
		
		$result = $this->db->get('users');

		if($result->num_rows() != 1) {
			return false;
		}

		//Make sure old password doesn't match new one's, and new ones match
		if (/*$old_password == $new_password || */$new_password != $new_password_verify) {
			return false;
		}

		$special_characters = array(
			'%', '&', '(', ')', '-', '=', '_', '+', ';', ':', "'", '"', ',', '<', '.', '>', '/'
		);

		//Checks that password length is greater than 7 and the password and password reconfirmation values are the same
		if (strlen($new_password) > 7) {
			//Checks password for at least one special character.
			foreach ($special_characters as $value) {
				if (strpos($new_password, $value)) {
					return false;
				}
			}
			$password_hash = password_hash($new_password, PASSWORD_DEFAULT);

			$password = array(
				'password' => $password_hash
			);

			$this->db->where('username', $login);
			$this->db->or_where('email', $login);
			$this->db->update('users', $password);

			return true;
		}
		

	}

	//function to return a list of questions to display on the discussion page
	public function get_questions() {
		
		$query_data = array();
		//array of all questions
		$query = $this->db->get('questions');
	
		foreach ($query->result() as $tuple) {
				array_push( 
					$query_data,
					array( 
						$tuple->question_id,
						$tuple->question_title,
						$tuple->question_author,
						$tuple->question_text,
						$tuple->question_date,
						$tuple->ratings
					)
				);
		}
		return $query_data;
	}

	//function to return a list of questions to display on the discussion page
	public function get_questions_search($query) {
		
		if ($query == '') {
			return null;
		} else {
			$this->db->select("*");
			$this->db->from('questions');
			$this->db->like("question_text", $query);
			$this->db->or_like("question_title", $query);
			$this->db->or_like('question_author', $query);
			$this->db->order_by("ratings", "DESC");
			return $this->db->get();
		}

	}

	/*get answers from database as an array */
	public function get_answers() {
		$query_data = array();
		//array of all questions
		$query = $this->db->get('answers');
	
		foreach ($query->result() as $tuple) {
				array_push( 
					$query_data,
					array( 
						$tuple->answer_id,
						$tuple->question_id,
						$tuple->answer_author,
						$tuple->answer_text,
						$tuple->answer_date,
						$tuple->ratings
					)
				);
		}
		return $query_data;
	}

	//function to return all the user's details 
	public function get_user_details() {
		$query_data = array();
		//array of all user info
		$this->db->select('id, username, email, given_name, surname, dob, contact_number, token, validated');
		$query = $this->db->get('users');
	
		foreach ($query->result() as $tuple) {
				array_push( 
					$query_data,
					array( 
						$tuple->id,
						$tuple->username,
						$tuple->email,
						$tuple->given_name,
						$tuple->surname,
						$tuple->dob,
						$tuple->contact_number,
						$tuple->token,
						$tuple->validated
					)
				);
		}
		return $query_data;
	}

	//Check validity of profile; if they have added a phone number, given name, etc.
	public function get_validation($username) {

		$this->db->select('validated');
		$this->db->where('username', $username);
		$this->db->or_where('email', $username);
		$query = $this->db->get('users');

		foreach ($query->result() as $tuple) {
			if ($tuple->validated == TRUE) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}
	
	public function confirm_token($username, $token) {
		$this->db->where('username', $username);
		$this->db->where('token', $token);
		$query = $this->db->get('users');

		if ($query->num_rows() == 0) {
			return FALSE;
		} else {
			$this->db->set('token', NULL);
			$this->db->where('username', $username);
			$this->db->update('users');
			return TRUE;
		}
	}

	public function post_answer($question_id, $answer_author, $answer_text) {
		$answer_date = date('Y-m-d');	
		
		$user_data = array(
			"question_id" => $question_id,
			"answer_author" => $answer_author,
			"answer_text" => $answer_text,
			"answer_date" => $answer_date
		);
		
		$this->db->insert('answers', $user_data);

		return true;
	}

	Public function toggle_question_favourite($question_id, $username) {

		//Check if user has already favourited this question.
		
		$user_data = array(
			'question_id' => $question_id,
				'username' => $username
		);
		
		//Uses the check_question_favourite function to check if the user haS favourited the question 
		if ($this->check_question_favourite($question_id, $username)) {
			$this->db->insert('favourited_questions', $user_data);				
			
			$this->db->set('ratings', 'ratings+1', false);
			$this->db->where('question_id', $question_id);
			$this->db->update('questions');
			return true;
		
		} else {

			$this->db->where('question_id', $question_id);
			$this->db->where('username', $username);
			$this->db->delete('favourited_questions');
			

			$this->db->set('ratings', 'ratings-1', false);
			$this->db->where('question_id', $question_id);
			$this->db->update('questions');
			return false;
		
		}
	}

	/*function checks if question has already been favorited by the user.
		If so, will change the favourite button to reflect this status.
	*/
	
	public function check_question_favourite($question_id, $username) {

		$this->db->where('question_id', $question_id);
		$this->db->where('username', $username);
		$result = $this->db->get('favourited_questions');
		
		if($result->num_rows() == 0) {				
	
			return true;
			
		} else {
			return false;
		}
	}

	public function check_email($email) {
		$this->db->where('email', $email);
		$result = $this->db->get('users');
		if($result->num_rows() == 1) {				
			return true;
		} else {
			return false;
		}
	}

	public function get_token($login) {
		$this->db->select('token');
		$this->db->where('email', $login);
		$this->db->or_where('username', $login);
		$result = $this->db->get('users');
		if($result->num_rows() == 1) {				
			foreach ($result->result() as $tuple) {
				return $tuple->token;
			}
		} else {
			return FALSE;
		}
	}

	public function get_email($username) {
		$this->db->select('email');
		$this->db->where('username', $username);
		$result = $this->db->get('users');				
		foreach ($result->result() as $tuple) {
				return $tuple->email;
		}

	}
	
	public function get_secret_question($email) {
		$this->db->select('secret_question');
		$this->db->where('email', $email);
		$query = $this->db->get('users');
		
		if($query->num_rows() == 1) {				
			foreach ($query->result() as $tuple) {
				return $tuple->secret_question;
			}
		} else {
			return false;
		}
	}
		
	//Verifies the validity of secret question answer
	public function verify_account($email, $secret_question, $secret_answer) {

		$this->db->where('secret_question', $secret_question);
		$this->db->where('secret_answer', $secret_answer);
		$this->db->where('email', $email);
		$result = $this->db->get('users');
		
		if($result->num_rows() == 1) {				
			return true;
		} else {
			return false;
		}
	}

	//Updates password for a given email (via recovery)
	public function change_password($email, $password, $password_2) {
		$special_characters = array(
			'%', '&', '(', ')', '-', '=', '_', '+', ';', ':', "'", '"', ',', '<', '.', '>', '/'
		);

		//Checks that password length is greater than 7 and the password and password reconfirmation values are the same
		if($password == $password_2 && strlen($password) > 7) {
			//Checks password for at least one special character.
			foreach ($special_characters as $value) {
				if (strpos($password, $value)) {
					return false;
				}
			}
		}
			$password_hash = password_hash($password, PASSWORD_DEFAULT);

		$query_data = array(
			'password' => $password_hash
		);

		$this->db->where('email', $email); 
		$this->db->update('users', $query_data);

		return true;
		}

}	
?>
