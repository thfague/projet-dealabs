<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200518163449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE deal_rate (id INT AUTO_INCREMENT NOT NULL, date VARCHAR(255) NOT NULL, rate INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE deal ADD deal_rates_id INT NOT NULL');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC11664FABBF5 FOREIGN KEY (deal_rates_id) REFERENCES deal_rate (id)');
        $this->addSql('CREATE INDEX IDX_E3FEC11664FABBF5 ON deal (deal_rates_id)');
        $this->addSql('ALTER TABLE utilisateur ADD deal_rates_id INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B364FABBF5 FOREIGN KEY (deal_rates_id) REFERENCES deal_rate (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B364FABBF5 ON utilisateur (deal_rates_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE deal DROP FOREIGN KEY FK_E3FEC11664FABBF5');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B364FABBF5');
        $this->addSql('DROP TABLE deal_rate');
        $this->addSql('DROP INDEX IDX_E3FEC11664FABBF5 ON deal');
        $this->addSql('ALTER TABLE deal DROP deal_rates_id');
        $this->addSql('DROP INDEX IDX_1D1C63B364FABBF5 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP deal_rates_id');
    }
}
