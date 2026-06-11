<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260611084129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, username, roles, password, logo, co2_impact, uid, created_date, updated_date, deleted_date, is_deleted, path_id, created_by_id, updated_by_id, deleted_by_id FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(30) NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, co2_impact DOUBLE PRECISION DEFAULT 0 NOT NULL, uid CHAR(36) NOT NULL, created_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_date DATETIME DEFAULT NULL, deleted_date DATETIME DEFAULT NULL, is_deleted BOOLEAN DEFAULT 0 NOT NULL, path_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_8D93D649D96C566B FOREIGN KEY (path_id) REFERENCES path (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (id, email, username, roles, password, logo, co2_impact, uid, created_date, updated_date, deleted_date, is_deleted, path_id, created_by_id, updated_by_id, deleted_by_id) SELECT id, email, username, roles, password, logo, co2_impact, uid, created_date, updated_date, deleted_date, is_deleted, path_id, created_by_id, updated_by_id, deleted_by_id FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
        $this->addSql('CREATE INDEX IDX_8D93D649C76F1F52 ON user (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649896DBBDE ON user (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B03A8386 ON user (created_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D96C566B ON user (path_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649539B0606 ON user (uid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, username, roles, password, logo, co2_impact, uid, created_date, updated_date, deleted_date, is_deleted, path_id, created_by_id, updated_by_id, deleted_by_id FROM "user"');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(30) NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, co2_impact DOUBLE PRECISION DEFAULT \'0\' NOT NULL, uid CHAR(36) NOT NULL, created_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_date DATETIME DEFAULT NULL, deleted_date DATETIME DEFAULT NULL, is_deleted BOOLEAN DEFAULT 0 NOT NULL, path_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_8D93D649D96C566B FOREIGN KEY (path_id) REFERENCES path (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8D93D649C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "user" (id, email, username, roles, password, logo, co2_impact, uid, created_date, updated_date, deleted_date, is_deleted, path_id, created_by_id, updated_by_id, deleted_by_id) SELECT id, email, username, roles, password, logo, co2_impact, uid, created_date, updated_date, deleted_date, is_deleted, path_id, created_by_id, updated_by_id, deleted_by_id FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649539B0606 ON "user" (uid)');
        $this->addSql('CREATE INDEX IDX_8D93D649D96C566B ON "user" (path_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B03A8386 ON "user" (created_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649896DBBDE ON "user" (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649C76F1F52 ON "user" (deleted_by_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
    }
}
