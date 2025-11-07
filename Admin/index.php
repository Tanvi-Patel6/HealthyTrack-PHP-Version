<?php
  
  session_name("admin_session");
  session_start();
   require_once __DIR__ . '../config/db.php';

   $message = "";

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = mysqli_query($cn, "SELECT id, email, password FROM admin WHERE email='$email'");

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            // login success
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email']   = $row['email'];
            header("Location: Pages/dashboard.php");
            exit();
        } else {
            $message = "❌ Incorrect password!";
        }
    } else {
        $message = "❌ No user found with that email!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthyTrack - Admin Login</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
     <style>
        body {
      background-color: #e5e5e5;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    a{
      color:white;
      font-weight:bold;
    }

    .login-container {
      display: flex;
      width: 70%;
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

    .left-side h3 {
      margin-bottom: 30px;
      font-weight: 500;
      color: #333;
    }

    .form-control {
      margin-bottom: 20px;
      padding: 12px;
    }

    .input-group-text {
        background-color: #f8f9fa; /* light background */
        border: 1px solid #ced4da;
        border-right: none;
        font-size: 1rem; /* keep icons normal size */
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px; /* fixed width for icon box */
        height:50px;
    }


    .btn-login {
      background-color: #006400;
      color: white;
      font-weight: bold;
      padding: 10px;
      border-radius: 5px;
      width:50%;
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
      font-size: 2.5rem;
      font-weight: bold;
    }

    .right-side p {
      margin-top: 10px;
      letter-spacing:1px;
      font-size: 1rem;
      line-height:2rem;
      opacity: 0.9;
    }
    </style>
</head>
<body>
    <div class="login-container">
    <!-- Left side -->
    <div class="left-side">
      <h3>Admin Login</h3>
      <form method="POST">
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="bi bi-at"></i></span>
          <input type="email" class="form-control" placeholder="Email" name="email">
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input type="password" class="form-control" placeholder="Password" name="password">
        </div>
        <div class="d-flex justify-content-between align-items-center">
          <button type="submit" class="btn btn-login">Login</button>
        </div><br>
        <a href="#" class="text-success">Forgot password ?</a>
        <br><br>
       <p style="color:red;"><?php echo $message; ?></p>
      </form>
    </div>

    <!-- Right side -->
    <div class="right-side">
      <h1>WELCOME BACK</h1>
      <p>Log in HealthyTrack System<br> Administration page</p>
      <p>If you're new to this then click her for register. </p>
      <a href="add_admin.php">~ Add Admin</a>
    </div>
  </div>
</body>
</html>