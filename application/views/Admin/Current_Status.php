
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Status</h1>

        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Current Status</li>

        </ul>
    </div>
    <style>
        .padding_class {
            padding: 10px 0;
        }
        h2{
            padding: 3px;
            background:#3c8dbc;
            color: white;
            font-family: initial;
        }

    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-title">
                    <ul  class="nav nav-pills" id="myTab">
                        <li class="active"><a  href="#5a" data-toggle="tab">Delay </a></li>
                        <li><a href="#1a" data-toggle="tab">With in 8Hr </a></li>
                        <li><a href="#2a" data-toggle="tab">8 to 16 hr</a></li>
                        <li><a href="#3a" data-toggle="tab">16 to 24hr</a></li>
                        <li><a href="#4a" data-toggle="tab">24 to 48hr</a></li>
                    </ul>
                </div>
                <div class="tile-body">
                    <div class="row padding_class">
                        <div class="col-md-12">
                            <div class="tab-content clearfix">
                                <div class="tab-pane " id="1a">
                                    <h2>With in 8 hours </h2>
                                    <table id="assigned_tasks" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <td>#</td>
                                            <th>WO Number</th>
                                            <th>WO DATE/TIME</th>
                                            <th>Client Name</th>
                                            <th>Total Qty</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        $i=1;
                                        foreach($hours as $r)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $r['WO_Number']; ?></td>
                                                <td><?php echo $r['WO_Created_On']; ?></td>
                                                <td><?php echo $r['Customer_Company_Name']; ?></td>
                                                <td><?php echo $r['Total_Qty']; ?></td>
                                                <td> <a class="btn btn-info" href="<?php echo site_url('Admin_Controller/View_WO_Status/') . $r['WO_Icode']; ?>">View Status</a></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="2a">
                                    <div class="row padding_class">
                                        <div class="col-md-12" >
                                            <h2>Between 8 hour to 16 hours</h2>
                                            <table id="tblCustomers5"  data-page-length='25' class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <td>#</td>
                                                    <th>WO Number</th>
                                                    <th>WO DATE/TIME</th>
                                                    <th>Client Name</th>
                                                    <th>Total Qty</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <?php
                                                $i=1;
                                                foreach($hours16 as $r)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $r['WO_Number']; ?></td>
                                                        <td><?php echo $r['WO_Created_On']; ?></td>
                                                        <td><?php echo $r['Customer_Company_Name']; ?></td>
                                                        <td><?php echo $r['Total_Qty']; ?></td>
                                                        <td> <a class="btn btn-info" href="<?php echo site_url('Admin_Controller/View_WO_Status/') . $r['WO_Icode']; ?>">View Status</a></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="3a">
                                    <div class="row padding_class">
                                        <div class="col-md-12" >
                                            <h2>Between 16 hour to 24 hours</h2>
                                            <table id="tblCustomers5"  data-page-length='25' class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <td>#</td>
                                                    <th>WO Number</th>
                                                    <th>WO DATE/TIME</th>
                                                    <th>Client Name</th>
                                                    <th>Total Qty</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <?php
                                                $i=1;
                                                foreach($hours24 as $r)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $r['WO_Number']; ?></td>
                                                        <td><?php echo $r['WO_Created_On']; ?></td>
                                                        <td><?php echo $r['Customer_Company_Name']; ?></td>
                                                        <td><?php echo $r['Total_Qty']; ?></td>
                                                        <td> <a class="btn btn-info" href="<?php echo site_url('Admin_Controller/View_WO_Status/') . $r['WO_Icode']; ?>">View Status</a></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="4a">
                                    <div class="row padding_class">
                                        <div class="col-md-12" >
                                            <h2>Between 24 hour to 48 hours</h2>
                                            <table id="tblCustomers5"  data-page-length='25' class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <td>#</td>
                                                    <th>WO Number</th>
                                                    <th>WO DATE/TIME</th>
                                                    <th>Client Name</th>
                                                    <th>Total Qty</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <?php
                                                $i=1;
                                                foreach($hours48 as $r)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $r['WO_Number']; ?></td>
                                                        <td><?php echo $r['WO_Created_On']; ?></td>
                                                        <td><?php echo $r['Customer_Company_Name']; ?></td>
                                                        <td><?php echo $r['Total_Qty']; ?></td>
                                                        <td> <a class="btn btn-info" href="<?php echo site_url('Admin_Controller/View_WO_Status/') . $r['WO_Icode']; ?>">View Status</a></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane active" id="5a">
                                    <div class="row padding_class">
                                        <div class="col-md-12" >
                                            <h2>Delay </h2>
                                            <table id="tblCustomers5"  data-page-length='25' class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <td>#</td>
                                                    <th>WO Number</th>
                                                    <th>WO DATE/TIME</th>
                                                    <th>Client Name</th>
                                                    <th>Total Qty</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <?php
                                                $i=1;
                                                foreach($delay as $r)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $r['WO_Number']; ?></td>
                                                        <td><?php echo $r['WO_Created_On']; ?></td>
                                                        <td><?php echo $r['Customer_Company_Name']; ?></td>
                                                        <td><?php echo $r['Total_Qty']; ?></td>
                                                        <td> <a class="btn btn-info" href="<?php echo site_url('Admin_Controller/View_WO_Status/') . $r['WO_Icode']; ?>">View Status</a></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>



