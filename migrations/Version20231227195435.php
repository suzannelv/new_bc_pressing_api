<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231227195435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_detail (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, emp_id INT NOT NULL, payment_id INT NOT NULL, order_status_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', comment LONGTEXT DEFAULT NULL, delivery TINYINT(1) NOT NULL, deposit_date DATETIME NOT NULL, retrieve_date DATETIME NOT NULL, order_number VARCHAR(255) NOT NULL, code_promo VARCHAR(255) DEFAULT NULL, INDEX IDX_ED896F4619EB6921 (client_id), INDEX IDX_ED896F467A663008 (emp_id), INDEX IDX_ED896F464C3A3BB (payment_id), INDEX IDX_ED896F46D7707B45 (order_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_status (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, method VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F4619EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F467A663008 FOREIGN KEY (emp_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F464C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F46D7707B45 FOREIGN KEY (order_status_id) REFERENCES order_status (id)');
        $this->addSql('ALTER TABLE product_selected ADD order_detail_id INT NOT NULL');
        $this->addSql('ALTER TABLE product_selected ADD CONSTRAINT FK_5319D51164577843 FOREIGN KEY (order_detail_id) REFERENCES order_detail (id)');
        $this->addSql('CREATE INDEX IDX_5319D51164577843 ON product_selected (order_detail_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_selected DROP FOREIGN KEY FK_5319D51164577843');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F4619EB6921');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F467A663008');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F464C3A3BB');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F46D7707B45');
        $this->addSql('DROP TABLE order_detail');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP INDEX IDX_5319D51164577843 ON product_selected');
        $this->addSql('ALTER TABLE product_selected DROP order_detail_id');
    }
}
