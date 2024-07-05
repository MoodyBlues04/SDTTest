<?php

require_once __DIR__ . '/../lib/db.php';
global $mysqli;

parse_str($argv[1], $arg);
$fileName = array_keys($arg)[0];

$rows = parseCsv(__DIR__ . "/../$fileName.csv");
$validRows = getValidRows($rows);

$date = date('Y-m-d H:i:s');
foreach ($validRows as $row) {
    $sql = "INSERT INTO orders (item_id, customer_id, comment, status, order_date)
            VALUES ('{$row[0]}', '{$row[1]}', '{$row[2]}', 'new', '{$date}')";
    execQuery($sql, 'clients', 'insert');
}


function getValidRows(array $rows): array
{
    $validRows = [];
    $invalidRows = [];
    foreach ($rows as $row) {
        if (sizeof($row) !== 3) {
            $invalidRows []= $row;
            continue;
        }
        $product = selectById((int)$row[0], 'merchandise');
        $client = selectById((int)$row[1], 'clients');
        if (empty($product) || empty($client)) {
            $invalidRows []= $row;
            continue;
        }
        $validRows []= $row;
    }
    writeToCsv(__DIR__ . '/../errors.csv', $invalidRows);
    return $validRows;
}

function writeToCsv(string $fileName, array $data): void
{
    $handle = fopen($fileName, "wb");
    if (!$handle) {
        throw new \InvalidArgumentException("Cannot open file '{$fileName}'");
    }
    foreach ($data as $row) {
        fputcsv($handle, $row);
    }
    fclose($handle);
}

/**
 * @param string $fileName
 * @return array<int, string[]>
 */
function parseCsv(string $fileName): array
{
    $result = [];
    $handle = fopen($fileName, "r");
    if (!$handle) {
        throw new \InvalidArgumentException("Cannot open file '{$fileName}'");
    }
    while ($row = fgetcsv($handle, 1000, ';')) {
        $result [] = $row;
    }
    fclose($handle);

    return $result;
}