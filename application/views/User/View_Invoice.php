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
                <form method="post" class="login-form" action="<?php echo site_url('User_Controller/Save_Invoice'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Save PI?');">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Consignee</h5>
                            <div class="form-group ">
                                <label class="control-label">Customer Name </label>
                                <input  class="form-control" name="search_data" id="search_data" type="text"   onkeyup="ajaxSearch();" required>
                                <input  class="form-control" name="company_name" id="company_name" type="hidden"   ">
                            </div>
                            <div id="suggestions">
                                <div id="autoSuggestionsList"></div>
                            </div>
                            <div id="consign">
                                <h5 id="coustomer"></h5>
                                <h5 id="address"></h5>
                                <h5 id="phone"></h5>
                                <h5 id="gstn"></h5>
                            </div>

                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <input type="checkbox" name="check" id="check" checked onclick="FillBilling()">
                                <em>Check this box if Consigee and   Buyer are the same.</em>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <h5>Buyer (if other than consignee)</h5>
                            <div class="form-group ">
                                <label class="control-label">Customer Name </label>
                                <select name="company_address" class="form-control" id="company_name2" >
                                    <option>Select Another Address</option>
                                </select>
                            </div>
                            <div id="Buyer">
                                <h5 id="coustomer1"></h5>
                                <h5 id="address1"></h5>
                                <h5 id="phone1"></h5>
                                <h5 id="gstn1"></h5>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <h4>Proforma Invoice No: <input type="text" name="invoice_no" id="invoice_no" value="<?php echo $profoma_number; ?>" readonly></h4>
                            <h4>Proforma Invoice Date: <input type="text" name="invoice_date" id="invoice_date" value="<?php echo date('Y-m-d'); ?>" readonly></h4>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                            <th>#</th>
                            <th>Material</th>
                            <th>Thickness</th>
                            <th>Actual<br>size(h)</th>
                            <th>Actual<br>size(w)</th>
                            <th>Chargable<br>size(h)</th>
                            <th>Chargable<br>size(w)</th>
                            <th>No.of<br>Pieces</th>
                            <th>No.of<br>Holes</th>
                            <th>Cutouts</th>
                            <th>Special</th>
                            <th>Area<br>(sqmtr)</th>
                            <th>Rate<br>(sqmtr)</th>
                            <th>Total<br>Rs</th>
                            </thead>
                            <tbody>
                            <?php $i=1; foreach ($invoice as $key) { ?>
                                <tr id="row<?php echo $i; ?>">
                                    <td><?php echo $i; ?></td>
                                    <td>     <div class="form-group">
                                            <select name="material[]" class="form-control" id="material<?php echo $i; ?>" onclick="get_result('<?php echo $i; ?>')" required >
                                                <option value="" >Select material</option>
                                                <?php foreach ($stock as $row):
                                                {
                                                    echo '<option value= "'.$row['Material_Icode'].'">' . $row['Material_Name'] . '</option>';
                                                }
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </td>
                                    <!--                                    <div id="suggestions_material">-->
                                    <!--                                        <div id="autoSuggestionsList_material"></div>-->
                                    <!--                                    </div>-->
                                    <td><input class="form-control" type="hidden" name="hsn[]" id="hsn<?php echo $i; ?>" readonly ><input class="form-control" type="hidden" name="thickness[]" id="thckness<?php echo $i; ?>" value="<?php echo $key['Thickness']; ?>" readonly><?php echo $key['Thickness']; ?></td>
                                    <td><input class="form-control" type="hidden" name="height[]" id="height<?php echo $i; ?>" value="<?php echo $key['height']; ?>" readonly><?php echo $key['height']; ?></td>
                                    <td><input class="form-control" type="hidden" name="width[]" id="width<?php echo $i; ?>" value="<?php echo $key['width']; ?>" readonly><?php echo $key['width']; ?></td>
                                    <td><input class="form-control" type="number" name="ch_height[]" id="ch_height<?php echo $i; ?>" value="<?php echo $key['ch_height']; ?>" onkeyup="change_Charge_Height('<?php echo $i; ?>')" ></td>
                                    <td><input class="form-control" type="number" name="ch_weight[]" id="ch_weight<?php echo $i; ?>" value="<?php echo $key['ch_weight']; ?>" onkeyup="change_Charge_Width('<?php echo $i; ?>')" ></td>
                                    <td><input class="form-control" type="hidden" name="pics[]" id="pics<?php echo $i; ?>" value="<?php echo $key['pics']; ?>" readonly><?php echo $key['pics']; ?></td>
                                    <td><input class="form-control" type="hidden" name="holes[]" id="holes<?php echo $i; ?>" value="<?php echo $key['holes']; ?>" readonly><?php echo $key['holes']; ?></td>
                                    <td><input class="form-control" type="hidden" name="cutout[]" id="cutout<?php echo $i; ?>" value="<?php echo $key['cutout']; ?>" readonly><?php echo $key['cutout']; ?></td>
                                    <td><input class="form-control" type="hidden" name="type[]" id="type<?php echo $i; ?>" value="<?php echo $key['type']; ?>" readonly><?php echo $key['type']; ?></td>
                                     <?php
                                    if($key['area'] > 5)
                                    {
                                        ?>
                                        <td><input class="form-control new_area pi_textbox" style="color: red;" type="text" name="area[]" id="area<?php echo $i; ?>" value="<?php echo $key['area']; ?>" readonly></td>

                                        <?php
                                    }
                                    else{
                                        ?>
                                        <td><input class="form-control new_area1 pi_textbox" type="text"  name="area[]" id="area<?php echo $i; ?>" value="<?php echo $key['area']; ?>" readonly></td>

                                    <?php }
                                    ?>
                                    <td><input class="form-control" type="number" name="rate[]" id="rate<?php echo $i; ?>" onkeyup="change_rate('<?php echo $i; ?>')" ></td>
                                    <td><input class="form-control" type="text" name="total[]" id="total<?php echo $i; ?>" readonly ></td>

                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id="total_pic1"><input type="hidden" class="form-control pull-right" id="total_pic" readonly/></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id="total_area1"><input type="hidden" class="form-control pull-right" id="total_area" value="0"   readonly/></td>
                                <td></td>
                                <td> <input type="text" class="form-control pull-right" id="grand_total" value="0"   readonly/>(INR)</td>
                            </tr>
                            </tfoot>
                        </table>
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
                            <h3 style="font-size: 15px;">Terms & Conditions</h3>
                            <p style="font-size: 8px;text-align: justify;">
                                Supply shall be against advance payment or Letter of credit or any other agreed
                                terms. Interest @2% per month will be charged for the payment delayed beyond
                                the terms agreed from the date of invoice. All payments made by third
                                party/consumer/contractor interested in the transaction shall be adjusted against
                                supplies made to buyer/consignee
                            </p>
                            <h3 style="font-size: 15px;">Dear Customer</h3>
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
                                <th>Select Charges</th>
                                <th>No.of pieces</th>
                                <th>Price</th>
                                <th>Total</th>
                                </thead>
                                <tbody></tbody>
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
                                    <td><input class="form-control" type="number" name="charge_amt[]" id="charge_amt" ></td>
                                    <td><input class="form-control" type="text" name="tot_charge_amt[]" id="tot_charge_amt"  readonly></td>
                                    <td><input type="button" onclick="Add_one()" value="Add" id="Add" /></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">SUB-TOTAL</td>

                                    <td><input class="form-control" type="text" name="sub_tot" id="sub_tot" readonly ></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">HANDLING CHARGES</td>

                                    <td><input class="form-control" type="number" name="insurance" id="insurance" required readonly></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">TRANSPORT</td>

                                    <td><input class="form-control" type="number" name="transport" id="transport" onkeyup="change_transport(this.value)" required  ></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><input  type="radio" id="ptype" name="tax" value="igst"  required onclick="isgt()"> IGST</td>
                                    <td>
                                        <input  type="radio" id="ptype2" name="tax" value="gst"  onclick="GST()" required> SGST/CGST
                                    </td>
                                </tr>
                                <tr id="sgst1" style="display: none">
                                    <td colspan="3" align="right">SGST @<?php echo $tax[0]['SGST%']; ?></td>

                                    <td><input class="form-control" type="text" name="sgst" id="sgst"  readonly ></td>
                                    <td></td>
                                </tr>
                                <tr id="cgst1" style="display: none">
                                    <td colspan="3" align="right">CGST @<?php echo $tax[0]['CGST%']; ?>
                                        <input type="hidden" id="gst" value="<?php echo $tax[0]['CGST%']; ?>">
                                    </td>
                                    <td><input class="form-control" type="text" name="cgst" id="cgst"  readonly ></td>
                                    <td></td>
                                </tr>
                                <tr id="igst1" style="display: none">
                                    <td colspan="3" align="right">IGST @18%

                                    </td>
                                    <td><input class="form-control" type="text" name="igst" id="igst" readonly ></td>
                                    <td></td>
                                </tr>
                                <tr>

                                    <td colspan="3" align="right">GROSS TOTAL</td>
                                    <td><input class="form-control" type="text" name="gross_tot" id="gross_tot" readonly ></td>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div>Amount in Words: <span id="word"></span></div>
                        <script>
                            $('#insurance').click(function () {
                                var sub_tot =document.getElementById('sub_tot').value;
                                var tax = 2.42;
                                var total = parseFloat (sub_tot * tax / 100);
                                document.getElementById('insurance').value = parseFloat(total).toFixed(3);
                            });
                        </script>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Confirm PI</button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</main>
<!--<script>$('#sampleTable').DataTable({-->
<!--        scrollX: true,-->
<!--    });</script>-->
<style>
    .st_check{
        padding-top: 15px;
        border-top: 1px solid #000000;
        text-align: center;
    }
    #search_data {
        width: 200px;
        padding: 5px;
        margin: 5px 0;
        box-sizing: border-box;
    }
    #autoSuggestionsList {
        z-index: 99;
        max-height: 400px;
        overflow-y: auto;
        min-height: auto;
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

    /* For Firefox */
    input[type='number'] {
        -moz-appearance:textfield;
    }
    /* Webkit browsers like Safari and Chrome */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .table thead th
    {
        font-size: 12px;
    }

