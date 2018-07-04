<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
            <p>Stronglass Tough</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                    <h4><?php echo("{$_SESSION['user_name']}"."<br />");?></h4>
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
                        <p><b>DATA ENTRY</b></p>

                    <?php  }
                    elseif ($_SESSION['role'] == 6)
                    { ?>
                        <p><b>WO ENTRY</b></p>

                    <?php  }
                    elseif ($_SESSION['role'] == 7)
                    { ?>
                        <p><b>Review/Confirm PI</b></p>

                    <?php  }
                    ?>


                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small info coloured-icon"><i class="icon fa fa-thumbs-o-up fa-3x"></i>
                <div class="info">
                    <h4>Likes</h4>
                    <p><b>25</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
                <div class="info">
                    <h4>Uploades</h4>
                    <p><b>10</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small danger coloured-icon"><i class="icon fa fa-star fa-3x"></i>
                <div class="info">
                    <h4>Stars</h4>
                    <p><b>500</b></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Monthly Status</h3>
                <div class="embed-responsive embed-responsive-16by9">
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
                        <div id="line_chart_Pi"></div>

                    <?php  }
                    elseif ($_SESSION['role'] == 6)
                    { ?>
                        <p><b>WO ENTRY</b></p>

                    <?php  }
                    elseif ($_SESSION['role'] == 7)
                    { ?>
                        <p><b>Review/Confirm PI</b></p>

                    <?php  }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Support Requests</h3>
                <div class="embed-responsive embed-responsive-16by9">
                    <canvas class="embed-responsive-item" id="pieChartDemo"></canvas>
                </div>
            </div>
        </div>
    </div>

</main>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    // Load the Visualization API and the line package.
    google.charts.load('current', {'packages':['line']});
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(pi_chart);
    google.charts.setOnLoadCallback(drawChart1);
    google.charts.setOnLoadCallback(drawChart_hit_rate);


    function pi_chart() {

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('User_Controller/PI_Monthly_Chart'); ?>',

            success: function (data1) {
                // Create our data table out of JSON data loaded from server.
                var data = new google.visualization.DataTable();

                data.addColumn('string', 'Date');
                data.addColumn('number', 'warm');
                data.addColumn('number', 'hot');

                var jsonData = $.parseJSON(data1);

                //alert(jsonData);

                for (var i = 0; i < jsonData.length; i++) {
                    data.addRow([jsonData[i].Date, parseInt(jsonData[i].warm), parseInt(jsonData[i].hot)]);
                }
                var options = {
                    chart: {
                        title: 'Warm/Hot Calls',
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
                var chart = new google.charts.Line(document.getElementById('line_chart1'));
                chart.draw(data, options);
            }
        });
    }
</script>

