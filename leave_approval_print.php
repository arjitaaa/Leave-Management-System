<?php
$conn = new mysqli("localhost", "root", "", "leavedb");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (!isset($_GET['id'])) {
    echo "No leave ID specified.";
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM leave_requests WHERE id = ? AND parent_status = 'Approved' AND hod_status = 'Approved'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Leave not found or not approved yet.";
    exit;
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Leave Approval Print</title>
  <style>
    @media print {
      button {
        display: none;
      }
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f0f4f8;
      margin: 0;
      padding: 40px 20px;
    }

    .print-container {
      background: white;
      max-width: 800px;
      margin: auto;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      border-top: 8px solid #1a237e;
    }

    h2 {
      text-align: center;
      color: #1a237e;
      margin-bottom: 30px;
      font-size: 28px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    td {
      padding: 14px 12px;
      border-bottom: 1px solid #e0e0e0;
      font-size: 15px;
    }

    tr:nth-child(even) {
      background-color: #f9fbfd;
    }

    td:first-child {
      font-weight: 600;
      color: #333;
      width: 35%;
    }

    td:last-child {
      color: #444;
    }

    .print-btn {
      text-align: center;
      margin-top: 30px;
    }

    button {
      background: #1a237e;
      color: white;
      padding: 12px 30px;
      font-size: 16px;
      border: none;
      border-radius: 30px;
      cursor: pointer;
      transition: background 0.3s;
    }

    button:hover {
      background-color: #0d47a1;
    }
  </style>
</head>
<body>
  <div class="print-container">
    <h2>Leave Approval Summary</h2>
    <table>
      <tr><td>Student ID</td><td><?= $row['studentId'] ?></td></tr>
      <tr><td>Student Name</td><td><?= $row['student_name'] ?></td></tr>
      <tr><td>Leave Type</td><td><?= $row['leave_type'] ?></td></tr>
      <tr><td>Reason</td><td><?= $row['reason'] ?></td></tr>
      <tr><td>From</td><td><?= $row['start_date'] ?></td></tr>
      <tr><td>To</td><td><?= $row['end_date'] ?></td></tr>
      <tr><td>No. of Days</td><td><?= $row['no_of_days'] ?></td></tr>
      <tr><td>Stay Option</td><td><?= $row['stay_option'] ?></td></tr>
      <tr><td>Parent Address</td><td><?= $row['parent_address'] ?></td></tr>
      <tr><td>Parent Approval</td><td><?= $row['parent_status'] ?></td></tr>
      <tr><td>HOD Approval</td><td><?= $row['hod_status'] ?></td></tr>
      <tr><td>Final Status</td><td><?= $row['final_status'] ?></td></tr>
      <tr><td>Applied On</td><td><?= date('d-m-Y H:i A', strtotime($row['applied_on'])) ?></td></tr>
    </table>

    <div class="print-btn">
      <button onclick="window.print()">🖨️ Print This Page</button>
    </div>
  </div>
</body>
</html>
