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
                                <h4><?php echo $work_order[0]['WO_Date']; ?></h4>

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
                           <?php
                           if($_SESSION['role'] == 2)
                           {
                             ?>

                                <th>Balance Qty</th>
                          <?php }
                           elseif($_SESSION['role'] == 3)
                           { ?>
                               <th>Holes</th>
                               <th>Cutout</th>
                               <th>Colour</th>
                               <th>Other</th>
                               <th>Incoming Qty</th>
                               <th>Balance</th>
                          <?php } elseif($_SESSION['role'] == 4) {?>
                               <th>Holes</th>
                               <th>Cutout</th>
                               <th>Colour</th>
                               <th>Other</th>
                               <th>Incoming Qty</th>
                                <th>Balance Qty</th>
                            <?php } ?>
                            <th>Remaining Qty</th>
                            <th>Remaining Reason</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($work_order_desc as $val)
                        {
                            ?>

                            <tr>

                                <td><?php echo $i; ?>
                                    <input type="hidden" id="tot_qty<?php echo $val['WO_Process_Icode']; ?>" value="<?php echo $val['Total_Qty']; ?>">
                                    <input type="hidden" id="Fur_income<?php echo $val['WO_Process_Icode']; ?>" value="<?php echo $val['Furnace_Incoming']; ?>">
                                    <input type="hidden" id="dis_income<?php echo $val['WO_Process_Icode']; ?>" value="<?php echo $val['Dispatch_Incoming']; ?>"></td>
                                <td><?php echo $val['Material_Name']; ?></td>
                                <td><?php echo $val['Proforma_Actual_Size_Height']; ?></td>
                                <td><?php echo $val['Proforma_Actual_Size_Width']; ?></td>
                                <td><?php echo $val['Total_Qty']; ?></td>

                                <?php
                                if($_SESSION['role'] == 2)
                                {
                                    ?>
                                    <td><?php echo $val['Cutting_Remaining_Qty']; ?></td>
                                <?php }
                                elseif($_SESSION['role'] == 3)
                                { ?>
                                    <td><?php echo $val['Proforma_Holes']; ?></td>
                                    <td>cutout</td>
                                    <td><?php echo $val['Proforma_Special']; ?></td>
                                    <td>other</td>
                                    <td><?php echo $val['Furnace_Incoming']; ?></td>
                                    <td><?php echo $val['Furnace_Remaining_Qty']; ?></td>
                                <?php }
                                elseif($_SESSION['role'] == 4) {?>
                                    <td><?php echo $val['Proforma_Holes']; ?></td>
                                    <td>cutout</td>
                                    <td><?php echo $val['Proforma_Special']; ?></td>
                                    <td>other</td>
                                    <td><?php echo $val['Dispatch_Incoming']; ?> </td>
                                    <td><?php echo $val['Dispatch_Remaining_Qty']; ?></td>
                                <?php }?>

                                <td><input type="text" class="form-control" name="remain_qty" id="remain_qty<?php echo $val['WO_Process_Icode']; ?>" required min="0" onkeyup="change_qty('<?php echo $val['WO_Process_Icode']; ?>')"  ></td>
                                <td><select name="comments" class="form-control" id="comments<?php echo $val['WO_Process_Icode']; ?>">
                                        <option value="">Select Reason</option>
                                        <option value="Out_of_Stock">Out of Stock </option>
                                        <option value="optimize">optimize Issue</option>
                                        <option value="Handling">Handling Issue</option>
                                    </select></td>
                                <td><select name="status" class="form-control" id="status<?php echo $val['WO_Process_Icode']; ?>">
                                        <option value="">Select Status</option>
                                    </select></td>
                                <td>
                                    <?php if($_SESSION['role'] == 2)
                                    { ?>
                                        <button class="btn btn-success" onclick="Save_cutting_Status('<?php echo $val['WO_Process_Icode']; ?>')">Save</button>
                                        <input type="hidden" id="profoma_item_icode<?php echo $val['WO_Process_Icode']; ?>" value="<?php echo $val['Proforma_Invoice_Item_Icode']; ?>"
                                        ">
                                        <?php }
                                    elseif($_SESSION['role'] == 3)
                                    { ?>
                                        <button class="btn btn-success" onclick="Save_furnance_Status('<?php echo $val['WO_Process_Icode']; ?>')">Save</button>
                                        <input type="hidden" id="profoma_item_icode<?php echo $val['WO_Process_Icode']; ?>" value="<?php echo $val['Proforma_Invoice_Item_Icode']; ?>"
                                        ">
                                    <?php }
                                    elseif($_SESSION['role'] == 4) {?>

                                        <button class="btn btn-success" onclick="Save_Dispatch_Status('<?php echo $val['WO_Process_Icode']; ?>')">Save</button>
                                        <input type="hidden" id="profoma_item_icode<?php echo $val['WO_Process_Icode']; ?>" value="<?php echo $val['Proforma_Invoice_Item_Icode']; ?>"
                                        ">
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
        if (confirm("Do you want to Save ")) {
            var wo_icode = document.getElementById('wo_icode').value;
            var remaining_qty = document.getElementById('remain_qty' + id).value;
            var remaining_comments = document.getElementById('comments' + id).value;

            var profoma_item_icode = document.getElementById('profoma_item_icode' + id).value;
            var status = document.getElementById('status' + id).value;

            var total_qty = document.getElementById('tot_qty' + id).value;

            var furnace_income = document.getElementById('Fur_income' + id).value;
            var dispatch_income = document.getElementById('dis_income' + id).value;


            if (remaining_qty == "" ) {
                alert("Please Select Remaining qty and Status");
            }
            else if (remaining_qty != 0 && remaining_comments == "") {
                alert("Please Type Reason for Remaining Qty");
            }
            else if(remaining_qty > total_qty )
            {
                alert("Remaining QTY is Wrong");
            }
          else {
                $.ajax({
                    url: "<?php echo site_url('User_Controller/Save_WO_Item'); ?>",
                    data: {
                        Qty: remaining_qty,
                        Comments: remaining_comments,
                        Status: status,
                        Item_Icode: profoma_item_icode,
                        Wo_Icode: wo_icode,
                        Process_Icode: id,
                        Total_Qty: total_qty,
                        Furnace_Income: furnace_income,
                        Dispatch_Income: dispatch_income
                    },
                    type: "POST",
                    context: document.body,
                    success: function (data) {
                        if (data == 1) {
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
    }

    function Save_furnance_Status(id)
    {
        if (confirm("Do you want to Save ")) {
            var wo_icode = document.getElementById('wo_icode').value;
            var remaining_qty = document.getElementById('remain_qty' + id).value;
            var remaining_comments = document.getElementById('comments' + id).value;

            var profoma_item_icode = document.getElementById('profoma_item_icode' + id).value;
            var status = document.getElementById('status' + id).value;

            var total_qty = document.getElementById('tot_qty' + id).value;

            var furnace_income = document.getElementById('Fur_income' + id).value;
            var dispatch_income = document.getElementById('dis_income' + id).value;


            if (remaining_qty == "" ) {
                alert("Please Select Remaining qty and Status");
            }
            else if (remaining_qty != 0 && remaining_comments == "") {
                alert("Please Type Reason for Remaining Qty");
            }
            else if(remaining_qty > furnace_income )
            {
                alert("Remaining QTY is Wrong");
            }
            else {
                $.ajax({
                    url: "<?php echo site_url('User_Controller/Save_WO_Item'); ?>",
                    data: {
                        Qty: remaining_qty,
                        Comments: remaining_comments,
                        Status: status,
                        Item_Icode: profoma_item_icode,
                        Wo_Icode: wo_icode,
                        Process_Icode: id,
                        Total_Qty: total_qty,
                        Furnace_Income: furnace_income,
                        Dispatch_Income: dispatch_income
                    },
                    type: "POST",
                    context: document.body,
                    success: function (data) {
                        if (data == 1) {
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
    }
    function Save_Dispatch_Status(id)
    {
        if (confirm("Do you want to Save ")) {
            var wo_icode = document.getElementById('wo_icode').value;
            var remaining_qty = document.getElementById('remain_qty' + id).value;
            var remaining_comments = document.getElementById('comments' + id).value;

            var profoma_item_icode = document.getElementById('profoma_item_icode' + id).value;
            var status = document.getElementById('status' + id).value;

            var total_qty = document.getElementById('tot_qty' + id).value;

            var furnace_income = document.getElementById('Fur_income' + id).value;
            var dispatch_income = document.getElementById('dis_income' + id).value;


            if (remaining_qty == "" ) {
                alert("Please Select Remaining qty and Status");
            }
            else if (remaining_qty != 0 && remaining_comments == "") {
                alert("Please Type Reason for Remaining Qty");
            }
            else if(remaining_qty > dispatch_income )
            {
                alert("Remaining QTY is Wrong");
            }
            else {
                $.ajax({
                    url: "<?php echo site_url('User_Controller/Save_WO_Item'); ?>",
                    data: {
                        Qty: remaining_qty,
                        Comments: remaining_comments,
                        Status: status,
                        Item_Icode: profoma_item_icode,
                        Wo_Icode: wo_icode,
                        Process_Icode: id,
                        Total_Qty: total_qty,
                        Furnace_Income: furnace_income,
                        Dispatch_Income: dispatch_income
                    },
                    type: "POST",
                    context: document.body,
                    success: function (data) {
                        if (data == 1) {
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
    }

    function change_qty(id) {
        var remaining_qty = document.getElementById('remain_qty' + id).value;
        var total_qty = document.getElementById('tot_qty' + id).value;
        if (!/^[0-9]+$/.test(remaining_qty))
        {
            alert("Please enter onyl number.");

        }

        if(remaining_qty == 0)
        {
            $('#status'+id)
                .empty()
                .append('<option selected="selected" value="3">Fully Completed</option>');
            $('#comments'+id).prop('disabled', true);
        }
      else
        {
            $('#status'+id)
                .empty()
                .append('<option selected="selected" value="2">Completed with Remaining</option>');
            $('#comments'+id).prop('disabled', false);
        }
       if(total_qty < remaining_qty )
        {
            alert("Remaining QTY is Wrong..");
        }

    }

</script>
