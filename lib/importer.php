<?php

include_once dirname(__FILE__) . '/config.php';
include_once dirname(__FILE__) . '/product.php';
include_once dirname(__FILE__) . '/exception.php';

class R46Importer
{

    protected $products = [];

    public function newProduct() {
        $p = new R46Product();
        $this->products[] = $p;
        $this->debug('Create new product');
        return $p;
    }

    public function sendProducts() {
        /**
         * @var $product R46Product
         */
        foreach ($this->products as $product) {
            $product->validate();
        }

        foreach (array_chunk($this->getProductsAsArray(), 1000) as $items) {
            $data = [
                'shop_id'       => R46_SHOP_ID,
                'shop_secret'   => R46_SHOP_SECRET,
                'items'         => $items
            ];

            $this->debug("Send " . count($items). " items...");
            if (R46_DEBUG) {
                print_r($data);
            }

            $url = R46_BASE_URL . 'import/products';
            $ch = curl_init($url);
            $header = "Content-Type: application/json";
            curl_setopt($ch, CURLOPT_VERBOSE, R46_DEBUG ? 1 : 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $returned = curl_exec($ch);

            if (curl_error($ch)) {
                print curl_error($ch);
            } else {
                #print 'API returns: ' . $returned;
            }
        }

    }

    protected function getProductsAsArray() {
        $result = [];
        foreach ($this->products as $product) {
            /**
             * @var $product R46Product
             */
            $item = [
                'id' => $product->get('id'),
                'name' => $product->get('name'),
                'price' => $product->get('price'),
                'currency' => $product->get('currency'),
                'url' => $product->get('url'),
                'picture' => $product->get('picture'),
                'available' => $product->get('available'),
                'categories' => $product->get('categories'),
            ];
            if ($product->is_niche('fashion')) {
                $item['fashion'] = [
                    'gender'  => $product->get('fashion_gender'),
                    'sizes'   => $product->get('fashion_sizes'),
                    'type'    => $product->get('fashion_type'),
                    'feature' => $product->get('fashion_feature'),
                ];
            }
            $result[] = $item;
        }
        return $result;
    }

    protected function debug($str) {
        echo('R46 DEBUG: ' . $str . "\n");
    }

}