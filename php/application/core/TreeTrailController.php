<?php defined('BASEPATH') or exit('No direct script access allowed');


class TreeTrailController extends RestController{

  protected $isLoggedIn = false;
  protected $isSuperAdmin = false;
  protected $isAdmin = false;

  public function __construct(){
    parent::__construct();
    $this->load->model('session_model', 'tree_trail_session');
    
    $this->isLoggedIn = $this->tree_trail_session->isLogin();
    $this->isSuperAdmin = $this->tree_trail_session->isSuperAdmin();
    $this->isAdmin = ($this->isLoggedIn && !$this->isSuperAdmin);

    if($this->isSuperAdmin) $this->redirectToDashboardIfSuperAdmin();
  }

  public function render($view = NULL, $data = [], $partials = []){

    // Add the partials and pragmas
    $renderer = new Mustache_Engine([
      'pragmas' => [Mustache_Engine::PRAGMA_BLOCKS],
      'partials' => array_map(function($partial){
        return $this->load->view($partial, NULL, true);
      }, $partials)
    ]);

    // Inject common data

    // These need to be strings because Mustache doesn't convert true and false
    // to actual strings.
    $data['isLoggedIn'] = $this->isLoggedIn;
    $data['isAdmin'] = $this->isAdmin;
    $data['isSuperAdmin'] = $this->isSuperAdmin;

    $data['isLoggedInString'] = $this->isLoggedIn ? 'true' : 'false';
    $data['isAdminString'] = $this->isAdmin ? 'true' : 'false';
    $data['isSuperAdminString'] = $this->isSuperAdmin ? 'true' : 'false';
    
    $contents = $renderer->render($this->load->view($view, NULL, true), $data);
    $this->output->set_output($contents);
  }

  // Redirects super user to dashboard. Override to avoid.
  public function redirectToDashboardIfSuperAdmin(){
    redirect('/dashboard');
  }

}