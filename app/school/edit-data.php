<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "แก้ไขข้อมูลสถานศึกษา";
$active = 'school';
$subactive = 'edit';
//global $school_id;
$school_id = $_SESSION['user']['school_id'];
//$check=$_GET['action'];
// is_admin('home/index');
if (isset($_POST['submit'])) {
    $data = $_POST;
    $valid = do_validate($data);
    // 	check ความถูกต้องของข้อมูล
    if (!$valid) {
        //  show_message();
        foreach ($_POST as $k => $v) {
            $k = $v;
            // 			set variable to form
        }
    } else {
        do_update();
        // echo  "school=>".$school_id;
        //	ไม่มี error บันทึกข้อมูล
    }
}
//    $property = array();
    $school = get_school($school_id);
    if($school){
        foreach ($school as $key => $value) {
            $$key = $value;
        }
    }else{
        $school_name = get_school_name($school_id);
    }
//    var_dump($school);
//    exit();
    // if ($_GET['action'] == 'edit') {
    //     list_form_edit();
    //     var_dump()
    //  }
//    if ($_GET['action'] == 'del') {
//        do_delete($school_id);
//        echo "scho=>".$school_id;
//    }

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
                รายการสถานศึกษา
                <small>สถานศึกษา</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">สถานศึกษา</a></li>
                <li class="active">รายการ</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <?php show_message() ?> 
                <div class="box-header">
                    <h3 class="box-title">ข้อมูลสถานศึกษา</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="form-horizontal" action="" method="post">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="school_id">รหัสสถานศึกษา:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" readonly="readonly" name="school_id" value="<?php set_var($school_id) ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="school_name">ชื่อสถานศึกษา:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" readonly="" name="school_name" value="<?php set_var($school_name) ?>">
                            </div>
                        </div>
                        <?php $sql = "SELECT * FROM school_type" ?>
                        <div class="form-group">
                            <label for="school_type_id" class="col-md-2 control-label">ประเภทของสถานศึกษา:</label>
                            <div class="col-md-3">
                                <select class="form-control" id="catagory"name="school_type_id">
                                    <?php echo gen_option($sql, $school_type_id) ?>
                                </select>
                            </div>
                        </div>   

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="address_no">ที่อยู่:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="address_no" value="<?php set_var($address_no) ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="road">ถนน:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="road" value="<?php set_var($road) ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="province_id" class="col-md-2 control-label">จังหวัด</label>
                            <div class="col-md-3">
                                <select class="form-control select2-single" id="province_id" name="province_id">
                                    <option id="province_list" > -- กรุณาเลือกจังหวัด -- </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="aumphur_id" class="col-md-2 control-label">อำเภอ</label>
                            <div class="col-md-3">
                                <select class="form-control select2-single" id="aumphur_id" name="aumphur_id">
                                    <option id="amphur_id_list"> -- กรุณาเลือกอำเภอ -- </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="district_id" class="col-md-2 control-label">ตำบล</label>
                            <div class="col-md-3">
                                <select class="form-control select2-single" id="district_id" name="district_id">
                                    <option id="district_id_list"> -- กรุณาเลือกตำบล -- </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="postcode">รหัสไปรษณีย์:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="postcode" value="<?php set_var($postcode) ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="phone">โทรศัพท์:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="phone" value="<?php set_var($phone) ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="postcode">โทรสาร:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="fax" value="<?php set_var($fax) ?>">
                            </div>
                        </div>
                                <div class="form-group"> 
                                    <label class="control-label col-sm-2" for="zone">ภาค:</label>
                                    <div class="col-sm-3">
                                        <select class='form-control' id="zone" name="zone">
                                            <?php
                                            $def = isset($zone) ? $zone : '1';
                                            $sql = "SELECT zone_id As zone,zoneName FROM zone ORDER BY zone_id ASC";
                                            echo gen_option($sql, $def)
                                            ?>
                                        </select>              
                                    </div>
                                </div>

<!--                        <div class="form-group">
                            <label class="control-label col-sm-2" for="zone">ภาค:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="zone" value="<?php set_var($zone) ?>">
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label for="location" class="col-md-2 control-label">พิกัดที่ตั้ง</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="do_location" name="location" value="<?php set_var($location) ?>" placeholder="x,y" >
                            </div>
                        </div>
                        <?php $catagories = array('รัฐบาล' => 'รัฐบาล', 'เอกชน' => 'เอกชน', 'อื่นๆ' => 'อื่นๆ') ?>
                        <div class="form-group">
                            <label for="catagory" class="col-md-2 control-label">สังกัดหน่วยงาน</label>
                            <div class="col-md-2">
                                <select class="form-control" id="catagory"name="catagory">
                                    <?php echo gen_option($catagories, $catagory) ?>
                                </select>
                            </div>
                        </div>   


                        <div class="form-group"> 
                            <label class="control-label col-md-2 control-label " for="institute_id">รหัสสถาบัน</label>
                            <div class="col-md-6 "><input type="text" class="form-control" id="institute_id" placeholder="ชื่อสถาบัน" name="institute" value="<?php set_var($institute_id) ?>">

                            </div>
                        </div>
                        <div class="form-group">        
                            <div class="col-sm-offset-2 col-sm-6">
                                <input type="submit" name="submit" value="บันทึกแก้ไขข้อมูล" class="btn btn-default" >
                            </div>
                        </div>

                    </form>
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
    $(function () {

        $("#institute_id").autocomplete({
            source: "<?php echo SITE_URL ?>ajax/search_institute_1.php",
            minLength: 1
        });

    });
