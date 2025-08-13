<?php

$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/database.php');
include_once ($filepath.'/../helpers/format.php');
?>
<?php
class product 
{
    private $db;
    private $fm;
    
    public function __construct()  
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function insert_product($data, $files) 
    {
        $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
        $category = mysqli_real_escape_string($this->db->link, $data['category']);
        $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
        $product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
        $price = mysqli_real_escape_string($this->db->link, $data['price']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);

        $permitted = ['jpg', 'jpeg', 'png', 'gif'];

        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;

        if ($productName=="" || $category=="" || $brand=="" || $product_desc=="" || $price=="" || $type=="" || $file_name=="") {
            return "<span class='error'>Fields must not be empty!</span>";
        } else {
            move_uploaded_file($file_temp, $uploaded_image);
            $query = "INSERT INTO tbl_product(productName,catId,brandId,product_desc,price,type,image) 
                      VALUES('$productName','$category','$brand','$product_desc','$price','$type','$unique_image')";
            $result = $this->db->insert($query);
            if ($result) {
                return "<span class='success'>Inserted product Successfully!</span>";
            } else {
                return "<span class='error'>Product Not Inserted!</span>";
            }
        }
    }

    public function show_product() {
        $query = "
            SELECT 
                tbl_product.*, 
                tbl_category.catName, 
                tbl_brand.brandName
            FROM tbl_product
            INNER JOIN tbl_category 
                ON tbl_product.catId = tbl_category.catId
            INNER JOIN tbl_brand 
                ON tbl_product.brandId = tbl_brand.brandId
            ORDER BY tbl_product.productId DESC
        ";
        return $this->db->select($query);
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM tbl_product WHERE productId = '$id'";
        return $this->db->select($query);
    }

    public function update_product($data, $files, $id)
    {
        $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
        $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
        $category = mysqli_real_escape_string($this->db->link, $data['category']);
        $product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
        $price = mysqli_real_escape_string($this->db->link, $data['price']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);

        $permitted = ['jpg', 'jpeg', 'png', 'gif'];
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;

        if ($productName=="" || $brand=="" || $category=="" || $product_desc=="" || $price=="" || $type=="") {
            return "<span class='error'>Fields must not be empty</span>";
        } else {
            if (!empty($file_name)) {
                if ($file_size > 20480) {
                    return "<span class='error'>Image Size should be less than 2MB!</span>";
                } elseif (!in_array($file_ext, $permitted)) {
                    return "<span class='error'>You can upload only: ".implode(', ', $permitted)."</span>";
                }
                move_uploaded_file($file_temp, $uploaded_image);
                $query = "UPDATE tbl_product SET
                            productName = '$productName',
                            brandId = '$brand',
                            catId = '$category',
                            type = '$type',
                            price = '$price',
                            image = '$unique_image',
                            product_desc = '$product_desc'
                          WHERE productId = '$id'";
            } else {
                $query = "UPDATE tbl_product SET
                            productName = '$productName',
                            brandId = '$brand',
                            catId = '$category',
                            type = '$type',
                            price = '$price',
                            product_desc = '$product_desc'
                          WHERE productId = '$id'";
            }

            $result = $this->db->update($query);
            if ($result) {
                return "<span class='success'>Product Updated Successfully</span>";
            } else {
                return "<span class='error'>Product Update Not Successful</span>";
            }
        }
    }

    public function delete_product($id)
    {
        $query = "DELETE FROM tbl_product WHERE productId = '$id'";    
        $result = $this->db->delete($query);
        
        if ($result) {
            return "<span class='success'>Xóa product thành công</span>";
        } else {
            return "<span class='error'>Xóa product không thành công</span>";  
        }
    }



    // forn end 
    public function getFeaturedProducts() {
        $query = "SELECT * FROM tbl_product WHERE type='0' ORDER BY productId DESC LIMIT 4";
        return $this->db->select($query);
    }
    public function getNewProducts() {
        $query = "SELECT * FROM tbl_product  ORDER BY productId DESC LIMIT 4";
        return $this->db->select($query);
    }
    public function get_details($id) {
    $query = "SELECT p.*, c.catName, b.brandName 
              FROM tbl_product p
              INNER JOIN tbl_category c ON p.catId = c.catId
              INNER JOIN tbl_brand b ON p.brandId = b.brandId
              WHERE p.productId = '$id' LIMIT 1";
    return $this->db->select($query);
}

} 
?>
