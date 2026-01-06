<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>HOD Login</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(135deg, #e3f2fd, #90caf9);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

     /* Top-right back button */
    .top-right-btn {
      position: absolute;
      top: 20px;
      right: 20px;
      z-index: 999;
    }

    .top-right-btn a {
      background-color: #1a237e;
      color: white;
      padding: 10px 16px;
      border-radius: 25px;
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      transition: background-color 0.3s ease;
    }

    .top-right-btn a:hover {
      background-color: #0d47a1;
    }

    .login-container {
      background-color: #ffffff;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    .login-container h2 {
      margin-bottom: 25px;
      color: #333;
      font-size: 26px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px 14px;
      margin: 10px 0 20px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      transition: border 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      border-color: #74ebd5;
      outline: none;
    }

    button[type="submit"] {
      background-color: #1a237e;
      color: #fff;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
      background-color: # #1a237e;
    }
  </style>
</head>
<body>
   <!-- Top Right Home Button -->
  <div class="top-right-btn">
    <a href="index.html">🏠Back to Home</a>
  </div>
  <div class="login-container">
    <h2>HOD Login</h2>
    <form method="POST" action="hod_login_process.php">
      <input type="text" name="hod_id" placeholder="Enter HOD ID" required>
      <input type="password" name="password" placeholder="Enter Password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
