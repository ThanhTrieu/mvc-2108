<?php
// day la noi tiep nhan cac request tu ben phia client gui len
// url : index.php?c=home&m=index
// c: controller
// m: phuong thuc nam trong controller

// name controller : HomeController

$pathController = "app/controller/";
$namespaceController = "app\\controller\\";

$c = ucfirst($_GET['c'] ?? 'home'); // viet hoa chu cai dau tien
$nameController = "{$c}Controller";
$fileNameController = "{$pathController}{$nameController}.php";

$m = trim($_GET['m'] ?? 'index'); // phuong thuc nam trong controller
$objectController = $namespaceController.$nameController;

if(file_exists($fileNameController)){
    // autoload controller
    $controller = new $objectController;
    // auto call method of controller
    $controller->$m();
} else {
    exit('Not Found Request');
}
