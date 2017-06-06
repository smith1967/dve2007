<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "แก้ไขข้อมูลการทำความร่วมมือ";
$active = 'mou';
$subactive = 'edit';
$property = array();
$benefit = array();

if (isset($_POST['submit'])) {
    $data = $_POST;
    //  var_dump($data);
    foreach ($_POST as $k => $v) {
        $$k = $v;  // set variable to form
    }
//    $property = $business['property'];
    $valid = do_validate($data);  // check ความถูกต้องของข้อมูล

    if ($valid) {
        do_editmou();
    }
} else if ($_GET['mou_id']) {
    $property = array();
    $mou = get_mou($_GET['mou_id']);
    // $property = explode(',', $business['property_id']);
    // $benefit = explode(',', $business['benefit_id']);
    foreach ($mou as $key => $value) {
        $$key = $value;
    }

//    var_dump($business);
//    exit();
} else {
    redirect('app/mou/list');
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
                แก้ไขข้อมูลการทำความร่วมมือ
                <small>แบบฟอร์ม</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">การทำความร่วมมือ</a></li>
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
                            <h3 class="box-title">mou Form</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">                        
                            <form method="post" class="form-horizontal" action="">
                                <input type="hidden" class="form-control" readonly="" id="mou_id" placeholder="" name="mou_id" value="<?php set_var($mou_id) ?>">
                                <input type="hidden" class="form-control" readonly="" id="school_id" placeholder="" name="school_id" value="<?php set_var($school_id) ?>">
                                <input type="hidden" class="form-control" readonly="" id="business_id" placeholder="" name="business_id" value="<?php set_var($business_id) ?>">
                                <div class="form-group"> 
                                    <label class="control-label col-md-3" for="business_name">สถานประกอบการ</label>
                                    <div class="col-md-5 ">
                                        <input type="text" class="form-control" id="business_name" placeholder="ชื่อสถานประกอบการ" name="business_name" value="<?php set_var($business_name) ?>">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="control-label col-md-3" for="mou_date">วันที่ลงนามความร่วมมือ</label>
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" id="mou_date" placeholder="yyyy/mm/dd" name="mou_date"value="<?php set_var($mou_date); ?>">
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label  class="control-label col-md-3 " for="director_name">ชื่อผู้อำนวยการสถานศึกษา</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" required="" id="director_name"name="director_name"value="<?php set_var($director_name); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="ceo_name">ชื่อผู้บริหารสถานประกอบการ</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" required="" id="ceo_name"name="ceo_name"value="<?php set_var($ceo_name); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3" for="mou_start_date">วันที่ทำความร่วมมือ</label>
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" id="mou_start_date" placeholder="yyyy/mm/dd" name="mou_start_date"value="<?php set_var($mou_start_date); ?>">
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="control-label col-md-3" for="mou_end_date">วันที่สิ้นสุดความร่วมมือ</label>
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" id="mou_end_date" placeholder="yyyy/mm/dd" name="mou_end_date"value="<?php set_var($mou_end_date); ?>">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="mou_sign_place" class="control-label col-md-3 ">สถานที่ลงนามความร่วมมือ</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" required="" id="mou_sign_place"name="mou_sign_place"value="<?php set_var($mou_sign_place); ?>">
                                    </div>
                                </div> 
                                <?php
                                $arr_plan = array('มี' => 'มี', 'ไม่มี' => 'ไม่มี');
                                ?>
                                <div class="form-group">
                                    <label for="studying_plan" class="col-md-3 control-label">แผนการเรียน</label>
                                    <div class="col-md-2">
                                        <select class="form-control" id="studying_plan" name="studying_plan">
                                            <?php echo gen_option($arr_plan, $studying_plan) ?>
                                        </select>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="training_plan" class="col-md-3 control-label">แผนการฝึกอาชีพ</label>
                                    <div class="col-md-2">
                                        <select class="form-control" id="training_plan" name="training_plan">
                                            <?php echo gen_option($arr_plan, $training_plan) ?>
                                        </select>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="supervision_plan" class="col-md-3 control-label">แผนการนิเทศ</label>
                                    <div class="col-md-2">
                                        <select class="form-control" id="supervision_plan" name="supervision_plan">
                                            <?php echo gen_option($arr_plan, $supervision_plan) ?>
                                        </select>
                                    </div>
                                </div> 
                                <?php
                                $arr_comp = array('ตรง' => 'ตรง', 'ไม่ตรง' => 'ไม่ตรง');
                                ?>
                                <div class="form-group">
                                    <label for="major_compatibility" class="col-md-3 control-label">ฝึกอาชีพตรงกับกับสาขาที่เรียน</label>
                                    <div class="col-md-2">
                                        <select class="form-control" id="major_compatibility" name="major_compatibility">
                                            <?php echo gen_option($arr_comp, $major_compatibility) ?>
                                        </select>
                                    </div>
                                </div>            
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-10">
                                        <button type="submit" class="btn btn-primary" name="submit">บันทึกข้อมูล</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
    });
