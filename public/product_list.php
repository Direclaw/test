<?php

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . "autoload.php";
spl_autoload_register("autoload");

use Model\Product;

Product::getList();
