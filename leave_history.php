<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}

$conn = new mysqli("localhost", "root", "", "leavedb");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT rollNo FROM student WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($rollNo);
$stmt->fetch();
$stmt->close();

if (!$rollNo) {
    echo "No student found.";
    exit;
}

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
  <title>Leave History</title>
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
      border: 1px solid #cfd8dc;
      padding: 10px;
      text-align: center;
      font-size: 14px;
    }

    th {
      background-color: #90caf9;
      color: #1a237e;
    }

    tr:nth-child(even) {
      background-color: #f1f8ff;
    }

    tr:hover {
      background-color: #e3f2fd;
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
      background-color: #0d47a1;
    }

    .view-link {
      display: inline-block;
      margin-top: 6px;
      background: #4caf50;
      color: white;
      padding: 6px 10px;
      border-radius: 5px;
      font-size: 13px;
      text-decoration: none;
    }

    .view-link:hover {
      background: #388e3c;
    }

    @media screen and (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }
      thead {
        display: none;
      }
      tr {
        margin-bottom: 15px;
        background: #f9f9f9;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      }
      td {
        padding: 10px 5px;
        position: relative;
        text-align: left;
      }
      td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        top: 10px;
        font-weight: bold;
        color: #0d47a1;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Student Leave History</h2>
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
            <td data-label="Applied On">
              <?php echo htmlspecialchars($row['applied_on']); ?>
              <?php if ($row['parent_status'] === 'Approved' && $row['hod_status'] === 'Approved'): ?>
                <br><a href="leave_approval_print.php?id=<?= $row['id'] ?>" class="view-link">🖨️ Print</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <div style="text-align: center;">
      <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>
  </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
