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
                    <div class="row wo_top">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3">
                                    <h4>Ref No </h4>
                                </div>
                                <div class="col-md-3 wo_right">
                                    <h4>123</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3">
                                    <h4>PI NO </h4>
                                </div>
                                <div class="col-md-3 wo_right">
                                    <h4><?php echo $work_order[0]['Proforma_Number']; ?></h4>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3">
                                    <h4>Work Order No</h4>

                                </div>
                                <div class="col-md-3 wo_right">
                                    <h4><?php echo $work_order[0]['WO_Number']; ?></h4>

                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="wo_icode" id="wo_icode" value="<?php echo $work_order[0]['WO_Icode']; ?>">

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3">
                                    <h4>Work Order Date</h4>

                                </div>
                                <div class="col-md-3 wo_right">
                                    <h4><?php echo $work_order[0]['WO_Confirm_Date']; ?></h4>

                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Thickness</th>
                            <th>Height</th>
                            <th>Width</th>
                            <th>Qty</th>
                            <th>Holes</th>
                            <th>Cutout</th>
                            <th>Colour</th>
                            <th>Other</th>
                            <th>Cutting Remaining Qty</th>
                            <th>Cutting Status</th>
                             <th>Furnance Remaining Qty</th>
                            <th>Furnace Status</th>
                            <th>Dispatch Remaining Qty</th>
                            <th>Dispatch Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($work_order_desc as $val)
                        {
                            ?>

                            <tr>

                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['Material_Name']; ?></td>
                                <td><?php echo $val['Proforma_Actual_Size_Height']; ?></td>
                                <td><?php echo $val['Proforma_Actual_Size_Width']; ?></td>
                                <td><?php echo $val['Total_Qty']; ?></td>
                                <td><?php echo $val['Proforma_Holes']; ?></td>
                                <td></td>
                                <td><?php echo $val['Proforma_Special']; ?></td>
                                <td></td>
                                <td><?php echo $val['Cutting_Remaining_Qty']; ?></td>
                                <?php if($val['Cutting_Status'] == '3') {?>
                                <td>Completed</td>
                                <?php } else {?> <td>Pending</td> <?php }
                                $total = $val['Furnace_Remaining_Qty'] + $val['Furnace_Incoming'];
                                ?>
                                <td><?php echo $total; ?></td>
                                <?php if($val['Furnace_Status'] == '3') {?>
                                    <td>Completed</td>
                                <?php } else {?> <td>Pending</td> <?php }
                                $total_dispatch = $val['Dispatch_Incoming'] + $val['Dispatch_Remaining_Qty'];
                                ?>
                                <td><?php echo $total_dispatch; ?></td>
                                <?php if($val['Dispatch_Status'] == '3') {?>
                                    <td>Completed</td>
                                <?php } else {?> <td>Pending</td> <?php } ?>


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
    function Save_Status(id)
    {
        var wo_icode = document.getElementById('wo_icode').value;
        var remaining_qty = document.getElementById('remain_qty'+id).value;
        var remaining_comments = document.getElementById('comments'+id).value;
        var status = document.getElementById('status'+id).value;
        var profoma_item_icode = document.getElementById('profoma_item_icode'+id).value;
        if(remaining_qty =="" || status =="")
        {
            alert("Please Select Remaining qty and Status");
        }
        else if(remaining_qty != 0 && remaining_comments == "" )
        {
            alert("Please Type Reason for Remaining Qty");
        }
        else
        {
            $.ajax({ url: "<?php echo site_url('User_Controller/Save_WO_Item'); ?>",
                data: {Qty: remaining_qty,Comments: remaining_comments, Status: status, Item_Icode: profoma_item_icode, Wo_Icode: wo_icode, Process_Icode: id   },
                type: "POST",
                context: document.body,
                success: function(data){
                    if(data == 1)
                    {
                        swal({
                                title: "Success!",
                                text: "Data Saved..",
                                type: "success"
                            },
                            function(){
                                location.reload();
                            });

                    }
                }});
        }
    }

</script>
