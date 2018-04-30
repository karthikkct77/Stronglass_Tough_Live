<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> Material Revice History List</h1>

        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Master Entry</li>
            <li class="breadcrumb-item"><a href="#">Material Revice History</a></li>
        </ul>
    </div>
    <div class="row">
        <!-- view Stock Details -->
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Material List</h3>
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Stock Name</th>
                            <th>Stock Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($stock as $val)
                        {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['Material_Name']; ?></td>
                                <td><?php echo $val['Material_Current_Price']; ?></td>
                                <td><button class="btn btn-info" onclick="view_reviced_material('<?php echo $val['Material_Icode']; ?> ')">View</button></td>
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
            <table class="table table-hover table-bordered" id="sampleTable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Material Old Price</th>
                    <th>Material Changed Price</th>
                    <th>Updated ON</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td id="old_prices"></td>
                        <td id="prices"></td>
                        <td id="rdate"></td>
                    </tr>
                    <?php
                    $i++;
                ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<script>$('#sampleTable').DataTable();</script>
<script>
    function view_reviced_material (id) {
        $.ajax({
            url:"<?php echo site_url('Admin_Controller/View_Material_Revice_History'); ?>",
            data: {id: id},
            type: "POST",
            cache: false,
            success:function(server_response){
                $("#View").show();
                var data = $.parseJSON(server_response);
                var old_price = data[0]['Material_Old_Price'];
                document.getElementById('old_prices').innerHTML = old_price;
                var price = data[0]['prices'];
                document.getElementById('price').innerHTML = price;
                var icode =data[0]['Material_Icode'];
                document.getElementById('material_icode').innerHTML = icode;
                var rdate = data[0]['Material_Price_Updated_On'];
                document.getElementById('rdate').innerHTML = rdate;
            }
        });
    }
</script>