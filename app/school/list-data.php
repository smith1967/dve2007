<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
global $school_id;
$school_id = $_SESSION['user']['school_id'];
//$check=$_GET['action'];
$title = "ข้อมูลสถานศึกษา";
$active = 'school';
$subactive = 'list-data';
$list_school_data = list_school_data();
//var_dump($list_school_data);
//die();
if(is_null($list_school_data))
    redirect('app/school/edit-data');
// is_admin('home/index');
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
                    <h3 class="box-title">รายการสถานศึกษา</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive  col-md-7">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>คำนำหน้า</th>
                                    <th>รายการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>รหัส</td>
                                    <td> <?php echo $list_school_data['school_id']; ?></td>
                                </tr>
                                <tr>
                                    <td>ชื่อสถานศึกษา</td>
                                    <td> <?php echo $list_school_data['school_name']; ?></td>
                                </tr>
                                <tr>
                                    <td>ประเภทสถานศึกษา</td>
                                    <td> <?php echo $list_school_data['school_type_id']; ?></td>
                                </tr>
                                <tr>
                                    <td>ที่อยู่</td>
                                    <td> <?php echo $list_school_data['address_no']; ?> </td>
                                </tr>
                                <tr>
                                    <td>ถนน</td>
                                    <td> <?php echo $list_school_data['road']; ?> </td>
                                </tr>
                                <tr>
                                    <td>จังหวัด</td>
                                    <td> <?php
                                        echo $list_school_data['province_id'];
                                        echo "(";
                                        echo $list_school_data['PROVINCE_NAME'];
                                        echo ")";
                                        ?> </td>
                                </tr>
                                <tr>
                                    <td>อำเภอ</td>
                                    <td> <?php
                                        echo $list_school_data['aumphur_id'];
                                        echo "(";
                                        echo $list_school_data['AMPHUR_NAME'];
                                        echo ")";
                                        ?> </td>
                                </tr>

                                <tr>
                                    <td>ตำบล</td>
                                    <td> <?php
                                        echo $list_school_data['district_id'];
                                        echo "(";
                                        echo $list_school_data['DISTRICT_NAME'];
                                        echo ")";
                                        ?> </td>

                                <tr>
                                    <td>รหัสไปรษณีย์</td>
                                    <td> <?php echo $list_school_data['postcode']; ?> </td>
                                </tr>
                                <tr>
                                    <td>โทรศัพท์</td>
                                    <td> <?php echo $list_school_data['phone']; ?> </td>
                                </tr>
                                <tr>
                                    <td>โทรสาร</td>
                                    <td> <?php echo $list_school_data['fax']; ?> </td>
                                </tr>
                                <tr>
                                    <td>ภาค</td>
                                    <td> <?php echo $list_school_data['zone']; ?> </td>
                                </tr>
                                <tr>
                                    <td>พิกัด</td>
                                    <td> <?php echo $list_school_data['location']; ?> </td>
                                </tr>
                                <tr>
                                    <td>สังกัดหน่วยงาน</td>
                                    <td> <?php echo $list_school_data['catagory']; ?> </td>
                                </tr>
                                <tr>
                                    <td>สังกัดหน่วยงาน</td>
                                    <td> <?php
                                        echo $list_school_data['institute_id'];
                                        echo "(";
                                        echo $list_school_data['institute_name'];
                                        echo ")";
                                        ?> </td>

                                <tr>
                                    <td>  <a href="index.php?app/school/edit-data">แก้ไขข้อมูล<span class="glyphicon glyphicon-pencil"></span></a> </td>
                                </tr>  
                        </table>
                    </div>

                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- /.box -->

        </section>
        <!--
                            </tbody>
                        </table>
                    </div>            
                </div> /.content -->
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

function list_school_data() {
    global $school_id;
    global $db;
// $sql1 = "SELECT * from school WHERE school_id='$school_id'";
// $result1 = mysqli_query($db, $sql);
// $row1 = mysqli_fetch_array($result1);
    $sql = "SELECT
            pv.PROVINCE_CODE,
            pv.PROVINCE_NAME,
            dt.DISTRICT_CODE,
            dt.DISTRICT_NAME,
            am.AMPHUR_CODE,
            am.AMPHUR_NAME,
            sh.school_id,
            sh.school_name,
            sh.school_type_id,
            sh.address_no,
            sh.road,
            sh.district_id,
            sh.aumphur_id,
            sh.province_id,
            sh.postcode,
            sh.phone,
            sh.fax,
            sh.zone,
            sh.location,
            sh.catagory,
            sh.institute_id,
            ins.institute_id,
            ins.institute_name
        FROM
            school AS sh ,
            province AS pv ,
            district AS dt ,
            amphur AS am ,
            institute AS ins
        WHERE
            sh.province_id = pv.PROVINCE_CODE AND
            sh.district_id = dt.DISTRICT_CODE AND
            sh.aumphur_id = am.AMPHUR_CODE AND
            sh.institute_id = ins.institute_id AND 
            sh.school_id = '$school_id' ";
    $result = mysqli_query($db, $sql);
//    echo $sql;
//    die();
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
    }else{
        if(mysqli_errno($db)){
            set_err("เกิดข้อผิดพลาด".mysqli_error($db));
        }
        set_err("ไม่พบข้อมูลหรือข้อมูลไม่ครบ");
//        redirect();
    }
    return $row;
}
?>