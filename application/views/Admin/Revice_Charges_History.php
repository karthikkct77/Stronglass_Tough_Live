<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> Charges Revice History List</h1>

        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?php echo site_url('Admin_Controller/Charges_Entry'); ?>">Charges Entry</a></li>
            <li class="breadcrumb-item"><a href="#">Charges Revice History</a></li>
        </ul>
    </div>
    <div class="row">
        <!-- view Stock Details -->
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Charges List</h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Charges Name</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($charges as $val)
                        {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['charge_name']; ?></td>
                                <td><?php echo $val['charge_current_price']; ?></td>
                                <td><button class="btn btn-info" onclick="view_reviced_charges('<?php echo $val['charge_icode']; ?> ')">View</button></td>
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
                <h3 class="tile-title">Changed Price List</h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Charges old Price</th>
                            <th>Updated ON</th>
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
<script>$('#sampleTable').DataTable();</script>
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
</script>