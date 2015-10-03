<?php
class Start_init extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model("init_db_model", "db_checker");
	}

	public function index() {
		$this->db_checker->reset_results();

		$this->db_checker->modify_db();
		$this->db_checker->drop_tables();
		$this->db_checker->create_tables();
		$this->db_checker->create_constraints();

		$data = $this->db_checker->results();
		$this->load->view("init_db/init", $data);
	}

}
