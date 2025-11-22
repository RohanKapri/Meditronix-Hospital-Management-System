<?php ob_start(); ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("adminHeader.php");

$db = mysqli_connect("localhost", "root", "", "meditronix_new");
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($db, $_POST["name"]);
    $description = mysqli_real_escape_string($db, $_POST["description"]);
    $fee = floatval($_POST["fee"]);
    $status = mysqli_real_escape_string($db, $_POST["status"]);

    $query = "INSERT INTO services (name, description, fee, status, created_at) 
              VALUES ('$name', '$description', $fee, '$status', NOW())";

    if (mysqli_query($db, $query)) {
        $success = "✅ Service added successfully!";
    } else {
        $error = "❌ Failed to add service. Please try again.";
    }
}
?>

<style>
    body {
        background-color: #f5f7fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .service-container {
        max-width: 1000px;
        margin: 120px auto;
        padding: 50px 60px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .section-title {
        font-size: 32px;
        font-weight: 700;
        color: #0d6efd;
        margin-bottom: 20px;
    }

    .back-btn {
        display: inline-block;
        text-decoration: none;
        color: #0d6efd;
        font-weight: 600;
        border: 2px solid #0d6efd;
        border-radius: 30px;
        padding: 8px 25px;
        transition: 0.3s;
    }

    .back-btn:hover {
        background-color: #0d6efd;
        color: #fff;
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }

    .form-control {
        height: 50px;
        padding: 10px 20px;
        font-size: 16px;
        border: 1px solid #ced4da;
        border-radius: 12px;
        box-shadow: none;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.2);
    }

    textarea.form-control {
        height: 200px !important;
        padding: 20px;
        resize: vertical;
        font-size: 16px;
    }

    .btn-success {
        background-color: #198754;
        border: none;
        padding: 12px 40px;
        font-size: 18px;
        border-radius: 30px;
        transition: 0.3s;
        font-weight: 600;
    }

    .btn-success:hover {
        background-color: #157347;
        box-shadow: 0 5px 15px rgba(25, 135, 84, 0.4);
    }

    .alert {
        border-radius: 12px;
        font-size: 16px;
    }

    .button-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
    }
</style>

<div class="service-container">
    <div class="text-center">
        <h2 class="section-title">➕ Add New Service</h2>
        <p class="text-muted">Fill out the form below to register a new service.</p>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success text-center mt-3"><?= $success ?></div>
        <div class="button-row">
            <a href="all_category_service.php" class="back-btn">⬅️ Back to All Services</a>
            <div></div>
        </div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger text-center mt-3"><?= $error ?></div>
    <?php endif; ?>

    <?php if (!$success): ?>
    <form method="POST" class="mt-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Service Name</label>
                <input type="text" name="name" class="form-control" required placeholder="Enter service name">
            </div>

            <div class="col-md-6">
                <label for="fee" class="form-label">Fee (INR)</label>
                <input type="number" name="fee" step="0.01" class="form-control" required placeholder="e.g., 500">
            </div>

            <div class="col-12">
                <label for="description" class="form-label">Service Description</label>
                <textarea name="description" class="form-control" required placeholder="Describe the service in detail"></textarea>
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div class="button-row">
            <a href="all_category_services.php" class="back-btn">⬅️ Back to All Services</a>
            <button type="submit" class="btn btn-success fw-bold">💾 Save Service</button>
        </div>
    </form>
    <?php endif; ?>
</div>

<?php include("adminFooter.php"); ?>
<?php ob_end_flush(); ?>
