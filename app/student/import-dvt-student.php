<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "โอนข้อมูล std เข้า table เฉพาะทวิภาคี";
$active = 'admin';
$subactive = 'import-dvt-std';
//is_admin('home/index');
// do_import_all_std();
//do_import_std();
$date_update = date("Y-m-d");
if (isset($_GET['action']) && $_GET['action'] == 'import_dvt_std') {
    do_import_all_std();
    $message=do_import_std();
} else if (isset($_GET['action']) && $_GET['action'] == 'delete_dvt_std') {
    do_delete();
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
                นำเข้าข้อมูลทวิภาคี
                <small>ข้อมูลนักศึกษา</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">นักศึกษา</a></li>
                <li class="active">นำเข้าข้อมูลทวิภาคี</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content"
            <!-- Default box -->
            <div class="box">
                <?php show_message()  ;
                echo $message['true'];
                echo $message['wrong'][0];
                echo $message['wrong'][1];
                ?>
                <div class="box-header">
                    <h3 class="box-title">นำเข้าข้อมูลนักเรียนระบบทวิภาคี</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <?php $importlink = site_url('app/student/import-dvt-student') . '&action=delete_dvt_std'; ?>
                    <?php $importlink2 = site_url('app/student/list'); ?>
                    <p>จำนวนข้อมูลไม่ถูกต้องต้องการยกเลิกข้อมูลในฐานข้อมูลทั้งหมด <a href="<?php echo $importlink ?>"><button type="button" class="btn btn-danger">ยกเลิกข้อมูล</button></a></p>
                    <p>จำนวนข้อมูลถูกต้อง ตรวจสอบรายชื่อนักเรียน <a href="<?php echo $importlink2 ?>"><button type="button" class="btn btn-info">ตรวจสอบรายชื่อนักเรียน</button></a></p>
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

<?php
function do_import_all_std(){
    global $db;
    
    $sql="insert into sum_of_student 
        select `school_id`,`round_year`,`semester`,`edu_year`,
        (SELECT count(`std_id`) FROM `student_tmp`) as sum_of_student,
        (SELECT count(`std_id`) FROM `student_tmp` where `edu_id`=2) as sum_of_dvt_student,
        (SELECT  count(`std_id`) FROM `student_tmp` WHERE substr(std_id,3,1)=2) as sum_of_vc_student,
        (SELECT  count(`std_id`) FROM `student_tmp` WHERE substr(std_id,3,1)=3) as sum_of_hvc_student,
        (SELECT  count(`std_id`) FROM `student_tmp` WHERE substr(std_id,3,1)=4) as sum_of_b_student,
        (SELECT  count(`std_id`) FROM `student_tmp` WHERE substr(std_id,3,1)=2 and `edu_id`=2) as sum_of_dvt_vc_student,
        (SELECT  count(`std_id`) FROM `student_tmp` WHERE substr(std_id,3,1)=3 and `edu_id`=2) as sum_of_dvt_hvc_student,
        (SELECT  count(`std_id`) FROM `student_tmp` WHERE substr(std_id,3,1)=4 and `edu_id`=2) as sum_of_dvt_b_student
        from `student_tmp` limit 0,1";
    $result= mysqli_query($db, $sql);
    if (!$result) {   
        $err="การเพิ่มข้อมูลเข้าตารางนับจำนวนนักเรียนผิดพลาด  : " . mysqli_error($db);
//        echo "<pre>";
//        print_r(mysqli_error_list($db));// [errno]=1062 =>Duplicate
//        echo "</pre>";       
        $errorlist=mysqli_error_list($db);
        //echo $errorlist[0]['errno'];
        $link = site_url('student/file-manager');
        if ($errorlist[0]['errno']==1062){
          //  echo '<div class="alert alert-danger">';
          //  echo "ข้อมูลในตารางนับจำนวนนักเรียนมีอยู่แล้วในระบบ ไม่สามารถส่งข้อมูลขึ้นระบบได้";
          //  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            //echo '<p class="text-info"> ต้องการส่งข้อมูลใหม่ กรุณาติดต่อผู้ดูแลระบบ</p>';
            // echo '<a href="'.$link.'">กลับไปหน้าส่งไฟล์ข้อมูล</a>';
            // echo '</div>';
        }else{
            echo '<div class="alert alert-danger">';
            echo $err.'<a href="'.$link.'">กลับไปหน้าส่งไฟล์ข้อมูล</a>';
            echo '</div>';
            
        }
    } else {
       // $info='โอนข้อมูลเข้าตารางนับจำนวนนักเรียน จำนวน ' . mysqli_affected_rows($db) . ' รายการ';
      // echo 'โอนข้อมูลเข้าตาราง student จำนวน ' . mysqli_affected_rows($db) . ' รายการ' ;
        echo '<div class="alert alert-info">';
        echo $info;
        echo '</div>';
        
    }

}
function do_import_std() {
    global $db;
    global $date_update;
   //  transfer new data from tmp to student
    $sql = "replace INTO student (`std_id`,`school_id`,`citizen_id`,`std_name`,`dateofbirth`,`sex`,`minor_id`,`major_id`,`type_code`,`end_edu_id`,`edu_year`,`date_update`) 
    SELECT `std_id`,`school_id`,`citizen_id`,`std_name`,`dateofbirth`,`sex`,`minor_id`,`major_id`,`type_code`,`end_edu_id`,`edu_year` ,`date_update`
    FROM `student_tmp` 
    WHERE `edu_id`=2;";
    //echo "sql= ".$sql; exit();
    $result= mysqli_query($db, $sql);
    if (!$result) {
        $err="การเพิ่มข้อมูลเข้าตาราง student ผิดพลาด  : " . mysqli_error($db);
        $message['wrong'][0]='<div class="alert alert-danger">'.$err.'</div>';
        $errorlist=mysqli_error_list($db);
        //echo $errorlist[0]['errno'];
        $link = site_url('student/file-manager');
        if ($errorlist[0]['errno']==1062){
            $message['wrong'][1]='<div class="alert alert-danger"> ข้อมูลนักเรียนมีอยู่แล้วในระบบ ไม่สามารถส่งข้อมูลขึ้นระบบได้ ';
            $message['wrong'][1].='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="'.$link.'">กลับไปหน้าส่งไฟล์ข้อมูล</a> </div>'    ;    
        }else{
            $message['wrong'][1]='<div class="alert alert-danger"> '.$err.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="'.$link.'">กลับไปหน้าส่งไฟล์ข้อมูล</a></div>';
        }
        //redirect('form.php');
    } else {
        //ปรับ end_edu_id เป็น 0 สำหรับผู้ไม่มีรายชื่อ ในการโอนครั้งต่อไป
        //UPDATE `dvt2017`.`student` SET `end_edu_id` = '0' 
        //WHERE `student`.`std_id` = '5931110025' AND `student`.`school_id` = '1320026101';
        $sql="UPDATE `student` SET `end_edu_id` = '0' WHERE  `date_update` != '".$date_update."'";
        $result= mysqli_query($db, $sql);
        $info='โอนข้อมูลนักเรียนทวิภาคี เข้าตาราง student เรียบร้อยแล้ว';
      //  echo 'โอนข้อมูลเข้าตาราง student จำนวน ' . mysqli_affected_rows($db) . ' รายการ' ;
        //show_info($_SESSION['info']);
        $message['true']= '<div class="alert alert-info">';
        $message['true'].=  $info;
        $message['true'].= '</div>';   
    }
   // redirect('student/import-std');
   return $message;
}

function do_delete(){
    global $db;
    $school_id = $_SESSION['user']['school_id'];
    $year=$_SESSION['year'];
    $round_year = $_SESSION['user']['round-year'];
    $sql = "DELETE FROM `student` WHERE `school_id` = '$school_id' AND `edu_year` = '$year' ";
    $result = mysqli_query($db, $sql);
    $sql2 = "DELETE FROM `sum_of_student` WHERE `school_id` = '$school_id' AND `round_year` = '$round_year' ";
    $result2 = mysqli_query($db, $sql2);
    //    echo $sql."<br>";
    //     echo $sql2."<br>";
    //      echo exit()."<br>";
    if ($result >0 && $result2>0){
        redirect('app/student/file-manager');
    }
}


