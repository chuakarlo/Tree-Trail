<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photos extends TreeTrailController{

  public function index_post(){

    // Load upload library with the following config
    $this->load->library('upload', [
      'file_name' => $this->generateUuid(),
      'upload_path' => realpath(APPPATH . '../static/uploaded_photos/'),
      'allowed_types' => 'gif|jpg|png',
      'max_size' => '2048',
    ]);

    if ($this->upload->do_upload('file'))    {
      $this->response($this->upload->data()['file_name'], 201);
    } else {
      $this->response([
        'error' => $this->upload->display_errors()
      ], 400);
    }
  }

  public function index_get(){

    // Get data from uploaded photo
    $path = $this->input->get('path');
    $gps = $this->input->get('gps');
    $exif = @exif_read_data($path, 0, true);

    if($gps=='latitude'){ 
      
      $degrees = $exif["GPS"]["GPSLatitude"][0] / 1;
      $minutes = $exif["GPS"]["GPSLatitude"][1] / 60;
      $sec = explode('/',$exif["GPS"]["GPSLatitude"][2]);
      $seconds = ($sec[0] / $sec[1]) / 3600;
      echo $degrees + $minutes + $seconds;
      
    } else if ($gps=='longitude') {
      
      $degrees = $exif["GPS"]["GPSLongitude"][0] / 1;
      $minutes = $exif["GPS"]["GPSLongitude"][1] / 60;
      $sec = explode('/',$exif["GPS"]["GPSLongitude"][2]);
      $seconds = ($sec[0] / $sec[1]) / 3600;
      echo $degrees + $minutes + $seconds;

    }
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