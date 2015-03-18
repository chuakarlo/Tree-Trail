<?php defined('BASEPATH') or exit('No direct script access allowed');

class Statistics_model extends CI_Model{

	public function retrieve_all(){
    $this->db->select('quantity, municipality as name, id, types');
    $this->db->from('locations');
	$this->db->where('municipality != ', '');
    $query = $this->db->get();
    return $query;
  }
	
}
