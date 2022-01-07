<?php

namespace app\controller;

use app\controller\BaseController as Controller;
use app\model\Product;

class HomeController extends Controller
{
    private $productModel;

    public function __construct()
    {
        // checkUserLogin;
        $this->redirectToLogin();

        $this->productModel = new Product;
    }

    public function index()
    {
        // $s = sumNumber(1,2);
        // echo $s;
        // die;
        // echo LIMIT_PAGE;
        // die;
        // xu ly cac logic o day
        // lay du lieu tu model
        $products = $this->productModel->getListProducts();

        // load header
        $this->loadHeader([
            'title' => 'Home page'
        ]);
        // day du lieu ra ngoai view va hien thi
        $this->loadView('home/index_view', [
            'products' => $products // du lieu truyen ra view
        ]);
        // load footer
        $this->loadFooter();
    }
}