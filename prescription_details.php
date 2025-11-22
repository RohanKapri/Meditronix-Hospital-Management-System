<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("patientHeader.php");

$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("<div class='container mt-5'><div class='alert alert-danger'>❌ Failed to connect to database.</div></div>");
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = mysqli_query($db, "SELECT * FROM prescriptions WHERE id = $id");
if (!$query || mysqli_num_rows($query) === 0) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>⚠️ No prescription found.</div></div>";
    include("patientFooter.php");
    exit;
}
$data = mysqli_fetch_assoc($query);
?>

<style>
    body {
        background: linear-gradient(to right, #f3f4f6, #ffffff);
        font-family: 'Nunito', sans-serif;
    }

    .container-box {
        max-width: 900px;
        margin: 150px auto 100px auto; /* Increased top margin for better spacing */
        padding: 50px;
        background: #fff;
        border-left: 10px solid #0d6efd;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

.title {
    font-size: 40px;
    font-weight: 800;
    color: #0d6efd;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: center; /* Center horizontally */
    text-align: center; /* Ensures text alignment inside the flex */
}


    .title::before {
        content: "📘";
        margin-right: 10px;
    }

    .meta {
        font-size: 20px;
        color: #6c757d;
        margin-bottom: 30px;
    }

    .notes-box {
        background-color: #f1f9ff;
        border: 2px dashed #0d6efd;
        padding: 25px;
        border-radius: 15px;
        font-size: 20px;
        color: #333;
        font-weight: 600;
        word-spacing: 2px;
        line-height: 1.6;
    }

    .back-btn {
        margin-top: 30px;
    }

    .back-btn a {
        text-decoration: none;
        color: #0d6efd;
        font-weight: bold;
        border: 2px solid #0d6efd;
        border-radius: 30px;
        padding: 10px 25px;
        transition: 0.3s;
        font-size: 18px;
        display: inline-flex;
        align-items: center;
    }

    .back-btn a::before {
        content: "⬅️";
        margin-right: 10px;
    }

    .back-btn a:hover {
        background-color: #0d6efd;
        color: #fff;
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
    }
</style>

<div class="container-box">
    <div class="title">Prescription Notes</div>

    <div class="meta">
        <strong>ID:</strong> <?= $data['id'] ?> 
        <br>
        <strong>Appointment ID:</strong> <?= $data['appointment_id'] ?> 
        <br>
        <strong>Doctor ID:</strong> <?= $data['doctor_id'] ?> 
        <br>
        <strong>Patient ID:</strong> <?= $data['patient_id'] ?> 
        <br>
        <strong>Status:</strong> <?= ucfirst($data['status']) ?> 
        <br>
        <strong>Created:</strong> <?= $data['created_at'] ?>
    </div>

    <div class="notes-box">
        <?= nl2br(htmlspecialchars($data['notes'])) ?>
    </div>

    <div class="back-btn">
        <a href="javascript:window.close();">Back to Prescriptions</a>
    </div>
</div>

<?php include("patientFooter.php"); ?> 
