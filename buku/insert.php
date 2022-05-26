<?php
include __DIR__ . '/../autoload.php';

$buku = new Buku($db);

if (isset($_POST['submit'])) {
  $buku->create([
    "isbn" => $_POST['isbn'],
    "judul" => $_POST['judul'],
    "pengarang" => $_POST['pengarang'],
    "penerbit" => $_POST['penerbit'],
    "tahun" => $_POST['tahun'],
    "stok" => $_POST['stok'],
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
      <h3>Data Buku</h3>

      <div>
        <a href="/index.php">Lihat Data Buku</a>
      </div>
    </div>

    <form method="post" action="">
      <div class="form-floating mb-3">
        <input class="form-control" id="isbn" name="isbn" type="text" placeholder="ISBN" />
        <label for="isbn">ISBN</label>
      </div>
      <div class="form-floating mb-3">
        <input class="form-control" id="judul" name="judul" type="text" placeholder="Judul" />
        <label for="judul">Judul</label>
      </div>
      <div class="form-floating mb-3">
        <input class="form-control" id="pengarang" name="pengarang" type="text" placeholder="Pengarang" />
        <label for="pengarang">Pengarang</label>
      </div>
      <div class="form-floating mb-3">
        <input class="form-control" id="penerbit" name="penerbit" type="text" placeholder="Penerbit" />
        <label for="penerbit">Penerbit</label>
      </div>
      <div class="form-floating mb-3">
        <input class="form-control" id="tahun" name="tahun" type="number" placeholder="Tahun" />
        <label for="tahun">Tahun</label>
      </div>
      <div class="form-floating mb-3">
        <input class="form-control" id="stok" name="stok" type="number" placeholder="Stok" />
        <label for="stok">Stok</label>
      </div>
      <div class="d-grid">
        <button class="btn btn-primary btn-lg" name="submit" value="submit" type="submit">Submit</button>
      </div>
    </form>
  </div>
</body>

</html>