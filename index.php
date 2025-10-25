<?php
// =============================
// ⚙️ CONFIGURATION
// =============================
$botToken = "YOUR_NEW_BOT_TOKEN";  // यहाँ अपना नया Bot Token डालें
$chatId   = "-1003037262117";      // आपका Telegram Channel ID

// =============================
// 🚀 BACKEND: Send file to Telegram
// =============================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['document'])) {
    $caption = $_POST['caption'] ?? '';
    $filePath = $_FILES['document']['tmp_name'];
    $fileName = $_FILES['document']['name'];

    $url = "https://api.telegram.org/bot$botToken/sendDocument";
    $post_fields = [
        'chat_id' => $chatId,
        'caption' => $caption,
        'document' => new CURLFile($filePath, mime_content_type($filePath), $fileName)
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    $output = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($output, true);
    if ($response['ok']) {
        echo "<script>alert('✅ File sent successfully to Telegram!');</script>";
    } else {
        echo "<script>alert('❌ Failed to send: " . $response['description'] . "');</script>";
    }
}
?>

<!-- =============================
🧩 FRONTEND FORM
============================= -->
<!DOCTYPE html>
<html lang="hi">
<head>
  <meta charset="UTF-8">
  <title>Telegram File Sender</title>
  <style>
    body { font-family: Arial; background: #f4f4f4; padding: 40px; }
    form { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #ccc; max-width: 400px; margin: auto; }
    h2 { text-align: center; }
    input, textarea, button { width: 100%; margin-top: 10px; padding: 10px; border-radius: 6px; border: 1px solid #ccc; }
    button { background: #0088cc; color: white; border: none; font-weight: bold; cursor: pointer; }
    button:hover { background: #0077b3; }
  </style>
</head>
<body>
  <h2>📤 Send File to Telegram Channel</h2>

  <form method="POST" enctype="multipart/form-data">
    <input type="file" name="document" accept=".pdf,.xlsx,.xls,.csv" required>
    <textarea name="caption" placeholder="Enter caption..." rows="3"></textarea>
    <button type="submit">Send to Telegram</button>
  </form>
</body>
</html>