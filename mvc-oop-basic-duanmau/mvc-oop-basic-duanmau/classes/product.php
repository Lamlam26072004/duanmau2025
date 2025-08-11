<?php
require_once '../lib/database.php';
require_once '../helpers/format.php';
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

             // Các định dạng file được phép
            $permitted = ['jpg', 'jpeg', 'png', 'gif'];

// Lấy thông tin file upload
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

// Lấy phần mở rộng của file (extension)
            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));

// Tạo tên file duy nhất để tránh trùng
            $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;

// Đường dẫn lưu file upload
            $uploaded_image = "uploads/" . $unique_image;

            


            if ($productName=="" || $category=="" || $brand=="" || $product_desc=="" || $price=="" || $type=="" || $file_name=="") {
                $alert = "<span class='error'>Fiels must not be empty!</span>";
                return $alert;
            }else {
                move_uploaded_file($file_temp, $uploaded_image);
                $query = "INSERT INTO tbl_product(productName,catId,brandId,product_desc,price,type,image) VALUES('$productName','$category','$brand','$product_desc','$price','$type','$unique_image')";
                $result = $this->db->insert($query);
                if ($result) {
                    $alert = "<span class='success'>Inserted product Successfully!</span>";
                    return $alert;
                }else{
                    $alert = "<span class='error'>Product Not Inserted!</span>";
                    return $alert;
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
        order by tbl_product.productId desc
    ";

    $result = $this->db->select($query);
    return $result;
}

        public function getProductById($id)
        {
            $query = "SELECT * FROM tbl_product WHERE productId = '$id'";
            $result = $this->db->select($query);
            return $result;
        }
//        public function update_category($catName, $id)
// {
//     $catName = $this->fm->validation($catName);
//     $catName = mysqli_real_escape_string($this->db->link, $catName);
//     $id = mysqli_real_escape_string($this->db->link, $id);

//     if (empty($catName)) {
//         return "<span class='error'>Category Name must not be empty!</span>";
//     } else {
//         $query = "UPDATE tbl_category SET catName = '$catName' WHERE catId = '$id'";
//         $result = $this->db->update($query);
//         if ($result) {
//             return "success"; // ✅ không dùng header ở đây
//         } else {
//             return "<span class='error'>Category Update Not Inserted!</span>";
//         }
//     }
// }
//     public function delete_category($id)
// {
//     $query = "DELETE FROM tbl_category WHERE catId = '$id'";    
//     $result = $this->db->delete($query);
    
//     if ($result) {
//         $alert = "<span class='success'>Xóa danh mục thành công</span>";
//         return $alert;
//     } else {
//         $alert = "<span class='error'>Xóa không thành công</span>";
//         return $alert;  
//     }
// }


            }
     
?>