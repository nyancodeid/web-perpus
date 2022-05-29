<?php
include __DIR__ . '/autoload.php';

use App\Models\Mahasiswa;
use App\Models\Buku;
use App\Models\Transaksi;

$mahasiswa = new Mahasiswa();
$buku = new Buku();
$transaksi = new Transaksi();

if (_match('action', 'delete')) {
  // Menghapus Data
  $nama_tabel = $_GET['table'];

  if ($nama_tabel == 'mahasiswa') {
    $mahasiswa->where('nim', $_GET['id'])->delete();
  } else if ($nama_tabel == 'buku') {
    $buku->where('isbn', $_GET['id'])->delete();
  } else if ($nama_tabel == 'transaksi') {
    $transaksi->where('id', $_GET['id'])->delete();
  }
  
  header('Location: /index.php');
} else if (_match('action', 'pengembalian-buku')) {
  // Pengembalian Buku
  $tanggal_harus_kembali = $_GET['date'];
  $denda = hitung_denda($tanggal_harus_kembali, 1000);

  $transaksi->where('id', $_GET['id'])->update([
    'status' => 'kembali',
    'denda' => $denda,
    'tanggal_kembali' => date('Y-m-d')
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

  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
  <!-- Navbar -->
  <?php include __DIR__ . "/components/navbar.php"; ?>

  <div class="container mt-4">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-mahasiswa-tab" data-bs-toggle="tab" data-bs-target="#nav-mahasiswa" type="button" role="tab" aria-controls="nav-mahasiswa" aria-selected="true">Data Mahasiswa</button>
        <button class="nav-link" id="nav-buku-tab" data-bs-toggle="tab" data-bs-target="#nav-buku" type="button" role="tab" aria-controls="nav-buku" aria-selected="false">Data Buku</button>
        <button class="nav-link" id="nav-transaksi-tab" data-bs-toggle="tab" data-bs-target="#nav-transaksi" type="button" role="tab" aria-controls="nav-transaksi" aria-selected="false">Transaksi</button>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-mahasiswa" role="tabpanel" aria-labelledby="nav-mahasiswa-tab">
        <section id="s_mahasiswa">
          <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 mb-3">Data Mahasiswa</h3>

            <div>
              <a href="/mahasiswa/insert.php">Tambah Mahasiswa</a>
            </div>
          </div>
          
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Jurusan</th>
                <th>JK</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($mahasiswa->all() as $item) { ?>
              <tr>
                <td>
                  <a class="btn-modal--toggler cursor-pointer" role="button" data-bs-toggle="modal" data-bs-target="#v-modal" data-from="mahasiswa" data-source="<?= base64_encode(json_encode($item)) ?>"><?= $item['nim'] ?></a>
                </td>
                <td><?= $item['nama'] ?></td>
                <td><?= $item['alamat'] ?></td>
                <td><?= $item['jurusan'] ?></td>
                <td><?= $item['jenis_kelamin'] ?></td>
                <td>
                  <a href="/mahasiswa/update.php?id=<?= $item['nim'] ?>">Edit</a>
                  <a href="/index.php?action=delete&table=mahasiswa&id=<?= $item['nim'] ?>">Hapus</a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </section>
      </div>
      <div class="tab-pane fade" id="nav-buku" role="tabpanel" aria-labelledby="nav-buku-tab">
        <section id="s_buku">
          <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 mb-3">Data Buku</h3>

            <div>
              <a href="/buku/insert.php">Tambah Buku</a>
            </div>
          </div>
          
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ISBN</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Stok</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($buku->all() as $item) { ?>
              <tr>
                <td>
                  <a class="btn-modal--toggler cursor-pointer" role="button" data-bs-toggle="modal" data-bs-target="#v-modal" data-from="buku" data-source="<?= base64_encode(json_encode($item)) ?>"><?= $item['isbn'] ?></a>  
                </td>
                <td><?= $item['judul'] ?></td>
                <td><?= $item['pengarang'] ?></td>
                <td><?= $item['penerbit'] ?></td>
                <td><?= $item['tahun'] ?></td>
                <td><?= $item['stok'] ?></td>
                <td>
                  <a href="/buku/update.php?id=<?= $item['isbn'] ?>">Edit</a>
                  <a href="/index.php?action=delete&table=buku&id=<?= $item['isbn'] ?>">Hapus</a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </section>
      </div>
      <div class="tab-pane fade" id="nav-transaksi" role="tabpanel" aria-labelledby="nav-transaksi-tab">
        <section id="s_transaksi">
          <div class="d-flex justify-content-between align-items-center">
            <h3 class="mt-3 mb-3">Data Transaksi</h3>

            <div>
              <a href="/transaksi/pinjam.php">Pinjam Buku</a>
            </div>
          </div>
          
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>NIM Mahasiswa</th>
                <th>ISBN Buku</th>
                <th>Status</th>
                <th>Denda</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Hrs Kembali</th>
                <th>Tgl Kembali</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($transaksi->all() as $item) { ?>
              <tr>
                <td>
                  <a class="btn-modal--toggler cursor-pointer" role="button" data-bs-toggle="modal" data-bs-target="#v-modal" data-from="transaksi" data-source="<?= base64_encode(json_encode($item)) ?>"><?= $item['id'] ?></a>
                </td>
                <td><?= $item['mahasiswa_id'] ?></td>
                <td><?= $item['buku_id'] ?></td>
                <td><?= strtoupper($item['status']) ?></td>
                <td><?= $item['denda'] ?></td>
                <td><?= format_tanggal($item['tanggal_pinjam'], 'd-m-Y') ?></td>
                <td><?= format_tanggal($item['tanggal_harus_kembali'], 'd-m-Y') ?></td>
                <td><?= format_tanggal($item['tanggal_kembali'], 'd-m-Y') ?? "-" ?></td>
                <td>
                  
                  <a href="/index.php?action=pengembalian-buku&date=<?= $item['tanggal_harus_kembali'] ?>&id=<?= $item['id'] ?>">Kembali</a>
                  <a href="/transaksi/update.php?id=<?= $item['id'] ?>">Edit</a>
                  <a href="/index.php?action=delete&table=transaksi&id=<?= $item['id'] ?>">Hapus</a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </section>
      </div>
    </div>
  </div>

  <div class="modal fade" id="v-modal" tabindex="-1" aria-labelledby="modal-views" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-views">Detail</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered table-striped">
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
    const modal = document.getElementById('v-modal');
    const columns = {
      mahasiswa: ['NIM', 'Nama', 'Jurusan', 'Jenis Kelamin', 'Alamat'],
      buku: ['ISBN', 'Judul', 'Pengarang', 'Penerbit', 'Tahun', 'Stok'],
      transaksi: ['ID', 'NIM Mahasiswa', 'ISBN Buku', 'Denda', 'Tgl Pinjam', 'Tgl Kembali', 'Tgl Harus Kembali', 'Status']
    }

    document.querySelectorAll('.btn-modal--toggler').forEach(function (element) {
      element.addEventListener('click', function(event) {
        const source = event.target;
        const data_source = source.getAttribute('data-source');
        const from = source.getAttribute('data-from');

        const data = JSON.parse(atob(data_source));
        const table_body = document.querySelector('#v-modal tbody');
        const table_title = document.querySelector('#v-modal .modal-title');

        let pre_rendered_body = '';

        let i = 0;
        for (const column of Object.keys(data)) {
          let column_name = columns[from][i];
          let column_value = data[column] || '-';

          pre_rendered_body += `
            <tr>
              <td>${column_name}</td>
              <td>${column_value}</td>
            </tr>
          `;

          i++;
        }
      
        table_body.innerHTML = pre_rendered_body;
      })
    });
  </script>
</body>
</html>