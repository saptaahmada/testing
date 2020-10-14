<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Cabang extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        return $this->db->get('tb_cabang')->result_array();
    }

    public function getById($id_cabang)
    {
        $this->db->where('id_cabang', $id_cabang);
        return $this->db->get('tb_cabang')->result_array();
    }

}
