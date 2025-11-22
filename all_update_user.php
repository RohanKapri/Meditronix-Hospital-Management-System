<?php
ob_start(); // Start output buffering to prevent header issues
error_reporting(E_ALL); // Enable all error reporting for debugging
ini_set('display_errors', 1); // Display errors directly in the browser
date_default_timezone_set('Asia/Kolkata'); // Set the default timezone to India Standard Time

// Include the header file for consistent page structure.
// This file is assumed to contain necessary HTML head, body start, and navigation elements.
include("patientHeader.php");

// Establish a database connection to 'meditronix_new'.
// IMPORTANT: Replace 'localhost', 'root', '', 'meditronix_new' with your actual database server,
// username, password, and database name for production environments.
$db = mysqli_connect("localhost", "root", "", "meditronix_new");

// Check if the database connection was successful.
if (!$db) {
    // If the connection fails, display a user-friendly error message and terminate the script.
    die("<div class='container mt-5'><div class='alert alert-danger'>❌ Failed to connect to database. Please check your database configuration.</div></div>");
}

// Fetch patient data from the 'patients' table.
// The query selects all relevant columns, including 'patient_names' instead of 'profile_picture',
// and orders the results by the 'created_at' timestamp in descending order,
// showing the most recently added patients first.
$patient_query = "SELECT id, user_id, patient_names, gender, dob, blood_group, emergency_contact, status, created_at FROM patients ORDER BY created_at DESC";
$patient_result = mysqli_query($db, $patient_query);

// Check if there was an error executing the SQL query.
if (!$patient_result) {
    // If an error occurs during query execution, capture the MySQL error message for debugging.
    $error_message = "Error fetching patient data: " . mysqli_error($db);
    $patient_result = false; // Set to false to indicate that the query failed.
}

// Close the database connection after all data has been retrieved.
// It's good practice to close connections as soon as they are no longer needed to free up resources.
mysqli_close($db);
?>

<!-- External CSS Libraries and Google Fonts -->
<!-- Font Awesome for a wide range of vector icons. Version 6.0.0-beta3 is used for modern icons. -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Owl Carousel CSS for creating responsive and touch-enabled carousels. -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<!-- Google Fonts for 'Poppins' (general text) and 'Rubik' (headings) for a modern and clean typography. -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@700;800;900&display=swap" rel="stylesheet">

