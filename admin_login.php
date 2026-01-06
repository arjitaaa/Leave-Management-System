<!DOCTYPE html>
<html lang="en">
<head><title>Admin Login</title></head>
<body>
<h2>Admin Login</h2>
<form action="admin_login.php" method="POST">
  Username: <input type="text" name="username" required /><br/>
  Password: <input type="password" name="password" required /><br/>
  <button type="submit">Login</button>
</form>
</body>
</html>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // For demo, hardcoded admin credentials
    $adminUser = "admin";
    $adminPass = "admin123";

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $adminUser && $password === $adminPass) {
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Invalid admin credentials. <a href='admin_login.php'>Try again</a>";
    }
} else {
    // Display form if GET request
    include 'admin_login.html';
}
?>
