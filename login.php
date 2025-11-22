<?php
// This line includes your header file, which typically contains
// the opening HTML tags (like <!DOCTYPE html>, <html>, <head>, <body>),
// meta tags, title, links to external CSS (if any), and possibly a navigation bar.
include('header.php');
?>

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Font Awesome CDN for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Google Fonts - Inter -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- Chart.js CDN for graphs -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Minimal Custom styles for animations and specific background patterns that cannot be inline -->
<style>
    /* Body font-family is global, and background color is explicitly white */
    body {
        font-family: 'Inter', sans-serif;
        background-color: #ffffff; /* Plain white background */
    }
    /* Animations for form panels */
    .form-panel {
        animation: fadeIn 0.5s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    /* Specific panel patterns - these cannot be applied inline as they are gradients */
    .form-area.doctor-pattern {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    }
    .form-area.patient-pattern {
        background: linear-gradient(135deg, #fff7ed 0%, #ffeecf 100%);
    }
    .form-area.admin-pattern {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    }
    /* Placeholder color - can't be inline */
    .form-input::placeholder {
        color: #94a3b8;
    }

    /* Modal Styling - Adjusted for reliable show/hide with transitions */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        display: none; /* Hidden by default */
        justify-content: center;
        align-items: center;
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s ease; /* Only transition opacity */
    }
    .modal-overlay.active {
        display: flex; /* Show when active */
        opacity: 1;
    }
    .modal-content {
        background-color: #ffffff;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        width: 90%;
        max-width: 500px;
        transform: translateY(-20px);
        transition: transform 0.3s ease;
    }
    .modal-overlay.active .modal-content {
        transform: translateY(0);
    }

    /* Dashboard specific styles */
    .dashboard-sidebar {
        background-color: #1e293b; /* Slate-800 */
        color: #f8fafc; /* Slate-50 */
        min-height: calc(100vh - 70px); /* Adjust based on header height */
        position: sticky;
        top: 70px; /* Should be height of your fixed header */
    }
    .dashboard-sidebar a {
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
        transition: background-color 0.2s ease;
    }
    .dashboard-sidebar a:hover, .dashboard-sidebar a.active {
        background-color: #334155; /* Slate-700 */
        color: #3b82f6; /* Blue-500 */
    }
    .dashboard-sidebar a.active {
        border-left: 4px solid #3b82f6; /* Blue-500 */
    }

    .dashboard-content-area {
        background-color: #ffffff;
        flex-grow: 1;
        overflow-y: auto; /* Enable scrolling for content */
    }

    /* Specific card styles for dashboards */
    .dashboard-card {
        background-color: #ffffff;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
    }

    /* Hide the login page container when dashboard is visible */
    #loginPageContainer.hidden {
        display: none;
    }
</style>

<!-- Contact Start - This is the user-provided outer div structure -->
<div class="container-xxl py-5" style="margin-top: 100px;" id="loginPageContainer">
    <div class="container mx-auto px-4">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-5">Login form</h6>
        </div>
        <div class="row g-4 justify-content-center flex flex-wrap justify-center gap-4">
            <!-- Adjusted width classes for the main content area to allow for a larger form -->
            <div class="wow fadeInUp w-full md:w-11/12 lg:w-10/12 xl:w-9/12" data-wow-delay="0.5s">
                <!-- Main login wrapper container - Centered horizontally with mx-auto -->
                <div class="login-wrapper w-full flex flex-col items-center gap-4 mx-auto">
                    <!-- Top Login/Logout Button -->
                    <button id="topAuthButton" class="top-auth-button bg-blue-500 text-white py-3 px-6 rounded-lg font-semibold cursor-pointer transition duration-300 ease-in-out shadow-lg mb-4 self-end hover:bg-blue-600 hover:translate-y-px active:translate-y-0 active:shadow-md" onclick="handleAuthAction()">Login</button>

                    <!-- Increased max-width for the login-container to make the form larger -->
                    <div class="login-container bg-white rounded-2xl shadow-xl overflow-hidden w-full max-w-5xl flex flex-col md:flex-row">
                        <!-- Panel Selection Area -->
                        <div class="panel-selection bg-gray-50 p-8 flex flex-col justify-center items-center gap-6 border-b border-gray-200 md:w-2/5 md:border-r md:border-b-0">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">Choose Your Role</h2>
                            <button class="panel-button active flex flex-col items-center justify-center p-6 rounded-xl bg-white border border-gray-300 text-gray-700 transition duration-300 ease-in-out cursor-pointer w-full text-center hover:border-blue-500 hover:text-blue-500 hover:shadow-lg" data-panel="doctor">
                                <i class="fas fa-user-md text-4xl mb-3"></i>
                                <span class="font-semibold text-lg">Doctor Panel</span>
                            </button>
                            <button class="panel-button flex flex-col items-center justify-center p-6 rounded-xl bg-white border border-gray-300 text-gray-700 transition duration-300 ease-in-out cursor-pointer w-full text-center hover:border-blue-500 hover:text-blue-500 hover:shadow-lg" data-panel="patient">
                                <i class="fas fa-user-injured text-4xl mb-3"></i>
                                <span class="font-semibold text-lg">Patient Panel</span>
                            </button>
                            <button class="panel-button flex flex-col items-center justify-center p-6 rounded-xl bg-white border border-gray-300 text-gray-700 transition duration-300 ease-in-out cursor-pointer w-full text-center hover:border-blue-500 hover:text-blue-500 hover:shadow-lg" data-panel="admin">
                                <i class="fas fa-user-shield text-4xl mb-3"></i>
                                <span class="font-semibold text-lg">Admin Panel</span>
                            </button>
                        </div>

                        <!-- Form Area -->
                        <div class="form-area doctor-pattern p-8 w-full md:w-3/5 relative" id="formArea">
                            <!-- Doctor Panel Login Form -->
                            <div id="doctorPanel" class="form-panel active">
                                <h1 class="text-3xl font-extrabold text-gray-900 mb-6 text-center">Doctor Login</h1>
                                <form class="space-y-5" onsubmit="event.preventDefault(); login('doctor');">
                                    <div>
                                        <label for="doctorUsername" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                        <input type="text" id="doctorUsername" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Enter your username" required>
                                    </div>
                                    <div>
                                        <label for="doctorPassword" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                        <input type="password" id="doctorPassword" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Enter your password" required>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <a href="#" class="form-link text-blue-500 font-medium transition duration-200 hover:text-blue-700 hover:underline" onclick="showForgotPasswordModal('doctor'); return false;">Forgot Password?</a>
                                        <p class="text-gray-600">Not registered yet? <a href="#" class="form-link text-blue-500 font-medium transition duration-200 hover:text-blue-700 hover:underline" onclick="showRegistrationModal('doctor'); return false;">Register here</a></p>
                                    </div>
                                    <div class="captcha-container flex items-center gap-3 mb-4">
                                        <div id="doctorCaptchaText" class="captcha-text bg-gray-200 py-3 px-4 rounded-lg font-mono text-xl font-bold text-gray-800 select-none flex-grow text-center"></div>
                                        <button type="button" class="captcha-refresh-button bg-gray-600 text-white py-3 px-3 rounded-lg cursor-pointer transition duration-200 hover:bg-gray-700 border-none" onclick="generateCaptcha('doctor')"><i class="fas fa-sync-alt"></i></button>
                                    </div>
                                    <div>
                                        <label for="doctorCaptchaInput" class="block text-sm font-medium text-gray-700 mb-1">Enter Captcha</label>
                                        <input type="text" id="doctorCaptchaInput" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Enter the text above" required>
                                    </div>
                                    <button type="submit" class="submit-button w-full py-3 px-6 bg-blue-500 text-white font-semibold rounded-lg transition duration-300 ease-in-out shadow-lg border-none cursor-pointer hover:bg-blue-600 hover:translate-y-px active:translate-y-0 active:shadow-md">Login as Doctor</button>
                                </form>
                            </div>

                            <!-- Patient Panel Login Form -->
                            <div id="patientPanel" class="form-panel" style="display: none;">
                                <h1 class="text-3xl font-extrabold text-gray-900 mb-6 text-center">Patient Login</h1>
                                <form class="space-y-5" onsubmit="event.preventDefault(); login('patient');">
                                    <div>
                                        <label for="patientUsername" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                        <input type="text" id="patientUsername" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Enter your username" required>
                                    </div>
                                    <div>
                                        <label for="patientPassword" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                        <input type="password" id="patientPassword" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Enter your password" required>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <a href="#" class="form-link text-blue-500 font-medium transition duration-200 hover:text-blue-700 hover:underline" onclick="showForgotPasswordModal('patient'); return false;">Forgot Password?</a>
                                        <p class="text-gray-600">Not registered yet? <a href="#" class="form-link text-blue-500 font-medium transition duration-200 hover:text-blue-700 hover:underline" onclick="showRegistrationModal('patient'); return false;">Register here</a></p>
                                    </div>
                                    <div class="captcha-container flex items-center gap-3 mb-4">
                                        <div id="patientCaptchaText" class="captcha-text bg-gray-200 py-3 px-4 rounded-lg font-mono text-xl font-bold text-gray-800 select-none flex-grow text-center"></div>
                                        <button type="button" class="captcha-refresh-button bg-gray-600 text-white py-3 px-3 rounded-lg cursor-pointer transition duration-200 hover:bg-gray-700 border-none" onclick="generateCaptcha('patient')"><i class="fas fa-sync-alt"></i></button>
                                    </div>
                                    <div>
                                        <label for="patientCaptchaInput" class="block text-sm font-medium text-gray-700 mb-1">Enter Captcha</label>
                                        <input type="text" id="patientCaptchaInput" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Enter the text above" required>
                                    </div>
                                    <button type="submit" class="submit-button w-full py-3 px-6 bg-blue-500 text-white font-semibold rounded-lg transition duration-300 ease-in-out shadow-lg border-none cursor-pointer hover:bg-blue-600 hover:translate-y-px active:translate-y-0 active:shadow-md">Login as Patient</button>
                                </form>
                            </div>

                            <!-- Admin Panel Login Form -->
                            <div id="adminPanel" class="form-panel" style="display: none;">
                                <h1 class="text-3xl font-extrabold text-gray-900 mb-6 text-center">Admin Login</h1>
                                <form class="space-y-5" onsubmit="event.preventDefault(); login('admin');">
                                    <div>
                                        <label for="adminUsername" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                        <input type="text" id="adminUsername" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Enter your username" required>
                                    </div>
                                    <div>
                                        <label for="adminPassword" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                        <input type="password" id="adminPassword" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Enter your password" required>
                                    </div>
                                    <div class="flex justify-end items-center text-sm">
                                        <a href="#" class="form-link text-blue-500 font-medium transition duration-200 hover:text-blue-700 hover:underline" onclick="showForgotPasswordModal('admin'); return false;">Forgot Password?</a>
                                        <!-- Admin registration link usually not public -->
                                    </div>
                                    <div class="captcha-container flex items-center gap-3 mb-4">
                                        <div id="adminCaptchaText" class="captcha-text bg-gray-200 py-3 px-4 rounded-lg font-mono text-xl font-bold text-gray-800 select-none flex-grow text-center"></div>
                                        <button type="button" class="captcha-refresh-button bg-gray-600 text-white py-3 px-3 rounded-lg cursor-pointer transition duration-200 hover:bg-gray-700 border-none" onclick="generateCaptcha('admin')"><i class="fas fa-sync-alt"></i></button>
                                    </div>
                                    <div>
                                        <label for="adminCaptchaInput" class="block text-sm font-medium text-gray-700 mb-1">Enter Captcha</label>
                                        <input type="text" id="adminCaptchaInput" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Enter the text above" required>
                                    </div>
                                    <button type="submit" class="submit-button w-full py-3 px-6 bg-blue-500 text-white font-semibold rounded-lg transition duration-300 ease-in-out shadow-lg border-none cursor-pointer hover:bg-blue-600 hover:translate-y-px active:translate-y-0 active:shadow-md">Login as Admin</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

<!-- Main Dashboard Container -->
<div id="mainDashboardContainer" class="hidden w-full min-h-screen bg-gray-100 flex" style="display: none;">
    <!-- Sidebar -->
    <div class="dashboard-sidebar w-64 flex-shrink-0 p-6 shadow-lg">
        <div class="text-2xl font-bold text-white mb-8">Healthbridge</div>
        <nav class="space-y-2" id="dashboardSidebarNav">
            <!-- Sidebar links will be dynamically generated based on user role -->
        </nav>
    </div>

    <!-- Content Area -->
    <div class="dashboard-content-area flex-grow p-8">
        <!-- Patient Dashboard Sections -->
        <div id="patientDashboardOverview" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Patient Dashboard Overview</h1>
            <!-- Patient Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="dashboard-card bg-blue-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-blue-700">Booked Appointments</p>
                        <h3 id="patientBookedCount" class="text-4xl font-bold text-blue-900">0</h3>
                    </div>
                    <i class="fas fa-calendar-check text-blue-500 text-5xl"></i>
                </div>
                <div class="dashboard-card bg-red-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-red-700">Cancelled Appointments</p>
                        <h3 id="patientCancelledCount" class="text-4xl font-bold text-red-900">0</h3>
                    </div>
                    <i class="fas fa-calendar-times text-red-500 text-5xl"></i>
                </div>
            </div>
            <!-- Patient specific charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">My Appointment Status</h2>
                    <canvas id="patientAppointmentStatusChart"></canvas>
                </div>
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Appointments by Specialization</h2>
                    <canvas id="patientSpecializationChart"></canvas>
                </div>
            </div>
        </div>

        <div id="patientDashboardBookAppointment" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Book an Appointment</h1>
            <div id="doctorsList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Doctor cards will be rendered here by JavaScript -->
            </div>
        </div>

        <div id="patientDashboardMyAppointments" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">My Appointments</h1>
            <div class="dashboard-card">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Appointment ID</th>
                                <th class="py-3 px-6 text-left">Doctor Name</th>
                                <th class="py-3 px-6 text-left">Specialization</th>
                                <th class="py-3 px-6 text-left">Disease</th>
                                <th class="py-3 px-6 text-left">Date</th>
                                <th class="py-3 px-6 text-left">Time</th>
                                <th class="py-3 px-6 text-left">Status</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="patientAppointmentsTable" class="text-gray-700 text-sm font-light">
                            <!-- Appointments will be rendered here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Doctor Dashboard Sections -->
        <div id="doctorDashboardOverview" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Doctor Dashboard Overview</h1>
            <!-- Doctor Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="dashboard-card bg-purple-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-purple-700">Total Patients</p>
                        <h3 id="doctorTotalPatients" class="text-4xl font-bold text-purple-900">0</h3>
                    </div>
                    <i class="fas fa-users text-purple-500 text-5xl"></i>
                </div>
                <div class="dashboard-card bg-green-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-green-700">Accepted Appointments</p>
                        <h3 id="doctorAcceptedAppointments" class="text-4xl font-bold text-green-900">0</h3>
                    </div>
                    <i class="fas fa-check-circle text-green-500 text-5xl"></i>
                </div>
                <div class="dashboard-card bg-yellow-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-yellow-700">Pending Appointments</p>
                        <h3 id="doctorPendingAppointments" class="text-4xl font-bold text-yellow-900">0</h3>
                    </div>
                    <i class="fas fa-clock text-yellow-500 text-5xl"></i>
                </div>
                <div class="dashboard-card bg-red-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-red-700">Rejected Appointments</p>
                        <h3 id="doctorRejectedAppointments" class="text-4xl font-bold text-red-900">0</h3>
                    </div>
                    <i class="fas fa-times-circle text-red-500 text-5xl"></i>
                </div>
            </div>
            <!-- Doctor Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">My Appointment Status Overview</h2>
                    <canvas id="doctorAppointmentStatusChart"></canvas>
                </div>
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Patients by Disease (My Patients)</h2>
                    <canvas id="doctorPatientsByDiseaseChart"></canvas>
                </div>
            </div>
        </div>

        <div id="doctorDashboardAppointments" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">My Appointments</h1>
            <div class="dashboard-card">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Planned Consultations</h2>
                <div id="doctorAppointmentsList" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Doctor's appointments will be rendered here by JavaScript -->
                </div>
            </div>
        </div>

        <div id="doctorDashboardMyPatients" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">My Patients</h1>
            <div class="dashboard-card">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Patient List</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Patient ID</th>
                                <th class="py-3 px-6 text-left">Patient Name</th>
                                <th class="py-3 px-6 text-left">Date Check In</th>
                                <th class="py-3 px-6 text-left">Disease</th>
                                <th class="py-3 px-6 text-left">Room/Bed</th>
                            </tr>
                        </thead>
                        <tbody id="doctorPatientListTable" class="text-gray-700 text-sm font-light">
                            <!-- Patient list will be rendered here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="doctorDashboardSchedule" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">My Schedule</h1>
            <div class="dashboard-card">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Daily Slots</h2>
                <div id="doctorScheduleSlots" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- Doctor's schedule slots will be rendered here -->
                </div>
            </div>
        </div>

        <!-- Admin Dashboard Sections -->
        <div id="adminDashboardOverview" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Admin Dashboard Overview</h1>
            <!-- Admin Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="dashboard-card bg-blue-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-blue-700">Total Doctors</p>
                        <h3 id="adminTotalDoctors" class="text-4xl font-bold text-blue-900">0</h3>
                    </div>
                    <i class="fas fa-user-md text-blue-500 text-5xl"></i>
                </div>
                <div class="dashboard-card bg-purple-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-purple-700">Total Patients</p>
                        <h3 id="adminTotalPatients" class="text-4xl font-bold text-purple-900">0</h3>
                    </div>
                    <i class="fas fa-user-injured text-purple-500 text-5xl"></i>
                </div>
                <div class="dashboard-card bg-green-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-green-700">Total Appointments</p>
                        <h3 id="adminTotalAppointments" class="text-4xl font-bold text-green-900">0</h3>
                    </div>
                    <i class="fas fa-calendar-alt text-green-500 text-5xl"></i>
                </div>
            </div>
            <!-- Admin Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Overall Appointment Status</h2>
                    <canvas id="adminAppointmentStatusChart"></canvas>
                </div>
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Doctors by Specialization</h2>
                    <canvas id="adminDoctorsBySpecializationChart"></canvas>
                </div>
            </div>
        </div>

        <div id="adminDashboardManageDoctors" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Manage Doctors</h1>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Add Doctor -->
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Doctor</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="newDoctorName" class="block text-sm font-medium text-gray-700">Doctor Name</label>
                            <input type="text" id="newDoctorName" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., Dr. Alice Smith">
                        </div>
                        <div>
                            <label for="newDoctorSpecialization" class="block text-sm font-medium text-gray-700">Specialization</label>
                            <input type="text" id="newDoctorSpecialization" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., Cardiology">
                        </div>
                        <button class="submit-button w-full py-2 px-4 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition duration-300" onclick="adminAddDoctor()">Add Doctor</button>
                    </div>
                </div>

                <!-- Remove Doctor -->
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Remove Doctor</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="removeDoctorId" class="block text-sm font-medium text-gray-700">Doctor ID (e.g., D001)</label>
                            <input type="text" id="removeDoctorId" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Doctor ID">
                        </div>
                        <button class="submit-button w-full py-2 px-4 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition duration-300" onclick="adminRemoveDoctor()">Remove Doctor</button>
                    </div>
                </div>

                <!-- Change Slot Time -->
                <div class="dashboard-card col-span-full">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Change Doctor Slot Time</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="slotDoctorId" class="block text-sm font-medium text-gray-700">Doctor ID</label>
                            <input type="text" id="slotDoctorId" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Doctor ID">
                        </div>
                        <div>
                            <label for="newSlotTime" class="block text-sm font-medium text-gray-700">New Slot Time (HH:MM)</label>
                            <input type="time" id="newSlotTime" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button class="submit-button w-full py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition duration-300" onclick="adminChangeSlotTime()">Update Slot</button>
                    </div>
                </div>
            </div>
            <div class="dashboard-card">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Doctors List</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Doctor ID</th>
                                <th class="py-3 px-6 text-left">Name</th>
                                <th class="py-3 px-6 text-left">Specialization</th>
                                <th class="py-3 px-6 text-left">Available Slots</th>
                            </tr>
                        </thead>
                        <tbody id="adminDoctorsTable" class="text-gray-700 text-sm font-light">
                            <!-- Doctors will be rendered here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="adminDashboardManagePatients" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Manage Patients</h1>
            <div class="dashboard-card">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Patients List</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Patient ID</th>
                                <th class="py-3 px-6 text-left">Name</th>
                                <th class="py-3 px-6 text-left">Disease</th>
                                <th class="py-3 px-6 text-left">Room/Bed</th>
                            </tr>
                        </thead>
                        <tbody id="adminPatientsTable" class="text-gray-700 text-sm font-light">
                            <!-- Patients will be rendered here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="adminDashboardManageAppointments" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Manage Appointments</h1>
            <div class="dashboard-card mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Cancel Any Appointment</h2>
                <div class="space-y-4">
                    <div>
                        <label for="cancelAppointmentId" class="block text-sm font-medium text-gray-700">Appointment ID</label>
                        <input type="text" id="cancelAppointmentId" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Appointment ID">
                    </div>
                    <button class="submit-button w-full py-2 px-4 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition duration-300" onclick="adminCancelMeeting()">Cancel Meeting</button>
                </div>
            </div>
            <div class="dashboard-card">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Appointments List</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Appointment ID</th>
                                <th class="py-3 px-6 text-left">Patient Name</th>
                                <th class="py-3 px-6 text-left">Doctor Name</th>
                                <th class="py-3 px-6 text-left">Specialization</th>
                                <th class="py-3 px-6 text-left">Disease</th>
                                <th class="py-3 px-6 text-left">Date</th>
                                <th class="py-3 px-6 text-left">Time</th>
                                <th class="py-3 px-6 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody id="adminAppointmentsTable" class="text-gray-700 text-sm font-light">
                            <!-- All appointments will be rendered here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Placeholder for other Admin sections (e.g., System Logs) -->
        <div id="adminDashboardSystemLogs" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">System Logs (Admin Only)</h1>
            <div class="dashboard-card p-6">
                <p class="text-gray-700">This section would display system activity, errors, and audit trails.</p>
                <ul class="list-disc list-inside text-gray-600 mt-4 space-y-2">
                    <li>[2025-07-09 10:30] Admin logged in.</li>
                    <li>[2025-07-09 10:25] Dr. Alice Smith added.</li>
                    <li>[2025-07-09 10:20] Patient Rohan Kapri booked appointment with Dr. Bob Johnson.</li>
                    <li>[2025-07-09 10:15] System initialized.</li>
                </ul>
            </div>
        </div>

    </div>
</div>

<!-- Custom Alert Modal (for "Thank you" and other messages) -->
<div id="customAlertModal" class="modal-overlay fixed top-0 left-0 w-full h-full bg-black bg-opacity-60 flex justify-center items-center z-50 opacity-0 transition-opacity duration-300 ease-in-out">
    <div class="modal-content bg-white p-8 rounded-2xl shadow-2xl w-11/12 max-w-lg transform -translate-y-5 transition-transform duration-300 ease-in-out">
        <div class="modal-header flex justify-between items-center mb-6 border-b border-gray-200 pb-4">
            <h3 class="modal-title text-3xl font-bold text-gray-800" id="customAlertTitle">Alert</h3>
            <button type="button" class="modal-close-button bg-none border-none text-2xl text-gray-500 cursor-pointer transition duration-200 hover:text-gray-800" onclick="closeCustomAlert()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body text-base text-gray-700 leading-relaxed">
            <p id="customAlertMessage"></p>
        </div>
        <div class="modal-footer text-right mt-6">
            <button type="button" class="modal-button py-3 px-6 bg-blue-500 text-white font-semibold rounded-lg border-none cursor-pointer transition duration-300 hover:bg-blue-600" onclick="closeCustomAlert()">OK</button>
        </div>
    </div>
</div>

