<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Factory Outwards</h1>
        </div>
    </div>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link " href="<?php echo site_url('Admin_Controller/Factory_Stock'); ?>">Current Stocks </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" id="pills-profile-tab" href="<?php echo site_url('Admin_Controller/Factory_Outwords'); ?>">Factory Outwards</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-md-6" id="add">
            <div class="tile">
                <?php if($this->session->flashdata('message')){?>
                    <div class="alert alert-success">
                        <?php echo $this->session->flashdata('message')?>
                    </div>
                <?php } ?>
                <h3 class="tile-title">Factory Outward Inventory</h3>
                <div class="tile-body">
                    <form method="post" enctype="multipart/form-data" class="login-form" action="<?php echo site_url('Admin_Controller/Save_Factory_Outward'); ?>" name="data_register">
                        <table class="table  table-bordered" id="sampleTable1" border="2">
                            <thead>
                            <tr>
                                <th>Select Meterial</th>
                                <th>Current<br>qty</th>
                                <th>Out<br>qty</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <select name="material[]" class="form-control" id="material"  >
                                            <option value="" >Select material</option>
                                            <?php foreach ($factory_outword as $row):
                                            {
                                                echo '<option value= "'.$row['Stock_Icode'].'">' . $row['Stock_Name'] . '(' .$row['Stock_Height']. '*' .$row['Stock_Width']. ')'.'</option>';
                                            }
                                            endforeach; ?>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <input  class="form-control" type="text" id="current_qty" readonly>
                                </td>
                                <td>
                                    <input class="form-control" type="number" name="new_qty[]" id="qty"  placeholder="Enter qty" min="0" step="1" required>
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="total_qty[]" id="total_qty"  readonly>
                                </td>
                                <td><input type="button" onclick="Add_one()" value="Add" id="Add" /></td>
                            </tr>
                            </tfoot>
                        </table>
                        <button class="btn btn-danger" type="submit" ><i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>&nbsp;
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="tile">  <h3 class="tile-title">Factory Outword List</h3>
<!--                <a class="btn btn-success pull-right" href="--><?php //echo site_url('Admin_Controller/Godown_Inward_History'); ?><!--">Inward History</a>-->
                <div class="tile-body">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Stock Name</th>
                            <th>Out Quantity</th>
                            <th>Date</th>
