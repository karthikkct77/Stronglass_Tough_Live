<html>
<head>
    <style>
        table,tr,td,thead,tbody,th{
            border: 1px solid #cccccc;
            border-collapse: collapse;
        }
        th{
            font-weight: bold;
        }
        table{
            width: 100%;
            text-align: left;
            font-size: 12px;
        }
        .width_td{
            width: 10%;
            max-width: 30px;
            table-layout: fixed;
        }
        #page {
            page-break-inside: avoid;
        }
        .acc span
        {
            width: 100px;
            float: left;
            font-size: 12px;
            font-weight: normal;
        }
        .acc {
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div style="width: 100%; display: block;text-align: center;">
    <img style="position: absolute;width: 100px;height: auto;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
    <h6>Proforma Invoice</h6>
    <h4 style="margin-bottom: 10px;"><?php echo $st[0]['ST_Name']; ?></h4>
    <h5 style="margin: 0;"><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?></h5>
    <h6 style="margin: 0;"><span>Mob: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
    <br>
    <hr>
    <br>
    <div style="width:100%;clear:both;">
        <div style="width:40%;float: left;text-align: left;">
            <h4 style="margin: 0;margin-bottom:5px;">Consignee</h4>
            <p style="margin: 0;margin-bottom:5px;font-size: 14px;"><?php echo $invoice[0]['Customer_Company_Name']; ?></p>
            <p style="margin: 0;margin-bottom:5px;font-size: 14px;"><?php echo $invoice[0]['Customer_Address_1'];?><?php echo $invoice[0]['Customer_Address_2']; ?></p>
            <p style="margin: 0;margin-bottom:5px;font-size: 14px;">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></p>
            <p style="margin: 0;font-size: 14px;">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></p>
        </div>
        <div style="width:40%;float: left;text-align: left;">
            <h4 style="margin: 0;margin-bottom:5px;">Buyer (if other than consignee)</h4>
            <p style="margin: 0;margin-bottom:5px;font-size: 14px;"><?php echo $invoice[0]['Customer_Company_Name']; ?></p>
            <p style="margin: 0;margin-bottom:5px;font-size: 14px;"><?php echo $invoice[0]['Customer_Address_1']; ?><?php echo $invoice[0]['Customer_Address_2']; ?></p>
            <p style="margin: 0;margin-bottom:5px;font-size: 14px;">City: <?php echo $invoice[0]['Customer_City']; ?></p>
            <p style="margin: 0;margin-bottom:5px;font-size: 14px;">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></p>
            <p style="margin: 0;font-size: 14px;">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></p>
        </div>
        <div style="width:20%;float: left;text-align: left;">
            <p style="margin: 0;margin-bottom:5px;font-size: 14px;">Date<br><span style="font-size: 18px !important;font-weight: bold;"><?php echo $invoice[0]['Proforma_Date']; ?></span></p>
            <p style="margin: 0 0 15px 0;margin-bottom:5px;font-size: 14px;">P.INV. NO<br><span style="font-size: 18px !important;font-weight: bold;"><?php echo $invoice[0]['Proforma_Number']; ?></span></p>
        </div>
    </div>
    <br style="width:100%;clear:both;">
    <hr>
    <?php if($invoice[0]['PI_Type'] == '1')
    { ?>
        <h6 style="text-align: center">Total Number of Sheets used to Cut the following glasses</h6>
        <table>
            <thead >
            <tr >
            <th>#</th>
            <th >Material</th>
            <th>No.of sheet</th>
            <th >ActSize(h)</th>
            <th >ActSize(w)</th>
            <th >chaSize(h)</th>
            <th>chaSize(w)</th>
            <th >Area</th>
            <th >Rate</th>
            <th >Amount</th>
            </tr>
            </thead>
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
            <?php
            }
            ?>
        </table>
        <br style="width:100%;clear:both;">
        <hr>
        <br>
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Material</th>
                <th>Actucal Size(W)</th>
                <th>Actucal Size(H)</th>
                <th>No.of .Pieces</th>
                <th>Holes</th>
                <th>cutout</th>
                <th>Special</th>
                <th>Area</th>
            </tr>
            </thead>
            <?php $i=1; foreach ($invoice_item as $key) { ?>
                <tr>
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
        </table>

   <?php }
   else
   { ?>
       <table>
           <thead>
           <tr>
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
           </tr>
           </thead>
           <?php $i=1; foreach ($invoice_item as $key) { ?>
               <tr>
                   <td><?php echo $i; ?></td>
                   <td class="width_td"><?php echo $key['Material_Name']; ?></td>
                   <td><?php echo $key['Proforma_Actual_Size_Width']; ?></td>
                   <td><?php echo $key['Proforma_Actual_Size_Height']; ?></td>
                   <td><?php echo $key['Proforma_Chargeable_Size_Width']; ?></td>
                   <td><?php echo $key['Proforma_Chargeable_Size_Height']; ?></td>
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
               <td style="font-weight: bold;"><?php echo $invoice_total[0]['qty']; ?></td>
               <td></td>
               <td></td>
               <td></td>
               <td style="font-weight: bold;"><?php echo round($invoice_total[0]['area'], 3); ?></td>
               <td></td>
               <td style="font-weight: bold;"><?php echo round($invoice_total[0]['rate'],3); ?></td>
           </tr>
       </table>
   <?php } ?>
<!--    <br style="width:100%;">-->
    <hr>
    <div id="page"style="display: block; vertical-align: top;">
        <div style="width: 49.5%; text-align: left; display: inline-block; vertical-align: top;">
            <h3 style="font-size: 13px;">Terms & Conditions</h3>
            <p style="font-size: 8px;text-align: justify;">
                Supply shall be against advance payment or Letter of credit or any other agreed
                terms. Interest @2% per month will be charged for the payment delayed beyond
                the terms agreed from the date of invoice. All payments made by third
                party/consumer/contractor interested in the transaction shall be adjusted against
                supplies made to buyer/consignee
            </p>
            <h3 style="font-size: 13px;">Dear Customer</h3>
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
        </div>
        <div style="width: 49.5%; display: inline-block; vertical-align: top;">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Select Charges</th>
                    <th>No.of pieces</th>
                    <th>Price</th>
                    <th>Total(INR)</th>
                </tr>
                </thead>
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
<!--            </table>-->
<!--            <div  style="float: right;" id="totals">-->
<!--            <table>-->
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
                if($invoice[0]['IGST_Value'] == '0')
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
                    <td style="font-size: 15px;font-weight: bold;"><input class="form-control" type="hidden" name="gross_tot" id="gross_tot" readonly value="<?php echo $invoice[0]['GrossTotal_Value']; ?>" ><?php echo $invoice[0]['GrossTotal_Value']; ?>(INR)</td>

                </tr>
            </table>

            </div>
       <p id="word" style="float: left;">Amount in Words: <?php echo $invoice[0]['Amt_Words'];?></p>
        </div>
    <div id="page"style="display: block;vertical-align: top;">
        <div style="width: 49.5%; text-align: left; display: inline-block;vertical-align: top;">
            <h3 style="font-size: 14px;">Bank Details</h3>
            <p class="acc">Stronglass Tough</p>
            <p class="acc"><span>A/C Type</span>:<?php echo $st[0]['ST_Bank_Account_Type']; ?></p>
            <p class="acc"><span>A/C Number</span>:<?php echo $st[0]['ST_Bank_Account_Number']; ?></p>
            <p class="acc"><span>Name</span>:<?php echo $st[0]['ST_Bank']; ?></p>
            <p class="acc"><span>IFSC</span>:<?php echo $st[0]['ST_Bank_Account_IFSC_Code']; ?> </p>
        </div>
        <div style="width: 49.5%; display: inline-block; vertical-align: top;">
        </div>
    </div>
    </div>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

    $( document ).ready(function() {
        number_to_words();
    });

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
        document.getElementById('word').innerHTML=str;
        $("#amt_word").append("<p> str</p>");
        if (x != s.length) {
            var y = s.length;
            str += 'point ';
            for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
        }
        return str.replace(/\s+/g, ' ');
    }

</script>