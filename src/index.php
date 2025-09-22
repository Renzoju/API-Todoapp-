
<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");


$pdo = require __DIR__ . '/Database.php';
require_once __DIR__ . '/controllers/TodoController.php';

header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$cmd = $_GET['cmd'] ?? null;

if (!$cmd) {
    echo json_encode([
        'success' => false,
        'message' => 'Geen cmd parameter meegegeven'
    ]);
    exit;
}

// 4. Controller aanmaken en request afhandelen
$controller = new TodoController($pdo); 
$response = $controller->handleRequest($cmd, $_GET);


echo json_encode($response);
