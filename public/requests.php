<?php

require_once __DIR__ . '/../lib/db.php';
global $mysqli;

parse_str($argv[1], $arg);
$reqType = array_keys($arg)[0];

$res = [];
switch ($reqType)
{
    case 'a':
        $data = selectNotBoughtClients();
        break;
    case 'b':
        $data = selectMostActiveClients();
        break;
    case 'c':
        $data = selectMostPaidClients();
        break;
    case 'd':
        $data = selectNotCompleteProducts();
        break;
}

var_dump($data);

/**
 * Выбрать имена (name) всех клиентов, которые не делали заказы в последние 7 дней
 * @param int $days
 * @return array
 */
function selectNotBoughtClients(int $days = 0): array
{
    $targetDate = date('Y-m-d', strtotime("-$days days"));
    $query = "SELECT name
                FROM clients
                    INNER JOIN orders ON clients.id=orders.customer_id
                GROUP BY customer_id
                HAVING MAX(order_date) < '{$targetDate}'";
    return select($query);
}

/**
 * Выбрать имена (name) 5 клиентов, которые сделали больше всего заказов в магазине.
 * @param int $limit
 * @return array
 */
function selectMostActiveClients(int $limit = 5)
{
    $query = "SELECT name
                FROM clients
                    INNER JOIN orders ON clients.id=orders.customer_id
                GROUP BY customer_id
                ORDER BY COUNT(orders.id) DESC
                LIMIT $limit";
    return select($query);
}

/**
 * Выбрать имена (name) 10 клиентов, которые сделали заказы на наибольшую сумму.
 * @param int $limit
 * @return array
 */
function selectMostPaidClients(int $limit = 10): array
{
    $query = "SELECT clients.name
                FROM clients
                    INNER JOIN orders ON clients.id=orders.customer_id
                    INNER JOIN merchandise ON merchandise.id=orders.item_id
                GROUP BY customer_id
                ORDER BY SUM(price)
                DESC LIMIT $limit";
    return select($query);
}

/**
 * Выбрать имена (name) всех товаров, по которым не было доставленных заказов (со статусом “complete”).
 * @return array
 */
function selectNotCompleteProducts(): array
{
    $query = "SELECT name FROM merchandise
                WHERE id NOT IN (
                    SELECT merchandise.id
                    FROM merchandise
                        INNER JOIN orders ON merchandise.id=orders.item_id
                    WHERE status='new'
                )";
    return select($query);
}