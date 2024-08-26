<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240822093403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added table with depot data.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE depot (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, email_contact VARCHAR(255) DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vehicle ADD depot_id INT NOT NULL');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4868510D4DE FOREIGN KEY (depot_id) REFERENCES depot (id)');
        $this->addSql('CREATE INDEX IDX_1B80E4868510D4DE ON vehicle (depot_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4868510D4DE');
        $this->addSql('DROP TABLE depot');
        $this->addSql('DROP INDEX IDX_1B80E4868510D4DE ON vehicle');
        $this->addSql('ALTER TABLE vehicle DROP depot_id');
    }
}
