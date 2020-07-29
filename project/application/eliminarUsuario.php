<?php
require_once("conf/database_connection.php");
		
$connection = new DatabaseConnection();
$id = $_POST['id'];
$result = $connection->eliminarUsuario($id);
echo json_encode($result);
?>