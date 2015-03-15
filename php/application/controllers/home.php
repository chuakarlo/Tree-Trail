<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends TreeTrailController {

  public function index_get(){
    $this->load->model("login_model", "login");
    $data = ['name' => $this->login->getName($this->session->userdata("user_id"))];

    $this->render('home', $data, [
      'layout' => 'layout'
    ]);
  }
  
}
