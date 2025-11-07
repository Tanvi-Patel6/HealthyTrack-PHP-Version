<?php


require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/header.php';

 $user_id = $_SESSION['user_id'];

    // Fetch only the most recent meal
    $latest_meal_result = $cn->query("
        SELECT meal_time, meal_name, calories, protein, carbs, fats, meal_day 
        FROM meal_plans 
        WHERE user_id = $user_id 
        ORDER BY id DESC 
        LIMIT 1
    ");

    $latest_meal = $latest_meal_result->fetch_assoc();

   ?>


<head>
 

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      min-height: 100vh;
    }

    
    
    .card {
      background: rgba(255,255,255,0.05);
      backdrop-filter: blur(10px);
      border: none;
      border-radius: 16px;
      color: black;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    .progress {
      height: 8px;
      border-radius: 20px;
      overflow: hidden;
    }
    .main {
      background: rgba(255, 255, 255, 0);
      backdrop-filter: blur(10px);
    }

     .week-box {
    display: flex;
    justify-content: space-between;
    gap: 8px;
    flex-wrap: nowrap; /* keeps them in one line */
  }

  .day-box {
    flex: 1; /* evenly distribute inside col-md-4 */
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #f9f9f9;
    transition: all 0.2s ease;
    font-size: 12px;
  }

  .day-box:hover {
    background: #eef7ff;
    border-color: #48c6ef;
  }

  .day-box input[type="checkbox"] {
    transform: scale(1.1);
    accent-color: #48c6ef; /* modern checkbox color */
    cursor: pointer;
  }

    .tip-card {
    border-left: 6px solid #28a745;
    background: #f6fff9;
  }
  .quote-card {
    background: url('https://images.unsplash.com/photo-1599058917212-d750089bc07e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80') no-repeat center center/cover;
    border-radius: 1rem;
    min-height: 200px;
    box-shadow: inset 0 0 0 1000px rgba(0,0,0,0.5);
  }
  .badge-card {
    background: #f9f9ff;
  }
  .badge-icon {
    width: 80px;
    filter: drop-shadow(0px 0px 6px gold);
    animation: glow 2s infinite alternate;
  }
  @keyframes glow {
    from { filter: drop-shadow(0 0 4px gold); }
    to { filter: drop-shadow(0 0 12px gold); }
  }

  
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
     

      <!-- Main Content -->
      <main class="col-md-12 ms-sm-auto px-4">
        <!-- Navbar -->
        <nav class="main navbar navbar-expand-lg rounded my-3 px-3">
          <p class="fs-4  fw-bold text-dark" > 🥗 “Your health, your journey, your track.”</p>
          <div class="ms-auto d-flex align-items-center">
            <span class="me-2">Welcome, <i class="bi bi-person-fill"></i><strong><?php echo $_SESSION['user_name']; ?></strong></span>
            
          </div>
        </nav>

        <!-- Stats Cards -->
        <div class="row g-3 mb-3">

           <div class="col-md-8">
            <div class="card p-3">
              <h6><i class="bi bi-basket2-fill text-success"></i> Recent Meal</h6>
               <?php if(!empty($latest_meal)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Meal Day</th>
                            <th>Meal Time</th>
                            <th>Meal Name</th>
                            <th>Calories</th>
                            <th>Protein</th>
                            <th>Carbs</th>
                            <th>Fats</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $latest_meal['meal_day'] ?></td>
                            <td><?= $latest_meal['meal_time'] ?></td>
                            <td><?= $latest_meal['meal_name'] ?></td>
                            <td><?= $latest_meal['calories'] ?></td>
                            <td><?= $latest_meal['protein'] ?></td>
                            <td><?= $latest_meal['carbs'] ?></td>
                            <td><?= $latest_meal['fats'] ?></td>
                        </tr>
                    </tbody>
                </table>
                <?php else: ?>
                    <p class="text-muted">No meals added yet.</p>
                <?php endif; ?>
             </div>
          </div>


          
                 

        
        <section  class="p-5">
      <div class="container">
        <div class="row align-items-center justify-content-between ">
          <div class="col-md-6 text-center ">
            <img src="../Assets/img/dashboard_meal.jpg" class="img-fluid rounded " alt="" />
          </div>
          <div class="col-md-6 p-4 text-center text-md-start">
            <h2><i class="bi bi-egg-fried"></i>Meal of the Day: Rajma-Chawal Bowl (Kidney Beans with Rice & Salad)</h2>
            <p class="d-none d-md-block">
             Rajma-Chawal is a classic North Indian comfort meal that’s both nourishing and satisfying. Kidney beans (rajma) are an excellent source of plant-based protein, iron, and complex carbs, while steamed rice provides quick energy and balances the meal. A side of cucumber-carrot salad adds freshness, hydration, and essential vitamins.

             The combination of legumes + rice makes a complete protein (all essential amino acids), making it ideal for vegetarians. Slow-digesting carbs and fiber help maintain steady energy and improve digestion.    
            </p>
            <p class="d-none d-md-block">
              🌟 Key Benefits
            </p>
             <ul class="text-start">
                <li> High Protein & Iron: Rajma supports muscle repair and prevents fatigue.</li>
                <li> Complete Protein Source: Rice + beans together provide all essential amino acids.</li>
                <li> Fiber-Rich: Aids digestion and keeps you full longer.</li>
                <li> Heart-Friendly: Cooked with minimal oil & spices for a wholesome balance.</li>
                <li>Immunity Boosting: Tomatoes, onions, and spices (like turmeric & cumin) provide antioxidants.</li>
            </ul>
            <p><strong>Nutrition (per serving):</strong><br>
              Calories: 520 kcal | Protein: 18g | Carbs: 90g | Fats: 10g | Fiber: 15g
            </p>

          
          </div>
        </div>
      </div>
    </section>
       
        <!-- Community / Motivation Section -->
      <div class="container my-4">
        <div class="row g-4">

    <!-- Daily Health Tip -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0 rounded-4 tip-card h-100">
        <div class="card-body">
          <h5 class="card-title text-success">
            <i class="bi bi-lightbulb-fill"></i> Daily Health Tip
          </h5>
          <p class="card-text">
            💧 Hydration: “Drink 8–10 glasses of water today. Hydration boosts focus and metabolism.”

            <p>🥦 Nutrition: “Add one green vegetable to your lunch. Greens improve digestion and immunity.”</p>

            <p>🧘 Mindfulness: “Spend 5 minutes in meditation before bed. It reduces stress and improves sleep.”</p>

            <p>🚶 Movement: “Take a 10-minute walk after meals to regulate blood sugar.”</p>
          </p>
        </div>
      </div>
    </div>

    <!-- Motivational Quote / Image -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0 rounded-4 quote-card h-100 text-white text-center">
        <div class="card-body d-flex flex-column justify-content-center align-items-center">
          <h5 class="card-title">
            <i class="bi bi-chat-heart-fill"></i> Motivation
          </h5>
          <p class="card-text fs-5 fst-italic">
            “A little progress each day adds up to big results.”
          </p>
        </div>
      </div>
    </div>

    <!-- Progress Badge -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0 rounded-4 badge-card h-100 text-center">
        <div class="card-body">
          <h5 class="card-title text-primary">
            <i class="bi bi-award-fill"></i> Your Progress
          </h5>
          <img src="https://cdn-icons-png.flaticon.com/512/2583/2583347.png"
               alt="Bronze Badge" class="badge-icon my-3">
          <p class="fw-bold">🥉 Bronze Badge Earned!</p>
          <div class="progress rounded-pill" style="height: 12px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: 70%;">
              70%
            </div>
          </div>
          <p class="small text-muted mt-2">Keep going! Silver Badge at 100%</p>
        </div>
      </div>
    </div>

  </div>
</div>



      </main>
    </div>
  </div>


<?php
    require_once __DIR__ . '/../includes/footer.php';
?>