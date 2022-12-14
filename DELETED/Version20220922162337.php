<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922162337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C64B89032C');
        $this->addSql('DROP TABLE features_activity');
        $this->addSql('DROP TABLE post');
        $this->addSql('ALTER TABLE features ADD activity_id INT DEFAULT NULL, ADD features_label_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE features ADD CONSTRAINT FK_BFC0DC1381C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE features ADD CONSTRAINT FK_BFC0DC13FE074995 FOREIGN KEY (features_label_id) REFERENCES features_label (id)');
        $this->addSql('CREATE INDEX IDX_BFC0DC1381C06096 ON features (activity_id)');
        $this->addSql('CREATE INDEX IDX_BFC0DC13FE074995 ON features (features_label_id)');
        $this->addSql('ALTER TABLE features_label DROP FOREIGN KEY FK_F5970932CEC89005');
        $this->addSql('DROP INDEX IDX_F5970932CEC89005 ON features_label');
        $this->addSql('ALTER TABLE features_label DROP features_id');
        $this->addSql('DROP INDEX IDX_794381C64B89032C ON review');
        $this->addSql('ALTER TABLE review DROP post_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE features_activity (features_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_61CA6FF6CEC89005 (features_id), INDEX IDX_61CA6FF681C06096 (activity_id), PRIMARY KEY(features_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, activity_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, country VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, city VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, address VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, published TINYINT(1) NOT NULL, picture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, price VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, short_description VARCHAR(60) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_5A8A6C8DA76ED395 (user_id), UNIQUE INDEX UNIQ_5A8A6C8D81C06096 (activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE features_activity ADD CONSTRAINT FK_61CA6FF681C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE features_activity ADD CONSTRAINT FK_61CA6FF6CEC89005 FOREIGN KEY (features_id) REFERENCES features (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE features DROP FOREIGN KEY FK_BFC0DC1381C06096');
        $this->addSql('ALTER TABLE features DROP FOREIGN KEY FK_BFC0DC13FE074995');
        $this->addSql('DROP INDEX IDX_BFC0DC1381C06096 ON features');
        $this->addSql('DROP INDEX IDX_BFC0DC13FE074995 ON features');
        $this->addSql('ALTER TABLE features DROP activity_id, DROP features_label_id');
        $this->addSql('ALTER TABLE features_label ADD features_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE features_label ADD CONSTRAINT FK_F5970932CEC89005 FOREIGN KEY (features_id) REFERENCES features (id)');
        $this->addSql('CREATE INDEX IDX_F5970932CEC89005 ON features_label (features_id)');
        $this->addSql('ALTER TABLE review ADD post_id INT NOT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C64B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_794381C64B89032C ON review (post_id)');
    }
}
