<?php

require_once __DIR__ .'/../db/Database.php';

// Modellklasse für Datenbankoperationen (CRUD) auf der "users"-Tabelle
class UserModel {

    private $conn;

    // Verbindung zur Datenbank beim Erstellen des Objekts
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Neuen Nutzer einfügen
    public function insertUser($name, $email) {
        $stmt = $this->conn->prepare('INSERT INTO users (name, email) VALUES (?, ?)');
        $stmt->bind_param('ss', $name, $email);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // Alle Nutzer abrufen
    public function selectAllUsers() {
        $sql = "SELECT * FROM users";
        $result = $this->conn->query($sql);

        $users = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }

        $result->close();
        return $users;
    }

    // Nutzer aktualisieren (per ID)
    public function updateUser($id, $name, $email) {
        $stmt = $this->conn->prepare('UPDATE users SET name = ?, email = ? WHERE id = ?');
        $stmt->bind_param("ssi", $name, $email, $id);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // Nutzer löschen (per ID)
    public function deleteUser($id) {
        $stmt = $this->conn->prepare('DELETE FROM users WHERE id = ?');
        $stmt->bind_param('i', $id);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // Verbindung schließen, wenn das Objekt zerstört wird
    public function __destruct() {
        $this->conn->close();
    }
}
?>