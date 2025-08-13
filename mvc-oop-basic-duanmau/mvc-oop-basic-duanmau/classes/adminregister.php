<?php

include '../lib/database.php';
 // nếu bạn đã include file DB ở nơi khác thì bỏ dòng này

class adminregister {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

public function register_admin($adminName, $adminEmail, $adminUser, $adminPass)
{
    $adminName = mysqli_real_escape_string($this->db->link, $adminName);
    $adminEmail = mysqli_real_escape_string($this->db->link, $adminEmail);
    $adminUser = mysqli_real_escape_string($this->db->link, $adminUser);
    $adminPass = mysqli_real_escape_string($this->db->link, md5($adminPass));

    if(empty($adminName) || empty($adminEmail) || empty($adminUser) || empty($adminPass)) {
        return "<span class='error'>Không được để trống</span>";
    } else {
        // Kiểm tra user đã tồn tại chưa
        $check_user = "SELECT * FROM tbl_admin WHERE adminUser = '$adminUser' LIMIT 1";
        $result = $this->db->select($check_user);

        if($result) {
            return "<span class='error'>Tài khoản đã tồn tại</span>";
        } else {
            $query = "INSERT INTO tbl_admin(adminName, adminEmail, adminUser, adminPass, lever) 
                      VALUES('$adminName', '$adminEmail', '$adminUser', '$adminPass', 0)";
            $insert_result = $this->db->insert($query);
            
            if($insert_result) {
                // Chuyển hướng về trang đăng nhập
                header("Location: login.php");
                exit();
            } else {
                return "<span class='error'>Đăng ký không thành công</span>";
            }
        }
    }
}
public function show_users() {
    $query = "SELECT adminId, adminUser, adminEmail, level FROM tbl_admin";
    $result = $this->db->select($query);
    return $result;
}

}
