<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
include_once LIB_PATH . 'ImageResize.php';
//var_dump(LIB_PATH);
//die();
$title = "แก้ไขข่าวสาร";
$active = 'pages';
//$property = array();
//$benefit = array();
$subactive = 'edit';

if (isset($_POST['submit'])) {
    $data = $_POST;
    var_dump($data);
//    die();
    $valid = do_validate($data);  // check ความถูกต้องของข้อมูล
    foreach ($_POST as $k => $v) {
        $$k = $v;
    }  //    var_dump($property);
    if ($valid) {
        if ($_FILES['image_url']['name'] !== '') {
            if (upload_image() == 1) {
//    var_dump($_FILES);
                $src_dir = "upload/images/src/";
                $src_file = $src_dir . basename($_FILES["image_url"]["name"]);
                $dest_dir = "upload/images/pages/";
                $dest_file = $dest_dir . basename($_FILES["image_url"]["name"]);
                $width = 1280;
                $height = 720;
                resize_image($src_file, $dest_file, $width, $height);
////            use \Eventviva\ImageResize;
//                $image = new \Eventviva\ImageResize($src_file);
//                $image->resizeToHeight(500);
//                $image->save($dest_file);
            }
//            do_update(basename($_FILES["image_url"]["name"]));
        }
        do_update($data['pages_id']);
    }
}if ($_GET['pages_id']) {
    $pages_list = get_pages($_GET['pages_id']);
    foreach ($pages_list as $key => $value) {
        $$key = $value;
    }

//    var_dump($pages_list);
//    exit();
} else {
    redirect('app/pages/list');
}
?>
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
                แก้ไขข้อมูลข่าวสาร
                <small>แบบฟอร์ม</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">ข่าวสาร</a></li>
                <li class="active">แก้ไขข้อมูล</li>
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
                                <input type="text" id="pages_id"  name="pages_id" hidden="" value="<?php set_var($pages_id); ?>">
                                <div class="form-group">
                                    <label for="pages_title">ชื่อเรื่อง</label>
                                    <input type="text" class="form-control" id="pages_title" placeholder="ชื่อเรื่อง" name="pages_title" value="<?php set_var($pages_title); ?>">
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
                                <?php
                                $frontpage_opt = array('N' => 'ไม่แสดง', 'Y' => 'แสดง');
                                $frontpage = empty($frontpage) ? 'Y' : $frontpage;
                                ?>
                                <div class="form-group">
                                    <label for="frontpage" >แสดงในหน้าแรก</label>
                                    <?php echo gen_bootrap_radio('frontpage', $frontpage_opt, $frontpage) ?>
                                </div>  

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
    if (empty($data['pages_title'])) {
        set_err('กรุณากรอกชื่อเรื่อง');
        $valid = false;
    }
    if (empty($data['content'])) {
        set_err('กรุณาใส่เนื้อหาด้วยครับ');
        $valid = false;
    }
    return $valid;
}

function get_pages($pages_id = null) {
    global $db;
//    $start = $page * $limit;
    $query = "SELECT p.*,u.fname FROM pages AS p,user AS u"
            . " WHERE "
            . "p.user_id = u.user_id "
            . "AND "
            . "p.pages_id = ".pq($pages_id)
            . " ORDER BY "
            . "p.pages_id,p.published_date DESC;";
    $result = mysqli_query($db, $query);
//    $pages_list = array();
    $row = mysqli_fetch_assoc($result); 
    return $row;
}


function do_update($pages_id) {
    global $db;
    $data = &$_POST;
    $files = &$_FILES;
    //print_r($data['property']);
    if (basename($files['image_url']['name'])=='') {
        $query = "UPDATE `pages` "
                . "SET "
                . "`pages_title`=" . pq($data['pages_title'])
                . ",`content`=" . pq($data['content'])
                . ",`published_date`=NOW()"
                . ",`frontpage`=" . pq($data['frontpage'])
                . " WHERE "
                . "`pages_id`=" . pq($pages_id) . ";";
    } else {
        $query = "UPDATE `pages` "
                . "SET "
                . "`pages_title`=" . pq($data['pages_title'])
                . ",`content`=" . pq($data['content'])
                . ",`published_date`=NOW()"
                . ",`frontpage`=" . pq($data['frontpage'])
                . ",`image_url`=" . pq(basename($files['image_url']['name']))
                . ",`image_desc`=" . pq($data['image_desc'])
                . " WHERE "
                . "`pages_id`=" . pq($pages_id) . ";";
    }
    $result = mysqli_query($db, $query);
//    echo $query;
//    var_dump(basename($files['image_url']['name']));
//    die();
    if (mysqli_affected_rows($db) == 0) {
        set_err('ไม่สามารถแก้ไขข้อมูล' . mysqli_error($db));
    } else {
        set_info('แก้ไขข้อมูลสำเร็จ');
    }
    redirect('app/pages/list');
}

function upload_image() {
    $target_dir = "upload/images/src/";
    $target_file = $target_dir . basename($_FILES["image_url"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $check = getimagesize($_FILES["image_url"]["tmp_name"]);
    if ($check !== false) {
        set_info("ไฟล์รูปภาพ - " . $check["mime"] . ".");
        $uploadOk = 1;
    } else {
        set_err("ไม่ใช่ไฟล์รูปภาพครับ.");
        $uploadOk = 0;
    }
    if (file_exists($target_file)) {
        set_err("ไฟล์มีอยู่แล้วครับ.");
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["image_url"]["size"] > 10000000) {
        set_err("ไฟล์มีขนาดใหญ่เกินครับ.");
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        set_err("อนุญาตให้ใช้ไฟล์สกุล JPG, JPEG, PNG & GIF เท่านั้นครับ");
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1) {
//        return;
//// if everything is ok, try to upload file
//    } else {
        if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
            set_info("ไฟล์ " . basename($_FILES["image_url"]["name"]) . " อัพโหลดเรียบร้อย.");
        } else {
            set_err("อัพโหลดไฟล์ไม่สำเร็จ.");
            $uploadOk = 0;
        }
    }
    return $uploadOk;
}
