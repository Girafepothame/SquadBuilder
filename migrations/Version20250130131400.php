<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250130131400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP INDEX id_ship ON action');
        $this->addSql('DROP INDEX id_linked ON action');
        $this->addSql('ALTER TABLE action ADD id INT AUTO_INCREMENT NOT NULL, DROP id_action, CHANGE difficulty difficulty VARCHAR(255) NOT NULL, CHANGE type type VARCHAR(255) NOT NULL, CHANGE id_ship id_ship INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX id_side ON bonus');
        $this->addSql('ALTER TABLE bonus ADD id INT AUTO_INCREMENT NOT NULL, DROP id_bonus, CHANGE type type VARCHAR(255) NOT NULL, CHANGE value value VARCHAR(255) NOT NULL, CHANGE id_side id_side INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX id_pilot ON charge');
        $this->addSql('ALTER TABLE charge ADD id INT AUTO_INCREMENT NOT NULL, DROP id_charge, CHANGE recovers recovers INT NOT NULL, CHANGE id_pilot id_pilot INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX id_ship ON dial');
        $this->addSql('ALTER TABLE dial ADD id INT AUTO_INCREMENT NOT NULL, ADD dial_codes VARCHAR(255) NOT NULL, DROP id_dial, DROP dialCodes, CHANGE id_ship id_ship INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE faction ADD id INT AUTO_INCREMENT NOT NULL, DROP id_faction, CHANGE name name VARCHAR(255) NOT NULL, CHANGE xws xws VARCHAR(255) NOT NULL, CHANGE icon icon VARCHAR(255) NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX id_pilot ON `force`');
        $this->addSql('ALTER TABLE `force` ADD id INT AUTO_INCREMENT NOT NULL, DROP id_force, CHANGE value value INT NOT NULL, CHANGE side side VARCHAR(255) NOT NULL, CHANGE id_pilot id_pilot INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX id_pilot ON loadout');
        $this->addSql('ALTER TABLE loadout ADD id INT AUTO_INCREMENT NOT NULL, DROP id_loadout, CHANGE max max INT NOT NULL, CHANGE total total INT NOT NULL, CHANGE id_pilot id_pilot INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX id_dial ON maneuver');
        $this->addSql('ALTER TABLE maneuver ADD id INT AUTO_INCREMENT NOT NULL, DROP id_maneuver, CHANGE code code VARCHAR(255) NOT NULL, CHANGE id_dial id_dial INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX id_ship ON pilot');
        $this->addSql('ALTER TABLE pilot ADD id INT AUTO_INCREMENT NOT NULL, ADD ship_ability LONGTEXT DEFAULT NULL, DROP id_pilot, DROP shipAbility, CHANGE xws xws VARCHAR(255) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE caption caption VARCHAR(255) NOT NULL, CHANGE initiative initiative INT NOT NULL, CHANGE limited limited INT NOT NULL, CHANGE cost cost INT NOT NULL, CHANGE loadout loadout INT NOT NULL, CHANGE ability ability LONGTEXT DEFAULT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE artwork artwork VARCHAR(255) NOT NULL, CHANGE keywords keywords VARCHAR(255) NOT NULL, CHANGE slots slots VARCHAR(255) NOT NULL, CHANGE id_ship id_ship INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX id_upgrade ON restriction');
        $this->addSql('ALTER TABLE restriction ADD id INT AUTO_INCREMENT NOT NULL, DROP id_restriction, CHANGE type type VARCHAR(255) NOT NULL, CHANGE value value VARCHAR(255) NOT NULL, CHANGE id_upgrade id_upgrade INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX id_faction ON ship');
        $this->addSql('ALTER TABLE ship ADD id INT AUTO_INCREMENT NOT NULL, DROP id_ship, CHANGE name name VARCHAR(255) NOT NULL, CHANGE xws xws VARCHAR(255) NOT NULL, CHANGE size size VARCHAR(255) NOT NULL, CHANGE icon icon VARCHAR(255) NOT NULL, CHANGE id_faction id_faction INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX id_upgrade ON side');
        $this->addSql('ALTER TABLE side ADD id INT AUTO_INCREMENT NOT NULL, DROP id_side, CHANGE title title VARCHAR(255) NOT NULL, CHANGE ability ability LONGTEXT NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE artwork artwork VARCHAR(255) NOT NULL, CHANGE slots slots VARCHAR(255) NOT NULL, CHANGE id_upgrade id_upgrade INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX id_ship ON stat');
        $this->addSql('ALTER TABLE stat ADD id INT AUTO_INCREMENT NOT NULL, DROP id_stat, CHANGE type type VARCHAR(255) NOT NULL, CHANGE value value VARCHAR(255) NOT NULL, CHANGE id_ship id_ship INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE upgrade ADD id INT AUTO_INCREMENT NOT NULL, DROP id_upgrade, CHANGE xws xws VARCHAR(255) NOT NULL, CHANGE type type VARCHAR(255) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE limited limited INT NOT NULL, CHANGE cost cost INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX id_loadout ON upgrade_loadout');
        $this->addSql('ALTER TABLE upgrade_loadout ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE charge MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON charge');
        $this->addSql('ALTER TABLE charge ADD id_charge INT NOT NULL, DROP id, CHANGE recovers recovers INT DEFAULT NULL, CHANGE id_pilot id_pilot INT DEFAULT NULL');
        $this->addSql('CREATE INDEX id_pilot ON charge (id_pilot)');
        $this->addSql('ALTER TABLE charge ADD PRIMARY KEY (id_charge)');
        $this->addSql('ALTER TABLE action MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON action');
        $this->addSql('ALTER TABLE action ADD id_action INT NOT NULL, DROP id, CHANGE difficulty difficulty VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE id_ship id_ship INT DEFAULT NULL');
        $this->addSql('CREATE INDEX id_ship ON action (id_ship)');
        $this->addSql('CREATE INDEX id_linked ON action (id_linked)');
        $this->addSql('ALTER TABLE action ADD PRIMARY KEY (id_action)');
        $this->addSql('ALTER TABLE loadout MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON loadout');
        $this->addSql('ALTER TABLE loadout ADD id_loadout INT NOT NULL, DROP id, CHANGE max max INT DEFAULT NULL, CHANGE total total INT DEFAULT NULL, CHANGE id_pilot id_pilot INT DEFAULT NULL');
        $this->addSql('CREATE INDEX id_pilot ON loadout (id_pilot)');
        $this->addSql('ALTER TABLE loadout ADD PRIMARY KEY (id_loadout)');
        $this->addSql('ALTER TABLE upgrade MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON upgrade');
        $this->addSql('ALTER TABLE upgrade ADD id_upgrade INT NOT NULL, DROP id, CHANGE xws xws VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE limited limited INT DEFAULT NULL, CHANGE cost cost INT DEFAULT NULL');
        $this->addSql('ALTER TABLE upgrade ADD PRIMARY KEY (id_upgrade)');
        $this->addSql('ALTER TABLE faction MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON faction');
        $this->addSql('ALTER TABLE faction ADD id_faction INT NOT NULL, DROP id, CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE xws xws VARCHAR(255) DEFAULT NULL, CHANGE icon icon VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE faction ADD PRIMARY KEY (id_faction)');
        $this->addSql('ALTER TABLE bonus MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON bonus');
        $this->addSql('ALTER TABLE bonus ADD id_bonus INT NOT NULL, DROP id, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE value value VARCHAR(255) DEFAULT NULL, CHANGE id_side id_side INT DEFAULT NULL');
        $this->addSql('CREATE INDEX id_side ON bonus (id_side)');
        $this->addSql('ALTER TABLE bonus ADD PRIMARY KEY (id_bonus)');
        $this->addSql('ALTER TABLE stat MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON stat');
        $this->addSql('ALTER TABLE stat ADD id_stat INT NOT NULL, DROP id, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE value value VARCHAR(255) DEFAULT NULL, CHANGE id_ship id_ship INT DEFAULT NULL');
        $this->addSql('CREATE INDEX id_ship ON stat (id_ship)');
        $this->addSql('ALTER TABLE stat ADD PRIMARY KEY (id_stat)');
        $this->addSql('ALTER TABLE side MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON side');
        $this->addSql('ALTER TABLE side ADD id_side INT NOT NULL, DROP id, CHANGE title title VARCHAR(255) DEFAULT NULL, CHANGE ability ability TEXT DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE artwork artwork VARCHAR(255) DEFAULT NULL, CHANGE slots slots VARCHAR(255) DEFAULT NULL, CHANGE id_upgrade id_upgrade INT DEFAULT NULL');
        $this->addSql('CREATE INDEX id_upgrade ON side (id_upgrade)');
        $this->addSql('ALTER TABLE side ADD PRIMARY KEY (id_side)');
        $this->addSql('ALTER TABLE `force` MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON `force`');
        $this->addSql('ALTER TABLE `force` ADD id_force INT NOT NULL, DROP id, CHANGE value value INT DEFAULT NULL, CHANGE side side VARCHAR(255) DEFAULT NULL, CHANGE id_pilot id_pilot INT DEFAULT NULL');
        $this->addSql('CREATE INDEX id_pilot ON `force` (id_pilot)');
        $this->addSql('ALTER TABLE `force` ADD PRIMARY KEY (id_force)');
        $this->addSql('ALTER TABLE upgrade_loadout MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON upgrade_loadout');
        $this->addSql('ALTER TABLE upgrade_loadout DROP id');
        $this->addSql('CREATE INDEX id_loadout ON upgrade_loadout (id_loadout)');
        $this->addSql('ALTER TABLE upgrade_loadout ADD PRIMARY KEY (id_upgrade, id_loadout)');
        $this->addSql('ALTER TABLE pilot MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON pilot');
        $this->addSql('ALTER TABLE pilot ADD id_pilot INT NOT NULL, ADD shipAbility TEXT DEFAULT NULL, DROP id, DROP ship_ability, CHANGE xws xws VARCHAR(255) DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE caption caption VARCHAR(255) DEFAULT NULL, CHANGE initiative initiative INT DEFAULT NULL, CHANGE limited limited INT DEFAULT NULL, CHANGE cost cost INT DEFAULT NULL, CHANGE loadout loadout INT DEFAULT NULL, CHANGE ability ability TEXT DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE artwork artwork VARCHAR(255) DEFAULT NULL, CHANGE keywords keywords VARCHAR(255) DEFAULT NULL, CHANGE slots slots VARCHAR(255) DEFAULT NULL, CHANGE id_ship id_ship INT DEFAULT NULL');
        $this->addSql('CREATE INDEX id_ship ON pilot (id_ship)');
        $this->addSql('ALTER TABLE pilot ADD PRIMARY KEY (id_pilot)');
        $this->addSql('ALTER TABLE ship MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON ship');
        $this->addSql('ALTER TABLE ship ADD id_ship INT NOT NULL, DROP id, CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE xws xws VARCHAR(255) DEFAULT NULL, CHANGE size size VARCHAR(255) DEFAULT NULL, CHANGE icon icon VARCHAR(255) DEFAULT NULL, CHANGE id_faction id_faction INT DEFAULT NULL');
        $this->addSql('CREATE INDEX id_faction ON ship (id_faction)');
        $this->addSql('ALTER TABLE ship ADD PRIMARY KEY (id_ship)');
        $this->addSql('ALTER TABLE maneuver MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON maneuver');
        $this->addSql('ALTER TABLE maneuver ADD id_maneuver INT NOT NULL, DROP id, CHANGE code code VARCHAR(255) DEFAULT NULL, CHANGE id_dial id_dial INT DEFAULT NULL');
        $this->addSql('CREATE INDEX id_dial ON maneuver (id_dial)');
        $this->addSql('ALTER TABLE maneuver ADD PRIMARY KEY (id_maneuver)');
        $this->addSql('ALTER TABLE restriction MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON restriction');
        $this->addSql('ALTER TABLE restriction ADD id_restriction INT NOT NULL, DROP id, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE value value VARCHAR(255) DEFAULT NULL, CHANGE id_upgrade id_upgrade INT DEFAULT NULL');
        $this->addSql('CREATE INDEX id_upgrade ON restriction (id_upgrade)');
        $this->addSql('ALTER TABLE restriction ADD PRIMARY KEY (id_restriction)');
        $this->addSql('ALTER TABLE dial MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON dial');
        $this->addSql('ALTER TABLE dial ADD id_dial INT NOT NULL, ADD dialCodes VARCHAR(255) DEFAULT NULL, DROP id, DROP dial_codes, CHANGE id_ship id_ship INT DEFAULT NULL');
        $this->addSql('CREATE INDEX id_ship ON dial (id_ship)');
        $this->addSql('ALTER TABLE dial ADD PRIMARY KEY (id_dial)');
    }
}
