<?php
include('header.php');
?>

    <!-- Required CSS for Owl Carousel -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-utbXrL8kryHLHE2Pb7LPv23+a1vRGoAePCxKZZT03WrVAYkHdF+lHbgiQUWwZZklPPZz1mR68YVKP1xClL5SvA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-9CW1XIjEQhv6nOIbGwRGOQ5jDDoY3yoAZc2wV4jQrS6UdOd+P6pH8GEo4Tx6RTejQZudYXrURzQ6u+Ffls9kgA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
.header-carousel .carousel-caption {
    bottom: 20%;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6);
}

.header-carousel .carousel-caption-content h1 {
    animation: fadeInDown 1s ease-in-out;
}

.header-carousel .carousel-caption-content p {
    animation: fadeInUp 1s ease-in-out;
}

.header-carousel .header-carousel-item img {
    height: 90vh;
    object-fit: cover;
    filter: brightness(0.6);
}

.owl-carousel .owl-nav button.owl-prev, 
.owl-carousel .owl-nav button.owl-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0,0,0,0.5);
    color: #fff;
    border: none;
    font-size: 24px;
    width: 50px;
    height: 50px;
    line-height: 50px;
    text-align: center;
    border-radius: 50%;
    z-index: 1;
}

.owl-carousel .owl-nav button.owl-prev {
    left: 20px;
}

.owl-carousel .owl-nav button.owl-next {
    right: 20px;
}

.owl-carousel .owl-dots {
    position: absolute;
    bottom: 20px;
    width: 100%;
    text-align: center;
}

.owl-carousel .owl-dot {
    display: inline-block;
    width: 14px;
    height: 14px;
    background: #fff;
    border-radius: 50%;
    margin: 0 5px;
    opacity: 0.5;
}

.owl-carousel .owl-dot.active {
    opacity: 1;
}
</style>

<!-- Font Awesome for Social Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- Carousel Start -->
<div class="header-carousel owl-carousel owl-theme">
    <div class="header-carousel-item position-relative">
        <img src="https://cdn.pixabay.com/photo/2016/11/08/05/29/surgery-1807541_1280.jpg" class="img-fluid w-100" alt="Physiotherapy Treatment">
        <div class="carousel-caption">
            <div class="carousel-caption-content p-3 text-center">
                <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Advanced Physiotherapy</h5>
                <h1 class="display-1 text-capitalize text-white mb-4">Relieving Pain, Restoring Movement</h1>
                <p class="mb-4 fs-5">Experience cutting-edge physiotherapy techniques performed by certified experts. We focus on personalized care for muscle recovery, joint mobility, and long-term wellness goals.</p>
                <div class="d-flex justify-content-center gap-4 mb-4">
                    <a href="https://www.facebook.com/" target="_blank" class="text-white fs-4"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/" target="_blank" class="text-white fs-4"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.linkedin.com/" target="_blank" class="text-white fs-4"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#">Book Appointment</a>
            </div>
        </div>
    </div>

    <div class="header-carousel-item position-relative">
        <img src="https://cdn.pixabay.com/photo/2015/11/30/19/08/drug-1070943_1280.jpg" class="img-fluid w-100" alt="Hospital Care">
        <div class="carousel-caption">
            <div class="carousel-caption-content p-3 text-center">
                <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Professional Healthcare</h5>
                <h1 class="display-1 text-capitalize text-white mb-4">Trusted Hands for Healthy Recovery</h1>
                <p class="mb-4 fs-5">Your health deserves precision, compassion, and expertise. From diagnostics to rehabilitation, our dedicated professionals prioritize your comfort and complete care journey.</p>
                <div class="d-flex justify-content-center gap-4 mb-4">
                    <a href="https://www.facebook.com/" target="_blank" class="text-white fs-4"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/" target="_blank" class="text-white fs-4"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.linkedin.com/" target="_blank" class="text-white fs-4"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#">Book Appointment</a>
            </div>
        </div>
    </div>

    <div class="header-carousel-item position-relative">
        <img src="https://cdn.pixabay.com/photo/2016/01/19/15/05/computer-1149148_1280.jpg" class="img-fluid w-100" alt="Rehabilitation">
        <div class="carousel-caption">
            <div class="carousel-caption-content p-3 text-center">
                <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">Complete Rehabilitation</h5>
                <h1 class="display-1 text-capitalize text-white mb-4">Rebuilding Strength, Step by Step</h1>
                <p class="mb-4 fs-5">We provide comprehensive recovery programs for patients of all ages—focused on regaining strength, balance, and confidence through structured, evidence-based treatments.</p>
                <div class="d-flex justify-content-center gap-4 mb-4">
                    <a href="https://www.facebook.com/" target="_blank" class="text-white fs-4"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/" target="_blank" class="text-white fs-4"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.linkedin.com/" target="_blank" class="text-white fs-4"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#">Book Appointment</a>
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->



