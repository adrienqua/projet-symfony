<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250201221144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939819EB6921');
        $this->addSql('DROP INDEX IDX_F529939819EB6921 ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE client_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE user_id client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939819EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F529939819EB6921 ON `order` (client_id)');
    }
}
