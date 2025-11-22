<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Kolkata');

$db = mysqli_connect("localhost", "root", "", "meditronix_new");

include("adminHeader.php");
?>

<style>
    .user-view-container {
        margin-top: 100px;
        padding: 30px;
    }

    .section-title {
        font-weight: 700;
        font-size: 2.5rem;
        color: #0d6efd;
        padding: 10px 30px;
        border-radius: 12px;
        display: inline-block;
        box-shadow: 0 0 15px rgba(13, 110, 253, 0.2);
        background: #fff;
    }

    .lead {
        font-size: 1.2rem;
        color: #555;
    }

    .card-attractive {
        border-radius: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        padding: 40px;
        background-color: #f9f9f9;
        border: 2px solid #e2e2e2;
    }

    .card-attractive h4 {
        font-weight: 600;
        color:rgb(83, 152, 255);
    }

    .table-attractive {
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
    }

    .table-attractive th {
        background-color:rgb(245, 251, 157);
        color: black;
        font-weight: 600;
        padding: 12px;
        text-align: center;
    }

    .table-attractive td {
        padding: 12px;
        vertical-align: middle;
    }

    .table-attractive tr:hover {
        background-color: #f1f1f1;
    }

    .btn-back {
        padding: 10px 30px;
        font-size: 1rem;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
</style>


<div class="container user-view-container">
    <div class="text-center wow fadeInUp mb-4" data-wow-delay="0.1s">
        <h1 class="section-title">
            👤 User Information Panel
        </h1>
        <p class="lead mt-3">
            This panel displays <strong>verified user details</strong> directly from the system records.
        </p>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-lg-8 col-md-10 wow fadeInUp" data-wow-delay="0.5s">
            <div class="card card-attractive">
                <div class="mb-4 text-center">
                    <h4>📄 Complete User Record</h4>
                </div>

                <?php
                if (isset($_GET['id'])) {
                    $userId = intval($_GET['id']);
                    $result = mysqli_query($db, "SELECT * FROM users WHERE id=$userId");

                    if ($result && mysqli_num_rows($result) > 0) {
                        $user = mysqli_fetch_assoc($result);

                        echo "<div class='table-responsive'>";
                        echo "<table class='table table-bordered table-hover table-attractive'>";
                        echo "<tbody>";
                        echo "<tr><th>User ID</th><td>" . htmlspecialchars($user['id']) . "</td></tr>";
                        echo "<tr><th>Name</th><td>" . htmlspecialchars($user['name']) . "</td></tr>";
                        echo "<tr><th>Email</th><td>" . htmlspecialchars($user['email']) . "</td></tr>";
                        echo "<tr><th>Password (Encrypted)</th><td>" . htmlspecialchars($user['password']) . "</td></tr>";
                        echo "<tr><th>Contact</th><td>" . htmlspecialchars($user['contact']) . "</td></tr>";
                        echo "<tr><th>Address</th><td>" . htmlspecialchars($user['address']) . "</td></tr>";
                        echo "<tr><th>Role</th><td>" . ucfirst(htmlspecialchars($user['role'])) . "</td></tr>";
                        echo "<tr><th>Status</th><td>" . ucfirst(htmlspecialchars($user['status'])) . "</td></tr>";
                        echo "<tr><th>Created At</th><td>" . htmlspecialchars($user['create_at']) . "</td></tr>";
                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>";
                    } else {
                        echo "<div class='alert alert-warning text-center'>⚠️ User not found or removed.</div>";
                    }
                } else {
                    echo "<div class='alert alert-warning text-center'>⚠️ Invalid Request: No User ID Provided.</div>";
                }
                ?>

                <div class="text-center mt-4">
                    <a href='user_action_handler.php' class='btn btn-secondary btn-back'>🔙 Back to User Directory</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("adminFooter.php"); ?>
