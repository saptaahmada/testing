<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Jenis_Buku extends CI_Model {


    private function _get_datatables_query()
    {
        $this->db->select('*')->from('tb_jenis_buku');
        $column_orderTopUp = array(null, 'id_jenis_buku', 'jenis', 'type', 'tarif_dasar'); 
        $column_searchTopUp = array('id_jenis_buku', 'jenis', 'type', 'tarif_dasar'); 
        $order = array('id_jenis_buku' => 'asc'); 
 
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
        $this->db->select('id_jenis_buku')->from('tb_jenis_buku');
        return $this->db->count_all_results();
    }

    public function getAll()
    {
        return $this->db->get('tb_jenis_buku')->result_array();
    }

    public function getById($id_jenis_buku)
    {
    	$this->db->where('id_jenis_buku', $id_jenis_buku);
    	return $this->db->get('tb_jenis_buku')->result_array();
    }

    public function insert()
    {
    	$data = [
    		'jenis'			=> $this->input->post('jenis'),
    		'type'			=> $this->input->post('type'),
    		'tarif_dasar'	=> $this->input->post('tarif_dasar'),
    	];
    	return $this->db->insert('tb_jenis_buku', $data);
    }

    public function update($id_jenis_buku)
    {
    	$data = [
    		'jenis'			=> $this->input->post('jenis'),
    		'type'			=> $this->input->post('type'),
    		'tarif_dasar'	=> $this->input->post('tarif_dasar'),
    	];
    	$this->db->where('id_jenis_buku', $id_jenis_buku);
    	return $this->db->update('tb_jenis_buku', $data);
    }

    public function delete($id_jenis_buku)
    {
    	$this->db->where('id_jenis_buku', $id_jenis_buku);
    	return $this->db->delete('tb_jenis_buku');
    }

}
