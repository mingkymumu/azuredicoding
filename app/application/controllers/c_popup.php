<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_popup extends CI_Controller {
    private $id;
    
    public function __construct( ) {
        parent::__construct();
        $this->load->library(array('session'));
	$this->load->helper(array('url'));
	
    }

     public function index()
    {
         $this->load->view('v_popup_cust');
    }
    public function load()
    {
        $this->load->view('v_barang');
        
    }
    
    
    public function create()
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_barang->create())
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal memasukkan data'));
    }
     
    public function update($kode_barang=null)
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_barang->update($kode_barang))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal mengubah data'));
    }
     
    public function delete()
    {
        if(!isset($_POST))   
            show_404();
        
        $kode_barang = $_POST['kode_barang'];
        if($this->m_barang->delete($kode_barang))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal menghapus data'));
    }

    
    public function getJson()
    {
         echo $this->m_barang->getJson();
    }
    
    
    
}
