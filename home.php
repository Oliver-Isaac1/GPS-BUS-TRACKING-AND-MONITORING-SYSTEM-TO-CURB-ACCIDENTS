<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MASH EAST AFRICA</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <style>
    /* === General Styling === */
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); margin: 0; padding: 0; }
    .navbar { background-color: #1E3A8A; padding: 10px 20px; display: flex; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); }
    .companylogo { height: 60px; }
    .dark-mode-toggle {
  background-color: transparent;
  border: none;
  color: white;
  font-size: 12px; /* Reduced font size */
  padding: 5px;    /* Reduced padding */
  width: 30px;         /* Reduced width for shorter length */
  height: 30px;        /* Optional: Adjust height for consistency */
  cursor: pointer;
}

.dark-mode-toggle i {
  font-size: 18px; /* Smaller icon size */
}

    .container { background-color: #fff; margin: 30px auto; padding: 30px; border-radius: 15px; width: 90%; max-width: 1100px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); }
    h3 { text-align: center; font-size: 28px; color: #1E3A8A; }
    .blocks { display: flex; flex-wrap: wrap; justify-content: space-between; }
    .left, .right { width: 48%; }
    .select select, .date-input-field, textarea { width: 100%; padding: 12px; margin-top: 5px; border-radius: 10px; border: 1px solid #ccc; }
    button { background-color: #1E3A8A; color: white; padding: 12px 25px; border-radius: 10px; cursor: pointer; width: 100%; font-size: 16px; transition: all 0.3s ease; }
    button:hover { background-color: #2563EB; transform: translateY(-2px); }
    #successPopup, #bookingSuccessPopup { display: none; position: fixed; left: 50%; top: 10%; transform: translate(-50%, -50%); background-color: #10B981; color: white; padding: 20px; border-radius: 10px; font-size: 18px; }
     /* === Chatbot Widget === */
     .chatbot-container { position: fixed; bottom: 20px; right: 20px; width: 300px; height: 400px; background-color: #fff; border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); display: none; flex-direction: column; }
    .chatbot-header { background-color: #1E3A8A; color: white; padding: 15px; border-radius: 15px 15px 0 0; text-align: center; font-weight: bold; }
    .chatbot-close { background: none; border: none; color: white; font-size: 20px; cursor: pointer; }
    .chatbot-messages { flex: 1; padding: 10px; overflow-y: auto; background-color: #f9fafb; }
    .chatbot-input { display: flex; border-top: 1px solid #ccc; }
    .chatbot-input input { flex: 1; padding: 10px; border: none; border-radius: 0 0 0 15px; }
    .chatbot-input button { width: 60px; border-radius: 0 0 15px 0; }
    .chatbot-toggle { position: fixed; bottom: 20px; right: 20px; background-color: #1E3A8A; color: white; width: 60px; height: 60px; border-radius: 50%; border: none; font-size: 30px; cursor: pointer; }

    @media (max-width: 768px) {
      .chatbot-container { width: 90%; height: 400px; }
    }
 /* === Dark Mode === */
 body.dark-mode {
      background: linear-gradient(135deg, #1f2937 0%, #4b5563 100%);
      color: #e5e7eb;
    }
    .dark-mode .container { background-color: #374151; color: #e5e7eb; }
    .dark-mode h3 { color: #93c5fd; }
    .dark-mode .navbar { background-color: #111827; }
    .dark-mode .select select, .dark-mode .date-input-field, .dark-mode textarea {
      background-color: #4b5563;
      color: #e5e7eb;
      border: 1px solid #6b7280;
    }
    .dark-mode button { background-color: #2563EB; }
    .dark-mode button:hover { background-color: #3b82f6; }
    .dark-mode .modal-content { background-color: #4b5563; color: #e5e7eb; }
    .dark-mode .close { color: #93c5fd; }

    @media (max-width: 768px) {
      .blocks { flex-direction: column; }
      .left, .right { width: 100%; }
    }
    /* === Message Modal Styling === */
    .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); justify-content: center; align-items: center; }
    .modal-content { background-color: #fff; padding: 30px; border-radius: 15px; width: 90%; max-width: 500px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3); position: relative; animation: fadeIn 0.4s ease; }
    .modal-content h3 { text-align: center; color: #1E3A8A; margin-bottom: 20px; }
    .modal-content textarea { width: 100%; border-radius: 10px; border: 1px solid #ccc; padding: 15px; font-size: 16px; resize: none; }
    .modal-content button { width: 100%; background-color: #1E3A8A; margin-top: 15px; }
    .modal-content button:hover { background-color: #2563EB; }
    .close { position: absolute; top: 10px; right: 15px; font-size: 28px; color: #1E3A8A; cursor: pointer; }
    .close:hover { color: #2563EB; }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
      .blocks { flex-direction: column; }
      .left, .right { width: 100%; }
    }
  </style>
</head>

<body>
<div class="navbar">
    <img src="kasperlogo.png" class="companylogo">
    <button class="dark-mode-toggle" onclick="toggleDarkMode()">
      <i class="fas fa-moon"></i>
    </button>
  </div>

  <div class="container">
    <h3>Mash Cool</h3>
    <form id="bookingForm">
      <input type="hidden" name="action" value="booking">
      <div class="blocks">
        <div class="left">
          <p>From</p>
          <div class="select">
            <select name="from_location" required>
              <option value="Nairobi">Nairobi</option>
              <option value="Mombasa">Mombasa</option>
              <option value="Kisumu">Kisumu</option>
              <option value="Eldoret">Eldoret</option>
            </select>
          </div>
          <button type="button" onclick="fetchCurrentLocationOnMap()">Use Current Location</button>

          <p>To</p>
          <div class="select">
            <select name="to_location" required>
              <option value="Kisumu">Kisumu</option>
              <option value="Mombasa">Mombasa</option>
              <option value="Eldoret">Eldoret</option>
              <option value="Nairobi">Nairobi</option>
            </select>
          </div>

          <p>Departure Date</p>
          <input class="date-input-field" type="date" name="departure_date" required>

          <p>Arrival Date</p>
          <input class="date-input-field" type="date" name="arrival_date" required>

          <p>Passengers</p>
          <div class="select">
            <select name="passengers" required>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
          </div>
        </div>

        <div class="right">
          <div class="trip-detail-container">
            <h3 class="trip-detail-title">Trip Details</h3>
            <table>
              <tr><td>From</td><td>Nairobi</td></tr>
              <tr><td>To</td><td>Mombasa</td></tr>
              <tr><td>Transfers</td><td>1</td></tr>
              <tr><td>Departure</td><td>2021-10-28</td></tr>
              <tr><td>Arrival</td><td>2021-10-29</td></tr>
            </table>
            <hr>
            <h3 class="trip-detail-title">Price</h3>
            <table>
              <tr><td>Base Price</td><td>Ksh 1500</td></tr>
              <tr><td>Tax</td><td>Ksh 100</td></tr>
              <tr><td>Total Price</td><td>Ksh 1600</td></tr>
            </table>
            <!-- 🚨 Emergency Alert Button -->
<button type="button" style="background-color: red; margin-top: 15px;" onclick="sendEmergencyAlert()">🚨 Emergency Alert</button>

<script>
  function sendEmergencyAlert() {
    if (confirm("Are you sure you want to send an emergency alert?")) {
      $.ajax({
        type: 'POST',
        url: 'emergency.php',
        data: { action: 'emergency_alert' },
        success: function(response) {
          alert("🚨 Emergency alert sent: " + response);
        },
        error: function() {
          alert("❌ Failed to send emergency alert.");
        }
      });
    }
  }
</script>
          </div>
        </div>
      </div>

      <div class="buttons">
        <button type="submit">Book Ticket</button>
        <button type="button" onclick="window.location.href='map.php'">View Current Location</button>
        <button type="button" onclick="openMessageDialog()">Send Message</button>
      </div>
    </form>
  </div>
<!-- ✅ Floating Chatbot Widget -->
<button class="chatbot-toggle" onclick="toggleChatbot()">💬</button>
<div class="chatbot-container" id="chatbotContainer">
  <div class="chatbot-header"><span>🤖 Chatbot Assistant</span>
  <button class="chatbot-close" onclick="toggleChatbot()">&times;</button></div>
  <div class="chatbot-messages" id="chatbotMessages"></div>
  <div class="chatbot-input">
    <input type="text" id="chatbotInput" placeholder="Type your message...">
    <button onclick="sendChatbotMessage()">Send</button>
  </div>
</div>
  <!-- ✅ Success Popups -->
  <div id="successPopup">✅ Message sent successfully!</div>
  <div id="bookingSuccessPopup">✅ Ticket booked successfully!</div>

  <!-- 💬 Stylish Message Modal -->
  <div id="messageModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeMessageDialog()">&times;</span>
      <h3>Send a Message</h3>
      <form id="messageForm">
        <input type="hidden" name="action" value="message">
        <textarea name="message" rows="5" placeholder="Type your message here..." required></textarea>
        <button type="submit">Send</button>
      </form>
    </div>
  </div>

  <!-- ✅ JavaScript Functions -->
  <script>
     function toggleDarkMode() {
      document.body.classList.toggle('dark-mode');
      const icon = document.querySelector('.dark-mode-toggle i');
      icon.classList.toggle('fa-sun');
      icon.classList.toggle('fa-moon');
    }
    function toggleChatbot() {
    const chatbot = document.getElementById('chatbotContainer');
    chatbot.style.display = chatbot.style.display === 'flex' ? 'none' : 'flex';
  }

  function sendChatbotMessage() {
    const inputField = document.getElementById('chatbotInput');
    const message = inputField.value.trim();
    if (message !== '') {
      displayChatbotMessage(`You: ${message}`);
      setTimeout(() => displayChatbotMessage(`Bot: ${generateBotResponse(message)}`), 500);
      inputField.value = '';
    }
  }

  function displayChatbotMessage(message) {
    const messagesContainer = document.getElementById('chatbotMessages');
    const messageDiv = document.createElement('div');
    messageDiv.textContent = message;
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
  }

  function generateBotResponse(message) {
    const responses = {
      'hello': 'Hello! How can I assist you today?',
  'help': 'Sure, I can help. What do you need assistance with?',
  'book': 'You can book your ticket by filling out the booking form.',
  'emergency': 'For emergencies, please click the Emergency Alert button.',
  'location': 'Click "View Current Location" to see your real-time location on the map.',
  'reliable': 'Yes, this company is reliable. We prioritize safety, comfort, and timely services.',
  'how can i book': 'To book your ticket, simply fill out the booking form on the page and click "Book Ticket."',
  'available trips': 'Our available trips include Nairobi, Mombasa, Kisumu, and Eldoret routes.',
  'thankyou': 'You\'re welcome! 😊 Let me know if you need any more assistance.',
  'price': 'The base price is Ksh 1500, with tax included, totaling Ksh 1600.',
  'cancel': 'To cancel a booking, please contact customer support or visit our office.',
  'payment': 'We accept various payment methods including mobile money and credit cards.',
  'offers': 'Currently, we have discounts for early bookings and group travel. Check our website for details.',
  'departure time': 'Departure times vary by route. Please select a route to see available times.',
  'arrival time': 'Arrival times depend on the destination. Check the trip details section for more info.',
  'passenger limit': 'Each bus accommodates up to 50 passengers comfortably.',
  'support': 'For further support, you can send us a message using the "Send Message" option.',
  'dark mode': 'You can switch to dark mode using the toggle button on the top right corner.',
  'safety': 'Your safety is our priority. Our buses are GPS-monitored and have emergency alert systems.',
  'feedback': 'We value your feedback! Use the "Send Message" option to share your thoughts with us.'
    };
    const lowerMessage = message.toLowerCase();
    return responses[lowerMessage] || "I'm sorry, I didn't understand that. Can you rephrase?";
  }

  document.getElementById("chatbotInput").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
      event.preventDefault();
      sendChatbotMessage();
    }
  });
    function fetchCurrentLocationOnMap() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function (position) {
            let latitude = position.coords.latitude;
            let longitude = position.coords.longitude;
            window.open(`https://www.google.com/maps?q=${latitude},${longitude}`, '_blank');
          },
          function (error) {
            alert("Error fetching location: " + error.message);
          }
        );
      } else {
        alert("Geolocation is not supported by this browser.");
      }
    }

    function openMessageDialog() {
      $('#messageModal').fadeIn();
    }

    function closeMessageDialog() {
      $('#messageModal').fadeOut();
    }

    $(document).ready(function() {
      $('#messageForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
          type: 'POST',
          url: 'connect.php',
          data: $(this).serialize(),
          success: function(response) {
            $('#successPopup').text("✅ " + response).fadeIn().delay(2000).fadeOut();
            $('#messageForm')[0].reset();
            closeMessageDialog();
          },
          error: function() {
            alert("❌ Failed to send the message.");
          }
        });
      });

      $('#bookingForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
          type: 'POST',
          url: 'connect.php',
          data: $(this).serialize(),
          success: function(response) {
            $('#bookingSuccessPopup').text("✅ " + response).fadeIn().delay(2000).fadeOut();
            $('#bookingForm')[0].reset();
          },
          error: function() {
            alert("❌ Failed to book the ticket.");
          }
        });
      });
    });
  </script>
</body>
</html>
