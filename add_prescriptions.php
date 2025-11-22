<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("doctorHeader.php");

// Message placeholder
$prescriptionMsg = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = mysqli_connect("localhost", "root", "", "meditronix_new");
    if (!$db) {
        die("<div class='container mt-5'><div class='alert alert-danger'>❌ DB Connection Failed</div></div>");
    }

    $appointment_id = mysqli_real_escape_string($db, $_POST['appointment_id']);
    $doctor_id      = mysqli_real_escape_string($db, $_POST['doctor_id']);
    $patient_id     = mysqli_real_escape_string($db, $_POST['patient_id']);
    $notes          = mysqli_real_escape_string($db, $_POST['notes']);
    $status         = mysqli_real_escape_string($db, $_POST['status']);
    $created_at     = date('Y-m-d H:i:s');

    $query = "INSERT INTO prescriptions (appointment_id, doctor_id, patient_id, notes, status, created_at)
              VALUES ('$appointment_id', '$doctor_id', '$patient_id', '$notes', '$status', '$created_at')";

    if (mysqli_query($db, $query)) {
        $prescriptionMsg = "<div class='alert alert-success alert-dismissible fade show fw-bold text-center shadow-sm' role='alert'>
                                ✅ Prescription successfully saved for <strong>Appointment ID: $appointment_id</strong>.
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
    } else {
        $prescriptionMsg = "<div class='alert alert-danger text-center fw-bold'>❌ Failed to save prescription. " . mysqli_error($db) . "</div>";
    }
    mysqli_close($db);
}
?>

<!-- Stylish Prescription Form -->
<div class="container py-5" style="max-width: 700px; margin-top: 80px;">
    <!-- Display cinematic message -->
    <?php if (!empty($prescriptionMsg)) echo $prescriptionMsg; ?>

    <div class="text-center mb-4">
        <h2 class="display-6 fw-bold text-primary wow fadeInDown">📝 Create Patient Prescription</h2>
        <p class="text-muted lead">Empowering recovery, one prescription at a time. Please fill out the form carefully. 🩺</p>
    </div>

    <div class="card shadow border-0 rounded-4 wow fadeInUp" data-wow-delay="0.2s">
        <div class="card-header bg-gradient-primary text-white text-center rounded-top-4" style="background: linear-gradient(45deg, #007bff, #00bcd4);">
            <h4 class="mb-0 fw-bold">💊 Add New Prescription</h4>
        </div>
        <div class="card-body px-4 py-4">
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Appointment ID</label>
                    <input type="number" name="appointment_id" class="form-control rounded-pill px-4 py-2 shadow-sm" required placeholder="Enter appointment ID">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Doctor ID</label>
                    <input type="number" name="doctor_id" class="form-control rounded-pill px-4 py-2 shadow-sm" required placeholder="Enter doctor ID">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Patient ID</label>
                    <input type="number" name="patient_id" class="form-control rounded-pill px-4 py-2 shadow-sm" required placeholder="Enter patient ID">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Prescription Notes</label>
                    <textarea name="notes" class="form-control rounded-3 shadow-sm px-3 py-2" rows="4" placeholder="e.g., Take Amoxicillin 500mg twice daily after meals." required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Status</label>
                    <select name="status" class="form-select rounded-pill px-4 py-2 shadow-sm" required>
                        <option value="">-- Select Status --</option>
                        <option value="active">Active</option>
                        <option value="expired">Expired</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success rounded-pill px-5 py-2 fw-bold shadow-sm">
                        💾 Save Prescription
                    </button>
                    <a href="doctor_prescriptions.php" class="btn btn-outline-secondary rounded-pill px-4 py-2 ms-3">
                        ↩️ Back to Prescription Page
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("doctorFooter.php"); ?>
