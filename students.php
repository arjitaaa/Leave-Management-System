<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "leavedb");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$sql = "SELECT rollNo, studentId, firstName, lastName, branch, class, semester, email FROM student ORDER BY rollNo ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head><title>Registered Students</title></head>
<body>
<h2>Registered Students</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Roll No</th>
        <th>Student ID</th>
        <th>Name</th>
        <th>Branch</th>
        <th>Class</th>
        <th>Semester</th>
        <th>Email</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['rollNo']); ?></td>
        <td><?php echo htmlspecialchars($row['studentId']); ?></td>
        <td><?php echo htmlspecialchars($row['firstName'] . " " . $row['lastName']); ?></td>
        <td><?php echo htmlspecialchars($row['branch']); ?></td>
        <td><?php echo htmlspecialchars($row['class']); ?></td>
        <td><?php echo htmlspecialchars($row['semester']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
    </tr>
    <?php } ?>
</table>
<br/>
<a href="admin_dashboard.php">Back to Dashboard</a> | <a href="logout.php">Logout</a>
</body>
</html>

<?php
$conn->close();
?>
