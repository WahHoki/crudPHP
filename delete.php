<?php

include 'db.php';

if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    // Hapus data mahasiswa berdasarkan NIM
    $stmt = $conn->prepare("DELETE FROM mahasiswa WHERE nim = ?");
    $stmt->bind_param("s", $nim);

    if ($stmt->execute()) {
        header('Location: index.php');
    } else {
        echo "Error: " . $conn->error;
    }
}