</script>
<script>
    $(function () {

        //เรียกใช้งาน Select2
        $(".select2-single").select2();

        //ดึงข้อมูล province จากไฟล์ get_data.php
        $.ajax({
            url: "<?php echo SITE_URL ?>ajax/get_data.php",
            dataType: "json", //กำหนดให้มีรูปแบบเป็น Json
            data: {show_province: 'show_province'}, //ส่งค่าตัวแปร show_province เพื่อดึงข้อมูล จังหวัด
            success: function (data) {

                //วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data
                $.each(data, function (index, value) {
                    //แทรก Elements ใน id province  ด้วยคำสั่ง append
                    $("#province_id").append("<option value='" + value.id + "'> " + value.name + "</option>");
                });
                var province = "<?php echo $province_id ?>";
                if (isNaN(province)) {
                    $("#province_id").find('option:eq(0)').prop('selected', true);
//                    console.log(province)
                } else {
                    $("#province_id").val("<?php echo $province_id ?>");
                }
                $("#province_id").change();
            }
        });


        //แสดงข้อมูล อำเภอ  โดยใช้คำสั่ง change จะทำงานกรณีมีการเปลี่ยนแปลงที่ #province
        $("#province_id").change(function () {

            //กำหนดให้ ตัวแปร province มีค่าเท่ากับ ค่าของ #province ที่กำลังถูกเลือกในขณะนั้น
            var province_id = $(this).val();

            $.ajax({
                url: "<?php echo SITE_URL ?>ajax/get_data.php",
                dataType: "json", //กำหนดให้มีรูปแบบเป็น Json
                data: {province_id: province_id}, //ส่งค่าตัวแปร province_id เพื่อดึงข้อมูล อำเภอ ที่มี province_id เท่ากับค่าที่ส่งไป
                success: function (data) {

                    //กำหนดให้ข้อมูลใน #amphur เป็นค่าว่าง
                    $("#aumphur_id").text("");

                    //วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data  
                    $.each(data, function (index, value) {

                        //แทรก Elements ข้อมูลที่ได้  ใน id amphur  ด้วยคำสั่ง append
                        $("#aumphur_id").append("<option value='" + value.id + "'> " + value.name + "</option>");
                    });
                    var aumphur = "<?php echo $aumphur_id ?>"
                    if (isNaN(aumphur)) {
                        $("#aumphur_id").find('option:eq(0)').prop('selected', true);
//                        console.log(province)
                    } else {
                        $("#aumphur_id").val("<?php echo $aumphur_id ?>");
                    }
                    $("#aumphur_id").change();
                }
            });

        });

        //แสดงข้อมูลตำบล โดยใช้คำสั่ง change จะทำงานกรณีมีการเปลี่ยนแปลงที่  #amphur
        $("#aumphur_id").change(function () {
            //กำหนดให้ ตัวแปร amphur_id มีค่าเท่ากับ ค่าของ  #amphur ที่กำลังถูกเลือกในขณะนั้น
            var amphur_id = $(this).val();
            $.ajax({
                url: "<?php echo SITE_URL ?>ajax/get_data.php",
                dataType: "json", //กำหนดให้มีรูปแบบเป็น Json
                data: {amphur_id: amphur_id}, //ส่งค่าตัวแปร amphur_id เพื่อดึงข้อมูล ตำบล ที่มี amphur_id เท่ากับค่าที่ส่งไป
                success: function (data) {
//                                console.log(JSON.stringify(data))
                    //กำหนดให้ข้อมูลใน #district เป็นค่าว่าง
                    $("#district_id").text("");

                    //วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data  
                    $.each(data, function (index, value) {
                        //แทรก Elements ข้อมูลที่ได้  ใน id district  ด้วยคำสั่ง append
                        $("#district_id").append("<option value='" + value.id + "'> " + value.name + "</option>");

                    });
                    var district = "<?php echo $district_id ?>"
//                                console.log(district)
                    if (isNaN(district)) {
                        $("#district_id").find('option:eq(0)').prop('selected', true);
                    } else {
                        $("#district_id").val("<?php echo $district_id ?>");
                    }
                    $("#district_id").change();
                }
            });

        });

        //คำสั่ง change จะทำงานกรณีมีการเปลี่ยนแปลงที่  #district 
        $("#district_id").change(function () {
            var district_id = $(this).val();
            $.ajax({
                url: "<?php echo SITE_URL ?>ajax/get_data.php",
                dataType: "json", //กำหนดให้มีรูปแบบเป็น Json
                data: {district_id: district_id}, //ส่งค่าตัวแปร amphur_id เพื่อดึงข้อมูล ตำบล ที่มี amphur_id เท่ากับค่าที่ส่งไป
                success: function (data) {
                    $("#postcode").val(data[0].id);
                }
            });

            //นำข้อมูลรายการ จังหวัด ที่เลือก มาใส่ไว้ในตัวแปร province
            var province = $("#province_id option:selected").text();

            //นำข้อมูลรายการ อำเภอ ที่เลือก มาใส่ไว้ในตัวแปร amphur
            var amphur = $("#aumphur_id option:selected").text();

            //นำข้อมูลรายการ ตำบล ที่เลือก มาใส่ไว้ในตัวแปร district
            var district = $("#district_id option:selected").text();

            //ใช้คำสั่ง alert แสดงข้อมูลที่ได้
//                alert("คุณได้เลือก :  จังหวัด : " + province + " อำเภอ : "+ amphur + "  ตำบล : " + district );
        });
    });

