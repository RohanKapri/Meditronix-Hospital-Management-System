<?php
include("patientHeader.php");
?>


<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 25%, #fceabb 50%, #d4fc79 75%, #96e6a1 100%);
        background-attachment: fixed;
        overflow-x: hidden;
    }

    .container {
        max-width: 1400px;
        margin: 130px auto;
        padding: 50px;
        background: rgba(255, 255, 255, 0.12);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        border-radius: 30px;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        animation: fadeInUp 1s ease;
    }

    .dashboard-title {
        font-size: 3rem;
        font-weight: 700;
        text-align: center;
        color: #222;
        margin-bottom: 30px;
        position: relative;
        letter-spacing: 1px;
        background: linear-gradient(to right, #30cfd0 0%, #330867 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .dashboard-title::after {
        content: '';
        width: 150px;
        height: 4px;
        background: linear-gradient(to right, #4facfe, #00f2fe);
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        bottom: -12px;
        border-radius: 3px;
    }

    .visual-banner {
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.3), rgba(245, 245, 245, 0.1));
        padding: 50px;
        border-radius: 20px;
        color: #333;
        margin-bottom: 40px;
        text-align: center;
        font-size: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 0 40px rgba(0, 0, 0, 0.05);
        animation: float 6s infinite ease-in-out;
    }

    .visual-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
        animation: shine 8s linear infinite;
    }

    @keyframes shine {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    .floating {
        animation: float 4s ease-in-out infinite;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    .welcome-text {
        text-align: center;
        font-size: 1.2rem;
        color: #444;
        margin-bottom: 50px;
        line-height: 1.8;
        padding: 0 20px;
        animation: fadeIn 2s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .footer-note {
        text-align: center;
        font-size: 0.95rem;
        color: #777;
        margin-top: 60px;
        animation: fadeIn 3s ease;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            padding: 20px;
            margin: 100px 20px;
        }

        .visual-banner {
            font-size: 1.2rem;
            padding: 30px;
        }

        .dashboard-title {
            font-size: 2rem;
        }

        .welcome-text {
            font-size: 1rem;
        }
    }
</style>

<div class="container floating">
    <div class="visual-banner">
        <strong>Welcome to Meditronix</strong><br>Empowering Healthcare Through Intelligent Technology.<br>Bringing Hospital Management into the Future.
    </div>

    <h1 class="dashboard-title">Patient Dashboard</h1>
    <p class="welcome-text">
        This dashboard is the gateway to your entire healthcare journey at Meditronix.<br> 
        Soon, your appointments, reports, health analytics, and care updates will appear here in a beautiful, interactive carousel.<br>
        Designed for clarity, speed, and elegance — this platform represents the next step in modern healthcare management.
    </p>

    <div class="footer-note">
        Meditronix® Hospital Management System | Designed with Passion for Healthcare Excellence | © 2025
    </div>
</div>

<script>
    // Additional subtle interactive shine on hover (future ready for your carousel)
    const banner = document.querySelector('.visual-banner');
    banner.addEventListener('mousemove', e => {
        const { offsetX: x, offsetY: y } = e;
        banner.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(255, 255, 255, 0.2), rgba(245, 245, 245, 0.05))`;
    });
    banner.addEventListener('mouseleave', () => {
        banner.style.background = 'linear-gradient(145deg, rgba(255, 255, 255, 0.3), rgba(245, 245, 245, 0.1))';
    });
</script>



<?php
// Database Connection
// Ensure your database 'meditronix_new' is running and accessible.
// IMPORTANT: In a production environment, avoid 'root' and empty passwords.
// Use environment variables or a secure configuration file.
$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// --- CRUD Operations PHP Logic ---

// Function to sanitize input data to prevent SQL injection and XSS
function sanitize_input($data) {
    global $db; // Access the global database connection
    $data = trim($data); // Remove whitespace from the beginning and end of string
    $data = stripslashes($data); // Remove backslashes
    $data = htmlspecialchars($data); // Convert special characters to HTML entities
    return mysqli_real_escape_string($db, $data); // Escape special characters in a string for use in an SQL statement
}

// Handle Add Service operation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $doctor_name = sanitize_input($_POST['doctor_name']);
    $service_name = sanitize_input($_POST['service_name']);
    $description = sanitize_input($_POST['description']);
    $fee = sanitize_input($_POST['fee']);
    $status = sanitize_input($_POST['status']);
    $created_at = date('Y-m-d H:i:s'); // Get current timestamp

    // SQL INSERT query to add a new service record
    $insert_query = "INSERT INTO `services` (`doctor's_name`, `name`, `description`, `fee`, `status`, `created_at`) VALUES ('$doctor_name', '$service_name', '$description', '$fee', '$status', '$created_at')";

    if (mysqli_query($db, $insert_query)) {
        // If query is successful, show a success message using JavaScript
        echo "<script>window.onload = function() { showCustomAlert('Service added successfully!', 'success'); }</script>";
    } else {
        // If query fails, show an error message
        echo "<script>window.onload = function() { showCustomAlert('Error adding service: " . mysqli_error($db) . "', 'error'); }</script>";
    }
}

// Handle Edit Service operation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id = sanitize_input($_POST['service_id']); // Service ID to identify the record
    $doctor_name = sanitize_input($_POST['doctor_name']);
    $service_name = sanitize_input($_POST['service_name']);
    $description = sanitize_input($_POST['description']);
    $fee = sanitize_input($_POST['fee']);
    $status = sanitize_input($_POST['status']);

    // SQL UPDATE query to modify an existing service record
    $update_query = "UPDATE `services` SET `doctor's_name`='$doctor_name', `name`='$service_name', `description`='$description', `fee`='$fee', `status`='$status' WHERE `id`='$id'";

    if (mysqli_query($db, $update_query)) {
        // If query is successful, show a success message
        echo "<script>window.onload = function() { showCustomAlert('Service updated successfully!', 'success'); }</script>";
    } else {
        // If query fails, show an error message
        echo "<script>window.onload = function() { showCustomAlert('Error updating service: " . mysqli_error($db) . "', 'error'); }</script>";
    }
}

// Handle Delete Service operation (triggered via GET request for simplicity in this demo)
if (isset($_GET['delete_id'])) {
    $id = sanitize_input($_GET['delete_id']); // Service ID to identify the record to delete
    $delete_query = "DELETE FROM `services` WHERE `id`='$id'";

    if (mysqli_query($db, $delete_query)) {
        // If query is successful, show a success message
        echo "<script>window.onload = function() { showCustomAlert('Service deleted successfully!', 'success'); }</script>";
    } else {
        // If query fails, show an error message
        echo "<script>window.onload = function() { showCustomAlert('Error deleting service: " . mysqli_error($db) . "', 'error'); }</script>";
    }
}

// --- Data Fetching for Display and Charts ---

// Fetch all services data for display in carousel cards
// Ordered by creation date to show latest services first
$services_result = mysqli_query($db, "SELECT `id`, `doctor's_name`, `name`, `description`, `fee`, `status`, `created_at` FROM `services` WHERE 1 ORDER BY created_at DESC");

// Fetch data for charts: Service Status Distribution
$chart_status_query = mysqli_query($db, "SELECT status, COUNT(*) as count FROM `services` GROUP BY status");
$chart_status_counts = [];
while ($row = mysqli_fetch_assoc($chart_status_query)) {
    $chart_status_counts[$row['status']] = $row['count'];
}

// Prepare data for the Bar Chart (Service Status)
$status_labels = json_encode(array_keys($chart_status_counts));
$status_data = json_encode(array_values($chart_status_counts));

// Fetch data for charts: Service Categories Distribution
// This requires a 'category' column or a more sophisticated mapping.
// For this example, we'll try to infer categories from service names or use a default.
$service_categories = [
    'Cardiology' => 0,
    'Dentistry' => 0,
    'Pediatrics' => 0,
    'Dermatology' => 0,
    'General Medicine' => 0,
    'Orthopedics' => 0,
    'Neurology' => 0
];

// Reset pointer for services_result to re-iterate for category counting
mysqli_data_seek($services_result, 0);
while ($row = mysqli_fetch_assoc($services_result)) {
    $service_name_lower = strtolower($row['name']);
    if (strpos($service_name_lower, 'cardio') !== false || strpos($service_name_lower, 'heart') !== false) {
        $service_categories['Cardiology']++;
    } elseif (strpos($service_name_lower, 'dent') !== false || strpos($service_name_lower, 'tooth') !== false || strpos($service_name_lower, 'oral') !== false) {
        $service_categories['Dentistry']++;
    } elseif (strpos($service_name_lower, 'pedi') !== false || strpos($service_name_lower, 'child') !== false) {
        $service_categories['Pediatrics']++;
    } elseif (strpos($service_name_lower, 'derm') !== false || strpos($service_name_lower, 'skin') !== false) {
        $service_categories['Dermatology']++;
    } elseif (strpos($service_name_lower, 'ortho') !== false || strpos($service_name_lower, 'bone') !== false) {
        $service_categories['Orthopedics']++;
    } elseif (strpos($service_name_lower, 'neuro') !== false || strpos($service_name_lower, 'brain') !== false) {
        $service_categories['Neurology']++;
    } else {
        $service_categories['General Medicine']++; // Default category
    }
}
$service_category_labels = json_encode(array_keys($service_categories));
$service_category_data = json_encode(array_values($service_categories));

// Dummy data for Monthly Service Registrations/Additions (Line Chart)
// In a real application, you'd query `created_at` column grouped by month.
$monthly_registrations_data = json_encode([15, 22, 18, 25, 30, 28, 35, 32, 40, 38, 45, 42]); // Last 12 months
$monthly_labels_data = json_encode(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);

// Get total number of services for dummy data generation
$total_existing_services = mysqli_num_rows($services_result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meditronix: Services Management Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome for modern icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    /*======================================================================
      GLOBAL STYLES & BASE LAYOUT
      Defines root variables for consistent theming, basic resets,
      and the overall page structure including the subtle rainbow background.
    ========================================================================*/
    :root {
        --primary-blue: #007bff;
        --secondary-blue: #00c6ff;
        --dark-blue: #0056b3;
        /* Updated pastel rainbow colors for a softer, changing background */
        --pastel-color-1: #e0f2f7; /* Light Blue */
        --pastel-color-2: #e6f7e0; /* Light Green */
        --pastel-color-3: #f7f7e0; /* Light Yellow */
        --pastel-color-4: #f7e0e6; /* Light Pink */
        --pastel-color-5: #e0e6f7; /* Light Purple */
        --text-color-dark: #222;
        --text-color-medium: #555;
        --text-color-light: #888;
        --card-bg: rgba(255, 255, 255, 0.9); /* Slightly less transparent */
        --card-border: rgba(255, 255, 255, 0.7);
        --shadow-light: 0 10px 40px rgba(0,0,0,0.12); /* Enhanced shadow */
        --shadow-hover: 0 20px 60px rgba(0,0,0,0.25); /* More prominent hover shadow */
        --border-radius-xl: 30px; /* Extra large border radius */
        --padding-xl: 3rem; /* Extra large padding */
        --transition-speed: 0.5s;
        --transition-ease: cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Smooth ease for animations */
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        /* Softer, more attractive light rainbow background with more distinct color changes */
        background: linear-gradient(135deg, var(--pastel-color-1) 0%, var(--pastel-color-2) 20%, var(--pastel-color-3) 40%, var(--pastel-color-4) 60%, var(--pastel-color-5) 80%, var(--pastel-color-1) 100%);
        background-size: 400% 400%; /* Larger background size for more subtle movement */
        animation: bgAnim 40s ease infinite alternate; /* Slower, smoother, bi-directional animation */
        overflow-x: hidden;
        color: var(--text-color-medium);
        line-height: 1.8; /* Increased line height for readability */
        position: relative; /* For potential overlay effects */
    }

    /* Background animation for a subtle "wind" effect */
    @keyframes bgAnim {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .main-wrapper {
        max-width: 1500px; /* Increased max-width for a larger layout */
        margin: 60px auto; /* More vertical margin */
        padding: 50px 30px; /* Increased padding */
        background: rgba(255, 255, 255, 0.4); /* Slightly more translucent wrapper background */
        border-radius: var(--border-radius-xl);
        box-shadow: 0 20px 70px rgba(0,0,0,0.1); /* Enhanced shadow */
        backdrop-filter: blur(12px); /* Stronger blur effect */
        border: 1px solid rgba(255,255,255,0.6); /* More prominent border */
        position: relative;
        z-index: 1; /* Ensure content is above background effects */
    }

    /*======================================================================
      HEADER SECTION
      Styling for the main title and introductory paragraph.
    ========================================================================*/
    .header-section {
        text-align: center;
        margin-bottom: 80px; /* Increased margin */
        padding: 40px; /* Increased padding */
        background: rgba(255,255,255,0.9); /* More opaque header background */
        border-radius: var(--border-radius-xl);
        box-shadow: 0 15px 50px rgba(0,0,0,0.2); /* Stronger shadow */
        backdrop-filter: blur(15px); /* Stronger blur */
        border: 1px solid rgba(255,255,255,0.8);
        animation: fadeIn 1.2s ease-out;
    }

    .header-section h1 {
        font-size: 4.2rem; /* Even larger, more impactful heading */
        background: linear-gradient(to right, #00c6ff, #0072ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shimmer 5s ease-in-out infinite; /* Slower, more elegant shimmer */
        margin-bottom: 20px;
        font-weight: 800; /* Bolder font weight */
        letter-spacing: 2px; /* Increased letter spacing */
        text-shadow: 3px 3px 10px rgba(0,0,0,0.15); /* More pronounced text shadow */
    }

    @keyframes shimmer {
        0%, 100% { background-position: -300% 0; }
        50% { background-position: 300% 0; }
    }

    .header-section p {
        font-size: 1.5rem; /* Larger intro text */
        color: var(--text-color-medium);
        max-width: 900px;
        margin: 0 auto;
        line-height: 1.8;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.08); /* Slightly stronger text shadow */
    }

    /*======================================================================
      SERVICE MANAGEMENT SECTION (CRUD FORMS)
      This section contains the forms for adding, editing, and potentially deleting services.
      It's designed to be collapsible or appear in a modal.
    ========================================================================*/
    .crud-section {
        max-width: 900px;
        margin: 60px auto;
        background: var(--card-bg);
        border-radius: var(--border-radius-xl);
        box-shadow: var(--shadow-light);
        padding: 40px;
        border: 1px solid var(--card-border);
        transition: all var(--transition-speed) var(--transition-ease);
    }

    .crud-section h2 {
        text-align: center;
        font-size: 2.5rem;
        color: var(--text-color-dark);
        margin-bottom: 30px;
        border-bottom: 2px solid rgba(0,0,0,0.1);
        padding-bottom: 15px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
    }

    .crud-form-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .crud-section input[type="text"],
    .crud-section input[type="number"],
    .crud-section textarea,
    .crud-section select {
        width: 100%;
        padding: 15px 20px;
        border: 1px solid rgba(0,0,0,0.1);
        border-radius: 15px;
        font-size: 1.1rem;
        background: rgba(255,255,255,0.7);
        transition: all 0.3s ease;
        box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
        color: var(--text-color-dark);
    }

    .crud-section input:focus,
    .crud-section textarea:focus,
    .crud-section select:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(0,123,255,0.25);
        outline: none;
    }

    .crud-section textarea {
        resize: vertical;
        min-height: 100px;
        grid-column: 1 / -1; /* Make textarea span full width */
    }

    .crud-section button {
        padding: 15px 40px;
        border: none;
        border-radius: 30px;
        background: linear-gradient(to right, #4facfe, #00f2fe);
        color: #fff;
        cursor: pointer;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        transition: all 0.4s ease;
        font-size: 1.2rem;
        font-weight: 600;
        display: block;
        margin: 0 auto;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .crud-section button:hover {
        background: linear-gradient(to right, #00f2fe, #4facfe);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.2);
    }

    /* Styles for the Edit Modal */
    .edit-modal {
        display: none; /* Hidden by default */
        position: fixed;
        z-index: 3000; /* Above everything */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.6); /* Darker overlay */
        backdrop-filter: blur(8px);
        animation: fadeIn 0.3s ease-out;
    }

    .edit-modal-content {
        background-color: #fefefe;
        margin: 5% auto; /* Position higher */
        padding: 40px;
        border: 1px solid #888;
        width: 90%;
        max-width: 700px; /* Constrain max width */
        border-radius: var(--border-radius-xl);
        box-shadow: 0 20px 70px rgba(0,0,0,0.3);
        position: relative;
        animation: slideInTop 0.4s ease-out;
    }

    .edit-modal-content .close-button {
        color: #aaa;
        font-size: 2.5rem; /* Larger close button */
        font-weight: bold;
        position: absolute;
        top: 15px;
        right: 25px;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .edit-modal-content .close-button:hover,
    .edit-modal-content .close-button:focus {
        color: #333;
    }

    .edit-modal-content h2 {
        margin-bottom: 25px;
        font-size: 2.2rem;
        color: var(--text-color-dark);
        text-align: center;
    }

    /*======================================================================
      SERVICES CAROUSEL SECTION
      Styling for the service cards carousel, including auto-sliding and click effects.
    ========================================================================*/
    .services-carousel-section {
        overflow-x: hidden; /* Hide default scrollbar */
        padding-bottom: 40px; /* More padding */
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        position: relative;
        padding: 30px 0; /* More vertical padding */
        box-shadow: inset 0 0 20px rgba(0,0,0,0.08); /* Deeper inner shadow */
        border-radius: var(--border-radius-xl);
        background: rgba(255,255,255,0.7); /* Slightly more opaque background */
        border: 1px solid rgba(255,255,255,0.6);
        /* Background image for services section */
        background-image: url('https://cdn.pixabay.com/photo/2017/05/01/14/59/call-center-2275745_1280.jpg'); /* Placeholder image */
        background-size: cover;
        background-position: center;
        background-blend-mode: overlay; /* Blend with the semi-transparent background */
        animation: backgroundPan 60s linear infinite alternate; /* Subtle pan effect */
    }

    @keyframes backgroundPan {
        0% { background-position: 0% 50%; }
        100% { background-position: 100% 50%; }
    }

    /* Custom scrollbar for webkit browsers */
    .services-carousel-section::-webkit-scrollbar {
        height: 14px; /* Thicker scrollbar */
    }
    .services-carousel-section::-webkit-scrollbar-track {
        background: rgba(0,0,0,0.1);
        border-radius: 10px;
    }
    .services-carousel-section::-webkit-scrollbar-thumb {
        background: linear-gradient(to right, #00c6ff, #0072ff);
        border-radius: 10px;
        border: 4px solid rgba(255,255,255,0.9); /* Thicker, brighter border */
    }
    .services-carousel-section::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to right, #0072ff, #00c6ff);
    }

    .services-carousel-track {
        display: flex;
        gap: 50px; /* Increased gap between cards */
        padding: 20px; /* Increased padding inside the track */
        min-width: fit-content;
    }

    .service-card {
        flex: 0 0 380px; /* Slightly reduced card size as requested */
        background: var(--card-bg);
        border-radius: var(--border-radius-xl);
        padding: var(--padding-xl);
        position: relative;
        box-shadow: var(--shadow-light);
        transition: transform var(--transition-speed) var(--transition-ease), box-shadow var(--transition-speed) var(--transition-ease), background var(--transition-speed) var(--transition-ease);
        overflow: hidden;
        border: 1px solid var(--card-border);
        cursor: pointer;
        scroll-snap-align: start;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        z-index: 5; /* Ensure cards are above blade effect */
    }

    .service-card:hover {
        transform: translateY(-15px) scale(1.05); /* More dramatic hover effect */
        box-shadow: var(--shadow-hover);
        background: rgba(255,255,255,1); /* Fully opaque on hover */
    }

    /* Sharp blade shining effect on click */
    .service-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -200%; /* Start even further left */
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent); /* Stronger, brighter shine */
        transform: skewX(-25deg); /* More angled blade effect */
        transition: left 1s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Slower, smoother transition */
        pointer-events: none;
        z-index: 10; /* Ensure blade is on top */
    }
    .service-card.clicked::before {
        left: 200%; /* End even further right */
    }

    /* Water-filled effect on click (radial gradient expanding) */
    .service-card::after {
        content: '';
        position: absolute;
        top: var(--mouse-y, 50%);
        left: var(--mouse-x, 50%);
        width: 0;
        height: 0;
        border-radius: 50%;
        background: radial-gradient(circle at center, rgba(0, 123, 255, 0.3), transparent 70%); /* Blue water ripple */
        opacity: 0;
        transform: translate(-50%, -50%);
        transition: width 0.6s ease-out, height 0.6s ease-out, opacity 0.6s ease-out;
        pointer-events: none;
        z-index: 9;
    }
    .service-card.clicked::after {
        width: 200%; /* Expand significantly */
        height: 200%;
        opacity: 1;
    }

    .service-icon-container {
        width: 100px; /* Slightly smaller icon container */
        height: 100px;
        background: linear-gradient(135deg, #00c6ff, #0072ff);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 3.2rem; /* Larger icon font */
        margin: 0 auto 25px; /* More margin */
        box-shadow: 0 10px 25px rgba(0,114,255,0.5); /* Stronger shadow */
        transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55); /* Springy animation */
        position: relative;
        overflow: hidden; /* For inner glow effect */
    }
    .service-icon-container::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at center, rgba(255,255,255,0.3), transparent 70%);
        animation: iconPulse 3s infinite alternate; /* Pulsing glow */
    }
    @keyframes iconPulse {
        0% { transform: scale(0.8); opacity: 0.5; }
        100% { transform: scale(1.2); opacity: 0.8; }
    }

    .service-card:hover .service-icon-container {
        transform: rotate(20deg) scale(1.2); /* More dramatic rotate and scale */
    }

    .service-card h2 {
        font-size: 1.6rem; /* Slightly smaller title */
        color: var(--text-color-dark);
        margin-bottom: 15px;
        text-align: center;
        font-weight: 700;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
    }

    .service-card p {
        color: var(--text-color-medium);
        font-size: 1rem; /* Slightly smaller text */
        margin-bottom: 20px;
        line-height: 1.7;
        text-align: justify;
        flex-grow: 1;
    }

    .service-card footer {
        font-size: 0.95rem; /* Slightly smaller footer text */
        color: var(--text-color-light);
        display: flex;
        justify-content: space-between;
        margin-top: 25px;
        border-top: 1px dashed rgba(0,0,0,0.2); /* More visible dashed border */
        padding-top: 20px;
        align-items: center;
    }

    .card-social-links {
        display: flex;
        gap: 18px; /* Increased gap for social icons */
    }
    .card-social-links a {
        color: var(--primary-blue);
        font-size: 1.4rem; /* Slightly smaller social icons */
        transition: color 0.3s ease, transform 0.3s ease;
        text-decoration: none;
    }
    .card-social-links a:hover {
        transform: translateY(-7px) scale(1.3); /* More pronounced effect */
        color: var(--dark-blue);
        text-shadow: 0 5px 10px rgba(0,123,255,0.3);
    }

    /*======================================================================
      CHARTS SECTION
      Styling for the analytics charts, including individual containers and click effects.
    ========================================================================*/
    .charts-section {
        display: grid;
        grid-template-columns: 1fr; /* Each chart on a new row as requested */
        gap: 60px; /* Increased gap between charts */
        margin-top: 100px; /* More margin */
    }

    .chart-container-wrapper {
        background: var(--card-bg);
        border-radius: var(--border-radius-xl);
        box-shadow: var(--shadow-light);
        padding: 35px; /* Increased padding */
        position: relative;
        overflow: hidden;
        transition: transform var(--transition-speed) var(--transition-ease), box-shadow var(--transition-speed) var(--transition-ease);
        border: 1px solid var(--card-border);
        display: flex;
        flex-direction: column;
        cursor: pointer; /* Indicate clickability */
        max-width: 1000px; /* Max width for larger charts */
        margin: 0 auto; /* Center individual chart containers */
    }
    .chart-container-wrapper:hover {
        transform: translateY(-12px) scale(1.03); /* Lift and slight scale on hover */
        box-shadow: var(--shadow-hover);
    }

    /* Chart shine effect on click */
    .chart-container-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, rgba(255,255,255,0.4), transparent 70%);
        opacity: 0;
        transition: opacity 0.5s ease-out;
        pointer-events: none;
        z-index: 1;
    }
    .chart-container-wrapper.clicked::before {
        animation: chartShine 1s forwards;
    }
    @keyframes chartShine {
        0% { opacity: 0; transform: scale(0.5); }
        50% { opacity: 1; transform: scale(1); }
        100% { opacity: 0; transform: scale(1.5); }
    }


    .chart-container-wrapper h3 {
        text-align: center;
        margin-bottom: 30px;
        color: var(--text-color-dark);
        font-size: 1.8rem; /* Larger chart titles */
        font-weight: 700;
        border-bottom: 2px solid rgba(0,0,0,0.1);
        padding-bottom: 18px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
    }

    .chart-container-wrapper p.chart-description {
        text-align: center;
        font-size: 1rem;
        color: var(--text-color-medium);
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .chart-canvas-container {
        position: relative;
        height: 500px; /* Increased fixed height for "larger graphs" */
        width: 100%;
        flex-grow: 1;
    }

    /* Chart specific styles for better visuals */
    canvas {
        background: transparent; /* Chart.js handles its own background */
    }

    /*======================================================================
      POPUP MESSAGES (CUSTOM ALERTS/CONFIRMS)
      Styling for the interactive popup message.
    ========================================================================*/
    .custom-modal {
        display: none; /* Hidden by default */
        position: fixed;
        z-index: 3000; /* Above everything */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.6); /* Darker overlay */
        backdrop-filter: blur(8px);
        animation: fadeIn 0.3s ease-out;
        justify-content: center;
        align-items: center;
    }

    .custom-modal-content {
        background-color: #fefefe;
        margin: auto; /* Center vertically and horizontally */
        padding: 40px;
        border: 1px solid #888;
        width: 90%;
        max-width: 500px; /* Constrain max width */
        border-radius: var(--border-radius-xl);
        box-shadow: 0 20px 70px rgba(0,0,0,0.3);
        position: relative;
        animation: slideInTop 0.4s ease-out;
        text-align: center;
    }

    .custom-modal-content .close-button {
        color: #aaa;
        font-size: 2.5rem; /* Larger close button */
        font-weight: bold;
        position: absolute;
        top: 15px;
        right: 25px;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .custom-modal-content .close-button:hover,
    .custom-modal-content .close-button:focus {
        color: #333;
    }

    .custom-modal-content h3 {
        margin-bottom: 20px;
        font-size: 2rem;
        color: var(--text-color-dark);
    }

    .custom-modal-content p {
        margin-bottom: 30px;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .custom-modal-content .modal-buttons button {
        padding: 10px 25px;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        transition: background 0.3s ease, transform 0.2s ease;
        margin: 0 10px;
    }

    .custom-modal-content .modal-buttons .btn-ok {
        background: #28a745;
        color: #fff;
    }
    .custom-modal-content .modal-buttons .btn-ok:hover {
        background: #218838;
        transform: translateY(-2px);
    }

    .custom-modal-content .modal-buttons .btn-cancel {
        background: #dc3545;
        color: #fff;
    }
    .custom-modal-content .modal-buttons .btn-cancel:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    /* Specific styling for the initial "Thanks for exploring" popup */
    #popup-message {
        background: linear-gradient(45deg, #ff9a9e 0%, #fad0c4 99%, #fad0c4 100%);
        padding: 40px 70px; /* Larger padding */
        border-radius: var(--border-radius-xl);
        font-size: 2.5rem; /* Larger text */
        color: #fff;
        text-shadow: 1px 1px 5px rgba(0,0,0,0.4);
        box-shadow: 0 0 30px rgba(255,154,158,0.8); /* Stronger shadow */
        opacity: 0;
        transition: transform 0.7s cubic-bezier(0.68, -0.55, 0.27, 1.55), opacity 0.7s ease;
        z-index: 2000; /* Highest z-index */
        border: 4px solid rgba(255,255,255,0.9);
        font-weight: bold;
        letter-spacing: 1px;
    }
    #popup-message.show {
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
    }

    /*======================================================================
      FOOTER & SOCIAL LINKS
      Styling for the social media links and copyright information.
    ========================================================================*/
    .footer-social-links {
        text-align: center;
        margin-top: 120px; /* More margin */
        padding-top: 60px; /* More padding */
        border-top: 1px solid rgba(0,0,0,0.2); /* More visible border */
        padding-bottom: 40px;
    }
    .footer-social-links a {
        margin: 0 30px; /* Increased spacing */
        color: var(--primary-blue);
        font-size: 2.5rem; /* Larger icons */
        text-decoration: none;
        transition: color 0.4s ease, transform 0.4s ease, text-shadow 0.4s ease;
    }
    .footer-social-links a:hover {
        transform: translateY(-10px) scale(1.3); /* More lift */
        color: var(--dark-blue);
        text-shadow: 0 8px 15px rgba(0,123,255,0.4);
    }

    footer {
        text-align: center;
        margin-top: 50px;
        padding: 30px 0;
        border-top: 1px dashed rgba(0,0,0,0.15);
        color: var(--text-color-light);
        font-size: 1rem;
    }

    /*======================================================================
      RESPONSIVE DESIGN
      Media queries for optimal viewing on various screen sizes.
    ========================================================================*/
    @media (max-width: 1400px) {
        .main-wrapper {
            max-width: 1200px;
        }
        .service-card {
            flex: 0 0 450px;
        }
    }

    @media (max-width: 1200px) {
        .main-wrapper {
            max-width: 960px;
        }
        .header-section h1 {
            font-size: 3.5rem;
        }
        .header-section p {
            font-size: 1.2rem;
        }
        .service-card {
            flex: 0 0 400px;
            padding: 2.2rem;
        }
        .charts-section {
            gap: 40px;
        }
        .chart-canvas-container {
            height: 400px;
        }
    }

    @media (max-width: 992px) {
        .main-wrapper {
            padding: 30px 20px;
            margin: 30px auto;
        }
        .header-section {
            padding: 30px;
            margin-bottom: 50px;
        }
        .header-section h1 {
            font-size: 2.8rem;
        }
        .header-section p {
            font-size: 1.1rem;
        }
        .service-card {
            flex: 0 0 350px;
            padding: 2rem;
        }
        .service-icon-container {
            width: 90px;
            height: 90px;
            font-size: 2.8rem;
            margin-bottom: 25px;
        }
        .service-card h2 {
            font-size: 1.5rem;
        }
        .service-card p {
            font-size: 1rem;
        }
        .charts-section {
            grid-template-columns: 1fr; /* Stack charts vertically */
            gap: 30px;
            margin-top: 70px;
        }
        .chart-container-wrapper {
            padding: 25px;
            max-width: 100%; /* Allow full width on smaller screens */
        }
        .chart-container-wrapper h3 {
            font-size: 1.5rem;
        }
        .chart-canvas-container {
            height: 350px;
        }
        .footer-social-links {
            margin-top: 80px;
            padding-top: 40px;
        }
        .footer-social-links a {
            font-size: 2rem;
            margin: 0 20px;
        }
        .custom-modal-content {
            padding: 30px;
        }
        .custom-modal-content h3 {
            font-size: 1.8rem;
        }
        .custom-modal-content p {
            font-size: 1rem;
        }
        #popup-message {
            padding: 30px 50px;
            font-size: 2rem;
        }
    }

    @media (max-width: 768px) {
        body {
            padding: 10px 0;
        }
        .main-wrapper {
            padding: 20px 15px;
            margin: 20px auto;
        }
        .header-section {
            padding: 20px;
            margin-bottom: 40px;
        }
        .header-section h1 {
            font-size: 2.2rem;
            letter-spacing: 1px;
        }
        .header-section p {
            font-size: 0.95rem;
        }
        .service-card {
            flex: 0 0 95%; /* Take up almost full width */
            margin: 0 auto; /* Center cards */
            padding: 1.8rem;
            min-width: 280px;
        }
        .services-carousel-track {
            justify-content: flex-start;
            padding-left: 10px;
            padding-right: 10px;
            gap: 30px;
        }
        .service-icon-container {
            width: 80px;
            height: 80px;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .service-card h2 {
            font-size: 1.3rem;
        }
        .service-card p {
            font-size: 0.9rem;
            line-height: 1.6;
        }
        .service-card footer {
            font-size: 0.8rem;
            padding-top: 15px;
        }
        .card-social-links a {
            font-size: 1rem;
            margin: 0 8px;
        }
        .charts-section {
            grid-template-columns: 1fr; /* Stack charts vertically */
            gap: 20px;
            margin-top: 50px;
        }
        .chart-container-wrapper {
            padding: 20px;
        }
        .chart-container-wrapper h3 {
            font-size: 1.2rem;
        }
        .chart-canvas-container {
            height: 300px;
        }
        .footer-social-links {
            margin-top: 60px;
            padding-top: 30px;
        }
        .footer-social-links a {
            font-size: 1.6rem;
            margin: 0 15px;
        }
        .custom-modal-content {
            padding: 20px;
        }
        .custom-modal-content h3 {
            font-size: 1.5rem;
        }
        .custom-modal-content p {
            font-size: 0.9rem;
        }
        #popup-message {
            width: 90%;
            padding: 20px 30px;
            font-size: 1.6rem;
        }
    }

    @media (max-width: 480px) {
        .header-section h1 {
            font-size: 1.8rem;
        }
        .header-section p {
            font-size: 0.8rem;
        }
        .service-card {
            padding: 1.5rem;
            flex: 0 0 98%;
        }
        .service-icon-container {
            width: 60px;
            height: 60px;
            font-size: 1.6rem;
        }
        .service-card h2 {
            font-size: 1.1rem;
        }
        .service-card p {
            font-size: 0.8rem;
        }
        .card-social-links a {
            font-size: 0.9rem;
        }
        .charts-section {
            gap: 15px;
        }
        .chart-container-wrapper {
            padding: 15px;
        }
        .chart-container-wrapper h3 {
            font-size: 1rem;
        }
        .chart-canvas-container {
            height: 250px;
        }
        .footer-social-links a {
            font-size: 1.2rem;
            margin: 0 10px;
        }
        .custom-modal-content {
            padding: 15px;
        }
        .custom-modal-content h3 {
            font-size: 1.2rem;
        }
        .custom-modal-content p {
            font-size: 0.8rem;
        }
        #popup-message {
            font-size: 1.3rem;
            padding: 15px 25px;
        }
    }
    </style>
