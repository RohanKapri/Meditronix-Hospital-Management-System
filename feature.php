<?php
include('header.php'); // Assuming this includes necessary HTML head and body start
?>

<?php
// Database Connection
// Ensure your database 'meditronix_new' is running and accessible.
// IMPORTANT: In a production environment, avoid 'root' and empty passwords.
// Use environment variables or a secure configuration file.
$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// --- Data Fetching for Doctors ---

// Fetch all doctor data for display in carousel cards
// Ordered by doctor name for consistent display
$doctors_result = mysqli_query($db, "SELECT `id`, `doctor_name`, `specialization`, `user_id`, `experience`, `availability`, `status`, `created_at` FROM `doctors` WHERE 1 ORDER BY doctor_name ASC");

// Check if any doctor records were fetched
$doctors_count = mysqli_num_rows($doctors_result);

// Prepare dummy data if no doctor records are found in the database
$dummy_doctors_items = [];
if ($doctors_count === 0) {
    $dummy_doctors_items = [
        [
            'id' => 'D-001',
            'doctor_name' => 'Dr. Emily Watson',
            'specialization' => 'Cardiology',
            'user_id' => 'U-101',
            'experience' => 15,
            'availability' => 'Mon-Fri, 9 AM - 5 PM',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s', strtotime('-5 years'))
        ],
        [
            'id' => 'D-002',
            'doctor_name' => 'Dr. John Smith',
            'specialization' => 'Pediatrics',
            'user_id' => 'U-102',
            'experience' => 10,
            'availability' => 'Tue-Sat, 10 AM - 6 PM',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 years'))
        ],
        [
            'id' => 'D-003',
            'doctor_name' => 'Dr. Sarah Lee',
            'specialization' => 'Dermatology',
            'user_id' => 'U-103',
            'experience' => 8,
            'availability' => 'Mon, Wed, Fri, 8 AM - 4 PM',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s', strtotime('-2 years'))
        ],
        [
            'id' => 'D-004',
            'doctor_name' => 'Dr. Michael Brown',
            'specialization' => 'Orthopedics',
            'user_id' => 'U-104',
            'experience' => 20,
            'availability' => 'Mon-Thu, 9 AM - 3 PM',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s', strtotime('-7 years'))
        ],
        [
            'id' => 'D-005',
            'doctor_name' => 'Dr. Jessica Green',
            'specialization' => 'Neurology',
            'user_id' => 'U-105',
            'experience' => 12,
            'availability' => 'Tue, Thu, Fri, 11 AM - 7 PM',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s', strtotime('-4 years'))
        ],
        [
            'id' => 'D-006',
            'doctor_name' => 'Dr. Robert White',
            'specialization' => 'Oncology',
            'user_id' => 'U-106',
            'experience' => 18,
            'availability' => 'Mon-Wed, 9 AM - 4 PM',
            'status' => 'inactive', // Example of inactive status
            'created_at' => date('Y-m-d H:i:s', strtotime('-6 years'))
        ],
        [
            'id' => 'D-007',
            'doctor_name' => 'Dr. Olivia Kim',
            'specialization' => 'Gastroenterology',
            'user_id' => 'U-107',
            'experience' => 7,
            'availability' => 'Mon-Fri, 1 PM - 8 PM',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s', strtotime('-1.5 years'))
        ]
    ];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meditronix: Meet Our Doctors</title>
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
        --pastel-color-1: #e0f7fa; /* Light Cyan */
        --pastel-color-2: #e8f5e9; /* Light Greenish Blue */
        --pastel-color-3: #f9fbe7; /* Light Yellowish Green */
        --pastel-color-4: #fce4ec; /* Light Pink */
        --pastel-color-5: #ede7f6; /* Light Purple */
        --text-color-dark: #222;
        --text-color-medium: #555;
        --text-color-light: #888;
        --card-bg-start: #e0f8ff; /* Alice Blue for crystal effect */
        --card-bg-end: #c0eaff;   /* Lighter blue for crystal effect */
        --card-border: rgba(255, 255, 255, 0.9);
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
        background: linear-gradient(to right, #00c6ff, #0072ff, #4facfe, #00f2fe); /* More colors for shimmer */
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
      DOCTORS CAROUSEL SECTION
      Styling for the doctor cards carousel, including auto-sliding and click effects.
    ========================================================================*/
    .doctors-carousel-section {
        overflow-x: hidden; /* Ensures no scrollbar */
        padding: 60px 0; /* More vertical padding */
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        position: relative;
        box-shadow: inset 0 0 30px rgba(0,0,0,0.12); /* Deeper inner shadow */
        border-radius: var(--border-radius-xl);
        background: rgba(255,255,255,0.9); /* Slightly more opaque background */
        border: 1px solid var(--card-border);
        /* Background image for doctors section */
        background-image: url('https://cdn.pixabay.com/photo/2015/02/26/15/40/doctor-650534_1280.jpg'); /* Placeholder image for doctors background */
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

    .doctors-carousel-track {
        display: flex;
        gap: 70px; /* Increased gap between cards */
        padding: 40px; /* Increased padding inside the track */
        min-width: fit-content; /* Allows content to exceed container width */
        transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Smooth transition for JS-controlled slide */
    }

    .doctor-card {
        flex: 0 0 600px; /* Significantly larger and fixed width for equal size */
        min-width: 600px; /* Ensures minimum width even if flex tries to shrink */
        height: 900px; /* Increased height for full icon visibility and more space */
        background: linear-gradient(145deg, var(--card-bg-start) 0%, var(--card-bg-end) 100%); /* Crystal light blue gradient */
        border-radius: var(--border-radius-xl);
        padding: var(--padding-xl);
        position: relative;
        box-shadow: 0 12px 35px rgba(0, 123, 255, 0.15), /* Soft blue shadow */
                    0 30px 90px rgba(0,0,0,0.2); /* General shadow */
        transition: transform var(--transition-speed) var(--transition-ease), box-shadow var(--transition-speed) var(--transition-ease), background var(--transition-speed) var(--transition-ease);
        overflow: hidden;
        border: 3px solid rgba(0, 123, 255, 0.4); /* More prominent blue border */
        cursor: pointer;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        z-index: 5; /* Ensure cards are above effects */
        transform-style: preserve-3d; /* Enable 3D transformations for children */
        perspective: 1000px; /* For 3D effect */
    }

    .doctor-card:hover {
        transform: translateY(-30px) scale(1.08) rotateX(2.5deg) rotateY(2.5deg); /* More dramatic hover effect with 3D tilt */
        box-shadow: 0 18px 45px rgba(0, 123, 255, 0.25), /* Enhanced blue shadow */
                    0 40px 110px rgba(0,0,0,0.4); /* More prominent general shadow */
        background: linear-gradient(145deg, #eaf8ff 0%, #d0eaff 100%); /* Slightly brighter crystal blue on hover */
    }

    /* Glittering Shine Effect on click (Shining Blade) */
    .doctor-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -400%; /* Start even farther off-screen to the left */
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 1), transparent); /* Super bright shine, fully opaque */
        transform: skewX(-45deg); /* More angled "blade" */
        transition: left 1.8s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Slower, smoother transition */
        pointer-events: none;
        z-index: 10;
        opacity: 0; /* Hidden by default */
    }
    .doctor-card.clicked::before {
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
    .doctor-card::after {
        content: '';
        position: absolute;
        top: var(--mouse-y, 50%);
        left: var(--mouse-x, 50%);
        width: 0;
        height: 0;
        border-radius: 50%;
        background: radial-gradient(circle at center, rgba(0, 230, 255, 0.8), transparent 85%); /* Brighter, more expansive blue water ripple */
        opacity: 0;
        transform: translate(-50%, -50%);
        transition: width 1.5s ease-out, height 1.5s ease-out, opacity 1.5s ease-out; /* Slower, more fluid expansion */
        pointer-events: none;
        z-index: 9;
        box-shadow: 0 0 60px 25px rgba(0, 230, 255, 0.6); /* Stronger glowing effect for water */
    }
    .doctor-card.clicked::after {
        width: 500%; /* Expand significantly */
        height: 500%;
        opacity: 1;
    }

    .doctor-icon-container {
        width: 140px; /* Larger icon container */
        height: 140px;
        background: linear-gradient(135deg, #00c6ff, #0072ff);
        border-radius: 50%; /* Ensure it's a perfect circle */
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 5rem; /* Larger icon font */
        margin: 0 auto 45px; /* More margin */
        box-shadow: 0 20px 45px rgba(0,114,255,0.9); /* Stronger shadow */
        transition: transform 0.9s cubic-bezier(0.68, -0.55, 0.27, 1.55); /* Springy animation */
        position: relative;
        overflow: hidden; /* Ensure content inside is clipped if it overflows */
    }
    .doctor-icon-container::before {
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

    .doctor-card:hover .doctor-icon-container {
        transform: rotate(40deg) scale(1.4); /* More dramatic rotate and scale */
    }

    .doctor-card h4 {
        font-size: 3.2rem; /* Larger title */
        color: var(--text-color-dark);
        margin-bottom: 18px;
        font-weight: 900;
        text-shadow: 1px 1px 6px rgba(0,0,0,0.25);
        text-align: center; /* Centered */

        /* Glitter effect for doctor name */
        background: linear-gradient(90deg, #fefefe, #ffd700, #fefefe, #ffd700, #fefefe); /* Gold shimmer */
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: 400% 100%; /* Larger background size for more prominent shimmer */
        animation: textShine 6s linear infinite; /* Slower animation */
    }

    .doctor-card h5 {
        font-size: 2.4rem; /* Larger specialization */
        color: var(--primary-blue);
        margin-bottom: 35px;
        font-weight: 800; /* More bold */
        text-shadow: 1px 1px 4px rgba(0,0,0,0.15);
        text-align: center; /* Centered */

        /* Glitter effect for specialization */
        background: linear-gradient(90deg, #e0f7fa, #80deea, #e0f7fa, #80deea, #e0f7fa); /* Aqua shimmer */
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: 400% 100%; /* Larger background size for more prominent shimmer */
        animation: textShine 6s linear infinite reverse; /* Reverse animation for contrast */
    }

    @keyframes textShine {
        0% { background-position: 400% 0; }
        100% { background-position: -400% 0; }
    }

    .doctor-card p {
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

    .doctor-card p strong {
        color: var(--text-color-dark);
        font-weight: 700;
    }

    .doctor-card p i {
        color: var(--secondary-blue); /* Icon color */
        font-size: 1.8rem; /* Larger icon size */
        min-width: 35px; /* Ensure consistent spacing */
        text-shadow: 0.8px 0.8px 3px rgba(0,198,255,0.4); /* Icon shadow */
    }

    .doctor-card span {
        font-weight: 600;
    }

    /* Status classes are no longer used but kept for reference if needed in other parts of the app */
    .doctor-card .status-active {
        color: #28a745; /* Green for active */
        font-weight: 700;
        text-shadow: 0.5px 0.5px 1px rgba(40,167,69,0.2);
    }

    .doctor-card .status-inactive {
        color: #dc3545; /* Red for inactive */
        font-weight: 700;
        text-shadow: 0.5px 0.5px 1px rgba(220,53,69,0.2);
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
        color: var(--primary-blue); /* Default icon color */
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

    /* Specific styling for the initial "Thanks for exploring" popup */
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
        color: var(--primary-blue);
        font-size: 3.5rem; /* Larger icons */
        text-decoration: none;
        transition: color 0.6s ease, transform 0.6s ease, text-shadow 0.6s ease;
    }
    .footer-social-links a:hover {
        transform: translateY(-15px) scale(1.5); /* More lift */
        color: var(--dark-blue);
        text-shadow: 0 12px 25px rgba(0,123,255,0.6);
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
        .doctor-card {
            flex: 0 0 500px;
            min-width: 500px;
            height: 800px; /* Adjusted height */
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
        .doctor-card {
            flex: 0 0 450px;
            min-width: 450px;
            padding: 3rem;
            height: 750px; /* Adjusted height */
        }
        .doctor-icon-container {
            width: 110px;
            height: 110px;
            font-size: 3.5rem;
        }
        .doctor-card h4 {
            font-size: 2rem;
        }
        .doctor-card h5 {
            font-size: 1.4rem;
        }
        .doctor-card p {
            font-size: 1.1rem;
        }
        .doctors-carousel-track {
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
        .doctor-card {
            flex: 0 0 400px; /* Adjust for smaller screens */
            min-width: 400px;
            padding: 2.5rem;
            height: 700px; /* Adjusted height */
        }
        .doctors-carousel-track {
            justify-content: flex-start;
            padding-left: 15px;
            padding-right: 15px;
            gap: 40px;
        }
        .doctor-icon-container {
            width: 100px;
            height: 100px;
            font-size: 3.2rem;
            margin-bottom: 30px;
        }
        .doctor-card h4 {
            font-size: 1.8rem;
        }
        .doctor-card h5 {
            font-size: 1.3rem;
        }
        .doctor-card p {
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
        .doctor-card {
            flex: 0 0 95%; /* Take up almost full width on mobile */
            min-width: 300px; /* Ensure it doesn't get too small */
            margin: 0 auto; /* Center cards */
            padding: 2rem;
            height: 650px; /* Adjusted height */
        }
        .doctors-carousel-track {
            gap: 30px;
            padding-left: 10px;
            padding-right: 10px;
        }
        .doctor-icon-container {
            width: 80px;
            height: 80px;
            font-size: 2.8rem;
            margin-bottom: 25px;
        }
        .doctor-card h4 {
            font-size: 1.6rem;
        }
        .doctor-card h5 {
            font-size: 1.2rem;
        }
        .doctor-card p {
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
        .doctor-card {
            padding: 1.5rem;
            flex: 0 0 98%;
            min-width: 280px;
            height: 600px; /* Adjusted height */
        }
        .doctor-icon-container {
            width: 70px;
            height: 70px;
            font-size: 2.5rem;
        }
        .doctor-card h4 {
            font-size: 1.4rem;
        }
        .doctor-card h5 {
            font-size: 1.1rem;
        }
        .doctor-card p {
            font-size: 0.85rem;
        }
        .doctors-carousel-track {
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
        <h1><i class="fas fa-user-nurse" style="margin-right: 20px; color: #00c6ff;"></i>Meditronix: Meet Our Esteemed Doctors<i class="fas fa-clinic-medical" style="margin-left: 20px; color: #0072ff;"></i></h1>
        <p>At Meditronix, our strength lies in our exceptional team of medical professionals. We are proud to introduce you to our highly qualified and compassionate doctors, each a leader in their respective fields. With years of experience, dedication to patient well-being, and a commitment to continuous learning, our physicians are here to provide you with the highest standard of care. Explore their profiles and find the specialist who best meets your healthcare needs.</p>
    </div>

    <!-- Doctors Carousel Section -->
    <div class="doctors-carousel-section" id="doctorsCarouselContainer">
        <div class="doctors-carousel-track" id="doctorsCarouselTrack">
            <?php
            // If no doctors from DB, use dummy data
            if ($doctors_count === 0) {
                $current_doctors_items = $dummy_doctors_items;
            } else {
                // Reset pointer for doctors_result to ensure all doctors are displayed
                mysqli_data_seek($doctors_result, 0);
                $current_doctors_items = [];
                while ($row = mysqli_fetch_assoc($doctors_result)) {
                    $current_doctors_items[] = $row;
                }
            }

            // Define a set of relevant icons to cycle through for doctors
            $doctor_icons = [
                'fas fa-user-md',          // General doctor
                'fas fa-heartbeat',        // Cardiology
                'fas fa-child',            // Pediatrics
                'fas fa-hand-sparkles',    // Dermatology
                'fas fa-bone',             // Orthopedics
                'fas fa-brain',            // Neurology
                'fas fa-microscope',       // Oncology/Research
                'fas fa-lungs',            // Pulmonology
                'fas fa-tooth',            // Dentistry (if applicable)
                'fas fa-eye',              // Ophthalmology
                'fas fa-ear-listen',       // ENT
                'fas fa-syringe'           // General medicine/vaccines
            ];

            $icon_index = 0; // To cycle through icons
            foreach ($current_doctors_items as $doctor_item) {
                // Get a specific icon from the array and increment index
                $current_icon = $doctor_icons[$icon_index % count($doctor_icons)];
                $icon_index++;
            ?>
            <div class="doctor-card" data-doctor-id="<?= htmlspecialchars($doctor_item['id']); ?>">
                <div class="doctor-icon-container"><i class="<?= $current_icon; ?>"></i></div>
                <h4><?= htmlspecialchars($doctor_item['doctor_name']) ?></h4>
                <h5><?= htmlspecialchars($doctor_item['specialization']) ?></h5>
                <p><i class="fas fa-id-badge"></i><strong>Doctor ID:</strong> <?= htmlspecialchars($doctor_item['id']) ?></p>
                <p><i class="fas fa-user"></i><strong>User ID:</strong> <?= htmlspecialchars($doctor_item['user_id']) ?></p>
                <p><i class="fas fa-briefcase-medical"></i><strong>Experience:</strong> <?= htmlspecialchars($doctor_item['experience']) ?> Years</p>
                <p><i class="fas fa-calendar-alt"></i><strong>Availability:</strong> <?= htmlspecialchars($doctor_item['availability']) ?></p>
                <!-- Removed Status field as per request -->
                <p><i class="fas fa-calendar-plus"></i><strong>Joined:</strong> <?= date('d M Y', strtotime($doctor_item['created_at'])) ?></p>

                <!-- Social Links for each doctor card -->
                <div class="card-social-links">
                    <a href="https://www.linkedin.com/in/rohankapri" target="_blank" class="linkedin" title="LinkedIn Profile"><i class="fab fa-linkedin"></i></a>
                    <a href="https://www.youtube.com/@Google" target="_blank" class="youtube" title="YouTube Channel"><i class="fab fa-youtube"></i></a>
                    <a href="https://www.instagram.com/google/" target="_blank" class="instagram" title="Instagram Profile"><i class="fab fa-instagram"></i></a>
                    <a href="https://en.wikipedia.org/wiki/Medicine" target="_blank" class="wikipedia" title="Wikipedia Page"><i class="fab fa-wikipedia-w"></i></a>
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

<!-- Initial "Welcome" popup -->
<div id="popup-message">✨ Welcome to Meditronix Doctors! ✨<br><center>Excellence in Every Specialty.</center></div>
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
function showCustomAlert(message, title = 'Notification') {
    const popupModal = document.getElementById('customPopupMessage');
    const popupTitle = document.getElementById('popupTitle');
    const popupMessage = document.getElementById('popupMessage');

    popupTitle.textContent = title;
    popupMessage.textContent = message;

    popupModal.style.display = 'flex'; // Use flex to center
}

function closeCustomAlert() {
    document.getElementById('customPopupMessage').style.display = 'none';
}

// Initial "Welcome" popup on page load
window.addEventListener('load', function() {
    const initialPopup = document.getElementById('popup-message');
    initialPopup.classList.add('show');
    setTimeout(() => initialPopup.classList.remove('show'), 3000);
});

// --- Doctor Card Interactions (Glitter and Water effects) ---
document.querySelectorAll('.doctor-card').forEach(card => {
    card.addEventListener('click', (event) => {
        // Prevent triggering the card effect if a social link or other interactive element was clicked
        if (event.target.closest('.card-social-links a')) {
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

//======================================================================
// CAROUSEL AUTO-SLIDING FEATURE (BI-DIRECTIONAL "TRAIN" MOVEMENT)
// This section controls the automatic, smooth, back-and-forth scrolling
// of the doctor cards carousel.
//======================================================================
const doctorsCarouselContainer = document.getElementById('doctorsCarouselContainer');
const doctorsCarouselTrack = document.getElementById('doctorsCarouselTrack');
const doctorsCards = document.querySelectorAll('.doctor-card');

let currentScroll = 0;
let scrollDirection = 1; // 1 for right, -1 for left
let carouselAnimationFrameId;
const scrollSpeed = 2.0; // Slightly slower speed for smoother auto-sliding
const pauseAtEndDuration = 3000; // Longer pause duration at the end/start of the track

function animateDoctorsCarousel() {
    // Calculate the total width of the track including gaps
    const trackWidth = doctorsCarouselTrack.scrollWidth;
    // Calculate the visible width of the container
    const containerWidth = doctorsCarouselContainer.clientWidth;
    // Calculate the maximum scrollable distance
    const maxScrollLeft = trackWidth - containerWidth;

    // If there are no cards or the content is smaller than the container, stop animation
    if (doctorsCards.length === 0 || maxScrollLeft <= 0) {
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
            carouselAnimationFrameId = requestAnimationFrame(animateDoctorsCarousel);
        }, pauseAtEndDuration);
    }
    // Check if we've reached the beginning (scrolling left)
    else if (scrollDirection === -1 && currentScroll <= 0) {
        currentScroll = 0; // Cap at min scroll
        scrollDirection = 1; // Change direction to right
        // Add a pause before reversing direction
        cancelAnimationFrame(carouselAnimationFrameId);
        setTimeout(() => {
            carouselAnimationFrameId = requestAnimationFrame(animateDoctorsCarousel);
        }, pauseAtEndDuration);
    }

    // Apply the transform to the track to simulate scrolling
    doctorsCarouselTrack.style.transform = `translateX(-${currentScroll}px)`;

    // Continue animation if not paused
    if (carouselAnimationFrameId) { // Ensure it's not cancelled
        carouselAnimationFrameId = requestAnimationFrame(animateDoctorsCarousel);
    }
}

// Start auto-scrolling when the page loads
window.addEventListener('load', () => {
    carouselAnimationFrameId = requestAnimationFrame(animateDoctorsCarousel);
});

// Pause scrolling on hover over the carousel
doctorsCarouselContainer.addEventListener('mouseover', () => {
    cancelAnimationFrame(carouselAnimationFrameId);
    carouselAnimationFrameId = null; // Explicitly set to null when paused
});

doctorsCarouselContainer.addEventListener('mouseout', () => {
    if (!carouselAnimationFrameId) { // Only restart if it was paused
        carouselAnimationFrameId = requestAnimationFrame(animateDoctorsCarousel);
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
            p.dy += p.gravity; // Apply gravity
            p.y += p.dy;
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

// Add firework trigger to doctor cards on click
document.querySelectorAll('.doctor-card').forEach(card => {
    card.addEventListener('click', (event) => {
        // Only trigger firework if not clicking on a social link
        if (!event.target.closest('.card-social-links a')) {
            triggerFirework(event); // Pass the event object to get click coordinates
        }
    });
});

</script>
</body>
</html>


<?php include('footer.php'); // Assuming this closes body and html tags and includes any common scripts ?>