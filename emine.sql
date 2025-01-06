-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2025 at 08:15 AM
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
-- Database: `emine`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `position` enum('admin','super_admin','','') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`, `email`, `status`, `position`, `created_at`, `updated_at`) VALUES
(2, 'admin2', 'adminpass2', 'admin2@example.com', 'active', 'admin', '2025-01-04 02:26:39', '2025-01-04 02:26:39'),
(3, 'Olanre', '$2y$10$soAl0XcqhR9mG/XqVQwpa.b80sYS9OZmT6TayYu2jq2uI/Y4QeL6i', 'shobowalelanre111@gmail.com', 'active', 'admin', '2025-01-04 08:52:27', '2025-01-04 08:53:53');

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `ad_id` int(11) NOT NULL,
  `ad_name` varchar(255) NOT NULL,
  `ad_text` text NOT NULL,
  `ad_url` varchar(255) NOT NULL,
  `status` enum('active','paused','ended') NOT NULL DEFAULT 'active',
  `max_attempt` int(11) DEFAULT NULL,
  `clicks` int(11) DEFAULT 0,
  `cost_per_click` decimal(10,2) DEFAULT 0.00,
  `start_date` varchar(50) NOT NULL,
  `end_date` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`ad_id`, `ad_name`, `ad_text`, `ad_url`, `status`, `max_attempt`, `clicks`, `cost_per_click`, `start_date`, `end_date`, `created_at`) VALUES
(1, 'Ad 1', 'Description of Ad 1', 'Http://ad1.com', 'active', 1000, 150, 0.50, '2025-01-04 15:10:02', '', '2025-01-04 03:26:39'),
(2, 'Ad 2', 'Description of Ad 2', 'http://ad2.com', 'paused', 2000, 300, 0.75, '2025-01-04 15:10:02', '', '2025-01-04 03:26:39'),
(8, 'Welcome Bonus', 'Welcome to E-mine', 'https://shobowalelanre.com.ng', 'active', 2000, 0, 100.00, '2025-01-04', '2025-02-04', '2025-01-04 16:27:39');

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `campaign_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `campaign_name` varchar(255) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` enum('active','paused','ended') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`campaign_id`, `user_id`, `campaign_name`, `budget`, `start_date`, `end_date`, `status`) VALUES
(1, 1, 'Campaign 1', 500.00, '2025-01-01 00:00:00', '2025-01-31 23:59:59', 'active'),
(2, 2, 'Campaign 2', 1000.00, '2025-02-01 00:00:00', '2025-02-28 23:59:59', 'paused');

-- --------------------------------------------------------

--
-- Table structure for table `clicks`
--

CREATE TABLE `clicks` (
  `click_id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `click_time` datetime DEFAULT current_timestamp(),
  `ip_address` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clicks`
--

INSERT INTO `clicks` (`click_id`, `ad_id`, `user_id`, `click_time`, `ip_address`) VALUES
(1, 1, 1, '2025-01-04 03:26:39', '192.168.1.1'),
(2, 2, 2, '2025-01-04 03:26:39', '192.168.1.2'),
(7, 1, 3, '2025-01-05 05:19:09', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `cusage` int(11) DEFAULT NULL,
  `coupon_usage` int(11) DEFAULT 0,
  `amount` int(11) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `title`, `code`, `cusage`, `coupon_usage`, `amount`, `created_on`) VALUES
(2, 'Coupon1', 'BFGDGT', 3, 1, 1000, '2024-08-20 19:08:17');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_used`
--

CREATE TABLE `coupon_used` (
  `id` int(11) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `used_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupon_used`
--

INSERT INTO `coupon_used` (`id`, `coupon_code`, `user_id`, `used_on`) VALUES
(2, 'BFGDGT', 131, '2024-10-07 23:57:50');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `deposit_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `deposit_date` datetime DEFAULT current_timestamp(),
  `payment_method` varchar(50) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `status` enum('pending','completed','failed') NOT NULL DEFAULT 'pending',
  `reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`deposit_id`, `user_id`, `amount`, `deposit_date`, `payment_method`, `transaction_id`, `status`, `reason`) VALUES
(1, 1, 200.00, '2025-01-04 03:26:39', 'credit_card', 'TXN001', 'completed', NULL),
(2, 2, 100.00, '2025-01-04 03:26:39', 'paypal', 'TXN002', 'completed', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `user_subscription_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` datetime DEFAULT current_timestamp(),
  `payment_method` varchar(50) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `status` enum('pending','completed','failed') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `user_subscription_id`, `amount`, `payment_date`, `payment_method`, `transaction_id`, `status`) VALUES
