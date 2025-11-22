<?php ob_start(); ?>
<?php
include("adminHeader.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
$db = mysqli_connect("localhost", "root", "", "meditronix_new");
$id = $_GET['id'];

$successMessage = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $specialization = $_POST['specialization'];
    $experience = $_POST['experience'];
    $availability = $_POST['availability'];
    $status = $_POST['status'];

    $update = "UPDATE doctors SET user_id='$user_id', specialization='$specialization', experience='$experience', 
                availability='$availability', status='$status' WHERE id=$id";
    if (mysqli_query($db, $update)) {
        $successMessage = "Doctor details have been successfully updated.";
    } else {
        echo "<div class='text-danger text-center'>Update failed: " . mysqli_error($db) . "</div>";
    }
}

$result = mysqli_query($db, "SELECT * FROM doctors WHERE id=$id LIMIT 1");
$row = mysqli_fetch_assoc($result);
?>

<style>
    body {
        background-color: #f5f7fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .edit-doctor-container {
        max-width: 800px;
        margin: 130px auto 50px auto;
        padding: 50px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .edit-doctor-heading {
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

    .btn-primary {
        background-color: #0d6efd;
        border: none;
        padding: 12px 40px;
        font-size: 18px;
        border-radius: 30px;
        transition: 0.3s;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
    }

    .alert {
        border-radius: 12px;
        font-size: 16px;
    }
</style>

<div class="edit-doctor-container">
    <h2 class="edit-doctor-heading">👨‍⚕️ Update Doctor's Professional Profile</h2>

    <div class="text-end">
        <a href="all_category_doctors.php" class="back-link">⬅️ Back to All Doctors</a>
    </div>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-info text-center fw-semibold">
            ✏️ <?php echo htmlspecialchars($successMessage); ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="user_id" class="form-control mb-4" value="<?php echo $row['user_id']; ?>" required placeholder="User ID">
        <input type="text" name="specialization" class="form-control mb-4" value="<?php echo $row['specialization']; ?>" required placeholder="Specialization">
        <input type="number" name="experience" class="form-control mb-4" value="<?php echo $row['experience']; ?>" required placeholder="Experience (Years)">
        <input type="text" name="availability" class="form-control mb-4" value="<?php echo $row['availability']; ?>" required placeholder="Availability">
        <select name="status" class="form-control mb-4" required>
            <option value="active" <?php if ($row['status'] == 'active') echo 'selected'; ?>>Active</option>
            <option value="inactive" <?php if ($row['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
        </select>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Update Doctor</button>
        </div>
    </form>
</div>

<?php include("adminFooter.php"); ?>
<?php ob_end_flush(); ?>
