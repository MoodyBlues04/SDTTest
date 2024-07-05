<?php

require_once __DIR__ . '/../lib/db.php';
global $mysqli;

$migrations = [
    [
        'sql' => 'CREATE TABLE clients (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(30) UNIQUE NOT NULL
                    )',
        'name' => 'clients',
    ],
    [
        'sql' => 'CREATE TABLE merchandise (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(30) UNIQUE NOT NULL,
                    price INTEGER NOT NULL
                    )',
        'name' => 'merchandise',
    ],
    [
        'sql' => 'CREATE TABLE orders (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    item_id INT(6) UNSIGNED,
                    customer_id INT(6) UNSIGNED,
                    comment VARCHAR(55) NOT NULL,
                    status VARCHAR(55) NOT NULL,
                    order_date DATE NOT NULL,
                    FOREIGN KEY (item_id) REFERENCES merchandise(id) ON DELETE CASCADE,
                    FOREIGN KEY (customer_id) REFERENCES clients(id) ON DELETE CASCADE
                    )',
        'name' => 'orders',
    ],
];

foreach ($migrations as $migration) {
    execQuery($migration['sql'], $migration['name']);
}
$mysqli->close();
