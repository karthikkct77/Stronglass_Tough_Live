
<main class="app-content">
    <div   >
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>Work Order </h1>
            </div>
        </div>
        <input type="button" id="with_print" class="btn btn-primary pi_button" onclick="window.print()" value="Print"/>

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
            <div class="col-md-12" >

                <div class="tile">
                    <div class="row invoice">
                        <img style="position: absolute;width: 100px;height: auto;top: 1%;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
                        <h4><?php echo $st[0]['ST_Name']; ?> <span style="float: right;margin-right: 20px; font-size: 25px;">WO.NO: <?php echo $wo[0]['WO_Number']; ?></span></h4>
                        <h5><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?> </h5>
                        <h6><span>Mob: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>

                    </div>

                    <hr>
                    <form method="post" class="login-form" action="<?php echo site_url('User_Controller/Barcode/').$invoice[0]['Proforma_Icode']. '/' .$invoice[0]['PI_Type'].'' ; ?>" name="data_register" onsubmit="return confirm('Do you really want to Save ?');">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Consignee</h5>
                                <div id="consign">
                                    <h5 id="coustomer"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
                                    <h5 id="address"><?php echo $invoice[0]['Customer_Company_Name']; ?>$nbsn;<?php echo $invoice[0]['Customer_Address_1']; ?>$nbsn;<?php echo $invoice[0]['Customer_Address_2']; ?></h5>
                                    <h5 id="phone">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></h5>
                                    <h5 id="gstn">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></h5>
                                </div>

                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <!--                                <input type="checkbox" name="check" id="check" checked onclick="FillBilling()">-->
                                    <!--                                <em>Check this box if Current Address and Mailing permanent are the same.</em>-->
                                </div>

                            </div>
                            <div class="col-md-4" style="border-right: 1px solid #000;">
                                <h5>Buyer (if other than consignee)</h5>
                                <div id="Buyer">
                                    <?php
                                    if($invoice[0]['Proforma_Delivery_Address_Icode'] == "0")
                                    {
                                        ?>
                                        <h5 id="coustomer" style="font-size: 16px; font-weight: bold;"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
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

                                        $myString = $invoice[0]['Proforma_Delivery_Address_Icode'];
                                        $myArray = explode(',', $myString);
                                        foreach ($myArray as $key)
                                        { ?>
                                            <h5><?php echo $key; ?> </h5>


                                        <?php }
                                        ?>
                                        <input type="hidden" name="new_delivery_address" value="<?php echo $invoice[0]['Proforma_Delivery_Address_Icode']; ?>">
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" type="hidden" name="PI_Icode"  id="PI_Icode" value="<?php echo $invoice[0]['Proforma_Icode']; ?>" >
                                <h5><span>PI.Date</span><input type="hidden" name="invoice_date" id="invoice_date" value="<?php echo $invoice[0]['Proforma_Date']; ?>" readonly><?php echo $invoice[0]['Proforma_Date']; ?></h5>
                                <h5><span>PI.NO</span><input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice[0]['Proforma_Number']; ?>" readonly><?php echo $invoice[0]['Proforma_Number']; ?></h5>
                                <h5><span>Total Outstanding</span><?php echo $invoice[0]['Total_Outstanding']; ?></h5>
                                <h5><span>Credit Limit Amt</span><?php echo $invoice[0]['Credit_Limit']; ?> </h5>
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
                                <?php $i=1; foreach ($invoice_item as $key) { ?>
                                    <tr id="row<?php echo $i; ?>">
                                                 <td><?php echo $i; ?></td>
                                        <td><?php echo $key['Material_Name']; ?></td>
                                        <td><?php echo $key['Proforma_Actual_Size_Height']; ?></td>

                                        <td><?php echo $key['Proforma_Actual_Size_Width']; ?></td>
                                        <td><?php echo $key['Proforma_Chargeable_Size_Height']; ?></td>

                                        <td><?php echo $key['Proforma_Chargeable_Size_Width']; ?></td>
                                        <td><?php echo $key['Proforma_Qty']; ?></td>
                                        <td><?php echo $key['Proforma_Holes']; ?></td>
                                        <td><?php echo $key['Proforma_Cutout']; ?></td>
                                        <td><?php echo $key['Proforma_Special']; ?></td>
                                        <td><?php echo $key['Proforma_Area_SQMTR']; ?></td>
                                        <td><?php echo $key['Proforma_Material_Rate']; ?></td>
                                        <td><?php echo $key['Proforma_Material_Cost']; ?></td>
                                    </tr>
                                    <?php $i++; } ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <td><input type="hidden" class="form-control pull-right" id="total_pic" value="<?php echo $invoice_total[0]['qty']; ?>"   readonly/><?php echo $invoice_total[0]['qty']; ?></td>

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><input type="hidden" class="form-control pull-right" id="total_area" value="<?php echo round($invoice_total[0]['area'], 2); ?>"   readonly/><?php echo round($invoice_total[0]['area'], 2); ?></td>
                                    <td></td>
                                    <td> <input type="hidden" class="form-control pull-right" id="grand_total" value="<?php echo round($invoice_total[0]['rate'],2); ?>"   readonly/><?php echo round($invoice_total[0]['rate'],2); ?></td>
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
                                <?php
                                if($invoice[0]['Proforma_Generated_By'] == '2')
                                { ?>
                                    <div id="account">
                                        <h3 style="font-size: 13px;">Bank Details</h3>
                                        <h5><span>Account Name</span> :STRONGLASS TOUGH</h5>
                                        <h5><span>Bank Name</span>:FEDERAL BANK Coimbatore Branch </span></h5>
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

                                        <td><input class="form-control" type="hidden" name="sub_tot" id="sub_tot" value="<?php echo $invoice[0]['Sub_Total']; ?>" readonly ><?php echo $invoice[0]['Sub_Total']; ?></td>

                                    </tr>
                                    <tr>
                                        <td colspan="4" align="right">HANDLING CHARGE</td>

                                        <td><input class="form-control" type="hidden" name="insurance" id="insurance" value="<?php echo $invoice[0]['Insurance_Value']; ?>" required readonly><?php echo $invoice[0]['Insurance_Value']; ?></td>

                                    </tr>
                                    <tr>
                                        <td colspan="4" align="right">TRANSPORT</td>

                                        <td><input class="form-control" type="hidden" name="transport" id="transport"  value="<?php echo $invoice[0]['Transport']; ?>" readonly><?php echo $invoice[0]['Transport']; ?></td>

                                    </tr>
                                    <?php
                                    if($invoice[0]['IGST_Value'] == '0' || $invoice[0]['IGST_Value'] == '')
                                    { ?>
                                        <tr>
                                            <td colspan="4" align="right">SGST @<?php echo $tax[0]['SGST%']; ?></td>

                                            <td><input class="form-control" type="hidden" name="sgst" id="sgst" value="<?php echo $invoice[0]['SGST_Value']; ?>"readonly ><?php echo $invoice[0]['SGST_Value']; ?></td>

                                        </tr>
                                        <tr>
                                            <td colspan="4" align="right">CGST @<?php echo $tax[0]['CGST%']; ?>
                                                <input type="hidden" id="gst" value="<?php echo $tax[0]['CGST%']; ?>">
                                            </td>
                                            <td><input class="form-control" type="hidden" name="cgst" id="cgst" value="<?php echo $invoice[0]['CGST_Value']; ?>" readonly ><?php echo $invoice[0]['CGST_Value']; ?></td>

                                        </tr>

                                    <?php }
                                    else
                                    {?>
                                        <tr>
                                            <td colspan="4" align="right">IGST @18%
                                                <input type="hidden" id="gst" value="18">
                                            </td>
                                            <td><input class="form-control" type="hidden" name="igst" id="igst" value="<?php echo $invoice[0]['IGST_Value']; ?>" readonly ><?php echo $invoice[0]['IGST_Value']; ?></td>

                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>

                                        <td colspan="4" align="right">GROSS TOTAL</td>
                                        <td><input class="form-control" type="hidden" name="gross_tot" id="gross_tot" readonly value="<?php echo $invoice[0]['GrossTotal_Value']; ?>" ><h4><?php echo $invoice[0]['GrossTotal_Value']; ?> /-</h4></td>

                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div>Amount in Words: <span id="word" style="font-size: 20px;margin-left: 10px;"></span></div>
                        </div>
                        <hr>



                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<style type="text/css" media="print">
    #pagewidth {
        overflow: hidden ;
        width: 500px ;
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


</style>

<script type="text/javascript">
    $( document ).ready(function() {
        number_to_words();
        var totals =document.getElementsByName("holes_print[]");
        var sum1 = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum1 +=val;
            }
        }
        document.getElementById('holes_print').innerHTML = sum1 ;

        var totals_cut =document.getElementsByName("cutout_print[]");
        var sum2 = 0;
        for (var j = 0, iLen = totals_cut.length; j < iLen; j++) {
            if (totals_cut[j].value!==""){
                val=parseFloat(totals_cut[j].value);
                sum2 +=val;
            }
        }
        document.getElementById('cutout_print').innerHTML = sum2 ;
    });
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

</script>


<script>

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

