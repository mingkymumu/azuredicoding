<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_menu extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->load->database();
        
    }
    
     public function getArrayMenu()
    {
        
        $result =[];
        $row = array();
        
        
        $criteria = $this->db->get('menu_item');
        
        foreach($criteria->result_array() as $data)
        {   
            $row[] = array(
                'id'=>$data['id'],
                'title'=>$data['title'],
                'parent_id'=>$data['parent_id']
                
            );
        }
        return $row;
                //return json_encode($result);
    } 
    
  
 public function create()
    {
        $array = array(
            'id'=>$this->input->post('id',false),
            'title'=>$this->input->post('title',false),
            'link'=>$this->input->post('link',false),
            'parent_id'=>$this->input->post('parent_id',false),
            'url'=>$this->input->post('url',false)
        );
        $this->db->set($array);
        return $this->db->insert('menu_item',$array);
        
        
    }
     
    public function update($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('menu_item',array(
             'title'=>$this->input->post('title',true),
            'link'=>$this->input->post('link',true),
            'parent_id'=>$this->input->post('parent_id',true),
            'url'=>$this->input->post('url',true)
        ));
    }
     
    public function delete($id)
    {
        return $this->db->delete('menu_item', array('id' => $id)); 
    }
     
    public function getJson()
    {
        
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page-1) * $rows;
        
        $result = array();
        $result['total'] = $this->db->get('menu_item')->num_rows();
        $row = array();
        
        $this->db->limit($rows,$offset);
        $this->db->order_by($sort,$order);
        $criteria = $this->db->get('menu_item');
        
        foreach($criteria->result_array() as $data)
        {   
            $row[] = array(
                'id'=>$data['id'],
                'title'=>$data['title'],
                'link'=>$data['link'],
                'parent_id'=>$data['parent_id'],
                'url'=>$data['url']
            );
        }
        $result=array_merge($result,array('rows'=>$row));
        return json_encode($row);
    }
    
    
    
}