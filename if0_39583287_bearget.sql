-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql306.infinityfree.com
-- Creato il: Ago 07, 2025 alle 19:29
-- Versione del server: 11.4.7-MariaDB
-- Versione PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_39583287_bearget`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `initial_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `accounts`
--

INSERT INTO `accounts` (`id`, `user_id`, `name`, `initial_balance`, `created_at`) VALUES
(1, 1, 'Conto Principale', '1000.00', '2025-07-29 02:30:08'),
(2, 1, 'Revolut', '0.00', '2025-07-29 02:50:38'),
(3, 6, 'Conto Principale', '0.00', '2025-07-29 16:17:03'),
(4, 7, 'Conto Principale', '1000.00', '2025-07-31 00:50:17'),
(5, 8, 'Conto Principale', '0.00', '2025-07-31 13:52:31'),
(6, 9, 'Conto Principale', '0.00', '2025-07-31 15:11:18'),
(7, 10, 'Conto Principale', '0.00', '2025-07-31 15:25:59'),
(8, 11, 'Conto Principale', '0.00', '2025-07-31 23:40:00'),
(9, 1, 'Prova', '111.00', '2025-08-02 23:16:18'),
(10, 1, 'newda', '2.00', '2025-08-03 04:04:09'),
(11, 1, 'yooooo', '60.00', '2025-08-04 03:34:30'),
(12, 1, 'sdfv', '36.00', '2025-08-04 03:34:55'),
(13, 12, 'Conto Principaleee', '100.00', '2025-08-04 17:09:40'),
(14, 13, 'Conto Principale', '0.00', '2025-08-04 17:11:27'),
(16, 12, 'revo', '0.00', '2025-08-04 23:09:49'),
(17, 14, 'Conto Principale', '0.00', '2025-08-05 03:35:19'),
(18, 15, 'Conto Principale', '0.00', '2025-08-07 22:01:32');

-- --------------------------------------------------------

--
-- Struttura della tabella `budgets`
--

