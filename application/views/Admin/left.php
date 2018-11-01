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
<!--                <li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Inventry'); ?><!--"><i class="icon fa fa-circle-o"></i> Material Inventry</a></li>-->
            </ul>
        </li>
           <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-plus-square"></i><span class="app-menu__label">Stock Entry</span><i class="treeview-indicator fa fa-angle-right"></i></a>
               <ul class="treeview-menu">
                   <!--<li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Size_Master'); ?><!--"><i class="icon fa fa-circle-o"></i> Size Entry</a></li>-->
                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/New_Stock'); ?>"><i class="icon fa fa-circle-o"></i>New Stock</a></li>
                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Godown_Entry'); ?>"><i class="icon fa fa-circle-o"></i>Godown Stock Entry</a></li>
                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Factory_Stock'); ?>"><i class="icon fa fa-circle-o"></i> Factory Stock</a></li>
               </ul>
           </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Customer Entry</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <!--<li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Size_Master'); ?><!--"><i class="icon fa fa-circle-o"></i> Size Entry</a></li>-->
                <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Add_Customers'); ?>"><i class="icon fa fa-circle-o"></i> Add Customer Details</a></li>
                <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Add_Address'); ?>"><i class="icon fa fa-circle-o"></i>Add Locations</a></li>
                <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/View_Customers'); ?>"><i class="icon fa fa-circle-o"></i>View Customers</a></li>

            </ul>
        </li>
           <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-eye"></i><span class="app-menu__label">Status</span><i class="treeview-indicator fa fa-angle-right"></i></a>
               <ul class="treeview-menu">
                   <!--<li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Size_Master'); ?><!--"><i class="icon fa fa-circle-o"></i> Size Entry</a></li>-->
                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Current_Status'); ?>"><i class="icon fa fa-circle-o"></i>WO Status</a></li>
                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Work_Order'); ?>"><i class="icon fa fa-circle-o"></i>View Work Order</a></li>
                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Complete_Work_Order'); ?>"><i class="icon fa fa-circle-o"></i>Completed WO</a></li>
                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/profoma_invoice'); ?>"><i class="icon fa fa-circle-o"></i>View PI</a></li>

               </ul>
           </li>
           <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Report</span><i class="treeview-indicator fa fa-angle-right"></i></a>
               <ul class="treeview-menu">
                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Pending_PI'); ?>"><i class="icon fa fa-circle-o"></i> Today Pending PI</a></li>
                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Today_Wo_Report'); ?>"><i class="icon fa fa-circle-o"></i>Today WO Report</a></li>
                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/PI_Summary'); ?>"><i class="icon fa fa-circle-o"></i>PI Summary</a></li>
                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/WO_Summary'); ?>"><i class="icon fa fa-circle-o"></i>WO Summary</a></li>

                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Today_Delivery_Report'); ?>"><i class="icon fa fa-circle-o"></i>Delivery</a></li>
<!--                   <li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Today_Despatch_Report'); ?><!--"><i class="icon fa fa-circle-o"></i>Despatch Report</a></li>-->
                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Despatch_Report'); ?>"><i class="icon fa fa-circle-o"></i>Despatch Report</a></li>

                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Monthly_Report'); ?>"><i class="icon fa fa-circle-o"></i>Monthly Report</a></li>



               </ul>
           </li>
           <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-eye"></i><span class="app-menu__label">Expenses</span><i class="treeview-indicator fa fa-angle-right"></i></a>
               <ul class="treeview-menu">
                   <!--<li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Size_Master'); ?><!--"><i class="icon fa fa-circle-o"></i> Size Entry</a></li>-->
                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Expenses_Master'); ?>"><i class="icon fa fa-circle-o"></i>Expenses Master</a></li>
                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/Add_Expenses'); ?>"><i class="icon fa fa-circle-o"></i>Add Expenses</a></li>
                   <li><a class="treeview-item" href="<?php echo site_url('Admin_Controller/View_Expenses'); ?>"><i class="icon fa fa-circle-o"></i>View Expenses</a></li>


               </ul>
           </li>
<!--           <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Work Order</span><i class="treeview-indicator fa fa-angle-right"></i></a>-->
<!--               <ul class="treeview-menu">-->
<!--                   <!--<li><a class="treeview-item" href="--><?php ////echo site_url('Admin_Controller/Size_Master'); ?><!--<!--"><i class="icon fa fa-circle-o"></i> Size Entry</a></li>-->
<!--                   <li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Create_Work_Order'); ?><!--"><i class="icon fa fa-circle-o"></i> Create Work Order</a></li>-->
<!--                   <li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Work_Order'); ?><!--"><i class="icon fa fa-circle-o"></i>View Work Order</a></li>-->
<!--<!--                   <li><a class="treeview-item" href="--><?php ////echo site_url('Admin_Controller/View_Customers'); ?><!--<!--"><i class="icon fa fa-circle-o"></i>View Customers</a></li>-->
<!---->
<!--               </ul>-->
<!--           </li>-->


<!--           <li><a class="app-menu__item active" href="--><?php //echo site_url('Admin_Controller/Upload_Customer'); ?><!--"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Upload</span></a></li>-->


       <?php }
        elseif($_SESSION['role'] == 'MD')
        { ?>
            <li><a class="app-menu__item active" href="<?php echo site_url('Admin_Controller/dashboard'); ?>"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>

        <?php }
        ?>


<!--        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Invoice</span><i class="treeview-indicator fa fa-angle-right"></i></a>-->
<!--            <ul class="treeview-menu">-->
<!--                <!--<li><a class="treeview-item" href="--><?php ////echo site_url('Admin_Controller/Size_Master'); ?><!--<!--"><i class="icon fa fa-circle-o"></i> Size Entry</a></li>--
<!--                <li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Proforma_Invoice'); ?><!--"><i class="icon fa fa-circle-o"></i> Add Profoma Invoice</a></li>-->
<!--                <li><a class="treeview-item" href="--><?php //echo site_url('Admin_Controller/Invoice_List'); ?><!--"><i class="icon fa fa-circle-o"></i>View Invoice</a></li>-->
<!--            </ul>-->
<!--        </li>-->
<!--        <li><a class="app-menu__item" href="--><?php //echo site_url('Admin_Controller/Work_Order'); ?><!--"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Work Order</span></a></li>-->

    </ul>
    </ul>
</aside>