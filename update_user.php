<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("patientHeader.php"); // Header file

// DB Connection
$db = mysqli_connect("localhost", "root", "", "meditronix_new");

if (!$db) {
    die("<div class='container mt-5'><div class='alert alert-danger'>❌ Database connection failed.</div></div>");
}

// Validate patient ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>⚠️ Invalid patient ID provided.</div></div>";
    include("patientFooter.php");
    exit;
}

$patient_id = intval($_GET['id']);
$result = mysqli_query($db, "SELECT * FROM patients WHERE id = $patient_id");

if (mysqli_num_rows($result) != 1) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>⚠️ Patient not found.</div></div>";
    include("patientFooter.php");
    exit;
}

$patient = mysqli_fetch_assoc($result);

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id           = intval($_POST['user_id']);
    $gender            = mysqli_real_escape_string($db, $_POST['gender']);
    $dob               = mysqli_real_escape_string($db, $_POST['dob']);
    $blood_group       = mysqli_real_escape_string($db, $_POST['blood_group']);
    $emergency_contact = mysqli_real_escape_string($db, $_POST['emergency_contact']);
    $profile_picture   = mysqli_real_escape_string($db, $_POST['profile_picture']);
    $status            = mysqli_real_escape_string($db, $_POST['status']);
    $created_at        = date('Y-m-d H:i:s');

    // Final update query for patients
    $updateQuery = "UPDATE `patients` SET 
        `user_id`='$user_id',
        `gender`='$gender',
        `dob`='$dob',
        `blood_group`='$blood_group',
        `emergency_contact`='$emergency_contact',
        `profile_picture`='$profile_picture',
        `status`='$status',
        `created_at`='$created_at'
        WHERE id = $patient_id";

    $update = mysqli_query($db, $updateQuery);

    if ($update) {
        echo "<div class='container mt-5 pt-5'><div class='alert alert-success text-center fw-bold'>✅ Patient profile updated successfully.</div></div>";
        $result = mysqli_query($db, "SELECT * FROM patients WHERE id = $patient_id");
        $patient = mysqli_fetch_assoc($result);
    } else {
        echo "<div class='container mt-5 pt-5'><div class='alert alert-danger text-center fw-bold'>❌ Failed to update patient profile. Please try again.</div></div>";
    }
}
?>

<!-- 🔷 Stylish Heading -->
<div class="container text-center" style="margin-top: 150px;">
    <h1 class="display-5 fw-bold text-primary" style="letter-spacing: 1px;">
        🏥 Patient Profile Management
    </h1>
    <p class="text-muted fst-italic" style="font-size: 25px;">
        <span style="font-size: 20px;">🩺</span> "Every small detail you update today strengthens patient care tomorrow."
    </p>
</div>


<!-- 🌐 Update Patient Form UI -->
<div class="container py-5" style="max-width: 720px;">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">✏️ Update Patient Profile</h3>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label fw-bold">User ID (Reference)</label>
                    <input type="text" name="user_id" value="<?= htmlspecialchars($patient['user_id']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Gender</label>
                    <input type="text" name="gender" value="<?= htmlspecialchars($patient['gender']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Date of Birth</label>
                    <input type="date" name="dob" value="<?= htmlspecialchars($patient['dob']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Blood Group</label>
                    <input type="text" name="blood_group" value="<?= htmlspecialchars($patient['blood_group']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Emergency Contact</label>
                    <input type="text" name="emergency_contact" value="<?= htmlspecialchars($patient['emergency_contact']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Profile Picture (Filename Only)</label>
                    <input type="text" name="profile_picture" value="<?= htmlspecialchars($patient['profile_picture']) ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="active" <?= $patient['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $patient['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success px-5 py-2 fw-bold">✅ Save Changes</button>
                    <a href="all_update_user.php" class="btn btn-outline-secondary px-4 py-2 ms-3">↩️ Back to Table</a>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include("patientFooter.php"); ?>
