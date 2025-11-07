<?php 
    session_start(); 
    $page_title = "HealthyTrack - View Meals"; 

    require_once __DIR__ . '/../config/db.php'; 
    require_once __DIR__ . '/../includes/auth_check.php'; 
    require_once __DIR__ . '/../includes/header.php'; 

 $user_id = $_SESSION['user_id'];
$days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

$all_meals = [];
$result = mysqli_query($cn, "SELECT * FROM meal_plans WHERE user_id = '$user_id'");
while ($row = mysqli_fetch_assoc($result)) {
    $all_meals[$row['meal_day']][] = $row;
}

?>
<style>
  body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }
  .flex-grow-1 {
    flex-grow: 1;
  }
  .accordion-button {
    background: linear-gradient(90deg, #5b8dbf, #89c2d9);
    color: #fff;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: background 0.3s;
  }
  .accordion-button:hover {
    background: linear-gradient(90deg, #467aa0, #6fa5be);
  }
  .accordion-item {
    border-radius: 8px;
    overflow: hidden;
  }
  .table thead th {
    background: #1f4e79;
    color: #fff;
  }
  .table tbody tr:hover {
    background-color: #e6f0fa;
  }
  .badge-meal {
    font-size: 0.85rem;
    padding: 0.35em 0.65em;
    border-radius: 0.5rem;
  }
  .table-responsive {
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    border-radius: 8px;
    overflow: hidden;
  }
</style>

<div class="flex-grow-1">
  <div class="container mt-5 mb-4">
        <h2 class="text-center mb-4 display-6 fw-bold"><i class="fas fa-burger"></i> 

 7 Day Healthy Diet Plan</h2>

        <div class="accordion" id="dietAccordion">
            <?php foreach ($days as $index => $day): ?>
            <div class="accordion-item mb-3 shadow-sm">
                <h2 class="accordion-header" id="heading<?= $index ?>">
                    <button class="accordion-button collapsed fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="false" aria-controls="collapse<?= $index ?>">
                        <?= $day ?>
                    </button>
                </h2>
                <div id="collapse<?= $index ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $index ?>" data-bs-parent="#dietAccordion">
                    <div class="accordion-body">
                        <?php if (!empty($all_meals[$day])): ?>
                        <div class="table-responsive">
                            <table class="table table-striped align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Meal Time</th>
                                        <th>Meal Name</th>
                                        <th>Calories</th>
                                        <th>Protein</th>
                                        <th>Carbs</th>
                                        <th>Fats</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($all_meals[$day] as $meal): ?>
                                    <tr>
                                        <td>
                                            <span class="badge badge-meal 
                                              <?= $meal['meal_time'] == 'Breakfast' ? 'bg-warning text-dark' : ($meal['meal_time']=='Lunch' ? 'bg-success' : 'bg-danger') ?>">
                                              <?= $meal['meal_time'] ?>
                                            </span>
                                        </td>
                                        <td><?= $meal['meal_name'] ?></td>
                                        <td><?= rtrim(rtrim($meal['calories'], '0'), '.') ?></td>
                                        <td><?= rtrim(rtrim($meal['protein'], '0'), '.') ?></td>
                                        <td><?= rtrim(rtrim($meal['carbs'], '0'), '.') ?></td>
                                        <td><?= rtrim(rtrim($meal['fats'], '0'), '.') ?></td>

                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <p class="text-muted fw-semibold">No meals assigned for <?= $day ?>.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

</div>



    <?php require_once __DIR__ . '/../includes/footer.php'; ?>