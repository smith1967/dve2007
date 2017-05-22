<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$active = 'home';
$subactive = 'index';
$title = 'หน้าหลัก';
//$page = isset($_GET['page']) ? $_GET['page'] : 0;
//$action = isset($_GET['action']) ? $_GET['action'] : "list";
//$order = isset($_GET['order']) ? $_GET['order'] : '';
//$limit = isset($_GET['limit']) ? $_GET['limit'] : 40;
//
//$params = array(
//    'action' => $action,
//    'limit' => $limit,
//);
//$params = http_build_query($params);
//$studentlist = get_student($page, $limit, $school_id);
//echo $studentlist; exit();
//    $total = get_total();
//$url = site_url('student/list-student&') . $params;
//    var_dump($businesslist);
//    exit();
//$total = get_total($school_id);
$pages_list = get_pages();
?>
<?php require_once 'template/header.php'; ?>
<div class="wrapper">
    <?php require_once 'template/main-header.php'; ?>
    <?php require_once 'template/main-sidebar.php'; ?> 
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <section class="content-header"><?php show_message() ?></section>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                ระบบงานทวิศีกษา
                <small>SMART DVE</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
<!--                <li><a href="#">Examples</a></li>
                <li class="active">Blank page</li>-->
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">
            <!--carousel start-->
            <div class="box-body">
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                  <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                  <!--<li data-target="#carousel-example-generic" data-slide-to="3" class=""></li>-->
                </ol>
                <div class="carousel-inner">
                  <div class="item active">
                    <img src="upload/images/slides/slide-01.jpg" alt="it-Dev Staff">

                    <div class="carousel-caption">
                      ประชุมมอบหมายงาน
                    </div>
                  </div>
                  <div class="item">
                    <img src="upload/images/slides/slide-02.jpg" alt="Second slide">

                    <div class="carousel-caption">
                      ทีมงานพัฒนาโปรแกรม
                    </div>
                  </div>
                  <div class="item">
                    <img src="upload/images/slides/slide-03.jpg" alt="Third slide">
                    <div class="carousel-caption">
                      นำเสนอผลงานครั้งที่ 1
                    </div>
                  </div>
                </div>
                  <!--carousel end-->
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
              </div>
            </div>
            <!-- /.box-body -->
          <!-- Box Comment -->
          <!-- /.box -->         
            <!-- Default box -->  
            <?php foreach ($pages_list as $page): ?>
            
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $page['page_title'] ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                   <?php if(!empty($page['image_url'])): ?>
                   <div class="col-xs-12 col-sm-4"> 
                        <img src="upload/images/pages/<?php echo $page['image_url']; ?>" alt="<?php echo $page['image_desc']; ?>" > 
                   </div>
                   <?php endif; ?> 
                   <?php echo $page['content']; ?>
                </div>
                 <!--/.box-body--> 
                <div class="box-footer">
                    ตีพิมพ์วันที่ : <?php echo $page['published_date']; ?> โดย : <?php echo $page['fname']; ?>
                </div>
                 <!--/.box-footer-->
            </div>
            <?php endforeach; ?>
            <!-- /.box -->            
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php require_once 'template/main-footer.php'; ?>    
</div>
<!--.wrapper-->
<?php require_once 'template/footer.php'; ?>
<script>
$(document).ready(function(){ 
      $('.box-body img').addClass('img-responsive');
});
</script>
<?php

function get_pages($page = 0, $limit = 10) {
    global $db;
    $start = $page * $limit;
//    $query = "SELECT business.*,province.province_name FROM business,province WHERE business.province_id = province.province_code LIMIT " . $start . "," . $limit . "";
    $query = "SELECT p.*,u.fname "
            . "FROM "
            . "pages AS p, user AS u "
            . "WHERE "
            . "p.user_id = u.user_id "
            . "LIMIT "
            . "$start,$limit";
    $result = mysqli_query($db, $query);
    $pages_list = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $pages_list[] = $row;
    }
    return $pages_list;
}

function get_total() {
    global $db;
//    $val = $group."%";
    $query = "SELECT * FROM business ";
    $result = mysqli_query($db, $query);
    return mysqli_num_rows($result);
}

function do_delete($business_id) {
    global $db;
    if (empty($business_id)) {
        set_err('ค่าพารามิเตอร์ไม่ถูกต้อง');
        redirect('business/list-business');
    }
    $query = "DELETE FROM business WHERE business_id =" . pq($business_id);
    mysqli_query($db, $query);
    if (mysqli_affected_rows($db)) {
        set_info('ลบข้อมูลสำเร็จ');
    }
    redirect('app/business/list');
}
?>
