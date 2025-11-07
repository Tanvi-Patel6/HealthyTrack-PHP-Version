<?php

  session_start();

   require_once __DIR__ . '../config/db.php';



// Handle Contact Form
if (isset($_POST['submit_contact'])) {
    $name = mysqli_real_escape_string($cn, $_POST['contact_name']);
    $email = mysqli_real_escape_string($cn, $_POST['contact_email']);
    $subject = mysqli_real_escape_string($cn, $_POST['contact_subject']);
    $message = mysqli_real_escape_string($cn, $_POST['contact_message']);

    $insert = "INSERT INTO contact_messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
    if (mysqli_query($cn, $insert)) {
        $_SESSION['contact_msg'] = "Your message has been sent successfully!";
        header("Location: index.php#contact"); // scroll to contact section
        exit;
    } else {
        $_SESSION['contact_msg'] = "Error: " . mysqli_error($cn);
        header("Location: index.php#contact");
        exit;
    }
}

// Handle Feedback Form
if (isset($_POST['submit_feedback'])) {
    $name = mysqli_real_escape_string($cn, $_POST['feedback_name']);
    $email = mysqli_real_escape_string($cn, $_POST['feedback_email']);
    $feedback = mysqli_real_escape_string($cn, $_POST['feedback_text']);

    $insert = "INSERT INTO feedback_messages (name, email, feedback) VALUES ('$name', '$email', '$feedback')";
    if (mysqli_query($cn, $insert)) {
        $_SESSION['feedback_msg'] = "Thank you for your feedback!";
        header("Location: index.php#feedback"); // scroll to feedback section
        exit;
    } else {
        $_SESSION['feedback_msg'] = "Error: " . mysqli_error($cn);
        header("Location: index.php#feedback");
        exit;
    }
}


?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>HealthyTrack - Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: #f5f6f8;
  margin: 0;
  padding: 0;
}

/* Navbar */
.navbar {
  padding: 12px 0;
  position: sticky;
}
.navbar .nav-link {
  font-weight: 500;
}
.navbar .btn {
  border-radius: 8px;
}

/* Hero Section */
.hero {
  background: url('Assets/img/hero.avif') center/cover no-repeat;
  height: 90vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  position: relative;
  color: white;
}
.hero::before {
  content: "";
  position: absolute;
  top:0;left:0;width:100%;height:100%;
  background: rgba(0,0,0,0.5);
}
.hero-content {
  position: relative;
  z-index: 2;
}

/* About Section */
#about h2 {
  font-weight: 700;
}
.feature-icon {
  font-size: 40px;
  color: #159ddbff;
}

/* Contact & Feedback */
.card {
  border-radius: 12px;
}
.form-control-lg {
  border-radius: 10px;
}
.btn-custom, .btn.color {
  background: #06df67;
  color: #fff;
  border-radius: 8px;
  font-weight: 500;
}
.btn-custom:hover, .btn.color:hover {
  background: #06df67;
  color: #fff;
}

/* Footer */
footer {
  background-color: #13a756 !important;
  color: white;
  text-align: center;
  padding: 15px 0;
  margin-top: 40px;
}

  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container">
    <a class="navbar-brand fw-bold" href="home.php">HealthyTrack - <small>Diet & Nutrition Tracker</small></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="#feedback">Feedback</a></li>
        <li class="nav-item"><a class="btn btn-light text-success ms-2" href="Pages/register.php">Register</a></li>
        <li class="nav-item"><a class="btn btn-outline-light ms-2" href="Pages/register.php">Login</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero">
  <div class="hero-content">
    <h1 class="display-4 fw-bold">Track Your Health, Achieve Your Goals</h1>
    <p class="lead">Log meals, track progress, and get personalized diet plans.</p>
    <a href="../User/Pages/register.php" class="btn btn-success btn-lg me-2">Register Now</a>
    <a href="../User/Pages/register.php" class="btn btn-outline-light btn-lg">Login</a>
  </div>
</section>

