<?php
session_start();
$user   = $_SERVER['REMOTE_USER'] ?? "unknown";
$zeit   = date("d.m.Y H:i:s");

$data = $_POST;
if (empty($data) && !empty($_GET)) $data = $_GET;

$to     = $data['to']          ?? '–';
$status = $data['status']      ?? '–';
$name   = $data['name']        ?? '–';
$addr   = $data['block2']     ?? '–';
$art    = $data['text1']  ?? '–';
$bete   = isset($data['text2']) ? (is_array($data['beteiligte']) ? implode(', ', $data['beteiligte']) : $data['beteiligte']) : '–';
$rm     = $data['text3'] ?? '';
$free   = $data['text4'] ?? '';

// ---------- Send Protocol via email ----------
$empfaenger = "example@example.com";
$betreff    = "SMS Protocol";

$inhalt  = "SMS Protocol\n";
$inhalt .= "Generated: $zeit\n";
$inhalt .= "User: $user\n";
$inhalt .= "Phone Number: $to\n";
$inhalt .= "API-Status: $status\n";
$inhalt .= "Block1: $art\n";
$inhalt .= "Block2: $bete\n";
$inhalt .= "Block3: $name\n";
$inhalt .= "Block4: $addr\n";
$inhalt .= "Block5: $rm\n";
$inhalt .= "Block6:\n$free\n";

$headers = "From: example@example.com\r\nContent-Type: text/plain; charset=UTF-8";
@mail($empfaenger, $betreff, $inhalt, $headers);
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Protocol</title>
<style>
  :root { --green:#017133; --muted:#6b7280; }
  html,body { height:100%; margin:0; }
  body { font-family: Arial, sans-serif; }

  .page { margin: 16mm; }
  header { display:flex; align-items:center; gap:16px; margin-bottom:10mm; }
  header img { width:110px; height:auto; }
  header .titles { display:flex; flex-direction:column; }
  header .titles h1 { margin:0; color:var(--green); font-size:22px; }
  header .titles .sub { color:var(--muted); font-size:12px; }

  .section { margin: 8mm 0 0 0; }
  .section h2 { color:var(--green); font-size:15px; margin:0 0 6px 0; }
  .grid { display:grid; grid-template-columns: 42mm 1fr; gap:6px 10px; }
  .label { color:#111; font-weight:bold; }
  .value { color:#111; white-space:pre-wrap; }

  .box { border:1px solid #e5e7eb; border-radius:8px; padding:10px; }
  .muted { color:var(--muted); }

  @media print {
    @page { margin: 10mm; }
    .page { margin: 0; }
    .print-counter-anchor::after {
      content: "Seite " counter(page) " von " counter(pages);
      position: fixed; bottom: 6mm; right: 10mm; font-size: 11px; color:#374151;
    }
    button { display:none; }
  }

  .actions { margin-top: 12mm; }
  .btn { background:var(--green); color:#fff; border:none; border-radius:8px; padding:10px 16px; cursor:pointer; }
  .btn:hover { filter:brightness(0.92); }
</style>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    window.print();
  });
</script>
</head>
<body>
<div class="page">
  <div class="print-counter-anchor"></div>

  <header>
    <img src="logo.png" alt="Logo">
    <div class="titles">
      <h1>SMS Protocol</h1>
      <div class="sub">Generated <?= $zeit ?></div>
    </div>
  </header>

  <section class="section">
    <h2>Metadata</h2>
    <div class="grid box">
      <div class="label">User</div><div class="value"><?= htmlspecialchars($user) ?></div>
      <div class="label">Phone Number</div><div class="value"><?= htmlspecialchars($to) ?></div>
      <div class="label">API-Status</div><div class="value"><?= htmlspecialchars($status) ?></div>
      <div class="label">Time</div><div class="value"><?= $zeit ?></div>
    </div>
  </section>

  <section class="section">
    <h2>Head</h2>
    <div class="grid box">
      <div class="label">Block1</div><div class="value"><?= htmlspecialchars($art) ?></div>
      <div class="label">Block2</div><div class="value"><?= htmlspecialchars($bete) ?></div>
      <div class="label">Block3</div><div class="value"><?= htmlspecialchars($name) ?></div>
      <div class="label">Block4</div><div class="value"><?= htmlspecialchars($addr) ?></div>
      <div class="label">Block5</div><div class="value"><?= nl2br(htmlspecialchars($rm)) ?></div>
    </div>
  </section>

  <section class="section">
    <h2>Head</h2>
    <div class="box value"><?= nl2br(htmlspecialchars($free)) ?: '<span class="muted">–</span>' ?></div>
  </section>

  <section class="section">
    <h2>Notice</h2>
    <div class="box value"> Write your notice here.</div>
  </section> 


  <div class="actions">
    <button class="btn" onclick="window.print()">print again</button>
  </div>
</div>
</body>
</html>