// Handle the message form submission using AJAX
document.getElementById('messageForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent form submission

    const message = document.getElementById('message').value.trim(); // Get the message from the textarea

    if (message !== '') {
        // Prepare the data to be sent via AJAX
        const formData = new FormData();
        formData.append('message', message);

        // Send the message via AJAX
        fetch('connect.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Handle the response from the server (message sent successfully)
            if (data.includes("Message has been successfully sent.")) {
                alert("Your message has been sent!");
                document.getElementById('message').value = ''; // Clear the message field after sending
                closeMessageDialog(); // Close the modal dialog after submission
            } else {
                alert("There was an issue sending your message. Please try again later.");
            }
        })
        .catch(error => {
            // Handle any errors
            console.error('Error:', error);
            alert('There was an error sending your message. Please try again later.');
        });
    } else {
        alert("Please enter a message before submitting.");
    }
});

// Fetch the user's current location
function fetchCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                let latitude = position.coords.latitude;
                let longitude = position.coords.longitude;
                alert("Your current location:\nLatitude: " + latitude + "\nLongitude: " + longitude);

                // Optionally, send this data to the backend (connect.php) for processing
                const locationData = new FormData();
                locationData.append('latitude', latitude);
                locationData.append('longitude', longitude);

                fetch('connect.php', {
                    method: 'POST',
                    body: locationData
                })
                .then(response => response.text())
                .then(data => {
                    console.log("Location sent successfully:", data);
                })
                .catch(error => {
                    console.error('Error sending location:', error);
                });

            },
            function (error) {
                alert("Error fetching location: " + error.message);
            }
        );
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}
