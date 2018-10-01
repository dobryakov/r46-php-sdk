<?php

use PHPUnit\Framework\TestCase;
include dirname(__FILE__) . '/../lib/importer.php';

class ImporterTest extends TestCase {

    /** @var  R46Importer */
    var $importer;
    /** @var  R46Product */
    var $product;

    public function setUp() {
        $this->importer = new R46Importer();
        $this->product = $this->importer->newProduct();
    }

    public function testCorrectFashionGender() {
        $this->product->setFashionGender('m');
    }

    public function testIncorrectFashionGender() {
        $this->setExpectedException('R46InvalidAttributeFormat');
        $this->product->setFashionGender('male');
    }

    public function testCorrectFashionSizes() {
        $this->product->setFashionSizes(['r44', 44, 'e38', 'XS', 'u30', 'b6', 'h89-95', null]);
    }

    public function testFashionTypeRequired() {
        # set fashion_size, but forget fashion_type
        $this->product->setId(3);
        $this->product->setName('Фонарик');
        $this->product->setPrice(rand(1000,3000));
        $this->product->setCurrency('RUR');
        $this->product->setURL('http://www.yandex.ru/');
        $this->product->setPicture('http://www.yandex.ru/logo.jpg');
        $this->product->setAvailable(true);
        $this->product->setCategories(['CCC']);
        $this->product->setFashionSizes([null]);
        $this->setExpectedException('R46RequiredParameterMissing');
        $this->product->validate();
    }

    public function testIncorrectFashionFeature() {
        $this->setExpectedException('R46InvalidAttributeFormat');
        $this->product->setFashionFeature('adult');
    }

}