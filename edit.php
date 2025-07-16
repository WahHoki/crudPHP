<?php
include 'db.php';

// Ambil data mahasiswa berdasarkan NIM
if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    $stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE nim = ?");
    $stmt->bind_param("s", $nim);
    $stmt->execute();

    $result = $stmt->get_result();
    $mahasiswa = $result->fetch_assoc();
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $kode_jurusan = $_POST['kode_jurusan'];
    $gender = $_POST['gender'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];

    $sql = "UPDATE mahasiswa 
            SET nama='$nama', kode_jurusan='$kode_jurusan', gender='$gender', alamat='$alamat', no_hp='$no_hp', email='$email' 
            WHERE nim='$nim'";

    if (mysqli_query($conn, $sql)) {
        header('Location: index.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa</title>
</head>
<body>
    <h1>Edit Mahasiswa</h1>
    <form action="" method="POST">
        <label>NIM:</label><br>
        <input type="text" name="nim" value="<?= $mahasiswa['nim']; ?>" readonly><br>
        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?= $mahasiswa['nama']; ?>" required><br>
        <label>Jurusan:</label><br>
        <select name="kode_jurusan">
            <?php
            $jurusan = mysqli_query($conn, "SELECT * FROM jurusan");
while ($j = mysqli_fetch_assoc($jurusan)) {
    $selected = $j['kode_jurusan'] == $mahasiswa['kode_jurusan'] ? 'selected' : '';
    echo "<option value='{$j['kode_jurusan']}' $selected>{$j['nama_jurusan']}</option>";
}
?>
        </select><br>
        <label>Gender:</label><br>
        <input type="radio" name="gender" value="L" <?= $mahasiswa['gender'] == 'L' ? 'checked' : ''; ?>> Laki-laki
        <input type="radio" name="gender" value="P" <?= $mahasiswa['gender'] == 'P' ? 'checked' : ''; ?>> Perempuan<br>
        <label>Alamat:</label><br>
        <textarea name="alamat"><?= $mahasiswa['alamat']; ?></textarea><br>
        <label>No HP:</label><br>
        <input type="text" name="no_hp" value="<?= $mahasiswa['no_hp']; ?>"><br>
        <label>Email:</label><br>
        <input type="email" name="email" value="<?= $mahasiswa['email']; ?>"><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
