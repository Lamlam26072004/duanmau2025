<?php
require_once '../lib/database.php';
require_once '../helpers/format.php';
?>
<?php
       class brand 
{
    private $db;
    private $fm;
    
    public function __construct()  
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function insert_brand($brandName) 
    {
        $brandName = $this->fm->validation($brandName);
        $brandName = mysqli_real_escape_string($this->db->link, $brandName);

        if (empty($brandName)) {
            $alert = "<span class='error'>Brand must not be empty!</span>";
            return $alert;
        } else {
            $query = "INSERT INTO tbl_brand(brandName) VALUES('$brandName')";
            $result = $this->db->insert($query);
            if ($result) {
                $alert = "<span class='success'>Brand Inserted Successfully!</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Brand Not Inserted!</span>";
                return $alert;
            }
        }
    }
        public function show_brand()
        {
            $query = "SELECT * FROM tbl_brand ORDER BY brandId DESC";
            $result = $this->db->select($query);
            return $result;
        }
      public function getBrandById($id) {
    $query = "SELECT * FROM tbl_brand WHERE brandId = '$id'";
    return $this->db->select($query);
}
      public function update_brand($brandName, $id) {
    $brandName = $this->fm->validation($brandName);
    $brandName = mysqli_real_escape_string($this->db->link, $brandName);
    $id = mysqli_real_escape_string($this->db->link, $id);

    if (empty($brandName)) {
        return "Tên thương hiệu không được để trống!";
    } else {
        $query = "UPDATE tbl_brand SET brandName = '$brandName' WHERE brandId = '$id'";
        $result = $this->db->update($query);
        if ($result) {
            return 'success';
        } else {
            return "Cập nhật thương hiệu thất bại!";
        }
    }
}

public function delete_brand($id)
{
    $query = "DELETE FROM tbl_brand WHERE brandId = '$id'";
    $result = $this->db->delete($query);

    if ($result) {
        $alert = "<span class='success'>Xóa thương hiệu thành công</span>";
        return $alert;
    } else {
        $alert = "<span class='error'>Xóa không thành công</span>";
        return $alert;
    }
}


            }
     
?>