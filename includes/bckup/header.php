
  <?php
  function getUrl($requestUri)
  {
      $current_file_name = $_SERVER['REQUEST_URI'];
      if ($current_file_name == $requestUri){
          echo "";
      }else{
        echo "collapsed";
      }
  }
  ?>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Self Declaration</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2">
                <?php
                if(isset($_SESSION['user']['Name'])){
                    echo $_SESSION['user']['Name'];
                }
                ?>
            </span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6> <?php
                if(isset($_SESSION['user']['Name'])){
                    echo $_SESSION['user']['Name'];
                }
                ?></h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li> -->
            <?php if(isset($_SESSION['user']['Role']) && $_SESSION['user']['Role'] ==1){?>
            <li>
            <a class="dropdown-item d-flex align-items-center" href="/changeUserPassword.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Change Password</span>
              </a>
            </li>
            <?php }?>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="/logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link <?=getUrl("/dashboard/")?>" href="/dashboard">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <?php if(isset($_SESSION['user']['Role']) && ($_SESSION['user']['Role'] ==1 || $_SESSION['user']['Role'] ==4)){?>
      <li class="nav-item">
        <a class="nav-link <?=getUrl("/users/")?>" href="/users">
        <i class="bi bi-person-square"></i>
          <span>Users</span>
        </a>
      </li>
      <?php }?>
      <?php if(isset($_SESSION['user']['Role']) && ($_SESSION['user']['Role'] ==3 || $_SESSION['user']['Role'] ==1)){?>
      <li class="nav-item">
        <a class="nav-link <?=getUrl("/selfdeclarationform/")?>" href="/selfdeclarationform">
        <i class="bi bi-person-vcard-fill"></i>
          <span>Self Declaration Form</span>
        </a>
      </li>
      <?php }?>
      <?php if(isset($_SESSION['user']['Role']) && ($_SESSION['user']['Role'] ==2 || $_SESSION['user']['Role'] ==1)){?>
      <li class="nav-item">
        <a class="nav-link <?=getUrl("/selfdeclarationlist/")?>" href="/selfdeclarationlist">
        <i class="bi bi-layout-text-window-reverse"></i>
          <span>Self Declaration List</span>
        </a>
      </li>
      <?php }?>
      <?php if(isset($_SESSION['user']['Role']) && $_SESSION['user']['Role'] ==1){?>
      <li class="nav-item">
        <a class="nav-link <?=getUrl("/csvupload/")?>" href="/csvupload">
        <i class="bi bi-box-arrow-right"></i>
          <span>CSV Uploader</span>
        </a>
      </li>
      <?php }?>
    </ul>
  </aside><!-- End Sidebar-->

  <!-- ====== Footer ======= -->
  <!-- <footer id="footer" class="footer"> -->
    <!-- <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div> -->
  <!-- </footer>End Footer   -->