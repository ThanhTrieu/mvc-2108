<?php

namespace app\model;

use app\database\Database as Model;
use PDO;
class Product extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getListProducts()
    {
        $data = [];
        $sql = "SELECT * FROM productions";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            // trong cau lenh sql khong co tham so - nen ko can kiem tra
            if($stmt->execute()){
                if($stmt->rowCount() > 0){
                    // cau lenh sql ben tren se tra ve nhieu data
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    // fetchAll : lay nhieu dong du lieu
                }
                $stmt->closeCursor();
            }
        }
        return $data;
    }
}