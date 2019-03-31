<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_Supplier extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
	$this->load->helper(array('url'));
	$this->load->model('m_supplier');
    }

     public function index()
    {
        if(isset($_GET['grid']))
            echo $this->m_supplier->getJson();
        else
            $this->load->view('v_supplier');
    }
    public function load()
    {
        $this->load->view('v_supplier');
        
    }
    
    
    public function create()
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_supplier->create())
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal memasukkan data'));
    }
     
    public function update($sup_id=null)
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_supplier->update($sup_id))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal mengubah data'));
    }
     
    public function delete()
    {
        if(!isset($_POST))   
            show_404();
        
        $sup_id = $_POST['sup_id'];
        if($this->m_supplier->delete($sup_id))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal menghapus data'));
    }

    
    
    
    
    
}
