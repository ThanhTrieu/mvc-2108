<?php

// day root file - sau nay tat ca ung dung deu phai chay qua file index.php
require_once __DIR__ . '/vendor/autoload.php'; // autoload file

if(file_exists('route/web.php')){
    define('ROOT_PATH', 'index.php'); // duong dan root file
    require 'route/web.php';
} else {
    echo 'website dang duoc nang cap - vui long quay lai sau';
}