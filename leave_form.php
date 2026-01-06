<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}

$conn = new mysqli("localhost", "root", "", "leavedb");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT rollNo, studentId, CONCAT(firstName, ' ', lastName) as student_name FROM student WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($rollNo, $studentId, $student_name);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Apply for Leave</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100vh;
      overflow: hidden;
      background: linear-gradient(135deg, #e3f2fd, #90caf9);
      font-family: 'Poppins', sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 10px;
    }

    .top-right-btn {
      position: absolute;
      top: 20px;
      right: 20px;
    }

    .top-right-btn a {
      background-color: #1a237e;
      color: white;
      padding: 8px 16px;
      border-radius: 20px;
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      transition: background-color 0.3s ease;
    }

    .top-right-btn a:hover {
      background-color: #0d47a1;
    }

    .form-card {
      background: white;
      padding: 15px 20px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      max-width: 600px;
      width: 100%;
      max-height: 100vh;
      overflow-y: hidden;
      box-sizing: border-box;
    }

    .form-card h2 {
      color: #1a237e;
      text-align: center;
      margin-bottom: 15px;
      font-size: 1.5rem;
    }

    .form-group {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .form-group.two-fields,
    .form-group.three-fields {
      flex-wrap: nowrap;
    }

    .form-group.two-fields .field,
    .form-group.three-fields .field {
      flex: 1;
      min-width: 0;
    }

    .form-group .field {
      flex: 1;
      min-width: 130px;
    }

    label {
      display: block;
      margin: 8px 0 4px;
      color: #0d47a1;
      font-weight: 500;
      font-size: 0.9rem;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"],
    select,
    textarea {
      width: 100%;
      padding: 6px 8px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 13px;
      outline: none;
      box-sizing: border-box;
    }

    textarea {
      resize: vertical;
    }

    .radio-group {
      margin-top: 8px;
    }

    .radio-group label {
      font-weight: 400;
      margin-right: 12px;
      font-size: 0.9rem;
    }

    .submit-btn {
      margin-top: 20px;
      background-color: #1a237e;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 25px;
      font-size: 15px;
      cursor: pointer;
      width: 100%;
      transition: background 0.3s ease;
    }

    .submit-btn:hover {
      background-color: #0d47a1;
    }

    #parentAddressDiv {
      margin-top: 10px;
      display: none;
    }

    @media (max-width: 600px) {
      .form-group.two-fields,
      .form-group.three-fields {
        flex-wrap: wrap;
      }
      .form-group.two-fields .field,
      .form-group.three-fields .field {
        min-width: 100%;
      }
    }
  </style>
</head>
<body>

  <div class="top-right-btn">
    <a href="dashboard.php">← Back to Dashboard</a>
  </div>

  <div class="form-card">
    <h2>Apply for Leave</h2>
    <form action="submit_leave.php" method="POST">

      <div class="form-group three-fields">
        <div class="field">
          <label>Roll No:</label>
          <input type="number" name="rollNo" value="<?php echo htmlspecialchars($rollNo); ?>" readonly />
        </div>
        <div class="field">
          <label>Student ID:</label>
          <input type="text" name="studentId" value="<?php echo htmlspecialchars($studentId); ?>" readonly />
        </div>
      </div>

      <div class="form-group">
        <div class="field" style="flex-basis: 100%;">
          <label>Full Name:</label>
          <input type="text" name="student_name" value="<?php echo htmlspecialchars($student_name); ?>" readonly />
        </div>
      </div>

      <label>Leave Type:</label>
      <select name="leave_type" required>
        <option value="">Select</option>
        <option value="Academic Leave">Academic Leave</option>
        <option value="Casual Leave">Casual Leave</option>
        <option value="Summer/Diwali Leave">Summer/Diwali Leave</option>
        <option value="Emergency Leave">Emergency Leave</option>
      </select>

      <label>Reason:</label>
      <textarea name="reason" rows="3" required></textarea>

      <div class="form-group three-fields">
        <div class="field">
          <label>From:</label>
          <input type="date" name="start_date" required />
        </div>
        <div class="field">
          <label>To:</label>
          <input type="date" name="end_date" required />
        </div>
        <div class="field">
          <label>Number of Days:</label>
          <input type="number" name="no_of_days" id="no_of_days" readonly required />
        </div>
      </div>

      <label>Stay Option:</label>
      <div class="radio-group">
        <input type="radio" name="stay_option" value="Alone" onchange="toggleParentAddress()" checked /> Alone
        <input type="radio" name="stay_option" value="With Parents" onchange="toggleParentAddress()" /> With Parents
      </div>

      <div id="parentAddressDiv">
        <label>Parent Address:</label>
        <textarea name="parent_address" rows="3"></textarea>
      </div>

      <button type="submit" class="submit-btn">Submit</button>
    </form>
  </div>

  <script>toggleParentAddress();</script>
  <script>
  function toggleParentAddress() {
    const stayOption = document.querySelector('input[name="stay_option"]:checked').value;
    const parentAddressDiv = document.getElementById('parentAddressDiv');
    parentAddressDiv.style.display = (stayOption === 'With Parents') ? 'block' : 'none';
  }

  function calculateDays() {
    const startInput = document.querySelector('input[name="start_date"]');
    const endInput = document.querySelector('input[name="end_date"]');
    const dayField = document.getElementById('no_of_days');

    const start = new Date(startInput.value);
    const end = new Date(endInput.value);

    if (startInput.value && endInput.value) {
      const timeDiff = end.getTime() - start.getTime();
      const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24)) + 1;

      if (days <= 0) {
        alert("End date must be same or after start date.");
        dayField.value = '';
        return;
      }

      if (days > 10) {
        alert("You cannot apply for more than 10 days.");
        dayField.value = '';
        return;
      }

      dayField.value = days;
    }
  }

  window.addEventListener('DOMContentLoaded', () => {
    document.querySelector('input[name="start_date"]').addEventListener('change', calculateDays);
    document.querySelector('input[name="end_date"]').addEventListener('change', calculateDays);

    document.querySelector('form').addEventListener('submit', function (e) {
      const noOfDays = parseInt(document.getElementById('no_of_days').value);
      if (!noOfDays || noOfDays > 10) {
        e.preventDefault();
        alert("Form not submitted. Please select valid dates. Leave cannot exceed 10 days.");
      }
    });

    toggleParentAddress();
  });
  </script>

</body>
</html>
