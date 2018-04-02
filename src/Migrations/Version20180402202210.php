<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180402202210 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE position (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, item_list_id INT NOT NULL, position INT NOT NULL, INDEX IDX_462CE4F5126F525E (item_id), INDEX IDX_462CE4F536F330DF (item_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F5126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F536F330DF FOREIGN KEY (item_list_id) REFERENCES item_list (id)');
        $this->addSql('DROP TABLE item_list_item');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE item_list_item (item_list_id INT NOT NULL, item_id INT NOT NULL, INDEX IDX_560FEC0736F330DF (item_list_id), INDEX IDX_560FEC07126F525E (item_id), PRIMARY KEY(item_list_id, item_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item_list_item ADD CONSTRAINT FK_560FEC07126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item_list_item ADD CONSTRAINT FK_560FEC0736F330DF FOREIGN KEY (item_list_id) REFERENCES item_list (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE position');
    }
}
