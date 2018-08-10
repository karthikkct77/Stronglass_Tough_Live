<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Stock Master</h1>
        </div>
    </div>
    <div class="row">
        <?php if($this->session->flashdata('feedback')): ?>
            <script>
                var ssd = "<?php echo $this->session->flashdata('feedback'); ?>";
                swal({
                        title: "Success!",
                        text: ssd,
                        type: "success"
                    },
                    function(){
                        location.reload();
                    });
            </script>
        <?php endif; ?>

        <?php if($this->session->flashdata('feedback1')): ?>
            <script>
                var ssd = "<?php echo $this->session->flashdata('feedback1'); ?>";
                swal({
                        title: "Error!",
                        text: ssd,
                        type: "warning"
                    },
                    function(){
                        location.reload();
                    });
            </script>
        <?php endif; ?>

        <div class="col-md-6" id="add">
            <div class="tile">
                <h3 class="tile-title">Add New Stock</h3>
                <div class="tile-body">
                    <form method="post" class="login-form" action="<?php echo site_url('Admin_Controller/Insert_Stock'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Save?');">
                        <div class="form-group">
                            <label class="control-label">Material Name</label>
                            <input class="form-control" type="text" name="stock_name" placeholder="Enter stock name" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Height</label>
                            <input class="form-control" type="number" name="stock_height"  placeholder="Enter Height" min="0"  >
                        </div>
                        <div class="form-group">
                            <label class="control-label">Width</label>
                            <input class="form-control" type="number" name="stock_width" placeholder="Enter Width" min="0"  required>
                        </div>
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>&nbsp;
                    </form>
                </div>
            </div>
        </div>

        <!-- Update  Details -->
        <div class="col-md-6" id="update" style="display: none">
            <div class="tile">
                <h3 class="tile-title pull-left">Edit Stock</h3>
                <div class="tile-body">
                    <form method="post" class="login-form" action="<?php echo site_url('Admin_Controller/Update_Stock'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Update The Material Datas?');">
                        <div class="form-group">
                            <label class="control-label">Material Name</label>
                            <input class="form-control" type="text" name="material_name" id="material" readonly required>
                            <input type="hidden" name="Stock_icode" id="Stock_icode">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Material Height</label>
                            <input class="form-control" type="number" name="material_height" id="material_height"  min="0" step="1" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Material Width</label>
                            <input class="form-control" type="number" name="material_width" id="material_width"   min="0" step="1" required>
                        </div>
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>&nbsp;
                        <button class="btn btn-danger" type="button" onClick="window.location.reload();">Close</button>
                    </form>

                </div>
            </div>
        </div>
        <!-- view Stock Details -->
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title ">View Stock List</h3>
<!--                <a class="btn btn-success pull-right" href="--><?php //echo site_url('Admin_Controller/Revice_History'); ?><!--">Revising History</a>-->
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Stock Name</th>
                            <th>Stock Height</th>
                            <th>Stock Width</th>
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
                                <td><?php echo $val['Stock_Name']; ?></td>
                                <td><?php echo $val['Stock_Height']; ?></td>
                                <td><?php echo $val['Stock_Width']; ?></td>
                                <td><button class="btn btn-info" onclick="edit_material('<?php echo $val['Stock_Icode']; ?> ')">Edit</button></td>
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
</main>
<script>$('#sampleTable').DataTable();</script>
<script>
    function edit_material (id) {
        $.ajax({
            url:"<?php echo site_url('Admin_Controller/Edit_Stock'); ?>",
            data: {id: id},
            type: "POST",
            cache: false,
            success:function(server_response){
                $("#update").show();
                $("#add").hide();
                var data = $.parseJSON(server_response);
                var charges_name = data[0]['Stock_Name'];
                document.getElementById('material').value = charges_name;
                var height = data[0]['Stock_Height'];
                document.getElementById('material_height').value = height;
                var width =data[0]['Stock_Width'];
                document.getElementById('material_width').value = width;
                var stock_id =data[0]['Stock_Icode'];
                document.getElementById('Stock_icode').value = stock_id;
            }
        });
    }
</script>