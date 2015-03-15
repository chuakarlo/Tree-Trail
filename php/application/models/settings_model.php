<?php
class Settings_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get() {
		$user_id = $this->session->userdata("user_id");
		
		$user_details = $this->db->select("first_name, middle_name, last_name, address, contact_number, gender")->from("user_info")->where_in("user_id", $user_id)->get();
		
		$username_details = $this->db->select("id, username, password, password_updated_on")->from("users")->where_in("id", $user_id)->get();

		foreach($user_details->result() as $row):
			$settings_data["first_name"] = $row->first_name;
			$settings_data["middle_name"] = $row->middle_name;
			$settings_data["last_name"] = $row->last_name;
			$settings_data["gender"] = $row->gender;
			$settings_data["address"] = $row->address;
			$settings_data["contact"] = $row->contact_number;
		endforeach;
		
		foreach($username_details->result() as $row):
			$settings_data["username"] = $row->username;
		endforeach;

		$user_details->free_result();
		$username_details->free_result();

		return $settings_data;
	}
	
	 public function check_password_match($db_pass_input,$id)
    {

        $db_user    = $this->db->select("id, password")->where('id', $id)->from("users")->get()->row();
        $db_pass    = $db_user->password; 
        if($db_pass==$db_pass_input)
            return true;
        else 
            return false;
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