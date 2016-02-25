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
}
?>