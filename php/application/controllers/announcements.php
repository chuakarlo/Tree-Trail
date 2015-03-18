<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Announcements extends TreeTrailController {

  public function __construct(){
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('contact_model','contacts');
    $this->load->model('announcements_model','announcements');
    $this->load->model("login_model", "login");
  }

  public function index_get(){

    $c = $this->get('key');
    if($c == 'view'){
      $this->render('announcements',[
        'announcements'=>$this->announcements->read(),
        'name' => $this->login->getName($this->session->userdata("user_id")),
      ],[
     'layout'=>'layout'
      ]);
     }else{
    if($this->isLoggedIn){
      $this->render('announcements_admin',[
        'announcements'=>$this->announcements->read(),
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
    
    $validator = new Valitron\Validator($con);
    $validator->rule('required', ['title', 'body']);
    $validator->rule('lengthMin', ['title','body'], 6);
    $iscon = $validator->validate();
    if($iscon){
      $this->announcements->create($con);
      $this->renderPageWithData([
        'message' => 'Announcement has been successfully created.',
        'announcements'=>$this->announcements->read(),
        'name' => $this->login->getName($this->session->userdata("user_id")),
      ]);
    } else{
      $this->renderPageWithData([
        'error' => 'Announcement not successfully updated (each field requires a minimum of 6 characters).',
        'announcements'=>$this->announcements->read(),
        'name' => $this->login->getName($this->session->userdata("user_id")),
      ]);
    }
  }
  else if($action == 'edit'){
      $this->render('announcements_edit',[
        'announcementsedit'=>$this->announcements->read([ 'id' => $this->post('id')]),
        'name' => $this->login->getName($this->session->userdata("user_id"))
      ],[
     'layout'=>'layout'
    ]);
  }
  else if($action == 'edited'){
    $con = $this->post();
    unset($con['action']);
    $validator = new Valitron\Validator($con);
    $validator->rule('required', ['title', 'body']);
    $validator->rule('lengthMin', ['title','body'], 6);
    $iscon = $validator->validate();
    if($iscon){
     $this->announcements->update($con);
     $this->renderPageWithData([
        'message' => 'Announcement has been successfully updated.',
        'announcements'=>$this->announcements->read(),
        'name' => $this->login->getName($this->session->userdata("user_id"))
      ]);
    }else{
      $this->renderPageWithData([
        'error' => 'Announcement not successfully updated (each field requires a minimum of 6 characters).',
        'announcements'=>$this->announcements->read(),
        'name' => $this->login->getName($this->session->userdata("user_id")),
      ]);
    }
  }
  else if($action == 'delete'){
  	$this->announcements->delete(['id'=>$this->post('id')]);
    $this->renderPageWithData([
        'message' => 'Account successfully deleted.',
        'announcements'=>$this->announcements->read(),
        'name' => $this->login->getName($this->session->userdata("user_id"))
      ]);
  	}
 }

 private function renderPageWithData($data = []){
    $this->render('announcements_admin', $data, [
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