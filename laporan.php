<?php
include 'koneksi.php';

// Handle Filter
$filterKelas = '';
if (isset($_POST['filterKelas'])) {
    $filterKelas = $_POST['kelas'];
    $query = "SELECT * FROM siswa WHERE Kelas LIKE '%$filterKelas%'";
} else {
    $query = "SELECT * FROM siswa";
}
$result = mysqli_query($koneksi, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Laporan</h1>
    <!-- Filter Form -->
    <form method="POST" action="laporan.php" class="form-inline mb-3">
        <label for="kelas" class="mr-2">Filter Kelas:</label>
        <input type="text" name="kelas" id="kelas" class="form-control mr-2" placeholder="Masukkan Kelas" value="<?php echo $filterKelas; ?>">
        <button type="submit" name="filterKelas" class="btn btn-primary">Filter</button>
        <a href="laporan.php" class="btn btn-secondary ml-2">Reset</a>
    </form>

    <!-- Table Data Siswa -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Alamat</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>$no</td>";
            echo "<td>{$row['Nis']}</td>";
            echo "<td>{$row['Nama']}</td>";
            echo "<td>{$row['Kelas']}</td>";
            echo "<td>{$row['Alamat']}</td>";
            echo "</tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>

    <!-- Button Cetak -->
    <button class="btn btn-success" onclick="window.print()">Cetak Laporan</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>

