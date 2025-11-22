<?php include 'patientHeader.php'; ?>

<style>
    .main-heading {
        text-align: center;
        margin-top: 120px;
        margin-bottom: 40px;
        font-size: 50px;
        font-weight: 700;
        color: #0d6efd;
        text-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .confirmation-container {
        background: linear-gradient(135deg, #e0f2f1, #ffffff);
        padding: 60px;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        width: 90%;
        max-width: 1200px;
        margin: 0 auto 100px auto;
        text-align: center;
    }

    .confirmation-container h1 {
        color: #198754;
        font-weight: 700;
        margin-bottom: 25px;
        font-size: 40px;
    }

    .confirmation-container .list-group {
        margin: 20px auto;
        text-align: left;
        max-width: 700px;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
    }

    .confirmation-container .btn {
        padding: 12px 40px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 20px;
    }

    .confirmation-icon {
        font-size: 70px;
        color: #198754;
        margin-bottom: 15px;
    }

    .professional-message {
        margin-top: 20px;
        font-size: 20px;
        color: #555;
        font-weight: 500;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.5;
    }
</style>

<div class="container">
    <h2 class="main-heading">📋 Your Booking Confirmation</h2>

    <div class="confirmation-container">
        <div class="confirmation-icon">✅</div>
        <h1>Your Service Has Been Booked Successfully!</h1>

        <ul class="list-group">
            <li class="list-group-item"><strong>Service ID:</strong> <?= htmlspecialchars($_GET['id'] ?? 'N/A') ?></li>
            <li class="list-group-item"><strong>Service Name:</strong> <?= htmlspecialchars($_GET['name'] ?? 'N/A') ?></li>
            <li class="list-group-item"><strong>Fee:</strong> ₹<?= htmlspecialchars($_GET['fee'] ?? 'N/A') ?></li>
            <li class="list-group-item"><strong>Booking Time:</strong> <?= htmlspecialchars($_GET['time'] ?? 'N/A') ?></li>
        </ul>

        <p class="professional-message">
            Thank you for trusting us with your healthcare needs. Your booking has been confirmed, and our medical team will ensure your visit is handled with care and professionalism.  
            For any inquiries or rescheduling, please visit your patient dashboard or contact our support.
        </p>

        <a href="patient_service.php" class="btn btn-success mt-4">🔙 Back to Services</a>
    </div>
</div>

<?php include 'patientFooter.php'; ?>
