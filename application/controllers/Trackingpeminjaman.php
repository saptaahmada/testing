<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trackingpeminjaman extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Model_Buku','model');
	}

	public function index()
	{
		$data['content'] = 'trackingpeminjaman/view';
		$this->load->view('index', $data);
	}

    public function get_data_buku()
    {
        $response   = $this->getDataBuku($this->input->post('kode_buku'));
        echo json_encode($response);
    }


    function getDataBuku($kode_buku)
    {
        $this->db->select('*');
        $this->db->where("nama_buku like '%".$kode_buku."%' ");
        $fetched_records = $this->db->get('tb_buku');
        $buku = $fetched_records->result_array();

        $data = array();
        foreach($buku as $value){
            $data[] = array("id"=>$value['kode_buku'], "text"=>$value['nama_buku']);
        }
        return $data;
    }

}
