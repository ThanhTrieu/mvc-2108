<?php

namespace app\controller;

use app\controller\BaseController as Controller;
use app\libs\UploadFile as File;
use app\model\Brand;

class BrandController extends Controller
{
    private $brandModel;

    public function __construct()
    {
        // neu chua login thi phai lai login
        $this->redirectToLogin();
        // khoi tao doi tuong truy cap vao model
        $this->brandModel = new Brand();
    }

    public function index()
    {
        //xu ly logic o day

        //load header
        $this->loadHeader([
            'title' => 'brands page'
        ]);
        //load view
        $this->loadView('brands/index_view');
        //load footer
        $this->loadFooter();
    }

    public function add()
    {
        //xu ly logic o day
        $state = trim($_GET['state'] ?? '');
        // $state === error || $state === name-exists || $state === fail
        $messagesError = [];
        if($state === 'error' && isset($_SESSION['errorAddBrand'])){
            $messagesError = $_SESSION['errorAddBrand'];
        }
        $messagesExists = null;
        if($state === 'name-exists' && isset($_SESSION['nameBrandExists'])){
            $messagesExists = $_SESSION['nameBrandExists'];
        }
        $messagesFail = null;
        if($state === 'fail'){
            $messagesFail = 'Co loi xay ra, vui long thu lai';
        }

        //load header
        $this->loadHeader([
            'title' => 'add brand page'
        ]);
        //load view
        $this->loadView('brands/add_view',[
            'messagesError' => $messagesError,
            'messagesExists' => $messagesExists,
            'messagesFail' => $messagesFail
        ]);
        //load footer
        $this->loadFooter();
    }

    public function handleAdd()
    {
        if(isset($_POST['btnAddBrand'])){
            $nameBrand = $_POST['nameBrand'] ?? '';
            $nameBrand = strip_tags($nameBrand); // xoa cac tags html
            // slug - xu ly nho common helper
            $slug = slugtify($nameBrand);
            $description = $_POST['description'] ?? '';

            // tien hanh upload logo
            $nameLogo = null; // ten anh - luu trong db
            if(!empty($_FILES['logoBrand']['name'])){
                // nguoi dung thuc su co upload logo
                $nameLogo = File::uploadFileToServer($_FILES['logoBrand'],PATH_UPLOAD_BRAND_LOGO);
            }
            
            // kiem tra tinh hop le cua du lieu
            // ten thuong hieu khong duoc trong
            // logo thuong hieu khong duoc trong
            $validations = validationBandData($nameBrand, $nameLogo);
  
            /// ???
            $flagCheck = true; // thong bao loi
            foreach ($validations as $val) {
                if(!empty($val)){
                    $flagCheck = false;
                    break;
                }
            }

            if($flagCheck){
                // khong co loi gi ca
                // xoa bo di session error
                if(isset($_SESSION['errorAddBrand'])){
                    unset($_SESSION['errorAddBrand']);
                }
                // kiem tra ten thuong hieu da ton tai trong db chua ?
                // neu chua ton tai thi se duoc them moi
                // neu ton tai roi - bao loi va quay ve form add
                $nameExists = $this->brandModel->checkExistsNameBrand($nameBrand);
                if($nameExists){
                    // ton tai roi
                    $_SESSION['nameBrandExists'] = $nameBrand;
                    // can xoa bo anh da dc upload len server
                    if(!empty($nameLogo)) {
                        // xoa anh
                        File::deleteFileServer($nameLogo, PATH_UPLOAD_BRAND_LOGO);
                    }
                    // quay ve form add
                    header("Location:index.php?c=brand&m=add&state=name-exists");
                } else {
                    // chua ton tai
                    $insert = $this->brandModel->insertBrands($nameBrand, $slug, $nameLogo, $description);
                    if($insert){
                        // thanh cong - quay ve trang list brands
                        header("Location:index.php?c=brand");
                    } else {
                        // that bai - quay ve lai form add
                        header("Location:index.php?c=brand&m=add&state=fail");
                    }
                }
            } else {
                // co loi
                // gan loi vao session
                $_SESSION['errorAddBrand'] = $validations;
                // can xoa bo anh da dc upload len server
                if(!empty($nameLogo)) {
                    // xoa anh
                    File::deleteFileServer($nameLogo, PATH_UPLOAD_BRAND_LOGO);
                }
                // quay ve form add
                header("Location:index.php?c=brand&m=add&state=error");
            }
        }
    }
}