<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("doctorHeader.php");
$db = mysqli_connect("localhost", "root", "", "meditronix_new");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($db && $id) {
    $query = "SELECT * FROM `appointments:` WHERE id = $id";
    $result = mysqli_query($db, $query);
    $appointment = mysqli_fetch_assoc($result);

    if ($appointment) {
        mysqli_query($db, "UPDATE `appointments:` SET status = 'Dismissed' WHERE id = $id");
    }
}
?>

<style>
    .decline-box {
        background: linear-gradient(135deg, #fff0f0, #fff);
        padding: 50px;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        margin: 100px auto;
        text-align: center;
        max-width: 700px;
    }

    .decline-box h1 {
        color: #dc3545;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .decline-box .list-group {
        margin: 20px auto;
        text-align: left;
        max-width: 500px;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .decline-box .btn {
        padding: 10px 30px;
        border-radius: 30px;
        font-weight: 600;
    }

    .decline-icon {
        font-size: 60px;
        color: #dc3545;
    }
</style>

<div class="container">
    <div class="decline-box">
        <div class="decline-icon">❌</div>
        <h1>Appointment Declined & Dismissed</h1>
        <?php if (!empty($appointment)): ?>
            <ul class="list-group">
                <li class="list-group-item"><strong>Appointment ID:</strong> <?= htmlspecialchars($appointment['id']) ?></li>
                <li class="list-group-item"><strong>Patient ID:</strong> <?= htmlspecialchars($appointment['patient_id']) ?></li>
                <li class="list-group-item"><strong>Doctor ID:</strong> <?= htmlspecialchars($appointment['doctor_id']) ?></li>
                <li class="list-group-item"><strong>Service ID:</strong> <?= htmlspecialchars($appointment['service_id']) ?></li>
                <li class="list-group-item"><strong>Date:</strong> <?= htmlspecialchars($appointment['appointment_date']) ?></li>
                <li class="list-group-item"><strong>Time:</strong> <?= htmlspecialchars($appointment['appointment_time']) ?></li>
                <li class="list-group-item"><strong>Status:</strong> <span class="text-danger fw-bold">Dismissed</span></li>
                <li class="list-group-item"><strong>Created At:</strong> <?= htmlspecialchars($appointment['created_at']) ?></li>
            </ul>
        <?php else: ?>
            <p class="text-danger">No appointment found with this ID.</p>
        <?php endif; ?>

        <a href="schedule_appointemnet.php" class="btn btn-danger mt-4">🔙 Back to Appointments</a>
    </div>
</div>

<?php include("doctorFooter.php"); ?>
