<?php

namespace Model;

class Furniture extends Product
{
    public const FIELDS = ['sku', 'name', 'price', 'productType', 'height', 'width', 'length'];

    public function text()
    {
        return 'Dimension: ' . $this->height . 'x' . $this->width . 'x' . $this->length;
    }
}
