<?php

class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbName = "bb231";
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->dbName);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function query($sql) {
        return $this->connection->query($sql);
    }

    public function close() {
        $this->connection->close();
    }
}

class Mahasiswa {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getAllMahasiswa() {
        $sql = "SELECT m.nim, m.nama, j.nama_jurusan, m.gender, m.alamat, m.no_hp, m.email 
                FROM mahasiswa m 
                LEFT JOIN jurusan j ON m.kode_jurusan = j.kode_jurusan";
        $result = $this->db->query($sql);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }
}

// Inisialisasi
$db = new Database();
$mahasiswa = new Mahasiswa($db);
$dataMahasiswa = $mahasiswa->getAllMahasiswa();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Daftar Mahasiswa</h1>
    <a href="tambah.php">Tambah Mahasiswa</a>
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>Gender</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['nim']; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['nama_jurusan']; ?></td>
            <td><?= $row['gender']; ?></td>
            <td><?= $row['alamat']; ?></td>
            <td><?= $row['no_hp']; ?></td>
            <td><?= $row['email']; ?></td>
            <td>
            <a href="edit.php?nim=<?= $row['nim']; ?>">Edit</a>
<a href="delete.php?nim=<?= $row['nim']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>

            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
