<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180414085738 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item_list ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE item_list ADD CONSTRAINT FK_8CF8BCE37E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8CF8BCE37E3C61F9 ON item_list (owner_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item_list DROP FOREIGN KEY FK_8CF8BCE37E3C61F9');
        $this->addSql('DROP INDEX IDX_8CF8BCE37E3C61F9 ON item_list');
        $this->addSql('ALTER TABLE item_list DROP owner_id');
    }
}
