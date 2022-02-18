<?php

namespace app\model;

use app\database\Database as Model;
use PDO;

class Brand extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertBrands($nameBrand, $slug, $logo, $description)
    {
        $status = 1;
        $deletedAt = null;
        $updatedAt = null;
        $createdAt = date('Y-m-d H:i:s');
        $flagCheck = false; // insert thanh cong hay ko
        $sql = "INSERT INTO `brands`(`name`,`slug`,`status`,`logo`,`descriptions`,`deleted_at`,`created_at`,`updated_at`) VALUES (:nameBrand, :slug, :statusBrand, :logo, :descriptions, :deleted_at, :created_at, :updated_at)";

        $stmt = $this->db->prepare($sql);
        if($stmt){
            $stmt->bindParam(':nameBrand', $nameBrand, PDO::PARAM_STR);
            $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
            $stmt->bindParam(':statusBrand', $status, PDO::PARAM_INT);
            $stmt->bindParam(':logo', $logo, PDO::PARAM_STR);
            $stmt->bindParam(':descriptions', $description, PDO::PARAM_STR);
            $stmt->bindParam(':deleted_at', $deletedAt, PDO::PARAM_STR);
            $stmt->bindParam(':created_at', $createdAt, PDO::PARAM_STR);
            $stmt->bindParam(':updated_at', $updatedAt, PDO::PARAM_STR);
            if($stmt->execute()){
                $flagCheck = true;
                $stmt->closeCursor();
            }
        }
        return $flagCheck;
    }

    public function checkExistsNameBrand($nameBrand)
    {
        $flagCheck = false;
        $sql = "SELECT `id`,`name` FROM `brands` WHERE `name` = :nameBrand";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            $stmt->bindParam(':nameBrand', $nameBrand, PDO::PARAM_STR);
            if($stmt->execute()){
                if($stmt->rowCount() > 0){
                    $flagCheck = true;
                }
                $stmt->closeCursor();
            }
        }
        return $flagCheck;
    }
}