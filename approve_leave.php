<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "leavedb");
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $id = intval($_POST['id']);
    $action = $_POST['action'];

    if ($action === 'update_parent' && isset($_POST['parent_status'])) {
        $parent_status = $_POST['parent_status'];

        // Update parent_status
        $stmt = $conn->prepare("UPDATE leave_requests SET parent_status = ? WHERE id = ?");
        $stmt->bind_param("si", $parent_status, $id);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'update_hod' && isset($_POST['hod_status'])) {
        $hod_status = $_POST['hod_status'];

        // Update hod_status
        $stmt = $conn->prepare("UPDATE leave_requests SET hod_status = ? WHERE id = ?");
        $stmt->bind_param("si", $hod_status, $id);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Invalid action or missing status.";
        exit;
    }

    // Now check both statuses to update final_status
    $stmt = $conn->prepare("SELECT parent_status, hod_status FROM leave_requests WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($parent_status_db, $hod_status_db);
    $stmt->fetch();
    $stmt->close();

    $final_status = "Pending";

    if ($parent_status_db === 'Approved' && $hod_status_db === 'Approved') {
        $final_status = "Approved";
    } elseif ($parent_status_db === 'Rejected' || $hod_status_db === 'Rejected') {
        $final_status = "Rejected";
    }

    // Update final status
    $stmt = $conn->prepare("UPDATE leave_requests SET final_status = ? WHERE id = ?");
    $stmt->bind_param("si", $final_status, $id);
    $stmt->execute();
    $stmt->close();

    $conn->close();
    header("Location: admin_dashboard.php");
    exit;
} else {
    echo "Invalid request.";
}
?>
