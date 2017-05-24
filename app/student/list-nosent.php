<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "ตรวจสอบการส่งข้อมูลนักศึกษา";
$active = 'student';
$subactive = 'list-nosent';
//is_admin('home/index');
//$school_id = $_SESSION['user']['school_id'];

$page = isset($_GET['page']) ? $_GET['page'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : "list";
$order = isset($_GET['order']) ? $_GET['order'] : '';
$limit = isset($_GET['limit']) ? $_GET['limit'] : 40;

$params = array(
    'action' => $action,
    'limit' => $limit,
);
$params = http_build_query($params);
$school_list = get_school_nosent($page, $limit, $school_id);
//echo $studentlist; exit();
//    $total = get_total();
//$url = site_url('student/list-student&') . $params;
//    var_dump($businesslist);
//    exit();
//$total = get_total($school_id);
//if(!isset($total))redirect("/admin/index");

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
                รายการสถานศึกษา
                <small>ไม่ส่งข้อมูล</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">ไม่ส่งข้อมูล</a></li>
                <li class="active">รายการ</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <?php show_message() ?> 
                <div class="box-header">
                    <h3 class="box-title">รายการสถานศึกษาไม่ส่งข้อมูล</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-condensed table-hover" id="data">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>รหัสสถานศึกษา</th>
                                    <th>ชื่อสถานศึกษา</th>
                                    <th>จังหวัด</th>
                                    <th>ภาค</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cn = 0;
            //    var_dump($school_list);
                                foreach ($school_list as $school) :
                                    $cn++;
                                    ?>
                                    <tr>
                                        <td><?php echo $cn; ?></td>
                                        <td><?php echo $school['school_id']; ?></td>
                                        <td><?php echo $school['school_name']; ?></td>
                                        <td><?php echo $school['province_name']; ?></td>
                                        <td><?php echo $school['zoneName']; ?></td>
                                       
                                    </tr>  
                                <?php endforeach; ?>
                            </tbody>
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

function get_school_nosent($page = 0, $limit = 10,$school_id) {
    global $db;
    $start = $page * $limit;
    $query = "SELECT s.`school_id`,s.`school_name` ,p.`province_name`,z.`zoneName` FROM `school` s  ,`province` p ,`zone` z
                where s.`school_id` not in (SELECT  `school_id` FROM `student` group by `school_id`)
                and s.`school_id` like '13%' and s.`school_id` not like '1300%'
                and s.`province_id`=p.`PROVINCE_CODE`
                and s.zone=z.`zone_id`
                group by `school_id`";
//            . " LIMIT " . $start . "," . $limit . "";
//    var_dump($query);
    //$query = "SELECT * FROM student  LIMIT " . $start . "," . $limit . "";
    $result = mysqli_query($db, $query);
    $studentlist = array();
    while ($row = mysqli_fetch_array($result)) {
        $school_list[] = $row;
    }
     
    return $school_list;

}

// function get_total($school_id) {
//     global $db;
// //    $val = $group."%";
//     $query = "SELECT * FROM student WHERE school_id = ".pq($school_id);
//     $result = mysqli_query($db, $query);
//     return mysqli_num_rows($result);
// }


