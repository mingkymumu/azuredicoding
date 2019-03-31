<?php defined('BASEPATH') OR exit('No direct script access allowed');
class C_menu extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
	$this->load->helper(array('url'));
       	$this->load->model('m_menu');
    }
    
     public function index()
    {
        if(isset($_GET['grid']))
            echo $this->m_menu->getJson();
        else
            $this->load->view('v_menu');
    }
    public function load()
    {
        $this->load->view('v_menu');
        
    }
    
    
    public function create()
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_menu->create())
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal memasukkan data'));
    }
     
    public function update($id=null)
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_menu->update($id))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal mengubah data'));
    }
     
    public function delete()
    {
        if(!isset($_POST))   
            show_404();
        
        $id = $_POST['id'];
        if($this->m_menu->delete($id))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal menghapus data'));
    } 
}
