<?php
include __DIR__ . '/../autoload.php';

use App\Models\Mahasiswa;
use App\Models\Buku;
use App\Models\Transaksi;

$buku = new Buku();
$mahasiswa = new Mahasiswa();
$transaksi = new Transaksi();

$tx = $transaksi->where('id', $_GET['id'])->first();

if (isset($_POST['submit']) && ($tx['id'] == $_GET['id'])) {
  $status = $_POST['status'];

  if (!empty($_POST['tanggal_kembali']) && $status != 'kembali') {
    $status = 'kembali';
  } 

  $transaksi->where("id", $_GET['id'])->update([
    "mahasiswa_id" => $_POST['mahasiswa_id'],
    "buku_id" => $_POST['buku_id'],
    "status" => $status,
    "denda" => $_POST['denda'],
    "tanggal_pinjam" => format_tanggal($_POST['tanggal_pinjam']),
    "tanggal_kembali" => format_tanggal($_POST['tanggal_kembali']),
    "tanggal_harus_kembali" => format_tanggal($_POST['tanggal_harus_kembali']),
  ]);

  header('Location: /index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Program CRUD Perpustakaan - Ryan Aunur Rassyid</title>

  <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
</head>

<body>
  <!-- Navbar -->
  <?php include __DIR__ . "/../components/navbar.php"; ?>
  
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
      <h3>Ubah Data Peminjaman</h3>

      <div>
        <a href="/index.php">Lihat Data Semua</a>
      </div>
    </div>

    <form method="post" action="">
      <div class="form-floating mb-3">
        <input class="form-control" disabled id="id" name="id" type="text" placeholder="ID" value="<?= $tx['id'] ?>" />
        <label for="id">ID</label>
      </div>
      <div class="d-flex mb-3">
        <div class="form-floating flex-filled">
          <select class="form-select" id="mahasiswa" name="mahasiswa_id" aria-label="Mahasiswa">
            <?php foreach ($mahasiswa->all() as $data) : ?>
              <option value="<?= $data['nim'] ?>"><?= $data['nim'] ?> - <?= $data['nama'] ?></option>
            <?php endforeach; ?>
          </select>
          <label for="mahasiswa">Mahasiswa</label>
        </div>
        <div class="form-floating ms-3 flex-filled">
          <select class="form-select" id="buku" name="buku_id" aria-label="Buku">
            <?php foreach ($buku->all() as $data) : ?>
              <option value="<?= $data['isbn'] ?>"><?= $data['judul'] ?></option>
            <?php endforeach; ?>
          </select>
          <label for="buku">Buku</label>
        </div>
      </div>
      
      <div class="form-floating mb-3">
        <select class="form-select" id="status" name="status" aria-label="Status">
          <option value="pinjam" <?= ($tx['status'] == 'pinjam') ? 'selected' : '' ?>>Pinjam</option>
          <option value="kembali" <?= ($tx['status'] == 'kembali') ? 'selected' : '' ?>>Kembali</option>
        </select>
        <label for="status">Status</label>
      </div>
      <div class="form-floating mb-3">
        <input class="form-control" id="denda" name="denda" type="number" placeholder="Denda" value="<?= $tx['denda'] ?>" />
        <label for="denda">Denda</label>
      </div>
      <div class="d-flex mb-3">
        <div class="form-floating flex-filled me-3">
          <input class="form-control" id="tanggal_pinjam" type="date" name="tanggal_pinjam" placeholder="Tanggal Peminjaman" value="<?= format_tanggal($tx['tanggal_pinjam']) ?>" />
          <label for="tanggal_pinjam">Tanggal Peminjaman</label>
        </div>
        <div class="form-floating flex-filled me-3">
          <input class="form-control" id="tanggal_kembali" type="date" name="tanggal_kembali" placeholder="Tanggal Kembali" value="<?= format_tanggal($tx['tanggal_kembali']) ?? '' ?>" />
          <label for="tanggal_kembali">Tanggal Kembali</label>
        </div>
        <div class="form-floating flex-filled">
          <input class="form-control" id="tanggal_harus_kembali" type="date" name="tanggal_harus_kembali" placeholder="Tanggal Harus Kembali" value="<?= format_tanggal($tx['tanggal_harus_kembali']) ?>" />
          <label for="tanggal_harus_kembali">Tanggal Harus Kembali</label>
        </div>
      </div>
      <div class="d-grid">
        <button class="btn btn-primary btn-lg" name="submit" value="submit" type="submit">Submit</button>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('tanggal_kembali').onchange = function() {
        const harus_kembali = document.getElementById('tanggal_harus_kembali').valueAsDate;
        const kembali = this.valueAsDate;

        if (kembali > harus_kembali && (kembali - harus_kembali) > 0) {
          const HARI = (1000*60*60*24);
          const selisih = (kembali - harus_kembali) / HARI;

          document.getElementById('denda').value = selisih * 1000;
        } else {
          document.getElementById('denda').value = 0;
        }
      }
    });
  </script>
</body>

</html>