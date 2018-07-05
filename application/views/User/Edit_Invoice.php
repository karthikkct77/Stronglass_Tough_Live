    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>Invoice</h1>

            </div>
            <div class="row invoice">
                <h4><?php echo $st[0]['ST_Name']; ?></h4>
                <h5><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?></h5>
                <h6><span>Mob: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">Profoma_invoice</li>
                <li class="breadcrumb-item"><a href="#">Profoma_invoice</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12" >
                <div class="tile">
                    <form method="post" class="login-form" action="<?php echo site_url('User_Controller/Update_Invoice'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Save ?');">
                        <div class="row">
                            <div class="col-md-4">

                                <h5>Consignee</h5>
                                <input  class="form-control" name="search_data" id="search_data" type="text" value="<?php echo $invoice[0]['Customer_Company_Name']; ?>"   onkeyup="ajaxSearch();" required>
                                <input  class="form-control" name="company_name" id="company_name" type="hidden" value="<?php echo $invoice[0]['Customer_Icode']; ?>">
                                <div id="suggestions">
                                    <div id="autoSuggestionsList"></div>
                                </div>
                                <div id="consign">
                                    <h5 id="coustomer"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
                                    <h5 id="address"><?php echo $invoice[0]['Customer_Address_1']; ?><?php echo $invoice[0]['Customer_Address_2']; ?></h5>
                                    <h5 id="phone">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></h5>
                                    <h5 id="gstn">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></h5>
                                </div>

                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <input type="checkbox" name="check" id="check" checked onclick="FillBilling()">
                                    <em>Check this box if Current Address and Mailing permanent are the same.</em>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <h5>Buyer (if other than consignee)</h5>
                                <div class="form-group" >
                                    <label class="control-label">Customer Name </label>
                                    <select name="company_address" class="form-control" id="company_name2" style="display: none" >
                                        <option>Select Another Address</option>
                                    </select>
                                </div>
                                <div id="Buyer">
                                    <?php
                                    if($invoice[0]['Customer_Address_Icode'] == "")
                                    {
                                        ?>
                                        <h5 id="coustomer"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
                                        <h5 id="address"><?php echo $invoice[0]['Customer_Address_1']; ?>$nbsn;<?php echo $invoice[0]['Customer_Address_2']; ?></h5>
                                        <h5 id="phone">City: <?php echo $invoice[0]['Customer_City']; ?></h5>
                                        <h5 id="phone">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></h5>
                                        <h5 id="gstn">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></h5>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <h5 id="coustomer"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
                                        <h5 id="address"><?php echo $invoice[0]['Customer_Add_Address_1']; ?>$nbsn;<?php echo $invoice[0]['Customer_Add_Address_2']; ?></h5>
                                        <h5 id="phone">City: <?php echo $invoice[0]['Customer_Add_City']; ?></h5>
                                        <h5 id="phone">Phone: <?php echo $invoice[0]['Customer_Add_Phone']; ?></h5>
                                        <h5 id="gstn">GSTN: <?php echo $invoice[0]['Customer_Add_Email_Id_1']; ?></h5>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" type="hidden" name="PI_Icode"  value="<?php echo $invoice[0]['Proforma_Icode']; ?>" >
                                <h4>Proforma Invoice No: <input type="text" name="invoice_no" id="invoice_no" value="<?php echo $invoice[0]['Proforma_Number']; ?>" readonly></h4>
                                <h4>Proforma Invoice Date: <input type="text" name="invoice_date" id="invoice_date" value="<?php echo $invoice[0]['Proforma_Date']; ?>" readonly></h4>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-hover table-bordered" id="sampleTabless">
                                <thead>
                                <th>#</th>
                                <th>Material</th>
                                <th>Hsn code</th>
                                <th>Special</th>
                                <th>No.of Pieces</th>
                                <th>No.of Holes</th>
                                <th>Actucal Size(W)(MM)</th>
                                <th>Actucal Size(H)(MM)</th>
                                <th>Chargable Size(W)(MM)</th>
                                <th>Chargable Size(H)(MM)</th>
                                <th>Area(SQMTR)</th>
                                <th>Rate(SQMTR)</th>
                                <th>Total(INR)</th>
                                <th></th>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach ($invoice_item as $key) { ?>
                                    <tr id="row<?php echo $i; ?>">
    <!--                                    <input class="form-control" type="hidden" name="material[]"  value="" >-->
                                        <input class="form-control" type="hidden" name="qty[]"  value="<?php echo $key['Proforma_Qty']; ?>" >
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <div class="form-group">
                                                <select name="material[]" class="form-control" id="material"  required >
                                                    <option value="<?php echo $key['Proforma_Invoice_Items_Icode']; ?>" ><?php echo $key['Material_Name']; ?></option>
                                                    <?php foreach ($stock as $row):
                                                    {
                                                        echo '<option value= "'.$row['Material_Icode'].'">' . $row['Material_Name'] . '</option>';
                                                    }
                                                    endforeach; ?>
                                                </select>
                                            </div></td>
                                        <td><?php echo $key['Proforma_HSNCode']; ?></td>
                                        <td><?php echo $key['Proforma_Special']; ?></td>
                                        <td><input class="form-control" type="number" id="pics<?php echo $i; ?>"  name="pics[]"  value="<?php echo $key['Proforma_Qty']; ?>" onkeyup="change_rate('<?php echo $i; ?>')" ></td>
                                        <td><input class="form-control" type="number" name="holes[]"  value="<?php echo $key['Proforma_Holes']; ?>" ></td>
                                        <td><input class="form-control" type="number" id="Actual_width<?php echo $i; ?>" name="Actual_width[]"  value="<?php echo $key['Proforma_Actual_Size_Width']; ?>"  onkeyup="change_Actual_Width('<?php echo $i; ?>')" ></td>
                                        <td><input class="form-control" type="number" id="Actual_height<?php echo $i; ?>" name="Actual_height[]"  value="<?php echo $key['Proforma_Actual_Size_Height']; ?>"  onkeyup="change_Actual_Height('<?php echo $i; ?>')" ></td>
                                        <td><input class="form-control" type="number" id="Charge_width<?php echo $i; ?>" name="Charge_width[]"  value="<?php echo $key['Proforma_Chargeable_Size_Width']; ?>"  onkeyup="change_Charge_Width('<?php echo $i; ?>')" ></td>
                                        <td><input class="form-control" type="number" id="Charge_height<?php echo $i; ?>" name="Charge_height[]"  value="<?php echo $key['Proforma_Chargeable_Size_Height']; ?>"  onkeyup="change_Charge_Height('<?php echo $i; ?>')" ></td>
                                        <td><input class="form-control" type="number" name="area[]" id="area<?php echo $i; ?>" value="<?php echo $key['Proforma_Area_SQMTR']; ?>" readonly></td>
                                        <td><input class="form-control" type="number" name="rate[]" value="<?php echo $key['Proforma_Material_Rate']; ?>" id="rate<?php echo $i; ?>" onkeyup="change_rate('<?php echo $i; ?>')" ></td>
                                        <td><input class="form-control" type="number" name="total[]" value="<?php echo $key['Proforma_Material_Cost']; ?>" id="total<?php echo $i; ?>" readonly></td>
                                        <td><input type="button" onclick="delete_items('<?php echo $i; ?>','<?php echo $key['Proforma_Invoice_Items_Icode']; ?>')" value="Delete"></input></td>
                                    </tr>
                                    <?php $i++; } ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><input type="text" class="form-control pull-right" id="total_pic" value="<?php echo $invoice_total[0]['qty']; ?>"   readonly/></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><input type="text" class="form-control pull-right" id="total_area" value="<?php echo round($invoice_total[0]['area'], 2); ?>"   readonly/></td>
                                    <td></td>
                                    <td> <input type="text" class="form-control pull-right" id="grand_total" value="<?php echo round($invoice_total[0]['rate'],2); ?>"   readonly/>(INR)</td>
                                </tr>
                                </tbody>


                            </table>

                            <div >
                                <table id="my_item_table">
                                    <thead></thead>
                                    <tbody></tbody>
                                </table>

                            </div>
                            <script>
                                $("#grand_total").on('click', function() {
                                    var total =document.getElementsByName("total[]");
                                    var sum = 0;
                                    for (var j = 0, iLen = total.length; j < iLen; j++) {
                                        val=parseFloat(total[j].value);
                                        sum +=val;
                                    }
                                    document.getElementById('grand_total').value = parseFloat(sum).toFixed(2);
                                });
                            </script>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h3>Terms & Conditions</h3>
                                <p style="font-size: 16px;text-align: justify;">
                                    We Shall not be responsible for any type of Breakage/Loss in Transit.
                                    At the time of transit Breakage/Loss insurance claim will be done by
                                    the customer and not by the company.
                                    Any discrepancies observed in the supply like quantity,specification,
                                    quality, etc.
                                </p>

                            </div>
                            <div class="col-md-6">
                                <table class="table table-hover table-bordered" id="sampleTable">
                                    <thead>
                                    <th>Select Charges</th>
                                    <th>No.of pieces</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th></th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i=1;
                                    foreach ($invoice_Charges as $key) {
                                        ?>
                                        <tr id="charge<?php echo $i; ?>">
                                            <td><input type="hidden" name="Delete_charges[]" class="form-control" value="<?php echo $key['charge_icode']; ?>" ><?php echo $key['charge_name']; ?></td>
                                            <td><input type="number" id="charges_count<?php echo $i; ?>" name="Delete_charges_count[]" class="form-control" value="<?php echo $key['Proforma_Charge_Count']; ?>" onkeyup="change_charge_count('<?php echo $i; ?>')"  ></td>
                                            <td><input type="number" id="charges_value<?php echo $i; ?>" name="Delete_charges_value[]" class="form-control" value="<?php echo $key['Proforma_Charge_Value']; ?>" onkeyup="change_charge_value('<?php echo $i; ?>')"  ></td>
                                            <td><input class="form-control" type="text" name="tot_charge_amt[]" id="tot_charge_amt<?php echo $i; ?>" value="<?php echo $key['Proforma_Charge_Cost']; ?>"  readonly></td>
                                            <td><input type="button" onclick="delete_charges('<?php echo $i; ?>','<?php echo $key['charge_icode']; ?>')" value="Delete"></input>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>

                                        <td><div class="form-group">
                                                <select name="charges[]" class="form-control" id="charges"   >
                                                    <option value="" >Select Charges</option>
                                                    <?php foreach ($charges as $row):
                                                    {
                                                        echo '<option value= "'.$row['charge_icode'].'">' . $row['charge_name'] . '</option>';
                                                    }
                                                    endforeach; ?>
                                                </select>
                                            </div></td>
                                        <td><input class="form-control" type="number" name="no_holes[]" id="no_holes" ></td>
                                        <td><input class="form-control" type="number" name="charge_amt[]" id="charge_amt"  readonly></td>
                                        <td><input class="form-control" type="text" name="tot_charge_amt[]" id="tot_charge_amount"  readonly></td>
                                        <td><input type="button" onclick="Add_one()" value="Add" id="Add" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="right">SUB-TOTAL</td>

                                        <td><input class="form-control" type="text" name="sub_tot" id="sub_tot" value="<?php echo $invoice[0]['Sub_Total']; ?>" readonly ></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="right">HANDLING CHARGES</td>
                                        <td><input class="form-control" type="text" name="insurance" id="insurance" value="<?php echo $invoice[0]['Insurance_Value']; ?>" required readonly></td>
                                        <td></td>
                                    </tr>
                                        <tr>
                                            <td colspan="3" align="right">TRANSPORT</td>
                                            <td><input class="form-control" type="text" name="transport" id="transport" onkeyup="change_transport(this.value)"  value="<?php echo $invoice[0]['Transport']; ?>" ></td>
                                            <td></td>
                                        </tr>

                                        <?php
                                        if($invoice[0]['IGST_Value'] == '0')
                                        { ?>
                                            <tr>

                                                <td colspan="3" align="right">SGST @<?php echo $tax[0]['SGST%']; ?></td>

                                                <td><input class="form-control" type="text" name="sgst" id="sgst" value="<?php echo $invoice[0]['SGST_Value']; ?>"readonly ></td>
                                                <td> <input type="hidden" id="igst" value=""></td>
                                            </tr>
                                            <tr>

                                                <td colspan="3" align="right">CGST @<?php echo $tax[0]['CGST%']; ?>
                                                    <input type="hidden" id="gst" value="<?php echo $tax[0]['CGST%']; ?>">
                                                </td>
                                                <td><input class="form-control" type="text" name="cgst" id="cgst" value="<?php echo $invoice[0]['CGST_Value']; ?>" readonly ></td>
                                                <td></td>
                                            </tr>

                                        <?php }
                                        else
                                        { ?>
                                            <tr>
                                                <td colspan="3" align="right">IGST @18%
                                                    <input type="hidden" id="igst1" value="18">
                                                </td>
                                                <td><input class="form-control" type="text" name="igst" id="igst" value="<?php echo $invoice[0]['IGST_Value']; ?>" readonly ></td>
                                                <td></td>
                                            </tr>
                                       <?php }
                                        ?>
                                    <tr>

                                        <td colspan="3" align="right">GROSS TOTAL</td>
                                        <td><input class="form-control" type="text" name="gross_tot" id="gross_tot" readonly value="<?php echo $invoice[0]['GrossTotal_Value']; ?>" ></td>
                                        <td></td>
                                    </tr>
                                    </tfoot>
                                </table>
                                <div style="display: none">
                                    <table id="my_table">
                                        <thead></thead>
                                        <tbody></tbody>
                                    </table>

                                </div>
                            </div>
                            <script>
                                $("#insurance").on('change keyup paste', function() {
                                    var sub_tot =document.getElementById('sub_tot').value;
                                    var insurance =document.getElementById('insurance').value;
                                    var gst = document.getElementById('gst').value;
                                    var sum = ((parseFloat(sub_tot) + parseFloat(insurance)) * gst / 100 );
                                    document.getElementById('sgst').value = parseFloat(sum).toFixed(2);
                                    document.getElementById('cgst').value = parseFloat(sum).toFixed(2);
                                    var sgst = document.getElementById('sgst').value;
                                    var cgst = document.getElementById('cgst').value;
                                    var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(sgst) + parseFloat(cgst));
                                    document.getElementById('gross_tot').value = parseInt(grant);
                                });
                            </script>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Bank Details</h4>
                                <h5>Stronglass Tough</h5>
                                <h5>A/C Type: <span><?php echo $st[0]['ST_Bank_Account_Type']; ?></span></h5>
                                <h5>A/C Number: <span><?php echo $st[0]['ST_Bank_Account_Number']; ?></span></h5>
                                <h5>Name: <span><?php echo $st[0]['ST_Bank']; ?></span></h5>
                                <h5>IFSC:<span><?php echo $st[0]['ST_Bank_Account_IFSC_Code']; ?></span> </h5>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-danger pull-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <style>
        #search_data {
            width: 200px;
            padding: 5px;
            margin: 5px 0;
            box-sizing: border-box;
        }
        #autoSuggestionsList > li {
            background: none repeat scroll 0 0 #F3F3F3;
            border-bottom: 1px solid #E3E3E3;
            list-style: none outside none;
            padding: 3px 15px 3px 15px;
            text-align: left;
        }

        #autoSuggestionsList > li a { color: #800000; }

        .auto_list {
            border: 1px solid #E3E3E3;
            border-radius: 5px 5px 5px 5px;
            position: absolute;
        }
    </style>


    <script>
        $("#company_name2").change(function () {
            $.ajax({
                url:"<?php echo site_url('User_Controller/get_Customer_Address_Details'); ?>",
                data: {id:
                    $(this).val()},
                type: "POST",
                success:function(server_response){
                    var data = $.parseJSON(server_response);
                    $('#Buyer').show();
                    document.getElementById('coustomer1').innerHTML = data[0]['Customer_Company_Name'];
                    document.getElementById('address1').innerHTML = data[0]['Customer_Add_Address_1'] + data[0]['Customer_Add_Area'] + data[0]['Customer_Add_City'] ;
                    document.getElementById('phone1').innerHTML = "Mob :" + data[0]['Customer_Add_Phone'];
                    document.getElementById('gstn1').innerHTML = "GSTIN :" + data[0]['Customer_Add_GSTIN'];
                }
            });
        });
        $("#no_holes").on('change keyup paste', function() {
            var holes = parseInt($(this).val());
            var amt = parseInt($('#charge_amt').val());
            var total =  parseInt(holes * amt);
            document.getElementById('tot_charge_amount').value = total;

            var totals =document.getElementsByName("tot_charge_amt[]");
            var sum1 = 0;
            for (var j = 0, iLen = totals.length; j < iLen; j++) {
                if (totals[j].value!==""){
                    val=parseFloat(totals[j].value);
                    sum1 +=val;
                }
            }
            var grant_tot = document.getElementById('grand_total').value;
            var sub_tot1 = parseFloat(sum1) + parseFloat(grant_tot);
            document.getElementById('sub_tot').value = parseFloat(sub_tot1).toFixed(2);
            var sub_tot =document.getElementById('sub_tot').value;
            var insurance =document.getElementById('insurance').value;
            var igst =document.getElementById('igst').value;
            if(igst == '')
            {
                var gst = document.getElementById('gst').value;
                var trans =document.getElementById('transport').value;
                var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                document.getElementById('sgst').value = parseFloat(sum).toFixed(2);
                document.getElementById('cgst').value = parseFloat(sum).toFixed(2);
                var sgst = document.getElementById('sgst').value;
                var cgst = document.getElementById('cgst').value;
                var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(sgst) + parseFloat(cgst) + parseFloat(trans));
                document.getElementById('gross_tot').value = parseInt(grant);
            }
            else
            {

                var gst = 18;
                var trans =document.getElementById('transport').value;
                var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                var iisgst = document.getElementById('igst').value;
                var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst)+ parseFloat(trans));
                document.getElementById('gross_tot').value = parseInt(grant);
            }
            number_to_words();

        });
        $("#charges").change(function () {
            $.ajax({
                url:"<?php echo site_url('User_Controller/Edit_Charges'); ?>",
                data: {id:
                    $(this).val()},
                type: "POST",
                success:function(server_response){
                    var data = $.parseJSON(server_response);
                    var  price = data[0]['charge_current_price'];
                    document.getElementById('charge_amt').value = price;
                }
            });
        });
        $("#Add").click(function () {
            if($('#charges').val() == "")
            {
                alert("Please Select Charges...");
            }
            else if($('#no_holes').val() == ""){
                alert("Please enter No.of pieces...");
            }
            else
            {
                var chrgs = $("#charges option:selected").text();
                AddRow($('#charges').val(), $("#no_holes").val(),$("#charge_amt").val(),$("#tot_charge_amount").val(),chrgs);
                $("#charges").val("");
                $("#no_holes").val("");
                $("#charge_amt").val("");
                $("#tot_charge_amount").val("");
            }
        });
        function AddRow(charges,no_holes,charge_amt,tot_charge_amt,chrgs) {
            var tBody = $("#sampleTable > TBODY")[0];
            //Add Row.
            row = tBody.insertRow(-1);
            //Add Name cell.
            var cell = $(row.insertCell(-1));
            var stock = $("<input />");
            stock.attr("type", "hidden");
            stock.attr("name", "charges[]");
            stock.val(charges);
            cell.append(stock);

            var tech1 = $("<input />");
            tech1.attr("type", "text");
            tech1.attr("name", "test");
            tech1.attr("class", "form-control");
            tech1.attr('readonly', true);
            tech1.val(chrgs);
            cell.append(tech1);

            var cell = $(row.insertCell(-1));
            var cty = $("<input />");
            cty.attr("type", "text");
            cty.attr("class", "form-control");
            cty.attr("name", "no_holes[]");
            cty.attr('readonly', true);
            cty.val(no_holes);
            cell.append(cty);

            var cell = $(row.insertCell(-1));
            var cty1 = $("<input />");
            cty1.attr("type", "text");
            cty1.attr("class", "form-control");
            cty1.attr("name", "charge_amt[]");
            cty1.attr('readonly', true);
            cty1.val(charge_amt);
            cell.append(cty1);

            var cell = $(row.insertCell(-1));
            var cty2 = $("<input />");
            cty2.attr("type", "text");
            cty2.attr("class", "form-control");
            cty2.attr("name", "tot_charge_amt[]");
            cty2.attr('readonly', true);
            cty2.val(tot_charge_amt);
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
                var table = $("#sampleTable")[0];
                //Delete the Table row using it's Index.
                table.deleteRow(row[0].rowIndex);
                var totals =document.getElementsByName("tot_charge_amt[]");
                var sum1 = 0;
                for (var j = 0, iLen = totals.length; j < iLen; j++) {
                    if (totals[j].value!==""){
                        val=parseFloat(totals[j].value);
                        sum1 +=val;
                    }
                }
                var grant_tot = document.getElementById('grand_total').value;
                var sub_tot1 = parseFloat(sum1) + parseFloat(grant_tot);
                document.getElementById('sub_tot').value = parseFloat(sub_tot1).toFixed(2);
                var sub_tot =document.getElementById('sub_tot').value;
                var insurance =document.getElementById('insurance').value;
                var igst =document.getElementById('igst').value;
                if(igst == '')
                {
                    var gst = document.getElementById('gst').value;
                    var trans =document.getElementById('transport').value;
                    var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                    document.getElementById('sgst').value = parseFloat(sum).toFixed(2);
                    document.getElementById('cgst').value = parseFloat(sum).toFixed(2);
                    var sgst = document.getElementById('sgst').value;
                    var cgst = document.getElementById('cgst').value;
                    var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(sgst) + parseFloat(cgst) + parseFloat(trans));
                    document.getElementById('gross_tot').value = parseInt(grant);
                }
                else
                {
                    var gst = 18;
                    var trans =document.getElementById('transport').value;
                    var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                    document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                    var iisgst = document.getElementById('igst').value;
                    var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst)+ parseFloat(trans));
                    document.getElementById('gross_tot').value = parseInt(grant);
                }
                number_to_words();
            }
        };
        function FillBilling() {
            if($('#check').is(":checked"))
            {
                $('#Buyer').show();
                $('#company_name2').hide();
                document.getElementById('coustomer1').innerHTML =  document.getElementById('coustomer').innerHTML;
                document.getElementById('address1').innerHTML  = document.getElementById('address').innerHTML;
                document.getElementById('phone1').innerHTML =  document.getElementById('phone').innerHTML
                document.getElementById('gstn1').innerHTML =  document.getElementById('gstn').innerHTML;
            }
            else
            {
                $('#Buyer').hide();
                $('#company_name2').show();
            }
        }
        function get_result(id) {
            var pcs = document.getElementById('pics'+id).value;
            var area = document.getElementById('area'+id).value;
            $("#material"+id).change(function () {
                $.ajax({
                    url:"<?php echo site_url('User_Controller/Edit_Material'); ?>",
                    data: {id:
                        $(this).val()},
                    type: "POST",
                    success:function(server_response){
                        var data = $.parseJSON(server_response);
                        var amount = data[0]['Material_Current_Price'];
                        var total = pcs * area * amount;
                        document.getElementById('total'+id).value = total.toFixed(2);
                        document.getElementById('rate'+id).value = amount;
                        // Grand Total
                        var totals =document.getElementsByName("total[]");
                        var sum = 0;
                        for (var j = 0, iLen = totals.length; j < iLen; j++) {
                            if (totals[j].value!==""){
                                val=parseFloat(totals[j].value);
                                sum +=val;
                            }
                        }
                        document.getElementById('grand_total').value = parseFloat(sum).toFixed(2);

                        // total pices
                        var pices =document.getElementsByName("pics[]");
                        var sum_pic = 0;
                        for (var j = 0, iLen = pices.length; j < iLen; j++) {
                            if (pices[j].value!==""){
                                val=parseFloat(pices[j].value);
                                sum_pic +=val;
                            }
                        }
                        document.getElementById('total_pic').value = parseInt(sum_pic);

                        //total area
                        var areas =document.getElementsByName("area[]");
                        var sum_area = 0;
                        for (var j = 0, iLen = areas.length; j < iLen; j++) {
                            if (areas[j].value!==""){
                                val=parseFloat(areas[j].value);
                                sum_area +=val;
                            }
                        }
                        document.getElementById('total_area').value = parseFloat(sum_area).toFixed(2);

                    }
                });
            });
        }

        function change_rate(id) {
            var pcs = document.getElementById('pics'+id).value;
            var area = document.getElementById('area'+id).value;
            var rate = document.getElementById('rate'+id).value;
            var total = (pcs * area * rate);
            document.getElementById('total'+id).value =  parseFloat(total).toFixed(2);
            // Grand Total
            var totals =document.getElementsByName("total[]");
            var sum = 0;
            for (var j = 0, iLen = totals.length; j < iLen; j++) {
                if (totals[j].value!==""){
                    val=parseFloat(totals[j].value);
                    sum +=val;
                }
            }
            document.getElementById('grand_total').value = parseFloat(sum).toFixed(2);
            // total pices
            var pices =document.getElementsByName("pics[]");
            var sum_pic = 0;
            for (var j = 0, iLen = pices.length; j < iLen; j++) {
                if (pices[j].value!==""){
                    val=parseFloat(pices[j].value);
                    sum_pic +=val;
                }
            }
            document.getElementById('total_pic').value = parseInt(sum_pic);
            var charge =document.getElementsByName("tot_charge_amt[]");
            var sum_charge = 0;
            for (var j = 0, iLen = charge.length; j < iLen; j++) {
                if (charge[j].value!==""){
                    val=parseFloat(charge[j].value);
                    sum_charge +=val;
                }
            }
            var grant_tot = document.getElementById('grand_total').value;
            var sub_tot = parseFloat(sum_charge) + parseFloat(grant_tot);
            document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
            var sub_tot =document.getElementById('sub_tot').value;

            var tax = 2.42;
            var total = parseFloat (sub_tot * tax / 100);
            document.getElementById('insurance').value = parseFloat(total).toFixed(3);
            var insurance =parseFloat(total).toFixed(3);

            var igst =document.getElementById('igst').value;
            if(igst == '')
            {
                var gst = document.getElementById('gst').value;
                var trans =document.getElementById('transport').value;
                var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                document.getElementById('sgst').value = parseFloat(sum).toFixed(2);
                document.getElementById('cgst').value = parseFloat(sum).toFixed(2);
                var sgst = document.getElementById('sgst').value;
                var cgst = document.getElementById('cgst').value;
                var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(sgst) + parseFloat(cgst) + parseFloat(trans));
                document.getElementById('gross_tot').value = parseInt(grant);
            }
            else
            {

                var gst = 18;
                var trans =document.getElementById('transport').value;
                var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                var iisgst = document.getElementById('igst').value;
                var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst) + parseFloat(trans));
                document.getElementById('gross_tot').value = parseInt(grant);
            }
            number_to_words();

        }

        function ajaxSearch()
        {
            var input_data = $('#search_data').val();

            if (input_data.length === 0)
            {
                $('#suggestions').hide();
            }
            else
            {

                var post_data = {
                    'search_data': input_data,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                };

                $.ajax({
                    type: "POST",

                    url:"<?php echo site_url('User_Controller/GetCountryName'); ?>",
                    data: post_data,
                    success: function (data) {
                        // return success
                        if (data.length > 0) {
                            $('#suggestions').show();
                            $('#autoSuggestionsList').addClass('auto_list');
                            $('#autoSuggestionsList').html(data);
                        }
                    }
                });

            }
        }

        function get_row(id) {
            $.ajax({
                url:"<?php echo site_url('User_Controller/get_Customer_Address'); ?>",
                data: {id:
                id},
                type: "POST",
                success:function(server_response){
                    $("#company_name2").html(server_response);
                    $('#suggestions').hide();
                    $('#Buyer').show();
                    document.getElementById('coustomer1').innerHTML =  document.getElementById('coustomer').innerHTML;
                    document.getElementById('address1').innerHTML  = document.getElementById('address').innerHTML;
                    document.getElementById('phone1').innerHTML =  document.getElementById('phone').innerHTML
                    document.getElementById('gstn1').innerHTML =  document.getElementById('gstn').innerHTML;
                }
            });
            $.ajax({
                url:"<?php echo site_url('User_Controller/get_Customer_Details'); ?>",
                data: {id:
                id},
                type: "POST",
                success:function(server_response){
                    $('#suggestions').hide();
                    var data = $.parseJSON(server_response);
                    document.getElementById('search_data').value = data[0]['Customer_Company_Name'];
                    document.getElementById('company_name').value = data[0]['Customer_Icode'];
                    document.getElementById('coustomer').innerHTML = data[0]['Customer_Company_Name'];
                    document.getElementById('address').innerHTML = data[0]['Customer_Address_1'] + data[0]['Customer_Area']  + data[0]['Customer_City'];
                    document.getElementById('phone').innerHTML = "Mob :" + data[0]['Customer_Phone'];
                    document.getElementById('gstn').innerHTML = "GSTIN :" + data[0]['Customer_GSTIN'];
                    $('#Buyer').show();
                    $('#company_name2').hide();
                    document.getElementById('coustomer1').innerHTML =  document.getElementById('coustomer').innerHTML;
                    document.getElementById('address1').innerHTML  = document.getElementById('address').innerHTML;
                    document.getElementById('phone1').innerHTML =  document.getElementById('phone').innerHTML
                    document.getElementById('gstn1').innerHTML =  document.getElementById('gstn').innerHTML;
                }
            });
        }
        function isgt() {
            $('#igst1').show();
            $('#sgst1').hide();
            $('#cgst1').hide();
            var sub_tot =document.getElementById('sub_tot').value;
            var insurance =document.getElementById('insurance').value;
            var trans =document.getElementById('transport').value;
            var sum = ((parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(trans) ) * 18 / 100 );
            document.getElementById('igst').value = parseFloat(sum).toFixed(2);
            var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(trans) + parseFloat(sum));
            document.getElementById('gross_tot').value = parseInt(grant);
            number_to_words();
        }
        function GST() {
            $('#igst1').hide();
            $('#sgst1').show();
            $('#cgst1').show();
            var sub_tot =document.getElementById('sub_tot').value;
            var insurance =document.getElementById('insurance').value;
            var gst = document.getElementById('gst').value;
            var trans =document.getElementById('transport').value;
            var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
            document.getElementById('sgst').value = parseFloat(sum).toFixed(2);
            document.getElementById('cgst').value = parseFloat(sum).toFixed(2);
            var sgst = document.getElementById('sgst').value;
            var cgst = document.getElementById('cgst').value;
            var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(sgst) + parseFloat(cgst) + parseFloat(trans));
            document.getElementById('gross_tot').value = parseInt(grant);
            number_to_words();
        }

     /** Change Actual Width */
        function change_Actual_Width(id) {
            var actual_W = document.getElementById('Actual_width'+id).value;
            var Charge_W = parseInt(actual_W) + 30;
            document.getElementById('Charge_width'+id).value = Charge_W;
            var Charge_H = document.getElementById('Charge_height'+id).value;
            var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000;
            document.getElementById('area'+id).value = parseFloat(areas).toFixed(3);
            var pcs = document.getElementById('pics'+id).value;
            var rate = document.getElementById('rate'+id).value;
            var total = (pcs * areas * rate);
            document.getElementById('total'+id).value =  parseFloat(total).toFixed(3);

//            // Grand Total
            var totals =document.getElementsByName("total[]");
            var sum = 0;
            for (var j = 0, iLen = totals.length; j < iLen; j++) {
                if (totals[j].value!==""){
                    val=parseFloat(totals[j].value);
                    sum +=val;
                }
            }
            document.getElementById('grand_total').value = parseFloat(sum).toFixed(2);
            // total pices
            var pices =document.getElementsByName("pics[]");
            var sum_pic = 0;
            for (var j = 0, iLen = pices.length; j < iLen; j++) {
                if (pices[j].value!==""){
                    val=parseFloat(pices[j].value);
                    sum_pic +=val;
                }
            }
            document.getElementById('total_pic').value = parseInt(sum_pic);
            var totals =document.getElementsByName("tot_charge_amt[]");
            var sum = 0;
            for (var j = 0, iLen = totals.length; j < iLen; j++) {
                if (totals[j].value!==""){
                    val=parseFloat(totals[j].value);
                    sum +=val;
                }
            }
            var grant_tot = document.getElementById('grand_total').value;
            var sub_tot = parseFloat(sum) + parseFloat(grant_tot);
            document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
            var sub_tot =document.getElementById('sub_tot').value;

            var tax = 2.42;
            var total = parseFloat (sub_tot * tax / 100);
            document.getElementById('insurance').value = parseFloat(total).toFixed(3);
            var insurance =parseFloat(total).toFixed(3);

            var igst =document.getElementById('igst').value;
            if(igst == '')
            {
                var gst = document.getElementById('gst').value;
                var trans =document.getElementById('transport').value;
                var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                document.getElementById('sgst').value = parseFloat(sum).toFixed(2);
                document.getElementById('cgst').value = parseFloat(sum).toFixed(2);
                var sgst = document.getElementById('sgst').value;
                var cgst = document.getElementById('cgst').value;
                var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(sgst) + parseFloat(cgst) + parseFloat(trans));
                document.getElementById('gross_tot').value = parseInt(grant);
            }
            else
            {

                var gst = 18;
                var trans =document.getElementById('transport').value;
                var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                var iisgst = document.getElementById('igst').value;
                var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst) + parseFloat(trans));
                document.getElementById('gross_tot').value = parseInt(grant);

            }
         number_to_words();
        }
        /** Change Actual Width */

        /** Change Actual Height */
        function change_Actual_Height(id) {
            var actual_H = document.getElementById('Actual_height'+id).value;
            var Charge_H = parseInt(actual_H) + 30;
            document.getElementById('Charge_height'+id).value = Charge_H;
            var Charge_W = document.getElementById('Charge_width'+id).value;
            var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000;
            document.getElementById('area'+id).value = parseFloat(areas).toFixed(3);
            var pcs = document.getElementById('pics'+id).value;
            var rate = document.getElementById('rate'+id).value;
            var total = (pcs * areas * rate);
            document.getElementById('total'+id).value =  parseFloat(total).toFixed(3);

//            // Grand Total
            var totals =document.getElementsByName("total[]");
            var sum = 0;
            for (var j = 0, iLen = totals.length; j < iLen; j++) {
                if (totals[j].value!==""){
                    val=parseFloat(totals[j].value);
                    sum +=val;
                }
            }
            document.getElementById('grand_total').value = parseFloat(sum).toFixed(2);
            // total pices
            var pices =document.getElementsByName("pics[]");
            var sum_pic = 0;
            for (var j = 0, iLen = pices.length; j < iLen; j++) {
                if (pices[j].value!==""){
                    val=parseFloat(pices[j].value);
                    sum_pic +=val;
                }
            }
            document.getElementById('total_pic').value = parseInt(sum_pic);
            var totals =document.getElementsByName("tot_charge_amt[]");
            var sum = 0;
            for (var j = 0, iLen = totals.length; j < iLen; j++) {
                if (totals[j].value!==""){
                    val=parseFloat(totals[j].value);
                    sum +=val;
                }
            }
            var grant_tot = document.getElementById('grand_total').value;
            var sub_tot = parseFloat(sum) + parseFloat(grant_tot);
            document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
            var sub_tot =document.getElementById('sub_tot').value;

            var tax = 2.42;
            var total = parseFloat (sub_tot * tax / 100);
            document.getElementById('insurance').value = parseFloat(total).toFixed(3);
            var insurance =parseFloat(total).toFixed(3);

            var igst =document.getElementById('igst').value;
            if(igst == '')
            {
                var gst = document.getElementById('gst').value;
                var trans =document.getElementById('transport').value;
                var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                document.getElementById('sgst').value = parseFloat(sum).toFixed(2);
                document.getElementById('cgst').value = parseFloat(sum).toFixed(2);
                var sgst = document.getElementById('sgst').value;
                var cgst = document.getElementById('cgst').value;
                var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(sgst) + parseFloat(cgst) + parseFloat(trans));
                document.getElementById('gross_tot').value = parseInt(grant);
            }
            else
            {

                var gst = 18;
                var trans =document.getElementById('transport').value;
                var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                var iisgst = document.getElementById('igst').value;
                var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst) + parseFloat(trans));
                document.getElementById('gross_tot').value = parseInt(grant);

            }
            number_to_words();
        }
        /** Change Actual Height */

        /** Change Charge Width */
        function change_Charge_Width(id) {
            var actual_W = document.getElementById('Actual_width'+id).value;
            var Charge_W = document.getElementById('Charge_width'+id).value;
            var Charge_H = document.getElementById('Charge_height'+id).value;

            if(actual_W > Charge_W)
            {
                alert("Chargable Width should be greater then Actual Width")
            }
            else
            {
                var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000;
                document.getElementById('area'+id).value = parseFloat(areas).toFixed(3);
                var pcs = document.getElementById('pics'+id).value;
                var rate = document.getElementById('rate'+id).value;
                var total = (pcs * areas * rate);
                document.getElementById('total'+id).value =  parseFloat(total).toFixed(3);

//            // Grand Total
                var totals =document.getElementsByName("total[]");
                var sum = 0;
                for (var j = 0, iLen = totals.length; j < iLen; j++) {
                    if (totals[j].value!==""){
                        val=parseFloat(totals[j].value);
                        sum +=val;
                    }
                }
                document.getElementById('grand_total').value = parseFloat(sum).toFixed(2);
                // total pices
                var pices =document.getElementsByName("pics[]");
                var sum_pic = 0;
                for (var j = 0, iLen = pices.length; j < iLen; j++) {
                    if (pices[j].value!==""){
                        val=parseFloat(pices[j].value);
                        sum_pic +=val;
                    }
                }
                document.getElementById('total_pic').value = parseInt(sum_pic);
                var totals =document.getElementsByName("tot_charge_amt[]");
                var sum = 0;
                for (var j = 0, iLen = totals.length; j < iLen; j++) {
                    if (totals[j].value!==""){
                        val=parseFloat(totals[j].value);
                        sum +=val;
                    }
                }
                var grant_tot = document.getElementById('grand_total').value;
                var sub_tot = parseFloat(sum) + parseFloat(grant_tot);
                document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
                var sub_tot =document.getElementById('sub_tot').value;

                var tax = 2.42;
                var total = parseFloat (sub_tot * tax / 100);
                document.getElementById('insurance').value = parseFloat(total).toFixed(3);
                var insurance =parseFloat(total).toFixed(3);

                var igst =document.getElementById('igst').value;
                if(igst == '')
                {
                    var gst = document.getElementById('gst').value;
                    var trans =document.getElementById('transport').value;
                    var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                    document.getElementById('sgst').value = parseFloat(sum).toFixed(2);
                    document.getElementById('cgst').value = parseFloat(sum).toFixed(2);
                    var sgst = document.getElementById('sgst').value;
                    var cgst = document.getElementById('cgst').value;
                    var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(sgst) + parseFloat(cgst) + parseFloat(trans));
                    document.getElementById('gross_tot').value = parseInt(grant);
                }
                else
                {

                    var gst = 18;
                    var trans =document.getElementById('transport').value;
                    var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                    document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                    var iisgst = document.getElementById('igst').value;
                    var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst) + parseFloat(trans));
                    document.getElementById('gross_tot').value = parseInt(grant);

                }
                number_to_words();

            }

        }
        /** Change Charge Width */

        /** Change Charge Height */
        function change_Charge_Height(id) {
            var actual_H = document.getElementById('Actual_height'+id).value;
            var Charge_W = document.getElementById('Charge_width'+id).value;
            var Charge_H = document.getElementById('Charge_height'+id).value;

            if(actual_H > Charge_H)
            {
                alert("Chargable Height should be greater then Actual Height")
            }
            else
            {
                var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000;
                document.getElementById('area'+id).value = parseFloat(areas).toFixed(3);;
                var pcs = document.getElementById('pics'+id).value;
                var rate = document.getElementById('rate'+id).value;
                var total = (pcs * areas * rate);
                document.getElementById('total'+id).value =  parseFloat(total).toFixed(3);

//            // Grand Total
                var totals =document.getElementsByName("total[]");
                var sum = 0;
                for (var j = 0, iLen = totals.length; j < iLen; j++) {
                    if (totals[j].value!==""){
                        val=parseFloat(totals[j].value);
                        sum +=val;
                    }
                }
                document.getElementById('grand_total').value = parseFloat(sum).toFixed(2);
                // total pices
                var pices =document.getElementsByName("pics[]");
                var sum_pic = 0;
                for (var j = 0, iLen = pices.length; j < iLen; j++) {
                    if (pices[j].value!==""){
                        val=parseFloat(pices[j].value);
                        sum_pic +=val;
                    }
                }
                document.getElementById('total_pic').value = parseInt(sum_pic);
                var totals =document.getElementsByName("tot_charge_amt[]");
                var sum = 0;
                for (var j = 0, iLen = totals.length; j < iLen; j++) {
                    if (totals[j].value!==""){
                        val=parseFloat(totals[j].value);
                        sum +=val;
                    }
                }
                var grant_tot = document.getElementById('grand_total').value;
                var sub_tot = parseFloat(sum) + parseFloat(grant_tot);
                document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
                var sub_tot =document.getElementById('sub_tot').value;

                var tax = 2.42;
                var total = parseFloat (sub_tot * tax / 100);
                document.getElementById('insurance').value = parseFloat(total).toFixed(3);
                var insurance =parseFloat(total).toFixed(3);

                var igst =document.getElementById('igst').value;
                if(igst == '')
                {
                    var gst = document.getElementById('gst').value;
                    var trans =document.getElementById('transport').value;
                    var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                    document.getElementById('sgst').value = parseFloat(sum).toFixed(2);
                    document.getElementById('cgst').value = parseFloat(sum).toFixed(2);
                    var sgst = document.getElementById('sgst').value;
                    var cgst = document.getElementById('cgst').value;
                    var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(sgst) + parseFloat(cgst) +  parseFloat(trans));
                    document.getElementById('gross_tot').value = parseInt(grant);
                }
                else
                {

                    var gst = 18;
                    var trans =document.getElementById('transport').value;
                    var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                    document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                    var iisgst = document.getElementById('igst').value;
                    var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst) +  parseFloat(trans));
                    document.getElementById('gross_tot').value = parseInt(grant);

                }
                number_to_words();

            }

        }
        /** Change Charge Height */

        //** Delete Item **/
        function delete_items (id,item_icode) {
            if (confirm("Do you Want to Delete This Material...!")) {
                var tBody = $("#my_item_table > TBODY")[0];
                //Add Row.
                row = tBody.insertRow(-1);
                //Add Name cell.
                var cell = $(row.insertCell(-1));
                var stock = $("<input />");
                stock.attr("type", "text");
                stock.attr("name", "Delete_Item_Icode[]");
                stock.val(item_icode);
                cell.append(stock);

                $('table#sampleTabless tr#row'+id).remove();
                var totals =document.getElementsByName("total[]");
                var sum = 0;
                for (var j = 0, iLen = totals.length; j < iLen; j++) {
                    if (totals[j].value!==""){
                        val=parseFloat(totals[j].value);
                        sum +=val;
                    }
                }
                document.getElementById('grand_total').value = parseFloat(sum).toFixed(2);
                // total pices
                var pices =document.getElementsByName("pics[]");
                var sum_pic = 0;
                for (var j = 0, iLen = pices.length; j < iLen; j++) {
                    if (pices[j].value!==""){
                        val=parseFloat(pices[j].value);
                        sum_pic +=val;
                    }
                }
                document.getElementById('total_pic').value = parseInt(sum_pic);

                //total area
                var areas =document.getElementsByName("area[]");
                var sum_area = 0;
                for (var j = 0, iLen = areas.length; j < iLen; j++) {
                    if (areas[j].value!==""){
                        val=parseFloat(areas[j].value);
                        sum_area +=val;
                    }
                }
                document.getElementById('total_area').value = parseFloat(sum_area).toFixed(2);

                var totals =document.getElementsByName("tot_charge_amt[]");
                var charge = 0;
                for (var j = 0, iLen = totals.length; j < iLen; j++) {
                    if (totals[j].value!==""){
                        val=parseFloat(totals[j].value);
                        charge +=val;
                    }
                }
                var grant_tot = document.getElementById('grand_total').value;
                var sub_tot = parseFloat(charge) + parseFloat(grant_tot);
                document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
                var tax = 2.42;
                var total = parseFloat (sub_tot * tax / 100);
                document.getElementById('insurance').value = parseFloat(total).toFixed(3);
                var insurance =parseFloat(total).toFixed(3);

                var igst =document.getElementById('igst').value;
                if(igst == '')
                {
                    var gst = document.getElementById('gst').value;
                    var trans =document.getElementById('transport').value;
                    var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                    document.getElementById('sgst').value = parseFloat(sum).toFixed(2);
                    document.getElementById('cgst').value = parseFloat(sum).toFixed(2);
                    var sgst = document.getElementById('sgst').value;
                    var cgst = document.getElementById('cgst').value;
                    var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(sgst) + parseFloat(cgst) + parseFloat(trans));
                    document.getElementById('gross_tot').value = parseInt(grant);
                }
                else
                {

                    var gst = 18;
                    var trans =document.getElementById('transport').value;
                    var sum = parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans);
                    var sum_tot =parseFloat(sum) * gst / 100 ;
                    document.getElementById('igst').value = parseFloat(sum_tot).toFixed(2);
                    var iisgst = document.getElementById('igst').value;
                    var grant = parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst) + parseFloat(trans);
                    document.getElementById('gross_tot').value = parseInt(grant);

                }
                number_to_words();


            }
        }

        //** Delete Item **/

        //** Delete Charges **//
        function delete_charges(id,charges) {
            if (confirm("Do you Want to Delete This Charges...!")) {
                var tBody = $("#my_table > TBODY")[0];
                //Add Row.
                row = tBody.insertRow(-1);
                //Add Name cell.
                var cell = $(row.insertCell(-1));
                var stock = $("<input />");
                stock.attr("type", "text");
                stock.attr("name", "Delete_Charge_Icode[]");
                stock.val(charges);
                cell.append(stock);
                $('table#sampleTable tr#charge'+id).remove();
                var totals =document.getElementsByName("tot_charge_amt[]");
                var sum1 = 0;
                for (var j = 0, iLen = totals.length; j < iLen; j++) {
                    if (totals[j].value!==""){
                        val=parseFloat(totals[j].value);
                        sum1 +=val;
                    }
                }
                var grant_tot = document.getElementById('grand_total').value;
                var sub_tot1 = parseFloat(sum1) + parseFloat(grant_tot);
                document.getElementById('sub_tot').value = parseFloat(sub_tot1).toFixed(2);
                var sub_tot =document.getElementById('sub_tot').value;
                var tax = 2.42;
                var total = parseFloat (sub_tot * tax / 100);
                document.getElementById('insurance').value = parseFloat(total).toFixed(3);
                var insurance =parseFloat(total).toFixed(3);
                var igst =document.getElementById('igst').value;
                if(igst == '')
                {
                    var gst = document.getElementById('gst').value;
                    var trans =document.getElementById('transport').value;
                    var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                    document.getElementById('sgst').value = parseFloat(sum).toFixed(2);
                    document.getElementById('cgst').value = parseFloat(sum).toFixed(2);
                    var sgst = document.getElementById('sgst').value;
                    var cgst = document.getElementById('cgst').value;
                    var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(sgst) + parseFloat(cgst) + parseFloat(trans));
                    document.getElementById('gross_tot').value = parseInt(grant);
                }
                else
                {
                    var gst = 18;
                    var trans =document.getElementById('transport').value;
                    var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                    document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                    var iisgst = document.getElementById('igst').value;
                    var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst)+ parseFloat(trans));
                    document.getElementById('gross_tot').value = parseInt(grant);
                }
                number_to_words();
            }
        }
        //** Chasnge Transport**/
        function change_transport(val) {
            var igst =document.getElementById('igst').value;
            var sub_tot =document.getElementById('sub_tot').value;
            var insurance =document.getElementById('insurance').value;
            if(igst == '')
            {
                var gst = document.getElementById('gst').value;
                var trans =document.getElementById('transport').value;
                var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                document.getElementById('sgst').value = parseFloat(sum).toFixed(2);
                document.getElementById('cgst').value = parseFloat(sum).toFixed(2);
                var sgst = document.getElementById('sgst').value;
                var cgst = document.getElementById('cgst').value;
                var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(sgst) + parseFloat(cgst) + parseFloat(trans));
                document.getElementById('gross_tot').value = parseInt(grant);
            }
            else
            {
                var gst = 18;
                var trans =document.getElementById('transport').value;
                var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                var iisgst = document.getElementById('igst').value;
                var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst)+ parseFloat(trans));
                document.getElementById('gross_tot').value = parseInt(grant);
            }
            number_to_words();
        }

        /** Change Charge count */
        function change_charge_count(id) {
            var holes = document.getElementById('charges_count'+id).value;
            var amt = document.getElementById('charges_value'+id).value;
            var total =  parseInt(holes * amt);
            document.getElementById('tot_charge_amt'+id).value=total;
                var totals =document.getElementsByName("tot_charge_amt[]");
                var sum = 0;
                for (var j = 0, iLen = totals.length; j < iLen; j++) {
                    if (totals[j].value!==""){
                        val=parseFloat(totals[j].value);
                        sum +=val;
                    }
                }
                var grant_tot = document.getElementById('grand_total').value;
                var sub_tot = parseFloat(sum) + parseFloat(grant_tot);
                document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
                var sub_tot1 =document.getElementById('sub_tot').value;

                var tax = 2.42;
                var total = parseFloat (sub_tot1 * tax / 100);
                document.getElementById('insurance').value = parseFloat(total).toFixed(3);
                var insurance =parseFloat(total).toFixed(3);
                var igst =document.getElementById('igst').value;
                if(igst == '')
                {
                    var gst = document.getElementById('gst').value;
                    var trans =document.getElementById('transport').value;
                    var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                    document.getElementById('sgst').value = parseFloat(sum).toFixed(2);
                    document.getElementById('cgst').value = parseFloat(sum).toFixed(2);
                    var sgst = document.getElementById('sgst').value;
                    var cgst = document.getElementById('cgst').value;
                    var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(sgst) + parseFloat(cgst) +  parseFloat(trans));
                    document.getElementById('gross_tot').value = parseInt(grant);
                }
                else
                {

                    var gst = 18;
                    var trans =document.getElementById('transport').value;
                    var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                    document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                    var iisgst = document.getElementById('igst').value;
                    var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst) +  parseFloat(trans));
                    document.getElementById('gross_tot').value = parseInt(grant);
                }
            number_to_words();


        }
        /** Change Charge count */
        /** Change Charge value */
        function change_charge_value(id) {
            var holes = document.getElementById('charges_count'+id).value;
            var amt = document.getElementById('charges_value'+id).value;
            var total =  parseInt(holes * amt);
            document.getElementById('tot_charge_amt'+id).value=total;
            var totals =document.getElementsByName("tot_charge_amt[]");
            var sum = 0;
            for (var j = 0, iLen = totals.length; j < iLen; j++) {
                if (totals[j].value!==""){
                    val=parseFloat(totals[j].value);
                    sum +=val;
                }
            }
            var grant_tot = document.getElementById('grand_total').value;
            var sub_tot = parseFloat(sum) + parseFloat(grant_tot);
            document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
            var sub_tot1 =document.getElementById('sub_tot').value;

            var tax = 2.42;
            var total = parseFloat (sub_tot1 * tax / 100);
            document.getElementById('insurance').value = parseFloat(total).toFixed(3);
            var insurance =parseFloat(total).toFixed(3);
            var igst =document.getElementById('igst').value;
            if(igst == '')
            {
                var gst = document.getElementById('gst').value;
                var trans =document.getElementById('transport').value;
                var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                document.getElementById('sgst').value = parseFloat(sum).toFixed(2);
                document.getElementById('cgst').value = parseFloat(sum).toFixed(2);
                var sgst = document.getElementById('sgst').value;
                var cgst = document.getElementById('cgst').value;
                var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(sgst) + parseFloat(cgst) +  parseFloat(trans));
                document.getElementById('gross_tot').value = parseInt(grant);
            }
            else
            {
                var gst = 18;
                var trans =document.getElementById('transport').value;
                var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                var iisgst = document.getElementById('igst').value;
                var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst) +  parseFloat(trans));
                document.getElementById('gross_tot').value = parseInt(grant);
            }
            number_to_words();


        }
        /** Change Charge value */

        // Number into words
        function number_to_words() {
            var th = ['', 'thousand', 'million', 'billion', 'trillion'];

            var dg = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];

            var tn = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];

            var tw = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

            var s = document.getElementById('gross_tot').value;

            s = s.toString();
            s = s.replace(/[\, ]/g, '');
            if (s != parseFloat(s)) return 'not a number';
            var x = s.indexOf('.');
            if (x == -1) x = s.length;
            if (x > 15) return 'too big';
            var n = s.split('');
            var str = '';
            var sk = 0;
            for (var i = 0; i < x; i++) {
                if ((x - i) % 3 == 2) {
                    if (n[i] == '1') {
                        str += tn[Number(n[i + 1])] + ' ';
                        i++;
                        sk = 1;
                    } else if (n[i] != 0) {
                        str += tw[n[i] - 2] + ' ';
                        sk = 1;
                    }
                } else if (n[i] != 0) {
                    str += dg[n[i]] + ' ';
                    if ((x - i) % 3 == 0) str += 'hundred ';
                    sk = 1;
                }
                if ((x - i) % 3 == 1) {
                    if (sk) str += th[(x - i - 1) / 3] + ' ';
                    sk = 0;
                }
            }
            document.getElementById('word').innerHTML = str;
            if (x != s.length) {
                var y = s.length;
                str += 'point ';
                for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
            }
            return str.replace(/\s+/g, ' ');
        }

    </script>

