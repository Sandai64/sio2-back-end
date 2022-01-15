<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220109144416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_page (id INT AUTO_INCREMENT NOT NULL, id_blog_category_id INT NOT NULL, written_by_user_id INT NOT NULL, username_id INT NOT NULL, title LONGTEXT NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, slug VARCHAR(2048) NOT NULL, INDEX IDX_F4DA3AB028FC54CD (id_blog_category_id), INDEX IDX_F4DA3AB062E3BCE6 (written_by_user_id), INDEX IDX_F4DA3AB0ED766068 (username_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(2048) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, is_hidden TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commands (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', table_number INT NOT NULL, is_served TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(500) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9474526C79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, id_category_id INT NOT NULL, id_product_kind_id INT NOT NULL, tax_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, price_tax_free DOUBLE PRECISION NOT NULL, image_path VARCHAR(8096) DEFAULT NULL, is_hidden TINYINT(1) NOT NULL, slug VARCHAR(2048) NOT NULL, INDEX IDX_D34A04ADA545015 (id_category_id), INDEX IDX_D34A04AD8E7F491 (id_product_kind_id), INDEX IDX_D34A04ADCC3E6B76 (tax_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_kind (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tax (id INT AUTO_INCREMENT NOT NULL, percentage DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_page ADD CONSTRAINT FK_F4DA3AB028FC54CD FOREIGN KEY (id_blog_category_id) REFERENCES blog_category (id)');
        $this->addSql('ALTER TABLE blog_page ADD CONSTRAINT FK_F4DA3AB062E3BCE6 FOREIGN KEY (written_by_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE blog_page ADD CONSTRAINT FK_F4DA3AB0ED766068 FOREIGN KEY (username_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA545015 FOREIGN KEY (id_category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD8E7F491 FOREIGN KEY (id_product_kind_id) REFERENCES product_kind (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADCC3E6B76 FOREIGN KEY (tax_id_id) REFERENCES tax (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_page DROP FOREIGN KEY FK_F4DA3AB028FC54CD');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA545015');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD8E7F491');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADCC3E6B76');
        $this->addSql('ALTER TABLE blog_page DROP FOREIGN KEY FK_F4DA3AB062E3BCE6');
        $this->addSql('ALTER TABLE blog_page DROP FOREIGN KEY FK_F4DA3AB0ED766068');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C79F37AE5');
        $this->addSql('DROP TABLE blog_category');
        $this->addSql('DROP TABLE blog_page');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE commands');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_kind');
        $this->addSql('DROP TABLE tax');
        $this->addSql('DROP TABLE user');
    }
}
