DROP TABLE IF EXISTS `#__edobunko_pages`;
 
CREATE TABLE `#__edobunko_pages` (
	`id`       INT(11)     	NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10)      NOT NULL DEFAULT '0',
	`page` VARCHAR(255) 	NOT NULL,
	`publicationStmt` VARCHAR(255) 	NOT NULL,
	`overlay` MEDIUMTEXT 	NOT NULL,
	`published` tinyint(4) 	NOT NULL DEFAULT '1',
	`parentid` int(11) 		NOT NULL DEFAULT '0',
	`params` VARCHAR(1024)  NOT NULL DEFAULT '',
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;