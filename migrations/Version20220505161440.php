<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505161440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comments_users (comments_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_5CB5428F63379586 (comments_id), INDEX IDX_5CB5428F67B3B43D (users_id), PRIMARY KEY(comments_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments_users ADD CONSTRAINT FK_5CB5428F63379586 FOREIGN KEY (comments_id) REFERENCES comments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comments_users ADD CONSTRAINT FK_5CB5428F67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA674A03E');
        $this->addSql('DROP INDEX IDX_5F9E962AA674A03E ON comments');
        $this->addSql('ALTER TABLE comments ADD users_id INT NOT NULL, CHANGE tricks_id tricks_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA674A03E FOREIGN KEY (tricks_id_id) REFERENCES tricks (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962AA674A03E ON comments (tricks_id_id)');
        $this->addSql('ALTER TABLE users CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comments_users');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA674A03E');
        $this->addSql('DROP INDEX IDX_5F9E962AA674A03E ON comments');
        $this->addSql('ALTER TABLE comments ADD tricks_id INT NOT NULL, DROP tricks_id_id, DROP users_id');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA674A03E FOREIGN KEY (tricks_id) REFERENCES tricks (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962AA674A03E ON comments (tricks_id)');
        $this->addSql('ALTER TABLE users CHANGE roles roles VARCHAR(10) DEFAULT NULL');
    }
}
