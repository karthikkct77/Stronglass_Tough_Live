
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
                        <li class="active"><a  href="#1a" data-toggle="tab">>With in 8Hr </a></li>
                        <li><a href="#2a" data-toggle="tab">8 to 16 hr</a></li>
                        <li><a href="#3a" data-toggle="tab">16 to 24hr</a></li>
                        <li><a href="#4a" data-toggle="tab">24 to 48hr</a></li>
                    </ul>
                </div>
                <div class="tile-body">
                    <div class="row padding_class">
                        <div class="col-md-12">
                            <div class="tab-content clearfix">
                                <div class="tab-pane active" id="1a">
                                    <h3>With in 8 hours </h3>

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
                                            <h2>Other Task</h2>
                                            <table id="tblCustomers5"  data-page-length='25' class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Company Name</th>
                                                    <th>Contract Type</th>
                                                    <th>Project Title</th>
                                                    <th>Estimate Date</th>
                                                    <th>Tech Team Date</th>
                                                    <th>Leader Name</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i=1;
                                                foreach($Assigned as $r)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $r['Company_Name']; ?></td>
                                                        <td><?php echo $r['Requirement_Type']; ?></td>
                                                        <td><?php echo $r['Project_Title']; ?></td>
                                                        <td><?php echo $r['Estimation_Date']; ?></td>
                                                        <td><?php echo $r['Tech_Team_Date']; ?></td>
                                                        <td><?php echo $r['User_Name']; ?></td>
                                                        <td><?php echo $r['Req_Name']; ?></td>
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
<script type="text/javascript">
    $(document).ready(function() {
        /*stay in same tab after form submit*/
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){

            $('#myTab a[href="' + activeTab + '"]').tab('show');
        }
        /*stay in same tab after form submit*/
        $('#assigned_tasks').DataTable();
    });
    function with_in_8hours(id) {
        alert(id);


    }
</script>


