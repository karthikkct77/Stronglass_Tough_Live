
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
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="5a" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="tile" >
                        <h2>Work Order Status </h2>
                        <table id="tblCustomers1"  data-page-length='25' class="table table-striped" width="100%">
                            <thead>
                            <tr>
                                <td>#</td>
                                <th>WO Number</th>
                                <th>WO DATE/TIME</th>
                                <th>Client Name</th>
                                <th>Total Qty</th>
                                <th>Completed%</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php

                            $i=1;
                            foreach($kerala_wo as $r)
                            {
                                $total_qty = $r['Total_Qty'];
                                $remain = $r['remaining'];
                                $completed = $total_qty - $remain;
                                $totel_completed = (int)(($completed / $total_qty) * 100);
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






