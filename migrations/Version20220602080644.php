<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220602080644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD email VARCHAR(60) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car CHANGE reg_plate reg_plate VARCHAR(7) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE chasis_num chasis_num VARCHAR(17) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE brand brand VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE model model VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE engine_type engine_type VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE picture_car picture_car VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE customer CHANGE name name VARCHAR(25) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE surnames surnames VARCHAR(150) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE id_card id_card VARCHAR(9) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE e_mail e_mail VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reset_password_request CHANGE selector selector VARCHAR(20) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE hashed_token hashed_token VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user DROP email, CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE worksheet CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
