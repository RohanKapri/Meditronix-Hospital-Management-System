<?php
ob_start(); // Start output buffering
error_reporting(E_ALL); // Report all errors
ini_set('display_errors', 1); // Display errors
date_default_timezone_set('Asia/Kolkata'); // Set timezone to India Standard Time

// Include the header file for consistent page structure
// This file is assumed to contain necessary HTML head, body start, and navigation elements.
include("patientHeader.php");

// Establish database connection
// Replace 'localhost', 'root', '', 'meditronix_new' with your actual database credentials.
$db = mysqli_connect("localhost", "root", "", "meditronix_new");

// Check if the database connection was successful
if (!$db) {
    // If connection fails, display an error message and terminate script execution
    die("<div class='container mt-5'><div class='alert alert-danger'>❌ Failed to connect to database.</div></div>");
}

// Fetch feedback data from the 'feedback' table
// The query selects all relevant columns and orders results by creation date in descending order.
$feedback_query = "SELECT id, patient_id, `patients' _name` AS patient_name, message, rating, status, created_at FROM feedback ORDER BY created_at DESC";
$feedback_result = mysqli_query($db, $feedback_query);

// Check if there was an error executing the query
if (!$feedback_result) {
    $error_message = "Error fetching feedback data: " . mysqli_error($db);
    $feedback_result = false; // Set to false to indicate query failure
}

// Close the database connection after data retrieval
mysqli_close($db);
?>

<!-- External CSS Libraries and Fonts -->
<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Owl Carousel CSS for the carousel functionality -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<!-- Google Fonts for 'Poppins' and 'Rubik' -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@700;800;900&display=swap" rel="stylesheet">

