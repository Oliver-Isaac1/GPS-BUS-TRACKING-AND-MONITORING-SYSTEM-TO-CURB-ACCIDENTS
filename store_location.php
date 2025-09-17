<?php
$servername = "localhost";
$username = "root"; // Default username for WAMP
$password = ""; // Default password for WAMP
$dbname = "research";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve POST data
$device_id = $_POST['device_id'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$speed = $_POST['speed']; // Capture the speed from the request

// Prepare and bind the SQL statement
$stmt = $conn->prepare("INSERT INTO bus_location_data (device_id, latitude, longitude, speed) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sdds", $device_id, $latitude, $longitude, $speed);

// Execute the statement
if ($stmt->execute()) {
    echo "Location data saved successfully.";
} else {
    echo "Error: " . $stmt->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>
