<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Model_Buku','model');
        $this->load->model('Model_Kapasitas');
		$this->load->model('Model_Jenis_Buku');
	}

	public function index()
	{
		$data['content'] = 'buku/view';
		$this->load->view('index', $data);
	}

    public function tracking($kode_buku)
    {
        $data['kode_buku']  = $kode_buku;
        $data['data']       = $this->model->getById($kode_buku);
        $this->load->view('buku/tracking2', $data);
    }

    public function get_buku_detail()
    {
        echo json_encode($this->model->getById($this->input->post('kode_buku'))[0]);
    }
    
    public function get_data_buku()
    {
        $response   = $this->model->getDataBukuSelect2($this->input->post('kode_buku'));
        echo json_encode($response);
    }

    public function create()
    {
        if($this->input->post('submit') != '') {
            if($this->model->insert()) {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-success">sukses create data</div>');
                redirect('buku');
            } else {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-danger">gagal create data</div>');
                redirect('buku/create');
            }
        } else {
            $data['kapasitas']  = $this->Model_Kapasitas->getAll();
            $data['jenis_buku'] = $this->Model_Jenis_Buku->getAll();
            $data['content']    = 'buku/create';
            $this->load->view('index', $data);
        }
    }

    public function update($kode_buku)
    {
        if($this->input->post('submit') != '') {
            if($this->model->update($kode_buku)) {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-success">sukses update data</div>');
                redirect('buku');
            } else {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-danger">gagal update data</div>');
                redirect('buku/update/'.$kode_buku);
            }
        } else {
            $data['kode_buku']      = $kode_buku;
            $data['jenis_buku']     = $this->Model_Jenis_Buku->getAll();
            $data['data']           = $this->model->getById($kode_buku);
            $data['content']        = 'buku/update';
            $this->load->view('index', $data);
        }
    }

    public function delete($kode_buku)
    {
        if($this->model->delete($kode_buku)) {
            $this->session->set_flashdata('message', 
                '<div class="alert alert-success">sukses delete data</div>');
        } else {
            $this->session->set_flashdata('message', 
                '<div class="alert alert-danger">gagal delete data</div>');
        }
        redirect('buku');
    }

    public function alamat_buku($kode_buku)
    {
        $data['kode_buku']  = $kode_buku;
        $data['data']       = $this->model->getById($kode_buku);
        $data['kapasitas']  = $this->Model_Kapasitas->getAll();
        $this->load->view('buku/alamat', $data);
    }

    public function save_alamat()
    {
        $cek = $this->model->saveAlamat();
        echo json_encode($cek);
    }

    public function get_tracking()
    {
        $rak = $_POST['alamat_rak'];

        $data = $this->model->getById($_POST['kode_buku']);
        $kapasitas = $this->Model_Kapasitas->getAll()[0];

        $html = "Rak : ".$rak.'<br><br>';


        for($i=1; $i<=$kapasitas['kolom']; $i++) {
            $html = $html."<span class='rect-no-border font-10'>".$i."</span>";
        }

        $html = $html."<Br>";

        for($j=$kapasitas['tinggi']; $j>=1; $j--) {
            for($i=1; $i<=$kapasitas['kolom']; $i++) {
                $class = $this->cekbosku($data, $rak, $i, $j);

                $html = $html.
                "<span class='rect ".$class."' onclick='pilih(\"$class\", $rak, $i, $j)'></span>";

                if($i==80) {
                    $html = $html."<span class='rect-no-border font-10'>".$j."</span>";
                }
            }
            $html = $html."<br>";
        }


        echo json_encode($html);
    }


    public function get_buku_from_rak()
    {
        $rak = $_POST['alamat_rak'];

        $data = $this->model->getByAlamatRak($_POST['alamat_rak']);
        $kapasitas = $this->Model_Kapasitas->getAll()[0];

        $html = "";


        for($i=1; $i<=$kapasitas['kolom']; $i++) {
            $html = $html."<span class='rect-no-border font-10'>".$i."</span>";
        }

        $html = $html."<Br>";

        for($j=$kapasitas['tinggi']; $j>=1; $j--) {
            for($i=1; $i<=$kapasitas['kolom']; $i++) {
                $class = $this->cekbosku($data, $rak, $i, $j);

                $html = $html.
                "<span class='rect ".$class."' onclick='pilih(\"$class\", $rak, $i, $j)'></span>";

                if($i==80) {
                    $html = $html."<span class='rect-no-border font-10'>".$j."</span>";
                }
            }
            $html = $html."<br>";
        }


        echo json_encode($html);
    }

    private function cekbosku($data, $rak, $i, $j)
    {
        $result = '';
        foreach ($data as $key => $val) {
            if($val['alamat_rak'] == $rak && $val['alamat_kolom'] == $i && $val['alamat_tinggi'] == $j) {
                $result = 'rect-filled';
                break;
            }
        }
        return $result;
    }

    public function get_alamat_rak()
    {
        $buku = $this->model->getAlamatRak($this->input->post('kode_buku'));
        if(count($buku) > 0)
            echo json_encode($buku[0]['alamat_rak']);
        else
            echo json_encode(null);
    }

	public function datatable_buku()
	{
        $id_cabang = $this->session->userdata('userdata')['id_cabang'];
		$list = $this->model->get_datatables($id_cabang);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $value->kode_buku;
            $row[] = $value->nama_buku;
            $row[] = $value->penerbit;
            $row[] = $value->penulis;
            $row[] = $value->jenis;
            $row[] = $value->alamat_rak.":".$value->alamat_kolom.":".$value->alamat_tinggi;
            $row[] = "
                <a class='btn btn-warning' href='".base_url('buku/alamat_buku/'.$value->kode_buku)."'>alamat buku</a>
                <a class='btn btn-success' href='".base_url('buku/update/'.$value->kode_buku)."'>edit</a>
                <a class='btn btn-danger' href='".base_url('buku/delete/'.$value->kode_buku)."' onclick='return confirm(\"apa anda yakin ingin menghapus data ini?\")'>delete</a>";

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
