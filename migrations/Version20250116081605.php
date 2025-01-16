<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250116081605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS client (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS renter (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS user_task (user_id INT NOT NULL, task_id INT NOT NULL, INDEX IDX_28FF97ECA76ED395 (user_id), INDEX IDX_28FF97EC8DB60186 (task_id), PRIMARY KEY(user_id, task_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE renter ADD CONSTRAINT FK_887A3A1ABF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_task ADD CONSTRAINT FK_28FF97ECA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_task ADD CONSTRAINT FK_28FF97EC8DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contract ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP creation_date');
        $this->addSql('ALTER TABLE message ADD sent_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP sent_date');
        $this->addSql('ALTER TABLE notification ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP notification_date');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873EB13FA634');
        $this->addSql('DROP INDEX IDX_29D6873EB13FA634 ON offer');
        $this->addSql('ALTER TABLE offer ADD renter_id INT NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP proposer_id, DROP creation_date');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873EE289A545 FOREIGN KEY (renter_id) REFERENCES renter (id)');
        $this->addSql('CREATE INDEX IDX_29D6873EE289A545 ON offer (renter_id)');
        $this->addSql('ALTER TABLE payment ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP payment_date');
        $this->addSql('ALTER TABLE review ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP review_date');
        $this->addSql('ALTER TABLE task ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP request_date');
        $this->addSql('ALTER TABLE user ADD username VARCHAR(30) NOT NULL, ADD discr VARCHAR(255) NOT NULL, CHANGE birth_date birth_date DATE NOT NULL, CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\', CHANGE offers_adult_content offers_adult_content TINYINT(1) DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873EE289A545');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750');
        $this->addSql('ALTER TABLE renter DROP FOREIGN KEY FK_887A3A1ABF396750');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user_task DROP FOREIGN KEY FK_28FF97ECA76ED395');
        $this->addSql('ALTER TABLE user_task DROP FOREIGN KEY FK_28FF97EC8DB60186');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE renter');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user_task');
        $this->addSql('ALTER TABLE contract ADD creation_date DATETIME NOT NULL, DROP created_at');
        $this->addSql('ALTER TABLE message ADD sent_date DATETIME NOT NULL, DROP sent_at');
        $this->addSql('ALTER TABLE notification ADD notification_date DATETIME NOT NULL, DROP created_at');
        $this->addSql('DROP INDEX IDX_29D6873EE289A545 ON offer');
        $this->addSql('ALTER TABLE offer ADD proposer_id INT DEFAULT NULL, ADD creation_date DATETIME NOT NULL, DROP renter_id, DROP created_at');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873EB13FA634 FOREIGN KEY (proposer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_29D6873EB13FA634 ON offer (proposer_id)');
        $this->addSql('ALTER TABLE payment ADD payment_date DATETIME NOT NULL, DROP created_at');
        $this->addSql('ALTER TABLE review ADD review_date DATETIME NOT NULL, DROP created_at');
        $this->addSql('ALTER TABLE task ADD request_date DATETIME NOT NULL, DROP created_at');
        $this->addSql('ALTER TABLE user DROP username, DROP discr, CHANGE birth_date birth_date DATETIME NOT NULL, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE offers_adult_content offers_adult_content TINYINT(1) NOT NULL');
    }
}
