<?php
declare(strict_types = 1);
namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240324170501 extends AbstractMigration
{

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE energy_types  (
                id INT AUTO_INCREMENT NOT NULL,
                type VARCHAR(255) NOT NULL,
                    PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql("        
            INSERT INTO `energy_types` (`id`, `type`) VALUES
                (1, 'Maistas'),
                (2, 'Elektra'),
                (3, 'Atliekos'),
                (4, 'Pirkiniai'),
                (5, 'Transportas'),
                (6, 'Kuras'),
                (7, 'Šiluma'),
                (8, 'Vanduo');"
            );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE energy_types');
    }
}
