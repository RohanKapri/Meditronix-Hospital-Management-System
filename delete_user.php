<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Kolkata');

$db = mysqli_connect("localhost", "root", "", "meditronix_new");

include("adminHeader.php");

$userDeleted = false;
$userInfo = null;

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);

    $fetch = mysqli_query($db, "SELECT * FROM users WHERE id=$userId");
    if ($fetch && mysqli_num_rows($fetch) > 0) {
        $userInfo = mysqli_fetch_assoc($fetch);

        mysqli_query($db, "DELETE FROM users WHERE id=$userId");
        $userDeleted = true;
    }
}
?>

<style>
    body {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .user-delete-container {
        margin-top: 100px;
        padding: 30px;
    }

    .section-title {
        font-weight: 700;
        font-size: 2.3rem;
        color: #c0392b;
        background-color: #fff;
        padding: 12px 30px;
        border-radius: 10px;
        display: inline-block;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .info-message {
        font-size: 1rem;
        color: #555;
        margin-bottom: 20px;
        background-color: #ffffffa8;
        padding: 10px 20px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .custom-table th {
        background-color: #fff59d;
        text-align: left;
        padding: 12px 20px;
        width: 220px;
        font-weight: 600;
        color: #333;
        border-bottom: 1px solid #e0e0e0;
        border-right: 1px solid #e0e0e0;
    }

    .custom-table td {
        padding: 12px 20px;
        background-color: #fff;
        color: #333;
        border-bottom: 1px solid #e0e0e0;
    }

    .custom-table tr:hover td {
        background-color: #f9f9f9;
    }

    .btn-back {
        margin-top: 25px;
        padding: 12px 30px;
        background-color: #e74c3c;
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-back:hover {
        background-color: #c0392b;
        transform: translateY(-1px);
    }

    .back-icon {
        margin-right: 5px;
    }
</style>

<div class="container user-delete-container">
    <div class="text-center mb-4">
        <h2 class="section-title">
            🗑️ Deleted User Details
        </h2>
        <p class="info-message">
            Below is the final snapshot of the user's record at the time of deletion. This action is irreversible.
        </p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="table-responsive">
                <?php if ($userDeleted && $userInfo) : ?>
                    <h4 class="text-center text-danger mb-4">
                        User ID <strong># <?= htmlspecialchars($userInfo['id']) ?></strong> has been <span class="text-danger">DELETED</span> successfully.
                    </h4>
                    <table class="custom-table">
                        <tr><th>User ID</th><td><?= htmlspecialchars($userInfo['id']) ?></td></tr>
                        <tr><th>Name</th><td><?= htmlspecialchars($userInfo['name']) ?></td></tr>
                        <tr><th>Email</th><td><?= htmlspecialchars($userInfo['email']) ?></td></tr>
                        <tr><th>Password (Encrypted)</th><td><?= htmlspecialchars($userInfo['password']) ?></td></tr>
                        <tr><th>Contact</th><td><?= htmlspecialchars($userInfo['contact']) ?></td></tr>
                        <tr><th>Address</th><td><?= htmlspecialchars($userInfo['address']) ?></td></tr>
                        <tr><th>Role</th><td><?= ucfirst(htmlspecialchars($userInfo['role'])) ?></td></tr>
                        <tr><th>Status (At Deletion)</th><td><?= ucfirst(htmlspecialchars($userInfo['status'])) ?></td></tr>
                        <tr><th>Created At</th><td><?= htmlspecialchars($userInfo['create_at']) ?></td></tr>
                    </table>
                <?php else : ?>
                    <div class="alert alert-warning text-center">⚠️ No user found or already deleted.</div>
                <?php endif; ?>
            </div>

            <div class="text-center">
                <a href='user_action_handler.php' class='btn-back'>
                    <span class="back-icon">🔙</span> Back to User Directory
                </a>
            </div>
        </div>
    </div>
</div>

<?php include("adminFooter.php"); ?>
