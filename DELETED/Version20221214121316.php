<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221214121316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE features_value DROP FOREIGN KEY FK_E64701EECEC89005');
        $this->addSql('DROP INDEX IDX_E64701EECEC89005 ON features_value');
        $this->addSql('ALTER TABLE features_value DROP features_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE features_value ADD features_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE features_value ADD CONSTRAINT FK_E64701EECEC89005 FOREIGN KEY (features_id) REFERENCES features (id)');
        $this->addSql('CREATE INDEX IDX_E64701EECEC89005 ON features_value (features_id)');
    }
}
