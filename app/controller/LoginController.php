<?php

namespace app\controller;

use app\controller\BaseController as Controller;
use app\model\Login;

class LoginController extends Controller
{
    private $loginModel;
    public function __construct()
    {
        // da login roi thi vao thang luon trang mac dinh
        // khong bat login lai nua
        $method = strtolower(trim($_GET['m'] ?? ''));
        if($method !== 'logout'){
            // loai tru logout
            $this->redirectToDefaultPage();
        }
        // khoi tao doi tuong de truy cap vao login model
        $this->loginModel = new Login();
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
                $dataUser = $this->loginModel->checkUserLogin($username, $password);                
                if(!empty($dataUser)) {
                    // gan session
                    $_SESSION['username'] = $dataUser['username'];
                    $_SESSION['idUser'] = $dataUser['id'];
                    $_SESSION['email'] = $dataUser['email'];

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
                unset($_SESSION['idUser']);
                unset($_SESSION['email']);
            }
            header('Location:index.php?c=login');
        }
    }
}