
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url(); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>MART</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SMART</b>DVE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <!-- Notifications: style can be found in dropdown.less -->
          <!-- Tasks: style can be found in dropdown.less -->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php if(is_auth()) : ?>
              <img src="upload/user-images/noImage.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['user']['fname']; ?></span>
                <?php else: ?>
              <img src="upload/user-images/noImage1.png" class="user-image" alt="User Image">              
              <?php endif; ?>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/user9-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION['user']['fname']. " ". $_SESSION['user']['lname']  ?>
                  <small><?php echo $_SESSION['user']['email']  ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo site_url('app/user/edit')?>" class="btn btn-default btn-flat">แก้ไขข้อมูล</a>
                </div>
                <div class="pull-right">
                    <a href="<?php echo site_url('app/user/logout')?>" class="btn btn-default btn-flat">ออกจากระบบ</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
