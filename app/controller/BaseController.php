<?php

namespace app\controller;

class BaseController
{
    const PATH_VIEW = 'app/view/';

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

    public function __call($method, $parameters = null)
    {
        // khi truy cap vao phuong thuc ko phai la static khong ton tai trong class thi no se tu dong chay
        exit("{$method} not found");
    }
}