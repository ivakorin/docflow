-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 02 2015 г., 15:02
-- Версия сервера: 5.5.41
-- Версия PHP: 5.4.36-0+deb7u3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `contracts`
--

-- --------------------------------------------------------

--
-- Структура таблицы `contractors`
--

CREATE TABLE IF NOT EXISTS `contractors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pattern_of_ownership` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `post_code` varchar(45) NOT NULL,
  `area` varchar(180) NOT NULL,
  `region` varchar(180) NOT NULL,
  `city` varchar(45) NOT NULL,
  `street` varchar(90) NOT NULL,
  `building` varchar(45) NOT NULL,
  `web_site` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `contact_person_phone` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `contact_person_surname` varchar(45) DEFAULT NULL,
  `contact_person_name` varchar(90) NOT NULL,
  `contact_person_patronymic` varchar(90) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Структура таблицы `contractor_type`
--

CREATE TABLE IF NOT EXISTS `contractor_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0 - supplier, 1-customer, 3- another',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Структура таблицы `contracts_data`
--

CREATE TABLE IF NOT EXISTS `contracts_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='For signed and active contracts' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `contracts_journal`
--

CREATE TABLE IF NOT EXISTS `contracts_journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_number` varchar(11) NOT NULL,
  `incoming_date` int(11) NOT NULL,
  `incoming_contract_number` varchar(255) NOT NULL,
  `incoming_contract_date` int(11) NOT NULL,
  `validity` int(11) NOT NULL,
  `letter_type` varchar(4) DEFAULT '0',
  `contract_species` varchar(45) NOT NULL,
  `contract_type` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  `contractor_name` varchar(255) NOT NULL,
  `contract_subject` text NOT NULL,
  `contract_cost` decimal(15,2) NOT NULL,
  `valute` varchar(45) NOT NULL,
  `initiator` varchar(50) NOT NULL,
  `initiator_department` varchar(180) NOT NULL,
  `purchase_method` varchar(90) NOT NULL,
  `link_to_file` varchar(360) NOT NULL,
  `curator` varchar(45) NOT NULL,
  `jurist` varchar(90) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Структура таблицы `contracts_negotiations`
--

CREATE TABLE IF NOT EXISTS `contracts_negotiations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_number` varchar(45) NOT NULL,
  `revision` int(11) NOT NULL,
  `member` varchar(45) NOT NULL,
  `note` text,
  `status` varchar(45) NOT NULL,
  `global_status` varchar(45) NOT NULL,
  `file_name` varchar(45) NOT NULL,
  `voted` tinyint(1) DEFAULT '0',
  `begin_time_stamp` int(11) NOT NULL,
  `negotiations_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Структура таблицы `contracts_species`
--

CREATE TABLE IF NOT EXISTS `contracts_species` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `species` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `contract_files_types`
--

CREATE TABLE IF NOT EXISTS `contract_files_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_type` varchar(45) NOT NULL,
  `file_type_description` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблицы `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(45) DEFAULT NULL,
  `short_department_name` varchar(50) NOT NULL,
  `head_of_department` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Data about departments' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `internal_requests`
--

CREATE TABLE IF NOT EXISTS `internal_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) DEFAULT NULL,
  `reason` varchar(45) DEFAULT NULL,
  `department` varchar(45) DEFAULT NULL,
  `part` varchar(45) DEFAULT NULL,
  `requested` varchar(45) DEFAULT NULL,
  `approved` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `internal_request_data`
--

CREATE TABLE IF NOT EXISTS `internal_request_data` (
  `request_number` int(11) NOT NULL,
  `position_in_request` int(50) NOT NULL,
  `parts_description` varchar(45) DEFAULT NULL,
  `partnumber` varchar(45) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `purchase_date` varchar(45) DEFAULT NULL COMMENT 'It ',
  `comment` mediumtext,
  PRIMARY KEY (`request_number`),
  UNIQUE KEY `request_number_UNIQUE` (`request_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table for storge of data for internal request';

-- --------------------------------------------------------

--
-- Структура таблицы `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `letters`
--

CREATE TABLE IF NOT EXISTS `letters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `letter` varchar(5) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

-- --------------------------------------------------------

--
-- Структура таблицы `links_to_files`
--

CREATE TABLE IF NOT EXISTS `links_to_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `contract_number` varchar(255) NOT NULL,
  `file_type` varchar(45) NOT NULL,
  `file_version` int(11) NOT NULL,
  `file_name` varchar(45) NOT NULL,
  `link_to_file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Структура таблицы `paid_invoices`
--

CREATE TABLE IF NOT EXISTS `paid_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `parts_data`
--

CREATE TABLE IF NOT EXISTS `parts_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) DEFAULT NULL,
  `partnumber` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `party_list`
--

CREATE TABLE IF NOT EXISTS `party_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `party` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `purchase_methods`
--

CREATE TABLE IF NOT EXISTS `purchase_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(90) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Структура таблицы `purchase_orders`
--

CREATE TABLE IF NOT EXISTS `purchase_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='info about purchase orders' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `purchase_types`
--

CREATE TABLE IF NOT EXISTS `purchase_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `request_for_quotation`
--

CREATE TABLE IF NOT EXISTS `request_for_quotation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `internal_request_id` varchar(45) DEFAULT NULL,
  `supplier` varchar(45) DEFAULT NULL,
  `part` varchar(45) DEFAULT NULL,
  `cost` varchar(45) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `total_for_part` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='add data about all reply of supplier' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `second_name` varchar(45) DEFAULT NULL,
  `patronymic` varchar(45) DEFAULT NULL,
  `initials` varchar(90) NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `department` varchar(45) DEFAULT NULL,
  `position` varchar(90) DEFAULT NULL,
  `decision_maker` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `administrator` tinyint(1) NOT NULL DEFAULT '0',
  `jurist` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Data about staff' AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users_sessions`
--

CREATE TABLE IF NOT EXISTS `users_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `valute`
--

CREATE TABLE IF NOT EXISTS `valute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valute_name` varchar(45) NOT NULL,
  `valute_description` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
