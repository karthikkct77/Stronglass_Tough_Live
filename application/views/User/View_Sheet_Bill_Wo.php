<main class="app-content">
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>Invoice</h1>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12" id="pagewidth" >



                <div class="tile">
                    <div class="row invoice">
                        <img style="position: absolute;width: 100px;height: auto;top: 1%;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
                        <h6>Invoice</h6>
                        <h4><?php echo $st[0]['ST_Name']; ?></h4>
                        <h5><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?></h5>
                        <h6><span>Mob: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
                        <h6>GSTN: 33ACYFS4034L2ZJ</h6>
                        <h6>ECC-NO: ACYFS4034LEM001</h6>
                    </div>
                    <hr>
                    <form method="post" class="login-form" action="<?php echo site_url('User_Controller/save_bill'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Save ?');">
                        <div class="row">
                            <div class="col-md-4" style="border-right: 1px solid #000;">
                                <h5>Consignee</h5>
                                <div id="consign">
                                    <h4 id="coustomer"><?php echo $invoice[0]['Customer_Company_Name']; ?></h4>
                                    <h5 id="address"><?php echo $invoice[0]['Customer_Address_1']; echo '&nbsp'; ?>,<?php echo $invoice[0]['Customer_Address_2']; echo '&nbsp';?>,<?php echo $invoice[0]['Customer_Area']; ?></h5>
                                    <h5> <?php echo $invoice[0]['Customer_City']; echo '&nbsp'; ?><?php echo $invoice[0]['Customer_State']; ?></h5>
                                    <h5 id="phone">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></h5>
                                    <h5 id="email">Email: <?php echo $invoice[0]['Customer_Email_Id_1']; ?></h5>
                                    <h5 id="gstn">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></h5>
                                    <input type="hidden" name="email" value="<?php echo $invoice[0]['Customer_Email_Id_1']; ?>">
                                </div>

                            </div>

                            <div class="col-md-4" style="border-right: 1px solid #000;">
                                <div id="with_print">
                                    <input type="checkbox" name="check" id="check" checked onclick="FillBilling()">
                                    <em>Edit.</em>
                                </div>
                                <h5>Delivery Address</h5>
                                <div id="Buyer">
                                    <?php
                                    if($invoice[0]['Customer_Address_Icode'] == "")
                                    {
                                        ?>
                                        <input type="hidden" class="form-control" name="new_address" value="<?php echo $invoice[0]['Customer_Address_1']; echo '&nbsp'; ?>,<?php echo $invoice[0]['Customer_Address_2']; echo '&nbsp';?>,<?php echo $invoice[0]['Customer_Area']; ?>">
                                        <h4 id="coustomer"><?php echo $invoice[0]['Customer_Company_Name']; ?></h4>
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
                                        <input type="hidden" class="form-control" name="new_address" value="<?php echo $invoice[0]['Customer_Address_1']; echo '&nbsp'; ?>,<?php echo $invoice[0]['Customer_Address_2']; echo '&nbsp';?>,<?php echo $invoice[0]['Customer_Area']; ?>">
                                        <h5 id="coustomer"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
                                        <h5 id="address"><?php echo $invoice[0]['Customer_Add_Address_1']; ?>&nbsn;<?php echo $invoice[0]['Customer_Add_Address_2']; ?></h5>
                                        <h5 id="phone">City: <?php echo $invoice[0]['Customer_Add_City']; ?></h5>
                                        <h5 id="phone">Phone: <?php echo $invoice[0]['Customer_Add_Phone']; ?></h5>
                                        <h5 id="gstn">GSTN: <?php echo $invoice[0]['Customer_Add_Email_Id_1']; ?></h5>
                                        <?php
                                    }
                                    ?>

                                </div>
                                <div id="edit" style="display: none;">
                                    <textarea class="form-control"  name="new_address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" type="hidden" name="PI_Icode"  id="PI_Icode" value="<?php echo $invoice[0]['Proforma_Icode']; ?>" >
                                <h5><span>Date</span><input type="hidden" name="invoice_date" id="invoice_date" value="<?php echo $invoice[0]['Proforma_Date']; ?>" readonly><?php echo $invoice[0]['Proforma_Date']; ?></h5>
                                <h5><span>PI.NO</span><input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice[0]['Proforma_Number']; ?>" readonly><?php echo $invoice[0]['Proforma_Number']; ?></h5>
                                <h5><span>Invoice No</span><?php echo $bill_no; ?></h5>
                                <h5><span>Destination</span><input type="text" name="destination" id="destination" required="" ></h5>
                                <h5><span>Motor Vehicle No</span><input type="text" name="vehicle_no" id="vehicle_no" required="" ></h5>
                                <input type="hidden" name="work_order_no" value="<?php echo $work_order[0]['WO_Icode']; ?>">
                                <input type="hidden" name="bill_no" value="<?php echo $bill_no; ?>">
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
                                    <td><?php echo $key['Total_Amount']; ?>
                                    <input type="hidden" name="sheet_total[]" value="<?php echo $key['Total_Amount']; ?>">
                                    </td>
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
                                <th style="width: 10px;">#</th>
                                <th style="width: 20px;">Material</th>
                                <th style="width: 20px;">HSN Code</th>
                                <th style="width: 20px;">Actual<br>sz(h)</th>
                                <th style="width: 20px;">Actual<br>sz(w)</th>
                                <th style="width: 20px;">Charge<br>sz(h</th>
                                <th style="width: 20px;">Charge<br>sz(w)</th>
                                <th style="width: 10px;">No.of<br>Pcs</th>
                                <th style="width: 10px;">Special</th>
                                <th style="width: 20px;">Area<br>(sqmtr)</th>
                                <th style="width: 20px;">Rate<br>(sqmtr)</th>
                                <th style="width: 20px;">Total<br>Rs</th>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach ($invoice_item as $key) { ?>
                                    <tr id="row<?php echo $i; ?>">
                                        <td><?php echo $i; ?></td>
                                        <td style="text-align: left;"><p style="width: 180px; word-wrap: break-word;"><?php echo $key['Material_Name']; ?></p></td>
                                        <td>70071900</td>
                                        <td><?php echo $key['Proforma_Actual_Size_Height']; ?></td>
                                        <td><?php echo $key['Proforma_Actual_Size_Width']; ?></td>
                                        <td><?php echo $key['Proforma_Chargeable_Size_Height']; ?></td>
                                        <td><?php echo $key['Proforma_Chargeable_Size_Width']; ?></td>
                                        <td><?php echo $key['Proforma_Qty']; ?></td>
                                        <td><?php echo $key['Proforma_Special']; ?></td>
                                        <td><?php echo $key['Proforma_Area_SQMTR']; ?></td>
                                        <td><?php echo $key['Proforma_Material_Rate']; ?></td>
                                        <td><?php echo $key['Proforma_Material_Cost']; ?></td>
                                    </tr>
                                    <?php $i++; } ?>

                                <tr>
                                    <td colspan="7" style="font-weight: bold;text-align: right;" >Total Summary</td>
                                    <td><input type="hidden" class="form-control pull-right" id="total_pic" value="<?php echo $invoice_total[0]['qty']; ?>"readonly/><?php echo $invoice_total[0]['qty']; ?></td>
                                    <td></td>


                                    <td><input type="hidden" class="form-control pull-right" id="total_area" value="<?php echo round($invoice_total[0]['area'], 2); ?>"   readonly/><?php echo round($invoice_total[0]['area'], 3); ?></td>
                                    <td></td>
                                    <td> <input type="hidden" class="form-control pull-right" id="grand_total" value="<?php echo round($invoice_total[0]['rate'],2); ?>"   readonly/><?php echo round($invoice_total[0]['rate'],3); ?></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="row" id="page_inside">
                            <div class="col-md-6">

                                <h3 style="font-size: 13px;">Terms & Conditions</h3>
                                <p style="font-size: 12px;text-align: justify;">
                                    We declare that thi invoice shows the actual price of the goods described and that all particulars are true and correct. Interest @2% per month will be charged for the payment delayed beyond the terms agreed from the date of invoice. All payments made by third
                                    party/consumer/contractor interested in the transaction shall be adjusted against
                                    supplies made to buyer/consignee
                                </p>

                                <?php
                                if($invoice[0]['Customer_State'] == 'kerala')
                                { ?>
                                    <div id="account">
                                        <h3 style="font-size: 13px;">Bank Details</h3>
                                        <h5><span>Account Name</span> :STRONGLASS TOUGH</h5>
                                        <h5><span>Bank Name</span>:FEDERAL BANK Coimbatore Branch(Tamilnadu) </span></h5>
                                        <h5><span>Account Number</span>:10920200043393</h5>
                                        <h5><span>IFSC</span>:FDRL0001092</h5>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div id="account">
                                        <h3 style="font-size: 13px;">Bank Details</h3>
                                        <h5><span>Account Name</span> :STRONGLASS TOUGH</h5>
                                        <h5><span>Bank Name</span>:<?php echo $st[0]['ST_Bank']; ?></span></h5>
                                        <h5><span>Account Number</span>:<?php echo $st[0]['ST_Bank_Account_Number']; ?></h5>
                                        <h5><span>IFSC</span>:<?php echo $st[0]['ST_Bank_Account_IFSC_Code']; ?></h5>
                                    </div>

                                <?php } ?>
                                <div>Amount in Words: <span id="word" style="font-size: 15px;"></span>
                                    <input type="hidden" name="amt_words" id="amt_words"></div>


                            </div>
                            <div class="col-md-6">
                                <table class="table table-hover table-bordered" id="sampleTable">
                                    <thead>
                                    <th>#</th>
                                    <th>Select Charges</th>
                                    <th>No.of pieces</th>
                                    <th>Price</th>
                                    <th>Total(INR)</th>
                                    <th id="with_print"></th>

                                    </thead>
                                    <tbody>
                                    <?php
                                    $i=1;
                                    foreach ($invoice_Charges as $key) {

                                        if($key['charge_icode'])
                                            ?>
                                            <tr id="charge<?php echo $i; ?>">
                                        <td><?php echo $i; ?></td>
                                        <td><input type="hidden" name="Delete_charges[]" class="form-control" value="<?php echo $key['charge_icode']; ?>" ><?php echo $key['charge_name']; ?></td>
                                        <td><input style="text-align: center;" type="number" id="charges_count<?php echo $i; ?>" name="Delete_charges_count[]" class="form-control" value="<?php echo $key['Proforma_Charge_Count']; ?>" onkeyup="change_charge_count('<?php echo $i; ?>')"  ></td>
                                        <td><input style="text-align: center;" type="number" id="charges_value<?php echo $i; ?>" name="Delete_charges_value[]" class="form-control" value="<?php echo $key['Proforma_Charge_Value']; ?>" onkeyup="change_charge_value('<?php echo $i; ?>')"  ></td>
                                        <td><input style="text-align: center;" class="form-control" type="text" name="tot_charge_amt[]" id="tot_charge_amt<?php echo $i; ?>" value="<?php echo $key['Proforma_Charge_Cost']; ?>"  readonly></td>

                                        <?php
                                        if($key['Proforma_Charge_Icode'] == '33')
                                        { ?>
                                            <td id="with_print"><input type="button" onclick="delete_charges('<?php echo $i; ?>','<?php echo $key['charge_icode']; ?>')" value="Delete"></input>
                                            </td>
                                            <?php
                                        }

                                        ?>

                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>

                                    <tr>
                                        <td colspan="4" style="text-align: right;">SUB-TOTAL</td>

                                        <td><input class="form-control" style="text-align: center;" type="text" name="sub_tot" id="sub_tot" value="<?php echo $invoice[0]['Sub_Total']; ?>" readonly ></td>

                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right;">HANDLING CHARGE @2.42%</td>

                                        <td><input class="form-control" style="text-align: center;" type="text" name="insurance" id="insurance" value="<?php echo $invoice[0]['Insurance_Value']; ?>" required readonly></td>

                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right;">TRANSPORT</td>

                                        <td><input style="text-align: center;" class="form-control" type="text" name="transport" id="transport" onkeyup="change_transport(this.value)"   value="<?php echo $invoice[0]['Transport']; ?>" required></td>

                                    </tr>
                                    <?php
                                    if($invoice[0]['IGST_Value'] == '0')
                                    { ?>
                                        <tr>
                                            <td colspan="4" style="text-align: right;">SGST @<?php echo $tax[0]['SGST%']; ?>%</td>

                                            <td><input style="text-align: center;" class="form-control" type="text" name="sgst" id="sgst" value="<?php echo $invoice[0]['SGST_Value']; ?>"readonly ></td>

                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align: right;">CGST @<?php echo $tax[0]['CGST%']; ?>%
                                                <input type="hidden" id="gst" value="<?php echo $tax[0]['CGST%']; ?>">
                                            </td>
                                            <td>
                                                <input style="text-align: center;" class="form-control" type="hidden" name="igst" id="igst" value="<?php echo $invoice[0]['IGST_Value']; ?>" readonly >
                                                <input style="text-align: center;" class="form-control" type="text" name="cgst" id="cgst" value="<?php echo $invoice[0]['CGST_Value']; ?>" readonly >
                                            </td>
                                        </tr>

                                    <?php }
                                    else
                                    {?>
                                        <tr>
                                            <td colspan="4" style="text-align: right;">IGST @18%
                                                <input type="hidden" id="gst" value="18">
                                            </td>
                                            <td><input style="text-align: center;" class="form-control" type="text" name="igst" id="igst" value="<?php echo $invoice[0]['IGST_Value']; ?>" readonly ></td>

                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>

                                        <td colspan="4" style="text-align: right;">GROSS TOTAL</td>
                                        <td><input style="text-align: center;" class="form-control" type="text" name="gross_tot" id="gross_tot" readonly value="<?php echo $invoice[0]['GrossTotal_Value']; ?>" ><h4></h4></td>

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
                        </div>
                        <div id="Signature" style="margin-top: 20px; border: 1px solid ">

                            <div class="row"  >
                                <div class="col-md-6">
                                    <p style="padding-left: 10px;">Customer Seal and Signature</p>
                                </div>

                                <div class="col-md-6">
                                    <p  style="margin-bottom:30px; text-align: right;margin-right: 10px;">For Stronglass Tough</p>

                                    <p class="float-right">(Authorised Signatory)</p>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="with_print">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">

                                <button class="btn btn-danger pi_button " type="submit" id="with_print"><i class="fa fa-fw fa-lg fa-check-circle"></i>Generate Bill</button>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<style type="text/css" media="print">

    #pagewidth {
        overflow: hidden ;
        /*width: 500px ;*/
    }
    @media print {
        #with_print {
            display: none;
        }
        table { page-break-after:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        td    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
        #page_inside {  page-break-inside: avoid; }
        #Signature { page-break-inside: avoid;}
    }
</style>
<style>
    .pi_button{
        margin-right: 15px;
        float: right;
    }
    table td {
        text-align: center;
    }
    #account h5 span {
        float: left;
        width: 150px;
        font-weight: normal;
    }
    h5 span{
        float: left;
        width: 200px;
        font-weight: normal;
    }
    .details_tag{
        border: 1px solid #ccc;
        height: 50px;
        width: 100%;
        margin: 0px auto;
        padding: 5px;
        text-align: justify;
    }
    .st_check{
        padding-top: 15px;
        border-top: 1px solid #000000;
        text-align: center;
    }
    .dynamic_data{
        position: relative;
        top: -90px;
        text-align: center;
        font-weight: bold;
        font-size: 20px;
        margin: 0px;
        margin-top: 5px;
    }

</style>


<script>

    $( document ).ready(function() {
        number_to_words();
    });

    /** Request for Approve **/
    function Request_Approve() {
        if (confirm("Do you Want Request to Approve WO...!")) {
            var pi_code = document.getElementById('PI_Icode').value;
            $.ajax({
                url:"<?php echo site_url('User_Controller/Request_To_Approve'); ?>",
                data: {id: pi_code},
                type: "POST",
                success:function(data){
                    if(data == '1')
                    {
                        swal({
                                title: "Success!",
                                text: 'PI Request Send Success',
                                type: "success"
                            },
                            function(){
                                window.location.href = document.referrer;
                            });
                    }

                }
            });

        }

    }

    function FillBilling() {
        if($('#check').is(":checked"))
        {
            $('#Buyer').show();
            $('#edit').hide();

        }
        else
        {
            $('#Buyer').hide();
            $('#edit').show();
        }
    }

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
        if(igst == '' || igst == '0' )
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
        if(igst == '' || igst == '0')
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
        if(igst == '' || igst == '0')
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

            var sheet_totals =document.getElementsByName("sheet_total[]");
            var sheet_sum1 = 0;
            for (var j = 0, iLen = sheet_totals.length; j < iLen; j++) {
                if (sheet_totals[j].value!==""){
                    val=parseFloat(sheet_totals[j].value);
                    sheet_sum1 +=val;
                }
            }
            var grant_tot = document.getElementById('grand_total').value;

            var sub_tot1 = parseFloat(sum1) + parseFloat(grant_tot) + parseFloat(sheet_sum1) ;
            document.getElementById('sub_tot').value = parseFloat(sub_tot1).toFixed(2);
            var sub_tot =document.getElementById('sub_tot').value;
            var tax = 2.42;
            var total = parseFloat (sub_tot * tax / 100);
            document.getElementById('insurance').value = parseFloat(total).toFixed(3);
            var insurance =parseFloat(total).toFixed(3);
            var igst =document.getElementById('igst').value;
            if(igst == '' || igst == '0')
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

        if(igst == '' || igst == '0' )
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
        document.getElementById('amt_words').value = str;
        if (x != s.length) {
            var y = s.length;
            str += 'point ';
            for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
        }
        return str.replace(/\s+/g, ' ');
    }

</script>

