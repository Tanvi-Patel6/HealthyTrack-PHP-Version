<?php
$page_title = "HealthyTrack - Manage Admins"; 
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth_check.php'; 

// ✅ Only allow logged-in admins
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// ✅ Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); 

    // Prevent deleting yourself
    if ($delete_id == $_SESSION['user_id']) {
        $msg = "❌ You cannot delete your own account!";
    } else {
        $cn->query("DELETE FROM admin WHERE id = $delete_id");
        $msg = "✅ Admin deleted successfully!";
    }
}

// ✅ Fetch all admins
$result = $cn->query("SELECT id, email, created_at FROM admin");

require_once __DIR__ . '/../includes/header.php';
?>

<style>
  html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
    background: linear-gradient(135deg, #f9f9ff, #e3e4ff);
    font-family: 'Poppins', sans-serif;
  }

  #content {
    flex: 1;
    padding: 50px 20px;
  }

  .admin-container {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    padding: 40px;
    animation: fadeInUp 0.7s ease;
  }

  h2 {
    font-weight: 700;
    color: #023047;
    margin-bottom: 30px;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
  }

  h2 i {
    color: #710b81ff;
  }

  .alert {
    border-radius: 10px;
    font-weight: 500;
    width: 80%;
    margin: 0 auto 20px auto;
  }

  .table {
    border-radius: 12px;
    overflow: hidden;
    background: white;
  }

  thead {
    background: #710b81ff;
    color: white;
  }

  tbody tr {
    transition: all 0.2s ease;
  }

  tbody tr:hover {
    background: #f1faff;
    transform: scale(1.01);
  }

  .btn-danger {
    background: #e63946;
    border: none;
    border-radius: 8px;
    transition: 0.3s;
    font-weight: 500;
  }

  .btn-danger:hover {
    background: #ba1b1d;
    transform: scale(1.05);
  }

  .badge {
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 0.85rem;
  }

  /* Add subtle fade animation */
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(15px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>

<div id="content" class="container py-5">
  <div class="admin-container">
    <h2><i class="bi bi-person-gear"></i> Manage Admins</h2>

    <?php if (!empty($msg)) { ?>
      <div class="alert alert-info text-center shadow-sm">
        <?php echo $msg; ?>
      </div>
    <?php } ?>

    <div class="table-responsive">
      <table class="table table-hover text-center align-middle shadow-sm">
        <thead>
          <tr>
            <th>Email</th>
            <th>Created At</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()) { ?>
              <tr>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= htmlspecialchars($row['created_at']); ?></td>
                <td>
                  <?php if ($row['id'] != $_SESSION['user_id']) { ?>
                    <a href="?delete_id=<?= $row['id']; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure you want to delete this admin?');">
                       <i class="bi bi-trash3"></i> Delete
                    </a>
                  <?php } else { ?>
                    <span class="badge bg-secondary"><i class="bi bi-person-circle"></i> Your Account</span>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
          <?php else: ?>
            <tr><td colspan="3" class="text-muted">No admins found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
