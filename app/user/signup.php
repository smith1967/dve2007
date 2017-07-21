<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$active = 'user';
$subactive = 'signup';
$title = 'ลงทะเบียนผู้ใช้';
//
if (isset($_POST['submit'])) {
    $data = $_POST;
    $valid = do_validate($data);  // check ความถูกต้องของข้อมูล
    if (!$valid) {
        foreach ($data as $k => $v) {
            $$k = $v;  // set variable to form
        }
    } else {
        do_save();  // ไม่มี error บันทึกข้อมูล
    }
} else {
    $username = '';
    $lname = '';
    $fname = '';
    $password = '';
    $confirm_password = '';
    $email = '';
    $phone = '';
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
                กรอกข้อมูลสมัครสมาชิก
                <small>แบบฟอร์ม</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">ผู้ใช้</a></li>
                <li class="active">สมัครใช้งาน</li>
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
                            <h3 class="box-title">ลงทะเบียนผู้ใช้งาน</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" id="signupform" method="post" action="">
                            <div class="form-group">
                                <label class="control-label col-md-3" for="username">ชื่อผู้ใช้</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="ชื่อผู้ใช้ภาษาอังกฤษ" value='<?php echo isset($username) ? $username : ''; ?>'>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3" for="password">รหัสผ่าน</label>
                                <div class="col-md-5">
                                    <input type="password" class="form-control" id="password" name="password" value='<?php echo isset($password) ? $password : ''; ?>'>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3" for="confirm_password">ยืนยันรหัสผ่าน</label>
                                <div class="col-md-5">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" value='<?php echo isset($confirm_password) ? $confirm_password : ''; ?>'>
                                </div>
                            </div>
                                <input type="hidden" class="form-control" id="school_id"  name="school_id" value="<?php set_var($school_id) ?>">
                                <div class="form-group"> 
                                    <label class="control-label col-md-3" for="school_name">ชื่อสถานศึกษา</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="school_name" placeholder="ชื่อสถานศึกษา" name="school_name" value="<?php set_var($school_name) ?>">
                                    </div>
                                </div>

                            <div class="form-group">
                                <label class="control-label col-md-3" for="email">อีเมล์</label>
                                <div class="col-md-5">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value='<?php echo isset($email) ? $email : ''; ?>'>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3" for="fname">ชื่อ</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" id="fname" name="fname" placeholder="ชื่อภาษาไทย" value='<?php echo isset($fname) ? $fname : ''; ?>'>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3" for="lname">นามสกุล</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" id="lname" name="lname" placeholder="นามสกุลภาษาไทย" value='<?php echo isset($lname) ? $lname : ''; ?>'>
                                </div>
                            </div>
                            <input type="hidden" id="user_type_id" name="user_type_id" value="4" /> 
                            <!--                    <div class="form-group"> 
                                                    <label class="control-label col-md-3" for="user_type_id">ประเภทผู้ใช้</label>
                                                    <div class="col-md-4">
                                                        <select class='form-control input-xlarge'id="user_type_id" name="user_type_id">
                            <?php
                            $def = isset($user_type_id) ? $user_type_id : '3';
                            $sql = "SELECT user_type_id,user_type_desc FROM user_type";
                            echo gen_option($sql, $def)
                            ?>
                                                        </select>              
                                                    </div>
                                                </div>-->
                            <div class="form-group">
                                <label class="control-label col-md-3" for="phone">โทรศัพท์</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" id="phone" name="phone" value='<?php echo isset($phone) ? $phone : ''; ?>'>
                                </div>
                            </div>

                            <div class="form-group">

                                <div class="checkbox" >
                                    <label class="control-label col-md-offset-3"><input type="checkbox" id='agree' name='agree' value='1'>ยืนยันข้อมูลถูกต้อง</label>
                                </div>

                            </div>            
                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-5">
                                    <button type="submit" class="btn btn-primary" name='submit'>บันทึกข้อมูล</button>
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
   $(function() {

      $( "#school_id" ).autocomplete({
         source: "<?php echo SITE_URL ?>ajax/search_school.php",
         minLength: 1
      });
      $("#school_name").autocomplete({
            source: "<?php echo SITE_URL ?>ajax/search_school.php",
            minLength: 2,
            select: function (event, ui) {
                $("#school_name").val(ui.item.label); // display the selected text
                $("#school_id").val(ui.item.value); // save selected id to hidden input
                return false;
            },
        });
   });
</script> 

<?php
// function section

function do_save() {
    global $db;
    $data = &$_POST;
    $password = md5($data['password']);
    //var_dump($data);
    //die();
    $sql = "INSERT INTO `user` ("
            . "`user_id`, "
            . "`username`, "
            . "`password`, "
            . "`fname`, "
            . "`lname`, "
            . "`email`, "
            . "`phone`, "
            . "`school_id`, "
            . "`user_type_id`, "
            . "`register_date`, "
            . "`status`"
            . ") VALUES ("
            . "NULL, "
            . pq($data['username']) . ", "
            . pq($password) . ", "
            . pq($data['fname']) . ", "
            . pq($data['lname']) . ", "
            . pq($data['email']) . ", "
            . pq($data['phone']) . ", "
            . pq($data['school_id']) . ", "
            . pq($data['user_type_id']) . ","
            . "NOW(),"
            . "'N');";
//    die("sql: " . $sql);
    mysqli_query($db, $sql);
    if (mysqli_affected_rows($db) > 0) {
        set_info('ลงทะเบียนข้อมูลเรียบร้อย');
//        $_SESSION['info'] = "ลงทะเบียนเรียบร้อยครับ";
        redirect('app/home/index');
    } else {
        set_err("ลงทะเบียนไม่สำเร็จ กรุณาตรวจสอบข้อมูล" . mysqli_error($db));
//        $_SESSION['error'] = "ลงทะเบียนไม่สำเร็จ กรุณาตรวจสอบข้อมูล" . mysqli_error($db) . $sql;
        redirect('app/user/signup');
    }
    /* close statement and connection */
    //redirect();
}

function get_info($mem_id) {
    global $db;
    $query = "SELECT * FROM member WHERE mem_id='" . pq($mem_id + 0) . "'";
    $res = mysqli_query($db, $query);
    return $res;
}

function do_validate($data) {
//    var_dump($data);
    global $db;
    $valid = TRUE;
    if (!preg_match('/^[a-zA-Z0-9_@]{5,15}$/', $data['username'])) {
        set_err('ชื่อผู้ใช้ต้องเป็นตัวเลขหรือตัวอักษรภาษาอังกฤษ ความยาวไม่ต่ำกว่า 5 ตัวอักษร');
        $valid = FALSE;
    }
    $sql = "SELECT username FROM user WHERE username = ".pq($data['username']);
    $result= mysqli_query($db, $sql);

    if(mysqli_num_rows($result)>0){
        set_err('ชือผู้ใช้นี้ถูกใช้ไปแล้ว');
        $valid = FALSE;
    }
  
    if (!preg_match('/^[a-zA-Z0-9_@$!]{6,}$/', $data['password'])) {
        set_err('รหัสผ่านต้องเป็นตัวเลขหรือตัวอักษรภาษาอังกฤษ ความยาวไม่ต่ำกว่า 6 ตัวอักษร');
        $valid = FALSE;
    }
    if (!preg_match('/^[0-9]{10}$/', $data['school_id'])) {
        set_err('รหัสสถานศึกษาไม่ถูกต้อง');
        $valid = FALSE;
    }    
    if ($data['password'] != $data['confirm_password']) {
        set_err('รหัสยืนยันไม่ตรงกับรหัสผ่าน');
        $valid = FALSE;
    }
    if ($data['password'] == $data['username']) {
        set_err('ชื่อผู้ใช้กับรหัสผ่านต้องไม่เหมือนกัน');
        $valid = FALSE;
    }
    if (empty($data['fname'])) {
        set_err('กรุณาใส่ชื่อ');
        $valid = FALSE;
    }
    if (empty($data['lname'])) {
        set_err('กรุณาใส่นามสกุล');
        $valid = FALSE;
    }
//    if (check_confirm_password($data['confirm_password'])) {
//        set_err('ตรวจสอบรหัสบัตรประชาชนให้ถูกต้องครับ');
//        $valid = FALSE;
//    }
    if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) == FALSE) {
        set_err('รูปแบบอีเมล์ไม่ถูกต้อง');
        $valid = FALSE;
    }
    $sql = "SELECT username FROM user WHERE email = ".pq($data['email']);
    $result= mysqli_query($db, $sql);
    if(mysqli_num_rows($result)>0){
        set_err('อีเมล์นี้ถูกใช้ไปแล้');
        $valid = FALSE;
    } 
    if (!preg_match('/[0-9_-]{8,}/', $data['phone'])) {
        set_err('กรุณาใส่หมายเลขโทรศัพท์');
        $valid = FALSE;
    }
    if (empty($data['agree'])) {
        set_err('กรุณายืนยันข้อมูล');
        $valid = FALSE;
    }
    return $valid;
    /* ----End Validate ---- */
}