<!-- About Section -->
<section id="about" class="py-5">
  <div class="container text-center">
    <h2 class="mb-4">About HealthyTrack</h2>
    <p class="mb-4">
      HealthyTrack is more than just a diet tracker — it’s your personal health companion. 
      It helps you log meals, monitor water intake, track progress with interactive charts, 
      and receive personalized diet plans. Whether your goal is weight loss, fitness improvement, 
      or simply a healthier lifestyle, HealthyTrack makes it simple and motivating.
    </p>

    <div class="row mt-5">
      <h3 class="mb-4">Why Choose Us?</h3>

      <div class="col-md-3">
        <div class="card shadow-sm border-0 p-3">
          <div class="feature-icon">✅</div>
          <h5 class="mt-2">Easy to Use</h5>
          <p class="small">Simple design that anyone can use without confusion.</p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card shadow-sm border-0 p-3">
          <div class="feature-icon">📊</div>
          <h5 class="mt-2">Smart Analytics</h5>
          <p class="small">Track your progress with clear charts and reports.</p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card shadow-sm border-0 p-3">
          <div class="feature-icon">📱</div>
          <h5 class="mt-2">Accessible Anywhere</h5>
          <p class="small">Use it anytime on desktop, tablet, or mobile devices.</p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card shadow-sm border-0 p-3">
          <div class="feature-icon">🧑‍⚕️</div>
          <h5 class="mt-2">Expert Backed</h5>
          <p class="small">Built with inputs from nutrition and fitness experts.</p>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Contact Section -->
<section id="contact" class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-4 fw-bold">Contact Us</h2>
    <p class="text-center mb-5 text-muted">
      Have questions or need help? Reach out to us — we’re here to support your health journey.
    </p>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow border-0">
          <div class="card-body p-4">
            <form method="POST">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold">Full Name</label>
                  <input type="text" name="contact_name" class="form-control form-control-lg" placeholder="Enter your name" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label fw-semibold">Email</label>
                  <input type="email" name="contact_email" class="form-control form-control-lg" placeholder="Enter your email" required>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Subject</label>
                <input type="text" name="contact_subject" class="form-control form-control-lg" placeholder="Subject" required>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Message</label>
                <textarea class="form-control form-control-lg" name="contact_message" rows="5" placeholder="Write your message here..." required></textarea>
              </div>
              <div class="text-center">
                <button type="submit" name="submit_contact" class="btn btn-success btn_hover px-5 py-2">Send Message</button>
              </div>
            </form>
            <?php
            if(isset($_SESSION['contact_msg'])) {
                echo '<div class="alert alert-success text-center">'.$_SESSION['contact_msg'].'</div>';
                unset($_SESSION['contact_msg']); // remove after displaying
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Feedback Section -->
<section id="feedback" class="py-5">
  <div class="container">
    <h2 class="text-center mb-4 fw-bold">Your Feedback Matters</h2>
    <p class="text-center mb-5 text-muted">
      We value your thoughts. Share your feedback and help us make HealthyTrack better for everyone.
    </p>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-lg border-0">
          <div class="card-body p-4">
            <form method="POST">
                <div class="mb-3">
                  <label class="form-label fw-semibold">Your Name</label>
                  <input type="text" name="feedback_name" class="form-control form-control-lg" placeholder="Enter your name" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold">Email (Optional)</label>
                  <input type="email" name="feedback_email" class="form-control form-control-lg" placeholder="Enter your email">
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold">Feedback</label>
                  <textarea class="form-control form-control-lg" name="feedback_text" rows="4" placeholder="Write your feedback" required></textarea>
                </div>
                <div class="text-center">
                  <button type="submit" name="submit_feedback" class="btn btn-success btn_hover px-5 py-2">Submit Feedback</button>
                </div>
              </form>
                 <?php
                  if(isset($_SESSION['feedback_msg'])) {
                      echo '<div class="alert alert-success text-center">'.$_SESSION['feedback_msg'].'</div>';
                      unset($_SESSION['feedback_msg']);
                  }
                  ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Footer -->
<footer>
  <p>© 2025 HealthyTrack | Designed with  for health and fitness</p>
</footer>

</body>
</html>
