<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200626125851 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_badge (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_badge_utilisateur (id INT AUTO_INCREMENT NOT NULL, user_badge_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_BFAEA4F172F26FC (user_badge_id), INDEX IDX_BFAEA4FFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_badge_utilisateur ADD CONSTRAINT FK_BFAEA4F172F26FC FOREIGN KEY (user_badge_id) REFERENCES user_badge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_badge_utilisateur ADD CONSTRAINT FK_BFAEA4FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_badge_utilisateur DROP FOREIGN KEY FK_BFAEA4F172F26FC');
        $this->addSql('DROP TABLE user_badge');
        $this->addSql('DROP TABLE user_badge_utilisateur');
    }
}
