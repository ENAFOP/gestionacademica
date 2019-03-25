# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.34)
# Database: dms
# Generation Time: 2017-05-18 13:12:59 +0000
# ************************************************************

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table tblProcesses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblProcesses`;

CREATE TABLE `tblProcesses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `created` int(11) NOT NULL DEFAULT 0,
  `createdBy` int(11) NOT NULL,
  `modified` int(11) DEFAULT NULL,
  `modifiedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idxProcessesNameUnique` (`name`),
  KEY `fkProcessesCreatedBy` (`createdBy`),
  KEY `fkProcessesModifiedBy` (`modifiedBy`),
  CONSTRAINT `fkProcessesCreatedBy` FOREIGN KEY (`createdBy`) REFERENCES `tblUsers` (`id`),
  CONSTRAINT `fkProcessesModifiedBy` FOREIGN KEY (`modifiedBy`) REFERENCES `tblUsers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tgProcessesCreated` BEFORE INSERT ON `tblProcesses` FOR EACH ROW SET new.`created` = UNIX_TIMESTAMP(NOW()) */;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tgProcessesModified` BEFORE UPDATE ON `tblProcesses` FOR EACH ROW SET new.`modified` = UNIX_TIMESTAMP(NOW()) */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


# Dump of table tblNonconformities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblNonconformities`;

CREATE TABLE `tblNonconformities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `processId` int(11) unsigned NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `source` VARCHAR(255) NULL DEFAULT '',
  `description` VARCHAR(1000) NOT NULL DEFAULT '',
  `created` int(11) NOT NULL DEFAULT 0,
  `createdBy` int(11) NOT NULL,
  `modified` int(11) DEFAULT NULL,
  `modifiedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkNonconformitiesProcessId` (`processId`),
  KEY `fkNonconformitiesCreatedBy` (`createdBy`),
  KEY `fkNonconformitiesModifiedBy` (`modifiedBy`),
  CONSTRAINT `fkNonconformitiesProcessId` FOREIGN KEY (`processId`) REFERENCES `tblProcesses` (`id`),
  CONSTRAINT `fkNonconformitiesCreatedBy` FOREIGN KEY (`createdBy`) REFERENCES `tblUsers` (`id`),
  CONSTRAINT `fkNonconformitiesModifiedBy` FOREIGN KEY (`modifiedBy`) REFERENCES `tblUsers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tgNonconformitiesCreated` BEFORE INSERT ON `tblNonconformities` FOR EACH ROW SET new.`created` = UNIX_TIMESTAMP(NOW()) */;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tgNonconformitiesModified` BEFORE UPDATE ON `tblNonconformities` FOR EACH ROW SET new.`modified` = UNIX_TIMESTAMP(NOW()) */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


# Dump of table tblActions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblActions`;

CREATE TABLE `tblActions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nonconformityId` int(11) NOT NULL,
  `description` VARCHAR(500) NOT NULL DEFAULT '',
  `dateStart` int(11) NOT NULL,
  `dateEnd` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT 0,
  `created` int(11) NOT NULL DEFAULT 0,
  `createdBy` int(11) NOT NULL,
  `modified` int(11) DEFAULT NULL,
  `modifiedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkActionsCreatedBy` (`createdBy`),
  KEY `fkActionsModifiedBy` (`modifiedBy`),
  CONSTRAINT `fkActionsnonconformityId` FOREIGN KEY (`nonconformityId`) REFERENCES `tblNonconformities` (`id`),
  CONSTRAINT `fkActionsCreatedBy` FOREIGN KEY (`createdBy`) REFERENCES `tblUsers` (`id`),
  CONSTRAINT `fkActionsModifiedBy` FOREIGN KEY (`modifiedBy`) REFERENCES `tblUsers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tgActionsCreated` BEFORE INSERT ON `tblActions` FOR EACH ROW SET new.`created` = UNIX_TIMESTAMP(NOW()) */;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tgActionsModified` BEFORE UPDATE ON `tblActions` FOR EACH ROW SET new.`modified` = UNIX_TIMESTAMP(NOW()) */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


# Dump of table tblProcessOwners
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblProcessOwners`;

