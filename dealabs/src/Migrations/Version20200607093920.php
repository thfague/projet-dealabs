<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200607093920 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, auteur_id INT NOT NULL, texte VARCHAR(255) NOT NULL, date_publication DATE NOT NULL, INDEX IDX_67F068BC60BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deal (id INT AUTO_INCREMENT NOT NULL, auteur_id INT NOT NULL, type_id INT NOT NULL, categorie_id INT DEFAULT NULL, prix DOUBLE PRECISION NOT NULL, fdp DOUBLE PRECISION NOT NULL, livraison TINYINT(1) NOT NULL, prix_hab DOUBLE PRECISION NOT NULL, note INT NOT NULL, date_publication DATE NOT NULL, description VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) NOT NULL, lien VARCHAR(255) DEFAULT NULL, type_reduc INT DEFAULT NULL, valeur_code_promo DOUBLE PRECISION DEFAULT NULL, code_promo VARCHAR(255) DEFAULT NULL, INDEX IDX_E3FEC11660BB6FE6 (auteur_id), INDEX IDX_E3FEC116C54C8C93 (type_id), INDEX IDX_E3FEC116BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deal_rate (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, deal_id INT NOT NULL, date VARCHAR(255) NOT NULL, rate INT NOT NULL, INDEX IDX_69915A96FB88E14F (utilisateur_id), INDEX IDX_69915A96F60E2305 (deal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deal_type (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_deal (utilisateur_id INT NOT NULL, deal_id INT NOT NULL, INDEX IDX_2A7FAD2CFB88E14F (utilisateur_id), INDEX IDX_2A7FAD2CF60E2305 (deal_id), PRIMARY KEY(utilisateur_id, deal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC11660BB6FE6 FOREIGN KEY (auteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC116C54C8C93 FOREIGN KEY (type_id) REFERENCES deal_type (id)');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC116BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE deal_rate ADD CONSTRAINT FK_69915A96FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE deal_rate ADD CONSTRAINT FK_69915A96F60E2305 FOREIGN KEY (deal_id) REFERENCES deal (id)');
        $this->addSql('ALTER TABLE utilisateur_deal ADD CONSTRAINT FK_2A7FAD2CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_deal ADD CONSTRAINT FK_2A7FAD2CF60E2305 FOREIGN KEY (deal_id) REFERENCES deal (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE deal DROP FOREIGN KEY FK_E3FEC116BCF5E72D');
        $this->addSql('ALTER TABLE deal_rate DROP FOREIGN KEY FK_69915A96F60E2305');
        $this->addSql('ALTER TABLE utilisateur_deal DROP FOREIGN KEY FK_2A7FAD2CF60E2305');
        $this->addSql('ALTER TABLE deal DROP FOREIGN KEY FK_E3FEC116C54C8C93');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC60BB6FE6');
        $this->addSql('ALTER TABLE deal DROP FOREIGN KEY FK_E3FEC11660BB6FE6');
        $this->addSql('ALTER TABLE deal_rate DROP FOREIGN KEY FK_69915A96FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_deal DROP FOREIGN KEY FK_2A7FAD2CFB88E14F');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE deal');
        $this->addSql('DROP TABLE deal_rate');
        $this->addSql('DROP TABLE deal_type');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_deal');
    }
}
