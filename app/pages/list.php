<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "รายการหน้าข่าวสาร";
$active = 'pages';
$subactive = 'list';
$pages_list = get_pages();
//if(!isset($total))redirect("/admin/index");
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    do_delete($_GET['pages_id']);
}else if (isset($_GET['action']) && $_GET['action'] == 'enabled') {
    do_enabled($_GET['pages_id']);
    //var_dump($userlist);
} else if (isset($_GET['action']) && $_GET['action'] == 'disabled') {
    do_disabled($_GET['pages_id']);
    //var_dump($userlist);
}
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
                รายการหน้าข่าวสาร
                <small>ข่าวสาร</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">หน้าข่าวสาร</a></li>
                <li class="active">รายการ</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <?php show_message() ?> 
                <div class="box-header">
                    <h3 class="box-title">รายการหน้าข่าวสาร</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                    <table id="data" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อเรื่อง</th>
                                <th>วันที่</th>
                                <th>แสดงหน้าแรก</th>
                                <th>ผู้ตีพิมพ์</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($pages_list as $pages) :
                                ?>                            
                                <tr>
                                    <td><?php echo $pages['pages_id'];; ?></td>
                                    <td><?php echo $pages['pages_title']; ?></td>
                                    <td><?php echo $pages['published_date']; ?></td>
                                    <td><?php echo $pages['frontpage']; ?></td>
                                    <td><?php echo $pages['fname']; ?></td>
                                    <td class="text-center">
                                        <?php if ($pages['status'] == 'Y') : ?>
                                            <a href="<?php echo site_url('app/pages/list') . '&action=disabled&pages_id=' . $pages['pages_id']; ?>" class="btn btn-success btn-sm">
                                                <span class="glyphicon glyphicon-ok-circle"></span>
                                            </a> 
                                        <?php else: ?>
                                            <a href="<?php echo site_url('app/pages/list') . '&action=enabled&pages_id=' . $pages['pages_id']; ?>" class="btn btn-danger btn-sm" >
                                                <span class="glyphicon glyphicon-ban-circle"></span>
                                            </a> 
                                        <?php endif; ?>
                                        <a href="<?php echo site_url('app/pages/list') . '&action=delete&pages_id=' . $pages['pages_id']; ?>" class="btn btn-warning btn-sm  delete">
                                            <span class="glyphicon glyphicon-remove-circle"></span>
                                        </a> 
                                        <a href="<?php echo site_url('app/pages/edit') . '&action=edit&pages_id=' . $pages['pages_id']; ?>" class="btn btn-info btn-sm">
                                            <span class="glyphicon glyphicon-edit "></span>
                                        </a>                      
<!--                                        <a href="<?php echo site_url('app/pages/list') . '&action=delete&pages_id=' . $pages['pages_id']; ?>" class="delete"><i class="fa fa-remove"></i></a> | 
                                        <a href="<?php echo site_url('app/pages/edit') . '&action=edit&pages_id=' . $pages['pages_id']; ?>" ><i class="fa fa-edit"></i></a>-->
<!--                                        <a href="#" class="delete"> <i class="fa fa-remove"></i></a> | 
                                        <a href="#" ><i class="fa fa-edit"></i></a>-->
                                    </td>                    
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อเรื่อง</th>
                                <th>วันที่</th>
                                <th>แสดงหน้าแรก</th>
                                <th>ผู้ตีพิมพ์</th>
                                <th>จัดการ</th>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
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

function get_pages() {
    global $db;
//    $start = $page * $limit;
    $query = "SELECT p.*,u.fname FROM pages As p,user As u WHERE p.user_id = u.user_id ORDER BY STR_TO_DATE(p.published_date, '%M %d, %Y') DESC;";
    $result = mysqli_query($db, $query);
    $pages_list = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $pages_list[] = $row;
    }
    return $pages_list;
}

function get_total() {
    global $db;
//    $val = $group."%";
    $query = "SELECT * FROM pages ";
    $result = mysqli_query($db, $query);
    return mysqli_num_rows($result);
}

function do_delete($pages_id) {
    global $db;
    if (empty($pages_id)) {
        set_err('ค่าพารามิเตอร์ไม่ถูกต้อง');
        redirect('app/pages/list');
    }
    $query = "DELETE FROM pages WHERE pages_id =" . pq($pages_id);
    mysqli_query($db, $query);
    if (mysqli_affected_rows($db)) {
        set_info('ลบข้อมูลสำเร็จ');
    }
    redirect('app/pages/list');
}
function do_disabled($pages_id) {
    global $db;
    $query = "UPDATE pages SET status='N' WHERE pages_id = " . pq($pages_id);
//        var_dump($query);
//    die();
    $result = mysqli_query($db, $query);
    if (mysqli_affected_rows($db) > 0) {
        set_info('ปิดการแสดงผลสำเร็จ');
    } else {
        set_err($query);
    }
    redirect('app/pages/list');
}
function do_enabled($pages_id) {
    global $db;
    $query = "UPDATE pages SET status='Y' WHERE pages_id = " . pq($pages_id);
//        var_dump($query);
//    die();
    $result = mysqli_query($db, $query);
    if (mysqli_affected_rows($db) > 0) {
        set_info('เปิดการแสดงผลสำเร็จ');
    } else {
        set_err($query);
    }
    redirect('app/pages/list');
}
