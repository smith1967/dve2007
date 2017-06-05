<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "แก้ไขข้อมูลสถานประกอบการ";
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
} else if ($_GET['business_id']) {
    $property = array();
    $business = get_business($_GET['business_id']);
    $property = explode(',', $business['property_id']);
    $benefit = explode(',', $business['benefit_id']);
    foreach ($business as $key => $value) {
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
                กรอกข้อมูลสถานประกอบการ
                <small>แบบฟอร์ม</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">สถานประกอบการ</a></li>
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
                            <h3 class="box-title">Business Form</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <form method="post" class="form-horizontal" action="">

                                <!--                    <div class="form-group">
                                                        <label for="business_id" class="col-md-2 control-label">รหัส</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control" required="" id="business_id" name="business_id"value="<?php set_var($business_id); ?>">
                                                        </div>
                                                    </div>-->
                                <input type="hidden" class="form-control" id="business_id" readonly="" name="business_id"value="<?php set_var($business_id); ?>">
                                <div class="form-group">
                                    <label for="business_name" class="col-md-2 control-label">ชื่อสถานประกอบการ</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" required="" id="business_name"name="business_name"value="<?php set_var($business_name); ?>">
                                    </div>
                                </div>
                                <?php
                                $business_opt = array('ไม่ระบุ' => 'ไม่ระบุ', 'เล็ก' => 'เล็ก', 'กลาง' => 'กลาง', 'ใหญ่' => 'ใหญ่');
                                ?>
                                <div class="form-group">
                                    <label for="business_size" class="col-md-2 control-label">ขนาดสถานประกอบการ</label>
                                    <div class="col-md-2">
                                        <select class="form-control" id="do_mou" name="business_size">
                                            <?php echo gen_option($business_opt, $business_size) ?>
                                        </select>
                                    </div>
                                </div>    

                                <div class="form-group">
                                    <label for="amount_emp" class="col-md-2 control-label">จำนวนพนักงาน</label>
                                    <div class="col-md-1">
                                        <input type="text" class="form-control" required="" id="amount_emp" name="amount_emp"value="<?php set_var($amount_emp); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="job_description" class="col-md-2 control-label">รายละเอียด</label>
                                    <div class="col-md-4">
                                        <textarea class="form-control" id="job_description" rows="3" name="job_description"><?php set_var($job_description); ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-offset-1">ที่ตั้งสถานประกอบการ</label>
                                </div>
                                <div class="form-group">
                                    <label for="province_id" class="col-md-2 control-label">จังหวัด</label>
                                    <div class="col-md-3">
                                        <select class="form-control select2" id="province_id" name="province_id">
                                            <option id="province_id_list"> -- กรุณาเลือกจังหวัด -- </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="aumphur_id" class="col-md-2 control-label">อำเภอ</label>
                                    <div class="col-md-3">
                                        <select class="form-control select2" id="aumphur_id" name="aumphur_id">
                                            <option id="amphur_id_list"> -- กรุณาเลือกอำเภอ -- </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="district_id" class="col-md-2 control-label">ตำบล</label>
                                    <div class="col-md-3">
                                        <select class="form-control select2" id="district_id" name="district_id">
                                            <option id="district_id_list"> -- กรุณาเลือกตำบล -- </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="postcode" class="col-md-2 control-label">รหัสไปรษณีย์</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" required="" id="postcode" name="postcode" value="<?php set_var($postcode); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address_no" class="col-md-2 control-label">เลขที่</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" required="" id="address_no" name="address_no"value="<?php set_var($address_no); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="road" class="col-md-2 control-label">ถนน</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="road" name="road"value="<?php set_var($road); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="land" class="col-md-2 control-label">ประเทศ</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="land" placeholder="ประเทศไทย" name="land" value="ประเทศไทย">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="capital" class="col-md-2 control-label">พิกัดแผนที่</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" placeholder="หาจาก google maps" id="capital" name="capital" value="<?php set_var($locattion); ?>">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="email" class="col-md-2 control-label">E-mail</label>
                                    <div class="col-md-3">
                                        <input type="email" class="form-control" id="email" placeholder="Kidakarn@gmail.com"name="email"value="<?php set_var($email); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="contact" class="col-md-2 control-label">ชื่อผู้ประสานงาน</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" required="" id="contact"name="contact"value="<?php set_var($contact); ?>">
                                    </div>
                                </div>  

                                <div class="form-group">
                                    <label for="contact_phone" class="col-md-2 control-label">เบอร์โทรศัพท์</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" required="" id="contact_phone" name="contact_phone" placeholder="xxx-xxx-xxxx"value="<?php set_var($contact_phone); ?>">
                                    </div>
                                </div> 

                                <?php
                                $do_mou_opt = array('N' => 'ไม่เคยทำ', 'Y' => 'เคยร่วมจัดทำ');
                                ?>
                                <div class="form-group">
                                    <label for="do_mou" class="col-md-2 control-label">ทำความร่วมมือจัดอาชีวศึกษา</label>
                                    <div class="col-md-2">
                                        <select class="form-control" id="do_mou" name="do_mou">
                                            <?php echo gen_option($do_mou_opt, $do_mou) ?>
                                        </select>
                                    </div>
                                </div>                       

                                <div class="form-group">
                                    <label for="registration_date" class="col-md-2 control-label">วันที่จดทะเบียน</label>
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" id="registration_date" placeholder="yyyy/mm/dd" name="registration_date"value="<?php set_var($registration_date); ?>">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="capital" class="col-md-2 control-label">ทุนการจดทะเบียน</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="capital"name="capital"value="<?php set_var($capital); ?>">
                                    </div>
                                </div>       
                                <div class="form-group">
                                    <label for="country" class="col-md-2 control-label">ประเทศต้นสังกัด</label>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" id="country" name="country"value="<?php set_var($country); ?>">
                                    </div>
                                </div>  
                                <?php $tax_break_opt = array('ใช้สิทธิ์' => 'ใช้สิทธิ์', 'กำลังดำเนินการ' => 'กำลังดำเนินการ', 'ไม่ใช้สิทธิ์' => 'ไม่ใช้สิทธิ์') ?>
                                <div class="form-group">
                                    <label for="tax_break" class="col-md-2 control-label">การลดหย่อนภาษี</label>
                                    <div class="col-md-2">
                                        <select class="form-control" id="tax_break"name="tax_break">
                                            <?php echo gen_option($tax_break_opt, $tax_break) ?>
                                        </select>
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label for="tax_break" class="control-label col-md-offset-1"><u>คำชี้แจง</u>กรุณาคลิกในช่องที่ตรงกับคุณลักษณะของสถานประกอบการ</label>
                                    <?php
                                    $sql = "select * from business_property order by property_id ASC";
                                    $result = mysqli_query($db, $sql);
                                    while ($rs = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                        ?>
                                        <div class="checkbox">
                                            <label class="col-md-offset-2">
                                                <input type="checkbox" 
                                                       name="property[]" 
                                                       value="<?php echo $rs['property_id'] ?>"
                                                       <?php echo in_array($rs['property_id'], $property) ? "checked=checked" : "" ?>
                                                       >
                                                       <?php echo $rs['descript'] ?>
                                            </label>
                                        </div>           
                                    <?php } ?>
                                </div> 
                                <div class="form-group">
                                    <label for="benefit" class="control-label col-md-offset-1"><u>คำชี้แจง</u>กรุณาคลิกในช่องที่ตรงกับสวัสดิการของสถานประกอบการ</label>
                                    <?php
                                    $sql = "select * from business_benefit order by benefit_id ASC";
                                    $result = mysqli_query($db, $sql);
                                    while ($rs = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                        ?>
                                        <div class="checkbox">
                                            <label class="col-md-offset-2">
                                                <input type="checkbox" 
                                                       name="benefit[]" 
                                                       value="<?php echo $rs['benefit_id'] ?>"
                                                       <?php echo in_array($rs['benefit_id'], $benefit) ? "checked=checked" : "" ?>
                                                       >
                                                       <?php echo $rs['name'] ?>
                                            </label>
                                        </div>           
                                    <?php } ?>
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
//                                console.log(JSON.stringify(data))
                    //กำหนดให้ข้อมูลใน #district เป็นค่าว่าง
//                                $("#postcode").val(JSON.stringify(data));

                    //วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data  
                    $.each(data, function (index, value) {
                        //แทรก Elements ข้อมูลที่ได้  ใน id district  ด้วยคำสั่ง append
//                                   console.log(index);
                        $("#postcode").val(value.id);
//                                $("#district_id").append("<option value='" + value.id + "'> " + value.name + "</option>");
                    });
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

                $("#province_id").val("<?php echo $province_id ?>");
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
                    $("#aumphur_id").val("<?php echo $aumphur_id ?>");
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

                    $("#district_id").val("<?php echo $district_id ?>");
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

function do_validate($data) {
    $valid = true;
    $data = &$_POST;
//    if (empty($data['business_id'])) {
//        set_err('กรุณากรอกรหัสสถานประกอบการ');
//        $valid = false;
//    }
    if (empty($data['business_name'])) {
        set_err('กรุณากรอกชื่อสถานประกอบการ');
        $valid = false;
    }
    if (empty($data['address_no'])) {
        set_err('กรุณากรอกเลขที่');
        $valid = false;
    }
    if (empty($data['district_id'])) {
        set_err('กรุณากรอกตำบล');
        $valid = false;
    }
    if (empty($data['aumphur_id'])) {
        set_err('กรุณากรอกอำเภอ');
        $valid = false;
    }
    if (empty($data['province_id'])) {
        set_err('กรุณากรอกจังหวัด');
        $valid = false;
    }
    if (!preg_match('/[0-9]{1,}/', $data['postcode'])) {
        set_err('กรุณากรอกรหัสไปรษณีย์');
        $valid = false;
    }
    if (empty($data['contact'])) {
        set_err('กรุณากรอกชื่อผู้ประสานงาน');
        $valid = false;
    }
    if (!preg_match('/[0-9]{1,}/', $data['contact_phone'])) {
        set_err('กรุณากรอกเบอร์โทรศัพท์');
        $valid = false;
    }

    return $valid;
}

function do_editbusiness() {
    global $db;
    $data = &$_POST;
    //print_r($data['property']);
//    $arr_pro = $data['property'];
//    $pro = implode(",", $arr_pro);
    //echo $pro;
    //exit();
    $query = "update business  set
	business_name=" . pq($data['business_name']) . ","
            . "job_description=" . pq($data['job_description']) . ","
            . "business_size=" . pq($data['business_size']) . ","
            . "amount_emp=" . pq($data['amount_emp']) . ","
            . "address_no=" . pq($data['address_no']) . ","
            . "road=" . pq($data['road']) . ","
            . "district_id=" . pq($data['district_id']) . ","
            . "aumphur_id=" . pq($data['aumphur_id']) . ","
            . "province_id=" . pq($data['province_id']) . ","
            . "postcode=" . pq($data['postcode']) . ","
            . "land=" . pq($data['land']) . ","
            . "location=" . pq($data['location']) . ","
            . "email=" . pq($data['email']) . ","
            . "contact=" . pq($data['contact']) . ","
            . "contact_phone=" . pq($data['contact_phone']) . ","
            . "do_mou=" . pq($data['do_mou']) . ","
            . "registration_date=" . pq($data['registration_date']) . ","
            . "capital=" . pq($data['capital']) . ","
            . "country=" . pq($data['country']) . ","
            . "tax_break=" . pq($data['tax_break']) . ","
            . "benefit_id=" . pq(implode(",", $data['benefit'])) . ","
            . "property_id=" . pq(implode(",", $data['property']))
            . " WHERE "
            . "business_id = " . pq($data['business_id']) . "";
//    echo $query; exit();
    $result = mysqli_query($db, $query);
    if (mysqli_affected_rows($db) > 0) {
        set_info('แก้ไขข้อมูลสำเร็จ');
    } else {
        set_err('ไม่สามารถแก้ไขข้อมูล' . mysqli_error($db));
    }
    redirect('app/business/list');
}

function get_business($business_id = NULL) {
    global $db;
    $sql = "SELECT * FROM business where business_id = '$business_id';";
    $rs = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($rs);
    return $row;
}