<!-- Required JS for Owl Carousel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YeLec6bKx1p8bYv4yYcgP+TozMDw4bXo9oLSJtWUpVbK6BntxjBBXevnjsXRXD7L8i9Wv4v8p9gG1IQ9zPg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-kosU5hko1N5hP20GJIRj2qjMgOq8q19SZyzBYQQZT/3Dmt+z2eP8bhkXScH6IQ8nUnlJbkaVYhvYx0shvPeN3A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
$('.header-carousel').owlCarousel({
    loop: true,
    margin: 0,
    nav: true,
    dots: true,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    smartSpeed: 1000,
    items: 1,
    navText: ['<span class="fa fa-chevron-left"></span>', '<span class="fa fa-chevron-right"></span>']
});
</script>


<!-- About Start -->
<div class="container-fluid bg-light p-0 m-0">
    <div class="container-fluid p-0 m-0 position-relative">
        <div class="row g-0 align-items-center w-100">
            <div class="col-lg-6 p-0">
                <div class="about-slider position-relative overflow-hidden">
                    <div class="about-slider-wrapper">
                        <div class="about-slider-images d-flex">
                            <img src="https://cdn.pixabay.com/photo/2024/03/19/13/40/ai-generated-8643329_1280.png" class="img-fluid slide-img" alt="Healthcare">
                            <img src="https://cdn.pixabay.com/photo/2020/04/08/07/19/eye-care-5016057_1280.jpg" class="img-fluid slide-img" alt="Hospital">
                            <img src="https://cdn.pixabay.com/photo/2024/03/26/11/57/man-8656636_1280.jpg" class="img-fluid slide-img" alt="Treatment">
                        </div>
                    </div>
                </div>
            </div>
<div class="col-lg-6 bg-white p-5">
    <div class="section-title text-start mb-4 wow fadeInUp" data-wow-delay="0.3s">
        <h4 class="sub-title text-uppercase fw-bold mb-3">About Our Hospital</h4>
        <h1 class="display-3 mb-4 fw-bold">Empowering Recovery Through Advanced Healthcare</h1>
        <p class="mb-4 fs-5 text-secondary">
            With over a decade of trust and excellence, Meditronix bridges the gap between cutting-edge healthcare and intelligent technology. We believe in precise diagnosis, evidence-based treatments, and personalised rehabilitation programs designed for modern patients. Our commitment is to restore strength, mobility, and confidence through innovation, compassion, and precision care.
        </p>
        <p class="mb-4 fs-5 text-secondary">
            Meditronix is not just a hospital — we are a comprehensive **Hospital Management System (HMS)** designed to enhance every aspect of healthcare delivery. From patient registration to discharge, pharmacy integration to real-time reporting, our platform streamlines clinical and administrative workflows, ensuring seamless experiences for both patients and healthcare providers.
        </p>
        <div class="mb-4">
            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Certified & Experienced Medical Professionals</p>
            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Personalised Treatment Plans Tailored to You</p>
            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> State-of-the-art Facilities with Modern Equipment</p>
            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Trusted by Thousands for Compassionate Care</p>
            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Commitment to Your Recovery, Every Step Forward</p>
            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Fully Integrated Digital Hospital Management Ecosystem</p>
            <p class="text-secondary"><i class="fa fa-check text-primary me-2"></i> Real-time Data Insights for Smarter Medical Decisions</p>
        </div>
        <a href="#" class="btn btn-primary rounded-pill text-white py-3 px-5">Discover More</a>
    </div>
