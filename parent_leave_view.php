<?php
session_start();
if (!isset($_SESSION['fatherMobile'])) {
  header("Location: parent_login.php");
  exit();
}

$conn = new mysqli("localhost", "root", "", "leavedb");
$id = $_GET['id'];

$sql = "SELECT * FROM leave_requests WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$leave = $result->fetch_assoc();
?>


<!-- <h2>Leave Request Details</h2>
<p><strong>Student:</strong> <?= $leave['student_name'] ?></p>
<p><strong>Type:</strong> <?= $leave['leave_type'] ?></p>
<p><strong>Reason:</strong> <?= $leave['reason'] ?></p>
<p><strong>From:</strong> <?= $leave['start_date'] ?></p>
<p><strong>To:</strong> <?= $leave['end_date'] ?></p>

<form action="parent_approve.php" method="POST">
    <input type="hidden" name="id" value="<?= $leave['id'] ?>">
    <label>
        <input type="radio" name="parent_approval" value="Approved" required> Approve
    </label>
    <label>
        <input type="radio" name="parent_approval" value="Rejected"> Reject
    </label><br><br>
    <input type="submit" value="Submit Decision">
</form> -->


<div class="leave-request-container">
    <h2 class="leave-request-title">Leave Request Details</h2>

    <div class="leave-details">
        <div class="detail-row">
            <span class="detail-label">Student:</span>
            <span class="detail-value"><?= $leave['student_name'] ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Type:</span>
            <span class="detail-value"><?= $leave['leave_type'] ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Reason:</span>
            <span class="detail-value"><?= $leave['reason'] ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">From:</span>
            <span class="detail-value"><?= $leave['start_date'] ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">To:</span>
            <span class="detail-value"><?= $leave['end_date'] ?></span>
        </div>
    </div>

    <form action="parent_approve.php" method="POST" class="approval-form">
        <input type="hidden" name="id" value="<?= $leave['id'] ?>">

        <div class="approval-options">
            <div class="radio-option">
                <input type="radio" id="approve" name="parent_approval" value="Approved" required>
                <label for="approve">Approve</label>
            </div>
            <div class="radio-option">
                <input type="radio" id="reject" name="parent_approval" value="Rejected">
                <label for="reject">Reject</label>
            </div>
        </div>

        <button type="submit" class="submit-button">Submit Decision</button>
    </form>
</div>

<style>
.leave-request-container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-family: Arial, sans-serif;
}

.leave-request-title {
    color: #2c3e50;
    text-align: center;
    margin-bottom: 20px;
}

.detail-row {
    margin-bottom: 10px;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.detail-label {
    font-weight: bold;
    color: #34495e;
    width: 100px;
    display: inline-block;
}

.detail-value {
    color: #7f8c8d;
}

.approval-form {
    margin-top: 25px;
}

.approval-options {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.radio-option {
    display: flex;
    align-items: center;
}

.radio-option input {
    margin-right: 8px;
}

.submit-button {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
}

.submit-button:hover {
    background-color: #2980b9;
}
</style>