<!-- Custom CSS for the Patient Feedback & Insights Portal -->
<style>
    /* Root variables for consistent theming and easy modification */
    :root {
        --primary-color: #0077b6; /* A vibrant blue for primary elements */
        --secondary-color: #023e8a; /* A deeper blue for contrast */
        --accent-color: #ff8c00; /* An energetic orange for highlights */
        --highlight-color-light: #ffc107; /* Lighter yellow for subtle highlights */

        /* Card background gradients for multi-color effect */
        --card-bg-light-pink: #fce4ec;
        --card-bg-light-blue: #e0f2f7;
        --card-bg-light-orange: #ffe0cc; /* Mixed light orange for containers */
        --card-multi-gradient: linear-gradient(145deg, var(--card-bg-light-pink) 0%, var(--card-bg-light-blue) 50%, var(--card-bg-light-orange) 100%);

        /* Text colors */
        --text-dark: #343a40; /* Dark grey for main text */
        --text-light: #6c757d; /* Lighter grey for secondary text */
        --text-heading-soft: rgba(2, 62, 138, 0.85); /* Soft blue for headings */
        --text-id-color: #c0392b; /* Reddish-brown for IDs */

        /* Status specific colors */
        --text-status-active: #28a745; /* Green for active status */
        --text-status-inactive: #dc3545; /* Red for inactive status */
        --text-status-pending: #ffc107; /* Yellow for pending status */

        /* Border and shadow effects */
        --border-color-light: #f0f0f0;
        --border-color-medium: rgba(255, 255, 255, 0.7);
        --shadow-light: rgba(0, 0, 0, 0.12);
        --shadow-medium: rgba(0, 0, 0, 0.25);
        --shadow-strong: rgba(0, 0, 0, 0.4);
        --shadow-inset: inset 0 0 20px rgba(0, 0, 0, 0.1);

        /* Transition speeds */
        --transition-speed-fast: 0.2s;
        --transition-speed-normal: 0.4s;
        --transition-speed-slow: 0.6s;

        /* Border radii for rounded corners */
        --border-radius-sm: 8px;
        --border-radius-md: 15px;
        --border-radius-lg: 25px;
        --border-radius-full: 50%;

        /* Full rainbow gradient for background */
        --rainbow-gradient-full: linear-gradient(45deg, #FF0000, #FF7F00, #FFFF00, #00FF00, #0000FF, #4B0082, #9400D3);

        /* Greyish blue and ruby diamond effect for background */
        --greyish-blue: #a7c5d9;
        --ruby-diamond-effect: radial-gradient(circle at center, rgba(248,224,224,0.5) 0%, rgba(217,184,184,0.3) 50%, rgba(167,197,217,0.1) 100%);
    }

    /* Base HTML and Body styles for a smooth, animated background */
    html {
        scroll-behavior: smooth; /* Smooth scrolling for navigation */
    }
    body {
        font-family: 'Poppins', sans-serif; /* Primary font */
        background: var(--rainbow-gradient-full); /* Initial rainbow background */
        background-size: 600% 600%; /* Large background size for animation */
        animation: rainbowBackground 40s ease infinite; /* Rainbow background animation */
        color: var(--text-dark); /* Default text color */
        line-height: 1.7; /* Improved readability */
        overflow-x: hidden; /* Prevent horizontal scrolling */
        min-height: 100vh; /* Full viewport height */
        display: flex;
        flex-direction: column;
        position: relative;
        padding: 0;
        margin: 0;
        perspective: 1200px; /* For 3D transformations */
        -webkit-font-smoothing: antialiased; /* Font rendering enhancements */
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
    }

    /* Keyframe animation for rainbow background movement */
    @keyframes rainbowBackground {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Pseudo-element for subtle shine effect on body, creating a ruby diamond overlay */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--ruby-diamond-effect); /* Ruby diamond effect */
        pointer-events: none; /* Allows clicks to pass through */
        z-index: -1; /* Behind other content */
        animation: subtleShine 15s infinite alternate ease-in-out; /* Subtle shine animation */
    }

    /* Keyframe animation for subtle shine */
    @keyframes subtleShine {
        0% { opacity: 0.8; transform: scale(1); }
        100% { opacity: 1; transform: scale(1.02); }
    }

    /* Pseudo-element for waterfall texture effect on body, adding depth */
    body::after {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('https://cdn.pixabay.com/photo/2025/03/24/15/10/ai-generated-9490956_1280.png'); /* Cube texture */
        background-repeat: repeat;
        background-size: 70px 70px;
        animation: waterfall 120s linear infinite; /* Waterfall animation for background texture */
        z-index: -2; /* Furthest back */
        opacity: 0.1; /* Very subtle */
        pointer-events: none;
    }

    /* Keyframe animation for waterfall effect */
    @keyframes waterfall {
        from { background-position: 0 0; }
        to { background-position: 140px 140px; }
    }

    /* Main container styling, making it visually appealing and responsive */
    .container-xxl {
        padding: 7rem 4rem; /* Generous padding */
        flex-grow: 1;
        background-color: rgba(255, 255, 255, 0.99); /* Slightly transparent white background */
        border-radius: var(--border-radius-lg); /* Rounded corners */
        box-shadow: 0 20px 60px var(--shadow-strong), 0 0 0 5px rgba(255,255,255,0.5); /* Strong shadow with white border */
        margin: 100px auto; /* Centered with top/bottom margin */
        max-width: 1800px; /* Increased max-width for content justification */
        min-width: 320px; /* Minimum width for small screens */
        position: relative;
        overflow: hidden; /* Hide overflowing content */
        border: 3px solid rgba(255, 255, 255, 0.9); /* White border */
        transform-style: preserve-3d; /* For 3D effects */
        perspective: 1000px;
        animation: containerEntrance 1.8s ease-out forwards; /* Entrance animation */
        background-image: url('https://cdn.pixabay.com/photo/2025/03/24/15/10/ai-generated-9490956_1280.png'); /* Placeholder background image */
        background-size: cover; /* Cover the entire container */
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed; /* Fixed background */
        transition: all 0.8s ease-in-out; /* Smooth transitions */
    }

    /* Pseudo-element for subtle gradient overlay on container, enhancing depth */
    .container-xxl::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        pointer-events: none;
        z-index: 3;
        border-radius: inherit;
    }

    /* Keyframe animation for container entrance effect */
    @keyframes containerEntrance {
        0% {
            opacity: 0;
            transform: translateY(80px) scale(0.9);
            filter: blur(8px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }
    }

    /* Section header styling for the main title and message */
    .section-header {
        text-align: center;
        margin-bottom: 80px;
        position: relative;
        z-index: 2;
        padding: 20px;
        background: rgba(255,255,255,0.1); /* Semi-transparent background */
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-medium);
        backdrop-filter: blur(10px); /* Frosted glass effect */
    }

    /* Main heading styling with flying and gradient effects */
    .main-heading {
        font-family: 'Rubik', sans-serif;
        font-size: 5.5rem;
        font-weight: 900;
        color: var(--secondary-color);
        margin-bottom: 25px;
        text-transform: uppercase;
        letter-spacing: 4px;
        position: relative;
        display: inline-block;
        text-shadow: 0 0 25px rgba(0, 119, 182, 0.8), 0 0 45px rgba(0, 119, 182, 0.6), 0 0 60px rgba(0, 119, 182, 0.4); /* Multiple text shadows for glow */
        -webkit-text-stroke: 2px var(--primary-color); /* Text stroke effect */
        color: transparent; /* Make text transparent to show background gradient */
        background-image: linear-gradient(45deg, var(--secondary-color), var(--primary-color), var(--accent-color));
        -webkit-background-clip: text; /* Clip background to text */
        background-clip: text;
        background-size: 200% auto; /* For gradient animation */
        animation: flyIn 2s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards, textGradientShine 6s linear infinite; /* Fly-in and gradient shine animations */
        will-change: transform, opacity, filter;
    }

    /* Pseudo-element for heading underline */
    .main-heading::after {
        content: '';
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        width: 180px;
        height: 10px;
        background: linear-gradient(to right, var(--primary-color), var(--accent-color), var(--secondary-color));
        border-radius: 5px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        animation: headingUnderlineGrow 2s ease-out forwards; /* Underline grow animation */
    }

    /* Keyframe animation for heading underline grow */
    @keyframes headingUnderlineGrow {
        0% { width: 0; opacity: 0; }
        100% { width: 180px; opacity: 1; }
    }

    /* Keyframe animation for heading fly-in effect */
    @keyframes flyIn {
        0% {
            opacity: 0;
            transform: translateY(-120px) scale(0.6) rotateX(30deg);
            filter: blur(20px) brightness(0.3);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1) rotateX(0deg);
            filter: blur(0px) brightness(1);
        }
    }

    /* Keyframe animation for text gradient shine */
    @keyframes textGradientShine {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Professional message styling */
    .professional-message {
        font-size: 1.45rem;
        color: var(--text-light);
        max-width: 1100px;
        margin: 0 auto 70px auto;
        padding: 30px 45px;
        background-color: rgba(255, 255, 255, 0.97);
        border-left: 12px solid var(--primary-color);
        border-radius: var(--border-radius-md);
        box-shadow: 0 10px 30px var(--shadow-light);
        line-height: 1.9;
        font-weight: 500;
        text-align: justify;
        border: 2px solid rgba(0, 119, 182, 0.15);
        transition: all var(--transition-speed-normal) cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
        overflow: hidden;
    }

    /* Pseudo-element for professional message hover effect */
    .professional-message::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transform: skewX(-20deg);
        transition: transform 0.5s ease-out;
        pointer-events: none;
    }

    /* Professional message hover effects */
    .professional-message:hover::before {
        transform: skewX(-20deg) translateX(200%);
    }
    .professional-message:hover {
        transform: translateY(-8px) scale(1.01);
        box-shadow: 0 15px 40px var(--shadow-medium);
        border-left-color: var(--accent-color);
    }

    /* Feedback card styling */
    .feedback-card {
        background: var(--card-multi-gradient); /* Multi-gradient background */
        border: 3px solid var(--border-color-medium);
        box-shadow: 0 15px 50px var(--shadow-light), var(--shadow-inset);
        border-radius: var(--border-radius-lg);
        padding: 50px; /* Increased padding for larger size */
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55); /* Smooth transition for hover */
        position: relative;
        overflow: hidden;
        cursor: pointer;
        z-index: 1;
        backdrop-filter: blur(8px) brightness(1.1); /* Frosted glass effect */
        transform-style: preserve-3d;
        transform: translateZ(0);
        animation: cardFloat 6s infinite alternate ease-in-out, cardShinePulse 4s infinite ease-in-out; /* Floating and shine pulse animations */
        will-change: transform, box-shadow, border-color;
    }

    /* Keyframe animation for card floating */
    @keyframes cardFloat {
        0% { transform: translateY(0px) rotateX(0deg) rotateY(0deg); }
        50% { transform: translateY(-8px) rotateX(0.8deg) rotateY(-0.8deg); }
        100% { transform: translateY(0px) rotateX(0deg) rotateY(0deg); }
    }

    /* Keyframe animation for card shine pulse */
    @keyframes cardShinePulse {
        0% { box-shadow: 0 15px 50px var(--shadow-light), var(--shadow-inset); }
        50% { box-shadow: 0 15px 50px rgba(0,0,0,0.2), inset 0 0 30px rgba(255,255,255,0.3); }
        100% { box-shadow: 0 15px 50px var(--shadow-light), var(--shadow-inset); }
    }

    /* Pseudo-element for glitter shining blade effect on hover/click */
    .feedback-card::before {
        content: '';
        position: absolute;
        top: -8px;
        left: -8px;
        right: -8px;
        bottom: -8px;
        background: linear-gradient(45deg, #FF007F, #00C6FF, #FF007F, #00C6FF, #FF007F, #00C6FF, #FF007F); /* Rainbow gradient for glitter */
        background-size: 800% 800%;
        z-index: -1;
        filter: blur(15px) brightness(1.5);
        opacity: 0;
        transition: opacity 0.6s ease-in-out;
        border-radius: var(--border-radius-lg);
        animation: glitterShine 4s linear infinite; /* Glitter animation */
        animation-play-state: paused; /* Paused until hover/active */
        will-change: opacity, background-position;
    }

    /* Pseudo-element for shining glaze effect on hover/click */
    .feedback-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: -200%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.6) 50%, rgba(255,255,255,0) 100%);
        transform: skewX(-25deg);
        transition: transform 0.8s ease-out;
        pointer-events: none;
        opacity: 0;
        z-index: 2;
        border-radius: var(--border-radius-lg);
        will-change: transform, opacity;
    }

    /* Activate glitter and glaze on hover/active */
    .feedback-card:hover::before,
    .feedback-card.active::before {
        opacity: 1;
        animation-play-state: running;
    }
    .feedback-card:hover::after,
    .feedback-card.active::after {
        opacity: 1;
        transform: skewX(-25deg) translateX(300%);
        transition: transform 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .feedback-card:not(:hover)::after {
        transform: skewX(-25deg) translateX(-200%);
        transition: transform 0.01s linear 1.5s; /* Reset quickly when not hovered */
        opacity: 0;
    }

    /* Feedback card hover transformation */
    .feedback-card:hover {
        transform: translateY(-20px) scale(1.06) rotateX(3deg) rotateY(3deg);
        box-shadow: 0 30px 70px var(--shadow-medium), inset 0 0 40px rgba(255,255,255,0.4);
        border-color: var(--accent-color);
    }

    /* Keyframe animation for glitter shine */
    @keyframes glitterShine {
        0% { background-position: 0% 50%; }
        100% { background-position: 100% 50%; }
    }

    /* Feedback icon styling */
    .feedback-icon {
        font-size: 6rem; /* Larger icon size */
        color: var(--primary-color);
        margin-bottom: 40px; /* More space below icon */
        transition: transform 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55), color 0.4s ease, filter 0.4s ease;
        text-shadow: 4px 4px 15px rgba(0, 119, 182, 0.5);
        animation: iconPulse 2.5s infinite alternate, iconGlow 3s infinite alternate; /* Pulse and glow animations */
        will-change: transform, color, filter;
    }

    /* Keyframe animation for icon pulse */
    @keyframes iconPulse {
        0% { transform: scale(1); }
        100% { transform: scale(1.05); }
    }

    /* Keyframe animation for icon glow */
    @keyframes iconGlow {
        0% { filter: drop-shadow(0 0 5px var(--primary-color)); }
        100% { filter: drop-shadow(0 0 15px var(--primary-color)) drop-shadow(0 0 25px rgba(0,119,182,0.5)); }
    }

    /* Feedback icon hover effects */
    .feedback-card:hover .feedback-icon {
        transform: rotateY(360deg) scale(1.25) rotateZ(5deg);
        color: var(--accent-color);
        filter: drop-shadow(0 0 20px var(--accent-color));
    }

    /* Generic feedback detail item styling for left alignment */
    .feedback-detail-item {
        font-size: 1.65rem; /* Increased text size */
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 18px; /* Increased margin for separation */
        line-height: 1.7; /* Improved line height */
        text-align: left; /* Align all content to the left */
        width: 100%;
        display: flex; /* Use flex for icon and text alignment */
        align-items: flex-start; /* Align items to the start of the cross axis */
        padding: 10px 0;
        position: relative;
    }
    .feedback-detail-item strong {
        color: var(--primary-color);
        font-weight: 700;
        display: inline-block;
        margin-right: 12px; /* Space between label and value */
        min-width: 160px; /* Ensure labels are aligned */
    }
    .feedback-detail-item span {
        display: inline-block;
        font-size: 1.45rem; /* Larger value text */
        color: var(--text-light);
        font-weight: 500;
        flex-grow: 1; /* Allow span to take remaining space */
        word-wrap: break-word; /* Ensure long words break */
        white-space: normal; /* Allow text to wrap naturally */
    }
    .feedback-detail-item i {
        color: var(--accent-color);
        font-size: 1.6em; /* Larger icons within details */
        margin-right: 15px; /* Space between icon and text */
        filter: drop-shadow(0 0 10px rgba(255,140,0,0.5)); /* Stronger glow for icons */
    }

    /* Specific styling for Patient Name (centered and unique) */
    .feedback-detail-item.patient-name-unique {
        font-family: 'Rubik', sans-serif;
        font-size: 3.5rem; /* Significantly larger for uniqueness */
        font-weight: 900;
        color: var(--text-heading-soft);
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.15), 0 0 15px rgba(255,255,255,0.6);
        background: linear-gradient(90deg, var(--secondary-color), var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        background-size: 200% auto;
        animation: nameShine 4s infinite alternate;
        padding-bottom: 20px; /* More space for underline */
        margin-top: 0; /* Align to top under icon */
        order: -1; /* Move to top of flex order */
        text-align: center; /* Keep patient name centered */
        display: block; /* Ensure it takes full width and centers */
    }
    .feedback-detail-item.patient-name-unique strong {
        display: none; /* Hide the "Patient Name" label */
    }
    .feedback-detail-item.patient-name-unique span {
        font-size: inherit; /* Inherit the large font size */
        font-weight: inherit;
        color: transparent; /* Inherit transparent color for gradient */
        background-clip: text;
        -webkit-background-clip: text;
        background-image: linear-gradient(90deg, var(--secondary-color), var(--primary-color), var(--accent-color));
        background-size: 200% auto;
        animation: nameShine 4s infinite alternate;
        display: block; /* Ensure it's on its own line */
    }
    .feedback-detail-item.patient-name-unique::after {
        content: '';
        position: absolute;
        bottom: 10px; /* Adjust position */
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        height: 8px; /* Thicker underline */
        background: linear-gradient(to right, transparent, var(--accent-color), transparent);
        opacity: 0.8;
        border-radius: 4px;
    }

    /* Keyframe animation for name shine */
    @keyframes nameShine {
        0% { background-position: 0% 50%; }
        100% { background-position: 100% 50%; }
    }

    /* Specific styling for Feedback ID (highlighted and unique) */
    .feedback-detail-item.id-unique {
        font-size: 1.8rem; /* Larger for ID */
        font-weight: 900;
        color: var(--text-id-color);
        padding: 12px 30px;
        background-color: rgba(255, 255, 255, 0.85);
        border-radius: var(--border-radius-md);
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2), inset 0 0 18px rgba(255,255,255,0.8);
        width: fit-content;
        margin: 20px auto; /* Centered with more margin */
        animation: idGlow 2.5s infinite alternate;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        border: 3px solid rgba(192,57,43,0.6);
        will-change: box-shadow;
        display: block; /* Ensure it's on its own line */
    }
    .feedback-detail-item.id-unique strong {
        display: none; /* Hide the "Feedback ID" label */
    }
    .feedback-detail-item.id-unique span {
        font-size: inherit; /* Inherit the larger font size */
        color: inherit; /* Inherit the ID color */
        display: inline; /* Keep the ID inline */
    }
    .feedback-detail-item.id-unique i {
        margin-right: 10px; /* Adjust icon spacing for ID */
    }

    /* Keyframe animation for ID glow */
    @keyframes idGlow {
        0% { box-shadow: 0 0 15px rgba(192,57,43,0.7), inset 0 0 12px rgba(255,255,255,0.5); }
        100% { box-shadow: 0 0 35px rgba(192,57,43,1), inset 0 0 25px rgba(255,255,255,0.9); }
    }

    /* Status button styling */
    .feedback-status {
        font-weight: 800;
        padding: 14px 28px; /* Larger padding */
        border-radius: 45px; /* More rounded */
        display: inline-block;
        margin-top: 28px; /* More margin */
        font-size: 1.3rem; /* Larger font size */
        text-transform: uppercase;
        letter-spacing: 1.8px; /* Increased letter spacing */
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.35); /* Stronger shadow */
        transition: all 0.3s ease;
        border: 5px solid transparent; /* Thicker border */
        cursor: default;
    }

    /* Status specific colors and animations */
    .status-active {
        background-color: var(--text-status-active);
        color: white;
        border-color: #218838;
        animation: statusGlowGreen 2s infinite alternate;
    }
    @keyframes statusGlowGreen {
        0% { box-shadow: 0 0 10px rgba(40,167,69,0.8); }
        100% { box-shadow: 0 0 25px rgba(40,167,69,1); }
    }
    .status-inactive {
        background-color: var(--text-status-inactive);
        color: white;
        border-color: #c82333;
        animation: statusGlowRed 2s infinite alternate;
    }
    @keyframes statusGlowRed {
        0% { box-shadow: 0 0 10px rgba(220,53,69,0.8); }
        100% { box-shadow: 0 0 25px rgba(220,53,69,1); }
    }
    .status-pending {
        background-color: var(--text-status-pending);
        color: var(--text-dark);
        border-color: #e0a800;
        animation: statusGlowYellow 2s infinite alternate;
    }
    @keyframes statusGlowYellow {
        0% { box-shadow: 0 0 10px rgba(255,193,7,0.8); }
        100% { box-shadow: 0 0 25px rgba(255,193,7,1); }
    }

    /* Status hover effect */
    .feedback-status:hover {
        transform: scale(1.1);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.6);
    }

    /* Action button group styling */
    .action-btn-group {
        display: flex;
        justify-content: center; /* Centered buttons */
        gap: 30px; /* More space between buttons */
        margin-top: 70px; /* More margin from top */
    }

    /* Action button base styling */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 25px 60px; /* Larger padding */
        border-radius: 50px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2.2px; /* More letter spacing */
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.5); /* Stronger shadow */
        text-decoration: none;
        border: none;
        cursor: pointer;
        outline: none;
        position: relative;
        overflow: hidden;
        z-index: 1;
        transform: translateZ(0);
    }

    /* Pseudo-element for button hover shine */
    .action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.4); /* Stronger shine effect */
        transform: skewX(-20deg);
        transition: transform 0.5s ease-out;
        z-index: -1;
    }

    /* Button hover shine effect */
    .action-btn:hover::before {
        transform: skewX(-20deg) translateX(200%);
    }

    /* Icon within button styling */
    .action-btn .fas {
        margin-right: 20px; /* More space for icon */
        transition: transform 0.4s ease;
    }

    /* Button hover transformations */
    .action-btn:hover {
        background-color: #e67e22; /* Specific hover color */
        transform: translateY(-18px) scale(1.08); /* More pronounced lift and scale */
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8); /* Even stronger shadow */
        filter: brightness(1.3); /* Brighter on hover */
    }

    /* Icon within button hover transformation */
    .action-btn:hover .fas {
        transform: translateX(15px) rotate(30deg); /* More pronounced icon movement */
    }

    /* Add Feedback button specific styling */
    .add-feedback-btn {
        background-color: var(--primary-color);
        color: white;
        margin-top: 50px; /* Margin to separate from carousel */
        display: block; /* Ensure it takes full width for centering */
        width: fit-content; /* Adjust width to content */
        margin-left: auto; /* Center the button */
        margin-right: auto; /* Center the button */
    }
    .add-feedback-btn:hover {
        background-color: var(--secondary-color);
    }

    /* Owl Carousel custom padding for items */
    .owl-carousel .owl-item {
        padding: 30px;
    }

    /* Owl Carousel navigation buttons */
    .owl-nav {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
        pointer-events: none; /* Allow clicks to pass through to cards */
        z-index: 10;
    }
    .owl-nav button.owl-prev,
    .owl-nav button.owl-next {
        background-color: var(--primary-color) !important;
        color: white !important;
        border-radius: var(--border-radius-full) !important;
        width: 85px; /* Larger nav buttons */
        height: 85px; /* Larger nav buttons */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.2rem !important; /* Larger nav icon */
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        box-shadow: 0 18px 40px var(--shadow-medium); /* Stronger shadow */
        pointer-events: all; /* Make buttons clickable */
        border: 5px solid rgba(255, 255, 255, 0.8) !important; /* Thicker border */
        margin: 0 45px; /* More margin */
        outline: none;
        filter: drop-shadow(0 0 15px rgba(0,119,182,0.7)); /* Stronger glow */
    }

    /* Owl Carousel navigation hover effects */
    .owl-nav button.owl-prev:hover,
    .owl-nav button.owl-next:hover {
        background-color: var(--secondary-color) !important;
        transform: scale(1.4); /* More pronounced scale */
        box-shadow: 0 30px 70px var(--shadow-strong); /* Even stronger shadow */
        border-color: var(--accent-color) !important;
        filter: drop-shadow(0 0 30px var(--accent-color)); /* Even stronger glow */
    }

    /* Owl Carousel dots styling */
    .owl-dots {
        text-align: center;
        margin-top: 100px; /* More margin */
        z-index: 5;
    }
    .owl-dots .owl-dot {
        width: 28px; /* Larger dots */
        height: 28px; /* Larger dots */
        background: #d0d5db;
        border-radius: var(--border-radius-full);
        display: inline-block;
        margin: 0 22px; /* More margin */
        transition: all 0.4s ease;
        border: 6px solid transparent; /* Thicker border */
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.25); /* Stronger shadow */
    }

    /* Owl Carousel active dot styling and animation */
    .owl-dots .owl-dot.active {
        background: var(--primary-color);
        transform: scale(1.8); /* More pronounced scale */
        border-color: var(--accent-color);
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.5); /* Stronger shadow */
        animation: dotPulse 1.5s infinite alternate;
    }

    /* Keyframe animation for dot pulse */
    @keyframes dotPulse {
        0% { transform: scale(1.8); box-shadow: 0 10px 22px rgba(0, 0, 0, 0.5); }
        100% { transform: scale(1.9); box-shadow: 0 12px 25px rgba(0, 0, 0, 0.6); }
    }

    /* Popup message styling for detailed view */
    #popup-message {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: linear-gradient(135deg, #f0f8ff, #e6f7ff);
        border: 3px solid var(--primary-color);
        border-radius: var(--border-radius-lg);
        padding: 40px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
        z-index: 1000;
        text-align: center;
        font-family: 'Poppins', sans-serif;
        font-size: 1.8rem;
        color: var(--secondary-color);
        display: none; /* Hidden by default */
        opacity: 0;
        transition: opacity 0.6s ease-in-out, transform 0.6s ease-in-out;
        width: 95%;
        max-width: 600px;
        animation: popupAppear 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        backdrop-filter: blur(15px);
        border-image: linear-gradient(45deg, #ff007f, #00c6ff) 1;
        overflow: hidden;
    }

    /* Pseudo-element for popup border shine */
    #popup-message::before {
        content: '';
        position: absolute;
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        border: 5px solid transparent;
        border-radius: inherit;
        background: linear-gradient(45deg, #ff007f, #00c6ff) border-box;
        -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: destination-out;
        mask-composite: exclude;
        z-index: -1;
        animation: popupBorderShine 3s linear infinite;
    }

    /* Keyframe animation for popup border shine */
    @keyframes popupBorderShine {
        0% { border-image-source: linear-gradient(45deg, #ff007f, #00c6ff); }
        25% { border-image-source: linear-gradient(90deg, #00c6ff, #ff007f); }
        50% { border-image-source: linear-gradient(135deg, #ff007f, #00c6ff); }
        75% { border-image-source: linear-gradient(180deg, #00c6ff, #ff007f); }
        100% { border-image-source: linear-gradient(45deg, #ff007f, #00c6ff); }
    }

    /* Popup message center text styling */
    #popup-message center {
        font-size: 2.2rem;
        font-weight: 900;
        margin-top: 15px;
        color: var(--accent-color);
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2), 0 0 10px rgba(255,140,0,0.5);
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    /* Keyframe animation for popup appearance */
    @keyframes popupAppear {
        0% { opacity: 0; transform: translate(-50%, -60%) scale(0.8); filter: blur(10px); }
        100% { opacity: 1; transform: translate(-50%, -50%) scale(1); filter: blur(0); }
    }

    /* Firework canvas styling for celebratory effects */
    #fireworkCanvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 999;
        pointer-events: none; /* Allows clicks to pass through */
        display: none; /* Hidden by default */
        background: rgba(0,0,0,0.1); /* Slight overlay */
    }

    /* Responsive adjustments for various screen sizes */
    @media (max-width: 1400px) {
        .container-xxl {
            padding: 5rem 2.5rem;
            margin: 60px auto;
            max-width: 1600px; /* Adjust max-width for smaller large screens */
        }
        .main-heading {
            font-size: 4.5rem;
        }
        .professional-message {
            font-size: 1.3rem;
        }
        .feedback-card {
            padding: 40px;
        }
        .feedback-icon {
            font-size: 5rem;
        }
        .feedback-detail-item {
            font-size: 1.4rem;
            margin-bottom: 15px;
        }
        .feedback-detail-item strong {
            min-width: 140px;
        }
        .feedback-detail-item span {
            font-size: 1.2rem;
        }
        .feedback-detail-item.patient-name-unique {
            font-size: 2.8rem;
            padding-bottom: 15px;
        }
        .feedback-detail-item.id-unique {
            font-size: 1.6rem;
            padding: 10px 25px;
            margin: 15px auto;
        }
        .feedback-status {
            padding: 12px 25px;
            font-size: 1.1rem;
            margin-top: 25px;
        }
        .action-btn {
            padding: 20px 50px;
            font-size: 1rem;
            margin-top: 60px;
        }
        .owl-nav button {
            width: 75px !important;
            height: 75px !important;
            font-size: 2.8rem !important;
            margin: 0 35px;
        }
        .owl-dots {
            margin-top: 80px;
        }
        .owl-dots .owl-dot {
            width: 22px;
            height: 22px;
            margin: 0 18px;
        }
    }
    @media (max-width: 1200px) {
        .container-xxl {
            max-width: 1300px; /* Further adjust max-width */
            padding: 4rem 2rem;
            margin: 50px auto;
        }
        .main-heading {
            font-size: 4rem;
            letter-spacing: 2px;
        }
        .main-heading::after {
            width: 130px;
            height: 7px;
        }
        .professional-message {
            font-size: 1.2rem;
            padding: 20px 30px;
            margin-bottom: 50px;
        }
        .feedback-card {
            padding: 35px;
        }
        .feedback-icon {
            font-size: 4.5rem;
            margin-bottom: 30px;
        }
        .feedback-detail-item {
            font-size: 1.3rem;
            margin-bottom: 12px;
        }
        .feedback-detail-item strong {
            min-width: 130px;
        }
        .feedback-detail-item span {
            font-size: 1.15rem;
        }
        .feedback-detail-item.patient-name-unique {
            font-size: 2.5rem;
            padding-bottom: 12px;
        }
        .feedback-detail-item.id-unique {
            font-size: 1.4rem;
            padding: 8px 20px;
            margin: 12px auto;
        }
        .feedback-status {
            padding: 10px 22px;
            font-size: 1rem;
            margin-top: 20px;
        }
        .action-btn {
            padding: 18px 45px;
            font-size: 0.95rem;
            margin-top: 50px;
        }
        .owl-nav button {
            width: 65px !important;
            height: 65px !important;
            font-size: 2.4rem !important;
            margin: 0 25px;
        }
        .owl-dots {
            margin-top: 60px;
        }
        .owl-dots .owl-dot {
            width: 18px;
            height: 18px;
            margin: 0 12px;
        }
    }
    @media (max-width: 992px) {
        .container-xxl {
            max-width: 960px; /* Further adjust max-width */
            padding: 4rem 2rem;
            margin: 50px auto;
        }
        .main-heading {
            font-size: 3.5rem;
            letter-spacing: 1.5px;
        }
        .main-heading::after {
            width: 110px;
            height: 6px;
        }
        .professional-message {
            font-size: 1.1rem;
            padding: 18px 25px;
            margin-bottom: 40px;
            border-left-width: 8px;
        }
        .owl-nav {
            display: none; /* Hide nav buttons on smaller screens */
        }
        .owl-dots {
            margin-top: 50px;
        }
        .feedback-card {
            padding: 30px;
        }
        .feedback-icon {
            font-size: 3.8rem;
            margin-bottom: 25px;
        }
        .feedback-detail-item {
            font-size: 1.1rem;
            margin-bottom: 10px;
        }
        .feedback-detail-item strong {
            min-width: 110px;
        }
        .feedback-detail-item span {
            font-size: 1rem;
        }
        .feedback-detail-item.patient-name-unique {
            font-size: 2.2rem;
            padding-bottom: 10px;
        }
        .feedback-detail-item.id-unique {
            font-size: 1.2rem;
            padding: 6px 15px;
            margin: 10px auto;
        }
        .feedback-status {
            padding: 8px 18px;
            font-size: 0.9rem;
            margin-top: 15px;
        }
        .action-btn {
            padding: 15px 35px;
            font-size: 0.85rem;
            margin-top: 40px;
        }
        .owl-dots .owl-dot {
            width: 16px;
            height: 16px;
            margin: 0 10px;
        }
    }
    @media (max-width: 768px) {
        .container-xxl {
            max-width: 720px; /* Further adjust max-width */
            padding: 3rem 1.5rem;
            margin: 40px auto;
        }
        .main-heading {
            font-size: 2.8rem;
            letter-spacing: 1px;
        }
        .main-heading::after {
            width: 90px;
            height: 5px;
            bottom: -12px;
        }
        .professional-message {
            font-size: 1rem;
            margin-bottom: 30px;
            padding: 15px 20px;
            border-left-width: 6px;
        }
        .feedback-card {
            padding: 25px;
        }
        .feedback-icon {
            font-size: 3.2rem;
            margin-bottom: 20px;
        }
        .feedback-detail-item {
            font-size: 1rem;
            margin-bottom: 8px;
        }
        .feedback-detail-item strong {
            min-width: 90px;
        }
        .feedback-detail-item span {
            font-size: 0.9rem;
        }
        .feedback-detail-item.patient-name-unique {
            font-size: 1.8rem;
            padding-bottom: 8px;
        }
        .feedback-detail-item.id-unique {
            font-size: 1rem;
            padding: 4px 10px;
            margin: 8px auto;
        }
        .feedback-status {
            padding: 6px 15px;
            font-size: 0.8rem;
            margin-top: 12px;
        }
        .action-btn {
            padding: 12px 30px;
            font-size: 0.75rem;
            margin-top: 30px;
        }
        .action-btn .fas {
            margin-right: 10px;
        }
        .owl-dots {
            margin-top: 40px;
        }
        .owl-dots .owl-dot {
            width: 14px;
            height: 14px;
            margin: 0 8px;
        }
    }
    @media (max-width: 576px) {
        .container-xxl {
            max-width: 540px; /* Further adjust max-width */
            padding: 2.5rem 1rem;
            margin: 25px auto;
        }
        .section-header {
            margin-bottom: 30px;
        }
        .main-heading {
            font-size: 2rem;
            letter-spacing: 0.5px;
            -webkit-text-stroke: 1px var(--primary-color);
        }
        .main-heading::after {
            width: 60px;
            height: 3px;
            bottom: -8px;
        }
        .professional-message {
            font-size: 0.8rem;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-left-width: 4px;
        }
        .feedback-card {
            padding: 20px;
            margin: 0;
        }
        .feedback-icon {
            font-size: 2.8rem;
            margin-bottom: 15px;
        }
        .feedback-detail-item {
            font-size: 0.85rem;
            margin-bottom: 6px;
        }
        .feedback-detail-item strong {
            min-width: 70px;
        }
        .feedback-detail-item span {
            font-size: 0.75rem;
        }
        .feedback-detail-item.patient-name-unique {
            font-size: 1.5rem;
            padding-bottom: 6px;
        }
        .feedback-detail-item.id-unique {
            font-size: 0.9rem;
            padding: 3px 8px;
            margin: 6px auto;
        }
        .feedback-status {
            padding: 5px 12px;
            font-size: 0.7rem;
            margin-top: 10px;
        }
        .action-btn {
            padding: 10px 25px;
            font-size: 0.65rem;
            margin-top: 20px;
        }
        .action-btn .fas {
            margin-right: 8px;
        }
        .owl-dots {
            margin-top: 30px;
        }
        .owl-dots .owl-dot {
            width: 12px;
            height: 12px;
            margin: 0 5px;
        }
    }
</style>

<!-- Main container for the Patient Feedback & Insights portal -->
<div class="container-xxl py-5">
    <div class="section-header wow fadeInUp" data-wow-delay="0.1s">
        <!-- Main attractive heading -->
        <h1 class="main-heading">Patient Feedback & Insights ✨</h1>
        <!-- Professional message under the heading -->
        <p class="professional-message">
            Your voice shapes our future. Share your valuable feedback and insights to help us continuously enhance our services and patient care.
            Every comment contributes to a better healthcare experience for everyone.
        </p>
    </div>

    <!-- Owl Carousel for displaying feedback cards -->
    <div class="owl-carousel feedback-carousel">
        <?php
        // Check if feedback data was successfully fetched and if there are any rows
        if ($feedback_result && mysqli_num_rows($feedback_result) > 0) :
            // Array of diverse icons for each feedback card
            $icon_classes = [
                'fas fa-comments', 'fas fa-heart', 'fas fa-lightbulb', 'fas fa-star',
                'fas fa-comment-dots', 'fas fa-thumbs-up', 'fas fa-smile', 'fas fa-user-check',
                'fas fa-clipboard-list', 'fas fa-chart-line', 'fas fa-award', 'fas fa-handshake',
                'fas fa-brain', 'fas fa-shield-alt', 'fas fa-feather-alt', 'fas fa-quote-right',
                'fas fa-comment-alt', 'fas fa-envelope-open-text', 'fas fa-user-shield', 'fas fa-trophy',
                'fas fa-cloud-upload-alt', 'fas fa-check-double', 'fas fa-hands-helping', 'fas fa-seedling',
                'fas fa-grin-stars', 'fas fa-gem', 'fas fa-infinity', 'fas fa-compass',
                'fas fa-sun', 'fas fa-moon', 'fas fa-globe', 'fas fa-leaf',
                'fas fa-fire', 'fas fa-bolt', 'fas fa-crown', 'fas fa-rocket',
                'fas fa-magic', 'fas fa-sparkles', 'fas fa-gift', 'fas fa-bell',
                'fas fa-map-marked-alt', 'fas fa-fingerprint', 'fas fa-yin-yang', 'fas fa-peace',
                'fas fa-holly-berry', 'fas fa-cloud-sun', 'fas fa-water', 'fas fa-wind',
                'fas fa-mountain', 'fas fa-tree', 'fas fa-flower', 'fas fa-rainbow',
                'fas fa-meteor', 'fas fa-satellite-dish', 'fas fa-robot', 'fas fa-brain-circuit',
                'fas fa-dna', 'fas fa-atom', 'fas fa-microchip', 'fas fa-server',
                'fas fa-database', 'fas fa-code', 'fas fa-bug', 'fas fa-terminal',
                'fas fa-network-wired', 'fas fa-cloud-meatball', 'fas fa-cookie-bite', 'fas fa-pizza-slice'
            ];
            $icon_index = 0; // Initialize icon index

            // Loop through each fetched feedback row
            while ($row = mysqli_fetch_assoc($feedback_result)) :
                // Sanitize and store data for display
                $id = htmlspecialchars($row['id']);
                $patient_id = htmlspecialchars($row['patient_id']);
                $patient_name = htmlspecialchars($row['patient_name']);
                $message = htmlspecialchars($row['message']);
                $rating = htmlspecialchars($row['rating']);
                $status = htmlspecialchars($row['status']);
                $created_at = htmlspecialchars($row['created_at']);

                // Determine CSS class for status based on its value
                $status_class = '';
                switch (strtolower($status)) {
                    case 'active':
                        $status_class = 'status-active';
                        break;
                    case 'inactive':
                        $status_class = 'status-inactive';
                        break;
                    case 'pending':
                        $status_class = 'status-pending';
                        break;
                    default:
                        $status_class = 'status-inactive'; // Default status
                }

                // Get the current icon from the array and increment index
                $current_icon = $icon_classes[$icon_index % count($icon_classes)];
                $icon_index++;
        ?>
                <!-- Individual feedback card -->
                <div class="feedback-card text-center">
                    <!-- Dynamic icon for the card -->
                    <i class="feedback-icon <?= $current_icon ?>"></i>

                    <!-- Patient Name - Centered and unique styling -->
                    <p class="feedback-detail-item patient-name-unique">
                        <span><?= $patient_name ?></span>
                    </p>

                    <!-- Patient ID - Left-aligned with label on new line -->
                    <p class="feedback-detail-item">
                        <i class="fas fa-id-badge"></i> <strong>Patient ID:</strong> <br><span><?= $patient_id ?></span>
                    </p>

                    <!-- Feedback ID - Highlighted and unique styling -->
                    <p class="feedback-detail-item id-unique">
                        <i class="fas fa-comment-alt"></i> <span>ID: <?= $id ?></span>
                    </p>

                    <!-- Message - Left-aligned with label on new line -->
                    <p class="feedback-detail-item">
                        <i class="fas fa-comment"></i> <strong>Message:</strong> <br><span><?= $message ?></span>
                    </p>

                    <!-- Rating - Left-aligned with label on new line -->
                    <p class="feedback-detail-item">
                        <i class="fas fa-star"></i> <strong>Rating:</strong> <br><span><?= $rating ?> ★</span>
                    </p>

                    <!-- Status - Left-aligned with label and styled button -->
                    <p class="feedback-detail-item">
                        <i class="fas fa-info-circle"></i> <strong>Status:</strong> <br><span class="feedback-status <?= $status_class ?>"><?= ucfirst($status) ?></span>
                    </p>

                    <!-- Created At - Left-aligned with label on new line -->
                    <p class="feedback-detail-item">
                        <i class="fas fa-calendar-alt"></i> <strong>Created At:</strong> <br><span><?= date('d M, Y H:i', strtotime($created_at)) ?></span>
                    </p>
                </div>
            <?php
            endwhile;
        else :
        ?>
            <!-- Message displayed if no feedback is found -->
            <div class="col-12 text-center py-5">
                <p class="professional-message">No feedback has been submitted yet. Please check back later!</p>
                <?php if (isset($error_message)) : ?>
                    <p class="text-danger">Error: <?= $error_message ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Add Feedback Button (outside carousel, centered) -->
    <div class="text-center mt-5">
        <a href="add_feedback.php" target="_blank" class="action-btn add-feedback-btn">
            <i class="fas fa-plus-circle me-2"></i> Add Feedback
        </a>
    </div>

    <!-- Social Links Section -->
    <div class="social-links-section text-center mt-5 py-4" style="background: rgba(255,255,255,0.1); border-radius: var(--border-radius-md); box-shadow: var(--shadow-light); backdrop-filter: blur(5px);">
        <h3 style="font-family: 'Rubik', sans-serif; color: var(--secondary-color); font-size: 2.5rem; margin-bottom: 30px; text-shadow: 1px 1px 5px rgba(0,0,0,0.1);">Connect With Us!</h3>
        <div class="d-flex justify-content-center gap-4">
            <a href="https://www.facebook.com/yourpage" target="_blank" class="social-icon" style="color: #3b5998; font-size: 3rem; transition: transform 0.3s ease, color 0.3s ease;">
                <i class="fab fa-facebook-square"></i>
            </a>
            <a href="https://www.twitter.com/yourpage" target="_blank" class="social-icon" style="color: #00acee; font-size: 3rem; transition: transform 0.3s ease, color 0.3s ease;">
                <i class="fab fa-twitter-square"></i>
            </a>
            <a href="https://www.instagram.com/yourpage" target="_blank" class="social-icon" style="color: #E1306C; font-size: 3rem; transition: transform 0.3s ease, color 0.3s ease;">
                <i class="fab fa-instagram-square"></i>
            </a>
            <a href="https://www.linkedin.com/company/yourcompany" target="_blank" class="social-icon" style="color: #0077B5; font-size: 3rem; transition: transform 0.3s ease, color 0.3s ease;">
                <i class="fab fa-linkedin"></i>
            </a>
            <a href="mailto:info@yourcompany.com" class="social-icon" style="color: #D44638; font-size: 3rem; transition: transform 0.3s ease, color 0.3s ease;">
                <i class="fas fa-envelope-square"></i>
            </a>
        </div>
    </div>
</div>

<!-- Popup message for glitter effect and firework display -->
<div id="popup-message">
    ✨ Your Feedback is Valued! ✨
    <br>
    <center>✨MEDITRONIX FEEDBACK PORTAL✨</center>
</div>

<!-- Canvas for firework animations -->
<canvas id="fireworkCanvas"></canvas>

<!-- External JavaScript Libraries -->
<!-- jQuery for DOM manipulation and Owl Carousel -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Owl Carousel JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<!-- Bootstrap Bundle JavaScript for responsive features (if any are used by the theme) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JavaScript for carousel functionality and interactive effects -->
<script>
    $(document).ready(function() {
        const feedbackCarousel = $('.feedback-carousel');

        // Initialize Owl Carousel with specified options
        feedbackCarousel.owlCarousel({
            loop: true, // Enable infinite loop
            margin: 30, // Space between items
            nav: true, // Enable navigation buttons
            dots: true, // Enable pagination dots
            autoplay: true, // Enable auto-play
            autoplayTimeout: 5000, // Auto-play interval (5 seconds)
            autoplayHoverPause: true, // Pause auto-play on hover
            smartSpeed: 1200, // Speed of transitions
            responsive: {
                0: { items: 1, nav: false }, // 1 item on extra small screens, no nav
                600: { items: 2, nav: true }, // 2 items on small screens, show nav
                1000: { items: 3, nav: true } // 3 items on large screens, show nav
            },
            navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'] // Custom nav icons
        });

        // Function to set equal height for all active feedback cards
        function setEqualCardHeight() {
            let maxHeight = 0;
            // Reset height to auto before calculating to ensure correct measurement
            $('.feedback-carousel .owl-item .feedback-card').css('height', 'auto');
            // Iterate over active items to find the maximum height
            $('.feedback-carousel .owl-item.active').each(function() {
                let currentHeight = $(this).find('.feedback-card').outerHeight();
                if (currentHeight > maxHeight) {
                    maxHeight = currentHeight;
                }
            });
            // Apply the maximum height to all feedback cards
            $('.feedback-carousel .owl-item .feedback-card').css('height', maxHeight + 'px');
        }

        // Call the function on document ready and window resize
        setEqualCardHeight();
        $(window).on('resize', setEqualCardHeight);

        // Re-calculate height after carousel initialization, resizing, or content change
        feedbackCarousel.on('initialized.owl.carousel resized.owl.carousel changed.owl.carousel', function(event) {
            setTimeout(setEqualCardHeight, 100); // Small delay to ensure elements are rendered
        });

        // Popup message and firework canvas elements
        const popupMessage = $('#popup-message');
        const fireworkCanvas = $('#fireworkCanvas')[0];
        const ctx = fireworkCanvas.getContext('2d'); // 2D rendering context

        let particles = []; // Array to store firework particles
        let fireworks = []; // Array to store firework rockets

        // Function to resize the canvas to fill the window
        function resizeCanvas() {
            fireworkCanvas.width = window.innerWidth;
            fireworkCanvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resizeCanvas); // Listen for window resize events
        resizeCanvas(); // Initial canvas resize

        // Particle class for individual firework sparks
        function Particle(x, y, color, velocity) {
            this.x = x;
            this.y = y;
            this.color = color;
            this.velocity = velocity;
            this.alpha = 1; // Opacity of the particle
            this.friction = 0.99; // Reduces velocity over time
            this.gravity = 0.05; // Pulls particle downwards

            this.draw = function() {
                ctx.save(); // Save current canvas state
                ctx.beginPath();
                ctx.arc(this.x, this.y, 1.5, 0, Math.PI * 2, false); // Draw a small circle
                ctx.fillStyle = `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${this.alpha})`; // Apply color with current alpha
                ctx.fill();
                ctx.restore(); // Restore canvas state
            };

            this.update = function() {
                this.velocity.x *= this.friction;
                this.velocity.y *= this.friction;
                this.velocity.y += this.gravity;
                this.x += this.velocity.x;
                this.y += this.velocity.y;
                this.alpha -= 0.01; // Fade out over time
                if (this.alpha <= 0) {
                    this.alpha = 0;
                }
                this.draw(); // Redraw the particle
            };
        }

        // Firework class for the rockets that explode into particles
        function Firework(x, y, targetX, targetY, color) {
            this.x = x;
            this.y = y;
            this.targetX = targetX;
            this.targetY = targetY;
            this.color = color;
            this.velocity = { x: 0, y: 0 };
            this.alpha = 1;
            this.speed = 2; // Speed of the rocket

            this.draw = function() {
                ctx.save();
                ctx.beginPath();
                ctx.arc(this.x, this.y, 2, 0, Math.PI * 2, false); // Draw the rocket
                ctx.fillStyle = `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${this.alpha})`;
                ctx.fill();
                ctx.restore();
            };

            this.update = function() {
                let dx = this.targetX - this.x;
                let dy = this.targetY - this.y;
                let dist = Math.sqrt(dx * dx + dy * dy); // Distance to target

                if (dist < this.speed) {
                    this.explode(); // Explode if close to target
                    return false; // Remove firework from array
                }

                // Move towards target
                this.x += dx / dist * this.speed;
                this.y += dy / dist * this.speed;
                this.draw();
                return true; // Keep firework in array
            };

            // Explode function to create particles
            this.explode = function() {
                for (let i = 0; i < 100; i++) { // Create 100 particles
                    const angle = Math.random() * Math.PI * 2; // Random angle
                    const velocity = {
                        x: Math.cos(angle) * (Math.random() * 5 + 2), // Random speed
                        y: Math.sin(angle) * (Math.random() * 5 + 2)
                    };
                    particles.push(new Particle(this.x, this.y, this.color, velocity));
                }
            };
        }

        // Animation loop for fireworks
        function animateFireworks() {
            requestAnimationFrame(animateFireworks); // Request next frame
            ctx.fillStyle = 'rgba(0, 0, 0, 0.05)'; // Clear canvas with slight fade effect
            ctx.fillRect(0, 0, fireworkCanvas.width, fireworkCanvas.height);

            // Update and draw fireworks
            for (let i = fireworks.length - 1; i >= 0; i--) {
                if (!fireworks[i].update()) {
                    fireworks.splice(i, 1); // Remove completed fireworks
                }
            }

            // Update and draw particles
            for (let i = particles.length - 1; i >= 0; i--) {
                if (particles[i].alpha <= 0) {
                    particles.splice(i, 1); // Remove faded particles
                } else {
                    particles[i].update();
                }
            }
        }

        // Helper function to get a random RGB color
        function getRandomColor() {
            return {
                r: Math.floor(Math.random() * 255),
                g: Math.floor(Math.random() * 255),
                b: Math.floor(Math.random() * 255)
            };
        }

        // Function to launch a single firework
        function launchFirework() {
            const startX = fireworkCanvas.width / 2; // Start from bottom center
            const startY = fireworkCanvas.height;
            const targetX = Math.random() * fireworkCanvas.width; // Random target X
            const targetY = Math.random() * fireworkCanvas.height / 2; // Target in upper half
            fireworks.push(new Firework(startX, startY, targetX, targetY, getRandomColor()));
        }

        // Event listener for clicking on feedback cards
        $(document).on('click', '.feedback-card', function() {
            // Remove 'active' class from all cards and add to the clicked one
            $('.feedback-card').removeClass('active');
            $(this).addClass('active');

            // Get the feedback ID from the clicked card
            const feedbackId = $(this).find('.feedback-detail-item.id-unique span').text().replace('ID: ', '').trim();

            // Update popup message content
            popupMessage.find('br').first().remove(); // Remove existing line break if any
            popupMessage.find('center').html(`✨ Feedback ID: ${feedbackId} Details ✨`);

            // Show popup message with animation
            popupMessage.css({ display: 'block', opacity: 0 }).animate({ opacity: 1 }, 500);

            // Show firework canvas and launch fireworks
            fireworkCanvas.style.display = 'block';
            particles = []; // Clear existing particles
            fireworks = []; // Clear existing fireworks
            for (let i = 0; i < 3; i++) {
                setTimeout(launchFirework, i * 500); // Launch multiple fireworks with delay
            }

            // Hide popup and fireworks after a delay
            setTimeout(() => {
                popupMessage.animate({ opacity: 0 }, 500, function() {
                    $(this).css('display', 'none');
                });
                fireworkCanvas.style.display = 'none';
                $(this).removeClass('active'); // Remove active class from card
            }, 5000); // Popup and fireworks visible for 5 seconds
        });

        animateFireworks(); // Start the firework animation loop
    });
</script>

<?php
// PHP code for SQL queries (as comments) - for reference
// These queries are illustrative and would be executed in a backend script.

// SELECT Query: Fetches all feedback entries
/*
SELECT id, patient_id, `patients' _name`, message, rating, status, created_at FROM feedback ORDER BY created_at DESC
*/

// INSERT Query: Inserts a new feedback entry
/*
INSERT INTO `feedback` (`id`, `patient_id`, `patients' _name`, `message`, `rating`, `status`, `created_at`)
VALUES (NULL, '[patient_id]', '[patient_name]', '[message]', '[rating]', '[status]', CURRENT_TIMESTAMP)
*/

// UPDATE Query: Updates an existing feedback entry by ID
/*
UPDATE `feedback`
SET
    `patient_id` = '[new_patient_id]',
    `patients' _name` = '[new_patient_name]',
    `message` = '[new_message]',
    `rating` = '[new_rating]',
    `status` = '[new_status]'
WHERE `id` = '[feedback_id_to_update]'
*/

// DELETE Query: Deletes a feedback entry by ID
/*
DELETE FROM `feedback` WHERE `id` = '[feedback_id_to_delete]'
*/

// Include the footer file for consistent page structure
// This file is assumed to contain necessary HTML body end and closing tags.
include("patientFooter.php");
ob_end_flush(); // End output buffering and send content to browser
?>
