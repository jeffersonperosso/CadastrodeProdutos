<?php
require_once __DIR__ . '/Controller.php';

$controller = new Controller();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $controller->getAll();
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $controller->create($data);
}

if ($method === 'DELETE') {
    $id = $_GET["id"];

    if (!$id) {
        http_response_code(400);
        exit;
    }

    $controller->delete($id);
}
