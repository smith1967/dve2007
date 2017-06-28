<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
//is_admin('home/index');
$title = "ตรวจสอบข้อมูล";
$active = 'student';
$subactive = 'check-data';
$school_id = $_SESSION['user']['school_id'];
if (!isset($_GET['filename'])){
    redirect('app/student/file-manager');
}
//http://localhost/dvt2017/index.php?student/check-data&action=import&type=std&filename=2017-04-12_Std_20026101_2560_2.csv
if (isset($_GET['action']) && $_GET['action'] == 'import' && $_GET['type'] == 'std') {
    $filename = UPLOAD_DIR . $_GET['filename'];
    do_transfer_std($filename);
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
                ตรวจสอบไฟล์
                <small>แบบฟอร์ม</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">นักศึกษา</a></li>
                <li class="active">ตรวจสอบไฟล์</li>
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
                            <h3 class="box-title">ตรวจสอบไฟล์</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <?php
                        //http://localhost/dvt2017/index.php?student/check-data&action=check&filename=2017-03-22_Sch_20026101_2560_2.CSV
                        if (isset($_GET['action'])) {
                            if ($_GET['action'] == 'check') {
                                $filename = UPLOAD_DIR . $_GET['filename'];
                                if (validate_std_file($filename)) {
                                    $importlink = site_url('app/student/check-data') . '&action=import&type=std&filename=' . $_GET['filename'];
                                    echo '<div class="alert alert-success col-md-4">ข้อมูลแฟ้ม std_' . $school_id . ' ถูกต้อง&nbsp;&nbsp;&nbsp;<a href= ' . $importlink . '>';
                                    ?>
                                    <button type="button" id="button1" class="btn btn-success"> โอนแฟ้มข้อมูล </button></a>
                                </div>

                                <?php
                            } else {
                                $uploadlink = site_url('app/student/file-manager');
                                echo '<div class="alert alert-warning col-md-4">ข้อมูลไม่ถูกต้องกลับไป <a href= ' . $uploadlink . '>จัดการแฟ้มข้อมูล </a></div>';
                                //die("not valid");
                            }
                        }
                    }
                    ?>    
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
<?php
function validate_std_file($filename) {
    $handle = fopen($filename, "r");
   // print_r(fgetcsv($handle));
    $col_names = fgetcsv($handle);
    $valid = TRUE;
    // -- fields บางส่วนของไฟล์ std
    $stdcol = array('years', 'semester', 'school_id', 'depart_id', 'people_id');
    //years,semester,school_id,depart_id,people_id,perfix_id,stu_fname,stu_lname,gender_id,birthday,nation_id,home_id,moo,street,tumbol_id,cripple_id,tall,weight,fat_fname,fat_lname,fat_crippl,fat_status,fat_salary,fat_occupa,mot_fname,mot_lname,mot_crippl,mot_status,mot_salary,mot_occupa,marry_stat,brother,study_brot,par_fname,par_lname,par_salary,par_occupa,start_year,level_id,schedu_id,grade_id,major_id,gpa,stu_expert,student_id,group_id,nickname,religion,b_provite,graduate,fat_tell,par_tell,std_blgr,std_edu_id,bud_edu_id,type_id,bud_typeid,major_name,minor_name,homecode,endyear,end_edu_id,end_status,work_id,job_id,job_place,j_position,job_salary,knowlageid,knowlage,job_search,typeschool,moemajors,curri_id,scoo,da_prename,ma_prename,add1,moo1,road1,tumb1,post1,post2,day_in,std_fname,std_lname
//print_r($col_names);
    foreach ($stdcol as $col) {
        if (!in_array($col, $col_names)) {
            $valid = FALSE;
             
        }
    }
    
    fclose($handle);
    return $valid;
}

//function validate_users_file($filename) {
//    $handle = fopen($filename, "r");
//    //print_r(fgetcsv($file));
//    $col_names = fgetcsv($handle);
//    //var_dump($col_names);
//    $valid = TRUE;
//// -- table cols
//    $dbcol = array('username', 'password', 'fname', 'lname', 'groupname');
//    // check header csv
//    foreach ($dbcol as $col) {
//        if (!in_array($col, $col_names)) {
//            $valid = FALSE;
//        }
//    }
//    fclose($handle);
//    return $valid;
//huyvf\iy
//}

function do_transfer_std($stdfile) {
    //echo "ssss";exit();
    global $db;
    /* insert data to table tmp */
    $handle = fopen($stdfile, "r");

    //ลบข้อมูล temp table
    $sql_t = "TRUNCATE TABLE student_tmp ";
    $res=mysqli_query($db, $sql_t);
    $num_row=0;
    $count =0;
    $count2 =0;
    $date_update=date("Y-m-d");
        
    while (!feof($handle)) {
        $data_str = fgetcsv($handle);
        //print_r($data_str); exit(); //====================
        if ($data_str[0]!=''){
            $str_comma = implode(",", $data_str);       
        //print_r($str_comma);exit(); //====================
            $line = iconv("TIS-620", "UTF-8", $str_comma);
            $data = explode(",", $line);
        }
        $_SESSION['year']=$data[0];
            // print_r($line); exit();
        //print_r($data);exit(); //หัวตาราง ====================
        //std_edu_id = $data[53]=>1=ปกติ  2=ทวิภาคี
        //end_edu_id = $data[61]==1 --กำลังศึกษาอยู่
        $num_row++;
        if ($num_row>2 && $data[0]!=null && $data[61]==1 ){  
            // echo substr($data[4],-4)."<br>" ;
            // print_r($data);exit();     //ข้อมูลแถวแรก ============    
            if (substr($data[4],-4)=="E+12") {
                set_err("รูปแบบข้อมูลรหัสประจำตัวประชาชน ผิดพลาด : ".$data[4]."<br> ตรวจสอบ และส่งไฟล์ใหม่");
                redirect('app/student/check-data');
            }
			$count++;
			$name=getSerName($data[5]).$data[6]."  ".$data[7];
			$dofb=chDay1($data[9]);
			$sex=convSexId($data[8]);
            $minor_id=getminorId($data[58]);
            $major_id=getmajorId($data[57]);
            $round_year=$_SESSION['user']['round-year'];
			$strsql = "insert into student_tmp values(";
			$strsql .= "'$data[44]','$data[2]','$data[4]',";
			$strsql .= "'$name','$dofb','$sex',";
			$strsql .= "'$minor_id','$major_id',";
            $strsql .= "'$data[55]','$data[61]','$data[53]',";
            $strsql .= "'$data[0]','$data[1]','$round_year','$date_update'";
			$strsql .=");";
			//set_err($strsql);exit();
       // echo 'zzz='.$count;
			$res = mysqli_query($db,$strsql);
         //   if ($count==3)exit();
			if ($res){
				$count2++;
			}
		}
    }
    //echo "ข้อมูลจำนวน ".$count." แถว <br>";
    //echo "นำเข้าข้อมูลจำนวน ".$count2." แถว";

    if (mysqli_affected_rows($db)) {
        set_info('โอนข้อมูลนักเรียนทั้งหมด ใส่ตารางชั่วคราวจำนวน ' . $count2. ' รายการ');
        redirect('app/student/import-std');
    } else {
        set_err("การโอนข้อมูลใส่ตารางชั่วคราวผิดพลาด : " . mysqli_error($db));
        //die();
    }
    redirect('app/student/import-std');
}

//function do_transfer_users($usersfile) {
//    global $db;
//    $stdcol = array('student_id', 'people_id', 'stu_fname', 'stu_lname', 'group_id');
//// -- table cols
//    $dbcol = array('username', 'password', 'fname', 'lname', 'groupname');
//    /* insert data to table tmp */
//    $handle = fopen($usersfile, "r");
//// get header column from file     
//    $cols = fgetcsv($handle);
//    $colindex = array();   // --- get index of array
//    foreach ($dbcol as $value) {
//        $colindex[] = array_search($value, $cols);
//    }
//    $stdcharset = "";
//    while (!feof($handle)) {
//        $str = fgetcsv($handle);
//        $str_comma = implode(",", $str);
//        if (empty($stdcharset))
//            $stdcharset = mb_detect_encoding($str_comma, "UTF-8", TRUE) ? "UTF-8" : "TIS-620";
//        $line = ($stdcharset == 'TIS-620') ? iconv("tis-620", "utf-8", $str_comma) : $line = $str_comma;
//        //die($line);
//        if (strlen($line)) {
//            $row = array();
//            $row = explode(",", $line);
//            $val = array();
//            foreach ($colindex as $v) {
//                $val[] = pq($row[$v]);
//            }
//            $arr[] = '(' . implode(",", $val) . ')';    //  set of data array((1,2,3),(4,5,6),..);
//        }
//    }
//    fclose($handle);
//    $values = implode(",", $arr);                   // -- group set data  (1,2,3),(4,5,6),...
//    $cols = "(" . implode(",", $dbcol) . ")";
//    $sql = "TRUNCATE TABLE `users_temp`";
//    mysqli_query($db, $sql);
//    $query = "INSERT INTO users_temp " . $cols . " VALUES " . $values;
//   // die($query);
//    mysqli_query($db, $query);
//    if (mysqli_affected_rows($db)) {
//        set_info('โอนข้อมูลจำนวน ' . mysqli_affected_rows($db) . ' ใส่ตารางชั่วคราว');
//        //redirect('admin/file-manager');
//    } else {
//        set_err("การโอนข้อมูลใส่ตารางชั่วคราวผิดพลาด : " . mysqli_error($db));
//        //die();
//    }
//    redirect('student/file-manager');
//}

function getSerName($id){
	if ($id==002){
		return "นาย";
	}else if($id==003){
		return "นางสาว";
	}
}

function chDay1($s){
	$d=explode("/",$s);
//print_r($d);
	$y=$d[2]-543;
	return $y."-".$d[1]."-".$d[0];
}
//function convSex($id){
//	if ($id==1){return "M";}
//	else{return "F";}
//}
function getmajorId($s){
    global $db;
    $sql="select * from major where major_name='$s' " ; 
    $res=mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($res);
	return $row['major_id'];
}
function getminorId($s){
    global $db;
    $sql="select * from minor where minor_name='$s' " ; 
    $res=mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($res);
	return $row['minor_id'];
}
function convSexId($s){
    if ($s==1){
        return "M";
    }
    else {
        return "F";
    }
    
}