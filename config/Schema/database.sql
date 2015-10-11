SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `address_details` (
`id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET latin1 NOT NULL,
  `address_line_1` varchar(255) CHARACTER SET latin1 NOT NULL,
  `address_line_2` varchar(255) CHARACTER SET latin1 NOT NULL,
  `street` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `house_number` varchar(8) CHARACTER SET latin1 DEFAULT NULL,
  `house_number_addition` varchar(8) CHARACTER SET latin1 DEFAULT NULL,
  `city` varchar(128) CHARACTER SET latin1 NOT NULL,
  `province` varchar(64) CHARACTER SET latin1 NOT NULL,
  `postcode` varchar(16) CHARACTER SET latin1 NOT NULL,
  `country` varchar(128) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `customers` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(32) NOT NULL,
  `vat_number` varchar(255) DEFAULT NULL,
  `financial_contact_id` int(11) DEFAULT NULL,
  `invoice_address_detail_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=633 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `customer_contacts` (
`id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `telephone` varchar(64) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `customer_users` (
`id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;


ALTER TABLE `address_details`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `customers`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `customer_contacts`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `customer_users`
 ADD PRIMARY KEY (`id`);


ALTER TABLE `address_details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=158;
ALTER TABLE `customers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=633;
ALTER TABLE `customer_contacts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=142;
ALTER TABLE `customer_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
