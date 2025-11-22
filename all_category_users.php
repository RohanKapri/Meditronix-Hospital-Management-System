<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("adminHeader.php"); // Admin Header
?>

<!-- All Users Section Start -->
<div class="container-xxl py-5" style="margin-top: 70px;">
    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
        <h2 class="section-title bg-white text-center text-primary px-5">All Registered Users</h2>
    </div>

    <!-- Table Section -->
    <div class="row g-4 justify-content-center mt-4">
        <div class="col-lg-11 col-md-12 wow fadeInUp" data-wow-delay="0.5s">
            <h5 class="text-center mb-4">Complete User Directory & Access Records</h5>
            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $db = mysqli_connect("localhost", "root", "", "meditronix_new");

                    if (!$db) {
                        echo "<tr><td colspan='8' class='text-danger text-center py-4'>
                                ⚠️ <strong>Connection Error:</strong> Could not connect to database.
                              </td></tr>";
                    } else {
                        $query = "SELECT * FROM `users`";
                        $result = mysqli_query($db, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $count = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td class='text-center'>" . $count++ . "</td>";
                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                echo "<td class='text-capitalize text-center'>" . htmlspecialchars($row['role']) . "</td>";

                                // ✅ Status - fallback if null or empty
                                $status = isset($row['status']) ? trim($row['status']) : '';
                                echo "<td class='text-center'>";
                                echo $status ? htmlspecialchars(ucfirst($status)) : "<span class='text-danger'>Inactive</span>";
                                echo "</td>";

                                // ✅ Created At - fallback if null
                                $createdAt = isset($row['create_at']) ? $row['create_at'] : '';
                                echo "<td class='text-center'>";
                                echo ($createdAt && $createdAt != '0000-00-00 00:00:00') 
                                    ? date("d M Y, h:i A", strtotime($createdAt)) 
                                    : "<span class='text-muted'>N/A</span>";
                                echo "</td>";

                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center text-muted py-5'>
                                    🕊️ <strong>No Users Found:</strong> No records in the database.
                                  </td></tr>";
                        }

                        mysqli_close($db);
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- All Users End -->

<?php include("adminFooter.php"); ?>
