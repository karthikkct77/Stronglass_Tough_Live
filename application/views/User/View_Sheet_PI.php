<main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>Profoma Invoice</h1>
            </div>
        </div>
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
        <div class="row">
            <div class="col-md-12" id="pagewidth" >
                <div class="tile">
                    <div class="row invoice">
                        <img style="position: absolute;width: 100px;height: auto;top: 1%;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
                        <h6>Proforma Invoice</h6>
                        <h4><?php echo $st[0]['ST_Name']; ?></h4>
                        <h5><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?></h5>
                        <h6><span>Phone: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
                        <h6 style="margin: 0;"> Mob: <?php echo $st[0]['ST_Alternate_Phone']; ?> </h6>
                    </div>
                    <hr>
                    <form method="post" class="login-form" action="<?php echo site_url('User_Controller/Save_Work_Order'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Save ?');">
                        <div class="row">
                            <div class="col-md-4" style="border-right: 1px solid #000;">
                                <input type="hidden" name="invoice_type" id="invoice_type" value="<?php echo $invoice[0]['PI_Type']; ?>">
                                <h5>Consignee</h5>
                                <div id="consign">
                                    <h5 id="coustomer" style="font-size: 16px; font-weight: bold;"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
                                    <h5 id="address" style="font-size: 14px;"><?php echo $invoice[0]['Customer_Address_1']; echo '&nbsp'; ?>,<?php echo $invoice[0]['Customer_Address_2']; echo '&nbsp';?>,<?php echo $invoice[0]['Customer_Area']; ?></h5>
                                    <h5 style="font-size: 14px; "> <?php echo $invoice[0]['Customer_City']; echo '&nbsp'; ?><?php echo $invoice[0]['Customer_State']; ?></h5>
                                    <h5 id="phone" style="font-size: 14px; ">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></h5>
                                    <h5 id="email" style="font-size: 14px; ">Email: <?php echo $invoice[0]['Customer_Email_Id_1']; ?></h5>
                                    <h5 id="gstn" style="font-size: 14px;">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></h5>
                                    <input type="hidden" name="email" value="<?php echo $invoice[0]['Customer_Email_Id_1']; ?>">
                                </div>

                            </div>
                            <div class="col-md-4" style="border-right: 1px solid #000;">
                                <h5>Buyer (if other than consignee)</h5>
                                <div id="Buyer">
                                    <?php
                                    if($invoice[0]['Customer_Address_Icode'] == "")
                                    {
                                        ?>
                                        <h5 id="coustomer" style="font-size: 14px; font-weight: bold;"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
                                        <h5 id="address" style="font-size: 14px; "><?php echo $invoice[0]['Customer_Address_1']; echo '&nbsp'; ?>,<?php echo $invoice[0]['Customer_Address_2']; echo '&nbsp';?>,<?php echo $invoice[0]['Customer_Area']; ?></h5>
                                        <h5 style="font-size: 14px; "> <?php echo $invoice[0]['Customer_City']; echo '&nbsp'; ?><?php echo $invoice[0]['Customer_State']; ?></h5>
                                        <h5 id="phone" style="font-size: 14px; ">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></h5>
                                        <h5 id="email" style="font-size: 14px; ">Email: <?php echo $invoice[0]['Customer_Email_Id_1']; ?></h5>
                                        <h5 id="gstn" style="font-size: 14px; ">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></h5>
                                        <input type="hidden" name="email" value="<?php echo $invoice[0]['Customer_Email_Id_1']; ?>">
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <h5 id="coustomer" style="font-size: 14px; font-weight: bold;"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
                                        <h5 id="address" style="font-size: 14px; "><?php echo $invoice[0]['Customer_Add_Address_1']; ?>&nbsn;<?php echo $invoice[0]['Customer_Add_Address_2']; ?></h5>
                                        <h5 id="phone" style="font-size: 14px; ">City: <?php echo $invoice[0]['Customer_Add_City']; ?></h5>
                                        <h5 id="phone" style="font-size: 14px; ">Phone: <?php echo $invoice[0]['Customer_Add_Phone']; ?></h5>
                                        <h5 id="gstn" style="font-size: 14px; ">GSTN: <?php echo $invoice[0]['Customer_Add_Email_Id_1']; ?></h5>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" type="hidden" name="PI_Icode"  id="PI_Icode" value="<?php echo $invoice[0]['Proforma_Icode']; ?>" >
                                <input class="form-control" type="hidden" name="PI_Type"  id="PI_Icode" value="<?php echo $invoice[0]['PI_Type']; ?>" >
                                <h5><span>Date</span><input type="hidden" name="invoice_date" id="invoice_date" value="<?php echo $invoice[0]['Proforma_Date']; ?>" readonly><?php echo $invoice[0]['Proforma_Date']; ?></h5>
                                <h5><span>P.INV.NO</span><input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice[0]['Proforma_Number']; ?>" readonly><?php echo $invoice[0]['Proforma_Number']; ?></h5>
                                <h5><span>Total Outstanding</span><?php echo $invoice[0]['Total_Outstanding']; ?></h5>
                                <h5><span>Credit Limit Amt</span><?php echo $invoice[0]['Credit_Limit']; ?> </h5>
                            </div>
                        </div>
                        <div class="row details_tag">
                            <div><?php echo $invoice[0]['Material_Area']; ?></div>
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
                                    <td style="text-align: left;"><?php echo $key['Material_Name']; ?></td>
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
                                <th>Qty</th>
                                <th>No.of<br>Holes</th>
                                <th>Cutouts</th>
                                <th>Special</th>
                                <th>Area<br>(SQMTR)</th>
                                <th>Rate</th>
                                <th>Total</th>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach ($invoice_item as $key) { ?>
                                    <input class="form-control" type="hidden" name="material[]"  value="<?php echo $key['pi_item_sheet_icode']; ?>" >
                                    <input class="form-control" type="hidden" name="pics[]"  value="<?php echo $key['Proforma_Qty']; ?>" >
                                    <tr id="row<?php echo $i; ?>">
                                        <td><?php echo $i; ?></td>
                                        <td style="text-align: left;"><?php echo $key['Material_Name']; ?></td>
                                        <td><?php echo $key['Proforma_Actual_Size_Height']; ?></td>
                                        <td><?php echo $key['Proforma_Actual_Size_Width']; ?></td>
                                        <td><?php echo $key['Proforma_Qty']; ?></td>
                                        <td><?php echo $key['Proforma_Holes']; ?></td>
                                        <td><?php echo $key['Proforma_Cutout']; ?></td>
                                        <td><?php echo $key['Proforma_Special']; ?></td>
                                        <td><?php echo $key['Proforma_Area_SQMTR']; ?></td>
                                        <td><?php echo $key['Proforma_Material_Rate']; ?></td>
                                        <td><?php echo $key['Proforma_Material_Cost']; ?></td>
                                    </tr>
                                    <?php $i++; } ?>
                                <tr><td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="font-weight: bold;text-align: right;" >Total Summary</td>
                                    <td><input type="hidden" class="form-control pull-right" id="total_pic" value="<?php echo $invoice_total[0]['qty']; ?>"readonly/><?php echo $invoice_total[0]['qty']; ?></td>
                                    <td><?php echo $invoice_total[0]['holes']; ?></td>
                                    <td><?php echo $invoice_total[0]['cutout']; ?></td>
                                    <td></td>
                                    <td><input type="hidden" class="form-control pull-right" id="total_area" value="<?php echo round($invoice_total[0]['area'], 2); ?>"   readonly/><?php echo round($invoice_total[0]['area'], 3); ?></td>
                                    <td></td>
                                    <td><input type="hidden" class="form-control pull-right" id="total_amts" value="<?php echo round($invoice_total[0]['rate'], 2); ?>"   readonly/><?php echo round($invoice_total[0]['rate'], 3); ?></td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row"  id="page_inside">
                            <div class="col-md-6">
                                <h3 style="font-weight: normal;font-size: 15px;">Delivery Period: <span style="font-weight: bold; padding-left: 5px;"><?php echo $invoice[0]['Delivery_Days']; ?> </span>Working Days </h3>
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
                                <div id="account">
                                    <h3 style="font-size: 13px;">Bank Details</h3>
                                    <h5><span>Account Name</span> :STRONGLASS TOUGH</h5>
                                    <h5><span>Bank Name</span>:<?php echo $st[0]['ST_Bank']; ?></span></h5>
                                    <h5><span>Account Number</span>:<?php echo $st[0]['ST_Bank_Account_Number']; ?></h5>
                                    <h5><span>IFSC</span>:<?php echo $st[0]['ST_Bank_Account_IFSC_Code']; ?></h5>
                                </div>
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
                                            <td style="text-align: left;"><?php echo $key['charge_name']; ?></td>
                                            <td><?php echo $key['Proforma_Charge_Count']; ?></td>
                                            <td><?php echo $key['Proforma_Charge_Value']; ?></td>
                                            <td><?php echo $key['Proforma_Charge_Cost']; ?></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="4" style="text-align: right;">SUB-TOTAL</td>

                                        <td><input class="form-control" type="hidden" name="sub_tot" id="sub_tot" value="<?php echo $invoice[0]['Sub_Total']; ?>" readonly ><?php echo $invoice[0]['Sub_Total']; ?></td>

                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right;">HANDLING CHARGE</td>

                                        <td><input class="form-control" type="hidden" name="insurance" id="insurance" value="<?php echo $invoice[0]['Insurance_Value']; ?>" required readonly><?php echo $invoice[0]['Insurance_Value']; ?></td>

                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right;">TRANSPORT</td>

                                        <td><input class="form-control" type="hidden" name="transport" id="transport"  value="<?php echo $invoice[0]['Transport']; ?>" readonly><?php echo $invoice[0]['Transport']; ?></td>

                                    </tr>
                                    <?php
                                    if($invoice[0]['IGST_Value'] == '0')
                                    { ?>
                                        <tr>
                                            <td colspan="4" style="text-align: right;">SGST @<?php echo $tax[0]['SGST%']; ?></td>

                                            <td><input class="form-control" type="hidden" name="sgst" id="sgst" value="<?php echo $invoice[0]['SGST_Value']; ?>"readonly ><?php echo $invoice[0]['SGST_Value']; ?></td>

                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align: right;">CGST @<?php echo $tax[0]['CGST%']; ?>
                                                <input type="hidden" id="gst" value="<?php echo $tax[0]['CGST%']; ?>">
                                            </td>
                                            <td><input class="form-control" type="hidden" name="cgst" id="cgst" value="<?php echo $invoice[0]['CGST_Value']; ?>" readonly ><?php echo $invoice[0]['CGST_Value']; ?></td>

                                        </tr>

                                    <?php }
                                    else
                                    {?>
                                        <tr>
                                            <td colspan="4" style="text-align: right;">IGST @18%
                                                <input type="hidden" id="gst" value="18">
                                            </td>
                                            <td><input class="form-control" type="hidden" name="igst" id="igst" value="<?php echo $invoice[0]['IGST_Value']; ?>" readonly ><?php echo $invoice[0]['IGST_Value']; ?></td>

                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>

                                        <td colspan="4" style="text-align: right;">GROSS TOTAL</td>
                                        <td><input class="form-control" type="hidden" name="gross_tot" id="gross_tot" readonly value="<?php echo $invoice[0]['GrossTotal_Value']; ?>" ><h4><?php echo $invoice[0]['GrossTotal_Value']; ?> /-</h4></td>

                                    </tr>
                                    </tfoot>
                                </table>
                                <div>Amount in Words: <span id="word" style="font-size: 15px; font-weight: bold;"></span></div>
                                </div>
                        </div>
                        <div id="Signature">
                        <p>For Stronglass Tough</p>
                        <div class="row"  style="margin-top: 150px;">
                            <div class="col-md-3">
                                <h6 class="st_check">Customer's Acceptance<br>Sign & Seal</h6>
                            </div>
                            <div class="col-md-3">
                                <h6 class="st_check">Prepared By</h6>
                                <p class="dynamic_data"><?php echo $User[0]['User_Name']; ?></p>
                            </div>
                            <div class="col-md-3">
                                <h6 class="st_check">Checked By</h6>
                                <p class="dynamic_data"><?php echo $check_user[0]['User_Name']; ?>
                            </div>
                            <div class="col-md-3">
                                <h6 class="st_check">(Authorised Signatory)</h6>
                            </div>
                        </div>
                        </div>
                        <div class="row" id="with_print">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <?php if($_SESSION['role'] == 6) { ?>

                                    <button id="with_print" class="btn btn-danger pi_button" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i> Generate WO</button>
                                    <input type="button" id="with_print" class="btn btn-primary pi_button" onclick="window.print()" value="Print"/>
                                <?php } elseif($_SESSION['role'] == 7){
                                    if($invoice[0]['PI_Confirm'] == '0')
                                    { ?>
                                        <input type="button" id="with_print" class="btn btn-info" onclick="Request_Approve()" value="Request Work Order">
                                   <?php }
                                    ?>
                                    <button class="btn btn-danger pi_button " type="submit" id="with_print"><i class="fa fa-fw fa-lg fa-check-circle"></i>Send PI To Customer</button>
                                    <input  type="button" id="with_print" class="btn btn-primary pi_button" onclick="window.print()" value="Print PIs">
                                    <a class="btn btn-success pi_button" id="with_print" href="<?php echo site_url('User_Controller/Edit_Sheet_Invoice/').$invoice[0]['Proforma_Icode']; ?>">EDIT PI</a>

                                <?php } ?>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
</main>
<style type="text/css" media="print">
    #pagewidth {
        overflow: hidden ;
        width: 500px ;
    }
    @media print {
        table { page-break-after:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        td    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
        #page_inside {  page-break-inside: avoid;  }
        #with_print {
            display: none;
        }
        #Signature { page-break-inside: avoid;}
    }
</style>
<style>

    .pi_button{
        margin-right: 15px;
        float: right;
    }
    h5 span{
        float: left;
        width: 200px;
        font-weight: normal;
    }
    table td {
        text-align: center;
    }
    #account h5 span {
        float: left;
        width: 150px;
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

    // Number into words
    function number_to_words() {
        var th = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];

        var dg = ['Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];

        var tn = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];

        var tw = ['Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

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

