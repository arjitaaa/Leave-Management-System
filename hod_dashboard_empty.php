<?php
session_start();
if (!isset($_SESSION['hod_id'])) {
    header("Location: hod_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>HOD Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f4f8;
      display: flex;
      height: 100vh;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }
    .message {
      font-size: 24px;
      margin-bottom: 20px;
      color: #333;
    }
    form button {
      background-color: #4b79a1;
      border: none;
      padding: 10px 20px;
      color: white;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
    }
    form button:hover {
      background-color: #355c7d;
    }
  </style>
</head>
<body>
  <div class="message">No leave requests pending approval.</div>
  <form action="hod_logout.php" method="POST">
    <button type="submit">Logout</button>
  </form>
</body>
</html>
