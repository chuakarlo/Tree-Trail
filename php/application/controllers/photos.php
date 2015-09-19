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