<?php

$db = new DB([
    "host" => "localhost",
    "user" => "ryanaunur",
    "password" => "A6HxLvoCwO5bq!@#",
    "database" => "perpustakaan_db"
]);

class Mahasiswa extends Model {
    protected $table = "mahasiswa";
}
class Buku extends Model {
    protected $table = "buku";
}
class Transaksi extends Model {
    protected $table = "transaksi";
}