<!-- Forgot Password Modal -->
<div id="forgotPasswordModal" class="modal-overlay fixed top-0 left-0 w-full h-full bg-black bg-opacity-60 flex justify-center items-center z-50 opacity-0 transition-opacity duration-300 ease-in-out">
    <div class="modal-content bg-white p-8 rounded-2xl shadow-2xl w-11/12 max-w-lg transform -translate-y-5 transition-transform duration-300 ease-in-out">
        <div class="modal-header flex justify-between items-center mb-6 border-b border-gray-200 pb-4">
            <h3 class="modal-title text-3xl font-bold text-gray-800">Forgot Password</h3>
            <button type="button" class="modal-close-button bg-none border-none text-2xl text-gray-500 cursor-pointer transition duration-200 hover:text-gray-800" onclick="closeForgotPasswordModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body text-base text-gray-700 leading-relaxed">
            <div id="forgotPasswordStep1">
                <p class="mb-4">Please enter your registered phone number to receive an OTP.</p>
                <input type="tel" id="forgotPhone" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline mb-4" placeholder="Phone Number (e.g., +91-1234567890)" required>
                <button type="button" class="submit-button w-full py-3 px-6 bg-blue-500 text-white font-semibold rounded-lg transition duration-300 ease-in-out shadow-lg border-none cursor-pointer hover:bg-blue-600 hover:translate-y-px active:translate-y-0 active:shadow-md" onclick="sendOTP()">Send OTP</button>
            </div>
            <div id="forgotPasswordStep2" style="display: none;">
                <p class="mb-4">An OTP has been sent to your phone number. Please enter it below along with your new password.</p>
                <input type="text" id="forgotOTP" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline mb-4" placeholder="Enter OTP" required>
                <input type="password" id="newPassword" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline mb-4" placeholder="New Password" required>
                <input type="password" id="confirmNewPassword" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline mb-4" placeholder="Confirm New Password" required>
                <button type="button" class="submit-button w-full py-3 px-6 bg-blue-500 text-white font-semibold rounded-lg transition duration-300 ease-in-out shadow-lg border-none cursor-pointer hover:bg-blue-600 hover:translate-y-px active:translate-y-0 active:shadow-md" onclick="resetPassword()">Reset Password</button>
            </div>
        </div>
    </div>
</div>

<!-- Doctor Registration Modal -->
<div id="doctorRegistrationModal" class="modal-overlay fixed top-0 left-0 w-full h-full bg-black bg-opacity-60 flex justify-center items-center z-50 opacity-0 transition-opacity duration-300 ease-in-out">
    <div class="modal-content bg-white p-8 rounded-2xl shadow-2xl w-11/12 max-w-lg transform -translate-y-5 transition-transform duration-300 ease-in-out">
        <div class="modal-header flex justify-between items-center mb-6 border-b border-gray-200 pb-4">
            <h3 class="modal-title text-3xl font-bold text-gray-800">Doctor Registration</h3>
            <button type="button" class="modal-close-button bg-none border-none text-2xl text-gray-500 cursor-pointer transition duration-200 hover:text-gray-800" onclick="closeRegistrationModal('doctor')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body text-base text-gray-700 leading-relaxed">
            <form class="space-y-5" onsubmit="event.preventDefault(); registerUser('doctor');">
                <div>
                    <label for="regDoctorUsername" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" id="regDoctorUsername" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Choose a username" required>
                </div>
                <div>
                    <label for="regDoctorPassword" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" id="regDoctorPassword" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Create a password" required>
                </div>
                <div>
                    <label for="regDoctorConfirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" id="regDoctorConfirmPassword" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Confirm your password" required>
                </div>
                <div class="captcha-container flex items-center gap-3 mb-4">
                    <div id="regDoctorCaptchaText" class="captcha-text bg-gray-200 py-3 px-4 rounded-lg font-mono text-xl font-bold text-gray-800 select-none flex-grow text-center"></div>
                    <button type="button" class="captcha-refresh-button bg-gray-600 text-white py-3 px-3 rounded-lg cursor-pointer transition duration-200 hover:bg-gray-700 border-none" onclick="generateCaptcha('regDoctor')"><i class="fas fa-sync-alt"></i></button>
                </div>
                <div>
                    <label for="regDoctorCaptchaInput" class="block text-sm font-medium text-gray-700 mb-1">Enter Captcha</label>
                    <input type="text" id="regDoctorCaptchaInput" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Enter the text above" required>
                </div>
                <div class="flex gap-4">
                    <button type="button" class="submit-button bg-gray-500 hover:bg-gray-600 w-full py-3 px-6 text-white font-semibold rounded-lg transition duration-300 ease-in-out shadow-lg border-none cursor-pointer hover:translate-y-px active:translate-y-0 active:shadow-md" onclick="clearRegistrationForm('doctor')">Clear All Details</button>
                    <button type="submit" class="submit-button w-full py-3 px-6 bg-blue-500 text-white font-semibold rounded-lg transition duration-300 ease-in-out shadow-lg border-none cursor-pointer hover:bg-blue-600 hover:translate-y-px active:translate-y-0 active:shadow-md">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Patient Registration Modal -->
<div id="patientRegistrationModal" class="modal-overlay fixed top-0 left-0 w-full h-full bg-black bg-opacity-60 flex justify-center items-center z-50 opacity-0 transition-opacity duration-300 ease-in-out">
    <div class="modal-content bg-white p-8 rounded-2xl shadow-2xl w-11/12 max-w-lg transform -translate-y-5 transition-transform duration-300 ease-in-out">
        <div class="modal-header flex justify-between items-center mb-6 border-b border-gray-200 pb-4">
            <h3 class="modal-title text-3xl font-bold text-gray-800">Patient Registration</h3>
            <button type="button" class="modal-close-button bg-none border-none text-2xl text-gray-500 cursor-pointer transition duration-200 hover:text-gray-800" onclick="closeRegistrationModal('patient')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body text-base text-gray-700 leading-relaxed">
            <form class="space-y-5" onsubmit="event.preventDefault(); registerUser('patient');">
                <div>
                    <label for="regPatientUsername" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" id="regPatientUsername" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Choose a username" required>
                </div>
                <div>
                    <label for="regPatientPassword" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" id="regPatientPassword" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Create a password" required>
                </div>
                <div>
                    <label for="regPatientConfirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" id="regPatientConfirmPassword" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Confirm your password" required>
                </div>
                <div class="captcha-container flex items-center gap-3 mb-4">
                    <div id="regPatientCaptchaText" class="captcha-text bg-gray-200 py-3 px-4 rounded-lg font-mono text-xl font-bold text-gray-800 select-none flex-grow text-center"></div>
                    <button type="button" class="captcha-refresh-button bg-gray-600 text-white py-3 px-3 rounded-lg cursor-pointer transition duration-200 hover:bg-gray-700 border-none" onclick="generateCaptcha('regPatient')"><i class="fas fa-sync-alt"></i></button>
                </div>
                <div>
                    <label for="regPatientCaptchaInput" class="block text-sm font-medium text-gray-700 mb-1">Enter Captcha</label>
                    <input type="text" id="regPatientCaptchaInput" class="form-input w-full py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 transition duration-200 ease-in-out shadow-inner focus:outline-none focus:border-blue-500 focus:shadow-outline" placeholder="Enter the text above" required>
                </div>
                <div class="flex gap-4">
                    <button type="button" class="submit-button bg-gray-500 hover:bg-gray-600 w-full py-3 px-6 text-white font-semibold rounded-lg transition duration-300 ease-in-out shadow-lg border-none cursor-pointer hover:translate-y-px active:translate-y-0 active:shadow-md" onclick="clearRegistrationForm('patient')">Clear All Details</button>
                    <button type="submit" class="submit-button w-full py-3 px-6 bg-blue-500 text-white font-semibold rounded-lg transition duration-300 ease-in-out shadow-lg border-none cursor-pointer hover:bg-blue-600 hover:translate-y-px active:translate-y-0 active:shadow-md">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for the login form functionality.
     It's placed at the end of the content to ensure all HTML elements
     are loaded before the script tries to access them. -->
