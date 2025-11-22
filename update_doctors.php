<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("doctorHeader.php");

// DB Connection
$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("<div class='container mt-5'><div class='alert alert-danger'>❌ Database connection failed.</div></div>");
}

// Validate doctor ID from query string
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>⚠️ Invalid doctor ID provided.</div></div>";
    include("doctorFooter.php");
    exit;
}

$doctor_id = intval($_GET['id']);
$result = mysqli_query($db, "SELECT * FROM doctors WHERE id = $doctor_id");

if (mysqli_num_rows($result) != 1) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>⚠️ Doctor not found.</div></div>";
    include("doctorFooter.php");
    exit;
}

$doctor = mysqli_fetch_assoc($result);

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id       = mysqli_real_escape_string($db, $_POST['user_id']);
    $specialization = mysqli_real_escape_string($db, $_POST['specialization']);
    $experience    = mysqli_real_escape_string($db, $_POST['experience']);
    $availability  = mysqli_real_escape_string($db, $_POST['availability']);
    $status        = mysqli_real_escape_string($db, $_POST['status']);
    $created_at    = date('Y-m-d H:i:s');

    // Update query
    $updateQuery = "UPDATE doctors SET 
                        user_id = '$user_id',
                        specialization = '$specialization',
                        experience = '$experience',
                        availability = '$availability',
                        status = '$status',
                        created_at = '$created_at'
                    WHERE id = $doctor_id";

    $update = mysqli_query($db, $updateQuery);

    if ($update) {
        echo "<div class='container mt-5 pt-5' style='margin-top: 100px;'>
                <div class='alert alert-success text-center fw-bold'>
                    ✅ Doctor profile updated successfully.
                </div>
              </div>";
        $result = mysqli_query($db, "SELECT * FROM doctors WHERE id = $doctor_id");
        $doctor = mysqli_fetch_assoc($result);
    } else {
        echo "<div class='container mt-5 pt-5' style='margin-top: 100px;'>
                <div class='alert alert-danger text-center fw-bold'>
                    ❌ Failed to update doctor profile.
                </div>
              </div>";
    }
}
?>

<!-- Doctor Update Form -->
<div class="container py-5" style="margin-top: 60px; max-width: 720px;">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">✏️ Update Doctor Profile</h3>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label fw-bold">User ID</label>
                    <input type="text" name="user_id" value="<?= htmlspecialchars($doctor['user_id']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Specialization</label>
                    <input type="text" name="specialization" value="<?= htmlspecialchars($doctor['specialization']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Experience (Years)</label>
                    <input type="number" name="experience" value="<?= htmlspecialchars($doctor['experience']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Availability</label>
                    <input type="text" name="availability" value="<?= htmlspecialchars($doctor['availability']) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="active" <?= $doctor['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $doctor['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success px-5 py-2 fw-bold">✅ Save Changes</button>
                    <a href="javascript:window.close()" class="btn btn-outline-secondary px-4 py-2 ms-3">❌ Close</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("doctorFooter.php"); ?>
