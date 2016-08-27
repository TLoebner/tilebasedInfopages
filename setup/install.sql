-- 
--  Copyright [2016] [Torsten Loebner <loebnert@gmail.com>]
--
--  Licensed under the Apache License, Version 2.0 (the "License");
--  you may not use this file except in compliance with the License.
--  You may obtain a copy of the License at
--
--    http://www.apache.org/licenses/LICENSE-2.0
--
--				or
--
--    https://github.com/TLoebner/tilebasedInfopages/blob/master/LICENSE
--
--  Unless required by applicable law or agreed to in writing, software
--  distributed under the License is distributed on an "AS IS" BASIS,
--  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
--  See the License for the specific language governing permissions and
--  limitations under the License.
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;

START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `TileInfoPage` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `TileInfoPage`;

DROP TABLE IF EXISTS `TileInfoPage`.`help_sections`;
CREATE TABLE IF NOT EXISTS `TileInfoPage`.`help_sections` (
  `pk` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sequence_no` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `fg` varchar(7),
  `bg` varchar(7),
  `image` MEDIUMBLOB,
  PRIMARY KEY (pk)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `TileInfoPage`.`help_subsections`;
CREATE TABLE IF NOT EXISTS `TileInfoPage`.`help_subsections` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` text,
  `sequence_no` int(11) DEFAULT NULL,
  `description` text,
  `help_section_fk` int(11) unsigned NOT NULL,
  PRIMARY KEY (pk),
  INDEX (help_section_fk),
  FOREIGN KEY (help_section_fk) REFERENCES help_sections(pk)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `TileInfoPage`.`help_contents`;
CREATE TABLE IF NOT EXISTS `TileInfoPage`.`help_contents` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` text,
  `link` text,
  `description` text,
  `meta_name` text,
  `meta_description` text,
  `http_result` varchar(10),
  `google_results` text,
  PRIMARY KEY (pk)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `TileInfoPage`.`help_multicontents`;
CREATE TABLE `TileInfoPage`.`help_multicontents` (
  `sequence_no` INT NULL,
  `help_subsection_fk` int(11) unsigned NOT NULL,
  `help_content_fk` int(11) unsigned NOT NULL,
  `uid` varchar(23)  NOT NULL,
  PRIMARY KEY (`help_subsection_fk`, `help_content_fk`),
  INDEX `fk_content_idx_idx` (`help_content_fk` ASC),
  CONSTRAINT `fk_subsection_idx`
    FOREIGN KEY (`help_subsection_fk`)
    REFERENCES `TileInfoPage`.`help_subsections` (`pk`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_content_idx`
    FOREIGN KEY (`help_content_fk`)
    REFERENCES `TileInfoPage`.`help_contents` (`pk`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

DROP TABLE IF EXISTS `faq_sections`;
CREATE TABLE IF NOT EXISTS `faq_sections` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` text,
  `description` text,
  `sequence_no` int(11) DEFAULT NULL,
  `fg` varchar(7),
  `bg` varchar(7),
  `image` MEDIUMBLOB,
  PRIMARY KEY (pk)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `faq_contents`;
CREATE TABLE IF NOT EXISTS `faq_contents` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `link` text,
  `question` text,
  `answer` text,
  PRIMARY KEY (pk)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `TileInfoPage`.`faq_multicontents`;
CREATE TABLE `TileInfoPage`.`faq_multicontents` (
  `sequence_no` INT NULL,
  `faq_section_fk` int(11) unsigned NOT NULL,
  `faq_content_fk` int(11) unsigned NOT NULL,
  `uid` varchar(23)  NOT NULL,
  PRIMARY KEY (`faq_section_fk`, `faq_content_fk`),
  INDEX `fk_content2_idx_idx` (`faq_content_fk` ASC),
  CONSTRAINT `fk_section_idx`
    FOREIGN KEY (`faq_section_fk`)
    REFERENCES `TileInfoPage`.`faq_sections` (`pk`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_content2_idx`
    FOREIGN KEY (`faq_content_fk`)
    REFERENCES `TileInfoPage`.`faq_contents` (`pk`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `TileInfoPage`.`incidents`;
CREATE TABLE `TileInfoPage`.`incidents` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  PRIMARY KEY (`pk`)
);


DROP TABLE IF EXISTS `TileInfoPage`.`faq_incidents`;
CREATE TABLE `TileInfoPage`.`faq_incidents` (
  `incident_fk` int(11) unsigned  NOT NULL,
  `faq_content_fk` int(11) unsigned  NOT NULL,
  `status` ENUM('new', 'in progress', 'done') NOT NULL,
  `comments` TEXT NULL,
  PRIMARY KEY (`incident_fk`, `faq_content_fk`),
  INDEX `fk_incident_1_idx` (`incident_fk` ASC),
  CONSTRAINT `fk_incident_1`
    FOREIGN KEY (`incident_fk`)
    REFERENCES `TileInfoPage`.`incidents` (`pk`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_faq_content_5`
    FOREIGN KEY (`faq_content_fk`)
    REFERENCES `TileInfoPage`.`faq_contents` (`pk`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

DROP TABLE IF EXISTS `TileInfoPage`.`help_incidents`;
CREATE TABLE `TileInfoPage`.`help_incidents` (
  `incident_fk` int(11) unsigned  NOT NULL,
  `help_content_fk` int(11) unsigned  NOT NULL,
  `status` ENUM('new', 'in progress', 'done') NOT NULL,
  `comments` TEXT NULL,
  PRIMARY KEY (`incident_fk`, `help_content_fk`),
  INDEX `fk_incident_2_idx` (`incident_fk` ASC),
  CONSTRAINT `fk_incident_2`
    FOREIGN KEY (`incident_fk`)
    REFERENCES `TileInfoPage`.`incidents` (`pk`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_help_content_5`
    FOREIGN KEY (`help_content_fk`)
    REFERENCES `TileInfoPage`.`help_contents` (`pk`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


DROP TABLE IF EXISTS `screensaver`;
CREATE TABLE IF NOT EXISTS `screensaver` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sequence_no` INT NULL,
  `due_date` DATE NULL,
  `image_type` varchar(25) NOT NULL,
  `image` MEDIUMBLOB NOT NULL,
  `image_size` varchar(25) NOT NULL,
  `image_ctgy` varchar(25) NOT NULL,
  `image_name` varchar(50) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `index_pics`;
CREATE TABLE IF NOT EXISTS `index_pics` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sequence_no` INT NULL,
  `image_type` varchar(25) NOT NULL,
  `image` MEDIUMBLOB NOT NULL,
  `image_size` varchar(25) NOT NULL,
  `image_ctgy` varchar(25) NOT NULL,
  `image_name` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `due_date` TIMESTAMP,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `styles`;
CREATE TABLE IF NOT EXISTS `styles` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `TileInfoPage`.`searches`;
CREATE TABLE IF NOT EXISTS `TileInfoPage`.`searches` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(40) NOT NULL,
  `string` varchar(100) NOT NULL,
  `creation` TIMESTAMP NOT NULL,
  PRIMARY KEY (pk)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `TileInfoPage`.`search_results`;
CREATE TABLE IF NOT EXISTS `TileInfoPage`.`search_results` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `searches_fk` int(11) unsigned NOT NULL,
  `help_subsection_fk` int(11) unsigned DEFAULT NULL,
  `help_content_fk` int(11) unsigned DEFAULT NULL,
  `faq_section_fk` int(11) unsigned DEFAULT NULL,
  `faq_content_fk` int(11) unsigned DEFAULT NULL,
    PRIMARY KEY (pk),
  INDEX (searches_fk),
  FOREIGN KEY (searches_fk) REFERENCES searches(pk)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `TileInfoPage`.`status_help`;
CREATE TABLE IF NOT EXISTS `TileInfoPage`.`status_help` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `month` int(2) NOT NULL,
  `year` int(4) NOT NULL,
  `help_subsection_fk` int(11) DEFAULT NULL,
  `help_content_fk` int(11) DEFAULT NULL,
  `search_result_fk` int(11) DEFAULT NULL,
  `count` int DEFAULT NULL,
  PRIMARY KEY (pk)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `TileInfoPage`.`status_faq`;
CREATE TABLE IF NOT EXISTS `TileInfoPage`.`status_faq` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `month` int(2) NOT NULL,
  `year` int(4) NOT NULL,
  `faq_section_fk` int(11) DEFAULT NULL,
  `faq_content_fk` int(11) DEFAULT NULL,
  `search_result_fk` int(11) DEFAULT NULL,
  `count` int DEFAULT NULL,
  PRIMARY KEY (pk)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `TileInfoPage`.`status_search`;
CREATE TABLE IF NOT EXISTS `TileInfoPage`.`status_search` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `month` int(2) NOT NULL,
  `year` int(4) NOT NULL,
  `searches_fk` int(11) DEFAULT NULL,
  `count` int DEFAULT NULL,
  PRIMARY KEY (pk)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `configs` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `type` enum('int','color','text','image') NOT NULL,
  `text` text NOT NULL,
  `type_int` int(11) DEFAULT NULL,
  `type_color` varchar(7) DEFAULT NULL,
  `type_string` varchar(150) DEFAULT NULL,
  `type_text` text,
  `type_image_mime` varchar(40) DEFAULT NULL,
  `type_image_size` varchar(40) DEFAULT NULL,
  `type_image_data` mediumblob,
  PRIMARY KEY (pk)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;


DROP TABLE IF EXISTS `TileInfoPage`.`admin_menu`;
CREATE TABLE IF NOT EXISTS `TileInfoPage`.`admin_menu` (
  `pk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(40),
  `module` varchar(40),
  `description` text,
  PRIMARY KEY (pk)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `TileInfoPage`.`commonIncidents`;
CREATE TABLE `TileInfoPage`.`commonIncodents` (
  `pk` INT(11) NOT NULL AUTO_INCREMENT,
  `description` TEXT NULL,
  `status` ENUM('new', 'in progress', 'done') NULL,
  `coments` TEXT NULL,
  PRIMARY KEY (`pk`));

CREATE OR REPLACE VIEW `all_help_contents` AS
    SELECT 
        `help_multicontents`.`uid` AS `content_uid`,
        `help_sections`.`pk` AS `section_pk`,
        `help_subsections`.`pk` AS `subsection_pk`,
        `help_contents`.`pk` AS `content_pk`,
        `help_sections`.`sequence_no` AS `section_sequence`,
        `help_subsections`.`sequence_no` AS `subsection_sequence`,
        `help_multicontents`.`sequence_no` AS `content_sequence`,
        `help_sections`.`name` AS `section_name`,
        `help_subsections`.`name` AS `subsection_name`,
        `help_contents`.`name` AS `help_name`,
        `help_contents`.`link` AS `link`,
        `help_contents`.`description` AS `description`,
        `help_contents`.`meta_name` AS `meta_name`,
        `help_contents`.`meta_description` AS `meta_description`
    FROM
        (`help_contents`
        LEFT JOIN ((`help_multicontents`
        JOIN `help_subsections`)
        JOIN `help_sections`) ON (((`help_multicontents`.`help_content_fk` = `help_contents`.`pk`)
            AND (`help_multicontents`.`help_subsection_fk` = `help_subsections`.`pk`)
            AND (`help_subsections`.`help_section_fk` = `help_sections`.`pk`))))
    ORDER BY `help_sections`.`sequence_no` , `help_subsections`.`sequence_no` , `help_multicontents`.`sequence_no`;

CREATE OR REPLACE VIEW `all_faq_contents` AS
    SELECT 
        `faq_multicontents`.`uid` AS `content_uid`,
        `faq_sections`.`pk` AS `section_pk`,
        `faq_contents`.`pk` AS `content_pk`,
        `faq_sections`.`sequence_no` AS `section_sequence`,
        `faq_multicontents`.`sequence_no` AS `content_sequence`,
        `faq_sections`.`name` AS `section_name`,
        `faq_contents`.`question` AS `question`,
        `faq_contents`.`answer` AS `answer`,
        `faq_contents`.`link` AS `link`
    FROM
        (`faq_contents`
        LEFT JOIN (`faq_multicontents`
        JOIN `faq_sections`) ON (((`faq_multicontents`.`faq_content_fk` = `faq_contents`.`pk`)
            AND (`faq_multicontents`.`faq_section_fk` = `faq_sections`.`pk`))))
    ORDER BY `faq_sections`.`sequence_no` , `faq_multicontents`.`sequence_no`;
            
CREATE OR REPLACE VIEW `all_incidents` AS
    SELECT 
        `incidents`.`pk` AS `incident_pk`,
        `incidents`.`description` AS `description`,
        `faq_incidents`.`status` AS `status`,
        `faq_incidents`.`comments` AS `comments`,
        `faq_contents`.`pk` AS `faq_content_pk`,
        0 AS `help_content_pk`,
        `faq_contents`.`question` AS `title`,
        `faq_contents`.`link` AS `link`
    FROM
        ((`incidents`
        JOIN `faq_incidents`)
        JOIN `faq_contents` ON (((`faq_incidents`.`faq_content_fk` = `faq_contents`.`pk`)
            AND (`faq_incidents`.`incident_fk` = `incidents`.`pk`)))) 
    UNION ALL SELECT 
        `incidents`.`pk` AS `incident_pk`,
        `incidents`.`description` AS `description`,
        `help_incidents`.`status` AS `status`,
        `help_incidents`.`comments` AS `comments`,
        0 AS `faq_content_pk`,
        `help_contents`.`pk` AS `help_content_pk`,
        `help_contents`.`name` AS `title`,
        `help_contents`.`link` AS `link`
    FROM
        ((`incidents`
        JOIN `help_incidents`)
        JOIN `help_contents` ON (((`help_incidents`.`help_content_fk` = `help_contents`.`pk`)
            AND (`help_incidents`.`incident_fk` = `incidents`.`pk`))));
            
            
CREATE OR REPLACE VIEW `all_search` AS
    SELECT 
        `searches`.`pk` AS `pk`,
        `searches`.`uid` AS `uid`,
        `searches`.`string` AS `string`,
        `searches`.`creation` AS `creation`,
        `search_results`.`help_subsection_fk` AS `help_subsection_pk`,
        `search_results`.`help_content_fk` AS `help_content_pk`,
        `search_results`.`faq_section_fk` AS `faq_section_pk`,
        `search_results`.`faq_content_fk` AS `faq_content_pk`
    FROM
        (`searches`
        LEFT JOIN `search_results` ON ((`searches`.`pk` = `search_results`.`searches_fk`)))
    ORDER BY `searches`.`uid`;

CREATE OR REPLACE VIEW `all_contents` AS
    SELECT 
        'help' AS `type`,
        `all_help_contents`.`content_uid` AS `content_uid`,
        `all_help_contents`.`section_pk` AS `section_pk`,
        `all_help_contents`.`subsection_pk` AS `subsection_pk`,
        `all_help_contents`.`content_pk` AS `content_pk`,
        `all_help_contents`.`section_sequence` AS `section_sequence`,
        `all_help_contents`.`subsection_sequence` AS `subsection_sequence`,
        `all_help_contents`.`content_sequence` AS `content_sequence`,
        `all_help_contents`.`section_name` AS `section_name`,
        `all_help_contents`.`subsection_name` AS `subsection_name`,
        `all_help_contents`.`help_name` AS `help_name`,
        `all_help_contents`.`link` AS `link`,
        `all_help_contents`.`description` AS `description`,
        '' AS `question`,
        '' AS `answer`
    FROM
        `all_help_contents` 
    UNION ALL SELECT 
        'faq' AS `type`,
        `all_faq_contents`.`content_uid` AS `content_uid`,
        `all_faq_contents`.`section_pk` AS `section_pk`,
        '' AS `subsection_pk`,
        `all_faq_contents`.`content_pk` AS `content_pk`,
        `all_faq_contents`.`section_sequence` AS `section_sequence`,
        0 AS `subsection_sequence`,
        `all_faq_contents`.`content_sequence` AS `content_sequence`,
        `all_faq_contents`.`section_name` AS `section_name`,
        '' AS `subsection_name`,
        '' AS `help_name`,
        `all_faq_contents`.`link` AS `link`,
        '' AS `description`,
        `all_faq_contents`.`question` AS `question`,
        `all_faq_contents`.`answer` AS `answer`
    FROM
        `all_faq_contents`;

CREATE OR REPLACE VIEW `all_search_contents` AS
    SELECT 
        `all_contents`.`content_uid` AS `content_uid`,
        `all_contents`.`type` AS `type`,
        `all_contents`.`section_pk` AS `section_pk`,
        `all_contents`.`subsection_pk` AS `subsection_pk`,
        `all_contents`.`content_pk` AS `content_pk`,
        `all_contents`.`section_sequence` AS `section_sequence`,
        `all_contents`.`subsection_sequence` AS `subsection_sequence`,
        `all_contents`.`content_sequence` AS `content_sequence`,
        `all_contents`.`section_name` AS `section_name`,
        `all_contents`.`subsection_name` AS `subsection_name`,
        `all_contents`.`help_name` AS `help_name`,
        `all_contents`.`link` AS `link`,
        `all_contents`.`description` AS `description`,
        `all_contents`.`question` AS `question`,
        `all_contents`.`answer` AS `answer`,
        `all_search`.`pk` AS `pk`,
        `all_search`.`uid` AS `uid`,
        `all_search`.`string` AS `string`,
        `all_search`.`creation` AS `creation`,
        `all_search`.`help_subsection_pk` AS `help_subsection_pk`,
        `all_search`.`help_content_pk` AS `help_content_pk`,
        `all_search`.`faq_section_pk` AS `faq_section_pk`,
        `all_search`.`faq_content_pk` AS `faq_content_pk`
    FROM
        (`all_search`
        LEFT JOIN `all_contents` ON ((((`all_search`.`help_subsection_pk` = `all_contents`.`subsection_pk`)
            AND (`all_search`.`help_content_pk` = `all_contents`.`content_pk`))
            OR ((`all_search`.`faq_section_pk` = `all_contents`.`section_pk`)
            AND (`all_search`.`faq_content_pk` = `all_contents`.`content_pk`)))))
    ORDER BY `all_search`.`uid` , `all_contents`.`type`;

CREATE OR REPLACE VIEW `help_search_contents` AS
    SELECT 
        `all_search`.`pk` AS `pk`,
        `all_search`.`uid` AS `uid`,
        `all_search`.`string` AS `string`,
        `all_search`.`creation` AS `creation`,
        `all_search`.`help_subsection_pk` AS `help_subsection_pk`,
        `all_search`.`help_content_pk` AS `help_content_pk`,
        `all_search`.`faq_section_pk` AS `faq_section_pk`,
        `all_search`.`faq_content_pk` AS `faq_content_pk`,
        `all_help_contents`.`content_uid` AS `content_uid`,
        `all_help_contents`.`section_pk` AS `section_pk`,
        `all_help_contents`.`subsection_pk` AS `subsection_pk`,
        `all_help_contents`.`content_pk` AS `content_pk`,
        `all_help_contents`.`section_sequence` AS `section_sequence`,
        `all_help_contents`.`subsection_sequence` AS `subsection_sequence`,
        `all_help_contents`.`content_sequence` AS `content_sequence`,
        `all_help_contents`.`section_name` AS `section_name`,
        `all_help_contents`.`subsection_name` AS `subsection_name`,
        `all_help_contents`.`help_name` AS `help_name`,
        `all_help_contents`.`link` AS `link`,
        `all_help_contents`.`description` AS `description`,
        `all_help_contents`.`meta_name` AS `meta_name`,
        `all_help_contents`.`meta_description` AS `meta_description`
    FROM
        (`all_search`
        LEFT JOIN `all_help_contents` ON (((`all_search`.`help_subsection_pk` = `all_help_contents`.`subsection_pk`)
            AND (`all_search`.`help_content_pk` = `all_help_contents`.`content_pk`))))
    ORDER BY `all_search`.`uid`;

CREATE OR REPLACE VIEW `faq_search_contents` AS
    SELECT 
        `all_search`.`pk` AS `pk`,
        `all_search`.`uid` AS `uid`,
        `all_search`.`string` AS `string`,
        `all_search`.`creation` AS `creation`,
        `all_search`.`help_subsection_pk` AS `help_subsection_pk`,
        `all_search`.`help_content_pk` AS `help_content_pk`,
        `all_search`.`faq_section_pk` AS `faq_section_pk`,
        `all_search`.`faq_content_pk` AS `faq_content_pk`,
        `all_faq_contents`.`content_uid` AS `content_uid`,
        `all_faq_contents`.`section_pk` AS `section_pk`,
        `all_faq_contents`.`content_pk` AS `content_pk`,
        `all_faq_contents`.`section_sequence` AS `section_sequence`,
        `all_faq_contents`.`content_sequence` AS `content_sequence`,
        `all_faq_contents`.`section_name` AS `section_name`,
        `all_faq_contents`.`question` AS `question`,
        `all_faq_contents`.`answer` AS `answer`,
        `all_faq_contents`.`link` AS `link`
    FROM
        (`all_search`
        LEFT JOIN `all_faq_contents` ON (((`all_search`.`faq_section_pk` = `all_faq_contents`.`section_pk`)
            AND (`all_search`.`faq_content_pk` = `all_faq_contents`.`content_pk`))))
    ORDER BY `all_search`.`uid`;

    
CREATE OR REPLACE VIEW `all_status` AS
    SELECT 
        'faq' AS `type`,
        `status_faq`.`pk` AS `pk`,
        `status_faq`.`month` AS `month`,
        `status_faq`.`year` AS `year`,
        `status_faq`.`faq_section_fk` AS `section_pk`,
        '' AS `subsection_pk`,
        `status_faq`.`faq_content_fk` AS `content_pk`,
        `status_faq`.`search_result_fk` AS `search_pk`,
        `status_faq`.`count` AS `count`
    FROM
        `status_faq` 
    UNION ALL SELECT 
        'help' AS `type`,
        `status_help`.`pk` AS `pk`,
        `status_help`.`month` AS `month`,
        `status_help`.`year` AS `year`,
        `help_subsections`.`help_section_fk` AS `section_pk`,
        `status_help`.`help_subsection_fk` AS `subsection_pk`,
        `status_help`.`help_content_fk` AS `content_pk`,
        `status_help`.`search_result_fk` AS `search_pk`,
        `status_help`.`count` AS `count`
    FROM
        (`status_help`
        LEFT JOIN `help_subsections` ON ((`status_help`.`help_subsection_fk` = `help_subsections`.`pk`))) 
    UNION ALL SELECT 
        'search' AS `type`,
        `status_search`.`pk` AS `pk`,
        `status_search`.`month` AS `month`,
        `status_search`.`year` AS `year`,
        '' AS `section_pk`,
        '' AS `subsection_pk`,
        '' AS `content_pk`,
        `status_search`.`searches_fk` AS `search_pk`,
        `status_search`.`count` AS `count`
    FROM
        `status_search`;

CREATE OR REPLACE VIEW `all_help_status` AS
    SELECT 
        `status_help`.`pk` AS `pk`,
        `status_help`.`month` AS `month`,
        `status_help`.`year` AS `year`,
        `status_help`.`help_subsection_fk` AS `help_subsection_fk`,
        `status_help`.`help_content_fk` AS `help_content_fk`,
        `status_help`.`search_result_fk` AS `search_result_fk`,
        `status_help`.`count` AS `count`,
        `all_help_contents`.`content_uid` AS `content_uid`,
        `all_help_contents`.`section_pk` AS `section_pk`,
        `all_help_contents`.`subsection_pk` AS `subsection_pk`,
        `all_help_contents`.`content_pk` AS `content_pk`,
        `all_help_contents`.`section_sequence` AS `section_sequence`,
        `all_help_contents`.`subsection_sequence` AS `subsection_sequence`,
        `all_help_contents`.`content_sequence` AS `content_sequence`,
        `all_help_contents`.`section_name` AS `section_name`,
        `all_help_contents`.`subsection_name` AS `subsection_name`,
        `all_help_contents`.`help_name` AS `help_name`,
        `all_help_contents`.`link` AS `link`,
        `all_help_contents`.`description` AS `description`,
        `all_help_contents`.`meta_name` AS `meta_name`,
        `all_help_contents`.`meta_description` AS `meta_description`
    FROM
        (`status_help`
        LEFT JOIN `all_help_contents` ON (((`status_help`.`help_subsection_fk` = `all_help_contents`.`subsection_pk`)
            AND (`status_help`.`help_content_fk` = `all_help_contents`.`content_pk`))))
    ORDER BY `status_help`.`year` , `status_help`.`month`;        

CREATE OR REPLACE VIEW `all_faq_status` AS
    SELECT 
        `status_faq`.`pk` AS `pk`,
        `status_faq`.`month` AS `month`,
        `status_faq`.`year` AS `year`,
        `status_faq`.`faq_section_fk` AS `faq_section_fk`,
        `status_faq`.`faq_content_fk` AS `faq_content_fk`,
        `status_faq`.`search_result_fk` AS `search_result_fk`,
        `status_faq`.`count` AS `count`,
        `all_faq_contents`.`content_uid` AS `content_uid`,
        `all_faq_contents`.`section_pk` AS `section_pk`,
        `all_faq_contents`.`content_pk` AS `content_pk`,
        `all_faq_contents`.`section_sequence` AS `section_sequence`,
        `all_faq_contents`.`content_sequence` AS `content_sequence`,
        `all_faq_contents`.`section_name` AS `section_name`,
        `all_faq_contents`.`question` AS `question`,
        `all_faq_contents`.`answer` AS `answer`,
        `all_faq_contents`.`link` AS `link`
    FROM
        (`status_faq`
        LEFT JOIN `all_faq_contents` ON (((`status_faq`.`faq_section_fk` = `all_faq_contents`.`section_pk`)
            AND (`status_faq`.`faq_content_fk` = `all_faq_contents`.`content_pk`))))
    ORDER BY `status_faq`.`year` , `status_faq`.`month`;
    
CREATE OR REPLACE VIEW `full_status_contents` AS
    SELECT 
        `all_status`.`type` AS `status_type`,
        `all_status`.`pk` AS `status_pk`,
        `all_status`.`month` AS `month`,
        `all_status`.`year` AS `year`,
        `all_status`.`section_pk` AS `status_section_pk`,
        `all_status`.`content_pk` AS `status_content_pk`,
        `all_status`.`search_pk` AS `status_search_pk`,
        `all_status`.`count` AS `count`,
        `all_search_contents`.`content_uid` AS  `content_uid`,
        `all_search_contents`.`type` AS `search_type`,
        `all_search_contents`.`section_pk` AS `search_section_pk`,
        `all_search_contents`.`subsection_pk` AS `search_subsection_pk`,
        `all_search_contents`.`content_pk` AS `search_content_pk`,
        `all_search_contents`.`section_sequence` AS `section_sequence`,
        `all_search_contents`.`subsection_sequence` AS `subsection_sequence`,
        `all_search_contents`.`content_sequence` AS `content_sequence`,
        `all_search_contents`.`section_name` AS `section_name`,
        `all_search_contents`.`subsection_name` AS `subsection_name`,
        `all_search_contents`.`help_name` AS `help_name`,
        `all_search_contents`.`link` AS `link`,
        `all_search_contents`.`description` AS `description`,
        `all_search_contents`.`question` AS `question`,
        `all_search_contents`.`answer` AS `answer`,
        `all_search_contents`.`pk` AS `search_pk`,
        `all_search_contents`.`uid` AS `uid`,
        `all_search_contents`.`string` AS `string`,
        `all_search_contents`.`creation` AS `creation`,
        `all_search_contents`.`help_subsection_pk` AS `help_subsection_pk`,
        `all_search_contents`.`help_content_pk` AS `help_content_pk`,
        `all_search_contents`.`faq_section_pk` AS `faq_section_pk`,
        `all_search_contents`.`faq_content_pk` AS `faq_content_pk`
    FROM
        (`all_status`
        LEFT JOIN `all_search_contents` ON (((`all_status`.`search_pk` = `all_search_contents`.`pk`)
            OR ((`all_status`.`type` = 'help')
            AND (`all_search_contents`.`type` = 'help')
            AND (`all_status`.`section_pk` = `all_search_contents`.`subsection_pk`)
            AND (`all_status`.`content_pk` = `all_search_contents`.`content_pk`))
            OR ((`all_status`.`type` = 'faq')
            AND (`all_search_contents`.`type` = 'faq')
            AND (`all_status`.`section_pk` = `all_search_contents`.`section_pk`)
            AND (`all_status`.`content_pk` = `all_search_contents`.`content_pk`)))));

CREATE OR REPLACE VIEW `all_sections` AS
    SELECT 
        'help' AS `type`,
        `help_sections`.`pk` AS `pk`,
        `help_sections`.`name` AS `name`,
        `help_sections`.`bg` AS `bg`,
        `help_sections`.`fg` AS `fg`,
        `help_sections`.`image` AS `image`
    FROM
        `help_sections` 
    UNION ALL SELECT 
        'faq' AS `type`,
        `faq_sections`.`pk` AS `pk`,
        `faq_sections`.`name` AS `name`,
        `faq_sections`.`bg` AS `bg`,
        `faq_sections`.`fg` AS `fg`,
        `faq_sections`.`image` AS `image`
    FROM
        `faq_sections`;
        
CREATE OR REPLACE VIEW `search_sections` AS
    SELECT 
        `all_search_contents`.`uid` AS `uid`,
        `all_search_contents`.`string` AS `string`,
        `all_search_contents`.`type` AS `type`,
        `all_search_contents`.`section_pk` AS `section_pk`,
        `all_sections`.`name` AS `name`,
        `all_sections`.`bg` AS `bg`,
        `all_sections`.`fg` AS `fg`,
        `all_sections`.`image` AS `image`,
        COUNT(0) AS `count`
    FROM
        (`all_search_contents`
        LEFT JOIN `all_sections` ON (((`all_sections`.`pk` = `all_search_contents`.`section_pk`)
            AND (`all_sections`.`type` = `all_search_contents`.`type`))))
    GROUP BY `all_search_contents`.`uid` , `all_search_contents`.`section_pk`;
    
CREATE OR REPLACE VIEW `all_search_status` AS
    SELECT 
        `all_search_contents`.`uid` AS `uid`,
        `all_search_contents`.`string` AS `string`,
        `all_search_contents`.`type` AS `type`,
        COUNT(0) AS `num_res`,
        `status_search`.`year` AS `year`,
        `status_search`.`month` AS `month`,
        `status_search`.`count` AS `num_klicks`
    FROM
        (`all_search_contents`
        LEFT JOIN `status_search` ON ((`all_search_contents`.`pk` = `status_search`.`searches_fk`)))
    GROUP BY `all_search_contents`.`uid` , `all_search_contents`.`type` , `status_search`.`year` , `status_search`.`month`;

CREATE OR REPLACE VIEW `search_subsections` AS
    SELECT 
        `all_search_contents`.`uid` AS `uid`,
        `all_search_contents`.`string` AS `string`,
        `all_search_contents`.`type` AS `type`,
        `all_search_contents`.`subsection_pk` AS `subsection_pk`,
        `help_subsections`.`name` AS `name`,
        `help_subsections`.`sequence_no` AS `sequence_no`,
        `help_subsections`.`help_section_fk` AS `help_section_fk`,
        `help_subsections`.`description` AS `description`,
        COUNT(0) AS `count`
    FROM
        (`all_search_contents`
        LEFT JOIN `help_subsections` ON ((`help_subsections`.`pk` = `all_search_contents`.`subsection_pk`)))
    GROUP BY `all_search_contents`.`uid` , `all_search_contents`.`subsection_pk`;
            
CREATE OR REPLACE VIEW `HTTP_ERRORS` AS
    SELECT 
        `help_contents`.`pk` AS `pk`,
        `help_contents`.`name` AS `name`,
        `help_contents`.`link` AS `link`,
        `help_contents`.`description` AS `description`
    FROM
        `help_contents`
    WHERE
        (`help_contents`.`http_result` = 'DEAD LINK');


CREATE OR REPLACE VIEW `description_errors` AS
    SELECT
        `help_contents`.`pk` AS `pk`,
        `help_contents`.`name` AS `name`,
        `help_contents`.`link` AS `link`,
        `help_contents`.`description` AS `description`,
        `help_contents`.`meta_name` AS `meta_name`,
        `help_contents`.`meta_description` AS `meta_description`,
        `help_contents`.`http_result` AS `http_result`,
        `help_contents`.`google_results` AS `google_results`,
        CHAR_LENGTH(`help_contents`.`description`) AS `char_count`
    FROM
        `help_contents`
    HAVING (`char_count` < 100);

CREATE OR REPLACE VIEW `show_doubbles` AS
    SELECT
        'name' AS `type`,
        `help_contents`.`pk` AS `pk`,
        `help_contents`.`name` AS `name`,
        `help_contents`.`link` AS `link`,
        `help_contents`.`description` AS `description`,
        COUNT(0) AS `name_count`,
        0 AS `link_count`
    FROM
        `help_contents`
    GROUP BY `help_contents`.`name`
    HAVING (`name_count` > 1)
    UNION SELECT
        'link' AS `type`,
        `help_contents`.`pk` AS `pk`,
        `help_contents`.`name` AS `name`,
        `help_contents`.`link` AS `link`,
        `help_contents`.`description` AS `description`,
        0 AS `name_count`,
        COUNT(0) AS `link_count`
    FROM
        `help_contents`
    GROUP BY `help_contents`.`link`
    HAVING (`link_count` > 1);

CREATE OR REPLACE VIEW `helpSectionStatus` AS
    SELECT
        `help_subsections`.`pk` AS `subsection_pk`,
        `help_subsections`.`name` AS `subsection_name`,
        `help_sections`.`pk` AS `section_pk`,
        `help_sections`.`name` AS `section_name`,
        `help_subsections`.`sequence_no` AS `sequence_no`,
        `help_subsections`.`description` AS `description`,
        `help_subsections`.`help_section_fk` AS `help_section_fk`,
        COUNT(`help_multicontents`.`uid`) AS `count`
    FROM
        (`help_subsections`
        LEFT JOIN (`help_multicontents`
        JOIN `help_sections`) ON (((`help_subsections`.`pk` = `help_multicontents`.`help_subsection_fk`)
            AND (`help_subsections`.`help_section_fk` = `help_sections`.`pk`))))
    GROUP BY `help_subsections`.`name`
    ORDER BY `help_sections`.`pk`;

    CREATE OR REPLACE VIEW `help_tree` AS
    SELECT
        `help_subsections`.`pk` AS `pk`,
        `help_sections`.`name` AS `section_name`,
        `help_subsections`.`name` AS `subsection_name`,
        `help_subsections`.`sequence_no` AS `sequence_no`,
        `help_subsections`.`description` AS `description`,
        `help_subsections`.`help_section_fk` AS `help_section_fk`
    FROM
        (`help_subsections`
        LEFT JOIN `help_sections` ON ((`help_subsections`.`help_section_fk` = `help_sections`.`pk`)));


    CREATE OR REPLACE VIEW `subsection_count` AS
    SELECT
        `help_tree`.`pk` AS `pk`,
        `help_tree`.`section_name` AS `section_name`,
        `help_tree`.`subsection_name` AS `subsection_name`,
        `help_tree`.`sequence_no` AS `sequence_no`,
        `help_tree`.`description` AS `description`,
        COUNT(`help_multicontents`.`uid`) AS `count`
    FROM
        (`help_tree`
        LEFT JOIN `help_multicontents` ON ((`help_tree`.`pk` = `help_multicontents`.`help_subsection_fk`)))
    GROUP BY `help_tree`.`subsection_name`;

CREATE OR REPLACE VIEW `FAQ_section_count` AS
    SELECT
        `faq_sections`.`pk` AS `pk`,
        `faq_sections`.`name` AS `name`,
        `faq_sections`.`description` AS `description`,
        `faq_sections`.`sequence_no` AS `sequence_no`,
        `faq_sections`.`fg` AS `fg`,
        `faq_sections`.`bg` AS `bg`,
        COUNT(`faq_multicontents`.`uid`) AS `count`
    FROM
        (`faq_sections`
        LEFT JOIN `faq_multicontents` ON ((`faq_sections`.`pk` = `faq_multicontents`.`faq_section_fk`)))
    GROUP BY `faq_sections`.`name`;

CREATE OR REPLACE VIEW `section_count` AS
    SELECT
        `help_sections`.`pk` AS `pk`,
        `help_sections`.`sequence_no` AS `sequence_no`,
        `help_sections`.`name` AS `name`,
        `help_sections`.`description` AS `description`,
        `help_sections`.`fg` AS `fg`,
        `help_sections`.`bg` AS `bg`,
        COUNT(`help_subsections`.`name`) AS `count`
    FROM
        (`help_sections`
        LEFT JOIN `help_subsections` ON ((`help_sections`.`pk` = `help_subsections`.`help_section_fk`)))
    GROUP BY `help_sections`.`name`;

INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(1, 'DeleteFaq', 'delete_faq.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(2, 'DeleteFaqCath', 'delete_faq_cath.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(3, 'DeleteHelp', 'delete_help.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(4, 'DeleteHelpCath', 'delete_help_cath.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(5, 'DeleteHelpSubcath', 'delete_help_subcath.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(6, 'DeleteHelpMultiConts', 'delete_helpmulti.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(7, 'EditFaq', 'edit_faq.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(8, 'EditFaqCath', 'edit_faq_cath.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(9, 'EditHelp', 'edit_help.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(10, 'EditHelpCath', 'edit_help_cath.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(11, 'EditHelpSubCath', 'edit_help_subcath.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(12, 'Logout', 'logout.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(13, 'NewFaq', 'new_faq.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(14, 'NewFaqCath', 'new_faq_cath.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(15, 'NewHelp', 'new_help.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(16, 'NewHelpCath', 'new_help_cath.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(17, 'NewHelpSubCath', 'new_help_subcath.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(18, 'ShowDoubles', 'show_doubles.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(19, 'ShowStatus', 'show_status.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(20, 'EditMain', 'edit_main.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(21, 'EditMainItem', 'edit_main_item.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(22, 'EditConfigs', 'edit_configs.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(23, 'DeleteEmptyHelpSection', 'delete_empty_help_section.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(24, 'DeleteEmptyHelpSubSection', 'delete_empty_help_subsection.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(25, 'DeleteEmptyFaqSection', 'delete_empty_faq_section.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(26, 'ShowFeedback', 'show_common_feedback.php', NULL);
INSERT INTO `admin_menu` (`pk`, `action`, `module`, `description`) VALUES(27, 'DeleteFeedback', 'delete_common_feedback.php', NULL);


    COMMIT


