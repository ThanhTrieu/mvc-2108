<?php

namespace app\model;

class Product
{
    public function getListProducts()
    {
        return [
            [
                'id' => 1,
                'name' => 'iPhone13',
                'price' => 2000
            ],
            [
                'id' => 2,
                'name' => 'SamsungS22',
                'price' => 2000
            ],
            [
                'id' => 3,
                'name' => 'Bphone3',
                'price' => 1000
            ]
        ];
    }
}