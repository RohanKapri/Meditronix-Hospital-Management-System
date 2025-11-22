<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("doctorHeader.php");

$db = mysqli_connect("localhost", "root", "", "meditronix_new");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = "";
$appointment = null;

if ($db && $id > 0) {
    // Update status
    $updateQuery = "UPDATE `appointments:` SET status = 'Scheduled' WHERE id = $id";
    if (mysqli_query($db, $updateQuery)) {
        $message = "✅ Appointment Approved & Marked as Scheduled Successfully.";

        // Fetch updated data
        $selectQuery = "SELECT * FROM `appointments:` WHERE id = $id";
        $result = mysqli_query($db, $selectQuery);
        if ($result && mysqli_num_rows($result) > 0) {
            $appointment = mysqli_fetch_assoc($result);
        }
    } else {
        $message = "❌ Unable to approve appointment. Please try again later.";
    }
} else {
    $message = "❌ Invalid Appointment ID or Database Issue.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment Successfully Approved</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e9f0f7, #ffffff);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .page-heading {
            text-align: center;
            font-size: 42px;
            font-weight: 800;
            color: #0d6efd;
            margin-top: 150px;
            margin-bottom: 50px;
            text-shadow: 2px 3px 8px rgba(0,0,0,0.1);
        }

        .confirmation-container {
            max-width: 900px;
            padding: 90px;
            margin: 0 auto 100px auto;
            border-radius: 40px;
            background: linear-gradient(160deg, #ffffff, #f2f6fa);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: 0.4s ease;
        }

        .confirmation-container h2 {
            color: #198754;
            font-weight: 900;
            margin-bottom: 30px;
            font-size: 36px;
        }

        .confirmation-container p {
            font-size: 22px;
            color: #333;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .appointment-details {
            text-align: left;
            margin: 0 auto;
            max-width: 700px;
            font-size: 18px;
            color: #333;
            padding: 30px;
            border-radius: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .appointment-details h4 {
            color: #0d6efd;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .appointment-details p {
            margin: 10px 0;
        }

        .btn-back {
            padding: 15px 50px;
            font-weight: 700;
            background-color: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 50px;
            transition: 0.3s;
            font-size: 20px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            margin-top: 40px;
        }

        .btn-back:hover {
            background-color: #0b5ed7;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<h1 class="page-heading">🎉 Appointment Scheduling Confirmation</h1>

<div class="confirmation-container">
    <h2><?php echo htmlspecialchars($message); ?></h2>
    <p>Your approval has been successfully recorded.<br>Thank you for maintaining professional healthcare operations.</p>

    <?php if ($appointment) : ?>
        <div class="appointment-details">
            <h4>📄 Appointment Details</h4>
            <p><strong>Appointment ID:</strong> <?= htmlspecialchars($appointment['id']) ?></p>
            <p><strong>Patient ID:</strong> <?= htmlspecialchars($appointment['patient_id']) ?></p>
            <p><strong>Doctor ID:</strong> <?= htmlspecialchars($appointment['doctor_id']) ?></p>
            <p><strong>Service ID:</strong> <?= htmlspecialchars($appointment['service_id']) ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($appointment['appointment_date']) ?></p>
            <p><strong>Time:</strong> <?= htmlspecialchars($appointment['appointment_time']) ?></p>
            <p><strong>Status:</strong> <span style="color: #198754; font-weight: 600;"><?= htmlspecialchars($appointment['status']) ?></span></p>
            <p><strong>Created At:</strong> <?= htmlspecialchars($appointment['created_at']) ?></p>
        </div>
    <?php endif; ?>

  <div class="text-center mt-5">
    <a href="schedule_appointemnet.php" class="btn btn-outline-primary px-4 py-2 rounded-pill mt-2">
        🔙 Return to Appointments Dashboard
    </a>
</div>

</div>

<?php include("doctorFooter.php"); ?>
</body>
</html>

