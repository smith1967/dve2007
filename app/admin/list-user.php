<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "ผู้ดูแลระบบ";
$active = 'app/admin';
$subactive = 'list-user';

if (isset($_GET['action']) && $_GET['action'] == 'list') {
//    $page = isset($_GET['page']) ? $_GET['page'] : 0;
//    $action = isset($_GET['action']) ? $_GET['action'] : "list";
//    $params = array(
//        'action' => $action,
//    );
//    $params = http_build_query($params);
    $userslist = get_user_signup($page);
//    $total = get_total();
//    $url = site_url('app/admin/list-user&') . $params;
    //var_dump($userlist);
} else if (isset($_GET['action']) && $_GET['action'] == 'enabled') {
    do_enabled($_GET['user_id']);
    //var_dump($userlist);
} else if (isset($_GET['action']) && $_GET['action'] == 'disabled') {
    do_disabled($_GET['user_id']);
    //var_dump($userlist);
} else if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    do_delete($_GET['user_id']);
    //var_dump($userlist);
} else {
//    $page = isset($_GET['page']) ? $_GET['page'] : 0;
//    $action = isset($_GET['action']) ? $_GET['action'] : "list";
//    $params = array(
//        'action' => $action,
//    );
//    $params = http_build_query($params);
    $userslist = get_user($page);
//    $total = get_total();
//    $url = site_url('app/admin/list-user&') . $params;
}

//if (!isset($total))
//    redirect("app/admin/index");
?>
<?php require_once 'template/header.php'; ?>
<div class="wrapper">
    <?php require_once 'template/main-header.php'; ?>
    <?php require_once 'template/main-sidebar.php'; ?> 
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                รายชื่อผู้ใช้งาน
                <small>ผู้ใช้งาน</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">ผู้ดูแลระบบ</a></li>
                <li class="active">รายชื่อ</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <?php show_message() ?> 
                <div class="box-header">
                    <h3 class="box-title">รายชื่อผู้ใช้งาน</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="data" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>รหัส</th>
                                <th>ชื่อผู้ใช้</th>
                                <th>ชื่อ-นามสกุล</th>
                                <!--<th>Last Na</th>-->
                                <th>ประเภทผู้ใช้งาน</th>
                                <th>กระทำการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($userslist as $user) :
                                ?>                            
                                <tr>
                                    <td><?php echo $user['user_id'] ?></td>
                                    <td><?php echo $user['username'] ?></td>
                                    <td><?php echo $user['fname'] . " " . $user['lname'] ?></td>
                                    <!--<td><?php echo $user['lname'] ?></td>-->
                                    <td><?php echo $user['user_type_id'] ?></td>
                                    <td>
                                        <?php if ($user['status'] == 'Y') : ?>
                                            <a href="<?php echo site_url('app/admin/list-user') . '&action=disabled&user_id=' . $user['user_id']; ?>" class="btn btn-success btn-sm">
                                                <span class="glyphicon glyphicon-ok-circle"></span>
                                            </a> 
                                        <?php else: ?>
                                            <a href="<?php echo site_url('app/admin/list-user') . '&action=enabled&user_id=' . $user['user_id']; ?>" class="btn btn-danger btn-sm" >
                                                <span class="glyphicon glyphicon-ban-circle"></span>
                                            </a> 
                                        <?php endif; ?>
                                        <a href="<?php echo site_url('app/admin/list-user') . '&action=delete&user_id=' . $user['user_id']; ?>" class="btn btn-warning btn-sm  delete">
                                            <span class="glyphicon glyphicon-remove-circle"></span>
                                        </a> 
                                        <a href="<?php echo site_url('app/admin/edit-user') . '&action=edit&user_id=' . $user['user_id']; ?>" class="btn btn-info btn-sm">
                                            <span class="glyphicon glyphicon-edit "></span>
                                        </a>                      
                                    </td>                    
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>รหัส</th>
                                <th>ชื่อผู้ใช้</th>
                                <th>ชื่อ-นามสกุล</th>
                                <!--<th>Last Na</th>-->
                                <th>ประเภทผู้ใช้งาน</th>
                                <th>กระทำการ</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php require_once 'template/main-footer.php'; ?>    
</div>
<!--.wrapper-->
<?php require_once 'template/footer.php'; ?>
<script>
    $(document).ready(function () {
        $('#data').DataTable({
            "language": {
                "lengthMenu": "แสดง _MENU_ แถวต่อหน้า",
                "zeroRecords": "ไม่มีข้อมูล",
                "info": "กำลังแสดงข้อมูล _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                "search": "ค้นหา:",
                "infoEmpty": "ไม่มีข้อมูลแสดง",
                "infoFiltered": "(ค้นหาจาก _MAX_ total records)",
                "paginate": {
                    "first": "หน้าแรก",
                    "last": "หน้าสุดท้าย",
                    "next": "หน้าต่อไป",
                    "previous": "หน้าก่อน"
                }
            }
        });
    });
</script>
<script>
    $('.delete').click(function () {
        return confirm('ยืนยันลบข้อมูล')
    });
</script>
<?php

function get_user_signup($page = 0, $limit = 20) {
    global $db;
    $start = $page * $limit;
    $val = $group . "%";
    $query = "SELECT * FROM user WHERE status LIKE 'N' ORDER BY user_id LIMIT " . $start . "," . $limit;
    $result = mysqli_query($db, $query);
    $userlist = array();
    while ($row = mysqli_fetch_array($result)) {
        $userlist[] = $row;
    }
    return $userlist;
}

function get_user($page = 0, $limit = 10) {
    global $db;
    $start = $page * $limit;
    $query = "SELECT * FROM user LIMIT " . $start . "," . $limit;
    $result = mysqli_query($db, $query);
    $userlist = array();
    while ($row = mysqli_fetch_array($result)) {
        $userlist[] = $row;
    }
    return $userlist;
}

function get_total() {
    global $db;
    $query = "SELECT * FROM user WHERE status = 'N'";
    $result = mysqli_query($db, $query);
    return mysqli_num_rows($result);
}

function get_users_total($group) {
    global $db;
    $val = $group . "%";
    $query = "SELECT * FROM users WHERE groupname LIKE " . pq($val);
    $result = mysqli_query($db, $query);
    return mysqli_num_rows($result);
}

function do_enabled($user_id) {
    global $db;
    $query = "UPDATE user SET status='Y' WHERE user_id = " . pq($user_id);
//    var_dump($query);
//    die();
    $result = mysqli_query($db, $query);
    if (mysqli_affected_rows($db) > 0) {
        set_info('ยืนยันข้อมูลสำเร็จ');
    } else {
        set_err($query);
    }
    redirect('app/admin/list-user');
}

function do_disabled($user_id) {
    global $db;
    $query = "UPDATE user SET status='N' WHERE user_id = " . pq($user_id);
//        var_dump($query);
//    die();
    $result = mysqli_query($db, $query);
    if (mysqli_affected_rows($db) > 0) {
        set_info('ระงับการใช้งานสำเร็จ');
    } else {
        set_err($query);
    }
    redirect('app/admin/list-user');
}

function do_delete($user_id) {
    global $db;
    $query = "DELETE FROM user WHERE user_id = " . pq($user_id);
//        var_dump($query);
//    die();
    $result = mysqli_query($db, $query);
    if (mysqli_affected_rows($db) > 0) {
        set_info('ลบข้อมูลผู้ใช้สำเร็จ');
    } else {
        set_err($query);
    }
    redirect('app/admin/list-user');
}
