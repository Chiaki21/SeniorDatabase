<!DOCTYPE html>
<html>
<head>
  <title>Account Update</title>
  <style>
    /* Center the container div */
    body, html {
        display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      text-align: center;
      background-color: darkblue;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    /* Style for the message */
    .message {
      font-size: 24px;
      color: white;
      margin-bottom: 20px;
      cursor: default;
    }

    /* Style for the button */
    .button {
      padding: 10px 20px;
      background-color: #f44336;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
      text-decoration: none;
    }

    /* Hover effect for the button */
    .button:hover {
      background-color: #e53935;
    }
  </style>
</head>
<body>
  <div class="container">
    <p class="message">You cannot access this page because some modifications made<br>into your account, try logging in.</p>
    <a class="button" href="index.php">Okay</a>
  </div>
</body>
</html>
