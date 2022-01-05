<?php

namespace app\controller;

use app\controller\BaseController as Controller;

class LoginController extends Controller
{
    public function index()
    {
        $this->loadView('login/index_view');
    }

    public function handleLogin()
    {
        // nhan dc du lieu tu form gui len chua
        if(isset($_POST['btnLogin'])){
            echo "<pre>";
            print_r($_POST);
        }
    }
}