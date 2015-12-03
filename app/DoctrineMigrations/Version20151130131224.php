<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151130131224 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE vendor_user (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, vendor_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_A75ED396A76ED395 (user_id), INDEX IDX_A75ED396F603EE73 (vendor_id), UNIQUE INDEX UNIQ_A75ED396F603EE73A76ED395 (vendor_id, user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vendor_user ADD CONSTRAINT FK_A75ED396A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user_user (id)');
        $this->addSql('ALTER TABLE vendor_user ADD CONSTRAINT FK_A75ED396F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE vendor_user');
    }
}
