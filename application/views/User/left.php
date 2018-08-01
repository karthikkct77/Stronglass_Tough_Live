<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?php echo base_url('img/st.jpg'); ?>" alt="User Image">
        <div>
            <p class="app-sidebar__user-name"><?php echo("{$_SESSION['user_name']}"."<br />");?></p>
            <?php
            if($_SESSION['role'] == 2)
            { ?>
                <p class="app-sidebar__user-designation">CUTTING</p>
         <?php   }
            elseif ($_SESSION['role'] == 3)
            { ?>
                <p class="app-sidebar__user-designation">FURNACE</p>
          <?php  }
            elseif ($_SESSION['role'] == 4)
            { ?>
                <p class="app-sidebar__user-designation">DISPATCH</p>
          <?php  }
            elseif ($_SESSION['role'] == 5)
            { ?>
                <p class="app-sidebar__user-designation">DATA ENTRY</p>
            <?php  }
            elseif ($_SESSION['role'] == 6)
            { ?>
                <p class="app-sidebar__user-designation">WO ENTRY</p>
            <?php  }
            elseif ($_SESSION['role'] == 7)
            { ?>
                <p class="app-sidebar__user-designation">Confirm/ Review PI</p>
            <?php  }
            elseif ($_SESSION['role'] == 9)
            { ?>
                <p class="app-sidebar__user-designation">Fabrication</p>
            <?php  }
            ?>

        </div>
    </div>
    <ul class="app-menu">

        <?php
        if($_SESSION['role'] == 2)
        { ?>
            <li><a class="app-menu__item " href="<?php echo site_url('User_Controller/dashboard'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
            <li><a class="app-menu__item" href="<?php echo site_url('User_Controller/Work_Order'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Work Order</span></a></li>

        <?php   }
        elseif ($_SESSION['role'] == 3)
        { ?>
            <li><a class="app-menu__item " href="<?php echo site_url('User_Controller/dashboard'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
            <li><a class="app-menu__item" href="<?php echo site_url('User_Controller/Work_Order'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Work Order</span></a></li>

        <?php  }
        elseif ($_SESSION['role'] == 4)
        { ?>
            <li><a class="app-menu__item " href="<?php echo site_url('User_Controller/dashboard'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
            <li><a class="app-menu__item" href="<?php echo site_url('User_Controller/Work_Order'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Work Order</span></a></li>

        <?php  }
        elseif ($_SESSION['role'] == 5)
        {   ?>
            <li><a class="app-menu__item " href="<?php echo site_url('User_Controller/dashboard'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Profoma Invoice</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <!--<li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Size_Master'); ?><!--"><i class="icon fa fa-circle-o"></i> Size Entry</a></li>-->
                    <li><a class="treeview-item" href="<?php echo site_url('User_Controller/Proforma_Invoice'); ?>"><i class="icon fa fa-circle-o"></i>Normal PI</a></li>
                    <li><a class="treeview-item" href="<?php echo site_url('User_Controller/Sheet_PI'); ?>"><i class="icon fa fa-circle-o"></i>Sheet PI</a></li>
                    <!--                   <li><a class="treeview-item" href="--><!--"><i class="icon fa fa-circle-o"></i>View Customers</a></li>-->

                </ul>
            </li>
            <li><a class="app-menu__item" href="<?php echo site_url('User_Controller/Invoice_List'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">View PI</span></a></li>

        <?php  }
        elseif ($_SESSION['role'] == 6)
        { ?>
            <li><a class="app-menu__item " href="<?php echo site_url('User_Controller/dashboard'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
            <li><a class="app-menu__item" href="<?php echo site_url('User_Controller/Generate_WO'); ?>"><i class="app-menu__icon fa fa-file-powerpoint-o"></i><span class="app-menu__label">View PI List</span></a></li>
            <li><a class="app-menu__item" href="<?php echo site_url('User_Controller/View_WO'); ?>"><i class="app-menu__icon fa fa-barcode"></i><span class="app-menu__label">View WO List</span></a></li>
            <li><a class="app-menu__item" href="<?php echo site_url('User_Controller/Print_WO'); ?>"><i class="app-menu__icon fa fa-print"></i><span class="app-menu__label">Print WO</span></a></li>
            <li><a class="app-menu__item" href="<?php echo site_url('User_Controller/Re_Cut'); ?>"><i class="app-menu__icon fa fa-scissors"></i><span class="app-menu__label">Recut</span></a></li>

        <?php  }
        elseif ($_SESSION['role'] == 7)
        { ?>
            <li><a class="app-menu__item " href="<?php echo site_url('User_Controller/dashboard'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
            <li><a class="app-menu__item" href="<?php echo site_url('User_Controller/Check_PI'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">CHECK PI</span></a></li>

        <?php  }
        elseif ($_SESSION['role'] == 8)
        { ?>
            <li><a class="app-menu__item " href="<?php echo site_url('User_Controller/Production_Dashboard'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
<!--            <li><a class="app-menu__item" href="--><?php //echo site_url('User_Controller/Check_PI'); ?><!--"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">CHECK PI</span></a></li>-->

        <?php  }
        elseif ($_SESSION['role'] == 9)
        { ?>
            <li><a class="app-menu__item " href="<?php echo site_url('User_Controller/dashboard'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
            <li><a class="app-menu__item" href="<?php echo site_url('User_Controller/Work_Order'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Work Order</span></a></li>

        <?php  }
        ?>
    </ul>
</aside>