<?php

namespace app\libs;

class Pagination
{
    const ROOT_PAGE  = 'index.php';
    const LIMIT_PAGE = 2; // so luong data tren 1 trang

    // viet method de tao link phan trang
    public static function createLink($data = [])
    {
        /**
        [
            'c' => 'brand', // bat buoc
            'm' => 'index, // bat buoc
            'page' => {page}, // bat buoc
            's' => "$keyword" // ko bat buoc
        ]
        **/
        
        // index.php?c=brand&m=index&page=1&s=abc
        $link = '';
        foreach ($data as $key => $val) {
            $link .= (empty($link)) ? "?{$key}={$val}" : "&{$key}={$val}";
            // ?c=brand&m=index&page=1&s=abc
        }
        return self::ROOT_PAGE.$link; // // index.php?c=brand&m=index&page=1&s=abc
    }

    public static function paginate($link, $totalRecords, $page, $limit = self::LIMIT_PAGE, $keyword = '')
    {
        $totalPage = ceil($totalRecords / $limit); // ceil : lam tron so len
        // page = 1; min
        // max : page = $totalPage
        if($page < 1){
            $page = 1;
        } elseif($page > $totalPage) {
            $page = $totalPage;
        }
        $start = ($page - 1) * $limit; // vi tri lay du lieu trong database : xuat phat tu 0

        // tao template phan trang Bootstrap v5.1.3
        // tao 1 mot chuoi chua cac ma html phan trang theo bootstrap v5.1.
        $htmlPage = '';
        $htmlPage .= '<nav>';
        // se tiep tuc xu ly o buoi sau.
        $htmlPage .= '</nav>';

        return [
            'start' => $start,
            'limit' => $limit,
            'htmlPage' => $htmlPage
        ];
    }
}