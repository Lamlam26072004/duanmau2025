<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/adminregister.php'; ?>
<link rel="stylesheet" type="text/css" href="css/style.css">


<?php
    $admin = new adminregister();
    $userList = $admin->show_users();
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Danh sách tài khoản</h2>
        <div class="block">
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên đăng nhập</th>
                        <th>Email</th>
                        <th>Chức vụ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($userList) {
                        $i = 0;
                        while ($result = $userList->fetch_assoc()) {
                            $i++;
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $result['adminUser']; ?></td>
                        <td><?php echo $result['adminEmail']; ?></td>
                        <td>
                            <?php 
                                if ($result['level'] == 0) {
                                    echo "Quản trị viên";
                                } else {
                                    echo "Người dùng";
                                }
                            ?>
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

<?php include 'inc/footer.php'; ?>
