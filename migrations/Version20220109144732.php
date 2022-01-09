<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220109144732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_page DROP FOREIGN KEY FK_F4DA3AB062E3BCE6');
        $this->addSql('DROP INDEX IDX_F4DA3AB062E3BCE6 ON blog_page');
        $this->addSql('ALTER TABLE blog_page DROP written_by_user_id');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C79F37AE5');
        $this->addSql('DROP INDEX IDX_9474526C79F37AE5 ON comment');
        $this->addSql('ALTER TABLE comment DROP id_user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_page ADD written_by_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE blog_page ADD CONSTRAINT FK_F4DA3AB062E3BCE6 FOREIGN KEY (written_by_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F4DA3AB062E3BCE6 ON blog_page (written_by_user_id)');
        $this->addSql('ALTER TABLE comment ADD id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9474526C79F37AE5 ON comment (id_user_id)');
    }
}
