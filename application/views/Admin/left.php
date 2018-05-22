<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?php echo base_url('img/st.jpg'); ?>" alt="User Image">
        <div>
            <p class="app-sidebar__user-name"><?php echo("{$_SESSION['user_name']}"."<br />");?></p>
            <!--<p class="app-sidebar__user-designation">Admin</p>-->
        </div>
    </div>
    <ul class="app-menu">

       <?php if($_SESSION['role'] == 'Admin')
       { ?>
           <li><a class="app-menu__item active" href="<?php echo site_url('Admin_Controller/dashboard'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-building"></i><span class="app-menu__label">Stronglass Tough</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <!-- <li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Size_Master'); ?><!--"><i class="icon fa fa-circle-o"></i> Size Entry</a></li>-->
                <!--<li><a class="treeview-item" href="<?php /*echo site_url('Admin_Controller/Add_Stornglass'); */?>"><i class="icon fa fa-circle-o"></i>Add ST </a></li>-->
                <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/View_Stronglass'); ?>"><i class="icon fa fa-circle-o"></i>View ST</a></li>
            </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Master Entry</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <!--<li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Size_Master'); ?><!--"><i class="icon fa fa-circle-o"></i> Size Entry</a></li>-->
                <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Stock_Entry'); ?>"><i class="icon fa fa-circle-o"></i> Material Entry</a></li>
                <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Charges_Entry'); ?>"><i class="icon fa fa-circle-o"></i>Charges Entry</a></li>
                <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Inventry'); ?>"><i class="icon fa fa-circle-o"></i> Material Inventry</a></li>
            </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Customer Entry</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <!--<li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Size_Master'); ?><!--"><i class="icon fa fa-circle-o"></i> Size Entry</a></li>-->
                <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Add_Customers'); ?>"><i class="icon fa fa-circle-o"></i> Add Customer Details</a></li>
                <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Add_Address'); ?>"><i class="icon fa fa-circle-o"></i>Add Locations</a></li>
                <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/View_Customers'); ?>"><i class="icon fa fa-circle-o"></i>View Customers</a></li>

            </ul>
        </li>
           <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Work Order</span><i class="treeview-indicator fa fa-angle-right"></i></a>
               <ul class="treeview-menu">
                   <!--<li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Size_Master'); ?><!--"><i class="icon fa fa-circle-o"></i> Size Entry</a></li>-->
                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Create_Work_Order'); ?>"><i class="icon fa fa-circle-o"></i> Create Work Order</a></li>
<!--                   <li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Add_Address'); ?><!--"><i class="icon fa fa-circle-o"></i>Add Locations</a></li>-->
<!--                   <li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/View_Customers'); ?><!--"><i class="icon fa fa-circle-o"></i>View Customers</a></li>-->

               </ul>
           </li>

       <?php }
        elseif($_SESSION['role'] == 'MD')
        { ?>
            <li><a class="app-menu__item active" href="<?php echo site_url('Admin_Controller/dashboard'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>

        <?php }
        ?>


<!--        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Invoice</span><i class="treeview-indicator fa fa-angle-right"></i></a>-->
<!--            <ul class="treeview-menu">-->
<!--                <!--<li><a class="treeview-item" href="-->--><?php ////echo site_url('Admin_Controller/Size_Master'); ?><!--<!--"><i class="icon fa fa-circle-o"></i> Size Entry</a></li>-->-->
<!--                <li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Proforma_Invoice'); ?><!--"><i class="icon fa fa-circle-o"></i> Add Profoma Invoice</a></li>-->
<!--                <li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Invoice_List'); ?><!--"><i class="icon fa fa-circle-o"></i>View Invoice</a></li>-->
<!--            </ul>-->
<!--        </li>-->
<!--        <li><a class="app-menu__item" href="--><?php //echo site_url('Admin_Controller/Work_Order'); ?><!--"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Work Order</span></a></li>-->

    </ul>
    </ul>
</aside>