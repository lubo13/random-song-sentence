<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211120113833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE song_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE song (id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, full_text_in_this_column TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_33EDEEA12B36786B ON song (title)');
        $this->addSql('CREATE INDEX search_1 ON song (title)');
        $this->addSql('CREATE INDEX search_2 ON song (created_at)');
        $this->addSql('CREATE INDEX search_3 ON song (updated_at)');
        $this->addSql('CREATE INDEX search_4 ON song (created_at, updated_at)');
        $this->addSql('CREATE INDEX search_5 ON song (title, created_at, updated_at)');
        $this->addSql('COMMENT ON COLUMN song.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN song.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE song_id_seq CASCADE');
        $this->addSql('DROP TABLE song');
    }
}
