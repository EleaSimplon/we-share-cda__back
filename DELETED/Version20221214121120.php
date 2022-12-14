<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221214121120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE features_value (id INT AUTO_INCREMENT NOT NULL, features_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_E64701EECEC89005 (features_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE features_value ADD CONSTRAINT FK_E64701EECEC89005 FOREIGN KEY (features_id) REFERENCES features (id)');
        $this->addSql('ALTER TABLE features DROP value');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE features_value');
        $this->addSql('ALTER TABLE features ADD value VARCHAR(255) DEFAULT NULL');
    }
}
