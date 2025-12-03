<?php


$page_title = "HealthyTrack - Dashboard";
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../includes/header.php';

// Count total users
$totalUsers = $cn->query("SELECT COUNT(*) as c FROM user_register")->fetch_assoc()['c'];

// Count total admins
$totalAdmins = $cn->query("SELECT COUNT(*) as c FROM admin")->fetch_assoc()['c'];

//Count total body type form submitted
$totalBodyType =  $cn->query("SELECT COUNT(*) as c FROM body_type")->fetch_assoc()['c'];

//Count total meal plans
$totalMealPlans =  $cn->query("SELECT COUNT(*) as c FROM meal_plans")->fetch_assoc()['c'];

//body analysis details
$sql = "SELECT bt.id, bt.height, bt.weight, bt.age, bt.gender, bt.goal, bt.blood_group, 
            bt.type AS diet_type, bt.created_at AS submitted_at, 
            u.name AS username
        FROM body_type bt
        JOIN user_register u ON bt.user_id = u.id
        ORDER BY bt.created_at DESC
        LIMIT 1";

$result = $cn->query($sql);


?>

<head>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;

        }

        #content {

            width: 1250px;
            /* optional: limit width */
        }


        .hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body>
    <div id="content" class="container py-5">
        <div class="container-fluid p-10">
            <!-- Quick Stats -->
            <div class="row g-3 mb-4 ">
                <div class="col-md-3 hover">
                    <div class="card shadow-sm text-center p-3 text-white" style="background-color:#22577a;">
                        <h5>Total Users</h5>
                        <h2><?= $totalUsers ?></h2>
                    </div>
                </div>
                <div class="col-md-3 hover">
                    <div class="card shadow-sm text-center p-3 text-white" style="background-color:#38a3a5;">
                        <h5>Total Admins</h5>
                        <h2><?= $totalAdmins ?></h2>
                    </div>
                </div>
                <div class="col-md-3 hover">
                    <div class="card shadow-sm text-center p-3  text-dark" style="background-color:#57cc99;">
                        <h5>Analyses Done</h5>
                        <h2><?= $totalBodyType ?></h2>
                    </div>
                </div>
                <div class="col-md-3 hover">
                    <div class="card shadow-sm text-center p-3  text-white" style="background-color:#80ed99;">
                        <h5>Meal Plans</h5>
                        <h2><?= $totalMealPlans ?></h2>
                    </div>
                </div>
            </div>

            <!-- Recent user login -->
            <div class="row g-3 mb-4">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <strong>Recent User Registrations</strong>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped  table-hover mb-0">
                                <thead class="table-info">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Registered Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch last 5 users
                                    $result1 = $cn->query("SELECT id, name, email, created_at FROM user_register ORDER BY id DESC LIMIT 2");

                                    if ($result1 && $result1->num_rows > 0) {
                                        $i = 1;
                                        while ($row = $result1->fetch_assoc()) {
                                            echo "<tr>
                                        <td>" . $i++ . "</td>
                                        <td>" . htmlspecialchars($row['name']) . "</td>
                                        <td>" . htmlspecialchars($row['email']) . "</td>
                                        <td>" . htmlspecialchars($row['created_at']) . "</td>
                                    </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center text-muted'>No recent users found.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- recent admin logins -->
            <div class="row g-3 mb-4">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <strong>Recent Admin Registrations</strong>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped  table-hover mb-0">
                                <thead class="table-info">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Registered Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch last 5 users
                                    $result2 = $cn->query("SELECT id, email,created_at FROM admin ORDER BY id DESC LIMIT 2");

                                    if ($result2 && $result2->num_rows > 0) {
                                        $i = 1;
                                        while ($row = $result2->fetch_assoc()) {
                                            echo "<tr>
                                        <td>" . $i++ . "</td>
                                        <td>" . htmlspecialchars($row['email']) . "</td>
                                        <td>" . htmlspecialchars($row['created_at']) . "</td>
                                    </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center text-muted'>No recent users found.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Body Type Analyses Section -->
            <div class="row g-3 mb-4">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <strong>Body Type Analyses</strong>
                        </div>
                        <div class="card-body">
                            <?php if ($result->num_rows > 0): ?>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Height (cm)</th>
                                            <th>Weight (kg)</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Goal</th>
                                            <th>Blood Group</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo $row['username'] ?></td>
                                                <td><?php echo $row['height'] ?></td>
                                                <td><?php echo $row['weight'] ?></td>
                                                <td><?php echo $row['age'] ?></td>
                                                <td><?php echo $row['gender'] ?></td>
                                                <td><?php echo $row['goal'] ?></td>
                                                <td><?php echo $row['blood_group'] ?></td>
                                                <td><?php echo $row['diet_type'] ?></td>
                                                <td><?php echo date("d M Y H:i", strtotime($row['submitted_at'])) ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p class="text-center text-muted">No body type analyses found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>




    <?php
    require_once __DIR__ . '/../includes/footer.php';
    ?>

</body>