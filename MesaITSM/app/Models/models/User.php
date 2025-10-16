<?php
class User {
    public static function register($email, $password) {
        // Hash de la contraseña
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        // Guardar usuario en la base de datos (ejemplo con PDO)
        $db = new PDO('mysql:host=localhost;dbname=mesa_ayuda', 'root', '');
        $stmt = $db->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        return $stmt->execute([$email, $hashed]);
    }

    public static function login($email, $password) {
        $db = new PDO('mysql:host=localhost;dbname=mesa_ayuda', 'root', '');
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
        return false;
    }

    public static function logout() {
        session_destroy();
    }
}
