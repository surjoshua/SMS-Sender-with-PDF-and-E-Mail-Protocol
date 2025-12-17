<?php
$env = parse_ini_file(__DIR__ . "/.env");  
$API_KEY = $env["SEVEN_API_KEY"];

$data = json_decode(file_get_contents("php://input"), true);
$empfaenger = $data["to"];

// Benutzername aus Basic-Auth (htpasswd)
$user = isset($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] : "Unbekannt";

$payload = http_build_query([
    "to"   => $empfaenger,
    "text" => "Type Your SMS Text Here.",
    "from" => "SMS Sender",
    "p"    => $API_KEY
]);

$ch = curl_init("https://gateway.seven.io/api/sms");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/x-www-form-urlencoded"
    ],
    CURLOPT_TIMEOUT => 10
]);

$result = curl_exec($ch);
if ($result === false) {
    echo json_encode([
        "message" => "Error: Could Not Send Message (" . curl_error($ch) . ")"
    ]);
    exit;
}
curl_close($ch);

$result = trim($result);

// --- Mail Logging ---
$betreff = "LOG SMS Sender (API-Feedback: $result)";
$nachricht = "The server has been requested to send a new SMS. ".\n\n".
             "User: $user\n".
             "Recipient: $empfaenger\n".
             "API-Feedback: $result\n".
             "Time: " . date("Y-m-d H:i:s");

$headers = "From: noreply@example.com\r\n".
           "Content-Type: text/plain; charset=UTF-8";

@mail("example@example.com", $betreff, $nachricht, $headers);
// ---------------------

if ($result === "100") {
    echo json_encode([
        "message" => "The request to send the SMS has been successfully forwarded to the SMS server."
    ]);
} else {
    echo json_encode([
        "message" => "Error: The SMS could not be forwarded to the SMS server. (Error: $result)"
    ]);
}
?>