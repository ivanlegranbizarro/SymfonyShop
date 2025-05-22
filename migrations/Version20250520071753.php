<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250520071753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE cart_history (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_name VARCHAR(255) NOT NULL, product_price VARCHAR(255) NOT NULL, quantity INTEGER NOT NULL, sub_total DOUBLE PRECISION NOT NULL, order_reference VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE "order" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_name VARCHAR(255) NOT NULL, user_email VARCHAR(255) NOT NULL, user_address VARCHAR(255) NOT NULL, total DOUBLE PRECISION NOT NULL, payment_method VARCHAR(255) NOT NULL, payment_status VARCHAR(255) NOT NULL, is_pending BOOLEAN DEFAULT NULL, is_shipped BOOLEAN DEFAULT NULL, is_delivered BOOLEAN DEFAULT NULL, is_processed BOOLEAN DEFAULT NULL, order_reference VARCHAR(255) NOT NULL)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE cart_history
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE "order"
        SQL);
    }
}
