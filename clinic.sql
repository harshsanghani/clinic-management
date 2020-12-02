-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2019 at 07:20 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `angel_admin`
--

CREATE TABLE `angel_admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `visiblePassword` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `isActive` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0 = Inactive, 1 = Active',
  `createdDate` datetime NOT NULL,
  `modifyDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activation_code` varchar(255) DEFAULT NULL,
  `verifyOTP` varchar(255) NOT NULL,
  `loginAttempt` int(11) NOT NULL,
  `blockDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_admin`
--

INSERT INTO `angel_admin` (`id`, `username`, `password`, `visiblePassword`, `email`, `isActive`, `createdDate`, `modifyDate`, `activation_code`, `verifyOTP`, `loginAttempt`, `blockDate`) VALUES
(1, 'harsh', 'e10adc3949ba59abbe56e057f20f883e', '123456', 'harsh.angelinfotech@gmail.com', '1', '2016-07-31 14:58:44', '0000-00-00 00:00:00', '', '', 0, '0000-00-00'),
(3, 'kishan', 'e10adc3949ba59abbe56e057f20f883e', '123456', 'kishan.angelinfotech@gmail.com', '1', '0000-00-00 00:00:00', '2017-08-02 16:47:35', '', '95P28k', 4, '2018-10-05'),
(4, 'kishan01', 'e10adc3949ba59abbe56e057f20f883e', '123456', 'kishan01.angelinfotech@gmail.com', '1', '0000-00-00 00:00:00', '2018-02-26 11:50:58', '', '', 0, '0000-00-00'),
(5, 'kishanB', 'e10adc3949ba59abbe56e057f20f883e', '123456', 'kishan02.angelinfotech@gmail.com', '1', '0000-00-00 00:00:00', '2018-02-27 09:47:09', NULL, '', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `angel_appointment`
--

CREATE TABLE `angel_appointment` (
  `id` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = New, 2 = Follow up, 3 = Emergency',
  `patient_id` int(11) DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `sms_notification` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0 - notification not sent ,1 - notification  sent',
  `email_notification` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0 - notification not sent ,1 - notification  sent',
  `attend` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0 = Not attended, 1 = Attended',
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_appointment`
--

INSERT INTO `angel_appointment` (`id`, `type`, `patient_id`, `appointment_date`, `appointment_time`, `sms_notification`, `email_notification`, `attend`, `created_date`, `modify_date`) VALUES
(4, 0, 5, '2019-01-22', '13:30:00', '1', '1', '1', '2019-01-22 00:13:46', '2019-01-22 04:50:26'),
(5, 0, 6, '2019-01-22', '12:30:00', '1', '1', '1', '2019-01-22 05:18:22', '2019-01-22 09:49:00'),
(8, 0, 5, '2019-01-31', '10:00:00', '1', '1', '0', '2019-01-28 03:22:54', '2019-01-29 12:09:42'),
(9, 0, 5, '2019-01-30', '14:00:00', '1', '1', '0', '2019-01-27 20:37:56', '2019-01-29 12:09:39'),
(14, 0, 6, '2019-02-11', '13:00:00', '0', '0', '0', '2019-02-10 20:02:02', '2019-02-11 12:32:02'),
(16, 1, 6, '2019-03-25', '10:00:00', '0', '0', '0', '2019-03-25 03:00:19', '2019-03-25 07:30:19'),
(18, 2, 5, '2019-03-25', '14:30:00', '0', '0', '0', '2019-03-25 03:00:54', '2019-03-25 07:30:54'),
(26, 3, 6, '2019-04-03', '10:00:00', '0', '0', '0', '2019-04-17 06:10:18', '2019-04-17 09:40:18'),
(36, 3, 5, '2019-04-09', '12:00:00', '0', '0', '1', '2019-04-09 06:16:29', '2019-04-09 09:47:28'),
(37, 3, 6, '2019-04-10', '07:00:00', '0', '0', '1', '2019-04-10 01:41:04', '2019-04-10 05:11:06'),
(38, 3, 6, '2019-04-17', '17:30:00', '0', '0', '0', '2019-04-16 19:33:25', '2019-04-17 11:03:25'),
(41, 1, 19, '2019-04-19', '10:00:00', '0', '0', '0', '2019-04-17 06:52:22', '2019-04-17 10:22:22'),
(63, 1, 19, '2019-04-17', '10:00:00', '0', '1', '0', '2019-04-16 23:36:39', '2019-04-17 15:06:39'),
(64, 1, 19, '2019-05-18', '13:00:00', '1', '1', '0', '2019-05-18 02:23:37', '2019-05-18 05:53:37'),
(65, 1, 18, '2019-05-19', '12:00:00', '1', '1', '0', '2019-05-18 02:25:08', '2019-05-18 05:55:08'),
(66, 1, 16, '2019-05-20', '18:30:00', '1', '1', '0', '2019-05-18 02:24:11', '2019-05-18 05:54:11'),
(72, 1, 19, '2019-05-25', '13:30:00', '0', '1', '1', '2019-05-25 03:39:28', '2019-05-25 07:37:49'),
(73, 1, 19, '2019-05-25', '15:00:00', '0', '1', '0', '2019-05-25 03:41:12', '2019-05-25 07:11:12'),
(74, 1, 19, '2019-05-25', '15:30:00', '0', '1', '0', '2019-05-25 03:44:15', '2019-05-25 07:14:15'),
(75, 3, 19, '2019-06-17', '16:00:00', '0', '0', '1', '2019-06-17 10:33:33', '2019-06-17 14:03:53'),
(76, 2, 19, '2019-06-29', '12:00:00', '1', '1', '0', '2019-06-28 03:45:17', '2019-06-28 07:15:17');

