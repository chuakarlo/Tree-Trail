<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedback extends TreeTrailController {

  public function index_get(){
    $this->load->model("login_model", "login");
    $this->load->model("feedback_view_model", "feedback_view_m");
    $data = [
		'name' => $this->login->getName($this->session->userdata("user_id")),
		'feedback' => $this->feedback_view_m->read()
	];

	if(!$this->isLoggedIn):
		$this->render('feedback', NULL, [
		  'layout' => 'layout'
		]);
	else:
		$this->render('feedback_view', $data, [
		  'layout' => 'layout'
		]);
	endif;
  }
  
  public function index_post() {
  	$action = $this->post('action');
  	if($action == 'delete'){
  		$this->load->model("login_model", "login");
	    $this->load->model("feedback_view_model", "feedback_view_m");
		
  		$this->feedback_view_m->delete(['id'=>$this->post('id')]);
	    
	    $data = [
			'message' => 'Feedback successfully deleted.',
			'feedback'=>$this->feedback_view_m->read(),
			'name' => $this->login->getName($this->session->userdata("user_id")),
		];
	    $this->render('feedback_view', $data, [
	    	'layout' => 'layout'
	    ]);
  	} else {
  		$this->load->model("login_model", "login");
	    $this->load->model("feedback_model", "feedback_m");
		
		$this->form_validation->set_error_delimiters("", "");
		$this->form_validation->set_rules("name", "Name", "required");
		$this->form_validation->set_rules("email", "Email Address", "required|valid_email");
		$this->form_validation->set_rules("comment", "Comment Area", "required");
		
		if(!$this->form_validation->run()):
			$this->render('feedback', NULL, [
				'layout' => 'layout'
			]);
		else:
			$this->feedback_m->add();
			$data = [
				'message' => 'Feedback successfully added.',
				'name' => $this->login->getName($this->session->userdata("user_id")),
				'success' => 'success'
			];
			$this->render('feedback', $data, [
				'layout' => 'layout'
			]);
		endif;
  	}
    
  }
  
}
