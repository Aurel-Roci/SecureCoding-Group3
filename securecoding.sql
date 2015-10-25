-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2015 at 09:40 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: securecoding
--

-- --------------------------------------------------------

-- Drops tables to replace the old ones
-- if you want only to update comment the following line
DROP TABLE IF EXISTS transactions,tans, users;

--
-- Table structure for table users
--

CREATE TABLE IF NOT EXISTS users (
  id int AUTO_INCREMENT,
  username varchar(15) NOT NULL,
  password varchar(64) NOT NULL,
  firstname varchar(20) NOT NULL,
  lastname varchar(20) NOT NULL,
  approved bool NOT NULL DEFAULT 0,
  memberrole tinyint NOT NULL,
  -- 0 for customer, 1 for employee
  UNIQUE KEY(username),
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table tans
--

CREATE TABLE IF NOT EXISTS tans (
  id varchar(15) NOT NULL,
  user_id int,
  -- used variable removed and added a tan field in the transactions to
  -- stick to some database modeling conventions
  PRIMARY KEY(id),
  FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table transactions
--

CREATE TABLE IF NOT EXISTS transactions (
  id int AUTO_INCREMENT,
  sender_id int NOT NULL,
  recipient_id int NOT NULL,
  ammount int(10) NOT NULL,
  approval_date DATETIME,
  -- same as before if approve_date is not set it is not approved
  -- and for approving you set the current timestamp
  -- for example: UPDATE transactions SET approve_date = NOW() WHERE ...
  create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  tan_id VARCHAR(15) NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(sender_id) REFERENCES users(id) ON DELETE NO ACTION,
  FOREIGN KEY(recipient_id) REFERENCES users(id) ON DELETE NO ACTION,
  FOREIGN KEY(tan_id) REFERENCES tans(id) ON DELETE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table users
--

INSERT INTO users (username, password, approved, memberrole, firstname, lastname) VALUES
('admin', SHA2('samurai', 256), True, 1, 'Admin', 'Admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
