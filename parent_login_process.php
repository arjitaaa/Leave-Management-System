<?php
session_start();
$conn = new mysqli("localhost", "root", "", "leavedb");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$fatherMobile = $_POST['fatherMobile'];

$sql = "SELECT * FROM student WHERE fatherMobile = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $fatherMobile);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $student = $result->fetch_assoc();
  $_SESSION['fatherMobile'] = $fatherMobile;
  $_SESSION['rollNo'] = $student['rollNo'];
  header("Location: parent_dashboard.php");
} else {
  echo "Invalid Mobile Number.";
}

$conn->close();
?>
