<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manage_users extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->helper('url');
	$this->load->model("manage_users_model", "users");    
  }

  public function index(){
	  $this->load->model('session_model', 'session_m');
    $this->load->model("login_model", "login");

			$users = $this->users->get_all();
			$users_table = $this->users->pretty($users);

			$data['name'] = $this->login->getName($this->session->userdata("user_id"));
			$data["users"] = $users_table;
			$data["isSuperAdmin"] = $this->session_m->isSuperAdmin();
			$data["isLoggedIn"] = $this->session_m->isLogin();
			
			if($this->session_m->isLogin() && $this->session_m->isSuperAdmin()):
				$this->load->view('manage_users', $data);
			else:
				redirect('/');
			endif;
  }

	public function manage_users_modal() {

		$id = $this->uri->segment(3);
		$submit = $this->input->post("submit");
	
		$this->form_validation->set_error_delimiters("", "");
		if($submit == "add"):
			$this->form_validation->set_rules("username", "Username", "required|alpha_numeric|min_length[6]|callback_check_if_username_exists");
		else:
			$this->form_validation->set_rules("username", "Username", "required|alpha_numeric|callback_check_if_conflict");
		endif;
		$this->form_validation->set_rules("lastname", "Last Name", "required");
		$this->form_validation->set_rules("firstname", "First Name", "required");
		$this->form_validation->set_rules("middlename", "Middle Name", "required");
		$this->form_validation->set_rules("gender", "Gender", "required");
		$this->form_validation->set_rules("contactnumber", "Contact Number", "required|numeric");
		$this->form_validation->set_rules("address", "Address", "required");

		if(!$this->form_validation->run()):
			$data["user_data"] = $this->users->get($id);
			$this->load->view("manage_users_modal", $data);
		else:
			$this->submit();
		endif;
	}

	function check_if_conflict($username) {
		$init_username = $this->input->post("init_username");
		
		if($username != $init_username):
			$query = $this->db->select("username")->where("username", $username)->get("users");
			
			if(empty($query->first_row()->username)):
				return TRUE;
			else:
				 $this->form_validation->set_message(__FUNCTION__, 'The username you entered is already used.');
				return FALSE;
			endif;
		else:
			return TRUE;
		endif;
	}

	function check_if_username_exists($username) {
		$query = $this->db->select("username")->where("username", $username)->get("users");
		
		if(empty($query->first_row()->username)):
			return TRUE;
		else:
			$this->form_validation->set_message(__FUNCTION__, 'The username you entered is already used.');
			return FALSE;
		endif;
	}
	
	public function delete_user() {
		$id = $this->uri->segment(3);		
		if($this->users->delete($id)):
			$this->output->set_output(json_encode([
				'title' => 'Delete Successful',
				'body' => 'The user has been successfully deleted!'
			]));
		else:
			$this->output->set_output(json_encode([
				'title' => 'Delete Failed',
				'body' => 'The user has not been deleted!'
			]));
		endif;
	}
	
	private function submit() {
		$submit = $this->input->post("submit");

		if($submit == "add"):
			if($this->users->add()):
				$this->output->set_output(json_encode([
					'response' => 'Success!',
					'title' => 'Add Successful',
					'body' => 'The user has been successfully added!'
				]));
			else:
				$this->output->set_output(json_encode([
					'response' => 'Failure!',
					'title' => 'Add Failed',
					'body' => 'The user has not been added!'
				]));
			endif;
		else:
			if($this->users->update()):
				$this->output->set_output(json_encode([
					'response' => 'Success!',
					'title' => 'Update Successful',
					'body' => 'The user has been successfully updated!'
				]));
			else:
				$this->output->set_output(json_encode([
					'response' => 'Failure!',
					'title' => 'Update Failed',
					'body' => 'The user has not been updated!'
				]));
			endif;
		endif;
		
	}
	
}
?>