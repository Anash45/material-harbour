<?php
// db_conn.php
session_start();
$servername = "localhost"; // Update with your database server details
$username = "root"; // Update with your database username
$password = "root"; // Update with your database password
$dbname = "material_harbour"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function isLoggedIn() {
    return isset($_SESSION['userType'], $_SESSION['userId'], $_SESSION['email'], $_SESSION['companyName']);
}


function isManufacturer() {
    return isLoggedIn() && isset($_SESSION['userType']) && $_SESSION['userType'] === 'Manufacturer';
}


function isSupplier() {
    return isLoggedIn() && isset($_SESSION['userType']) && $_SESSION['userType'] === 'Supplier';
}
?>
