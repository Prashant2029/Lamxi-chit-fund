-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2025 at 04:54 PM
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
-- Database: `banking`
--

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `assist` enum('support','billing','technical','other') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`id`, `account_id`, `name`, `email`, `message`, `assist`) VALUES
(2, 74377855, 'John Doe', 'john@gmail.com', 'I cannot transfer more than 100000.\r\n', 'billing');

-- --------------------------------------------------------

--
-- Table structure for table `loandetails`
--

CREATE TABLE `loandetails` (
  `Loan_ID` int(11) NOT NULL,
  `Account_ID` int(11) DEFAULT NULL,
  `Name` varchar(100) NOT NULL,
  `No_of_Dependents` int(11) DEFAULT NULL,
  `Education` enum('Not Graduate','Graduate') NOT NULL,
  `Self_Employed` enum('Yes','No') NOT NULL,
  `Income_Annum` decimal(15,2) DEFAULT NULL,
  `Loan_Amount` decimal(15,2) DEFAULT NULL,
  `Loan_Term` int(11) DEFAULT NULL,
  `Cibil_Score` int(11) DEFAULT NULL,
  `Residential_Assets_Value` decimal(15,2) DEFAULT NULL,
  `Commercial_Assets_Value` decimal(15,2) DEFAULT NULL,
  `Luxury_Assets_Value` decimal(15,2) DEFAULT NULL,
  `Bank_Asset_Value` decimal(15,2) DEFAULT NULL,
  `Loan_Status` varchar(50) DEFAULT NULL,
  `loan_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loandetails`
--

INSERT INTO `loandetails` (`Loan_ID`, `Account_ID`, `Name`, `No_of_Dependents`, `Education`, `Self_Employed`, `Income_Annum`, `Loan_Amount`, `Loan_Term`, `Cibil_Score`, `Residential_Assets_Value`, `Commercial_Assets_Value`, `Luxury_Assets_Value`, `Bank_Asset_Value`, `Loan_Status`, `loan_date`) VALUES
(5, 74377855, 'John Doe', 5, 'Graduate', 'Yes', 45000.00, 50000.00, 24, 567, 567000.00, 567999.00, 345888.00, 5678000.00, 'Approved', '2025-02-16'),
(6, 25570321, 'Prashant Dhoju', 4, 'Graduate', 'Yes', 4506.00, 45999.00, 24, 350, 56006.00, 56766.00, 98066.00, 10906.00, 'Denied', '2025-02-16');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `sender_account_id` int(11) DEFAULT NULL,
  `recipient_account_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `remarks` text DEFAULT NULL,
  `transaction_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `sender_account_id`, `recipient_account_id`, `amount`, `remarks`, `transaction_date`) VALUES
(1, 25570321, 74377855, 5000.00, 'Enjoy', '2025-02-16'),
(2, 25570321, 74377855, 5000.00, 'Enjoy', '2025-02-16'),
(3, 74377855, 25570321, 2500.00, 'Enjoy', '2025-02-16');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `account_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` int(10) NOT NULL,
  `balance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `account_id`, `name`, `email`, `password`, `address`, `phone`, `balance`) VALUES
(9, 25570321, 'Prashant', 'pralash@gmail.com', '$2y$10$bgGKi9SKKVTug7Pt0t0pqOOpJon4ANpny8IezOPTXDoVbrWZt597i', 'Bhaktapur', 987654532, 7500.00),
(10, 74377855, 'John Doe', 'john@gmail.com', '$2y$10$rLnk1SQBvhsUTLDzFSUZf.O9Ks.bW/sGowSMty84NM07kW9NeRYUa', 'Nepal', 987654342, 2500.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_account_id` (`account_id`);

--
-- Indexes for table `loandetails`
--
ALTER TABLE `loandetails`
  ADD PRIMARY KEY (`Loan_ID`),
  ADD KEY `Account_ID` (`Account_ID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `sender_account_id` (`sender_account_id`),
  ADD KEY `recipient_account_id` (`recipient_account_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `loandetails`
--
ALTER TABLE `loandetails`
  MODIFY `Loan_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contactus`
--
ALTER TABLE `contactus`
  ADD CONSTRAINT `fk_account_id` FOREIGN KEY (`account_id`) REFERENCES `user_info` (`account_id`);

--
-- Constraints for table `loandetails`
--
ALTER TABLE `loandetails`
  ADD CONSTRAINT `loandetails_ibfk_1` FOREIGN KEY (`Account_ID`) REFERENCES `user_info` (`account_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`sender_account_id`) REFERENCES `user_info` (`account_id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`recipient_account_id`) REFERENCES `user_info` (`account_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
