<?php

include_once 'lib/importer.php';

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
$product->setPrice(rand(1000,3000));
$product->setCurrency('RUR');
$product->setURL('http://www.yandex.ru/');
$product->setPicture('http://www.yandex.ru/logo.jpg');
$product->setAvailable(true);
$product->setCategories(['CCC']);

$product = $importer->newProduct();
$product->setId(4);
$product->setName('Футболка');
$product->setPrice(rand(10,30));
$product->setCurrency('RUR');
$product->setURL('http://www.yandex.ru/');
$product->setPicture('http://www.yandex.ru/logo.jpg');
$product->setAvailable(true);
$product->setCategories(['XXX']);
$product->setFashionType('shirt');
$product->setFashionFeature('pregnant');
$product->setFashionGender('f');
$product->setFashionSizes(['r44', 44]);

$importer->sendProducts();
