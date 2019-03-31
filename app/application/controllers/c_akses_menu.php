<?php defined('BASEPATH') OR exit('No direct script access allowed');
class C_akses_menu extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
	$this->load->helper(array('url'));
       	$this->load->model('m_role');
    }
    
     public function index()
    {
         $this->load->view('v_akses_menu');
    }
   
    public function getValCombo()
    {
        echo $this->m_role->getValCombo();
    }
}
