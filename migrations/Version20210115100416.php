<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210115100416 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993985DED49AA');
        $this->addSql('DROP INDEX UNIQ_F52993985DED49AA ON `order`');
        $this->addSql('ALTER TABLE `order` DROP commentary_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD commentary_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993985DED49AA FOREIGN KEY (commentary_id) REFERENCES commentary (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F52993985DED49AA ON `order` (commentary_id)');
    }
}
