<?php

require_once __DIR__ . '/../models/Todo.php';

class TodoController {
    private $todoModel;

    // Constructor koppelt het model aan de controller
    public function __construct($pdo) {
        $this->todoModel = new Todo($pdo);
    }

    // Deze functie beslist wat er gebeurt op basis van de ?cmd= parameter
    public function handleRequest($cmd, $params) {
        switch ($cmd) {
            case 'all':
                return $this->todoModel->getAll();

            case 'add':
                if (!empty($params['item'])) {
                    $id = $this->todoModel->add($params['item']);
                    return [
                        'success' => true,
                        'id' => $id,
                        'item' => $params['item'],
                        'status' => 'NOT DONE'
                    ];
                }
                return ['success' => false, 'message' => 'Geen item opgegeven'];

            case 'done':
                if (!empty($params['id'])) {
                    $this->todoModel->markDone($params['id']);
                    return [
                        'success' => true,
                        'message' => "Todo #{$params['id']} gemarkeerd als DONE"
                    ];
                }
                return ['success' => false, 'message' => 'Geen ID opgegeven'];

            case 'remove':
                if (!empty($params['id'])) {
                    $this->todoModel->remove($params['id']);
                    return [
                        'success' => true,
                        'message' => "Todo #{$params['id']} succesvol verwijderd"
                    ];
                }
                return ['success' => false, 'message' => 'Geen ID opgegeven'];

            default:
                return ['success' => false, 'message' => 'Onbekend commando'];
        }
    }
}
