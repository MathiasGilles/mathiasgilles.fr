<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201210093405 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bus_magique (id INT AUTO_INCREMENT NOT NULL, player VARCHAR(255) NOT NULL, km INT NOT NULL, gorge INT NOT NULL, gorgee_total INT NOT NULL, km_total INT NOT NULL, cities JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, longitude DOUBLE PRECISION NOT NULL, latitude DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_bus_magique (game_id INT NOT NULL, bus_magique_id INT NOT NULL, INDEX IDX_967474BCE48FD905 (game_id), INDEX IDX_967474BC6CF49749 (bus_magique_id), PRIMARY KEY(game_id, bus_magique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_bus_magique ADD CONSTRAINT FK_967474BCE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_bus_magique ADD CONSTRAINT FK_967474BC6CF49749 FOREIGN KEY (bus_magique_id) REFERENCES bus_magique (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_bus_magique DROP FOREIGN KEY FK_967474BC6CF49749');
        $this->addSql('ALTER TABLE game_bus_magique DROP FOREIGN KEY FK_967474BCE48FD905');
        $this->addSql('DROP TABLE bus_magique');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_bus_magique');
        $this->addSql('DROP TABLE user');
    }
}