</script> 

<?php

function do_validate($data) {
    $valid = true;
    $data = &$_POST;
//    if (empty($data['business_id'])) {
//        set_err('กรุณากรอกรหัสสถานประกอบการ');
//        $valid = false;
//    }
    if (empty($data['business_id'])) {
        set_err('กรุณากรอกชื่อสถานประกอบการ');
        $valid = false;
    }
    if (empty($data['mou_date'])) {
        set_err('กรุณากรอกวันที่ลงนามความร่วมมือ');
        $valid = false;
    }
    if (empty($data['director_name'])) {
        set_err('กรุณากรอกชื่อผู้อำนวยการสถานศึกษา');
        $valid = false;
    }
    if (empty($data['ceo_name'])) {
        set_err('กรุณากรอกชื่อผู้บริหารสถานประกอบการ');
        $valid = false;
    }
    if (empty($data['mou_start_date'])) {
        set_err('กรุณากรอกวันที่เริ่มความร่วมมือ');
        $valid = false;
    }
    if (empty($data['mou_end_date'])) {
        set_err('กรุณากรอกวันที่สิ้นสุดความร่วมมือ');
        $valid = false;
    }
    if (empty($data['mou_sign_place'])) {
        set_err('กรุณากรอกสถานที่ลงนามความร่วมมือ');
        $valid = false;
    }
    return $valid;
}

function do_editmou() {
    global $db;
    $data = &$_POST;
    //print_r($data['property']);
//    $arr_pro = $data['property'];
//    $pro = implode(",", $arr_pro);
    //echo $pro;
    //exit();
    $query = "update mou  set
	business_id=" . pq($data['business_id']) . ","
            . "mou_date=" . pq($data['mou_date']) . ","
            . "director_name=" . pq($data['director_name']) . ","
            . "ceo_name=" . pq($data['ceo_name']) . ","
            . "mou_start_date=" . pq($data['mou_start_date']) . ","
            . "mou_end_date=" . pq($data['mou_end_date']) . ","
            . "mou_sign_place=" . pq($data['mou_sign_place']) . ","
            . "studying_plan=" . pq($data['studying_plan']) . ","
            . "training_plan=" . pq($data['training_plan']) . ","
            . "supervision_plan=" . pq($data['supervision_plan']) . ","
            . "major_compatibility=" . pq($data['major_compatibility'])
            . " WHERE "
            . "mou_id = " . pq($data['mou_id']) . "";
    // echo $query; exit();
    $result = mysqli_query($db, $query);
    if (mysqli_affected_rows($db) > 0) {
        set_info('แก้ไขข้อมูลสำเร็จ');
    } else {
        set_err('ไม่สามารถแก้ไขข้อมูล' . mysqli_error($db));
    }
    redirect('app/mou/list');
}

function get_mou($mou_id = NULL) {
    global $db;
    $sql = "SELECT m.*,b.business_name FROM mou m JOIN business b ON m.business_id = b.business_id WHERE mou_id = '$mou_id';";
    $rs = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($rs);
    return $row;
}
