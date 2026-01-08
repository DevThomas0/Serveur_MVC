<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class User
{
    private $id;
    private $nom;
    private $email;
    private $pwd;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getnom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPwd()
    {
        return $this->pwd;
    }

    public function setPwd($pwd)
    {
        $this->pwd = $pwd;
    }

    public static function getAll()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->query("SELECT * FROM user ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($id)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByEmail($email)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM Users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function createUser($username, $email, $password)
    {
        if (self::findByEmail($email)) {
            return false;
        }

        $pdo = Database::getPDO();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO Users (username, email, pwd) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $email, $hashedPassword]);
    }

    public function save()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("INSERT INTO user (nom, email) VALUES (?, ?)");
        return $stmt->execute([$this->nom, $this->email]);
    }


    public function update()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE user SET nom = ?, email = ? WHERE id = ?");
        return $stmt->execute([$this->nom, $this->email, $this->id]);
    }

    public function delete()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM user WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
}
