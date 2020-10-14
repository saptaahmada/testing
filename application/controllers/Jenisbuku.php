<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenisbuku extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Model_Jenis_Buku','model');
	}

	public function index()
	{
		$data['content'] = 'jenisbuku/view';
		$this->load->view('index', $data);
	}

    public function create()
    {
        if($this->input->post('submit') != '') {
            if($this->model->insert()) {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-success">sukses create data</div>');
                redirect('jenisbuku');
            } else {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-danger">gagal create data</div>');
                redirect('jenisbuku/create');
            }
        } else {
            $data['content']    = 'jenisbuku/create';
            $this->load->view('index', $data);
        }
    }

    public function update($id_jenis_buku)
    {
        if($this->input->post('submit') != '') {
            if($this->model->update($id_jenis_buku)) {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-success">sukses update data</div>');
                redirect('jenisbuku');
            } else {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-danger">gagal update data</div>');
                redirect('jenisbuku/update/'.$id_jenis_buku);
            }
        } else {
            $data['id_jenis_buku']  = $id_jenis_buku;
            $data['data']           = $this->model->getById($id_jenis_buku);
            $data['content']        = 'jenisbuku/update';
            $this->load->view('index', $data);
        }
    }

    public function delete($id_jenis_buku)
    {
        if($this->model->delete($id_jenis_buku)) {
            $this->session->set_flashdata('message', 
                '<div class="alert alert-success">sukses delete data</div>');
        } else {
            $this->session->set_flashdata('message', 
                '<div class="alert alert-danger">gagal delete data</div>');
        }
        redirect('jenisbuku');
    }

	public function datatable_jenisbuku()
	{
		$list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->jenis;
            $row[] = $value->type;
            $row[] = $value->tarif_dasar;
            $row[] = "
                <a class='btn btn-success' href='".base_url('jenisbuku/update/'.$value->id_jenis_buku)."'>edit</a>
                <a class='btn btn-danger' href='".base_url('jenisbuku/delete/'.$value->id_jenis_buku)."' onclick='return confirm(\"apa anda yakin ingin menghapus data ini?\")'>delete</a>";

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
}
