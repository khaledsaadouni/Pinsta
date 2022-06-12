<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220605165026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, author_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_9474526C4B89032C (post_id), INDEX IDX_9474526CF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, relation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussion_user (discussion_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A8FD7A7F1ADED311 (discussion_id), INDEX IDX_A8FD7A7FA76ED395 (user_id), PRIMARY KEY(discussion_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE in_box (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_DCBDB8C1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE in_box_discussion (in_box_id INT NOT NULL, discussion_id INT NOT NULL, INDEX IDX_B66D75936FE0D21A (in_box_id), INDEX IDX_B66D75931ADED311 (discussion_id), PRIMARY KEY(in_box_id, discussion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, discussion_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_B6BD307F1ADED311 (discussion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_user (message_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_24064D90537A1329 (message_id), INDEX IDX_24064D90A76ED395 (user_id), PRIMARY KEY(message_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, category_id INT DEFAULT NULL, title VARCHAR(50) NOT NULL, description VARCHAR(50) DEFAULT NULL, likes INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_5A8A6C8DF675F31B (author_id), INDEX IDX_5A8A6C8D12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, birthday DATE NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE discussion_user ADD CONSTRAINT FK_A8FD7A7F1ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discussion_user ADD CONSTRAINT FK_A8FD7A7FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE in_box ADD CONSTRAINT FK_DCBDB8C1A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE in_box_discussion ADD CONSTRAINT FK_B66D75936FE0D21A FOREIGN KEY (in_box_id) REFERENCES in_box (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE in_box_discussion ADD CONSTRAINT FK_B66D75931ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id)');
        $this->addSql('ALTER TABLE message_user ADD CONSTRAINT FK_24064D90537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message_user ADD CONSTRAINT FK_24064D90A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D12469DE2');
        $this->addSql('ALTER TABLE discussion_user DROP FOREIGN KEY FK_A8FD7A7F1ADED311');
        $this->addSql('ALTER TABLE in_box_discussion DROP FOREIGN KEY FK_B66D75931ADED311');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1ADED311');
        $this->addSql('ALTER TABLE in_box_discussion DROP FOREIGN KEY FK_B66D75936FE0D21A');
        $this->addSql('ALTER TABLE message_user DROP FOREIGN KEY FK_24064D90537A1329');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4B89032C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE discussion_user DROP FOREIGN KEY FK_A8FD7A7FA76ED395');
        $this->addSql('ALTER TABLE in_box DROP FOREIGN KEY FK_DCBDB8C1A76ED395');
        $this->addSql('ALTER TABLE message_user DROP FOREIGN KEY FK_24064D90A76ED395');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DF675F31B');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE discussion_user');
        $this->addSql('DROP TABLE in_box');
        $this->addSql('DROP TABLE in_box_discussion');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_user');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
