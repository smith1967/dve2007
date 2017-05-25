<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "เพิ่มข้อมูลครูฝึก";
$active = 'trainer';
$property = array();
$benefit = array();
$subactive = 'insert';
if (isset($_POST['submit'])) {
    $data = $_POST;
//    var_dump($data);
//    die();
    $valid = do_validate($data);  // check ความถูกต้องของข้อมูล
    foreach ($_POST as $k => $v) {
        $$k = $v;
    }  //    var_dump($property);
    if ($valid) {
        do_insert();
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

<!--                    <div class="form-group">
                        <label for="trainer_id" class="col-md-3 control-label">รหัสครูฝึก</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="trainer_id" name="trainer_id"value="<?php set_var($trainer_id); ?>">
                        </div>
                    </div>-->


                    <div class="form-group">
                        <label for="trainer_name" class="col-md-3 control-label">ชื่อครูฝึก</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="trainer_name" name="trainer_name"value="<?php set_var($trainer_name); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="trainer_citizen" class="col-md-3 control-label">เลขประจำตัวประชาชน</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="trainer_citizen" name="trainer_citizen"value="<?php set_var($trainer_citizen); ?>">
                        </div>
                    </div>    

                    <div class="form-group">
                        <label for="phone" class="col-md-3 control-label">เบอร์โทรศัพท์</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="phone" name="phone"value="<?php set_var($phone); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-md-3 control-label">ที่อยู่</label>
                        <div class="col-md-4">
                            <textarea class="form-control" id="address" rows="3" name="address" ><?php set_var($address); ?></textarea>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" id="business_id" name="business_id" placeholder="ชื่อสถานประกอบการ" value="<?php set_var($business_id); ?>">
                    <div class="form-group">
                        <label for="business_name" class="col-md-3 control-label">สถานประกอบการ</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="business_name" name="business_name" placeholder="ชื่อสถานประกอบการ" value="<?php set_var($business_name); ?>">
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="control-label col-md-3" for="educational_id">ระดับการศึกษาสูงสุด</label>
                        <div class="col-md-2">
                            <select class='form-control' id="educational_id" name="educational_id">
                                <?php
                                $def = isset($educational_id) ? $educational_id : '2';
                                $sql = "SELECT educational_id,educational_name FROM educational ORDER BY educational_id ASC";
                                echo gen_option($sql, $def)
                                ?>
                            </select>              
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="control-label col-md-3" for="trainer_experience">ประสบการณ์ในอาชีพที่สำเร็จการศึกษา</label>
                       <div class="col-md-2">
                            <select class='form-control' id="trainer_experience" name="trainer_experience">
                                <?php
                                $def = isset($trainer_experience) ? $trainer_experience : 'ต่ำกว่า 3 ปี';
                                //$sql = "SELECT trainer_property_id,trainer_property FROM trainer_property ORDER BY trainer_property_id ASC";
                                $exper_data = array('1'=>'ต่ำกว่า 3 ปี', 
                                                '2'=>'3 ปี','3'=>'5 ปี','4'=>'มากกว่า 5 ปี');
                                echo gen_option($exper_data, $def)
                                ?>
                            </select>
                            
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="assign_date" class="col-md-3 control-label">วันที่ได้รับการแต่งตั้งเป็นครูฝึก</label>
                        <div class="col-md-2">
                            <input type="date" class="form-control" id="assign_date" name="assign_date"value="<?php set_var($assign_date); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="trainer_method_assign" class="col-md-3 control-label">ได้รับการแต่งตั้งเป็นครูฝึก ด้วยวิธี</label>
                        <div class="col-md-4">
                            <select class='form-control' id="trainer_method_assign" name="trainer_method_assign">
                                <?php
                                $def = isset($trainer_method_assign) ? $trainer_method_assign : 'ผ่านการฝึกอบรม';
                                //$sql = "SELECT trainer_property_id,trainer_property FROM trainer_property ORDER BY trainer_property_id ASC";
                                $assign_data = array('T'=>'ผ่านการฝึกอบรม', 
                                                'E'=>'มีประสบการณ์การสอนมากกว่า 6 เดือน');
                                echo gen_option($assign_data, $def);
                                ?>
                            </select>
                            
                        </div>
                    </div>

<!--                 
                    

                    <div class="form-group"> 
                        <label class="control-label col-md-3" for="certificate">ผ่านการฝึกอบรมเป็นครูฝึก</label>
                        <div class="col-md-2">
                            <select class='form-control' id="certificate" name="certificate">
                                <?php
                                $def = isset($certificate) ? $certificate : 'P';
                                // $sql = "SELECT trainer_property_id,trainer_property FROM trainer_property ORDER BY trainer_property_id ASC";
                                $cert_data = array('P'=>'ผ่าน', 'N'=>'ไม่ผ่าน');
                                echo gen_option($cert_data, $def)
                                ?>
                            </select>              
                        </div>
                    </div>-->

                    <!--<div class="form-group">
                        <label for="property" class="col-md-3 control-label">ข้อมูลทำความร่วมมือจัดอาชีวศึกษา</label>
                        <div class="col-md-2">
                            <select class="form-control" id="property"name="property"value="<?php set_var($property); ?>">
                                <option value="P">ผ่านการฝึกอบรม</option>
                                <option value="E">มีประสบการณ์</option>
                                <option value="N">ไม่มีประสบการณ์</option>
                            </select>
                        </div>
                    </div>-->


                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-8">
                            <button type="submit" class="btn btn-sm-primary" name="submit">บันทึกข้อมูล</button>
                        </div>
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
        $("#business_name").autocomplete({
            source: "<?php echo SITE_URL ?>ajax/search_business_1.php",
            minLength: 2,
            select: function (event, ui) {
                $("#business_name").val(ui.item.label); // display the selected text
                $("#business_id").val(ui.item.value); // save selected id to hidden input
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
//        set_err('กรุณากรอกรหัสสครูฝึก');
//        $valid = false;
//    }
    if (!preg_match('/[a-zA-Z0-9_]{1,13}/', $data['trainer_citizen'])) {
        set_err('กรุณากรอกเลขบัตรประชาชน กรอกได้ 13 ตัว');
        $valid = false;
    }
    if (empty($data['trainer_name'])) {
        set_err('กรุณากรอกชื่อครูฝึก');
        $valid = false;
    }
    if (!preg_match('/[0-9]{1,}/', $data['phone'])) {
        set_err('กรุณากรอกเบอร์โทรศัพท์');
        $valid = false;
    }
    if (!preg_match('/[0-9]{1,}/', $data['address'])) {
        set_err('กรุณากรอกที่อยู่');
        $valid = false;
    }
    if (empty($data['business_name'])) {
        set_err('กรุณากรอกชื่อสถานประกอบการ');
        $valid = false;
    }
   
    if (!preg_match('/[0-9]{1,}/', $data['assign_date'])) {
        set_err('กรุณาเลือกวันที่แต่งตั้งเป็นครูฝึก');
        $valid = false;
    }
//    if (!preg_match('/[0-9]{1,}/', $data['educational'])) {
//        set_err('เลือกวุฒิการศึกษา');
//        $valid = false;
//    }
//    if (!preg_match('/[0-9]{1,}/', $data['certificate_date'])) {
//        set_err('กรุณาเลือกวันที่ออกใบรับฝึกงาน');
//        $valid = false;
//    }
//    if (!preg_match('/[a-zA-Z0-9_]{1,}/', $data['property'])) {
//        set_err('กรุณาเลือคุณสมบัติของครูฝึก');
//        $valid = false;
//    }

    return $valid;
}

function do_insert() {
    global $db;
    $data = &$_POST;
    $query = "INSERT INTO trainer (`trainer_id`, `trainer_citizen`, `trainer_name`, `phone`, `address`, `business_id`, `educational_id`, `trainer_experience`,`assign_date`, `trainer_method_assign`) VALUES (NULL," . pq($data['trainer_citizen']) . "," . pq($data['trainer_name']) . "," . pq($data['phone']) . "," . pq($data['address']) . "," . pq($data['business_id']) . "," . pq($data['educational_id']) . "," . pq($data['trainer_experience']) . "," . pq($data['assign_date']) . "," . pq($data['trainer_method_assign']) .")";
    mysqli_query($db, $query);
    if (mysqli_affected_rows($db) > 0) {
        set_info('เพิ่มข้อมูลสำเร็จ');
    } else {
        set_err('ไม่สามารถเพิ่มข้อมูล ' . mysqli_error($db));
    }
    redirect('app/trainer/list');
}
