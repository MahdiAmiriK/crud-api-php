<?php

// Stellt eine Verbindung zur MySQL-Datenbank her
class Database {
    private $conn;

    // Verbindung im Konstruktor aufbauen
    public function __construct() {
        $servername = '******'; 
        $username = '******';
        $password = '******';
        $dbname = '******';
    
        $this->conn = new mysqli($servername, $username, $password, $dbname);
    
        // Fehler beim Verbindungsaufbau abfangen
        if ($this->conn->connect_error) {
            die(json_encode([        
                'status' => 'error',
                'message' => 'DB connection failed: ' . $this->conn->connect_error
            ]));
        }
    }

    // Zugriff auf die aktive Verbindung ermöglichen
    public function getConnection() {
        return $this->conn;
    }
}

?>
