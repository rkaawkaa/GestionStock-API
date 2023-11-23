<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230228152957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE borrow (borrow_id INT AUTO_INCREMENT NOT NULL, borrower_id INT NOT NULL, material_id INT NOT NULL, borrow_accessories LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', borrow_active TINYINT(1) NOT NULL, borrow_period_start DATE NOT NULL, borrow_period_end DATE NOT NULL, INDEX IDX_55DBA8B011CE312B (borrower_id), INDEX IDX_55DBA8B0E308AC6F (material_id), PRIMARY KEY(borrow_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE borrower (borrower_id INT AUTO_INCREMENT NOT NULL, borrower_first_name VARCHAR(255) NOT NULL, borrower_last_name VARCHAR(255) NOT NULL, borrower_group VARCHAR(255) NOT NULL, PRIMARY KEY(borrower_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE material (material_id INT AUTO_INCREMENT NOT NULL, material_name VARCHAR(255) NOT NULL, material_state VARCHAR(255) DEFAULT NULL, material_details VARCHAR(255) NOT NULL, PRIMARY KEY(material_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B011CE312B FOREIGN KEY (borrower_id) REFERENCES borrower (borrower_id)');
        $this->addSql('ALTER TABLE borrow ADD CONSTRAINT FK_55DBA8B0E308AC6F FOREIGN KEY (material_id) REFERENCES material (material_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY FK_55DBA8B011CE312B');
        $this->addSql('ALTER TABLE borrow DROP FOREIGN KEY FK_55DBA8B0E308AC6F');
        $this->addSql('DROP TABLE borrow');
        $this->addSql('DROP TABLE borrower');
        $this->addSql('DROP TABLE material');
    }
}
