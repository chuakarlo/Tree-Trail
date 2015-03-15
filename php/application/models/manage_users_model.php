<?php
class Manage_users_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function add() {
		date_default_timezone_set('Asia/Manila');
		
		$username 						= $this->input->post("username");
		$password						= md5('12345');
		$type							= 'users';
		$lastname 						= $this->input->post("lastname");
		$firstname 						= $this->input->post("firstname");
		$middlename 					= $this->input->post("middlename");
		$gender 						= $this->input->post("gender");
		$contactnumber				 	= $this->input->post("contactnumber");
		$address 						= $this->input->post("address");

		$this->db->trans_start();
		$users = array(
			"username"		=> $username,
			"password"		=> $password,
			"type"			=> $type,
			"date"			=> mdate("%Y-%m-%d"),
			"password_updated_on" => mdate("%Y-%m-%d")
		);
		$this->db->insert("users", $users);
		$user_id = $this->getCurrentID();
		$user_info = array(
			"first_name"			=> $firstname,
			"middle_name"			=> $middlename,
			"last_name"				=> $lastname,
			"gender"				=> $gender,
			"contact_number"		=> $contactnumber,
			"address"				=> $address,			
			"user_id"				=> $user_id
		);
		

		$this->db->insert("user_info", $user_info);
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	
	function update() {
		if($data = $this->input->post()):
			if(sizeof($updated_data = $this->did_change($data)) > 0):
			
				$user_id = $updated_data["id"];

				$this->db->trans_start();
				if(array_key_exists("user_info", $updated_data)):
					$this->db->where("user_id", $user_id)->update("user_info", $updated_data["user_info"]);
				endif;
				if(array_key_exists("users", $updated_data)):
					$this->db->where("id", $user_id)->update("users", $updated_data["users"]);
				endif;
				$this->db->trans_complete();
			endif;
		endif;

		return $this->db->trans_status();
	}

