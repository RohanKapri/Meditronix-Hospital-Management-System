<?php include('header.php'); ?>

<?php
// PHP Error Reporting for Development
// This ensures that all PHP errors are displayed, which is helpful for debugging during development.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the default timezone to Asia/Kolkata for consistent date and time handling.
date_default_timezone_set('Asia/Kolkata');

// Database Connection
// Establishes a connection to the MySQL database.
// Parameters: host (localhost), username (root), password (empty), database name (meditronix_new).
// IMPORTANT: In a production environment, 'root' and an empty password are highly insecure.
// Always use strong, unique credentials and consider environment variables or secure configuration files.
$db = mysqli_connect("localhost", "root", "", "meditronix_new");

// Check if the database connection was successful.
if (!$db) {
    // If connection fails, terminate the script and display an error message.
    die("Database connection failed: " . mysqli_connect_error());
}

/**
 * Function to sanitize input data.
 * This function helps prevent SQL injection and Cross-Site Scripting (XSS) attacks.
 * It trims whitespace, removes backslashes, converts special characters to HTML entities,
 * and escapes special characters for use in SQL statements.
 *
 * @param string $data The input string to sanitize.
 * @return string The sanitized string.
 */
function sanitize_input($data) {
    global $db; // Access the global database connection variable.
    $data = trim($data); // Remove whitespace from the beginning and end of the string.
    $data = stripslashes($data); // Remove backslashes added by functions like addslashes().
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Convert special characters to HTML entities, ensuring UTF-8 encoding for security.
    return mysqli_real_escape_string($db, $data); // Escape special characters for SQL to prevent SQL injection.
}

// ------------ BACKEND CRUD OPERATIONS (NOT DISPLAYED ON FRONT-END) -----------------
// These operations are handled on the server-side but do not have visible buttons
// or direct user interaction on this specific front-end page, as requested.

/**
 * Handle Add Feedback operation.
 * This block executes when a POST request with 'add_feedback' is received.
 * It sanitizes input, constructs an SQL INSERT query, and attempts to add a new feedback record.
 */
if (isset($_POST['add_feedback'])) {
    // Sanitize and validate input data for the new feedback.
    $patient_id = sanitize_input($_POST['patient_id']);
    $patients_name = sanitize_input($_POST['patients_name']); // Added patients' _name
    $message = sanitize_input($_POST['message']);
    $rating = intval($_POST['rating']); // Convert to integer for safety.
    $status = sanitize_input($_POST['status']);
    $created_at = date('Y-m-d H:i:s'); // Get the current server timestamp.

    // SQL INSERT query to add a new feedback record to the `feedback` table.
    // Note: `patients' _name` needs to be escaped with backticks due to the space and apostrophe.
    $insert_query = "INSERT INTO `feedback` (`patient_id`, `patients' _name`, `message`, `rating`, `status`, `created_at`) VALUES ('$patient_id', '$patients_name', '$message', $rating, '$status', '$created_at')";

    // Execute the query and check for success or failure.
    if (mysqli_query($db, $insert_query)) {
        // Success message for backend operation (commented out as no front-end display).
        // echo "<script>window.onload = function() { showCustomAlert('Feedback added successfully!', 'success'); }</script>";
    } else {
        // Error message for backend operation (commented out).
        // echo "<script>window.onload = function() { showCustomAlert('Error adding feedback: " . mysqli_error($db) . "', 'error'); }</script>";
    }
}

/**
 * Handle Edit Feedback operation.
 * This block executes when a POST request with 'edit_feedback' is received.
 * It sanitizes input, constructs an SQL UPDATE query, and attempts to modify an existing feedback record.
 */
if (isset($_POST['edit_feedback'])) {
    // Sanitize and validate input data for editing a feedback.
    $id = intval($_POST['id']); // The ID of the feedback to be edited.
    $patient_id = sanitize_input($_POST['patient_id']);
    $patients_name = sanitize_input($_POST['patients_name']); // Added patients' _name
    $message = sanitize_input($_POST['message']);
    $rating = intval($_POST['rating']);
    $status = sanitize_input($_POST['status']);

    // SQL UPDATE query to modify an existing feedback record.
    $update_query = "UPDATE `feedback` SET `patient_id`='$patient_id', `patients' _name`='$patients_name', `message`='$message', `rating`=$rating, `status`='$status' WHERE id=$id";

    // Execute the query and check for success or failure.
    if (mysqli_query($db, $update_query)) {
        // Success message (commented out).
        // echo "<script>window.onload = function() { showCustomAlert('Feedback updated successfully!', 'success'); }</script>";
    } else {
        // Error message (commented out).
        // echo "<script>window.onload = function() { showCustomAlert('Error updating feedback: " . mysqli_error($db) . "', 'error'); }</script>";
    }
}

/**
 * Handle Delete Feedback operation.
 * This block executes when a GET request with 'delete_id' is received.
 * It sanitizes the ID, constructs an SQL DELETE query, and attempts to remove a feedback record.
 */
if (isset($_GET['delete_id'])) {
    // Sanitize and validate the ID for deletion.
    $deleteId = intval($_GET['delete_id']); // Convert to integer for safety.
    $delete_query = "DELETE FROM `feedback` WHERE id=$deleteId";

    // Execute the query and check for success or failure.
    if (mysqli_query($db, $delete_query)) {
        // Success message (commented out).
        // echo "<script>window.onload = function() { showCustomAlert('Feedback deleted successfully!', 'success'); }</script>";
    } else {
        // Error message (commented out).
        // echo "<script>window.onload = function() { showCustomAlert('Error deleting feedback: " . mysqli_error($db) . "', 'error'); }</script>";
    }
}

// ------------ FETCH ALL FEEDBACK FOR DISPLAY -----------------
// This section fetches all relevant feedback data from the database
// to be displayed dynamically on the front-end.

// SQL SELECT query to retrieve all columns from the `feedback` table.
// Note: `patients' _name` needs to be escaped with backticks due to the space and apostrophe.
// The data is ordered by created_at in descending order to show recent feedback first.
$feedback_result = mysqli_query($db, "SELECT id, patient_id, `patients' _name`, message, rating, status, created_at FROM `feedback` ORDER BY created_at DESC");

// Check the number of rows returned by the query.
$feedback_count = mysqli_num_rows($feedback_result);

