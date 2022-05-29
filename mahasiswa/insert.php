<?php
include __DIR__ . '/../autoload.php';

use App\Models\Mahasiswa;

$mahasiswa = new Mahasiswa();

if (isset($_POST['submit'])) {
  $mahasiswa->create([
    "nim" => $_POST['nim'],
    "nama" => $_POST['nama'],
    "alamat" => $_POST['alamat'],
    "jurusan" => $_POST['jurusan'],
    "jenis_kelamin" => $_POST['jenis_kelamin'],
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
      <h3>Data Mahasiswa</h3>

      <div>
        <a href="/index.php">Lihat Data Mahasiswa</a>
      </div>
    </div>

    <form method="post" action="">
      <div class="form-floating mb-3">
        <input class="form-control" id="nim" name="nim" type="text" placeholder="NIM" />
        <label for="nim">NIM</label>
      </div>
      <div class="form-floating mb-3">
        <input class="form-control" id="nama" name="nama" type="text" placeholder="Nama" />
        <label for="nama">Nama</label>
      </div>
      <div class="form-floating mb-3">
        <select class="form-select" id="jurusan" name="jurusan" aria-label="Jurusan">
          <option value="Teknik Informatika">Teknik Informatika</option>
          <option value="Teknik Sipil">Teknik Sipil</option>
          <option value="Teknik Elektronika">Teknik Elektronika</option>
        </select>
        <label for="jurusan">Jurusan</label>
      </div>
      <div class="form-floating mb-3">
        <input class="form-control" id="alamat" name="alamat" type="text" placeholder="Alamat" />
        <label for="alamat">Alamat</label>
      </div>
      <div class="mb-3">
        <label class="form-label d-block">Jenis Kelamin</label>
        <div class="form-check form-check-inline">
          <input class="form-check-input" id="lakiLaki" type="radio" name="jenis_kelamin" value="L" />
          <label class="form-check-label" for="lakiLaki">Laki Laki</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" id="perempuan" type="radio" name="jenis_kelamin" value="P" />
          <label class="form-check-label" for="perempuan">Perempuan</label>
        </div>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-lg" name="submit" value="submit">Submit</button>
      </div>
    </form>


  </div>
</body>

</html>