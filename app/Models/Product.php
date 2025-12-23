<?php
namespace App\Models;

use PDO;

class Product {
    public int $id;
    public string $name;
    public float $price;
    public string $category;
    public ?string $image;

    public static function all(): array {
        $pdo = db(); // helper from config/database.php
        $stmt = $pdo->query('SELECT id, name, price, category, image FROM products ORDER BY id DESC');
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function find(int $id): ?self {
        $pdo = db();
        $stmt = $pdo->prepare('SELECT id, name, price, category, image FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