</head>
<body>

<div class="main-wrapper">
    <!-- Header Section -->
    <div class="header-section">
        <h1><i class="fas fa-hand-holding-medical" style="margin-right: 15px; color: #00c6ff;"></i>Meditronix: Comprehensive Medical Services<i class="fas fa-heartbeat" style="margin-left: 15px; color: #0072ff;"></i></h1>
        <p>At Meditronix, we are dedicated to providing a wide array of high-quality medical services designed to meet your every healthcare need. From routine check-ups to specialized treatments, our expert team ensures compassionate care and innovative solutions. Explore our offerings below, manage service details, and gain valuable insights through our interactive analytics dashboard.</p>
    </div>

    <!-- Service Management Section (CRUD Forms) -->
    <div class="crud-section">

        <!-- Edit Service Modal (Hidden by default, shown by JS) -->
        <div id="editServiceModal" class="custom-modal">
            <div class="custom-modal-content">
                <span class="close-button" onclick="closeEditModal()">&times;</span>
                <h2>Edit Service</h2>
                <form id="editServiceForm" method="post" action="">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" id="editServiceId" name="service_id">
                    <div class="crud-form-group">
                        <input type="text" id="editDoctorName" name="doctor_name" placeholder="Doctor's Name" required>
                        <input type="text" id="editServiceName" name="service_name" placeholder="Service Name" required>
                        <textarea id="editDescription" name="description" placeholder="Service Description" required></textarea>
                        <input type="number" id="editFee" name="fee" placeholder="Fee (e.g., 100.00)" step="0.01" required>
                        <select id="editStatus" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    <button type="submit">Update Service</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Services Carousel Section -->
    <div class="services-carousel-section" id="servicesCarouselContainer">
        <h2 style="text-align: center; font-size: 2.8rem; color: var(--text-color-dark); margin-bottom: 40px; text-shadow: 1px 1px 2px rgba(0,0,0,0.05);">Our Diverse Medical Services</h2>
        <div class="services-carousel-track" id="servicesCarouselTrack">
            <?php
            // Reset pointer for services_result to ensure all services are displayed
            mysqli_data_seek($services_result, 0);
            $service_count = 0;
            while ($row = mysqli_fetch_assoc($services_result)) {
                $service_count++;
                // Determine icon based on service name (simple logic for demonstration)
                $icon_class = 'fas fa-hospital'; // Default icon
                $service_name_lower = strtolower($row['name']);
                if (strpos($service_name_lower, 'cardio') !== false || strpos($service_name_lower, 'heart') !== false) {
                    $icon_class = 'fas fa-heartbeat';
                } elseif (strpos($service_name_lower, 'dent') !== false || strpos($service_name_lower, 'tooth') !== false) {
                    $icon_class = 'fas fa-tooth';
                } elseif (strpos($service_name_lower, 'pedi') !== false || strpos($service_name_lower, 'child') !== false) {
                    $icon_class = 'fas fa-child';
                } elseif (strpos($service_name_lower, 'derm') !== false || strpos($service_name_lower, 'skin') !== false) {
                    $icon_class = 'fas fa-allergies';
                } elseif (strpos($service_name_lower, 'ortho') !== false || strpos($service_name_lower, 'bone') !== false) {
                    $icon_class = 'fas fa-bone';
                } elseif (strpos($service_name_lower, 'neuro') !== false || strpos($service_name_lower, 'brain') !== false) {
                    $icon_class = 'fas fa-brain';
                } elseif (strpos($service_name_lower, 'physio') !== false) {
                    $icon_class = 'fas fa-running';
                } elseif (strpos($service_name_lower, 'therapy') !== false) {
                    $icon_class = 'fas fa-hand-holding-heart';
                }
            ?>
            <div class="service-card" data-service-id="<?= $row['id']; ?>" data-doctor-name="<?= htmlspecialchars($row['doctor\'s_name']); ?>" data-service-name="<?= htmlspecialchars($row['name']); ?>" data-description="<?= htmlspecialchars($row['description']); ?>" data-fee="<?= htmlspecialchars($row['fee']); ?>" data-status="<?= htmlspecialchars($row['status']); ?>">
                <div class="service-icon-container"><i class="<?= $icon_class; ?>"></i></div>
                <h2><?= htmlspecialchars($row['name']); ?></h2>
                <p><strong>Doctor:</strong> <?= htmlspecialchars($row['doctor\'s_name']); ?></p>
                <p><?= nl2br(htmlspecialchars($row['description'])); ?></p>
 
                <div style="margin-top: 15px; text-align: center;">
                    <button onclick="event.stopPropagation(); openEditModal(this)" style="background: linear-gradient(to right, #30cfd0, #330867); color: #fff; padding: 8px 15px; border-radius: 20px; border: none; cursor: pointer; font-size: 0.9rem; margin-right: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: all 0.3s ease;">Edit</button>
                    <button onclick="event.stopPropagation(); deleteService(<?= $row['id']; ?>)" style="background: linear-gradient(to right, #ff5f6d, #ffc371); color: #fff; padding: 8px 15px; border-radius: 20px; border: none; cursor: pointer; font-size: 0.9rem; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: all 0.3s ease;">Delete</button>
                </div>
            </div>
            <?php } ?>
            <?php
            // Add dummy cards if fewer than 5 services exist, to ensure carousel functionality and visual appeal
            $required_dummy_cards = 5 - $service_count;
            for ($i = 0; $i < $required_dummy_cards; $i++) {
                $dummy_titles = [
                    "Advanced Diagnostics", "Preventative Care", "Rehabilitation Programs",
                    "Nutritional Counseling", "Emergency Services"
                ];
                $dummy_descriptions = [
                    "Utilizing cutting-edge technology for precise and early detection of health conditions.",
                    "Proactive health strategies including vaccinations, screenings, and lifestyle advice.",
                    "Tailored programs to restore function and improve quality of life after injury or illness.",
                    "Personalized dietary plans and guidance for optimal health and disease management.",
                    "Rapid response and critical care for urgent medical situations, available 24/7."
                ];
                $dummy_fees = [8500.00, 3200.00, 6000.00, 2500.00, 15000.00];
                $dummy_statuses = ["Active", "Active", "Pending", "Active", "Active"];
                $dummy_doctors = ["Dr. Emily White", "Dr. David Green", "Dr. Sarah Brown", "Dr. Alex Johnson", "Dr. Olivia Davis"];
                $dummy_icons = [
                    'fas fa-x-ray', 'fas fa-shield-alt', 'fas fa-wheelchair',
                    'fas fa-apple-alt', 'fas fa-ambulance'
                ];

                $rand_idx = $i % count($dummy_titles); // Cycle through dummy data
            ?>
            <div class="service-card">
                <div class="service-icon-container"><i class="<?= $dummy_icons[$rand_idx]; ?>"></i></div>
                <h2><?= htmlspecialchars($dummy_titles[$rand_idx]); ?></h2>
                <p><strong>Doctor:</strong> <?= htmlspecialchars($dummy_doctors[$rand_idx]); ?></p>
                <p><?= nl2br(htmlspecialchars($dummy_descriptions[$rand_idx])); ?></p>
 
                <div style="margin-top: 15px; text-align: center;">
                    <button onclick="event.stopPropagation(); showCustomAlert('This is a dummy service, cannot edit.', 'info');" style="background: linear-gradient(to right, #30cfd0, #330867); color: #fff; padding: 8px 15px; border-radius: 20px; border: none; cursor: pointer; font-size: 0.9rem; margin-right: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: all 0.3s ease;">Edit</button>
                    <button onclick="event.stopPropagation(); showCustomAlert('This is a dummy service, cannot delete.', 'info');" style="background: linear-gradient(to right, #ff5f6d, #ffc371); color: #fff; padding: 8px 15px; border-radius: 20px; border: none; cursor: pointer; font-size: 0.9rem; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: all 0.3s ease;">Delete</button>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-section">
        <div class="chart-container-wrapper">
            <h3>Service Status Distribution</h3>
            <p class="chart-description">This dynamic bar chart provides a clear and insightful breakdown of the current status of all medical services offered by Meditronix. Quickly visualize the proportion of services that are 'Active' and available, 'Inactive' (e.g., temporarily suspended), or 'Pending' (e.g., under development or review). This helps in service portfolio management and operational planning.</p>
            <div class="chart-canvas-container">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <div class="chart-container-wrapper">
            <h3>Categorization of Medical Services</h3>
            <p class="chart-description">Explore the thematic distribution of our medical services at a glance. This interactive doughnut chart illustrates the proportional representation of services across key specialties such as 'Cardiology', 'Dentistry', 'Pediatrics', 'Dermatology', 'General Medicine', 'Orthopedics', and 'Neurology'. It helps identify service demand and resource allocation.</p>
            <div class="chart-canvas-container">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
        <div class="chart-container-wrapper">
            <h3>Monthly Service Registrations Trend</h3>
            <p class="chart-description">Monitor the growth and popularity of our services over time. This engaging line chart displays the monthly trend of new service registrations, allowing you to track demand, identify seasonal patterns, and evaluate marketing effectiveness. Data points are highlighted for easy trend analysis.</p>
            <div class="chart-canvas-container">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Custom Popup Message -->
<div id="customPopupMessage" class="custom-modal">
    <div class="custom-modal-content">
        <span class="close-button" onclick="closeCustomAlert()">&times;</span>
        <h3 id="popupTitle"></h3>
        <p id="popupMessage"></p>
        <div class="modal-buttons">
            <button class="btn-ok" onclick="closeCustomAlert()">OK</button>
        </div>
    </div>
</div>

<!-- Custom Confirm Modal -->
<div id="customConfirmModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="close-button" onclick="closeCustomConfirm()">&times;</span>
        <h3>Confirm Action</h3>
        <p id="confirmMessage"></p>
        <div class="modal-buttons">
            <button class="btn-ok" id="confirmOkBtn">Yes</button>
            <button class="btn-cancel" id="confirmCancelBtn">No</button>
        </div>
    </div>
</div>

<!-- Initial "Thanks for exploring" popup -->
<div id="popup-message">✨ Welcome to Meditronix Services ✨</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
//======================================================================
// JAVASCRIPT FUNCTIONS & INTERACTIVITY
// This section handles all dynamic behaviors, including popup messages,
// click effects on cards and charts, and the carousel auto-sliding.
//======================================================================

// --- Custom Alert/Confirm Modals (replacing native alert() and confirm()) ---
function showCustomAlert(message, type = 'info') {
    const popupModal = document.getElementById('customPopupMessage');
    const popupTitle = document.getElementById('popupTitle');
    const popupMessage = document.getElementById('popupMessage');
    const okButton = popupModal.querySelector('.btn-ok');

    popupTitle.textContent = type.charAt(0).toUpperCase() + type.slice(1); // Capitalize type (e.g., "Success", "Error")
    popupMessage.textContent = message;

    // Set title color based on type
    if (type === 'success') {
        popupTitle.style.color = '#28a745';
        okButton.style.background = '#28a745';
    } else if (type === 'error') {
        popupTitle.style.color = '#dc3545';
        okButton.style.background = '#dc3545';
    } else { // info or default
        popupTitle.style.color = '#007bff';
        okButton.style.background = '#007bff';
    }

    popupModal.style.display = 'flex'; // Use flex to center
}

function closeCustomAlert() {
    document.getElementById('customPopupMessage').style.display = 'none';
}

function showCustomConfirm(message, onConfirmCallback) {
    const confirmModal = document.getElementById('customConfirmModal');
    const confirmMessage = document.getElementById('confirmMessage');
    const confirmOkBtn = document.getElementById('confirmOkBtn');
    const confirmCancelBtn = document.getElementById('confirmCancelBtn');

    confirmMessage.textContent = message;
    confirmModal.style.display = 'flex';

    // Clear previous event listeners to prevent multiple calls
    confirmOkBtn.onclick = null;
    confirmCancelBtn.onclick = null;

    confirmOkBtn.onclick = () => {
        onConfirmCallback();
        confirmModal.style.display = 'none';
    };
    confirmCancelBtn.onclick = () => {
        confirmModal.style.display = 'none';
    };
}

function closeCustomConfirm() {
    document.getElementById('customConfirmModal').style.display = 'none';
}

// Initial "Thanks for exploring" popup on page load
window.onload = function() {
    const initialPopup = document.getElementById('popup-message');
    initialPopup.classList.add('show');
    setTimeout(() => initialPopup.classList.remove('show'), 3000);
};

// --- Service Card Interactions ---
document.querySelectorAll('.service-card').forEach(card => {
    card.addEventListener('click', (event) => {
        // Prevent default click behavior and effects if a social link or button inside the card was clicked
        if (event.target.closest('.card-social-links') || event.target.tagName === 'BUTTON') {
            return;
        }

        // Add 'clicked' class to trigger the sharp blade shine and water-filled effects
        card.classList.add('clicked');

        // Capture mouse position for the water-filled effect origin
        const rect = card.getBoundingClientRect();
        const mouseX = event.clientX - rect.left; // X position within the element
        const mouseY = event.clientY - rect.top;  // Y position within the element
        card.style.setProperty('--mouse-x', `${mouseX}px`);
        card.style.setProperty('--mouse-y', `${mouseY}px`);

        // Remove the 'clicked' class after the animation duration to allow re-triggering
        setTimeout(() => {
            card.classList.remove('clicked');
        }, 800); // Matches the CSS transition duration for the blade effect
    });
});

// --- Chart Container Interactions ---
document.querySelectorAll('.chart-container-wrapper').forEach(chartContainer => {
    chartContainer.addEventListener('click', () => {
        chartContainer.classList.add('clicked');
        setTimeout(() => {
            chartContainer.classList.remove('clicked');
        }, 1000); // Matches the CSS animation duration for chartShine
    });
});

// --- CRUD Modals and Operations ---

// Function to open the Edit Service Modal and populate it with data
function openEditModal(button) {
    const card = button.closest('.service-card');
    const serviceId = card.dataset.serviceId;
    const doctorName = card.dataset.doctorName;
    const serviceName = card.dataset.serviceName;
    const description = card.dataset.description;
    const fee = card.dataset.fee;
    const status = card.dataset.status;

    document.getElementById('editServiceId').value = serviceId;
    document.getElementById('editDoctorName').value = doctorName;
    document.getElementById('editServiceName').value = serviceName;
    document.getElementById('editDescription').value = description;
    document.getElementById('editFee').value = fee;
    document.getElementById('editStatus').value = status;

    document.getElementById('editServiceModal').style.display = 'flex'; // Show the modal
}

// Function to close the Edit Service Modal
function closeEditModal() {
    document.getElementById('editServiceModal').style.display = 'none';
}

// Function to handle Delete Service operation
function deleteService(id) {
    showCustomConfirm('Are you sure you want to delete this service? This action cannot be undone.', () => {
        window.location.href = '?delete_id=' + id; // Redirect to trigger PHP delete logic
    });
}

//======================================================================
// CHART.JS CONFIGURATION AND INITIALIZATION
// This section defines the data, options, and initializes all Chart.js instances.
//======================================================================

// PHP variables are already JSON encoded in the PHP block
const barChartLabels = <?php echo $status_labels; ?>;
const barChartDataValues = <?php echo $status_data; ?>;

const pieChartLabels = <?php echo $service_category_labels; ?>;
const pieChartDataValues = <?php echo $service_category_data; ?>;

const lineChartLabels = <?php echo $monthly_labels_data; ?>;
const lineChartDataValues = <?php echo $monthly_registrations_data; ?>;


// Common Chart Options for responsiveness, animation, and styling
const chartCommonOptions = {
    responsive: true,
    maintainAspectRatio: false, /* Crucial for preventing overflow with fixed height parent */
    animation: {
        duration: 1800, /* Slower, more graceful animation for charts */
        easing: 'easeInOutQuart' /* Smooth easing function */
    },
    plugins: {
        legend: {
            display: true, /* Display legend by default */
            position: 'bottom',
            labels: {
                color: '#555',
                font: {
                    size: 15, /* Larger legend font */
                    family: 'Segoe UI'
                },
                padding: 25 /* More padding for legend items */
            }
        },
        tooltip: {
            backgroundColor: 'rgba(0,0,0,0.9)', /* Darker tooltip background */
            titleColor: '#fff',
            bodyColor: '#fff',
            borderColor: 'rgba(255,255,255,0.6)', /* Brighter border */
            borderWidth: 2, /* Thicker border */
            cornerRadius: 12, /* More rounded corners */
            displayColors: true,
            bodyFont: {
                size: 15
            },
            titleFont: {
                size: 17,
                weight: 'bold'
            },
            padding: 15
        }
    },
    scales: {
        x: {
            grid: {
                display: false,
                drawBorder: false
            },
            ticks: {
                color: '#777',
                font: {
                    size: 13
                }
            }
        },
        y: {
            beginAtZero: true,
            grid: {
                color: 'rgba(0,0,0,0.12)', /* More visible grid lines */
                drawBorder: false
            },
            ticks: {
                color: '#777',
                font: {
                    size: 13
                }
            }
        }
    }
};

// Bar Chart Initialization
const barCtx = document.getElementById('barChart').getContext('2d');
const barChart = new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: barChartLabels,
        datasets: [{
            label: 'Service Count',
            data: barChartDataValues,
            backgroundColor: [
                'rgba(0, 123, 255, 0.9)', /* Primary Blue - Active */
                'rgba(255, 193, 7, 0.9)',  /* Warning Yellow - Pending */
                'rgba(220, 53, 69, 0.9)'   /* Danger Red - Inactive */
            ],
            borderColor: [
                'rgba(0, 123, 255, 1)',
                'rgba(255, 193, 7, 1)',
                'rgba(220, 53, 69, 1)'
            ],
            borderWidth: 1,
            borderRadius: 10,
            hoverBackgroundColor: [
                'rgba(0, 123, 255, 1)',
                'rgba(255, 193, 7, 1)',
                'rgba(220, 53, 69, 1)'
            ],
            hoverBorderColor: [
                'rgba(0, 86, 179, 1)',
                'rgba(204, 155, 0, 1)',
                'rgba(179, 43, 56, 1)'
            ]
        }]
    },
    options: {
        ...chartCommonOptions,
        plugins: {
            ...chartCommonOptions.plugins,
            legend: { display: false }
        },
        scales: {
            x: {
                ...chartCommonOptions.scales.x,
                grid: {
                    display: false
                }
            },
            y: {
                ...chartCommonOptions.scales.y,
                grid: {
                    color: 'rgba(0,0,0,0.15)'
                }
            }
        }
    }
});

