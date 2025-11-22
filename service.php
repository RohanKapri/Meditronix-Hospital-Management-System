<?php
include('header.php');
?>

<?php
// PHP Error Reporting for Development
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Kolkata'); // Set timezone for accurate timestamps

// Database Connection
// IMPORTANT: In a production environment, avoid 'root' and empty passwords.
// Use environment variables or a secure configuration file.
$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Function to sanitize input data to prevent SQL injection and XSS
function sanitize_input($data) {
    global $db; // Access the global database connection
    $data = trim($data); // Remove whitespace from the beginning and end of string
    $data = stripslashes($data); // Remove backslashes
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Convert special characters to HTML entities, ensuring UTF-8
    return mysqli_real_escape_string($db, $data); // Escape special characters for SQL
}

// ------------ ADD SERVICE QUERY -----------------
if (isset($_POST['add_service'])) {
    $doctor_name = sanitize_input($_POST["doctor_name"]);
    $name = sanitize_input($_POST["name"]);
    $description = sanitize_input($_POST["description"]);
    $fee = floatval($_POST["fee"]);
    $status = 'active'; // Default status for new services
    $created_at = date('Y-m-d H:i:s'); // Current timestamp

    $insert_query = "INSERT INTO services (`doctor's_name`, name, description, fee, status, created_at) VALUES ('$doctor_name', '$name', '$description', '$fee', '$status', '$created_at')";

    if (mysqli_query($db, $insert_query)) {
        echo "<script>window.onload = function() { showCustomAlert('Service added successfully!', 'success'); }</script>";
    } else {
        echo "<script>window.onload = function() { showCustomAlert('Error adding service: " . mysqli_error($db) . "', 'error'); }</script>";
    }
}

// ------------ EDIT SERVICE QUERY -----------------
if (isset($_POST['edit_service'])) {
    $id = intval($_POST["id"]); // Ensure ID is an integer
    $doctor_name = sanitize_input($_POST["doctor_name"]);
    $name = sanitize_input($_POST["name"]);
    $description = sanitize_input($_POST["description"]);
    $fee = floatval($_POST["fee"]);
    $status = sanitize_input($_POST["status"]);

    $update_query = "UPDATE services SET `doctor's_name`='$doctor_name', name='$name', description='$description', fee='$fee', status='$status' WHERE id=$id";

    if (mysqli_query($db, $update_query)) {
        echo "<script>window.onload = function() { showCustomAlert('Service updated successfully!', 'success'); }</script>";
    } else {
        echo "<script>window.onload = function() { showCustomAlert('Error updating service: " . mysqli_error($db) . "', 'error'); }</script>";
    }
}

// ------------ DELETE SERVICE QUERY -----------------
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']); // Ensure ID is an integer
    $delete_query = "DELETE FROM services WHERE id=$deleteId";

    if (mysqli_query($db, $delete_query)) {
        echo "<script>window.onload = function() { showCustomAlert('Service deleted successfully!', 'success'); }</script>";
    } else {
        echo "<script>window.onload = function() { showCustomAlert('Error deleting service: " . mysqli_error($db) . "', 'error'); }</script>";
    }
}

// ------------ FETCH ALL SERVICES -----------------
$services_result = mysqli_query($db, "SELECT `id`, `doctor's_name`, `name`, `description`, `fee`, `status`, `created_at` FROM `services` WHERE 1 ORDER BY created_at DESC");

// Check if any service records were fetched
$services_count = mysqli_num_rows($services_result);

