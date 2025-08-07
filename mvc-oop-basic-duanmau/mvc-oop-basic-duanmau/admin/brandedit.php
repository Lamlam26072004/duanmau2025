<?php
// Khởi động output buffering để tránh lỗi header
ob_start();

include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/brand.php';

$brand = new brand();

// Kiểm tra brandId
if (!isset($_GET['brandId']) || $_GET['brandId'] == NULL) {
    header("Location: brandlist.php");
    exit();
} else {
    $id = $_GET['brandId'];
}

$updateBrand = null;

// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $brandName = $_POST['brandName'];
    $updateBrand = $brand->update_brand($brandName, $id);

    if ($updateBrand === 'success') {
        header("Location: brandlist.php"); // Chuyển hướng sau khi update
        exit();
    }
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa thương hiệu</h2>
        <div class="block copyblock"> 

            <?php
            if ($updateBrand && $updateBrand !== 'success') {
                echo "<span style='color: red;'>$updateBrand</span>";
            }

            $get_brand_name = $brand->getBrandById($id);
            if ($get_brand_name) {
                $result = $get_brand_name->fetch_assoc();
            ?>

            <form action="" method="post">
                <table class="form">					
                    <tr>
                        <td>
                            <input type="text" value="<?php echo htmlspecialchars($result['brandName']) ?>" name="brandName" placeholder="Sửa tên thương hiệu" class="medium" required />
                        </td>
                    </tr>
                    <tr> 
                        <td>
                            <input type="submit" name="submit" value="Cập nhật" />
                        </td>
                    </tr>
                </table>
            </form>

            <?php } else {
                echo "<span style='color: red;'>Không tìm thấy thương hiệu.</span>";
            } ?>

        </div>
    </div>
</div>

<?php 
include 'inc/footer.php';
// Kết thúc output buffering
ob_end_flush();
?>
