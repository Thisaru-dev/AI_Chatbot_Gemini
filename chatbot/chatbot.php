<?php
session_start();

// Replace with your real API key
$apiKey = 'xxxxxxxxxxxxxxxxxxxxxxxxxx';

if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear'])) {
    $_SESSION['chat_history'] = [];
}

// Handle user input
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {
    $userMessage = trim($_POST['message']);
 //unset($_SESSION['chat_history']);  // Clear chat history
    // Add user's message to history
    $_SESSION['chat_history'][] = ['role' => 'user', 'parts' => [['text' => $userMessage]]];

    // Prepare API request
    $data = [
        'contents' => $_SESSION['chat_history']
    ];

  // Initialize cURL
$ch = curl_init('https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent?key=' . $apiKey);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Execute and handle response
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    $responseData = json_decode($response, true);
    // echo "Raw response: " . $response;

    $botMessage = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? 'Error: No response';
    // echo "Bot says: " . $botMessage;
}

curl_close($ch);
  // Add bot's response to history
    $_SESSION['chat_history'][] = ['role' => 'model', 'parts' => [['text' => $botMessage]]];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chatbot</title>
   <style>
    body {  font-family: Arial;
        margin: 0;
        background: #f9f9f9;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: stretch; }
    .chat-box { display: flex;
        flex-direction: column;
        margin: 20px;
        width: 100%;
        max-width: 600px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px #ccc;
        overflow: hidden; }
    .chat-header {
        padding: 20px;
        background: #4a90e2;
        color: white;
        font-size: 20px;
        text-align: center;
    }

    .chat-messages {
       flex: 1;
    padding: 20px;
    overflow-y: auto;
    background-color: #f5f5f5;
    display: flex;
    flex-direction: column;
    }

    .message {
   display: inline-flex;
    margin: 10px 0;
    align-items: flex-end;
    padding: 10px 15px;
    border-radius: 15px;
    font-size: 13px;
    word-wrap: break-word;
    white-space: pre-wrap;
    max-width: 80%;
    }
    .field{
 flex: 1;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 20px;
        outline: none;
    }
    .form{
         display: flex;
        padding: 10px;
        border-top: 1px solid #ccc;
        background: #fff;
    }
    .btn{
    padding: 10px 20px;
        margin-left: 10px;
        border: none;
        background: #4a90e2;
        color: white;
        border-radius: 20px;
        cursor: pointer;
    }
    .btn:hover{
         background-color:#58BF83;
    }
    .message.user {
        background-color: #dcf8c6;
        margin-left: auto;
        border-bottom-right-radius: 0;
        justify-content: flex-end;
    }
    .message.bot {
       background-color: #f1f0f0;
        margin-right: auto;
        border-bottom-left-radius: 0;
        justify-content: flex-start;
    }
    .message .icon {
        width: 24px;
        height: 24px;
        margin: 0 8px;
    }
    .message.user .icon {
        order: 2; /* icon after text */
    }
    .message.user .text {
        order: 1;
    }
    .message.bot .icon {
        order: 2; /* icon before text */
    }
    .message.bot .text {
        order: 1;
    }
    .clearbtnform{
      text-align: right;  
padding: 5px; 
    }
    .clearbtn{

     background-color:white;
  color: #f44336;
 border: none;
 padding: 6px 12px;
 border-radius: 5px;
cursor: pointer;
    }


    @keyframes float {
    0% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0); }
}

.ask-anything-container {
    text-align: center;
    padding: 40px 20px;
    color: #888;
}

.ask-anything-img {
    width: 100px;
    opacity: 0.7;
    animation: float 3s ease-in-out infinite;
}
</style>


</head>
<body>
    <div class="chat-box">
        <div class="chat-header">Chatbot</div><form method="post" class="clearbtnform">
    <button type="submit" name="clear" class="clearbtn">
        clear all
    </button>
</form>
<div class="chat-messages" id="chat-messages">
    <?php if (empty($_SESSION['chat_history'])): ?>
    <div style="text-align: center; padding: 40px 20px;" class="ask-anything-container">
        <img src="chatbot.png" alt="Ask Anything"  class="ask-anything-img" style="width: 100px; opacity: 0.6;" />
        <p style="font-size: 16px; color: #888;">Ask anything to get started...</p>
    </div>
<?php else: ?>
       <?php foreach ($_SESSION['chat_history'] as $message): 
    $role = $message['role'];
    $text = htmlspecialchars($message['parts'][0]['text']);
?>
    <div class="message <?= $role ?>">
        <?php if ($role === 'model'): ?>
            <img src="chatbot.png" alt="Bot" class="icon" />
            <div class="text"><?= $text ?></div>
        <?php else: ?>
            <div class="text"><?= $text ?></div>
            <img src="user.ico" alt="User" class="icon" />
        <?php endif; ?>
    </div>
<?php endforeach; ?>
<?php endif; ?>
</div>

        <form method="POST" class="form">
            <input type="text" name="message" class="field" placeholder="Type a message..." required />
            <input type="submit" class="btn" value="Send" />
        </form>
    </div>

    <script>
    const chatMessages = document.getElementById("chat-messages");
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
</script>
</body>
</html>
