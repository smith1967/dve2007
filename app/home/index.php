<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$active = 'home';
$subactive = 'index';
$title = 'หน้าหลัก';
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
                <small>DVE2017LTE</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
<!--                <li><a href="#">Examples</a></li>
                <li class="active">Blank page</li>-->
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Title</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    Start creating your amazing application!
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    Footer
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Title</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    Start creating your amazing application!
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    Footer
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
            
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php require_once 'template/main-footer.php'; ?>    
</div>
<!--.wrapper-->
<?php require_once 'template/footer.php'; ?>