// Pie Chart Initialization (Doughnut type for modern look)
const pieCtx = document.getElementById('pieChart').getContext('2d');
const pieChart = new Chart(pieCtx, {
    type: 'doughnut',
    data: {
        labels: pieChartLabels,
        datasets: [{
            data: pieChartDataValues,
            // Ensured enough colors for all 7 categories
            backgroundColor: [
                'rgba(40, 167, 69, 0.9)',  /* Success Green - Cardiology */
                'rgba(23, 162, 184, 0.9)', /* Info Cyan - Dentistry */
                'rgba(111, 66, 193, 0.9)', /* Purple - Pediatrics */
                'rgba(253, 126, 20, 0.9)',  /* Orange - Dermatology */
                'rgba(102, 16, 242, 0.9)', /* Darker Purple - General Medicine */
                'rgba(255, 99, 132, 0.9)', /* Red-Pink - Orthopedics */
                'rgba(54, 162, 235, 0.9)'  /* Blue - Neurology */
            ],
            borderColor: '#fff',
            borderWidth: 3,
            hoverOffset: 20,
            // Ensured enough hover colors for all 7 categories
            hoverBackgroundColor: [
                'rgba(40, 167, 69, 1)',
                'rgba(23, 162, 184, 1)',
                'rgba(111, 66, 193, 1)',
                'rgba(253, 126, 20, 1)',
                'rgba(102, 16, 242, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'
            ]
        }]
    },
    options: {
        ...chartCommonOptions,
        scales: { /* No scales for pie/doughnut chart */ },
        plugins: {
            ...chartCommonOptions.plugins,
            legend: {
                position: 'right',
                labels: {
                    boxWidth: 25,
                    padding: 20
                }
            }
        }
    }
});

// Line Chart Initialization
const lineCtx = document.getElementById('lineChart').getContext('2d');
const lineChart = new Chart(lineCtx, {
    type: 'line',
    data: {
        labels: lineChartLabels,
        datasets: [{
            label: 'Monthly Registrations',
            data: lineChartDataValues,
            fill: true,
            backgroundColor: 'rgba(0, 123, 255, 0.3)',
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 4,
            tension: 0.4,
            pointBackgroundColor: 'rgba(0, 123, 255, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 3,
            pointRadius: 7,
            pointHoverRadius: 10,
            pointHitRadius: 25
        }]
    },
    options: {
        ...chartCommonOptions,
        scales: {
            x: {
                ...chartCommonOptions.scales.x,
                grid: {
                    display: false
                }
            },
            y: {
                ...chartCommonOptions.scales.y,
                grid: {
                    color: 'rgba(0,0,0,0.15)'
                }
            }
        }
    }
});

//======================================================================
// CAROUSEL AUTO-SLIDING FEATURE (BI-DIRECTIONAL "TRAIN" MOVEMENT)
// This section controls the automatic, smooth, back-and-forth scrolling
// of the service cards carousel.
//======================================================================
const servicesCarouselContainer = document.getElementById('servicesCarouselContainer');
const servicesCarouselTrack = document.getElementById('servicesCarouselTrack');
const serviceCards = document.querySelectorAll('.service-card');

let currentScroll = 0;
let scrollDirection = 1; // 1 for right, -1 for left
let carouselAnimationFrameId;
const scrollSpeed = 2.0; // Faster pixels per frame for a more dynamic "train" effect
const pauseAtEndDuration = 2500; // Slightly reduced pause at the end/start

function animateServicesCarousel() {
    currentScroll += scrollDirection * scrollSpeed;
    servicesCarouselContainer.scrollLeft = currentScroll;

    // Check if we've reached the end or the beginning
    const maxScrollLeft = servicesCarouselTrack.scrollWidth - servicesCarouselContainer.clientWidth;

    if (scrollDirection === 1 && servicesCarouselContainer.scrollLeft >= maxScrollLeft - 5) { // Reached end (with a small buffer)
        cancelAnimationFrame(carouselAnimationFrameId);
        setTimeout(() => {
            scrollDirection = -1; // Change direction to left
            carouselAnimationFrameId = requestAnimationFrame(animateServicesCarousel);
        }, pauseAtEndDuration);
    } else if (scrollDirection === -1 && servicesCarouselContainer.scrollLeft <= 5) { // Reached beginning (with a small buffer)
        cancelAnimationFrame(carouselAnimationFrameId);
        setTimeout(() => {
            scrollDirection = 1; // Change direction to right
            carouselAnimationFrameId = requestAnimationFrame(animateServicesCarousel);
        }, pauseAtEndDuration);
    } else {
        carouselAnimationFrameId = requestAnimationFrame(animateServicesCarousel);
    }
}

// Start auto-scrolling when the page loads
window.addEventListener('load', () => {
    carouselAnimationFrameId = requestAnimationFrame(animateServicesCarousel);
});

// Pause scrolling on hover
servicesCarouselContainer.addEventListener('mouseover', () => {
    cancelAnimationFrame(carouselAnimationFrameId);
});

servicesCarouselContainer.addEventListener('mouseout', () => {
    carouselAnimationFrameId = requestAnimationFrame(animateServicesCarousel);
});

// Ensure charts redraw on window resize for optimal responsiveness
window.addEventListener('resize', () => {
    barChart.resize();
    pieChart.resize();
    lineChart.resize();
});

</script>
</body>
</html>

<br>
<br>
<?php
// PHP Backend Logic
// Establish database connection
$con = mysqli_connect("localhost", "root", "", "meditronix_new");