CREATE TABLE `tblProcessOwners` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `processId` int(11) unsigned NOT NULL,
  `userId` int(11) NOT NULL,
  `created` int(11) NOT NULL DEFAULT 0,
  `createdBy` int(11) NOT NULL,
  `modified` int(11) DEFAULT NULL,
  `modifiedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkProcessOwnersProcessId` (`processId`),
  KEY `fkProcessOwnersUserId` (`userId`),
  KEY `fkProcessOwnersCreatedBy` (`createdBy`),
  KEY `fkProcessOwnersModifiedBy` (`modifiedBy`),
  CONSTRAINT `fkProcessOwnersProcessId` FOREIGN KEY (`processId`) REFERENCES `tblProcesses` (`id`),
  CONSTRAINT `fkProcessOwnersUserId` FOREIGN KEY (`userId`) REFERENCES `tblUsers` (`id`),
  CONSTRAINT `fkProcessOwnersCreatedBy` FOREIGN KEY (`createdBy`) REFERENCES `tblUsers` (`id`),
  CONSTRAINT `fkProcessOwnersModifiedBy` FOREIGN KEY (`modifiedBy`) REFERENCES `tblUsers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tgProcessOwnersCreated` BEFORE INSERT ON `tblProcessOwners` FOR EACH ROW SET new.`created` = UNIX_TIMESTAMP(NOW()) */;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tgProcessOwnersModified` BEFORE UPDATE ON `tblProcessOwners` FOR EACH ROW SET new.`modified` = UNIX_TIMESTAMP(NOW()) */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


# Dump of table tblActionsFollows
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblActionsFollows`;

CREATE TABLE `tblActionsFollows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actionId` int(11) NOT NULL,
  `realDateEnd` int(11) NOT NULL DEFAULT 0,
  `followResult` VARCHAR(1000) NOT NULL DEFAULT '',
  `indicatorBefore` varchar(255) NOT NULL DEFAULT '',
  `indicatorAfter` varchar(255) NOT NULL DEFAULT '',
  `finalStatus` varchar(10) NOT NULL DEFAULT '',
  `created` int(11) NOT NULL DEFAULT 0,
  `createdBy` int(11) NOT NULL,
  `modified` int(11) DEFAULT NULL,
  `modifiedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkActionsFollowsActionId` (`actionId`),
  KEY `fkActionsFollowsCreatedBy` (`createdBy`),
  KEY `fkActionsFollowsModifiedBy` (`modifiedBy`),
  CONSTRAINT `fkActionsFollowsActionId` FOREIGN KEY (`actionId`) REFERENCES `tblActions` (`id`),
  CONSTRAINT `fkActionsFollowsCreatedBy` FOREIGN KEY (`createdBy`) REFERENCES `tblUsers` (`id`),
  CONSTRAINT `fkActionsFollowsModifiedBy` FOREIGN KEY (`modifiedBy`) REFERENCES `tblUsers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tgActionsFollowsCreated` BEFORE INSERT ON `tblActionsFollows` FOR EACH ROW SET new.`created` = UNIX_TIMESTAMP(NOW()) */;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tgActionsFollowsModified` BEFORE UPDATE ON `tblActionsFollows` FOR EACH ROW SET new.`modified` = UNIX_TIMESTAMP(NOW()) */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;

# Dump of table tblNonconfoResponsibles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblNonconfoResponsibles`;

