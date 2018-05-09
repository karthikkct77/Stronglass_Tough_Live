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
            ?>

        </div>
    </div>
    <ul class="app-menu">
        <li><a class="app-menu__item active" href="<?php echo site_url('User_Controller/dashboard'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>

        <li><a class="app-menu__item" href="<?php echo site_url('User_Controller/Work_Order'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Work Order</span></a></li>

    </ul>
</aside>