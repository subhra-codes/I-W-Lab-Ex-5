<?php
$pageTitle = "Add Employee";
require_once __DIR__ . "/config/database.php";

$success = isset($_GET["success"]);
$error = $_GET["error"] ?? "";

$old = [
    "employee_id" => "",
    "full_name" => "",
    "email" => "",
    "phone" => "",
    "department" => "",
    "designation" => "",
    "joining_date" => date("Y-m-d")
];

require __DIR__ . "/includes/header.php";
?>

<section class="hero">
    <div>
        <span class="eyebrow">EMPLOYEE MANAGEMENT SYSTEM</span>
        <h1>Register a new employee.</h1>
        <p>Enter verified employee information and securely store it in the MySQL database.</p>
    </div>
    <div class="hero-badge">
        <span>●</span> Database Connected
    </div>
</section>

<?php if ($success): ?>
    <div class="alert success">
        <strong>Employee added successfully.</strong>
        The employee record has been saved to the database.
        <a href="admin.php">View all employees →</a>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<section class="form-card">
    <div class="card-heading">
        <div>
            <span class="section-label">EMPLOYEE DETAILS</span>
            <h2>Personal & professional information</h2>
        </div>
        <span class="required-note">* Required</span>
    </div>

    <form action="save_employee.php" method="POST" id="employeeForm" novalidate>
        <div class="form-grid">
            <div class="field">
                <label for="employee_id">Employee ID <span>*</span></label>
                <input id="employee_id" name="employee_id" type="text" placeholder="e.g. EMP-1001"
                       maxlength="20" required pattern="[A-Za-z0-9-]{3,20}">
                <small>3–20 characters; letters, numbers and hyphens.</small>
            </div>

            <div class="field">
                <label for="full_name">Full Name <span>*</span></label>
                <input id="full_name" name="full_name" type="text" placeholder="e.g. Rahul Sharma"
                       maxlength="100" required>
            </div>

            <div class="field">
                <label for="email">Official Email <span>*</span></label>
                <input id="email" name="email" type="email" placeholder="name@company.com"
                       maxlength="150" required>
                <small>Must be a valid email address.</small>
            </div>

            <div class="field">
                <label for="phone">Phone Number <span>*</span></label>
                <input id="phone" name="phone" type="tel" placeholder="9876543210"
                       inputmode="numeric" maxlength="10" required pattern="[6-9][0-9]{9}">
                <small>Valid Indian mobile number: 10 digits, starting with 6–9.</small>
            </div>

            <div class="field">
                <label for="department">Department <span>*</span></label>
                <select id="department" name="department" required>
                    <option value="">Select department</option>
                    <option>Engineering</option>
                    <option>Human Resources</option>
                    <option>Finance</option>
                    <option>Marketing</option>
                    <option>Sales</option>
                    <option>Operations</option>
                    <option>Design</option>
                </select>
            </div>

            <div class="field">
                <label for="designation">Designation <span>*</span></label>
                <input id="designation" name="designation" type="text" placeholder="e.g. Software Engineer"
                       maxlength="100" required>
            </div>

            <div class="field">
                <label for="joining_date">Joining Date <span>*</span></label>
                <input id="joining_date" name="joining_date" type="date"
                       value="<?= date("Y-m-d") ?>" required>
            </div>
        </div>

        <div class="form-actions">
            <p><span class="dot"></span> All submitted information is validated before storage.</p>
            <button class="btn primary" type="submit">Save Employee <span>→</span></button>
        </div>
    </form>
</section>

<section class="info-strip">
    <div><strong>Server-side validation</strong><span>PHP validates every field before database insertion.</span></div>
    <div><strong>Secure queries</strong><span>PDO prepared statements prevent SQL injection.</span></div>
    <div><strong>Unique records</strong><span>Employee ID, email and phone are unique.</span></div>
</section>

<script>
const phone = document.getElementById("phone");
phone.addEventListener("input", () => {
    phone.value = phone.value.replace(/\D/g, "").slice(0, 10);
});

document.getElementById("employee_id").addEventListener("input", function () {
    this.value = this.value.toUpperCase().replace(/[^A-Z0-9-]/g, "").slice(0, 20);
});
</script>

<?php require __DIR__ . "/includes/footer.php"; ?>
