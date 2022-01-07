<?php

namespace app\controller;

use app\controller\BaseController as Controller;

class ProductController extends Controller
{
    public function __construct()
    {
        // checkUserLogin;
        $this->redirectToLogin();
    }
    
    public function index()
    {
        // xu ly logic o day

        //load header
        $this->loadHeader([
            'title' => 'Product page'
        ]);
        //load view
        $this->loadView('product/index_view');
        //load footer
        $this->loadFooter();
    }
}