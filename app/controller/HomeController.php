<?php

namespace app\controller;

use app\controller\BaseController as Controller;
use app\model\Product;

class HomeController extends Controller
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product;
    }

    public function index()
    {
        // lay du lieu tu model
        $products = $this->productModel->getListProducts();

        // day du lieu ra ngoai view va hien thi
        $this->loadView('home/index_view', [
            'products' => $products // du lieu truyen ra view
        ]);
    }
}