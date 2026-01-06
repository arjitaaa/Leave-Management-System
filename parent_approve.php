<?php
session_start();
if (!isset($_SESSION['fatherMobile'])) {
    header("Location: parent_login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "leavedb");

$id = $_POST['id'];
$approval = $_POST['parent_approval'];

$sql = "UPDATE leave_requests SET parent_approval = ?, parent_status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $approval, $approval, $id);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decision Submitted</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --primary-color: #1a237e;
        --secondary-color: #1a237e;
        --success-color: #4cc9f0;
        --danger-color: #f72585;
        --light-color: #f8f9fa;
        --dark-color: #212529;
        --border-radius: 8px;
        --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background: linear-gradient(135deg, #e3f2fd, #90caf9);
        color: var(--dark-color);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        line-height: 1.6;
    }

    .confirmation-container {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 3rem;
        max-width: 600px;
        width: 90%;
        text-align: center;
    }

    .confirmation-icon {
        font-size: 5rem;
        margin-bottom: 1.5rem;
        color: <?=$approval=='Approved'? 'var(--success-color)': 'var(--danger-color)'?>;
    }

    .confirmation-title {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: <?=$approval=='Approved'? 'var(--success-color)': 'var(--danger-color)'?>;
    }

    .confirmation-message {
        font-size: 1.1rem;
        margin-bottom: 2rem;
        color: #555;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background-color: var(--primary-color);
        color: white;
        text-decoration: none;
        border-radius: var(--border-radius);
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn i {
        font-size: 0.9em;
    }

    @media (max-width: 768px) {
        .confirmation-container {
            padding: 2rem;
        }

        .confirmation-icon {
            font-size: 3.5rem;
        }

        .confirmation-title {
            font-size: 1.5rem;
        }
    }
    </style>
</head>

<body>
    <div class="confirmation-container">
        <div class="confirmation-icon">
            <?php if ($approval == 'Approved'): ?>
            <i class="fas fa-check-circle"></i>
            <?php else: ?>
            <i class="fas fa-times-circle"></i>
            <?php endif; ?>
        </div>

        <h1 class="confirmation-title">
            <?= $approval == 'Approved' ? 'Leave Approved!' : 'Leave Rejected' ?>
        </h1>

        <p class="confirmation-message">
            Your decision has been successfully recorded. The <?= $approval == 'Approved' ? 'approval' : 'rejection' ?>
            has been sent to the administration.
        </p>

        <a href="parent_dashboard.php" class="btn">
            <i class="fas fa-arrow-left"></i> Back to Parent Dashboard
        </a>
    </div>
</body>

</html>