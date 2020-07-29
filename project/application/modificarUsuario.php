<?php
require_once("usuarios.php");

session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit;
}

$idUsuario = $_GET['id'];
$result = datosUsuarioModificar($idUsuario);
$usuario = $result['usuario'];
$email = $result['email'];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Página de Inicio</title>
		<link href="../public/css/styles.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<script src="https://kit.fontawesome.com/83a0b726f7.js" crossorigin="anonymous"></script>
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<a href="inicio.php"><i class="fas fa-house-user"></i> Inicio </a>
				<a href="listado.php"><i class="fas fa-list-ul"></i> Listado </a>
				<a href="perfil.php"><i class="fas fa-user-circle"></i>Perfil</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Cerrar Sesión</a>
			</div>
		</nav>
		<div class="content">
			<h2>Modificar usuario</h2>
		</div>
		<div id="mensaje-modificar" class="alert" hidden="hidden"></div>
		<div class="modificar">
			<form action="modificar.php" method="post" autocomplete="off">
				<label for="usuario">
					<i class="fas fa-user"></i>
				</label>
				<input type="hidden" id="idUsuario" name="idUsuario" value="<?=$idUsuario;?>">
				<input type="text" class="form-input" name="usuario" placeholder="Usuario" id="usuario" minlength="3" maxlength="40" value="<?=$usuario;?>">
				<p id="error-usuario" class="error-message error-usuario-form" hidden="hidden">
				</p>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" class="form-input" name="password" placeholder="Contraseña" id="password" minlength="6" maxlength="20">
				<p id="error-password" class="error-message error-password-form" hidden="hidden"></p>
				<label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="email" class="form-input" name="email" placeholder="Email" id="email" value="<?=$email;?>">
				<p id="error-email" class="error-message error-email-form" hidden="hidden"></p>
				<input id="modificar" class="button-form" type="button" value="Modificar">
			</form>
		</div>
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script type="text/javascript" src="../public/js/main.js"></script>
	</body>
</html>