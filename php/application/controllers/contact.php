<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends TreeTrailController {

  public function __construct(){
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('contact_model','contacts');
    $this->load->model("login_model", "login");
  }

  public function index_get(){

    $c = $this->get('key');
    if($c == 'view'){
      $this->render('contacts',[
        'contacts'=>$this->contacts->read(),
        'name' => $this->login->getName($this->session->userdata("user_id")),
      ],[
     'layout'=>'layout'
      ]);
     }else{
    if($this->isLoggedIn){
      $this->render('contact_admin',[
        'contacts'=>$this->contacts->read(),
        'name' => $this->login->getName($this->session->userdata("user_id")),
      ],[
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
    
    $this->load->library('upload', [
      'file_name' => $this->generateUuid(),
      'upload_path' => realpath(APPPATH . '../static/uploaded_photos/'),
      'allowed_types' => 'gif|jpg|png',
      'max_size' => '2048',
    ]);
    
    $con['image_path'] = ($this->upload->do_upload('image_path')) ? $this->upload->data()['file_name'] : '';

    $validator = new Valitron\Validator($con);
    $validator->rule('required', ['contact_person', 'contact_number','email','organization']);
    $validator->rule('lengthMin', ['contact_person','organization'], 6);
    $validator->rule('lengthMin', ['contact_number'], 7);
    $validator->rule('numeric', ['contact_number']);
    $validator->rule('email', 'email');
    $iscon = $validator->validate();
    if($iscon){
      $this->contacts->create($con);
      $this->renderPageWithData([
        'message' => 'Account has been successfully created.',
        'contacts'=>$this->contacts->read(),
        'name'    =>$this->login->getName($this->session->userdata("user_id")),
      ]);
    } else{
      $this->renderPageWithData([
        'error' => 'Account not successfully updated (each field requires a minimum of 7 characters, a valid number and email).',
        'contacts'=>$this->contacts->read(),
        'name'    =>$this->login->getName($this->session->userdata("user_id")),
      ]);
    }
  }
  else if($action == 'edit'){
      $this->render('contactedit',[
        'contactedit'=>$this->contacts->read([ 'id' => $this->post('id')]),
        'name' => $this->login->getName($this->session->userdata("user_id")),
      ],[
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
    $validator->rule('numeric', ['contact_number']);
    $validator->rule('email', 'email');
    $iscon = $validator->validate();
    if($iscon){
     $this->contacts->update($con);
     $this->renderPageWithData([
        'message' => 'Account has been successfully updated.',
        'contacts'=>$this->contacts->read(),
        'name'    =>$this->login->getName($this->session->userdata("user_id")),
      ]);
    }else{
      $this->renderPageWithData([
        'error' => 'Account not successfully updated (each field requires a minimum of 7 characters, a valid number and email).',
        'contacts'=>$this->contacts->read(),
        'name'    =>$this->login->getName($this->session->userdata("user_id")),
      ]);
    }
  }
  else if($action == 'delete'){
  	$this->contacts->delete(['id'=>$this->post('id')]);
    $this->renderPageWithData([
        'message' => 'Account successfully deleted.',
        'contacts'=>$this->contacts->read(),
        'name'    =>$this->login->getName($this->session->userdata("user_id")),
      ]);
  	}
 }

 private function renderPageWithData($data = []){
    $this->render('contact_admin', $data, [
      'layout' => 'layout'
    ]);
  }

  private function generateUuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
      mt_rand( 0, 0xffff ),
      mt_rand( 0, 0x0fff ) | 0x4000,
      mt_rand( 0, 0x3fff ) | 0x8000,
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
  }
}