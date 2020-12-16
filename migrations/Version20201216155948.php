<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201216155948 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE restaurant_dish (restaurant_id INT NOT NULL, dish_id INT NOT NULL, INDEX IDX_576B1CDCB1E7706E (restaurant_id), INDEX IDX_576B1CDC148EB0CB (dish_id), PRIMARY KEY(restaurant_id, dish_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE restaurant_dish ADD CONSTRAINT FK_576B1CDCB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant_dish ADD CONSTRAINT FK_576B1CDC148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F148EB0CB');
        $this->addSql('DROP INDEX IDX_EB95123F148EB0CB ON restaurant');
        $this->addSql('ALTER TABLE restaurant DROP dish_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE restaurant_dish');
        $this->addSql('ALTER TABLE restaurant ADD dish_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id)');
        $this->addSql('CREATE INDEX IDX_EB95123F148EB0CB ON restaurant (dish_id)');
    }
}
