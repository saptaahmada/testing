<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Model_Pelanggan','model');
	}

	public function index()
	{
		$data['content'] = 'pelanggan/view';
		$this->load->view('index', $data);
	}

    public function create()
    {
        if($this->input->post('submit') != '') {
            if($this->model->insert()) {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-success">sukses create data</div>');
                redirect('pelanggan');
            } else {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-danger">gagal create data</div>');
                redirect('pelanggan/create');
            }
        } else {
            $data['content']    = 'pelanggan/create';
            $this->load->view('index', $data);
        }
    }

    public function update($kode)
    {
        if($this->input->post('submit') != '') {
            if($this->model->update($kode)) {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-success">sukses update data</div>');
                redirect('pelanggan');
            } else {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-danger">gagal update data</div>');
                redirect('pelanggan/update/'.$kode);
            }
        } else {
            $data['kode']  = $kode;
            $data['data']           = $this->model->getById($kode);
            $data['content']        = 'pelanggan/update';
            $this->load->view('index', $data);
        }
    }

    public function delete($kode)
    {
        if($this->model->delete($kode)) {
            $this->session->set_flashdata('message', 
                '<div class="alert alert-success">sukses delete data</div>');
        } else {
            $this->session->set_flashdata('message', 
                '<div class="alert alert-danger">gagal delete data</div>');
        }
        redirect('pelanggan');
    }

	public function datatable_pelanggan()
	{
		$list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $value->kode;
            $row[] = $value->nama;
            $row[] = $value->ktp;
            $row[] = $value->alamat;
            $row[] = $value->hp;
            $row[] = $value->email;
            if($value->status == 0 && $value->status != null)
                $row[] = "
                    <a class='btn btn-success' href='".base_url('pelanggan/update/'.$value->kode)."'>edit</a>
                    <a class='btn btn-danger' href='".base_url('pelanggan/delete/'.$value->kode)."' onclick='return confirm(\"apa anda yakin ingin menghapus data ini?\")'>delete</a>
                    <a class='btn btn-warning' href='".base_url('peminjaman/detail_peminjaman/'.$value->kode)."'>Detail Peminjaman</a>
                    ";
            else
                $row[] = "
                    <a class='btn btn-success' href='".base_url('pelanggan/update/'.$value->kode)."'>edit</a>
                    <a class='btn btn-danger' href='".base_url('pelanggan/delete/'.$value->kode)."' onclick='return confirm(\"apa anda yakin ingin menghapus data ini?\")'>delete</a>
                    ";

            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all(),
            "recordsFiltered" => count($list),
            "data" => $data,
        );

        echo json_encode($output);
	}


    public function get_pelanggan_select2()
    {
        $response   = $this->getDataPelanggan($this->input->post('kode'));
        echo json_encode($response);
    }


    function getDataPelanggan($kode)
    {
        $this->db->select('*');
        $this->db->where("kode like '%".$kode."%' ");
        $fetched_records = $this->db->get('tb_pelanggan');
        $buku = $fetched_records->result_array();

        $data = array();
        foreach($buku as $value){
            $data[] = array("id"=>$value['kode'], "text"=>$value['nama']);
        }
        return $data;
    }

}
