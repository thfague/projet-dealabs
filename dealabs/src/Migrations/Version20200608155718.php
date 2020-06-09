<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200608155718 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE deal CHANGE prix prix DOUBLE PRECISION DEFAULT NULL, CHANGE fdp fdp DOUBLE PRECISION DEFAULT NULL, CHANGE livraison livraison TINYINT(1) DEFAULT NULL, CHANGE prix_hab prix_hab DOUBLE PRECISION DEFAULT NULL, CHANGE lien lien VARCHAR(1000) DEFAULT NULL');
        $this->addSql('INSERT INTO deal_type (nom) VALUES("Bon plan")');
        $this->addSql('INSERT INTO deal_type (nom) VALUES("Code promo")');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE deal CHANGE prix prix DOUBLE PRECISION NOT NULL, CHANGE fdp fdp DOUBLE PRECISION NOT NULL, CHANGE livraison livraison TINYINT(1) NOT NULL, CHANGE prix_hab prix_hab DOUBLE PRECISION NOT NULL, CHANGE lien lien VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