<script>
    // Global state variables for user authentication and current view
    let isLoggedIn = false;
    let loggedInUserType = ''; // 'doctor', 'patient', 'admin'
    let loggedInUsername = '';
    let currentDashboardSection = 'overview'; // Default section for dashboards

    // Object to store generated captchas for different forms
    const captchas = {
        doctor: '',
        patient: '',
        admin: '',
        regDoctor: '', // Captcha for doctor registration
        regPatient: '' // Captcha for patient registration
    };

    // --- Mock Data (for demonstration purposes, will reset on page refresh) ---
    // In a real application, this data would be fetched from a backend database.

    // Array of mock doctor objects
    let doctors = [
        { id: 'D001', name: 'Dr. Alice Smith', specialization: 'Cardiology', availableSlots: ['09:00', '10:00', '11:00', '14:00', '15:00'] },
        { id: 'D002', name: 'Dr. Bob Johnson', specialization: 'Pediatrics', availableSlots: ['09:30', '10:30', '11:30', '13:30', '14:30'] },
        { id: 'D003', name: 'Dr. Carol White', specialization: 'Dermatology', availableSlots: ['08:00', '09:00', '10:00', '16:00', '17:00'] },
        { id: 'D004', name: 'Dr. David Green', specialization: 'Neurology', availableSlots: ['10:00', '11:00', '12:00', '14:00', '15:00'] },
        { id: 'D005', name: 'Dr. Emily Brown', specialization: 'Orthopedics', availableSlots: ['08:30', '09:30', '10:30', '13:00', '14:00'] },
        { id: 'D006', name: 'Dr. Frank Black', specialization: 'Ophthalmology', availableSlots: ['11:00', '12:00', '13:00', '15:00', '16:00'] },
        { id: 'D007', name: 'Dr. Grace Lee', specialization: 'Gastroenterology', availableSlots: ['09:00', '10:00', '11:00', '14:00', '15:00'] },
        { id: 'D008', name: 'Dr. Henry King', specialization: 'Urology', availableSlots: ['08:00', '09:00', '10:00', '16:00', '17:00'] },
        { id: 'D009', name: 'Dr. Ivy Chen', specialization: 'Endocrinology', availableSlots: ['13:00', '14:00', '15:00', '16:00', '17:00'] },
        { id: 'D010', name: 'Dr. Jack Wilson', specialization: 'Pulmonology', availableSlots: ['09:00', '10:00', '11:00', '13:00', '14:00'] },
        { id: 'D011', name: 'Dr. Karen Davis', specialization: 'Oncology', availableSlots: ['10:00', '11:00', '12:00', '15:00', '16:00'] },
        { id: 'D012', name: 'Dr. Liam Miller', specialization: 'Nephrology', availableSlots: ['08:30', '09:30', '10:30', '14:30', '15:30'] },
        { id: 'D013', name: 'Dr. Mia Garcia', specialization: 'Rheumatology', availableSlots: ['11:00', '12:00', '13:00', '16:00', '17:00'] },
        { id: 'D014', name: 'Dr. Noah Rodriguez', specialization: 'Infectious Disease', availableSlots: ['09:00', '10:00', '11:00', '13:00', '14:00'] },
        { id: 'D015', name: 'Dr. Olivia Martinez', specialization: 'Psychiatry', availableSlots: ['13:00', '14:00', '15:00', '16:00', '17:00'] },
        { id: 'D016', name: 'Dr. Peter Hernandez', specialization: 'Allergy & Immunology', availableSlots: ['08:00', '09:00', '10:00', '11:00', '12:00'] },
        { id: 'D017', name: 'Dr. Quinn Lopez', specialization: 'Sports Medicine', availableSlots: ['10:00', '11:00', '12:00', '14:00', '15:00'] },
        { id: 'D018', name: 'Dr. Rachel Perez', specialization: 'Geriatrics', availableSlots: ['09:30', '10:30', '11:30', '13:30', '14:30'] },
        { id: 'D019', name: 'Dr. Sam Gonzalez', specialization: 'Pain Management', availableSlots: ['08:00', '09:00', '10:00', '15:00', '16:00'] },
        { id: 'D020', name: 'Dr. Tina Scott', specialization: 'Sleep Medicine', availableSlots: ['11:00', '12:00', '13:00', '14:00', '15:00'] },
        { id: 'D021', name: 'Dr. Victor Adams', specialization: 'Emergency Medicine', availableSlots: ['07:00', '08:00', '09:00', '10:00', '11:00'] },
        { id: 'D022', name: 'Dr. Wendy Baker', specialization: 'Plastic Surgery', availableSlots: ['10:00', '11:00', '12:00', '13:00', '14:00'] },
        { id: 'D023', name: 'Dr. Xavier Hall', specialization: 'Vascular Surgery', availableSlots: ['13:00', '14:00', '15:00', '16:00', '17:00'] },
        { id: 'D024', name: 'Dr. Yolanda Young', specialization: 'Oncological Surgery', availableSlots: ['08:00', '09:00', '10:00', '11:00', '12:00'] },
        { id: 'D025', name: 'Dr. Zoe Wright', specialization: 'Cardiac Surgery', availableSlots: ['11:00', '12:00', '13:00', '14:00', '15:00'] }
    ];

    // Array of mock patient objects
    let patients = [
        { id: 'P001', name: 'Rohan Kapri', disease: 'Common Cold', roomBed: 'A-101' },
        { id: 'P002', name: 'Jane Doe', disease: 'Flu', roomBed: 'A-102' },
        { id: 'P003', name: 'John Smith', disease: 'Migraine', roomBed: 'B-201' },
        { id: 'P004', name: 'Emily White', disease: 'Asthma', roomBed: 'B-202' },
        { id: 'P005', name: 'Michael Brown', disease: 'Diabetes', roomBed: 'C-301' },
        { id: 'P006', name: 'Sarah Green', disease: 'Hypertension', roomBed: 'C-302' },
        { id: 'P007', name: 'Chris Evans', disease: 'Arthritis', roomBed: 'D-401' },
        { id: 'P008', name: 'Jessica Alba', disease: 'Allergy', roomBed: 'D-402' },
        { id: 'P009', name: 'David Lee', disease: 'Back Pain', roomBed: 'E-501' },
        { id: 'P010', name: 'Laura Kim', disease: 'Dermatitis', roomBed: 'E-502' },
        { id: 'P011', name: 'Daniel Clark', disease: 'Anxiety', roomBed: 'F-601' },
        { id: 'P012', name: 'Sophia Lewis', disease: 'Gastroenteritis', roomBed: 'F-602' },
        { id: 'P013', name: 'Matthew Hall', disease: 'Bronchitis', roomBed: 'G-701' },
        { id: 'P014', name: 'Olivia Young', disease: 'Sinusitis', roomBed: 'G-702' },
        { id: 'P015', name: 'James King', disease: 'Insomnia', roomBed: 'H-801' },
    ];

    // Counter for generating unique appointment IDs
    let appointmentCounter = 1;

    // Array to store all appointments in the system
    let allAppointments = [];

    /**
     * Generates a unique appointment ID.
     * @returns {string} A unique appointment ID.
     */
    function generateAppointmentId() {
        return `APP${String(appointmentCounter++).padStart(4, '0')}`;
    }

    /**
     * Generates a random future date within the next 30 days.
     * @returns {string} Date in YYYY-MM-DD format.
     */
    function getRandomFutureDate() {
        const today = new Date();
        const futureDate = new Date(today);
        futureDate.setDate(today.getDate() + Math.floor(Math.random() * 30) + 1); // 1 to 30 days in future
        return futureDate.toISOString().slice(0, 10);
    }

    /**
     * Picks a random time slot from a doctor's available slots.
     * @param {Array<string>} slots - Array of available time slots.
     * @returns {string} A random time slot.
     */
    function getRandomSlot(slots) {
        if (slots.length === 0) return 'N/A';
        return slots[Math.floor(Math.random() * slots.length)];
    }

    // Simulate some initial appointments for a more populated dashboard
    // These appointments are distributed among doctors and patients
    function seedInitialAppointments() {
        const mockDiseases = ['Fever', 'Headache', 'Dizziness', 'Cough', 'Rash', 'Stomach Ache', 'Fatigue', 'Sore Throat'];
        const statuses = ['Pending', 'Accepted', 'Rejected', 'Approved', 'Cancelled'];

        for (let i = 0; i < 15; i++) { // Create at least 15 initial appointments
            const randomPatient = patients[Math.floor(Math.random() * patients.length)];
            const randomDoctor = doctors[Math.floor(Math.random() * doctors.length)];
            const randomDisease = mockDiseases[Math.floor(Math.random() * mockDiseases.length)];
            const randomStatus = statuses[Math.floor(Math.random() * statuses.length)];
            const randomDate = getRandomFutureDate();
            const randomTime = getRandomSlot(randomDoctor.availableSlots);

            allAppointments.push({
                id: generateAppointmentId(),
                patientId: randomPatient.id,
                patientName: randomPatient.name,
                doctorId: randomDoctor.id,
                doctorName: randomDoctor.name,
                specialization: randomDoctor.specialization,
                disease: randomDisease,
                date: randomDate,
                time: randomTime,
                status: randomStatus
            });
        }
    }

    // Call to seed initial appointments when the script loads
    seedInitialAppointments();

    // --- DOM Elements ---
    const loginPageContainer = document.getElementById('loginPageContainer');
    const mainDashboardContainer = document.getElementById('mainDashboardContainer');
    const topAuthButton = document.getElementById('topAuthButton');
    const panelButtons = document.querySelectorAll('.panel-button');
    const formPanels = document.querySelectorAll('.form-panel');
    const formArea = document.getElementById('formArea');
    const dashboardSidebarNav = document.getElementById('dashboardSidebarNav');

    // Patient Dashboard Elements
    const patientDashboardOverview = document.getElementById('patientDashboardOverview');
    const patientDashboardBookAppointment = document.getElementById('patientDashboardBookAppointment');
    const patientDashboardMyAppointments = document.getElementById('patientDashboardMyAppointments');
    const doctorsListContainer = document.getElementById('doctorsList');
    const patientBookedCount = document.getElementById('patientBookedCount');
    const patientCancelledCount = document.getElementById('patientCancelledCount');
    const patientAppointmentsTableBody = document.getElementById('patientAppointmentsTable');
    let patientAppointmentStatusChartInstance;
    let patientSpecializationChartInstance;

    // Doctor Dashboard Elements
    const doctorDashboardOverview = document.getElementById('doctorDashboardOverview');
    const doctorDashboardAppointments = document.getElementById('doctorDashboardAppointments');
    const doctorDashboardMyPatients = document.getElementById('doctorDashboardMyPatients');
    const doctorDashboardSchedule = document.getElementById('doctorDashboardSchedule');
    const doctorTotalPatients = document.getElementById('doctorTotalPatients');
    const doctorAcceptedAppointments = document.getElementById('doctorAcceptedAppointments');
    const doctorPendingAppointments = document.getElementById('doctorPendingAppointments');
    const doctorRejectedAppointments = document.getElementById('doctorRejectedAppointments');
    const doctorAppointmentsList = document.getElementById('doctorAppointmentsList');
    const doctorPatientListTableBody = document.getElementById('doctorPatientListTable');
    const doctorScheduleSlots = document.getElementById('doctorScheduleSlots');
    let doctorAppointmentStatusChartInstance;
    let doctorPatientsByDiseaseChartInstance;

    // Admin Dashboard Elements
    const adminDashboardOverview = document.getElementById('adminDashboardOverview');
    const adminDashboardManageDoctors = document.getElementById('adminDashboardManageDoctors');
    const adminDashboardManagePatients = document.getElementById('adminDashboardManagePatients');
    const adminDashboardManageAppointments = document.getElementById('adminDashboardManageAppointments');
    const adminDashboardSystemLogs = document.getElementById('adminDashboardSystemLogs');
    const adminTotalDoctors = document.getElementById('adminTotalDoctors');
    const adminTotalPatients = document.getElementById('adminTotalPatients');
    const adminTotalAppointments = document.getElementById('adminTotalAppointments');
    const newDoctorNameInput = document.getElementById('newDoctorName');
    const newDoctorSpecializationInput = document.getElementById('newDoctorSpecialization');
    const removeDoctorIdInput = document.getElementById('removeDoctorId');
    const slotDoctorIdInput = document.getElementById('slotDoctorId');
    const newSlotTimeInput = document.getElementById('newSlotTime');
    const cancelAppointmentIdInput = document.getElementById('cancelAppointmentId');
    const adminDoctorsTableBody = document.getElementById('adminDoctorsTable');
    const adminPatientsTableBody = document.getElementById('adminPatientsTable');
    const adminAppointmentsTableBody = document.getElementById('adminAppointmentsTable');
    let adminAppointmentStatusChartInstance;
    let adminDoctorsBySpecializationChartInstance;


    // --- Utility Functions for Modals (unchanged from previous version, but included for completeness) ---

    /**
     * Shows a modal overlay.
     * @param {HTMLElement} modalElement - The modal overlay element to show.
     */
    function showModal(modalElement) {
        modalElement.style.display = 'flex';
        modalElement.offsetWidth; // Trigger reflow for transition
        modalElement.classList.add('active');
    }

    /**
     * Hides a modal overlay.
     * @param {HTMLElement} modalElement - The modal overlay element to hide.
     */
    function closeModal(modalElement) {
        modalElement.classList.remove('active');
        const onTransitionEnd = () => {
            modalElement.style.display = 'none';
            modalElement.removeEventListener('transitionend', onTransitionEnd);
        };
        modalElement.addEventListener('transitionend', onTransitionEnd);
        setTimeout(() => {
            if (modalElement.classList.contains('active') === false && modalElement.style.display !== 'none') {
                modalElement.style.display = 'none';
            }
        }, 350);
    }

    /**
     * Generates a simple alphanumeric captcha and displays it.
     * @param {string} panelType - The type of panel (e.g., 'doctor', 'patient', 'regDoctor').
     */
    function generateCaptcha(panelType) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let captcha = '';
        for (let i = 0; i < 6; i++) {
            captcha += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        captchas[panelType] = captcha;
        const captchaTextElement = document.getElementById(`${panelType}CaptchaText`);
        if (captchaTextElement) {
            captchaTextElement.innerText = captcha;
        }
    }

    /**
     * Shows the custom alert modal with a given title and message.
     * @param {string} title - The title of the alert.
     * @param {string} message - The message content of the alert.
     */
    function showCustomAlert(title, message) {
        document.getElementById('customAlertTitle').innerText = title;
        document.getElementById('customAlertMessage').innerText = message;
        showModal(document.getElementById('customAlertModal'));
    }

    /**
     * Closes the custom alert modal.
     */
    function closeCustomAlert() {
        closeModal(document.getElementById('customAlertModal'));
    }

    // --- Login Form Panel Management ---

    /**
     * Displays the specified login panel and updates the UI.
     * @param {string} panelType - The type of panel to show ('doctor', 'patient', 'admin').
     */
    function showPanel(panelType) {
        if (isLoggedIn) {
            showCustomAlert('Access Denied', 'Please log out first to switch panels.');
            return;
        }

        panelButtons.forEach(button => {
            button.classList.remove('active');
        });
        const activeButton = document.querySelector(`.panel-button[data-panel="${panelType}"]`);
        if (activeButton) {
            activeButton.classList.add('active');
        }

        formPanels.forEach(panel => {
            panel.classList.remove('active');
            panel.style.display = 'none';
        });
        const targetPanel = document.getElementById(`${panelType}Panel`);
        if (targetPanel) {
            targetPanel.classList.add('active');
            targetPanel.style.display = 'block';
        }

        formArea.classList.remove('doctor-pattern', 'patient-pattern', 'admin-pattern');
        formArea.classList.add(`${panelType}-pattern`);
        generateCaptcha(panelType);
    }

    // --- Login/Logout Functionality ---

    /**
     * Updates the text and functionality of the top Login/Logout button.
     */
    function updateLoginButton() {
        if (isLoggedIn) {
            topAuthButton.innerText = `Logout (${loggedInUsername})`;
            topAuthButton.classList.add('bg-red-500', 'hover:bg-red-600');
            topAuthButton.classList.remove('bg-blue-500', 'hover:bg-blue-600');
            panelButtons.forEach(button => button.disabled = true);
        } else {
            topAuthButton.innerText = 'Login';
            topAuthButton.classList.add('bg-blue-500', 'hover:bg-blue-600');
            topAuthButton.classList.remove('bg-red-500', 'hover:bg-red-600');
            panelButtons.forEach(button => button.disabled = false);
        }
    }

    /**
     * Handles the click action on the top Login/Logout button.
     * Logs out the user if already logged in, otherwise prompts to use forms.
     */
    function handleAuthAction() {
        if (isLoggedIn) {
            isLoggedIn = false;
            loggedInUserType = '';
            loggedInUsername = '';
            updateLoginButton();
            showCustomAlert('Logged Out', 'You have been successfully logged out.');
            // Hide dashboard, show login page
            mainDashboardContainer.style.display = 'none';
            loginPageContainer.style.display = 'block';
            showPanel('doctor'); // Revert to default login panel
        } else {
            showCustomAlert('Login', 'Please use the forms below to log in.');
        }
    }

    /**
     * Simulates the login process for a given panel type.
     * @param {string} panelType - The type of panel ('doctor', 'patient', 'admin').
     */
    function login(panelType) {
        const usernameInput = document.getElementById(`${panelType}Username`);
        const passwordInput = document.getElementById(`${panelType}Password`);
        const captchaInput = document.getElementById(`${panelType}CaptchaInput`);

        const username = usernameInput.value.trim();
        const password = passwordInput.value.trim();
        const enteredCaptcha = captchaInput.value.trim();

        if (!username || !password || !enteredCaptcha) {
            showCustomAlert('Login Failed', 'All fields are required.');
            return;
        }

        if (enteredCaptcha.toLowerCase() !== captchas[panelType].toLowerCase()) {
            showCustomAlert('Login Failed', 'Incorrect captcha. Please try again.');
            generateCaptcha(panelType);
            captchaInput.value = '';
            return;
        }

        // --- Simulated Authentication ---
        // In a real application, you would send these credentials to a backend for verification.
        if (username === 'admin' && password === 'adminpass') {
            isLoggedIn = true;
            loggedInUserType = 'admin';
            loggedInUsername = username;
        } else if (username === 'doctor' && password === 'doctorpass') {
            isLoggedIn = true;
            loggedInUserType = 'doctor';
            loggedInUsername = username;
        } else if (username === 'patient' && password === 'patientpass') {
            isLoggedIn = true;
            loggedInUserType = 'patient';
            loggedInUsername = username;
        } else {
            showCustomAlert('Login Failed', 'Invalid username or password.');
            generateCaptcha(panelType);
            usernameInput.value = '';
            passwordInput.value = '';
            captchaInput.value = '';
            return;
        }

        updateLoginButton();
        showCustomAlert('Login Successful', `Welcome, ${username}! Redirecting to your dashboard.`);

        // Hide login page and show main dashboard
        loginPageContainer.style.display = 'none';
        mainDashboardContainer.style.display = 'flex';

        // Initialize sidebar and show the appropriate dashboard section
        setupDashboardSidebar(loggedInUserType);
        showDashboardContent(loggedInUserType, 'overview'); // Always start with overview

        // Clear login form fields
        usernameInput.value = '';
        passwordInput.value = '';
        captchaInput.value = '';
        generateCaptcha(panelType);
    }

    // --- Forgot Password Functionality (unchanged) ---
    let currentForgotPasswordPanel = '';

    function showForgotPasswordModal(panelType) {
        currentForgotPasswordPanel = panelType;
        document.getElementById('forgotPasswordStep1').style.display = 'block';
        document.getElementById('forgotPasswordStep2').style.display = 'none';
        document.getElementById('forgotPhone').value = '';
        document.getElementById('forgotOTP').value = '';
        document.getElementById('newPassword').value = '';
        document.getElementById('confirmNewPassword').value = '';
        showModal(document.getElementById('forgotPasswordModal'));
    }

    function closeForgotPasswordModal() {
        closeModal(document.getElementById('forgotPasswordModal'));
    }

    function sendOTP() {
        const phoneNumber = document.getElementById('forgotPhone').value.trim();
        if (!phoneNumber) {
            showCustomAlert('Error', 'Please enter your phone number.');
            return;
        }
        if (!/^\+\d{1,3}-\d{7,15}$/.test(phoneNumber)) {
            showCustomAlert('Error', 'Please enter a valid phone number, e.g., +91-1234567890');
            return;
        }
        const otp = Math.floor(100000 + Math.random() * 900000);
        console.log(`Simulated OTP for ${phoneNumber}: ${otp}`);
        showCustomAlert('OTP Sent', `A 6-digit OTP has been sent to ${phoneNumber}. (Simulated: ${otp})`);
        setTimeout(() => {
            document.getElementById('forgotPasswordStep1').style.display = 'none';
            document.getElementById('forgotPasswordStep2').style.display = 'block';
        }, 1000);
    }

    function resetPassword() {
        const enteredOTP = document.getElementById('forgotOTP').value.trim();
        const newPassword = document.getElementById('newPassword').value.trim();
        const confirmNewPassword = document.getElementById('confirmNewPassword').value.trim();

        if (!enteredOTP || !newPassword || !confirmNewPassword) {
            showCustomAlert('Error', 'All fields are required.');
            return;
        }
        if (newPassword !== confirmNewPassword) {
            showCustomAlert('Error', 'New password and confirm password do not match.');
            return;
        }
        if (newPassword.length < 6) {
            showCustomAlert('Error', 'Password must be at least 6 characters long.');
            return;
        }
        showCustomAlert('Success', `Password for ${currentForgotPasswordPanel} account has been reset. Thank you for submitting the form, we will connect soon.`);
        closeForgotPasswordModal();
    }

    // --- Registration Functionality (unchanged) ---

    function showRegistrationModal(panelType) {
        showModal(document.getElementById(`${panelType}RegistrationModal`));
        generateCaptcha(`reg${panelType.charAt(0).toUpperCase() + panelType.slice(1)}`);
    }

    function closeRegistrationModal(panelType) {
        closeModal(document.getElementById(`${panelType}RegistrationModal`));
        clearRegistrationForm(panelType);
    }

    function clearRegistrationForm(panelType) {
        document.getElementById(`reg${panelType.charAt(0).toUpperCase() + panelType.slice(1)}Username`).value = '';
        document.getElementById(`reg${panelType.charAt(0).toUpperCase() + panelType.slice(1)}Password`).value = '';
        document.getElementById(`reg${panelType.charAt(0).toUpperCase() + panelType.slice(1)}ConfirmPassword`).value = '';
        document.getElementById(`reg${panelType.charAt(0).toUpperCase() + panelType.slice(1)}CaptchaInput`).value = '';
        generateCaptcha(`reg${panelType.charAt(0).toUpperCase() + panelType.slice(1)}`);
    }

    function registerUser(panelType) {
        const usernameInput = document.getElementById(`reg${panelType.charAt(0).toUpperCase() + panelType.slice(1)}Username`);
        const passwordInput = document.getElementById(`reg${panelType.charAt(0).toUpperCase() + panelType.slice(1)}Password`);
        const confirmPasswordInput = document.getElementById(`reg${panelType.charAt(0).toUpperCase() + panelType.slice(1)}ConfirmPassword`);
        const captchaInput = document.getElementById(`reg${panelType.charAt(0).toUpperCase() + panelType.slice(1)}CaptchaInput`);

        const username = usernameInput.value.trim();
        const password = passwordInput.value.trim();
        const confirmPassword = confirmPasswordInput.value.trim();
        const enteredCaptcha = captchaInput.value.trim();
        const captchaKey = `reg${panelType.charAt(0).toUpperCase() + panelType.slice(1)}`;

        if (!username || !password || !confirmPassword || !enteredCaptcha) {
            showCustomAlert('Registration Failed', 'All fields are required.');
            return;
        }

        if (password !== confirmPassword) {
            showCustomAlert('Registration Failed', 'Passwords do not match.');
            return;
        }

        if (password.length < 6) {
            showCustomAlert('Registration Failed', 'Password must be at least 6 characters long.');
            return;
        }

        if (enteredCaptcha.toLowerCase() !== captchas[captchaKey].toLowerCase()) {
            showCustomAlert('Registration Failed', 'Incorrect captcha. Please try again.');
            generateCaptcha(captchaKey);
            captchaInput.value = '';
            return;
        }

        showCustomAlert('Registration Successful', `Thank you for registering as a ${panelType}, ${username}! We will connect soon.`);
        closeRegistrationModal(panelType);
    }

    // --- Dashboard Sidebar Navigation Setup ---

    /**
     * Sets up the sidebar navigation links based on the logged-in user type.
     * @param {string} userType - The type of the logged-in user ('patient', 'doctor', 'admin').
     */
    function setupDashboardSidebar(userType) {
        dashboardSidebarNav.innerHTML = ''; // Clear existing links

        let links = [];
        if (userType === 'patient') {
            links = [
                { text: 'Dashboard', icon: 'fas fa-th-large', section: 'overview' },
                { text: 'Book Appointment', icon: 'fas fa-calendar-plus', section: 'bookAppointment' },
                { text: 'My Appointments', icon: 'fas fa-calendar-check', section: 'myAppointments' }
            ];
        } else if (userType === 'doctor') {
            links = [
                { text: 'Dashboard', icon: 'fas fa-th-large', section: 'overview' },
                { text: 'My Appointments', icon: 'fas fa-calendar-alt', section: 'appointments' },
                { text: 'My Patients', icon: 'fas fa-user-injured', section: 'myPatients' },
                { text: 'My Schedule', icon: 'fas fa-clock', section: 'schedule' }
            ];
        } else if (userType === 'admin') {
            links = [
                { text: 'Dashboard', icon: 'fas fa-th-large', section: 'overview' },
                { text: 'Manage Doctors', icon: 'fas fa-user-md', section: 'manageDoctors' },
                { text: 'Manage Patients', icon: 'fas fa-user-injured', section: 'managePatients' },
                { text: 'Manage Appointments', icon: 'fas fa-calendar-alt', section: 'manageAppointments' },
                { text: 'System Logs', icon: 'fas fa-clipboard-list', section: 'systemLogs' }
            ];
        }

        links.forEach(link => {
            const anchor = document.createElement('a');
            anchor.href = '#';
            anchor.className = `dashboard-nav-link ${link.section === currentDashboardSection ? 'active' : ''}`;
            anchor.setAttribute('data-dashboard-link', link.section);
            anchor.innerHTML = `<i class="${link.icon} text-xl"></i><span>${link.text}</span>`;
            anchor.addEventListener('click', (event) => {
                event.preventDefault();
                currentDashboardSection = link.section; // Update current section
                showDashboardContent(userType, link.section);

                // Update active class on sidebar links
                document.querySelectorAll('.dashboard-nav-link').forEach(l => l.classList.remove('active'));
                event.currentTarget.classList.add('active');
            });
            dashboardSidebarNav.appendChild(anchor);
        });
    }

    /**
     * Shows the content for the specified dashboard section for the given user type.
     * @param {string} userType - The type of the logged-in user ('patient', 'doctor', 'admin').
     * @param {string} section - The specific section to display (e.g., 'overview', 'bookAppointment').
     */
    function showDashboardContent(userType, section) {
        // Hide all dashboard panels first
        const allDashboardPanels = document.querySelectorAll('.dashboard-panel');
        allDashboardPanels.forEach(panel => {
            panel.style.display = 'none';
        });

        // Show the specific panel based on userType and section
        const targetPanelId = `${userType}Dashboard${section.charAt(0).toUpperCase() + section.slice(1)}`;
        const targetPanel = document.getElementById(targetPanelId);

        if (targetPanel) {
            targetPanel.style.display = 'block';
            // Call rendering functions specific to the active section
            if (userType === 'patient') {
                if (section === 'overview') {
                    renderPatientOverview();
                    renderPatientCharts();
                } else if (section === 'bookAppointment') {
                    renderDoctorsListForPatient();
                } else if (section === 'myAppointments') {
                    renderPatientAppointmentsTable();
                }
            } else if (userType === 'doctor') {
                if (section === 'overview') {
                    renderDoctorOverview();
                    renderDoctorCharts();
                } else if (section === 'appointments') {
                    renderDoctorAppointments();
                } else if (section === 'myPatients') {
                    renderDoctorPatientList();
                } else if (section === 'schedule') {
                    renderDoctorSchedule();
                }
            } else if (userType === 'admin') {
                if (section === 'overview') {
                    renderAdminOverview();
                    renderAdminCharts();
                } else if (section === 'manageDoctors') {
                    renderAdminDoctorsTable();
                } else if (section === 'managePatients') {
                    renderAdminPatientsTable();
                } else if (section === 'manageAppointments') {
                    renderAdminAppointmentsTable();
                } else if (section === 'systemLogs') {
                    // System logs are static for this demo
                }
            }
        } else {
            console.error(`Dashboard panel not found: ${targetPanelId}`);
        }

        // Update active class on sidebar links
        document.querySelectorAll('.dashboard-nav-link').forEach(link => {
            if (link.dataset.dashboardLink === section) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }


    // --- Patient Dashboard Functions ---

    /**
     * Renders the patient's overview statistics.
     */
    function renderPatientOverview() {
        const patientSpecificAppointments = allAppointments.filter(app => app.patientName === loggedInUsername);
        const bookedCount = patientSpecificAppointments.filter(app => app.status === 'Approved').length;
        const cancelledCount = patientSpecificAppointments.filter(app => app.status === 'Cancelled').length;
        patientBookedCount.innerText = bookedCount;
        patientCancelledCount.innerText = cancelledCount;
    }

    /**
     * Renders the list of doctors available for appointment booking for the patient.
     */
    function renderDoctorsListForPatient() {
        doctorsListContainer.innerHTML = '';
        if (doctors.length === 0) {
            doctorsListContainer.innerHTML = `<p class="text-gray-500 col-span-full text-center">No doctors available for booking.</p>`;
            return;
        }

        doctors.forEach(doctor => {
            const patientSpecificAppointment = allAppointments.find(app => app.doctorId === doctor.id && app.patientName === loggedInUsername);
            const buttonClass = getAppointmentButtonClass(patientSpecificAppointment);
            const buttonText = getAppointmentButtonText(patientSpecificAppointment);

            const doctorCard = document.createElement('div');
            doctorCard.className = 'dashboard-card p-4 flex flex-col items-center text-center';
            doctorCard.innerHTML = `
                <img src="https://placehold.co/100x100/e0f2fe/3b82f6?text=DR" alt="${doctor.name}" class="rounded-full mb-3 border-4 border-blue-200">
                <h3 class="text-xl font-semibold text-gray-800">${doctor.name}</h3>
                <p class="text-blue-600 mb-3">${doctor.specialization}</p>
                <button class="book-appointment-btn w-full py-2 px-4 rounded-lg font-semibold transition duration-300 ease-in-out shadow-md ${buttonClass}"
                    data-doctor-id="${doctor.id}" data-doctor-name="${doctor.name}" data-specialization="${doctor.specialization}"
                    onclick="toggleAppointmentStatusForPatient('${doctor.id}', '${doctor.name}', '${doctor.specialization}', this)">
                    ${buttonText}
                </button>
            `;
            doctorsListContainer.appendChild(doctorCard);
        });
    }

    /**
     * Determines the CSS class for the appointment button based on current status for a patient.
     * @param {object | undefined} appointment - The appointment object or undefined if not found.
     * @returns {string} CSS classes for the button.
     */
    function getAppointmentButtonClass(appointment) {
        if (appointment) {
            if (appointment.status === 'Approved') {
                return 'bg-green-500 text-white hover:bg-green-600';
            } else if (appointment.status === 'Cancelled') {
                return 'bg-red-500 text-white hover:bg-red-600';
            }
        }
        return 'bg-blue-500 text-white hover:bg-blue-600';
    }

    /**
     * Determines the text for the appointment button based on current status for a patient.
     * @param {object | undefined} appointment - The appointment object or undefined if not found.
     * @returns {string} Text for the button.
     */
    function getAppointmentButtonText(appointment) {
        if (appointment) {
            return appointment.status;
        }
        return 'Book Appointment';
    }

    /**
     * Toggles the appointment status (Book -> Approved -> Cancelled) for a patient.
     * Updates both the global allAppointments array and the patient's specific view.
     * @param {string} doctorId - The ID of the doctor.
     * @param {string} doctorName - The name of the doctor.
     * @param {string} specialization - The specialization of the doctor.
     * @param {HTMLElement} buttonElement - The button element that was clicked.
     */
    function toggleAppointmentStatusForPatient(doctorId, doctorName, specialization, buttonElement) {
        const patientUsername = loggedInUsername;
        let appointment = allAppointments.find(app => app.doctorId === doctorId && app.patientName === patientUsername);

        if (!appointment) {
            // Book new appointment
            const newAppointment = {
                id: generateAppointmentId(),
                patientId: patients.find(p => p.name === patientUsername)?.id || 'P000', // Find patient ID or default
                patientName: patientUsername,
                doctorId: doctorId,
                doctorName: doctorName,
                specialization: specialization,
                disease: 'General Checkup', // Default disease for new booking
                date: getRandomFutureDate(),
                time: getRandomSlot(doctors.find(d => d.id === doctorId)?.availableSlots || []),
                status: 'Approved' // Directly approved on patient booking for simplicity
            };
            allAppointments.push(newAppointment);
            showCustomAlert('Appointment Booked', `You have successfully booked an appointment with ${doctorName} for ${newAppointment.date} at ${newAppointment.time}.`);
        } else if (appointment.status === 'Approved') {
            // Change to Cancelled
            appointment.status = 'Cancelled';
            showCustomAlert('Appointment Cancelled', `Your appointment with ${doctorName} has been cancelled.`);
        } else if (appointment.status === 'Cancelled') {
            // Change back to Approved (re-book)
            appointment.status = 'Approved';
            showCustomAlert('Appointment Re-booked', `Your appointment with ${doctorName} has been re-booked.`);
        }

        // Re-render relevant sections to reflect changes
        renderDoctorsListForPatient(); // Update button state
        renderPatientAppointmentsTable(); // Update patient's own table
        renderPatientOverview(); // Update patient stats
        // Also update other dashboards if they are active
        if (loggedInUserType === 'doctor') renderDoctorDashboard();
        if (loggedInUserType === 'admin') renderAdminDashboard();
    }

    /**
     * Renders the patient's booked appointments in a table.
     */
    function renderPatientAppointmentsTable() {
        patientAppointmentsTableBody.innerHTML = '';
        const patientSpecificAppointments = allAppointments.filter(app => app.patientName === loggedInUsername);

        if (patientSpecificAppointments.length === 0) {
            patientAppointmentsTableBody.innerHTML = `<tr><td colspan="8" class="py-4 text-center text-gray-500">No appointments booked yet.</td></tr>`;
            return;
        }

        patientSpecificAppointments.forEach(app => {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-200 hover:bg-gray-50';
            let statusClass = '';
            if (app.status === 'Approved') {
                statusClass = 'bg-green-200 text-green-800';
            } else if (app.status === 'Cancelled') {
                statusClass = 'bg-red-200 text-red-800';
            } else if (app.status === 'Pending') {
                statusClass = 'bg-yellow-200 text-yellow-800';
            } else if (app.status === 'Rejected') {
                statusClass = 'bg-gray-200 text-gray-800'; // Or another color for rejected
            } else if (app.status === 'Cancelled by Admin') {
                statusClass = 'bg-gray-300 text-gray-700';
            }

            row.innerHTML = `
                <td class="py-3 px-6 text-left whitespace-nowrap">${app.id}</td>
                <td class="py-3 px-6 text-left">${app.doctorName}</td>
                <td class="py-3 px-6 text-left">${app.specialization}</td>
                <td class="py-3 px-6 text-left">${app.disease}</td>
                <td class="py-3 px-6 text-left">${app.date}</td>
                <td class="py-3 px-6 text-left">${app.time}</td>
                <td class="py-3 px-6 text-left">
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                        <span aria-hidden="true" class="absolute inset-0 opacity-50 rounded-full ${statusClass}"></span>
                        <span class="relative">${app.status}</span>
                    </span>
                </td>
                <td class="py-3 px-6 text-center">
                    ${app.status !== 'Cancelled by Admin' ? `
                        <button class="py-1 px-3 rounded-md text-white
                            ${app.status === 'Cancelled' ? 'bg-blue-500 hover:bg-blue-600' : 'bg-red-500 hover:bg-red-600'}"
                            onclick="toggleAppointmentStatusForPatient('${app.doctorId}', '${app.doctorName}', '${app.specialization}', this)">
                            ${app.status === 'Cancelled' ? 'Re-book' : 'Cancel'}
                        </button>
                    ` : '<span class="text-gray-500">N/A</span>'}
                </td>
            `;
            patientAppointmentsTableBody.appendChild(row);
        });
    }

    /**
     * Renders charts for the patient dashboard.
     */
    function renderPatientCharts() {
        // Destroy existing chart instances if they exist
        if (patientAppointmentStatusChartInstance) {
            patientAppointmentStatusChartInstance.destroy();
        }
        if (patientSpecializationChartInstance) {
            patientSpecializationChartInstance.destroy();
        }

        const patientSpecificAppointments = allAppointments.filter(app => app.patientName === loggedInUsername);

        // Patient Appointment Status Chart
        const patientAppointmentStatusCtx = document.getElementById('patientAppointmentStatusChart').getContext('2d');
        const statusCounts = patientSpecificAppointments.reduce((acc, app) => {
            acc[app.status] = (acc[app.status] || 0) + 1;
            return acc;
        }, {});

        patientAppointmentStatusChartInstance = new Chart(patientAppointmentStatusCtx, {
            type: 'pie',
            data: {
                labels: Object.keys(statusCounts),
                datasets: [{
                    data: Object.values(statusCounts),
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)', // Approved
                        'rgba(255, 99, 132, 0.6)', // Cancelled
                        'rgba(255, 206, 86, 0.6)', // Pending
                        'rgba(150, 150, 150, 0.6)' // Rejected/Cancelled by Admin
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(150, 150, 150, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'My Appointment Status'
                    }
                }
            }
        });

        // Appointments by Specialization Chart (Patient's perspective)
        const patientSpecializationCtx = document.getElementById('patientSpecializationChart').getContext('2d');
        const specializationCounts = patientSpecificAppointments.reduce((acc, app) => {
            acc[app.specialization] = (acc[app.specialization] || 0) + 1;
            return acc;
        }, {});

        patientSpecializationChartInstance = new Chart(patientSpecializationCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(specializationCounts),
                datasets: [{
                    label: 'Appointments',
                    data: Object.values(specializationCounts),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)', // Blue
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false,
                        text: 'Appointments by Specialization'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }


    // --- Doctor Dashboard Functions ---

    /**
     * Renders the doctor's overview cards.
     */
    function renderDoctorOverview() {
        // Filter appointments relevant to the logged-in doctor
        const myAppointments = allAppointments.filter(app => app.doctorId === 'D001'); // Assuming D001 is the logged-in doctor for demo
        const accepted = myAppointments.filter(app => app.status === 'Accepted').length;
        const pending = myAppointments.filter(app => app.status === 'Pending').length;
        const rejected = myAppointments.filter(app => app.status === 'Rejected').length;
        const totalPatients = new Set(myAppointments.map(app => app.patientId)).size; // Unique patients

        doctorTotalPatients.innerText = totalPatients;
        doctorAcceptedAppointments.innerText = accepted;
        doctorPendingAppointments.innerText = pending;
        doctorRejectedAppointments.innerText = rejected;
    }

    /**
     * Renders the doctor's planned consultations/appointment requests.
     */
    function renderDoctorAppointments() {
        doctorAppointmentsList.innerHTML = '';
        const myAppointments = allAppointments.filter(app => app.doctorId === 'D001'); // Assuming D001 is the logged-in doctor for demo

        if (myAppointments.length === 0) {
            doctorAppointmentsList.innerHTML = `<p class="text-gray-500 col-span-full text-center">No appointments scheduled for you.</p>`;
            return;
        }

        myAppointments.forEach(app => {
            const appointmentCard = document.createElement('div');
            appointmentCard.className = 'dashboard-card p-4 flex flex-col md:flex-row items-center justify-between';
            let statusColorClass = '';
            if (app.status === 'Accepted') statusColorClass = 'text-green-500';
            else if (app.status === 'Pending') statusColorClass = 'text-yellow-500';
            else if (app.status === 'Rejected') statusColorClass = 'text-red-500';
            else if (app.status === 'Approved') statusColorClass = 'text-blue-500'; // Patient booked status
            else if (app.status === 'Cancelled') statusColorClass = 'text-gray-500'; // Patient cancelled status
            else if (app.status === 'Cancelled by Admin') statusColorClass = 'text-gray-600';


            appointmentCard.innerHTML = `
                <div class="flex items-center gap-4 mb-4 md:mb-0">
                    <img src="https://placehold.co/60x60/f0f9ff/3b82f6?text=PT" alt="${app.patientName}" class="rounded-full border-2 border-gray-200">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">${app.patientName} (ID: ${app.patientId})</h3>
                        <p class="text-gray-600 text-sm">Disease: ${app.disease}</p>
                    </div>
                </div>
                <div class="text-right md:text-left">
                    <p class="text-gray-600 text-sm"><i class="fas fa-calendar-alt mr-1"></i>${app.date}</p>
                    <p class="text-gray-600 text-sm"><i class="fas fa-clock mr-1"></i>${app.time}</p>
                    <p class="font-semibold ${statusColorClass}">Status: ${app.status}</p>
                </div>
                <div class="flex gap-2 mt-4 md:mt-0">
                    ${app.status === 'Pending' ? `
                        <button class="py-2 px-4 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300" onclick="acceptAppointment('${app.id}')">Accept</button>
                        <button class="py-2 px-4 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300" onclick="rejectAppointment('${app.id}')">Reject</button>
                    ` : `<span class="text-gray-500 text-sm">Actioned</span>`}
                </div>
            `;
            doctorAppointmentsList.appendChild(appointmentCard);
        });
    }

    /**
     * Accepts a doctor's appointment.
     * @param {string} appointmentId - The ID of the appointment to accept.
     */
    function acceptAppointment(appointmentId) {
        const appointment = allAppointments.find(app => app.id === appointmentId);
        if (appointment) {
            appointment.status = 'Accepted';
            showCustomAlert('Appointment Accepted', `Appointment ${appointmentId} with ${appointment.patientName} has been accepted.`);
            renderDoctorAppointments(); // Re-render to update UI
            renderDoctorOverview(); // Update stats
            renderPatientAppointmentsTable(); // Update patient view
            renderAdminAppointmentsTable(); // Update admin view
            renderDoctorCharts(); // Update charts
        }
    }

    /**
     * Rejects a doctor's appointment.
     * @param {string} appointmentId - The ID of the appointment to reject.
     */
    function rejectAppointment(appointmentId) {
        const appointment = allAppointments.find(app => app.id === appointmentId);
        if (appointment) {
            appointment.status = 'Rejected';
            showCustomAlert('Appointment Rejected', `Appointment ${appointmentId} with ${appointment.patientName} has been rejected.`);
            renderDoctorAppointments(); // Re-render to update UI
            renderDoctorOverview(); // Update stats
            renderPatientAppointmentsTable(); // Update patient view
            renderAdminAppointmentsTable(); // Update admin view
            renderDoctorCharts(); // Update charts
        }
    }

    /**
     * Renders the patient list for the doctor dashboard.
     */
    function renderDoctorPatientList() {
        doctorPatientListTableBody.innerHTML = '';
        // Filter patients who have appointments with the logged-in doctor
        const patientsWithAppointments = new Set(allAppointments
            .filter(app => app.doctorId === 'D001') // Assuming D001 is the logged-in doctor
            .map(app => app.patientId));

        const myPatients = patients.filter(p => patientsWithAppointments.has(p.id));

        if (myPatients.length === 0) {
            doctorPatientListTableBody.innerHTML = `<tr><td colspan="5" class="py-4 text-center text-gray-500">No patients associated with your appointments.</td></tr>`;
            return;
        }

        myPatients.forEach(patient => {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-200 hover:bg-gray-50';
            row.innerHTML = `
                <td class="py-3 px-6 text-left whitespace-nowrap">${patient.id}</td>
                <td class="py-3 px-6 text-left">${patient.name}</td>
                <td class="py-3 px-6 text-left">${new Date().toISOString().slice(0, 10)}</td> <!-- Mock check-in date -->
                <td class="py-3 px-6 text-left">${patient.disease}</td>
                <td class="py-3 px-6 text-left">${patient.roomBed}</td>
            `;
            doctorPatientListTableBody.appendChild(row);
        });
    }

    /**
     * Renders the doctor's schedule (available slots).
     */
    function renderDoctorSchedule() {
        doctorScheduleSlots.innerHTML = '';
        const doctor = doctors.find(d => d.id === 'D001'); // Assuming D001 is the logged-in doctor
        if (!doctor || doctor.availableSlots.length === 0) {
            doctorScheduleSlots.innerHTML = `<p class="text-gray-500 col-span-full text-center">No available slots set.</p>`;
            return;
        }

        doctor.availableSlots.forEach(slot => {
            const slotCard = document.createElement('div');
            slotCard.className = 'dashboard-card p-4 text-center border border-blue-200 bg-blue-50';
            slotCard.innerHTML = `
                <p class="text-lg font-semibold text-blue-800">${slot}</p>
                <p class="text-sm text-gray-600">Available</p>
            `;
            doctorScheduleSlots.appendChild(slotCard);
        });
    }

    /**
     * Renders charts for the doctor dashboard.
     */
    function renderDoctorCharts() {
        // Destroy existing chart instances if they exist
        if (doctorAppointmentStatusChartInstance) {
            doctorAppointmentStatusChartInstance.destroy();
        }
        if (doctorPatientsByDiseaseChartInstance) {
            doctorPatientsByDiseaseChartInstance.destroy();
        }

        const myAppointments = allAppointments.filter(app => app.doctorId === 'D001');
        const myPatients = patients.filter(p => new Set(myAppointments.map(app => app.patientId)).has(p.id));

        // Doctor Appointment Status Chart
        const doctorAppointmentStatusCtx = document.getElementById('doctorAppointmentStatusChart').getContext('2d');
        const statusCounts = myAppointments.reduce((acc, app) => {
            acc[app.status] = (acc[app.status] || 0) + 1;
            return acc;
        }, {});

        doctorAppointmentStatusChartInstance = new Chart(doctorAppointmentStatusCtx, {
            type: 'pie',
            data: {
                labels: Object.keys(statusCounts),
                datasets: [{
                    data: Object.values(statusCounts),
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)', // Accepted
                        'rgba(255, 206, 86, 0.6)', // Pending
                        'rgba(255, 99, 132, 0.6)', // Rejected
                        'rgba(54, 162, 235, 0.6)', // Approved (patient booked)
                        'rgba(150, 150, 150, 0.6)', // Cancelled
                        'rgba(100, 100, 100, 0.6)' // Cancelled by Admin
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(150, 150, 150, 1)',
                        'rgba(100, 100, 100, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'My Appointment Status'
                    }
                }
            }
        });

        // Patients by Disease Chart (My Patients)
        const doctorPatientsByDiseaseCtx = document.getElementById('doctorPatientsByDiseaseChart').getContext('2d');
        const diseaseCounts = myPatients.reduce((acc, patient) => {
            acc[patient.disease] = (acc[patient.disease] || 0) + 1;
            return acc;
        }, {});

        doctorPatientsByDiseaseChartInstance = new Chart(doctorPatientsByDiseaseCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(diseaseCounts),
                datasets: [{
                    label: 'Number of Patients',
                    data: Object.values(diseaseCounts),
                    backgroundColor: 'rgba(153, 102, 255, 0.6)', // Purple
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false,
                        text: 'Patients by Disease'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    // --- Admin Dashboard Functions ---

    /**
     * Updates admin overview statistics.
     */
    function renderAdminOverview() {
        adminTotalDoctors.innerText = doctors.length;
        adminTotalPatients.innerText = patients.length;
        adminTotalAppointments.innerText = allAppointments.length;
    }

    /**
     * Renders charts for the admin dashboard.
     */
    function renderAdminCharts() {
        // Destroy existing chart instances if they exist
        if (adminAppointmentStatusChartInstance) {
            adminAppointmentStatusChartInstance.destroy();
        }
        if (adminDoctorsBySpecializationChartInstance) {
            adminDoctorsBySpecializationChartInstance.destroy();
        }

        // Overall Appointment Status Chart
        const adminAppointmentStatusCtx = document.getElementById('adminAppointmentStatusChart').getContext('2d');
        const statusCounts = allAppointments.reduce((acc, app) => {
            acc[app.status] = (acc[app.status] || 0) + 1;
            return acc;
        }, {});

        adminAppointmentStatusChartInstance = new Chart(adminAppointmentStatusCtx, {
            type: 'pie',
            data: {
                labels: Object.keys(statusCounts),
                datasets: [{
                    data: Object.values(statusCounts),
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)', // Accepted/Approved
                        'rgba(255, 206, 86, 0.6)', // Pending
                        'rgba(255, 99, 132, 0.6)', // Rejected
                        'rgba(54, 162, 235, 0.6)', // Booked (Approved by patient)
                        'rgba(150, 150, 150, 0.6)', // Cancelled
                        'rgba(100, 100, 100, 0.6)' // Cancelled by Admin
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(150, 150, 150, 1)',
                        'rgba(100, 100, 100, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Overall Appointment Status'
                    }
                }
            }
        });

        // Doctors by Specialization Chart
        const adminDoctorsBySpecializationCtx = document.getElementById('adminDoctorsBySpecializationChart').getContext('2d');
        const specializationCounts = doctors.reduce((acc, doctor) => {
            acc[doctor.specialization] = (acc[doctor.specialization] || 0) + 1;
            return acc;
        }, {});

        adminDoctorsBySpecializationChartInstance = new Chart(adminDoctorsBySpecializationCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(specializationCounts),
                datasets: [{
                    label: 'Number of Doctors',
                    data: Object.values(specializationCounts),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)', // Greenish
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false,
                        text: 'Doctors by Specialization'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    /**
     * Renders the list of all doctors for the admin.
     */
    function renderAdminDoctorsTable() {
        adminDoctorsTableBody.innerHTML = '';
        if (doctors.length === 0) {
            adminDoctorsTableBody.innerHTML = `<tr><td colspan="4" class="py-4 text-center text-gray-500">No doctors registered.</td></tr>`;
            return;
        }

        doctors.forEach(doctor => {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-200 hover:bg-gray-50';
            row.innerHTML = `
                <td class="py-3 px-6 text-left whitespace-nowrap">${doctor.id}</td>
                <td class="py-3 px-6 text-left">${doctor.name}</td>
                <td class="py-3 px-6 text-left">${doctor.specialization}</td>
                <td class="py-3 px-6 text-left">${doctor.availableSlots.join(', ')}</td>
            `;
            adminDoctorsTableBody.appendChild(row);
        });
    }

    /**
     * Admin function to add a new doctor.
     */
    function adminAddDoctor() {
        const name = newDoctorNameInput.value.trim();
        const specialization = newDoctorSpecializationInput.value.trim();

        if (!name || !specialization) {
            showCustomAlert('Error', 'Please enter both doctor name and specialization.');
            return;
        }

        const newDoctorId = 'D' + String(doctors.length + 1).padStart(3, '0');
        const newDoctor = {
            id: newDoctorId,
            name: name,
            specialization: specialization,
            availableSlots: ['09:00', '10:00', '11:00', '13:00', '14:00'] // Default slots
        };
        doctors.push(newDoctor);
        showCustomAlert('Success', `${name} (${specialization}) added as a new doctor with ID ${newDoctorId}.`);
        newDoctorNameInput.value = '';
        newDoctorSpecializationInput.value = '';
        renderAdminDoctorsTable(); // Re-render to update the list
        renderAdminOverview(); // Update stats
        renderAdminCharts(); // Update charts
        renderDoctorsListForPatient(); // Update patient's view of doctors
    }

    /**
     * Admin function to remove a doctor.
     */
    function adminRemoveDoctor() {
        const doctorIdToRemove = removeDoctorIdInput.value.trim().toUpperCase();
        const initialLength = doctors.length;
        doctors = doctors.filter(doc => doc.id !== doctorIdToRemove);

        if (doctors.length < initialLength) {
            showCustomAlert('Success', `Doctor ${doctorIdToRemove} has been removed.`);
            // Also remove associated appointments
            allAppointments = allAppointments.filter(app => app.doctorId !== doctorIdToRemove);

            renderAdminDoctorsTable(); // Re-render to update the list
            renderAdminOverview(); // Update stats
            renderAdminCharts(); // Update charts
            renderDoctorsListForPatient(); // Update patient's view of doctors
            // Re-render doctor dashboards if needed (e.g., if a doctor logs in who was removed)
        } else {
            showCustomAlert('Error', `Doctor with ID ${doctorIdToRemove} not found.`);
        }
        removeDoctorIdInput.value = '';
    }

    /**
     * Admin function to change a doctor's slot time.
     */
    function adminChangeSlotTime() {
        const doctorId = slotDoctorIdInput.value.trim().toUpperCase();
        const newSlot = newSlotTimeInput.value.trim();

        if (!doctorId || !newSlot) {
            showCustomAlert('Error', 'Please enter both Doctor ID and a new slot time.');
            return;
        }

        const doctor = doctors.find(doc => doc.id === doctorId);
        if (doctor) {
            // For simplicity, replacing all slots with the new one.
            doctor.availableSlots = [newSlot];
            showCustomAlert('Success', `Doctor ${doctorId}'s slot time updated to ${newSlot}.`);
            renderAdminDoctorsTable(); // Re-render to update the list
            renderDoctorsListForPatient(); // Update patient's view of doctors
        } else {
            showCustomAlert('Error', `Doctor with ID ${doctorId} not found.`);
        }
        slotDoctorIdInput.value = '';
        newSlotTimeInput.value = '';
    }

    /**
     * Renders the list of all patients for the admin.
     */
    function renderAdminPatientsTable() {
        adminPatientsTableBody.innerHTML = '';
        if (patients.length === 0) {
            adminPatientsTableBody.innerHTML = `<tr><td colspan="4" class="py-4 text-center text-gray-500">No patients registered.</td></tr>`;
            return;
        }

        patients.forEach(patient => {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-200 hover:bg-gray-50';
            row.innerHTML = `
                <td class="py-3 px-6 text-left whitespace-nowrap">${patient.id}</td>
                <td class="py-3 px-6 text-left">${patient.name}</td>
                <td class="py-3 px-6 text-left">${patient.disease}</td>
                <td class="py-3 px-6 text-left">${patient.roomBed}</td>
            `;
            adminPatientsTableBody.appendChild(row);
        });
    }

    /**
     * Renders the list of all appointments for the admin.
     */
    function renderAdminAppointmentsTable() {
        adminAppointmentsTableBody.innerHTML = '';
        if (allAppointments.length === 0) {
            adminAppointmentsTableBody.innerHTML = `<tr><td colspan="8" class="py-4 text-center text-gray-500">No appointments in the system.</td></tr>`;
            return;
        }

        allAppointments.forEach(app => {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-200 hover:bg-gray-50';
            let statusClass = '';
            if (app.status === 'Approved') {
                statusClass = 'bg-green-200 text-green-800';
            } else if (app.status === 'Cancelled') {
                statusClass = 'bg-red-200 text-red-800';
            } else if (app.status === 'Pending') {
                statusClass = 'bg-yellow-200 text-yellow-800';
            } else if (app.status === 'Rejected') {
                statusClass = 'bg-gray-200 text-gray-800';
            } else if (app.status === 'Accepted') {
                statusClass = 'bg-blue-200 text-blue-800';
            } else if (app.status === 'Cancelled by Admin') {
                statusClass = 'bg-gray-300 text-gray-700';
            }

            row.innerHTML = `
                <td class="py-3 px-6 text-left whitespace-nowrap">${app.id}</td>
                <td class="py-3 px-6 text-left">${app.patientName} (ID: ${app.patientId})</td>
                <td class="py-3 px-6 text-left">${app.doctorName} (ID: ${app.doctorId})</td>
                <td class="py-3 px-6 text-left">${app.specialization}</td>
                <td class="py-3 px-6 text-left">${app.disease}</td>
                <td class="py-3 px-6 text-left">${app.date}</td>
                <td class="py-3 px-6 text-left">${app.time}</td>
                <td class="py-3 px-6 text-left">
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                        <span aria-hidden="true" class="absolute inset-0 opacity-50 rounded-full ${statusClass}"></span>
                        <span class="relative">${app.status}</span>
                    </span>
                </td>
            `;
            adminAppointmentsTableBody.appendChild(row);
        });
    }

    /**
     * Admin function to cancel any meeting by appointment ID.
     */
    function adminCancelMeeting() {
        const appIdToCancel = cancelAppointmentIdInput.value.trim();
        const appointment = allAppointments.find(app => app.id === appIdToCancel);

        if (appointment) {
            appointment.status = 'Cancelled by Admin';
            showCustomAlert('Success', `Appointment ${appIdToCancel} has been cancelled by Admin.`);
            renderAdminAppointmentsTable(); // Re-render to update the list
            renderAdminOverview(); // Update stats
            renderAdminCharts(); // Update charts
            renderPatientAppointmentsTable(); // Update patient's view
            renderDoctorAppointments(); // Update doctor's view
        } else {
            showCustomAlert('Error', `Appointment with ID ${appIdToCancel} not found.`);
        }
        cancelAppointmentIdInput.value = '';
    }

    // --- Initialization ---

    // Hide the spinner once the page content is loaded
    window.addEventListener('load', function() {
        const spinnerElement = document.getElementById('spinner');
        if (spinnerElement) {
            // Remove Bootstrap's 'show' class and ensure display is none
            spinnerElement.classList.remove('show');
            spinnerElement.style.display = 'none';
        }
    });

    // Initialize the page with the Doctor panel active and update the login button state
    document.addEventListener('DOMContentLoaded', () => {
        showPanel('doctor'); // Default to doctor panel on load
        updateLoginButton(); // Set initial state of the top button

        // Attach event listeners to login panel selection buttons
        panelButtons.forEach(button => {
            button.addEventListener('click', () => {
                showPanel(button.dataset.panel);
            });
        });
    });
    
</script>

<!-- Main Dashboard Container - This entire block will be displayed after successful login -->
<div id="mainDashboardContainer" class="hidden w-full min-h-screen bg-gray-100 flex flex-col lg:flex-row">
    <!-- Sidebar -->
    <div class="dashboard-sidebar w-full lg:w-64 flex-shrink-0 p-6 shadow-lg">
        <div class="text-2xl font-bold text-white mb-8 text-center lg:text-left">Healthbridge</div>
        <nav class="space-y-2" id="dashboardSidebarNav">
            <!-- Sidebar links will be dynamically generated here by JavaScript based on user role -->
        </nav>
    </div>

    <!-- Content Area -->
    <div class="dashboard-content-area flex-grow p-8 overflow-y-auto">
        <!-- Patient Dashboard Sections -->
        <div id="patientDashboardOverview" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Patient Dashboard Overview</h1>
            <!-- Patient Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="dashboard-card bg-blue-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-blue-700">Booked Appointments</p>
                        <h3 id="patientBookedCount" class="text-4xl font-bold text-blue-900">0</h3>
                    </div>
                    <i class="fas fa-calendar-check text-blue-500 text-5xl"></i>
                </div>
                <div class="dashboard-card bg-red-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-red-700">Cancelled Appointments</p>
                        <h3 id="patientCancelledCount" class="text-4xl font-bold text-red-900">0</h3>
                    </div>
                    <i class="fas fa-calendar-times text-red-500 text-5xl"></i>
                </div>
                <div class="dashboard-card bg-purple-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-purple-700">Total Doctors Available</p>
                        <h3 id="patientTotalDoctorsAvailable" class="text-4xl font-bold text-purple-900">0</h3>
                    </div>
                    <i class="fas fa-user-md text-purple-500 text-5xl"></i>
                </div>
            </div>
            <!-- Patient specific charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">My Appointment Status</h2>
                    <canvas id="patientAppointmentStatusChart"></canvas>
                </div>
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Appointments by Specialization</h2>
                    <canvas id="patientSpecializationChart"></canvas>
                </div>
            </div>
            <!-- Quick Actions -->
            <div class="dashboard-card mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button class="py-3 px-6 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition duration-300 shadow-md" onclick="showDashboardContent('patient', 'bookAppointment')">
                        <i class="fas fa-calendar-plus mr-2"></i>Book New Appointment
                    </button>
                    <button class="py-3 px-6 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition duration-300 shadow-md" onclick="showDashboardContent('patient', 'labResults')">
                        <i class="fas fa-file-medical-alt mr-2"></i>View Lab Results
                    </button>
                    <button class="py-3 px-6 bg-yellow-500 text-white rounded-lg font-semibold hover:bg-yellow-600 transition duration-300 shadow-md" onclick="showDashboardContent('patient', 'messages')">
                        <i class="fas fa-comments mr-2"></i>Send Message
                    </button>
                    <button class="py-3 px-6 bg-purple-500 text-white rounded-lg font-semibold hover:bg-purple-600 transition duration-300 shadow-md" onclick="showDashboardContent('patient', 'profileSettings')">
                        <i class="fas fa-user-cog mr-2"></i>Profile Settings
                    </button>
                </div>
            </div>
        </div>

        <div id="patientDashboardBookAppointment" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Book an Appointment</h1>
            <div class="dashboard-card mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Find a Doctor</h2>
                <input type="text" id="patientDoctorSearch" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search by name or specialization..." onkeyup="filterDoctorsList()">
            </div>
            <div id="doctorsList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Doctor cards will be rendered here by JavaScript -->
            </div>
            <div id="doctorsListPagination" class="flex justify-center mt-6 space-x-2">
                <!-- Pagination buttons will be rendered here -->
            </div>
        </div>

        <div id="patientDashboardMyAppointments" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">My Appointments</h1>
            <div class="dashboard-card">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Appointment ID</th>
                                <th class="py-3 px-6 text-left">Doctor Name</th>
                                <th class="py-3 px-6 text-left">Specialization</th>
                                <th class="py-3 px-6 text-left">Disease</th>
                                <th class="py-3 px-6 text-left">Date</th>
                                <th class="py-3 px-6 text-left">Time</th>
                                <th class="py-3 px-6 text-left">Status</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="patientAppointmentsTable" class="text-gray-700 text-sm font-light">
                            <!-- Appointments will be rendered here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="patientDashboardMedicalRecords" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">My Medical Records</h1>
            <div class="dashboard-card p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Comprehensive Health Overview</h2>
                <div id="patientMedicalRecordsContent" class="space-y-4 text-gray-700">
                    <!-- Medical records content will be dynamically loaded here -->
                </div>
            </div>
        </div>

        <div id="patientDashboardMessages" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Messages</h1>
            <div class="dashboard-card p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Secure Messaging Center</h2>
                <div class="bg-gray-100 p-4 rounded-lg h-64 overflow-y-auto mb-4">
                    <p class="text-gray-600 mb-2"><strong>Dr. Alice Smith:</strong> Your lab results are in. Please schedule a follow-up.</p>
                    <p class="text-blue-700 text-right mb-2"><strong>You:</strong> Ok, thank you Dr. Smith. I will book one soon.</p>
                    <p class="text-gray-600 mb-2"><strong>Support:</strong> Your appointment with Dr. Johnson has been confirmed.</p>
                    <p class="text-gray-600 mb-2">This is a simulated message history. In a real system, you'd see live conversations.</p>
                </div>
                <input type="text" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2" placeholder="Type your message...">
                <button class="py-2 px-4 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition duration-300" onclick="showCustomAlert('Message Sent', 'Your message has been sent (simulated).')">Send Message</button>
            </div>
        </div>

        <div id="patientDashboardBillingPayments" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Billing & Payments</h1>
            <div class="dashboard-card p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Your Financial Overview</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Invoice ID</th>
                                <th class="py-3 px-6 text-left">Date</th>
                                <th class="py-3 px-6 text-left">Service</th>
                                <th class="py-3 px-6 text-left">Amount</th>
                                <th class="py-3 px-6 text-left">Status</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm font-light">
                            <tr>
                                <td class="py-3 px-6">INV001</td>
                                <td class="py-3 px-6">2025-06-15</td>
                                <td class="py-3 px-6">Consultation (Dr. Smith)</td>
                                <td class="py-3 px-6">$150.00</td>
                                <td class="py-3 px-6"><span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">Paid</span></td>
                                <td class="py-3 px-6 text-center"><button class="text-blue-500 hover:underline" onclick="showCustomAlert('View Invoice', 'Viewing invoice INV001 details.')">View</button></td>
                            </tr>
                            <tr>
                                <td class="py-3 px-6">INV002</td>
                                <td class="py-3 px-6">2025-07-01</td>
                                <td class="py-3 px-6">Lab Test (Blood Work)</td>
                                <td class="py-3 px-6">$75.00</td>
                                <td class="py-3 px-6"><span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-xs">Pending</span></td>
                                <td class="py-3 px-6 text-center"><button class="text-blue-500 hover:underline" onclick="showCustomAlert('Pay Now', 'Proceeding to payment for INV002.')">Pay Now</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="patientDashboardProfileSettings" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Profile Settings</h1>
            <div class="dashboard-card p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Manage Your Account</h2>
                <form class="space-y-4">
                    <div>
                        <label for="patientNameSetting" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="patientNameSetting" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="Rohan Kapri">
                    </div>
                    <div>
                        <label for="patientEmailSetting" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" id="patientEmailSetting" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="rohan.kapri@example.com">
                    </div>
                    <div>
                        <label for="patientPhoneSetting" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" id="patientPhoneSetting" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="+91-9876543210">
                    </div>
                    <button type="button" class="py-2 px-4 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition duration-300" onclick="showCustomAlert('Profile Updated', 'Your profile settings have been updated (simulated).')">Save Changes</button>
                    <button type="button" class="ml-4 py-2 px-4 bg-gray-300 text-gray-800 rounded-lg font-semibold hover:bg-gray-400 transition duration-300" onclick="showCustomAlert('Password Reset', 'Password reset initiated. Check your email for instructions (simulated).')">Change Password</button>
                </form>
            </div>
        </div>


        <!-- Doctor Dashboard Sections -->
        <div id="doctorDashboardOverview" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Doctor Dashboard Overview</h1>
            <!-- Doctor Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="dashboard-card bg-purple-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-purple-700">Total Patients</p>
                        <h3 id="doctorTotalPatients" class="text-4xl font-bold text-purple-900">0</h3>
                    </div>
                    <i class="fas fa-users text-purple-500 text-5xl"></i>
                </div>
                <div class="dashboard-card bg-green-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-green-700">Accepted Appointments</p>
                        <h3 id="doctorAcceptedAppointments" class="text-4xl font-bold text-green-900">0</h3>
                    </div>
                    <i class="fas fa-check-circle text-green-500 text-5xl"></i>
                </div>
                <div class="dashboard-card bg-yellow-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-yellow-700">Pending Appointments</p>
                        <h3 id="doctorPendingAppointments" class="text-4xl font-bold text-yellow-900">0</h3>
                    </div>
                    <i class="fas fa-clock text-yellow-500 text-5xl"></i>
                </div>
                <div class="dashboard-card bg-red-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-red-700">Rejected Appointments</p>
                        <h3 id="doctorRejectedAppointments" class="text-4xl font-bold text-red-900">0</h3>
                    </div>
                    <i class="fas fa-times-circle text-red-500 text-5xl"></i>
                </div>
            </div>
            <!-- Doctor Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">My Appointment Status Overview</h2>
                    <canvas id="doctorAppointmentStatusChart"></canvas>
                </div>
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Patients by Disease (My Patients)</h2>
                    <canvas id="doctorPatientsByDiseaseChart"></canvas>
                </div>
            </div>
            <!-- Doctor Quick Actions -->
            <div class="dashboard-card mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Doctor Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button class="py-3 px-6 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition duration-300 shadow-md" onclick="showDashboardContent('doctor', 'virtualConsultations')">
                        <i class="fas fa-video mr-2"></i>Virtual Consultations
                    </button>
                    <button class="py-3 px-6 bg-purple-500 text-white rounded-lg font-semibold hover:bg-purple-600 transition duration-300 shadow-md" onclick="showDashboardContent('doctor', 'prescriptions')">
                        <i class="fas fa-prescription-bottle-alt mr-2"></i>Prescription Management
                    </button>
                    <button class="py-3 px-6 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition duration-300 shadow-md" onclick="showDashboardContent('doctor', 'patientProfiles')">
                        <i class="fas fa-user-circle mr-2"></i>View Patient Profiles
                    </button>
                    <button class="py-3 px-6 bg-yellow-500 text-white rounded-lg font-semibold hover:bg-yellow-600 transition duration-300 shadow-md" onclick="showDashboardContent('doctor', 'referrals')">
                        <i class="fas fa-share-square mr-2"></i>Manage Referrals
                    </button>
                </div>
            </div>
        </div>

        <div id="doctorDashboardAppointments" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">My Appointments</h1>
            <div class="dashboard-card">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Planned Consultations</h2>
                <div id="doctorAppointmentsList" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Doctor's appointments will be rendered here by JavaScript -->
                </div>
            </div>
            <div id="doctorAppointmentsPagination" class="flex justify-center mt-6 space-x-2">
                <!-- Pagination buttons will be rendered here -->
            </div>
        </div>

        <div id="doctorDashboardMyPatients" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">My Patients</h1>
            <div class="dashboard-card mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Search Patients</h2>
                <input type="text" id="doctorPatientSearch" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search by patient name or ID..." onkeyup="filterDoctorPatientList()">
            </div>
            <div class="dashboard-card">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Patient ID</th>
                                <th class="py-3 px-6 text-left">Patient Name</th>
                                <th class="py-3 px-6 text-left">Date Check In</th>
                                <th class="py-3 px-6 text-left">Disease</th>
                                <th class="py-3 px-6 text-left">Room/Bed</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="doctorPatientListTable" class="text-gray-700 text-sm font-light">
                            <!-- Patient list will be rendered here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="doctorPatientListPagination" class="flex justify-center mt-6 space-x-2">
                <!-- Pagination buttons will be rendered here -->
            </div>
        </div>

        <div id="doctorDashboardSchedule" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">My Schedule</h1>
            <div class="dashboard-card">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Daily Slots</h2>
                <div id="doctorScheduleSlots" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- Doctor's schedule slots will be rendered here -->
                </div>
            </div>
        </div>

        <div id="doctorDashboardPatientProfiles" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Patient Profiles</h1>
            <div class="dashboard-card mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">View Patient Details</h2>
                <input type="text" id="doctorPatientProfileSearch" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search by patient name or ID..." onkeyup="filterDoctorPatientProfiles()">
            </div>
            <div id="doctorPatientProfilesList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Patient profiles will be rendered here -->
            </div>
            <div id="doctorPatientProfilesPagination" class="flex justify-center mt-6 space-x-2">
                <!-- Pagination buttons will be rendered here -->
            </div>
        </div>

        <div id="doctorDashboardVirtualConsultations" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Virtual Consultations</h1>
            <div class="dashboard-card p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Upcoming Video Calls</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg shadow-sm">
                        <div>
                            <p class="font-semibold text-lg text-blue-800">Consultation with Rohan Kapri</p>
                            <p class="text-sm text-gray-600">Today, 10:30 AM (APP001)</p>
                        </div>
                        <button class="py-2 px-4 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition duration-300" onclick="showCustomAlert('Starting Call', 'Initiating video call with Rohan Kapri...')">
                            <i class="fas fa-video mr-2"></i>Start Call
                        </button>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg shadow-sm">
                        <div>
                            <p class="font-semibold text-lg text-blue-800">Consultation with Jane Doe</p>
                            <p class="text-sm text-gray-600">Tomorrow, 09:00 AM (APP005)</p>
                        </div>
                        <button class="py-2 px-4 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition duration-300" onclick="showCustomAlert('Starting Call', 'Initiating video call with Jane Doe...')">
                            <i class="fas fa-video mr-2"></i>Start Call
                        </button>
                    </div>
                    <p class="text-gray-500 text-center">More upcoming consultations would be listed here.</p>
                </div>
            </div>
        </div>

        <div id="doctorDashboardReferrals" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Manage Referrals</h1>
            <div class="dashboard-card p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Patient Referrals</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Referral ID</th>
                                <th class="py-3 px-6 text-left">Patient Name</th>
                                <th class="py-3 px-6 text-left">Referred To/From</th>
                                <th class="py-3 px-6 text-left">Reason</th>
                                <th class="py-3 px-6 text-left">Status</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm font-light">
                            <tr>
                                <td class="py-3 px-6">REF001</td>
                                <td class="py-3 px-6">John Smith</td>
                                <td class="py-3 px-6">Dr. Emily Brown (Orthopedics)</td>
                                <td class="py-3 px-6">Knee Pain Evaluation</td>
                                <td class="py-3 px-6"><span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-xs">Pending</span></td>
                                <td class="py-3 px-6 text-center"><button class="text-blue-500 hover:underline" onclick="showCustomAlert('Referral Details', 'Viewing details for REF001.')">View</button></td>
                            </tr>
                            <tr>
                                <td class="py-3 px-6">REF002</td>
                                <td class="py-3 px-6">Laura Kim</td>
                                <td class="py-3 px-6">Dr. Carol White (Dermatology)</td>
                                <td class="py-3 px-6">Skin Rash Consultation</td>
                                <td class="py-3 px-6"><span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">Completed</span></td>
                                <td class="py-3 px-6 text-center"><button class="text-blue-500 hover:underline" onclick="showCustomAlert('Referral Details', 'Viewing details for REF002.')">View</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button class="mt-6 py-2 px-4 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition duration-300" onclick="showCustomAlert('New Referral', 'Opening form to create a new referral (simulated).')">
                    <i class="fas fa-plus-circle mr-2"></i>Create New Referral
                </button>
            </div>
        </div>

        <div id="doctorDashboardPrescriptions" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Prescription Management</h1>
            <div class="dashboard-card p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Issue & Manage Prescriptions</h2>
                <div class="space-y-4">
                    <div>
                        <label for="prescriptionPatientId" class="block text-sm font-medium text-gray-700">Patient ID</label>
                        <input type="text" id="prescriptionPatientId" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., P001">
                    </div>
                    <div>
                        <label for="prescriptionMedication" class="block text-sm font-medium text-gray-700">Medication</label>
                        <input type="text" id="prescriptionMedication" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., Amoxicillin 500mg">
                    </div>
                    <div>
                        <label for="prescriptionDosage" class="block text-sm font-medium text-gray-700">Dosage & Instructions</label>
                        <textarea id="prescriptionDosage" rows="3" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., Take 1 tablet every 8 hours for 7 days."></textarea>
                    </div>
                    <button class="py-2 px-4 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition duration-300" onclick="showCustomAlert('Prescription Issued', 'Prescription issued for patient (simulated).')">
                        <i class="fas fa-file-prescription mr-2"></i>Issue Prescription
                    </button>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mt-8 mb-4">Recent Prescriptions</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Rx ID</th>
                                <th class="py-3 px-6 text-left">Patient</th>
                                <th class="py-3 px-6 text-left">Medication</th>
                                <th class="py-3 px-6 text-left">Date Issued</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm font-light">
                            <tr>
                                <td class="py-3 px-6">RX001</td>
                                <td class="py-3 px-6">Rohan Kapri</td>
                                <td class="py-3 px-6">Paracetamol 500mg</td>
                                <td class="py-3 px-6">2025-07-01</td>
                                <td class="py-3 px-6 text-center"><button class="text-blue-500 hover:underline" onclick="showCustomAlert('Prescription Details', 'Viewing details for RX001.')">View</button></td>
                            </tr>
                            <tr>
                                <td class="py-3 px-6">RX002</td>
                                <td class="py-3 px-6">John Smith</td>
                                <td class="py-3 px-6">Ibuprofen 400mg</td>
                                <td class="py-3 px-6">2025-06-28</td>
                                <td class="py-3 px-6 text-center"><button class="text-blue-500 hover:underline" onclick="showCustomAlert('Prescription Details', 'Viewing details for RX002.')">View</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="doctorDashboardPracticeAnalytics" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Practice Analytics</h1>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Monthly Patient Visits</h2>
                    <canvas id="doctorMonthlyVisitsChart"></canvas>
                </div>
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Top 5 Diagnoses</h2>
                    <canvas id="doctorTopDiagnosesChart"></canvas>
                </div>
            </div>
            <div class="dashboard-card p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Performance Metrics</h2>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li>Average Appointment Duration: 15 minutes</li>
                    <li>Patient Satisfaction Score: 4.7/5</li>
                    <li>Referral Rate: 10%</li>
                    <li>No-Show Rate: 5%</li>
                </ul>
            </div>
        </div>

        <!-- Admin Dashboard Sections -->
        <div id="adminDashboardOverview" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Admin Dashboard Overview</h1>
            <!-- Admin Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="dashboard-card bg-blue-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-blue-700">Total Doctors</p>
                        <h3 id="adminTotalDoctors" class="text-4xl font-bold text-blue-900">0</h3>
                    </div>
                    <i class="fas fa-user-md text-blue-500 text-5xl"></i>
                </div>
                <div class="dashboard-card bg-purple-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-purple-700">Total Patients</p>
                        <h3 id="adminTotalPatients" class="text-4xl font-bold text-purple-900">0</h3>
                    </div>
                    <i class="fas fa-user-injured text-purple-500 text-5xl"></i>
                </div>
                <div class="dashboard-card bg-green-50 p-6 rounded-xl shadow-md flex items-center justify-between">
                    <div>
                        <p class="text-lg text-green-700">Total Appointments</p>
                        <h3 id="adminTotalAppointments" class="text-4xl font-bold text-green-900">0</h3>
                    </div>
                    <i class="fas fa-calendar-alt text-green-500 text-5xl"></i>
                </div>
            </div>
            <!-- Admin Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Overall Appointment Status</h2>
                    <canvas id="adminAppointmentStatusChart"></canvas>
                </div>
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Doctors by Specialization</h2>
                    <canvas id="adminDoctorsBySpecializationChart"></canvas>
                </div>
            </div>
            <!-- Admin Quick Actions -->
            <div class="dashboard-card mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Admin Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button class="py-3 px-6 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition duration-300 shadow-md" onclick="showDashboardContent('admin', 'manageDoctors')">
                        <i class="fas fa-user-plus mr-2"></i>Add/Remove Doctors
                    </button>
                    <button class="py-3 px-6 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition duration-300 shadow-md" onclick="showDashboardContent('admin', 'manageAppointments')">
                        <i class="fas fa-calendar-times mr-2"></i>Cancel Appointments
                    </button>
                    <button class="py-3 px-6 bg-yellow-500 text-white rounded-lg font-semibold hover:bg-yellow-600 transition duration-300 shadow-md" onclick="showCustomAlert('Feature', 'Exporting data to CSV...')">
                        <i class="fas fa-file-csv mr-2"></i>Export Data
                    </button>
                    <button class="py-3 px-6 bg-gray-500 text-white rounded-lg font-semibold hover:bg-gray-600 transition duration-300 shadow-md" onclick="showDashboardContent('admin', 'userManagement')">
                        <i class="fas fa-users-cog mr-2"></i>Manage Users
                    </button>
                </div>
            </div>
        </div>

        <div id="adminDashboardManageDoctors" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Manage Doctors</h1>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Add Doctor -->
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Doctor</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="newDoctorName" class="block text-sm font-medium text-gray-700">Doctor Name</label>
                            <input type="text" id="newDoctorName" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., Dr. Alice Smith">
                        </div>
                        <div>
                            <label for="newDoctorSpecialization" class="block text-sm font-medium text-gray-700">Specialization</label>
                            <input type="text" id="newDoctorSpecialization" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., Cardiology">
                        </div>
                        <button class="submit-button w-full py-2 px-4 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition duration-300" onclick="adminAddDoctor()">Add Doctor</button>
                    </div>
                </div>

                <!-- Remove Doctor -->
                <div class="dashboard-card">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Remove Doctor</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="removeDoctorId" class="block text-sm font-medium text-gray-700">Doctor ID (e.g., D001)</label>
                            <input type="text" id="removeDoctorId" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Doctor ID">
                        </div>
                        <button class="submit-button w-full py-2 px-4 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition duration-300" onclick="adminRemoveDoctor()">Remove Doctor</button>
                    </div>
                </div>

                <!-- Change Slot Time -->
                <div class="dashboard-card col-span-full">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Change Doctor Slot Time</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="slotDoctorId" class="block text-sm font-medium text-gray-700">Doctor ID</label>
                            <input type="text" id="slotDoctorId" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Doctor ID">
                        </div>
                        <div>
                            <label for="newSlotTime" class="block text-sm font-medium text-gray-700">New Slot Time (HH:MM)</label>
                            <input type="time" id="newSlotTime" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button class="submit-button w-full py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition duration-300" onclick="adminChangeSlotTime()">Update Slot</button>
                    </div>
                </div>
            </div>
            <div class="dashboard-card">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Doctors List</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Doctor ID</th>
                                <th class="py-3 px-6 text-left">Name</th>
                                <th class="py-3 px-6 text-left">Specialization</th>
                                <th class="py-3 px-6 text-left">Available Slots</th>
                            </tr>
                        </thead>
                        <tbody id="adminDoctorsTable" class="text-gray-700 text-sm font-light">
                            <!-- Doctors will be rendered here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="adminDashboardManagePatients" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Manage Patients</h1>
            <div class="dashboard-card mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Search Patients</h2>
                <input type="text" id="adminPatientSearch" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search by patient name or ID..." onkeyup="filterAdminPatientList()">
            </div>
            <div class="dashboard-card">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Patients List</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Patient ID</th>
                                <th class="py-3 px-6 text-left">Name</th>
                                <th class="py-3 px-6 text-left">Disease</th>
                                <th class="py-3 px-6 text-left">Room/Bed</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="adminPatientsTable" class="text-gray-700 text-sm font-light">
                            <!-- Patients will be rendered here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="adminPatientListPagination" class="flex justify-center mt-6 space-x-2">
                <!-- Pagination buttons will be rendered here -->
            </div>
        </div>

        <div id="adminDashboardManageAppointments" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Manage Appointments</h1>
            <div class="dashboard-card mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Cancel Any Appointment</h2>
                <div class="space-y-4">
                    <div>
                        <label for="cancelAppointmentId" class="block text-sm font-medium text-gray-700">Appointment ID</label>
                        <input type="text" id="cancelAppointmentId" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Appointment ID">
                    </div>
                    <button class="submit-button w-full py-2 px-4 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition duration-300" onclick="adminCancelMeeting()">Cancel Meeting</button>
                </div>
            </div>
            <div class="dashboard-card mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Search Appointments</h2>
                <input type="text" id="adminAppointmentSearch" class="form-input w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search by ID, patient, or doctor name..." onkeyup="filterAdminAppointmentList()">
            </div>
            <div class="dashboard-card">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">All Appointments List</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Appointment ID</th>
                                <th class="py-3 px-6 text-left">Patient Name</th>
                                <th class="py-3 px-6 text-left">Doctor Name</th>
                                <th class="py-3 px-6 text-left">Specialization</th>
                                <th class="py-3 px-6 text-left">Disease</th>
                                <th class="py-3 px-6 text-left">Date</th>
                                <th class="py-3 px-6 text-left">Time</th>
                                <th class="py-3 px-6 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody id="adminAppointmentsTable" class="text-gray-700 text-sm font-light">
                            <!-- All appointments will be rendered here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="adminAppointmentsPagination" class="flex justify-center mt-6 space-x-2">
                <!-- Pagination buttons will be rendered here -->
            </div>
        </div>

        <div id="adminDashboardSystemLogs" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">System Logs (Admin Only)</h1>
            <div class="dashboard-card p-6">
                <p class="text-gray-700 mb-4">This section would display system activity, errors, and audit trails. For this demo, it's a static placeholder.</p>
                <div class="bg-gray-50 p-4 rounded-md h-96 overflow-y-auto font-mono text-sm text-gray-800">
                    <p>[2025-07-09 11:00:00] Admin 'admin' logged in successfully.</p>
                    <p>[2025-07-09 10:59:30] Patient 'patient' booked appointment APP0016 with Dr. Alice Smith.</p>
                    <p>[2025-07-09 10:58:15] Doctor 'doctor' accepted appointment APP0001.</p>
                    <p>[2025-07-09 10:57:00] Admin 'admin' added new doctor 'Dr. New Doctor'.</p>
                    <p>[2025-07-09 10:56:45] User 'guest' attempted login (failed: invalid credentials).</p>
                    <p>[2025-07-09 10:55:00] System startup: Initializing mock data.</p>
                    <p>[2025-07-09 10:54:30] Database connection established (simulated).</p>
                    <p>[2025-07-09 10:53:00] Application server started.</p>
                    <p>[2025-07-09 10:52:00] Healthcheck passed.</p>
                    <p>[2025-07-09 10:51:00] Cache cleared.</p>
                    <p>[2025-07-09 10:50:00] Scheduled task 'daily_backup' completed.</p>
                    <p>[2025-07-09 10:49:00] API endpoint '/api/appointments' accessed by 'patient'.</p>
                    <p>[2025-07-09 10:48:00] Data integrity check initiated.</p>
                    <p>[2025-07-09 10:47:00] User 'patient' viewed doctor list.</p>
                    <p>[2025-07-09 10:46:00] Notification sent: 'New appointment booked'.</p>
                    <p>[2025-07-09 10:45:00] Admin 'admin' updated Dr. Bob Johnson's slot time.</p>
                    <p>[2025-07-09 10:44:00] User 'doctor' logged out.</p>
                    <p>[2025-07-09 10:43:00] Patient 'patient' cancelled appointment APP0005.</p>
                    <p>[2025-07-09 10:42:00] System performance metrics collected.</p>
                    <p>[2025-07-09 10:41:00] Admin 'admin' removed Dr. Carol White.</p>
                    <p>[2025-07-09 10:40:00] User 'admin' accessed 'Manage Doctors' section.</p>
                    <p>[2025-07-09 10:39:00] Data synchronization complete.</p>
                    <p>[2025-07-09 10:38:00] External API call: 'SMS service' status OK.</p>
                    <p>[2025-07-09 10:37:00] User 'doctor' viewed 'My Patients' list.</p>
                    <p>[2025-07-09 10:36:00] New patient 'New Patient' registered.</p>
                    <p>[2025-07-09 10:35:00] Security audit initiated.</p>
                    <p>[2025-07-09 10:34:00] User 'patient' viewed 'My Appointments' list.</p>
                    <p>[2025-07-09 10:33:00] Resource utilization: CPU 30%, Memory 60%.</p>
                    <p>[2025-07-09 10:32:00] Backup process started.</p>
                </div>
            </div>
        </div>

        <div id="adminDashboardUserManagement" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">User Management</h1>
            <div class="dashboard-card p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Manage System Users</h2>
                <p class="text-gray-700 mb-4">This section provides tools for managing all user accounts (doctors, patients, admins). Features would include:</p>
                <ul class="list-disc list-inside text-gray-600 space-y-2">
                    <li>Add/Edit/Remove User Accounts</li>
                    <li>Assign/Change User Roles (Admin, Doctor, Patient)</li>
                    <li>Reset User Passwords</li>
                    <li>View User Activity Logs</li>
                    <li>Suspend/Activate User Accounts</li>
                </ul>
                <button class="mt-6 py-2 px-4 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition duration-300" onclick="showCustomAlert('User Management', 'User management features are under active development.')">
                    <i class="fas fa-users-cog mr-2"></i>Access User Controls
                </button>
            </div>
        </div>

        <div id="adminDashboardSettings" class="dashboard-panel" style="display: none;">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Admin Settings</h1>
            <div class="dashboard-card p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">System Configuration</h2>
                <p class="text-gray-700 mb-4">This section allows administrators to configure various system-wide settings. Features would include:</p>
                <ul class="list-disc list-inside text-gray-600 space-y-2">
                    <li>Manage System Parameters (e.g., appointment slot duration, notification preferences)</li>
                    <li>Configure Integrations (e.g., payment gateways, external lab services)</li>
                    <li>Backup and Restore Database (simulated)</li>
                    <li>Manage User Permissions and Access Control Lists</li>
                    <li>System Health Monitoring Setup</li>
                </ul>
                <button class="mt-6 py-2 px-4 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition duration-300" onclick="showCustomAlert('System Settings', 'System settings configuration is under development.')">
                    <i class="fas fa-cog mr-2"></i>Configure System
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for the Comprehensive Dashboard Functionality -->
<script>
    // --- Mock Data (for demonstration purposes, will reset on page refresh) ---
    // This data is initialized here and will be used throughout the dashboard.
    // In a real application, this data would be fetched from a backend database.

    // Array of mock doctor objects
    let doctors = [
        { id: 'D001', name: 'Dr. Alice Smith', specialization: 'Cardiology', availableSlots: ['09:00', '10:00', '11:00', '14:00', '15:00'], rating: 4.8, experience: 12, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR1' },
        { id: 'D002', name: 'Dr. Bob Johnson', specialization: 'Pediatrics', availableSlots: ['09:30', '10:30', '11:30', '13:30', '14:30'], rating: 4.5, experience: 8, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR2' },
        { id: 'D003', name: 'Dr. Carol White', specialization: 'Dermatology', availableSlots: ['08:00', '09:00', '10:00', '16:00', '17:00'], rating: 4.9, experience: 15, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR3' },
        { id: 'D004', name: 'Dr. David Green', specialization: 'Neurology', availableSlots: ['10:00', '11:00', '12:00', '14:00', '15:00'], rating: 4.7, experience: 10, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR4' },
        { id: 'D005', name: 'Dr. Emily Brown', specialization: 'Orthopedics', availableSlots: ['08:30', '09:30', '10:30', '13:00', '14:00'], rating: 4.6, experience: 7, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR5' },
        { id: 'D006', name: 'Dr. Frank Black', specialization: 'Ophthalmology', availableSlots: ['11:00', '12:00', '13:00', '15:00', '16:00'], rating: 4.4, experience: 9, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR6' },
        { id: 'D007', name: 'Dr. Grace Lee', specialization: 'Gastroenterology', availableSlots: ['09:00', '10:00', '11:00', '14:00', '15:00'], rating: 4.8, experience: 11, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR7' },
        { id: 'D008', name: 'Dr. Henry King', specialization: 'Urology', availableSlots: ['08:00', '09:00', '10:00', '16:00', '17:00'], rating: 4.5, experience: 6, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR8' },
        { id: 'D009', name: 'Dr. Ivy Chen', specialization: 'Endocrinology', availableSlots: ['13:00', '14:00', '15:00', '16:00', '17:00'], rating: 4.7, experience: 13, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR9' },
        { id: 'D010', name: 'Dr. Jack Wilson', specialization: 'Pulmonology', availableSlots: ['09:00', '10:00', '11:00', '13:00', '14:00'], rating: 4.6, experience: 8, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR10' },
        { id: 'D011', name: 'Dr. Karen Davis', specialization: 'Oncology', availableSlots: ['10:00', '11:00', '12:00', '15:00', '16:00'], rating: 4.9, experience: 18, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR11' },
        { id: 'D012', name: 'Dr. Liam Miller', specialization: 'Nephrology', availableSlots: ['08:30', '09:30', '10:30', '14:30', '15:30'], rating: 4.5, experience: 7, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR12' },
        { id: 'D013', name: 'Dr. Mia Garcia', specialization: 'Rheumatology', availableSlots: ['11:00', '12:00', '13:00', '16:00', '17:00'], rating: 4.7, experience: 9, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR13' },
        { id: 'D014', name: 'Dr. Noah Rodriguez', specialization: 'Infectious Disease', availableSlots: ['09:00', '10:00', '11:00', '13:00', '14:00'], rating: 4.6, experience: 10, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR14' },
        { id: 'D015', name: 'Dr. Olivia Martinez', specialization: 'Psychiatry', availableSlots: ['13:00', '14:00', '15:00', '16:00', '17:00'], rating: 4.8, experience: 14, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR15' },
        { id: 'D016', name: 'Dr. Peter Hernandez', specialization: 'Allergy & Immunology', availableSlots: ['08:00', '09:00', '10:00', '11:00', '12:00'], rating: 4.5, experience: 6, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR16' },
        { id: 'D017', name: 'Dr. Quinn Lopez', specialization: 'Sports Medicine', availableSlots: ['10:00', '11:00', '12:00', '14:00', '15:00'], rating: 4.7, experience: 8, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR17' },
        { id: 'D018', name: 'Dr. Rachel Perez', specialization: 'Geriatrics', availableSlots: ['09:30', '10:30', '11:30', '13:30', '14:30'], rating: 4.6, experience: 16, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR18' },
        { id: 'D019', name: 'Dr. Sam Gonzalez', specialization: 'Pain Management', availableSlots: ['08:00', '09:00', '10:00', '15:00', '16:00'], rating: 4.4, experience: 7, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR19' },
        { id: 'D020', name: 'Dr. Tina Scott', specialization: 'Sleep Medicine', availableSlots: ['11:00', '12:00', '13:00', '14:00', '15:00'], rating: 4.7, experience: 10, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR20' },
        { id: 'D021', name: 'Dr. Victor Adams', specialization: 'Emergency Medicine', availableSlots: ['07:00', '08:00', '09:00', '10:00', '11:00'], rating: 4.5, experience: 5, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR21' },
        { id: 'D022', name: 'Dr. Wendy Baker', specialization: 'Plastic Surgery', availableSlots: ['10:00', '11:00', '12:00', '13:00', '14:00'], rating: 4.8, experience: 12, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR22' },
        { id: 'D023', name: 'Dr. Xavier Hall', specialization: 'Vascular Surgery', availableSlots: ['13:00', '14:00', '15:00', '16:00', '17:00'], rating: 4.6, experience: 9, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR23' },
        { id: 'D024', name: 'Dr. Yolanda Young', specialization: 'Oncological Surgery', availableSlots: ['08:00', '09:00', '10:00', '11:00', '12:00'], rating: 4.9, experience: 17, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR24' },
        { id: 'D025', name: 'Dr. Zoe Wright', specialization: 'Cardiac Surgery', availableSlots: ['11:00', '12:00', '13:00', '14:00', '15:00'], rating: 4.7, experience: 11, imageUrl: 'https://placehold.co/100x100/e0f2fe/3b82f6?text=DR25' }
    ];

    // Array of mock patient objects
    let patients = [
        { id: 'P001', name: 'Rohan Kapri', disease: 'Common Cold', roomBed: 'A-101', medicalHistory: ['Flu (2023)', 'Allergy (Dust)'], contact: 'rohan.kapri@example.com', phone: '+91-9876543210' },
        { id: 'P002', name: 'Jane Doe', disease: 'Flu', roomBed: 'A-102', medicalHistory: ['Asthma (Childhood)'], contact: 'jane.doe@example.com', phone: '+1-555-123-4567' },
        { id: 'P003', name: 'John Smith', disease: 'Migraine', roomBed: 'B-201', medicalHistory: [], contact: 'john.smith@example.com', phone: '+1-555-234-5678' },
        { id: 'P004', name: 'Emily White', disease: 'Asthma', roomBed: 'B-202', medicalHistory: ['Seasonal Allergies'], contact: 'emily.white@example.com', phone: '+1-555-345-6789' },
        { id: 'P005', name: 'Michael Brown', disease: 'Diabetes', roomBed: 'C-301', medicalHistory: ['Hypertension (2020)'], contact: 'michael.brown@example.com', phone: '+1-555-456-7890' },
        { id: 'P006', name: 'Sarah Green', disease: 'Hypertension', roomBed: 'C-302', medicalHistory: [], contact: 'sarah.green@example.com', phone: '+1-555-567-8901' },
        { id: 'P007', name: 'Chris Evans', disease: 'Arthritis', roomBed: 'D-401', medicalHistory: ['Knee Surgery (2021)'], contact: 'chris.evans@example.com', phone: '+1-555-678-9012' },
        { id: 'P008', name: 'Jessica Alba', disease: 'Allergy', roomBed: 'D-402', medicalHistory: [], contact: 'jessica.alba@example.com', phone: '+1-555-789-0123' },
        { id: 'P009', name: 'David Lee', disease: 'Back Pain', roomBed: 'E-501', medicalHistory: ['Herniated Disc (2022)'], contact: 'david.lee@example.com', phone: '+1-555-890-1234' },
        { id: 'P010', name: 'Laura Kim', disease: 'Dermatitis', roomBed: 'E-502', medicalHistory: [], contact: 'laura.kim@example.com', phone: '+1-555-901-2345' },
        { id: 'P011', name: 'Daniel Clark', disease: 'Anxiety', roomBed: 'F-601', medicalHistory: [], contact: 'daniel.clark@example.com', phone: '+1-555-012-3456' },
        { id: 'P012', name: 'Sophia Lewis', disease: 'Gastroenteritis', roomBed: 'F-602', medicalHistory: [], contact: 'sophia.lewis@example.com', phone: '+1-555-112-2334' },
        { id: 'P013', name: 'Matthew Hall', disease: 'Bronchitis', roomBed: 'G-701', medicalHistory: ['Frequent Colds'], contact: 'matthew.hall@example.com', phone: '+1-555-223-3445' },
        { id: 'P014', name: 'Olivia Young', disease: 'Sinusitis', roomBed: 'G-702', medicalHistory: [], contact: 'olivia.young@example.com', phone: '+1-555-334-4556' },
        { id: 'P015', name: 'James King', disease: 'Insomnia', roomBed: 'H-801', medicalHistory: [], contact: 'james.king@example.com', phone: '+1-555-445-5667' },
        { id: 'P016', name: 'Ava Wright', disease: 'Thyroid Disorder', roomBed: 'I-901', medicalHistory: [], contact: 'ava.wright@example.com', phone: '+1-555-556-6778' },
        { id: 'P017', name: 'William Turner', disease: 'Kidney Stones', roomBed: 'I-902', medicalHistory: [], contact: 'william.turner@example.com', phone: '+1-555-667-7889' },
        { id: 'P018', name: 'Charlotte Hill', disease: 'Pneumonia', roomBed: 'J-1001', medicalHistory: ['Past Respiratory Infection'], contact: 'charlotte.hill@example.com', phone: '+1-555-778-8990' },
        { id: 'P019', name: 'Benjamin Scott', disease: 'Depression', roomBed: 'J-1002', medicalHistory: [], contact: 'benjamin.scott@example.com', phone: '+1-555-889-9001' },
        { id: 'P020', name: 'Amelia Adams', disease: 'High Cholesterol', roomBed: 'K-1101', medicalHistory: ['Family History of Heart Disease'], contact: 'amelia.adams@example.com', phone: '+1-555-990-0112' },
    ];

    // Counter for generating unique appointment IDs
    let appointmentCounter = 1;

    // Array to store all appointments in the system
    let allAppointments = [];

    // Pagination settings
    const itemsPerPage = 10; // Number of items per page for tables/lists

    /**
     * Generates a unique appointment ID.
     * @returns {string} A unique appointment ID.
     */
    function generateAppointmentId() {
        return `APP${String(appointmentCounter++).padStart(4, '0')}`;
    }

    /**
     * Generates a random future date within the next 30 days.
     * @returns {string} Date in YYYY-MM-DD format.
     */
    function getRandomFutureDate() {
        const today = new Date();
        const futureDate = new Date(today);
        futureDate.setDate(today.getDate() + Math.floor(Math.random() * 30) + 1); // 1 to 30 days in future
        return futureDate.toISOString().slice(0, 10);
    }

    /**
     * Picks a random time slot from a doctor's available slots.
     * @param {Array<string>} slots - Array of available time slots.
     * @returns {string} A random time slot.
     */
    function getRandomSlot(slots) {
        if (!slots || slots.length === 0) return 'N/A';
        return slots[Math.floor(Math.random() * slots.length)];
    }

    /**
     * Seeds initial mock appointments for a more populated dashboard.
     * These appointments are distributed among doctors and patients.
     */
    function seedInitialAppointments() {
        const mockDiseases = ['Fever', 'Headache', 'Dizziness', 'Cough', 'Rash', 'Stomach Ache', 'Fatigue', 'Sore Throat', 'Hypertension', 'Diabetes', 'Asthma', 'Migraine', 'Arthritis', 'Allergy'];
        const statuses = ['Pending', 'Accepted', 'Rejected', 'Approved', 'Cancelled'];

        for (let i = 0; i < 25; i++) { // Create 25 initial appointments
            const randomPatient = patients[Math.floor(Math.random() * patients.length)];
            const randomDoctor = doctors[Math.floor(Math.random() * doctors.length)];
            const randomDisease = mockDiseases[Math.floor(Math.random() * mockDiseases.length)];
            const randomStatus = statuses[Math.floor(Math.random() * statuses.length)];
            const randomDate = getRandomFutureDate();
            const randomTime = getRandomSlot(randomDoctor.availableSlots);

            allAppointments.push({
                id: generateAppointmentId(),
                patientId: randomPatient.id,
                patientName: randomPatient.name,
                doctorId: randomDoctor.id,
                doctorName: randomDoctor.name,
                specialization: randomDoctor.specialization,
                disease: randomDisease,
                date: randomDate,
                time: randomTime,
                status: randomStatus
            });
        }
    }

    // Call to seed initial appointments when the script loads
    seedInitialAppointments();

    // --- DOM Elements (Dashboard Specific) ---
    const mainDashboardContainer = document.getElementById('mainDashboardContainer');
    const dashboardSidebarNav = document.getElementById('dashboardSidebarNav');

    // Patient Dashboard Elements
    const patientDashboardOverview = document.getElementById('patientDashboardOverview');
    const patientDashboardBookAppointment = document.getElementById('patientDashboardBookAppointment');
    const patientDashboardMyAppointments = document.getElementById('patientDashboardMyAppointments');
    const patientDashboardMedicalRecords = document.getElementById('patientDashboardMedicalRecords');
    const patientDashboardMessages = document.getElementById('patientDashboardMessages');
    const patientDashboardBillingPayments = document.getElementById('patientDashboardBillingPayments');
    const patientDashboardProfileSettings = document.getElementById('patientDashboardProfileSettings');

    const doctorsListContainer = document.getElementById('doctorsList');
    const patientBookedCount = document.getElementById('patientBookedCount');
    const patientCancelledCount = document.getElementById('patientCancelledCount');
    const patientTotalDoctorsAvailable = document.getElementById('patientTotalDoctorsAvailable');
    const patientAppointmentsTableBody = document.getElementById('patientAppointmentsTable');
    const patientDoctorSearchInput = document.getElementById('patientDoctorSearch');
    const doctorsListPagination = document.getElementById('doctorsListPagination');
    const patientMedicalRecordsContent = document.getElementById('patientMedicalRecordsContent'); // New element
    let patientAppointmentStatusChartInstance;
    let patientSpecializationChartInstance;

    // Doctor Dashboard Elements
    const doctorDashboardOverview = document.getElementById('doctorDashboardOverview');
    const doctorDashboardAppointments = document.getElementById('doctorDashboardAppointments');
    const doctorDashboardMyPatients = document.getElementById('doctorDashboardMyPatients');
    const doctorDashboardSchedule = document.getElementById('doctorDashboardSchedule');
    const doctorDashboardPatientProfiles = document.getElementById('doctorDashboardPatientProfiles'); // New element
    const doctorDashboardVirtualConsultations = document.getElementById('doctorDashboardVirtualConsultations'); // New element
    const doctorDashboardReferrals = document.getElementById('doctorDashboardReferrals'); // New element
    const doctorDashboardPrescriptions = document.getElementById('doctorDashboardPrescriptions'); // New element
    const doctorDashboardPracticeAnalytics = document.getElementById('doctorDashboardPracticeAnalytics'); // New element

    const doctorTotalPatients = document.getElementById('doctorTotalPatients');
    const doctorAcceptedAppointments = document.getElementById('doctorAcceptedAppointments');
    const doctorPendingAppointments = document.getElementById('doctorPendingAppointments');
    const doctorRejectedAppointments = document.getElementById('doctorRejectedAppointments');
    const doctorAppointmentsList = document.getElementById('doctorAppointmentsList');
    const doctorPatientListTableBody = document.getElementById('doctorPatientListTable');
    const doctorPatientSearchInput = document.getElementById('doctorPatientSearch');
    const doctorAppointmentsPagination = document.getElementById('doctorAppointmentsPagination');
    const doctorPatientListPagination = document.getElementById('doctorPatientListPagination');
    const doctorScheduleSlots = document.getElementById('doctorScheduleSlots');
    const doctorPatientProfileSearchInput = document.getElementById('doctorPatientProfileSearch'); // New element
    const doctorPatientProfilesList = document.getElementById('doctorPatientProfilesList'); // New element
    const doctorPatientProfilesPagination = document.getElementById('doctorPatientProfilesPagination'); // New element
    let doctorAppointmentStatusChartInstance;
    let doctorPatientsByDiseaseChartInstance;
    let doctorMonthlyVisitsChartInstance; // New chart instance
    let doctorTopDiagnosesChartInstance; // New chart instance


    // Admin Dashboard Elements
    const adminDashboardOverview = document.getElementById('adminDashboardOverview');
    const adminDashboardManageDoctors = document.getElementById('adminDashboardManageDoctors');
    const adminDashboardManagePatients = document.getElementById('adminDashboardManagePatients');
    const adminDashboardManageAppointments = document.getElementById('adminDashboardManageAppointments');
    const adminDashboardSystemLogs = document.getElementById('adminDashboardSystemLogs');
    const adminDashboardUserManagement = document.getElementById('adminDashboardUserManagement'); // New element
    const adminDashboardSettings = document.getElementById('adminDashboardSettings'); // New element

    const adminTotalDoctors = document.getElementById('adminTotalDoctors');
    const adminTotalPatients = document.getElementById('adminTotalPatients');
    const adminTotalAppointments = document.getElementById('adminTotalAppointments');
    const newDoctorNameInput = document.getElementById('newDoctorName');
    const newDoctorSpecializationInput = document.getElementById('newDoctorSpecialization');
    const removeDoctorIdInput = document.getElementById('removeDoctorId');
    const slotDoctorIdInput = document.getElementById('slotDoctorId');
    const newSlotTimeInput = document.getElementById('newSlotTime');
    const cancelAppointmentIdInput = document.getElementById('cancelAppointmentId');
    const adminDoctorsTableBody = document.getElementById('adminDoctorsTable');
    const adminPatientsTableBody = document.getElementById('adminPatientsTable');
    const adminPatientSearchInput = document.getElementById('adminPatientSearch');
    const adminPatientListPagination = document.getElementById('adminPatientListPagination');
    const adminAppointmentsTableBody = document.getElementById('adminAppointmentsTable');
    const adminAppointmentSearchInput = document.getElementById('adminAppointmentSearch');
    const adminAppointmentsPagination = document.getElementById('adminAppointmentsPagination');
    let adminAppointmentStatusChartInstance;
    let adminDoctorsBySpecializationChartInstance;

    // Pagination state variables
    let currentPageDoctors = 1;
    let currentPageDoctorAppointments = 1;
    let currentPageDoctorPatients = 1;
    let currentPageDoctorPatientProfiles = 1; // New pagination state
    let currentPageAdminPatients = 1;
    let currentPageAdminAppointments = 1;


    // --- Dashboard Routing and Rendering ---

    /**
     * Sets up the sidebar navigation links dynamically based on the logged-in user type.
     * This ensures only relevant links are shown.
     * @param {string} userType - The type of the logged-in user ('patient', 'doctor', 'admin').
     */
    function setupDashboardSidebar(userType) {
        dashboardSidebarNav.innerHTML = ''; // Clear existing links

        let links = [];
        if (userType === 'patient') {
            links = [
                { text: 'Dashboard', icon: 'fas fa-th-large', section: 'overview' },
                { text: 'Book Appointment', icon: 'fas fa-calendar-plus', section: 'bookAppointment' },
                { text: 'My Appointments', icon: 'fas fa-calendar-check', section: 'myAppointments' },
                { text: 'Medical Records', icon: 'fas fa-file-medical', section: 'medicalRecords' }, // New
                { text: 'Messages', icon: 'fas fa-comments', section: 'messages' }, // New
                { text: 'Billing & Payments', icon: 'fas fa-dollar-sign', section: 'billingPayments' }, // New
                { text: 'Profile Settings', icon: 'fas fa-user-cog', section: 'profileSettings' } // New
            ];
        } else if (userType === 'doctor') {
            links = [
                { text: 'Dashboard', icon: 'fas fa-th-large', section: 'overview' },
                { text: 'My Appointments', icon: 'fas fa-calendar-alt', section: 'appointments' },
                { text: 'My Patients', icon: 'fas fa-user-injured', section: 'myPatients' },
                { text: 'My Schedule', icon: 'fas fa-clock', section: 'schedule' },
                { text: 'Patient Profiles', icon: 'fas fa-user-circle', section: 'patientProfiles' }, // New
                { text: 'Virtual Consultations', icon: 'fas fa-video', section: 'virtualConsultations' }, // New
                { text: 'Prescriptions', icon: 'fas fa-prescription-bottle-alt', section: 'prescriptions' }, // Existing placeholder, now with content
                { text: 'Referrals', icon: 'fas fa-share-square', section: 'referrals' }, // New
                { text: 'Practice Analytics', icon: 'fas fa-chart-line', section: 'practiceAnalytics' } // New
            ];
        } else if (userType === 'admin') {
            links = [
                { text: 'Dashboard', icon: 'fas fa-th-large', section: 'overview' },
                { text: 'Manage Doctors', icon: 'fas fa-user-md', section: 'manageDoctors' },
                { text: 'Manage Patients', icon: 'fas fa-user-injured', section: 'managePatients' },
                { text: 'Manage Appointments', icon: 'fas fa-calendar-alt', section: 'manageAppointments' },
                { text: 'User Management', icon: 'fas fa-users-cog', section: 'userManagement' }, // New
                { text: 'System Logs', icon: 'fas fa-clipboard-list', section: 'systemLogs' },
                { text: 'Settings', icon: 'fas fa-cog', section: 'settings' } // New
            ];
        }

        links.forEach(link => {
            const anchor = document.createElement('a');
            anchor.href = '#';
            anchor.className = `dashboard-nav-link ${link.section === currentDashboardSection ? 'active' : ''}`;
            anchor.setAttribute('data-dashboard-link', link.section);
            anchor.innerHTML = `<i class="${link.icon} text-xl"></i><span>${link.text}</span>`;
            anchor.addEventListener('click', (event) => {
                event.preventDefault();
                currentDashboardSection = link.section; // Update current section
                showDashboardContent(userType, link.section);

                // Update active class on sidebar links
                document.querySelectorAll('.dashboard-nav-link').forEach(l => l.classList.remove('active'));
                event.currentTarget.classList.add('active');
            });
            dashboardSidebarNav.appendChild(anchor);
        });
    }

    /**
     * Shows the content for the specified dashboard section for the given user type.
     * This function manages the visibility of different dashboard panels and triggers their rendering.
     * @param {string} userType - The type of the logged-in user ('patient', 'doctor', 'admin').
     * @param {string} section - The specific section to display (e.g., 'overview', 'bookAppointment').
     */
    function showDashboardContent(userType, section) {
        // Hide all dashboard panels first
        const allDashboardPanels = document.querySelectorAll('.dashboard-panel');
        allDashboardPanels.forEach(panel => {
            panel.style.display = 'none';
        });

        // Show the specific panel based on userType and section
        const targetPanelId = `${userType}Dashboard${section.charAt(0).toUpperCase() + section.slice(1)}`;
        const targetPanel = document.getElementById(targetPanelId);

        if (targetPanel) {
            targetPanel.style.display = 'block';
            // Call rendering functions specific to the active section
            if (userType === 'patient') {
                if (section === 'overview') {
                    renderPatientOverview();
                    renderPatientCharts();
                } else if (section === 'bookAppointment') {
                    currentPageDoctors = 1; // Reset pagination
                    renderDoctorsListForPatient();
                } else if (section === 'myAppointments') {
                    renderPatientAppointmentsTable();
                } else if (section === 'medicalRecords') {
                    renderPatientMedicalRecords(); // New rendering call
                } else if (section === 'messages') {
                    // Static content for now, but could be dynamic
                } else if (section === 'billingPayments') {
                    // Static content for now, but could be dynamic
                } else if (section === 'profileSettings') {
                    // Static content for now, but could be dynamic
                }
            } else if (userType === 'doctor') {
                if (section === 'overview') {
                    renderDoctorOverview();
                    renderDoctorCharts();
                } else if (section === 'appointments') {
                    currentPageDoctorAppointments = 1; // Reset pagination
                    renderDoctorAppointments();
                } else if (section === 'myPatients') {
                    currentPageDoctorPatients = 1; // Reset pagination
                    renderDoctorPatientList();
                } else if (section === 'schedule') {
                    renderDoctorSchedule();
                } else if (section === 'patientProfiles') {
                    currentPageDoctorPatientProfiles = 1; // Reset pagination
                    renderDoctorPatientProfiles(); // New rendering call
                } else if (section === 'virtualConsultations') {
                    // Static content for now
                } else if (section === 'referrals') {
                    // Static content for now
                } else if (section === 'prescriptions') {
                    // Static content for now
                } else if (section === 'practiceAnalytics') {
                    renderDoctorPracticeAnalyticsCharts(); // New rendering call
                }
            } else if (userType === 'admin') {
                if (section === 'overview') {
                    renderAdminOverview();
                    renderAdminCharts();
                } else if (section === 'manageDoctors') {
                    renderAdminDoctorsTable();
                } else if (section === 'managePatients') {
                    currentPageAdminPatients = 1; // Reset pagination
                    renderAdminPatientsTable();
                } else if (section === 'manageAppointments') {
                    currentPageAdminAppointments = 1; // Reset pagination
                    renderAdminAppointmentsTable();
                } else if (section === 'userManagement') {
                    // Static content for now
                } else if (section === 'systemLogs') {
                    // Static content for now
                } else if (section === 'settings') {
                    // Static content for now
                }
            }
        } else {
            console.error(`Dashboard panel not found: ${targetPanelId}`);
        }

        // Update active class on sidebar links
        document.querySelectorAll('.dashboard-nav-link').forEach(link => {
            if (link.dataset.dashboardLink === section) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }


    // --- Patient Dashboard Functions ---

    /**
     * Renders the patient's overview statistics and updates the counts.
     */
    function renderPatientOverview() {
        const patientSpecificAppointments = allAppointments.filter(app => app.patientName === loggedInUsername);
        const bookedCount = patientSpecificAppointments.filter(app => app.status === 'Approved').length;
        const cancelledCount = patientSpecificAppointments.filter(app => app.status === 'Cancelled').length;
        patientBookedCount.innerText = bookedCount;
        patientCancelledCount.innerText = cancelledCount;
        patientTotalDoctorsAvailable.innerText = doctors.length;
    }

    /**
     * Renders the list of doctors available for appointment booking for the patient, with search and pagination.
     */
    function renderDoctorsListForPatient() {
        const searchTerm = patientDoctorSearchInput.value.toLowerCase();
        const filteredDoctors = doctors.filter(doctor =>
            doctor.name.toLowerCase().includes(searchTerm) ||
            doctor.specialization.toLowerCase().includes(searchTerm)
        );

        const totalPages = Math.ceil(filteredDoctors.length / itemsPerPage);
        const startIndex = (currentPageDoctors - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const doctorsToDisplay = filteredDoctors.slice(startIndex, endIndex);

        doctorsListContainer.innerHTML = ''; // Clear previous list

        if (doctorsToDisplay.length === 0) {
            doctorsListContainer.innerHTML = `<p class="text-gray-500 col-span-full text-center">No doctors found matching your criteria.</p>`;
        } else {
            doctorsToDisplay.forEach(doctor => {
                const patientSpecificAppointment = allAppointments.find(app => app.doctorId === doctor.id && app.patientName === loggedInUsername);
                const buttonClass = getAppointmentButtonClassForPatient(patientSpecificAppointment);
                const buttonText = getAppointmentButtonTextForPatient(patientSpecificAppointment);

                const doctorCard = document.createElement('div');
                doctorCard.className = 'dashboard-card p-4 flex flex-col items-center text-center';
                doctorCard.innerHTML = `
                    <img src="${doctor.imageUrl}" onerror="this.onerror=null;this.src='https://placehold.co/100x100/e0f2fe/3b82f6?text=DR';" alt="${doctor.name}" class="rounded-full mb-3 border-4 border-blue-200">
                    <h3 class="text-xl font-semibold text-gray-800">${doctor.name}</h3>
                    <p class="text-blue-600 mb-1">${doctor.specialization}</p>
                    <p class="text-gray-500 text-sm mb-3">${doctor.experience} years experience | Rating: ${doctor.rating}/5</p>
                    <button class="book-appointment-btn w-full py-2 px-4 rounded-lg font-semibold transition duration-300 ease-in-out shadow-md ${buttonClass}"
                        data-doctor-id="${doctor.id}" data-doctor-name="${doctor.name}" data-specialization="${doctor.specialization}"
                        onclick="toggleAppointmentStatusForPatient('${doctor.id}', '${doctor.name}', '${doctor.specialization}', this)">
                        ${buttonText}
                    </button>
                `;
                doctorsListContainer.appendChild(doctorCard);
            });
        }
        renderPagination(doctorsListPagination, totalPages, currentPageDoctors, (page) => {
            currentPageDoctors = page;
            renderDoctorsListForPatient();
        });
    }

    /**
     * Filters the doctor list based on search input.
     */
    function filterDoctorsList() {
        currentPageDoctors = 1; // Reset to first page on new search
        renderDoctorsListForPatient();
    }

    /**
     * Determines the CSS class for the appointment button based on current status for a patient.
     * @param {object | undefined} appointment - The appointment object or undefined if not found.
     * @returns {string} CSS classes for the button.
     */
    function getAppointmentButtonClassForPatient(appointment) {
        if (appointment) {
            if (appointment.status === 'Approved') {
                return 'bg-green-500 text-white hover:bg-green-600';
            } else if (appointment.status === 'Cancelled') {
                return 'bg-red-500 text-white hover:bg-red-600';
            } else if (appointment.status === 'Pending') {
                return 'bg-yellow-500 text-white hover:bg-yellow-600';
            } else if (appointment.status === 'Rejected' || appointment.status === 'Cancelled by Admin') {
                return 'bg-gray-500 text-white cursor-not-allowed'; // Cannot re-book rejected/admin-cancelled
            }
        }
        return 'bg-blue-500 text-white hover:bg-blue-600';
    }

    /**
     * Determines the text for the appointment button based on current status for a patient.
     * @param {object | undefined} appointment - The appointment object or undefined if not found.
     * @returns {string} Text for the button.
     */
    function getAppointmentButtonTextForPatient(appointment) {
        if (appointment) {
            if (appointment.status === 'Approved') {
                return 'Approved';
            } else if (appointment.status === 'Cancelled') {
                return 'Cancelled';
            } else if (appointment.status === 'Pending') {
                return 'Pending';
            } else if (appointment.status === 'Rejected') {
                return 'Rejected';
            } else if (appointment.status === 'Cancelled by Admin') {
                return 'Admin Cancelled';
            }
        }
        return 'Book Appointment';
    }

    /**
     * Toggles the appointment status (Book -> Approved -> Cancelled) for a patient.
     * Updates both the global allAppointments array and the patient's specific view.
     * @param {string} doctorId - The ID of the doctor.
     * @param {string} doctorName - The name of the doctor.
     * @param {string} specialization - The specialization of the doctor.
     * @param {HTMLElement} buttonElement - The button element that was clicked.
     */
    function toggleAppointmentStatusForPatient(doctorId, doctorName, specialization, buttonElement) {
        const patientUsername = loggedInUsername;
        let appointment = allAppointments.find(app => app.doctorId === doctorId && app.patientName === patientUsername);

        if (appointment && (appointment.status === 'Rejected' || appointment.status === 'Cancelled by Admin')) {
            showCustomAlert('Action Not Allowed', 'This appointment cannot be re-booked by patient.');
            return;
        }

        if (!appointment) {
            // Book new appointment
            const newAppointment = {
                id: generateAppointmentId(),
                patientId: patients.find(p => p.name === patientUsername)?.id || 'P_UNKNOWN', // Find patient ID or default
                patientName: patientUsername,
                doctorId: doctorId,
                doctorName: doctorName,
                specialization: specialization,
                disease: 'General Checkup', // Default disease for new booking
                date: getRandomFutureDate(),
                time: getRandomSlot(doctors.find(d => d.id === doctorId)?.availableSlots || []),
                status: 'Approved' // Directly approved on patient booking for simplicity
            };
            allAppointments.push(newAppointment);
            showCustomAlert('Appointment Booked', `You have successfully booked an appointment with ${doctorName} for ${newAppointment.date} at ${newAppointment.time}.`);
        } else if (appointment.status === 'Approved') {
            // Change to Cancelled
            appointment.status = 'Cancelled';
            showCustomAlert('Appointment Cancelled', `Your appointment with ${doctorName} has been cancelled.`);
        } else if (appointment.status === 'Cancelled') {
            // Change back to Approved (re-book)
            appointment.status = 'Approved';
            showCustomAlert('Appointment Re-booked', `Your appointment with ${doctorName} has been re-booked.`);
        }

        // Re-render relevant sections to reflect changes
        renderDoctorsListForPatient(); // Update button state
        renderPatientAppointmentsTable(); // Update patient's own table
        renderPatientOverview(); // Update patient stats
        // Also update other dashboards if they are active
        if (loggedInUserType === 'doctor') renderDoctorAppointments(); // Only specific section
        if (loggedInUserType === 'admin') renderAdminAppointmentsTable(); // Only specific section
    }

    /**
     * Renders the patient's booked appointments in a table.
     */
    function renderPatientAppointmentsTable() {
        patientAppointmentsTableBody.innerHTML = '';
        const patientSpecificAppointments = allAppointments.filter(app => app.patientName === loggedInUsername);

        if (patientSpecificAppointments.length === 0) {
            patientAppointmentsTableBody.innerHTML = `<tr><td colspan="8" class="py-4 text-center text-gray-500">No appointments booked yet.</td></tr>`;
            return;
        }

        patientSpecificAppointments.forEach(app => {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-200 hover:bg-gray-50';
            let statusClass = '';
            if (app.status === 'Approved') {
                statusClass = 'bg-green-200 text-green-800';
            } else if (app.status === 'Cancelled') {
                statusClass = 'bg-red-200 text-red-800';
            } else if (app.status === 'Pending') {
                statusClass = 'bg-yellow-200 text-yellow-800';
            } else if (app.status === 'Rejected') {
                statusClass = 'bg-gray-200 text-gray-800';
            } else if (app.status === 'Cancelled by Admin') {
                statusClass = 'bg-gray-300 text-gray-700';
            }

            row.innerHTML = `
                <td class="py-3 px-6 text-left whitespace-nowrap">${app.id}</td>
                <td class="py-3 px-6 text-left">${app.doctorName}</td>
                <td class="py-3 px-6 text-left">${app.specialization}</td>
                <td class="py-3 px-6 text-left">${app.disease}</td>
                <td class="py-3 px-6 text-left">${app.date}</td>
                <td class="py-3 px-6 text-left">${app.time}</td>
                <td class="py-3 px-6 text-left">
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                        <span aria-hidden="true" class="absolute inset-0 opacity-50 rounded-full ${statusClass}"></span>
                        <span class="relative">${app.status}</span>
                    </span>
                </td>
                <td class="py-3 px-6 text-center">
                    ${app.status !== 'Cancelled by Admin' && app.status !== 'Rejected' ? `
                        <button class="py-1 px-3 rounded-md text-white
                            ${app.status === 'Cancelled' ? 'bg-blue-500 hover:bg-blue-600' : 'bg-red-500 hover:bg-red-600'}"
                            onclick="toggleAppointmentStatusForPatient('${app.doctorId}', '${app.doctorName}', '${app.specialization}', this)">
                            ${app.status === 'Cancelled' ? 'Re-book' : 'Cancel'}
                        </button>
                    ` : '<span class="text-gray-500">N/A</span>'}
                </td>
            `;
            patientAppointmentsTableBody.appendChild(row);
        });
    }

    /**
     * Renders charts for the patient dashboard.
     */
    function renderPatientCharts() {
        // Destroy existing chart instances if they exist
        if (patientAppointmentStatusChartInstance) {
            patientAppointmentStatusChartInstance.destroy();
        }
        if (patientSpecializationChartInstance) {
            patientSpecializationChartInstance.destroy();
        }

        const patientSpecificAppointments = allAppointments.filter(app => app.patientName === loggedInUsername);

        // Patient Appointment Status Chart
        const patientAppointmentStatusCtx = document.getElementById('patientAppointmentStatusChart').getContext('2d');
        const statusCounts = patientSpecificAppointments.reduce((acc, app) => {
            acc[app.status] = (acc[app.status] || 0) + 1;
            return acc;
        }, {});

        patientAppointmentStatusChartInstance = new Chart(patientAppointmentStatusCtx, {
            type: 'pie',
            data: {
                labels: Object.keys(statusCounts),
                datasets: [{
                    data: Object.values(statusCounts),
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)', // Approved
                        'rgba(255, 99, 132, 0.6)', // Cancelled
                        'rgba(255, 206, 86, 0.6)', // Pending
                        'rgba(150, 150, 150, 0.6)', // Rejected
                        'rgba(100, 100, 100, 0.6)' // Cancelled by Admin
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(150, 150, 150, 1)',
                        'rgba(100, 100, 100, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'My Appointment Status'
                    }
                }
            }
        });

        // Appointments by Specialization Chart (Patient's perspective)
        const patientSpecializationCtx = document.getElementById('patientSpecializationChart').getContext('2d');
        const specializationCounts = patientSpecificAppointments.reduce((acc, app) => {
            acc[app.specialization] = (acc[app.specialization] || 0) + 1;
            return acc;
        }, {});

        patientSpecializationChartInstance = new Chart(patientSpecializationCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(specializationCounts),
                datasets: [{
                    label: 'Appointments',
                    data: Object.values(specializationCounts),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)', // Blue
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false,
                        text: 'Appointments by Specialization'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    /**
     * Renders simulated patient medical records.
     */
    function renderPatientMedicalRecords() {
        patientMedicalRecordsContent.innerHTML = '';
        const patient = patients.find(p => p.name === loggedInUsername);

        if (!patient) {
            patientMedicalRecordsContent.innerHTML = `<p class="text-gray-500">Medical records not found for this patient.</p>`;
            return;
        }

        let medicalHistoryHtml = patient.medicalHistory.length > 0 ?
            patient.medicalHistory.map(item => `<li>${item}</li>`).join('') :
            '<li>No significant medical history recorded.</li>';

        patientMedicalRecordsContent.innerHTML = `
            <div class="mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Personal Information</h3>
                <p><strong>Name:</strong> ${patient.name}</p>
                <p><strong>Patient ID:</strong> ${patient.id}</p>
                <p><strong>Current Disease:</strong> ${patient.disease}</p>
                <p><strong>Room/Bed:</strong> ${patient.roomBed}</p>
            </div>
            <div class="mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Medical History</h3>
                <ul class="list-disc list-inside ml-4">
                    ${medicalHistoryHtml}
                </ul>
            </div>
            <div class="mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Recent Visits</h3>
                <ul class="list-disc list-inside ml-4">
                    <li>2025-06-20: Consultation with Dr. Alice Smith (Cardiology) - Diagnosis: Mild Arrhythmia</li>
                    <li>2025-05-10: General Checkup with Dr. Bob Johnson - No major issues</li>
                    <li>2025-03-05: Follow-up for Flu with Dr. Bob Johnson - Recovered</li>
                </ul>
            </div>
            <div class="mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Allergies</h3>
                <ul class="list-disc list-inside ml-4">
                    <li>Dust Mites (mild)</li>
                    <li>Penicillin (reported)</li>
                </ul>
            </div>
            <div class="mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Current Medications</h3>
                <ul class="list-disc list-inside ml-4">
                    <li>Vitamin D Supplement (daily)</li>
                </ul>
            </div>
            <button class="py-2 px-4 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition duration-300" onclick="showCustomAlert('Download Medical Records', 'Downloading your medical records as PDF (simulated).')">
                <i class="fas fa-download mr-2"></i>Download Records
            </button>
        `;
    }


    // --- Doctor Dashboard Functions ---

    /**
     * Renders the doctor's overview cards.
     */
    function renderDoctorOverview() {
        // Filter appointments relevant to the logged-in doctor
        const myAppointments = allAppointments.filter(app => app.doctorId === 'D001'); // Assuming D001 is the logged-in doctor for demo
        const accepted = myAppointments.filter(app => app.status === 'Accepted').length;
        const pending = myAppointments.filter(app => app.status === 'Pending').length;
        const rejected = myAppointments.filter(app => app.status === 'Rejected').length;
        const totalPatients = new Set(myAppointments.map(app => app.patientId)).size; // Unique patients

        doctorTotalPatients.innerText = totalPatients;
        doctorAcceptedAppointments.innerText = accepted;
        doctorPendingAppointments.innerText = pending;
        doctorRejectedAppointments.innerText = rejected;
    }

    /**
     * Renders the doctor's planned consultations/appointment requests, with pagination.
     */
    function renderDoctorAppointments() {
        const myAppointments = allAppointments.filter(app => app.doctorId === 'D001'); // Assuming D001 is the logged-in doctor for demo

        const totalPages = Math.ceil(myAppointments.length / itemsPerPage);
        const startIndex = (currentPageDoctorAppointments - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const appointmentsToDisplay = myAppointments.slice(startIndex, endIndex);

        doctorAppointmentsList.innerHTML = '';

        if (appointmentsToDisplay.length === 0) {
            doctorAppointmentsList.innerHTML = `<p class="text-gray-500 col-span-full text-center">No appointments scheduled for you.</p>`;
            return;
        }

        appointmentsToDisplay.forEach(app => {
            const appointmentCard = document.createElement('div');
            appointmentCard.className = 'dashboard-card p-4 flex flex-col md:flex-row items-center justify-between';
            let statusColorClass = '';
            if (app.status === 'Accepted') statusColorClass = 'text-green-500';
            else if (app.status === 'Pending') statusColorClass = 'text-yellow-500';
            else if (app.status === 'Rejected') statusColorClass = 'text-red-500';
            else if (app.status === 'Approved') statusColorClass = 'text-blue-500'; // Patient booked status
            else if (app.status === 'Cancelled') statusColorClass = 'text-gray-500'; // Patient cancelled status
            else if (app.status === 'Cancelled by Admin') statusColorClass = 'text-gray-600';


            appointmentCard.innerHTML = `
                <div class="flex items-center gap-4 mb-4 md:mb-0">
                    <img src="https://placehold.co/60x60/f0f9ff/3b82f6?text=PT" alt="${app.patientName}" class="rounded-full border-2 border-gray-200">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">${app.patientName} (ID: ${app.patientId})</h3>
                        <p class="text-gray-600 text-sm">Disease: ${app.disease}</p>
                    </div>
                </div>
                <div class="text-right md:text-left">
                    <p class="text-gray-600 text-sm"><i class="fas fa-calendar-alt mr-1"></i>${app.date}</p>
                    <p class="text-gray-600 text-sm"><i class="fas fa-clock mr-1"></i>${app.time}</p>
                    <p class="font-semibold ${statusColorClass}">Status: ${app.status}</p>
                </div>
                <div class="flex gap-2 mt-4 md:mt-0">
                    ${app.status === 'Pending' ? `
                        <button class="py-2 px-4 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300" onclick="acceptAppointment('${app.id}')">Accept</button>
                        <button class="py-2 px-4 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300" onclick="rejectAppointment('${app.id}')">Reject</button>
                    ` : `<span class="text-gray-500 text-sm">Actioned</span>`}
                </div>
            `;
            doctorAppointmentsList.appendChild(appointmentCard);
        });
        renderPagination(doctorAppointmentsPagination, totalPages, currentPageDoctorAppointments, (page) => {
            currentPageDoctorAppointments = page;
            renderDoctorAppointments();
        });
    }

    /**
     * Accepts a doctor's appointment.
     * @param {string} appointmentId - The ID of the appointment to accept.
     */
    function acceptAppointment(appointmentId) {
        const appointment = allAppointments.find(app => app.id === appointmentId);
        if (appointment) {
            appointment.status = 'Accepted';
            showCustomAlert('Appointment Accepted', `Appointment ${appointmentId} with ${appointment.patientName} has been accepted.`);
            renderDoctorAppointments(); // Re-render to update UI
            renderDoctorOverview(); // Update stats
            renderPatientAppointmentsTable(); // Update patient view
            renderAdminAppointmentsTable(); // Update admin view
            renderDoctorCharts(); // Update charts
            renderDoctorPracticeAnalyticsCharts(); // Update new charts
        }
    }

    /**
     * Rejects a doctor's appointment.
     * @param {string} appointmentId - The ID of the appointment to reject.
     */
    function rejectAppointment(appointmentId) {
        const appointment = allAppointments.find(app => app.id === appointmentId);
        if (appointment) {
            appointment.status = 'Rejected';
            showCustomAlert('Appointment Rejected', `Appointment ${appointmentId} with ${appointment.patientName} has been rejected.`);
            renderDoctorAppointments(); // Re-render to update UI
            renderDoctorOverview(); // Update stats
            renderPatientAppointmentsTable(); // Update patient view
            renderAdminAppointmentsTable(); // Update admin view
            renderDoctorCharts(); // Update charts
            renderDoctorPracticeAnalyticsCharts(); // Update new charts
        }
    }

    /**
     * Renders the patient list for the doctor dashboard, with search and pagination.
     */
    function renderDoctorPatientList() {
        doctorPatientListTableBody.innerHTML = '';
        // Filter patients who have appointments with the logged-in doctor
        const patientsWithAppointmentsSet = new Set(allAppointments
            .filter(app => app.doctorId === 'D001') // Assuming D001 is the logged-in doctor
            .map(app => app.patientId));

        let myPatients = patients.filter(p => patientsWithAppointmentsSet.has(p.id));

        const searchTerm = doctorPatientSearchInput.value.toLowerCase();
        if (searchTerm) {
            myPatients = myPatients.filter(patient =>
                patient.name.toLowerCase().includes(searchTerm) ||
                patient.id.toLowerCase().includes(searchTerm)
            );
        }

        const totalPages = Math.ceil(myPatients.length / itemsPerPage);
        const startIndex = (currentPageDoctorPatients - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const patientsToDisplay = myPatients.slice(startIndex, endIndex);

        if (patientsToDisplay.length === 0) {
            doctorPatientListTableBody.innerHTML = `<tr><td colspan="6" class="py-4 text-center text-gray-500">No patients found associated with your appointments or matching search.</td></tr>`;
            return;
        }

        patientsToDisplay.forEach(patient => {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-200 hover:bg-gray-50';
            row.innerHTML = `
                <td class="py-3 px-6 text-left whitespace-nowrap">${patient.id}</td>
                <td class="py-3 px-6 text-left">${patient.name}</td>
                <td class="py-3 px-6 text-left">${new Date().toISOString().slice(0, 10)}</td> <!-- Mock check-in date -->
                <td class="py-3 px-6 text-left">${patient.disease}</td>
                <td class="py-3 px-6 text-left">${patient.roomBed}</td>
                <td class="py-3 px-6 text-center">
                    <button class="py-1 px-3 rounded-md text-white bg-blue-500 hover:bg-blue-600 transition duration-300" onclick="viewPatientMedicalHistory('${patient.id}')">
                        <i class="fas fa-notes-medical mr-1"></i>History
                    </button>
                </td>
            `;
            doctorPatientListTableBody.appendChild(row);
        });
        renderPagination(doctorPatientListPagination, totalPages, currentPageDoctorPatients, (page) => {
            currentPageDoctorPatients = page;
            renderDoctorPatientList();
        });
    }

    /**
     * Filters the doctor's patient list based on search input.
     */
    function filterDoctorPatientList() {
        currentPageDoctorPatients = 1; // Reset to first page on new search
        renderDoctorPatientList();
    }

    /**
     * Simulates viewing patient medical history.
     * @param {string} patientId - The ID of the patient.
     */
    function viewPatientMedicalHistory(patientId) {
        const patient = patients.find(p => p.id === patientId);
        if (patient) {
            let historyHtml = patient.medicalHistory.length > 0 ?
                patient.medicalHistory.map(item => `<li>${item}</li>`).join('') :
                '<li>No significant medical history recorded.</li>';
            showCustomAlert(
                `Medical History for ${patient.name} (ID: ${patient.id})`,
                `<ul class="list-disc list-inside">${historyHtml}</ul>`
            );
        } else {
            showCustomAlert('Error', 'Patient not found.');
        }
    }

    /**
     * Renders the doctor's schedule (available slots).
     */
    function renderDoctorSchedule() {
        doctorScheduleSlots.innerHTML = '';
        const doctor = doctors.find(d => d.id === 'D001'); // Assuming D001 is the logged-in doctor
        if (!doctor || doctor.availableSlots.length === 0) {
            doctorScheduleSlots.innerHTML = `<p class="text-gray-500 col-span-full text-center">No available slots set for today.</p>`;
            return;
        }

        doctor.availableSlots.forEach(slot => {
            const slotCard = document.createElement('div');
            slotCard.className = 'dashboard-card p-4 text-center border border-blue-200 bg-blue-50';
            slotCard.innerHTML = `
                <p class="text-lg font-semibold text-blue-800">${slot}</p>
                <p class="text-sm text-gray-600">Available</p>
            `;
            doctorScheduleSlots.appendChild(slotCard);
        });
    }

    /**
     * Renders detailed patient profiles for doctors, with search and pagination.
     */
    function renderDoctorPatientProfiles() {
        doctorPatientProfilesList.innerHTML = '';
        let filteredPatients = patients;

        const searchTerm = doctorPatientProfileSearchInput.value.toLowerCase();
        if (searchTerm) {
            filteredPatients = patients.filter(patient =>
                patient.name.toLowerCase().includes(searchTerm) ||
                patient.id.toLowerCase().includes(searchTerm) ||
                patient.disease.toLowerCase().includes(searchTerm)
            );
        }

        const totalPages = Math.ceil(filteredPatients.length / itemsPerPage);
        const startIndex = (currentPageDoctorPatientProfiles - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const patientsToDisplay = filteredPatients.slice(startIndex, endIndex);

        if (patientsToDisplay.length === 0) {
            doctorPatientProfilesList.innerHTML = `<p class="text-gray-500 col-span-full text-center">No patient profiles found matching your criteria.</p>`;
            return;
        }

        patientsToDisplay.forEach(patient => {
            const profileCard = document.createElement('div');
            profileCard.className = 'dashboard-card p-4 flex flex-col items-center text-center';
            profileCard.innerHTML = `
                <img src="https://placehold.co/80x80/f0f9ff/3b82f6?text=PT" alt="${patient.name}" class="rounded-full mb-3 border-4 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800">${patient.name}</h3>
                <p class="text-gray-600 mb-1">ID: ${patient.id}</p>
                <p class="text-gray-600 mb-1">Disease: ${patient.disease}</p>
                <p class="text-gray-600 text-sm mb-3">Room/Bed: ${patient.roomBed}</p>
                <button class="py-2 px-4 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition duration-300" onclick="viewPatientMedicalHistory('${patient.id}')">
                    <i class="fas fa-notes-medical mr-2"></i>Full History
                </button>
            `;
            doctorPatientProfilesList.appendChild(profileCard);
        });
        renderPagination(doctorPatientProfilesPagination, totalPages, currentPageDoctorPatientProfiles, (page) => {
            currentPageDoctorPatientProfiles = page;
            renderDoctorPatientProfiles();
        });
    }

    /**
     * Filters the doctor's patient profiles list based on search input.
     */
    function filterDoctorPatientProfiles() {
        currentPageDoctorPatientProfiles = 1; // Reset to first page on new search
        renderDoctorPatientProfiles();
    }

    /**
     * Renders charts for the doctor dashboard.
     */
    function renderDoctorCharts() {
        // Destroy existing chart instances if they exist
        if (doctorAppointmentStatusChartInstance) {
            doctorAppointmentStatusChartInstance.destroy();
        }
        if (doctorPatientsByDiseaseChartInstance) {
            doctorPatientsByDiseaseChartInstance.destroy();
        }

        const myAppointments = allAppointments.filter(app => app.doctorId === 'D001');
        const myPatients = patients.filter(p => new Set(myAppointments.map(app => app.patientId)).has(p.id));

        // Doctor Appointment Status Chart
        const doctorAppointmentStatusCtx = document.getElementById('doctorAppointmentStatusChart').getContext('2d');
        const statusCounts = myAppointments.reduce((acc, app) => {
            acc[app.status] = (acc[app.status] || 0) + 1;
            return acc;
        }, {});

        doctorAppointmentStatusChartInstance = new Chart(doctorAppointmentStatusCtx, {
            type: 'pie',
            data: {
                labels: Object.keys(statusCounts),
                datasets: [{
                    data: Object.values(statusCounts),
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)', // Accepted
                        'rgba(255, 206, 86, 0.6)', // Pending
                        'rgba(255, 99, 132, 0.6)', // Rejected
                        'rgba(54, 162, 235, 0.6)', // Approved (patient booked)
                        'rgba(150, 150, 150, 0.6)', // Cancelled
                        'rgba(100, 100, 100, 0.6)' // Cancelled by Admin
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(150, 150, 150, 1)',
                        'rgba(100, 100, 100, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'My Appointment Status'
                    }
                }
            }
        });

        // Patients by Disease Chart (My Patients)
        const doctorPatientsByDiseaseCtx = document.getElementById('doctorPatientsByDiseaseChart').getContext('2d');
        const diseaseCounts = myPatients.reduce((acc, patient) => {
            acc[patient.disease] = (acc[patient.disease] || 0) + 1;
            return acc;
        }, {});

        doctorPatientsByDiseaseChartInstance = new Chart(doctorPatientsByDiseaseCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(diseaseCounts),
                datasets: [{
                    label: 'Number of Patients',
                    data: Object.values(diseaseCounts),
                    backgroundColor: 'rgba(153, 102, 255, 0.6)', // Purple
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false,
                        text: 'Patients by Disease'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    /**
     * Renders charts for the doctor's practice analytics.
     */
    function renderDoctorPracticeAnalyticsCharts() {
        if (doctorMonthlyVisitsChartInstance) {
            doctorMonthlyVisitsChartInstance.destroy();
        }
        if (doctorTopDiagnosesChartInstance) {
            doctorTopDiagnosesChartInstance.destroy();
        }

        const myAppointments = allAppointments.filter(app => app.doctorId === 'D001' && app.status === 'Accepted');

        // Monthly Patient Visits Chart
        const monthlyVisitsCtx = document.getElementById('doctorMonthlyVisitsChart').getContext('2d');
        const monthlyVisitsData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Accepted Appointments',
                data: [15, 20, 25, 18, 22, 30, myAppointments.length], // Last value is dynamic
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };
        doctorMonthlyVisitsChartInstance = new Chart(monthlyVisitsCtx, {
            type: 'line',
            data: monthlyVisitsData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false,
                        text: 'Monthly Patient Visits'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Top 5 Diagnoses Chart
        const topDiagnosesCtx = document.getElementById('doctorTopDiagnosesChart').getContext('2d');
        const diagnosisCounts = myAppointments.reduce((acc, app) => {
            acc[app.disease] = (acc[app.disease] || 0) + 1;
            return acc;
        }, {});

        const sortedDiagnoses = Object.entries(diagnosisCounts).sort(([, a], [, b]) => b - a).slice(0, 5);
        const topDiagnosesLabels = sortedDiagnoses.map(([disease]) => disease);
        const topDiagnosesData = sortedDiagnoses.map(([, count]) => count);

        doctorTopDiagnosesChartInstance = new Chart(topDiagnosesCtx, {
            type: 'bar',
            data: {
                labels: topDiagnosesLabels,
                datasets: [{
                    label: 'Number of Cases',
                    data: topDiagnosesData,
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false,
                        text: 'Top 5 Diagnoses'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }


    // --- Admin Dashboard Functions ---

    /**
     * Renders the admin overview statistics.
     */
    function renderAdminOverview() {
        adminTotalDoctors.innerText = doctors.length;
        adminTotalPatients.innerText = patients.length;
        adminTotalAppointments.innerText = allAppointments.length;
    }

    /**
     * Renders charts for the admin dashboard.
     */
    function renderAdminCharts() {
        // Destroy existing chart instances if they exist
        if (adminAppointmentStatusChartInstance) {
            adminAppointmentStatusChartInstance.destroy();
        }
        if (adminDoctorsBySpecializationChartInstance) {
            adminDoctorsBySpecializationChartInstance.destroy();
        }

        // Overall Appointment Status Chart
        const adminAppointmentStatusCtx = document.getElementById('adminAppointmentStatusChart').getContext('2d');
        const statusCounts = allAppointments.reduce((acc, app) => {
            acc[app.status] = (acc[app.status] || 0) + 1;
            return acc;
        }, {});

        adminAppointmentStatusChartInstance = new Chart(adminAppointmentStatusCtx, {
            type: 'pie',
            data: {
                labels: Object.keys(statusCounts),
                datasets: [{
                    data: Object.values(statusCounts),
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)', // Accepted/Approved
                        'rgba(255, 206, 86, 0.6)', // Pending
                        'rgba(255, 99, 132, 0.6)', // Rejected
                        'rgba(54, 162, 235, 0.6)', // Booked (Approved by patient)
                        'rgba(150, 150, 150, 0.6)', // Cancelled
                        'rgba(100, 100, 100, 0.6)' // Cancelled by Admin
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(150, 150, 150, 1)',
                        'rgba(100, 100, 100, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Overall Appointment Status'
                    }
                }
            }
        });

        // Doctors by Specialization Chart
        const adminDoctorsBySpecializationCtx = document.getElementById('adminDoctorsBySpecializationChart').getContext('2d');
        const specializationCounts = doctors.reduce((acc, doctor) => {
            acc[doctor.specialization] = (acc[doctor.specialization] || 0) + 1;
            return acc;
        }, {});

        adminDoctorsBySpecializationChartInstance = new Chart(adminDoctorsBySpecializationCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(specializationCounts),
                datasets: [{
                    label: 'Number of Doctors',
                    data: Object.values(specializationCounts),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)', // Greenish
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false,
                        text: 'Doctors by Specialization'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    /**
     * Renders the list of all doctors for the admin.
     */
    function renderAdminDoctorsTable() {
        adminDoctorsTableBody.innerHTML = '';
        if (doctors.length === 0) {
            adminDoctorsTableBody.innerHTML = `<tr><td colspan="4" class="py-4 text-center text-gray-500">No doctors registered.</td></tr>`;
            return;
        }

        doctors.forEach(doctor => {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-200 hover:bg-gray-50';
            row.innerHTML = `
                <td class="py-3 px-6 text-left whitespace-nowrap">${doctor.id}</td>
                <td class="py-3 px-6 text-left">${doctor.name}</td>
                <td class="py-3 px-6 text-left">${doctor.specialization}</td>
                <td class="py-3 px-6 text-left">${doctor.availableSlots.join(', ')}</td>
            `;
            adminDoctorsTableBody.appendChild(row);
        });
    }

    /**
     * Admin function to add a new doctor.
     */
    function adminAddDoctor() {
        const name = newDoctorNameInput.value.trim();
        const specialization = newDoctorSpecializationInput.value.trim();

        if (!name || !specialization) {
            showCustomAlert('Error', 'Please enter both doctor name and specialization.');
            return;
        }

        const newDoctorId = 'D' + String(doctors.length + 1).padStart(3, '0');
        const newDoctor = {
            id: newDoctorId,
            name: name,
            specialization: specialization,
            availableSlots: ['09:00', '10:00', '11:00', '13:00', '14:00'], // Default slots
            rating: 0, // New doctors start with no rating
            experience: 0, // New doctors start with no experience
            imageUrl: `https://placehold.co/100x100/e0f2fe/3b82f6?text=DR${doctors.length + 1}`
        };
        doctors.push(newDoctor);
        showCustomAlert('Success', `${name} (${specialization}) added as a new doctor with ID ${newDoctorId}.`);
        newDoctorNameInput.value = '';
        newDoctorSpecializationInput.value = '';
        renderAdminDoctorsTable(); // Re-render to update the list
        renderAdminOverview(); // Update stats
        renderAdminCharts(); // Update charts
        renderDoctorsListForPatient(); // Update patient's view of doctors
    }

    /**
     * Admin function to remove a doctor.
     */
    function adminRemoveDoctor() {
        const doctorIdToRemove = removeDoctorIdInput.value.trim().toUpperCase();
        const initialLength = doctors.length;
        doctors = doctors.filter(doc => doc.id !== doctorIdToRemove);

        if (doctors.length < initialLength) {
            showCustomAlert('Success', `Doctor ${doctorIdToRemove} has been removed.`);
            // Also remove associated appointments
            allAppointments = allAppointments.filter(app => app.doctorId !== doctorIdToRemove);

            renderAdminDoctorsTable(); // Re-render to update the list
            renderAdminOverview(); // Update stats
            renderAdminCharts(); // Update charts
            renderDoctorsListForPatient(); // Update patient's view of doctors
            // Note: In a real app, you'd also handle doctor user accounts.
        } else {
            showCustomAlert('Error', `Doctor with ID ${doctorIdToRemove} not found.`);
        }
        removeDoctorIdInput.value = '';
    }

    /**
     * Admin function to change a doctor's slot time.
     */
    function adminChangeSlotTime() {
        const doctorId = slotDoctorIdInput.value.trim().toUpperCase();
        const newSlot = newSlotTimeInput.value.trim();

        if (!doctorId || !newSlot) {
            showCustomAlert('Error', 'Please enter both Doctor ID and a new slot time.');
            return;
        }

        const doctor = doctors.find(doc => doc.id === doctorId);
        if (doctor) {
            // For simplicity, replacing all slots with the new one.
            // In a real app, you'd manage individual slots carefully (add/remove specific slots).
            doctor.availableSlots = [newSlot];
            showCustomAlert('Success', `Doctor ${doctorId}'s slot time updated to ${newSlot}.`);
            renderAdminDoctorsTable(); // Re-render to update the list
            renderDoctorsListForPatient(); // Update patient's view of doctors
        } else {
            showCustomAlert('Error', `Doctor with ID ${doctorId} not found.`);
        }
        slotDoctorIdInput.value = '';
        newSlotTimeInput.value = '';
    }

    /**
     * Renders the list of all patients for the admin, with search and pagination.
     */
    function renderAdminPatientsTable() {
        adminPatientsTableBody.innerHTML = '';
        let filteredPatients = patients;

        const searchTerm = adminPatientSearchInput.value.toLowerCase();
        if (searchTerm) {
            filteredPatients = patients.filter(patient =>
                patient.name.toLowerCase().includes(searchTerm) ||
                patient.id.toLowerCase().includes(searchTerm) ||
                patient.disease.toLowerCase().includes(searchTerm)
            );
        }

        const totalPages = Math.ceil(filteredPatients.length / itemsPerPage);
        const startIndex = (currentPageAdminPatients - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const patientsToDisplay = filteredPatients.slice(startIndex, endIndex);

        if (patientsToDisplay.length === 0) {
            adminPatientsTableBody.innerHTML = `<tr><td colspan="5" class="py-4 text-center text-gray-500">No patients registered or matching search.</td></tr>`;
            return;
        }

        patientsToDisplay.forEach(patient => {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-200 hover:bg-gray-50';
            row.innerHTML = `
                <td class="py-3 px-6 text-left whitespace-nowrap">${patient.id}</td>
                <td class="py-3 px-6 text-left">${patient.name}</td>
                <td class="py-3 px-6 text-left">${patient.disease}</td>
                <td class="py-3 px-6 text-left">${patient.roomBed}</td>
                <td class="py-3 px-6 text-center">
                    <button class="py-1 px-3 rounded-md text-white bg-red-500 hover:bg-red-600 transition duration-300" onclick="adminDeactivatePatient('${patient.id}')">
                        <i class="fas fa-user-slash mr-1"></i>Deactivate
                    </button>
                </td>
            `;
            adminPatientsTableBody.appendChild(row);
        });
        renderPagination(adminPatientListPagination, totalPages, currentPageAdminPatients, (page) => {
            currentPageAdminPatients = page;
            renderAdminPatientsTable();
        });
    }

    /**
     * Filters the admin's patient list based on search input.
     */
    function filterAdminPatientList() {
        currentPageAdminPatients = 1; // Reset to first page on new search
        renderAdminPatientsTable();
    }

    /**
     * Admin function to simulate deactivating a patient account.
     * @param {string} patientId - The ID of the patient to deactivate.
     */
    function adminDeactivatePatient(patientId) {
        // In a real system, this would mark the user as inactive in the database.
        // For this demo, we'll just show an alert.
        const patient = patients.find(p => p.id === patientId);
        if (patient) {
            showCustomAlert('Patient Deactivated', `Patient ${patient.name} (ID: ${patient.id}) has been deactivated (simulated).`);
            // Optionally remove from list for demo effect:
            patients = patients.filter(p => p.id !== patientId);
            renderAdminPatientsTable();
            renderAdminOverview();
        } else {
            showCustomAlert('Error', 'Patient not found.');
        }
    }

    /**
     * Renders the list of all appointments for the admin, with search and pagination.
     */
    function renderAdminAppointmentsTable() {
        adminAppointmentsTableBody.innerHTML = '';
        let filteredAppointments = allAppointments;

        const searchTerm = adminAppointmentSearchInput.value.toLowerCase();
        if (searchTerm) {
            filteredAppointments = allAppointments.filter(app =>
                app.id.toLowerCase().includes(searchTerm) ||
                app.patientName.toLowerCase().includes(searchTerm) ||
                app.doctorName.toLowerCase().includes(searchTerm) ||
                app.specialization.toLowerCase().includes(searchTerm) ||
                app.disease.toLowerCase().includes(searchTerm) ||
                app.status.toLowerCase().includes(searchTerm)
            );
        }

        const totalPages = Math.ceil(filteredAppointments.length / itemsPerPage);
        const startIndex = (currentPageAdminAppointments - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const appointmentsToDisplay = filteredAppointments.slice(startIndex, endIndex);

        if (appointmentsToDisplay.length === 0) {
            adminAppointmentsTableBody.innerHTML = `<tr><td colspan="8" class="py-4 text-center text-gray-500">No appointments in the system or matching search.</td></tr>`;
            return;
        }

        appointmentsToDisplay.forEach(app => {
            const row = document.createElement('tr');
            row.className = 'border-b border-gray-200 hover:bg-gray-50';
            let statusClass = '';
            if (app.status === 'Approved') {
                statusClass = 'bg-green-200 text-green-800';
            } else if (app.status === 'Cancelled') {
                statusClass = 'bg-red-200 text-red-800';
            } else if (app.status === 'Pending') {
                statusClass = 'bg-yellow-200 text-yellow-800';
            } else if (app.status === 'Rejected') {
                statusClass = 'bg-gray-200 text-gray-800';
            } else if (app.status === 'Accepted') {
                statusClass = 'bg-blue-200 text-blue-800';
            } else if (app.status === 'Cancelled by Admin') {
                statusClass = 'bg-gray-300 text-gray-700';
            }

            row.innerHTML = `
                <td class="py-3 px-6 text-left whitespace-nowrap">${app.id}</td>
                <td class="py-3 px-6 text-left">${app.patientName} (ID: ${app.patientId})</td>
                <td class="py-3 px-6 text-left">${app.doctorName} (ID: ${app.doctorId})</td>
                <td class="py-3 px-6 text-left">${app.specialization}</td>
                <td class="py-3 px-6 text-left">${app.disease}</td>
                <td class="py-3 px-6 text-left">${app.date}</td>
                <td class="py-3 px-6 text-left">${app.time}</td>
                <td class="py-3 px-6 text-left">
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                        <span aria-hidden="true" class="absolute inset-0 opacity-50 rounded-full ${statusClass}"></span>
                        <span class="relative">${app.status}</span>
                    </span>
                </td>
            `;
            adminAppointmentsTableBody.appendChild(row);
        });
        renderPagination(adminAppointmentsPagination, totalPages, currentPageAdminAppointments, (page) => {
            currentPageAdminAppointments = page;
            renderAdminAppointmentsTable();
        });
    }

    /**
     * Filters the admin's appointment list based on search input.
     */
    function filterAdminAppointmentList() {
        currentPageAdminAppointments = 1; // Reset to first page on new search
        renderAdminAppointmentsTable();
    }

    /**
     * Admin function to cancel any meeting by appointment ID.
     */
    function adminCancelMeeting() {
        const appIdToCancel = cancelAppointmentIdInput.value.trim();
        const appointment = allAppointments.find(app => app.id === appIdToCancel);

        if (appointment) {
            appointment.status = 'Cancelled by Admin';
            showCustomAlert('Success', `Appointment ${appIdToCancel} has been cancelled by Admin.`);
            renderAdminAppointmentsTable(); // Re-render to update the list
            renderAdminOverview(); // Update stats
            renderAdminCharts(); // Update charts
            // Re-render relevant sections on other dashboards if they are active
            showDashboardContent('patient', 'myAppointments'); // Force update patient view
            showDashboardContent('doctor', 'appointments'); // Force update doctor view
        } else {
            showCustomAlert('Error', `Appointment with ID ${appIdToCancel} not found.`);
        }
        cancelAppointmentIdInput.value = '';
    }

    // --- General Pagination Function ---

    /**
     * Renders pagination controls for a given container.
     * @param {HTMLElement} container - The DOM element to render pagination buttons into.
     * @param {number} totalPages - Total number of pages.
     * @param {number} currentPage - The current active page.
     * @param {function} onPageChange - Callback function when a page button is clicked.
     */
    function renderPagination(container, totalPages, currentPage, onPageChange) {
        container.innerHTML = '';
        if (totalPages <= 1) {
            return; // No pagination needed for 1 or fewer pages
        }

        // Previous button
        const prevButton = document.createElement('button');
        prevButton.className = `px-3 py-1 rounded-md ${currentPage === 1 ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-blue-500 text-white hover:bg-blue-600'}`;
        prevButton.innerText = 'Previous';
        prevButton.disabled = currentPage === 1;
        prevButton.onclick = () => onPageChange(currentPage - 1);
        container.appendChild(prevButton);

        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement('button');
            pageButton.className = `px-3 py-1 rounded-md ${currentPage === i ? 'bg-blue-700 text-white' : 'bg-blue-500 text-white hover:bg-blue-600'}`;
            pageButton.innerText = i;
            pageButton.onclick = () => onPageChange(i);
            container.appendChild(pageButton);
        }

        // Next button
        const nextButton = document.createElement('button');
        nextButton.className = `px-3 py-1 rounded-md ${currentPage === totalPages ? 'bg-gray-200 text-gray-500 cursor-not-allowed' : 'bg-blue-500 text-white hover:bg-blue-600'}`;
        nextButton.innerText = 'Next';
        nextButton.disabled = currentPage === totalPages;
        nextButton.onclick = () => onPageChange(currentPage + 1);
        container.appendChild(nextButton);
    }

    // --- Initial Dashboard Setup after Login ---
    // This function will be called by the login script after successful authentication.
    // It assumes `isLoggedIn`, `loggedInUserType`, `loggedInUsername` are set globally.
    function initializeDashboard() {
        if (isLoggedIn) {
            // Hide the login page and show the dashboard
            document.getElementById('loginPageContainer').style.display = 'none';
            mainDashboardContainer.style.display = 'flex'; // Use flex for sidebar layout

            // Setup sidebar navigation based on user role
            setupDashboardSidebar(loggedInUserType);

            // Show the default overview section for the logged-in user
            showDashboardContent(loggedInUserType, 'overview');
        }
    }

    // Call initializeDashboard when the DOM is fully loaded.
    // This will check if a user is already "logged in" (e.g., if the previous script
    // has set the global login state) and display the dashboard accordingly.
    document.addEventListener('DOMContentLoaded', initializeDashboard);

</script>


<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>



<?php
// This line includes your footer file, which typically contains
// the closing HTML tags (like </body>, </html>),
// and any footer content or global scripts.
include('footer.php');
?>
