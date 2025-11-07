<?php
 require_once __DIR__ . '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO admin (email, password) VALUES ('$email', '$hash')";
    if (mysqli_query($cn, $sql)) {
        header('Location: index.php'); exit;
    } else {
        echo "Error: " . mysqli_error($cn);
    }
}

?>
<head>
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

    a{
     
      color:white;
      font-weight:bold;
    }

    .login-container {
      display: flex;
      width: 50%;
      max-width: 900px;
      height: 50vh;
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
    }

     .input-group {
        width:100%;
    }


    .btn-login {
      background-color: #006400;
      color: white;
      font-weight: bold;
      padding: 10px;
      border-radius: 5px;
      width:40%;
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
      letter-spacing:1px;
      font-size: 1rem;
      line-height:2rem;
      opacity: 0.9;
    }
    </style>
</head>
     <div class="login-container">
    <!-- Left side -->
    <div class="left-side">
      <h1> Add Admin</h1>
      <form method="POST">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
        </div>
        <div class="d-flex justify-content-between align-items-center">
          <button type="submit" class="btn btn-login">Add Admin</button>
        </div>
      </form>
    </div>

    <!-- Right side -->
    <div class="right-side">
      <h1>Admin</h1>
      <p>Add in HealthyTrack System<br> Administration page</p>
      <p> Already Admin then click here to Login</p>
      <a href="index.php">~ Login</a>
    </div>
  </div>
