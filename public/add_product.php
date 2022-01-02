<?php

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . "autoload.php";
spl_autoload_register("autoload");

$data = json_decode(file_get_contents('php://input'));

$class = 'Model\\' . $data->productType;
$product = new $class((array) $data);
$product->save();
