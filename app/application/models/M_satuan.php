<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_satuan extends CI_Model
{
    
    public function __construct() {
        parent::__construct();
         $this->load->database();
    }
    
    
   
    
    public function create()
    {
        $array = array(
            'kode_satuan'=>$this->input->post('kode_satuan',true),
            'nama_satuan'=>$this->input->post('nama_satuan',true),
            'desc'=>$this->input->post('desc',true)
            
        );
        $this->db->set($array);
        return $this->db->insert('satuan',$array);
        
        
    }
     
    public function update($kode_satuan)
    {
        $this->db->where('kode_satuan', $kode_satuan);
        return $this->db->update('satuan',array(
             'nama_satuan'=>$this->input->post('nama_satuan',true),
            'desc'=>$this->input->post('desc',true)
            
        ));
    }
     
    public function delete($kode_satuan)
    {
        return $this->db->delete('satuan', array('kode_satuan' => $kode_satuan)); 
    }
     
    public function getJson()
    {
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'kode_satuan';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page-1) * $rows;
        
        $result = array();
        $result['total'] = $this->db->get('satuan')->num_rows();
        $row = array();
        
        $this->db->limit($rows,$offset);
        $this->db->order_by($sort,$order);
        $criteria = $this->db->get('satuan');
        
        foreach($criteria->result_array() as $data)
        {   
            $row[] = array(
                'kode_satuan'=>$data['kode_satuan'],
                'nama_satuan'=>$data['nama_satuan'],
                'desc'=>$data['desc'],
            );
        }
        $result=array_merge($result,array('rows'=>$row));
        return json_encode($row);
    }
    
    public function getValCombo()
    {
        $criteria = $this->db->get('satuan');
        foreach($criteria->result_array() as $data)
        {   
            $row[] = array(
                'kode_satuan'=>intval($data['kode_satuan']),
                'nama_satuan'=>$data['nama_satuan']
               
            );
        }
        return json_encode($row);
    }
}