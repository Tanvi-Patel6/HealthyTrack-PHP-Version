<?php
$page_title = "HealthyTrack - View Users";
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

// ✅ Handle search
$search = "";
if (isset($_GET['search']) && $_GET['search'] !== "") {
    $search = $cn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM user_register 
            WHERE name LIKE '%$search%' 
               OR email LIKE '%$search%'";
    $result = $cn->query($sql);
} else {
    $result = $cn->query("SELECT * FROM user_register");
}
?>

<style>
    body {
        background: linear-gradient(to right, #f0fdf4, #e6f7f3);

        min-height: 100vh;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    #content {
        width: 1250px;
    }

    h2 {
        font-weight: 700;
        letter-spacing: 1px;
        color: #264653;
        text-transform: uppercase;
    }

    /* Search Bar */
    .search-bar {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
        gap: 10px;
    }

    .search-bar input {
        border: 2px solid #2a9d8f;
        border-radius: 8px;
        padding: 10px 15px;
        width: 280px;
        font-size: 15px;
        transition: 0.3s;
    }

    .search-bar input:focus {
        outline: none;
        box-shadow: 0 0 5px #2a9d8f;
    }

    .search-bar button {
        background: #2a9d8f;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        transition: 0.3s;
    }

    .search-bar button:hover {
        background: #21867a;
        transform: scale(1.05);
    }

    /* Card Grid */
    .user-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        width: 80%;
        margin-left: 10%;
        margin-top: 30px;
    }

    /* Card Style */
    .user-card {
        background: white;
        border-radius: 18px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        padding: 25px;
        transition: 0.3s;
        border-top: 4px solid #2a9d8f;
    }

    .user-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .user-card h5 {
        color: #1d3557;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .user-card p {
        color: #555;
        font-size: 15px;
        margin: 5px 0;
    }

    .no-result {
        text-align: center;
        color: #e63946;
        font-weight: 600;
        font-size: 18px;
        margin-top: 40px;
    }

    /* Responsive Fix */
    @media (max-width: 600px) {
        .search-bar {
            flex-direction: column;
            align-items: center;
        }

        .search-bar input {
            width: 100%;
        }

        .search-bar button {
            width: 100%;
        }
    }
</style>

<div id="content" class="container">
    <!-- Title -->
    <h2 class="text-center mb-4">Registered Users</h2>

    <!-- Search Form -->
    <form method="GET" class="search-bar">
        <input
            type="text"
            name="search"
            placeholder="Search by name or email..."
            value="<?php echo htmlspecialchars($search); ?>"
            required>
        <button type="submit">🔍 Search</button>
    </form>

    <!-- User Cards -->
    <div class="user-grid">
        <?php if ($result->num_rows > 0) { ?>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="user-card">
                    <h5><?php echo htmlspecialchars($row['name']); ?></h5>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                    <p><strong>Registered:</strong> <?php echo htmlspecialchars($row['created_at']); ?></p>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p class="no-result">No users found.</p>
        <?php } ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>