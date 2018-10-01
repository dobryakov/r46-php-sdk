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

    protected $fashion_gender;
    protected $fashion_sizes;
    protected $fashion_type;
    protected $fashion_feature;

    protected $required_fields = ['id', 'name', 'price', 'currency', 'url', 'picture', 'available', 'categories'];

    public function validate() {
        foreach ($this->required_fields as $f) {
            if (is_null($this->$f)) {
                throw new R46Exception('Required field ' . $f . ' is not set.');
            }
        }
        if ( (count($this->fashion_sizes) > 0) && is_null($this->fashion_type) ) {
            throw new R46RequiredParameterMissing('Fashion_type is required while fashion_sizes are not empty');
        }
        $this->debug('Product id ' . $this->id . ' is valid');
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

    public function setFashionGender($value) {
        if (!in_array($value, ['f', 'm'])) {
            throw new R46InvalidAttributeFormat('Gender should be only f, m, or undefined');
        }
        $this->debug('Set fashion_gender: ' . $value);
        $this->fashion_gender = $value;
    }

    public function setFashionSizes($value) {
        if (!is_array($value)) {
            throw new R46InvalidAttributeFormat('Fashion_size should be an array');
        }
        foreach ($value as $size) {
            if ( is_null($size) ) { continue; } # null is allowed
            if (is_numeric($size)) { continue; } # only digits are allowed
            if ( in_array(substr($size, 0, 1), ['r', 'e', 'u', 'b'] ) ) { # allow sizes begins with these symbols
                if (is_numeric(substr($size, 1))) { continue; } # and contains only digits
            }
            if ( in_array($size, ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL']) ) { continue; } # allow US sizes
            if ( substr($size, 0, 1) == 'h' ) {
                if ( is_numeric( str_replace('-', '', substr($size, 1)) ) ) { continue; } # allow height format like 'h89-95'
            }
            # raise an error in other case
            throw new R46InvalidAttributeFormat('Fashion_size ' . $size . ' is not correct, see the documentation');
        }
        $this->debug('Set fashion_sizes: [' . join(',', $value) . ']');
        $this->fashion_sizes = $value;
    }

    public function setFashionType($value) {
        $allowed_fashion_types = ['shoe', 'shirt', 'tshirt', 'underwear', 'trouser', 'jacket', 'blazer', 'sock', 'belt', 'hat', 'glove'];
        if (!in_array($value, $allowed_fashion_types)) {
            throw new R46InvalidAttributeFormat('Fashion_type should be in array [' . join(',', $allowed_fashion_types) . ']');
        }
        $this->debug('Set fashion_type: ' . $value);
        $this->fashion_type = $value;
    }

    public function setFashionFeature($value) {
        $allowed_fashion_features = ['pregnant'];
        if (!in_array($value, $allowed_fashion_features)) {
            throw new R46InvalidAttributeFormat('Fashion_features should be in array [' . join(',', $allowed_fashion_features) . ']');
        }
        $this->debug('Set fashion_feature: ' . $value);
        $this->fashion_feature = $value;
    }

    public function is_niche($niche) {
        switch ($niche) {
            case 'fashion':
                return ($this->fashion_type || $this->fashion_sizes || $this->fashion_gender || $this->fashion_feature);
                break;
            default:
                return false;
        }
    }

    public function get($attribute) {
        return $this->$attribute;
    }

    protected function debug($str) {
        echo('R46 DEBUG: ' . $str . "\n");
    }

}
