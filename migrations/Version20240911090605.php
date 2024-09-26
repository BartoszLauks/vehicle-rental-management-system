<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240911090605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add table to booking and pay system.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, vehicle_id INT NOT NULL, discount_id INT DEFAULT NULL, promotion_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', start_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivery_time DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', total_km INT DEFAULT NULL, base_cost NUMERIC(10, 2) NOT NULL, additional_km_cost NUMERIC(10, 2) DEFAULT NULL, discount_amount NUMERIC(10, 2) DEFAULT NULL, promotion_amount NUMERIC(10, 2) NOT NULL, INDEX IDX_E00CEDDEA76ED395 (user_id), INDEX IDX_E00CEDDE545317D1 (vehicle_id), INDEX IDX_E00CEDDE4C7C611F (discount_id), INDEX IDX_E00CEDDE139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_status (id INT AUTO_INCREMENT NOT NULL, booking_id INT NOT NULL, status VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C09A5EE23301C60 (booking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discounts (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, value INT NOT NULL, minimum_days INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payments (id INT AUTO_INCREMENT NOT NULL, booking_id INT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', id_session VARCHAR(255) NOT NULL, url LONGTEXT NOT NULL, session_created_timestamp INT NOT NULL, session_expires_at_timestamp INT NOT NULL, currency VARCHAR(3) NOT NULL, amount_total INT NOT NULL, metadata JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_65D29B323301C60 (booking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotions (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, value INT NOT NULL, valid_from DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', valid_to DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE4C7C611F FOREIGN KEY (discount_id) REFERENCES discounts (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE139DF194 FOREIGN KEY (promotion_id) REFERENCES promotions (id)');
        $this->addSql('ALTER TABLE booking_status ADD CONSTRAINT FK_C09A5EE23301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('ALTER TABLE payments ADD CONSTRAINT FK_65D29B323301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('ALTER TABLE vehicle ADD daily_price NUMERIC(10, 2) NOT NULL, ADD mileage_limit_per_day INT NOT NULL, ADD additional_km_cost NUMERIC(10, 2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE545317D1');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE4C7C611F');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE139DF194');
        $this->addSql('ALTER TABLE booking_status DROP FOREIGN KEY FK_C09A5EE23301C60');
        $this->addSql('ALTER TABLE payments DROP FOREIGN KEY FK_65D29B323301C60');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_status');
        $this->addSql('DROP TABLE discounts');
        $this->addSql('DROP TABLE payments');
        $this->addSql('DROP TABLE promotions');
        $this->addSql('ALTER TABLE vehicle DROP daily_price, DROP mileage_limit_per_day, DROP additional_km_cost');
    }
}
