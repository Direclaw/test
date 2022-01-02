<?php

namespace Model;

class DVD extends Product
{
    public const FIELDS = ['sku', 'name', 'price', 'productType', 'size'];

    public function text()
    {
        return 'Size: ' . $this->size . ' MB';
    }
}
