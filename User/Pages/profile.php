<?php
session_start();

$page_title = "HealthyTrack - User Profile"; 
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/header.php';

$userId = $_SESSION['user_id'];
$msg = "";

// Fetch user data
$result = $cn->query("SELECT id, name, email, created_at FROM user_register WHERE id=$userId");
$user = $result->fetch_assoc();

if(!$user){
    die("⚠️ User not found. Please <a href='../login.php'>login</a> again.");
}
// Update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];

    if (!empty($newPassword)) {
        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
        $sql = "UPDATE user_register SET name='$newName', email='$newEmail', password='$hashed' WHERE id=$userId";
    } else {
        $sql = "UPDATE user_register SET name='$newName', email='$newEmail' WHERE id=$userId";
    }

    if ($cn->query($sql)) {
        $_SESSION['email'] = $newEmail;
        $msg = "Profile updated successfully!";
        $user['name'] = $newName;
        $user['email'] = $newEmail;
    } else {
        $msg = " Error updating profile: " . $cn->error;
    }
}

// Handle delete account
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_account'])) {
    $delete = "DELETE FROM user_register WHERE id=$userId";
    if ($cn->query($delete)) {
        session_unset();
        session_destroy();
        header("Location: ../index.php"); // redirect to login page
        exit;
    } else {
        $msg = "Error deleting account: " . $cn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $page_title ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
         
    .profile-card {
      margin:auto;
      margin-top:1%;
      width: 500px;
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
      border-bottom:1px solid black;
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
    }

    .btn:hover {
      background: linear-gradient(135deg, #185a9d, #43cea2);
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .btn-danger {
    background: linear-gradient(135deg, #ff4b5c, #ff1e56);
    color: white;
    font-weight: 600;
}

    .btn-danger:hover {
        background: linear-gradient(135deg, #ff1e56, #ff4b5c);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
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
    <div class="profile-card text-black">
        <h2>👤 User Profile</h2>

           <?php if ($msg): ?>
                <div class="alert"><?php echo $msg; ?></div>
            <?php endif; ?>
        <form method="POST">

            <label>Created At:</label>
            <input type="text" value="<?= $user['created_at']; ?>" disabled>

            <label>Name:</label>
            <input type="text" name="name" value="<?= $user['name']; ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?= $user['email']; ?>" required>

            <label>New Password:</label>
            <input type="password" name="password" placeholder="Leave blank if not changing">

            <button type="submit" class="btn">Update Profile</button>
        </form>
            <br>
       <form method="POST" onsubmit="return confirm('⚠️ Are you sure you want to delete your account? This action cannot be undone.');">
            <button type="submit" name="delete_account" class="btn btn-danger">Delete Account</button>
        </form>
    </div>
</body>
</html>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
