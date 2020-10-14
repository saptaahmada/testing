<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Transaksi extends CI_Model {

    public function getAll()
    {
        return $this->db->get('tb_transaksi')->result_array();
    }

    public function getDataTransaksi($kode_pelanggan)
    {
        $sql =
        "SELECT a.*, b.nama_buku, b.jenis_buku, c.tarif_dasar FROM tb_transaksi a 
        JOIN tb_buku b ON a.kode_buku=b.kode_buku 
        JOIN tb_jenis_buku c ON b.jenis_buku=c.id_jenis_buku 
        WHERE 
        a.status=0 and a.kode_pelanggan='$kode_pelanggan'";

        return $this->db->query($sql)->result_array();
    }

    public function isMasihPinjam($kode_pelanggan)
    {
    	$this->db->where('kode_pelanggan', $kode_pelanggan);
    	$this->db->where('status', 0);
    	$result = $this->db->get('tb_transaksi')->result_array();
    	if(count($result) > 0)
	        return true;
	    else 
	    	return false;
    }

    public function isDiPinjam($kode_buku)
    {
    	$this->db->where('kode_buku', $kode_buku);
    	$this->db->where('status', 0);
    	$result = $this->db->get('tb_transaksi')->result_array();
    	if(count($result) > 0)
	        return true;
	    else 
	    	return false;
    }

    public function getNextUrutanTransaksi()
    {
        $this->db->select_max('urutan_transaksi');
        $result = $this->db->get('tb_transaksi')->result_array();
        if(count($result) > 0) {

            $maxUrutanTransaksi = $result[0]['urutan_transaksi'];

            $maxUrutanTransaksi++;

            if($maxUrutanTransaksi < 10)
                $maxUrutanTransaksi = '0000'.$maxUrutanTransaksi;
            else if($maxUrutanTransaksi < 100)
                $maxUrutanTransaksi = '000'.$maxUrutanTransaksi;
            else if($maxUrutanTransaksi < 1000)
                $maxUrutanTransaksi = '00'.$maxUrutanTransaksi;
            else if($maxUrutanTransaksi < 10000)
                $maxUrutanTransaksi = '0'.$maxUrutanTransaksi;

            return $maxUrutanTransaksi;
        }
        else
            return '00001';
    }

    public function insert($kode_buku, $jumlah_hari, $kode_transaksi, $next_urutan_trans)
    {
        $tanggal_kembali    = date('d-m-Y', strtotime('+'.$jumlah_hari.' days', strtotime(date('d-m-Y'))));

    	$data = [
            'kode_transaksi'    => $kode_transaksi,
            'kode_pelanggan'    => $this->input->post('kode_pelanggan'),
    		'kode_buku'			=> $kode_buku,
    		'tanggal_pinjam'	=> date('d-m-Y'),
            'tanggal_kembali'   => $tanggal_kembali,
            'urutan_transaksi'  => $next_urutan_trans,
    	];
    	return $this->db->insert('tb_transaksi', $data);
    }

    public function lunas($kode_pelanggan)
    {
        $this->db->where('kode_pelanggan', $kode_pelanggan);
        return $this->db->update('tb_transaksi', ['status' => 1, 'tanggal_kembali_real' => date('d-m-Y')]);
    }

    public function getDetailPeminjaman($kode_buku)
    {
        $this->db->select("a.*, b.nama_buku, b.penerbit, b.penulis, b.jenis_buku, c.jenis, d.nama peminjam, d.alamat alamat_peminjam");
        $this->db->from('tb_transaksi a');
        $this->db->join('tb_buku b', 'a.kode_buku=b.kode_buku');
        $this->db->join('tb_jenis_buku c', 'b.jenis_buku=c.id_jenis_buku');
        $this->db->join('tb_pelanggan d', 'a.kode_pelanggan=d.kode');
        $this->db->where('a.kode_buku', $kode_buku);
        $this->db->where('a.status', 0);
        return $this->db->get()->result_array();
    }

}
