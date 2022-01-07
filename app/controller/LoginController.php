<?php

namespace app\controller;

use app\controller\BaseController as Controller;

class LoginController extends Controller
{
    public function __construct()
    {
        // da login roi thi vao thang luon trang mac dinh
        // khong bat login lai nua
        $method = strtolower(trim($_GET['m'] ?? ''));
        if($method !== 'logout'){
            // loai tru logout
            $this->redirectToDefaultPage();
        }
        
    }

    public function index()
    {
        $state = trim($_GET['state'] ?? '');

        $this->loadView('login/index_view',[
            'messages' => $state
        ]);
    }

    public function handleLogin()
    {
        // nhan dc du lieu tu form gui len chua
        if(isset($_POST['btnLogin'])) {
            $username = $_POST['username'] ?? '';
            $username = strip_tags($username);

            $password = $_POST['password'] ?? '';
            $password = strip_tags($password);

            if(!empty($password) && !empty($username)) {
                // moi xu ly
                if($username === 'admin' && $password === '123456') {
                    // gan session
                    $_SESSION['username'] = $username;
                    header('Location:index.php?c=home');
                } else {
                    header('Location:index.php?c=login&state=fail');
                }
            } else {
                header('Location:index.php?c=login&state=error');
            }
        }
    }

    public function logout()
    {
        if(isset($_POST['btnLogout'])){
            // xoa session da tao ra o login
            // quay ve trang login
            if(isset($_SESSION['username'])){
                unset($_SESSION['username']);
            }
            header('Location:index.php?c=login');
        }
    }
}