CREATE TABLE `budgets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `budgets`
--

INSERT INTO `budgets` (`id`, `user_id`, `category_id`, `amount`, `start_date`, `created_at`) VALUES
(1, 1, 11, '40.00', NULL, '2025-07-29 04:04:36'),
(3, 6, 21, '70.00', NULL, '2025-07-29 19:47:32'),
(5, 1, 7, '50.00', NULL, '2025-08-03 03:24:59'),
(8, 1, 9, '878.00', NULL, '2025-08-04 14:21:47'),
(9, 12, 98, '33.00', NULL, '2025-08-04 18:37:41'),
(14, 12, 130, '500.00', NULL, '2025-08-05 03:33:17'),
(17, 1, 13, '50.00', NULL, '2025-08-05 20:00:38'),
(18, 1, 146, '450.00', NULL, '2025-08-05 20:05:32');

-- --------------------------------------------------------

--
-- Struttura della tabella `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'expense',
  `icon` varchar(10) DEFAULT NULL,
  `category_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `categories`
--

INSERT INTO `categories` (`id`, `user_id`, `name`, `type`, `icon`, `category_order`) VALUES
(1, 1, 'Stipendio', 'income', '💼', 16),
(2, 1, 'Altre Entratee', 'income', '💰', 17),
(3, 1, 'Spesa', 'expense', '🛒', 4),
(4, 1, 'Trasporti', 'expense', '⛽️', 7),
(5, 1, 'Casa', 'expense', '🏠', 5),
(6, 1, 'Bollette', 'expense', '🧾', 3),
(7, 1, 'Svago', 'expense', '🎉', 6),
(8, 1, 'Ristoranti', 'expense', '🍔', 9),
(9, 1, 'Salute', 'expense', '❤️‍🩹', 8),
(10, 1, 'Regali', 'expense', '🎁', 10),
(11, 1, 'Videogiochi', 'expense', '🎮', 11),
(12, 1, 'Risparmi', 'expense', '', 12),
(13, 1, 'Trasferimento', 'expense', '🔄', 13),
(15, 6, 'Stipendio', 'income', '💼', 12),
(16, 6, 'Altre Entrate', 'income', '💰', 13),
(17, 6, 'Spesa', 'expense', '🛒', 6),
(18, 6, 'Trasporti', 'expense', '⛽️', 5),
(19, 6, 'Casa', 'expense', '🏠', 3),
(20, 6, 'Bollette', 'expense', '🧾', 8),
(21, 6, 'Svago', 'expense', '🎉', 2),
(22, 6, 'Ristoranti', 'expense', '🍔', 4),
(23, 6, 'Salute', 'expense', '❤️‍🩹', 7),
(24, 6, 'Regali', 'expense', '🎁', 11),
(25, 6, 'Risparmi', 'expense', '💾', 9),
(26, 6, 'Fondi Comuni', 'expense', '👥', 10),
(27, 6, 'Trasferimento', 'expense', '🔄', 1),
(28, 7, 'Stipendio', 'income', '💼', 12),
(29, 7, 'Altre Entrate', 'income', '💰', 13),
(30, 7, 'Spesa', 'expense', '🛒', 1),
(31, 7, 'Trasporti', 'expense', '⛽️', 11),
(32, 7, 'Casa', 'expense', '🏠', 10),
(33, 7, 'Bollette', 'expense', '🧾', 9),
(34, 7, 'Svago', 'expense', '🎉', 8),
(35, 7, 'Ristoranti', 'expense', '🍔', 7),
(36, 7, 'Salute', 'expense', '❤️‍🩹', 5),
(37, 7, 'Regali', 'expense', '🎁', 4),
(38, 7, 'Risparmi', 'expense', '💾', 3),
(39, 7, 'Fondi Comuni', 'expense', '👥', 2),
(40, 7, 'Trasferimento', 'expense', '🔄', 6),
(41, 8, 'Stipendio', 'income', '💼', 0),
(42, 8, 'Altre Entrate', 'income', '💰', 0),
(43, 8, 'Spesa', 'expense', '🛒', 0),
(44, 8, 'Trasporti', 'expense', '⛽️', 0),
(45, 8, 'Casa', 'expense', '🏠', 0),
(46, 8, 'Bollette', 'expense', '🧾', 0),
(47, 8, 'Svago', 'expense', '🎉', 0),
(48, 8, 'Ristoranti', 'expense', '🍔', 0),
(49, 8, 'Salute', 'expense', '❤️‍🩹', 0),
(50, 8, 'Regali', 'expense', '🎁', 0),
(51, 8, 'Risparmi', 'expense', '💾', 0),
(52, 8, 'Fondi Comuni', 'expense', '👥', 0),
(53, 8, 'Trasferimento', 'expense', '🔄', 0),
(54, 9, 'Stipendio', 'income', '💼', 0),
(55, 9, 'Altre Entrate', 'income', '💰', 0),
(56, 9, 'Spesa', 'expense', '🛒', 0),
(57, 9, 'Trasporti', 'expense', '⛽️', 0),
(58, 9, 'Casa', 'expense', '🏠', 0),
(59, 9, 'Bollette', 'expense', '🧾', 0),
(60, 9, 'Svago', 'expense', '🎉', 0),
(61, 9, 'Ristoranti', 'expense', '🍔', 0),
(62, 9, 'Salute', 'expense', '❤️‍🩹', 0),
(63, 9, 'Regali', 'expense', '🎁', 0),
(64, 9, 'Risparmi', 'expense', '💾', 0),
(65, 9, 'Fondi Comuni', 'expense', '👥', 0),
(66, 9, 'Trasferimento', 'expense', '🔄', 0),
(67, 10, 'Stipendio', 'income', '💼', 0),
(68, 10, 'Altre Entrate', 'income', '💰', 0),
(69, 10, 'Spesa', 'expense', '🛒', 0),
(70, 10, 'Trasporti', 'expense', '⛽️', 0),
(71, 10, 'Casa', 'expense', '🏠', 0),
(72, 10, 'Bollette', 'expense', '🧾', 0),
(73, 10, 'Svago', 'expense', '🎉', 0),
(74, 10, 'Ristoranti', 'expense', '🍔', 0),
(75, 10, 'Salute', 'expense', '❤️‍🩹', 0),
(76, 10, 'Regali', 'expense', '🎁', 0),
(77, 10, 'Risparmi', 'expense', '💾', 0),
(78, 10, 'Fondi Comuni', 'expense', '👥', 0),
(79, 10, 'Trasferimento', 'expense', '🔄', 0),
(80, 11, 'Stipendio', 'income', '💼', 0),
(81, 11, 'Altre Entrate', 'income', '💰', 0),
(82, 11, 'Spesa', 'expense', '🛒', 0),
(83, 11, 'Trasporti', 'expense', '⛽️', 0),
(84, 11, 'Casa', 'expense', '🏠', 0),
(85, 11, 'Bollette', 'expense', '🧾', 0),
(86, 11, 'Svago', 'expense', '🎉', 0),
(87, 11, 'Ristoranti', 'expense', '🍔', 0),
(88, 11, 'Salute', 'expense', '❤️‍🩹', 0),
(89, 11, 'Regali', 'expense', '🎁', 0),
(90, 11, 'Risparmi', 'expense', '💾', 0),
(91, 11, 'Fondi Comuni', 'expense', '👥', 0),
(92, 11, 'Trasferimento', 'expense', '🔄', 0),
(93, 1, 'Future', 'income', '🎮', 18),
(94, 1, 'newda', 'expense', '', 14),
(95, 1, 'Fondi Comunii', 'expense', '', 15),
(96, 12, 'Stipendio', 'income', '💼', 12),
(97, 12, 'Altre Entrate', 'income', '💰', 13),
(98, 12, 'Spesa', 'expense', '🛒', 2),
(99, 12, 'Trasporti', 'expense', '⛽️', 10),
(100, 12, 'Casa', 'expense', '🏠', 9),
(101, 12, 'Bollette', 'expense', '🧾', 8),
(102, 12, 'Svago', 'expense', '🎉', 7),
(103, 12, 'Ristoranti', 'expense', '🍔', 6),
(104, 12, 'Salute', 'expense', '❤️‍🩹', 5),
(105, 12, 'Regali', 'expense', '🎁', 4),
(106, 12, 'Risparmi', 'expense', '💾', 3),
(107, 12, 'Fondi Comuniss', 'expense', '👥', 1),
(108, 12, 'Trasferimento', 'expense', '🔄', 11),
(109, 13, 'Stipendio', 'income', '💼', 0),
(110, 13, 'Altre Entrate', 'income', '💰', 0),
(111, 13, 'Spesa', 'expense', '🛒', 0),
(112, 13, 'Trasporti', 'expense', '⛽️', 0),
(113, 13, 'Casa', 'expense', '🏠', 0),
(114, 13, 'Bollette', 'expense', '🧾', 0),
(115, 13, 'Svago', 'expense', '🎉', 0),
(116, 13, 'Ristoranti', 'expense', '🍔', 0),
(117, 13, 'Salute', 'expense', '❤️‍🩹', 0),
(118, 13, 'Regali', 'expense', '🎁', 0),
(119, 13, 'Risparmi', 'expense', '💾', 0),
(120, 13, 'Fondi Comuni', 'expense', '👥', 0),
(121, 13, 'Trasferimento', 'expense', '🔄', 0),
(130, 12, 'Risparmio: PC', 'expense', 'piggy-bank', 0),
(131, 14, 'Stipendio', 'income', '💼', 0),
(132, 14, 'Altre Entrate', 'income', '💰', 0),
(133, 14, 'Spesa', 'expense', '🛒', 0),
(134, 14, 'Trasporti', 'expense', '⛽️', 0),
(135, 14, 'Casa', 'expense', '🏠', 0),
(136, 14, 'Bollette', 'expense', '🧾', 0),
(137, 14, 'Svago', 'expense', '🎉', 0),
(138, 14, 'Ristoranti', 'expense', '🍔', 0),
(139, 14, 'Salute', 'expense', '❤️‍🩹', 0),
(140, 14, 'Regali', 'expense', '🎁', 0),
(141, 14, 'Risparmi', 'expense', '💾', 0),
(142, 14, 'Fondi Comuni', 'expense', '👥', 0),
(143, 14, 'Trasferimento', 'expense', '🔄', 0),
(146, 1, 'Risparmio: Boh', 'expense', 'piggy-bank', 0),
(147, 15, 'Stipendio', 'income', '💼', 12),
(148, 15, 'Altre Entrate', 'income', '💰', 13),
(149, 15, 'Spesa', 'expense', '🛒', 1),
(150, 15, 'Trasporti', 'expense', '⛽️', 10),
(151, 15, 'Casa', 'expense', '🏠', 9),
(152, 15, 'Bollette', 'expense', '🧾', 8),
(153, 15, 'Svago', 'expense', '🎉', 7),
(154, 15, 'Ristoranti', 'expense', '🍔', 6),
(155, 15, 'Salute', 'expense', '❤️‍🩹', 4),
(156, 15, 'Regali', 'expense', '🎁', 5),
(157, 15, 'Risparmi', 'expense', '💾', 3),
(158, 15, 'Fondi Comuni', 'expense', '👥', 2),
(159, 15, 'Trasferimento', 'expense', '🔄', 11);

-- --------------------------------------------------------

--
-- Struttura della tabella `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `todolist_content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `title`, `content`, `todolist_content`, `created_at`, `updated_at`) VALUES
(1, 6, 'Prova della notakk', '[{\"task\":\"prova to do\",\"completed\":false}]', NULL, '2025-07-29 16:41:26', '2025-07-29 17:37:29'),
(2, 6, 'prova 2', 'asdasdasdasdxxxx', '[{\"task\":\"sdfsdf\",\"completed\":false}]', '2025-07-29 17:49:17', '2025-07-29 17:53:28'),
(3, 6, 'sadfdddd', 'cgdfc', '[{\"task\":\"aaaaaaaaaaaaaaaaaaaaa\",\"completed\":false}]', '2025-07-29 17:53:36', '2025-07-29 17:53:45'),
(4, 6, 'Nuova Notaaaa', 'aaaaaa', '[{\"task\":\"aaaaaaaaa\",\"completed\":true}]', '2025-07-29 17:56:46', '2025-07-29 17:57:05'),
(5, 6, 'sfdsdfsdfsf', 'asdasdsdfsdfsdf', '[{\"task\":\"ffffff\",\"completed\":false}]', '2025-07-29 18:02:35', '2025-07-29 18:03:40'),
(6, 1, 'Nuova Nota di prova', 'Gang', '[{\"task\":\"To do list gang\",\"completed\":true}]', '2025-08-03 12:37:37', '2025-08-03 12:38:10'),
(7, 1, 'Nuova Nota', '', '[]', '2025-08-03 12:41:17', '2025-08-03 12:41:17'),
(8, 1, 'Nuova Nota', '', '[]', '2025-08-04 03:04:17', '2025-08-04 03:04:17'),
(13, 12, 'Nuova Nota', 'asdasd', '[{\"task\":\"sss\",\"completed\":false}]', '2025-08-04 19:25:51', '2025-08-04 19:25:56'),
(14, 12, 'Nuova Notassss', 'asdasda', '[]', '2025-08-04 19:31:50', '2025-08-04 19:32:10');

-- --------------------------------------------------------

--
-- Struttura della tabella `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `related_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `message`, `related_id`, `is_read`, `created_at`) VALUES
(1, 5, 'fund_invite', 'dio ti ha invitato a partecipare al fondo \'Jesolo Night City Spesa\'.', 2, 1, '2025-07-29 16:07:00'),
(2, 1, 'fund_invite', 'cristian.salviato ti ha invitato a partecipare al fondo \'jesolo spesa\'.', 3, 1, '2025-07-31 01:02:50'),
(3, 1, 'budget_exceeded', 'Hai superato il budget per la categoria \'Svago\' questo mese!', 5, 0, '2025-08-03 03:25:23');

-- --------------------------------------------------------

--
-- Struttura della tabella `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `recurring_transactions`
--

