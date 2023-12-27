<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231227184700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employee (id INT NOT NULL, emp_number VARCHAR(255) NOT NULL, admin_role TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499CEB97F7 FOREIGN KEY (zip_code_id) REFERENCES zip_code (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6499CEB97F7 ON user (zip_code_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1BF396750');
        $this->addSql('DROP TABLE employee');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499CEB97F7');
        $this->addSql('DROP INDEX IDX_8D93D6499CEB97F7 ON user');
    }
}
