<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
            <p>Stronglass Tough</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">

            <?php
            if($_SESSION['role'] == 5)
            {
                if($msg_count[0]['msg'] == '0')
                { ?>
                    <li><a style="color: red;" class="app-nav__item" href="<?php echo site_url('User_Controller/Get_All_Message');?>" ><i class="fa fa-bell-o fa-lg"></i></a></li>

                <?php  }
                else{ ?>
                    <li><a style="color: green;" class="app-nav__item" href="<?php echo site_url('User_Controller/Get_All_Message');?>"><span><?php echo $msg_count[0]['msg']; ?> </span><i class="fa fa-bell-o fa-lg"></i></a>

                    </li>

                <?php }
                ?>



            <?php   }
            elseif ($_SESSION['role'] == 10)
            {
                if($msg_count[0]['msg'] == '0')
                { ?>
                    <li><a style="color: red;" class="app-nav__item" href="<?php echo site_url('User_Controller/Get_All_Message');?>" ><i class="fa fa-bell-o fa-lg"></i></a></li>

                <?php  }
                else{ ?>
                    <li><a  style="color: red;" class="app-nav__item" href="<?php echo site_url('User_Controller/Get_All_Message');?>"><span><?php echo $msg_count[0]['msg']; ?> </span><i class="fa fa-bell-o fa-lg"></i></a>

                    </li>

                <?php }
                ?>

            <?php  }
            elseif ($_SESSION['role'] == 11)
            {       if($msg_count[0]['msg'] == '0')
            { ?>
                <li><a style="color: red;" class="app-nav__item" href="<?php echo site_url('User_Controller/Get_All_Message');?>" ><i class="fa fa-bell-o fa-lg"></i></a></li>

            <?php  }
            else{ ?>
                <li><a style="color: red;" class="app-nav__item" href="<?php echo site_url('User_Controller/Get_All_Message');?>"><span><?php echo $msg_count[0]['msg']; ?> </span><i class="fa fa-bell-o fa-lg"></i></a>

                </li>

            <?php }
                ?>

            <?php  } ?>

        </ul>
    </div>



    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                    <?php
                    if($_SESSION['role'] == 2)
                    { ?>
                        <h3 class="tile-title">Cutting Status</h3>
                        <div id="line_chart_cutting" style="width: 100%;"></div>

                    <?php   }
                    elseif ($_SESSION['role'] == 3)
                    { ?>
                        <h3 class="tile-title">Furnace Status</h3>
                        <div id="line_chart_furnace" style="width: 100%;"></div>

                    <?php  }
                    elseif ($_SESSION['role'] == 4)
                    { ?>
                        <h3 class="tile-title">Dispatch Status</h3>
                        <div id="line_chart_dispatch" style="width: 100%;"></div>


                    <?php  }
                    elseif ($_SESSION['role'] == 5)
                    { ?>
                        <h3 class="tile-title">Monthly Status</h3>
                        <div id="line_chart_Pi" style="width: 100%;"></div>
                        <h4>Todays PI Count:<span style="color: #00CC00;margin-left: 10px;font-size: 30px;"><?php echo $today_pi_count[0]['pi_count']; ?></span></h4>
                    <?php  }
                    elseif ($_SESSION['role'] == 6)
                    { ?>
                        <h3 class="tile-title">Generated WO</h3>
                        <div id="line_chart_WO" style="width: 100%;"></div>

                    <?php  }
                    elseif ($_SESSION['role'] == 7)
                    { ?>
                        <h3 class="tile-title">Completed PI</h3>
                        <div id="line_chart_Pi_confirm" style="width: 100%;"></div>


                    <?php  }
                    elseif ($_SESSION['role'] == 8)
                    { ?>
                        <div class="tile">
                            <h3 class="tile-title">Current Work Order Status</h3>
                            <table id="tblCustomers5"  data-page-length='25' class="table table-striped" width="100%">
                                <thead>
                                <tr>
                                    <th>Delay</th>
                                    <th>Within 8 hours</th>
                                    <th>Within 16 Hours</th>
                                    <th>Within 24 Hours</th>
                                    <th>Within 48 Hours</th>
                                    <!--                        <th></th>-->
                                </tr>
                                </thead>
                                <tbody>
                                <?php  foreach($status as $r)
                                { ?>
                                    <tr>
                                        <td><h2><a href="<?php echo site_url('User_Controller/Production_Dashboard'); ?>"><?php echo $r['delay']; ?></a></h2></td>
                                        <td><h2><a href="<?php echo site_url('User_Controller/Production_Dashboard'); ?>"><?php echo $r['within8']; ?></a></h2></td>
                                        <td><h2><a href="<?php echo site_url('User_Controller/Production_Dashboard'); ?>"><?php echo $r['within16']; ?></a></h2></td>
                                        <td><h2><a href="<?php echo site_url('User_Controller/Production_Dashboard'); ?>"><?php echo $r['within24']; ?></a></h2></td>
                                        <td><h2><a href="<?php echo site_url('User_Controller/Production_Dashboard'); ?>"><?php echo $r['within48']; ?></a></h2></td>
                                        <!--                        <td> <a class="btn btn-info" href="--><?php //echo site_url('Admin_Controller/Current_Status'); ?><!--">View Status</a></td>-->
                                    </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>


                    <?php  }
                    elseif ($_SESSION['role'] == 9)
                    { ?>
                        <p><b>Fabrication</b></p>

                    <?php  }

                    elseif ($_SESSION['role'] == 10)
                    { ?>
                        <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                            <div class="info">
                                <h4>Chennai Customers</h4>
                                <p><?php echo $customer[0]['counts']; ?></p>
                            </div>
                        </div>

                    <?php  }
                    elseif ($_SESSION['role'] == 11)
                    { ?>
                        <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                            <div class="info">
                                <h4>Kerala Customers</h4>
                                <p><?php echo $customer[0]['counts']; ?></p>
                            </div>
                        </div>

                    <?php  }
                    ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="tile">
                <?php
                if($_SESSION['role'] == 2)
                { ?>
                    <p><b>CUTTING</b></p>

                <?php   }
                elseif ($_SESSION['role'] == 3)
                { ?>
                    <p><b>FURNACE</b></p>

                <?php  }
                elseif ($_SESSION['role'] == 4)
                { ?>
                    <p><b>DISPATCH</b></p>

                <?php  }
                elseif ($_SESSION['role'] == 5)
                { ?>
<!--                    <div class="widget-small info coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>-->
<!--                        <div class="info">-->
<!--                            <h4><a href="--><?php //echo site_url('User_Controller/Proforma_Invoice'); ?><!--">Create PI</a></h4>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="widget-small warning coloured-icon"><i class="icon fa fa fa-eye fa-3x"></i>-->
<!--                        <div class="info">-->
<!--                            <h4><a href="--><?php //echo site_url('User_Controller/Invoice_List'); ?><!--">View PI</a></h4>-->
<!--                        </div>-->
<!--                    </div>-->


                <?php  }
                elseif ($_SESSION['role'] == 6)
                { ?>
                    <h3 class="tile-title">Review Status</h3>
                    <div class="widget-small info coloured-icon review_status"><i class="icon fa fa-play fa-3x"></i>
                        <div class="info">
                            <h4>Yet to Generate <span style="color: #00CC00;margin-left: 10px;font-size: 30px;"><?php echo $wo_generate[0]['Yet_to_generate']; ?></span></h4>
                        </div>
                    </div>
                    <div class="widget-small warning coloured-icon review_status"><i class="icon fa fa-files-o fa-3x"></i>
                        <div class="info">
                            <h4>Today Generated <span style="color: #00CC00;margin-left: 10px;font-size: 30px;"><?php echo $wo_generate[0]['Generated']; ?></span></h4>
                        </div>
                    </div>
                <?php  }
                elseif ($_SESSION['role'] == 7)
                { ?>
                    <h3 class="tile-title">Review Status</h3>
                    <div class="widget-small info coloured-icon review_status"><i class="icon fa fa-play fa-3x"></i>
                        <div class="info">
                            <h4>Yet to Review <span style="color: #00CC00;margin-left: 10px;font-size: 30px;"><a href="<?php echo site_url('User_Controller/Check_PI'); ?>"><?php echo $today_pi_check[0]['Yet_to_review']; ?></a></span></h4>
                        </div>
                    </div>
                    <div class="widget-small warning coloured-icon review_status"><i class="icon fa fa-files-o fa-3x"></i>
                        <div class="info">
                            <h4>In Review <span style="color: #00CC00;margin-left: 10px;font-size: 30px;"><a href="<?php echo site_url('User_Controller/Check_PI'); ?>"><?php echo $today_pi_check[0]['In_Review']; ?></a></span></h4>
                        </div>
                    </div>
                    <div class="widget-small primary coloured-icon review_status"><i class="icon fa fa-share fa-3x"></i>
                        <div class="info">
                            <h4>Sent to Customer <span style="color: #00CC00;margin-left: 10px;font-size: 30px;"><a href="<?php echo site_url('User_Controller/Check_PI'); ?>"><?php echo $today_pi_check[0]['SendEmail']; ?></a></span></h4>
                        </div>
                    </div>

                <?php  }
                elseif ($_SESSION['role'] == 10)
                { ?>


                <?php  }
                elseif ($_SESSION['role'] == 11)
                { ?>


                <?php  }
                ?>

            </div>
        </div>
    </div>

</main>
<style>
    .review_status{
        margin-bottom: 20px;
    }
    .review_status h4{
        text-transform: none!important;
    }
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    // Load the Visualization API and the line package.
    google.charts.load('current', {'packages':['line']});
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(pi_chart);
    google.charts.setOnLoadCallback(pi_chart_Confirm);
    google.charts.setOnLoadCallback(generated_wo);
    google.charts.setOnLoadCallback(cutting_chart);
    google.charts.setOnLoadCallback(furnace_chart);
    google.charts.setOnLoadCallback(dispatch_chart);




    function pi_chart() {

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('User_Controller/PI_Monthly_Chart'); ?>',

            success: function (data1) {

                // Create our data table out of JSON data loaded from server.
                var data = new google.visualization.DataTable();

                data.addColumn('string', 'Date');
                data.addColumn('number', 'pi');
                var jsonData = $.parseJSON(data1);
                //alert(jsonData);

                for (var i = 0; i < jsonData.length; i++) {
                    data.addRow([jsonData[i].Date, parseInt(jsonData[i].pi)]);
                }
                var options = {
                    chart: {
                        title: 'Invoice',
                        subtitle: ''
                    },

                    height: 300,
                    axes: {
                        x: {
                            0: {side: 'bottom'}
                        }
                    },
                    colors: ['#f39c12', '#f9325c']

                };
                var chart = new google.charts.Line(document.getElementById('line_chart_Pi'));
                chart.draw(data, options);
            }
        });
    }



    function pi_chart_Confirm() {

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('User_Controller/PI_Confirm_Monthly_Chart'); ?>',

            success: function (data1) {
                // Create our data table out of JSON data loaded from server.
                var data = new google.visualization.DataTable();

                data.addColumn('string', 'Date');
                data.addColumn('number', 'Complete_pi');
                var jsonData = $.parseJSON(data1);
                //alert(jsonData);

                for (var i = 0; i < jsonData.length; i++) {
                    data.addRow([jsonData[i].Date, parseInt(jsonData[i].Complete_pi)]);
                }
                var options = {
                    chart: {
                        title: 'Invoice',
                        subtitle: ''
                    },

                    height: 300,
                    axes: {
                        x: {
                            0: {side: 'bottom'}
                        }
                    },
                    colors: ['#16b72f', '#f9325c']

                };
                var chart = new google.charts.Line(document.getElementById('line_chart_Pi_confirm'));
                chart.draw(data, options);
            }
        });
    }

    function generated_wo() {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('User_Controller/Completed_WO'); ?>',

            success: function (data1) {
                // Create our data table out of JSON data loaded from server.
                var data = new google.visualization.DataTable();

                data.addColumn('string', 'Date');
                data.addColumn('number', 'Work_Order');
                var jsonData = $.parseJSON(data1);
                //alert(jsonData);

                for (var i = 0; i < jsonData.length; i++) {
                    data.addRow([jsonData[i].Date, parseInt(jsonData[i].Work_Order)]);
                }
                var options = {
                    chart: {
                        title: 'Generated WO',
                        subtitle: ''
                    },

                    height: 300,
                    axes: {
                        x: {
                            0: {side: 'bottom'}
                        }
                    },
                    colors: ['#16b72f', '#f9325c']

                };
                var chart = new google.charts.Line(document.getElementById('line_chart_WO'));
                chart.draw(data, options);
            }
        });
    }

    function cutting_chart() {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('User_Controller/Cutting_chart'); ?>',

            success: function (data1) {
                // Create our data table out of JSON data loaded from server.
                var data = new google.visualization.DataTable();

                data.addColumn('string', 'Date');
                data.addColumn('number', 'cutting');
                var jsonData = $.parseJSON(data1);
                //alert(jsonData);

                for (var i = 0; i < jsonData.length; i++) {
                    data.addRow([jsonData[i].Date, parseInt(jsonData[i].cutting)]);
                }
                var options = {
                    chart: {
                        title: 'Cutting',
                        subtitle: ''
                    },

                    height: 300,
                    axes: {
                        x: {
                            0: {side: 'bottom'}
                        }
                    },
                    colors: ['#16b72f', '#f9325c']

                };
                var chart = new google.charts.Line(document.getElementById('line_chart_cutting'));
                chart.draw(data, options);
            }
        });

    }

    function furnace_chart() {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('User_Controller/Furnace_chart'); ?>',

            success: function (data1) {
                // Create our data table out of JSON data loaded from server.
                var data = new google.visualization.DataTable();

                data.addColumn('string', 'Date');
                data.addColumn('number', 'furnace');
                var jsonData = $.parseJSON(data1);
                //alert(jsonData);

                for (var i = 0; i < jsonData.length; i++) {
                    data.addRow([jsonData[i].Date, parseInt(jsonData[i].furnace)]);
                }
                var options = {
                    chart: {
                        title: 'Cutting',
                        subtitle: ''
                    },

                    height: 300,
                    axes: {
                        x: {
                            0: {side: 'bottom'}
                        }
                    },
                    colors: ['#16b72f', '#f9325c']

                };
                var chart = new google.charts.Line(document.getElementById('line_chart_furnace'));
                chart.draw(data, options);
            }
        });
    }

    function dispatch_chart() {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('User_Controller/Dispatch_chart'); ?>',

            success: function (data1) {
                // Create our data table out of JSON data loaded from server.
                var data = new google.visualization.DataTable();

                data.addColumn('string', 'Date');
                data.addColumn('number', 'dispatch');
                var jsonData = $.parseJSON(data1);
                //alert(jsonData);

                for (var i = 0; i < jsonData.length; i++) {
                    data.addRow([jsonData[i].Date, parseInt(jsonData[i].dispatch)]);
                }
                var options = {
                    chart: {
                        title: 'Cutting',
                        subtitle: ''
                    },

                    height: 300,
                    axes: {
                        x: {
                            0: {side: 'bottom'}
                        }
                    },
                    colors: ['#16b72f', '#f9325c']

                };
                var chart = new google.charts.Line(document.getElementById('line_chart_dispatch'));
                chart.draw(data, options);
            }
        });
    }
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Work',     11],
            ['Eat',      2]
        ]);

        var options = {
            title: 'My Daily Activities',
            height: 300,
            axes: {
                x: {
                    0: {side: 'bottom'}
                }
            },

        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }


</script>



