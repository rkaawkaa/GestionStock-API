<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230310143030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borrow CHANGE return_comment borrow_return_comment VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE material ADD material_status VARCHAR(255) NOT NULL, ADD material_sub_status VARCHAR(255) NOT NULL, DROP status, DROP sub_status');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borrow CHANGE borrow_return_comment return_comment VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE material ADD status VARCHAR(255) NOT NULL, ADD sub_status VARCHAR(255) NOT NULL, DROP material_status, DROP material_sub_status');
    }
}
