<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> Work Order List</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Work Order</a></li>
        </ul>
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
        <style>
            .wo_right{
                background: #ccc;
                text-align: center;
                margin-bottom: 20px;
            }
            .wo_top{
                margin-bottom: 20px;
            }
            .wo_top h4{
                margin-bottom: 0;

                padding: 10px 0;
            }
        </style>
        <!-- view Stock Details -->
        <div class="col-md-12">
            <div class="tile">
                <!--         <h3 class="tile-title">Work Order List</h3>-->
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Work Order NO</th>
                            <th>Thickness</th>
                            <th>Height</th>
                            <th>Width</th>
                            <th>Qty</th>
                            <?php
                            if($_SESSION['role'] == 2)
                            {
                                ?>

                            <?php }
                            elseif($_SESSION['role'] == 3)
                            { ?>
                                <th>Holes</th>
                                <th>Cutout</th>
                                <th>Colour</th>
                            <?php } elseif($_SESSION['role'] == 4) {?>
                                <th>Holes</th>
                                <th>Cutout</th>
                                <th>Colour</th>
                            <?php } ?>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($Recut as $val)
                        {
                            ?>

                            <tr>

                                <td><?php echo $i; ?>
                                    <input type="hidden" id="Work_Order<?php echo $val['Recut_Icode']; ?>" value="<?php echo $val['Work_Order_Icode']; ?>">
                                <td><?php echo $val['WO_Number']; ?></td>
                                <td><?php echo $val['Material_Name']; ?></td>
                                <td><?php echo $val['Proforma_Actual_Size_Height']; ?></td>
                                <td><?php echo $val['Proforma_Actual_Size_Width']; ?></td>
                                <td><?php echo $val['Recut_Qty']; ?></td>

                                <?php
                                if($_SESSION['role'] == 2)
                                {
                                    ?>
                                <?php }
                                elseif($_SESSION['role'] == 3)
                                { ?>
                                    <td><?php echo $val['Proforma_Holes']; ?></td>
                                    <td><?php echo $val['Proforma_Cutout']; ?></td>
                                    <td><?php echo $val['Proforma_Special']; ?></td>
                                <?php }
                                elseif($_SESSION['role'] == 4) {?>
                                    <td><?php echo $val['Proforma_Holes']; ?></td>
                                    <td><?php echo $val['Proforma_Cutout']; ?><</td>
                                    <td><?php echo $val['Proforma_Special']; ?></td>
                                        <?php }?>
                                <td>
                                    <?php if($_SESSION['role'] == 2)
                                    { ?>

                                        <button class="btn btn-success" onclick="Save_cutting_Status('<?php echo $val['Recut_Icode']; ?>')">Save</button>
                                    <?php }
                                    elseif($_SESSION['role'] == 3)
                                    { ?>
                                        <button class="btn btn-success" onclick="Save_furnance_Status('<?php echo $val['Recut_Icode']; ?>')">Save</button>

                                    <?php }
                                    elseif($_SESSION['role'] == 4) {?>
                                        <button class="btn btn-success" onclick="Save_Dispatch_Status('<?php echo $val['Recut_Icode']; ?>')">Save</button>

                                    <?php }?>

                                </td>
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
    function Save_cutting_Status(id)
    {
     var work_order = document.getElementById('Work_Order'+id).value;
        if (confirm("Do you want to Save ")) {
                $.ajax({
                    url: "<?php echo site_url('User_Controller/Save_Recut_Item'); ?>",
                    data: {
                        Recut_Icode: id,
                        Work_Oder: work_order,
                        Type: 'Cutting'
                    },
                    type: "POST",
                    context: document.body,
                    success: function (data) {
                        if (data == '1') {
                            swal({
                                    title: "Success!",
                                    text: "Data Saved..",
                                    type: "success"
                                },
                                function () {
                                    location.reload();
                                });
                        }
                    }
                });
            }
        }
    function Save_furnance_Status(id)
    {
        var work_order = document.getElementById('Work_Order'+id).value;
        if (confirm("Do you want to Save ")) {
            $.ajax({
                url: "<?php echo site_url('User_Controller/Save_Recut_Item'); ?>",
                data: {
                    Recut_Icode: id,
                    Work_Oder: work_order,
                    Type: 'Furnace'
                },
                type: "POST",
                context: document.body,
                success: function (data) {
                    if (data == '1') {
                        swal({
                                title: "Success!",
                                text: "Data Saved..",
                                type: "success"
                            },
                            function () {
                                location.reload();
                            });
                    }
                }
            });
        }
    }
    function Save_Dispatch_Status(id)
    {
        var work_order = document.getElementById('Work_Order'+id).value;
        if (confirm("Do you want to Save ")) {
            $.ajax({
                url: "<?php echo site_url('User_Controller/Save_Recut_Item'); ?>",
                data: {
                    Recut_Icode: id,
                    Work_Oder: work_order,
                    Type: 'Dispatch'
                },
                type: "POST",
                context: document.body,
                success: function (data) {
                    if (data == '1') {
                        swal({
                                title: "Success!",
                                text: "Data Saved..",
                                type: "success"
                            },
                            function () {
                                location.reload();
                            });
                    }
                }
            });
        }
    }
</script>
