<?php
include("patientHeader.php");
?>

<?php
ob_start(); // Start output buffering to prevent headers from being sent prematurely

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
// Ensure your MySQL server is running and credentials are correct.
// Host: localhost, Username: root, Password: (empty for root, if set, provide here), Database: meditronix_new
$con = mysqli_connect("localhost", "root", "", "meditronix_new");
if (mysqli_connect_errno()) {
    // Log the error for server-side debugging
    error_log("Failed to connect to MySQL: " . mysqli_connect_error());
    // Display a user-friendly message without stopping the entire page rendering
    echo "<div class='container-wrapper' style='text-align: center; padding: 50px; background: #fff; border-radius: 15px; box-shadow: 0 0 20px rgba(0,0,0,0.1); margin-top: 100px;'>";
    echo "<h2 style='color: #dc3545;'>❌ Database Connection Failed</h2>";
    echo "<p style='color: #6c757d; font-size: 1.2rem;'>We are unable to connect to the database at this moment.</p>";
    echo "<p style='color: #6c757d; font-size: 1.2rem;'>Please ensure your database server is running and the connection details in the code are correct.</p>";
    echo "<p style='color: #6c757d; font-size: 1.2rem;'>Once fixed, news entries will appear here automatically.</p>";
    echo "</div>";
    // Exit PHP execution to prevent further errors, but after displaying a message
    ob_end_flush(); // Flush any buffered output before exiting
    exit();
}

// Fetch news data for display in the carousel
// SELECT Query: Retrieve all necessary columns from the 'news' table, ordered by creation date.
$newsResult = mysqli_query($con, "SELECT `id`, `title`, `content`, `status`, `created_at` FROM `news` ORDER BY `created_at` DESC");
$newsData = [];
if ($newsResult) {
    while ($row = mysqli_fetch_assoc($newsResult)) {
        $newsData[] = $row;
    }
} else {
    error_log("Error fetching news data: " . mysqli_error($con));
    $newsData = [];
}
mysqli_close($con); // Close the database connection after all operations

// --- User Provided SQL Queries for Reference ---
/*
// General SELECT Query (as provided by user)
// SELECT * FROM `news` WHERE 1;

// Specific SELECT Query (as provided by user, similar to current fetch)
// SELECT `id`, `title`, `content`, `status`, `created_at` FROM `news` WHERE 1;

// INSERT Query Template (example, not directly used here but for reference)
// INSERT INTO `news`(`id`, `title`, `content`, `status`, `created_at`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')

// UPDATE Query Template (example, not directly used here but for reference)
// UPDATE `news` SET `id`='[value-1]',`title`='[value-2]',`content`='[value-3]',`status`='[value-4]',`created_at`='[value-5]' WHERE 1;
*/
?>

