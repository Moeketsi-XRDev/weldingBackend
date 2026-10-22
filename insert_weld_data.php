<?php
$servername = "sql10.freesqldatabase.com";
$username   = "sql10839185";
$password   = "lfNHe5GHSN";
$dbname     = "sql10839185";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read POST parameters
$user          = isset($_POST['username']) ? $_POST['username'] : '';
$speed         = isset($_POST['welding_speed']) ? floatval($_POST['welding_speed']) : 0;
$welding_angle = isset($_POST['welding_angle']) ? floatval($_POST['welding_angle']) : 0;
$travel_angle  = isset($_POST['travel_angle']) ? floatval($_POST['travel_angle']) : 0;

if (!empty($user)) {
    // Note: Since 'username' is the PRIMARY KEY in user_data, 
    // ON DUPLICATE KEY UPDATE updates existing records instead of throwing a duplicate key error.
    $stmt = $conn->prepare("INSERT INTO user_data (username, welding_speed, welding_angle, travel_angle) 
                            VALUES (?, ?, ?, ?) 
                            ON DUPLICATE KEY UPDATE welding_speed=?, welding_angle=?, travel_angle=?");
    
    $stmt->bind_param("sdddddd", $user, $speed, $welding_angle, $travel_angle, $speed, $welding_angle, $travel_angle);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error: Missing username";
}

$conn->close();
?>