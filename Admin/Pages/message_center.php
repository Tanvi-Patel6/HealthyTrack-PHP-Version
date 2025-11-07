<?php
$page_title = "Message Center";
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/header.php';

// Fetch Contact Messages
$contact_result = mysqli_query($cn, "SELECT * FROM contact_messages ORDER BY created_at DESC");

// Fetch Feedback Messages
$feedback_result = mysqli_query($cn, "SELECT * FROM feedback_messages ORDER BY created_at DESC");
?>


<style>

    body{
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }
</style>
<div id="content" class="container py-5">
    <h2 class="mb-4">📨 Message Center</h2>

    <ul class="nav nav-tabs mb-4" id="messageTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab">Contact Messages</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="feedback-tab" data-bs-toggle="tab" data-bs-target="#feedback" type="button" role="tab">Feedback Messages</button>
      </li>
    </ul>

    <div class="tab-content">
        <!-- Contact Messages -->
        <div class="tab-pane fade show active" id="contact" role="tabpanel">
            <table class="table table-hover table-striped table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Received At</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; while($row = mysqli_fetch_assoc($contact_result)): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['subject']) ?></td>
                        <td><?= htmlspecialchars($row['message']) ?></td>
                        <td><?= $row['created_at'] ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Feedback Messages -->
        <div class="tab-pane fade" id="feedback" role="tabpanel">
            <table class="table table-hover table-striped table-bordered">
                <thead class="table-info">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Feedback</th>
                        <th>Received At</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; while($row = mysqli_fetch_assoc($feedback_result)): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['feedback']) ?></td>
                        <td><?= $row['created_at'] ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Initialize Bootstrap tabs
    var triggerTabList = [].slice.call(document.querySelectorAll('#messageTabs button'))
    triggerTabList.forEach(function (triggerEl) {
      var tabTrigger = new bootstrap.Tab(triggerEl)
      triggerEl.addEventListener('click', function (event) {
        event.preventDefault()
        tabTrigger.show()
      })
    })
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
