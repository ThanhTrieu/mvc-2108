<?php

namespace app\model;

use app\database\Database as Model;
use PDO;

class Login extends Model
{
    public function __construct()
    {
        parent::__construct();
        // su dung duoc $this->db : bien ket noi csdl
    }

    public function checkUserLogin($user, $password)
    {
        // su dung PDO de xu ly cac thao tac lam viec voi csdl
        // SQL ???
        $data = []; // du lieu lay tu ben MySQL se chuyen ve array php
        $sql = "SELECT `id`, `username`, `email`, `phone`, `fullname` FROM `admins` WHERE `username` = :user  AND `PASSWORD` = :pass";

        // :use va :pass la tham so truyen vao cau lenh sql theo cu phap cua PDO PHP
        // muc dich chong loi bao mat SQL Injection
        // kiem tra du lieu that truyen vao cau lenh sql thong qua tham so
        $stmt = $this->db->prepare($sql); // kiem tra su hop le cua string MySQL

        if($stmt){
            // Kiem tra du lieu truyen vao cau lenh sql thong qua tham so
            $stmt->bindParam(':user', $user, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $password, PDO::PARAM_STR);

            // thuc thi lenh - chay sql
            if($stmt->execute()){
                // kiem tra xem co data tra ve ko ? (cua lenh select)
                if($stmt->rowCount() > 0){
                    // co data tra ve thi lay ve thoi gan vao mang $data dang doi san
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
                    // fetch: tra ve 1 dong du lieu
                    //  PDO::FETCH_ASSOC: tra ve du lieu kieu mang php (key cua mang chinh la ten cac cot nam trong database)
                }
                $stmt->closeCursor(); // ngat viec xu ly da xong - xu ly tiep truy van cac lenh ben duoi neu co
            }
        }
        return $data;
    }
}