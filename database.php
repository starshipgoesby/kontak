<?php

class Database
{
    private $host = "localhost"; // Sesuaikan dengan host Anda
    private $username = "root";   // Sesuaikan dengan username MySQL Anda
    private $password = "";       // Sesuaikan dengan password MySQL Anda
    private $database = "kontak_db"; // Sesuaikan dengan nama database yang telah Anda buat
    public $conn;

    // Fungsi untuk membuat koneksi
    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Cek koneksi
        if ($this->conn->connect_error) {
            die("Koneksi Gagal: " . $this->conn->connect_error);
        }
    }

    // Fungsi untuk menutup koneksi
    public function closeConnection()
    {
        $this->conn->close();
    }
}

?>
