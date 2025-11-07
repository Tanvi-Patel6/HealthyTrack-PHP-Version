<?php
$page_title = "HealthyTrack - Forms"; 
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth_check.php';

// Fetch submitted forms
$sql = "SELECT bt.id, bt.height, bt.weight, bt.age, bt.gender, bt.goal, bt.blood_group, 
               bt.type AS diet_type, bt.created_at AS submitted_at, 
               u.name AS username
        FROM body_type bt
        JOIN user_register u ON bt.user_id = u.id
        ORDER BY bt.created_at DESC";

$result = $cn->query($sql);

require_once __DIR__ . '/../includes/header.php';
?>

<style>
  html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
    background: linear-gradient(135deg, #f8f9fa, #eef2ff);
  }

  #content {
    flex: 1;
    padding: 50px 20px;
  }

  .table-container {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    padding: 35px;
    animation: fadeInUp 0.8s ease;
  }

  h2 {
    font-weight: 700;
    color: #023047;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  h2 i {
    color: #710b81ff;
    font-size: 1.5rem;
  }

  /* 🔍 Search & Filter Bar */
  .search-bar {
    display: flex;
    justify-content: start;
    align-items: center;
    gap: 10px;
    margin-bottom: 25px;
    flex-wrap: wrap;
  }

  .search-bar input,
  .search-bar select {
    border-radius: 10px;
    border: 1px solid #ccc;
    padding: 10px 15px;
    transition: 0.3s;
  }

  .search-bar input:focus,
  .search-bar select:focus {
    outline: none;
    border-color: #710b81ff;
    box-shadow: 0 0 5px #710b81ff;
  }

  .filter-btn {
    background-color: #710b81ff;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    transition: 0.3s;
    font-weight: 500;
  }

  .filter-btn:hover {
    background-color: #570868;
    transform: scale(1.05);
  }

  table {
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
  }

  thead {
    background: #710b81ff;
    color: #fff;
  }

  tbody tr {
    transition: all 0.2s ease;
  }

  tbody tr:hover {
    background: #f1faff;
  }

  .no-results {
    color: #999;
    font-style: italic;
    text-align: center;
  }

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

<div class="container py-5" id="content">
  <div class="table-container">
    <h2><i class="bi bi-file-earmark-text-fill"></i> Submitted Body Type Forms</h2>

    <!-- 🔍 Search & Filter Bar -->
    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Search by Username..."  required>
      <select id="filterGender">
        <option value="">Filter by Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>
      <button class="filter-btn" id="filterBtn" type="submit"><i class="bi bi-funnel-fill"></i> Filter</button>
    </div>

    <!-- 🧾 Table -->
    <div class="table-responsive">
      <table class="table table-hover text-center align-middle" id="formsTable">
        <thead>
          <tr>
            <th>Username</th>
            <th>Height (cm)</th>
            <th>Weight (kg)</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Goal</th>
            <th>Blood Group</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['username']); ?></td>
                <td><?= htmlspecialchars($row['height']); ?></td>
                <td><?= htmlspecialchars($row['weight']); ?></td>
                <td><?= htmlspecialchars($row['age']); ?></td>
                <td><?= htmlspecialchars($row['gender']); ?></td>
                <td><?= htmlspecialchars($row['goal']); ?></td>
                <td><?= htmlspecialchars($row['blood_group']); ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="7" class="no-results">No forms submitted yet.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  const searchInput = document.getElementById('searchInput');
  const filterGender = document.getElementById('filterGender');
  const filterBtn = document.getElementById('filterBtn');
  const rows = document.querySelectorAll('#formsTable tbody tr');

  filterBtn.addEventListener('click', () => {
    const searchValue = searchInput.value.toLowerCase();
    const genderValue = filterGender.value.toLowerCase();

    let visibleCount = 0;

    rows.forEach(row => {
      const username = row.cells[0].innerText.toLowerCase();
      const gender = row.cells[4].innerText.toLowerCase();

      if (
        (username.includes(searchValue) || searchValue === '') &&
        (gender === genderValue || genderValue === '')
      ) {
        row.style.display = '';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    });

    // Show message if no results
    if (visibleCount === 0) {
      if (!document.querySelector('.no-results-row')) {
        const tbody = document.querySelector('#formsTable tbody');
        const tr = document.createElement('tr');
        tr.classList.add('no-results-row');
        tr.innerHTML = `<td colspan="7" class="no-results">No results found.</td>`;
        tbody.appendChild(tr);
      }
    } else {
      const existing = document.querySelector('.no-results-row');
      if (existing) existing.remove();
    }
  });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
