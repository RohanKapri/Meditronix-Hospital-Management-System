<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Kolkata');
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "meditronix_new";
$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$db) {
    die("Connection Failed: " . mysqli_connect_error());
}
$doctors = mysqli_query($db, "SELECT `id`, `user_id`, `doctor_name`, `specialization`, `experience`, `availability`, `status`, `created_at` FROM `doctors` ORDER BY doctor_name ASC");
if (!$doctors) {
    $error_message = "Error fetching doctors data: " . mysqli_error($db);
    $doctors = false;
}
include("patientHeader.php");
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@700;800;900&display=swap" rel="stylesheet">
<style>
    :root {
        --primary-color: #0077b6;
        --secondary-color: #023e8a;
        --accent-color: #ff8c00;
        --highlight-color-light: #ffc107;
        --card-bg-light-pink: #fce4ec;
        --card-bg-light-blue: #e0f2f7;
        --card-bg-light-orange: #ffe0cc;
        --card-multi-gradient: linear-gradient(145deg, var(--card-bg-light-pink) 0%, var(--card-bg-light-blue) 50%, var(--card-bg-light-orange) 100%);
        --card-shine-gradient: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%);
        --text-dark: #343a40;
        --text-light: #6c757d;
        --text-heading-soft: rgba(2, 62, 138, 0.85);
        --text-id-color: #c0392b;
        --text-status-active: #28a745;
        --text-status-inactive: #dc3545;
        --text-status-onleave: #ffc107;
        --border-color-light: #f0f0f0;
        --border-color-medium: rgba(255, 255, 255, 0.7);
        --shadow-light: rgba(0, 0, 0, 0.08);
        --shadow-medium: rgba(0, 0, 0, 0.18);
        --shadow-strong: rgba(0, 0, 0, 0.3);
        --shadow-inset: inset 0 0 15px rgba(0, 0, 0, 0.05);
        --transition-speed-fast: 0.2s;
        --transition-speed-normal: 0.4s;
        --transition-speed-slow: 0.6s;
        --border-radius-sm: 8px;
        --border-radius-md: 15px;
        --border-radius-lg: 25px;
        --border-radius-full: 50%;
        --background-ruby-red: #f8e0e0;
        --background-greyish-red: #d9b8b8;
        --background-pink: #fce4ec;
        --background-gradient-body: linear-gradient(135deg, var(--background-ruby-red) 0%, var(--background-greyish-red) 50%, var(--background-pink) 100%);
    }
    body {
        font-family: 'Poppins', sans-serif;
        background: var(--background-gradient-body);
        color: var(--text-dark);
        line-height: 1.7;
        overflow-x: hidden;
        scroll-behavior: smooth;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        position: relative;
        padding: 0;
        margin: 0;
    }
    body::after {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
        background-repeat: repeat;
        background-size: 60px 60px;
        animation: waterfall 90s linear infinite;
        z-index: -2;
        opacity: 0.15;
        pointer-events: none;
    }
    @keyframes waterfall {
        from { background-position: 0 0; }
        to { background-position: 120px 120px; }
    }
    .container-xxl {
        padding: 6rem 3rem;
        flex-grow: 1;
        background-color: rgba(255, 255, 255, 0.98);
        border-radius: var(--border-radius-lg);
        box-shadow: 0 15px 50px var(--shadow-strong);
        margin: 80px auto;
        max-width: 1500px;
        min-width: 320px;
        position: relative;
        overflow: hidden;
        border: 2px solid rgba(255, 255, 255, 0.8);
        transform-style: preserve-3d;
        perspective: 1000px;
        animation: containerEntrance 1.5s ease-out forwards;
    }
    @keyframes containerEntrance {
        0% {
            opacity: 0;
            transform: translateY(50px) scale(0.95);
            filter: blur(5px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }
    }
    .section-header {
        text-align: center;
        margin-bottom: 70px;
        position: relative;
        z-index: 2;
    }
    .main-heading {
        font-family: 'Rubik', sans-serif;
        font-size: 4.8rem;
        font-weight: 900;
        color: var(--secondary-color);
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 3px;
        position: relative;
        display: inline-block;
        text-shadow: 0 0 20px rgba(0, 119, 182, 0.7), 0 0 35px rgba(0, 119, 182, 0.5);
        -webkit-text-stroke: 1.5px var(--primary-color);
        color: transparent;
        background-image: linear-gradient(45deg, var(--secondary-color), var(--primary-color), var(--accent-color));
        -webkit-background-clip: text;
        background-clip: text;
        background-size: 200% auto;
        animation: flyIn 1.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards, textGradientShine 5s linear infinite;
    }
    .main-heading::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 150px;
        height: 8px;
        background: linear-gradient(to right, var(--primary-color), var(--accent-color), var(--secondary-color));
        border-radius: 4px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    @keyframes flyIn {
        0% {
            opacity: 0;
            transform: translateY(-100px) scale(0.7);
            filter: blur(15px) brightness(0.5);
        }
        50% {
            filter: blur(0px) brightness(1);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0px) brightness(1);
        }
    }
    @keyframes textGradientShine {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .professional-message {
        font-size: 1.35rem;
        color: var(--text-light);
        max-width: 1000px;
        margin: 0 auto 60px auto;
        padding: 25px 40px;
        background-color: rgba(255, 255, 255, 0.95);
        border-left: 10px solid var(--primary-color);
        border-radius: var(--border-radius-md);
        box-shadow: 0 8px 25px var(--shadow-light);
        line-height: 1.8;
        font-weight: 500;
        text-align: justify;
        border: 1px solid rgba(0, 119, 182, 0.1);
        transition: all var(--transition-speed-normal) ease;
    }
    .professional-message:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px var(--shadow-medium);
        border-left-color: var(--accent-color);
    }
    .doctor-card {
        background: var(--card-multi-gradient);
        border: 2px solid var(--border-color-medium);
        box-shadow: 0 12px 40px var(--shadow-light), var(--shadow-inset);
        border-radius: var(--border-radius-lg);
        padding: 40px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all var(--transition-speed-normal) cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        z-index: 1;
        backdrop-filter: blur(5px) brightness(1.05);
        transform-style: preserve-3d;
        transform: translateZ(0);
        animation: cardFloat 5s infinite alternate ease-in-out;
    }
    @keyframes cardFloat {
        0% { transform: translateY(0px) rotateX(0deg) rotateY(0deg); }
        50% { transform: translateY(-5px) rotateX(0.5deg) rotateY(-0.5deg); }
        100% { transform: translateY(0px) rotateX(0deg) rotateY(0deg); }
    }
    .doctor-card::before {
        content: '';
        position: absolute;
        top: -5px;
        left: -5px;
        right: -5px;
        bottom: -5px;
        background: linear-gradient(45deg, #ff007f, #00c6ff, #ff007f, #00c6ff, #ff007f, #00c6ff);
        background-size: 600% 600%;
        z-index: -1;
        filter: blur(12px) brightness(1.2);
        opacity: 0;
        transition: opacity var(--transition-speed-normal) ease-in-out;
        border-radius: var(--border-radius-lg);
        animation: glitterShine 3s linear infinite;
        animation-play-state: paused;
    }
    .doctor-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: -150%;
        width: 100%;
        height: 100%;
        background: var(--card-shine-gradient);
        transform: skewX(-20deg);
        transition: transform var(--transition-speed-slow) ease-out;
        pointer-events: none;
        opacity: 0;
        z-index: 2;
        border-radius: var(--border-radius-lg);
    }
    .doctor-card:hover::before,
    .doctor-card.active::before {
        opacity: 1;
        animation-play-state: running;
    }
    .doctor-card:hover::after,
    .doctor-card.active::after {
        opacity: 1;
        transform: skewX(-20deg) translateX(250%);
        transition: transform 1s ease-out;
    }
    .doctor-card:not(:hover)::after {
        transform: skewX(-20deg) translateX(-150%);
        transition: transform 0.01s linear 1s;
        opacity: 0;
    }
    .doctor-card:hover {
        transform: translateY(-15px) scale(1.05) rotateX(2deg) rotateY(2deg);
        box-shadow: 0 25px 60px var(--shadow-medium), var(--shadow-inset);
        border-color: var(--accent-color);
    }
    @keyframes glitterShine {
        0% { background-position: 0% 50%; }
        100% { background-position: 100% 50%; }
    }
    .doctor-icon {
        font-size: 4.5rem;
        color: var(--primary-color);
        margin-bottom: 30px;
        transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55), color 0.3s ease;
        text-shadow: 3px 3px 12px rgba(0, 119, 182, 0.4);
        animation: iconPulse 2s infinite alternate;
    }
    @keyframes iconPulse {
        0% { transform: scale(1); }
        100% { transform: scale(1.03); }
    }
    .doctor-card:hover .doctor-icon {
        transform: rotateY(360deg) scale(1.2);
        color: var(--accent-color);
    }
    .doctor-name-id {
        font-size: 2.5rem; /* Increased font size */
        font-weight: 900;
        color: var(--text-heading-soft);
        margin-bottom: 5px; /* Reduced margin to bring ID closer */
        line-height: 1.2;
        text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.1);
        word-wrap: break-word;
        position: relative;
        padding-bottom: 5px;
        animation: nameShine 3s infinite alternate;
    }
    @keyframes nameShine {
        0% { text-shadow: 0 0 5px rgba(0,0,0,0.1); }
        50% { text-shadow: 0 0 15px rgba(0,0,0,0.3), 0 0 20px rgba(255,255,255,0.5); }
        100% { text-shadow: 0 0 5px rgba(0,0,0,0.1); }
    }
    .doctor-name-id::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        height: 3px;
        background: linear-gradient(to right, transparent, var(--accent-color), transparent);
        opacity: 0.7;
        border-radius: 2px;
    }
    .doctor-id-display {
        font-size: 1.2rem; /* Separate styling for ID */
        color: var(--text-id-color);
        font-weight: 800;
        margin-top: 5px; /* Margin to place on next line */
        margin-bottom: 15px;
        display: block; /* Ensures it's on a new line */
        padding: 5px 10px;
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: var(--border-radius-sm);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        width: fit-content;
        margin-left: auto;
        margin-right: auto;
        animation: idGlow 2s infinite alternate;
    }
    @keyframes idGlow {
        0% { box-shadow: 0 0 5px rgba(192,57,43,0.3); }
        100% { box-shadow: 0 0 15px rgba(192,57,43,0.7); }
    }
    .doctor-specialization {
        font-size: 1.45rem;
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 10px;
        text-transform: capitalize;
    }
    .doctor-specialization::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 70px;
        height: 5px;
        background: linear-gradient(to right, var(--primary-color), var(--accent-color));
        border-radius: 2.5px;
        transition: width var(--transition-speed-normal) ease-out;
    }
    .doctor-card:hover .doctor-specialization::after {
        width: 100%;
    }
    .doctor-details {
        margin-top: 15px;
        line-height: 1.6;
    }
    .doctor-details p {
        margin-bottom: 10px;
        font-size: 1.1rem;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 8px;
        padding-left: 5px;
    }
    .doctor-details p strong {
        color: var(--primary-color);
        font-weight: 600;
        min-width: 100px;
        text-align: left;
    }
    .doctor-details p i {
        color: var(--accent-color);
        font-size: 1.1em;
    }
    .doctor-status {
        font-weight: 700;
        padding: 7px 15px;
        border-radius: 25px;
        display: inline-block;
        margin-top: 15px;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        transition: all var(--transition-speed-fast) ease;
        border: 1px solid transparent;
    }
    .status-active {
        background-color: var(--text-status-active);
        color: white;
        border-color: #218838; /* Darker green */
    }
    .status-inactive {
        background-color: var(--text-status-inactive);
        color: white;
        border-color: #c82333; /* Darker red */
    }
    .status-onleave {
        background-color: var(--text-status-onleave);
        color: var(--text-dark);
        border-color: #e0a800; /* Darker yellow */
    }
    .doctor-status:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .doctor-social-links {
        margin-top: 35px;
        padding-top: 25px;
        border-top: 1px solid var(--border-color-light);
        display: flex;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
    }
    .doctor-social-links a {
        color: var(--secondary-color);
        font-size: 2.2rem;
        transition: color 0.3s ease, transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none;
        display: inline-block;
        filter: drop-shadow(1px 1px 2px rgba(0, 0, 0, 0.1));
    }
    .doctor-social-links a:hover {
        color: var(--accent-color);
        transform: translateY(-10px) scale(1.3);
        filter: drop-shadow(2px 2px 5px rgba(0, 0, 0, 0.2));
    }
    .view-profile-btn {
        margin-top: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: var(--accent-color);
        color: white;
        padding: 16px 40px;
        border-radius: 50px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all var(--transition-speed-normal) cubic-bezier(0.68, -0.55, 0.265, 1.55);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        text-decoration: none;
        border: none;
        cursor: pointer;
        outline: none;
        position: relative;
        overflow: hidden;
    }
    .view-profile-btn .fas {
        margin-right: 10px;
        transition: transform var(--transition-speed-normal) ease;
    }
    .view-profile-btn:hover {
        background-color: #e67e22;
        transform: translateY(-8px) scale(1.03);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
        filter: brightness(1.1);
    }
    .view-profile-btn:hover .fas {
        transform: translateX(5px) rotate(10deg);
    }
    .owl-carousel .owl-item {
        padding: 25px;
    }
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
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.6rem !important;
        transition: all var(--transition-speed-normal) cubic-bezier(0.68, -0.55, 0.265, 1.55);
        box-shadow: 0 10px 25px var(--shadow-medium);
        pointer-events: all;
        border: 2px solid rgba(255, 255, 255, 0.5) !important;
        margin: 0 30px;
        outline: none;
    }
    .owl-nav button.owl-prev:hover,
    .owl-nav button.owl-next:hover {
        background-color: var(--secondary-color) !important;
        transform: scale(1.25);
        box-shadow: 0 15px 35px var(--shadow-strong);
        border-color: var(--accent-color) !important;
    }
    .owl-dots {
        text-align: center;
        margin-top: 70px;
        z-index: 5;
    }
    .owl-dots .owl-dot {
        width: 20px;
        height: 20px;
        background: #d0d5db;
        border-radius: var(--border-radius-full);
        display: inline-block;
        margin: 0 15px;
        transition: all var(--transition-speed-normal) ease;
        border: 3px solid transparent;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .owl-dots .owl-dot.active {
        background: var(--primary-color);
        transform: scale(1.5);
        border-color: var(--accent-color);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }
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
        .doctor-card {
            padding: 35px;
        }
        .doctor-icon {
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
        .doctor-card {
            padding: 30px;
        }
        .doctor-icon {
            font-size: 3.8rem;
            margin-bottom: 25px;
        }
        .doctor-name-id {
            font-size: 2rem;
        }
        .doctor-specialization {
            font-size: 1.3rem;
            margin-bottom: 20px;
        }
        .doctor-details p {
            font-size: 1rem;
        }
        .view-profile-btn {
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
        .doctor-card {
            padding: 28px;
        }
        .doctor-icon {
            font-size: 3.2rem;
            margin-bottom: 20px;
        }
        .doctor-name-id {
            font-size: 1.8rem;
        }
        .doctor-specialization {
            font-size: 1.2rem;
            margin-bottom: 18px;
        }
        .doctor-specialization::after {
            width: 60px;
            height: 4px;
        }
        .doctor-details p {
            font-size: 0.95rem;
            margin-bottom: 8px;
        }
        .doctor-social-links {
            margin-top: 30px;
            padding-top: 20px;
            gap: 25px;
        }
        .doctor-social-links a {
            font-size: 2rem;
        }
        .view-profile-btn {
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
        .doctor-card {
            padding: 25px;
        }
        .doctor-icon {
            font-size: 2.8rem;
            margin-bottom: 18px;
        }
        .doctor-name-id {
            font-size: 1.6rem;
        }
        .doctor-name-id strong {
            font-size: 0.8em;
            margin-left: 8px;
        }
        .doctor-specialization {
            font-size: 1.1rem;
            margin-bottom: 15px;
        }
        .doctor-specialization::after {
            width: 50px;
            height: 3px;
        }
        .doctor-details p {
            font-size: 0.9rem;
            margin-bottom: 7px;
            gap: 6px;
        }
        .doctor-details p strong {
            min-width: 80px;
        }
        .doctor-social-links {
            margin-top: 25px;
            padding-top: 15px;
            gap: 20px;
        }
        .doctor-social-links a {
            font-size: 1.8rem;
        }
        .view-profile-btn {
            padding: 10px 25px;
            font-size: 0.85rem;
            margin-top: 20px;
        }
        .view-profile-btn .fas {
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
        .doctor-card {
            padding: 20px;
            margin: 0;
        }
        .doctor-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        .doctor-name-id {
            font-size: 1.4rem;
            margin-bottom: 10px;
        }
        .doctor-name-id strong {
            font-size: 0.7em;
            margin-left: 6px;
            padding: 1px 4px;
        }
        .doctor-specialization {
            font-size: 1rem;
            margin-bottom: 12px;
        }
        .doctor-specialization::after {
            width: 40px;
            height: 2px;
        }
        .doctor-details p {
            font-size: 0.8rem;
            margin-bottom: 5px;
            gap: 5px;
        }
        .doctor-details p strong {
            min-width: 70px;
        }
        .doctor-social-links {
            margin-top: 20px;
            padding-top: 10px;
            gap: 15px;
        }
        .doctor-social-links a {
            font-size: 1.6rem;
        }
        .view-profile-btn {
            padding: 8px 20px;
            font-size: 0.75rem;
            margin-top: 15px;
        }
        .view-profile-btn .fas {
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
        <h1 class="main-heading">Meet Our Expert Doctors 🩺</h1>
        <p class="professional-message">
            Discover our dedicated team of healthcare professionals, each specializing in various fields to provide you with the best possible care.
            Browse through their comprehensive profiles to find the right specialist perfectly suited for your unique health needs.
            Our commitment is to connect you with compassionate and highly skilled medical experts.
        </p>
    </div>
    <div class="owl-carousel doctor-carousel">
        <?php
        if ($doctors && mysqli_num_rows($doctors) > 0) :
            $icon_classes = [
                'fas fa-user-md',
                'fas fa-brain',
                'fas fa-heartbeat',
                'fas fa-lungs',
                'fas fa-bone',
                'fas fa-tooth',
                'fas fa-eye',
                'fas fa-child',
                'fas fa-female',
                'fas fa-allergies',
                'fas fa-stethoscope',
                'fas fa-clinic-medical',
                'fas fa-microscope',
                'fas fa-x-ray',
                'fas fa-hand-holding-medical',
                'fas fa-diagnoses',
                'fas fa-syringe',
                'fas fa-pills',
                'fas fa-dna',
                'fas fa-hospital-user',
                'fas fa-ear-listen',
                'fas fa-head-side-virus',
                'fas fa-crutch',
                'fas fa-notes-medical',
                'fas fa-bacteria',
                'fas fa-radiation',
                'fas fa-vial',
                'fas fa-capsules',
                'fas fa-file-medical',
                'fas fa-hospital-alt',
                'fas fa-medkit',
                'fas fa-prescription-bottle-alt',
                'fas fa-thermometer-half',
                'fas fa-band-aid',
                'fas fa-briefcase-medical',
                'fas fa-comment-medical',
                'fas fa-file-prescription',
                'fas fa-hospital-symbol',
                'fas fa-joint',
                'fas fa-kit-medical',
                'fas fa-laptop-medical',
                'fas fa-microbe',
                'fas fa-monitor-heart-rate',
                'fas fa-notes-medical',
                'fas fa-pager',
                'fas fa-pills',
                'fas fa-prescription',
                'fas fa-radiation-alt',
                'fas fa-skull-crossbones',
                'fas fa-tooth',
                'fas fa-user-nurse',
                'fas fa-virus',
                'fas fa-virus-slash',
                'fas fa-weight-scale',
                'fas fa-xmarks-lines',
                'fas fa-biohazard',
                'fas fa-brain',
                'fas fa-cannabis',
                'fas fa-capsules',
                'fas fa-clipboard-user',
                'fas fa-comment-dots',
                'fas fa-diagnoses',
                'fas fa-dna',
                'fas fa-ear-listen',
                'fas fa-eye-dropper',
                'fas fa-face-mask',
                'fas fa-file-waveform',
                'fas fa-hand-holding-droplet',
                'fas fa-head-side-cough',
                'fas fa-heart-circle-bolt',
                'fas fa-hospital-user',
                'fas fa-house-medical',
                'fas fa-id-card-clip',
                'fas fa-lungs-virus',
                'fas fa-mask-face',
                'fas fa-microscope',
                'fas fa-notes-medical',
                'fas fa-pills',
                'fas fa-prescription-bottle',
                'fas fa-pump-medical',
                'fas fa-radiation',
                'fas fa-republican',
                'fas fa-skull',
                'fas fa-syringe',
                'fas fa-tooth',
                'fas fa-user-doctor',
                'fas fa-user-injured',
                'fas fa-user-nurse',
                'fas fa-virus',
                'fas fa-virus-slash',
                'fas fa-weight-hanging',
                'fas fa-x-ray',
                'fas fa-brain',
                'fas fa-heart-pulse',
                'fas fa-bone',
                'fas fa-tooth',
                'fas fa-eye',
                'fas fa-child',
                'fas fa-venus-mars',
                'fas fa-allergies',
                'fas fa-stethoscope',
                'fas fa-hospital',
                'fas fa-flask',
                'fas fa-lungs',
                'fas fa-dna',
                'fas fa-microscope',
                'fas fa-x-ray',
                'fas fa-hand-holding-medical',
                'fas fa-diagnoses',
                'fas fa-syringe',
                'fas fa-pills',
                'fas fa-capsules',
                'fas fa-file-medical',
                'fas fa-hospital-alt',
                'fas fa-medkit',
                'fas fa-prescription-bottle-alt',
                'fas fa-thermometer-half',
                'fas fa-band-aid',
                'fas fa-briefcase-medical',
                'fas fa-comment-medical',
                'fas fa-file-prescription',
                'fas fa-hospital-symbol',
                'fas fa-joint',
                'fas fa-kit-medical',
                'fas fa-laptop-medical',
                'fas fa-microbe',
                'fas fa-monitor-heart-rate',
                'fas fa-notes-medical',
                'fas fa-pager',
                'fas fa-pills',
                'fas fa-prescription',
                'fas fa-radiation-alt',
                'fas fa-skull-crossbones',
                'fas fa-tooth',
                'fas fa-user-nurse',
                'fas fa-virus',
                'fas fa-virus-slash',
                'fas fa-weight-scale',
                'fas fa-xmarks-lines',
                'fas fa-biohazard',
                'fas fa-brain',
                'fas fa-cannabis',
                'fas fa-capsules',
                'fas fa-clipboard-user',
                'fas fa-comment-dots',
                'fas fa-diagnoses',
                'fas fa-dna',
                'fas fa-ear-listen',
                'fas fa-eye-dropper',
                'fas fa-face-mask',
                'fas fa-file-waveform',
                'fas fa-hand-holding-droplet',
                'fas fa-head-side-cough',
                'fas fa-heart-circle-bolt',
                'fas fa-hospital-user',
                'fas fa-house-medical',
                'fas fa-id-card-clip',
                'fas fa-lungs-virus',
                'fas fa-mask-face',
                'fas fa-microscope',
                'fas fa-notes-medical',
                'fas fa-pills',
                'fas fa-prescription-bottle',
                'fas fa-pump-medical',
                'fas fa-radiation',
                'fas fa-republican',
                'fas fa-skull',
                'fas fa-syringe',
                'fas fa-tooth',
                'fas fa-user-doctor',
                'fas fa-user-injured',
                'fas fa-user-nurse',
                'fas fa-virus',
                'fas fa-virus-slash',
                'fas fa-weight-hanging',
                'fas fa-x-ray',
                'fas fa-brain',
                'fas fa-heart-pulse',
                'fas fa-bone',
                'fas fa-tooth',
                'fas fa-eye',
                'fas fa-child',
                'fas fa-venus-mars',
                'fas fa-allergies',
                'fas fa-stethoscope',
                'fas fa-hospital',
                'fas fa-flask',
                'fas fa-lungs',
                'fas fa-dna',
                'fas fa-microscope',
                'fas fa-x-ray',
                'fas fa-hand-holding-medical',
                'fas fa-diagnoses',
                'fas fa-syringe',
                'fas fa-pills',
                'fas fa-capsules',
                'fas fa-file-medical',
                'fas fa-hospital-alt',
                'fas fa-medkit',
                'fas fa-prescription-bottle-alt',
                'fas fa-thermometer-half',
                'fas fa-band-aid',
                'fas fa-briefcase-medical',
                'fas fa-comment-medical',
                'fas fa-file-prescription',
                'fas fa-hospital-symbol',
                'fas fa-joint',
                'fas fa-kit-medical',
                'fas fa-laptop-medical',
                'fas fa-microbe',
                'fas fa-monitor-heart-rate',
                'fas fa-notes-medical',
                'fas fa-pager',
                'fas fa-pills',
                'fas fa-prescription',
                'fas fa-radiation-alt',
                'fas fa-skull-crossbones',
                'fas fa-tooth',
                'fas fa-user-nurse',
                'fas fa-virus',
                'fas fa-virus-slash',
                'fas fa-weight-scale',
                'fas fa-xmarks-lines',
                'fas fa-biohazard',
                'fas fa-brain',
                'fas fa-cannabis',
                'fas fa-capsules',
                'fas fa-clipboard-user',
                'fas fa-comment-dots',
                'fas fa-diagnoses',
                'fas fa-dna',
                'fas fa-ear-listen',
                'fas fa-eye-dropper',
                'fas fa-face-mask',
                'fas fa-file-waveform',
                'fas fa-hand-holding-droplet',
                'fas fa-head-side-cough',
                'fas fa-heart-circle-bolt',
                'fas fa-hospital-user',
                'fas fa-house-medical',
                'fas fa-id-card-clip',
                'fas fa-lungs-virus',
                'fas fa-mask-face',
                'fas fa-microscope',
                'fas fa-notes-medical',
                'fas fa-pills',
                'fas fa-prescription-bottle',
                'fas fa-pump-medical',
                'fas fa-radiation',
                'fas fa-republican',
                'fas fa-skull',
                'fas fa-syringe',
                'fas fa-tooth',
                'fas fa-user-doctor',
                'fas fa-user-injured',
                'fas fa-user-nurse',
                'fas fa-virus',
                'fas fa-virus-slash',
                'fas fa-weight-hanging',
                'fas fa-x-ray'
            ];
            $icon_index = 0;
            while ($row = mysqli_fetch_assoc($doctors)) :
                $doctor_id = htmlspecialchars($row['id']);
                $user_id = htmlspecialchars($row['user_id']);
                $doctor_name = htmlspecialchars($row['doctor_name']);
                $specialization = htmlspecialchars($row['specialization']);
                $experience = htmlspecialchars($row['experience']);
                $availability = htmlspecialchars($row['availability']);
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
                    case 'on leave':
                        $status_class = 'status-onleave';
                        break;
                    default:
                        $status_class = 'status-inactive';
                }
                $current_icon = $icon_classes[$icon_index % count($icon_classes)];
                $icon_index++;
        ?>
                <div class="doctor-card text-center">
                    <i class="doctor-icon <?= $current_icon ?>"></i>
                    <h5 class="doctor-name-id">
                        <?= $doctor_name ?>
                    </h5>
                    <span class="doctor-id-display">ID: <?= $doctor_id ?></span>
                    <p class="doctor-specialization"><?= $specialization ?></p>
                    <div class="doctor-details">
                        <p><i class="fas fa-briefcase"></i> <strong>Experience:</strong> <?= $experience ?> years</p>
                        <p><i class="fas fa-calendar-alt"></i> <strong>Availability:</strong> <?= $availability ?></p>
                        <p><i class="fas fa-user-tag"></i> <strong>User ID:</strong> <?= $user_id ?></p>
                        <p><i class="fas fa-sign-in-alt"></i> <strong>Joined:</strong> <?= date('d M, Y', strtotime($created_at)) ?></p>
                        <p><i class="fas fa-circle-info"></i> <strong>Status:</strong> <span class="doctor-status <?= $status_class ?>"><?= ucfirst($status) ?></span></p>
                    </div>
                    <div class="doctor-social-links">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://yourwebsite.com/doctorProfile.php?id=' . $doctor_id); ?>" target="_blank" aria-label="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('http://yourwebsite.com/doctorProfile.php?id=' . $doctor_id); ?>&text=Check%20out%20Dr.%20<?= urlencode($doctor_name) ?>%20on%20Meditronix!" target="_blank" aria-label="Share on Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode('http://yourwebsite.com/doctorProfile.php?id=' . $doctor_id); ?>&title=Meet%20Dr.%20<?= urlencode($doctor_name) ?>&summary=Specialized%20in%20<?= urlencode($specialization) ?>%20at%20Meditronix" target="_blank" aria-label="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://wa.me/?text=Check%20out%20Dr.%20<?= urlencode($doctor_name) ?>'s%20profile%20at%20Meditronix:%20<?php echo urlencode('http://yourwebsite.com/doctorProfile.php?id=' . $doctor_id); ?>" target="_blank" aria-label="Share on WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                    <div class="text-center mt-4">
                        <a href="doctorProfile.php?id=<?= $doctor_id ?>" class="view-profile-btn">
                            <i class="fas fa-eye me-2"></i> View Profile
                        </a>
                    </div>
                </div>
            <?php
            endwhile;
        else :
        ?>
            <div class="col-12 text-center py-5">
                <p class="professional-message">No doctors found in the directory. Please check back later!</p>
                <?php if (isset($error_message)) : ?>
                    <p class="text-danger">Error: <?= $error_message ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        const doctorCarousel = $('.doctor-carousel');
        doctorCarousel.owlCarousel({
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
            $('.doctor-carousel .owl-item .doctor-card').css('height', 'auto');
            $('.doctor-carousel .owl-item.active').each(function() {
                let currentHeight = $(this).find('.doctor-card').outerHeight();
                if (currentHeight > maxHeight) {
                    maxHeight = currentHeight;
                }
            });
            $('.doctor-carousel .owl-item .doctor-card').css('height', maxHeight + 'px');
        }
        setEqualCardHeight();
        $(window).on('resize', setEqualCardHeight);
        doctorCarousel.on('initialized.owl.carousel resized.owl.carousel changed.owl.carousel', function(event) {
            setTimeout(setEqualCardHeight, 100);
        });
        $(document).on('click', '.doctor-card', function() {
            $('.doctor-card').removeClass('active');
            $(this).addClass('active');
            const doctorName = $(this).find('.doctor-name-id').text().trim().split(' ')[0];
            const doctorId = $(this).find('.doctor-id-display').text().trim();
            alert(`You clicked on ${doctorName} (${doctorId})!`);
            setTimeout(() => {
                $(this).removeClass('active');
            }, 1000);
        });
    });
</script>
<?php
mysqli_close($db);
include("patientFooter.php");
?>
