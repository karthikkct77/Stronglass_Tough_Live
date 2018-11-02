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
    #autoSuggestionsList > li{
        background: none repeat scroll 0 0 #F3F3F3;
        border-bottom: 1px solid #E3E3E3;
        list-style: none outside none;
        padding: 3px 15px 3px 15px;
        text-align: left;
    }
    .modal-content {
        height: 500px;
        overflow-y: scroll;
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
    h4 span{
        float: left;
        width: 100px;
    }
</style>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Proforma Invoice</h1>

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
                <form method="post" class="login-form" action="<?php echo site_url('Admin_Controller/Save_Export_Invoice'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Save PI?');">
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
                            <h4><span>P.INV.No</span>: <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $profoma_number; ?>" readonly><?php echo $profoma_number; ?></h4>
                            <h4><span>Date </span>:<input type="hidden" name="invoice_date" id="invoice_date" value="<?php echo date('Y-m-d'); ?>" readonly><?php echo date('Y-m-d'); ?></h4>
                            <h6><span>Container Type</span>:<input type="text" class="form-control" name="container_type" id="container_type" required> </h6>
                            <h6><span>Payment Terms</span>:<input type="text" class="form-control" name="payment_Terms" id="payment_Terms" required> </h6>
                            <h6><span>Price Term</span>:<input type="text" class="form-control" name="price_Terms" id="price_Terms" required> </h6>
                            <h6><span>Delivery Route</span>:<input type="text" class="form-control" name="Delivery_Route" id="Delivery_Route" required> </h6>



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
                            <th>Chargeable<br>size(h)</th>
                            <th>Chargeable<br>size(w)</th>
                            <th>No.of<br>Holes</th>
                            <th>Cutouts</th>
                            <th>Special</th>
                            <th>No.of<br>Pieces</th>
                            <th>Area<br>(sqmtr)</th>
                            <th>UNIT Price<br>(USD M2)</th>
                            <th>Amount<br>(USD)</th>
                            </thead>
                            <tbody>
                            <?php $i=1; foreach ($invoice as $key) { ?>
                                <tr id="row<?php echo $i; ?>">
                                    <td><?php echo $i; ?>

                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select name="material[]" class="form-control" id="material<?php echo $i; ?>" onchange="get_result('<?php echo $i; ?>')" required >
                                                <option value="" >Select material</option>
                                                <?php foreach ($stock as $row):
                                                {
                                                    echo '<option value= "'.$row['Material_Icode'].'">' . $row['Material_Name'] . '</option>';
                                                }
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </td>


                                    <td style="width: 20px;">
                                        <input class="form-control" type="hidden" name="hsn[]" id="hsn<?php echo $i; ?>" readonly ><input class="form-control" type="hidden" name="thickness[]" id="thckness<?php echo $i; ?>" value="<?php echo $key['Thickness']; ?>" readonly><?php echo $key['Thickness']; ?></td>
                                    <td><input class="form-control" type="hidden" name="height[]" id="height<?php echo $i; ?>" value="<?php echo $key['height']; ?>" readonly><?php echo $key['height']; ?></td>
                                    <td><input class="form-control" type="hidden" name="width[]" id="width<?php echo $i; ?>" value="<?php echo $key['width']; ?>" readonly><?php echo $key['width']; ?></td>
                                    <td style="width: 90px;"><input class="form-control" type="number" name="ch_height[]" id="ch_height<?php echo $i; ?>" value="<?php echo $key['ch_height']; ?>" onkeyup="change_Charge_Height('<?php echo $i; ?>')" ></td>
                                    <td style="width: 90px;"><input class="form-control" type="number" name="ch_weight[]" id="ch_weight<?php echo $i; ?>" value="<?php echo $key['ch_weight']; ?>" onkeyup="change_Charge_Width('<?php echo $i; ?>')" ></td>
                                    <td style="width: 20px;"><input class="form-control" type="hidden" name="holes[]" id="holes<?php echo $i; ?>" value="<?php echo $key['holes']; ?>" readonly><?php echo $key['holes']; ?></td>
                                    <td style="width: 20px;"><input class="form-control" type="hidden" name="cutout[]" id="cutout<?php echo $i; ?>" value="<?php echo $key['cutout']; ?>" readonly><?php echo $key['cutout']; ?></td>
                                    <?php
                                    if($key['type'] == 'T')
                                    { ?>
                                        <td style="width: 20px; color: blue;"><input class="form-control" type="hidden" name="type[]" id="type<?php echo $i; ?>" value="<?php echo $key['type']; ?>" readonly><?php echo $key['type']; ?></td>

                                    <?php } else {?>
                                        <td style="width: 20px;"><input class="form-control" type="hidden" name="type[]" id="type<?php echo $i; ?>" value="<?php echo $key['type']; ?>" readonly><?php echo $key['type']; ?></td>

                                    <?php } ?>
                                    <td style="width: 20px;"><input class="form-control" type="hidden" name="pics[]" id="pics<?php echo $i; ?>" value="<?php echo $key['pics']; ?>" readonly><?php echo $key['pics']; ?></td>


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
                                <td colspan="10" align="right" style="font-weight: bold;" >Total Summary</td>
                                   <td id="total_pic1">
                                       <input type="text" class="form-control " name="total_pic" id="total_pic" readonly/>
                                   </td>

                                <td id="total_area1"><input type="text" class="form-control " name="total_area" id="total_area" value="0"   readonly/></td>
                                <td></td>
                                <td> <input type="text" class="form-control pull-right" name="grand_total" id="grand_total" value="0"   readonly/></td>
                            </tr>
                            </tfoot>
                        </table>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div style="" class="form-group row">
                                <label class="control-label" style="font-weight: bold;">Delivery Period</label>
                                <div class="col-md-8">
                                    <input class="form-control col-md-3" type="text" name="delivery" required>
                                </div>
                            </div>
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
                            <div id="account">
                                <h3 style="font-size: 13px;">Bank Details</h3>
                                <h5><span>Account Name</span> :STRONGLASS TOUGH</h5>
                                <h5><span>Bank Name</span>:<?php echo $st[0]['ST_Bank']; ?></span></h5>
                                <h5><span>Account Number</span>:<?php echo $st[0]['ST_Bank_Account_Number']; ?></h5>
                                <h5><span>IFSC</span>:<?php echo $st[0]['ST_Bank_Account_IFSC_Code']; ?></h5>
                            </div>
                        </div>

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
        document.getElementById('total_area').value=parseFloat(sum_area).toFixed(3);
        document.getElementById('total_area1').innerHTML =  parseFloat(sum_area).toFixed(3);
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

        //Total Holes
        var holes =document.getElementsByName("holes[]");
        var sum_holes = 0;
        for (var j = 0, iLen = holes.length; j < iLen; j++) {
            if (holes[j].value!==""){
                val=parseFloat(holes[j].value);
                sum_holes +=val;
            }
        }
        document.getElementById('total_holes').value = parseInt(sum_holes);
        document.getElementById('total_holes1').innerHTML = parseInt(sum_holes);

        //Total Cutouts
        var cutout =document.getElementsByName("cutout[]");
        var sum_cutout = 0;
        for (var j = 0, iLen = cutout.length; j < iLen; j++) {
            if (cutout[j].value!==""){
                val=parseFloat(cutout[j].value);
                sum_cutout +=val;
            }
        }
        document.getElementById('total_cutout').value = parseInt(sum_cutout);
        document.getElementById('total_cutout1').innerHTML = parseInt(sum_cutout);
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
        var code = id;
        var a = code-1;
        var pices =document.getElementsByName("pics[]");
        var material =document.getElementById('material'+code).value;
        if(code == '1')
        {
            for (var j = 1, iLen = pices.length; j <= iLen; j++) {
                document.getElementById('material'+j).value = material;
            }
        }
        else if(code > a)
        {

            for (var j = code, iLen = pices.length; j <= iLen; j++) {
                document.getElementById('material'+j).value = material;
            }

        }
    }
    // Change Charge Rate
    function change_rate(id) {

        var pcs = document.getElementById('pics'+id).value;
        var area = document.getElementById('area'+id).value;
        var rate = document.getElementById('rate'+id).value;
        var total = (area * rate);
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

        var charge =document.getElementsByName("tot_charge_amt[]");
        var sum_cherge = 0;
        for (var j = 0, iLen = charge.length; j < iLen; j++) {
            if (charge[j].value!==""){
                val=parseFloat(charge[j].value);
                sum_cherge +=val;
            }
            else
            {
                sum_cherge = 0;
            }
        }
        var grant_tot = document.getElementById('grand_total').value;

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

    function ajaxmaterial(id)
    {
        var input_data = $('#material'+id).val();

        if (input_data.length === 0)
        {

            $('#myModal').modal('hide');
        }
        else
        {

            var post_data = {
                'search_data': input_data,
                'item_icode' : id,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            };

            $.ajax({
                type: "POST",
                url:"<?php echo site_url('User_Controller/get_material_name'); ?>",
                data: post_data,
                success: function (data) {
                    // return success
                    if (data.length > 0) {

                        $('#myModal').modal('show');
                        $('#autoSuggestionsList_material').addClass('auto_list');
                        $('#autoSuggestionsList_material').html(data);
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

    //get material
    function Get_search_material(id,item_id) {
        $.ajax({
            url:"<?php echo site_url('User_Controller/get_material_details'); ?>",
            data: {id:
            id},
            type: "POST",
            success:function(server_response){


                $('#myModal').modal('hide');
                var data = $.parseJSON(server_response);
                document.getElementById('material_icode'+item_id).value = data[0]['Material_Icode'];
                document.getElementById('material'+item_id).value = data[0]['Material_Name'];

            }
        });

    }

    function dismiss() {
        $('#myModal').modal('hide');
    }


    /** Change Charge Height */
    function change_Charge_Height(id) {
        var Charge_W = document.getElementById('ch_weight'+id).value;
        var Charge_H = document.getElementById('ch_height'+id).value;

        var pcs = document.getElementById('pics'+id).value;
        var rate = document.getElementById('rate'+id).value;
        var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000 * parseInt(pcs);
        document.getElementById('area'+id).value = parseFloat(areas).toFixed(3);
        var tot = (areas * rate);
        document.getElementById('total'+id).value =  parseFloat(tot).toFixed(3);

        var totals =document.getElementsByName("total[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }
        document.getElementById('grand_total').value = parseFloat(sum).toFixed(2);

        var charge =document.getElementsByName("tot_charge_amt[]");
        var sum_cherge = 0;
        for (var k = 0, iLen = charge.length; k < iLen; k++) {
            if (charge[k].value!==""){
                val=parseFloat(charge[k].value);
                sum_cherge +=val;
            }
            else
            {
                sum_cherge = 0;
            }
        }
        var grant_tot = document.getElementById('grand_total').value;

    }
    /** Change Charge Height */

    /** Change Charge Width */
    function change_Charge_Width(id) {
        var actual_W = parseFloat(document.getElementById('width'+id).value);
        var Charge_W = parseFloat(document.getElementById('ch_weight'+id).value);
        var Charge_H = document.getElementById('ch_height'+id).value;
        var pcs = document.getElementById('pics'+id).value;

        var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000 * parseInt(pcs);
        document.getElementById('area'+id).value = parseFloat(areas).toFixed(3);

        var areas1 =document.getElementsByName("area[]");
        var sum_area = 0;
        for (var j = 0, iLen = areas1.length; j < iLen; j++) {
            if (areas1[j].value!==""){
                val=parseFloat(areas1[j].value);
                sum_area +=val;
            }
        }
        document.getElementById('total_area1').innerHTML =  parseFloat(sum_area).toFixed(3);

        var pcs = document.getElementById('pics'+id).value;
        var rate = document.getElementById('rate'+id).value;
        var total = (areas * rate);
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

        var charge =document.getElementsByName("tot_charge_amt[]");
        var sum_cherge = 0;
        for (var j = 0, iLen = charge.length; j < iLen; j++) {
            if (charge[j].value!==""){
                val=parseFloat(charge[j].value);
                sum_cherge +=val;
            }
            else
            {
                sum_cherge = 0;
            }
        }
        var grant_tot = document.getElementById('grand_total').value;

    }
    /** Change Charge Width */

</script>

