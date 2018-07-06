
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

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#5a" role="tab" aria-controls="pills-home" aria-selected="true">Delay</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#1a" role="tab" aria-controls="pills-profile" aria-selected="false">Within 8 Hours</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#2a" role="tab" aria-controls="pills-contact" aria-selected="false">Between 8 to 16 Hours</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-24hours-tab" data-toggle="pill" href="#3a" role="tab" aria-controls="pills-24hours" aria-selected="false">Between 16 to 24 Hours</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-48hours-tab" data-toggle="pill" href="#4a" role="tab" aria-controls="pills-48hours" aria-selected="false">Between 24 to 48 Hours</a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="5a" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="tile" >
                                <h2>Delay </h2>
                                <table id="tblCustomers1"  data-page-length='25' class="table table-striped" width="100%">
                                    <thead>
                                    <tr>
                                        <td>#</td>
                                        <th>WO Number</th>
                                        <th>WO DATE/TIME</th>
                                        <th>Client Name</th>
                                        <th>Total Qty</th>
                                        <th>Completed%</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php

                                    $i=1;
                                    foreach($delays as $r)
                                    {
                                        $total_qty = $r['Total_Qty'];
                                        $completed = $r['total'] - $r['remaining'];
                                        $totel_completed = ($completed/$total_qty) * 100;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $r['WO_Number']; ?></td>
                                            <td><?php echo $r['WO_Created_On']; ?></td>
                                            <td><?php echo $r['Customer_Company_Name']; ?></td>
                                            <td><?php echo $r['Total_Qty']; ?></td>
                                            <?php
                                            if($totel_completed < 50)
                                            { ?>
                                                <td style="color: red;"><h3><?php echo  $totel_completed; ?>%</h3></td>
                                                <?php
                                            }
                                            elseif($totel_completed >50 && $totel_completed <90 )
                                            {
                                                ?>
                                                <td style="color: orange;"><h3><?php echo  $totel_completed; ?>%</h3></td>

                                                <?php
                                            }
                                            else{ ?>
                                                <td style="color: green;"><h3><?php echo  $totel_completed; ?>%</h3></td>
                                            <?php }
                                            ?>

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
                <div class="tab-pane fade" id="1a" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="tile">
                        <h2>Within 8 Hours</h2>
                        <table id="tblCustomers2"  data-page-length='25' class="table table-striped" width="100%">
                        <thead>
                        <tr>
                            <td>#</td>
                            <th>WO Number</th>
                            <th>WO DATE/TIME</th>
                            <th>Client Name</th>
                            <th>Total Qty</th>
                            <th>Completed %</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i=1;
                        foreach($hours as $r)
                        {
                            $total_qty = $r['Total_Qty'];
                            $completed = $r['total'] - $r['remaining'];
                            $totel_completed = ($completed/$total_qty) * 100;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $r['WO_Number']; ?></td>
                                <td><?php echo $r['WO_Created_On']; ?></td>
                                <td><?php echo $r['Customer_Company_Name']; ?></td>
                                <td><?php echo $r['Total_Qty']; ?></td>
                                <?php
                                if($totel_completed < 50)
                                { ?>
                                    <td style="color: red;"><h3><?php echo  $totel_completed; ?>%</h3></td>
                                    <?php
                                }
                                elseif($totel_completed >50 && $totel_completed <90 )
                                {
                                    ?>
                                    <td style="color: orange;"><h3><?php echo  $totel_completed; ?>%</h3></td>

                                    <?php
                                }
                                else{ ?>
                                    <td style="color: green;"><h3><?php echo  $totel_completed; ?>%</h3></td>
                                <?php }
                                ?>
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
                <div class="tab-pane fade" id="2a" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div class="tile">
                        <h2>Between 8 to 16 Hours</h2>
                        <table id="tblCustomers3"  data-page-length='25' class="table table-striped" width="100%">
                        <thead>
                        <tr>
                            <td>#</td>
                            <th>WO Number</th>
                            <th>WO DATE/TIME</th>
                            <th>Client Name</th>
                            <th>Total Qty</th>
                            <th>Completed %</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i=1;
                        foreach($hours16 as $r)
                        {
                            $total_qty = $r['Total_Qty'];
                            $completed = $r['total'] - $r['remaining'];
                            $totel_completed = ($completed/$total_qty) * 100;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $r['WO_Number']; ?></td>
                                <td><?php echo $r['WO_Created_On']; ?></td>
                                <td><?php echo $r['Customer_Company_Name']; ?></td>
                                <td><?php echo $r['Total_Qty']; ?></td>
                                <?php
                                if($totel_completed < 50)
                                { ?>
                                    <td style="color: red;"><h3><?php echo  $totel_completed; ?>%</h3></td>
                                    <?php
                                }
                                elseif($totel_completed >50 && $totel_completed <90 )
                                {
                                    ?>
                                    <td style="color: orange;"><h3><?php echo  $totel_completed; ?>%</h3></td>

                                    <?php
                                }
                                else{ ?>
                                    <td style="color: green;"><h3><?php echo  $totel_completed; ?>%</h3></td>
                                <?php }
                                ?>
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
                <div class="tab-pane fade" id="3a" role="tabpanel" aria-labelledby="pills-24hours-tab">
                    <div class="tile">
                        <h2>Between 16 to 24 Hours</h2>
                        <table id="tblCustomers4"  data-page-length='25' class="table table-striped" width="100%">
                        <thead>
                        <tr>
                            <td>#</td>
                            <th>WO Number</th>
                            <th>WO DATE/TIME</th>
                            <th>Client Name</th>
                            <th>Total Qty</th>
                            <th>Completed %</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=1;
                        foreach($hours24 as $r)
                        {
                            $total_qty = $r['Total_Qty'];
                            $completed = $r['total'] - $r['remaining'];
                            $totel_completed = ($completed/$total_qty) * 100;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $r['WO_Number']; ?></td>
                                <td><?php echo $r['WO_Created_On']; ?></td>
                                <td><?php echo $r['Customer_Company_Name']; ?></td>
                                <td><?php echo $r['Total_Qty']; ?></td>
                                <?php
                                if($totel_completed < 50)
                                { ?>
                                    <td style="color: red;"><h3><?php echo  $totel_completed; ?>%</h3></td>
                                    <?php
                                }
                                elseif($totel_completed >50 && $totel_completed <90 )
                                {
                                    ?>
                                    <td style="color: orange;"><h3><?php echo  $totel_completed; ?>%</h3></td>

                                    <?php
                                }
                                else{ ?>
                                    <td style="color: green;"><h3><?php echo  $totel_completed; ?>%</h3></td>
                                <?php }
                                ?>
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
                <div class="tab-pane fade" id="4a" role="tabpanel" aria-labelledby="pills-48hours-tab">
                    <div class="tile">
                        <h2>Between 24 to 48 Hours</h2>
                    <table id="tblCustomers5"  data-page-length='25' class="table table-striped" width="100%">
                        <thead>
                        <tr>
                            <td>#</td>
                            <th>WO Number</th>
                            <th>WO DATE/TIME</th>
                            <th>Client Name</th>
                            <th>Total Qty</th>
                            <th>Completed %</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $i=1;
                        foreach($hours48 as $r)
                        {
                            $total_qty = $r['Total_Qty'];
                            $completed = $r['total'] - $r['remaining'];
                            $totel_completed = ($completed/$total_qty) * 100;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $r['WO_Number']; ?></td>
                                <td><?php echo $r['WO_Created_On']; ?></td>
                                <td><?php echo $r['Customer_Company_Name']; ?></td>
                                <td><?php echo $r['Total_Qty']; ?></td>
                                <?php
                                if($totel_completed < 50)
                                { ?>
                                    <td style="color: red;"><h3><?php echo  $totel_completed; ?>%</h3></td>
                                    <?php
                                }
                                elseif($totel_completed >50 && $totel_completed <90 )
                                {
                                    ?>
                                    <td style="color: orange;"><h3><?php echo  $totel_completed; ?>%</h3></td>

                                    <?php
                                }
                                else{ ?>
                                    <td style="color: green;"><h3><?php echo  $totel_completed; ?>%</h3></td>
                                <?php }
                                ?>
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
</main>
<script>
    $(document).ready(function() {
        /*stay in same tab after form submit*/
        $('a[data-toggle="pill"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){

            $('#pills-tab a[href="' + activeTab + '"]').tab('show');
        }
        $('#tblCustomers5').DataTable();
        $('#tblCustomers4').DataTable();
//        $('#tblCustomers3').DataTable();
//        $('#tblCustomers2').DataTable();
//        $('#tblCustomers1').DataTable();
    } );
</script>






