-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2023 at 03:34 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `senior`
--

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `account` varchar(25) NOT NULL,
  `action` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL,
  `personStatus` enum('Active','Deceased') NOT NULL,
  `RBIID` text NOT NULL,
  `referenceCode` text NOT NULL,
  `lastName` varchar(35) NOT NULL,
  `firstName` varchar(35) NOT NULL,
  `middleName` varchar(35) NOT NULL,
  `extensionName` enum('','JR','SR.') NOT NULL,
  `region` varchar(35) NOT NULL,
  `province` varchar(35) NOT NULL,
  `city` varchar(35) NOT NULL,
  `barangay` enum('Aldiano Olaes','Poblacion 1','Poblacion 2','Poblacion 3','Poblacion 4','Poblacion 5','Benjamin Tirona','Bernardo Pulido','Epifanio Malia','Francisco De Castro','Francisco Reyes','Fiorello Calimag','Gavino Maderan','Gregoria De Jesus','Inocencio Salud','Jacinto Lumbreras','Kapitan Kua','Koronel Jose P. Elises','Macario Dacon','Marcelino Memije','Nicolasa Virata','Pantaleon Granados','Ramon Cruz Sr.','San Gabriel','San Jose','Severino De Las Alas','Tiniente Tiago') NOT NULL,
  `houseno` varchar(50) NOT NULL,
  `street` varchar(50) NOT NULL,
  `birthDate` date NOT NULL,
  `birthPlace` varchar(35) NOT NULL,
  `maritalStatus` enum('','Married','Divorce','Seperated','Widowed','Never Married') NOT NULL,
  `gender` enum('','Female','Male') NOT NULL,
  `contactNumber` text NOT NULL,
  `email` varchar(128) NOT NULL,
  `religion` varchar(35) NOT NULL,
  `ethnic` varchar(35) NOT NULL,
  `language` varchar(35) NOT NULL,
  `oscaID` varchar(35) NOT NULL,
  `sss` varchar(35) NOT NULL,
  `tin` varchar(35) NOT NULL,
  `philhealth` text NOT NULL,
  `orgID` varchar(35) NOT NULL,
  `govID` varchar(35) NOT NULL,
  `travel` varchar(50) NOT NULL,
  `serviceEmp` varchar(35) NOT NULL,
  `pension` varchar(35) NOT NULL,
  `spouseLastName` varchar(35) NOT NULL,
  `spouseFirstName` varchar(35) NOT NULL,
  `spouseMiddleName` varchar(35) NOT NULL,
  `spouseExtensionName` enum('','Jr.','Sr.') NOT NULL,
  `fatherLastName` varchar(35) NOT NULL,
  `fatherFirstName` varchar(35) NOT NULL,
  `fatherMiddleName` varchar(35) NOT NULL,
  `fatherExtensionName` enum('','Jr.','Sr.') NOT NULL,
  `motherLastName` varchar(35) NOT NULL,
  `motherFirstName` varchar(35) NOT NULL,
  `motherMiddleName` varchar(35) NOT NULL,
  `child1FullName` varchar(128) NOT NULL,
  `child1Occupation` varchar(35) NOT NULL,
  `child1Income` text NOT NULL,
  `child1Age` text NOT NULL,
  `child1Work` enum('','Working','Not Working') NOT NULL,
  `child2FullName` varchar(128) NOT NULL,
  `child2Occupation` varchar(128) NOT NULL,
  `child2Income` text NOT NULL,
  `child2Age` text NOT NULL,
  `child2Work` enum('','Working','Not Working') NOT NULL,
  `child3FullName` varchar(128) NOT NULL,
  `child3Occupation` varchar(128) NOT NULL,
  `child3Income` text NOT NULL,
  `child3Age` text NOT NULL,
  `child3Work` enum('','Working','Not Working') NOT NULL,
  `child4FullName` varchar(128) NOT NULL,
  `child4Occupation` varchar(128) NOT NULL,
  `child4Income` text NOT NULL,
  `child4Age` text NOT NULL,
  `child4Work` enum('','Working','Not Working') NOT NULL,
  `dependentFullName` varchar(128) NOT NULL,
  `dependentOccupation` varchar(128) NOT NULL,
  `dependentIncome` text NOT NULL,
  `dependentAge` text NOT NULL,
  `dependentWork` enum('','Working','Not Working') NOT NULL,
  `dependent2FullName` text NOT NULL,
  `dependent2Occupation` text NOT NULL,
  `dependent2Income` text NOT NULL,
  `dependent2Age` text NOT NULL,
  `dependent2Work` enum('','Working','Not Working') NOT NULL,
  `dependent3FullName` text NOT NULL,
  `dependent3Occupation` text NOT NULL,
  `dependent3Income` text NOT NULL,
  `dependent3Age` text NOT NULL,
  `dependent3Work` enum('','Working','Not Working') NOT NULL,
  `educationalAttainment` enum('','Elementary Graduate','High School Level','High School Graduate','College Level','College Graduate','Post Graduate','Vocational','Elementary Level','Not Attended School') NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `specializationOthers` varchar(30) NOT NULL,
  `shareSkill` varchar(128) NOT NULL,
  `shareSkill1` varchar(128) NOT NULL,
  `shareSkill2` varchar(128) NOT NULL,
  `communityService` varchar(255) NOT NULL,
  `communityServiceOthers` varchar(30) NOT NULL,
  `residingwith` varchar(255) NOT NULL,
  `residingWithOthers` varchar(30) NOT NULL,
  `houseHold` varchar(255) NOT NULL,
  `houseHoldOthers` varchar(30) NOT NULL,
  `sourceIncome` varchar(255) NOT NULL,
  `sourceIncomeOthers` varchar(30) NOT NULL,
  `assetsFirst` varchar(255) NOT NULL,
  `assetsFirstOthers` varchar(30) NOT NULL,
  `assetsSecond` varchar(255) NOT NULL,
  `assetsSecondOthers` varchar(30) NOT NULL,
  `monthlyIncome` varchar(255) NOT NULL,
  `incomeOthers` varchar(100) NOT NULL,
  `problems` varchar(255) NOT NULL,
  `problemsOthers` varchar(30) NOT NULL,
  `bloodType` enum('','A','B','AB','O','Don''t know') NOT NULL,
  `medicalConcern` varchar(255) NOT NULL,
  `medicalConcernOthers` varchar(30) NOT NULL,
  `physicalDisability` varchar(128) NOT NULL,
  `dentalConcern` varchar(255) NOT NULL,
  `dentalConcernOthers` varchar(30) NOT NULL,
  `optical` varchar(50) NOT NULL,
  `opticalOthers` varchar(30) NOT NULL,
  `hearing` varchar(255) NOT NULL,
  `hearingOthers` varchar(30) NOT NULL,
  `socialEmotional` varchar(255) NOT NULL,
  `socialEmotionalOthers` varchar(30) NOT NULL,
  `areaDifficulty` varchar(255) NOT NULL,
  `areaDifficultyOthers` varchar(30) NOT NULL,
  `medicines` varchar(255) NOT NULL,
  `scheduledMedical` varchar(255) NOT NULL,
  `scheduledMedical1` varchar(255) NOT NULL,
  `scheduledMedical1Others` varchar(30) NOT NULL,
  `updated_date` datetime DEFAULT current_timestamp(),
  `date_deceased` date NOT NULL,
  `deceasedCert` varchar(100) NOT NULL,
  `imageup` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `ID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `activeStatus` enum('Offline','Online') NOT NULL,
  `CodeV` varchar(255) NOT NULL,
  `verification` tinyint(1) NOT NULL DEFAULT 0,
  `role` enum('User','Admin','Super Admin','') NOT NULL,
  `status` enum('Active','Disabled') NOT NULL,
  `autoOut` enum('No','Yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`ID`, `Username`, `email`, `Password`, `activeStatus`, `CodeV`, `verification`, `role`, `status`, `autoOut`) VALUES
(73, 'ICT Admin', 'ictgma@gmail.com', '$2y$10$nGSaSzWo/txRb2h4aIAFRe65XeiOqzDRUB6faKlEDVeUV0i/TfpKi', 'Online', '56d1d22f2f74424ac7e682a08f3da457', 1, 'Super Admin', 'Active', 'No');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=665;

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3976;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
