<?php
// Fehler anzeigen (nur in der Entwicklungsphase)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Basis-Header für JSON-Antworten und CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Eingehende JSON-Daten lesen
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Controller initialisieren
require_once __DIR__ . '/controller/UserController.php';
$controller = new UserController();

// Aktion bestimmen und passende Methode ausführen
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'create':
        echo json_encode($controller->createUser($data));
        break;
    case 'read':
        echo json_encode($controller->getAllUsers());
        break;
    case 'update':
        echo json_encode($controller->updateUser($data));
        break;
    case 'delete':
        echo json_encode($controller->deleteUser($data));
        break;
    default:
        // Ungültige Aktion
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid action'
        ]);
}
?>