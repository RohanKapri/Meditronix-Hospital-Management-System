<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("patientHeader.php");

$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("Connection Failed: " . mysqli_connect_error());
}

$doctor_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = mysqli_query($db, "SELECT * FROM doctors WHERE id = $doctor_id");
$doctor = mysqli_fetch_assoc($query);

if (!$doctor) {
    echo "<div class='container my-5'><div class='alert alert-danger'>❌ Doctor not found.</div></div>";
    include("patientFooter.php");
    exit;
}
?>

<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #ffffff);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .profile-container {
        max-width: 615px;
        margin: 150px auto 80px auto;
        padding: 40px;
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        text-align: center;
        transition: 0.4s ease;
    }

    .profile-container:hover {
        box-shadow: 0 10px 40px rgba(13, 202, 240, 0.2);
        transform: translateY(-2px);
    }

    .profile-img {
        width: 200px;
        height: 130px;
        border-radius: 50%;
        border: 6px solid #0dcaf0;
        object-fit: cover;
        margin-bottom: 20px;
    }

    .profile-container h2 {
        font-size: 2.4rem;
        color: #0dcaf0;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .profile-container h5 {
        font-size: 1.3rem;
        color: #555;
        margin-bottom: 1.5rem;
    }

    .profile-details {
        list-style: none;
        padding: 0;
        font-size: 1.15rem;
        text-align: left;
        margin-top: 20px;
    }

    .profile-details li {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .badge-status {
        font-size: 1.1rem;
        padding: 6px 18px;
        border-radius: 50px;
    }

    .btn-back {
        margin-top: 35px;
        font-size: 1rem;
        padding: 10px 25px;
        border-radius: 50px;
        background-color: #0dcaf0;
        color: white;
        border: none;
        transition: 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-back:hover {
        background-color: #0bb1d1;
        color: white;
        box-shadow: 0 0 12px rgba(13, 202, 240, 0.4);
    }
</style>

<div class="profile-container">
    <img src="https://cdn-icons-png.flaticon.com/512/387/387561.png" alt="Doctor Avatar" class="profile-img">
    <h2>Dr. <?= htmlspecialchars($doctor['specialization']) ?></h2>
    <h5><?= ucfirst($doctor['status']) ?> Doctor</h5>
    <span class="badge bg-<?= $doctor['status'] === 'active' ? 'success' : 'secondary' ?> badge-status"><?= ucfirst($doctor['status']) ?></span>

    <ul class="profile-details mt-4">
        <li><strong>👤 Doctor ID:</strong> <?= $doctor['id'] ?></li>
        <li><strong>🆔 User ID:</strong> <?= $doctor['user_id'] ?></li>
        <li><strong>💼 Specialization:</strong> <?= htmlspecialchars($doctor['specialization']) ?></li>
        <li><strong>🎓 Experience:</strong> <?= htmlspecialchars($doctor['experience']) ?> Years</li>
        <li><strong>🕒 Availability:</strong> <?= htmlspecialchars($doctor['availability']) ?></li>
        <li><strong>🗓️ Created At:</strong> <?= $doctor['created_at'] ?? "N/A" ?></li>
    </ul>

    <a href="patient_view.php" class="btn-back">⬅️ Back to Doctors Directory</a>
</div>

<?php include("patientFooter.php"); ?>
