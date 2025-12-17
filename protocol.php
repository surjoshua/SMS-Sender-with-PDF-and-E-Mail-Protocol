<?php
session_start();
$user = $_SERVER['REMOTE_USER'] ?? "undefined";
$nummer = $_GET['to'] ?? "undefined";
$status = $_GET['status'] ?? "undefined";
$zeit = date("d.m.Y H:i:s");
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>SMS Sender Protocol</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    header { text-align: center; margin-bottom: 30px; }
    header img { width: 120px; }
    h1 { color: #017133; }

    .block { margin-bottom: 20px; }
    label { font-weight: bold; display: block; margin-top: 10px; }
    .freitext, input[type="text"] { width: 100%; border: 1px solid #ccc; padding: 8px; margin-top: 5px; }

    button { margin-top: 20px; background:#017133; color:#fff; border:none; padding:10px 20px; border-radius:8px; cursor:pointer; }
    button:hover { background:#015526; }

    @media print {
      button { display: none; }
      input, textarea, .checkbox, .radio { display: none; }
      .print-value { display: block; margin: 5px 0; }
    }

    @page {
      @bottom-right {
        content: "Page " counter(page) " of " counter(pages);
      }
    }

    .print-value { display:none; font-style: italic; }
  </style>
</head>
<body>

<header>
  <img src="logo.png" alt="Logo">
  <h1>SMS Sender Protocol</h1>
</header>

<form id="protokollForm" action="protokol-print.php" method="post" target="_blank">

<input type="hidden" name="to" value="<?= htmlspecialchars($nummer) ?>">
<input type="hidden" name="status" value="<?= htmlspecialchars($status) ?>">

<div class="block">
    <label>User:</label> <?= htmlspecialchars($user) ?><br>
    <label>Phone Number:</label> <?= htmlspecialchars($nummer) ?><br>
    <label>Time:</label> <?= $zeit ?><br>
    <label>API-Status:</label> <?= htmlspecialchars($status) ?><br>
  </div>

  <div class="block">
    <label>Block 1:</label>
    <label class="radio"><input type="radio" name="block1" value="Radio1" checked> Radio 1</label>
    <label class="radio"><input type="radio" name="block1" value="Radio2"> Radio 2</label>
  </div>

  <div class="block">
    <label>Block 2:</label>
    <label class="checkbox"><input type="checkbox" name="block2" value="check1"> check1</label>
    <label class="checkbox"><input type="checkbox" name="block2" value="check2"> check2</label>
    <label class="checkbox"><input type="checkbox" name="block2" value="check3"> check3</label>
  </div>

  <div class="block">
    <label>Block 3:</label>
    <input type="text" name="text1" placeholder="Placeholder1">
  </div>

  <div class="block">
    <label>Block 4:</label>
    <input type="text" name="text2" placeholder="Placeholder2">
  </div>

  <div class="block">
    <label>Block 5:</label>
    <textarea name="text3" class="text3" placeholder="Placeholder3"></textarea>
  </div>

  <div class="block">
    <label>Block 6:</label>
    <textarea name="text4" class="text4" placeholder="Placeholder4"></textarea>
  </div>

  <button type="submit">Create PDF</button>
</form>

</body>
</html>