<?php

include_once 'importer.php';

$importer = new R46Importer();

$product = $importer->newProduct();
$product->setId(1);
$product->setName('Ведро');
$product->setPrice(100);
$product->setCurrency('RUR');
$product->setURL('http://www.yandex.ru/');
$product->setPicture('http://www.yandex.ru/logo.jpg');
$product->setAvailable(true);
$product->setCategories(['AAA', 'BBB', 'CCC']);

$product = $importer->newProduct();
$product->setId(2);
$product->setName('Лопата');
$product->setPrice(200);
$product->setCurrency('RUR');
$product->setURL('http://www.yandex.ru/');
$product->setPicture('http://www.yandex.ru/logo.jpg');
$product->setAvailable(false);
$product->setCategories(['AAA', 'BBB']);

$product = $importer->newProduct();
$product->setId(3);
$product->setName('Фонарик');
$product->setPrice(300);
$product->setCurrency('RUR');
$product->setURL('http://www.yandex.ru/');
$product->setPicture('http://www.yandex.ru/logo.jpg');
$product->setAvailable(true);
$product->setCategories(['CCC']);

$importer->sendProducts();