// Prepare dummy data if no actual feedback records are found in the database.
// This ensures the page always has content to display for demonstration purposes.
$dummy_feedback_items = [];
if ($feedback_count === 0) {
    $dummy_feedback_items = [
        [
            'id' => 101,
            'patient_id' => 'P-001',
            'patients\' _name' => 'Rohan Kapri',
            'message' => 'The staff were incredibly kind and attentive. My experience at Meditronix was outstanding!',
            'rating' => 5,
            'status' => 'Approved',
            'created_at' => date('Y-m-d H:i:s', strtotime('-7 days'))
        ],
        [
            'id' => 102,
            'patient_id' => 'P-002',
            'patients\' _name' => 'Priya Sharma',
            'message' => 'Good service overall, but waiting times for appointments could be shorter. Otherwise, a positive visit.',
            'rating' => 4,
            'status' => 'Approved',
            'created_at' => date('Y-m-d H:i:s', strtotime('-10 days'))
        ],
        [
            'id' => 103,
            'patient_id' => 'P-003',
            'patients\' _name' => 'Amit Singh',
            'message' => 'I had some concerns regarding the clarity of post-treatment instructions. Room for improvement.',
            'rating' => 3,
            'status' => 'Pending',
            'created_at' => date('Y-m-d H:i:s', strtotime('-15 days'))
        ],
        [
            'id' => 104,
            'patient_id' => 'P-004',
            'patients\' _name' => 'Neha Gupta',
            'message' => 'Exceptional care from start to finish. The doctors were very knowledgeable and reassuring. Highly recommended!',
            'rating' => 5,
            'status' => 'Approved',
            'created_at' => date('Y-m-d H:i:s', strtotime('-20 days'))
        ],
        [
            'id' => 105,
            'patient_id' => 'P-005',
            'patients\' _name' => 'Rajesh Kumar',
            'message' => 'The facility was clean and modern. My only suggestion would be to improve the online booking system.',
            'rating' => 4,
            'status' => 'Approved',
            'created_at' => date('Y-m-d H:i:s', strtotime('-25 days'))
        ],
        [
            'id' => 106,
            'patient_id' => 'P-006',
            'patients\' _name' => 'Sneha Verma',
            'message' => 'My experience was not satisfactory. There was a significant delay in receiving my test results.',
            'rating' => 2,
            'status' => 'Archived',
            'created_at' => date('Y-m-d H:i:s', strtotime('-30 days'))
        ],
        [
            'id' => 107,
            'patient_id' => 'P-007',
            'patients\' _name' => 'Vikram Patel',
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
    <!-- Sets the viewport for responsive design, ensuring proper scaling on all devices. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome for modern icons -->
    <!-- This CDN link provides access to a wide range of vector icons. -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    /*======================================================================
      GLOBAL STYLES & BASE LAYOUT
      This section defines root variables for consistent theming,
      basic CSS resets, and the overall page structure, including the
      subtle light multi-rainbow background.
    ========================================================================*/
    :root {
        /* Primary color palette for feedback - blushing bloom, very light pink, maroon */
        --primary-accent: #ffb6c1; /* Light Pink (blushing bloom) */
        --secondary-accent: #ff69b4; /* Hot Pink */
        --tertiary-accent: #800000; /* Maroon */
        --dark-accent: #4b0082; /* Indigo (for depth) */

        /* Light pastel rainbow colors for a softer, changing background */
        --pastel-color-1: #f0f8ff; /* Alice Blue */
        --pastel-color-2: #e6f0ff; /* Very Light Blue */
        --pastel-color-3: #f0fff8; /* Mint Cream */
        --pastel-color-4: #fff0f5; /* Lavender Blush */
        --pastel-color-5: #fdf5e6; /* Old Lace */
        --pastel-color-6: #ffe4e1; /* Misty Rose */
        --pastel-color-7: #e0ffff; /* Light Cyan */

        /* Text colors for different levels of emphasis */
        --text-color-dark: #222;
        --text-color-medium: #555;
        --text-color-light: #888;

        /* Card background and border colors */
        --card-bg-start: rgba(255, 255, 255, 0.95);   /* Near white, start of card gradient */
        --card-bg-end: rgba(245, 245, 245, 0.9);     /* White Smoke, end of card gradient */
        --card-border: rgba(255, 182, 193, 0.4); /* Light Pink border for cards */

        /* Multi-gradient blushing bloom very light pink and maroon zebra cross lines for card background */
        --zebra-gradient: linear-gradient(
            45deg,
            rgba(255, 240, 245, 0.95) 0%, /* Lavender Blush (very light pink) */
            rgba(255, 240, 245, 0.95) 10%,
            rgba(255, 228, 225, 0.9) 10%, /* Misty Rose (light blushing bloom) */
            rgba(255, 228, 225, 0.9) 20%,
            rgba(255, 240, 245, 0.95) 20%,
            rgba(255, 240, 245, 0.95) 30%,
            rgba(255, 228, 225, 0.9) 30%,
            rgba(255, 228, 225, 0.9) 40%,
            rgba(255, 240, 245, 0.95) 40%,
            rgba(255, 240, 245, 0.95) 50%,
            rgba(255, 228, 225, 0.9) 50%,
            rgba(255, 228, 225, 0.9) 60%,
            rgba(255, 240, 245, 0.95) 60%,
            rgba(255, 240, 245, 0.95) 70%,
            rgba(255, 228, 225, 0.9) 70%,
            rgba(255, 228, 225, 0.9) 80%,
            rgba(255, 240, 245, 0.95) 80%,
            rgba(255, 240, 245, 0.95) 90%,
            rgba(255, 228, 225, 0.9) 90%,
            rgba(255, 228, 225, 0.9) 100%
        );
        --zebra-gradient-size: 40px; /* Size of one stripe cycle */


        /* Shadow definitions for depth and visual hierarchy */
        --shadow-light: 0 15px 50px rgba(0,0,0,0.15); /* Lighter shadow for general elements */
        --shadow-hover: 0 25px 70px rgba(0,0,0,0.3); /* More prominent shadow on hover */

        /* Border radius and padding for consistent styling */
        --border-radius-xl: 35px; /* Extra large border radius for rounded elements */
        --padding-xl: 3.5rem; /* Extra large padding for spacious layouts */

        /* Transition properties for smooth animations */
        --transition-speed: 0.6s; /* Default transition duration */
        --transition-ease: cubic-bezier(0.4, 0, 0.2, 1); /* Material Design-like easing function */
    }

    /* Universal box-sizing for consistent layout calculations */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    /* Body styling: font, dynamic rainbow background, overflow, and text color */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        /* Dynamic, flowing light rainbow background for the entire page.
           Uses multiple pastel colors to create a subtle, shifting gradient. */
        background: linear-gradient(160deg, var(--pastel-color-1) 0%, var(--pastel-color-2) 15%, var(--pastel-color-3) 30%, var(--pastel-color-4) 45%, var(--pastel-color-5) 60%, var(--pastel-color-6) 75%, var(--pastel-color-7) 90%, var(--pastel-color-1) 100%);
        background-size: 700% 700%; /* Larger background size for more subtle and continuous motion. */
        animation: bgGradientMotion 90s ease-in-out infinite alternate; /* Slower, more elegant bi-directional animation. */
        overflow-x: hidden; /* Prevents horizontal scrollbar on the body. */
        color: var(--text-color-medium); /* Default text color. */
        line-height: 1.8; /* Increased line height for better readability. */
        position: relative; /* Establishes a positioning context for child elements. */
    }

    /* Keyframe animation for the background gradient motion, creating a subtle "wind" effect. */
    @keyframes bgGradientMotion {
        0% { background-position: 0% 50%; } /* Start position */
        50% { background-position: 100% 50%; } /* Mid position */
        100% { background-position: 0% 50%; } /* End position, returning to start */
    }

    /* Main wrapper styling: central container for the content */
    .main-wrapper {
        max-width: 2000px; /* Wider layout as requested, extending left and right. */
        margin: 30px auto; /* Centers the wrapper horizontally with vertical margin. */
        padding: 50px 40px; /* Increased padding on sides for an extended feel. */
        background: rgba(255, 255, 255, 0.75); /* More translucent wrapper background for depth. */
        border-radius: var(--border-radius-xl); /* Applies large rounded corners. */
        box-shadow: 0 30px 90px rgba(0,0,0,0.2); /* Stronger shadow for a lifted effect. */
        backdrop-filter: blur(20px); /* Stronger blur effect for elements behind the wrapper. */
        border: 1px solid rgba(255,255,255,0.85); /* More prominent white border. */
        position: relative; /* Establishes positioning context. */
        z-index: 1; /* Ensures the wrapper is above the background but below popups. */
        perspective: 1000px; /* Establishes a 3D context for child transformations. */
        transition: transform 0.8s var(--transition-ease), box-shadow 0.8s var(--transition-ease); /* Smooth transitions for hover effects. */
    }

    /* Hover effect for the main wrapper: subtle 3D tilt and scale. */
    .main-wrapper:hover {
        transform: rotateY(0.5deg) rotateX(0.5deg) scale(1.005); /* Slight rotation and scale for interactive feel. */
        box-shadow: 0 40px 120px rgba(0,0,0,0.35); /* Enhanced shadow on hover. */
    }

    /*======================================================================
      HEADER SECTION
      Styling for the main title and introductory paragraph of the page.
    ========================================================================*/
    .header-section {
        text-align: center; /* Centers text content. */
        margin-bottom: 80px; /* Increased bottom margin for spacing. */
        padding: 45px; /* Increased padding around content. */
        background: rgba(255,255,255,0.98); /* Nearly opaque header background. */
        border-radius: var(--border-radius-xl); /* Applies large rounded corners. */
        box-shadow: 0 20px 70px rgba(0,0,0,0.3); /* Stronger shadow. */
        backdrop-filter: blur(22px); /* Stronger blur effect. */
        border: 1px solid rgba(255,255,255,0.95); /* Prominent white border. */
        animation: fadeIn 1.8s ease-out; /* Fade-in animation on load. */
        position: relative; /* For potential future pseudo-elements or animations. */
    }

    /* Main heading (H1) styling with gradient shimmer and floating effect. */
    .header-section h1 {
        font-size: 5.8rem; /* Even larger, more impactful heading. */
        /* Gradient background for text, clipped to text. */
        background: linear-gradient(to right, var(--primary-accent), var(--secondary-accent), var(--tertiary-accent), var(--primary-accent));
        -webkit-background-clip: text; /* Clips the background to the shape of the text. */
        -webkit-text-fill-color: transparent; /* Makes the text transparent to show the background. */
        animation: shimmer 7s ease-in-out infinite, floatingHeading 8s ease-in-out infinite alternate; /* Combines shimmer and floating animations. */
        margin-bottom: 30px; /* Spacing below the heading. */
        font-weight: 900; /* Extra bold font weight. */
        letter-spacing: 4px; /* Increased letter spacing for emphasis. */
        text-shadow: 5px 5px 15px rgba(0,0,0,0.25); /* More pronounced text shadow. */
        position: relative; /* Ensures text-shadow and background-clip work well. */
        display: inline-block; /* Required for text-shadow and background-clip to work well. */
    }

    /* Keyframe animation for the text shimmer effect. */
    @keyframes shimmer {
        0%, 100% { background-position: -500% 0; } /* Start and end positions for background pan. */
        50% { background-position: 500% 0; } /* Mid position for background pan. */
    }

    /* Keyframe animation for a subtle floating effect on the heading. */
    @keyframes floatingHeading {
        0% { transform: translateY(0px) rotateX(0deg); } /* Start position. */
        50% { transform: translateY(-10px) rotateX(1deg); } /* Subtle lift and tilt. */
        100% { transform: translateY(0px) rotateX(0deg); } /* Return to start. */
    }

    /* Introductory paragraph styling. */
    .header-section p {
        font-size: 1.9rem; /* Larger introductory text. */
        color: var(--text-color-dark); /* Darker text for better contrast. */
        max-width: 1400px; /* Wider text block. */
        margin: 0 auto; /* Centers the paragraph. */
        line-height: 2.1; /* Increased line height for readability. */
        text-shadow: 1px 1px 5px rgba(0,0,0,0.15); /* Slightly stronger text shadow. */
        animation: slideInUp 1.5s ease-out 0.5s forwards; /* Subtle slide-in animation for text. */
        opacity: 0; /* Hidden initially for animation. */
    }

    /* Keyframe animation for the slide-in-up effect. */
    @keyframes slideInUp {
        0% { transform: translateY(20px); opacity: 0; } /* Starts slightly below and transparent. */
        100% { transform: translateY(0); opacity: 1; } /* Slides up and fades in. */
    }

    /*======================================================================
      FEEDBACK CAROUSEL SECTION
      Styling for the feedback cards carousel, including auto-sliding
      and interactive click effects.
    ========================================================================*/
    .feedback-carousel-section {
        overflow-x: hidden; /* Ensures no horizontal scrollbar is visible. */
        padding: 60px 0; /* More vertical padding for spacing. */
        scroll-behavior: smooth; /* Enables smooth scrolling for programmatic scrolls. */
        -webkit-overflow-scrolling: touch; /* Improves scrolling performance on touch devices. */
        position: relative; /* Establishes positioning context. */
        box-shadow: inset 0 0 30px rgba(0,0,0,0.12); /* Deeper inner shadow for depth. */
        border-radius: var(--border-radius-xl); /* Applies large rounded corners. */
        background: rgba(255,255,255,0.9); /* Slightly more opaque background. */
        border: 1px solid var(--card-border); /* Card border. */
        /* Background image for feedback section. */
        background-image: url('https://cdn.pixabay.com/photo/2024/07/08/16/28/ai-generated-8881553_1280.jpg'); /* Light pink background */
        background-size: cover; /* Ensures the background image covers the entire area. */
        background-position: center; /* Centers the background image. */
        background-blend-mode: overlay; /* Blends the image with the semi-transparent background. */
        animation: backgroundPan 90s linear infinite alternate; /* Slower, subtle pan effect for the background. */
        margin-bottom: 0 !important; /* Ensures no space below the carousel. */
    }

    /* Keyframe animation for the background image pan effect. */
    @keyframes backgroundPan {
        0% { background-position: 0% 50%; } /* Start position. */
        100% { background-position: 100% 50%; } /* End position. */
    }

    /* Styling for the carousel track that holds the feedback cards. */
    .feedback-carousel-track {
        display: flex; /* Uses flexbox for horizontal arrangement of cards. */
        gap: 70px; /* Increased gap between individual cards. */
        padding: 40px; /* Increased padding inside the track. */
        min-width: fit-content; /* Allows content to exceed container width, enabling scrolling. */
        transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Smooth transition for JavaScript-controlled sliding. */
    }

    /* Styling for individual feedback cards. */
    .feedback-card {
        flex: 0 0 650px; /* Sets fixed width for each card, preventing shrinking. */
        min-width: 650px; /* Ensures minimum width even if flex tries to shrink. */
        height: 1020px; /* Increased height for full icon visibility and more content space. */
        background: var(--zebra-gradient); /* Zebra cross lines gradient background. */
        background-size: var(--zebra-gradient-size) var(--zebra-gradient-size); /* Size of the zebra stripes */
        border-radius: var(--border-radius-xl); /* Applies large rounded corners. */
        padding: var(--padding-xl); /* Applies large padding inside the card. */
        position: relative; /* Establishes positioning context for pseudo-elements. */
        box-shadow: 0 12px 35px rgba(255, 182, 193, 0.15), /* Soft accent shadow. */
                    0 30px 90px rgba(0,0,0,0.2); /* General shadow for depth. */
        transition: transform var(--transition-speed) var(--transition-ease), box-shadow var(--transition-speed) var(--transition-ease), background var(--transition-speed) var(--transition-ease); /* Smooth transitions for hover effects. */
        overflow: hidden; /* Hides content that overflows the card boundaries. */
        border: 3px solid var(--card-border); /* More prominent accent border. */
        cursor: pointer; /* Changes cursor to pointer to indicate interactivity. */
        display: flex; /* Uses flexbox for internal layout. */
        flex-direction: column; /* Stacks content vertically. */
        justify-content: space-between; /* Distributes space between items. */
        z-index: 5; /* Ensures cards are above background effects. */
        transform-style: preserve-3d; /* Enables 3D transformations for child elements. */
        perspective: 1000px; /* Sets perspective for 3D effects. */
    }

    /* Hover effect for feedback cards: dramatic lift, scale, and 3D tilt. */
    .feedback-card:hover {
        transform: translateY(-30px) scale(1.08) rotateX(2.5deg) rotateY(2.5deg); /* More dramatic lift, scale, and 3D rotation. */
        box-shadow: 0 18px 45px rgba(255, 182, 193, 0.25), /* Enhanced accent shadow. */
                    0 40px 110px rgba(0,0,0,0.4); /* More prominent general shadow. */
        background: linear-gradient(145deg, #ffffff 0%, #fff0f5 100%); /* Slightly brighter crystal background on hover. */
    }

    /* Glittering Shine Effect on click (Shining Blade) */
    /* This pseudo-element creates a "shining blade" effect that sweeps across the card on click. */
    .feedback-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -400%; /* Starts far off-screen to the left. */
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 1), transparent); /* Super bright white shine, fully opaque in the middle. */
        transform: skewX(-45deg); /* Creates an angled "blade" shape. */
        transition: left 1.8s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Slower, smoother transition for the sweep. */
        pointer-events: none; /* Allows clicks to pass through this pseudo-element. */
        z-index: 10; /* Ensures it's above other card content. */
        opacity: 0; /* Hidden by default. */
    }
    /* Activates the shining blade effect when the card is clicked. */
    .feedback-card.clicked::before {
        left: 400%; /* Slides across to the right. */
        opacity: 1; /* Makes it visible when clicked. */
        animation: glitterShineBlade 1.8s forwards; /* Animation for the shine. */
    }
    /* Keyframe animation for the glitter shine blade effect. */
    @keyframes glitterShineBlade {
        0% { left: -400%; opacity: 0; } /* Starts off-screen, transparent. */
        50% { left: 0%; opacity: 1; } /* Moves to center, fully opaque. */
        100% { left: 400%; opacity: 0; } /* Moves off-screen, fades out. */
    }

    /* Crystal Water Effect on click (Expanding Radial Gradient) - Waterfall-like */
    /* This pseudo-element creates an expanding radial gradient effect, like a water ripple. */
    .feedback-card::after {
        content: '';
        position: absolute;
        top: var(--mouse-y, 50%); /* Dynamic Y position based on mouse click. */
        left: var(--mouse-x, 50%); /* Dynamic X position based on mouse click. */
        width: 0;
        height: 0;
        border-radius: 50%; /* Ensures a circular ripple. */
        background: radial-gradient(circle at center, rgba(255, 182, 193, 0.8), transparent 85%); /* Brighter, more expansive accent water ripple. */
        opacity: 0;
        transform: translate(-50%, -50%); /* Centers the pseudo-element relative to its top/left. */
        transition: width 1.5s ease-out, height 1.5s ease-out, opacity 1.5s ease-out; /* Slower, more fluid expansion. */
        pointer-events: none; /* Allows clicks to pass through. */
        z-index: 9; /* Ensures it's above card content but below the shining blade. */
        box-shadow: 0 0 60px 25px rgba(255, 182, 193, 0.6); /* Stronger glowing effect for water. */
    }
    /* Activates the crystal water effect when the card is clicked. */
    .feedback-card.clicked::after {
        width: 500%; /* Expands significantly. */
        height: 500%;
        opacity: 1; /* Becomes visible. */
    }

    /* Styling for the circular icon container at the top of each card. */
    .feedback-icon-container {
        width: 200px; /* Increased width for a larger circle */
        height: 200px; /* Increased height for a larger circle */
        background: linear-gradient(135deg, var(--primary-accent), var(--dark-accent)); /* Accent gradient background. */
        border-radius: 50%; /* Ensures it's a perfect circle. */
        display: flex; /* Uses flexbox for centering the icon. */
        align-items: center; /* Centers vertically. */
        justify-content: center; /* Centers horizontally. */
        color: #fff; /* White icon color. */
        font-size: 8rem; /* Increased icon font size for a "fuller" look */
        margin: 0 auto 55px; /* Adjusted bottom margin for spacing. */
        box-shadow: 0 20px 45px rgba(255, 182, 193, 0.9); /* Stronger accent shadow. */
        transition: transform 0.9s cubic-bezier(0.68, -0.55, 0.27, 1.55); /* Springy animation for hover. */
        position: relative; /* For pseudo-elements. */
        overflow: hidden; /* Ensures content inside is clipped if it overflows. */
    }
    /* Pseudo-element for a pulsing glow effect inside the icon container. */
    .feedback-icon-container::before {
        content: '';
        position: absolute;
        top: -90%;
        left: -90%;
        width: 280%;
        height: 280%;
        background: radial-gradient(circle at center, rgba(255,255,255,0.7), transparent 90%);
        animation: iconPulse 7s infinite alternate; /* Slower pulsing glow animation. */
    }
    /* Keyframe animation for the icon pulsing glow. */
    @keyframes iconPulse {
        0% { transform: scale(0.4); opacity: 0.9; } /* Starts smaller, slightly transparent. */
        100% { transform: scale(1.6); opacity: 1; } /* Expands, becomes fully opaque. */
    }

    /* Hover effect for the icon container: dramatic rotate and scale. */
    .feedback-card:hover .feedback-icon-container {
        transform: rotate(40deg) scale(1.4); /* More dramatic rotation and scale on hover. */
    }

    /* Styling for the main title of the feedback (e.g., "Feedback ID"). */
    .feedback-card h4 {
        font-size: 3.2rem; /* Larger title font size. */
        color: var(--text-color-dark);
        margin-bottom: 18px;
        font-weight: 900; /* Extra bold. */
        text-shadow: 1px 1px 6px rgba(0,0,0,0.25);
        text-align: center; /* Centered text. */
        /* Glitter effect for feedback title using a gold shimmer gradient. */
        background: linear-gradient(90deg, #fefefe, #ffd700, #fefefe, #ffd700, #fefefe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: 400% 100%; /* Larger background size for more prominent shimmer. */
        animation: textShine 6s linear infinite; /* Slower shimmer animation. */
    }

    /* Styling for individual feedback details (Patient ID, Name, Message, Rating, Created At). */
    .feedback-card p {
        color: var(--text-color-medium);
        font-size: 1.5rem; /* Larger text. */
        margin-bottom: 12px; /* Slightly reduced margin for denser info */
        line-height: 1.7;
        text-align: left; /* Aligns details to the left for readability. */
        display: flex; /* Uses flexbox for icon alignment. */
        align-items: flex-start; /* Aligns icon and text to the top */
        gap: 20px; /* Space between icon and text. */
        padding-left: 25px; /* Indents details slightly. */
        position: relative; /* For icon styling. */
    }

    /* Styling for strong/bold text within paragraphs. */
    .feedback-card p strong {
        color: var(--text-color-dark);
        font-weight: 700;
        min-width: 150px; /* Ensure consistent alignment for labels */
    }

    /* Styling for Font Awesome icons within paragraphs. */
    .feedback-card p i {
        color: var(--primary-accent); /* Accent icon color. */
        font-size: 1.8rem; /* Larger icon size. */
        min-width: 35px; /* Ensures consistent spacing for icons. */
        text-shadow: 0.8px 0.8px 3px rgba(255, 182, 193, 0.4); /* Icon shadow. */
    }

    /* Styling for the star rating */
    .feedback-card .rating-stars {
        color: #FFD700; /* Gold color for stars */
        font-size: 2.2rem; /* Larger stars */
        margin-left: 25px; /* Align with other content */
        margin-top: 10px;
        margin-bottom: 15px;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
    }

    /* Styling for the "Posted on" timestamp. */
    .feedback-card small {
        display: block; /* Ensures it takes full width. */
        text-align: right; /* Aligns to the right. */
        color: var(--text-color-light);
        font-size: 1.2rem; /* Larger font size. */
        margin-top: 25px; /* More space above. */
        padding-top: 15px;
        border-top: 1px dashed rgba(0,0,0,0.1); /* Subtle dashed line. */
    }

    /* Social Links within each card */
    .card-social-links {
        display: flex; /* Uses flexbox for arrangement. */
        justify-content: center; /* Centers the social icons. */
        gap: 25px; /* Space between icons. */
        margin-top: 30px; /* Space from content above. */
        padding-top: 20px;
        border-top: 1px dashed rgba(0,0,0,0.1); /* Subtle separator line. */
    }

    /* Styling for individual social media links. */
    .card-social-links a {
        color: var(--primary-accent); /* Default icon color, now accent. */
        font-size: 2.5rem; /* Large social icons. */
        transition: transform 0.3s ease, color 0.3s ease, text-shadow 0.3s ease; /* Smooth transitions for hover. */
        text-decoration: none; /* Removes underline from links. */
    }

    /* Hover effect for social media links: lift and slightly enlarge. */
    .card-social-links a:hover {
        transform: translateY(-5px) scale(1.1); /* Lifts and slightly enlarges on hover. */
    }

    /* Specific colors for social icons on hover for brand recognition. */
    .card-social-links a.linkedin:hover { color: #0077B5; text-shadow: 0 0 15px rgba(0,119,181,0.6); }
    .card-social-links a.youtube:hover { color: #FF0000; text-shadow: 0 0 15px rgba(255,0,0,0.6); }
    .card-social-links a.instagram:hover {
        /* Instagram gradient effect for hover. */
        background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 15px rgba(214,36,159,0.6);
    }
    .card-social-links a.wikipedia:hover { color: #000; text-shadow: 0 0 15px rgba(0,0,0,0.6); }


    /*======================================================================
      POPUP MESSAGES (CUSTOM ALERTS/CONFIRMS)
      Styling for the interactive popup message and confirmation modals.
    ========================================================================*/
    .custom-modal {
        display: none; /* Hidden by default. */
        position: fixed; /* Fixed position relative to the viewport. */
        z-index: 3000; /* Highest z-index to appear above all other content. */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto; /* Enables scrolling if content overflows. */
        background-color: rgba(0,0,0,0.75); /* Darker, semi-transparent overlay. */
        backdrop-filter: blur(12px); /* Applies a blur effect to content behind the modal. */
        animation: fadeIn 0.5s ease-out; /* Fade-in animation for the modal. */
        justify-content: center; /* Centers content horizontally using flexbox. */
        align-items: center; /* Centers content vertically using flexbox. */
    }

    /* Styling for the content area of the custom modal. */
    .custom-modal-content {
        background-color: #fefefe; /* Near-white background. */
        margin: auto; /* Centers vertically and horizontally. */
        padding: 60px; /* Even larger padding. */
        border: 1px solid #888; /* Light gray border. */
        width: 90%; /* Takes 90% of parent width. */
        max-width: 700px; /* Larger maximum width. */
        border-radius: var(--border-radius-xl); /* Applies large rounded corners. */
        box-shadow: 0 30px 90px rgba(0,0,0,0.5); /* Stronger shadow. */
        position: relative; /* For positioning the close button. */
        animation: slideInTop 0.6s ease-out; /* Slide-in-from-top animation. */
        text-align: center; /* Centers text content. */
    }

    /* Close button styling for modals. */
    .custom-modal-content .close-button {
        color: #aaa; /* Light gray color. */
        font-size: 3.5rem; /* Larger font size. */
        font-weight: bold;
        position: absolute; /* Absolute positioning relative to modal content. */
        top: 25px;
        right: 35px;
        cursor: pointer;
        transition: color 0.3s ease; /* Smooth color transition on hover. */
    }

    /* Hover/focus effect for the close button. */
    .custom-modal-content .close-button:hover,
    .custom-modal-content .close-button:focus {
        color: #333; /* Darker gray on hover. */
    }

    /* Heading (H3) styling within modals. */
    .custom-modal-content h3 {
        margin-bottom: 30px;
        font-size: 3rem;
        color: var(--text-color-dark);
    }

    /* Paragraph styling within modals. */
    .custom-modal-content p {
        margin-bottom: 40px;
        font-size: 1.4rem;
        line-height: 1.8;
    }

    /* Button container for modal actions. */
    .custom-modal-content .modal-buttons button {
        padding: 15px 35px;
        border: none;
        border-radius: 30px;
        cursor: pointer;
        font-size: 1.2rem;
        font-weight: 700;
        transition: background 0.4s ease, transform 0.3s ease; /* Smooth transitions. */
        margin: 0 20px;
    }

    /* Styling for "OK" button in modals. */
    .custom-modal-content .modal-buttons .btn-ok {
        background: linear-gradient(to right, #28a745, #218838); /* Green gradient. */
        color: #fff;
    }
    /* Hover effect for "OK" button. */
    .custom-modal-content .modal-buttons .btn-ok:hover {
        background: linear-gradient(to right, #218838, #28a745);
        transform: translateY(-4px);
    }

    /* Styling for "Cancel" button in modals. */
    .custom-modal-content .modal-buttons .btn-cancel {
        background: linear-gradient(to right, #dc3545, #c82333); /* Red gradient. */
        color: #fff;
    }
    /* Hover effect for "Cancel" button. */
    .custom-modal-content .modal-buttons .btn-cancel:hover {
        background: linear-gradient(to right, #c82333, #dc3545);
        transform: translateY(-4px);
    }

    /* Specific styling for the initial "Welcome" popup message. */
    #popup-message {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0); /* Starts hidden and scaled down. */
        background: linear-gradient(45deg, var(--primary-accent) 0%, var(--secondary-accent) 99%, var(--tertiary-accent) 100%); /* Accent gradient background. */
        padding: 60px 90px; /* Larger padding. */
        border-radius: var(--border-radius-xl);
        font-size: 3.5rem; /* Larger text. */
        color: #fff;
        text-shadow: 1px 1px 8px rgba(0,0,0,0.6);
        box-shadow: 0 0 50px rgba(255, 182, 193, 1); /* Stronger shadow. */
        opacity: 0; /* Hidden initially. */
        transition: transform 1s cubic-bezier(0.68, -0.55, 0.27, 1.55), opacity 1s ease; /* Smooth, springy transition. */
        z-index: 2000; /* Highest z-index for initial display. */
        border: 6px solid rgba(255,255,255,1); /* White border. */
        font-weight: bold;
        letter-spacing: 3px;
        text-align: center;
    }
    /* Shows the welcome popup with animation. */
    #popup-message.show {
        transform: translate(-50%, -50%) scale(1); /* Scales up to full size. */
        opacity: 1; /* Fades in. */
    }

    /* Firework Canvas for dynamic effects */
    #fireworkCanvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none; /* Allows clicks to pass through to elements below. */
        z-index: 1500; /* Below popups, above content. */
    }

    /*======================================================================
      FOOTER & SOCIAL LINKS
      Styling for the social media links and copyright information at the bottom of the page.
    ========================================================================*/
    .footer-social-links {
        text-align: center;
        margin-top: 0 !important; /* IMPORTANT: Removes any default top margin. */
        padding-top: 80px; /* More padding above social links. */
        border-top: 1px solid rgba(0,0,0,0.4); /* More visible border above social links. */
        padding-bottom: 60px;
    }
    /* Styling for individual social media icons in the footer. */
    .footer-social-links a {
        margin: 0 40px; /* Increased spacing between icons. */
        color: var(--primary-accent); /* Accent color for footer links. */
        font-size: 3.5rem; /* Larger icons. */
        text-decoration: none;
        transition: color 0.6s ease, transform 0.6s ease, text-shadow 0.6s ease; /* Smooth transitions for hover effects. */
    }
    /* Hover effect for footer social links: significant lift and scale. */
    .footer-social-links a:hover {
        transform: translateY(-15px) scale(1.5); /* More pronounced lift. */
        color: var(--dark-accent); /* Darker accent on hover. */
        text-shadow: 0 12px 25px rgba(255, 182, 193, 0.6); /* Shadow on hover. */
    }

    /* Footer copyright text styling. */
    footer {
        text-align: center;
        margin-top: 0 !important; /* IMPORTANT: Removes any default top margin. */
        padding: 40px 0;
        border-top: 1px dashed rgba(0,0,0,0.25); /* Dashed border above copyright. */
        color: var(--text-color-light);
        font-size: 1.2rem;
    }

    /*======================================================================
      RESPONSIVE DESIGN
      Media queries for optimal viewing on various screen sizes,
      ensuring the layout adapts gracefully from large desktops to small mobile devices.
    ========================================================================*/
    /* Large screens (e.g., smaller desktops, large tablets in landscape) */
    @media (max-width: 1800px) {
        .main-wrapper {
            max-width: 1600px;
            padding: 40px 30px;
        }
        .feedback-card {
            flex: 0 0 550px;
            min-width: 550px;
            height: 940px; /* Adjusted height */
            padding: 3rem;
        }
        .feedback-icon-container {
            width: 180px; /* Adjusted for responsiveness */
            height: 180px; /* Adjusted for responsiveness */
            font-size: 7rem; /* Adjusted for responsiveness */
            margin-bottom: 50px; /* Adjusted for responsiveness */
        }
        .feedback-carousel-track {
            gap: 60px;
            padding: 30px;
        }
    }

    /* Medium-large screens (e.g., typical desktops, large tablets) */
    @media (max-width: 1400px) {
        .main-wrapper {
            max-width: 1200px;
            padding: 30px 25px;
        }
        .header-section h1 {
            font-size: 4.5rem;
        }
        .header-section p {
            font-size: 1.6rem;
        }
        .feedback-card {
            flex: 0 0 480px;
            min-width: 480px;
            height: 890px; /* Adjusted height */
            padding: 2.8rem;
        }
        .feedback-icon-container {
            width: 160px; /* Adjusted for responsiveness */
            height: 160px; /* Adjusted for responsiveness */
            font-size: 6rem; /* Adjusted for responsiveness */
            margin-bottom: 45px; /* Adjusted for responsiveness */
        }
        .feedback-card h4 {
            font-size: 2.8rem;
        }
        .feedback-card p {
            font-size: 1.3rem;
        }
        .feedback-carousel-track {
            gap: 50px;
            padding: 25px;
        }
        .footer-social-links a {
            font-size: 3rem;
            margin: 0 30px;
        }
    }

    /* Medium screens (e.g., smaller tablets, laptops) */
    @media (max-width: 1024px) {
        .main-wrapper {
            max-width: 960px;
            margin: 25px auto;
            padding: 25px 20px;
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
        .feedback-carousel-section {
            padding: 50px 0;
        }
        .feedback-card {
            flex: 0 0 420px; /* Adjust for smaller screens */
            min-width: 420px;
            padding: 2.5rem;
            height: 820px; /* Adjusted height */
        }
        .feedback-carousel-track {
            justify-content: flex-start;
            padding-left: 15px;
            padding-right: 15px;
            gap: 40px;
        }
        .feedback-icon-container {
            width: 140px; /* Adjusted for responsiveness */
            height: 140px; /* Adjusted for responsiveness */
            font-size: 5rem; /* Adjusted for responsiveness */
            margin-bottom: 35px; /* Adjusted for responsiveness */
        }
        .feedback-card h4 {
            font-size: 2.4rem;
        }
        .feedback-card p {
            font-size: 1.1rem;
            line-height: 1.8;
        }
        .footer-social-links {
            padding-top: 60px;
            padding-bottom: 40px;
        }
        .footer-social-links a {
            font-size: 2.8rem;
            margin: 0 25px;
        }
        #popup-message {
            padding: 40px 60px;
            font-size: 3rem;
        }
    }

    /* Small to medium screens (e.g., tablets in portrait, large phones) */
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
        .feedback-carousel-section {
            padding: 40px 0;
        }
        .feedback-card {
            flex: 0 0 95%; /* Take up almost full width on mobile */
            min-width: 300px; /* Ensure it doesn't get too small */
            margin: 0 auto; /* Center cards */
            padding: 2rem;
            height: 740px; /* Adjusted height */
        }
        .feedback-carousel-track {
            gap: 30px;
            padding-left: 10px;
            padding-right: 10px;
        }
        .feedback-icon-container {
            width: 120px; /* Adjusted for responsiveness */
            height: 120px; /* Adjusted for responsiveness */
            font-size: 4rem; /* Adjusted for responsiveness */
            margin-bottom: 30px; /* Adjusted for responsiveness */
        }
        .feedback-card h4 {
            font-size: 2rem;
        }
        .feedback-card p {
            font-size: 1rem;
            line-height: 1.6;
        }
        .footer-social-links {
            padding-top: 50px;
            padding-bottom: 35px;
        }
        .footer-social-links a {
            font-size: 2.5rem;
            margin: 0 20px;
        }
        #popup-message {
            font-size: 2.5rem;
            padding: 30px 50px;
        }
    }

    /* Smallest screens (e.g., most mobile phones) */
    @media (max-width: 480px) {
        .header-section h1 {
            font-size: 2.2rem;
        }
        .header-section p {
            font-size: 0.9rem;
        }
        .feedback-carousel-section {
            padding: 30px 0;
        }
        .feedback-card {
            padding: 1.5rem;
            flex: 0 0 98%;
            min-width: 280px;
            height: 680px; /* Adjusted height */
        }
        .feedback-icon-container {
            width: 100px; /* Adjusted for responsiveness */
            height: 100px; /* Adjusted for responsiveness */
            font-size: 3.5rem; /* Adjusted for responsiveness */
            margin-bottom: 25px; /* Adjusted for responsiveness */
        }
        .feedback-card h4 {
            font-size: 1.6rem;
        }
        .feedback-card p {
            font-size: 0.9rem;
        }
        .feedback-carousel-track {
            gap: 20px;
            padding-left: 5px;
            padding-right: 5px;
        }
        .footer-social-links {
            padding-top: 40px;
            padding-bottom: 25px;
        }
        .footer-social-links a {
            font-size: 2rem;
            margin: 0 15px;
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
        <h1><i class="fas fa-comment-dots" style="margin-right: 20px; color: var(--primary-accent);"></i>Meditronix: Patient Feedback & Insights<i class="fas fa-lightbulb" style="margin-left: 20px; color: var(--dark-accent);"></i></h1>
        <p>Your voice matters! At Meditronix, we value every piece of feedback as it helps us continuously improve our services and patient care. This dashboard provides a transparent overview of patient satisfaction, highlighting their experiences and valuable suggestions. We are committed to fostering an environment where every patient's input directly shapes our future, ensuring we deliver the highest standard of healthcare excellence.</p>
    </div>

    <!-- Feedback Carousel Section -->
    <div class="feedback-carousel-section" id="feedbackCarouselContainer">
        <h2 style="text-align: center; font-size: 2.8rem; color: var(--text-color-dark); margin-bottom: 40px; text-shadow: 1px 1px 2px rgba(0,0,0,0.05);">What Our Patients Are Saying</h2>
        <div class="feedback-carousel-track" id="feedbackCarouselTrack">
            <?php
            // If no feedback are fetched from the database, use the predefined dummy data.
            if ($feedback_count === 0) {
                $current_feedback_items = $dummy_feedback_items;
            } else {
                // If data is available from the database, reset the result pointer and fetch all rows.
                mysqli_data_seek($feedback_result, 0); // Ensures we start from the first row.
                $current_feedback_items = [];
                while ($row = mysqli_fetch_assoc($feedback_result)) {
                    $current_feedback_items[] = $row; // Add each row to the array.
                }
            }

            // Define a set of relevant Font Awesome icons to cycle through for each feedback card.
            // This provides visual variety and relevance to the feedback type.
            $feedback_icons = [
                'fas fa-star',              // General positive feedback
                'fas fa-comments',          // Message/comment
                'fas fa-thumbs-up',         // Approval/positive
                'fas fa-heart',             // Love/excellent experience
                'fas fa-exclamation-circle',// Suggestion/area for improvement
                'fas fa-user-nurse',        // Related to nursing staff
                'fas fa-hospital-user',     // Patient experience
                'fas fa-smile',             // Happy patient
                'fas fa-meh',               // Neutral feedback
                'fas fa-frown'              // Negative feedback
            ];

            $icon_index = 0; // Initialize an index to cycle through the icons array.

            // Loop through each feedback item to generate a feedback card.
            foreach ($current_feedback_items as $feedback_item) {
                // Get a specific icon from the array using the modulo operator to cycle through.
                $current_icon = $feedback_icons[$icon_index % count($feedback_icons)];
                $icon_index++; // Increment the index for the next card.

                // Generate star ratings
                $full_stars = str_repeat('&#9733;', $feedback_item['rating']);
                $empty_stars = str_repeat('&#9734;', 5 - $feedback_item['rating']);
            ?>
            <div class="feedback-card"
                 data-feedback-id="<?= htmlspecialchars($feedback_item['id']); ?>"
                 data-patient-id="<?= htmlspecialchars($feedback_item['patient_id']); ?>"
                 data-patients-name="<?= htmlspecialchars($feedback_item['patients\' _name']); ?>"
                 data-message="<?= htmlspecialchars($feedback_item['message']); ?>"
                 data-rating="<?= htmlspecialchars($feedback_item['rating']); ?>"
                 data-status="<?= htmlspecialchars($feedback_item['status']); ?>"
                 data-created-at="<?= htmlspecialchars($feedback_item['created_at']); ?>">
                <!-- Circular icon container -->
                <div class="feedback-icon-container"><i class="<?= $current_icon; ?>"></i></div>
                <!-- Main feedback title with ID -->
                <h4>Feedback ID: <?= htmlspecialchars($feedback_item['id']) ?></h4>
                <!-- Patient ID -->
                <p><i class="fas fa-id-card-alt"></i><strong>Patient ID:</strong> <?= htmlspecialchars($feedback_item['patient_id']) ?></p>
                <!-- Patient Name -->
                <p><i class="fas fa-user"></i><strong>Patient Name:</strong> <?= htmlspecialchars($feedback_item['patients\' _name']) ?></p>
                <!-- Message -->
                <p><i class="fas fa-comment-alt"></i><strong>Message:</strong> <?= nl2br(htmlspecialchars($feedback_item['message'])) ?></p>
                <!-- Rating -->
                <p class="rating-stars">
                    <i class="fas fa-star"></i><strong>Rating:</strong>
                    <?= $full_stars ?><?= $empty_stars ?> (<?= htmlspecialchars($feedback_item['rating']) ?>/5)
                </p>
                <!-- Received At timestamp -->
                <small>Received At: <?= date('d M Y H:i', strtotime($feedback_item['created_at'])) ?></small>

                <!-- Social Links for each feedback card -->
                <div class="card-social-links">
                    <a href="https://www.linkedin.com/company/google/" target="_blank" class="linkedin" title="Share on LinkedIn"><i class="fab fa-linkedin"></i></a>
                    <a href="https://www.youtube.com/Google" target="_blank" class="youtube" title="Watch on YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="https://www.instagram.com/google/" target="_blank" class="instagram" title="Follow on Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://en.wikipedia.org/wiki/Customer_feedback" target="_blank" class="wikipedia" title="Learn more on Wikipedia"><i class="fab fa-wikipedia-w"></i></a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Custom Popup Message (for alerts/success/error) -->
<!-- This modal is used to display general alert messages to the user. -->
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

<!-- Custom Confirm Modal (for delete confirmation - though delete not on front-end) -->
<!-- This modal is used to ask for user confirmation before performing sensitive actions. -->
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

<!-- Initial "Welcome" popup displayed briefly on page load. -->
<div id="popup-message">✨ Welcome to Meditronix Feedback! ✨<br><center>Your Voice Shapes Our Care.</center></div>
<!-- Canvas element for rendering dynamic firework effects. -->
<canvas id="fireworkCanvas"></canvas>

<!-- Social Links for the footer section. -->
<div class="footer-social-links">
    <a href="https://www.facebook.com/Google" target="_blank" title="Visit our Facebook"><i class="fab fa-facebook-f"></i></a>
    <a href="https://twitter.com/Google" target="_blank" title="Visit our Twitter"><i class="fab fa-twitter"></i></a>
    <a href="https://www.instagram.com/google/" target="_blank" title="Visit our Instagram"><i class="fab fa-instagram"></i></a>
    <a href="https://www.linkedin.com/company/google/" target="_blank" title="Visit our LinkedIn"><i class="fab fa-linkedin-in"></i></a>
    <a href="https://www.youtube.com/Google" target="_blank" title="Visit our YouTube"><i class="fab fa-youtube"></i></a>
    <a href="https://github.com/Google" target="_blank" title="Visit our GitHub"><i class="fab fa-github"></i></a>
</div>

<!-- Footer section with copyright information and personalization for Rohan Kapri. -->
<footer>
    &copy; <?php echo date("Y"); ?> Meditronix. All rights reserved. Your insights drive our excellence. Designed with <span style="color: #e25555;">&hearts;</span> for Rohan Kapri.
</footer>

<script>
//======================================================================
// JAVASCRIPT FUNCTIONS & INTERACTIVITY
// This section handles all dynamic behaviors, including custom popup messages,
// interactive click effects on feedback cards, and the auto-sliding carousel.
//======================================================================

// --- Custom Alert Modals ---
/**
 * Displays a custom alert modal with a specified message and type.
 * @param {string} message The message to display in the alert.
 * @param {string} type The type of alert ('info', 'success', 'error'). Affects title and button color.
 */
function showCustomAlert(message, type = 'info') {
    const popupModal = document.getElementById('customPopupMessage');
    const popupTitle = document.getElementById('popupTitle');
    const popupMessage = document.getElementById('popupMessage');
    const okButton = popupModal.querySelector('.btn-ok');

    // Capitalize the first letter of the type for the title (e.g., "Success", "Error").
    popupTitle.textContent = type.charAt(0).toUpperCase() + type.slice(1);
    popupMessage.textContent = message;

    // Set title color and OK button background based on the alert type.
    if (type === 'success') {
        popupTitle.style.color = '#28a745'; // Green for success.
        okButton.style.background = 'linear-gradient(to right, #28a745, #218838)';
    } else if (type === 'error') {
        popupTitle.style.color = '#dc3545'; // Red for error.
        okButton.style.background = 'linear-gradient(to right, #dc3545, #c82333)';
    } else { // Default to info (blue).
        popupTitle.style.color = '#007bff';
        okButton.style.background = 'linear-gradient(to right, #007bff, #0056b3)';
    }

    // Display the modal using flexbox for centering.
    popupModal.style.display = 'flex';
}

/**
 * Closes the custom alert modal.
 */
function closeCustomAlert() {
    document.getElementById('customPopupMessage').style.display = 'none';
}

// --- Custom Confirm Modals ---
/**
 * Displays a custom confirmation modal with a message and a callback for confirmation.
 * @param {string} message The message to display in the confirmation.
 * @param {function} onConfirmCallback The function to execute if the user confirms.
 */
function showCustomConfirm(message, onConfirmCallback) {
    const confirmModal = document.getElementById('customConfirmModal');
    const confirmMessage = document.getElementById('confirmMessage');
    const confirmOkBtn = document.getElementById('confirmOkBtn');
    const confirmCancelBtn = document.getElementById('confirmCancelBtn');

    confirmMessage.textContent = message;
    confirmModal.style.display = 'flex';

    // Clear previous event listeners to prevent multiple callback executions.
    confirmOkBtn.onclick = null;
    confirmCancelBtn.onclick = null;

    // Attach new click handlers.
    confirmOkBtn.onclick = () => {
        onConfirmCallback(); // Execute the provided callback.
        confirmModal.style.display = 'none'; // Hide the modal.
    };
    confirmCancelBtn.onclick = () => {
        confirmModal.style.display = 'none'; // Hide the modal if cancelled.
    };
}

/**
 * Closes the custom confirmation modal.
 */
function closeCustomConfirm() {
    document.getElementById('customConfirmModal').style.display = 'none';
}

// Initial "Welcome" popup animation on page load.
window.addEventListener('load', function() {
    const initialPopup = document.getElementById('popup-message');
    initialPopup.classList.add('show'); // Add 'show' class to trigger the animation.
    // Hide the popup after 3 seconds.
    setTimeout(() => initialPopup.classList.remove('show'), 3000);
});

// --- Feedback Card Interactions (Glitter and Water effects) ---
// Attaches click event listeners to all feedback cards for interactive effects.
document.querySelectorAll('.feedback-card').forEach(card => {
    card.addEventListener('click', (event) => {
        // Prevent triggering card effects if a social link was clicked.
        if (event.target.closest('.card-social-links a')) {
            return; // Exit if an interactive element inside the card was clicked.
        }

        // Add 'clicked' class to trigger the CSS animations for glitter shine and water-filled effects.
        card.classList.add('clicked');

        // Capture mouse position relative to the card for the water-filled effect origin.
        const rect = card.getBoundingClientRect();
        const mouseX = event.clientX - rect.left; // X position within the element.
        const mouseY = event.clientY - rect.top;  // Y position within the element.
        card.style.setProperty('--mouse-x', `${mouseX}px`); // Set CSS custom property for X.
        card.style.setProperty('--mouse-y', `${mouseY}px`); // Set CSS custom property for Y.

        // Remove the 'clicked' class after the animation duration to allow re-triggering.
        setTimeout(() => {
            card.classList.remove('clicked');
        }, 1200); // Matches the CSS transition duration for the glitter effect.
    });
});

//======================================================================
// CAROUSEL AUTO-SLIDING FEATURE (BI-DIRECTIONAL "TRAIN" MOVEMENT)
// This section controls the automatic, smooth, back-and-forth scrolling
// of the feedback cards carousel.
//======================================================================
const feedbackCarouselContainer = document.getElementById('feedbackCarouselContainer');
const feedbackCarouselTrack = document.getElementById('feedbackCarouselTrack');
const feedbackCards = document.querySelectorAll('.feedback-card'); // Get all individual feedback cards.

let currentScroll = 0; // Tracks the current scroll position of the carousel.
let scrollDirection = 1; // 1 for scrolling right, -1 for scrolling left.
let carouselAnimationFrameId; // Stores the ID of the requestAnimationFrame to allow stopping it.
const scrollSpeed = 2.0; // Defines the speed of the auto-sliding. Slightly slower for smoother motion.
const pauseAtEndDuration = 3000; // Duration (in milliseconds) to pause at the beginning/end of the track.

/**
 * Animates the feedback carousel, creating a continuous back-and-forth motion.
 */
function animateFeedbackCarousel() {
    // Calculate the total width of the track including gaps between cards.
    const trackWidth = feedbackCarouselTrack.scrollWidth;
    // Calculate the visible width of the carousel container.
    const containerWidth = feedbackCarouselContainer.clientWidth;
    // Calculate the maximum scrollable distance to the right.
    const maxScrollLeft = trackWidth - containerWidth;

    // If there are no cards or the content is smaller than the container, stop the animation.
    if (feedbackCards.length === 0 || maxScrollLeft <= 0) {
        cancelAnimationFrame(carouselAnimationFrameId); // Stop the animation loop.
        return;
    }

    // Update the current scroll position based on the scroll direction and speed.
    currentScroll += scrollDirection * scrollSpeed;

    // Check if the carousel has reached the end while scrolling right.
    if (scrollDirection === 1 && currentScroll >= maxScrollLeft) {
        currentScroll = maxScrollLeft; // Cap the scroll position at the maximum.
        scrollDirection = -1; // Reverse the direction to scroll left.
        // Pause the animation before reversing direction.
        cancelAnimationFrame(carouselAnimationFrameId);
        setTimeout(() => {
            carouselAnimationFrameId = requestAnimationFrame(animateFeedbackCarousel); // Restart animation after pause.
        }, pauseAtEndDuration);
    }
    // Check if the carousel has reached the beginning while scrolling left.
    else if (scrollDirection === -1 && currentScroll <= 0) {
        currentScroll = 0; // Cap the scroll position at the minimum (beginning).
        scrollDirection = 1; // Reverse the direction to scroll right.
        // Pause the animation before reversing direction.
        cancelAnimationFrame(carouselAnimationFrameId);
        setTimeout(() => {
            carouselAnimationFrameId = requestAnimationFrame(animateFeedbackCarousel); // Restart animation after pause.
        }, pauseAtEndDuration);
    }

    // Apply the calculated transform to the carousel track to simulate scrolling.
    feedbackCarouselTrack.style.transform = `translateX(-${currentScroll}px)`;

    // Continue the animation loop if it hasn't been cancelled (e.g., during a pause).
    if (carouselAnimationFrameId) {
        carouselAnimationFrameId = requestAnimationFrame(animateFeedbackCarousel);
    }
}

// Start auto-scrolling when the entire page content has loaded.
window.addEventListener('load', () => {
    carouselAnimationFrameId = requestAnimationFrame(animateFeedbackCarousel);
});

// Pause scrolling when the mouse hovers over the carousel container.
feedbackCarouselContainer.addEventListener('mouseover', () => {
    cancelAnimationFrame(carouselAnimationFrameId); // Stop the animation.
    carouselAnimationFrameId = null; // Explicitly set to null to indicate it's paused.
});

// Resume scrolling when the mouse leaves the carousel container.
feedbackCarouselContainer.addEventListener('mouseout', () => {
    if (!carouselAnimationFrameId) { // Only restart if it was actually paused.
        carouselAnimationFrameId = requestAnimationFrame(animateFeedbackCarousel);
    }
});

//======================================================================
// FIREWORK CRACKER EFFECT (Canvas Animation)
// This section handles the visual firework animation triggered on card clicks.
//======================================================================
const fireworkCanvas = document.getElementById('fireworkCanvas');
const fireworkCtx = fireworkCanvas.getContext('2d');

// Initialize canvas dimensions to match the window size.
fireworkCanvas.width = window.innerWidth;
fireworkCanvas.height = window.innerHeight;

// Adjust canvas size dynamically when the window is resized.
window.addEventListener('resize', () => {
    fireworkCanvas.width = window.innerWidth;
    fireworkCanvas.height = window.innerHeight;
});

/**
 * Generates a random number within a specified range.
 * @param {number} min The minimum value (inclusive).
 * @param {number} max The maximum value (inclusive).
 * @returns {number} A random number between min and max.
 */
function random(min, max) {
    return Math.random() * (max - min) + min;
}

/**
 * Creates an array of particle objects for a firework explosion.
 * @param {number} x The X coordinate of the explosion origin.
 * @param {number} y The Y coordinate of the explosion origin.
 * @returns {Array<Object>} An array of particle objects.
 */
function createParticles(x, y) {
    const particles = [];
    for (let i = 0; i < 70; i++) { // Generate 70 particles for a denser effect.
        particles.push({
            x, // Initial X position of the particle.
            y, // Initial Y position of the particle.
            radius: random(2.5, 5.5), // Random radius for varied particle sizes.
            color: `hsl(${Math.random() * 360}, 100%, 65%)`, // Random bright HSL color.
            dx: random(-7, 7), // Random horizontal velocity for initial spread.
            dy: random(-7, 7), // Random vertical velocity for initial spread.
            alpha: 1, // Initial opacity (fully opaque).
            gravity: 0.15 // Gravity applied to particles for a realistic fall.
        });
    }
    return particles;
}

let fireworks = []; // Array to store all active firework particle systems.

/**
 * Animates the firework particles on the canvas.
 * This function is called repeatedly using requestAnimationFrame.
 */
function animateFireworks() {
    fireworkCtx.clearRect(0, 0, fireworkCanvas.width, fireworkCanvas.height); // Clear the entire canvas for each frame.

    // Iterate over each firework particle system.
    fireworks.forEach((fw, index) => {
        // Iterate over each particle within the current firework.
        fw.forEach(p => {
            p.x += p.dx; // Update horizontal position.
            p.y += p.dy; // Update vertical position.
            p.dy += p.gravity; // Apply gravity to vertical velocity.
            p.alpha -= 0.03; // Gradually reduce opacity to fade out particles.

            fireworkCtx.beginPath(); // Start a new path for drawing the particle.
            fireworkCtx.arc(p.x, p.y, p.radius, 0, Math.PI * 2); // Draw a circle for the particle.
            // Set fill style with current color and fading alpha.
            fireworkCtx.fillStyle = `rgba(${p.color.match(/\d+/g).slice(0,3).join(",")},${p.alpha})`;
            fireworkCtx.fill(); // Fill the particle circle.
        });
        // Filter out particles that have faded completely (alpha <= 0).
        fireworks[index] = fw.filter(p => p.alpha > 0);
    });
    // Filter out firework systems that no longer have any active particles.
    fireworks = fireworks.filter(fw => fw.length > 0);

    requestAnimationFrame(animateFireworks); // Request the next animation frame.
}

animateFireworks(); // Start the main firework animation loop when the script loads.

/**
 * Triggers a new firework explosion at the specified event coordinates.
 * @param {MouseEvent} event The mouse event object, used to get click coordinates.
 */
function triggerFirework(event) {
    const x = event.clientX; // Get X coordinate of the click.
    const y = event.clientY; // Get Y coordinate of the click.
    fireworks.push(createParticles(x, y)); // Add a new set of particles to the fireworks array.
}

// Add firework trigger to feedback cards on click.
document.querySelectorAll('.feedback-card').forEach(card => {
    card.addEventListener('click', (event) => {
        // Only trigger firework if not clicking on a social link.
        if (!event.target.closest('.card-social-links a')) {
            triggerFirework(event); // Trigger firework at the click coordinates.
        }
    });
});

</script>
</body>
</html>


<?php include('footer.php'); ?>
