<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221212093656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE topic ADD content LONGTEXT DEFAULT NULL, CHANGE topic_name topic_name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE user ADD twitch_id VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE topic DROP content, CHANGE topic_name topic_name VARCHAR(60) NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP twitch_id');
    }
}
