<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231014183449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9F670345A58240EF ON shorten (source_url)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9F6703455CF6E1C8 ON shorten (hashed_url)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_9F670345A58240EF ON shorten');
        $this->addSql('DROP INDEX UNIQ_9F6703455CF6E1C8 ON shorten');
    }
}
