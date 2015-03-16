<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Badges extends TreeTrailController {

  public function __construct(){
    parent::__construct();
    $this->load->model('Badges_Model', 'badges');
    $this->load->model('Photos_Model', 'photos');
  }

  public function index_get(){
    $badges = $this->isLoggedIn ? $this->badges->readWithPhotos() : $this->badges->readWithPhotosApproved();
    $this->response($badges);
  }

  public function index_post(){
    $data = $this->post();

    $validator = new Valitron\Validator($data);
    $validator->rule('required', ['name', 'latitude', 'longitude', 'types', 'abundance', 'quantity', 'email']);
    $validator->rule('numeric', ['latitude', 'longitude', 'quantity']);
    $validator->rule('email', ['email']);
    $validator->rule('min', 'quantity', 0);
    $validator->rule('in', 'abundance', ['abundant', 'average', 'scarce']);
    if(!$validator->validate()) return $this->response(null, 400);

    // Remove photos from the creation process. They get saved later
    $photos = isset($data['photos']) ? $data['photos'] : [];
    unset($data['photos']);
    
    if($this->isLoggedIn) $data['approved'] = 1;

    $savedBadge = $this->badges->create($data);
    if(!$savedBadge) return $this->response(null, 500);
    
    $savedPhotos = $this->savePhotos($savedBadge['id'], $photos);
    if(!$savedPhotos) return $this->response(null, 500);

    $badges = $this->badges->readWithPhotos();
    $badgesInRecord = array_values(array_filter($badges, function($badge) use ($savedBadge){
      return $badge['id'] === $savedBadge['id'];
    }));
    $badgeInRecord = count($badgesInRecord) ? $badgesInRecord[0] : [];

    $this->response($badgeInRecord, 201);
  }

  public function index_put(){
    if(!$this->isLoggedIn) return $this->response(null, 403);

    $data = $this->put();
    $validator = new Valitron\Validator($data);
    $validator->rule('required', ['id', 'name', 'latitude', 'longitude', 'types', 'abundance', 'quantity', 'email']);
    $validator->rule('numeric', ['latitude', 'longitude', 'quantity']);
    $validator->rule('in', 'abundance', ['abundant', 'average', 'scarce']);
    $validator->rule('email', 'email');
    $validator->rule('min', 'quantity', 0);
    $validator->rule('integer', 'id');
    $validator->rule('min', 'id', 1);

    $photos = isset($data['photos']) ? $data['photos'] : [];
    unset($data['photos']);
    unset($data['approvalRequest']);
    $savedBadge = $this->badges->update($data);
    if(!$savedBadge) return $this->response(null, 500);
    
    $savedPhotos = $this->photos->deleteWithLocationId($savedBadge['id']);
    $savedPhotos = $this->savePhotos($savedBadge['id'], array_map(function($photo){
      return $photo['image_path'];
    }, $photos));
    if(!$savedPhotos) return $this->response(null, 500);

    if($this->put('approvalRequest')) $this->mailConfirmation($savedBadge);
    $savedBadge['photos'] = $photos;
    $this->response($savedBadge, 201);
  }

  public function index_delete(){
    if(!$this->isLoggedIn) return $this->response(null, 403);

    $data = ['id' => $this->uri->segment(2)];
    $validator = new Valitron\Validator($data);
    $validator->rule('integer', 'id');
    $validator->rule('min', 'id', 1);

    if($validator->validate()){
      $result = $this->badges->delete($data);
      if($result) $this->response(null, 204);
      else $this->response(null, 400);
    } else {
      $this->response($validator->errors(), 400);
    }
  }

  private function savePhotos($badgeId = '', $photos = []){
    return !in_array(false, array_map(function($photo) use ($badgeId){
      return $this->photos->create([
        'image_path' => $photo,
        'location_id' => $badgeId,
        'caption' => '',
        'uploader_ip' => '',
      ]);
    }, $photos));
  }

  private function mailConfirmation($savedBadge = []){
    $subject = "Your TreeTrail badge has been approved";
    $message = "Your badge " . $savedBadge['name'] . " has been approved.";
    mail($savedBadge['email'], $subject, $message);
  }

}
