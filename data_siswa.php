<?php
include 'koneksi.php';

// Handle Tambah Siswa
if (isset($_POST['addStudent'])) {
    $Nis = $_POST['nis'];
    $Nama = $_POST['nama'];
    $Kelas = $_POST['kelas'];
    $Alamat = $_POST['alamat'];

    $query = "INSERT INTO siswa (Nis, Nama, Kelas, Alamat) VALUES ('$Nis', '$Nama', '$Kelas', '$Alamat')";
    if (mysqli_query($koneksi, $query)) {
        header("Location: data_siswa.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);  // Menampilkan error dari query
    }    
}

// Handle Edit Siswa
if (isset($_POST['editStudent'])) {
    $Nis = $_POST['nis'];
    $Nama = $_POST['nama'];
    $Kelas = $_POST['kelas'];
    $Alamat = $_POST['alamat'];

    $query = "UPDATE siswa SET Nama='$Nama', Kelas='$Kelas', Alamat='$Alamat' WHERE Nis='$Nis'";
    if (mysqli_query($koneksi, $query)) {
        header("Location: data_siswa.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

// Handle Hapus Siswa
if (isset($_GET['deleteId'])) {
    $Nis = $_GET['deleteId'];

    $query = "DELETE FROM siswa WHERE Nis='$Nis'";
    if (mysqli_query($koneksi, $query)) {
        header("Location: data_siswa.php");
        exit;
    } else {
        echo "Error deleting student: " . mysqli_error($koneksi);
    }
}

// Ambil data siswa
$query = "SELECT * FROM siswa";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css"> <!-- AdminLTE CSS -->
    <style>
        body {
            background-color: #f4f6f9; /* Warna latar belakang */
        }
        .content-wrapper {
            margin-left: 0; /* Reset any margin from previous customizations */
            margin-left: 200px; /* Adjust the left margin to match the sidebar width */
        }
        .table {
            margin-top: 20px; /* Tambahkan margin atas untuk jarak */
        }
        .table th {
            background-color: #007bff; /* Warna latar belakang header */
            color: white; /* Warna teks header */
        }
        .table tbody tr:hover {
            background-color: #e9ecef; /* Warna latar belakang saat hover */
        }
        .modal-header {
            background-color: #007bff; /* Warna latar belakang modal header */
            color: white; /* Warna teks modal header */
        }
        .btn-primary {
            background-color: #007bff; /* Warna tombol primary */
            border-color: #007bff; /* Warna border tombol primary */
        }
        .btn-danger {
            background-color: #dc3545; /* Warna tombol danger */
            border-color: #dc3545; /* Warna border tombol danger */
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <img src="image/admin.png" alt="Logo TPQ" class="brand-image img-circle elevation-3" style="opacity: .8;">
            <span class="brand-text font-weight-light">ADMIN</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="data_siswa.php" class="nav-link active">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Data Siswa</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pembayaran.php" class="nav-link">
                            <i class="nav-icon fas fa-credit-card"></i>
                            <p>Pembayaran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="laporan.php" class="nav-link">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link" onclick="return confirmLogout();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1></h1>
        </section>
        <section class="content">
            <div class="container mt-4">
                <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal">
                    <i class="fas fa-plus-circle"></i> Tambah Siswa
                </button>
                <table class="table table-bordered">
    <thead>
    <tr>
        <th>Nis</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['Nis']}</td>";
        echo "<td>{$row['Nama']}</td>";
        echo "<td>{$row['Kelas']}</td>";
        echo "<td>{$row['Alamat']}</td>";
        echo "<td>
                <button class='btn btn-success btn-sm' data-toggle='modal' data-target='#editModal' 
                       data-nis='{$row['Nis']}' data-nama='{$row['Nama']}' data-kelas='{$row['Kelas']}' data-alamat='{$row['Alamat']}'>
                    <i class='fas fa-edit'></i> Edit
                </button>
                <a href='data_siswa.php?deleteId={$row['Nis']}' class='btn btn-danger btn-sm' 
                   onclick='return confirm(\"Apakah kamu yakin ingin menghapus data siswa?\");'>
                    <i class='fas fa-trash'></i> Hapus
                </a>
              </td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table><!-- Modal Tambah Siswa -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="data_siswa.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nis</label>
                        <input type="text" name="nis" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" name="kelas" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="addStudent" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Siswa -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="data_siswa.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nis</label>
                        <input type="text" name="nis" id="editNis" class="form-control" readonly required>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" id="editNama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" name="kelas" id="editKelas" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" id="editAlamat" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="editStudent" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Pass data to Edit Modal
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var nis = button.data('nis');
        var nama = button.data('nama');
        var kelas = button.data('kelas');
        var alamat = button.data('alamat');

        var modal = $(this);
        modal.find('#editNis').val(nis);
        modal.find('#editNama').val(nama);
        modal.find('#editKelas').val(kelas);
        modal.find('#editAlamat').val(alamat);
    });
</script>
</body>
</html>