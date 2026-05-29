<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Manajemen Tugas</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- SweetAlert2 for Premium Alerts -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --secondary-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --bg-body: #f8fafc;
            --card-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
            --modal-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: #1e293b;
            min-height: 100vh;
        }

        /* Navbar / Header */
        .app-header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .brand-title {
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        /* Main Container */
        .dashboard-container {
            max-width: 1200px;
            margin: 2.5rem auto;
            padding: 0 1.5rem;
        }

        /* Cards & Tables */
        .glass-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.08);
        }

        .card-header-custom {
            padding: 1.5rem 2rem;
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-add-task {
            background: var(--primary-gradient);
            color: #ffffff;
            font-weight: 600;
            border: none;
            padding: 0.6rem 1.4rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35);
            transition: all 0.2s ease;
        }

        .btn-add-task:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.45);
            color: #ffffff;
        }

        .btn-add-task:active {
            transform: translateY(0);
        }

        /* Custom Table Styling */
        .table-custom {
            margin-bottom: 0;
        }

        .table-custom th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-custom td {
            padding: 1.2rem 1.5rem;
            vertical-align: middle;
            font-size: 0.9rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-custom tbody tr {
            transition: background-color 0.2s ease;
        }

        .table-custom tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Task Title and Category */
        .task-title {
            font-weight: 600;
            color: #0f172a;
        }

        .task-cat {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-weight: 500;
            display: inline-block;
            margin-top: 0.25rem;
        }

        .cat-kuliah { background-color: #e0e7ff; color: #4338ca; }
        .cat-pekerjaan { background-color: #fef3c7; color: #d97706; }
        .cat-pribadi { background-color: #d1fae5; color: #065f46; }
        .cat-lainnya { background-color: #f1f5f9; color: #475569; }

        /* Badge Status Interaktif */
        .status-badge {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.4rem 0.8rem;
            border-radius: 30px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            user-select: none;
        }

        .status-badge:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .status-belum-selesai {
            background-color: #fee2e2;
            color: #ef4444;
            border: 1px solid #fca5a5;
        }

        .status-sedang-dikerjakan {
            background-color: #e0f2fe;
            color: #0284c7;
            border: 1px solid #93c5fd;
        }

        .status-selesai {
            background-color: #d1fae5;
            color: #059669;
            border: 1px solid #6ee7b7;
        }

        /* Action Buttons */
        .btn-action {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: none;
            transition: all 0.2s ease;
            font-size: 0.85rem;
            color: #64748b;
            background: #f1f5f9;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .btn-view:hover {
            background: #e0f2fe;
            color: #0284c7;
        }

        .btn-edit:hover {
            background: #fef3c7;
            color: #d97706;
        }

        .btn-delete:hover {
            background: #fee2e2;
            color: #ef4444;
        }

        /* Premium Modal Design */
        .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: var(--modal-shadow);
            overflow: hidden;
        }

        .modal-header-custom {
            background: var(--primary-gradient);
            color: #ffffff;
            padding: 1.5rem 2rem;
            border: none;
            position: relative;
        }

        .modal-header-custom .btn-close-white {
            filter: invert(1) grayscale(1) brightness(2);
            opacity: 0.8;
            transition: opacity 0.2s ease;
        }

        .modal-header-custom .btn-close-white:hover {
            opacity: 1;
        }

        .modal-body-custom {
            padding: 2rem;
        }

        .form-label {
            font-weight: 500;
            color: #475569;
            font-size: 0.85rem;
            margin-bottom: 0.4rem;
        }

        .form-control-custom, .form-select-custom {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            background-color: #f8fafc;
        }

        .form-control-custom:focus, .form-select-custom:focus {
            background-color: #ffffff;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        .modal-footer-custom {
            padding: 1.5rem 2rem;
            background-color: #f8fafc;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-modal-cancel {
            background: #e2e8f0;
            color: #475569;
            border: none;
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .btn-modal-cancel:hover {
            background: #cbd5e1;
            color: #334155;
        }

        .btn-modal-submit {
            background: var(--primary-gradient);
            color: #ffffff;
            border: none;
            font-weight: 600;
            padding: 0.6rem 1.4rem;
            border-radius: 10px;
            font-size: 0.9rem;
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.25);
            transition: all 0.2s ease;
        }

        .btn-modal-submit:hover {
            box-shadow: 0 6px 15px rgba(99, 102, 241, 0.35);
            transform: translateY(-1px);
        }

        /* Detail Modal Styling */
        .detail-item {
            margin-bottom: 1.2rem;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 0.8rem;
        }

        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .detail-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 600;
            color: #94a3b8;
            letter-spacing: 0.5px;
            margin-bottom: 0.2rem;
        }

        .detail-value {
            font-size: 0.95rem;
            color: #1e293b;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <header class="app-header py-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check2-square text-primary fs-3" style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
                <span class="brand-title fs-4">Aplikasi Manajemen Tugas</span>
            </div>
            <span class="text-muted small"><i class="bi bi-calendar3 me-1"></i> <span id="current-date"></span></span>
        </div>
    </header>

    <!-- Main Container -->
    <main class="dashboard-container">
        <!-- Dashboard Header -->
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h1 class="h3 fw-bold m-0">Daftar Tugas</h1>
                <p class="text-muted small m-0">Kelola dan selesaikan semua tugas Anda dengan terstruktur.</p>
            </div>
        </div>

        <!-- Glass Card Table -->
        <div class="glass-card">
            <div class="card-header-custom">
                <h5 class="m-0 fw-bold"><i class="bi bi-list-task me-2 text-primary"></i>Semua Tugas</h5>
                <button type="button" class="btn btn-add-task btn-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    <i class="bi bi-plus-lg"></i> Tambah Tugas
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th style="width: 60px;" class="text-center">No</th>
                            <th>Judul Tugas</th>
                            <th>Deskripsi</th>
                            <th>Deadline</th>
                            <th class="text-center">Status</th>
                            <th style="width: 150px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="task-list">
                        <?php if(!empty($tasks)): ?>
                            <?php $no = 1; foreach($tasks as $t): ?>
                                <tr id="task-row-<?= $t['id'] ?>">
                                    <td class="text-center font-monospace fw-semibold text-muted"><?= $no++ ?></td>
                                    <td>
                                        <div class="task-title"><?= htmlspecialchars($t['judul_tugas']) ?></div>
                                        <?php 
                                            $catClass = 'cat-lainnya';
                                            $catVal = strtolower($t['kategori']);
                                            if ($catVal == 'kuliah') $catClass = 'cat-kuliah';
                                            elseif ($catVal == 'pekerjaan') $catClass = 'cat-pekerjaan';
                                            elseif ($catVal == 'pribadi') $catClass = 'cat-pribadi';
                                        ?>
                                        <span class="task-cat <?= $catClass ?>"><?= htmlspecialchars($t['kategori']) ?></span>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 250px;" title="<?= htmlspecialchars($t['deskripsi']) ?>">
                                            <?= htmlspecialchars($t['deskripsi']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark"><i class="bi bi-calendar-event me-1 text-muted"></i><?= date('d M Y', strtotime($t['tgl_deadline'])) ?></div>
                                        <div class="small text-muted"><i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($t['waktu_deadline'])) ?> WIB</div>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                            $statusClass = 'status-belum-selesai';
                                            $statusText = $t['status'];
                                            if ($statusText === 'Sedang Dikerjakan') $statusClass = 'status-sedang-dikerjakan';
                                            elseif ($statusText === 'Selesai') $statusClass = 'status-selesai';
                                        ?>
                                        <span class="status-badge <?= $statusClass ?>" onclick="openStatusModal(<?= $t['id'] ?>, '<?= htmlspecialchars($t['status']) ?>')">
                                            <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> <?= htmlspecialchars($t['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn-action btn-view" title="Lihat Detail" onclick="viewTask(<?= $t['id'] ?>)">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                            <button class="btn-action btn-edit" title="Edit Tugas" onclick="editTask(<?= $t['id'] ?>)">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <button class="btn-action btn-delete" title="Hapus Tugas" onclick="confirmDelete(<?= $t['id'] ?>)">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                                    Tidak ada tugas saat ini. Mulai dengan menambahkan tugas baru!
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="text-center text-muted mt-5 mb-4 small">
        <p class="mb-0">Powered by <strong>Marlan Munaji</strong> &copy; <?= date('Y') ?></p>
    </footer>

    <!-- ======================================= -->
    <!-- MODAL POPUP: TAMBAH TUGAS -->
    <!-- ======================================= -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header-custom d-flex justify-content-between align-items-center">
                    <h5 class="modal-title fw-bold" id="addTaskModalLabel"><i class="bi bi-plus-circle me-2"></i>Tambah Tugas Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addTaskForm">
                    <div class="modal-body-custom">
                        <div class="mb-3">
                            <label for="add_judul_tugas" class="form-label">Judul Tugas</label>
                            <input type="text" class="form-control form-control-custom" id="add_judul_tugas" name="judul_tugas" placeholder="Masukkan judul tugas" required>
                        </div>
                        <div class="mb-3">
                            <label for="add_deskripsi" class="form-label">Deskripsi Tugas</label>
                            <textarea class="form-control form-control-custom" id="add_deskripsi" name="deskripsi" rows="3" placeholder="Tulis rincian tugas..." required></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="add_tgl_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control form-control-custom" id="add_tgl_mulai" name="tgl_mulai" required>
                            </div>
                            <div class="col-md-6">
                                <label for="add_waktu_mulai" class="form-label">Waktu Mulai</label>
                                <input type="time" class="form-control form-control-custom" id="add_waktu_mulai" name="waktu_mulai" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="add_tgl_deadline" class="form-label">Tanggal Deadline</label>
                                <input type="date" class="form-control form-control-custom" id="add_tgl_deadline" name="tgl_deadline" required>
                            </div>
                            <div class="col-md-6">
                                <label for="add_waktu_deadline" class="form-label">Waktu Deadline</label>
                                <input type="time" class="form-control form-control-custom" id="add_waktu_deadline" name="waktu_deadline" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="add_kategori" class="form-label">Kategori</label>
                                <select class="form-select form-select-custom" id="add_kategori" name="kategori" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <option value="Kuliah">Kuliah</option>
                                    <option value="Pekerjaan">Pekerjaan</option>
                                    <option value="Pribadi">Pribadi</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="add_status" class="form-label">Status</label>
                                <select class="form-select form-select-custom" id="add_status" name="status" required>
                                    <option value="Belum Selesai" selected>Belum Selesai</option>
                                    <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer-custom">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-modal-submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ======================================= -->
    <!-- MODAL POPUP: EDIT TUGAS -->
    <!-- ======================================= -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header-custom d-flex justify-content-between align-items-center" style="background: var(--warning-gradient)">
                    <h5 class="modal-title fw-bold" id="editTaskModalLabel"><i class="bi bi-pencil-square me-2"></i>Ubah Tugas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTaskForm">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-body-custom">
                        <div class="mb-3">
                            <label for="edit_judul_tugas" class="form-label">Judul Tugas</label>
                            <input type="text" class="form-control form-control-custom" id="edit_judul_tugas" name="judul_tugas" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_deskripsi" class="form-label">Deskripsi Tugas</label>
                            <textarea class="form-control form-control-custom" id="edit_deskripsi" name="deskripsi" rows="3" required></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_tgl_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control form-control-custom" id="edit_tgl_mulai" name="tgl_mulai" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_waktu_mulai" class="form-label">Waktu Mulai</label>
                                <input type="time" class="form-control form-control-custom" id="edit_waktu_mulai" name="waktu_mulai" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_tgl_deadline" class="form-label">Tanggal Deadline</label>
                                <input type="date" class="form-control form-control-custom" id="edit_tgl_deadline" name="tgl_deadline" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_waktu_deadline" class="form-label">Waktu Deadline</label>
                                <input type="time" class="form-control form-control-custom" id="edit_waktu_deadline" name="waktu_deadline" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_kategori" class="form-label">Kategori</label>
                                <select class="form-select form-select-custom" id="edit_kategori" name="kategori" required>
                                    <option value="Kuliah">Kuliah</option>
                                    <option value="Pekerjaan">Pekerjaan</option>
                                    <option value="Pribadi">Pribadi</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_status" class="form-label">Status</label>
                                <select class="form-select form-select-custom" id="edit_status" name="status" required>
                                    <option value="Belum Selesai">Belum Selesai</option>
                                    <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer-custom">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-modal-submit" style="background: var(--warning-gradient); box-shadow: 0 4px 10px rgba(245, 158, 11, 0.25);">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ======================================= -->
    <!-- MODAL POPUP: LIHAT DETAIL TUGAS -->
    <!-- ======================================= -->
    <div class="modal fade" id="viewTaskModal" tabindex="-1" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header-custom d-flex justify-content-between align-items-center">
                    <h5 class="modal-title fw-bold" id="viewTaskModalLabel"><i class="bi bi-info-circle me-2"></i>Detail Lengkap Tugas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body-custom">
                    <div class="detail-item">
                        <div class="detail-label">Judul Tugas</div>
                        <div class="detail-value fs-5 fw-bold" id="detail_judul">Tugas ETS</div>
                    </div>
                    <div class="row">
                        <div class="col-6 detail-item">
                            <div class="detail-label">Kategori</div>
                            <div class="detail-value" id="detail_kategori">Kuliah</div>
                        </div>
                        <div class="col-6 detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" id="detail_status"><span class="badge bg-danger">Belum Selesai</span></div>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Deskripsi</div>
                        <div class="detail-value text-secondary" id="detail_deskripsi" style="white-space: pre-line;"></div>
                    </div>
                    <div class="row">
                        <div class="col-6 detail-item">
                            <div class="detail-label">Mulai</div>
                            <div class="detail-value" id="detail_mulai">-</div>
                        </div>
                        <div class="col-6 detail-item">
                            <div class="detail-label">Deadline</div>
                            <div class="detail-value" id="detail_deadline">-</div>
                        </div>
                    </div>
                    <div class="detail-item" id="detail_selesai_wrapper" style="display: none;">
                        <div class="detail-label">Diselesaikan Pada</div>
                        <div class="detail-value text-success font-monospace" id="detail_selesai">-</div>
                    </div>
                </div>
                <div class="modal-footer-custom">
                    <button type="button" class="btn-modal-cancel bg-secondary text-white" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================= -->
    <!-- MODAL POPUP: UBAH STATUS (QUICK UPDATE) -->
    <!-- ======================================= -->
    <div class="modal fade" id="statusTaskModal" tabindex="-1" aria-labelledby="statusTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header-custom d-flex justify-content-between align-items-center" style="background: var(--secondary-gradient)">
                    <h5 class="modal-title fw-bold fs-6" id="statusTaskModalLabel"><i class="bi bi-arrow-repeat me-2"></i>Update Status</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="statusTaskForm">
                    <input type="hidden" id="status_id" name="id">
                    <div class="modal-body-custom p-4">
                        <div class="mb-3">
                            <label for="quick_status" class="form-label">Pilih Status Baru</label>
                            <select class="form-select form-select-custom" id="quick_status" name="status" required>
                                <option value="Belum Selesai">Belum Selesai</option>
                                <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer-custom p-3 bg-light">
                        <button type="button" class="btn-modal-cancel btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-modal-submit btn-sm" style="background: var(--secondary-gradient); box-shadow: 0 4px 10px rgba(16, 185, 129, 0.25);">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 for Premium Alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Set Base URL dynamically
        const BASE_URL = '<?= base_url() ?>';

        // Set real date
        document.getElementById('current-date').textContent = new Date().toLocaleDateString('id-ID', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });

        // Initialize Modals
        const addTaskModal = new bootstrap.Modal(document.getElementById('addTaskModal'));
        const editTaskModal = new bootstrap.Modal(document.getElementById('editTaskModal'));
        const viewTaskModal = new bootstrap.Modal(document.getElementById('viewTaskModal'));
        const statusTaskModal = new bootstrap.Modal(document.getElementById('statusTaskModal'));

        // Handle Add Task Submit
        document.getElementById('addTaskForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch(BASE_URL + 'tasks/store', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    addTaskModal.hide();
                    document.getElementById('addTaskForm').reset();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else if (data.status === 'validation_error') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validasi Gagal',
                        html: data.errors
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message
                    });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({ icon: 'error', title: 'Galat Sistem', text: 'Terjadi kegagalan komunikasi ke server.' });
            });
        });

        // Fetch task detail and populate modal "Lihat"
        function viewTask(id) {
            fetch(BASE_URL + 'tasks/detail/' + id)
            .then(res => res.json())
            .then(response => {
                if (response.status === 'success') {
                    const data = response.data;
                    document.getElementById('detail_judul').textContent = data.judul_tugas;
                    document.getElementById('detail_kategori').textContent = data.kategori;
                    document.getElementById('detail_deskripsi').textContent = data.deskripsi;
                    document.getElementById('detail_mulai').innerHTML = `<i class="bi bi-calendar-check me-1 text-muted"></i>${formatDate(data.tgl_mulai)}<br><small class="text-muted"><i class="bi bi-clock me-1"></i>${data.waktu_mulai.substring(0, 5)} WIB</small>`;
                    document.getElementById('detail_deadline').innerHTML = `<i class="bi bi-calendar-x me-1 text-muted"></i>${formatDate(data.tgl_deadline)}<br><small class="text-muted"><i class="bi bi-clock me-1"></i>${data.waktu_deadline.substring(0, 5)} WIB</small>`;
                    
                    // Status Badge
                    let badgeClass = 'bg-danger';
                    if(data.status === 'Sedang Dikerjakan') badgeClass = 'bg-info text-dark';
                    else if(data.status === 'Selesai') badgeClass = 'bg-success';
                    document.getElementById('detail_status').innerHTML = `<span class="badge ${badgeClass}">${data.status}</span>`;

                    // Selesai date info
                    const selesaiWrapper = document.getElementById('detail_selesai_wrapper');
                    if (data.status === 'Selesai' && data.tgl_selesai) {
                        selesaiWrapper.style.display = 'block';
                        document.getElementById('detail_selesai').textContent = formatDate(data.tgl_selesai);
                    } else {
                        selesaiWrapper.style.display = 'none';
                    }

                    viewTaskModal.show();
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({ icon: 'error', title: 'Galat Sistem', text: 'Gagal mengambil data detail.' });
            });
        }

        // Fetch task and populate modal "Edit"
        function editTask(id) {
            fetch(BASE_URL + 'tasks/detail/' + id)
            .then(res => res.json())
            .then(response => {
                if (response.status === 'success') {
                    const data = response.data;
                    document.getElementById('edit_id').value = data.id;
                    document.getElementById('edit_judul_tugas').value = data.judul_tugas;
                    document.getElementById('edit_deskripsi').value = data.deskripsi;
                    document.getElementById('edit_tgl_mulai').value = data.tgl_mulai;
                    document.getElementById('edit_waktu_mulai').value = data.waktu_mulai;
                    document.getElementById('edit_tgl_deadline').value = data.tgl_deadline;
                    document.getElementById('edit_waktu_deadline').value = data.waktu_deadline;
                    document.getElementById('edit_kategori').value = data.kategori;
                    document.getElementById('edit_status').value = data.status;

                    editTaskModal.show();
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({ icon: 'error', title: 'Galat Sistem', text: 'Gagal mengambil data edit.' });
            });
        }

        // Handle Edit Task Submit
        document.getElementById('editTaskForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('edit_id').value;
            const formData = new FormData(this);

            fetch(BASE_URL + 'tasks/update/' + id, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    editTaskModal.hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else if (data.status === 'validation_error') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validasi Gagal',
                        html: data.errors
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message
                    });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({ icon: 'error', title: 'Galat Sistem', text: 'Terjadi kegagalan komunikasi ke server.' });
            });
        });

        // Quick status updater modal
        function openStatusModal(id, currentStatus) {
            document.getElementById('status_id').value = id;
            document.getElementById('quick_status').value = currentStatus;
            statusTaskModal.show();
        }

        // Handle Status Change Submit
        document.getElementById('statusTaskForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('status_id').value;
            const formData = new FormData(this);

            fetch(BASE_URL + 'tasks/update_status/' + id, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    statusTaskModal.hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Status Terupdate!',
                        text: data.message,
                        timer: 1200,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message
                    });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({ icon: 'error', title: 'Galat Sistem', text: 'Gagal memperbarui status.' });
            });
        });

        // Delete Task Confirmation
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data tugas yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                customClass: {
                    popup: 'border-radius-20'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(BASE_URL + 'tasks/delete/' + id)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: data.message,
                                timer: 1200,
                                showConfirmButton: false
                            }).then(() => {
                                // Smooth remove from table
                                const row = document.getElementById('task-row-' + id);
                                if (row) {
                                    row.style.transition = 'all 0.3s ease';
                                    row.style.opacity = '0';
                                    setTimeout(() => {
                                        row.remove();
                                        // If no items left, reload to show empty state
                                        if (document.querySelectorAll('#task-list tr').length === 0) {
                                            location.reload();
                                        }
                                    }, 300);
                                } else {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire({ icon: 'error', title: 'Galat Sistem', text: 'Gagal menghapus data.' });
                    });
                }
            });
        }

        // Helper to format date in Indonesian style
        function formatDate(dateStr) {
            if (!dateStr) return '-';
            const date = new Date(dateStr);
            return date.toLocaleDateString('id-ID', {
                day: 'numeric', month: 'short', year: 'numeric'
            });
        }
    </script>
</body>
</html>
