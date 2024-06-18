<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "extraescolaresbd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>


<?php

class DB {
    private $host = 'localhost';
    private $db_name = 'extraescolaresbd';
    private $username = 'root';
    private $password = '';
    private $conn;

    // Método de conexión a la base de datos
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Error de conexión: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
?>