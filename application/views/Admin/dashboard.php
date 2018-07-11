<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
            <p>stronglass tough</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
    </div>
<!--    <div class="row">-->
<!--        <div class="col-md-6 col-lg-3">-->
<!--            <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>-->
<!--                <div class="info">-->
<!--                    <h4>Users</h4>-->
<!--                    <p><b>5</b></p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-md-6 col-lg-3">-->
<!--            <div class="widget-small info coloured-icon"><i class="icon fa fa-thumbs-o-up fa-3x"></i>-->
<!--                <div class="info">-->
<!--                    <h4>Likes</h4>-->
<!--                    <p><b>25</b></p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-md-6 col-lg-3">-->
<!--            <div class="widget-small warning coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>-->
<!--                <div class="info">-->
<!--                    <h4>Uploades</h4>-->
<!--                    <p><b>10</b></p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-md-6 col-lg-3">-->
<!--            <div class="widget-small danger coloured-icon"><i class="icon fa fa-star fa-3x"></i>-->
<!--                <div class="info">-->
<!--                    <h4>Stars</h4>-->
<!--                    <p><b>500</b></p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <div class="row">
        <div class="col-md-6">
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
                        <td><h2><a href="<?php echo site_url('Admin_Controller/Current_Status'); ?>"><?php echo $r['delay']; ?></a></h2></td>
                        <td><h2><a href="<?php echo site_url('Admin_Controller/Current_Status'); ?>"><?php echo $r['within8']; ?></a></h2></td>
                        <td><h2><a href="<?php echo site_url('Admin_Controller/Current_Status'); ?>"><?php echo $r['within16']; ?></a></h2></td>
                        <td><h2><a href="<?php echo site_url('Admin_Controller/Current_Status'); ?>"><?php echo $r['within24']; ?></a></h2></td>
                        <td><h2><a href="<?php echo site_url('Admin_Controller/Current_Status'); ?>"><?php echo $r['within48']; ?></a></h2></td>
<!--                        <td> <a class="btn btn-info" href="--><?php //echo site_url('Admin_Controller/Current_Status'); ?><!--">View Status</a></td>-->
                    </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Today Status</h3>
                <table id="tblCustomers5"  data-page-length='25' class="table table-striped" width="100%">
                    <thead>
                    <tr>
                        <th>Generate PI</th>
                        <th>Confirm PI</th>
                        <th>Generate WO</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php  foreach($todays_pi as $r)
                    { ?>
                        <tr>
                            <td><h2><?php echo $r['pi']; ?></h2></td>
                            <td><h2><?php echo $r['pi_confirm']; ?></h2></td>
                            <td><h2><?php echo $r['wo_confirm']; ?></h2></td>

                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Monthly WO Complete Status</h3>
                <div id="line_chart_Pi" style="width: 100%;"></div>
            </div>
        </div>

    </div>


</main>

<script>
    $(document).ready(function() {
    $.ajax({
        url:"<?php echo site_url('Admin_Controller/WO_Result'); ?>",
        data: {},
        type: "POST",
        cache: false,
        success:function(server_response){
            $("#update").show();
            $("#add").hide();
            var data = $.parseJSON(server_response);
            var charges_name = data[0]['charge_name'];
            document.getElementById('charge').value = charges_name;
            var price = data[0]['charge_current_price'];
            document.getElementById('price').value = price;
            var icode =data[0]['charge_icode'];
            document.getElementById('charges_icode').value = icode;
        }
    });
    });

</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    // Load the Visualization API and the line package.
    google.charts.load('current', {'packages':['line']});
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(pi_chart);
    google.charts.setOnLoadCallback(pi_chart_Confirm);
    google.charts.setOnLoadCallback(generated_wo);

    function pi_chart() {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('Admin_Controller/WO_Monthly_Chart'); ?>',

            success: function (data1) {

                // Create our data table out of JSON data loaded from server.
                var data = new google.visualization.DataTable();

                data.addColumn('string', 'months');
                data.addColumn('number', 'wo');
                var jsonData = $.parseJSON(data1);
                //alert(jsonData);

                for (var i = 0; i < jsonData.length; i++) {
                    data.addRow([jsonData[i].months, parseInt(jsonData[i].wo)]);
                }
                var options = {
                    chart: {
                        title: 'WO Completed',
                        subtitle: ''
                    },

                    height: 300,
                    axes: {
                        x: {
                            0: {side: 'bottom'}
                        }
                    },
                    colors: ['#f34f37', '#f9325c']

                };
                var chart = new google.charts.Line(document.getElementById('line_chart_Pi'));
                chart.draw(data, options);
            }
        });
    }
</script>