</div>

        </div>
    </div>
</div>
<!-- About End -->

<style>
.about-slider {
    width: 100%;
    height: 100vh;
    position: relative;
    overflow: hidden;
}
.about-slider-wrapper {
    width: 300%;
    height: 100%;
    display: flex;
    animation: slide 15s infinite linear;
}
.about-slider-images img {
    width: 100vw;
    height: 100vh;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.about-slider-images img:hover {
    transform: scale(1.05);
    filter: brightness(0.95);
}
@keyframes slide {
    0% { transform: translateX(0%); }
    33.33% { transform: translateX(-100vw); }
    66.66% { transform: translateX(-200vw); }
    100% { transform: translateX(0%); }
}
.section-title h4 {
    color: #0d6efd;
    letter-spacing: 2px;
    position: relative;
}
.section-title h4::before {
    content: "";
    width: 50px;
    height: 3px;
    background-color: #0d6efd;
    position: absolute;
    bottom: -5px;
    left: 0;
}
.section-title h1 {
    font-size: 2.8rem;
    color: #333;
    line-height: 1.2;
}
.section-title p {
    color: #555;
}
.btn-primary {
    background-color: #0d6efd;
    border: none;
    transition: all 0.3s ease-in-out;
}
.btn-primary:hover {
    background-color: #0b5ed7;
    transform: scale(1.05);
    box-shadow: 0 0 10px rgba(13, 110, 253, 0.5);
}
p.text-secondary {
    font-weight: 500;
    font-size: 1rem;
}
.fa-check {
    color: #0d6efd;
}
.bg-light {
    background-color:rgb(254, 255, 255) !important;
}
.bg-white {
    background-color: #fff !important;
}
.wow {
    opacity: 0;
    animation: fadeInUp 1s ease forwards;
}
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(40px);}
    100% { opacity: 1; transform: translateY(0);}
}
.container-fluid {
    padding-left: 0;
    padding-right: 0;
    margin-left: 0;
    margin-right: 0;
}
.row {
    margin-left: 0;
    margin-right: 0;
}
.p-0 {
    padding: 0 !important;
}
.m-0 {
    margin: 0 !important;
}
.p-5 {
    padding: 3rem !important;
}
.display-3 {
    font-weight: 700;
}
.text-primary {
    color: #0d6efd !important;
}
.rounded-pill {
    border-radius: 50rem !important;
}
.text-secondary {
    color: #6c757d !important;
}
.text-uppercase {
    text-transform: uppercase !important;
}
.fw-bold {
    font-weight: 700 !important;
}
.fw-semibold {
    font-weight: 600 !important;
}
.me-2 {
    margin-right: 0.5rem !important;
}
.py-3 {
    padding-top: 1rem !important;
    padding-bottom: 1rem !important;
}
.px-5 {
    padding-left: 3rem !important;
    padding-right: 3rem !important;
}
.fs-5 {
    font-size: 1.25rem !important;
}
.mb-4 {
    margin-bottom: 1.5rem !important;
}
.mb-5 {
    margin-bottom: 3rem !important;
}
.text-center {
    text-align: center !important;
}
.text-start {
    text-align: left !important;
}
.shadow-lg {
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
}
.position-relative {
    position: relative !important;
}
.overflow-hidden {
    overflow: hidden !important;
}
.align-items-center {
    align-items: center !important;
}
.w-100 {
    width: 100% !important;
}
.h-100 {
    height: 100% !important;
}
.d-flex {
    display: flex !important;
}
</style>