<!--                            <th></th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=1;
                        foreach ($factory_outword_details as $key)
                        {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $key['Stock_Name']; ?><br>(<?php echo $key['Stock_Height']; ?>*<?php echo $key['Stock_Width']; ?>)</td>
                                <td><?php echo $key['Stock_Out_Qty']; ?></td>
                                <td><?php echo $key['Stock_Getting_On']; ?></td>
<!--                                <td>-->
<!--                                     <a class="btn btn-success pull-right" href="--><?php //echo site_url('Admin_Controller/Factory_outword_Stock_History/') .$key['Stock_Icode']; ?><!--">View</a>-->
<!--                                </td>-->

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
    </div>
    </div>
</main>
<script>
    $('#sampleTable').DataTable();
    $("#material").change(function () {
        $.ajax({
            url:"<?php echo site_url('Admin_Controller/get_factory_stock_quantity'); ?>",
            data: {id:
                $(this).val()},
            type: "POST",
            success:function(server_response){
                var data = $.parseJSON(server_response);

                if (data.length === 0) {
                    document.getElementById('current_qty').value = 0;
                }
                else
                {
                    var  qty = data[0]['Current_Qty'];
                    document.getElementById('current_qty').value = qty;

                }
            }
        });
    });

    $("#qty").on('change keyup paste', function() {
        var qty = parseInt($(this).val());
        var current_qty = parseInt($('#current_qty').val());

        if(current_qty < qty)
        {
            alert("Out QTY greater then Current QTY");
        }
        else
        {
            var total =  parseInt(current_qty) - parseInt(qty);
            document.getElementById('total_qty').value = total;
        }
    });

    $("#Add").click(function () {

        if($('#material').val() == "")
        {
            alert("Please Select Material...");
        }
        else if($('#qty').val() == ""){
            alert("Please enter additional quantity...");
        }
        else if($('#company_name').val() == ""){
            alert("Please enter Comapny Name...");
        }
        else if($('#vehicle_no').val() == ""){
            alert("Please enter Vehicle NO...");
        }
        else
        {
            var stocks = $("#material option:selected").text();
            AddRow($('#material').val(), $("#current_qty").val(),$("#qty").val(),$("#total_qty").val(),stocks);
            $("#material").val("");
            $("#current_qty").val("");
            $("#qty").val("");
            $("#total_qty").val("");
        }
    });

    function AddRow(material,current_qty,newqty,total_qty,stocks) {

        var tBody = $("#sampleTable1 > TBODY")[0];
        //Add Row.
        row = tBody.insertRow(-1);
        //Add Name cell.
        var cell = $(row.insertCell(-1));
        var stock = $("<input />");
        stock.attr("type", "hidden");
        stock.attr("name", "material[]");
        stock.val(material);
        cell.append(stock);

        var tech1 = $("<input />");
        tech1.attr("type", "text");
        tech1.attr("name", "test");
        tech1.attr("class", "form-control");
        tech1.attr('readonly', true);
        tech1.val(stocks);
        cell.append(tech1);

        var cell = $(row.insertCell(-1));
        var cty = $("<input />");
        cty.attr("type", "text");
        cty.attr("class", "form-control");
        cty.attr("name", "cty[]");
        cty.attr('readonly', true);
        cty.val(current_qty);
        cell.append(cty);

        var cell = $(row.insertCell(-1));
        var cty1 = $("<input />");
        cty1.attr("type", "text");
        cty1.attr("class", "form-control");
        cty1.attr("name", "new_qty[]");
        cty1.attr('readonly', true);
        cty1.val(newqty);
        cell.append(cty1);

        var cell = $(row.insertCell(-1));
        var cty2 = $("<input />");
        cty2.attr("type", "text");
        cty2.attr("class", "form-control");
        cty2.attr("name", "total_qty[]");
        cty2.attr('readonly', true);
        cty2.val(total_qty);
        cell.append(cty2);

        cell = $(row.insertCell(-1));
        var btnRemove = $("<input />");
        btnRemove.attr("type", "button");
        btnRemove.attr("onclick", "Remove(this);");
        btnRemove.val("Remove");
        cell.append(btnRemove);
    };
    function Remove(button) {
        //Determine the reference of the Row using the Button.
        var row = $(button).closest("TR");
        var name = $("TD", row).eq(0).html();
        if (confirm("Do you want to delete: ")) {

            //Get the reference of the Table.
            var table = $("#sampleTable1")[0];

            //Delete the Table row using it's Index.
            table.deleteRow(row[0].rowIndex);
        }
    };
</script>

<script>
    function edit_material (id) {
        $.ajax({
            url:"<?php echo site_url('Admin_Controller/Edit_Material'); ?>",
            data: {id: id},
            type: "POST",
            cache: false,
            success:function(server_response){
                $("#update").show();
                $("#add").hide();
                var data = $.parseJSON(server_response);
                var charges_name = data[0]['Material_Name'];
                document.getElementById('material').value = charges_name;
                var price = data[0]['Material_Current_Price'];
                document.getElementById('price').value = price;
                var icode =data[0]['Material_Icode'];
                document.getElementById('material_icode').value = icode;
            }
        });
    }
    function Save_inventry() {

        var material =document.getElementsByName("material[]");
        var materials = [];
        for (var j = 0, iLen = material.length; j < iLen; j++) {
            materials.push(material[j].value);
        }

        var new_qty =document.getElementsByName("new_qty[]");
        var new_qtys = [];
        for (var j = 0, iLen = new_qty.length; j < iLen; j++) {
            new_qtys.push(new_qty[j].value);
        }

        var total_qty =document.getElementsByName("total_qty[]");
        var total_qtys = [];
        for (var j = 0, iLen = total_qty.length; j < iLen; j++) {
            total_qtys.push(total_qty[j].value);
        }

        if (materials == '' || new_qtys == '' || total_qtys == ''){
            alert("Please Select All Fields");
        }
        else{
            $.ajax({
                url:"<?php echo site_url('Admin_Controller/Save_Inventary'); ?>",
                data: {material_id: materials, new_quantity: new_qtys, total_quantity: total_qtys },
                type: "POST",
                cache: false,
                success:function(server_response){
                    if(server_response == 1)
                    {
                        swal({
                                title: "Success!",
                                text: "Data Saved!",
                                type: "success"
                            },
                            function(){
                                location.reload();
                            });

                    }

                }
            });
        }

    }

</script>