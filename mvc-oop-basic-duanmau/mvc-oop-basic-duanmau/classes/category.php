<?php
include '../lib/database.php';
include '../helpers/format.php';
?>
<?php
    class category 
     {
        private $db;
        private $fm;
        
        public function __construct()  
        {
            $this->db = new Database();
            $this->fm = new Format();

        }
        public function insert_category($catName) 
        {
            $catName = $this->fm->validation($catName);
            
            $catName = mysqli_real_escape_string($this->db->link, $catName);

            if (empty($catName)) {
                $alert = "<span class='error'>Category Name must not be empty!</span>";
                return $alert;
            }else {
                $query = "INSERT INTO tbl_category(catName) VALUES('$catName')";
                $result = $this->db->insert($query);
                if ($result) {
                    $alert = "<span class='success'>Category Inserted Successfully!</span>";
                    return $alert;
                }else{
                    $alert = "<span class='error'>Category Not Inserted!</span>";
                    return $alert;
                }
            }
        }
        public function show_category()
        {
            $query = "SELECT * FROM tbl_category ORDER BY catId DESC";
            $result = $this->db->select($query);
            return $result;
        }
        public function getCategoryById($id)
        {
            $query = "SELECT * FROM tbl_category WHERE catId = '$id'";
            $result = $this->db->select($query);
            return $result;
        }
       public function update_category($catName, $id)
{
    $catName = $this->fm->validation($catName);
    $catName = mysqli_real_escape_string($this->db->link, $catName);
    $id = mysqli_real_escape_string($this->db->link, $id);

    if (empty($catName)) {
        return "<span class='error'>Category Name must not be empty!</span>";
    } else {
        $query = "UPDATE tbl_category SET catName = '$catName' WHERE catId = '$id'";
        $result = $this->db->update($query);
        if ($result) {
            return "success"; // ✅ không dùng header ở đây
        } else {
            return "<span class='error'>Category Update Not Inserted!</span>";
        }
    }
}
    public function delete_category($id)
{
    $query = "DELETE FROM tbl_category WHERE catId = '$id'";    
    $result = $this->db->delete($query);
    
    if ($result) {
        $alert = "<span class='success'>Xóa danh mục thành công</span>";
        return $alert;
    } else {
        $alert = "<span class='error'>Xóa không thành công</span>";
        return $alert;  
    }
}


            }
     
?>