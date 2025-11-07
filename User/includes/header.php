<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($page_title) ? $page_title : "HealthyTrack - Dashboard" ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   <script src="https://kit.fontawesome.com/46d1c4370c.js" crossorigin="anonymous"></script>

  <style>
    .navbar {
      background: linear-gradient(90deg, #2c3e50, #34495e);
      box-shadow: 0 3px 8px rgba(0,0,0,0.2);
    }

    .navbar-brand {
      font-size: 20px;
      font-weight: bold;
      color: #fff !important;
      letter-spacing: 1px;
    }

    .navbar-nav {
       margin-right:20px;
       gap:10px;
    }

    .navbar-nav .nav-link {
      color: #ecf0f1 !important;
      font-weight: 500;
      font-size: 16px;
      padding: 8px 12px;
      border-radius: 6px;
      transition: all 0.3s ease;
    }

    .navbar-nav .nav-link:hover {
      background: #1abc9c;
      color: #fff !important;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .navbar-nav .nav-link.active {
      background: #e67e22;
      color: #fff !important;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <!-- Brand -->
      <a class="navbar-brand" href="#">
        HealthyTrack - <small>Diet & Nutrition Tracker</small>
      </a>

      <!-- Hamburger Icon -->
      <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar Links -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="../Pages/dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="../Pages/bodytype_analysis.php">Body Type Analysis</a></li>
          <li class="nav-item"><a class="nav-link" href="../Pages/user_meal.php">My Diet Plan</a></li>
          <li class="nav-item"><a class="nav-link" href="../Pages/progress_track.php">Weight Track</a></li>
          <li class="nav-item"><a class="nav-link" href="../Pages/health_tips.php">Health Tips</a></li>
          <li class="nav-item"><a class="nav-link" href="../Pages/profile.php">Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
</body>
</html>


















































