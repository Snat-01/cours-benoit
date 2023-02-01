<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131145130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_open_hours ADD user_has_booked_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_open_hours ADD CONSTRAINT FK_66C05B673127775A FOREIGN KEY (user_has_booked_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_66C05B673127775A ON user_open_hours (user_has_booked_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_open_hours DROP FOREIGN KEY FK_66C05B673127775A');
        $this->addSql('DROP INDEX IDX_66C05B673127775A ON user_open_hours');
        $this->addSql('ALTER TABLE user_open_hours DROP user_has_booked_id');
    }
}
