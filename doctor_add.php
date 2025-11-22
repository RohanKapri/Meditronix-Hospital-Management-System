<?php ob_start(); ?>
<?php
include("adminHeader.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$successMessage = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = mysqli_connect("localhost", "root", "", "meditronix_new");

    $user_id = $_POST['user_id'];
    $specialization = $_POST['specialization'];
    $experience = $_POST['experience'];
    $availability = $_POST['availability'];
    $status = $_POST['status'];

    $query = "INSERT INTO doctors (user_id, specialization, experience, availability, status, created_at) 
              VALUES ('$user_id', '$specialization', '$experience', '$availability', '$status', NOW())";
    if (mysqli_query($db, $query)) {
        $successMessage = "Doctor has been successfully added to the system and is now listed in the database.";
    } else {
        echo "<div class='text-danger text-center'>Error: " . mysqli_error($db) . "</div>";
    }
}
?>

<style>
    body {
        background-color: #f5f7fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .add-doctor-container {
        max-width: 800px;
        margin: 130px auto 50px auto;
        padding: 50px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .add-doctor-heading {
        text-align: center;
        font-size: 36px;
        font-weight: 700;
        color: #0d6efd;
        margin-bottom: 40px;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 20px;
        text-decoration: none;
        color: #0d6efd;
        font-weight: 600;
        border: 2px solid #0d6efd;
        border-radius: 30px;
        padding: 8px 25px;
        transition: 0.3s;
    }

    .back-link:hover {
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
</style>

<div class="add-doctor-container">
    <h2 class="add-doctor-heading">👨‍⚕️ Add New Doctor's Professional Profile</h2>

    <div class="text-end">
        <a href="all_category_doctors.php" class="back-link">⬅️ Back to All Doctors</a>
    </div>

    <?php if ($successMessage): ?>
        <div class="alert alert-success text-center fw-semibold">
            ✅ <?php echo htmlspecialchars($successMessage); ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="user_id" class="form-control mb-4" placeholder="User ID" required>
        <input type="text" name="specialization" class="form-control mb-4" placeholder="Specialization" required>
        <input type="number" name="experience" class="form-control mb-4" placeholder="Experience (years)" required>
        <input type="text" name="availability" class="form-control mb-4" placeholder="Availability" required>
        <select name="status" class="form-control mb-4" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
        <div class="text-center">
            <button type="submit" class="btn btn-success">Add Doctor</button>
        </div>
    </form>
</div>

<?php include("adminFooter.php"); ?>
<?php ob_end_flush(); ?>
