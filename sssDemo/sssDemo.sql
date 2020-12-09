

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pbsDashBoard`
--


-- --------------------------------------------------------

--
-- Table structure for table `register` (registered users)
--

CREATE TABLE IF NOT EXISTS `register` (
  `uid` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `phone` varchar(25) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
--
-- Table structure for table `logFile`
--
CREATE TABLE IF NOT EXISTS logFile (
  transactionId int NOT NULL AUTO_INCREMENT,
  create_date timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  os varchar(15) NOT NULL,
  customerEmail varchar(50) NOT NULL,
  hostID varchar(255) NOT NULL,
  systemId varchar(255) NOT NULL,
  cpuCores int NOT NULL,
  keyGen varchar(255) NOT NULL,
  duration varchar(25) NOT NULL,
  uid int NOT NULL,
  PRIMARY KEY (transactionId),
  INDEX (uid),
  FOREIGN KEY (uid)
  REFERENCES register(uid)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `mailList` (email addresses to be sent as keys are cut)
--

CREATE TABLE IF NOT EXISTS `emaiList` (
  `email` varchar(255) NOT NULL,
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
