<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Task_model');
        // Set timezone
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index() {
        $data['tasks'] = $this->Task_model->get_all_tasks();
        $this->load->view('tasks_view', $data);
    }

    public function detail($id) {
        $task = $this->Task_model->get_task_by_id($id);
        if ($task) {
            echo json_encode(['status' => 'success', 'data' => $task]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Tugas tidak ditemukan.']);
        }
    }

    public function store() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('judul_tugas', 'Judul Tugas', 'required|trim');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('waktu_mulai', 'Waktu Mulai', 'required');
        $this->form_validation->set_rules('tgl_deadline', 'Tanggal Deadline', 'required');
        $this->form_validation->set_rules('waktu_deadline', 'Waktu Deadline', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'validation_error', 'errors' => validation_errors()]);
            return;
        }

        $data = [
            'judul_tugas' => $this->input->post('judul_tugas'),
            'kategori' => $this->input->post('kategori'),
            'deskripsi' => $this->input->post('deskripsi'),
            'tgl_mulai' => $this->input->post('tgl_mulai'),
            'waktu_mulai' => $this->input->post('waktu_mulai'),
            'tgl_deadline' => $this->input->post('tgl_deadline'),
            'waktu_deadline' => $this->input->post('waktu_deadline'),
            'status' => $this->input->post('status'),
            'tgl_selesai' => ($this->input->post('status') === 'Selesai') ? date('Y-m-d') : null
        ];

        if ($this->Task_model->insert_task($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Tugas berhasil ditambahkan!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan tugas.']);
        }
    }

    public function update($id) {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('judul_tugas', 'Judul Tugas', 'required|trim');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('waktu_mulai', 'Waktu Mulai', 'required');
        $this->form_validation->set_rules('tgl_deadline', 'Tanggal Deadline', 'required');
        $this->form_validation->set_rules('waktu_deadline', 'Waktu Deadline', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'validation_error', 'errors' => validation_errors()]);
            return;
        }

        $data = [
            'judul_tugas' => $this->input->post('judul_tugas'),
            'kategori' => $this->input->post('kategori'),
            'deskripsi' => $this->input->post('deskripsi'),
            'tgl_mulai' => $this->input->post('tgl_mulai'),
            'waktu_mulai' => $this->input->post('waktu_mulai'),
            'tgl_deadline' => $this->input->post('tgl_deadline'),
            'waktu_deadline' => $this->input->post('waktu_deadline'),
            'status' => $this->input->post('status'),
        ];

        // Jika status diubah ke Selesai dan sebelumnya belum selesai, catat tgl_selesai
        // Atau jika status diubah ke yang lain, hilangkan tgl_selesai
        if ($this->input->post('status') === 'Selesai') {
            $existing = $this->Task_model->get_task_by_id($id);
            if ($existing && empty($existing['tgl_selesai'])) {
                $data['tgl_selesai'] = date('Y-m-d');
            }
        } else {
            $data['tgl_selesai'] = null;
        }

        if ($this->Task_model->update_task($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Tugas berhasil diperbarui!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui tugas.']);
        }
    }

    public function update_status($id) {
        $status = $this->input->post('status');
        if (empty($status)) {
            echo json_encode(['status' => 'error', 'message' => 'Status tidak boleh kosong.']);
            return;
        }

        $data = ['status' => $status];
        if ($status === 'Selesai') {
            $data['tgl_selesai'] = date('Y-m-d');
        } else {
            $data['tgl_selesai'] = null;
        }

        if ($this->Task_model->update_task($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Status tugas berhasil diperbarui!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui status.']);
        }
    }

    public function delete($id) {
        if ($this->Task_model->delete_task($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Tugas berhasil dihapus!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus tugas.']);
        }
    }
}
