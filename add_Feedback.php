<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("patientHeader.php");

$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("<div class='container mt-5'><div class='alert alert-danger'>❌ Database connection failed.</div></div>");
}

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = intval($_POST['patient_id']);
    $message = mysqli_real_escape_string($db, $_POST['message']);
    $rating = intval($_POST['rating']);
    $status = mysqli_real_escape_string($db, $_POST['status']);
    $created_at = date('Y-m-d H:i:s');

    $insert = mysqli_query($db, "INSERT INTO feedback (patient_id, message, rating, status, created_at) VALUES ('$patient_id', '$message', '$rating', '$status', '$created_at')");
    if ($insert) {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Feedback - Meditronix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #ffffff);
            font-family: 'Segoe UI', sans-serif;
        }

        .form-container {
            max-width: 700px;
            margin: 70px auto 60px auto; /* Keep container below fixed header */
            background: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #0d6efd;
        }

        .form-title {
            font-size: 28px;
            font-weight: 800;
            color: #0d6efd;
            text-align: center;
            margin-bottom: 25px;
        }

        .btn-submit {
            background-color: #198754;
            color: white;
            padding: 10px 25px;
            font-weight: 600;
            border-radius: 50px;
            border: none;
            transition: 0.3s ease-in-out;
        }

        .btn-submit:hover {
            background-color: #146c43;
            transform: scale(1.02);
            box-shadow: 0 0 10px rgba(25, 135, 84, 0.3);
        }

        .btn-back {
            margin-top: 20px;
            display: inline-block;
            background-color: #0d6efd;
            color: white;
            padding: 10px 25px;
            font-weight: 500;
            border-radius: 50px;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .btn-back:hover {
            background-color: #0b5ed7;
        }

        .success-box {
            background-color: #d1e7dd;
            border: 1px solid #0f5132;
            padding: 15px;
            border-radius: 10px;
            color: #0f5132;
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <div class="form-title">📝 Submit Your Feedback</div>

        <?php if ($success): ?>
            <div class="success-box">
                ✅ Your feedback has been successfully submitted!
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="patient_id" class="form-label fw-semibold">Patient ID</label>
                <input type="number" class="form-control" id="patient_id" name="patient_id" required>
            </div>

            <div class="mb-3">
                <label for="message" class="form-label fw-semibold">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Write your feedback here..."></textarea>
            </div>

            <div class="mb-3">
                <label for="rating" class="form-label fw-semibold">Rating (1–5)</label>
                <select class="form-select" id="rating" name="rating" required>
                    <option value="">Select rating</option>
                    <option value="5">★★★★★</option>
                    <option value="4">★★★★☆</option>
                    <option value="3">★★★☆☆</option>
                    <option value="2">★★☆☆☆</option>
                    <option value="1">★☆☆☆☆</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="status" class="form-label fw-semibold">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="">Select status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn-submit">➕ Submit Feedback</button>
            </div>
        </form>

        <div class="text-center">
            <a href="patient_feedback.php" class="btn-back mt-4">⬅️ Back to Feedback Panel</a>
        </div>
    </div>

</body>
</html>

<?php include("patientFooter.php"); ?>
