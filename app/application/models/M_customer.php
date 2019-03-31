<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_customer extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function create() {
        return $this->db->insert('customer', array(
                    'cust_id' => $this->input->post('cust_id', true),
                    'cust_name' => $this->input->post('cust_name', true),
                    'address' => $this->input->post('address', true),
                    'telp' => $this->input->post('telp', true),
                    'disc_persen' => $this->input->post('disc_persen', true),
                    'disc_rupiah' => $this->input->post('disc_rupiah', true)
        ));
    }

    public function update($cust_id) {
        $this->db->where('cust_id', $cust_id);
        return $this->db->update('customer', array(
                    'cust_name' => $this->input->post('cust_name', true),
                    'address' => $this->input->post('address', true),
                    'telp' => $this->input->post('telp', true),
                    'disc_persen' => $this->input->post('disc_persen', true),
                    'disc_rupiah' => $this->input->post('disc_rupiah', true)
        ));
    }

    public function delete($cust_id) {
        return $this->db->delete('customer', array('cust_id' => $cust_id));
    }

    public function getJson() {

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'cust_id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page - 1) * $rows;

        $result = array();
        $result['total'] = $this->db->get('customer')->num_rows();
        $row = array();

        $this->db->limit($rows, $offset);
        $this->db->order_by($sort, $order);
        $criteria = $this->db->get('customer');

        foreach ($criteria->result_array() as $data) {
            $row[] = array(
                'cust_id' => $data['cust_id'],
                'cust_name' => $data['cust_name'],
                'address' => $data['address'],
                'telp' => $data['telp'],
                'disc_persen' => $data['disc_persen'],
                'disc_rupiah' => $data['disc_rupiah']
            );
        }
        $result = array_merge($result, array('rows' => $row));
        return json_encode($row);
    }

    public function getBy($berdasarkan = '', $cari = '') {

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'cust_id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        $offset = ($page - 1) * $rows;

        $result = array();
        
        if ($berdasarkan!="" && $cari!="") {
            $this->db->select('*');
            $this->db->from('customer');
            $this->db->like($berdasarkan, $cari);
            $criteria = $this->db->get();
        } else {
            $criteria = $this->db->get('customer');
        }
        $result['total'] = $criteria->num_rows();
        $row = array();
//        $this->db->limit($rows,$offset);
//        $this->db->order_by($sort,$order);
        foreach ($criteria->result_array() as $data) {
            $row[] = array(
                'cust_id' => $data['cust_id'],
                'cust_name' => $data['cust_name'],
                'address' => $data['address'],
                'telp' => $data['telp'],
                'disc_persen' => $data['disc_persen'],
                'disc_rupiah' => $data['disc_rupiah']
            );
        }
        $result = array_merge($result, array('rows' => $row));
        return json_encode($result);
    }

}
