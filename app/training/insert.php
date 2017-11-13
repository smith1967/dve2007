<?php
if (!defined('BASE_PATH'))
  exit('No direct script access allowed'); 
$title = "เพิ่มข้อมูลการฝึกงาน";
$active = 'training';
$school_id = $_SESSION['user']['school_id'];
$subactive = 'insert';
if (isset($_POST['submit'])) {
    $data = $_POST;
//    var_dump($data);
//    die();
    $valid = do_validate($data);  // check ความถูกต้องของข้อมูล
    if ($valid) {
//        foreach ($data['trainer_id_list'] as $trainer_id) {
        do_insert($school_id);
//            var_dump($trainer_id);
//        }
//        die();
    } else {
        foreach ($_POST as $key => $value) {
            if (is_array($key)) {
                foreach ($key as $k => $v) {
                    $$k = $v;
                }
            } else {
                $$key = $value;  // set variable to form                
            }
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
                กรอกข้อมูลการฝึกอาชีพ
                <small>แบบฟอร์ม</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">การฝึกอาชีพ</a></li>
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
                            <h3 class="box-title">เพิ่มข้อมูลการฝึกอาชีพ</h3> 
                            <span class="pull-right">
                                <a href="<?php echo site_url('app/trainer/insert') ?>" class="btn  btn-primary ">+ เพิ่มข้อมูลครูฝึก</a>
                                <a href="<?php echo site_url('app/business/insert') ?>" class="btn  btn-primary ">+ เพิ่มข้อมูลสถานประกอบการ</a>
                            </span>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <form method="post" class="form-horizontal" id="training-form" action=""> 
                                <input type="hidden" class="form-control" readonly="" id="school_id" placeholder="ชื่อสถานศึกษา" name="school_id" value="<?php set_var($school_id) ?>">
                                <input type="hidden" class="form-control" id="citizen_id" name="citizen_id" value="<?php set_var($citizen_id) ?>">
                                <div class="form-group"> 
                                    <label class="control-label col-md-3" for="std_name">ชื่อนักศึกษา</label>
                                    <div class="col-md-3 ">
                                        <input type="text" class="form-control" id="std_name" placeholder="ชื่อนักศึกษา" name="std_name" value="<?php set_var($std_name) ?>">
                                    </div>
                                    <p class="text-danger" id="citizen_id_error">*ยังไม่ได้เลือกนักศึกษาครับ</p>
                                </div>
                                <input type="hidden" class="form-control" id="business_id"  name="business_id" value="<?php set_var($business_id) ?>">
                                <div class="form-group"> 
                                    <label class="control-label col-md-3" for="business_name">ชื่อสถานประกอบการ</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="business_name" placeholder="ชื่อสถานประกอบการ" name="business_name" value="<?php set_var($business_name) ?>">
                                    </div>
                                    <p class="text-danger" id="business_id_error">*ยังไม่ได้เลือกสถานประกอบการครับ</p>
                                </div>

                                <div class="form-group">
                                    <label for="trainer_id_list" class="col-md-3 control-label">ครูฝึก</label>
                                    <div class="col-md-5">
                                        <select class="select2-mulitple form-control" id="trainer_id_list" name="trainer_id_list[]" multiple="multiple">
                                            <!--<option id="trainer_id_list"> -- กรุณาเลือกครูฝึก -- </option>-->
                                        </select>
                                    </div>
                                    <p class="text-danger" id="trainer_id_error">*ยังไม่ได้เลือกครูฝึกหรือยังไม่มีครูฝึกครับ</p>
                                    <!--<h5 class="text-info">*ถ้าไม่พบครูฝึกกรุณาไปเพิ่มครูฝึกก่อนครับ</h5>-->
                                </div>                                
                                <input type="hidden" class="form-control" id="minor_id" name="minor_id" value="<?php set_var($minor_id) ?>">
                                <div class="form-group"> 
                                    <label class="control-label col-md-3" for="minor_name">ชื่อสาขางาน</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="minor_name" placeholder="ชื่อสาขางาน" name="minor_name" value="<?php set_var($minor_name) ?>">
                                    </div>
                                    <p class="text-danger" id="minor_id_error">*ยังไม่ได้เลือกสาขางานครับ</p>
                                </div>

                               <div class="form-group">
                                 <label class="control-label col-md-3" for="contract_date">วันที่ทำสัญญา</label>

                                 <div class="input-group date col-md-2">
                                   <div class="input-group-addon">
                                     <i class="fa fa-calendar"></i>
                                   </div>
                                   <input type="text" class="form-control pull-right" id="contract_date" name="contract_date" value="<?php set_var($contract_date) ?>" />
                                 </div>
                                 <!-- /.input group -->
                               </div>
                               <!-- /.form group -->

                                <!-- Date -->
                               <div class="form-group">
                                 <label class="control-label col-md-3" for="start_date">วันเริ่มต้นการฝึก</label>

                                 <div class="input-group date col-md-2">
                                   <div class="input-group-addon">
                                     <i class="fa fa-calendar"></i>
                                   </div>
                                   <input type="text" class="form-control pull-right" id="start_date" name="start_date" value="<?php set_var($start_date) ?>" />
                                 </div>
                                 <!-- /.input group -->
                               </div>                                

                               <div class="form-group">
                                 <label class="control-label col-md-3" for="end_date">วันที่สิ้นสุดการฝึก</label>

                                 <div class="input-group date col-md-2">
                                   <div class="input-group-addon">
                                     <i class="fa fa-calendar"></i>
                                   </div>
                                   <input type="text" class="form-control pull-right" id="end_date" name="end_date" value="<?php set_var($end_date) ?>" />
                                 </div>
                                 <div class="col-md-offset-3"><p class="text-danger" id="date_error">*เลือกวันเดือนปีให้ครบด้วยครับ</p> </div>
                                 <!-- /.input group -->
                               </div>

                                <div class="box-footer">
                                    <div class="col-md-offset-3"><button type="submit" class="btn btn-primary" name="submit">บันทึกข้อมูล</button></div>
                                </div>

                            </form>
                        </div>
                        <!-- /.box-body -->
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
        //Date picker        
        $('#start_date').datepicker({
            format: "yyyy/mm/dd",
            language: "th",
            autoclose: true
        });
        $('#contract_date').datepicker({
            format: "yyyy/mm/dd",
            language: "th",
            autoclose: true
        });
        $('#end_date').datepicker({
            format: "yyyy/mm/dd",
            language: "th",
            autoclose: true
        });        
        $("#trainer_id_list").prop("disabled",true);

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
            },
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
        // Validate data
        $("#citizen_id_error").hide();
        $("#business_id_error").hide();
        $("#trainer_id_error").hide();
        $("#minor_id_error").hide();
        $("#date_error").hide();
        
        $("#training-form").submit(function(event){
            var valid_citizen_id = false
            if($('#citizen_id').val()!=""){
                valid_citizen_id = true;
                $("#citizen_id_error").hide();
            }else{
                $("#citizen_id_error").show();
            }
            var valid_business_id
            if($('#business_id').val()!=""){
                valid_business_id = true;
                $("#business_id_error").hide();
            }else{
                $("#business_id_error").show();
            }            
            var valid_trainer_id = false;
            $('#trainer_id_list option').each(function() {
                if ($(this).prop("selected") == true) {
//                   alert($(this).val() + " is selected");
                   valid_trainer_id = true
                } 
            });
            if(valid_trainer_id == false){               
                $("#trainer_id_error").show();
            }
            var valid_minor_id = false;
            if($('#minor_id').val()!=""){
                valid_minor_id = true;
                $("#minor_id_error").hide();
            }else{
                $("#minor_id_error").show();
            }   
            var valid_date = false;
            if($('#start_date').val()!="" && $('#end_date').val()!="" && $('#contract_date').val()!=""){
                valid_date = true;
                $("#date_error").hide();
            }else{
                $("#date_error").show();
            }
           if (valid_citizen_id && valid_business_id && valid_trainer_id && valid_minor_id && valid_date){
//               alert("submit ok")
               return ;
            }           
            event.preventDefault();
        });
    });
    $(".select2-mulitple").select2();
    //ดึงข้อมูล province จากไฟล์ get_data.php
    $("#business_id").change(function () {
        $("#trainer_id_list").prop("disabled",false);
//        alert('test');
        $.ajax({
            url: "<?php echo SITE_URL ?>ajax/get_trainers.php",
            dataType: "json", //กำหนดให้มีรูปแบบเป็น Json
            data: {q: $("#business_id").val()}, //ส่งค่าตัวแปร show_province เพื่อดึงข้อมูล จังหวัด
            success: function (data) {
                //วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data
                $("#trainer_id_list").empty();
                $.each(data, function (index, value) {
                    //แทรก Elements ใน id province  ด้วยคำสั่ง append
                    $("#trainer_id_list").append("<option value='" + value.id + "' > " + value.name + "</option>");
                });
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
    if (check_pid($data['citizen_id']) && !preg_match('/[0-9]{13}/', $data['citizen_id'])) {
        set_err('รหัสนักศึกษาไม่ถูกต้อง');
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
//    if (empty($data['trainer_id'])) {
//        set_err('กรุณากรอกรหัสครูฝึก');
//        $valid = false;
//    }
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
    foreach ((array)$data['trainer_id_list'] as $trainer_id) {
        if (empty($trainer_id))
            continue;
//             do_insert($school_id,$trainer_id);
//            var_dump($trainer_id);
        $query = "INSERT INTO training ("
                . "`training_id`,`citizen_id`,"
                . "`business_id`,`school_id`,"
                . "`minor_id`,`trainer_id`,"
                . "`contract_date`,`start_date`,"
                . "`end_date`)  "
                . "VALUES "
                . "(NULL," . pq($data['citizen_id']) . ","
                . pq($data['business_id']) . "," . pq($school_id) . ","
                . pq($data['minor_id']) . "," . pq($trainer_id) . ","
                . pq($data['contract_date']) . "," . pq($data['start_date']) . ","
                . pq($data['end_date']) . ")";
        mysqli_query($db, $query);
        if (mysqli_affected_rows($db) > 0) {
            set_info('บันทึกข้อมูลเรียบร้อย');
        } else {
            set_err('บันทึกข้อมูลไม่สำเร็จ ' . mysqli_error($db));
        }
    }
    redirect('app/training/insert');
}
