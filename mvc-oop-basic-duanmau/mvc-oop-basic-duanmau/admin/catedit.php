<?php
// Khởi động output buffering để tránh lỗi header
ob_start();

include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/category.php';

$cat = new category();

// Kiểm tra catId
if (!isset($_GET['catId']) || $_GET['catId'] == NULL) {
    header("Location: catlist.php");
    exit();
} else {
    $id = $_GET['catId'];
}

$updateCat = null;

// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $catName = $_POST['catName'];
    $updateCat = $cat->update_category($catName, $id);

    if ($updateCat === 'success') {
        header("Location: catlist.php"); // Chuyển hướng sau khi update
        exit();
    }
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa danh mục</h2>
        <div class="block copyblock"> 

            <?php
            if ($updateCat && $updateCat !== 'success') {
                echo "<span style='color: red;'>$updateCat</span>";
            }

            $get_cate_name = $cat->getCategoryById($id);
            if ($get_cate_name) {
                $result = $get_cate_name->fetch_assoc();
            ?>

            <form action="" method="post">
                <table class="form">					
                    <tr>
                        <td>
                            <input type="text" value="<?php echo htmlspecialchars($result['catName']) ?>" name="catName" placeholder="Edit danh mục sản phẩm" class="medium" required />
                        </td>
                    </tr>
                    <tr> 
                        <td>
                            <input type="submit" name="submit" value="Update" />
                        </td>
                    </tr>
                </table>
            </form>

            <?php } else {
                echo "<span style='color: red;'>Không tìm thấy danh mục.</span>";
            } ?>

        </div>
    </div>
</div>

<?php 
include 'inc/footer.php';
// Kết thúc output buffering
ob_end_flush();
?>
