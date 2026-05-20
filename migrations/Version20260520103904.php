<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260520103904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD path_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649D96C566B FOREIGN KEY (path_id) REFERENCES path (id)');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D96C566B ON "user" (path_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649296CD8AE ON "user" (team_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649D96C566B');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649296CD8AE');
        $this->addSql('DROP INDEX IDX_8D93D649D96C566B');
        $this->addSql('DROP INDEX IDX_8D93D649296CD8AE');
        $this->addSql('ALTER TABLE "user" DROP path_id');
        $this->addSql('ALTER TABLE "user" DROP team_id');
    }
}
