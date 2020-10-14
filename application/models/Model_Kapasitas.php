<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Kapasitas extends CI_Model {

    public function getAll()
    {
    	$this->db->where('id_cabang', $this->session->userdata('userdata')['id_cabang']);
        return $this->db->get('tb_kapasitas')->result_array();
    }
}
