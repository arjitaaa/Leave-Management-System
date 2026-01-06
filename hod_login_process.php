<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "leavedb");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$hod_id = $_POST['hod_id'];
$password = $_POST['password'];

$stmt = $mysqli->prepare("SELECT password FROM hods WHERE hod_id = ?");
$stmt->bind_param("s", $hod_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($stored_password);
    $stmt->fetch();

    if ($password === $stored_password) {
        $_SESSION['hod_id'] = $hod_id;
        header("Location: hod_dashboard.php");
        exit;
    } else {
        echo "❌ Invalid HOD ID or password.";
    }
} else {
    echo "❌ Invalid HOD ID or password.";
}

$stmt->close();
$mysqli->close();
?>
