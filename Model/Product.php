<?php

namespace Model;

abstract class Product implements \JsonSerializable
{
    public const FIELDS = ['sku', 'name', 'price', 'productType'];

    public function __construct($data)
    {
        foreach (static::FIELDS as $field) {
            $this->$field = $data[$field];
        }
    }

    public static function getList()
    {
        $result = Database::getAll('products');
        foreach ($result as $row) {
            $class = 'Model\\' . $row['productType'];
            $row = new $class($row);
        }
        echo json_encode($result);
    }

    public function save()
    {
        Database::insert('products', static::FIELDS, $this);
    }

    public static function massDelete($list)
    {
        Database::massDelete('products', $list);
    }

    abstract public function text();

    public function jsonSerialize()
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->price,
            'text' => $this->text()
        ];
    }
}
