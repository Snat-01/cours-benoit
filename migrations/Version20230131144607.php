<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131144607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE open_hours (id INT AUTO_INCREMENT NOT NULL, start_hours DATETIME NOT NULL, end_hours DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_open_hours (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, open_hours_id INT NOT NULL, INDEX IDX_66C05B679D86650F (user_id_id), INDEX IDX_66C05B6777CF38C (open_hours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_open_hours ADD CONSTRAINT FK_66C05B679D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_open_hours ADD CONSTRAINT FK_66C05B6777CF38C FOREIGN KEY (open_hours_id) REFERENCES open_hours (id)');
        $this->addSql('ALTER TABLE user ADD address VARCHAR(255) DEFAULT NULL, ADD postal_code VARCHAR(6) DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD firstname VARCHAR(255) DEFAULT NULL, ADD lastname VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_open_hours DROP FOREIGN KEY FK_66C05B679D86650F');
        $this->addSql('ALTER TABLE user_open_hours DROP FOREIGN KEY FK_66C05B6777CF38C');
        $this->addSql('DROP TABLE open_hours');
        $this->addSql('DROP TABLE user_open_hours');
        $this->addSql('ALTER TABLE user DROP address, DROP postal_code, DROP city, DROP firstname, DROP lastname');
    }
}
