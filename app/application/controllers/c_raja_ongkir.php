<?
class C_raja_ongkir extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
    	$this->load->helper(array('url'));
    
    }
    
     public function index()
    {
         $this->load->view('v_raja_ongkir');
    }
   
    public function getValCombo()
    {
        echo $this->m_role->getValCombo();
    }
}