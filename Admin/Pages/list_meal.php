<?php
$page_title = "HealthyTrack - List of Meals";
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth_check.php';

// ✅ Handle delete
if (isset($_GET['delete'])) {
    $mealId = intval($_GET['delete']);
    $cn->query("DELETE FROM meal_plans WHERE id = $mealId");
    header("Location: list_meal.php?deleted=1");
    exit();
}

// ✅ Handle search
$search = "";
$where = "";
if (!empty($_GET['search'])) {
    $search = $cn->real_escape_string($_GET['search']);
    $where = "WHERE m.meal_name LIKE '%$search%' OR u.name LIKE '%$search%'";
}

// ✅ Fetch meals
$query = "
    SELECT m.id, u.name AS username, m.meal_name, m.calories, m.protein, 
           m.carbs, m.fats, m.meal_day, m.meal_time
    FROM meal_plans m
    JOIN user_register u ON m.user_id = u.id
    $where
    ORDER BY m.id DESC
";
$meals = $cn->query($query);

require_once __DIR__ . '/../includes/header.php';
?>

<style>
body {
     height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
}
#content {
    flex: 1;
}
.container {
    background: rgba(255, 255, 255, 0.75);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    margin-top: 40px;
}
.table {
    border-collapse: separate;
    border-spacing: 0 10px;
}
.table thead th {
    background-color: #333d29;
    color: #fff;
    text-align: center;
    vertical-align: middle;
}
.table tbody tr {
    background: rgba(255,255,255,0.8);
    transition: 0.3s;
}
.table tbody tr:hover {
    background: #d8f3dc;
    transform: scale(1.01);
}
.search-bar {
    max-width: 400px;
    margin: 0 auto 20px;
}
.btn-custom {
    border-radius: 20px;
    font-weight: 500;
    transition: 0.3s;
}
.btn-custom:hover {
    transform: translateY(-2px);
}
.alert {
    border-radius: 15px;
}
</style>

<div class="container" id="content">
    <h2 class="text-center mb-4" style="color:#333d29;">
        <i class="bi bi-list-check me-2"></i>All Meal Plans
    </h2>

    <!-- ✅ Success Message -->
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success text-center shadow-sm">
            ✅ Meal plan deleted successfully!
        </div>
    <?php endif; ?>

    <!-- ✅ Search Bar -->
    <form class="d-flex search-bar" method="GET">
        <input 
            type="text" 
            name="search" 
            class="form-control me-2 shadow-sm" 
            placeholder="Search by user or meal name..." 
            value="<?= htmlspecialchars($search) ?>"
            required
        >
        <button class="btn btn-success btn-custom shadow-sm" type="submit">
            <i class="bi bi-search"></i> Search
        </button>
    </form>

    <!-- ✅ Meals Table -->
    <div class="table-responsive mt-4">
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
                            <td>
                                <a href="assign_meal.php?edit=<?= $meal['id'] ?>" 
                                   class="btn btn-warning btn-sm btn-custom">
                                   <i class="bi bi-pencil-square"></i> Edit
                                </a>
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
