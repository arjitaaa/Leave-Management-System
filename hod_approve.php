<?php
session_start();
if (!isset($_SESSION['hod_id'])) {
    header("Location: hod_login.php");
    exit;
}

$mysqli = new mysqli("localhost", "root", "", "leavedb");

$id = $_POST['id'];
$action = $_POST['action'];
$hod_status = ($action == 'approve') ? 'Approved' : 'Rejected';

// Get current parent status
$stmt = $mysqli->prepare("SELECT parent_status FROM leave_requests WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($parent_status);
$stmt->fetch();
$stmt->close();

if ($parent_status !== 'Approved') {
    echo "Parent has not approved yet. HOD cannot act.";
    exit;
}

// Determine final status based on HOD decision
if ($hod_status === 'Approved') {
    $final_status = 'Approved';
} else {
    $final_status = 'Rejected';
}

// Update HOD status and final status
$stmt = $mysqli->prepare("UPDATE leave_requests SET hod_status = ?, final_status = ? WHERE id = ?");
$stmt->bind_param("ssi", $hod_status, $final_status, $id);

if ($stmt->execute()) {
    $stmt->close();
    $mysqli->close();
    header("Location: hod_dashboard.php");
    exit;
} else {
    echo "Error updating status: " . $stmt->error;
    $stmt->close();
    $mysqli->close();
    exit;
}
?>
