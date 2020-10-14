<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Buku extends CI_Model {

    private $id_cabang;

    public function __construct()
    {
        parent::__construct();
        $this->id_cabang = $this->session->userdata('userdata')['id_cabang'];
    }


    private function _get_datatables_query()
    {
        $this->db->select('tb_buku.*, tb_jenis_buku.jenis')->from('tb_buku');
        $this->db->join('tb_jenis_buku', 'tb_buku.jenis_buku=tb_jenis_buku.id_jenis_buku');
        $column_orderTopUp = array(null, 'kode_buku', 'nama_buku', 'penerbit', 'penulis'); 
        $column_searchTopUp = array('kode_buku', 'nama_buku', 'penerbit', 'penulis'); 
        $order = array('kode_buku' => 'asc'); 
 
        $i = 0;
     
        foreach ($column_searchTopUp as $item) 
        {
            if($_POST['search']['value']) 
            {                 
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($column_searchTopUp) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($column_orderTopUp[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($order))
        {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables($id_cabang)
    {
        $this->_get_datatables_query();
        $this->db->where('id_cabang', $id_cabang);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $this->db->where('id_cabang', $this->id_cabang);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->select('kode_buku')->from('tb_buku');
        $this->db->where('id_cabang', $this->id_cabang);
        return $this->db->count_all_results();
    }

    public function getAll($id_cabang)
    {
        $this->db->where('id_cabang', $this->id_cabang);
        return $this->db->get('tb_buku')->result_array();
    }

    public function getById($kode_buku)
    {
        $this->db->select('a.*, b.jenis');
        $this->db->from('tb_buku a');
        $this->db->join('tb_jenis_buku b', 'a.jenis_buku=b.id_jenis_buku');
        $this->db->where('a.kode_buku', $kode_buku);
        $this->db->where('id_cabang', $this->id_cabang);
        return $this->db->get()->result_array();
    }

    public function getByAlamatRak($alamat_rak)
    {
        $this->db->select('kode_buku, alamat_rak, alamat_kolom, alamat_tinggi');
        $this->db->where('alamat_rak', $alamat_rak);
        $this->db->where('id_cabang', $this->id_cabang);
        return $this->db->get('tb_buku')->result_array();
    }

    public function getAlamatRak($kode_buku)
    {
        $this->db->where('kode_buku', $kode_buku);
        $this->db->where('id_cabang', $this->id_cabang);
        return $this->db->get('tb_buku')->result_array();
    }

    public function getMaxKodeBuku()
    {
        $this->db->select_max('kode_buku');
        $result = $this->db->get('tb_buku')->result_array(); 
        if(count($result) > 0)
            return $result[0]['kode_buku'];
        else
            return 0;
    }


    public function getDataBukuSelect2($kode_buku)
    {
        $this->db->select('*');
        $this->db->where("nama_buku like '%".$kode_buku."%' ");
        $this->db->where('id_cabang', $this->id_cabang);
        $fetched_records = $this->db->get('tb_buku');
        $buku = $fetched_records->result_array();

        $data = array();
        foreach($buku as $value){
            $data[] = array("id"=>$value['kode_buku'], "text"=>$value['nama_buku']);
        }
        return $data;
    }

    public function saveAlamat()
    {
        $data = [
            'alamat_rak'    => $this->input->post('alamat_rak'),
            'alamat_kolom'  => $this->input->post('alamat_kolom'),
            'alamat_tinggi' => $this->input->post('alamat_tinggi'),
        ];
        $this->db->where('kode_buku', $this->input->post('kode_buku'));
        return $this->db->update('tb_buku', $data);
    }

    public function pinjam($kode_buku, $status_pinjam)
    {
        $data = ['status_pinjam' => $status_pinjam];
        $this->db->where('kode_buku', $kode_buku);
        return $this->db->update('tb_buku', $data);
    }

    public function insert()
    {
        $maxKodeBuku = $this->getMaxKodeBuku();

        $maxKodeBuku++;

        if($maxKodeBuku < 10)
            $maxKodeBuku = '0000'.$maxKodeBuku;
        else if($maxKodeBuku < 100)
            $maxKodeBuku = '000'.$maxKodeBuku;
        else if($maxKodeBuku < 1000)
            $maxKodeBuku = '00'.$maxKodeBuku;
        else if($maxKodeBuku < 10000)
            $maxKodeBuku = '0'.$maxKodeBuku;

        $data = [
            'kode_buku'     => $maxKodeBuku,
            'nama_buku'     => $this->input->post('nama_buku'),
            'penerbit'      => $this->input->post('penerbit'),
            'penulis'       => $this->input->post('penulis'),
            'jenis_buku'    => $this->input->post('jenis_buku'),
            'id_cabang'     => $this->session->userdata('userdata')['id_cabang'],
        ];
        return $this->db->insert('tb_buku', $data);
    }

    public function update($kode_buku)
    {
        $data = [
            'nama_buku'     => $this->input->post('nama_buku'),
            'penerbit'      => $this->input->post('penerbit'),
            'penulis'       => $this->input->post('penulis'),
            'jenis_buku'    => $this->input->post('jenis_buku'),
            'id_cabang'     => $this->session->userdata('userdata')['id_cabang'],
        ];
        $this->db->where('kode_buku', $kode_buku);
        $this->db->where('id_cabang', $this->id_cabang);
        return $this->db->update('tb_buku', $data);
    }

    public function delete($kode_buku)
    {
        $this->db->where('kode_buku', $kode_buku);
        $this->db->where('id_cabang', $this->id_cabang);
        return $this->db->delete('tb_buku');
    }


}
