<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201221165724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_dish MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX id ON order_dish');
        $this->addSql('ALTER TABLE order_dish DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE order_dish DROP id');
        $this->addSql('ALTER TABLE order_dish ADD PRIMARY KEY (order_id, dish_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_dish ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (order_id, dish_id, id)');
        $this->addSql('CREATE INDEX id ON order_dish (id)');
    }
}
