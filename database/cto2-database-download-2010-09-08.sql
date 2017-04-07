-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Host: 173.201.217.6
-- Generation Time: Sep 08, 2010 at 02:41 AM
-- Server version: 5.0.91
-- PHP Version: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ctou2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cto_admin`
--

DROP TABLE IF EXISTS `cto_admin`;
CREATE TABLE IF NOT EXISTS `cto_admin` (
  `admin_id` int(11) NOT NULL auto_increment,
  `admin_groups_id` int(11) default NULL,
  `admin_firstname` varchar(32) collate latin1_general_ci NOT NULL default '',
  `admin_lastname` varchar(32) collate latin1_general_ci default NULL,
  `admin_email_address` varchar(96) collate latin1_general_ci NOT NULL default '',
  `admin_password` varchar(40) collate latin1_general_ci NOT NULL default '',
  `admin_created` datetime default NULL,
  `admin_modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `admin_logdate` datetime default NULL,
  `admin_lognum` int(11) NOT NULL default '0',
  PRIMARY KEY  (`admin_id`),
  UNIQUE KEY `admin_email_address` (`admin_email_address`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cto_admin`
--

INSERT INTO `cto_admin` VALUES(1, 1, 'AdminFirstname', 'AdminLastname', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2006-04-15 15:46:46', '0000-00-00 00:00:00', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cto_admin_settings`
--

DROP TABLE IF EXISTS `cto_admin_settings`;
CREATE TABLE IF NOT EXISTS `cto_admin_settings` (
  `setting_id` int(11) NOT NULL default '0',
  `site_store_name` varchar(100) collate latin1_general_ci NOT NULL,
  `site_owner_name` varchar(100) collate latin1_general_ci NOT NULL,
  `site_domain_name` varchar(50) collate latin1_general_ci default NULL,
  `site_phone_number` varchar(50) collate latin1_general_ci NOT NULL default '',
  `site_fax_number` varchar(50) collate latin1_general_ci NOT NULL default '',
  `site_company_name` varchar(50) collate latin1_general_ci NOT NULL default '',
  `site_company_address` varchar(250) collate latin1_general_ci NOT NULL,
  `site_company_city` varchar(50) collate latin1_general_ci NOT NULL default '',
  `site_company_state` varchar(50) collate latin1_general_ci NOT NULL default '',
  `site_company_zip` varchar(50) collate latin1_general_ci NOT NULL default '',
  `site_company_country` varchar(255) collate latin1_general_ci NOT NULL default '',
  `site_zone` varchar(200) collate latin1_general_ci NOT NULL,
  `site_email_address` varchar(200) collate latin1_general_ci NOT NULL,
  `site_email_from` varchar(200) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`setting_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `cto_admin_settings`
--

INSERT INTO `cto_admin_settings` VALUES(1, 'CTOsOnTheMove.com', '', 'CTOsOnTheMove.com', '', '', '', '', '', '', '', '', '', 'admin@ctosonthemove.com', 'admin@ctosonthemove.com');

-- --------------------------------------------------------

--
-- Table structure for table `cto_alert`
--

DROP TABLE IF EXISTS `cto_alert`;
CREATE TABLE IF NOT EXISTS `cto_alert` (
  `alert_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `country` varchar(200) NOT NULL,
  `state` varchar(150) NOT NULL,
  `city` varchar(150) NOT NULL,
  `zip_code` varchar(150) NOT NULL,
  `company` varchar(255) NOT NULL,
  `industry_id` varchar(200) NOT NULL,
  `revenue_size` varchar(200) NOT NULL,
  `employee_size` varchar(200) NOT NULL,
  `delivery_schedule` varchar(20) NOT NULL,
  `monthly_budget` varchar(200) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `exp_date` date NOT NULL,
  `alert_date` date NOT NULL,
  `add_date` date NOT NULL,
  `modify_date` date NOT NULL,
  `level` varchar(20) NOT NULL,
  `status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`alert_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `cto_alert`
--

INSERT INTO `cto_alert` VALUES(1, 4, 'Chief Information Officer', 'Appointment', 'United States', 'CA', 'Type in the City', 'Type in the Zip code', 'Type in the Company Name', '', '$101-250 Million', '251-1000', 'Monthly', '$180', '3RE86799R1686283A', '2020-05-12', '2010-09-25', '2010-05-12', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(2, 4, 'Vice President of Technology', 'Termination', 'United States', '', 'Type in the City', 'Type in the Zip code', 'Type in the Company Name', '6', '$11-50 Million', '101-250', 'Weekly', '$90', '6WR69777U6153101N', '2020-05-12', '2010-08-31', '2010-05-12', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(3, 6, 'Chief Information Officer', 'Resignation', 'United States', 'CA', 'Type in the City', 'Type in the Zip code', 'Type in the Company Name', '24', '$11-50 Million', '251-1000', 'Monthly', '$90', '4BH506041R905563G', '2020-05-17', '2010-09-25', '2010-05-17', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(4, 6, 'Chief Information Officer', 'Appointment', '', 'CA', 'Type in the City', 'Type in the Zip code', 'Type in the Company Name', '15', '$11-50 Million', '251-1000', 'Weekly', '$90', '95G41268Y8022053N', '2020-05-24', '2010-08-24', '2010-05-24', '0000-00-00', '', 1);
INSERT INTO `cto_alert` VALUES(5, 6, 'Vice President of Technology', 'Resignation', '', 'CA', 'Type in the City', 'Type in the Zip code', 'Type in the Company Name', '24', '', '', 'Weekly', '$180', '18418408U2311730X', '2020-05-24', '2010-08-31', '2010-05-24', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(6, 1, 'Chief Information Officer', 'Appointment', '', 'CA', 'Type in the City', 'Type in the Zip code', 'Type in the Company Name', '', '', '', 'Weekly', '$90', '', '2020-05-26', '2010-08-24', '2010-05-26', '0000-00-00', '', 1);
INSERT INTO `cto_alert` VALUES(7, 9, 'Chief Information Officer', '', 'Afghanistan', 'AL', 'Type in the City', 'Type in the Zip code', 'Type in the Company Name', '2', 'Any', 'Any', 'Weekly', '$90', '', '2020-05-27', '2010-08-31', '2010-05-27', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(8, 1, 'Chief Technology Officer', 'Appointment', 'United States', 'CA', 'Type in the City', 'Type in the Zip code', 'Type in the Company Name', '3', '$10-50 Million', 'Any', 'Monthly', '$180', '', '2020-06-01', '2010-08-24', '2010-06-01', '0000-00-00', 'Paid', 1);
INSERT INTO `cto_alert` VALUES(9, 1, 'Chief Technology Officer', 'Appointment', 'United States', 'CA', 'Type in the City', 'Type in the Zip code', 'Type in the Company Name', '5', 'Any', 'Any', 'Any', '$45', '', '2020-06-01', '2010-08-31', '2010-06-01', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(10, 0, 'Any', 'Appointment', 'Any', 'Any', 'Type in the City', 'Type in the Zip code', 'Type in the Company Name', '', 'Any', 'Any', 'Any', 'Any', '', '2020-06-02', '2010-08-31', '2010-06-02', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(12, 0, 'Chief Technology Officer', 'Retirement', 'United States', 'CA', 'Kolkata', '7876876', 'ABC Co.', '6', '$10-50 Million', '250-1000', 'Monthly', '$180', '', '2020-06-03', '2010-09-25', '2010-06-03', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(13, 6, 'Chief Technology Officer', 'Retirement', 'Any', 'Any', '', '', '', '', 'Any', 'Any', 'Weekly', 'Any', '', '2020-06-04', '2010-08-24', '2010-06-04', '0000-00-00', '', 1);
INSERT INTO `cto_alert` VALUES(14, 17, 'Chief Technology Officer', 'Promotion', 'United States', 'CA', '', '', '', '', '$10-50 Million', '100-250', 'Monthly', '$180', '', '2020-06-08', '2010-09-25', '2010-06-08', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(15, 0, 'Chief Information Officer', 'Any', 'Any', 'Any', '', '', '', '', '$1-10 Million', '25-100', 'Any', '$90', '', '2020-06-10', '2010-09-25', '2010-06-10', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(16, 0, 'Chief Technology Officer', 'Any', 'Any', 'Any', '', '', '', '', '$0-1 Million', '100-250', 'Weekly', '$90', '', '2020-06-10', '2010-08-31', '2010-06-10', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(18, 26, 'Chief Information Officer', 'Appointment', 'Any', 'Any', '', '', '', '6', '$0-1 Million', '0-25', 'Weekly', '$45', '1KA40110SE653853R', '2020-06-14', '2010-08-24', '2010-06-14', '0000-00-00', '', 1);
INSERT INTO `cto_alert` VALUES(19, 26, 'Chief Technology Officer', 'Appointment', 'Any', 'CA', '', '', '', '6', '$0-1 Million', '25-100', 'Weekly', '$90', '5WE95670EG165970L', '2020-06-14', '2010-08-31', '2010-06-14', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(20, 26, 'Chief Technology Officer', 'Promotion', 'Any', 'CA', '', '', '', '6', '$0-1 Million', '25-100', 'Weekly', '$180', '6NK73895E9506344R', '2020-06-14', '2010-08-31', '2010-06-14', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(21, 26, 'Chief Information Officer', 'Any', 'Any', 'CA', '', '', '', '6', '$0-1 Million', '100-250', 'Monthly', '$90', '48C50381D3191190T', '2020-06-14', '2010-08-24', '2010-06-14', '0000-00-00', '', 1);
INSERT INTO `cto_alert` VALUES(22, 38, 'Chief Information Officer', 'Retirement', 'United States', 'CA', '', '', '', '', 'Any', 'Any', 'Weekly', '$180', '0WK14091ED853882N', '2020-07-02', '2010-08-31', '2010-07-02', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(23, 38, 'Chief Technology Officer', 'Appointment', 'United States', 'CA', '', '', '', '6', '$10-50 Million', '25-100', 'Monthly', '$180', '1Y636900084162744', '2020-07-02', '2010-09-25', '2010-07-02', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(24, 9, 'Any', 'Any', 'Any', 'Any', '', '', '', '', 'Any', 'Any', 'Any', '$45', '', '2020-07-05', '2010-09-25', '2010-07-05', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(25, 55, 'Chief Information Officer', 'Appointment', 'USA', 'CA', '', '', '', '5', 'Any', 'Any', 'Daily', '$90', '4SR67003UJ1734410', '2020-08-25', '2010-08-31', '2010-08-25', '0000-00-00', '', 0);
INSERT INTO `cto_alert` VALUES(26, 55, 'Chief Technology Officer', 'Promotion', 'USA', 'FL', '', '', 'Testing Co.', '14', 'Any', '100-250', 'Weekly', '$45', '0PL49813CF5869250', '2020-08-25', '2010-09-01', '2010-08-25', '0000-00-00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cto_alert_price`
--

DROP TABLE IF EXISTS `cto_alert_price`;
CREATE TABLE IF NOT EXISTS `cto_alert_price` (
  `ap_id` int(11) NOT NULL auto_increment,
  `ap_name` varchar(255) NOT NULL,
  `ap_amount` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `modify_date` date NOT NULL,
  `status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ap_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `cto_alert_price`
--

INSERT INTO `cto_alert_price` VALUES(5, '90', 90, '2010-03-26', '2010-03-26', 0);
INSERT INTO `cto_alert_price` VALUES(4, '45', 45, '2010-03-26', '2010-03-26', 0);
INSERT INTO `cto_alert_price` VALUES(6, '180', 180, '2010-03-26', '2010-03-26', 0);
INSERT INTO `cto_alert_price` VALUES(7, 'Unlimited', 250, '2010-03-26', '2010-03-26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cto_alert_send_info`
--

DROP TABLE IF EXISTS `cto_alert_send_info`;
CREATE TABLE IF NOT EXISTS `cto_alert_send_info` (
  `info_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `alert_id` int(11) NOT NULL,
  `contact_id` text NOT NULL,
  `email_content` text NOT NULL,
  `sent_date` varchar(50) NOT NULL,
  PRIMARY KEY  (`info_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `cto_alert_send_info`
--

INSERT INTO `cto_alert_send_info` VALUES(1, 55, 25, '38,152', '<a href="http://ctosonthemove.com/cto2/index.php"><img src="http://ctosonthemove.com/cto2/images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;\n							  <table width="95%" cellspacing="0" cellpadding="3" class="alert_email_content11">\n								<tr>\n									<td align="left" colspan="2">&nbsp;</td>\n								</tr><tr>\n								<td align="left" colspan="2"><b>Your matches alert 1 </b></td>\n							</tr>\n							<tr>\n								<td align="left" width="150"> Name:</td>\n								<td align="left">Roy Finaly</td>\n							</tr>\n							<tr>\n								<td align="left"> Title:</td>\n								<td align="left">Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> Email:</td>\n								<td align="left">rfinaly@iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Phone:</td>\n								<td align="left">619.477.6310</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Name:</td>\n								<td align="left">InterAmerican College</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Industry:</td>\n								<td align="left">Colleges and Universities</td>\n							</tr>\n							<tr>\n								<td align="left"> Address:</td>\n								<td align="left">140 W 16th St</td>\n							</tr>\n							<tr>\n								<td align="left"> City:</td>\n								<td align="left">National City</td>\n							</tr>\n							<tr>\n								<td align="left"> State:</td>\n								<td align="left">CA</td>\n							</tr>\n							<tr>\n								<td align="left"> Country:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> Zip Code:</td>\n								<td align="left">91950</td>\n							</tr>\n							<tr>\n								<td align="left"> Announce Date:</td>\n								<td align="left">2010-02-26</td>\n							</tr>\n							<tr>\n								<td align="left"> Effective Date:</td>\n								<td align="left">2010-02-26</td>\n							</tr>\n							<tr>\n								<td align="left"> Source:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> Headline:</td>\n								<td align="left">InterAmerican College Appoints Dr. Yoram Neumann as its New President and CEO</td>\n							</tr>\n							<tr>\n								<td align="left"> Full Body:</td>\n								<td align="left">InterAmerican College Appoints Dr. Yoram Neumann as its New President and CEO\r\n</td>\n							</tr>\n							<tr>\n								<td align="left"> Short URL:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> What Happened:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> About Person:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> About Company:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> More Link:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left" colspan="2">&nbsp;</td>\n							</tr><tr>\n								<td align="left" colspan="2"><b>Your matches alert 2 </b></td>\n							</tr>\n							<tr>\n								<td align="left" width="150"> Name:</td>\n								<td align="left">Jeremy Hopkins</td>\n							</tr>\n							<tr>\n								<td align="left"> Title:</td>\n								<td align="left">Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> Email:</td>\n								<td align="left">JHopkins@wtgcom.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Phone:</td>\n								<td align="left">310.456.2200</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Name:</td>\n								<td align="left">World Telecom Group</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.worldtelecomgroup.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.worldtelecomgroup.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Industry:</td>\n								<td align="left">Business Services Other</td>\n							</tr>\n							<tr>\n								<td align="left"> Address:</td>\n								<td align="left">22761 Pacific Coast Hwy Ste 101</td>\n							</tr>\n							<tr>\n								<td align="left"> City:</td>\n								<td align="left">Malibu</td>\n							</tr>\n							<tr>\n								<td align="left"> State:</td>\n								<td align="left">CA</td>\n							</tr>\n							<tr>\n								<td align="left"> Country:</td>\n								<td align="left">USA</td>\n							</tr>\n							<tr>\n								<td align="left"> Zip Code:</td>\n								<td align="left">90265</td>\n							</tr>\n							<tr>\n								<td align="left"> Announce Date:</td>\n								<td align="left">2010-07-28</td>\n							</tr>\n							<tr>\n								<td align="left"> Effective Date:</td>\n								<td align="left">2010-07-28</td>\n							</tr>\n							<tr>\n								<td align="left"> Source:</td>\n								<td align="left">Company Announcement</td>\n							</tr>\n							<tr>\n								<td align="left"> Headline:</td>\n								<td align="left">World Telecom Group Announces the Appointment of Jeremy Hopkins to CFO/CIO</td>\n							</tr>\n							<tr>\n								<td align="left"> Full Body:</td>\n								<td align="left">World Telecom Group Announces the Appointment of Jeremy Hopkins to CFO/CIO                                                                                                                                                                                             Wednesday 28 July 2010 3:48 pm                                                                                                                                                                                              World Telecom Group (WTG); a premier Master Agency with the most diverse telecom portfolio in the industry has appointed Jeremy Hopkins to the position of Chief Financial Officer/Chief Information Officer. Hopkins primary responsibilities will include managing all financial and technological matters within the organization. He will report directly to CEO; Vince Bradley.                                                                                                                                                                                             Bradley stated; “I am extremely excited to have someone of Jeremy’s caliber as part of WTG’s management team. As we approach 100% complete automation overlay; his expertise will allow us to take our CRM to the next level.”                                                                                                                                                                                             Hopkins is an accomplished consultant in delivering highly effective Sales Force Automation (SFA) technology applications. In addition to over 12 years of technology management consulting experience spanning North America; Asia and Europe; he has built up seven years of targeted expertise in deploying CRM (Customer Relationship Management) systems for both Fortune 500 companies and Small and Medium Sized Enterprises (SMEs). Hopkins specializes in systems analysis; data modeling; user interface design and project management in the development B2B Web Portals; servicing centralized call center operations; distributed retail and wholesale/broker-based business. He has been entrusted to develop multiple projects with eight figure investment portfolios.                                                                                                                                                                                             Hopkins said “I am elated to be working with such an impressive team of individuals and look forward to working with our Provider and Agent Partners in the near future.”                                                                                                                                                                                              Hopkins holds an MBA degree from The University of Chicago Booth School of Business; a top-five program in the United States and the Midwestern powerhouse of finance; banking and economics. In addition; he has served as an adjunct professor of marketing in the undergraduate business division of his alma mater; Pepperdine University.                                                                                                                                                                                             To contact Jeremy Hopkins directly; please reach him at 310.456.2200 or via e-mail JHopkins@wtgcom.com. For more information about WTG please go to www.worldtelecomgroup.com.                                                                                                                                                                                             About World Telecom Group                                                                                                                                                                                             World Telecom Group (WTG) is a premier Master Agent providing exceptional service to agent partners since 1996. WTG has the most diverse portfolio in the industry with over 100 Providers; including local; long-distance; data and internet. It also includes the following specialty Divisions with dedicated extra support: LEC; award winning Wireless/Mobility; Equipment; Wholesale; Cost Containment (TEM; Logistics and all other Cost Containment) and Energent; its extremely fast growing Energy Division (Electricity; Natural Gas and DSM). WTG Agents have the ability to sell and consistently expand their business without commitments or quotas. WTG is 100% partner driven and pays top commissions in the industry. WTG exceeds expectations with a dynamic approach to automation; partner support and its commitment to success.                                                                                                                                                                                             Press Contact:                                                                                                                                                                                             Salwa Scarpone                                                                                                                                                                                             sscarpone@wtgcom.com                                                                                                                                                                                             310.456.2200</td>\n							</tr>\n							<tr>\n								<td align="left"> Short URL:</td>\n								<td align="left">http://bit.ly/8Xe0rF</td>\n							</tr>\n							<tr>\n								<td align="left"> What Happened:</td>\n								<td align="left">World Telecom Group appointed Jeremy Hopkins as Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> About Person:</td>\n								<td align="left">Jeremy Hopkins is an accomplished consultant in delivering highly effective Sales Force Automation (SFA) technology applications. In addition to over 12 years of technology management consulting experience spanning North America; Asia and Europe; he has built up seven years of targeted expertise in deploying CRM (Customer Relationship Management) systems for both Fortune 500 companies and Small and Medium Sized Enterprises (SMEs).  Hopkins holds an MBA degree from The University of Chicago Booth School of Business.</td>\n							</tr>\n							<tr>\n								<td align="left"> About Company:</td>\n								<td align="left">World Telecom Group (WTG) is a premier Master Agent providing exceptional service to agent partners since 1996. WTG has the most diverse portfolio in the industry with over 100 Providers; including local; long-distance; data and internet. It also includes the following specialty Divisions with dedicated extra support: LEC; award winning Wireless/Mobility; Equipment; Wholesale; Cost Containment (TEM; Logistics and all other Cost Containment) and Energent; its extremely fast growing Energy Division (Electricity; Natural Gas and DSM). WTG Agents have the ability to sell and consistently expand their business without commitments or quotas. WTG is 100% partner driven and pays top commissions in the industry. WTG exceeds expectations with a dynamic approach to automation; partner support and its commitment to success.</td>\n							</tr>\n							<tr>\n								<td align="left"> More Link:</td>\n								<td align="left">http://www.worldtelecomgroup.com/?p=318</td>\n							</tr>\n							<tr>\n								<td align="left" colspan="2">&nbsp;</td>\n							</tr></table>', '1282736589');
INSERT INTO `cto_alert_send_info` VALUES(3, 55, 26, '35,116', '<a href="http://ctosonthemove.com/cto2/index.php"><img src="http://ctosonthemove.com/cto2/images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;\n							  <table width="95%" cellspacing="0" cellpadding="3" class="alert_email_content11">\n								<tr>\n									<td align="left" colspan="2">&nbsp;</td>\n								</tr><tr>\n								<td align="left" colspan="2"><b>Your matches alert 1 </b></td>\n							</tr>\n							<tr>\n								<td align="left" width="150"> Name:</td>\n								<td align="left">Tom Packert</td>\n							</tr>\n							<tr>\n								<td align="left"> Title:</td>\n								<td align="left">Chief Technology Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> Email:</td>\n								<td align="left">info@carecloud.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Phone:</td>\n								<td align="left">786.528.5740</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Name:</td>\n								<td align="left">CareCloud</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.carecloud.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.carecloud.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Industry:</td>\n								<td align="left">Consumer Services Other</td>\n							</tr>\n							<tr>\n								<td align="left"> Address:</td>\n								<td align="left">5200 Blue Lagoon Dr Ste 900</td>\n							</tr>\n							<tr>\n								<td align="left"> City:</td>\n								<td align="left">Miami</td>\n							</tr>\n							<tr>\n								<td align="left"> State:</td>\n								<td align="left">FL</td>\n							</tr>\n							<tr>\n								<td align="left"> Country:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> Zip Code:</td>\n								<td align="left">33126</td>\n							</tr>\n							<tr>\n								<td align="left"> Announce Date:</td>\n								<td align="left">2010-02-15</td>\n							</tr>\n							<tr>\n								<td align="left"> Effective Date:</td>\n								<td align="left">2010-02-15</td>\n							</tr>\n							<tr>\n								<td align="left"> Source:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> Headline:</td>\n								<td align="left">CareCloud appoints new chief technology officer</td>\n							</tr>\n							<tr>\n								<td align="left"> Full Body:</td>\n								<td align="left">CareCloud appoints new chief technology officer\r\n</td>\n							</tr>\n							<tr>\n								<td align="left"> Short URL:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> What Happened:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> About Person:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> About Company:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> More Link:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left" colspan="2">&nbsp;</td>\n							</tr><tr>\n								<td align="left" colspan="2"><b>Your matches alert 2 </b></td>\n							</tr>\n							<tr>\n								<td align="left" width="150"> Name:</td>\n								<td align="left">John Iacovelli</td>\n							</tr>\n							<tr>\n								<td align="left"> Title:</td>\n								<td align="left">Chief Technology Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> Email:</td>\n								<td align="left">n/a</td>\n							</tr>\n							<tr>\n								<td align="left"> Phone:</td>\n								<td align="left">561.394.2748</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Name:</td>\n								<td align="left">Flint Telecom Group</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.flinttel.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.flinttel.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Industry:</td>\n								<td align="left">Telecommunications Other</td>\n							</tr>\n							<tr>\n								<td align="left"> Address:</td>\n								<td align="left">327 Plaza Real Ste 319</td>\n							</tr>\n							<tr>\n								<td align="left"> City:</td>\n								<td align="left">Boca Raton</td>\n							</tr>\n							<tr>\n								<td align="left"> State:</td>\n								<td align="left">FL</td>\n							</tr>\n							<tr>\n								<td align="left"> Country:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> Zip Code:</td>\n								<td align="left">33432</td>\n							</tr>\n							<tr>\n								<td align="left"> Announce Date:</td>\n								<td align="left">2010-02-04</td>\n							</tr>\n							<tr>\n								<td align="left"> Effective Date:</td>\n								<td align="left">2010-02-04</td>\n							</tr>\n							<tr>\n								<td align="left"> Source:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> Headline:</td>\n								<td align="left">FORM 8-K</td>\n							</tr>\n							<tr>\n								<td align="left"> Full Body:</td>\n								<td align="left">FORM 8-K\r\n</td>\n							</tr>\n							<tr>\n								<td align="left"> Short URL:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> What Happened:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> About Person:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> About Company:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> More Link:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left" colspan="2">&nbsp;</td>\n							</tr></table>', '1282739201');
INSERT INTO `cto_alert_send_info` VALUES(4, 55, 25, '38,152', '<a href="http://ctosonthemove.com/cto2/index.php"><img src="http://ctosonthemove.com/cto2/images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;\n							  <table width="95%" cellspacing="0" cellpadding="3" class="alert_email_content11">\n								<tr>\n									<td align="left" colspan="2">&nbsp;</td>\n								</tr><tr>\n								<td align="left" colspan="2"><b>Your matches alert 1 </b></td>\n							</tr>\n							<tr>\n								<td align="left" width="150"> Name:</td>\n								<td align="left">Roy Finaly</td>\n							</tr>\n							<tr>\n								<td align="left"> Title:</td>\n								<td align="left">Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> Email:</td>\n								<td align="left">rfinaly@iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Phone:</td>\n								<td align="left">619.477.6310</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Name:</td>\n								<td align="left">InterAmerican College</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Industry:</td>\n								<td align="left">Colleges and Universities</td>\n							</tr>\n							<tr>\n								<td align="left"> Address:</td>\n								<td align="left">140 W 16th St</td>\n							</tr>\n							<tr>\n								<td align="left"> City:</td>\n								<td align="left">National City</td>\n							</tr>\n							<tr>\n								<td align="left"> State:</td>\n								<td align="left">CA</td>\n							</tr>\n							<tr>\n								<td align="left"> Country:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> Zip Code:</td>\n								<td align="left">91950</td>\n							</tr>\n							<tr>\n								<td align="left"> Announce Date:</td>\n								<td align="left">2010-02-26</td>\n							</tr>\n							<tr>\n								<td align="left"> Effective Date:</td>\n								<td align="left">2010-02-26</td>\n							</tr>\n							<tr>\n								<td align="left"> Source:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> Headline:</td>\n								<td align="left">InterAmerican College Appoints Dr. Yoram Neumann as its New President and CEO</td>\n							</tr>\n							<tr>\n								<td align="left"> Full Body:</td>\n								<td align="left">InterAmerican College Appoints Dr. Yoram Neumann as its New President and CEO\r\n</td>\n							</tr>\n							<tr>\n								<td align="left"> Short URL:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> What Happened:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> About Person:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> About Company:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> More Link:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left" colspan="2">&nbsp;</td>\n							</tr><tr>\n								<td align="left" colspan="2"><b>Your matches alert 2 </b></td>\n							</tr>\n							<tr>\n								<td align="left" width="150"> Name:</td>\n								<td align="left">Jeremy Hopkins</td>\n							</tr>\n							<tr>\n								<td align="left"> Title:</td>\n								<td align="left">Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> Email:</td>\n								<td align="left">JHopkins@wtgcom.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Phone:</td>\n								<td align="left">310.456.2200</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Name:</td>\n								<td align="left">World Telecom Group</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.worldtelecomgroup.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.worldtelecomgroup.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Industry:</td>\n								<td align="left">Business Services Other</td>\n							</tr>\n							<tr>\n								<td align="left"> Address:</td>\n								<td align="left">22761 Pacific Coast Hwy Ste 101</td>\n							</tr>\n							<tr>\n								<td align="left"> City:</td>\n								<td align="left">Malibu</td>\n							</tr>\n							<tr>\n								<td align="left"> State:</td>\n								<td align="left">CA</td>\n							</tr>\n							<tr>\n								<td align="left"> Country:</td>\n								<td align="left">USA</td>\n							</tr>\n							<tr>\n								<td align="left"> Zip Code:</td>\n								<td align="left">90265</td>\n							</tr>\n							<tr>\n								<td align="left"> Announce Date:</td>\n								<td align="left">2010-07-28</td>\n							</tr>\n							<tr>\n								<td align="left"> Effective Date:</td>\n								<td align="left">2010-07-28</td>\n							</tr>\n							<tr>\n								<td align="left"> Source:</td>\n								<td align="left">Company Announcement</td>\n							</tr>\n							<tr>\n								<td align="left"> Headline:</td>\n								<td align="left">World Telecom Group Announces the Appointment of Jeremy Hopkins to CFO/CIO</td>\n							</tr>\n							<tr>\n								<td align="left"> Full Body:</td>\n								<td align="left">World Telecom Group Announces the Appointment of Jeremy Hopkins to CFO/CIO                                                                                                                                                                                             Wednesday 28 July 2010 3:48 pm                                                                                                                                                                                              World Telecom Group (WTG); a premier Master Agency with the most diverse telecom portfolio in the industry has appointed Jeremy Hopkins to the position of Chief Financial Officer/Chief Information Officer. Hopkins primary responsibilities will include managing all financial and technological matters within the organization. He will report directly to CEO; Vince Bradley.                                                                                                                                                                                             Bradley stated; “I am extremely excited to have someone of Jeremy’s caliber as part of WTG’s management team. As we approach 100% complete automation overlay; his expertise will allow us to take our CRM to the next level.”                                                                                                                                                                                             Hopkins is an accomplished consultant in delivering highly effective Sales Force Automation (SFA) technology applications. In addition to over 12 years of technology management consulting experience spanning North America; Asia and Europe; he has built up seven years of targeted expertise in deploying CRM (Customer Relationship Management) systems for both Fortune 500 companies and Small and Medium Sized Enterprises (SMEs). Hopkins specializes in systems analysis; data modeling; user interface design and project management in the development B2B Web Portals; servicing centralized call center operations; distributed retail and wholesale/broker-based business. He has been entrusted to develop multiple projects with eight figure investment portfolios.                                                                                                                                                                                             Hopkins said “I am elated to be working with such an impressive team of individuals and look forward to working with our Provider and Agent Partners in the near future.”                                                                                                                                                                                              Hopkins holds an MBA degree from The University of Chicago Booth School of Business; a top-five program in the United States and the Midwestern powerhouse of finance; banking and economics. In addition; he has served as an adjunct professor of marketing in the undergraduate business division of his alma mater; Pepperdine University.                                                                                                                                                                                             To contact Jeremy Hopkins directly; please reach him at 310.456.2200 or via e-mail JHopkins@wtgcom.com. For more information about WTG please go to www.worldtelecomgroup.com.                                                                                                                                                                                             About World Telecom Group                                                                                                                                                                                             World Telecom Group (WTG) is a premier Master Agent providing exceptional service to agent partners since 1996. WTG has the most diverse portfolio in the industry with over 100 Providers; including local; long-distance; data and internet. It also includes the following specialty Divisions with dedicated extra support: LEC; award winning Wireless/Mobility; Equipment; Wholesale; Cost Containment (TEM; Logistics and all other Cost Containment) and Energent; its extremely fast growing Energy Division (Electricity; Natural Gas and DSM). WTG Agents have the ability to sell and consistently expand their business without commitments or quotas. WTG is 100% partner driven and pays top commissions in the industry. WTG exceeds expectations with a dynamic approach to automation; partner support and its commitment to success.                                                                                                                                                                                             Press Contact:                                                                                                                                                                                             Salwa Scarpone                                                                                                                                                                                             sscarpone@wtgcom.com                                                                                                                                                                                             310.456.2200</td>\n							</tr>\n							<tr>\n								<td align="left"> Short URL:</td>\n								<td align="left">http://bit.ly/8Xe0rF</td>\n							</tr>\n							<tr>\n								<td align="left"> What Happened:</td>\n								<td align="left">World Telecom Group appointed Jeremy Hopkins as Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> About Person:</td>\n								<td align="left">Jeremy Hopkins is an accomplished consultant in delivering highly effective Sales Force Automation (SFA) technology applications. In addition to over 12 years of technology management consulting experience spanning North America; Asia and Europe; he has built up seven years of targeted expertise in deploying CRM (Customer Relationship Management) systems for both Fortune 500 companies and Small and Medium Sized Enterprises (SMEs).  Hopkins holds an MBA degree from The University of Chicago Booth School of Business.</td>\n							</tr>\n							<tr>\n								<td align="left"> About Company:</td>\n								<td align="left">World Telecom Group (WTG) is a premier Master Agent providing exceptional service to agent partners since 1996. WTG has the most diverse portfolio in the industry with over 100 Providers; including local; long-distance; data and internet. It also includes the following specialty Divisions with dedicated extra support: LEC; award winning Wireless/Mobility; Equipment; Wholesale; Cost Containment (TEM; Logistics and all other Cost Containment) and Energent; its extremely fast growing Energy Division (Electricity; Natural Gas and DSM). WTG Agents have the ability to sell and consistently expand their business without commitments or quotas. WTG is 100% partner driven and pays top commissions in the industry. WTG exceeds expectations with a dynamic approach to automation; partner support and its commitment to success.</td>\n							</tr>\n							<tr>\n								<td align="left"> More Link:</td>\n								<td align="left">http://www.worldtelecomgroup.com/?p=318</td>\n							</tr>\n							<tr>\n								<td align="left" colspan="2">&nbsp;</td>\n							</tr></table>', '1282850711');
INSERT INTO `cto_alert_send_info` VALUES(5, 55, 25, '38,152', '<a href="http://ctosonthemove.com/cto2/index.php"><img src="http://ctosonthemove.com/cto2/images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;\n							  <table width="95%" cellspacing="0" cellpadding="3" class="alert_email_content11">\n								<tr>\n									<td align="left" colspan="2">&nbsp;</td>\n								</tr><tr>\n								<td align="left" colspan="2"><b>Your matches alert 1 </b></td>\n							</tr>\n							<tr>\n								<td align="left" width="150"> Name:</td>\n								<td align="left">Roy Finaly</td>\n							</tr>\n							<tr>\n								<td align="left"> Title:</td>\n								<td align="left">Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> Email:</td>\n								<td align="left">rfinaly@iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Phone:</td>\n								<td align="left">619.477.6310</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Name:</td>\n								<td align="left">InterAmerican College</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Industry:</td>\n								<td align="left">Colleges and Universities</td>\n							</tr>\n							<tr>\n								<td align="left"> Address:</td>\n								<td align="left">140 W 16th St</td>\n							</tr>\n							<tr>\n								<td align="left"> City:</td>\n								<td align="left">National City</td>\n							</tr>\n							<tr>\n								<td align="left"> State:</td>\n								<td align="left">CA</td>\n							</tr>\n							<tr>\n								<td align="left"> Country:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> Zip Code:</td>\n								<td align="left">91950</td>\n							</tr>\n							<tr>\n								<td align="left"> Announce Date:</td>\n								<td align="left">2010-02-26</td>\n							</tr>\n							<tr>\n								<td align="left"> Effective Date:</td>\n								<td align="left">2010-02-26</td>\n							</tr>\n							<tr>\n								<td align="left"> Source:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> Headline:</td>\n								<td align="left">InterAmerican College Appoints Dr. Yoram Neumann as its New President and CEO</td>\n							</tr>\n							<tr>\n								<td align="left"> Full Body:</td>\n								<td align="left">InterAmerican College Appoints Dr. Yoram Neumann as its New President and CEO\r\n</td>\n							</tr>\n							<tr>\n								<td align="left"> Short URL:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> What Happened:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> About Person:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> About Company:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> More Link:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left" colspan="2">&nbsp;</td>\n							</tr><tr>\n								<td align="left" colspan="2"><b>Your matches alert 2 </b></td>\n							</tr>\n							<tr>\n								<td align="left" width="150"> Name:</td>\n								<td align="left">Jeremy Hopkins</td>\n							</tr>\n							<tr>\n								<td align="left"> Title:</td>\n								<td align="left">Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> Email:</td>\n								<td align="left">JHopkins@wtgcom.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Phone:</td>\n								<td align="left">310.456.2200</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Name:</td>\n								<td align="left">World Telecom Group</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.worldtelecomgroup.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.worldtelecomgroup.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Industry:</td>\n								<td align="left">Business Services Other</td>\n							</tr>\n							<tr>\n								<td align="left"> Address:</td>\n								<td align="left">22761 Pacific Coast Hwy Ste 101</td>\n							</tr>\n							<tr>\n								<td align="left"> City:</td>\n								<td align="left">Malibu</td>\n							</tr>\n							<tr>\n								<td align="left"> State:</td>\n								<td align="left">CA</td>\n							</tr>\n							<tr>\n								<td align="left"> Country:</td>\n								<td align="left">USA</td>\n							</tr>\n							<tr>\n								<td align="left"> Zip Code:</td>\n								<td align="left">90265</td>\n							</tr>\n							<tr>\n								<td align="left"> Announce Date:</td>\n								<td align="left">2010-07-28</td>\n							</tr>\n							<tr>\n								<td align="left"> Effective Date:</td>\n								<td align="left">2010-07-28</td>\n							</tr>\n							<tr>\n								<td align="left"> Source:</td>\n								<td align="left">Company Announcement</td>\n							</tr>\n							<tr>\n								<td align="left"> Headline:</td>\n								<td align="left">World Telecom Group Announces the Appointment of Jeremy Hopkins to CFO/CIO</td>\n							</tr>\n							<tr>\n								<td align="left"> Full Body:</td>\n								<td align="left">World Telecom Group Announces the Appointment of Jeremy Hopkins to CFO/CIO                                                                                                                                                                                             Wednesday 28 July 2010 3:48 pm                                                                                                                                                                                              World Telecom Group (WTG); a premier Master Agency with the most diverse telecom portfolio in the industry has appointed Jeremy Hopkins to the position of Chief Financial Officer/Chief Information Officer. Hopkins primary responsibilities will include managing all financial and technological matters within the organization. He will report directly to CEO; Vince Bradley.                                                                                                                                                                                             Bradley stated; “I am extremely excited to have someone of Jeremy’s caliber as part of WTG’s management team. As we approach 100% complete automation overlay; his expertise will allow us to take our CRM to the next level.”                                                                                                                                                                                             Hopkins is an accomplished consultant in delivering highly effective Sales Force Automation (SFA) technology applications. In addition to over 12 years of technology management consulting experience spanning North America; Asia and Europe; he has built up seven years of targeted expertise in deploying CRM (Customer Relationship Management) systems for both Fortune 500 companies and Small and Medium Sized Enterprises (SMEs). Hopkins specializes in systems analysis; data modeling; user interface design and project management in the development B2B Web Portals; servicing centralized call center operations; distributed retail and wholesale/broker-based business. He has been entrusted to develop multiple projects with eight figure investment portfolios.                                                                                                                                                                                             Hopkins said “I am elated to be working with such an impressive team of individuals and look forward to working with our Provider and Agent Partners in the near future.”                                                                                                                                                                                              Hopkins holds an MBA degree from The University of Chicago Booth School of Business; a top-five program in the United States and the Midwestern powerhouse of finance; banking and economics. In addition; he has served as an adjunct professor of marketing in the undergraduate business division of his alma mater; Pepperdine University.                                                                                                                                                                                             To contact Jeremy Hopkins directly; please reach him at 310.456.2200 or via e-mail JHopkins@wtgcom.com. For more information about WTG please go to www.worldtelecomgroup.com.                                                                                                                                                                                             About World Telecom Group                                                                                                                                                                                             World Telecom Group (WTG) is a premier Master Agent providing exceptional service to agent partners since 1996. WTG has the most diverse portfolio in the industry with over 100 Providers; including local; long-distance; data and internet. It also includes the following specialty Divisions with dedicated extra support: LEC; award winning Wireless/Mobility; Equipment; Wholesale; Cost Containment (TEM; Logistics and all other Cost Containment) and Energent; its extremely fast growing Energy Division (Electricity; Natural Gas and DSM). WTG Agents have the ability to sell and consistently expand their business without commitments or quotas. WTG is 100% partner driven and pays top commissions in the industry. WTG exceeds expectations with a dynamic approach to automation; partner support and its commitment to success.                                                                                                                                                                                             Press Contact:                                                                                                                                                                                             Salwa Scarpone                                                                                                                                                                                             sscarpone@wtgcom.com                                                                                                                                                                                             310.456.2200</td>\n							</tr>\n							<tr>\n								<td align="left"> Short URL:</td>\n								<td align="left">http://bit.ly/8Xe0rF</td>\n							</tr>\n							<tr>\n								<td align="left"> What Happened:</td>\n								<td align="left">World Telecom Group appointed Jeremy Hopkins as Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> About Person:</td>\n								<td align="left">Jeremy Hopkins is an accomplished consultant in delivering highly effective Sales Force Automation (SFA) technology applications. In addition to over 12 years of technology management consulting experience spanning North America; Asia and Europe; he has built up seven years of targeted expertise in deploying CRM (Customer Relationship Management) systems for both Fortune 500 companies and Small and Medium Sized Enterprises (SMEs).  Hopkins holds an MBA degree from The University of Chicago Booth School of Business.</td>\n							</tr>\n							<tr>\n								<td align="left"> About Company:</td>\n								<td align="left">World Telecom Group (WTG) is a premier Master Agent providing exceptional service to agent partners since 1996. WTG has the most diverse portfolio in the industry with over 100 Providers; including local; long-distance; data and internet. It also includes the following specialty Divisions with dedicated extra support: LEC; award winning Wireless/Mobility; Equipment; Wholesale; Cost Containment (TEM; Logistics and all other Cost Containment) and Energent; its extremely fast growing Energy Division (Electricity; Natural Gas and DSM). WTG Agents have the ability to sell and consistently expand their business without commitments or quotas. WTG is 100% partner driven and pays top commissions in the industry. WTG exceeds expectations with a dynamic approach to automation; partner support and its commitment to success.</td>\n							</tr>\n							<tr>\n								<td align="left"> More Link:</td>\n								<td align="left">http://www.worldtelecomgroup.com/?p=318</td>\n							</tr>\n							<tr>\n								<td align="left" colspan="2">&nbsp;</td>\n							</tr></table>', '1282937101');
INSERT INTO `cto_alert_send_info` VALUES(6, 55, 25, '38,152', '<a href="http://ctosonthemove.com/cto2/index.php"><img src="http://ctosonthemove.com/cto2/images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;\n							  <table width="95%" cellspacing="0" cellpadding="3" class="alert_email_content11">\n								<tr>\n									<td align="left" colspan="2">&nbsp;</td>\n								</tr><tr>\n								<td align="left" colspan="2"><b>Your matches alert 1 </b></td>\n							</tr>\n							<tr>\n								<td align="left" width="150"> Name:</td>\n								<td align="left">Roy Finaly</td>\n							</tr>\n							<tr>\n								<td align="left"> Title:</td>\n								<td align="left">Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> Email:</td>\n								<td align="left">rfinaly@iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Phone:</td>\n								<td align="left">619.477.6310</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Name:</td>\n								<td align="left">InterAmerican College</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Industry:</td>\n								<td align="left">Colleges and Universities</td>\n							</tr>\n							<tr>\n								<td align="left"> Address:</td>\n								<td align="left">140 W 16th St</td>\n							</tr>\n							<tr>\n								<td align="left"> City:</td>\n								<td align="left">National City</td>\n							</tr>\n							<tr>\n								<td align="left"> State:</td>\n								<td align="left">CA</td>\n							</tr>\n							<tr>\n								<td align="left"> Country:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> Zip Code:</td>\n								<td align="left">91950</td>\n							</tr>\n							<tr>\n								<td align="left"> Announce Date:</td>\n								<td align="left">2010-02-26</td>\n							</tr>\n							<tr>\n								<td align="left"> Effective Date:</td>\n								<td align="left">2010-02-26</td>\n							</tr>\n							<tr>\n								<td align="left"> Source:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> Headline:</td>\n								<td align="left">InterAmerican College Appoints Dr. Yoram Neumann as its New President and CEO</td>\n							</tr>\n							<tr>\n								<td align="left"> Full Body:</td>\n								<td align="left">InterAmerican College Appoints Dr. Yoram Neumann as its New President and CEO\r\n</td>\n							</tr>\n							<tr>\n								<td align="left"> Short URL:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> What Happened:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> About Person:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> About Company:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> More Link:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left" colspan="2">&nbsp;</td>\n							</tr><tr>\n								<td align="left" colspan="2"><b>Your matches alert 2 </b></td>\n							</tr>\n							<tr>\n								<td align="left" width="150"> Name:</td>\n								<td align="left">Jeremy Hopkins</td>\n							</tr>\n							<tr>\n								<td align="left"> Title:</td>\n								<td align="left">Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> Email:</td>\n								<td align="left">JHopkins@wtgcom.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Phone:</td>\n								<td align="left">310.456.2200</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Name:</td>\n								<td align="left">World Telecom Group</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.worldtelecomgroup.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.worldtelecomgroup.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Industry:</td>\n								<td align="left">Business Services Other</td>\n							</tr>\n							<tr>\n								<td align="left"> Address:</td>\n								<td align="left">22761 Pacific Coast Hwy Ste 101</td>\n							</tr>\n							<tr>\n								<td align="left"> City:</td>\n								<td align="left">Malibu</td>\n							</tr>\n							<tr>\n								<td align="left"> State:</td>\n								<td align="left">CA</td>\n							</tr>\n							<tr>\n								<td align="left"> Country:</td>\n								<td align="left">USA</td>\n							</tr>\n							<tr>\n								<td align="left"> Zip Code:</td>\n								<td align="left">90265</td>\n							</tr>\n							<tr>\n								<td align="left"> Announce Date:</td>\n								<td align="left">2010-07-28</td>\n							</tr>\n							<tr>\n								<td align="left"> Effective Date:</td>\n								<td align="left">2010-07-28</td>\n							</tr>\n							<tr>\n								<td align="left"> Source:</td>\n								<td align="left">Company Announcement</td>\n							</tr>\n							<tr>\n								<td align="left"> Headline:</td>\n								<td align="left">World Telecom Group Announces the Appointment of Jeremy Hopkins to CFO/CIO</td>\n							</tr>\n							<tr>\n								<td align="left"> Full Body:</td>\n								<td align="left">World Telecom Group Announces the Appointment of Jeremy Hopkins to CFO/CIO                                                                                                                                                                                             Wednesday 28 July 2010 3:48 pm                                                                                                                                                                                              World Telecom Group (WTG); a premier Master Agency with the most diverse telecom portfolio in the industry has appointed Jeremy Hopkins to the position of Chief Financial Officer/Chief Information Officer. Hopkins primary responsibilities will include managing all financial and technological matters within the organization. He will report directly to CEO; Vince Bradley.                                                                                                                                                                                             Bradley stated; “I am extremely excited to have someone of Jeremy’s caliber as part of WTG’s management team. As we approach 100% complete automation overlay; his expertise will allow us to take our CRM to the next level.”                                                                                                                                                                                             Hopkins is an accomplished consultant in delivering highly effective Sales Force Automation (SFA) technology applications. In addition to over 12 years of technology management consulting experience spanning North America; Asia and Europe; he has built up seven years of targeted expertise in deploying CRM (Customer Relationship Management) systems for both Fortune 500 companies and Small and Medium Sized Enterprises (SMEs). Hopkins specializes in systems analysis; data modeling; user interface design and project management in the development B2B Web Portals; servicing centralized call center operations; distributed retail and wholesale/broker-based business. He has been entrusted to develop multiple projects with eight figure investment portfolios.                                                                                                                                                                                             Hopkins said “I am elated to be working with such an impressive team of individuals and look forward to working with our Provider and Agent Partners in the near future.”                                                                                                                                                                                              Hopkins holds an MBA degree from The University of Chicago Booth School of Business; a top-five program in the United States and the Midwestern powerhouse of finance; banking and economics. In addition; he has served as an adjunct professor of marketing in the undergraduate business division of his alma mater; Pepperdine University.                                                                                                                                                                                             To contact Jeremy Hopkins directly; please reach him at 310.456.2200 or via e-mail JHopkins@wtgcom.com. For more information about WTG please go to www.worldtelecomgroup.com.                                                                                                                                                                                             About World Telecom Group                                                                                                                                                                                             World Telecom Group (WTG) is a premier Master Agent providing exceptional service to agent partners since 1996. WTG has the most diverse portfolio in the industry with over 100 Providers; including local; long-distance; data and internet. It also includes the following specialty Divisions with dedicated extra support: LEC; award winning Wireless/Mobility; Equipment; Wholesale; Cost Containment (TEM; Logistics and all other Cost Containment) and Energent; its extremely fast growing Energy Division (Electricity; Natural Gas and DSM). WTG Agents have the ability to sell and consistently expand their business without commitments or quotas. WTG is 100% partner driven and pays top commissions in the industry. WTG exceeds expectations with a dynamic approach to automation; partner support and its commitment to success.                                                                                                                                                                                             Press Contact:                                                                                                                                                                                             Salwa Scarpone                                                                                                                                                                                             sscarpone@wtgcom.com                                                                                                                                                                                             310.456.2200</td>\n							</tr>\n							<tr>\n								<td align="left"> Short URL:</td>\n								<td align="left">http://bit.ly/8Xe0rF</td>\n							</tr>\n							<tr>\n								<td align="left"> What Happened:</td>\n								<td align="left">World Telecom Group appointed Jeremy Hopkins as Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> About Person:</td>\n								<td align="left">Jeremy Hopkins is an accomplished consultant in delivering highly effective Sales Force Automation (SFA) technology applications. In addition to over 12 years of technology management consulting experience spanning North America; Asia and Europe; he has built up seven years of targeted expertise in deploying CRM (Customer Relationship Management) systems for both Fortune 500 companies and Small and Medium Sized Enterprises (SMEs).  Hopkins holds an MBA degree from The University of Chicago Booth School of Business.</td>\n							</tr>\n							<tr>\n								<td align="left"> About Company:</td>\n								<td align="left">World Telecom Group (WTG) is a premier Master Agent providing exceptional service to agent partners since 1996. WTG has the most diverse portfolio in the industry with over 100 Providers; including local; long-distance; data and internet. It also includes the following specialty Divisions with dedicated extra support: LEC; award winning Wireless/Mobility; Equipment; Wholesale; Cost Containment (TEM; Logistics and all other Cost Containment) and Energent; its extremely fast growing Energy Division (Electricity; Natural Gas and DSM). WTG Agents have the ability to sell and consistently expand their business without commitments or quotas. WTG is 100% partner driven and pays top commissions in the industry. WTG exceeds expectations with a dynamic approach to automation; partner support and its commitment to success.</td>\n							</tr>\n							<tr>\n								<td align="left"> More Link:</td>\n								<td align="left">http://www.worldtelecomgroup.com/?p=318</td>\n							</tr>\n							<tr>\n								<td align="left" colspan="2">&nbsp;</td>\n							</tr></table>', '1283023503');
INSERT INTO `cto_alert_send_info` VALUES(7, 55, 25, '38,152', '<a href="http://ctosonthemove.com/cto2/index.php"><img src="http://ctosonthemove.com/cto2/images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;\n							  <table width="95%" cellspacing="0" cellpadding="3" class="alert_email_content11">\n								<tr>\n									<td align="left" colspan="2">&nbsp;</td>\n								</tr><tr>\n								<td align="left" colspan="2"><b>Your matches alert 1 </b></td>\n							</tr>\n							<tr>\n								<td align="left" width="150"> Name:</td>\n								<td align="left">Roy Finaly</td>\n							</tr>\n							<tr>\n								<td align="left"> Title:</td>\n								<td align="left">Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> Email:</td>\n								<td align="left">rfinaly@iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Phone:</td>\n								<td align="left">619.477.6310</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Name:</td>\n								<td align="left">InterAmerican College</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Industry:</td>\n								<td align="left">Colleges and Universities</td>\n							</tr>\n							<tr>\n								<td align="left"> Address:</td>\n								<td align="left">140 W 16th St</td>\n							</tr>\n							<tr>\n								<td align="left"> City:</td>\n								<td align="left">National City</td>\n							</tr>\n							<tr>\n								<td align="left"> State:</td>\n								<td align="left">CA</td>\n							</tr>\n							<tr>\n								<td align="left"> Country:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> Zip Code:</td>\n								<td align="left">91950</td>\n							</tr>\n							<tr>\n								<td align="left"> Announce Date:</td>\n								<td align="left">2010-02-26</td>\n							</tr>\n							<tr>\n								<td align="left"> Effective Date:</td>\n								<td align="left">2010-02-26</td>\n							</tr>\n							<tr>\n								<td align="left"> Source:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> Headline:</td>\n								<td align="left">InterAmerican College Appoints Dr. Yoram Neumann as its New President and CEO</td>\n							</tr>\n							<tr>\n								<td align="left"> Full Body:</td>\n								<td align="left">InterAmerican College Appoints Dr. Yoram Neumann as its New President and CEO\r\n</td>\n							</tr>\n							<tr>\n								<td align="left"> Short URL:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> What Happened:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> About Person:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> About Company:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> More Link:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left" colspan="2">&nbsp;</td>\n							</tr><tr>\n								<td align="left" colspan="2"><b>Your matches alert 2 </b></td>\n							</tr>\n							<tr>\n								<td align="left" width="150"> Name:</td>\n								<td align="left">Jeremy Hopkins</td>\n							</tr>\n							<tr>\n								<td align="left"> Title:</td>\n								<td align="left">Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> Email:</td>\n								<td align="left">JHopkins@wtgcom.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Phone:</td>\n								<td align="left">310.456.2200</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Name:</td>\n								<td align="left">World Telecom Group</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.worldtelecomgroup.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.worldtelecomgroup.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Industry:</td>\n								<td align="left">Business Services Other</td>\n							</tr>\n							<tr>\n								<td align="left"> Address:</td>\n								<td align="left">22761 Pacific Coast Hwy Ste 101</td>\n							</tr>\n							<tr>\n								<td align="left"> City:</td>\n								<td align="left">Malibu</td>\n							</tr>\n							<tr>\n								<td align="left"> State:</td>\n								<td align="left">CA</td>\n							</tr>\n							<tr>\n								<td align="left"> Country:</td>\n								<td align="left">USA</td>\n							</tr>\n							<tr>\n								<td align="left"> Zip Code:</td>\n								<td align="left">90265</td>\n							</tr>\n							<tr>\n								<td align="left"> Announce Date:</td>\n								<td align="left">2010-07-28</td>\n							</tr>\n							<tr>\n								<td align="left"> Effective Date:</td>\n								<td align="left">2010-07-28</td>\n							</tr>\n							<tr>\n								<td align="left"> Source:</td>\n								<td align="left">Company Announcement</td>\n							</tr>\n							<tr>\n								<td align="left"> Headline:</td>\n								<td align="left">World Telecom Group Announces the Appointment of Jeremy Hopkins to CFO/CIO</td>\n							</tr>\n							<tr>\n								<td align="left"> Full Body:</td>\n								<td align="left">World Telecom Group Announces the Appointment of Jeremy Hopkins to CFO/CIO                                                                                                                                                                                             Wednesday 28 July 2010 3:48 pm                                                                                                                                                                                              World Telecom Group (WTG); a premier Master Agency with the most diverse telecom portfolio in the industry has appointed Jeremy Hopkins to the position of Chief Financial Officer/Chief Information Officer. Hopkins primary responsibilities will include managing all financial and technological matters within the organization. He will report directly to CEO; Vince Bradley.                                                                                                                                                                                             Bradley stated; “I am extremely excited to have someone of Jeremy’s caliber as part of WTG’s management team. As we approach 100% complete automation overlay; his expertise will allow us to take our CRM to the next level.”                                                                                                                                                                                             Hopkins is an accomplished consultant in delivering highly effective Sales Force Automation (SFA) technology applications. In addition to over 12 years of technology management consulting experience spanning North America; Asia and Europe; he has built up seven years of targeted expertise in deploying CRM (Customer Relationship Management) systems for both Fortune 500 companies and Small and Medium Sized Enterprises (SMEs). Hopkins specializes in systems analysis; data modeling; user interface design and project management in the development B2B Web Portals; servicing centralized call center operations; distributed retail and wholesale/broker-based business. He has been entrusted to develop multiple projects with eight figure investment portfolios.                                                                                                                                                                                             Hopkins said “I am elated to be working with such an impressive team of individuals and look forward to working with our Provider and Agent Partners in the near future.”                                                                                                                                                                                              Hopkins holds an MBA degree from The University of Chicago Booth School of Business; a top-five program in the United States and the Midwestern powerhouse of finance; banking and economics. In addition; he has served as an adjunct professor of marketing in the undergraduate business division of his alma mater; Pepperdine University.                                                                                                                                                                                             To contact Jeremy Hopkins directly; please reach him at 310.456.2200 or via e-mail JHopkins@wtgcom.com. For more information about WTG please go to www.worldtelecomgroup.com.                                                                                                                                                                                             About World Telecom Group                                                                                                                                                                                             World Telecom Group (WTG) is a premier Master Agent providing exceptional service to agent partners since 1996. WTG has the most diverse portfolio in the industry with over 100 Providers; including local; long-distance; data and internet. It also includes the following specialty Divisions with dedicated extra support: LEC; award winning Wireless/Mobility; Equipment; Wholesale; Cost Containment (TEM; Logistics and all other Cost Containment) and Energent; its extremely fast growing Energy Division (Electricity; Natural Gas and DSM). WTG Agents have the ability to sell and consistently expand their business without commitments or quotas. WTG is 100% partner driven and pays top commissions in the industry. WTG exceeds expectations with a dynamic approach to automation; partner support and its commitment to success.                                                                                                                                                                                             Press Contact:                                                                                                                                                                                             Salwa Scarpone                                                                                                                                                                                             sscarpone@wtgcom.com                                                                                                                                                                                             310.456.2200</td>\n							</tr>\n							<tr>\n								<td align="left"> Short URL:</td>\n								<td align="left">http://bit.ly/8Xe0rF</td>\n							</tr>\n							<tr>\n								<td align="left"> What Happened:</td>\n								<td align="left">World Telecom Group appointed Jeremy Hopkins as Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> About Person:</td>\n								<td align="left">Jeremy Hopkins is an accomplished consultant in delivering highly effective Sales Force Automation (SFA) technology applications. In addition to over 12 years of technology management consulting experience spanning North America; Asia and Europe; he has built up seven years of targeted expertise in deploying CRM (Customer Relationship Management) systems for both Fortune 500 companies and Small and Medium Sized Enterprises (SMEs).  Hopkins holds an MBA degree from The University of Chicago Booth School of Business.</td>\n							</tr>\n							<tr>\n								<td align="left"> About Company:</td>\n								<td align="left">World Telecom Group (WTG) is a premier Master Agent providing exceptional service to agent partners since 1996. WTG has the most diverse portfolio in the industry with over 100 Providers; including local; long-distance; data and internet. It also includes the following specialty Divisions with dedicated extra support: LEC; award winning Wireless/Mobility; Equipment; Wholesale; Cost Containment (TEM; Logistics and all other Cost Containment) and Energent; its extremely fast growing Energy Division (Electricity; Natural Gas and DSM). WTG Agents have the ability to sell and consistently expand their business without commitments or quotas. WTG is 100% partner driven and pays top commissions in the industry. WTG exceeds expectations with a dynamic approach to automation; partner support and its commitment to success.</td>\n							</tr>\n							<tr>\n								<td align="left"> More Link:</td>\n								<td align="left">http://www.worldtelecomgroup.com/?p=318</td>\n							</tr>\n							<tr>\n								<td align="left" colspan="2">&nbsp;</td>\n							</tr></table>', '1283109902');
INSERT INTO `cto_alert_send_info` VALUES(8, 55, 25, '38,152', '<a href="http://ctosonthemove.com/cto2/index.php"><img src="http://ctosonthemove.com/cto2/images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;\n							  <table width="95%" cellspacing="0" cellpadding="3" class="alert_email_content11">\n								<tr>\n									<td align="left" colspan="2">&nbsp;</td>\n								</tr><tr>\n								<td align="left" colspan="2"><b>Your matches alert 1 </b></td>\n							</tr>\n							<tr>\n								<td align="left" width="150"> Name:</td>\n								<td align="left">Roy Finaly</td>\n							</tr>\n							<tr>\n								<td align="left"> Title:</td>\n								<td align="left">Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> Email:</td>\n								<td align="left">rfinaly@iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Phone:</td>\n								<td align="left">619.477.6310</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Name:</td>\n								<td align="left">InterAmerican College</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.iacnc.edu</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Industry:</td>\n								<td align="left">Colleges and Universities</td>\n							</tr>\n							<tr>\n								<td align="left"> Address:</td>\n								<td align="left">140 W 16th St</td>\n							</tr>\n							<tr>\n								<td align="left"> City:</td>\n								<td align="left">National City</td>\n							</tr>\n							<tr>\n								<td align="left"> State:</td>\n								<td align="left">CA</td>\n							</tr>\n							<tr>\n								<td align="left"> Country:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> Zip Code:</td>\n								<td align="left">91950</td>\n							</tr>\n							<tr>\n								<td align="left"> Announce Date:</td>\n								<td align="left">2010-02-26</td>\n							</tr>\n							<tr>\n								<td align="left"> Effective Date:</td>\n								<td align="left">2010-02-26</td>\n							</tr>\n							<tr>\n								<td align="left"> Source:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> Headline:</td>\n								<td align="left">InterAmerican College Appoints Dr. Yoram Neumann as its New President and CEO</td>\n							</tr>\n							<tr>\n								<td align="left"> Full Body:</td>\n								<td align="left">InterAmerican College Appoints Dr. Yoram Neumann as its New President and CEO\r\n</td>\n							</tr>\n							<tr>\n								<td align="left"> Short URL:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> What Happened:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> About Person:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> About Company:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left"> More Link:</td>\n								<td align="left"></td>\n							</tr>\n							<tr>\n								<td align="left" colspan="2">&nbsp;</td>\n							</tr><tr>\n								<td align="left" colspan="2"><b>Your matches alert 2 </b></td>\n							</tr>\n							<tr>\n								<td align="left" width="150"> Name:</td>\n								<td align="left">Jeremy Hopkins</td>\n							</tr>\n							<tr>\n								<td align="left"> Title:</td>\n								<td align="left">Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> Email:</td>\n								<td align="left">JHopkins@wtgcom.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Phone:</td>\n								<td align="left">310.456.2200</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Name:</td>\n								<td align="left">World Telecom Group</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.worldtelecomgroup.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Website:</td>\n								<td align="left">www.worldtelecomgroup.com</td>\n							</tr>\n							<tr>\n								<td align="left"> Company Industry:</td>\n								<td align="left">Business Services Other</td>\n							</tr>\n							<tr>\n								<td align="left"> Address:</td>\n								<td align="left">22761 Pacific Coast Hwy Ste 101</td>\n							</tr>\n							<tr>\n								<td align="left"> City:</td>\n								<td align="left">Malibu</td>\n							</tr>\n							<tr>\n								<td align="left"> State:</td>\n								<td align="left">CA</td>\n							</tr>\n							<tr>\n								<td align="left"> Country:</td>\n								<td align="left">USA</td>\n							</tr>\n							<tr>\n								<td align="left"> Zip Code:</td>\n								<td align="left">90265</td>\n							</tr>\n							<tr>\n								<td align="left"> Announce Date:</td>\n								<td align="left">2010-07-28</td>\n							</tr>\n							<tr>\n								<td align="left"> Effective Date:</td>\n								<td align="left">2010-07-28</td>\n							</tr>\n							<tr>\n								<td align="left"> Source:</td>\n								<td align="left">Company Announcement</td>\n							</tr>\n							<tr>\n								<td align="left"> Headline:</td>\n								<td align="left">World Telecom Group Announces the Appointment of Jeremy Hopkins to CFO/CIO</td>\n							</tr>\n							<tr>\n								<td align="left"> Full Body:</td>\n								<td align="left">World Telecom Group Announces the Appointment of Jeremy Hopkins to CFO/CIO                                                                                                                                                                                             Wednesday 28 July 2010 3:48 pm                                                                                                                                                                                              World Telecom Group (WTG); a premier Master Agency with the most diverse telecom portfolio in the industry has appointed Jeremy Hopkins to the position of Chief Financial Officer/Chief Information Officer. Hopkins primary responsibilities will include managing all financial and technological matters within the organization. He will report directly to CEO; Vince Bradley.                                                                                                                                                                                             Bradley stated; “I am extremely excited to have someone of Jeremy’s caliber as part of WTG’s management team. As we approach 100% complete automation overlay; his expertise will allow us to take our CRM to the next level.”                                                                                                                                                                                             Hopkins is an accomplished consultant in delivering highly effective Sales Force Automation (SFA) technology applications. In addition to over 12 years of technology management consulting experience spanning North America; Asia and Europe; he has built up seven years of targeted expertise in deploying CRM (Customer Relationship Management) systems for both Fortune 500 companies and Small and Medium Sized Enterprises (SMEs). Hopkins specializes in systems analysis; data modeling; user interface design and project management in the development B2B Web Portals; servicing centralized call center operations; distributed retail and wholesale/broker-based business. He has been entrusted to develop multiple projects with eight figure investment portfolios.                                                                                                                                                                                             Hopkins said “I am elated to be working with such an impressive team of individuals and look forward to working with our Provider and Agent Partners in the near future.”                                                                                                                                                                                              Hopkins holds an MBA degree from The University of Chicago Booth School of Business; a top-five program in the United States and the Midwestern powerhouse of finance; banking and economics. In addition; he has served as an adjunct professor of marketing in the undergraduate business division of his alma mater; Pepperdine University.                                                                                                                                                                                             To contact Jeremy Hopkins directly; please reach him at 310.456.2200 or via e-mail JHopkins@wtgcom.com. For more information about WTG please go to www.worldtelecomgroup.com.                                                                                                                                                                                             About World Telecom Group                                                                                                                                                                                             World Telecom Group (WTG) is a premier Master Agent providing exceptional service to agent partners since 1996. WTG has the most diverse portfolio in the industry with over 100 Providers; including local; long-distance; data and internet. It also includes the following specialty Divisions with dedicated extra support: LEC; award winning Wireless/Mobility; Equipment; Wholesale; Cost Containment (TEM; Logistics and all other Cost Containment) and Energent; its extremely fast growing Energy Division (Electricity; Natural Gas and DSM). WTG Agents have the ability to sell and consistently expand their business without commitments or quotas. WTG is 100% partner driven and pays top commissions in the industry. WTG exceeds expectations with a dynamic approach to automation; partner support and its commitment to success.                                                                                                                                                                                             Press Contact:                                                                                                                                                                                             Salwa Scarpone                                                                                                                                                                                             sscarpone@wtgcom.com                                                                                                                                                                                             310.456.2200</td>\n							</tr>\n							<tr>\n								<td align="left"> Short URL:</td>\n								<td align="left">http://bit.ly/8Xe0rF</td>\n							</tr>\n							<tr>\n								<td align="left"> What Happened:</td>\n								<td align="left">World Telecom Group appointed Jeremy Hopkins as Chief Information Officer</td>\n							</tr>\n							<tr>\n								<td align="left"> About Person:</td>\n								<td align="left">Jeremy Hopkins is an accomplished consultant in delivering highly effective Sales Force Automation (SFA) technology applications. In addition to over 12 years of technology management consulting experience spanning North America; Asia and Europe; he has built up seven years of targeted expertise in deploying CRM (Customer Relationship Management) systems for both Fortune 500 companies and Small and Medium Sized Enterprises (SMEs).  Hopkins holds an MBA degree from The University of Chicago Booth School of Business.</td>\n							</tr>\n							<tr>\n								<td align="left"> About Company:</td>\n								<td align="left">World Telecom Group (WTG) is a premier Master Agent providing exceptional service to agent partners since 1996. WTG has the most diverse portfolio in the industry with over 100 Providers; including local; long-distance; data and internet. It also includes the following specialty Divisions with dedicated extra support: LEC; award winning Wireless/Mobility; Equipment; Wholesale; Cost Containment (TEM; Logistics and all other Cost Containment) and Energent; its extremely fast growing Energy Division (Electricity; Natural Gas and DSM). WTG Agents have the ability to sell and consistently expand their business without commitments or quotas. WTG is 100% partner driven and pays top commissions in the industry. WTG exceeds expectations with a dynamic approach to automation; partner support and its commitment to success.</td>\n							</tr>\n							<tr>\n								<td align="left"> More Link:</td>\n								<td align="left">http://www.worldtelecomgroup.com/?p=318</td>\n							</tr>\n							<tr>\n								<td align="left" colspan="2">&nbsp;</td>\n							</tr></table>', '1283196304');

-- --------------------------------------------------------

--
-- Table structure for table `cto_alert_without_login`
--

DROP TABLE IF EXISTS `cto_alert_without_login`;
CREATE TABLE IF NOT EXISTS `cto_alert_without_login` (
  `session_id` varchar(100) NOT NULL,
  `alert_id` int(11) NOT NULL,
  `add_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cto_alert_without_login`
--

INSERT INTO `cto_alert_without_login` VALUES('ec8c006b36e8d8d54ab512d29a6bb395', 14, '2010-06-08');
INSERT INTO `cto_alert_without_login` VALUES('063ce8c0a51984499a0a492f0b4859a1', 15, '2010-06-10');
INSERT INTO `cto_alert_without_login` VALUES('063ce8c0a51984499a0a492f0b4859a1', 16, '2010-06-10');

-- --------------------------------------------------------

--
-- Table structure for table `cto_autoresponders`
--

DROP TABLE IF EXISTS `cto_autoresponders`;
CREATE TABLE IF NOT EXISTS `cto_autoresponders` (
  `auto_id` int(11) NOT NULL auto_increment,
  `type` varchar(10) NOT NULL,
  `autoresponder_for` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `body1` text NOT NULL,
  `link_caption` varchar(255) NOT NULL,
  `body2` text NOT NULL,
  PRIMARY KEY  (`auto_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `cto_autoresponders`
--

INSERT INTO `cto_autoresponders` VALUES(1, 'User', 'successful registration of a new user', 'Successful subscription to CTOsOnTheMove', 'Congratulations! You are now subscribed to CTOsOnTheMove.com - welcome on board!', 'Click to validate your email', '');
INSERT INTO `cto_autoresponders` VALUES(2, 'User', 'user forgot login/password', 'CTOsOnTheMove - your password ', 'Here is the login/password you were looking for: ', '', '');
INSERT INTO `cto_autoresponders` VALUES(3, 'User', 'user updated profile', 'CTOsOnTheMove - your profile has been updated', 'This is just a notification that your profile has been changed', '', '');
INSERT INTO `cto_autoresponders` VALUES(4, 'User', 'user submitted a credit card for subscription', 'CTOsOnTheMove - subscription fee received', 'Your subscription has been processed successfully', '', '');
INSERT INTO `cto_autoresponders` VALUES(5, 'User', 'user submitted a credit card for alert', 'CTOsOnTheMove - your subscription received', 'Your subscription has been processed successfully', '', '');
INSERT INTO `cto_autoresponders` VALUES(6, 'User', 'user set up an alert', 'CTOsOnTheMove - your alert is set', 'Thank you for setting up an alert, make sure you whitelist the email address so it does not end up in the spam folder', '', '');
INSERT INTO `cto_autoresponders` VALUES(7, 'User', 'user renewed the subscription', 'CTOsOnTheMove - your subscription was successfully renewed', 'Your subscription has been renewed successfully', '', '');
INSERT INTO `cto_autoresponders` VALUES(8, 'User', '1 week before free trial expiration', 'CTOsOnTheMove - 1 week before free trial expiration', 'Your free trial is about to expire, ', 'click here to sign up for paid subscription', ', it is only $85/month and you can cancel anytime');
INSERT INTO `cto_autoresponders` VALUES(9, 'User', 'free trial expired', 'CTOsOnTheMove - free trial expired', 'Your free trial has expired,', 'click here to sign up for paid subscription edit', ', it is only $85/month and you can cancel anytime. If you sign up in the next 24 hours we will send you a rebate check of 50% percent of your first month payment');
INSERT INTO `cto_autoresponders` VALUES(10, 'User', '2 weeks prior to subscription expiration', 'CTOsOnTheMove - your subscription is about to expire', 'click here to renew your subscription', 'click here to renew your subscription', 'it is only $85/month and you can cancel anytime.');
INSERT INTO `cto_autoresponders` VALUES(11, 'User', 'subscription expired', 'CTOsOnTheMove - your subscription expired', 'Your subscription has expired, ', 'click here to renew your subscription', ', it is only $85/month and you can cancel anytime.');
INSERT INTO `cto_autoresponders` VALUES(12, 'User', '2 months prior to expiration of the credit card on file', '2 months prior to expiration of the credit card on file', 'You credit card on file is about to expire, to ensure continuation of service, please update your file with a new valid credit card.', '', '');
INSERT INTO `cto_autoresponders` VALUES(13, 'Admin', 'New user registered', 'New user registered', 'new user registered', '', '');
INSERT INTO `cto_autoresponders` VALUES(14, 'Admin', 'User canceled registration', 'User canceled registration', 'user cancelled registration,', '', '');
INSERT INTO `cto_autoresponders` VALUES(15, 'Admin', 'User attempted to concurrently login with the same login/password', 'User attempted to concurrently login with the same login/password', 'concurrent  login attempt', '', '');
INSERT INTO `cto_autoresponders` VALUES(16, 'Admin', '2 months prior to expiration of user credit card on file', 'User credit card is about to expire', 'User credit card is about to expire', '', '');
INSERT INTO `cto_autoresponders` VALUES(17, 'Admin', '1 week before free trial expiration', '1 week before free trial expiration', 'Free subscription will be expired, which user', '', '');
INSERT INTO `cto_autoresponders` VALUES(18, 'Admin', 'free trial expired', 'free trial expired', 'Free subscription is expired, which user', '', '');
INSERT INTO `cto_autoresponders` VALUES(19, 'Admin', '2 weeks prior to subscription expiration', '2 weeks prior to subscription expiration', 'Subscription will be expiration, which user', '', '');
INSERT INTO `cto_autoresponders` VALUES(20, 'Admin', 'subscription expired', 'subscription expired', 'subscription is expired, which user', '', '');
INSERT INTO `cto_autoresponders` VALUES(21, 'Admin', 'user submitted a credit card for subscription', 'user submitted a credit card for subscription', 'Payment received for subscription', '', '');
INSERT INTO `cto_autoresponders` VALUES(22, 'Admin', 'user set up an alert', 'user set up an alert', 'user set up an alert', '', '');
INSERT INTO `cto_autoresponders` VALUES(23, 'Admin', 'user submitted a credit card for alert', 'user submitted a credit card for alert', 'user submitted a credit card for alert', '', '');
INSERT INTO `cto_autoresponders` VALUES(24, 'Admin', 'user updated profile', 'user updated profile', 'user updated profile', '', '');
INSERT INTO `cto_autoresponders` VALUES(25, 'Admin', 'user renewed the subscription', 'user renewed the subscription', 'user renewed the subscription', '', '');
INSERT INTO `cto_autoresponders` VALUES(26, 'User', 'User canceled registration', 'CTOsOnTheMove - your subscription was canceled', 'This is just to confirm that your subscription to CTOsOnTheMove.com was canceled.', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cto_banner`
--

DROP TABLE IF EXISTS `cto_banner`;
CREATE TABLE IF NOT EXISTS `cto_banner` (
  `id` int(11) NOT NULL auto_increment,
  `image_path` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cto_banner`
--

INSERT INTO `cto_banner` VALUES(1, 'logo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cto_billing_address`
--

DROP TABLE IF EXISTS `cto_billing_address`;
CREATE TABLE IF NOT EXISTS `cto_billing_address` (
  `bill_id` int(11) NOT NULL auto_increment,
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address_cont` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `add_date` date NOT NULL,
  `modify_date` date NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `level` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY  (`bill_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `cto_billing_address`
--

INSERT INTO `cto_billing_address` VALUES(1, 9, 1, 'ABC INFOTECH', '1 Main St', 'Garia', 'San+Jose', 'CA', '95131', 'United States', '2010-05-10', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(2, 10, 2, 'ABC INFOTECH', '1 Main St', 'Garia', 'San+Jose', 'CA', '95131', 'United States', '2010-05-10', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(3, 11, 3, 'ABC INFOTECH', '1 Main St', 'Garia', 'San+Jose', 'CA', '95131', 'United States', '2010-05-10', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(4, 12, 4, 'ABC Co.', '1 Main St', 'Garia', 'San+Jose', 'CA', '95131', 'United States', '2010-05-11', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(5, 13, 4, 'ABC Co.', '1 Main St', 'Garia', 'San%2BJose', 'CA', '95131', 'United States', '2010-05-12', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(6, 14, 4, 'ABC Co.', '1 Main St', 'Garia', 'San%2BJose', 'CA', '95131', 'United States', '2010-05-12', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(7, 15, 6, 'ABC Co.', '1 Main St', 'Garia', 'San+Jose', 'CA', '95131', 'United States', '2010-05-13', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(8, 16, 6, 'ABC Co.', '1 Main St', 'Garia', 'San%2BJose', 'CA', '95131', 'United States', '2010-05-17', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(9, 17, 6, 'ABC Co.', '1 Main St', 'Garia', 'San%2BJose', 'CA', '95131', 'United States', '2010-05-24', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(10, 18, 6, 'ABC Co.', '1 Main St', 'Garia', 'San%2BJose', 'CA', '95131', 'United States', '2010-05-24', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(11, 19, 8, 'ABC Co.', 'Arabinda Pallee,Kolkata - 84', 'Type in the Address (Cont)', 'San+Jose', 'CA', '95131', 'United States', '2010-05-24', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(12, 20, 15, 'ABC Co.', '1 Main St', 'Garia', 'Kolkata', 'CA', '95131', 'United States', '2010-06-08', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(13, 21, 16, 'ABC Co.', '1 Main St', 'Garia', 'Kolkata', 'CA', '95131', 'United States', '2010-06-08', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(14, 22, 17, 'ABC Co.', '1 Main St', 'Garia', 'Kolkata', 'CA', '95131', 'United States', '2010-06-08', '0000-00-00', 'ec8c006b36e8d8d54ab512d29a6bb395', '', '');
INSERT INTO `cto_billing_address` VALUES(15, 23, 17, 'ABC Co.', '1 Main St', 'Garia', 'Kolkata', 'CA', '95131', 'United States', '2010-06-08', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(16, 24, 25, 'Abc info', '1 Main St', 'kolkata', 'San+Jose', 'CA', '95131', 'United States', '2010-06-14', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(17, 25, 24, 'ABC Co.', '1 Main St', 'Kolkata', 'San+Jose', 'CA', '95131', 'United States', '2010-06-14', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(18, 26, 26, 'ABC Co.', '1 Main St', 'Kolkata', 'San+Jose', 'CA', '95131', 'United States', '2010-06-14', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(19, 27, 26, 'ABC Co.', '1 Main St', 'Kolkata', 'San%2BJose', 'CA', '95131', 'United States', '2010-06-14', '0000-00-00', 'e930e44163a04251190e1e1f29de0035', '', '');
INSERT INTO `cto_billing_address` VALUES(20, 28, 26, 'ABC Co.', '1 Main St', 'Kolkata', 'San%2BJose', 'CA', '95131', 'United States', '2010-06-14', '0000-00-00', '11fd85ba3d0a15eceb075a7812ce2412', '', '');
INSERT INTO `cto_billing_address` VALUES(21, 29, 26, 'ABC Co.', '1 Main St', 'Kolkata', 'San%2BJose', 'CA', '95131', 'United States', '2010-06-14', '0000-00-00', '11fd85ba3d0a15eceb075a7812ce2412', '', '');
INSERT INTO `cto_billing_address` VALUES(22, 30, 26, 'ABC Co.', '1 Main St', 'Kolkata', 'San%2BJose', 'CA', '95131', 'United States', '2010-06-14', '0000-00-00', 'a6aa253f424e15e1a5901b5cff7afce5', '', '');
INSERT INTO `cto_billing_address` VALUES(23, 31, 36, 'ABC INFOTECH', '1 Main St', 'Garia', 'Kolkata', 'CA', '95131', 'US', '2010-07-01', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(24, 32, 38, 'ABC Co.', '1 Main St', 'Garia', 'San+Jose', 'CA', '95131', 'US', '2010-07-02', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(25, 33, 38, 'ABC Co.', '1 Main St', 'Garia', 'San%2BJose', 'CA', '95131', 'US', '2010-07-02', '0000-00-00', 'r8tovbgcn0ph6u23qt6ss5vab6', '', '');
INSERT INTO `cto_billing_address` VALUES(26, 34, 38, 'ABC Co.', '1 Main St', 'Garia', 'San%2BJose', 'CA', '95131', 'US', '2010-07-02', '0000-00-00', 'r8tovbgcn0ph6u23qt6ss5vab6', '', '');
INSERT INTO `cto_billing_address` VALUES(27, 35, 39, 'ABC INFOTECH', '1 Main St', 'Garia', 'Kolkata', 'CA', '95131', '', '2010-07-02', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(28, 36, 42, '', '303 E 57th st 12C', '', 'New+York', 'NY', '10022', '', '2010-07-06', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(29, 37, 44, 'ABC Co.', '1 Main St', 'Garia', 'Kolkata', 'CA', '95131', '', '2010-07-08', '0000-00-00', 'fis2es1lltmk6pp4v6178lt0v3', '', '');
INSERT INTO `cto_billing_address` VALUES(30, 38, 0, 'ABC Info', '1 Main St', 'Garia', 'Kolkata', 'CA', '95131', '', '2010-07-26', '0000-00-00', '01ce21llrsa92hj0t30k9c49j4', '', '');
INSERT INTO `cto_billing_address` VALUES(31, 39, 55, 'ANXeBusiness Corp. ', '1 Main St', '', 'Kolkata', 'CA', '95131', '', '2010-08-25', '0000-00-00', '', '', '');
INSERT INTO `cto_billing_address` VALUES(32, 40, 55, 'ANXeBusiness Corp. ', '1 Main St', '', 'Kolkata', 'CA', '95131', '', '2010-08-25', '0000-00-00', 'cf8ge1iap5gglksrgvdd9a28h1', '', '');
INSERT INTO `cto_billing_address` VALUES(33, 41, 55, 'ANXeBusiness Corp. ', '1 Main St', '', 'Kolkata', 'CA', '95131', '', '2010-08-25', '0000-00-00', 'cf8ge1iap5gglksrgvdd9a28h1', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cto_card_info`
--

DROP TABLE IF EXISTS `cto_card_info`;
CREATE TABLE IF NOT EXISTS `cto_card_info` (
  `card_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `number` varchar(30) NOT NULL,
  `exp_month` int(2) NOT NULL,
  `exp_year` int(4) NOT NULL,
  `security_code` varchar(10) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  PRIMARY KEY  (`card_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `cto_card_info`
--

INSERT INTO `cto_card_info` VALUES(1, 1, 9, 'Visa', '4806015924385178', 4, 2012, '962', '');
INSERT INTO `cto_card_info` VALUES(2, 2, 10, 'Visa', '4806015924385178', 5, 2014, '962', '');
INSERT INTO `cto_card_info` VALUES(3, 3, 11, 'Visa', '4806015924385178', 5, 2013, '962', '');
INSERT INTO `cto_card_info` VALUES(4, 4, 12, 'Visa', '4806015924385178', 5, 2014, '962', '');
INSERT INTO `cto_card_info` VALUES(5, 4, 13, 'Visa', '4806015924385178', 5, 2014, '962', '');
INSERT INTO `cto_card_info` VALUES(6, 4, 14, 'Visa', '4806015924385178', 5, 2014, '962', '');
INSERT INTO `cto_card_info` VALUES(7, 6, 15, 'Visa', '4806015924385178', 5, 2013, '962', '');
INSERT INTO `cto_card_info` VALUES(8, 6, 16, 'Visa', '4806015924385178', 5, 2013, '962', '');
INSERT INTO `cto_card_info` VALUES(9, 6, 17, 'Visa', '4806015924385178', 7, 2010, '962', '');
INSERT INTO `cto_card_info` VALUES(10, 6, 18, 'Visa', '4806015924385178', 7, 2010, '962', '');
INSERT INTO `cto_card_info` VALUES(11, 8, 19, 'Visa', '4806015924385178', 5, 2012, '962', '');
INSERT INTO `cto_card_info` VALUES(12, 15, 20, 'Visa', '4296885442880562', 5, 2014, '962', '');
INSERT INTO `cto_card_info` VALUES(13, 16, 21, 'Visa', '4641595351938390', 4, 2013, '962', '');
INSERT INTO `cto_card_info` VALUES(14, 17, 22, 'Visa', '4641595351938390', 5, 2014, '962', 'ec8c006b36e8d8d54ab512d29a6bb395');
INSERT INTO `cto_card_info` VALUES(15, 17, 23, 'Visa', '4806015924385178', 4, 2013, '962', '');
INSERT INTO `cto_card_info` VALUES(16, 25, 24, 'Visa', '4130731477084870', 4, 2012, '962', '');
INSERT INTO `cto_card_info` VALUES(17, 24, 25, 'Visa', '4101854843863424', 4, 2014, '962', '');
INSERT INTO `cto_card_info` VALUES(18, 26, 26, 'Visa', '4487872602501898', 4, 2015, '962', '');
INSERT INTO `cto_card_info` VALUES(19, 26, 27, 'Visa', '4487872602501898', 4, 2015, '962', 'e930e44163a04251190e1e1f29de0035');
INSERT INTO `cto_card_info` VALUES(20, 26, 28, 'Visa', '4487872602501898', 4, 2015, '962', '11fd85ba3d0a15eceb075a7812ce2412');
INSERT INTO `cto_card_info` VALUES(21, 26, 29, 'Visa', '4487872602501898', 4, 2015, '962', '11fd85ba3d0a15eceb075a7812ce2412');
INSERT INTO `cto_card_info` VALUES(22, 26, 30, 'Visa', '4487872602501898', 4, 2015, '962', 'a6aa253f424e15e1a5901b5cff7afce5');
INSERT INTO `cto_card_info` VALUES(23, 36, 31, 'Visa', '4654422255559939', 4, 2012, '962', '');
INSERT INTO `cto_card_info` VALUES(24, 38, 32, 'Visa', '4568772367896545', 4, 2012, '962', '');
INSERT INTO `cto_card_info` VALUES(25, 38, 33, 'Visa', '4568772367896545', 4, 2012, '962', 'r8tovbgcn0ph6u23qt6ss5vab6');
INSERT INTO `cto_card_info` VALUES(26, 38, 34, 'Visa', '4568772367896545', 4, 2012, '962', 'r8tovbgcn0ph6u23qt6ss5vab6');
INSERT INTO `cto_card_info` VALUES(27, 39, 35, 'Visa', '4568772367896545', 4, 2014, '962', '');
INSERT INTO `cto_card_info` VALUES(28, 42, 36, 'Visa', '4266841189637406', 9, 2011, '295', '');
INSERT INTO `cto_card_info` VALUES(29, 44, 37, 'Visa', '4839707106272429', 5, 2012, '962', 'fis2es1lltmk6pp4v6178lt0v3');
INSERT INTO `cto_card_info` VALUES(30, 0, 38, 'Visa', '4032419407585500', 4, 2012, '962', '01ce21llrsa92hj0t30k9c49j4');
INSERT INTO `cto_card_info` VALUES(31, 55, 39, 'Visa', '4956211807005151', 3, 2012, '962', '');
INSERT INTO `cto_card_info` VALUES(32, 55, 40, 'Visa', '4956211807005151', 3, 2012, '962', 'cf8ge1iap5gglksrgvdd9a28h1');
INSERT INTO `cto_card_info` VALUES(33, 55, 41, 'Visa', '4956211807005151', 3, 2012, '962', 'cf8ge1iap5gglksrgvdd9a28h1');

-- --------------------------------------------------------

--
-- Table structure for table `cto_contact`
--

DROP TABLE IF EXISTS `cto_contact`;
CREATE TABLE IF NOT EXISTS `cto_contact` (
  `contact_id` int(11) NOT NULL auto_increment,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `new_title` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `contact_url` varchar(255) NOT NULL,
  `company_website` varchar(200) NOT NULL,
  `company_revenue` varchar(50) NOT NULL,
  `company_employee` varchar(50) NOT NULL,
  `company_industry` varchar(100) NOT NULL,
  `ind_group_id` int(11) NOT NULL,
  `industry_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `city` varchar(150) NOT NULL,
  `state` varchar(150) NOT NULL,
  `country` varchar(150) NOT NULL,
  `zip_code` varchar(50) NOT NULL,
  `announce_date` date NOT NULL,
  `effective_date` date NOT NULL,
  `source` varchar(255) NOT NULL,
  `headline` varchar(255) NOT NULL,
  `full_body` text NOT NULL,
  `short_url` varchar(255) NOT NULL,
  `movement_type` varchar(100) NOT NULL,
  `what_happened` text NOT NULL,
  `about_person` text NOT NULL,
  `about_company` text NOT NULL,
  `more_link` varchar(255) NOT NULL,
  `add_date` date NOT NULL,
  `modify_date` date NOT NULL,
  `publish` int(11) NOT NULL default '0',
  `create_by` varchar(50) NOT NULL default 'Admin',
  `status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`contact_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=195 ;

--
-- Dumping data for table `cto_contact`
--

INSERT INTO `cto_contact` VALUES(1, 'Tony', '', 'Ali', 'Chief Technology Officer', 'tonya@bkv.com', '404.233.0332', 'BKV', 'Tony-Ali-Appointed-CTO-at-BKV', 'www.bkv.com', '0', '0', 'Business Services Other', 7, 17, '3390 Peachtree Rd 10th Fl', '', 'Atlanta', 'GA', '', '30305', '2010-02-04', '2010-02-04', '', 'Ali Appointed Senior VP, Chief Technology Officer at BKV', 'Ali Appointed Senior VP, Chief Technology Officer at BKV, Please change the content', '', 'Appointment', '', '', '', '', '0000-00-00', '2010-07-12', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(2, 'Mike', '', 'Brook', 'Chief Information Officer', 'michael.brook@viterra.ca', '204.954.1500', 'Viterra', 'Mike-Brook-Appointed-CIO-at-Viterra', 'www.viterra.ca', '0', '0', 'Mining & Quarrying', 1, 5, 'I19962', '', 'Regina', 'MB', '', ' S4T 7T9', '2010-02-26', '2010-02-26', '', 'Canada - New appointment at Viterra', 'Canada - New appointment at Viterra\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(3, 'Leon', '', 'Rudakov', 'Chief Technology Officer', 'n/a', '206.963.4519', 'ARTVENTIVE MEDICAL GROUP', 'Leon-Rudakov-Appointed-CTO-at-ARTVENTIVE-MEDICAL-GROUP', '', '0', '0', 'Mining & Quarrying', 1, 5, 'Suite 107 17624 15th Avenue', '', 'Mill Creek', 'WA', '', '98012', '2010-02-11', '2010-02-11', '', 'FORM 8-K', 'FORM 8-K\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(4, 'Jeff', '', 'Bell', 'Chief Information Officer', 'jeff.bell@phh.com', '800.449.8767', 'PHH Corporation', 'Jeff-Bell-Appointed-CIO-at-PHH-Corporation', 'www.phh.com', '0', '0', 'Business Services Other', 7, 17, '1 Mortgage Way', '', 'Mount Laurel', 'NJ', '', '8054', '2010-02-19', '2010-02-19', '', 'PHH Corporation Names Jeff S. Bell Chief Information Officer', 'PHH Corporation Names Jeff S. Bell Chief Information Officer\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(5, 'Joe', '', 'Brewer', 'Chief Information Officer', 'joe.brewer@katz-media.com', '212.424.6000', 'Katz Media Group', 'Joe-Brewer-Promoted-To-CIO-at-Katz-Media-Group', 'www.katz-media.com', '0', '0', 'Business Services Other', 7, 17, '125 W 55th St', '', 'New York', 'NY', '', '10019', '2010-02-23', '2010-02-23', '', 'Joe Brewer Rises At Katz Media Group', 'Joe Brewer Rises At Katz Media Group\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(6, 'Elizabeth', '', 'Cummings', 'Chief Information Officer', 'ecummings@pvtb.com', '312.683.7100', 'PrivateBancorp', 'Elizabeth-Cummings-Promoted-To-CIO-at-PrivateBancorp', 'www.pvtb.com', '0', '0', 'Business Services Other', 7, 17, '70 W Madison St', '', 'Chicago', 'IL', '', '60602', '2010-02-24', '2010-02-24', '', 'PrivateBancorp Names New Treasurer, CIO and CTO', 'PrivateBancorp Names New Treasurer, CIO and CTO\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(7, 'Sytze', '', 'Koopmans', 'Chief Information Officer', 'sytze.koopmans@dhv.com', '31 33 468 37 00', 'DHV Group', 'Sytze-Koopmans-Appointed-CIO-at-DHV-Group', 'www.dhv.com', '0', '0', 'Business Services Other', 7, 17, 'Laan 1914 no 35', '', 'Amersfoort', '', '', '0', '2010-01-28', '2010-01-28', '', 'Sytze Koopmans appointed DHV Group Chief Information Officer', 'Sytze Koopmans appointed DHV Group Chief Information Officer\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(8, 'Jorge', '', 'Sauri', 'Chief Information Officer', 'support@mortgagedashboard.com', '800.209.8812', 'MortgageDashboard', 'Jorge-Sauri-Promoted-To-CIO-at-MortgageDashboard', 'www.MortgageDashboard.com', '0', '0', 'Business Services Other', 7, 17, '3818 EX Amersfoort', '', 'Plano', 'TX', '', '75024', '2010-02-19', '2010-02-19', '', 'Catalizador Private Equity Fund announces acquisition of MortgageDashboard', 'Catalizador Private Equity Fund, a team of venture capitalists that includes Jim McMahan, Stewart Hunter and Bryan Harlan of Benchmark Mortgage and other significant Texas-based business partners, has announced the completed acquisition of MortgageDashboard, a leading on-demand loan origination software system enabling paperless mortgage processing for lenders, credit unions and banks. Catalizador took control of MortgageDashboard last fall when the technology firm lost an important line of credit and was on the brink of insolvency\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '2010-07-24', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(9, 'Mugunth', '', 'Vaithylingam', 'Chief Information Officer ', 'mugunth.vaithylingam@sungardhe.com', '610.647.5930', 'Sungard Higher Education', 'Mugunth-Vaithylingam-Appointed-CIO-at-Sungard-Higher-Education', 'www.sungardhe.com', '0', '0', 'Business Services Other', 7, 17, 'P.O. Box 219', '', 'Malvern', 'PA', '', '19355', '2009-11-21', '2009-11-21', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(10, 'James', '', 'Bennett ', 'Chief Technology Officer', 'jbennett@pvtb.com', '312.683.7100', 'PrivateBancorp', 'James-Bennett -Promoted-To-CTO-at-PrivateBancorp', 'www.pvtb.com', '0', '0', 'Business Services Other', 7, 17, '3800 AE', '', 'Chicago', 'IL', '', '60602', '2010-02-24', '2010-02-24', '', 'PrivateBancorp Names New Treasurer, CIO and CTO', 'PrivateBancorp Names New Treasurer, CIO and CTO\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(11, 'Robert', '', 'Grover', 'Chief Technology Officer', 'help@edventures.com', '208.343.3110', 'PCS Edventures', 'Robert-Grover-Promoted-To-CTO-at-PCS-Edventures', 'www.edventures.com', '0', '0', 'Business Services Other', 7, 17, '345 W Bobwhite Ct', '', 'Boise', 'ID', '', '83706', '2010-02-26', '2010-02-26', '', 'Robert Grover Promoted to President, Chief Operating Officer and Chief Technology Officer at PCS Edventures', 'Robert Grover Promoted to President, Chief Operating Officer and Chief Technology Officer at PCS Edventures\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(12, 'Adrian', '', 'Hawkins', 'Chief Technology Officer', 'adrian.hawkins@kuju.com', '44.01483414', 'Kuju Entertainment', 'Adrian-Hawkins-Appointed-CTO-at-Kuju-Entertainment', 'www.kuju.com', '0', '0', 'Business Services Other', 7, 17, 'Unit 10 Woodside Park Catteshall Ln Golaming', '', 'Surrey', '', '', ' GU7 1LG', '2010-02-04', '2010-02-04', '', 'Kuju Entertainment appoints Adrian Hawkins as new board member and Chief Technical Officer (CTO)', 'Kuju Entertainment appoints Adrian Hawkins as new board member and Chief Technical Officer (CTO)\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(13, 'Chris', '', 'Nicotra', 'Chief Technology Officer', 'cnicotra@comscore.com', '703.438.2000', 'ComScore', 'Chris-Nicotra-Appointed-CTO-at-ComScore', 'www.comscore.com', '0', '0', 'Business Services Other', 7, 17, '11950 Democracy Dr', '', 'Reston', 'VA', '', '20190', '2010-02-08', '2010-02-08', '', 'comScore Announces Appointment of Chris Nicotra as Chief Technology Officer', 'comScore Announces Appointment of Chris Nicotra as Chief Technology Officer\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(14, 'Simon', '', 'Raik-Allen', 'Chief Technology Officer', 'simonr@myob.com', '973.586.2229', 'MYOB', 'Simon-Raik-Allen-Appointed-CTO-at-MYOB', 'www.myob.com', '0', '0', 'Business Services Other', 7, 17, '300 Round Hill Dr', '', 'Rockaway', 'NJ', '', '7866', '2010-02-19', '2010-02-19', '', 'MYOB strengthens executive team', 'MYOB strengthens executive team\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(15, 'Alok', '', 'Saxena', 'Chief Technology Officer', 'asaxena@elemica.com', '610.786.1200', 'Elemica', 'Alok-Saxena-Appointed-CTO-at-Elemica', 'www.elemica.com', '0', '0', 'Business Services Other', 7, 17, '1200 Liberty Ridge Dr Ste 120', '', 'Chesterbrook', 'PA', '', '19087', '2010-02-04', '2010-02-04', '', 'New Management Team at Elemica Following Merger With RubberNetwork', 'New Management Team at Elemica Following Merger With RubberNetwork\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(16, 'Abdallah', '', 'Shanti', 'Chief Technology Officer', 'shantia@anx.com', '248.263.3400', 'ANXeBusiness Corp.', 'Abdallah-Shanti-Appointed-CTO-at-ANXeBusiness-Corp.', 'www.anx.com', '$1-10 Million', '0-25', 'Business Services Other', 7, 17, '2000 Prudential Town Ctr 2000 Town Ctr Ste 2050', '', 'Southfield', 'MI', 'AFG', '48075', '2010-02-18', '2010-02-18', '', 'ANXeBusiness Expands Executive Team With New CTO ', 'ANXeBusiness Expands Executive Team With New CTO \r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '2010-08-24', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(17, 'Georg', '', 'Westin', 'Chief Technology Officer', 'georg@betsafe.com', '0', 'Betsafe.com', 'Georg-Westin-Appointed-CTO-at-Betsafe.com', 'www.betsafe.com', '0', '0', 'Business Services Other', 7, 17, 'The Penthouse, 122 Home Space Building, Quarries Street', '', 'St Venera', '', '', 'SVR 1755', '2010-02-19', '2010-02-19', '', 'We’re expanding and welcome Georg as our new CTO', 'We’re expanding and welcome Georg as our new CTO\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(18, 'Shijun', '', 'Zeng', 'Chief Technology Officer', 'jun.zeng@shiperptech.com', '317.824.0393', 'Perpetual Technologies', 'Shijun-Zeng-Appointed-CTO-at-Perpetual-Technologies', 'www.perptech.com', '0', '0', 'Business Services Other', 7, 17, '9155 Harrison Park Ct', '', 'Indianapolis', 'IN', '', '46216', '2010-02-12', '2010-02-12', '', 'FORM 8-K', 'FORM 8-K\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(19, 'Ryan ', '', 'Reineke ', 'Senior Vice President of Operations & Technology', 'rreineke@cambridgeinvestmentresearch.com', '44.12233035', 'Cambridge Investment Research', 'Ryan -Reineke -Promoted-To-SVPOT-at-Cambridge-Investment-Research', 'www.cambridgeinvestmentresearch.com', '0', '0', 'Business Services Other', 7, 17, '1 Fenners Lawn', '', 'Cambridge', '', '', ' CB1 2EH', '2010-02-02', '2010-02-02', '', 'Cambridge Names Reineke as Senior Vice President of Operations & Technology and Jerry Oliver as Vice President & Chief Financial Officer , Gary Gagnon Named Vice President of Technology ', 'Cambridge Names Reineke as Senior Vice President of Operations & Technology and Jerry Oliver as Vice President & Chief Financial Officer , Gary Gagnon Named Vice President of Technology \r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(20, 'Alan', '', 'Holsztynski', 'Senior Vice President, Information Technology', 'aholsztynski@coletaylor.com', '847.653.7978', 'Taylor Capital', 'Alan-Holsztynski-Appointed-SVPIT-at-Taylor-Capital', 'www.coletaylor.com', '0', '0', 'Business Services Other', 7, 17, '9550 W Higgins Rd', '', 'Rosemont', 'IL', '', '60018', '2010-02-18', '2010-02-18', '', 'FORM 8-K', 'FORM 8-K\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(21, 'William', '', 'Hobbins', 'Special Advisor', 'william.hobbins@digitalreasoning.com', '615.298.8595 x225', 'Digital Reasoning® Systems Inc.', 'William-Hobbins-Appointed-SA-at-Digital-Reasoning®-Systems-Inc.', 'www.digitalreasoning.com', '0', '0', 'Business Services Other', 7, 17, '155 Franklin Rd Ste 225', '', 'Brentwood', 'TN', '', '37027', '2010-02-08', '2010-02-08', '', 'Former U.S. Air Force Chief Information Officer Joins Digital Reasoning as Special Advisor', 'Former U.S. Air Force Chief Information Officer Joins Digital Reasoning as Special Advisor\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(22, 'Mark', '', 'Kelly', 'Vice President of IT', 'mark@networkhardware.com', '805.964.9975', 'Network Hardware Resale', 'Mark-Kelly-Appointed-VPIT-at-Network-Hardware-Resale', 'www.networkhardware.com', '0', '0', 'Business Services Other', 7, 17, '26 Castilian Dr Ste A', '', 'Goleta', 'CA', '', '93117', '2010-02-19', '2010-02-19', '', 'Network Hardware Resale Appoints Mark V. Kelly Vice President of IT', 'Network Hardware Resale Appoints Mark V. Kelly Vice President of IT\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(23, 'Steven', '', 'Gearhart ', 'Chief Information Officer', 'steven.gearhart@plexus.com', '920.722.3451', 'Plexus', 'Steven-Gearhart -Appointed-CIO-at-Plexus', 'www.plexus.com', '0', '0', 'Computers & Electronics Other', 18, 29, '55 Jewelers Park Dr', '', 'Neenah', 'WI', '', '54956', '2010-02-03', '2010-02-03', '', 'Plexus Corp. in Neenah names Steve Gearhart chief information officer', 'Plexus Corp. in Neenah names Steve Gearhart chief information officer\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(24, 'Aftkhar', '', 'Aslam', 'Chief Technology Officer', 'aaslam@yieldwerx.com', '866.438.6300', 'YieldWerx', 'Aftkhar-Aslam-Appointed-CTO-at-YieldWerx', 'www.yieldwerx.com', '0', '0', 'Computers & Electronics Other', 18, 29, '320 Decker Dr', '', 'Irving', 'TX', '', '75062', '2010-02-08', '2010-02-08', '', 'yieldWerx Semiconductor Test and Yield Enhancement Firm Appoints New Chief Technology Officer', 'yieldWerx Semiconductor Test and Yield Enhancement Firm Appoints New Chief Technology Officer\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(25, 'Jinfeng', '', 'Huang', 'Chief Technology Officer', 'n/a', '0', 'Deerfield Resources Ltd ', 'Jinfeng-Huang-Appointed-CTO-at-Deerfield-Resources-Ltd-', '', '0', '0', 'Computers & Electronics Other', 18, 29, 'Gottbetter & Partners, LLP, 488 Madison Avenue, ', '', 'New York', 'NY', '', '0', '2010-02-12', '2010-02-12', '', 'FORM 8-K', 'FORM 8-K\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(26, 'Greg', '', 'Millar', 'Chief Technology Officer', 'gmillar@pelco.com', '559.292.1981', 'Pelco', 'Greg-Millar-Appointed-CTO-at-Pelco', 'www.pelco.com', '0', '0', 'Computers & Electronics Other', 18, 29, '3500 Pelco Way', '', 'Clovis', 'CA', '', '93612', '2010-02-26', '2010-02-26', '', 'Pelco announces internal changes', 'Pelco announces internal changes\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(27, 'Naresh', '', 'Soni', 'Chief Technology Officer', 'naresh.soni@interdigital.com', '610.878.7800', 'InterDigital', 'Naresh-Soni-Promoted-To-CTO-at-InterDigital', 'www.interdigital.com', '0', '0', 'Computers & Electronics Other', 18, 29, '781 3rd Ave', '', 'King Of Prussia', 'PA', '', '19406', '2010-02-04', '2010-02-04', '', 'InterDigital Appoints Naresh Soni Chief Technology Officer', 'InterDigital Appoints Naresh Soni Chief Technology Officer\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(28, 'Bert', '', 'Vermeire ', 'Chief Technology Officer', 'bvermeire@spacemicro.com', '858.332.0700', 'Space Micro', 'Bert-Vermeire -Appointed-CTO-at-Space-Micro', 'www.spacemicro.com', '0', '0', 'Computers & Electronics Other', 18, 29, '10401 Roselle St Ste 400', '', 'San Diego', 'CA', '', '92121', '2010-02-11', '2010-02-11', '', 'On the move', 'On the move\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(29, 'Anthony', '', 'Welgemoed', 'Chief Technology Officer', 'contact.us@proofhq.com', '44.20813311', 'ProofHQ', 'Anthony-Welgemoed-Appointed-CTO-at-ProofHQ', 'www.proofhq.com', '0', '0', 'Computers & Electronics Other', 18, 29, '66 High St', '', 'Northwood', '', '', ' HA6 1BL', '2010-02-19', '2010-02-19', '', 'Anthony Welgemoed joins ProofHQ as CTO ', 'Anthony Welgemoed joins ProofHQ as CTO \r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(30, 'Ning', '', 'Zhu', 'Chief Technology Officer', 'nzhu@analogixsemi.com', '408.988.8848', 'Analogix Semiconductor', 'Ning-Zhu-Appointed-CTO-at-Analogix-Semiconductor', 'www.analogixsemi.com', '0', '0', 'Computers & Electronics Other', 18, 29, '3211 Scott Blvd Ste 102', '', 'Santa Clara', 'CA', '', '95054', '2010-02-19', '2010-02-19', '', 'Analogix Semiconductor Names Dr. Ning Zhu as Chief Technology Officer', 'Analogix Semiconductor Names Dr. Ning Zhu as Chief Technology Officer\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(31, 'Kent', '', 'Jackson', 'Director of Technology', 'kjackson@circadence.com', '303.413.8800', 'Circadence Corporation', 'Kent-Jackson-Appointed-DT-at-Circadence-Corporation', 'www.circadence.com', '0', '0', 'Computers & Electronics Other', 18, 29, '4888 Pearl East Cir', '', 'Boulder', 'CO', '', '80301', '2010-02-18', '2010-02-18', '', 'Circadence Corporation, Circadence Welcomes Kent Jackson as Director of Technology ', 'Circadence Corporation, Circadence Welcomes Kent Jackson as Director of Technology \r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(32, 'Dominick', '', 'Cavuoto', 'President of Technology', 'Dominick.Cavuoto@unisys.com', '215.986.4011', 'Unisys', 'Dominick-Cavuoto-Promoted-To-PT-at-Unisys', 'www.unisys.com', '0', '0', 'Computers & Electronics Other', 18, 29, '751 Jolly Rd', '', 'Blue Bell', 'PA', '', '19422', '2010-02-10', '2010-02-10', '', 'Unisys Names Dominick Cavuoto as President of Technology, Consulting and Integration Solutions Business ', 'Unisys Names Dominick Cavuoto as President of Technology, Consulting and Integration Solutions Business \r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(33, 'Jason', '', 'Richards', 'Vice President of Information Technology', 'jason.richards@sophos.com', '781.494.5800', 'Sophos', 'Jason-Richards-Appointed-VPIT-at-Sophos', 'www.sophos.com', '0', '0', 'Computers & Electronics Other', 18, 29, '3 Van de Fraaff Dr 2nd Fl', '', 'Burlington', 'MA', '', '1803', '2010-02-04', '2010-02-04', '', 'Sophos Names Jason Richards as Vice President of Information Technology', 'Sophos Names Jason Richards as Vice President of Information Technology\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(34, 'Jay ', '', 'House', 'Chief Technology Officer', 'jhouse@fcbmd.com', '301.620.1400', 'Frederick County Bank', 'Jay -House-Promoted-To-CTO-at-Frederick-County-Bank', 'www.fcbmd.com', '0', '0', 'Consumer Services Other', 30, 37, '30 E Patrick St', '', 'Frederick', 'MD', '', '21701', '2010-02-11', '2010-02-11', '', 'Bank promotes 8 executives', 'Bank promotes 8 executives\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(35, 'Tom', '', 'Packert', 'Chief Technology Officer', 'info@carecloud.com', '786.528.5740', 'CareCloud', 'Tom-Packert-Appointed-CTO-at-CareCloud', 'www.carecloud.com', '0', '0', 'Consumer Services Other', 30, 37, '5200 Blue Lagoon Dr Ste 900', '', 'Miami', 'FL', '', '33126', '2010-02-15', '2010-02-15', '', 'CareCloud appoints new chief technology officer', 'CareCloud appoints new chief technology officer\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(36, 'Stephen', '', 'Campbell ', 'Chief Information Officer', 'scampbell@plymouth.edu', '603.535.5000', 'Plymouth State University ', 'Stephen-Campbell -Appointed-CIO-at-Plymouth-State-University-', 'www.plymouth.edu', '0', '0', 'Colleges and Universities', 38, 39, '17 High St', '', 'Plymouth', 'NH', '', '3264', '2010-02-09', '2010-02-09', '', 'STEPHEN CAMPBELL NAMED ASSISTANT VICE PRESIDENT AND CHIEF INFORMATION OFFICER AT PLYMOUTH STATE ', 'STEPHEN CAMPBELL NAMED ASSISTANT VICE PRESIDENT AND CHIEF INFORMATION OFFICER AT PLYMOUTH STATE \r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(37, 'Sam', '', 'Dunn', 'Chief Information Officer', 'sdunn@babson.edu', '781.235.1200', 'Babson College', 'Sam-Dunn-Appointed-CIO-at-Babson-College', 'www.babson.edu', '0', '0', 'Colleges and Universities', 38, 39, '231 Forest St', '', 'Wellesley Hills', 'MA', '', '2481', '2009-11-09', '2009-11-09', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(38, 'Roy', '', 'Finaly', 'Chief Information Officer', 'rfinaly@iacnc.edu', '619.477.6310', 'InterAmerican College', 'Roy-Finaly-Appointed-CIO-at-InterAmerican-College', 'www.iacnc.edu', '0', '0', 'Colleges and Universities', 38, 39, '140 W 16th St', '', 'National City', 'CA', '', '91950', '2010-02-26', '2010-02-26', '', 'InterAmerican College Appoints Dr. Yoram Neumann as its New President and CEO', 'InterAmerican College Appoints Dr. Yoram Neumann as its New President and CEO\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(39, 'Thomas', '', 'O''Dea', 'Chief Information Officer', 'odea@studentclearinghouse.org', '703.742.4200', 'National Student Clearinghouse', 'Thomas-O''Dea-Appointed-CIO-at-National-Student-Clearinghouse', 'www.studentclearinghouse.org', '0', '0', 'Colleges and Universities', 38, 39, '13454 Sunrise Valley Dr Ste 300', '', 'Herndon', 'VA', '', '20171', '2010-02-04', '2010-02-04', '', 'National Student Clearinghouse(R) Announces Two New Appointments to Spearhead Its New Technology Initiatives', 'National Student Clearinghouse(R) Announces Two New Appointments to Spearhead Its New Technology Initiatives\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(40, 'Debra', '', 'Orr', 'Chief Information Officer', 'debra.orr@simmons.edu', '617.521.2000', 'Simmons', 'Debra-Orr-Appointed-CIO-at-Simmons', 'www.simmons.edu', '0', '0', 'Colleges and Universities', 38, 39, '300 Fenway', '', 'Boston', 'MA', '', '2115', '2010-02-23', '2010-02-23', '', 'Simmons Welcomes New Chief Information Officer', 'Simmons Welcomes New Chief Information Officer\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(41, 'Thomas', '', 'Squeo  ', 'Chief Information Officer', 'tsqueo@measuredprogress.org', '603.749.9102', 'Measured Progress', 'Thomas-Squeo  -Appointed-CIO-at-Measured-Progress', 'www.measuredprogress.org', '0', '0', 'Colleges and Universities', 38, 39, '100 Education Way', '', 'Dover', 'NH', '', '3820', '2009-11-15', '2009-11-15', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(42, 'Gordon', '', 'Wishon', 'Chief Information Officer', 'n/a', '574.631.5000', 'Notre Dame University', 'Gordon-Wishon-Resigned-from-CIO-at-Notre-Dame-University', 'www.nd.edu', '0', '0', 'Colleges and Universities', 38, 39, '300 Main Building', '', 'Notre Dame', 'IN', '', '46556', '2010-02-04', '2010-02-04', '', 'CIO leaves University, interim leader installed', 'CIO leaves University, interim leader installed\r\n', '', 'Resignation', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(43, 'Tom', '', 'Delaney  ', 'Chief Information Officer ', 'tom.delaney@nyu.edu', '212.998.1212', 'New York University School of Law', 'Tom-Delaney  -Appointed-CIO-at-New-York-University-School-of-Law', 'www.nyu.edu', '0', '0', 'Colleges and Universities', 38, 39, '295 Lafayette St Fl 2', '', 'New York', 'NY', '', '10012', '2009-08-14', '2009-08-14', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(44, 'Steve', '', 'Hahn', 'Chief Information Officer ', 'shagn@wisc.edu', '608.262.1234', 'UW&ndash;Madison', 'Steve-Hahn-Appointed-CIO-at-UW&ndash;Madison', 'www.wisc.edu', '$1-10 Million', '0-25', 'Colleges and Universities', 38, 39, '716 Langdon St', '', 'Madison', 'WI', 'AFG', '53706', '2009-10-28', '2009-10-28', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '2010-08-24', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(45, 'Rick', '', 'Mickool  ', 'Chief Information Officer ', 'rmickool@wittenberg.edu', '937.327.6231', 'Wittenberg University', 'Rick-Mickool  -Appointed-CIO-at-Wittenberg-University', 'www.wittenberg.edu', '0', '0', 'Colleges and Universities', 38, 39, '200 W Ward St', '', 'Springfield', 'OH', '', '45504', '2009-10-07', '2009-10-07', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(46, 'Jim', '', 'Bertolina', 'Chief Technology Officer', 'jim.bertolina@histosonics.com', '734.926.4630', 'HistoSonics ', 'Jim-Bertolina-Appointed-CTO-at-HistoSonics-', 'www.histosonics.com', '0', '0', 'Colleges and Universities', 38, 39, '3626 West Liberty Road', '', 'Ann Arbor', 'MI', '', '48103', '2010-02-09', '2010-02-09', '', 'U-M startup launched to develop ultrasound technology for tumor ablation', 'U-M startup launched to develop ultrasound technology for tumor ablation\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(47, 'Doug', '', 'Falk', 'Chief Technology Officer', 'falk@studentclearinghouse.org', '703.742.4200', 'National Student Clearinghouse', 'Doug-Falk-Appointed-CTO-at-National-Student-Clearinghouse', 'www.studentclearinghouse.org', '0', '0', 'Colleges and Universities', 38, 39, '13454 Sunrise Valley Dr Ste 300', '', 'Herndon', 'VA', '', '20171', '2010-02-04', '2010-02-04', '', 'National Student Clearinghouse(R) Announces Two New Appointments to Spearhead Its New Technology Initiatives', 'National Student Clearinghouse(R) Announces Two New Appointments to Spearhead Its New Technology Initiatives\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(48, 'William', '', 'Morse', 'Chief Technology Officer', 'wmorse@pugetsound.edu', '253.879.3100', 'University of Puget Sound in Tacoma', 'William-Morse-Appointed-CTO-at-University-of-Puget-Sound-in-Tacoma', 'www.pugetsound.edu', '0', '0', 'Colleges and Universities', 38, 39, '1500 N Warner St', '', 'Tacoma', 'WA', '', '98416', '2010-02-17', '2010-02-17', '', 'People in Business ', 'People in Business \r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(49, 'Michael', '', 'Gunter', 'Director of Information Systems', 'n/a', '785.670.1010', 'Washburn University', 'Michael-Gunter-Resigned-from-DIS-at-Washburn-University', 'www.washburn.edu', '$1-10 Million', '0-25', 'Colleges and Universities', 38, 39, '1700 SW College Ave', '', 'Topeka', 'KS', 'AFG', '66621', '2010-02-11', '2010-02-11', '', 'Washburn University\\''s ISS director resigns ', 'Washburn University\\''s ISS director resigns \r\n', '', 'Resignation', '', '', '', '', '0000-00-00', '2010-08-11', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(50, 'Dale', '', 'Young', 'Senior Vice President and Chief Information Office', 'dyoung@apus.edu', '877.777.9081', 'American Public University System', 'Dale-Young-Appointed-SVPACIO-at-American-Public-University-System', 'www.apus.edu', '0', '0', 'Colleges and Universities', 38, 39, '111 W Congress St', '', 'Charles Town', 'WV', '', '25414', '2010-02-08', '2010-02-08', '', 'W. Dale Young Joins American Public University System as Senior Vice President and Chief Information Officer', 'W. Dale Young Joins American Public University System as Senior Vice President and Chief Information Officer\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(51, 'Adrian', '', 'Corless', 'Chief Technology Officer', 'adrian_corless@plugpower.com', '518.782.7700', 'Plug Power', 'Adrian-Corless-Appointed-CTO-at-Plug-Power', 'www.plugpower.com', '0', '0', 'Energy & Utilities Other', 46, 0, '968 Albany Shaker Rd', '', 'Latham', 'NY', '', '12110', '2010-02-09', '2010-02-09', '', 'FORM 8-K', 'FORM 8-K\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(52, 'Walter', '', 'Sass', 'Chief Technology Officer', 'walter@secondwind.com', '617.776.8520', 'Second Wind Inc.', 'Walter-Sass-Promoted-To-CTO-at-Second-Wind-Inc.', 'www.secondwind.com', '0', '0', 'Energy & Utilities Other', 46, 0, '366 Summer St', '', 'Somerville', 'MA', '', '2144', '2010-02-26', '2010-02-26', '', 'Second Wind Inc. Names Larry Letteney CEO ', 'Second Wind Inc. Names Larry Letteney CEO \r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(53, 'Barbara', '', 'Sugg', 'VP, Information Technology', 'bsugg@spp.org', '501.614.3200', 'Southwest Power Pool ', 'Barbara-Sugg-Appointed-VPIT-at-Southwest-Power-Pool-', 'www.spp.org', '0', '0', 'Energy & Utilities Other', 46, 0, '415 N McKinley St', '', 'Little Rock', 'AR', '', '72205', '2010-02-07', '2010-02-07', '', 'BUSINESS PEOPLE ', 'BUSINESS PEOPLE \r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(54, 'Mitchell ', '', 'McLaughlin ', 'Chief Information Officer', 'mmclaughlin@fivestarbank.com', '585.786.3131', 'Five Star Bank', 'Mitchell -McLaughlin -Appointed-CIO-at-Five-Star-Bank', 'www.fivestar-bank.com', '0', '0', 'Financial Services Other', 54, 63, '55 N Main St', '', 'Warsaw', 'NY', '', '14569', '2010-02-08', '2010-02-08', '', 'New York-based Five Star Bank appoints Rizzo, McLaughlin to posts. ', 'New York-based Five Star Bank appoints Rizzo, McLaughlin to posts. \r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(55, 'Paul', '', 'Zajac', 'Chief Information Officer - Enterprise Risk Corpor', 'paul.zajac@aig.com', '212.770.7000', 'AIG', 'Paul-Zajac-Appointed-CIOERC-at-AIG', 'www.aig.com', '0', '0', 'Financial Services Other', 54, 63, '70 Pine St', '', 'New York', 'NY', '', '10270', '2010-01-14', '2010-01-14', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(56, 'Cristian', '', 'Doloc', 'Chief Technology Officer', 'n/a', '312.827.3600', 'Terra Nova Financial Group', 'Cristian-Doloc-Resigned-from-CTO-at-Terra-Nova-Financial-Group', 'www.tnfg.com', '0', '0', 'Financial Services Other', 54, 63, '100 S Wacker Dr Ste 1550', '', 'Chicago', 'IL', '', '60606', '2010-02-01', '2010-02-01', '', 'FORM 8-K', 'FORM 8-K\r\n', '', 'Resignation', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(57, 'Stuart', '', 'Evered', 'Chief Technology Officer', 'stuart.evered@phoenixpartnersgroup.com', '212.358.8110', 'Phoenix Partners Group', 'Stuart-Evered-Appointed-CTO-at-Phoenix-Partners-Group', 'www.phoenixpartnersgroup.com', '0', '0', 'Financial Services Other', 54, 63, '315 Park Ave S', '', 'New York', 'NY', '', '10010', '2010-02-04', '2010-02-04', '', 'Phoenix Partners Group Hires Stuart I. Evered as Chief Technology Officer', 'Phoenix Partners Group Hires Stuart I. Evered as Chief Technology Officer\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(58, 'Don', '', 'Gaspar ', 'Chief Technology Officer', 'dgaspar@yapstone.com', '866.289.5977', 'YapStone', 'Don-Gaspar -Appointed-CTO-at-YapStone', 'www.yapstone.com', '0', '0', 'Financial Services Other', 54, 63, '505 Sansome St Fl 8', '', 'San Francisco', 'CA', '', '94111', '2010-02-26', '2010-02-26', '', 'YapStone Announces New Chief Technology Officer', 'YapStone Announces New Chief Technology Officer\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(59, 'James', '', 'Mazarakis', 'Chief Technology Officer', 'jmazarakis@wsfsbank.com', '302.792.6000', 'WSFS Financial Corporation', 'James-Mazarakis-Promoted-To-CTO-at-WSFS-Financial-Corporation', 'www.wsfsbank.com', '0', '0', 'Financial Services Other', 54, 63, '500 Delaware Ave', '', 'Wilmington', 'DE', '', '19801', '2010-02-15', '2010-02-15', '', 'WSFS Names New Chief Technology Officer', 'WSFS Names New Chief Technology Officer\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(60, 'Shawn', '', 'Melamed', 'Chief Technology Officer', 'shawn.m@correlix.com', '212.487.9626', 'Correlix', 'Shawn-Melamed-Promoted-To-CTO-at-Correlix', 'www.correlix.com', '0', '0', 'Financial Services Other', 54, 63, '100 William Street, Suite 305', '', 'New York', 'NY', '', '10038', '2010-02-04', '2010-02-04', '', 'Correlix Accelerates Growth, Names Gil Shaked CEO', 'Correlix Accelerates Growth, Names Gil Shaked CEO\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(61, 'Antoine', '', 'Shagoury', 'Chief Technology Officer', 'ashagoury@londonstockexchange.com', '44.02077973', 'London Stock Exchange', 'Antoine-Shagoury-Appointed-CTO-at-London-Stock-Exchange', 'www.londonstockexchange.com', '0', '0', 'Financial Services Other', 54, 63, '10 Paternoster Sq', '', 'London', '', '', ' EC4M 7LS', '2010-02-15', '2010-02-15', '', 'London Stock Exchange Appoints Antoine Shagoury Chief Information Officer ', 'London Stock Exchange Appoints Antoine Shagoury Chief Information Officer edit Full Body\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '2010-07-07', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(62, 'Dawn', '', 'Robinson', 'Vice President, Information Technology Manager', 'dawn.robinson@kennebunksavings.com', '800.339.6573', 'Kennebunk Savings', 'Dawn-Robinson-Promoted-To-VPITM-at-Kennebunk-Savings', 'www.kennebunksavings.com', '0', '0', 'Financial Services Other', 54, 63, '104 Main St', '', 'Kennebunk', 'ME', '', '4043', '2010-02-08', '2010-02-08', '', 'Kennebunk Savings names Robinson V.P.', 'Kennebunk Savings names Robinson V.P.\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(63, 'Ben', '', 'Craig', 'VP, Information Technology', 'bcraig@northrim.com', '907.562.0062', 'Northrim Bank ', 'Ben-Craig-Appointed-VPIT-at-Northrim-Bank-', 'www.northrim.com', '0', '0', 'Financial Services Other', 54, 63, '3111 C St', '', 'Anchorage', 'AK', '', '99503', '2010-02-13', '2010-02-13', '', 'ALASKA BUSINESS PEOPLE ', 'ALASKA BUSINESS PEOPLE \r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(64, 'Teri', '', 'Takai', 'Chief Information Officer', 'tatait@michigan.gov', '703.697.9327', 'Department of Defense', 'Teri-Takai-Appointed-CIO-at-Department-of-Defense', 'www.dia.mil', '0', '0', 'National Government', 0, 0, 'Army Navy Dr and Fern St', '', 'Arlington', 'VA', '', '22202', '2010-02-08', '2010-02-08', '', 'Defense Department chooses CIO', 'Defense Department chooses CIO\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(65, 'Bill', '', 'Turnbull', 'Chief Information Officer', 'n/a', '800.342.5363', 'Department Of Energy', 'Bill-Turnbull-Resigned-from-CIO-at-Department-Of-Energy', 'www.doe.gov', '0', '0', 'National Government', 0, 0, '1000 Independence Ave SW', '', 'Washington', 'DC', '', '20585', '2010-02-19', '2010-02-19', '', 'Department Of Energy Names New Acting CIO', 'Department Of Energy Names New Acting CIO\r\n', '', 'Resignation', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(66, 'Renee', '', 'Davis', 'Chief Information Officer ', 'rdavis@lifemanagementcenter.org', '850.547.5114', 'Life Management Center of NWF', 'Renee-Davis-Appointed-CIO-at-Life-Management-Center-of-NWF', 'www.lifemanagementcenter.org', '0', '0', 'National Government', 0, 0, '310 E Byrd Ave', '', 'Bonifay', 'FL', '', '32425', '2009-10-26', '2009-10-26', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(67, 'Carl', '', 'Staton', 'Deputy Chief Information Officer', 'n/a', '800.342.5363', 'Department of Energy', 'Carl-Staton-Retired-as-DCIO-from-Department-of-Energy', 'www.doe.gov', '$1-10 Million', '0-25', 'National Government', 64, 67, '1000 Independence Ave SW', '', 'Washington', 'AL', 'AFG', '20585', '2010-02-04', '2010-02-04', '', 'Another IT Manager To Leave DoE ', 'Another IT Manager To Leave DoE \r\n', '', 'Retirement', '', '', '', '', '0000-00-00', '2010-08-11', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(68, 'Annette', '', 'Flowers', 'Director of Information Technology', 'annette.flowers@richmondgov.com', '804.646.5639', 'City of Richmond', 'Annette-Flowers-Appointed-DIT-at-City-of-Richmond', 'www.richmondgov.com', '0', '0', 'Local Government', 0, 0, '900 E. Broad St., G2', '', 'Richmond', 'VA', '', '23219', '2009-10-13', '2009-10-13', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(69, 'Richard', '', 'Fuqua', 'Chief Information Officer', 'rfuqua@@simplexdiabetes.com', '800.883.0608', 'Simplex Healthcare', 'Richard-Fuqua-Appointed-CIO-at-Simplex-Healthcare', 'www.simplexhealthcare.com', '0', '0', 'Healthcare, Pharmaceuticals, & Biotech Other', 0, 0, '210 Westwood Pl Ste 400', '', 'Brentwood', 'TN', '', '37027', '2010-02-26', '2010-02-26', '', 'Simplex Healthcare names Richard Fuqua CIO', 'Simplex Healthcare names Richard Fuqua CIO\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(70, 'Don', '', 'Imholz', 'Chief Information Officer', 'dimholz@centene.com', '314.725.4477', 'Centene Corporation', 'Don-Imholz-Promoted-To-CIO-at-Centene-Corporation', 'www.centene.com', '0', '0', 'Healthcare, Pharmaceuticals, & Biotech Other', 0, 0, '7711 Carondelet Ave Ste 800', '', 'Saint Louis', 'MO', '', '63105', '2010-02-09', '2010-02-09', '', 'EX-99.1 2 exhibit991.htm PRESS RELEASE FEBRUARY 9, 2010 ', 'EX-99.1 2 exhibit991.htm PRESS RELEASE FEBRUARY 9, 2010 \r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(71, 'Kent', '', 'Petty', 'Chief Information Officer', 'kent_petty@wellmont.org', '423.230.8200', 'Wellmont Health System', 'Kent-Petty-Appointed-CIO-at-Wellmont-Health-System', 'www.wellmont.org', '0', '0', 'Healthcare, Pharmaceuticals, & Biotech Other', 0, 0, '1905 American Way', '', 'Kingsport', 'TN', '', '37660', '2010-02-23', '2010-02-23', '', 'Wellmont Health hires Petty as VP, CIO', 'Wellmont Health hires Petty as VP, CIO\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(72, 'Sharon', '', 'Solomon', 'Chief Information Officer ', 'solomons@medimmune.com', '301.398.0000', 'MedImmune', 'Sharon-Solomon-Appointed-CIO-at-MedImmune', 'www.medimmune.com', '0', '0', 'Healthcare, Pharmaceuticals, & Biotech Other', 0, 0, '1 Medimmune Way', '', 'Gaithersburg', 'MD', '', '20878', '2009-11-01', '2009-11-01', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(73, 'Qibin', 'Chip', 'Bao', 'Chief Technology Officer', 'chipbao@pioneersurgical.com', '906.226.9909', 'Pioneer(R) Surgical Technology, Inc.', 'Qibin-Bao-Promoted-To-CTO-at-Pioneer(R)-Surgical-Technology,-Inc.', 'www.pioneersurgical.com', '$1-10 Million', '0-25', 'Healthcare, Pharmaceuticals, & Biotech Other', 70, 81, '375 River Park Cir', '', 'Marquette', 'MI', 'AFG', '49855', '2010-02-19', '2010-02-19', '', 'Pioneer(R) Surgical Technology, Inc. Announces New CTO', 'Pioneer(R) Surgical Technology, Inc. Announces New CTO\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '2010-08-24', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(74, 'Fred', '', 'Colen', 'Chief Technology Officer', 'fred.colen@bostonscientific.com', '508.650.8000', 'Boston Scientific', 'Fred-Colen-Promoted-To-CTO-at-Boston-Scientific', 'www.bostonscientific.com', '0', '0', 'Healthcare, Pharmaceuticals, & Biotech Other', 0, 0, '1 Boston Scientific Pl', '', 'Natick', 'MA', '', '1760', '2010-02-15', '2010-02-15', '', 'Boston Scientific Announces Management Changes and Restructuring Initiatives', 'Boston Scientific Announces Management Changes and Restructuring Initiatives\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(75, 'Mark', '', 'Long', 'Chief Technology Officer', 'mlong@zynx.com', '310.954.1950', 'Zynx Health', 'Mark-Long-Appointed-CTO-at-Zynx-Health', 'www.zynx.com', '0', '0', 'Healthcare, Pharmaceuticals, & Biotech Other', 0, 0, '10880 Wilshire Blvd Ste 300', '', 'Beverly Hills', 'CA', '', '90212', '2010-02-26', '2010-02-26', '', 'Zynx Health Names Mark Long Chief Technology Officer', 'Zynx Health Names Mark Long Chief Technology Officer\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(76, 'Jim', '', 'McGrann', 'Chief Technology Officer', 'jim.mclaughlin@vsp.com', '916.851.5000', 'VSP Global', 'Jim-McGrann-Appointed-CTO-at-VSP-Global', 'www.vsp.com', '0', '0', 'Healthcare, Pharmaceuticals, & Biotech Other', 0, 0, '3333 Quality Dr', '', 'Rancho Cordova', 'CA', '', '95670', '2010-02-15', '2010-02-15', '', 'On the Move', 'On the Move\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(77, 'Kurt', '', 'Nielsen', 'Chief Technology Officer', 'kurt.nielsen@catalent.com', '732.537.6200', 'Catalent Pharma Solutions', 'Kurt-Nielsen-Appointed-CTO-at-Catalent-Pharma-Solutions', 'www.catalent.com', '0', '0', 'Healthcare, Pharmaceuticals, & Biotech Other', 0, 0, '14 Schoolhouse Rd', '', 'Somerset', 'NJ', '', '8873', '2010-02-04', '2010-02-04', '', 'Catalent Pharma Solutions Appoints Chief Technology Officer to Lead Innovation Activities', 'Catalent Pharma Solutions Appoints Chief Technology Officer to Lead Innovation Activities\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(78, 'Sean', '', 'Tuley', 'SVP Information Technology', 'sean.tuley@lifepointhospitals.com', '615.372.8500', 'LifePoint Hospitals', 'Sean-Tuley-Appointed-SVPIT-at-LifePoint-Hospitals', 'www.lifepointhospitals.com', '0', '0', 'Healthcare, Pharmaceuticals, & Biotech Other', 0, 0, '103 Powell Ct Ste 200', '', 'Brentwood', 'TN', '', '37027', '2010-02-04', '2010-02-04', '', 'LifePoint names IT leader', 'LifePoint names IT leader\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(79, 'Kathleen', '', 'McElligott', 'Chief Information Officer', 'kathleen.mcelligott@emerson.com', '314.553.2000', 'Emerson', 'Kathleen-McElligott-Promoted-To-CIO-at-Emerson', 'www.emerson.com', '0', '0', 'Manufacturing Other', 0, 0, 'Emerson Electric 8000 W Florissant Ave', '', 'Saint Louis', 'MO', '', '63136', '2010-02-26', '2010-02-26', '', 'Emerson Names Kathleen McElligott as Chief Information Officer', 'Emerson Names Kathleen McElligott as Chief Information Officer\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(80, 'Patrick', '', 'Black', 'Chief Technology Officer', 'patrick.black@lmco.com', '301.897.6000', 'Lockheed Martin', 'Patrick-Black-Appointed-CTO-at-Lockheed-Martin', 'www.lockheedmartin.com', '0', '0', 'Manufacturing Other', 0, 0, '6801 Rockledge Dr', '', 'Bethesda', 'MD', '', '20817', '2009-09-20', '2009-09-20', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(81, 'Ray', '', 'Ghanbari', 'Chief Technology Officer', 'information@patientsafesolutions.com', '858.746.3100', 'PatientSafe Solutions, Inc.', 'Ray-Ghanbari-Appointed-CTO-at-PatientSafe-Solutions,-Inc.', 'www.patientsafesolutions.com', '0', '0', 'Manufacturing Other', 0, 0, '5375 Mira Sorrento Pl Ste 500', '', 'San Diego', 'CA', '', '92121', '2010-02-19', '2010-02-19', '', 'PatientSafe Solutions, Inc. Announces Management Team', 'PatientSafe Solutions, Inc. Announces Management Team\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(82, 'John', '', 'Zaleski', 'Chief Technology Officer', 'jzaleski@nuvon.com', '800.838.8574', 'Nuvon', 'John-Zaleski-Appointed-CTO-at-Nuvon', 'www.nuvon.net', '0', '0', 'Manufacturing Other', 0, 0, '3230 S Buffalo Dr', '', 'Las Vegas', 'NV', '', '89117', '2010-02-25', '2010-02-25', '', 'Nuvon Welcomes Healthcare Technology and Biomedical Informatics Leader John Zaleski, PhD to Executive Team ', 'Nuvon Welcomes Healthcare Technology and Biomedical Informatics Leader John Zaleski, PhD to Executive Team \r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(83, 'Phillip ', '', 'Morrow', 'Chief Information Officer', 'n/a', '214.854.3000', 'Blockbuster', 'Phillip -Morrow-Resigned-from-CIO-at-Blockbuster', 'www.blockbuster.com', '0', '0', 'Media & Entertainment Other', 0, 0, '1201 Elm St.', '', 'Dallas', 'TX', '', '75270', '2010-02-10', '2010-02-10', '', 'Blockbuster''s Bill Lee Resigns As EVP And Chief Merchandising Officer ', 'Blockbuster''s Bill Lee Resigns As EVP And Chief Merchandising Officer \r\n', '', 'Resignation', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(84, 'Ralph', '', 'Munsen', 'Chief Information Officer', 'rmunsen@hfmus.com', '212.364.1100', 'Hachette Book Group', 'Ralph-Munsen-Appointed-CIO-at-Hachette-Book-Group', 'www.hachettebookgroupusa.com', '0', '0', 'Media & Entertainment Other', 0, 0, '237 Park Ave', '', 'New York', 'NY', '', '10017', '2010-02-23', '2010-02-23', '', 'March 2010 Roundup', 'March 2010 Roundup\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(85, 'Kelvin', '', 'Hubbard', 'Chief Technology Officer', 'khubbard@talentsecure.com', '913.451.3733', 'TalentSecure ', 'Kelvin-Hubbard-Appointed-CTO-at-TalentSecure-', 'www.talentsecure.com', '0', '0', 'Media & Entertainment Other', 0, 0, '7500 College Blvd', '', 'Overland Park', 'KS', '', '66210', '2010-02-22', '2010-02-22', '', 'New Executives at TalentSecure Lead Growth of Financial and Product Development', 'New Executives at TalentSecure Lead Growth of Financial and Product Development\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(86, 'Brian ', '', 'Kelley', 'Chief Technology Officer', 'bkelley@bayareanewsproject.org', '0', 'Bay Area News Project', 'Brian -Kelley-Appointed-CTO-at-Bay-Area-News-Project', 'www.bayareanewsproject.org', '0', '0', 'Media & Entertainment Other', 0, 0, '0', '', 'San Francisco', 'CA', '', '94107', '2010-02-24', '2010-02-24', '', 'Bay Area News Project announces CTO hire via Twitter', 'Bay Area News Project announces CTO hire via Twitter\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(87, 'Lonnie', '', 'Stroud', 'Chief Information Officer', 'lonnie@cascadesierrasolutions.org', '541.302.0900', 'Cascade Sierra Solutions', 'Lonnie-Stroud-Appointed-CIO-at-Cascade-Sierra-Solutions', 'www.cascadesierrasolutions.org', '0', '0', 'Non-profit Other', 0, 0, '32670 E Mill St', '', 'Coburg', 'OR', '', '97408', '2010-02-19', '2010-02-19', '', 'Cascade Sierra Solutions appoints Stroud COO, CIO', 'Cascade Sierra Solutions appoints Stroud COO, CIO\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(88, 'James', '', 'Barbaglia', 'Chief Information Officer', 'jbarbaglia@virtuosant.com', '888.748.9880 x101', 'Virtuosant Technology, Inc.', 'James-Barbaglia-Appointed-CIO-at-Virtuosant-Technology,-Inc.', 'www.virtuosant.com', '0', '0', 'Software & Internet Other', 0, 0, '372 Cardinal Rd', '', 'Ringgold', 'GA', '', '30736', '2010-02-19', '2010-02-19', '', 'Virtuosant Technology, Inc. Appoints James M. Barbaglia as Chief Information Officer', 'Virtuosant Technology, Inc. Appoints James M. Barbaglia as Chief Information Officer\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(89, 'James', '', 'Froisland', 'Chief Information Officer', 'n/a', '847.439.2210', 'Material Sciences Corp.', 'James-Froisland-Resigned-from-CIO-at-Material-Sciences-Corp.', 'www.matsci.com', '0', '0', 'Real Estate and Construction Other', 0, 0, '2200 Pratt Blvd', '', 'Elk Grove Village', 'IL', '', '60007', '2010-02-12', '2010-02-12', '', 'FORM 8-K', 'FORM 8-K\r\n', '', 'Resignation', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(90, 'John', '', 'Collins', 'Chief Information Officer ', 'info@RuddProps.com', '888.252.3602', 'Leslie Rudd Investment Co.', 'John-Collins-Appointed-CIO-at-Leslie-Rudd-Investment-Co.', 'www.ruddprops.com', '0', '0', 'Real Estate and Construction Other', 0, 0, '2416 E. 37th North', '', 'Wichita', 'KS', '', '67219', '2009-11-03', '2009-11-03', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(91, 'David', '', 'Linthicum', 'Chief Technology Officer', 'dlinthicum@bickgroup.com', '314.993.3355', 'Bick Group ', 'David-Linthicum-Promoted-To-CTO-at-Bick-Group-', 'www.bickgroup.com', '0', '0', 'Real Estate and Construction Other', 0, 0, '12969 Manchester Rd', '', 'Saint Louis', 'MO', '', '63131', '2010-02-15', '2010-02-15', '', 'Bick Group Acquires Blue Mountain Labs, Expands Cloud Computing Services', 'Bick Group Acquires Blue Mountain Labs, Expands Cloud Computing Services\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(92, 'Jason', '', 'Waters', 'Chief Technology Officer', 'services@hubplumbing.com', '617.822.0700', 'HubPlumbing', 'Jason-Waters-Appointed-CTO-at-HubPlumbing', 'www.hubplumbing.com', '0', '0', 'Real Estate and Construction Other', 0, 0, '70 Old Colony Ave', '', 'Boston', 'MA', '', '2127', '2010-02-09', '2010-02-09', '', 'Hub Plumbing & Mechanical Names Jason Waters as Their Lead Hvac Technician', 'Hub Plumbing & Mechanical Names Jason Waters as Their Lead Hvac Technician\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(93, 'Kevin', '', 'Noval', 'Director, Information Technology', 'knoval@bondbrothers.com', '617.387.3400', 'BOND', 'Kevin-Noval-Appointed-DIT-at-BOND', 'www.bondbrothers.com', '0', '0', 'Real Estate and Construction Other', 0, 0, '145 Spring St', '', 'Everett', 'MA', '', '2149', '2010-02-08', '2010-02-08', '', 'Kevin Noval ', 'Kevin Noval \r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(94, 'Terry', '', 'Morgan', 'Chief Information Officer', 'n/a', '704.633.8250', 'Delhaize Group', 'Terry-Morgan-Retired-as-CIO-from-Delhaize-Group', 'www.delhaizegroup.com', '0', '0', 'Grocery and Specialty Food Stores', 0, 0, '2110 Executive Dr', '', 'Salisbury', 'NC', '', '28147', '2010-02-19', '2010-02-19', '', 'More changes at Food Lion/Delhaize', 'More changes at Food Lion/Delhaize\r\n', '', 'Retirement', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(95, 'Andrew', '', 'Mirsky', 'Chief Technology Officer', 'andrew@custommade.com', '617.300.0169', 'CustomMade Ventures', 'Andrew-Mirsky-Appointed-CTO-at-CustomMade-Ventures', 'www.custommade.com', '0', '0', 'Retail Other', 0, 0, '99 1st St', '', 'Cambridge', 'MA', '', '2141', '2010-02-26', '2010-02-26', '', 'Bookmark and Share', 'Bookmark and Share\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(96, 'Dwight', '', 'Gibbs', 'Chief Information Officer', 'dwight.gibbs@invisioninc.com', '212.557.5554', 'INVISION, INC.', 'Dwight-Gibbs-Appointed-CIO-at-INVISION,-INC.', 'www.invisioninc.com', '0', '0', 'Software & Internet Other', 0, 0, '420 Lexington Ave Rm 2903', '', 'New York', 'NY', '', '10170', '2010-02-26', '2010-02-26', '', '', '\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(97, 'Steve', '', 'Mills', 'Chief Information Officer', 'steve.mills@rackspace.com', '210.312.4700', 'Rackspace', 'Steve-Mills-Appointed-CIO-at-Rackspace', 'www.rackspace.com', '0', '0', 'Software & Internet Other', 0, 0, '5000 Walzem Rd', '', 'San Antonio', 'TX', '', '78218', '2010-02-16', '2010-02-16', '', 'Rackspace Hosting Reports Fourth Quarter and Year-End 2009 Results', 'Rackspace Hosting Reports Fourth Quarter and Year-End 2009 Results\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(98, 'Jeff', '', 'Rubenstein', 'Chief Information Officer', 'jrubenstein@wimba.com', '646.861.5100', 'Wimba ', 'Jeff-Rubenstein-Appointed-CIO-at-Wimba-', 'www.wimba.com', '0', '0', 'Software & Internet Other', 0, 0, '10 E 40th St Fl 11', '', 'New York', 'NY', '', '10016', '2009-10-29', '2009-10-29', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(99, 'Mike', '', 'Knapick', 'Chief Information Officer ', 'mknapick@isilon.com', '206.315.7500', 'Isilon Systems', 'Mike-Knapick-Appointed-CIO-at-Isilon-Systems', 'www.isilon.com', '0', '0', 'Software & Internet Other', 0, 0, '3101 Western Ave', '', 'Seattle', 'WA', '', '98121', '2009-11-19', '2009-11-19', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(100, 'Mark', '', 'Bowles', 'Chief Technology Officer', 'mbowles@netbase.com', '650.810.2100', 'NetBase', 'Mark-Bowles-Appointed-CTO-at-NetBase', 'www.netbase.com', '0', '0', 'Software & Internet Other', 0, 0, '2087 Landings Dr', '', 'Mountain View', 'CA', '', '94043', '2010-02-09', '2010-02-09', '', 'NetBase Expands Leadership Team With Three Seasoned High-Tech Executives ', 'NetBase Expands Leadership Team With Three Seasoned High-Tech Executives \r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(101, 'Dave', '', 'Dupre', 'Chief Technology Officer', 'ddupre@wimba.com', '646.861.5100', 'Wimba ', 'Dave-Dupre-Appointed-CTO-at-Wimba-', 'www.wimba.com', '0', '0', 'Software & Internet Other', 0, 0, '10 E 40th St Fl 11', '', 'New York', 'NY', '', '10016', '2009-10-29', '2009-10-29', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(102, 'Julie', '', 'Hartigan', 'Chief Technology Officer', 'jhartigan@expertsystem.net', '650.224.7048', 'Expert System', 'Julie-Hartigan-Appointed-CTO-at-Expert-System', 'www.expertsystem.net', '0', '0', 'Software & Internet Other', 0, 0, '544 Thompson Ave', '', 'Mountain View', 'CA', '', '94043', '2010-02-04', '2010-02-04', '', 'Expert System Expands North American Executive Team', 'Expert System Expands North American Executive Team\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(103, 'Wayne', '', 'Huang', 'Chief Technology Officer', 'wayne@armorize.com', '408.216.7893', 'Armorize Technologies', 'Wayne-Huang-Promoted-To-CTO-at-Armorize-Technologies', 'www.armorize.com', '0', '0', 'Software & Internet Other', 0, 0, '5201 Great America Pkwy Ste 320', '', 'Santa Clara', 'CA', '', '95054', '2010-02-26', '2010-02-26', '', 'Caleb Sima Joins Armorize Technologies as CEO', 'Caleb Sima Joins Armorize Technologies as CEO\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(104, 'Chris', '', 'Insinger ', 'Chief Technology Officer', 'cinsinger@nimaya.com', '877.646.2924', 'Nimaya', 'Chris-Insinger -Appointed-CTO-at-Nimaya', 'www.nimaya.com', '0', '0', 'Software & Internet Other', 0, 0, '7900 Westpark Dr Ste T300', '', 'MC Lean', 'VA', '', '22102', '2010-02-26', '2010-02-26', '', 'Nimaya Adds Chris Insinger as CTO and President, Asia Pacific ', 'Nimaya Adds Chris Insinger as CTO and President, Asia Pacific \r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(105, 'Adam', '', 'Pisoni', 'Chief Technology Officer', 'adam@yammer-inc.com', '415.968.5852', 'Yammer', 'Adam-Pisoni-Promoted-To-CTO-at-Yammer', 'www.yammer-inc.com', '0', '0', 'Software & Internet Other', 0, 0, '410 Townsend St Ste 410', '', 'San Francisco', 'CA', '', '94107', '2010-02-09', '2010-02-09', '', 'Flush With $10 Million In Fresh Cash, Yammer Strengthens Executive', 'Flush With $10 Million In Fresh Cash, Yammer Strengthens Executive\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(106, 'Rob', '', 'Roy', 'Chief Technology Officer', 'rroy@fortifysoftware.com', '650.358.5600', 'Fortify Software', 'Rob-Roy-Appointed-CTO-at-Fortify-Software', 'www.fortifysoftware.com', '0', '0', 'Software & Internet Other', 0, 0, '2215 Bridgepointe Pkwy Ste 400', '', 'Foster City', 'CA', '', '94404', '2010-02-04', '2010-02-04', '', 'Fortify Software Names Rob Roy as Its Federal Chief Technology Officer', 'Fortify Software Names Rob Roy as Its Federal Chief Technology Officer\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(107, 'Mark', '', 'Seamans ', 'Chief Technology Officer', 'mseamans@filetek.com', '301.251.0600', 'FileTek', 'Mark-Seamans -Appointed-CTO-at-FileTek', 'www.filetek.com', '0', '0', 'Software & Internet Other', 0, 0, '9400 Key West Ave', '', 'Rockville', 'MD', '', '20850', '2010-02-16', '2010-02-16', '', 'FileTek Announces the Appointment of Mark Seamans as Executive Vice President and CTO', 'FileTek Announces the Appointment of Mark Seamans as Executive Vice President and CTO\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(108, 'Troy', '', 'Wing', 'Chief Technology Officer', 'n/a', '847.281.9307', 'ForceLogix Technologies Inc.', 'Troy-Wing-Resigned-from-CTO-at-ForceLogix-Technologies-Inc.', 'www.forcelogix.com', '0', '0', 'Software & Internet Other', 0, 0, '100 E Cook Ave', '', 'Libertyville', 'IL', '', '60048', '2010-02-19', '2010-02-19', '', 'ForceLogix Technologies Inc. Announces Departure of CTO ', 'ForceLogix Technologies Inc. Announces Departure of CTO \r\n', '', 'Resignation', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(109, 'Vince', '', 'Hunt', 'COO', 'vinceh@shop.com', '831.647.6024', 'Shop.com', 'Vince-Hunt-Promoted-To-COO-at-Shop.com', 'www.shop.com', '0', '0', 'Software & Internet Other', 0, 0, '1 Lower Ragsdale Dr Ste 210 Bldg 1', '', 'Monterey', 'CA', '', '93940', '2010-02-05', '2010-02-05', '', 'SHOP.COM(TM) Announces Executive Team Promotions ', 'SHOP.COM(TM) Announces Executive Team Promotions \r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(110, 'Marc', '', 'Hollander', 'EVP Technology', 'marc@kickapps.com', '212.730.4558', 'KickApps', 'Marc-Hollander-Appointed-EVPT-at-KickApps', 'www.kickapps.com', '0', '0', 'Software & Internet Other', 0, 0, '29 W 38th St Fl 5', '', 'New York', 'NY', '', '10018', '2010-02-15', '2010-02-15', '', 'Past AOL Veteran to Join the Executive Team at KickApps', 'Past AOL Veteran to Join the Executive Team at KickApps\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(111, 'Karl', '', 'Salnoske', 'Executive Vice President of Service Delivery & Chi', 'ksalnoske@gxs.com', '301.340.4000', 'GXS', 'Karl-Salnoske-Appointed-EVPSDC-at-GXS', 'www.gxs.com', '0', '0', 'Software & Internet Other', 0, 0, '100 Edison Park Dr', '', 'Gaithersburg', 'MD', '', '20878', '2010-02-26', '2010-02-26', '', 'Karl Salnoske Named Executive Vice President of Service Delivery and CIO of GXS', 'Karl Salnoske Named Executive Vice President of Service Delivery and CIO of GXS\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(112, 'Ralph', '', 'Szygenda', 'Strategic Consultant', 'rszygenda@irise.com', '310.426.7800', 'iRise', 'Ralph-Szygenda-Appointed-SC-at-iRise', 'www.irise.com', '0', '0', 'Software & Internet Other', 0, 0, '2321 Rosecrans Ave Ste 4200', '', 'El Segundo', 'CA', '', '90245', '2010-02-09', '2010-02-09', '', 'Ralph Szygenda Joins iRise', 'Ralph Szygenda Joins iRise\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(113, 'Martin', '', 'Heller', 'VP, Technology', 'martin@alphasoftware.com ', '781.229.4500', 'Alpha Software', 'Martin-Heller-Appointed-VPT-at-Alpha-Software', 'www.alphasoftware.com', '0', '0', 'Software & Internet Other', 0, 0, '70 Blanchard Rd Ste 206', '', 'Burlington', 'MA', '', '1803', '2010-02-22', '2010-02-22', '', 'Dr. Martin Heller Joins Alpha Software as VP of Technology and Education , Veteran InfoWorld journalist is now part of Alpha’s executive team ', 'Dr. Martin Heller Joins Alpha Software as VP of Technology and Education , Veteran InfoWorld journalist is now part of Alpha’s executive team \r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(114, 'Russ', '', 'Freen', 'Chief Information Officer', 'n/a', '613.591.6655', 'Bridgewater Systems', 'Russ-Freen-Resigned-from-CIO-at-Bridgewater-Systems', 'www.bridgewatersystems.com', '0', '0', 'Telecommunications Other', 0, 0, '303 Terry Fox Dr Ste 500', '', 'Ottawa', 'ON', '', ' K2K 3J1', '2010-02-24', '2010-02-24', '', 'Bridgewater Systems Founder and CTO to Step Down', 'Bridgewater Systems Founder and CTO to Step Down\r\n', '', 'Resignation', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(115, 'David', '', 'Brager', 'Chief Technology Officer', 'david.brager@ericsson.com', '972.583.0000', 'Ericsson ', 'David-Brager-Appointed-CTO-at-Ericsson-', 'www.ericsson.com', '0', '0', 'Telecommunications Other', 0, 0, '6300 Legacy Dr', '', 'Plano', 'TX', '', '75024', '2009-09-20', '2009-09-20', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(116, 'John', '', 'Iacovelli', 'Chief Technology Officer', 'n/a', '561.394.2748', 'Flint Telecom Group', 'John-Iacovelli-Resigned-from-CTO-at-Flint-Telecom-Group', 'www.flinttel.com', '0', '0', 'Telecommunications Other', 0, 0, '327 Plaza Real Ste 319', '', 'Boca Raton', 'FL', '', '33432', '2010-02-04', '2010-02-04', '', 'FORM 8-K', 'FORM 8-K\r\n', '', 'Resignation', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(117, 'Vince', '', 'Lesch', 'Chief Technology Officer', 'vince.lesch@tekelec.com', '919.460.5500', 'Tekelec', 'Vince-Lesch-Promoted-To-CTO-at-Tekelec', 'www.tekelec.com', '0', '0', 'Telecommunications Other', 0, 0, '5200 Paramount Pkwy', '', 'Morrisville', 'NC', '', '27560', '2010-02-15', '2010-02-15', '', 'Tekelec Promotes Vince Lesch to CTO', 'Tekelec Promotes Vince Lesch to CTO\r\n', '', 'Promotion', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(118, 'Paul', '', 'Makiewich', 'Chief Technology Officer', 'n/a', '908.582.3000', 'Alcatel&ndash;Lucent', 'Paul-Makiewich-Resigned-from-CTO-at-Alcatel&ndash;Lucent', 'www.alcatel-lucent.com', '$1-10 Million', '0-25', 'Telecommunications Other', 144, 150, '600 Mountain Ave', '', 'New Providence', 'NJ', 'AFG', '7974', '2010-02-08', '2010-02-08', '', 'Mankiewich Out as AlcaLu Wireless CTO', 'Mankiewich Out as AlcaLu Wireless CTO\r\n', '', 'Resignation', '', '', '', '', '0000-00-00', '2010-08-24', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(119, 'Ron', '', 'Darin', 'Chief Information Officer', 'rdarin@lighthouse-facilities.org', '508.626.0901 x26', 'Lighthouse Academies', 'Ron-Darin-Appointed-CIO-at-Lighthouse-Academies', 'www.lighthouse-facilities.org', '0', '0', 'Transportation & Storage Other', 0, 0, '1661 Worcester Rd', '', 'Framingham', 'MA', '', '1701', '2010-01-14', '2010-01-14', '', 'Job Posting > Updated LinkedIn Profile', 'Job Posting > Updated LinkedIn Profile\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(120, 'Rocky', '', 'Wiggins', 'Chief Information Officer', 'rocky.wiggins@airtranairways.com', '407.318.5600', 'AirTran Airways', 'Rocky-Wiggins-Appointed-CIO-at-AirTran-Airways', 'www.airtran-airways.com', '0', '0', 'Travel, Recreation & Leisure Other', 0, 0, '9955 Airtran Blvd', '', 'Orlando', 'FL', '', '32827', '2010-02-19', '2010-02-19', '', 'AirTran Airways announces four executive appointments', 'AirTran Airways announces four executive appointments\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(121, 'Jason', '', 'Campbell ', 'Chief Technology Officer', 'n/a', '310.383.8893', 'FormulaWon', 'Jason-Campbell -Appointed-CTO-at-FormulaWon', 'www.formulawon.com', '0', '0', 'Travel, Recreation & Leisure Other', 0, 0, '2800 Neilson Way Apt 910', '', 'Santa Monica', 'CA', '', '90405', '2010-02-05', '2010-02-05', '', 'FORM 8-K', 'FORM 8-K\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(122, 'Justin', '', 'Erbacci ', 'Vice President Information Technology', 'justin.erbacci@staralliance.com', '847.910.1336', 'Star Alliance', 'Justin-Erbacci -Appointed-VPIT-at-Star-Alliance', 'www.staralliance.com', '0', '0', 'Travel, Recreation & Leisure Other', 0, 0, '34 Sunset View Rd', '', 'Deer Park', 'IL', '', '60010', '2010-02-19', '2010-02-19', '', 'Star Alliance Appoints New Vice President Information Technology', 'Star Alliance Appoints New Vice President Information Technology\r\n', '', 'Appointment', '', '', '', '', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(123, 'Tim', '', 'Dyer', 'Chief Technology Officer', 'tdyer@energyrecovery.com', '510.483.7370', 'Energy Recovery', 'Tim-Dyer-Promoted-To-CTO-at-Energy-Recovery', 'www.energyrecovery.com', '0', '250', 'Agriculture & Mining Other', 1, 6, '1908 Doolittle Dr', '', 'San Leandro', 'CA', 'United States', '94577', '2010-07-22', '2010-07-22', 'Press Release', 'Energy Recovery Inc Appoints Renowned Ceramicist and Material Sciences Expert Tim Dyer as Chief Technology Officer', 'Energy Recovery Inc Appoints Renowned Ceramicist and Material Sciences Expert Tim Dyer as Chief Technology Officer\r\n2010-07-22 14:15:28 - \r\nEnergy Recovery Inc : cts.businesswire.com/ct/CT?id=smartlink&url=http%3A%2F%2Fwww .. (NASDAQ:ERII), a leader in the design and development of energy recovery devices for desalination, today appointed Tim Dyer as Chief Technology Officer (CTO) to manage all engineering and R&D initiatives. Previously Energy Recovery&#8217;s chief scientist, Dyer will oversee the expansion of the company&#8217;s product portfolio by enhancing existing offerings and bringing new solutions to market. Specifically, he will head the development of the company&#8217;s industry-leading Pressure Exchanger&#8482; (PX&#8482;) isobaric energy recovery devices, advanced liquid turbo solutions, cutting-edge ceramics applications and all other energy-transfer technologies.\r\n\r\n&#8220;Energy Recovery is committed to diversifying its technology offerings and commercial solutions, and we are aggressively expanding into the ceramic material science, advanced ceramic components and other clean-technology markets. By naming Tim Dyer CTO, we have solidified the management within our engineering division, which is essential to the success of these efforts,&#8221; said G.G. Pique, president and CEO of Energy Recovery. &#8220;To support Tim in this new role, Paul Cook, the founder of Raychem and an active member of our Board of Directors, has agreed to advise and consult with Tim by lending his significant expertise in the diversification and commercialization of an expanded product portfolio.\r\nTim&#8217;s brilliant R&D team also includes Chief Engineer Jeremy Martin and Vice President of Engineering Kevin Terrasi, rounding out an experienced, innovative group that will enable Energy Recovery to develop new solutions to meet demand across a wide range of markets.&#8221;\r\n\r\nDyer brings more than 18 years of engineering, product development and management experience to his new role. He joined Energy Recovery in 2009 as director of ceramics, helping the company successfully integrate a state-of-the-art ceramics production facility into its new headquarters to strengthen the oversight of its intellectual property, improve supply costs and enhance manufacturing and operational efficiency. Prior to joining Energy Recovery, Dyer served as the director of technology at Morgan Technical Ceramics where he oversaw the development of high-quality alumina and zirconia products for use in critical process applications. Before that, he managed the laser chamber technology team at Cymer Inc where he led multiple metallurgical and ceramic materials technology development projects. Dyer has also held management and engineering positions with SpeedFam-IPEC, Heraeus Materials Technology, Accord Semiconductor Equipment Group and Applied Materials. He currently holds 31 patents and has 18 pending, and he has published numerous technical papers that have helped shape best practices within the advanced ceramics and material sciences fields. Dyer holds a bachelor&#8217;s degree in material science and a master&#8217;s degree in mechanical engineering from the University of California, Davis.\r\n\r\n&#8220;Since coming to Energy Recovery, I have been impressed by the company&#8217;s ongoing commitment to its R&D efforts. The team continues to innovate by enhancing the existing product portfolio of industry-leading solutions, finding new applications for these technologies and uncovering potential new products to meet the demands of various markets,&#8221; said Dyer. &#8220;Energy Recovery&#8217;s significant engineering expertise, our go-to-market strategies and addition of an in-house ceramics manufacturing facility are tremendous competitive differentiators that will help us continue to set the bar when it comes to technology innovations and product development. I look forward to serving as CTO to help take the company to the next level.&#8221;\r\n\r\nEnergy Recovery\\''s technologies are up to 98 percent efficient and reduce the energy consumption of seawater desalination systems by up to 60 percent, making it a cost-effective solution for clean water supply. The company&#8217;s technologies reduce the carbon footprint of desalination, saving more than 900 MW of energy and reducing CO2 emissions by more than 4.7 million tons per year worldwide. For more information about Energy Recovery\\''s technologies, visit www.energyrecovery.com : cts.businesswire.com/ct/CT?id=smartlink&url=http%3A%2F%2Fwww .. or send an email to info@energyrecovery.com : mailto:info@energyrecovery.com .\r\n\r\n\r\nAbout Energy Recovery Inc\r\n\r\nEnergy Recovery Inc (NASDAQ:ERII) designs and develops energy recovery devices that help make desalination affordable by significantly reducing energy consumption. Energy Recovery technologies include the PX Pressure Exchanger&#8482; (PX&#8482;) device for desalination and the Turbocharger hydraulic turbine energy recovery device and pumps for desalination, gas and liquid processing applications. The company is headquartered in the San Francisco Bay Area with offices in Detroit and worldwide, including Madrid, Shanghai and the United Arab Emirates. For more information about Energy Recovery Inc, please visit www.energyrecovery.com : cts.businesswire.com/ct/CT?id=smartlink&url=http%3A%2F%2Fwww .. .\r\n\r\n \r\n\r\nEnergy Recovery Inc. Audrey Bold, +1-510-746-2529 abold@energyrecovery.com : mailto:abold@energyrecovery.com or Schwartz \r\nCommunications, Inc.Dan Borgasano, +1-781-684-6660 ERI@schwartz-pr.com : mailto:ERI@schwartz-pr.com \r\n', 'http://bit.ly/chny14', 'Promotion', 'Tim Dyer promoted to Chief Technology Officer At Energy Recovery', 'Previously Energy Recovery&#8217;s chief scientist, Dyer brings more than 18 years of engineering, product development and management experience. He currently holds 31 patents and has 18 pending, and he has published numerous technical papers that have helped shape best practices within the advanced ceramics and material sciences fields. Dyer holds a bachelor&#8217;s degree in material science and a master&#8217;s degree in mechanical engineering from the University of California, Davis.', 'Energy Recovery Inc (NASDAQ:ERII) designs and develops energy recovery devices that help make desalination affordable by significantly reducing energy consumption.', 'http://www.pr-inside.com/print2017832.htm', '2010-05-27', '2010-07-26', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(134, 'Ed', ' ', 'Steinike', 'Chief Information Officer', 'esteinike@na.ko.com', '404.676.2121', 'The Coca Cola Company', 'Ed-Steinike-Appointed-CIO-at-The-Coca-Cola-Company', 'www.thecoca-colacompany.com', ' > $ 1 Billion', '10K-50K', 'Nonalcoholic Beverages', 82, 92, '1 Coca Cola Plz Northwest', ' ', 'Atlanta', 'GA', 'AFG', '30313', '2010-07-22', '2010-07-22', 'Press Release', 'The Board of Directors of the Coca-Cola Company Announces Quarterly Dividend  Elects Chief Information Officer Ed Steinike as a Vice President ', 'July 22, 2010 12:17 PM Eastern Daylight Time   The Board of Directors of the Coca-Cola Company Announces Quarterly Dividend  Elects Chief Information Officer Ed Steinike as a Vice President  ATLANTA--(BUSINESS WIRE)--The Board of Directors of The Coca-Cola Company today declared a regular quarterly dividend of 44 cents per common share. The dividend is payable October 1, 2010, to shareowners of record as of September 15, 2010.  This is equivalent to an annual dividend of $1.76 per share, up from $1.64 per share in 2009. The dividend reflects the Board\\''s confidence in the Company\\''s long-term cash flow. The Company returned $5.3 billion to shareowners in 2009, through $3.8 billion in dividends and $1.5 billion in share repurchases.  The Board also elected Ed Steinike as a vice president of the Company.  As Chief Information Officer, Mr. Steinike oversees the Company&#65533;s global information technology strategy, services and operations. Before rejoining The Coca-Cola Company in April, Mr. Steinike served as Executive Vice President and Chief Information Officer at ING Insurance. Prior to ING, he was The Coca-Cola Company&#65533;s Chief Development Officer and CIO of its North America business from 2004 to 2007. From 2002 to 2004, Mr. Steinike was the Company&#65533;s Chief Technology Officer. Prior to joining The Coca-Cola Company, he worked at General Electric between 1976 and 2002, holding positions of increasing responsibility including CIO for GE Energy and GE Medical Systems.  Mr. Steinike holds a Bachelor of Science degree from Marquette University.  The Coca-Cola Company (NYSE: KO) is the world\\''s largest beverage company, refreshing consumers with more than 500 sparkling and still brands. Along with Coca-Cola®, recognized as the world\\''s most valuable brand, the Company\\''s portfolio includes 12 other billion dollar brands, including Diet Coke®, Fanta®, Sprite®, Coca-Cola Zero®, vitaminwater®, POWERADE®, Minute Maid®, Simply® and Georgia Coffee®. Globally, we are the No. 1 provider of sparkling beverages, juices and juice drinks and ready-to-drink teas and coffees. Through the world\\''s largest beverage distribution system, consumers in more than 200 countries enjoy the Company\\''s beverages at a rate of 1.6 billion servings a day. With an enduring commitment to building sustainable communities, our Company is focused on initiatives that protect the environment, conserve resources and enhance the economic development of the communities where we operate. For more information about our Company, please visit our website at www.thecoca-colacompany.com.  Stay informed. Subscribe to receive the latest news from The Coca-Cola Company at http://feeds.feedburner.com/NewsFromTheCoca-ColaCompany.  Photos/Multimedia Gallery Available: http://www.businesswire.com/cgi-bin/mmg.cgi?eid=6369638&#9001;=en  Contacts  The Coca-Cola Company Kenth Kaerhoeg, +1 (404) 676-2683 pressinquiries@na.ko.com  Permalink: http://www.businesswire.com/news/home/20100722006214/en/Board-Directors-Coca-Cola-Company-Announces-Quarterly-Dividend', 'http://bit.ly/bGOih0', 'Appointment', 'Ed Steinike was appointed Chief Information Officer of The Coca-Cola Company', 'Before rejoining The Coca-Cola Company in April, Mr. Steinike served as Executive Vice President and Chief Information Officer at ING Insurance. Prior to ING, he was The Coca-Cola Company&#65533;s Chief Development Officer and CIO of its North America business from 2004 to 2007. From 2002 to 2004, Mr. Steinike was the Company&#65533;s Chief Technology Officer. Prior to joining The Coca-Cola Company, he worked at General Electric between 1976 and 2002, holding positions of increasing responsibility including CIO for GE Energy and GE Medical Systems. Mr. Steinike holds a Bachelor of Science degree from Marquette University. ', 'The Coca-Cola Company (NYSE: KO) is the world\\''s largest beverage company, refreshing consumers with more than 500 sparkling and still brands. Along with Coca-Cola®, recognized as the world\\''s most valuable brand, the Company\\''s portfolio includes 12 other billion dollar brands, including Diet Coke®, Fanta®, Sprite®, Coca-Cola Zero®, vitaminwater®, POWERADE®, Minute Maid®, Simply® and Georgia Coffee®. Globally, we are the No. 1 provider of sparkling beverages, juices and juice drinks and ready-to-drink teas and coffees. Through the world\\''s largest beverage distribution system, consumers in more than 200 countries enjoy the Company\\''s beverages at a rate of 1.6 billion servings a day. With an enduring commitment to building sustainable communities, our Company is focused on initiatives that protect the environment, conserve resources and enhance the economic development of the communities where we operate. For more information about our Company, please visit our website at www.thecoca-colacompany.com.', 'http://www.businesswire.com/news/home/20100722006214/en/Board-Directors-Coca-Cola-Company-Announces-Quarterly-Dividend', '2010-07-26', '2010-07-29', 0, 'msobolev', 0);
INSERT INTO `cto_contact` VALUES(152, 'Jeremy', '', 'Hopkins', 'Chief Information Officer', 'JHopkins@wtgcom.com', '310.456.2200', 'World Telecom Group', 'Jeremy-Hopkins-Appointed-CIO-at-World-Telecom-Group', 'www.worldtelecomgroup.com', '$1-10 Million', '0-25', 'Business Services Other', 7, 17, '22761 Pacific Coast Hwy Ste 101', '', 'Malibu', 'CA', 'USA', '90265', '2010-07-28', '2010-07-28', 'Company Announcement', 'World Telecom Group Announces the Appointment of Jeremy Hopkins to CFO/CIO', 'World Telecom Group Announces the Appointment of Jeremy Hopkins to CFO/CIO                                                                                                                                                                                             Wednesday 28 July 2010 3:48 pm                                                                                                                                                                                              World Telecom Group (WTG); a premier Master Agency with the most diverse telecom portfolio in the industry has appointed Jeremy Hopkins to the position of Chief Financial Officer/Chief Information Officer. Hopkins primary responsibilities will include managing all financial and technological matters within the organization. He will report directly to CEO; Vince Bradley.                                                                                                                                                                                             Bradley stated; “I am extremely excited to have someone of Jeremy’s caliber as part of WTG’s management team. As we approach 100% complete automation overlay; his expertise will allow us to take our CRM to the next level.”                                                                                                                                                                                             Hopkins is an accomplished consultant in delivering highly effective Sales Force Automation (SFA) technology applications. In addition to over 12 years of technology management consulting experience spanning North America; Asia and Europe; he has built up seven years of targeted expertise in deploying CRM (Customer Relationship Management) systems for both Fortune 500 companies and Small and Medium Sized Enterprises (SMEs). Hopkins specializes in systems analysis; data modeling; user interface design and project management in the development B2B Web Portals; servicing centralized call center operations; distributed retail and wholesale/broker-based business. He has been entrusted to develop multiple projects with eight figure investment portfolios.                                                                                                                                                                                             Hopkins said “I am elated to be working with such an impressive team of individuals and look forward to working with our Provider and Agent Partners in the near future.”                                                                                                                                                                                              Hopkins holds an MBA degree from The University of Chicago Booth School of Business; a top-five program in the United States and the Midwestern powerhouse of finance; banking and economics. In addition; he has served as an adjunct professor of marketing in the undergraduate business division of his alma mater; Pepperdine University.                                                                                                                                                                                             To contact Jeremy Hopkins directly; please reach him at 310.456.2200 or via e-mail JHopkins@wtgcom.com. For more information about WTG please go to www.worldtelecomgroup.com.                                                                                                                                                                                             About World Telecom Group                                                                                                                                                                                             World Telecom Group (WTG) is a premier Master Agent providing exceptional service to agent partners since 1996. WTG has the most diverse portfolio in the industry with over 100 Providers; including local; long-distance; data and internet. It also includes the following specialty Divisions with dedicated extra support: LEC; award winning Wireless/Mobility; Equipment; Wholesale; Cost Containment (TEM; Logistics and all other Cost Containment) and Energent; its extremely fast growing Energy Division (Electricity; Natural Gas and DSM). WTG Agents have the ability to sell and consistently expand their business without commitments or quotas. WTG is 100% partner driven and pays top commissions in the industry. WTG exceeds expectations with a dynamic approach to automation; partner support and its commitment to success.                                                                                                                                                                                             Press Contact:                                                                                                                                                                                             Salwa Scarpone                                                                                                                                                                                             sscarpone@wtgcom.com                                                                                                                                                                                             310.456.2200', 'http://bit.ly/8Xe0rF', 'Appointment', 'World Telecom Group appointed Jeremy Hopkins as Chief Information Officer', 'Jeremy Hopkins is an accomplished consultant in delivering highly effective Sales Force Automation (SFA) technology applications. In addition to over 12 years of technology management consulting experience spanning North America; Asia and Europe; he has built up seven years of targeted expertise in deploying CRM (Customer Relationship Management) systems for both Fortune 500 companies and Small and Medium Sized Enterprises (SMEs).  Hopkins holds an MBA degree from The University of Chicago Booth School of Business.', 'World Telecom Group (WTG) is a premier Master Agent providing exceptional service to agent partners since 1996. WTG has the most diverse portfolio in the industry with over 100 Providers; including local; long-distance; data and internet. It also includes the following specialty Divisions with dedicated extra support: LEC; award winning Wireless/Mobility; Equipment; Wholesale; Cost Containment (TEM; Logistics and all other Cost Containment) and Energent; its extremely fast growing Energy Division (Electricity; Natural Gas and DSM). WTG Agents have the ability to sell and consistently expand their business without commitments or quotas. WTG is 100% partner driven and pays top commissions in the industry. WTG exceeds expectations with a dynamic approach to automation; partner support and its commitment to success.', 'http://www.worldtelecomgroup.com/?p=318', '2010-08-05', '2010-08-05', 0, 'msobolev', 0);
INSERT INTO `cto_contact` VALUES(153, 'Laurence', '', 'O\\''Hagan', 'Chief Technology Officer', 'laurence.ohagan@streamserve.com', '781.761.6600', 'StreamServe', 'Laurence-O\\''Hagan-Appointed-CTO-at-StreamServe', 'www.streamserve.com', '$1-10 Million', '0-25', 'Management Consulting', 7, 14, '1 Van de Graaff Dr', '', 'Burlington', 'MA', 'USA', '01803', '2010-07-20', '2010-07-20', 'Press Release', 'Electronic Printing and Customer Communications Veteran Laurence O&#65533;Hagan Joins StreamServe as Chief Technology Officer', 'Electronic Printing and Customer Communications Veteran Laurence O&#65533;Hagan Joins StreamServe as Chief Technology Officer                                                                                                                                                                                              July 20, 2010                                                                                                                                                                                             O&#65533;Hagan will leverage his past experience to drive the strategic vision and innovative planning behind StreamServe&#65533;s newest business communications solutions                                                                                                                                                                                              BURLINGTON, Mass.--(BUSINESS WIRE)--StreamServe, a leading provider of business communication solutions for document efficiency and customer experience management, announces the appointment of Laurence O&#65533;Hagan to the position of Chief Technology Officer. In this role, O&#65533;Hagan will be responsible for driving the strategic vision and planning behind StreamServe&#65533;s innovative solutions, product development and technical support.                                                                                                                                                                                              &#65533;Through his technical expertise, as well as his product and market vision, he will help us drive our product planning and developments to extend our technology into newer areas, such as cloud-based offerings.&#65533;                                                                                                                                                                                             O&#65533;Hagan brings a tremendous amount of senior technical experience and visionary leadership to StreamServe, and is considered an industry expert in the field of document automation and related technologies. He was most recently Chief Technology Officer for the Customer Communications Management division of Pitney Bowes Business Insight (PBBI), a position he was appointed to in 2004, when Pitney Bowes acquired Group 1 Software. At PBBI, he conceived and architected DOC1, the company&#65533;s core flagship solution for Customer Communications Management, as well as other pivotal products, including EngageOne Interactive and Content Author. In 2009, he additionally assumed the Global Portfolio Directorship for Customer Communications Management, responsible for its vision and strategy.                                                                                                                                                                                              O&#65533;Hagan was Chief Technology Officer of Customer Communications Systems at Group 1 Software between 1994 through 2004. He also held the position of President and Technical Director at Archetype, Inc., from 1986 to 1994. O&#65533;Hagan attended University College of London, where he was trained as a physicist.                                                                                                                                                                                              &#65533;We are absolutely thrilled with Laurence&#65533;s new role with StreamServe,&#65533; commented Dennis Ladd, StreamServe&#65533;s president and CEO. &#65533;Through his technical expertise, as well as his product and market vision, he will help us drive our product planning and developments to extend our technology into newer areas, such as cloud-based offerings.&#65533;                                                                                                                                                                                              &#65533;StreamServe is well known for how it&#65533;s innovative and flexible customer communications management solutions integrate seamlessly with larger partner offerings, such as SAP and Adobe,&#65533; said O&#65533;Hagan. &#65533;I look forward to leveraging my past technical experience to advance StreamServe&#65533;s product offerings and to further propel the company&#65533;s leadership in the marketplace.&#65533;                                                                                                                                                                                              About StreamServe                                                                                                                                                                                              StreamServe is a leading provider of enterprise business communication solutions. Simple to deploy and maintain, the company&#65533;s dynamic composition, document process automation and enterprise output management solutions meet the demanding challenges of today&#65533;s global businesses for producing and delivering highly customized documents in any format.                                                                                                                                                                                              StreamServe&#65533;s advanced software solutions ease the process of composing and automating business communications, enabling organizations to increase the value and profitability of their business relationships. This is done all while leveraging existing business applications such as ERP, CRM and ECM.                                                                                                                                                                                              The company was founded in 1997 and is headquartered in Burlington, Mass., with 14 offices worldwide. StreamServe serves more than 5,000 customers in 130 countries, primarily in the financial services, utilities, manufacturing, distribution and telecom sectors. Customers include BMW, CLP Power Hong Kong, AmerisourceBergen, and Siemens Financial. StreamServe&#65533;s strategic partners include Adobe Systems, IBM, InfoPrint Solutions Company, Lawson and SAP AG. To learn how StreamServe&#65533;s business communications solutions can help drive efficiency and improve costs within your organization, please visit StreamServe online at http://www.streamserve.com, or join the conversation on StreamShare&#65533;, StreamServe&#65533;s online community forum: http://streamshare.streamserve.com/.                                                                                                                                                                                              StreamServe, StreamShare, and the StreamServe logo are all trademarks of StreamServe Inc. Some software products marketed by StreamServe Inc. and its distributors contain proprietary software components of other software vendors. All other product and service names mentioned are the trademarks of their respective companies. ©StreamServe Inc. 2010                                                                                                                                                                                              Photos/Multimedia Gallery Available: http://www.businesswire.com/cgi-bin/mmg.cgi?eid=6366157&#9001;=en                                                                                                                                                                                              Contacts                                                                                                                                                                                              StreamServe contacts:                                                                                                                                                                                             Peter J. Gorman, 781-761-6659 Mobile: 617-669-4329                                                                                                                                                                                              Sr. Director, Corporate Communications                                                                                                                                                                                             Email: peter.gorman@streamserve.com                                                                                                                                                                                             Twitter: http://twitter.com/StreamServe                                                                                                                                                                                             Facebook: http://bit.ly/dkOpQG                                                                                                                                                                                             StreamShare: http://streamshare.streamserve.com                                                                                                                                                                                             Web: http://www.streamserve.com', '', 'Appointment', 'StreamServe appointed Laurence O&#65533;Hagan as Chief Technology Officer', 'Laurence O&#65533;Hagan was most recently Chief Technology Officer for the Customer Communications Management division of Pitney Bowes Business Insight (PBBI), a position he was appointed to in 2004, when Pitney Bowes acquired Group 1 Software.', 'StreamServe is a leading provider of enterprise business communication solutions. Simple to deploy and maintain, the company&#65533;s dynamic composition, document process automation and enterprise output management solutions meet the demanding challenges of today&#65533;s global businesses for producing and delivering highly customized documents in any format. ', 'http://www.businesswire.com/news/home/20100720006504/en/Electronic-Printing-Customer-Communications-Veteran-Laurence-O%E2%80%99Hagan', '0000-00-00', '2010-08-08', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(172, 'Tony', '', 'Hildesheim', 'Senior Vice President of Information Technology', 'thildesheim@redwoodcu.org', '707.545.4000', 'Redwood Credit Union', 'Tony-Hildesheim-Appointed-SVPIT-at-Redwood-Credit-Union', 'www.redwoodcu.org', '$100 - 250M', '100 - 250', 'Credit Card and Related Services', 54, 56, '1701 4th St', '', 'Santa Rosa', 'CA', 'USA', '95404', '0000-00-00', '0000-00-00', 'News', 'ON THE MOVE', '"ON THE MOVE<br/>Business<br/>ON THE MOVE <br/>11 July 2010<br/>Press Democrat<br/>Catherine ""Kay"" Marquez of Alain Pinel Realtors in Santa Rosa has earned the Certified Distressed Property Expert designation. The certification training focuses on foreclosure avoidance,with emphasis on short sales.<br/>Tony Hildesheim has been named senior vice president of information technology at Redwood Credit Union in Santa Rosa. He was vice president of information technology for Washington State Employee Credit Union in Olympia,Washington.<br/>Nancy Woods and Ashlei Kilkenny have been named to sales positions at Balletto Vineyards in Santa Rosa. Kilkenny is sales and marketing director,and Woods is direct-to-consumer sales manager.<br/>Douglas Christian has been named director of business development for Security Code 3 in Rohnert Park. A former firefighter and emergency medical technician,he was CEO of Grapevine Security Services in Santa Rosa.<br/>Petaluma''s First California Mortgage has opened an office in New Mexico,the ninth state in which it does business. Steve Mancilla,one of five certified mortgage planners in the state,has been named to manage the company''s new Albuquerque office.<br/>Jennifer Beck,M.D.,has moved her practice from Petaluma to 1400 Dutton Ave.,No. 6,in Santa Rosa. Her WellMind Center provides Transcranial Magnetic Stimulation therapy to patients suffering from depression.<br/>Jason Cotter has been named North Coast sales manager for Real Goods Solar,which has eight offices throughout California and Colorado. He will manage sales for Real Goods Solar''s Santa Rosa and Ukiah offices.<br/>Work World in Santa Rosa has received Carhartt Inc.''s ""Retailer of Excellence"" award for promoting its brand of work clothing. The store at 1993 Santa Rosa Ave. is the largest of 16 Work World stores in California and Nevada."', '', 'Appointment', 'Hildesheim  appointed Tony Hildesheim  as Senior Vice President of Information Technology', 'Tony Hildesheim was previosly the vice president of information technology for Washington State Employee Credit Union in Olympia,Washington.', 'Redwood Credit Union is a full-service community credit union serving anyone living/,working or owning a small business in the North Bay or San Francisco.', 'http://www.shoretel.com/resource_center/success_stories/Washington_State_Employees_Credit_Union.html\r\n', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(173, 'Nial', '', 'McLoughlin', 'Chief Technology Officer', 'nmcloughlin@ashworthcollege.edu', '770.729.2400', 'Ashworth College', 'Nial-McLoughlin-Appointed-CTO-at-Ashworth-College', 'www.ashworthcollege.edu', '$1-10 Million', '25-100', 'Colleges and Universities', 38, 39, '430 Technology Pkwy', '', 'Norcross', 'GA', 'USA', '30092', '2010-08-09', '2010-08-09', 'Press Release', 'Ashworth College Appoints New Chief Technology Officer and Director of Information Technology', 'Ashworth College Appoints New Chief Technology Officer and Director of Information Technology Ashworth College, a top provider of online education, announced that Nial McLoughlin has been appointed Chief Technology Officer and Director of Information Technology. He brings 16 plus years of business and technology management experience.   FOR IMMEDIATE RELEASE PRLog (Press Release) &#65533; Aug 09, 2010 &#65533; NORCROSS, Georgia &#65533; Ashworth College, a leading provider of accredited, online education programs, announced today that Nial McLoughlin has been appointed Chief Technology Officer and Director of Information Technology. McLoughlin brings more than 16 years of experience in business and technology management to his new role at Ashworth (http://www.ashworthcollege.edu).   Prior to Ashworth, McLoughlin ran a small software business delivering technology solutions to the airline industry, growing this business from a small, one-customer business to a provider to the nation&#65533;s largest airlines. He also spent a number of years in the technology consulting world, primarily with Sapient &#65533; a leading interactive consulting firm, providing technology solutions to customers ranging from small start-ups to Fortune 100 companies.     \\"We&#65533;re excited to have Nial as part of the Ashworth team. His technology expertise will help ensure that Ashworth continues to grow as a global player in today&#65533;s highly competitive for-profit education arena,&#65533; said Gary Keisling, Ashworth Chairman and CEO.   McLoughlin has a Bachelor&#65533;s Degree in Finance from the University of Florida and a Master&#65533;s Degree in Computer Science from Georgia State University. He and his wife have three sons and in his spare time he enjoys biking, running and triathlons.  # # # About Ashworth College   Ashworth College, a leader in online education, offers students worldwide more than 100 online degrees, online certificate programs, online career training and online high school diplomas that are affordable and fit the busy schedules of working adults. Ashworth also offers specialized programs to corporate partners, active duty military personnel, military spouses, and homeschoolers.   Headquartered in Norcross, GA, Ashworth is accredited by the Distance Education and Training Council (DETC). The Accrediting Commission of the DETC is listed by the U.S. Department of Education as a nationally recognized accrediting agency. Ashworth High School is further accredited by the Southern Association of Colleges and Schools Council on Accreditation and School Improvement (SACS CASI). For more information, visit http://www.ashworthcollege.edu.', 'http://bit.ly/c7rBZd', 'Appointment', 'Ashworth College appointed Nial McLoughlin as Chief Technology Officer', 'Prior to Ashworth, Nial McLoughlin ran a small software business delivering technology solutions to the airline industry, growing this business from a small, one-customer business to a provider to the nation&#65533;s largest airlines. ', 'Ashworth College, a leader in online education, offers students worldwide more than 100 online degrees, online certificate programs, online career training and online high school diplomas that are affordable and fit the busy schedules of working adults.', 'http://www.prlog.org/10839310-ashworth-college-appoints-new-chief-technology-officer-and-director-of-information-technology.html', '2010-08-09', '2010-08-09', 0, 'msobolev', 0);
INSERT INTO `cto_contact` VALUES(174, 'Ted', '', 'Hengst', 'Chief Information Officer', 'ted.hengst@harris.com', '321.727.9100', 'Harris Corporation', 'Ted-Hengst-Appointed-CIO-at-Harris-Corporation', 'www.harris.com', ' > $ 1 Billion', '10K-50K', 'Telecommunication Equipment and Accessories', 144, 146, '1025 W Nasa Blvd', '', 'Melbourne', 'FL', 'USA', '32919', '2010-08-06', '2010-08-06', 'Press Release', 'Harris Corporatio Names Ted Hengst Corporate Vice President and Chief Information Officer', 'Harris Corporation Names Ted Hengst Corporate Vice President and Chief Information Officer   MELBOURNE, Fla., Aug. 6 /PRNewswire-FirstCall/ -- Harris Corporation (NYSE: HRS), an international communications and information technology company, has named Ted Hengst corporate vice president and chief information officer (CIO), reporting to Howard L. Lance, chairman, president and CEO.  Hengst, 55, has served as president of Harris IT Services since joining Harris in December 2006.  In his role as CIO, Hengst will have responsibility for setting the strategic direction, architecture and governance of Harris\\'' global IT enterprise to drive innovation, fuel growth, and enable transformation to advance our customers\\'' and Harris\\'' competitive advantage through the use of information technology.  Prior to joining Harris, Hengst served as a senior vice president for General Dynamics.  Previously, he served in the U.S. Army, retiring at the rank of Colonel.  His last assignment was as CIO (J6) at U.S. Special Operations Command at MacDill AFB, Florida.  As CIO, Hengst was responsible for planning, funding and execution of all phases of information, computing and communications resources for a 46,000-person command.  Hengst earned a bachelor\\''s degree in engineering from the U.S. Military Academy at West Point and a master\\''s degree in management information systems from the Naval Post Graduate School. \\"Ted is extremely well qualified for this strategic role within our organization and is the ideal leader to deliver innovative, transformational solutions to advance our customer missions by leveraging the power of IT,\\" said Lance.  \\"Under his leadership, our IT Services business has more than doubled and has become an industry recognized leader.\\" A high resolution photo is available at the following link:  Ted Hengst.  About Harris Corporation Harris is an international communications and information technology company serving government and commercial markets in more than 150 countries. Headquartered in Melbourne, Florida, the company has approximately $5 billion of annual revenue and more than 15,000 employees — including nearly 7,000 engineers and scientists. Harris is dedicated to developing best-in-class assured communications® products, systems, and services. Additional information about Harris Corporation is available at www.harris.com.', '', 'Appointment', 'Harris Corporation appointed Ted Hengst as Chief Information Office', 'Prior to joining Harris, Hengst served as a senior vice president for General Dynamics.  Previously, he served in the U.S. Army, retiring at the rank of Colonel.', 'Harris is an international communications and information technology company serving government and commercial markets in more than 150 countries.', 'http://www.prnewswire.com/news-releases/harris-corporation-names-ted-hengst-corporate-vice-president-and-chief-information-officer-100108939.html', '2010-08-09', '0000-00-00', 0, 'msobolev', 0);
INSERT INTO `cto_contact` VALUES(175, 'Bridget', '', 'OConnor', 'Chief Technology Officer', 'bridget.oconnor@bankofamerica.com', '800.432.1000', 'Bank of America', 'Bridget-OConnor-Appointed-CTO-at-Bank-of-America', 'www.bankofamerica.com', ' > $ 1 Billion', ' >100K', 'Personal Financial Planning & Private Banking', 54, 60, '100 N Tryon St Ste 3600', '', 'Charlotte', 'NC', 'USA', '28202', '2010-08-06', '2010-08-06', 'Press Release', 'Bank of America Names Bridget OConnor Chief Technology Officer for Consumer and Small Business Banking and Home Loans and Insurance and Customer Segments Technology Executive', 'Bank of America Names Bridget O\\''Connor Chief Technology Officer for Consumer and Small Business Banking and Home Loans and Insurance and Customer Segments Technology Executive  Aug 6, 2010 CHARLOTTE, N.C.--(BUSINESS WIRE)--Bank of America announced today that Bridget O&#65533;Connor has been named chief technology officer for Consumer and Small Business Banking (CSBB) and Home Loans and Insurance (HL&I), responsible for leading the team that supports strategy, architecture, design and build, operations, engagement and product delivery of technology infrastructure for the CSBB and HL&I businesses.  &#65533;With her on our team, we have further strengthened our ability to achieve business alignment and agility along with the leverage of our global scale.&#65533; She will also act as the CSBB Customer Segments Technology executive and will lead the delivery of technology that supports customer segments, responsible for the CSBB technology strategy, architecture, and data and information management that are aligned with the company&#65533;s strategy that puts customer needs at the center of everything.  O&#65533;Connor will join the bank in mid-August, reporting to both Chief Technology Officer Marc Gordon and CSBB Technology and Operations and HL&I Technology Executive Vlad Torgovnik.  &#65533;Bridget is a seasoned technology executive who has spent more than 20 years successfully building and leading large-scale, business-aligned technology teams,&#65533; Gordon said. &#65533;With her on our team, we have further strengthened our ability to achieve business alignment and agility along with the leverage of our global scale.&#65533;  O&#65533;Connor joins Bank of America from Depository Trust & Clearing Corporation (DTCC), where she was managing director and chief technology officer responsible for overseeing the critical information technology infrastructure, including core network services, processing and messaging systems, distributed systems and business continuity.  Prior to DTCC, O&#65533;Connor spent 19 years at Lehman Brothers and held numerous technology management positions including chief information officer, global head of business continuity, chief technology officer and senior vice president and global head of e-commerce technology. During her time with Lehman Brothers, she designed the firm&#65533;s web portal, which was recognized as an industrywide benchmark in both content and infrastructure.  &#65533;Bridget brings a variety of experience that will allow our teams to deliver high-impact results and focus on understanding the ever-changing needs of our customers,&#65533; said Torgovnik. &#65533;By aligning customer requirements with technology strategy, we are able to take advantage of the innovative opportunities to improve the overall customer experience.&#65533;  Bank of America  Bank of America is one of the world\\''s largest financial institutions, serving individual consumers, small- and middle-market businesses and large corporations with a full range of banking, investing, asset management and other financial and risk management products and services. The company provides unmatched convenience in the United States, serving approximately 57 million consumer and small business relationships with 5,900 retail banking offices, more than 18,000 ATMs and award-winning online banking with 29 million active users. Bank of America is among the world\\''s leading wealth management companies and is a global leader in corporate and investment banking and trading across a broad range of asset classes, serving corporations, governments, institutions and individuals around the world. Bank of America offers industry-leading support to approximately 4 million small business owners through a suite of innovative, easy-to-use online products and services. The company serves clients through operations in more than 40 countries. Bank of America Corporation stock (NYSE: BAC) is a component of the Dow Jones Industrial Average and is listed on the New York Stock Exchange.  www.bankofamerica.com  Contacts  Reporters May Contact: Christopher Feeney, Bank of America, 980-386-6794 Christopher.Feeney@bankofamerica.com', '', 'Appointment', 'Bank of America, Consumer and Small Business Banking (CSBB) and Home Loans and Insurance (HL&I) appointed Bridget O\\''Connor as Chief Technology Officer', 'Bridget O\\''Connor was previously with Bank of America from Depository Trust & Clearing Corporation (DTCC), where she was managing director and chief technology officer responsible for overseeing the critical information technology infrastructure, including core network services, processing and messaging systems, distributed systems and business continuity.', 'Bank of America is one of the world\\''s largest financial institutions, serving individual consumers, small- and middle-market businesses and large corporations with a full range of banking, investing, asset management and other financial and risk management products and services. ', 'http://www.businesswire.com/news/beverlyhillschamber/20100806005017/en/Bank-America-Names-Bridget-O%E2%80%99Connor-Chief-Technology', '2010-08-09', '2010-08-09', 0, 'msobolev', 0);
INSERT INTO `cto_contact` VALUES(176, 'Joe', '', 'Simon', 'Chief Technology Officer', 'joe_simon@condenast.com', '212.286.3700', 'Conde Nast', 'Joe-Simon-Appointed-CTO-at-Conde-Nast', 'www.condenast.com', ' > $ 1 Billion', '1K-10K', 'Newspapers, Books and Periodicals', 98, 102, '4 Times Sq', '', 'New York', 'NY', 'USA', '10036', '2010-08-04', '2010-08-04', 'News', 'Conde Nast Names a Chief Technology Officer', 'Conde Nast Names a Chief Technology Officer Published: August 4, 2010 Condé Nast continued its retooling on Wednesday with the appointment of Joe Simon as chief technology officer. Mr. Simon, 48, was previously chief technology officer for Viacom Inc.  Robert A. Sauerberg Jr., Condé Nast’s new president, said in an interview that Mr. Simon represented a “match made in heaven for us as we start the process of expanding our offerings for our consumers.”  The appointment, he said, comes at a time when the company is “increasingly focusing on brand development and consumer revenues and building on the great foundation that we have with our magazines.”  The move follows a series of recent changes in the company’s senior leadership, including the appointment of Mr. Sauerberg as president just over a week ago. He was previously group president for consumer marketing.  Other moves include John Bellando taking the role of chief financial officer in addition to being chief operating officer, and Louis Cona being named chief marketing officer. Charles H. Townsend and Thomas J. Wallace continue to serve as chief executive officer and editorial director, respectively.  When asked if the company would announce any more moves, Mr. Sauerberg said, “As you go to push the envelope in media I think change is inevitable.” Mr. Simon could not be reached for comment.  Condé Nast has also discussed moving its offices from Times Square to Lower Manhattan. The company has signed a tentative deal with the Port Authority of New York and New Jersey and would become the largest private tenant so far at 1 World Trade Center. A move would be unlikely before 2014. ', '', 'Appointment', 'Conde Nast appointed Joe Simon as Chief Technology Officer', 'Joe Simon, 48, was previously chief technology officer for Viacom Inc. ', 'Publisher of established magazines covering fashion, technology, food, and travel, including The New Yorker, Vogue, and Wired.', 'http://www.nytimes.com/2010/08/05/business/media/05mag.html?_r=1&src=busln', '2010-08-09', '0000-00-00', 0, 'msobolev', 0);
INSERT INTO `cto_contact` VALUES(177, 'Markus', '', 'Nordlin', 'Chief Information Officer', 'markus.nordlin@zurich.com', '847.605.6000', 'Zurich', 'Markus-Nordlin-Promoted-To-CIO-at-Zurich', 'www.zurich.com', ' > $ 1 Billion', '50K-100K', 'Insurance and Risk Management', 54, 57, '1400 American Ln', '', 'Schaumburg', 'IL', 'USA', '60196', '2010-08-09', '2010-08-09', 'Company Announcement', 'Markus Nordlin appointed Chief Information Technology Officer', 'Markus Nordlin appointed Chief Information Technology Officer Zurich, August 9, 2010 – Zurich Financial Services Group (Zurich) announces the appointment of Markus Nordlin (46, Finnish and U.S. citizen) to the position of Chief Information Technology Officer (CITO) and member of the Group Management Board, effective September 1, 2010. He succeeds Michael Paravicini, who will retire. In his new role, Mr. Nordlin will continue the transformational journey that Zurich and Group IT have undertaken and leverage these capabilities to support Zurich to achieve its ambitious business goals. He will report into Kristof Terryn, Group Head of Operations, and will be located in Zurich, Switzerland. Mr. Nordlin joined Zurich in 1999 from Accenture (formerly Andersen Consulting). Since 2004 he served as the Group IT Key Account Executive for the Farmers Insurance Group (Farmers), being responsible for developing the IT Roadmaps supporting Farmers’ business strategy across all business units and functions. Most recently, he has been responsible for managing Zurich’s service agreement with CSC for the provision of data center and IT infrastructure services in Europe and North America, covering data center centralization and server virtualization. Mr. Nordlin holds a Bachelor of Science in Civil Engineering from Brigham Young University and a Master of Business Administration from the University of California, Los Angeles. For high resolution pictures supporting this news release, please visit www.zurich.com/multimedia. In case you have any questions, please email journalisthelp@thenewsmarket.com. Zurich Financial Services Group (Zurich) is an insurance-based financial services provider with a global network of subsidiaries and offices in North America and Europe as well as in Asia-Pacific, Latin America and other markets. Founded in 1872, the Group is headquartered in Zurich, Switzerland. It employs approximately 60,000 people serving customers in more than 170 countries. For additional information please contact: Group Media Relations Phone: +41 (0)44 625 21 00 Fax: +41 (0)44 625 26 41 Zurich Financial Services Ltd Mythenquai 2, P.O. Box, 8022 Zurich, Switzerland SIX Swiss Exchange/SMI: ZURN Valor: 001107539', '', 'Promotion', 'Zurich promoted Markus Nordlin to Chief Information Officer', 'Mr. Nordlin joined Zurich in 1999 from Accenture (formerly Andersen Consulting). Since 2004 he served as the Group IT Key Account Executive for the Farmers Insurance Group (Farmers), being responsible for developing the IT Roadmaps supporting Farmers’ business strategy across all business units and functions. ', 'Zurich Financial Services Group (Zurich) is an insurance-based financial services provider with a global network of subsidiaries and offices in North America and Europe as well as in Asia-Pacific, Latin America and other markets. ', 'http://www.zurich.com/main/media/newsreleases/2010/english/2010_0908_01_article.htm', '2010-08-09', '2010-08-09', 0, 'msobolev', 0);
INSERT INTO `cto_contact` VALUES(178, 'Doug', '', 'Horner', 'Chief Technology Officer', 'dhonner@mieweb.com', '260.459.6270', 'Medical Informatics Engineering', 'Doug-Horner-Appointed-CTO-at-Medical-Informatics-Engineering', 'www.mieweb.com', '$0-1 Million', '0-25', 'Medical Supplies & Equipment', 70, 75, '6302 Constitution Dr', '', 'Fort Wayne', 'IN', 'USA', '46804', '2010-08-09', '2010-08-09', 'Press Release', 'Press Release', 'Press Release  Fort Wayne, Ind. - August 9, 2010 - Bruce Lisanti, a leader in the business technology community, has been named Chief Executive Officer and President of Medical Informatics Engineering (MIE), a healthcare information technology company. MIE offers advanced web-based products that simplify the automation of medical records in physician practices and clinics, and integrate with consumer health platforms to improve the management and sharing of medical records.  For the past 15 years, Mr. Lisanti has been a principal at several successful high technology companies. As a technology executive with extensive experience in marketing, channel development, M&A and strategic planning, he has helped build several companies from early stage development to over $500 million in revenue. Prior to these achievements, Mr. Lisanti worked for Electronic Data Systems (EDS) and at General Electric Company (GE) where he was instrumental in growing the Computer Services Division from start-up to over $1.2 billion of revenue.  “With the pending changes in the US healthcare system and with meaningful use criteria now finalized under the HITECH Act\\''s electronic health records (EHR) incentive program, there is an unprecedented opportunity for growth and expansion in the healthcare IT industry,” said Mr. Lisanti. “Electronic health records can enable physicians, hospitals, labs and patients to work together more easily. When combined with fully functional personal health records (PHR), electronic communication and access to information can substantially reduce the overall costs of the healthcare system. As one of the only fully integrated, web-based EHR systems available today, MIE has an enormous opportunity to become a leader in this space.” “MIE has already demonstrated an impressive ability to promote the broad adoption of this technology on a regional scale,” Lisanti continued. “The MIE Health Information Exchange is currently utilized by over 90 percent of the physicians in Northeast Indiana with 55 percent of these doctors using the WebChart EHR system from MIE. Our goal is to take this model nationally, positioning MIE as a leader in healthcare IT.”  “While many EHR vendors are scrambling to meet the new meaningful use standards, MIE’s WebChart EHR Now product has been specifically designed to meet the meaningful use criteria,” said Lisanti. “Our web-based implementation process provides great flexibility, allowing physicians to tailor the system to their practice, rather than requiring them to alter the way they practice medicine, a common complaint in the industry.”  “We are also very well positioned in the corporate environment due to our experience with Fortune 500 companies such as Google who operate on-site employee health clinics,” said Lisanti. “As one of the proven industry leaders in the enterprise health arena, we see a huge opportunity here as companies look to improve the health care provided to their employees while lowering costs.”  Mr. Lisanti’s new role is effective immediately. Company founder, Doug Horner, remains with MIE as Chief Technology Officer and Chairman of the Board. “I could not be more pleased that Bruce has joined our team as CEO and I look forward to concentrating on further product innovation,” said Doug Horner. “For the past 15 years, I have been stretched between the development of our technology and building the company. Bruce is the ideal person to drive the company for growth.” For more information on Medical Informatics Engineering, please visit http://www.mieweb.com.  About Medical Informatics Engineering (MIE): Founded in 1995, MIE has developed the WebChart EHR portfolio, a minimally invasive™ EHR which operates on any web browser or mobile device, including iPads or Smartphones. WebChart is offered as a SaaS model which requires no investment in on-site servers, or as a hosted model which can scale from a single server to a multi-server cluster operating in a client data center. WebChart EHR systems are deployed in small family practices, large multi-specialty clinics and global Fortune 500 on-site employee clinics. This minimally invasive approach was designed to be: - Accessible – web-based to provide secure access to patient records anytime, anywhere, from any web browser. - Interoperable – designed to play well in the sandbox with other healthcare IT applications using standard interoperability protocols. - Flexible – configured to integrate with established practice workflow and available in modular, scalable increments. - Affordable – MIE’s Software as a Service model requires less investment in hardware, and the minimally invasive approach leads to faster, wider adoption – speeding practice ROI. More information can be found at www.mieweb.com ', '', 'Lateral Move', 'Medical Informatics Engineering appointed Doug Horner as Chief Technology Officer', 'Doug has nearly two decades of software industry experience, building expertise in systems, networks, and management.', 'Founded in 1995, MIE has developed the WebChart EHR portfolio, a minimally invasive™ EHR which operates on any web browser or mobile device, including iPads or Smartphones. ', 'http://www.insideindianabusiness.com/newsitem.asp?ID=43050', '2010-08-10', '2010-08-10', 0, 'msobolev', 0);
INSERT INTO `cto_contact` VALUES(190, 'Jeri', '', 'Lose', 'Chief Information Officer', 'jeri_lose@uhc.com', '952.936.1300', 'UnitedHealthcare', 'Jeri-Lose-Appointed-CIO-at-UnitedHealthcare', 'www.uhc.com', '$1-10 Million', '50K-100K', 'Healthcare, Pharmaceuticals, & Biotech Other', 70, 81, '6300 Highway 55', '', 'Minneapolis', 'MN', 'USA', '55427', '2010-08-01', '2010-08-01', 'LinkedIn Update', 'LinkedIn Update', 'Jeri Lose </br>Chief Information Officer at UnitedHealthcare </br>Location</br>Greater Minneapolis-St. Paul Area </br>Industry</br>Hospital & Health Care </br>Current </br>• Chief Information Officer at UnitedHealthcare </br>Past </br>• Vice President, IT Management at Cardinal Health/CareFusion, Inc. </br>• EVP & CIO at Apria Healthcare, Inc. </br>• Board of Directors at Apria Healthcare ', '', 'Appointment', 'UnitedHealthcare appointed Jeri Lose as Chief Information Officer', 'Jeri Lose was perviously Vice President, IT Management at Cardinal Health/CareFusion, Inc.', 'United Health Group is one of the leading companies in the healthcare industry. Through its services, the company is serving more than 70 million America', 'http://www.linkedin.com/pub/jeri-lose/a/7a9/517', '0000-00-00', '2010-08-13', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(191, 'Michael', '', 'Miotto', 'Chief Technology Officer', 'mmiotto@creditacceptance.com', '248.353.2700 x4423', 'Credit Acceptance Corp.', 'Michael-Miotto-Promoted-To-CTO-at-Credit-Acceptance-Corp.', 'www.creditacceptance.com', '$100-500 Million', '250-1000', 'Credit Card and Related Services', 54, 56, 'Silver Triangle 25505 W 12 Mile Rd Ste 3000', '', 'Southfield', 'MI', 'USA', '48111', '2010-08-05', '2010-08-05', 'SEC Filing', 'Item 5.02 Departure of Directors or Certain Officers; Election of Directors; Appointment of Certain Officers; Compensatory Arrangements of Certain Officers. ', 'UNITED STATES SECURITIES AND EXCHANGE COMMISSION  WASHINGTON, D.C. 20549  FORM 8-K  CURRENT REPORT  Pursuant to Section 13 or 15(d) of the Securities Exchange Act of 1934           Date of Report (Date of Earliest Event Reported):     August 5, 2010   CREDIT ACCEPTANCE CORPORATION  __________________________________________ (Exact name of registrant as specified in its charter)           Michigan  000-20202  38-1999511  _____________________ (State or other jurisdiction  _____________ (Commission  ______________ (I.R.S. Employer  of incorporation)  File Number)  Identification No.)            25505 West Twelve Mile Road, Southfield, Michigan     48034-8339  _________________________________ (Address of principal executive offices)     ___________ (Zip Code)           Registrant’s telephone number, including area code:     248-353-2700  Not Applicable  ______________________________________________ Former name or former address, if changed since last report  Item 5.02 Departure of Directors or Certain Officers; Election of Directors; Appointment of Certain Officers; Compensatory Arrangements of Certain Officers.  Effective August 5, 2010, Michael Miotto was named Chief Technology Officer. Mr. Miotto was previously Chief Information Officer. John Neary, Senior Vice President – Operations Improvement, was named Chief Information Officer.  ', '', 'Promotion', 'Credit Acceptance Corp. promoted Michael Miotto to Chief Technology Officer', 'Michael Miotto was previously Chief Information Officer with Credit Acceptance', 'Credit Acceptance Corp. Provides funding, receivables management, collection, sales training and related services to automobile dealers. (Nasdaq:CACC).', 'http://www.sec.gov/Archives/edgar/data/885550/000129993310003041/htm_38690.htm', '2010-08-13', '2010-08-13', 0, 'msobolev', 0);
INSERT INTO `cto_contact` VALUES(148, 'David', '', 'Manser', 'Director of Technology', 'david.manser@tasc.com', '703.633.8300', 'TASC', 'David-Manser-Appointed-DT-at-TASC', 'www.tasc.com', '>100K', '>$1B', 'Software & Internet Other', 138, 143, '4805 Stonecroft Blvd', '', 'Chantilly', 'VA', 'USA', '20151', '2010-07-07', '2010-07-07', 'News', 'TASC, Inc. Appoints Retired Naval Aviator to Enterprise Systems Business Unit', '"TASC, Inc. Appoints Retired Naval Aviator to Enterprise Systems Business Unit                                                                                                                                                                                              TASC, Inc.                                                                                                                                                                                             7 July 2010                                                                                                                                                                                             PR Newswire (U.S.)                                                                                                                                                                                             CHANTILLY, Va., July 7 /PRNewswire/ -- TASC, Inc., the leading independent and non-conflicted provider of advanced systems engineering, integration and support services to the intelligence, defense and federal civilian markets, has named David Manser Director of Technology for TASC''s Enterprise Systems Business Unit. Manser joins TASC from Boeing, where he served as program manager and IT director on the company''s internal advanced experimental network, LabNet, which serves as the backbone for modeling, simulation and experimentation for future applications at agencies such as the Department of Defense, Department of Homeland Security and the Federal Aviation Administration.                                                                                                                                                                                              ""Dave''s deep experience in virtual test environments will further strengthen TASC''s ability to tailor and apply advanced test capabilities and tools to the most complex enterprise systems,"" says Pamela Drew, vice president of Enterprise Systems Business Unit at TASC.                                                                                                                                                                                              During his tenure at Boeing, Manser led the development teams that created leading applications in cyber warfare and network management. He managed large-scale programs and systems integration projects, including the $400 million S3 truss segment and S4 power-generation module of the International Space Station. He is a NASA-certified spaceflight controller and served in Mission Control Houston and the Russian Spaceflight Control Center in Korolev for the construction of the space station''s pressurized modules and first manned crews.                                                                                                                                                                                             ""With his background in developing leading-edge, network-centric systems and managing large-scale infrastructure and cyber security programs, Dave brings great insight into the needs of TASC''s customers in the military and intelligence communities, as well as in civilian sectors,"" says Drew.                                                                                                                                                                                             A retired naval aviator, Manser served in the U.S. Navy for 22 years in active duty and the reserves. He earned a master''s of science in space systems from the Naval Postgraduate School, and a B.A. in economics from Duke University.                                                                                                                                                                                             About TASC                                                                                                                                                                                             TASC is the premier, non-conflicted provider of advanced systems engineering, integration and decision-support services across the intelligence community, Department of Defense and civilian agencies of the federal government. Formerly a unit of Northrop Grumman Corporation, TASC became an independent company in December 2009. For more than 40 years, TASC has partnered with our customers toward one goal—the success of their missions. Our broad portfolio of services includes system and policy analysis, program, financial and acquisition management, enterprise engineering and integration, advanced concept and technology development, and test and evaluation. With nearly 5,000 employees, TASC generates more than $1.6 billion in annual revenue. For more information and career opportunities, visit our website at www.tasc.com [http://www.tasc.com].                                                                                                                                                                                             CONTACT                                                                                                                                                                                             Christine Nyirjesy Bragale                                                                                                                                                                                             (703) 653-5996 (office)                                                                                                                                                                                             Christine.Bragale@TASC.com"', 'http://bit.ly/cVptUx', 'Appointment', 'TASC appointed David Manser as Director of Technology', 'A retired naval aviator, Manser served in the U.S. Navy for 22 years in active duty and the reserves. He earned a master''s of science in space systems from the Naval Postgraduate School, and a B.A. in economics from Duke University.', 'TASC is the premier, non-conflicted provider of advanced systems engineering, integration and decision-support services across the intelligence community, Department of Defense and civilian agencies of the federal government. ', 'http://www.prnewswire.com/news-releases/tasc-inc-appoints-retired-naval-aviator-to-enterprise-systems-business-unit-97990569.html\r\n', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(149, 'Jerry', 'W.', 'Clever', 'Chief Technology Officer', 'jerry@monsterdiesel.com', '410.666.7837', 'Alcane', 'Jerry-Clever-Appointed-CTO-at-Alcane', 'www.monsterdiesel.com', '25 - 100', '$1 - 10M', 'Energy & Utilities Other', 46, 0, '2205 York Road, Suite 14', '', 'Lutherville', 'MD', 'USA', '21093', '2010-07-26', '2010-07-26', 'Press Release', 'Alkane, Inc. Names New Chief Technology Officer', '"Jul 26, 2010 14:01 ET                                                                                                                                                                                             Alkane, Inc. Names New Chief Technology Officer                                                                                                                                                                                             Clever Brings Technology, Business, and Research Experience to the Position                                                                                                                                                                                             BALTIMORE, MD--(Marketwire - July 26, 2010) - Alkane, Inc. (OTCQB: ALKN) (PINKSHEETS: ALKN) is pleased to announce the company has appointed Jerry W. Clever, Ph.D. to the role of Chief Technology Officer. Dr. Clever is the former President and owner of JEDB Associates, LLC, where he built significant government and defense contacts in the alternative energy industry.                                                                                                                                                                                             Before joining forces with Alkane, Dr. Clever''s JEDB Associates supported alternative, renewable energy technologies to maximize the value of sustainability -- making environmental excellence, energy innovation, and social responsibility drivers for increased reliance and energy independence.                                                                                                                                                                                             Dr. Clever received his Ph.D. from Catholic University of America in 1991 and has worked as an advocate for renewable, sustainable energy throughout his career. He served as Adjunct Professor for the school and in various research capacities in both the academic and professional realm. In addition, Dr. Clever''s private sector career included executive responsibilities for a physician driven provider network and three medical mall facilities in the Washington, D.C. area.                                                                                                                                                                                             ""Dr. Clever brings uncommon expertise, terrific energy, and a unique set of interdisciplinary skills which will form the nexus of technology for our products today and tomorrow,"" said Mathew Zuckerman, Ph.D., CEO & President. ""He has the rare combination of a curious mind, natural leadership, communication, and interpersonal skills.""                                                                                                                                                                                                                                                                                                                                                                                          About Alkane, Inc.                                                                                                                                                                                              Alkane, Inc. is dedicated to the development of a family of alternative fuels and additives, which, collectively, will contribute to a solution to the global energy crisis. Additional benefits of Alkane, Inc.''s product offerings include positive environmental impact through the reduction of harmful emissions and reduced vehicle operation and maintenance costs. Monster Diesel™, flagship product of Alkane, Inc., is a patent pending high energy ""green"" alternative fuel additive which boosts diesel fuel''s quality to premium levels and is designed for use in any diesel powered motor.                                                                                                                                                                                             Forward-Looking Statements:                                                                                                                                                                                             This press release contains certain forward-looking statements. Investors are cautioned that certain statements in this release are ""forward-looking statements"" and involve both known and unknown risks, uncertainties and other factors. Such uncertainties include, among others, certain risks associated with the operation of the company described above. The Company''s actual results could differ materially from expected results.                                                                                                                                                                                             Visit www.MonsterDiesel.com for more product information, news and analysis, and information on how to order Monster Diesel™ and branded products. Also visit Monster Diesel™ on Facebook or follow on Twitter.                                                                                                                                                                                             Monster Diesel™ and the logo are trademarks and are the property of Alkane, Inc."', 'http://bit.ly/cVptUx', 'Appointment', 'Jerry Clever was appointed Chief Technology Officer at Alkane Inc.', 'Before Alkane, Dr. Clever''s JEDB Associates supported alternative, renewable energy technologies to maximize the value of sustainability -- making environmental excellence, energy innovation, and social responsibility drivers for increased reliance and energy independence.', '"Alkane, Inc. is dedicated to the development of a family of alternative fuels and additives, which, collectively, will contribute to a solution to the global energy crisis. Additional benefits of Alkane, Inc.''s product offerings include positive environmental impact through the reduction of harmful emissions and reduced vehicle operation and maintenance costs. Monster Diesel™, flagship product of Alkane, Inc., is a patent pending high energy ""green"" alternative fuel additive which boosts diesel fuel''s quality to premium levels and is designed for use in any diesel powered motor."', 'http://www.marketwire.com/press-release/Alkane-Inc-Names-New-Chief-Technology-Officer-1295466.htm\r\n', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(150, 'Jim', '', 'Tommaney', 'Chief Technology Officer', 'jtommaney@calpont.com', '214.618.9500', 'Calpont', 'Jim-Tommaney-Promoted-To-CTO-at-Calpont', 'www.calpont.com', '25 - 100', '$1 - 10M', 'Software & Internet Other', 138, 143, '3011 Internet Blvd Ste 100', '', 'Frisco', 'TX', 'USA', '75034', '2010-07-23', '2010-07-23', 'Press Release', 'Calpont Appoints Jim Tommaney as Chief Technology Officer', 'Calpont Appoints Jim Tommaney as Chief Technology Officer                                                                                                                                                                                             Tommaney Promoted from Chief Product Architect to CTO to Accelerate Development and Customer Success                                                                                                                                                                                                                                                                                                                                                                                          Frisco, TX (PRWEB) July 23, 2010                                                                                                                                                                                             Calpont Corporation, a provider of scalable, high-performance, column-oriented analytic databases, today announced the promotion of Jim Tommaney from Chief Product Architect to Chief Technology Officer (CTO). In this position, Tommaney will work closely with customers to help guide Calpont’s long-term technology strategy and keep it aligned with industry requirements.                                                                                                                                                                                             “We are very fortunate to have Jim’s “next bench” expertise with 25 years of software development experience. His recognized expertise, forward-thinking, and strategic guidance will help Calpontcontinue to innovate in the areas of scalable solutions, improved data load procedures and integration support for the applications our customers use today and in the future.” said Jeff Vogel, CEO of Calpont. “Jim will continue to provide genuine innovation, and provide leading-edge solutions to keep moving the industry forward.”                                                                                                                                                                                             Tommaney served as Chief Product Architect for the past four years. He has been responsible for the design and architecture for the InfiniDB product, a high-performance, horizontally-scalable and cost-effective database solution purpose-built for analytics, business intelligence and data warehousing. His broad expertise in design, managing and delivering performance for enterprise data architectures continues to be instrumental in the InfiniDB architecture. Tommaney holds a BBA from Texas A&M and a Masters in MIS from the University of Texas at Dallas and has provided data architecture leadership for teams up to 200 developers.                                                                                                                                                                                             About Calpont                                                                                                                                                                                              Calpont Corporation is a provider of scalable, high-performance analytic databases enabling ultra-fast, deep analysis of massive data sets. Its InfiniDB Enterprise Edition is the emerging choice for demanding data warehouse, Business Intelligence, reporting, analytic application and data mart deployments. Known for its quick implementation time, unmatched operational simplicity and unparalleled value, InfiniDB provides rapid access to critical business data for data-intensive businesses including those in the SaaS, retail, telecommunications and government industries. For more information, please visit www.calpont.com, or follow us at twitter.com/calpont.                                                                                                                                                                                             All names referred to are trademarks or registered trademarks of their respective owners.                                                                                                                                                                                             Media Contact:                                                                                                                                                                                              Lisa Prassack                                                                                                                                                                                              EDGE Consulting for Calpont Corporation                                                                                                                                                                                              lprassack(at)calpont(dot)com or press(at)calpont(dot)com                                                                                                                                                                                              +1(303) 570-8141', 'http://bit.ly/cVptUx', 'Promotion', 'Calpont promoted Jim Tommaney to Chief Technology Officer', 'Jim Tommaney served as Chief Product Architect for the past four years. He has been responsible for the design and architecture for the InfiniDB product, a high-performance, horizontally-scalable and cost-effective database solution purpose-built for analytics, business intelligence and data warehousing. His broad expertise in design, managing and delivering performance for enterprise data architectures continues to be instrumental in the InfiniDB architecture. Tommaney holds a BBA from Texas A&M and a Masters in MIS from the University of Texas at Dallas and has provided data architecture leadership for teams up to 200 developers.', 'Calpont Corporation is a provider of scalable, high-performance analytic databases enabling ultra-fast, deep analysis of massive data sets. Its InfiniDB Enterprise Edition is the emerging choice for demanding data warehouse, Business Intelligence, reporting, analytic application and data mart deployments. Known for its quick implementation time, unmatched operational simplicity and unparalleled value, InfiniDB provides rapid access to critical business data for data-intensive businesses including those in the SaaS, retail, telecommunications and government industries. ', 'http://www.prweb.com/releases/2010/07/prweb4297574.htm\r\n', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(151, 'Jorge', '', 'Valdes', 'Chief Technology Officer', 'jorge.valdes@DexOne.com', '919.297.1600', 'DexCom', 'Jorge-Valdes-Promoted-To-CTO-at-DexCom', 'www.dexknows.com', '250 - 1000', '$100 - 250M', 'Telecommunications Other', 144, 150, '9380 Station St', '', 'Lone Tree', 'CO', 'USA', '80124', '2010-07-01', '2010-07-01', 'News', 'DexCom Appoints New COO and CTO', '"DexCom Appoints New COO and CTO                                                                                                                                                                                              1 July 2010                                                                                                                                                                                             Entertainment Close-Up                                                                                                                                                                                             DexCom, Inc. announced that Steven R. Pacelli has been appointed to the newly created position of Chief Operating Officer (COO).                                                                                                                                                                                             In this role, Pacelli will be responsible for the strategic and operational leadership of DexCom''s sales, marketing and other core commercial functions, including finance, customer support, quality, corporate development, managed care, human resources, legal and intellectual property and investor relations. Pacelli will continue to report to Terry Gregg, DexCom''s President and Chief Executive Officer.                                                                                                                                                                                             ""I have every confidence that Steve''s knowledge of our business, proven leadership skills, and keen insight into our development strategies will serve as an excellent foundation for his continued success in his new role,"" said Gregg. ""Steve''s appointment will also provide me with the opportunity to direct more of my energies on developing and refining our corporate strategy, and to enhancing DexCom''s external relationships with customers, shareholders, and key constituents, both domestically and internationally.""                                                                                                                                                                                             DexCom also announced that Jorge Valdes has been appointed to the newly created position of Chief Technical Officer (CTO). In this role, Valdes assumes responsibility for the strategic and operational leadership of DexCom''s research and development function, including clinical and regulatory, as well as information technology and manufacturing operations. Valdes will also continue to report to Gregg.                                                                                                                                                                                             ""As our product portfolio continues to grow and we tap new opportunities and markets around the globe, operational excellence is critical to achieving our goals,"" said Gregg. ""Jorge is a talented healthcare executive with a proven track record of assembling winning teams focused on building successful products and driving operational efficiencies. Steve and Jorge have each demonstrated outstanding leadership skills, both externally and internally, and an ability to deliver results. I look forward to working closely with them in their expanded roles.""                                                                                                                                                                                             Pacelli has served as DexCom''s Chief Administrative Officer since December 2008, where he was charged with overseeing DexCom''s finance, corporate development, managed care, legal, human resources, intellectual property and investor relations functions. From July 2007 to December 2008, Pacelli served as DexCom''s Senior Vice President of Corporate Affairs, and from April 2006 to July 2007, as its Vice President of Legal Affairs. From March 2003 to April 2006, Pacelli served as a corporate attorney with Stradling Yocca Carlson & Rauth where he specialized in public and private finance, mergers and acquisitions, and general corporate matters for life sciences and technology companies. From February 2001 to March 2003, Pacelli served as Vice President of Corporate Development, Secretary, and General Counsel of Axcelerant, Inc., a provider of secure managed business network services. From January 2000 to January 2001, Pacelli served as Vice President, Secretary, and General Counsel of Flashcom, Inc., a provider of consumer broadband DSL services.                                                                                                                                                                                             Valdes has served as DexCom''s Senior Vice President of Operations since July 2007, responsible for overseeing DexCom''s manufacturing, engineering, and information technology departments. Valdes previously served as DexCom''s Vice President of Engineering from November 2005 to July 2007. From July 1999 to March 2005, Valdes served as Vice President of Engineering at Advanced Fibre Communications, or AFC, a provider of broadband access solutions. Valdes also served as General Manager for the fiber to the premise (FTTP) business unit of AFC beginning in May 2004. From May 1985 until July 1999, Valdes held positions at Racal-Datacom, Inc., a manufacturer of data communication products, in engineering management, product development and product management.                                                                                                                                                                                             DexCom, Inc. is developing and marketing continuous glucose monitoring systems for ambulatory use by patients and by healthcare providers in the hospital."', 'http://bit.ly/cVptUx', 'Promotion', 'DexCom promoted Jorge Valdes  to Chief Technology Officer', 'Valdes has served as DexCom''s Senior Vice President of Operations since July 2007, responsible for overseeing DexCom''s manufacturing, engineering, and information technology departments. Valdes previously served as DexCom''s Vice President of Engineering from November 2005 to July 2007. From July 1999 to March 2005, Valdes served as Vice President of Engineering at Advanced Fibre Communications, or AFC, a provider of broadband access solutions.', 'DexCom, Inc. is developing and marketing continuous glucose monitoring systems for ambulatory use by patients and by healthcare providers in the hospital.', 'http://www.rttnews.com/ArticleView.aspx%3FId%3D1340463\r\n', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(187, 'Gordon', '', 'Wishon', 'Chief Information Officer', 'gwishon@asu.edu', '480.965.1225', 'Arizona State University', 'Gordon-Wishon-Appointed-CIO-at-Arizona-State-University', 'www.asu.edu', 'N/A', '10K - 50K', 'Colleges and Universities', 38, 39, '300 E University Dr', '', 'Tempe', 'AZ', 'USA', '85281', '2010-08-03', '2010-08-16', 'News', 'IT leader named chief information officer for ASU', 'IT leader named chief information officer for ASU<br/>Gordon Wishon, a leader in information technology with a distinguished career in higher education and the military, will join Arizona State University as chief information officer on Aug. 16.<br/>Wishon will be responsible for developing a long range technology plan for the university, helping meet ASU''s goals of excellence, access and impact. He will guide the selection of strategic technologies to meet the unique administrative, research and academic computing needs of a rapidly growing, multi-campus university.<br/>Wishon comes to ASU from Notre Dame University, where he was CIO for nine years and was named one of Computerworld Magazine’s Premier 100 IT Leaders. He also was awarded CIO Magazine’s CIO100 award for innovation in information technology in 2005 and 2008.<br/>He led a Notre Dame/Purdue grant program to establish the Northwest Indiana Computational Grid, and he chaired the board of directors of the St. Joseph Valley Metronet, a northern Indiana regional economic development initiative.<br/>“Gordon Wishon will help ASU lead the nation in innovative ways to enhance university education, improving access by lowering cost and improving excellence by expanding learning options and intensity,” said ASU President Michael Crow.<br/>Wishon emerged as the leading candidate after a national search produced a very deep pool of talented candidates, according to Kevin Salcido, associate vice president of human resources.<br/>“He is highly qualified and is very interested in working with faculty, students and staff as we increasingly use technology in all of our operations,” said Elizabeth D. Capaldi, executive vice president and provost. “We are very happy to have attracted him to ASU.”<br/>From 1994 to 2001 Wishon served as CIO for the Georgia Institute of Technology, where he was chair of the Southeastern Universities Research Association IT committee and served on its executive committee. He also co-founded and chaired the EDUCAUSE/Internet 2 Security Task Force and served as a faculty member on the EDUCAUSE Leadership Institute.<br/>Prior to that Wishon served 20 years with the U.S. Air Force in a variety of roles, including flying in F-111 fighter-bombers, aiding in the development of advanced avionics systems and leading the engineering of the first large scale production TCP/IP network in the Air Force. He completed his military career as CIO at the Air Force Institute of Technology.<br/>He holds a bachelor’s degree in computer science from West Virginia University and a master’s in computer science from Wright State University.<br/>“We are very pleased Gordon Wishon will be joining the ASU team,” said Morgan Olsen, executive vice president, treasurer and CFO. “He is an accomplished chief information officer, whose experience will allow him to lead our efforts as we apply information technology in a wide range of opportunities across the university.”<br/>“I am excited by the opportunity to make an impact at a university that is on such an upward trajectory,” Wishon said. “President Crow has a tremendously powerful vision for what ASU can mean to the people of this state and the nation, and I’m honored to be a part of that effort.<br/>“I’m also pleased to have the opportunity to lead a group of accomplished professionals in the University Technology Office, and I look forward to working with them in service to the faculty, students and administrators of the university.”<br/>Sarah Auffret, sauffret@asu.edu<br/>480-965-6991 ASU Media Relations', '', 'Appointment', 'Arizona State University appointed Gordon Wishon as Chief Information Officer', 'Gordon Wishon was previously with the Notre Dame University, where he was CIO for nine years.', 'Arizona State University (also referred to as ASU, or Arizona State) is the largest public research university in the United States under a single administration, with a 2009 student enrollment of 68,064.', 'http://asunews.asu.edu/20100804_wishon\r\n', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(188, 'Rob', '', 'Smith', 'Chief Information Officer', 'rob.smith@integratelecom.com', '503.453.8000', 'Integra Telecom', 'Rob-Smith-Promoted-To-CIO-at-Integra-Telecom', 'www.integratelecom.com', '$1-10 Million', '1K-10K', 'Telecommunications Other', 144, 150, '1201 NE Lloyd Blvd', '', 'Portland', 'OR', 'USA', '97232', '2010-08-03', '2010-08-03', 'Press Release', 'Integra Telecom Promotes Rob Smith to Chief Information Officer', 'August 03, 2010 02:31 PM Eastern Daylight Time <br/>Integra Telecom Promotes Rob Smith to Chief Information Officer <br/>PORTLAND, Ore.--(BUSINESS WIRE)--Integra Telecom Inc., an integrated communications provider for business, has promoted Rob Smith to chief information officer. In his new role, Smith is responsible for all information technology systems and reports directly to Jim Huesgen, president of Integra Telecom. <br/>“Rob understands the systems and technologies that Integra relies on to deliver reliable service to our business customers, and will ensure that our employees have the systems they need to deliver the unique, personalized customer service experience that our customers have come to expect.”<br/>Most recently, Smith served as senior vice president of Integra Telecom of Arizona where he directed the company’s operations, customer services and new business development throughout the company’s Arizona markets. Previously, Smith was Integra’s vice president of customer care for Oregon. <br/>“Rob has been a key contributor to Integra’s leadership team for years and will serve the company well as chief information officer,” said Huesgen. “Rob understands the systems and technologies that Integra relies on to deliver reliable service to our business customers, and will ensure that our employees have the systems they need to deliver the unique, personalized customer service experience that our customers have come to expect.” <br/>Smith has more than 25 years of telecommunications and management experience, including 10 years of leadership at Integra Telecom. His tenure with the company also includes four years as vice president of information technology and chief information officer. Before joining Integra, Smith worked as director of information services and director of plant systems for CenturyTel in Vancouver, Wash. <br/>Smith graduated from the University of Idaho with a Bachelor of Science. <br/>About Integra Telecom <br/>Integra Telecom Inc. provides integrated communications services across 33 metropolitan areas in 11 Western states, including: Arizona, California, Colorado, Idaho, Minnesota, Montana, Nevada, North Dakota, Oregon, Utah and Washington. It owns and operates a best-in-class fiber-optic network comprised of more than 2,800 route miles in 11 metropolitan access networks including approximately 1,386 on-net buildings, a world class Internet and data network, and approximately 4,900-mile high-speed long-haul fiber network. The company has earned some of the highest customer loyalty and customer satisfaction ratings in the telecommunications industry. Primary equity investors in the company include Goldman, Sachs & Co., Tennenbaum Capital Partners, funds managed by Farallon Capital Partners and Warburg Pincus. Integra Telecom and Electric Lightwave are registered trademarks of Integra Telecom, Inc. For more information, visit: www.integratelecom.com. <br/>Contacts <br/>Integra Telecom Inc.<br/>John Nee, 503-453-8084 john.nee@integratelecom.com<br/>or<br/>Melissa Moore, 503-546-7894 <br/>melissa@lanepr.com ', '', 'Promotion', 'Integra Telecom appointed Rob Smith as Chief Information Officer', 'Rob Smith has more than 25 years of telecommunications and management experience, including 10 years of leadership at Integra Telecom.', 'Integra Telecom Inc. provides integrated communications services across 33 metropolitan areas in 11 Western states, including: Arizona, California, Colorado, Idaho, Minnesota, Montana, Nevada, North Dakota, Oregon, Utah and Washington.', 'http://www.businesswire.com/news/home/20100803006964/en/Integra-Telecom-Promotes-Rob-Smith-Chief-Information', '0000-00-00', '2010-08-10', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(192, 'John', '', 'Neary', 'Chief Information Officer', 'jneary@creditacceptance.com', '248.353.2700 x4423', 'Credit Acceptance Corp.', 'John-Neary-Promoted-To-CIO-at-Credit-Acceptance-Corp.', 'www.creditacceptance.com', '$1-10 Million', '250-1000', 'Credit Card and Related Services', 54, 56, 'Silver Triangle 25505 W 12 Mile Rd Ste 3000', '', 'Southfield', 'MI', 'USA', '48111', '2010-08-05', '2010-08-05', 'SEC Filing', 'Item 5.02 Departure of Directors or Certain Officers, Election of Directors, Appointment of Certain Officers, Compensatory Arrangements of Certain Officers. ', 'UNITED STATES</br>SECURITIES AND EXCHANGE COMMISSION </br>WASHINGTON, D.C. 20549 </br>FORM 8-K </br>CURRENT REPORT </br>Pursuant to Section 13 or 15(d) of the Securities Exchange Act of 1934 </br>        </br>Date of Report (Date of Earliest Event Reported):     August 5, 2010 </br></br>CREDIT ACCEPTANCE CORPORATION </br>__________________________________________</br>(Exact name of registrant as specified in its charter) </br>        </br>Michigan  000-20202  38-1999511 </br>_____________________</br>(State or other jurisdiction  _____________</br>(Commission  ______________</br>(I.R.S. Employer </br>of incorporation)  File Number)  Identification No.) </br>         </br>25505 West Twelve Mile Road, Southfield, Michigan     48034-8339 </br>_________________________________</br>(Address of principal executive offices)     ___________</br>(Zip Code) </br>        </br>Registrant’s telephone number, including area code:     248-353-2700 </br>Not Applicable </br>______________________________________________</br>Former name or former address, if changed since last report </br>Item 5.02 Departure of Directors or Certain Officers, Election of Directors, Appointment of Certain Officers, Compensatory Arrangements of Certain Officers. </br>Effective August 5, 2010, Michael Miotto was named Chief Technology Officer. Mr. Miotto was previously Chief Information Officer. John Neary, Senior Vice President – Operations Improvement, was named Chief Information Officer. ', '', 'Promotion', 'Credit Acceptance Corp. promoted John Neary to Chief Information Officer', 'John Neary was previously Senior Vice President – Operations Improvement with Credit Acceptance Corp.', 'Provides funding, receivables management, collection, sales training and related services to automobile dealers. (Nasdaq:CACC).', 'http://www.sec.gov/Archives/edgar/data/885550/000129993310003041/htm_38690.htm', '0000-00-00', '2010-08-21', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(193, '', '', '', 'Chief Information Officer', '', '410.837.4200', 'University of Baltimore', '--Appointed-CIO-at-University-of-Baltimore', 'www.ubalt.edu', 'Any', '250-1000', 'Colleges and Universities', 38, 39, '1420 N Charles St', '', 'Baltimore', 'MD', 'USA', '21201', '2010-06-15', '2010-06-15', 'Job Opening', 'University of Baltimore Job Opportunities', 'Chief Information Officer Office of Technology Services Position Type: Regular exempt position with full benefits package Opens: 06/15/10     Closes: Open Until Filled Salary: Commensurate with qualifications At the University of Baltimore, the Chief Information Officer’s role is to provide vision and leadership for developing and implementing information technology initiatives. The Chief Information Officer directs the planning and implementation of enterprise IT systems in support of business operations in order to improve cost effectiveness, service quality, and business development. This individual is responsible for all aspects of the organization’s information technology and systems. Duties Strategy & Planning •         Participate in strategic and operational governance processes of the business organization as a member of the senior management team. •         Lead IT strategic and operational planning to achieve business goals by fostering innovation, prioritizing IT initiatives, and coordinating the evaluation, deployment, and management of current and future IT systems across the organization. •         Develop and maintain an appropriate IT organizational structure that supports the needs of the business. •         Establish IT departmental goals, objectives, and operating procedures. •         Identify opportunities for the appropriate and cost-effective investment of financial resources in IT systems and resources, including staffing, sourcing, purchasing, and in-house development. •         Assess and communicate risks associated with IT investments. •         Develop, track, and control the information technology annual operating and capital budgets. •         Develop business case justifications and cost/benefit analyses for IT spending and initiatives. •         Direct development and execution of an enterprise-wide disaster recovery and business continuity plan. •         Assess and make recommendations on the improvement or re-engineering of the IT organization.  Acquisition & Deployment •         Coordinate and facilitate consultation with stakeholders to define business and systems requirements for new technology implementations. •         Approve, prioritize, and control projects and the project portfolio as they relate to the selection, acquisition, development, and installation of major information systems. •         Review hardware and software acquisition and maintenance contracts and pursue master agreements to capitalize on economies of scale. •         Define and communicate corporate plans, policies, and standards for the organization for acquiring, implementing, and operating IT systems.   Operational Management •         Ensure continuous delivery of IT services through oversight of service level agreements with end users and monitoring of IT systems performance. •         Ensure IT system operation adheres to applicable laws and regulations. •         Establish lines of control for current and proposed information systems. •         Keep current with trends and issues in the IT industry, including current technologies and prices. Advise, counsel, and educate executives and management on their competitive or financial impact. •         Promote and oversee strategic relationships between internal IT resources and external entities, including government, vendors, and partner organizations. •         Supervise recruitment, development, retention, and organization of all IT staff in accordance with corporate budgetary objectives and personnel policies. Qualifications Formal Education & Certification •         Bachelor\\''s in the field of computer science or business administration or the equivalent in work experience preferred. Master’s degree in one these fields is highly desirable and a major plus.  Knowledge & Experience •         Fifteen (15) years experience working in the IT discipline industry in a combination of Industry and Higher Education would be preferred •         Five (5) to Seven (7) years experience in Leadership managing and/or directing an IT multiple, large scale cross functional teams or IT Projects. •         Experience in strategic planning and execution. •         Considerable knowledge of business theory, business processes, management, budgeting, and business office operations. •         Substantial exposure to data processing, hardware platforms, enterprise software applications, and outsourced systems, including Oracle or other such Higher Education applications modules. •         Good understanding of computer systems characteristics, features, and integration capabilities. •         Experience with systems design and development from business requirements analysis through to day-to-day management. •         Proven experience in IT planning, organization, and development. •         Excellent understanding of project management principles. •         Superior understanding of the organization’s goals and objectives. •         Demonstrated ability to apply IT in solving business problems. •         In-depth knowledge of applicable laws and regulations as they relate to IT. •         Strong understanding of human resource management principles, practices, and procedures. •         Proven leadership ability. •         Ability to set and manage priorities judiciously.  Personal Attributes •         Excellent written and oral communication skills. •         Excellent interpersonal skills. •         Strong negotiating skills. •         Ability to present ideas in business-friendly and user-friendly language. •         Exceptionally self-motivated and directed. •         Keen attention to detail. •         Superior analytical, evaluative, and problem-solving abilities. •         Exceptional service orientation. •         Ability to motivate in a team-oriented, collaborative environment. To Apply Apply with Resume and cover letter to Michael J. Reid, Principal Michael James Reid & Company michael@mjrco.com www.mjrco.com Office: 415-255-6262  ', '', 'Appointment', 'University of Baltimore is looking to hire a Chief Information Officer', 'N/A', 'The University of Baltimore was founded in 1925. It became a state institution in 1975, and today is part of the University System of Maryland.', 'http://www.ubalt.edu/template.cfm?page=318&posting=509', '2010-08-14', '2010-08-14', 0, 'msobolev', 0);
INSERT INTO `cto_contact` VALUES(185, 'Jeff', '', 'Osegard', 'Chief Information Officer', 'jeffosegard@lakewoodhealthsystem.com', '218.894.1515', 'Lakewood Health System', 'Jeff-Osegard-Appointed-CIO-at-Lakewood-Health-System', 'www.lakewoodhealthsystem.com', '$1 - 10M', '25 - 100', 'Hospitals', 198, 199, '401 Prairie Ave NE', '', 'Staples', 'MN', 'USA', '56479', '2010-08-09', '2010-08-09', 'News', 'PRAIRIE PEOPLE', 'Published August 09 2010 <br/>PRAIRIE PEOPLE<br/>OSEGARD NAMED CIO AT LAKEWOOD HEALTH<br/>Staples, MN-based Lakewood Health System has named Jeff Osegard chief information officer. Osegard has 25 years of experience in data management and information technology, 10 of them in leadership roles. He previously worked at Regina Medical Center in Hastings, MN. Osegard will oversee Lakewood Health’s 19-person information technology division and will be responsible for strategic planning, directing the selection, acquisition and implementation of electronic health records systems, as well as making sure IS infrastructure meets the health care system’s needs.', '', 'Appointment', 'Lakewood Health System appointed Jeff Osegard as Chief Information Officer', 'Jeff Osegard previously worked at Regina Medical Center in Hastings, MN.', 'Serving the Staples and surrounding communities since 1936, Lakewood Health System has grown from a small community hospital to one recognized as a leading rural health care system.', 'http://www.prairiebizmag.com/event/article/id/11140/\r\n', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(186, 'Michael', '', 'Duffy', 'Chief Information Officer', 'N/A', '202.622.2000', 'Department of Treasury', 'Michael-Duffy-Resigned-from-CIO-at-Department-of-Treasury', 'www.ustreas.gov', 'N/A', '> 100K', 'National Government', 64, 67, '1500 Pennsylvania Ave NW', '', 'Washington', 'DC', 'USA', '20220', '2010-08-04', '2010-08-04', 'News', 'Treasury CIO Michael Duffy will return to Justice', 'Treasury CIO Michael Duffy will return to Justice<br/>Michael Duffy, the Treasury Department’s chief information officer, will return to the Justice Department, where he spent a decade and a half. <br/>A Justice Department spokesperson confirmed today that Duffy would be rejoining Justice in the Office of the Chief Information Officer. Duffy’s new position and start date were not provided. <br/>As Treasury CIO, Duffy serves as that department’s principal adviser on information technology and he’s responsible for acquiring and managing information resources and developing policies to maximize the value of technology investments, according to his biography on Treasury’s Web site.<br/>Before being appointed CIO and deputy assistant secretary for information systems for Treasury in September 2007, Duffy spent 15 years with Justice, including time as deputy chief information officer, according to his biography. He directed the development of Justice’s law enforcement and counterterrorism information-sharing strategy and deploying a multi-agency tactical wireless communications system. <br/>His previous positions at Justice included director of telecommunications, director of information management and security, and program manager for the Justice Consolidated Office Network.<br/>Duffy started working for the federal government in 1987 as a Presidential Management Intern at the Health and Human Services Department, according to his biography.<br/>o Print<br/> <br/>Big Lake Golf Course<br/>FREE APPETIZER with the purchase of two entrees at Big Lake Golf Club.', '', 'Resignation', 'Department of Treasury appointed Michael Duffy as Chief Information Officer', 'Before being appointed CIO and deputy assistant secretary for information systems for Treasury in September 2007, Duffy spent 15 years with Justice, including time as deputy chief information officer.', 'The Department of the Treasury is an executive department and the treasury of the United States federal government. It was established by an Act of Congress in 1789 to manage government revenue.', 'http://fcw.com/blogs/circuit/2010/08/duffy-treasury-cio-justice.aspx\r\n', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(183, 'Bob', '', 'Lee', 'Chief Technology Officer', 'bob@cyphermedia.com', '510.270.5318', 'Cypher Media', 'Bob-Lee-Appointed-CTO-at-Cypher-Media', 'www.cyphermedia.com', '$0 - 1M', '0 - 25', 'Business Services Other', 7, 17, '42840 Christy St Ste 101', '', 'Fremont', 'CA', 'USA', '94538', '2010-08-09', '2010-08-09', 'Press Release', 'Cypher Media, a Leader in Online Marketing, Hires Bob Lee as Chief Technology Officer', '"Aug 09, 2010 03:01 ET<br/>Cypher Media, a Leader in Online Marketing, Hires Bob Lee as Chief Technology Officer<br/>Company''s Doubling of Gross Revenue Year Over Year Since Founding and Plans for Additional Offerings Necessitate Bringing in IT Expert<br/>FREMONT, CA--(Marketwire - August 9, 2010) - Cypher Media, Inc. has hired Bob Lee, a pioneer in information technology and product marketing, as its new chief technology officer. <br/>Lee comes to Cypher Media from Wigix, a community-driven Internet marketplace he co-founded in 2007.<br/>""Bob is an IT pioneer,"" said Ty Lim, Cypher Media''s president and CEO. ""His wealth of knowledge and experience will be a key component to our product strategy.""<br/>Founded by Lim in 2007, Cypher Media provides publishers and advertisers lead generation and customer acquisition services on a pay-for-performance model. In just three years, the company has created more than 100 web properties, generated more than 10 million leads, and have doubled gross revenues year over year since its founding.<br/>""Cypher Media is a true example of innovation, one that brings real results to its customers,"" Lee said. ""When a company can take its expertise in user acquisition into community based products, that''s the kind of company that can change the online advertising marketplace. I''m looking forward to contributing to Cypher Media''s product strategy and vision.""<br/>Before co-founding Wigix, Mr. Lee served as vice president of Product Management for Cyanea Systems, an enterprise software company that was purchased by IBM in 2004. Lee also served as Vice President of Engineering for Epoch Partners, an investment bank that used sophisticated technology to connect to one of the largest groups of individual investors in the United States. Epoch Partners was acquired in 2001 by Goldman Sachs.<br/>To learn more about how Cypher Media can grow your business, visit www.cyphermedia.com, call (510) 270-2940 or e-mail press@cyphermedia.com."', '', 'Appointment', 'Cypher Media appointed Bob Lee as Chief Technology Officer', 'Bob Lee previously was with Wigix, a community-driven Internet marketplace he co-founded in 2007.', 'Cypher Media provides publishers and advertisers lead generation and customer acquisition services on a pay-for-performance model.', 'http://www.marketwire.com/press-release/Cypher-Media-a-Leader-in-Online-Marketing-Hires-Bob-Lee-as-Chief-Technology-Officer-1301558.htm\r\n', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(184, 'Charles', '', 'Campbell', 'Chief Information Officer', 'N/A', '877.874.2273', 'Military Health System', 'Charles-Campbell-Resigned-from-CIO-at-Military-Health-System', 'www.health.mil', 'N/A', '1K-10K', 'National Government', 64, 67, 'Skyline 5, Suite 810, 5111 Leesburg Pike', '', 'Falls Church', 'VA', 'USA', '22041', '2010-08-05', '2010-08-05', 'News', 'Campbell out as MHS CIO, Gates to close Defense CIO''s office', 'Campbell out as MHS CIO, Gates to close Defense CIO''s office<br/>08/09/2010<br/>The Military Health System on Aug. 5 abruptly transferred its chief information officer to a temporary assignment at the Defense Department''s office of the chief information officer, an organization the department will soon shutter, Nextgov has learned.<br/>Multiple government and industry sources confirmed that Charles Campbell was detailed to the CIO''s office, also known as the Office of the Assistant Secretary of Defense for Networks and Information Integration, this month, but Pentagon and MHS spokesmen did not reply to queries for official confirmation as of press deadline.<br/>Sources told Nextgov that Mary Ann Rockey, MHS deputy CIO for acquisition, will take over Campbell''s duties while he is on a 120-day assignment at ASD/NII.<br/>Defense Secretary Robert Gates said at a press briefing on Monday that he planned to eliminate ASD/NII in an effort to cut $100 billion from the Pentagon budget during the next five years.<br/>In the wake of Gates'' plan to eliminate the technology office, Campbell''s transfer to ASD/NII looks like he is being pushed out of a top management position, said sources familiar with the transfer and who asked to remain anonymous.<br/>At about the same time Gates was making his announcement, Sen. Roger Wicker, R-Miss., put a hold on the nomination of Dr. Jonathan Woodson to be assistant secretary of Defense for health affairs. Woodson said at his confirmation hearing on Aug. 3 that he considered development of a new electronic health record for Defense one of his key priorities. Woodson is a vascular surgeon who practices at the Boston Medical Center in Massachusetts and is an associate dean at Boston University.<br/>Tara DiJulio, a spokeswoman for Wicker, said the senator put the nomination on hold because he was concerned about an amendment to the Senate version of the fiscal 2011 Defense authorization bill that would allow military servicewomen to obtain abortion care at military hospitals even if they use their own funds. Wicker spent most of his time at Woodson''s confirmation hearing to voice his opposition to the amendment, which Sen. Roland Burris, D-Ill., sponsored.<br/>DiJulio said Wicker did not believe Woodson adequately addressed concerns about the impact the amendment would have on military hospitals, and he will keep the nomination on hold until Woodson provides detailed answers to questions the senator asked at the hearing.<br/>Campbell''s transfer puts development of a new Defense electronic health record system on hold and leaves a leadership vacuum for the Virtual Lifetime Electronic Record, a medical record for all service members and veterans that Defense is creating in conjunction with the Veterans Affairs Department, sources told Nextgov. But the move will make it easier for Woodson to pick his own CIO when and if confirmed, sources said.', '', 'Resignation', 'Military Health System appointed Charles Campbell as Chief Information Officer', 'Charles (Chuck) Campbell, Senior Executive Service, was appointed Chief Information Officer (CIO) of the Military Health System in September 2007. Mr. Campbell is the principal advisor to the Assistant Secretary of Defense for Health Affairs and to Department of Defense (DoD) medical leaders on all matters related to information management (IM) and information technology (IT).', 'The Military Health System (MHS) is a global medical network within the Department of Defense that provides cutting-edge health care to all U.S. military personnel worldwide.', 'http://www.nextgov.com/nextgov/ng_20100809_1306.php?oref=topnews\r\n', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(182, 'Michael', '', 'Paravicini', 'Chief Information Officer', 'N/A', '847.605.6000', 'Zurich', 'Michael-Paravicini-Retired-as-CIO-from-Zurich', 'www.zurich.com', '$1-10 Million', '50K-100K', 'Insurance and Risk Management', 54, 57, '1400 American Ln', '', 'Schaumburg', 'IL', 'USA', '60196', '2010-08-09', '2010-08-09', 'Company Announcement', 'Markus Nordlin appointed Chief Information Technology Officer', 'Markus Nordlin appointed Chief Information Technology Officer<br/>Zurich, August 9, 2010 – Zurich Financial Services Group (Zurich) announces the appointment of Markus Nordlin (46, Finnish and U.S. citizen) to the position of Chief Information Technology Officer (CITO) and member of the Group Management Board, effective September 1, 2010. He succeeds Michael Paravicini, who will retire. In his new role, Mr. Nordlin will continue the transformational journey that Zurich and Group IT have undertaken and leverage these capabilities to support Zurich to achieve its ambitious business goals. He will report into Kristof Terryn, Group Head of Operations, and will be located in Zurich, Switzerland.<br/>Mr. Nordlin joined Zurich in 1999 from Accenture (formerly Andersen Consulting). Since 2004 he served as the Group IT Key Account Executive for the Farmers Insurance Group (Farmers), being responsible for developing the IT Roadmaps supporting Farmers’ business strategy across all business units and functions. Most recently, he has been responsible for managing Zurich’s service agreement with CSC for the provision of data center and IT infrastructure services in Europe and North America, covering data center centralization and server virtualization.<br/>Mr. Nordlin holds a Bachelor of Science in Civil Engineering from Brigham Young University and a Master of Business Administration from the University of California, Los Angeles.<br/>For high resolution pictures supporting this news release, please visit www.zurich.com/multimedia. In case you have any questions, please email journalisthelp@thenewsmarket.com.<br/>Zurich Financial Services Group (Zurich) is an insurance-based financial services provider with a global network of subsidiaries and offices in North America and Europe as well as in Asia-Pacific, Latin America and other markets. Founded in 1872, the Group is headquartered in Zurich, Switzerland. It employs approximately 60,000 people serving customers in more than 170 countries.<br/>For additional information please contact:<br/>Group Media Relations<br/>Phone: +41 (0)44 625 21 00 Fax: +41 (0)44 625 26 41<br/>Zurich Financial Services Ltd<br/>Mythenquai 2, P.O. Box, 8022 Zurich, Switzerland<br/>SIX Swiss Exchange/SMI: ZURN<br/>Valor: 001107539', '', 'Retirement', 'Michael Paravicini retired as Zurich\\''s Chief Information Officer', 'Mr. Paravicini started his career as Sales Engineer with Hewlett-Packard in Zurich in 1985. From 1986 to 1987 he worked in the staff department of Credit Suisse Zurich, International Commercial Banking, providing support for foreign commercial banking activities.', 'Zurich Financial Services Group (Zurich) is an insurance-based financial services provider with a global network of subsidiaries and offices in North America and Europe as well as in Asia-Pacific, Latin America and other markets.', 'http://www.zurich.com/main/media/newsreleases/2010/english/2010_0908_01_article.htm', '0000-00-00', '2010-08-10', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(171, 'Dan', '', 'Raju', 'Chief Information Officer', 'dan@tradeking.com', '561.988.017', 'TradeKing', 'Dan-Raju-Appointed-CIO-at-TradeKing', 'www.tradeking.com', '$10-50 Million', '25-100', 'Insurance and Risk Management', 54, 57, '5455 N Federal Hwy, Ste E', '', 'Boca Raton', 'FL', 'USA', '33487', '2010-07-08', '2010-07-08', 'Press Release', 'Online Broker, TradeKing Appoints Raju Chief Information Officer', 'Online Broker, TradeKing Appoints Raju Chief Information Officer Former Global IT Executive for AP and Borders Brings More Than 15 Years of Strategy, Infrastructure and Technical Operations Leadership to Fast-Growing Online Brokerage Firm July 08, 2010 09:03 AM Eastern Daylight Time  BOCA RATON, Fla.--(EON: Enhanced Online News)--Now in its fifth year of sustained high growth, online broker TradeKing (www.tradeking.com) today announced it has selected Dan Raju to join its senior management team as TradeKing’s first Chief Information Officer (CIO). Raju comes to TradeKing having served in senior global IT roles at both the Associated Press and Borders Group Inc. where he oversaw the infrastructure and operations groups for these vast global organizations. He will be based in the firm’s Charlotte, NC, offices and will be responsible for heading up all of the firm’s technology-based initiatives, reporting directly to TradeKing President and COO Rich Hagen.  “It became very clear to us in speaking with Dan and evaluating his experience that he is deeply proficient at driving efficiency and stability through periods of corporate hyper-growth and change,” said Hagen. “He has a great track record of identifying new opportunities to maximize operational performance and using technology to drive greater organizational value. We believe Dan will be a great asset to our firm and, consequently, to our clients.” Raju was most recently Senior Director and Associate Vice President of Global Technology Infrastructure & Operations at the Associated Press where he was charged with overseeing all aspects of technology operations, strategy, engineering and support for the world\\''s largest news company with operations in 300 plus global locations supporting about 10,000 newspapers and broadcasters and members. Before that, Raju held the position of senior director of IT Infrastructure and & Operations for Borders Group Inc. where he spent three years managing the complete infrastructure and operational support services for the Fortune 500 company with annual sales of over $4 Billion derived via its online and more than 1,400 retail stores. He has also held senior IT positions with other major national brand companies including Charming Shoppes (parent to fashion retailers Lane Bryant, Fashion Bug and others), Safety-Kleen and NCR Corporation. Raju received his Bachelor of Science degree in Chemical Engineering from JN Technology University in India and a Masters of Science in Computer Science from the University of Mississippi. ', '', 'Appointment', 'TradeKing, appointed Dan Raju, as Chief Information Officer', 'Raju, was most recently Senior Director and Associate Vice President of Global Technology Infrastructure & Operations at the Associated Press where he was charged with overseeing all aspects of technology operations, strategy, engineering and support for the world\\''s largest news company with operations in 300 plus global locations supporting about 10,000 newspapers and broadcasters and members.', 'TradeKing, (http://www.tradeking.com) is a nationally licensed online stock and option trading broker offering simple, low trading fees ($4.95 per trade plus $.65 per option contract) with no hidden costs or account minimums.1 A pioneer in integrating new financial social media as part of its innovative online equities, options trading and fixed-income trading platform, TradeKing has received multiple five-star ratings from top industry sources and was rated best in customer service by SmartMoney2 Magazine, ahead of OptionsXpress, Scottrade, Fidelity and TD Ameritrade. (June 2010 SmartMoney Broker Survey).', 'http://eon.businesswire.com/news/eon/20100708005368/en', '2010-08-08', '0000-00-00', 0, 'msobolev', 0);
INSERT INTO `cto_contact` VALUES(189, 'Ben', '', 'Ellison', 'Chief Information Officer', 'ben.ellison@hq.doe.gov', '800.342.5363', 'U.S. Department of Energy', 'Ben-Ellison-Promoted-To-CIO-at-U.S.-Department-of-Energy', 'www.energy.gov', '$1-10 Million', '25-100', 'National Government', 64, 67, '1000 Independence Ave SW', '', 'Washington', 'DE', 'USA', '20585', '2010-08-01', '2010-08-01', 'LinkedIn Update', 'LinkedIn Update', 'Ben Ellison  Chief Information Officer at U.S. Department of Energy  Location Richland/Kennewick/Pasco, Washington Area  Industry Information Technology and Services  Current  &#65533; Chief Information Officer at U.S. Department of Energy  Past  &#65533; RL Deputy CIO at U.S. Department of Energy  &#65533; Cyber Technical Expert at DOE Counterintelligence  &#65533; Development Lead / Project Manager at Lockheed Martin IT  ', '', 'Promotion', 'U.S. Department of Energy  promoted Ben Ellison to Chief Information Officer', 'Ben Ellison was previously RL Deputy CIO at  U.S. Department of Energy', 'The Department of Energy\\''s overarching mission is to advance the national, economic, and energy security of the United States; to promote scientific and technological innovation in support of that mission; and to ensure the environmental cleanup of the national nuclear weapons complex.', 'http://www.linkedin.com/in/benjaminellison', '2010-08-13', '2010-08-24', 0, 'msobolev', 0);
INSERT INTO `cto_contact` VALUES(180, 'Bob', '', 'Lee', 'Chief Technology Officer', 'bob@cyphermedia.com', '510.270.5318', 'Cypher Media', 'Bob-Lee-Appointed-CTO-at-Cypher-Media', 'www.cyphermedia.com', '$0 - 1M', '0 - 25', 'Business Services Other', 7, 17, '42840 Christy St Ste 101', '', 'Fremont', 'CA', 'USA', '94538', '2010-08-09', '2010-08-09', 'Press Release', 'Cypher Media, a Leader in Online Marketing, Hires Bob Lee as Chief Technology Officer', '"Aug 09, 2010 03:01 ET<br/>Cypher Media, a Leader in Online Marketing, Hires Bob Lee as Chief Technology Officer<br/>Company''s Doubling of Gross Revenue Year Over Year Since Founding and Plans for Additional Offerings Necessitate Bringing in IT Expert<br/>FREMONT, CA--(Marketwire - August 9, 2010) - Cypher Media, Inc. has hired Bob Lee, a pioneer in information technology and product marketing, as its new chief technology officer. <br/>Lee comes to Cypher Media from Wigix, a community-driven Internet marketplace he co-founded in 2007.<br/>""Bob is an IT pioneer,"" said Ty Lim, Cypher Media''s president and CEO. ""His wealth of knowledge and experience will be a key component to our product strategy.""<br/>Founded by Lim in 2007, Cypher Media provides publishers and advertisers lead generation and customer acquisition services on a pay-for-performance model. In just three years, the company has created more than 100 web properties, generated more than 10 million leads, and have doubled gross revenues year over year since its founding.<br/>""Cypher Media is a true example of innovation, one that brings real results to its customers,"" Lee said. ""When a company can take its expertise in user acquisition into community based products, that''s the kind of company that can change the online advertising marketplace. I''m looking forward to contributing to Cypher Media''s product strategy and vision.""<br/>Before co-founding Wigix, Mr. Lee served as vice president of Product Management for Cyanea Systems, an enterprise software company that was purchased by IBM in 2004. Lee also served as Vice President of Engineering for Epoch Partners, an investment bank that used sophisticated technology to connect to one of the largest groups of individual investors in the United States. Epoch Partners was acquired in 2001 by Goldman Sachs.<br/>To learn more about how Cypher Media can grow your business, visit www.cyphermedia.com, call (510) 270-2940 or e-mail press@cyphermedia.com."', '', 'Appointment', 'Cypher Media appointed Bob Lee as Chief Technology Officer', 'Bob Lee previously was with Wigix, a community-driven Internet marketplace he co-founded in 2007.', 'Cypher Media provides publishers and advertisers lead generation and customer acquisition services on a pay-for-performance model.', 'http://www.marketwire.com/press-release/Cypher-Media-a-Leader-in-Online-Marketing-Hires-Bob-Lee-as-Chief-Technology-Officer-1301558.htm\r\n', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(181, 'Charles', '', 'Campbell', 'Chief Information Officer', 'N/A', '877.874.2273', 'Military Health System', 'Charles-Campbell-Resigned-from-CIO-at-Military-Health-System', 'www.health.mil', 'N/A', '1K-10K', 'National Government', 64, 67, 'Skyline 5, Suite 810, 5111 Leesburg Pike', '', 'Falls Church', 'VA', 'USA', '22041', '2010-08-05', '2010-08-05', 'News', 'Campbell out as MHS CIO, Gates to close Defense CIO''s office', 'Campbell out as MHS CIO, Gates to close Defense CIO''s office<br/>08/09/2010<br/>The Military Health System on Aug. 5 abruptly transferred its chief information officer to a temporary assignment at the Defense Department''s office of the chief information officer, an organization the department will soon shutter, Nextgov has learned.<br/>Multiple government and industry sources confirmed that Charles Campbell was detailed to the CIO''s office, also known as the Office of the Assistant Secretary of Defense for Networks and Information Integration, this month, but Pentagon and MHS spokesmen did not reply to queries for official confirmation as of press deadline.<br/>Sources told Nextgov that Mary Ann Rockey, MHS deputy CIO for acquisition, will take over Campbell''s duties while he is on a 120-day assignment at ASD/NII.<br/>Defense Secretary Robert Gates said at a press briefing on Monday that he planned to eliminate ASD/NII in an effort to cut $100 billion from the Pentagon budget during the next five years.<br/>In the wake of Gates'' plan to eliminate the technology office, Campbell''s transfer to ASD/NII looks like he is being pushed out of a top management position, said sources familiar with the transfer and who asked to remain anonymous.<br/>At about the same time Gates was making his announcement, Sen. Roger Wicker, R-Miss., put a hold on the nomination of Dr. Jonathan Woodson to be assistant secretary of Defense for health affairs. Woodson said at his confirmation hearing on Aug. 3 that he considered development of a new electronic health record for Defense one of his key priorities. Woodson is a vascular surgeon who practices at the Boston Medical Center in Massachusetts and is an associate dean at Boston University.<br/>Tara DiJulio, a spokeswoman for Wicker, said the senator put the nomination on hold because he was concerned about an amendment to the Senate version of the fiscal 2011 Defense authorization bill that would allow military servicewomen to obtain abortion care at military hospitals even if they use their own funds. Wicker spent most of his time at Woodson''s confirmation hearing to voice his opposition to the amendment, which Sen. Roland Burris, D-Ill., sponsored.<br/>DiJulio said Wicker did not believe Woodson adequately addressed concerns about the impact the amendment would have on military hospitals, and he will keep the nomination on hold until Woodson provides detailed answers to questions the senator asked at the hearing.<br/>Campbell''s transfer puts development of a new Defense electronic health record system on hold and leaves a leadership vacuum for the Virtual Lifetime Electronic Record, a medical record for all service members and veterans that Defense is creating in conjunction with the Veterans Affairs Department, sources told Nextgov. But the move will make it easier for Woodson to pick his own CIO when and if confirmed, sources said.', '', 'Resignation', 'Military Health System appointed Charles Campbell as Chief Information Officer', 'Charles (Chuck) Campbell, Senior Executive Service, was appointed Chief Information Officer (CIO) of the Military Health System in September 2007. Mr. Campbell is the principal advisor to the Assistant Secretary of Defense for Health Affairs and to Department of Defense (DoD) medical leaders on all matters related to information management (IM) and information technology (IT).', 'The Military Health System (MHS) is a global medical network within the Department of Defense that provides cutting-edge health care to all U.S. military personnel worldwide.', 'http://www.nextgov.com/nextgov/ng_20100809_1306.php?oref=topnews\r\n', '0000-00-00', '0000-00-00', 0, 'Admin', 0);
INSERT INTO `cto_contact` VALUES(169, 'Venkatesh', '', 'Tadinada', 'Chief Technology Officer', 'venkatesh.tadinada@hannaglobal.com', '925.956.0300', 'Hanna Global Solutions', 'Venkatesh-Tadinada-Appointed-CTO-at-Hanna-Global-Solutions', 'www.hannaglobal.com', '$1-10 Million', '0-25', 'Data Analytics, Management and Storage', 138, 139, '1600 S Main St Ste 215', '', 'Walnut Creek', 'CA', 'USA', '94596', '2010-07-27', '2010-07-27', 'Press Release', 'Hanna Global Solutions Expands its Senior Management Team', 'Hanna Global Solutions Expands its Senior Management Team California, 27 July 2010 -- Hanna Global Solutions (HGS) the niche Employee Benefits advisory and administration firm with solutions specifically directed to the multinational employer today announced the expansion of its Senior Management team. The recent additions to the senior management team include: Venkatesh Tadinada joins as Chief Technology Officer at Hanna Global Solutions. With dual Masters Degrees in Computer Sciences and Business Administration, Venkatesh brings a rare blend of technical expertise and comprehensive understanding of business issues. Venkatesh Tadinada has over 20 years of experience working in various senior management roles with Ernst and Young’s consulting division, and other leading management consulting organizations before founding a technology services company, Solivar, Inc. For over a decade now Venkatesh has been closely involved with Employee Self Service and other Benefits Technology Platforms using the latest web technologies. He is an expert at architecting products and has led entire product development life cycles from conception to commercialization.   Sudhir Pai joins as Director Tax and Compliance at Hanna Global Solutions. He brings over 13 years of experience as a Global Accounting Professional. He is an Associate Chartered Accountant from the Institute of Chartered Accountants of India (ICAI), and a Certified Public Accountant from the Texas State Board of Accountancy. In his new role, Sudhir helps clients of Hanna Global Solutions navigate the complex world of global accounting practices and regulations. Sudhir began his career with Infosys Technologies Ltd., as Accounts Officer – Finance and Administration, in India, and grew to AVP and Head – Finance & Administration – USA. He left the company to pursue his own entrepreneurial venture, and founded Global Value Add, Inc., a global service business offering value added Income Tax solutions (Tax Planning, Preparation, Filing, Representation and Advisory Services) to Residents and Non Residents in United States, India, Canada, and the United Kingdom. Jan Cameron joins as – Director – Retirement Plans at Hanna Global Solutions. She has over 25 years experience as a design and administration expert in the field of Qualified Retirement Plans. Jan is a partner in a CPA firm, with her team, managing that firm’s clients Qualified Plan Administration. Prior to joining HGS, Jan owned an Independent Third Party Administration company administering Qualified Retirement Plans and provided oversight and compliance support for over 200 plans of varied sizes, including 1-person plans to plans with participant headcount exceeding 10,000. Jan’s responsibilities to HGS clients include trust account reconciliation, annual 5500 filings, and compliance test work such as ADP and ACP. She works with IRS and Department of Labor, and is very familiar with its processes and challenges. Jan supports HGS clients in annual filing and disclosure requirements, and has worked on multiple VCP applications. Jan’s years of experience combined with an acute sense of detail and accuracy makes her invaluable as a trusted advisor to keep our clients out of trouble with changing regulations when it comes to their retirement plans. According to Mark Hanna, CEO, Hanna Global Solutions, “Clients who partner with HGS, have access to a team of very seasoned professionals, each with decades of business experience. They bring deep expertise in different aspects of employee benefits plans, processes and technologies, in implementation, compliance, and creative problem solving. HGS provides stability of tenure of the team servicing each account, ensuring that valuable experience and knowledge of past issues and challenges are not lost due to turnover of key employees of our clients. The new additions to our senior management team is going to further enhance our capabilities in offering more value to our clients.” About Hanna Global Solutions   Based in California, Hanna Global Solutions is a full service human resource management firm offering extensive industry expertise and multiple professional credentials in insurance, employee benefits and retirement plans.   Leveling international markets require consistent operational strategies across borders and cultures. In addition, the leveling of these markets changes the dynamics of human resource management from a local to a global approach. Hanna Global Solutions is uniquely positioned to perform consistent and complete human resource solutions. Currently it services an employee base of over 50,000 Worldwide. For more at www.hannaglobal.com  ', 'Hanna Global Solutions appointed Venkatesh Tadinada as Chief Technology Officer', 'Appointment', 'Hanna Global Solutions appointed Venkatesh Tadinada as Chief Technology Officer', 'Venkatesh Tadinada has a dual Masters Degrees in Computer Sciences and Business Administration, Venkatesh brings a rare blend of technical expertise and comprehensive understanding of business issues. Venkatesh Tadinada has over 20 years of experience working in various senior management roles with Ernst and Young’s consulting division, and other leading management consulting organizations before founding a technology services company, Solivar, Inc. For over a decade now Venkatesh has been closely involved with Employee Self Service and other Benefits Technology Platforms using the latest web technologies. He is an expert at architecting products and has led entire product development life cycles from conception to commercialization.', 'Based in California, Hanna Global Solutions is a full service human resource management firm offering extensive industry expertise and multiple professional credentials in insurance, employee benefits and retirement plans.   Leveling international markets require consistent operational strategies across borders and cultures. In addition, the leveling of these markets changes the dynamics of human resource management from a local to a global approach. Hanna Global Solutions is uniquely positioned to perform consistent and complete human resource solutions. Currently it services an employee base of over 50,000 Worldwide. ', 'http://pr-usa.net/index.php?option=com_content&task=view&id=444172&Itemid=34', '2010-08-06', '2010-08-06', 0, 'msobolev', 0);
INSERT INTO `cto_contact` VALUES(170, 'William', 'R.', 'Radon', 'Chief Information Officer', 'william.radon@chamberlain.com', '630.279.3600', 'The Chamberlain Group Inc.', 'William-Radon-Appointed-CIO-at-The-Chamberlain-Group-Inc.', 'www.chamberlain.com', 'Any', 'Any', 'Tools, Hardware and Light Machinery', 82, 96, '845 N Larch Ave', '', 'Elmhurst', 'IL', 'USA', '60126', '2010-07-30', '2010-07-30', 'Press Release', 'Chamberlain Names William R. Radon VP of IT, CIO', 'Chamberlain Names William R. Radon VP of IT, CIO 07/30/2010 The Chamberlain Group Inc., the leading, single-source provider of access control products for residential and commercial applications, has named William R. Radon as Vice President of Information Technology and Chief Information Officer. In this leadership role, Radon will direct all of The Chamberlain Group’s information technology functionality. In addition, he will also assume responsibility as the Executive Sponsor charged to drive the implementation of Chamberlain’s new integrated business system project utilizing the SAP solutions set.  “We are excited that Bill is joining our management team and applying his expertise and profound understanding of SAP to drive an implementation that meets our business need and is cost effective,” says Brendan Gilboy, Executive Vice President and Chief Financial Officer, The Chamberlain Group Inc. “His depth and breadth of experience in developing world class IT organizations will assist us in embracing new forms of technology as a business enablement tool, which will serve as a competitive differentiator for us.”  Prior to joining The Chamberlain Group Inc., Radon established himself as a transformational leader of IT organizations, proven by an impressive track record of more than 25 years in the industry. In addition, Radon has deep, valued experience in directing global SAP implementations for several multi-billion dollar companies. His success and accomplishments have been recognized by SAP itself, as he recently served on SAP’s Independent Executive Advisory Council. Preceding his position in SAP’s Independent Executive Advisory Council, Radon’s past leadership roles include Chief Information Officer for Ball Horticultural Company, VP, Technology Infrastructure Services for W.W. Grainger and he has held executive positions for Nalco Company, The Scotts Company, and Ernst & Young. Radon holds a Bachelor of Science in Computer Science from The Ohio State University. The Chamberlain Group, Inc. manufactures and markets access control products including residential garage door openers, commercial door operators, residential and commercial gate operators, telephone entry systems and related access control products.', '', 'Appointment', 'The Chamberlain Group Inc. appointed William Radon as Chief Information Officer', 'William Randon has an impressive track record of more than 25 years in the industry. In addition, Radon has deep, valued experience in directing global SAP implementations for several multi-billion dollar companies. His success and accomplishments have been recognized by SAP itself, as he recently served on SAP’s Independent Executive Advisory Council.', 'The Chamberlain Group, Inc. manufactures and markets access control products including residential garage door openers, commercial door operators, residential and commercial gate operators, telephone entry systems and related access control products.', 'http://www.professionaldoordealer.com/industrynews/chamberlain-names-william-r--radon-vp-of-it--.html', '2010-08-06', '0000-00-00', 0, 'msobolev', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cto_contact_us`
--

DROP TABLE IF EXISTS `cto_contact_us`;
CREATE TABLE IF NOT EXISTS `cto_contact_us` (
  `contact_id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `add_date` date NOT NULL,
  PRIMARY KEY  (`contact_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `cto_contact_us`
--

INSERT INTO `cto_contact_us` VALUES(2, 'Ananga Mohan Samanta', 'http://gdhdh.com', '206.963.4519', 'anangahelp@yahoo.com', 'Demo testing', '2010-05-06');
INSERT INTO `cto_contact_us` VALUES(7, 'john doe', 'jd.com', '', 'jd@jd.com', 'test', '2010-06-02');
INSERT INTO `cto_contact_us` VALUES(4, 'Arun Mondal', 'http://arun.com', '9830001231', 'arun@mondal.com', 'Demo testing Contact Us email', '2010-05-12');
INSERT INTO `cto_contact_us` VALUES(6, 'Misha Sobolev', 'ctosonthemove.com', '', 'Mike_Sobolev@yahoo.com', 'Test', '2010-05-25');
INSERT INTO `cto_contact_us` VALUES(8, 'johnny doe', 'www.jdow.com', '', 'johnnydoe@jd.com', 'test', '2010-08-15');

-- --------------------------------------------------------

--
-- Table structure for table `cto_countries`
--

DROP TABLE IF EXISTS `cto_countries`;
CREATE TABLE IF NOT EXISTS `cto_countries` (
  `countries_id` int(11) NOT NULL auto_increment,
  `countries_name` varchar(64) NOT NULL,
  `countries_iso_code_2` char(2) NOT NULL,
  `countries_iso_code_3` char(3) NOT NULL,
  PRIMARY KEY  (`countries_id`),
  KEY `IDX_COUNTRIES_NAME` (`countries_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=240 ;

--
-- Dumping data for table `cto_countries`
--

INSERT INTO `cto_countries` VALUES(1, 'Afghanistan', 'AF', 'AFG');
INSERT INTO `cto_countries` VALUES(2, 'Albania', 'AL', 'ALB');
INSERT INTO `cto_countries` VALUES(3, 'Algeria', 'DZ', 'DZA');
INSERT INTO `cto_countries` VALUES(4, 'American Samoa', 'AS', 'ASM');
INSERT INTO `cto_countries` VALUES(5, 'Andorra', 'AD', 'AND');
INSERT INTO `cto_countries` VALUES(6, 'Angola', 'AO', 'AGO');
INSERT INTO `cto_countries` VALUES(7, 'Anguilla', 'AI', 'AIA');
INSERT INTO `cto_countries` VALUES(8, 'Antarctica', 'AQ', 'ATA');
INSERT INTO `cto_countries` VALUES(9, 'Antigua and Barbuda', 'AG', 'ATG');
INSERT INTO `cto_countries` VALUES(10, 'Argentina', 'AR', 'ARG');
INSERT INTO `cto_countries` VALUES(11, 'Armenia', 'AM', 'ARM');
INSERT INTO `cto_countries` VALUES(12, 'Aruba', 'AW', 'ABW');
INSERT INTO `cto_countries` VALUES(13, 'Australia', 'AU', 'AUS');
INSERT INTO `cto_countries` VALUES(14, 'Austria', 'AT', 'AUT');
INSERT INTO `cto_countries` VALUES(15, 'Azerbaijan', 'AZ', 'AZE');
INSERT INTO `cto_countries` VALUES(16, 'Bahamas', 'BS', 'BHS');
INSERT INTO `cto_countries` VALUES(17, 'Bahrain', 'BH', 'BHR');
INSERT INTO `cto_countries` VALUES(18, 'Bangladesh', 'BD', 'BGD');
INSERT INTO `cto_countries` VALUES(19, 'Barbados', 'BB', 'BRB');
INSERT INTO `cto_countries` VALUES(20, 'Belarus', 'BY', 'BLR');
INSERT INTO `cto_countries` VALUES(21, 'Belgium', 'BE', 'BEL');
INSERT INTO `cto_countries` VALUES(22, 'Belize', 'BZ', 'BLZ');
INSERT INTO `cto_countries` VALUES(23, 'Benin', 'BJ', 'BEN');
INSERT INTO `cto_countries` VALUES(24, 'Bermuda', 'BM', 'BMU');
INSERT INTO `cto_countries` VALUES(25, 'Bhutan', 'BT', 'BTN');
INSERT INTO `cto_countries` VALUES(26, 'Bolivia', 'BO', 'BOL');
INSERT INTO `cto_countries` VALUES(27, 'Bosnia and Herzegowina', 'BA', 'BIH');
INSERT INTO `cto_countries` VALUES(28, 'Botswana', 'BW', 'BWA');
INSERT INTO `cto_countries` VALUES(29, 'Bouvet Island', 'BV', 'BVT');
INSERT INTO `cto_countries` VALUES(30, 'Brazil', 'BR', 'BRA');
INSERT INTO `cto_countries` VALUES(31, 'British Indian Ocean Territory', 'IO', 'IOT');
INSERT INTO `cto_countries` VALUES(32, 'Brunei Darussalam', 'BN', 'BRN');
INSERT INTO `cto_countries` VALUES(33, 'Bulgaria', 'BG', 'BGR');
INSERT INTO `cto_countries` VALUES(34, 'Burkina Faso', 'BF', 'BFA');
INSERT INTO `cto_countries` VALUES(35, 'Burundi', 'BI', 'BDI');
INSERT INTO `cto_countries` VALUES(36, 'Cambodia', 'KH', 'KHM');
INSERT INTO `cto_countries` VALUES(37, 'Cameroon', 'CM', 'CMR');
INSERT INTO `cto_countries` VALUES(38, 'Canada', 'CA', 'CAN');
INSERT INTO `cto_countries` VALUES(39, 'Cape Verde', 'CV', 'CPV');
INSERT INTO `cto_countries` VALUES(40, 'Cayman Islands', 'KY', 'CYM');
INSERT INTO `cto_countries` VALUES(41, 'Central African Republic', 'CF', 'CAF');
INSERT INTO `cto_countries` VALUES(42, 'Chad', 'TD', 'TCD');
INSERT INTO `cto_countries` VALUES(43, 'Chile', 'CL', 'CHL');
INSERT INTO `cto_countries` VALUES(44, 'China', 'CN', 'CHN');
INSERT INTO `cto_countries` VALUES(45, 'Christmas Island', 'CX', 'CXR');
INSERT INTO `cto_countries` VALUES(46, 'Cocos (Keeling) Islands', 'CC', 'CCK');
INSERT INTO `cto_countries` VALUES(47, 'Colombia', 'CO', 'COL');
INSERT INTO `cto_countries` VALUES(48, 'Comoros', 'KM', 'COM');
INSERT INTO `cto_countries` VALUES(49, 'Congo', 'CG', 'COG');
INSERT INTO `cto_countries` VALUES(50, 'Cook Islands', 'CK', 'COK');
INSERT INTO `cto_countries` VALUES(51, 'Costa Rica', 'CR', 'CRI');
INSERT INTO `cto_countries` VALUES(52, 'Cote D''Ivoire', 'CI', 'CIV');
INSERT INTO `cto_countries` VALUES(53, 'Croatia', 'HR', 'HRV');
INSERT INTO `cto_countries` VALUES(54, 'Cuba', 'CU', 'CUB');
INSERT INTO `cto_countries` VALUES(55, 'Cyprus', 'CY', 'CYP');
INSERT INTO `cto_countries` VALUES(56, 'Czech Republic', 'CZ', 'CZE');
INSERT INTO `cto_countries` VALUES(57, 'Denmark', 'DK', 'DNK');
INSERT INTO `cto_countries` VALUES(58, 'Djibouti', 'DJ', 'DJI');
INSERT INTO `cto_countries` VALUES(59, 'Dominica', 'DM', 'DMA');
INSERT INTO `cto_countries` VALUES(60, 'Dominican Republic', 'DO', 'DOM');
INSERT INTO `cto_countries` VALUES(61, 'East Timor', 'TP', 'TMP');
INSERT INTO `cto_countries` VALUES(62, 'Ecuador', 'EC', 'ECU');
INSERT INTO `cto_countries` VALUES(63, 'Egypt', 'EG', 'EGY');
INSERT INTO `cto_countries` VALUES(64, 'El Salvador', 'SV', 'SLV');
INSERT INTO `cto_countries` VALUES(65, 'Equatorial Guinea', 'GQ', 'GNQ');
INSERT INTO `cto_countries` VALUES(66, 'Eritrea', 'ER', 'ERI');
INSERT INTO `cto_countries` VALUES(67, 'Estonia', 'EE', 'EST');
INSERT INTO `cto_countries` VALUES(68, 'Ethiopia', 'ET', 'ETH');
INSERT INTO `cto_countries` VALUES(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK');
INSERT INTO `cto_countries` VALUES(70, 'Faroe Islands', 'FO', 'FRO');
INSERT INTO `cto_countries` VALUES(71, 'Fiji', 'FJ', 'FJI');
INSERT INTO `cto_countries` VALUES(72, 'Finland', 'FI', 'FIN');
INSERT INTO `cto_countries` VALUES(73, 'France', 'FR', 'FRA');
INSERT INTO `cto_countries` VALUES(74, 'France, Metropolitan', 'FX', 'FXX');
INSERT INTO `cto_countries` VALUES(75, 'French Guiana', 'GF', 'GUF');
INSERT INTO `cto_countries` VALUES(76, 'French Polynesia', 'PF', 'PYF');
INSERT INTO `cto_countries` VALUES(77, 'French Southern Territories', 'TF', 'ATF');
INSERT INTO `cto_countries` VALUES(78, 'Gabon', 'GA', 'GAB');
INSERT INTO `cto_countries` VALUES(79, 'Gambia', 'GM', 'GMB');
INSERT INTO `cto_countries` VALUES(80, 'Georgia', 'GE', 'GEO');
INSERT INTO `cto_countries` VALUES(81, 'Germany', 'DE', 'DEU');
INSERT INTO `cto_countries` VALUES(82, 'Ghana', 'GH', 'GHA');
INSERT INTO `cto_countries` VALUES(83, 'Gibraltar', 'GI', 'GIB');
INSERT INTO `cto_countries` VALUES(84, 'Greece', 'GR', 'GRC');
INSERT INTO `cto_countries` VALUES(85, 'Greenland', 'GL', 'GRL');
INSERT INTO `cto_countries` VALUES(86, 'Grenada', 'GD', 'GRD');
INSERT INTO `cto_countries` VALUES(87, 'Guadeloupe', 'GP', 'GLP');
INSERT INTO `cto_countries` VALUES(88, 'Guam', 'GU', 'GUM');
INSERT INTO `cto_countries` VALUES(89, 'Guatemala', 'GT', 'GTM');
INSERT INTO `cto_countries` VALUES(90, 'Guinea', 'GN', 'GIN');
INSERT INTO `cto_countries` VALUES(91, 'Guinea-bissau', 'GW', 'GNB');
INSERT INTO `cto_countries` VALUES(92, 'Guyana', 'GY', 'GUY');
INSERT INTO `cto_countries` VALUES(93, 'Haiti', 'HT', 'HTI');
INSERT INTO `cto_countries` VALUES(94, 'Heard and Mc Donald Islands', 'HM', 'HMD');
INSERT INTO `cto_countries` VALUES(95, 'Honduras', 'HN', 'HND');
INSERT INTO `cto_countries` VALUES(96, 'Hong Kong', 'HK', 'HKG');
INSERT INTO `cto_countries` VALUES(97, 'Hungary', 'HU', 'HUN');
INSERT INTO `cto_countries` VALUES(98, 'Iceland', 'IS', 'ISL');
INSERT INTO `cto_countries` VALUES(99, 'India', 'IN', 'IND');
INSERT INTO `cto_countries` VALUES(100, 'Indonesia', 'ID', 'IDN');
INSERT INTO `cto_countries` VALUES(101, 'Iran (Islamic Republic of)', 'IR', 'IRN');
INSERT INTO `cto_countries` VALUES(102, 'Iraq', 'IQ', 'IRQ');
INSERT INTO `cto_countries` VALUES(103, 'Ireland', 'IE', 'IRL');
INSERT INTO `cto_countries` VALUES(104, 'Israel', 'IL', 'ISR');
INSERT INTO `cto_countries` VALUES(105, 'Italy', 'IT', 'ITA');
INSERT INTO `cto_countries` VALUES(106, 'Jamaica', 'JM', 'JAM');
INSERT INTO `cto_countries` VALUES(107, 'Japan', 'JP', 'JPN');
INSERT INTO `cto_countries` VALUES(108, 'Jordan', 'JO', 'JOR');
INSERT INTO `cto_countries` VALUES(109, 'Kazakhstan', 'KZ', 'KAZ');
INSERT INTO `cto_countries` VALUES(110, 'Kenya', 'KE', 'KEN');
INSERT INTO `cto_countries` VALUES(111, 'Kiribati', 'KI', 'KIR');
INSERT INTO `cto_countries` VALUES(112, 'Korea, Democratic People''s Republic of', 'KP', 'PRK');
INSERT INTO `cto_countries` VALUES(113, 'Korea, Republic of', 'KR', 'KOR');
INSERT INTO `cto_countries` VALUES(114, 'Kuwait', 'KW', 'KWT');
INSERT INTO `cto_countries` VALUES(115, 'Kyrgyzstan', 'KG', 'KGZ');
INSERT INTO `cto_countries` VALUES(116, 'Lao People''s Democratic Republic', 'LA', 'LAO');
INSERT INTO `cto_countries` VALUES(117, 'Latvia', 'LV', 'LVA');
INSERT INTO `cto_countries` VALUES(118, 'Lebanon', 'LB', 'LBN');
INSERT INTO `cto_countries` VALUES(119, 'Lesotho', 'LS', 'LSO');
INSERT INTO `cto_countries` VALUES(120, 'Liberia', 'LR', 'LBR');
INSERT INTO `cto_countries` VALUES(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY');
INSERT INTO `cto_countries` VALUES(122, 'Liechtenstein', 'LI', 'LIE');
INSERT INTO `cto_countries` VALUES(123, 'Lithuania', 'LT', 'LTU');
INSERT INTO `cto_countries` VALUES(124, 'Luxembourg', 'LU', 'LUX');
INSERT INTO `cto_countries` VALUES(125, 'Macau', 'MO', 'MAC');
INSERT INTO `cto_countries` VALUES(126, 'Macedonia, The Former Yugoslav Republic of', 'MK', 'MKD');
INSERT INTO `cto_countries` VALUES(127, 'Madagascar', 'MG', 'MDG');
INSERT INTO `cto_countries` VALUES(128, 'Malawi', 'MW', 'MWI');
INSERT INTO `cto_countries` VALUES(129, 'Malaysia', 'MY', 'MYS');
INSERT INTO `cto_countries` VALUES(130, 'Maldives', 'MV', 'MDV');
INSERT INTO `cto_countries` VALUES(131, 'Mali', 'ML', 'MLI');
INSERT INTO `cto_countries` VALUES(132, 'Malta', 'MT', 'MLT');
INSERT INTO `cto_countries` VALUES(133, 'Marshall Islands', 'MH', 'MHL');
INSERT INTO `cto_countries` VALUES(134, 'Martinique', 'MQ', 'MTQ');
INSERT INTO `cto_countries` VALUES(135, 'Mauritania', 'MR', 'MRT');
INSERT INTO `cto_countries` VALUES(136, 'Mauritius', 'MU', 'MUS');
INSERT INTO `cto_countries` VALUES(137, 'Mayotte', 'YT', 'MYT');
INSERT INTO `cto_countries` VALUES(138, 'Mexico', 'MX', 'MEX');
INSERT INTO `cto_countries` VALUES(139, 'Micronesia, Federated States of', 'FM', 'FSM');
INSERT INTO `cto_countries` VALUES(140, 'Moldova, Republic of', 'MD', 'MDA');
INSERT INTO `cto_countries` VALUES(141, 'Monaco', 'MC', 'MCO');
INSERT INTO `cto_countries` VALUES(142, 'Mongolia', 'MN', 'MNG');
INSERT INTO `cto_countries` VALUES(143, 'Montserrat', 'MS', 'MSR');
INSERT INTO `cto_countries` VALUES(144, 'Morocco', 'MA', 'MAR');
INSERT INTO `cto_countries` VALUES(145, 'Mozambique', 'MZ', 'MOZ');
INSERT INTO `cto_countries` VALUES(146, 'Myanmar', 'MM', 'MMR');
INSERT INTO `cto_countries` VALUES(147, 'Namibia', 'NA', 'NAM');
INSERT INTO `cto_countries` VALUES(148, 'Nauru', 'NR', 'NRU');
INSERT INTO `cto_countries` VALUES(149, 'Nepal', 'NP', 'NPL');
INSERT INTO `cto_countries` VALUES(150, 'Netherlands', 'NL', 'NLD');
INSERT INTO `cto_countries` VALUES(151, 'Netherlands Antilles', 'AN', 'ANT');
INSERT INTO `cto_countries` VALUES(152, 'New Caledonia', 'NC', 'NCL');
INSERT INTO `cto_countries` VALUES(153, 'New Zealand', 'NZ', 'NZL');
INSERT INTO `cto_countries` VALUES(154, 'Nicaragua', 'NI', 'NIC');
INSERT INTO `cto_countries` VALUES(155, 'Niger', 'NE', 'NER');
INSERT INTO `cto_countries` VALUES(156, 'Nigeria', 'NG', 'NGA');
INSERT INTO `cto_countries` VALUES(157, 'Niue', 'NU', 'NIU');
INSERT INTO `cto_countries` VALUES(158, 'Norfolk Island', 'NF', 'NFK');
INSERT INTO `cto_countries` VALUES(159, 'Northern Mariana Islands', 'MP', 'MNP');
INSERT INTO `cto_countries` VALUES(160, 'Norway', 'NO', 'NOR');
INSERT INTO `cto_countries` VALUES(161, 'Oman', 'OM', 'OMN');
INSERT INTO `cto_countries` VALUES(162, 'Pakistan', 'PK', 'PAK');
INSERT INTO `cto_countries` VALUES(163, 'Palau', 'PW', 'PLW');
INSERT INTO `cto_countries` VALUES(164, 'Panama', 'PA', 'PAN');
INSERT INTO `cto_countries` VALUES(165, 'Papua New Guinea', 'PG', 'PNG');
INSERT INTO `cto_countries` VALUES(166, 'Paraguay', 'PY', 'PRY');
INSERT INTO `cto_countries` VALUES(167, 'Peru', 'PE', 'PER');
INSERT INTO `cto_countries` VALUES(168, 'Philippines', 'PH', 'PHL');
INSERT INTO `cto_countries` VALUES(169, 'Pitcairn', 'PN', 'PCN');
INSERT INTO `cto_countries` VALUES(170, 'Poland', 'PL', 'POL');
INSERT INTO `cto_countries` VALUES(171, 'Portugal', 'PT', 'PRT');
INSERT INTO `cto_countries` VALUES(172, 'Puerto Rico', 'PR', 'PRI');
INSERT INTO `cto_countries` VALUES(173, 'Qatar', 'QA', 'QAT');
INSERT INTO `cto_countries` VALUES(174, 'Reunion', 'RE', 'REU');
INSERT INTO `cto_countries` VALUES(175, 'Romania', 'RO', 'ROM');
INSERT INTO `cto_countries` VALUES(176, 'Russian Federation', 'RU', 'RUS');
INSERT INTO `cto_countries` VALUES(177, 'Rwanda', 'RW', 'RWA');
INSERT INTO `cto_countries` VALUES(178, 'Saint Kitts and Nevis', 'KN', 'KNA');
INSERT INTO `cto_countries` VALUES(179, 'Saint Lucia', 'LC', 'LCA');
INSERT INTO `cto_countries` VALUES(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT');
INSERT INTO `cto_countries` VALUES(181, 'Samoa', 'WS', 'WSM');
INSERT INTO `cto_countries` VALUES(182, 'San Marino', 'SM', 'SMR');
INSERT INTO `cto_countries` VALUES(183, 'Sao Tome and Principe', 'ST', 'STP');
INSERT INTO `cto_countries` VALUES(184, 'Saudi Arabia', 'SA', 'SAU');
INSERT INTO `cto_countries` VALUES(185, 'Senegal', 'SN', 'SEN');
INSERT INTO `cto_countries` VALUES(186, 'Seychelles', 'SC', 'SYC');
INSERT INTO `cto_countries` VALUES(187, 'Sierra Leone', 'SL', 'SLE');
INSERT INTO `cto_countries` VALUES(188, 'Singapore', 'SG', 'SGP');
INSERT INTO `cto_countries` VALUES(189, 'Slovakia (Slovak Republic)', 'SK', 'SVK');
INSERT INTO `cto_countries` VALUES(190, 'Slovenia', 'SI', 'SVN');
INSERT INTO `cto_countries` VALUES(191, 'Solomon Islands', 'SB', 'SLB');
INSERT INTO `cto_countries` VALUES(192, 'Somalia', 'SO', 'SOM');
INSERT INTO `cto_countries` VALUES(193, 'South Africa', 'ZA', 'ZAF');
INSERT INTO `cto_countries` VALUES(194, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS');
INSERT INTO `cto_countries` VALUES(195, 'Spain', 'ES', 'ESP');
INSERT INTO `cto_countries` VALUES(196, 'Sri Lanka', 'LK', 'LKA');
INSERT INTO `cto_countries` VALUES(197, 'St. Helena', 'SH', 'SHN');
INSERT INTO `cto_countries` VALUES(198, 'St. Pierre and Miquelon', 'PM', 'SPM');
INSERT INTO `cto_countries` VALUES(199, 'Sudan', 'SD', 'SDN');
INSERT INTO `cto_countries` VALUES(200, 'Suriname', 'SR', 'SUR');
INSERT INTO `cto_countries` VALUES(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM');
INSERT INTO `cto_countries` VALUES(202, 'Swaziland', 'SZ', 'SWZ');
INSERT INTO `cto_countries` VALUES(203, 'Sweden', 'SE', 'SWE');
INSERT INTO `cto_countries` VALUES(204, 'Switzerland', 'CH', 'CHE');
INSERT INTO `cto_countries` VALUES(205, 'Syrian Arab Republic', 'SY', 'SYR');
INSERT INTO `cto_countries` VALUES(206, 'Taiwan', 'TW', 'TWN');
INSERT INTO `cto_countries` VALUES(207, 'Tajikistan', 'TJ', 'TJK');
INSERT INTO `cto_countries` VALUES(208, 'Tanzania, United Republic of', 'TZ', 'TZA');
INSERT INTO `cto_countries` VALUES(209, 'Thailand', 'TH', 'THA');
INSERT INTO `cto_countries` VALUES(210, 'Togo', 'TG', 'TGO');
INSERT INTO `cto_countries` VALUES(211, 'Tokelau', 'TK', 'TKL');
INSERT INTO `cto_countries` VALUES(212, 'Tonga', 'TO', 'TON');
INSERT INTO `cto_countries` VALUES(213, 'Trinidad and Tobago', 'TT', 'TTO');
INSERT INTO `cto_countries` VALUES(214, 'Tunisia', 'TN', 'TUN');
INSERT INTO `cto_countries` VALUES(215, 'Turkey', 'TR', 'TUR');
INSERT INTO `cto_countries` VALUES(216, 'Turkmenistan', 'TM', 'TKM');
INSERT INTO `cto_countries` VALUES(217, 'Turks and Caicos Islands', 'TC', 'TCA');
INSERT INTO `cto_countries` VALUES(218, 'Tuvalu', 'TV', 'TUV');
INSERT INTO `cto_countries` VALUES(219, 'Uganda', 'UG', 'UGA');
INSERT INTO `cto_countries` VALUES(220, 'Ukraine', 'UA', 'UKR');
INSERT INTO `cto_countries` VALUES(221, 'United Arab Emirates', 'AE', 'ARE');
INSERT INTO `cto_countries` VALUES(222, 'United Kingdom', 'GB', 'GBR');
INSERT INTO `cto_countries` VALUES(223, 'United States', 'US', 'USA');
INSERT INTO `cto_countries` VALUES(224, 'United States Minor Outlying Islands', 'UM', 'UMI');
INSERT INTO `cto_countries` VALUES(225, 'Uruguay', 'UY', 'URY');
INSERT INTO `cto_countries` VALUES(226, 'Uzbekistan', 'UZ', 'UZB');
INSERT INTO `cto_countries` VALUES(227, 'Vanuatu', 'VU', 'VUT');
INSERT INTO `cto_countries` VALUES(228, 'Vatican City State (Holy See)', 'VA', 'VAT');
INSERT INTO `cto_countries` VALUES(229, 'Venezuela', 'VE', 'VEN');
INSERT INTO `cto_countries` VALUES(230, 'Viet Nam', 'VN', 'VNM');
INSERT INTO `cto_countries` VALUES(231, 'Virgin Islands (British)', 'VG', 'VGB');
INSERT INTO `cto_countries` VALUES(232, 'Virgin Islands (U.S.)', 'VI', 'VIR');
INSERT INTO `cto_countries` VALUES(233, 'Wallis and Futuna Islands', 'WF', 'WLF');
INSERT INTO `cto_countries` VALUES(234, 'Western Sahara', 'EH', 'ESH');
INSERT INTO `cto_countries` VALUES(235, 'Yemen', 'YE', 'YEM');
INSERT INTO `cto_countries` VALUES(236, 'Yugoslavia', 'YU', 'YUG');
INSERT INTO `cto_countries` VALUES(237, 'Zaire', 'ZR', 'ZAR');
INSERT INTO `cto_countries` VALUES(238, 'Zambia', 'ZM', 'ZMB');
INSERT INTO `cto_countries` VALUES(239, 'Zimbabwe', 'ZW', 'ZWE');

-- --------------------------------------------------------

--
-- Table structure for table `cto_data_entry_user`
--

DROP TABLE IF EXISTS `cto_data_entry_user`;
CREATE TABLE IF NOT EXISTS `cto_data_entry_user` (
  `user_id` int(11) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL,
  `login_name` varchar(200) NOT NULL,
  `password` varchar(50) NOT NULL,
  `pw` varchar(50) NOT NULL,
  `add_date` date NOT NULL,
  `status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cto_data_entry_user`
--

INSERT INTO `cto_data_entry_user` VALUES(1, 'Amit Mondal', 'Amit', 'e10adc3949ba59abbe56e057f20f883e', '123456', '2010-05-19', 0);
INSERT INTO `cto_data_entry_user` VALUES(2, 'Demo User', 'demouser', 'e10adc3949ba59abbe56e057f20f883e', '123456', '2010-05-24', 0);
INSERT INTO `cto_data_entry_user` VALUES(3, 'Misha', 'msobolev', '051959e0db8058d488793a49e922b367', 'ryazan', '2010-07-26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cto_date_range`
--

DROP TABLE IF EXISTS `cto_date_range`;
CREATE TABLE IF NOT EXISTS `cto_date_range` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `cto_date_range`
--

INSERT INTO `cto_date_range` VALUES(1, 'In the Last Day');
INSERT INTO `cto_date_range` VALUES(2, 'In the Last Week');
INSERT INTO `cto_date_range` VALUES(3, 'In the Last 3 Months');
INSERT INTO `cto_date_range` VALUES(4, 'In the Last 6 Months');
INSERT INTO `cto_date_range` VALUES(5, 'In the Last Year');
INSERT INTO `cto_date_range` VALUES(6, 'In the Last 2 Years');
INSERT INTO `cto_date_range` VALUES(7, 'Enter Date Range...');

-- --------------------------------------------------------

--
-- Table structure for table `cto_download`
--

DROP TABLE IF EXISTS `cto_download`;
CREATE TABLE IF NOT EXISTS `cto_download` (
  `download_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `add_date` date NOT NULL,
  PRIMARY KEY  (`download_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `cto_download`
--

INSERT INTO `cto_download` VALUES(1, 4, '2010-05-12');
INSERT INTO `cto_download` VALUES(2, 4, '2010-05-12');
INSERT INTO `cto_download` VALUES(3, 7, '2010-05-20');
INSERT INTO `cto_download` VALUES(4, 6, '2010-05-21');
INSERT INTO `cto_download` VALUES(5, 6, '2010-05-21');
INSERT INTO `cto_download` VALUES(6, 6, '2010-05-21');
INSERT INTO `cto_download` VALUES(7, 6, '2010-05-21');
INSERT INTO `cto_download` VALUES(8, 6, '2010-05-21');
INSERT INTO `cto_download` VALUES(9, 6, '2010-05-21');
INSERT INTO `cto_download` VALUES(10, 6, '2010-05-21');
INSERT INTO `cto_download` VALUES(11, 6, '2010-05-21');
INSERT INTO `cto_download` VALUES(12, 6, '2010-05-21');
INSERT INTO `cto_download` VALUES(13, 6, '2010-05-21');
INSERT INTO `cto_download` VALUES(14, 6, '2010-05-21');
INSERT INTO `cto_download` VALUES(15, 6, '2010-05-22');
INSERT INTO `cto_download` VALUES(16, 8, '2010-05-24');
INSERT INTO `cto_download` VALUES(17, 9, '2010-05-26');
INSERT INTO `cto_download` VALUES(18, 1, '2010-06-01');
INSERT INTO `cto_download` VALUES(19, 9, '2010-06-02');
INSERT INTO `cto_download` VALUES(20, 9, '2010-06-10');
INSERT INTO `cto_download` VALUES(21, 26, '2010-06-14');
INSERT INTO `cto_download` VALUES(22, 26, '2010-06-14');
INSERT INTO `cto_download` VALUES(23, 26, '2010-06-14');
INSERT INTO `cto_download` VALUES(24, 26, '2010-06-14');
INSERT INTO `cto_download` VALUES(25, 9, '2010-06-14');
INSERT INTO `cto_download` VALUES(26, 9, '2010-07-05');
INSERT INTO `cto_download` VALUES(27, 9, '2010-07-09');
INSERT INTO `cto_download` VALUES(28, 9, '2010-07-23');

-- --------------------------------------------------------

--
-- Table structure for table `cto_download_trans`
--

DROP TABLE IF EXISTS `cto_download_trans`;
CREATE TABLE IF NOT EXISTS `cto_download_trans` (
  `download_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cto_download_trans`
--

INSERT INTO `cto_download_trans` VALUES(1, 2);
INSERT INTO `cto_download_trans` VALUES(1, 3);
INSERT INTO `cto_download_trans` VALUES(2, 1);
INSERT INTO `cto_download_trans` VALUES(2, 4);
INSERT INTO `cto_download_trans` VALUES(2, 5);
INSERT INTO `cto_download_trans` VALUES(2, 6);
INSERT INTO `cto_download_trans` VALUES(2, 7);
INSERT INTO `cto_download_trans` VALUES(2, 8);
INSERT INTO `cto_download_trans` VALUES(2, 9);
INSERT INTO `cto_download_trans` VALUES(2, 10);
INSERT INTO `cto_download_trans` VALUES(2, 11);
INSERT INTO `cto_download_trans` VALUES(2, 12);
INSERT INTO `cto_download_trans` VALUES(2, 13);
INSERT INTO `cto_download_trans` VALUES(2, 14);
INSERT INTO `cto_download_trans` VALUES(2, 15);
INSERT INTO `cto_download_trans` VALUES(2, 16);
INSERT INTO `cto_download_trans` VALUES(2, 17);
INSERT INTO `cto_download_trans` VALUES(2, 18);
INSERT INTO `cto_download_trans` VALUES(2, 19);
INSERT INTO `cto_download_trans` VALUES(2, 20);
INSERT INTO `cto_download_trans` VALUES(2, 21);
INSERT INTO `cto_download_trans` VALUES(2, 22);
INSERT INTO `cto_download_trans` VALUES(3, 1);
INSERT INTO `cto_download_trans` VALUES(3, 2);
INSERT INTO `cto_download_trans` VALUES(3, 3);
INSERT INTO `cto_download_trans` VALUES(3, 4);
INSERT INTO `cto_download_trans` VALUES(3, 5);
INSERT INTO `cto_download_trans` VALUES(3, 6);
INSERT INTO `cto_download_trans` VALUES(3, 7);
INSERT INTO `cto_download_trans` VALUES(3, 8);
INSERT INTO `cto_download_trans` VALUES(3, 9);
INSERT INTO `cto_download_trans` VALUES(3, 10);
INSERT INTO `cto_download_trans` VALUES(3, 11);
INSERT INTO `cto_download_trans` VALUES(3, 12);
INSERT INTO `cto_download_trans` VALUES(3, 13);
INSERT INTO `cto_download_trans` VALUES(3, 14);
INSERT INTO `cto_download_trans` VALUES(3, 15);
INSERT INTO `cto_download_trans` VALUES(3, 16);
INSERT INTO `cto_download_trans` VALUES(3, 17);
INSERT INTO `cto_download_trans` VALUES(3, 18);
INSERT INTO `cto_download_trans` VALUES(3, 19);
INSERT INTO `cto_download_trans` VALUES(3, 20);
INSERT INTO `cto_download_trans` VALUES(3, 21);
INSERT INTO `cto_download_trans` VALUES(3, 22);
INSERT INTO `cto_download_trans` VALUES(3, 23);
INSERT INTO `cto_download_trans` VALUES(3, 24);
INSERT INTO `cto_download_trans` VALUES(3, 25);
INSERT INTO `cto_download_trans` VALUES(3, 26);
INSERT INTO `cto_download_trans` VALUES(3, 27);
INSERT INTO `cto_download_trans` VALUES(3, 28);
INSERT INTO `cto_download_trans` VALUES(3, 29);
INSERT INTO `cto_download_trans` VALUES(3, 30);
INSERT INTO `cto_download_trans` VALUES(3, 31);
INSERT INTO `cto_download_trans` VALUES(3, 32);
INSERT INTO `cto_download_trans` VALUES(3, 33);
INSERT INTO `cto_download_trans` VALUES(3, 34);
INSERT INTO `cto_download_trans` VALUES(3, 35);
INSERT INTO `cto_download_trans` VALUES(3, 36);
INSERT INTO `cto_download_trans` VALUES(3, 37);
INSERT INTO `cto_download_trans` VALUES(3, 38);
INSERT INTO `cto_download_trans` VALUES(3, 39);
INSERT INTO `cto_download_trans` VALUES(3, 40);
INSERT INTO `cto_download_trans` VALUES(3, 41);
INSERT INTO `cto_download_trans` VALUES(3, 42);
INSERT INTO `cto_download_trans` VALUES(3, 43);
INSERT INTO `cto_download_trans` VALUES(3, 44);
INSERT INTO `cto_download_trans` VALUES(3, 45);
INSERT INTO `cto_download_trans` VALUES(3, 46);
INSERT INTO `cto_download_trans` VALUES(3, 47);
INSERT INTO `cto_download_trans` VALUES(3, 48);
INSERT INTO `cto_download_trans` VALUES(3, 49);
INSERT INTO `cto_download_trans` VALUES(3, 50);
INSERT INTO `cto_download_trans` VALUES(3, 51);
INSERT INTO `cto_download_trans` VALUES(3, 52);
INSERT INTO `cto_download_trans` VALUES(3, 53);
INSERT INTO `cto_download_trans` VALUES(3, 54);
INSERT INTO `cto_download_trans` VALUES(3, 55);
INSERT INTO `cto_download_trans` VALUES(3, 56);
INSERT INTO `cto_download_trans` VALUES(3, 57);
INSERT INTO `cto_download_trans` VALUES(3, 58);
INSERT INTO `cto_download_trans` VALUES(3, 59);
INSERT INTO `cto_download_trans` VALUES(3, 60);
INSERT INTO `cto_download_trans` VALUES(3, 61);
INSERT INTO `cto_download_trans` VALUES(3, 62);
INSERT INTO `cto_download_trans` VALUES(3, 63);
INSERT INTO `cto_download_trans` VALUES(3, 64);
INSERT INTO `cto_download_trans` VALUES(3, 65);
INSERT INTO `cto_download_trans` VALUES(3, 66);
INSERT INTO `cto_download_trans` VALUES(3, 67);
INSERT INTO `cto_download_trans` VALUES(3, 68);
INSERT INTO `cto_download_trans` VALUES(3, 69);
INSERT INTO `cto_download_trans` VALUES(3, 70);
INSERT INTO `cto_download_trans` VALUES(3, 71);
INSERT INTO `cto_download_trans` VALUES(3, 72);
INSERT INTO `cto_download_trans` VALUES(3, 73);
INSERT INTO `cto_download_trans` VALUES(3, 74);
INSERT INTO `cto_download_trans` VALUES(3, 75);
INSERT INTO `cto_download_trans` VALUES(3, 76);
INSERT INTO `cto_download_trans` VALUES(3, 77);
INSERT INTO `cto_download_trans` VALUES(3, 78);
INSERT INTO `cto_download_trans` VALUES(3, 79);
INSERT INTO `cto_download_trans` VALUES(3, 80);
INSERT INTO `cto_download_trans` VALUES(3, 81);
INSERT INTO `cto_download_trans` VALUES(3, 82);
INSERT INTO `cto_download_trans` VALUES(3, 83);
INSERT INTO `cto_download_trans` VALUES(3, 84);
INSERT INTO `cto_download_trans` VALUES(3, 85);
INSERT INTO `cto_download_trans` VALUES(3, 86);
INSERT INTO `cto_download_trans` VALUES(3, 87);
INSERT INTO `cto_download_trans` VALUES(3, 88);
INSERT INTO `cto_download_trans` VALUES(3, 89);
INSERT INTO `cto_download_trans` VALUES(3, 90);
INSERT INTO `cto_download_trans` VALUES(3, 91);
INSERT INTO `cto_download_trans` VALUES(3, 92);
INSERT INTO `cto_download_trans` VALUES(3, 93);
INSERT INTO `cto_download_trans` VALUES(3, 94);
INSERT INTO `cto_download_trans` VALUES(3, 95);
INSERT INTO `cto_download_trans` VALUES(3, 96);
INSERT INTO `cto_download_trans` VALUES(3, 97);
INSERT INTO `cto_download_trans` VALUES(3, 98);
INSERT INTO `cto_download_trans` VALUES(3, 99);
INSERT INTO `cto_download_trans` VALUES(3, 100);
INSERT INTO `cto_download_trans` VALUES(3, 101);
INSERT INTO `cto_download_trans` VALUES(3, 102);
INSERT INTO `cto_download_trans` VALUES(3, 103);
INSERT INTO `cto_download_trans` VALUES(3, 104);
INSERT INTO `cto_download_trans` VALUES(3, 105);
INSERT INTO `cto_download_trans` VALUES(3, 106);
INSERT INTO `cto_download_trans` VALUES(3, 107);
INSERT INTO `cto_download_trans` VALUES(3, 108);
INSERT INTO `cto_download_trans` VALUES(3, 109);
INSERT INTO `cto_download_trans` VALUES(3, 110);
INSERT INTO `cto_download_trans` VALUES(3, 111);
INSERT INTO `cto_download_trans` VALUES(3, 112);
INSERT INTO `cto_download_trans` VALUES(3, 113);
INSERT INTO `cto_download_trans` VALUES(3, 114);
INSERT INTO `cto_download_trans` VALUES(3, 115);
INSERT INTO `cto_download_trans` VALUES(3, 116);
INSERT INTO `cto_download_trans` VALUES(3, 117);
INSERT INTO `cto_download_trans` VALUES(3, 118);
INSERT INTO `cto_download_trans` VALUES(3, 119);
INSERT INTO `cto_download_trans` VALUES(3, 120);
INSERT INTO `cto_download_trans` VALUES(3, 121);
INSERT INTO `cto_download_trans` VALUES(3, 122);
INSERT INTO `cto_download_trans` VALUES(4, 35);
INSERT INTO `cto_download_trans` VALUES(4, 66);
INSERT INTO `cto_download_trans` VALUES(4, 120);
INSERT INTO `cto_download_trans` VALUES(5, 1);
INSERT INTO `cto_download_trans` VALUES(5, 2);
INSERT INTO `cto_download_trans` VALUES(5, 3);
INSERT INTO `cto_download_trans` VALUES(5, 4);
INSERT INTO `cto_download_trans` VALUES(5, 5);
INSERT INTO `cto_download_trans` VALUES(5, 6);
INSERT INTO `cto_download_trans` VALUES(5, 7);
INSERT INTO `cto_download_trans` VALUES(5, 8);
INSERT INTO `cto_download_trans` VALUES(5, 9);
INSERT INTO `cto_download_trans` VALUES(5, 10);
INSERT INTO `cto_download_trans` VALUES(5, 11);
INSERT INTO `cto_download_trans` VALUES(5, 12);
INSERT INTO `cto_download_trans` VALUES(5, 13);
INSERT INTO `cto_download_trans` VALUES(5, 14);
INSERT INTO `cto_download_trans` VALUES(5, 15);
INSERT INTO `cto_download_trans` VALUES(5, 16);
INSERT INTO `cto_download_trans` VALUES(5, 17);
INSERT INTO `cto_download_trans` VALUES(5, 18);
INSERT INTO `cto_download_trans` VALUES(5, 19);
INSERT INTO `cto_download_trans` VALUES(5, 20);
INSERT INTO `cto_download_trans` VALUES(5, 21);
INSERT INTO `cto_download_trans` VALUES(5, 22);
INSERT INTO `cto_download_trans` VALUES(5, 23);
INSERT INTO `cto_download_trans` VALUES(5, 24);
INSERT INTO `cto_download_trans` VALUES(5, 25);
INSERT INTO `cto_download_trans` VALUES(5, 26);
INSERT INTO `cto_download_trans` VALUES(5, 27);
INSERT INTO `cto_download_trans` VALUES(5, 28);
INSERT INTO `cto_download_trans` VALUES(5, 29);
INSERT INTO `cto_download_trans` VALUES(5, 30);
INSERT INTO `cto_download_trans` VALUES(5, 31);
INSERT INTO `cto_download_trans` VALUES(5, 32);
INSERT INTO `cto_download_trans` VALUES(5, 33);
INSERT INTO `cto_download_trans` VALUES(5, 34);
INSERT INTO `cto_download_trans` VALUES(5, 35);
INSERT INTO `cto_download_trans` VALUES(5, 36);
INSERT INTO `cto_download_trans` VALUES(5, 37);
INSERT INTO `cto_download_trans` VALUES(5, 38);
INSERT INTO `cto_download_trans` VALUES(5, 39);
INSERT INTO `cto_download_trans` VALUES(5, 40);
INSERT INTO `cto_download_trans` VALUES(5, 41);
INSERT INTO `cto_download_trans` VALUES(5, 42);
INSERT INTO `cto_download_trans` VALUES(5, 43);
INSERT INTO `cto_download_trans` VALUES(5, 44);
INSERT INTO `cto_download_trans` VALUES(5, 45);
INSERT INTO `cto_download_trans` VALUES(5, 46);
INSERT INTO `cto_download_trans` VALUES(5, 47);
INSERT INTO `cto_download_trans` VALUES(5, 48);
INSERT INTO `cto_download_trans` VALUES(5, 49);
INSERT INTO `cto_download_trans` VALUES(5, 50);
INSERT INTO `cto_download_trans` VALUES(5, 51);
INSERT INTO `cto_download_trans` VALUES(5, 52);
INSERT INTO `cto_download_trans` VALUES(5, 53);
INSERT INTO `cto_download_trans` VALUES(5, 54);
INSERT INTO `cto_download_trans` VALUES(5, 55);
INSERT INTO `cto_download_trans` VALUES(5, 56);
INSERT INTO `cto_download_trans` VALUES(5, 57);
INSERT INTO `cto_download_trans` VALUES(5, 58);
INSERT INTO `cto_download_trans` VALUES(5, 59);
INSERT INTO `cto_download_trans` VALUES(5, 60);
INSERT INTO `cto_download_trans` VALUES(5, 61);
INSERT INTO `cto_download_trans` VALUES(5, 62);
INSERT INTO `cto_download_trans` VALUES(5, 63);
INSERT INTO `cto_download_trans` VALUES(5, 64);
INSERT INTO `cto_download_trans` VALUES(5, 65);
INSERT INTO `cto_download_trans` VALUES(5, 66);
INSERT INTO `cto_download_trans` VALUES(5, 67);
INSERT INTO `cto_download_trans` VALUES(5, 68);
INSERT INTO `cto_download_trans` VALUES(5, 69);
INSERT INTO `cto_download_trans` VALUES(5, 70);
INSERT INTO `cto_download_trans` VALUES(5, 71);
INSERT INTO `cto_download_trans` VALUES(5, 72);
INSERT INTO `cto_download_trans` VALUES(5, 73);
INSERT INTO `cto_download_trans` VALUES(5, 74);
INSERT INTO `cto_download_trans` VALUES(5, 75);
INSERT INTO `cto_download_trans` VALUES(5, 76);
INSERT INTO `cto_download_trans` VALUES(5, 77);
INSERT INTO `cto_download_trans` VALUES(5, 78);
INSERT INTO `cto_download_trans` VALUES(5, 79);
INSERT INTO `cto_download_trans` VALUES(5, 80);
INSERT INTO `cto_download_trans` VALUES(5, 81);
INSERT INTO `cto_download_trans` VALUES(5, 82);
INSERT INTO `cto_download_trans` VALUES(5, 83);
INSERT INTO `cto_download_trans` VALUES(5, 84);
INSERT INTO `cto_download_trans` VALUES(5, 85);
INSERT INTO `cto_download_trans` VALUES(5, 86);
INSERT INTO `cto_download_trans` VALUES(5, 87);
INSERT INTO `cto_download_trans` VALUES(5, 88);
INSERT INTO `cto_download_trans` VALUES(5, 89);
INSERT INTO `cto_download_trans` VALUES(5, 90);
INSERT INTO `cto_download_trans` VALUES(5, 91);
INSERT INTO `cto_download_trans` VALUES(5, 92);
INSERT INTO `cto_download_trans` VALUES(5, 93);
INSERT INTO `cto_download_trans` VALUES(5, 94);
INSERT INTO `cto_download_trans` VALUES(5, 95);
INSERT INTO `cto_download_trans` VALUES(5, 96);
INSERT INTO `cto_download_trans` VALUES(5, 97);
INSERT INTO `cto_download_trans` VALUES(5, 98);
INSERT INTO `cto_download_trans` VALUES(5, 99);
INSERT INTO `cto_download_trans` VALUES(5, 100);
INSERT INTO `cto_download_trans` VALUES(5, 101);
INSERT INTO `cto_download_trans` VALUES(5, 102);
INSERT INTO `cto_download_trans` VALUES(5, 103);
INSERT INTO `cto_download_trans` VALUES(5, 104);
INSERT INTO `cto_download_trans` VALUES(5, 105);
INSERT INTO `cto_download_trans` VALUES(5, 106);
INSERT INTO `cto_download_trans` VALUES(5, 107);
INSERT INTO `cto_download_trans` VALUES(5, 108);
INSERT INTO `cto_download_trans` VALUES(5, 109);
INSERT INTO `cto_download_trans` VALUES(5, 110);
INSERT INTO `cto_download_trans` VALUES(5, 111);
INSERT INTO `cto_download_trans` VALUES(5, 112);
INSERT INTO `cto_download_trans` VALUES(5, 113);
INSERT INTO `cto_download_trans` VALUES(5, 114);
INSERT INTO `cto_download_trans` VALUES(5, 115);
INSERT INTO `cto_download_trans` VALUES(5, 116);
INSERT INTO `cto_download_trans` VALUES(5, 117);
INSERT INTO `cto_download_trans` VALUES(5, 118);
INSERT INTO `cto_download_trans` VALUES(5, 119);
INSERT INTO `cto_download_trans` VALUES(5, 120);
INSERT INTO `cto_download_trans` VALUES(5, 121);
INSERT INTO `cto_download_trans` VALUES(5, 122);
INSERT INTO `cto_download_trans` VALUES(6, 1);
INSERT INTO `cto_download_trans` VALUES(6, 2);
INSERT INTO `cto_download_trans` VALUES(6, 3);
INSERT INTO `cto_download_trans` VALUES(6, 4);
INSERT INTO `cto_download_trans` VALUES(6, 5);
INSERT INTO `cto_download_trans` VALUES(6, 6);
INSERT INTO `cto_download_trans` VALUES(6, 7);
INSERT INTO `cto_download_trans` VALUES(6, 8);
INSERT INTO `cto_download_trans` VALUES(6, 9);
INSERT INTO `cto_download_trans` VALUES(6, 10);
INSERT INTO `cto_download_trans` VALUES(6, 11);
INSERT INTO `cto_download_trans` VALUES(6, 12);
INSERT INTO `cto_download_trans` VALUES(6, 13);
INSERT INTO `cto_download_trans` VALUES(6, 14);
INSERT INTO `cto_download_trans` VALUES(6, 15);
INSERT INTO `cto_download_trans` VALUES(6, 16);
INSERT INTO `cto_download_trans` VALUES(6, 17);
INSERT INTO `cto_download_trans` VALUES(6, 18);
INSERT INTO `cto_download_trans` VALUES(6, 19);
INSERT INTO `cto_download_trans` VALUES(6, 20);
INSERT INTO `cto_download_trans` VALUES(6, 21);
INSERT INTO `cto_download_trans` VALUES(6, 22);
INSERT INTO `cto_download_trans` VALUES(6, 23);
INSERT INTO `cto_download_trans` VALUES(6, 24);
INSERT INTO `cto_download_trans` VALUES(6, 25);
INSERT INTO `cto_download_trans` VALUES(6, 26);
INSERT INTO `cto_download_trans` VALUES(6, 27);
INSERT INTO `cto_download_trans` VALUES(6, 28);
INSERT INTO `cto_download_trans` VALUES(6, 29);
INSERT INTO `cto_download_trans` VALUES(6, 30);
INSERT INTO `cto_download_trans` VALUES(6, 31);
INSERT INTO `cto_download_trans` VALUES(6, 32);
INSERT INTO `cto_download_trans` VALUES(6, 33);
INSERT INTO `cto_download_trans` VALUES(6, 34);
INSERT INTO `cto_download_trans` VALUES(6, 35);
INSERT INTO `cto_download_trans` VALUES(6, 36);
INSERT INTO `cto_download_trans` VALUES(6, 37);
INSERT INTO `cto_download_trans` VALUES(6, 38);
INSERT INTO `cto_download_trans` VALUES(6, 39);
INSERT INTO `cto_download_trans` VALUES(6, 40);
INSERT INTO `cto_download_trans` VALUES(6, 41);
INSERT INTO `cto_download_trans` VALUES(6, 42);
INSERT INTO `cto_download_trans` VALUES(6, 43);
INSERT INTO `cto_download_trans` VALUES(6, 44);
INSERT INTO `cto_download_trans` VALUES(6, 45);
INSERT INTO `cto_download_trans` VALUES(6, 46);
INSERT INTO `cto_download_trans` VALUES(6, 47);
INSERT INTO `cto_download_trans` VALUES(6, 48);
INSERT INTO `cto_download_trans` VALUES(6, 49);
INSERT INTO `cto_download_trans` VALUES(6, 50);
INSERT INTO `cto_download_trans` VALUES(6, 51);
INSERT INTO `cto_download_trans` VALUES(6, 52);
INSERT INTO `cto_download_trans` VALUES(6, 53);
INSERT INTO `cto_download_trans` VALUES(6, 54);
INSERT INTO `cto_download_trans` VALUES(6, 55);
INSERT INTO `cto_download_trans` VALUES(6, 56);
INSERT INTO `cto_download_trans` VALUES(6, 57);
INSERT INTO `cto_download_trans` VALUES(6, 58);
INSERT INTO `cto_download_trans` VALUES(6, 59);
INSERT INTO `cto_download_trans` VALUES(6, 60);
INSERT INTO `cto_download_trans` VALUES(6, 61);
INSERT INTO `cto_download_trans` VALUES(6, 62);
INSERT INTO `cto_download_trans` VALUES(6, 63);
INSERT INTO `cto_download_trans` VALUES(6, 64);
INSERT INTO `cto_download_trans` VALUES(6, 65);
INSERT INTO `cto_download_trans` VALUES(6, 66);
INSERT INTO `cto_download_trans` VALUES(6, 67);
INSERT INTO `cto_download_trans` VALUES(6, 68);
INSERT INTO `cto_download_trans` VALUES(6, 69);
INSERT INTO `cto_download_trans` VALUES(6, 70);
INSERT INTO `cto_download_trans` VALUES(6, 71);
INSERT INTO `cto_download_trans` VALUES(6, 72);
INSERT INTO `cto_download_trans` VALUES(6, 73);
INSERT INTO `cto_download_trans` VALUES(6, 74);
INSERT INTO `cto_download_trans` VALUES(6, 75);
INSERT INTO `cto_download_trans` VALUES(6, 76);
INSERT INTO `cto_download_trans` VALUES(6, 77);
INSERT INTO `cto_download_trans` VALUES(6, 78);
INSERT INTO `cto_download_trans` VALUES(6, 79);
INSERT INTO `cto_download_trans` VALUES(6, 80);
INSERT INTO `cto_download_trans` VALUES(6, 81);
INSERT INTO `cto_download_trans` VALUES(6, 82);
INSERT INTO `cto_download_trans` VALUES(6, 83);
INSERT INTO `cto_download_trans` VALUES(6, 84);
INSERT INTO `cto_download_trans` VALUES(6, 85);
INSERT INTO `cto_download_trans` VALUES(6, 86);
INSERT INTO `cto_download_trans` VALUES(6, 87);
INSERT INTO `cto_download_trans` VALUES(6, 88);
INSERT INTO `cto_download_trans` VALUES(6, 89);
INSERT INTO `cto_download_trans` VALUES(6, 90);
INSERT INTO `cto_download_trans` VALUES(6, 91);
INSERT INTO `cto_download_trans` VALUES(6, 92);
INSERT INTO `cto_download_trans` VALUES(6, 93);
INSERT INTO `cto_download_trans` VALUES(6, 94);
INSERT INTO `cto_download_trans` VALUES(6, 95);
INSERT INTO `cto_download_trans` VALUES(6, 96);
INSERT INTO `cto_download_trans` VALUES(6, 97);
INSERT INTO `cto_download_trans` VALUES(6, 98);
INSERT INTO `cto_download_trans` VALUES(6, 99);
INSERT INTO `cto_download_trans` VALUES(6, 100);
INSERT INTO `cto_download_trans` VALUES(6, 101);
INSERT INTO `cto_download_trans` VALUES(6, 102);
INSERT INTO `cto_download_trans` VALUES(6, 103);
INSERT INTO `cto_download_trans` VALUES(6, 104);
INSERT INTO `cto_download_trans` VALUES(6, 105);
INSERT INTO `cto_download_trans` VALUES(6, 106);
INSERT INTO `cto_download_trans` VALUES(6, 107);
INSERT INTO `cto_download_trans` VALUES(6, 108);
INSERT INTO `cto_download_trans` VALUES(6, 109);
INSERT INTO `cto_download_trans` VALUES(6, 110);
INSERT INTO `cto_download_trans` VALUES(6, 111);
INSERT INTO `cto_download_trans` VALUES(6, 112);
INSERT INTO `cto_download_trans` VALUES(6, 113);
INSERT INTO `cto_download_trans` VALUES(6, 114);
INSERT INTO `cto_download_trans` VALUES(6, 115);
INSERT INTO `cto_download_trans` VALUES(6, 116);
INSERT INTO `cto_download_trans` VALUES(6, 117);
INSERT INTO `cto_download_trans` VALUES(6, 118);
INSERT INTO `cto_download_trans` VALUES(6, 119);
INSERT INTO `cto_download_trans` VALUES(6, 120);
INSERT INTO `cto_download_trans` VALUES(6, 121);
INSERT INTO `cto_download_trans` VALUES(6, 122);
INSERT INTO `cto_download_trans` VALUES(7, 1);
INSERT INTO `cto_download_trans` VALUES(7, 3);
INSERT INTO `cto_download_trans` VALUES(7, 10);
INSERT INTO `cto_download_trans` VALUES(7, 11);
INSERT INTO `cto_download_trans` VALUES(7, 12);
INSERT INTO `cto_download_trans` VALUES(7, 13);
INSERT INTO `cto_download_trans` VALUES(7, 14);
INSERT INTO `cto_download_trans` VALUES(7, 15);
INSERT INTO `cto_download_trans` VALUES(7, 16);
INSERT INTO `cto_download_trans` VALUES(7, 17);
INSERT INTO `cto_download_trans` VALUES(7, 18);
INSERT INTO `cto_download_trans` VALUES(7, 24);
INSERT INTO `cto_download_trans` VALUES(7, 25);
INSERT INTO `cto_download_trans` VALUES(7, 26);
INSERT INTO `cto_download_trans` VALUES(7, 27);
INSERT INTO `cto_download_trans` VALUES(7, 28);
INSERT INTO `cto_download_trans` VALUES(7, 29);
INSERT INTO `cto_download_trans` VALUES(7, 30);
INSERT INTO `cto_download_trans` VALUES(7, 34);
INSERT INTO `cto_download_trans` VALUES(7, 35);
INSERT INTO `cto_download_trans` VALUES(7, 46);
INSERT INTO `cto_download_trans` VALUES(7, 47);
INSERT INTO `cto_download_trans` VALUES(7, 48);
INSERT INTO `cto_download_trans` VALUES(7, 51);
INSERT INTO `cto_download_trans` VALUES(7, 52);
INSERT INTO `cto_download_trans` VALUES(7, 56);
INSERT INTO `cto_download_trans` VALUES(7, 57);
INSERT INTO `cto_download_trans` VALUES(7, 58);
INSERT INTO `cto_download_trans` VALUES(7, 59);
INSERT INTO `cto_download_trans` VALUES(7, 60);
INSERT INTO `cto_download_trans` VALUES(7, 61);
INSERT INTO `cto_download_trans` VALUES(7, 73);
INSERT INTO `cto_download_trans` VALUES(7, 74);
INSERT INTO `cto_download_trans` VALUES(7, 75);
INSERT INTO `cto_download_trans` VALUES(7, 76);
INSERT INTO `cto_download_trans` VALUES(7, 77);
INSERT INTO `cto_download_trans` VALUES(7, 80);
INSERT INTO `cto_download_trans` VALUES(7, 81);
INSERT INTO `cto_download_trans` VALUES(7, 82);
INSERT INTO `cto_download_trans` VALUES(7, 85);
INSERT INTO `cto_download_trans` VALUES(7, 86);
INSERT INTO `cto_download_trans` VALUES(7, 91);
INSERT INTO `cto_download_trans` VALUES(7, 92);
INSERT INTO `cto_download_trans` VALUES(7, 95);
INSERT INTO `cto_download_trans` VALUES(7, 100);
INSERT INTO `cto_download_trans` VALUES(7, 101);
INSERT INTO `cto_download_trans` VALUES(7, 102);
INSERT INTO `cto_download_trans` VALUES(7, 103);
INSERT INTO `cto_download_trans` VALUES(7, 104);
INSERT INTO `cto_download_trans` VALUES(7, 105);
INSERT INTO `cto_download_trans` VALUES(7, 106);
INSERT INTO `cto_download_trans` VALUES(7, 107);
INSERT INTO `cto_download_trans` VALUES(7, 108);
INSERT INTO `cto_download_trans` VALUES(7, 115);
INSERT INTO `cto_download_trans` VALUES(7, 116);
INSERT INTO `cto_download_trans` VALUES(7, 117);
INSERT INTO `cto_download_trans` VALUES(7, 118);
INSERT INTO `cto_download_trans` VALUES(7, 121);
INSERT INTO `cto_download_trans` VALUES(8, 1);
INSERT INTO `cto_download_trans` VALUES(8, 2);
INSERT INTO `cto_download_trans` VALUES(8, 3);
INSERT INTO `cto_download_trans` VALUES(8, 4);
INSERT INTO `cto_download_trans` VALUES(8, 5);
INSERT INTO `cto_download_trans` VALUES(8, 6);
INSERT INTO `cto_download_trans` VALUES(8, 7);
INSERT INTO `cto_download_trans` VALUES(8, 8);
INSERT INTO `cto_download_trans` VALUES(8, 9);
INSERT INTO `cto_download_trans` VALUES(8, 10);
INSERT INTO `cto_download_trans` VALUES(8, 11);
INSERT INTO `cto_download_trans` VALUES(8, 12);
INSERT INTO `cto_download_trans` VALUES(8, 13);
INSERT INTO `cto_download_trans` VALUES(8, 14);
INSERT INTO `cto_download_trans` VALUES(8, 15);
INSERT INTO `cto_download_trans` VALUES(8, 16);
INSERT INTO `cto_download_trans` VALUES(8, 17);
INSERT INTO `cto_download_trans` VALUES(8, 18);
INSERT INTO `cto_download_trans` VALUES(8, 19);
INSERT INTO `cto_download_trans` VALUES(8, 20);
INSERT INTO `cto_download_trans` VALUES(8, 21);
INSERT INTO `cto_download_trans` VALUES(8, 22);
INSERT INTO `cto_download_trans` VALUES(8, 23);
INSERT INTO `cto_download_trans` VALUES(8, 24);
INSERT INTO `cto_download_trans` VALUES(8, 25);
INSERT INTO `cto_download_trans` VALUES(8, 26);
INSERT INTO `cto_download_trans` VALUES(8, 27);
INSERT INTO `cto_download_trans` VALUES(8, 28);
INSERT INTO `cto_download_trans` VALUES(8, 29);
INSERT INTO `cto_download_trans` VALUES(8, 30);
INSERT INTO `cto_download_trans` VALUES(8, 31);
INSERT INTO `cto_download_trans` VALUES(8, 32);
INSERT INTO `cto_download_trans` VALUES(8, 33);
INSERT INTO `cto_download_trans` VALUES(8, 34);
INSERT INTO `cto_download_trans` VALUES(8, 35);
INSERT INTO `cto_download_trans` VALUES(8, 36);
INSERT INTO `cto_download_trans` VALUES(8, 37);
INSERT INTO `cto_download_trans` VALUES(8, 38);
INSERT INTO `cto_download_trans` VALUES(8, 39);
INSERT INTO `cto_download_trans` VALUES(8, 40);
INSERT INTO `cto_download_trans` VALUES(8, 41);
INSERT INTO `cto_download_trans` VALUES(8, 42);
INSERT INTO `cto_download_trans` VALUES(8, 43);
INSERT INTO `cto_download_trans` VALUES(8, 44);
INSERT INTO `cto_download_trans` VALUES(8, 45);
INSERT INTO `cto_download_trans` VALUES(8, 46);
INSERT INTO `cto_download_trans` VALUES(8, 47);
INSERT INTO `cto_download_trans` VALUES(8, 48);
INSERT INTO `cto_download_trans` VALUES(8, 49);
INSERT INTO `cto_download_trans` VALUES(8, 50);
INSERT INTO `cto_download_trans` VALUES(8, 51);
INSERT INTO `cto_download_trans` VALUES(8, 52);
INSERT INTO `cto_download_trans` VALUES(8, 53);
INSERT INTO `cto_download_trans` VALUES(8, 54);
INSERT INTO `cto_download_trans` VALUES(8, 55);
INSERT INTO `cto_download_trans` VALUES(8, 56);
INSERT INTO `cto_download_trans` VALUES(8, 57);
INSERT INTO `cto_download_trans` VALUES(8, 58);
INSERT INTO `cto_download_trans` VALUES(8, 59);
INSERT INTO `cto_download_trans` VALUES(8, 60);
INSERT INTO `cto_download_trans` VALUES(8, 61);
INSERT INTO `cto_download_trans` VALUES(8, 62);
INSERT INTO `cto_download_trans` VALUES(8, 63);
INSERT INTO `cto_download_trans` VALUES(8, 64);
INSERT INTO `cto_download_trans` VALUES(8, 65);
INSERT INTO `cto_download_trans` VALUES(8, 66);
INSERT INTO `cto_download_trans` VALUES(8, 67);
INSERT INTO `cto_download_trans` VALUES(8, 68);
INSERT INTO `cto_download_trans` VALUES(8, 69);
INSERT INTO `cto_download_trans` VALUES(8, 70);
INSERT INTO `cto_download_trans` VALUES(8, 71);
INSERT INTO `cto_download_trans` VALUES(8, 72);
INSERT INTO `cto_download_trans` VALUES(8, 73);
INSERT INTO `cto_download_trans` VALUES(8, 74);
INSERT INTO `cto_download_trans` VALUES(8, 75);
INSERT INTO `cto_download_trans` VALUES(8, 76);
INSERT INTO `cto_download_trans` VALUES(8, 77);
INSERT INTO `cto_download_trans` VALUES(8, 78);
INSERT INTO `cto_download_trans` VALUES(8, 79);
INSERT INTO `cto_download_trans` VALUES(8, 80);
INSERT INTO `cto_download_trans` VALUES(8, 81);
INSERT INTO `cto_download_trans` VALUES(8, 82);
INSERT INTO `cto_download_trans` VALUES(8, 83);
INSERT INTO `cto_download_trans` VALUES(8, 84);
INSERT INTO `cto_download_trans` VALUES(8, 85);
INSERT INTO `cto_download_trans` VALUES(8, 86);
INSERT INTO `cto_download_trans` VALUES(8, 87);
INSERT INTO `cto_download_trans` VALUES(8, 88);
INSERT INTO `cto_download_trans` VALUES(8, 89);
INSERT INTO `cto_download_trans` VALUES(8, 90);
INSERT INTO `cto_download_trans` VALUES(8, 91);
INSERT INTO `cto_download_trans` VALUES(8, 92);
INSERT INTO `cto_download_trans` VALUES(8, 93);
INSERT INTO `cto_download_trans` VALUES(8, 94);
INSERT INTO `cto_download_trans` VALUES(8, 95);
INSERT INTO `cto_download_trans` VALUES(8, 96);
INSERT INTO `cto_download_trans` VALUES(8, 97);
INSERT INTO `cto_download_trans` VALUES(8, 98);
INSERT INTO `cto_download_trans` VALUES(8, 99);
INSERT INTO `cto_download_trans` VALUES(8, 100);
INSERT INTO `cto_download_trans` VALUES(8, 101);
INSERT INTO `cto_download_trans` VALUES(8, 102);
INSERT INTO `cto_download_trans` VALUES(8, 103);
INSERT INTO `cto_download_trans` VALUES(8, 104);
INSERT INTO `cto_download_trans` VALUES(8, 105);
INSERT INTO `cto_download_trans` VALUES(8, 106);
INSERT INTO `cto_download_trans` VALUES(8, 107);
INSERT INTO `cto_download_trans` VALUES(8, 108);
INSERT INTO `cto_download_trans` VALUES(8, 109);
INSERT INTO `cto_download_trans` VALUES(8, 110);
INSERT INTO `cto_download_trans` VALUES(8, 111);
INSERT INTO `cto_download_trans` VALUES(8, 112);
INSERT INTO `cto_download_trans` VALUES(8, 113);
INSERT INTO `cto_download_trans` VALUES(8, 114);
INSERT INTO `cto_download_trans` VALUES(8, 115);
INSERT INTO `cto_download_trans` VALUES(8, 116);
INSERT INTO `cto_download_trans` VALUES(8, 117);
INSERT INTO `cto_download_trans` VALUES(8, 118);
INSERT INTO `cto_download_trans` VALUES(8, 119);
INSERT INTO `cto_download_trans` VALUES(8, 120);
INSERT INTO `cto_download_trans` VALUES(8, 121);
INSERT INTO `cto_download_trans` VALUES(8, 122);
INSERT INTO `cto_download_trans` VALUES(9, 2);
INSERT INTO `cto_download_trans` VALUES(9, 4);
INSERT INTO `cto_download_trans` VALUES(9, 5);
INSERT INTO `cto_download_trans` VALUES(9, 6);
INSERT INTO `cto_download_trans` VALUES(9, 7);
INSERT INTO `cto_download_trans` VALUES(9, 8);
INSERT INTO `cto_download_trans` VALUES(9, 9);
INSERT INTO `cto_download_trans` VALUES(9, 23);
INSERT INTO `cto_download_trans` VALUES(9, 36);
INSERT INTO `cto_download_trans` VALUES(9, 37);
INSERT INTO `cto_download_trans` VALUES(9, 38);
INSERT INTO `cto_download_trans` VALUES(9, 39);
INSERT INTO `cto_download_trans` VALUES(9, 40);
INSERT INTO `cto_download_trans` VALUES(9, 41);
INSERT INTO `cto_download_trans` VALUES(9, 42);
INSERT INTO `cto_download_trans` VALUES(9, 43);
INSERT INTO `cto_download_trans` VALUES(9, 44);
INSERT INTO `cto_download_trans` VALUES(9, 45);
INSERT INTO `cto_download_trans` VALUES(9, 54);
INSERT INTO `cto_download_trans` VALUES(9, 55);
INSERT INTO `cto_download_trans` VALUES(9, 64);
INSERT INTO `cto_download_trans` VALUES(9, 65);
INSERT INTO `cto_download_trans` VALUES(9, 66);
INSERT INTO `cto_download_trans` VALUES(9, 67);
INSERT INTO `cto_download_trans` VALUES(9, 69);
INSERT INTO `cto_download_trans` VALUES(9, 70);
INSERT INTO `cto_download_trans` VALUES(9, 71);
INSERT INTO `cto_download_trans` VALUES(9, 72);
INSERT INTO `cto_download_trans` VALUES(9, 79);
INSERT INTO `cto_download_trans` VALUES(9, 83);
INSERT INTO `cto_download_trans` VALUES(9, 84);
INSERT INTO `cto_download_trans` VALUES(9, 87);
INSERT INTO `cto_download_trans` VALUES(9, 88);
INSERT INTO `cto_download_trans` VALUES(9, 89);
INSERT INTO `cto_download_trans` VALUES(9, 90);
INSERT INTO `cto_download_trans` VALUES(9, 94);
INSERT INTO `cto_download_trans` VALUES(9, 96);
INSERT INTO `cto_download_trans` VALUES(9, 97);
INSERT INTO `cto_download_trans` VALUES(9, 98);
INSERT INTO `cto_download_trans` VALUES(9, 99);
INSERT INTO `cto_download_trans` VALUES(9, 114);
INSERT INTO `cto_download_trans` VALUES(9, 119);
INSERT INTO `cto_download_trans` VALUES(9, 120);
INSERT INTO `cto_download_trans` VALUES(10, 2);
INSERT INTO `cto_download_trans` VALUES(10, 4);
INSERT INTO `cto_download_trans` VALUES(10, 5);
INSERT INTO `cto_download_trans` VALUES(10, 6);
INSERT INTO `cto_download_trans` VALUES(10, 7);
INSERT INTO `cto_download_trans` VALUES(10, 8);
INSERT INTO `cto_download_trans` VALUES(10, 9);
INSERT INTO `cto_download_trans` VALUES(10, 23);
INSERT INTO `cto_download_trans` VALUES(10, 36);
INSERT INTO `cto_download_trans` VALUES(10, 37);
INSERT INTO `cto_download_trans` VALUES(10, 38);
INSERT INTO `cto_download_trans` VALUES(10, 39);
INSERT INTO `cto_download_trans` VALUES(10, 40);
INSERT INTO `cto_download_trans` VALUES(10, 41);
INSERT INTO `cto_download_trans` VALUES(10, 42);
INSERT INTO `cto_download_trans` VALUES(10, 43);
INSERT INTO `cto_download_trans` VALUES(10, 44);
INSERT INTO `cto_download_trans` VALUES(10, 45);
INSERT INTO `cto_download_trans` VALUES(10, 54);
INSERT INTO `cto_download_trans` VALUES(10, 55);
INSERT INTO `cto_download_trans` VALUES(10, 64);
INSERT INTO `cto_download_trans` VALUES(10, 65);
INSERT INTO `cto_download_trans` VALUES(10, 66);
INSERT INTO `cto_download_trans` VALUES(10, 67);
INSERT INTO `cto_download_trans` VALUES(10, 69);
INSERT INTO `cto_download_trans` VALUES(10, 70);
INSERT INTO `cto_download_trans` VALUES(10, 71);
INSERT INTO `cto_download_trans` VALUES(10, 72);
INSERT INTO `cto_download_trans` VALUES(10, 79);
INSERT INTO `cto_download_trans` VALUES(10, 83);
INSERT INTO `cto_download_trans` VALUES(10, 84);
INSERT INTO `cto_download_trans` VALUES(10, 87);
INSERT INTO `cto_download_trans` VALUES(10, 88);
INSERT INTO `cto_download_trans` VALUES(10, 89);
INSERT INTO `cto_download_trans` VALUES(10, 90);
INSERT INTO `cto_download_trans` VALUES(10, 94);
INSERT INTO `cto_download_trans` VALUES(10, 96);
INSERT INTO `cto_download_trans` VALUES(10, 97);
INSERT INTO `cto_download_trans` VALUES(10, 98);
INSERT INTO `cto_download_trans` VALUES(10, 99);
INSERT INTO `cto_download_trans` VALUES(10, 114);
INSERT INTO `cto_download_trans` VALUES(10, 119);
INSERT INTO `cto_download_trans` VALUES(10, 120);
INSERT INTO `cto_download_trans` VALUES(11, 1);
INSERT INTO `cto_download_trans` VALUES(11, 2);
INSERT INTO `cto_download_trans` VALUES(11, 3);
INSERT INTO `cto_download_trans` VALUES(11, 4);
INSERT INTO `cto_download_trans` VALUES(11, 5);
INSERT INTO `cto_download_trans` VALUES(11, 6);
INSERT INTO `cto_download_trans` VALUES(11, 7);
INSERT INTO `cto_download_trans` VALUES(11, 8);
INSERT INTO `cto_download_trans` VALUES(11, 9);
INSERT INTO `cto_download_trans` VALUES(11, 10);
INSERT INTO `cto_download_trans` VALUES(11, 11);
INSERT INTO `cto_download_trans` VALUES(11, 12);
INSERT INTO `cto_download_trans` VALUES(11, 13);
INSERT INTO `cto_download_trans` VALUES(11, 14);
INSERT INTO `cto_download_trans` VALUES(11, 15);
INSERT INTO `cto_download_trans` VALUES(11, 16);
INSERT INTO `cto_download_trans` VALUES(11, 17);
INSERT INTO `cto_download_trans` VALUES(11, 18);
INSERT INTO `cto_download_trans` VALUES(11, 19);
INSERT INTO `cto_download_trans` VALUES(11, 20);
INSERT INTO `cto_download_trans` VALUES(11, 21);
INSERT INTO `cto_download_trans` VALUES(11, 22);
INSERT INTO `cto_download_trans` VALUES(11, 23);
INSERT INTO `cto_download_trans` VALUES(11, 24);
INSERT INTO `cto_download_trans` VALUES(11, 25);
INSERT INTO `cto_download_trans` VALUES(11, 26);
INSERT INTO `cto_download_trans` VALUES(11, 27);
INSERT INTO `cto_download_trans` VALUES(11, 28);
INSERT INTO `cto_download_trans` VALUES(11, 29);
INSERT INTO `cto_download_trans` VALUES(11, 30);
INSERT INTO `cto_download_trans` VALUES(11, 31);
INSERT INTO `cto_download_trans` VALUES(11, 32);
INSERT INTO `cto_download_trans` VALUES(11, 33);
INSERT INTO `cto_download_trans` VALUES(11, 34);
INSERT INTO `cto_download_trans` VALUES(11, 35);
INSERT INTO `cto_download_trans` VALUES(11, 36);
INSERT INTO `cto_download_trans` VALUES(11, 37);
INSERT INTO `cto_download_trans` VALUES(11, 38);
INSERT INTO `cto_download_trans` VALUES(11, 39);
INSERT INTO `cto_download_trans` VALUES(11, 40);
INSERT INTO `cto_download_trans` VALUES(11, 41);
INSERT INTO `cto_download_trans` VALUES(11, 42);
INSERT INTO `cto_download_trans` VALUES(11, 43);
INSERT INTO `cto_download_trans` VALUES(11, 44);
INSERT INTO `cto_download_trans` VALUES(11, 45);
INSERT INTO `cto_download_trans` VALUES(11, 46);
INSERT INTO `cto_download_trans` VALUES(11, 47);
INSERT INTO `cto_download_trans` VALUES(11, 48);
INSERT INTO `cto_download_trans` VALUES(11, 49);
INSERT INTO `cto_download_trans` VALUES(11, 50);
INSERT INTO `cto_download_trans` VALUES(11, 51);
INSERT INTO `cto_download_trans` VALUES(11, 52);
INSERT INTO `cto_download_trans` VALUES(11, 53);
INSERT INTO `cto_download_trans` VALUES(11, 54);
INSERT INTO `cto_download_trans` VALUES(11, 55);
INSERT INTO `cto_download_trans` VALUES(11, 56);
INSERT INTO `cto_download_trans` VALUES(11, 57);
INSERT INTO `cto_download_trans` VALUES(11, 58);
INSERT INTO `cto_download_trans` VALUES(11, 59);
INSERT INTO `cto_download_trans` VALUES(11, 60);
INSERT INTO `cto_download_trans` VALUES(11, 61);
INSERT INTO `cto_download_trans` VALUES(11, 62);
INSERT INTO `cto_download_trans` VALUES(11, 63);
INSERT INTO `cto_download_trans` VALUES(11, 64);
INSERT INTO `cto_download_trans` VALUES(11, 65);
INSERT INTO `cto_download_trans` VALUES(11, 66);
INSERT INTO `cto_download_trans` VALUES(11, 67);
INSERT INTO `cto_download_trans` VALUES(11, 68);
INSERT INTO `cto_download_trans` VALUES(11, 69);
INSERT INTO `cto_download_trans` VALUES(11, 70);
INSERT INTO `cto_download_trans` VALUES(11, 71);
INSERT INTO `cto_download_trans` VALUES(11, 72);
INSERT INTO `cto_download_trans` VALUES(11, 73);
INSERT INTO `cto_download_trans` VALUES(11, 74);
INSERT INTO `cto_download_trans` VALUES(11, 75);
INSERT INTO `cto_download_trans` VALUES(11, 76);
INSERT INTO `cto_download_trans` VALUES(11, 77);
INSERT INTO `cto_download_trans` VALUES(11, 78);
INSERT INTO `cto_download_trans` VALUES(11, 79);
INSERT INTO `cto_download_trans` VALUES(11, 80);
INSERT INTO `cto_download_trans` VALUES(11, 81);
INSERT INTO `cto_download_trans` VALUES(11, 82);
INSERT INTO `cto_download_trans` VALUES(11, 83);
INSERT INTO `cto_download_trans` VALUES(11, 84);
INSERT INTO `cto_download_trans` VALUES(11, 85);
INSERT INTO `cto_download_trans` VALUES(11, 86);
INSERT INTO `cto_download_trans` VALUES(11, 87);
INSERT INTO `cto_download_trans` VALUES(11, 88);
INSERT INTO `cto_download_trans` VALUES(11, 89);
INSERT INTO `cto_download_trans` VALUES(11, 90);
INSERT INTO `cto_download_trans` VALUES(11, 91);
INSERT INTO `cto_download_trans` VALUES(11, 92);
INSERT INTO `cto_download_trans` VALUES(11, 93);
INSERT INTO `cto_download_trans` VALUES(11, 94);
INSERT INTO `cto_download_trans` VALUES(11, 95);
INSERT INTO `cto_download_trans` VALUES(11, 96);
INSERT INTO `cto_download_trans` VALUES(11, 97);
INSERT INTO `cto_download_trans` VALUES(11, 98);
INSERT INTO `cto_download_trans` VALUES(11, 99);
INSERT INTO `cto_download_trans` VALUES(11, 100);
INSERT INTO `cto_download_trans` VALUES(11, 101);
INSERT INTO `cto_download_trans` VALUES(11, 102);
INSERT INTO `cto_download_trans` VALUES(11, 103);
INSERT INTO `cto_download_trans` VALUES(11, 104);
INSERT INTO `cto_download_trans` VALUES(11, 105);
INSERT INTO `cto_download_trans` VALUES(11, 106);
INSERT INTO `cto_download_trans` VALUES(11, 107);
INSERT INTO `cto_download_trans` VALUES(11, 108);
INSERT INTO `cto_download_trans` VALUES(11, 109);
INSERT INTO `cto_download_trans` VALUES(11, 110);
INSERT INTO `cto_download_trans` VALUES(11, 111);
INSERT INTO `cto_download_trans` VALUES(11, 112);
INSERT INTO `cto_download_trans` VALUES(11, 113);
INSERT INTO `cto_download_trans` VALUES(11, 114);
INSERT INTO `cto_download_trans` VALUES(11, 115);
INSERT INTO `cto_download_trans` VALUES(11, 116);
INSERT INTO `cto_download_trans` VALUES(11, 117);
INSERT INTO `cto_download_trans` VALUES(11, 118);
INSERT INTO `cto_download_trans` VALUES(11, 119);
INSERT INTO `cto_download_trans` VALUES(11, 120);
INSERT INTO `cto_download_trans` VALUES(11, 121);
INSERT INTO `cto_download_trans` VALUES(11, 122);
INSERT INTO `cto_download_trans` VALUES(12, 1);
INSERT INTO `cto_download_trans` VALUES(12, 2);
INSERT INTO `cto_download_trans` VALUES(12, 3);
INSERT INTO `cto_download_trans` VALUES(12, 4);
INSERT INTO `cto_download_trans` VALUES(12, 5);
INSERT INTO `cto_download_trans` VALUES(12, 6);
INSERT INTO `cto_download_trans` VALUES(12, 7);
INSERT INTO `cto_download_trans` VALUES(12, 8);
INSERT INTO `cto_download_trans` VALUES(12, 9);
INSERT INTO `cto_download_trans` VALUES(12, 10);
INSERT INTO `cto_download_trans` VALUES(12, 11);
INSERT INTO `cto_download_trans` VALUES(12, 12);
INSERT INTO `cto_download_trans` VALUES(12, 13);
INSERT INTO `cto_download_trans` VALUES(12, 14);
INSERT INTO `cto_download_trans` VALUES(12, 15);
INSERT INTO `cto_download_trans` VALUES(12, 16);
INSERT INTO `cto_download_trans` VALUES(12, 17);
INSERT INTO `cto_download_trans` VALUES(12, 18);
INSERT INTO `cto_download_trans` VALUES(12, 19);
INSERT INTO `cto_download_trans` VALUES(12, 20);
INSERT INTO `cto_download_trans` VALUES(12, 21);
INSERT INTO `cto_download_trans` VALUES(12, 22);
INSERT INTO `cto_download_trans` VALUES(12, 23);
INSERT INTO `cto_download_trans` VALUES(12, 24);
INSERT INTO `cto_download_trans` VALUES(12, 25);
INSERT INTO `cto_download_trans` VALUES(12, 26);
INSERT INTO `cto_download_trans` VALUES(12, 27);
INSERT INTO `cto_download_trans` VALUES(12, 28);
INSERT INTO `cto_download_trans` VALUES(12, 29);
INSERT INTO `cto_download_trans` VALUES(12, 30);
INSERT INTO `cto_download_trans` VALUES(12, 31);
INSERT INTO `cto_download_trans` VALUES(12, 32);
INSERT INTO `cto_download_trans` VALUES(12, 33);
INSERT INTO `cto_download_trans` VALUES(12, 34);
INSERT INTO `cto_download_trans` VALUES(12, 35);
INSERT INTO `cto_download_trans` VALUES(12, 36);
INSERT INTO `cto_download_trans` VALUES(12, 37);
INSERT INTO `cto_download_trans` VALUES(12, 38);
INSERT INTO `cto_download_trans` VALUES(12, 39);
INSERT INTO `cto_download_trans` VALUES(12, 40);
INSERT INTO `cto_download_trans` VALUES(12, 41);
INSERT INTO `cto_download_trans` VALUES(12, 42);
INSERT INTO `cto_download_trans` VALUES(12, 43);
INSERT INTO `cto_download_trans` VALUES(12, 44);
INSERT INTO `cto_download_trans` VALUES(12, 45);
INSERT INTO `cto_download_trans` VALUES(12, 46);
INSERT INTO `cto_download_trans` VALUES(12, 47);
INSERT INTO `cto_download_trans` VALUES(12, 48);
INSERT INTO `cto_download_trans` VALUES(12, 49);
INSERT INTO `cto_download_trans` VALUES(12, 50);
INSERT INTO `cto_download_trans` VALUES(12, 51);
INSERT INTO `cto_download_trans` VALUES(12, 52);
INSERT INTO `cto_download_trans` VALUES(12, 53);
INSERT INTO `cto_download_trans` VALUES(12, 54);
INSERT INTO `cto_download_trans` VALUES(12, 55);
INSERT INTO `cto_download_trans` VALUES(12, 56);
INSERT INTO `cto_download_trans` VALUES(12, 57);
INSERT INTO `cto_download_trans` VALUES(12, 58);
INSERT INTO `cto_download_trans` VALUES(12, 59);
INSERT INTO `cto_download_trans` VALUES(12, 60);
INSERT INTO `cto_download_trans` VALUES(12, 61);
INSERT INTO `cto_download_trans` VALUES(12, 62);
INSERT INTO `cto_download_trans` VALUES(12, 63);
INSERT INTO `cto_download_trans` VALUES(12, 64);
INSERT INTO `cto_download_trans` VALUES(12, 65);
INSERT INTO `cto_download_trans` VALUES(12, 66);
INSERT INTO `cto_download_trans` VALUES(12, 67);
INSERT INTO `cto_download_trans` VALUES(12, 68);
INSERT INTO `cto_download_trans` VALUES(12, 69);
INSERT INTO `cto_download_trans` VALUES(12, 70);
INSERT INTO `cto_download_trans` VALUES(12, 71);
INSERT INTO `cto_download_trans` VALUES(12, 72);
INSERT INTO `cto_download_trans` VALUES(12, 73);
INSERT INTO `cto_download_trans` VALUES(12, 74);
INSERT INTO `cto_download_trans` VALUES(12, 75);
INSERT INTO `cto_download_trans` VALUES(12, 76);
INSERT INTO `cto_download_trans` VALUES(12, 77);
INSERT INTO `cto_download_trans` VALUES(12, 78);
INSERT INTO `cto_download_trans` VALUES(12, 79);
INSERT INTO `cto_download_trans` VALUES(12, 80);
INSERT INTO `cto_download_trans` VALUES(12, 81);
INSERT INTO `cto_download_trans` VALUES(12, 82);
INSERT INTO `cto_download_trans` VALUES(12, 83);
INSERT INTO `cto_download_trans` VALUES(12, 84);
INSERT INTO `cto_download_trans` VALUES(12, 85);
INSERT INTO `cto_download_trans` VALUES(12, 86);
INSERT INTO `cto_download_trans` VALUES(12, 87);
INSERT INTO `cto_download_trans` VALUES(12, 88);
INSERT INTO `cto_download_trans` VALUES(12, 89);
INSERT INTO `cto_download_trans` VALUES(12, 90);
INSERT INTO `cto_download_trans` VALUES(12, 91);
INSERT INTO `cto_download_trans` VALUES(12, 92);
INSERT INTO `cto_download_trans` VALUES(12, 93);
INSERT INTO `cto_download_trans` VALUES(12, 94);
INSERT INTO `cto_download_trans` VALUES(12, 95);
INSERT INTO `cto_download_trans` VALUES(12, 96);
INSERT INTO `cto_download_trans` VALUES(12, 97);
INSERT INTO `cto_download_trans` VALUES(12, 98);
INSERT INTO `cto_download_trans` VALUES(12, 99);
INSERT INTO `cto_download_trans` VALUES(12, 100);
INSERT INTO `cto_download_trans` VALUES(12, 101);
INSERT INTO `cto_download_trans` VALUES(12, 102);
INSERT INTO `cto_download_trans` VALUES(12, 103);
INSERT INTO `cto_download_trans` VALUES(12, 104);
INSERT INTO `cto_download_trans` VALUES(12, 105);
INSERT INTO `cto_download_trans` VALUES(12, 106);
INSERT INTO `cto_download_trans` VALUES(12, 107);
INSERT INTO `cto_download_trans` VALUES(12, 108);
INSERT INTO `cto_download_trans` VALUES(12, 109);
INSERT INTO `cto_download_trans` VALUES(12, 110);
INSERT INTO `cto_download_trans` VALUES(12, 111);
INSERT INTO `cto_download_trans` VALUES(12, 112);
INSERT INTO `cto_download_trans` VALUES(12, 113);
INSERT INTO `cto_download_trans` VALUES(12, 114);
INSERT INTO `cto_download_trans` VALUES(12, 115);
INSERT INTO `cto_download_trans` VALUES(12, 116);
INSERT INTO `cto_download_trans` VALUES(12, 117);
INSERT INTO `cto_download_trans` VALUES(12, 118);
INSERT INTO `cto_download_trans` VALUES(12, 119);
INSERT INTO `cto_download_trans` VALUES(12, 120);
INSERT INTO `cto_download_trans` VALUES(12, 121);
INSERT INTO `cto_download_trans` VALUES(12, 122);
INSERT INTO `cto_download_trans` VALUES(13, 1);
INSERT INTO `cto_download_trans` VALUES(13, 2);
INSERT INTO `cto_download_trans` VALUES(13, 3);
INSERT INTO `cto_download_trans` VALUES(13, 4);
INSERT INTO `cto_download_trans` VALUES(13, 5);
INSERT INTO `cto_download_trans` VALUES(13, 6);
INSERT INTO `cto_download_trans` VALUES(13, 7);
INSERT INTO `cto_download_trans` VALUES(13, 8);
INSERT INTO `cto_download_trans` VALUES(13, 9);
INSERT INTO `cto_download_trans` VALUES(13, 10);
INSERT INTO `cto_download_trans` VALUES(13, 11);
INSERT INTO `cto_download_trans` VALUES(13, 12);
INSERT INTO `cto_download_trans` VALUES(13, 13);
INSERT INTO `cto_download_trans` VALUES(13, 14);
INSERT INTO `cto_download_trans` VALUES(13, 15);
INSERT INTO `cto_download_trans` VALUES(13, 16);
INSERT INTO `cto_download_trans` VALUES(13, 17);
INSERT INTO `cto_download_trans` VALUES(13, 18);
INSERT INTO `cto_download_trans` VALUES(13, 19);
INSERT INTO `cto_download_trans` VALUES(13, 20);
INSERT INTO `cto_download_trans` VALUES(13, 21);
INSERT INTO `cto_download_trans` VALUES(13, 22);
INSERT INTO `cto_download_trans` VALUES(13, 23);
INSERT INTO `cto_download_trans` VALUES(13, 24);
INSERT INTO `cto_download_trans` VALUES(13, 25);
INSERT INTO `cto_download_trans` VALUES(13, 26);
INSERT INTO `cto_download_trans` VALUES(13, 27);
INSERT INTO `cto_download_trans` VALUES(13, 28);
INSERT INTO `cto_download_trans` VALUES(13, 29);
INSERT INTO `cto_download_trans` VALUES(13, 30);
INSERT INTO `cto_download_trans` VALUES(13, 31);
INSERT INTO `cto_download_trans` VALUES(13, 32);
INSERT INTO `cto_download_trans` VALUES(13, 33);
INSERT INTO `cto_download_trans` VALUES(13, 34);
INSERT INTO `cto_download_trans` VALUES(13, 35);
INSERT INTO `cto_download_trans` VALUES(13, 36);
INSERT INTO `cto_download_trans` VALUES(13, 37);
INSERT INTO `cto_download_trans` VALUES(13, 38);
INSERT INTO `cto_download_trans` VALUES(13, 39);
INSERT INTO `cto_download_trans` VALUES(13, 40);
INSERT INTO `cto_download_trans` VALUES(13, 41);
INSERT INTO `cto_download_trans` VALUES(13, 42);
INSERT INTO `cto_download_trans` VALUES(13, 43);
INSERT INTO `cto_download_trans` VALUES(13, 44);
INSERT INTO `cto_download_trans` VALUES(13, 45);
INSERT INTO `cto_download_trans` VALUES(13, 46);
INSERT INTO `cto_download_trans` VALUES(13, 47);
INSERT INTO `cto_download_trans` VALUES(13, 48);
INSERT INTO `cto_download_trans` VALUES(13, 49);
INSERT INTO `cto_download_trans` VALUES(13, 50);
INSERT INTO `cto_download_trans` VALUES(13, 51);
INSERT INTO `cto_download_trans` VALUES(13, 52);
INSERT INTO `cto_download_trans` VALUES(13, 53);
INSERT INTO `cto_download_trans` VALUES(13, 54);
INSERT INTO `cto_download_trans` VALUES(13, 55);
INSERT INTO `cto_download_trans` VALUES(13, 56);
INSERT INTO `cto_download_trans` VALUES(13, 57);
INSERT INTO `cto_download_trans` VALUES(13, 58);
INSERT INTO `cto_download_trans` VALUES(13, 59);
INSERT INTO `cto_download_trans` VALUES(13, 60);
INSERT INTO `cto_download_trans` VALUES(13, 61);
INSERT INTO `cto_download_trans` VALUES(13, 62);
INSERT INTO `cto_download_trans` VALUES(13, 63);
INSERT INTO `cto_download_trans` VALUES(13, 64);
INSERT INTO `cto_download_trans` VALUES(13, 65);
INSERT INTO `cto_download_trans` VALUES(13, 66);
INSERT INTO `cto_download_trans` VALUES(13, 67);
INSERT INTO `cto_download_trans` VALUES(13, 68);
INSERT INTO `cto_download_trans` VALUES(13, 69);
INSERT INTO `cto_download_trans` VALUES(13, 70);
INSERT INTO `cto_download_trans` VALUES(13, 71);
INSERT INTO `cto_download_trans` VALUES(13, 72);
INSERT INTO `cto_download_trans` VALUES(13, 73);
INSERT INTO `cto_download_trans` VALUES(13, 74);
INSERT INTO `cto_download_trans` VALUES(13, 75);
INSERT INTO `cto_download_trans` VALUES(13, 76);
INSERT INTO `cto_download_trans` VALUES(13, 77);
INSERT INTO `cto_download_trans` VALUES(13, 78);
INSERT INTO `cto_download_trans` VALUES(13, 79);
INSERT INTO `cto_download_trans` VALUES(13, 80);
INSERT INTO `cto_download_trans` VALUES(13, 81);
INSERT INTO `cto_download_trans` VALUES(13, 82);
INSERT INTO `cto_download_trans` VALUES(13, 83);
INSERT INTO `cto_download_trans` VALUES(13, 84);
INSERT INTO `cto_download_trans` VALUES(13, 85);
INSERT INTO `cto_download_trans` VALUES(13, 86);
INSERT INTO `cto_download_trans` VALUES(13, 87);
INSERT INTO `cto_download_trans` VALUES(13, 88);
INSERT INTO `cto_download_trans` VALUES(13, 89);
INSERT INTO `cto_download_trans` VALUES(13, 90);
INSERT INTO `cto_download_trans` VALUES(13, 91);
INSERT INTO `cto_download_trans` VALUES(13, 92);
INSERT INTO `cto_download_trans` VALUES(13, 93);
INSERT INTO `cto_download_trans` VALUES(13, 94);
INSERT INTO `cto_download_trans` VALUES(13, 95);
INSERT INTO `cto_download_trans` VALUES(13, 96);
INSERT INTO `cto_download_trans` VALUES(13, 97);
INSERT INTO `cto_download_trans` VALUES(13, 98);
INSERT INTO `cto_download_trans` VALUES(13, 99);
INSERT INTO `cto_download_trans` VALUES(13, 100);
INSERT INTO `cto_download_trans` VALUES(13, 101);
INSERT INTO `cto_download_trans` VALUES(13, 102);
INSERT INTO `cto_download_trans` VALUES(13, 103);
INSERT INTO `cto_download_trans` VALUES(13, 104);
INSERT INTO `cto_download_trans` VALUES(13, 105);
INSERT INTO `cto_download_trans` VALUES(13, 106);
INSERT INTO `cto_download_trans` VALUES(13, 107);
INSERT INTO `cto_download_trans` VALUES(13, 108);
INSERT INTO `cto_download_trans` VALUES(13, 109);
INSERT INTO `cto_download_trans` VALUES(13, 110);
INSERT INTO `cto_download_trans` VALUES(13, 111);
INSERT INTO `cto_download_trans` VALUES(13, 112);
INSERT INTO `cto_download_trans` VALUES(13, 113);
INSERT INTO `cto_download_trans` VALUES(13, 114);
INSERT INTO `cto_download_trans` VALUES(13, 115);
INSERT INTO `cto_download_trans` VALUES(13, 116);
INSERT INTO `cto_download_trans` VALUES(13, 117);
INSERT INTO `cto_download_trans` VALUES(13, 118);
INSERT INTO `cto_download_trans` VALUES(13, 119);
INSERT INTO `cto_download_trans` VALUES(13, 120);
INSERT INTO `cto_download_trans` VALUES(13, 121);
INSERT INTO `cto_download_trans` VALUES(13, 122);
INSERT INTO `cto_download_trans` VALUES(14, 1);
INSERT INTO `cto_download_trans` VALUES(14, 2);
INSERT INTO `cto_download_trans` VALUES(14, 3);
INSERT INTO `cto_download_trans` VALUES(14, 4);
INSERT INTO `cto_download_trans` VALUES(14, 5);
INSERT INTO `cto_download_trans` VALUES(14, 6);
INSERT INTO `cto_download_trans` VALUES(14, 7);
INSERT INTO `cto_download_trans` VALUES(14, 8);
INSERT INTO `cto_download_trans` VALUES(14, 9);
INSERT INTO `cto_download_trans` VALUES(14, 10);
INSERT INTO `cto_download_trans` VALUES(14, 11);
INSERT INTO `cto_download_trans` VALUES(14, 12);
INSERT INTO `cto_download_trans` VALUES(14, 13);
INSERT INTO `cto_download_trans` VALUES(14, 14);
INSERT INTO `cto_download_trans` VALUES(14, 15);
INSERT INTO `cto_download_trans` VALUES(14, 16);
INSERT INTO `cto_download_trans` VALUES(14, 17);
INSERT INTO `cto_download_trans` VALUES(14, 18);
INSERT INTO `cto_download_trans` VALUES(14, 19);
INSERT INTO `cto_download_trans` VALUES(14, 20);
INSERT INTO `cto_download_trans` VALUES(14, 21);
INSERT INTO `cto_download_trans` VALUES(14, 22);
INSERT INTO `cto_download_trans` VALUES(14, 23);
INSERT INTO `cto_download_trans` VALUES(14, 24);
INSERT INTO `cto_download_trans` VALUES(14, 25);
INSERT INTO `cto_download_trans` VALUES(14, 26);
INSERT INTO `cto_download_trans` VALUES(14, 27);
INSERT INTO `cto_download_trans` VALUES(14, 28);
INSERT INTO `cto_download_trans` VALUES(14, 29);
INSERT INTO `cto_download_trans` VALUES(14, 30);
INSERT INTO `cto_download_trans` VALUES(14, 31);
INSERT INTO `cto_download_trans` VALUES(14, 32);
INSERT INTO `cto_download_trans` VALUES(14, 33);
INSERT INTO `cto_download_trans` VALUES(14, 34);
INSERT INTO `cto_download_trans` VALUES(14, 35);
INSERT INTO `cto_download_trans` VALUES(14, 36);
INSERT INTO `cto_download_trans` VALUES(14, 37);
INSERT INTO `cto_download_trans` VALUES(14, 38);
INSERT INTO `cto_download_trans` VALUES(14, 39);
INSERT INTO `cto_download_trans` VALUES(14, 40);
INSERT INTO `cto_download_trans` VALUES(14, 41);
INSERT INTO `cto_download_trans` VALUES(14, 42);
INSERT INTO `cto_download_trans` VALUES(14, 43);
INSERT INTO `cto_download_trans` VALUES(14, 44);
INSERT INTO `cto_download_trans` VALUES(14, 45);
INSERT INTO `cto_download_trans` VALUES(14, 46);
INSERT INTO `cto_download_trans` VALUES(14, 47);
INSERT INTO `cto_download_trans` VALUES(14, 48);
INSERT INTO `cto_download_trans` VALUES(14, 49);
INSERT INTO `cto_download_trans` VALUES(14, 50);
INSERT INTO `cto_download_trans` VALUES(14, 51);
INSERT INTO `cto_download_trans` VALUES(14, 52);
INSERT INTO `cto_download_trans` VALUES(14, 53);
INSERT INTO `cto_download_trans` VALUES(14, 54);
INSERT INTO `cto_download_trans` VALUES(14, 55);
INSERT INTO `cto_download_trans` VALUES(14, 56);
INSERT INTO `cto_download_trans` VALUES(14, 57);
INSERT INTO `cto_download_trans` VALUES(14, 58);
INSERT INTO `cto_download_trans` VALUES(14, 59);
INSERT INTO `cto_download_trans` VALUES(14, 60);
INSERT INTO `cto_download_trans` VALUES(14, 61);
INSERT INTO `cto_download_trans` VALUES(14, 62);
INSERT INTO `cto_download_trans` VALUES(14, 63);
INSERT INTO `cto_download_trans` VALUES(14, 64);
INSERT INTO `cto_download_trans` VALUES(14, 65);
INSERT INTO `cto_download_trans` VALUES(14, 66);
INSERT INTO `cto_download_trans` VALUES(14, 67);
INSERT INTO `cto_download_trans` VALUES(14, 68);
INSERT INTO `cto_download_trans` VALUES(14, 69);
INSERT INTO `cto_download_trans` VALUES(14, 70);
INSERT INTO `cto_download_trans` VALUES(14, 71);
INSERT INTO `cto_download_trans` VALUES(14, 72);
INSERT INTO `cto_download_trans` VALUES(14, 73);
INSERT INTO `cto_download_trans` VALUES(14, 74);
INSERT INTO `cto_download_trans` VALUES(14, 75);
INSERT INTO `cto_download_trans` VALUES(14, 76);
INSERT INTO `cto_download_trans` VALUES(14, 77);
INSERT INTO `cto_download_trans` VALUES(14, 78);
INSERT INTO `cto_download_trans` VALUES(14, 79);
INSERT INTO `cto_download_trans` VALUES(14, 80);
INSERT INTO `cto_download_trans` VALUES(14, 81);
INSERT INTO `cto_download_trans` VALUES(14, 82);
INSERT INTO `cto_download_trans` VALUES(14, 83);
INSERT INTO `cto_download_trans` VALUES(14, 84);
INSERT INTO `cto_download_trans` VALUES(14, 85);
INSERT INTO `cto_download_trans` VALUES(14, 86);
INSERT INTO `cto_download_trans` VALUES(14, 87);
INSERT INTO `cto_download_trans` VALUES(14, 88);
INSERT INTO `cto_download_trans` VALUES(14, 89);
INSERT INTO `cto_download_trans` VALUES(14, 90);
INSERT INTO `cto_download_trans` VALUES(14, 91);
INSERT INTO `cto_download_trans` VALUES(14, 92);
INSERT INTO `cto_download_trans` VALUES(14, 93);
INSERT INTO `cto_download_trans` VALUES(14, 94);
INSERT INTO `cto_download_trans` VALUES(14, 95);
INSERT INTO `cto_download_trans` VALUES(14, 96);
INSERT INTO `cto_download_trans` VALUES(14, 97);
INSERT INTO `cto_download_trans` VALUES(14, 98);
INSERT INTO `cto_download_trans` VALUES(14, 99);
INSERT INTO `cto_download_trans` VALUES(14, 100);
INSERT INTO `cto_download_trans` VALUES(14, 101);
INSERT INTO `cto_download_trans` VALUES(14, 102);
INSERT INTO `cto_download_trans` VALUES(14, 103);
INSERT INTO `cto_download_trans` VALUES(14, 104);
INSERT INTO `cto_download_trans` VALUES(14, 105);
INSERT INTO `cto_download_trans` VALUES(14, 106);
INSERT INTO `cto_download_trans` VALUES(14, 107);
INSERT INTO `cto_download_trans` VALUES(14, 108);
INSERT INTO `cto_download_trans` VALUES(14, 109);
INSERT INTO `cto_download_trans` VALUES(14, 110);
INSERT INTO `cto_download_trans` VALUES(14, 111);
INSERT INTO `cto_download_trans` VALUES(14, 112);
INSERT INTO `cto_download_trans` VALUES(14, 113);
INSERT INTO `cto_download_trans` VALUES(14, 114);
INSERT INTO `cto_download_trans` VALUES(14, 115);
INSERT INTO `cto_download_trans` VALUES(14, 116);
INSERT INTO `cto_download_trans` VALUES(14, 117);
INSERT INTO `cto_download_trans` VALUES(14, 118);
INSERT INTO `cto_download_trans` VALUES(14, 119);
INSERT INTO `cto_download_trans` VALUES(14, 120);
INSERT INTO `cto_download_trans` VALUES(14, 121);
INSERT INTO `cto_download_trans` VALUES(14, 122);
INSERT INTO `cto_download_trans` VALUES(15, 1);
INSERT INTO `cto_download_trans` VALUES(15, 2);
INSERT INTO `cto_download_trans` VALUES(15, 3);
INSERT INTO `cto_download_trans` VALUES(15, 4);
INSERT INTO `cto_download_trans` VALUES(15, 5);
INSERT INTO `cto_download_trans` VALUES(15, 6);
INSERT INTO `cto_download_trans` VALUES(15, 7);
INSERT INTO `cto_download_trans` VALUES(15, 8);
INSERT INTO `cto_download_trans` VALUES(15, 9);
INSERT INTO `cto_download_trans` VALUES(15, 10);
INSERT INTO `cto_download_trans` VALUES(15, 11);
INSERT INTO `cto_download_trans` VALUES(15, 12);
INSERT INTO `cto_download_trans` VALUES(15, 13);
INSERT INTO `cto_download_trans` VALUES(15, 14);
INSERT INTO `cto_download_trans` VALUES(15, 15);
INSERT INTO `cto_download_trans` VALUES(15, 16);
INSERT INTO `cto_download_trans` VALUES(15, 17);
INSERT INTO `cto_download_trans` VALUES(15, 18);
INSERT INTO `cto_download_trans` VALUES(15, 19);
INSERT INTO `cto_download_trans` VALUES(15, 20);
INSERT INTO `cto_download_trans` VALUES(15, 21);
INSERT INTO `cto_download_trans` VALUES(15, 22);
INSERT INTO `cto_download_trans` VALUES(15, 23);
INSERT INTO `cto_download_trans` VALUES(15, 24);
INSERT INTO `cto_download_trans` VALUES(15, 25);
INSERT INTO `cto_download_trans` VALUES(15, 26);
INSERT INTO `cto_download_trans` VALUES(15, 27);
INSERT INTO `cto_download_trans` VALUES(15, 28);
INSERT INTO `cto_download_trans` VALUES(15, 29);
INSERT INTO `cto_download_trans` VALUES(15, 30);
INSERT INTO `cto_download_trans` VALUES(15, 31);
INSERT INTO `cto_download_trans` VALUES(15, 32);
INSERT INTO `cto_download_trans` VALUES(15, 33);
INSERT INTO `cto_download_trans` VALUES(15, 34);
INSERT INTO `cto_download_trans` VALUES(15, 35);
INSERT INTO `cto_download_trans` VALUES(15, 36);
INSERT INTO `cto_download_trans` VALUES(15, 37);
INSERT INTO `cto_download_trans` VALUES(15, 38);
INSERT INTO `cto_download_trans` VALUES(15, 39);
INSERT INTO `cto_download_trans` VALUES(15, 40);
INSERT INTO `cto_download_trans` VALUES(15, 41);
INSERT INTO `cto_download_trans` VALUES(15, 42);
INSERT INTO `cto_download_trans` VALUES(15, 43);
INSERT INTO `cto_download_trans` VALUES(15, 44);
INSERT INTO `cto_download_trans` VALUES(15, 45);
INSERT INTO `cto_download_trans` VALUES(15, 46);
INSERT INTO `cto_download_trans` VALUES(15, 47);
INSERT INTO `cto_download_trans` VALUES(15, 48);
INSERT INTO `cto_download_trans` VALUES(15, 49);
INSERT INTO `cto_download_trans` VALUES(15, 50);
INSERT INTO `cto_download_trans` VALUES(15, 51);
INSERT INTO `cto_download_trans` VALUES(15, 52);
INSERT INTO `cto_download_trans` VALUES(15, 53);
INSERT INTO `cto_download_trans` VALUES(15, 54);
INSERT INTO `cto_download_trans` VALUES(15, 55);
INSERT INTO `cto_download_trans` VALUES(15, 56);
INSERT INTO `cto_download_trans` VALUES(15, 57);
INSERT INTO `cto_download_trans` VALUES(15, 58);
INSERT INTO `cto_download_trans` VALUES(15, 59);
INSERT INTO `cto_download_trans` VALUES(15, 60);
INSERT INTO `cto_download_trans` VALUES(15, 61);
INSERT INTO `cto_download_trans` VALUES(15, 62);
INSERT INTO `cto_download_trans` VALUES(15, 63);
INSERT INTO `cto_download_trans` VALUES(15, 64);
INSERT INTO `cto_download_trans` VALUES(15, 65);
INSERT INTO `cto_download_trans` VALUES(15, 66);
INSERT INTO `cto_download_trans` VALUES(15, 67);
INSERT INTO `cto_download_trans` VALUES(15, 68);
INSERT INTO `cto_download_trans` VALUES(15, 69);
INSERT INTO `cto_download_trans` VALUES(15, 70);
INSERT INTO `cto_download_trans` VALUES(15, 71);
INSERT INTO `cto_download_trans` VALUES(15, 72);
INSERT INTO `cto_download_trans` VALUES(15, 73);
INSERT INTO `cto_download_trans` VALUES(15, 74);
INSERT INTO `cto_download_trans` VALUES(15, 75);
INSERT INTO `cto_download_trans` VALUES(15, 76);
INSERT INTO `cto_download_trans` VALUES(15, 77);
INSERT INTO `cto_download_trans` VALUES(15, 78);
INSERT INTO `cto_download_trans` VALUES(15, 79);
INSERT INTO `cto_download_trans` VALUES(15, 80);
INSERT INTO `cto_download_trans` VALUES(15, 81);
INSERT INTO `cto_download_trans` VALUES(15, 82);
INSERT INTO `cto_download_trans` VALUES(15, 83);
INSERT INTO `cto_download_trans` VALUES(15, 84);
INSERT INTO `cto_download_trans` VALUES(15, 85);
INSERT INTO `cto_download_trans` VALUES(15, 86);
INSERT INTO `cto_download_trans` VALUES(15, 87);
INSERT INTO `cto_download_trans` VALUES(15, 88);
INSERT INTO `cto_download_trans` VALUES(15, 89);
INSERT INTO `cto_download_trans` VALUES(15, 90);
INSERT INTO `cto_download_trans` VALUES(15, 91);
INSERT INTO `cto_download_trans` VALUES(15, 92);
INSERT INTO `cto_download_trans` VALUES(15, 93);
INSERT INTO `cto_download_trans` VALUES(15, 94);
INSERT INTO `cto_download_trans` VALUES(15, 95);
INSERT INTO `cto_download_trans` VALUES(15, 96);
INSERT INTO `cto_download_trans` VALUES(15, 97);
INSERT INTO `cto_download_trans` VALUES(15, 98);
INSERT INTO `cto_download_trans` VALUES(15, 99);
INSERT INTO `cto_download_trans` VALUES(15, 100);
INSERT INTO `cto_download_trans` VALUES(15, 101);
INSERT INTO `cto_download_trans` VALUES(15, 102);
INSERT INTO `cto_download_trans` VALUES(15, 103);
INSERT INTO `cto_download_trans` VALUES(15, 104);
INSERT INTO `cto_download_trans` VALUES(15, 105);
INSERT INTO `cto_download_trans` VALUES(15, 106);
INSERT INTO `cto_download_trans` VALUES(15, 107);
INSERT INTO `cto_download_trans` VALUES(15, 108);
INSERT INTO `cto_download_trans` VALUES(15, 109);
INSERT INTO `cto_download_trans` VALUES(15, 110);
INSERT INTO `cto_download_trans` VALUES(15, 111);
INSERT INTO `cto_download_trans` VALUES(15, 112);
INSERT INTO `cto_download_trans` VALUES(15, 113);
INSERT INTO `cto_download_trans` VALUES(15, 114);
INSERT INTO `cto_download_trans` VALUES(15, 115);
INSERT INTO `cto_download_trans` VALUES(15, 116);
INSERT INTO `cto_download_trans` VALUES(15, 117);
INSERT INTO `cto_download_trans` VALUES(15, 118);
INSERT INTO `cto_download_trans` VALUES(15, 119);
INSERT INTO `cto_download_trans` VALUES(15, 120);
INSERT INTO `cto_download_trans` VALUES(15, 121);
INSERT INTO `cto_download_trans` VALUES(15, 122);
INSERT INTO `cto_download_trans` VALUES(16, 1);
INSERT INTO `cto_download_trans` VALUES(16, 2);
INSERT INTO `cto_download_trans` VALUES(16, 3);
INSERT INTO `cto_download_trans` VALUES(16, 4);
INSERT INTO `cto_download_trans` VALUES(16, 5);
INSERT INTO `cto_download_trans` VALUES(16, 6);
INSERT INTO `cto_download_trans` VALUES(16, 7);
INSERT INTO `cto_download_trans` VALUES(16, 8);
INSERT INTO `cto_download_trans` VALUES(16, 9);
INSERT INTO `cto_download_trans` VALUES(16, 10);
INSERT INTO `cto_download_trans` VALUES(16, 11);
INSERT INTO `cto_download_trans` VALUES(16, 12);
INSERT INTO `cto_download_trans` VALUES(16, 13);
INSERT INTO `cto_download_trans` VALUES(16, 14);
INSERT INTO `cto_download_trans` VALUES(16, 15);
INSERT INTO `cto_download_trans` VALUES(16, 16);
INSERT INTO `cto_download_trans` VALUES(16, 17);
INSERT INTO `cto_download_trans` VALUES(16, 18);
INSERT INTO `cto_download_trans` VALUES(16, 19);
INSERT INTO `cto_download_trans` VALUES(16, 20);
INSERT INTO `cto_download_trans` VALUES(16, 21);
INSERT INTO `cto_download_trans` VALUES(16, 22);
INSERT INTO `cto_download_trans` VALUES(16, 23);
INSERT INTO `cto_download_trans` VALUES(16, 24);
INSERT INTO `cto_download_trans` VALUES(16, 25);
INSERT INTO `cto_download_trans` VALUES(16, 26);
INSERT INTO `cto_download_trans` VALUES(16, 27);
INSERT INTO `cto_download_trans` VALUES(16, 28);
INSERT INTO `cto_download_trans` VALUES(16, 29);
INSERT INTO `cto_download_trans` VALUES(16, 30);
INSERT INTO `cto_download_trans` VALUES(16, 31);
INSERT INTO `cto_download_trans` VALUES(16, 32);
INSERT INTO `cto_download_trans` VALUES(16, 33);
INSERT INTO `cto_download_trans` VALUES(16, 34);
INSERT INTO `cto_download_trans` VALUES(16, 35);
INSERT INTO `cto_download_trans` VALUES(16, 36);
INSERT INTO `cto_download_trans` VALUES(16, 37);
INSERT INTO `cto_download_trans` VALUES(16, 38);
INSERT INTO `cto_download_trans` VALUES(16, 39);
INSERT INTO `cto_download_trans` VALUES(16, 40);
INSERT INTO `cto_download_trans` VALUES(16, 41);
INSERT INTO `cto_download_trans` VALUES(16, 42);
INSERT INTO `cto_download_trans` VALUES(16, 43);
INSERT INTO `cto_download_trans` VALUES(16, 44);
INSERT INTO `cto_download_trans` VALUES(16, 45);
INSERT INTO `cto_download_trans` VALUES(16, 46);
INSERT INTO `cto_download_trans` VALUES(16, 47);
INSERT INTO `cto_download_trans` VALUES(16, 48);
INSERT INTO `cto_download_trans` VALUES(16, 49);
INSERT INTO `cto_download_trans` VALUES(16, 50);
INSERT INTO `cto_download_trans` VALUES(16, 51);
INSERT INTO `cto_download_trans` VALUES(16, 52);
INSERT INTO `cto_download_trans` VALUES(16, 53);
INSERT INTO `cto_download_trans` VALUES(16, 54);
INSERT INTO `cto_download_trans` VALUES(16, 55);
INSERT INTO `cto_download_trans` VALUES(16, 56);
INSERT INTO `cto_download_trans` VALUES(16, 57);
INSERT INTO `cto_download_trans` VALUES(16, 58);
INSERT INTO `cto_download_trans` VALUES(16, 59);
INSERT INTO `cto_download_trans` VALUES(16, 60);
INSERT INTO `cto_download_trans` VALUES(16, 61);
INSERT INTO `cto_download_trans` VALUES(16, 62);
INSERT INTO `cto_download_trans` VALUES(16, 63);
INSERT INTO `cto_download_trans` VALUES(16, 64);
INSERT INTO `cto_download_trans` VALUES(16, 65);
INSERT INTO `cto_download_trans` VALUES(16, 66);
INSERT INTO `cto_download_trans` VALUES(16, 67);
INSERT INTO `cto_download_trans` VALUES(16, 68);
INSERT INTO `cto_download_trans` VALUES(16, 69);
INSERT INTO `cto_download_trans` VALUES(16, 70);
INSERT INTO `cto_download_trans` VALUES(16, 71);
INSERT INTO `cto_download_trans` VALUES(16, 72);
INSERT INTO `cto_download_trans` VALUES(16, 73);
INSERT INTO `cto_download_trans` VALUES(16, 74);
INSERT INTO `cto_download_trans` VALUES(16, 75);
INSERT INTO `cto_download_trans` VALUES(16, 76);
INSERT INTO `cto_download_trans` VALUES(16, 77);
INSERT INTO `cto_download_trans` VALUES(16, 78);
INSERT INTO `cto_download_trans` VALUES(16, 79);
INSERT INTO `cto_download_trans` VALUES(16, 80);
INSERT INTO `cto_download_trans` VALUES(16, 81);
INSERT INTO `cto_download_trans` VALUES(16, 82);
INSERT INTO `cto_download_trans` VALUES(16, 83);
INSERT INTO `cto_download_trans` VALUES(16, 84);
INSERT INTO `cto_download_trans` VALUES(16, 85);
INSERT INTO `cto_download_trans` VALUES(16, 86);
INSERT INTO `cto_download_trans` VALUES(16, 87);
INSERT INTO `cto_download_trans` VALUES(16, 88);
INSERT INTO `cto_download_trans` VALUES(16, 89);
INSERT INTO `cto_download_trans` VALUES(16, 90);
INSERT INTO `cto_download_trans` VALUES(16, 91);
INSERT INTO `cto_download_trans` VALUES(16, 92);
INSERT INTO `cto_download_trans` VALUES(16, 93);
INSERT INTO `cto_download_trans` VALUES(16, 94);
INSERT INTO `cto_download_trans` VALUES(16, 95);
INSERT INTO `cto_download_trans` VALUES(16, 96);
INSERT INTO `cto_download_trans` VALUES(16, 97);
INSERT INTO `cto_download_trans` VALUES(16, 98);
INSERT INTO `cto_download_trans` VALUES(16, 99);
INSERT INTO `cto_download_trans` VALUES(16, 100);
INSERT INTO `cto_download_trans` VALUES(16, 101);
INSERT INTO `cto_download_trans` VALUES(16, 102);
INSERT INTO `cto_download_trans` VALUES(16, 103);
INSERT INTO `cto_download_trans` VALUES(16, 104);
INSERT INTO `cto_download_trans` VALUES(16, 105);
INSERT INTO `cto_download_trans` VALUES(16, 106);
INSERT INTO `cto_download_trans` VALUES(16, 107);
INSERT INTO `cto_download_trans` VALUES(16, 108);
INSERT INTO `cto_download_trans` VALUES(16, 109);
INSERT INTO `cto_download_trans` VALUES(16, 110);
INSERT INTO `cto_download_trans` VALUES(16, 111);
INSERT INTO `cto_download_trans` VALUES(16, 112);
INSERT INTO `cto_download_trans` VALUES(16, 113);
INSERT INTO `cto_download_trans` VALUES(16, 114);
INSERT INTO `cto_download_trans` VALUES(16, 115);
INSERT INTO `cto_download_trans` VALUES(16, 116);
INSERT INTO `cto_download_trans` VALUES(16, 117);
INSERT INTO `cto_download_trans` VALUES(16, 118);
INSERT INTO `cto_download_trans` VALUES(16, 119);
INSERT INTO `cto_download_trans` VALUES(16, 120);
INSERT INTO `cto_download_trans` VALUES(16, 121);
INSERT INTO `cto_download_trans` VALUES(16, 122);
INSERT INTO `cto_download_trans` VALUES(17, 1);
INSERT INTO `cto_download_trans` VALUES(17, 2);
INSERT INTO `cto_download_trans` VALUES(17, 3);
INSERT INTO `cto_download_trans` VALUES(17, 4);
INSERT INTO `cto_download_trans` VALUES(17, 5);
INSERT INTO `cto_download_trans` VALUES(17, 6);
INSERT INTO `cto_download_trans` VALUES(17, 7);
INSERT INTO `cto_download_trans` VALUES(17, 8);
INSERT INTO `cto_download_trans` VALUES(17, 9);
INSERT INTO `cto_download_trans` VALUES(17, 10);
INSERT INTO `cto_download_trans` VALUES(17, 11);
INSERT INTO `cto_download_trans` VALUES(17, 12);
INSERT INTO `cto_download_trans` VALUES(17, 13);
INSERT INTO `cto_download_trans` VALUES(17, 14);
INSERT INTO `cto_download_trans` VALUES(17, 15);
INSERT INTO `cto_download_trans` VALUES(17, 16);
INSERT INTO `cto_download_trans` VALUES(17, 17);
INSERT INTO `cto_download_trans` VALUES(17, 18);
INSERT INTO `cto_download_trans` VALUES(17, 19);
INSERT INTO `cto_download_trans` VALUES(17, 20);
INSERT INTO `cto_download_trans` VALUES(17, 21);
INSERT INTO `cto_download_trans` VALUES(17, 22);
INSERT INTO `cto_download_trans` VALUES(17, 23);
INSERT INTO `cto_download_trans` VALUES(17, 24);
INSERT INTO `cto_download_trans` VALUES(17, 25);
INSERT INTO `cto_download_trans` VALUES(17, 26);
INSERT INTO `cto_download_trans` VALUES(17, 27);
INSERT INTO `cto_download_trans` VALUES(17, 28);
INSERT INTO `cto_download_trans` VALUES(17, 29);
INSERT INTO `cto_download_trans` VALUES(17, 30);
INSERT INTO `cto_download_trans` VALUES(17, 31);
INSERT INTO `cto_download_trans` VALUES(17, 32);
INSERT INTO `cto_download_trans` VALUES(17, 33);
INSERT INTO `cto_download_trans` VALUES(17, 34);
INSERT INTO `cto_download_trans` VALUES(17, 35);
INSERT INTO `cto_download_trans` VALUES(17, 36);
INSERT INTO `cto_download_trans` VALUES(17, 37);
INSERT INTO `cto_download_trans` VALUES(17, 38);
INSERT INTO `cto_download_trans` VALUES(17, 39);
INSERT INTO `cto_download_trans` VALUES(17, 40);
INSERT INTO `cto_download_trans` VALUES(17, 41);
INSERT INTO `cto_download_trans` VALUES(17, 42);
INSERT INTO `cto_download_trans` VALUES(17, 43);
INSERT INTO `cto_download_trans` VALUES(17, 44);
INSERT INTO `cto_download_trans` VALUES(17, 45);
INSERT INTO `cto_download_trans` VALUES(17, 46);
INSERT INTO `cto_download_trans` VALUES(17, 47);
INSERT INTO `cto_download_trans` VALUES(17, 48);
INSERT INTO `cto_download_trans` VALUES(17, 49);
INSERT INTO `cto_download_trans` VALUES(17, 50);
INSERT INTO `cto_download_trans` VALUES(17, 51);
INSERT INTO `cto_download_trans` VALUES(17, 52);
INSERT INTO `cto_download_trans` VALUES(17, 53);
INSERT INTO `cto_download_trans` VALUES(17, 54);
INSERT INTO `cto_download_trans` VALUES(17, 55);
INSERT INTO `cto_download_trans` VALUES(17, 56);
INSERT INTO `cto_download_trans` VALUES(17, 57);
INSERT INTO `cto_download_trans` VALUES(17, 58);
INSERT INTO `cto_download_trans` VALUES(17, 59);
INSERT INTO `cto_download_trans` VALUES(17, 60);
INSERT INTO `cto_download_trans` VALUES(17, 61);
INSERT INTO `cto_download_trans` VALUES(17, 62);
INSERT INTO `cto_download_trans` VALUES(17, 63);
INSERT INTO `cto_download_trans` VALUES(17, 64);
INSERT INTO `cto_download_trans` VALUES(17, 65);
INSERT INTO `cto_download_trans` VALUES(17, 66);
INSERT INTO `cto_download_trans` VALUES(17, 67);
INSERT INTO `cto_download_trans` VALUES(17, 68);
INSERT INTO `cto_download_trans` VALUES(17, 69);
INSERT INTO `cto_download_trans` VALUES(17, 70);
INSERT INTO `cto_download_trans` VALUES(17, 71);
INSERT INTO `cto_download_trans` VALUES(17, 72);
INSERT INTO `cto_download_trans` VALUES(17, 73);
INSERT INTO `cto_download_trans` VALUES(17, 74);
INSERT INTO `cto_download_trans` VALUES(17, 75);
INSERT INTO `cto_download_trans` VALUES(17, 76);
INSERT INTO `cto_download_trans` VALUES(17, 77);
INSERT INTO `cto_download_trans` VALUES(17, 78);
INSERT INTO `cto_download_trans` VALUES(17, 79);
INSERT INTO `cto_download_trans` VALUES(17, 80);
INSERT INTO `cto_download_trans` VALUES(17, 81);
INSERT INTO `cto_download_trans` VALUES(17, 82);
INSERT INTO `cto_download_trans` VALUES(17, 83);
INSERT INTO `cto_download_trans` VALUES(17, 84);
INSERT INTO `cto_download_trans` VALUES(17, 85);
INSERT INTO `cto_download_trans` VALUES(17, 86);
INSERT INTO `cto_download_trans` VALUES(17, 87);
INSERT INTO `cto_download_trans` VALUES(17, 88);
INSERT INTO `cto_download_trans` VALUES(17, 89);
INSERT INTO `cto_download_trans` VALUES(17, 90);
INSERT INTO `cto_download_trans` VALUES(17, 91);
INSERT INTO `cto_download_trans` VALUES(17, 92);
INSERT INTO `cto_download_trans` VALUES(17, 93);
INSERT INTO `cto_download_trans` VALUES(17, 94);
INSERT INTO `cto_download_trans` VALUES(17, 95);
INSERT INTO `cto_download_trans` VALUES(17, 96);
INSERT INTO `cto_download_trans` VALUES(17, 97);
INSERT INTO `cto_download_trans` VALUES(17, 98);
INSERT INTO `cto_download_trans` VALUES(17, 99);
INSERT INTO `cto_download_trans` VALUES(17, 100);
INSERT INTO `cto_download_trans` VALUES(17, 101);
INSERT INTO `cto_download_trans` VALUES(17, 102);
INSERT INTO `cto_download_trans` VALUES(17, 103);
INSERT INTO `cto_download_trans` VALUES(17, 104);
INSERT INTO `cto_download_trans` VALUES(17, 105);
INSERT INTO `cto_download_trans` VALUES(17, 106);
INSERT INTO `cto_download_trans` VALUES(17, 107);
INSERT INTO `cto_download_trans` VALUES(17, 108);
INSERT INTO `cto_download_trans` VALUES(17, 109);
INSERT INTO `cto_download_trans` VALUES(17, 110);
INSERT INTO `cto_download_trans` VALUES(17, 111);
INSERT INTO `cto_download_trans` VALUES(17, 112);
INSERT INTO `cto_download_trans` VALUES(17, 113);
INSERT INTO `cto_download_trans` VALUES(17, 114);
INSERT INTO `cto_download_trans` VALUES(17, 115);
INSERT INTO `cto_download_trans` VALUES(17, 116);
INSERT INTO `cto_download_trans` VALUES(17, 117);
INSERT INTO `cto_download_trans` VALUES(17, 118);
INSERT INTO `cto_download_trans` VALUES(17, 119);
INSERT INTO `cto_download_trans` VALUES(17, 120);
INSERT INTO `cto_download_trans` VALUES(17, 121);
INSERT INTO `cto_download_trans` VALUES(17, 122);
INSERT INTO `cto_download_trans` VALUES(18, 1);
INSERT INTO `cto_download_trans` VALUES(18, 2);
INSERT INTO `cto_download_trans` VALUES(18, 3);
INSERT INTO `cto_download_trans` VALUES(18, 4);
INSERT INTO `cto_download_trans` VALUES(18, 5);
INSERT INTO `cto_download_trans` VALUES(18, 6);
INSERT INTO `cto_download_trans` VALUES(18, 7);
INSERT INTO `cto_download_trans` VALUES(18, 8);
INSERT INTO `cto_download_trans` VALUES(18, 9);
INSERT INTO `cto_download_trans` VALUES(18, 10);
INSERT INTO `cto_download_trans` VALUES(18, 11);
INSERT INTO `cto_download_trans` VALUES(18, 12);
INSERT INTO `cto_download_trans` VALUES(18, 13);
INSERT INTO `cto_download_trans` VALUES(18, 14);
INSERT INTO `cto_download_trans` VALUES(18, 15);
INSERT INTO `cto_download_trans` VALUES(18, 16);
INSERT INTO `cto_download_trans` VALUES(18, 17);
INSERT INTO `cto_download_trans` VALUES(18, 18);
INSERT INTO `cto_download_trans` VALUES(18, 19);
INSERT INTO `cto_download_trans` VALUES(18, 20);
INSERT INTO `cto_download_trans` VALUES(18, 21);
INSERT INTO `cto_download_trans` VALUES(18, 22);
INSERT INTO `cto_download_trans` VALUES(18, 23);
INSERT INTO `cto_download_trans` VALUES(18, 24);
INSERT INTO `cto_download_trans` VALUES(18, 25);
INSERT INTO `cto_download_trans` VALUES(18, 26);
INSERT INTO `cto_download_trans` VALUES(18, 27);
INSERT INTO `cto_download_trans` VALUES(18, 28);
INSERT INTO `cto_download_trans` VALUES(18, 29);
INSERT INTO `cto_download_trans` VALUES(18, 30);
INSERT INTO `cto_download_trans` VALUES(18, 31);
INSERT INTO `cto_download_trans` VALUES(18, 32);
INSERT INTO `cto_download_trans` VALUES(18, 33);
INSERT INTO `cto_download_trans` VALUES(18, 34);
INSERT INTO `cto_download_trans` VALUES(18, 35);
INSERT INTO `cto_download_trans` VALUES(18, 36);
INSERT INTO `cto_download_trans` VALUES(18, 37);
INSERT INTO `cto_download_trans` VALUES(18, 38);
INSERT INTO `cto_download_trans` VALUES(18, 39);
INSERT INTO `cto_download_trans` VALUES(18, 40);
INSERT INTO `cto_download_trans` VALUES(18, 41);
INSERT INTO `cto_download_trans` VALUES(18, 42);
INSERT INTO `cto_download_trans` VALUES(18, 43);
INSERT INTO `cto_download_trans` VALUES(18, 44);
INSERT INTO `cto_download_trans` VALUES(18, 45);
INSERT INTO `cto_download_trans` VALUES(18, 46);
INSERT INTO `cto_download_trans` VALUES(18, 47);
INSERT INTO `cto_download_trans` VALUES(18, 48);
INSERT INTO `cto_download_trans` VALUES(18, 49);
INSERT INTO `cto_download_trans` VALUES(18, 50);
INSERT INTO `cto_download_trans` VALUES(18, 51);
INSERT INTO `cto_download_trans` VALUES(18, 52);
INSERT INTO `cto_download_trans` VALUES(18, 53);
INSERT INTO `cto_download_trans` VALUES(18, 54);
INSERT INTO `cto_download_trans` VALUES(18, 55);
INSERT INTO `cto_download_trans` VALUES(18, 56);
INSERT INTO `cto_download_trans` VALUES(18, 57);
INSERT INTO `cto_download_trans` VALUES(18, 58);
INSERT INTO `cto_download_trans` VALUES(18, 59);
INSERT INTO `cto_download_trans` VALUES(18, 60);
INSERT INTO `cto_download_trans` VALUES(18, 61);
INSERT INTO `cto_download_trans` VALUES(18, 62);
INSERT INTO `cto_download_trans` VALUES(18, 63);
INSERT INTO `cto_download_trans` VALUES(18, 64);
INSERT INTO `cto_download_trans` VALUES(18, 65);
INSERT INTO `cto_download_trans` VALUES(18, 66);
INSERT INTO `cto_download_trans` VALUES(18, 67);
INSERT INTO `cto_download_trans` VALUES(18, 68);
INSERT INTO `cto_download_trans` VALUES(18, 69);
INSERT INTO `cto_download_trans` VALUES(18, 70);
INSERT INTO `cto_download_trans` VALUES(18, 71);
INSERT INTO `cto_download_trans` VALUES(18, 72);
INSERT INTO `cto_download_trans` VALUES(18, 73);
INSERT INTO `cto_download_trans` VALUES(18, 74);
INSERT INTO `cto_download_trans` VALUES(18, 75);
INSERT INTO `cto_download_trans` VALUES(18, 76);
INSERT INTO `cto_download_trans` VALUES(18, 77);
INSERT INTO `cto_download_trans` VALUES(18, 78);
INSERT INTO `cto_download_trans` VALUES(18, 79);
INSERT INTO `cto_download_trans` VALUES(18, 80);
INSERT INTO `cto_download_trans` VALUES(18, 81);
INSERT INTO `cto_download_trans` VALUES(18, 82);
INSERT INTO `cto_download_trans` VALUES(18, 83);
INSERT INTO `cto_download_trans` VALUES(18, 84);
INSERT INTO `cto_download_trans` VALUES(18, 85);
INSERT INTO `cto_download_trans` VALUES(18, 86);
INSERT INTO `cto_download_trans` VALUES(18, 87);
INSERT INTO `cto_download_trans` VALUES(18, 88);
INSERT INTO `cto_download_trans` VALUES(18, 89);
INSERT INTO `cto_download_trans` VALUES(18, 90);
INSERT INTO `cto_download_trans` VALUES(18, 91);
INSERT INTO `cto_download_trans` VALUES(18, 92);
INSERT INTO `cto_download_trans` VALUES(18, 93);
INSERT INTO `cto_download_trans` VALUES(18, 94);
INSERT INTO `cto_download_trans` VALUES(18, 95);
INSERT INTO `cto_download_trans` VALUES(18, 96);
INSERT INTO `cto_download_trans` VALUES(18, 97);
INSERT INTO `cto_download_trans` VALUES(18, 98);
INSERT INTO `cto_download_trans` VALUES(18, 99);
INSERT INTO `cto_download_trans` VALUES(18, 100);
INSERT INTO `cto_download_trans` VALUES(18, 101);
INSERT INTO `cto_download_trans` VALUES(18, 102);
INSERT INTO `cto_download_trans` VALUES(18, 103);
INSERT INTO `cto_download_trans` VALUES(18, 104);
INSERT INTO `cto_download_trans` VALUES(18, 105);
INSERT INTO `cto_download_trans` VALUES(18, 106);
INSERT INTO `cto_download_trans` VALUES(18, 107);
INSERT INTO `cto_download_trans` VALUES(18, 108);
INSERT INTO `cto_download_trans` VALUES(18, 109);
INSERT INTO `cto_download_trans` VALUES(18, 110);
INSERT INTO `cto_download_trans` VALUES(18, 111);
INSERT INTO `cto_download_trans` VALUES(18, 112);
INSERT INTO `cto_download_trans` VALUES(18, 113);
INSERT INTO `cto_download_trans` VALUES(18, 114);
INSERT INTO `cto_download_trans` VALUES(18, 115);
INSERT INTO `cto_download_trans` VALUES(18, 116);
INSERT INTO `cto_download_trans` VALUES(18, 117);
INSERT INTO `cto_download_trans` VALUES(18, 118);
INSERT INTO `cto_download_trans` VALUES(18, 119);
INSERT INTO `cto_download_trans` VALUES(18, 120);
INSERT INTO `cto_download_trans` VALUES(18, 121);
INSERT INTO `cto_download_trans` VALUES(18, 122);
INSERT INTO `cto_download_trans` VALUES(18, 123);
INSERT INTO `cto_download_trans` VALUES(19, 1);
INSERT INTO `cto_download_trans` VALUES(19, 2);
INSERT INTO `cto_download_trans` VALUES(19, 3);
INSERT INTO `cto_download_trans` VALUES(19, 4);
INSERT INTO `cto_download_trans` VALUES(19, 5);
INSERT INTO `cto_download_trans` VALUES(19, 6);
INSERT INTO `cto_download_trans` VALUES(19, 7);
INSERT INTO `cto_download_trans` VALUES(19, 8);
INSERT INTO `cto_download_trans` VALUES(19, 9);
INSERT INTO `cto_download_trans` VALUES(19, 10);
INSERT INTO `cto_download_trans` VALUES(19, 11);
INSERT INTO `cto_download_trans` VALUES(19, 12);
INSERT INTO `cto_download_trans` VALUES(19, 13);
INSERT INTO `cto_download_trans` VALUES(19, 14);
INSERT INTO `cto_download_trans` VALUES(19, 15);
INSERT INTO `cto_download_trans` VALUES(19, 16);
INSERT INTO `cto_download_trans` VALUES(19, 17);
INSERT INTO `cto_download_trans` VALUES(19, 18);
INSERT INTO `cto_download_trans` VALUES(19, 19);
INSERT INTO `cto_download_trans` VALUES(19, 20);
INSERT INTO `cto_download_trans` VALUES(19, 21);
INSERT INTO `cto_download_trans` VALUES(19, 22);
INSERT INTO `cto_download_trans` VALUES(19, 23);
INSERT INTO `cto_download_trans` VALUES(19, 24);
INSERT INTO `cto_download_trans` VALUES(19, 25);
INSERT INTO `cto_download_trans` VALUES(19, 26);
INSERT INTO `cto_download_trans` VALUES(19, 27);
INSERT INTO `cto_download_trans` VALUES(19, 28);
INSERT INTO `cto_download_trans` VALUES(19, 29);
INSERT INTO `cto_download_trans` VALUES(19, 30);
INSERT INTO `cto_download_trans` VALUES(19, 31);
INSERT INTO `cto_download_trans` VALUES(19, 32);
INSERT INTO `cto_download_trans` VALUES(19, 33);
INSERT INTO `cto_download_trans` VALUES(19, 34);
INSERT INTO `cto_download_trans` VALUES(19, 35);
INSERT INTO `cto_download_trans` VALUES(19, 36);
INSERT INTO `cto_download_trans` VALUES(19, 37);
INSERT INTO `cto_download_trans` VALUES(19, 38);
INSERT INTO `cto_download_trans` VALUES(19, 39);
INSERT INTO `cto_download_trans` VALUES(19, 40);
INSERT INTO `cto_download_trans` VALUES(19, 41);
INSERT INTO `cto_download_trans` VALUES(19, 42);
INSERT INTO `cto_download_trans` VALUES(19, 43);
INSERT INTO `cto_download_trans` VALUES(19, 44);
INSERT INTO `cto_download_trans` VALUES(19, 45);
INSERT INTO `cto_download_trans` VALUES(19, 46);
INSERT INTO `cto_download_trans` VALUES(19, 47);
INSERT INTO `cto_download_trans` VALUES(19, 48);
INSERT INTO `cto_download_trans` VALUES(19, 49);
INSERT INTO `cto_download_trans` VALUES(19, 50);
INSERT INTO `cto_download_trans` VALUES(19, 51);
INSERT INTO `cto_download_trans` VALUES(19, 52);
INSERT INTO `cto_download_trans` VALUES(19, 53);
INSERT INTO `cto_download_trans` VALUES(19, 54);
INSERT INTO `cto_download_trans` VALUES(19, 55);
INSERT INTO `cto_download_trans` VALUES(19, 56);
INSERT INTO `cto_download_trans` VALUES(19, 57);
INSERT INTO `cto_download_trans` VALUES(19, 58);
INSERT INTO `cto_download_trans` VALUES(19, 59);
INSERT INTO `cto_download_trans` VALUES(19, 60);
INSERT INTO `cto_download_trans` VALUES(19, 61);
INSERT INTO `cto_download_trans` VALUES(19, 62);
INSERT INTO `cto_download_trans` VALUES(19, 63);
INSERT INTO `cto_download_trans` VALUES(19, 64);
INSERT INTO `cto_download_trans` VALUES(19, 65);
INSERT INTO `cto_download_trans` VALUES(19, 66);
INSERT INTO `cto_download_trans` VALUES(19, 67);
INSERT INTO `cto_download_trans` VALUES(19, 68);
INSERT INTO `cto_download_trans` VALUES(19, 69);
INSERT INTO `cto_download_trans` VALUES(19, 70);
INSERT INTO `cto_download_trans` VALUES(19, 71);
INSERT INTO `cto_download_trans` VALUES(19, 72);
INSERT INTO `cto_download_trans` VALUES(19, 73);
INSERT INTO `cto_download_trans` VALUES(19, 74);
INSERT INTO `cto_download_trans` VALUES(19, 75);
INSERT INTO `cto_download_trans` VALUES(19, 76);
INSERT INTO `cto_download_trans` VALUES(19, 77);
INSERT INTO `cto_download_trans` VALUES(19, 78);
INSERT INTO `cto_download_trans` VALUES(19, 79);
INSERT INTO `cto_download_trans` VALUES(19, 80);
INSERT INTO `cto_download_trans` VALUES(19, 81);
INSERT INTO `cto_download_trans` VALUES(19, 82);
INSERT INTO `cto_download_trans` VALUES(19, 83);
INSERT INTO `cto_download_trans` VALUES(19, 84);
INSERT INTO `cto_download_trans` VALUES(19, 85);
INSERT INTO `cto_download_trans` VALUES(19, 86);
INSERT INTO `cto_download_trans` VALUES(19, 87);
INSERT INTO `cto_download_trans` VALUES(19, 88);
INSERT INTO `cto_download_trans` VALUES(19, 89);
INSERT INTO `cto_download_trans` VALUES(19, 90);
INSERT INTO `cto_download_trans` VALUES(19, 91);
INSERT INTO `cto_download_trans` VALUES(19, 92);
INSERT INTO `cto_download_trans` VALUES(19, 93);
INSERT INTO `cto_download_trans` VALUES(19, 94);
INSERT INTO `cto_download_trans` VALUES(19, 95);
INSERT INTO `cto_download_trans` VALUES(19, 96);
INSERT INTO `cto_download_trans` VALUES(19, 97);
INSERT INTO `cto_download_trans` VALUES(19, 98);
INSERT INTO `cto_download_trans` VALUES(19, 99);
INSERT INTO `cto_download_trans` VALUES(19, 100);
INSERT INTO `cto_download_trans` VALUES(19, 101);
INSERT INTO `cto_download_trans` VALUES(19, 102);
INSERT INTO `cto_download_trans` VALUES(19, 103);
INSERT INTO `cto_download_trans` VALUES(19, 104);
INSERT INTO `cto_download_trans` VALUES(19, 105);
INSERT INTO `cto_download_trans` VALUES(19, 106);
INSERT INTO `cto_download_trans` VALUES(19, 107);
INSERT INTO `cto_download_trans` VALUES(19, 108);
INSERT INTO `cto_download_trans` VALUES(19, 109);
INSERT INTO `cto_download_trans` VALUES(19, 110);
INSERT INTO `cto_download_trans` VALUES(19, 111);
INSERT INTO `cto_download_trans` VALUES(19, 112);
INSERT INTO `cto_download_trans` VALUES(19, 113);
INSERT INTO `cto_download_trans` VALUES(19, 114);
INSERT INTO `cto_download_trans` VALUES(19, 115);
INSERT INTO `cto_download_trans` VALUES(19, 116);
INSERT INTO `cto_download_trans` VALUES(19, 117);
INSERT INTO `cto_download_trans` VALUES(19, 118);
INSERT INTO `cto_download_trans` VALUES(19, 119);
INSERT INTO `cto_download_trans` VALUES(19, 120);
INSERT INTO `cto_download_trans` VALUES(19, 121);
INSERT INTO `cto_download_trans` VALUES(19, 122);
INSERT INTO `cto_download_trans` VALUES(19, 123);
INSERT INTO `cto_download_trans` VALUES(19, 124);
INSERT INTO `cto_download_trans` VALUES(20, 1);
INSERT INTO `cto_download_trans` VALUES(20, 4);
INSERT INTO `cto_download_trans` VALUES(20, 5);
INSERT INTO `cto_download_trans` VALUES(20, 6);
INSERT INTO `cto_download_trans` VALUES(20, 7);
INSERT INTO `cto_download_trans` VALUES(20, 8);
INSERT INTO `cto_download_trans` VALUES(20, 9);
INSERT INTO `cto_download_trans` VALUES(20, 10);
INSERT INTO `cto_download_trans` VALUES(20, 11);
INSERT INTO `cto_download_trans` VALUES(20, 12);
INSERT INTO `cto_download_trans` VALUES(20, 13);
INSERT INTO `cto_download_trans` VALUES(20, 14);
INSERT INTO `cto_download_trans` VALUES(20, 15);
INSERT INTO `cto_download_trans` VALUES(20, 16);
INSERT INTO `cto_download_trans` VALUES(20, 17);
INSERT INTO `cto_download_trans` VALUES(20, 18);
INSERT INTO `cto_download_trans` VALUES(20, 19);
INSERT INTO `cto_download_trans` VALUES(20, 20);
INSERT INTO `cto_download_trans` VALUES(20, 21);
INSERT INTO `cto_download_trans` VALUES(20, 22);
INSERT INTO `cto_download_trans` VALUES(20, 123);
INSERT INTO `cto_download_trans` VALUES(21, 1);
INSERT INTO `cto_download_trans` VALUES(21, 2);
INSERT INTO `cto_download_trans` VALUES(21, 3);
INSERT INTO `cto_download_trans` VALUES(21, 4);
INSERT INTO `cto_download_trans` VALUES(21, 5);
INSERT INTO `cto_download_trans` VALUES(21, 6);
INSERT INTO `cto_download_trans` VALUES(21, 7);
INSERT INTO `cto_download_trans` VALUES(21, 8);
INSERT INTO `cto_download_trans` VALUES(21, 9);
INSERT INTO `cto_download_trans` VALUES(21, 10);
INSERT INTO `cto_download_trans` VALUES(21, 11);
INSERT INTO `cto_download_trans` VALUES(21, 12);
INSERT INTO `cto_download_trans` VALUES(21, 13);
INSERT INTO `cto_download_trans` VALUES(21, 14);
INSERT INTO `cto_download_trans` VALUES(21, 15);
INSERT INTO `cto_download_trans` VALUES(21, 16);
INSERT INTO `cto_download_trans` VALUES(21, 17);
INSERT INTO `cto_download_trans` VALUES(21, 18);
INSERT INTO `cto_download_trans` VALUES(21, 19);
INSERT INTO `cto_download_trans` VALUES(21, 20);
INSERT INTO `cto_download_trans` VALUES(21, 21);
INSERT INTO `cto_download_trans` VALUES(21, 22);
INSERT INTO `cto_download_trans` VALUES(21, 23);
INSERT INTO `cto_download_trans` VALUES(21, 24);
INSERT INTO `cto_download_trans` VALUES(21, 25);
INSERT INTO `cto_download_trans` VALUES(21, 26);
INSERT INTO `cto_download_trans` VALUES(21, 27);
INSERT INTO `cto_download_trans` VALUES(21, 28);
INSERT INTO `cto_download_trans` VALUES(21, 29);
INSERT INTO `cto_download_trans` VALUES(21, 30);
INSERT INTO `cto_download_trans` VALUES(21, 31);
INSERT INTO `cto_download_trans` VALUES(21, 32);
INSERT INTO `cto_download_trans` VALUES(21, 33);
INSERT INTO `cto_download_trans` VALUES(21, 34);
INSERT INTO `cto_download_trans` VALUES(21, 35);
INSERT INTO `cto_download_trans` VALUES(21, 36);
INSERT INTO `cto_download_trans` VALUES(21, 37);
INSERT INTO `cto_download_trans` VALUES(21, 38);
INSERT INTO `cto_download_trans` VALUES(21, 39);
INSERT INTO `cto_download_trans` VALUES(21, 40);
INSERT INTO `cto_download_trans` VALUES(21, 41);
INSERT INTO `cto_download_trans` VALUES(21, 42);
INSERT INTO `cto_download_trans` VALUES(21, 43);
INSERT INTO `cto_download_trans` VALUES(21, 44);
INSERT INTO `cto_download_trans` VALUES(21, 45);
INSERT INTO `cto_download_trans` VALUES(21, 46);
INSERT INTO `cto_download_trans` VALUES(21, 47);
INSERT INTO `cto_download_trans` VALUES(21, 48);
INSERT INTO `cto_download_trans` VALUES(21, 49);
INSERT INTO `cto_download_trans` VALUES(21, 50);
INSERT INTO `cto_download_trans` VALUES(21, 51);
INSERT INTO `cto_download_trans` VALUES(21, 52);
INSERT INTO `cto_download_trans` VALUES(21, 53);
INSERT INTO `cto_download_trans` VALUES(21, 54);
INSERT INTO `cto_download_trans` VALUES(21, 55);
INSERT INTO `cto_download_trans` VALUES(21, 56);
INSERT INTO `cto_download_trans` VALUES(21, 57);
INSERT INTO `cto_download_trans` VALUES(21, 58);
INSERT INTO `cto_download_trans` VALUES(21, 59);
INSERT INTO `cto_download_trans` VALUES(21, 60);
INSERT INTO `cto_download_trans` VALUES(21, 61);
INSERT INTO `cto_download_trans` VALUES(21, 62);
INSERT INTO `cto_download_trans` VALUES(21, 63);
INSERT INTO `cto_download_trans` VALUES(21, 64);
INSERT INTO `cto_download_trans` VALUES(21, 65);
INSERT INTO `cto_download_trans` VALUES(21, 66);
INSERT INTO `cto_download_trans` VALUES(21, 67);
INSERT INTO `cto_download_trans` VALUES(21, 68);
INSERT INTO `cto_download_trans` VALUES(21, 69);
INSERT INTO `cto_download_trans` VALUES(21, 70);
INSERT INTO `cto_download_trans` VALUES(21, 71);
INSERT INTO `cto_download_trans` VALUES(21, 72);
INSERT INTO `cto_download_trans` VALUES(21, 73);
INSERT INTO `cto_download_trans` VALUES(21, 74);
INSERT INTO `cto_download_trans` VALUES(21, 75);
INSERT INTO `cto_download_trans` VALUES(21, 76);
INSERT INTO `cto_download_trans` VALUES(21, 77);
INSERT INTO `cto_download_trans` VALUES(21, 78);
INSERT INTO `cto_download_trans` VALUES(21, 79);
INSERT INTO `cto_download_trans` VALUES(21, 80);
INSERT INTO `cto_download_trans` VALUES(21, 81);
INSERT INTO `cto_download_trans` VALUES(21, 82);
INSERT INTO `cto_download_trans` VALUES(21, 83);
INSERT INTO `cto_download_trans` VALUES(21, 84);
INSERT INTO `cto_download_trans` VALUES(21, 85);
INSERT INTO `cto_download_trans` VALUES(21, 86);
INSERT INTO `cto_download_trans` VALUES(21, 87);
INSERT INTO `cto_download_trans` VALUES(21, 88);
INSERT INTO `cto_download_trans` VALUES(21, 89);
INSERT INTO `cto_download_trans` VALUES(21, 90);
INSERT INTO `cto_download_trans` VALUES(21, 91);
INSERT INTO `cto_download_trans` VALUES(21, 92);
INSERT INTO `cto_download_trans` VALUES(21, 93);
INSERT INTO `cto_download_trans` VALUES(21, 94);
INSERT INTO `cto_download_trans` VALUES(21, 95);
INSERT INTO `cto_download_trans` VALUES(21, 96);
INSERT INTO `cto_download_trans` VALUES(21, 97);
INSERT INTO `cto_download_trans` VALUES(21, 98);
INSERT INTO `cto_download_trans` VALUES(21, 99);
INSERT INTO `cto_download_trans` VALUES(21, 100);
INSERT INTO `cto_download_trans` VALUES(21, 101);
INSERT INTO `cto_download_trans` VALUES(21, 102);
INSERT INTO `cto_download_trans` VALUES(21, 103);
INSERT INTO `cto_download_trans` VALUES(21, 104);
INSERT INTO `cto_download_trans` VALUES(21, 105);
INSERT INTO `cto_download_trans` VALUES(21, 106);
INSERT INTO `cto_download_trans` VALUES(21, 107);
INSERT INTO `cto_download_trans` VALUES(21, 108);
INSERT INTO `cto_download_trans` VALUES(21, 109);
INSERT INTO `cto_download_trans` VALUES(21, 110);
INSERT INTO `cto_download_trans` VALUES(21, 111);
INSERT INTO `cto_download_trans` VALUES(21, 112);
INSERT INTO `cto_download_trans` VALUES(21, 113);
INSERT INTO `cto_download_trans` VALUES(21, 114);
INSERT INTO `cto_download_trans` VALUES(21, 115);
INSERT INTO `cto_download_trans` VALUES(21, 116);
INSERT INTO `cto_download_trans` VALUES(21, 117);
INSERT INTO `cto_download_trans` VALUES(21, 118);
INSERT INTO `cto_download_trans` VALUES(21, 119);
INSERT INTO `cto_download_trans` VALUES(21, 120);
INSERT INTO `cto_download_trans` VALUES(21, 121);
INSERT INTO `cto_download_trans` VALUES(21, 122);
INSERT INTO `cto_download_trans` VALUES(21, 123);
INSERT INTO `cto_download_trans` VALUES(21, 129);
INSERT INTO `cto_download_trans` VALUES(21, 130);
INSERT INTO `cto_download_trans` VALUES(22, 6);
INSERT INTO `cto_download_trans` VALUES(22, 67);
INSERT INTO `cto_download_trans` VALUES(23, 5);
INSERT INTO `cto_download_trans` VALUES(23, 67);
INSERT INTO `cto_download_trans` VALUES(24, 1);
INSERT INTO `cto_download_trans` VALUES(24, 2);
INSERT INTO `cto_download_trans` VALUES(24, 3);
INSERT INTO `cto_download_trans` VALUES(24, 4);
INSERT INTO `cto_download_trans` VALUES(24, 5);
INSERT INTO `cto_download_trans` VALUES(24, 6);
INSERT INTO `cto_download_trans` VALUES(24, 7);
INSERT INTO `cto_download_trans` VALUES(24, 8);
INSERT INTO `cto_download_trans` VALUES(24, 9);
INSERT INTO `cto_download_trans` VALUES(24, 10);
INSERT INTO `cto_download_trans` VALUES(24, 11);
INSERT INTO `cto_download_trans` VALUES(24, 12);
INSERT INTO `cto_download_trans` VALUES(24, 13);
INSERT INTO `cto_download_trans` VALUES(24, 14);
INSERT INTO `cto_download_trans` VALUES(24, 15);
INSERT INTO `cto_download_trans` VALUES(24, 16);
INSERT INTO `cto_download_trans` VALUES(24, 17);
INSERT INTO `cto_download_trans` VALUES(24, 18);
INSERT INTO `cto_download_trans` VALUES(24, 19);
INSERT INTO `cto_download_trans` VALUES(24, 20);
INSERT INTO `cto_download_trans` VALUES(24, 21);
INSERT INTO `cto_download_trans` VALUES(24, 22);
INSERT INTO `cto_download_trans` VALUES(24, 23);
INSERT INTO `cto_download_trans` VALUES(24, 24);
INSERT INTO `cto_download_trans` VALUES(24, 25);
INSERT INTO `cto_download_trans` VALUES(24, 26);
INSERT INTO `cto_download_trans` VALUES(24, 27);
INSERT INTO `cto_download_trans` VALUES(24, 28);
INSERT INTO `cto_download_trans` VALUES(24, 29);
INSERT INTO `cto_download_trans` VALUES(24, 30);
INSERT INTO `cto_download_trans` VALUES(24, 31);
INSERT INTO `cto_download_trans` VALUES(24, 32);
INSERT INTO `cto_download_trans` VALUES(24, 33);
INSERT INTO `cto_download_trans` VALUES(24, 34);
INSERT INTO `cto_download_trans` VALUES(24, 35);
INSERT INTO `cto_download_trans` VALUES(24, 36);
INSERT INTO `cto_download_trans` VALUES(24, 37);
INSERT INTO `cto_download_trans` VALUES(24, 38);
INSERT INTO `cto_download_trans` VALUES(24, 39);
INSERT INTO `cto_download_trans` VALUES(24, 40);
INSERT INTO `cto_download_trans` VALUES(24, 41);
INSERT INTO `cto_download_trans` VALUES(24, 42);
INSERT INTO `cto_download_trans` VALUES(24, 43);
INSERT INTO `cto_download_trans` VALUES(24, 44);
INSERT INTO `cto_download_trans` VALUES(24, 45);
INSERT INTO `cto_download_trans` VALUES(24, 46);
INSERT INTO `cto_download_trans` VALUES(24, 47);
INSERT INTO `cto_download_trans` VALUES(24, 48);
INSERT INTO `cto_download_trans` VALUES(24, 49);
INSERT INTO `cto_download_trans` VALUES(24, 50);
INSERT INTO `cto_download_trans` VALUES(24, 51);
INSERT INTO `cto_download_trans` VALUES(24, 52);
INSERT INTO `cto_download_trans` VALUES(24, 53);
INSERT INTO `cto_download_trans` VALUES(24, 54);
INSERT INTO `cto_download_trans` VALUES(24, 55);
INSERT INTO `cto_download_trans` VALUES(24, 56);
INSERT INTO `cto_download_trans` VALUES(24, 57);
INSERT INTO `cto_download_trans` VALUES(24, 58);
INSERT INTO `cto_download_trans` VALUES(24, 59);
INSERT INTO `cto_download_trans` VALUES(24, 60);
INSERT INTO `cto_download_trans` VALUES(24, 61);
INSERT INTO `cto_download_trans` VALUES(24, 62);
INSERT INTO `cto_download_trans` VALUES(24, 63);
INSERT INTO `cto_download_trans` VALUES(24, 64);
INSERT INTO `cto_download_trans` VALUES(24, 65);
INSERT INTO `cto_download_trans` VALUES(24, 66);
INSERT INTO `cto_download_trans` VALUES(24, 67);
INSERT INTO `cto_download_trans` VALUES(24, 68);
INSERT INTO `cto_download_trans` VALUES(24, 69);
INSERT INTO `cto_download_trans` VALUES(24, 70);
INSERT INTO `cto_download_trans` VALUES(24, 71);
INSERT INTO `cto_download_trans` VALUES(24, 72);
INSERT INTO `cto_download_trans` VALUES(24, 73);
INSERT INTO `cto_download_trans` VALUES(24, 74);
INSERT INTO `cto_download_trans` VALUES(24, 75);
INSERT INTO `cto_download_trans` VALUES(24, 76);
INSERT INTO `cto_download_trans` VALUES(24, 77);
INSERT INTO `cto_download_trans` VALUES(24, 78);
INSERT INTO `cto_download_trans` VALUES(24, 79);
INSERT INTO `cto_download_trans` VALUES(24, 80);
INSERT INTO `cto_download_trans` VALUES(24, 81);
INSERT INTO `cto_download_trans` VALUES(24, 82);
INSERT INTO `cto_download_trans` VALUES(24, 83);
INSERT INTO `cto_download_trans` VALUES(24, 84);
INSERT INTO `cto_download_trans` VALUES(24, 85);
INSERT INTO `cto_download_trans` VALUES(24, 86);
INSERT INTO `cto_download_trans` VALUES(24, 87);
INSERT INTO `cto_download_trans` VALUES(24, 88);
INSERT INTO `cto_download_trans` VALUES(24, 89);
INSERT INTO `cto_download_trans` VALUES(24, 90);
INSERT INTO `cto_download_trans` VALUES(24, 91);
INSERT INTO `cto_download_trans` VALUES(24, 92);
INSERT INTO `cto_download_trans` VALUES(24, 93);
INSERT INTO `cto_download_trans` VALUES(24, 94);
INSERT INTO `cto_download_trans` VALUES(24, 95);
INSERT INTO `cto_download_trans` VALUES(24, 96);
INSERT INTO `cto_download_trans` VALUES(24, 97);
INSERT INTO `cto_download_trans` VALUES(24, 98);
INSERT INTO `cto_download_trans` VALUES(24, 99);
INSERT INTO `cto_download_trans` VALUES(24, 100);
INSERT INTO `cto_download_trans` VALUES(24, 101);
INSERT INTO `cto_download_trans` VALUES(24, 102);
INSERT INTO `cto_download_trans` VALUES(24, 103);
INSERT INTO `cto_download_trans` VALUES(24, 104);
INSERT INTO `cto_download_trans` VALUES(24, 105);
INSERT INTO `cto_download_trans` VALUES(24, 106);
INSERT INTO `cto_download_trans` VALUES(24, 107);
INSERT INTO `cto_download_trans` VALUES(24, 108);
INSERT INTO `cto_download_trans` VALUES(24, 109);
INSERT INTO `cto_download_trans` VALUES(24, 110);
INSERT INTO `cto_download_trans` VALUES(24, 111);
INSERT INTO `cto_download_trans` VALUES(24, 112);
INSERT INTO `cto_download_trans` VALUES(24, 113);
INSERT INTO `cto_download_trans` VALUES(24, 114);
INSERT INTO `cto_download_trans` VALUES(24, 115);
INSERT INTO `cto_download_trans` VALUES(24, 116);
INSERT INTO `cto_download_trans` VALUES(24, 117);
INSERT INTO `cto_download_trans` VALUES(24, 118);
INSERT INTO `cto_download_trans` VALUES(24, 119);
INSERT INTO `cto_download_trans` VALUES(24, 120);
INSERT INTO `cto_download_trans` VALUES(24, 121);
INSERT INTO `cto_download_trans` VALUES(24, 122);
INSERT INTO `cto_download_trans` VALUES(24, 123);
INSERT INTO `cto_download_trans` VALUES(24, 129);
INSERT INTO `cto_download_trans` VALUES(24, 130);
INSERT INTO `cto_download_trans` VALUES(25, 1);
INSERT INTO `cto_download_trans` VALUES(25, 2);
INSERT INTO `cto_download_trans` VALUES(25, 3);
INSERT INTO `cto_download_trans` VALUES(25, 4);
INSERT INTO `cto_download_trans` VALUES(25, 5);
INSERT INTO `cto_download_trans` VALUES(25, 6);
INSERT INTO `cto_download_trans` VALUES(25, 7);
INSERT INTO `cto_download_trans` VALUES(25, 8);
INSERT INTO `cto_download_trans` VALUES(25, 9);
INSERT INTO `cto_download_trans` VALUES(25, 10);
INSERT INTO `cto_download_trans` VALUES(25, 11);
INSERT INTO `cto_download_trans` VALUES(25, 12);
INSERT INTO `cto_download_trans` VALUES(25, 13);
INSERT INTO `cto_download_trans` VALUES(25, 14);
INSERT INTO `cto_download_trans` VALUES(25, 15);
INSERT INTO `cto_download_trans` VALUES(25, 16);
INSERT INTO `cto_download_trans` VALUES(25, 17);
INSERT INTO `cto_download_trans` VALUES(25, 18);
INSERT INTO `cto_download_trans` VALUES(25, 19);
INSERT INTO `cto_download_trans` VALUES(25, 20);
INSERT INTO `cto_download_trans` VALUES(25, 21);
INSERT INTO `cto_download_trans` VALUES(25, 22);
INSERT INTO `cto_download_trans` VALUES(25, 23);
INSERT INTO `cto_download_trans` VALUES(25, 24);
INSERT INTO `cto_download_trans` VALUES(25, 25);
INSERT INTO `cto_download_trans` VALUES(25, 26);
INSERT INTO `cto_download_trans` VALUES(25, 27);
INSERT INTO `cto_download_trans` VALUES(25, 28);
INSERT INTO `cto_download_trans` VALUES(25, 29);
INSERT INTO `cto_download_trans` VALUES(25, 30);
INSERT INTO `cto_download_trans` VALUES(25, 31);
INSERT INTO `cto_download_trans` VALUES(25, 32);
INSERT INTO `cto_download_trans` VALUES(25, 33);
INSERT INTO `cto_download_trans` VALUES(25, 34);
INSERT INTO `cto_download_trans` VALUES(25, 35);
INSERT INTO `cto_download_trans` VALUES(25, 36);
INSERT INTO `cto_download_trans` VALUES(25, 37);
INSERT INTO `cto_download_trans` VALUES(25, 38);
INSERT INTO `cto_download_trans` VALUES(25, 39);
INSERT INTO `cto_download_trans` VALUES(25, 40);
INSERT INTO `cto_download_trans` VALUES(25, 41);
INSERT INTO `cto_download_trans` VALUES(25, 42);
INSERT INTO `cto_download_trans` VALUES(25, 43);
INSERT INTO `cto_download_trans` VALUES(25, 44);
INSERT INTO `cto_download_trans` VALUES(25, 45);
INSERT INTO `cto_download_trans` VALUES(25, 46);
INSERT INTO `cto_download_trans` VALUES(25, 47);
INSERT INTO `cto_download_trans` VALUES(25, 48);
INSERT INTO `cto_download_trans` VALUES(25, 49);
INSERT INTO `cto_download_trans` VALUES(25, 50);
INSERT INTO `cto_download_trans` VALUES(25, 51);
INSERT INTO `cto_download_trans` VALUES(25, 52);
INSERT INTO `cto_download_trans` VALUES(25, 53);
INSERT INTO `cto_download_trans` VALUES(25, 54);
INSERT INTO `cto_download_trans` VALUES(25, 55);
INSERT INTO `cto_download_trans` VALUES(25, 56);
INSERT INTO `cto_download_trans` VALUES(25, 57);
INSERT INTO `cto_download_trans` VALUES(25, 58);
INSERT INTO `cto_download_trans` VALUES(25, 59);
INSERT INTO `cto_download_trans` VALUES(25, 60);
INSERT INTO `cto_download_trans` VALUES(25, 61);
INSERT INTO `cto_download_trans` VALUES(25, 62);
INSERT INTO `cto_download_trans` VALUES(25, 63);
INSERT INTO `cto_download_trans` VALUES(25, 64);
INSERT INTO `cto_download_trans` VALUES(25, 65);
INSERT INTO `cto_download_trans` VALUES(25, 66);
INSERT INTO `cto_download_trans` VALUES(25, 67);
INSERT INTO `cto_download_trans` VALUES(25, 68);
INSERT INTO `cto_download_trans` VALUES(25, 69);
INSERT INTO `cto_download_trans` VALUES(25, 70);
INSERT INTO `cto_download_trans` VALUES(25, 71);
INSERT INTO `cto_download_trans` VALUES(25, 72);
INSERT INTO `cto_download_trans` VALUES(25, 73);
INSERT INTO `cto_download_trans` VALUES(25, 74);
INSERT INTO `cto_download_trans` VALUES(25, 75);
INSERT INTO `cto_download_trans` VALUES(25, 76);
INSERT INTO `cto_download_trans` VALUES(25, 77);
INSERT INTO `cto_download_trans` VALUES(25, 78);
INSERT INTO `cto_download_trans` VALUES(25, 79);
INSERT INTO `cto_download_trans` VALUES(25, 80);
INSERT INTO `cto_download_trans` VALUES(25, 81);
INSERT INTO `cto_download_trans` VALUES(25, 82);
INSERT INTO `cto_download_trans` VALUES(25, 83);
INSERT INTO `cto_download_trans` VALUES(25, 84);
INSERT INTO `cto_download_trans` VALUES(25, 85);
INSERT INTO `cto_download_trans` VALUES(25, 86);
INSERT INTO `cto_download_trans` VALUES(25, 87);
INSERT INTO `cto_download_trans` VALUES(25, 88);
INSERT INTO `cto_download_trans` VALUES(25, 89);
INSERT INTO `cto_download_trans` VALUES(25, 90);
INSERT INTO `cto_download_trans` VALUES(25, 91);
INSERT INTO `cto_download_trans` VALUES(25, 92);
INSERT INTO `cto_download_trans` VALUES(25, 93);
INSERT INTO `cto_download_trans` VALUES(25, 94);
INSERT INTO `cto_download_trans` VALUES(25, 95);
INSERT INTO `cto_download_trans` VALUES(25, 96);
INSERT INTO `cto_download_trans` VALUES(25, 97);
INSERT INTO `cto_download_trans` VALUES(25, 98);
INSERT INTO `cto_download_trans` VALUES(25, 99);
INSERT INTO `cto_download_trans` VALUES(25, 100);
INSERT INTO `cto_download_trans` VALUES(25, 101);
INSERT INTO `cto_download_trans` VALUES(25, 102);
INSERT INTO `cto_download_trans` VALUES(25, 103);
INSERT INTO `cto_download_trans` VALUES(25, 104);
INSERT INTO `cto_download_trans` VALUES(25, 105);
INSERT INTO `cto_download_trans` VALUES(25, 106);
INSERT INTO `cto_download_trans` VALUES(25, 107);
INSERT INTO `cto_download_trans` VALUES(25, 108);
INSERT INTO `cto_download_trans` VALUES(25, 109);
INSERT INTO `cto_download_trans` VALUES(25, 110);
INSERT INTO `cto_download_trans` VALUES(25, 111);
INSERT INTO `cto_download_trans` VALUES(25, 112);
INSERT INTO `cto_download_trans` VALUES(25, 113);
INSERT INTO `cto_download_trans` VALUES(25, 114);
INSERT INTO `cto_download_trans` VALUES(25, 115);
INSERT INTO `cto_download_trans` VALUES(25, 116);
INSERT INTO `cto_download_trans` VALUES(25, 117);
INSERT INTO `cto_download_trans` VALUES(25, 118);
INSERT INTO `cto_download_trans` VALUES(25, 119);
INSERT INTO `cto_download_trans` VALUES(25, 120);
INSERT INTO `cto_download_trans` VALUES(25, 121);
INSERT INTO `cto_download_trans` VALUES(25, 122);
INSERT INTO `cto_download_trans` VALUES(25, 123);
INSERT INTO `cto_download_trans` VALUES(25, 129);
INSERT INTO `cto_download_trans` VALUES(25, 130);
INSERT INTO `cto_download_trans` VALUES(26, 1);
INSERT INTO `cto_download_trans` VALUES(26, 2);
INSERT INTO `cto_download_trans` VALUES(26, 3);
INSERT INTO `cto_download_trans` VALUES(26, 4);
INSERT INTO `cto_download_trans` VALUES(26, 5);
INSERT INTO `cto_download_trans` VALUES(26, 6);
INSERT INTO `cto_download_trans` VALUES(26, 7);
INSERT INTO `cto_download_trans` VALUES(26, 8);
INSERT INTO `cto_download_trans` VALUES(26, 9);
INSERT INTO `cto_download_trans` VALUES(26, 10);
INSERT INTO `cto_download_trans` VALUES(26, 11);
INSERT INTO `cto_download_trans` VALUES(26, 12);
INSERT INTO `cto_download_trans` VALUES(26, 13);
INSERT INTO `cto_download_trans` VALUES(26, 14);
INSERT INTO `cto_download_trans` VALUES(26, 15);
INSERT INTO `cto_download_trans` VALUES(26, 16);
INSERT INTO `cto_download_trans` VALUES(26, 17);
INSERT INTO `cto_download_trans` VALUES(26, 18);
INSERT INTO `cto_download_trans` VALUES(26, 19);
INSERT INTO `cto_download_trans` VALUES(26, 20);
INSERT INTO `cto_download_trans` VALUES(26, 21);
INSERT INTO `cto_download_trans` VALUES(26, 22);
INSERT INTO `cto_download_trans` VALUES(26, 23);
INSERT INTO `cto_download_trans` VALUES(26, 24);
INSERT INTO `cto_download_trans` VALUES(26, 25);
INSERT INTO `cto_download_trans` VALUES(26, 26);
INSERT INTO `cto_download_trans` VALUES(26, 27);
INSERT INTO `cto_download_trans` VALUES(26, 28);
INSERT INTO `cto_download_trans` VALUES(26, 29);
INSERT INTO `cto_download_trans` VALUES(26, 30);
INSERT INTO `cto_download_trans` VALUES(26, 31);
INSERT INTO `cto_download_trans` VALUES(26, 32);
INSERT INTO `cto_download_trans` VALUES(26, 33);
INSERT INTO `cto_download_trans` VALUES(26, 34);
INSERT INTO `cto_download_trans` VALUES(26, 35);
INSERT INTO `cto_download_trans` VALUES(26, 36);
INSERT INTO `cto_download_trans` VALUES(26, 37);
INSERT INTO `cto_download_trans` VALUES(26, 38);
INSERT INTO `cto_download_trans` VALUES(26, 39);
INSERT INTO `cto_download_trans` VALUES(26, 40);
INSERT INTO `cto_download_trans` VALUES(26, 41);
INSERT INTO `cto_download_trans` VALUES(26, 42);
INSERT INTO `cto_download_trans` VALUES(26, 43);
INSERT INTO `cto_download_trans` VALUES(26, 44);
INSERT INTO `cto_download_trans` VALUES(26, 45);
INSERT INTO `cto_download_trans` VALUES(26, 46);
INSERT INTO `cto_download_trans` VALUES(26, 47);
INSERT INTO `cto_download_trans` VALUES(26, 48);
INSERT INTO `cto_download_trans` VALUES(26, 49);
INSERT INTO `cto_download_trans` VALUES(26, 50);
INSERT INTO `cto_download_trans` VALUES(26, 51);
INSERT INTO `cto_download_trans` VALUES(26, 52);
INSERT INTO `cto_download_trans` VALUES(26, 53);
INSERT INTO `cto_download_trans` VALUES(26, 54);
INSERT INTO `cto_download_trans` VALUES(26, 55);
INSERT INTO `cto_download_trans` VALUES(26, 56);
INSERT INTO `cto_download_trans` VALUES(26, 57);
INSERT INTO `cto_download_trans` VALUES(26, 58);
INSERT INTO `cto_download_trans` VALUES(26, 59);
INSERT INTO `cto_download_trans` VALUES(26, 60);
INSERT INTO `cto_download_trans` VALUES(26, 61);
INSERT INTO `cto_download_trans` VALUES(26, 62);
INSERT INTO `cto_download_trans` VALUES(26, 63);
INSERT INTO `cto_download_trans` VALUES(26, 64);
INSERT INTO `cto_download_trans` VALUES(26, 65);
INSERT INTO `cto_download_trans` VALUES(26, 66);
INSERT INTO `cto_download_trans` VALUES(26, 67);
INSERT INTO `cto_download_trans` VALUES(26, 68);
INSERT INTO `cto_download_trans` VALUES(26, 69);
INSERT INTO `cto_download_trans` VALUES(26, 70);
INSERT INTO `cto_download_trans` VALUES(26, 71);
INSERT INTO `cto_download_trans` VALUES(26, 72);
INSERT INTO `cto_download_trans` VALUES(26, 73);
INSERT INTO `cto_download_trans` VALUES(26, 74);
INSERT INTO `cto_download_trans` VALUES(26, 75);
INSERT INTO `cto_download_trans` VALUES(26, 76);
INSERT INTO `cto_download_trans` VALUES(26, 77);
INSERT INTO `cto_download_trans` VALUES(26, 78);
INSERT INTO `cto_download_trans` VALUES(26, 79);
INSERT INTO `cto_download_trans` VALUES(26, 80);
INSERT INTO `cto_download_trans` VALUES(26, 81);
INSERT INTO `cto_download_trans` VALUES(26, 82);
INSERT INTO `cto_download_trans` VALUES(26, 83);
INSERT INTO `cto_download_trans` VALUES(26, 84);
INSERT INTO `cto_download_trans` VALUES(26, 85);
INSERT INTO `cto_download_trans` VALUES(26, 86);
INSERT INTO `cto_download_trans` VALUES(26, 87);
INSERT INTO `cto_download_trans` VALUES(26, 88);
INSERT INTO `cto_download_trans` VALUES(26, 89);
INSERT INTO `cto_download_trans` VALUES(26, 90);
INSERT INTO `cto_download_trans` VALUES(26, 91);
INSERT INTO `cto_download_trans` VALUES(26, 92);
INSERT INTO `cto_download_trans` VALUES(26, 93);
INSERT INTO `cto_download_trans` VALUES(26, 94);
INSERT INTO `cto_download_trans` VALUES(26, 95);
INSERT INTO `cto_download_trans` VALUES(26, 96);
INSERT INTO `cto_download_trans` VALUES(26, 97);
INSERT INTO `cto_download_trans` VALUES(26, 98);
INSERT INTO `cto_download_trans` VALUES(26, 99);
INSERT INTO `cto_download_trans` VALUES(26, 100);
INSERT INTO `cto_download_trans` VALUES(26, 101);
INSERT INTO `cto_download_trans` VALUES(26, 102);
INSERT INTO `cto_download_trans` VALUES(26, 103);
INSERT INTO `cto_download_trans` VALUES(26, 104);
INSERT INTO `cto_download_trans` VALUES(26, 105);
INSERT INTO `cto_download_trans` VALUES(26, 106);
INSERT INTO `cto_download_trans` VALUES(26, 107);
INSERT INTO `cto_download_trans` VALUES(26, 108);
INSERT INTO `cto_download_trans` VALUES(26, 109);
INSERT INTO `cto_download_trans` VALUES(26, 110);
INSERT INTO `cto_download_trans` VALUES(26, 111);
INSERT INTO `cto_download_trans` VALUES(26, 112);
INSERT INTO `cto_download_trans` VALUES(26, 113);
INSERT INTO `cto_download_trans` VALUES(26, 114);
INSERT INTO `cto_download_trans` VALUES(26, 115);
INSERT INTO `cto_download_trans` VALUES(26, 116);
INSERT INTO `cto_download_trans` VALUES(26, 117);
INSERT INTO `cto_download_trans` VALUES(26, 118);
INSERT INTO `cto_download_trans` VALUES(26, 119);
INSERT INTO `cto_download_trans` VALUES(26, 120);
INSERT INTO `cto_download_trans` VALUES(26, 121);
INSERT INTO `cto_download_trans` VALUES(26, 122);
INSERT INTO `cto_download_trans` VALUES(26, 123);
INSERT INTO `cto_download_trans` VALUES(26, 129);
INSERT INTO `cto_download_trans` VALUES(26, 130);
INSERT INTO `cto_download_trans` VALUES(27, 1);
INSERT INTO `cto_download_trans` VALUES(27, 2);
INSERT INTO `cto_download_trans` VALUES(27, 3);
INSERT INTO `cto_download_trans` VALUES(27, 4);
INSERT INTO `cto_download_trans` VALUES(27, 5);
INSERT INTO `cto_download_trans` VALUES(27, 6);
INSERT INTO `cto_download_trans` VALUES(27, 7);
INSERT INTO `cto_download_trans` VALUES(27, 8);
INSERT INTO `cto_download_trans` VALUES(27, 9);
INSERT INTO `cto_download_trans` VALUES(27, 10);
INSERT INTO `cto_download_trans` VALUES(27, 11);
INSERT INTO `cto_download_trans` VALUES(27, 12);
INSERT INTO `cto_download_trans` VALUES(27, 13);
INSERT INTO `cto_download_trans` VALUES(27, 14);
INSERT INTO `cto_download_trans` VALUES(27, 15);
INSERT INTO `cto_download_trans` VALUES(27, 16);
INSERT INTO `cto_download_trans` VALUES(27, 17);
INSERT INTO `cto_download_trans` VALUES(27, 18);
INSERT INTO `cto_download_trans` VALUES(27, 19);
INSERT INTO `cto_download_trans` VALUES(27, 20);
INSERT INTO `cto_download_trans` VALUES(27, 21);
INSERT INTO `cto_download_trans` VALUES(27, 22);
INSERT INTO `cto_download_trans` VALUES(27, 23);
INSERT INTO `cto_download_trans` VALUES(27, 24);
INSERT INTO `cto_download_trans` VALUES(27, 25);
INSERT INTO `cto_download_trans` VALUES(27, 26);
INSERT INTO `cto_download_trans` VALUES(27, 27);
INSERT INTO `cto_download_trans` VALUES(27, 28);
INSERT INTO `cto_download_trans` VALUES(27, 29);
INSERT INTO `cto_download_trans` VALUES(27, 30);
INSERT INTO `cto_download_trans` VALUES(27, 31);
INSERT INTO `cto_download_trans` VALUES(27, 32);
INSERT INTO `cto_download_trans` VALUES(27, 33);
INSERT INTO `cto_download_trans` VALUES(27, 34);
INSERT INTO `cto_download_trans` VALUES(27, 35);
INSERT INTO `cto_download_trans` VALUES(27, 36);
INSERT INTO `cto_download_trans` VALUES(27, 37);
INSERT INTO `cto_download_trans` VALUES(27, 38);
INSERT INTO `cto_download_trans` VALUES(27, 39);
INSERT INTO `cto_download_trans` VALUES(27, 40);
INSERT INTO `cto_download_trans` VALUES(27, 41);
INSERT INTO `cto_download_trans` VALUES(27, 42);
INSERT INTO `cto_download_trans` VALUES(27, 43);
INSERT INTO `cto_download_trans` VALUES(27, 44);
INSERT INTO `cto_download_trans` VALUES(27, 45);
INSERT INTO `cto_download_trans` VALUES(27, 46);
INSERT INTO `cto_download_trans` VALUES(27, 47);
INSERT INTO `cto_download_trans` VALUES(27, 48);
INSERT INTO `cto_download_trans` VALUES(27, 49);
INSERT INTO `cto_download_trans` VALUES(27, 50);
INSERT INTO `cto_download_trans` VALUES(27, 51);
INSERT INTO `cto_download_trans` VALUES(27, 52);
INSERT INTO `cto_download_trans` VALUES(27, 53);
INSERT INTO `cto_download_trans` VALUES(27, 54);
INSERT INTO `cto_download_trans` VALUES(27, 55);
INSERT INTO `cto_download_trans` VALUES(27, 56);
INSERT INTO `cto_download_trans` VALUES(27, 57);
INSERT INTO `cto_download_trans` VALUES(27, 58);
INSERT INTO `cto_download_trans` VALUES(27, 59);
INSERT INTO `cto_download_trans` VALUES(27, 60);
INSERT INTO `cto_download_trans` VALUES(27, 61);
INSERT INTO `cto_download_trans` VALUES(27, 62);
INSERT INTO `cto_download_trans` VALUES(27, 63);
INSERT INTO `cto_download_trans` VALUES(27, 64);
INSERT INTO `cto_download_trans` VALUES(27, 65);
INSERT INTO `cto_download_trans` VALUES(27, 66);
INSERT INTO `cto_download_trans` VALUES(27, 67);
INSERT INTO `cto_download_trans` VALUES(27, 68);
INSERT INTO `cto_download_trans` VALUES(27, 69);
INSERT INTO `cto_download_trans` VALUES(27, 70);
INSERT INTO `cto_download_trans` VALUES(27, 71);
INSERT INTO `cto_download_trans` VALUES(27, 72);
INSERT INTO `cto_download_trans` VALUES(27, 73);
INSERT INTO `cto_download_trans` VALUES(27, 74);
INSERT INTO `cto_download_trans` VALUES(27, 75);
INSERT INTO `cto_download_trans` VALUES(27, 76);
INSERT INTO `cto_download_trans` VALUES(27, 77);
INSERT INTO `cto_download_trans` VALUES(27, 78);
INSERT INTO `cto_download_trans` VALUES(27, 79);
INSERT INTO `cto_download_trans` VALUES(27, 80);
INSERT INTO `cto_download_trans` VALUES(27, 81);
INSERT INTO `cto_download_trans` VALUES(27, 82);
INSERT INTO `cto_download_trans` VALUES(27, 83);
INSERT INTO `cto_download_trans` VALUES(27, 84);
INSERT INTO `cto_download_trans` VALUES(27, 85);
INSERT INTO `cto_download_trans` VALUES(27, 86);
INSERT INTO `cto_download_trans` VALUES(27, 87);
INSERT INTO `cto_download_trans` VALUES(27, 88);
INSERT INTO `cto_download_trans` VALUES(27, 89);
INSERT INTO `cto_download_trans` VALUES(27, 90);
INSERT INTO `cto_download_trans` VALUES(27, 91);
INSERT INTO `cto_download_trans` VALUES(27, 92);
INSERT INTO `cto_download_trans` VALUES(27, 93);
INSERT INTO `cto_download_trans` VALUES(27, 94);
INSERT INTO `cto_download_trans` VALUES(27, 95);
INSERT INTO `cto_download_trans` VALUES(27, 96);
INSERT INTO `cto_download_trans` VALUES(27, 97);
INSERT INTO `cto_download_trans` VALUES(27, 98);
INSERT INTO `cto_download_trans` VALUES(27, 99);
INSERT INTO `cto_download_trans` VALUES(27, 100);
INSERT INTO `cto_download_trans` VALUES(27, 101);
INSERT INTO `cto_download_trans` VALUES(27, 102);
INSERT INTO `cto_download_trans` VALUES(27, 103);
INSERT INTO `cto_download_trans` VALUES(27, 104);
INSERT INTO `cto_download_trans` VALUES(27, 105);
INSERT INTO `cto_download_trans` VALUES(27, 106);
INSERT INTO `cto_download_trans` VALUES(27, 107);
INSERT INTO `cto_download_trans` VALUES(27, 108);
INSERT INTO `cto_download_trans` VALUES(27, 109);
INSERT INTO `cto_download_trans` VALUES(27, 110);
INSERT INTO `cto_download_trans` VALUES(27, 111);
INSERT INTO `cto_download_trans` VALUES(27, 112);
INSERT INTO `cto_download_trans` VALUES(27, 113);
INSERT INTO `cto_download_trans` VALUES(27, 114);
INSERT INTO `cto_download_trans` VALUES(27, 115);
INSERT INTO `cto_download_trans` VALUES(27, 116);
INSERT INTO `cto_download_trans` VALUES(27, 117);
INSERT INTO `cto_download_trans` VALUES(27, 118);
INSERT INTO `cto_download_trans` VALUES(27, 119);
INSERT INTO `cto_download_trans` VALUES(27, 120);
INSERT INTO `cto_download_trans` VALUES(27, 121);
INSERT INTO `cto_download_trans` VALUES(27, 122);
INSERT INTO `cto_download_trans` VALUES(27, 123);
INSERT INTO `cto_download_trans` VALUES(28, 1);
INSERT INTO `cto_download_trans` VALUES(28, 2);
INSERT INTO `cto_download_trans` VALUES(28, 3);
INSERT INTO `cto_download_trans` VALUES(28, 4);
INSERT INTO `cto_download_trans` VALUES(28, 5);
INSERT INTO `cto_download_trans` VALUES(28, 6);
INSERT INTO `cto_download_trans` VALUES(28, 7);
INSERT INTO `cto_download_trans` VALUES(28, 8);
INSERT INTO `cto_download_trans` VALUES(28, 9);
INSERT INTO `cto_download_trans` VALUES(28, 10);
INSERT INTO `cto_download_trans` VALUES(28, 11);
INSERT INTO `cto_download_trans` VALUES(28, 12);
INSERT INTO `cto_download_trans` VALUES(28, 13);
INSERT INTO `cto_download_trans` VALUES(28, 14);
INSERT INTO `cto_download_trans` VALUES(28, 15);
INSERT INTO `cto_download_trans` VALUES(28, 16);
INSERT INTO `cto_download_trans` VALUES(28, 17);
INSERT INTO `cto_download_trans` VALUES(28, 18);
INSERT INTO `cto_download_trans` VALUES(28, 19);
INSERT INTO `cto_download_trans` VALUES(28, 20);
INSERT INTO `cto_download_trans` VALUES(28, 21);
INSERT INTO `cto_download_trans` VALUES(28, 22);
INSERT INTO `cto_download_trans` VALUES(28, 23);
INSERT INTO `cto_download_trans` VALUES(28, 24);
INSERT INTO `cto_download_trans` VALUES(28, 25);
INSERT INTO `cto_download_trans` VALUES(28, 26);
INSERT INTO `cto_download_trans` VALUES(28, 27);
INSERT INTO `cto_download_trans` VALUES(28, 28);
INSERT INTO `cto_download_trans` VALUES(28, 29);
INSERT INTO `cto_download_trans` VALUES(28, 30);
INSERT INTO `cto_download_trans` VALUES(28, 31);
INSERT INTO `cto_download_trans` VALUES(28, 32);
INSERT INTO `cto_download_trans` VALUES(28, 33);
INSERT INTO `cto_download_trans` VALUES(28, 34);
INSERT INTO `cto_download_trans` VALUES(28, 35);
INSERT INTO `cto_download_trans` VALUES(28, 36);
INSERT INTO `cto_download_trans` VALUES(28, 37);
INSERT INTO `cto_download_trans` VALUES(28, 38);
INSERT INTO `cto_download_trans` VALUES(28, 39);
INSERT INTO `cto_download_trans` VALUES(28, 40);
INSERT INTO `cto_download_trans` VALUES(28, 41);
INSERT INTO `cto_download_trans` VALUES(28, 42);
INSERT INTO `cto_download_trans` VALUES(28, 43);
INSERT INTO `cto_download_trans` VALUES(28, 44);
INSERT INTO `cto_download_trans` VALUES(28, 45);
INSERT INTO `cto_download_trans` VALUES(28, 46);
INSERT INTO `cto_download_trans` VALUES(28, 47);
INSERT INTO `cto_download_trans` VALUES(28, 48);
INSERT INTO `cto_download_trans` VALUES(28, 49);
INSERT INTO `cto_download_trans` VALUES(28, 50);
INSERT INTO `cto_download_trans` VALUES(28, 51);
INSERT INTO `cto_download_trans` VALUES(28, 52);
INSERT INTO `cto_download_trans` VALUES(28, 53);
INSERT INTO `cto_download_trans` VALUES(28, 54);
INSERT INTO `cto_download_trans` VALUES(28, 55);
INSERT INTO `cto_download_trans` VALUES(28, 56);
INSERT INTO `cto_download_trans` VALUES(28, 57);
INSERT INTO `cto_download_trans` VALUES(28, 58);
INSERT INTO `cto_download_trans` VALUES(28, 59);
INSERT INTO `cto_download_trans` VALUES(28, 60);
INSERT INTO `cto_download_trans` VALUES(28, 61);
INSERT INTO `cto_download_trans` VALUES(28, 62);
INSERT INTO `cto_download_trans` VALUES(28, 63);
INSERT INTO `cto_download_trans` VALUES(28, 64);
INSERT INTO `cto_download_trans` VALUES(28, 65);
INSERT INTO `cto_download_trans` VALUES(28, 66);
INSERT INTO `cto_download_trans` VALUES(28, 67);
INSERT INTO `cto_download_trans` VALUES(28, 68);
INSERT INTO `cto_download_trans` VALUES(28, 69);
INSERT INTO `cto_download_trans` VALUES(28, 70);
INSERT INTO `cto_download_trans` VALUES(28, 71);
INSERT INTO `cto_download_trans` VALUES(28, 72);
INSERT INTO `cto_download_trans` VALUES(28, 73);
INSERT INTO `cto_download_trans` VALUES(28, 74);
INSERT INTO `cto_download_trans` VALUES(28, 75);
INSERT INTO `cto_download_trans` VALUES(28, 76);
INSERT INTO `cto_download_trans` VALUES(28, 77);
INSERT INTO `cto_download_trans` VALUES(28, 78);
INSERT INTO `cto_download_trans` VALUES(28, 79);
INSERT INTO `cto_download_trans` VALUES(28, 80);
INSERT INTO `cto_download_trans` VALUES(28, 81);
INSERT INTO `cto_download_trans` VALUES(28, 82);
INSERT INTO `cto_download_trans` VALUES(28, 83);
INSERT INTO `cto_download_trans` VALUES(28, 84);
INSERT INTO `cto_download_trans` VALUES(28, 85);
INSERT INTO `cto_download_trans` VALUES(28, 86);
INSERT INTO `cto_download_trans` VALUES(28, 87);
INSERT INTO `cto_download_trans` VALUES(28, 88);
INSERT INTO `cto_download_trans` VALUES(28, 89);
INSERT INTO `cto_download_trans` VALUES(28, 90);
INSERT INTO `cto_download_trans` VALUES(28, 91);
INSERT INTO `cto_download_trans` VALUES(28, 92);
INSERT INTO `cto_download_trans` VALUES(28, 93);
INSERT INTO `cto_download_trans` VALUES(28, 94);
INSERT INTO `cto_download_trans` VALUES(28, 95);
INSERT INTO `cto_download_trans` VALUES(28, 96);
INSERT INTO `cto_download_trans` VALUES(28, 97);
INSERT INTO `cto_download_trans` VALUES(28, 98);
INSERT INTO `cto_download_trans` VALUES(28, 99);
INSERT INTO `cto_download_trans` VALUES(28, 100);
INSERT INTO `cto_download_trans` VALUES(28, 101);
INSERT INTO `cto_download_trans` VALUES(28, 102);
INSERT INTO `cto_download_trans` VALUES(28, 103);
INSERT INTO `cto_download_trans` VALUES(28, 104);
INSERT INTO `cto_download_trans` VALUES(28, 105);
INSERT INTO `cto_download_trans` VALUES(28, 106);
INSERT INTO `cto_download_trans` VALUES(28, 107);
INSERT INTO `cto_download_trans` VALUES(28, 108);
INSERT INTO `cto_download_trans` VALUES(28, 109);
INSERT INTO `cto_download_trans` VALUES(28, 110);
INSERT INTO `cto_download_trans` VALUES(28, 111);
INSERT INTO `cto_download_trans` VALUES(28, 112);
INSERT INTO `cto_download_trans` VALUES(28, 113);
INSERT INTO `cto_download_trans` VALUES(28, 114);
INSERT INTO `cto_download_trans` VALUES(28, 115);
INSERT INTO `cto_download_trans` VALUES(28, 116);
INSERT INTO `cto_download_trans` VALUES(28, 117);
INSERT INTO `cto_download_trans` VALUES(28, 118);
INSERT INTO `cto_download_trans` VALUES(28, 119);
INSERT INTO `cto_download_trans` VALUES(28, 120);
INSERT INTO `cto_download_trans` VALUES(28, 121);
INSERT INTO `cto_download_trans` VALUES(28, 122);
INSERT INTO `cto_download_trans` VALUES(28, 123);

-- --------------------------------------------------------

--
-- Table structure for table `cto_email_update`
--

DROP TABLE IF EXISTS `cto_email_update`;
CREATE TABLE IF NOT EXISTS `cto_email_update` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `cto_email_update`
--

INSERT INTO `cto_email_update` VALUES(1, 'Daily');
INSERT INTO `cto_email_update` VALUES(2, 'Weekly');
INSERT INTO `cto_email_update` VALUES(3, 'Monthly');
INSERT INTO `cto_email_update` VALUES(4, 'No Updates');

-- --------------------------------------------------------

--
-- Table structure for table `cto_employee_size`
--

DROP TABLE IF EXISTS `cto_employee_size`;
CREATE TABLE IF NOT EXISTS `cto_employee_size` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `from_range` int(11) NOT NULL,
  `to_range` int(11) NOT NULL,
  `add_date` date NOT NULL default '0000-00-00',
  `modify_date` date NOT NULL default '0000-00-00',
  `status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `cto_employee_size`
--

INSERT INTO `cto_employee_size` VALUES(1, '0-25', 0, 25, '2010-03-25', '2010-03-25', 0);
INSERT INTO `cto_employee_size` VALUES(2, '25-100', 25, 100, '2010-03-25', '2010-05-28', 0);
INSERT INTO `cto_employee_size` VALUES(3, '100-250', 100, 250, '2010-03-25', '2010-05-28', 0);
INSERT INTO `cto_employee_size` VALUES(4, '250-1000', 250, 1000, '2010-03-25', '2010-05-28', 0);
INSERT INTO `cto_employee_size` VALUES(5, '1K-10K', 1001, 10000, '2010-03-25', '2010-03-25', 0);
INSERT INTO `cto_employee_size` VALUES(6, '10K-50K', 10000, 50000, '2010-03-25', '2010-05-28', 0);
INSERT INTO `cto_employee_size` VALUES(7, '50K-100K', 50000, 100000, '2010-03-25', '2010-05-28', 0);
INSERT INTO `cto_employee_size` VALUES(8, ' >100K', 100001, 1000000000, '2010-03-25', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cto_faq`
--

DROP TABLE IF EXISTS `cto_faq`;
CREATE TABLE IF NOT EXISTS `cto_faq` (
  `faq_id` int(11) NOT NULL auto_increment,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `add_date` date NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY  (`faq_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `cto_faq`
--

INSERT INTO `cto_faq` VALUES(4, 'What makes you different from some of the other providers?', '<font size=\\"2\\" face=\\"Verdana\\">Most of other providers are either giving you the entire world of data and leave you to spend your own time sifting through it. Still others give you static data about some of your potential clients. Only CTOsOnTheMove.com gives you the delta of change amongst key decision makers from the community of your potential customer - CTOs, CIOs and VPs of Technology and Information Services.</font>', '2010-03-15', 0);
INSERT INTO `cto_faq` VALUES(5, 'What if I decide to cancel - are there any penalties or fees?', '<font size=\\"2\\" face=\\"Verdana\\">None. The subscription is monthly and is pay-as-you-go, so you a free to cancel at any point in time without any fees or penalties.</font>', '2010-03-22', 0);
INSERT INTO `cto_faq` VALUES(6, 'What do I get with the subscription?', '<font size=\\"2\\" face=\\"Verdana\\">As a subscriber you receive full unlimited searching, browsing and downloading access to the entire database. In addition, you also receive a monthly update file in an email.</font>', '2010-03-22', 0);
INSERT INTO `cto_faq` VALUES(8, 'Where do you get your data?', '<font size=\\"2\\" face=\\"Verdana\\">We are CTOsOnTheMove.com constantly monitor over 5,000 news sources, companies\\'' announcements, statutory filings, social media outlets and many other sources for timely, relevant and actionable insights into your clients\\'' businesses. <br />\r\n<br />\r\nThis information is gathered, cleaned, validated and enhanced in real time to provide you with insights to act on, to drive your sales.</font>', '2010-07-08', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cto_industry`
--

DROP TABLE IF EXISTS `cto_industry`;
CREATE TABLE IF NOT EXISTS `cto_industry` (
  `industry_id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `add_date` varchar(50) NOT NULL,
  `status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`industry_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=202 ;

--
-- Dumping data for table `cto_industry`
--

INSERT INTO `cto_industry` VALUES(1, 0, 'Agriculture & Mining', '', '1268637954', 0);
INSERT INTO `cto_industry` VALUES(2, 1, 'Farming & Ranching', '', '1268637972', 0);
INSERT INTO `cto_industry` VALUES(3, 1, 'Fishing, Hunting, & Trapping', '', '1268637988', 0);
INSERT INTO `cto_industry` VALUES(4, 1, 'Forestry & Logging', '', '1268638006', 0);
INSERT INTO `cto_industry` VALUES(5, 1, 'Mining & Quarrying', '', '1268638018', 0);
INSERT INTO `cto_industry` VALUES(6, 1, 'Agriculture & Mining Other', '', '1268638039', 0);
INSERT INTO `cto_industry` VALUES(7, 0, 'Business Services', '', '1268638058', 0);
INSERT INTO `cto_industry` VALUES(8, 7, 'Accounting & Tax Preparation', '', '1268638073', 1);
INSERT INTO `cto_industry` VALUES(9, 7, 'Advertising, Marketing, & PR', '', '1268638087', 0);
INSERT INTO `cto_industry` VALUES(10, 7, 'Data and Records Management', '', '1268638104', 0);
INSERT INTO `cto_industry` VALUES(11, 7, 'Facilities Management & Maintenance', '', '1268638115', 0);
INSERT INTO `cto_industry` VALUES(12, 7, 'HR, Recruiting, & Payroll Services', '', '1268638145', 0);
INSERT INTO `cto_industry` VALUES(13, 7, 'Legal Services', '', '1268638170', 0);
INSERT INTO `cto_industry` VALUES(14, 7, 'Management Consulting', '', '1268638183', 0);
INSERT INTO `cto_industry` VALUES(15, 7, 'Sales Services', '', '1268638197', 0);
INSERT INTO `cto_industry` VALUES(16, 7, 'Security Services', '', '1268638223', 0);
INSERT INTO `cto_industry` VALUES(17, 7, 'Business Services Other', '', '1268638235', 0);
INSERT INTO `cto_industry` VALUES(18, 0, 'Computers & Electronics', '', '1268638286', 0);
INSERT INTO `cto_industry` VALUES(19, 18, 'Audio, Video & Photography', '', '1268638301', 0);
INSERT INTO `cto_industry` VALUES(20, 18, 'Computers, Parts & Repair', '', '1268638315', 0);
INSERT INTO `cto_industry` VALUES(21, 18, 'Consumer Electronics, Parts & Repair', '', '1268638327', 0);
INSERT INTO `cto_industry` VALUES(22, 18, 'IT and Network Services and Support', '', '1268638341', 0);
INSERT INTO `cto_industry` VALUES(23, 18, 'Instruments & Controls', '', '1268638353', 0);
INSERT INTO `cto_industry` VALUES(24, 18, 'Network Security Products', '', '1268638373', 0);
INSERT INTO `cto_industry` VALUES(25, 18, 'Networking Equipment and Systems', '', '1268638396', 0);
INSERT INTO `cto_industry` VALUES(26, 18, 'Office Machinery & Equipment', '', '1268638407', 0);
INSERT INTO `cto_industry` VALUES(27, 18, 'Peripherals Manufacturing', '', '1268638421', 0);
INSERT INTO `cto_industry` VALUES(28, 18, 'Semiconductor and Microchip Manufacturing', '', '1268638436', 0);
INSERT INTO `cto_industry` VALUES(29, 18, 'Computers & Electronics Other', '', '1268638454', 0);
INSERT INTO `cto_industry` VALUES(30, 0, 'Consumer Services', '', '1268638542', 0);
INSERT INTO `cto_industry` VALUES(31, 30, 'Consumer Services', '', '1268638571', 0);
INSERT INTO `cto_industry` VALUES(32, 30, 'Funeral Homes & Funeral Services', '', '1268638587', 0);
INSERT INTO `cto_industry` VALUES(33, 30, 'Laundry & Dry Cleaning', '', '1268638598', 0);
INSERT INTO `cto_industry` VALUES(34, 30, 'Parking Lots & Garage Management', '', '1268638612', 0);
INSERT INTO `cto_industry` VALUES(35, 30, 'Personal Care', '', '1268638628', 0);
INSERT INTO `cto_industry` VALUES(36, 30, 'Photofinishing Services', '', '1268638644', 0);
INSERT INTO `cto_industry` VALUES(37, 30, 'Consumer Services Other', '', '1268638658', 0);
INSERT INTO `cto_industry` VALUES(38, 0, 'Education ', '', '1268638694', 0);
INSERT INTO `cto_industry` VALUES(39, 38, 'Colleges and Universities', '', '1268638707', 0);
INSERT INTO `cto_industry` VALUES(40, 38, 'Elementary and Secondary Schools', '', '1268638720', 0);
INSERT INTO `cto_industry` VALUES(41, 38, 'Libraries, Archives and Museums', '', '1268638733', 0);
INSERT INTO `cto_industry` VALUES(42, 38, 'Sports, Arts, and Recreation Instruction', '', '1268638747', 0);
INSERT INTO `cto_industry` VALUES(43, 38, 'Technical and Trade Schools', '', '1268638770', 0);
INSERT INTO `cto_industry` VALUES(44, 38, 'Test Preparation', '', '1268638782', 1);
INSERT INTO `cto_industry` VALUES(45, 38, 'Education Other', '', '1268638798', 0);
INSERT INTO `cto_industry` VALUES(46, 0, 'Energy & Utilities', '', '1271395210', 0);
INSERT INTO `cto_industry` VALUES(47, 46, 'Alternative Energy Sources', '', '1271395234', 0);
INSERT INTO `cto_industry` VALUES(48, 46, 'Gas and Electric Utilities', '', '1271395246', 0);
INSERT INTO `cto_industry` VALUES(49, 46, 'Gasoline and Oil Refineries', '', '1271395258', 0);
INSERT INTO `cto_industry` VALUES(50, 46, 'Sewage Treatment Facilities', '', '1271395271', 0);
INSERT INTO `cto_industry` VALUES(51, 46, 'Waste Management and Recycling', '', '1271395286', 0);
INSERT INTO `cto_industry` VALUES(52, 46, 'Water Treatment and Utilities', '', '1271395306', 0);
INSERT INTO `cto_industry` VALUES(53, 46, 'Energy and Utilities Other', '', '1271395346', 0);
INSERT INTO `cto_industry` VALUES(54, 0, 'Financial Services', '', '1271395387', 0);
INSERT INTO `cto_industry` VALUES(55, 54, 'Banks', '', '1271395405', 0);
INSERT INTO `cto_industry` VALUES(56, 54, 'Credit Card and Related Services', '', '1271395418', 0);
INSERT INTO `cto_industry` VALUES(57, 54, 'Insurance and Risk Management', '', '1271395437', 0);
INSERT INTO `cto_industry` VALUES(58, 54, 'Investment Banking and Venture Capital', '', '1271395526', 0);
INSERT INTO `cto_industry` VALUES(59, 54, 'Lending and Mortgage', '', '1271395579', 0);
INSERT INTO `cto_industry` VALUES(60, 54, 'Personal Financial Planning & Private Banking', '', '1271395594', 0);
INSERT INTO `cto_industry` VALUES(61, 54, 'Securities Agents & Brokers', '', '1271395605', 0);
INSERT INTO `cto_industry` VALUES(62, 54, 'Trust, Feduciary and Custody Activities', '', '1271395628', 0);
INSERT INTO `cto_industry` VALUES(63, 54, 'Financial Services Other', '', '1271395638', 0);
INSERT INTO `cto_industry` VALUES(64, 0, 'Government', '', '1278490830', 0);
INSERT INTO `cto_industry` VALUES(65, 64, 'International Bodies and Organizations', '', '1278490875', 0);
INSERT INTO `cto_industry` VALUES(66, 64, 'Local Government', '', '1278491132', 0);
INSERT INTO `cto_industry` VALUES(67, 64, 'National Government', '', '1278491163', 0);
INSERT INTO `cto_industry` VALUES(68, 64, 'State/Provincial Government', '', '1278491274', 0);
INSERT INTO `cto_industry` VALUES(69, 64, 'Government Other', '', '1278491343', 0);
INSERT INTO `cto_industry` VALUES(70, 0, 'Healthcare, Pharmaceuticals, & Biotech', '', '1278491578', 0);
INSERT INTO `cto_industry` VALUES(71, 70, 'Biotechnology', '', '1278491600', 0);
INSERT INTO `cto_industry` VALUES(72, 70, 'Diagnostic Laboratories', '', '1278491639', 0);
INSERT INTO `cto_industry` VALUES(73, 70, 'Doctors and Health Care Practiotioners', '', '1278491658', 0);
INSERT INTO `cto_industry` VALUES(74, 70, 'Hospitals', '', '1278491679', 0);
INSERT INTO `cto_industry` VALUES(75, 70, 'Medical Supplies & Equipment', '', '1278491703', 0);
INSERT INTO `cto_industry` VALUES(76, 70, 'Outpatient Care Centers', '', '1278491722', 0);
INSERT INTO `cto_industry` VALUES(77, 70, 'Personal Health Care Products', '', '1278491739', 0);
INSERT INTO `cto_industry` VALUES(78, 70, 'Pharmaceuticals', '', '1278491757', 0);
INSERT INTO `cto_industry` VALUES(79, 70, 'Residential and Long-Term Care Facilities', '', '1278491800', 0);
INSERT INTO `cto_industry` VALUES(80, 70, 'Veterinary Clinics and Services', '', '1278491817', 0);
INSERT INTO `cto_industry` VALUES(81, 70, 'Healthcare, Pharmaceuticals, & Biotech Other', '', '1278491835', 0);
INSERT INTO `cto_industry` VALUES(82, 0, 'Manufacturing', '', '1278491859', 0);
INSERT INTO `cto_industry` VALUES(83, 82, 'Aerospace & Defense', '', '1278491881', 0);
INSERT INTO `cto_industry` VALUES(84, 82, 'Alcoholic Beverages', '', '1278491905', 0);
INSERT INTO `cto_industry` VALUES(85, 82, 'Automobiles, Boats and Motor Vehicles', '', '1278491922', 0);
INSERT INTO `cto_industry` VALUES(86, 82, 'Chemicals and Petrochemicals', '', '1278491937', 0);
INSERT INTO `cto_industry` VALUES(87, 82, 'Concrete, Glass and Building Materials', '', '1278491954', 0);
INSERT INTO `cto_industry` VALUES(88, 82, 'Farming and Mining Machinery & Equipment', '', '1278491985', 0);
INSERT INTO `cto_industry` VALUES(89, 82, 'Food & Dairy Product Manufacturing', '', '1278492004', 0);
INSERT INTO `cto_industry` VALUES(90, 82, 'Furniture Manufacturing', '', '1278492023', 0);
INSERT INTO `cto_industry` VALUES(91, 82, 'Heavy Machinery', '', '1278492043', 0);
INSERT INTO `cto_industry` VALUES(92, 82, 'Nonalcoholic Beverages', '', '1278492062', 0);
INSERT INTO `cto_industry` VALUES(93, 82, 'Paper and Paper Products', '', '1278492112', 0);
INSERT INTO `cto_industry` VALUES(94, 82, 'Plastics and Rubber Manufacturing', '', '1278492130', 0);
INSERT INTO `cto_industry` VALUES(95, 82, 'Textiles, Apparel and Accessories', '', '1278492148', 0);
INSERT INTO `cto_industry` VALUES(96, 82, 'Tools, Hardware and Light Machinery', '', '1278492183', 0);
INSERT INTO `cto_industry` VALUES(97, 82, 'Manufacturing Other', '', '1278492202', 0);
INSERT INTO `cto_industry` VALUES(98, 0, 'Media & Entertainment', '', '1278492221', 0);
INSERT INTO `cto_industry` VALUES(99, 98, 'Adult Entertainment', '', '1278492245', 0);
INSERT INTO `cto_industry` VALUES(100, 98, 'Motion Picture Exhibitors', '', '1278492262', 0);
INSERT INTO `cto_industry` VALUES(101, 98, 'Motion Picture and Recording Producers', '', '1278492284', 0);
INSERT INTO `cto_industry` VALUES(102, 98, 'Newspapers, Books and Periodicals', '', '1278492305', 0);
INSERT INTO `cto_industry` VALUES(103, 98, 'Performing Arts', '', '1278492323', 0);
INSERT INTO `cto_industry` VALUES(104, 98, 'Radio and Television Broadcasting', '', '1278492366', 0);
INSERT INTO `cto_industry` VALUES(105, 98, 'Media & Entertainment Other', '', '1278492383', 0);
INSERT INTO `cto_industry` VALUES(106, 0, 'Non-profit', '', '1278492411', 0);
INSERT INTO `cto_industry` VALUES(107, 106, 'Advocacy Organizations', '', '1278492427', 0);
INSERT INTO `cto_industry` VALUES(108, 106, 'Charitable Organizations and Foundations', '', '1278492447', 0);
INSERT INTO `cto_industry` VALUES(109, 106, 'Professional Associations', '', '1278492464', 0);
INSERT INTO `cto_industry` VALUES(110, 106, 'Religious Organizations', '', '1278492482', 0);
INSERT INTO `cto_industry` VALUES(111, 106, 'Social and Membership Organizations', '', '1278492507', 0);
INSERT INTO `cto_industry` VALUES(112, 106, 'Trade Groups and Labor Unions', '', '1278492527', 0);
INSERT INTO `cto_industry` VALUES(113, 106, 'Non-profit Other', '', '1278492547', 0);
INSERT INTO `cto_industry` VALUES(114, 0, 'Real Estate & Construction', '', '1278492616', 0);
INSERT INTO `cto_industry` VALUES(115, 114, 'Architecture, Engineering & Design', '', '1278492637', 0);
INSERT INTO `cto_industry` VALUES(116, 114, 'Construction, Equipment and Supplies', '', '1278492721', 0);
INSERT INTO `cto_industry` VALUES(117, 114, 'Construction and Remodeling', '', '1278492741', 0);
INSERT INTO `cto_industry` VALUES(118, 114, 'Property Leasing and Management', '', '1278492810', 0);
INSERT INTO `cto_industry` VALUES(119, 114, 'Real Estate Agents and Appraisers', '', '1278492828', 0);
INSERT INTO `cto_industry` VALUES(120, 114, 'Real Estate Investment and Development', '', '1278492848', 0);
INSERT INTO `cto_industry` VALUES(121, 114, 'Real Estate and Construction Other', '', '1278492885', 0);
INSERT INTO `cto_industry` VALUES(122, 0, 'Retail', '', '1278492941', 0);
INSERT INTO `cto_industry` VALUES(123, 122, 'Automobile Dealers', '', '1278492959', 0);
INSERT INTO `cto_industry` VALUES(124, 122, 'Automobile Parts Stores', '', '1278492986', 0);
INSERT INTO `cto_industry` VALUES(125, 122, 'Beer, Wine and Liquor Stores', '', '1278493012', 0);
INSERT INTO `cto_industry` VALUES(126, 122, 'Clothing and Shoes Stores', '', '1278493028', 0);
INSERT INTO `cto_industry` VALUES(127, 122, 'Department Stores', '', '1278493054', 0);
INSERT INTO `cto_industry` VALUES(128, 122, 'Florists', '', '1278493084', 0);
INSERT INTO `cto_industry` VALUES(129, 122, 'Furniture Stores', '', '1278493101', 0);
INSERT INTO `cto_industry` VALUES(130, 122, 'Gasoline Stations', '', '1278493119', 0);
INSERT INTO `cto_industry` VALUES(131, 122, 'Grocery and Specialty Food Stores', '', '1278493146', 0);
INSERT INTO `cto_industry` VALUES(132, 122, 'Hardware and Building Materials Dealers', '', '1278493169', 0);
INSERT INTO `cto_industry` VALUES(133, 122, 'Jewelry, Luggage and Leather Goods Stores', '', '1278493191', 0);
INSERT INTO `cto_industry` VALUES(134, 122, 'Office Supplies Stores', '', '1278493210', 0);
INSERT INTO `cto_industry` VALUES(135, 122, 'Restaurants and Bars', '', '1278493229', 0);
INSERT INTO `cto_industry` VALUES(136, 122, 'Sporting Goods, Hobby, Book and Music Stores', '', '1278493248', 0);
INSERT INTO `cto_industry` VALUES(137, 122, 'Retail Other', '', '1278493267', 0);
INSERT INTO `cto_industry` VALUES(138, 0, 'Software & Internet', '', '1278494695', 0);
INSERT INTO `cto_industry` VALUES(139, 138, 'Data Analytics, Management and Storage', '', '1278494714', 0);
INSERT INTO `cto_industry` VALUES(140, 138, 'E-commerce and Internet Businesses', '', '1278494733', 0);
INSERT INTO `cto_industry` VALUES(141, 138, 'Games and Gaming', '', '1278494757', 0);
INSERT INTO `cto_industry` VALUES(142, 138, 'Software', '', '1278494784', 0);
INSERT INTO `cto_industry` VALUES(143, 138, 'Software & Internet Other', '', '1278494805', 0);
INSERT INTO `cto_industry` VALUES(144, 0, 'Telecommunications', '', '1278494832', 0);
INSERT INTO `cto_industry` VALUES(145, 144, 'Cable Television Providers', '', '1278494878', 0);
INSERT INTO `cto_industry` VALUES(146, 144, 'Telecommunication Equipment and Accessories', '', '1278494898', 0);
INSERT INTO `cto_industry` VALUES(147, 144, 'Telephone Service Providers and Accessories', '', '1278494918', 0);
INSERT INTO `cto_industry` VALUES(148, 144, 'Video and Teleconferencing', '', '1278494936', 0);
INSERT INTO `cto_industry` VALUES(149, 144, 'Wireless and Mobile', '', '1278494959', 0);
INSERT INTO `cto_industry` VALUES(150, 144, 'Telecommunications Other', '', '1278494991', 0);
INSERT INTO `cto_industry` VALUES(151, 0, 'Transportation & Storage', '', '1278495009', 0);
INSERT INTO `cto_industry` VALUES(152, 151, 'Air Couriers and Cargo Services', '', '1278495028', 0);
INSERT INTO `cto_industry` VALUES(153, 151, 'Airport, Harbor and Terminal Operations', '', '1278495050', 0);
INSERT INTO `cto_industry` VALUES(154, 151, 'Freight Hauling (Rail and Truck)', '', '1278495073', 0);
INSERT INTO `cto_industry` VALUES(155, 151, 'Marine and Inland Shipping', '', '1278495092', 0);
INSERT INTO `cto_industry` VALUES(156, 151, 'Moving Companies and Services', '', '1278495110', 0);
INSERT INTO `cto_industry` VALUES(157, 151, 'Postal, Express Delivery and Couriers', '', '1278495130', 0);
INSERT INTO `cto_industry` VALUES(158, 151, 'Warehousing and Storage', '', '1278495150', 0);
INSERT INTO `cto_industry` VALUES(159, 151, 'Transportation & Storage Other', '', '1278495176', 0);
INSERT INTO `cto_industry` VALUES(160, 0, 'Travel, Recreation & Leisure', '', '1278495206', 0);
INSERT INTO `cto_industry` VALUES(161, 160, 'Amusment Parks and Attractions', '', '1278495231', 0);
INSERT INTO `cto_industry` VALUES(162, 160, 'Cruise Shop Operations', '', '1278495250', 0);
INSERT INTO `cto_industry` VALUES(163, 160, 'Gambling and Gaming Industries', '', '1278495269', 0);
INSERT INTO `cto_industry` VALUES(164, 160, 'Hotels, Motels and Lodging', '', '1278495294', 0);
INSERT INTO `cto_industry` VALUES(165, 160, 'Participatory Sports and Recreation', '', '1278495317', 0);
INSERT INTO `cto_industry` VALUES(166, 160, 'Passenger Airlines', '', '1278495337', 0);
INSERT INTO `cto_industry` VALUES(167, 160, 'Rental Cars', '', '1278495360', 0);
INSERT INTO `cto_industry` VALUES(168, 160, 'Resorts and Casinos', '', '1278495393', 0);
INSERT INTO `cto_industry` VALUES(169, 160, 'Spectator Sports and Teams', '', '1278495416', 0);
INSERT INTO `cto_industry` VALUES(170, 160, 'Taxi and Limousine Services', '', '1278495436', 0);
INSERT INTO `cto_industry` VALUES(171, 160, 'Trains, Buses and Transit Systems', '', '1278495454', 0);
INSERT INTO `cto_industry` VALUES(172, 160, 'Travel Agents and Services', '', '1278495474', 0);
INSERT INTO `cto_industry` VALUES(173, 160, 'Travel, Recreation & Leisure Other', '', '1278495494', 0);
INSERT INTO `cto_industry` VALUES(174, 0, 'Wholesale & Distribution', '', '1278495535', 0);
INSERT INTO `cto_industry` VALUES(175, 174, 'Apparel Wholesalers', '', '1278495554', 0);
INSERT INTO `cto_industry` VALUES(176, 174, 'Automobile Parts Wholesalers', '', '1278495573', 0);
INSERT INTO `cto_industry` VALUES(177, 174, 'Beer, Wine and Liquor Wholesalers', '', '1278495594', 0);
INSERT INTO `cto_industry` VALUES(178, 174, 'Chemicals and Plastics Wholesalers', '', '1278495615', 0);
INSERT INTO `cto_industry` VALUES(179, 174, 'Grocery and Food Wholesalers', '', '1278495638', 0);
INSERT INTO `cto_industry` VALUES(180, 174, 'Lumber and Construction Materials Wholesalers', '', '1278495662', 0);
INSERT INTO `cto_industry` VALUES(181, 174, 'Office Equipment and Supplies Wholesalers', '', '1278495685', 0);
INSERT INTO `cto_industry` VALUES(182, 174, 'Petroleum Products Wholesalers', '', '1278495706', 0);
INSERT INTO `cto_industry` VALUES(183, 174, 'Wholesale & Distribution Other', '', '1278495725', 0);
INSERT INTO `cto_industry` VALUES(184, 0, 'Healthcare, Pharmaceuticals, & Biotech', '', '1281063341', 0);
INSERT INTO `cto_industry` VALUES(185, 184, 'Healthcare, Pharmaceuticals, & Biotech Other', '', '1281063341', 0);
INSERT INTO `cto_industry` VALUES(186, 0, 'Healthcare, Pharmaceuticals, & Biotech', '', '1281063501', 0);
INSERT INTO `cto_industry` VALUES(187, 186, 'Healthcare, Pharmaceuticals, & Biotech Other', '', '1281063501', 0);
INSERT INTO `cto_industry` VALUES(188, 0, 'Healthcare, Pharmaceuticals, & Biotech', '', '1281063608', 0);
INSERT INTO `cto_industry` VALUES(189, 188, 'Healthcare, Pharmaceuticals, & Biotech Other', '', '1281063608', 0);
INSERT INTO `cto_industry` VALUES(190, 0, 'Healthcare, Pharmaceuticals, & Biotech', '', '1281063901', 0);
INSERT INTO `cto_industry` VALUES(191, 190, 'Healthcare, Pharmaceuticals, & Biotech Other', '', '1281063901', 0);
INSERT INTO `cto_industry` VALUES(192, 0, 'Travel, Recreation & Leisure', '', '1281089147', 0);
INSERT INTO `cto_industry` VALUES(193, 192, 'Passenger Airlines', '', '1281089147', 0);
INSERT INTO `cto_industry` VALUES(194, 0, 'Travel, Recreation & Leisure', '', '1281089147', 0);
INSERT INTO `cto_industry` VALUES(195, 194, 'Travel Agents and Services', '', '1281089147', 0);
INSERT INTO `cto_industry` VALUES(196, 0, 'Healthcare, Pharmaceuticals, & Biotech', '', '1281089147', 0);
INSERT INTO `cto_industry` VALUES(197, 196, 'Healthcare, Pharmaceuticals, & Biotech Other', '', '1281089147', 0);
INSERT INTO `cto_industry` VALUES(198, 0, 'Healthcare, Pharmaceuticals, & Biotech', '', '1281450621', 0);
INSERT INTO `cto_industry` VALUES(199, 198, 'Hospitals', '', '1281450621', 0);
INSERT INTO `cto_industry` VALUES(200, 0, 'Healthcare, Pharmaceuticals, & Biotech', '', '1281722855', 0);
INSERT INTO `cto_industry` VALUES(201, 200, 'Healthcare, Pharmaceuticals, & Biotech Other', '', '1281722855', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cto_landing_page`
--

DROP TABLE IF EXISTS `cto_landing_page`;
CREATE TABLE IF NOT EXISTS `cto_landing_page` (
  `lp_id` int(11) NOT NULL auto_increment,
  `lp_name` varchar(255) NOT NULL,
  `lp_logo` varchar(255) NOT NULL,
  `lp_caption` varchar(255) NOT NULL,
  `lp_img_title` varchar(255) NOT NULL,
  `lp_image` varchar(255) NOT NULL,
  `lp_img_desc` text NOT NULL,
  `lp_content_title` varchar(255) NOT NULL,
  `lp_content_desc` text NOT NULL,
  `add_date` date NOT NULL,
  PRIMARY KEY  (`lp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `cto_landing_page`
--

INSERT INTO `cto_landing_page` VALUES(5, 'Landing-Page.html', 'logo-1279105102.jpg', 'Landing Page Demo', 'A striking image Demo', 'brad-pitt-1268990030-1279105102.jpg', 'This is a picture of your product which will entice people to buy it&nbsp;                                                     <br />\r\nThis is a picture of your product which will entice people to buy it&nbsp;                                                     <br />\r\nThis is a picture of your product which will entice people to buy it&nbsp;', 'Your stunning headline! demo', '<p>Here is where you describe your call to action. A clear succinct description works best. Advertise the benefits to your potential customer, not just the features. What will they get by filling out your form?</p>\r\n<p>For instance:</p>\r\n<ul>\r\n    <li>Our whitepaper will teach you the 5 secrets of inbound marketing!</li>\r\n    <li>Learn how to make cold-calling a thing of the past!</li>\r\n</ul>\r\n<p>Finally, wrap things up with a brief re-stating of the value you\\''re providing your visitor. They will then go on to fill the form over to the right.</p>\r\n&nbsp;                                                     <br />\r\n<p>Here is where you describe your call to action. A clear succinct description works best. Advertise the benefits to your potential customer, not just the features. What will they get by filling out your form?</p>\r\n<p>For instance:</p>\r\n<ul>\r\n    <li>Our whitepaper will teach you the 5 secrets of inbound marketing!</li>\r\n    <li>Learn how to make cold-calling a thing of the past!</li>\r\n</ul>\r\n<p>Finally, wrap things up with a brief re-stating of the value you\\''re providing your visitor. They will then go on to fill the form over to the right.</p>\r\n&nbsp;                                                     <br />\r\n<p>Here is where you describe your call to action. A clear succinct description works best. Advertise the benefits to your potential customer, not just the features. What will they get by filling out your form?</p>\r\n<p>For instance:</p>\r\n<ul>\r\n    <li>Our whitepaper will teach you the 5 secrets of inbound marketing!</li>\r\n    <li>Learn how to make cold-calling a thing of the past!</li>\r\n</ul>\r\n<p>Finally, wrap things up with a brief re-stating of the value you\\''re providing your visitor. They will then go on to fill the form over to the right.</p>\r\n&nbsp;', '2010-07-14');
INSERT INTO `cto_landing_page` VALUES(4, 'My-Landing-Page.html', 'logo-1279104106.jpg', 'Landing Page', 'A striking image', 'Azhar-image-1279104106.jpg', 'This is a picture of your product which will entice people to buy it', 'Your stunning headline!', '<p>Here is where you describe your call to action. A clear succinct description works best. Advertise the benefits to your potential customer, not just the features. What will they get by filling out your form?</p>\r\n<p>For instance:</p>\r\n<ul>\r\n    <li>Our whitepaper will teach you the 5 secrets of inbound marketing!</li>\r\n    <li>Learn how to make cold-calling a thing of the past!</li>\r\n</ul>\r\n<p>Finally, wrap things up with a brief re-stating of the value you\\''re providing your visitor. They will then go on to fill the form over to the right.</p>', '2010-07-14');
INSERT INTO `cto_landing_page` VALUES(6, 'Testing-Landing-Page.html', 'logo-1279109708.jpg', 'CTOsOnTheMove.com - Lead Generation', 'CTOsOnTheMove.com - Lead Generation', 'Misha-image-1279109709.jpg', 'This is a picture of your product which will entice people to buy it&nbsp;                                                     <br />\r\nThis is a picture of your product which will entice people to buy it&nbsp;', 'Testing Your stunning headline! demo', '<p>Here is where you describe your call to action. A clear succinct description works best. Advertise the benefits to your potential customer, not just the features. What will they get by filling out your form?</p>\r\n<p>For instance:</p>\r\n<ul>\r\n    <li>Our whitepaper will teach you the 5 secrets of inbound marketing!</li>\r\n    <li>Learn how to make cold-calling a thing of the past!</li>\r\n</ul>\r\n<p>Finally, wrap things up with a brief re-stating of the value you\\''re providing your visitor. They will then go on to fill the form over to the right.</p>\r\n&nbsp;                                                     <br />\r\n<p>Here is where you describe your call to action. A clear succinct description works best. Advertise the benefits to your potential customer, not just the features. What will they get by filling out your form?</p>\r\n<p>For instance:</p>\r\n<ul>\r\n    <li>Our whitepaper will teach you the 5 secrets of inbound marketing!</li>\r\n    <li>Learn how to make cold-calling a thing of the past!</li>\r\n</ul>\r\n<p>Finally, wrap things up with a brief re-stating of the value you\\''re providing your visitor. They will then go on to fill the form over to the right.</p>', '2010-07-14');
INSERT INTO `cto_landing_page` VALUES(7, 'landingpageuno', '', 'test', 'test', '', 'test', 'test', 'test', '2010-07-30');

-- --------------------------------------------------------

--
-- Table structure for table `cto_login_history`
--

DROP TABLE IF EXISTS `cto_login_history`;
CREATE TABLE IF NOT EXISTS `cto_login_history` (
  `login_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `login_time` varchar(50) NOT NULL,
  `logout_time` varchar(50) NOT NULL,
  `log_status` varchar(20) NOT NULL,
  PRIMARY KEY  (`login_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=83 ;

--
-- Dumping data for table `cto_login_history`
--

INSERT INTO `cto_login_history` VALUES(1, 1, '2010-05-10', '1273485110', '1273485149', 'Logout');
INSERT INTO `cto_login_history` VALUES(2, 2, '2010-05-10', '1273485862', '1273488607', 'Logout');
INSERT INTO `cto_login_history` VALUES(3, 4, '2010-05-12', '1273644026', '1273647877', 'Logout');
INSERT INTO `cto_login_history` VALUES(4, 4, '2010-05-12', '1273645460', '1273647877', 'Logout');
INSERT INTO `cto_login_history` VALUES(5, 6, '2010-05-17', '1274086437', '1274100906', 'Logout');
INSERT INTO `cto_login_history` VALUES(6, 6, '2010-05-17', '1274100276', '1274100906', 'Logout');
INSERT INTO `cto_login_history` VALUES(7, 6, '2010-05-17', '1274100579', '1274100906', 'Logout');
INSERT INTO `cto_login_history` VALUES(8, 6, '2010-05-17', '1274100630', '1274100906', 'Logout');
INSERT INTO `cto_login_history` VALUES(9, 6, '2010-05-17', '1274100763', '1274100906', 'Logout');
INSERT INTO `cto_login_history` VALUES(10, 6, '2010-05-17', '1274100948', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(11, 6, '2010-05-17', '1274100999', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(12, 7, '2010-05-20', '1274419593', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(13, 6, '2010-05-21', '1274428228', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(14, 6, '2010-05-21', '1274432185', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(15, 6, '2010-05-21', '1274437493', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(16, 6, '2010-05-22', '1274523724', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(17, 1, '2010-05-24', '1274686652', '1274688242', 'Logout');
INSERT INTO `cto_login_history` VALUES(18, 6, '2010-05-24', '1274688256', '1274689082', 'Logout');
INSERT INTO `cto_login_history` VALUES(19, 8, '2010-05-24', '1274689967', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(20, 9, '2010-05-26', '1274930702', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(21, 6, '2010-05-28', '1275031763', '1275038864', 'Logout');
INSERT INTO `cto_login_history` VALUES(22, 1, '2010-05-28', '1275038955', '1275110750', 'Logout');
INSERT INTO `cto_login_history` VALUES(23, 1, '2010-05-28', '1275041604', '1275110750', 'Logout');
INSERT INTO `cto_login_history` VALUES(24, 1, '2010-05-28', '1275109595', '1275110750', 'Logout');
INSERT INTO `cto_login_history` VALUES(25, 1, '2010-05-28', '1275110739', '1275110750', 'Logout');
INSERT INTO `cto_login_history` VALUES(26, 1, '2010-06-01', '1275383828', '1275398018', 'Logout');
INSERT INTO `cto_login_history` VALUES(27, 1, '2010-06-01', '1275386518', '1275398018', 'Logout');
INSERT INTO `cto_login_history` VALUES(28, 1, '2010-06-01', '1275392352', '1275398018', 'Logout');
INSERT INTO `cto_login_history` VALUES(29, 1, '2010-06-01', '1275392717', '1275398018', 'Logout');
INSERT INTO `cto_login_history` VALUES(30, 1, '2010-06-01', '1275393269', '1275398018', 'Logout');
INSERT INTO `cto_login_history` VALUES(31, 1, '2010-06-01', '1275397591', '1275398018', 'Logout');
INSERT INTO `cto_login_history` VALUES(32, 9, '2010-06-02', '1275533626', '1275534323', 'Logout');
INSERT INTO `cto_login_history` VALUES(33, 6, '2010-06-04', '1275653828', '1275654587', 'Logout');
INSERT INTO `cto_login_history` VALUES(34, 6, '2010-06-04', '1275654153', '1275654587', 'Logout');
INSERT INTO `cto_login_history` VALUES(35, 13, '2010-06-04', '1275656520', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(36, 16, '2010-06-08', '1275990228', '1275990559', 'Logout');
INSERT INTO `cto_login_history` VALUES(37, 9, '2010-06-10', '1276201045', '1276201056', 'Logout');
INSERT INTO `cto_login_history` VALUES(38, 9, '2010-06-10', '1276201351', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(39, 6, '2010-06-10', '1276232557', '1276234365', 'Logout');
INSERT INTO `cto_login_history` VALUES(40, 6, '2010-06-11', '1276249145', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(41, 9, '2010-06-11', '1276283697', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(42, 26, '2010-06-14', '1276518798', '1276521345', 'Logout');
INSERT INTO `cto_login_history` VALUES(43, 26, '2010-06-14', '1276519450', '1276521345', 'Logout');
INSERT INTO `cto_login_history` VALUES(44, 26, '2010-06-14', '1276520546', '1276521345', 'Logout');
INSERT INTO `cto_login_history` VALUES(45, 26, '2010-06-14', '1276521255', '1276521345', 'Logout');
INSERT INTO `cto_login_history` VALUES(46, 26, '2010-06-14', '1276521272', '1276521345', 'Logout');
INSERT INTO `cto_login_history` VALUES(47, 9, '2010-06-14', '1276570971', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(48, 9, '2010-06-15', '1276615781', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(49, 24, '2010-06-15', '1276665678', '1276665687', 'Logout');
INSERT INTO `cto_login_history` VALUES(50, 24, '2010-06-15', '1276665769', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(51, 24, '2010-06-16', '1276693707', '1276693817', 'Logout');
INSERT INTO `cto_login_history` VALUES(52, 27, '2010-06-16', '1276693902', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(53, 27, '2010-06-21', '1277185218', '1277185594', 'Logout');
INSERT INTO `cto_login_history` VALUES(54, 27, '2010-06-25', '1277532935', '1277534311', 'Logout');
INSERT INTO `cto_login_history` VALUES(55, 27, '2010-06-26', '1277536218', '1277540793', 'Logout');
INSERT INTO `cto_login_history` VALUES(56, 27, '2010-06-26', '1277541399', '1277541863', 'Logout');
INSERT INTO `cto_login_history` VALUES(57, 38, '2010-07-02', '1278064108', '1278064954', 'Logout');
INSERT INTO `cto_login_history` VALUES(58, 39, '2010-07-02', '1278064972', '1278065537', 'Logout');
INSERT INTO `cto_login_history` VALUES(59, 40, '2010-07-02', '1278065589', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(60, 9, '2010-07-05', '1278360305', '1278387165', 'Logout');
INSERT INTO `cto_login_history` VALUES(61, 9, '2010-07-06', '1278423529', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(62, 26, '2010-07-08', '1278585472', '1278585669', 'Logout');
INSERT INTO `cto_login_history` VALUES(63, 43, '2010-07-08', '1278586036', '1278586124', 'Logout');
INSERT INTO `cto_login_history` VALUES(64, 9, '2010-07-09', '1278728629', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(65, 9, '2010-07-23', '1279886471', '1279887743', 'Logout');
INSERT INTO `cto_login_history` VALUES(66, 9, '2010-07-23', '1279903129', '1279903139', 'Logout');
INSERT INTO `cto_login_history` VALUES(67, 9, '2010-07-26', '1280169579', '1280169581', 'Logout');
INSERT INTO `cto_login_history` VALUES(68, 9, '2010-07-26', '1280169640', '1280169641', 'Logout');
INSERT INTO `cto_login_history` VALUES(69, 9, '2010-07-26', '1280169679', '1280169680', 'Logout');
INSERT INTO `cto_login_history` VALUES(70, 9, '2010-07-26', '1280169830', '1280169831', 'Logout');
INSERT INTO `cto_login_history` VALUES(71, 9, '2010-07-29', '1280394449', '1280394450', 'Logout');
INSERT INTO `cto_login_history` VALUES(72, 9, '2010-07-29', '1280394501', '1280394502', 'Logout');
INSERT INTO `cto_login_history` VALUES(73, 9, '2010-07-29', '1280402051', '1280402053', 'Logout');
INSERT INTO `cto_login_history` VALUES(74, 9, '2010-07-29', '1280402078', '1280402079', 'Logout');
INSERT INTO `cto_login_history` VALUES(75, 9, '2010-07-29', '1280402108', '1280402109', 'Logout');
INSERT INTO `cto_login_history` VALUES(76, 9, '2010-07-29', '1280402445', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(77, 9, '2010-08-05', '1281064287', '1281064353', 'Logout');
INSERT INTO `cto_login_history` VALUES(78, 53, '2010-08-21', '1282417786', '1282442986', 'Logout');
INSERT INTO `cto_login_history` VALUES(79, 54, '2010-08-23', '1282550175', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(80, 54, '2010-08-23', '1282550569', '1282551445', 'Logout');
INSERT INTO `cto_login_history` VALUES(81, 47, '2010-08-23', '1282551800', '0', 'Login');
INSERT INTO `cto_login_history` VALUES(82, 55, '2010-08-25', '1282735568', '0', 'Login');

-- --------------------------------------------------------

--
-- Table structure for table `cto_main`
--

DROP TABLE IF EXISTS `cto_main`;
CREATE TABLE IF NOT EXISTS `cto_main` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `new_title` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `company_website` varchar(200) NOT NULL,
  `company_revenue` float NOT NULL,
  `company_employee` int(11) NOT NULL,
  `company_industry` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cto_main`
--


-- --------------------------------------------------------

--
-- Table structure for table `cto_management_change`
--

DROP TABLE IF EXISTS `cto_management_change`;
CREATE TABLE IF NOT EXISTS `cto_management_change` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `add_date` date NOT NULL default '0000-00-00',
  `modify_date` date NOT NULL default '0000-00-00',
  `status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `cto_management_change`
--

INSERT INTO `cto_management_change` VALUES(1, 'Appointment', '2010-03-24', '2010-03-24', 0);
INSERT INTO `cto_management_change` VALUES(2, 'Promotion', '2010-03-24', '0000-00-00', 0);
INSERT INTO `cto_management_change` VALUES(3, 'Retirement', '2010-03-24', '0000-00-00', 0);
INSERT INTO `cto_management_change` VALUES(4, 'Resignation', '2010-03-24', '0000-00-00', 0);
INSERT INTO `cto_management_change` VALUES(5, 'Termination', '2010-03-24', '0000-00-00', 0);
INSERT INTO `cto_management_change` VALUES(6, 'Lateral Move', '2010-05-27', '0000-00-00', 0);
INSERT INTO `cto_management_change` VALUES(7, 'Job Opening', '2010-08-14', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cto_meta_tag`
--

DROP TABLE IF EXISTS `cto_meta_tag`;
CREATE TABLE IF NOT EXISTS `cto_meta_tag` (
  `id` int(11) NOT NULL auto_increment,
  `page_name` varchar(255) NOT NULL,
  `page_title` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `meta_desc` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `cto_meta_tag`
--

INSERT INTO `cto_meta_tag` VALUES(1, 'Default', 'CTOsOnTheMove.com', 'tracking management changes, IT executives, CIOs, CTOs, Chief Information Officer, Chief Technology Officer', 'tracking management changes, IT executives, CIOs, CTOs, Chief Information Officer, Chief Technology Officer');
INSERT INTO `cto_meta_tag` VALUES(2, 'index.php', 'Home', '', '');
INSERT INTO `cto_meta_tag` VALUES(3, 'why-cto.php', 'Why CTOsOnTheMove?', '', '');
INSERT INTO `cto_meta_tag` VALUES(4, 'team.php', 'Our Team', '', '');
INSERT INTO `cto_meta_tag` VALUES(5, 'partners.php', 'Our Partners', '', '');
INSERT INTO `cto_meta_tag` VALUES(6, 'press-news.php', 'Press / News', '', '');
INSERT INTO `cto_meta_tag` VALUES(7, 'terms-use.php', 'Terms of Use', '', '');
INSERT INTO `cto_meta_tag` VALUES(8, 'privacy-policy.php', 'Privacy Policy', '', '');
INSERT INTO `cto_meta_tag` VALUES(9, 'copyright-policy.php', 'Copyright Policy', '', '');
INSERT INTO `cto_meta_tag` VALUES(10, 'contact-us.php', 'Contact Us', '', '');
INSERT INTO `cto_meta_tag` VALUES(11, 'pricing.php', 'Pricing', '', '');
INSERT INTO `cto_meta_tag` VALUES(12, 'site-map.php', 'Sitemap', '', '');
INSERT INTO `cto_meta_tag` VALUES(13, 'faq.php', 'FAQ', '', '');
INSERT INTO `cto_meta_tag` VALUES(14, 'logout.php', 'Logout', '', '');
INSERT INTO `cto_meta_tag` VALUES(15, 'submit-payment.php', 'Submit Payment Information', '', '');
INSERT INTO `cto_meta_tag` VALUES(16, 'provide-contact-information.php', 'Provide Contact Information', '', '');
INSERT INTO `cto_meta_tag` VALUES(17, 'choose-subscription.php', 'Chose Subscription Level', '', '');
INSERT INTO `cto_meta_tag` VALUES(18, 'forgot-password.php', 'Forgot Your Password?', '', '');
INSERT INTO `cto_meta_tag` VALUES(19, 'white-paper.php', 'White Paper Download', '', '');
INSERT INTO `cto_meta_tag` VALUES(20, 'browse.php', 'Browse', '', '');
INSERT INTO `cto_meta_tag` VALUES(21, 'browse-more.php', 'Browse', '', '');
INSERT INTO `cto_meta_tag` VALUES(22, 'alert.php', 'Alert', '', '');
INSERT INTO `cto_meta_tag` VALUES(23, 'alert-confirmation.php', 'Alert Confirmation', '', '');
INSERT INTO `cto_meta_tag` VALUES(24, 'alert-confirmation-confirm.php', 'Alert Confirmation Confirm', '', '');
INSERT INTO `cto_meta_tag` VALUES(25, 'alert-payment.php', 'Alert Payment', '', '');
INSERT INTO `cto_meta_tag` VALUES(26, 'advance-search.php', 'Advanced Search', '', '');
INSERT INTO `cto_meta_tag` VALUES(27, 'my-alert.php', 'My Alert', '', '');
INSERT INTO `cto_meta_tag` VALUES(28, 'my-profile.php', 'My Profile', '', '');
INSERT INTO `cto_meta_tag` VALUES(29, 'my-subscription.php', 'My Subscription', '', '');
INSERT INTO `cto_meta_tag` VALUES(30, 'search-result.php', 'Search Result', '', '');
INSERT INTO `cto_meta_tag` VALUES(31, 'notifications.php', 'Notifications', '', '');
INSERT INTO `cto_meta_tag` VALUES(32, 'my-change-password.php', 'Change Password', '', '');
INSERT INTO `cto_meta_tag` VALUES(33, 'priv.php', '', '', '');
INSERT INTO `cto_meta_tag` VALUES(35, 'company-list.php', 'Company Directory', '', '');
INSERT INTO `cto_meta_tag` VALUES(36, 'executives-list.php', 'IT Executives Directory', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cto_my_card`
--

DROP TABLE IF EXISTS `cto_my_card`;
CREATE TABLE IF NOT EXISTS `cto_my_card` (
  `card_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `card_type` varchar(20) NOT NULL,
  `card_number` varchar(25) NOT NULL,
  `exp_month` int(11) NOT NULL,
  `exp_year` int(11) NOT NULL,
  `security_code` varchar(20) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address_cont` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL default '0',
  `is_primary` varchar(10) NOT NULL default 'No',
  `add_date` date NOT NULL,
  `modify_date` date NOT NULL,
  `mail_send` varchar(5) NOT NULL default 'No',
  PRIMARY KEY  (`card_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `cto_my_card`
--

INSERT INTO `cto_my_card` VALUES(1, 1, 'Ananga', 'Samanta', 'Visa', '4806015924385178', 7, 2010, '962', 'ABC INFOTECH', '1 Main St', 'Garia', 'San+Jose', 'CA', '95131', 'United States', '0', 'Yes', '2010-05-10', '0000-00-00', 'Yes');
INSERT INTO `cto_my_card` VALUES(7, 15, 'Arun', 'Das', 'Visa', '4296885442880562', 5, 2014, '962', 'ABC Co.', '1 Main St', 'Garia', 'Kolkata', 'CA', '95131', 'United States', '0', 'Yes', '2010-06-08', '0000-00-00', 'No');
INSERT INTO `cto_my_card` VALUES(6, 8, 'Anit', 'Samanta', 'Visa', '4806015924385178', 5, 2012, '962', 'ABC Co.', 'Arabinda Pallee,Kolkata - 84', 'Type in the Address (Cont)', 'San+Jose', 'CA', '95131', 'United States', '0', 'Yes', '2010-05-24', '0000-00-00', 'No');
INSERT INTO `cto_my_card` VALUES(5, 6, 'Ramani', 'Nayak', 'Visa', '4806015924385178', 7, 2010, '962', 'ABC Co.', '1 Main St', 'Garia', 'San+Jose', 'CA', '95131', 'United States', '0', 'Yes', '2010-05-13', '0000-00-00', 'Yes');
INSERT INTO `cto_my_card` VALUES(8, 16, 'Arun', 'Mondal', 'Visa', '4641595351938390', 4, 2013, '962', 'ABC Co.', '1 Main St', 'Garia', 'Kolkata', 'CA', '95131', 'United States', '0', 'Yes', '2010-06-08', '0000-00-00', 'No');
INSERT INTO `cto_my_card` VALUES(9, 17, 'Arun kumar', 'Mondal', 'Visa', '4806015924385178', 4, 2013, '962', 'ABC Co.', '1 Main St', 'Garia', 'Kolkata', 'CA', '95131', 'United States', '0', 'Yes', '2010-06-08', '0000-00-00', 'No');
INSERT INTO `cto_my_card` VALUES(10, 25, 'Ananga Sty', 'Samanta', 'Visa', '4130731477084870', 4, 2012, '962', 'Abc info', '1 Main St', 'kolkata', 'San+Jose', 'CA', '95131', 'United States', '0', 'Yes', '2010-06-14', '0000-00-00', 'No');
INSERT INTO `cto_my_card` VALUES(11, 24, 'Ananga', 'samanta', 'Visa', '4101854843863424', 4, 2014, '962', 'ABC Co.', '1 Main St', 'Kolkata', 'San+Jose', 'CA', '95131', 'United States', '0', 'Yes', '2010-06-14', '0000-00-00', 'No');
INSERT INTO `cto_my_card` VALUES(12, 26, 'Ramani', 'Nayak', 'Visa', '4487872602501898', 4, 2015, '962', 'ABC Co.', '1 Main St', 'Kolkata', 'San+Jose', 'CA', '95131', 'United States', '0', 'Yes', '2010-06-14', '0000-00-00', 'No');
INSERT INTO `cto_my_card` VALUES(13, 36, 'Amit', 'Das', 'Visa', '4654422255559939', 4, 2012, '962', 'ABC INFOTECH', '1 Main St', 'Garia', 'Kolkata', 'CA', '95131', 'US', '0', 'Yes', '2010-07-01', '0000-00-00', 'No');
INSERT INTO `cto_my_card` VALUES(14, 38, 'asd', 'fgh', 'Visa', '4568772367896545', 4, 2012, '962', 'ABC Co.', '1 Main St', 'Garia', 'San+Jose', 'CA', '95131', 'US', '0', 'Yes', '2010-07-02', '0000-00-00', 'No');
INSERT INTO `cto_my_card` VALUES(15, 39, 'qqq', 'www', 'Visa', '4568772367896545', 4, 2014, '962', 'ABC INFOTECH', '1 Main St', 'Garia', 'Kolkata', 'CA', '95131', '', '0', 'Yes', '2010-07-02', '0000-00-00', 'No');
INSERT INTO `cto_my_card` VALUES(17, 42, 'Mikhail', 'Sobolev', 'Visa', '4266841189637406', 9, 2011, '295', '', '303 E 57th st 12C', '', 'New+York', 'NY', '10022', '', '0', 'Yes', '2010-07-06', '0000-00-00', 'No');
INSERT INTO `cto_my_card` VALUES(18, 26, 'Ramani', 'Nayak', 'Visa', '4296885442880562', 5, 2012, '962', 'ABC Co.', '1 Main St', 'Garia', 'Kolkata', 'CA', '95131', 'US', '0', 'No', '2010-07-08', '0000-00-00', 'No');
INSERT INTO `cto_my_card` VALUES(19, 43, 'Sujay', 'Jana', 'Visa', '4839707106272429', 5, 2012, '962', 'ABC Co.', '1 Main St', 'Garia', 'Kolkata', 'CA', '95131', '', '0', 'Yes', '2010-07-08', '0000-00-00', 'No');
INSERT INTO `cto_my_card` VALUES(20, 0, 'ghgfh', 'hgfhgf', 'Visa', '4032419407585500', 4, 2012, '962', 'ABC Info', '1 Main St', 'Garia', 'Kolkata', 'CA', '95131', '', '0', 'Yes', '2010-07-26', '0000-00-00', 'No');
INSERT INTO `cto_my_card` VALUES(21, 55, 'Testing', 'User', 'Visa', '4956211807005151', 3, 2012, '962', 'ANXeBusiness Corp. ', '1 Main St', '', 'Kolkata', 'CA', '95131', '', '0', 'Yes', '2010-08-25', '0000-00-00', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `cto_news`
--

DROP TABLE IF EXISTS `cto_news`;
CREATE TABLE IF NOT EXISTS `cto_news` (
  `news_id` int(11) NOT NULL auto_increment,
  `news_title` varchar(255) NOT NULL default '',
  `news_details` text NOT NULL,
  `add_date` varchar(50) NOT NULL default '0000-00-00',
  `status` int(1) NOT NULL default '0',
  PRIMARY KEY  (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `cto_news`
--

INSERT INTO `cto_news` VALUES(4, 'CTOsOnTheMove.com Expands IT Sales Lead Generation from Press Releases to Job Postings, SEC Filings', '<p>CTOsOnTheMove announced a website upgrade that will include an extePressbox (Press Release) - CTOsOnTheMove.com, the leading provider of lead generation solutions for technology companies selling to Chief Technology Officers (CTOs), Chief Information Officers (CIOs) and VPs of Technology and Information Systems, today announced expansion of service offerings to include coverage of job posting websites, SEC mandatory corporate filings and social media outlets.</p>\r\n<p>New York, NY March 15, 2010 &#65533; CTOsOnTheMove.com, the leading provider of lead generation solutions for technology companies, today announced that it added tracking of job posting sites, SEC filings and select social media outlets to provide unique, relevant and highly actionable sales leads to its subscribers.</p>\r\n<p>&quot;Our clients, mostly Fortune 1000 companies, are excited about this new development as we continue to drive incremental sales for them&quot; said Janna Soltero, Head of Market Research at CTOsOnTheMove.com. &quot;Selling to corporate and government CIOs and CTOs has become an increasingly crowded space and with continuing explosion of B2B content aimed at IT executive function, claims on the limited attention span of executives with budget authority rise exponentially. This creates a low responsiveness challenge that we solve for our subscribers by identifying and delivering to them in real time event-based unique sales opportunities that help them &#65533;sell more faster&#65533;.</p>\r\n<p> About CTOsOnTheMove.com  CTOsOnTheMove.com provides lead generation services to insides sales and direct marketing teams of large and midsize technology corporations. CTOsOnTheMove.com monitors in real time thousands of media sources, corporate websites, jobs boards, government publications and social media to track executive management changes and other sales triggers to provide unique, relevant, highly responsive, timely and actionable sales opportunities to its subscribers.  For more information, visit http://www.ctosonthemove.com  Contacts:  info@ctosonthemove.com </p>', '2010-08-17', 0);
INSERT INTO `cto_news` VALUES(6, 'CTOsOnTheMove.com supports Global BPO forum in New York', '<p>NEW YORK &#65533; July 22, 2010 - www.CTOsOnTheMove.com, the leading provider of lead generation solutions for technology companies selling to corporate IT Executives &#65533; Chief Information Officers, Chief Technology Officers, Vice Presidents of Technology and Information Services - announced today that it is joining the BPO forum taking place on July 28, 2010 in New Jersey as an Affiliate Supporter.  CTOsOnTheMove.com, is proud to be part of this premier event bringing together IT practitioners and trusted advisors from companies like Accenture and Tata.</p>\r\n<p>&#65533;We are certainly pleased to announce this event to our community of IT executives, CIOs, CTOs, VPs of Technology on the Corporate and Government side&#65533;, said Janna Soltero, Managing Director at CTOsOnTheMove.com.</p>\r\n<p>About http://www.CTOsOnTheMove.com </p>\r\n<p>CTOsOnTheMove.com is an online subscription-based service for vendors, advisors and service providers to the CIO/CTO community.  The service includes access to the online searchable database of corporate, government and non-profit CTOs and CIOs in North America who recently changed jobs, were promoted, or resigned; the records are collected from publically available sources, including press release services and then appended with company information and personal contact information Contact: info@ctosonthemove.com </p>', '2010-08-17', 0);
INSERT INTO `cto_news` VALUES(7, 'CTOsOnTheMove.com Sponsors Interop Forum', '<p>CTOsOnTheMove.com, the leading provider of lead generation solutions for technology companies, joined the Interop Forum as a Media Sponsor.</p>\r\n<p>New York, NY August 15, 2010 &#65533; CTOsOnTheMove.com, the leading provider of lead generation solutions for technology companies, today announced that it is supporting the Interop Forum, taking place in New York, NY on October 18, 2010 through October 22, 2010, as a media sponsor.</p>\r\n<p>&#65533;We are certainly pleased to announce this event to our community of IT executives, CIOs, CTOs, VPs of Technology on the Corporate and Government side&#65533;, said Janna Soltero, Managing Director at CTOsOnTheMove.com. Interop is the leading business technology event with the most comprehensive IT conference and expo available. Interop drives the adoption of technology, providing knowledge and insight to help IT and corporate decision-makers achieve business success. </p>\r\n<p>Part of UBM TechWeb\\''s family of global brands, Interop is the leading business technology event series. Through in-depth educational programs, workshops, real-world demonstration and live technology implementation in its unique InteropNet program, Interop provides the forum for the most powerful innovations and solutions the industry has to offer.</p>\r\n<p>About CTOsOnTheMove.com</p>\r\n<p>CTOsOnTheMove.com is an online subscription-based service for vendors, advisors and service providers to the CIO/CTO community.  The service includes access to the online searchable database of corporate, government and non-profit CTOs and CIOs in North America who recently changed jobs, were promoted, or resigned; the records are collected from publically available sources, including press release services and then appended with company information and personal contact information. For details visit http://www.ctosonthemove.com/</p>\r\n<p>Contact:  info@ctosonthemove.com</p>', '2010-08-17', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cto_page_content`
--

DROP TABLE IF EXISTS `cto_page_content`;
CREATE TABLE IF NOT EXISTS `cto_page_content` (
  `p_id` int(11) NOT NULL auto_increment,
  `page_name` varchar(50) NOT NULL default '',
  `page_title` varchar(250) NOT NULL,
  `page_content` text NOT NULL,
  PRIMARY KEY  (`p_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `cto_page_content`
--

INSERT INTO `cto_page_content` VALUES(1, 'terms-use.php', 'Terms of use', '<table cellspacing=\\"0\\" cellpadding=\\"0\\" border=\\"0\\" align=\\"center\\" width=\\"90%\\">\r\n    <tbody>\r\n        <tr>\r\n            <td valign=\\"top\\" align=\\"left\\" class=\\"terms-content-text\\">\r\n            <h2>Summary</h2>\r\n            <p>The following is a summary of the key terms under which we offer and you agree to use the &quot;CTOsOnTheMove.com&rdquo; web site (the &quot;Site&quot;). However, both parties are obligated to adhere to the full agreement which is set forth below under Terms of Use (&quot;Terms&quot;). </p>\r\n            <ul>\r\n                <li>The Site contains proprietary notices and copyright information, the terms of which must be observed and followed.</li>\r\n                <li>Information on the Site may be changed or updated without notice.</li>\r\n                <li>CTOsOnTheMove.com may change, suspend or discontinue any aspect of the Site at any time, including the availability of any Site feature, database, or content.</li>\r\n                <li>CTOsOnTheMove.com may impose limits on certain features and functionality or restrict your access to parts or all of the Site without notice or liability.</li>\r\n                <li>You agree to comply with all federal and state laws in the use of any of the data obtained through the Site, specifically including, but not limited to, email addresses. </li>\r\n            </ul>\r\n            <p>The following Terms of Use and all applicable Plan Details form a legally binding contract between you (&lsquo;Subscriber&rsquo;) and CTOsOnTheMove.com&nbsp;(&lsquo;CTOSONTHEMOVE.COM&rsquo;). CTOSONTHEMOVE.COM is the owner and operator of the business contact database, including&nbsp;related services and systems (collectively the &lsquo;system&rsquo;). You desire to have authorized access to the system. CTOSONTHEMOVE.COM authorizes access to its system subject to the following terms and conditions of use (&lsquo;terms&rsquo;). Your access to or use of the system&nbsp;is subject to these terms and CTOsOnTheMove.com will not provide the Services except pursuant to these terms. This agreement is void where prohibited. In consideration for the mutual promises contained herein, you and CTOSONTHEMOVE.COM accept and agree to the following terms:</p>\r\n            <h2>Terms of Use</h2>\r\n            <p><strong>1)&nbsp;USE OF THE SITE</strong></p>\r\n            <p><strong>1.1)&nbsp;</strong>The Site may be used only by you if you agree to be bound by these Terms, and you may not rent, lease, sublicense or transfer the Site or any data residing on it or any of your rights under this Agreement to anyone else. You may not develop or derive for commercial sale any data in any form whatsoever that incorporates or uses any part of the Site. Except with the prior written consent of CTOsOnTheMove.com, no data that resides in the Site may be transferred or made available by you to any person or entity.&nbsp;Violation of this limitation on use shall result in immediate termination of access to the Site and grounds for legal action against you. Use can be made for commercial purposes only after payment of CTOsOnTheMove.com\\''s standard fees for one or more CTOsOnTheMove.com services. </p>\r\n            <p><strong>1.2)</strong>&nbsp;CTOsOnTheMove.com may, in its sole discretion, terminate or suspend your access to all or part of the Site for any or no reason and with no prior notice to you.&nbsp;You may terminate this agreement at any time by discontinuing use of the Site. The provisions of Sections 4, 7, 8, 9 and 10 shall survive termination or expiration of this Agreement.</p>\r\n            <p><strong>2)&nbsp;CONTENT </strong></p>\r\n            <p><strong>2.1)</strong>&nbsp;All materials published on the Site including, but not limited to, news articles, photographs, company summaries, company descriptions, people summaries, contact information, and images (collectively known as the &quot;Content&quot;) are protected by copyright pursuant to U.S. and international copyright laws, and owned or controlled by CTOsOnTheMove.com or the party credited as the provider of the Content. You shall abide by all additional copyright notices, information, or restrictions contained in any Content accessed through the Site. Customer may not use the CTOsOnTheMove.com Services in a commercial service bureau environment including, but not limited to, any provision or export of data to third parties in any form whatsoever.</p>\r\n            <p><strong>2.2)</strong>&nbsp;CTOsOnTheMove.com is the sole owner of the layout, functions, appearance, trademarks and other intellectual property comprising the Site. Additionally, CTOsOnTheMove.com is the sole owner of the compiled biographical and company data, but not the cached Web pages or material that have been copied from the cached pages which belong to their respective copyright owners.</p>\r\n            <p><strong>2.3)</strong>&nbsp;CTOsOnTheMove.com is a search engine that extracts and summarizes information from the Web.&nbsp;This information may be inaccurate and we may make mistakes when extracting the information.&nbsp;CTOsOnTheMove.com assumes no responsibility regarding the accuracy of the information that is provided by CTOsOnTheMove.com and use of such information is your own risk. By furnishing information, CTOsOnTheMove.com does not grant any licenses to any copyrights, patents or any other intellectual property rights. </p>\r\n            <p><strong>2.4)</strong>&nbsp;Information on the Site may be changed or updated without notice. CTOsOnTheMove.com may also make improvements and/or changes in the products and/or the programs available on the Site at any time without notice.</p>\r\n            <p><strong>2.6)</strong>&nbsp;CTOsOnTheMove.com will utilize reasonable commercial efforts to protect the integrity of data collected by you and stored with the Site. However, CTOsOnTheMove.com shall not be liable for any loss or damage resulting from total or partial loss of your data or from any corruption of your data. Data can get lost or become corrupt as a result of a number of causes, including hardware failures, software failures or bugs, or communications failures. CTOsOnTheMove.com recommends that you periodically back up your information and Web Summaries onto media not associated with CTOsOnTheMove.com, including printing a hard copy of it.</p>\r\n            <p><strong>2.7)&nbsp;</strong>CTOsOnTheMove.com may preserve and disclose content or user information (including queries made) if required to do so by law or in the good faith belief that doing so is necessary to: </p>\r\n            <p><strong>(a)</strong> comply with legal process; </p>\r\n            <p><strong>(b)</strong> enforce these Terms, </p>\r\n            <p><strong>(c)</strong> respond to claims that any content violates the rights of third parties; </p>\r\n            <p><strong>(d)</strong> protect the rights, property, or personal safety of CTOsOnTheMove.com, its users, or the public, </p>\r\n            <p><strong>(e)</strong> administer the Site, or </p>\r\n            <p><strong>(f)</strong> comply with the request of a user or a user\\''s employer.</p>\r\n            <p><strong>2.8)</strong>&nbsp;CTOsOnTheMove.com will utilize reasonable commercial efforts to provide the Site on a 24/7 basis but it shall not be responsible for any disruption, regardless of length.&nbsp;Furthermore, CTOsOnTheMove.com shall not be liable for losses or damages you may incur due to any errors or omissions in any Content or any inaccurate interpretations of data, or due to your inability to access data due to disruption of the Site.</p>\r\n            <p><strong>3)&nbsp;USER RESPONSIBILITIES </strong></p>\r\n            <p>In using the Site, you agree not to:</p>\r\n            <p><strong>3.1)</strong>&nbsp;Knowingly transmit: </p>\r\n            <p><strong>a)&nbsp;</strong>any information, data, images, or other materials (&quot;Material&quot;) that are unlawful, harmful, threatening, defamatory, vulgar, obscene, libelous or otherwise objectionable or that may invade another\\''s right of privacy; or</p>\r\n            <p><strong>b)</strong>&nbsp;any Material that infringes any intellectual property right, including but not limited to patent, trademark, service mark, trade secret, copyright or other proprietary rights of any third party. </p>\r\n            <p><strong>3.2)</strong>&nbsp;Impersonate any person or entity or falsely state or otherwise misrepresent your affiliation with a person or entity; </p>\r\n            <p><strong>3.3)</strong>&nbsp;Violate any law; </p>\r\n            <p><strong>3.4)</strong>&nbsp;Violate or attempt to violate the security of the Site, including, without limitation:</p>\r\n            <p><strong>a)&nbsp;</strong>log in to a server or account that you are not authorized to access; </p>\r\n            <p><strong>b)</strong>&nbsp;attempt to test, scan, probe or hack the vulnerability of the Site or any network used by the Site or to breach security, encryption or other authentication measures; or</p>\r\n            <p><strong>c)</strong>&nbsp;attempt to interfere with the Site by overloading, flooding, pinging, mail bombing or crashing it.</p>\r\n            <p><strong>3.5)</strong>&nbsp;Reverse engineer, decompile or disassemble any portion of the Site. </p>\r\n            <p><strong>3.6)</strong>&nbsp;Use or attempt to use any engine, software, tool, agent or other device or mechanism (including without limitation browsers, spiders, robots, avatars or intelligent agents) to navigate or search any portion of the Site, other than the search engine and search agents available from CTOsOnTheMove.com on the Site and generally available third party web browsers (e.g., Netscape Navigator and Microsoft Explorer).</p>\r\n            <p><strong>3.7</strong>)&nbsp;Use the Site or any of the data obtained through the Site, specifically including but not limited to email addresses, to send email to any individual unless such email communication fully complies with all federal and state laws protecting said individual from unsolicited email.</p>\r\n            <p><strong>6)&nbsp;FEES</strong></p>\r\n            <p><strong>6.1) </strong>CTOsOnTheMove.com reserves the right at any time to charge fees for access to portions of the Site or the Site as a whole. However, in no event will you be charged for access to the Site unless we obtain your prior agreement to pay such charges.&nbsp;All fees paid to CTOsOnTheMove.com are non-refundable upon purchase, activation, or renewal.</p>\r\n            <p><strong>7)&nbsp;REPRESENTATIONS AND WARRANTIES </strong></p>\r\n            <p><strong>7.1)&nbsp;You represent,</strong> warrant and covenant (a) that no Materials of any kind submitted through your account will (i) violate, plagiarize, or infringe upon the rights of any third party, including copyright, trademark, privacy or other personal or proprietary rights; or (ii) contain libelous or otherwise unlawful material; and (b) that you are at least thirteen (13) years old. You hereby indemnify, defend and hold harmless CTOsOnTheMove.com, and all officers, directors, owners, agents, information providers, affiliates, licensors and licensees (collectively, the &quot;Indemnified Parties&quot; ) from and against any and all liability and costs, including, without limitation, reasonable attorneys\\'' fees, incurred by the Indemnified Parties in connection with any claim arising out of any breach by you or any user of your account of this Agreement or the foregoing representations, warranties and covenants. You shall cooperate as fully as reasonably required in the defense of any such claim. CTOsOnTheMove.com reserves the right, at its own expense, to assume the exclusive defense and control of any matter subject to indemnification by you.</p>\r\n            <p><strong>8)&nbsp;DISCLAIMERS and LIMITATIONS. </strong></p>\r\n            <p><strong>8.1)</strong>&nbsp;YOU ASSUME ALL RESPONSIBILITY AND RISK FOR YOUR USE OF THE SITE. THE SITE AND THE INFORMATION MADE AVAILABLE ON IT ARE PROVIDED &quot;AS IS&quot; WITHOUT WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO WARRANTIES OF TITLE, NONINFRINGEMENT, OR IMPLIED WARRANTIES OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE. CTOSONTHEMOVE.COM EXPRESSLY DISCLAIMS ANY WARRANTY THAT THE INFORMATION ON THE SITE SHALL BE UNINTERRUPTED OR ERROR FREE. CTOSONTHEMOVE.COM DOES NOT ASSUME ANY LEGAL LIABILITY OR RESPONSIBILITY FOR THE ACCURACY, COMPLETENESS, OR USEFULNESS OF ANY INFORMATION USED OR DISCLOSED ON THE SITE.</p>\r\n            <p><strong>8.2)</strong>&nbsp;IN NO EVENT SHALL CTOSONTHEMOVE.COM BE LIABLE FOR ANY INDIRECT, PUNITIVE, INCIDENTAL, SPECIAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF OR IN ANY WAY CONNECTED WITH YOUR USE OF THE SITE OR WITH THE DELAY OR INABILITY TO USE IT. CTOSONTHEMOVE.COM\\''S LIABILITY FOR ANY DIRECT DAMAGES SHALL BE LIMITED TO THE AMOUNT OF FEES YOU HAVE PAID FOR THE SITE FOR THE THEN-CURRENT PERIOD.&nbsp;SOME STATES OR JURISDICTIONS DO NOT ALLOW THE EXCLUSION OR LIMITATION OF LIABILITY FOR CONSEQUENTIAL OR INCIDENTAL DAMAGES AND THUS THE ABOVE LIMITATION MAY NOT APPLY TO YOU. IF THIS LIMITATION OF LIABILITY OR THE EXCLUSION OF WARRANTY SET FORTH ABOVE IS HELD INAPPLICABLE OR UNENFORCEABLE FOR ANY REASON, CTOSONTHEMOVE.COM\\''S MAXIMUM LIABILITY FOR ANY TYPE OF DAMAGES SHALL BE LIMITED TO $100. </p>\r\n            <p><strong>9)&nbsp;MUTUAL INDEMNIFICATION.</strong></p>\r\n            <p><strong>9.1)</strong>&nbsp;Each party agrees to indemnify and hold harmless the other party from and against any cost, loss or expense (including attorney\\''s fees) resulting from any claims by third parties for loss, damage or injury allegedly caused by the actions, omissions or misrepresentations of the other party, its agents or employees provided that the indemnified party provides the indemnifying party with (a) prompt written notice of such claim or action, (b) sole control and authority over the defense or settlement of such claim or action and (c) proper and full information and reasonable assistance to defend and/or settle any such claim or action.</p>\r\n            <p><strong>10)&nbsp;MISCELLANEOUS </strong></p>\r\n            <p><strong>10.1) Relationship.</strong>&nbsp;You agree that no joint venture, partnership, employment or agency relationship exists between you and CTOsOnTheMove.com as a result of this Agreement and/or your use of the Site. </p>\r\n            <p><strong>10.2) Entire Agreement.</strong>&nbsp;These Terms represent the entire binding agreement between you and CTOsOnTheMove.com, and each party\\''s respective successors and assigns, and supersede any and all prior understandings, statements or representations, whether electronic, oral or written, regarding the Site or the information therein.&nbsp;A printed version of this Agreement and of any notice given shall be admissible in judicial or administrative proceedings based upon or relating to these Terms to the same extent and subject to the same conditions as other business documents and records originally generated and maintained in printed form.</p>\r\n            <p><strong>10.3) Modifications,</strong> Assignment and Waiver. CTOsOnTheMove.com shall have the right to modify these Terms at any time by posting them on the Site and providing notice on the Site that they have been changed.&nbsp;Changes will be binding on you on the date they are posted on the Site (or as otherwise stated in any notice to you of such changes). A link will be provided to the current Terms, and CTOsOnTheMove.com recommends that you review the details of any such changes as they are binding on you regarding future use of the Site.&nbsp;Any use of the Site will be considered acceptance by you of the then-current Terms.&nbsp;If at any time you find the Terms unacceptable and do not agree to such Terms, you must terminate use of the Site.&nbsp;Any new or different terms supplied by you are specifically rejected by CTOsOnTheMove.com.&nbsp;CTOsOnTheMove.com may assign this Agreement at its discretion. You may not assign any part of this Agreement without CTOsOnTheMove.com\\''s prior written consent. No waiver of any obligation or right of either party shall be effective unless in writing, executed by the party against whom it is being enforced. </p>\r\n            <p><strong>10.4) Jurisdiction</strong>.&nbsp;This Agreement shall be governed by the applicable New York state and federal laws, without regard to its conflict of laws rules, and you hereby give your consent to have any action or dispute between yourself and CTOsOnTheMove.com resolved exclusively within the jurisdiction of the state and federal courts located in New York State. Use of the Site is unauthorized in any jurisdiction that does not give effect to all provisions of these terms and conditions, including without limitation this paragraph. </p>\r\n            <p><strong>10.5) Equitable Relief.</strong>&nbsp;You understand and agree that, in addition to money damages, CTOsOnTheMove.com shall be entitled to equitable relief where appropriate upon your breach of any portion of this Agreement.</p>\r\n            <p><strong>10.6) Severability.</strong>&nbsp;The Terms are severable and may be construed to the extent of their enforceability in light of the parties\\'' mutual intent. </p>\r\n            <p><strong>10.7) Force Majeure.</strong> If the performance of this Agreement or any obligations hereunder is prevented or interfered with by reason of fire or other casualty or accident, strikes or labor disputes, war or other violence, any law, proclamation, regulation, or requirement of any government agency, or any other act or condition beyond the reasonable control of a party hereto, that party upon giving prompt notice to the other party shall be excused from such performance during such occurrence.</p>\r\n            <p><strong>10.8) Legal Expenses.</strong> The prevailing party in any legal action brought by one party against the other that arises out of this Agreement shall be entitled, in addition to any other rights and remedies it may have, to reimbursement for its legal expenses, including court costs and reasonable attorneys\\'' fees.</p>\r\n            <p><strong>10.10)&nbsp;Notices and Other Communications.</strong>&nbsp;Notices required or permitted hereunder that are intended for you personally and not all users of the Site shall be made to you at the most recent email address on file with CTOsOnTheMove.com and shall be made to CTOsOnTheMove.com by email to &quot;<a href=\\"mailto:info@CTOsOnTheMove.com\\">info@CTOsOnTheMove.com</a>&quot; </p>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>');
INSERT INTO `cto_page_content` VALUES(2, 'privacy-policy.php', 'Privacy Policy', '<table cellspacing=\\"0\\" cellpadding=\\"0\\" border=\\"0\\" align=\\"center\\" width=\\"90%\\">\r\n    <tbody>\r\n        <tr>\r\n            <td valign=\\"top\\" align=\\"left\\" class=\\"terms-content-text\\">\r\n            <p>Protecting  the privacy and anonymity of our subscribers is important to us. This  privacy policy covers how, when and why we collect and use information  about our subscribers. Please read this policy carefully and review it  often because it may change. </p>\r\n            <h2>Overview </h2>\r\n            <ul>\r\n                <li>Subscribers  must complete a registration process. We will collect personally  identifiable information from our subscribers during registration.</li>\r\n                <li>We  do not use or share personally identifiable information other than as  described in this privacy statement. We may disclose such information  as required by law or to protect our interests or the rights of third  parties. </li>\r\n                <li>We communicate with our subscribers by email. We do not give or sell email addresses to anyone for their marketing purposes.</li>\r\n                <li>We secure information we collect using generally accepted industry standards. </li>\r\n                <li> This privacy statement may change at any time and changes take effect when posted unless otherwise indicated.</li>\r\n                <li>We  will cooperate with legal inquiries and requests made by third parties  to enforce laws or to protect their rights. Although subscribers are  anonymous while using our website, the improper or illegal use of our  website can jeopardize that anonymity.</li>\r\n            </ul>\r\n            <h2>Payment Information</h2>\r\n            <p>To  open a subscription account, subscribers must enter valid credit card  and/or other payment information needed to process their subscription  payments. We use this information for identification and verification  purposes and to process payments. We may also use this information to  contact subscribers about payment processing. When subscribers provide  payment information, it is not stored anywhere on our website, instead  it is seamlessly integrated with PayPal Merchant Solutions that has  highest in the industry security standards and protocols. </p>\r\n            <h2>Sharing Personally Identifiable Information</h2>\r\n            <p>We do not share personally identifiable information about our subscribers except as follows: </p>\r\n            <h2>Agents</h2>\r\n            <p>We  use an outside company (PayPal) to process subscription payments. This  processing company does not retain, share, store or use subscriber  payment information for any other purposes. </p>\r\n            <h2>Service Providers</h2>\r\n            <p>We  use third parties service providers for network, security, email and  hosting services for our website. We will only provide subscriber  information that is necessary for third parties to provide their  respective services to us. These third parties are prohibited from  using personally identifiable information for any other purposes. </p>\r\n            <h2>Communicating with our Subscribers</h2>\r\n            <p>We  will typically communicate with our subscribers using their registered  email address. We do not share or sell email addresses to anyone for  their marketing purposes. If we cannot reach our subscribers by email,  we may use other contact information such as their address or telephone  number. We will communicate with subscribers in accordance with their  preferences and in response to inquiries, to provide requested services  and to manage their accounts. </p>\r\n            <h2>Service-related Announcements</h2>\r\n            <p>We  will send subscribers mandatory service-related announcements and  notifications by email when necessary. Subscribers cannot opt-out of  these communications, which are not promotional in nature. If  subscribers do not wish to receive them, they have the option of  canceling their subscription. We may broadcast important messages to  all users or send individual messages to specific subscribers. </p>\r\n            <h2>Access to Information</h2>\r\n            <p>Subscribers  may access and change their registration information using the \\''My  Profile&rsquo; area provided by the website. Subscribers may change their  email address, other contact information, payment information, optional  personal profile, and their sharing, use and communication preferences.  Subscribers may access other information collected and processed about  them by using standard system functionality. To access any other  subscriber related information, if any, subscribers may email us at <a href=\\"mailto:ms@ctosonthemove.com\\">ms@ctosonthemove.com</a> </p>\r\n            <h2>Information Security</h2>\r\n            <h2>Generally accepted standards</h2>\r\n            <p>We  follow generally accepted industry standards to protect all information  collected by us. We use procedural and technical safeguards to protect  information against loss, theft and unauthorized access or disclosure  during transmission and once we receive it. Perfect security does not  exist on the Internet and no method of transmission or electronic  storage is completely secure. While we work hard to use commercially  acceptable means to protect the information, we cannot guarantee its  absolute security. </p>\r\n            <h2>Passwords</h2>\r\n            <p>During  registration, subscribers are assigned a randomly generated password.  Passwords are used to secure subscriber information and the integrity  of the website. We only store a one-way encryption of subscriber  passwords which means passwords cannot be unencrypted by us. Our login  page provides a way for subscribers to obtain access to the website in  case they lose or forget their password. </p>\r\n            <h2>Links to Other Sites</h2>\r\n            <p>Our  website contains links to other sites that are not owned or controlled  by us. We are not responsible for the privacy practices of those other  sites. This privacy statement applies only to information collected by  us through our website. You should keep aware of when you leave our  site and read the privacy statements of each and every other web site  that collects your personally identifiable information. </p>\r\n            <h2>Changes to this Privacy Policy</h2>\r\n            <p>We  reserve the right to change this privacy statement at any time, so  please review it frequently. We will post changes to this statement,  our homepage, and other places that we deem appropriate so our  subscribers are aware of what information we collect, how we use it,  and under what circumstances, if any, we disclose it. Changes shall  automatically be effective when posted unless otherwise indicated. If  we make material changes to this policy, we may notify subscribers by  email or by other prominent means online. </p>\r\n            <h2>Legal Requests</h2>\r\n            <p>We  will cooperate with law enforcement inquiries. In response to a  verified request by law enforcement or other government officials  relating to a criminal investigation or alleged illegal activity, we  may disclose subscriber information, including personally identifiable  information, without a subpoena. </p>\r\n            <p>Except  as otherwise described herein, we will not disclose subscriber  information, including personally identifiable information, without a  subpoena, court order or substantially similar legal process or  procedure, except when we believe in good faith that the disclosure of  such information is necessary to report suspected illegal or improper  activity, protect our rights or interests, protect our subscribers&rsquo;  rights or interests, protect the rights or interests of third parties,  or enforce our policies and procedures. </p>\r\n            <h2>Contact Us</h2>\r\n            <p>For more information or to make suggestions about our privacy policy, please email us at ms@ctosonthemove.com</p>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>');
INSERT INTO `cto_page_content` VALUES(3, 'copyright-policy.php', 'Copyright Policy', '<table cellspacing=\\"0\\" cellpadding=\\"0\\" border=\\"0\\" align=\\"center\\" width=\\"90%\\">\r\n    <tbody>\r\n        <tr>\r\n            <td valign=\\"top\\" align=\\"left\\" class=\\"terms-content-text\\">\r\n            <p><br />\r\n            </p>\r\n            <p>The  Content and other matters related to our Website are protected under  applicable laws relating to copyright and trademark laws. The copying,  redistribution, use or publication by you of any such matters or any  part of our Website, except as allowed under this User Agreement, is  strictly prohibited. The posting of Content on our Website or Booking  Engine does not constitute a waiver of any such rights.  CTOsOnTheMove.com and certain other trade names are either trademarks  or service marks or registered trademarks or service marks of  Actionable Information Advisory. Other product and company names  contained on the Website or Booking Engine may be trademarks or service  marks of their respective owners. Actionable Information Advisory  reserves all right, title and interest in and to its copyright and  trademark rights.</p>\r\n            <p>&nbsp;</p>\r\n            <p>&nbsp;</p>\r\n            <p>&nbsp;</p>\r\n            <p>&nbsp;</p>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>');
INSERT INTO `cto_page_content` VALUES(14, 'company-list.php', 'Company Directory', 'Browse our complete list of business contacts from the list below. To access specific company directory, click on the company name to access business contact directory.');
INSERT INTO `cto_page_content` VALUES(16, 'executives-list.php', 'IT Executives Directory', 'Browse our complete list of business professionals in the list below. To access that person\\''s complete and accurate contact information, simply click on their name for more information.');
INSERT INTO `cto_page_content` VALUES(13, 'priv.php', 'Privacy Policy', '<meta content=\\"text/html; charset=utf-8\\" http-equiv=\\"Content-Type\\" />\r\n<meta content=\\"Word.Document\\" name=\\"ProgId\\" />\r\n<meta content=\\"Microsoft Word 12\\" name=\\"Generator\\" />\r\n<meta content=\\"Microsoft Word 12\\" name=\\"Originator\\" />\r\n<link href=\\"file:///C:\\\\DOCUME~1\\\\Mike\\\\LOCALS~1\\\\Temp\\\\msohtmlclip1\\\\01\\\\clip_filelist.xml\\" rel=\\"File-List\\" />\r\n<link href=\\"file:///C:\\\\DOCUME~1\\\\Mike\\\\LOCALS~1\\\\Temp\\\\msohtmlclip1\\\\01\\\\clip_themedata.thmx\\" rel=\\"themeData\\" />\r\n<link href=\\"file:///C:\\\\DOCUME~1\\\\Mike\\\\LOCALS~1\\\\Temp\\\\msohtmlclip1\\\\01\\\\clip_colorschememapping.xml\\" rel=\\"colorSchemeMapping\\" /><!--[if gte mso 9]><xml>\r\n<w:WordDocument>\r\n<w:View>Normal</w:View>\r\n<w:Zoom>0</w:Zoom>\r\n<w:TrackMoves />\r\n<w:TrackFormatting />\r\n<w:PunctuationKerning />\r\n<w:ValidateAgainstSchemas />\r\n<w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>\r\n<w:IgnoreMixedContent>false</w:IgnoreMixedContent>\r\n<w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>\r\n<w:DoNotPromoteQF />\r\n<w:LidThemeOther>EN-US</w:LidThemeOther>\r\n<w:LidThemeAsian>X-NONE</w:LidThemeAsian>\r\n<w:LidThemeComplexScript>X-NONE</w:LidThemeComplexScript>\r\n<w:Compatibility>\r\n<w:BreakWrappedTables />\r\n<w:SnapToGridInCell />\r\n<w:WrapTextWithPunct />\r\n<w:UseAsianBreakRules />\r\n<w:DontGrowAutofit />\r\n<w:SplitPgBreakAndParaMark />\r\n<w:DontVertAlignCellWithSp />\r\n<w:DontBreakConstrainedForcedTables />\r\n<w:DontVertAlignInTxbx />\r\n<w:Word11KerningPairs />\r\n<w:CachedColBalance />\r\n</w:Compatibility>\r\n<m:mathPr>\r\n<m:mathFont m:val=\\"Cambria Math\\" />\r\n<m:brkBin m:val=\\"before\\" />\r\n<m:brkBinSub m:val=\\"&#45;-\\" />\r\n<m:smallFrac m:val=\\"off\\" />\r\n<m:dispDef />\r\n<m:lMargin m:val=\\"0\\" />\r\n<m:rMargin m:val=\\"0\\" />\r\n<m:defJc m:val=\\"centerGroup\\" />\r\n<m:wrapIndent m:val=\\"1440\\" />\r\n<m:intLim m:val=\\"subSup\\" />\r\n<m:naryLim m:val=\\"undOvr\\" />\r\n</m:mathPr></w:WordDocument>\r\n</xml><![endif]--><!--[if gte mso 9]><xml>\r\n<w:LatentStyles DefLockedState=\\"false\\" DefUnhideWhenUsed=\\"true\\"\r\nDefSemiHidden=\\"true\\" DefQFormat=\\"false\\" DefPriority=\\"99\\"\r\nLatentStyleCount=\\"267\\">\r\n<w:LsdException Locked=\\"false\\" Priority=\\"0\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Normal\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"heading 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" QFormat=\\"true\\" Name=\\"heading 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" QFormat=\\"true\\" Name=\\"heading 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" QFormat=\\"true\\" Name=\\"heading 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" QFormat=\\"true\\" Name=\\"heading 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" QFormat=\\"true\\" Name=\\"heading 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" QFormat=\\"true\\" Name=\\"heading 7\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" QFormat=\\"true\\" Name=\\"heading 8\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" QFormat=\\"true\\" Name=\\"heading 9\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 7\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 8\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 9\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"35\\" QFormat=\\"true\\" Name=\\"caption\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"10\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Title\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"1\\" Name=\\"Default Paragraph Font\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"11\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Subtitle\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"22\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Strong\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"20\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Emphasis\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"59\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Table Grid\\" />\r\n<w:LsdException Locked=\\"false\\" UnhideWhenUsed=\\"false\\" Name=\\"Placeholder Text\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"1\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"No Spacing\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"60\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Shading\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"61\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light List\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"62\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Grid\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"63\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"64\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"65\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"66\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"67\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"68\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"69\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"70\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Dark List\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"71\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Shading\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"72\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful List\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"73\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Grid\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"60\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Shading Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"61\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light List Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"62\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Grid Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"63\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 1 Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"64\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 2 Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"65\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 1 Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" UnhideWhenUsed=\\"false\\" Name=\\"Revision\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"34\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"List Paragraph\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"29\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Quote\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"30\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Intense Quote\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"66\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 2 Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"67\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 1 Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"68\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 2 Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"69\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 3 Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"70\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Dark List Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"71\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Shading Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"72\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful List Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"73\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Grid Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"60\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Shading Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"61\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light List Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"62\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Grid Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"63\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 1 Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"64\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 2 Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"65\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 1 Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"66\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 2 Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"67\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 1 Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"68\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 2 Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"69\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 3 Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"70\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Dark List Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"71\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Shading Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"72\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful List Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"73\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Grid Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"60\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Shading Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"61\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light List Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"62\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Grid Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"63\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 1 Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"64\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 2 Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"65\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 1 Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"66\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 2 Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"67\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 1 Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"68\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 2 Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"69\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 3 Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"70\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Dark List Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"71\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Shading Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"72\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful List Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"73\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Grid Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"60\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Shading Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"61\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light List Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"62\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Grid Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"63\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 1 Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"64\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 2 Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"65\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 1 Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"66\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 2 Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"67\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 1 Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"68\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 2 Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"69\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 3 Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"70\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Dark List Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"71\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Shading Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"72\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful List Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"73\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Grid Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"60\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Shading Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"61\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light List Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"62\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Grid Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"63\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 1 Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"64\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 2 Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"65\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 1 Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"66\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 2 Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"67\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 1 Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"68\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 2 Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"69\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 3 Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"70\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Dark List Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"71\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Shading Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"72\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful List Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"73\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Grid Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"60\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Shading Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"61\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light List Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"62\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Grid Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"63\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 1 Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"64\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 2 Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"65\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 1 Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"66\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 2 Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"67\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 1 Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"68\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 2 Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"69\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 3 Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"70\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Dark List Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"71\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Shading Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"72\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful List Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"73\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Grid Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"19\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Subtle Emphasis\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"21\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Intense Emphasis\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"31\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Subtle Reference\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"32\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Intense Reference\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"33\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Book Title\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"37\\" Name=\\"Bibliography\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" QFormat=\\"true\\" Name=\\"TOC Heading\\" />\r\n</w:LatentStyles>\r\n</xml><![endif]--><style type=\\"text/css\\">\r\n<!--\r\n /* Font Definitions */\r\n @font-face\r\n	{font-family:Wingdings;\r\n	panose-1:5 0 0 0 0 0 0 0 0 0;\r\n	mso-font-charset:2;\r\n	mso-generic-font-family:auto;\r\n	mso-font-pitch:variable;\r\n	mso-font-signature:0 268435456 0 0 -2147483648 0;}\r\n@font-face\r\n	{font-family:\\"Cambria Math\\";\r\n	panose-1:2 4 5 3 5 4 6 3 2 4;\r\n	mso-font-charset:0;\r\n	mso-generic-font-family:roman;\r\n	mso-font-pitch:variable;\r\n	mso-font-signature:-1610611985 1107304683 0 0 159 0;}\r\n@font-face\r\n	{font-family:Calibri;\r\n	panose-1:2 15 5 2 2 2 4 3 2 4;\r\n	mso-font-charset:0;\r\n	mso-generic-font-family:swiss;\r\n	mso-font-pitch:variable;\r\n	mso-font-signature:-1610611985 1073750139 0 0 159 0;}\r\n@font-face\r\n	{font-family:Verdana;\r\n	panose-1:2 11 6 4 3 5 4 4 2 4;\r\n	mso-font-charset:0;\r\n	mso-generic-font-family:swiss;\r\n	mso-font-pitch:variable;\r\n	mso-font-signature:536871559 0 0 0 415 0;}\r\n /* Style Definitions */\r\n p.MsoNormal, li.MsoNormal, div.MsoNormal\r\n	{mso-style-unhide:no;\r\n	mso-style-qformat:yes;\r\n	mso-style-parent:\\"\\";\r\n	margin-top:0in;\r\n	margin-right:0in;\r\n	margin-bottom:10.0pt;\r\n	margin-left:0in;\r\n	line-height:115%;\r\n	mso-pagination:widow-orphan;\r\n	font-size:11.0pt;\r\n	font-family:\\"Calibri\\",\\"sans-serif\\";\r\n	mso-ascii-font-family:Calibri;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:Calibri;\r\n	mso-fareast-theme-font:minor-latin;\r\n	mso-hansi-font-family:Calibri;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:\\"Times New Roman\\";\r\n	mso-bidi-theme-font:minor-bidi;}\r\np.MsoListParagraph, li.MsoListParagraph, div.MsoListParagraph\r\n	{mso-style-priority:34;\r\n	mso-style-unhide:no;\r\n	mso-style-qformat:yes;\r\n	margin-top:0in;\r\n	margin-right:0in;\r\n	margin-bottom:10.0pt;\r\n	margin-left:.5in;\r\n	mso-add-space:auto;\r\n	line-height:115%;\r\n	mso-pagination:widow-orphan;\r\n	font-size:11.0pt;\r\n	font-family:\\"Calibri\\",\\"sans-serif\\";\r\n	mso-ascii-font-family:Calibri;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:Calibri;\r\n	mso-fareast-theme-font:minor-latin;\r\n	mso-hansi-font-family:Calibri;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:\\"Times New Roman\\";\r\n	mso-bidi-theme-font:minor-bidi;}\r\np.MsoListParagraphCxSpFirst, li.MsoListParagraphCxSpFirst, div.MsoListParagraphCxSpFirst\r\n	{mso-style-priority:34;\r\n	mso-style-unhide:no;\r\n	mso-style-qformat:yes;\r\n	mso-style-type:export-only;\r\n	margin-top:0in;\r\n	margin-right:0in;\r\n	margin-bottom:0in;\r\n	margin-left:.5in;\r\n	margin-bottom:.0001pt;\r\n	mso-add-space:auto;\r\n	line-height:115%;\r\n	mso-pagination:widow-orphan;\r\n	font-size:11.0pt;\r\n	font-family:\\"Calibri\\",\\"sans-serif\\";\r\n	mso-ascii-font-family:Calibri;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:Calibri;\r\n	mso-fareast-theme-font:minor-latin;\r\n	mso-hansi-font-family:Calibri;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:\\"Times New Roman\\";\r\n	mso-bidi-theme-font:minor-bidi;}\r\np.MsoListParagraphCxSpMiddle, li.MsoListParagraphCxSpMiddle, div.MsoListParagraphCxSpMiddle\r\n	{mso-style-priority:34;\r\n	mso-style-unhide:no;\r\n	mso-style-qformat:yes;\r\n	mso-style-type:export-only;\r\n	margin-top:0in;\r\n	margin-right:0in;\r\n	margin-bottom:0in;\r\n	margin-left:.5in;\r\n	margin-bottom:.0001pt;\r\n	mso-add-space:auto;\r\n	line-height:115%;\r\n	mso-pagination:widow-orphan;\r\n	font-size:11.0pt;\r\n	font-family:\\"Calibri\\",\\"sans-serif\\";\r\n	mso-ascii-font-family:Calibri;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:Calibri;\r\n	mso-fareast-theme-font:minor-latin;\r\n	mso-hansi-font-family:Calibri;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:\\"Times New Roman\\";\r\n	mso-bidi-theme-font:minor-bidi;}\r\np.MsoListParagraphCxSpLast, li.MsoListParagraphCxSpLast, div.MsoListParagraphCxSpLast\r\n	{mso-style-priority:34;\r\n	mso-style-unhide:no;\r\n	mso-style-qformat:yes;\r\n	mso-style-type:export-only;\r\n	margin-top:0in;\r\n	margin-right:0in;\r\n	margin-bottom:10.0pt;\r\n	margin-left:.5in;\r\n	mso-add-space:auto;\r\n	line-height:115%;\r\n	mso-pagination:widow-orphan;\r\n	font-size:11.0pt;\r\n	font-family:\\"Calibri\\",\\"sans-serif\\";\r\n	mso-ascii-font-family:Calibri;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:Calibri;\r\n	mso-fareast-theme-font:minor-latin;\r\n	mso-hansi-font-family:Calibri;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:\\"Times New Roman\\";\r\n	mso-bidi-theme-font:minor-bidi;}\r\n.MsoChpDefault\r\n	{mso-style-type:export-only;\r\n	mso-default-props:yes;\r\n	mso-ascii-font-family:Calibri;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:Calibri;\r\n	mso-fareast-theme-font:minor-latin;\r\n	mso-hansi-font-family:Calibri;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:\\"Times New Roman\\";\r\n	mso-bidi-theme-font:minor-bidi;}\r\n.MsoPapDefault\r\n	{mso-style-type:export-only;\r\n	margin-bottom:10.0pt;\r\n	line-height:115%;}\r\n@page WordSection1\r\n	{size:8.5in 11.0in;\r\n	margin:1.0in 1.0in 1.0in 1.0in;\r\n	mso-header-margin:.5in;\r\n	mso-footer-margin:.5in;\r\n	mso-paper-source:0;}\r\ndiv.WordSection1\r\n	{page:WordSection1;}\r\n /* List Definitions */\r\n @list l0\r\n	{mso-list-id:170531796;\r\n	mso-list-type:hybrid;\r\n	mso-list-template-ids:1905412774 67698689 67698691 67698693 67698689 67698691 67698693 67698689 67698691 67698693;}\r\n@list l0:level1\r\n	{mso-level-number-format:bullet;\r\n	mso-level-text:&#61623;;\r\n	mso-level-tab-stop:none;\r\n	mso-level-number-position:left;\r\n	margin-left:71.3pt;\r\n	text-indent:-.25in;\r\n	font-family:Symbol;}\r\nol\r\n	{margin-bottom:0in;}\r\nul\r\n	{margin-bottom:0in;}\r\n-->\r\n</style><!--[if gte mso 10]>\r\n<style>\r\n/* Style Definitions */\r\ntable.MsoNormalTable\r\n{mso-style-name:\\"Table Normal\\";\r\nmso-tstyle-rowband-size:0;\r\nmso-tstyle-colband-size:0;\r\nmso-style-noshow:yes;\r\nmso-style-priority:99;\r\nmso-style-qformat:yes;\r\nmso-style-parent:\\"\\";\r\nmso-padding-alt:0in 5.4pt 0in 5.4pt;\r\nmso-para-margin-top:0in;\r\nmso-para-margin-right:0in;\r\nmso-para-margin-bottom:10.0pt;\r\nmso-para-margin-left:0in;\r\nline-height:115%;\r\nmso-pagination:widow-orphan;\r\nfont-size:11.0pt;\r\nfont-family:\\"Calibri\\",\\"sans-serif\\";\r\nmso-ascii-font-family:Calibri;\r\nmso-ascii-theme-font:minor-latin;\r\nmso-hansi-font-family:Calibri;\r\nmso-hansi-theme-font:minor-latin;}\r\n</style>\r\n<![endif]-->\r\n<meta content=\\"text/html; charset=utf-8\\" http-equiv=\\"Content-Type\\" />\r\n<meta content=\\"Word.Document\\" name=\\"ProgId\\" />\r\n<meta content=\\"Microsoft Word 12\\" name=\\"Generator\\" />\r\n<meta content=\\"Microsoft Word 12\\" name=\\"Originator\\" />\r\n<link href=\\"file:///C:\\\\DOCUME~1\\\\Mike\\\\LOCALS~1\\\\Temp\\\\msohtmlclip1\\\\01\\\\clip_filelist.xml\\" rel=\\"File-List\\" />\r\n<link href=\\"file:///C:\\\\DOCUME~1\\\\Mike\\\\LOCALS~1\\\\Temp\\\\msohtmlclip1\\\\01\\\\clip_themedata.thmx\\" rel=\\"themeData\\" />\r\n<link href=\\"file:///C:\\\\DOCUME~1\\\\Mike\\\\LOCALS~1\\\\Temp\\\\msohtmlclip1\\\\01\\\\clip_colorschememapping.xml\\" rel=\\"colorSchemeMapping\\" /><!--[if gte mso 9]><xml>\r\n<w:WordDocument>\r\n<w:View>Normal</w:View>\r\n<w:Zoom>0</w:Zoom>\r\n<w:TrackMoves />\r\n<w:TrackFormatting />\r\n<w:PunctuationKerning />\r\n<w:ValidateAgainstSchemas />\r\n<w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>\r\n<w:IgnoreMixedContent>false</w:IgnoreMixedContent>\r\n<w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>\r\n<w:DoNotPromoteQF />\r\n<w:LidThemeOther>EN-US</w:LidThemeOther>\r\n<w:LidThemeAsian>X-NONE</w:LidThemeAsian>\r\n<w:LidThemeComplexScript>X-NONE</w:LidThemeComplexScript>\r\n<w:Compatibility>\r\n<w:BreakWrappedTables />\r\n<w:SnapToGridInCell />\r\n<w:WrapTextWithPunct />\r\n<w:UseAsianBreakRules />\r\n<w:DontGrowAutofit />\r\n<w:SplitPgBreakAndParaMark />\r\n<w:DontVertAlignCellWithSp />\r\n<w:DontBreakConstrainedForcedTables />\r\n<w:DontVertAlignInTxbx />\r\n<w:Word11KerningPairs />\r\n<w:CachedColBalance />\r\n</w:Compatibility>\r\n<m:mathPr>\r\n<m:mathFont m:val=\\"Cambria Math\\" />\r\n<m:brkBin m:val=\\"before\\" />\r\n<m:brkBinSub m:val=\\"&#45;-\\" />\r\n<m:smallFrac m:val=\\"off\\" />\r\n<m:dispDef />\r\n<m:lMargin m:val=\\"0\\" />\r\n<m:rMargin m:val=\\"0\\" />\r\n<m:defJc m:val=\\"centerGroup\\" />\r\n<m:wrapIndent m:val=\\"1440\\" />\r\n<m:intLim m:val=\\"subSup\\" />\r\n<m:naryLim m:val=\\"undOvr\\" />\r\n</m:mathPr></w:WordDocument>\r\n</xml><![endif]--><!--[if gte mso 9]><xml>\r\n<w:LatentStyles DefLockedState=\\"false\\" DefUnhideWhenUsed=\\"true\\"\r\nDefSemiHidden=\\"true\\" DefQFormat=\\"false\\" DefPriority=\\"99\\"\r\nLatentStyleCount=\\"267\\">\r\n<w:LsdException Locked=\\"false\\" Priority=\\"0\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Normal\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"heading 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" QFormat=\\"true\\" Name=\\"heading 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" QFormat=\\"true\\" Name=\\"heading 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" QFormat=\\"true\\" Name=\\"heading 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" QFormat=\\"true\\" Name=\\"heading 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" QFormat=\\"true\\" Name=\\"heading 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" QFormat=\\"true\\" Name=\\"heading 7\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" QFormat=\\"true\\" Name=\\"heading 8\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"9\\" QFormat=\\"true\\" Name=\\"heading 9\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 7\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 8\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" Name=\\"toc 9\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"35\\" QFormat=\\"true\\" Name=\\"caption\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"10\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Title\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"1\\" Name=\\"Default Paragraph Font\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"11\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Subtitle\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"22\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Strong\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"20\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Emphasis\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"59\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Table Grid\\" />\r\n<w:LsdException Locked=\\"false\\" UnhideWhenUsed=\\"false\\" Name=\\"Placeholder Text\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"1\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"No Spacing\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"60\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Shading\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"61\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light List\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"62\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Grid\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"63\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"64\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"65\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"66\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"67\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"68\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"69\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"70\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Dark List\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"71\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Shading\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"72\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful List\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"73\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Grid\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"60\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Shading Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"61\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light List Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"62\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Grid Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"63\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 1 Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"64\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 2 Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"65\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 1 Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" UnhideWhenUsed=\\"false\\" Name=\\"Revision\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"34\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"List Paragraph\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"29\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Quote\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"30\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Intense Quote\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"66\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 2 Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"67\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 1 Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"68\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 2 Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"69\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 3 Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"70\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Dark List Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"71\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Shading Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"72\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful List Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"73\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Grid Accent 1\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"60\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Shading Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"61\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light List Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"62\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Grid Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"63\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 1 Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"64\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 2 Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"65\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 1 Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"66\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 2 Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"67\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 1 Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"68\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 2 Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"69\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 3 Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"70\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Dark List Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"71\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Shading Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"72\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful List Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"73\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Grid Accent 2\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"60\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Shading Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"61\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light List Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"62\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Grid Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"63\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 1 Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"64\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 2 Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"65\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 1 Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"66\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 2 Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"67\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 1 Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"68\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 2 Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"69\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 3 Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"70\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Dark List Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"71\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Shading Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"72\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful List Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"73\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Grid Accent 3\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"60\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Shading Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"61\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light List Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"62\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Grid Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"63\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 1 Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"64\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 2 Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"65\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 1 Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"66\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 2 Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"67\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 1 Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"68\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 2 Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"69\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 3 Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"70\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Dark List Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"71\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Shading Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"72\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful List Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"73\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Grid Accent 4\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"60\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Shading Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"61\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light List Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"62\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Grid Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"63\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 1 Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"64\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 2 Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"65\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 1 Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"66\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 2 Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"67\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 1 Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"68\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 2 Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"69\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 3 Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"70\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Dark List Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"71\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Shading Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"72\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful List Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"73\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Grid Accent 5\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"60\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Shading Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"61\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light List Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"62\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Light Grid Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"63\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 1 Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"64\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Shading 2 Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"65\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 1 Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"66\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium List 2 Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"67\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 1 Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"68\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 2 Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"69\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Medium Grid 3 Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"70\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Dark List Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"71\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Shading Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"72\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful List Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"73\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" Name=\\"Colorful Grid Accent 6\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"19\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Subtle Emphasis\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"21\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Intense Emphasis\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"31\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Subtle Reference\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"32\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Intense Reference\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"33\\" SemiHidden=\\"false\\"\r\nUnhideWhenUsed=\\"false\\" QFormat=\\"true\\" Name=\\"Book Title\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"37\\" Name=\\"Bibliography\\" />\r\n<w:LsdException Locked=\\"false\\" Priority=\\"39\\" QFormat=\\"true\\" Name=\\"TOC Heading\\" />\r\n</w:LatentStyles>\r\n</xml><![endif]--><style type=\\"text/css\\">\r\n<!--\r\n /* Font Definitions */\r\n @font-face\r\n	{font-family:Wingdings;\r\n	panose-1:5 0 0 0 0 0 0 0 0 0;\r\n	mso-font-charset:2;\r\n	mso-generic-font-family:auto;\r\n	mso-font-pitch:variable;\r\n	mso-font-signature:0 268435456 0 0 -2147483648 0;}\r\n@font-face\r\n	{font-family:\\"Cambria Math\\";\r\n	panose-1:2 4 5 3 5 4 6 3 2 4;\r\n	mso-font-charset:0;\r\n	mso-generic-font-family:roman;\r\n	mso-font-pitch:variable;\r\n	mso-font-signature:-1610611985 1107304683 0 0 159 0;}\r\n@font-face\r\n	{font-family:Calibri;\r\n	panose-1:2 15 5 2 2 2 4 3 2 4;\r\n	mso-font-charset:0;\r\n	mso-generic-font-family:swiss;\r\n	mso-font-pitch:variable;\r\n	mso-font-signature:-1610611985 1073750139 0 0 159 0;}\r\n@font-face\r\n	{font-family:Verdana;\r\n	panose-1:2 11 6 4 3 5 4 4 2 4;\r\n	mso-font-charset:0;\r\n	mso-generic-font-family:swiss;\r\n	mso-font-pitch:variable;\r\n	mso-font-signature:536871559 0 0 0 415 0;}\r\n /* Style Definitions */\r\n p.MsoNormal, li.MsoNormal, div.MsoNormal\r\n	{mso-style-unhide:no;\r\n	mso-style-qformat:yes;\r\n	mso-style-parent:\\"\\";\r\n	margin-top:0in;\r\n	margin-right:0in;\r\n	margin-bottom:10.0pt;\r\n	margin-left:0in;\r\n	line-height:115%;\r\n	mso-pagination:widow-orphan;\r\n	font-size:11.0pt;\r\n	font-family:\\"Calibri\\",\\"sans-serif\\";\r\n	mso-ascii-font-family:Calibri;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:Calibri;\r\n	mso-fareast-theme-font:minor-latin;\r\n	mso-hansi-font-family:Calibri;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:\\"Times New Roman\\";\r\n	mso-bidi-theme-font:minor-bidi;}\r\np.MsoListParagraph, li.MsoListParagraph, div.MsoListParagraph\r\n	{mso-style-priority:34;\r\n	mso-style-unhide:no;\r\n	mso-style-qformat:yes;\r\n	margin-top:0in;\r\n	margin-right:0in;\r\n	margin-bottom:10.0pt;\r\n	margin-left:.5in;\r\n	mso-add-space:auto;\r\n	line-height:115%;\r\n	mso-pagination:widow-orphan;\r\n	font-size:11.0pt;\r\n	font-family:\\"Calibri\\",\\"sans-serif\\";\r\n	mso-ascii-font-family:Calibri;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:Calibri;\r\n	mso-fareast-theme-font:minor-latin;\r\n	mso-hansi-font-family:Calibri;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:\\"Times New Roman\\";\r\n	mso-bidi-theme-font:minor-bidi;}\r\np.MsoListParagraphCxSpFirst, li.MsoListParagraphCxSpFirst, div.MsoListParagraphCxSpFirst\r\n	{mso-style-priority:34;\r\n	mso-style-unhide:no;\r\n	mso-style-qformat:yes;\r\n	mso-style-type:export-only;\r\n	margin-top:0in;\r\n	margin-right:0in;\r\n	margin-bottom:0in;\r\n	margin-left:.5in;\r\n	margin-bottom:.0001pt;\r\n	mso-add-space:auto;\r\n	line-height:115%;\r\n	mso-pagination:widow-orphan;\r\n	font-size:11.0pt;\r\n	font-family:\\"Calibri\\",\\"sans-serif\\";\r\n	mso-ascii-font-family:Calibri;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:Calibri;\r\n	mso-fareast-theme-font:minor-latin;\r\n	mso-hansi-font-family:Calibri;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:\\"Times New Roman\\";\r\n	mso-bidi-theme-font:minor-bidi;}\r\np.MsoListParagraphCxSpMiddle, li.MsoListParagraphCxSpMiddle, div.MsoListParagraphCxSpMiddle\r\n	{mso-style-priority:34;\r\n	mso-style-unhide:no;\r\n	mso-style-qformat:yes;\r\n	mso-style-type:export-only;\r\n	margin-top:0in;\r\n	margin-right:0in;\r\n	margin-bottom:0in;\r\n	margin-left:.5in;\r\n	margin-bottom:.0001pt;\r\n	mso-add-space:auto;\r\n	line-height:115%;\r\n	mso-pagination:widow-orphan;\r\n	font-size:11.0pt;\r\n	font-family:\\"Calibri\\",\\"sans-serif\\";\r\n	mso-ascii-font-family:Calibri;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:Calibri;\r\n	mso-fareast-theme-font:minor-latin;\r\n	mso-hansi-font-family:Calibri;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:\\"Times New Roman\\";\r\n	mso-bidi-theme-font:minor-bidi;}\r\np.MsoListParagraphCxSpLast, li.MsoListParagraphCxSpLast, div.MsoListParagraphCxSpLast\r\n	{mso-style-priority:34;\r\n	mso-style-unhide:no;\r\n	mso-style-qformat:yes;\r\n	mso-style-type:export-only;\r\n	margin-top:0in;\r\n	margin-right:0in;\r\n	margin-bottom:10.0pt;\r\n	margin-left:.5in;\r\n	mso-add-space:auto;\r\n	line-height:115%;\r\n	mso-pagination:widow-orphan;\r\n	font-size:11.0pt;\r\n	font-family:\\"Calibri\\",\\"sans-serif\\";\r\n	mso-ascii-font-family:Calibri;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:Calibri;\r\n	mso-fareast-theme-font:minor-latin;\r\n	mso-hansi-font-family:Calibri;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:\\"Times New Roman\\";\r\n	mso-bidi-theme-font:minor-bidi;}\r\n.MsoChpDefault\r\n	{mso-style-type:export-only;\r\n	mso-default-props:yes;\r\n	mso-ascii-font-family:Calibri;\r\n	mso-ascii-theme-font:minor-latin;\r\n	mso-fareast-font-family:Calibri;\r\n	mso-fareast-theme-font:minor-latin;\r\n	mso-hansi-font-family:Calibri;\r\n	mso-hansi-theme-font:minor-latin;\r\n	mso-bidi-font-family:\\"Times New Roman\\";\r\n	mso-bidi-theme-font:minor-bidi;}\r\n.MsoPapDefault\r\n	{mso-style-type:export-only;\r\n	margin-bottom:10.0pt;\r\n	line-height:115%;}\r\n@page WordSection1\r\n	{size:8.5in 11.0in;\r\n	margin:1.0in 1.0in 1.0in 1.0in;\r\n	mso-header-margin:.5in;\r\n	mso-footer-margin:.5in;\r\n	mso-paper-source:0;}\r\ndiv.WordSection1\r\n	{page:WordSection1;}\r\n /* List Definitions */\r\n @list l0\r\n	{mso-list-id:170531796;\r\n	mso-list-type:hybrid;\r\n	mso-list-template-ids:1905412774 67698689 67698691 67698693 67698689 67698691 67698693 67698689 67698691 67698693;}\r\n@list l0:level1\r\n	{mso-level-number-format:bullet;\r\n	mso-level-text:&#61623;;\r\n	mso-level-tab-stop:none;\r\n	mso-level-number-position:left;\r\n	margin-left:71.3pt;\r\n	text-indent:-.25in;\r\n	font-family:Symbol;}\r\nol\r\n	{margin-bottom:0in;}\r\nul\r\n	{margin-bottom:0in;}\r\n-->\r\n</style><!--[if gte mso 10]>\r\n<style>\r\n/* Style Definitions */\r\ntable.MsoNormalTable\r\n{mso-style-name:\\"Table Normal\\";\r\nmso-tstyle-rowband-size:0;\r\nmso-tstyle-colband-size:0;\r\nmso-style-noshow:yes;\r\nmso-style-priority:99;\r\nmso-style-qformat:yes;\r\nmso-style-parent:\\"\\";\r\nmso-padding-alt:0in 5.4pt 0in 5.4pt;\r\nmso-para-margin-top:0in;\r\nmso-para-margin-right:0in;\r\nmso-para-margin-bottom:10.0pt;\r\nmso-para-margin-left:0in;\r\nline-height:115%;\r\nmso-pagination:widow-orphan;\r\nfont-size:11.0pt;\r\nfont-family:\\"Calibri\\",\\"sans-serif\\";\r\nmso-ascii-font-family:Calibri;\r\nmso-ascii-theme-font:minor-latin;\r\nmso-hansi-font-family:Calibri;\r\nmso-hansi-theme-font:minor-latin;}\r\n</style>\r\n<![endif]-->\r\n<p align=\\"center\\" style=\\"text-align: center; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 24pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\">Privacy Policy<o:p></o:p></span></strong></p>\r\n<p style=\\"margin-bottom: 13.85pt; line-height: normal;\\" class=\\"MsoNormal\\"><span style=\\"font-size: 12pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\">Protecting the privacy and anonymity of our subscribers is important to us. This privacy policy covers how, when and why we collect and use information about our subscribers. Please read this policy carefully and review it often because it may change.</span><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 13.85pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 12.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">Overview</span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-left: 71.3pt; text-indent: -0.25in; line-height: normal;\\" class=\\"MsoListParagraphCxSpFirst\\"><!--[if !supportLists]--><span style=\\"font-family: Symbol;\\"><span style=\\"\\">&middot;<span style=\\"font: 7pt &quot;Times New Roman&quot;;\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><!--[endif]--><span style=\\"font-size: 12pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\">Subscribers must complete a registration process. We will collect personally identifiable information from our subscribers during registration. </span><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-left: 71.3pt; text-indent: -0.25in; line-height: normal;\\" class=\\"MsoListParagraphCxSpMiddle\\"><!--[if !supportLists]--><span style=\\"font-family: Symbol;\\"><span style=\\"\\">&middot;<span style=\\"font: 7pt &quot;Times New Roman&quot;;\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><!--[endif]--><span style=\\"font-size: 12pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\">We do not use or share personally identifiable information other than as described in this privacy statement. We may disclose such information as required by law or to protect our interests or the rights of third parties. </span><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-left: 71.3pt; text-indent: -0.25in; line-height: normal;\\" class=\\"MsoListParagraphCxSpMiddle\\"><!--[if !supportLists]--><span style=\\"font-family: Symbol;\\"><span style=\\"\\">&middot;<span style=\\"font: 7pt &quot;Times New Roman&quot;;\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><!--[endif]--><span style=\\"font-size: 12pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\">We communicate with our subscribers by email. We do not give or sell email addresses to anyone for their marketing purposes. </span><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-left: 71.3pt; text-indent: -0.25in; line-height: normal;\\" class=\\"MsoListParagraphCxSpMiddle\\"><!--[if !supportLists]--><span style=\\"font-family: Symbol;\\"><span style=\\"\\">&middot;<span style=\\"font: 7pt &quot;Times New Roman&quot;;\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><!--[endif]--><span style=\\"font-size: 12pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\">We secure information we collect using generally accepted industry standards. </span><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-left: 71.3pt; text-indent: -0.25in; line-height: normal;\\" class=\\"MsoListParagraphCxSpMiddle\\"><!--[if !supportLists]--><span style=\\"font-family: Symbol;\\"><span style=\\"\\">&middot;<span style=\\"font: 7pt &quot;Times New Roman&quot;;\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><!--[endif]--><span style=\\"font-size: 12pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\">This privacy statement may change at any time and changes take effect when posted unless otherwise indicated. </span><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-left: 71.3pt; text-indent: -0.25in; line-height: normal;\\" class=\\"MsoListParagraphCxSpLast\\"><!--[if !supportLists]--><span style=\\"font-family: Symbol;\\"><span style=\\"\\">&middot;<span style=\\"font: 7pt &quot;Times New Roman&quot;;\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><!--[endif]--><span style=\\"font-size: 12pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\">We will cooperate with legal inquiries and requests made by third parties to enforce laws or to protect their rights. Although subscribers are anonymous while using our website, the improper or illegal use of our website can jeopardize that anonymity. </span><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 13.85pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 12.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">Payment Information</span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 0.0001pt; line-height: normal;\\" class=\\"MsoNormal\\"><span style=\\"font-size: 12pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\">To open a subscription account, subscribers must enter valid credit card and/or other payment information needed to process their subscription payments. We use this information for identification and verification purposes and to process payments. We may also use this information to contact subscribers about payment processing. When subscribers provide payment information, it is not stored anywhere on our website, instead it is seamlessly integrated with PayPal Merchant Solutions that has highest in the industry security standards and protocols. <o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 6.9pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 8.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">&nbsp;<o:p></o:p></span></strong></p>\r\n<p style=\\"margin-bottom: 13.85pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 12.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">Sharing Personally Identifiable Information</span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 0.0001pt; line-height: normal;\\" class=\\"MsoNormal\\"><span style=\\"font-size: 12pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\">We do not share personally identifiable information about our subscribers except as follows: </span><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 6.9pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 8.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">&nbsp;</span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 6.9pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 12.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">Agents</span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 0.0001pt; line-height: normal;\\" class=\\"MsoNormal\\"><span style=\\"font-size: 12pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\">We use an outside company (PayPal) to process subscription payments. This processing company does not retain, share, store or use subscriber payment information for any other purposes. </span><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 6.9pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 8.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">&nbsp;</span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 6.9pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 12.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">Service Providers</span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 0.0001pt; line-height: normal;\\" class=\\"MsoNormal\\"><span style=\\"font-size: 12pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\">We use third parties service providers for network, security, email and hosting services for our website. We will only provide subscriber information that is necessary for third parties to provide their respective services to us. These third parties are prohibited from using personally identifiable information for any other purposes. </span><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 6.9pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 8.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">&nbsp;</span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 12.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">Communicating with our Subscribers</span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 0.0001pt; line-height: normal;\\" class=\\"MsoNormal\\"><span style=\\"font-size: 12pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\">We will typically communicate with our subscribers using their registered email address. We do not share or sell email addresses to anyone for their marketing purposes. If we cannot reach our subscribers by email, we may use other contact information such as their address or telephone number. We will communicate with subscribers in accordance with their preferences and in response to inquiries, to provide requested services and to manage their accounts. </span><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 6.9pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 8.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">&nbsp;</span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 6.9pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 12.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">Service-related Announcements </span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 6.9pt; line-height: normal;\\" class=\\"MsoNormal\\"><span style=\\"font-size: 12pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\">We will send subscribers mandatory service-related announcements and notifications by email when necessary. Subscribers cannot opt-out of these communications, which are not promotional in nature. If subscribers do not wish to receive them, they have the option of canceling their subscription. We may broadcast important messages to all users or send individual messages to specific subscribers. </span><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 6.9pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 8.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">&nbsp;</span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 6.9pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 12.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">Access to Information</span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 0.0001pt; line-height: normal;\\" class=\\"MsoNormal\\"><span style=\\"font-size: 12pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\">Subscribers may access and change their registration information using the \\''My Profile&rsquo; area provided by the website. Subscribers may change their email address, other contact information, payment information, optional personal profile, and their sharing, use and communication preferences. Subscribers may access other information collected and processed about them by using standard system functionality. To access any other subscriber related information, if any, subscribers may email us at </span><a href=\\"mailto:ms@ctosonthemove.com\\"><span style=\\"font-size: 12pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(0, 51, 204); text-decoration: none;\\">ms@ctosonthemove.com</span></a><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 0.0001pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 9.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">&nbsp;</span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 13.85pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 12.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">&nbsp;</span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 13.85pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 12.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">Information Security</span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 13.85pt; line-height: normal;\\" class=\\"MsoNormal\\"><strong><span style=\\"font-size: 12.5pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;; color: rgb(51, 51, 51);\\">Generally accepted standards</span></strong><span style=\\"font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\"><o:p></o:p></span></p>\r\n<p style=\\"margin-bottom: 0.0001pt; line-height: normal;\\" class=\\"MsoNormal\\"><span style=\\"font-size: 12pt; font-family: &quot;Verdana&quot;,&quot;sans-serif&quot;;\\">We follow generally accepted industry standards to protect all information collected by us. We ');
INSERT INTO `cto_page_content` VALUES(4, 'why-cto.php', 'Why Use CTOsOnTheMove', '<table cellspacing=\\"0\\" cellpadding=\\"0\\" border=\\"0\\" align=\\"center\\" width=\\"100%\\">\r\n    <tbody>\r\n        <tr>\r\n            <td align=\\"left\\" valign=\\"top\\" class=\\"inner-page-bold-text\\"><strong><font size=\\"3\\" face=\\"Verdana\\">Why subscribe to CTOsOnTheMove.com?&nbsp; Very simply, we are in business of getting our subscribers in front of their potential customers: corporate and government CIOs, CTOs and VPs of Technology who recently changed jobs. Our leads are:</font><br />\r\n            </strong></td>\r\n        </tr>\r\n        <tr>\r\n            <td align=\\"left\\" valign=\\"top\\" class=\\"content-text\\">\r\n            <p><font size=\\"3\\" face=\\"Verdana\\"><strong>Unique &ndash; </strong>these records do not exist in other databases</font></p>\r\n            <p><font size=\\"3\\" face=\\"Verdana\\"><strong>Timely &ndash; </strong>we sweep news sources constantly you get access to insights the value of which is perishable for two reasons: 1) IT execs are in research mode early on and 2) The window of opportunity when this information hasn&rsquo;t yet been updated in other databases is usually 3-4 months.<br />\r\n            </font></p>\r\n            <p><font size=\\"3\\" face=\\"Verdana\\"><strong>Relevant &ndash;</strong> we provide leads that are making decisions for your products, not the whole world</font></p>\r\n            <p><font size=\\"3\\" face=\\"Verdana\\"><strong>Actionable &ndash;</strong> you can send an email or place a call as soon as the news break without any additional appending and enhancing - all necessary contact information is already part of the record.</font></p>\r\n            <p><font size=\\"3\\" face=\\"Verdana\\"><strong>Conveniently delivered in the right format &ndash; </strong>access the searchable database on online or opt for a monthly update in xls format delivered straight to your email inbox.</font></p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td align=\\"left\\" valign=\\"top\\"><br />\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td align=\\"left\\" valign=\\"top\\">\r\n            <table cellspacing=\\"0\\" cellpadding=\\"0\\" border=\\"0\\" align=\\"center\\" width=\\"928\\">\r\n                <tbody>\r\n                    <tr>\r\n                        <td align=\\"left\\" width=\\"411\\" valign=\\"middle\\" class=\\"content-text\\"><font size=\\"3\\" face=\\"Verdana\\">Pay-as-you-go - $85/month, cancellable any time</font></td>\r\n                        <td align=\\"left\\" width=\\"517\\" valign=\\"top\\">\r\n                        <table cellspacing=\\"0\\" cellpadding=\\"0\\" border=\\"0\\" align=\\"left\\" width=\\"106\\">\r\n                            <tbody>\r\n                                <tr>\r\n                                    <td align=\\"center\\" valign=\\"top\\" class=\\"download_bottom\\"><a href=\\"provide-contact-information.php\\">SIGN UP HERE</a></td>\r\n                                </tr>\r\n                            </tbody>\r\n                        </table>\r\n                        </td>\r\n                    </tr>\r\n                </tbody>\r\n            </table>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>');
INSERT INTO `cto_page_content` VALUES(10, 'partners.php', 'Our Partners', 'CTOsOnTheMove partners with leading trade associations, conference organizers, executive search organizations, advisors and consultants to the IT executives. If you would like to explore partnership opportunities, please provide the following information:');
INSERT INTO `cto_page_content` VALUES(11, 'index.php', 'Page Heading', 'We Enable You to Sell More IT Faster by Providing Unique, Responsive and Actionable Sales Leads');
INSERT INTO `cto_page_content` VALUES(12, 'index.php', 'Home Page Content', 'CTOsOnTheMove tracks management changes among CIOs, CTOs, VPs of Technology to get our subscribers in front of their potential clients by providing up-to-date, relevant and highly actionable data.&nbsp; Stand out from the crowd; find out now how our solution can enhance your direct marketing efforts and increase your sales...');

-- --------------------------------------------------------

--
-- Table structure for table `cto_paging`
--

DROP TABLE IF EXISTS `cto_paging`;
CREATE TABLE IF NOT EXISTS `cto_paging` (
  `id` int(11) NOT NULL auto_increment,
  `per_page` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `cto_paging`
--

INSERT INTO `cto_paging` VALUES(1, 10);
INSERT INTO `cto_paging` VALUES(2, 20);
INSERT INTO `cto_paging` VALUES(3, 30);
INSERT INTO `cto_paging` VALUES(4, 40);
INSERT INTO `cto_paging` VALUES(5, 50);
INSERT INTO `cto_paging` VALUES(6, 60);

-- --------------------------------------------------------

--
-- Table structure for table `cto_partners`
--

DROP TABLE IF EXISTS `cto_partners`;
CREATE TABLE IF NOT EXISTS `cto_partners` (
  `partners_id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `add_date` date NOT NULL,
  PRIMARY KEY  (`partners_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `cto_partners`
--

INSERT INTO `cto_partners` VALUES(2, 'Ananga Mohan Samanta', 'http://demo.com', '983457685', 'anangahelp@yahoo.com', 'Demo testing email', '2010-05-06');
INSERT INTO `cto_partners` VALUES(5, 'Souvik Roy', 'http://templeatheart.com', '31 33 468 37 00', 'roygroup.souvik@gmail.com', 'Demo testing email', '2010-05-06');
INSERT INTO `cto_partners` VALUES(6, 'Arun Mondal', 'http://arun.com', '', 'arun@mondal.com', 'Demo testing Partner email', '2010-05-12');
INSERT INTO `cto_partners` VALUES(8, 'john doe', 'jd.com', '', 'jd@jd.com', 'test', '2010-06-02');

-- --------------------------------------------------------

--
-- Table structure for table `cto_payment`
--

DROP TABLE IF EXISTS `cto_payment`;
CREATE TABLE IF NOT EXISTS `cto_payment` (
  `payment_id` int(11) NOT NULL auto_increment,
  `payment_type` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `add_date` date NOT NULL,
  PRIMARY KEY  (`payment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `cto_payment`
--

INSERT INTO `cto_payment` VALUES(1, 'Registration', 1, 'Ananga Mohon', 'Samanta', '2RV34722FT043304B', '', '2010-04-30');
INSERT INTO `cto_payment` VALUES(2, 'Alert', 1, 'Ananga', 'Samanta', '56B28064NR987634Y', '', '2010-04-30');
INSERT INTO `cto_payment` VALUES(3, 'Alert', 1, 'Ananga', 'Samanta', '29R00192PJ8284329', '', '2010-04-30');
INSERT INTO `cto_payment` VALUES(4, 'Alert', 1, 'Ananga', 'Samanta', '4LW948345L414851Y', '', '2010-04-30');
INSERT INTO `cto_payment` VALUES(5, 'Alert', 1, 'Ananga', 'Samanta', '99N893926K198593W', '', '2010-04-30');
INSERT INTO `cto_payment` VALUES(6, 'Alert', 1, 'Ananga', 'Samanta', '7KR73046DW7552258', '', '2010-04-30');
INSERT INTO `cto_payment` VALUES(7, 'Alert', 1, 'Amit', 'Roy', '62D58717PA8009810', '', '2010-04-30');
INSERT INTO `cto_payment` VALUES(8, 'Alert', 0, 'Suman', 'Nandi', '18H502922U774004M', '', '2010-04-30');
INSERT INTO `cto_payment` VALUES(9, 'Registration', 1, 'Ananga', 'Samanta', '4XV93842L79301121', '', '2010-05-10');
INSERT INTO `cto_payment` VALUES(10, 'Registration', 2, 'Ramani', 'Nayak', '7WE584747V8557412', '', '2010-05-10');
INSERT INTO `cto_payment` VALUES(11, 'Registration', 3, 'Amit', 'Roy', '9PD314382U662264B', '', '2010-05-10');
INSERT INTO `cto_payment` VALUES(12, 'Registration', 4, 'Arun', 'Mondal', '71T53529R92064517', '', '2010-05-11');
INSERT INTO `cto_payment` VALUES(13, 'Alert', 4, 'Arun', 'Mondal', '3RE86799R1686283A', '', '2010-05-12');
INSERT INTO `cto_payment` VALUES(14, 'Alert', 4, 'Arun', 'Mondal', '6WR69777U6153101N', '', '2010-05-12');
INSERT INTO `cto_payment` VALUES(15, 'Registration', 6, 'Ramani', 'Nayak', '1DE12033A1355315T', '', '2010-05-13');
INSERT INTO `cto_payment` VALUES(16, 'Alert', 6, 'Ramani', 'Nayak', '4BH506041R905563G', '', '2010-05-17');
INSERT INTO `cto_payment` VALUES(17, 'Alert', 6, 'Ramani', 'Nayak', '95G41268Y8022053N', '', '2010-05-24');
INSERT INTO `cto_payment` VALUES(18, 'Alert', 6, 'Ramani', 'Nayak', '18418408U2311730X', '', '2010-05-24');
INSERT INTO `cto_payment` VALUES(19, 'Registration', 8, 'Anit', 'Samanta', '43M19825VR6268309', '', '2010-05-24');
INSERT INTO `cto_payment` VALUES(20, 'Registration', 15, 'Arun', 'Das', '4ER244507E619492N', '', '2010-06-08');
INSERT INTO `cto_payment` VALUES(21, 'Registration', 16, 'Arun', 'Mondal', '9C555914G8742460T', '', '2010-06-08');
INSERT INTO `cto_payment` VALUES(22, 'Alert', 17, 'Arun kumar', 'Mondal', '05D00063NB955400G', 'ec8c006b36e8d8d54ab512d29a6bb395', '2010-06-08');
INSERT INTO `cto_payment` VALUES(23, 'Registration', 17, 'Arun kumar', 'Mondal', '84N47182LF955381C', '', '2010-06-08');
INSERT INTO `cto_payment` VALUES(24, 'Registration', 25, 'Ananga Sty', 'Samanta', '3FD246231Y286461J', '', '2010-06-14');
INSERT INTO `cto_payment` VALUES(25, 'Registration', 24, 'Ananga', 'samanta', '1LD60465ER430563P', '', '2010-06-14');
INSERT INTO `cto_payment` VALUES(26, 'Registration', 26, 'Ramani', 'Nayak', '8LA34104WU6723917', '', '2010-06-14');
INSERT INTO `cto_payment` VALUES(27, 'Alert', 26, 'Ramani', 'Nayak', '1KA40110SE653853R', 'e930e44163a04251190e1e1f29de0035', '2010-06-14');
INSERT INTO `cto_payment` VALUES(28, 'Alert', 26, 'Ramani', 'Nayak', '5WE95670EG165970L', '11fd85ba3d0a15eceb075a7812ce2412', '2010-06-14');
INSERT INTO `cto_payment` VALUES(29, 'Alert', 26, 'Ramani', 'Nayak', '6NK73895E9506344R', '11fd85ba3d0a15eceb075a7812ce2412', '2010-06-14');
INSERT INTO `cto_payment` VALUES(30, 'Alert', 26, 'Ramani', 'Nayak', '48C50381D3191190T', 'a6aa253f424e15e1a5901b5cff7afce5', '2010-06-14');
INSERT INTO `cto_payment` VALUES(31, 'Registration', 36, 'Amit', 'Das', '3LL87646GU827382M', '', '2010-07-01');
INSERT INTO `cto_payment` VALUES(32, 'Registration', 38, 'asd', 'fgh', '09677960R8313593N', '', '2010-07-02');
INSERT INTO `cto_payment` VALUES(33, 'Alert', 38, 'asd', 'fgh', '0WK14091ED853882N', 'r8tovbgcn0ph6u23qt6ss5vab6', '2010-07-02');
INSERT INTO `cto_payment` VALUES(34, 'Alert', 38, 'asd', 'fgh', '1Y636900084162744', 'r8tovbgcn0ph6u23qt6ss5vab6', '2010-07-02');
INSERT INTO `cto_payment` VALUES(35, 'Registration', 39, 'qqq', 'www', '1VS34765RV666584X', '', '2010-07-02');
INSERT INTO `cto_payment` VALUES(36, 'Registration', 42, 'Mikhail', 'Sobolev', '0H9416971U676124Y', '', '2010-07-06');
INSERT INTO `cto_payment` VALUES(37, 'Registration', 44, 'Sujay', 'Jana', '0PX06095MX2986058', 'fis2es1lltmk6pp4v6178lt0v3', '2010-07-08');
INSERT INTO `cto_payment` VALUES(38, 'Registration', 0, 'ghgfh', 'hgfhgf', '2SV29084TB0677612', '01ce21llrsa92hj0t30k9c49j4', '2010-07-26');
INSERT INTO `cto_payment` VALUES(39, 'Registration', 55, 'Testing', 'User', '6RK875471M8935213', '', '2010-08-25');
INSERT INTO `cto_payment` VALUES(40, 'Alert', 55, 'Testing', 'User', '4SR67003UJ1734410', 'cf8ge1iap5gglksrgvdd9a28h1', '2010-08-25');
INSERT INTO `cto_payment` VALUES(41, 'Alert', 55, 'Testing', 'User', '0PL49813CF5869250', 'cf8ge1iap5gglksrgvdd9a28h1', '2010-08-25');

-- --------------------------------------------------------

--
-- Table structure for table `cto_payment_befor_reg`
--

DROP TABLE IF EXISTS `cto_payment_befor_reg`;
CREATE TABLE IF NOT EXISTS `cto_payment_befor_reg` (
  `session_id` varchar(100) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `add_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cto_payment_befor_reg`
--

INSERT INTO `cto_payment_befor_reg` VALUES('fis2es1lltmk6pp4v6178lt0v3', 37, '2010-07-08');
INSERT INTO `cto_payment_befor_reg` VALUES('01ce21llrsa92hj0t30k9c49j4', 38, '2010-07-26');

-- --------------------------------------------------------

--
-- Table structure for table `cto_revenue_size`
--

DROP TABLE IF EXISTS `cto_revenue_size`;
CREATE TABLE IF NOT EXISTS `cto_revenue_size` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `from_range` int(11) NOT NULL,
  `to_range` int(11) NOT NULL,
  `add_date` date NOT NULL default '0000-00-00',
  `modify_date` date NOT NULL default '0000-00-00',
  `status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `cto_revenue_size`
--

INSERT INTO `cto_revenue_size` VALUES(3, '$1-10 Million', 1, 10, '2010-03-25', '2010-05-28', 0);
INSERT INTO `cto_revenue_size` VALUES(2, '$0-1 Million', 0, 1, '2010-03-25', '2010-03-25', 0);
INSERT INTO `cto_revenue_size` VALUES(4, '$10-50 Million', 10, 50, '2010-03-25', '2010-05-28', 0);
INSERT INTO `cto_revenue_size` VALUES(5, '$50-100 Million', 50, 100, '2010-03-25', '2010-05-28', 0);
INSERT INTO `cto_revenue_size` VALUES(6, '$100-250 Million', 100, 250, '2010-03-25', '2010-08-14', 0);
INSERT INTO `cto_revenue_size` VALUES(7, '$500-1 Billion', 500, 1, '2010-03-25', '2010-08-14', 0);
INSERT INTO `cto_revenue_size` VALUES(9, ' > $ 1 Billion', 1001, 1000000, '2010-03-25', '0000-00-00', 0);
INSERT INTO `cto_revenue_size` VALUES(10, '$250-500 Million', 250, 500, '2010-08-14', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cto_search_history`
--

DROP TABLE IF EXISTS `cto_search_history`;
CREATE TABLE IF NOT EXISTS `cto_search_history` (
  `search_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `search_type` varchar(20) NOT NULL,
  `search_string` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `title` varchar(200) NOT NULL,
  `management` varchar(50) NOT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zip_code` varchar(50) NOT NULL,
  `company` varchar(200) NOT NULL,
  `industry` varchar(200) NOT NULL,
  `revenue_size` varchar(50) NOT NULL,
  `employee_size` varchar(50) NOT NULL,
  `time_period` varchar(50) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `add_date` date NOT NULL,
  PRIMARY KEY  (`search_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=123 ;

--
-- Dumping data for table `cto_search_history`
--

INSERT INTO `cto_search_history` VALUES(1, 4, 'Search', 'chief technology', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-12');
INSERT INTO `cto_search_history` VALUES(2, 4, 'Search', 'Mining & Quarrying', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-12');
INSERT INTO `cto_search_history` VALUES(3, 4, 'AdvanceSearch', '', '', '', '', 'Appointment', 'Any', 'Any', '', '', '', 'Agriculture & Mining Other', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-05-12');
INSERT INTO `cto_search_history` VALUES(4, 4, 'AdvanceSearch', '', '', '', '', 'Appointment', 'Any', 'Any', '', '', '', 'Business Services Other', 'Any', 'Any', 'In the Last 3 Months', '0000-00-00', '2010-05-12', '2010-05-12');
INSERT INTO `cto_search_history` VALUES(5, 4, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Business Services Other', 'Any', 'Any', 'In the Last 3 Months', '0000-00-00', '2010-05-12', '2010-05-12');
INSERT INTO `cto_search_history` VALUES(6, 4, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Business Services Other', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-05-12');
INSERT INTO `cto_search_history` VALUES(7, 7, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-05-20');
INSERT INTO `cto_search_history` VALUES(8, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(9, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(10, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(11, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(12, 6, 'Search', 'Chief Information Officer', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(13, 6, 'AdvanceSearch', '', '', '', '', 'Appointment', '', 'FL', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(14, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(15, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(16, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(17, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(18, 6, 'Search', 'Chief Technology Officer', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(19, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(20, 6, 'Search', 'Chief Information Officer', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(21, 6, 'Search', 'Chief Information Officer', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(22, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(23, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(24, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-21');
INSERT INTO `cto_search_history` VALUES(25, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-22');
INSERT INTO `cto_search_history` VALUES(26, 8, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-05-24');
INSERT INTO `cto_search_history` VALUES(27, 9, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-05-26');
INSERT INTO `cto_search_history` VALUES(28, 9, 'Search', 'Bryan, Agee, Chief Technology Officer, Pamiris, Business Services Other', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-27');
INSERT INTO `cto_search_history` VALUES(29, 6, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(30, 6, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(31, 6, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(32, 6, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(33, 6, 'Search', 'Alyssa Agee', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(34, 6, 'Search', 'Alyssa', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(35, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(36, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(37, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(38, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(39, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(40, 6, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(41, 1, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(42, 1, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(43, 1, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(44, 1, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(45, 1, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(46, 1, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(47, 1, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(48, 1, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(49, 1, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(50, 1, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(51, 1, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-05-28');
INSERT INTO `cto_search_history` VALUES(52, 1, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-06-01');
INSERT INTO `cto_search_history` VALUES(53, 1, 'AdvanceSearch', '', '', '', '', 'Appointment', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-06-01');
INSERT INTO `cto_search_history` VALUES(54, 1, 'AdvanceSearch', '', '', '', '', 'Appointment', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-06-01');
INSERT INTO `cto_search_history` VALUES(55, 1, 'AdvanceSearch', '', '', '', '', 'Appointment', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-06-01');
INSERT INTO `cto_search_history` VALUES(56, 1, 'AdvanceSearch', '', '', '', '', 'Appointment', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-06-01');
INSERT INTO `cto_search_history` VALUES(57, 1, 'AdvanceSearch', '', '', '', '', 'Appointment', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-06-01');
INSERT INTO `cto_search_history` VALUES(58, 1, 'AdvanceSearch', '', '', '', '', 'Appointment', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-06-01');
INSERT INTO `cto_search_history` VALUES(59, 1, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-01');
INSERT INTO `cto_search_history` VALUES(60, 1, 'Search', 'Elizabeth, Cummings, Chief Information Officer, PrivateBancorp, Business Services Other', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-01');
INSERT INTO `cto_search_history` VALUES(61, 1, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-01');
INSERT INTO `cto_search_history` VALUES(62, 1, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-01');
INSERT INTO `cto_search_history` VALUES(63, 1, 'Search', 'Joe, Brewer, Chief Information Officer, Katz Media Group, Business Services Other', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-01');
INSERT INTO `cto_search_history` VALUES(64, 9, 'AdvanceSearch', '', '', '', '', 'Appointment', 'Afghanistan', 'AZ', '', '', '', 'Any', '$50-100 Million', 'Any', 'In the Last 6 Months', '0000-00-00', '2010-06-02', '2010-06-02');
INSERT INTO `cto_search_history` VALUES(65, 9, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-06-02');
INSERT INTO `cto_search_history` VALUES(66, 9, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-06-02');
INSERT INTO `cto_search_history` VALUES(67, 9, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-06-02');
INSERT INTO `cto_search_history` VALUES(68, 6, 'AdvanceSearch', '', '', '', '', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-06-04');
INSERT INTO `cto_search_history` VALUES(69, 9, 'AdvanceSearch', '', '', '', 'Any', 'Any', 'Any', 'Any', '', '', '', 'Any', '$10-50 Million', '25-100', 'Any', '0000-00-00', '0000-00-00', '2010-06-10');
INSERT INTO `cto_search_history` VALUES(70, 9, 'Search', 'James, Froisland, Chief Information Officer, Material Sciences Corp., Real Estate and Construction Other', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-10');
INSERT INTO `cto_search_history` VALUES(71, 9, 'Search', 'James, Froisland, Chief Information Officer, Material Sciences Corp., Real Estate and Construction Other', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-10');
INSERT INTO `cto_search_history` VALUES(72, 9, 'Search', 'James, Froisland, Chief Information Officer, Material Sciences Corp., Real Estate and Construction Other', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-10');
INSERT INTO `cto_search_history` VALUES(73, 9, 'Search', 'James, Froisland, Chief Information Officer, Material Sciences Corp., Real Estate and Construction Other', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-10');
INSERT INTO `cto_search_history` VALUES(74, 6, 'AdvanceSearch', '', '', '', 'Chief Technology Officer', 'Any', 'Any', 'Any', '', '', '', 'Any', 'Any', 'Any', 'Any', '0000-00-00', '0000-00-00', '2010-06-11');
INSERT INTO `cto_search_history` VALUES(75, 26, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(76, 26, 'AdvanceSearch', '', '', '', 'Chief Information Officer', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(77, 26, 'Search', 'Elizabeth, Cummings, Chief Information Officer, PrivateBancorp, Business Services Other', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(78, 26, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(79, 26, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(80, 26, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(81, 26, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(82, 26, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(83, 26, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(84, 26, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(85, 26, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(86, 26, 'Search', 'Joe, Brewer, Chief Information Officer, Katz Media Group, Business Services Other', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(87, 26, 'AdvanceSearch', '', '', '', 'Chief Technology Officer', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(88, 26, 'AdvanceSearch', '', '', '', '', 'Appointment', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(89, 26, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(90, 26, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(91, 26, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(92, 26, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(93, 26, 'AdvanceSearch', '', '', '', 'Chief Information Officer,Chief Technology Officer', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(94, 26, 'AdvanceSearch', '', '', '', 'Chief Information Officer,Chief Technology Officer', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(95, 26, 'AdvanceSearch', '', '', '', 'Chief Information Officer,Chief Technology Officer', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(96, 26, 'AdvanceSearch', '', '', '', 'Chief Information Officer,Chief Technology Officer', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(97, 26, 'AdvanceSearch', '', '', '', 'Chief Information Officer,Chief Technology Officer', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(98, 26, 'AdvanceSearch', '', '', '', 'Chief Information Officer,Chief Technology Officer', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(99, 26, 'AdvanceSearch', '', '', '', 'Chief Information Officer,Chief Technology Officer', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(100, 26, 'AdvanceSearch', '', '', '', 'Chief Information Officer,Chief Technology Officer', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(101, 26, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(102, 9, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-14');
INSERT INTO `cto_search_history` VALUES(103, 9, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-15');
INSERT INTO `cto_search_history` VALUES(104, 9, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-15');
INSERT INTO `cto_search_history` VALUES(105, 9, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-15');
INSERT INTO `cto_search_history` VALUES(106, 9, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-15');
INSERT INTO `cto_search_history` VALUES(107, 9, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-15');
INSERT INTO `cto_search_history` VALUES(108, 24, 'AdvanceSearch', '', '', '', 'Chief Information Officer', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-15');
INSERT INTO `cto_search_history` VALUES(109, 24, 'Search', 'Jorge Sauri ', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-15');
INSERT INTO `cto_search_history` VALUES(110, 24, 'AdvanceSearch', '', 'Jorge', 'Sauri', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-15');
INSERT INTO `cto_search_history` VALUES(111, 27, 'AdvanceSearch', '', '', '', 'Chief Information Officer', 'Appointment', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-21');
INSERT INTO `cto_search_history` VALUES(112, 27, 'Search', 'h kjsdsjg hdskjgdsh gkjsdhgkjsd hkjghsdkghsd', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-06-21');
INSERT INTO `cto_search_history` VALUES(113, 27, 'AdvanceSearch', '', '', '', 'Chief Information Officer', 'Appointment', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-06-21');
INSERT INTO `cto_search_history` VALUES(114, 9, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-07-05');
INSERT INTO `cto_search_history` VALUES(115, 9, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-07-05');
INSERT INTO `cto_search_history` VALUES(116, 9, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-07-09');
INSERT INTO `cto_search_history` VALUES(117, 9, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-07-23');
INSERT INTO `cto_search_history` VALUES(118, 9, 'AdvanceSearch', '', 'Ed', 'Steinike', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-07-29');
INSERT INTO `cto_search_history` VALUES(119, 9, 'AdvanceSearch', '', 'Ed', 'Steinike', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-07-29');
INSERT INTO `cto_search_history` VALUES(120, 9, 'AdvanceSearch', '', '', 'manser', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-08-05');
INSERT INTO `cto_search_history` VALUES(121, 53, 'AdvanceSearch', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Any', '0000-00-00', '0000-00-00', '2010-08-21');
INSERT INTO `cto_search_history` VALUES(122, 55, 'Search', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '2010-08-25');

-- --------------------------------------------------------

--
-- Table structure for table `cto_social_link`
--

DROP TABLE IF EXISTS `cto_social_link`;
CREATE TABLE IF NOT EXISTS `cto_social_link` (
  `social_id` int(11) NOT NULL auto_increment,
  `social_name` varchar(255) NOT NULL,
  `social_url` varchar(255) NOT NULL,
  PRIMARY KEY  (`social_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `cto_social_link`
--

INSERT INTO `cto_social_link` VALUES(1, 'Twitter', 'http://www.twitter.com/ctosonthemove');
INSERT INTO `cto_social_link` VALUES(2, 'Facebook', 'http://www.facebook.com/CTOsOnTheMove');
INSERT INTO `cto_social_link` VALUES(3, 'Linkedin', 'http://www.linkedin.com/groups?gid=2142896');
INSERT INTO `cto_social_link` VALUES(4, 'Blog', 'http://www.CTOsOnTheMove.com/blog');

-- --------------------------------------------------------

--
-- Table structure for table `cto_state`
--

DROP TABLE IF EXISTS `cto_state`;
CREATE TABLE IF NOT EXISTS `cto_state` (
  `state_id` int(11) NOT NULL auto_increment,
  `country_id` int(11) NOT NULL,
  `state_name` varchar(150) NOT NULL,
  `short_name` varchar(10) NOT NULL,
  PRIMARY KEY  (`state_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `cto_state`
--

INSERT INTO `cto_state` VALUES(1, 223, 'Alabama', 'AL');
INSERT INTO `cto_state` VALUES(2, 223, 'Alaska', 'AK');
INSERT INTO `cto_state` VALUES(3, 223, 'Arizona', 'AZ');
INSERT INTO `cto_state` VALUES(4, 223, 'Arkansas', 'AR');
INSERT INTO `cto_state` VALUES(5, 223, 'California', 'CA');
INSERT INTO `cto_state` VALUES(6, 223, 'Colorado', 'CO');
INSERT INTO `cto_state` VALUES(7, 223, 'Connecticut', 'CT');
INSERT INTO `cto_state` VALUES(8, 223, 'Delaware', 'DE');
INSERT INTO `cto_state` VALUES(9, 223, 'Florida', 'FL');
INSERT INTO `cto_state` VALUES(10, 223, 'Georgia', 'GA');
INSERT INTO `cto_state` VALUES(11, 223, 'Hawaii', 'HI');
INSERT INTO `cto_state` VALUES(12, 223, 'Idaho', 'ID');
INSERT INTO `cto_state` VALUES(13, 223, 'Illinois', 'IL');
INSERT INTO `cto_state` VALUES(14, 223, 'Indiana', 'IN');
INSERT INTO `cto_state` VALUES(15, 223, 'Iowa', 'IA');
INSERT INTO `cto_state` VALUES(16, 223, 'Kansas', 'KS');
INSERT INTO `cto_state` VALUES(17, 223, 'Kentucky', 'KY');
INSERT INTO `cto_state` VALUES(18, 223, 'Louisiana', 'LA');
INSERT INTO `cto_state` VALUES(19, 223, 'Maine', 'ME');
INSERT INTO `cto_state` VALUES(20, 223, 'Maryland', 'MD');
INSERT INTO `cto_state` VALUES(28, 223, 'Massachusetts', 'MA');
INSERT INTO `cto_state` VALUES(29, 223, 'Michigan', 'MI');
INSERT INTO `cto_state` VALUES(30, 223, 'Minnesota', 'MN');
INSERT INTO `cto_state` VALUES(31, 223, 'Mississippi', 'MS');
INSERT INTO `cto_state` VALUES(32, 223, 'Missouri', 'MO');
INSERT INTO `cto_state` VALUES(33, 223, 'Montana', 'MT');
INSERT INTO `cto_state` VALUES(34, 223, 'Nebraska ', 'NE');
INSERT INTO `cto_state` VALUES(35, 223, 'Nevada', 'NV');
INSERT INTO `cto_state` VALUES(36, 223, 'New Hampshire', 'NH');
INSERT INTO `cto_state` VALUES(37, 223, 'New Jersey', 'NJ');
INSERT INTO `cto_state` VALUES(38, 223, 'New Mexico', 'NM');
INSERT INTO `cto_state` VALUES(39, 223, 'New York', 'NY');
INSERT INTO `cto_state` VALUES(40, 223, 'North Carolina', 'NC');
INSERT INTO `cto_state` VALUES(41, 223, 'North Dakota', 'ND');
INSERT INTO `cto_state` VALUES(42, 223, 'Ohio', 'OH');
INSERT INTO `cto_state` VALUES(43, 223, 'Oklahoma', 'OK');
INSERT INTO `cto_state` VALUES(44, 223, 'Oregon', 'OR');
INSERT INTO `cto_state` VALUES(45, 223, 'Pennsylvania', 'PA');
INSERT INTO `cto_state` VALUES(46, 223, 'Rhode Island', 'RI');
INSERT INTO `cto_state` VALUES(47, 223, 'South Carolina', 'SC');
INSERT INTO `cto_state` VALUES(48, 223, 'South Dakota', 'SD');
INSERT INTO `cto_state` VALUES(49, 223, 'Tennessee', 'TN');
INSERT INTO `cto_state` VALUES(50, 223, 'Texas', 'TX');
INSERT INTO `cto_state` VALUES(51, 223, 'Utah', 'UT');
INSERT INTO `cto_state` VALUES(52, 223, 'Vermont', 'VT');
INSERT INTO `cto_state` VALUES(53, 223, 'Virginia', 'VA');
INSERT INTO `cto_state` VALUES(54, 223, 'Washington', 'WA');
INSERT INTO `cto_state` VALUES(55, 223, 'West Virginia', 'WV');
INSERT INTO `cto_state` VALUES(56, 223, 'Wisconsin', 'WI');
INSERT INTO `cto_state` VALUES(57, 223, 'Wyoming', 'WY');
INSERT INTO `cto_state` VALUES(58, 223, 'DC', 'DC');

-- --------------------------------------------------------

--
-- Table structure for table `cto_subscription`
--

DROP TABLE IF EXISTS `cto_subscription`;
CREATE TABLE IF NOT EXISTS `cto_subscription` (
  `sub_id` int(11) NOT NULL,
  `subscription_name` varchar(255) NOT NULL,
  `benefits` varchar(255) NOT NULL,
  `best` varchar(255) NOT NULL,
  `price` text NOT NULL,
  `amount` double NOT NULL,
  PRIMARY KEY  (`sub_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cto_subscription`
--

INSERT INTO `cto_subscription` VALUES(1, 'Standard', '1 search per month, no downloads,  1 monthly general email update', 'Trying the service out', 'Free', 0);
INSERT INTO `cto_subscription` VALUES(2, 'Premium', 'Unlimited searching,  browsing access,  unlimited downloads', 'Selling to multiple industry veriticals, geographies', '$85/month<br />\r\nCancel any time', 85);
INSERT INTO `cto_subscription` VALUES(3, 'Email Alerts', 'Email alerts specified  by search parameters', 'Selling to niche industries,  geographies, markets', '$45 one-time sign up + $4.5 per alert\r\n Chose Monthly Limit:', 45);

-- --------------------------------------------------------

--
-- Table structure for table `cto_team_advisors`
--

DROP TABLE IF EXISTS `cto_team_advisors`;
CREATE TABLE IF NOT EXISTS `cto_team_advisors` (
  `ta_id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `type` varchar(20) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `add_date` date NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY  (`ta_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `cto_team_advisors`
--

INSERT INTO `cto_team_advisors` VALUES(16, 'Zach Gal, Director of Research', 'Zach has been the Director of Research at the Company since 2000. Previously he worked is a stunt double in a number of Hollywood movies, without much success however.', 'Team', 'Azhar-image-1278917760.jpg', '2010-03-19', 0);
INSERT INTO `cto_team_advisors` VALUES(14, 'Misha Sobolev, President and CEO ', 'Misha has been the President and CEO of the Company since early 2010.', 'Team', 'Misha-image-1278918507.jpg', '2010-03-19', 0);
INSERT INTO `cto_team_advisors` VALUES(15, 'George Clone, Director of Business Development', 'Brad has been the Director of Business Development for the Company since 2000. Previously he worked is a stunt double in a number of Hollywood movies, without much success however.', 'Team', 'Ilya-image-1278918472.jpg', '2010-03-19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cto_title`
--

DROP TABLE IF EXISTS `cto_title`;
CREATE TABLE IF NOT EXISTS `cto_title` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `add_date` date NOT NULL default '0000-00-00',
  `modify_date` date NOT NULL default '0000-00-00',
  `status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `cto_title`
--

INSERT INTO `cto_title` VALUES(1, 'Chief Information Officer', '2010-03-30', '0000-00-00', 0);
INSERT INTO `cto_title` VALUES(2, 'Chief Technology Officer', '2010-03-30', '0000-00-00', 0);
INSERT INTO `cto_title` VALUES(3, 'Vice President of Information Services', '2010-03-30', '0000-00-00', 0);
INSERT INTO `cto_title` VALUES(4, 'Vice President of Technology', '2010-03-30', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cto_user`
--

DROP TABLE IF EXISTS `cto_user`;
CREATE TABLE IF NOT EXISTS `cto_user` (
  `user_id` int(11) NOT NULL auto_increment,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `update_frequency` varchar(255) NOT NULL,
  `accept` int(11) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `alert_price` varchar(255) NOT NULL,
  `exp_date` date NOT NULL,
  `res_date` date NOT NULL,
  `modify_date` date NOT NULL,
  `level` varchar(50) NOT NULL,
  `status` int(11) NOT NULL default '1',
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `cto_user`
--

INSERT INTO `cto_user` VALUES(48, 'mastra', 'mastra', '', 'ads', '', 'Mike_Sobolev@yahoo.com', 'tra', '', 1, 2, '', '2020-07-23', '2010-07-23', '0000-00-00', 'Paid', 1);
INSERT INTO `cto_user` VALUES(7, 'John', 'Doe', '', '', '', 'jd@jdoe.com', 'john', '', 1, 1, '', '0000-00-00', '2010-05-20', '0000-00-00', '', 0);
INSERT INTO `cto_user` VALUES(47, 'ad', 'asd', 'ada', 'sad', '', 'ms@asdas.com', 'rad', 'Monthly', 1, 2, '', '2020-07-23', '2010-07-23', '2010-08-23', 'Paid', 1);
INSERT INTO `cto_user` VALUES(53, 'Misha', 'Sobolev', 'Director', 'AIA', 'Type in your phone', 'ms@ctosonthemove.com', 'ryazan', 'Monthly', 1, 1, '', '2020-08-21', '2010-08-21', '0000-00-00', 'Free', 0);
INSERT INTO `cto_user` VALUES(14, 'm', 'm', 'Type in the Title', 'd', 'Type in the phone Nu', 'm@ed.com', 'rta', 'Weekly', 1, 2, '', '2020-06-04', '2010-06-04', '0000-00-00', 'Paid', 1);
INSERT INTO `cto_user` VALUES(50, 'Dean', 'Crame', 'CTO', 'SysCorp Worldwide LLC', '888-473-0108', 'marketing@syscorp.net', '*bogical112*', 'Any', 1, 1, '', '2020-08-10', '2010-08-10', '0000-00-00', 'Free', 1);
INSERT INTO `cto_user` VALUES(55, 'Testing', 'User', 'Demo', 'ABC Co.', '9876543210', 'roygroup.ananga@gmail.com', '123456', 'Daily', 1, 2, '', '2020-08-25', '2010-08-25', '0000-00-00', 'Paid', 1);
INSERT INTO `cto_user` VALUES(56, 'rxgyjx', 'rxgyjx', 'fRdXGmdKhGHDCx', 'rxgyjx', '12924978026', 'ikofwg@lzqdqz.com', 'FM2Q5cib', 'ikofwg@lzqdqz.com', 0, 0, '', '2020-08-26', '2010-08-26', '0000-00-00', '', 1);
INSERT INTO `cto_user` VALUES(45, 'asf', 'as', '', 'afdsa', '', 'asas@as.com', 'ra', 'Any', 1, 1, '', '2020-07-09', '2010-07-09', '0000-00-00', 'Free', 1);
INSERT INTO `cto_user` VALUES(46, 'sd', ',', '', 'dsad', '', 'mdsfs@sa.com', 'john', 'Daily', 1, 0, '', '2020-07-21', '2010-07-21', '0000-00-00', '', 1);
INSERT INTO `cto_user` VALUES(49, 'fgfdg', 'dfgfd', 'dfgfdg', 'fgfdgd', '5654654', 'Mike_Sobolev1@yahoo.com', '123456', 'Weekly', 1, 0, '', '2020-07-26', '2010-07-26', '0000-00-00', '', 1);
INSERT INTO `cto_user` VALUES(51, 'http://bqygpcnqrmjy.com/', 'http://bqygpcnqrmjy.com/', 'yfLLBybjwza', 'FqYKHNpeOUQn', '47827823672', 'mbvooc@eumolc.com', '', 'mbvooc@eumolc.com', 0, 0, '', '2020-08-11', '2010-08-11', '0000-00-00', '', 1);
INSERT INTO `cto_user` VALUES(52, 'http://pxasystlqmot.com/', 'http://pxasystlqmot.com/', 'VtGvJcNAWvnBa', 'ZfbqFrPrBCfe', '29135520316', 'qgglid@uozcqj.com', '', 'qgglid@uozcqj.com', 0, 0, '', '2020-08-11', '2010-08-11', '0000-00-00', '', 1);
INSERT INTO `cto_user` VALUES(41, 'john', 'Wilde', 'Director', 'aida', '', 'johnwilde14@yahoo.com', 'borabora', 'Daily', 1, 1, '', '2020-07-05', '2010-07-05', '0000-00-00', 'Free', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cto_white_paper`
--

DROP TABLE IF EXISTS `cto_white_paper`;
CREATE TABLE IF NOT EXISTS `cto_white_paper` (
  `paper_id` int(11) NOT NULL auto_increment,
  `paper_name` varchar(255) NOT NULL,
  `download_path` varchar(255) NOT NULL,
  `add_date` date NOT NULL,
  `modify_date` date NOT NULL,
  `status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`paper_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `cto_white_paper`
--

INSERT INTO `cto_white_paper` VALUES(5, 'On accuracy to contact details in database', 'url.txt', '2010-03-24', '0000-00-00', 0);
INSERT INTO `cto_white_paper` VALUES(4, 'Top 10 Ways to Leverage Sales Triggers', 'menu-cms.txt', '2010-03-24', '0000-00-00', 0);
INSERT INTO `cto_white_paper` VALUES(6, 'Challenges of Direct Marketing in the Age of Social Media', 'no html file.txt', '2010-03-24', '0000-00-00', 0);
