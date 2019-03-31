<?php defined('BASEPATH') OR exit('No direct script access allowed');
class C_satuan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
	$this->load->helper(array('url'));
       	$this->load->model('m_satuan');
    }
    
     public function index()
    {
        if(isset($_GET['grid']))
            echo $this->m_satuan->getJson();
        else
            $this->load->view('v_satuan');
    }
    public function load()
    {
        $this->load->view('v_satuan');
        
    }
    
    
    public function create()
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_satuan->create())
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal memasukkan data'));
    }
     
    public function update($kode_satuan=null)
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_satuan->update($kode_satuan))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal mengubah data'));
    }
     
    public function delete()
    {
        if(!isset($_POST))   
            show_404();
        
        $kode_satuan = $_POST['kode_satuan'];
        if($this->m_satuan->delete($kode_satuan))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal menghapus data'));
    } 
    
    public function getValCombo()
    {
        echo $this->m_satuan->getValCombo();
    }
}
