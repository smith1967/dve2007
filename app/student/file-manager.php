<?php
// student/file-manager
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "อัพโหลดไฟล์และตรวจสอบข้อมูล";
$active = 'student';
$subactive = 'file-manager';
//is_admin('home/index');
//$_SESSION['school_id']='1320026101'; //==========fix session  วท.ชลบุรี
//$_SESSION['school_id']='1316016101'; //==========fix session ลพบุรี
//$_SESSION['school_id']='1346146401'; //==========fix session  ห้วยผึ้ง

$school_id = $_SESSION['user']['school_id'];
$school_name = getSchoolName($school_id);

/* -- upload process -- */


if (isset($_POST['submit'])):
    $err = do_upload();
endif;

if (isset($_POST['submit1'])):
    $_SESSION['user']['round'] = $_POST["round"];
    $_SESSION['user']['year'] = $_POST["year"];
    $_SESSION['user']['round-year']=$_SESSION['user']['round'].'-'.$_SESSION['user']['year'];
endif;
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'del') {
        // echo "<script>alert('dddd') </script>" ;
        $filename = UPLOAD_DIR . $_GET['filename'];
        // echo $filename ;exit();
        if (is_file($filename))
            unlink($filename);
        else
            set_err('ไม่สามารถลบไฟล์ ' . $filename);
    }
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
                รายการจัดการไฟล์
                <small>upload ไฟล์</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">รายการจัดการไฟล์</a></li>
                <li class="active">upload ไฟล์</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <?php show_message() ?> 
                <div class="box-header">
                    <h3 class="box-title">upload ไฟล์ข้อมูลนักเรียน</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="panel-group ">
                        <div class="panel panel-default">
                            <div class="panel-heading">เลือกงวดและปีงบประมาณ</div>
                            <div class="panel-body">
                                <form method="post" class="form-inline " action="">
                                    <div class="form-group ">
                                        <label class="control-label col-md-6"for="round">งวดการส่งข้อมูล :</label>
                                        <div class="col-md-2 ">
                                            <select class="form-control" id="round" name="round">
                                                <?php
                                                $arr = array(1 => 1, 2 => 2, 3 => 3);
                                                $def = $_SESSION['user']['round'];
                                                echo gen_option($arr, $def);
                                                ?>
                                            </select>
                                        </div></div>
                                    <div class="form-group">
                                        <label class="control-label col-md-6"for="year">ปีงบประมาณ:</label>
                                        <div class="col-md-2 ">
                                        <?php
                                            $year_now=date('Y')+543;
                                            //echo $year_now;
                                         ?>
                                            <select class="form-control" id="year" name="year">
                                                <?php
                                                
                                                $arr2 = array($year_now => $year_now, $year_now+1 => $year_now+1, $year_now+2 => $year_now+2);
                                                $def = $_SESSION['user']['year'];
                                                echo gen_option($arr2, $def);
                                                ?>
                                            </select>
                                        </div></div>
                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-primary col-md-offset-4" name="submit1"> ตกลง </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($_POST["submit1"]) || $_SESSION['user']['upload'] != ''):
                        ?>
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">เลือกไฟล์ ข้อมูลนักเรียนงวดที่ <?php echo $_SESSION['user']['round'] ?> ปีงบประมาณ <?php echo $_SESSION['user']['year'] ?></div>
                                <div class="panel-body">
                                    <form class="form-horizontal" id="upload_form" method="post" action="" enctype="multipart/form-data">
                                        <fieldset>
                                            <div class="form-group">
                                                <label class="control-label col-md-3" for="uploadfile">เลือกไฟล์ std_รหัสสถานศึกษา.csv</label>
                                                <div class="col-md-3">
                                                    <input type="file" class="btn btn-primary btn-file" id="uploadfile" name="uploadfile" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-offset-2 col-md-10">
                                                    <button type="submit" class="btn btn-primary" name='submit'>อัพโหลดไฟล์</button>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div> 

                        <?php
                        //get file list in upload folder
                        //ie(UPLOAD_DIR);
                        $fstd = "std_" . substr($school_id, 2, 8);
//                        echo "a=".$fstd."<br>";
                        if ($handle = opendir(UPLOAD_DIR)) :
                            while (false !== ($entry = readdir($handle))) :
//                                   echo "b=".substr($entry,11,12)."<br>";
//                                echo "(2560)y=".substr($entry,24,4)."<br>";
//                                 echo "(2)r=".substr($entry,29,1)."<br>";
//                                echo $_SESSION['user']['round'];
                                if ($entry != "." && $entry != ".." && strtolower(substr($entry, 11, 12)) == $fstd && substr($entry, 24, 4) == $_SESSION['user']["year"] && substr($entry, 29, 1) == $_SESSION['user']["round"]):
//                    if ($entry != "." && $entry != "..") :    
                                    ?>
                                    <div class="table-responsive col-md-6">
                                        <table class="table" >
                                            <thead><th>ชื่อไฟล์</th><th>ตรวจสอบไฟล์</th><th>ลบไฟล์</th></thead>
                                            <tr>
                                                <td> <?php echo $entry . "\n"; ?></td>
                                                <?php
                                                $checklink = site_url('app/student/check-data') . '&action=check&filename=' . $entry;
                                                $unlink = site_url('app/student/file-manager') . '&action=del&filename=' . $entry;
                                                ?>
                                                <td class="text-center"><a href="<?php echo $checklink ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                                                <td class="text-center"><a href="<?php echo $unlink ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                                            </tr>
                                            <tr><td colspan="3" align='center'>คลิกตรวจสอบไฟล์ เพื่อดำเนินการขั้นตอนต่อไป</td></tr>
                                            <?php
                                        endif;
                                    endwhile;
                                    closedir($handle);
                                endif;
                            endif;
                            ?>
                        </table>
                    </div>  

                </div>
                <!-- /.box-body -->
            </div>
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

function do_upload() {
    $filename = $_FILES['uploadfile']['tmp_name'];
    $stdfile = UPLOAD_DIR . date('Y-m-d') . '_' . basename($_FILES['uploadfile']['name']);
    $ext = pathinfo($stdfile, PATHINFO_EXTENSION); // die();
    if (strtolower($ext) != 'csv') {
        set_err("ชนิดของไฟล์ไม่ถูกต้อง กรุณาตรวจสอบอีกครั้งครับ");
    }

    if ($_FILES["uploadfile"]["error"] > 0) {
        //echo "Error: " . $_FILES["uploadfile"]["error"] . "<br>";
        set_err("<p>Error: " . $_FILES["uploadfile"]["error"] . "<p/>");
    }

    if (file_exists($stdfile)) {
        unlink($stdfile);
    }
    if (!move_uploaded_file($filename, $stdfile)) {
        set_err("อัพโหลดไฟล์ข้อมูลผิดพลาด :" . $stdfile);
    }
    $_SESSION['user']['upload'] = "$filename";

    redirect('app/student/file-manager');
}
