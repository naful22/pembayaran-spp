<?php
include 'koneksi.php'; // Pastikan koneksi database sudah benar

// Query untuk menampilkan data pembayaran
$query = "SELECT siswa.Nama, pembayaran.nis, pembayaran.bulan, pembayaran.jumlah, pembayaran.status 
          FROM pembayaran 
          JOIN siswa ON pembayaran.nis = siswa.nis";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($koneksi));
}

// Menambahkan pembayaran baru
if (isset($_POST['addPayment'])) {
    $nis = $_POST['nis'];
    $bulan = $_POST['bulan'];
    $jumlah = str_replace(['Rp', '.', ' '], '', $_POST['jumlah']); // Menghilangkan format "Rp" dan titik
    $status = $_POST['status'];

    // Query untuk menambahkan data pembayaran baru
    $insertQuery = "INSERT INTO pembayaran (nis, bulan, jumlah, status) 
                    VALUES ('$nis', '$bulan', '$jumlah', '$status')";

    if (mysqli_query($koneksi, $insertQuery)) {
        echo "<script>alert('Data pembayaran berhasil disimpan');</script>";
        header('Location: pembayaran.php'); // Reload halaman setelah berhasil
        exit();
    } else {
        echo "<script>alert('Gagal menyimpan data pembayaran');</script>";
    }
}

// Mengedit data pembayaran
if (isset($_POST['editPayment'])) {
    $nis = $_POST['nis'];
    $bulan = $_POST['bulan'];
    $jumlah = str_replace(['Rp', '.', ' '], '', $_POST['jumlah']); // Menghilangkan format "Rp" dan titik
    $status = $_POST['status'];

    // Query untuk memperbarui data pembayaran
    $updateQuery = "UPDATE pembayaran SET bulan = '$bulan', jumlah = '$jumlah', status = '$status' 
                    WHERE nis = '$nis' AND bulan = '$bulan'";

    if (mysqli_query($koneksi, $updateQuery)) {
        echo "<script>alert('Data pembayaran berhasil diperbarui');</script>";
        header('Location: pembayaran.php'); // Reload halaman setelah berhasil
        exit();
    } else {
        echo "<script>alert('Gagal memperbarui data pembayaran');</script>";
    }
}

// Menghapus data pembayaran
if (isset($_GET['delete'])) {
    $nis = $_GET['delete'];
    $bulan = $_GET['bulan'];

    // Query untuk menghapus data pembayaran
    $deleteQuery = "DELETE FROM pembayaran WHERE nis = '$nis' AND bulan = '$bulan'";

    if (mysqli_query($koneksi, $deleteQuery)) {
        echo "<script>alert('Data pembayaran berhasil dihapus');</script>";
        header('Location: pembayaran.php'); // Reload halaman setelah berhasil
        exit();
    } else {
        echo "<script>alert('Gagal menghapus data pembayaran');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembayaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Data Pembayaran</h1>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal">Tambah Pembayaran</button>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Nis</th>
            <th>Bulan</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>$no</td>";
            echo "<td>{$row['Nama']}</td>";
            echo "<td>{$row['nis']}</td>";
            echo "<td>{$row['bulan']}</td>";
            echo "<td>Rp " . number_format($row['jumlah'], 0, ',', '.') . "</td>";
            echo "<td>{$row['status']}</td>";
            echo "<td>
            <button class='btn btn-success btn-sm' data-toggle='modal' data-target='#editModal' onclick='editPayment({$row['nis']}, \"{$row['bulan']}\", {$row['jumlah']}, \"{$row['status']}\")'>Edit</button>
            <a href='pembayaran.php?delete={$row['nis']}&bulan={$row['bulan']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah kamu yakin ingin menghapus pembayaran ini?\")'>Delete</a>
            </td>";
            echo "</tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Pembayaran -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="pembayaran.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Siswa</label>
                        <select name="nis" class="form-control" required>
                            <option value="">Pilih Siswa</option>
                            <?php
                            $siswaQuery = "SELECT * FROM siswa";
                            $siswaResult = mysqli_query($koneksi, $siswaQuery);
                            while ($siswa = mysqli_fetch_assoc($siswaResult)) {
                                echo "<option value='{$siswa['Nis']}'>{$siswa['Nama']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Bulan</label>
                        <select name="bulan" class="form-control" required>
                            <option value="">Pilih Bulan</option>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <select name="jumlah" class="form-control" required>
                            <option value="10000">Rp. 10.000</option>
                            <option value="20000">Rp. 20.000</option>
                            <option value="30000">Rp. 30.000</option>
                            <option value="40000">Rp. 40.000</option>
                            <option value="50000">Rp. 50.000</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="addPayment" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Pembayaran -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="pembayaran.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- Input Hidden untuk Nis -->
                    <input type="hidden" name="nis" id="editNis">
                    
                    <div class="form-group">
                        <label>Bulan</label>
                        <select name="bulan" id="editBulan" class="form-control" required>
                            <option value="">Pilih Bulan</option>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="text" name="jumlah" id="editJumlah" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="editStatus" class="form-control" required>
                            <option value="Lunas">Lunas</option>
                            <option value="Belum Lunas">Belum Lunas</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="editPayment" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript Dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Function to populate the Edit modal
function editPayment(nis, bulan, jumlah, status) {
    // Isi data pada modal berdasarkan data yang dipilih
    $('#editNis').val(nis);
    $('#editBulan').val(bulan); // Set pilihan bulan
    $('#editJumlah').val(jumlah); // Set jumlah pembayaran
    $('#editStatus').val(status); // Set status
}
</script>
</body>
</html>

