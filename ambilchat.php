<?php
$con = new PDO("mysql:dbname=json;host=localhost", "root", "");

if (isset($_GET['nama'])) {
    @$nama = $_GET['nama'];
}

if (isset($_GET['pesan'])) {
    $pesan = $_GET['pesan'];
}

$waktu = date("H:i");

if (isset($_GET['akhir'])) {
    @$akhir = $_GET['akhir'];
}

$json = '{"messages": {';
if (@$akhir == 0) {
    $nomor = $con->query("select nomor from drzchat order by nomor desc limit 1");
    $nomor->execute();
    $n = $nomor->fetch(PDO::FETCH_ASSOC);
    $no = $n['nomor'] + 1;

    $json .= '"pesan":[ {';
    $json .= '"id":"' . $no . '",
        "nama": "Admin",
        "teks": "Selamat datang di chatting room",
        "waktu": "' . $waktu . '"
        }]';

    $masuk = $con->query("insert into drzchat values(null, 'Admin', '$nama bergabung dalam chat', '$waktu')");
} else {
    if (isset($pesan)) {
        $masuk = $con->query("insert into drzchat values(null, '$nama','$pesan','$waktu')");
    }

    $query = $con->query("select * from drzchat where nomor > $akhir");
    $json .= '"pesan":[ ';
    foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $x) {
        $json .= '{';
        $json .= '"id": "' . $x['nomor'] . '",
            "nama": "' . htmlspecialchars($x['nama']) . '",
            "teks": "' . htmlspecialchars($x['pesan']) . '",
            "waktu": "' . $x['waktu'] . '"
            },';
    }
    $json = substr($json, 0, strlen($json) - 1);
    $json .= ']';
}

$json .= '}}';
echo $json;
