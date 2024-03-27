<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327165042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_goals (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, predicted_consumption NUMERIC(13, 2) NOT NULL, consumption NUMERIC(13, 2) DEFAULT 0 NOT NULL, goal NUMERIC(13, 2) NOT NULL, percentage INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_25E6E577A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_goals ADD CONSTRAINT FK_25E6E577A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE energy_monthly_consumption CHANGE consumption consumption NUMERIC(13, 1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_goals DROP FOREIGN KEY FK_25E6E577A76ED395');
        $this->addSql('DROP TABLE user_goals');
        $this->addSql('ALTER TABLE energy_monthly_consumption CHANGE consumption consumption NUMERIC(13, 5) NOT NULL');
    }
}
