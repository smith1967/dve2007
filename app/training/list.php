<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
$title = "การฝึกอาชีพ";
$active = 'training';
$subactive = 'list';
$school_id = $_SESSION['user']['school_id'];
//is_admin('app/home/index');

$page = isset($_GET['page']) ? $_GET['page'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : "list";
//    $group = isset($_GET['group']) ? $_GET['group'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : '';
$limit = isset($_GET['limit']) ? $_GET['limit'] : 40;

$params = array(
    'action' => $action,
    'limit' => $limit,
//        'group' => $group
);
$params = http_build_query($params);
$traininglist = get_training($school_id, $page, $limit);
//var_dump($traininglist);
//die();
//    $total = get_total();
$url = site_url('app/training/list-training&') . $params;
//    var_dump($businesslist);
//    exit();
$total = get_total();
//if(!isset($total))redirect("/admin/index");
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    do_delete($_GET['training_id']);
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
                รายการฝึกอาชีพ
                <small>ฝึกอาชีพ</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> หน้าหลัก</a></li>
                <li><a href="#">ฝึกอาชีพ</a></li>
                <li class="active">รายการ</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <?php show_message() ?> 
                <div class="box-header">
                    <h3 class="box-title">รายการฝึกอาชีพ</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                    <table id="data" class="table  table-bordered table-striped ">
                        <thead>
                            <tr>
                                <th>รหัสการฝึกอาชีพ</th>
                                <th>รหัสนักศึกษา</th>
                                <th>ชื่อนักศึกษา</th>
                                <th>ชื่อสถานประกอบการ</th>
                                <th>สถานศึกษา</th>
                                <th>ชื่อสาขางาน</th>
                                <th>ครูฝึก</th>
                                <!--<th>วันที่ทำสัญญา</th>-->
                                <th>วันที่เริ่มต้นการฝึก</th>
                                <th>วันที่สิ้นสุดการฝึก</th>
                                <th class="col-md-2 text-center">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                         
                <?php
                foreach ($traininglist as $training) :
                    ?>                            
                    <tr>
                    <td><center><?php echo $training['training_id']; ?></td>
                    <td><center><?php echo $training['std_id']; ?></center></td>
                    <td><center><?php echo $training['std_name']; ?></center></td>
                    <td><center><?php echo $training['business_name']; ?></center></td>
                    <td><center><?php echo $training['school_name']; ?></center></td>
                    <td><center><?php echo $training['minor_name']; ?></center></td>
                    <td><center><?php echo $training['trainer_name']; ?></center></td>
                    <!--<td><center><?php echo $training['contract_date']; ?></center></td>-->
                    <td><center><?php echo $training['start_date']; ?></center></td>
                    <td><center><?php echo $training['end_date']; ?></center></td>
                    <td class="text-center">                            
                            <a href="<?php echo site_url('app/training/list') . '&action=delete&training_id=' . $training['training_id']; ?>"  class="btn btn-danger btn-sm delete" ><i class="fa fa-remove"></i></a>
                            <a href="<?php echo site_url('app/training/edit') . '&action=edit&training_id=' . $training['training_id']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                        </td>                    
                    </tr>
                <?php endforeach; ?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>รหัสการฝึกอาชีพ</th>
                                <th>รหัสนักศึกษา</th>
                                <th>ชื่อนักศึกษา</th>
                                <th>ชื่อสถานประกอบการ</th>
                                <th>สถานศึกษา</th>
                                <th>ชื่อสาขางาน</th>
                                <th>ครูฝึก</th>
                                <!--<th>วันที่ทำสัญญา</th>-->
                                <th>วันที่เริ่มต้นการฝึก</th>
                                <th>วันที่สิ้นสุดการฝึก</th>
                                <th>ดำเนินการ</th>
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

function get_training($school_id, $page = 0, $limit = 10) {
    global $db;
    $start = $page * $limit;
//    $query = "SELECT * FROM training WHERE school_id = ".pq($school_id)." LIMIT " . $start . "," . $limit . "";
    $query = "SELECT t1.std_id,t1.std_name,t2.business_name,t3.*,t4.minor_name,t5.trainer_name,t6.school_name "
            . "FROM training AS t3 "
            . "LEFT JOIN student AS t1 ON t1.citizen_id=t3.citizen_id "
            . "LEFT JOIN business AS t2 ON t2.business_id=t3.business_id "
            . "LEFT JOIN minor AS t4 ON t4.minor_id=t3.minor_id "
            . "LEFT JOIN school AS t6 ON t3.school_id = t6.school_id "
            . "LEFT JOIN trainer AS t5 ON t5.trainer_id=t3.trainer_id "
            . " WHERE t3.school_id = " . pq($school_id) ;
    $result = mysqli_query($db, $query);
//    var_dump($query);
//    die();
    $traininglist = array();
    while ($training = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $traininglist[] = $training;
    }
    return $traininglist;
}

function get_total() {
    global $db;
//    $val = $group."%";
    $query = "SELECT * FROM training WHERE "
            . "school_id = " . pq($school_id) . " ORDER BY training_id";
    $result = mysqli_query($db, $query);
    return mysqli_num_rows($result);
}

function do_delete($training_id) {
    global $db;
    if (empty($training_id)) {
        set_err('app/ค่าพารามิเตอร์ไม่ถูกต้อง');
        redirect('app/training/list');
    }
    $query = "DELETE FROM training WHERE training_id =" . pq($training_id);
    mysqli_query($db, $query);
    if (mysqli_affected_rows($db)) {
        set_info('app/ลบข้อมูลสำเร็จ');
    }
    redirect('app/training/list');
}
