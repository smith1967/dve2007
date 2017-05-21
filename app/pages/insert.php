<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "เพิ่มข่าวสาร";
$active = 'pages';
//$property = array();
//$benefit = array();
$subactive = 'insert';
if (isset($_POST['submit'])) {
    $data = $_POST;
//    var_dump($data);
//    die();
    $valid = do_validate($data);  // check ความถูกต้องของข้อมูล
    foreach ($_POST as $k => $v) {
        $$k = $v;
    }  //    var_dump($property);
    if ($valid) {
        do_insert();
    }
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
                กรอกข้อมูลข่าวสาร
                <small>แบบฟอร์ม</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">ข่าวสาร</a></li>
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
                            <h3 class="box-title">ฟอร์มข่าวสาร</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="page_title">ชื่อเรื่อง</label>
                                    <input type="text" class="form-control" id="page_title" placeholder="ชื่อเรื่อง" name="page_title" value="<?php set_var($page_title); ?>">
                                </div>

                                <!-- textarea -->
                                <div class="form-group">
                                    <label>เนื้อหา</label>
                                    <textarea class="form-control" id="editor1" rows="3" placeholder="เพิ่มเนื้อหา ..." name="content" ><?php set_var($content) ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="imageFile">ภาพประกอบ</label>
                                    <input type="file" id="imageFile" name="image_url" value="<?php set_var($image_url) ?>">

                  <!--<p class="help-block">Example block-level help text here.</p>-->
                                </div>
                                <div class="form-group">
                                    <label for="image_desc">คำอธิบายภาพ</label>
                                    <input type="text" class="form-control" id="image_desc" placeholder="คำอธิบายภาพ" name="image_desc" value="<?php set_var($image_desc); ?>">
                                </div>
                                <!--                <div class="checkbox">
                                                  <label>
                                                    <input type="checkbox"> Check me out
                                                  </label>
                                                </div>-->


                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                </div>
                            </div>
                            <!-- /.box-body -->
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
    $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1');
        //bootstrap WYSIHTML5 - text editor
//    $(".textarea").wysihtml5();
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
    if (empty($data['page_title'])) {
        set_err('กรุณากรอกชื่อเรื่อง');
        $valid = false;
    }
    if (empty($data['content'])) {
        set_err('กรุณาใส่เนื้อหาด้วยครับ');
        $valid = false;
    }
    return $valid;
}

function do_insert() {
    global $db;
    $data = &$_POST;
    //print_r($data['property']);
//    $arr_pro = $data['property'];
//    $pro = implode(",", $arr_pro);
    //echo $pro;
    //exit();
    $query = "INSERT INTO pages ("
            . "`id`,"
            . " `page_title`,"
            . " `content`,"
            . " `published_date`,"
            . " `image_url`,"
            . " `image_desc`,"
            . " `user_id`)"
            . " VALUES ("
            . "NULL,"
            . pq($data['page_title']) . ","
            . pq($data['content']) . ","
            . "NOW(),"
            . pq($data['image_url']) . ","
            . pq($data['image_desc']) . ","
            . pq($_SESSION['user']['user_id'])
            . ");";
//    var_dump($query);
//    echo '<br>'.$query;
//    die();
//    $query = "INSERT INTO group_config (groupname, group_desc, upload, download) VALUES (".pq($data['groupname']).", ".pq($data['group_desc']).", ".pq($data['upload']).", ".pq($data['download']).");";
    mysqli_query($db, $query);
    if (mysqli_affected_rows($db) > 0) {
        set_info('เพิ่มข้อมูลสำเร็จ');
    } else {
        set_err('ไม่สามารถเพิ่มข้อมูล ' . mysqli_error($db) . $query);
    }
    redirect('app/pages/insert');
}
