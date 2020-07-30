<?php
require_once("usuarios.php");

session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit;
}

$datos = datosUsuarioLogueado($_SESSION['id']);
$usuario = $datos['usuario'];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> Inicio - Yell Ducal </title>
		<link href="../public/css/styles.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1> Project Usuarios Yell Ducal</h1>
				<a href="perfil.php"><i class="fas fa-user-circle"></i>Perfil</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Cerrar Sesión</a>
			</div>
		</nav>
		<div class="content">
			<h2>Bienvenido <?=ucfirst($usuario);?></h2>
			<div class="div-content">
				<a href="listado.php"> 
					<button class="btn btn-dark">
						Listado de usuarios
					</button>
				</a>
				<a href="crearUsuario.php"> 
					<button class="btn btn-success">
						Crear usuario 
					</button>
				</a>
			</div>
		</div>
	</body>
</html>