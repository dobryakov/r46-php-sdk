<?php

class R46Product {

    protected $id;
    protected $name;
    protected $price;
    protected $currency;
    protected $url;
    protected $picture;
    protected $available;
    protected $categories;

    protected $required_fields = ['id', 'name', 'price', 'currency', 'url', 'picture', 'available', 'categories'];

    public function is_valid() {
        foreach ($this->required_fields as $f) {
            if (is_null($this->$f)) {
                throw new R46Exception('Required field ' . $f . ' is not set.');
            }
        }
        return true;
    }

    public function setId($value) {
        if (!is_string($value) && !is_numeric($value)) {
            throw new R46InvalidAttributeFormat('Id should be a string or numeric');
        }
        $this->debug('Set id: ' . $value);
        $this->id = $value;
    }

    public function setName($value) {
        if (is_numeric($value)) {
            throw new R46InvalidAttributeFormat('Name should be a string');
        }
        $this->debug('Set name: ' . $value);
        $this->name = $value;
    }

    public function setPrice($value) {
        if (!is_float($value) && !is_numeric($value)) {
            throw new R46InvalidAttributeFormat('Price should be numeric');
        }
        $this->debug('Set price: ' . $value);
        $this->price = $value;
    }

    public function setCurrency($value) {
        if (!is_string($value)) {
            throw new R46InvalidAttributeFormat('Currency should be a string');
        }
        $this->debug('Set currency: ' . $value);
        $this->currency = $value;
    }

    public function setURL($value) {
        if (!is_string($value) || substr($value,0,4) !== "http") {
            throw new R46InvalidAttributeFormat('URL should be valid');
        }
        $this->debug('Set URL: ' . $value);
        $this->url = $value;
    }

    public function setPicture($value) {
        if (!is_string($value) || substr($value,0,4) !== "http") {
            throw new R46InvalidAttributeFormat('Picture should be a valid URL');
        }
        $this->debug('Set picture: ' . $value);
        $this->picture = $value;
    }

    public function setAvailable($value) {
        if (!is_bool($value)) {
            throw new R46InvalidAttributeFormat('Available should be boolean');
        }
        $this->debug('Set available: ' . $value);
        $this->available = $value;
    }

    public function setCategories($value) {
        if (!is_array($value)) {
            throw new R46InvalidAttributeFormat('Categories should be an array of strings');
        }
        $this->debug('Set categories: ' . implode(',', $value));
        $this->categories = $value;
    }

    public function get($attribute) {
        return $this->$attribute;
    }

    protected function debug($str) {
        echo('R46 DEBUG: ' . $str . "\n");
    }

}
