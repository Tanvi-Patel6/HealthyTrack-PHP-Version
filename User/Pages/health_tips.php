<?php 
    session_start();
    $page_title = "HealthyTrack - Health Tips"; 
    require_once __DIR__ . '/../config/db.php';
    require_once __DIR__ . '/../includes/auth_check.php';
    require_once __DIR__ . '/../includes/header.php';

    
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT goal FROM body_type WHERE user_id = '$user_id' ORDER BY created_at DESC LIMIT 1";
    $result = mysqli_query($cn, $sql);
    $row = mysqli_fetch_assoc($result);
    $goal = $row['goal'] ?? "maintain"; // fallback
?>


<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <title>HealthyTrack - Health Tips</title>
  <style>
   

    .header {
      text-align: center;
      padding: 2rem;
      background: linear-gradient(135deg, #48c6ef, #6f86d6);
      color: white;
      font-size: 2rem;
      font-weight: bold;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .container1 {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 1rem;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.5rem;
    }

    .card {
      background: white;
      border-radius: 20px;
      padding: 1.5rem;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .card::before {
      content: "";
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(120deg, rgba(72,198,239,0.1), rgba(111,134,214,0.1));
      transform: rotate(25deg);
    }

    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }

    .card h3 {
      margin-top: 0;
      color: #48c6ef;
      font-size: 1.3rem;
    }

    .card p {
      margin: 0.5rem 0;
      line-height: 1.6;
    }

    .quote {
      grid-column: 1 / -1;
      background: linear-gradient(135deg, #ff9a9e, #fad0c4);
      color: #333;
      font-style: italic;
      font-weight: 500;
      text-align: center;
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    @media(max-width: 768px) {
      .header {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>

<header class="header">
  🌿 HealthyTrack Health Tips
</header>

<div class="container1">
  <div class="card">
    <h3>💧 Stay Hydrated</h3>
    <p>Drink at least 8–10 glasses of water daily to keep your body active and improve metabolism.</p>
  </div>

  <div class="card">
    <h3>😴 Sleep Well</h3>
    <p>Aim for 7–9 hours of quality sleep every night for better recovery and energy.</p>
  </div>

  <div class="card">
    <h3>🥗 Balanced Diet</h3>
    <p>Include whole grains, proteins, healthy fats, and colorful vegetables in every meal.</p>
  </div>

  <div class="card">
    <h3>🏃 Exercise</h3>
    <p>Do at least 30 minutes of exercise daily. Mix cardio with strength training.</p>
  </div>

  <?php if($goal === 'loss'): ?>
    <div class="card">
      <h3>🔥 Weight Loss Tip</h3>
      <p>Focus on a calorie deficit, avoid sugary drinks, and add high-protein meals.</p>
    </div>
  <?php elseif($goal === 'gain'): ?>
    <div class="card">
      <h3>💪 Weight Gain Tip</h3>
      <p>Add healthy snacks, nuts, dairy, and strength training for lean muscle gain.</p>
    </div>
  <?php elseif($goal === 'maintain'): ?>
    <div class="card">
      <h3>⚖️ Maintain Tip</h3>
      <p>Stick to balanced meals, regular workouts, and portion control to maintain weight.</p>
    </div>
  <?php endif; ?>

  <div class="quote">
    “Take care of your body. It's the only place you have to live.” 💚
  </div>
</div>

     <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>

