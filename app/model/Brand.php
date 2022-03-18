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

    public function getAllDataBrandsByPaging($start, $limit, $key = '')
    {
        $data = [];
        $keyword = "%{$key}%";
        if(empty($key)){
            $sql = "SELECT `id`,`name`,`slug`,`status`,`logo` FROM `brands` LIMIT :startRow, :limitRow";
        } else {
            $sql = "SELECT `id`,`name`,`slug`,`status`,`logo` FROM `brands` WHERE `name` LIKE :keyword LIMIT :startRow, :limitRow";
        }
        
        $stmt = $this->db->prepare($sql);
        if($stmt) {
            if(!empty($key)) {
                $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            }
            $stmt->bindParam(':startRow', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limitRow', $limit, PDO::PARAM_INT);
            
            if($stmt->execute()) {
                if($stmt->rowCount() > 0) {
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                $stmt->closeCursor();
            }
        }
        return $data;
    }

    public function getDataBrandById($id = 0)
    {
        $data = []; // mang don
        $sql  = "SELECT `id`,`name`,`slug`,`status`,`logo`,`descriptions` FROM `brands` WHERE `id` = :id";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if($stmt->execute()){
                if($stmt->rowCount() > 0){
                    $data = $stmt->fetch(PDO::FETCH_ASSOC); // mang 1 chieu
                }
                $stmt->closeCursor();
            }
        }
        return $data;
    }

    public function getAllDataBrands($key = '')
    {
        $data = [];
        $keyword = "%{$key}%";
        if(empty($key)){
            $sql = "SELECT `id`,`name`,`slug`,`status`,`logo` FROM `brands`";
        } else {
            $sql = "SELECT `id`,`name`,`slug`,`status`,`logo` FROM `brands` WHERE `name` LIKE :keyword ";
        }
        
        $stmt = $this->db->prepare($sql);
        if($stmt) {
            if(!empty($key)) {
                $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            }
            if($stmt->execute()) {
                if($stmt->rowCount() > 0) {
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                $stmt->closeCursor();
            }
        }
        return $data;
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

    public function checkExistsEditNameBrand($name, $id)
    {
        $flagCheck = false;
        $sql = "SELECT `id`,`name` FROM `brands` WHERE `name` = :nameBrand AND `id` <> :id";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            $stmt->bindParam(':nameBrand', $name, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if($stmt->execute()){
                if($stmt->rowCount() > 0){
                    $flagCheck = true;
                }
                $stmt->closeCursor();
            }
        }
        return $flagCheck;
    }

    public function updateDataBrand($name, $slug, $logo, $status, $description, $id)
    {
        $flagCheck = false;
        $updatedAt = date('Y-m-d H:i:s');
        $sql = "UPDATE `brands` SET `name` = :nameBrand, `slug` = :slug, `status` = :statusBrand, `logo` = :logo, `descriptions` = :descriptions, `updated_at` = :updated_at WHERE `id` = :id";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            $stmt->bindParam(':nameBrand', $name, PDO::PARAM_STR);
            $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
            $stmt->bindParam(':statusBrand', $status, PDO::PARAM_INT);
            $stmt->bindParam(':logo', $logo, PDO::PARAM_STR);
            $stmt->bindParam(':descriptions', $description, PDO::PARAM_STR);
            $stmt->bindParam(':updated_at', $updatedAt, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if($stmt->execute()){
                $flagCheck = true;
                $stmt->closeCursor();
            }
        }
        return $flagCheck;
    }

    public function deleteBrandById($id)
    {
        $flagCheck = false;
        $sql = "DELETE FROM `brands` WHERE `id` = :id";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if($stmt->execute()){
                $flagCheck = true;
                $stmt->closeCursor();
            }
        }
        return $flagCheck;
    }
}