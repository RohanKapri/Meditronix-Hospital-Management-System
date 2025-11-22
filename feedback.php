<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$db = mysqli_connect("localhost", "root", "", "meditronix_new");

if (!$db) {
    die("<div class='container mt-5'><div class='alert alert-danger'>❌ Database Connection Failed</div></div>");
}

$fid = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query = mysqli_query($db, "SELECT * FROM feedback WHERE id = $fid");

if (!$query || mysqli_num_rows($query) == 0) {
    die("<div class='container mt-5'><div class='alert alert-warning'>⚠️ Feedback not found.</div></div>");
}

$feedback = mysqli_fetch_assoc($query);
mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #dfe9f3, #ffffff);
            font-family: 'Poppins', sans-serif;
            padding: 40px 0;
        }

        .feedback-card {
            background-color: #ffffff;
            border-left: 10px solid #007bff;
            border-radius: 18px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
            padding: 50px;
            max-width: 1000px;
            margin: auto;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .feedback-title {
            font-family: 'Algerian', cursive;
            font-size: 40px;
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 20px;
        }

        .feedback-meta {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .feedback-meta strong {
            color: #000;
        }

        .feedback-message {
            font-size: 20px;
            line-height: 1.8;
            color: #333;
            border-left: 5px solid #0d6efd;
            padding-left: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .back-btn {
            margin-top: 40px;
        }

        .btn-outline-primary {
            font-size: 18px;
            padding: 10px 25px;
            border-radius: 30px;
            transition: 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: #0d6efd;
            color: #fff;
        }

        @media (max-width: 768px) {
            .feedback-card {
                padding: 30px;
            }
            .feedback-title {
                font-size: 32px;
            }
            .feedback-message {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

<div class="feedback-card">
    <div class="feedback-title">📝 Feedback Description</div>
    <div class="feedback-meta">
        <strong>🆔 ID:</strong> <?= $feedback['id'] ?><br>
        <strong>🧑‍🤝‍🧑 Patient:</strong> <?= $feedback['patient_id'] ?><br>
        <strong>⭐ Rating:</strong> <?= $feedback['rating'] ?> ★<br>
        <strong>📌 Status:</strong> <?= ucfirst($feedback['status']) ?><br>
        <strong>🗓️ Date:</strong> <?= $feedback['created_at'] ?><br>
    </div>

    <div class="feedback-message">
        <?= nl2br(htmlspecialchars($feedback['message'])) ?>
    </div>

    <div class="text-center back-btn">
        <a href="javascript:window.close()" class="btn btn-outline-primary">🔙 Close Window</a>
    </div>
</div>

</body>
</html>
