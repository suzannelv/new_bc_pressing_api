<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231223153357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE material (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, coefficent_price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_selected (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, material_id INT NOT NULL, total_price DOUBLE PRECISION NOT NULL, INDEX IDX_5319D5114584665A (product_id), INDEX IDX_5319D511E308AC6F (material_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_selected_service_option (product_selected_id INT NOT NULL, service_option_id INT NOT NULL, INDEX IDX_1D0D7272E38195BE (product_selected_id), INDEX IDX_1D0D7272FF552725 (service_option_id), PRIMARY KEY(product_selected_id, service_option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_option (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, coefficent_price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_selected ADD CONSTRAINT FK_5319D5114584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_selected ADD CONSTRAINT FK_5319D511E308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
        $this->addSql('ALTER TABLE product_selected_service_option ADD CONSTRAINT FK_1D0D7272E38195BE FOREIGN KEY (product_selected_id) REFERENCES product_selected (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_selected_service_option ADD CONSTRAINT FK_1D0D7272FF552725 FOREIGN KEY (service_option_id) REFERENCES service_option (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_selected DROP FOREIGN KEY FK_5319D5114584665A');
        $this->addSql('ALTER TABLE product_selected DROP FOREIGN KEY FK_5319D511E308AC6F');
        $this->addSql('ALTER TABLE product_selected_service_option DROP FOREIGN KEY FK_1D0D7272E38195BE');
        $this->addSql('ALTER TABLE product_selected_service_option DROP FOREIGN KEY FK_1D0D7272FF552725');
        $this->addSql('DROP TABLE material');
        $this->addSql('DROP TABLE product_selected');
        $this->addSql('DROP TABLE product_selected_service_option');
        $this->addSql('DROP TABLE service_option');
    }
}
