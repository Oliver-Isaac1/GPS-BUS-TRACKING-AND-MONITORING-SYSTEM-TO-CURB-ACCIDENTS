<?php
$servername = "localhost"; // Change if using a different host
$username = "root"; // Default for local server, change if necessary
$password = ""; // Default for local server, change if necessary
$dbname = "research"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle emergency alert request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'emergency_alert') {
    $timestamp = date("Y-m-d H:i:s");

    // Insert emergency alert into database
    $sql = "INSERT INTO emergency_alerts (alert_message, alert_time) VALUES ('Emergency Alert Triggered', '$timestamp')";

    if ($conn->query($sql) === TRUE) {
        echo "Emergency alert recorded successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
