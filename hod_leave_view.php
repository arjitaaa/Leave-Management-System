<?php
session_start();
if (!isset($_SESSION['hod_id'])) {
    header("Location: hod_login.php");
    exit;
}

$id = $_GET['id'];
$mysqli = new mysqli("localhost", "root", "", "leavedb");

// Get leave request
$stmt = $mysqli->prepare("SELECT * FROM leave_requests WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Fetch student details using rollNo
$studentStmt = $mysqli->prepare("SELECT * FROM student WHERE rollNo = ?");
$studentStmt->bind_param("i", $row['rollNo']);
$studentStmt->execute();
$studentResult = $studentStmt->get_result();
$student = $studentResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Leave Request Details</title>
  <style>
    body {
      margin: 0;
      padding: 0;
       background: linear-gradient(135deg, #e3f2fd, #90caf9);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .container {
      background-color: #ffffff;
      padding: 35px 40px;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 700px;
    }

    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 25px;
      font-size: 24px;
    }

    .detail {
      margin: 16px 0;
      font-size: 17px;
      line-height: 1.5;
    }

    .detail span {
      font-weight: 600;
      color: #555;
      display: inline-block;
      width: 180px;
    }

    form {
      display: flex;
      justify-content: center;
      gap: 25px;
      margin-top: 30px;
    }

    button {
      padding: 12px 24px;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s ease;
      color: #fff;
    }

    button[name="action"][value="approve"] {
      background-color: #28a745;
    }

    button[name="action"][value="approve"]:hover {
      background-color: #218838;
    }

    button[name="action"][value="reject"] {
      background-color: #dc3545;
    }

    button[name="action"][value="reject"]:hover {
      background-color: #c82333;
    }

    @media (max-width: 600px) {
      .container {
        padding: 25px;
      }

      .detail span {
        width: 100%;
        display: block;
        margin-bottom: 5px;
      }

      form {
        flex-direction: column;
        gap: 12px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Leave Request Details</h2>

    <!-- Student Info -->
    <div class="detail"><span>Student Name:</span> <?= htmlspecialchars($row['student_name']) ?></div>
    <div class="detail"><span>Roll No:</span> <?= htmlspecialchars($student['rollNo']) ?></div>
    <div class="detail"><span>Student ID:</span> <?= htmlspecialchars($student['studentId']) ?></div>
    <div class="detail"><span>Branch:</span> <?= htmlspecialchars($student['branch']) ?></div>
    <div class="detail"><span>Class:</span> <?= htmlspecialchars($student['class']) ?></div>
    <div class="detail"><span>Semester:</span> <?= htmlspecialchars($student['semester']) ?></div>
    <div class="detail"><span>Father's Name:</span> <?= htmlspecialchars($student['fatherName']) ?></div>
    <div class="detail"><span>Mobile:</span> <?= htmlspecialchars($student['mobile']) ?></div>

    <!-- Leave Info -->
    <div class="detail"><span>Reason:</span> <?= htmlspecialchars($row['reason']) ?></div>
    <div class="detail"><span>Leave Type:</span> <?= htmlspecialchars($row['leave_type']) ?></div>
    <div class="detail"><span>From - To:</span> <?= $row['start_date'] ?> to <?= $row['end_date'] ?></div>
    <div class="detail"><span>No. of Days:</span> <?= $row['no_of_days'] ?></div>
    <div class="detail"><span>Stay Option:</span> <?= htmlspecialchars($row['stay_option']) ?></div>

    <form action="hod_approve.php" method="POST">
      <input type="hidden" name="id" value="<?= $row['id'] ?>">
      <button name="action" value="approve">Approve</button>
      <button name="action" value="reject">Reject</button>
    </form>
  </div>
</body>
</html>
