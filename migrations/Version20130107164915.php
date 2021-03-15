<?php
/**
 * @copyright 2012,2013 Binovo it Human Project, S.L.
 * @license http://www.opensource.org/licenses/bsd-license.php New-BSD
 */

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130107164915 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

        $this->addSql("UPDATE Client SET diskUsage = diskUsage / 1024");
        $this->addSql("UPDATE Job    SET diskUsage = diskUsage / 1024");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

        $this->addSql("UPDATE Client SET diskUsage = diskUsage * 1024");
        $this->addSql("UPDATE Job    SET diskUsage = diskUsage * 1024");
    }
}
