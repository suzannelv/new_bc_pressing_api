<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231224054910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zip_code (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, zip_code VARCHAR(5) NOT NULL, city VARCHAR(255) NOT NULL, INDEX IDX_A1ACE158F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE zip_code ADD CONSTRAINT FK_A1ACE158F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE user ADD zip_code_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499CEB97F7 FOREIGN KEY (zip_code_id) REFERENCES zip_code (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6499CEB97F7 ON user (zip_code_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499CEB97F7');
        $this->addSql('ALTER TABLE zip_code DROP FOREIGN KEY FK_A1ACE158F92F3E70');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE zip_code');
        $this->addSql('DROP INDEX IDX_8D93D6499CEB97F7 ON user');
        $this->addSql('ALTER TABLE user DROP zip_code_id');
    }
}
