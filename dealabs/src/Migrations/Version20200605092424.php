<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200605092424 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bon_plan (id INT AUTO_INCREMENT NOT NULL, auteur_id INT DEFAULT NULL, lien VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, prix_hab DOUBLE PRECISION NOT NULL, fdp DOUBLE PRECISION DEFAULT NULL, livraison_gratuite TINYINT(1) DEFAULT NULL, valeur VARCHAR(255) DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, date_publication DATE NOT NULL, INDEX IDX_FEB1F6F260BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bon_plan_categorie (bon_plan_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_DBA906202E81A751 (bon_plan_id), INDEX IDX_DBA90620BCF5E72D (categorie_id), PRIMARY KEY(bon_plan_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_code_promo (categorie_id INT NOT NULL, code_promo_id INT NOT NULL, INDEX IDX_C28F491BBCF5E72D (categorie_id), INDEX IDX_C28F491B294102D4 (code_promo_id), PRIMARY KEY(categorie_id, code_promo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE code_promo (id INT AUTO_INCREMENT NOT NULL, auteur_id INT DEFAULT NULL, lien VARCHAR(255) NOT NULL, type_reduction INT DEFAULT NULL, valeur VARCHAR(255) DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, valeur_reduc DOUBLE PRECISION DEFAULT NULL, date_publication DATE DEFAULT NULL, INDEX IDX_5C4683B760BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, auteur_id INT DEFAULT NULL, texte VARCHAR(255) NOT NULL, date_publication DATE NOT NULL, INDEX IDX_67F068BC60BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deal_rate (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, code_promo_id INT DEFAULT NULL, bon_plan_id INT DEFAULT NULL, date DATE DEFAULT NULL, rate INT DEFAULT NULL, INDEX IDX_69915A96FB88E14F (utilisateur_id), INDEX IDX_69915A96294102D4 (code_promo_id), INDEX IDX_69915A962E81A751 (bon_plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bon_plan ADD CONSTRAINT FK_FEB1F6F260BB6FE6 FOREIGN KEY (auteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE bon_plan_categorie ADD CONSTRAINT FK_DBA906202E81A751 FOREIGN KEY (bon_plan_id) REFERENCES bon_plan (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bon_plan_categorie ADD CONSTRAINT FK_DBA90620BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_code_promo ADD CONSTRAINT FK_C28F491BBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_code_promo ADD CONSTRAINT FK_C28F491B294102D4 FOREIGN KEY (code_promo_id) REFERENCES code_promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE code_promo ADD CONSTRAINT FK_5C4683B760BB6FE6 FOREIGN KEY (auteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE deal_rate ADD CONSTRAINT FK_69915A96FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE deal_rate ADD CONSTRAINT FK_69915A96294102D4 FOREIGN KEY (code_promo_id) REFERENCES code_promo (id)');
        $this->addSql('ALTER TABLE deal_rate ADD CONSTRAINT FK_69915A962E81A751 FOREIGN KEY (bon_plan_id) REFERENCES bon_plan (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bon_plan_categorie DROP FOREIGN KEY FK_DBA906202E81A751');
        $this->addSql('ALTER TABLE deal_rate DROP FOREIGN KEY FK_69915A962E81A751');
        $this->addSql('ALTER TABLE bon_plan_categorie DROP FOREIGN KEY FK_DBA90620BCF5E72D');
        $this->addSql('ALTER TABLE categorie_code_promo DROP FOREIGN KEY FK_C28F491BBCF5E72D');
        $this->addSql('ALTER TABLE categorie_code_promo DROP FOREIGN KEY FK_C28F491B294102D4');
        $this->addSql('ALTER TABLE deal_rate DROP FOREIGN KEY FK_69915A96294102D4');
        $this->addSql('ALTER TABLE bon_plan DROP FOREIGN KEY FK_FEB1F6F260BB6FE6');
        $this->addSql('ALTER TABLE code_promo DROP FOREIGN KEY FK_5C4683B760BB6FE6');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC60BB6FE6');
        $this->addSql('ALTER TABLE deal_rate DROP FOREIGN KEY FK_69915A96FB88E14F');
        $this->addSql('DROP TABLE bon_plan');
        $this->addSql('DROP TABLE bon_plan_categorie');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE categorie_code_promo');
        $this->addSql('DROP TABLE code_promo');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE deal_rate');
        $this->addSql('DROP TABLE utilisateur');
    }
}
