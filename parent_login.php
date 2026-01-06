<!-- <!DOCTYPE html>
<html>
<head>
  <title>Parent Login</title>
</head>
<body>
  <h2>Parent Login</h2>
  <form action="parent_login_process.php" method="POST">
    <label for="fatherMobile">Father's Mobile Number:</label>
    <input type="text" name="fatherMobile" required><br><br>
    <input type="submit" value="Login">
  </form>
</body>
</html> -->
<!-- <!DOCTYPE html>
<html>
<head>
  <title>Parent Login</title>
</head>
<body>
  <h2>Parent Login</h2>
  <form action="parent_login_process.php" method="POST">
    <label for="fatherMobile">Father's Mobile Number:</label>
    <input type="text" name="fatherMobile" required><br><br>
    <input type="submit" value="Login">
  </form>
</body>
</html> -->




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Login | School Portal</title>
    <style>
    :root {
        --primary-color: #3498db;
        --secondary-color: #2980b9;
        --accent-color: #e74c3c;
        --light-color: #ecf0f1;
        --dark-color: #2c3e50;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #f5f7fa;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .login-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        padding: 40px;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .login-container:hover {
        transform: translateY(-5px);
    }

    .logo {
        width: 80px;
        height: 80px;
        margin-bottom: 20px;
        background-color: var(--primary-color);
        border-radius: 50%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 24px;
        font-weight: bold;
    }

    h2 {
        color: var(--dark-color);
        margin-bottom: 30px;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: var(--dark-color);
        font-weight: 500;
    }

    input[type="text"] {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        transition: border 0.3s ease;
    }

    input[type="text"]:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }

    .submit-btn {
        background-color: #1a237e;
        color: white;
        border: none;
        padding: 12px 20px;
        width: 100%;
        border-radius: 5px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 10px;
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


    .submit-btn:hover {
        background-color: #1a237e;
    }

    .footer {
        margin-top: 30px;
        font-size: 14px;
        color: #7f8c8d;
    }

    .footer a {
        color: var(--primary-color);
        text-decoration: none;
    }

    .footer a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <!-- Top Right Home Button -->
  <div class="top-right-btn">
    <a href="index.html">🏠Back to Home</a>
  </div>
    <div class="login-container">
        <h2>Parent Login</h2>
        <form action="parent_login_process.php" method="POST">
            <div class="form-group">
                <label for="fatherMobile">Father's Mobile Number</label>
                <input type="text" id="fatherMobile" name="fatherMobile" placeholder="Enter registered mobile number"
                    required>
            </div>
            <button type="submit" class="submit-btn">Login</button>
        </form>
        
    </div>
</body>

</html>