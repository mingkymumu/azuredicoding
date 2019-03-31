<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_supplier extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
     public function create()
    {
        return $this->db->insert('supplier',array(
            'sup_id'=>$this->input->post('sup_id',true),
            'sup_name'=>$this->input->post('sup_name',true),
            'address'=>$this->input->post('address',true),
            'telp'=>$this->input->post('telp',true)
        ));
    }
     
    public function update($sup_id)
    {
        $this->db->where('sup_id', $sup_id);
        return $this->db->update('supplier',array(
            'sup_name'=>$this->input->post('sup_name',true),
            'address'=>$this->input->post('address',true),
            'telp'=>$this->input->post('telp',true)
            
        ));
    }
     
    public function delete($sup_id)
    {
        return $this->db->delete('supplier', array('sup_id' => $sup_id)); 
    }
     
    public function getJson()
    {
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'sup_id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page-1) * $rows;
        
        $result = array();
        $result['total'] = $this->db->get('supplier')->num_rows();
        $row = array();
        
        $this->db->limit($rows,$offset);
        $this->db->order_by($sort,$order);
        $criteria = $this->db->get('supplier');
        
        foreach($criteria->result_array() as $data)
        {   
            $row[] = array(
                'sup_id'=>$data['sup_id'],
                'sup_name'=>$data['sup_name'],
                'address'=>$data['address'],
                'telp'=>$data['telp']
                
            );
        }
        $result=array_merge($result,array('rows'=>$row));
        return json_encode($row);
    }
    
    
}

