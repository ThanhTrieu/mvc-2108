<?php

namespace app\controller;

use app\controller\BaseController as Controller;
use app\libs\UploadFile as File;
use app\model\Brand;
use app\libs\Pagination;

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
        $keyword = $_GET['s'] ?? '';
        $keyword = trim(strip_tags($keyword));

        $linkPage = Pagination::createLink([
            'c' => 'brand',
            'm' => 'index',
            'page' => '{page}',
            's' => $keyword
        ]);

        //xu ly logic o day
        $allBrands = $this->brandModel->getAllDataBrands($keyword);

        //load header
        $this->loadHeader([
            'title' => 'brands page'
        ]);
        //load view
        $this->loadView('brands/index_view',[
            'brands' => $allBrands,
            'keyword' => $keyword
        ]);
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

    public function edit()
    {
        $id = $_GET['id'] ?? '';
        $id = is_numeric($id) ? $id : 0;

        // lay chi tiet du lieu brand theo id
        $infoBrand = $this->brandModel->getDataBrandById($id);
        if(!empty($infoBrand)){
            // co du lieu theo id trong database

            $state = trim($_GET['state'] ?? '');
            $messagesError = [];
            if($state === 'error' && !empty($_SESSION['editBrands'])){
                $messagesError = $_SESSION['editBrands'];
            }
            $messagesExists = null;
            if($state === 'exists' && !empty($_SESSION['nameBrandExists'])){
                $messagesExists = $_SESSION['nameBrandExists'];
            }
            $messagesFail = null;
            if($state === 'fail'){
                $messagesFail = 'Co loi xay ra vui long thu lai';
            }


            $this->loadHeader([
                'title' => 'Brand - ' . $infoBrand['name']
            ]);
            $this->loadView('brands/edit_view',[
                'info' => $infoBrand,
                'error' => $messagesError,
                'exists' => $messagesExists,
                'fail' => $messagesFail
            ]);
            $this->loadFooter();
        } else {
            // khong co
            //load header
            $this->loadHeader([
                'title' => '404 page'
            ]);
            $this->loadView('errors/404_view');
            $this->loadFooter();
        }
    }

    public function handleEdit()
    {
        if(isset($_POST['btnEditBrand'])){
            $id = $_GET['id'] ?? '';
            $id = is_numeric($id) ? $id : 0;
            // lay chi tiet du lieu brand theo id
            $infoBrand = $this->brandModel->getDataBrandById($id);
            if(!empty($infoBrand)){
                $nameBrand = $_POST['nameBrand'] ?? '';
                $nameBrand = strip_tags($nameBrand); // xoa cac tags html
                // slug - xu ly nho common helper
                $slug = slugtify($nameBrand);
                $description = $_POST['description'] ?? '';
                $status = $_POST['statusBrand'] ?? '';
                $status = $status === '0' || $status === '1' ? $status : 0;

                // ko bat nguoi dung phai upload logo nhu phan tao moi thuong hieu (ko sua lai logo)
                $oldLogo = $infoBrand['logo'];
                $checkUpload = null;
                if(!empty($_FILES['logoBrand']['name'])){
                    // nguoi dung muon thay doi logo thuong hieu
                    $newLogo = File::uploadFileToServer($_FILES['logoBrand'],PATH_UPLOAD_BRAND_LOGO);
                    if($newLogo !== false){
                        $checkUpload = true; // thuc su co upload logo moi
                    }
                } else {
                    $newLogo = $oldLogo;
                }
                // validations data
                $validations = validationBandData($nameBrand, $newLogo);
                /// check data
                $flagCheck = true; // thong bao loi
                foreach ($validations as $val) {
                    if(!empty($val)){
                        $flagCheck = false;
                        break;
                    }
                }

                if($flagCheck){
                    // ko co loi nhap du lieu tu nguoi dung
                    // xoa bo session loi neu co
                    if(isset($_SESSION['editBrands'])){
                        unset($_SESSION['editBrands']);
                    }
                    // kiem tra ten thuong hieu muon thay doi khong trung voi nhung ten thuong hieu khac trong database tru chinh no (chinh ten thuong hieu day)
                    $existsName = $this->brandModel->checkExistsEditNameBrand($nameBrand, $id);
                    if($existsName) {
                        // loi nguoi dung nhap trung ten thuong hieu can sua
                        $_SESSION['nameBrandExists'] = $nameBrand;
                        // xoa anh upload neu co (neu nhu nguoi dung co upload logo moi thi moi xoa)
                        if($checkUpload){
                            File::deleteFileServer($newLogo, PATH_UPLOAD_BRAND_LOGO);
                        }
                        // quay ve form edit
                        header("Location:index.php?c=brand&m=edit&id={$id}&state=exists");
                    } else {
                        // xoa session loi trung ten thuong hieu
                        if(isset($_SESSION['nameBrandExists'])){
                            unset($_SESSION['nameBrandExists']);
                        }
                        // oke - tien hanh update data
                        $update = $this->brandModel->updateDataBrand($nameBrand, $slug, $newLogo, $status, $description, $id);
                        if($update){
                            // thanh cong quay ve trang list brands
                            header("Location:index.php?c=brand");
                        } else {
                            // loi ko update - quay ve trang form edit
                            // xoa anh upload neu co (neu nhu nguoi dung co upload logo moi thi moi xoa)
                            if($checkUpload){
                                File::deleteFileServer($newLogo, PATH_UPLOAD_BRAND_LOGO);
                            }
                            header("Location:index.php?c=brand&m=edit&id={$id}&state=fail");
                        }
                    }
                } else {
                    // co loi nhap du lieu tu nguoi dung
                    // gan loi vao session
                    $_SESSION['editBrands'] = $validations;
                    // xoa anh upload neu co (neu nhu nguoi dung co upload logo moi thi moi xoa)
                    if($checkUpload){
                        File::deleteFileServer($newLogo, PATH_UPLOAD_BRAND_LOGO);
                    }
                    // quay ve form edit
                    header("Location:index.php?c=brand&m=edit&id={$id}&state=error");
                }

            } else {
                // quay ve lai form Edit
                header("Location:index.php?c=brand&m=edit&id={$id}&state=empty");
            }
        }
    }

    public function delete()
    {
        // phuong thuc nay chi chap nhan request ajax gui len
        if(isRequestAjax()){
            // xu ly
            $id = $_POST['idBrand'] ?? '';
            $id = is_numeric($id) && $id > 0 ? $id : 0;
            if($id !== 0){
                // hop le
                // viet model de xoa thuong hieu theo id
                $info     = $this->brandModel->getDataBrandById($id);
                $nameLogo = $info['logo'] ?? '';
                $del = $this->brandModel->deleteBrandById($id);
                if($del){
                    // xoa bo anh
                    if(!empty($nameLogo)){
                        File::deleteFileServer($nameLogo, PATH_UPLOAD_BRAND_LOGO);
                    }
                    echo "OK";
                } else {
                    echo "FAIL";
                }
            } else {
                echo "ERROR";
            }
        }
    }
}