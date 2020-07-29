<?php
require_once("conf/database_connection.php");

$connection = new DatabaseConnection();
$data = $_POST['data'];
$result = $connection->login($data);
echo json_encode($result);
?>