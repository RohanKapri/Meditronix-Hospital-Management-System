<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Kolkata');

$db = mysqli_connect("localhost", "root", "", "meditronix_new");

include("adminHeader.php");

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    mysqli_query($db, "UPDATE users SET status='blocked' WHERE id=$userId");
    $result = mysqli_query($db, "SELECT * FROM users WHERE id=$userId");
}
?>

<style>
    body {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .user-block-container {
        margin-top: 100px;
        padding: 30px;
    }

    .section-title {
        font-weight: 700;
        font-size: 2.2rem;
        color: #d63031;
        background-color: #fff;
        padding: 12px 30px;
        border-radius: 10px;
        display: inline-block;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .info-message {
        font-size: 20px;
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
        background-color: #ff7043;
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
        background-color: #f4511e;
        transform: translateY(-1px);
    }

    .back-icon {
        margin-right: 5px;
    }
</style>

<div class="container user-block-container">
    <div class="text-center mb-4">
        <h2 class="section-title">
            🚫 Blocked User Details
        </h2>
        <p class="info-message">
            This is a protected record of the blocked user. Review the details carefully before taking any further administrative action.
        </p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="table-responsive">
                <?php
                if (isset($result) && mysqli_num_rows($result) > 0) {
                    $user = mysqli_fetch_assoc($result);

                    echo "<h4 class='text-center text-danger mb-4'>User ID <strong># " . htmlspecialchars($user['id']) . "</strong> is now <span class='text-danger'>BLOCKED</span></h4>";
                    echo "<table class='custom-table'>";
                    echo "<tr><th>User ID</th><td>" . htmlspecialchars($user['id']) . "</td></tr>";
                    echo "<tr><th>Name</th><td>" . htmlspecialchars($user['name']) . "</td></tr>";
                    echo "<tr><th>Email</th><td>" . htmlspecialchars($user['email']) . "</td></tr>";
                    echo "<tr><th>Password (Encrypted)</th><td>" . htmlspecialchars($user['password']) . "</td></tr>";
                    echo "<tr><th>Contact</th><td>" . htmlspecialchars($user['contact']) . "</td></tr>";
                    echo "<tr><th>Address</th><td>" . htmlspecialchars($user['address']) . "</td></tr>";
                    echo "<tr><th>Role</th><td>" . ucfirst(htmlspecialchars($user['role'])) . "</td></tr>";
                    echo "<tr><th>Status</th><td><span style='color: red; font-weight: bold;'>Blocked</span></td></tr>";
                    echo "<tr><th>Created At</th><td>" . htmlspecialchars($user['create_at']) . "</td></tr>";
                    echo "</table>";
                } else {
                    echo "<div class='alert alert-warning text-center'>⚠️ No User Found for Blocking.</div>";
                }
                ?>
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