// Check connection
if (mysqli_connect_errno()) {
    // In a real production environment, you should log this error and show a user-friendly message,
    // not expose raw database errors.
    error_log("Failed to connect to MySQL: " . mysqli_connect_error());
    // For now, displaying it as per instruction.
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// FETCH DOCTORS DATA
// The query provided in the prompt was 'SELECT * FROM `doctors` WHERE 1WHERE 1' which has a redundant 'WHERE 1'.
// Correcting to 'SELECT * FROM `doctors`' to fetch all data as intended.
// Assuming a column 'doctor_image_url' exists for individual doctor images. If not, this will need to be added to your DB.
// Also, assuming 'doctor_image_url' and 'icon_class' might be present for custom images/icons.
$doctorsResult = mysqli_query($con, "SELECT `id`, `user_id`, `doctor_name`, `specialization`, `experience`, `availability`, `status`, `created_at` FROM `doctors`");

$doctorsData = [];
if ($doctorsResult) {
    while ($row = mysqli_fetch_assoc($doctorsResult)) {
        $doctorsData[] = $row;
    }
} else {
    error_log("Error fetching doctors data: " . mysqli_error($con));
    // Provide a default empty array if data fetching fails
    $doctorsData = [];
}

// Close the database connection
mysqli_close($con);
?>

<div class="container-wrapper">
    <style>
        /* This <style> block is placed directly in the div as per instruction, but traditionally belongs in <head> */

        /* Universal Box-sizing */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Body Background - Light changing multi-rainbow */
        body {
            background: linear-gradient(135deg,
                hsl(330, 100%, 95%), /* Light Pink */
                hsl(30, 100%, 95%),  /* Light Orange */
                hsl(60, 100%, 95%),  /* Light Yellow */
                hsl(120, 100%, 95%), /* Light Green */
                hsl(210, 100%, 95%), /* Light Blue */
                hsl(270, 100%, 95%)  /* Light Purple */
            );
            background-size: 400% 400%; /* For animating the gradient */
            animation: gradientBackground 30s ease infinite alternate; /* Added alternate for smoother loop */
            padding: 25px; /* Overall page padding */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            overflow-x: hidden; /* Prevent horizontal scroll from animations */
            position: relative; /* For pseudo-elements */
            filter: saturate(1.1); /* Slightly more vibrant colors */
        }

        @keyframes gradientBackground {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Subtle floating particles (wind effect) */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            background: radial-gradient(circle at 10% 20%, rgba(255,255,255,0.08) 1px, transparent 1px),
                        radial-gradient(circle at 70% 80%, rgba(255,255,255,0.08) 1px, transparent 1px);
            background-size: 35px 35px, 45px 45px; /* Slightly larger particles */
            animation: windEffect 90s linear infinite alternate; /* Slower, more subtle wind */
            z-index: -1;
            opacity: 0.7;
        }

        @keyframes windEffect {
            0% { background-position: 0% 0%, 50% 50%; }
            100% { background-position: 100% 100%, 0% 0%; }
        }

        /* Main Container for the entire content */
        .container-wrapper {
            width: 100%;
            max-width: 1400px; /* Increased max-width for more space from left/right */
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.98); /* Almost opaque white */
            border-radius: 35px; /* More rounded */
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2); /* Deeper shadow */
            padding: 50px; /* More internal padding */
            overflow: hidden;
            position: relative;
            z-index: 1;
            transform: translateZ(0); /* Force hardware acceleration */
            border: 1px solid rgba(0,0,0,0.05); /* Subtle border */
            backdrop-filter: blur(5px); /* Frosted glass effect */
        }

        /* Container Shining Effect (Water-filled/Glitter) on Click */
        .container-wrapper::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center,
                rgba(255, 255, 255, 0.4) 0%, /* Inner shine */
                rgba(255, 255, 255, 0.2) 20%, /* Outer shine */
                transparent 70% /* Fade out */
            );
            transform: rotate(45deg);
            opacity: 0;
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
            pointer-events: none;
            mix-blend-mode: screen; /* Brighter glitter effect */
            z-index: 2; /* Above content for the shine */
        }

        .container-wrapper.shining::after {
            opacity: 1;
            transform: rotate(45deg) scale(1.1);
            animation: shineEffect 0.8s forwards; /* Animation for single click */
        }

        @keyframes shineEffect {
            0% { opacity: 0.6; transform: rotate(45deg) scale(0.8); }
            50% { opacity: 1; transform: rotate(45deg) scale(1); }
            100% { opacity: 0; transform: rotate(45deg) scale(1.2); }
        }

        /* Long Message Top Section Styling */
        .top-message {
            text-align: center;
            margin-bottom: 70px;
            padding: 30px;
            background: linear-gradient(90deg, #f0f8ff, #e6f7ff); /* Light, subtle gradient */
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-left: 8px solid #007bff; /* Thicker border */
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        .top-message::before { /* Subtle wave effect */
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 123, 255, 0.05);
            clip-path: ellipse(60% 30% at 50% 0%);
            animation: waveMotion 10s infinite alternate;
            z-index: -1;
        }
        @keyframes waveMotion {
            0% { transform: translateY(0); }
            100% { transform: translateY(-10px); }
        }
        .top-message:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.18);
        }
        .top-message h2 {
            font-size: 3.2rem; /* Larger font */
            color: #2c3e50;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.08);
            letter-spacing: 1px;
        }
        .top-message p {
            font-size: 1.25rem; /* Larger text */
            color: #555;
            line-height: 1.8;
            max-width: 950px;
            margin: 0 auto;
        }

        /* Attractive Heading for Doctors Section Styling (water-filled/glitter effect) */
        .section-title {
            text-align: center;
            margin-bottom: 70px;
            position: relative;
            padding-bottom: 25px;
        }
        .section-title h1 {
            font-size: 5rem; /* Even larger font */
            font-weight: 800; /* Bolder */
            margin-bottom: 25px;
            background: linear-gradient(45deg, #007bff, #00c3ff, #e52e71, #ff8a00, #9b59b6, #2ecc71); /* More colors */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 4px 4px 12px rgba(0,0,0,0.2);
            letter-spacing: 3px;
            position: relative;
            display: inline-block;
            animation: textGlow 3s infinite alternate; /* Subtle text glow */
        }
        @keyframes textGlow {
            0% { text-shadow: 4px 4px 12px rgba(0,0,0,0.2), 0 0 5px rgba(0,123,255,0.3); }
            100% { text-shadow: 4px 4px 12px rgba(0,0,0,0.2), 0 0 15px rgba(0,195,255,0.6); }
        }
        .section-title h1::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            height: 7px; /* Thicker underline */
            background: linear-gradient(90deg, transparent, #00c3ff, #ff8a00, transparent);
            border-radius: 7px;
            animation: underlinePulse 2.5s infinite alternate;
        }
        @keyframes underlinePulse {
            0% { width: 80%; opacity: 0.8; }
            100% { width: 100%; opacity: 1; }
        }
        .section-title p {
            font-size: 1.4rem; /* Larger text */
            color: #666;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* Carousel Container and Track Styling */
        .doctor-carousel-container {
            overflow: hidden;
            position: relative;
            padding: 40px 0;
            margin-bottom: 90px;
            background: rgba(255, 255, 255, 0.85);
            border-radius: 25px;
            box-shadow: inset 0 0 25px rgba(0,0,0,0.1);
            border: 2px solid rgba(0,0,0,0.08);
            perspective: 1200px; /* Stronger 3D perspective */
        }
        .doctor-carousel-track {
            display: flex;
            gap: 40px; /* Increased spacing between cards */
            padding: 20px;
            animation: carouselScroll 40s linear infinite; /* Faster speed */
            will-change: transform;
            /* Duplicate content for seamless infinite scroll */
            width: fit-content; /* Allow track to expand */
        }
        @keyframes carouselScroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-50% - 20px)); /* Adjust for actual content width for seamless loop */ }
        }

        /* Doctor Card Styling (Looks like News Cards) */
        .doctor-card {
            min-width: 380px; /* Larger cards */
            background: #fff;
            padding: 35px;
            border-radius: 30px; /* More rounded */
            box-shadow: 0 15px 45px rgba(0,0,0,0.18); /* Deeper shadow */
            transition: all .6s cubic-bezier(0.25, 0.8, 0.25, 1); /* Smoother elastic transition */
            border: 2px solid rgba(0,0,0,0.1); /* More visible border */
            position: relative;
            overflow: hidden;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transform-style: preserve-3d;
            transform: rotateY(0deg) scale(1);
            cursor: pointer; /* Indicate interactivity */
        }
        .doctor-card::before { /* Border highlight on hover */
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            background: linear-gradient(45deg, #007bff, #00c3ff, #e52e71, #ff8a00, #9b59b6);
            z-index: -1;
            filter: blur(15px); /* More blur */
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            border-radius: 35px;
        }
        .doctor-card:hover::before {
            opacity: 0.9;
        }
        .doctor-card:hover {
            transform: translateY(-20px) scale(1.05) rotateY(8deg); /* More pronounced lift, scale, and 3D rotate */
            box-shadow: 0 25px 60px rgba(0,0,0,0.25);
            border-color: #007bff;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef); /* Subtle background change on hover */
        }
        .doctor-card::after { /* Water-filled glitter effect on active */
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: radial-gradient(circle at center, rgba(255,255,255,0.7) 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0;
            transform: translate(-50%, -50%);
            transition: width 0.5s ease, height 0.5s ease, opacity 0.5s ease;
            mix-blend-mode: screen;
            z-index: 2;
        }
        .doctor-card.active-shine::after {
            width: 300%;
            height: 300%;
            opacity: 1;
        }

        /* Doctor Image (Background) */
        .doctor-image-bg {
            width: 100%;
            height: 200px; /* Taller height for images */
            background-size: cover;
            background-position: center;
            border-radius: 25px;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
            border: 3px solid rgba(0,0,0,0.1);
            box-shadow: inset 0 0 15px rgba(0,0,0,0.15);
            transition: transform 0.5s ease;
        }
        .doctor-card:hover .doctor-image-bg {
            transform: scale(1.08); /* More zoom on image hover */
        }
        .doctor-image-bg::before { /* Subtle overlay */
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
            border-radius: 25px;
        }

        .doctor-card h3 {
            font-size: 2.5rem; /* Even larger name */
            margin-bottom: 15px;
            color: #2c3e50;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.05);
        }
        .doctor-card p {
            font-size: 1.15rem;
            color: #555;
            margin-bottom: 10px;
            line-height: 1.7;
        }
        .doctor-card p strong {
            color: #333;
            font-weight: 600;
        }
        .doctor-card .icon {
            font-size: 4.5rem; /* Larger icon */
            color: #007bff; /* Primary color for icon */
            margin-bottom: 25px;
            transition: transform 0.5s ease, color 0.5s ease, text-shadow 0.5s ease;
            text-shadow: 3px 3px 8px rgba(0,0,0,0.15);
            animation: iconPulse 2s infinite alternate; /* Subtle icon pulse */
        }
        @keyframes iconPulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.05); }
        }
        .doctor-card:hover .icon {
            transform: rotate(15deg) scale(1.2);
            color: #e52e71; /* Change color on hover */
            text-shadow: 0 0 15px rgba(229,46,113,0.7);
        }

        /* Form Section Styling */
        .form-section {
            margin-top: 90px;
            padding: 70px;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 35px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.18);
            position: relative;
            overflow: hidden;
            transition: all .4s ease-in-out;
            border: 1px solid rgba(0,0,0,0.08);
            backdrop-filter: blur(3px);
        }
        .form-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(circle, #f0f0f0 1.5px, transparent 1.5px); /* Denser pattern */
            background-size: 25px 25px;
            opacity: 0.3;
            z-index: -1;
        }
        .form-section h2 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 3.5rem;
            color: #2c3e50;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.08);
            letter-spacing: 0.5px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 30px; /* Increased gap */
            max-width: 750px; /* Wider form */
            margin: 0 auto;
        }
        form input, form textarea, form select {
            padding: 18px; /* More padding */
            border: 2px solid #ddd; /* Thicker border */
            border-radius: 15px; /* More rounded */
            font-size: 1.2rem;
            box-shadow: inset 0 3px 8px rgba(0,0,0,0.08);
            transition: border-color 0.4s ease, box-shadow 0.4s ease, background-color 0.4s ease;
            background-color: rgba(255, 255, 255, 0.7); /* Slightly visible background */
            color: #333;
        }
        form input::placeholder, form textarea::placeholder {
            color: rgba(0,0,0,0.5);
        }
        form input:focus, form textarea:focus, form select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 5px rgba(0, 123, 255, 0.3);
            background-color: #fff;
            outline: none;
        }
        form textarea {
            min-height: 180px; /* Taller textarea */
            resize: vertical;
        }
        .btn-submit {
            padding: 18px;
            background: linear-gradient(135deg, #007bff, #00c3ff);
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1.4rem;
            color: #fff;
            transition: all .4s ease;
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
            position: relative;
            overflow: hidden;
            z-index: 1;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .btn-submit::before { /* Water-filled effect */
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.3);
            transition: all 0.5s ease-in-out;
            z-index: -1;
        }
        .btn-submit:hover::before {
            left: 0;
        }
        .btn-submit::after { /* Glitter effect */
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.9) 10%, transparent 10.01%);
            background-size: 25px 25px;
            opacity: 0;
            transition: opacity 0.6s ease;
            z-index: -1;
            mix-blend-mode: screen;
        }
        .btn-submit:hover::after {
            opacity: 1;
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, #0056b3, #007bff);
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 123, 255, 0.4);
        }

        /* Contact Section Styling */
        .contact-section {
            margin-top: 90px;
            padding: 70px;
            background: url('https://cdn.pixabay.com/photo/2024/11/15/12/31/ai-generated-9199437_1280.jpg') no-repeat center/cover;
            border-radius: 35px;
            color: #fff;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0,0,0,0.25);
            backdrop-filter: blur(2px);
        }
        .contact-section::before { /* Darker overlay */
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 0;
            border-radius: 35px;
        }
        .contact-section > * {
            position: relative;
            z-index: 1;
        }
        .contact-section h2 {
            font-size: 4rem;
            margin-bottom: 25px;
            letter-spacing: 1.5px;
            text-shadow: 3px 3px 8px rgba(0,0,0,0.7);
        }
        .contact-section p {
            font-size: 1.4rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.6);
            line-height: 1.6;
        }
        .social-icons {
            margin-top: 50px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 25px; /* More space between icons */
        }
        .social-icons a {
            color: #fff;
            font-size: 45px; /* Even larger icons */
            transition: transform .5s ease, color .5s ease, text-shadow .5s ease;
            display: inline-flex; /* Use flex for centering icon */
            align-items: center;
            justify-content: center;
            text-shadow: 3px 3px 8px rgba(0,0,0,0.5);
            position: relative;
            overflow: hidden;
            border-radius: 50%;
            width: 70px; /* Make them round buttons */
            height: 70px;
            background: rgba(255,255,255,0.15);
            border: 2px solid rgba(255,255,255,0.2);
            box-shadow: 0 0 15px rgba(255,255,255,0.1);
        }
        .social-icons a::before { /* Water fill effect for social icons */
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.3);
            transform: scaleY(0);
            transform-origin: bottom;
            transition: transform 0.4s ease;
            z-index: -1;
            border-radius: 50%;
        }
        .social-icons a:hover::before {
            transform: scaleY(1);
        }
        .social-icons a:hover {
            transform: scale(1.2) rotate(15deg);
            color: #ffeb3b; /* Brighter yellow on hover */
            text-shadow: 0 0 25px rgba(255,235,59,1);
            box-shadow: 0 0 30px rgba(255,235,59,0.6);
            border-color: rgba(255,255,255,0.5);
        }

        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .container-wrapper {
                padding: 40px;
                max-width: 1100px; /* Adjusted for smaller screens */
            }
            .top-message h2 {
                font-size: 2.8rem;
            }
            .section-title h1 {
                font-size: 4rem;
            }
            .doctor-card {
                min-width: 350px;
                padding: 30px;
            }
            .form-section, .contact-section {
                padding: 60px;
            }
            .form-section h2, .contact-section h2 {
                font-size: 3rem;
            }
            .social-icons a {
                font-size: 40px;
                width: 60px;
                height: 60px;
                line-height: 60px;
            }
        }

        @media (max-width: 992px) {
            .container-wrapper {
                padding: 30px;
                max-width: 90%;
            }
            .top-message {
                margin-bottom: 50px;
            }
            .top-message h2 {
                font-size: 2.2rem;
            }
            .top-message p {
                font-size: 1.1rem;
            }
            .section-title {
                margin-bottom: 50px;
            }
            .section-title h1 {
                font-size: 3.5rem;
            }
            .section-title p {
                font-size: 1.2rem;
            }
            .doctor-carousel-track {
                animation: none; /* Disable animation on smaller screens */
                flex-wrap: wrap;
                justify-content: center;
                gap: 30px;
            }
            .doctor-card {
                min-width: 90%; /* Take more width on small screens */
                margin-bottom: 20px;
                transform: none !important; /* Override hover transform for better mobile experience */
            }
            .doctor-card:hover {
                transform: none !important;
                box-shadow: 0 15px 45px rgba(0,0,0,0.18); /* Keep base shadow */
            }
            .doctor-card::before {
                opacity: 0; /* Disable hover highlight on touch devices */
            }
            .form-section, .contact-section {
                padding: 50px;
            }
            .form-section h2, .contact-section h2 {
                font-size: 2.8rem;
            }
            form input, form textarea, form select {
                padding: 15px;
                font-size: 1.1rem;
            }
            .btn-submit {
                padding: 15px;
                font-size: 1.2rem;
            }
            .social-icons a {
                font-size: 35px;
                margin: 0 12px;
                width: 55px;
                height: 55px;
                line-height: 55px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            .container-wrapper {
                padding: 20px;
                border-radius: 25px;
            }
            .top-message {
                padding: 20px;
                margin-bottom: 40px;
            }
            .top-message h2 {
                font-size: 1.8rem;
            }
            .top-message p {
                font-size: 1rem;
            }
            .section-title h1 {
                font-size: 2.8rem;
            }
            .section-title p {
                font-size: 1rem;
            }
            .doctor-card {
                padding: 25px;
                border-radius: 20px;
            }
            .doctor-image-bg {
                height: 160px;
                border-radius: 20px;
            }
            .doctor-card h3 {
                font-size: 2rem;
            }
            .doctor-card p {
                font-size: 0.95rem;
            }
            .doctor-card .icon {
                font-size: 3.5rem;
            }
            .form-section, .contact-section {
                padding: 40px;
                border-radius: 25px;
            }
            .form-section h2, .contact-section h2 {
                font-size: 2.2rem;
            }
            form {
                gap: 18px;
            }
            form input, form textarea, form select {
                padding: 12px;
                font-size: 1rem;
            }
            .btn-submit {
                padding: 12px;
                font-size: 1.1rem;
            }
            .social-icons a {
                font-size: 30px;
                margin: 0 10px;
                width: 50px;
                height: 50px;
                line-height: 50px;
            }
        }

        @media (max-width: 576px) {
            .container-wrapper {
                padding: 15px;
                border-radius: 20px;
            }
            .top-message {
                padding: 15px;
                margin-bottom: 30px;
            }
            .top-message h2 {
                font-size: 1.4rem;
            }
            .top-message p {
                font-size: 0.9rem;
            }
            .section-title {
                margin-bottom: 30px;
                padding-bottom: 15px;
            }
            .section-title h1 {
                font-size: 2.2rem;
                margin-bottom: 15px;
            }
            .section-title p {
                font-size: 0.9rem;
            }
            .doctor-carousel-container {
                padding: 20px 0;
                margin-bottom: 60px;
                border-radius: 20px;
            }
            .doctor-carousel-track {
                padding: 10px;
                gap: 20px;
            }
            .doctor-card {
                min-width: 100%;
                padding: 20px;
            }
            .doctor-image-bg {
                height: 140px;
            }
            .doctor-card h3 {
                font-size: 1.6rem;
            }
            .doctor-card p {
                font-size: 0.9rem;
            }
            .doctor-card .icon {
                font-size: 3rem;
            }
            .form-section, .contact-section {
                padding: 30px;
                border-radius: 20px;
            }
            .form-section h2, .contact-section h2 {
                font-size: 1.8rem;
            }
            form {
                gap: 15px;
            }
            form input, form textarea, form select {
                padding: 10px;
                font-size: 0.9rem;
            }
            .btn-submit {
                padding: 10px;
                font-size: 1rem;
            }
            .social-icons {
                gap: 15px;
            }
            .social-icons a {
                font-size: 26px;
                margin: 0 8px;
                width: 45px;
                height: 45px;
                line-height: 45px;
            }
        }
    </style>

    <div class="top-message">
        <h2>Your Journey to Wellness Begins Here</h2>
        <p>At Meditronix, we connect you with highly experienced and dedicated medical professionals. Discover personalized care, innovative solutions, and a compassionate approach to your health needs. We are committed to ensuring your comfort and recovery with minimal discomfort.</p>
    </div>

    <div class="section-title">
        <h1>Our Expert Doctors</h1>
        <p>Meet our team of specialists dedicated to providing you with the best quality services and comprehensive care.</p>
    </div>

    <div class="doctor-carousel-container">
        <div class="doctor-carousel-track">
            <?php if (!empty($doctorsData)): ?>
                <?php foreach ($doctorsData as $doctor): ?>
                    <div class="doctor-card">
                        <div class="doctor-image-bg" style="background-image: url('https://placehold.co/400x300/ADD8E6/FFFFFF?text=Dr.+<?php echo urlencode($doctor['doctor_name']); ?>');">
                            <!-- Placeholder image. If you have a 'doctor_image_url' column in your 'doctors' table,
                                 replace the 'placehold.co' URL with '<?php // echo htmlspecialchars($doctor['doctor_image_url']); ?>' -->
                        </div>
                        <?php
                            // Assign an icon based on specialization (illustrative)
                            $iconClass = 'fas fa-user-md'; // Default icon
                            switch (strtolower($doctor['specialization'])) {
                                case 'pediatrics':
                                    $iconClass = 'fas fa-baby'; break;
                                case 'oncology':
                                    $iconClass = 'fas fa-dna'; break;
                                case 'dermatology':
                                    $iconClass = 'fas fa-hand-sparkles'; break;
                                case 'neurology':
                                    $iconClass = 'fas fa-brain'; break;
                                case 'gynecologist':
                                    $iconClass = 'fas fa-venus'; break;
                                case 'surgeon':
                                    $iconClass = 'fas fa-cut'; break;
                                case 'physiotherapy':
                                    $iconClass = 'fas fa-walking'; break;
                                case 'physical health':
                                    $iconClass = 'fas fa-heartbeat'; break;
                                case 'treatments':
                                    $iconClass = 'fas fa-hand-holding-medical'; break;
                                case 'dentist':
                                    $iconClass = 'fas fa-tooth'; break;
                                case 'cardiologist':
                                    $iconClass = 'fas fa-heart'; break;
                                // Add more cases for other specializations and their respective Font Awesome icons
                            }
                        ?>
                        <i class="icon <?php echo $iconClass; ?>"></i>
                        <h3><?php echo htmlspecialchars($doctor['doctor_name']); ?></h3>
                        <p><strong>Specialization:</strong> <?php echo htmlspecialchars($doctor['specialization']); ?></p>
                        <p><strong>Experience:</strong> <?php echo htmlspecialchars($doctor['experience']); ?> Years</p>
                        <p><strong>Availability:</strong> <?php echo htmlspecialchars($doctor['availability']); ?></p>
                        <p><strong>Status:</strong> <?php echo htmlspecialchars($doctor['status']); ?></p>
                        <p><strong>Joined:</strong> <?php echo htmlspecialchars(date('M d, Y', strtotime($doctor['created_at']))); ?></p>
                        <!-- Social links for individual doctors (if you add them to DB, e.g., doctor_facebook_url) -->
                        <!-- <div class="doctor-social-links">
                            <a href="<?php // echo htmlspecialchars($doctor['doctor_facebook_url']); ?>" target="_blank" aria-label="Doctor Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="<?php // echo htmlspecialchars($doctor['doctor_twitter_url']); ?>" target="_blank" aria-label="Doctor Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="<?php // echo htmlspecialchars($doctor['doctor_linkedin_url']); ?>" target="_blank" aria-label="Doctor LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        </div> -->
                    </div>
                <?php endforeach; ?>
                <?php
                // Duplicate cards for seamless infinite scroll effect
                // This is a common technique for pure CSS carousels to avoid jumpiness at the end
                foreach ($doctorsData as $doctor): ?>
                    <div class="doctor-card">
                        <div class="doctor-image-bg" style="background-image: url('https://placehold.co/400x300/ADD8E6/FFFFFF?text=Dr.+<?php echo urlencode($doctor['doctor_name']); ?>');"></div>
                        <?php
                            $iconClass = 'fas fa-user-md';
                            switch (strtolower($doctor['specialization'])) {
                                case 'pediatrics': $iconClass = 'fas fa-baby'; break;
                                case 'oncology': $iconClass = 'fas fa-dna'; break;
                                case 'dermatology': $iconClass = 'fas fa-hand-sparkles'; break;
                                case 'neurology': $iconClass = 'fas fa-brain'; break;
                                case 'gynecologist': $iconClass = 'fas fa-venus'; break;
                                case 'surgeon': $iconClass = 'fas fa-cut'; break;
                                case 'physiotherapy': $iconClass = 'fas fa-walking'; break;
                                case 'physical health':
                                    $iconClass = 'fas fa-heartbeat'; break;
                                case 'treatments':
                                    $iconClass = 'fas fa-hand-holding-medical'; break;
                                case 'dentist':
                                    $iconClass = 'fas fa-tooth'; break;
                                case 'cardiologist':
                                    $iconClass = 'fas fa-heart'; break;
                            }
                        ?>
                        <i class="icon <?php echo $iconClass; ?>"></i>
                        <h3><?php echo htmlspecialchars($doctor['doctor_name']); ?></h3>
                        <p><strong>Specialization:</strong> <?php echo htmlspecialchars($doctor['specialization']); ?></p>
                        <p><strong>Experience:</strong> <?php echo htmlspecialchars($doctor['experience']); ?> Years</p>
                        <p><strong>Availability:</strong> <?php echo htmlspecialchars($doctor['availability']); ?></p>
                        <p><strong>Status:</strong> <?php echo htmlspecialchars($doctor['status']); ?></p>
                        <p><strong>Joined:</strong> <?php echo htmlspecialchars(date('M d, Y', strtotime($doctor['created_at']))); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="doctor-card" style="min-width: 100%; text-align: center;">
                    <h3>No Doctors Found</h3>
                    <p>Currently, no doctor profiles are available. Please check back later.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>



    <div class="contact-section">
        <h2>Connect With Us</h2>
        <p>Have questions or need assistance? Reach out to us through our various channels.</p>
        <p>Email: contact@meditronix.com</p>
        <p>Phone: +91-9876543210</p>
        <div class="social-icons">
            <a href="https://www.facebook.com/MeditronixOfficial" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.instagram.com/Meditronix_Official" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="https://www.twitter.com/Meditronix_Official" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="https://www.linkedin.com/company/Meditronix_Official" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            <a href="https://www.youtube.com/Meditronix" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
    </div>

    <!-- Modal Video (from your reference code, ensure necessary Bootstrap JS is loaded externally) -->
    <!-- This modal requires Bootstrap's JavaScript to function correctly for toggling and video playback control.
         You would typically include Bootstrap's JS bundle at the end of your <body> tag. -->

    <!-- JavaScript for interactivity (custom effects) -->
    <!-- REMINDER: Font Awesome CDN link should ideally be in <head> or at the end of <body>.
                 This is placed here as per your "inside div only" instruction. -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        // Ensure DOM is fully loaded before running scripts
        document.addEventListener('DOMContentLoaded', function() {
            // Container shining effect on click
            const containerWrapper = document.querySelector('.container-wrapper');
            if (containerWrapper) {
                containerWrapper.addEventListener('click', function() {
                    this.classList.add('shining');
                    setTimeout(() => {
                        this.classList.remove('shining');
                    }, 800); // Match animation duration
                });
            }

            // Doctor card shining effect on click
            document.querySelectorAll('.doctor-card').forEach(card => {
                card.addEventListener('click', function() {
                    this.classList.add('active-shine');
                    setTimeout(() => {
                        this.classList.remove('active-shine');
                    }, 500); // Shorter duration for card shine
                });
            });

            // Handle video modal (requires Bootstrap JS to be loaded externally)
            const videoModal = document.getElementById('videoModal');
            if (videoModal) {
                videoModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget; // Button that triggered the modal
                    const videoSrc = button.getAttribute('data-src'); // Extract info from data-src attribute
                    const iframe = this.querySelector('#video');
                    iframe.src = videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0"; // Autoplay video
                });

                videoModal.addEventListener('hide.bs.modal', function () {
                    const iframe = this.querySelector('#video');
                    iframe.src = ""; // Stop video playback when modal is closed
                });
            }
        });
    </script>
