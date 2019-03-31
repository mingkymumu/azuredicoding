<?php defined('BASEPATH') OR exit('No direct script access allowed');
class C_type extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
	$this->load->helper(array('url'));
       	$this->load->model('m_type');
    }
    
     public function index()
    {
        if(isset($_GET['grid']))
            echo $this->m_type->getJson();
        else
            $this->load->view('v_type');
    }
    public function load()
    {
        $this->load->view('v_type');
        
    }
    
    
    public function create()
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_type->create())
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal memasukkan data'));
    }
     
    public function update($type_id=null)
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_type->update($type_id))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal mengubah data'));
    }
     
    public function delete()
    {
        if(!isset($_POST))   
            show_404();
        
        $type_id = $_POST['type_id'];
        if($this->m_type->delete($type_id))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal menghapus data'));
    } 
    
    public function getValCombo()
    {
        echo $this->m_type->getValCombo();
    }
}
