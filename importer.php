<?php

include_once 'config.php';
include_once 'product.php';
include_once 'exception.php';

class R46Importer
{

    protected $products = [];

    public function newProduct()
    {
        $p = new R46Product();
        $this->products[] = $p;
        $this->debug('Create new product');
        return $p;
    }

    public function sendProducts()
    {
        foreach ($this->products as $product) {
            if ($product->is_valid()) {
                $this->debug('Send product ' . $product->get('id') . ' ' . $product->get('name'));

                $data = [
                    'shop_id' => R46_SHOP_ID,
                    'shop_secret' => R46_SHOP_SECRET,
                    'items' => $this->getProductsAsArray()
                ];

                $url = R46_BASE_URL . 'import/products';
                $ch = curl_init($url);
                $header = "Content-Type: application/json";
                curl_setopt($ch, CURLOPT_VERBOSE, 1);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                $returned = curl_exec($ch);

                if (curl_error($ch)) {
                    print curl_error($ch);
                } else {
                    print 'ret: ' . $returned;
                }

            }
        }
    }

    protected function getProductsAsArray()
    {
        $result = [];
        foreach ($this->products as $product) {
            $result[] = [
                'id' => $product->get('id'),
                'name' => $product->get('name'),
                'price' => $product->get('price'),
                'currency' => $product->get('currency'),
                'url' => $product->get('url'),
                'picture' => $product->get('picture'),
                'available' => $product->get('available'),
                'categories' => $product->get('categories')
            ];
        }
        return $result;
    }

    protected function debug($str)
    {
        echo('R46 DEBUG: ' . $str . "\n");
    }

}