	function delete($id) {
		$this->db->trans_start();
		$this->db->where("user_id", $id)->delete(array("user_info"));
		$this->db->where("id", $id)->delete("users");
		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	function get($id) {
		$name			= $this->db->select("first_name, middle_name, last_name, gender, contact_number, address")->from("user_info")->where("user_id", $id)->get();
		$username		= $this->db->select("username, date")->from("users")->where("id", $id)->get();
	
		if($name->num_rows() > 0):
			foreach($name->result() as $row):
				$user_data["id"] = $id;
				$user_data["first_name"] = $row->first_name;
				$user_data["middle_name"] = $row->middle_name;
				$user_data["last_name"] = $row->last_name;
				$user_data["gender"] = $row->gender;
				$user_data["contact_number"] = $row->contact_number;
				$user_data["address"] = $row->address;
			endforeach;
			foreach($username->result() as $row):
				$user_data["username"] = $row->username;
				$user_data["date"] = $row->date;
			endforeach;
		else:
			$user_data = array();
		endif;

		$name->free_result();
		$username->free_result();

		return $user_data;
	}

	function get_all() {		
		$user_info			= $this->db->select("user_id, first_name, middle_name, last_name")->from("user_info")->get();
		$users				= $this->db->select("id, username, date")->from("users")->get();
		$merged_data = array();
		if($user_info->num_rows() > 0):
			$counter = 0;
			foreach($user_info->result() as $row):		
				if ($counter==1):
					$query = $this->db->select("username")->where("id", $row->user_id)->get("users");
			echo "HELLO";	
					$merged_data[$row->user_id]["user_id"] = $row->user_id;
					$merged_data[$row->user_id]["last_name"] = $row->last_name;
					$merged_data[$row->user_id]["first_name"] = $row->first_name;
					$merged_data[$row->user_id]["middle_name"] = $row->middle_name;
					$merged_data[$row->user_id]["update_id"] = "updateinfo_".$row->user_id;
					$merged_data[$row->user_id]["update_link"] = "<a href='#' onClick='show_modal(\"update\", \"".$row->user_id."\", ".$row->user_id.")'>Update</a>";
					$merged_data[$row->user_id]["delete_link"] = "<a href='#' onClick='show_modal(\"delete\", \"".$query->first_row()->username."\", ".$row->user_id.")'>Delete</a>";
				endif;
				$counter=1;
			endforeach;
			foreach($users->result() as $row):
				if ($counter==2):
					$merged_data[$row->id]["username"] = $row->username;
					$merged_data[$row->id]["date"] = $row->date;
				endif;
				$counter=2;
			endforeach;
		endif;

		$user_info->free_result();
		$users->free_result();

		return $merged_data;
	}

	function pretty($merged_data) {
		if(sizeof($merged_data) > 0):
			foreach($merged_data as $row):
				$pretty_data[$row["user_id"]][0] = $row["last_name"].", ".$row["first_name"]." ".$row["middle_name"];
				$pretty_data[$row["user_id"]][1] = $row["username"];
				$pretty_data[$row["user_id"]][2] = $row["date"];
				$pretty_data[$row["user_id"]][3] = array("class" => "center-text", "data" => $row["update_link"]);
				$pretty_data[$row["user_id"]][4] = array("class" => "center-text", "data" => $row["delete_link"]);
			endforeach;
		else:
			$pretty_data = array();
		endif;

		return $pretty_data;
	}

	function did_change($data) {
		$has_changed = false;

		if($data["username"] != $data["init_username"]):
			$updated_data["users"]["username"] = $data["username"];
			$has_changed = true;
		endif;
		if($data["lastname"] != $data["init_last_name"]):
			$updated_data["user_info"]["last_name"] = $data["lastname"];
			$has_changed = true;
		endif;
		if($data["middlename"] != $data["init_middle_name"]):
			$updated_data["user_info"]["middle_name"] = $data["middlename"];
			$has_changed = true;
		endif;
		if($data["firstname"] != $data["init_first_name"]):
			$updated_data["user_info"]["first_name"] = $data["firstname"];
			$has_changed = true;
		endif;		
		if($data["gender"] != $data["init_gender"]):
			$updated_data["user_info"]["gender"] = $data["gender"];
			$has_changed = true;
		endif;
		if($data["contactnumber"] != $data["init_contact_number"]):
			$updated_data["user_info"]["contact_number"] = $data["contactnumber"];
			$has_changed = true;
		endif;
		if($data["address"] != $data["init_address"]):
			$updated_data["user_info"]["address"] = $data["address"];
			$has_changed = true;
		endif;		
		
		if($has_changed):
			$updated_data["id"] = $data["id"];
		endif;

		return ($has_changed) ? $updated_data : array();
	}

	function getId($username) {
		$this->db->where('username', $username);
		$query = $this->db->get('users');
		
		$row = $query->row();
		return $row->id;
	}
	
	function validate($username, $password) {
		$this->db->where('username', $username);
		$this->db->where('password', md5($password));
		$query = $this->db->get('users');
		
		if ($query->num_rows() == 1) {
			return TRUE;
		}
	}
	
	function getAllData($username) {
		$this->db->where('username', $username);
		$query = $this->db->get('users');
		
		foreach($query->result_array() as $row)
			return $row;
	}

	function getUsersCount(){
		$maxid=0;

		$row = $this->db->select('COUNT(id) as id')->get("users")->row();
		if ($row) {
		    $maxid = $row->id; 
		}
		return $maxid;
	}	
	function getSuperAdminID() {
		$superadminID=1;
		$row = $this->db->select('min(id) as id')->get("users")->row();
		if ($row) {
		    $superadminID = $row->id; 
		}
		return $superadminID;	
	}	
	function getCurrentID() {
		$maxid=0;
		$row = $this->db->select('MAX(id) as id')->get("users")->row();
		if ($row) {
		    $maxid = $row->id; 
		}
		return $maxid;
	}	
}
?>