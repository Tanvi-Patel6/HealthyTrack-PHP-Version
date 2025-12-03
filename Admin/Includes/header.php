<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth_check.php';



?>

<head>
  <title><?= isset($page_title) ? $page_title : "HealthyTrack - Admin Panel" ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      overflow-x: hidden;
    }

    /* Sidebar */
    #sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 230px;
      height: 100%;
      background: #023047;
      color: white;
      display: flex;
      flex-direction: column;
    }

    #sidebar .nav-link {
      color: #bbb;
      transition: 0.3s;
      margin: 10px 0;
    }

    #sidebar .nav-link:hover,
    #sidebar .nav-link.active {
      color: #fff;
      background: #219ebc;
      border-radius: 8px;
    }

    #content {
      margin-left: 250px;
      padding: 20px;
    }

    .profile-box {
      padding: 20px;
      border-bottom: 1px solid #444;
    }

    .profile-box p {
      margin: 0;
      font-size: 0.9rem;
    }

    .logout-section {
      margin-top: auto;
      padding: 20px;
      border-top: 1px solid #444;
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div id="sidebar">
    <!-- Profile Section -->
    <div class="profile-box text-center">
      <i class="bi bi-person-circle fs-2"></i>
      <h6 class="mt-2">Signed in as</h6>
      <p><strong><?php echo $_SESSION['email']; ?></strong></p>

    </div>

    <!-- Menu Items -->
    <ul class="nav flex-column px-3 mt-3">
      <li><a href="../Pages/dashboard.php" class="nav-link"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>

      <!-- Collapsible Manage Users -->
      <li class="nav-item mb-2">
        <a class="nav-link text-white"
          data-bs-toggle="collapse"
          href="#usersMenu"
          role="button"
          onclick="toggleUsersMenu()">
          <i class="bi bi-people-fill me-2"></i> Manage Users <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <div class="collapse ps-3 " id="usersMenu">
          <a href="../Pages/view_user.php" class="nav-link text-white-50 ">
            <i class="bi bi-person-plus me-2"></i> All User
          </a>
          <a href="../Pages/block_user.php" class="nav-link text-white-50 ">
            <i class="bi bi-list-ul me-2"></i> Block/Delete Users
          </a>
        </div>
      </li>

      <!-- manage admin -->
      <li><a href="../Pages/manage_admin.php" class="nav-link"><i class="bi bi-people-fill me-2"></i>Manage Admins</a></li>

      <!-- forms -->
      <li><a href="../Pages/forms.php" class="nav-link"><i class="bi bi-file-earmark-text me-2"></i>Forms</a></li>

      <!-- Assigning the meal -->
      <li><a href="../Pages/assign_meal.php" class="nav-link"><i class="bi bi-basket me-2"></i> Assign Meal</a></li>

      <!-- list meal -->
      <li><a href="../Pages/list_meal.php" class="nav-link"><i class="bi bi-basket me-2"></i>List Meal</a></li>

      <!-- message center -->
      <li><a href="../Pages/message_center.php" class="nav-link"><i class="bi bi-envelope-fill me-2"></i>Message Center</a></li>

      <!-- Settings -->
      <li class="nav-item mb-2">
        <a class="nav-link text-white" data-bs-toggle="collapse" href="#settingsMenu" role="button">
          <i class="bi bi-gear-fill me-2"></i> Settings <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <div class="collapse ps-3" id="settingsMenu">
          <a href="../Pages/profile.php" class="nav-link text-white-50"><i class="bi bi-person-circle me-2"></i> Profile</a>

        </div>
      </li>
    </ul>

    <!-- Logout at bottom -->
    <div class="logout-section">
      <a href="../logout.php" class="nav-link text-danger">
        <i class="bi bi-box-arrow-right me-2"></i> Logout
      </a>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      if (sessionStorage.getItem('usersMenuOpen') === 'true') {
        const menu = document.getElementById('usersMenu');
        menu.classList.add('show');
      }
    });
  </script>