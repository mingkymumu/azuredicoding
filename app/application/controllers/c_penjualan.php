<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_penjualan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
	$this->load->helper(array('url'));
	$this->load->model('m_penjualan');
    }

     public function index()
    {
       
            
         $this->load->view('v_penjualan');
    
         
         
    }
    public function load()
    {
        $this->load->view('v_penjualan');
        
    }
    
    
    public function createHeaderPenjualan()
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_penjualan->createHeaderPenjualan())
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal memasukkan data'));
    }
    public function createDetailPenjualan()
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_penjualan->createDetailPenjualan())
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal memasukkan data'));
    }
     
    public function updateHeaderPenjualan($no_bukti=null)
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_penjualan->update($no_bukti))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal mengubah data'));
    }
     
    public function delete($no_bukti=null)
    {
        if(!isset($_POST))   
            show_404();
        
        $no_bukti = $_POST['no_bukti'];
        if($this->m_penjualan->delete($no_bukti))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal menghapus data'));
    }

    
    public function getJson()
    {
         echo $this->m_penjualan->getJson();
    }
    public function getJsonJualDetail()
    {
         echo $this->m_penjualan->getJsonJualDetail();
    }
   
    public function getBy()
    {
        $berdasarkan = isset($_POST['berdasarkan']) ? $_POST['berdasarkan'] : "";
        $cari = isset($_POST['cari']) ? $_POST['cari'] : "";
        echo $this->m_penjualan->getBy($berdasarkan,$cari);
    }
    public function generateBukti()
    {
        $this->m_penjualan->generateBukti();
//        $this->m_penjualan->getZeroInFirstStr($str);
    }
    
    
}
