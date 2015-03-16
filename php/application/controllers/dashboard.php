<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends TreeTrailController {

  public function index_get(){
    $this->load->model("manage_users_model", "users");  
	  $this->load->model('session_model', 'session_m');
    $this->load->model("login_model", "login");
    $data = [
		'name' => $this->login->getName($this->session->userdata("user_id")),
		'users_count' => $this->users->getUsersCount()
	];

		$users = $this->users->get_all();
		$users_table = $this->users->pretty($users);

		$data["users"] 		= $users_table;
		if($this->isLoggedIn && $this->isSuperAdmin):
			$this->render('dashboard', $data, [
				'layout' => 'layout'
			]);
		else:
			redirect('/');
		endif;
  }
  
}