<!-- Feature Start -->
<div class="container-fluid bg-light py-5 px-0 m-0" style="overflow-x: hidden;">
    <div class="container-fluid py-5 px-0 m-0 position-relative">
        <div class="section-title text-center mb-5">
            <h4 class="text-uppercase text-primary fw-bold mb-3" style="letter-spacing: 3px;">Why Choose Us</h4>
            <h1 class="display-3 fw-bold mb-4">Trusted Expertise For Your Health & Recovery</h1>
            <p class="fs-5 fw-semibold">Excellence in physiotherapy through personalized care, proven techniques, and genuine results. Let us help you rebuild, recover, and restore your lifestyle with confidence and care.</p>
        </div>

        <div class="row g-4 justify-content-center px-5">
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="feature-item p-4 rounded bg-white shadow-lg h-100 animate-fly">
                    <div class="feature-icon mb-4 text-center">
                        <div class="d-inline-flex bg-light rounded-circle p-4">
                            <i class="fas fa-user-md fa-3x text-primary"></i>
                        </div>
                    </div>
                    <div class="feature-content text-center">
                        <h4 class="fw-bold text-primary mb-3">Certified Therapists</h4>
                        <p class="fw-semibold">Highly trained, globally certified professionals ensuring the best clinical care.</p>
                        <p class="fw-semibold">Empathy and expertise combined for personalized results.</p>
                        <div class="d-flex justify-content-center gap-3 pt-3">
                            <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f text-primary fs-5"></i></a>
                            <a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter text-primary fs-5"></i></a>
                            <a href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin-in text-primary fs-5"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="feature-item p-4 rounded bg-white shadow-lg h-100 animate-fly delay-1">
                    <div class="feature-icon mb-4 text-center">
                        <div class="d-inline-flex bg-light rounded-circle p-4">
                            <i class="fas fa-hospital-user fa-3x text-primary"></i>
                        </div>
                    </div>
                    <div class="feature-content text-center">
                        <h4 class="fw-bold text-primary mb-3">Patient Focused</h4>
                        <p class="fw-semibold">We focus on outcomes that restore confidence and independence in your life.</p>
                        <p class="fw-semibold">Individual recovery journeys, guided step-by-step with care.</p>
                        <div class="d-flex justify-content-center gap-3 pt-3">
                            <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f text-primary fs-5"></i></a>
                            <a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter text-primary fs-5"></i></a>
                            <a href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin-in text-primary fs-5"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="feature-item p-4 rounded bg-white shadow-lg h-100 animate-fly delay-2">
                    <div class="feature-icon mb-4 text-center">
                        <div class="d-inline-flex bg-light rounded-circle p-4">
                            <i class="fas fa-heartbeat fa-3x text-primary"></i>
                        </div>
                    </div>
                    <div class="feature-content text-center">
                        <h4 class="fw-bold text-primary mb-3">Comprehensive Care</h4>
                        <p class="fw-semibold">Holistic treatments tailored to support your physical and mental wellness.</p>
                        <p class="fw-semibold">Science-backed methods meeting your specific health needs.</p>
                        <div class="d-flex justify-content-center gap-3 pt-3">
                            <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f text-primary fs-5"></i></a>
                            <a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter text-primary fs-5"></i></a>
                            <a href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin-in text-primary fs-5"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Feature End -->

<style>
.feature-item {
    transition: all 0.5s ease;
    min-height: 380px;
}
.feature-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.08);
}
.feature-icon i {
    transition: 0.3s;
}
.feature-item:hover .feature-icon i {
    transform: rotate(10deg);
}
.animate-fly {
    opacity: 0;
    transform: translateY(50px);
    animation: flyIn 1.5s forwards;
}
.animate-fly.delay-1 {
    animation-delay: 0.3s;
}
.animate-fly.delay-2 {
    animation-delay: 0.6s;
}
@keyframes flyIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.section-title h1 {
    font-size: 3rem;
    color: #333;
    font-weight: 700;
}
.section-title h4 {
    letter-spacing: 2px;
    color: #0d6efd;
}
.section-title p {
    color: #555;
    font-weight: 500;
}
.fab {
    transition: 0.3s;
}
.fab:hover {
    transform: scale(1.2);
    color: #0b5ed7 !important;
}
.container-fluid {
    padding-left: 0;
    padding-right: 0;
}
.row {
    margin-left: 0;
    margin-right: 0;
}
</style>

  


