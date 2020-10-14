<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Model_Buku','model');
	}

	public function index()
	{
		$data['content'] = 'tracking/view';
		$this->load->view('index', $data);
	}

}
