-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2025 at 06:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meditronix_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments:`
--

CREATE TABLE `appointments:` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `doctor_id` int(11) NOT NULL,
  `doctor's_name` varchar(255) DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('scheduled','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `appointments:`
--

INSERT INTO `appointments:` (`id`, `patient_id`, `patient_name`, `doctor_id`, `doctor's_name`, `service_id`, `appointment_date`, `appointment_time`, `status`, `created_at`) VALUES
(1, 1, 'anchal', 1332, 'tanvi', 1, '2025-07-09', '10:13:00', 'scheduled', '2025-07-09 12:00:06'),
(2, 2, 'riya', 1221, 'rohan', 2, '2025-07-10', '17:10:48', '', '2025-07-09 12:06:26'),
(5, 278383, 'raj kuamr', 74884, 'pinky', 5, '2025-07-01', '23:30:00', 'completed', '2025-07-15 12:30:20'),
(6, 74848, 'aswin', 74884, 'prince', 8484, '2025-07-23', '00:30:00', 'completed', '2025-07-15 12:30:49');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `patient's_name` varchar(255) DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `booked_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `patient's_name`, `service_id`, `service_name`, `description`, `fee`, `booked_at`) VALUES
(1, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-12 15:47:11'),
(2, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-12 15:51:21'),
(3, NULL, 2, 'Dental Cleaning', 'Professional cleaning to remove plaque and tartar, followed by a fluoride treatment and oral hygiene advice.', 100.00, '2025-07-12 15:51:26'),
(4, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-12 15:52:04'),
(5, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-12 15:53:23'),
(6, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-12 15:54:46'),
(7, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-12 15:59:20'),
(8, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-12 16:00:19'),
(9, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-12 16:01:27'),
(10, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-12 16:06:48'),
(11, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-12 16:07:57'),
(12, NULL, 2, 'Dental Cleaning', 'Professional cleaning to remove plaque and tartar, followed by a fluoride treatment and oral hygiene advice.', 100.00, '2025-07-12 16:08:11'),
(13, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-12 17:05:32'),
(14, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 03:59:10'),
(15, NULL, 2, 'Dental Cleaning', 'Professional cleaning to remove plaque and tartar, followed by a fluoride treatment and oral hygiene advice.', 100.00, '2025-07-13 04:03:51'),
(16, NULL, 2, 'Dental Cleaning', 'Professional cleaning to remove plaque and tartar, followed by a fluoride treatment and oral hygiene advice.', 100.00, '2025-07-13 04:04:25'),
(17, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:08:02'),
(18, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:10:37'),
(19, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:11:37'),
(20, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:11:44'),
(21, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:14:31'),
(22, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:17:05'),
(23, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:17:09'),
(25, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:22:13'),
(26, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:22:18'),
(27, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:26:12'),
(28, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:26:28'),
(29, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:26:43'),
(30, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:27:00'),
(31, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:27:14'),
(32, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:28:08'),
(33, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:28:12'),
(34, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:34:46'),
(35, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:34:52'),
(36, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:38:57'),
(37, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 04:55:33'),
(38, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 06:50:34'),
(39, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 10:47:24'),
(40, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-13 10:47:31'),
(41, NULL, 1, 'General Check-up', 'Comprehensive health assessment including vital signs, basic blood tests, and a consultation with a general practitioner.', 700.02, '2025-07-14 04:59:50'),
(42, NULL, 2, 'Dental Cleaning', 'Professional cleaning to remove plaque and tartar, followed by a fluoride treatment and oral hygiene advice.', 100.00, '2025-07-17 07:06:22');

-- --------------------------------------------------------

--
-- Table structure for table `contact_queries:`
--

CREATE TABLE `contact_queries:` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('pending','resolved') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact_queries:`
--

INSERT INTO `contact_queries:` (`id`, `name`, `email`, `subject`, `message`, `status`, `created_at`) VALUES
(2, 'Amit Kumar', 'amit.kumar@example.com', 'Inquiry about service fees', 'I would like to know more about the pricing structure for dental cleaning services. Are there any discounts for new patients?', 'resolved', '2025-07-09 12:32:57'),
(3, 'Anjali Singh', 'anjali.singh@example.com', 'Appointment rescheduling request', 'I need to reschedule my appointment for a general check-up currently set for July 15th. Could you please let me know the available slots next week?', 'resolved', '2025-07-09 12:39:26'),
(4, 'Rohan kapri', 'rohankapri463@gmail.com', 'Regarding payement ', 'I need to reschedule my appointment for a general check-up currently set for July 15th. Could you please let me know the available slots next week?', 'resolved', '2025-07-03 09:47:00'),
(5, 'Riya kapri', 'rohankapri463@gmail.com', 'regarding booking appointment ', 'I need to reschedule my appointment for a general check-up currently set for July 15th. Could you please let me know the available slots next week?', 'resolved', '2025-07-03 09:47:00'),
(6, 'zoho', 'zoho@gmail.com', 'Related to issues coming', 'I would like to know more about the pricing structure for dental cleaning services. Are there any discounts for new patients?', 'resolved', '2025-07-15 10:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `doctor_name` varchar(255) DEFAULT NULL,
  `specialization` varchar(100) NOT NULL,
  `experience` int(11) NOT NULL,
  `availability` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `doctor_name`, `specialization`, `experience`, `availability`, `status`, `created_at`) VALUES
(2, 122184, 'rohan kapri', 'Pediatrics', 20, 'Tue, Thu, Sat, 10 AM - 6 PM', 'active', '2025-07-09 11:54:36'),
(3, 277387, 'andrew', 'Oncology', 7, 'Tue, Thu, Sat, 10 AM - 6 PM', 'active', '2025-07-12 08:53:32'),
(6, 13321, 'Tanvi ', 'Dermatology', 4, 'Tue, Thu, Sat, 10 AM - 6 PM', 'inactive', '2025-07-13 07:48:46'),
(7, 1739, 'Michael ', 'neurology ', 10, 'Saturday ', 'active', '2025-07-14 10:29:26'),
(8, 6737, 'Anupama ', 'gynecologist', 10, 'Friday ', 'active', '2025-07-14 12:28:25'),
(9, 88888, 'Namita ', 'surgeon ', 5, 'Friday', 'active', '2025-07-15 14:01:53');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `patients' _name` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `rating` int(5) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `patient_id`, `patients' _name`, `message`, `rating`, `status`, `created_at`) VALUES
(1, 1, 'andrew', 'The online booking system was very user-friendly, and the staff were incredibly polite. Excellent service overall!', 5, 'active', '2025-07-09 13:02:10'),
(2, 2, 'elon musk', 'I found the waiting time a bit long, but the doctor was very thorough and helpful once I was seen.', 4, 'active', '2025-07-09 13:05:37'),
(3, 2, 'amit kumar', 'its nice service', 5, 'active', '2025-07-13 00:06:42'),
(4, 2445, 'laura zam', 'The online booking system was very user-friendly, and the staff were incredibly polite. Excellent service overall!', 5, 'active', '2025-07-14 16:02:05'),
(5, 35662, 'Jackson ', 'I found the waiting time a bit long, but the doctor was very thorough and helpful once I was seen.', 5, 'active', '2025-07-15 10:11:15');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `status`, `created_at`) VALUES
(1, 'New Advancements in Telemedicine advancement', 'Recent breakthroughs in telemedicine technology are making healthcare more accessible than ever. Patients can now consult with doctors remotely, receive diagnoses, and even get prescriptions online, reducing the need for in-person visits.', 'active', '2025-07-09 13:27:15'),
(2, 'Understanding Seasonal Allergies Victims', 'As seasons change, many people experience seasonal allergies. This article discusses common allergens, symptoms, and effective management strategies, including tips for minimizing exposure and treatment options.', 'active', '2025-07-09 13:29:07'),
(3, 'cancer treatment', 'In 2025, cancer research has entered a new era of precision and hope. Precision oncology now tailors treatments to each patient’s unique genetic mutations. Liquid biopsy technology allows early detection through blood tests, greatly improving survival chances.\r\n\r\nImmunotherapy, including CAR-T cell therapy and cancer vaccines, is transforming treatment for previously incurable cancers. AI is helping doctors diagnose more accurately and choose the best therapies faster.\r\n\r\n', 'active', '2025-07-14 17:19:11'),
(4, 'brain tumor', 'A brain tumor is an abnormal growth of cells within the brain that can be either benign (non-cancerous) or malignant (cancerous). These tumors can affect brain function, depending on their location, size, and rate of growth.\r\n\r\nIn 2025, advancements in MRI imaging, AI diagnostics, and precision surgery have greatly improved the detection and treatment of brain tumors. Minimally invasive surgeries and targeted therapies (which attack tumor cells without harming healthy brain tissue) are becoming more common.\r\n\r\nImmunotherapy and personalized medicine are also providing new hope, especially for aggressive forms like glioblastoma. Doctors now often use genetic profiling to design patient-specific treatments.', 'active', '2025-07-14 17:19:56');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `patient_names` varchar(255) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `emergency_contact` varchar(15) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `user_id`, `patient_names`, `gender`, `dob`, `blood_group`, `emergency_contact`, `status`, `created_at`) VALUES
(2, 2, 'priya kumari ', 'male', '2025-07-01', 'O+', '989737962', 'active', '2025-07-13 08:50:09'),
(4, 1, 'Rohan kapri', 'male', '2025-07-02', 'A+', '9893993993', 'active', '2025-07-13 05:26:36');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `doctor_name` varchar(255) DEFAULT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient's_name` varchar(255) DEFAULT NULL,
  `patient_id` int(11) NOT NULL,
  `notes` text NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `appointment_id`, `doctor_name`, `doctor_id`, `patient's_name`, `patient_id`, `notes`, `status`, `created_at`) VALUES
(1, 1, 'suzen ', 1332, 'lelia hamza', 1, 'Medication: Amoxicillin 500mg. Dosage: 1 tablet, 3 times a day for 7 days after meals. Notes: Complete the full course of antibiotics.', 'active', '2025-07-09 13:14:59'),
(2, 2, 'Angel carla', 1221, 'lana suzen', 2, 'Medication: Ibuprofen 400mg. Dosage: 1 tablet every 6 hours as needed for pain. Notes: Do not exceed 3 tablets in 24 hours. Take with food.', 'active', '2025-07-09 13:22:32'),
(3, 13749, 'Andrew ', 3, 'Mamta ', 2848, 'take 500G of medicine daily', 'active', '2025-07-12 14:11:20');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `doctor's_name` varchar(255) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `doctor's_name`, `name`, `description`, `fee`, `status`, `created_at`) VALUES
(2, 'riya kapri', 'Dental Cleaning', 'To keep your teeth protected from germs ', 100.00, 'active', '2025-07-09 11:36:43'),
(6, 'rohit kumar', 'General Check-up', 'To clean and take care of your health', 700.00, 'active', '2025-07-12 06:31:33'),
(7, 'sonia kumari', 'heart surgery', 'to cure heart patients ', 700.00, 'active', '2025-07-14 06:21:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','doctor','patient') NOT NULL DEFAULT 'patient',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `contact`, `address`, `role`, `status`, `create_at`) VALUES
(1, 'Rohan kapri', 'rachel2@gmail.com', 'passwordhack', '98765432100', '120, california states of western union valley', 'patient', '', '2025-07-12 13:38:26'),
(2, 'Priya Kumari', 'priya28@gmail.com', 'iuhdebje', '9988776655', '1873, town palace royal palace valentine glory', 'patient', 'active', '2025-07-10 18:30:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments:`
--
ALTER TABLE `appointments:`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_queries:`
--
ALTER TABLE `contact_queries:`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_patient` (`user_id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_appointment_id` (`appointment_id`),
  ADD KEY `idx_doctor_id` (`doctor_id`),
  ADD KEY `idx_patient_id` (`patient_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments:`
--
ALTER TABLE `appointments:`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `contact_queries:`
--
ALTER TABLE `contact_queries:`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