CREATE TABLE `recurring_transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` varchar(10) NOT NULL,
  `category_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `frequency` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `next_due_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `recurring_transactions`
--

INSERT INTO `recurring_transactions` (`id`, `user_id`, `description`, `amount`, `type`, `category_id`, `account_id`, `frequency`, `start_date`, `next_due_date`, `created_at`) VALUES
(1, 1, 'Amazon Prime', '2.49', 'expense', 7, 1, 'monthly', '2025-08-01', '2025-09-01', '2025-07-29 04:56:23'),
(2, 1, 'Stipendio Bonifico', '700.00', 'income', 1, 1, 'monthly', '2025-08-16', '2025-08-16', '2025-07-29 04:57:21');

-- --------------------------------------------------------

--
-- Struttura della tabella `saving_goals`
--

CREATE TABLE `saving_goals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `target_amount` decimal(10,2) NOT NULL,
  `current_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `target_date` date DEFAULT NULL,
  `monthly_contribution` decimal(10,2) NOT NULL DEFAULT 0.00,
  `linked_category_id` int(11) DEFAULT NULL,
  `created_by_planner` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `saving_goals`
--

INSERT INTO `saving_goals` (`id`, `user_id`, `name`, `target_amount`, `current_amount`, `target_date`, `monthly_contribution`, `linked_category_id`, `created_by_planner`, `created_at`) VALUES
(8, 12, 'rrr', '33.00', '0.00', NULL, '0.00', NULL, 0, '2025-08-04 18:20:18'),
(10, 12, 'PC', '2000.00', '0.00', '2025-11-15', '0.00', NULL, 0, '2025-08-05 03:33:17'),
(13, 1, 'Risparmio generale', '200.00', '50.00', NULL, '0.00', NULL, 0, '2025-08-05 19:59:46'),
(14, 1, 'Boh', '900.00', '0.00', '2025-09-27', '450.00', 146, 1, '2025-08-05 20:05:32'),
(15, 1, 'iiiii', '70.00', '0.00', NULL, '0.00', NULL, 0, '2025-08-07 13:58:14');

