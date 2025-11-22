<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Kolkata');
include("patientHeader.php");
$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("<div class='container mt-5'><div class='alert alert-danger'>❌ Failed to connect to database.</div></div>");
}
$prescriptions = mysqli_query($db, "SELECT `id`, `appointment_id`, `doctor_name`, `doctor_id`, `patient's_name`, `patient_id`, `notes`, `status`, `created_at` FROM `prescriptions` ORDER BY created_at DESC");
if (!$prescriptions) {
    $error_message = "Error fetching prescriptions data: " . mysqli_error($db);
    $prescriptions = false;
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@700;800;900&display=swap" rel="stylesheet">
<style>
    /* Root variables for consistent theming */
    :root {
        --primary-color: #0077b6; /* A vibrant blue for primary elements */
        --secondary-color: #023e8a; /* A deeper blue for contrast */
        --accent-color: #ff8c00; /* An energetic orange for highlights */
        --highlight-color-light: #ffc107; /* Lighter yellow for subtle highlights */

        /* Card background gradients for multi-color effect */
        --card-bg-light-pink: #fce4ec;
        --card-bg-light-blue: #e0f2f7;
        --card-bg-light-orange: #ffe0cc;
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

    /* Base HTML and Body styles */
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

    /* Keyframe animation for rainbow background */
    @keyframes rainbowBackground {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Pseudo-element for subtle shine effect on body */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--ruby-diamond-effect); /* Ruby diamond effect */
        pointer-events: none;
        z-index: -1;
        animation: subtleShine 15s infinite alternate ease-in-out; /* Subtle shine animation */
    }

    /* Keyframe animation for subtle shine */
    @keyframes subtleShine {
        0% { opacity: 0.8; transform: scale(1); }
        100% { opacity: 1; transform: scale(1.02); }
    }

    /* Pseudo-element for waterfall texture effect on body */
    body::after {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('https://cdn.pixabay.com/photo/2016/12/01/09/09/ambulance-1874764_1280.jpg'); /* Cube texture */
        background-repeat: repeat;
        background-size: 70px 70px;
        animation: waterfall 120s linear infinite; /* Waterfall animation */
        z-index: -2;
        opacity: 0.1;
        pointer-events: none;
    }

    /* Keyframe animation for waterfall effect */
    @keyframes waterfall {
        from { background-position: 0 0; }
        to { background-position: 140px 140px; }
    }

    /* Main container styling */
    .container-xxl {
        padding: 7rem 4rem;
        flex-grow: 1;
        background-color: rgba(255, 255, 255, 0.99); /* Slightly transparent white background */
        border-radius: var(--border-radius-lg); /* Rounded corners */
        box-shadow: 0 20px 60px var(--shadow-strong), 0 0 0 5px rgba(255,255,255,0.5); /* Strong shadow with white border */
        margin: 100px auto; /* Centered with margin */
        max-width: 1600px; /* Max width */
        min-width: 320px; /* Min width for responsiveness */
        position: relative;
        overflow: hidden;
        border: 3px solid rgba(255, 255, 255, 0.9); /* White border */
        transform-style: preserve-3d; /* For 3D effects */
        perspective: 1000px;
        animation: containerEntrance 1.8s ease-out forwards; /* Entrance animation */
        background-image: url('https://cdn.pixabay.com/photo/2017/03/13/21/41/scientist-2141259_1280.jpg'); /* Placeholder background image */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed; /* Fixed background */
        transition: all 0.8s ease-in-out; /* Smooth transitions */
    }

    /* Pseudo-element for subtle gradient overlay on container */
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

    /* Keyframe animation for container entrance */
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

    /* Section header styling */
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

    /* Main heading styling */
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
        -webkit-background-clip: text;
        background-clip: text;
        background-size: 200% auto;
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
        transition: transform 0.5s ease-out;
        transform: skewX(-20deg);
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

    /* Prescription card styling */
    .prescription-card {
        background: var(--card-multi-gradient); /* Multi-gradient background */
        border: 3px solid var(--border-color-medium);
        box-shadow: 0 15px 50px var(--shadow-light), var(--shadow-inset);
        border-radius: var(--border-radius-lg);
        padding: 45px;
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

    /* Pseudo-element for glitter shining blade effect on hover */
    .prescription-card::before {
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

    /* Pseudo-element for shining glaze effect on hover */
    .prescription-card::after {
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
    .prescription-card:hover::before,
    .prescription-card.active::before {
        opacity: 1;
        animation-play-state: running;
    }
    .prescription-card:hover::after,
    .prescription-card.active::after {
        opacity: 1;
        transform: skewX(-25deg) translateX(300%);
        transition: transform 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .prescription-card:not(:hover)::after {
        transform: skewX(-25deg) translateX(-200%);
        transition: transform 0.01s linear 1.5s; /* Reset quickly when not hovered */
        opacity: 0;
    }

    /* Prescription card hover transformation */
    .prescription-card:hover {
        transform: translateY(-20px) scale(1.06) rotateX(3deg) rotateY(3deg);
        box-shadow: 0 30px 70px var(--shadow-medium), inset 0 0 40px rgba(255,255,255,0.4);
        border-color: var(--accent-color);
    }

    /* Keyframe animation for glitter shine */
    @keyframes glitterShine {
        0% { background-position: 0% 50%; }
        100% { background-position: 100% 50%; }
    }

    /* Prescription icon styling */
    .prescription-icon {
        font-size: 5.5rem; /* Increased icon size */
        color: var(--primary-color);
        margin-bottom: 35px;
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

    /* Prescription icon hover effects */
    .prescription-card:hover .prescription-icon {
        transform: rotateY(360deg) scale(1.25) rotateZ(5deg);
        color: var(--accent-color);
        filter: drop-shadow(0 0 20px var(--accent-color));
    }

    /* Generic prescription detail item styling */
    .prescription-detail-item {
        font-size: 1.55rem; /* Increased text size */
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 15px; /* Increased margin for separation */
        line-height: 1.6; /* Improved line height */
        text-align: left; /* Align all content to the left */
        width: 100%;
        display: block; /* Each item on a new line by default */
        padding: 8px 0;
        position: relative;
    }
    .prescription-detail-item strong {
        color: var(--primary-color);
        font-weight: 700;
        display: inline-block; /* Keep strong and span on same line for some items */
        margin-right: 10px; /* Space between label and value */
    }
    .prescription-detail-item span {
        display: inline-block; /* Keep value on same line */
        font-size: 1.35rem; /* Larger value text */
        color: var(--text-light);
        font-weight: 500;
    }

    /* Specific styling for doctor name */
    .prescription-detail-item.doctor-name-unique {
        font-family: 'Rubik', sans-serif;
        font-size: 3.2rem; /* Significantly larger for uniqueness */
        font-weight: 900;
        color: var(--text-heading-soft);
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.15), 0 0 15px rgba(255,255,255,0.6);
        background: linear-gradient(90deg, var(--secondary-color), var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        background-size: 200% auto;
        animation: nameShine 4s infinite alternate;
        padding-bottom: 18px; /* More space for underline */
        margin-top: 0; /* Align to top under icon */
        order: -1; /* Move to top */
        text-align: center; /* Keep doctor name centered */
    }
    .prescription-detail-item.doctor-name-unique strong {
        display: none; /* Hide the "Doctor Name" label */
    }
    .prescription-detail-item.doctor-name-unique span {
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
    .prescription-detail-item.doctor-name-unique::after {
        content: '';
        position: absolute;
        bottom: 8px; /* Adjust position */
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        height: 7px; /* Thicker underline */
        background: linear-gradient(to right, transparent, var(--accent-color), transparent);
        opacity: 0.8;
        border-radius: 3px;
    }

    /* Keyframe animation for name shine */
    @keyframes nameShine {
        0% { background-position: 0% 50%; }
        100% { background-position: 100% 50%; }
    }

    /* Specific styling for Prescription ID */
    .prescription-detail-item.id-unique {
        font-size: 1.7rem; /* Larger for ID */
        font-weight: 900;
        color: var(--text-id-color);
        padding: 10px 25px;
        background-color: rgba(255, 255, 255, 0.85);
        border-radius: var(--border-radius-md);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.18), inset 0 0 15px rgba(255,255,255,0.7);
        width: fit-content;
        margin: 18px auto; /* Centered with more margin */
        animation: idGlow 2.5s infinite alternate;
        letter-spacing: 1px;
        text-transform: uppercase;
        border: 2px solid rgba(192,57,43,0.5);
        will-change: box-shadow;
    }
    .prescription-detail-item.id-unique strong {
        display: none; /* Hide the "Prescription ID" label */
    }
    .prescription-detail-item.id-unique span {
        font-size: inherit; /* Inherit the larger font size */
        color: inherit; /* Inherit the ID color */
        display: inline; /* Keep the ID inline */
    }

    /* Grouping for details for better visual structure */
    .prescription-details-group {
        margin-top: 30px; /* More space from top */
        padding: 25px; /* More padding */
        background: rgba(255,255,255,0.4); /* Slightly less transparent */
        border-radius: var(--border-radius-md);
        box-shadow: inset 0 0 20px rgba(0,0,0,0.1); /* Stronger inset shadow */
        border: 2px solid rgba(255,255,255,0.7); /* Thicker border */
    }
    .prescription-details-group p {
        margin-bottom: 12px; /* Consistent spacing */
        font-size: 1.35rem; /* Larger text */
        color: var(--text-dark);
        display: flex; /* Use flex for icon and text alignment */
        align-items: center;
        gap: 15px; /* More space between icon and text */
        padding: 10px 0; /* More padding */
        border-bottom: 1px dashed rgba(0,0,0,0.2); /* Slightly stronger dashed line */
        transition: all 0.3s ease;
    }
    .prescription-details-group p:last-child {
        margin-bottom: 0;
        border-bottom: none;
    }
    .prescription-details-group p:hover {
        background-color: rgba(255,255,255,0.7); /* More prominent hover background */
        transform: translateX(10px); /* More pronounced slide effect */
        border-radius: var(--border-radius-sm);
    }
    .prescription-details-group p strong {
        color: var(--primary-color);
        font-weight: 700;
        min-width: 150px; /* Wider min-width for labels */
        text-align: left;
        text-shadow: 0 0 5px rgba(0,0,0,0.1); /* Subtle text shadow */
    }
    .prescription-details-group p i {
        color: var(--accent-color);
        font-size: 1.5em; /* Larger icons */
        filter: drop-shadow(0 0 10px rgba(255,140,0,0.5)); /* Stronger glow for icons */
    }

    /* Status button styling */
    .prescription-status {
        font-weight: 800;
        padding: 12px 25px; /* Larger padding */
        border-radius: 40px; /* More rounded */
        display: inline-block;
        margin-top: 25px; /* More margin */
        font-size: 1.2rem; /* Larger font size */
        text-transform: uppercase;
        letter-spacing: 1.5px; /* Increased letter spacing */
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.3); /* Stronger shadow */
        transition: all 0.3s ease;
        border: 4px solid transparent; /* Thicker border */
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
        0% { box-shadow: 0 0 8px rgba(40,167,69,0.7); }
        100% { box-shadow: 0 0 20px rgba(40,167,69,1); }
    }
    .status-inactive {
        background-color: var(--text-status-inactive);
        color: white;
        border-color: #c82333;
        animation: statusGlowRed 2s infinite alternate;
    }
    @keyframes statusGlowRed {
        0% { box-shadow: 0 0 8px rgba(220,53,69,0.7); }
        100% { box-shadow: 0 0 20px rgba(220,53,69,1); }
    }
    .status-pending {
        background-color: var(--text-status-pending);
        color: var(--text-dark);
        border-color: #e0a800;
        animation: statusGlowYellow 2s infinite alternate;
    }
    @keyframes statusGlowYellow {
        0% { box-shadow: 0 0 8px rgba(255,193,7,0.7); }
        100% { box-shadow: 0 0 20px rgba(255,193,7,1); }
    }

    /* Status hover effect */
    .prescription-status:hover {
        transform: scale(1.1);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
    }

    /* Action button group styling */
    .action-btn-group {
        display: flex;
        justify-content: center;
        gap: 25px; /* More space between buttons */
        margin-top: 60px; /* More margin from top */
    }

    /* Action button base styling */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 22px 55px; /* Larger padding */
        border-radius: 50px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px; /* More letter spacing */
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.45); /* Stronger shadow */
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
        background: rgba(255,255,255,0.3); /* Stronger shine effect */
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
        margin-right: 18px; /* More space for icon */
        transition: transform 0.4s ease;
    }

    /* Button hover transformations */
    .action-btn:hover {
        background-color: #e67e22; /* Specific hover color */
        transform: translateY(-15px) scale(1.06); /* More pronounced lift and scale */
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7); /* Even stronger shadow */
        filter: brightness(1.25); /* Brighter on hover */
    }

    /* Icon within button hover transformation */
    .action-btn:hover .fas {
        transform: translateX(12px) rotate(25deg); /* More pronounced icon movement */
    }

    /* View button specific styling */
    .view-btn {
        background-color: var(--primary-color);
        color: white;
    }
    .view-btn:hover {
        background-color: var(--secondary-color);
    }

    /* Owl Carousel custom padding */
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
        pointer-events: none;
        z-index: 10;
    }
    .owl-nav button.owl-prev,
    .owl-nav button.owl-next {
        background-color: var(--primary-color) !important;
        color: white !important;
        border-radius: var(--border-radius-full) !important;
        width: 80px; /* Slightly larger nav buttons */
        height: 80px; /* Slightly larger nav buttons */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem !important; /* Larger nav icon */
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        box-shadow: 0 15px 35px var(--shadow-medium); /* Stronger shadow */
        pointer-events: all;
        border: 4px solid rgba(255, 255, 255, 0.7) !important; /* Thicker border */
        margin: 0 40px; /* More margin */
        outline: none;
        filter: drop-shadow(0 0 12px rgba(0,119,182,0.6)); /* Stronger glow */
    }

    /* Owl Carousel navigation hover effects */
    .owl-nav button.owl-prev:hover,
    .owl-nav button.owl-next:hover {
        background-color: var(--secondary-color) !important;
        transform: scale(1.35); /* More pronounced scale */
        box-shadow: 0 25px 60px var(--shadow-strong); /* Even stronger shadow */
        border-color: var(--accent-color) !important;
        filter: drop-shadow(0 0 25px var(--accent-color)); /* Even stronger glow */
    }

    /* Owl Carousel dots styling */
    .owl-dots {
        text-align: center;
        margin-top: 90px; /* More margin */
        z-index: 5;
    }
    .owl-dots .owl-dot {
        width: 25px; /* Larger dots */
        height: 25px; /* Larger dots */
        background: #d0d5db;
        border-radius: var(--border-radius-full);
        display: inline-block;
        margin: 0 20px; /* More margin */
        transition: all 0.4s ease;
        border: 5px solid transparent; /* Thicker border */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Stronger shadow */
    }

    /* Owl Carousel active dot styling and animation */
    .owl-dots .owl-dot.active {
        background: var(--primary-color);
        transform: scale(1.7); /* More pronounced scale */
        border-color: var(--accent-color);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.4); /* Stronger shadow */
        animation: dotPulse 1.5s infinite alternate;
    }

    /* Keyframe animation for dot pulse */
    @keyframes dotPulse {
        0% { transform: scale(1.7); box-shadow: 0 8px 18px rgba(0, 0, 0, 0.4); }
        100% { transform: scale(1.8); box-shadow: 0 10px 22px rgba(0, 0, 0, 0.5); }
    }

    /* Popup message styling */
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
        display: none;
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

    /* Firework canvas styling */
    #fireworkCanvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 999;
        pointer-events: none;
        display: none;
        background: rgba(0,0,0,0.1);
    }

    /* Responsive adjustments for various screen sizes */
    @media (max-width: 1400px) {
        .container-xxl {
            padding: 5rem 2.5rem;
            margin: 60px auto;
        }
        .main-heading {
            font-size: 4.5rem;
        }
        .professional-message {
            font-size: 1.3rem;
        }
        .prescription-card {
            padding: 35px;
        }
        .prescription-icon {
            font-size: 4.2rem;
        }
    }
    @media (max-width: 1200px) {
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
        .prescription-card {
            padding: 30px;
        }
        .prescription-icon {
            font-size: 3.8rem;
            margin-bottom: 25px;
        }
        .prescription-detail-item {
            font-size: 1.2rem;
        }
        .prescription-detail-item.doctor-name-unique {
            font-size: 2rem;
        }
        .prescription-detail-item.id-unique span {
            font-size: 1.1rem;
        }
        .prescription-details-group p {
            font-size: 1rem;
        }
        .action-btn {
            padding: 14px 35px;
            font-size: 0.95rem;
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
            display: none;
        }
        .owl-dots {
            margin-top: 50px;
        }
        .prescription-card {
            padding: 28px;
        }
        .prescription-icon {
            font-size: 3.2rem;
            margin-bottom: 20px;
        }
        .prescription-detail-item {
            font-size: 1.1rem;
        }
        .prescription-detail-item.doctor-name-unique {
            font-size: 1.8rem;
        }
        .prescription-detail-item.id-unique span {
            font-size: 1rem;
        }
        .prescription-details-group p {
            font-size: 0.95rem;
            margin-bottom: 8px;
        }
        .action-btn {
            padding: 12px 30px;
            font-size: 0.9rem;
            margin-top: 25px;
        }
        .owl-dots .owl-dot {
            width: 16px;
            height: 16px;
            margin: 0 10px;
        }
    }
    @media (max-width: 768px) {
        .container-xxl {
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
        .prescription-card {
            padding: 25px;
        }
        .prescription-icon {
            font-size: 2.8rem;
            margin-bottom: 18px;
        }
        .prescription-detail-item {
            font-size: 1rem;
        }
        .prescription-detail-item.doctor-name-unique {
            font-size: 1.6rem;
        }
        .prescription-detail-item.id-unique span {
            font-size: 0.9rem;
            padding: 3px 8px;
        }
        .prescription-details-group p {
            font-size: 0.9rem;
            margin-bottom: 7px;
            gap: 6px;
        }
        .prescription-details-group p strong {
            min-width: 80px;
        }
        .action-btn {
            padding: 10px 25px;
            font-size: 0.85rem;
            margin-top: 20px;
        }
        .action-btn .fas {
            margin-right: 8px;
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
            padding: 2.5rem 1rem;
            margin: 25px auto;
        }
        .section-header {
            margin-bottom: 40px;
        }
        .main-heading {
            font-size: 2.2rem;
            letter-spacing: 0.5px;
            -webkit-text-stroke: 1px var(--primary-color);
        }
        .main-heading::after {
            width: 70px;
            height: 4px;
            bottom: -10px;
        }
        .professional-message {
            font-size: 0.85rem;
            padding: 12px 15px;
            margin-bottom: 25px;
            border-left-width: 5px;
        }
        .prescription-card {
            padding: 20px;
            margin: 0;
        }
        .prescription-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        .prescription-detail-item {
            font-size: 0.9rem;
        }
        .prescription-detail-item.doctor-name-unique {
            font-size: 1.4rem;
            margin-bottom: 10px;
        }
        .prescription-detail-item.id-unique span {
            font-size: 0.8rem;
            padding: 2px 5px;
            margin-top: 3px;
            margin-bottom: 10px;
        }
        .prescription-details-group p {
            font-size: 0.8rem;
            margin-bottom: 5px;
            gap: 5px;
        }
        .prescription-details-group p strong {
            min-width: 70px;
        }
        .action-btn {
            padding: 8px 20px;
            font-size: 0.75rem;
            margin-top: 15px;
        }
        .action-btn .fas {
            margin-right: 6px;
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
<div class="container-xxl py-5">
    <div class="section-header wow fadeInUp" data-wow-delay="0.1s">
        <h1 class="main-heading">Prescription Management System 📝</h1>
        <p class="professional-message">
            Easily view and manage all prescriptions issued by your doctors with clarity and transparency.
            Our system provides detailed records for each prescription, ensuring you have all the necessary information at your fingertips.
            Access your health records securely and efficiently.
        </p>
    </div>
    <div class="owl-carousel prescription-carousel">
        <?php
        if ($prescriptions && mysqli_num_rows($prescriptions) > 0) :
            $icon_classes = [
                'fas fa-user-md', 'fas fa-stethoscope', 'fas fa-hospital-user', 'fas fa-notes-medical',
                'fas fa-file-prescription', 'fas fa-pills', 'fas fa-syringe', 'fas fa-capsules',
                'fas fa-flask-vial', 'fas fa-microscope', 'fas fa-x-ray', 'fas fa-heart-pulse',
                'fas fa-brain', 'fas fa-lungs', 'fas fa-bone', 'fas fa-tooth',
                'fas fa-eye', 'fas fa-child', 'fas fa-user-nurse', 'fas fa-allergies',
                'fas fa-clinic-medical', 'fas fa-diagnoses', 'fas fa-dna', 'fas fa-ear-listen',
                'fas fa-head-side-cough', 'fas fa-briefcase-medical', 'fas fa-comment-medical',
                'fas fa-hospital-symbol', 'fas fa-kit-medical', 'fas fa-laptop-medical', 'fas fa-monitor-heart-rate',
                'fas fa-radiation-alt', 'fas fa-virus', 'fas fa-weight-scale', 'fas fa-hand-holding-medical',
                'fas fa-band-aid', 'fas fa-first-aid', 'fas fa-thermometer-half', 'fas fa-joint',
                'fas fa-crutch', 'fas fa-bacteria', 'fas fa-vial', 'fas fa-file-waveform',
                'fas fa-hand-holding-droplet', 'fas fa-mask-face', 'fas fa-pump-medical', 'fas fa-skull-crossbones',
                'fas fa-user-injured'
            ];
            $icon_index = 0;
            while ($row = mysqli_fetch_assoc($prescriptions)) :
                $id = htmlspecialchars($row['id']);
                $appointment_id = htmlspecialchars($row['appointment_id']);
                $doctor_name = htmlspecialchars($row['doctor_name']);
                $doctor_id = htmlspecialchars($row['doctor_id']);
                $patient_name = htmlspecialchars($row["patient's_name"]);
                $patient_id = htmlspecialchars($row['patient_id']);
                $status = htmlspecialchars($row['status']);
                $created_at = htmlspecialchars($row['created_at']);
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
                        $status_class = 'status-inactive';
                }
                $current_icon = $icon_classes[$icon_index % count($icon_classes)];
                $icon_index++;
        ?>
                <div class="prescription-card text-center">
                    <i class="prescription-icon <?= $current_icon ?>"></i>
                    <p class="prescription-detail-item doctor-name-unique">
                        <span><?= $doctor_name ?></span>
                    </p>
                    <p class="prescription-detail-item">
                        <i class="fas fa-id-card-alt"></i> <strong>ID:</strong> <span><?= $doctor_id ?></span>
                    </p>
                    <p class="prescription-detail-item id-unique">
                        <i class="fas fa-prescription"></i> <span><?= $id ?></span>
                    </p>
                    <p class="prescription-detail-item">
                        <i class="fas fa-calendar-check"></i> <strong>Appointment ID:</strong> <span><?= $appointment_id ?></span>
                    </p>
                    <p class="prescription-detail-item">
                        <i class="fas fa-user-injured"></i> <strong>Patient Name:</strong> <span><?= $patient_name ?></span>
                    </p>
                    <p class="prescription-detail-item">
                        <i class="fas fa-id-badge"></i> <strong>Patient ID:</strong> <span><?= $patient_id ?></span>
                    </p>
                    <p class="prescription-detail-item">
                        <i class="fas fa-info-circle"></i> <strong>Status:</strong> <span class="prescription-status <?= $status_class ?>"><?= ucfirst($status) ?></span>
                    </p>
                    <p class="prescription-detail-item">
                        <i class="fas fa-calendar-alt"></i> <strong>Created At:</strong> <span><?= date('d M, Y H:i', strtotime($created_at)) ?></span>
                    </p>
                    <div class="action-btn-group">
                        <a href="prescription_details.php?id=<?= $id ?>" target="_blank" class="action-btn view-btn">
                            <i class="fas fa-eye me-2"></i> View Details
                        </a>
                    </div>
                </div>
            <?php
            endwhile;
        else :
        ?>
            <div class="col-12 text-center py-5">
                <p class="professional-message">No prescriptions found in the system. Please check back later!</p>
                <?php if (isset($error_message)) : ?>
                    <p class="text-danger">Error: <?= $error_message ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<div id="popup-message">
    ✨ Your Prescription Records ✨
    <br>
    <center>✨MEDITRONIX PRESCRIPTIONS✨</center>
</div>
<canvas id="fireworkCanvas"></canvas>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        const prescriptionCarousel = $('.prescription-carousel');
        prescriptionCarousel.owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            smartSpeed: 1200,
            responsive: {
                0: { items: 1, nav: false },
                600: { items: 2, nav: true },
                1000: { items: 3, nav: true }
            },
            navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>']
        });
        function setEqualCardHeight() {
            let maxHeight = 0;
            $('.prescription-carousel .owl-item .prescription-card').css('height', 'auto');
            $('.prescription-carousel .owl-item.active').each(function() {
                let currentHeight = $(this).find('.prescription-card').outerHeight();
                if (currentHeight > maxHeight) {
                    maxHeight = currentHeight;
                }
            });
            $('.prescription-carousel .owl-item .prescription-card').css('height', maxHeight + 'px');
        }
        setEqualCardHeight();
        $(window).on('resize', setEqualCardHeight);
        prescriptionCarousel.on('initialized.owl.carousel resized.owl.carousel changed.owl.carousel', function(event) {
            setTimeout(setEqualCardHeight, 100);
        });
        const popupMessage = $('#popup-message');
        const fireworkCanvas = $('#fireworkCanvas')[0];
        const ctx = fireworkCanvas.getContext('2d');
        let particles = [];
        let fireworks = [];
        function resizeCanvas() {
            fireworkCanvas.width = window.innerWidth;
            fireworkCanvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();
        function Particle(x, y, color, velocity) {
            this.x = x;
            this.y = y;
            this.color = color;
            this.velocity = velocity;
            this.alpha = 1;
            this.friction = 0.99;
            this.gravity = 0.05;
            this.draw = function() {
                ctx.save();
                ctx.beginPath();
                ctx.arc(this.x, this.y, 1.5, 0, Math.PI * 2, false);
                ctx.fillStyle = `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${this.alpha})`;
                ctx.fill();
                ctx.restore();
            };
            this.update = function() {
                this.velocity.x *= this.friction;
                this.velocity.y *= this.friction;
                this.velocity.y += this.gravity;
                this.x += this.velocity.x;
                this.y += this.velocity.y;
                this.alpha -= 0.01;
                if (this.alpha <= 0) {
                    this.alpha = 0;
                }
                this.draw();
            };
        }
        function Firework(x, y, targetX, targetY, color) {
            this.x = x;
            this.y = y;
            this.targetX = targetX;
            this.targetY = targetY;
            this.color = color;
            this.velocity = { x: 0, y: 0 };
            this.alpha = 1;
            this.speed = 2;
            this.draw = function() {
                ctx.save();
                ctx.beginPath();
                ctx.arc(this.x, this.y, 2, 0, Math.PI * 2, false);
                ctx.fillStyle = `rgba(${this.color.r}, ${this.color.g}, ${this.color.b}, ${this.alpha})`;
                ctx.fill();
                ctx.restore();
            };
            this.update = function() {
                let dx = this.targetX - this.x;
                let dy = this.targetY - this.y;
                let dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < this.speed) {
                    this.explode();
                    return false;
                }
                this.x += dx / dist * this.speed;
                this.y += dy / dist * this.speed;
                this.draw();
                return true;
            };
            this.explode = function() {
                for (let i = 0; i < 100; i++) {
                    const angle = Math.random() * Math.PI * 2;
                    const velocity = {
                        x: Math.cos(angle) * (Math.random() * 5 + 2),
                        y: Math.sin(angle) * (Math.random() * 5 + 2)
                    };
                    particles.push(new Particle(this.x, this.y, this.color, velocity));
                }
            };
        }
        function animateFireworks() {
            requestAnimationFrame(animateFireworks);
            ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
            ctx.fillRect(0, 0, fireworkCanvas.width, fireworkCanvas.height);
            for (let i = fireworks.length - 1; i >= 0; i--) {
                if (!fireworks[i].update()) {
                    fireworks.splice(i, 1);
                }
            }
            for (let i = particles.length - 1; i >= 0; i--) {
                if (particles[i].alpha <= 0) {
                    particles.splice(i, 1);
                } else {
                    particles[i].update();
                }
            }
        }
        function getRandomColor() {
            return {
                r: Math.floor(Math.random() * 255),
                g: Math.floor(Math.random() * 255),
                b: Math.floor(Math.random() * 255)
            };
        }
        function launchFirework() {
            const startX = fireworkCanvas.width / 2;
            const startY = fireworkCanvas.height;
            const targetX = Math.random() * fireworkCanvas.width;
            const targetY = Math.random() * fireworkCanvas.height / 2;
            fireworks.push(new Firework(startX, startY, targetX, targetY, getRandomColor()));
        }
        $(document).on('click', '.prescription-card', function() {
            $('.prescription-card').removeClass('active');
            $(this).addClass('active');
            const prescriptionId = $(this).find('.prescription-detail-item.id-unique span').text().trim();
            popupMessage.find('br').first().remove();
            popupMessage.find('center').html(`✨ Prescription ID: ${prescriptionId} Details ✨`);
            popupMessage.css({ display: 'block', opacity: 0 }).animate({ opacity: 1 }, 500);
            fireworkCanvas.style.display = 'block';
            particles = [];
            fireworks = [];
            for (let i = 0; i < 3; i++) {
                setTimeout(launchFirework, i * 500);
            }
            setTimeout(() => {
                popupMessage.animate({ opacity: 0 }, 500, function() {
                    $(this).css('display', 'none');
                });
                fireworkCanvas.style.display = 'none';
                $(this).removeClass('active');
            }, 5000);
        });
        animateFireworks();
    });
</script>
<?php ob_end_flush(); ?>
<?php include("patientFooter.php"); ?>
