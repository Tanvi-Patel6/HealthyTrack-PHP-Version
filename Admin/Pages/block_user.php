<?php


    $page_title = "HealthyTrack - Block User"; 
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth_check.php'; 


// Delete user if form submitted
if (isset($_POST['delete_id'])) {
    $delete_id = (int) $_POST['delete_id'];

    // Store query in a variable
    $sql = "DELETE FROM user_register WHERE id = $delete_id";

    // Execute query
    if ($cn->query($sql)) {
        $msg = "User deleted successfully!";
    } else {
        $msg = "Error deleting user: " . $cn->error;
    }
}


// Fetch all users
$result = $cn->query("SELECT id, name, email FROM user_register ORDER BY id DESC");

require_once __DIR__ . '/../includes/header.php';
?>
<head>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        #content {
        flex: 1; 
        }
    </style>
</head>
<body>
    <div id="content" class="container py-5" >
       <div class="container mt-5">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-danger text-white text-center">
            <h4>Delete User</h4>
            </div>
            <div class="card-body">

            <?php if (!empty($msg)): ?>
                <div class="alert alert-info"><?php echo $msg; ?></div>
            <?php endif; ?>

            <table class="table table-hover table-bordered align-middle">
                <thead class="table-danger">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td class="text-center">
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="delete_id" value="<?= $row['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this user?');">
                            Delete / Block
                            </button>
                        </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                    <td colspan="4" class="text-center text-muted">No users found</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <div class="text-center mt-3">
                <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>

            </div>
        </div>
        </div>
    </div>

<?php
    require_once __DIR__ . '/../includes/footer.php';
?>
</body>