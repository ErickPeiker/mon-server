<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20181211182510 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ItemType (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, valueType VARCHAR(255) NOT NULL COMMENT \'(DC2Type:ValueType)\', createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, equipmentTypeId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_7FE4F889FF395CDE (equipmentTypeId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Action (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', type VARCHAR(255) NOT NULL COMMENT \'(DC2Type:ActionType)\', parameters JSON NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, criteriaId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_406089A46FF8162B (criteriaId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IncidentType (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, sequence INT NOT NULL, backgroundColor VARCHAR(255) NOT NULL, textColor VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Person (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE LegalPerson (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, cnpj VARCHAR(255) DEFAULT NULL, ie VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE State (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, abbreviation VARCHAR(255) NOT NULL, countryId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_6252FDFFFBA2A6B4 (countryId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE EquipmentType (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Equipment (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, observation LONGTEXT DEFAULT NULL, ip VARCHAR(255) NOT NULL, parameters JSON DEFAULT NULL, isActive TINYINT(1) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, equipmentTypeId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', companyId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_51C95720FF395CDE (equipmentTypeId), INDEX IDX_51C957202480E723 (companyId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE City (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, stateId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_8D69AD0AB5286BEF (stateId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Expression (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', `function` VARCHAR(255) NOT NULL COMMENT \'(DC2Type:FunctionType)\', parameter VARCHAR(255) DEFAULT NULL, item VARCHAR(255) DEFAULT NULL, logicalComparator VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, sequence INT NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, itemTypeId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', criteriaId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_976D55D13CC766EA (itemTypeId), INDEX IDX_976D55D16FF8162B (criteriaId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ConfigurationGroup (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, sequence INT NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Configuration (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, defaultValue LONGTEXT DEFAULT NULL, sequence INT NOT NULL, type VARCHAR(255) NOT NULL, options LONGTEXT DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, configurationGroupId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_169CEE222D287132 (configurationGroupId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Rule (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, isActive TINYINT(1) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, companyId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_E6EA03F22480E723 (companyId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Criteria (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', templateCriteria VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, ruleId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_4F69F9D7929272AB (ruleId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Phone (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', number VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, personId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_858EB8D9A20C4B1C (personId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `User` (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, apiToken LONGTEXT DEFAULT NULL, roles JSON NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, physicalPersonId CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', companyId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', dashboardId CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', UNIQUE INDEX UNIQ_2DA17977E7927C74 (email), UNIQUE INDEX UNIQ_2DA179773B8A601A (physicalPersonId), INDEX IDX_2DA179772480E723 (companyId), INDEX IDX_2DA17977DBDA9B5E (dashboardId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE UserCompany (userId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', companyId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_9AFF43BA64B64DCC (userId), INDEX IDX_9AFF43BA2480E723 (companyId), PRIMARY KEY(userId, companyId)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE UserGroup (userId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', groupId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_954D5B064B64DCC (userId), INDEX IDX_954D5B0ED8188B0 (groupId), PRIMARY KEY(userId, groupId)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Collector (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ip VARCHAR(255) NOT NULL, port VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, companyId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_4C2A77EF2480E723 (companyId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Country (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Incident (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', description LONGTEXT NOT NULL, incidentType JSON NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, companyId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_C475C34C2480E723 (companyId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Company (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', type VARCHAR(255) NOT NULL COMMENT \'(DC2Type:CompanyType)\', createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, companyId CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', legalPersonId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_800230D32480E723 (companyId), UNIQUE INDEX UNIQ_800230D3E8095659 (legalPersonId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ConfigurationValue (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', value LONGTEXT DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, configurationId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', companyId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_B986C91C4278E2AF (configurationId), INDEX IDX_B986C91C2480E723 (companyId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Menu (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, path VARCHAR(255) DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, sequence INT NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, menuId CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_DD3795ADB6DD3E9C (menuId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Route (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, path VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Widget (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL COMMENT \'(DC2Type:WidgetType)\', parameters JSON DEFAULT NULL, gridPosition JSON NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, dashboardId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_82551BE6DBDA9B5E (dashboardId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Address (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', street VARCHAR(255) NOT NULL, number INT NOT NULL, observation VARCHAR(255) DEFAULT NULL, postcode VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, cityId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', personId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_C2F3561D7F99FC72 (cityId), INDEX IDX_C2F3561DA20C4B1C (personId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE PhysicalPerson (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, cpf VARCHAR(255) DEFAULT NULL, rg VARCHAR(255) DEFAULT NULL, birthdate DATE DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, maritalStatus VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `Group` (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, companyId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_AC016BC12480E723 (companyId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE GroupMenus (groupId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', menuId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_88960F70ED8188B0 (groupId), INDEX IDX_88960F70B6DD3E9C (menuId), PRIMARY KEY(groupId, menuId)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE GroupRoutes (groupId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', routeId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_69F18FA9ED8188B0 (groupId), INDEX IDX_69F18FA9EF2EA341 (routeId), PRIMARY KEY(groupId, routeId)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Dashboard (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, deletedAt DATETIME DEFAULT NULL, userId CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', companyId CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_DE657D5B64B64DCC (userId), INDEX IDX_DE657D5B2480E723 (companyId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ItemType ADD CONSTRAINT FK_7FE4F889FF395CDE FOREIGN KEY (equipmentTypeId) REFERENCES EquipmentType (id)');
        $this->addSql('ALTER TABLE Action ADD CONSTRAINT FK_406089A46FF8162B FOREIGN KEY (criteriaId) REFERENCES Criteria (id)');
        $this->addSql('ALTER TABLE LegalPerson ADD CONSTRAINT FK_6AFCEACABF396750 FOREIGN KEY (id) REFERENCES Person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE State ADD CONSTRAINT FK_6252FDFFFBA2A6B4 FOREIGN KEY (countryId) REFERENCES Country (id)');
        $this->addSql('ALTER TABLE Equipment ADD CONSTRAINT FK_51C95720FF395CDE FOREIGN KEY (equipmentTypeId) REFERENCES EquipmentType (id)');
        $this->addSql('ALTER TABLE Equipment ADD CONSTRAINT FK_51C957202480E723 FOREIGN KEY (companyId) REFERENCES Company (id)');
        $this->addSql('ALTER TABLE City ADD CONSTRAINT FK_8D69AD0AB5286BEF FOREIGN KEY (stateId) REFERENCES State (id)');
        $this->addSql('ALTER TABLE Expression ADD CONSTRAINT FK_976D55D13CC766EA FOREIGN KEY (itemTypeId) REFERENCES ItemType (id)');
        $this->addSql('ALTER TABLE Expression ADD CONSTRAINT FK_976D55D16FF8162B FOREIGN KEY (criteriaId) REFERENCES Criteria (id)');
        $this->addSql('ALTER TABLE Configuration ADD CONSTRAINT FK_169CEE222D287132 FOREIGN KEY (configurationGroupId) REFERENCES ConfigurationGroup (id)');
        $this->addSql('ALTER TABLE Rule ADD CONSTRAINT FK_E6EA03F22480E723 FOREIGN KEY (companyId) REFERENCES Company (id)');
        $this->addSql('ALTER TABLE Criteria ADD CONSTRAINT FK_4F69F9D7929272AB FOREIGN KEY (ruleId) REFERENCES Rule (id)');
        $this->addSql('ALTER TABLE Phone ADD CONSTRAINT FK_858EB8D9A20C4B1C FOREIGN KEY (personId) REFERENCES Person (id)');
        $this->addSql('ALTER TABLE `User` ADD CONSTRAINT FK_2DA179773B8A601A FOREIGN KEY (physicalPersonId) REFERENCES PhysicalPerson (id)');
        $this->addSql('ALTER TABLE `User` ADD CONSTRAINT FK_2DA179772480E723 FOREIGN KEY (companyId) REFERENCES Company (id)');
        $this->addSql('ALTER TABLE `User` ADD CONSTRAINT FK_2DA17977DBDA9B5E FOREIGN KEY (dashboardId) REFERENCES Dashboard (id)');
        $this->addSql('ALTER TABLE UserCompany ADD CONSTRAINT FK_9AFF43BA64B64DCC FOREIGN KEY (userId) REFERENCES `User` (id)');
        $this->addSql('ALTER TABLE UserCompany ADD CONSTRAINT FK_9AFF43BA2480E723 FOREIGN KEY (companyId) REFERENCES Company (id)');
        $this->addSql('ALTER TABLE UserGroup ADD CONSTRAINT FK_954D5B064B64DCC FOREIGN KEY (userId) REFERENCES `User` (id)');
        $this->addSql('ALTER TABLE UserGroup ADD CONSTRAINT FK_954D5B0ED8188B0 FOREIGN KEY (groupId) REFERENCES `Group` (id)');
        $this->addSql('ALTER TABLE Collector ADD CONSTRAINT FK_4C2A77EF2480E723 FOREIGN KEY (companyId) REFERENCES Company (id)');
        $this->addSql('ALTER TABLE Incident ADD CONSTRAINT FK_C475C34C2480E723 FOREIGN KEY (companyId) REFERENCES Company (id)');
        $this->addSql('ALTER TABLE Company ADD CONSTRAINT FK_800230D32480E723 FOREIGN KEY (companyId) REFERENCES Company (id)');
        $this->addSql('ALTER TABLE Company ADD CONSTRAINT FK_800230D3E8095659 FOREIGN KEY (legalPersonId) REFERENCES LegalPerson (id)');
        $this->addSql('ALTER TABLE ConfigurationValue ADD CONSTRAINT FK_B986C91C4278E2AF FOREIGN KEY (configurationId) REFERENCES Configuration (id)');
        $this->addSql('ALTER TABLE ConfigurationValue ADD CONSTRAINT FK_B986C91C2480E723 FOREIGN KEY (companyId) REFERENCES Company (id)');
        $this->addSql('ALTER TABLE Menu ADD CONSTRAINT FK_DD3795ADB6DD3E9C FOREIGN KEY (menuId) REFERENCES Menu (id)');
        $this->addSql('ALTER TABLE Widget ADD CONSTRAINT FK_82551BE6DBDA9B5E FOREIGN KEY (dashboardId) REFERENCES Dashboard (id)');
        $this->addSql('ALTER TABLE Address ADD CONSTRAINT FK_C2F3561D7F99FC72 FOREIGN KEY (cityId) REFERENCES City (id)');
        $this->addSql('ALTER TABLE Address ADD CONSTRAINT FK_C2F3561DA20C4B1C FOREIGN KEY (personId) REFERENCES Person (id)');
        $this->addSql('ALTER TABLE PhysicalPerson ADD CONSTRAINT FK_E69A5572BF396750 FOREIGN KEY (id) REFERENCES Person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `Group` ADD CONSTRAINT FK_AC016BC12480E723 FOREIGN KEY (companyId) REFERENCES Company (id)');
        $this->addSql('ALTER TABLE GroupMenus ADD CONSTRAINT FK_88960F70ED8188B0 FOREIGN KEY (groupId) REFERENCES `Group` (id)');
        $this->addSql('ALTER TABLE GroupMenus ADD CONSTRAINT FK_88960F70B6DD3E9C FOREIGN KEY (menuId) REFERENCES Menu (id)');
        $this->addSql('ALTER TABLE GroupRoutes ADD CONSTRAINT FK_69F18FA9ED8188B0 FOREIGN KEY (groupId) REFERENCES `Group` (id)');
        $this->addSql('ALTER TABLE GroupRoutes ADD CONSTRAINT FK_69F18FA9EF2EA341 FOREIGN KEY (routeId) REFERENCES Route (id)');
        $this->addSql('ALTER TABLE Dashboard ADD CONSTRAINT FK_DE657D5B64B64DCC FOREIGN KEY (userId) REFERENCES `User` (id)');
        $this->addSql('ALTER TABLE Dashboard ADD CONSTRAINT FK_DE657D5B2480E723 FOREIGN KEY (companyId) REFERENCES Company (id)');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Expression DROP FOREIGN KEY FK_976D55D13CC766EA');
        $this->addSql('ALTER TABLE LegalPerson DROP FOREIGN KEY FK_6AFCEACABF396750');
        $this->addSql('ALTER TABLE Phone DROP FOREIGN KEY FK_858EB8D9A20C4B1C');
        $this->addSql('ALTER TABLE Address DROP FOREIGN KEY FK_C2F3561DA20C4B1C');
        $this->addSql('ALTER TABLE PhysicalPerson DROP FOREIGN KEY FK_E69A5572BF396750');
        $this->addSql('ALTER TABLE Company DROP FOREIGN KEY FK_800230D3E8095659');
        $this->addSql('ALTER TABLE City DROP FOREIGN KEY FK_8D69AD0AB5286BEF');
        $this->addSql('ALTER TABLE ItemType DROP FOREIGN KEY FK_7FE4F889FF395CDE');
        $this->addSql('ALTER TABLE Equipment DROP FOREIGN KEY FK_51C95720FF395CDE');
        $this->addSql('ALTER TABLE Address DROP FOREIGN KEY FK_C2F3561D7F99FC72');
        $this->addSql('ALTER TABLE Configuration DROP FOREIGN KEY FK_169CEE222D287132');
        $this->addSql('ALTER TABLE ConfigurationValue DROP FOREIGN KEY FK_B986C91C4278E2AF');
        $this->addSql('ALTER TABLE Criteria DROP FOREIGN KEY FK_4F69F9D7929272AB');
        $this->addSql('ALTER TABLE Action DROP FOREIGN KEY FK_406089A46FF8162B');
        $this->addSql('ALTER TABLE Expression DROP FOREIGN KEY FK_976D55D16FF8162B');
        $this->addSql('ALTER TABLE UserCompany DROP FOREIGN KEY FK_9AFF43BA64B64DCC');
        $this->addSql('ALTER TABLE UserGroup DROP FOREIGN KEY FK_954D5B064B64DCC');
        $this->addSql('ALTER TABLE Dashboard DROP FOREIGN KEY FK_DE657D5B64B64DCC');
        $this->addSql('ALTER TABLE State DROP FOREIGN KEY FK_6252FDFFFBA2A6B4');
        $this->addSql('ALTER TABLE Equipment DROP FOREIGN KEY FK_51C957202480E723');
        $this->addSql('ALTER TABLE Rule DROP FOREIGN KEY FK_E6EA03F22480E723');
        $this->addSql('ALTER TABLE `User` DROP FOREIGN KEY FK_2DA179772480E723');
        $this->addSql('ALTER TABLE UserCompany DROP FOREIGN KEY FK_9AFF43BA2480E723');
        $this->addSql('ALTER TABLE Collector DROP FOREIGN KEY FK_4C2A77EF2480E723');
        $this->addSql('ALTER TABLE Incident DROP FOREIGN KEY FK_C475C34C2480E723');
        $this->addSql('ALTER TABLE Company DROP FOREIGN KEY FK_800230D32480E723');
        $this->addSql('ALTER TABLE ConfigurationValue DROP FOREIGN KEY FK_B986C91C2480E723');
        $this->addSql('ALTER TABLE `Group` DROP FOREIGN KEY FK_AC016BC12480E723');
        $this->addSql('ALTER TABLE Dashboard DROP FOREIGN KEY FK_DE657D5B2480E723');
        $this->addSql('ALTER TABLE Menu DROP FOREIGN KEY FK_DD3795ADB6DD3E9C');
        $this->addSql('ALTER TABLE GroupMenus DROP FOREIGN KEY FK_88960F70B6DD3E9C');
        $this->addSql('ALTER TABLE GroupRoutes DROP FOREIGN KEY FK_69F18FA9EF2EA341');
        $this->addSql('ALTER TABLE `User` DROP FOREIGN KEY FK_2DA179773B8A601A');
        $this->addSql('ALTER TABLE UserGroup DROP FOREIGN KEY FK_954D5B0ED8188B0');
        $this->addSql('ALTER TABLE GroupMenus DROP FOREIGN KEY FK_88960F70ED8188B0');
        $this->addSql('ALTER TABLE GroupRoutes DROP FOREIGN KEY FK_69F18FA9ED8188B0');
        $this->addSql('ALTER TABLE `User` DROP FOREIGN KEY FK_2DA17977DBDA9B5E');
        $this->addSql('ALTER TABLE Widget DROP FOREIGN KEY FK_82551BE6DBDA9B5E');
        $this->addSql('DROP TABLE ItemType');
        $this->addSql('DROP TABLE Action');
        $this->addSql('DROP TABLE IncidentType');
        $this->addSql('DROP TABLE Person');
        $this->addSql('DROP TABLE LegalPerson');
        $this->addSql('DROP TABLE State');
        $this->addSql('DROP TABLE EquipmentType');
        $this->addSql('DROP TABLE Equipment');
        $this->addSql('DROP TABLE City');
        $this->addSql('DROP TABLE Expression');
        $this->addSql('DROP TABLE ConfigurationGroup');
        $this->addSql('DROP TABLE Configuration');
        $this->addSql('DROP TABLE Rule');
        $this->addSql('DROP TABLE Criteria');
        $this->addSql('DROP TABLE Phone');
        $this->addSql('DROP TABLE `User`');
        $this->addSql('DROP TABLE UserCompany');
        $this->addSql('DROP TABLE UserGroup');
        $this->addSql('DROP TABLE Collector');
        $this->addSql('DROP TABLE Country');
        $this->addSql('DROP TABLE Incident');
        $this->addSql('DROP TABLE Company');
        $this->addSql('DROP TABLE ConfigurationValue');
        $this->addSql('DROP TABLE Menu');
        $this->addSql('DROP TABLE Route');
        $this->addSql('DROP TABLE Widget');
        $this->addSql('DROP TABLE Address');
        $this->addSql('DROP TABLE PhysicalPerson');
        $this->addSql('DROP TABLE `Group`');
        $this->addSql('DROP TABLE GroupMenus');
        $this->addSql('DROP TABLE GroupRoutes');
        $this->addSql('DROP TABLE Dashboard');
    }
}
