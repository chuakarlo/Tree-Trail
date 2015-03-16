<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends TreeTrailController {

  public function index_get() {
    $id = $this->session->userdata('user_id');
    $this->load->model("login_model", "login");
	
	if($id > 0):
	  $db_user_details = $this->db->select("first_name, last_name, middle_name, address, contact_number, gender")->from("user_info")->where_in("user_id", $id)->get()->row();
	  $db_username = $this->db->select("id, username, password, password_updated_on")->from("users")->where_in("id", $id)->get()->row();
	  $user = [
			'name' => $this->login->getName($this->session->userdata("user_id")),
            "form_id"				=> $id,
            "form_action"			=> "settings/update_info/".$id,				
            "form_last_name"		=> $db_user_details->last_name,
            "form_first_name" 		=> $db_user_details->first_name,
            "form_middle_name" 		=> $db_user_details->middle_name,
            "form_gender" 			=> $db_user_details->gender,
            "form_contact_number" 	=> $db_user_details->contact_number,
            "form_address" 			=> $db_user_details->address,
            "form_username"			=> $db_username->username,
            "form_password"			=> $db_username->password,
            "form_updated_on"		=> $db_username->password_updated_on
	  ];
	endif;
  
    if($this->isLoggedIn):
      $this->render('settings/settings_view', $user, [
        'layout' => 'layout'
      ]);
	else:
	  redirect('/');
	endif;
  }
  
  public function index_post() {
	$this->load->model("settings_model", "settings");
	if($this->post('target') == 'name'):
	  if($this->post('first-attempt') === 'false'):
		$this->form_validation->set_error_delimiters("", "");
		$this->form_validation->set_rules("first-name", "First Name", "required");
		$this->form_validation->set_rules("middle-name", "Middle Name", "required");
		$this->form_validation->set_rules("last-name", "Last Name", "required");
		$this->form_validation->set_rules("address", "Address", "required");
		$this->form_validation->set_rules("contact", "Mobile Number", "required|numeric|min_length[11]|max_length[13]");
      endif;
	  
	  if(!$this->form_validation->run()):
	    $data["settings_data"] = $this->settings->get();
		$this->load->view("settings/settings_name", $data);
	  else:
		if($this->settings->update('name')):
		  $this->output->set_output(json_encode([
		    'response' => 'Success!',
		    'title' => 'Update Successful',
		    'body' => 'Name has been successfully updated!'
		  ]));
		endif;
	  endif;
	elseif($this->post('target') == 'username'):
	  if($this->post('first-attempt') === 'false'):
		$this->form_validation->set_error_delimiters("", "");
		$this->form_validation->set_rules("username", "Username", "required|callback_check_if_username_exists|alpha_numeric|min_length[6]");
	  endif;
	  
	  if(!$this->form_validation->run()):
		$data["settings_data"] = $this->settings->get();
		$this->load->view("settings/settings_username", $data);
	  else:
		if($this->settings->update('user-name')):
		  $this->output->set_output(json_encode([
		    'response' => 'Success!',
		    'title' => 'Update Successful',
		    'body' => 'Username has been successfully updated!'
		  ]));
		endif;
	  endif;
	elseif($this->post('target') == 'password'):
	  if($this->post('first-attempt') === 'false'):
	    $this->form_validation->set_error_delimiters("", "");
		$this->form_validation->set_rules("current", "Current Password", "trim|required|xss_clean|callback_verify_old_pass_post");
		$this->form_validation->set_rules("newpass", "New Password", "trim|required|min_length[6]|max_length[32]");
		$this->form_validation->set_rules("matched", "Confirm", "trim|required|matches[newpass]");
	  endif;

	  if(!$this->form_validation->run()):
		$data["settings_data"] = $this->settings->get();
		$this->load->view("settings/settings_password", $data);
	  else:
		if($this->settings->update('password')):
		  $this->output->set_output(json_encode([
		    'response' => 'Success!',
		    'title' => 'Update Successful',
		    'body' => 'Password has been successfully updated!'
		  ]));
		endif;
	  endif;
	endif;
  }
  
  public function check_if_username_exists($username) {
    $query = $this->db->select("username")->where("username", $username)->get("users");
		
	if(empty($query->first_row()->username)):
	  return TRUE;
	else:
	  return FALSE;
	endif;
  }
  
  public function verify_old_pass() {
    $db_pass_input=$this->input->post('db_pass');
	  $id=$this->input->post('id');
      $result=$this->settings->check_password_match(md5($db_pass_input),$id);
      if($result)
        return TRUE;
      else
		return FALSE;
  }
  
  public function verify_old_pass_post() {
    $db_pass_input=$this->input->post('current');
	$id=$this->session->userdata('user_id');
    $result=$this->settings->check_password_match(md5($db_pass_input),$id);
    if($result):
	  return true;
	else:
	  $this->form_validation->set_message('verify_old_pass', 'Passwords do not match.');
	    return false;
	endif;
  }
  
}
