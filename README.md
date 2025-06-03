# 🤖 AI Chatbot with Gemini API – Web Integration

This project is a simple yet powerful web-based AI chatbot powered by **Google's Gemini 1.5 Flash API**, built using PHP and HTML/CSS. It supports real-time conversation, session-based history, and is integrated into a responsive modern website with an animated chatbot popup.

---

## 📌 Features

- 🔌 **Gemini 1.5 Flash API Integration** (via PHP `cURL`)
- 💬 **Live Chat Interface** with automatic scroll and icon-based user/bot messages
- 🧠 **Session-based Message History** to simulate ChatGPT-like experience
- 🌐 **Clean Website UI** with embedded chatbot popup in bottom-right corner
- 🎨 **"Ask Anything" Animation** when no messages are present
- 🧼 **Clear Chat Button** to reset conversation anytime

---

## 🛠️ Technologies Used

- PHP (Backend logic)
- Google Gemini 1.5 Flash API
- HTML5 / CSS3 (Frontend UI)
- JavaScript (Popup behavior)
- Apache (XAMPP or WAMP for local hosting)

---
## 🚀 Installation Guide

### 🗂️ Step 1: Download and Extract

- Download the zip of this repository.
- Extract the folder into:
  - For **WAMP**: `C:\wamp64\www\`
  - For **XAMPP**: `C:\xampp\htdocs\`

---

### 🟢 Step 2: Start Your Server

- Open **WAMP** or **XAMPP Control Panel**.
- Start **Apache** service.

---

### 🌐 Step 3: Access the Chatbot

#### Option A – Direct Chatbot
Go to:
http://localhost/chatbot/chatbot.php

#### Option B – Website with Chatbot Integration
Go to:
http://localhost/chatbot
Then click the **chatbot icon in the bottom right corner** to open the chat window.

---

### ✅ Step 4: Start Chatting

- Enter a message and press **Send**.
- Wait for a reply from the AI (powered by Gemini).
- To clear all messages, click the **"Clear Chat"** button at the top of the chat window.

---
## 🔑 API Key Setup

Replace the following line in `chatbot.php` with your own Gemini API key:

```php
$apiKey = "xxxxxxxxxxxxxxxxxxxxxxxx";

🙋‍♂️ Author
Thisaru Kalpana
