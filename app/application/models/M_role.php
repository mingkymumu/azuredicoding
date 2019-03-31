<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_role extends CI_Model
{
    
    public function __construct() {
        parent::__construct();
         $this->load->database();
    }
    
    
    public function getroles()
    {
        
    }
    
    public function getRoleByUser($user_id)
    {
        
    }
    
    public function getRoleById($role_id)
    {
        
    }
    
    public function create()
    {
        $array = array(
            'role_id'=>$this->input->post('role_id',true),
            'role_name'=>$this->input->post('role_name',true),
            'desc'=>$this->input->post('desc',true)
            
        );
        $this->db->set($array);
        return $this->db->insert('role',$array);
        
        
    }
     
    public function update($role_id)
    {
        $this->db->where('role_id', $role_id);
        return $this->db->update('role',array(
             'role_name'=>$this->input->post('role_name',true),
            'desc'=>$this->input->post('desc',true)
            
        ));
    }
     
    public function delete($role_id)
    {
        return $this->db->delete('role', array('role_id' => $role_id)); 
    }
     
    public function getJson()
    {
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'role_id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page-1) * $rows;
        
        $result = array();
        $result['total'] = $this->db->get('role')->num_rows();
        $row = array();
        
        $this->db->limit($rows,$offset);
        $this->db->order_by($sort,$order);
        $criteria = $this->db->get('role');
        
        foreach($criteria->result_array() as $data)
        {   
            $row[] = array(
                'role_id'=>$data['role_id'],
                'role_name'=>$data['role_name'],
                'desc'=>$data['desc'],
            );
        }
        $result=array_merge($result,array('rows'=>$row));
        return json_encode($row);
    }
    
    public function getValCombo()
    {
        $criteria = $this->db->get('role');
        foreach($criteria->result_array() as $data)
        {   
            $row[] = array(
                'role_id'=>intval($data['role_id']),
                'role_name'=>$data['role_name']
               
            );
        }
        return json_encode($row);
    }
}