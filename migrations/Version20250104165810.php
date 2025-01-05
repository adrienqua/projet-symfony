<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250104165810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE client (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE renter (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE renter ADD CONSTRAINT FK_887A3A1ABF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
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
        $this->addSql('ALTER TABLE user ADD discr VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873EE289A545');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750');
        $this->addSql('ALTER TABLE renter DROP FOREIGN KEY FK_887A3A1ABF396750');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE renter');
        $this->addSql('ALTER TABLE message ADD sent_date DATETIME NOT NULL, DROP sent_at');
        $this->addSql('ALTER TABLE contract ADD creation_date DATETIME NOT NULL, DROP created_at');
        $this->addSql('DROP INDEX IDX_29D6873EE289A545 ON offer');
        $this->addSql('ALTER TABLE offer ADD proposer_id INT DEFAULT NULL, ADD creation_date DATETIME NOT NULL, DROP renter_id, DROP created_at');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873EB13FA634 FOREIGN KEY (proposer_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_29D6873EB13FA634 ON offer (proposer_id)');
        $this->addSql('ALTER TABLE payment ADD payment_date DATETIME NOT NULL, DROP created_at');
        $this->addSql('ALTER TABLE review ADD review_date DATETIME NOT NULL, DROP created_at');
        $this->addSql('ALTER TABLE notification ADD notification_date DATETIME NOT NULL, DROP created_at');
        $this->addSql('ALTER TABLE task ADD request_date DATETIME NOT NULL, DROP created_at');
        $this->addSql('ALTER TABLE user DROP discr');
    }
}
