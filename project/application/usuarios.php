<?php
require_once("conf/database_connection.php");

$connection = new DatabaseConnection();

function datosUsuarioLogueado($usuario) {
	$datos = $GLOBALS['connection']->datosUsuarioLogueado($usuario);
	return $datos;
}

function datosUsuarioModificar($idUsuario) {
	$result = $GLOBALS['connection']->datosUsuarioModificar($idUsuario);
	return $result;
}

function listadoUsuarios() {
	$result = $GLOBALS['connection']->listadoUsuarios();
	return $result;
}

function paginado() {
	$result = $GLOBALS['connection']->paginado();
	return $result;
}
?>