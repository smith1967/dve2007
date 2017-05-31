<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "แก้ไขข้อมูล";
$active = 'app/admin';
$subactive = 'edit-user';
?>
<?php
if (isset($_POST['submit'])) {
    $data = $_POST;
    $valid = do_validate($data);
    foreach ($_POST as $k => $v) {
        $$k = $v;  // set variable to form
    }
    if ($valid) {
        do_update();  // ไม่มี error บันทึกข้อมูล
    }
} else {
//    if (isset($_GET['action']) && $_GET['action'] == 'edit') {
        $user_id = $_SESSION['user']['user_id'];
        $user_info = get_info($user_id);
//        var_dump($user_info);
//        die();
        foreach ($user_info as $key => $value) {
            $$key = $value;
        }
        $password = '';
//    }else{
        if(!$user_info)
            redirect('app/home/index');
//    }
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
                แก้ไขข้อมูลผู้ใช้
                <small>ผู้ใช้</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">ผู้ดูแลระบบ</a></li>
                <li class="active">แก้ไขผู้ใช้</li>
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
                            <h3 class="box-title">แก้ไขข้อมูลผู้ใช้</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                <form class="form-horizontal" id="signupform" method="post" action="">
                    <input type="hidden" name="user_id" value="<?php set_var($user_id) ?>"/>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="username">ชื่อผู้ใช้</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="username" name="username" readonly value='<?php echo isset($username) ? $username : ''; ?>'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="password">รหัสผ่าน</label>
                        <div class="col-md-5">
                            <input type="password" class="form-control" id="password" name="password" value='<?php set_var($password); ?>'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="confirm_password">ยืนยันรหัสผ่าน</label>
                        <div class="col-md-5">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" value='<?php set_var($confirm_password);; ?>'>
                        </div>
                    </div>
<!--                    <div class="form-group">
                        <label class="control-label col-md-3" for="school_id">รหัสสถานศึกษา</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="school_id" name="school_id" placeholder="School ID" value='<?php echo isset($school_id) ? $school_id : ''; ?>'>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <label class="control-label col-md-3" for="email">อีเมล์</label>
                        <div class="col-md-5">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value='<?php echo isset($email) ? $email : ''; ?>'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="fname">ชื่อ</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="firstname" value='<?php echo isset($fname) ? $fname : ''; ?>'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="lname">นามสกุล</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="lastname" value='<?php echo isset($lname) ? $lname : ''; ?>'>
                        </div>
                    </div>
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
      $( "#business_name" ).autocomplete({
         minLength: 2, 
         source: "<?php echo SITE_URL ?>ajax/search_business_1.php",
         select: function (event, ui) {
            $("#business_name").val(ui.item.label); // display the selected text
            $("#business_id").val(ui.item.value); // save selected id to hidden input
            return false;
        }         
      });
   });
</script> 

<script>
    $(function () {

        $("#school_id").autocomplete({
            source: "<?php echo SITE_URL ?>ajax/search_school.php",
            minLength: 2
        });
    });
</script>
<?php

function do_update() {
    global $db;
    $data = &$_POST;
//    var_dump($data);
    //die();
    foreach ($_POST as $k => $v) {
        $$k = $v;  // set variable to form
    }
//    $id = $_SESSION['user']['id'];
    if(empty($password)):
    $sql = "UPDATE user SET "
//                . "username = ".pq($username).","
                . "fname = ".pq($fname).","
                . "lname = ".pq($lname).","
//                . "school_id = ".pq($school_id).","
//                . "user_type_id = ".pq($user_type_id).","
                . "phone = ".pq($phone).","
                . "email = ".pq($email)
            ." WHERE "
                . "user_id = ".pq($user_id).";";
    else:
    $sql = "UPDATE user SET "
//                . "username = ".pq($username).","
                . "fname = ".pq($fname).","
                . "lname = ".pq($lname).","
//                . "school_id = ".pq($school_id).","
//                . "user_type_id = ".pq($user_type_id).","
                . "password = MD5(".  pq($password)."),"
                . "phone = ".pq($phone).","
                . "email = ".pq($email)
            ." WHERE "
                . "user_id = ".pq($user_id).";";
    endif;         
//    var_dump($sql);
//    die();
    mysqli_query($db, $sql);
    if (mysqli_affected_rows($db) > 0) {
        set_info("แก้ไขข้อมูลเรียบร้อยครับ");
        redirect('app/user/logout');
    } else {
        if (mysqli_error($db)) {
            set_err("แก้ไขข้อมูลไม่สำเร็จกรุณาตรวจสอบข้อมูล" . mysqli_error($db) . $sql);
//            redirect('app/admin/list-user');
        } else {
        if (mysqli_error($db)) {
            set_err("แก้ไขข้อมูลไม่สำเร็จกรุณาตรวจสอบข้อมูล" . mysqli_error($db) . $sql);            
        } else {
            set_info('ไม่มีข้อมูลเปลี่ยนแปลง');
        }     
        }
//        redirect('app/admin/list-user');
    }
    /* close statement and connection */
    redirect();
}

function get_info($user_id) {
    global $db;
    $query = "SELECT * FROM user WHERE user_id=" . pq($user_id + 0) . ";";
    $result = mysqli_query($db, $query);
//    var_dump($result);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

function do_validate($data) {
//    var_dump($data);
    global $db;
    $valid = TRUE;
//    if (!preg_match('/[a-zA-Z0-9_@]{5,}/', $data['username'])) {
//        set_err('ชื่อผู้ใช้ต้องเป็นตัวเลขหรือตัวอักษรภาษาอังกฤษ ความยาวไม่ต่ำกว่า 5 ตัวอักษร');
//        $valid = FALSE;
//    }
//    $sql = "SELECT username FROM user WHERE username = ".pq($data['username']);
//    if(mysqli_query($db, $sql)){
//        set_err('ชือผู้ใช้นี้ถูกใช้ไปแล้ว');
//        $valid = FALSE;
//    }
//    if (!preg_match('/[a-zA-Z0-9_@]{5,}/', $data['username'])) {
//        set_err('ชื่อผู้ใช้ต้องเป็นตัวเลขหรือตัวอักษรภาษาอังกฤษ ความยาวไม่ต่ำกว่า 5 ตัวอักษร');
//        $valid = FALSE;
//    }    
    if (!empty($data['password'])) {
        if (!preg_match('/[a-zA-Z0-9_@]{6,}/', $data['password'])) {
            set_err('รหัสผ่านต้องเป็นตัวเลขหรือตัวอักษรภาษาอังกฤษ ความยาวไม่ต่ำกว่า 6 ตัวอักษร');
            $valid = FALSE;
        }
        if ($data['password'] != $data['confirm_password']) {
            set_err('รหัสยืนยันไม่ตรงกับรหัสผ่าน');
            $valid = FALSE;
        }
    }
//    if ($data['password'] == $data['username']) {
//        set_err('ชื่อผู้ใช้กับรหัสผ่านต้องไม่เหมือนกัน');
//        $valid = FALSE;
//    }
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
//    $sql = "SELECT username FROM user WHERE email = ".pq($data['email']);
//    if(mysqli_query($db, $sql)){
//        set_err('อีเมล์นี้ถูกใช้ไปแล้ว');
//        $valid = FALSE;
//    }    
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