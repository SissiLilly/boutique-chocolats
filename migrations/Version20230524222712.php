<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524222712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ideecadeau ADD categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE ideecadeau ADD CONSTRAINT FK_291CF3ABCF5E72D FOREIGN KEY (categorie_id) REFERENCES collection (id)');
        $this->addSql('CREATE INDEX IDX_291CF3ABCF5E72D ON ideecadeau (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ideecadeau DROP FOREIGN KEY FK_291CF3ABCF5E72D');
        $this->addSql('DROP INDEX IDX_291CF3ABCF5E72D ON ideecadeau');
        $this->addSql('ALTER TABLE ideecadeau DROP categorie_id');
    }
}
