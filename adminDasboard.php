<?php
include("adminHeader.php");
?>

<style>
    body {
        background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 20%, #ff9a9e 40%, #fad0c4 60%, #fbc2eb 80%, #a6c1ee 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        background-attachment: fixed;
    }

    .dashboard-container {
        margin-top: 150px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 60vh;
        color: #444;
        text-shadow: 0px 0px 0px rgba(0,0,0,0.2);
    }

    .dashboard-title {
        font-size: 3rem;
        font-weight: 700;
        animation: float 3s ease-in-out infinite;
        color: #444;
    }

    .dashboard-subtitle {
        font-size: 1.2rem;
        margin-bottom: 30px;
        color: #333;
        letter-spacing: 1px;
    }

    .dashboard-card {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 15px;
        padding: 40px;
        width: 80%;
        max-width: 900px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: 0.3s;
    }

    .dashboard-card:hover {
        transform: scale(1.01);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
</style>

<div class="dashboard-container">
    <h1 class="dashboard-title">Welcome, ADMIN</h1>
    <p class="dashboard-subtitle">Meditronix Hospital Management System</p>

    <div class="dashboard-card">
        <h2 style="color: #333; font-weight: 600;">Your Secure Admin Control Panel</h2>
        <p style="font-size: 1rem; color: #555;">
            Monitor hospital operations, manage departments, and ensure smooth healthcare delivery with ease and precision.
        </p>
        <p style="font-size: 0.95rem; color: #777;">
            (Your features will appear here soon in a carousel format.)
        </p>
    </div>
</div>

<div style="font-family: Arial, sans-serif; background-color: #fffbea; padding: 50px; min-height: 100vh; color: #111;">

<?php
$conn = mysqli_connect("localhost", "root", "", "meditronix_new");
$doctors = mysqli_query($conn, "SELECT * FROM doctors");
$doctor_ids = [];
while($row = mysqli_fetch_assoc($doctors)) {
    $doctor_ids[] = $row['user_id'];
}
$doctor_cards = mysqli_query($conn, "SELECT * FROM doctors");
?>

<style>
h1 {
    text-align: center;
    color: #0f172a;
    font-size: 48px;
    margin-bottom: 10px;
}
h3, h4 {
    text-align: center;
    color: #333;
}
.chart-title {
    text-align: center;
    font-size: 32px;
    margin-top: 80px;
    color: #0f172a;
    font-weight: 600;
}
.chart-description {
    text-align: center;
    font-weight: normal;
    font-size: 18px;
    color: #444;
    margin: 10px auto 30px auto;
    max-width: 900px;
}
#chart-container {
    width: 95%;
    height: 600px;
    margin: 40px auto;
    background: linear-gradient(to bottom right, #fff, #fef4d7);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 0 30px rgba(0,0,0,0.05);
    position: relative;
}
canvas {
    width: 100% !important;
    height: 100% !important;
}

.carousel-wrapper {
    max-width: 90%;
    margin: 50px auto;
    position: relative;
    overflow: hidden;
}
.carousel-container {
    display: flex;
    gap: 30px;
    animation: slide 20s linear infinite;
}
@keyframes slide {
    0% { transform: translateX(0); }
    50% { transform: translateX(calc(-50%)); }
    100% { transform: translateX(0); }
}
.card {
    background-color: #fff;
    min-width: 300px;
    max-width: 300px;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(56, 189, 248, 0.2);
    flex-shrink: 0;
    transition: transform 0.3s;
}
.card:hover {
    transform: scale(1.05);
}
.card h4 {
    margin-top: 10px;
}
</style>

<h1>OUR PROFESSIONAL & DEDICATED DOCTORS</h1>
<h3>Your Health, Our Promise To Serve You With Care & Excellence.</h3>
<h4>Leading Expertise | Trusted Hands | Unmatched Dedication</h4>

<div class="carousel-wrapper">
    <div class="carousel-container">
        <?php while($doctor = mysqli_fetch_assoc($doctor_cards)) { ?>
            <div class="card">
                <h4>User ID: <?php echo $doctor['user_id']; ?></h4>
                <p><strong>Specialization:</strong> <?php echo $doctor['specialization']; ?></p>
                <p><strong>Experience:</strong> <?php echo $doctor['experience']; ?> Years</p>
                <p><strong>Availability:</strong> <?php echo $doctor['availability']; ?></p>
                <p><strong>Status:</strong> <?php echo $doctor['status']; ?></p>
                <p><strong>Joined On:</strong> <?php echo $doctor['created_at']; ?></p>
            </div>
        <?php } ?>
    </div>
</div>

<div class="chart-title">Doctor's User ID Overview</div>
<div class="chart-description">
    This graph visually represents each doctor’s unique User ID through dynamic charts. The transitions help you quickly understand how many doctors are registered, and the Bar Chart provides a clear breakdown for reporting.
</div>

<div id="chart-container">
    <canvas id="doctorChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('doctorChart').getContext('2d');
let chartType = 'bar';
const doctorIDs = <?php echo json_encode($doctor_ids); ?>;
const doctorData = doctorIDs.map(() => 1);

let myChart = new Chart(ctx, {
    type: chartType,
    data: {
        labels: doctorIDs,
        datasets: [{
            label: 'Doctor User IDs (Count Representation)',
            data: doctorData,
            backgroundColor: doctorIDs.map(() => `hsl(${Math.random()*360}, 70%, 60%)`),
            borderColor: '#0f172a',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            duration: 2000,
            easing: 'easeOutElastic'
        },
        plugins: {
            legend: {
                labels: {
                    color: '#0f172a',
                    font: {
                        size: 14
                    }
                }
            },
            tooltip: {
                backgroundColor: '#0f172a',
                titleColor: '#fff',
                bodyColor: '#fff'
            }
        },
        scales: {
            x: {
                ticks: { color: '#0f172a' },
                grid: { color: 'rgba(15, 23, 42, 0.1)' }
            },
            y: {
                beginAtZero: true,
                ticks: { color: '#0f172a' },
                grid: { color: 'rgba(15, 23, 42, 0.1)' }
            }
        }
    }
});

function transitionChart() {
    setTimeout(() => {
        myChart.destroy();
        myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: doctorIDs,
                datasets: [{
                    data: doctorData,
                    backgroundColor: doctorIDs.map(() => `hsl(${Math.random()*360}, 70%, 60%)`)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 2000 },
                plugins: { legend: { labels: { color: '#0f172a' } } }
            }
        });
    }, 4000);

    setTimeout(() => {
        myChart.destroy();
        myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: doctorIDs,
                datasets: [{
                    data: doctorData,
                    backgroundColor: doctorIDs.map(() => `hsl(${Math.random()*360}, 70%, 60%)`)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 2000 },
                plugins: { legend: { labels: { color: '#0f172a' } } }
            }
        });
    }, 8000);

    setTimeout(() => {
        myChart.destroy();
        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: doctorIDs,
                datasets: [{
                    label: 'Doctor User IDs (Count Representation)',
                    data: doctorData,
                    backgroundColor: doctorIDs.map(() => `hsl(${Math.random()*360}, 70%, 60%)`),
                    borderColor: '#0f172a',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 2000, easing: 'easeOutElastic' },
                plugins: {
                    legend: { labels: { color: '#0f172a' } }
                },
                scales: {
                    x: { ticks: { color: '#0f172a' }, grid: { color: 'rgba(15, 23, 42, 0.1)' } },
                    y: { beginAtZero: true, ticks: { color: '#0f172a' }, grid: { color: 'rgba(15, 23, 42, 0.1)' } }
                }
            }
        });
    }, 12000);
}

transitionChart();
setInterval(transitionChart, 16000);
</script>


