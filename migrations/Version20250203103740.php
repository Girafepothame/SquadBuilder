<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250203103740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pilot ADD text LONGTEXT DEFAULT NULL, CHANGE caption caption VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C927110F726');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92B1CF5001');
        $this->addSql('ALTER TABLE pilot DROP FOREIGN KEY FK_8D1E5F527110F726');
        $this->addSql('ALTER TABLE pilot DROP text, CHANGE caption caption VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE dial DROP FOREIGN KEY FK_EAE438727110F726');
        $this->addSql('ALTER TABLE ship DROP FOREIGN KEY FK_FA30EB245D9922E0');
        $this->addSql('ALTER TABLE stat DROP FOREIGN KEY FK_20B8FF217110F726');
        $this->addSql('ALTER TABLE maneuver DROP FOREIGN KEY FK_CA3D70FB61C42470');
    }
}
