<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240325100046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE energy_daily_consumption (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, energy_type_id INT DEFAULT NULL, consumption NUMERIC(13, 2) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_872FC131A76ED395 (user_id), INDEX IDX_872FC13180726647 (energy_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE energy_daily_consumption ADD CONSTRAINT FK_872FC131A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE energy_daily_consumption ADD CONSTRAINT FK_872FC13180726647 FOREIGN KEY (energy_type_id) REFERENCES energy_types (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE energy_daily_consumption DROP FOREIGN KEY FK_872FC131A76ED395');
        $this->addSql('ALTER TABLE energy_daily_consumption DROP FOREIGN KEY FK_872FC13180726647');
        $this->addSql('DROP TABLE energy_daily_consumption');
    }
}
