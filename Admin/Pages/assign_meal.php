<?php
$page_title = "HealthyTrack - Assign Meal";
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth_check.php';

// ✅ Handle form submission
if (isset($_POST['assign_meal'])) {
    $user_id = $_POST['user_id'];
    $meal_name = $_POST['meal_name'];
    $calories = $_POST['calories'];
    $protein = $_POST['protein'];
    $carbs = $_POST['carbs'];
    $fats = $_POST['fats'];
    $meal_day = $_POST['meal_day'];
    $meal_time = $_POST['meal_time'];
    $meal_date = $_POST['meal_date'];


    if ($calories < 0 || $protein < 0 || $carbs < 0 || $fats < 0) {
        $error_message = "❌ Nutritional values cannot be negative!";
    } else {
        $sql = "INSERT INTO meal_plans (user_id, meal_name, calories, protein, carbs, fats, meal_day, meal_time, meal_date)
        VALUES ('$user_id', '$meal_name', '$calories', '$protein', '$carbs', '$fats', '$meal_day', '$meal_time', '$meal_date')";

        $cn->query($sql);
        header("Location: assign_meal.php?success=1");
        exit();
    }
}

// ✅ Fetch users and meals
$users = $cn->query("SELECT DISTINCT id, name FROM user_register ORDER BY name ASC");
$meals = $cn->query("SELECT m.id, u.name AS username, m.meal_name, m.calories, m.protein, m.carbs, m.fats, m.meal_day, m.meal_time, m.meal_date 
                    FROM meal_plans m 
                    JOIN user_register u ON m.user_id = u.id
                    ORDER BY m.id DESC LIMIT 5");

// ✅ Edit meal
$editMeal = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = $cn->query("SELECT * FROM meal_plans WHERE id = $id");
    $editMeal = $result->fetch_assoc();
}

if (isset($_POST['update_meal'])) {
    $id = $_POST['id'];
    $meal_name = $_POST['meal_name'];
    $calories = $_POST['calories'];
    $protein = $_POST['protein'];
    $carbs = $_POST['carbs'];
    $fats = $_POST['fats'];
    $meal_day = $_POST['meal_day'];
    $meal_time = $_POST['meal_time'];
    $meal_date = $_POST['meal_date'];


    $sql =  "UPDATE meal_plans 
        SET meal_name='$meal_name', calories='$calories', protein='$protein', 
            carbs='$carbs', fats='$fats', meal_day='$meal_day', meal_time='$meal_time',
            meal_date='$meal_date'
        WHERE id=$id";
    $cn->query($sql);
    header("Location: assign_meal.php?updated=1");
    exit();
}

require_once __DIR__ . '/../includes/header.php';
?>

<style>
    /* Sidebar Layout */
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: #f0fdf4;
    }

    .sidebar {
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        background-color: #264653;
        color: white;
        padding: 20px 15px;
        overflow-y: auto;
    }

    .sidebar h2 {
        color: #ffffff;
        font-size: 20px;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Main content */

    #content {
        margin-left: 250px;
        /* sidebar width */
        padding: 30px 20px;
        width: 1250px;
        /* keeps form & table from stretching too wide */
    }



    /* Form */
    form {
        background: #ffffff;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        margin-bottom: 40px;
    }

    .form-label {
        font-weight: 600;
        color: #264653;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 8px 10px;
        width: 100%;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #2a9d8f;
        box-shadow: 0 0 5px rgba(42, 157, 143, 0.3);
        outline: none;
    }




    /* Buttons */
    .btn-primary,
    .btn-warning,
    .btn-secondary {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-primary {
        background-color: #2a9d8f;
        color: #fff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #21867a;
    }

    .btn-warning {
        background-color: #f4a261;
        color: #fff;
        border: none;
    }

    .btn-warning:hover {
        background-color: #e76f51;
    }

    .btn-secondary {
        background-color: #adb5bd;
        color: #fff;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #868e96;
    }

    /* Table */
    .table {
        border-radius: 12px;
        overflow: hidden;
        background-color: #ffffff;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
    }

    .table thead {
        background-color: #2a9d8f;
        color: #fff;
        font-weight: 600;
    }

    .table tbody tr:hover {
        background-color: #e6f7f3;
    }

    .table th,
    .table td {
        padding: 10px;
        text-align: center;
        font-size: 14px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        #content {
            margin-left: 0;
            padding: 20px;
        }

        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }

        form .col-md-2,
        form .col-md-3,
        form .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 15px;
        }
    }
