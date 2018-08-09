<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> Godown Inventry Inward History</h1>

        </div>
    </div>
    <div class="row">
        <!-- view Stock Details -->
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">By Date Range</h3>
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>From Date</label>
                                <input class="form-control" id="demoDate" name="from_date" type="text" placeholder="From Date">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>To Date</label>
                                <input  class="form-control"  type="text" name="to_date"   data-date-format="yyyy-mm-dd" id="todate" placeholder="To Date" required>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="button" class="btn btn-success"  onclick="search_inventry()" >Search</button>
                                <button type="button" class="btn btn-danger"  onclick="refresh()" >Reset</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div id="old">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Stock Name</th>
                                <th>Counts</th>
                                <th>Company Name</th>
                                <th>Vehicle NO</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1;
                            foreach ($inventary as $val)
                            {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $val['Stock_Name']; ?><br>(<?php echo $val['Stock_Height']; ?> * <?php echo $val['Stock_Width']; ?> ) </td>
                                    <td><?php echo $val['Current_Qty']; ?></td>
                                    <td><?php echo $val['Company_Name']; ?></td>
                                    <td><?php echo $val['Vehicle_No']; ?></td>
                                    <td><?php echo $val['Created_On']; ?></td>
                                    <!--                                <td>--><?php //echo Date('Y-m-d',strtotime($val['Material_Qty_Last_Added_Date'])); ?><!--</td>-->
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="search" style="display: none">
                        <table class="table table-hover table-bordered" id="sampleTable1" >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Material Name</th>
                                <th>Counts</th>
                            </tr>
                            </thead>
                            <tbody id="result_count">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
<script>$('#sampleTable').DataTable();</script>
<script type="text/javascript">
    $('#demoDate').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true
    });
    $('#todate').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true
    });
    $('#demoDate1').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true
    });
    $('#todate1').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true
    });

</script>
<script>
    function view_reviced_charges (id) {
        $.ajax({
            url:"<?php echo site_url('Admin_Controller/View_Charges_Revice_History'); ?>",
            data: {id: id},
            type: "POST",
            cache: false,
            success:function(server_response){
                $("#View").show();
                $("#result").html(server_response);
            }
        });
    }
    function search_inventry()
    {
        var start_date = $('#demoDate').val();
        var end_date = $('#todate').val();
        $(document).ready(function(){
            $.ajax({ url: "<?php echo site_url('Admin_Controller/Get_Date_Godown_inventry_history'); ?>",
                data: {from_date: start_date,to_date: end_date},
                type: "POST",
                context: document.body,
                success: function(data){
                    $("#old").hide();
                    $("#search").show();
                    $("#result_count").html(data);
                    $('#sampleTable1').dataTable();
                }});
        });
    }
    function refresh() {
        location.reload();
    }
    function search_material() {
        var start_date = $('#demoDate1').val();
        var end_date = $('#todate1').val();
        var material =$('#material').val();

        $.ajax({ url: "<?php echo site_url('Admin_Controller/Get_Material_inventry_history'); ?>",
            data: {from_date: start_date,to_date: end_date, Material: material },
            type: "POST",
            context: document.body,
            success: function(data){
                $("#result_material").html(data);
                $('#sampleTable3').dataTable();
            }});



    }
</script>