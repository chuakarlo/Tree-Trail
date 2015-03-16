<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends TreeTrailController {

  public function __construct(){
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('contact_model','contacts');
  }

  public function index_get(){

    $this->load->model("login_model", "login");
    $c = $this->get('key');
    if($c == 'ammil'){
      if($this->isAdmin){
      $this->render('contacts',['contacts'=>$this->contacts->read()],[
     'layout'=>'layout'
      ]);
     }
    else if($this->isSuperAdmin){
      $this->render('contacts',['contacts'=>$this->contacts->read()],[
     'layout'=>'layout'
      ]);
     }
    }else{
    if($this->isAdmin){
      $this->render('contact_admin',[
        'contacts'=>$this->contacts->read(),
        'name' => $this->login->getName($this->session->userdata("user_id")),
      ],[
     'layout'=>'layout'
    ]);
    }
    else if($this->isAdmin){
      $this->render('contact',['contacts'=>$this->contacts->read()],[
     'layout'=>'layout'
    ]);
    }
    else if($this->isSuperAdmin){
       $this->render('contact_admin',[
        'contacts'=>$this->contacts->read(),
        'name' => $this->login->getName($this->session->userdata("user_id")),
      ],[
     'layout'=>'layout'
    ]);
    }else{
      $this->render('contacts',['contacts'=>$this->contacts->read()],[
     'layout'=>'layout'
      ]);
    }
    }//end else
  }

 public function index_post(){
  $action = $this->post('action');
  if($action === 'add'){
  	$con = $this->post();
    unset($con['action']);
    $validator = new Valitron\Validator($con);
    $validator->rule('required', ['contact_person', 'contact_number','email','organization']);
    $validator->rule('lengthMin', ['contact_person','organization'], 6);
    $validator->rule('lengthMin', ['contact_number'], 7);

    $iscon = $validator->validate();
    if($iscon){
      $this->contacts->create($con);
      $this->renderPageWithData([
        'message' => 'Account has been successfully created.',
        'contacts'=>$this->contacts->read()
      ]);
    } else{
      $this->renderPageWithData([
        'error' => 'Account not successfully created. Please try again (each field requires a minimum of 7 characters).',
        'contacts'=>$this->contacts->read()
      ]);
    }
  }
  else if($action == 'edit'){
      $this->render('contactedit',['contactedit'=>$this->contacts->read([ 'id' => $this->post('id')])],[
     'layout'=>'layout'
    ]);
  }
  else if($action == 'edited'){
    $con = $this->post();
    unset($con['action']);
    $validator = new Valitron\Validator($con);
    $validator->rule('required', ['contact_person', 'contact_number','email','organization']);
    $validator->rule('lengthMin', ['contact_person','organization'], 6);
    $validator->rule('lengthMin', ['contact_number'], 7);

    $iscon = $validator->validate();
    if($iscon){
     $this->contacts->update($con);
     $this->renderPageWithData([
        'message' => 'Account has been successfully updated.',
        'contacts'=>$this->contacts->read()
      ]);
    }else{
      $this->renderPageWithData([
        'error' => 'Account not successfully updated. Please try again (each field requires a minimum of 7 characters).',
        'contacts'=>$this->contacts->read()
      ]);
    }
  }
  else if($action == 'delete'){
  	$this->contacts->delete(['id'=>$this->post('id')]);
    $this->renderPageWithData([
        'message' => 'Account successfully deleted.',
        'contacts'=>$this->contacts->read()
      ]);
  	}
 }

 private function renderPageWithData($data = []){
    $this->render('contact_admin', $data, [
      'layout' => 'layout'
    ]);
  }

}