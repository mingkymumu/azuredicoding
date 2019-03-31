<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_tree_menu extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function getArrayMenu() {

        $criteria = $this->db->get('menu_item');
        foreach ($criteria->result_array() as $data) {
            $row[] = array(
                'id' => $data['id'],
                'title' => $data['title'],
                'link' => $data['link'],
                'parent_id' => $data['parent_id']
            );
        }
        return $row;
    }

    public function getJson() {
        $row = array();
        $criteria = $this->db->get('menu_item');
        foreach ($criteria->result_array() as $data) {
            $row[] = array(
                'id' => intval($data['id']),
                'text' => $data['title'],
                'parent_id' => intval($data['parent_id'])
            );
        }
        return json_encode($row);
    }

    public function getJsonMenu() {
        $roleId = $this->session->userdata('role');
        $row = array();
        $sql = "select d.* from users a join role b on a.role_id=b.role_id
                        join role_menu c on b.role_id=c.role_id 
                        join menu_item d on c.menu_id=d.id
                        where b.role_id=?";
        $criteria = $this->db->query($sql, array($roleId));
        foreach ($criteria->result_array() as $data) {
            $row[] = array(
                'id' => intval($data['id']),
                'text' => $data['title'],
                'parent_id' => intval($data['parent_id'])
            );
        }
        return json_encode($row);
    }

    public function getJsonMenuAll() {
        $row = array();
        $sql = "select *  from menu_item ";
        $criteria = $this->db->query($sql);
        foreach ($criteria->result_array() as $data) {
            $row[] = array(
                'id' => intval($data['id']),
                'title' => $data['title'],
                'parent_id' => intval($data['parent_id']),
                'url' => $data['url'],
                'link' => $data['link']
            );
        }
        return json_encode($row);
    }

    //buat menghasilkan json ke akses menu 
    public function getJsonMenuByRole() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $row = array();
        $sql = "select a.* from menu_item a join role_menu b on a.id=b.menu_id
                where b.role_id = ?";
        $criteria = $this->db->query($sql, array($id));
        foreach ($criteria->result_array() as $data) {
            $row[] = array(
                'id' => intval($data['id'])
            );
        }
        return json_encode($row);
    }

    //buat tree tampil di menu hak akses
    public function getJsonAkses() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $result = array();
        $this->db->select('*');
        $this->db->from('menu_item');
        $this->db->where('parent_id', $id);
        $criteria = $this->db->get();
        foreach ($criteria->result_array() as $row) {
            $node = array();
            $node['id'] = $row['id'];
            $node['text'] = $row['title'];
            $node['state'] = $this->has_child($row['id']) ? 'closed' : 'open';
            array_push($result, $node);
        }
        echo json_encode($result);
    }

    public function has_child($id) {

        $this->db->select('*');
        $this->db->from('menu_item');
        $this->db->where('parent_id', $id);
        $query = $this->db->get();
        return ($query->num_rows() > 0);
    }

    public function geturl($title) {
        $title = $this->input->post('title');
        $row = "";
        $this->db->select('url');
        $this->db->from('menu_item');
        $this->db->where('title', $title);
        $query = $this->db->get();
        $row = $query->row();
        if (isset($row))
            return $row->url;
    }

    public function generateJsonTree() {
        $sql = "select id,title as text,parent_id  from menu_item ";
        $criteria = $this->db->query($sql);
        $arr = $criteria->result_array();
        $x = array();
        $new = array();
        foreach ($arr as $a) {
            $new[$a['parent_id']][] = $a;
        }
        $tree = $this->createTree($new, $new[0]); // changed
        $x = $this->removeRecursive($tree, 'parent_id');
        //var_dump($y);
        return json_encode($x);
    }

    private function createTree(&$list, $parent) {
        $tree = array();
        foreach ($parent as $k => $l) {
            if (isset($list[$l['id']])) {
                $l['children'] = $this->createTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }
        return $tree;
    }

    function removeRecursive($haystack, $needle) {
        if (is_array($haystack)) {
            unset($haystack[$needle]);
            foreach ($haystack as $k => $value) {
                $haystack[$k] = $this->removeRecursive($value, $needle);
            }
        }
        return $haystack;
    }
    
    public function createRoleMenu()
    {
        
        $role_id = $_POST['role_id'];
        $array = $_POST['data'];
       $this->deleteRoleMenu();
        foreach ($array as $arr)
        {
         $x = array(
             'role_id'=>intval($role_id),
             'menu_id'=>intval($arr)
             );
             //array_push($a, $x);
         $this->db->set($x);
         $this->db->insert('role_menu',$x);
        }
//         var_dump($array);    
    }
    public function deleteRoleMenu()
    {
        $array = array(
            'role_id'=> intval($_POST['role_id'])
        );
       return $this->db->delete('role_menu', $array);         
    }

}
