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
                <table width="99%" border="1" align=center cellpadding="0" cellspacing="0">
    <tr align=center >
        <th rowspan="3" width="5px">ลำดับที่</th>
        <th rowspan="3" width="30px">ชื่อสถานศึกษา</th>
        <th colspan="21">จำนวนนักเรียน(คน)</th>
        <th rowspan="3">รวม</th>
    </tr> 
    <tr align=center>
        <th colspan="3">ปวช.1</th>
        <th colspan="3">ปวช.2</th>
        <th colspan="3">ปวช.3</th>
        <th colspan="3">ปวส.1</th>
        <th colspan="3">ปวส.2</th>
        <th colspan="3">ป.ตรี 1</th>
        <th colspan="3">ป.ตรี 2</th>
    </tr> 
    <tr align=center>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>รวม</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>รวม</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>รวม</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>รวม</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>รวม</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>รวม</th>
        <th>ชาย</th>
        <th>หญิง</th>
        <th>รวม</th>
    </tr>';
                    $sql = "SELECT  sch.`school_name`,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . $y . "2'
	and sex='M' and end_edu_id=1 and edu_year='" . $sem . "', 1 , 0)),0) pvc1_m,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . $y . "2'
	and sex='F' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) pvc1_f,
IFNULL(SUM(IF(SUBSTRING(s.std_id , 1, 3)='" . $y . "2' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) sum_pvc1,

IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . ($y - 1) . "2'
	and sex='M' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) pvc2_m,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . ($y - 1) . "2'
	and sex='F' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) pvc2_f,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . ($y - 1) . "2' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) sum_pvc2,

IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . ($y - 2) . "2'
	and sex='M' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)) ,0) pvc3_m,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . ($y - 2) . "2'
	and sex='F' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) pvc3_f,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . ($y - 2) . "2' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) sum_pvc3,

IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . $y . "3'
	and sex='M'and end_edu_id=1 and edu_year='" . $sem . "', 1 , 0)),0) pvs1_m,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . $y . "3'
	and sex='F' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) pvs1_f,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . $y . "3' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) sum_pvs1,

IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . ($y - 1) . "3'
	and sex='M' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) pvs2_m,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . ($y - 1) . "3'
	and sex='F' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) pvs2_f,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . ($y - 1) . "3' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) sum_pvs2,

IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . $y . "4'
	and sex='M' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) pt1_m,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . $y . "4'
	and sex='F' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) pt1_f,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . $y . "4' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) sum_pt1,

IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . ($y - 1) . "4'
	and sex='M' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) pt2_m,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . ($y - 1) . "4'
	and sex='F' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) pt2_f,
IFNULL(SUM(IF(SUBSTRING(s.std_id, 1, 3)='" . ($y - 1) . "4' and end_edu_id=1 and edu_year='" . $sem . "', 1, 0)),0) sum_pt2,

IFNULL(SUM(IF(
	(SUBSTRING(s.std_id, 1, 3)='" . $y . "2' 
	OR SUBSTRING(s.std_id, 1, 3)='" . ($y-1) . "2' 
	OR SUBSTRING(s.std_id, 1, 3)='" . ($y - 2) . "2' 
	OR SUBSTRING(s.std_id, 1, 3)='" . $y . "3' 
	OR SUBSTRING(s.std_id, 1, 3)='" . ($y - 1) . "3' 
	OR SUBSTRING(s.std_id, 1, 3)='" . $y . "4' 
	OR SUBSTRING(s.std_id, 1, 3)='" . ($y - 1) . "4')  
	and end_edu_id=1 
	and edu_year='" . $sem . "'
	, 1, 0)),0) sum_all

FROM student s 
JOIN school sch ON s.school_id=sch.school_id
WHERE sch.province_id='$province_id'
GROUP BY s.school_id";
                    //echo $sql;
                    $result = mysqli_query($db, $sql);
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $html .= "<tr align='center'>
                        <td>" . $count++ . "</td>
                        <td>" . $row['school_name'] . "</td>
                        <td align='center'>" . $row['pvc1_m'] . "</td>
                        <td align='center'>" . $row['pvc1_f'] . "</td>
                        <td align='center'>" . $row['sum_pvc1'] . "</td>
                        <td align='center'>" . $row['pvc2_m'] . "</td>
                        <td align='center'>" . $row['pvc2_f'] . "</td>
                        <td align='center'>" . $row['sum_pvc2'] . "</td>
                        <td align='center'>" . $row['pvc3_m'] . "</td>
                        <td align='center'>" . $row['pvc3_f'] . "</td>
                        <td align='center'>" . $row['sum_pvc3'] . "</td>
                        <td align='center'>" . $row['pvs1_m'] . "</td>
                        <td align='center'>" . $row['pvs1_f'] . "</td>
                        <td align='center'>" . $row['sum_pvs1'] . "</td>
                        <td align='center'>" . $row['pvs2_m'] . "</td>
                        <td align='center'>" . $row['pvs2_f'] . "</td>
                        <td align='center'>" . $row['sum_pvs2'] . "</td>
                        <td align='center'>" . $row['pt1_m'] . "</td>
                        <td align='center'>" . $row['pt1_f'] . "</td>
                        <td align='center'>" . $row['sum_pt1'] . "</td>
                        <td align='center'>" . $row['pt2_m'] . "</td>
                        <td align='center'>" . $row['pt2_f'] . "</td>
                        <td align='center'>" . $row['sum_pt2'] . "</td>
                        <td align='center'>" . $row['sum_all'] . "</td>
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