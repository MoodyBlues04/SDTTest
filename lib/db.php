<?php

$mysqli = new mysqli(
    'localhost',
    'root',
    '',
    'sdt_test'
);
if ($mysqli->connect_error) {
    die("Connection failed: $mysqli->connect_error");
}

function selectById(int $id, string $table): array
{
    $res = select("SELECT * FROM $table WHERE id={$id}");
    return $res[0] ?? [];
}

function select(string $query): array
{
    global $mysqli;
    $result = $mysqli->query($query);

    $res = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $res []= $row;
        }
    }
    return $res;
}

function execQuery(string $query, string $tableName, string $reqType = 'create'): void
{
    global $mysqli;
    if ($mysqli->query($query)) {
        echo "Table '$tableName' $reqType success\n";
    } else {
        die("Cannot $reqType '$tableName': $mysqli->error");
    }
}