<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("doctorHeader.php");

$db = mysqli_connect("localhost", "root", "", "meditronix_new");
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$feedback = null;

if ($db && $id > 0) {
    $result = mysqli_query($db, "SELECT * FROM feedback WHERE id = $id");
    $feedback = mysqli_fetch_assoc($result);
}
?>

<style>
    .feedback-container {
        max-width: 950px;
        margin: 120px auto;
        padding: 50px;
        background: linear-gradient(135deg, #ffffff, #f1f3f5);
        border-radius: 20px;
        box-shadow: 0 10px 50px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .feedback-title {
        font-size: 36px;
        font-weight: 800;
        color: #0d6efd;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        margin-bottom: 20px;
        border-bottom: 3px solid #0d6efd;
        display: inline-block;
        padding-bottom: 6px;
        position: relative;
        z-index: 1;
    }

    .feedback-meta {
        font-size: 20px;
        color: #6c757d;
        margin-top: 5px;
        margin-bottom: 30px;
        position: relative;
        z-index: 1;
    }

    .feedback-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #212529;
        background: #f8f9fa;
        padding: 30px;
        border-left: 6px solid #0d6efd;
        border-radius: 15px;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
        position: relative;
        z-index: 1;
        white-space: pre-wrap;
    }

    .btn-back {
        margin-top: 50px;
        padding: 12px 35px;
        background-color: #0d6efd;
        color: #fff;
        font-size: 16px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        position: relative;
        z-index: 1;
    }

    .btn-back:hover {
        background-color: #0b5ed7;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        transform: translateY(-2px);
    }
</style>

<div class="feedback-container">
    <?php if ($feedback): ?>
     <div class="text-center my-4">
    <h1 class="feedback-title">🗨️ Feedback Details</h1>
    <p class="feedback-subtitle">Your feedback helps us improve patient care and service quality.</p>
</div>
<p class="feedback-meta">
    🆔 Feedback ID: <?= htmlspecialchars($feedback['id']) ?> &nbsp; &nbsp;
    <br>
    👤 Patient ID: <?= htmlspecialchars($feedback['patient_id']) ?> &nbsp; &nbsp;
    <br>
    ⭐ Rating: <?= htmlspecialchars($feedback['rating']) ?> ★ &nbsp; &nbsp;
    <br>
    📌 Status: <?= ucfirst(htmlspecialchars($feedback['status'])) ?> &nbsp; &nbsp;
    <br>
    📅 <?= htmlspecialchars($feedback['created_at']) ?>
</p>
<div class="feedback-content">
    <?= nl2br(htmlspecialchars($feedback['message'])) ?>
</div>
<a href="view_feedback.php" class="btn-back">🔙 Back to Feedback Dashboard</a>
<?php else: ?>
    <h2 class="text-danger">No Feedback Found</h2>
<?php endif; ?>
</div>


<?php include("doctorFooter.php"); ?>
