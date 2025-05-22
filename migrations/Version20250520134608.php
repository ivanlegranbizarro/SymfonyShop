<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250520134608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
            , password VARCHAR(255) NOT NULL, full_name VARCHAR(255) DEFAULT NULL, address CLOB DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__cart_history AS SELECT id, product_name, product_price, quantity, sub_total, order_reference FROM cart_history
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cart_history
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cart_history (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, order_id INTEGER NOT NULL, product_name VARCHAR(255) NOT NULL, product_price VARCHAR(255) NOT NULL, quantity INTEGER NOT NULL, sub_total DOUBLE PRECISION NOT NULL, order_reference VARCHAR(255) NOT NULL, CONSTRAINT FK_DC60B84C8D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO cart_history (id, product_name, product_price, quantity, sub_total, order_reference) SELECT id, product_name, product_price, quantity, sub_total, order_reference FROM __temp__cart_history
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__cart_history
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DC60B84C8D9F6D38 ON cart_history (order_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__product AS SELECT id, name, description, price, image, created_at, updated_at FROM product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, price DOUBLE PRECISION NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            , CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO product (id, name, description, price, image, created_at, updated_at) SELECT id, name, description, price, image, created_at, updated_at FROM __temp__product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__product
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__cart_history AS SELECT id, product_name, product_price, quantity, sub_total, order_reference FROM cart_history
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cart_history
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cart_history (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_name VARCHAR(255) NOT NULL, product_price VARCHAR(255) NOT NULL, quantity INTEGER NOT NULL, sub_total DOUBLE PRECISION NOT NULL, order_reference VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO cart_history (id, product_name, product_price, quantity, sub_total, order_reference) SELECT id, product_name, product_price, quantity, sub_total, order_reference FROM __temp__cart_history
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__cart_history
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__product AS SELECT id, name, description, price, image, created_at, updated_at FROM product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, price DOUBLE PRECISION NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            )
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO product (id, name, description, price, image, created_at, updated_at) SELECT id, name, description, price, image, created_at, updated_at FROM __temp__product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__product
        SQL);
    }
}
