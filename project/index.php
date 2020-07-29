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
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="public/css/styles.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="mensaje-login" class="alert" hidden="hidden"></div>
		<div class="login">
			<h1>Iniciar Sesión</h1>
			<form action="application/autenticar.php" method="post">
				<label for="usuario">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" class="form-input" name="usuario" placeholder="Usuario o Correo" id="usuario-login" minlength="3" maxlength="40" required>
				<p id="error-usuario-login" class="error-message error-usuario" hidden="hidden">
				</p>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" class="form-input" name="password" placeholder="Contraseña" id="password-login" minlength="6" maxlength="20" required>
				<p id="error-password-login" class="error-message error-password" hidden="hidden"></p>
				<input id="ingresar" class="button-form" type="button" value="Ingresar">
			</form>
			<p class="text-center"> o </p> 
			<p class="text-center padding-bottom"> 
				<a class="option" href="registro.php"> Registrarse </a>
			</p>
		</div>
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script type="text/javascript" src="public/js/main.js"></script>
	</body>
</html>