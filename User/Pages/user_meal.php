<?php
session_start();
$page_title = "HealthyTrack - View Meals";

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/header.php';

$user_id = $_SESSION['user_id'];

// Filters
$day  = $_GET['meal_day']  ?? "";
$date = $_GET['meal_date'] ?? "";

// Base query
$sql = "SELECT * FROM meal_plans WHERE user_id = '$user_id'";

// Apply filters
if (isset($_GET['day_search']) && $day != "") {
  $sql .= " AND meal_day = '$day'";
}

if (isset($_GET['date_search']) && $date != "") {
  $sql .= " AND meal_date = '$date'";
}

$sql .= " ORDER BY meal_date ASC, meal_time ASC";
$result = mysqli_query($cn, $sql);
?>

<style>
  html,
  body {
    height: 100%;
  }

  body {
    display: flex;
    flex-direction: column;
    background: #f5f7fa;
  }

  .content-wrapper {
    flex: 1;
  }

  .container-custom {
    max-width: 1100px;
    margin: auto;
    padding: 20px 0;
  }

  /* Title */
  .page-title {
    font-size: 32px;
    font-weight: 700;
    color: #34495e;
    margin-bottom: 20px;
  }

  /* Search Box */
  .search-box {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    background: #fff;
    padding: 18px;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 25px;
  }

  .search-box label {
    font-weight: 600;
  }

  .search-box select,
  .search-box input[type="date"] {
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 15px;
    width: 180px;
  }

  .search-box button {
    padding: 11px 22px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: 0.2s;
  }

  .search-box .btn-day {
    background: #1f4e79;
    color: #fff;
  }

  .search-box .btn-day:hover {
    background: #163e5c;
  }

  .search-box .btn-date {
    background: #2b9348;
    color: #fff;
  }

  .search-box .btn-date:hover {
    background: #1f6f37;
  }

  .search-box .btn-reset {
    background: #6c757d;
    color: #fff;
  }

  .search-box .btn-reset:hover {
    background: #495057;
  }

  /* Table */
  .table-container {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  th {
    background: #1e293b;
    color: white;
    padding: 14px;
    text-align: left;
    font-size: 15px;
  }

  td {
    padding: 12px;
    border-bottom: 1px solid #e2e8f0;
    font-size: 14px;
  }

  tr:hover td {
    background: #f1f5f9;
  }

  .no-data {
    text-align: center;
    padding: 20px;
    font-size: 18px;
    font-weight: 500;
    color: #6b7280;
  }
</style>

<div class="content-wrapper">
  <div class="container container-custom">
    <h2 class="page-title"><i class="fas fa-utensils"></i> Your Meal Plan</h2>

    <!-- Search Section -->
    <form method="GET" class="search-box">
      <!-- Day Search -->
      <div>
        <label>Search by Day</label><br>
        <select name="meal_day">
          <option value="">-- Select Day --</option>
          <?php
          $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
          foreach ($days as $d) {
            $selected = ($day == $d) ? "selected" : "";
            echo "<option value='$d' $selected>$d</option>";
          }
          ?>
        </select>
      </div>
      <div class="d-flex align-items-end">
        <button type="submit" name="day_search" class="btn btn-day">Search Day</button>
      </div>

      <!-- Date Search -->
      <div>
        <label>Search by Date</label><br>
        <input type="date" name="meal_date" value="<?= htmlspecialchars($date) ?>">
      </div>
      <div class="d-flex align-items-end">
        <button type="submit" name="date_search" class="btn btn-date">Search Date</button>
      </div>

      <!-- Reset -->
      <div class="d-flex align-items-end">
        <a href="user_meal.php" class="btn btn-reset">Reset</a>
      </div>
    </form>

    <!-- Table -->
    <div class="table-container">
      <table>
        <tr>
          <th>Meal Time</th>
          <th>Meal Name</th>
          <th>Calories</th>
          <th>Protein</th>
          <th>Carbs</th>
          <th>Fats</th>
          <th>Day</th>
          <th>Date</th>
        </tr>

        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php while ($meal = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= htmlspecialchars($meal['meal_time']) ?></td>
              <td><?= htmlspecialchars($meal['meal_name']) ?></td>
              <td><?= rtrim(rtrim($meal['calories'], '0'), '.') ?></td>
              <td><?= rtrim(rtrim($meal['protein'], '0'), '.') ?></td>
              <td><?= rtrim(rtrim($meal['carbs'], '0'), '.') ?></td>
              <td><?= rtrim(rtrim($meal['fats'], '0'), '.') ?></td>
              <td><?= htmlspecialchars($meal['meal_day']) ?></td>
              <td><?= htmlspecialchars($meal['meal_date']) ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="8" class="no-data">No meals found.</td>
          </tr>
        <?php endif; ?>
      </table>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>