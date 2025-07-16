<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbName = "your_database_name";
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

    public function escape($value) {
        return $this->connection->real_escape_string($value);
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

    public function tambahMahasiswa($nim, $nama, $jurusan, $gender, $alamat, $no_hp, $email) {
        $nim = $this->db->escape($nim);
        $nama = $this->db->escape($nama);
        $jurusan = $this->db->escape($jurusan);
        $gender = $this->db->escape($gender);
        $alamat = $this->db->escape($alamat);
        $no_hp = $this->db->escape($no_hp);
        $email = $this->db->escape($email);

        $sql = "INSERT INTO mahasiswa (nim, nama, kode_jurusan, gender, alamat, no_hp, email) 
                VALUES ('$nim', '$nama', '$jurusan', '$gender', '$alamat', '$no_hp', '$email')";

        return $this->db->query($sql);
    }
}

// Proses penambahan data
$db = new Database();
$mahasiswa = new Mahasiswa($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $gender = $_POST['gender'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];

    if ($mahasiswa->tambahMahasiswa($nim, $nama, $jurusan, $gender, $alamat, $no_hp, $email)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menambah data.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
</head>
<body>
    <h1>Tambah Mahasiswa</h1>
    <form method="POST" action="">
        <label for="nim">NIM:</label><br>
        <input type="text" id="nim" name="nim" required><br>
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" required><br>
        <label for="jurusan">Kode Jurusan:</label><br>
        <input type="text" id="jurusan" name="jurusan" required><br>
        <label for="gender">Gender:</label><br>
        <select id="gender" name="gender" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select><br>
        <label for="alamat">Alamat:</label><br>
        <textarea id="alamat" name="alamat" required></textarea><br>
        <label for="no_hp">No HP:</label><br>
        <input type="text" id="no_hp" name="no_hp" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <button type="submit">Tambah</button>
    </form>
</body>
</html>
