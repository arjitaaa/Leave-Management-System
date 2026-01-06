<?php
session_start();
if (!isset($_SESSION['fatherMobile'])) {
    header("Location: parent_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "leavedb");
$rollNo = $_SESSION['rollNo'];

$sql = "SELECT * FROM leave_requests WHERE rollNo = ? AND parent_approval = 'Pending'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $rollNo);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Parent Dashboard | Pending Requests</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    :root {
      --primary: #1a237e;
      --secondary: #1a237e;
      --accent: #f8bbd0;
      --light-bg: #fce4ec;
      --white: #ffffff;
      --text: #333;
      --success: #66bb6a;
      --danger: #ef5350;
      --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      --radius: 15px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #e3f2fd, #90caf9);
      padding: 40px 20px;
      color: var(--text);
    }

    .container {
      max-width: 1200px;
      margin: auto;
    }

    .title {
      text-align: center;
      font-size: 2.2rem;
      color: var(--primary);
      margin-bottom: 30px;
      position: relative;
    }

    .title::after {
      content: '';
      width: 80px;
      height: 4px;
      background-color: var(--secondary);
      display: block;
      margin: 10px auto 0;
      border-radius: 2px;
    }

    .dashboard-actions {
      text-align: center;
      margin: 30px 0;
    }

    .btn {
      display: inline-block;
      background-color: var(--primary);
      color: white;
      padding: 12px 24px;
      margin: 10px;
      border: none;
      border-radius: 50px;
      text-decoration: none;
      font-size: 1rem;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn:hover {
      background-color: var(--secondary);
      transform: translateY(-2px);
    }
  

    .requests-table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      border-radius: var(--radius);
      overflow: hidden;
      box-shadow: var(--shadow);
    }

    .requests-table thead {
      background-color: var(--primary);
      color: white;
    }

    .requests-table th, .requests-table td {
      padding: 16px;
      text-align: left;
    }

    .requests-table tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      color: white;
      font-weight: 500;
    }

    .badge-academic { background-color:rgb(52, 26, 224); }
    .badge-summerdiwali { background-color:rgb(232, 19, 153); }
    .badge-emergency { background-color: #ffa000; color: #222; }
    .badge-casual { background-color:rgb(139, 142, 144); }

    .action-link {
      display: inline-flex;
      align-items: center;
      background-color: var(--secondary);
      color: white;
      padding: 8px 14px;
      border-radius: 30px;
      text-decoration: none;
      font-size: 0.9rem;
      transition: background 0.3s ease;
    }

    .action-link:hover {
      background-color: var(--primary);
    }

    .empty-state {
      text-align: center;
      padding: 40px;
      background-color: var(--white);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      margin-top: 20px;
    }

    .empty-state i {
      font-size: 3rem;
      color: #ccc;
      margin-bottom: 10px;
    }

    @media (max-width: 768px) {
      .requests-table th, .requests-table td {
        padding: 12px 10px;
      }

      .btn {
        width: 100%;
        margin: 8px 0;
      }

      .dashboard-actions {
        display: flex;
        flex-direction: column;
        align-items: center;
      }
    }

    @media (max-width: 768px) {
  .title {
    font-size: 1.6rem;
  }

  .requests-table thead {
    display: none;
  }

  .requests-table, .requests-table tbody, .requests-table tr, .requests-table td {
    display: block;
    width: 100%;
  }

  .requests-table tr {
    margin-bottom: 15px;
    background-color: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 10px;
  }

  .requests-table td {
    text-align: right;
    padding: 10px 15px;
    position: relative;
  }

  .requests-table td::before {
    content: attr(data-label);
    position: absolute;
    left: 15px;
    top: 10px;
    font-weight: bold;
    color: var(--primary);
    text-align: left;
  }

  .btn {
    width: 100%;
    margin: 8px 0;
    text-align: center;
  }

  .dashboard-actions {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .empty-state {
    padding: 30px 20px;
  }
}

  </style>
</head>
<body>

  <div class="container">
    <h1 class="title">Parent Dashboard</h1>
    <h1 class="title">Pending Leave Requests</h1>

    <?php if ($result->num_rows > 0): ?>
    <div class="table-container">
      <table class="requests-table">
        <thead>
          <tr>
            <th>Student Name</th>
            <th>Leave Type</th>
            <th>From</th>
            <th>To</th>
            <th>Reason</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['student_name']) ?></td>
            <td>
              <span class="badge badge-<?= strtolower(explode(' ', $row['leave_type'])[0]) ?>">
                <?= htmlspecialchars($row['leave_type']) ?>
              </span>
            </td>
            <td><?= date('M d, Y', strtotime($row['start_date'])) ?></td>
            <td><?= date('M d, Y', strtotime($row['end_date'])) ?></td>
            <td><?= htmlspecialchars(substr($row['reason'], 0, 30)) . (strlen($row['reason']) > 30 ? '...' : '') ?></td>
            <td>
              <a href="parent_leave_view.php?id=<?= $row['id'] ?>" class="action-link">
                <i class="fas fa-eye"></i>&nbsp; View
              </a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <?php else: ?>
    <div class="empty-state">
      <i class="far fa-check-circle"></i>
      <h3>No Pending Requests</h3>
      <p>There are currently no leave requests waiting for your approval.</p>
    </div>
    <?php endif; ?>
        
    <div class="dashboard-actions">
      <a href="parent_leave_history.php" class="btn"><i class="fas fa-history"></i> View Leave History</a>
      <a href="parent_logout.php" class="btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
  </div>

</body>
</html>
