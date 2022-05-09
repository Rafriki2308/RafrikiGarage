<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427154628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP id_public_car');
        $this->addSql('ALTER TABLE customer DROP id_public_customer');
        $this->addSql('DROP INDEX UNIQ_23DA50C1EAD54DA0 ON worksheet');
        $this->addSql('ALTER TABLE worksheet ADD is_active TINYINT(1) NOT NULL, DROP worksheet_num');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car ADD id_public_car INT NOT NULL, CHANGE reg_plate reg_plate VARCHAR(7) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE chasis_num chasis_num VARCHAR(17) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE brand brand VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE model model VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE engine_type engine_type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE customer ADD id_public_customer INT NOT NULL, CHANGE name name VARCHAR(25) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE surnames surnames VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE id_card id_card VARCHAR(9) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE e_mail e_mail VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE worksheet ADD worksheet_num INT NOT NULL, DROP is_active, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23DA50C1EAD54DA0 ON worksheet (worksheet_num)');
    }
}