</style>


<script>
    $( document ).ready(function() {
        var areas =document.getElementsByName("area[]");
        var sum_area = 0;
        for (var j = 0, iLen = areas.length; j < iLen; j++) {
            if (areas[j].value!==""){
                val=parseFloat(areas[j].value);
                sum_area +=val;
            }
        }
        document.getElementById('total_area').value=sum_area;
        document.getElementById('total_area1').innerHTML = sum_area;
        var pices =document.getElementsByName("pics[]");
        var sum_pic = 0;
        for (var j = 0, iLen = pices.length; j < iLen; j++) {
            if (pices[j].value!==""){
                val=parseFloat(pices[j].value);
                sum_pic +=val;
            }
        }

        document.getElementById('total_pic').value = parseInt(sum_pic);
        document.getElementById('total_pic1').innerHTML = parseInt(sum_pic);
    });

    // Get Company Addresss
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


    // No of  Pieces
    $("#no_holes").on('change keyup paste', function() {
        var holes = parseInt($('#no_holes').val());
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
        var tax = 2.42;
        var totals = parseFloat (sub_tot * tax / 100);
        document.getElementById('insurance').value = parseFloat(totals).toFixed(3);
        var insurance = totals;
        if ($('input[name=tax]:checked').length > 0) {
            var res = $('input:radio[name="tax"]:checked').val();
            if(res == 'gst')
            {
                var gst = document.getElementById('gst').value;
                var trans =parseFloat(document.getElementById('transport').value);
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
                var trans =parseFloat(document.getElementById('transport').value);
                var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                var iisgst = document.getElementById('igst').value;
                var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst)+ parseFloat(trans));
                document.getElementById('gross_tot').value = parseInt(grant);
            }
            number_to_words();
        }
        else
        {

        }

    });


    // Charge Amount
    $("#charge_amt").on('change keyup paste', function() {
        var amt = parseInt($('#charge_amt').val());
        var holes = parseInt($('#no_holes').val());
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
        var tax = 2.42;
        var totals = parseFloat (sub_tot * tax / 100);
        document.getElementById('insurance').value = parseFloat(totals).toFixed(3);
        var insurance = totals;
        if ($('input[name=tax]:checked').length > 0) {
            var res = $('input:radio[name="tax"]:checked').val();
            if(res == 'gst')
            {

                var gst = document.getElementById('gst').value;
                var trans =parseFloat(document.getElementById('transport').value);
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
                var trans =parseFloat(document.getElementById('transport').value);
                var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                var iisgst = document.getElementById('igst').value;
                var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst)+ parseFloat(trans));
                document.getElementById('gross_tot').value = parseInt(grant);
            }
            number_to_words();
        }
        else
        {

        }

    });


    // get Charges
    $("#charges").change(function () {
        var pics=document.getElementById('no_holes').value;
        var amt=document.getElementById('charge_amt').value;
        $.ajax({
            url:"<?php echo site_url('User_Controller/Edit_Charges'); ?>",
            data: {id:
                $(this).val()},
            type: "POST",
            success:function(server_response){
                var data = $.parseJSON(server_response);
                var  price = data[0]['charge_current_price'];
                document.getElementById('charge_amt').value = price;
                var total =  parseInt(pics * price);
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
                var tax = 2.42;
                var totals = parseFloat (sub_tot * tax / 100);
                document.getElementById('insurance').value = parseFloat(totals).toFixed(3);
                var insurance = totals;
                if ($('input[name=tax]:checked').length > 0) {
                    var res = $('input:radio[name="tax"]:checked').val();
                    if(res == 'gst')
                    {

                        var gst = document.getElementById('gst').value;
                        var trans =parseFloat(document.getElementById('transport').value);
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
                        var trans =parseFloat(document.getElementById('transport').value);
                        var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                        document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                        var iisgst = document.getElementById('igst').value;
                        var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst)+ parseFloat(trans));
                        document.getElementById('gross_tot').value = parseInt(grant);
                    }
                    number_to_words();
                }
                else
                {

                }

            }
        });
    });

    // Add more Charges
    $("#Add").click(function () {
        if($('#charges').val() == "")
        {
            alert("Please Select Charges...");
        }
        else if($('#no_holes').val() == ""){
            alert("Please enter No.of pieces...");
        }
        else if($('#charge_amt').val() == '0')
        {
            alert("Please Enter Charges Amount..")
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
    //Add Charges Row
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

    //Remove Charges
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
            var tax = 2.42;
            var totals = parseFloat (sub_tot * tax / 100);
            document.getElementById('insurance').value = parseFloat(totals).toFixed(3);
            var insurance =parseFloat(totals).toFixed(3);

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
    };

    // Check box Customer
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

    // get Material Based Charges
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

                    var hsn = data[0]['HSN_Code'];
                    document.getElementById('hsn'+id).value = hsn;
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

                    var pices =document.getElementsByName("pics[]");
                    var sum_pic = 0;
                    for (var j = 0, iLen = pices.length; j < iLen; j++) {
                        if (pices[j].value!==""){
                            val=parseFloat(pices[j].value);
                            sum_pic +=val;
                        }
                    }
                    document.getElementById('total_pic').value = parseInt(sum_pic);
                }
            });



        });

    }

    // Change Charge Rate
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

    //Search Customer
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

    // Onselect Customer Get Customer Address
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

    //IGST Function
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

    //GST Function
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

    /** Change Charge Height */
    function change_Charge_Height(id) {
        var actual_H = document.getElementById('height'+id).value;
        var Charge_W = document.getElementById('ch_weight'+id).value;
        var Charge_H = document.getElementById('ch_height'+id).value;
        if(actual_H > Charge_H)
        {
            alert("Chargable Height should be greater then Actual Height ");
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

            if ($('input[name=tax]:checked').length > 0) {
                var res = $('input:radio[name="tax"]:checked').val();
                if(res == 'gst')
                {
                    var gst = document.getElementById('gst').value;
                    var trans =parseFloat(document.getElementById('transport').value);
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
                    var trans =parseFloat(document.getElementById('transport').value);
                    var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                    document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                    var iisgst = document.getElementById('igst').value;
                    var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst)+ parseFloat(trans));
                    document.getElementById('gross_tot').value = parseInt(grant);
                }
                number_to_words();
            }
            else
            {

            }

        }

    }
    /** Change Charge Height */

    /** Change Charge Width */
    function change_Charge_Width(id) {
        var actual_W = parseFloat(document.getElementById('width'+id).value);
        var Charge_W = parseFloat(document.getElementById('ch_weight'+id).value);
        var Charge_H = document.getElementById('ch_height'+id).value;

        if(actual_W > Charge_W)
        {
            alert("Chargable Width should be greater then Actual Width");
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

            if ($('input[name=tax]:checked').length > 0) {
                var res = $('input:radio[name="tax"]:checked').val();
                if(res == 'gst')
                {
                    var gst = document.getElementById('gst').value;
                    var trans =parseFloat(document.getElementById('transport').value);
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
                    var trans =parseFloat(document.getElementById('transport').value);
                    var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                    document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                    var iisgst = document.getElementById('igst').value;
                    var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst)+ parseFloat(trans));
                    document.getElementById('gross_tot').value = parseInt(grant);
                }
                number_to_words();
            }
            else
            {

            }


        }

    }
    /** Change Charge Width */

    //** Chasnge Transport**/
    function change_transport(val) {
        var igst =document.getElementById('igst').value;
        var sub_tot =document.getElementById('sub_tot').value;
        var insurance =document.getElementById('insurance').value;

        if ($('input[name=tax]:checked').length > 0) {
            var res = $('input:radio[name="tax"]:checked').val();
            if(res == 'gst')
            {
                var gst = document.getElementById('gst').value;
                var trans =parseFloat(document.getElementById('transport').value);
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
                var trans =parseFloat(document.getElementById('transport').value);
                var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                var iisgst = document.getElementById('igst').value;
                var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst)+ parseFloat(trans));
                document.getElementById('gross_tot').value = parseInt(grant);
            }
            number_to_words();
        }
        else
        {

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

