<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_penjualan extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function createHeaderPenjualan() {

        $tgl = date("Y-m-d", strtotime($this->input->post('tgl'), true));
        return $this->db->insert('penjualan', array(
                    'no_bukti' => $this->input->post('no_bukti', true),
                    'tgl' => $tgl,
                    'total_nilai' => $this->input->post('total_nilai', true),
                    'keterangan' => $this->input->post('keterangan', true),
                    'cust_id' => $this->input->post('cust_id', true),
                    'cust_name' => $this->input->post('cust_name', true),
                    'ppn' => $this->input->post('ppn', true)
        ));
    }

    public function createDetailPenjualan() {
        return $this->db->insert('penjualan_detail', array(
                    'no_bukti' => $this->input->post('no_bukti', true),
                    'nomor' => $this->input->post('nomor', true),
                    'kode_barang' => $this->input->post('kode_barang', true),
                    'nama_barang' => $this->input->post('nama_barang', true),
                    'qty' => $this->input->post('qty', true),
                    'harga_satuan' => $this->input->post('harga_satuan', true),
                    'harga_total' => $this->input->post('harga_total', true)
        ));
    }

    public function update($no_bukti) {
        $tgl = date("Y-m-d", strtotime($this->input->post('tgl'), true));
        $this->deleteDetailPenjualan($no_bukti);
        $this->db->where('no_bukti', $no_bukti);
        return $this->db->update('penjualan', array(
                    'cust_id' => $this->input->post('cust_id', true),
                    'cust_name' => $this->input->post('cust_name', true),
                    'ppn' => $this->input->post('ppn', true),
                    'total_nilai' => $this->input->post('total_nilai', true),
                    'keterangan' => $this->input->post('keterangan', true),
                    'tgl' => $tgl
        ));
        
        
    }

    public function delete($no_bukti) {
        
        return ($this->db->delete('penjualan', array('no_bukti' => $no_bukti)) && $this->deleteDetailPenjualan($no_bukti));
        
    }

    public function getJson() {

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'no_bukti';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'no_bukti';
        $offset = ($page - 1) * $rows;
        $qry = 'select * from penjualan';
        $result = [];

        $row = array();
        $this->db->limit($rows, $offset);
        $this->db->order_by($sort, $order);
        $criteria = $this->db->get('penjualan');
        $result['total'] = $criteria->num_rows();
        foreach ($criteria->result_array() as $data) {
            $row[] = array(
                'no_bukti' => $data['no_bukti'],
                'tgl' => $data['tgl'],
                'total_nilai' => $data['total_nilai'],
                'cust_id' => $data['cust_id'],
                'cust_name' => $data['cust_name']
            );
        }
        $result = array_merge($result, array('rows' => $row));
        return json_encode($result);
    }

    public function getBy($berdasarkan = '', $cari = '') {

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'no_bukti';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page - 1) * $rows;

        $result = array();

        if ($berdasarkan != "" && $cari != "") {
            $this->db->select('no_bukti,DATE_FORMAT(tgl,\'%d-%m-%Y\') as tgl,total_nilai,cust_id,cust_name,ppn');
            $this->db->from('penjualan');
            $this->db->where($berdasarkan, $cari);
            $criteria = $this->db->get();
        } else {
            $this->db->select('no_bukti,DATE_FORMAT(tgl,\'%d-%m-%Y\') as tgl,total_nilai,cust_id,cust_name,ppn');
            $this->db->from('penjualan');
            $criteria = $this->db->get();
        }
        $result['total'] = $criteria->num_rows();
        $row = array();
//        $this->db->limit($rows,$offset);
//        $this->db->order_by($sort,$order);
        foreach ($criteria->result_array() as $data) {
            $row[] = array(
                'no_bukti' => $data['no_bukti'],
                'tgl' => $data['tgl'],
                'total_nilai' => $data['total_nilai'],
                'cust_id' => $data['cust_id'],
                'cust_name' => $data['cust_name'],
                'ppn' => $data['ppn']
            );
        }
        $result = array_merge($result, array('rows' => $row));
        return json_encode($result);
    }

    public function getJsonJualDetail() {
        $no_bukti = isset($_POST['no_bukti']) ? $_POST['no_bukti'] : '';
        $result = array();
        $this->db->select('*');
        $this->db->from('penjualan_detail');
        $this->db->where('no_bukti', $no_bukti);
        $criteria = $this->db->get();

        $result['total'] = $criteria->num_rows();
        $row = array();
        foreach ($criteria->result_array() as $data) {
            $row[] = array(
                'no_bukti' => $data['no_bukti'],
                'nomor' => $data['nomor'],
                'kode_barang' => $data['kode_barang'],
                'nama_barang' => $data['nama_barang'],
                'qty' => $data['qty'],
                'harga_satuan' => $data['harga_satuan'],
                'harga_total' => $data['harga_total']
            );
        }
        $result = array_merge($result, array('rows' => $row));
        return json_encode($result);
    }
    public function deleteDetailPenjualan($no_bukti)
    {
           
           return $this->db->delete('penjualan_detail', array('no_bukti' => $no_bukti));
    }
    public function isExist($no_bukti)
    {
        $this->db->select('*');
        $this->db->from('penjualan_detail');
        $this->db->where('no_bukti', $no_bukti);
        $criteria = $this->db->get();
       return $criteria->num_rows > 0;
    }
    
    
    public function generateBukti()
    {
        $prefix ="FK";
        $this->db->select_max('no_bukti','bukti');
        $query = $this->db->get('penjualan'); 
        $row = $query->row();
        if (isset($row))
        $row = substr ($row->bukti,6);
        $ext = $this->getZeroInFirstStr($row);
        if(strlen($ext)>4)
            $ext = $this->strright ($ext, 4);
        $date = date("ym");
        echo   $prefix.$date.$ext;
        
    }
    
    
    public function getZeroInFirstStr($str)
    {
        $hasil="";
        $hasil2="";
        $arr_str = str_split($str,1);
        $new_arr = array(); 
        $totZero = 0;
        for ($i=0; $i<count($arr_str);$i++) {
            if($arr_str[$i]=='0')
            {
                $totZero+=1;
            }
            else
            {  
                break;
            }
            
        }
        array_splice($arr_str, 0,$totZero);
        if($totZero>0)
        {
            for($j=0;$j<$totZero;$j++)
            {
                $new_arr[$j]='0';
            }
        }
        $hasil2 =  count($new_arr)>0 ? implode($new_arr):'';
        $hasil =  intval(implode($arr_str))+1;
        return  $hasil2.$hasil ;

    }
    
    
    private function strright($rightstring, $length) {
        return(substr($rightstring, -$length));
}
    

}
