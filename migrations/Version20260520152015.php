<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260520152015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE level ADD uid UUID NOT NULL');
        $this->addSql('ALTER TABLE level ADD created_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE level ADD updated_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE level ADD deleted_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE level ADD is_deleted BOOLEAN DEFAULT false NOT NULL');
        $this->addSql('ALTER TABLE level ADD created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE level ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE level ADD deleted_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE level ADD CONSTRAINT FK_9AEACC13B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE level ADD CONSTRAINT FK_9AEACC13896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE level ADD CONSTRAINT FK_9AEACC13C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9AEACC13539B0606 ON level (uid)');
        $this->addSql('CREATE INDEX IDX_9AEACC13B03A8386 ON level (created_by_id)');
        $this->addSql('CREATE INDEX IDX_9AEACC13896DBBDE ON level (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_9AEACC13C76F1F52 ON level (deleted_by_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_LEVEL_NAME ON level (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE level DROP CONSTRAINT FK_9AEACC13B03A8386');
        $this->addSql('ALTER TABLE level DROP CONSTRAINT FK_9AEACC13896DBBDE');
        $this->addSql('ALTER TABLE level DROP CONSTRAINT FK_9AEACC13C76F1F52');
        $this->addSql('DROP INDEX UNIQ_9AEACC13539B0606');
        $this->addSql('DROP INDEX IDX_9AEACC13B03A8386');
        $this->addSql('DROP INDEX IDX_9AEACC13896DBBDE');
        $this->addSql('DROP INDEX IDX_9AEACC13C76F1F52');
        $this->addSql('DROP INDEX UNIQ_LEVEL_NAME');
        $this->addSql('ALTER TABLE level DROP uid');
        $this->addSql('ALTER TABLE level DROP created_date');
        $this->addSql('ALTER TABLE level DROP updated_date');
        $this->addSql('ALTER TABLE level DROP deleted_date');
        $this->addSql('ALTER TABLE level DROP is_deleted');
        $this->addSql('ALTER TABLE level DROP created_by_id');
        $this->addSql('ALTER TABLE level DROP updated_by_id');
        $this->addSql('ALTER TABLE level DROP deleted_by_id');
    }
}
