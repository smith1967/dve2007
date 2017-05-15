<?php
/* if (!defined('BASE_PATH'))
  exit('No direct script access allowed'); */
$title = "เพิ่มข้อมูลการฝึกงาน";
$active = 'training';
$school_id = $_SESSION['user']['school_id'];
$subactive = 'insert';
if (isset($_POST['submit'])) {
    $data = $_POST;
//    var_dump($data);
    $valid = do_validate($data);  // check ความถูกต้องของข้อมูล
    if ($valid) {
        do_insert($school_id);
    } else {
        foreach ($_POST as $k => $v) {
            $$k = $v;  // set variable to form
        }
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
                กรอกข้อมูลครูฝึก
                <small>แบบฟอร์ม</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">ครูฝึก</a></li>
                <li class="active">เพิ่มข้อมูล</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-12">
                    <?php show_message() ?>    
                    <!-- Horizontal Form -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">เพิ่มข้อมูลครูฝึก</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form method="post" class="form-horizontal" action=""> 
                            <!--                <div class="form-group"> 
                                                <label class="control-label col-md-3" for="training_id">รหัสการฝึกอาชีพ</label>
                                                <div class="col-md-4 "><input type="text" class="form-control" id="training_id" name="training_id"></div>
                                            </div>-->
                            <input type="hidden" class="form-control" id="citizen_id" name="citizen_id" value="<?php set_var($citizen_id) ?>">
                            <div class="form-group"> 
                                <label class="control-label col-md-3" for="std_name">ชื่อนักศึกษา</label>
                                <div class="col-md-3 ">
                                    <input type="text" class="form-control" id="std_name" placeholder="ชื่อนักศึกษา" name="std_name" value="<?php set_var($std_name) ?>">
                                </div>
                            </div>
                            <input type="hidden" class="form-control" id="business_id"  name="business_id" value="<?php set_var($business_id) ?>">
                            <div class="form-group"> 
                                <label class="control-label col-md-3" for="business_name">รหัสสถานประกอบการ</label>
                                <div class="col-md-3 ">
                                    <input type="text" class="form-control" id="business_name" placeholder="ชื่อสถานประกอบการ" name="business_name" value="<?php set_var($business_name) ?>">
                                </div>
                            </div>
                            <div class="form-group"> 
                                <label class="control-label col-md-3" for="school_id">รหัสสถานศึกษา</label>
                                <div class="col-md-3 ">
                                    <input type="text" class="form-control" readonly="" id="school_id" placeholder="ชื่อสถานศึกษา" name="school_id" value="<?php set_var($school_id) ?>">
                                </div>
                            </div>
                            <input type="hidden" class="form-control" id="minor_id" name="minor_id" value="<?php set_var($minor_id) ?>">
                            <div class="form-group"> 
                                <label class="control-label col-md-3" for="minor_name">ชื่อสาขางาน</label>
                                <div class="col-md-3 ">
                                    <input type="text" class="form-control" id="minor_name" placeholder="ชื่อสาขางาน" name="minor_name" value="<?php set_var($minor_name) ?>">
                                </div>
                            </div>
                            <input type="hidden" class="form-control" id="trainer_id" name="trainer_id" value="<?php set_var($trainer_id) ?>">
                            <div class="form-group"> 
                                <label class="control-label col-md-3" for="trainer_name">ชื่อครูฝึก</label>
                                <div class="col-md-3 ">
                                    <input type="text" class="form-control" id="trainer_name" placeholder="ชื่อครูฝึก" name="trainer_name" value="<?php set_var($trainer_name) ?>">
                                </div>
                            </div>

                            <div class="form-group"> 
                                <label class="control-label col-md-3" for="contract_date">วันที่ทำสัญญา</label>
                                <div class="col-md-4 "><input type="date" id="contract_date" name="contract_date" value="<?php set_var($contract_date) ?>"/></div>
                            </div>
                            <div class="form-group"> 
                                <label class="control-label col-md-3" for="start_date">วันที่เริ่มต้นการฝึก</label>
                                <div class="col-md-4 "><input type="date" id="start_date" name="start_date" value="<?php set_var($start_date) ?>"/></div>
                            </div>

                            <div class="form-group"> 
                                <label class="control-label col-md-3" for="end_date">วันที่สิ้นสุดการฝึก</label>
                                <div class="col-md-4 "><input type="date" id="end_date" name="end_date" value="<?php set_var($end_date) ?>"/></div>
                            </div>


                            <div class="form-group"> 
                                <div class="col-md-offset-3"><button type="submit" class="btn btn-primary"name="submit">บันทึกข้อมูล</button></div>
                            </div>
                        </form>

                    </div>
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php require_once 'template/main-footer.php'; ?>    
</div>
<!--.wrapper-->
<?php require_once 'template/footer.php'; ?>
<script>
    $(function () {
        $("#std_name").autocomplete({
            source: "<?php echo SITE_URL ?>ajax/search_student.php",
            minLength: 2,
            select: function (event, ui) {
                $("#std_name").val(ui.item.label); // display the selected text
                $("#citizen_id").val(ui.item.value); // save selected id to hidden input
                return false;
            }
        });
        $("#business_name").autocomplete({
            source: "<?php echo SITE_URL ?>ajax/search_business_1.php",
            minLength: 2,
            select: function (event, ui) {
                $("#business_name").val(ui.item.label); // display the selected text
                $("#business_id").val(ui.item.value); // save selected id to hidden input
                return false;
            }
        });
        $("#minor_name").autocomplete({
            source: "<?php echo SITE_URL ?>ajax/search_minor.php",
            minLength: 2,
            select: function (event, ui) {
                $("#minor_name").val(ui.item.label); // display the selected text
                $("#minor_id").val(ui.item.value); // save selected id to hidden input
                return false;
            }
        });
        $("#trainer_name").autocomplete({
            source: "<?php echo SITE_URL ?>ajax/search_trainer.php",
            minLength: 2,
            select: function (event, ui) {
                $("#trainer_name").val(ui.item.label); // display the selected text
                $("#trainer_id").val(ui.item.value); // save selected id to hidden input
                return false;
            }
        });
    });
</script> 
<?php

function do_validate($data) {
    $valid = true;
    $data = &$_POST;
//    if (!preg_match('/[a-zA-Z0-9_]{1,}/', $data['trainer_id'])) {
//        set_err('กรุณากรอกรหัสครูฝึก');
//        $valid = false;
//    }
    if (check_pid($data['citizen_id'])) {
        set_err('กรุณากรอกเลขบัตรประชาชน');
        $valid = false;
    }
    if (empty($data['business_id'])) {
        set_err('กรุณากรอกรหัสสถานประกอบการ');
        $valid = false;
    }
    if (empty($data['minor_id'])) {
        set_err('กรุณากรอกรหัสสาขางาน');
        $valid = false;
    }
    if (empty($data['trainer_id'])) {
        set_err('กรุณากรอกรหัสครูฝึก');
        $valid = false;
    }
    if (empty($data['contract_date'])) {
        set_err('กรุณาเลือกวันทำสัญญา');
        $valid = false;
    }
    if (empty($data['start_date'])) {
        set_err('กรุณาเลือกวันเริ่มฝึกงาน');
        $valid = false;
    }
    if (empty($data['end_date'])) {
        set_err('กรุณาเลือกวันสุดท้ายฝึกงาน');
        $valid = false;
    }
    return $valid;
}

function do_insert($school_id) {
    global $db;
    $data = &$_POST;
    $query = "INSERT INTO training (`training_id`,`citizen_id`,`business_id`,`school_id`,`minor_id`,`trainer_id`,`contract_date`,`start_date`,`end_date`)  VALUES (NULL," . pq($data['citizen_id']) . "," . pq($data['business_id']) . "," . pq($school_id) . "," . pq($data['minor_id']) . "," . pq($data['trainer_id']) . "," . pq($data['contract_date']) . "," . pq($data['start_date']) . "," . pq($data['end_date']) . ")";
    mysqli_query($db, $query);
    if (mysqli_affected_rows($db) > 0) {
        set_info('บันทึกข้อมูลเรียบร้อย');
    } else {
        set_err('บันทึกข้อมูลไม่สำเร็จ ' . mysqli_error($db));
    }
    redirect('app/training/insert');
}
