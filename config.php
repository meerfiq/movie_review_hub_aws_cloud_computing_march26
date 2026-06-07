<?php
// Database configuration for AWS RDS
// Update these values with your actual RDS credentials
$host = "YOUR_RDS_ENDPOINT_HERE";  // e.g., cc-group-project-db.xxxxx.us-east-1.rds.amazonaws.com
$user = "admin";                    // Your database username
$pass = "YOUR_PASSWORD_HERE";       // Your database password
$db = "app_db";                     // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8");
?>