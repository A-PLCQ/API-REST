<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240721213910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the book table with title, author, publicationYear, and isbn columns.';
    }

    public function up(Schema $schema): void
    {
        // Create the book table with the correct column names
        $this->addSql('CREATE TABLE book (
            id INT AUTO_INCREMENT NOT NULL,
            title VARCHAR(255) NOT NULL,
            author VARCHAR(255) NOT NULL,
            publication_Year INT NOT NULL,
            isbn VARCHAR(13) NOT NULL UNIQUE,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Add some initial data (optional)
        $this->addSql("INSERT INTO book (title, author, publication_Year, isbn) VALUES
            ('The Great Gatsby', 'F. Scott Fitzgerald', 1925, '9780743273565'),
            ('To Kill a Mockingbird', 'Harper Lee', 1960, '9780060935467'),
            ('1984', 'George Orwell', 1949, '9780451524935'),
            ('Pride and Prejudice', 'Jane Austen', 1813, '9780486284736'),
            ('Moby-Dick', 'Herman Melville', 1851, '9781503280786'),
            ('The Catcher in the Rye', 'J.D. Salinger', 1951, '9780316769488'),
            ('The Lord of the Rings', 'J.R.R. Tolkien', 1954, '9780544003415'),
            ('The Hobbit', 'J.R.R. Tolkien', 1937, '9780547928227'),
            ('Brave New World', 'Aldous Huxley', 1932, '9780060850524'),
            ('Fahrenheit 451', 'Ray Bradbury', 1953, '9781451673319')");
    }

    public function down(Schema $schema): void
    {
        // Drop the book table
        $this->addSql('DROP TABLE book');
    }
}
