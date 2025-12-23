<?php
use PDO;

function db(): PDO {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    $host = 'localhost';
    $port = '5432';
    $dbname = 'postgres';     // or your DB name
    $user = 'farmly_user';
    $pass = 'secure_password';

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);
    return $pdo;
}
