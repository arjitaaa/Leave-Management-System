<?php
session_start();
if (!isset($_SESSION['fatherMobile']) || !isset($_SESSION['rollNo'])) {
    header("Location: parent_login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "leavedb");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$rollNo = $_SESSION['rollNo'];

$sql = "SELECT * FROM leave_requests WHERE rollNo = ? ORDER BY applied_on DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $rollNo);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Child's Leave History</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #e3f2fd, #90caf9);
      font-family: 'Poppins', sans-serif;
      padding: 40px 20px;
    }

    .container {
      max-width: 95%;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #1a237e;
      margin-bottom: 25px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      border: 1px solid #f1f8ff;
      padding: 10px;
      text-align: center;
      font-size: 14px;
    }

    th {
      background-color: #90caf9; ;
      color:  #1a237e;
    }

    tr:nth-child(even) {
      background-color:  #f1f8ff;
    }

    tr:hover {
      background-color:  #f1f8ff;
    }

    .back-btn {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      padding: 12px 20px;
      background-color: #1a237e;
      color: white;
      border-radius: 30px;
      transition: background 0.3s ease;
    }

    .back-btn:hover {
      background-color: #1a237e;
    }

    @media screen and (max-width: 768px) {
  table, thead, tbody, th, td, tr {
    display: block;
    width: 100%;
  }

  thead {
    display: none;
  }

  tr {
    margin-bottom: 20px;
    background: #fff;
    padding: 15px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
  }

  td {
    padding: 12px 10px 12px 120px;
    position: relative;
    text-align: left;
    border: none;
    background: none;
    font-size: 14px;
    border-bottom: 1px solid #f3c5d0;
  }

  td:last-child {
    border-bottom: none;
  }

  td::before {
    content: attr(data-label);
    position: absolute;
    left: 15px;
    top: 12px;
    font-weight: 600;
    color: #880e4f;
    width: 100px;
    white-space: nowrap;
  }

  .back-btn {
    width: 100%;
    margin-top: 30px;
  }
}
  </style>
</head>
<body>
  <div class="container">
    <h2>Your Child's Leave History</h2>
    <table>
      <thead>
        <tr>
          <th>Leave Type</th>
          <th>Reason</th>
          <th>From</th>
          <th>To</th>
          <th>No. of Days</th>
          <th>Stay Option</th>
          <th>Parent Status</th>
          <th>HOD Status</th>
          <th>Final Status</th>
          <th>Applied On</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td data-label="Leave Type"><?php echo htmlspecialchars($row['leave_type']); ?></td>
            <td data-label="Reason"><?php echo htmlspecialchars($row['reason']); ?></td>
            <td data-label="From"><?php echo htmlspecialchars($row['start_date']); ?></td>
            <td data-label="To"><?php echo htmlspecialchars($row['end_date']); ?></td>
            <td data-label="Days"><?php echo htmlspecialchars($row['no_of_days']); ?></td>
            <td data-label="Stay Option"><?php echo htmlspecialchars($row['stay_option']); ?></td>
            <td data-label="Parent Status"><?php echo htmlspecialchars($row['parent_status']); ?></td>
            <td data-label="HOD Status"><?php echo htmlspecialchars($row['hod_status']); ?></td>
            <td data-label="Final Status"><?php echo htmlspecialchars($row['final_status']); ?></td>
            <td data-label="Applied On"><?php echo htmlspecialchars($row['applied_on']); ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <div style="text-align: center;">
      <a href="parent_dashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>
  </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
