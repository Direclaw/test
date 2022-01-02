<?php

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . "autoload.php";
spl_autoload_register("autoload");

use Model\Product;

$data = json_decode(file_get_contents('php://input'));
Product::massDelete($data->list);
