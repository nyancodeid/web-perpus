<?php
include __DIR__ . '/../autoload.php';

use App\Models\Mahasiswa;
use App\Models\Buku;
use App\Models\Transaksi;

$mahasiswa = new Mahasiswa();
$buku = new Buku();

if (isset($_POST['submit'])) {
  $transaksi = new Transaksi();

  $transaksi->create([
    "mahasiswa_id" => $_POST['mahasiswa_id'],
    "buku_id" => $_POST['buku_id'],
    "tanggal_pinjam" => date_format(date_create($_POST['tanggal_pinjam']), 'Y-m-d'),
    "tanggal_harus_kembali" => date_format(date_create($_POST['tanggal_kembali']), 'Y-m-d'),
    "status" => "pinjam"
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
      <h3>Peminjaman Buku</h3>

      <div>
        <a href="/index.php">Lihat Semua Data</a>
      </div>
    </div>

    <form method="post" action="">
      <div class="form-floating mb-3">
        <select class="form-select" id="mahasiswa" name="mahasiswa_id" aria-label="Mahasiswa">
          <?php foreach ($mahasiswa->all() as $data) : ?>
            <option value="<?= $data['nim'] ?>"><?= $data['nim'] ?> - <?= $data['nama'] ?></option>
          <?php endforeach; ?>
        </select>
        <label for="mahasiswa">Mahasiswa</label>
      </div>
      <div class="form-floating mb-3">
        <select class="form-select" id="buku" name="buku_id" aria-label="Buku">
          <?php foreach ($buku->all() as $data) : ?>
            <option value="<?= $data['isbn'] ?>"><?= $data['judul'] ?></option>
          <?php endforeach; ?>
        </select>
        <label for="buku">Buku</label>
      </div>
      <div class="d-flex mb-3">
        <div class="form-floating me-3 flex-filled">
          <input class="form-control" id="tanggal_pinjam" type="date" name="tanggal_pinjam" placeholder="Tanggal Peminjaman" data-sb-validations="required" value="<?= format_tanggal(date('Y-m-d')) ?>" />
          <label for="tanggal_pinjam">Tanggal Peminjaman</label>
        </div>
        <div class="form-floating flex-filled">
          <input class="form-control" id="tanggal_kembali" type="date" name="tanggal_kembali" placeholder="Tanggal Kembali" data-sb-validations="required" />
          <label for="tanggal_kembali">Tanggal Harus Kembali</label>
        </div>
      </div> 
      <div class="d-grid">
        <button class="btn btn-primary btn-lg" name="submit" value="submit" type="submit">Submit</button>
      </div>
    </form>
  </div>
</body>

</html>