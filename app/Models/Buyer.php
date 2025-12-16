<?php

require_once 'Database.php';

class Buyer
{
    public static function create($data)
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            INSERT INTO buyers
            (email, password, full_name, phone, address, gender, state, city)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['full_name'],
            $data['phone'],
            $data['address'],
            $data['gender'],
            $data['state'],
            $data['city']
        ]);
    }

    public static function findByEmail($email)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM buyers WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}
