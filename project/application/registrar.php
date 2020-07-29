<?php
require_once("conf/database_connection.php");

$connection = new DatabaseConnection();
$result = $connection->registrarUsuario($_POST['data']);
echo json_encode($result);
?>