</div>


    <div>

    <br>
    <br>
    <br>
    <br>
    <br>
    <?php
// PHP Section
// Database connection
// Ensure your database server is running and 'meditronix_new' database exists with a 'news' table.
$db = mysqli_connect("localhost", "root", "", "meditronix_new");

// Check connection
if (!$db) {
    // Display a user-friendly error message if connection fails
    die("<div class='db-error-message'>
            <i class='fas fa-exclamation-triangle'></i> Database Connection Failed! <br>
            Please ensure your MySQL server is running and database credentials are correct.
            <br><small>" . mysqli_connect_error() . "</small>
         </div>");
}

// Fetch news data
// Selecting specific columns for security and performance
$news_query = mysqli_query($db, "SELECT id, title, content, status, created_at FROM news ORDER BY created_at DESC");

// Check if query was successful
if (!$news_query) {
    // Display a user-friendly error message if query fails
    die("<div class='db-error-message'>
            <i class='fas fa-exclamation-circle'></i> Error Fetching News Data! <br>
            There was an issue retrieving news articles. Please try again later.
            <br><small>" . mysqli_error($db) . "</small>
         </div>");
}

// Store news articles in an array for easier processing
$news_articles = [];
while ($row = mysqli_fetch_assoc($news_query)) {
    $news_articles[] = $row;
}

// Close database connection
mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cutting-Edge Medical News & Insights - Meditronix</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        /* CSS Variables for easy theme management and consistency */
        :root {
            --primary-color: #007bff; /* Meditronix Blue */
            --primary-dark: #0056b3;
            --secondary-color: #6c757d; /* Grey for secondary text */
            --dark-color: #212529; /* Dark text/background */
            --light-bg: #f8f9fa; /* Light background */
            --white-color: #ffffff;
            --card-bg: #ffffff;
            --border-radius-sm: 0.75rem;
            --border-radius-md: 1.5rem;
            --border-radius-lg: 2.5rem;
            --box-shadow-light: 0 4px 20px rgba(0,0,0,0.05);
            --box-shadow-medium: 0 8px 30px rgba(0,0,0,0.1);
            --box-shadow-heavy: 0 12px 40px rgba(0,0,0,0.15);
            --transition-duration: 0.5s;
            --transition-timing-function: ease-in-out;
            --popup-bg-gradient: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%); /* Blue gradient for popup */

            /* More vibrant, yet light rainbow colors */
            --rainbow-color1: #ffb6c1; /* Light Pink */
            --rainbow-color2: #ffe0b2; /* Light Orange */
            --rainbow-color3: #fffacd; /* Light Yellow */
            --rainbow-color4: #b2f0c8; /* Light Green */
            --rainbow-color5: #b0e0e6; /* Light Blue */
            --rainbow-color6: #d8bfd8; /* Light Purple */
            --rainbow-color7: #e0b0ff; /* Light Lavender */
        }

        /* Base Styles & Typography */
        html {
            scroll-behavior: smooth; /* Smooth scrolling for anchor links */
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--dark-color);
            line-height: 1.6;
            /* Enhanced Multi-Light Rainbow Background */
            background: linear-gradient(135deg,
                var(--rainbow-color1) 0%,
                var(--rainbow-color2) 15%,
                var(--rainbow-color3) 30%,
                var(--rainbow-color4) 45%,
                var(--rainbow-color5) 60%,
                var(--rainbow-color6) 75%,
                var(--rainbow-color7) 90%,
                var(--rainbow-color1) 100%
            );
            background-size: 800% 800%; /* Larger size for smoother, more spread-out animation */
            animation: gradientBackground 20s ease infinite alternate; /* Slower, continuous rainbow shift */
            overflow-x: hidden; /* Prevent horizontal scrollbar from animations */
        }

        /* Keyframe for the subtle rainbow background animation */
        @keyframes gradientBackground {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            margin-top: 0;
            margin-bottom: 0.5rem;
            line-height: 1.2;
            font-weight: 700;
        }

        p {
            margin-bottom: 1rem;
        }

        /* Utility Classes */
        .text-primary { color: var(--primary-color) !important; }
        .text-secondary { color: var(--secondary-color) !important; }
        .text-dark { color: var(--dark-color) !important; }
        .fw-bold { font-weight: 700 !important; }
        .text-uppercase { text-transform: uppercase !important; }
        .display-5 { font-size: 2.5rem; }
        .lead { font-size: 1.25rem; font-weight: 300; }
        .small { font-size: 0.875em; }
        .mb-5 { margin-bottom: 3rem !important; }
        .py-5 { padding-top: 3rem !important; padding-bottom: 3rem !important; }
        .text-center { text-align: center !important; }

        /* Database Error Message Styling */
        .db-error-message {
            background-color: #ffe0e0;
            border-left: 8px solid #ff4d4d;
            margin: 2rem auto;
            padding: 20px 30px;
            color: #cc0000;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            border-radius: var(--border-radius-md);
            box-shadow: var(--box-shadow-light);
            max-width: 700px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .db-error-message i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ff4d4d;
        }
        .db-error-message small {
            margin-top: 1rem;
            font-size: 0.8rem;
            color: #990000;
        }

        /* Page Container - Max width and centering */
        .page-container {
            width: 100%;
            max-width: 1920px; /* Ensures content doesn't stretch too wide on large screens */
            margin: 0 auto;
            padding: 0 20px; /* Padding on sides for smaller screens */
            box-sizing: border-box;
        }

        /* Main Header Section */
        .main-header {
            background: rgba(255, 255, 255, 0.95); /* Slightly transparent white background */
            padding: 5rem 3rem;
            margin-bottom: 4rem;
            border-bottom-left-radius: var(--border-radius-lg);
            border-bottom-right-radius: var(--border-radius-lg);
            box-shadow: var(--box-shadow-medium);
            text-align: center;
            position: relative;
            z-index: 10;
            overflow: hidden; /* For header water effect */
            backdrop-filter: blur(5px); /* Subtle blur effect */
            animation: headerEntrance 1.5s cubic-bezier(0.23, 1, 0.32, 1) forwards; /* Entrance animation */
            transform: translateY(-50px);
            opacity: 0;
        }

        @keyframes headerEntrance {
            to { transform: translateY(0); opacity: 1; }
        }

        /* Water ripple effect for the header background */
        .main-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(0, 123, 255, 0.15) 0%, rgba(0, 123, 255, 0) 70%);
            animation: headerWaterFlow 20s infinite linear;
            opacity: 0.8;
            pointer-events: none;
            z-index: -1; /* Behind content */
        }

        @keyframes headerWaterFlow {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(50%, 50%) scale(1.1); }
            100% { transform: translate(0, 0) scale(1); }
        }

        .main-header p {
            font-size: 1.6rem;
            max-width: 1000px;
            margin: 0 auto 2.5rem auto;
            color: var(--dark-color);
            opacity: 0.9;
            font-weight: 300;
            line-height: 1.8;
            animation: textFadeIn 2s ease-out 0.5s forwards; /* Delayed fade-in for text */
            opacity: 0;
        }

        @keyframes textFadeIn {
            to { opacity: 0.9; }
        }

        .main-header h1 {
            font-size: 4.5rem; /* Larger, more professional heading */
            color: var(--primary-color);
            text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.15);
            position: relative;
            display: inline-block;
            margin-bottom: 0;
            overflow: hidden;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(45deg, #007bff, #00c6ff, #007bff);
            background-size: 200% 100%;
            animation: textFill 5s infinite alternate, headingEntrance 1.8s cubic-bezier(0.23, 1, 0.32, 1) 0.8s forwards; /* Animated text fill + entrance */
            font-weight: 800;
            opacity: 0;
            transform: scale(0.8);
        }

        @keyframes textFill {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }

        @keyframes headingEntrance {
            to { opacity: 1; transform: scale(1); }
        }

        /* Slider Wrapper - Contains carousel and navigation */
        .slider-wrapper {
            position: relative;
            padding: 3rem 0;
            margin: 0 40px; /* Extended width from sides */
            animation: fadeIn 1.5s ease-out 1s forwards; /* Delayed fade-in */
            opacity: 0;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }

        /* Slider Container - The visible window for the carousel */
        .slider-container {
            width: calc(100% - 80px); /* Adjusting for wrapper margin */
            margin: 0 auto;
            overflow-x: hidden; /* Hide default scrollbar */
            overflow-y: hidden;
            position: relative;
            padding-bottom: 25px; /* Space for custom scrollbar */
            border-radius: var(--border-radius-lg);
            box-shadow: inset 0 0 20px rgba(0,0,0,0.05), 0 15px 40px rgba(0,0,0,0.1); /* Inner and outer shadow for depth */
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent background for slider */
            backdrop-filter: blur(3px);
        }

        /* Custom Scrollbar Styling */
        .slider-container::-webkit-scrollbar {
            height: 12px;
        }

        .slider-container::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1); /* Darker track for contrast */
            border-radius: 10px;
            box-shadow: inset 0 0 5px rgba(0,0,0,0.1);
        }

        .slider-container::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, var(--primary-color), #00c6ff);
            border-radius: 10px;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .slider-container::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, var(--primary-dark), #00aaff);
            transform: scaleY(1.1);
        }

        /* Slider Track - The moving part of the carousel */
        .slider-track {
            display: flex;
            transition: transform var(--transition-duration) var(--transition-timing-function);
            padding: 15px 0; /* Padding for cards to prevent clipping by scrollbar */
            will-change: transform; /* Optimize for animation */
        }

        /* Individual Slider Card */
        .slider-card {
            min-width: 480px; /* Larger card width */
            max-width: 480px;
            margin: 0 30px; /* More spacing between cards */
            background: var(--card-bg);
            border-radius: var(--border-radius-lg); /* More rounded corners */
            padding: 3rem; /* Increased padding */
            text-align: center;
            box-shadow: var(--box-shadow-light);
            cursor: pointer;
            transition: transform 0.4s ease, box-shadow 0.4s ease, background-color 0.4s ease;
            position: relative;
            overflow: hidden; /* For shining effect */
            flex-shrink: 0; /* Prevent cards from shrinking */
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Distribute content vertically */
            align-items: center;
            border: 1px solid rgba(0, 0, 0, 0.05); /* Subtle border */
        }

        /* Hover effect for cards */
        .slider-card:hover {
            transform: translateY(-15px) scale(1.02); /* More pronounced lift and slight scale */
            box-shadow: var(--box-shadow-heavy);
            background: linear-gradient(135deg, #f0f8ff, #e0f2ff); /* Subtle light blue gradient on hover */
        }

        /* Crystal Water Shine Effect on Click */
        .slider-card::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: radial-gradient(circle at center, rgba(0, 123, 255, 0.5) 0%, rgba(0, 123, 255, 0) 70%);
            transform: translate(-50%, -50%);
            border-radius: 50%;
            opacity: 0;
            pointer-events: none;
            z-index: 1;
            transition: width 0s, height 0s, opacity 0s; /* Reset on non-active state */
        }

        .slider-card.shine::before {
            animation: crystalShine 1s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards; /* Smoother animation */
            width: 250%; /* Larger shine area */
            height: 250%;
            opacity: 1;
        }

        @keyframes crystalShine {
            0% { width: 0; height: 0; opacity: 0.8; }
            50% { opacity: 0.4; }
            100% { opacity: 0; width: 250%; height: 250%; } /* Ensure it fades out at full size */
        }

        /* Icon Container within cards */
        .slider-card .icon-container {
            width: 110px; /* Even larger icon container */
            height: 110px;
            background: linear-gradient(45deg, var(--primary-color), #00c6ff); /* Gradient background for icon */
            color: var(--white-color);
            border-radius: 50%;
            font-size: 4rem; /* Larger icon size */
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem auto; /* More spacing */
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.4);
            transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275), background 0.5s ease; /* Bouncy transform */
            position: relative;
            z-index: 2; /* Ensure icon is above shine effect */
            overflow: hidden; /* For inner glitter effect */
        }

        /* Inner glitter effect for icon container */
        .slider-card .icon-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 30%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transform: skewX(-20deg);
            transition: transform 0.3s ease;
            opacity: 0;
        }

        .slider-card:hover .icon-container {
            transform: rotateY(360deg) scale(1.15); /* More pronounced 3D rotation and scale */
            background: linear-gradient(45deg, #0056b3, #00aaff); /* Darker gradient on hover */
        }

        .slider-card:hover .icon-container::after {
            animation: iconGlitter 1.5s infinite linear; /* Continuous glitter on hover */
            opacity: 1;
        }

        @keyframes iconGlitter {
            0% { transform: translateX(-100%) skewX(-20deg); opacity: 0; }
            20% { opacity: 1; }
            80% { opacity: 1; }
            100% { transform: translateX(200%) skewX(-20deg); opacity: 0; }
        }

        .slider-card h5 {
            font-size: 2rem; /* Larger heading in card */
            margin-bottom: 1.2rem;
            color: var(--dark-color);
            font-weight: 700;
            line-height: 1.3;
        }

        .slider-card p {
            font-size: 1.15rem; /* Slightly larger paragraph text */
            margin-bottom: 1.5rem;
            color: var(--secondary-color);
            flex-grow: 1; /* Allows content to take available space */
        }

        .slider-card p.small {
            color: #888;
            font-size: 0.95rem;
            font-weight: 300;
        }

        /* Navigation Arrows for Carousel */
        .slider-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            pointer-events: none; /* Allows clicks to pass through to cards */
            z-index: 5;
            padding: 0 20px; /* Ensures buttons are within page boundaries */
            box-sizing: border-box;
        }

        .slider-nav button {
            background-color: var(--primary-color);
            color: var(--white-color);
            border: none;
            border-radius: 50%;
            width: 65px; /* Larger buttons */
            height: 65px;
            font-size: 2.2rem; /* Larger icons */
            cursor: pointer;
            outline: none;
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.5);
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            pointer-events: auto; /* Enable clicks on buttons */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slider-nav button:hover {
            background-color: var(--primary-dark);
            transform: scale(1.15); /* More pronounced scale on hover */
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.7);
        }

        .slider-nav button:first-child {
            margin-left: -35px; /* Overlap with container edge for visual appeal */
        }

        .slider-nav button:last-child {
            margin-right: -35px; /* Overlap with container edge */
        }

        /* Slider Dots for Navigation */
        .slider-dots {
            text-align: center;
            margin-top: 2rem;
            position: relative;
            z-index: 10;
        }

        .slider-dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            background-color: rgba(0, 123, 255, 0.3);
            border-radius: 50%;
            margin: 0 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            border: 2px solid transparent;
        }

        .slider-dot.active {
            background-color: var(--primary-color);
            transform: scale(1.2);
            border-color: var(--primary-color);
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        }

        .slider-dot:hover {
            background-color: rgba(0, 123, 255, 0.6);
            transform: scale(1.1);
        }

        /* Popup Message */
        #popup-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            background: var(--popup-bg-gradient);
            color: var(--white-color);
            padding: 40px 60px;
            border-radius: var(--border-radius-lg);
            font-size: 2.5rem; /* Larger font for impact */
            font-weight: bold;
            opacity: 0;
            z-index: 10000;
            box-shadow: 0 0 50px rgba(0, 123, 255, 0.8); /* More prominent shadow */
            transition: transform 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55), opacity 0.8s ease-in-out; /* Bouncy transition */
            text-shadow: 3px 3px 8px rgba(0,0,0,0.3);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 1rem;
        }

        #popup-message i {
            font-size: 3.5rem;
            color: rgba(255, 255, 255, 0.9);
        }

        /* Glitter effect for popup */
        #popup-message::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 30%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transform: skewX(-20deg);
            animation: popupGlitter 2s infinite linear;
            opacity: 0;
            z-index: -1;
        }

        #popup-message.show::before {
            opacity: 1;
        }

        @keyframes popupGlitter {
            0% { transform: translateX(-100%) skewX(-20deg); }
            100% { transform: translateX(200%) skewX(-20deg); }
        }

        #popup-message.show {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }

        /* Footer with Social Links */
        .footer {
            background-color: var(--dark-color);
            color: var(--white-color);
            padding: 3.5rem 0;
            text-align: center;
            margin-top: 6rem;
            box-shadow: 0 -8px 30px rgba(0,0,0,0.3);
            border-top-left-radius: var(--border-radius-lg);
            border-top-right-radius: var(--border-radius-lg);
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at bottom, rgba(255,255,255,0.05) 0%, transparent 70%);
            animation: footerPulse 10s infinite alternate;
            pointer-events: none;
        }

        @keyframes footerPulse {
            0% { transform: scale(1); opacity: 1; }
            100% { transform: scale(1.2); opacity: 0.8; }
        }

        .footer .social-links {
            margin-bottom: 2rem;
        }

        .footer .social-links a {
            color: var(--white-color);
            font-size: 2.2rem; /* Larger social icons */
            margin: 0 1.2rem;
            transition: color 0.3s ease, transform 0.3s ease, text-shadow 0.3s ease;
            display: inline-block;
            position: relative;
            overflow: hidden;
        }

        .footer .social-links a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: transform 0.3s ease;
            transform: skewX(-20deg);
        }

        .footer .social-links a:hover {
            color: #00c6ff; /* Lighter blue on hover */
            transform: translateY(-8px) scale(1.2); /* More pronounced lift */
            text-shadow: 0 0 15px #00c6ff;
        }

        .footer .social-links a:hover::before {
            transform: translateX(100%) skewX(-20deg);
        }

        .footer p {
            margin-top: 2rem;
            font-size: 1.1rem;
            opacity: 0.85;
            font-weight: 300;
        }

        /* Scroll to Top Button */
        #scrollToTopBtn {
            display: none; /* Hidden by default */
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            background-color: var(--primary-color);
            color: var(--white-color);
            border: none;
            border-radius: 50%;
            width: 55px;
            height: 55px;
            font-size: 1.8rem;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.5);
            transition: background-color 0.3s ease, transform 0.3s ease, opacity 0.3s ease;
            opacity: 0;
        }

        #scrollToTopBtn.show {
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
        }

        #scrollToTopBtn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.7);
        }

        /* Preloader Overlay */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #e0f7fa, #e8f5e9, #fffde7, #fbe9e7, #f3e5f5); /* Soft pastel gradient */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 100000;
            opacity: 1;
            transition: opacity 1s ease-out;
        }

        #preloader.hidden {
            opacity: 0;
            pointer-events: none; /* Allow interaction after fade out */
        }

        .spinner {
            width: 80px;
            height: 80px;
            border: 8px solid rgba(0, 123, 255, 0.2);
            border-top: 8px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1.2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive Design Adjustments */
        @media (max-width: 1400px) {
            .slider-card {
                min-width: 420px;
                max-width: 420px;
                margin: 0 25px;
                padding: 2.5rem;
            }
            .main-header h1 {
                font-size: 3.8rem;
            }
            .main-header p {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 1200px) {
            .slider-card {
                min-width: 380px;
                max-width: 380px;
                margin: 0 20px;
                padding: 2.2rem;
            }
            .slider-card .icon-container {
                width: 90px;
                height: 90px;
                font-size: 3.2rem;
            }
            .slider-card h5 {
                font-size: 1.7rem;
            }
            .main-header h1 {
                font-size: 3.2rem;
            }
            .main-header p {
                font-size: 1.2rem;
            }
            .slider-wrapper {
                margin: 0 20px;
            }
            .slider-container {
                width: calc(100% - 40px);
            }
        }

        @media (max-width: 992px) {
            .slider-card {
                min-width: 300px;
                max-width: 300px;
                padding: 2rem;
                margin: 0 15px;
            }
            .slider-card .icon-container {
                width: 80px;
                height: 80px;
                font-size: 2.8rem;
            }
            .slider-card h5 {
                font-size: 1.5rem;
            }
            .main-header {
                padding: 4rem 2rem;
            }
            .main-header h1 {
                font-size: 2.8rem;
            }
            .main-header p {
                font-size: 1.1rem;
                margin-bottom: 2rem;
            }
            .slider-nav button {
                width: 55px;
                height: 55px;
                font-size: 1.8rem;
            }
            .footer .social-links a {
                font-size: 1.8rem;
                margin: 0 1rem;
            }
            #popup-message {
                font-size: 2rem;
                padding: 30px 40px;
            }
            #popup-message i {
                font-size: 3rem;
            }
        }

        @media (max-width: 768px) {
            .slider-card {
                min-width: 260px;
                max-width: 260px;
                margin: 0 10px;
                padding: 1.8rem;
            }
            .slider-wrapper {
                margin: 0 10px;
            }
            .slider-container {
                width: calc(100% - 20px);
            }
            .slider-nav {
                display: none; /* Hide arrows on smaller screens, rely on scroll/dots */
            }
            .main-header h1 {
                font-size: 2.2rem;
            }
            .main-header p {
                font-size: 1rem;
                margin-bottom: 1.5rem;
            }
            .footer {
                padding: 2.5rem 0;
            }
            .footer .social-links a {
                font-size: 1.5rem;
                margin: 0 0.8rem;
            }
            #scrollToTopBtn {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
                bottom: 20px;
                right: 20px;
            }
            #popup-message {
                font-size: 1.6rem;
                padding: 25px 35px;
            }
            #popup-message i {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 576px) {
            .slider-card {
                min-width: 90%; /* Take up most of the screen width */
                margin: 0 auto 2rem auto; /* Stack vertically with margin */
                float: none; /* Ensure stacking */
            }
            .slider-track {
                flex-direction: column; /* Stack cards vertically */
                align-items: center;
                padding: 0; /* Remove horizontal padding when stacking */
            }
            .slider-container {
                padding-bottom: 0; /* No need for horizontal scrollbar */
                overflow-x: hidden; /* Ensure no horizontal scroll */
                width: 100%; /* Full width */
            }
            .slider-wrapper {
                margin: 0;
                padding: 2rem 0;
            }
            .main-header {
                padding: 3rem 1rem;
                margin-bottom: 3rem;
            }
            .main-header h1 {
                font-size: 1.8rem;
            }
            .main-header p {
                font-size: 0.9rem;
            }
            .slider-dots {
                display: none; /* Hide dots if cards are stacked */
            }
            .footer {
                padding: 2rem 0;
            }
            .footer p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

    <div id="preloader">
        <div class="spinner"></div>
    </div>

    <div class="page-container">
        <header class="main-header">
            <p>
                "In an era where medical science advances at an unprecedented pace, staying informed is paramount. Meditronix is dedicated to being your premier source for the latest, most impactful medical news and breakthroughs. Our commitment is to deliver meticulously curated insights, expert analyses, and vital updates that empower healthcare professionals and individuals alike to navigate the complexities of modern health. Join us as we explore the frontiers of medicine, ensuring you are always equipped with knowledge that matters."
            </p>
            <h1>Pioneering Healthcare Insights: Your Daily Dose of Medical News</h1>
        </header>

        <main>
            <section class="slider-wrapper">
                <div class="slider-container" id="sliderContainer">
                    <div class="slider-track" id="sliderTrack">
                        <?php
                        // Define a rich set of medical icons
                        $icons = [
                            'fa-newspaper', 'fa-stethoscope', 'fa-pills', 'fa-microscope', 'fa-heartbeat',
                            'fa-brain', 'fa-dna', 'fa-bacteria', 'fa-hospital-user', 'fa-hand-holding-medical',
                            'fa-virus', 'fa-flask', 'fa-x-ray', 'fa-syringe', 'fa-user-nurse',
                            'fa-ambulance', 'fa-dna', 'fa-lungs', 'fa-bone', 'fa-tooth',
                            'fa-eye', 'fa-ear-listen', 'fa-hand-dots', 'fa-head-side-virus', 'fa-notes-medical'
                        ];

                        if (!empty($news_articles)) {
                            $icon_index = 0;
                            foreach ($news_articles as $row) {
                                // Cycle through icons for variety
                                $current_icon = $icons[$icon_index % count($icons)];
                                $icon_index++;
                        ?>
                                <article class="slider-card" data-id="<?php echo htmlspecialchars($row['id']); ?>">
                                    <div class="icon-container">
                                        <i class="fas <?php echo $current_icon; ?>"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark"><?php echo htmlspecialchars($row['title']); ?></h5>
                                    <p class="text-secondary"><?php echo htmlspecialchars(substr($row['content'], 0, 180)); ?>...</p>
                                    <p class="small text-muted">Status: <?php echo htmlspecialchars($row['status']); ?> | Published: <?php echo date('d M Y', strtotime($row['created_at'])); ?></p>
                                    </article>
                        <?php
                            }
                        } else {
                            // Message if no news articles are found
                            echo "<div class='slider-card' style='min-width: 100%; text-align: center; justify-content: center; align-items: center; display: flex; flex-direction: column; height: 350px; margin: 0 auto;'>";
                            echo "<div class='icon-container'><i class='fas fa-info-circle'></i></div>";
                            echo "<h5 class='fw-bold text-dark'>No News Available Yet</h5>";
                            echo "<p class='text-secondary'>Our team is working hard to bring you the latest updates. Please check back soon!</p>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
                <div class="slider-nav">
                    <button id="prevBtn" aria-label="Previous Slide"><i class="fas fa-chevron-left"></i></button>
                    <button id="nextBtn" aria-label="Next Slide"><i class="fas fa-chevron-right"></i></button>
                </div>
                <div class="slider-dots" id="sliderDots">
                    </div>
            </section>
        </main>
    </div>

    <div id="popup-message">
        <i class="fas fa-heart-pulse"></i>
        <span>✨ Thanks for exploring our medical updates ✨</span>
    </div>


    <button id="scrollToTopBtn" aria-label="Scroll to top"><i class="fas fa-arrow-up"></i></button>

    <script>
        // JavaScript Section
        document.addEventListener('DOMContentLoaded', () => {
            // Preloader logic
            const preloader = document.getElementById('preloader');
            window.addEventListener('load', () => {
                preloader.classList.add('hidden');
                // Remove preloader from DOM after transition
                preloader.addEventListener('transitionend', () => {
                    preloader.remove();
                });
            });

            const sliderContainer = document.getElementById('sliderContainer');
            const sliderTrack = document.getElementById('sliderTrack');
            const sliderCards = Array.from(document.querySelectorAll('.slider-card')); // Convert NodeList to Array
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const popupMessage = document.getElementById('popup-message');
            const sliderDotsContainer = document.getElementById('sliderDots');
            const scrollToTopBtn = document.getElementById('scrollToTopBtn');

            // Exit if no cards are present
            if (sliderCards.length === 0) {
                if (prevBtn) prevBtn.style.display = 'none';
                if (nextBtn) nextBtn.style.display = 'none';
                if (sliderDotsContainer) sliderDotsContainer.style.display = 'none';
                return;
            }

            let currentIndex = 0;
            let cardWidth = sliderCards[0].offsetWidth + (parseFloat(getComputedStyle(sliderCards[0]).marginLeft) * 2);
            let visibleCards = Math.floor(sliderContainer.offsetWidth / cardWidth);

            // Function to update the slider position
            const updateSliderPosition = () => {
                const offset = -currentIndex * cardWidth;
                sliderTrack.style.transform = `translateX(${offset}px)`;
                updateDots();
            };

            // Function to show the animated popup message
            const showPopupMessage = () => {
                popupMessage.classList.add('show');
                setTimeout(() => {
                    popupMessage.classList.remove('show');
                }, 3500); // Popup stays for 3.5 seconds
            };

            // Function to generate and update slider dots
            const generateDots = () => {
                sliderDotsContainer.innerHTML = ''; // Clear existing dots
                const totalSlides = Math.ceil(sliderCards.length / visibleCards); // Number of groups of visible cards
                for (let i = 0; i < totalSlides; i++) {
                    const dot = document.createElement('span');
                    dot.classList.add('slider-dot');
                    dot.dataset.index = i;
                    dot.addEventListener('click', () => {
                        currentIndex = i * visibleCards; // Jump to the start of the group
                        if (currentIndex > sliderCards.length - visibleCards) {
                            currentIndex = sliderCards.length - visibleCards; // Adjust if it goes past the end
                        }
                        updateSliderPosition();
                        stopAutoSlide(); // Pause auto-slide on manual navigation
                        startAutoSlide(); // Restart after a brief pause
                    });
                    sliderDotsContainer.appendChild(dot);
                }
                updateDots();
            };

            // Function to update active dot
            const updateDots = () => {
                const dots = document.querySelectorAll('.slider-dot');
                dots.forEach((dot, index) => {
                    dot.classList.remove('active');
                    // Determine which dot should be active based on current index and visible cards
                    if (Math.floor(currentIndex / visibleCards) === index) {
                        dot.classList.add('active');
                    }
                });
            };

            // Navigation for carousel (Next Button)
            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    if (currentIndex < sliderCards.length - visibleCards) {
                        currentIndex++;
                    } else {
                        currentIndex = 0; // Loop back to start
                    }
                    updateSliderPosition();
                    stopAutoSlide(); // Pause auto-slide on manual navigation
                    startAutoSlide(); // Restart after a brief pause
                });
            }

            // Navigation for carousel (Previous Button)
            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    if (currentIndex > 0) {
                        currentIndex--;
                    } else {
                        currentIndex = sliderCards.length - visibleCards; // Loop to end
                    }
                    updateSliderPosition();
                    stopAutoSlide(); // Pause auto-slide on manual navigation
                    startAutoSlide(); // Restart after a brief pause
                });
            }

            // Card click effect and popup
            sliderCards.forEach(card => {
                card.addEventListener('click', () => {
                    // Add shine effect
                    card.classList.add('shine');
                    // Remove shine after animation completes
                    card.addEventListener('animationend', () => {
                        card.classList.remove('shine');
                    }, { once: true }); // Ensure listener runs only once

                    showPopupMessage();
                });
            });

            // Auto-slide functionality
            let autoSlideInterval;
            const startAutoSlide = () => {
                stopAutoSlide(); // Clear any existing interval first
                autoSlideInterval = setInterval(() => {
                    if (currentIndex < sliderCards.length - visibleCards) {
                        currentIndex++;
                    } else {
                        currentIndex = 0; // Loop back to start
                    }
                    updateSliderPosition();
                }, 6000); // Change slide every 6 seconds
            };

            const stopAutoSlide = () => {
                clearInterval(autoSlideInterval);
            };

            // Pause auto-slide on hover over the slider container
            sliderContainer.addEventListener('mouseenter', stopAutoSlide);
            sliderContainer.addEventListener('mouseleave', startAutoSlide);

            // Initial setup on page load
            const initializeSlider = () => {
                cardWidth = sliderCards[0].offsetWidth + (parseFloat(getComputedStyle(sliderCards[0]).marginLeft) * 2);
                visibleCards = Math.floor(sliderContainer.offsetWidth / cardWidth);
                // Ensure currentIndex doesn't go out of bounds if window resizes smaller
                if (currentIndex > sliderCards.length - visibleCards) {
                    currentIndex = sliderCards.length - visibleCards > 0 ? sliderCards.length - visibleCards : 0;
                }
                const totalTrackWidth = cardWidth * sliderCards.length;
                sliderTrack.style.width = `${totalTrackWidth}px`;
                updateSliderPosition();
                generateDots(); // Generate dots based on new visibleCards
                startAutoSlide();
            };

            // Debounce for resize event for performance
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    initializeSlider();
                }, 250); // Wait 250ms after resize stops before recalculating
            });

            // Scroll to Top Button functionality
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) { // Show button after scrolling 300px
                    scrollToTopBtn.classList.add('show');
                } else {
                    scrollToTopBtn.classList.remove('show');
                }
            });

            scrollToTopBtn.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth' // Smooth scroll to top
                });
            });

            // Initial calls
            initializeSlider();
        });
    </script>
