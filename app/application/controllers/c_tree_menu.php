<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
class C_tree_menu extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->model('m_tree_menu');
        $this->load->view('user/coba');
    }
    
    
    public function geturl()
    {
        $title =$this->input->post('title');
        $this->m_tree_menu->geturl($title);
    }
  
    public function getJsonAkses()
    {
       $this->m_tree_menu->getJsonAkses();
    }
    
    public function getJsonMenuByRole() {
        echo $this->m_tree_menu->getJsonMenuByRole();
    }
    
    public function getJsonMenuAll() {
        echo $this->m_tree_menu->getJsonMenuAll();
    }
    
    public function generateJsonTree()
    {
        echo $this->m_tree_menu->generateJsonTree();
    }
    
    public function  createRoleMenu()
    {
        if(!isset($_POST))   
            show_404();
        if($this->m_tree_menu->createRoleMenu())
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal menambah data'));
       
       
    }

    public function deleteRoleMenu()
    {
         if(!isset($_POST))   
            show_404();
        if($this->m_tree_menu->deleteRoleMenu())
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal menambah data'));
    }

}

