<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131005190743 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE picture CHANGE dateCreated dateCreated DATETIME NOT NULL, CHANGE location location VARCHAR(255) DEFAULT NULL, CHANGE description description VARCHAR(160) DEFAULT NULL, CHANGE focalLength focalLength VARCHAR(10) DEFAULT NULL, CHANGE aperture aperture VARCHAR(10) DEFAULT NULL, CHANGE ISO ISO VARCHAR(10) DEFAULT NULL, CHANGE shutterSpeed shutterSpeed VARCHAR(10) DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");

        $this->addSql("ALTER TABLE picture CHANGE dateCreated dateCreated DATETIME DEFAULT NULL, CHANGE location location VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(160) NOT NULL, CHANGE focalLength focalLength VARCHAR(10) NOT NULL, CHANGE aperture aperture VARCHAR(10) NOT NULL, CHANGE ISO ISO VARCHAR(10) NOT NULL, CHANGE shutterSpeed shutterSpeed VARCHAR(10) NOT NULL");
    }
}
