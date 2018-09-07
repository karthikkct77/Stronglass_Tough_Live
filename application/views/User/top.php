<body class="app sidebar-mini rtl pace-done sidenav-toggled">
<!-- Navbar-->
<header class="app-header"><a class="app-header__logo" href="#">Stronglass Tough</a>
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">
        <?php
        if($_SESSION['role'] == 5)
        { ?>
            <li ><a class="app-nav__item" href="<?php echo site_url('User_Controller/Get_All_Message');?>" ><i class="fa fa-bell-o fa-lg"></i></a>

            </li>

       <?php   }
        elseif ($_SESSION['role'] == 10)
        { ?>
            <li><a class="app-nav__item" href="<?php echo site_url('User_Controller/Get_All_Message');?>" ><i class="fa fa-bell-o fa-lg"></i></a>

            </li>

        <?php  }
        elseif ($_SESSION['role'] == 11)
        { ?>
            <li><a class="app-nav__item" href="<?php echo site_url('User_Controller/Get_All_Message');?>"><i class="fa fa-bell-o fa-lg"></i></a>

            </li>

         <?php  } ?>


        <!--Notification Menu-->


        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                <li><a class="dropdown-item" href="<?php echo site_url('User_Controller/change_password');?>"><i class="fa  fa-key fa-lg"></i> Change Password</a></li>
                <li><a class="dropdown-item" href="<?php echo site_url('Login/logout');?>"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
            </ul>
        </li>
    </ul>
</header>