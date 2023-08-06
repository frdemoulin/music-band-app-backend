<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230805161520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, album_sort_id INT NOT NULL, title VARCHAR(255) NOT NULL, released_year INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_39986E4312D66D13 (album_sort_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album_sort (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE backing_track (id INT AUTO_INCREMENT NOT NULL, backing_track_sort_id INT NOT NULL, cover_id INT DEFAULT NULL, block_id INT DEFAULT NULL, filename VARCHAR(255) NOT NULL, duration INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A4B444CA6C97B3DC (backing_track_sort_id), INDEX IDX_A4B444CA922726E9 (cover_id), INDEX IDX_A4B444CAE9ED820C (block_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE backing_track_sort (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, roles JSON NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE block (id INT AUTO_INCREMENT NOT NULL, ending_id INT DEFAULT NULL, duration INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_831B97227C6D4E1C (ending_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE block_has_covers (id INT AUTO_INCREMENT NOT NULL, block_id INT NOT NULL, cover_id INT NOT NULL, cover_rank_in_block INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B142ED42E9ED820C (block_id), INDEX IDX_B142ED42922726E9 (cover_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cover (id INT AUTO_INCREMENT NOT NULL, song_id INT NOT NULL, intro_id INT DEFAULT NULL, outro_id INT DEFAULT NULL, ending_id INT DEFAULT NULL, duration INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_8D0886C5A0BDB2F3 (song_id), INDEX IDX_8D0886C598EB544E (intro_id), INDEX IDX_8D0886C53B5D95FD (outro_id), UNIQUE INDEX UNIQ_8D0886C57C6D4E1C (ending_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ending (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, filename VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intermission (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, duration INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intro_outro (id INT AUTO_INCREMENT NOT NULL, artist_name VARCHAR(255) DEFAULT NULL, song_title VARCHAR(255) NOT NULL, duration INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE log_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, session_id VARCHAR(255) NOT NULL, login_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', logout_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_9CFD383CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setlist (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, last_modified_by_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_710BEA2AB03A8386 (created_by_id), INDEX IDX_710BEA2AF703974A (last_modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setlist_entry (id INT AUTO_INCREMENT NOT NULL, setlist_id INT NOT NULL, block_id INT DEFAULT NULL, cover_id INT DEFAULT NULL, speech_id INT DEFAULT NULL, intermission_id INT DEFAULT NULL, sort_id INT DEFAULT NULL, rank_in_setlist INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E7780DA460D8C499 (setlist_id), INDEX IDX_E7780DA4E9ED820C (block_id), INDEX IDX_E7780DA4922726E9 (cover_id), INDEX IDX_E7780DA4BBC049D6 (speech_id), INDEX IDX_E7780DA495CDAB1C (intermission_id), INDEX IDX_E7780DA447013001 (sort_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setlist_entry_sort (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE song (id INT AUTO_INCREMENT NOT NULL, tuning_id INT DEFAULT NULL, album_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, duration INT NOT NULL, short_title VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_33EDEEA142776A1D (tuning_id), INDEX IDX_33EDEEA11137ABCF (album_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speech (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, duration INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tuning (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, nickname VARCHAR(255) DEFAULT NULL, session_id VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E4312D66D13 FOREIGN KEY (album_sort_id) REFERENCES album_sort (id)');
        $this->addSql('ALTER TABLE backing_track ADD CONSTRAINT FK_A4B444CA6C97B3DC FOREIGN KEY (backing_track_sort_id) REFERENCES backing_track_sort (id)');
        $this->addSql('ALTER TABLE backing_track ADD CONSTRAINT FK_A4B444CA922726E9 FOREIGN KEY (cover_id) REFERENCES cover (id)');
        $this->addSql('ALTER TABLE backing_track ADD CONSTRAINT FK_A4B444CAE9ED820C FOREIGN KEY (block_id) REFERENCES block (id)');
        $this->addSql('ALTER TABLE block ADD CONSTRAINT FK_831B97227C6D4E1C FOREIGN KEY (ending_id) REFERENCES ending (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE block_has_covers ADD CONSTRAINT FK_B142ED42E9ED820C FOREIGN KEY (block_id) REFERENCES block (id)');
        $this->addSql('ALTER TABLE block_has_covers ADD CONSTRAINT FK_B142ED42922726E9 FOREIGN KEY (cover_id) REFERENCES cover (id)');
        $this->addSql('ALTER TABLE cover ADD CONSTRAINT FK_8D0886C5A0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id)');
        $this->addSql('ALTER TABLE cover ADD CONSTRAINT FK_8D0886C598EB544E FOREIGN KEY (intro_id) REFERENCES intro_outro (id)');
        $this->addSql('ALTER TABLE cover ADD CONSTRAINT FK_8D0886C53B5D95FD FOREIGN KEY (outro_id) REFERENCES intro_outro (id)');
        $this->addSql('ALTER TABLE cover ADD CONSTRAINT FK_8D0886C57C6D4E1C FOREIGN KEY (ending_id) REFERENCES ending (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE log_user ADD CONSTRAINT FK_9CFD383CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE setlist ADD CONSTRAINT FK_710BEA2AB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE setlist ADD CONSTRAINT FK_710BEA2AF703974A FOREIGN KEY (last_modified_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE setlist_entry ADD CONSTRAINT FK_E7780DA460D8C499 FOREIGN KEY (setlist_id) REFERENCES setlist (id)');
        $this->addSql('ALTER TABLE setlist_entry ADD CONSTRAINT FK_E7780DA4E9ED820C FOREIGN KEY (block_id) REFERENCES block (id)');
        $this->addSql('ALTER TABLE setlist_entry ADD CONSTRAINT FK_E7780DA4922726E9 FOREIGN KEY (cover_id) REFERENCES cover (id)');
        $this->addSql('ALTER TABLE setlist_entry ADD CONSTRAINT FK_E7780DA4BBC049D6 FOREIGN KEY (speech_id) REFERENCES speech (id)');
        $this->addSql('ALTER TABLE setlist_entry ADD CONSTRAINT FK_E7780DA495CDAB1C FOREIGN KEY (intermission_id) REFERENCES intermission (id)');
        $this->addSql('ALTER TABLE setlist_entry ADD CONSTRAINT FK_E7780DA447013001 FOREIGN KEY (sort_id) REFERENCES setlist_entry_sort (id)');
        $this->addSql('ALTER TABLE song ADD CONSTRAINT FK_33EDEEA142776A1D FOREIGN KEY (tuning_id) REFERENCES tuning (id)');
        $this->addSql('ALTER TABLE song ADD CONSTRAINT FK_33EDEEA11137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E4312D66D13');
        $this->addSql('ALTER TABLE backing_track DROP FOREIGN KEY FK_A4B444CA6C97B3DC');
        $this->addSql('ALTER TABLE backing_track DROP FOREIGN KEY FK_A4B444CA922726E9');
        $this->addSql('ALTER TABLE backing_track DROP FOREIGN KEY FK_A4B444CAE9ED820C');
        $this->addSql('ALTER TABLE block DROP FOREIGN KEY FK_831B97227C6D4E1C');
        $this->addSql('ALTER TABLE block_has_covers DROP FOREIGN KEY FK_B142ED42E9ED820C');
        $this->addSql('ALTER TABLE block_has_covers DROP FOREIGN KEY FK_B142ED42922726E9');
        $this->addSql('ALTER TABLE cover DROP FOREIGN KEY FK_8D0886C5A0BDB2F3');
        $this->addSql('ALTER TABLE cover DROP FOREIGN KEY FK_8D0886C598EB544E');
        $this->addSql('ALTER TABLE cover DROP FOREIGN KEY FK_8D0886C53B5D95FD');
        $this->addSql('ALTER TABLE cover DROP FOREIGN KEY FK_8D0886C57C6D4E1C');
        $this->addSql('ALTER TABLE log_user DROP FOREIGN KEY FK_9CFD383CA76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE setlist DROP FOREIGN KEY FK_710BEA2AB03A8386');
        $this->addSql('ALTER TABLE setlist DROP FOREIGN KEY FK_710BEA2AF703974A');
        $this->addSql('ALTER TABLE setlist_entry DROP FOREIGN KEY FK_E7780DA460D8C499');
        $this->addSql('ALTER TABLE setlist_entry DROP FOREIGN KEY FK_E7780DA4E9ED820C');
        $this->addSql('ALTER TABLE setlist_entry DROP FOREIGN KEY FK_E7780DA4922726E9');
        $this->addSql('ALTER TABLE setlist_entry DROP FOREIGN KEY FK_E7780DA4BBC049D6');
        $this->addSql('ALTER TABLE setlist_entry DROP FOREIGN KEY FK_E7780DA495CDAB1C');
        $this->addSql('ALTER TABLE setlist_entry DROP FOREIGN KEY FK_E7780DA447013001');
        $this->addSql('ALTER TABLE song DROP FOREIGN KEY FK_33EDEEA142776A1D');
        $this->addSql('ALTER TABLE song DROP FOREIGN KEY FK_33EDEEA11137ABCF');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE album_sort');
        $this->addSql('DROP TABLE backing_track');
        $this->addSql('DROP TABLE backing_track_sort');
        $this->addSql('DROP TABLE block');
        $this->addSql('DROP TABLE block_has_covers');
        $this->addSql('DROP TABLE cover');
        $this->addSql('DROP TABLE ending');
        $this->addSql('DROP TABLE intermission');
        $this->addSql('DROP TABLE intro_outro');
        $this->addSql('DROP TABLE log_user');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE setlist');
        $this->addSql('DROP TABLE setlist_entry');
        $this->addSql('DROP TABLE setlist_entry_sort');
        $this->addSql('DROP TABLE song');
        $this->addSql('DROP TABLE speech');
        $this->addSql('DROP TABLE tuning');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