<?php
$connection = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$connection) {
    die("Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = mysqli_real_escape_string($connection, $_POST['name']);
    $email   = mysqli_real_escape_string($connection, $_POST['email']);
    $subject = mysqli_real_escape_string($connection, $_POST['subject']);
    $message = mysqli_real_escape_string($connection, $_POST['message']);
    $status  = "new";
    $created_at = date('Y-m-d H:i:s');

    $sql = "INSERT INTO `contact_queries`(`name`, `email`, `subject`, `message`, `status`, `created_at`) 
            VALUES ('$name','$email','$subject','$message','$status','$created_at')";

    if (mysqli_query($connection, $sql)) {
        echo "<script>alert('Your query has been submitted successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Appointment | Meditronix</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f8fb;
            color: #333;
        }
        .container-fluid {
            padding: 0;
            margin: 0;
            width: 100%;
        }
        .row {
            display: flex;
            width: 100%;
        }
        .left-content {
            width: 50%;
            padding: 80px;
            background-color: #fff;
        }
        .right-content {
            width: 50%;
            padding: 80px;
            background-color: #0bb6d7;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .left-content h4 {
            color: #0bb6d7;
            letter-spacing: 2px;
        }
        .left-content h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #111;
        }
        .left-content p {
            font-size: 25px;
            margin-bottom: 1rem;
            line-height: 1.8;
        }
        .features {
            margin: 20px 0;
        }
        .features h5 {
            font-size: 25px;
            margin: 10px 0;
            color: #0b5ed7;
        }
        .features p {
            font-size: 20px;
        }
        .social-links a {
            margin-right: 15px;
            font-size: 20px;
            color: #0b5ed7;
            text-decoration: none;
            transition: 0.3s;
        }
        .social-links a:hover {
            color: #111;
            transform: scale(1.1);
        }
        .appointment-form {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
            width: 100%;
        }
        .appointment-form h4 {
            color: #0b5ed7;
            margin-bottom: 20px;
            font-size: 25px;
        }
        .appointment-form input,
        .appointment-form textarea {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #0bb6d7;
            border-radius: 6px;
            background: #f8f9fa;
        }
        .appointment-form textarea {
            resize: vertical;
        }
        .appointment-form button {
            background: #0b5ed7;
            color: #fff;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.4s;
        }
        .appointment-form button:hover {
            background: #111;
        }
        .right-content h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .right-content p {
            font-size: 22px;
            line-height: 1.8;
        }
        .animate-fly {
            opacity: 0;
            transform: translateY(50px);
            animation: flyIn 1.2s forwards;
        }
        @keyframes flyIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @media (max-width: 992px) {
            .row {
                flex-direction: column;
            }
            .left-content, .right-content {
                width: 100%;
                padding: 40px;
            }
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="left-content">
            <h4>SOLUTIONS TO YOUR PAIN</h4>
            <h1>Best Quality Services With Minimal Pain Rate</h1>
            <p>Empowering healing through precision care, personalized therapy, and compassionate rehabilitation for every patient.</p>
            <p>Dedicated to your health with modern techniques and professional commitment that ensures comfort and faster recovery.</p>

            <div class="features">
                <h5><i class="fa fa-check"></i> Safe & Effective Therapies</h5>
                <p>Focused solutions designed with clinical expertise for sustainable healing and mobility enhancement.</p>
                <h5><i class="fa fa-check"></i> Patient-Centered Care</h5>
                <p>We listen, understand, and deliver strategies that bring real-life benefits to your well-being.</p>
            </div>

            <div class="social-links">
                <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin-in"></i></a>
            </div>

            <div class="appointment-form animate-fly">
                <h4>Quick Appointment Query</h4>
                <form method="POST" action="">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <input type="text" name="subject" placeholder="Subject" required>
                    <textarea name="message" rows="4" placeholder="Write your message here..." required></textarea>
                    <button type="submit">Submit Now</button>
                </form>
            </div>
        </div>

   <div class="right-content">
    <h2>Your Wellness, Our Priority</h2>
    <p>Expert therapy combined with innovative care for remarkable recovery and sustainable health benefits. Book your appointment today and begin your journey to a pain-free life with confidence and trust.</p>

    <p>Meditronix stands at the forefront of modern healthcare, delivering trusted physiotherapy solutions tailored to individual needs. Our mission is rooted in a commitment to excellence, where every treatment is guided by compassion, precision, and medical expertise. We believe health is more than recovery — it's about restoring confidence, dignity, and quality of life.</p>

    <p>With a team of certified professionals, advanced therapeutic techniques, and a patient-centered approach, Meditronix continues to redefine standards in rehabilitation and wellness. Your health is our responsibility, and your satisfaction is our success.</p>
</div>

    </div>
</div>


      <?php
$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle Add Doctor
if (isset($_POST['add'])) {
    $user_id = $_POST['user_id'];
    $specialization = $_POST['specialization'];
    $experience = $_POST['experience'];
    $availability = $_POST['availability'];
    $status = $_POST['status'];
    $created_at = date('Y-m-d H:i:s');

    $sql = "INSERT INTO doctors (user_id, specialization, experience, availability, status, created_at) 
            VALUES ('$user_id','$specialization','$experience','$availability','$status','$created_at')";
    mysqli_query($db, $sql);
}

// (Hidden) Delete Logic, NOT VISIBLE on Frontend but query is there
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($db, "DELETE FROM doctors WHERE id=$id");
}

// Fetch Doctors
$doctors = mysqli_query($db, "SELECT * FROM doctors");
?>

<div class="container-fluid bg-light py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="text-uppercase text-primary fw-bold">Our Dedicated Medical Experts</h2>
            <h1 class="display-4 fw-bold">Bringing Expertise & Care Together</h1>
            <p class="lead">We combine innovation with compassion to deliver outstanding medical excellence every day.</p>
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-5">
            <?php while ($row = mysqli_fetch_assoc($doctors)) { ?>
                <div class="doctor-card p-4 shadow-lg rounded">
                    <div class="icon-container">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <h4 class="text-primary fw-bold mt-3"><?php echo htmlspecialchars($row['specialization']); ?></h4>
                    <p class="text-dark mb-2">Experience: <strong><?php echo htmlspecialchars($row['experience']); ?> Years</strong></p>
                    <p class="text-dark mb-2">Availability: <strong><?php echo htmlspecialchars($row['availability']); ?></strong></p>
                    <p class="text-success fw-bold">Status: <?php echo htmlspecialchars($row['status']); ?></p>
                    <p class="small text-muted">Joined on: <?php echo date('d M Y', strtotime($row['created_at'])); ?></p>
                    <div class="social-icons mt-3">
                        <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a>
                        <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            <?php } ?>
        </div>


    </div>
</div>

<style>
.doctor-card {
    width: 320px;
    min-height: 380px;
    background: linear-gradient(145deg, #ffffff, #f1f1f1);
    border: 1px solid #eee;
    border-radius: 1rem;
    text-align: center;
    transition: 0.5s;
    padding: 2rem 1.5rem;
    position: relative;
    overflow: hidden;
}

.doctor-card:hover {
    transform: translateY(-10px);
    background: linear-gradient(135deg, #007bff, #00c6ff);
    color: #fff;
}

.doctor-card .icon-container {
    width: 90px;
    height: 90px;
    background:rgb(52, 81, 110);
    color: #007bff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.8rem;
    margin: 0 auto;
    transition: 0.4s;
    box-shadow: 0 4px 10px rgba(250, 245, 245, 0.1);
}

.doctor-card:hover .icon-container {
    background: #00c6ff;
    color: rgb(255, 255, 255);
    transform: rotate(360deg);
}

.doctor-card h4, .doctor-card p {
    transition: 0.4s;
}

.doctor-card:hover h4,
.doctor-card:hover p {
    color: #fff !important;
}

.social-icons a {
    color: #007bff;
    font-size: 1.4rem;
    margin: 0 10px;
    transition: 0.3s;
}

.doctor-card:hover .social-icons a {
    color: #fff;
}

.btn-primary {
    background-color: #007bff;
    border: none;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
}

.btn-primary:hover {
    background-color: #0056b3;
    color: #fff;
}
</style>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<?php
$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['add'])) {
    $patient_id = $_POST['patient_id'];
    $message = $_POST['message'];
    $rating = $_POST['rating'];
    $status = $_POST['status'];
    $created_at = date('Y-m-d H:i:s');

    $sql = "INSERT INTO feedback (patient_id, message, rating, status, created_at) 
            VALUES ('$patient_id','$message','$rating','$status','$created_at')";
    mysqli_query($db, $sql);
}

$feedbacks = mysqli_query($db, "SELECT * FROM feedback");
?>

<div class="container-fluid bg-white py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="text-uppercase text-primary fw-bold">Patient Feedback</h2>
            <h1 class="display-5 fw-bold text-dark">Trust Reflected Through Words</h1>
            <p class="lead text-secondary">Real people, real stories. Every experience strengthens the quality we serve.</p>
        </div>

        <div class="slider-wrapper">
            <div class="feedback-slider" id="feedbackSlider">
                <?php while ($row = mysqli_fetch_assoc($feedbacks)) { ?>
                    <div class="feedback-card" onclick="triggerFirework()">
                        <span class="water-effect"></span>
                        <div class="icon-container">
                            <i class="fas fa-comments"></i>
                        </div>
                        <p class="fs-5 text-secondary"><?php echo htmlspecialchars($row['message']); ?></p>
                        <h5 class="text-dark fw-bold mb-1">Patient ID: <?php echo htmlspecialchars($row['patient_id']); ?></h5>
                        <p class="text-primary">Rating: <strong><?php echo htmlspecialchars($row['rating']); ?>/5</strong></p>
                        <p class="small text-muted">Status: <?php echo htmlspecialchars($row['status']); ?> | Shared: <?php echo date('d M Y', strtotime($row['created_at'])); ?></p>
                        <div class="stars text-warning fs-5">
                            <?php for ($i = 0; $i < $row['rating']; $i++) { echo '<i class="fas fa-star"></i>'; } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>


    </div>
</div>

<div id="popup-message">✨ Thanks for reaching out to our hospital ✨ 
<br>
<center>✨MEDITRONIX✨</center> 
</div>
<canvas id="fireworkCanvas"></canvas>

<style>
body {
    background: #fff;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

.slider-wrapper {
    overflow: hidden;
    position: relative;
    width: 100%;
    padding: 0 5%;
}

.feedback-slider {
    display: flex;
    gap: 50px;
    transition: transform 1s ease;
}

.feedback-card {
    flex: 0 0 350px;
    background: #fff;
    border-radius: 1.5rem;
    padding: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    text-align: center;
    cursor: pointer;
}

.feedback-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.1);
}

.feedback-card .water-effect {
    content: "";
    position: absolute;
    top: 0;
    left: 50%;
    width: 300%;
    height: 300%;
    background: rgba(0, 123, 255, 0.1);
    transform: translateX(-50%) scale(0);
    transition: 0.6s;
    border-radius: 50%;
    z-index: 0;
}

.feedback-card:hover .water-effect {
    transform: translateX(-50%) scale(1);
}

.icon-container {
    width: 90px;
    height: 90px;
    background: #007bff;
    color: #fff;
    border-radius: 50%;
    font-size: 2.8rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem auto;
    position: relative;
}

.feedback-card .stars i {
    margin-right: 3px;
    font-size: 1.4rem;
}

.btn-primary {
    background-color: #007bff;
    border: none;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
}

.btn-primary:hover {
    background-color: #0056b3;
    color: #fff;
}

#fireworkCanvas {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 9999;
}

