<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230123144116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE categories ADD user_id INT NOT NULL');
       // $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_3AF34668A76ED395 ON categories (user_id)');
        $this->addSql('ALTER TABLE items ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_E11EE94DA76ED395 ON items (user_id)');
        $this->addSql('ALTER TABLE sub_categories ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE sub_categories ADD CONSTRAINT FK_1638D5A5A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_1638D5A5A76ED395 ON sub_categories (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668A76ED395');
        $this->addSql('DROP INDEX IDX_3AF34668A76ED395 ON categories');
        $this->addSql('ALTER TABLE categories DROP user_id');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DA76ED395');
        $this->addSql('DROP INDEX IDX_E11EE94DA76ED395 ON items');
        $this->addSql('ALTER TABLE items DROP user_id');
        $this->addSql('ALTER TABLE sub_categories DROP FOREIGN KEY FK_1638D5A5A76ED395');
        $this->addSql('DROP INDEX IDX_1638D5A5A76ED395 ON sub_categories');
        $this->addSql('ALTER TABLE sub_categories DROP user_id');
    }
}
