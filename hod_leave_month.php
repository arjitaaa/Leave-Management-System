<?php
session_start();
if (!isset($_SESSION['hod_id'])) {
    header("Location: hod_login.php");
    exit;
}

$mysqli = new mysqli("localhost", "root", "", "leavedb");

if (isset($_GET['month'])) {
    $month = $_GET['month']; // e.g., '2025-06'

    $stmt = $mysqli->prepare("
        SELECT 
            lr.*, 
            s.class AS course, 
            s.branch, 
            s.semester 
        FROM leave_requests lr
        JOIN student s ON lr.rollNo = s.rollNo
        WHERE lr.hod_status = 'Approved' 
          AND DATE_FORMAT(lr.applied_on, '%Y-%m') = ?
    ");
    $stmt->bind_param("s", $month);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Monthly Leave Records</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #dfe9f3, #ffffff);
    }

    .container {
      max-width: 1200px;
      margin: 50px auto;
      background-color: #ffffff;
      padding: 30px 40px;
      border-radius: 16px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
      overflow-x: auto;
    }

    h2 {
      text-align: center;
      color: #1e40af;
      font-size: 26px;
      margin-bottom: 30px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
    }

    th, td {
      padding: 14px 12px;
      border: 1px solid #e2e8f0;
      text-align: center;
      vertical-align: middle;
    }

    th {
      background-color: #2563eb;
      color: #ffffff;
      font-weight: 600;
    }

    tr:nth-child(even) {
      background-color: #f9fafb;
    }

    tr:hover {
      background-color: #e0f2fe;
      transition: background-color 0.3s ease;
    }

    .button-group {
      margin-top: 30px;
      text-align: center;
    }

    .button-group a {
      background: #1f2937;
      color: white;
      padding: 12px 24px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 500;
      margin: 0 10px;
      transition: background 0.3s ease;
      display: inline-block;
    }

    .button-group a:hover {
      background: #111827;
    }

    .no-data {
      text-align: center;
      font-size: 16px;
      color: #6b7280;
      margin-top: 40px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Leave Requests for <?= date('F Y', strtotime($month . '-01')) ?></h2>

    <?php if (isset($result) && $result->num_rows > 0) { ?>
      <table>
        <thead>
          <tr>
            <th>Roll No</th>
            <th>Student ID</th>
            <th>Name</th>
            <th>Course</th>
            <th>Branch</th>
            <th>Semester</th>
            <th>Leave Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>No. of Days</th>
            <th>Stay Option</th>
            <th>Reason</th>
            <th>Applied On</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
              <td><?= htmlspecialchars($row['rollNo']) ?></td>
              <td><?= htmlspecialchars($row['studentId']) ?></td>
              <td><?= htmlspecialchars($row['student_name']) ?></td>
              <td><?= htmlspecialchars($row['course']) ?></td>
              <td><?= htmlspecialchars($row['branch']) ?></td>
              <td><?= htmlspecialchars($row['semester']) ?></td>
              <td><?= htmlspecialchars($row['leave_type']) ?></td>
              <td><?= htmlspecialchars($row['start_date']) ?></td>
              <td><?= htmlspecialchars($row['end_date']) ?></td>
              <td><?= htmlspecialchars($row['no_of_days']) ?></td>
              <td><?= htmlspecialchars($row['stay_option']) ?></td>
              <td><?= htmlspecialchars($row['reason']) ?></td>
              <td><?= htmlspecialchars($row['applied_on']) ?></td>
              <td><?= htmlspecialchars($row['hod_status']) ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p class="no-data">No approved leave requests found for this month.</p>
    <?php } ?>

    <div class="button-group">
      <a href="hod_leave_history.php">⬅ Back to Leave History</a>
      <a href="hod_dashboard.php"> Go to Dashboard</a>
    </div>
  </div>
</body>
</html>
