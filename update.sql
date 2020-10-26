CREATE TABLE `orthodox_obs`.`faq` (
  `id` INT  NOT NULL AUTO_INCREMENT,
  `question` VARCHAR(1000) NULL,
  `answer` VARCHAR(1000) NULL,
  `createdDate` DATETIME NULL DEFAULT NULL,
  `updatedDate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`));


CREATE TABLE `orthodox_obs`.`question` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `phone` VARCHAR(100) NULL DEFAULT '',
  `email` VARCHAR(100) NULL DEFAULT '',
  `address` VARCHAR(255) NULL DEFAULT '',
  `question` VARCHAR(1000) NULL DEFAULT '',
  `answer` VARCHAR(1000) NULL DEFAULT '',
  `createdDate` DATETIME NULL DEFAULT NULL,
  `updatedDate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `orthodox_obs`.`prayer_request` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `phone` VARCHAR(100) NULL DEFAULT '',
  `email` VARCHAR(100) NULL DEFAULT '',
  `subject` VARCHAR(255) NULL DEFAULT '',
  `message` VARCHAR(1000) NULL DEFAULT '',
  `status` INT DEFAULT 2,
  `createdDate` DATETIME NULL DEFAULT NULL,
  `updatedDate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

  CREATE TABLE `orthodox_obs`.`notification` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(300) NULL DEFAULT NULL,
  `description` VARCHAR(1000) NULL DEFAULT '',
  `createdDate` DATETIME NULL DEFAULT NULL,
  `updatedDate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

  CREATE TABLE `orthodox_obs`.`fcm` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `unique_id` VARCHAR(200) NULL DEFAULT null,
  `fcm` VARCHAR(300) NULL DEFAULT '',
  `createdDate` DATETIME NULL DEFAULT NULL,
  `updatedDate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`));


CREATE TABLE `orthodox_obs`.`new_calender` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(500) NULL DEFAULT null,
  `description` VARCHAR(1000) NULL DEFAULT '',
  `venue` VARCHAR(200) NULL DEFAULT '',
  `startDate` DATETIME NULL DEFAULT NULL,
  `endDate` DATETIME NULL DEFAULT NULL,
  `createdDate` DATETIME NULL DEFAULT NULL,
  `updatedDate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`));
