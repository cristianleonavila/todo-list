<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260812041837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create todos table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE todos (created_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, completed TINYINT NOT NULL, id INT AUTO_INCREMENT NOT NULL, created_by INT NOT NULL, INDEX IDX_CD826255DE12AB56 (created_by), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE todos ADD CONSTRAINT FK_CD826255DE12AB56 FOREIGN KEY (created_by) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE todos DROP FOREIGN KEY FK_CD826255DE12AB56');
        $this->addSql('DROP TABLE todos');
    }
}
