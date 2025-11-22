<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("patientHeader.php");

$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("Connection Failed: " . mysqli_connect_error());
}

$service_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = mysqli_query($db, "SELECT * FROM services WHERE id = $service_id");
$service = mysqli_fetch_assoc($query);

if (!$service) {
    echo "<div class='container my-5'><div class='alert alert-danger'>❌ Service not found.</div></div>";
    include("patientFooter.php");
    exit;
}

// Book if URL has ?book=1
if (isset($_GET['book']) && $_GET['book'] == 1) {
    $insert = mysqli_query($db, "INSERT INTO bookings (service_id, service_name, description, fee) 
        VALUES ('{$service['id']}', '{$service['name']}', '{$service['description']}', '{$service['fee']}')");
    $isBooked = $insert && mysqli_affected_rows($db) > 0;
} else {
    $isBooked = false;
}
?>

<link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">

<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #ffffff);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .profile-container {
        max-width: 750px;
        margin: 120px auto 80px auto;
        padding: 45px;
        border-radius: 25px;
        background: #ffffff;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        text-align: center;
        transition: 0.4s ease;
    }

    .profile-container:hover {
        box-shadow: 0 10px 40px rgba(13, 202, 240, 0.2);
        transform: translateY(-3px);
    }

    .profile-container h1 {
        font-family: 'algerian';
        font-size: 3rem;
        color:rgb(9, 17, 19);
        margin-bottom: 10px;
    }

    .profile-container h5 {
        color: #777;
        margin-bottom: 30px;
    }

    .desc {
        background-color: #f1faff;
        border: 2px dashed #0dcaf0;
        padding: 25px;
        border-radius: 10px;
        font-size: 1.2rem;
        font-style: italic;
        text-align: left;
        margin-bottom: 30px;
    }

    .profile-details {
        list-style: none;
        padding: 0;
        font-size: 1.1rem;
        text-align: left;
        margin-top: 10px;
    }

    .profile-details li {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
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
        box-shadow: 0 0 12px rgba(13, 202, 240, 0.4);
        color: white;
    }

    .book-msg {
        background-color: #d1e7dd;
        border: 2px solid #0f5132;
        padding: 20px;
        border-radius: 10px;
        margin-top: 20px;
        color: #0f5132;
        font-size: 1.2rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .book-msg h4 {
        font-family: 'times new roman', bold;
        color: #198754;
        font-size: 2rem;
        margin-bottom: 10px;
    }
</style>

<div class="profile-container">
    <h1><?= htmlspecialchars($service['name']) ?></h1>
    <h5>Detailed Healthcare Service Information</h5>

    <div class="desc">
        <?= nl2br(htmlspecialchars($service['description'])) ?>
    </div>

    <ul class="profile-details">
        <li><strong>Service ID:</strong> <?= $service['id'] ?></li>
        <li><strong>Fee:</strong> ₹<?= number_format($service['fee'], 2) ?></li>
        <li><strong>Status:</strong> <?= ucfirst($service['status']) ?></li>
        <li><strong>Created At:</strong> <?= $service['created_at'] ?? "N/A" ?></li>
    </ul>

    <?php if ($isBooked) : ?>
        <div class="book-msg">
            <h4>🎉 Thank You for Your Trust!</h4>
            <p>Your service has been successfully booked on <strong><?= date('d/m/Y h:i A') ?></strong>.</p>
            <p>We appreciate your choice. Our healthcare team is here to serve you.</p>
        </div>
    <?php endif; ?>

    <a href="patient_service.php" class="btn-back">⬅️ Back to Services Directory</a>
</div>

<?php include("patientFooter.php"); ?>
