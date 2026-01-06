<?php
session_start();
if (!isset($_SESSION['hod_id'])) {
    header("Location: hod_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "leavedb");

$sql = "SELECT DISTINCT DATE_FORMAT(applied_on, '%Y-%m') AS month
        FROM leave_requests
        WHERE parent_status = 'Approved' AND hod_status = 'Approved'
        ORDER BY month DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>HOD Leave History</title>
  <style>
    /* ---------- Base ---------- */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #f0f4f8, #dfe9f3);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px 20px;
    }

    /* ---------- Header ---------- */
    .header {
      width: 100%;
      max-width: 1000px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }
    .header a {
      text-decoration: none;
      padding: 12px 20px;
      border-radius: 10px;
      font-weight: bold;
      transition: 0.3s ease;
    }
    .dash-btn       { background:rgb(11, 162, 244); color: #fff; }
    .dash-btn:hover { background: #e63946; }
    .dl-btn         { background: #457b9d; color: #fff; }
    .dl-btn:hover   { background: #1d3557; }

    /* ---------- Title ---------- */
    h2 {
      color: #1d3557;
      margin-bottom: 30px;
      font-size: 32px;
      text-align: center;
    }

    /* ---------- Month Grid ---------- */
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      width: 100%;
      max-width: 1000px;
    }
    .card {
      background: rgba(255, 255, 255, 0.6);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 30px 20px;
      text-align: center;
      font-size: 18px;
      font-weight: 500;
      color: #1d3557;
      text-decoration: none;
      box-shadow: 0 8px 24px rgba(28, 164, 78, 0.08);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }

    /* ---------- Responsive ---------- */
    @media (max-width: 600px) {
      h2            { font-size: 24px; }
      .header a     { font-size: 14px; padding: 10px 14px; }
      .card         { font-size: 16px; }
    }
  </style>
</head>
<body>

  <!-- Top bar -->
  <div class="header">
    <a class="dash-btn" href="hod_dashboard.php"> ⬅Back to Dashboard</a>
    <a class="dl-btn" href="export_month_csv.php?month=<?= date('Y-m') ?>">⬇️ Download CSV</a>
  </div>

  <!-- Page title -->
  <h2>Leave History by Month</h2>

  <!-- Month cards -->
  <div class="grid">
    <?php while ($row = $result->fetch_assoc()):
      $month = $row['month'];
      $monthFormatted = date("F Y", strtotime($month));
    ?>
      <a class="card" href="hod_leave_month.php?month=<?= $month ?>">📅 <?= $monthFormatted ?></a>
    <?php endwhile; ?>
  </div>

</body>
</html>
