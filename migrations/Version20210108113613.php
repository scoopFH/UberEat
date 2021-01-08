<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210108113613 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_dish (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dish ADD order_dish_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dish ADD CONSTRAINT FK_957D8CB8E2F41980 FOREIGN KEY (order_dish_id) REFERENCES order_dish (id)');
        $this->addSql('CREATE INDEX IDX_957D8CB8E2F41980 ON dish (order_dish_id)');
        $this->addSql('ALTER TABLE `order` ADD order_dish_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398E2F41980 FOREIGN KEY (order_dish_id) REFERENCES order_dish (id)');
        $this->addSql('CREATE INDEX IDX_F5299398E2F41980 ON `order` (order_dish_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dish DROP FOREIGN KEY FK_957D8CB8E2F41980');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398E2F41980');
        $this->addSql('DROP TABLE order_dish');
        $this->addSql('DROP INDEX IDX_957D8CB8E2F41980 ON dish');
        $this->addSql('ALTER TABLE dish DROP order_dish_id');
        $this->addSql('DROP INDEX IDX_F5299398E2F41980 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP order_dish_id');
    }
}
