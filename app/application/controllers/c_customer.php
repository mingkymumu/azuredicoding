<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_customer extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
	$this->load->helper(array('url'));
	$this->load->model('m_customer');
    }

     public function index()
    {
        if(isset($_GET['grid']))
            echo $this->m_customer->getJson();
        else
            $this->load->view('v_customer');
    }
    public function load()
    {
        $this->load->view('v_customer');
        
    }
    
    
    public function create()
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_customer->create())
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal memasukkan data'));
    }
     
    public function update($cust_id=null)
    {
        if(!isset($_POST))   
            show_404();
        
        if($this->m_customer->update($cust_id))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal mengubah data'));
    }
     
    public function delete()
    {
        if(!isset($_POST))   
            show_404();
        
        $cust_id = $_POST['cust_id'];
        if($this->m_customer->delete($cust_id))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal menghapus data'));
    }

    
    public function getBy()
    {
        $berdasarkan = isset($_POST['berdasarkan']) ? $_POST['berdasarkan'] : "";
        $cari = isset($_POST['cari']) ? $_POST['cari'] : "";
        echo $this->m_customer->getBy($berdasarkan,$cari);
    }
    
    public function getJson()
    {
         echo $this->m_customer->getJson() ;
    }
    
}