</body>
</html>

    

<?php
// Database Connection
// Ensure your database 'meditronix_new' is running and accessible.
// IMPORTANT: In a production environment, avoid 'root' and empty passwords.
// Use environment variables or a secure configuration file.
$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// --- CRUD Operations PHP Logic for Feedback ---


// Handle Add Feedback operation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_feedback') {
    $patient_id = sanitize_input($_POST['patient_id']);
    $message = sanitize_input($_POST['message']);
    $rating = sanitize_input($_POST['rating']);
    $status = sanitize_input($_POST['status']);
    $created_at = date('Y-m-d H:i:s'); // Get current timestamp

    // SQL INSERT query to add a new feedback record
    $insert_query = "INSERT INTO `feedback` (`patient_id`, `message`, `rating`, `status`, `created_at`) VALUES ('$patient_id', '$message', '$rating', '$status', '$created_at')";

    if (mysqli_query($db, $insert_query)) {
        // If query is successful, show a success message using JavaScript
        echo "<script>window.onload = function() { showCustomAlert('Feedback added successfully!', 'success'); }</script>";
    } else {
        // If query fails, show an error message
        echo "<script>window.onload = function() { showCustomAlert('Error adding feedback: " . mysqli_error($db) . "', 'error'); }</script>";
    }
}

// Handle Edit Feedback operation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit_feedback') {
    $id = sanitize_input($_POST['feedback_id']); // Feedback ID to identify the record
    $patient_id = sanitize_input($_POST['patient_id']);
    $message = sanitize_input($_POST['message']);
    $rating = sanitize_input($_POST['rating']);
    $status = sanitize_input($_POST['status']);

    // SQL UPDATE query to modify an existing feedback record
    $update_query = "UPDATE `feedback` SET `patient_id`='$patient_id', `message`='$message', `rating`='$rating', `status`='$status' WHERE `id`='$id'";

    if (mysqli_query($db, $update_query)) {
        // If query is successful, show a success message
        echo "<script>window.onload = function() { showCustomAlert('Feedback updated successfully!', 'success'); }</script>";
    } else {
        // If query fails, show an error message
        echo "<script>window.onload = function() { showCustomAlert('Error updating feedback: " . mysqli_error($db) . "', 'error'); }</script>";
    }
}

// Handle Delete Feedback operation (triggered via GET request for simplicity in this demo)
if (isset($_GET['delete_feedback_id'])) {
    $id = sanitize_input($_GET['delete_feedback_id']); // Feedback ID to identify the record to delete
    $delete_query = "DELETE FROM `feedback` WHERE `id`='$id'";

    if (mysqli_query($db, $delete_query)) {
        // If query is successful, show a success message
        echo "<script>window.onload = function() { showCustomAlert('Feedback deleted successfully!', 'success'); }</script>";
    } else {
        // If query fails, show an error message
        echo "<script>window.onload = function() { showCustomAlert('Error deleting feedback: " . mysqli_error($db) . "', 'error'); }</script>";
    }
}

// --- Data Fetching for Display (Feedback Data) ---

// Fetch all feedback data for display in carousel cards
// Ordered by creation date to show latest feedback first
$feedbacks_result = mysqli_query($db, "SELECT `id`, `patient_id`, `message`, `rating`, `status`, `created_at` FROM `feedback` WHERE 1 ORDER BY created_at DESC");

// Check if any feedback articles were fetched
$feedback_count = mysqli_num_rows($feedbacks_result);

