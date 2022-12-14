<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221214125852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE features ADD features_value_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE features ADD CONSTRAINT FK_BFC0DC13349EDD0E FOREIGN KEY (features_value_id) REFERENCES features_value (id)');
        $this->addSql('CREATE INDEX IDX_BFC0DC13349EDD0E ON features (features_value_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE features DROP FOREIGN KEY FK_BFC0DC13349EDD0E');
        $this->addSql('DROP INDEX IDX_BFC0DC13349EDD0E ON features');
        $this->addSql('ALTER TABLE features DROP features_value_id');
    }
}
