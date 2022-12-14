<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220921175707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity ADD user_id INT NOT NULL, ADD name VARCHAR(255) NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD country VARCHAR(255) NOT NULL, ADD published_at DATE DEFAULT NULL, ADD picture VARCHAR(255) DEFAULT NULL, ADD price VARCHAR(255) NOT NULL, ADD description VARCHAR(255) NOT NULL, ADD short_description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AC74095AA76ED395 ON activity (user_id)');
        $this->addSql('ALTER TABLE review ADD activity_id INT NOT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C681C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('CREATE INDEX IDX_794381C681C06096 ON review (activity_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AA76ED395');
        $this->addSql('DROP INDEX IDX_AC74095AA76ED395 ON activity');
        $this->addSql('ALTER TABLE activity DROP user_id, DROP name, DROP city, DROP country, DROP published_at, DROP picture, DROP price, DROP description, DROP short_description');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C681C06096');
        $this->addSql('DROP INDEX IDX_794381C681C06096 ON review');
        $this->addSql('ALTER TABLE review DROP activity_id');
    }
}
