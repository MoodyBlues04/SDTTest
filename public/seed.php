<?php

require_once __DIR__ . '/../lib/db.php';
global $mysqli;

$clients = [
    'test1',
    'test2',
    'test3',
];
$merchandise = [
    ['name' => 'product1', 'price' => 120],
    ['name' => 'product2', 'price' => 230],
    ['name' => 'product3', 'price' => 450],
];
foreach ($clients as $clientName) {
    $sql = "INSERT INTO clients (name) VALUES ('$clientName')";
    execQuery($sql, 'clients', 'insert');
}
foreach ($merchandise as $data) {
    $sql = "INSERT INTO merchandise (name, price) VALUES ('{$data['name']}', '{$data['price']}')";
    execQuery($sql, 'merchandise', 'insert');
}

$mysqli->close();