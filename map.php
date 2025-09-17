<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Location Tracking</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map { height: 500px; }
    </style>
</head>
<body>
    <h1>Track Bus Locations</h1>
    
    <!-- Bus Information Display -->
    <div>
        <h3>Bus Information</h3>
        <p><strong>Device ID:</strong> <span id="device-id">KDS 444</span></p>
        <p><strong>Current Speed:</strong> <span id="bus-speed">0</span> km/h</p>
        <p><strong>Current Location:</strong> <span id="bus-location">Loading...</span></p>
    </div>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Initialize the map, initially centered at the user's current location or default to Nairobi
        const map = L.map('map').setView([-1.286389, 36.817223], 9); // Default to Nairobi

        // Set up OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Define a custom bus icon
        const busIcon = L.icon({
            iconUrl: 'bus.png', // Ensure this file exists in the correct directory
            iconSize: [40, 40], 
            iconAnchor: [20, 40], 
        });

        // Create a marker for the bus, initially at Nairobi
        let marker = L.marker([-1.286389, 36.817223], { icon: busIcon }).addTo(map);

        let currentLat = -1.286389, currentLng = 36.817223; // Default to Nairobi (will update to current location)
        let targetLat = -1.286389, targetLng = 36.817223; // Target for smooth movement (Nairobi)

        // Variables to calculate speed
        let previousLat = currentLat, previousLng = currentLng;
        let previousTimestamp = Date.now();

        // Function to send location and speed data to the backend
        function sendLocation(deviceId, latitude, longitude, speed) {
            document.getElementById("bus-speed").textContent = speed.toFixed(2);
            document.getElementById("bus-location").textContent = `${latitude.toFixed(5)}, ${longitude.toFixed(5)}`;

            fetch('http://localhost/research/store_location.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `device_id=${deviceId}&latitude=${latitude}&longitude=${longitude}&speed=${speed}`
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Success message or error from the backend
            })
            .catch(error => {
                console.log('Error:', error);
            });
        }

        // Function to calculate speed in km/h (using Haversine formula for distance)
        function calculateSpeed(lat1, lng1, lat2, lng2, timestamp1, timestamp2) {
            const R = 6371; // Radius of the Earth in km
            const toRad = Math.PI / 180;

            const deltaLat = (lat2 - lat1) * toRad;
            const deltaLng = (lng2 - lng1) * toRad;

            const a = Math.sin(deltaLat / 2) * Math.sin(deltaLat / 2) +
                      Math.cos(lat1 * toRad) * Math.cos(lat2 * toRad) *
                      Math.sin(deltaLng / 2) * Math.sin(deltaLng / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            const distance = R * c; // Distance in km
            const timeDiff = (timestamp2 - timestamp1) / 1000 / 3600; // Time difference in hours

            // Speed = distance / time
            return distance / timeDiff; // Speed in km/h
        }

        // Function to smoothly transition between GPS updates
        function animateBus() {
            const speed = 0.0005; // Adjust speed of movement (lower = smoother, higher = faster)

            let latDiff = targetLat - currentLat;
            let lngDiff = targetLng - currentLng;

            if (Math.abs(latDiff) > 0.00001 || Math.abs(lngDiff) > 0.00001) {
                currentLat += latDiff * speed;
                currentLng += lngDiff * speed;
                marker.setLatLng([currentLat, currentLng]);
                map.setView([currentLat, currentLng]);

                // Calculate speed based on previous and current position
                const currentTimestamp = Date.now();
                const speedInKmH = calculateSpeed(previousLat, previousLng, currentLat, currentLng, previousTimestamp, currentTimestamp);

                // Update previous values
                previousLat = currentLat;
                previousLng = currentLng;
                previousTimestamp = currentTimestamp;

                // Send the updated location and speed to the backend every 15 seconds
                setTimeout(() => {
                    sendLocation('KDS 444', currentLat, currentLng, speedInKmH);
                }, 15000); // 15000ms = 15 seconds
            }
            requestAnimationFrame(animateBus);
        }

        // Function to fetch and update the bus position to the phone's GPS location
        function getDeviceLocation() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const { latitude, longitude } = position.coords;
                        console.log("Device Location:", latitude, longitude);

                        // Update the map view and marker position based on current device location
                        currentLat = latitude;
                        currentLng = longitude;

                        // Set new target location to Nairobi
                        targetLat = -1.286389;  // Nairobi's coordinates
                        targetLng = 36.817223;

                        // Update the marker to the current location
                        marker.setLatLng([currentLat, currentLng]);
                        map.setView([currentLat, currentLng]);

                        // Start the bus movement animation from this location
                        animateBus();
                    },
                    (error) => {
                        console.error("Error getting location:", error);
                    },
                    { enableHighAccuracy: true, maximumAge: 1000 }
                );
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }

        // Display Nearby Bus Stops or Landmarks
        const busStops = [
            { name: "Stop 1", lat: -1.280, lng: 36.821 },
            { name: "Stop 2", lat: -1.300, lng: 36.810 }
        ];

        busStops.forEach(stop => {
            L.marker([stop.lat, stop.lng])
                .bindPopup(`<b>${stop.name}</b>`)
                .addTo(map);
        });

        // Start animation and GPS tracking
        getDeviceLocation(); // Get the user's current location when the page loads
    </script>
</body>
</html>
