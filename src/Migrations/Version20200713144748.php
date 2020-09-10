<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200713144748 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE spec (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_spec (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, spec_id INT DEFAULT NULL, value VARCHAR(50) DEFAULT NULL, INDEX IDX_4DE6359F4584665A (product_id), INDEX IDX_4DE6359FAA8FA4FB (spec_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, created_date DATETIME NOT NULL, name VARCHAR(50) NOT NULL, cost INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_spec ADD CONSTRAINT FK_4DE6359F4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_spec ADD CONSTRAINT FK_4DE6359FAA8FA4FB FOREIGN KEY (spec_id) REFERENCES spec (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product_spec DROP FOREIGN KEY FK_4DE6359FAA8FA4FB');
        $this->addSql('ALTER TABLE product_spec DROP FOREIGN KEY FK_4DE6359F4584665A');
        $this->addSql('DROP TABLE spec');
        $this->addSql('DROP TABLE product_spec');
        $this->addSql('DROP TABLE product');
    }
}
