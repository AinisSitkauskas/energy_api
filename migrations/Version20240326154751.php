<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326154751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_group_energy_consumption (id INT AUTO_INCREMENT NOT NULL, user_group_id INT DEFAULT NULL, average_consumption NUMERIC(13, 2) NOT NULL, percentage NUMERIC(13, 2) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_55AB70401ED93D47 (user_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_group_energy_consumption ADD CONSTRAINT FK_55AB70401ED93D47 FOREIGN KEY (user_group_id) REFERENCES user_groups (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_group_energy_consumption DROP FOREIGN KEY FK_55AB70401ED93D47');
        $this->addSql('DROP TABLE user_group_energy_consumption');
    }
}
