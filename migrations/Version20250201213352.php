<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250201213352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `order` ADD offer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939853C674EE FOREIGN KEY (offer_id) REFERENCES offer (id)');
        $this->addSql('CREATE INDEX IDX_F529939853C674EE ON `order` (offer_id)');
        $this->addSql('ALTER TABLE payment ADD stripe_order_id VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE payment DROP stripe_order_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939853C674EE');
        $this->addSql('DROP INDEX IDX_F529939853C674EE ON `order`');
        $this->addSql('ALTER TABLE `order` DROP offer_id');
    }
}
