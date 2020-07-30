<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title> Crear Usuario - Yell Ducal</title>
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
				<a href="perfil.php"><i class="fas fa-user-circle"></i>Perfil</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Cerrar Sesión</a>
			</div>
		</nav>
		<div class="content">
			<h2>Crear usuario</h2>
		</div>
		<div id="mensaje-registrar" class="alert" hidden="hidden"></div>
		<div class="modificar">
			<form action="registrar.php" method="post" autocomplete="off">
				<label for="usuario">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" class="form-input" name="usuario" placeholder="Usuario" id="usuario" minlength="3" maxlength="40" required>
				<p id="error-usuario" class="error-message error-usuario-form" hidden="hidden">
				</p>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" class="form-input" name="password" placeholder="Contraseña" id="password" minlength="6" maxlength="20" required>
				<p id="error-password" class="error-message error-password-form" hidden="hidden"></p>
				<label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="email" class="form-input" name="email" placeholder="Email" id="email">
				<p id="error-email" class="error-message error-email-form" hidden="hidden"></p>
				<input id="registrar" class="button-form" type="button" value="Crear">
			</form>
			<input id="logueado" type="hidden" value="true">
		</div>
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script type="text/javascript" src="../public/js/main.js"></script>
	</body>
</html>