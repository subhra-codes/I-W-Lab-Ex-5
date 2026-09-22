<?php
$pageTitle = "Admin Dashboard";
require_once __DIR__ . "/config/database.php";

$search = trim($_GET["search"] ?? "");

if ($search !== "") {
    $stmt = $pdo->prepare(
        "SELECT * FROM employees
         WHERE employee_id LIKE :q
            OR full_name LIKE :q
            OR email LIKE :q
            OR phone LIKE :q
            OR department LIKE :q
            OR designation LIKE :q
         ORDER BY created_at DESC"
    );
    $stmt->execute([":q" => "%$search%"]);
    $employees = $stmt->fetchAll();
} else {
    $employees = $pdo->query("SELECT * FROM employees ORDER BY created_at DESC")->fetchAll();
}

$total = (int) $pdo->query("SELECT COUNT(*) FROM employees")->fetchColumn();
$departments = (int) $pdo->query("SELECT COUNT(DISTINCT department) FROM employees")->fetchColumn();
$today = (int) $pdo->query("SELECT COUNT(*) FROM employees WHERE DATE(created_at) = CURDATE()")->fetchColumn();

require __DIR__ . "/includes/header.php";
?>

<section class="dashboard-head">
    <div>
        <span class="eyebrow">ADMIN CONSOLE</span>
        <h1>Employee directory</h1>
        <p>View and search all employee records stored in the database.</p>
    </div>
    <a class="btn primary" href="index.php">+ Add Employee</a>
</section>

<section class="stats-grid">
    <div class="stat-card"><span>Total Employees</span><strong><?= $total ?></strong><small>All stored records</small></div>
    <div class="stat-card"><span>Departments</span><strong><?= $departments ?></strong><small>Active departments</small></div>
    <div class="stat-card"><span>Added Today</span><strong><?= $today ?></strong><small>New records today</small></div>
</section>

<section class="table-card">
    <div class="table-toolbar">
        <div>
            <span class="section-label">EMPLOYEE RECORDS</span>
            <h2><?= $search !== "" ? "Search results" : "All employees" ?></h2>
        </div>
        <form class="search-form" method="GET">
            <input type="search" name="search" value="<?= htmlspecialchars($search) ?>"
                   placeholder="Search employee, email, department...">
            <button class="btn secondary" type="submit">Search</button>
            <?php if ($search !== ""): ?>
                <a class="clear-search" href="admin.php">Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <?php if (!$employees): ?>
        <div class="empty-state">
            <div class="empty-icon">◎</div>
            <h3>No employee records found</h3>
            <p>Add an employee or change your search query.</p>
            <a class="btn primary" href="index.php">Add First Employee</a>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Contact</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Joining Date</th>
                        <th>Added</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td>
                            <div class="employee-cell">
                                <span class="avatar"><?= htmlspecialchars(strtoupper(substr($employee["full_name"], 0, 1))) ?></span>
                                <div>
                                    <strong><?= htmlspecialchars($employee["full_name"]) ?></strong>
                                    <small><?= htmlspecialchars($employee["employee_id"]) ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="contact-cell">
                                <span><?= htmlspecialchars($employee["email"]) ?></span>
                                <small>+91 <?= htmlspecialchars($employee["phone"]) ?></small>
                            </div>
                        </td>
                        <td><span class="pill"><?= htmlspecialchars($employee["department"]) ?></span></td>
                        <td><?= htmlspecialchars($employee["designation"]) ?></td>
                        <td><?= htmlspecialchars(date("d M Y", strtotime($employee["joining_date"]))) ?></td>
                        <td><?= htmlspecialchars(date("d M Y", strtotime($employee["created_at"]))) ?></td>

                        <td>
                         <form action="delete_employee.php" method="POST"
                         onsubmit="return confirm('Are you sure you want to delete this employee? This action cannot be undone.');">

                         <input type="hidden" name="id" value="<?= (int)$employee["id"] ?>">

                        <button type="submit" class="delete-btn">
                     Delete
                </button>

               </form>
            </td>

            </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<?php require __DIR__ . "/includes/footer.php"; ?>
