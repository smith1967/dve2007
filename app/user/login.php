<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$active = 'user';
$subactive = 'login';
$title = 'เข้าระบบ';
// check post data
if (isset($_POST['submit'])) {
    $data = $_POST;
//    var_dump($data);
//    exit();
    do_login($data);   
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
        กรอกข้อมูลเข้าระบบ
        <small>แบบฟอร์ม</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
        <li><a href="#">ผู้ใช้</a></li>
        <li class="active">เข้าระบบ</li>
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
              <h3 class="box-title">Login Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="">
              <div class="box-body">
                <div class="form-group">
                  <label for="username" class="col-sm-2 control-label">ชื่อผู้ใช้</label>

                  <div class="col-sm-10 col-md-6">
                      <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="<?php set_var($username) ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

                  <div class="col-sm-10 col-md-6">
                      <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="password" value="<?php set_var($password) ?>">
                  </div>
                </div>
<!--                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10 col-md-6">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox"> Remember me
                      </label>
                    </div>
                  </div>
                </div>-->
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <div class="col-md-offset-2 col-md-6">
                <!--<button type="submit" class="btn btn-default">ยกเลิก</button>-->
                <button type="submit" class="btn btn-info" name="submit">เข้าระบบ</button>
                  </div>
                  </div>
              <!-- /.box-footer -->
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
<?php
// functions section 
function do_login($data) {
    global $db;
    $strHash = create_password_hash(md5($data['password']), PASSWORD_DEFAULT);
    $query = "SELECT * FROM user WHERE username = " . pq($data['username']) ." AND status = 'Y'" ;
    $result = mysqli_query($db, $query);
    if ($result) {
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        if (verify_password_hash($row['password'], $strHash)) {
            unset($row['password']);
            $_SESSION['user'] = $row;
//            $_SESSION['user']['token'] = urlencode($strHash);
//            var_dump($strHash);
            //Generate a random string.
            $token = openssl_random_pseudo_bytes(16);

            //Convert the binary data into hexadecimal representation.
            $token = bin2hex($token);
            $_SESSION['user']['token'] = $token;
            do_insert_log($data['username'],'Y',$token);
            set_info('ยินดีต้อนรับคุณ'.$row['fname']);
//            die();
        } else {
            do_insert_log($data['username'],'N');
            set_err("ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!!");
            redirect('app/user/login');
        }
    }  else {
        do_insert_log($data['username'],'N');
        set_err("ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!!");
    }
    redirect('app/home/index');
}

function do_insert_log($username,$event,$token){
    global $db;
    $query = "INSERT INTO `access_log` ("
            . "`id`, "
            . "`username`, "
            . "`token`, "
            . "`event`, "
            . "`ip_address`, "
            . "`user_agent` "            
            . ") VALUES ("
            . "NULL, "
            . pq($username) . ", "
            . pq($token). ", "
            . pq($event).","
            . pq($_SERVER['REMOTE_ADDR']) . ", "
            . pq($_SERVER['HTTP_USER_AGENT']).")";
//    var_dump($query);
//    die();
    $result = mysqli_query($db, $query);
    if(mysqli_error($db)){
        set_err('ไม่สามารถบันทึกข้อมูลได้ : '.  mysqli_error($db));
    }
}
