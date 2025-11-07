<?php

    $page_title = "HealthyTrack - Profile"; 
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth_check.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php"); // redirect if not logged in
    exit;
}

// Assuming admin is logged in
$admin_id = $_SESSION['user_id'];

// Fetch admin details
$sql = "SELECT * FROM admin WHERE id = $admin_id";
$result = $cn->query($sql);
$admin = $result->fetch_assoc();

$msg = "";

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_profile'])) {
    $email = trim($_POST['email']);

    // Handle password update
    $password_sql = "";
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $password_sql = ", password='$password'";
    }

    // Update query
    $update = "UPDATE admin SET email='$email' $password_sql WHERE id=$admin_id";

    if (mysqli_query($cn, $update)) {
        $msg = "Profile updated successfully!";
        $result = mysqli_query($cn, "SELECT * FROM admin WHERE id = $admin_id");
        $admin  = mysqli_fetch_assoc($result);
    } else {
        $msg = "Error: " . mysqli_error($cn);
    }
}

// Handle delete account
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_account'])) {
    $delete = "DELETE FROM admin WHERE id=$admin_id";
    if (mysqli_query($cn, $delete)) {
        session_unset();
        session_destroy();
        header("Location: ../index.php"); // redirect to login page
        exit;
    } else {
        $msg = "Error deleting account: " . mysqli_error($cn);
    }
}
require_once __DIR__ . '/../includes/header.php';
?>
<head>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        #content {
            flex: 1; 
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #a9c1efff, #d6dbe4ff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .profile-card {
          width: 400px;
          background: rgba(255, 255, 255, 0.1);
          border-radius: 20px;
          padding: 30px;
          backdrop-filter: blur(15px);
          box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
          color: #fff;
          animation: fadeIn 0.8s ease-in-out;
        }

        .profile-card h2 {
          text-align: center;
          margin-bottom: 20px;
          font-size: 26px;
          letter-spacing: 1px;
        }

        .alert {
          background: rgba(0, 255, 0, 0.2);
          border: 1px solid rgba(0, 255, 0, 0.4);
          padding: 10px;
          border-radius: 10px;
          text-align: center;
          margin-bottom: 15px;
          animation: slideIn 0.5s ease-in-out;
        }

        label {
          display: block;
          font-weight: 500;
          margin-bottom: 6px;
          font-size: 14px;
        }

        input {
          width: 100%;
          padding: 12px;
          margin-bottom: 18px;
          border: none;
          outline: none;
          border-radius: 10px;
          font-size: 15px;
          transition: all 0.3s ease;
        }

        input:focus {
          background: rgba(255, 255, 255, 0.2);
          transform: scale(1.02);
        }

        .btn {
          width: 100%;
          padding: 12px;
          border: none;
          border-radius: 10px;
          font-size: 16px;
          cursor: pointer;
          background: linear-gradient(135deg, #43cea2, #185a9d);
          color: white;
          font-weight: 600;
          letter-spacing: 1px;
          transition: 0.3s;
          margin-bottom: 10px;
        }

        .btn:hover {
          background: linear-gradient(135deg, #185a9d, #43cea2);
          transform: translateY(-2px);
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .btn-delete {
          background: linear-gradient(135deg, #ff4b5c, #ff1e56);
        }

        .btn-delete:hover {
          background: linear-gradient(135deg, #ff1e56, #ff4b5c);
        }

        @media (max-width: 500px) {
          .profile-card {
            width: 90%;
            padding: 20px;
          }
        }
    </style>
</head>
<body>
     <div id="content" class="container py-5" >
       <div class="profile-card text-black">
    <h2>👤 Admin Profile</h2>

    <?php if ($msg): ?>
      <div class="alert"><?php echo $msg; ?></div>
    <?php endif; ?>

    <!-- Update Profile Form -->
    <form method="POST">
      <label>Email</label>
      <input type="email" name="email" placeholder="Enter new email" required>

      <label>New Password</label>
      <input type="password" name="password" placeholder="Leave blank to keep old password">

      <label>Created At</label>
      <input type="text" value="<?php echo $admin['created_at']; ?>" disabled>

      <button type="submit" name="update_profile" class="btn">Update Profile</button>
    </form>

    <!-- Delete Account Form -->
    <form method="POST" onsubmit="return confirm('⚠️ Are you sure you want to delete this account? This action cannot be undone.');">
      <button type="submit" name="delete_account" class="btn btn-delete">Delete Account</button>
    </form>
  </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
</body>
