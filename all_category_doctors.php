<?php
// Filename: all_category_doctors.php
include("adminHeader.php");
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$con = mysqli_connect("localhost", "root", "", "meditronix_new");
if (mysqli_connect_errno()) {
    error_log("Failed to connect to MySQL: " . mysqli_connect_error());
    die("Database connection failed. Please try again later.");
}

// Fetch doctors data
// Removed 'status' from the SELECT query as requested
$doctorsResult = mysqli_query($con, "SELECT `id`, `user_id`, `doctor_name`, `specialization`, `experience`, `availability`, `created_at` FROM `doctors` ORDER BY `created_at` DESC");
$doctorsData = [];
if ($doctorsResult) {
    while ($row = mysqli_fetch_assoc($doctorsResult)) {
        $doctorsData[] = $row;
    }
} else {
    error_log("Error fetching doctors data: " . mysqli_error($con));
    $doctorsData = [];
}
mysqli_close($con);
?>

<div class="container-wrapper">
    <style>
        :root {
            --primary-blue: #007bff;
            --secondary-blue: #00c6ff;
            --dark-blue: #0056b3;
            --pastel-color-1: hsl(200, 100%, 97%);
            --pastel-color-2: hsl(150, 100%, 97%);
            --pastel-color-3: hsl(60, 100%, 97%);
            --pastel-color-4: hsl(330, 100%, 97%); /* Light pink */
            --pastel-color-5: hsl(270, 100%, 97%); /* Light purple */
            --blushing-bloom-light-pink: #ffe6f0; /* Very light pink */
            --blushing-bloom-maroon: #800000; /* Maroon */
            --light-orange: #ffecd2; /* Light orange for container mix */
            --text-color-dark: #2c3e50;
            --text-color-medium: #555;
            --text-color-light: #888;
            --card-bg: rgba(255, 255, 255, 0.99);
            --card-border: rgba(0, 0, 0, 0.03);
            --shadow-light: 0 20px 60px rgba(0,0,0,0.15);
            --shadow-hover: 0 35px 90px rgba(0,0,0,0.35);
            --border-radius-xl: 45px;
            --padding-xl: 4.5rem;
            --transition-speed: 0.8s;
            --transition-ease: cubic-bezier(0.25, 0.8, 0.25, 1);
            --glow-color: #00eaff;
            --shine-color: rgba(255, 255, 255, 0.98);
            --water-crystal-blue: rgba(0, 255, 255, 0.8);
            --water-crystal-blue-dark: rgba(0, 180, 255, 0.6);
            --light-gradient-pink: linear-gradient(135deg, #FFD1DC, #FFB6C1); /* Light gradient pink */
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
        }
        html {
            scroll-behavior: smooth;
        }
        body {
            background: linear-gradient(135deg,
                var(--blushing-bloom-light-pink) 0%,
                var(--pastel-color-2) 20%,
                var(--pastel-color-3) 40%,
                var(--pastel-color-4) 60%,
                var(--blushing-bloom-maroon) 80%,
                var(--blushing-bloom-light-pink) 100%
            );
            background-size: 600% 600%;
            animation: gradientBackground 60s ease infinite alternate, pulseBackground 120s linear infinite;
            overflow-x: hidden;
            color: var(--text-color-medium);
            line-height: 2;
            position: relative;
            padding: 40px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            filter: saturate(1.1);
            cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="%23007bff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pointer"><path d="M14 2L20 8V22H4V8L10 2H14Z"></path><line x1="12" y1="2" x2="12" y2="8"></line><line x1="4" y1="8" x2="20" y2="8"></line></svg>') 12 12, auto;
        }
        @keyframes gradientBackground {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes pulseBackground {
            0% { filter: brightness(1); }
            50% { filter: brightness(1.05); }
            100% { filter: brightness(1); }
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            background: radial-gradient(circle at 10% 20%, rgba(255,255,255,0.08) 1px, transparent 1px),
                        radial-gradient(circle at 90% 80%, rgba(255,255,255,0.08) 1px, transparent 1px),
                        radial-gradient(circle at 50% 50%, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 50px 50px, 60px 60px, 40px 40px;
            animation: windEffect 180s linear infinite alternate, subtleZoom 200s linear infinite;
            z-index: -1;
            opacity: 0.9;
        }
        @keyframes windEffect {
            0% { background-position: 0% 0%, 50% 50%, 25% 75%; }
            100% { background-position: 100% 100%, 0% 0%, 75% 25%; }
        }
        @keyframes subtleZoom {
            0% { background-size: 50px 50px, 60px 60px, 40px 40px; }
            50% { background-size: 52px 52px, 63px 63px, 42px 42px; }
            100% { background-size: 50px 50px, 60px 60px, 40px 40px; }
        }
        .container-wrapper {
            width: 100%;
            max-width: 1900px; /* Extended max-width for full size */
            margin: 80px auto;
            background: var(--light-gradient-pink); /* Changed to light gradient pink */
            border-radius: var(--border-radius-xl);
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.4);
            padding: 60px;
            overflow: hidden;
            position: relative;
            z-index: 1;
            transform: translateZ(0);
            border: 3px solid rgba(0,0,0,0.1);
            backdrop-filter: blur(12px) brightness(1.05);
            perspective: 1000px;
            transform-style: preserve-3d;
        }
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
        .container-wrapper.shining::before {
            left: 300%;
        }
        .container-wrapper.shining::after {
            width: 500%;
            height: 500%;
            opacity: 1;
        }
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
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes headerGlow {
            0%, 100% { box-shadow: 0 25px 70px rgba(0,0,0,0.35), 0 0 25px var(--glow-color); }
            50% { box-shadow: 0 25px 70px rgba(0,0,0,0.45), 0 0 40px var(--glow-color); }
        }
        .page-header h1 {
            font-size: 6rem;
            background: linear-gradient(to right, #00d2ff, #3a7bd5, #e52e71, #ff8a00, #9b59b6, #00d2ff);
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
        .page-header p {
            font-size: 2rem;
            color: var(--text-color-dark);
            max-width: 1200px;
            margin: 0 auto;
            line-height: 2.1;
            text-shadow: 1px 1px 6px rgba(0,0,0,0.15);
            transform: translateZ(10px);
        }
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
        .slider-track {
            display: flex;
            gap: 80px;
            padding: 40px;
            min-width: fit-content;
            transform-style: preserve-3d;
            animation: autoScroll 60s linear infinite; /* Automatic sliding */
        }
        @keyframes autoScroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-100% + 100vw)); /* Adjust to scroll full width */ }
        }
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
            background-image: url('https://cdn.pixabay.com/photo/2020/06/20/15/30/woman-doctor-5321347_1280.jpg'); /* Adjusted placeholder size and text */
            background-size: cover;
            background-position: center;
            color: #333;
            text-shadow: 1px 1px 3px rgba(255,255,255,0.9);
            transform-style: preserve-3d;
            transform: translateZ(0);
        }
        .slider-card:hover {
            transform: translateY(-30px) scale(1.08) rotateX(5deg);
            box-shadow: var(--shadow-hover);
            background-color: rgba(255,255,255,1);
            background-blend-mode: overlay;
            border-color: rgba(0,198,255,0.5);
        }
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
        .slider-card.clicked::before {
            left: 300%;
        }
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
        .slider-card.clicked::after {
            width: 450%;
            height: 450%;
            opacity: 1;
        }
        .icon-container {
            width: 140px;
            height: 140px;
            background: linear-gradient(135deg, #00d2ff, #3a7bd5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 5rem;
            margin: 0 auto 45px;
            box-shadow: 0 18px 40px rgba(0,114,255,0.8);
            transition: transform 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d;
            transform: translateZ(30px);
        }
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
        .slider-card:hover .icon-container {
            transform: rotate(35deg) scale(1.35) translateZ(40px);
        }
        .slider-card h2 {
            font-size: 2.5rem;
            color: var(--text-color-dark);
            margin-bottom: 20px; /* Adjusted margin */
            text-align: center;
            font-weight: 900;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.15);
            line-height: 1.5;
            transform: translateZ(15px);
        }
        .slider-card p {
            color: var(--text-color-dark);
            font-size: 1.3rem;
            margin-bottom: 15px; /* Adjusted margin */
            line-height: 2;
            text-align: justify;
            flex-grow: 1;
            overflow: visible;
            text-overflow: unset;
            display: block;
            -webkit-line-clamp: unset;
            -webkit-box-orient: unset;
            transform: translateZ(5px);
        }
        .slider-card p strong {
            color: var(--dark-blue);
            font-weight: 700;
            text-shadow: 0 0 5px rgba(0,123,255,0.2);
        }
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
        .crud-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            width: 100%; /* Ensure buttons take full width for centering */
        }
        .crud-buttons .btn {
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
        .crud-buttons .btn::before {
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
        .crud-buttons .btn:hover::before {
            left: 100%;
        }
        .btn-edit {
            background: linear-gradient(45deg, #ffc107, #ff9800);
            color: #fff;
            border: none;
        }
        .btn-edit:hover {
            background: linear-gradient(45deg, #ff9800, #ffc107);
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(255,152,0,0.4);
        }
        .btn-delete {
            background: linear-gradient(45deg, #dc3545, #c82333);
            color: #fff;
            border: none;
        }
        .btn-delete:hover {
            background: linear-gradient(45deg, #c82333, #dc3545);
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(220,53,69,0.4);
        }
        /* Removed .btn-info as requested */

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

        .btn-add-new {
            background: linear-gradient(45deg, #28a745, #218838);
            color: #fff;
            border: none;
            padding: 15px 35px;
            font-size: 1.3rem;
            margin-top: 50px;
            border-radius: 15px;
        }
        .btn-add-new:hover {
            background: linear-gradient(45deg, #218838, #28a745);
            transform: translateY(-7px);
            box-shadow: 0 10px 25px rgba(40,167,69,0.5);
        }

        /* Custom Modal for Delete Confirmation */
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
            background: #dc3545;
            color: #fff;
            border: none;
        }
        .modal-buttons .btn-yes:hover {
            background: #c82333;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(220,53,69,0.3);
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
        <h1><i class="fas fa-stethoscope" style="margin-right: 20px; color: #00c6ff;"></i>Meditronix: Our Expert Doctors<i class="fas fa-user-md" style="margin-left: 20px; color: #0072ff;"></i></h1>
        <p>Discover our team of highly qualified and experienced medical professionals dedicated to providing exceptional healthcare. Each doctor brings a wealth of knowledge and compassionate care to ensure your well-being. Explore their profiles, specializations, and availability to find the perfect match for your health needs. At Meditronix, we are committed to connecting you with the best medical expertise available.</p>
    </div>

    <div class="slider-container" id="sliderContainer">
        <div class="slider-track" id="sliderTrack">
            <?php
            // Function to get a random icon based on specialization
            function getDoctorIcon($specialization) {
                $specialization = strtolower($specialization);
                if (strpos($specialization, 'cardiology') !== false || strpos($specialization, 'heart') !== false) {
                    return 'fas fa-heartbeat';
                } elseif (strpos($specialization, 'neurology') !== false || strpos($specialization, 'brain') !== false) {
                    return 'fas fa-brain';
                } elseif (strpos($specialization, 'pediatrics') !== false || strpos($specialization, 'child') !== false) {
                    return 'fas fa-child';
                } elseif (strpos($specialization, 'orthopedics') !== false || strpos($specialization, 'bone') !== false) {
                    return 'fas fa-bone';
                } elseif (strpos($specialization, 'dermatology') !== false || strpos($specialization, 'skin') !== false) {
                    return 'fas fa-allergies';
                } elseif (strpos($specialization, 'oncology') !== false || strpos($specialization, 'cancer') !== false) {
                    return 'fas fa-dna';
                } elseif (strpos($specialization, 'radiology') !== false || strpos($specialization, 'x-ray') !== false) {
                    return 'fas fa-x-ray';
                } elseif (strpos($specialization, 'surgery') !== false || strpos($specialization, 'surgeon') !== false) {
                    return 'fas fa-cut';
                } elseif (strpos($specialization, 'ophthalmology') !== false || strpos($specialization, 'eye') !== false) {
                    return 'fas fa-eye';
                } elseif (strpos($specialization, 'dentistry') !== false || strpos($specialization, 'dental') !== false) {
                    return 'fas fa-tooth';
                } elseif (strpos($specialization, 'psychiatry') !== false || strpos($specialization, 'mental') !== false) {
                    return 'fas fa-brain';
                } elseif (strpos($specialization, 'gastroenterology') !== false || strpos($specialization, 'digestive') !== false) {
                    return 'fas fa-stomach';
                } elseif (strpos($specialization, 'endocrinology') !== false || strpos($specialization, 'hormone') !== false) {
                    return 'fas fa-flask';
                } elseif (strpos($specialization, 'urology') !== false || strpos($specialization, 'kidney') !== false) {
                    return 'fas fa-kidneys';
                } elseif (strpos($specialization, 'gynecology') !== false || strpos($specialization, 'women') !== false) {
                    return 'fas fa-venus';
                } elseif (strpos($specialization, 'anesthesiology') !== false || strpos($specialization, 'anesthesia') !== false) {
                    return 'fas fa-syringe';
                } elseif (strpos($specialization, 'emergency medicine') !== false || strpos($specialization, 'ER') !== false) {
                    return 'fas fa-ambulance';
                } elseif (strpos(strtolower($specialization), 'internal medicine') !== false) {
                    return 'fas fa-user-nurse';
                } else {
                    return 'fas fa-user-md'; // Default icon
                }
            }

            if (!empty($doctorsData)):
                foreach ($doctorsData as $row):
                    $iconClass = getDoctorIcon($row['specialization']);
            ?>
                    <div class="slider-card">
                        <div class="icon-container"><i class="<?php echo $iconClass; ?>"></i></div>
                        <h2>Dr. <?php echo htmlspecialchars($row['doctor_name']); ?></h2>
                        <p><strong>Doctor ID:</strong> <?php echo htmlspecialchars($row['id']); ?></p>
                        <p><strong>User ID:</strong> <?php echo htmlspecialchars($row['user_id']); ?></p>
                        <p><strong>Specialization:</strong> <?php echo htmlspecialchars($row['specialization']); ?></p>
                        <p><strong>Experience:</strong> <?php echo htmlspecialchars($row['experience']); ?> Years</p>
                        <p><strong>Availability:</strong> <?php echo htmlspecialchars($row['availability']); ?></p>
                        <p><strong>Joined:</strong> <?php echo date('d M Y', strtotime($row['created_at'])); ?></p>
                        <footer class="crud-buttons">
                            <a href='doctor_edit.php?id=<?php echo $row['id']; ?>' class='btn btn-edit' title='Edit'>✏️ Edit</a>
                            <button class='btn btn-delete' data-doctor-id='<?php echo $row['id']; ?>' title='Delete'>🗑️ Delete</button>
                            <div class="card-social-links">
                                <a href='https://www.linkedin.com/in/<?php echo urlencode(htmlspecialchars($row['doctor_name'])); ?>' target="_blank" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                                <a href='https://www.youtube.com/results?search_query=<?php echo urlencode(htmlspecialchars($row['doctor_name'])); ?>' target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                                <a href='https://en.wikipedia.org/wiki/Special:Search/<?php echo urlencode(htmlspecialchars($row['doctor_name'])); ?>' target="_blank" title="Wikipedia"><i class="fab fa-wikipedia-w"></i></a>
                                <a href='https://www.instagram.com/explore/tags/<?php echo urlencode(str_replace(' ', '', htmlspecialchars($row['doctor_name']))); ?>/' target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                            </div>
                        </footer>
                    </div>
            <?php
                endforeach;
            else:
            ?>
                <div class="slider-card" style="flex: 0 0 100%; text-align: center; padding: 50px; background-image: url('https://placehold.co/700x400/F8F9FA/6C757D?text=No+Doctors+Available');">
                    <div class="icon-container"><i class="fas fa-exclamation-triangle"></i></div>
                    <h2>No Doctors Available</h2>
                    <p>Currently, there are no doctor profiles to display. Please check back later for updates or add a new doctor.</p>
                    <div class="text-center">
                        <a href="doctor_add.php" class="btn btn-add-new">➕ Add New Doctor</a>
                    </div>
                </div>
            <?php
            endif;
            ?>
        </div>
    </div>

    <div class="text-center">
        <a href="doctor_add.php" class="btn btn-add-new">➕ Add New Doctor</a>
    </div>

 

    <div class="modal-overlay" id="deleteConfirmationModal">
        <div class="modal-content">
            <h3>Are you sure you want to delete this doctor?</h3>
            <div class="modal-buttons">
                <button class="btn btn-yes" id="confirmDeleteYes">Yes, Delete</button>
                <button class="btn btn-no" id="confirmDeleteNo">No, Cancel</button>
            </div>
        </div>
    </div>



  <style>
    footer {
        text-align: center;
        padding: 20px 0;
        font-family: Arial, sans-serif;
        font-size: 14px;
        color: #333;
    }
</style>

<footer>
    &copy; <?php echo date("Y"); ?> Meditronix. All rights reserved. Pioneering healthcare insights for a healthier tomorrow.
    Designed with <span style="color: #e52e71;">&hearts;</span> for Rohan Kapri.
</footer>


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
        function random(min, max) {
            return Math.random() * (max - min) + min;
        }
        function createParticles(x, y) {
            const particles = [];
            const numParticles = 120; // More particles for a richer effect
            for (let i = 0; i < numParticles; i++) {
                particles.push({
                    x,
                    y,
                    radius: random(3.5, 6.5), // Slightly larger particles
                    color: `hsl(${Math.random() * 360}, 100%, 78%)`, // Brighter colors
                    dx: random(-12, 12), // Wider spread
                    dy: random(-12, 12),
                    alpha: 1,
                    gravity: 0.2, // Slightly more gravity
                    friction: 0.94 // Less friction for longer trails
                });
            }
            return particles;
        }
        let fireworks = [];
        function animateFireworks() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
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
                    ctx.fillStyle = `rgba(${p.color.match(/\d+/g).slice(0,3).join(",")},${p.alpha})`;
                    ctx.fill();
                });
                fireworks[index] = fw.filter(p => p.alpha > 0);
            });
            fireworks = fireworks.filter(fw => fw.length > 0);
            requestAnimationFrame(animateFireworks);
        }
        animateFireworks();
        function triggerFirework() {
            const x = canvas.width / 2;
            const y = canvas.height / 2;
            fireworks.push(createParticles(x, y));
            showPopupMessage();
        }
        function showPopupMessage() {
            const popup = document.getElementById('popup-message');
            popup.classList.add('show');
            setTimeout(() => {
                popup.classList.remove('show');
            }, 4500);
        }
        const containerWrapper = document.querySelector('.container-wrapper');
        if (containerWrapper) {
            containerWrapper.addEventListener('click', function() {
                console.log('Container clicked, applying shining effect.');
                this.classList.add('shining');
                setTimeout(() => {
                    this.classList.remove('shining');
                    console.log('Shining effect removed.');
                }, 2000);
            });
        }

        // Custom Delete Confirmation Modal Logic
        const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
        const confirmDeleteYes = document.getElementById('confirmDeleteYes');
        const confirmDeleteNo = document.getElementById('confirmDeleteNo');
        let doctorIdToDelete = null;

        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default link behavior
                doctorIdToDelete = this.dataset.doctorId;
                deleteConfirmationModal.classList.add('show');
            });
        });

        confirmDeleteYes.addEventListener('click', function() {
            if (doctorIdToDelete) {
                // In a real application, you would send an AJAX request here
                // For this example, we'll simulate the deletion by removing the card
                console.log('Simulating delete for doctor ID:', doctorIdToDelete);
                const cardToRemove = document.querySelector(`.slider-card [data-doctor-id="${doctorIdToDelete}"]`).closest('.slider-card');
                if (cardToRemove) {
                    cardToRemove.remove();
                }
                // Redirect to a delete script in a real scenario
                // window.location.href = 'doctor_delete.php?id=' + doctorIdToDelete;
            }
            deleteConfirmationModal.classList.remove('show');
        });

        confirmDeleteNo.addEventListener('click', function() {
            doctorIdToDelete = null;
            deleteConfirmationModal.classList.remove('show');
        });

        deleteConfirmationModal.addEventListener('click', function(event) {
            if (event.target === deleteConfirmationModal) {
                doctorIdToDelete = null;
                deleteConfirmationModal.classList.remove('show');
            }
        });

        // Card click effects
        document.querySelectorAll('.slider-card').forEach(card => {
            card.addEventListener('click', function(event) {
                // Only trigger effects if not clicking on action buttons
                if (!event.target.closest('.crud-buttons')) {
                    const rect = card.getBoundingClientRect();
                    const mouseX = event.clientX - rect.left;
                    const mouseY = event.clientY - rect.top;
                    card.style.setProperty('--mouse-x', `${mouseX}px`);
                    card.style.setProperty('--mouse-y', `${mouseY}px`);
                    this.classList.add('clicked');
                    setTimeout(() => {
                        this.classList.remove('clicked');
                    }, 1500);
                    triggerFirework();
                }
            });
        });

        // Automatic carousel scrolling
        let scrollSpeed = 0.5; // pixels per frame
        let currentScroll = 0;
        let animationFrameId;

        function autoScrollCarousel() {
            if (slider) {
                currentScroll += scrollSpeed;
                // Check if we've scrolled past the end, and reset if so
                if (currentScroll >= slider.scrollWidth - sliderContainer.clientWidth) {
                    currentScroll = 0; // Reset to start when end is reached
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

    </script>
</div>

<?php
include('adminfooter.php');
?>