-- --------------------------------------------------------

--
-- Struttura della tabella `shared_funds`
--

CREATE TABLE `shared_funds` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `target_amount` decimal(10,2) DEFAULT NULL,
  `creator_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `shared_funds`
--

INSERT INTO `shared_funds` (`id`, `name`, `description`, `target_amount`, `creator_id`, `created_at`) VALUES
(1, 'Jesolo Night City Spesa', NULL, '120.00', 1, '2025-07-29 15:26:23'),
(2, 'Jesolo Night City Spesa', NULL, '200.00', 4, '2025-07-29 15:52:12'),
(3, 'jesolo spesa', NULL, '500.00', 7, '2025-07-31 00:55:48'),
(4, 'ASD', NULL, '33.00', 1, '2025-08-04 15:01:25'),
(5, 'newda', NULL, '40.00', 1, '2025-08-04 16:51:03'),
(6, 'Risparmio generale4', NULL, '33.00', 1, '2025-08-04 16:51:35'),
(7, 'Risparmio generale', NULL, '555.00', 1, '2025-08-04 16:56:57'),
(8, 'yyyy', NULL, '55.00', 1, '2025-08-04 16:57:08'),
(9, 'sda', NULL, '333.00', 1, '2025-08-04 17:04:37'),
(10, 'ferwt', NULL, '4444.00', 1, '2025-08-04 17:04:51'),
(11, 'sad', NULL, '333.00', 1, '2025-08-04 17:06:54'),
(13, 'newdaaaasds', NULL, '10.00', 12, '2025-08-04 17:15:47');

-- --------------------------------------------------------

--
-- Struttura della tabella `shared_fund_contributions`
--

CREATE TABLE `shared_fund_contributions` (
  `id` int(11) NOT NULL,
  `fund_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `contribution_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `shared_fund_contributions`
--

INSERT INTO `shared_fund_contributions` (`id`, `fund_id`, `user_id`, `amount`, `contribution_date`, `created_at`) VALUES
(1, 1, 1, '20.00', '2025-07-29', '2025-07-29 15:26:59'),
(2, 1, 1, '50.00', '2025-07-29', '2025-07-30 00:10:06'),
(3, 3, 1, '140.00', '2025-07-30', '2025-07-31 01:03:36'),
(4, 3, 7, '320.00', '2025-07-30', '2025-07-31 01:03:51'),
(5, 1, 1, '33.00', '2025-08-04', '2025-08-04 17:05:42'),
(7, 13, 12, '2.00', '2025-08-04', '2025-08-04 17:28:49');

-- --------------------------------------------------------

--
-- Struttura della tabella `shared_fund_members`
--

CREATE TABLE `shared_fund_members` (
  `id` int(11) NOT NULL,
  `fund_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `shared_fund_members`
