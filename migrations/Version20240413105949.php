<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240413105949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_goals CHANGE consumption consumption NUMERIC(13, 2) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE user_information ADD heat_type VARCHAR(255) NOT NULL, ADD monthly_heat_consumption NUMERIC(13, 1) NOT NULL, ADD fuel_type VARCHAR(255) NOT NULL, ADD fuel_consumption NUMERIC(13, 1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_goals CHANGE consumption consumption NUMERIC(13, 2) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE user_information DROP heat_type, DROP monthly_heat_consumption, DROP fuel_type, DROP fuel_consumption');
    }
}
