<?php
session_start();
if (!isset($_SESSION['hod_id'])) {
    header("Location: hod_login.php");
    exit;
}

$mysqli = new mysqli("localhost", "root", "", "leavedb");
$result = $mysqli->query("SELECT * FROM leave_requests WHERE parent_status='Approved' AND hod_status='Pending'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>HOD Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }

    body {
      margin: 0;
      background: linear-gradient(135deg, #e3f2fd, #90caf9);
      padding: 30px 20px;
    }

    .top-bar {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }

    .btn {
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.3s ease;
      text-decoration: none;
      margin: 5px;
    }

    .logout-btn {
      background-color: #ef4444;
      color: white;
    }

    .logout-btn:hover {
      background-color: #dc2626;
    }

    .history-btn {
      background-color:  #1e3a8a;
      color: white;
    }

    .history-btn:hover {
      background-color:  #1e3a8a;
    }

    .container {
      max-width: 1000px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .welcome {
      text-align: center;
      margin-bottom: 30px;
      font-size: 20px;
      color: #1e3a8a;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th, td {
      padding: 14px;
      text-align: center;
      border-bottom: 1px solid #1a237e;
    }

    th {
      background-color: #1a237e;
      color: white;
      text-transform: uppercase;
      font-weight: 600;
    }

    td {
      background-color: #f9fafb;
    }

    a.view-link {
      color: #1a237e;
      text-decoration: none;
      font-weight: 500;
    }

    a.view-link:hover {
      text-decoration: underline;
    }

     .action-link {
      display: inline-flex;
      align-items: center;
      background-color: #1a237e;
      color: white;
      padding: 8px 14px;
      border-radius: 30px;
      text-decoration: none;
      font-size: 0.9rem;
      transition: background 0.3s ease;
    }

    .action-link:hover {
      background-color: #1a237e;
    }

    @media (max-width: 768px) {
      .top-bar {
        justify-content: center;
      }

      table, thead, tbody, th, td, tr {
        display: block;
      }

      th {
        position: absolute;
        top: -9999px;
        left: -9999px;
      }

      tr {
        background-color: #f9fafb;
        border: 1px solid #ddd;
        margin-bottom: 10px;
        padding: 10px;
      }

      td {
        padding-left: 50%;
        position: relative;
      }

      td:before {
        position: absolute;
        top: 14px;
        left: 14px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        font-weight: bold;
        color: #555;
      }

      td:nth-of-type(1):before { content: "Roll No"; }
      td:nth-of-type(2):before { content: "Student Name"; }
      td:nth-of-type(3):before { content: "Class"; }
      td:nth-of-type(4):before { content: "Leave Type"; }
      td:nth-of-type(5):before { content: "View"; }
    }
  </style>
</head>
<body>

  <div class="top-bar">
    <a href="hod_leave_history.php" class="btn history-btn">📅 View Leave History</a>
    <form action="hod_logout.php" method="POST" style="margin: 0;">
      <button class="btn logout-btn" type="submit">Logout</button>
    </form>
  </div>

  <div class="container">
     <h1 class="title">HOD Dashboard</h1>
    <div class="welcome">Welcome HOD: <?= htmlspecialchars($_SESSION['hod_id']) ?></div>

    <table>
  <thead>
    <tr>
      <th>Roll No</th>
      <th>Student Name</th>
      <th>Student ID</th> <!-- Used in place of class -->
      <th>Leave Type</th>
      <th>View</th>
    </tr>
  </thead>
  <tbody>
    <?php while($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?= htmlspecialchars($row['rollNo']) ?></td>
        <td><?= htmlspecialchars($row['student_name']) ?></td>
        <td><?= htmlspecialchars($row['studentId']) ?></td>
        <td><?= htmlspecialchars($row['leave_type']) ?></td>
        
         <td>
              <a href="hod_leave_view.php?id=<?= $row['id'] ?>" class="action-link">
                <i class="fas fa-eye"></i>&nbsp; View
              </a>
            </td>
      </tr>
      
    <?php } ?>
  </tbody>
</table>
  </div>

</body>
</html>