--

INSERT INTO `shared_fund_members` (`id`, `fund_id`, `user_id`, `joined_at`) VALUES
(1, 1, 1, '2025-07-29 15:26:23'),
(2, 2, 4, '2025-07-29 15:52:12'),
(3, 2, 5, '2025-07-29 16:07:12'),
(4, 3, 7, '2025-07-31 00:55:48'),
(5, 3, 1, '2025-07-31 01:03:01'),
(6, 4, 1, '2025-08-04 15:01:25'),
(7, 5, 1, '2025-08-04 16:51:03'),
(8, 6, 1, '2025-08-04 16:51:35'),
(9, 7, 1, '2025-08-04 16:56:57'),
(10, 8, 1, '2025-08-04 16:57:08'),
(11, 9, 1, '2025-08-04 17:04:37'),
(12, 10, 1, '2025-08-04 17:04:51'),
(13, 11, 1, '2025-08-04 17:06:54'),
(15, 13, 12, '2025-08-04 17:15:47');

-- --------------------------------------------------------

--
-- Struttura della tabella `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `tags`
--

INSERT INTO `tags` (`id`, `user_id`, `name`) VALUES
(1, 1, 'goalll'),
(3, 1, 'kk'),
(17, 12, 'goal'),
(18, 12, 'kk'),
(16, 12, 'ssss');

-- --------------------------------------------------------

--
-- Struttura della tabella `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` varchar(10) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `transfer_group_id` varchar(36) DEFAULT NULL,
  `invoice_path` varchar(255) DEFAULT NULL,
  `goal_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `account_id`, `category_id`, `amount`, `type`, `description`, `transaction_date`, `created_at`, `transfer_group_id`, `invoice_path`, `goal_id`) VALUES
