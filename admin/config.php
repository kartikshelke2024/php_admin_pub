<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_panal_old";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


require_once('config/base_path.php');
require_once('config/function.php');

?>





