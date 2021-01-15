<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210115100605 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CA6DD161A5');
        $this->addSql('DROP INDEX UNIQ_1CAC12CA6DD161A5 ON commentary');
        $this->addSql('ALTER TABLE commentary CHANGE dishes_order_id order_dishes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CA1CDAA882 FOREIGN KEY (order_dishes_id) REFERENCES `order` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1CAC12CA1CDAA882 ON commentary (order_dishes_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CA1CDAA882');
        $this->addSql('DROP INDEX UNIQ_1CAC12CA1CDAA882 ON commentary');
        $this->addSql('ALTER TABLE commentary CHANGE order_dishes_id dishes_order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CA6DD161A5 FOREIGN KEY (dishes_order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1CAC12CA6DD161A5 ON commentary (dishes_order_id)');
    }
}
