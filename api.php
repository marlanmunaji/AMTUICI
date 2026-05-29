<?php
header('Content-Type: application/json');
require_once 'config.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'detail':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
        $task = $stmt->fetch();
        if ($task) {
            echo json_encode(['status' => 'success', 'data' => $task]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Tugas tidak ditemukan.']);
        }
        break;

    case 'store':
        // Validation check
        $required_fields = ['judul_tugas', 'kategori', 'deskripsi', 'tgl_mulai', 'waktu_mulai', 'tgl_deadline', 'waktu_deadline', 'status'];
        $errors = [];
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                $friendly_name = ucwords(str_replace('_', ' ', $field));
                $errors[] = "<p>Bagian {$friendly_name} wajib diisi.</p>";
            }
        }

        if (!empty($errors)) {
            echo json_encode(['status' => 'validation_error', 'errors' => implode('', $errors)]);
            exit;
        }

        $judul_tugas = trim($_POST['judul_tugas']);
        $kategori = $_POST['kategori'];
        $deskripsi = trim($_POST['deskripsi']);
        $tgl_mulai = $_POST['tgl_mulai'];
        $waktu_mulai = $_POST['waktu_mulai'];
        $tgl_deadline = $_POST['tgl_deadline'];
        $waktu_deadline = $_POST['waktu_deadline'];
        $status = $_POST['status'];
        $tgl_selesai = ($status === 'Selesai') ? date('Y-m-d') : null;

        $stmt = $pdo->prepare("INSERT INTO tasks (judul_tugas, kategori, deskripsi, tgl_mulai, waktu_mulai, tgl_deadline, waktu_deadline, status, tgl_selesai) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $result = $stmt->execute([$judul_tugas, $kategori, $deskripsi, $tgl_mulai, $waktu_mulai, $tgl_deadline, $waktu_deadline, $status, $tgl_selesai]);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Tugas berhasil ditambahkan!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan tugas.']);
        }
        break;

    case 'update':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        $required_fields = ['judul_tugas', 'kategori', 'deskripsi', 'tgl_mulai', 'waktu_mulai', 'tgl_deadline', 'waktu_deadline', 'status'];
        $errors = [];
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                $friendly_name = ucwords(str_replace('_', ' ', $field));
                $errors[] = "<p>Bagian {$friendly_name} wajib diisi.</p>";
            }
        }

        if (!empty($errors)) {
            echo json_encode(['status' => 'validation_error', 'errors' => implode('', $errors)]);
            exit;
        }

        $judul_tugas = trim($_POST['judul_tugas']);
        $kategori = $_POST['kategori'];
        $deskripsi = trim($_POST['deskripsi']);
        $tgl_mulai = $_POST['tgl_mulai'];
        $waktu_mulai = $_POST['waktu_mulai'];
        $tgl_deadline = $_POST['tgl_deadline'];
        $waktu_deadline = $_POST['waktu_deadline'];
        $status = $_POST['status'];

        // Get existing task to check status transition
        $stmt_exist = $pdo->prepare("SELECT tgl_selesai FROM tasks WHERE id = ?");
        $stmt_exist->execute([$id]);
        $existing = $stmt_exist->fetch();

        $tgl_selesai = null;
        if ($status === 'Selesai') {
            if ($existing && !empty($existing['tgl_selesai'])) {
                $tgl_selesai = $existing['tgl_selesai'];
            } else {
                $tgl_selesai = date('Y-m-d');
            }
        }

        $stmt = $pdo->prepare("UPDATE tasks SET judul_tugas = ?, kategori = ?, deskripsi = ?, tgl_mulai = ?, waktu_mulai = ?, tgl_deadline = ?, waktu_deadline = ?, status = ?, tgl_selesai = ? WHERE id = ?");
        $result = $stmt->execute([$judul_tugas, $kategori, $deskripsi, $tgl_mulai, $waktu_mulai, $tgl_deadline, $waktu_deadline, $status, $tgl_selesai, $id]);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Tugas berhasil diperbarui!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui tugas.']);
        }
        break;

    case 'update_status':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        if (empty($status)) {
            echo json_encode(['status' => 'error', 'message' => 'Status tidak boleh kosong.']);
            exit;
        }

        $tgl_selesai = ($status === 'Selesai') ? date('Y-m-d') : null;

        $stmt = $pdo->prepare("UPDATE tasks SET status = ?, tgl_selesai = ? WHERE id = ?");
        $result = $stmt->execute([$status, $tgl_selesai, $id]);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Status tugas berhasil diperbarui!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui status.']);
        }
        break;

    case 'delete':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
        $result = $stmt->execute([$id]);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Tugas berhasil dihapus!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus tugas.']);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Aksi tidak dikenal.']);
        break;
}