<!-- Custom CSS for the Patient Profiles Directory Portal -->
<style>
    /* Root variables for consistent theming and easy modification throughout the stylesheet. */
    :root {
        --primary-color: #0077b6; /* A vibrant blue, often used for buttons, links, and highlights. */
        --secondary-color: #023e8a; /* A deeper, darker blue for contrast and stronger elements. */
        --accent-color: #ff8c00; /* An energetic orange, used for accents, hover states, and key elements. */
        --highlight-color-light: #ffc107; /* A lighter yellow for subtle highlights. */

        /* Card background gradients for a multi-color, attractive effect. */
        --card-bg-light-pink: #fce4ec; /* Light pink shade. */
        --card-bg-light-blue: #e0f2f7; /* Light blue shade. */
        --card-bg-light-orange: #ffe0cc; /* Mixed light orange, as requested for containers. */
        --card-multi-gradient: linear-gradient(145deg, var(--card-bg-light-pink) 0%, var(--card-bg-light-blue) 50%, var(--card-bg-light-orange) 100%);

        /* Defined text colors for different purposes. */
        --text-dark: #343a40; /* Dark grey for main body text. */
        --text-light: #6c757d; /* Lighter grey for secondary or less prominent text. */
        --text-heading-soft: rgba(2, 62, 138, 0.85); /* A soft blue for headings, slightly transparent. */
        --text-id-color: #c0392b; /* A reddish-brown specifically for ID numbers, making them stand out. */

        /* Specific colors for different status indicators (e.g., active, inactive, pending). */
        --text-status-active: #28a745; /* Green for active status. */
        --text-status-inactive: #dc3545; /* Red for inactive status. */
        --text-status-pending: #ffc107; /* Yellow for pending status. */

        /* Border and shadow effects for depth and visual separation. */
        --border-color-light: #f0f0f0; /* Very light grey border. */
        --border-color-medium: rgba(255, 255, 255, 0.7); /* Semi-transparent white border. */
        --shadow-light: rgba(0, 0, 0, 0.12); /* Light shadow. */
        --shadow-medium: rgba(0, 0, 0, 0.25); /* Medium shadow. */
        --shadow-strong: rgba(0, 0, 0, 0.4); /* Stronger shadow for prominent elements. */
        --shadow-inset: inset 0 0 20px rgba(0, 0, 0, 0.1); /* Inner shadow for depth. */

        /* Transition speeds for smooth animations and hover effects. */
        --transition-speed-fast: 0.2s;
        --transition-speed-normal: 0.4s;
        --transition-speed-slow: 0.6s;

        /* Standard border radii for consistent rounded corners. */
        --border-radius-sm: 8px; /* Small radius. */
        --border-radius-md: 15px; /* Medium radius. */
        --border-radius-lg: 25px; /* Large radius. */
        --border-radius-full: 50%; /* Perfect circle. */

        /* Full rainbow gradient for the body background, creating a dynamic visual. */
        --rainbow-gradient-full: linear-gradient(45deg, #FF0000, #FF7F00, #FFFF00, #00FF00, #0000FF, #4B0082, #9400D3);

        /* Greyish blue base color for background combined with a ruby diamond effect. */
        --greyish-blue: #a7c5d9;
        --ruby-diamond-effect: radial-gradient(circle at center, rgba(248,224,224,0.5) 0%, rgba(217,184,184,0.3) 50%, rgba(167,197,217,0.1) 100%);
    }

    /* Base HTML and Body styles for a smooth, animated background and optimal rendering. */
    html {
        scroll-behavior: smooth; /* Enables smooth scrolling when navigating to anchor links. */
    }
    body {
        font-family: 'Poppins', sans-serif; /* Sets 'Poppins' as the primary font for the entire body. */
        background: var(--rainbow-gradient-full); /* Applies a full rainbow gradient as the background. */
        background-size: 600% 600%; /* Enlarges the background to enable animation across the gradient. */
        animation: rainbowBackground 40s ease infinite; /* Animates the background position for a flowing rainbow effect. */
        color: var(--text-dark); /* Sets a dark grey as the default text color. */
        line-height: 1.7; /* Improves readability by increasing line spacing. */
        overflow-x: hidden; /* Prevents horizontal scrolling, ensuring a clean layout. */
        min-height: 100vh; /* Ensures the body takes at least the full viewport height. */
        display: flex; /* Enables flexbox for layout control. */
        flex-direction: column; /* Stacks content vertically. */
        position: relative; /* Allows absolute positioning of child elements. */
        padding: 0; /* Removes default padding. */
        margin: 0; /* Removes default margin. */
        perspective: 1200px; /* Adds a 3D perspective for child transformations. */
        -webkit-font-smoothing: antialiased; /* Enhances font rendering for smoother text on WebKit browsers. */
        -moz-osx-font-smoothing: grayscale; /* Enhances font rendering for smoother text on Firefox. */
        text-rendering: optimizeLegibility; /* Optimizes text rendering for legibility over speed. */
    }

    /* Keyframe animation for the rainbow background movement, creating a dynamic visual. */
    @keyframes rainbowBackground {
        0% { background-position: 0% 50%; } /* Starts at 0% horizontal and 50% vertical. */
        50% { background-position: 100% 50%; } /* Moves to 100% horizontal at midpoint. */
        100% { background-position: 0% 50%; } /* Returns to start, creating a loop. */
    }

    /* Pseudo-element on the body for a subtle shine effect, creating a ruby diamond overlay. */
    body::before {
        content: ''; /* Required for pseudo-elements. */
        position: fixed; /* Stays in place when scrolling. */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--ruby-diamond-effect); /* Applies the ruby diamond radial gradient. */
        pointer-events: none; /* Allows mouse events to pass through to elements beneath. */
        z-index: -1; /* Positions it behind other content. */
        animation: subtleShine 15s infinite alternate ease-in-out; /* Animates its opacity and scale for a subtle glow. */
    }

    /* Keyframe animation for the subtle shine effect on the body's pseudo-element. */
    @keyframes subtleShine {
        0% { opacity: 0.8; transform: scale(1); } /* Starts slightly transparent and normal size. */
        100% { opacity: 1; transform: scale(1.02); } /* Becomes fully opaque and slightly larger. */
    }

    /* Pseudo-element on the body for a waterfall texture effect, adding subtle depth. */
    body::after {
        content: ''; /* Required for pseudo-elements. */
        position: fixed; /* Stays in place when scrolling. */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('https://cdn.pixabay.com/photo/2024/08/13/11/57/ai-generated-8965819_1280.png'); /* Applies a cube pattern texture. */
        background-repeat: repeat; /* Repeats the background image across the element. */
        background-size: 70px 70px; /* Sets the size of each repeated pattern. */
        animation: waterfall 120s linear infinite; /* Animates the background position for a slow, continuous waterfall effect. */
        z-index: -2; /* Positions it furthest back. */
        opacity: 0.1; /* Makes the texture very subtle. */
        pointer-events: none; /* Allows mouse events to pass through. */
    }

    /* Keyframe animation for the waterfall effect on the body's pseudo-element. */
    @keyframes waterfall {
        from { background-position: 0 0; } /* Starts at the top-left of the background. */
        to { background-position: 140px 140px; } /* Moves the background position, creating a scrolling effect. */
    }

    /* Main container styling, making it visually appealing, responsive, and interactive. */
    .container-xxl {
        padding: 7rem 4rem; /* Generous padding on all sides. */
        flex-grow: 1; /* Allows the container to grow and fill available space. */
        background-color: rgba(255, 255, 255, 0.99); /* Slightly transparent white background for a frosted look. */
        border-radius: var(--border-radius-lg); /* Applies large rounded corners. */
        box-shadow: 0 20px 60px var(--shadow-strong), 0 0 0 5px rgba(255,255,255,0.5); /* Strong shadow for depth and a subtle white border. */
        margin: 100px auto; /* Centers the container horizontally with top/bottom margin. */
        max-width: 1800px; /* Increased maximum width to prevent content cutting and improve justification. */
        min-width: 320px; /* Minimum width for responsiveness on very small screens. */
        position: relative; /* Allows absolute positioning of child elements. */
        overflow: hidden; /* Hides any content that overflows the container's boundaries. */
        border: 3px solid rgba(255, 255, 255, 0.9); /* A thick, semi-transparent white border. */
        transform-style: preserve-3d; /* Enables 3D transformations for child elements. */
        perspective: 1000px; /* Defines the perspective for 3D transformations. */
        animation: containerEntrance 1.8s ease-out forwards; /* Applies an entrance animation when the page loads. */
        background-image: url('https://cdn.pixabay.com/photo/2025/02/16/11/39/ai-generated-9410660_1280.png'); /* Placeholder background image for the container. */
        background-size: cover; /* Ensures the background image covers the entire container. */
        background-position: center; /* Centers the background image. */
        background-repeat: no-repeat; /* Prevents the background image from repeating. */
        background-attachment: fixed; /* Makes the background image fixed relative to the viewport. */
        transition: all 0.8s ease-in-out; /* Smooth transition for all properties on hover/state changes. */
    }

    /* Pseudo-element for a subtle gradient overlay on the container, enhancing depth and visual appeal. */
    .container-xxl::before {
        content: ''; /* Required for pseudo-elements. */
        position: absolute; /* Positions it relative to the container. */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%); /* A subtle white gradient overlay. */
        pointer-events: none; /* Allows mouse events to pass through. */
        z-index: 3; /* Positions it above the container's background but below content. */
        border-radius: inherit; /* Inherits the border-radius from the parent container. */
    }

    /* Keyframe animation for the container's entrance effect, providing a smooth fade-in and lift. */
    @keyframes containerEntrance {
        0% {
            opacity: 0; /* Starts completely transparent. */
            transform: translateY(80px) scale(0.9); /* Starts slightly below and scaled down. */
            filter: blur(8px); /* Starts with a blur effect. */
        }
        100% {
            opacity: 1; /* Becomes fully opaque. */
            transform: translateY(0) scale(1); /* Moves to its original position and scale. */
            filter: blur(0); /* Removes the blur. */
        }
    }

    /* Styling for the section header, containing the main title and professional message. */
    .section-header {
        text-align: center; /* Centers the text within the header. */
        margin-bottom: 80px; /* Adds space below the header. */
        position: relative; /* Allows z-index and absolute positioning of children. */
        z-index: 2; /* Ensures it's above some background elements. */
        padding: 20px; /* Adds internal padding. */
        background: rgba(255,255,255,0.1); /* Semi-transparent white background. */
        border-radius: var(--border-radius-lg); /* Applies large rounded corners. */
        box-shadow: var(--shadow-medium); /* Applies a medium shadow. */
        backdrop-filter: blur(10px); /* Creates a frosted glass effect for elements behind it. */
    }

    /* Styling for the main heading, featuring flying and gradient effects. */
    .main-heading {
        font-family: 'Rubik', sans-serif; /* Sets 'Rubik' as the font for the heading. */
        font-size: 5.5rem; /* Large font size for prominence. */
        font-weight: 900; /* Extra bold font weight. */
        color: var(--secondary-color); /* Default color before gradient clip. */
        margin-bottom: 25px; /* Space below the heading. */
        text-transform: uppercase; /* Converts text to uppercase. */
        letter-spacing: 4px; /* Increases spacing between letters. */
        position: relative; /* Allows absolute positioning of pseudo-elements. */
        display: inline-block; /* Allows width/height and vertical alignment while being inline. */
        text-shadow: 0 0 25px rgba(0, 119, 182, 0.8), 0 0 45px rgba(0, 119, 182, 0.6), 0 0 60px rgba(0, 119, 182, 0.4); /* Multiple text shadows for a glowing effect. */
        -webkit-text-stroke: 2px var(--primary-color); /* Adds a stroke around the text for definition. */
        color: transparent; /* Makes the text transparent to reveal the background gradient. */
        background-image: linear-gradient(45deg, var(--secondary-color), var(--primary-color), var(--accent-color)); /* Applies a linear gradient background. */
        -webkit-background-clip: text; /* Clips the background to the shape of the text (for WebKit browsers). */
        background-clip: text; /* Clips the background to the shape of the text. */
        background-size: 200% auto; /* Enlarges background for gradient animation. */
        animation: flyIn 2s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards, textGradientShine 6s linear infinite; /* Combines fly-in and gradient shine animations. */
        will-change: transform, opacity, filter; /* Optimizes rendering for these properties. */
    }

    /* Pseudo-element for the main heading's animated underline. */
    .main-heading::after {
        content: ''; /* Required for pseudo-elements. */
        position: absolute; /* Positions it relative to the heading. */
        bottom: -20px; /* Positions it below the text. */
        left: 50%; /* Starts from the horizontal center. */
        transform: translateX(-50%); /* Centers it precisely. */
        width: 180px; /* Fixed width for the underline. */
        height: 10px; /* Height of the underline. */
        background: linear-gradient(to right, var(--primary-color), var(--accent-color), var(--secondary-color)); /* Gradient for the underline. */
        border-radius: 5px; /* Rounded corners for the underline. */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3); /* Shadow for depth. */
        animation: headingUnderlineGrow 2s ease-out forwards; /* Animation for the underline to grow. */
    }

    /* Keyframe animation for the heading's underline to grow into view. */
    @keyframes headingUnderlineGrow {
        0% { width: 0; opacity: 0; } /* Starts hidden and zero width. */
        100% { width: 180px; opacity: 1; } /* Grows to full width and becomes visible. */
    }

    /* Keyframe animation for the heading's fly-in effect, creating a dynamic entrance. */
    @keyframes flyIn {
        0% {
            opacity: 0; /* Starts transparent. */
            transform: translateY(-120px) scale(0.6) rotateX(30deg); /* Starts high, small, and rotated. */
            filter: blur(20px) brightness(0.3); /* Starts blurred and dim. */
        }
        100% {
            opacity: 1; /* Becomes opaque. */
            transform: translateY(0) scale(1) rotateX(0deg); /* Moves to original position, scale, and rotation. */
            filter: blur(0px) brightness(1); /* Removes blur and restores brightness. */
        }
    }

    /* Keyframe animation for the text gradient shine effect, creating a subtle moving highlight. */
    @keyframes textGradientShine {
        0% { background-position: 0% 50%; } /* Starts background at left. */
        50% { background-position: 100% 50%; } /* Moves background to right. */
        100% { background-position: 0% 50%; } /* Returns to start, creating a loop. */
    }

    /* Styling for the professional message below the main heading. */
    .professional-message {
        font-size: 1.45rem; /* Generous font size. */
        color: var(--text-light); /* Light grey text color. */
        max-width: 1100px; /* Maximum width for readability. */
        margin: 0 auto 70px auto; /* Centers horizontally with bottom margin. */
        padding: 30px 45px; /* Internal padding. */
        background-color: rgba(255, 255, 255, 0.97); /* Near-opaque white background. */
        border-left: 12px solid var(--primary-color); /* Thick left border for emphasis. */
        border-radius: var(--border-radius-md); /* Medium rounded corners. */
        box-shadow: 0 10px 30px var(--shadow-light); /* Light shadow. */
        line-height: 1.9; /* Increased line height for readability. */
        font-weight: 500; /* Medium font weight. */
        text-align: justify; /* Justifies text for a clean block. */
        border: 2px solid rgba(0, 119, 182, 0.15); /* Subtle border. */
        transition: all var(--transition-speed-normal) cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Smooth transition for hover effects. */
        position: relative; /* Allows absolute positioning of pseudo-elements. */
        overflow: hidden; /* Hides overflowing content. */
    }

    /* Pseudo-element for a subtle hover shine effect on the professional message. */
    .professional-message::before {
        content: ''; /* Required for pseudo-elements. */
        position: absolute; /* Positions relative to the message. */
        top: 0;
        left: -100%; /* Starts off-screen to the left. */
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); /* A white gradient for the shine. */
        transform: skewX(-20deg); /* Skews the element for a slanted shine. */
        transition: transform 0.5s ease-out; /* Smooth transition for the shine movement. */
        pointer-events: none; /* Allows mouse events to pass through. */
    }

    /* Hover effects for the professional message, including the shine animation. */
    .professional-message:hover::before {
        transform: skewX(-20deg) translateX(200%); /* Moves the shine across the element. */
    }
    .professional-message:hover {
        transform: translateY(-8px) scale(1.01); /* Lifts and slightly scales the message on hover. */
        box-shadow: 0 15px 40px var(--shadow-medium); /* Increases shadow depth. */
        border-left-color: var(--accent-color); /* Changes left border color. */
    }

    /* Styling for individual feedback cards within the carousel. */
    .feedback-card {
        background: var(--card-multi-gradient); /* Applies a multi-gradient background. */
        border: 3px solid var(--border-color-medium); /* Medium thickness border. */
        box-shadow: 0 15px 50px var(--shadow-light), var(--shadow-inset); /* Light outer shadow and inner shadow. */
        border-radius: var(--border-radius-lg); /* Large rounded corners. */
        padding: 50px; /* Generous internal padding. */
        height: 100%; /* Ensures all cards in a row have equal height. */
        display: flex; /* Enables flexbox for content arrangement. */
        flex-direction: column; /* Stacks content vertically. */
        justify-content: space-between; /* Distributes space between items. */
        transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55); /* Smooth, spring-like transition for hover effects. */
        position: relative; /* Allows absolute positioning of pseudo-elements. */
        overflow: hidden; /* Hides overflowing content. */
        cursor: pointer; /* Changes cursor to pointer on hover. */
        z-index: 1; /* Ensures it's above background elements. */
        backdrop-filter: blur(8px) brightness(1.1); /* Frosted glass effect with slight brightness increase. */
        transform-style: preserve-3d; /* Enables 3D transformations for child elements. */
        transform: translateZ(0); /* Forces hardware acceleration for smooth transforms. */
        animation: cardFloat 6s infinite alternate ease-in-out, cardShinePulse 4s infinite alternate ease-in-out; /* Applies floating and shine pulse animations. */
        will-change: transform, box-shadow, border-color; /* Optimizes rendering for these properties. */
    }

    /* Keyframe animation for the card floating effect, adding a subtle vertical movement. */
    @keyframes cardFloat {
        0% { transform: translateY(0px) rotateX(0deg) rotateY(0deg); } /* Starts at original position. */
        50% { transform: translateY(-8px) rotateX(0.8deg) rotateY(-0.8deg); } /* Lifts slightly and rotates subtly. */
        100% { transform: translateY(0px) rotateX(0deg) rotateY(0deg); } /* Returns to original position. */
    }

    /* Keyframe animation for the card shine pulse, making the shadow and inner glow pulsate. */
    @keyframes cardShinePulse {
        0% { box-shadow: 0 15px 50px var(--shadow-light), var(--shadow-inset); } /* Initial shadow and inset. */
        50% { box-shadow: 0 15px 50px rgba(0,0,0,0.2), inset 0 0 30px rgba(255,255,255,0.3); } /* Stronger shadow and inner glow. */
        100% { box-shadow: 0 15px 50px var(--shadow-light), var(--shadow-inset); } /* Returns to initial state. */
    }

    /* Pseudo-element for the glitter shining blade effect on hover/click. */
    .feedback-card::before {
        content: ''; /* Required for pseudo-elements. */
        position: absolute; /* Positions relative to the card. */
        top: -8px;
        left: -8px;
        right: -8px;
        bottom: -8px; /* Extends slightly beyond the card for blur effect. */
        background: linear-gradient(45deg, #FF007F, #00C6FF, #FF007F, #00C6FF, #FF007F, #00C6FF, #FF007F); /* Rainbow gradient for the glitter. */
        background-size: 800% 800%; /* Enlarges background for animation. */
        z-index: -1; /* Positions behind the card content. */
        filter: blur(15px) brightness(1.5); /* Applies blur and brightness for a glowing effect. */
        opacity: 0; /* Starts hidden. */
        transition: opacity 0.6s ease-in-out; /* Smooth fade-in/out. */
        border-radius: var(--border-radius-lg); /* Inherits card's rounded corners. */
        animation: glitterShine 4s linear infinite; /* Animates the glitter movement. */
        animation-play-state: paused; /* Paused until hover/active. */
        will-change: opacity, background-position; /* Optimizes rendering. */
    }

    /* Pseudo-element for the shining glaze effect on hover/click. */
    .feedback-card::after {
        content: ''; /* Required for pseudo-elements. */
        position: absolute; /* Positions relative to the card. */
        top: 0;
        left: -200%; /* Starts far off-screen to the left. */
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.6) 50%, rgba(255,255,255,0) 100%); /* White gradient for the glaze. */
        transform: skewX(-25deg); /* Skews the element for a slanted effect. */
        transition: transform 0.8s ease-out; /* Smooth transition for movement. */
        pointer-events: none; /* Allows mouse events to pass through. */
        opacity: 0; /* Starts hidden. */
        z-index: 2; /* Positions above content for the shine effect. */
        border-radius: var(--border-radius-lg); /* Inherits card's rounded corners. */
        will-change: transform, opacity; /* Optimizes rendering. */
    }

    /* Activates glitter and glaze effects when the feedback card is hovered or active. */
    .feedback-card:hover::before,
    .feedback-card.active::before {
        opacity: 1; /* Makes glitter visible. */
        animation-play-state: running; /* Starts glitter animation. */
    }
    .feedback-card:hover::after,
    .feedback-card.active::after {
        opacity: 1; /* Makes glaze visible. */
        transform: skewX(-25deg) translateX(300%); /* Moves glaze across the card. */
        transition: transform 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Smooth, spring-like transition for glaze. */
    }
    /* Resets glaze position quickly when not hovered, preparing for next hover. */
    .feedback-card:not(:hover)::after {
        transform: skewX(-25deg) translateX(-200%); /* Resets off-screen left. */
        transition: transform 0.01s linear 1.5s; /* Very fast reset after a delay. */
        opacity: 0; /* Hides glaze. */
    }

    /* Hover transformation for the feedback card itself, providing a lift and subtle 3D rotation. */
    .feedback-card:hover {
        transform: translateY(-20px) scale(1.06) rotateX(3deg) rotateY(3deg); /* Lifts, scales, and rotates the card. */
        box-shadow: 0 30px 70px var(--shadow-medium), inset 0 0 40px rgba(255,255,255,0.4); /* Stronger shadow and inner glow. */
        border-color: var(--accent-color); /* Changes border color. */
    }

    /* Keyframe animation for the glitter shine effect, moving the background across the element. */
    @keyframes glitterShine {
        0% { background-position: 0% 50%; } /* Starts background at left. */
        100% { background-position: 100% 50%; } /* Moves background to right. */
    }

    /* Styling for the main icon displayed on each feedback card. */
    .feedback-icon {
        font-size: 6rem; /* Large icon size. */
        color: var(--primary-color); /* Primary blue color. */
        margin-bottom: 40px; /* Space below the icon. */
        transition: transform 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55), color 0.4s ease, filter 0.4s ease; /* Smooth transitions for hover effects. */
        text-shadow: 4px 4px 15px rgba(0, 119, 182, 0.5); /* Shadow for depth. */
        animation: iconPulse 2.5s infinite alternate, iconGlow 3s infinite alternate; /* Applies pulse and glow animations. */
        will-change: transform, color, filter; /* Optimizes rendering. */
    }

    /* Keyframe animation for the icon pulse effect, making it subtly grow and shrink. */
    @keyframes iconPulse {
        0% { transform: scale(1); } /* Normal size. */
        100% { transform: scale(1.05); } /* Slightly larger. */
    }

    /* Keyframe animation for the icon glow effect, making its shadow pulsate. */
    @keyframes iconGlow {
        0% { filter: drop-shadow(0 0 5px var(--primary-color)); } /* Subtle glow. */
        100% { filter: drop-shadow(0 0 15px var(--primary-color)) drop-shadow(0 0 25px rgba(0,119,182,0.5)); } /* Stronger glow. */
    }

    /* Hover effects for the feedback icon, including rotation and color change. */
    .feedback-card:hover .feedback-icon {
        transform: rotateY(360deg) scale(1.25) rotateZ(5deg); /* Rotates, scales, and tilts the icon. */
        color: var(--accent-color); /* Changes color to accent orange. */
        filter: drop-shadow(0 0 20px var(--accent-color)); /* Stronger glow. */
    }

    /* Generic styling for each detail item within the feedback card, ensuring left alignment and proper spacing. */
    .feedback-detail-item {
        font-size: 1.65rem; /* Increased font size for readability. */
        color: var(--text-dark); /* Dark grey text color. */
        font-weight: 600; /* Semi-bold font weight. */
        margin-bottom: 18px; /* Increased margin for separation between items. */
        line-height: 1.7; /* Improved line height for multi-line content. */
        text-align: left; /* Aligns all content to the left. */
        width: 100%; /* Ensures the item takes full width. */
        display: flex; /* Uses flexbox for icon and text alignment. */
        align-items: flex-start; /* Aligns items to the start of the cross axis (top for vertical flex). */
        padding: 10px 0; /* Vertical padding. */
        position: relative; /* Allows positioning of internal elements. */
    }
    .feedback-detail-item strong {
        color: var(--primary-color); /* Primary blue color for labels. */
        font-weight: 700; /* Bold font weight for labels. */
        display: inline-block; /* Allows setting width/margin. */
        margin-right: 12px; /* Space between label and value. */
        min-width: 160px; /* Ensures labels are aligned vertically. */
    }
    .feedback-detail-item span {
        display: inline-block; /* Allows text wrapping. */
        font-size: 1.45rem; /* Slightly smaller than label for value text. */
        color: var(--text-light); /* Lighter grey for values. */
        font-weight: 500; /* Medium font weight. */
        flex-grow: 1; /* Allows the span to take up remaining space. */
        word-wrap: break-word; /* Ensures long words break to fit. */
        white-space: normal; /* Allows text to wrap naturally. */
    }
    .feedback-detail-item i {
        color: var(--accent-color); /* Accent orange color for icons. */
        font-size: 1.6em; /* Larger icons within details. */
        margin-right: 15px; /* Space between icon and text. */
        filter: drop-shadow(0 0 10px rgba(255,140,0,0.5)); /* Stronger glow for icons. */
    }

    /* Specific styling for the Patient Name, making it centered and visually unique. */
    .feedback-detail-item.patient-name-unique {
        font-family: 'Rubik', sans-serif; /* Sets 'Rubik' font for uniqueness. */
        font-size: 3.5rem; /* Significantly larger font size. */
        font-weight: 900; /* Extra bold font weight. */
        color: var(--text-heading-soft); /* Soft blue color. */
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.15), 0 0 15px rgba(255,255,255,0.6); /* Shadows for depth and glow. */
        background: linear-gradient(90deg, var(--secondary-color), var(--primary-color), var(--secondary-color)); /* Gradient background. */
        -webkit-background-clip: text; /* Clips background to text. */
        background-clip: text;
        color: transparent; /* Makes text transparent to show gradient. */
        background-size: 200% auto; /* Enlarges background for animation. */
        animation: nameShine 4s infinite alternate; /* Animates a shine effect. */
        padding-bottom: 20px; /* More space for the underline. */
        margin-top: 0; /* Aligns to the top under the icon. */
        order: -1; /* Moves this item to the beginning of the flex order. */
        text-align: center; /* Keeps the patient name centered. */
        display: block; /* Ensures it takes full width and centers. */
    }
    .feedback-detail-item.patient-name-unique strong {
        display: none; /* Hides the "Patient Name" label as the name itself is prominent. */
    }
    .feedback-detail-item.patient-name-unique span {
        font-size: inherit; /* Inherits the large font size. */
        font-weight: inherit; /* Inherits the bold font weight. */
        color: transparent; /* Inherits transparent color for gradient. */
        background-clip: text; /* Clips background to text. */
        -webkit-background-clip: text;
        background-image: linear-gradient(90deg, var(--secondary-color), var(--primary-color), var(--accent-color)); /* Gradient for the name. */
        background-size: 200% auto; /* Enlarges background for animation. */
        animation: nameShine 4s infinite alternate; /* Animates a shine effect. */
        display: block; /* Ensures it's on its own line. */
    }
    .feedback-detail-item.patient-name-unique::after {
        content: ''; /* Required for pseudo-elements. */
        position: absolute; /* Positions relative to the name. */
        bottom: 10px; /* Adjusts position below the text. */
        left: 50%; /* Starts from horizontal center. */
        transform: translateX(-50%); /* Centers precisely. */
        width: 90%; /* Width of the underline. */
        height: 8px; /* Thicker underline. */
        background: linear-gradient(to right, transparent, var(--accent-color), transparent); /* Gradient for the underline. */
        opacity: 0.8; /* Slight transparency. */
        border-radius: 4px; /* Rounded corners for the underline. */
    }

    /* Keyframe animation for the name shine effect, moving the gradient across the text. */
    @keyframes nameShine {
        0% { background-position: 0% 50%; } /* Starts background at left. */
        100% { background-position: 100% 50%; } /* Moves background to right. */
    }

    /* Specific styling for the Feedback ID, making it highlighted and visually unique. */
    .feedback-detail-item.id-unique {
        font-size: 1.8rem; /* Larger font size for ID. */
        font-weight: 900; /* Extra bold font weight. */
        color: var(--text-id-color); /* Reddish-brown color. */
        padding: 12px 30px; /* Internal padding. */
        background-color: rgba(255, 255, 255, 0.85); /* Semi-transparent white background. */
        border-radius: var(--border-radius-md); /* Medium rounded corners. */
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2), inset 0 0 18px rgba(255,255,255,0.8); /* Outer and inner shadows. */
        width: fit-content; /* Adjusts width to content. */
        margin: 20px auto; /* Centers horizontally with top/bottom margin. */
        animation: idGlow 2.5s infinite alternate; /* Applies a glowing animation. */
        letter-spacing: 1.2px; /* Increased letter spacing. */
        text-transform: uppercase; /* Converts text to uppercase. */
        border: 3px solid rgba(192,57,43,0.6); /* Thick border with transparency. */
        will-change: box-shadow; /* Optimizes rendering. */
        display: block; /* Ensures it's on its own line. */
    }
    .feedback-detail-item.id-unique strong {
        display: none; /* Hides the "Feedback ID" label. */
    }
    .feedback-detail-item.id-unique span {
        font-size: inherit; /* Inherits the larger font size. */
        color: inherit; /* Inherits the ID color. */
        display: inline; /* Keeps the ID inline. */
    }
    .feedback-detail-item.id-unique i {
        margin-right: 10px; /* Adjusts icon spacing for ID. */
    }

    /* Keyframe animation for the ID glow effect, making its shadow pulsate. */
    @keyframes idGlow {
        0% { box-shadow: 0 0 15px rgba(192,57,43,0.7), inset 0 0 12px rgba(255,255,255,0.5); } /* Initial glow. */
        100% { box-shadow: 0 0 35px rgba(192,57,43,1), inset 0 0 25px rgba(255,255,255,0.9); } /* Stronger glow. */
    }

    /* Styling for status badges within the feedback cards. */
    .feedback-status {
        font-weight: 800; /* Extra bold font weight. */
        padding: 14px 28px; /* Generous padding. */
        border-radius: 45px; /* Highly rounded corners (pill shape). */
        display: inline-block; /* Allows width/height and vertical alignment. */
        margin-top: 28px; /* Space above the status. */
        font-size: 1.3rem; /* Larger font size. */
        text-transform: uppercase; /* Converts text to uppercase. */
        letter-spacing: 1.8px; /* Increased letter spacing. */
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.35); /* Shadow for depth. */
        transition: all 0.3s ease; /* Smooth transition for hover effects. */
        border: 5px solid transparent; /* Thick transparent border, filled by color classes. */
        cursor: default; /* Default cursor, indicating it's not clickable. */
    }

    /* Status specific colors and animations for 'active' status. */
    .status-active {
        background-color: var(--text-status-active); /* Green background. */
        color: white; /* White text. */
        border-color: #218838; /* Darker green border. */
        animation: statusGlowGreen 2s infinite alternate; /* Green glow animation. */
    }
    /* Keyframe animation for green status glow. */
    @keyframes statusGlowGreen {
        0% { box-shadow: 0 0 10px rgba(40,167,69,0.8); } /* Subtle glow. */
        100% { box-shadow: 0 0 25px rgba(40,167,69,1); } /* Stronger glow. */
    }
    /* Status specific colors and animations for 'inactive' status. */
    .status-inactive {
        background-color: var(--text-status-inactive); /* Red background. */
        color: white; /* White text. */
        border-color: #c82333; /* Darker red border. */
        animation: statusGlowRed 2s infinite alternate; /* Red glow animation. */
    }
    /* Keyframe animation for red status glow. */
    @keyframes statusGlowRed {
        0% { box-shadow: 0 0 10px rgba(220,53,69,0.8); } /* Subtle glow. */
        100% { box-shadow: 0 0 25px rgba(220,53,69,1); } /* Stronger glow. */
    }
    /* Status specific colors and animations for 'pending' status. */
    .status-pending {
        background-color: var(--text-status-pending); /* Yellow background. */
        color: var(--text-dark); /* Dark text. */
        border-color: #e0a800; /* Darker yellow border. */
        animation: statusGlowYellow 2s infinite alternate; /* Yellow glow animation. */
    }
    /* Keyframe animation for yellow status glow. */
    @keyframes statusGlowYellow {
        0% { box-shadow: 0 0 10px rgba(255,193,7,0.8); } /* Subtle glow. */
        100% { box-shadow: 0 0 25px rgba(255,193,7,1); } /* Stronger glow. */
    }

    /* Hover effect for status badges, making them slightly larger and increasing shadow. */
    .feedback-status:hover {
        transform: scale(1.1); /* Slightly scales up. */
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.6); /* Deeper shadow. */
    }

    /* Styling for the action button group (if multiple buttons were present). */
    .action-btn-group {
        display: flex; /* Enables flexbox for button arrangement. */
        justify-content: center; /* Centers buttons horizontally. */
        gap: 30px; /* Space between buttons. */
        margin-top: 70px; /* Space above the button group. */
    }

    /* Base styling for action buttons, providing a consistent look and feel. */
    .action-btn {
        display: inline-flex; /* Allows icon and text to be inline. */
        align-items: center; /* Vertically aligns icon and text. */
        justify-content: center; /* Horizontally centers content. */
        padding: 25px 60px; /* Generous padding. */
        border-radius: 50px; /* Highly rounded corners. */
        font-weight: 800; /* Extra bold font weight. */
        text-transform: uppercase; /* Converts text to uppercase. */
        letter-spacing: 2.2px; /* Increased letter spacing. */
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); /* Smooth, spring-like transition. */
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.5); /* Strong shadow. */
        text-decoration: none; /* Removes underline from links. */
        border: none; /* Removes default border. */
        cursor: pointer; /* Changes cursor to pointer. */
        outline: none; /* Removes outline on focus. */
        position: relative; /* Allows absolute positioning of pseudo-elements. */
        overflow: hidden; /* Hides overflowing content. */
        z-index: 1; /* Ensures it's above some elements. */
        transform: translateZ(0); /* Forces hardware acceleration. */
    }

    /* Pseudo-element for a hover shine effect on action buttons. */
    .action-btn::before {
        content: ''; /* Required for pseudo-elements. */
        position: absolute; /* Positions relative to the button. */
        top: 0;
        left: -100%; /* Starts off-screen to the left. */
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.4); /* White gradient for the shine. */
        transform: skewX(-20deg); /* Skews the element. */
        transition: transform 0.5s ease-out; /* Smooth transition for movement. */
        z-index: -1; /* Positions behind button content. */
    }

    /* Activates the shine effect on button hover. */
    .action-btn:hover::before {
        transform: skewX(-20deg) translateX(200%); /* Moves the shine across the button. */
    }

    /* Styling for icons within action buttons. */
    .action-btn .fas {
        margin-right: 20px; /* Space between icon and text. */
        transition: transform 0.4s ease; /* Smooth transition for icon movement. */
    }

    /* Hover transformations for action buttons, providing a lift, scale, and deeper shadow. */
    .action-btn:hover {
        background-color: #e67e22; /* Specific hover background color. */
        transform: translateY(-18px) scale(1.08); /* Lifts and scales the button. */
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8); /* Even stronger shadow. */
        filter: brightness(1.3); /* Increases brightness on hover. */
    }

    /* Hover transformation for icons within action buttons. */
    .action-btn:hover .fas {
        transform: translateX(15px) rotate(30deg); /* Moves and rotates the icon. */
    }

    /* Custom padding for Owl Carousel items, creating space around each card. */
    .owl-carousel .owl-item {
        padding: 30px; /* Padding around each carousel item. */
    }

    /* Styling for Owl Carousel navigation buttons (prev/next arrows). */
    .owl-nav {
        position: absolute; /* Positions absolutely within the carousel container. */
        top: 50%; /* Vertically centers the navigation. */
        width: 100%; /* Takes full width of the carousel. */
        display: flex; /* Enables flexbox for button arrangement. */
        justify-content: space-between; /* Places buttons at opposite ends. */
        transform: translateY(-50%); /* Adjusts vertical centering. */
        pointer-events: none; /* Allows mouse events to pass through to cards behind buttons. */
        z-index: 10; /* Ensures navigation is above carousel items. */
    }
    .owl-nav button.owl-prev,
    .owl-nav button.owl-next {
        background-color: var(--primary-color) !important; /* Primary blue background (important to override Owl Carousel default). */
        color: white !important; /* White icon color. */
        border-radius: var(--border-radius-full) !important; /* Perfect circle shape. */
        width: 85px; /* Larger width for buttons. */
        height: 85px; /* Larger height for buttons. */
        display: flex; /* Enables flexbox for centering icon. */
        align-items: center; /* Vertically aligns icon. */
        justify-content: center; /* Horizontally aligns icon. */
        font-size: 3.2rem !important; /* Larger icon size. */
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55); /* Smooth, spring-like transition. */
        box-shadow: 0 18px 40px var(--shadow-medium); /* Strong shadow. */
        pointer-events: all; /* Makes buttons clickable. */
        border: 5px solid rgba(255, 255, 255, 0.8) !important; /* Thick, semi-transparent white border. */
        margin: 0 45px; /* Margin on left/right. */
        outline: none; /* Removes outline on focus. */
        filter: drop-shadow(0 0 15px rgba(0,119,182,0.7)); /* Strong glow effect. */
    }

    /* Hover effects for Owl Carousel navigation buttons. */
    .owl-nav button.owl-prev:hover,
    .owl-nav button.owl-next:hover {
        background-color: var(--secondary-color) !important; /* Changes background to secondary blue. */
        transform: scale(1.4); /* Scales up significantly. */
        box-shadow: 0 30px 70px var(--shadow-strong); /* Even stronger shadow. */
        border-color: var(--accent-color) !important; /* Changes border color to accent orange. */
        filter: drop-shadow(0 0 30px var(--accent-color)); /* Even stronger glow. */
    }

    /* Styling for Owl Carousel pagination dots. */
    .owl-dots {
        text-align: center; /* Centers the dots. */
        margin-top: 100px; /* Space above the dots. */
        z-index: 5; /* Ensures dots are visible. */
    }
    .owl-dots .owl-dot {
        width: 28px; /* Larger dot width. */
        height: 28px; /* Larger dot height. */
        background: #d0d5db; /* Default grey background. */
        border-radius: var(--border-radius-full); /* Perfect circle shape. */
        display: inline-block; /* Allows side-by-side display. */
        margin: 0 22px; /* Space between dots. */
        transition: all 0.4s ease; /* Smooth transition for state changes. */
        border: 6px solid transparent; /* Thick transparent border. */
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.25); /* Shadow for depth. */
    }

    /* Styling and animation for the active Owl Carousel dot. */
    .owl-dots .owl-dot.active {
        background: var(--primary-color); /* Primary blue background for active dot. */
        transform: scale(1.8); /* Scales up significantly. */
        border-color: var(--accent-color); /* Changes border color to accent orange. */
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.5); /* Stronger shadow. */
        animation: dotPulse 1.5s infinite alternate; /* Applies a pulsating animation. */
    }

    /* Keyframe animation for the dot pulse effect. */
    @keyframes dotPulse {
        0% { transform: scale(1.8); box-shadow: 0 10px 22px rgba(0, 0, 0, 0.5); } /* Initial scale and shadow. */
        100% { transform: scale(1.9); box-shadow: 0 12px 25px rgba(0, 0, 0, 0.6); } /* Slightly larger scale and deeper shadow. */
    }

    /* Styling for the popup message, used for glitter effect and firework display. */
    #popup-message {
        position: fixed; /* Fixed position relative to the viewport. */
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); /* Centers the popup precisely. */
        background: linear-gradient(135deg, #f0f8ff, #e6f7ff); /* Light gradient background. */
        border: 3px solid var(--primary-color); /* Primary blue border. */
        border-radius: var(--border-radius-lg); /* Large rounded corners. */
        padding: 40px; /* Internal padding. */
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5); /* Strong shadow. */
        z-index: 1000; /* Ensures it's on top of other content. */
        text-align: center; /* Centers text. */
        font-family: 'Poppins', sans-serif; /* Poppins font. */
        font-size: 1.8rem; /* Large font size. */
        color: var(--secondary-color); /* Secondary blue text color. */
        display: none; /* Hidden by default. */
        opacity: 0; /* Starts transparent. */
        transition: opacity 0.6s ease-in-out, transform 0.6s ease-in-out; /* Smooth transitions for fade and movement. */
        width: 95%; /* Responsive width. */
        max-width: 600px; /* Maximum width. */
        animation: popupAppear 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards; /* Applies an appearance animation. */
        backdrop-filter: blur(15px); /* Strong blur for frosted effect. */
        border-image: linear-gradient(45deg, #ff007f, #00c6ff) 1; /* Gradient border. */
        overflow: hidden; /* Hides overflowing content. */
    }

    /* Pseudo-element for the popup border shine effect. */
    #popup-message::before {
        content: ''; /* Required for pseudo-elements. */
        position: absolute; /* Positions relative to the popup. */
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px; /* Extends slightly beyond the popup. */
        border: 5px solid transparent; /* Transparent border for gradient fill. */
        border-radius: inherit; /* Inherits rounded corners. */
        background: linear-gradient(45deg, #ff007f, #00c6ff) border-box; /* Gradient background for the border. */
        -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0); /* Masking for border effect. */
        -webkit-mask-composite: destination-out;
        mask-composite: exclude;
        z-index: -1; /* Positions behind the popup content. */
        animation: popupBorderShine 3s linear infinite; /* Animates the border shine. */
    }

    /* Keyframe animation for the popup border shine, rotating the gradient. */
    @keyframes popupBorderShine {
        0% { border-image-source: linear-gradient(45deg, #ff007f, #00c6ff); } /* Starts with one gradient. */
        25% { border-image-source: linear-gradient(90deg, #00c6ff, #ff007f); } /* Rotates gradient. */
        50% { border-image-source: linear-gradient(135deg, #ff007f, #00c6ff); } /* Rotates gradient. */
        75% { border-image-source: linear-gradient(180deg, #00c6ff, #ff007f); } /* Rotates gradient. */
        100% { border-image-source: linear-gradient(45deg, #ff007f, #00c6ff); } /* Returns to start. */
    }

    /* Styling for the centered text within the popup message. */
    #popup-message center {
        font-size: 2.2rem; /* Larger font size. */
        font-weight: 900; /* Extra bold font weight. */
        margin-top: 15px; /* Space above text. */
        color: var(--accent-color); /* Accent orange color. */
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2), 0 0 10px rgba(255,140,0,0.5); /* Shadows for depth and glow. */
        letter-spacing: 1px; /* Increased letter spacing. */
        text-transform: uppercase; /* Converts text to uppercase. */
    }

    /* Keyframe animation for the popup appearance, providing a bouncy entrance. */
    @keyframes popupAppear {
        0% { opacity: 0; transform: translate(-50%, -60%) scale(0.8); filter: blur(10px); } /* Starts transparent, higher, smaller, blurred. */
        100% { opacity: 1; transform: translate(-50%, -50%) scale(1); filter: blur(0); } /* Becomes opaque, centered, normal size, clear. */
    }

    /* Styling for the firework canvas, used for celebratory effects. */
    #fireworkCanvas {
        position: fixed; /* Fixed position relative to the viewport. */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 999; /* Ensures it's above most content but below popup. */
        pointer-events: none; /* Allows mouse events to pass through. */
        display: none; /* Hidden by default. */
        background: rgba(0,0,0,0.1); /* Slight transparent black overlay. */
    }

    /* Responsive adjustments for various screen sizes, ensuring optimal display on all devices. */
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

<!-- Main container for the Patient Profiles Directory portal -->
<div class="container-xxl py-5">
    <div class="section-header wow fadeInUp" data-wow-delay="0.1s">
        <!-- Main attractive heading -->
        <h1 class="main-heading">Patient Profiles Directory 🧑‍⚕️</h1>
        <!-- Professional message under the heading -->
        <p class="professional-message">
            Explore and manage comprehensive patient profiles within our advanced directory.
            Each profile provides vital information, ensuring efficient and personalized healthcare management.
            Maintain accurate records and enhance patient care with ease.
        </p>
    </div>

    <!-- Owl Carousel for displaying patient profile cards -->
    <div class="owl-carousel patient-carousel">
        <?php
        // Check if patient data was successfully fetched and if there are any rows
        if ($patient_result && mysqli_num_rows($patient_result) > 0) :
            // Array of diverse icons for each patient profile card
            $icon_classes = [
                'fas fa-user-injured', 'fas fa-hospital-user', 'fas fa-person', 'fas fa-user-tag',
                'fas fa-user-check', 'fas fa-user-md', 'fas fa-user-nurse', 'fas fa-wheelchair',
                'fas fa-bed-pulse', 'fas fa-heartbeat', 'fas fa-lungs', 'fas fa-brain',
                'fas fa-bone', 'fas fa-tooth', 'fas fa-eye', 'fas fa-ear-listen',
                'fas fa-hand-holding-medical', 'fas fa-syringe', 'fas fa-pills', 'fas fa-capsules',
                'fas fa-flask-vial', 'fas fa-microscope', 'fas fa-x-ray', 'fas fa-file-waveform',
                'fas fa-notes-medical', 'fas fa-clipboard-user', 'fas fa-id-card-alt', 'fas fa-address-book',
                'fas fa-fingerprint', 'fas fa-shield-alt', 'fas fa-user-shield', 'fas fa-user-plus',
                'fas fa-user-minus', 'fas fa-user-times', 'fas fa-user-lock', 'fas fa-user-secret',
                'fas fa-user-tie', 'fas fa-user-cog', 'fas fa-user-graduate', 'fas fa-user-astronaut',
                'fas fa-user-ninja', 'fas fa-user-robot', 'fas fa-user-tag', 'fas fa-user-friends',
                'fas fa-users-medical', 'fas fa-people-arrows', 'fas fa-person-booth', 'fas fa-person-cane',
                'fas fa-person-digging', 'fas fa-person-falling', 'fas fa-person-hiking', 'fas fa-person-running',
                'fas fa-person-skiing', 'fas fa-person-swimming', 'fas fa-person-walking', 'fas fa-person-walking-dashed-line-arrow-right'
            ];
            $icon_index = 0; // Initialize icon index

            // Loop through each fetched patient row
            while ($row = mysqli_fetch_assoc($patient_result)) :
                // Sanitize and store data for display
                $id = htmlspecialchars($row['id']);
                $user_id = htmlspecialchars($row['user_id']);
                $patient_name = htmlspecialchars($row['patient_names']); // Use patient_names
                $gender = htmlspecialchars($row['gender']);
                $dob = htmlspecialchars($row['dob']);
                $blood_group = htmlspecialchars($row['blood_group']);
                $emergency_contact = htmlspecialchars($row['emergency_contact']);
                // $profile_picture = htmlspecialchars($row['profile_picture']); // Profile picture removed
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
                <!-- Individual patient profile card -->
                <div class="feedback-card text-center">
                    <!-- Dynamic icon for the card -->
                    <i class="feedback-icon <?= $current_icon ?>"></i>

                    <!-- Patient Name - Centered and unique styling -->
                    <p class="feedback-detail-item patient-name-unique">
                        <span>Patient: <?= $patient_name ?></span>
                    </p>

                    <!-- Patient ID - Highlighted and unique styling -->
                    <p class="feedback-detail-item id-unique">
                        <i class="fas fa-id-card-alt"></i> <span>ID: <?= $id ?></span>
                    </p>

                    <!-- User ID - Left-aligned with label on new line -->
                    <p class="feedback-detail-item">
                        <i class="fas fa-user"></i> <strong>User ID:</strong> <br><span><?= $user_id ?></span>
                    </p>

                    <!-- Gender - Left-aligned with label on new line -->
                    <p class="feedback-detail-item">
                        <i class="fas fa-venus-mars"></i> <strong>Gender:</strong> <br><span><?= $gender ?></span>
                    </p>

                    <!-- Date of Birth - Left-aligned with label on new line -->
                    <p class="feedback-detail-item">
                        <i class="fas fa-calendar-days"></i> <strong>Date of Birth:</strong> <br><span><?= $dob ?></span>
                    </p>

                    <!-- Blood Group - Left-aligned with label on new line -->
                    <p class="feedback-detail-item">
                        <i class="fas fa-tint"></i> <strong>Blood Group:</strong> <br><span><?= $blood_group ?></span>
                    </p>

                    <!-- Emergency Contact - Left-aligned with label on new line -->
                    <p class="feedback-detail-item">
                        <i class="fas fa-phone-volume"></i> <strong>Emergency Contact:</strong> <br><span><?= $emergency_contact ?></span>
                    </p>

                    <!-- Status - Left-aligned with label and styled button -->
                    <p class="feedback-detail-item">
                        <i class="fas fa-info-circle"></i> <strong>Status:</strong> <br><span class="feedback-status <?= $status_class ?>"><?= ucfirst($status) ?></span>
                    </p>

                    <!-- Created At - Left-aligned with label on new line -->
                    <p class="feedback-detail-item">
                        <i class="fas fa-calendar-alt"></i> <strong>Created At:</strong> <br><span><?= date('d M, Y H:i', strtotime($created_at)) ?></span>
                    </p>

                    <!-- Action button group for "Update" -->
                    <div class="action-btn-group">
                        <a href="update_patient.php?id=<?= $id ?>" target="_blank" class="action-btn view-btn">
                            <i class="fas fa-edit me-2"></i> Update Profile
                        </a>
                    </div>
                </div>
            <?php
            endwhile;
        else :
        ?>
            <!-- Message displayed if no patient profiles are found -->
            <div class="col-12 text-center py-5">
                <p class="professional-message">No patient profiles found in the system. Please add new profiles!</p>
                <?php if (isset($error_message)) : ?>
                    <p class="text-danger">Error: <?= $error_message ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
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
    ✨ Patient Profile Details ✨
    <br>
    <center>✨MEDITRONIX PROFILES✨</center>
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
        const patientCarousel = $('.patient-carousel');

        // Initialize Owl Carousel with specified options
        patientCarousel.owlCarousel({
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

        // Function to set equal height for all active patient profile cards
        function setEqualCardHeight() {
            let maxHeight = 0;
            // Reset height to auto before calculating to ensure correct measurement
            $('.patient-carousel .owl-item .feedback-card').css('height', 'auto');
            // Iterate over active items to find the maximum height
            $('.patient-carousel .owl-item.active').each(function() {
                let currentHeight = $(this).find('.feedback-card').outerHeight();
                if (currentHeight > maxHeight) {
                    maxHeight = currentHeight;
                }
            });
            // Apply the maximum height to all patient profile cards
            $('.patient-carousel .owl-item .feedback-card').css('height', maxHeight + 'px');
        }

        // Call the function on document ready and window resize
        setEqualCardHeight();
        $(window).on('resize', setEqualCardHeight);

        // Re-calculate height after carousel initialization, resizing, or content change
        patientCarousel.on('initialized.owl.carousel resized.owl.carousel changed.owl.carousel', function(event) {
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

        // Event listener for clicking on patient profile cards
        $(document).on('click', '.feedback-card', function() {
            // Remove 'active' class from all cards and add to the clicked one
            $('.feedback-card').removeClass('active');
            $(this).addClass('active');

            // Get the patient ID from the clicked card
            const patientId = $(this).find('.feedback-detail-item.id-unique span').text().replace('ID: ', '').trim();

            // Update popup message content
            popupMessage.find('br').first().remove(); // Remove existing line break if any
            popupMessage.find('center').html(`✨ Patient ID: ${patientId} Details ✨`);

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

// SELECT Query: Fetches all patient entries from the 'patients' table.
/*
SELECT id, user_id, patient_names, gender, dob, blood_group, emergency_contact, status, created_at FROM patients ORDER BY created_at DESC
*/

// INSERT Query: Inserts a new patient entry into the 'patients' table.
/*
INSERT INTO `patients` (`id`, `user_id`, `patient_names`, `gender`, `dob`, `blood_group`, `emergency_contact`, `status`, `created_at`)
VALUES (NULL, '[user_id]', '[patient_names]', '[gender]', '[dob]', '[blood_group]', '[emergency_contact]', '[status]', CURRENT_TIMESTAMP)
*/

// UPDATE Query: Updates an existing patient entry by ID in the 'patients' table.
/*
UPDATE `patients`
SET
    `user_id` = '[new_user_id]',
    `patient_names` = '[new_patient_names]',
    `gender` = '[new_gender]',
    `dob` = '[new_dob]',
    `blood_group` = '[new_blood_group]',
    `emergency_contact` = '[new_emergency_contact]',
    `status` = '[new_status]'
WHERE `id` = '[patient_id_to_update]'
*/

// DELETE Query: Deletes a patient entry by ID from the 'patients' table.
/*
DELETE FROM `patients` WHERE `id` = '[patient_id_to_delete]'
*/

// Include the footer file for consistent page structure.
// This file is assumed to contain necessary HTML body end and closing tags.
include("patientFooter.php");
ob_end_flush(); // End output buffering and send content to browser
?>
