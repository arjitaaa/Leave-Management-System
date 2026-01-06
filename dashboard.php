<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Modern Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #e3f2fd, #90caf9);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      padding: 30px 20px;
    }

    .main-heading {
  font-size: 4rem;
  font-weight: 900;
  text-align: center;
  margin-bottom: 30px;
  letter-spacing: 2.5px;
  background: linear-gradient(90deg,rgb(20, 19, 20),rgb(106, 103, 104),rgb(47, 46, 47));
  background-size: 300% 300%;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-fill-color: transparent;
  animation: glowShift 6s ease infinite;
  text-shadow: 3px 3px 8px rgba(136, 14, 79, 0.25);
}


@keyframes glowShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}


.welcome {
  font-size: 3.5rem;
  font-weight: 700;
  margin-bottom: 20px;
  text-align: center;
  background: linear-gradient(270deg,rgb(6, 98, 151),rgb(59, 151, 170),rgb(13, 159, 182),rgb(158, 209, 231));
  background-size: 800% 800%;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-fill-color: transparent;
  animation: gradientShift 10s ease infinite;
  user-select: none;
  letter-spacing: 1.5px;
  text-shadow: 3px 3px 10px rgba(255, 87, 34, 0.3), 0 0 10px rgba(255, 111, 0, 0.2);
}



    @keyframes gradientShift {
      0% {background-position: 0% 50%;}
      50% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }

    .dashboard-title {
      font-size: 32px;
      font-weight: 600;
      margin-bottom: 40px;
      color: #1a237e;
      text-align: center;
    }

    .card-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 30px;
      width: 100%;
      max-width: 1000px;
    }

    .card {
      background: white;
      padding: 30px 20px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .card i {
      font-size: 30px;
      color: #3949ab;
      margin-bottom: 15px;
    }

    .card a {
      text-decoration: none;
      color: #1a237e;
      font-weight: 600;
      font-size: 18px;
      display: block;
    }

    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .button-container {
      margin-top: 40px;
      display: flex;
      gap: 20px;
    }

    .logout-btn, .home-btn {
      padding: 12px 25px;
      border: none;
      border-radius: 30px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .logout-btn {
      background-color: #e53935;
      color: white;
    }

    .logout-btn:hover {
      background-color: #c62828;
    }

    .home-btn {
      background-color: #1a237e;
      color: white;
      text-decoration: none;
    }

    .home-btn:hover {
      background-color: #1565c0;
    }

    /* Responsive Design */
@media (max-width: 768px) {
  .main-heading {
    font-size: 2.5rem;
  }

  .welcome {
    font-size: 2.2rem;
    text-align: center;
  }

  .dashboard-title {
    font-size: 20px;
    margin-bottom: 30px;
  }

  .card-container {
    grid-template-columns: 1fr;
    gap: 20px;
  }

  .card {
    padding: 25px 15px;
  }

  .card i {
    font-size: 26px;
  }

  .card a {
    font-size: 16px;
  }

  .button-container {
    flex-direction: column;
    align-items: center;
    gap: 15px;
  }

  .logout-btn, .home-btn {
    width: 80%;
    justify-content: center;
    font-size: 15px;
  }
}

@media (max-width: 480px) {
  .main-heading {
    font-size: 2rem;
  }

  .welcome {
    font-size: 1.8rem;
  }

  .dashboard-title {
    font-size: 18px;
  }

  .logout-btn, .home-btn {
    padding: 10px 20px;
    font-size: 14px;
  }
}

  </style>
</head>
<body>

  <!-- Added Student Dashboard heading -->
  <div class="main-heading">Student Dashboard</div>

  <div class="welcome">
    Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?>
  </div>

  <div class="dashboard-title">Leave Management System For Banasthali Vidyapith</div>

  <div class="card-container">
    <div class="card">
      <i class="fas fa-paper-plane"></i>
      <a href="leave_form.php">Apply for Leave</a>
    </div>
    <div class="card">
      <i class="fas fa-history"></i>
      <a href="leave_history.php">View Leave History</a>
    </div>
  </div>

  <div class="button-container">
    <form method="post" action="logout.php">
      <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </form>
    <a href="index.html" class="home-btn"><i class="fas fa-home"></i> Back to Home</a>
  </div>

</body>
</html>
