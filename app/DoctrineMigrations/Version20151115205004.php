<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151115205004 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE customCatalog (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, title VARCHAR(150) NOT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, root INT DEFAULT NULL, INDEX IDX_190F385C727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customCatalog ADD CONSTRAINT FK_190F385C727ACA70 FOREIGN KEY (parent_id) REFERENCES customCatalog (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customCatalog DROP FOREIGN KEY FK_190F385C727ACA70');
        $this->addSql('DROP TABLE customCatalog');
    }
}
