<?php

namespace app\controller;

use app\controller\BaseController as Controller;
use app\model\Product;

class ProductController extends Controller
{
    private $productModel;

    public function __construct()
    {
        // checkUserLogin;
        $this->redirectToLogin();
        // khoi tao doi tuong truy cap vao product model
        $this->productModel = new Product();
    }
    
    public function index()
    {
        // xu ly logic o day
        $products = $this->productModel->getListProducts();

        //load header
        $this->loadHeader([
            'title' => 'Product page'
        ]);
        //load view
        $this->loadView('product/index_view',[
            'products' => $products
        ]);
        //load footer
        $this->loadFooter();
    }
}