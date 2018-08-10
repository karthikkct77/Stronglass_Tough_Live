<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> Godown Inventry History</h1>

        </div>
    </div>
    <div class="row">
        <!-- view Stock Details -->
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Godown Inventry List</h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Stock Name</th>
                            <th>Current Quantity</th>
                            <th>Company Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($inventary as $key)
                        {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $key['Stock_Name']; ?><br>(<?php echo $key['Stock_Height']; ?>*<?php echo $key['Stock_Width']; ?>)</td>
                                <td><?php echo $key['Current_Qty']; ?></td>
                                <td><?php echo $key['Company_Name']; ?></td>
                                <td><?php echo $key['added_Date']; ?></td>
                                <td><button class="btn btn-info " onclick="view_reviced_stock('<?php echo $key['Stock_Icode']; ?> ')">View</button></td>
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
        <div class="col-md-6" id="View" style="display:none;">
            <div class="tile">
                <h3 class="tile-title">Stock History</h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable1">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Stock Name</th>
                            <th>Last Added Qty</th>
                            <th>Company Name</th>
                            <th>Vehicle No</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody id="result">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<style>
    .btn-info:active, .btn-info:focus{
        background-color: orangered!important;
        border-color: orangered!important;
    }
</style>
<script>$('#sampleTable').DataTable();</script>
<script>
    function view_reviced_stock (id) {
        $.ajax({
            url:"<?php echo site_url('Admin_Controller/View_Revice_Stock'); ?>",
            data: {id: id},
            type: "POST",
            cache: false,
            success:function(server_response){
                $("#View").show();
                $('#sampleTable1').DataTable();
                $("#result").html(server_response);
            }
        });
    }
</script>