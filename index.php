<?php
$user = isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] : "Gast";
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>SMS Sender</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f4f7f9;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      color: #333;
    }
    .container {
      background: #fff;
      border-radius: 12px;
      padding: 30px 40px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 420px;
      width: 90%;
    }
    .logo {
      width: 120px;
      margin-bottom: 20px;
    }
    h2 {
      margin-bottom: 20px;
      color: #017133;
    }
    input, button {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        font-size: 1em;
        border-radius: 8px;
        box-sizing: border-box;
    }

    input {
        border: 1px solid #ccc;
        text-align: center;
    }

    button {
        background: #017133;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    button:hover {
        background: #015526;
    }
    footer {
      margin-top: 20px;
      font-size: 0.9em;
      color: #666;
    }
    footer a {
      color: #017133;
      text-decoration: none;
    }
    footer a:hover {
      text-decoration: underline;
    }

    .modal {
        display: none; 
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        align-items: center;
        justify-content: center;
    }
    .modal-content {
      background: #fff;
      padding: 20px 30px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    .modal-content h3 {
      color: #017133;
      margin-bottom: 10px;
    }
    .close-btn {
      margin-top: 15px;
      background: #017133;
      color: #fff;
      border: none;
      border-radius: 6px;
      padding: 10px 20px;
      cursor: pointer;
    }
    .close-btn:hover {
      background: #017133;
    }

#legalPopup {
  display: flex;           
  position: fixed;
  z-index: 2000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
  align-items: center;
  justify-content: center;
}
#legalPopup .modal-content {
  background: #fff;
  padding: 25px 30px;
  border-radius: 12px;
  max-width: 500px;
  text-align: center;
  box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}
#legalPopup h3 {
  margin-bottom: 15px;
  color: #017133;
}
#legalPopup p {
  margin-bottom: 12px;
  font-size: 0.95em;
  line-height: 1.5;
}
#legalPopup a {
  color: #017133;
  text-decoration: none;
}
#legalPopup a:hover {
  text-decoration: underline;
}
#legalPopup .close-btn {
  margin-top: 10px;
  background: #017133;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 10px 20px;
  cursor: pointer;
}
#legalPopup .close-btn:hover {
  background: #017133;
}
  </style>
</head>
<body>

    <div id="legalPopup" class="modal">
    <div class="modal-content">
        <h3>Legal Notice</h3>
        <p>
        The SMS sender is an open-source project developed by Joshua Sur. You are free to adapt and modify the project to suit your specific requirements.
        <br>
        No liability is assumed for any potential errors. This notice section may be used to display user information, update notices, or similar communications.
        </p>
        <p>
        <em>Contact:</em><br>
        Admin: John Doe (<a href="mailto:example@example.com">john.doe@example.com</a>)<br>
        Helpdesk: Jane Doe (<a href="mailto:example@example.com">jane.doe@example.com</a>)
        </p>
        <button class="close-btn" onclick="closeLegalPopup()">OK</button>
    </div>
    </div>

  <div class="container">
    <img src="logo.png" alt="Logo" class="logo">
    <h2>SMS Sender</h2>
    <p>Welcome, <?php echo htmlspecialchars($user); ?>!</p>
    <form id="smsForm">
      <label for="nummer">phone number (+1...):</label><br>
      <input type="text" id="nummer" required><br>
      <button type="submit">Send SMS</button>
    </form>
    <footer>
      SMS Sender with protocol developed by <a href="mailto:mail@joshua-sur.com">Joshua Sur</a> /*In accordance with the Creative Commons license, attribution to the author of this software is required.*/
      <b>CC BY-NC-SA 4.0</b>
    </footer>
  </div>

  <!-- Modal -->
  <div id="popup" class="modal">
    <div class="modal-content">
      <h3 id="popup-title"></h3>
      <p id="popup-msg"></p>
      <button class="close-btn" onclick="closePopup()">OK</button>
    </div>
  </div>

  <script>
  const FROM = "SMS Sender";
  const LINK = "https://example.com";

  function closeLegalPopup() {
    document.getElementById("legalPopup").style.display = "none";
  }

  function showPopup(title, msg, isSuccess = false, nummer = null, status = null) {
  document.getElementById("popup-title").innerText = title;
  document.getElementById("popup-msg").innerText = msg;

  const popup = document.getElementById("popup");
  const buttonContainer = popup.querySelector(".modal-content");

  // alten Button entfernen
  const oldBtn = popup.querySelector(".close-btn");
  if (oldBtn) oldBtn.remove();

  // neuen Button erzeugen
  const btn = document.createElement("button");
  btn.className = "close-btn";

  if (isSuccess && nummer && status) {
    btn.innerText = "Create PDF";
    btn.onclick = () => {
      window.location.href = `protocol.php?to=${encodeURIComponent(nummer)}&status=${encodeURIComponent(status)}`;
    };
  } else {
    btn.innerText = "OK";
    btn.onclick = closePopup;
  }

  buttonContainer.appendChild(btn);

  popup.style.display = "flex";
}

  function closePopup() {
    document.getElementById("popup").style.display = "none";
  }

  document.getElementById("smsForm").addEventListener("submit", async (e) => {
  e.preventDefault();
  const nummer = document.getElementById("nummer").value;

  try {
    const res = await fetch("send-sms.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ to: nummer })
    });

    const data = await res.json();

    if (res.ok && data.message.includes("erfolgreich")) {
      showPopup("Success", data.message, true, nummer, "100");
    } else {
      showPopup("Error", data.message || "Unknown Error");
    }
  } catch (err) {
    showPopup("Network Error", err);
  }
});
</script>
</body>
</html>