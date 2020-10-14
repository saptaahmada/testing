<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Model_Transaksi','model');
        $this->load->model('Model_Buku');
        $this->load->model('Model_Pelanggan');
	}

    public function detail_peminjaman($kode_pelanggan)
    {
        $data_transaksi = $this->model->getDataTransaksi($kode_pelanggan);

        $subtotal = 0;

        foreach ($data_transaksi as $key => $val) {
	        $tgl1 		= new DateTime($val['tanggal_pinjam']);
			$tgl2 		= new DateTime($val['tanggal_kembali']);
			$selisih 	= $tgl2->diff($tgl1)->days + 1;
			$amount		= $this->hitungTarif($val['jenis_buku'], $selisih, $val['tarif_dasar']);

			$data_transaksi[$key]['item_days']	= $selisih;
			$data_transaksi[$key]['amount']		= $amount;

			$subtotal += $amount;
        }

        $tax 	= $subtotal * 10/100;
        $stamp 	= 3000;
        $total 	= $subtotal + $tax + $stamp;

        $data['subtotal']		= $subtotal;
        $data['tax']			= $tax;
        $data['stamp']			= $stamp;
        $data['total']			= $total;
        $data['data_transaksi']	= $data_transaksi;
        $data['kode_pelanggan'] = $kode_pelanggan;
        $data['data_pelanggan']	= $this->Model_Pelanggan->getById($kode_pelanggan);
        $data['content']        = 'peminjaman/detail_peminjaman';

        $this->load->view('index', $data);
    }

    private function hitungTarif($jenis_buku, $hari, $tarif_dasar)
    {
    	if($jenis_buku == 1) {
    		return $this->hitungMajalah($hari, $tarif_dasar);
    	} else if($jenis_buku == 2) {
    		return $this->hitungKomik($hari, $tarif_dasar);
    	} else if($jenis_buku == 3) {
    		return $this->hitungBuku($hari, $tarif_dasar);
    	}
    }

    private function hitungMajalah($hari, $tarif_dasar)
    {
    	return $tarif_dasar * $hari;
    }

    private function hitungKomik($hari, $tarif_dasar)
    {
    	$totalTarif = 0;

    	for ($i=0; $i < $hari; $i++) { 
    		if($i < 3) {
    			$totalTarif = $totalTarif + $tarif_dasar;
    		} else {
    			$tarif = 150/100 * $tarif_dasar;
    			$totalTarif = $totalTarif + $tarif;
    		}
    	}

    	return $totalTarif;
    }

    private function hitungBuku($hari, $tarif_dasar)
    {
    	$totalTarif = $tarif_dasar;

    	for ($i=1; $i <= $hari; $i++) { 
    		if($i > 3 && $i <= 10) {
    			$totalTarif = $totalTarif + $tarif_dasar;
    		} else if($i > 10) {
    			$tarif = 150/100 * $tarif_dasar;
    			$totalTarif = $totalTarif + $tarif;
    		}
    	}

    	return $totalTarif;
    }

    public function get_peminjaman_detail()
    {
        $result = $this->model->getDetailPeminjaman($this->input->post('kode_buku'));
        if(count($result) > 0)
            echo json_encode($result[0]);
        else
            echo json_encode(null);
    }

    public function lunas($kode_pelanggan)
    {
    	if($this->model->lunas($kode_pelanggan)) {
            $this->session->set_flashdata('message', 
            '<div class="alert alert-success">Aksi sukses</div>');
			redirect('pelanggan');
    	} else {
            $this->session->set_flashdata('message', 
            '<div class="alert alert-danger">Aksi gagal</div>');
			redirect('peminjaman/detail_peminjaman/'.$kode_pelanggan);
    	}
    }

	public function create()
	{
        if($this->input->post('submit') != '') 
        {
        	$kode_pelanggan = $this->input->post('kode_pelanggan');

        	$res = $this->Model_Pelanggan->getById($kode_pelanggan);

        	if(count($res) > 0) 
        	{
	        	$res = $this->model->isMasihPinjam($kode_pelanggan);

	        	if(!$res)
	        	{
		        	$buku = [];
		        	foreach ($_POST['kode_buku'] as $key => $val) {
		        		$res = $this->Model_Buku->getById($val);
		        		if(count($res) > 0) {
		        			$buku[] = $res[0];
		        		} else {
			                $this->session->set_flashdata('message', 
		                    '<div class="alert alert-danger">Buku dengan kode '.$val.' tidak ditemukan</div>');
		        			redirect('peminjaman/create');
		        		}
		        	}

		        	foreach ($_POST['kode_buku'] as $key => $val) {
		        		if($this->model->isDiPinjam($val)) {
			                $this->session->set_flashdata('message', 
		                    '<div class="alert alert-danger">Buku dengan kode '.$val.' masih dipinjam orang lain</div>');
		        			redirect('peminjaman/create');
		        		}
		        	}

                    $kode_cabang        = $this->session->userdata('userdata')['id_cabang'];
                    $next_urutan_trans  = $this->model->getNextUrutanTransaksi();
                    $kode_transaksi     = $kode_cabang.'-'.date('Ym').'-INV-'.$next_urutan_trans;

		        	foreach ($_POST['kode_buku'] as $key => $val) {
		        		$this->model->insert($val, $this->input->post('jumlah_hari'), $kode_transaksi, $next_urutan_trans);
		        	}

	                $this->session->set_flashdata('message', 
                    '<div class="alert alert-success">Sukses meminjam buku</div>');
        			redirect('peminjaman/create');

	        	}
	        	else
	        	{
	                $this->session->set_flashdata('message', 
	                '<div class="alert alert-danger">anda masih meminjam buku, silahkan dikembalikan dulu bukunya</div>');
	    			redirect('peminjaman/create');
	        	}
        	}
        	else
        	{
                $this->session->set_flashdata('message', 
                '<div class="alert alert-danger">Pelanggan tidak terdaftar</div>');
    			redirect('peminjaman/create');
        	}

        } else {
			$data['content'] = 'peminjaman/create';
			$this->load->view('index', $data);
        }

	}

}
