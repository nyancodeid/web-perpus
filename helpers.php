<?php

$config = [
    "db.instance" => null,
    "db.host" => "localhost",  
    "db.database" => "perpustakaan_db",
    "db.user" => "ryanaunur",
    "db.password" => "A6HxLvoCwO5bq!@#"
];

function config ($key, $value = null) {
    global $config;

    if (!is_null($value)) {
        $config[$key] = $value;
        return;
    }  

    return $config[$key] ?? null;
}

function hitung_denda (string $tanggal_harus_kembali, int $denda_per_hari): int {
    $tanggal_harus_kembali = new DateTime($tanggal_harus_kembali);
    $tanggal_sekarang = new DateTime();
    $selisih = $tanggal_harus_kembali->diff($tanggal_sekarang);

    $denda = 0;

    if ($selisih->days > 0 && $selisih->invert == 0) {
        $denda = $selisih->days * $denda_per_hari;
    }

    return $denda;
}

function format_tanggal ($tanggal, $format = 'Y-m-d'): string {
    if (!$tanggal) return '';

    return date_format(date_create($tanggal), $format);
}

function _get($key) {
    return $_GET[$key] ?? false;
}
function _match($key, $match) {
    return (_get($key) == $match);
}