(2, 1, 2, 7, '-28.99', 'expense', 'Clair Obscure', '2025-07-28', '2025-07-29 02:51:11', NULL, NULL, NULL),
(3, 1, 1, 4, '-30.00', 'expense', 'Benzina', '2025-07-28', '2025-07-29 02:51:35', NULL, NULL, NULL),
(4, 1, 2, 11, '-9.00', 'expense', 'Elden RIng', '2025-07-28', '2025-07-29 03:06:56', NULL, NULL, NULL),
(5, 1, 1, 8, '-24.00', 'expense', 'Kebab', '2025-07-29', '2025-07-29 04:13:24', NULL, NULL, NULL),
(7, 1, 1, 6, '-50.00', 'expense', 'Internet Casa', '2025-07-28', '2025-07-29 14:47:14', NULL, NULL, NULL),
(8, 1, 1, 13, '-70.00', 'expense', 'Prova trasferimento', '2025-07-29', '2025-07-29 14:57:49', NULL, NULL, NULL),
(9, 1, 1, 13, '-200.00', 'expense', 'da principale a revolut', '2025-07-29', '2025-07-29 15:08:08', 'transfer_6888e3d84f4de4.89760951', NULL, NULL),
(10, 1, 2, 13, '200.00', 'income', 'da principale a revolut', '2025-07-29', '2025-07-29 15:08:08', 'transfer_6888e3d84f4de4.89760951', NULL, NULL),
(11, 1, 1, NULL, '-20.00', 'expense', 'Contributo a fondo: Jesolo Night City Spesa', '2025-07-29', '2025-07-29 15:26:59', NULL, NULL, NULL),
(12, 1, 1, NULL, '-50.00', 'expense', 'Contributo a fondo: Jesolo Night City Spesa', '2025-07-29', '2025-07-30 00:10:06', NULL, NULL, NULL),
(13, 7, 4, 34, '-40.00', 'expense', 'wuchang', '2025-07-30', '2025-07-31 00:52:48', NULL, NULL, NULL),
(15, 7, 4, 39, '-320.00', 'expense', 'Contributo a fondo: jesolo spesa', '2025-07-30', '2025-07-31 01:03:51', NULL, NULL, NULL),
(22, 12, 13, 107, '-199.00', 'expense', 'Contributo a fondo: Risparmio generale', '2025-08-04', '2025-08-04 17:13:21', NULL, 'uploads/6890ee1fb384d-Leonardo_Phoenix_10_A_mystical_ancient_dragon_coin_with_ornate_0.jpg', NULL),
(24, 12, 13, 107, '-3331.00', 'expense', '33', '2025-08-04', '2025-08-04 21:04:56', NULL, NULL, NULL),
(25, 12, 13, 107, '-5.00', 'expense', '555', '2025-08-04', '2025-08-04 21:42:06', NULL, 'uploads/68912ce145cdd-ChatGPT Image 1 giu 2025, 13_10_55.png', NULL),
(26, 12, 13, 107, '-45.00', 'expense', 'Amazon Prime', '2025-08-04', '2025-08-04 21:59:16', NULL, 'uploads/68912d348f523-Note_250328_122811.pdf', NULL),
(27, 12, 13, 96, '7000.00', 'income', 'yyyyyyyy', '2025-08-04', '2025-08-04 22:25:25', NULL, NULL, NULL),
(28, 12, 13, 107, '-7.00', 'expense', 'ptobva', '2025-08-04', '2025-08-04 23:08:01', NULL, 'uploads/68913d51e5c50-Calend_ Game_I ANNO_24-25( IIsemestre).pdf', NULL),
(29, 12, 13, 107, '-7.00', 'expense', 'Kebab', '2025-08-04', '2025-08-04 23:08:20', NULL, 'uploads/68913d64e64d7-Bearget PRO Icon.png', NULL),
(30, 12, 13, 108, '-90.00', 'expense', 'verso revo', '2025-08-04', '2025-08-04 23:10:03', 'transfer_68913dcb897599.04402305', NULL, NULL),
(31, 12, 16, 108, '90.00', 'income', 'verso revo', '2025-08-04', '2025-08-04 23:10:03', 'transfer_68913dcb897599.04402305', NULL, NULL),
(32, 12, 16, 108, '-90.00', 'expense', 'Verso princ', '2025-08-04', '2025-08-04 23:10:30', 'transfer_68913de639b6a4.22268147', NULL, NULL),
(33, 12, 13, 108, '90.00', 'income', 'Verso princ', '2025-08-04', '2025-08-04 23:10:30', 'transfer_68913de639b6a4.22268147', NULL, NULL),
(34, 12, 16, 108, '-90.00', 'expense', 'Verso princ', '2025-08-04', '2025-08-04 23:10:31', 'transfer_68913de7a763a3.82228912', NULL, NULL),
(35, 12, 13, 108, '90.00', 'income', 'Verso princ', '2025-08-04', '2025-08-04 23:10:31', 'transfer_68913de7a763a3.82228912', NULL, NULL),
(36, 12, 16, 108, '-90.00', 'expense', 'Verso princ', '2025-08-04', '2025-08-04 23:10:35', 'transfer_68913debca5448.03276983', NULL, NULL),
(37, 12, 13, 108, '90.00', 'income', 'Verso princ', '2025-08-04', '2025-08-04 23:10:35', 'transfer_68913debca5448.03276983', NULL, NULL),
(38, 12, 13, 107, '-2000.00', 'expense', 'iudav', '2025-09-27', '2025-08-05 00:52:51', NULL, NULL, NULL),
(39, 1, 1, 12, '-100.00', 'expense', 'Contributo a: PC', '2025-08-05', '2025-08-05 18:40:28', NULL, NULL, NULL),
(40, 1, 1, 12, '-100.00', 'expense', 'Contributo a: PC', '2025-08-05', '2025-08-05 19:53:35', NULL, NULL, NULL),
(41, 1, 1, 12, '-50.00', 'expense', 'Contributo a: Risparmio generale', '2025-08-05', '2025-08-05 20:00:08', NULL, NULL, 13);

-- --------------------------------------------------------

--
-- Struttura della tabella `transaction_tags`
--

