<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Leave Submission Status</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      background: linear-gradient(135deg, #e3f2fd, #90caf9);
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .status-card {
      background: white;
      padding: 30px 40px;
      border-radius: 20px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
      text-align: center;
      max-width: 500px;
      width: 90%;
    }
    .status-card h2 {
      color: #1a237e;
      margin-bottom: 20px;
      font-size: 1.6rem;
    }
    .status-card p {
      font-size: 1rem;
      color: #333;
      margin-bottom: 25px;
    }
    .btn {
      display: inline-block;
      background-color: #1a237e;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 25px;
      font-size: 1rem;
      transition: background 0.3s ease;
    }
    .btn:hover {
      background-color: #0d47a1;
    }
  </style>
</head>
<body>
  <div class="status-card">
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $conn = new mysqli("localhost", "root", "", "leavedb");
        if ($conn->connect_error) die("<h2>Connection Failed</h2><p>" . $conn->connect_error . "</p>");

        $rollNo = intval($_POST['rollNo']);
        $studentId = $conn->real_escape_string($_POST['studentId']);
        $student_name = $conn->real_escape_string($_POST['student_name']);
        $leave_type = $conn->real_escape_string($_POST['leave_type']);
        $reason = $conn->real_escape_string($_POST['reason']);
        $start_date = $conn->real_escape_string($_POST['start_date']);
        $end_date = $conn->real_escape_string($_POST['end_date']);
        $stay_option = $conn->real_escape_string($_POST['stay_option']);
        $parent_address = ($stay_option === 'With Parents') ? $conn->real_escape_string($_POST['parent_address']) : NULL;

        // ✅ Calculate actual number of days between start_date and end_date
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $interval = $start->diff($end);
        $calculated_days = $interval->days + 1;

        // ❌ If more than 10 days, block submission
        if ($calculated_days > 10) {
            echo "<h2>Leave Too Long ❌</h2>";
            echo "<p>You cannot apply for more than 10 days of leave. You selected <strong>{$calculated_days}</strong> days.</p>";
            echo '<a class="btn" href="leave_form.php">Go Back</a>';
            exit;
        }

        // ✅ Insert with validated no_of_days
        $sql = "INSERT INTO leave_requests (rollNo, studentId, student_name, leave_type, reason, start_date, end_date, no_of_days, stay_option, parent_address)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssssiss", $rollNo, $studentId, $student_name, $leave_type, $reason, $start_date, $end_date, $calculated_days, $stay_option, $parent_address);

        if ($stmt->execute()) {
            echo "<h2>Leave Request Submitted ✅</h2>";
            echo "<p>Your leave request has been successfully recorded for <strong>{$calculated_days}</strong> days.</p>";
        } else {
            echo "<h2>Error ❌</h2>";
            echo "<p>There was an error submitting your request: <br><strong>" . $stmt->error . "</strong></p>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<h2>Invalid Request ❌</h2>";
        echo "<p>This page can only be accessed through the form submission.</p>";
    }
    ?>
    <a class="btn" href="dashboard.php">Go Back to Dashboard</a>
  </div>
</body>
</html>