<div class="container-wrapper">
    <style>
        /* Define CSS Variables for consistent styling and easy modification */
        :root {
            --primary-blue: #007bff;
            --secondary-blue: #00c6ff;
            --dark-blue: #0056b3;

            /* Body Background: Light Blue Greyish Rainbow with Shining Star Effect */
            --body-bg-1: #E0F2F7; /* Very light blue */
            --body-bg-2: #D4EBF2; /* Slightly darker light blue */
            --body-bg-3: #C8E4ED; /* Light grey-blue */
            --body-bg-4: #BCE0E8; /* Light blue-green */
            --body-bg-5: #B0DBE3; /* Light teal */
            --body-bg-6: #A4D6DE; /* Light cyan */

            /* Container Background: Proper Rose Red Color with Diamond Crystal Effect */
            --container-bg-gradient: linear-gradient(135deg, #FFDAB9, #FFC0CB, #FFB6C1, #F08080); /* Peach, Pink, Light Coral, Coral */
            --container-border-color: rgba(255, 192, 203, 0.6); /* Light pink border */

            --text-color-dark: #2c3e50;
            --text-color-medium: #555;
            --text-color-light: #888;
            --card-bg: rgba(255, 255, 255, 0.98); /* Slightly transparent white for cards */
            --card-border: rgba(0, 0, 0, 0.05);
            --shadow-light: 0 20px 60px rgba(0,0,0,0.15);
            --shadow-hover: 0 35px 90px rgba(0,0,0,0.35);
            --border-radius-xl: 45px;
            --padding-xl: 4.5rem;
            --transition-speed: 0.8s;
            --transition-ease: cubic-bezier(0.25, 0.8, 0.25, 1);
            --glow-color: #00eaff; /* Cyan glow */
            --shine-color: rgba(255, 255, 255, 0.98); /* White for glitter effect */
            --water-crystal-blue: rgba(0, 255, 255, 0.8); /* Bright cyan for water effect */
            --water-crystal-blue-dark: rgba(0, 180, 255, 0.6); /* Slightly darker cyan for water effect */
        }

        /* Global Box Sizing and Font Family */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
        }

        /* Smooth Scrolling for Anchor Links */
        html {
            scroll-behavior: smooth;
        }

        /* Body Styling: Light Blue Greyish Rainbow with Shining Star Effect */
        body {
            background: linear-gradient(135deg,
                var(--body-bg-1) 0%,
                var(--body-bg-2) 16%,
                var(--body-bg-3) 33%,
                var(--body-bg-4) 50%,
                var(--body-bg-5) 66%,
                var(--body-bg-6) 83%,
                var(--body-bg-1) 100%
            );
            background-size: 1500% 1500%; /* Larger size for more subtle and flowing gradient */
            animation: gradientBackground 150s ease infinite alternate, pulseBackground 200s linear infinite; /* Slower, more ethereal animations */
            overflow-x: hidden; /* Prevent horizontal scrollbar */
            color: var(--text-color-medium);
            line-height: 2;
            position: relative;
            padding: 40px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            filter: saturate(1.03) contrast(1.03); /* Subtle filter for haziness */
            cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="%23007bff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pointer"><path d="M14 2L20 8V22H4V8L10 2H14Z"></path><line x1="12" y1="2" x2="12" y2="8"></line><line x1="4" y1="8" x2="20" y2="8"></line></svg>') 12 12, auto;
        }

        /* Keyframe Animations for Body Background */
        @keyframes gradientBackground {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes pulseBackground {
            0% { filter: brightness(1); }
            50% { filter: brightness(1.01); } /* Very subtle pulse */
            100% { filter: brightness(1); }
        }

        /* Shining Star Effect Overlay for Body */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            background: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.08) 1px, transparent 1px),
                        radial-gradient(circle at 80% 70%, rgba(255,255,255,0.08) 1px, transparent 1px),
                        radial-gradient(circle at 50% 50%, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 120px 120px, 150px 150px, 100px 100px;
            animation: starTwinkle 10s linear infinite alternate, subtleZoom 400s linear infinite;
            z-index: -1;
            opacity: 0.7;
        }

        /* Keyframe Animations for Star Effect */
        @keyframes starTwinkle {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 0.9; }
        }
        @keyframes subtleZoom {
            0% { background-size: 120px 120px, 150px 150px, 100px 100px; }
            50% { background-size: 123px 123px, 154px 154px, 103px 103px; }
            100% { background-size: 120px 120px, 150px 150px, 100px 100px; }
        }

        /* Main Container Wrapper Styling */
        .container-wrapper {
            width: 100%;
            max-width: 1900px; /* Extended max-width for full size */
            margin: 80px auto;
            background: var(--container-bg-gradient); /* Bloosim Rose with Diamond Crystal for container */
            border-radius: var(--border-radius-xl);
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.4);
            padding: 60px;
            overflow: hidden;
            position: relative;
            z-index: 1;
            transform: translateZ(0);
            border: 3px solid var(--container-border-color);
            backdrop-filter: blur(12px) brightness(1.05);
            perspective: 1000px;
            transform-style: preserve-3d;
        }

        /* Glitter Shining Blade Effect on Container Click */
        .container-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: -300%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, var(--shine-color), transparent);
            transform: skewX(-45deg);
            transition: left 2s cubic-bezier(0.25, 0.8, 0.25, 1);
            pointer-events: none;
            z-index: 3;
            opacity: 1;
        }

        /* Slicing Waterfall Effect (Crystal Water Effect) on Container Click */
        .container-wrapper::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: radial-gradient(circle at center,
                var(--water-crystal-blue) 0%,
                var(--water-crystal-blue-dark) 30%,
                transparent 90%
            );
            opacity: 0;
            transform: translate(-50%, -50%) scale(0);
            transition: transform 1.5s ease-out, opacity 1.5s ease-out;
            pointer-events: none;
            mix-blend-mode: screen;
            z-index: 4;
        }

        /* Active states for click effects */
        .container-wrapper.shining::before {
            left: 300%;
        }
        .container-wrapper.shining::after {
            width: 500%;
            height: 500%;
            opacity: 1;
        }

        /* Page Header Styling */
        .page-header {
            text-align: center;
            margin-bottom: 100px;
            padding: 60px;
            background: rgba(255,255,255,0.99);
            border-radius: var(--border-radius-xl);
            box-shadow: 0 25px 70px rgba(0,0,0,0.35);
            backdrop-filter: blur(22px) brightness(1.08);
            border: 3px solid rgba(255,255,255,0.95);
            animation: fadeIn 2s ease-out, headerGlow 5s infinite alternate;
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d;
            perspective: 800px;
        }

        /* Keyframe Animations for Header */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes headerGlow {
            0%, 100% { box-shadow: 0 25px 70px rgba(0,0,0,0.35), 0 0 25px var(--glow-color); }
            50% { box-shadow: 0 25px 70px rgba(0,0,0,0.45), 0 0 40px var(--glow-color); }
        }

        /* Heading Text Styling with Flying Effect */
        .page-header h1 {
            font-size: 6rem;
            background: linear-gradient(to right, #6dd5ed, #2193b0, #ff7e5f, #feb47b, #8360c3, #2ebf91); /* A more vibrant rainbow gradient */
            background-size: 400% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 8s ease-in-out infinite, textGlow 4s infinite alternate, flyIn 3s ease-out; /* Added flyIn */
            margin-bottom: 35px;
            font-weight: 900;
            letter-spacing: 5px;
            text-shadow: 6px 6px 25px rgba(0,0,0,0.3);
            position: relative;
            display: inline-block;
            transform: translateZ(20px);
        }

        /* Keyframe Animations for Heading Text */
        @keyframes flyIn {
            0% { transform: translateY(-100px) scale(0.5) rotateX(90deg); opacity: 0; }
            100% { transform: translateY(0) scale(1) rotateX(0deg); opacity: 1; }
        }
        @keyframes shimmer {
            0%, 100% { background-position: -600% 0; }
            50% { background-position: 600% 0; }
        }
        @keyframes textGlow {
            0%, 100% { text-shadow: 6px 6px 25px rgba(0,0,0,0.3), 0 0 15px rgba(0,210,255,0.7); }
            50% { text-shadow: 6px 6px 30px rgba(0,0,0,0.4), 0 0 25px rgba(0,210,255,1); }
        }

        /* Paragraph Styling for Header Message */
        .page-header p {
            font-size: 2rem;
            color: var(--text-color-dark);
            max-width: 1200px;
            margin: 0 auto;
            line-height: 2.1;
            text-shadow: 1px 1px 6px rgba(0,0,0,0.15);
            transform: translateZ(10px);
        }

        /* Slider Container Styling */
        .slider-container {
            overflow-x: hidden; /* Changed to hidden for controlled JS scrolling */
            padding-bottom: 70px;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            position: relative;
            padding: 60px 0;
            box-shadow: inset 0 0 50px rgba(0,0,0,0.2);
            border-radius: var(--border-radius-xl);
            background: rgba(255,255,255,0.95);
            border: 3px solid rgba(255,255,255,0.9);
            transform-style: preserve-3d;
            perspective: 900px;
        }

        /* Slider Track for Automatic Sliding */
        .slider-track {
            display: flex;
            gap: 80px;
            padding: 40px;
            min-width: fit-content;
            transform-style: preserve-3d;
            animation: autoScroll 60s linear infinite; /* Automatic sliding */
        }

        /* Keyframe Animation for Automatic Carousel Scroll (first to last, then last to first) */
        @keyframes autoScroll {
            0% { transform: translateX(0); }
            50% { transform: translateX(calc(-100% + 100vw)); } /* Scrolls to the end */
            100% { transform: translateX(0); } /* Scrolls back to the start */
        }

        /* Individual Slider Card Styling */
        .slider-card {
            flex: 0 0 700px; /* Increased flex-basis for wider cards */
            background: var(--card-bg);
            border-radius: var(--border-radius-xl);
            padding: var(--padding-xl);
            position: relative;
            box-shadow: var(--shadow-light);
            transition: transform var(--transition-speed) var(--transition-ease),
                        box-shadow var(--transition-speed) var(--transition-ease),
                        background var(--transition-speed) var(--transition-ease),
                        border-color var(--transition-speed) var(--transition-ease);
            overflow: visible;
            border: 3px solid var(--card-border);
            cursor: pointer;
            scroll-snap-align: start;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 5;
            background-image: url('https://cdn.pixabay.com/photo/2016/09/06/04/19/hospital-1648316_1280.png'); /* Placeholder image for card background */
            background-size: cover;
            background-position: center;
            color: #333;
            text-shadow: 1px 1px 3px rgba(255,255,255,0.9);
            transform-style: preserve-3d;
            transform: translateZ(0);
        }

        /* Hover Effects for Cards */
        .slider-card:hover {
            transform: translateY(-30px) scale(1.08) rotateX(5deg);
            box-shadow: var(--shadow-hover);
            background-color: rgba(255,255,255,1);
            background-blend-mode: overlay;
            border-color: rgba(0,198,255,0.5);
        }

        /* Glitter Effect on Card Click */
        .slider-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -300%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, var(--shine-color), transparent);
            transform: skewX(-35deg);
            transition: left 1.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            pointer-events: none;
            z-index: 10;
            opacity: 0.95;
        }

        /* Slicing Waterfall Effect (Crystal Water) on Card Click */
        .slider-card::after {
            content: '';
            position: absolute;
            top: var(--mouse-y, 50%);
            left: var(--mouse-x, 50%);
            width: 0;
            height: 0;
            border-radius: 50%;
            background: radial-gradient(circle at center, rgba(0, 220, 255, 0.6), transparent 85%);
            opacity: 0;
            transform: translate(-50%, -50%) scale(0);
            transition: transform 1s ease-out, opacity 1s ease-out;
            pointer-events: none;
            z-index: 9;
            mix-blend-mode: screen;
        }

        /* Active states for card click effects */
        .slider-card.clicked::before {
            left: 300%;
        }
        .slider-card.clicked::after {
            width: 450%;
            height: 450%;
            opacity: 1;
        }

        /* Icon Container Styling */
        .icon-container {
            width: 140px;
            height: 140px;
            background: linear-gradient(135deg, #FFDAB9, #FFC0CB); /* Rose colors for icon container */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 5rem;
            margin: 0 auto 45px;
            box-shadow: 0 18px 40px rgba(255, 192, 203, 0.8); /* Pink shadow */
            transition: transform 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d;
            transform: translateZ(30px);
        }

        /* Icon Pulse Animation */
        .icon-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(255,255,255,0.6), transparent 70%);
            animation: iconPulse 4.5s infinite alternate;
        }
        @keyframes iconPulse {
            0% { transform: scale(0.8); opacity: 0.8; }
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(0.8); opacity: 0.8; }
        }

        /* Icon Hover Effect */
        .slider-card:hover .icon-container {
            transform: rotate(35deg) scale(1.35) translateZ(40px);
        }

        /* Card Title (News Title) Styling */
        .slider-card h2 {
            font-size: 2.5rem;
            color: var(--text-color-dark);
            margin-bottom: 20px;
            text-align: center;
            font-weight: 900;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.15);
            line-height: 1.5;
            transform: translateZ(15px);
        }

        /* Paragraph Styling for News Details */
        .slider-card p {
            color: #333; /* Solid color for text */
            font-size: 1.3rem;
            margin-bottom: 15px;
            line-height: 2;
            text-align: justify;
            flex-grow: 1;
            overflow: visible;
            text-overflow: unset;
            display: block;
            -webkit-line-clamp: unset;
            -webkit-box-orient: unset;
            transform: translateZ(5px);
            font-weight: bold; /* Make text bold */
        }

        /* Strong/Highlighted Text Styling for IDs and Titles */
        .slider-card p strong {
            color: var(--dark-blue);
            font-weight: 700;
            text-shadow: 0 0 5px rgba(0,123,255,0.2);
        }

        /* Card Footer Styling for Buttons and Social Links */
        .slider-card footer {
            font-size: 1.2rem;
            color: var(--text-color-dark);
            display: flex;
            flex-direction: column; /* Stack buttons and social links */
            align-items: center;
            margin-top: 35px;
            border-top: 3px dashed rgba(0,0,0,0.25);
            padding-top: 30px;
            gap: 25px; /* Gap between button row and social links */
            transform: translateZ(10px);
        }

        /* View Button Specific Styling */
        .btn-view {
            background: linear-gradient(45deg, #17a2b8, #138496);
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.4s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .btn-view::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.3);
            transform: skewX(-30deg);
            transition: all 0.5s ease;
            z-index: -1;
        }
        .btn-view:hover {
            background: linear-gradient(45deg, #138496, #17a2b8);
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(23,162,184,0.4);
        }
        .btn-view:hover::before {
            left: 100%;
        }

        /* Social Links Styling */
        .card-social-links {
            display: flex;
            justify-content: center; /* Center social links */
            gap: 25px; /* Adjusted gap for better spacing */
            margin-top: 0; /* Removed extra margin */
            width: 100%; /* Ensure social links take full width for centering */
        }
        .card-social-links a {
            color: var(--primary-blue);
            font-size: 2rem;
            transition: color 0.6s ease, transform 0.6s ease, text-shadow 0.6s ease;
            text-decoration: none;
            transform: translateZ(5px);
        }
        .card-social-links a:hover {
            transform: translateY(-12px) scale(1.7) translateZ(10px);
            color: var(--dark-blue);
            text-shadow: 0 10px 20px rgba(0,123,255,0.6);
        }

        /* Add New News Button Styling (Outside Carousel) */
        .btn-add-new {
            background: linear-gradient(45deg, #6f42c1, #563d7c); /* Purple gradient */
            color: #fff;
            border: none;
            padding: 15px 35px;
            font-size: 1.3rem;
            margin-top: 50px; /* Adjusted margin-top to reduce space */
            border-radius: 15px;
            text-decoration: none; /* Ensure it looks like a button */
            display: inline-block; /* For proper padding and margin */
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: all 0.4s ease;
        }
        .btn-add-new:hover {
            background: linear-gradient(45deg, #563d7c, #6f42c1);
            transform: translateY(-7px);
            box-shadow: 0 10px 25px rgba(111,66,193,0.5);
        }

        /* Custom Modal for Action Confirmation (if needed for future expansion) */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        .modal-content {
            background: linear-gradient(135deg, #f0f9ff, #c9e9ff);
            padding: 50px;
            border-radius: 25px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
            text-align: center;
            transform: scale(0.8);
            transition: transform 0.3s ease;
            max-width: 500px;
            width: 90%;
            border: 3px solid #007bff;
        }
        .modal-overlay.show .modal-content {
            transform: scale(1);
        }
        .modal-content h3 {
            font-size: 2.2rem;
            color: var(--text-color-dark);
            margin-bottom: 30px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
        }
        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
        .modal-buttons .btn {
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .modal-buttons .btn-yes {
            background: #28a745;
            color: #fff;
            border: none;
        }
        .modal-buttons .btn-yes:hover {
            background: #218838;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(40,167,69,0.3);
        }
        .modal-buttons .btn-no {
            background: #6c757d;
            color: #fff;
            border: none;
        }
        .modal-buttons .btn-no:hover {
            background: #5a6268;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(108,117,125,0.3);
        }

        /* Popup Message Styling */
        #popup-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: linear-gradient(45deg, #f0f9ff, #c9e9ff);
            color: var(--text-color-dark);
            padding: 40px 60px;
            border-radius: 25px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s ease, visibility 0.5s ease;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.1);
        }
        #popup-message.show {
            opacity: 1;
            visibility: visible;
        }

        /* Firework Canvas Styling */
        #fireworkCanvas {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999; /* Below modal, above other content */
            pointer-events: none; /* Allows clicks to pass through */
        }

        /* Footer Social Links Styling */
        .footer-social-links {
            display: flex;
            justify-content: center;
            gap: 60px; /* Increased gap for better spacing */
            margin-top: 150px; /* Increased margin to separate from content */
            padding-top: 80px; /* Increased padding */
            border-top: 2px solid rgba(0,0,0,0.1);
            width: 100%;
            max-width: 1200px;
        }
        .footer-social-links a {
            color: var(--primary-blue);
            font-size: 3rem; /* Larger icons */
            transition: color 0.6s ease, transform 0.6s ease, text-shadow 0.6s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 80px; /* Make clickable area larger */
            height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.8);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .footer-social-links a:hover {
            transform: translateY(-15px) scale(1.8) rotate(10deg); /* More pronounced hover */
            color: var(--dark-blue);
            text-shadow: 0 12px 25px rgba(0,123,255,0.7);
            background: rgba(255,255,255,1);
            box-shadow: 0 8px 20px rgba(0,123,255,0.3);
        }

        /* Main Footer Styling */
        footer {
            text-align: center;
            margin-top: 50px;
            padding: 30px;
            font-size: 1.1rem;
            color: var(--text-color-dark);
            background: rgba(255,255,255,0.8);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 1000px;
        }

        /* Responsive Adjustments */
        @media (max-width: 1800px) {
            .container-wrapper {
                max-width: 1700px;
                padding: 60px;
            }
            .page-header h1 {
                font-size: 5rem;
            }
            .page-header p {
                font-size: 1.7rem;
            }
            .slider-card {
                flex: 0 0 600px; /* Adjusted for larger cards */
                padding: 4rem;
            }
        }
        @media (max-width: 1500px) {
            .container-wrapper {
                max-width: 1400px;
                padding: 55px;
            }
            .page-header h1 {
                font-size: 4.5rem;
            }
            .page-header p {
                font-size: 1.5rem;
            }
            .slider-card {
                flex: 0 0 550px; /* Adjusted for larger cards */
                padding: 3.8rem;
            }
            .icon-container {
                width: 110px;
                height: 110px;
                font-size: 4rem;
                margin-bottom: 35px;
            }
            .slider-card h2 {
                font-size: 2.1rem;
            }
            .slider-card p {
                font-size: 1.15rem;
            }
            .footer-social-links a {
                font-size: 2.8rem;
                width: 75px;
                height: 75px;
            }
            #popup-message {
                font-size: 2.8rem;
                padding: 55px 85px;
            }
        }
        @media (max-width: 1200px) {
            .container-wrapper {
                max-width: 96%;
                padding: 50px;
                margin: 60px auto;
            }
            .page-header {
                padding: 50px;
                margin-bottom: 80px;
            }
            .page-header h1 {
                font-size: 3.8rem;
                letter-spacing: 3px;
            }
            .page-header p {
                font-size: 1.4rem;
            }
            .slider-container {
                padding: 50px 0;
            }
            .slider-track {
                gap: 60px;
                padding: 30px;
            }
            .slider-card {
                flex: 0 0 90%;
                max-width: 500px;
                margin: 0 auto;
                padding: 3.5rem;
            }
            .icon-container {
                width: 110px;
                height: 110px;
                font-size: 3.8rem;
                margin-bottom: 35px;
            }
            .slider-card h2 {
                font-size: 2rem;
            }
            .slider-card p {
                font-size: 1.1rem;
            }
            .slider-card footer {
                flex-direction: column;
                align-items: center;
                gap: 20px;
                padding-top: 25px;
            }
            .card-social-links {
                gap: 25px;
            }
            .card-social-links a {
                font-size: 1.8rem;
            }
            .footer-social-links {
                margin-top: 120px;
                padding-top: 70px;
                gap: 50px;
            }
            .footer-social-links a {
                font-size: 2.8rem;
                width: 70px;
                height: 70px;
            }
            #popup-message {
                font-size: 2.5rem;
                padding: 50px 80px;
            }
        }
        @media (max-width: 992px) {
            .container-wrapper {
                max-width: 95%;
                padding: 40px;
                margin: 50px auto;
            }
            .page-header {
                padding: 40px;
                margin-bottom: 70px;
            }
            .page-header h1 {
                font-size: 3.2rem;
                letter-spacing: 2px;
            }
            .page-header p {
                font-size: 1.2rem;
            }
            .slider-container {
                padding: 40px 0;
            }
            .slider-track {
                gap: 50px;
                padding: 20px;
            }
            .slider-card {
                padding: 3rem;
                min-width: 320px;
            }
            .icon-container {
                width: 100px;
                height: 100px;
                font-size: 3.5rem;
                margin-bottom: 30px;
            }
            .slider-card h2 {
                font-size: 1.8rem;
            }
            .slider-card p {
                font-size: 1rem;
            }
            .slider-card footer {
                font-size: 1.1rem;
                padding-top: 20px;
            }
            .card-social-links {
                gap: 20px;
            }
            .card-social-links a {
                font-size: 1.5rem;
            }
            .footer-social-links {
                margin-top: 100px;
                padding-top: 60px;
                gap: 40px;
            }
            .footer-social-links a {
                font-size: 2.5rem;
                width: 60px;
                height: 60px;
            }
            #popup-message {
                font-size: 2.2rem;
                padding: 40px 60px;
            }
        }
        @media (max-width: 768px) {
            body {
                padding: 20px;
            }
            .container-wrapper {
                padding: 30px;
                border-radius: 35px;
                margin: 40px auto;
            }
            .page-header {
                padding: 30px;
                margin-bottom: 60px;
            }
            .page-header h1 {
                font-size: 2.8rem;
                letter-spacing: 1.8px;
            }
            .page-header p {
                font-size: 1rem;
                line-height: 1.8;
            }
            .slider-container {
                padding: 30px 0;
            }
            .slider-track {
                gap: 40px;
                padding: 15px;
            }
            .slider-card {
                padding: 2.5rem;
                min-width: 280px;
            }
            .icon-container {
                width: 90px;
                height: 90px;
                font-size: 3.2rem;
                margin-bottom: 25px;
            }
            .slider-card h2 {
                font-size: 1.6rem;
            }
            .slider-card p {
                font-size: 0.9rem;
            }
            .slider-card footer {
                font-size: 1rem;
                padding-top: 15px;
            }
            .card-social-links {
                gap: 15px;
            }
            .card-social-links a {
                font-size: 1.3rem;
            }
            .footer-social-links {
                margin-top: 80px;
                padding-top: 50px;
                gap: 30px;
            }
            .footer-social-links a {
                font-size: 2.2rem;
                width: 50px;
                height: 50px;
            }
            #popup-message {
                font-size: 2rem;
                padding: 30px 50px;
                border-radius: 30px;
            }
        }
        @media (max-width: 576px) {
            .container-wrapper {
                padding: 20px;
                border-radius: 30px;
            }
            .page-header {
                padding: 20px;
                margin-bottom: 50px;
            }
            .page-header h1 {
                font-size: 2.2rem;
                letter-spacing: 1.5px;
            }
            .page-header p {
                font-size: 0.85rem;
            }
            .slider-container {
                padding: 20px 0;
            }
            .slider-track {
                gap: 30px;
                padding: 10px;
            }
            .slider-card {
                padding: 2rem;
                min-width: 260px;
            }
            .icon-container {
                width: 80px;
                height: 80px;
                font-size: 2.8rem;
                margin-bottom: 20px;
            }
            .slider-card h2 {
                font-size: 1.4rem;
            }
            .slider-card p {
                font-size: 0.8rem;
            }
            .slider-card footer {
                font-size: 0.9rem;
            }
            .card-social-links {
                gap: 10px;
            }
            .card-social-links a {
                font-size: 1.1rem;
            }
            .footer-social-links {
                margin-top: 60px;
                padding-top: 40px;
                gap: 20px;
            }
            .footer-social-links a {
                font-size: 1.8rem;
                width: 45px;
                height: 45px;
            }
            #popup-message {
                font-size: 1.6rem;
                padding: 25px 40px;
                border-radius: 25px;
            }
        }
    </style>

    <div class="page-header">
        <h1><i class="fas fa-newspaper" style="margin-right: 20px; color: #6dd5ed;"></i>Meditronix: News & Announcements<i class="fas fa-bullhorn" style="margin-left: 20px; color: #feb47b;"></i></h1>
       <p>Stay connected with Meditronix as we bring you the latest advancements in medical science, groundbreaking research, expert health tips, and important healthcare updates. Our dedicated news portal serves as your trusted source for in-depth articles, community health initiatives, and innovations shaping the future of medicine. Empower yourself with knowledge, stay ahead with insights, and be part of a community committed to advancing healthcare excellence.</p>
    </div>

    <div class="slider-container" id="sliderContainer">
        <div class="slider-track" id="sliderTrack">
            <?php
            // Function to get a relevant icon based on news status or content type
            function getNewsIcon($status, $title = '') {
                $status = strtolower($status);
                $title = strtolower($title);

                if ($status == 'active') {
                    return 'fas fa-check-circle';
                } elseif ($status == 'inactive') {
                    return 'fas fa-minus-circle';
                }

                if (strpos($title, 'research') !== false || strpos($title, 'study') !== false) {
                    return 'fas fa-flask';
                } elseif (strpos($title, 'health') !== false || strpos($title, 'wellness') !== false) {
                    return 'fas fa-heartbeat';
                } elseif (strpos($title, 'event') !== false || strpos($title, 'conference') !== false) {
                    return 'fas fa-calendar-alt';
                } elseif (strpos($title, 'update') !== false || strpos($title, 'announcement') !== false) {
                    return 'fas fa-bullhorn';
                }
                return 'fas fa-newspaper'; // Default icon
            }

            if (!empty($newsData)):
                foreach ($newsData as $row):
                    $iconClass = getNewsIcon($row['status'], $row['title']);
            ?>
                    <div class="slider-card">
                        <div class="icon-container"><i class="<?php echo $iconClass; ?>"></i></div>
                        <h2>News ID: <strong><?php echo htmlspecialchars($row['id']); ?></strong></h2>
                        <p><strong>Title:</strong> <?php echo htmlspecialchars($row['title']); ?></p>
                        <p><strong>Status:</strong> <span style="font-weight: bold; color: <?php
                            $status_color = 'var(--text-color-dark)';
                            if (strtolower($row['status']) == 'active') { $status_color = '#28a745'; } // Green
                            elseif (strtolower($row['status']) == 'inactive') { $status_color = '#6c757d'; } // Grey
                            echo $status_color;
                        ?>;"><?php echo htmlspecialchars(ucfirst($row['status'])); ?></span></p>
                        <p><strong>Published On:</strong> <?php echo date('d M Y', strtotime($row['created_at'])); ?></p>
                        <footer class="crud-buttons">
                            <!-- Only View Button is shown as per request -->
                            <button class='btn btn-view' data-news-id='<?php echo $row['id']; ?>' data-news-title='<?php echo htmlspecialchars($row['title'], ENT_QUOTES); ?>' data-news-content='<?php echo htmlspecialchars($row['content'], ENT_QUOTES); ?>' data-news-created-at='<?php echo date('d M Y', strtotime($row['created_at'])); ?>' data-news-status='<?php echo htmlspecialchars(ucfirst($row['status'])); ?>' title='View News Details'>👁️ View</button>
                            <div class="card-social-links">
                                <a href='https://www.facebook.com/Google' target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href='https://twitter.com/Google' target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a>
                                <a href='https://www.instagram.com/google/' target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                                <a href='https://www.linkedin.com/company/google/' target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                                <a href='https://www.youtube.com/Google' target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                            </div>
                        </footer>
                    </div>
            <?php
                endforeach;
            else:
            ?>
                <div class="slider-card" style="flex: 0 0 100%; text-align: center; padding: 50px; background-image: url('https://placehold.co/700x400/F8F9FA/6C757D?text=No+News+Available');">
                    <div class="icon-container"><i class="fas fa-exclamation-triangle"></i></div>
                    <h2>No News Available</h2>
                    <p>Currently, there are no news or announcements to display. Please check back later for updates.</p>
                    <div class="text-center">
                        <!-- No "Add News" button as per the request not to show buttons on layout -->
                    </div>
                </div>
            <?php
            endif;
            ?>
        </div>
    </div>

  

    <div id="popup-message">✨ Latest Updates from Meditronix ✨
        <br>
        <center>✨NEWS & ANNOUNCEMENTS✨</center>
    </div>
    <canvas id="fireworkCanvas"></canvas>

    <div class="modal-overlay" id="actionConfirmationModal">
        <div class="modal-content">
            <h3>Confirm Action</h3>
            <p>Are you sure you want to proceed with this action?</p>
            <div class="modal-buttons">
                <button class="btn btn-yes" id="confirmActionYes">Yes</button>
                <button class="btn btn-no" id="confirmActionNo">No</button>
            </div>
        </div>
    </div>



    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        let slider = document.getElementById('sliderTrack');
        let sliderContainer = document.getElementById('sliderContainer');
        const canvas = document.getElementById('fireworkCanvas');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });

        // Function to generate random numbers within a range
        function random(min, max) {
            return Math.random() * (max - min) + min;
        }

        // Function to create particles for firework effect
        function createParticles(x, y) {
            const particles = [];
            const numParticles = 150; // More particles for a richer effect
            for (let i = 0; i < numParticles; i++) {
                particles.push({
                    x,
                    y,
                    radius: random(3.5, 6.5), // Slightly larger particles
                    color: `hsl(${Math.random() * 360}, 100%, 78%)`, // Brighter colors
                    dx: random(-15, 15), // Wider spread
                    dy: random(-15, 15),
                    alpha: 1,
                    gravity: 0.25, // Slightly more gravity
                    friction: 0.92 // Less friction for longer trails
                });
            }
            return particles;
        }

        let fireworks = []; // Array to hold all active firework particle systems

        // Animation loop for fireworks
        function animateFireworks() {
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear canvas each frame
            fireworks.forEach((fw, index) => {
                fw.forEach(p => {
                    p.dx *= p.friction;
                    p.dy *= p.friction;
                    p.dy += p.gravity;
                    p.x += p.dx;
                    p.y += p.dy;
                    p.alpha -= 0.02; // Slower fade
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                    // Extract RGB values from HSL string for rgba compatibility
                    const hslToRgb = (h, s, l) => {
                        l /= 100;
                        const a = s * Math.min(l, 1 - l) / 100;
                        const f = n => {
                            const k = (n + h / 30) % 12;
                            const color = l - a * Math.max(Math.min(k - 3, 9 - k, 1), -1);
                            return Math.round(255 * color);
                        };
                        return [f(0), f(8), f(4)];
                    };
                    const hslMatch = p.color.match(/hsl\((\d+),\s*(\d+)%,\s*(\d+)%\)/);
                    if (hslMatch) {
                        const [r, g, b] = hslToRgb(parseInt(hslMatch[1]), parseInt(hslMatch[2]), parseInt(hslMatch[3]));
                        ctx.fillStyle = `rgba(${r},${g},${b},${p.alpha})`;
                    } else {
                        ctx.fillStyle = `rgba(0,0,0,${p.alpha})`; // Fallback
                    }
                    ctx.fill();
                });
                fireworks[index] = fw.filter(p => p.alpha > 0); // Remove faded particles
            });
            fireworks = fireworks.filter(fw => fw.length > 0); // Remove empty firework arrays
            requestAnimationFrame(animateFireworks); // Loop animation
        }
        animateFireworks(); // Start the firework animation loop

        // Function to trigger a firework burst and show popup message
        function triggerFirework() {
            const x = canvas.width / 2;
            const y = canvas.height / 2;
            fireworks.push(createParticles(x, y)); // Add a new firework burst
            showPopupMessage();
        }

        // Function to show and hide the popup message
        function showPopupMessage() {
            const popup = document.getElementById('popup-message');
            popup.classList.add('show');
            setTimeout(() => {
                popup.classList.remove('show');
            }, 4500); // Message visible for 4.5 seconds
        }

        // Glitter Shining Blade and Slicing Waterfall Effect on Container Click
        const containerWrapper = document.querySelector('.container-wrapper');
        if (containerWrapper) {
            containerWrapper.addEventListener('click', function() {
                console.log('Container clicked, applying shining effect.');
                this.classList.add('shining');
                setTimeout(() => {
                    this.classList.remove('shining');
                    console.log('Shining effect removed.');
                }, 2000); // Effects last for 2 seconds
            });
        }

        // Card click effects (Glitter and Waterfall on individual cards)
        document.querySelectorAll('.slider-card').forEach(card => {
            card.addEventListener('click', function(event) {
                // Only trigger effects if not clicking on action buttons
                if (!event.target.closest('.crud-buttons')) { // Ensure click is not on footer buttons
                    const rect = card.getBoundingClientRect();
                    const mouseX = event.clientX - rect.left;
                    const mouseY = event.clientY - rect.top;
                    card.style.setProperty('--mouse-x', `${mouseX}px`);
                    card.style.setProperty('--mouse-y', `${mouseY}px`);
                    this.classList.add('clicked');
                    setTimeout(() => {
                        this.classList.remove('clicked');
                    }, 1500); // Effects last for 1.5 seconds
                    triggerFirework(); // Trigger firework on card click
                }
            });
        });

        // Automatic carousel scrolling logic
        let scrollSpeed = 0.5; // pixels per frame
        let currentScroll = 0;
        let animationFrameId;

        function autoScrollCarousel() {
            if (slider) {
                currentScroll += scrollSpeed;
                // Check if we've scrolled past the end, and reverse direction if so
                if (currentScroll >= slider.scrollWidth - sliderContainer.clientWidth) {
                    scrollSpeed = -0.5; // Reverse direction
                } else if (currentScroll <= 0) {
                    scrollSpeed = 0.5; // Reverse back to original direction
                }
                sliderContainer.scrollLeft = currentScroll;
                animationFrameId = requestAnimationFrame(autoScrollCarousel);
            }
        }

        // Start auto-scrolling when the page loads
        window.onload = function() {
            autoScrollCarousel();
        };

        // Pause auto-scrolling on hover
        sliderContainer.addEventListener('mouseenter', () => {
            cancelAnimationFrame(animationFrameId);
        });

        // Resume auto-scrolling on mouse leave
        sliderContainer.addEventListener('mouseleave', () => {
            autoScrollCarousel();
        });

        // Logic for opening news details in a new tab/window
        document.querySelectorAll('.btn-view').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.newsId;
                const title = this.dataset.newsTitle;
                const content = this.dataset.newsContent;
                const createdAt = this.dataset.newsCreatedAt;
                const status = this.dataset.newsStatus;

                const tab = window.open('', '_blank');
                tab.document.write(`
                    <html>
                    <head>
                        <title>${title} | News Details</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                        <style>
                            body {
                                background: linear-gradient(to right, #f8f9fa, #e2e6ea);
                                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                                padding: 40px;
                            }
                            .container {
                                max-width: 1000px;
                                margin: auto;
                                background-color: #ffffff;
                                border-radius: 15px;
                                padding: 30px;
                                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
                            }
                            .title {
                                font-size: 2rem;
                                font-weight: bold;
                                color: #0d6efd;
                                border-bottom: 2px solid #0d6efd;
                                padding-bottom: 10px;
                            }
                            .meta {
                                font-size: 0.95rem;
                                color: #6c757d;
                                margin-top: 10px;
                            }
                            .description {
                                margin-top: 30px;
                                font-size: 1.1rem;
                                line-height: 1.8;
                                color: #212529;
                                background: #f1f3f5;
                                padding: 20px;
                                border-radius: 10px;
                                border-left: 6px solid #0d6efd;
                                white-space: pre-wrap;
                            }
                            .back-btn {
                                background-color: #0d6efd;
                                color: #fff;
                                font-weight: bold;
                                padding: 10px 20px;
                                border: none;
                                border-radius: 30px;
                                transition: 0.3s ease;
                                margin-top: 30px;
                                display: inline-block;
                                text-decoration: none;
                            }
                            .back-btn:hover {
                                background-color: #0b5ed7;
                                box-shadow: 0 0 10px rgba(13, 110, 253, 0.3);
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <div class="title">📰 ${title}</div>
                            <div class="meta">🆔 ID: ${id} &nbsp; | &nbsp; 📅 ${createdAt} &nbsp; | &nbsp; 📌 Status: ${status}</div>
                            <div class="description">${content}</div>
                            <a class="back-btn" href="Daily_news.php" target="_self">🔙 Back to News Page</a>
                        </div>
                    </body>
                    </html>
                `);
                tab.document.close();
            });
        });

    </script>
</div>
<?php ob_end_flush(); ?>



<?php include("patientFooter.php"); ?>
