<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131012164052 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8998A21AC6");
        $this->addSql("ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89A76ED395");
        $this->addSql("ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8998A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8998A21AC6");
        $this->addSql("ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89A76ED395");
        $this->addSql("ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8998A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id)");
        $this->addSql("ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)");
    }
}
