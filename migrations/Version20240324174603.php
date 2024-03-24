<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240324174603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_groups (
            id INT AUTO_INCREMENT NOT NULL,
            is_big_city TINYINT(1) NOT NULL,
            is_private_house TINYINT(1) NOT NULL, 
            min_residents INT NOT NULL, 
            max_residents INT NOT NULL, 
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
            );
        
        $this->addSql("
            INSERT INTO `user_groups` (`id`, `is_big_city`, `is_private_house`, `min_residents`, `max_residents`) VALUES
                (1, 0, 0, 1, 1),
                (2, 0, 1, 1, 1),
                (3, 1, 0, 1, 1),
                (4, 1, 1, 1, 1),
                (5, 0, 0, 2, 2),
                (6, 0, 1, 2, 2),
                (7, 1, 0, 2, 2),
                (8, 1, 1, 2, 2),
                (9, 0, 0, 3, 3),
                (10, 0, 1, 3, 3),
                (11, 1, 0, 3, 3),
                (12, 1, 1, 3, 3),
                (13, 0, 0, 4, 4),
                (14, 0, 1, 4, 4),
                (15, 1, 0, 4, 4),
                (16, 1, 1, 4, 4),
                (17, 0, 0, 5, 5),
                (18, 0, 1, 5, 5),
                (19, 1, 0, 5, 5),
                (20, 1, 1, 5, 5),
                (21, 0, 0, 6, 7),
                (22, 0, 1, 6, 7),
                (23, 1, 0, 6, 7),
                (24, 1, 1, 6, 7),
                (25, 0, 0, 8, 10);"
            );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_groups');
    }
}