<div class="container-fluid py-5 bg-gradient-animated">
    <div class="container py-5 position-relative z-10">
        <h1 class="text-center mb-3 display-3 fw-bold text-black text-shadow-subtle animate__animated animate__fadeInDown">
            <i class="fas fa-inbox me-3 text-primary animate__animated animate__pulse animate__infinite"></i>Client Inquiries Dashboard
        </h1>
        <p class="text-center mb-2 lead text-black-75 animate__animated animate__fadeInUp animate__delay-0-5s">
            "Your Voice, Our Priority. Connecting You to Solutions."
        </p>
        <p class="text-center mb-5 text-black-75 animate__animated animate__fadeInUp animate__delay-0-7s px-4">
            Browse through all incoming messages and feedback from your clients. This dashboard provides a clear overview of every interaction, helping us ensure that no query goes unanswered and every client feels heard and valued.
        </p>

        <div class="queries-grid d-flex flex-wrap justify-content-center align-items-stretch">
            <?php
            // Establish database connection
            $db = new mysqli("localhost", "root", "", "meditronix_new");
            if ($db->connect_error) {
                echo "<p class='text-center w-100 text-danger'>Failed to connect to the database. Please try again later.</p>";
                error_log("Database connection failed: " . $db->connect_error);
            } else {
                // IMPORTANT: Using backticks for the table name to handle the colon as a literal identifier.
                $query = "SELECT `id`, `name`, `email`, `subject`, `message`, `status`, `created_at` FROM `contact_queries:` ORDER BY `created_at` DESC";
                $result = $db->query($query);

                if ($result) {
                    $contactQueries = [];
                    while ($row = $result->fetch_assoc()) {
                        $contactQueries[] = $row;
                    }

                    // No duplication needed for a static grid layout
                    if (count($contactQueries) > 0) {
                        foreach ($contactQueries as $queryData):
                            // Assign a dynamic icon based on subject or a default
                            $iconClass = 'fas fa-question-circle'; // Default icon
                            if (stripos($queryData['subject'], 'support') !== false) {
                                $iconClass = 'fas fa-life-ring';
                            } elseif (stripos($queryData['subject'], 'feedback') !== false) {
                                $iconClass = 'fas fa-comment-alt';
                            } elseif (stripos($queryData['subject'], 'appointment') !== false) {
                                $iconClass = 'fas fa-calendar-check';
                            } elseif (stripos($queryData['subject'], 'enquiry') !== false) {
                                $iconClass = 'fas fa-info-circle';
                            }
            ?>
                            <div class="query-card p-4 m-3 rounded-xl shadow-2xl text-center position-relative d-flex flex-column justify-content-between animate__animated animate__zoomIn">
                                <div class="water-overlay"></div>
                                <div class="glitter-overlay"></div>
                                <div class="query-card-content position-relative z-10 d-flex flex-column h-100">
                                    <div class="card-icon mb-3 animate__animated animate__bounceIn">
                                        <i class="<?php echo $iconClass; ?> fa-3x text-primary icon-glow"></i>
                                    </div>
                                    <h3 class="mb-2 text-solid-black text-gradient-shine"><?php echo htmlspecialchars($queryData['name']); ?></h3>
                                    <p class="mb-1 text-dark-grey small fw-bold"><?php echo htmlspecialchars($queryData['email']); ?></p>
                                    <p class="mb-3 text-dark-grey fw-bold text-uppercase"><?php echo htmlspecialchars($queryData['subject']); ?></p>
                                    <p class="mb-3 text-dark-grey flex-grow-1 text-justify query-message"><?php echo htmlspecialchars($queryData['message']); ?></p>
                                    <p class="fw-bold text-success mb-2 status-text">Status: <span class="badge bg-<?php echo ($queryData['status'] == 'active' ? 'success' : 'warning'); ?> status-badge"><?php echo htmlspecialchars($queryData['status']); ?></span></p>
                                    <p class="text-muted small">Created: <?php echo htmlspecialchars($queryData['created_at']); ?></p>
                                    <div class="social-links mt-auto d-flex justify-content-center align-items-center">
                                        <a href="https://www.facebook.com/yourpage" target="_blank" class="text-primary mx-2 social-icon"><i class="fab fa-facebook-f fa-2x"></i></a>
                                        <a href="https://www.twitter.com/yourpage" target="_blank" class="text-info mx-2 social-icon"><i class="fab fa-twitter fa-2x"></i></a>
                                        <a href="https://www.linkedin.com/yourpage" target="_blank" class="text-secondary mx-2 social-icon"><i class="fab fa-linkedin-in fa-2x"></i></a>
                                    </div>
                                </div>
                            </div>
            <?php
                        endforeach;
                    } else {
                        echo "<p class='text-center w-100 text-muted'>No contact queries found.</p>";
                    }
                } else {
                    echo "<p class='text-center w-100 text-danger'>Error fetching queries: " . $db->error . "</p>";
                    error_log("Database query failed: " . $db->error);
                }
                $db->close();
            }
            ?>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    /* Global styles for body and fonts */
    body {
        font-family: 'Inter', sans-serif;
        overflow-x: hidden; /* Prevent horizontal scrollbar from layout issues */
        perspective: 1000px; /* For 3D transformations */
    }

    /* Custom Background with subtle contact theme */
    .bg-gradient-animated {
        background: linear-gradient(135deg, #f0f8ff, #f5f5dc, #fff0f5, #f0fff0, #f8f8ff, #e0ffff); /* Light rainbow colors */
        background-size: 600% 600%;
        animation: gradientAnimation 25s ease infinite;
        position: relative;
        overflow: hidden;
    }

    /* Subtle background pattern for contact theme */
    .bg-gradient-animated::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><path fill="%23e0e0e0" d="M10 0h80v100H10zM0 10h100v80H0z"/><path fill="%23d0d0d0" d="M20 0h60v100H20zM0 20h100v60H0z"/><path fill="%23c0c0c0" d="M30 0h40v100H30zM0 30h100v40H0z"/><path fill="%23b0b0b0" d="M40 0h20v100H40zM0 40h100v20H0z"/></svg>') repeat;
        background-size: 150px 150px;
        opacity: 0.1; /* Very subtle */
        z-index: 0;
        animation: backgroundPatternMove 120s linear infinite;
    }

    @keyframes backgroundPatternMove {
        from { background-position: 0 0; }
        to { background-position: 100% 100%; }
    }

    @keyframes gradientAnimation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Header and Subheader Styling */
    .text-black {
        color: #000000 !important;
    }

    .text-black-75 {
        color: rgba(0, 0, 0, 0.75) !important;
    }

    .text-shadow-subtle {
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2); /* Subtle shadow for readability on light background */
    }

    /* Queries Grid Container */
    .queries-grid {
        gap: 30px; /* Space between cards */
        justify-content: center; /* Center cards horizontally */
        align-items: stretch; /* Ensure cards stretch to equal height in a row */
        padding: 20px; /* Padding around the grid */
    }

    /* Query Card Styling */
    .query-card {
        width: calc(33.333% - 60px); /* 3 cards per row with margin */
        min-width: 350px; /* Minimum width to prevent squishing on smaller screens */
        min-height: 550px; /* Set a minimum height, but allow it to grow for content */
        background-color: rgba(255, 255, 255, 0.8); /* More opaque white for contrast */
        backdrop-filter: blur(8px) saturate(1.2); /* Glassmorphism effect with saturation */
        border: 1px solid rgba(0, 0, 0, 0.1); /* Subtle border */
        transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Smooth transition */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15), inset 0 0 15px rgba(255,255,255,0.3); /* Lighter shadow with inner glow */
        position: relative;
        cursor: pointer;
        display: flex; /* Changed to flex for vertical alignment of content */
        flex-direction: column;
        flex-shrink: 0; /* Prevent shrinking */
        margin: 0; /* Margin handled by gap in grid */
        transform-origin: center center; /* For 3D rotation */
        backface-visibility: hidden; /* Prevents flickering in 3D */
        overflow: hidden; /* Keep water overlay contained */
        animation: floatAnimation 6s ease-in-out infinite alternate; /* Subtle floating animation */
    }

    @keyframes floatAnimation {
        0% { transform: translateY(0px) rotateX(0deg); }
        50% { transform: translateY(-5px) rotateX(1deg); }
        100% { transform: translateY(0px) rotateX(0deg); }
    }

    .query-card:hover {
        transform: translateY(-15px) scale(1.03) rotateY(5deg); /* 3D tilt on hover */
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.25), 0 0 25px rgba(0, 123, 255, 0.3), inset 0 0 20px rgba(255,255,255,0.5); /* Enhanced shadow and subtle glow */
        border-color: rgba(0, 123, 255, 0.4);
        filter: brightness(1.1); /* Slightly brighter on hover */
    }

    /* Border animation on hover */
    .query-card::after {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        border-radius: inherit;
        background: linear-gradient(45deg, #007bff, #28a745, #007bff);
        z-index: -1;
        opacity: 0;
        transition: opacity 0.5s ease;
        filter: blur(5px);
    }

    .query-card:hover::after {
        opacity: 1;
    }

    /* Shining Effect on Hover */
    .query-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 50%;
        height: 100%;
        background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.7) 70%, rgba(255, 255, 255, 0) 100%);
        transform: skewX(-20deg);
        transition: all 0.7s ease-in-out;
        z-index: 10;
        opacity: 0;
    }

    .query-card:hover::before {
        left: 150%;
        opacity: 1;
    }

    /* Water Overlay Effect */
    .water-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 0; /* Starts hidden */
        background: linear-gradient(to top, rgba(0, 123, 255, 0.6), rgba(0, 123, 255, 0.3)); /* Lighter gradient for water */
        transition: height 0.6s cubic-bezier(0.19, 1, 0.22, 1); /* Smoother fill */
        z-index: 0; /* Below content */
        border-radius: 0 0 1rem 1rem; /* Rounded bottom corners */
        box-shadow: inset 0 0 20px rgba(0, 123, 255, 0.2); /* Inner glow for water */
        filter: blur(2px); /* Subtle blur for water effect */
    }

    .query-card:hover .water-overlay {
        height: 100%; /* Fills up on hover */
    }

    /* Glitter Overlay Effect */
    .glitter-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="25" cy="25" r="2" fill="rgba(255,255,255,0.8)"/><circle cx="75" cy="75" r="2" fill="rgba(255,255,255,0.8)"/><circle cx="50" cy="10" r="1.5" fill="rgba(255,255,255,0.6)"/><circle cx="10" cy="50" r="1.5" fill="rgba(255,255,255,0.6)"/><circle cx="90" cy="50" r="1.5" fill="rgba(255,255,255,0.6)"/><circle cx="50" cy="90" r="1.5" fill="rgba(255,255,255,0.6)"/></svg>');
        background-size: 10% 10%;
        opacity: 0;
        transition: opacity 0.5s ease;
        animation: glitterMove 10s linear infinite;
        z-index: 1; /* Above water, below content */
        pointer-events: none; /* Allow clicks to pass through */
    }

    .query-card:hover .glitter-overlay {
        opacity: 0.7;
    }

    @keyframes glitterMove {
        from { background-position: 0 0; }
        to { background-position: 100% 100%; }
    }


    /* Ensure content is above water overlay */
    .query-card-content {
        position: relative;
        z-index: 2;
        padding: 25px; /* Increased padding for inner content */
        padding-bottom: 25px; /* Adjusted padding to give more space for social links */
        color: #000000; /* Solid black text */
        display: flex; /* Ensure flex properties for content */
        flex-direction: column;
        height: 100%; /* Take full height of the card */
    }

    .card-icon {
        color: #007bff;
        text-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    }

    .icon-glow {
        animation: pulseIcon 2s infinite alternate;
    }

    @keyframes pulseIcon {
        0% { text-shadow: 0 0 5px rgba(0, 123, 255, 0.5); }
        100% { text-shadow: 0 0 15px rgba(0, 123, 255, 0.8); }
    }

    .query-card h3 {
        font-size: 2.2rem;
        position: relative;
        padding-bottom: 10px;
        color: #000000; /* Solid black for title */
    }

    .text-solid-black {
        color: #000000 !important; /* Explicitly solid black */
    }

    .text-gradient-shine {
        background: linear-gradient(45deg, #000000, #333333, #000000);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: 200% auto;
        animation: textShine 3s linear infinite;
    }

    @keyframes textShine {
        0% { background-position: 0% 50%; }
        100% { background-position: 200% 50%; }
    }


    .query-card p.text-dark-grey {
        color: #333333; /* Dark grey for description */
        line-height: 1.8; /* Increased line height for better readability */
        font-size: 1.1rem;
        text-align: justify;
        word-wrap: break-word; /* Ensure long words break */
        white-space: normal; /* Allow text to wrap naturally */
    }

    .status-text .status-badge {
        font-size: 0.75em; /* Smaller font size */
        padding: 0.25em 0.5em; /* Smaller padding */
        border-radius: 0.3rem; /* Smaller border radius */
        vertical-align: middle; /* Align with text */
        text-transform: capitalize; /* Capitalize status text */
        white-space: nowrap; /* Prevent badge text from wrapping */
    }

    .query-card p.text-success {
        font-size: 2.8rem; /* Larger price */
        color: #28a745;
        text-shadow: 0 0 5px rgba(40, 167, 69, 0.3); /* Subtle glow for price */
    }

    .price-glow {
        animation: pulseGlow 2s infinite alternate;
    }

    @keyframes pulseGlow {
        0% { text-shadow: 0 0 5px rgba(40, 167, 69, 0.3); }
        100% { text-shadow: 0 0 10px rgba(40, 167, 69, 0.6); }
    }


    .social-links {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: auto; /* Push to bottom of flex container */
        padding-top: 15px; /* Space above links */
    }

    .social-icon {
        color: #007bff; /* Default icon color */
        transition: transform 0.3s ease, color 0.3s ease, filter 0.3s ease;
        padding: 0 10px; /* Spacing between icons */
        filter: drop-shadow(0 2px 2px rgba(0,0,0,0.2)); /* Shadow for icons */
    }

    .social-icon:hover {
        transform: scale(1.3) translateY(-5px) rotate(5deg); /* More pronounced hover */
        color: #0056b3; /* Darker blue on hover */
        filter: drop-shadow(0 4px 4px rgba(0,0,0,0.3)) brightness(1.2);
    }

    /* Carousel Navigation Buttons (Hidden for grid layout) */
    .carousel-btn {
        display: none; /* Hide arrows completely */
    }


    /* Responsive adjustments for grid layout */
    @media (max-width: 1200px) {
        .query-card {
            width: calc(50% - 60px); /* 2 cards per row on medium screens */
        }
    }

    @media (max-width: 768px) {
        .queries-grid {
            padding: 10px; /* Adjust padding for smaller screens */
        }
        .query-card {
            width: calc(100% - 20px); /* 1 card per row on small screens */
            margin: 15px auto; /* Center single card */
            min-width: 90vw; /* Take up most of viewport width */
            min-height: auto; /* Allow height to adjust for content */
        }
        .query-card-content {
            padding: 20px;
            padding-bottom: 20px;
        }
        h1 {
            font-size: 2.5rem !important;
        }
        p.lead {
            font-size: 1rem !important;
        }
        .query-card h3 {
            font-size: 1.8rem;
        }
        .query-card p.text-dark-grey {
            font-size: 1rem;
        }
        .query-card p.text-success {
            font-size: 2rem;
        }
    }

    @media (max-width: 576px) {
        .query-card {
            min-width: 95vw;
            max-width: 95vw;
            margin: 15px auto;
        }
    }

    /* Hide scrollbar for aesthetic, but keep functionality */
    .queries-grid::-webkit-scrollbar {
        display: none;
    }
    .queries-grid {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // No JavaScript needed for sliding as it's now a static grid.
        // The previous carousel-related JS has been removed.
        // Only animations and dynamic content rendering (PHP) remain.
    });
