<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221215170756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team CHANGE team_name team_name VARCHAR(40) NOT NULL');
        $this->addSql('ALTER TABLE tournament ADD fzfzf TINYINT(1) DEFAULT NULL, CHANGE reward_choice reward_choice TINYINT(1) DEFAULT NULL, CHANGE limited_inscription limited_inscription TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team CHANGE team_name team_name VARCHAR(64) NOT NULL');
        $this->addSql('ALTER TABLE tournament DROP fzfzf, CHANGE reward_choice reward_choice VARCHAR(10) NOT NULL, CHANGE limited_inscription limited_inscription VARCHAR(10) NOT NULL');
    }
}
