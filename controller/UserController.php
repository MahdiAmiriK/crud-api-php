<?php

require_once __DIR__ . '/../model/UserModel.php';

// Controller-Klasse zur Verarbeitung von Benutzeraktionen
class UserController {

    // Benutzer erstellen (Name und E-Mail erforderlich)
    public function createUser($data) {
        if (isset($data['name']) && isset($data['email'])) {
            $model = new UserModel();
            $result = $model->insertUser($data['name'], $data['email']);

            if ($result) {
                return [
                    'status' => 'success',
                    'message' => 'Data saved successfully in DB'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Data is not saved in DB'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Name or Email was not sent'
            ];
        }
    }

    // Alle Benutzer abrufen
    public function getAllUsers() {
        $model = new UserModel();
        $result = $model->selectAllUsers();

        if (!empty($result)) {
            return [
                'status' => 'success',
                'data' => $result
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'There is no data in Database'
            ];
        }
    }

    // Benutzer aktualisieren (ID, Name und E-Mail erforderlich)
    public function updateUser($data) {
        if (isset($data['id']) && isset($data['name']) && isset($data['email'])) {
            $model = new UserModel();
            $result = $model->updateUser($data['id'], $data['name'], $data['email']);

            if ($result) {
                return [
                    'status' => 'success',
                    'message' => 'Data updated successfully in DB'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Data is not updated in DB'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Name or Email was not sent'
            ];
        }
    }

    // Benutzer löschen (ID erforderlich)
    public function deleteUser($data) {
        if ($data['id']) {
            $model = new UserModel();
            $result = $model->deleteUser($data['id']);

            if ($result) {
                return [
                    'status' => 'success',
                    'message' => 'The data was successfully deleted from the database',
                    'data' => $result
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Deleting data was not successful'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'ID was not sent'
            ];
        }
    }
}

?>