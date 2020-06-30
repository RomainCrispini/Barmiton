<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200625095858 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, user_id INT NOT NULL, comment_created_at DATETIME NOT NULL, comment_text VARCHAR(255) NOT NULL, comment_is_valid TINYINT(1) NOT NULL, INDEX IDX_9474526C59D8A214 (recipe_id), INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE element (id INT AUTO_INCREMENT NOT NULL, recipe_id INT DEFAULT NULL, unit VARCHAR(255) DEFAULT NULL, quantity DOUBLE PRECISION DEFAULT NULL, ingredient VARCHAR(255) NOT NULL, INDEX IDX_41405E3959D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, ingredient_name VARCHAR(100) NOT NULL, ingredient_is_valid TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, recipe_id INT DEFAULT NULL, image VARCHAR(255) NOT NULL, picture_text VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, INDEX IDX_16DB4F8959D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quantity (id INT AUTO_INCREMENT NOT NULL, recipe_id INT DEFAULT NULL, ingredient_id INT DEFAULT NULL, unit_id INT DEFAULT NULL, quantity DOUBLE PRECISION NOT NULL, INDEX IDX_9FF3163659D8A214 (recipe_id), INDEX IDX_9FF31636933FE08C (ingredient_id), INDEX IDX_9FF31636F8BD700D (unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rate (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, recipe_id INT NOT NULL, rate DOUBLE PRECISION NOT NULL, INDEX IDX_DFEC3F39A76ED395 (user_id), INDEX IDX_DFEC3F3959D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, recipe_name VARCHAR(100) NOT NULL, person_num INT NOT NULL, recipe_is_valid TINYINT(1) NOT NULL, recipe_created_at DATETIME NOT NULL, recipe_rate DOUBLE PRECISION DEFAULT NULL, INDEX IDX_DA88B137A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_category (recipe_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_70DCBC5F59D8A214 (recipe_id), INDEX IDX_70DCBC5F12469DE2 (category_id), PRIMARY KEY(recipe_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE step (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, step_num INT NOT NULL, step_text VARCHAR(255) NOT NULL, INDEX IDX_43B9FE3C59D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, unit VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, role LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE element ADD CONSTRAINT FK_41405E3959D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8959D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE quantity ADD CONSTRAINT FK_9FF3163659D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE quantity ADD CONSTRAINT FK_9FF31636933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE quantity ADD CONSTRAINT FK_9FF31636F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT FK_DFEC3F39A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT FK_DFEC3F3959D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recipe_category ADD CONSTRAINT FK_70DCBC5F59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_category ADD CONSTRAINT FK_70DCBC5F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe_category DROP FOREIGN KEY FK_70DCBC5F12469DE2');
        $this->addSql('ALTER TABLE quantity DROP FOREIGN KEY FK_9FF31636933FE08C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C59D8A214');
        $this->addSql('ALTER TABLE element DROP FOREIGN KEY FK_41405E3959D8A214');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8959D8A214');
        $this->addSql('ALTER TABLE quantity DROP FOREIGN KEY FK_9FF3163659D8A214');
        $this->addSql('ALTER TABLE rate DROP FOREIGN KEY FK_DFEC3F3959D8A214');
        $this->addSql('ALTER TABLE recipe_category DROP FOREIGN KEY FK_70DCBC5F59D8A214');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C59D8A214');
        $this->addSql('ALTER TABLE quantity DROP FOREIGN KEY FK_9FF31636F8BD700D');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE rate DROP FOREIGN KEY FK_DFEC3F39A76ED395');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137A76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE element');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE quantity');
        $this->addSql('DROP TABLE rate');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE recipe_category');
        $this->addSql('DROP TABLE step');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE user');
    }
}
