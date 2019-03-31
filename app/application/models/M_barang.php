<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_barang extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
     public function create()
    {
        return $this->db->insert('barang',array(
            'kode_barang'=>$this->input->post('kode_barang',true),
            'nama_barang'=>$this->input->post('nama_barang',true),
            'tipe'=>$this->input->post('tipe',true),
            'deskripsi'=>$this->input->post('deskripsi',true),
            'harga_beli'=>$this->input->post('harga_beli',true),
            'harga_jual'=>$this->input->post('harga_jual',true),
            'satuan'=>$this->input->post('satuan',true)
        ));
    }
     
    public function update($kode_barang)
    {
        $this->db->where('kode_barang', $kode_barang);
        return $this->db->update('barang',array(
             'nama_barang'=>$this->input->post('nama_barang',true),
            'tipe'=>$this->input->post('tipe',true),
            'deskripsi'=>$this->input->post('deskripsi',true),
            'harga_beli'=>$this->input->post('harga_beli',true),
            'harga_jual'=>$this->input->post('harga_jual',true),
            'satuan'=>$this->input->post('satuan',true)
        ));
    }
     
    public function delete($kode_barang)
    {
        return $this->db->delete('barang', array('kode_barang' => $kode_barang)); 
    }
     
    public function getJson()
    {
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : '';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'kode_barang';
        $offset = ($page-1) * $rows;
        $qry ='select * from barang';
        $result = [];
      
        $row = array();
        $this->db->limit($rows,$offset);
        $this->db->order_by($sort,$order);
        $criteria = $this->db->get('barang');
        $result['total'] = $criteria->num_rows();
        foreach($criteria->result_array() as $data)
        {   
            $row[] = array(
                'kode_barang'=>$data['kode_barang'],
                'nama_barang'=>$data['nama_barang'],
                'tipe'=>$data['tipe'],
                'deskripsi'=>$data['deskripsi'],
                'harga_beli'=>$data['harga_beli'],
                'harga_jual'=>$data['harga_jual'],
                'satuan'=>$data['satuan']
            );
        }
        $result=array_merge($result,array('rows'=>$row));
        return json_encode($result);
    }
    
    
}

