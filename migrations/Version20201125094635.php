<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201125094635 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_bus_magique (game_id INT NOT NULL, bus_magique_id INT NOT NULL, INDEX IDX_967474BCE48FD905 (game_id), INDEX IDX_967474BC6CF49749 (bus_magique_id), PRIMARY KEY(game_id, bus_magique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_bus_magique ADD CONSTRAINT FK_967474BCE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_bus_magique ADD CONSTRAINT FK_967474BC6CF49749 FOREIGN KEY (bus_magique_id) REFERENCES bus_magique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game DROP players');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game_bus_magique');
        $this->addSql('ALTER TABLE game ADD players JSON NOT NULL');
    }
}
