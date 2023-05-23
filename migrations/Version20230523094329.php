<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523094329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taches ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE taches ADD CONSTRAINT FK_3BF2CD986BF700BD FOREIGN KEY (status_id) REFERENCES status_taches (id)');
        $this->addSql('CREATE INDEX IDX_3BF2CD986BF700BD ON taches (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taches DROP FOREIGN KEY FK_3BF2CD986BF700BD');
        $this->addSql('DROP INDEX IDX_3BF2CD986BF700BD ON taches');
        $this->addSql('ALTER TABLE taches DROP status_id');
    }
}
