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
        $htmlPage .= '<ul class="pagination justify-content-center">';
        // xu ly back page - Previous
        if($page > 1){
            $htmlPage .= '<li class="page-item">';
            $htmlPage .= '<a class="page-link" href="'.str_replace('{page}', $page - 1, $link).'">Previous</a>';
            $htmlPage .= '</li>';
        }
        // xu ly cac trang o giua
        for($i = 1; $i <= $totalPage; $i++) {
            if($i == $page){
                // nguoi dang o trang hien tai
                $htmlPage .= '<li class="page-item active" aria-current="page">';
                $htmlPage .= '<a class="page-link">'.$page.'</a>';
                $htmlPage .= '</li>';
            } else {
                $htmlPage .= '<li class="page-item"><a class="page-link" href="'.str_replace('{page}', $i, $link).'">'.$i.'</a></li>';
            }
        }
        // xu ly next page
        if($page < $totalPage){
            $htmlPage .= '<li class="page-item"><a class="page-link" href="'.str_replace('{page}', $page + 1, $link).'">Next</a></li>';
        }

        $htmlPage .= '</ul>';
        $htmlPage .= '</nav>';

        return [
            'start' => $start,
            'limit' => $limit,
            'htmlPage' => $htmlPage
        ];
    }
}