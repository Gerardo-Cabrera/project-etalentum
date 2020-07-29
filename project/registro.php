<?php
session_start();

if (isset($_SESSION['loggedin'])) {
	header('Location: application/inicio.php');
	exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Registro de Usuario</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="public/css/styles.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="mensaje-registrar" class="alert" hidden="hidden"></div>
		<div class="registrar">
			<h1>Registrar Usuario</h1>
			<form action="application/registrar.php" method="post" autocomplete="off">
				<label for="usuario">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" class="form-input" name="usuario" placeholder="Usuario" id="usuario" minlength="3" maxlength="40" required>
				<p id="error-usuario" class="error-message error-usuario" hidden="hidden">
				</p>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" class="form-input" name="password" placeholder="Contraseña" id="password" minlength="6" maxlength="20" required>
				<p id="error-password" class="error-message error-password" hidden="hidden">
				</p>
				<label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="text" class="form-input" name="email" placeholder="Email" id="email" required>
				<p id="error-email" class="error-message error-email" hidden="hidden"></p>
				<input id="registrar" class="button-form" type="button" value="Registrar">
			</form>
			<input id="logueado" type="hidden" value="false">
			<p class="text-center"> o </p> 
			<p class="text-center padding-bottom"> 
				<a class="option" href="index.php"> Iniciar Sesión </a>
			</p>
		</div>
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script type="text/javascript" src="public/js/main.js"></script>
	</body>
</html>