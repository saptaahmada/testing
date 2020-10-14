<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabang extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Model_Cabang','model');
	}

	public function index()
	{
        if($this->input->post('submit') == "") {
            $data['data']       = $this->model->getAll();
            $data['content']    = 'cabang/choose';
    		$this->load->view('index', $data);
        } else {
            $data = $this->model->getById($this->input->post('id_cabang'));
            if(count($data) > 0)
                $this->session->set_userdata('userdata', $data[0]);

            redirect('buku');
        }
	}

}
