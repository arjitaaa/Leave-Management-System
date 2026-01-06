<?php
if (isset($_GET['month'])) {
    $month = $_GET['month']; // e.g., 2025-06

    $mysqli = new mysqli("localhost", "root", "", "leavedb");

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=leave_requests_' . $month . '.csv');

    $output = fopen('php://output', 'w');

    // CSV Header
    fputcsv($output, [
        'Roll No', 'Student ID', 'Student Name', 'Class', 'Branch', 'Semester',
        'Leave Type', 'Start Date', 'End Date', 'No. of Days', 'Stay Option',
        'Reason', 'Applied On', 'Parent Status', 'HOD Status'
    ]);

    // Fetch approved leave requests for the month
    $stmt = $mysqli->prepare("
        SELECT 
            lr.rollNo, lr.studentId, lr.student_name, 
            s.class, s.branch, s.semester,
            lr.leave_type, lr.start_date, lr.end_date, lr.no_of_days,
            lr.stay_option, lr.reason, lr.applied_on, 
            lr.parent_status, lr.hod_status
        FROM leave_requests lr
        JOIN student s ON lr.rollNo = s.rollNo
        WHERE DATE_FORMAT(lr.applied_on, '%Y-%m') = ?
    ");
    $stmt->bind_param("s", $month);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['rollNo'],
            $row['studentId'],
            $row['student_name'],
            $row['class'],
            $row['branch'],
            $row['semester'],
            $row['leave_type'],
            $row['start_date'],    // Ensure this column exists and has value
            $row['end_date'],
            $row['no_of_days'],
            $row['stay_option'],
            $row['reason'],
            $row['applied_on'],
            $row['parent_status'],
            $row['hod_status']
        ]);
    }

    fclose($output);
    exit;
} else {
    echo "Month not specified.";
}
?>