// Prepare dummy data if no feedback articles are found in the database
$dummy_feedback_items = [];
if ($feedback_count === 0) {
    $dummy_feedback_items = [
        [
            'id' => 101,
            'patient_id' => 'P-001',
            'message' => 'The staff were incredibly kind and attentive. My experience at Meditronix was outstanding!',
            'rating' => 5,
            'status' => 'Approved',
            'created_at' => date('Y-m-d H:i:s', strtotime('-7 days'))
        ],
        [
            'id' => 102,
            'patient_id' => 'P-002',
            'message' => 'Good service overall, but waiting times for appointments could be shorter. Otherwise, a positive visit.',
            'rating' => 4,
            'status' => 'Approved',
            'created_at' => date('Y-m-d H:i:s', strtotime('-10 days'))
        ],
        [
            'id' => 103,
            'patient_id' => 'P-003',
            'message' => 'I had some concerns regarding the clarity of post-treatment instructions. Room for improvement.',
            'rating' => 3,
            'status' => 'Pending',
            'created_at' => date('Y-m-d H:i:s', strtotime('-15 days'))
        ],
        [
            'id' => 104,
            'patient_id' => 'P-004',
            'message' => 'Exceptional care from start to finish. The doctors were very knowledgeable and reassuring. Highly recommended!',
            'rating' => 5,
            'status' => 'Approved',
            'created_at' => date('Y-m-d H:i:s', strtotime('-20 days'))
        ],
        [
            'id' => 105,
            'patient_id' => 'P-005',
            'message' => 'The facility was clean and modern. My only suggestion would be to improve the online booking system.',
            'rating' => 4,
            'status' => 'Approved',
            'created_at' => date('Y-m-d H:i:s', strtotime('-25 days'))
        ],
        [
            'id' => 106,
            'patient_id' => 'P-006',
            'message' => 'My experience was not satisfactory. There was a significant delay in receiving my test results.',
            'rating' => 2,
            'status' => 'Archived',
            'created_at' => date('Y-m-d H:i:s', strtotime('-30 days'))
        ],
        [
            'id' => 107,
            'patient_id' => 'P-007',
            'message' => 'A truly compassionate and professional team. They made a difficult time much easier to navigate. Thank you!',
            'rating' => 5,
            'status' => 'Approved',
            'created_at' => date('Y-m-d H:i:s', strtotime('-35 days'))
        ]
    ];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meditronix: Patient Feedback Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome for modern icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    /*======================================================================
      GLOBAL STYLES & BASE LAYOUT
      Defines root variables for consistent theming, basic resets,
      and the overall page structure including the subtle rainbow background.
    ========================================================================*/
    :root {
        --primary-blue: #007bff;
        --secondary-blue: #00c6ff;
        --dark-blue: #0056b3;
        /* Updated light pastel rainbow colors for a softer, changing background */
        --pastel-color-1: #f0f8ff; /* Alice Blue */
        --pastel-color-2: #f8f0ff; /* Lavender Blush */
        --pastel-color-3: #fff0f8; /* Misty Rose */
        --pastel-color-4: #f0fff8; /* Mint Cream */
        --pastel-color-5: #fff8f0; /* Old Lace */
        --text-color-dark: #222;
        --text-color-medium: #555;
        --text-color-light: #888;
        --card-bg: rgba(255, 255, 255, 0.98); /* Almost opaque for readability */
        --card-border: rgba(255, 255, 255, 0.8);
        --shadow-light: 0 10px 40px rgba(0,0,0,0.12); /* Enhanced shadow */
        --shadow-hover: 0 20px 60px rgba(0,0,0,0.25); /* More prominent hover shadow */
        --border-radius-xl: 30px; /* Extra large border radius */
        --padding-xl: 3rem; /* Extra large padding */
        --transition-speed: 0.5s;
        --transition-ease: cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Smooth ease for animations */
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        /* Light rainbow background with subtle motion (wind/waterfall effect) */
        background: linear-gradient(135deg, var(--pastel-color-1) 0%, var(--pastel-color-2) 25%, var(--pastel-color-3) 50%, var(--pastel-color-4) 75%, var(--pastel-color-5) 100%);
        background-size: 300% 300%; /* Larger size for smoother motion */
        animation: bgGradientMotion 30s ease infinite alternate; /* Slower, more fluid motion */
        overflow-x: hidden;
        color: var(--text-color-medium);
        line-height: 1.8;
        position: relative;
    }

    /* Background animation for a subtle "wind" effect, now more pronounced */
    @keyframes bgGradientMotion {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .main-wrapper {
        max-width: 1800px; /* Even wider layout */
        margin: 40px auto; /* Reduced vertical margin to minimize overall page height */
        padding: 40px 20px; /* Adjusted padding */
        background: rgba(255, 255, 255, 0.6); /* More translucent wrapper background */
        border-radius: var(--border-radius-xl);
        box-shadow: 0 25px 80px rgba(0,0,0,0.15); /* Stronger shadow */
        backdrop-filter: blur(15px); /* Stronger blur effect */
        border: 1px solid rgba(255,255,255,0.7); /* More prominent border */
        position: relative;
        z-index: 1;
    }

    /*======================================================================
      HEADER SECTION
      Styling for the main title and introductory paragraph.
    ========================================================================*/
    .header-section {
        text-align: center;
        margin-bottom: 60px; /* Adjusted margin */
        padding: 35px; /* Adjusted padding */
        background: rgba(255,255,255,0.95); /* Nearly opaque header background */
        border-radius: var(--border-radius-xl);
        box-shadow: 0 18px 60px rgba(0,0,0,0.25); /* Stronger shadow */
        backdrop-filter: blur(18px); /* Stronger blur */
        border: 1px solid rgba(255,255,255,0.9);
        animation: fadeIn 1.5s ease-out;
    }

    .header-section h1 {
        font-size: 4.8rem; /* Even larger, more impactful heading */
        background: linear-gradient(to right, #00c6ff, #0072ff, #4facfe); /* More colors for shimmer */
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shimmer 6s ease-in-out infinite; /* Slower, more elegant shimmer */
        margin-bottom: 25px;
        font-weight: 900; /* Extra bold */
        letter-spacing: 3px; /* Increased letter spacing */
        text-shadow: 4px 4px 12px rgba(0,0,0,0.2); /* More pronounced text shadow */
    }

    @keyframes shimmer {
        0%, 100% { background-position: -400% 0; }
        50% { background-position: 400% 0; }
    }

    .header-section p {
        font-size: 1.6rem; /* Larger intro text */
        color: var(--text-color-dark); /* Darker for better contrast */
        max-width: 1000px; /* Wider text block */
        margin: 0 auto;
        line-height: 1.9;
        text-shadow: 1px 1px 4px rgba(0,0,0,0.1); /* Slightly stronger text shadow */
    }

    /*======================================================================
      FEEDBACK MANAGEMENT SECTION (CRUD FORMS)
      This section contains the forms for adding, editing, and deleting feedback.
    ========================================================================*/
    .crud-section {
        max-width: 900px;
        margin: 60px auto;
        background: var(--card-bg);
        border-radius: var(--border-radius-xl);
        box-shadow: var(--shadow-light);
        padding: 40px;
        border: 1px solid var(--card-border);
        transition: all var(--transition-speed) var(--transition-ease);
    }

    .crud-section h2 {
        text-align: center;
        font-size: 2.5rem;
        color: var(--text-color-dark);
        margin-bottom: 30px;
        border-bottom: 2px solid rgba(0,0,0,0.1);
        padding-bottom: 15px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
    }

    .crud-form-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .crud-section input[type="text"],
    .crud-section input[type="number"],
    .crud-section textarea,
    .crud-section select {
        width: 100%;
        padding: 15px 20px;
        border: 1px solid rgba(0,0,0,0.1);
        border-radius: 15px;
        font-size: 1.1rem;
        background: rgba(255,255,255,0.7);
        transition: all 0.3s ease;
        box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
        color: var(--text-color-dark);
    }

    .crud-section input:focus,
    .crud-section textarea:focus,
    .crud-section select:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(0,123,255,0.25);
        outline: none;
    }

    .crud-section textarea {
        resize: vertical;
        min-height: 100px;
        grid-column: 1 / -1; /* Make textarea span full width */
    }

    .crud-section button {
        padding: 15px 40px;
        border: none;
        border-radius: 30px;
        background: linear-gradient(to right, #4facfe, #00f2fe);
        color: #fff;
        cursor: pointer;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        transition: all 0.4s ease;
        font-size: 1.2rem;
        font-weight: 600;
        display: block;
        margin: 0 auto;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .crud-section button:hover {
        background: linear-gradient(to right, #00f2fe, #4facfe);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.2);
    }

    /* Styles for the Edit Modal */
    .edit-modal {
        display: none; /* Hidden by default */
        position: fixed;
        z-index: 3000; /* Above everything */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.7); /* Darker overlay */
        backdrop-filter: blur(10px);
        animation: fadeIn 0.4s ease-out;
        justify-content: center;
        align-items: center;
    }

    .edit-modal-content {
        background-color: #fefefe;
        margin: auto; /* Center vertically and horizontally */
        padding: 50px; /* Larger padding */
        border: 1px solid #888;
        width: 90%;
        max-width: 700px; /* Constrain max width */
        border-radius: var(--border-radius-xl);
        box-shadow: 0 25px 80px rgba(0,0,0,0.4);
        position: relative;
        animation: slideInTop 0.5s ease-out;
    }

    .edit-modal-content .close-button {
        color: #aaa;
        font-size: 3rem; /* Larger close button */
        font-weight: bold;
        position: absolute;
        top: 20px;
        right: 30px;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .edit-modal-content .close-button:hover,
    .edit-modal-content .close-button:focus {
        color: #333;
    }

    .edit-modal-content h2 {
        margin-bottom: 25px;
        font-size: 2.5rem;
        color: var(--text-color-dark);
        text-align: center;
    }

    /*======================================================================
      FEEDBACK CAROUSEL SECTION
      Styling for the feedback cards carousel, including auto-sliding and click effects.
    ========================================================================*/
@keyframes backgroundPan {
    0% {
        background-position: 0% center;
    }
    100% {
        background-position: 100% center;
    }
}

.feedback-carousel-section {
    overflow-x: auto;
    padding: 50px 0;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
    position: relative;
    box-shadow: inset 0 0 25px rgba(0,0,0,0.1);
    border-radius: var(--border-radius-xl);
    background: rgba(255, 255, 255, 0.85);
    border: 1px solid var(--card-border);

    background-image: url('https://cdn.pixabay.com/photo/2024/08/29/12/12/doctor-9006736_1280.jpg');
    background-size: cover;   /* FULL width, fills perfectly, no gap */
    background-repeat: no-repeat;
    background-position: 0% center;
    background-attachment: fixed; /* Optional, for parallax-like effect */
    background-blend-mode: overlay;

    animation: backgroundPan 40s linear infinite;
    margin-bottom: 0 !important;
}


    @keyframes backgroundPan {
        0% { background-position: 0% 50%; }
        100% { background-position: 100% 50%; }
    }

    /* Custom scrollbar for webkit browsers */
    .feedback-carousel-section::-webkit-scrollbar {
        height: 16px; /* Thicker scrollbar */
    }
    .feedback-carousel-section::-webkit-scrollbar-track {
        background: rgba(0,0,0,0.15);
        border-radius: 10px;
    }
    .feedback-carousel-section::-webkit-scrollbar-thumb {
        background: linear-gradient(to right, #00c6ff, #0072ff);
        border-radius: 10px;
        border: 4px solid rgba(255,255,255,0.95); /* Thicker, brighter border */
    }
    .feedback-carousel-section::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to right, #0072ff, #00c6ff);
    }

    .feedback-carousel-track {
        display: flex;
        gap: 60px; /* Increased gap between cards */
        padding: 30px; /* Increased padding inside the track */
        min-width: fit-content;
    }

    .feedback-card {
        flex: 0 0 480px; /* Larger card size */
        background: var(--card-bg);
        border-radius: var(--border-radius-xl);
        padding: var(--padding-xl);
        position: relative;
        box-shadow: var(--shadow-light);
        transition: transform var(--transition-speed) var(--transition-ease), box-shadow var(--transition-speed) var(--transition-ease), background var(--transition-speed) var(--transition-ease);
        overflow: hidden;
        border: 1px solid var(--card-border);
        cursor: pointer;
        scroll-snap-align: start;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        z-index: 5; /* Ensure cards are above effects */
    }

    .feedback-card:hover {
        transform: translateY(-20px) scale(1.06); /* More dramatic hover effect */
        box-shadow: var(--shadow-hover);
        background: rgba(255,255,255,1); /* Fully opaque on hover */
    }

    /* Glittering Shine Effect on click (Shining Blade) */
    .feedback-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -200%; /* Start far off-screen to the left */
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.95), transparent); /* Stronger, brighter shine */
        transform: skewX(-30deg); /* More angled "blade" */
        transition: left 1s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Slower, smoother transition */
        pointer-events: none;
        z-index: 10;
        opacity: 0; /* Hidden by default */
    }
    .feedback-card.clicked::before {
        left: 200%; /* Slide across to the right */
        opacity: 1; /* Make visible when clicked */
        animation: glitterShineBlade 1s forwards; /* Animation for the shine */
    }
    @keyframes glitterShineBlade {
        0% { left: -200%; opacity: 0; }
        50% { left: 0%; opacity: 1; }
        100% { left: 200%; opacity: 0; }
    }

    /* Crystal Water Effect on click (Expanding Radial Gradient) */
    .feedback-card::after {
        content: '';
        position: absolute;
        top: var(--mouse-y, 50%);
        left: var(--mouse-x, 50%);
        width: 0;
        height: 0;
        border-radius: 50%;
        background: radial-gradient(circle at center, rgba(0, 198, 255, 0.5), transparent 70%); /* Brighter blue water ripple */
        opacity: 0;
        transform: translate(-50%, -50%);
        transition: width 0.8s ease-out, height 0.8s ease-out, opacity 0.8s ease-out; /* Slower, more fluid expansion */
        pointer-events: none;
        z-index: 9;
    }
    .feedback-card.clicked::after {
        width: 250%; /* Expand significantly */
        height: 250%;
        opacity: 1;
    }

    .feedback-icon-container {
        width: 110px; /* Larger icon container */
        height: 110px;
        background: linear-gradient(135deg, #00c6ff, #0072ff);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 3.5rem; /* Larger icon font */
        margin: 0 auto 30px; /* More margin */
        box-shadow: 0 12px 30px rgba(0,114,255,0.6); /* Stronger shadow */
        transition: transform 0.6s cubic-bezier(0.68, -0.55, 0.27, 1.55); /* Springy animation */
        position: relative;
        overflow: hidden;
    }
    .feedback-icon-container::before {
        content: '';
        position: absolute;
        top: -60%;
        left: -60%;
        width: 220%;
        height: 220%;
        background: radial-gradient(circle at center, rgba(255,255,255,0.4), transparent 75%);
        animation: iconPulse 4s infinite alternate; /* Slower pulsing glow */
    }
    @keyframes iconPulse {
        0% { transform: scale(0.7); opacity: 0.6; }
        100% { transform: scale(1.3); opacity: 0.9; }
    }

    .feedback-card:hover .feedback-icon-container {
        transform: rotate(25deg) scale(1.25); /* More dramatic rotate and scale */
    }

    .feedback-card h2 {
        font-size: 1.8rem; /* Larger title */
        color: var(--text-color-dark);
        margin-bottom: 20px;
        text-align: center;
        font-weight: 800;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
    }

    .feedback-card p {
        color: var(--text-color-medium);
        font-size: 1.1rem; /* Slightly larger text */
        margin-bottom: 25px;
        line-height: 1.8;
        text-align: justify;
        flex-grow: 1;
    }

    .feedback-card footer {
        font-size: 1rem; /* Larger footer text */
        color: var(--text-color-light);
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        border-top: 1px dashed rgba(0,0,0,0.25); /* More visible dashed border */
        padding-top: 25px;
        align-items: center;
    }

    /*======================================================================
      POPUP MESSAGES (CUSTOM ALERTS/CONFIRMS)
      Styling for the interactive popup message.
    ========================================================================*/
    .custom-modal {
        display: none; /* Hidden by default */
        position: fixed;
        z-index: 3000; /* Above everything */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.7); /* Darker overlay */
        backdrop-filter: blur(10px);
        animation: fadeIn 0.4s ease-out;
        justify-content: center;
        align-items: center;
    }

    .custom-modal-content {
        background-color: #fefefe;
        margin: auto; /* Center vertically and horizontally */
        padding: 50px; /* Larger padding */
        border: 1px solid #888;
        width: 90%;
        max-width: 600px; /* Larger max width */
        border-radius: var(--border-radius-xl);
        box-shadow: 0 25px 80px rgba(0,0,0,0.4);
        position: relative;
        animation: slideInTop 0.5s ease-out;
        text-align: center;
    }

    .custom-modal-content .close-button {
        color: #aaa;
        font-size: 3rem; /* Larger close button */
        font-weight: bold;
        position: absolute;
        top: 20px;
        right: 30px;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .custom-modal-content .close-button:hover,
    .custom-modal-content .close-button:focus {
        color: #333;
    }

    .custom-modal-content h3 {
        margin-bottom: 25px;
        font-size: 2.5rem;
        color: var(--text-color-dark);
    }

    .custom-modal-content p {
        margin-bottom: 35px;
        font-size: 1.2rem;
        line-height: 1.7;
    }

    .custom-modal-content .modal-buttons button {
        padding: 12px 30px;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-size: 1.1rem;
        font-weight: 700;
        transition: background 0.3s ease, transform 0.2s ease;
        margin: 0 15px;
    }

    .custom-modal-content .modal-buttons .btn-ok {
        background: linear-gradient(to right, #28a745, #218838);
        color: #fff;
    }
    .custom-modal-content .modal-buttons .btn-ok:hover {
        background: linear-gradient(to right, #218838, #28a745);
        transform: translateY(-3px);
    }

    .custom-modal-content .modal-buttons .btn-cancel {
        background: linear-gradient(to right, #dc3545, #c82333);
        color: #fff;
    }
    .custom-modal-content .modal-buttons .btn-cancel:hover {
        background: linear-gradient(to right, #c82333, #dc3545);
        transform: translateY(-3px);
    }

    /* Specific styling for the initial "Thanks for exploring" popup */
    #popup-message {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        background: linear-gradient(45deg, #ff9a9e 0%, #fad0c4 99%, #fad0c4 100%);
        padding: 50px 80px; /* Larger padding */
        border-radius: var(--border-radius-xl);
        font-size: 3rem; /* Larger text */
        color: #fff;
        text-shadow: 1px 1px 6px rgba(0,0,0,0.5);
        box-shadow: 0 0 40px rgba(255,154,158,0.9); /* Stronger shadow */
        opacity: 0;
        transition: transform 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55), opacity 0.8s ease;
        z-index: 2000; /* Highest z-index */
        border: 5px solid rgba(255,255,255,0.95);
        font-weight: bold;
        letter-spacing: 2px;
        text-align: center;
    }
    #popup-message.show {
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
    }

    /* Firework Canvas for dynamic effects */
    #fireworkCanvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none; /* Allows clicks to pass through to elements below */
        z-index: 1500; /* Below popups, above content */
    }

    /*======================================================================
      FOOTER & SOCIAL LINKS
      Styling for the social media links and copyright information.
    ========================================================================*/
    .footer-social-links {
        text-align: center;
        margin-top: 0 !important; /* IMPORTANT: Remove all space above social links */
        padding-top: 70px; /* More padding */
        border-top: 1px solid rgba(0,0,0,0.3); /* More visible border */
        padding-bottom: 50px;
    }
    .footer-social-links a {
        margin: 0 35px; /* Increased spacing */
        color: var(--primary-blue);
        font-size: 3rem; /* Larger icons */
        text-decoration: none;
        transition: color 0.5s ease, transform 0.5s ease, text-shadow 0.5s ease;
    }
    .footer-social-links a:hover {
        transform: translateY(-12px) scale(1.4); /* More lift */
        color: var(--dark-blue);
        text-shadow: 0 10px 20px rgba(0,123,255,0.5);
    }

    footer {
        text-align: center;
        margin-top: 0 !important; /* IMPORTANT: Remove all space above footer */
        padding: 35px 0;
        border-top: 1px dashed rgba(0,0,0,0.2);
        color: var(--text-color-light);
        font-size: 1.1rem;
    }

    /*======================================================================
      RESPONSIVE DESIGN
      Media queries for optimal viewing on various screen sizes.
    ========================================================================*/
    @media (max-width: 1600px) {
        .main-wrapper {
            max-width: 1400px;
        }
        .feedback-card {
            flex: 0 0 450px;
        }
    }

    @media (max-width: 1200px) {
        .main-wrapper {
            max-width: 1000px;
            padding: 30px 15px;
        }
        .header-section h1 {
            font-size: 3.8rem;
        }
        .header-section p {
            font-size: 1.4rem;
        }
        .feedback-card {
            flex: 0 0 400px;
            padding: 2.5rem;
        }
        .feedback-icon-container {
            width: 100px;
            height: 100px;
            font-size: 3rem;
        }
        .feedback-card h2 {
            font-size: 1.6rem;
        }
        .feedback-card p {
            font-size: 1rem;
        }
        .feedback-carousel-track {
            gap: 40px;
        }
        .footer-social-links a {
            font-size: 2.5rem;
            margin: 0 25px;
        }
    }

    @media (max-width: 992px) {
        .main-wrapper {
            max-width: 760px;
            margin: 20px auto;
        }
        .header-section {
            margin-bottom: 40px;
            padding: 25px;
        }
        .header-section h1 {
            font-size: 3rem;
            letter-spacing: 2px;
        }
        .header-section p {
            font-size: 1.2rem;
        }
        .feedback-card {
            flex: 0 0 90%; /* Take up more width on smaller screens */
            margin: 0 auto; /* Center cards */
            padding: 2rem;
            min-width: 320px;
        }
        .feedback-carousel-track {
            justify-content: flex-start;
            padding-left: 10px;
            padding-right: 10px;
            gap: 30px;
        }
        .feedback-icon-container {
            width: 90px;
            height: 90px;
            font-size: 2.8rem;
            margin-bottom: 25px;
        }
        .feedback-card h2 {
            font-size: 1.5rem;
        }
        .feedback-card p {
            font-size: 0.95rem;
            line-height: 1.7;
        }
        .feedback-card footer {
            font-size: 0.9rem;
            padding-top: 20px;
        }
        .footer-social-links a {
            font-size: 2rem;
            margin: 0 20px;
        }
        .custom-modal-content {
            padding: 30px;
        }
        .custom-modal-content h3 {
            font-size: 2rem;
        }
        .custom-modal-content p {
            font-size: 1.1rem;
        }
        #popup-message {
            padding: 30px 50px;
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        body {
            padding: 5px 0;
        }
        .main-wrapper {
            padding: 15px 10px;
            margin: 10px auto;
        }
        .header-section {
            padding: 20px;
            margin-bottom: 30px;
        }
        .header-section h1 {
            font-size: 2.5rem;
            letter-spacing: 1px;
        }
        .header-section p {
            font-size: 1rem;
        }
        .feedback-card {
            padding: 1.5rem;
            flex: 0 0 95%;
        }
        .feedback-icon-container {
            width: 80px;
            height: 80px;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .feedback-card h2 {
            font-size: 1.3rem;
        }
        .feedback-card p {
            font-size: 0.85rem;
            line-height: 1.6;
        }
        .feedback-carousel-track {
            gap: 20px;
            padding-left: 5px;
            padding-right: 5px;
        }
        .footer-social-links {
            padding-top: 40px;
            padding-bottom: 30px;
        }
        .footer-social-links a {
            font-size: 1.8rem;
            margin: 0 15px;
        }
        .custom-modal-content {
            padding: 25px;
        }
        .custom-modal-content h3 {
            font-size: 1.8rem;
        }
        .custom-modal-content p {
            font-size: 1rem;
        }
        #popup-message {
            font-size: 2rem;
            padding: 25px 40px;
        }
    }

    @media (max-width: 480px) {
        .header-section h1 {
            font-size: 2rem;
        }
        .header-section p {
            font-size: 0.8rem;
        }
        .feedback-card {
            padding: 1.2rem;
            flex: 0 0 98%;
        }
        .feedback-icon-container {
            width: 70px;
            height: 70px;
            font-size: 2.2rem;
        }
        .feedback-card h2 {
            font-size: 1.1rem;
        }
        .feedback-card p {
            font-size: 0.75rem;
        }
        .feedback-carousel-track {
            gap: 15px;
        }
        .footer-social-links {
            padding-top: 30px;
            padding-bottom: 20px;
        }
        .footer-social-links a {
            font-size: 1.5rem;
            margin: 0 10px;
        }
        .custom-modal-content {
            padding: 20px;
        }
        .custom-modal-content h3 {
            font-size: 1.5rem;
        }
        .custom-modal-content p {
            font-size: 0.9rem;
        }
        #popup-message {
            font-size: 1.6rem;
            padding: 20px 30px;
        }
    }
    </style>
</head>
<body>

<div class="main-wrapper">
    <!-- Header Section -->
    <div class="header-section">
        <h1><i class="fas fa-comment-dots" style="margin-right: 15px; color: #00c6ff;"></i>Meditronix: Patient Feedback & Insights<i class="fas fa-lightbulb" style="margin-left: 15px; color: #0072ff;"></i></h1>
        <p>Your voice matters! At Meditronix, we value every piece of feedback as it helps us continuously improve our services and patient care. Explore what our patients are saying, understand their experiences, and contribute your own thoughts to help us grow. This dashboard provides a transparent view of patient satisfaction and areas for enhancement.</p>
    </div>

    <!-- Feedback Management Section (CRUD Forms) -->
    <div class="crud-section">
 

        <!-- Edit Feedback Modal (Hidden by default, shown by JS) -->
        <div id="editFeedbackModal" class="custom-modal">
            <div class="custom-modal-content">
                <span class="close-button" onclick="closeEditModal()">&times;</span>
                <h2>Edit Feedback</h2>
                <form id="editFeedbackForm" method="post" action="">
                    <input type="hidden" name="action" value="edit_feedback">
                    <input type="hidden" id="editFeedbackId" name="feedback_id">
                    <div class="crud-form-group">
                        <input type="text" id="editPatientId" name="patient_id" placeholder="Patient ID" required>
                        <textarea id="editMessage" name="message" placeholder="Feedback Message" required></textarea>
                        <input type="number" id="editRating" name="rating" placeholder="Rating (1-5)" min="1" max="5" required>
                        <select id="editStatus" name="status" required>
                            <option value="Approved">Approved</option>
                            <option value="Pending">Pending</option>
                            <option value="Archived">Archived</option>
                        </select>
                    </div>
                    <button type="submit">Update Feedback</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Feedback Carousel Section -->
    <div class="feedback-carousel-section" id="feedbackCarouselContainer">
        <h2 style="text-align: center; font-size: 2.8rem; color: var(--text-color-dark); margin-bottom: 40px; text-shadow: 1px 1px 2px rgba(0,0,0,0.05);">What Our Patients Say</h2>
        <div class="feedback-carousel-track" id="feedbackCarouselTrack">
            <?php
            // If no news from DB, use dummy data
            if ($feedback_count === 0) {
                $current_feedback_items = $dummy_feedback_items;
            } else {
                // Reset pointer for feedbacks_result to ensure all feedbacks are displayed
                mysqli_data_seek($feedbacks_result, 0);
                $current_feedback_items = [];
                while ($row = mysqli_fetch_assoc($feedbacks_result)) {
                    $current_feedback_items[] = $row;
                }
            }

            // Define a set of relevant icons to cycle through
            $feedback_icons = [
                'fas fa-comments',       // General feedback
                'fas fa-heart',          // Positive feedback/care
                'fas fa-star-half-alt',  // Mixed feedback
                'fas fa-frown',          // Negative feedback
                'fas fa-lightbulb',      // Suggestions
                'fas fa-check-circle',   // Approved feedback
                'fas fa-hourglass-half', // Pending feedback
                'fas fa-archive',        // Archived feedback
                'fas fa-user-nurse',     // Nursing staff
                'fas fa-hospital-user'   // Patient experience
            ];

            $icon_index = 0; // To cycle through icons
            foreach ($current_feedback_items as $feedback_item) {
                // Get a specific icon from the array and increment index
                $current_icon = $feedback_icons[$icon_index % count($feedback_icons)];
                $icon_index++;
            ?>
            <div class="feedback-card" data-feedback-id="<?= htmlspecialchars($feedback_item['id']); ?>" data-patient-id="<?= htmlspecialchars($feedback_item['patient_id']); ?>" data-message="<?= htmlspecialchars($feedback_item['message']); ?>" data-rating="<?= htmlspecialchars($feedback_item['rating']); ?>" data-status="<?= htmlspecialchars($feedback_item['status']); ?>">
                <div class="feedback-icon-container"><i class="<?= $current_icon; ?>"></i></div>
                <h2 class="fw-bold text-dark mb-3">Patient ID: <?php echo htmlspecialchars($feedback_item['patient_id']); ?></h2>
                <p class="text-secondary mb-4"><?php echo htmlspecialchars($feedback_item['message']); ?></p>
                <footer>
                    <span class="small text-muted">Rating: <strong><?php echo htmlspecialchars($feedback_item['rating']); ?>/5</strong></span>
                    <span class="small text-muted">Status: <?php echo htmlspecialchars($feedback_item['status']); ?> | Shared: <?php echo date('d M Y', strtotime($feedback_item['created_at'])); ?></span>
                </footer>
                <div style="margin-top: 15px; text-align: center;">
                    <button onclick="event.stopPropagation(); openEditModal(this)" style="background: linear-gradient(to right, #30cfd0, #330867); color: #fff; padding: 8px 15px; border-radius: 20px; border: none; cursor: pointer; font-size: 0.9rem; margin-right: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: all 0.3s ease;">Edit</button>
                    <button onclick="event.stopPropagation(); deleteFeedback(<?= $feedback_item['id']; ?>)" style="background: linear-gradient(to right, #ff5f6d, #ffc371); color: #fff; padding: 8px 15px; border-radius: 20px; border: none; cursor: pointer; font-size: 0.9rem; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: all 0.3s ease;">Delete</button>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Custom Popup Message -->
<div id="customPopupMessage" class="custom-modal">
    <div class="custom-modal-content">
        <span class="close-button" onclick="closeCustomAlert()">&times;</span>
        <h3 id="popupTitle"></h3>
        <p id="popupMessage"></p>
        <div class="modal-buttons">
            <button class="btn-ok" onclick="closeCustomAlert()">OK</button>
        </div>
    </div>
</div>

<!-- Custom Confirm Modal -->
<div id="customConfirmModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="close-button" onclick="closeCustomConfirm()">&times;</span>
        <h3>Confirm Action</h3>
        <p id="confirmMessage"></p>
        <div class="modal-buttons">
            <button class="btn-ok" id="confirmOkBtn">Yes</button>
            <button class="btn-cancel" id="confirmCancelBtn">No</button>
        </div>
    </div>
</div>

<!-- Initial "Thanks for exploring" popup -->
<div id="popup-message">✨ Welcome to Meditronix Feedback! ✨<br><center>Your Voice Shapes Our Care.</center></div>
<canvas id="fireworkCanvas"></canvas>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
//======================================================================
// JAVASCRIPT FUNCTIONS & INTERACTIVITY
// This section handles all dynamic behaviors, including popup messages,
// click effects on cards and charts, and the carousel auto-sliding.
//======================================================================

// --- Custom Alert/Confirm Modals ---
function showCustomAlert(message, type = 'info') {
    const popupModal = document.getElementById('customPopupMessage');
    const popupTitle = document.getElementById('popupTitle');
    const popupMessage = document.getElementById('popupMessage');
    const okButton = popupModal.querySelector('.btn-ok');

    popupTitle.textContent = type.charAt(0).toUpperCase() + type.slice(1); // Capitalize type (e.g., "Success", "Error")
    popupMessage.textContent = message;

    // Set title color based on type
    if (type === 'success') {
        popupTitle.style.color = '#28a745';
        okButton.style.background = 'linear-gradient(to right, #28a745, #218838)';
    } else if (type === 'error') {
        popupTitle.style.color = '#dc3545';
        okButton.style.background = 'linear-gradient(to right, #dc3545, #c82333)';
    } else { // info or default
        popupTitle.style.color = '#007bff';
        okButton.style.background = 'linear-gradient(to right, #007bff, #0056b3)';
    }

    popupModal.style.display = 'flex'; // Use flex to center
}

function closeCustomAlert() {
    document.getElementById('customPopupMessage').style.display = 'none';
}

function showCustomConfirm(message, onConfirmCallback) {
    const confirmModal = document.getElementById('customConfirmModal');
    const confirmMessage = document.getElementById('confirmMessage');
    const confirmOkBtn = document.getElementById('confirmOkBtn');
    const confirmCancelBtn = document.getElementById('confirmCancelBtn');

    confirmMessage.textContent = message;
    confirmModal.style.display = 'flex';

    // Clear previous event listeners to prevent multiple calls
    confirmOkBtn.onclick = null;
    confirmCancelBtn.onclick = null;

    confirmOkBtn.onclick = () => {
        onConfirmCallback();
        confirmModal.style.display = 'none';
    };
    confirmCancelBtn.onclick = () => {
        confirmModal.style.display = 'none';
    };
}

function closeCustomConfirm() {
    document.getElementById('customConfirmModal').style.display = 'none';
}

// Initial "Welcome" popup on page load
window.addEventListener('load', function() {
    const initialPopup = document.getElementById('popup-message');
    initialPopup.classList.add('show');
    setTimeout(() => initialPopup.classList.remove('show'), 3000);
});

// --- Feedback Card Interactions (Glitter and Water effects) ---
document.querySelectorAll('.feedback-card').forEach(card => {
    card.addEventListener('click', (event) => {
        // Prevent default click behavior and effects if a social link or button inside the card was clicked
        if (event.target.closest('.card-social-links') || event.target.tagName === 'BUTTON') {
            return;
        }

        // Add 'clicked' class to trigger the glitter shine and water-filled effects
        card.classList.add('clicked');

        // Capture mouse position for the water-filled effect origin
        const rect = card.getBoundingClientRect();
        const mouseX = event.clientX - rect.left; // X position within the element
        const mouseY = event.clientY - rect.top;  // Y position within the element
        card.style.setProperty('--mouse-x', `${mouseX}px`);
        card.style.setProperty('--mouse-y', `${mouseY}px`);

        // Remove the 'clicked' class after the animation duration to allow re-triggering
        setTimeout(() => {
            card.classList.remove('clicked');
        }, 1000); // Matches the CSS transition duration for the glitter effect
    });
});

// --- CRUD Modals and Operations for Feedback ---

// Function to open the Edit Feedback Modal and populate it with data
function openEditModal(button) {
    const card = button.closest('.feedback-card');
    const feedbackId = card.dataset.feedbackId;
    const patientId = card.dataset.patientId;
    const message = card.dataset.message;
    const rating = card.dataset.rating;
    const status = card.dataset.status;

    document.getElementById('editFeedbackId').value = feedbackId;
    document.getElementById('editPatientId').value = patientId;
    document.getElementById('editMessage').value = message;
    document.getElementById('editRating').value = rating;
    document.getElementById('editStatus').value = status;

    document.getElementById('editFeedbackModal').style.display = 'flex'; // Show the modal
}

// Function to close the Edit Feedback Modal
function closeEditModal() {
    document.getElementById('editFeedbackModal').style.display = 'none';
}

// Function to handle Delete Feedback operation
function deleteFeedback(id) {
    showCustomConfirm('Are you sure you want to delete this feedback? This action cannot be undone.', () => {
        window.location.href = '?delete_feedback_id=' + id; // Redirect to trigger PHP delete logic
    });
}

//======================================================================
// CAROUSEL AUTO-SLIDING FEATURE (BI-DIRECTIONAL "TRAIN" MOVEMENT)
// This section controls the automatic, smooth, back-and-forth scrolling
// of the feedback cards carousel.
//======================================================================
const feedbackCarouselContainer = document.getElementById('feedbackCarouselContainer');
const feedbackCarouselTrack = document.getElementById('feedbackCarouselTrack');
const feedbackCards = document.querySelectorAll('.feedback-card');

let currentScroll = 0;
let scrollDirection = 1; // 1 for right, -1 for left
let carouselAnimationFrameId;
const scrollSpeed = 2.5; // Speed for auto-sliding
const pauseAtEndDuration = 2500; // Pause duration at the end/start of the track

function animateFeedbackCarousel() {
    currentScroll += scrollDirection * scrollSpeed;
    feedbackCarouselContainer.scrollLeft = currentScroll;

    // Calculate maximum scroll position
    // clientWidth is the visible width of the container
    // scrollWidth is the total scrollable width of the content
    const maxScrollLeft = feedbackCarouselTrack.scrollWidth - feedbackCarouselContainer.clientWidth;

    // Check if we've reached the end (scrolling right)
    if (scrollDirection === 1 && feedbackCarouselContainer.scrollLeft >= maxScrollLeft - 5) { // Small buffer
        cancelAnimationFrame(carouselAnimationFrameId); // Stop animation
        setTimeout(() => {
            scrollDirection = -1; // Change direction to left
            carouselAnimationFrameId = requestAnimationFrame(animateFeedbackCarousel); // Restart animation
        }, pauseAtEndDuration);
    }
    // Check if we've reached the beginning (scrolling left)
    else if (scrollDirection === -1 && feedbackCarouselContainer.scrollLeft <= 5) { // Small buffer
        cancelAnimationFrame(carouselAnimationFrameId); // Stop animation
        setTimeout(() => {
            scrollDirection = 1; // Change direction to right
            carouselAnimationFrameId = requestAnimationFrame(animateFeedbackCarousel); // Restart animation
        }, pauseAtEndDuration);
    } else {
        // Continue animation if not at an end
        carouselAnimationFrameId = requestAnimationFrame(animateFeedbackCarousel);
    }
}

// Start auto-scrolling when the page loads
window.addEventListener('load', () => {
    carouselAnimationFrameId = requestAnimationFrame(animateFeedbackCarousel);
});

// Pause scrolling on hover over the carousel
feedbackCarouselContainer.addEventListener('mouseover', () => {
    cancelAnimationFrame(carouselAnimationFrameId);
});

feedbackCarouselContainer.addEventListener('mouseout', () => {
    carouselAnimationFrameId = requestAnimationFrame(animateFeedbackCarousel);
});

// No charts, so no chart resize listeners needed here
</script>

<script>
//======================================================================
// FIREWORK CRACKER EFFECT (Canvas Animation)
// This section handles the visual firework animation triggered on card clicks.
//======================================================================
const fireworkCanvas = document.getElementById('fireworkCanvas');
const fireworkCtx = fireworkCanvas.getContext('2d');
fireworkCanvas.width = window.innerWidth;
fireworkCanvas.height = window.innerHeight;

// Adjust canvas size on window resize
window.addEventListener('resize', () => {
    fireworkCanvas.width = window.innerWidth;
    fireworkCanvas.height = window.innerHeight;
});

function random(min, max) {
    return Math.random() * (max - min) + min;
}

function createParticles(x, y) {
    const particles = [];
    for (let i = 0; i < 60; i++) { // More particles for a denser effect
        particles.push({
            x,
            y,
            radius: random(2, 5), // Slightly larger particles
            color: `hsl(${Math.random() * 360}, 100%, 60%)`, // Brighter colors
            dx: random(-6, 6), // Faster initial spread
            dy: random(-6, 6),
            alpha: 1,
            gravity: 0.1 // Add a little gravity for a more realistic fall
        });
    }
    return particles;
}

let fireworks = [];

function animateFireworks() {
    fireworkCtx.clearRect(0, 0, fireworkCanvas.width, fireworkCanvas.height);
    fireworks.forEach((fw, index) => {
        fw.forEach(p => {
            p.x += p.dx;
            p.dy += p.gravity; // Apply gravity
            p.y += p.dy;
            p.alpha -= 0.025; // Fade out faster
            fireworkCtx.beginPath();
            fireworkCtx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
            fireworkCtx.fillStyle = `rgba(${p.color.match(/\d+/g).slice(0,3).join(",")},${p.alpha})`;
            fireworkCtx.fill();
        });
        fireworks[index] = fw.filter(p => p.alpha > 0);
    });
    fireworks = fireworks.filter(fw => fw.length > 0);
    requestAnimationFrame(animateFireworks);
}

animateFireworks(); // Start the firework animation loop

function triggerFirework(event) {
    // Trigger fireworks at the click position
    const x = event.clientX;
    const y = event.clientY;
    fireworks.push(createParticles(x, y));
}

// Add firework trigger to feedback cards on click
document.querySelectorAll('.feedback-card').forEach(card => {
    card.addEventListener('click', (event) => {
        triggerFirework(event); // Pass the event object to get click coordinates
    });
});

</script>
</body>
</html>

<?php
include("patientFooter.php");
?>
