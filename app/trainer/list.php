<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "ครูฝึก";
$active = 'trainer';
$subactive = 'list';
$trainerlist = get_trainer();
//if(!isset($total))redirect("/admin/index");
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    do_delete($_GET['trainer_id']);
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
                รายชื่อครูฝึก
                <small>ครูฝึก</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">ครูฝึก</a></li>
                <li class="active">รายชื่อ</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <?php show_message() ?> 
                <div class="box-header">
                    <h3 class="box-title">รายชื่อครูฝึก</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                    <table id="data" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อครูฝึก</th>
                                <th>เบอร์โทรศัพท์</th>
                                <th>วุฒิการศึกษา</th>
                                <th>ชื่อสถานประกอบการ</th>
                                <th class="text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($trainerlist as $trainer) :
                                ?>                            
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $trainer['trainer_name']; ?></td>
                                    <td><?php echo $trainer['phone']; ?></td>
                                    <td><?php echo $trainer['educational_name']; ?></td>
                                    <td><?php echo $trainer['business_name']; ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo site_url('app/trainer/list') . '&action=delete&trainer_id=' . $trainer['trainer_id']; ?>" class="btn btn-danger btn-sm delete" ><i class="fa fa-remove"></i></a> | 
                                        <a href="<?php echo site_url('app/trainer/edit') . '&action=edit&trainer_id=' . $trainer['trainer_id']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
<!--                                        <a href="#" class="delete"> <i class="fa fa-remove"></i></a> | 
                                        <a href="#" ><i class="fa fa-edit"></i></a>-->
                                    </td>                    
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อครูฝึก</th>
                                <th>เบอร์โทรศัพท์</th>
                                <th>วุฒิการศึกษาสูงสุด</th>
                                <th>ชื่อสถานประกอบการ</th>
                                <th class="text-center">จัดการ</th>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
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
    $(document).ready(function () {
        $('#data').DataTable({
            "language": {
                "lengthMenu": "แสดง _MENU_ แถวต่อหน้า",
                "zeroRecords": "ไม่มีข้อมูล",
                "info": "กำลังแสดงข้อมูล _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                "search": "ค้นหา:",
                "infoEmpty": "ไม่มีข้อมูลแสดง",
                "infoFiltered": "(ค้นหาจาก _MAX_ total records)",
                "paginate": {
                    "first": "หน้าแรก",
                    "last": "หน้าสุดท้าย",
                    "next": "หน้าต่อไป",
                    "previous": "หน้าก่อน"
                }
            }
        });
    });
</script>
<script>
    $('.delete').click(function () {
        return confirm('ยืนยันลบข้อมูล')
    });
</script>
<?php

function get_trainer() {
    global $db;
//    $start = $page * $limit;
    $query = "SELECT "
            . "t.*,e.educational_name,b.business_name "
            . "FROM trainer t "
            . "JOIN educational e ON t.educational_id = e.educational_id "
            . "JOIN business b ON t.business_id = b.business_id ORDER BY t.trainer_id ASC;";
    $result = mysqli_query($db, $query);
    $trainerlist = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $trainerlist[] = $row;
    }
    return $trainerlist;
}

function get_total() {
    global $db;
//    $val = $group."%";
    $query = "SELECT * FROM trainer ";
    $result = mysqli_query($db, $query);
    return mysqli_num_rows($result);
}

function do_delete($trainer_id) {
    global $db;
    if (empty($trainer_id)) {
        set_err('ค่าพารามิเตอร์ไม่ถูกต้อง');
        redirect('app/trainer/list');
    }
    $query = "DELETE FROM trainer WHERE trainer_id =" . pq($trainer_id);
    mysqli_query($db, $query);
    if (mysqli_affected_rows($db)) {
        set_info('ลบข้อมูลสำเร็จ');
    }
    redirect('app/trainer/list');
}
?>
