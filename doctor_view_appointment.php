<?php ob_start(); ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("doctorHeader.php");
$db = mysqli_connect("localhost", "root", "", "meditronix_new");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$appointment = null;

if ($db && $id > 0) {
    $query = "SELECT * FROM `appointments:` WHERE id = $id";
    $result = mysqli_query($db, $query);
    $appointment = mysqli_fetch_assoc($result);
}
mysqli_close($db);
?>

<style>
    .main-heading {
        text-align: center;
        margin-top: 120px;
        margin-bottom: 20px;
        font-size: 36px;
        font-weight: 900;
        color: #0d6efd;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
    }

    .confirmation-msg {
        text-align: center;
        font-size: 20px;
        color: #333;
        margin-bottom: 40px;
        font-weight: 500;
    }

    .view-container {
        background: linear-gradient(135deg, #f0f9ff, #ffffff);
        width: 90%;
        max-width: 950px;
        margin: 0 auto 100px auto;
        padding: 50px;
        border-radius: 25px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .view-container h3 {
        text-align: center;
        color: #0d6efd;
        margin-bottom: 30px;
        font-weight: 800;
        font-size: 28px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .view-list {
        list-style: none;
        padding: 0;
        max-width: 650px;
        margin: 0 auto;
    }

    .view-list li {
        padding: 14px 0;
        border-bottom: 1px solid #ddd;
        font-size: 18px;
        font-weight: 500;
        display: flex;
        justify-content: space-between;
    }

    .view-list li strong {
        color: #0d6efd;
        width: 50%;
    }

    .back-btn {
        display: block;
        width: fit-content;
        margin: 40px auto 0 auto;
        padding: 12px 35px;
        font-weight: 600;
        border: 2px solid #0d6efd;
        border-radius: 30px;
        color: #0d6efd;
        text-decoration: none;
        transition: 0.3s;
    }

    .back-btn:hover {
        background-color: #0d6efd;
        color: #fff;
        text-decoration: none;
    }
</style>

<div class="container">
    <h2 class="main-heading">📖 Appointment Description</h2>
    <p class="confirmation-msg">Below are the full details of your selected appointment. Kindly review carefully.</p>

    <div class="view-container">
        <h3>📋 Appointment Summary</h3>
        <?php if ($appointment) : ?>
            <ul class="view-list">
                <li><strong>Appointment ID:</strong> <span><?= htmlspecialchars($appointment['id']) ?></span></li>
                <li><strong>Patient ID:</strong> <span><?= htmlspecialchars($appointment['patient_id']) ?></span></li>
                <li><strong>Doctor ID:</strong> <span><?= htmlspecialchars($appointment['doctor_id']) ?></span></li>
                <li><strong>Service ID:</strong> <span><?= htmlspecialchars($appointment['service_id']) ?></span></li>
                <li><strong>Appointment Date:</strong> <span><?= htmlspecialchars($appointment['appointment_date']) ?></span></li>
                <li><strong>Appointment Time:</strong> <span><?= htmlspecialchars($appointment['appointment_time']) ?></span></li>
                <li><strong>Status:</strong> <span><?= htmlspecialchars($appointment['status']) ?></span></li>
                <li><strong>Created At:</strong> <span><?= htmlspecialchars($appointment['created_at']) ?></span></li>
            </ul>
        <?php else : ?>
            <p class="text-center text-muted">No appointment details found for this ID.</p>
        <?php endif; ?>

        <a href="doctor_appointement.php" class="back-btn">🔙 Back to Appointments</a>
    </div>
</div>

<?php include("doctorFooter.php"); ?>
<?php ob_end_flush(); ?>
