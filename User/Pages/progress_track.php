<?php 
    session_start(); 
      $user_id = $_SESSION['user_id'];
    $page_title = "HealthyTrack - Progress Track"; 

    require_once __DIR__ . '/../config/db.php'; 
    require_once __DIR__ . '/../includes/auth_check.php'; 
    require_once __DIR__ . '/../includes/header.php'; 

    
if (isset($_POST['save_weight'])) {
    $weight = $_POST['weight'];
    $today = date('Y-m-d');

   $sql = "INSERT INTO weight_logs (user_id, weight, logged_on) 
            VALUES ('$user_id', '$weight', '$today')";
    mysqli_query($cn, $sql);
}

$sql = "SELECT weight, logged_on FROM weight_logs 
        WHERE user_id = '$user_id' ORDER BY logged_on ASC";
$result = mysqli_query($cn, $sql);

$weights = [];
$dates = [];

while ($row = mysqli_fetch_assoc($result)) {
    $weights[] = $row['weight'];
    $dates[] = $row['logged_on'];
}



?>

<style>
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
</style>

<div class="container-fluid">



<div class="card p-3 shadow-sm mb-3">
  <h6><i class="bi bi-clipboard-heart"></i> Update Weight</h6>
  <form method="POST" action="">
    <div class="row">
      <div class="col-md-6">
        <input type="number" step="0.1" name="weight" class="form-control" placeholder="Enter weight (kg)" required>
      </div>
      <div class="col-md-6">
        <button type="submit" name="save_weight" class="btn btn-primary">Save</button>
      </div>
    </div>
  </form>
</div>


<div class="card p-3 shadow-sm m-auto"  style="height:600px; width:80%;">
  <h6><i class="bi bi-graph-up-arrow"></i> Weight Change</h6>
  <canvas id="weightChart"></canvas>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('weightChart').getContext('2d');
const weightChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($dates) ?>,
        datasets: [{
            label: 'Weight (kg)',
            data: <?= json_encode($weights) ?>,
            borderColor: 'blue',
            backgroundColor: 'rgba(0,123,255,0.2)',
            fill: true,
            tension: 0.3,
            pointRadius: 5,
            pointBackgroundColor: 'blue'
        }]
    },
    options: {
        responsive: true,
         maintainAspectRatio: false,
        plugins: {
            legend: { display: true }
        },
        scales: {
            x: { title: { display: true, text: 'Date' } },
            y: { title: { display: true, text: 'Weight (kg)' }, beginAtZero: false }
        }
    }
});
</script>

    <?php require_once __DIR__ . '/../includes/footer.php'; ?>