CREATE TABLE `tblNonconfoResponsibles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nonconformityId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `created` int(11) NOT NULL DEFAULT 0,
  `createdBy` int(11) NOT NULL,
  `modified` int(11) DEFAULT NULL,
  `modifiedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkNonconfoResponsiblesNonconformityId` (`nonconformityId`),
  KEY `fkNonconfoResponsiblesUserId` (`userId`),
  KEY `fkNonconfoResponsiblesCreatedBy` (`createdBy`),
  KEY `fkNonconfoResponsiblesModifiedBy` (`modifiedBy`),
  CONSTRAINT `fkNonconfoResponsiblesNonconformityId` FOREIGN KEY (`nonconformityId`) REFERENCES `tblNonconformities` (`id`),
  CONSTRAINT `fkNonconfoResponsiblesUserId` FOREIGN KEY (`userId`) REFERENCES `tblUsers` (`id`),
  CONSTRAINT `fkNonconfoResponsiblesCreatedBy` FOREIGN KEY (`createdBy`) REFERENCES `tblUsers` (`id`),
  CONSTRAINT `fkNonconfoResponsiblesModifiedBy` FOREIGN KEY (`modifiedBy`) REFERENCES `tblUsers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tgNonconfoResponsiblesCreated` BEFORE INSERT ON `tblNonconfoResponsibles` FOR EACH ROW SET new.`created` = UNIX_TIMESTAMP(NOW()) */;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tgNonconfoResponsiblesModified` BEFORE UPDATE ON `tblNonconfoResponsibles` FOR EACH ROW SET new.`modified` = UNIX_TIMESTAMP(NOW()) */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;

# Dump of table tblNonconfoAnalysis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblNonconfoAnalysis`;

CREATE TABLE `tblNonconfoAnalysis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nonconformityId` int(11) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `dir` varchar(255) NULL DEFAULT '',
  `fileName` varchar(150) NULL DEFAULT '',
  `mimeType` varchar(100) NULL DEFAULT '',
  `created` int(11) NOT NULL DEFAULT 0,
  `createdBy` int(11) NOT NULL,
  `modified` int(11) DEFAULT NULL,
  `modifiedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkNonconfoAnalysisNonconformityId` (`nonconformityId`),
  KEY `fkNonconfoAnalysisCreatedBy` (`createdBy`),
  KEY `fkNonconfoAnalysisModifiedBy` (`modifiedBy`),
  CONSTRAINT `fkNonconfoAnalysisNonconformityId` FOREIGN KEY (`nonconformityId`) REFERENCES `tblNonconformities` (`id`),
  CONSTRAINT `fkNonconfoAnalysisCreatedBy` FOREIGN KEY (`createdBy`) REFERENCES `tblUsers` (`id`),
  CONSTRAINT `fkNonconfoAnalysisModifiedBy` FOREIGN KEY (`modifiedBy`) REFERENCES `tblUsers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tgNonconfoAnalysisCreated` BEFORE INSERT ON `tblNonconfoAnalysis` FOR EACH ROW SET new.`created` = UNIX_TIMESTAMP(NOW()) */;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tgNonconfoAnalysisModified` BEFORE UPDATE ON `tblNonconfoAnalysis` FOR EACH ROW SET new.`modified` = UNIX_TIMESTAMP(NOW()) */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;

# Dump of table tblActionsComments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tblActionsComments`;

CREATE TABLE `tblActionsComments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actionId` int(11) NOT NULL,
  `description` varchar(500) NOT NULL DEFAULT '',
  `created` int(11) NOT NULL DEFAULT 0,
  `createdBy` int(11) NOT NULL,
  `modified` int(11) DEFAULT NULL,
  `modifiedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkActionsCommentsActionId` (`actionId`),
  KEY `fkActionsCommentsCreatedBy` (`createdBy`),
  KEY `fkActionsCommentsModifiedBy` (`modifiedBy`),
  CONSTRAINT `fkActionsCommentsActionId` FOREIGN KEY (`actionId`) REFERENCES `tblActions` (`id`),
  CONSTRAINT `fkActionsCommentsCreatedBy` FOREIGN KEY (`createdBy`) REFERENCES `tblUsers` (`id`),
  CONSTRAINT `fkActionsCommentsModifiedBy` FOREIGN KEY (`modifiedBy`) REFERENCES `tblUsers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tgActionsCommentsCreated` BEFORE INSERT ON `tblActionsComments` FOR EACH ROW SET new.`created` = UNIX_TIMESTAMP(NOW()) */;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tgActionsCommentsModified` BEFORE UPDATE ON `tblActionsComments` FOR EACH ROW SET new.`modified` = UNIX_TIMESTAMP(NOW()) */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


/* Alter tables */
ALTER TABLE `tblNonconformities` ADD `correlative` VARCHAR(50) NULL DEFAULT NULL AFTER `id`;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