#popup-message {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
    background: #fff;
    padding: 20px 40px;
    border-radius: 20px;
    font-size: 22px;
    color: #007bff;
    font-weight: bold;
    opacity: 0;
    z-index: 10000;
    box-shadow: 0 0 20px rgba(0, 123, 255, 0.3);
    transition: transform 1.2s ease, opacity 1.2s ease;
}

#popup-message.show {
    transform: translate(-50%, -50%) scale(1);
    opacity: 1;
}
</style>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
let slider = document.getElementById('feedbackSlider');
let currentIndex = 0;
let cardWidth = 400;
let totalCards = slider.children.length;

function autoSlide() {
    currentIndex++;
    if (currentIndex >= totalCards) {
        currentIndex = 0;
    }
    slider.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
}

setInterval(autoSlide, 3500); // Slow & smooth

// Firework Cracker ✨ + Message Animation
const canvas = document.getElementById('fireworkCanvas');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

function random(min, max) {
    return Math.random() * (max - min) + min;
}

function createParticles(x, y) {
    const particles = [];
    for (let i = 0; i < 50; i++) {
        particles.push({
            x,
            y,
            radius: random(2, 4),
            color: `hsl(${Math.random() * 360}, 100%, 50%)`,
            dx: random(-5, 5),
            dy: random(-5, 5),
            alpha: 1
        });
    }
    return particles;
}

