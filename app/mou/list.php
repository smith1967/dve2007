<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "ข้อมูลการทำความร่วมมือ";
$active = ' mou';
$subactive = 'list-data';
//$moulist = get_mou(0, 0);
////    $total = get_total();
//$url = site_url('mou/list-mou&') . $params;
//// var_dump($moulist);
////    exit();
//$total = get_total();
//if(!isset($total))redirect("/admin/index");
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    do_delete($_GET['mou_id']);
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
                ข้อมูลการทำความร่วมมือ
                <small>แสดงรายการ</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">ข้อมูลการทำความร่วมมือ</a></li>
                <li class="active">รายการ</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <?php show_message() ?> 
                <div class="box-header">
                    <h3 class="box-title">ข้อมูลการทำความร่วมมือ</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="mou_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>ชื่อสถานศึกษา</th>
                                    <th>ชื่อสถานประกอบการ</th>
                                    <th>วันที่ทำความร่วมมือ</th>
                                    <th>ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
//                                $count=1;
//                        foreach ($moulist as $mou) :
//                                ?>                            
                                <!--<tr>-->
<!--        <td>//<?php //echo $count++; ?></td>
        <td>//<?php //echo $mou['school_name']; ?></td>
        <td>//<?php //echo $mou['business_name']; ?></td>
        <td>//<?php //echo chDay3($mou['mou_date']); ?></td>

        <td class="text-center">
            <a href="//<?php //echo site_url('app/mou/list') . '&action=delete&mou_id=' . $mou['mou_id']; ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-remove"></i></a> | 
            <a href="//<?php //echo site_url('app/mou/edit') . '&action=edit&mou_id=' . $mou['mou_id']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>

        </td>                    
    </tr>-->
                                <?php  //endforeach; ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>ชื่อสถานศึกษา</th>
                                    <th>ชื่อสถานประกอบการ</th>
                                    <th>วันที่ทำความร่วมมือ</th>
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
        $('.delete').click(function () {
            return confirm('ยืนยันการลบข้อมูล');
        });
        $('#mou_list').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "ajax": {
                "url": "ajax/get_mou.php",
                "type": "POST"
            },
            "columns": [
                {"data": "num"},
                {"data": "school_name"},
                {"data": "business_name"},
                {"data": "mou_date"},
//        { "data": "gender" },
//        { "data": "country" },
//        { "data": "phone" },
                {"data": "button"},
            ],
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

<?php

function get_mou($page = 0, $limit = 10) {
    global $db;
    //$start = $page * $limit;
//    $query = "SELECT mou.*,province.province_name FROM mou,province WHERE mou.province_id = province.province_code LIMIT " . $start . "," . $limit . "";
    $query = "SELECT  m.mou_id,s.`school_name`,b.`business_name`,m.`mou_date` "
            ."FROM `mou` m "
            ."join business b ON b. `business_id`=m.`mou_id` "
            ."join school s ON s.`school_id`=m.`school_id` "
            ."ORDER by m.`school_id` "
            ;
    //echo $query;
    $result = mysqli_query($db, $query);
    $moulist = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $moulist[] = $row;
    }
    return $moulist;
}

function get_total() {
    global $db;
//    $val = $group."%";
    $query = "SELECT * FROM mou ";
    $result = mysqli_query($db, $query);
    return mysqli_num_rows($result);
}

function do_delete($mou_id) {
    global $db;
    if (empty($mou_id)) {
        set_err('ค่าพารามิเตอร์ไม่ถูกต้อง');
        redirect('mou/list-mou');
    }
    $query = "DELETE FROM mou WHERE mou_id =" . pq($mou_id);
    mysqli_query($db, $query);
    if (mysqli_affected_rows($db)) {
        set_info('ลบข้อมูลสำเร็จ');
    }
    redirect('app/mou/list');
}