</script>


<?php

//function do_delete($school_id) {
//    global $db;
//    if (empty($school_id)) {
//        set_err('ค่าพารามิเตอร์รหัสสถานศึกษาไม่ถูกต้อง11');
//        redirect('school/list-school');
//    }
//    $query = "DELETE FROM school WHERE school_id =" . pq($school_id);
//    mysqli_query($db, $query);
//    if (mysqli_affected_rows($db)) {
//        set_info('ลบข้อมูลสำเร็จ');
//    }
//    redirect('school/list-school');
//}

function do_update() {
    global $db;
    //$data = &$_POST;
    $data = &$_POST;
    //	var_dump($data);
    //  exit();

    $sql = "update school  set "
            . "school_name=" . pq($data['school_name']) . ","
            . "school_type_id=" . pq($data['school_type_id']) . ","
            . "address_no=" . pq($data['address_no']) . ","
            . "road=" . pq($data['road']) . ","
            . "address_no=" . pq($data['address_no']) . ","
            . "road=" . pq($data['road']) . ","
            . "district_id=" . pq($data['district_id']) . ","
            . "aumphur_id=" . pq($data['aumphur_id']) . ","
            . "province_id=" . pq($data['province_id']) . ","
            . "postcode=" . pq($data['postcode']) . ","
            . "phone=" . pq($data['phone']) . ","
            . "fax=" . pq($data['fax']) . ","
            . "zone=" . pq($data['zone']) . ","
            . "location=" . pq($data['location']) . ","
            . "catagory=" . pq($data['catagory']) . ","
            . "institute_id=" . pq($data['institute'])
            . " WHERE "
            . "school_id = " . pq($data['school_id']) . "";
    $result = mysqli_query($db, $sql);
    if ($result) {
        set_info("แก้ไขเรียบร้อยครับ");
//        redirect('school/list-data-school');
    } else {
        set_err("แก้ไขข้อมูลไม่สำเร็จกรุณาตรวจสอบข้อมูล" . mysqli_error($db) . $sql);
//        redirect('school/list-data_school');
    }
    redirect('app/school/list-data');
}

function do_validate($data) {
    $valid = TRUE;

    if (empty($data['school_type_id'])) {
        set_err('กรุณาใส่รหัสประเภทของสถานศึกษา');
        $valid = FALSE;
    }
    if (empty($data['address_no'])) {
        set_err('กรุณาใส่ชื่อที่อยู่');
        $valid = FALSE;
    }
    if (empty($data['road'])) {
        set_err('กรุณาใส่ชื่อถนน');
        $valid = FALSE;
    }
    if (empty($data['district_id'])) {
        set_err('กรุณาใส่ตำบล');
        $valid = FALSE;
    }
    if (empty($data['aumphur_id'])) {
        set_err('กรุณาใส่ชื่ออำเภอ');
        $valid = FALSE;
    }
    if (empty($data['province_id'])) {
        set_err('กรุณาใส่ชื่อจังหวัด');
        $valid = FALSE;
    }
    if (empty($data['postcode'])) {
        set_err('กรุณาใส่รหัสไปรษณีย์');
        $valid = FALSE;
    }
    if (empty($data['phone'])) {
        set_err('กรุณาใส่เบอร์โทรศัพท์');
        $valid = FALSE;
    }
    if (empty($data['fax'])) {
        set_err('กรุณาใส่เบอร์ Fax');
        $valid = FALSE;
    }
    if (empty($data['zone'])) {
        set_err('กรุณาใส่ภาค');
        $valid = FALSE;
    }
    return $valid;
    /* ----End Validate ---- */
}

function get_school($school_id = NULL) {
    global $db;
    $sql = "SELECT * FROM school where school_id = '$school_id';";
//    echo $sql;
    $rs = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($rs);
//    var_dump($row);
//    die();
    return $row;
}

function list_form_edit() {
    global $school_id;
    global $db;
    $sql = "SELECT * from school WHERE school_id='$school_id'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result);
    return $row;
}
function get_school_name($param) {
    global $db;
    $sql  = "SELECT school_name FROM school WHERE school_id =".pq($param);
    $sql = "SELECT * from school WHERE school_id='$school_id'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result);
    return $row['school_name'];
}
?>    