// Prepare dummy data if no service records are found in the database
$dummy_services_items = [];
if ($services_count === 0) {
    $dummy_services_items = [
        [
            'id' => 1,
            'doctor\'s_name' => 'Dr. Emily Watson',
            'name' => 'Cardiology Consultation',
            'description' => 'Comprehensive cardiac health assessment and personalized treatment plans.',
            'fee' => 1500.00,
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 month'))
        ],
        [
            'id' => 2,
            'doctor\'s_name' => 'Dr. John Smith',
            'name' => 'Pediatric Check-up',
            'description' => 'Routine health check-ups and vaccinations for infants, children, and adolescents.',
            'fee' => 800.00,
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s', strtotime('-2 months'))
        ],
        [
            'id' => 3,
            'doctor\'s_name' => 'Dr. Sarah Lee',
            'name' => 'Dermatology Treatment',
            'description' => 'Specialized care for skin conditions, including acne, eczema, and anti-aging solutions.',
            'fee' => 1200.00,
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 months'))
        ],
        [
            'id' => 4,
            'doctor\'s_name' => 'Dr. Michael Brown',
            'name' => 'Orthopedic Surgery',
            'description' => 'Advanced surgical procedures for bone and joint disorders, including rehabilitation.',
            'fee' => 50000.00,
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s', strtotime('-4 months'))
        ],
        [
            'id' => 5,
            'doctor\'s_name' => 'Dr. Jessica Green',
            'name' => 'Neurology Diagnosis',
            'description' => 'Diagnostic services for neurological conditions like migraines, epilepsy, and stroke.',
            'fee' => 2000.00,
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s', strtotime('-5 months'))
        ],
        [
            'id' => 6,
            'doctor\'s_name' => 'Dr. Robert White',
            'name' => 'Oncology Therapy',
            'description' => 'Personalized cancer treatment plans, including chemotherapy, radiation, and support.',
            'fee' => 75000.00,
            'status' => 'inactive', // Example of inactive status
            'created_at' => date('Y-m-d H:i:s', strtotime('-6 months'))
        ],
        [
            'id' => 7,
            'doctor\'s_name' => 'Dr. Olivia Kim',
            'name' => 'Gastroenterology Scope',
            'description' => 'Endoscopic procedures for diagnosing and treating digestive system disorders.',
            'fee' => 18000.00,
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s', strtotime('-7 months'))
        ]
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meditronix: Our Services</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome for modern icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    /*======================================================================
      GLOBAL STYLES & BASE LAYOUT
      Defines root variables for consistent theming, basic resets,
      and the overall page structure including the subtle rainbow background.
    ========================================================================*/
    :root {
        --primary-pink: #ff69b4; /* Hot Pink */
        --secondary-pink: #ffb6c1; /* Light Pink */
        --dark-pink: #c71585; /* Medium Violet Red */
        /* Light pastel rainbow colors for a softer, changing background */
        --pastel-color-1: #e0f7fa; /* Light Cyan */
        --pastel-color-2: #e8f5e9; /* Light Greenish Blue */
        --pastel-color-3: #f9fbe7; /* Light Yellowish Green */
        --pastel-color-4: #fce4ec; /* Light Pink */
        --pastel-color-5: #ede7f6; /* Light Purple */
        --text-color-dark: #222;
        --text-color-medium: #555;
        --text-color-light: #888;
        --card-bg-start: #ffe0f0; /* Very light pink */
        --card-bg-end: #ffc0d9;   /* Lighter pink */
        --card-border: rgba(255, 200, 220, 0.9); /* Pinkish border */
        --shadow-light: 0 15px 50px rgba(0,0,0,0.15); /* Enhanced shadow */
        --shadow-hover: 0 25px 70px rgba(0,0,0,0.3); /* More prominent hover shadow */
        --border-radius-xl: 35px; /* Even larger border radius */
        --padding-xl: 3.5rem; /* Even larger padding */
        --transition-speed: 0.6s; /* Slower, smoother transitions */
        --transition-ease: cubic-bezier(0.4, 0, 0.2, 1); /* Material Design-like ease */
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        /* Dynamic, flowing light rainbow background */
        background: linear-gradient(160deg, var(--pastel-color-1) 0%, var(--pastel-color-2) 20%, var(--pastel-color-3) 40%, var(--pastel-color-4) 60%, var(--pastel-color-5) 80%, var(--pastel-color-1) 100%);
        background-size: 500% 500%; /* Even larger size for more subtle and continuous motion */
        animation: bgGradientMotion 60s ease-in-out infinite alternate; /* Slower, more elegant bi-directional animation */
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
        max-width: 1900px; /* Max width for a very expansive layout */
        margin: 30px auto; /* Adjusted vertical margin */
        padding: 50px 30px; /* Increased padding */
        background: rgba(255, 255, 255, 0.75); /* More translucent wrapper background for depth */
        border-radius: var(--border-radius-xl);
        box-shadow: 0 30px 90px rgba(0,0,0,0.2); /* Stronger shadow */
        backdrop-filter: blur(20px); /* Stronger blur effect */
        border: 1px solid rgba(255,255,255,0.85); /* More prominent border */
        position: relative;
        z-index: 1;
        /* Adding subtle 3D tilt on hover for the entire wrapper */
        perspective: 1000px; /* Establishes a 3D context */
        transition: transform 0.8s var(--transition-ease), box-shadow 0.8s var(--transition-ease);
    }

    .main-wrapper:hover {
        transform: rotateY(0.7deg) rotateX(0.7deg) scale(1.007); /* Slight 3D tilt and scale */
        box-shadow: 0 40px 120px rgba(0,0,0,0.35);
    }

    /*======================================================================
      HEADER SECTION
      Styling for the main title and introductory paragraph.
    ========================================================================*/
    .header-section {
        text-align: center;
        margin-bottom: 80px; /* Increased margin */
        padding: 45px; /* Increased padding */
        background: rgba(255,255,255,0.98); /* Nearly opaque header background */
        border-radius: var(--border-radius-xl);
        box-shadow: 0 20px 70px rgba(0,0,0,0.3); /* Stronger shadow */
        backdrop-filter: blur(22px); /* Stronger blur */
        border: 1px solid rgba(255,255,255,0.95);
        animation: fadeIn 1.8s ease-out;
        position: relative; /* For potential future pseudo-elements or animations */
    }

    .header-section h1 {
        font-size: 5.8rem; /* Even larger, more impactful heading */
        background: linear-gradient(to right, #ff69b4, #ff1493, #ff4500, #ff00ff); /* Pink/Red/Magenta shimmer */
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shimmer 7s ease-in-out infinite, floatingHeading 8s ease-in-out infinite alternate; /* Slower, more elegant shimmer + floating */
        margin-bottom: 30px;
        font-weight: 900; /* Extra bold */
        letter-spacing: 4px; /* Increased letter spacing */
        text-shadow: 5px 5px 15px rgba(0,0,0,0.25); /* More pronounced text shadow */
        position: relative;
        display: inline-block; /* Required for text-shadow and background-clip to work well */
    }

    @keyframes shimmer {
        0%, 100% { background-position: -500% 0; }
        50% { background-position: 500% 0; }
    }

    @keyframes floatingHeading {
        0% { transform: translateY(0px) rotateX(0deg); }
        50% { transform: translateY(-10px) rotateX(1deg); } /* Subtle lift and tilt */
        100% { transform: translateY(0px) rotateX(0deg); }
    }

    .header-section p {
        font-size: 1.9rem; /* Larger intro text */
        color: var(--text-color-dark); /* Darker for better contrast */
        max-width: 1200px; /* Wider text block */
        margin: 0 auto;
        line-height: 2.1; /* Increased line height for readability */
        text-shadow: 1px 1px 5px rgba(0,0,0,0.15); /* Slightly stronger text shadow */
        animation: slideInUp 1.5s ease-out 0.5s forwards; /* Subtle animation for text */
        opacity: 0; /* Hidden initially */
    }

    @keyframes slideInUp {
        0% { transform: translateY(20px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }

    /*======================================================================
      CRUD SECTION (FORMS FOR ADD/EDIT/DELETE SERVICES)
      Styling for the forms to manage services.
    ========================================================================*/
    .crud-section {
        max-width: 1000px; /* Wider form section */
        margin: 60px auto;
        background: rgba(255, 255, 255, 0.95); /* Nearly opaque background */
        border-radius: var(--border-radius-xl);
        box-shadow: var(--shadow-light);
        padding: 50px; /* Increased padding */
        border: 1px solid var(--card-border);
        transition: all var(--transition-speed) var(--transition-ease);
    }

    .crud-section h2 {
        text-align: center;
        font-size: 3rem; /* Larger heading */
        color: var(--text-color-dark);
        margin-bottom: 40px; /* More space below heading */
        border-bottom: 3px solid rgba(0,0,0,0.15); /* Thicker border */
        padding-bottom: 20px;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
    }

    .crud-section h3 {
        text-align: center;
        font-size: 2.2rem; /* Sub-heading for forms */
        color: var(--primary-pink); /* Pink heading */
        margin-bottom: 30px;
        text-shadow: 1px 1px 2px rgba(255,105,180,0.1);
    }

    .crud-form-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Wider input fields */
        gap: 30px; /* More space between inputs */
        margin-bottom: 40px;
    }

    .crud-section input[type="text"],
    .crud-section input[type="number"],
    .crud-section textarea,
    .crud-section select {
        width: 100%;
        padding: 18px 25px; /* Larger padding for inputs */
        border: 1px solid rgba(0,0,0,0.15);
        border-radius: 20px; /* More rounded inputs */
        font-size: 1.2rem; /* Larger font in inputs */
        background: rgba(255,255,255,0.8); /* Slightly more opaque input background */
        transition: all 0.4s ease;
        box-shadow: inset 0 3px 8px rgba(0,0,0,0.08); /* Deeper inner shadow */
        color: var(--text-color-dark);
    }

    .crud-section input:focus,
    .crud-section textarea:focus,
    .crud-section select:focus {
        border-color: var(--secondary-pink); /* Highlight with secondary pink */
        box-shadow: 0 0 0 4px rgba(255,182,193,0.3); /* Stronger focus glow */
        outline: none;
    }

    .crud-section textarea {
        resize: vertical;
        min-height: 120px; /* Taller textarea */
        grid-column: 1 / -1; /* Make textarea span full width */
    }

    .crud-section button {
        padding: 18px 45px; /* Larger buttons */
        border: none;
        border-radius: 35px; /* More rounded buttons */
        background: linear-gradient(to right, #ff69b4, #ff1493); /* Pink gradient */
        color: #fff;
        cursor: pointer;
        box-shadow: 0 12px 30px rgba(0,0,0,0.2); /* Stronger shadow */
        transition: all 0.5s ease;
        font-size: 1.4rem; /* Larger button text */
        font-weight: 700;
        display: block;
        margin: 0 auto;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .crud-section button:hover {
        background: linear-gradient(to right, #ff1493, #ff69b4); /* Reverse pink gradient */
        transform: translateY(-5px) scale(1.02); /* More pronounced lift and scale */
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
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
        background-color: rgba(0,0,0,0.8); /* Darker, more opaque overlay */
        backdrop-filter: blur(15px); /* Stronger blur */
        animation: fadeIn 0.5s ease-out;
        justify-content: center;
        align-items: center;
    }

    .edit-modal-content {
        background-color: #fefefe;
        margin: auto; /* Center vertically and horizontally */
        padding: 60px; /* Larger padding */
        border: 1px solid #888;
        width: 90%;
        max-width: 800px; /* Wider modal */
        border-radius: var(--border-radius-xl);
        box-shadow: 0 30px 90px rgba(0,0,0,0.5);
        position: relative;
        animation: slideInTop 0.6s ease-out;
    }

    .edit-modal-content .close-button {
        color: #aaa;
        font-size: 3.5rem; /* Larger close button */
        font-weight: bold;
        position: absolute;
        top: 25px;
        right: 35px;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .edit-modal-content .close-button:hover,
    .edit-modal-content .close-button:focus {
        color: #333;
    }

    .edit-modal-content h2 {
        margin-bottom: 30px;
        font-size: 3rem;
        color: var(--text-color-dark);
        text-align: center;
    }

    /*======================================================================
      SERVICES CAROUSEL SECTION
      Styling for the service cards carousel, including auto-sliding and click effects.
    ========================================================================*/
    .services-carousel-section {
        overflow-x: hidden; /* Ensures no scrollbar */
        padding: 60px 0; /* More vertical padding */
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        position: relative;
        box-shadow: inset 0 0 30px rgba(0,0,0,0.12); /* Deeper inner shadow */
        border-radius: var(--border-radius-xl);
        background: rgba(255,255,255,0.9); /* Slightly more opaque background */
        border: 1px solid var(--card-border);
        /* Background image for services section */
        background-image: url('https://cdn.pixabay.com/photo/2024/07/23/16/15/ai-generated-8915742_1280.png'); /* Placeholder image for services background, now pinkish */
        background-size: cover;
        background-position: center;
        background-blend-mode: overlay; /* Blend with the semi-transparent background */
        animation: backgroundPan 90s linear infinite alternate; /* Slower, subtle pan effect */
        margin-bottom: 0 !important; /* Ensure no space below carousel */
    }

    @keyframes backgroundPan {
        0% { background-position: 0% 50%; }
        100% { background-position: 100% 50%; }
    }

    .services-carousel-track {
        display: flex;
        gap: 70px; /* Increased gap between cards */
        padding: 40px; /* Increased padding inside the track */
        min-width: fit-content; /* Allows content to exceed container width */
        transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Smooth transition for JS-controlled slide */
    }

    .service-card {
        flex: 0 0 600px; /* Significantly larger and fixed width for equal size */
        min-width: 600px; /* Ensures minimum width even if flex tries to shrink */
        height: 950px; /* Increased height for full icon visibility and more space */
        background: linear-gradient(145deg, var(--card-bg-start) 0%, var(--card-bg-end) 100%); /* Crystal light pink gradient */
        border-radius: var(--border-radius-xl);
        padding: var(--padding-xl);
        position: relative;
        box-shadow: 0 12px 35px rgba(255, 105, 180, 0.15), /* Soft pink shadow */
                    0 30px 90px rgba(0,0,0,0.2); /* General shadow */
        transition: transform var(--transition-speed) var(--transition-ease), box-shadow var(--transition-speed) var(--transition-ease), background var(--transition-speed) var(--transition-ease);
        overflow: hidden;
        border: 3px solid rgba(255, 105, 180, 0.4); /* More prominent pink border */
        cursor: pointer;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        z-index: 5; /* Ensure cards are above effects */
        transform-style: preserve-3d; /* Enable 3D transformations for children */
        perspective: 1000px; /* For 3D effect */
    }

    .service-card:hover {
        transform: translateY(-30px) scale(1.08) rotateX(2.5deg) rotateY(2.5deg); /* More dramatic hover effect with 3D tilt */
        box-shadow: 0 18px 45px rgba(255, 105, 180, 0.25), /* Enhanced pink shadow */
                    0 40px 110px rgba(0,0,0,0.4); /* More prominent general shadow */
        background: linear-gradient(145deg, #fff5fa 0%, #ffebf5 100%); /* Slightly brighter crystal pink on hover */
    }

    /* Glittering Shine Effect on click (Shining Blade) */
    .service-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -400%; /* Start even farther off-screen to the left */
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 240, 245, 1), transparent); /* Super bright pinkish shine, fully opaque */
        transform: skewX(-45deg); /* More angled "blade" */
        transition: left 1.8s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Slower, smoother transition */
        pointer-events: none;
        z-index: 10;
        opacity: 0; /* Hidden by default */
    }
    .service-card.clicked::before {
        left: 400%; /* Slide across to the right */
        opacity: 1; /* Make visible when clicked */
        animation: glitterShineBlade 1.8s forwards; /* Animation for the shine */
    }
    @keyframes glitterShineBlade {
        0% { left: -400%; opacity: 0; }
        50% { left: 0%; opacity: 1; }
        100% { left: 400%; opacity: 0; }
    }

    /* Crystal Water Effect on click (Expanding Radial Gradient) - Waterfall-like */
    .service-card::after {
        content: '';
        position: absolute;
        top: var(--mouse-y, 50%);
        left: var(--mouse-x, 50%);
        width: 0;
        height: 0;
        border-radius: 50%;
        background: radial-gradient(circle at center, rgba(255, 105, 180, 0.8), transparent 85%); /* Brighter, more expansive pink water ripple */
        opacity: 0;
        transform: translate(-50%, -50%);
        transition: width 1.5s ease-out, height 1.5s ease-out, opacity 1.5s ease-out; /* Slower, more fluid expansion */
        pointer-events: none;
        z-index: 9;
        box-shadow: 0 0 60px 25px rgba(255, 105, 180, 0.6); /* Stronger glowing effect for water */
    }
    .service-card.clicked::after {
        width: 500%; /* Expand significantly */
        height: 500%;
        opacity: 1;
    }

    .service-icon-container {
        width: 140px; /* Ensure equal width and height for perfect circle */
        height: 140px;
        background: linear-gradient(135deg, var(--primary-pink), var(--dark-pink)); /* Pink gradient for icon */
        border-radius: 50%; /* Ensure it's a perfect circle */
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 5rem; /* Larger icon font */
        margin: 0 auto 45px; /* More margin */
        box-shadow: 0 20px 45px rgba(255,105,180,0.9); /* Stronger pink shadow */
        transition: transform 0.9s cubic-bezier(0.68, -0.55, 0.27, 1.55); /* Springy animation */
        position: relative;
        overflow: hidden; /* Ensure content inside is clipped if it overflows */
        flex-shrink: 0; /* Prevent shrinking in flex container */
    }
    .service-icon-container::before {
        content: '';
        position: absolute;
        top: -90%;
        left: -90%;
        width: 280%;
        height: 280%;
        background: radial-gradient(circle at center, rgba(255,255,255,0.7), transparent 90%);
        animation: iconPulse 7s infinite alternate; /* Slower pulsing glow */
    }
    @keyframes iconPulse {
        0% { transform: scale(0.4); opacity: 0.9; }
        100% { transform: scale(1.6); opacity: 1; }
    }

    .service-card:hover .service-icon-container {
        transform: rotate(40deg) scale(1.4); /* More dramatic rotate and scale */
    }

    .service-card h4 {
        font-size: 3.2rem; /* Larger title */
        color: var(--text-color-dark);
        margin-bottom: 18px;
        font-weight: 900;
        text-shadow: 1px 1px 6px rgba(0,0,0,0.25);
        text-align: center; /* Centered */

        /* Glitter effect for service name */
        background: linear-gradient(90deg, #fefefe, #ffd700, #fefefe, #ffd700, #fefefe); /* Gold shimmer */
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: 400% 100%; /* Larger background size for more prominent shimmer */
        animation: textShine 6s linear infinite; /* Slower animation */
    }

    .service-card h5 {
        font-size: 2.4rem; /* Larger doctor name/sub-title */
        color: var(--primary-pink); /* Pink color for doctor name */
        margin-bottom: 35px;
        font-weight: 800; /* More bold */
        text-shadow: 1px 1px 4px rgba(0,0,0,0.15);
        text-align: center; /* Centered */

        /* Glitter effect for doctor name */
        background: linear-gradient(90deg, #ffe0f0, #ffb6c1, #ffe0f0, #ffb6c1, #ffe0f0); /* Light pink shimmer */
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: 400% 100%; /* Larger background size for more prominent shimmer */
        animation: textShine 6s linear infinite reverse; /* Reverse animation for contrast */
    }

    @keyframes textShine {
        0% { background-position: 400% 0; }
        100% { background-position: -400% 0; }
    }

    .service-card p {
        color: var(--text-color-medium);
        font-size: 1.5rem; /* Larger text */
        margin-bottom: 18px;
        line-height: 1.9;
        text-align: left; /* Align details to left for readability */
        display: flex; /* Use flex for icon alignment */
        align-items: center; /* Vertically align icon and text */
        gap: 20px; /* Space between icon and text */
        padding-left: 25px; /* Indent details slightly */
        position: relative; /* For icon styling */
    }

    .service-card p strong {
        color: var(--text-color-dark);
        font-weight: 700;
    }

    .service-card p i {
        color: var(--primary-pink); /* Pink icon color */
        font-size: 1.8rem; /* Larger icon size */
        min-width: 35px; /* Ensure consistent spacing */
        text-shadow: 0.8px 0.8px 3px rgba(255,105,180,0.4); /* Icon shadow */
    }

    /* Social Links within each card */
    .card-social-links {
        display: flex;
        justify-content: center; /* Center the social icons */
        gap: 25px; /* Space between icons */
        margin-top: 30px; /* Space from content above */
        padding-top: 20px;
        border-top: 1px dashed rgba(0,0,0,0.1); /* Subtle separator */
    }

    .card-social-links a {
        color: var(--primary-pink); /* Default icon color, now pink */
        font-size: 2.5rem; /* Large social icons */
        transition: transform 0.3s ease, color 0.3s ease, text-shadow 0.3s ease;
        text-decoration: none; /* Remove underline */
    }

    .card-social-links a:hover {
        transform: translateY(-5px) scale(1.1); /* Lift and slightly enlarge on hover */
    }

    /* Specific colors for social icons on hover */
    .card-social-links a.linkedin:hover { color: #0077B5; text-shadow: 0 0 15px rgba(0,119,181,0.6); }
    .card-social-links a.youtube:hover { color: #FF0000; text-shadow: 0 0 15px rgba(255,0,0,0.6); }
    .card-social-links a.instagram:hover {
        background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 15px rgba(214,36,159,0.6);
    }
    .card-social-links a.wikipedia:hover { color: #000; text-shadow: 0 0 15px rgba(0,0,0,0.6); }

    /* Action buttons for edit/delete within cards */
    .service-actions {
        margin-top: 25px;
        text-align: center;
        padding-top: 15px;
        border-top: 1px solid rgba(0,0,0,0.08);
    }

    .service-actions button {
        padding: 10px 20px;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-size: 1.1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 0 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .service-actions .btn-edit {
        background: linear-gradient(to right, #ff69b4, #ff1493); /* Pink edit button */
        color: #fff;
    }
    .service-actions .btn-edit:hover {
        background: linear-gradient(to right, #ff1493, #ff69b4);
        transform: translateY(-3px);
        box-shadow: 0 7px 18px rgba(0,0,0,0.15);
    }

    .service-actions .btn-delete {
        background: linear-gradient(to right, #dc3545, #c82333); /* Red delete button */
        color: #fff;
    }
    .service-actions .btn-delete:hover {
        background: linear-gradient(to right, #c82333, #dc3545);
        transform: translateY(-3px);
        box-shadow: 0 7px 18px rgba(0,0,0,0.15);
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
        background-color: rgba(0,0,0,0.75); /* Darker overlay */
        backdrop-filter: blur(12px);
        animation: fadeIn 0.5s ease-out;
        justify-content: center;
        align-items: center;
    }

    .custom-modal-content {
        background-color: #fefefe;
        margin: auto; /* Center vertically and horizontally */
        padding: 60px; /* Even larger padding */
        border: 1px solid #888;
        width: 90%;
        max-width: 700px; /* Larger max width */
        border-radius: var(--border-radius-xl);
        box-shadow: 0 30px 90px rgba(0,0,0,0.5);
        position: relative;
        animation: slideInTop 0.6s ease-out;
        text-align: center;
    }

    .custom-modal-content .close-button {
        color: #aaa;
        font-size: 3.5rem; /* Larger close button */
        font-weight: bold;
        position: absolute;
        top: 25px;
        right: 35px;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .custom-modal-content .close-button:hover,
    .custom-modal-content .close-button:focus {
        color: #333;
    }

    .custom-modal-content h3 {
        margin-bottom: 30px;
        font-size: 3rem;
        color: var(--text-color-dark);
    }

    .custom-modal-content p {
        margin-bottom: 40px;
        font-size: 1.4rem;
        line-height: 1.8;
    }

    .custom-modal-content .modal-buttons button {
        padding: 15px 35px;
        border: none;
        border-radius: 30px;
        cursor: pointer;
        font-size: 1.2rem;
        font-weight: 700;
        transition: background 0.4s ease, transform 0.3s ease;
        margin: 0 20px;
    }

    .custom-modal-content .modal-buttons .btn-ok {
        background: linear-gradient(to right, #28a745, #218838);
        color: #fff;
    }
    .custom-modal-content .modal-buttons .btn-ok:hover {
        background: linear-gradient(to right, #218838, #28a745);
        transform: translateY(-4px);
    }

    .custom-modal-content .modal-buttons .btn-cancel {
        background: linear-gradient(to right, #dc3545, #c82333);
        color: #fff;
    }
    .custom-modal-content .modal-buttons .btn-cancel:hover {
        background: linear-gradient(to right, #c82333, #dc3545);
        transform: translateY(-4px);
    }

    /* Specific styling for the initial "Welcome" popup */
    #popup-message {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        background: linear-gradient(45deg, #ff9a9e 0%, #fad0c4 99%, #fad0c4 100%);
        padding: 60px 90px; /* Larger padding */
        border-radius: var(--border-radius-xl);
        font-size: 3.5rem; /* Larger text */
        color: #fff;
        text-shadow: 1px 1px 8px rgba(0,0,0,0.6);
        box-shadow: 0 0 50px rgba(255,154,158,1); /* Stronger shadow */
        opacity: 0;
        transition: transform 1s cubic-bezier(0.68, -0.55, 0.27, 1.55), opacity 1s ease;
        z-index: 2000; /* Highest z-index */
        border: 6px solid rgba(255,255,255,1);
        font-weight: bold;
        letter-spacing: 3px;
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
        padding-top: 80px; /* More padding */
        border-top: 1px solid rgba(0,0,0,0.4); /* More visible border */
        padding-bottom: 60px;
    }
    .footer-social-links a {
        margin: 0 40px; /* Increased spacing */
        color: var(--primary-pink); /* Pink footer links */
        font-size: 3.5rem; /* Larger icons */
        text-decoration: none;
        transition: color 0.6s ease, transform 0.6s ease, text-shadow 0.6s ease;
    }
    .footer-social-links a:hover {
        transform: translateY(-15px) scale(1.5); /* More lift */
        color: var(--dark-pink);
        text-shadow: 0 12px 25px rgba(255,105,180,0.6);
    }

    footer {
        text-align: center;
        margin-top: 0 !important; /* IMPORTANT: Remove all space above footer */
        padding: 40px 0;
        border-top: 1px dashed rgba(0,0,0,0.25);
        color: var(--text-color-light);
        font-size: 1.2rem;
    }

    /*======================================================================
      RESPONSIVE DESIGN
      Media queries for optimal viewing on various screen sizes.
    ========================================================================*/
    @media (max-width: 1800px) {
        .main-wrapper {
            max-width: 1600px;
        }
        .service-card {
            flex: 0 0 500px;
            min-width: 500px;
            height: 850px; /* Adjusted height */
        }
    }

    @media (max-width: 1400px) {
        .main-wrapper {
            max-width: 1200px;
            padding: 40px 25px;
        }
        .header-section h1 {
            font-size: 4.5rem;
        }
        .header-section p {
            font-size: 1.6rem;
        }
        .service-card {
            flex: 0 0 450px;
            min-width: 450px;
            padding: 3rem;
            height: 800px; /* Adjusted height */
        }
        .service-icon-container {
            width: 110px;
            height: 110px;
            font-size: 3.5rem;
        }
        .service-card h4 {
            font-size: 2rem;
        }
        .service-card h5 {
            font-size: 1.4rem;
        }
        .service-card p {
            font-size: 1.1rem;
        }
        .services-carousel-track {
            gap: 50px;
            padding: 30px;
        }
        .footer-social-links a {
            font-size: 3rem;
            margin: 0 30px;
        }
    }

    @media (max-width: 1024px) {
        .main-wrapper {
            max-width: 960px;
            margin: 25px auto;
            padding: 30px 20px;
        }
        .header-section {
            margin-bottom: 60px;
            padding: 35px;
        }
        .header-section h1 {
            font-size: 3.8rem;
            letter-spacing: 2px;
        }
        .header-section p {
            font-size: 1.3rem;
        }
        .crud-section {
            max-width: 700px;
            padding: 40px;
        }
        .crud-section h2 {
            font-size: 2.5rem;
        }
        .crud-section h3 {
            font-size: 1.8rem;
        }
        .crud-form-group {
            grid-template-columns: 1fr; /* Stack inputs on smaller tablets */
        }
        .crud-section input, .crud-section textarea, .crud-section select {
            padding: 15px 20px;
            font-size: 1.1rem;
        }
        .crud-section button {
            padding: 15px 35px;
            font-size: 1.2rem;
        }
        .service-card {
            flex: 0 0 400px; /* Adjust for smaller screens */
            min-width: 400px;
            padding: 2.5rem;
            height: 750px; /* Adjusted height */
        }
        .services-carousel-track {
            justify-content: flex-start;
            padding-left: 15px;
            padding-right: 15px;
            gap: 40px;
        }
        .service-icon-container {
            width: 100px;
            height: 100px;
            font-size: 3.2rem;
            margin-bottom: 30px;
        }
        .service-card h4 {
            font-size: 1.8rem;
        }
        .service-card h5 {
            font-size: 1.3rem;
        }
        .service-card p {
            font-size: 1rem;
            line-height: 1.6;
        }
        .footer-social-links {
            padding-top: 60px;
            padding-bottom: 40px;
        }
        .footer-social-links a {
            font-size: 2.5rem;
            margin: 0 25px;
        }
        .custom-modal-content {
            padding: 40px;
        }
        .custom-modal-content h3 {
            font-size: 2.5rem;
        }
        .custom-modal-content p {
            font-size: 1.2rem;
        }
        #popup-message {
            padding: 40px 60px;
            font-size: 3rem;
        }
    }

    @media (max-width: 768px) {
        body {
            padding: 10px 0;
        }
        .main-wrapper {
            padding: 20px 15px;
            margin: 15px auto;
        }
        .header-section {
            padding: 25px;
            margin-bottom: 40px;
        }
        .header-section h1 {
            font-size: 3rem;
            letter-spacing: 1px;
        }
        .header-section p {
            font-size: 1.1rem;
        }
        .crud-section {
            padding: 30px;
        }
        .crud-section h2 {
            font-size: 2.2rem;
        }
        .crud-section h3 {
            font-size: 1.6rem;
        }
        .crud-section input, .crud-section textarea, .crud-section select {
            padding: 12px 18px;
            font-size: 1rem;
        }
        .crud-section button {
            padding: 12px 30px;
            font-size: 1.1rem;
        }
        .service-card {
            flex: 0 0 95%; /* Take up almost full width on mobile */
            min-width: 300px; /* Ensure it doesn't get too small */
            margin: 0 auto; /* Center cards */
            padding: 2rem;
            height: 700px; /* Adjusted height */
        }
        .services-carousel-track {
            gap: 30px;
            padding-left: 10px;
            padding-right: 10px;
        }
        .service-icon-container {
            width: 80px;
            height: 80px;
            font-size: 2.8rem;
            margin-bottom: 25px;
        }
        .service-card h4 {
            font-size: 1.6rem;
        }
        .service-card h5 {
            font-size: 1.2rem;
        }
        .service-card p {
            font-size: 0.95rem;
            line-height: 1.5;
        }
        .footer-social-links {
            padding-top: 50px;
            padding-bottom: 35px;
        }
        .footer-social-links a {
            font-size: 2.2rem;
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
            font-size: 2.5rem;
            padding: 30px 50px;
        }
    }

    @media (max-width: 480px) {
        .header-section h1 {
            font-size: 2.2rem;
        }
        .header-section p {
            font-size: 0.9rem;
        }
        .crud-section {
            padding: 25px;
        }
        .crud-section h2 {
            font-size: 1.8rem;
        }
        .crud-section h3 {
            font-size: 1.4rem;
        }
        .crud-section input, .crud-section textarea, .crud-section select {
            padding: 10px 15px;
            font-size: 0.9rem;
        }
        .crud-section button {
            padding: 10px 25px;
            font-size: 1rem;
        }
        .service-card {
            padding: 1.5rem;
            flex: 0 0 98%;
            min-width: 280px;
            height: 650px; /* Adjusted height */
        }
        .service-icon-container {
            width: 70px;
            height: 70px;
            font-size: 2.5rem;
        }
        .service-card h4 {
            font-size: 1.4rem;
        }
        .service-card h5 {
            font-size: 1.1rem;
        }
        .service-card p {
            font-size: 0.85rem;
        }
        .services-carousel-track {
            gap: 20px;
            padding-left: 5px;
            padding-right: 5px;
        }
        .footer-social-links {
            padding-top: 40px;
            padding-bottom: 25px;
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
    </style>
</head>
<body>

<div class="main-wrapper">
    <!-- Header Section -->
    <div class="header-section">
        <h1><i class="fas fa-stethoscope" style="margin-right: 20px; color: #ff69b4;"></i>Meditronix: Our Comprehensive Healthcare Services<i class="fas fa-hospital-alt" style="margin-left: 20px; color: #ff1493;"></i></h1>
        <p>At Meditronix, we are dedicated to providing a wide array of high-quality healthcare services, tailored to meet the diverse needs of our patients. From specialized consultations to advanced treatments, our expert team is equipped with the latest technology and a compassionate approach to ensure your well-being. Explore our offerings below, each designed with your health and comfort in mind. We continuously update our services to bring you the best in modern medicine.</p>
    </div>

    <!-- CRUD Section (Forms for Add/Edit Services) -->
    <div class="crud-section">
        <h2>Manage Our Services</h2>
        <!-- Add New Service Form -->
        <form method="post" action="">
            <input type="hidden" name="action" value="add_service">
            <h3>Add New Service</h3>
            <div class="crud-form-group">
                <input type="text" name="doctor_name" placeholder="Doctor's Name" required>
                <input type="text" name="name" placeholder="Service Name" required>
                <textarea name="description" placeholder="Service Description" required></textarea>
                <input type="number" name="fee" placeholder="Service Fee (e.g., 1500.00)" step="0.01" required>
            </div>
            <button type="submit" name="add_service">Add Service</button>
        </form>

        <!-- Edit Service Modal (Hidden by default, shown by JS) -->
        <div id="editServiceModal" class="custom-modal">
            <div class="custom-modal-content">
                <span class="close-button" onclick="closeEditModal()">&times;</span>
                <h2>Edit Service</h2>
                <form id="editServiceForm" method="post" action="">
                    <input type="hidden" name="action" value="edit_service">
                    <input type="hidden" id="editServiceId" name="id">
                    <div class="crud-form-group">
                        <input type="text" id="editDoctorName" name="doctor_name" placeholder="Doctor's Name" required>
                        <input type="text" id="editServiceName" name="name" placeholder="Service Name" required>
                        <textarea id="editServiceDescription" name="description" placeholder="Service Description" required></textarea>
                        <input type="number" id="editServiceFee" name="fee" placeholder="Service Fee" step="0.01" required>
                        <select id="editServiceStatus" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" name="edit_service">Update Service</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Services Carousel Section -->
    <div class="services-carousel-section" id="servicesCarouselContainer">
        <h2 style="text-align: center; font-size: 2.8rem; color: var(--text-color-dark); margin-bottom: 40px; text-shadow: 1px 1px 2px rgba(0,0,0,0.05);">Explore Our Offerings</h2>
        <div class="services-carousel-track" id="servicesCarouselTrack">
            <?php
            // If no services from DB, use dummy data
            if ($services_count === 0) {
                $current_services_items = $dummy_services_items;
            } else {
                // Reset pointer for services_result to ensure all services are displayed
                mysqli_data_seek($services_result, 0);
                $current_services_items = [];
                while ($row = mysqli_fetch_assoc($services_result)) {
                    $current_services_items[] = $row;
                }
            }

            // Define a set of relevant icons to cycle through for services
            $service_icons = [
                'fas fa-heartbeat',        // Cardiology
                'fas fa-child',            // Pediatrics
                'fas fa-hand-sparkles',    // Dermatology
                'fas fa-bone',             // Orthopedics
                'fas fa-brain',            // Neurology
                'fas fa-microscope',       // Oncology
                'fas fa-lungs',            // Pulmonology
                'fas fa-tooth',            // Dentistry
                'fas fa-eye',              // Ophthalmology
                'fas fa-ear-listen',       // ENT
                'fas fa-syringe',          // Vaccinations/General
                'fas fa-x-ray',            // Radiology
                'fas fa-dna',              // Genetics
                'fas fa-medkit',           // First Aid/Emergency
                'fas fa-notes-medical'     // General Consultation
            ];

            $icon_index = 0; // To cycle through icons
            foreach ($current_services_items as $service_item) {
                // Get a specific icon from the array and increment index
                $current_icon = $service_icons[$icon_index % count($service_icons)];
                $icon_index++;
            ?>
            <div class="service-card"
                 data-service-id="<?= htmlspecialchars($service_item['id']); ?>"
                 data-doctor-name="<?= htmlspecialchars($service_item['doctor\'s_name']); ?>"
                 data-service-name="<?= htmlspecialchars($service_item['name']); ?>"
                 data-description="<?= htmlspecialchars($service_item['description']); ?>"
                 data-fee="<?= htmlspecialchars($service_item['fee']); ?>">
                <div class="service-icon-container"><i class="<?= $current_icon; ?>"></i></div>
                <h4><?= htmlspecialchars($service_item['name']) ?></h4>
                <h5>By: <?= htmlspecialchars($service_item['doctor\'s_name']) ?></h5>
                <p><i class="fas fa-id-badge"></i><strong>Service ID:</strong> <?= htmlspecialchars($service_item['id']) ?></p>
                <p><i class="fas fa-file-alt"></i><strong>Description:</strong> <?= htmlspecialchars($service_item['description']) ?></p>
                <p><i class="fas fa-rupee-sign"></i><strong>Fee:</strong> ₹<?= number_format($service_item['fee'], 2) ?></p>
                <!-- Removed Status line as per request -->
                <p><i class="fas fa-calendar-plus"></i><strong>Added On:</strong> <?= date('d M Y', strtotime($service_item['created_at'])) ?></p>

                <!-- Social Links for each service card -->
                <div class="card-social-links">
                    <a href="https://www.linkedin.com/company/google/" target="_blank" class="linkedin" title="Share on LinkedIn"><i class="fab fa-linkedin"></i></a>
                    <a href="https://www.youtube.com/Google" target="_blank" class="youtube" title="Watch on YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="https://www.instagram.com/google/" target="_blank" class="instagram" title="Follow on Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://en.wikipedia.org/wiki/Health_care" target="_blank" class="wikipedia" title="Learn more on Wikipedia"><i class="fab fa-wikipedia-w"></i></a>
                </div>

                <!-- Action buttons for Edit and Delete -->
                <div class="service-actions">
                    <button class="btn-edit" onclick="event.stopPropagation(); openEditModal(this)">Edit</button>
                    <button class="btn-delete" onclick="event.stopPropagation(); deleteService(<?= $service_item['id']; ?>)">Delete</button>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Custom Popup Message (for alerts/success/error) -->
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

<!-- Custom Confirm Modal (for delete confirmation) -->
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

<!-- Initial "Welcome" popup -->
<div id="popup-message">✨ Welcome to Meditronix Services! ✨<br><center>Excellence in Every Offering.</center></div>
<canvas id="fireworkCanvas"></canvas>

<!-- Social Links for the footer -->
<div class="footer-social-links">
    <a href="https://www.facebook.com/Google" target="_blank" title="Visit our Facebook"><i class="fab fa-facebook-f"></i></a>
    <a href="https://twitter.com/Google" target="_blank" title="Visit our Twitter"><i class="fab fa-twitter"></i></a>
    <a href="https://www.instagram.com/google/" target="_blank" title="Visit our Instagram"><i class="fab fa-instagram"></i></a>
    <a href="https://www.linkedin.com/company/google/" target="_blank" title="Visit our LinkedIn"><i class="fab fa-linkedin-in"></i></a>
    <a href="https://www.youtube.com/Google" target="_blank" title="Visit our YouTube"><i class="fab fa-youtube"></i></a>
    <a href="https://github.com/Google" target="_blank" title="Visit our GitHub"><i class="fab fa-github"></i></a>
</div>

<footer>
    &copy; <?php echo date("Y"); ?> Meditronix. All rights reserved. Pioneering healthcare insights for a healthier tomorrow. Designed with <span style="color: #e25555;">&hearts;</span> for Rohan Kapri.
</footer>

<script>
//======================================================================
// JAVASCRIPT FUNCTIONS & INTERACTIVITY
// This section handles all dynamic behaviors, including popup messages,
// click effects on cards, and the carousel auto-sliding.
//======================================================================

// --- Custom Alert Modals ---
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

// --- Custom Confirm Modals ---
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

// --- Service Card Interactions (Glitter and Water effects) ---
document.querySelectorAll('.service-card').forEach(card => {
    card.addEventListener('click', (event) => {
        // Prevent triggering the card effect if a social link or action button was clicked
        if (event.target.closest('.card-social-links a') || event.target.closest('.service-actions button')) {
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
        }, 1200); // Matches the CSS transition duration for the glitter effect
    });
});

// --- CRUD Modals and Operations for Services ---

// Function to open the Edit Service Modal and populate it with data
function openEditModal(button) {
    const card = button.closest('.service-card');
    const serviceId = card.dataset.serviceId;
    const doctorName = card.dataset.doctorName;
    const serviceName = card.dataset.serviceName;
    const description = card.dataset.description;
    const fee = card.dataset.fee;
    const status = card.dataset.status; // Still need status for the edit modal

    document.getElementById('editServiceId').value = serviceId;
    document.getElementById('editDoctorName').value = doctorName;
    document.getElementById('editServiceName').value = serviceName;
    document.getElementById('editServiceDescription').value = description;
    document.getElementById('editServiceFee').value = fee;
    document.getElementById('editServiceStatus').value = status;

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
// CAROUSEL AUTO-SLIDING FEATURE (BI-DIRECTIONAL "TRAIN" MOVEMENT)
// This section controls the automatic, smooth, back-and-forth scrolling
// of the service cards carousel.
//======================================================================
const servicesCarouselContainer = document.getElementById('servicesCarouselContainer');
const servicesCarouselTrack = document.getElementById('servicesCarouselTrack');
const servicesCards = document.querySelectorAll('.service-card');

let currentScroll = 0;
let scrollDirection = 1; // 1 for right, -1 for left
let carouselAnimationFrameId;
const scrollSpeed = 2.0; // Slightly slower speed for smoother auto-sliding
const pauseAtEndDuration = 3000; // Longer pause duration at the end/start of the track

function animateServicesCarousel() {
    // Calculate the total width of the track including gaps
    const trackWidth = servicesCarouselTrack.scrollWidth;
    // Calculate the visible width of the container
    const containerWidth = servicesCarouselContainer.clientWidth;
    // Calculate the maximum scrollable distance
    const maxScrollLeft = trackWidth - containerWidth;

    // If there are no cards or the content is smaller than the container, stop animation
    if (servicesCards.length === 0 || maxScrollLeft <= 0) {
        cancelAnimationFrame(carouselAnimationFrameId);
        return;
    }

    currentScroll += scrollDirection * scrollSpeed;

    // Check if we've reached the end (scrolling right)
    if (scrollDirection === 1 && currentScroll >= maxScrollLeft) {
        currentScroll = maxScrollLeft; // Cap at max scroll
        scrollDirection = -1; // Change direction to left
        // Add a pause before reversing direction
        cancelAnimationFrame(carouselAnimationFrameId);
        setTimeout(() => {
            carouselAnimationFrameId = requestAnimationFrame(animateServicesCarousel);
        }, pauseAtEndDuration);
    }
    // Check if we've reached the beginning (scrolling left)
    else if (scrollDirection === -1 && currentScroll <= 0) {
        currentScroll = 0; // Cap at min scroll
        scrollDirection = 1; // Change direction to right
        // Add a pause before reversing direction
        cancelAnimationFrame(carouselAnimationFrameId);
        setTimeout(() => {
            carouselAnimationFrameId = requestAnimationFrame(animateServicesCarousel);
        }, pauseAtEndDuration);
    }

    // Apply the transform to the track to simulate scrolling
    servicesCarouselTrack.style.transform = `translateX(-${currentScroll}px)`;

    // Continue animation if not paused
    if (carouselAnimationFrameId) { // Ensure it's not cancelled
        carouselAnimationFrameId = requestAnimationFrame(animateServicesCarousel);
    }
}

// Start auto-scrolling when the page loads
window.addEventListener('load', () => {
    carouselAnimationFrameId = requestAnimationFrame(animateServicesCarousel);
});

// Pause scrolling on hover over the carousel
servicesCarouselContainer.addEventListener('mouseover', () => {
    cancelAnimationFrame(carouselAnimationFrameId);
    carouselAnimationFrameId = null; // Explicitly set to null when paused
});

servicesCarouselContainer.addEventListener('mouseout', () => {
    if (!carouselAnimationFrameId) { // Only restart if it was paused
        carouselAnimationFrameId = requestAnimationFrame(animateServicesCarousel);
    }
});

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
    for (let i = 0; i < 70; i++) { // More particles for a denser effect
        particles.push({
            x,
            y,
            radius: random(2.5, 5.5), // Slightly larger particles
            color: `hsl(${Math.random() * 360}, 100%, 65%)`, // Brighter colors
            dx: random(-7, 7), // Faster initial spread
            dy: random(-7, 7),
            alpha: 1,
            gravity: 0.15 // Add a little more gravity for a more realistic fall
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
            p.y += p.dy;
            p.dy += p.gravity; // Apply gravity
            p.alpha -= 0.03; // Fade out faster
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

// Add firework trigger to service cards on click
document.querySelectorAll('.service-card').forEach(card => {
    card.addEventListener('click', (event) => {
        // Only trigger firework if not clicking on a social link or action button
        if (!event.target.closest('.card-social-links a') && !event.target.closest('.service-actions button')) {
            triggerFirework(event); // Pass the event object to get click coordinates
        }
    });
});

</script>
</body>
</html>


<?php include("footer.php"); ?>
