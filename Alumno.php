<?php
session_start();
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Invitado';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumno</title>
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
        <h1 class="mt-3 texto-uno">¡Alumnos, los invitamos a inscribirse y disfrutar de nuestras actividades extraescolares!</h1>
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
        <a href="activiades.php" class="btn btn-success">Actividades</a> 
        <ul class="nav">
            <li class="nav-item dropdown ml-auto">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Bienvenid@: <?php echo htmlspecialchars($nombreUsuario); ?>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="perfil.php">Perfil de Usuario</a></li>
                    <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <h1 class="texto-uno">Esta es la vista ALUMNO</h1>

    <footer class="text-white text-center footer-est py-3 mt-5 ">
        <br>Integrantes:<br>
        Gómez Flores Alberto Alejandro <br>
        Gonzalez Nabor Melanie <br>       
        López Espino Arlette Ivonne <br>
        Marin Rodriguez Citlalli <br>      
        Vargas Garcia Erick Sebastian<br><br>
    </footer>
</div>
</body>

</html>
