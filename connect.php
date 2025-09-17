<?php
// Database connection parameters
$servername = "localhost";
$username = "root";  // Update if different
$password = "";      // Update if different
$database = "research";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions based on 'action'
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'booking') {
        handleBooking($conn);
    } elseif ($action === 'message') {
        handleMessage($conn);
    } else {
        echo "Invalid action specified.";
    }
} else {
    echo "No action specified.";
}

$conn->close();

// Function to handle booking
function handleBooking($conn) {
    $from_location = $_POST['from_location'];
    $to_location = $_POST['to_location'];
    $departure_date = $_POST['departure_date'];
    $arrival_date = $_POST['arrival_date'];
    $passengers = $_POST['passengers'];

    $sql = "INSERT INTO bookings (from_location, to_location, departure_date, arrival_date, passengers)
            VALUES ('$from_location', '$to_location', '$departure_date', '$arrival_date', '$passengers')";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Booking saved successfully!";
    } else {
        echo "❌ Error: " . $sql . "<br>" . $conn->error;
    }
}

// Function to handle message
function handleMessage($conn) {
    $message = $_POST['message'];

    $sql = "INSERT INTO messages (message) VALUES ('$message')";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Message saved successfully!";
    } else {
        echo "❌ Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
