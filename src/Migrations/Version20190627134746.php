<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190627134746 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE child (id INT AUTO_INCREMENT NOT NULL, child_name VARCHAR(50) NOT NULL, parent_name VARCHAR(50) NOT NULL, parent_email VARCHAR(50) NOT NULL, parent_phone VARCHAR(50) NOT NULL, confirmed TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE child_lesson (child_id INT NOT NULL, lesson_id INT NOT NULL, INDEX IDX_9121B0AFDD62C21B (child_id), INDEX IDX_9121B0AFCDF80196 (lesson_id), PRIMARY KEY(child_id, lesson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hour (id INT AUTO_INCREMENT NOT NULL, start_time TIME NOT NULL, stop_time TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE child_lesson ADD CONSTRAINT FK_9121B0AFDD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE child_lesson ADD CONSTRAINT FK_9121B0AFCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson DROP child_1, DROP child_2, DROP child_3, DROP child_4');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3B5937BF9 FOREIGN KEY (hour_id) REFERENCES hour (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE child_lesson DROP FOREIGN KEY FK_9121B0AFDD62C21B');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3B5937BF9');
        $this->addSql('DROP TABLE child');
        $this->addSql('DROP TABLE child_lesson');
        $this->addSql('DROP TABLE hour');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE lesson ADD child_1 VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD child_2 VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD child_3 VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD child_4 VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
