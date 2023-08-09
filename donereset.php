<?php

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Senior Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
<link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="img/sslogo.png">
    <style>
        
        .container {
    width: 400px;
    margin: 100px auto;
    text-align: center;
    background-color: #ffffff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    flex-direction: column;
    align-items: center;
}
h1 {
    font-size: 28px;
    margin-bottom: 20px;
    color: #333333;
}

p {
    font-size: 18px;
    color: #555555;
}

#continue-btn {
    padding: 12px 24px;
    background-color: #3A86FB;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

#continue-btn:hover {
    background-color: #6BA4FC;
}

body {
    background-color: #5478FD;
    font-family: Arial, sans-serif;
    margin: 0;
}
.container h1 {
    font-weight: bold;
}

.container p {
    line-height: 1.4;
}

#continue-btn {
    width: 100%;
    max-width: 200px;
}
.container i {
  font-size: 70px;
  color: #4070f4;
}
    </style>
</head>
<body>
<div class="container">
        <i class="fa-regular fa-circle-check"></i>
        <h1>Password has been reset!</h1>
        <p>We are excited to have you on board.</p>
        <button id="continue-btn">Continue</button>
    </div>

    <script>
        document.getElementById('continue-btn').addEventListener('click', function() {
    window.location.href = 'homepage/homelog.php';
});
    </script>
</body>
</html>