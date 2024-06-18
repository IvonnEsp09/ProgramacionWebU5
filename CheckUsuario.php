<?php
require_once 'ORM/Database.php';
require_once 'ORM/Orm.php';
session_start(); 

$database = new Database();
$conn = $database->getConnection();

$orm = new Orm(null, 'registro', $conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'usrName', FILTER_SANITIZE_EMAIL);
    $password = $_POST['usrPwd'];

    $usuario = $orm->validarUsuario($email);

    if ($usuario) {
        echo "Usuario encontrado: " . $usuario['Correo'] . "<br>";
        echo "Contraseña almacenada: " . $usuario['Contraseña'] . "<br>";
        echo "Contraseña ingresada (sin hash): " . $password . "<br>";
    } else {
        $_SESSION['error'] = "Usuario no encontrado para el correo: " . $email;
        header('Location: Login.php');
        exit;
    }

    if ($usuario && isset($usuario['Contraseña'])) {
        if (password_verify($password, $usuario['Contraseña'])) {
            $_SESSION['nombre'] = $usuario['Nombre']; 
            $_SESSION['correo'] = $usuario['Correo']; 

            if ($usuario['Rol'] === 'administrador') {
                header('Location: Administrador.php');
                exit;
            } else if ($usuario['Rol'] === 'alumno') {
                header('Location: Alumno.php');
                exit;
            }
        } else {
            echo 'Contraseña incorrecta.'; 
            $_SESSION['error'] = 'Usuario o contraseña incorrectos.';
            header('Location: Login.php');
            exit;
        }
    } else {
        echo 'Contraseña no encontrada en la base de datos.'; 
        $_SESSION['error'] = 'Usuario o contraseña incorrectos.';
        header('Location: Login.php');
        exit;
    }
}
?>