let fireworks = [];

function animateFireworks() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    fireworks.forEach((fw, index) => {
        fw.forEach(p => {
            p.x += p.dx;
            p.y += p.dy;
            p.alpha -= 0.02;
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(${p.color.match(/\d+/g).join(",")},${p.alpha})`;
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
    }, 3000);
}
</script>


<?php
$db = mysqli_connect("localhost", "root", "", "meditronix_new");
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
$news = mysqli_query($db, "SELECT * FROM news");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Latest Medical News</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <style>
body { 
    background: #fff; 
    overflow-x: hidden; 
    margin: 0; 
    padding: 0; 
}

.slider-container { 
    width: 100%; 
    overflow-x: auto; 
    overflow-y: hidden; 
    position: relative; 
    padding-bottom: 10px; /* To avoid scrollbar overlapping content */
}

.slider-container::-webkit-scrollbar {
    height: 8px;
}

.slider-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.slider-container::-webkit-scrollbar-thumb {
    background: #007bff;
    border-radius: 10px;
}

.slider-container::-webkit-scrollbar-thumb:hover {
    background: #0056b3;
}

.slider-track { 
    display: flex; 
    transition: transform 0.7s ease; 
}

.slider-card {
    min-width: 400px;
    margin: 0 20px;
    background: #fff;
    border-radius: 1.5rem;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    cursor: pointer;
}

.slider-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.1);
}

.icon-container {
    width: 90px;
    height: 90px;
    background: #007bff;
    color: #fff;
    border-radius: 50%;
    font-size: 2.8rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem auto;
}

.btn-primary {
    background-color: #007bff;
    border: none;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
}

.btn-primary:hover { 
    background-color: #0056b3; 
}

#popup-message {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
    background: #fff;
    padding: 30px 50px;
    border-radius: 20px;
    font-size: 2rem;
    color: #007bff;
    font-weight: bold;
    opacity: 0;
    z-index: 10000;
    box-shadow: 0 0 20px rgba(0, 123, 255, 0.3);
    transition: transform 1.2s ease, opacity 1.2s ease;
}

#popup-message.show { 
    transform: translate(-50%, -50%) scale(1); 
    opacity: 1; 
}

</style>
</head>
<body>

<div class="container-fluid bg-white py-5">
    <div class="container-fluid py-5">
        <div class="text-center mb-5">
            <h2 class="text-uppercase text-primary fw-bold">Latest Medical News</h2>
            <h1 class="display-5 fw-bold text-dark">Stay Updated with Our Healthcare Insights</h1>
            <p class="lead text-secondary">Every update matters — Your health journey begins with trusted information.</p>
        </div>

        <div class="slider-container">
            <div class="slider-track" id="sliderTrack">
                <?php while ($row = mysqli_fetch_assoc($news)) { ?>
                    <div class="slider-card">
                        <span class="water-effect"></span>
                        <div class="icon-container">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <h5 class="fw-bold text-dark"><?php echo htmlspecialchars($row['title']); ?></h5>
                        <p class="text-secondary"><?php echo htmlspecialchars($row['content']); ?></p>
                        <p class="small text-muted">Status: <?php echo htmlspecialchars($row['status']); ?> | Published: <?php echo date('d M Y', strtotime($row['created_at'])); ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div id="popup-message">✨ Thanks for exploring our medical updates ✨</div>

<script>
    function showPopupMessage() {
        const popup = document.getElementById('popup-message');
        popup.classList.add('show');
        setTimeout(() => {
            popup.classList.remove('show');
        }, 3000);
    }

    document.querySelectorAll('.slider-card').forEach(card => {
        card.addEventListener('click', () => {
            showPopupMessage();
        });
    });
</script>

</body>
</html>





       <?php
       include('footer.php');
       ?>