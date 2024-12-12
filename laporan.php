<?php
session_start();
include 'koneksi.php';
// Handle Filter (if any)
$filterBulan = '';
if (isset($_POST['filterBulan'])) {
    $filterBulan = $_POST['bulan'];
    $query = "
        SELECT siswa.Nama, siswa.Nis, pembayaran.Bulan, pembayaran.Status, pembayaran.Jumlah
        FROM siswa
        JOIN pembayaran ON siswa.Nis = pembayaran.Nis
        WHERE pembayaran.Bulan LIKE '%$filterBulan%'";
} else {
    $query = "
        SELECT siswa.Nama, siswa.Nis, pembayaran.Bulan, pembayaran.Status, pembayaran.Jumlah
        FROM siswa
        JOIN pembayaran ON siswa.Nis = pembayaran.Nis";
}

$result = mysqli_query($koneksi, $query);

if (!$result) {
    echo "Error: " . mysqli_error($koneksi);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <style>
    body {
        background-color: #f4f6f9;
    }

    .content-wrapper {
        margin-left: 200px;
    }

    .table {
        margin-top: 20px;
    }

    .table th {
        background-color: #28a745; /* Green color */
        color: white;
    }

    .table tbody tr:hover {
        background-color: #e9ecef;
    }

    .btn-print {
        background-color: #28a745; /* Green color */
        color: white;
        padding: 5px 10px; /* Reduced padding for a smaller button */
        border-radius: 5px;
        font-weight: normal; /* Optional: to make the text less bold */
        font-size: 14px; /* Adjust the font size */
        transition: background-color 0.3s;
    }

    .btn-print:hover {
        background-color: #218838; /* Darker green on hover */
    }

    .btn-success {
        background-color: #28a745; /* Green color */
        color: white;
    }

    .btn-success:hover {
        background-color: #218838; /* Darker green on hover */
    }

    /* CSS khusus untuk cetak */
    @media print {
        /* Sembunyikan sidebar */
        .main-sidebar,
        .navbar-nav,
        .btn-print,
        form {
            display: none !important;
        }

        /* Atur margin untuk tampilan cetak */
        .content-wrapper {
            margin: 0 !important;
        }

        /* Tampilkan hanya tabel */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 5px;
        }
    }
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <img src="image/admin.png" alt="Logo" class="brand-image img-circle elevation-3">
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
                        <a href="data_siswa.php" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Data Siswa</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pembayaran.php" class="nav-link">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
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
                        <a href="logout.php" class="nav-link">
                            <i class="nav-icon fas fa-door-open"></i>
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
                <!-- Filter Form -->
                <form method="POST" action="" class="form-inline mb-3">
                    <label for="bulan" class="mr-2">Filter Bulan:</label>
                    <input type="text" name="bulan" id="bulan" class="form-control mr-2" placeholder="Masukkan Bulan" value="<?php echo $filterBulan; ?>">
                    <button type="submit" name="filterBulan" class="btn btn-success">Filter</button>
                    <a href="laporan_pembayaran.php" class="btn btn-secondary ml-2">Reset</a>
                </form>

                <!-- Table Laporan Pembayaran -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Nis</th>
                            <th>Bulan</th>
                            <th>Status</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['Nama']; ?></td>
                            <td><?php echo $row['Nis']; ?></td>
                            <td><?php echo $row['Bulan']; ?></td>
                            <td><?php echo $row['Status']; ?></td>
                            <td><?php echo 'Rp ' . number_format($row['Jumlah'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- Print Button -->
                <button class="btn-print" onclick="window.print()">Cetak Laporan</button>
            </div>
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
