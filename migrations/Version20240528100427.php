<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240528100427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_group_by_energy_type_consumptions (id INT AUTO_INCREMENT NOT NULL, user_group_id INT DEFAULT NULL, energy_type_id INT DEFAULT NULL, average_consumption NUMERIC(13, 2) NOT NULL, INDEX IDX_175046501ED93D47 (user_group_id), INDEX IDX_1750465080726647 (energy_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_group_by_energy_type_consumptions ADD CONSTRAINT FK_175046501ED93D47 FOREIGN KEY (user_group_id) REFERENCES user_groups (id)');
        $this->addSql('ALTER TABLE user_group_by_energy_type_consumptions ADD CONSTRAINT FK_1750465080726647 FOREIGN KEY (energy_type_id) REFERENCES energy_types (id)');
        $this->addSql('ALTER TABLE user_goals CHANGE consumption consumption NUMERIC(13, 2) DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_group_by_energy_type_consumptions DROP FOREIGN KEY FK_175046501ED93D47');
        $this->addSql('ALTER TABLE user_group_by_energy_type_consumptions DROP FOREIGN KEY FK_1750465080726647');
        $this->addSql('DROP TABLE user_group_by_energy_type_consumptions');
        $this->addSql('ALTER TABLE user_goals CHANGE consumption consumption NUMERIC(13, 2) DEFAULT \'0.00\' NOT NULL');
    }
}
