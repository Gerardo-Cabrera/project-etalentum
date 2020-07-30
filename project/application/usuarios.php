<?php
require_once("conf/database_connection.php");

$connection = new DatabaseConnection();

if (isset($_POST['data']['funcion']) && isset($_POST['data']['datos'])) {
	$funcion = $_POST['data']['funcion'];
	$data = $_POST['data']['datos'];

	if ($funcion == "eliminarUsuario") {
		$data = $_POST['data']['datos']['id'];
	}

	$datos = consulta();
	echo json_encode($datos);
}

function consulta() {
	$consulta = $GLOBALS['connection'];
	$funcion = $GLOBALS['funcion'];
	$data = $GLOBALS['data'];
	$result = $consulta->$funcion($data);
	return $result;
}

function datosUsuarioLogueado($usuario) {
	$consulta = $GLOBALS['connection'];
	$result = $consulta->datosUsuarioLogueado($usuario);
	return $result;
}

function datosUsuarioModificar($idUsuario) {
	$consulta = $GLOBALS['connection'];
	$result = $consulta->datosUsuarioModificar($idUsuario);
	return $result;
}

function listadoUsuarios() {
	$consulta = $GLOBALS['connection'];
	$result = $consulta->listadoUsuarios();
	return $result;
}

function paginado() {
	$consulta = $GLOBALS['connection'];
	$result = $consulta->paginado();
	return $result;
}
?>