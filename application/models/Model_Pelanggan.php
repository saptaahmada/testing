<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Pelanggan extends CI_Model {


    private function _get_datatables_query()
    {
        $this->db->select('a.*, b.status')->from('tb_pelanggan a');
        $this->db->join('(SELECT * FROM tb_transaksi WHERE status=0 group by kode_pelanggan) b', 'a.kode=b.kode_pelanggan', 'left');
        $column_orderTopUp = array(null, 'kode', 'nama', 'ktp', 'alamat', 'hp', 'email'); 
        $column_searchTopUp = array('kode', 'nama', 'ktp', 'alamat', 'hp', 'email'); 
        $order = array('kode' => 'asc'); 
 
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
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->select('kode')->from('tb_pelanggan');
        return $this->db->count_all_results();
    }

    public function getAll()
    {
        return $this->db->get('tb_pelanggan')->result_array();
    }

    public function getById($kode)
    {
    	$this->db->where('kode', $kode);
    	return $this->db->get('tb_pelanggan')->result_array();
    }

    public function insert()
    {
    	$data = [
            'kode'      => $this->input->post('kode'),
    		'nama'		=> $this->input->post('nama'),
    		'ktp'		=> $this->input->post('ktp'),
            'alamat'    => $this->input->post('alamat'),
            'hp'        => $this->input->post('hp'),
    		'email'	    => $this->input->post('email'),
    	];
    	return $this->db->insert('tb_pelanggan', $data);
    }

    public function update($kode)
    {
    	$data = [
            'kode'      => $this->input->post('kode'),
    		'nama'		=> $this->input->post('nama'),
    		'ktp'		=> $this->input->post('ktp'),
    		'alamat'	=> $this->input->post('alamat'),
            'hp'        => $this->input->post('hp'),
            'email'     => $this->input->post('email'),
    	];
    	$this->db->where('kode', $kode);
    	return $this->db->update('tb_pelanggan', $data);
    }

    public function delete($kode)
    {
    	$this->db->where('kode', $kode);
    	return $this->db->delete('tb_pelanggan');
    }

}
