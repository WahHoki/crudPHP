<?php

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'bb231';

$conn = new mysqli($host, $user, $password, $database);

if (mysqli_connect_error()) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
