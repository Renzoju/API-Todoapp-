<?php
class Todo {
    private $pdo;

   
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Voeg een nieuwe todo toe */
    public function add($item) {
        $stmt = $this->pdo->prepare("INSERT INTO todos (item, status) VALUES (:item, 'NOT DONE')");
        $stmt->execute(['item' => $item]);

        // Retourneer de ID van het nieuwe record
        return $this->pdo->lastInsertId();
    }

    /**
     * Haal alle todos op */
    public function getAll() {  
        $stmt = $this->pdo->query("SELECT * FROM todos ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Zet status van een todo op DONE */

    public function markDone($id) {
        $stmt = $this->pdo->prepare("UPDATE todos SET status = 'DONE' WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Verwijder een todo */
    public function remove($id) {
        $stmt = $this->pdo->prepare("DELETE FROM todos WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
