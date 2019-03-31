<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_type extends CI_Model
{
    
    public function __construct() {
        parent::__construct();
         $this->load->database();
    }
    
    
   
    
    public function create()
    {
        $array = array(
            'type_id'=>$this->input->post('type_id',true),
            'type_name'=>$this->input->post('type_name',true),
            'desc'=>$this->input->post('desc',true)
            
        );
        $this->db->set($array);
        return $this->db->insert('type',$array);
        
        
    }
     
    public function update($type_id)
    {
        $this->db->where('type_id', $type_id);
        return $this->db->update('type',array(
             'type_name'=>$this->input->post('type_name',true),
            'desc'=>$this->input->post('desc',true)
            
        ));
    }
     
    public function delete($type_id)
    {
        return $this->db->delete('type', array('type_id' => $type_id)); 
    }
     
    public function getJson()
    {
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'type_id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page-1) * $rows;
        
        $result = array();
        $result['total'] = $this->db->get('type')->num_rows();
        $row = array();
        
        $this->db->limit($rows,$offset);
        $this->db->order_by($sort,$order);
        $criteria = $this->db->get('type');
        
        foreach($criteria->result_array() as $data)
        {   
            $row[] = array(
                'type_id'=>$data['type_id'],
                'type_name'=>$data['type_name'],
                'desc'=>$data['desc'],
            );
        }
        $result=array_merge($result,array('rows'=>$row));
        return json_encode($row);
    }
    
    public function getValCombo()
    {
        $criteria = $this->db->get('type');
        foreach($criteria->result_array() as $data)
        {   
            $row[] = array(
                'type_id'=>intval($data['type_id']),
                'type_name'=>$data['type_name']
               
            );
        }
        return json_encode($row);
    }
}