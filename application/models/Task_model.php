<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all_tasks() {
        $this->db->order_by('tgl_deadline', 'ASC');
        $this->db->order_by('waktu_deadline', 'ASC');
        query_after:
        return $this->db->get('tasks')->result_array();
    }

    public function get_task_by_id($id) {
        return $this->db->get_where('tasks', array('id' => $id))->row_array();
    }

    public function insert_task($data) {
        return $this->db->insert('tasks', $data);
    }

    public function update_task($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tasks', $data);
    }

    public function delete_task($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tasks');
    }
}
