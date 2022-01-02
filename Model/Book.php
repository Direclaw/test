<?php

namespace Model;

class Book extends Product
{
    public const FIELDS = ['sku', 'name', 'price', 'productType', 'weight'];

    public function text()
    {
        return 'Weight: ' . $this->weight . 'KG';
    }
}
