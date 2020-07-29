<?php
require_once("conf/database_connection.php");

$connection = new DatabaseConnection();
$pass = (!empty($_POST['data']['password']) ? $_POST['data']['password'] : "");
$data = array(
	'idUsuario' => $_POST['data']['idUsuario'],
	'usuario' => $_POST['data']['usuario'],
	'password' => $pass,
	'email' => $_POST['data']['email']
);

$result = $connection->modificarUsuario($data);
echo json_encode($result);
?>