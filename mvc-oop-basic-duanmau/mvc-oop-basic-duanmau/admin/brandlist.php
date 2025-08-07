<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/brand.php'; ?>

<?php 
    $brand = new brand();

    if (isset($_GET['brandId'])) {
        $id = $_GET['brandId'];
        $delbrand = $brand->delete_brand($id); // Đổi $cat -> $brand
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Brand List</h2>
        <div class="block">  

            <?php
                if (isset($delbrand)) {
                    echo $delbrand;
                }
            ?>       

            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>Brand Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $show_brand = $brand->show_brand();
                        if ($show_brand) {
                            $i = 0;
                            while ($result = $show_brand->fetch_assoc()) {
                                $i++;
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $i ;?></td>
                        <td><?php echo $result['brandName'] ?></td>
                        <td>
                            <a href="brandedit.php?brandId=<?php echo $result['brandId']?>">Edit</a> || 
                            <a onclick="return confirm('Bạn có chắc chắn muốn xóa?')" href="?brandId=<?php echo $result['brandId']?>">Delete</a>
                            <!-- Đổi catId -> brandId -->
                        </td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
