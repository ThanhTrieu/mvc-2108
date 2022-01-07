<?php

namespace app\controller;

class BaseController
{
    const PATH_VIEW = 'app/view/';

    protected function loadHeader($data = [])
    {
        $data['userSession'] = $this->getUserSession();
        $this->loadView('partials/header_view', $data);
    }

    protected function loadFooter($data = [])
    {
        $this->loadView('partials/footer_view', $data);
    }

    protected function loadView($path, $data = [])
    {
        extract($data); // chuyen key cua mang thanh 1 bien
        /*
            ['id' => 10, 'name' => 'teo']
            $id = 10;
            $name = 'teo';
        */
       require self::PATH_VIEW.$path.".php";
    }

    public function getUserSession()
    {
        $user = $_SESSION['username'] ?? '';
        return $user;
    }

    protected function redirectToDefaultPage()
    {
        if($this->checkUserLogin()){
            header('Location:index.php?c=home');
            exit();
        }
    }

    protected function redirectToLogin()
    {
        if(!$this->checkUserLogin()){
            header('Location:index.php?c=login');
            exit();
        }
    }

    protected function checkUserLogin()
    {
        $sessionUser = $this->getUserSession();
        if(!empty($sessionUser)){
            return true;
        }
        return false;
    }

    public function __call($method, $parameters = null)
    {
        // khi truy cap vao phuong thuc ko phai la static khong ton tai trong class thi no se tu dong chay
        exit("{$method} not found");
    }
}