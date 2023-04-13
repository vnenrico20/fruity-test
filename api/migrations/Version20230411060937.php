<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411060937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fruit (id INT NOT NULL, name VARCHAR(255) NOT NULL, family VARCHAR(255) DEFAULT NULL, `order` VARCHAR(255) DEFAULT NULL, genus VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fruit_nutrition (id INT AUTO_INCREMENT NOT NULL, fruit_id INT NOT NULL, calories INT NOT NULL, fat DOUBLE PRECISION NOT NULL, sugar DOUBLE PRECISION NOT NULL, carbohydrates DOUBLE PRECISION NOT NULL, protein DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_F918F4FBBAC115F0 (fruit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fruit_nutrition ADD CONSTRAINT FK_F918F4FBBAC115F0 FOREIGN KEY (fruit_id) REFERENCES fruit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fruit_nutrition DROP FOREIGN KEY FK_F918F4FBBAC115F0');
        $this->addSql('DROP TABLE fruit');
        $this->addSql('DROP TABLE fruit_nutrition');
    }
}
