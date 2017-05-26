<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "ประเภทสถานศึกษา";
$active = 'school_type';
$subactive = 'index';
if (isset($_POST['submit'])) {
    $data = $_POST;
//    var_dump($data);
//    exit();
//    $valid = do_validate($data);  // check ความถูกต้องของข้อมูล
//    if (!$valid) {
//        foreach ($_POST as $k => $v) {
//            $$k = $v;  // set variable to form
//        }
//    } else {
        if (isset($data['school_type_id']) && !empty($data['school_type_id'])) {
            do_update($data);  // ไม่มี error บันทึกข้อมูล
        } else {
            do_insert();
        }
//    }
}
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    do_delete($_GET['school_type_id']);
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
                รายชื่อประเภทสถานศึกษา
                <small>ประเภทสถานศึกษา</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">ประเภทสถานศึกษา</a></li>
                <li class="active">รายชื่อ</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <?php show_message() ?> 
                <div class="box-header">
                    <h3 class="box-title">รายชื่อประเภทสถานศึกษา</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                                        <div class="table table-responsive">
                        <table class="table-striped table-condensed">
                            <tr>
                                <th class="col-xs-2 col-md-2">รหัส</th>
                                <th class="col-md-8">ชื่อประเภทสถานศึกษา</th>
                                <th class="text-center">กระทำการ</th></tr>
                            <tr>
                                <td><form method="post"><input type="text" class="form-control input-sm" readonly="" name="school_type_id" value=""</td>
                                        <td><input type="text" class="form-control input-sm" required="" name="type_name" value=""</td>
                                        <td class="text-center"><button type="submit" class="btn btn-sm btn-primary" name="submit">เพิ่มข้อมูล</button></form></td>
                            </tr>

                        </table>
                    </div> 
                    <div class="table table-responsive">
                        <table class="table-striped table-condensed">
                            <tr><th class="col-xs-2 col-md-2">รหัส</th><th class="col-md-8">ชื่อประเภทสถานศึกษา</th><th class="text-center">กระทำการ</th></tr>
                            <?php
                            $school_data = get_school_type();
                            foreach ($school_data as $data) :
                                $delete_url = site_url('app/school_type/index&action=delete&school_type_id=' . $data['school_type_id']);
                                ?>                     
                                <tr>
                                    <td><form method="post"><input type="text" class="form-control input-sm" readonly="" name="school_type_id" value="<?php echo $data['school_type_id'] ?>"</td>
                                            <td><input type="text" class="form-control input-sm" required="" name="type_name" value="<?php echo $data['type_name'] ?>"</td>
                                            <td class="text-center">
                                                <button type="submit" class="btn btn-sm btn-warning" name="submit">แก้ไข</button></form>
                                        <a class="btn btn-danger btn-sm" href="<?php echo $delete_url; ?>" role="button">ลบข้อมูล</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
        if (!confirm("ยืนยันการลบข้อมูล!!")) {
            return false;
        }
    });
</script>
<?php

function get_school_type() {
    global $db;
    $start = $page * $limit;
    $query = "SELECT * FROM school_type ORDER BY school_type_id ASC";
//    LIMIT " . $start . "," . $limit . "";
    $result = mysqli_query($db, $query);
    $schoollist = array();
    while ($row = mysqli_fetch_array($result)) {
        $schoollist[] = $row;
    }
    return $schoollist;
}

function get_total() {
    global $db;
//    $val = $group."%";
    $query = "SELECT * FROM school_type ";
    $result = mysqli_query($db, $query);
    return mysqli_num_rows($result);
}
function do_update($data) {
//    echo "update";
    global $db;
//    if (empty($type_name)) {
//        //echo "empty";
//        set_err('กรุณาใส่ชื่อสถานศึกษา');
//        redirect('school/list-school-type');
//    }
//        echo "school_type_id=".$school_type_id;
        $query = "UPDATE school_type SET type_name=".pq($data['type_name'])." WHERE school_type_id =" . pq($data['school_type_id']);
        $result=mysqli_query($db, $query);
        if ($result) {
            set_info('ปรับปรุงข้อมูลสำเร็จ');
        }else{
            set_err('ปรับปรุงข้อมูลไม่สำเร็จ');
        }
        redirect('app/school_type/index');
}
function do_delete($school_type_id) {
    global $db;
    if (empty($school_type_id)) {
        set_err('ค่าพารามิเตอร์รหัสสถานศึกษาไม่ถูกต้อง');
    }
    $query = "DELETE FROM school_type WHERE school_type_id =" . pq($school_type_id);
    mysqli_query($db, $query);
    if (mysqli_affected_rows($db)) {
        set_info('ลบข้อมูลสำเร็จ');
    }
    redirect('app/school_type/index');
}
function do_insert() {
    global $db;
    $data = &$_POST;
    //var_dump($data);
    //die();
    $sql = "INSERT INTO `school_type` (
			`school_type_id` ,`type_name`
		)VALUES(
			NULL,
            " . pq($data['type_name']) . ");";
			
    // die("sql: ".$sql);
    mysqli_query($db, $sql);
    if (mysqli_affected_rows($db) > 0) {
       $_SESSION['info'][] = "บันทึกข้อมูลเรียบร้อยครับ";
    } else {
       // $_SESSION['error'] = "บันทึกไม่สำเร็จ กรุณาตรวจสอบข้อมูล" . mysqli_error($db) . $sql;
        set_err('บันทึกไม่สำเร็จ กรุณาตรวจสอบข้อมูล'. mysqli_error($db));
    }
    redirect('app/school_type/index');
    /* close statement and connection */
    //redirect();
}
?>

