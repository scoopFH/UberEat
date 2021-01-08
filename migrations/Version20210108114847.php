<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210108114847 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE order_dish_order');
        $this->addSql('ALTER TABLE order_dish ADD orders_id INT DEFAULT NULL, DROP quantity');
        $this->addSql('ALTER TABLE order_dish ADD CONSTRAINT FK_D88CB6AFCFFE9AD6 FOREIGN KEY (orders_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_D88CB6AFCFFE9AD6 ON order_dish (orders_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_dish_order (order_dish_id INT NOT NULL, order_id INT NOT NULL, INDEX IDX_2CC94C80E2F41980 (order_dish_id), INDEX IDX_2CC94C808D9F6D38 (order_id), PRIMARY KEY(order_dish_id, order_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE order_dish_order ADD CONSTRAINT FK_2CC94C808D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_dish_order ADD CONSTRAINT FK_2CC94C80E2F41980 FOREIGN KEY (order_dish_id) REFERENCES order_dish (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_dish DROP FOREIGN KEY FK_D88CB6AFCFFE9AD6');
        $this->addSql('DROP INDEX IDX_D88CB6AFCFFE9AD6 ON order_dish');
        $this->addSql('ALTER TABLE order_dish ADD quantity INT NOT NULL, DROP orders_id');
    }
}
