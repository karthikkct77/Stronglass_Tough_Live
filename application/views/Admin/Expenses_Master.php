<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Expenses Master</h1>
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
                <h3 class="tile-title">Add New Expenses</h3>
                <div class="tile-body">
                    <form method="post" class="login-form" action="<?php echo site_url('Admin_Controller/Insert_Expenses'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Save?');">
                        <div class="form-group">
                            <label class="control-label">Expenses Name</label>
                            <input class="form-control" type="text" name="expenses_name" placeholder="Enter Expenses name" required>
                        </div>
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>&nbsp;
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title ">View Expenses List</h3>
                <!--                <a class="btn btn-success pull-right" href="--><?php //echo site_url('Admin_Controller/Revice_History'); ?><!--">Revising History</a>-->
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Expenses Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($expenses as $val)
                        {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['Expenses_Name']; ?></td>
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