-- --------------------------------------------------------

--
-- Table structure for table `angel_attachment`
--

CREATE TABLE `angel_attachment` (
  `id` int(10) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_attachment`
--

INSERT INTO `angel_attachment` (`id`, `path`, `type`, `created_date`) VALUES
(1, '/uploads/patient/c4ca4238a0b923820dcc509a6f75849b/5.jpg', 'image', '2019-01-11 09:51:47'),
(2, '/uploads/patient/c4ca4238a0b923820dcc509a6f75849b/images4.jpg', 'image', '2019-01-11 09:59:35'),
(8, '/uploads/patient/c4ca4238a0b923820dcc509a6f75849b/Penguins.jpg', 'image', '2019-01-11 13:00:04'),
(10, '/uploads/patient/e4da3b7fbbce2345d7772b0674a318d5/Lighthouse.jpg', 'image', '2019-01-11 13:03:19'),
(11, '/uploads/patient/1679091c5a880faf6fb5e6087eb1b2dc/Hydrangeas.jpg', 'image', '2019-01-15 04:43:55'),
(20, '/uploads/patient/e4da3b7fbbce2345d7772b0674a318d5/report/Tulips.jpg', 'image', '2019-01-24 07:37:34'),
(22, '/uploads/patient/e4da3b7fbbce2345d7772b0674a318d5/report/SampleVideo.MP4', 'video', '2019-01-25 12:11:47'),
(26, '/uploads/patient/eccbc87e4b5ce2fe28308fd9f2a7baf3/report/Koala.jpg', 'image', '2019-02-20 12:41:10'),
(28, '/uploads/patient/c9f0f895fb98ab9159f51fd0297e236d/report/Upwork_Freelancer_Hiring_Process.pdf', 'doc', '2019-03-25 06:59:30'),
(29, 'E:\\xampp\\htdocs\\clinic\\portal/uploads/testimonial/1554096480_Jellyfish.jpg', 'image', '2019-04-01 05:28:00'),
(30, 'E:\\xampp\\htdocs\\clinic\\portal/uploads/testimonial/10/1554097046_Hydrangeas.jpg', 'image', '2019-04-01 05:37:26'),
(34, 'E:\\xampp\\htdocs\\clinic\\portal/uploads/testimonial/aab3238922bcc25a6f606eb525ffdc56/1554097401_Hydrangeas.jpg', 'image', '2019-04-01 05:43:21'),
(35, 'E:\\xampp\\htdocs\\clinic\\portal/uploads/testimonial/9bf31c7ff062936a96d3c8bd1f8f2ff3/1554097427_Hydrangeas.jpg', 'image', '2019-04-01 05:43:47'),
(36, 'E:\\xampp\\htdocs\\clinic\\portal/uploads/testimonial/c74d97b01eae257e44aa9d5bade97baf/1554097479_Hydrangeas.jpg', 'image', '2019-04-01 05:44:39'),
(90, '/uploads/testimonial/before/f7177163c833dff4b38fc8d2872f1ec6/1554103489_Desert.jpg', 'image', '2019-04-01 07:24:49'),
(92, '/uploads/testimonial/after/6c8349cc7260ae62e3b1396831a8398f/1554103569_Koala.jpg', 'image', '2019-04-01 07:26:09'),
(96, '/uploads/testimonial/before/6c8349cc7260ae62e3b1396831a8398f/1554103803_Jellyfish.jpg', 'image', '2019-04-01 07:30:03'),
(105, '/uploads/testimonial/video/f457c545a9ded88f18ecee47145a72c0/1554105270_Wildlife2.wmv', 'video', '2019-04-01 07:54:30'),
(133, '/uploads/testimonial/before/7f39f8317fbdb1988ef4c628eba02591/1554117800_Hydrangeas.jpg', 'image', '2019-04-01 11:23:20'),
(134, '/uploads/testimonial/after/7f39f8317fbdb1988ef4c628eba02591/1554117801_Jellyfish.jpg', 'image', '2019-04-01 11:23:21'),
(138, '/uploads/testimonial/video/7f39f8317fbdb1988ef4c628eba02591/1554118170_553.mp4', 'video', '2019-04-01 11:29:30'),
(139, '/uploads/patient/1f0e3dad99908345f7439f8ffabdffc4/Tulips.jpg', 'image', '2019-04-17 09:27:25');

-- --------------------------------------------------------

--
-- Table structure for table `angel_blood`
--

CREATE TABLE `angel_blood` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_blood`
--

INSERT INTO `angel_blood` (`id`, `name`) VALUES
(3, 'O+'),
(4, 'A+'),
(5, 'B+'),
(7, 'O4'),
(8, 'A-'),
(9, 'B-'),
(10, 'AB-');

-- --------------------------------------------------------

--
-- Table structure for table `angel_certificate`
--

CREATE TABLE `angel_certificate` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `patient_id` int(11) NOT NULL,
  `report_type` int(11) NOT NULL,
  `certificate_detail` longtext NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_certificate`
--

INSERT INTO `angel_certificate` (`id`, `date`, `patient_id`, `report_type`, `certificate_detail`, `created_date`, `modify_date`) VALUES
(4, '2019-01-24', 6, 2, '{"bill_no":"422411","dignosis":"abc Dignosis","consultation_charges":"1214.25","medicine_charges":"4100","medicine_charges_days":"14","treatment_start_date":"2019-01-24","treatment_end_date":"2019-01-31"}', '2019-01-30 02:54:17', '2019-01-31 11:57:53'),
(11, '2019-01-31', 5, 4, '{"carry_person_title":"mr","carry_person_name":"rakesh","carry_person_relation":"friend"}', '2019-01-31 08:54:52', '2019-01-31 12:33:35'),
(22, '2019-03-26', 5, 2, '{"bill_no":"CL-01","dignosis":"ANCJHDKSLDK","consultation_charges":"90","medicine_charges":"60","medicine_charges_days":"8","treatment_start_date":"2019-01-26","treatment_end_date":"2019-01-30","comment":"extra comment for patient bill 2"}', '2019-01-31 12:40:51', '2019-03-26 07:35:34'),
(23, '2019-03-26', 5, 9, '{"heading":"This is demo report","message":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.","comment":"new extra comment"}', '2019-01-31 12:41:13', '2019-03-26 07:49:55'),
(48, '2019-04-12', 5, 2, '{"bill_no":"458","dignosis":"sdad","consultation_charges":"","medicine_charges":"205","medicine_charges_days":"2","treatment_start_date":"10-02-2019","treatment_end_date":"12-02-2019","comment":"dsds"}', '2019-04-12 08:18:18', '2019-04-12 06:18:18'),
(49, '2019-04-14', 5, 1, '{"prescription":[{"medicine":"Betax","potency":"testing 2","dosage":"abc","repetition":"Every monday","no_days":"8"}],"comment":""}', '2019-04-17 11:41:35', '2019-04-17 09:41:35'),
(50, '2019-05-25', 19, 1, '{"prescription":[{"medicine":"Betax","potency":"testing 2","dosage":"abc","repetition":"Every monday","no_days":"5"}],"comment":"just demo"}', '2019-05-25 09:17:39', '2019-05-25 07:17:39'),
(51, '2019-05-25', 19, 2, '{"bill_no":"78945","dignosis":"demo","consultation_charges":"500","medicine_charges":"100","medicine_charges_days":"5","treatment_start_date":"25-05-2019","treatment_end_date":"30-05-2019","comment":"demo"}', '2019-05-25 09:19:20', '2019-05-25 07:19:20'),
(52, '2019-05-25', 19, 3, '{"receipt_no":"1234","dignosis":"demo","consultation_charges":"500","medicine_charges":"100","medicine_charges_days":"5","treatment_start_date":"25-05-2019","treatment_end_date":"32-05-2019","relation":"Brother","relative_name":"prem","comment":"Demo"}', '2019-05-25 09:21:09', '2019-05-25 07:21:09'),
(53, '2019-05-25', 19, 7, '{"dignosis":"Demo","problem":"Demo","medicine":"Betax","report_back_date":"25-05-2019","physician_name":"Abc","suggested_investigation":"Demo","comment":"Demo"}', '2019-05-25 09:24:32', '2019-05-25 07:24:32'),
(54, '2019-05-25', 19, 8, '{"title":"mr","physician_name":"Abc","diagnosis":"Demo","medical_history":"Demo","comment":"Demo"}', '2019-05-25 09:25:27', '2019-05-25 07:25:27'),
(55, '2019-05-25', 19, 10, '{"dignosis":"dremo","medical_history":"Demo","lab_name":"Abc","investigation_type":"cG9ydGFsMQ%3D%3D","investigation":["cG9ydGFsMQ%3D%3D","cG9ydGFsNQ%3D%3D","cG9ydGFsOQ%3D%3D"],"comment":"Demo"}', '2019-05-25 09:26:37', '2019-05-25 07:26:37'),
(56, '2019-05-25', 19, 4, '{"carry_person_title":"mr","carry_person_name":"prem","carry_person_relation":"Brother","comment":"Demo"}', '2019-05-25 09:31:49', '2019-05-25 07:31:49'),
(57, '2019-05-25', 19, 5, '{"dignosis":"Demo","from_date":"25-05-2019","to_date":"30-05-2019","fit_resume_date":"30-05-2019","comment":"Demo"}', '2019-05-25 09:33:10', '2019-05-25 07:33:10'),
(58, '2019-05-25', 19, 6, '{"dignosis":"Demo","treatment_start_date":"25-05-2019","treatment_end_date":"30-05-2019","comment":"Demo"}', '2019-05-25 09:34:22', '2019-05-25 07:34:22'),
(59, '2019-05-25', 19, 9, '{"heading":"Demo","message":"Demo","comment":"Demo"}', '2019-05-25 09:36:22', '2019-05-25 07:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `angel_contact`
--

CREATE TABLE `angel_contact` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_contact`
--

INSERT INTO `angel_contact` (`id`, `name`, `mobile`, `email`, `message`, `created_date`) VALUES
(1, 'harsh', '7894567890', 'sasd@gmail.com', 'asda asd asda da sd', '2019-02-18 13:09:34'),
(2, 'harsh', '7894567890', 'sasd@gmail.com', 'asda asd asda da sd', '2019-02-18 13:09:54'),
(3, 'harsh', '7894567890', 'sasd@gmail.com', 'asda asd asda da sd', '2019-02-18 13:11:41'),
(4, 'harsh sanghani', '1234567890', 'abc@gmail.com', 'hello testing email', '2019-02-18 13:16:46'),
(5, 'sandip', '9925350552', 'sandip@gmail.com', 'contact form inquiry', '2019-02-18 13:17:27'),
(6, 'ad', '1234567890', '', 'ad', '2019-02-18 13:23:03'),
(7, 'harsh', '9876543210', 'sandip.angelinfotech@gmail.com', 'asdad', '2019-03-27 13:11:54');

-- --------------------------------------------------------

--
-- Table structure for table `angel_diet`
--

CREATE TABLE `angel_diet` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_diet`
--

INSERT INTO `angel_diet` (`id`, `name`) VALUES
(2, 'Daily noon');

-- --------------------------------------------------------

--
-- Table structure for table `angel_dosage`
--

CREATE TABLE `angel_dosage` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_dosage`
--

INSERT INTO `angel_dosage` (`id`, `name`) VALUES
(1, 'abc'),
(2, 'xyz');

-- --------------------------------------------------------

--
-- Table structure for table `angel_extra_notes`
--

CREATE TABLE `angel_extra_notes` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `note` text,
  `created_date` datetime NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_extra_notes`
--

INSERT INTO `angel_extra_notes` (`id`, `patient_id`, `note`, `created_date`, `modify_date`) VALUES
(15, 5, 'just test', '2019-01-25 13:01:20', '2019-01-25 12:01:20'),
(34, 6, 'sasa  a sasa', '2019-02-18 08:54:56', '2019-02-18 07:54:56');

-- --------------------------------------------------------

--
-- Table structure for table `angel_investigation`
--

CREATE TABLE `angel_investigation` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_investigation`
--

INSERT INTO `angel_investigation` (`id`, `type`, `name`) VALUES
(1, 1, 'Chest (PA View)'),
(2, 1, 'Chest (Lordotic View)'),
(3, 1, 'Chest (Lateral View)'),
(4, 1, 'Chest (Oblique View)'),
(5, 1, 'Plain Abdomen - AP View'),
(6, 1, 'K.U.B'),
(7, 1, 'Hand'),
(8, 1, 'Foot'),
(9, 1, 'Shoulder'),
(10, 1, 'Hip'),
(11, 1, 'Elbow'),
(12, 1, 'Wrist'),
(13, 1, 'Knee'),
(14, 1, 'Ankle'),
(15, 1, 'Cervical Spine'),
(16, 1, 'Dorsal spine'),
(17, 1, 'Lumbar Spine'),
(18, 1, 'Lambo-Sacral Spine'),
(19, 1, 'Skull'),
(20, 1, 'Barium Swallow'),
(21, 1, 'Barium Meal'),
(22, 1, 'Barium F.T'),
(23, 2, 'C.B.C'),
(24, 2, 'E.S.R'),
(25, 2, 'Haemoglobin'),
(26, 2, 'Urine Routine'),
(27, 2, 'Stool Routine'),
(28, 2, 'Mantoux Test'),
(29, 2, 'B.T / C.T'),
(30, 2, 'Platelet Count'),
(31, 2, 'Prothrombin time'),
(32, 2, 'P.T.T'),
(33, 2, 'Smear - Malarial Parasite'),
(34, 2, 'P. Falciparum Antigen'),
(35, 3, 'Blood Group'),
(36, 3, 'Direct Coombs Test'),
(37, 3, 'Indirect Coombs Test'),
(38, 3, 'V.D.R.L'),
(39, 3, 'Widal Test'),
(40, 3, 'Rh Antibody Test'),
(41, 3, 'Australia Antigen'),
(42, 3, 'R.A Test'),
(43, 3, 'ASO Titre'),
(44, 3, 'C - Reactive Protein'),
(45, 3, 'G6PD'),
(46, 3, 'Pregnancy Test ELISA'),
(47, 3, 'HIV (AIDS)');

-- --------------------------------------------------------

--
-- Table structure for table `angel_investigation_type`
--

CREATE TABLE `angel_investigation_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_investigation_type`
--

INSERT INTO `angel_investigation_type` (`id`, `name`) VALUES
(1, 'X-Ray'),
(2, 'Pathological Investigations'),
(3, 'Serological Tests'),
(4, 'BioChemical Test'),
(5, 'MicroBiology'),
(6, 'Body Fluid Examination'),
(7, 'RITA Test'),
(8, 'Histopathology');

-- --------------------------------------------------------

--
-- Table structure for table `angel_invoice`
--

CREATE TABLE `angel_invoice` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_invoice`
--

INSERT INTO `angel_invoice` (`id`, `patient_id`, `appointment_id`, `created_date`, `modify_date`) VALUES
(1, 5, 4, '2019-01-22 06:48:10', '2019-01-22 05:48:10'),
(2, 19, 38, '2019-04-17 11:47:52', '2019-04-17 09:47:52');

-- --------------------------------------------------------

--
-- Table structure for table `angel_marital_status`
--

CREATE TABLE `angel_marital_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_marital_status`
--

INSERT INTO `angel_marital_status` (`id`, `name`) VALUES
(1, 'single'),
(2, 'married');

-- --------------------------------------------------------

--
-- Table structure for table `angel_medicine`
--

CREATE TABLE `angel_medicine` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_medicine`
--

INSERT INTO `angel_medicine` (`id`, `name`) VALUES
(1, 'Betax'),
(2, 'Action 500'),
(3, 'Combiframe');

-- --------------------------------------------------------

--
-- Table structure for table `angel_occupation`
--

CREATE TABLE `angel_occupation` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_occupation`
--

INSERT INTO `angel_occupation` (`id`, `name`) VALUES
(4, 'Bussiness'),
(5, 'Goverment Job');

-- --------------------------------------------------------

--
-- Table structure for table `angel_organisation`
--

CREATE TABLE `angel_organisation` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_organisation`
--

INSERT INTO `angel_organisation` (`id`, `name`) VALUES
(2, 'Non pofit');

-- --------------------------------------------------------

--
-- Table structure for table `angel_patient`
--

CREATE TABLE `angel_patient` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `alternate_phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `birthdate` date NOT NULL,
  `age` varchar(255) DEFAULT NULL,
  `blood_group` int(11) DEFAULT NULL,
  `religion` int(11) NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `refereace` varchar(255) DEFAULT NULL,
  `image` int(12) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `maritial_status` varchar(255) DEFAULT NULL,
  `diet` text,
  `organization` varchar(255) DEFAULT NULL,
  `prognosis` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_patient`
--

INSERT INTO `angel_patient` (`id`, `title`, `firstname`, `middlename`, `lastname`, `phone`, `alternate_phone`, `email`, `birthdate`, `age`, `blood_group`, `religion`, `gender`, `refereace`, `image`, `occupation`, `maritial_status`, `diet`, `organization`, `prognosis`, `created_date`, `modify_date`) VALUES
(5, 'dr', 'Kishan', 'N', 'Chavda', '7894562356', '', 'kishan.angelinfotech@gmail.com', '1992-07-28', '26', 5, 1, 'male', 'Sandip Patel', 10, '', '', '', '', 0, '2019-01-11 02:01:03', '2019-04-13 06:16:48'),
(6, 'dr', 'Sandip', 'A', 'Patel', '8523697415', '8523697416', 'sandip.angelinfotech@gmail.com', '1987-06-24', '31', 0, 2, 'male', 'Harsh Sanghani', 11, '', '', '', '2', 0, '2019-01-15 05:01:43', '2019-04-17 08:06:56'),
(16, 'dr', 'Harsh', 'R', 'Sanghani', '9898977970', '', 'iamsanghani@gmail.com', '1970-01-01', '49', 0, 0, 'male', '', NULL, NULL, NULL, NULL, NULL, 0, '2019-04-03 09:04:11', '2019-04-03 07:11:28'),
(18, 'mrs', 'pooja', 'harsh', 'sanghani', '9898977970', '7016257574', 'iamsanghani@gmail.com', '1991-10-07', '27', 0, 1, 'female', 'viral desai', NULL, '', '', '', '', 0, '2019-04-03 09:04:21', '2019-05-18 06:30:35'),
(19, 'dr', 'Jay ', 'B', 'Pandya', '7894561238', '7894561238', 'pandya.angelinfotech@gmail.com', '1995-03-27', '24', 0, 1, 'male', 'Kishan Chavda', 139, '', '1', '2', '2', 3, '2019-04-17 11:04:27', '2019-04-17 12:19:02'),
(20, 'master', 'Ravi', 'm', 'Makvana', '123456789', '987645312', 'ravi@gmail.com', '0000-00-00', NULL, 2, 0, NULL, 'abc', NULL, NULL, NULL, NULL, NULL, 0, '0000-00-00 00:00:00', '2019-06-01 10:22:44'),
(21, 'mrs', 'Dhaval', 'Q', 'Gondaliya', '145414545', '225456', 'dhaval@mail.com', '0000-00-00', NULL, 2, 0, NULL, 'kishan', NULL, NULL, NULL, NULL, NULL, 0, '0000-00-00 00:00:00', '2019-06-01 10:24:04'),
(22, 'mrs', 'raju', 'n', 'bhai', '1211', '1321', 'asdsad', '0000-00-00', NULL, 1, 0, NULL, 'asdasds', 0, NULL, NULL, NULL, NULL, 0, '0000-00-00 00:00:00', '2019-06-01 11:13:54');

-- --------------------------------------------------------

--
-- Table structure for table `angel_patient_address`
--

CREATE TABLE `angel_patient_address` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `permanent_address` varchar(255) DEFAULT NULL,
  `permanent_city` varchar(255) DEFAULT NULL,
  `permanent_state` varchar(255) DEFAULT NULL,
  `permanent_country` varchar(255) DEFAULT NULL,
  `permanent_zipcode` varchar(255) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_patient_address`
--

INSERT INTO `angel_patient_address` (`id`, `patient_id`, `address`, `city`, `state`, `country`, `zipcode`, `permanent_address`, `permanent_city`, `permanent_state`, `permanent_country`, `permanent_zipcode`, `created_date`, `modify_date`) VALUES
(4, 6, 'Raiya Road ', 'Rajkot', 'Gujrat', 'India', '360007', 'Raiya Road ', 'Rajkot', 'Gujrat', 'India', '360007', '2019-01-11 01:01:54', '2019-01-15 12:56:47'),
(7, 5, 'Yagnik Road', 'Rajkot', 'Gujrat', 'India', '360008', 'Yagnik Road', 'Rajkot', 'Gujrat', 'India', '360008', '2019-01-11 02:01:04', '2019-01-11 13:04:25'),
(8, 19, 'Rajkot', 'Rajkot', 'Gujarat', 'India', '360007', 'Rajkot', 'Rajkot', 'Gujarat', 'India', '360007', '2019-04-17 02:04:18', '2019-04-17 12:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `angel_patient_notes`
--

CREATE TABLE `angel_patient_notes` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `notes` text,
  `diet` text,
  `diagnosis` text,
  `consulting_amount` double(9,2) NOT NULL,
  `medicine_amount` double(9,2) NOT NULL,
  `amount` double(9,2) DEFAULT NULL,
  `received_amount` double(9,2) NOT NULL COMMENT 'INR',
  `payment_mode` varchar(255) NOT NULL,
  `medicines` text,
  `created_date` datetime NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_patient_notes`
--

INSERT INTO `angel_patient_notes` (`id`, `patient_id`, `appointment_id`, `notes`, `diet`, `diagnosis`, `consulting_amount`, `medicine_amount`, `amount`, `received_amount`, `payment_mode`, `medicines`, `created_date`, `modify_date`) VALUES
(5, 5, 4, '<p><span style="color: rgb(34, 34, 34); font-family: Consolas, " lucida="" console",="" "courier="" new",="" monospace;="" font-size:="" 12px;="" white-space:="" pre-wrap;"="">Aenean lacinia bibendum nulla sed consectetur. Aenean lacinia bibendum nulla sed consectetur. Curabitur blandit tempus porttitor. Sed posuere consectetur est at lobortis. Sed posuere consectetur est at lobortis.\r\n                                </span><br></p>', 'demo', 'demo', 100.00, 400.00, 500.00, 0.00, '0', 'demo', '2019-02-01 14:42:44', '2019-02-01 13:42:44'),
(6, 19, 38, 'Demo', 'Demo', 'Demo', 200.00, 100.00, 300.00, 500.00, 'Cash', 'Demo', '2019-04-17 11:47:52', '2019-04-17 09:47:52');

-- --------------------------------------------------------

--
-- Table structure for table `angel_payment_mode`
--

CREATE TABLE `angel_payment_mode` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_payment_mode`
--

INSERT INTO `angel_payment_mode` (`id`, `name`) VALUES
(1, 'Cash'),
(2, 'NEFT'),
(3, 'BHIM App');

-- --------------------------------------------------------

--
-- Table structure for table `angel_potency`
--

CREATE TABLE `angel_potency` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_potency`
--

INSERT INTO `angel_potency` (`id`, `name`) VALUES
(1, 'testing 2'),
(2, 'new testing');

-- --------------------------------------------------------

--
-- Table structure for table `angel_prescription`
--

CREATE TABLE `angel_prescription` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `patient_id` int(11) NOT NULL,
  `prescription_detail` longtext NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `angel_prognosis`
--

CREATE TABLE `angel_prognosis` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_prognosis`
--

INSERT INTO `angel_prognosis` (`id`, `name`) VALUES
(3, 'Once Prognosis');

-- --------------------------------------------------------

--
-- Table structure for table `angel_relative`
--

CREATE TABLE `angel_relative` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_relative`
--

INSERT INTO `angel_relative` (`id`, `name`) VALUES
(1, 'Brother'),
(2, 'Aunty');

-- --------------------------------------------------------

--
-- Table structure for table `angel_religion`
--

CREATE TABLE `angel_religion` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_religion`
--

INSERT INTO `angel_religion` (`id`, `name`) VALUES
(1, 'Hinduism'),
(2, 'Islam'),
(3, 'Christianity'),
(7, 'Sikhism');

-- --------------------------------------------------------

--
-- Table structure for table `angel_repetition`
--

CREATE TABLE `angel_repetition` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_repetition`
--

INSERT INTO `angel_repetition` (`id`, `name`) VALUES
(1, 'Every monday'),
(2, 'Once in week');

-- --------------------------------------------------------

--
-- Table structure for table `angel_report`
--

CREATE TABLE `angel_report` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `report` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_report`
--

INSERT INTO `angel_report` (`id`, `patient_id`, `report`, `created_date`, `modify_date`) VALUES
(2, 5, 22, '2019-01-25 01:01:11', '2019-01-25 12:11:47');

-- --------------------------------------------------------

--
-- Table structure for table `angel_report_type`
--

CREATE TABLE `angel_report_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_report_type`
--

INSERT INTO `angel_report_type` (`id`, `name`) VALUES
(1, 'Prescription'),
(2, 'Patient Bill'),
(3, 'Receipt'),
(4, 'Abroad Certificate'),
(5, 'Fitness Certificate'),
(6, 'Sickness Certificate'),
(7, 'Patient Report'),
(8, 'Reference Latter'),
(9, 'Customized'),
(10, 'Request Investigation');

-- --------------------------------------------------------

--
-- Table structure for table `angel_testimonial`
--

CREATE TABLE `angel_testimonial` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text CHARACTER SET utf8mb4 NOT NULL,
  `avatar` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `before_image` int(11) NOT NULL,
  `after_image` int(11) NOT NULL,
  `video` int(11) NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angel_testimonial`
--

INSERT INTO `angel_testimonial` (`id`, `name`, `description`, `avatar`, `city`, `before_image`, `after_image`, `video`, `is_active`) VALUES
(1, 'Daivik K. Modh', 'ડૉ. દિપક સોની એક ઉત્તમ સ્ત્રીરોગવિજ્ઞાની છે. ખુબ નરમ બોલી, ઠંડી, ખૂબ ધીરજપૂર્વક સાંભળો. મારી પત્નીની પ્રથમ ગર્ભાવસ્થા તેની પારદર્શક સલાહ અને યોગ્ય માર્ગદર્શનને કારણે સફળ રહી છે. ક્લિનિક સ્ટાફમાં પર્યાવરણ પણ ખૂબ જ મૈત્રીપૂર્ણ છે. તમે ખૂબ જ આભાર માનતા હો અને બધા ક્લિનિક સ્ટાફ', '', 'Rajkot', 0, 0, 0, '0'),
(6, 'Piyush Shah', 'મને ઘણા ડોકટર એ સર્જરી નુ કેહવા છતા ડો. દિપક સોની એ હોમિઓપેથી ટ્રિટ્મેન્ટ થી મને એક્દમ સાજી કરી દીધી અને હવે હુ નોરમલ છુ. ખુબ જ આભાર.', '', 'Rajkot', 0, 0, 0, '0'),
(61, 'ravi', 'ds', '', 'una', 133, 134, 138, '0');

-- --------------------------------------------------------

--
-- Table structure for table `planogram_post`
--

CREATE TABLE `planogram_post` (
  `id` int(11) NOT NULL,
  `salesman_id` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `dist_type_id` int(11) NOT NULL,
  `planogram_id` int(11) NOT NULL,
  `before_img` varchar(255) NOT NULL,
  `after_img` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `planogram_post`
--

INSERT INTO `planogram_post` (`id`, `salesman_id`, `trip_id`, `customer_id`, `dist_type_id`, `planogram_id`, `before_img`, `after_img`, `description`, `created_date`) VALUES
(11, 1, 1, 5, 1, 6, 'planogram_1554715993.jpg', 'planogram_1554715993.jpg', 'dfhrjfr', '2019-04-08 09:33:14'),
(12, 1, 1, 5, 1, 6, 'planogram_1554717413.jpg', 'planogram_1554717413.jpg', 'dfhrjfr', '2019-04-08 09:56:53'),
(13, 1, 1, 5, 1, 6, 'planogram_1554723833.jpg', 'planogram_1554723833.jpg', 'dfhrjfr', '2019-04-08 11:43:53'),
(14, 1, 1, 5, 1, 6, 'planogram_1554728151.jpg', 'planogram_1554728151.jpg', 'dfhrjfr', '2019-04-08 12:55:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `angel_admin`
--
ALTER TABLE `angel_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_appointment`
--
ALTER TABLE `angel_appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_attachment`
--
ALTER TABLE `angel_attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_blood`
--
ALTER TABLE `angel_blood`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_certificate`
--
ALTER TABLE `angel_certificate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_contact`
--
ALTER TABLE `angel_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_diet`
--
ALTER TABLE `angel_diet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_dosage`
--
ALTER TABLE `angel_dosage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_extra_notes`
--
ALTER TABLE `angel_extra_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_investigation`
--
ALTER TABLE `angel_investigation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_investigation_type`
--
ALTER TABLE `angel_investigation_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_invoice`
--
ALTER TABLE `angel_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_marital_status`
--
ALTER TABLE `angel_marital_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_medicine`
--
ALTER TABLE `angel_medicine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_occupation`
--
ALTER TABLE `angel_occupation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_organisation`
--
ALTER TABLE `angel_organisation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_patient`
--
ALTER TABLE `angel_patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_patient_address`
--
ALTER TABLE `angel_patient_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_patient_notes`
--
ALTER TABLE `angel_patient_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_payment_mode`
--
ALTER TABLE `angel_payment_mode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_potency`
--
ALTER TABLE `angel_potency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_prescription`
--
ALTER TABLE `angel_prescription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_prognosis`
--
ALTER TABLE `angel_prognosis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_relative`
--
ALTER TABLE `angel_relative`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_religion`
--
ALTER TABLE `angel_religion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_repetition`
--
ALTER TABLE `angel_repetition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_report`
--
ALTER TABLE `angel_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_report_type`
--
ALTER TABLE `angel_report_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `angel_testimonial`
--
ALTER TABLE `angel_testimonial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `planogram_post`
--
ALTER TABLE `planogram_post`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `angel_admin`
--
ALTER TABLE `angel_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `angel_appointment`
--
ALTER TABLE `angel_appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `angel_attachment`
--
ALTER TABLE `angel_attachment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;
--
-- AUTO_INCREMENT for table `angel_blood`
--
ALTER TABLE `angel_blood`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `angel_certificate`
--
ALTER TABLE `angel_certificate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `angel_contact`
--
ALTER TABLE `angel_contact`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `angel_diet`
--
ALTER TABLE `angel_diet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `angel_dosage`
--
ALTER TABLE `angel_dosage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `angel_extra_notes`
--
ALTER TABLE `angel_extra_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `angel_investigation`
--
ALTER TABLE `angel_investigation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `angel_investigation_type`
--
ALTER TABLE `angel_investigation_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `angel_invoice`
--
ALTER TABLE `angel_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `angel_marital_status`
--
ALTER TABLE `angel_marital_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `angel_medicine`
--
ALTER TABLE `angel_medicine`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `angel_occupation`
--
ALTER TABLE `angel_occupation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `angel_organisation`
--
ALTER TABLE `angel_organisation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `angel_patient`
--
ALTER TABLE `angel_patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `angel_patient_address`
--
ALTER TABLE `angel_patient_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `angel_patient_notes`
--
ALTER TABLE `angel_patient_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `angel_payment_mode`
--
ALTER TABLE `angel_payment_mode`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `angel_potency`
--
ALTER TABLE `angel_potency`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `angel_prescription`
--
ALTER TABLE `angel_prescription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `angel_prognosis`
--
ALTER TABLE `angel_prognosis`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `angel_relative`
--
ALTER TABLE `angel_relative`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `angel_religion`
--
ALTER TABLE `angel_religion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `angel_repetition`
--
ALTER TABLE `angel_repetition`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `angel_report`
--
ALTER TABLE `angel_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `angel_report_type`
--
ALTER TABLE `angel_report_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `angel_testimonial`
--
ALTER TABLE `angel_testimonial`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `planogram_post`
--
ALTER TABLE `planogram_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
