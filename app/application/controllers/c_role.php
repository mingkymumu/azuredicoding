<?php defined('BASEPATH') OR exit('No direct script access allowed');
class C_role extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
	$this->load->helper(array('url'));
       	$this->load->model('m_role');
    }
    
     public function index()
    {
        if(isset($_GET['grid']))
            echo $this->m_role->getJson();
        else
            $this->load->view('v_role');
    }
    public function load()
    {
        $this->load->view('v_role');
        
    }
    
    
    public function create()
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_role->create())
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal memasukkan data'));
    }
     
    public function update($role_id=null)
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_role->update($role_id))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal mengubah data'));
    }
     
    public function delete()
    {
        if(!isset($_POST))   
            show_404();
        
        $role_id = $_POST['role_id'];
        if($this->m_role->delete($role_id))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal menghapus data'));
    } 
    
    public function getValCombo()
    {
        echo $this->m_role->getValCombo();
    }
}
