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
    mysqli_query($koneksi, $query);
    header("Location: data_siswa.php");
}

// Handle Hapus Siswa
if (isset($_GET['deleteId'])) {
    $Nis = $_GET['deleteId']; // Ambil Nis dari URL

    // Hapus data siswa berdasarkan Nis
    $query = "DELETE FROM siswa WHERE Nis='$Nis'";
    if (mysqli_query($koneksi, $query)) {
        // Redirect setelah penghapusan
        header("Location: data_siswa.php");
        exit;
    } else {
        // If query fails, show error
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
</head>
<body>
<div class="container mt-4">
    <h1>Data Siswa</h1>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal">Tambah Siswa</button>
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
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['Nis']}</td>";
            echo "<td>{$row['Nama']}</td>";
            echo "<td>{$row['Kelas']}</td>";
            echo "<td>{$row['Alamat']}</td>";
            echo "<td>
                    <button class='btn btn-success btn-sm' data-toggle='modal' data-target='#editModal' 
                           data-nis='{$row['Nis']}' data-nama='{$row['Nama']}' data-kelas='{$row['Kelas']}' data-alamat='{$row['Alamat']}'>
                        Edit
                    </button>
                    <a href='data_siswa.php?deleteId={$row['Nis']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah kamu yakin ingin menghapus data siswa?\");'>Hapus</a>
                  </td>";
            echo "</tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Siswa -->
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
                    <input type="hidden" name="nis" id="editNis">
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
