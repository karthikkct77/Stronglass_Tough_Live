<main class="app-content">
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>Profoma Invoice</h1>
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
            <div class="col-md-12" >

                <div class="tile">
                    <div class="row invoice">
                        <img style="position: absolute;width: 100px;height: auto;top: 1%;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
                        <h4><?php echo $st[0]['ST_Name']; ?></h4>
                        <h5><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?></h5>
                        <h6><span>Mob: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
                    </div>
                    <hr>
                    <form method="post" class="login-form" action="<?php echo site_url('User_Controller/Barcode'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Save ?');">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Consignee</h5>
                                <div id="consign">
                                    <h5 id="coustomer"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
                                    <h5 id="address"><?php echo $invoice[0]['Customer_Address_1']; echo '&nbsp'; ?>,<?php echo $invoice[0]['Customer_Address_2']; echo '&nbsp';?>,<?php echo $invoice[0]['Customer_Area']; ?></h5>
                                    <h5> <?php echo $invoice[0]['Customer_City']; echo '&nbsp'; ?><?php echo $invoice[0]['Customer_State']; ?></h5>
                                    <h5 id="phone">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></h5>
                                    <h5 id="email">Email: <?php echo $invoice[0]['Customer_Email_Id_1']; ?></h5>
                                    <h5 id="gstn">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></h5>
                                    <input type="hidden" name="email" value="<?php echo $invoice[0]['Customer_Email_Id_1']; ?>">
                                </div>

                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <!--                                <input type="checkbox" name="check" id="check" checked onclick="FillBilling()">-->
                                    <!--                                <em>Check this box if Current Address and Mailing permanent are the same.</em>-->
                                </div>

                            </div>
                            <div class="col-md-4">
                                <h5>Buyer (if other than consignee)</h5>
                                <div id="Buyer">
                                    <?php
                                    if($invoice[0]['Customer_Address_Icode'] == "")
                                    {
                                        ?>
                                        <h5 id="coustomer"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
                                        <h5 id="address"><?php echo $invoice[0]['Customer_Address_1']; echo '&nbsp'; ?>,<?php echo $invoice[0]['Customer_Address_2']; echo '&nbsp';?>,<?php echo $invoice[0]['Customer_Area']; ?></h5>
                                        <h5> <?php echo $invoice[0]['Customer_City']; echo '&nbsp'; ?><?php echo $invoice[0]['Customer_State']; ?></h5>
                                        <h5 id="phone">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></h5>
                                        <h5 id="email">Email: <?php echo $invoice[0]['Customer_Email_Id_1']; ?></h5>
                                        <h5 id="gstn">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></h5>
                                        <input type="hidden" name="email" value="<?php echo $invoice[0]['Customer_Email_Id_1']; ?>">
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <h5 id="coustomer"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
                                        <h5 id="address"><?php echo $invoice[0]['Customer_Add_Address_1']; ?>&nbsn;<?php echo $invoice[0]['Customer_Add_Address_2']; ?></h5>
                                        <h5 id="phone">City: <?php echo $invoice[0]['Customer_Add_City']; ?></h5>
                                        <h5 id="phone">Phone: <?php echo $invoice[0]['Customer_Add_Phone']; ?></h5>
                                        <h5 id="gstn">GSTN: <?php echo $invoice[0]['Customer_Add_Email_Id_1']; ?></h5>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" type="hidden" name="PI_Icode"  id="PI_Icode" value="<?php echo $invoice[0]['Proforma_Icode']; ?>" >
                                <h4>Proforma Invoice No: <input type="text" name="invoice_no" id="invoice_no" value="<?php echo $invoice[0]['Proforma_Number']; ?>" readonly></h4>
                                <h4>Proforma Invoice Date: <input type="text" name="invoice_date" id="invoice_date" value="<?php echo $invoice[0]['Proforma_Date']; ?>" readonly></h4>
                            </div>
                        </div>
                        <h6 style="text-align: center">Total Number of Sheets used to Cut the following glasses</h6>
                        <div class="row">
                            <table class="table table-hover table-bordered" id="sampleTable2">
                                <thead>
                                <th>#</th>
                                <th>Select Material</th>
                                <th>No.of sheet</th>
                                <th>Act<br>Size(h)</th>
                                <th>Act<br>Size(w)</th>
                                <th>cha<br>Size(h)</th>
                                <th>cha<br>Size(w)</th>
                                <th>Area</th>
                                <th>Rate</th>
                                <th>Amount</th>

                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                <?php $i=1; foreach ($sheet as $key) { ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $key['Material_Name']; ?></td>
                                    <td><?php echo $key['No_Of_Sheet']; ?></td>
                                    <td><?php echo $key['Actual_Height']; ?></td>
                                    <td><?php echo $key['Actual_Width']; ?></td>
                                    <td><?php echo $key['Chargable_Height']; ?></td>
                                    <td><?php echo $key['Chargable_Width']; ?></td>
                                    <td><?php echo $key['Area']; ?></td>
                                    <td><?php echo $key['Rate']; ?></td>
                                    <td><?php echo $key['Total_Amount']; ?></td>
                                </tr>
                                </tfoot>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="row">
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                <th>#</th>
                                <th>Material</th>
                                <th>Actual<br>size(H)</th>
                                <th>Actual<br>size(W)</th>
                                <th>No.of<br>Pieces</th>
                                <th>No.of<br>Holes</th>
                                <th>Cutouts</th>
                                <th>Special</th>
                                <th>Area<br>(SQMTR)</th>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach ($invoice_item as $key) { ?>
                                    <input class="form-control" type="hidden" name="material[]"  value="<?php echo $key['pi_item_sheet_icode']; ?>" >
                                    <input class="form-control" type="hidden" name="pics[]"  value="<?php echo $key['Proforma_Qty']; ?>" >
                                    <tr id="row<?php echo $i; ?>">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $key['Material_Name']; ?></td>
                                        <td><?php echo $key['Proforma_Actual_Size_Width']; ?></td>
                                        <td><?php echo $key['Proforma_Actual_Size_Height']; ?></td>
                                        <td><?php echo $key['Proforma_Qty']; ?></td>
                                        <td><?php echo $key['Proforma_Holes']; ?></td>
                                        <td><?php echo $key['Proforma_Cutout']; ?></td>
                                        <td><?php echo $key['Proforma_Special']; ?></td>
                                        <td><?php echo $key['Proforma_Area_SQMTR']; ?></td>
                                    </tr>
                                    <?php $i++; } ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><input type="hidden" class="form-control pull-right" id="total_pic" value="<?php echo $invoice_total[0]['qty']; ?>"readonly/><?php echo $invoice_total[0]['qty']; ?></td>
                                    <td></td>
                                    <td><?php echo $invoice_total[0]['cutout']; ?></td>
                                    <td></td>
                                    <td><input type="hidden" class="form-control pull-right" id="total_area" value="<?php echo round($invoice_total[0]['area'], 2); ?>"   readonly/><?php echo round($invoice_total[0]['area'], 3); ?></td>

                                </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h3 style="font-size: 15px;">Terms & Conditions</h3>
                                <p style="font-size: 8px;text-align: justify;">
                                    Supply shall be against advance payment or Letter of credit or any other agreed
                                    terms. Interest @2% per month will be charged for the payment delayed beyond
                                    the terms agreed from the date of invoice. All payments made by third
                                    party/consumer/contractor interested in the transaction shall be adjusted against
                                    supplies made to buyer/consignee
                                </p>
                                <h3 style="font-size: 8px;">Dear Customer</h3>
                                <p style="font-size: 8px;text-align: justify;">
                                <ul style="list-style: none;padding: 0;font-size: 8px;text-align: justify;">
                                    <li style="margin-bottom: 15px;">
                                        1.Please make sure to DOUBLE - CHECK the Pro-Forma Invoice in terms Billing & Delivery Address, Contact Name & Number, PAN NO, GST NO, complete Glass
                                        Specifications, Size, Quantity, Rates & Taxes.
                                    </li>
                                    <li style="margin-bottom: 15px;">
                                        2.If there is any item not as per your requirement, please get the same modified to be reflected in the Pro-Forma Invoice before confirmation. PI terms mentioned are
                                        final and shall supersede PO terms, no dispute will be entertained after order released for production pertaining to terms agreed in Pro-Forma invoice.
                                    </li>
                                    <li>
                                        3.In the event the order is modified or cancelled once issued to production, all material expenses, processing costs and cancellation penalties up to the date of
                                        modification or cancellation shall be invoiced. The amount to be invoiced is solely at the discretion of the Seller and shall be final and non-negotiable
                                    </li>
                                </ul>
                                </p>
                                <h4>Bank Details</h4>
                                <h5>Stronglass Tough</h5>
                                <h5>A/C Type: <span><?php echo $st[0]['ST_Bank_Account_Type']; ?></span></h5>
                                <h5>A/C Number: <span><?php echo $st[0]['ST_Bank_Account_Number']; ?></span></h5>
                                <h5>Name: <span><?php echo $st[0]['ST_Bank']; ?></span></h5>
                                <h5>IFSC:<span><?php echo $st[0]['ST_Bank_Account_IFSC_Code']; ?></span> </h5>

                            </div>
                            <div class="col-md-6">
                                <table class="table table-hover table-bordered" id="sampleTable1">
                                    <thead>
                                    <th>#</th>
                                    <th>Select Charges</th>
                                    <th>No.of pieces</th>
                                    <th>Price</th>
                                    <th>Total(INR)</th>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                    <?php
                                    $i=1;
                                    foreach ($invoice_Charges as $key) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $key['charge_name']; ?></td>
                                            <td><?php echo $key['Proforma_Charge_Count']; ?></td>
                                            <td><?php echo $key['Proforma_Charge_Value']; ?></td>
                                            <td><?php echo $key['Proforma_Charge_Cost']; ?></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="4" align="right">SUB-TOTAL</td>

                                        <td><input class="form-control" type="text" name="sub_tot" id="sub_tot" value="<?php echo $invoice[0]['Sub_Total']; ?>" readonly ></td>

                                    </tr>
                                    <tr>
                                        <td colspan="4" align="right">HANDLING CHARGE</td>

                                        <td><input class="form-control" type="text" name="insurance" id="insurance" value="<?php echo $invoice[0]['Insurance_Value']; ?>" required readonly></td>

                                    </tr>
                                    <tr>
                                        <td colspan="4" align="right">TRANSPORT</td>

                                        <td><input class="form-control" type="text" name="transport" id="transport"  value="<?php echo $invoice[0]['Transport']; ?>" readonly></td>

                                    </tr>
                                    <?php
                                    if($invoice[0]['IGST_Value'] == '0')
                                    { ?>
                                        <tr>
                                            <td colspan="4" align="right">SGST @<?php echo $tax[0]['SGST%']; ?></td>

                                            <td><input class="form-control" type="text" name="sgst" id="sgst" value="<?php echo $invoice[0]['SGST_Value']; ?>"readonly ></td>

                                        </tr>
                                        <tr>
                                            <td colspan="4" align="right">CGST @<?php echo $tax[0]['CGST%']; ?>
                                                <input type="hidden" id="gst" value="<?php echo $tax[0]['CGST%']; ?>">
                                            </td>
                                            <td><input class="form-control" type="text" name="cgst" id="cgst" value="<?php echo $invoice[0]['CGST_Value']; ?>" readonly ></td>

                                        </tr>

                                    <?php }
                                    else
                                    {?>
                                        <tr>
                                            <td colspan="4" align="right">IGST @18%
                                                <input type="hidden" id="gst" value="18">
                                            </td>
                                            <td><input class="form-control" type="text" name="igst" id="igst" value="<?php echo $invoice[0]['IGST_Value']; ?>" readonly ></td>

                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>

                                        <td colspan="4" align="right">GROSS TOTAL</td>
                                        <td><input class="form-control" type="text" name="gross_tot" id="gross_tot" readonly value="<?php echo $invoice[0]['GrossTotal_Value']; ?>" >(INR)</td>

                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div>Amount in Words: <span id="word" style="font-size: 20px;margin-left: 10px;"></span></div>
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
                            </div>
                            <div class="col-md-6">
                                <?php if($_SESSION['role'] == 6) { ?>

                                    <button class="btn btn-danger pi_button" id="with_print" type="submit"><i class="fa fa-fw fa-lg fa-print"></i> Barcode Print</button>
                                    <input type="button" id="with_print" class="btn btn-primary pi_button" onclick="window.print()"value="Print"/>
                                <?php } elseif($_SESSION['role'] == 7){
                                    ?>

                                <?php } ?>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<style type="text/css" media="print">
    @page
    {
        margin: 0mm;  /* this affects the margin in the printer settings */
    }
</style>
<style>
    @media print {
        #with_print {
            display: none;
        }
    }
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
    .pi_button{
        margin-right: 15px;
        float: right;
    }
    .st_check{
        padding-top: 15px;
        border-top: 1px solid #000000;
        text-align: center;
    }
</style>


<script>

    $( document ).ready(function() {
        number_to_words();
    });

    $("#company_name2").change(function () {
        $.ajax({
            url:"<?php echo site_url('Admin_Controller/get_Customer_Address_Details'); ?>",
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
        document.getElementById('tot_charge_amt').value = total;

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
    });
    $("#charges").change(function () {
        $.ajax({
            url:"<?php echo site_url('Admin_Controller/Edit_Charges'); ?>",
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
            AddRow($('#charges').val(), $("#no_holes").val(),$("#charge_amt").val(),$("#tot_charge_amt").val(),chrgs);
            $("#charges").val("");
            $("#no_holes").val("");
            $("#charge_amt").val("");
            $("#tot_charge_amt").val("");
        }
    });
    function AddRow(charges,no_holes,charge_amt,tot_charge_amt,chrgs) {
        var tBody = $("#sampleTable1 > TBODY")[0];
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
            var table = $("#sampleTable1")[0];
            //Delete the Table row using it's Index.
            table.deleteRow(row[0].rowIndex);
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
                url:"<?php echo site_url('Admin_Controller/Edit_Material'); ?>",
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
        document.getElementById('total'+id).value = total;
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

                url:"<?php echo site_url('Admin_Controller/GetCountryName'); ?>",
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

