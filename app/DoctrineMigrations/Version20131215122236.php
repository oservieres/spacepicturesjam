<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131215122236 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("TRUNCATE TABLE comment");
        $this->addSql("ALTER TABLE comment DROP FOREIGN KEY FK_9474526CEE45BDBF");
        $this->addSql("DROP INDEX IDX_9474526CEE45BDBF ON comment");
        $this->addSql("ALTER TABLE comment CHANGE picture_id challenge_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE comment ADD CONSTRAINT FK_9474526C98A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE");
        $this->addSql("CREATE INDEX IDX_9474526C98A21AC6 ON comment (challenge_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE comment DROP FOREIGN KEY FK_9474526C98A21AC6");
        $this->addSql("DROP INDEX IDX_9474526C98A21AC6 ON comment");
        $this->addSql("ALTER TABLE comment CHANGE challenge_id picture_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE comment ADD CONSTRAINT FK_9474526CEE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id) ON DELETE CASCADE");
        $this->addSql("CREATE INDEX IDX_9474526CEE45BDBF ON comment (picture_id)");
    }
}