</style>


<div id="content" class="container">
    <h2>Assign Meals to Users</h2>
    <br>

    <!-- Assign Meal Form -->
    <form method="POST" class="row g-3 mb-5">
        <div class="col-md-4">
            <label for="user_id" class="form-label">Select User</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">-- Select User --</option>
                <?php
                $users = $cn->query("SELECT DISTINCT id, name FROM user_register ORDER BY name ASC");
                while ($row = $users->fetch_assoc()) {
                    $selected = ($editMeal && $editMeal['user_id'] == $row['id']) ? 'selected' : '';
                    echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-4">
            <label for="meal_name" class="form-label">Meal Name</label>
            <input type="text" name="meal_name" id="meal_name" class="form-control" value="<?= $editMeal['meal_name'] ?? '' ?>" required>
        </div>

        <div class="col-md-2">
            <label for="calories" class="form-label">Calories</label>
            <input type="number" step="any" name="calories" id="calories" class="form-control" value="<?= $editMeal['calories'] ?? '' ?>" required>
        </div>

        <div class="col-md-2">
            <label for="protein" class="form-label">Protein</label>
            <input type="number" step="any" name="protein" id="protein" class="form-control" value="<?= $editMeal['protein'] ?? '' ?>" required>
        </div>

        <div class="col-md-2">
            <label for="carbs" class="form-label">Carbs</label>
            <input type="number" step="any" name="carbs" id="carbs" class="form-control" value="<?= $editMeal['carbs'] ?? '' ?>" required>
        </div>

        <div class="col-md-2">
            <label for="fats" class="form-label">Fats</label>
            <input type="number" step="any" name="fats" id="fats" class="form-control" value="<?= $editMeal['fats'] ?? '' ?>" required>
        </div>

        <div class="col-md-3">
            <label for="meal_day" class="form-label">Meal Day</label>
            <select name="meal_day" id="meal_day" class="form-select" required>
                <option value="">-- Select Day --</option>
                <?php
                $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                foreach ($days as $day) {
                    $selected = ($editMeal && $editMeal['meal_day'] == $day) ? 'selected' : '';
                    echo "<option $selected>$day</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-3">
            <label for="meal_time" class="form-label">Meal Time</label>
            <select name="meal_time" id="meal_time" class="form-select" required>
                <option value="">-- Select Time --</option>
                <?php
                $times = ["Breakfast", "Lunch", "Dinner"];
                foreach ($times as $time) {
                    $selected = ($editMeal && $editMeal['meal_time'] == $time) ? 'selected' : '';
                    echo "<option $selected>$time</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-3">
            <label for="meal_date" class="form-label">Meal Date</label>
            <input type="date" name="meal_date" id="meal_date"
                class="form-control"
                value="<?= $editMeal['meal_date'] ?? '' ?>" required>
        </div>


        <div class="col-12 text-center mt-3">
            <?php if ($editMeal) { ?>
                <input type="hidden" name="id" value="<?= $editMeal['id'] ?>">
                <button type="submit" name="update_meal" class="btn btn-warning px-4">Update Meal</button>
                <a href="assign_meal.php" class="btn btn-secondary px-4">Cancel</a>
            <?php } else { ?>
                <button type="submit" name="assign_meal" class="btn btn-primary px-4">Assign Meal</button>
            <?php } ?>
        </div>

        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger text-center"><?= $error_message ?></div>
        <?php } ?>
    </form>

    <!-- Assigned Meals Table -->
    <h3>Recently Assigned Meals</h3><br>
    <table class="table table-bordered table-striped text-center">
        <thead>
            <tr>
                <th>User</th>
                <th>Meal Name</th>
                <th>Calories</th>
                <th>Protein</th>
                <th>Carbs</th>
                <th>Fats</th>
                <th>Day</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($meal = $meals->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($meal['username']); ?></td>
                    <td><?= htmlspecialchars($meal['meal_name']); ?></td>
                    <td><?= rtrim(rtrim($meal['calories'], '0'), '.'); ?></td>
                    <td><?= rtrim(rtrim($meal['protein'], '0'), '.'); ?></td>
                    <td><?= rtrim(rtrim($meal['carbs'], '0'), '.'); ?></td>
                    <td><?= rtrim(rtrim($meal['fats'], '0'), '.'); ?></td>
                    <td><?= htmlspecialchars($meal['meal_day']); ?></td>
                    <td><?= htmlspecialchars($meal['meal_time']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>