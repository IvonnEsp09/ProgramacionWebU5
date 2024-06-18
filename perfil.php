<?php
session_start();
include('conexion.php'); // Asegúrate de tener un archivo de conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['nombre'])) {
    header('Location: Login.php');
    exit();
}

$nombreUsuario = $_SESSION['nombre'];

// Obtener los datos del usuario de la base de datos
$query = "SELECT * FROM registro WHERE Nombre = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $nombreUsuario);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

// Si el formulario se envía, procesar la actualización de los datos del usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usrName = $_POST['usrName'];
    $usrAp = $_POST['usrAp'];
    $usrAm = $_POST['usrAm'];
    $usrEmail = $_POST['usrEmail'];
    $cambiarPwd = isset($_POST['cambiarPwd']) && $_POST['cambiarPwd'] === 'yes';
    $usrPwd = $_POST['usrPwd'];
    $usrPwdConfirm = $_POST['usrPwdConfirm'];

    // Validar y actualizar los datos del usuario
    if ($cambiarPwd && $usrPwd !== $usrPwdConfirm) {
        $error = "Las contraseñas no coinciden.";
    } else {
        if ($cambiarPwd) {
            // Encriptar la nueva contraseña
            $hashedPwd = password_hash($usrPwd, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE registro SET Nombre = ?, ApellidoP = ?, ApellidoM = ?, Correo = ?, Contraseña = ? WHERE Nombre = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param('ssssss', $usrName, $usrAp, $usrAm, $usrEmail, $hashedPwd, $nombreUsuario);
        } else {
            $updateQuery = "UPDATE registro SET Nombre = ?, ApellidoP = ?, ApellidoM = ?, Correo = ? WHERE Nombre = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param('sssss', $usrName, $usrAp, $usrAm, $usrEmail, $nombreUsuario);
        }

        if ($updateStmt->execute()) {
            $_SESSION['nombre'] = $usrName;
            $success = "Los datos se actualizaron correctamente.";
        } else {
            $error = "Error al actualizar los datos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="Css/EstilosBanner.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/udm/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<div class="container-fluid">
    <div class="jumbotron bg-image text-center py-5 mb-4" style="background-image: url('fotos/Atletismo.jpg');">
        <h1 class="mt-3 texto-uno">¡Alumnos, actualicen sus datos de perfil!</h1>
        <h2 class="mt-3 texto-dos">TODO ES UN BALANCE</h2>
    </div>
    <nav class="navbar navbar-dark custom-forlog">
    <ul class="nav mr-auto">
        <li class="nav-item">
            <img src="fotos/Logo.jpg" alt="mi logo" width="50px" height="50px">
        </li>
        <li class="nav-item">
            <h1 class="text-white">Actividades Extraescolares</h1>
        </li>
    </ul>
    <ul class="nav">
        <li class="nav-item ml-auto">
        <a href="logout.php">
            <h3 class="opc-menulog">Cerrar Sesión</h3>
        </a>
        </li>
    </ul>
</nav>

</div>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card custom-for mb-5">
                    <div class="card-header text-center text-white custom-forlog">
                        <h3>Perfil de Usuario</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success text-center"><?php echo $success; ?></div>
                        <?php endif; ?>
                        <form action="perfil.php" method="post">
                            <div class="form-group ">
                                <label><i class="bi bi-person-fill"></i> Nombre</label>
                                <input type="text" name="usrName" class="form-control" value="<?php echo htmlspecialchars($userData['Nombre']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label><i class="bi bi-person"></i> Apellido Paterno</label>
                                <input type="text" name="usrAp" class="form-control" value="<?php echo htmlspecialchars($userData['ApellidoP']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label><i class="bi bi-person-check"></i> Apellido Materno</label>
                                <input type="text" name="usrAm" class="form-control" value="<?php echo htmlspecialchars($userData['ApellidoM']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label><i class="bi bi-person-circle"></i> Correo</label>
                                <input type="email" name="usrEmail" class="form-control" value="<?php echo htmlspecialchars($userData['Correo']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>¿Desea cambiar su contraseña?</label>
                                <select name="cambiarPwd" class="form-control">
                                    <option value="no">No</option>
                                    <option value="yes">Sí</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nueva Contraseña</label>
                                <input type="password" name="usrPwd" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Confirmar Nueva Contraseña</label>
                                <input type="password" name="usrPwdConfirm" class="form-control">
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Actualizar Datos</button>
                                <a href="Alumno.php" class="btn btn-secondary">Volver</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-white text-center footer-est py-3 mt-5 ">
        <br>Integrantes:<br>
        Gómez Flores Alberto Alejandro <br>
        Gonzalez Nabor Melanie <br>       
        López Espino Arlette Ivonne <br>
        Marin Rodriguez Citlalli <br>      
        Vargas Garcia Erick Sebastian<br><br>
    </footer>
</body>

</html>
