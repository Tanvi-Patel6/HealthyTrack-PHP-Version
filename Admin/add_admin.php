<?php
require_once __DIR__ . '/../Admin/Config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize input
  $email = trim($_POST['email'] ?? '');
  $password = trim($_POST['password'] ?? '');

  // Backend validation
  if (empty($email) || empty($password)) {
    $error = "All fields are required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Please enter a valid email address.";
  } elseif (strlen($password) < 6) {
    $error = "Password must be at least 6 characters long.";
  } else {
    // Hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkQuery = "SELECT * FROM admin WHERE email = '$email'";
    $checkResult = mysqli_query($cn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
      $error = "This email is already registered.";
    } else {
      // Insert admin
      $sql = "INSERT INTO admin (email, password) VALUES ('$email', '$hash')";
      if (mysqli_query($cn, $sql)) {
        header('Location: index.php');
        exit;
      } else {
        $error = "Error: " . mysqli_error($cn);
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>HealthyTrack - Add Admin</title>
  <style>
    body {
      background-color: #e5e5e5;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    a {
      color: white;
      font-weight: bold;
      text-decoration: none;
    }

    .login-container {
      display: flex;
      width: 50%;
      max-width: 900px;
      height: 60vh;
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 10px 20px 25px rgba(0, 0, 0, 0.2);
    }

    .left-side {
      flex: 1;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .form-control {
      margin-bottom: 20px;
      padding: 12px;
      width: 100%;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    .btn-login {
      background-color: #006400;
      color: white;
      font-weight: bold;
      padding: 10px;
      border-radius: 5px;
      width: 50%;
      border: none;
      cursor: pointer;
    }

    .btn-login:hover {
      background-color: #004d25;
    }

    .right-side {
      flex: 1;
      background: linear-gradient(135deg, #004d25 50%, #003d1e 50%);
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 30px;
    }

    .right-side h1 {
      font-size: 2rem;
      font-weight: bold;
    }

    .right-side p {
      margin-top: 10px;
      letter-spacing: 1px;
      font-size: 1rem;
      line-height: 2rem;
      opacity: 0.9;
    }

    .error-message {
      color: red;
      margin-bottom: 10px;
      font-weight: bold;
    }

    .success-message {
      color: green;
      margin-bottom: 10px;
      font-weight: bold;
    }
  </style>


  <script>
    function validateForm() {
      const email = document.forms["adminForm"]["email"].value.trim();
      const password = document.forms["adminForm"]["password"].value.trim();

      if (email === "" || password === "") {
        alert("All fields are required!");
        return false;
      }

      const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
      if (!email.match(emailPattern)) {
        alert("Please enter a valid email address!");
        return false;
      }

      if (password.length < 6) {
        alert("Password must be at least 6 characters long!");
        return false;
      }

      return true;
    }
  </script>
</head>

<body>
  <div class="login-container">
    <!-- Left side -->
    <div class="left-side">
      <h1>Add Admin</h1>

      <?php if (!empty($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form name="adminForm" method="POST" onsubmit="return validateForm();">
        <input type="email" class="form-control" placeholder="Email" name="email" required>
        <input type="password" class="form-control" placeholder="Password" name="password" required>
        <button type="submit" class="btn-login">Add Admin </button>
      </form>
    </div>

    <!-- Right side -->
    <div class="right-side">
      <h1>Admin</h1>
      <p>Add in HealthyTrack System<br>Administration page</p>
      <p>Already an admin? Click below to log in.</p>
      <a href="index.php">~ Login</a>
    </div>
  </div>
</body>

</html>