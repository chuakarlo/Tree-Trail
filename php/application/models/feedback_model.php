<?php
class Feedback_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function add() {
		date_default_timezone_set('Asia/Manila');
		
		$name = $this->input->post("name");
		$email = $this->input->post("email");
		$subject = $this->input->post("subject");
		$comment = $this->input->post("comment");
		
		$data = array(
			'name' => $name,
			'email' => $email,
			'title' => $subject,
			'body' => $comment,
			'date_added' => mdate("%Y-%m-%d"),
		);
		
		return $this->db->insert("feedback", $data);
	}
	
	function update($action) {
		$user_id = $this->session->userdata("user_id");
	
		$first = $this->input->post("first-name");
		$middle = $this->input->post("middle-name");
		$last = $this->input->post("last-name");
		$gender = $this->input->post("gender");
		$address = $this->input->post("address");
		$contact = $this->input->post("contact");
		$username = $this->input->post("username");
		$password = $this->input->post("newpass");
		$ads = $this->input->post("ads");
		
		if($action == 'name'):
			$data = array(
				'first_name' => $first,
				'middle_name' => $middle,
				'last_name' => $last,
				'gender' => $gender,
				'address' => $address,
				'contact_number' => $contact
			);
		
			return $this->db->where("user_id", $user_id)->update("user_info", $data);
		elseif($action == 'user-name'):
			$data = array(
				'username' => $username
			);
			
			$this->session->set_userdata('username', $username);

			return $this->db->where("id", $user_id)->update("users", $data);
		elseif($action == 'ads'):
			$data = array(
				'list'=> $ads
			);

			return $this->db->update("ads", $data);
		else:
			date_default_timezone_set('Asia/Manila');
		
			$data = array(
				'password' => md5($password),
				'password_updated_on' => mdate("%Y-%m-%d")
			);
			
			return $this->db->where("id", $user_id)->update("users", $data);
		endif;
	}
}
?>