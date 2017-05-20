<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "โอนข้อมูล std เข้า table เฉพาะทวิภาคี";
$active = 'student';
$subactive = 'import-std';
//is_admin('home/index');
// do_import_all_std();
//do_import_std();
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
                รายการฝึกงาน
                <small>ฝึกงาน</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">นักศึกษา</a></li>
                <li class="active">นำเข้าข้อมูล</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <?php show_message() ?> 
                <div class="box-header">
                    <h3 class="box-title">รายการฝึกงาน</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <?php
                            $school_id = $_SESSION['user']['school_id'];
                            $data = do_show_std();
                            //print_r($data);
                            ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>จำนวนนักเรียนทั้งหมด <?php echo $data['sum_student'] ?> คน</th>
                                            <th>จำนวนนักเรียนทวิภาคี <?php echo $data['sum_dvt_student'] ?> คน</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <p></p>
                            <center>
                                <button type="button" id="button1" class="btn btn-warning">ข้อมูลไม่ถูกต้อง ส่งข้อมูลใหม่</button>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button type="button" id="button2" class="btn btn-success">ข้อมูลถูกต้อง ไปขั้นตอนต่อไป</button>
                            </center>
                            <p></p>
                        </div>
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
    $('#button1').click(function() {
        // alert("aaa");
       // window.location = "www.example.com/index.php?id=" + this.id;
       window.location = "index.php?app/student/file-manager";
    });
    $('#button2').click(function() {
        // alert("aaa");
       // window.location = "www.example.com/index.php?id=" + this.id;
       window.location = "index.php?app/student/import-dvt-student&action=import_dvt_std";
    });

    $('.delete').click(function() {
        if (!confirm('ยืนยันลบข้อมูล')) {
            return false;
        }
    });
</script>

<?php

function do_delete($val) {
    global $db;
   
    redirect('app/student/import-std');
}


function do_import_std() {
    global $db;
   //  transfer new data from tmp to student
    $sql = "REPLACE INTO student (`std_id`,`school_id`,`citizen_id`,`std_name`,`dateofbirth`,`sex`,`minor_id`,`major_id`,`type_code`,`end_edu_id`) 
    SELECT `std_id`,`school_id`,`citizen_id`,`std_name`,`dateofbirth`,`sex`,`minor_id`,`major_id`,`type_code`,`end_edu_id` 
    FROM `student_tmp` 
    WHERE `edu_id`=2;";
   // echo "sql= ".$sql; exit();
    mysqli_query($db, $sql);
    if (mysqli_affected_rows($db) < 1) {
        set_err("การเพิ่มข้อมูลเข้าตาราง student ผิดพลาด  : " . mysqli_error($db));
        //redirect('form.php');
    } else {
        set_info('โอนข้อมูลนักเรียนทวิภาคี เข้าตาราง student จำนวน ' . mysqli_affected_rows($db) . ' รายการ');
      //  echo 'โอนข้อมูลเข้าตาราง student จำนวน ' . mysqli_affected_rows($db) . ' รายการ' ;
        //show_info($_SESSION['info']);
        echo '<div class="table-responsive col-md-6">';
        show_info($_SESSION['info']);
        echo '</div>';   
    }
   // redirect('student/import-std');
}

function do_show_std(){
    global $db;
    $sql="select 
    (SELECT count(`std_id`) FROM `student_tmp`) as sum_student,
    (SELECT count(`std_id`) FROM `student_tmp` where `edu_id`=2) as sum_dvt_student
    ";
    //echo $sql;
    $res=mysqli_query($db, $sql);
    $row=mysqli_fetch_assoc($res);
    //echo $row['sum_student'];
    return $row;
}
