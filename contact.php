<?php
include('header.php');
?>

<!-- Tailwind CSS CDN for utility classes -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* Base Styles for Body and Containers */
    body {
        font-family: 'Inter', sans-serif;
        background-color: #ffffff; /* Simple plane white background */
        margin: 0;
        padding: 0;
        overflow-x: hidden; /* Prevent horizontal scrolling */
        line-height: 1.6; /* Improved readability */
    }

    .container-fluid {
        width: 100%;
        padding-right: 1rem; /* Consistent padding */
        padding-left: 1rem; /* Consistent padding */
        margin-right: auto;
        margin-left: auto;
    }

    .container {
        max-width: 1200px; /* Adjust as needed for content width */
        margin-left: auto;
        margin-right: auto;
        padding: 2rem 1rem; /* Responsive padding */
    }

    /* Responsive padding for larger screens */
    @media (min-width: 768px) {
        .container {
            padding: 3rem 2rem;
        }
    }

    .py-5 {
        padding-top: 3rem;
        padding-bottom: 3rem;
    }

    /* Section Title Styling */
    .section-title {
        margin-bottom: 3rem;
        text-align: center;
    }

    .section-title .sub-style {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background-color: #e0f2fe; /* Tailwind blue-100 */
        color: #1e40af; /* Tailwind blue-800 */
        border-radius: 9999px; /* Rounded-full */
        font-weight: 500; /* Medium font weight */
        font-size: 0.875rem; /* Text-sm */
        margin-bottom: 0.5rem;
        animation: fadeInDown 0.8s ease-out; /* Animation for sub-title */
        box-shadow: 0 2px 4px rgba(0,0,0,0.05); /* Subtle shadow */
    }

    .section-title h1 {
        font-size: 2.5rem; /* Text-4xl */
        font-weight: 700; /* Font-bold */
        color: #1f2937; /* Gray-800 */
        margin-bottom: 1rem;
        line-height: 1.2;
        animation: fadeInLeft 1s ease-out; /* Animation for main title */
        text-shadow: 1px 1px 2px rgba(0,0,0,0.05); /* Subtle text shadow */
    }

    /* Paragraph container for charm and readability */
    .paragraph-container {
        background-color: #fcfcfc; /* Very light background */
        padding: 2rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
        transition: all 0.3s ease-in-out;
        border: 1px solid #f0f0f0; /* Light border */
    }
    .paragraph-container:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        transform: translateY(-3px);
    }
    .paragraph-container p {
        color: #4b5563; /* Gray-600 for paragraph text */
        font-size: 1.125rem; /* Text-lg */
        max-width: 48rem; /* Max-w-3xl */
        margin-left: auto;
        margin-right: auto;
    }

    /* Contact Section Specific Styles */
    .contact {
        background-color: #ffffff; /* Ensure white background for the entire section */
    }

    /* Contact Form Styling */
    .contact-form {
        background-color: #f8f9fa; /* Light skin color for the form background */
        padding: 2.5rem;
        border-radius: 1rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease-in-out;
        animation: fadeInUp 1s ease-out; /* Animation for form */
        border: 1px solid #e5e7eb; /* Light gray border */
    }

    .contact-form:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        transform: translateY(-5px);
    }

    .contact-form h2 {
        color: #1f2937; /* Dark text for heading */
        font-size: 2.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .contact-form p {
        color: #4b5563; /* Darker text for form description */
        margin-bottom: 1.5rem;
    }

    .contact-form .form-floating {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .contact-form .form-control {
        background-color: #ffffff; /* White background for input fields */
        border: 1px solid #d1d5db; /* Light gray border */
        border-radius: 0.5rem;
        padding: 1rem 1rem;
        width: 100%;
        color: #1f2937; /* Solid black text for input */
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        -webkit-appearance: none; /* Remove default browser styling */
        -moz-appearance: none;
        appearance: none;
    }

    .contact-form .form-control::placeholder { /* Placeholder text color */
        color: #6b7280; /* Dark gray for placeholder */
        opacity: 1; /* Ensure placeholder is always visible */
    }

    .contact-form .form-control:focus {
        outline: none;
        border-color: #3b82f6; /* Blue-500 on focus */
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2); /* Blue shadow on focus */
    }

    .contact-form .form-floating label {
        position: absolute;
        top: 1rem;
        left: 1rem;
        color: #6b7280; /* Gray-500 for label */
        pointer-events: none;
        transition: all 0.2s ease-in-out;
        transform-origin: 0% 0%;
    }

    .contact-form .form-control:focus ~ label,
    .contact-form .form-control:not(:placeholder-shown) ~ label {
        top: -0.75rem;
        left: 0.75rem;
        font-size: 0.75rem;
        color: #3b82f6; /* Blue-500 when focused/filled */
        background-color: #f8f9fa; /* Match form background */
        padding: 0 0.25rem;
        transform: scale(0.9); /* Slightly shrink label */
    }

    .contact-form textarea.form-control {
        height: 160px !important; /* Fixed height for textarea */
        resize: vertical; /* Allow vertical resizing */
        min-height: 100px; /* Minimum height */
    }

    /* Custom select styling */
    .contact-form select.form-control {
        padding-right: 2.5rem; /* Space for custom arrow */
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem 1rem;
    }

    .contact-form .btn-primary {
        background-color: #3b88c3; /* Primary blue button */
        color: #ffffff; /* White text */
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        width: 100%;
        transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        position: relative; /* For bubble effect */
        overflow: hidden; /* For ripple effect */
    }

    .contact-form .btn-primary:hover {
        background-color: #2563eb; /* Darker blue on hover */
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    /* Ripple effect for buttons */
    .btn-primary::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.4);
        width: 100px;
        height: 100px;
        margin-top: -50px;
        margin-left: -50px;
        opacity: 0;
        transition: all 0.7s ease-in-out;
        transform: scale(0);
    }

    .btn-primary:active::after {
        transform: scale(2);
        opacity: 1;
        transition: 0s;
    }

    /* Password toggle icon */
    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6b7280;
        transition: color 0.2s ease;
        z-index: 10; /* Ensure it's above the input */
    }
    .password-toggle:hover {
        color: #1f2937;
    }

    /* Contact Info Boxes */
    .contact-info-box {
        background-color: #ffffff; /* White background for info boxes */
        padding: 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        margin-bottom: 1.5rem;
        text-align: center;
        transition: all 0.3s ease-in-out;
        animation: fadeInRight 1s ease-out; /* Animation for info boxes */
        border: 1px solid #e5e7eb; /* Light gray border */
    }

    .contact-info-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .contact-info-box .icon-circle {
        width: 60px;
        height: 60px;
        background-color: #e0f2fe; /* Light blue background for icon circle */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
    }

    .contact-info-box:hover .icon-circle {
        background-color: #bfdbfe; /* Slightly darker blue on hover */
    }

    .contact-info-box .icon-circle i {
        color: #3b82f6; /* Primary blue for icons */
        font-size: 1.75rem;
        transition: color 0.3s ease;
    }

    .contact-info-box:hover .icon-circle i {
        color: #1e40af; /* Darker blue icon on hover */
    }

    .contact-info-box h4 {
        color: #1f2937; /* Dark text for info titles */
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .contact-info-box p {
        color: #4b5563; /* Gray text for info content */
        font-size: 0.95rem;
        line-height: 1.4;
        margin-bottom: 0.25rem;
    }

    /* Social Media Links */
    .social-links {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
        animation: fadeInDown 1s ease-out; /* Animation for social links */
    }

    .social-links a {
        width: 50px;
        height: 50px;
        background-color: #e0f2fe; /* Light blue background for social icons */
        color: #3b82f6; /* Primary blue for icons */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 0.5rem;
        font-size: 1.25rem;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .social-links a:hover {
        background-color: #3b82f6; /* Darker blue on hover */
        color: #ffffff;
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }

    /* Map Styling */
    .map-container {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease-in-out;
        animation: fadeInRight 1.2s ease-out; /* Animation for map */
        border: 1px solid #e5e7eb; /* Light gray border */
    }

    .map-container:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        transform: translateY(-5px);
    }

    .map-container iframe {
        width: 100%;
        height: 500px; /* Fixed height for the map */
        border: 0;
        max-width: 100%; /* Ensure responsive scaling for iframe */
        display: block; /* Remove extra space below iframe */
        object-fit: cover; /* Ensures the map covers the area without distortion */
    }

    /* Query Links Section */
    .query-links-section {
        background-color: #ffffff; /* White background */
        padding: 3rem 1rem;
        border-radius: 1rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        margin-top: 4rem;
        border: 1px solid #e5e7eb; /* Light gray border */
    }

    .query-links-section h2 {
        color: #1f2937;
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 2rem;
    }

    .query-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 1.5rem;
    }

    @media (min-width: 768px) {
        .query-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1024px) {
        .query-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    .query-card {
        background-color: #f0f9ff; /* Light blue background for query cards */
        padding: 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease-in-out;
        border: 1px solid #bfdbfe; /* Blue-200 border */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        animation: fadeInUp 0.8s ease-out; /* Animation for query cards */
    }

    .query-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .query-card .icon {
        color: #3b82f6; /* Primary blue for icons */
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .query-card h3 {
        color: #1f2937;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .query-card p {
        color: #4b5563;
        font-size: 1rem;
        line-height: 1.5;
        margin-bottom: 1.5rem;
        flex-grow: 1; /* Allows description to take available space */
    }

    .query-card .btn-query {
        background-color: #3b82f6; /* Blue-500 */
        color: #ffffff;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        transition: background-color 0.3s ease, transform 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-top: auto; /* Pushes button to bottom */
    }

    .query-card .btn-query:hover {
        background-color: #2563eb; /* Darker blue */
        transform: translateY(-2px);
    }

    /* Modals (Query Details and Carousel Details) */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .modal-content {
        background-color: #ffffff;
        padding: 2.5rem;
        border-radius: 1rem;
        max-width: 800px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        transform: translateY(20px);
        opacity: 0;
        transition: transform 0.3s ease, opacity 0.3s ease;
        position: relative; /* For close button positioning */
        border: 1px solid #e5e7eb; /* Light gray border */
    }

    .modal-overlay.active .modal-content {
        transform: translateY(0);
        opacity: 1;
    }

    .modal-close-button {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #6b7280;
        cursor: pointer;
        transition: color 0.2s ease, transform 0.2s ease;
    }

    .modal-close-button:hover {
        color: #1f2937;
        transform: rotate(90deg);
    }

    .modal-content h3 {
        font-size: 2rem;
        color: #1f2937;
        margin-bottom: 1.5rem;
        text-align: center;
        border-bottom: 2px solid #e0f2fe; /* Subtle underline */
        padding-bottom: 0.5rem;
    }

    .modal-content h4 {
        font-size: 1.5rem;
        color: #1f2937;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .modal-content p {
        color: #4b5563;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .modal-content ul, .modal-content ol {
        list-style: disc;
        margin-left: 1.5rem;
        margin-bottom: 1rem;
        color: #4b5563;
    }

    .modal-content ol {
        list-style: decimal;
    }

    .modal-content ul li, .modal-content ol li {
        margin-bottom: 0.5rem;
    }

    .modal-content .contact-details {
        background-color: #e0f2fe;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-top: 1.5rem;
        border: 1px solid #93c5fd;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
    }

    .modal-content .contact-details strong {
        color: #1e40af;
    }

    /* Carousel / Slideshow Features */
    .carousel-container {
        position: relative;
        width: 100%;
        max-width: 1000px; /* Adjust max width as needed */
        margin: 4rem auto;
        overflow: hidden;
        border-radius: 1rem;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        background-color: #f8f9fa;
        min-height: 400px; /* Minimum height for carousel */
        border: 1px solid #e5e7eb; /* Light gray border */
    }

    .carousel-track {
        display: flex;
        transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Smooth sliding transition with ease-in-out */
    }

    .carousel-slide {
        min-width: 100%; /* Each slide takes full width */
        box-sizing: border-box;
        padding: 2rem;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #ffffff; /* White background for slides */
        border-radius: 1rem;
        opacity: 0; /* Start hidden for animation */
        transform: scale(0.95); /* Slightly smaller for animation */
        transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
    }

    .carousel-slide.active-slide {
        opacity: 1;
        transform: scale(1);
    }

    .carousel-slide h3 {
        font-size: 2.25rem;
        color: #1f2937;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .carousel-slide p {
        font-size: 1.125rem;
        color: #4b5563;
        line-height: 1.6;
        max-width: 600px;
        margin-bottom: 1.5rem;
    }

    .carousel-slide .btn-carousel {
        background-color: #3b82f6;
        color: #ffffff;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 0.5rem;
        border: none;
        transition: background-color 0.3s ease, transform 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .carousel-slide .btn-carousel:hover {
        background-color: #2563eb;
        transform: translateY(-2px);
    }

    .carousel-dots {
        display: flex;
        justify-content: center;
        margin-top: 1.5rem;
        gap: 0.75rem;
    }

    .carousel-dot {
        width: 12px;
        height: 12px;
        background-color: #d1d5db; /* Gray-300 */
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .carousel-dot.active {
        background-color: #3b82f6; /* Blue-500 */
        transform: scale(1.2);
    }

    .carousel-nav-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        cursor: pointer;
        font-size: 1.5rem;
        z-index: 10;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .carousel-nav-button:hover {
        background-color: rgba(0, 0, 0, 0.7);
        transform: translateY(-50%) scale(1.05);
    }

    .carousel-nav-button.prev {
        left: 1rem;
    }

    .carousel-nav-button.next {
        right: 1rem;
    }

    /* Responsive adjustments */
    @media (max-width: 767px) {
        .contact-form {
            padding: 1.5rem;
        }
        .contact-form h2 {
            font-size: 1.75rem;
        }
        .contact-info-box {
            padding: 1rem;
        }
        .contact-info-box .icon-circle {
            width: 70px;
            height: 70px;
        }
        .contact-info-box .icon-circle i {
            font-size: 1.5rem;
        }
        .social-links a {
            width: 40px;
            height: 40px;
            font-size: 1rem;
            margin: 0 0.25rem;
        }
        .map-container iframe {
            height: 300px;
        }
        .query-links-section h2 {
            font-size: 2rem;
        }
        .query-card {
            padding: 1rem;
        }
        .query-card h3 {
            font-size: 1.25rem;
        }
        .query-card p {
            font-size: 0.9rem;
        }
        .carousel-slide h3 {
            font-size: 1.75rem;
        }
        .carousel-slide p {
            font-size: 1rem;
        }
        .carousel-nav-button {
            padding: 0.5rem 0.75rem;
            font-size: 1.2rem;
        }
    }

    /* Keyframe Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>

<!-- Contact Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <!-- Section Title: Contact Our Team -->
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sub-style mb-4">
                <h4 class="sub-title text-blue-800 px-3 mb-0">Contact Us</h4>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Contact Our Team</h1>
            <div class="paragraph-container">
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Whether you're seeking urgent medical care, expert consultations, or partnership support, our team is available 24/7 to respond to every message. We're committed to helping you navigate the right department quickly and confidently. From booking appointments with leading specialists to addressing health-related concerns with accuracy and empathy, we strive to offer you a seamless experience. No matter the complexity of your query—be it critical care, diagnostics, rehabilitation, or corporate health.
                </p>
            </div>
            <div class="mt-8 flex justify-center gap-4">
                <a href="tel:+01234567890" class="btn-carousel bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1">
                    <i class="fas fa-phone-alt mr-2"></i> Call Support
                </a>
                <a href="mailto:info@example.com" class="btn-carousel bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1">
                    <i class="fas fa-envelope mr-2"></i> Email Us
                </a>
            </div>
            <p class="text-sm text-green-600 mt-4"><i class="fas fa-circle text-green-500 mr-2"></i> Live Support: Available Now</p>
        </div>

        <div class="row g-4 align-items-center">
            <!-- Contact Form Section -->
            <div class="col-lg-5 col-xl-5 contact-form wow fadeInLeft" data-wow-delay="0.1s">
                <h2 class="display-5 text-gray-800 mb-2">Get in Touch</h2>
                <div class="paragraph-container mb-4">
                    <p class="text-gray-600">
                        We'd love to hear from you, Rohan Kapri! Fill out the form below and we'll get back to you as soon as possible. Your feedback and queries are important to us.
                    </p>
                </div>
                <form id="contactForm">
                    <div class="row g-3">
                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name" placeholder="Your Name" required aria-label="Your Name">
                                <label for="name">Your Name</label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" placeholder="Your Email" required aria-label="Your Email">
                                <label for="email">Your Email</label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <input type="tel" class="form-control" id="phone" placeholder="Phone" required aria-label="Your Phone">
                                <label for="phone">Your Phone</label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="subject" placeholder="Subject" required aria-label="Subject">
                                <label for="subject">Subject</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating relative">
                                <input type="password" class="form-control pr-10" id="password" placeholder="Password" required aria-label="Password">
                                <label for="password">Password</label>
                                <span class="password-toggle" data-target="password" aria-label="Toggle password visibility">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating relative">
                                <input type="password" class="form-control pr-10" id="confirmPassword" placeholder="Confirm Password" required aria-label="Confirm Password">
                                <label for="confirmPassword">Confirm Password</label>
                                <span class="password-toggle" data-target="confirmPassword" aria-label="Toggle confirm password visibility">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <!-- New Form Fields Added Below -->
                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <select class="form-control" id="contactMethod" required aria-label="Preferred Contact Method">
                                    <option value="" disabled selected>Select Method</option>
                                    <option value="email">Email</option>
                                    <option value="phone">Phone Call</option>
                                    <option value="video">Video Call</option>
                                </select>
                                <label for="contactMethod">Preferred Contact Method</label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="preferredDate" required aria-label="Preferred Date for Contact">
                                <label for="preferredDate">Preferred Date for Contact</label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <select class="form-control" id="timeSlot" required aria-label="Preferred Time Slot">
                                    <option value="" disabled selected>Select Time Slot</option>
                                    <option value="morning">Morning (9 AM - 12 PM)</option>
                                    <option value="afternoon">Afternoon (12 PM - 5 PM)</option>
                                    <option value="evening">Evening (5 PM - 8 PM)</option>
                                </select>
                                <label for="timeSlot">Preferred Time Slot</label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <select class="form-control" id="department" required aria-label="Department of Interest">
                                    <option value="" disabled selected>Select Department</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="appointments">Appointments</option>
                                    <option value="billing">Billing & Insurance</option>
                                    <option value="medical_records">Medical Records</option>
                                    <option value="hr">Human Resources</option>
                                    <option value="other">Other</option>
                                </select>
                                <label for="department">Department of Interest</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <select class="form-control" id="howHear" required aria-label="How did you hear about us?">
                                    <option value="" disabled selected>Select Option</option>
                                    <option value="search_engine">Search Engine</option>
                                    <option value="social_media">Social Media</option>
                                    <option value="referral">Referral</option>
                                    <option value="advertisement">Advertisement</option>
                                    <option value="event">Event</option>
                                    <option value="other">Other</option>
                                </select>
                                <label for="howHear">How did you hear about us?</label>
                            </div>
                        </div>
                        <!-- End New Form Fields -->

                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a message here" id="message" style="height: 160px" required aria-label="Your Message"></textarea>
                                <label for="message">Message</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="flex items-center mb-4">
                                <input type="checkbox" id="newPatient" class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <label for="newPatient" class="ml-2 text-gray-700">Are you a new patient?</label>
                            </div>
                            <div id="newPatientMessage" class="text-sm text-blue-700 bg-blue-50 p-3 rounded-md hidden transition-all duration-300 ease-in-out">
                                <p><i class="fas fa-info-circle mr-2"></i> Welcome! As a new patient, we recommend exploring our "Appointment Scheduling" and "Find a Doctor" links below for a smooth onboarding experience. You can also call us directly for personalized assistance.</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="flex items-center mb-4">
                                <input type="checkbox" id="consent" class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500" required>
                                <label for="consent" class="ml-2 text-gray-700">I consent to my data being processed for communication purposes as per the <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>.</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-paper-plane mr-2"></i> Send Message
                            </button>
                        </div>
                    </div>
                </form>
                <div id="formMessage" class="mt-4 text-center text-sm font-semibold hidden"></div>
            </div>

            <!-- Contact Information and Emergency Contact -->
            <div class="col-lg-2 col-xl-2 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-transparent rounded">
                    <!-- Address -->
                    <div class="contact-info-box">
                        <div class="icon-circle"><i class="fa fa-map-marker-alt"></i></div>
                        <h4>Our Address</h4>
                        <p>1481 Creekside Lane Avilla Beach, CA 93424</p>
                        <a href="https://maps.app.goo.gl/YourHospitalLocation" target="_blank" class="text-blue-600 hover:underline text-sm mt-2 block">View on Map</a>
                    </div>
                    <!-- Mobile -->
                    <div class="contact-info-box">
                        <div class="icon-circle"><i class="fa fa-phone-alt"></i></div>
                        <h4>Mobile</h4>
                        <p><a href="tel:+53345795332453" class="text-blue-600 hover:underline">+53 345 7953 32453</a></p>
                        <p><a href="tel:+01234567890" class="text-blue-600 hover:underline">+012 345 67890</a></p>
                        <p class="text-gray-500 text-xs mt-2">Available 24/7 for general inquiries.</p>
                    </div>
                    <!-- Email -->
                    <div class="contact-info-box">
                        <div class="icon-circle"><i class="fa fa-envelope-open"></i></div>
                        <h4>Email</h4>
                        <p><a href="mailto:yourmail@gmail.com" class="text-blue-600 hover:underline">yourmail@gmail.com</a></p>
                        <p><a href="mailto:info@example.com" class="text-blue-600 hover:underline">info@example.com</a></p>
                        <p class="text-gray-500 text-xs mt-2">Expect a response within 24-48 hours.</p>
                    </div>
                    <!-- Emergency Call Section -->
                    <div class="contact-info-box bg-red-50 text-red-800 border-red-300">
                        <div class="icon-circle bg-red-100"><i class="fa fa-exclamation-triangle text-red-600"></i></div>
                        <h4 class="text-red-800">For Emergency Calls</h4>
                        <p class="text-red-800 text-xl font-bold mb-2"><a href="tel:+18236118721" class="text-red-800 hover:underline">+1 823-611-8721</a></p>
                        <p class="text-red-700 text-sm">Our dedicated team is available 24/7 for urgent medical assistance. Don't hesitate to reach out in critical situations.</p>
                    </div>
                </div>
            </div>

            <!-- Social Media and Map -->
            <div class="col-lg-5 col-xl-5 wow fadeInRight" data-wow-delay="0.3s">
                <!-- Social Media Links -->
                <div class="social-links mb-4">
                    <a class="btn btn-lg-square rounded-circle mx-2" href="https://www.facebook.com/Google" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-lg-square rounded-circle mx-2" href="https://twitter.com/Google" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-lg-square rounded-circle mx-2" href="https://www.instagram.com/Google" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-lg-square rounded-circle mx-2" href="https://www.linkedin.com/company/google" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-lg-square rounded-circle mx-2" href="https://www.youtube.com/user/Google" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-lg-square rounded-circle mx-2" href="https://www.pinterest.com/Google/" target="_blank" aria-label="Pinterest"><i class="fab fa-pinterest"></i></a>
                </div>
                <!-- Google Map -->
                <div class="map-container rounded h-100">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387191.33750346623!2d-73.97968099999999!3d40.6974881!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1694259649153!5m2!1sen!2sbd"
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade" aria-label="Our Location on Google Maps">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

<!-- Explore Our Hospital Information & Query Links Section -->
<div class="container-fluid py-5 query-links-section">
    <div class="container py-5">
        <h2 class="text-center wow fadeInUp" data-wow-delay="0.1s">Explore Our Hospital Information & Query Links</h2>
        <div class="paragraph-container mb-8">
            <p class="text-center text-gray-600">
                Click on any link below to get detailed information about our services and departments.
            </p>
        </div>

        <div class="query-grid">
            <!-- General Inquiries -->
            <div class="query-card wow fadeInUp" data-wow-delay="0.1s">
                <div class="icon"><i class="fas fa-question-circle"></i></div>
                <h3>General Inquiries</h3>
                <p>Find answers to common questions about our services, visiting hours, and general hospital policies. For specific questions, please contact our administrative office.</p>
                <button class="btn-query" data-query-type="general">
                    Learn More <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>

            <!-- Appointment Scheduling -->
            <div class="query-card wow fadeInUp" data-wow-delay="0.2s">
                <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                <h3>Appointment Scheduling</h3>
                <p>Book or manage your appointments with our specialists and departments quickly and easily. Our online portal allows you to view available slots and choose your preferred doctor.</p>
                <button class="btn-query" data-query-type="appointment">
                    Schedule Now <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>

            <!-- Find a Doctor -->
            <div class="query-card wow fadeInUp" data-wow-delay="0.3s">
                <div class="icon"><i class="fas fa-user-md"></i></div>
                <h3>Find a Doctor</h3>
                <p>Search our comprehensive directory to find the right doctor for your specific medical needs and specialty. View their profiles, specializations, and patient reviews.</p>
                <button class="btn-query" data-query-type="doctor">
                    Search Doctors <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>

            <!-- Billing & Insurance -->
            <div class="query-card wow fadeInUp" data-wow-delay="0.4s">
                <div class="icon"><i class="fas fa-file-invoice-dollar"></i></div>
                <h3>Billing & Insurance</h3>
                <p>Get information on billing procedures, accepted insurance plans, and financial assistance options. Our dedicated team can help clarify any questions you may have.</p>
                <button class="btn-query" data-query-type="billing">
                    View Details <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>

            <!-- Laboratory Services -->
            <div class="query-card wow fadeInUp" data-wow-delay="0.5s">
                <div class="icon"><i class="fas fa-flask"></i></div>
                <h3>Laboratory Services</h3>
                <p>Learn about our comprehensive laboratory testing services and how to prepare for tests. We offer a wide range of diagnostic tests with accurate and timely results.</p>
                <button class="btn-query" data-query-type="laboratory">
                    Explore Services <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>

            <!-- Emergency Services -->
            <div class="query-card wow fadeInUp" data-wow-delay="0.6s">
                <div class="icon"><i class="fas fa-ambulance"></i></div>
                <h3>Emergency Services</h3>
                <p>Information regarding our emergency department, what to do in an emergency, and our capabilities. For immediate assistance, please call our emergency hotline.</p>
                <button class="btn-query bg-red-600 hover:bg-red-700 text-white" data-query-type="emergency">
                    Emergency Info <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Query Details Modal -->
<div id="queryModalOverlay" class="modal-overlay">
    <div class="modal-content">
        <button class="modal-close-button" id="closeModal" aria-label="Close modal">&times;</button>
        <h3 id="modalTitle"></h3>
        <div id="modalContent"></div>
    </div>
</div>

<!-- Advanced Sliding Carousel for Additional Features -->
<div class="carousel-container">
    <div class="carousel-track" id="featureCarouselTrack">
        <!-- Slide 1: Virtual Consultations -->
        <div class="carousel-slide">
            <i class="fas fa-video text-blue-500 text-5xl mb-4"></i>
            <h3>Virtual Consultations Available</h3>
            <div class="paragraph-container max-w-md mx-auto">
                <p>Connect with our specialists from the comfort of your home. Our secure telehealth platform ensures convenient and confidential medical advice.</p>
            </div>
            <button class="btn-carousel" data-modal-type="virtualConsult">Book a Virtual Consult <i class="fas fa-arrow-right ml-2"></i></button>
        </div>
        <!-- Slide 2: Patient Portal -->
        <div class="carousel-slide">
            <i class="fas fa-user-circle text-green-500 text-5xl mb-4"></i>
            <h3>Access Your Patient Portal</h3>
            <div class="paragraph-container max-w-md mx-auto">
                <p>Manage your appointments, view lab results, request prescription refills, and communicate securely with your care team. All in one place.</p>
            </div>
            <button class="btn-carousel" data-modal-type="patientPortal">Login to Portal <i class="fas fa-arrow-right ml-2"></i></button>
        </div>
        <!-- Slide 3: Holistic Wellness Programs -->
        <div class="carousel-slide">
            <i class="fas fa-heartbeat text-red-500 text-5xl mb-4"></i>
            <h3>Holistic Wellness Programs</h3>
            <div class="paragraph-container max-w-md mx-auto">
                <p>Explore our range of wellness programs, including nutrition counseling, fitness classes, and mental health support, designed for your overall well-being.</p>
            </div>
            <button class="btn-carousel" data-modal-type="wellnessPrograms">Discover Programs <i class="fas fa-arrow-right ml-2"></i></button>
        </div>
        <!-- Slide 4: Community Health Initiatives -->
        <div class="carousel-slide">
            <i class="fas fa-hands-helping text-purple-500 text-5xl mb-4"></i>
            <h3>Community Health Initiatives</h3>
            <div class="paragraph-container max-w-md mx-auto">
                <p>We are actively involved in promoting health within our community through free screenings, health education workshops, and outreach programs.</p>
            </div>
            <button class="btn-carousel" data-modal-type="communityHealth">Learn More <i class="fas fa-arrow-right ml-2"></i></button>
        </div>
        <!-- Slide 5: Career Opportunities -->
        <div class="carousel-slide">
            <i class="fas fa-briefcase text-yellow-500 text-5xl mb-4"></i>
            <h3>Join Our Dedicated Team</h3>
            <div class="paragraph-container max-w-md mx-auto">
                <p>Passionate about healthcare? Explore rewarding career opportunities at our hospital and become part of a team committed to excellence.</p>
            </div>
            <button class="btn-carousel" data-modal-type="careerOpportunities">View Openings <i class="fas fa-arrow-right ml-2"></i></button>
        </div>
        <!-- Additional Carousel Slides for more features -->
        <div class="carousel-slide">
            <i class="fas fa-pills text-teal-500 text-5xl mb-4"></i>
            <h3>Pharmacy Services</h3>
            <div class="paragraph-container max-w-md mx-auto">
                <p>Convenient on-site and online pharmacy services for all your prescription needs, including medication counseling and delivery options.</p>
            </div>
            <button class="btn-carousel" data-modal-type="pharmacyServices">Explore Pharmacy <i class="fas fa-arrow-right ml-2"></i></button>
        </div>
        <div class="carousel-slide">
            <i class="fas fa-child text-orange-500 text-5xl mb-4"></i>
            <h3>Pediatric Care</h3>
            <div class="paragraph-container max-w-md mx-auto">
                <p>Specialized medical care for infants, children, and adolescents, delivered by a compassionate team of pediatric experts.</p>
            </div>
            <button class="btn-carousel" data-modal-type="pediatricCare">Learn About Pediatrics <i class="fas fa-arrow-right ml-2"></i></button>
        </div>
        <div class="carousel-slide">
            <i class="fas fa-tooth text-lime-500 text-5xl mb-4"></i>
            <h3>Dental Health Services</h3>
            <div class="paragraph-container max-w-md mx-auto">
                <p>Comprehensive dental care, from routine check-ups to specialized procedures, ensuring your oral health is in excellent hands.</p>
            </div>
            <button class="btn-carousel" data-modal-type="dentalHealth">Discover Dental Care <i class="fas fa-arrow-right ml-2"></i></button>
        </div>
        <div class="carousel-slide">
            <i class="fas fa-brain text-indigo-500 text-5xl mb-4"></i>
            <h3>Neurology Department</h3>
            <div class="paragraph-container max-w-md mx-auto">
                <p>Advanced diagnosis and treatment for neurological conditions, including stroke, epilepsy, and Parkinson's disease.</p>
            </div>
            <button class="btn-carousel" data-modal-type="neurologyDept">Explore Neurology <i class="fas fa-arrow-right ml-2"></i></button>
        </div>
        <div class="carousel-slide">
            <i class="fas fa-lungs text-cyan-500 text-5xl mb-4"></i>
            <h3>Pulmonary & Respiratory Care</h3>
            <div class="paragraph-container max-w-md mx-auto">
                <p>Expert care for lung and respiratory conditions, offering advanced diagnostics and personalized treatment plans.</p>
            </div>
            <button class="btn-carousel" data-modal-type="pulmonaryCare">View Pulmonary Services <i class="fas fa-arrow-right ml-2"></i></button>
        </div>
        <div class="carousel-slide">
            <i class="fas fa-bone text-gray-700 text-5xl mb-4"></i>
            <h3>Orthopedic & Sports Medicine</h3>
            <div class="paragraph-container max-w-md mx-auto">
                <p>Specialized care for bone, joint, and muscle conditions, including sports injuries, fractures, and joint replacement.</p>
            </div>
            <button class="btn-carousel" data-modal-type="orthopedicCare">Explore Orthopedics <i class="fas fa-arrow-right ml-2"></i></button>
        </div>
        <div class="carousel-slide">
            <i class="fas fa-baby text-pink-500 text-5xl mb-4"></i>
            <h3>Maternity & Birthing Services</h3>
            <div class="paragraph-container max-w-md mx-auto">
                <p>Comprehensive care for expectant mothers, from prenatal to postpartum, including state-of-the-art birthing suites.</p>
            </div>
            <button class="btn-carousel" data-modal-type="maternityServices">Learn About Maternity <i class="fas fa-arrow-right ml-2"></i></button>
        </div>
        <div class="carousel-slide">
            <i class="fas fa-hand-holding-heart text-rose-500 text-5xl mb-4"></i>
            <h3>Cardiac Care Center</h3>
            <div class="paragraph-container max-w-md mx-auto">
                <p>Leading-edge diagnostics and treatments for heart conditions, from preventative cardiology to complex cardiac surgery.</p>
            </div>
            <button class="btn-carousel" data-modal-type="cardiacCare">Discover Cardiac Services <i class="fas fa-arrow-right ml-2"></i></button>
        </div>
        <div class="carousel-slide">
            <i class="fas fa-microscope text-fuchsia-500 text-5xl mb-4"></i>
            <h3>Research & Clinical Trials</h3>
            <div class="paragraph-container max-w-md mx-auto">
                <p>Participate in groundbreaking medical research and access innovative treatments through our clinical trials program.</p>
            </div>
            <button class="btn-carousel" data-modal-type="researchTrials">Explore Research <i class="fas fa-arrow-right ml-2"></i></button>
        </div>
        <div class="carousel-slide">
            <i class="fas fa-hospital-user text-emerald-500 text-5xl mb-4"></i>
            <h3>Patient & Family Support</h3>
            <div class="paragraph-container max-w-md mx-auto">
                <p>Resources and services to support patients and their families throughout their healthcare journey, including counseling and education.</p>
            </div>
            <button class="btn-carousel" data-modal-type="patientSupport">View Support Services <i class="fas fa-arrow-right ml-2"></i></button>
        </div>
    </div>
    <button class="carousel-nav-button prev" id="carouselPrev" aria-label="Previous slide">&#10094;</button>
    <button class="carousel-nav-button next" id="carouselNext" aria-label="Next slide">&#10095;</button>
    <div class="carousel-dots" id="carouselDots"></div>
</div>

<!-- Carousel Details Modal (New Modal for Carousel Links) -->
<div id="carouselModalOverlay" class="modal-overlay">
    <div class="modal-content">
        <button class="modal-close-button" id="closeCarouselModal" aria-label="Close carousel modal">&times;</button>
        <h3 id="carouselModalTitle"></h3>
        <div id="carouselModalContent"></div>
    </div>
</div>

<script>
    // Utility function to toggle password visibility
    function setupPasswordToggle(inputId, toggleIcon) {
        const input = document.getElementById(inputId);
        const icon = toggleIcon.querySelector('i');

        toggleIcon.addEventListener('click', () => {
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    }

    // Function to display a temporary message (e.g., for form submission)
    function showTemporaryMessage(message, type = 'success', duration = 3000) {
        const formMessage = document.getElementById('formMessage');
        formMessage.innerHTML = message;
        formMessage.classList.remove('hidden', 'text-green-600', 'text-red-600');
        if (type === 'success') {
            formMessage.classList.add('text-green-600');
        } else {
            formMessage.classList.add('text-red-600');
        }
        formMessage.classList.add('block');

        // Fade in animation
        formMessage.style.opacity = '0';
        formMessage.style.transform = 'translateY(10px)';
        setTimeout(() => {
            formMessage.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
            formMessage.style.opacity = '1';
            formMessage.style.transform = 'translateY(0)';
        }, 50);

        // Hide after duration
        setTimeout(() => {
            formMessage.style.opacity = '0';
            formMessage.style.transform = 'translateY(10px)';
            formMessage.addEventListener('transitionend', function handler() {
                formMessage.classList.add('hidden');
                formMessage.removeEventListener('transitionend', handler);
            }, { once: true });
        }, duration);
    }

    // JavaScript for Contact Form Submission (Client-side validation and message)
    document.getElementById('contactForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Get form field values and trim whitespace
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const subject = document.getElementById('subject').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const message = document.getElementById('message').value.trim();
        const contactMethod = document.getElementById('contactMethod').value;
        const preferredDate = document.getElementById('preferredDate').value;
        const timeSlot = document.getElementById('timeSlot').value;
        const department = document.getElementById('department').value;
        const howHear = document.getElementById('howHear').value;
        const consent = document.getElementById('consent').checked;

        let isValid = true;
        let errorMessage = '';

        // Validate Name: Must be at least 2 characters and contain only letters and spaces
        const nameRegex = /^[A-Za-z\s]{2,}$/;
        if (!nameRegex.test(name)) {
            errorMessage += 'Please enter a valid name (at least 2 letters, no numbers/symbols).<br>';
            isValid = false;
        }

        // Validate Email: Standard email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            errorMessage += 'Please enter a valid email address.<br>';
            isValid = false;
        }

        // Validate Phone: Allows optional +, numbers, spaces, hyphens, parentheses, min 7, max 20 digits
        const phoneRegex = /^\+?[0-9\s-()]{7,20}$/;
        if (!phoneRegex.test(phone)) {
            errorMessage += 'Please enter a valid phone number (7-20 digits, can include +, -, (), spaces).<br>';
            isValid = false;
        }

        // Validate Subject: Must be at least 5 characters
        if (subject.length < 5) {
            errorMessage += 'Subject must be at least 5 characters long.<br>';
            isValid = false;
        }

        // Validate Password: Minimum 8 characters, at least one letter and one number
        const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
        if (!passwordRegex.test(password)) {
            errorMessage += 'Password must be at least 8 characters long and include at least one letter and one number.<br>';
            isValid = false;
        } else if (password !== confirmPassword) {
            errorMessage += 'Password and Confirm Password do not match.<br>';
            isValid = false;
        }

        // Validate Message: Must be at least 10 characters
        if (message.length < 10) {
            errorMessage += 'Message must be at least 10 characters long.<br>';
            isValid = false;
        }

        // Validate Dropdowns: Must have a selected value (not the disabled default)
        if (!contactMethod) {
            errorMessage += 'Please select a preferred contact method.<br>';
            isValid = false;
        }
        if (!preferredDate) {
            errorMessage += 'Please select a preferred date for contact.<br>';
            isValid = false;
        } else {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const selected = new Date(preferredDate);
            selected.setHours(0, 0, 0, 0);
            if (selected < today) {
                errorMessage += 'Preferred date cannot be in the past.<br>';
                isValid = false;
            }
        }
        if (!timeSlot) {
            errorMessage += 'Please select a preferred time slot.<br>';
            isValid = false;
        }
        if (!department) {
            errorMessage += 'Please select a department of interest.<br>';
            isValid = false;
        }
        if (!howHear) {
            errorMessage += 'Please let us know how you heard about us.<br>';
            isValid = false;
        }

        // Validate Consent Checkbox
        if (!consent) {
            errorMessage += 'You must consent to our Privacy Policy.<br>';
            isValid = false;
        }

        if (!isValid) {
            showTemporaryMessage(errorMessage, 'error', 5000); // Show error message for 5 seconds
            return;
        }

        // Simulate form submission success
        setTimeout(() => {
            showTemporaryMessage('Thank you for your message, Rohan Kapri! We will get back to you shortly.', 'success', 5000);
            this.reset(); // Clear the form
            // Hide new patient message if it was visible
            newPatientMessage.classList.add('hidden');
        }, 1000);
    });

    // "Are you a new patient?" checkbox functionality
    const newPatientCheckbox = document.getElementById('newPatient');
    const newPatientMessage = document.getElementById('newPatientMessage');

    newPatientCheckbox.addEventListener('change', function() {
        if (this.checked) {
            newPatientMessage.classList.remove('hidden');
            newPatientMessage.style.opacity = '0';
            newPatientMessage.style.transform = 'translateY(20px)';
            setTimeout(() => {
                newPatientMessage.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                newPatientMessage.style.opacity = '1';
                newPatientMessage.style.transform = 'translateY(0)';
            }, 50); // Small delay to ensure transition applies
        } else {
            newPatientMessage.style.opacity = '0';
            newPatientMessage.style.transform = 'translateY(20px)';
            newPatientMessage.addEventListener('transitionend', function handler() {
                newPatientMessage.classList.add('hidden');
                newPatientMessage.removeEventListener('transitionend', handler);
            }, { once: true });
        }
    });

    // Setup password toggles
    document.querySelectorAll('.password-toggle').forEach(toggle => {
        const targetId = toggle.dataset.target;
        setupPasswordToggle(targetId, toggle);
    });

    // Data for Query Links Modals
    const queryDetails = {
        general: {
            title: "General Inquiries: Your Questions Answered",
            content: `
                <p>Our administrative team is here to assist you with any general questions about our hospital services, visiting hours, and policies. We aim to make your experience as smooth as possible.</p>
                <h4>Common General Inquiries:</h4>
                <ul>
                    <li><strong>Visiting Hours:</strong> Daily from 9:00 AM - 8:00 PM. Specific department hours may vary. Please check our website for the latest updates.</li>
                    <li><strong>Hospital Policies:</strong> Detailed information on patient rights, privacy (HIPAA compliance), billing policies, and general facility guidelines.</li>
                    <li><strong>General Services:</strong> Overview of non-medical services like cafeteria hours, parking availability and rates, gift shop, and spiritual care services.</li>
                    <li><strong>Feedback and Suggestions:</strong> How to provide feedback on your experience, submit complaints, or offer suggestions for improvement. Your input helps us serve you better.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>To contact our administrative office:</strong></p>
                    <p><i class="fas fa-phone-alt mr-2 text-blue-600"></i> Phone: <a href="tel:+01234567890" class="text-blue-600 hover:underline">+012 345 67890</a></p>
                    <p><i class="fas fa-envelope mr-2 text-blue-600"></i> Email: <a href="mailto:admin@yourhospital.com" class="text-blue-600 hover:underline">admin@yourhospital.com</a></p>
                    <p><i class="fas fa-clock mr-2 text-blue-600"></i> Office Hours: Monday - Friday, 8:00 AM - 5:00 PM (EST)</p>
                    <p><i class="fas fa-info-circle mr-2 text-blue-600"></i> For non-urgent queries, please allow 24-48 hours for a response.</p>
                </div>
            `
        },
        appointment: {
            title: "Appointment Scheduling: Book Your Visit",
            content: `
                <p>Scheduling an appointment with our specialists is easy and convenient. We offer flexible timings to suit your needs, ensuring you receive timely care.</p>
                <h4>How to Book:</h4>
                <ul>
                    <li><strong>Online Portal:</strong> Access our secure patient portal to view real-time availability, select your preferred specialist, and book directly. You'll receive instant confirmation.</li>
                    <li><strong>Phone:</strong> Call our dedicated scheduling desk during office hours. Our friendly staff will guide you through the process and answer any questions.</li>
                    <li><strong>Walk-in:</strong> While we encourage appointments, limited walk-in slots are available for urgent, non-emergency cases. Please note wait times may vary.</li>
                </ul>
                <h4>Key Information:</h4>
                <ul>
                    <li><strong>Specialists Available:</strong> We have over 150 board-certified physicians across a wide range of specialties including Cardiology, Orthopedics, Neurology, Pediatrics, General Medicine, Dermatology, Oncology, Gastroenterology, and more.</li>
                    <li><strong>Book Slots:</strong> Our online system shows real-time availability. Slots are typically 30-minute intervals, available from 8:00 AM to 6:00 PM, Monday to Saturday. Evening appointments are also available for select specialties.</li>
                    <li><strong>Preparation:</strong> Please bring your insurance card, a valid photo ID, and any relevant medical records, referral letters, or a list of current medications.</li>
                    <li><strong>Cancellation Policy:</strong> Kindly notify us at least 24 hours in advance for cancellations or rescheduling to avoid a cancellation fee. This allows us to offer the slot to another patient.</li>
                    <li><strong>Telehealth Options:</strong> Many appointments can be converted to virtual consultations if preferred, offering greater flexibility.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>To schedule an appointment:</strong></p>
                    <p><i class="fas fa-phone-alt mr-2 text-blue-600"></i> Scheduling Desk: <a href="tel:+01234567891" class="text-blue-600 hover:underline">+012 345 67891</a></p>
                    <p><i class="fas fa-globe mr-2 text-blue-600"></i> Online Portal: <a href="https://yourhospital.com/portal" target="_blank" class="text-blue-600 hover:underline">yourhospital.com/portal</a></p>
                    <p><i class="fas fa-clock mr-2 text-blue-600"></i> Hours: Monday - Saturday, 7:00 AM - 7:00 PM</p>
                    <p><i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> Location: Main Hospital Reception Desk, 1st Floor</p>
                </div>
            `
        },
        doctor: {
            title: "Find a Doctor: Our Expert Medical Team",
            content: `
                <p>Our hospital boasts a team of highly qualified and compassionate doctors across various specialties. Use our comprehensive directory to find the perfect match for your healthcare needs, ensuring you receive expert care.</p>
                <h4>Doctor Directory Features:</h4>
                <ul>
                    <li><strong>Search by Specialty:</strong> Easily find experts in Cardiology, Oncology, Pediatrics, Orthopedics, Neurology, General Medicine, Endocrinology, and many more.</li>
                    <li><strong>Doctor Profiles:</strong> View detailed bios, including their educational background (e.g., MD from Harvard Medical School, PhD from Stanford), board certifications (e.g., Board Certified in Internal Medicine, Fellowship in Sports Medicine), and extensive areas of expertise (e.g., minimally invasive surgery, pediatric cardiology, advanced cancer treatments).</li>
                    <li><strong>Years of Experience:</strong> Each profile clearly lists their years of practice, giving you confidence in their experience.</li>
                    <li><strong>Patient Reviews:</strong> Read genuine testimonials and ratings from other patients to help you make an informed decision about your care provider.</li>
                    <li><strong>Direct Contact:</strong> Options to send a secure message directly to the doctor's office or book an appointment directly from their profile page.</li>
                    <li><strong>Languages Spoken:</strong> Find doctors who speak your preferred language.</li>
                    <li><strong>Research & Publications:</strong> Access information on their contributions to medical research and publications.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>To search for a doctor:</strong></p>
                    <p><i class="fas fa-globe mr-2 text-blue-600"></i> Doctor Directory: <a href="https://yourhospital.com/doctors" target="_blank" class="text-blue-600 hover:underline">yourhospital.com/doctors</a></p>
                    <p><i class="fas fa-phone-alt mr-2 text-blue-600"></i> For assistance: <a href="tel:+01234567892" class="text-blue-600 hover:underline">+012 345 67892</a></p>
                    <p><i class="fas fa-question-circle mr-2 text-blue-600"></i> Need help choosing? Our patient navigators can assist you.</p>
                </div>
            `
        },
        billing: {
            title: "Billing & Insurance: Understanding Your Costs",
            content: `
                <p>Navigating healthcare billing and insurance can be complex. Our dedicated billing department is here to assist you with all your inquiries, ensuring transparency and clarity regarding your medical expenses.</p>
                <h4>Key Information:</h4>
                <ul>
                    <li><strong>Accepted Insurance Plans:</strong> A comprehensive list of insurance providers we work with, including major national and regional plans (e.g., Blue Cross Blue Shield, Aetna, Cigna, UnitedHealthcare, Medicare, Medicaid). We also provide guidance on verifying your coverage.</li>
                    <li><strong>Billing Procedures:</strong> A clear explanation of how charges are processed, how to read your medical statements, and what to do if you have questions about a specific bill.</li>
                    <li><strong>Financial Assistance:</strong> Information on various programs and options available for patients needing financial support, including payment plans, discounted care policies, and charity care applications. Our financial counselors are available to help.</li>
                    <li><strong>Payment Options:</strong> Details on how to conveniently pay your bills, including secure online payments, phone payments, in-person at our patient services desk, and mail-in options.</li>
                    <li><strong>Estimates:</strong> Request a good faith estimate for services.</li>
                    <li><strong>Understanding Your EOB:</strong> Explanation of Benefits (EOB) from your insurance company.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>To contact our billing department:</strong></p>
                    <p><i class="fas fa-phone-alt mr-2 text-blue-600"></i> Billing Inquiries: <a href="tel:+01234567893" class="text-blue-600 hover:underline">+012 345 67893</a></p>
                    <p><i class="fas fa-envelope mr-2 text-blue-600"></i> Email: <a href="mailto:billing@yourhospital.com" class="text-blue-600 hover:underline">billing@yourhospital.com</a></p>
                    <p><i class="fas fa-clock mr-2 text-blue-600"></i> Hours: Monday - Friday, 9:00 AM - 4:00 PM (EST)</p>
                    <p><i class="fas fa-calendar-alt mr-2 text-blue-600"></i> Book a financial counseling session online.</p>
                </div>
            `
        },
        laboratory: {
            title: "Laboratory Services: Accurate Diagnostics",
            content: `
                <p>Our state-of-the-art laboratory provides a full range of diagnostic testing services, crucial for accurate diagnosis and effective treatment. We are committed to providing timely and precise results using the latest technology.</p>
                <h4>Services Offered:</h4>
                <ul>
                    <li><strong>Blood Tests:</strong> Comprehensive blood work, including Complete Blood Count (CBC), chemistry panels, lipid profiles, thyroid function tests, specialized genetic screenings, and allergy testing.</li>
                    <li><strong>Urinalysis:</strong> Analysis of urine samples for various health indicators, including infections, kidney function, and metabolic disorders.</li>
                    <li><strong>Pathology:</strong> Expert tissue analysis for disease diagnosis, including biopsies, cytology, and immunohistochemistry.</li>
                    <li><strong>Microbiology:</strong> Identification of bacteria, viruses, and fungi, including antibiotic susceptibility testing.</li>
                    <li><strong>Molecular Diagnostics:</strong> Advanced testing for infectious diseases, genetic disorders, and cancer biomarkers.</li>
                    <li><strong>Imaging Preparation:</strong> Guidance on preparing for various imaging tests like MRI, CT scans, X-rays, and ultrasounds, including fasting instructions and contrast agent information.</li>
                </ul>
                <h4>Preparation & Results:</h4>
                <ul>
                    <li><strong>Fasting Requirements:</strong> Specific instructions for tests requiring fasting (e.g., 8-12 hours for certain blood tests). Please confirm with your doctor or our lab staff.</li>
                    <li><strong>Results Access:</strong> Secure online access to your lab results via our patient portal, typically available within 24-72 hours depending on the test complexity. Critical results are communicated immediately to your physician.</li>
                    <li><strong>Turnaround Time:</strong> Information on expected timeframes for test results, with urgent results prioritized.</li>
                    <li><strong>Walk-in Lab Draws:</strong> Available for most routine tests without an appointment.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>To inquire about laboratory services:</strong></p>
                    <p><i class="fas fa-phone-alt mr-2 text-blue-600"></i> Lab Services: <a href="tel:+01234567894" class="text-blue-600 hover:underline">+012 345 67894</a></p>
                    <p><i class="fas fa-clock mr-2 text-blue-600"></i> Lab Hours: Monday - Saturday, 6:00 AM - 6:00 PM (EST)</p>
                    <p><i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> Location: Ground Floor, Diagnostic Wing</p>
                </div>
            `
        },
        emergency: {
            title: "Emergency Services: Urgent Care Information",
            content: `
                <p>Our Emergency Department is open 24/7 to provide immediate medical attention for critical conditions and injuries. Your safety is our top priority. We are equipped to handle a wide range of medical emergencies with a dedicated team of specialists and advanced technology.</p>
                <h4>When to Visit Emergency:</h4>
                <ul>
                    <li>Severe chest pain or difficulty breathing.</li>
                    <li>Sudden numbness or weakness on one side of the body (potential stroke symptoms).</li>
                    <li>Severe bleeding, deep cuts, or major trauma (e.g., from an accident).</li>
                    <li>Head injury with loss of consciousness, severe headache, or confusion.</li>
                    <li>Severe abdominal pain, persistent vomiting, or signs of dehydration.</li>
                    <li>High fever in infants or young children, especially with other concerning symptoms.</li>
                    <li>Any life-threatening condition, severe allergic reaction, or overdose.</li>
                    <li>Unexplained seizures or loss of consciousness.</li>
                </ul>
                <h4>What to Expect:</h4>
                <ul>
                    <li><strong>Triage System:</strong> Patients are assessed upon arrival and seen based on the severity of their condition, not order of arrival. This ensures the most critical patients receive immediate attention.</li>
                    <li><strong>Waiting Times:</strong> May vary depending on patient volume and the severity of cases. We strive to minimize wait times while ensuring quality care.</li>
                    <li><strong>Capabilities:</strong> State-of-the-art diagnostic equipment (on-site X-ray, CT, MRI, Ultrasound), advanced life support systems, a fully equipped trauma center, and immediate access to operating rooms.</li>
                    <li><strong>Number of Wards Available:</strong> Our Emergency Department has 5 dedicated trauma bays, 20 acute care rooms, 10 observation beds, and direct access to specialized Intensive Care Units (ICUs) and surgical wards.</li>
                    <li><strong>Doctors Description:</strong> Our emergency team comprises over 50 board-certified emergency physicians, highly specialized emergency nurses, physician assistants, and support staff. They are trained to handle a wide range of medical emergencies with speed, precision, and compassion. We also have on-call specialists in all major fields (e.g., cardiologists, neurologists, surgeons) available 24/7 for immediate consultation.</li>
                </ul>
                <div class="contact-details bg-red-100 border-red-300">
                    <p class="text-red-800 font-bold text-lg"><i class="fas fa-exclamation-triangle mr-2"></i> For immediate emergencies, please call:</p>
                    <p class="text-red-800 font-bold text-2xl mb-2"><a href="tel:+18236118721" class="text-red-800 hover:underline">+1 823-611-8721</a></p>
                    <p class="text-red-700 text-sm">Our dedicated team is available 24/7 for urgent medical assistance. Don't hesitate to reach out in critical situations. For non-life-threatening conditions, consider our urgent care centers for faster service.</p>
                    <p class="text-red-700 text-sm mt-2"><i class="fas fa-map-marker-alt mr-2"></i> Emergency Entrance: Located on the North side of the hospital building.</p>
                </div>
            `
        }
    };

    // Data for Carousel Links Modals
    const carouselDetails = {
        virtualConsult: {
            title: "Virtual Consultations: Healthcare at Your Fingertips",
            content: `
                <p>Our virtual consultation service allows you to connect with our expert doctors and specialists from anywhere, using secure video conferencing. It's a convenient way to get medical advice, follow-up care, and discuss test results without needing to visit the hospital.</p>
                <h4>Benefits of Virtual Consultations:</h4>
                <ul>
                    <li><strong>Convenience:</strong> Consult from the comfort of your home or office, saving time and travel.</li>
                    <li><strong>Accessibility:</strong> Ideal for patients in remote areas, those with mobility challenges, or busy schedules.</li>
                    <li><strong>Time-Saving:</strong> Reduces travel time, parking hassles, and waiting room time.</li>
                    <li><strong>Confidentiality:</strong> Our telehealth platform is fully HIPAA-compliant, ensuring your privacy and data security.</li>
                    <li><strong>Continuity of Care:</strong> Seamless integration with your existing medical records.</li>
                </ul>
                <h4>How it Works:</h4>
                <ol>
                    <li><strong>Book Online:</strong> Schedule your virtual appointment through our secure patient portal or by calling our scheduling desk.</li>
                    <li><strong>Receive Link:</strong> Get a secure video link and instructions via email or SMS before your appointment.</li>
                    <li><strong>Connect:</strong> Join the virtual call at your scheduled time using a computer, tablet, or smartphone.</li>
                    <li><strong>Consult:</strong> Discuss your health concerns with your doctor in real-time.</li>
                    <li><strong>Follow-up:</strong> Receive post-consultation instructions, prescriptions, and referrals electronically.</li>
                </ol>
                <div class="contact-details">
                    <p><strong>For more information or to book:</strong></p>
                    <p><i class="fas fa-globe mr-2 text-blue-600"></i> Virtual Consult Portal: <a href="https://yourhospital.com/virtual-consult" target="_blank" class="text-blue-600 hover:underline">yourhospital.com/virtual-consult</a></p>
                    <p><i class="fas fa-phone-alt mr-2 text-blue-600"></i> Support: <a href="tel:+01234567895" class="text-blue-600 hover:underline">+012 345 67895</a></p>
                    <p><i class="fas fa-video mr-2 text-blue-600"></i> Technical Support available during virtual consult hours.</p>
                </div>
            `
        },
        patientPortal: {
            title: "Patient Portal: Your Health, Your Control",
            content: `
                <p>Our secure online Patient Portal empowers you to take an active role in managing your healthcare. It's a centralized hub for all your medical information and communication with our hospital, accessible 24/7.</p>
                <h4>What You Can Do:</h4>
                <ul>
                    <li><strong>Manage Appointments:</strong> Schedule, reschedule, or cancel appointments with ease. View your upcoming and past appointments.</li>
                    <li><strong>View Lab & Imaging Results:</strong> Access your test results quickly and securely, often before your follow-up appointment.</li>
                    <li><strong>Request Prescriptions:</strong> Send refill requests directly to your doctor's office.</li>
                    <li><strong>Communicate with Care Team:</strong> Send secure, non-urgent messages to your physicians, nurses, and other care providers.</li>
                    <li><strong>Access Medical Records:</strong> View your comprehensive health history, including medications, immunizations, allergies, and summaries of your visits.</li>
                    <li><strong>Pay Bills:</strong> Conveniently pay your hospital bills online, view statements, and set up payment plans.</li>
                    <li><strong>Update Personal Information:</strong> Keep your contact and insurance details current.</li>
                    <li><strong>Educational Resources:</strong> Access a library of health information tailored to your conditions.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>Access the Patient Portal:</strong></p>
                    <p><i class="fas fa-user-circle mr-2 text-blue-600"></i> Login: <a href="https://yourhospital.com/patient-portal-login" target="_blank" class="text-blue-600 hover:underline">yourhospital.com/patient-portal-login</a></p>
                    <p><i class="fas fa-question-circle mr-2 text-blue-600"></i> For portal support or registration assistance: <a href="tel:+01234567896" class="text-blue-600 hover:underline">+012 345 67896</a></p>
                    <p><i class="fas fa-lock mr-2 text-blue-600"></i> Your privacy and data security are our top priorities.</p>
                </div>
            `
        },
        wellnessPrograms: {
            title: "Holistic Wellness Programs: Nurturing Your Well-being",
            content: `
                <p>Beyond treating illness, we believe in promoting overall health and well-being. Our holistic wellness programs are designed to support your physical, mental, and emotional health, helping you lead a healthier, more fulfilling life.</p>
                <h4>Programs Offered:</h4>
                <ul>
                    <li><strong>Nutrition Counseling:</strong> Personalized dietary plans for various health goals, including diabetes management, weight loss, heart health, and digestive issues. Sessions with registered dietitians.</li>
                    <li><strong>Fitness Classes:</strong> A variety of group classes including gentle yoga, Pilates, low-impact aerobics, strength training, and balance exercises, suitable for all fitness levels and conditions.</li>
                    <li><strong>Mental Health Support:</strong> Workshops on stress management, mindfulness, meditation, and access to individual and group counseling services with licensed therapists.</li>
                    <li><strong>Chronic Disease Management:</strong> Educational programs and support groups for conditions like arthritis, diabetes, hypertension, and heart disease, focusing on self-management strategies.</li>
                    <li><strong>Preventive Health Screenings:</strong> Regular check-ups, health risk assessments, and screenings to detect potential health issues early and promote proactive health.</li>
                    <li><strong>Smoking Cessation:</strong> Programs and support to help you quit smoking.</li>
                    <li><strong>Sleep Hygiene Workshops:</strong> Learn strategies for improving sleep quality.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>Explore our Wellness Programs:</strong></p>
                    <p><i class="fas fa-globe mr-2 text-blue-600"></i> View Programs: <a href="https://yourhospital.com/wellness" target="_blank" class="text-blue-600 hover:underline">yourhospital.com/wellness</a></p>
                    <p><i class="fas fa-envelope mr-2 text-blue-600"></i> Email: <a href="mailto:wellness@yourhospital.com" class="text-blue-600 hover:underline">wellness@yourhospital.com</a></p>
                    <p><i class="fas fa-calendar-check mr-2 text-blue-600"></i> Register for upcoming workshops and classes online.</p>
                </div>
            `
        },
        communityHealth: {
            title: "Community Health Initiatives: Partnering for a Healthier Community",
            content: `
                <p>We are deeply committed to the health and well-being of our community. Our outreach programs and initiatives aim to provide health education, preventive care, and support to those in need, fostering a healthier environment for everyone.</p>
                <h4>Our Initiatives Include:</h4>
                <ul>
                    <li><strong>Free Health Screenings:</strong> Regular blood pressure, glucose, cholesterol, and basic cancer screenings offered at local community centers and events.</li>
                    <li><strong>Health Education Workshops:</strong> Interactive sessions on topics like healthy eating, disease prevention, managing chronic conditions, first aid, and emergency preparedness.</li>
                    <li><strong>Vaccination Drives:</strong> Seasonal flu shots, COVID-19 vaccinations, and other essential immunizations provided in accessible community locations.</li>
                    <li><strong>Support Groups:</strong> Facilitating various support groups for patients and caregivers dealing with specific health conditions (e.g., cancer, diabetes, grief).</li>
                    <li><strong>School Health Programs:</strong> Partnering with local schools to promote healthy habits among children and adolescents.</li>
                    <li><strong>Mobile Health Clinics:</strong> Bringing essential healthcare services directly to underserved areas.</li>
                    <li><strong>Partnerships:</strong> Collaborating with local businesses, non-profits, and government agencies to address community health needs.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>Get Involved or Learn More:</strong></p>
                    <p><i class="fas fa-globe mr-2 text-blue-600"></i> Community Page: <a href="https://yourhospital.com/community" target="_blank" class="text-blue-600 hover:underline">yourhospital.com/community</a></p>
                    <p><i class="fas fa-envelope mr-2 text-blue-600"></i> Email: <a href="mailto:community@yourhospital.com" class="text-blue-600 hover:underline">community@yourhospital.com</a></p>
                    <p><i class="fas fa-calendar-alt mr-2 text-blue-600"></i> View our community event calendar.</p>
                </div>
            `
        },
        careerOpportunities: {
            title: "Career Opportunities: Join Our Dedicated Team",
            content: `
                <p>Are you a passionate and skilled healthcare professional looking to make a difference? Our hospital offers a dynamic and supportive environment where you can grow your career and contribute to exceptional patient care.</p>
                <h4>Why Work With Us?</h4>
                <ul>
                    <li><strong>Commitment to Excellence:</strong> Be part of a leading healthcare institution renowned for its patient outcomes and innovative research.</li>
                    <li><strong>Professional Growth:</strong> Extensive opportunities for continuous learning, professional development, specialized training, and career advancement programs.</li>
                    <li><strong>Supportive Environment:</strong> A collaborative, empathetic, and inclusive workplace culture that values teamwork and employee well-being.</li>
                    <li><strong>Comprehensive Benefits:</strong> Competitive salaries, robust health insurance plans (medical, dental, vision), generous retirement plans, paid time off, and wellness programs.</li>
                    <li><strong>Cutting-Edge Technology:</strong> Work with the latest medical technologies and facilities.</li>
                    <li><strong>Research Opportunities:</strong> Participate in groundbreaking clinical trials and research studies.</li>
                </ul>
                <h4>Current Openings Include:</h4>
                <ul>
                    <li>Physicians (across all specialties, including new fellowships)</li>
                    <li>Registered Nurses (RNs) - all units (ICU, ER, Med-Surg, OR, Pediatrics)</li>
                    <li>Medical Technologists & Lab Scientists</li>
                    <li>Physical, Occupational, and Speech Therapists</li>
                    <li>Radiology Technicians & Imaging Specialists</li>
                    <li>Pharmacists & Pharmacy Technicians</li>
                    <li>Administrative Staff (Patient Services, Medical Records, Billing)</li>
                    <li>Patient Care Technicians & Medical Assistants</li>
                    <li>IT Professionals (Healthcare IT, Cybersecurity)</li>
                    <li>Research Coordinators</li>
                </ul>
                <div class="contact-details">
                    <p><strong>Explore Career Opportunities:</strong></p>
                    <p><i class="fas fa-briefcase mr-2 text-blue-600"></i> View Openings: <a href="https://yourhospital.com/careers" target="_blank" class="text-blue-600 hover:underline">yourhospital.com/careers</a></p>
                    <p><i class="fas fa-envelope mr-2 text-blue-600"></i> HR Department: <a href="mailto:hr@yourhospital.com" class="text-blue-600 hover:underline">hr@yourhospital.com</a></p>
                    <p><i class="fas fa-calendar-alt mr-2 text-blue-600"></i> Attend our virtual career fairs.</p>
                </div>
            `
        },
        pharmacyServices: {
            title: "Pharmacy Services: Your Health, Our Priority",
            content: `
                <p>Our hospital pharmacy provides comprehensive services to meet all your medication needs, ensuring safe and effective treatment. We focus on patient education and convenient access to prescriptions.</p>
                <h4>Our Pharmacy Services:</h4>
                <ul>
                    <li><strong>Prescription Fulfillment:</strong> Fast and accurate dispensing of both inpatient and outpatient prescriptions.</li>
                    <li><strong>Medication Counseling:</strong> Pharmacists are available to discuss your medications, potential side effects, and proper usage.</li>
                    <li><strong>Medication Synchronization:</strong> Coordinate all your refills to be picked up on a single day each month.</li>
                    <li><strong>Specialty Pharmacy:</strong> Expert handling of complex medications for chronic conditions.</li>
                    <li><strong>Over-the-Counter (OTC) Products:</strong> A wide selection of non-prescription medications and health products.</li>
                    <li><strong>Medication Delivery:</strong> Convenient home delivery options for eligible prescriptions.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>To contact our Pharmacy:</strong></p>
                    <p><i class="fas fa-phone-alt mr-2 text-blue-600"></i> Pharmacy Desk: <a href="tel:+01234567897" class="text-blue-600 hover:underline">+012 345 67897</a></p>
                    <p><i class="fas fa-clock mr-2 text-blue-600"></i> Hours: Monday - Friday, 8:00 AM - 8:00 PM; Saturday, 9:00 AM - 5:00 PM</p>
                    <p><i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> Location: Ground Floor, Main Lobby</p>
                </div>
            `
        },
        pediatricCare: {
            title: "Pediatric Care: Nurturing Our Youngest Patients",
            content: `
                <p>Our Pediatric Department is dedicated to providing compassionate and comprehensive medical care for infants, children, and adolescents. Our child-friendly environment and expert team ensure the best possible outcomes for your little ones.</p>
                <h4>Our Pediatric Services:</h4>
                <ul>
                    <li><strong>Well-Child Visits:</strong> Routine check-ups, immunizations, and developmental screenings from birth through adolescence.</li>
                    <li><strong>Acute Illness Care:</strong> Diagnosis and treatment for common childhood illnesses like colds, flu, infections, and allergies.</li>
                    <li><strong>Chronic Disease Management:</strong> Specialized care for conditions such as asthma, diabetes, and ADHD.</li>
                    <li><strong>Pediatric Subspecialties:</strong> Access to pediatric cardiologists, neurologists, oncologists, and surgeons.</li>
                    <li><strong>Emergency Pediatric Care:</strong> Dedicated pediatric emergency room services for urgent situations.</li>
                    <li><strong>Child Life Specialists:</strong> Support to help children cope with medical procedures and hospitalization.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>To contact our Pediatric Department:</strong></p>
                    <p><i class="fas fa-phone-alt mr-2 text-blue-600"></i> Pediatric Clinic: <a href="tel:+01234567898" class="text-blue-600 hover:underline">+012 345 67898</a></p>
                    <p><i class="fas fa-clock mr-2 text-blue-600"></i> Clinic Hours: Monday - Friday, 8:00 AM - 6:00 PM; Saturday, 9:00 AM - 1:00 PM</p>
                    <p><i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> Location: Pediatric Wing, 2nd Floor</p>
                </div>
            `
        },
        dentalHealth: {
            title: "Dental Health Services: A Brighter Smile, A Healthier You",
            content: `
                <p>Our comprehensive Dental Health Services ensure your oral health is in excellent hands. From routine check-ups to specialized procedures, we provide top-notch care for all ages.</p>
                <h4>Our Dental Services:</h4>
                <ul>
                    <li><strong>General Dentistry:</strong> Routine examinations, cleanings, fillings, and preventive care.</li>
                    <li><strong>Cosmetic Dentistry:</strong> Teeth whitening, veneers, and bonding for a brighter smile.</li>
                    <li><strong>Orthodontics:</strong> Braces and clear aligners for teeth straightening.</li>
                    <li><strong>Periodontics:</strong> Treatment for gum disease and related conditions.</li>
                    <li><strong>Oral Surgery:</strong> Tooth extractions, wisdom teeth removal, and dental implants.</li>
                    <li><strong>Pediatric Dentistry:</strong> Specialized dental care for children.</li>
                    <li><strong>Emergency Dental Care:</strong> Urgent treatment for dental pain, injuries, and infections.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>To contact our Dental Clinic:</strong></p>
                    <p><i class="fas fa-phone-alt mr-2 text-blue-600"></i> Dental Clinic: <a href="tel:+01234567899" class="text-blue-600 hover:underline">+012 345 67899</a></p>
                    <p><i class="fas fa-clock mr-2 text-blue-600"></i> Clinic Hours: Monday - Friday, 8:30 AM - 5:30 PM</p>
                    <p><i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> Location: Dental Clinic, 1st Floor, Outpatient Building</p>
                </div>
            `
        },
        neurologyDept: {
            title: "Neurology Department: Expert Care for Brain & Spine",
            content: `
                <p>Our Neurology Department offers advanced diagnosis and treatment for a wide range of neurological conditions affecting the brain, spinal cord, and nervous system. Our team of neurologists, neurosurgeons, and specialists provides comprehensive, patient-centered care.</p>
                <h4>Conditions We Treat:</h4>
                <ul>
                    <li><strong>Stroke:</strong> Rapid diagnosis and treatment for ischemic and hemorrhagic strokes, including rehabilitation.</li>
                    <li><strong>Epilepsy:</strong> Diagnosis, medication management, and advanced surgical options for seizure disorders.</li>
                    <li><strong>Parkinson's Disease & Movement Disorders:</strong> Comprehensive care, including medication, deep brain stimulation (DBS), and physical therapy.</li>
                    <li><strong>Multiple Sclerosis (MS):</strong> Diagnosis, disease-modifying therapies, and symptom management.</li>
                    <li><strong>Headaches & Migraines:</strong> Specialized clinics for chronic headache management.</li>
                    <li><strong>Neuromuscular Disorders:</strong> Conditions like ALS, myasthenia gravis, and neuropathies.</li>
                    <li><strong>Brain Tumors:</strong> Collaborative care with neurosurgery and oncology.</li>
                </ul>
                <h4>Our Facilities:</h4>
                <ul>
                    <li>State-of-the-art neuroimaging (MRI, CT, PET).</li>
                    <li>Dedicated neurophysiology lab (EEG, EMG).</li>
                    <li>Comprehensive stroke center.</li>
                    <li>Neuro-rehabilitation services.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>To contact our Neurology Department:</strong></p>
                    <p><i class="fas fa-phone-alt mr-2 text-blue-600"></i> Neurology Clinic: <a href="tel:+01234567800" class="text-blue-600 hover:underline">+012 345 67800</a></p>
                    <p><i class="fas fa-clock mr-2 text-blue-600"></i> Clinic Hours: Monday - Friday, 8:00 AM - 5:00 PM</p>
                    <p><i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> Location: Neurology Wing, 3rd Floor</p>
                </div>
            `
        },
        pulmonaryCare: {
            title: "Pulmonary & Respiratory Care: Breathing Easier",
            content: `
                <p>Our Pulmonary and Respiratory Care Department provides expert diagnosis and treatment for a wide range of lung and breathing conditions. Our pulmonologists, respiratory therapists, and specialized nurses are dedicated to helping you breathe easier and improve your quality of life.</p>
                <h4>Conditions We Treat:</h4>
                <ul>
                    <li><strong>Asthma:</strong> Comprehensive management plans, including medication and lifestyle adjustments.</li>
                    <li><strong>Chronic Obstructive Pulmonary Disease (COPD):</strong> Advanced therapies and rehabilitation programs.</li>
                    <li><strong>Pneumonia & Bronchitis:</strong> Diagnosis and treatment of acute respiratory infections.</li>
                    <li><strong>Sleep Apnea:</strong> Diagnosis and management of sleep-related breathing disorders.</li>
                    <li><strong>Cystic Fibrosis:</strong> Specialized care for this complex genetic condition.</li>
                    <li><strong>Lung Cancer:</strong> Collaborative care with oncology for diagnosis and treatment.</li>
                    <li><strong>Pulmonary Fibrosis:</strong> Management of interstitial lung diseases.</li>
                </ul>
                <h4>Services Offered:</h4>
                <ul>
                    <li>Pulmonary Function Testing (PFT).</li>
                    <li>Bronchoscopy.</li>
                    <li>Oxygen therapy.</li>
                    <li>Pulmonary rehabilitation programs.</li>
                    <li>Sleep studies.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>To contact our Pulmonary Department:</strong></p>
                    <p><i class="fas fa-phone-alt mr-2 text-blue-600"></i> Pulmonary Clinic: <a href="tel:+01234567801" class="text-blue-600 hover:underline">+012 345 67801</a></p>
                    <p><i class="fas fa-clock mr-2 text-blue-600"></i> Clinic Hours: Monday - Friday, 8:00 AM - 5:00 PM</p>
                    <p><i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> Location: Pulmonary Institute, 4th Floor</p>
                </div>
            `
        },
        orthopedicCare: {
            title: "Orthopedic & Sports Medicine: Restoring Movement",
            content: `
                <p>Our Orthopedic and Sports Medicine Department provides specialized care for conditions affecting bones, joints, muscles, ligaments, and tendons. Our expert team helps patients recover from injuries, manage chronic conditions, and regain mobility.</p>
                <h4>Conditions We Treat:</h4>
                <ul>
                    <li><strong>Sports Injuries:</strong> Sprains, strains, ligament tears (ACL, meniscus), and fractures.</li>
                    <li><strong>Arthritis:</strong> Comprehensive management for osteoarthritis, rheumatoid arthritis, and other joint conditions.</li>
                    <li><strong>Fractures:</strong> Diagnosis and treatment for all types of bone breaks.</li>
                    <li><strong>Joint Replacement:</strong> Advanced surgical options for hip, knee, and shoulder replacements.</li>
                    <li><strong>Spine Conditions:</strong> Treatment for back pain, disc herniations, and spinal deformities.</li>
                    <li><strong>Hand & Wrist Conditions:</strong> Carpal tunnel syndrome, tendonitis, and fractures.</li>
                </ul>
                <h4>Services Offered:</h4>
                <ul>
                    <li>Diagnostic imaging (X-ray, MRI, CT).</li>
                    <li>Physical therapy and rehabilitation.</li>
                    <li>Minimally invasive surgery.</li>
                    <li>Pain management.</li>
                    <li>Sports performance enhancement.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>To contact our Orthopedic Department:</strong></p>
                    <p><i class="fas fa-phone-alt mr-2 text-blue-600"></i> Orthopedic Clinic: <a href="tel:+01234567802" class="text-blue-600 hover:underline">+012 345 67802</a></p>
                    <p><i class="fas fa-clock mr-2 text-blue-600"></i> Clinic Hours: Monday - Friday, 8:00 AM - 6:00 PM</p>
                    <p><i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> Location: Orthopedic Center, 1st Floor</p>
                </div>
            `
        },
        maternityServices: {
            title: "Maternity & Birthing Services: A New Beginning",
            content: `
                <p>Our Maternity and Birthing Services provide comprehensive care for expectant mothers, from prenatal through postpartum. We offer a supportive and nurturing environment for a safe and memorable birthing experience.</p>
                <h4>Our Services Include:</h4>
                <ul>
                    <li><strong>Prenatal Care:</strong> Regular check-ups, ultrasounds, and genetic counseling.</li>
                    <li><strong>Birthing Suites:</strong> State-of-the-art, comfortable birthing rooms with advanced monitoring.</li>
                    <li><strong>Labor & Delivery:</strong> Experienced obstetricians, nurses, and anesthesiologists providing personalized care during labor.</li>
                    <li><strong>Postpartum Care:</strong> Support for new mothers, including breastfeeding assistance and emotional well-being checks.</li>
                    <li><strong>Neonatal Intensive Care Unit (NICU):</strong> Advanced care for premature or critically ill newborns.</li>
                    <li><strong>Childbirth Education Classes:</strong> Prepared childbirth, breastfeeding, and newborn care classes.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>To contact our Maternity Services:</strong></p>
                    <p><i class="fas fa-phone-alt mr-2 text-blue-600"></i> Maternity Desk: <a href="tel:+01234567803" class="text-blue-600 hover:underline">+012 345 67803</a></p>
                    <p><i class="fas fa-clock mr-2 text-blue-600"></i> Office Hours: Monday - Friday, 9:00 AM - 5:00 PM</p>
                    <p><i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> Location: Women's Health Center, 5th Floor</p>
                </div>
            `
        },
        cardiacCare: {
            title: "Cardiac Care Center: For a Healthy Heart",
            content: `
                <p>Our Cardiac Care Center offers leading-edge diagnostics and treatments for a full spectrum of heart conditions. Our team of cardiologists, cardiac surgeons, and specialized nurses are dedicated to providing exceptional heart care.</p>
                <h4>Conditions We Treat:</h4>
                <ul>
                    <li><strong>Coronary Artery Disease (CAD):</strong> Diagnosis and management of blocked arteries.</li>
                    <li><strong>Heart Failure:</strong> Comprehensive programs for managing weakened heart muscle.</li>
                    <li><strong>Arrhythmias:</strong> Treatment for irregular heartbeats, including ablation and pacemaker implantation.</li>
                    <li><strong>Valvular Heart Disease:</strong> Repair and replacement of heart valves.</li>
                    <li><strong>Hypertension:</strong> Management of high blood pressure.</li>
                    <li><strong>Congenital Heart Defects:</strong> Care for heart conditions present at birth.</li>
                </ul>
                <h4>Services Offered:</h4>
                <ul>
                    <li>Advanced diagnostic imaging (ECG, Echocardiogram, Stress Tests, Cardiac MRI).</li>
                    <li>Interventional Cardiology (Angioplasty, Stenting).</li>
                    <li>Cardiac Surgery (Bypass surgery, Valve repair/replacement).</li>
                    <li>Cardiac Rehabilitation.</li>
                    <li>Preventative Cardiology.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>To contact our Cardiac Care Center:</strong></p>
                    <p><i class="fas fa-phone-alt mr-2 text-blue-600"></i> Cardiac Clinic: <a href="tel:+01234567804" class="text-blue-600 hover:underline">+012 345 67804</a></p>
                    <p><i class="fas fa-clock mr-2 text-blue-600"></i> Clinic Hours: Monday - Friday, 8:00 AM - 5:00 PM</p>
                    <p><i class="fas fa-map-marker-alt mr-2 text-blue-600"></i> Location: Heart Institute, 6th Floor</p>
                </div>
            `
        },
        researchTrials: {
            title: "Research & Clinical Trials: Advancing Medicine",
            content: `
                <p>Our hospital is at the forefront of medical innovation, conducting groundbreaking research and clinical trials to discover new treatments and improve patient outcomes. Participating in a trial can offer access to cutting-edge therapies.</p>
                <h4>Why Participate?</h4>
                <ul>
                    <li>Access to new, experimental treatments before they are widely available.</li>
                    <li>Receive close medical attention from leading specialists.</li>
                    <li>Contribute to medical science and help future patients.</li>
                    <li>Compensation for time and travel may be available for some trials.</li>
                </ul>
                <h4>Areas of Research:</h4>
                <ul>
                    <li>Oncology (Cancer Research)</li>
                    <li>Cardiology (Heart Health)</li>
                    <li>Neurology (Brain & Nervous System Disorders)</li>
                    <li>Autoimmune Diseases</li>
                    <li>Infectious Diseases</li>
                    <li>Pediatrics</li>
                </ul>
                <div class="contact-details">
                    <p><strong>To learn more about Research & Clinical Trials:</strong></p>
                    <p><i class="fas fa-phone-alt mr-2 text-blue-600"></i> Research Coordinator: <a href="tel:+01234567805" class="text-blue-600 hover:underline">+012 345 67805</a></p>
                    <p><i class="fas fa-envelope mr-2 text-blue-600"></i> Email: <a href="mailto:research@yourhospital.com" class="text-blue-600 hover:underline">research@yourhospital.com</a></p>
                    <p><i class="fas fa-globe mr-2 text-blue-600"></i> View Current Trials: <a href="https://yourhospital.com/clinical-trials" target="_blank" class="text-blue-600 hover:underline">yourhospital.com/clinical-trials</a></p>
                </div>
            `
        },
        patientSupport: {
            title: "Patient & Family Support: Caring for You Completely",
            content: `
                <p>We understand that a hospital stay or managing a chronic condition can be challenging. Our Patient and Family Support services are designed to provide holistic care, addressing not just medical needs but also emotional, social, and practical concerns.</p>
                <h4>Services Offered:</h4>
                <ul>
                    <li><strong>Patient Navigators:</strong> Guidance through your healthcare journey, from appointments to understanding diagnoses.</li>
                    <li><strong>Social Work Services:</strong> Assistance with discharge planning, connecting to community resources, and emotional support.</li>
                    <li><strong>Spiritual Care:</strong> Support for patients and families of all faiths and beliefs.</li>
                    <li><strong>Nutritional Counseling:</strong> Registered dietitians provide personalized dietary advice.</li>
                    <li><strong>Financial Counseling:</strong> Help understanding billing and exploring financial assistance options.</li>
                    <li><strong>Support Groups:</strong> Facilitated groups for various conditions and for caregivers.</li>
                    <li><strong>Translation Services:</strong> Available for patients with limited English proficiency.</li>
                    <li><strong>Child Life Services:</strong> Support for pediatric patients and their families.</li>
                </ul>
                <div class="contact-details">
                    <p><strong>To contact Patient & Family Support:</strong></p>
                    <p><i class="fas fa-phone-alt mr-2 text-blue-600"></i> Support Services: <a href="tel:+01234567806" class="text-blue-600 hover:underline">+012 345 67806</a></p>
                    <p><i class="fas fa-envelope mr-2 text-blue-600"></i> Email: <a href="mailto:patientsupport@yourhospital.com" class="text-blue-600 hover:underline">patientsupport@yourhospital.com</a></p>
                    <p><i class="fas fa-info-circle mr-2 text-blue-600"></i> Available during hospital operating hours.</p>
                </div>
            `
        }
    };


    const queryModalOverlay = document.getElementById('queryModalOverlay');
    const modalTitle = document.getElementById('modalTitle');
    const modalContent = document.getElementById('modalContent');
    const closeModalButton = document.getElementById('closeModal');

    // Event listeners for Query Links buttons (using event delegation for efficiency)
    document.querySelector('.query-grid').addEventListener('click', function(event) {
        const button = event.target.closest('.btn-query');
        if (button) {
            const queryType = button.dataset.queryType;
            const details = queryDetails[queryType];

            if (details) {
                modalTitle.textContent = details.title;
                modalContent.innerHTML = details.content;
                queryModalOverlay.classList.add('active');
            }
        }
    });

    closeModalButton.addEventListener('click', function() {
        queryModalOverlay.classList.remove('active');
    });

    // Close query modal if clicked outside content
    queryModalOverlay.addEventListener('click', function(event) {
        if (event.target === queryModalOverlay) {
            queryModalOverlay.classList.remove('active');
        }
    });

    // Carousel / Slideshow JavaScript
    const carouselTrack = document.getElementById('featureCarouselTrack');
    const carouselSlides = document.querySelectorAll('.carousel-slide');
    const carouselPrevBtn = document.getElementById('carouselPrev');
    const carouselNextBtn = document.getElementById('carouselNext');
    const carouselDotsContainer = document.getElementById('carouselDots');
    let currentIndex = 0;
    let autoSlideInterval;

    // Create dots for the carousel
    function createCarouselDots() {
        carouselDotsContainer.innerHTML = '';
        carouselSlides.forEach((_, index) => {
            const dot = document.createElement('span');
            dot.classList.add('carousel-dot');
            if (index === 0) {
                dot.classList.add('active');
            }
            dot.addEventListener('click', () => goToSlide(index));
            carouselDotsContainer.appendChild(dot);
        });
    }

    // Update carousel display
    function updateCarousel() {
        carouselTrack.style.transform = `translateX(-${currentIndex * 100}%)`;
        carouselSlides.forEach((slide, index) => {
            if (index === currentIndex) {
                slide.classList.add('active-slide');
            } else {
                slide.classList.remove('active-slide');
            }
        });
        document.querySelectorAll('.carousel-dot').forEach((dot, index) => {
            if (index === currentIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    // Go to a specific slide
    function goToSlide(index) {
        currentIndex = index;
        updateCarousel();
        resetAutoSlide();
    }

    // Go to next slide
    function nextSlide() {
        currentIndex = (currentIndex + 1) % carouselSlides.length;
        updateCarousel();
        resetAutoSlide();
    }

    // Go to previous slide
    function prevSlide() {
        currentIndex = (currentIndex - 1 + carouselSlides.length) % carouselSlides.length;
        updateCarousel();
        resetAutoSlide();
    }

    // Start auto-sliding
    function startAutoSlide() {
        autoSlideInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
    }

    // Reset auto-sliding (clear and restart)
    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        startAutoSlide();
    }

    // Event listeners for carousel buttons
    carouselNextBtn.addEventListener('click', nextSlide);
    carouselPrevBtn.addEventListener('click', prevSlide);

    // Initialize carousel
    document.addEventListener('DOMContentLoaded', () => {
        createCarouselDots();
        updateCarousel();
        startAutoSlide(); // Start auto-sliding when page loads
    });

    // Pause auto-slide on hover for better user experience
    carouselTrack.closest('.carousel-container').addEventListener('mouseenter', () => {
        clearInterval(autoSlideInterval);
    });

    carouselTrack.closest('.carousel-container').addEventListener('mouseleave', () => {
        startAutoSlide();
    });

    // Carousel Details Modal functionality
    const carouselModalOverlay = document.getElementById('carouselModalOverlay');
    const carouselModalTitle = document.getElementById('carouselModalTitle');
    const carouselModalContent = document.getElementById('carouselModalContent');
    const closeCarouselModalButton = document.getElementById('closeCarouselModal');

    // Event listener for carousel slide buttons
    document.getElementById('featureCarouselTrack').addEventListener('click', function(event) {
        const button = event.target.closest('.btn-carousel');
        if (button) {
            const modalType = button.dataset.modalType;
            const details = carouselDetails[modalType];

            if (details) {
                carouselModalTitle.textContent = details.title;
                carouselModalContent.innerHTML = details.content;
                carouselModalOverlay.classList.add('active');
            }
        }
    });

    closeCarouselModalButton.addEventListener('click', function() {
        carouselModalOverlay.classList.remove('active');
    });

    // Close carousel modal if clicked outside content
    carouselModalOverlay.addEventListener('click', function(event) {
        if (event.target === carouselModalOverlay) {
            carouselModalOverlay.classList.remove('active');
        }
    });

</script>

<?php
include('footer.php');
?>