</script>

<div class="container-fluid py-5 bg-gradient-animated">
    <div class="container py-5">
        <h1 class="text-center mb-3 display-4 fw-bold text-black text-shadow-subtle animate__animated animate__fadeInDown">Our Premium Services</h1>
        <p class="text-center mb-2 lead text-black-75 animate__animated animate__fadeInUp animate__delay-0-5s">
            "Your Health, Our Priority."
        </p>
        <p class="text-center mb-5 text-black-75 animate__animated animate__fadeInUp animate__delay-0-7s">
            Schedule an appointment today for personalized care. Our expert team is ready to provide world-class healthcare tailored to your needs.
            From initial consultation to full recovery, we ensure every patient receives compassionate attention, precise treatment, and continuous support.
            Experience the difference with Meditronix — where technology meets trust, and your health is our highest priority.
        </p>

        <div class="carousel-wrapper position-relative overflow-hidden">
            <div class="carousel-track d-flex align-items-stretch" id="enhancedCarouselTrack">
                <?php
                // Establish database connection
                $db = new mysqli("localhost", "root", "", "meditronix_new");
                if ($db->connect_error) {
                    // Display a user-friendly message if connection fails
                    echo "<p class='text-center w-100 text-danger'>Failed to connect to the database. Please try again later.</p>";
                    // Log the error for debugging purposes
                    error_log("Database connection failed: " . $db->connect_error);
                } else {
                    $query = "SELECT * FROM services WHERE status = 'active'";
                    $result = $db->query($query);

                    if ($result) { // Check if query was successful
                        $services = [];
                        while ($row = $result->fetch_assoc()) {
                            $services[] = $row;
                        }

                        // Duplicate services array multiple times (e.g., 5-10 times) for a truly seamless CSS animation loop.
                        // The more duplicates, the less likely a visual jump will occur, especially if content varies.
                        $displayServices = array_merge($services, $services, $services, $services, $services, $services, $services, $services, $services, $services); // Duplicated 10 times

                        if (count($displayServices) > 0) {
                            foreach ($displayServices as $service):
                ?>
                                <div class="service-card p-4 m-3 rounded-xl shadow-2xl text-center position-relative d-flex flex-column justify-content-between animate__animated animate__zoomIn">
                                    <div class="water-overlay"></div>
                                    <div class="glitter-overlay"></div> <!-- Added glitter overlay -->
                                    <div class="service-card-content position-relative z-10 d-flex flex-column h-100">
                                        <h3 class="mb-3 text-primary fw-bold text-solid-black text-gradient-shine"><?php echo htmlspecialchars($service['name']); ?></h3>
                                        <p class="mb-3 text-dark-grey flex-grow-1 text-justify"><?php echo htmlspecialchars($service['description']); ?></p>
                                        <p class="fw-bold text-success display-6 mb-4 price-glow">₹<?php echo htmlspecialchars($service['fee']); ?></p>
                                        <div class="social-links mt-auto d-flex justify-content-center align-items-center">
                                            <a href="https://www.facebook.com/yourpage" target="_blank" class="text-primary mx-2 social-icon animate__animated animate__fadeInUp"><i class="fab fa-facebook-f fa-2x"></i></a>
                                            <a href="https://www.twitter.com/yourpage" target="_blank" class="text-info mx-2 social-icon animate__animated animate__fadeInUp animate__delay-0-1s"><i class="fab fa-twitter fa-2x"></i></a>
                                            <a href="https://www.linkedin.com/yourpage" target="_blank" class="text-secondary mx-2 social-icon animate__animated animate__fadeInUp animate__delay-0-2s"><i class="fab fa-linkedin-in fa-2x"></i></a>
                                        </div>
                                    </div>
                                </div>
                <?php
                            endforeach;
                        } else {
                            echo "<p class='text-center w-100 text-muted'>No active services found.</p>";
                        }
                    } else {
                        // Handle query execution error
                        echo "<p class='text-center w-100 text-danger'>Error fetching services: " . $db->error . "</p>";
                        error_log("Database query failed: " . $db->error);
                    }
                    $db->close();
                }
                ?>
            </div>
            <!-- Navigation Arrows -->
            <button class="btn btn-light border rounded-circle position-absolute top-50 start-0 translate-middle-y carousel-btn animate__animated animate__fadeInLeft" id="leftBtn" style="z-index: 10;">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="btn btn-light border rounded-circle position-absolute top-50 end-0 translate-middle-y carousel-btn animate__animated animate__fadeInRight" id="rightBtn" style="z-index: 10;">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<style>
    /* Global styles for body and fonts */
    body {
        font-family: 'Inter', sans-serif;
        overflow-x: hidden; /* Prevent horizontal scrollbar from animation */
        perspective: 1000px; /* For 3D transformations */
    }

    /* Custom Gradient Background with Animation (Very Light Rainbow) */
    .bg-gradient-animated {
        background: linear-gradient(135deg, #f0f8ff, #f5f5dc, #fff0f5, #f0fff0, #f8f8ff, #e0ffff); /* Light rainbow colors */
        background-size: 600% 600%; /* Increased size for smoother animation over more colors */
        animation: gradientAnimation 25s ease infinite; /* Slower animation for subtle effect */
        position: relative;
    }

    /* Subtle background particles */
    .bg-gradient-animated::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px) 0 0 / 20px 20px,
                    radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px) 10px 10px / 20px 20px;
        opacity: 0.5;
        animation: backgroundParticles 60s linear infinite;
        z-index: 0;
    }

    @keyframes backgroundParticles {
        from { background-position: 0 0; }
        to { background-position: 100% 100%; }
    }

    @keyframes gradientAnimation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Header and Subheader Styling */
    .text-black {
        color: #000000 !important;
    }

    .text-black-75 {
        color: rgba(0, 0, 0, 0.75) !important;
    }

    .text-shadow-subtle {
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2); /* Subtle shadow for readability on light background */
    }

    /* Carousel Container and Track */
    .carousel-wrapper {
        width: 100%; /* Fill full width */
        margin: 0 auto;
        padding: 20px 0;
        position: relative;
        perspective: 1200px; /* Perspective for the carousel itself */
    }

    .carousel-track {
        /* CSS animation for continuous sliding */
        animation: slideTrain 60s linear infinite; /* Initial duration, adjusted by JS */
        will-change: transform;
        white-space: nowrap; /* Keep cards in a single line */
        transform-style: preserve-3d; /* For 3D transforms on children */
    }

    /* Service Card Styling */
    .service-card {
        min-width: 450px; /* Increased width */
        max-width: 450px; /* Increased width */
        min-height: 500px; /* Set a minimum height, but allow it to grow */
        background-color: rgba(255, 255, 255, 0.8); /* More opaque white for contrast */
        backdrop-filter: blur(8px) saturate(1.2); /* Glassmorphism effect with saturation */
        border: 1px solid rgba(0, 0, 0, 0.1); /* Subtle border */
        transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Smooth transition */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15), inset 0 0 15px rgba(255,255,255,0.3); /* Lighter shadow with inner glow */
        position: relative;
        cursor: pointer;
        display: inline-flex; /* For horizontal layout */
        flex-shrink: 0; /* Prevent shrinking */
        margin: 0 15px; /* Adjust margin to control space between cards and fill edges */
        transform-origin: center center; /* For 3D rotation */
        backface-visibility: hidden; /* Prevents flickering in 3D */
        overflow: hidden; /* Keep water overlay contained */
    }

    .service-card:hover {
        transform: translateY(-15px) scale(1.03) rotateY(5deg); /* 3D tilt on hover */
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.25), 0 0 25px rgba(0, 123, 255, 0.3), inset 0 0 20px rgba(255,255,255,0.5); /* Enhanced shadow and subtle glow */
        border-color: rgba(0, 123, 255, 0.4);
        filter: brightness(1.1); /* Slightly brighter on hover */
    }

    /* Border animation on hover */
    .service-card::after {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        border-radius: inherit;
        background: linear-gradient(45deg, #007bff, #28a745, #007bff);
        z-index: -1;
        opacity: 0;
        transition: opacity 0.5s ease;
        filter: blur(5px);
    }

    .service-card:hover::after {
        opacity: 1;
    }

    /* Shining Effect on Hover */
    .service-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 50%;
        height: 100%;
        background: linear-gradient(to right, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.7) 70%, rgba(255, 255, 255, 0) 100%);
        transform: skewX(-20deg);
        transition: all 0.7s ease-in-out;
        z-index: 10;
        opacity: 0;
    }

    .service-card:hover::before {
        left: 150%;
        opacity: 1;
    }

    /* Water Overlay Effect */
    .water-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 0; /* Starts hidden */
        background: linear-gradient(to top, rgba(0, 123, 255, 0.6), rgba(0, 123, 255, 0.3)); /* Lighter gradient for water */
        transition: height 0.6s cubic-bezier(0.19, 1, 0.22, 1); /* Smoother fill */
        z-index: 0; /* Below content */
        border-radius: 0 0 1rem 1rem; /* Rounded bottom corners */
        box-shadow: inset 0 0 20px rgba(0, 123, 255, 0.2); /* Inner glow for water */
        filter: blur(2px); /* Subtle blur for water effect */
    }

    .service-card:hover .water-overlay {
        height: 100%; /* Fills up on hover */
    }

    /* Glitter Overlay Effect */
    .glitter-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="25" cy="25" r="2" fill="rgba(255,255,255,0.8)"/><circle cx="75" cy="75" r="2" fill="rgba(255,255,255,0.8)"/><circle cx="50" cy="10" r="1.5" fill="rgba(255,255,255,0.6)"/><circle cx="10" cy="50" r="1.5" fill="rgba(255,255,255,0.6)"/><circle cx="90" cy="50" r="1.5" fill="rgba(255,255,255,0.6)"/><circle cx="50" cy="90" r="1.5" fill="rgba(255,255,255,0.6)"/></svg>');
        background-size: 10% 10%;
        opacity: 0;
        transition: opacity 0.5s ease;
        animation: glitterMove 10s linear infinite;
        z-index: 1; /* Above water, below content */
        pointer-events: none; /* Allow clicks to pass through */
    }

    .service-card:hover .glitter-overlay {
        opacity: 0.7;
    }

    @keyframes glitterMove {
        from { background-position: 0 0; }
        to { background-position: 100% 100%; }
    }

    /* Ensure content is above water overlay */
    .service-card-content {
        position: relative;
        z-index: 2;
        padding: 20px; /* Added padding for inner content */
        padding-bottom: 70px; /* Space for social links */
        color: #000000; /* Solid black text */
    }

    .service-card h3 {
        font-size: 2.2rem;
        position: relative;
        padding-bottom: 10px;
        color: #000000; /* Solid black for title */
    }

    .text-solid-black {
        color: #000000 !important; /* Explicitly solid black */
    }

    .text-gradient-shine {
        background: linear-gradient(45deg, #000000, #333333, #000000);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: 200% auto;
        animation: textShine 3s linear infinite;
    }

    @keyframes textShine {
        0% { background-position: 0% 50%; }
        100% { background-position: 200% 50%; }
    }


    .service-card p.text-dark-grey {
        color: #333333; /* Dark grey for description */
        line-height: 1.8; /* Increased line height for better readability */
        font-size: 1.1rem;
        text-align: justify;
        word-wrap: break-word; /* Ensure long words break */
        white-space: normal; /* Allow text to wrap naturally */
    }

    .service-card p.text-success {
        font-size: 2.8rem; /* Larger price */
        color: #28a745;
        text-shadow: 0 0 5px rgba(40, 167, 69, 0.3); /* Subtle glow for price */
    }

    .price-glow {
        animation: pulseGlow 2s infinite alternate;
    }

    @keyframes pulseGlow {
        0% { text-shadow: 0 0 5px rgba(40, 167, 69, 0.3); }
        100% { text-shadow: 0 0 10px rgba(40, 167, 69, 0.6); }
    }


    .social-links {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .social-icon {
        color: #007bff; /* Default icon color */
        transition: transform 0.3s ease, color 0.3s ease, filter 0.3s ease;
        padding: 0 10px; /* Spacing between icons */
        filter: drop-shadow(0 2px 2px rgba(0,0,0,0.2)); /* Shadow for icons */
    }

    .social-icon:hover {
        transform: scale(1.3) translateY(-5px) rotate(5deg); /* More pronounced hover */
        color: #0056b3; /* Darker blue on hover */
        filter: drop-shadow(0 4px 4px rgba(0,0,0,0.3)) brightness(1.2);
    }

    /* Carousel Navigation Buttons */
    .carousel-btn {
        width: 50px;
        height: 50px;
        display: flex; /* Ensure display is flex to center icon */
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    }

    .carousel-btn:hover {
        background-color: #e9ecef;
        transform: scale(1.1) translateX(5px); /* Slight horizontal push */
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    #leftBtn:hover {
        transform: scale(1.1) translateX(-5px); /* Slight horizontal push */
    }


    /* Responsive adjustments */
    @media (max-width: 992px) {
        .service-card {
            min-width: 400px; /* Adjusted for tablet */
            max-width: 400px;
            min-height: 480px; /* Adjusted min-height for tablet */
        }
    }

    @media (max-width: 768px) {
        .carousel-track {
            /* On small screens, disable animation and enable manual scroll */
            animation: none !important;
            overflow-x: auto; /* Enable horizontal scrolling manually */
            -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
            scroll-snap-type: x mandatory; /* Snap to cards */
            justify-content: flex-start; /* Align items to start for scroll */
            padding: 0 10px; /* Adjust padding for smaller screens */
        }
        .carousel-wrapper {
            overflow-x: auto; /* Enable horizontal scrolling for the wrapper */
            scroll-snap-type: x mandatory;
            padding-bottom: 15px; /* Add space for scrollbar if visible */
        }
        .service-card {
            min-width: 90vw; /* Take up most of the viewport width */
            max-width: 90vw;
            margin: 15px 10px; /* Adjust margin for better spacing */
            min-height: auto; /* Allow height to adjust for content on small screens */
            scroll-snap-align: center; /* Snap cards to center */
        }
        .service-card-content {
            padding-bottom: 60px;
        }
        h1 {
            font-size: 2.5rem !important;
        }
        p.lead {
            font-size: 1rem !important;
        }
        .service-card h3 {
            font-size: 1.8rem;
        }
        .service-card p.text-dark-grey {
            font-size: 1rem;
        }
        .service-card p.text-success {
            font-size: 2rem;
        }
        .carousel-btn {
            display: none; /* Hide arrows on small screens, rely on touch scroll */
        }
    }

    @media (max-width: 576px) {
        .service-card {
            min-width: 95vw;
            max-width: 95vw;
            margin: 15px 5px;
        }
    }

    /* Hide scrollbar for aesthetic, but keep functionality */
    .carousel-wrapper::-webkit-scrollbar {
        display: none;
    }
    .carousel-wrapper {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const carouselTrack = document.getElementById('enhancedCarouselTrack');
        const leftBtn = document.getElementById('leftBtn');
        const rightBtn = document.getElementById('rightBtn');

        // Ensure elements exist before proceeding
        if (!carouselTrack || !leftBtn || !rightBtn) {
            console.error("Carousel elements not found. Please check IDs.");
            return;
        }

        const serviceCards = Array.from(carouselTrack.children).filter(child => child.classList.contains('service-card'));
        if (serviceCards.length === 0) {
            console.warn("No service cards found to animate. Please ensure PHP is correctly fetching services.");
            return;
        }

        // Dynamically calculate card width including margins
        const getCardWidthWithMargin = () => {
            if (serviceCards.length > 0) {
                const card = serviceCards[0];
                const style = getComputedStyle(card);
                return card.offsetWidth + parseFloat(style.marginLeft) + parseFloat(style.marginRight);
            }
            return 0;
        };

        let cardWidthWithMargin = getCardWidthWithMargin();
        let scrollX = 0; // Current scroll position for manual scrolling

        // Recalculate card width on resize to ensure responsiveness
        window.addEventListener('resize', () => {
            cardWidthWithMargin = getCardWidthWithMargin();
            handleResize(); // Also call handleResize to adjust arrow visibility and animation
        });

        // Calculate the width of one full original set of cards for seamless looping
        const originalServiceCount = <?php echo count($services); ?>;
        const widthOfOneOriginalSet = originalServiceCount * cardWidthWithMargin;

        // Function to update the CSS animation for continuous sliding
        let autoSlideInterval;

        const startAutoSlide = () => {
            // Clear any existing interval to prevent multiple intervals running
            if (autoSlideInterval) {
                clearInterval(autoSlideInterval);
            }

            // Only apply auto-sliding on larger screens
            if (window.innerWidth > 768) {
                // Set the animation duration based on the width of one original set of cards
                const animationSpeedFactor = 100; // Adjust for desired speed (lower = faster)
                const animationDuration = widthOfOneOriginalSet / animationSpeedFactor;

                // Ensure the animation property is set
                carouselTrack.style.animation = `slideTrain ${animationDuration}s linear infinite`;
                carouselTrack.style.animationPlayState = 'running'; // Ensure animation is running

                // Update the CSS keyframe rule for 'slideTrain' dynamically
                const styleSheet = document.styleSheets[0];
                let ruleIndex = -1;
                for (let i = 0; i < styleSheet.cssRules.length; i++) {
                    if (styleSheet.cssRules[i].name === 'slideTrain') {
                        ruleIndex = i;
                        break;
                    }
                }

                if (ruleIndex !== -1) {
                    styleSheet.deleteRule(ruleIndex);
                }

                // Insert the updated keyframe rule
                // The animation translates by the width of one full set of original cards
                // This creates the seamless "trademill" effect when the content is duplicated in PHP
                styleSheet.insertRule(`
                    @keyframes slideTrain {
                        0% { transform: translateX(0); }
                        100% { transform: translateX(-${widthOfOneOriginalSet}px); }
                    }
                `, 0);

                // Hide arrows when auto-sliding is active
                leftBtn.style.display = 'none';
                rightBtn.style.display = 'none';
                carouselTrack.style.overflowX = 'hidden'; // Hide scrollbar during auto-slide
            } else {
                // Disable animation and enable manual scrolling for smaller screens
                carouselTrack.style.animation = 'none';
                carouselTrack.style.overflowX = 'auto'; // Enable manual horizontal scroll
                carouselTrack.style.whiteSpace = 'nowrap'; // Keep cards inline for manual scroll
                carouselTrack.style.transform = `translateX(0)`; // Reset position for touch scroll
                // Show arrows for manual control on smaller screens
                leftBtn.style.display = 'flex';
                rightBtn.style.display = 'flex';
            }
        };


        // Event listener for the right button (manual override)
        rightBtn.addEventListener('click', () => {
            // Temporarily pause auto-slide if it's active
            if (window.innerWidth > 768) {
                carouselTrack.style.animationPlayState = 'paused';
            }

            scrollX += cardWidthWithMargin;
            // Loop back to the beginning if at the end of the original set
            if (scrollX >= widthOfOneOriginalSet) {
                scrollX = 0;
                carouselTrack.style.transition = 'none'; // Disable transition for instant jump
                carouselTrack.style.transform = `translateX(-${scrollX}px)`;
                void carouselTrack.offsetWidth; // Force reflow
                carouselTrack.style.transition = 'transform 0.8s ease-in-out'; // Re-enable transition
            } else {
                carouselTrack.style.transform = `translateX(-${scrollX}px)`;
            }

            // Resume auto-slide after a short delay
            if (window.innerWidth > 768) {
                setTimeout(() => {
                    carouselTrack.style.animationPlayState = 'running';
                }, 1000); // Resume after 1 second
            }
        });

        // Event listener for the left button (manual override)
        leftBtn.addEventListener('click', () => {
            // Temporarily pause auto-slide if it's active
            if (window.innerWidth > 768) {
                carouselTrack.style.animationPlayState = 'paused';
            }

            scrollX -= cardWidthWithMargin;
            // Loop back to the end if at the beginning
            if (scrollX < 0) {
                scrollX = widthOfOneOriginalSet - cardWidthWithMargin;
                carouselTrack.style.transition = 'none'; // Disable transition for instant jump
                carouselTrack.style.transform = `translateX(-${scrollX}px)`;
                void carouselTrack.offsetWidth; // Force reflow
                carouselTrack.style.transition = 'transform 0.8s ease-in-out'; // Re-enable transition
            } else {
                carouselTrack.style.transform = `translateX(-${scrollX}px)`;
            }

            // Resume auto-slide after a short delay
            if (window.innerWidth > 768) {
                setTimeout(() => {
                    carouselTrack.style.animationPlayState = 'running';
                }, 1000); // Resume after 1 second
            }
        });

        // Handle responsiveness: Adjust animation/manual scroll and arrow visibility
        const handleResize = () => {
            startAutoSlide(); // Re-evaluate and apply animation or manual scroll based on screen size
        };

        // Initial call and attach resize listener
        handleResize();
        window.addEventListener('resize', handleResize);
    });
</script>




<?php
$con = mysqli_connect("localhost", "root", "", "meditronix_new");
if (mysqli_connect_errno()) {
    error_log("Failed to connect to MySQL: " . mysqli_connect_error());
    die("Database connection failed. Please try again later.");
}
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
            --pastel-color-4: hsl(330, 100%, 97%);
            --pastel-color-5: hsl(270, 100%, 97%);
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
                var(--pastel-color-1) 0%,
                var(--pastel-color-2) 20%,
                var(--pastel-color-3) 40%,
                var(--pastel-color-4) 60%,
                var(--pastel-color-5) 80%,
                var(--pastel-color-1) 100%
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
            max-width: 1800px; /* Extended max-width for larger size */
            margin: 80px auto;
            background: rgba(255, 255, 255, 0.995);
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
                rgba(0, 255, 255, 0.8) 0%,
                rgba(0, 180, 255, 0.6) 30%,
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
            animation: shimmer 8s ease-in-out infinite, textGlow 4s infinite alternate;
            margin-bottom: 35px;
            font-weight: 900;
            letter-spacing: 5px;
            text-shadow: 6px 6px 25px rgba(0,0,0,0.3);
            position: relative;
            display: inline-block;
            transform: translateZ(20px);
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
            overflow-x: auto;
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
        .slider-container::-webkit-scrollbar {
            height: 20px;
        }
        .slider-container::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.25);
            border-radius: 10px;
            box-shadow: inset 0 0 8px rgba(0,0,0,0.4);
        }
        .slider-container::-webkit-scrollbar-thumb {
            background: linear-gradient(to right, #00d2ff, #3a7bd5);
            border-radius: 10px;
            border: 6px solid rgba(255,255,255,0.99);
            box-shadow: 0 0 15px rgba(0,210,255,0.6);
        }
        .slider-container::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to right, #3a7bd5, #00d2ff);
            box-shadow: 0 0 20px rgba(0,210,255,0.8);
        }
        .slider-container {
            scrollbar-width: thin;
            scrollbar-color: #007bff #f1f1f1;
        }
        .slider-track {
            display: flex;
            gap: 80px;
            padding: 40px;
            min-width: fit-content;
            transform-style: preserve-3d;
        }
        .slider-card {
            flex: 0 0 600px; /* Increased flex-basis for wider cards */
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
            background-image: url('https://cdn.pixabay.com/photo/2016/02/10/13/03/dentist-1191671_1280.jpg'); /* Adjusted placeholder size */
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
            margin-bottom: 30px;
            text-align: center;
            font-weight: 900;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.15);
            line-height: 1.5;
            transform: translateZ(15px);
        }
        .slider-card p {
            color: var(--text-color-dark);
            font-size: 1.3rem;
            margin-bottom: 25px;
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
        .slider-card footer {
            font-size: 1.2rem;
            color: var(--text-color-dark);
            display: flex;
            justify-content: space-between;
            margin-top: 35px;
            border-top: 3px dashed rgba(0,0,0,0.25);
            padding-top: 30px;
            align-items: center;
            flex-wrap: wrap;
            gap: 25px;
            transform: translateZ(10px);
        }
        .card-social-links {
            display: flex;
            gap: 35px;
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
        #popup-message {
            position: fixed;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%) scale(0) rotateX(90deg);
            background: linear-gradient(45deg, #ff9a9e 0%, #fad0c4 100%);
            padding: 70px 100px;
            border-radius: var(--border-radius-xl);
            font-size: 3.5rem;
            color: #fff;
            text-shadow: 4px 4px 12px rgba(0,0,0,0.7);
            box-shadow: 0 0 60px rgba(255,154,158,1);
            opacity: 0;
            transition: transform 1s cubic-bezier(0.68, -0.55, 0.27, 1.55), opacity 1s ease;
            z-index: 2000;
            border: 8px solid rgba(255,255,255,0.99);
            font-weight: bold;
            letter-spacing: 3px;
            text-align: center;
            line-height: 1.6;
            perspective: 1200px;
            transform-style: preserve-3d;
        }
        #popup-message.show {
            transform: translate(-50%, -50%) scale(1) rotateX(0deg);
            opacity: 1;
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
        .footer-social-links {
            text-align: center;
            margin-top: 140px;
            padding-top: 80px;
            border-top: 3px solid rgba(0,0,0,0.3);
            padding-bottom: 60px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 60px;
        }
        .footer-social-links a {
            color: var(--primary-blue);
            font-size: 3.5rem;
            text-decoration: none;
            transition: color 0.7s ease, transform 0.7s ease, text-shadow 0.7s ease;
            position: relative;
            overflow: hidden;
            border-radius: 50%;
            width: 90px;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(0,123,255,0.4);
            transform-style: preserve-3d;
            transform: translateZ(0);
        }
        .footer-social-links a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,123,255,0.3);
            transform: scaleY(0);
            transform-origin: bottom;
            transition: transform 0.6s ease-out;
            z-index: -1;
            border-radius: 50%;
        }
        .footer-social-links a:hover::before {
            transform: scaleY(1);
        }
        .footer-social-links a:hover {
            transform: translateY(-18px) scale(1.5) rotateY(15deg);
            color: var(--dark-blue);
            text-shadow: 0 15px 30px rgba(0,123,255,0.7);
            box-shadow: 0 12px 35px rgba(0,123,255,0.6);
        }
        footer {
            text-align: center;
            margin-top: 80px;
            padding: 50px 0;
            border-top: 3px dashed rgba(0,0,0,0.2);
            color: var(--text-color-light);
            font-size: 1.3rem;
            line-height: 1.8;
        }
        @media (max-width: 1800px) {
            .container-wrapper {
                max-width: 1700px; /* Increased max-width for larger size */
                padding: 60px;
            }
            .page-header h1 {
                font-size: 5rem;
            }
            .page-header p {
                font-size: 1.7rem;
            }
            .slider-card {
                flex: 0 0 550px; /* Adjusted for larger cards */
                padding: 4rem;
            }
        }
        @media (max-width: 1500px) {
            .container-wrapper {
                max-width: 1400px; /* Increased max-width for larger size */
                padding: 55px;
            }
            .page-header h1 {
                font-size: 4.5rem;
            }
            .page-header p {
                font-size: 1.5rem;
            }
            .slider-card {
                flex: 0 0 480px; /* Adjusted for larger cards */
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
        <h1><i class="fas fa-newspaper" style="margin-right: 20px; color: #00c6ff;"></i>Meditronix: Latest Medical News & Insights<i class="fas fa-microscope" style="margin-left: 20px; color: #0072ff;"></i></h1>
        <p>Welcome to your comprehensive dashboard for the latest advancements in medical science and technology. Stay informed with cutting-edge developments, breakthrough research, and essential healthcare updates curated by Meditronix. Our intuitive interface provides real-time news, insightful analytics, and a seamless experience to keep you ahead in the dynamic world of healthcare. Explore the future of health with our curated articles and stay connected with the pulse of medical innovation. Our commitment is to bring you accurate, timely, and impactful information that empowers both professionals and patients.</p>
    </div>

    <div class="slider-container" id="sliderContainer">
        <div class="slider-track" id="sliderTrack">
            <?php
            if (!empty($newsData)):
                foreach ($newsData as $row):
                    $iconClass = 'fas fa-newspaper';
                    if (strpos(strtolower($row['title']), 'cancer') !== false || strpos(strtolower($row['content']), 'oncology') !== false) {
                        $iconClass = 'fas fa-dna';
                    } elseif (strpos(strtolower($row['title']), 'ai') !== false || strpos(strtolower($row['content']), 'artificial intelligence') !== false) {
                        $iconClass = 'fas fa-robot';
                    } elseif (strpos(strtolower($row['title']), 'vaccine') !== false || strpos(strtolower($row['content']), 'immunization') !== false) {
                        $iconClass = 'fas fa-syringe';
                    } elseif (strpos(strtolower($row['title']), 'mental health') !== false || strpos(strtolower($row['content']), 'psychology') !== false) {
                        $iconClass = 'fas fa-brain';
                    } elseif (strpos(strtolower($row['title']), 'surgery') !== false || strpos(strtolower($row['content']), 'surgical') !== false) {
                        $iconClass = 'fas fa-cut';
                    } elseif (strpos(strtolower($row['title']), 'heart') !== false || strpos(strtolower($row['content']), 'cardiac') !== false) {
                        $iconClass = 'fas fa-heartbeat';
                    } elseif (strpos(strtolower($row['title']), 'diabetes') !== false || strpos(strtolower($row['content']), 'blood sugar') !== false) {
                        $iconClass = 'fas fa-tint';
                    } elseif (strpos(strtolower($row['title']), 'research') !== false || strpos(strtolower($row['content']), 'study') !== false) {
                        $iconClass = 'fas fa-flask';
                    } elseif (strpos(strtolower($row['title']), 'technology') !== false || strpos(strtolower($row['content']), 'tech') !== false) {
                        $iconClass = 'fas fa-microchip';
                    } elseif (strpos(strtolower($row['title']), 'public health') !== false || strpos(strtolower($row['content']), 'epidemic') !== false) {
                        $iconClass = 'fas fa-hospital-user';
                    }
            ?>
                    <div class="slider-card">
                        <div class="icon-container"><i class="<?php echo $iconClass; ?>"></i></div>
                        <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                        <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                        <footer>
                            <span>Status: <strong style="color: <?php
                                if ($row['status'] == 'Published') {
                                    echo '#28a745';
                                } elseif ($row['status'] == 'Drafted') {
                                    echo '#ffc107';
                                } else {
                                    echo '#dc3545';
                                }
                            ?>;"><?php echo htmlspecialchars($row['status']); ?></strong></span>
                            <time>Published: <?php echo date('d M Y', strtotime($row['created_at'])); ?></time>
                            <div class="card-social-links">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=https://example.com/news/<?php echo $row['id']; ?>" target="_blank" title="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://twitter.com/intent/tweet?url=https://example.com/news/<?php echo $row['id']; ?>&text=<?php echo urlencode(htmlspecialchars($row['title'])); ?>" target="_blank" title="Share on Twitter"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url=https://example.com/news/<?php echo $row['id']; ?>&title=<?php echo urlencode(htmlspecialchars($row['title'])); ?>" target="_blank" title="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </footer>
                    </div>
            <?php
                endforeach;
            else:
            ?>
                <div class="slider-card" style="flex: 0 0 100%; text-align: center; padding: 50px; background-image: url('https://placehold.co/550x400/F8F9FA/6C757D?text=No+News+Available');">
                    <div class="icon-container"><i class="fas fa-exclamation-triangle"></i></div>
                    <h2>No News Available</h2>
                    <p>Currently, there are no news articles to display. Please check back later for updates. We are constantly updating our database with the latest medical breakthroughs and insights from around the globe. Stay tuned for more exciting news from Meditronix, your trusted source for healthcare information. Our team is working diligently to bring you the most relevant and impactful stories.</p>
                </div>
            <?php
            endif;
            $current_news_count = count($newsData);
            $required_dummy_cards = 30 - $current_news_count;
            if ($required_dummy_cards > 0) {
                for ($i = 0; $i < $required_dummy_cards; $i++) {
                    $dummy_titles = [
                        "Breakthrough in Cancer Therapy: New Hope and Immunotherapy Advancements",
                        "AI Revolutionizing Diagnostics: Faster, More Accurate Predictions and Early Detection",
                        "Global Health Summit Highlights: Future of Digital Medicine and Telehealth Integration",
                        "Telemedicine Adoption Surges: Enhancing Healthcare Accessibility and Patient Engagement",
                        "Mental Health Awareness Campaign: Breaking Stigma & Offering Comprehensive Support Systems",
                        "Personalized Medicine Advances: Tailored Treatments for Unique Patients and Genetic Profiles",
                        "Future of Gene Editing: Ethical Debates, Therapeutic Potential, and CRISPR Innovations",
                        "Wearable Tech in Healthcare: Continuous Monitoring, Early Detection, and Proactive Wellness",
                        "Pandemic Preparedness: Lessons Learned, Global Strategies, and Rapid Response Frameworks",
                        "Nutritional Science Updates: Diet, Microbiome, Holistic Health, and Metabolic Insights",
                        "Robotics in Surgery: Precision, Minimally Invasive Procedures, Faster Recovery, and Enhanced Outcomes",
                        "Pharmacogenomics: Drug Response Prediction, Personalized Prescriptions, and Adverse Reaction Prevention",
                        "Space Medicine: Health in Extreme Environments, Long-Duration Missions, and Earth Applications",
                        "Bioinformatics Innovations: Data-Driven Discoveries, Drug Development, and Precision Oncology",
                        "Preventive Care Strategies: Long-term Wellness, Community Health Programs, and Early Screening",
                        "CRISPR Technology Breakthroughs: Advancements in Genetic Engineering and Disease Correction",
                        "Nanotechnology in Medicine: Targeted Drug Delivery Systems and Advanced Diagnostics",
                        "Regenerative Medicine: Stem Cells, Tissue Engineering, and Organ Regeneration",
                        "Public Health Initiatives: Tackling Non-Communicable Diseases and Health Disparities",
                        "Digital Therapeutics: Software as Medical Treatment, Behavioral Health, and Chronic Disease Management",
                        "Vaccine Development Milestones: New Platforms and Global Distribution Challenges",
                        "Precision Oncology: Targeting Tumors with Unprecedented Accuracy and Minimal Side Effects",
                        "Neuroscience Discoveries: Unraveling Brain Disorders and Cognitive Enhancements",
                        "Geriatric Care Innovations: Healthy Aging, Longevity Research, and Age-Related Diseases",
                        "Environmental Health: Impact of Climate Change on Public Well-being and Disease Patterns",
                        "Healthcare Cybersecurity: Protecting Patient Data and Medical Devices from Threats",
                        "Medical Imaging Advancements: AI-Powered Scans and 3D Visualization",
                        "Global Burden of Disease: New Insights into Leading Causes of Morbidity and Mortality",
                        "Biomarker Discovery: Revolutionizing Disease Diagnosis and Prognosis",
                        "AI in Drug Discovery: Accelerating the Development of New Therapies"
                    ];
                    $dummy_contents = [
                        "Researchers have announced a significant advancement in targeted cancer therapies, showing promising results in early clinical trials. This new approach focuses on precision treatment, minimizing side effects and improving patient outcomes dramatically. Immunotherapy, in particular, is showing great promise in treating various forms of cancer, offering new hope to patients worldwide. Clinical trials are expanding to include more diverse patient populations, aiming for broader applicability and effectiveness. The latest research indicates a paradigm shift in how we approach cancer, moving towards highly individualized treatment plans based on genetic profiling and molecular characteristics of tumors. This heralds a new era where cancer might become a manageable chronic condition for many, rather than a universally fatal disease.",
                        "Artificial intelligence is transforming medical diagnostics, enabling faster and more accurate disease detection. AI algorithms are now assisting radiologists and pathologists in identifying subtle indicators that might be missed by the human eye, leading to earlier interventions and better prognoses. This integration of AI is not only speeding up diagnosis but also enhancing the precision of treatment plans, ultimately leading to improved patient care and reduced healthcare costs. The future of diagnostics is undeniably intertwined with advanced AI, with deep learning models showing exceptional performance in analyzing complex medical images and pathological slides. This technology promises to democratize high-quality diagnostics, making it accessible even in remote areas.",
                        "Key takeaways from the recent Global Health Summit include renewed commitments to equitable vaccine distribution and strengthening healthcare infrastructures worldwide. Leaders emphasized global cooperation and shared knowledge as critical for addressing future health crises effectively. Discussions also focused on the role of digital health technologies in bridging healthcare gaps and improving access to medical services in underserved regions, highlighting a shift towards more interconnected global health systems. The summit underscored the importance of robust global health governance and sustainable funding mechanisms to ensure health equity for all populations, especially in the face of emerging infectious diseases and climate-related health challenges.",
                        "The adoption of telemedicine has seen an unprecedented surge, providing accessible healthcare solutions to remote areas and improving patient convenience. Virtual consultations are becoming the new norm, bridging geographical gaps and ensuring continuity of care for millions. This expansion has proven particularly vital during challenging times, demonstrating its potential to revolutionize healthcare delivery by making it more flexible, efficient, and patient-centric. The regulatory landscape is also evolving to support this growth, with governments and healthcare providers investing heavily in secure and user-friendly telehealth platforms. This trend is set to redefine patient-doctor interactions and expand the reach of specialized medical care.",
                        "A new global campaign aims to destigmatize mental health issues and promote open conversations. Resources and support networks are being expanded to ensure wider access to care, fostering a more understanding and supportive environment for those struggling with mental health. The initiative focuses on early intervention, community-based support, and integrating mental health services into primary care, recognizing mental well-being as a fundamental component of overall health. Public education is a key pillar of this campaign, aiming to reduce the societal burden of mental illness and encourage help-seeking behaviors. Innovations in digital mental health tools are also playing a crucial role in expanding access to therapy and support.",
                        "Advances in personalized medicine are allowing treatments to be tailored to an individual's genetic makeup, leading to more effective and safer therapeutic outcomes across various conditions. This precision approach minimizes adverse reactions and maximizes treatment efficacy, moving away from the traditional one-size-fits-all model. Genetic sequencing and biomarker identification are at the forefront of this revolution, enabling doctors to prescribe therapies that are optimized for each patient's unique biological profile. This promises to transform how diseases are managed, offering a future where treatments are as unique as the patients themselves, leading to better prognoses and quality of life.",
                        "The field of gene editing continues to evolve rapidly, with new techniques offering potential cures for previously incurable genetic disorders. Ethical considerations remain a key focus of discussion as scientists push the boundaries of genetic manipulation for therapeutic purposes. While the promise of curing inherited diseases is immense, responsible innovation and public dialogue are crucial to navigate the complex moral and societal implications of these powerful technologies. The latest advancements in CRISPR technology are making gene editing more precise and efficient, opening doors for treating a wider range of genetic conditions, from cystic fibrosis to Huntington's disease.",
                        "Wearable technology is increasingly integrated into healthcare, providing continuous monitoring of vital signs and activity levels. These devices empower individuals to take a more active role in managing their health and enable early detection of potential issues. From smartwatches tracking heart rates to specialized sensors monitoring glucose levels, wearables are transforming preventive care and chronic disease management, offering unprecedented insights into personal health data. The data collected from these devices is also being used to develop predictive analytics models, allowing for proactive interventions and personalized health recommendations.",
                        "Lessons learned from recent global health crises are driving new initiatives in pandemic preparedness. Governments and international organizations are investing in robust surveillance systems, rapid vaccine development platforms, and resilient supply chains to better respond to future outbreaks. The focus is on building a more proactive and coordinated global response, leveraging technological advancements and international collaborations to mitigate the impact of future pandemics. This includes strengthening public health infrastructure, enhancing global data sharing, and investing in research for novel pathogens.",
                        "New research in nutritional science is uncovering deeper connections between diet, the gut microbiome, and overall health. Studies highlight the importance of personalized nutrition plans for disease prevention and management, moving beyond one-size-fits-all dietary advice. The role of probiotics, prebiotics, and dietary fiber in maintaining a healthy gut ecosystem is being extensively researched, revealing new pathways for improving metabolic health and immune function. This emerging understanding is leading to more targeted dietary interventions for conditions ranging from obesity to autoimmune diseases.",
                        "Robotics in surgery continues to advance, offering unparalleled precision and minimally invasive options for complex procedures. Patients benefit from smaller incisions, reduced pain, faster recovery times, and improved surgical outcomes. Robotic-assisted surgery is now common in specialties like urology, gynecology, and cardiac surgery, demonstrating its effectiveness in enhancing surgical capabilities and patient safety. The integration of AI with surgical robots promises even greater autonomy and precision, further revolutionizing surgical practice and expanding the possibilities for complex operations.",
                        "Pharmacogenomics, the study of how genes affect a person's response to drugs, is becoming a cornerstone of personalized medicine. By understanding an individual's genetic profile, doctors can prescribe medications that are more likely to be effective and less likely to cause adverse reactions. This field promises to revolutionize drug development and clinical practice by ensuring that patients receive the right drug at the right dose for their unique genetic makeup. It holds the key to avoiding trial-and-error prescribing and optimizing therapeutic outcomes.",
                        "As humanity ventures further into space, the challenges of maintaining health in extreme environments are being addressed by a new frontier of medicine. Researchers are developing innovative solutions for radiation protection, bone density loss, and psychological well-being during long-duration space missions. This field not only supports space exploration but also yields insights applicable to terrestrial healthcare, particularly for conditions related to aging and immobility. Discoveries in space medicine often have direct implications for improving health on Earth, from new diagnostic tools to advanced life support systems.",
                        "Innovations in bioinformatics are accelerating drug discovery and disease understanding by leveraging vast amounts of biological data. Advanced computational tools are enabling scientists to identify new therapeutic targets and develop more effective treatments at an unprecedented pace. From genomic sequencing analysis to protein structure prediction, bioinformatics is a critical discipline driving breakthroughs in precision medicine and biotechnology. The ability to process and interpret massive datasets is unlocking new insights into disease mechanisms and therapeutic pathways.",
                        "Preventive care strategies are gaining prominence as healthcare systems shift focus from treatment to prevention. Public health campaigns, lifestyle interventions, and early screening programs are being implemented to promote long-term wellness and reduce the burden of chronic diseases. The emphasis is on empowering individuals to make healthier choices and providing accessible resources for maintaining well-being throughout their lives. This proactive approach aims to improve population health outcomes and reduce healthcare expenditures in the long run.",
                        "Recent CRISPR technology breakthroughs are revolutionizing genetic engineering, offering unprecedented precision in modifying DNA. These advancements hold immense promise for correcting genetic defects and treating a wide range of diseases, from inherited disorders to complex conditions like cancer. Ethical discussions continue to evolve alongside these scientific leaps, ensuring responsible development and application of this powerful tool. The potential for gene therapy to cure previously untreatable diseases is becoming a reality, offering new hope to millions.",
                        "Nanotechnology in medicine is paving the way for highly targeted drug delivery systems, minimizing side effects and maximizing therapeutic efficacy. Nanoparticles can be engineered to deliver drugs directly to diseased cells, bypass biological barriers, and even act as diagnostic tools, offering a new frontier in precision medicine and disease management. This technology is enabling the development of smarter drugs that can precisely target diseased tissues while sparing healthy ones, leading to more effective and safer treatments.",
                        "Regenerative medicine, leveraging stem cells and tissue engineering, aims to repair, replace, or regenerate damaged tissues and organs. Breakthroughs in this field offer potential cures for conditions like heart disease, spinal cord injuries, and diabetes, moving beyond symptom management to true biological restoration. The ability to grow functional tissues and organs in the lab holds immense promise for addressing organ shortages and treating a wide range of degenerative diseases.",
                        "New public health initiatives are being launched globally to tackle the rising burden of non-communicable diseases (NCDs) such as diabetes, cardiovascular disease, and chronic respiratory conditions. These programs focus on prevention through healthy lifestyles, early detection, and improved access to care, aiming to reduce premature mortality and improve quality of life. Global collaborations are essential to address the complex determinants of NCDs and implement effective, scalable interventions.",
                        "Digital therapeutics (DTx) represent a new category of medical treatments delivered through software programs. These evidence-based interventions are designed to prevent, manage, or treat a medical disorder or disease, often used alongside traditional therapies. DTx offers personalized, accessible, and scalable solutions for a variety of health conditions, from mental health disorders to chronic diseases. This innovative approach leverages technology to deliver therapeutic interventions directly to patients, enhancing engagement and adherence.",
                        "Vaccine development has seen unprecedented milestones, with new platforms like mRNA technology revolutionizing the speed and efficacy of vaccine production. However, global distribution challenges remain a critical hurdle in ensuring equitable access to life-saving immunizations worldwide. Efforts are underway to strengthen global supply chains and manufacturing capabilities to meet future demands, emphasizing the importance of vaccine equity as a global public good.",
                        "Precision oncology is at the forefront of cancer treatment, targeting tumors with unprecedented accuracy and minimal side effects. This approach relies on detailed genetic profiling of a patient's tumor to identify specific mutations that can be targeted by highly selective drugs. The goal is to move away from broad-spectrum chemotherapy towards treatments that are specifically designed for an individual's cancer, leading to better response rates and improved quality of life.",
                        "Neuroscience Discoveries: Unraveling Brain Disorders and Cognitive Enhancements",
                        "Geriatric Care Innovations: Healthy Aging, Longevity Research, and Age-Related Diseases",
                        "Environmental Health: Impact of Climate Change on Public Well-being and Disease Patterns",
                        "Healthcare Cybersecurity: Protecting Patient Data and Medical Devices from Threats",
                        "Medical Imaging Advancements: AI-Powered Scans and 3D Visualization",
                        "Global Burden of Disease: New Insights into Leading Causes of Morbidity and Mortality",
                        "Biomarker Discovery: Revolutionizing Disease Diagnosis and Prognosis",
                        "AI in Drug Discovery: Accelerating the Development of New Therapies"
                    ];
                    $dummy_statuses = ["Published", "Published", "Drafted", "Archived", "Published", "Drafted", "Published", "Upcoming", "Published", "Drafted", "Published", "Archived", "Published", "Upcoming", "Published", "Published", "Drafted", "Published", "Archived", "Upcoming", "Published", "Published", "Drafted", "Published", "Archived", "Upcoming", "Published", "Drafted", "Published", "Upcoming"];
                    $random_index = array_rand($dummy_titles);
                    $dummy_iconClass = 'fas fa-newspaper';
                    if (strpos(strtolower($dummy_titles[$random_index]), 'cancer') !== false || strpos(strtolower($dummy_contents[$random_index]), 'oncology') !== false) {
                        $dummy_iconClass = 'fas fa-dna';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'ai') !== false || strpos(strtolower($dummy_contents[$random_index]), 'artificial intelligence') !== false) {
                        $dummy_iconClass = 'fas fa-robot';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'vaccine') !== false || strpos(strtolower($dummy_contents[$random_index]), 'immunization') !== false) {
                        $dummy_iconClass = 'fas fa-syringe';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'mental health') !== false || strpos(strtolower($dummy_contents[$random_index]), 'psychology') !== false) {
                        $dummy_iconClass = 'fas fa-brain';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'surgery') !== false || strpos(strtolower($dummy_contents[$random_index]), 'surgical') !== false) {
                        $dummy_iconClass = 'fas fa-cut';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'heart') !== false || strpos(strtolower($dummy_contents[$random_index]), 'cardiac') !== false) {
                        $dummy_iconClass = 'fas fa-heartbeat';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'diabetes') !== false || strpos(strtolower($dummy_contents[$random_index]), 'blood sugar') !== false) {
                        $dummy_iconClass = 'fas fa-tint';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'research') !== false || strpos(strtolower($dummy_contents[$random_index]), 'study') !== false) {
                        $dummy_iconClass = 'fas fa-flask';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'technology') !== false || strpos(strtolower($dummy_contents[$random_index]), 'tech') !== false) {
                        $dummy_iconClass = 'fas fa-microchip';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'public health') !== false || strpos(strtolower($dummy_contents[$random_index]), 'epidemic') !== false) {
                        $dummy_iconClass = 'fas fa-hospital-user';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'crispr') !== false || strpos(strtolower($dummy_contents[$random_index]), 'genetic engineering') !== false) {
                        $dummy_iconClass = 'fas fa-dna';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'nano') !== false || strpos(strtolower($dummy_contents[$random_index]), 'nanotechnology') !== false) {
                        $dummy_iconClass = 'fas fa-atom';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'regenerative') !== false || strpos(strtolower($dummy_contents[$random_index]), 'stem cells') !== false) {
                        $dummy_iconClass = 'fas fa-seedling';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'digital therapeutics') !== false || strpos(strtolower($dummy_contents[$random_index]), 'software as medical treatment') !== false) {
                        $dummy_iconClass = 'fas fa-laptop-medical';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'neuroscience') !== false || strpos(strtolower($dummy_contents[$random_index]), 'brain disorders') !== false) {
                        $dummy_iconClass = 'fas fa-brain';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'geriatric') !== false || strpos(strtolower($dummy_contents[$random_index]), 'aging') !== false) {
                        $dummy_iconClass = 'fas fa-wheelchair';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'environmental health') !== false || strpos(strtolower($dummy_contents[$random_index]), 'climate change') !== false) {
                        $dummy_iconClass = 'fas fa-leaf';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'cybersecurity') !== false || strpos(strtolower($dummy_contents[$random_index]), 'patient data') !== false) {
                        $dummy_iconClass = 'fas fa-shield-alt';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'imaging') !== false || strpos(strtolower($dummy_contents[$random_index]), 'scans') !== false) {
                        $dummy_iconClass = 'fas fa-x-ray';
                    } elseif (strpos(strtolower($dummy_titles[$random_index]), 'biomarker') !== false || strpos(strtolower($dummy_contents[$random_index]), 'diagnosis') !== false) {
                        $dummy_iconClass = 'fas fa-vial';
                    }
            ?>
                    <div class="slider-card">
                        <div class="icon-container"><i class="<?php echo $dummy_iconClass; ?>"></i></div>
                        <h2><?php echo htmlspecialchars($dummy_titles[$random_index]); ?></h2>
                        <p><?php echo nl2br(htmlspecialchars($dummy_contents[$random_index])); ?></p>
                        <footer>
                            <span>Status: <strong style="color: <?php
                                if ($dummy_statuses[$random_index] == 'Published') {
                                    echo '#28a745';
                                } elseif ($dummy_statuses[$random_index] == 'Drafted') {
                                    echo '#ffc107';
                                } elseif ($dummy_statuses[$random_index] == 'Archived') {
                                    echo '#dc3545';
                                } else {
                                    echo '#6c757d';
                                }
                            ?>;"><?php echo htmlspecialchars($dummy_statuses[$random_index]); ?></strong></span>
                            <time>Published: <?php echo date('d M Y', strtotime('-' . rand(1, 365) . ' days')); ?></time>
                            <div class="card-social-links">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=https://example.com/dummy-news-<?php echo $i; ?>" target="_blank" title="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://twitter.com/intent/tweet?url=https://example.com/dummy-news-<?php echo $i; ?>&text=<?php echo urlencode(htmlspecialchars($dummy_titles[$random_index])); ?>" target="_blank" title="Share on Twitter"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url=https://example.com/dummy-news-<?php echo $i; ?>&title=<?php echo urlencode(htmlspecialchars($dummy_titles[$random_index])); ?>" target="_blank" title="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </footer>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <div id="popup-message">✨ Discover the Future of Health ✨
        <br>
        <center>✨MEDITRONIX NEWS✨</center>
    </div>
    <canvas id="fireworkCanvas"></canvas>

    <div class="footer-social-links">
        <a href="https://www.facebook.com/Google" target="_blank" title="Visit our Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="https://twitter.com/Google" target="_blank" title="Visit our Twitter"><i class="fab fa-twitter"></i></a>
        <a href="https://www.instagram.com/google/" target="_blank" title="Visit our Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://www.linkedin.com/company/google/" target="_blank" title="Visit our LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        <a href="https://www.youtube.com/Google" target="_blank" title="Visit our YouTube"><i class="fab fa-youtube"></i></a>
        <a href="https://github.com/Google" target="_blank" title="Visit our GitHub"><i class="fab fa-github"></i></a>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> Meditronix. All rights reserved. Pioneering healthcare insights for a healthier tomorrow. Designed with <span style="color: #e52e71;">&hearts;</span> for Rohan Kapri.
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
            const numParticles = 100;
            for (let i = 0; i < numParticles; i++) {
                particles.push({
                    x,
                    y,
                    radius: random(3.5, 6),
                    color: `hsl(${Math.random() * 360}, 100%, 75%)`,
                    dx: random(-10, 10),
                    dy: random(-10, 10),
                    alpha: 1,
                    gravity: 0.18,
                    friction: 0.95
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
                    p.alpha -= 0.025;
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
        document.querySelectorAll('.slider-card').forEach(card => {
            card.addEventListener('click', function(event) {
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
            });
        });
    </script>
</div>


<?php
include("adminFooter.php");
?>
