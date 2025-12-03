<?php
$page_title = "HealthyTrack - List of Meals";
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth_check.php';

//  Handle delete
if (isset($_GET['delete'])) {
    $mealId = intval($_GET['delete']);
    $cn->query("DELETE FROM meal_plans WHERE id = $mealId");
    header("Location: list_meal.php?deleted=1");
    exit();
}

$search = $_GET['search'] ?? "";
$search_date = $_GET['search_date'] ?? "";

$where = "";

// Text search
if ($search != "") {
    $where .= " AND (m.meal_name LIKE '%$search%' OR u.name LIKE '%$search%')";
}

// Date search
if ($search_date != "") {
    $where .= " AND m.meal_date = '$search_date'";
}

// Final query
$query = "
    SELECT m.id, u.name AS username, m.meal_name, m.calories, m.protein,
           m.carbs, m.fats, m.meal_day, m.meal_time, m.meal_date
    FROM meal_plans m
    JOIN user_register u ON m.user_id = u.id
    WHERE 1 $where
    ORDER BY m.id DESC
";


$meals = $cn->query($query);

require_once __DIR__ . '/../includes/header.php';
?>

<style>
    /* Main content */
    #content {
        margin-left: 220px;
        padding: 20px 25px;
        min-height: 100vh;
        background-color: #f4f7fa;
        width: 1300px;
    }

    /* Container card */
    .container {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    /* Headings */
    h2 {
        color: #264653;
        font-weight: 700;
        text-align: center;
        margin-bottom: 25px;
    }



    /* Buttons */
    form .btn-custom {
        border-radius: 8px;
        font-weight: 600;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }

    form .btn-custom:hover {
        transform: translateY(-2px);
    }

    /* Table styling */
    .table {
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        background-color: #ffffff;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    .table thead th {
        background-color: #2a9d8f;
        color: #fff;
        text-align: center;
        vertical-align: middle;
        font-weight: 600;
        padding: 12px 8px;
        border: none;
    }

    .table tbody tr {
        background: #f9f9f9;
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #e6f7f3;
        transform: scale(1.01);
    }

    .table th,
    .table td {
        padding: 10px 8px;
        text-align: center;
        font-size: 14px;
        word-break: break-word;
    }

    /* Action buttons */
    .btn-sm.btn-custom {
        padding: 5px 10px;
        font-size: 13px;
        border-radius: 6px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        #content {
            margin-left: 0;
            padding: 20px;
        }

        form.row.g-3 {
            grid-template-columns: 1fr;
        }

        .table th,
        .table td {
            font-size: 12px;
            padding: 8px 5px;
        }

        .btn-sm.btn-custom {
            font-size: 12px;
            padding: 4px 8px;
        }
    }

    /* Alert messages */
    .alert {
        border-radius: 10px;
        font-weight: 500;
        margin-bottom: 20px;
    }
</style>

<div class="container" id="content">
    <h2 class="text-center mb-4" style="color:#333d29;">
        <i class="bi bi-list-check me-2"></i>All Meal Plans
    </h2>

    <!--  Success Message -->
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success text-center shadow-sm">
            ✅ Meal plan deleted successfully!
        </div>
    <?php endif; ?>

    <!--  Search Bar -->
    <form method="GET" class="row g-3 mb-4">

        <!-- Search Text -->
        <div class="col-md-4">
            <label class="form-label">Search</label>
            <input
                type="text"
                name="search"
                class="form-control shadow-sm"
                placeholder="Search by user or meal name..."
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        </div>

        <!-- Search by Date -->
        <div class="col-md-4">
            <label class="form-label">Search by Date</label>
            <input
                type="date"
                name="search_date"
                class="form-control shadow-sm"
                value="<?= htmlspecialchars($_GET['search_date'] ?? '') ?>">
        </div>

        <!-- Search Button -->
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-success w-100 btn-custom shadow-sm">
                <i class="bi bi-search"></i> Search
            </button>
        </div>

        <!-- Reset Button -->
        <div class="col-md-2 d-flex align-items-end">
            <a href="list_meal.php" class="btn btn-secondary w-100 btn-custom shadow-sm">
                <i class="bi bi-x-circle"></i> Reset
            </a>
        </div>

    </form>



    <!-- ✅ Meals Table -->
    <div class="table-responsive mt-4" style="overflow-x:auto;">
        <table class="table align-middle text-center shadow-sm">
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
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($meals->num_rows > 0): ?>
                    <?php while ($meal = $meals->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($meal['username']) ?></strong></td>
                            <td><?= htmlspecialchars($meal['meal_name']) ?></td>
                            <td><?= rtrim(rtrim($meal['calories'], '0'), '.') ?></td>
                            <td><?= rtrim(rtrim($meal['protein'], '0'), '.') ?></td>
                            <td><?= rtrim(rtrim($meal['carbs'], '0'), '.') ?></td>
                            <td><?= rtrim(rtrim($meal['fats'], '0'), '.') ?></td>
                            <td><?= htmlspecialchars($meal['meal_day']) ?></td>
                            <td><?= htmlspecialchars($meal['meal_time']) ?></td>
                            <td><?= htmlspecialchars($meal['meal_date']); ?></td>
                            <td>
                                <a href="assign_meal.php?edit=<?= $meal['id'] ?>"
                                    class="btn btn-warning btn-sm btn-custom">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a><br><br>
                                <a href="?delete=<?= $meal['id'] ?>"
                                    class="btn btn-danger btn-sm btn-custom"
                                    onclick="return confirm('Are you sure you want to delete this meal plan?');">
                                    <i class="bi bi-trash-fill"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-danger text-center py-3">
                            No meal plans found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>