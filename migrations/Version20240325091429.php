<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240325091429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_information (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, user_group_id INT DEFAULT NULL, city VARCHAR(255) NOT NULL, residents INT NOT NULL, house_type VARCHAR(255) DEFAULT NULL, living_area INT DEFAULT NULL, UNIQUE INDEX UNIQ_8062D116A76ED395 (user_id), INDEX IDX_8062D1161ED93D47 (user_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_information ADD CONSTRAINT FK_8062D116A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_information ADD CONSTRAINT FK_8062D1161ED93D47 FOREIGN KEY (user_group_id) REFERENCES user_groups (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_information DROP FOREIGN KEY FK_8062D116A76ED395');
        $this->addSql('ALTER TABLE user_information DROP FOREIGN KEY FK_8062D1161ED93D47');
        $this->addSql('DROP TABLE user_information');
    }
}
