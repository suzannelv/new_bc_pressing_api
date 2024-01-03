<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240103083815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_64C19C1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, membership TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT NOT NULL, emp_number VARCHAR(255) NOT NULL, admin_role TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE material (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, coefficent_price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_detail (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, emp_id INT NOT NULL, payment_id INT NOT NULL, order_status_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', comment LONGTEXT DEFAULT NULL, delivery TINYINT(1) NOT NULL, deposit_date DATETIME NOT NULL, retrieve_date DATETIME NOT NULL, order_number VARCHAR(255) NOT NULL, code_promo VARCHAR(255) DEFAULT NULL, INDEX IDX_ED896F4619EB6921 (client_id), INDEX IDX_ED896F467A663008 (emp_id), INDEX IDX_ED896F464C3A3BB (payment_id), INDEX IDX_ED896F46D7707B45 (order_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_status (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, method VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, product_status_id INT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04AD557B630 (product_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_selected (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, material_id INT NOT NULL, order_detail_id INT NOT NULL, total_price DOUBLE PRECISION NOT NULL, INDEX IDX_5319D5114584665A (product_id), INDEX IDX_5319D511E308AC6F (material_id), INDEX IDX_5319D51164577843 (order_detail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_selected_service_option (product_selected_id INT NOT NULL, service_option_id INT NOT NULL, INDEX IDX_1D0D7272E38195BE (product_selected_id), INDEX IDX_1D0D7272FF552725 (service_option_id), PRIMARY KEY(product_selected_id, service_option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_status (id INT AUTO_INCREMENT NOT NULL, status_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_option (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, coefficent_price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, zip_code_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birthday DATE NOT NULL, phone_number VARCHAR(10) NOT NULL, adress VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', profil_url VARCHAR(255) DEFAULT NULL, discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6499CEB97F7 (zip_code_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zip_code (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, zip_code VARCHAR(5) NOT NULL, city VARCHAR(255) NOT NULL, INDEX IDX_A1ACE158F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F4619EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F467A663008 FOREIGN KEY (emp_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F464C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F46D7707B45 FOREIGN KEY (order_status_id) REFERENCES order_status (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD557B630 FOREIGN KEY (product_status_id) REFERENCES product_status (id)');
        $this->addSql('ALTER TABLE product_selected ADD CONSTRAINT FK_5319D5114584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_selected ADD CONSTRAINT FK_5319D511E308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
        $this->addSql('ALTER TABLE product_selected ADD CONSTRAINT FK_5319D51164577843 FOREIGN KEY (order_detail_id) REFERENCES order_detail (id)');
        $this->addSql('ALTER TABLE product_selected_service_option ADD CONSTRAINT FK_1D0D7272E38195BE FOREIGN KEY (product_selected_id) REFERENCES product_selected (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_selected_service_option ADD CONSTRAINT FK_1D0D7272FF552725 FOREIGN KEY (service_option_id) REFERENCES service_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499CEB97F7 FOREIGN KEY (zip_code_id) REFERENCES zip_code (id)');
        $this->addSql('ALTER TABLE zip_code ADD CONSTRAINT FK_A1ACE158F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1BF396750');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F4619EB6921');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F467A663008');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F464C3A3BB');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F46D7707B45');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD557B630');
        $this->addSql('ALTER TABLE product_selected DROP FOREIGN KEY FK_5319D5114584665A');
        $this->addSql('ALTER TABLE product_selected DROP FOREIGN KEY FK_5319D511E308AC6F');
        $this->addSql('ALTER TABLE product_selected DROP FOREIGN KEY FK_5319D51164577843');
        $this->addSql('ALTER TABLE product_selected_service_option DROP FOREIGN KEY FK_1D0D7272E38195BE');
        $this->addSql('ALTER TABLE product_selected_service_option DROP FOREIGN KEY FK_1D0D7272FF552725');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499CEB97F7');
        $this->addSql('ALTER TABLE zip_code DROP FOREIGN KEY FK_A1ACE158F92F3E70');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE material');
        $this->addSql('DROP TABLE order_detail');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_selected');
        $this->addSql('DROP TABLE product_selected_service_option');
        $this->addSql('DROP TABLE product_status');
        $this->addSql('DROP TABLE service_option');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE zip_code');
    }
}
