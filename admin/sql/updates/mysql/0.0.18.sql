ALTER TABLE`#__edobunko` ADD COLUMN `sourceDesc` VARCHAR(255) NOT NULL DEFAULT 'Information about the source' AFTER `title`;
ALTER TABLE`#__edobunko` ADD COLUMN `publicationStmt` VARCHAR(255) NOT NULL DEFAULT 'Publication Information' AFTER `title`;
