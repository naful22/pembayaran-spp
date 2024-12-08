<!-- layout.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<!-- Sidebar and Navbar -->
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark text-white" id="sidebar">
        <div class="sidebar-heading text-center">
            <h4>Dashboard</h4>
        </div>
        <div class="list-group list-group-flush">
            <a href="dashboard.php" class="list-group-item list-group-item-action bg-dark text-white">Dashboard</a>
            <a href="data_siswa.php" class="list-group-item list-group-item-action bg-dark text-white">Data Siswa</a>
            <a href="pembayaran.php" class="list-group-item list-group-item-action bg-dark text-white">Pembayaran</a>
            <a href="laporan.php" class="list-group-item list-group-item-action bg-dark text-white">Laporan</a>
            <a href="logout.php" class="list-group-item list-group-item-action bg-dark text-white">Logout</a>
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="btn btn-primary" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand" href="#">Admin Panel</a>
        </nav>

        <!-- Content Section -->
        <div class="container mt-4">
            <!-- Include the content from another page here -->
            <?php include 'data_siswa.php'; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