CREATE TABLE `transaction_tags` (
  `transaction_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `transaction_tags`
--

INSERT INTO `transaction_tags` (`transaction_id`, `tag_id`) VALUES
(26, 18),
(28, 18),
(29, 18);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `theme` varchar(25) NOT NULL DEFAULT 'dark-indigo',
  `subscription_status` varchar(20) NOT NULL DEFAULT 'free',
  `stripe_customer_id` varchar(255) DEFAULT NULL,
  `stripe_subscription_id` varchar(255) DEFAULT NULL,
  `subscription_end_date` timestamp NULL DEFAULT NULL,
  `subscription_start_date` timestamp NULL DEFAULT NULL,
  `friend_code` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `verification_token`, `is_verified`, `created_at`, `theme`, `subscription_status`, `stripe_customer_id`, `stripe_subscription_id`, `subscription_end_date`, `subscription_start_date`, `friend_code`) VALUES
(1, 'Christian', 'microhardtolax4@gmail.com', '$2y$10$ybXBV/xPwp5vIcLcF4QSoeRtZIYXMdwZzyUggxjAhO.ouTATHWPlO', NULL, 1, '2025-07-29 02:26:09', 'dark-indigo', 'lifetime', NULL, NULL, NULL, NULL, 'BIX59CRD'),
(2, 'Cristyanne', 'microhardtolax3@gmail.com', '$2y$10$ChaQ3Q7ktg.dgrbp70BnGOvM8JgEx3E32tpPpoz3HgXUXj.rHnq12', NULL, 1, '2025-07-29 13:47:25', 'dark-indigo', 'lifetime', NULL, NULL, NULL, NULL, 'AFRWEFSD'),
(3, 'Denise', 'jo@gmail.com', '$2y$10$qCF.Sm4TqVxZziIQSIeLIuCtAK4siKai0JpfywG/VoIfR9sHE9ZZe', NULL, 1, '2025-07-29 14:03:28', 'dark-indigo', 'free', NULL, NULL, NULL, NULL, NULL),
(4, 'dio', 'lol@gmail.com', '$2y$10$e84Nk4CFEYWGcmFXBr5LnOSsPwCWaqr6MAuhPGSN5mi9KDixUgUAa', NULL, 1, '2025-07-29 15:47:17', 'dark-indigo', 'active', 'cus_Slx2VNGl0yjFWX', 'sub_1RqP8RGglZNZJs04IRwg4H38', NULL, NULL, 'BIY59CRT'),
(5, 'Orso', 'orso@gmail.com', '$2y$10$7u36Rs5c0w0di4bZCkJYcuV/OSifGULBJkG9FQuLs.NPG0T2TZhKG', NULL, 1, '2025-07-29 16:02:35', 'dark-indigo', 'free', NULL, NULL, NULL, NULL, 'HBZ2CMTV'),
(6, 'Chris', 'chris@gmail.com', '$2y$10$ZRPan9k8wHvUvaneOMieleum.eZ01EGp8q.Av.w.YZYo9HkLi9.Na', NULL, 1, '2025-07-29 16:17:03', 'forest-green', 'active', NULL, NULL, NULL, NULL, 'VK6J9NM3'),
(7, 'cristian.salviato', 'cristiansalviato09@gmail.com', '$2y$10$OHUL1jqrLG3gWqql9gpvm.VNPpnsrnKsNnycP891Ku.MqBpn2tQqy', NULL, 1, '2025-07-31 00:50:17', 'sunset-orange', 'lifetime', NULL, NULL, NULL, NULL, '6WOX0EJ5'),
(8, 'PagamentoProva', 'Pagamento1prova@gmail.com', '$2y$10$6qc7v8s3yWtBsk5ZnR9e8e3a1jhSGNP57JSfnrZSRZg2rgobq5eqK', NULL, 1, '2025-07-31 13:52:31', 'dark-indigo', 'free', NULL, NULL, NULL, NULL, 'RD3SECNF'),
(9, 'prova2', 'Pagamento2prova@gmail.com', '$2y$10$kcEBb/S9UxqOMuPIT1jdf.6junj69CsV5qSEdLLQoeLhGRDWZDa1.', NULL, 1, '2025-07-31 15:11:18', 'dark-indigo', 'active', 'cus_SmXDCbzJLIq5mr', 'sub_1Rqy9LGvLwuAyACzwUyMY1W9', NULL, NULL, 'C5T1PN28'),
(10, 'prova3', 'Pagamento3prova@gmail.com', '$2y$10$SxEJyoCKxUIsZOQveLCilObIt7xl5C34D.YTPNPzGp15IBw5ctOnG', NULL, 1, '2025-07-31 15:25:59', 'dark-indigo', 'active', 'cus_SmXS4VeqJ0IQVy', 'sub_1RqyNTGvLwuAyACzOSxl9CP1', NULL, NULL, 'TXESJWUV'),
(11, 'prova4', 'prova4@gmail.com', '$2y$10$OYmWOIRT8OXXGDGWlXJu6e5zee84E05i1ufplrZIA1hcDR2BH4Fim', NULL, 1, '2025-07-31 23:40:00', 'dark-indigo', 'active', 'cus_Smt8t0vUL1kqcs', 'sub_1RrJM5GvLwuAyACzI55V0CrF', '2025-08-01 16:50:44', '2025-08-01 16:50:39', 'BVGQJNTE'),
(12, 'ProvaNoAdmin', 'provanoadmin@gmail.com', '$2y$10$fvkzi7p7Q14njXgU2zwpA.0NUJFJFtYfribI1XuLhDJE03Z9uB4LO', 'a76cac723973649d9c40d41c3f3dd4d9d3ee61e74a1bfeee1fe6317c485fb06e', 1, '2025-08-04 17:09:40', 'forest-green', 'active', 'cus_So44wxqjxzqfA4', 'sub_1RsRwKGvLwuAyACzcTBlcPBT', '2025-08-04 20:12:51', '2025-08-04 20:12:46', 'G2ND9I7P'),
(13, 'CHristia', 'Christa@gmail.com', '$2y$10$l8kIV7olSMJEMX9oG1LmHurxztZ6cVvo/5Mm/0lefJDQVn7Ruljee', '98bc75dc88c2ced2f4dbc5943a11e7b30e1cf033924d9dc06a1f0d3d4752f0a4', 1, '2025-08-04 17:11:27', 'dark-indigo', 'free', NULL, NULL, NULL, NULL, 'WVSUAOD3'),
(14, 'yooo', 'yooo@gmail.com', '$2y$10$FdaccBSNAOd77vN2ywbkwefKR4DeUlelQk.Urxuq.Cpc1T9sndD8y', NULL, 1, '2025-08-05 03:35:19', 'forest-green', 'active', 'cus_SoEFhPrN1bWcwI', 'sub_1RsbmdGvLwuAyACz51661hhK', '2025-08-05 06:43:30', '2025-08-05 06:43:25', 'SIJPLM1Z'),
(15, 'Orso', 'orsinchri@gmail.com', '$2y$10$xBrEn7kCYuUWB6XTC9S8Puj4VOB.PFjqfmY5knGqlp2Wt9gXqRAcG', NULL, 1, '2025-08-07 22:01:32', 'forest-green', 'free', NULL, NULL, NULL, NULL, 'O69ZEKH1');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indici per le tabelle `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_category_unique` (`user_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indici per le tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indici per le tabelle `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indici per le tabelle `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indici per le tabelle `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indici per le tabelle `recurring_transactions`
--
ALTER TABLE `recurring_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indici per le tabelle `saving_goals`
--
ALTER TABLE `saving_goals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_saving_goals_linked_category` (`linked_category_id`);

--
-- Indici per le tabelle `shared_funds`
--
ALTER TABLE `shared_funds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_id` (`creator_id`);

--
-- Indici per le tabelle `shared_fund_contributions`
--
ALTER TABLE `shared_fund_contributions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fund_id` (`fund_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indici per le tabelle `shared_fund_members`
--
ALTER TABLE `shared_fund_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fund_user_unique` (`fund_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indici per le tabelle `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_tag_unique` (`user_id`,`name`),
  ADD KEY `user_id` (`user_id`);

--
-- Indici per le tabelle `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `fk_transaction_goal` (`goal_id`);

--
-- Indici per le tabelle `transaction_tags`
--
ALTER TABLE `transaction_tags`
  ADD PRIMARY KEY (`transaction_id`,`tag_id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `friend_code` (`friend_code`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT per la tabella `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT per la tabella `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `recurring_transactions`
--
ALTER TABLE `recurring_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `saving_goals`
--
ALTER TABLE `saving_goals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `shared_funds`
--
ALTER TABLE `shared_funds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la tabella `shared_fund_contributions`
--
ALTER TABLE `shared_fund_contributions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `shared_fund_members`
--
ALTER TABLE `shared_fund_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT per la tabella `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `budgets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `budgets_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `recurring_transactions`
--
ALTER TABLE `recurring_transactions`
  ADD CONSTRAINT `recurring_transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recurring_transactions_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recurring_transactions_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `saving_goals`
--
ALTER TABLE `saving_goals`
  ADD CONSTRAINT `fk_saving_goals_linked_category` FOREIGN KEY (`linked_category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `saving_goals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `shared_funds`
--
ALTER TABLE `shared_funds`
  ADD CONSTRAINT `shared_funds_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `shared_fund_contributions`
--
ALTER TABLE `shared_fund_contributions`
  ADD CONSTRAINT `shared_fund_contributions_ibfk_1` FOREIGN KEY (`fund_id`) REFERENCES `shared_funds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shared_fund_contributions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `shared_fund_members`
--
ALTER TABLE `shared_fund_members`
  ADD CONSTRAINT `shared_fund_members_ibfk_1` FOREIGN KEY (`fund_id`) REFERENCES `shared_funds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shared_fund_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_transaction_goal` FOREIGN KEY (`goal_id`) REFERENCES `saving_goals` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Limiti per la tabella `transaction_tags`
--
ALTER TABLE `transaction_tags`
  ADD CONSTRAINT `transaction_tags_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
