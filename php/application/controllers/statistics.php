<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// class statistics extends CI_Controller {
class statistics extends TreeTrailController {


  public function index_get() {
	  $this->load->model('statistics_model','s_model');
	  $this->load->model('session_model','session_m');
	  $this->load->model("login_model", "login");
      $data = ['name' => $this->login->getName($this->session->userdata("user_id"))];
	  
	  $stat = $this->s_model->retrieve_all();
	  $data['num_rows'] = $stat->num_rows();
	  $data['data'] = $stat->result_array();

	  // if($this->session_m->isLogin()):
		$this->render('statistics_page', $data, [
			'layout' => 'layout'
		]);
	  // else:
	    // redirect('/');
	  // endif;
	
  }
  
}
