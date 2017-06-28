<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "ข้อมูลนักศึกษา";
$active = 'student';
$subactive = 'list';
//is_admin('home/index');
$school_id = $_SESSION['user']['school_id'];

//$page = isset($_GET['page']) ? $_GET['page'] : 0;
//$action = isset($_GET['action']) ? $_GET['action'] : "list";
//$order = isset($_GET['order']) ? $_GET['order'] : '';
//$limit = isset($_GET['limit']) ? $_GET['limit'] : 40;
//
//$params = array(
//    'action' => $action,
//    'limit' => $limit,
//);
//$params = http_build_query($params);
//$studentlist = get_student($page, $limit, $school_id);
////echo $studentlist; exit();
////    $total = get_total();
//$url = site_url('student/list-student&') . $params;
////    var_dump($businesslist);
////    exit();
//$total = get_total($school_id);
////if(!isset($total))redirect("/admin/index");
//if (isset($_GET['action']) && $_GET['action'] == 'delete') {
//    do_delete($_GET['std_id']);
//}
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
                รายชื่อนักศึกษา
                <small>รายชื่อ</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">นักศึกษา</a></li>
                <li class="active">รายชื่อ</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <?php show_message() ?> 
                <div class="box-header">
                    <h3 class="box-title">รายชื่อนักศึกษา</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="student_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>รหัสนักเรียน</th>
                <!--                    <th>รหัสสถานศึกษา</th>-->
                                    <th>รหัสประจำตัวประชาชน</th>
                                    <th>ชื่อนักเรียน</th>
                                    <th>วันเดือนปีเกิด</th>
                                    <th>เพศ</th>
                                    <th>สาขางาน</th>
                                    <th>สาขาวิชา</th>
                <!--                    <th>สถานะภาพ</th>
                                    <th>รหัสประเภทวิชา</th>-->
                                </tr>

                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>รหัสนักเรียน</th>
                <!--                    <th>รหัสสถานศึกษา</th>-->
                                    <th>รหัสประจำตัวประชาชน</th>
                                    <th>ชื่อนักเรียน</th>
                                    <th>วันเดือนปีเกิด</th>
                                    <th>เพศ</th>
                                    <th>สาขางาน</th>
                                    <th>สาขาวิชา</th>
                <!--                    <th>สถานะภาพ</th>
                                    <th>รหัสประเภทวิชา</th>-->
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
            return confirm('ยืนยันการลบข้อมูล')
        });
        $('#student_list').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "ajax": {
                "url": "ajax/get_student.php",
                "type": "POST"
            },
            "columns": [
                {"data": "num"},
                {"data": "std_id"},
                {"data": "citizen_id"},
                {"data": "std_name"},
                {"data": "dob"},
                {"data": "sex"},
                {"data": "minor_name"},
                {"data": "major_name"},
//        { "data": "gender" },
//        { "data": "country" },
//        { "data": "phone" },
//                {"data": "button"},
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

function get_student($page = 0, $limit = 10,$school_id) {
    global $db;
    $start = $page * $limit;
    $query = "SELECT * FROM student WHERE `school_id`=".pq($school_id)." AND end_edu_id = 1;";
//            . " LIMIT " . $start . "," . $limit . "";
//    var_dump($query);
    //$query = "SELECT * FROM student  LIMIT " . $start . "," . $limit . "";
    $result = mysqli_query($db, $query);
    $studentlist = array();
    while ($row = mysqli_fetch_array($result)) {
        $studentlist[] = $row;
    }
     
    return $studentlist;

}

function get_total($school_id) {
    global $db;
//    $val = $group."%";
    $query = "SELECT * FROM student WHERE school_id = ".pq($school_id);
    $result = mysqli_query($db, $query);
    return mysqli_num_rows($result);
}

function do_delete($std_id) {
    global $db;
    if (empty($std_id)) {
        set_err('ค่าพารามิเตอร์ไม่ถูกต้อง');
        redirect('student/list-student');
    }
    $query = "DELETE FROM student WHERE std_id =" . pq($std_id);
    mysqli_query($db, $query);
    if (mysqli_affected_rows($db)) {
        set_info('ลบข้อมูลสำเร็จ');
    }
    redirect('student/list-student');
}
//function getMajorName($id){
//    global $db;
//    $query = "SELECT * FROM major where major_id='".$id."'";
//    //echo $query;
//    $rs = mysqli_query($db, $query);
//    $row = mysqli_fetch_array($rs);
//    return $row['major_name'];
//}
//
//function getMinorName($id){
//    global $db;
//    $query = "SELECT * FROM minor where minor_id='".$id."'";
//    //echo $query;
//    $rs = mysqli_query($db, $query);
//    $row = mysqli_fetch_array($rs);
//    return $row['minor_name'];
//}
//
////แปลง 2011-03-08 to 8 มีนาคม 2554
//function chDay3($s){
//	$d=explode("-",$s);
//	//print_r($d);
//	$arr_month=array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
//                     'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
//	$y=$d[0]+543;
//	//$da=ins0($d[0]);
//	return del0($d[2])." ".$arr_month[$d[1]-1]." ".$y;
//}
////ตัดเลข 0 ถ้าไม่ถึง 10 // 08 >> 8
//function del0($s){
//    if ($s<10){
//        $r=substr($s,1);
//    }else{
//        $r=$s;
//    }
//    return $r;
//}
//// M=>ชาย
//function convSex($s){
//    if ($s=='M'){
//        $r='ชาย';
//    }else{
//        $r='หญิง';
//    }
//    return $r;
//}
//
//?>