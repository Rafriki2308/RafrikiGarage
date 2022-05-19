<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220519075642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car ADD is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE customer ADD is_active TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP is_active, CHANGE reg_plate reg_plate VARCHAR(7) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE chasis_num chasis_num VARCHAR(17) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE brand brand VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE model model VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE engine_type engine_type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE picture_car picture_car VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE customer DROP is_active, CHANGE name name VARCHAR(25) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE surnames surnames VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE id_card id_card VARCHAR(9) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE e_mail e_mail VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE worksheet CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
