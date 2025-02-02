<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250202151428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX IDX_47CC8C927110F726 ON action (id_ship)');
        $this->addSql('CREATE INDEX IDX_47CC8C92B1CF5001 ON action (id_linked)');
        $this->addSql('ALTER TABLE dial CHANGE id_ship id_ship INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_EAE438727110F726 ON dial (id_ship)');
        $this->addSql('ALTER TABLE maneuver CHANGE id_dial id_dial INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_CA3D70FB61C42470 ON maneuver (id_dial)');
        $this->addSql('ALTER TABLE pilot CHANGE id_ship id_ship INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_8D1E5F527110F726 ON pilot (id_ship)');
        $this->addSql('ALTER TABLE ship CHANGE id_faction id_faction INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_FA30EB245D9922E0 ON ship (id_faction)');
        $this->addSql('CREATE INDEX IDX_20B8FF217110F726 ON stat (id_ship)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C927110F726');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92B1CF5001');
        $this->addSql('DROP INDEX IDX_47CC8C927110F726 ON action');
        $this->addSql('DROP INDEX IDX_47CC8C92B1CF5001 ON action');
        $this->addSql('ALTER TABLE pilot DROP FOREIGN KEY FK_8D1E5F527110F726');
        $this->addSql('DROP INDEX IDX_8D1E5F527110F726 ON pilot');
        $this->addSql('ALTER TABLE pilot CHANGE id_ship id_ship INT NOT NULL');
        $this->addSql('ALTER TABLE dial DROP FOREIGN KEY FK_EAE438727110F726');
        $this->addSql('DROP INDEX IDX_EAE438727110F726 ON dial');
        $this->addSql('ALTER TABLE dial CHANGE id_ship id_ship INT NOT NULL');
        $this->addSql('ALTER TABLE ship DROP FOREIGN KEY FK_FA30EB245D9922E0');
        $this->addSql('DROP INDEX IDX_FA30EB245D9922E0 ON ship');
        $this->addSql('ALTER TABLE ship CHANGE id_faction id_faction INT NOT NULL');
        $this->addSql('ALTER TABLE stat DROP FOREIGN KEY FK_20B8FF217110F726');
        $this->addSql('DROP INDEX IDX_20B8FF217110F726 ON stat');
        $this->addSql('ALTER TABLE maneuver DROP FOREIGN KEY FK_CA3D70FB61C42470');
        $this->addSql('DROP INDEX IDX_CA3D70FB61C42470 ON maneuver');
        $this->addSql('ALTER TABLE maneuver CHANGE id_dial id_dial INT NOT NULL');
    }
}
