<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "leavedb");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$sql = "SELECT * FROM leave_requests ORDER BY applied_on DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head><title>Admin Dashboard</title></head>
<body>
<h2>Leave Requests</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Student</th>
        <th>Leave Type</th>
        <th>Reason</th>
        <th>From</th>
        <th>To</th>
        <th>No. of Days</th>
        <th>Stay Option</th>
        <th>Parent Address</th>
        <th>Parent Status</th>
        <th>HOD Status</th>
        <th>Final Status</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
            <td><?php echo htmlspecialchars($row['leave_type']); ?></td>
            <td><?php echo htmlspecialchars($row['reason']); ?></td>
            <td><?php echo htmlspecialchars($row['start_date']); ?></td>
            <td><?php echo htmlspecialchars($row['end_date']); ?></td>
            <td><?php echo htmlspecialchars($row['no_of_days']); ?></td>
            <td><?php echo htmlspecialchars($row['stay_option']); ?></td>
            <td><?php echo htmlspecialchars($row['parent_address']); ?></td>
            <td><?php echo htmlspecialchars($row['parent_status']); ?></td>
            <td><?php echo htmlspecialchars($row['hod_status']); ?></td>
            <td><?php echo htmlspecialchars($row['final_status']); ?></td>
            <td>
                <form action="approve_leave.php" method="POST" style="margin-bottom:5px;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                    <label>Parent Status:</label><br/>
                    <select name="parent_status" required>
                        <option value="Pending" <?php if($row['parent_status']=='Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Approved" <?php if($row['parent_status']=='Approved') echo 'selected'; ?>>Approve</option>
                        <option value="Rejected" <?php if($row['parent_status']=='Rejected') echo 'selected'; ?>>Reject</option>
                    </select><br/>
                    <button type="submit" name="action" value="update_parent">Update Parent</button>
                </form>
                <form action="approve_leave.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                    <label>HOD Status:</label><br/>
                    <select name="hod_status" required>
                        <option value="Pending" <?php if($row['hod_status']=='Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Approved" <?php if($row['hod_status']=='Approved') echo 'selected'; ?>>Approve</option>
                        <option value="Rejected" <?php if($row['hod_status']=='Rejected') echo 'selected'; ?>>Reject</option>
                    </select><br/>
                    <button type="submit" name="action" value="update_hod">Update HOD</button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>
<br/>
<a href="students.php">View Registered Students</a> | <a href="logout.php">Logout</a>
</body>
</html>

<?php $conn->close(); ?>
