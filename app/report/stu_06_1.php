<?php
// student/file-manager
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "อัพโหลดไฟล์และตรวจสอบข้อมูล";
$active = 'student';
$subactive = 'file-manager';
//header('Content-Type: text/html; charset=UTF-8');
require_once 'template/header.php';

if (isset($_POST['submit'])) {
    $sem = $_POST['semester'];
    $province_id = $_POST['province_id'];
    //echo $sem.$province_id;
    //echo "ppp".getProvinceName($province_id);
    $y = substr($sem, 2, 2);
} else {
    $sem = date('Y') + 543;
}
?>
<div class="wrapper">
    <?php require_once 'template/main-header.php'; ?>
    <?php require_once 'template/main-sidebar.php'; ?> 
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                รายงานข้อมูลนักเรียน
                <small>จำแนกตามสถานศึกษา ในจังหวัด</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">รายงานข้อมูลนักเรียน จำแนกตามสถานศึกษาในจังหวัด </h3>              
                </div>
                <!--box-header-->
                <div class="box-body">
                    <div class="panel-heading">เลือกปีการศึกษา และจังหวัด</div>
                    <div class="panel-body col-md-10">
                        <form method="post" class="form-inline " action="">
                            <div class="form-group ">
                                <label class="control-label col-md-6"for="semester">ปีการศึกษา</label>
                                <div class="col-md-2 ">
                                    <select class="form-control" id="semester" name="semester">
                                        <?php
                                        $year_now = date('Y') + 543;
                                        $arr = array($year_now - 2 => $year_now - 2, $year_now - 1 => $year_now - 1, $year_now => $year_now, $year_now + 1 => $year_now + 1, $year_now + 2 => $year_now + 2);
                                        $def = $sem;
                                        echo gen_option($arr, $def);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="province_id" class="col-md-3 control-label">จังหวัด</label>
                                <div class="col-md-3">
                                    <select class="form-control select2-single" id="province_id" name="province_id">
                                        <option id="province_list" > -- กรุณาเลือกจังหวัด -- </option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary col-md-offset-4" name="submit"> ตกลง </button>
                            </div>
                    </div>
                    </form>
                    <!--        //============================report=========================       -->
                    <?php
                    $html = "รายงานข้อมูลนักเรียนระบบทวิภาคี ปีการศึกษา " . $sem . "<br>";
                    $html .= "จำแนกตามสถานศึกษา  จังหวัด " . getProvinceName($province_id);
                    $html .= '
                <table style="width:100%" border="1">
  <tr>
    <th rowspan="2">ที่</th>
    <th rowspan="2">ภาค</th> 
    <th  rowspan="2">จังหวัด</th>
    <th  rowspan="2"> ชื่อสถานศึกษา</th> 
    <th  align="center" colspan="7" > ปีการศึกษา 2559</th> 
  </tr>
  <tr>
    <th>ป.ตรี</th> 
    <th>ปวส.</th>
    <th>ปวช.</th> 
    <th>รวมนักเรียนทวิทั้งหมด</th>
    <th>จำนวนักเรียนทั้งหมดแบบเงื่อนไข</th> 
     <th>ทั้งหมด</th>
    <th>ร้อยละ/ทั้งหมด</th>
  </tr>';
  
  $sql = "SELECT  z.zone_id,p.province_id, sch.school_id
  , MIN(z.zoneName) as zoneName
  , MIN(p.province_code) as province_code, MIN(p.province_name) province_name
  , MIN(sch.school_name) as school_name
  , IFNULL(SUM(IF(SUBSTRING(s.std_id, 3, 1)='4'
  and s.end_edu_id=1 
  and s.edu_year='2559'
  , 1, 0)),0) sum_level4
  , IFNULL(SUM(IF(SUBSTRING(s.std_id, 3, 1)='3'
  and s.end_edu_id=1 
  and s.edu_year='2559'
  , 1, 0)),0) sum_level3 
  , IFNULL(SUM(IF(SUBSTRING(s.std_id, 3, 1)='2'
  and s.end_edu_id=1 
  and s.edu_year='2559'
  , 1, 0)),0) sum_level2
  ,IFNULL(SUM(IF(
     (SUBSTRING(s.std_id, 3, 1)='4'
  OR SUBSTRING(s.std_id, 3, 1)='3'  
  OR SUBSTRING(s.std_id, 3, 1)='2')
  and s.end_edu_id=1  and s.edu_year='2559', 1 , 0)),0) sum_total
   ,round((
(IFNULL(SUM(IF(
     (SUBSTRING(s.std_id, 3, 1)='4'
	OR SUBSTRING(s.std_id, 3, 1)='3'  
	OR SUBSTRING(s.std_id, 3, 1)='2')
	and s.end_edu_id=1  and s.edu_year='2559', 1 , 0)),0))
 / (sum.sum_of_student) *100),2) as percent
 ,count(std_id) as sum_all
,sum.sum_of_student 
FROM student s 
JOIN school sch ON s.school_id=sch.school_Id
JOIN province p ON sch.province_id=p.province_code
JOIN zone z ON p.zone_id=z.zone_id
JOIN sum_of_student sum ON sum.school_id=sch.school_id
GROUP BY z.zone_id, p.province_id, sch.school_id";
                    //echo $sql;
                    $result = mysqli_query($db, $sql);
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $html .= "<tr align='center'>
                        <td align='center'>" . $count++ . "</td>
                        <td align='center'>" . $row['school_name'] . "</td>
                        <td align='center'>" . $row['zoneName'] . "</td>
                        <td align='center'>" . $row['province_name'] . "</td>
                        <td align='center'>" . $row['sum_level4'] . "</td>
                        <td align='center'>" . $row['sum_level3'] . "</td>
                        <td align='center'>" . $row['sum_level2'] . "</td>
                        <td align='center'>" . $row['sum_all'] . "</td>
                        <td align='center'>" . $row['sum_total'] . "</td>
                        <td align='center'>" . $row['sum_of_student'] . "</td>
                        <td align='center'>" . $row['percent'] . "</td>
                        </tr>";
                    }
                    $html .= "</table>";
                    ?>
                    <div class="panel-body col-md-10">
                         <?php    echo $html; ?>
                        <a href='<?php site_url("app/report/stu_03?action=print") ?>'>print</a>
                    </div>';
                    <?php
                    if ($_GET['action']=='print'){
                        require_once LIB_PATH . '/mpdf/vendor/autoload.php';

                        $mpdf = new mPDF('th','A4','','',32,25,27,25,16,13);

                        $mpdf->SetDisplayMode('fullpage');

                        $mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

                        // LOAD a stylesheet
                        $stylesheet = file_get_contents('mpdfstyletables.css');
                        $mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

                        $mpdf->WriteHTML($html,2);

                        $mpdf->Output('stu_03.pdf','I');
                        exit;
                     }

                    ?>
                   
                    
                    <!--        //============================end report=========================   -->
                </div><!--box-body-->
            </div>

    </div>

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
    });
</script>

<?php

function getProvinceName($id) {
    global $db;
    $query = "SELECT * FROM province where province_code='" . $id . "'";
    //echo $query;
    $rs = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($rs);
    return $row['PROVINCE_NAME'];
}

//==============================================================
//==============================================================
//==============================================================

//==============================================================
//==============================================================
//==============================================================