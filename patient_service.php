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
$services = mysqli_query($db, "SELECT `id`, `doctor's_name`, `name`, `description`, `fee`, `status`, `created_at` FROM `services` ORDER BY name ASC");
if (!$services) {
    $error_message = "Error fetching services data: " . mysqli_error($db);
    $services = false;
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
        --card-shine-gradient: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.8) 50%, rgba(255,255,255,0) 100%);
        --text-dark: #343a40;
        --text-light: #6c757d;
        --text-heading-soft: rgba(2, 62, 138, 0.85);
        --text-id-color: #c0392b;
        --text-status-active: #28a745;
        --text-status-inactive: #dc3545;
        --text-status-onleave: #ffc107;
        --border-color-light: #f0f0f0;
        --border-color-medium: rgba(255, 255, 255, 0.7);
        --shadow-light: rgba(0, 0, 0, 0.12);
        --shadow-medium: rgba(0, 0, 0, 0.25);
        --shadow-strong: rgba(0, 0, 0, 0.4);
        --shadow-inset: inset 0 0 20px rgba(0, 0, 0, 0.1);
        --transition-speed-fast: 0.2s;
        --transition-speed-normal: 0.4s;
        --transition-speed-slow: 0.6s;
        --border-radius-sm: 8px;
        --border-radius-md: 15px;
        --border-radius-lg: 25px;
        --border-radius-full: 50%;
        --rainbow-gradient-full: linear-gradient(45deg, #FF0000, #FF7F00, #FFFF00, #00FF00, #0000FF, #4B0082, #9400D3);
        --greyish-blue: #a7c5d9;
        --ruby-diamond-effect: radial-gradient(circle at center, rgba(248,224,224,0.5) 0%, rgba(217,184,184,0.3) 50%, rgba(167,197,217,0.1) 100%);
    }
    html {
        scroll-behavior: smooth;
    }
    body {
        font-family: 'Poppins', sans-serif;
        background: var(--rainbow-gradient-full);
        background-size: 600% 600%;
        animation: rainbowBackground 40s ease infinite;
        color: var(--text-dark);
        line-height: 1.7;
        overflow-x: hidden;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        position: relative;
        padding: 0;
        margin: 0;
        perspective: 1200px;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
    }
    @keyframes rainbowBackground {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--ruby-diamond-effect);
        pointer-events: none;
        z-index: -1;
        animation: subtleShine 15s infinite alternate ease-in-out;
    }
    @keyframes subtleShine {
        0% { opacity: 0.8; transform: scale(1); }
        100% { opacity: 1; transform: scale(1.02); }
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
        background-size: 70px 70px;
        animation: waterfall 120s linear infinite;
        z-index: -2;
        opacity: 0.1;
        pointer-events: none;
    }
    @keyframes waterfall {
        from { background-position: 0 0; }
        to { background-position: 140px 140px; }
    }
    .container-xxl {
        padding: 7rem 4rem;
        flex-grow: 1;
        background-color: rgba(255, 255, 255, 0.99);
        border-radius: var(--border-radius-lg);
        box-shadow: 0 20px 60px var(--shadow-strong), 0 0 0 5px rgba(255,255,255,0.5);
        margin: 100px auto;
        max-width: 1600px;
        min-width: 320px;
        position: relative;
        overflow: hidden;
        border: 3px solid rgba(255, 255, 255, 0.9);
        transform-style: preserve-3d;
        perspective: 1000px;
        animation: containerEntrance 1.8s ease-out forwards;
        background-image: url('https://cdn.pixabay.com/photo/2014/11/27/18/37/doctor-on-call-548023_1280.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        transition: all 0.8s ease-in-out;
    }
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
    .section-header {
        text-align: center;
        margin-bottom: 80px;
        position: relative;
        z-index: 2;
        padding: 20px;
        background: rgba(255,255,255,0.1);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-medium);
        backdrop-filter: blur(10px);
    }
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
        text-shadow: 0 0 25px rgba(0, 119, 182, 0.8), 0 0 45px rgba(0, 119, 182, 0.6), 0 0 60px rgba(0, 119, 182, 0.4);
        -webkit-text-stroke: 2px var(--primary-color);
        color: transparent;
        background-image: linear-gradient(45deg, var(--secondary-color), var(--primary-color), var(--accent-color));
        -webkit-background-clip: text;
        background-clip: text;
        background-size: 200% auto;
        animation: flyIn 2s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards, textGradientShine 6s linear infinite;
        will-change: transform, opacity, filter;
    }
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
        animation: headingUnderlineGrow 2s ease-out forwards;
    }
    @keyframes headingUnderlineGrow {
        0% { width: 0; opacity: 0; }
        100% { width: 180px; opacity: 1; }
    }
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
    @keyframes textGradientShine {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
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
    .professional-message:hover::before {
        transform: skewX(-20deg) translateX(200%);
    }
    .professional-message:hover {
        transform: translateY(-8px) scale(1.01);
        box-shadow: 0 15px 40px var(--shadow-medium);
        border-left-color: var(--accent-color);
    }
    .service-card {
        background: var(--card-multi-gradient);
        border: 3px solid var(--border-color-medium);
        box-shadow: 0 15px 50px var(--shadow-light), var(--shadow-inset);
        border-radius: var(--border-radius-lg);
        padding: 45px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        z-index: 1;
        backdrop-filter: blur(8px) brightness(1.1);
        transform-style: preserve-3d;
        transform: translateZ(0);
        animation: cardFloat 6s infinite alternate ease-in-out, cardShinePulse 4s infinite ease-in-out;
        will-change: transform, box-shadow, border-color;
    }
    @keyframes cardFloat {
        0% { transform: translateY(0px) rotateX(0deg) rotateY(0deg); }
        50% { transform: translateY(-8px) rotateX(0.8deg) rotateY(-0.8deg); }
        100% { transform: translateY(0px) rotateX(0deg) rotateY(0deg); }
    }
    @keyframes cardShinePulse {
        0% { box-shadow: 0 15px 50px var(--shadow-light), var(--shadow-inset); }
        50% { box-shadow: 0 15px 50px rgba(0,0,0,0.2), inset 0 0 30px rgba(255,255,255,0.3); }
        100% { box-shadow: 0 15px 50px var(--shadow-light), var(--shadow-inset); }
    }
    .service-card::before {
        content: '';
        position: absolute;
        top: -8px;
        left: -8px;
        right: -8px;
        bottom: -8px;
        background: linear-gradient(45deg, #FF007F, #00C6FF, #FF007F, #00C6FF, #FF007F, #00C6FF, #FF007F);
        background-size: 800% 800%;
        z-index: -1;
        filter: blur(15px) brightness(1.5);
        opacity: 0;
        transition: opacity 0.6s ease-in-out;
        border-radius: var(--border-radius-lg);
        animation: glitterShine 4s linear infinite;
        animation-play-state: paused;
        will-change: opacity, background-position;
    }
    .service-card::after {
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
    .service-card:hover::before,
    .service-card.active::before {
        opacity: 1;
        animation-play-state: running;
    }
    .service-card:hover::after,
    .service-card.active::after {
        opacity: 1;
        transform: skewX(-25deg) translateX(300%);
        transition: transform 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    .service-card:not(:hover)::after {
        transform: skewX(-25deg) translateX(-200%);
        transition: transform 0.01s linear 1.5s;
        opacity: 0;
    }
    .service-card:hover {
        transform: translateY(-20px) scale(1.06) rotateX(3deg) rotateY(3deg);
        box-shadow: 0 30px 70px var(--shadow-medium), inset 0 0 40px rgba(255,255,255,0.4);
        border-color: var(--accent-color);
    }
    @keyframes glitterShine {
        0% { background-position: 0% 50%; }
        100% { background-position: 100% 50%; }
    }
    .service-icon {
        font-size: 5rem;
        color: var(--primary-color);
        margin-bottom: 35px;
        transition: transform 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55), color 0.4s ease, filter 0.4s ease;
        text-shadow: 4px 4px 15px rgba(0, 119, 182, 0.5);
        animation: iconPulse 2.5s infinite alternate, iconGlow 3s infinite alternate;
        will-change: transform, color, filter;
    }
    @keyframes iconPulse {
        0% { transform: scale(1); }
        100% { transform: scale(1.05); }
    }
    @keyframes iconGlow {
        0% { filter: drop-shadow(0 0 5px var(--primary-color)); }
        100% { filter: drop-shadow(0 0 15px var(--primary-color)) drop-shadow(0 0 25px rgba(0,119,182,0.5)); }
    }
    .service-card:hover .service-icon {
        transform: rotateY(360deg) scale(1.25) rotateZ(5deg);
        color: var(--accent-color);
        filter: drop-shadow(0 0 20px var(--accent-color));
    }
    .service-name {
        font-family: 'Rubik', sans-serif;
        font-size: 3rem;
        font-weight: 900;
        color: var(--text-heading-soft);
        margin-bottom: 5px;
        line-height: 1.1;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.15), 0 0 15px rgba(255,255,255,0.6);
        word-wrap: break-word;
        position: relative;
        padding-bottom: 8px;
        animation: nameShine 4s infinite alternate, nameWave 5s infinite ease-in-out;
        background: linear-gradient(90deg, var(--secondary-color), var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        background-size: 200% auto;
        will-change: background-position, text-shadow;
    }
    @keyframes nameShine {
        0% { background-position: 0% 50%; }
        100% { background-position: 100% 50%; }
    }
    @keyframes nameWave {
        0% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
        100% { transform: translateY(0); }
    }
    .service-name::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        height: 4px;
        background: linear-gradient(to right, transparent, var(--accent-color), transparent);
        opacity: 0.8;
        border-radius: 2px;
        animation: underlinePulse 2s infinite alternate;
    }
    @keyframes underlinePulse {
        0% { transform: translateX(-50%) scaleX(1); opacity: 0.8; }
        100% { transform: translateX(-50%) scaleX(1.05); opacity: 1; }
    }
    .service-id-display {
        font-size: 1.35rem;
        color: var(--text-id-color);
        font-weight: 900;
        margin-top: 8px;
        margin-bottom: 20px;
        display: block;
        padding: 8px 15px;
        background-color: rgba(255, 255, 255, 0.85);
        border-radius: var(--border-radius-md);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15), inset 0 0 10px rgba(255,255,255,0.5);
        width: fit-content;
        margin-left: auto;
        margin-right: auto;
        animation: idGlow 2.5s infinite alternate;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border: 1px solid rgba(192,57,43,0.3);
        will-change: box-shadow;
    }
    @keyframes idGlow {
        0% { box-shadow: 0 0 8px rgba(192,57,43,0.4), inset 0 0 5px rgba(255,255,255,0.2); }
        100% { box-shadow: 0 0 20px rgba(192,57,43,0.8), inset 0 0 10px rgba(255,255,255,0.5); }
    }
    .service-doctor-name {
        font-size: 1.6rem;
        color: var(--primary-color);
        font-weight: 800;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 12px;
        text-transform: capitalize;
        text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.08);
    }
    .service-doctor-name::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        height: 4px;
        background: linear-gradient(to right, transparent, var(--primary-color), transparent);
        opacity: 0.8;
        border-radius: 2px;
    }
    .service-card:hover .service-doctor-name::after {
        width: 100%;
    }
    .service-details {
        margin-top: 20px;
        line-height: 1.7;
        padding: 10px;
        background: rgba(255,255,255,0.3);
        border-radius: var(--border-radius-md);
        box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
        border: 1px solid rgba(255,255,255,0.5);
    }
    .service-details p {
        margin-bottom: 12px;
        font-size: 1.15rem;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 0;
        border-bottom: 1px dashed rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .service-details p:last-child {
        margin-bottom: 0;
        border-bottom: none;
    }
    .service-details p:hover {
        background-color: rgba(255,255,255,0.5);
        transform: translateX(5px);
        border-radius: var(--border-radius-sm);
    }
    .service-details p strong {
        color: var(--primary-color);
        font-weight: 700;
        min-width: 110px;
        text-align: left;
        text-shadow: 0 0 3px rgba(0,0,0,0.05);
    }
    .service-details p i {
        color: var(--accent-color);
        font-size: 1.2em;
        filter: drop-shadow(0 0 5px rgba(255,140,0,0.3));
    }
    .service-status {
        font-weight: 800;
        padding: 9px 18px;
        border-radius: 30px;
        display: inline-block;
        margin-top: 18px;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        border: 2px solid transparent;
        cursor: default;
    }
    .status-active {
        background-color: var(--text-status-active);
        color: white;
        border-color: #218838;
        animation: statusGlowGreen 2s infinite alternate;
    }
    @keyframes statusGlowGreen {
        0% { box-shadow: 0 0 5px rgba(40,167,69,0.5); }
        100% { box-shadow: 0 0 15px rgba(40,167,69,0.8); }
    }
    .status-inactive {
        background-color: var(--text-status-inactive);
        color: white;
        border-color: #c82333;
        animation: statusGlowRed 2s infinite alternate;
    }
    @keyframes statusGlowRed {
        0% { box-shadow: 0 0 5px rgba(220,53,69,0.5); }
        100% { box-shadow: 0 0 15px rgba(220,53,69,0.8); }
    }
    .status-onleave {
        background-color: var(--text-status-onleave);
        color: var(--text-dark);
        border-color: #e0a800;
        animation: statusGlowYellow 2s infinite alternate;
    }
    @keyframes statusGlowYellow {
        0% { box-shadow: 0 0 5px rgba(255,193,7,0.5); }
        100% { box-shadow: 0 0 15px rgba(255,193,7,0.8); }
    }
    .service-status:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }
    .service-social-links {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 2px solid rgba(255,255,255,0.7);
        display: flex;
        justify-content: center;
        gap: 35px;
        flex-wrap: wrap;
        position: relative;
    }
    .service-social-links::before {
        content: '';
        position: absolute;
        top: -1px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 2px;
        background: linear-gradient(to right, transparent, var(--primary-color), transparent);
        opacity: 0.7;
    }
    .service-social-links a {
        color: var(--secondary-color);
        font-size: 2.5rem;
        transition: color 0.4s ease, transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), filter 0.4s ease;
        text-decoration: none;
        display: inline-block;
        filter: drop-shadow(1px 1px 3px rgba(0, 0, 0, 0.2));
        position: relative;
    }
    .service-social-links a::after {
        content: attr(aria-label);
        position: absolute;
        bottom: -30px;
        left: 50%;
        transform: translateX(-50%);
        background-color: var(--accent-color);
        color: white;
        padding: 5px 10px;
        border-radius: var(--border-radius-sm);
        font-size: 0.8rem;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, bottom 0.3s ease;
    }
    .service-social-links a:hover::after {
        opacity: 1;
        visibility: visible;
        bottom: -40px;
    }
    .service-social-links a:hover {
        color: var(--accent-color);
        transform: translateY(-12px) scale(1.35);
        filter: drop-shadow(3px 3px 8px rgba(0, 0, 0, 0.3));
    }
    .action-btn-group {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 40px;
    }
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 18px 45px;
        border-radius: 50px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35);
        text-decoration: none;
        border: none;
        cursor: pointer;
        outline: none;
        position: relative;
        overflow: hidden;
        z-index: 1;
        transform: translateZ(0);
    }
    .action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.2);
        transform: skewX(-20deg);
        transition: transform 0.5s ease-out;
        z-index: -1;
    }
    .action-btn:hover::before {
        transform: skewX(-20deg) translateX(200%);
    }
    .action-btn .fas {
        margin-right: 12px;
        transition: transform 0.4s ease;
    }
    .action-btn:hover {
        transform: translateY(-10px) scale(1.04);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
        filter: brightness(1.15);
    }
    .action-btn:hover .fas {
        transform: translateX(8px) rotate(15deg);
    }
    .view-btn {
        background-color: var(--primary-color);
        color: white;
    }
    .view-btn:hover {
        background-color: var(--secondary-color);
    }
    .book-btn {
        background-color: var(--accent-color);
        color: white;
    }
    .book-btn:hover {
        background-color: #e67e22;
    }
    .btn-booked {
        background-color: #198754 !important;
        color: #fff !important;
        pointer-events: none;
        cursor: default;
        box-shadow: 0 5px 15px rgba(25,135,84,0.5) !important;
        opacity: 0.8;
    }
    .owl-carousel .owl-item {
        padding: 30px;
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
        width: 75px;
        height: 75px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.8rem !important;
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        box-shadow: 0 12px 30px var(--shadow-medium);
        pointer-events: all;
        border: 3px solid rgba(255, 255, 255, 0.6) !important;
        margin: 0 35px;
        outline: none;
        filter: drop-shadow(0 0 10px rgba(0,119,182,0.5));
    }
    .owl-nav button.owl-prev:hover,
    .owl-nav button.owl-next:hover {
        background-color: var(--secondary-color) !important;
        transform: scale(1.3);
        box-shadow: 0 20px 50px var(--shadow-strong);
        border-color: var(--accent-color) !important;
        filter: drop-shadow(0 0 20px var(--accent-color));
    }
    .owl-dots {
        text-align: center;
        margin-top: 80px;
        z-index: 5;
    }
    .owl-dots .owl-dot {
        width: 22px;
        height: 22px;
        background: #d0d5db;
        border-radius: var(--border-radius-full);
        display: inline-block;
        margin: 0 18px;
        transition: all 0.4s ease;
        border: 4px solid transparent;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    }
    .owl-dots .owl-dot.active {
        background: var(--primary-color);
        transform: scale(1.6);
        border-color: var(--accent-color);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        animation: dotPulse 1.5s infinite alternate;
    }
    @keyframes dotPulse {
        0% { transform: scale(1.6); box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); }
        100% { transform: scale(1.7); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4); }
    }
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
    @keyframes popupBorderShine {
        0% { border-image-source: linear-gradient(45deg, #ff007f, #00c6ff); }
        25% { border-image-source: linear-gradient(90deg, #00c6ff, #ff007f); }
        50% { border-image-source: linear-gradient(135deg, #ff007f, #00c6ff); }
        75% { border-image-source: linear-gradient(180deg, #00c6ff, #ff007f); }
        100% { border-image-source: linear-gradient(45deg, #ff007f, #00c6ff); }
    }
    #popup-message center {
        font-size: 2.2rem;
        font-weight: 900;
        margin-top: 15px;
        color: var(--accent-color);
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2), 0 0 10px rgba(255,140,0,0.5);
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    @keyframes popupAppear {
        0% { opacity: 0; transform: translate(-50%, -60%) scale(0.8); filter: blur(10px); }
        100% { opacity: 1; transform: translate(-50%, -50%) scale(1); filter: blur(0); }
    }
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
        .service-card {
            padding: 35px;
        }
        .service-icon {
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
        .service-card {
            padding: 30px;
        }
        .service-icon {
            font-size: 3.8rem;
            margin-bottom: 25px;
        }
        .service-name {
            font-size: 2rem;
        }
        .service-doctor-name {
            font-size: 1.3rem;
            margin-bottom: 20px;
        }
        .service-details p {
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
        .service-card {
            padding: 28px;
        }
        .service-icon {
            font-size: 3.2rem;
            margin-bottom: 20px;
        }
        .service-name {
            font-size: 1.8rem;
        }
        .service-doctor-name {
            font-size: 1.2rem;
            margin-bottom: 18px;
        }
        .service-details p {
            font-size: 0.95rem;
            margin-bottom: 8px;
        }
        .service-social-links {
            margin-top: 30px;
            padding-top: 20px;
            gap: 25px;
        }
        .service-social-links a {
            font-size: 2rem;
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
        .service-card {
            padding: 25px;
        }
        .service-icon {
            font-size: 2.8rem;
            margin-bottom: 18px;
        }
        .service-name {
            font-size: 1.6rem;
        }
        .service-name::after {
            width: 80%;
        }
        .service-id-display {
            font-size: 1.1rem;
            padding: 4px 8px;
        }
        .service-doctor-name {
            font-size: 1.1rem;
            margin-bottom: 15px;
        }
        .service-doctor-name::after {
            width: 50px;
            height: 3px;
        }
        .service-details p {
            font-size: 0.9rem;
            margin-bottom: 7px;
            gap: 6px;
        }
        .service-details p strong {
            min-width: 80px;
        }
        .service-social-links {
            margin-top: 25px;
            padding-top: 15px;
            gap: 20px;
        }
        .service-social-links a {
            font-size: 1.8rem;
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
        .service-card {
            padding: 20px;
            margin: 0;
        }
        .service-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        .service-name {
            font-size: 1.4rem;
            margin-bottom: 10px;
        }
        .service-name::after {
            width: 70%;
        }
        .service-id-display {
            font-size: 1rem;
            padding: 3px 6px;
            margin-top: 3px;
            margin-bottom: 10px;
        }
        .service-doctor-name {
            font-size: 1rem;
            margin-bottom: 12px;
        }
        .service-doctor-name::after {
            width: 40px;
            height: 2px;
        }
        .service-details p {
            font-size: 0.8rem;
            margin-bottom: 5px;
            gap: 5px;
        }
        .service-details p strong {
            min-width: 70px;
        }
        .service-social-links {
            margin-top: 20px;
            padding-top: 10px;
            gap: 15px;
        }
        .service-social-links a {
            font-size: 1.6rem;
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
        <h1 class="main-heading">Our Healthcare Services ✨</h1>
        <p class="professional-message">
            Explore a comprehensive range of healthcare services tailored to your needs. From routine check-ups to specialized treatments,
            our panel of expert doctors and state-of-the-art facilities ensure you receive the highest quality care.
            Browse through our offerings and book your appointment with ease. Your well-being is our priority.
        </p>
    </div>
    <div class="owl-carousel service-carousel">
        <?php
        if ($services && mysqli_num_rows($services) > 0) :
            $icon_classes = [
                'fas fa-heartbeat', 'fas fa-stethoscope', 'fas fa-syringe', 'fas fa-pills',
                'fas fa-brain', 'fas fa-lungs', 'fas fa-bone', 'fas fa-tooth',
                'fas fa-eye', 'fas fa-child', 'fas fa-female', 'fas fa-allergies',
                'fas fa-hand-holding-medical', 'fas fa-diagnoses', 'fas fa-x-ray', 'fas fa-flask',
                'fas fa-capsules', 'fas fa-file-medical', 'fas fa-hospital-alt', 'fas fa-medkit',
                'fas fa-prescription-bottle-alt', 'fas fa-thermometer-half', 'fas fa-band-aid',
                'fas fa-briefcase-medical', 'fas fa-comment-medical', 'fas fa-file-prescription',
                'fas fa-hospital-symbol', 'fas fa-joint', 'fas fa-kit-medical', 'fas fa-laptop-medical',
                'fas fa-microbe', 'fas fa-monitor-heart-rate', 'fas fa-notes-medical', 'fas fa-pager',
                'fas fa-prescription', 'fas fa-radiation-alt', 'fas fa-skull-crossbones', 'fas fa-user-nurse',
                'fas fa-virus', 'fas fa-virus-slash', 'fas fa-weight-scale', 'fas fa-xmarks-lines',
                'fas fa-biohazard', 'fas fa-cannabis', 'fas fa-clipboard-user', 'fas fa-comment-dots',
                'fas fa-dna', 'fas fa-ear-listen', 'fas fa-eye-dropper', 'fas fa-face-mask',
                'fas fa-file-waveform', 'fas fa-hand-holding-droplet', 'fas fa-head-side-cough',
                'fas fa-heart-circle-bolt', 'fas fa-hospital-user', 'fas fa-house-medical',
                'fas fa-id-card-clip', 'fas fa-lungs-virus', 'fas fa-mask-face', 'fas fa-microscope',
                'fas fa-pump-medical', 'fas fa-republican', 'fas fa-skull', 'fas fa-user-doctor',
                'fas fa-user-injured', 'fas fa-weight-hanging', 'fas fa-venus-mars', 'fas fa-flask-vial'
            ];
            $icon_index = 0;
            while ($row = mysqli_fetch_assoc($services)) :
                $id = htmlspecialchars($row['id']);
                $doctor_name = htmlspecialchars($row["doctor's_name"]);
                $service_name = htmlspecialchars($row['name']);
                $description = htmlspecialchars($row['description']);
                $fee = htmlspecialchars($row['fee']);
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
                <div class="service-card text-center">
                    <i class="service-icon <?= $current_icon ?>"></i>
                    <h5 class="service-name">
                        <?= $service_name ?>
                    </h5>
                    <span class="service-id-display">Service ID: <?= $id ?></span>
                    <p class="service-doctor-name">Doctor: <?= $doctor_name ?></p>
                    <div class="service-details">
                        <p><i class="fas fa-file-alt"></i> <strong>Description:</strong> <?= substr($description, 0, 50) . (strlen($description) > 50 ? '...' : '') ?></p>
                        <p><i class="fas fa-rupee-sign"></i> <strong>Fee:</strong> ₹<?= number_format($fee, 2) ?></p>
                        <p><i class="fas fa-calendar-plus"></i> <strong>Created At:</strong> <?= date('d M, Y', strtotime($created_at)) ?></p>
                        <p><i class="fas fa-info-circle"></i> <strong>Status:</strong> <span class="service-status <?= $status_class ?>"><?= ucfirst($status) ?></span></p>
                    </div>
                    <div class="action-btn-group">
                        <a href="serviceProfile.php?id=<?= $id ?>" target="_blank" class="action-btn view-btn">
                            <i class="fas fa-eye me-2"></i> View
                        </a>
                        <a href="serviceProfile.php?id=<?= $id ?>&book=1"
                           target="_blank"
                           class="action-btn book-btn"
                           data-id="<?= $id ?>"
                           data-name="<?= htmlspecialchars($service_name) ?>"
                           data-fee="<?= $fee ?>">
                            <i class="fas fa-download me-2"></i> Book
                        </a>
                    </div>
                </div>
            <?php
            endwhile;
        else :
        ?>
            <div class="col-12 text-center py-5">
                <p class="professional-message">No services found in the directory. Please check back later!</p>
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
    sessionStorage.clear();
    function changeToBooked(btn) {
        btn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Booked';
        btn.classList.remove('book-btn');
        btn.classList.remove('btn-outline-success');
        btn.classList.add('btn-booked');
        btn.style.pointerEvents = 'none';
    }
    document.addEventListener('DOMContentLoaded', () => {
        const bookedIds = JSON.parse(sessionStorage.getItem('bookedServices')) || [];
        document.querySelectorAll('.book-btn').forEach(button => {
            const serviceId = button.dataset.id;
            if (bookedIds.includes(serviceId)) {
                changeToBooked(button);
            }
        });
    });
    document.querySelectorAll('.book-btn').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const url = this.getAttribute('href');
            const serviceId = this.dataset.id;
            const serviceName = encodeURIComponent(this.dataset.name);
            const serviceFee = encodeURIComponent(this.dataset.fee);
            const bookingTime = encodeURIComponent(new Date().toLocaleString());
            const bookedIds = JSON.parse(sessionStorage.getItem('bookedServices')) || [];
            if (!bookedIds.includes(serviceId)) {
                bookedIds.push(serviceId);
                sessionStorage.setItem('bookedServices', JSON.stringify(bookedIds));
            }
            window.open(`book_service.php?id=${serviceId}&name=${serviceName}&fee=${serviceFee}&time=${bookingTime}`, '_blank');
            changeToBooked(this);
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
            popupMessage.find('br').first().remove();
            popupMessage.find('center').text(`✨ Service: ${decodeURIComponent(serviceName)} Booked! ✨`);
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
            }, 5000);
        });
    });
    $(document).ready(function() {
        const serviceCarousel = $('.service-carousel');
        serviceCarousel.owlCarousel({
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
            $('.service-carousel .owl-item .service-card').css('height', 'auto');
            $('.service-carousel .owl-item.active').each(function() {
                let currentHeight = $(this).find('.service-card').outerHeight();
                if (currentHeight > maxHeight) {
                    maxHeight = currentHeight;
                }
            });
            $('.service-carousel .owl-item .service-card').css('height', maxHeight + 'px');
        }
        setEqualCardHeight();
        $(window).on('resize', setEqualCardHeight);
        serviceCarousel.on('initialized.owl.carousel resized.owl.carousel changed.owl.carousel', function(event) {
            setTimeout(setEqualCardHeight, 100);
        });
    });
</script>
<?php include("patientFooter.php"); ?>