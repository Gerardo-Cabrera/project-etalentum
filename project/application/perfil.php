<?php
require_once("usuarios.php");

session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit;
}

$datos = datosUsuarioLogueado($_SESSION['id']);
$idUsuario = $_SESSION['id'];
$usuario = $datos['usuario'];
$email = $datos['email'];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> Perfil de Usuario - Yell Ducal </title>
		<link href="../public/css/styles.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<script src="https://kit.fontawesome.com/83a0b726f7.js" crossorigin="anonymous"></script>
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1> Project Usuarios Yell Ducal </h1>
				<a href="inicio.php"><i class="fas fa-house-user"></i> Inicio </a>
				<a href="listado.php"><i class="fas fa-list-ul"></i> Listado </a>
				<a href="crearUsuario.php"><i class="fas fa-user"></i> Crear Usuario</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Cerrar Sesión</a>
			</div>
		</nav>
		<div class="content">
			<h2> Mi Perfil </h2>
			<div id="mensaje-modificar" class="alert" hidden="hidden"></div>
			<div class="modificar modificar-perfil">
				<form>
					<input type="hidden" id="idUsuario" name="idUsuario" class="form-input input-perfil" value="<?=$idUsuario;?>" readonly>
					<div>
						<label for="usuario" class="perfil-usuario">
							<i class="fas fa-user"></i>
						</label>
						<input type="text" id="usuario" name="usuario" class="form-input input-perfil" value="<?=$usuario;?>" readonly>
						<p id="error-usuario" class="error-message error-usuario-perfil" hidden="hidden">
						</p>
					</div>
					<div id="div-password" hidden="hidden">
						<label for="password" class="perfil-usuario">
							<i class="fas fa-lock"></i>
						</label>
						<input type="password" id="password" name="password" class="form-input input-perfil" value="" readonly>
						<p id="error-password" class="error-message error-password-perfil" hidden="hidden"></p>
					</div>
					<div>
						<label for="email" class="perfil-usuario">
							<i class="fas fa-envelope"></i>
						</label>
						<input type="text" id="email" name="email" class="form-input input-perfil" value="<?=$email;?>" readonly>
						<p id="error-email" class="error-message error-email-perfil" hidden="hidden"></p>
					</div>
					<div class="div-buttons">
						<input type="button" id="cancelar-perfil" class="btn btn-danger" name="cancelar-perfil" value="Cancelar">
						<input type="button" id="modificar-perfil" class="btn btn-dark" name="modificar-perfil" value="Modificar">
						<input type="button" id="guardar-perfil" class="btn btn-success" name="guardar-perfil" value="Guardar">
					</div>
				</form>
			</div>
		</div>
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script type="text/javascript" src="../public/js/main.js"></script>
	</body>
</html>