(1, 1, 50.00, '2025-01-04 03:26:39', 'credit_card', 'TXN003', 'completed'),
(2, 2, 100.00, '2025-01-04 03:26:39', 'paypal', 'TXN004', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` int(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `referred_by` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount_earned` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `subscription_id` int(11) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_months` int(11) NOT NULL,
  `daily_income` int(11) NOT NULL,
  `total_income` int(11) NOT NULL,
  `purchase_limit` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`subscription_id`, `plan_name`, `price`, `duration_months`, `daily_income`, `total_income`, `purchase_limit`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Basic Plan', 50.00, 1, 0, 0, 0, 'active', '2025-01-04 03:26:39', '2025-01-04 03:26:39'),
(2, 'Premium Plan', 100.00, 1, 0, 0, 0, 'active', '2025-01-04 03:26:39', '2025-01-04 03:26:39'),
(3, 'Maimum Plan', 3000.00, 2, 0, 0, 0, 'active', '2025-01-04 17:24:49', '2025-01-04 17:24:49');

-- --------------------------------------------------------

--
-- Table structure for table `support`
--

CREATE TABLE `support` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` int(11) NOT NULL,
  `reply` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `support`
--

INSERT INTO `support` (`id`, `user_id`, `subject`, `message`, `status`, `reply`, `created_on`, `updated_on`) VALUES
(1, 1, 'Testing', 'Testing', 2, '', '0000-00-00 00:00:00', '2024-10-10'),
(2, 1, 'qyefhjef', 'djhdsj', 2, '', '0000-00-00 00:00:00', '1723421316'),
(3, 1, 'Errord', 'dggdgd', 2, 'I think we are done testing', '2024-09-28 20:05:50', '2024-10-10'),
(4, 1, 'Errord', 'dggdgd', 2, 'This is all testing', '2024-09-28 20:07:10', '2024-10-10'),
(5, 1, 'Error', 'Texting', 3, '', '2024-09-28 20:07:40', '2024-10-10'),
(6, 1, 'hggheede', 'ytee', 2, '', '2024-09-28 20:08:46', '2024-10-10'),
(7, 1, 'Testd', 'hddd', 2, '', '2024-09-28 20:09:21', '2024-10-10');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_id` varchar(25) NOT NULL,
  `description` varchar(120) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `transaction_type` varchar(50) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `transaction_id`, `description`, `amount`, `status`, `transaction_type`, `created_on`) VALUES
(250, 3, '340ef631', 'Task completed', 1, 'success', '0', '2025-01-05 04:11:28'),
(251, 3, '5a516853', 'Task completed', 1, 'success', '0', '2025-01-05 04:19:09'),
(252, 1, 'f8047353', 'Withdrawal', 5000, 'success', 'withdraw', '2025-01-05 16:18:27'),
(253, 12, '4d1d1661', 'Welcome Bonus', 200, 'success', 'income', '2025-01-06 05:32:29'),
(254, 13, 'b6c3d098', 'Welcome Bonus', 200, 'success', 'income', '2025-01-06 05:39:14'),
(255, 14, '8c5fe896', 'Welcome Bonus', 200, 'success', 'income', '2025-01-06 05:40:03'),
(256, 15, '85016266', 'Welcome Bonus', 200, 'success', 'income', '2025-01-06 05:41:11'),
(257, 16, '749bf970', 'Welcome Bonus', 200, 'success', 'income', '2025-01-06 05:41:34'),
(258, 17, '9a984968', 'Welcome Bonus', 200, 'success', 'income', '2025-01-06 05:41:46'),
(259, 18, '1f884464', 'Welcome Bonus', 200, 'success', 'income', '2025-01-06 05:42:26'),
(260, 19, 'fbad0359', 'Welcome Bonus', 200, 'success', 'income', '2025-01-06 05:42:59'),
(261, 20, 'faa2d800', 'Welcome Bonus', 200, 'success', 'income', '2025-01-06 05:45:02'),
(262, 21, '9a6f1841', 'Welcome Bonus', 200, 'success', 'income', '2025-01-06 05:50:55'),
(263, 22, '66b4f570', 'Welcome Bonus', 200, 'success', 'income', '2025-01-06 05:51:08'),
(264, 23, 'a62ef850', 'Welcome Bonus', 200, 'success', 'income', '2025-01-06 05:51:27'),
(265, 24, '8b2d3130', 'Welcome Bonus', 200, 'success', 'income', '2025-01-06 05:51:30'),
(266, 25, '1a68b749', 'Welcome Bonus', 200, 'success', 'income', '2025-01-06 05:54:05'),
(267, 25, '273f9737', 'Daily Login', 50, 'success', 'login', '2025-01-06 06:27:07'),
(268, 25, '0b539408', 'Daily Login', 50, 'success', 'login', '2025-01-06 06:27:10'),
(269, 25, '5282c283', 'Daily Login', 50, 'success', 'login', '2025-01-06 06:27:10'),
(270, 25, 'a7ae3895', 'Daily Login', 50, 'success', 'login', '2025-01-06 06:27:10'),
(271, 25, 'fb121764', 'Daily Login', 50, 'success', 'login', '2025-01-06 06:27:11'),
(272, 25, '58bd8097', 'Daily Login', 50, 'success', 'login', '2025-01-06 06:27:11'),
(273, 25, '587ca622', 'Daily Login', 50, 'success', 'login', '2025-01-06 06:27:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `income_balance` decimal(10,2) DEFAULT 0.00,
  `deposit_balance` decimal(11,0) NOT NULL DEFAULT 0,
  `all_time_earnings` float NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `referral_code` varchar(100) NOT NULL,
  `referred_by` int(11) DEFAULT NULL,
  `verification` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `subscription_status` int(11) DEFAULT 0,
  `ads_history` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `income_balance`, `deposit_balance`, `all_time_earnings`, `status`, `referral_code`, `referred_by`, `verification`, `created_at`, `updated_at`, `subscription_status`, `ads_history`) VALUES
(25, 'Olanre', '$2y$10$0uGAThSkICrqlv2ocxZS6e8dlslW3qqTS7ibqUKljj3lMp5aPo0R2', 'shobowalelanre111@gmail.com', 350.00, 200, 550, 'active', 'Olanre499', NULL, 0, '2025-01-06 06:54:05', '2025-01-06 07:27:51', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_subscriptions`
--

CREATE TABLE `user_subscriptions` (
  `user_subscription_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `start_date` datetime DEFAULT current_timestamp(),
  `end_date` datetime NOT NULL,
  `status` enum('active','expired','cancelled') NOT NULL DEFAULT 'active',
  `payment_status` varchar(50) NOT NULL DEFAULT 'paid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_subscriptions`
--

INSERT INTO `user_subscriptions` (`user_subscription_id`, `user_id`, `subscription_id`, `start_date`, `end_date`, `status`, `payment_status`) VALUES
(1, 1, 1, '2025-01-04 03:26:39', '2026-01-04 03:26:39', 'active', 'paid'),
(2, 2, 2, '2025-01-04 03:26:39', '2026-01-04 03:26:39', 'active', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(10) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` int(11) DEFAULT 0,
  `bank_name` varchar(150) NOT NULL,
  `account_name` varchar(150) NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_on` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `withdrawals`
--

INSERT INTO `withdrawals` (`id`, `transaction_id`, `user_id`, `amount`, `status`, `bank_name`, `account_name`, `account_number`, `created_on`, `updated_on`) VALUES
(3, '256fftst2', 131, 25000, 0, '', '', '', '2024-10-07 09:13:52', '8th of October, 2024 by 2:46am'),
(4, '65G2H6yw', 131, 1500, 0, '', '', '', '2024-10-07 09:13:52', '8th of October, 2024 by 2:48am'),
(5, '65G2H6yw', 131, 2000, 0, '', '', '', '2024-10-10 09:13:52', '8th of October, 2024 by 2:48am'),
(6, '65G2H6yw', 131, 2000, 0, '', '', '', '2024-10-09 09:13:52', '8th of October, 2024 by 2:48am'),
(7, '65G2H6y6', 131, 1000, 0, '', '', '', '2024-10-09 09:13:52', '8th of October, 2024 by 2:48am'),
(8, '65G2t6yw', 131, 7000, 0, '', '', '', '2024-10-08 09:13:52', '8th of October, 2024 by 2:48am'),
(9, '65G2t6yw', 131, 4500, 0, '', '', '', '2024-10-06 09:13:52', '8th of October, 2024 by 2:48am'),
(10, '65G2t6yw', 131, 12000, 0, '', '', '', '2024-10-11 09:13:52', '8th of October, 2024 by 2:48am'),
(11, 'TRX1736093', 1, 5000, 0, 'GT Bank', 'Shobowale Olanrewaju', '0621574026', '2025-01-05 16:11:56', NULL),
(12, 'TRX1736093', 1, 5000, 0, 'GT Bank', 'Shobowale Olanrewaju', '0621574026', '2025-01-05 16:15:36', NULL),
(13, 'TRX1736093', 1, 5000, 0, 'GT Bank', 'Shobowale Olanrewaju', '0621574026', '2025-01-05 16:18:27', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `clicks`
--
ALTER TABLE `clicks`
  ADD PRIMARY KEY (`click_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_used`
--
ALTER TABLE `coupon_used`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`subscription_id`);

--
-- Indexes for table `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `clicks`
--
ALTER TABLE `clicks`
  MODIFY `click_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coupon_used`
--
ALTER TABLE `coupon_used`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `subscription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `support`
--
ALTER TABLE `support`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
