<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "แก้ไขข้อมูลการฝึกงาน";
$active = 'training';
$subactive = 'edit';
//$subactive = 'edit-group-config';
if (isset($_POST['submit'])) {
    $data = $_POST;
//    var_dump($data);
    $valid = do_validate($data);  // check ความถูกต้องของข้อมูล
    foreach ($_POST as $k => $v) {
        $$k = $v;  // set variable to form
    }
    if ($valid) {
        do_update();
    }
}
if (!isset($_GET['training_id']))
    redirect('app/training/list');
if ($_GET['training_id']) {
    $training_data = get_training($_GET['training_id']);
    foreach ($training_data as $key => $value) {
        $$key = $value;
    }
//    var_dump($training_data);
//    die();
//    var_dump($training);
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
                กรอกข้อมูลฝึกอาชีพ
                <small>แบบฟอร์ม</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">ฝึกอาชีพ</a></li>
                <li class="active">แก้ไขข้อมูล</li>
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
                            <h3 class="box-title">แก้ไขข้อมูลฝึกอาชีพ</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form method="post" class="form-horizontal" action=""> 
                            <!--                <div class="form-group"> 
                                                <label class="control-label col-md-3" for="training_id">รหัสการฝึกอาชีพ</label>
                                                <div class="col-md-4 "><input type="text" class="form-control" id="training_id" name="training_id"></div>
                                            </div>-->
                            <input type="hidden" class="form-control" id="training_id" name="training_id" value="<?php set_var($training_id) ?>">
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
                            <!--<input type="hidden" class="form-control" id="trainer_id" name="trainer_id" value="<?php set_var($trainer_id) ?>">-->
<!--                            <div class="form-group"> 
                                <label class="control-label col-md-3" for="trainer_name">ชื่อฝึกอาชีพ</label>
                                <div class="col-md-3 ">
                                    <input type="text" class="form-control" id="trainer_name" placeholder="ชื่อฝึกอาชีพ" name="trainer_name" value="<?php set_var($trainer_name) ?>">
                                </div>
                            </div>-->
                            <div class="form-group">
                                <label for="trainer_id" class="col-md-3 control-label">ครูฝึก</label>
                                <div class="col-md-6">
                                    <select class="form-control select2-mulitple" id="trainer_id" name="trainer_id" >
                                        <!--<option id="trainer_id_list"> -- กรุณาเลือกครูฝึก -- </option>-->
                                    </select>
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


                                <div class="box-footer">
                                    <div class="col-md-offset-3"><button type="submit" class="btn btn-primary" name="submit">บันทึกข้อมูล</button></div>
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
                $("#business_id").val(ui.item.value).trigger("change"); // save selected id to hidden input
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
    $(".select2-mulitple").select2();
    //ดึงข้อมูล province จากไฟล์ get_data.php
//    $("#business_id").load(function () {
//        alert('test');
        $.ajax({
            url: "<?php echo SITE_URL ?>ajax/get_trainers.php",
            dataType: "json", //กำหนดให้มีรูปแบบเป็น Json
            data: {q: $("#business_id").val()}, //ส่งค่าตัวแปร show_province เพื่อดึงข้อมูล จังหวัด
            success: function (data) {
                $("#trainer_id_list").empty();
                //วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data
                $.each(data, function (index, value) {
                    //แทรก Elements ใน id province  ด้วยคำสั่ง append
                    $("#trainer_id").append("<option value='" + value.id + "'> " + value.name + "</option>");
                });
                var t_id = "<?php echo $trainer_id ?>"
                $("#trainer_id").val(t_id);                
            },
                    
        });

//    });    
    
    $("#business_id").change(function () {
//        alert('test');
        $.ajax({
            url: "<?php echo SITE_URL ?>ajax/get_trainer.php",
            dataType: "json", //กำหนดให้มีรูปแบบเป็น Json
            data: {q: $("#business_id").val()}, //ส่งค่าตัวแปร show_province เพื่อดึงข้อมูล จังหวัด
            success: function (data) {
                //วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data
                $.each(data, function (index, value) {
                    //แทรก Elements ใน id province  ด้วยคำสั่ง append
                    $("#trainer_id").append("<option value='" + value.id + "'> " + value.name + "</option>");
                });
            }
        });
//        var t_id = "<?php echo $trainer_id ?>"
//        $("#trainer_id").val(t_id);
//        alert(2);
    });
//    $("#trainer_name").autocomplete({
//    source: function (request, response) {
//    $.ajax({
//            url: "<?php echo SITE_URL ?>ajax/search_trainer.php",
//            dataType: "json", //กำหนดให้มีรูปแบบเป็น Json
//            data: {q: $("#business_id").val()}, //ส่งค่าตัวแปร show_province เพื่อดึงข้อมูล จังหวัด
////            data: { query: request.term },
//            minLength: 2,
//            select: function (event, ui) {
//                    $("#trainer_name").val(ui.item.label); // display the selected text
//                    $("#trainer_id").val(ui.item.value); // save selected id to hidden input
//                    return false;
//                }
//            });
//        });

//        alert(t_id);
});
</script> 
<?php

function do_validate($data) {
    $valid = true;
    $data = &$_POST;
//    if (!preg_match('/[a-zA-Z0-9_]{1,}/', $data['training_id'])) {
//        set_err('กรุณากรอกรหัสฝึกอาชีพ');
//        $valid = false;
//    }
    if (check_pid($data['citizen_id']) && !preg_match('/[0-9]{13}/', $data['citizen_id'])) {
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

function do_update() {
    global $db;
    $data = &$_POST;
    //print_r($data['property']);
    $query = "UPDATE `training` SET `citizen_id`="
            . pq($data['citizen_id']) . ",`business_id`=" . pq($data['business_id'])
            . ",`business_id`=" . pq($data['business_id'])
            . ",`minor_id`=" . pq($data['minor_id'])
            . ",`trainer_id`=" . pq($data['trainer_id'])
            . ",`contract_date`=" . pq($data['contract_date'])
            . ",`start_date`=" . pq($data['start_date'])
            . ",`end_date`=" . pq($data['end_date'])
            . " WHERE `training_id`=" . pq($data['training_id']) . ";";
    $result = mysqli_query($db, $query);
//    var_dump($query);
//    die();
    if (mysqli_affected_rows($db) == 0) {
        set_err('ไม่สามารถแก้ไขข้อมูล' . mysqli_error($db));
    } else {
        set_info('แก้ไขข้อมูลสำเร็จ');
    }
    redirect('app/training/list');
}

function get_training($training_id = NULL) {
    global $db;
    $sql = "SELECT "
            . "t1.*,s.std_name,b.business_name,m.minor_name,t2.trainer_name "
            . "FROM "
            . "training as t1,business as b,minor as m,trainer as t2,student as s "
            . "where "
            . "t1.citizen_id = s.citizen_id "
            . "AND "
            . "t1.business_id = b.business_id "
            . "AND "
            . "t1.minor_id = m.minor_id "
            . "AND "
            . "t1.trainer_id = t2.trainer_id "
            . "AND "
            . "training_id = '$training_id';";
//    var_dump($sql);
//    die();

    $rs = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($rs, MYSQLI_ASSOC);
    return $row;
}
