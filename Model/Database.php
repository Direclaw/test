<?php

namespace Model;

class Database
{
    public static function connect()
    {
        $lines = file(
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '.env', 
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
        );
        $env = [];
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            $env[$name] = $value;
        }
        return mysqli_connect($env['HOST'], $env['USER'], $env['PASS'], $env['NAME']);
    }

    public static function getAll($table)
    {
        $connection = self::connect();
        $result = $connection->query("SELECT * from $table");

        $list = [];
        while ($row = $result->fetch_assoc()) {
            array_push($list, $row);
        }
        $connection->close();
        return $list;
    }

    public static function insert($table, $fields, $item)
    {
        $values = [];
        foreach ($fields as $field) {
            $values[$field] = $item->$field;
        }

        $keys = array_keys($values);
        $columns = implode(', ', $keys);
        $placeholders = str_repeat(', ?', count($values) - 1);
        $query = "INSERT INTO $table ($columns) VALUES (?$placeholders)";

        $connection = self::connect();

        $stmt = $connection->prepare($query);
        $stmt->bind_param(str_repeat('s', count($values)), ...array_values($values));
        $stmt->execute();

        $connection->close();
    }

    public static function massDelete($table, $list)
    {
        $placeholders = str_repeat(", ?", count($list) - 1);
        $query = "DELETE FROM $table WHERE sku IN(?$placeholders)";
        $connection = self::connect();

        $stmt = $connection->prepare($query);
        $stmt->bind_param(str_repeat('s', count($list)), ...$list);
        $stmt->execute();

        $connection->close();
    }
}
