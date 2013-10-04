<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131004222926 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, challenge_id INT DEFAULT NULL, user_id INT DEFAULT NULL, dateCreated DATETIME DEFAULT NULL, title VARCHAR(100) NOT NULL, location VARCHAR(255) NOT NULL, description VARCHAR(160) NOT NULL, focalLength VARCHAR(10) NOT NULL, aperture VARCHAR(10) NOT NULL, ISO VARCHAR(10) NOT NULL, shutterSpeed VARCHAR(10) NOT NULL, path VARCHAR(100) NOT NULL, miniaturePath VARCHAR(100) NOT NULL, INDEX IDX_16DB4F8998A21AC6 (challenge_id), INDEX IDX_16DB4F89A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8998A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)");
        $this->addSql("ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)");
        $this->addSql("ALTER TABLE user CHANGE password password VARCHAR(32) NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE picture");
        $this->addSql("ALTER TABLE user CHANGE password password CHAR(32) NOT NULL");
    }
}
