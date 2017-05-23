<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "สถานประกอบการ";
$active = 'business';
$subactive = 'index';
$businesslist = get_business(0, 0);
//    $total = get_total();
$url = site_url('business/list-business&') . $params;
// var_dump($businesslist);
//    exit();
$total = get_total();
//if(!isset($total))redirect("/admin/index");
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    do_delete($_GET['business_id']);
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
                รายชื่อสถานประกอบการ
                <small>สถานประกอบการ</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">สถานประกอบการ</a></li>
                <li class="active">รายชื่อ</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <?php show_message() ?> 
                <div class="box-header">
                    <h3 class="box-title">รายชื่อสถานประกอบการ</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                    <table id="business_list" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>รหัส</th>
                                <th>ชื่อสถานประกอบการ</th>
                                <th>จังหวัด</th>
                                <th>ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($businesslist as $business) :
                            ?>                            
                                <tr>
                                    <td><?php echo $business['business_id']; ?></td>
                                    <td><?php echo $business['business_name']; ?></td>
                                    <td><?php echo $business['province_name']; ?></td>
            
                                    <td class="text-center">
                                        <a href="<?php echo site_url('app/business/list') . '&action=delete&business_id=' . $business['business_id']; ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-remove"></i></a> | 
                                        <a href="<?php echo site_url('app/business/edit') . '&action=edit&business_id=' . $business['business_id']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
            
                                    </td>                    
                                </tr>
                        <?php endforeach; ?>
        
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>รหัส</th>
                                <th>ชื่อสถานประกอบการ</th>
                                <th>จังหวัด</th>
                                <th>ดำเนินการ</th>
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
        $('#business_list').DataTable( {
//            "processing": true,
//            "serverSide": true,
//            "ajax": {
//                "url": "ajax/get_business.php",
//            },
//            "deferLoading": 50
//            
//        });
//        var table = $('#business_list').DataTable({
//            "processing": true,
//            "serverSide": true,
//            "ajax": 'ajax/get_business.php',           
//            "columnDefs": [
//                {
//                    "targets": 3,
//                    render: function (data, type, row, meta) {
//                        return '<a href="app/business/edit&action=edit&business_id=' + row[0] + '">Edit</a>';
//                    }
//                }
//            ],
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

function get_business($page = 0, $limit = 10) {
    global $db;
    $start = $page * $limit;
//    $query = "SELECT business.*,province.province_name FROM business,province WHERE business.province_id = province.province_code LIMIT " . $start . "," . $limit . "";
    $query = "SELECT b.business_id,b.business_name,p.province_name "
            . "FROM "
            . "business as b,province as p "
            . "WHERE "
            . "b.province_id = p.province_code";
    $result = mysqli_query($db, $query);
    $businesslist = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $businesslist[] = $row;
    }
    return $businesslist;
}

function get_total() {
    global $db;
//    $val = $group."%";
    $query = "SELECT * FROM business ";
    $result = mysqli_query($db, $query);
    return mysqli_num_rows($result);
}

function do_delete($business_id) {
    global $db;
    if (empty($business_id)) {
        set_err('ค่าพารามิเตอร์ไม่ถูกต้อง');
        redirect('business/list-business');
    }
    $query = "DELETE FROM business WHERE business_id =" . pq($business_id);
    mysqli_query($db, $query);
    if (mysqli_affected_rows($db)) {
        set_info('ลบข้อมูลสำเร็จ');
    }
    redirect('app/business/list');
}
?>