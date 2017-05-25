<?php
$menu = Array(
    'home' => array(
        'title' => 'หน้าหลัก',
        'url' => site_url(),
        'class' => 'fa fa-home',
        'cond' => true,
//        'subitems' => array(
//            'index' => array(
////                'title' => 'หน้าหลัก',
////                'url' => 'app/home/index',
////                'cond' => FALSE,
//            ),
////            'test' => array(
////                'title' => 'ทดสอบ',
////                'url' => 'app/home/test',
////                'cond' => true,
////            ),
//        ),
    ),
    'school' => array(
        'title' => 'สถานศึกษา',
        'url' => '#',
        'class' => 'fa fa-graduation-cap',
        'cond' => is_school_staff(),
        'subitems' => array(
//            'index' => array(
//                'title' => 'หน้าหลัก',
//                'cond' => true,
//                'url' => 'app/school/index',
//            ),
            'list' => array(
                'title' => 'ข้อมูล',
                'url' => 'app/school/list-data',
                'cond' => is_school_staff(),
            ),
            'edit' => array(
                'title' => 'แก้ไขข้อมูล',
                'url' => 'app/school/edit',
                'cond' => is_school_staff() ,
            ),
        ),
    ),
    'student' => array(
        'title' => 'นักศึกษา',
        'url' => '#',
        'class' => 'fa fa-graduation-cap',
        'cond' => is_school_staff() || is_admin(),
        'subitems' => array(
            'file-manager' => array(
                'title' => 'จัดการไฟล์',
                'url' => 'app/student/file-manager',
                'cond' => is_school_staff() || is_admin(),
            ),
            'check-data' => array(
                'title' => 'ตรวจสอบข้อมูล',
                'url' => 'app/student/check-data',
                'cond' => is_school_staff() || is_admin(),
            ),
            'list' => array(
                'title' => 'รายชื่อ',
                'url' => 'app/student/list',
                'cond' => is_school_staff() || is_admin(),
            ),
            'list-nosent' => array(
                'title' => 'สถานศึกษาที่ไม่ส่งข้อมูล',
                'url' => 'app/student/list-nosent',
                'cond' => is_dvt_staff() || is_admin() || is_dvt_admin(),
            ),
        ),
    ),
    'school_type' => array(
        'title' => 'ประเภทสถานศึกษา',
        'url' => '#',
        'class' => 'fa fa-graduation-cap',
        'cond' => is_admin(),
        'subitems' => array(
            'index' => array(
                'title' => 'จัดการข้อมูล',
                'cond' => true,
                'url' => 'app/school_type/index',
            ),
        ),
    ),
    'pages' => array(
        'title' => 'ข่าวสาร',
        'url' => '#',
        'class' => 'fa fa-book',
        'cond' => is_admin(),
        'subitems' => array(
            'list' => array(
                'title' => 'จัดการข่าวสาร',
                'cond' => true,
                'url' => 'app/pages/list',
            ),
            'insert' => array(
                'title' => 'เพิ่มข่าวสาร',
                'cond' => true,
                'url' => 'app/pages/insert',
            ),
        ),
    ),
    'business' => array(
        'title' => 'สถานประกอบการ',
        'url' => '#',
        'class' => 'fa fa-building-o',
        'cond' => true,
        'subitems' => array(
            'list' => array(
                'title' => 'รายชื่อ',
                'cond' => true,
                'url' => 'app/business/list',
            ),
            'insert' => array(
                'title' => 'เพิ่มข้อมูล',
                'url' => 'app/business/insert',
                'cond' => is_auth(),
            ),
            'edit' => array(
                'title' => 'แก้ไขข้อมูล',
                'url' => 'app/business/edit',
                'cond' => is_auth(),
            ),
        ),
    ),
    'trainer' => array(
        'title' => 'ครูฝึก',
        'url' => '#',
        'class' => 'fa fa-building-o',
        'cond' => true,
        'subitems' => array(
            'list' => array(
                'title' => 'รายชื่อ',
                'cond' => true,
                'url' => 'app/trainer/list',
            ),
            'insert' => array(
                'title' => 'เพิ่มข้อมูล',
                'url' => 'app/trainer/insert',
                'cond' => is_auth(),
            ),
            'edit' => array(
                'title' => 'แก้ไขข้อมูล',
                'url' => 'app/trainer/edit',
                'cond' => is_auth(),
            ),
        ),
    ),
    'training' => array(
        'title' => 'การฝึกอาชีพ',
        'url' => '#',
        'class' => 'fa fa-building-o',
        'cond' => true,
        'subitems' => array(
            'list' => array(
                'title' => 'รายการ',
                'cond' => true,
                'url' => 'app/training/list',
            ),
            'insert' => array(
                'title' => 'เพิ่มข้อมูล',
                'url' => 'app/training/insert',
                'cond' => is_auth(),
            ),
            'edit' => array(
                'title' => 'แก้ไขข้อมูล',
                'url' => 'app/training/edit',
                'cond' => is_auth(),
            ),
        ),
    ),
    'admin' => array(
        'title' => 'ผู้ดูแลระบบ',
        'url' => '#',
        'class' => 'fa fa-users',
        'cond' => is_admin(),
        'subitems' => array(
            'list-user' => array(
                'title' => 'รายชื่อ',
                'cond' => is_admin(),
                'url' => 'app/admin/list-user',
            ),
//            'insert' => array(
//                'title' => 'เพิ่มข้อมูล',
//                'url' => 'app/admin/insert-user',
//                'cond' => is_auth(),
//            ),
            'edit-user' => array(
                'title' => 'แก้ไขข้อมูล',
                'url' => 'app/admin/edit-user',
                'cond' => is_admin(),
            ),
        ),
    ),
    'user' => array(
        'title' => 'ผู้ใช้งาน',
        'url' => '#',
        'class' => 'fa fa-user',
        'cond' => true,
        'subitems' => array(
//                  'index' => array(
//                      'title' => 'หน้าหลัก',
//                      'cond' => true,
//                      'url' => 'app/user/index',
//                  ),
            'signup' => array(
                'title' => 'สมัครสมาชิก',
                'url' => 'app/user/signup',
                'cond' => !is_auth(),
            ),
            'change-password' => array(
                'title' => 'เปลี่ยนรหัสผ่าน',
                'url' => 'app/user/change-password',
                'cond' => is_auth(),
            ),
            'login' => array(
                'title' => 'เข้าระบบ',
                'url' => 'app/user/login',
                'cond' => !is_auth(),
            ),
            'logout' => array(
                'title' => 'ออกระบบ',
                'url' => 'app/user/logout',
                'cond' => is_auth(),
            ),
        ),
    ),
);
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php if(is_auth()) : ?>
              <img src="upload/user-images/noImage.png" class="user-image" alt="User Image">
                <?php else: ?>
              <img src="upload/user-images/noImage1.png" class="user-image" alt="User Image">              
              <?php endif; ?>
            </div>
            <div class="pull-left info">
                <p><?php echo $_SESSION['user']['fname']; ?></p>
                <?php if (is_auth()) : ?>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                <?php else: ?>
                    <a href="#"><i class="fa fa-circle text-orange"></i> Offline</a>          
                <?php endif; ?>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <?php
        echo gen_sidebar_menu($menu, $active, $subactive, $class);
        ?>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
