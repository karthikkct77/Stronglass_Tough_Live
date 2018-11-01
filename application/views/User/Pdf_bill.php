<html>
<head>
    <style>
        body,div,table,thead,td,th,tr,span,li,ul,p,h1,h2,h3,h4,h5,h6,i,section{
            font-family: Helvetica;
        }
        table,tr,td,thead,tbody,th{
            border: 1px solid #cccccc;
            border-collapse: collapse;
        }
        th{
            font-weight: bold;
        }
        table{
            width: 100%;
            text-align: center;
            font-size: 12px;
        }
        .width_td{
            width: 15%;
            max-width: 30px;
            table-layout: fixed;
            text-align:left;
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
        .details_tag{
            border: 1px solid #ccc;
            height: 10px;
            width: 100%;
            margin: 0px auto;
            padding: 5px;
            text-align: center;
            font-size: 12px;
        }
        .flex{
            display: flex;
        }
        .total
        {
            font-weight: bold;
        }
        #account h5 span {
            float: left;
            width: 150px;
            font-weight: normal;
        }
        .section3{
            font-size: 18px !important;
            font-weight: bold;
            float: right;
            text-align: left;
        }
        .tile_1{
            margin: 0 0 15px 0;margin-bottom:5px;font-size: 14px;width: 200px;
        }
    </style>
</head>
<body>
<div style="width: 100%; display: block;text-align: center;">
    <img style="position: absolute;width: 20%;height: auto;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
    <h6 style=" margin-bottom:0px; font-size: 16px; ">Invoice</h6>
    <h4 style=" margin-top:5px; margin-bottom: 2px; font-size: 20px"><?php echo $st[0]['ST_Name']; ?></h4>
    <h5 style="margin: 0;"><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?></h5>
    <h6 style="margin: 0;"><span>Phone: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
    <h6 style="margin: 0;"> Mob: <?php echo $st[0]['ST_Alternate_Phone']; ?> </h6>
    <h6 style="margin: 0;">GSTN: 33ACYFS4034L2ZJ</h6>
    <h6 style="margin: 0;">ECC-NO: ACYFS4034LEM001</h6>
    <br>
    <hr>
    <br>
    <div style="width:100%;clear:both;">
        <div style="width:40%;float: left;text-align: left; border-right: 1px solid #000;">
            <h4 style="margin: 0;margin-bottom:5px;">Consignee</h4>
            <?php
            if($bill[0]['Customer_Address'] == "")
            {
                ?>
                <p style="margin: 0;margin-bottom:5px;font-size: 14px; font-weight: bold;"><?php echo $invoice[0]['Customer_Company_Name']; ?></p>
                <p style="margin: 0;margin-bottom:5px;font-size: 14px;"><?php echo $invoice[0]['Customer_Address_1'];?><?php echo $invoice[0]['Customer_Address_2']; ?></p>
                <p style="margin: 0;margin-bottom:5px;font-size: 14px;">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></p>
                <p style="margin: 0;font-size: 14px;">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></p>
                <?php
            }
            else
            { ?>
                <p style="margin: 0;margin-bottom:5px;font-size: 14px; font-weight: bold;"><?php echo $bill_customer[0]['Customer_Company_Name']; ?></p>
                <p style="margin: 0;margin-bottom:5px;font-size: 14px;"><?php echo $bill_customer[0]['Customer_Address_1'];?><?php echo $bill_customer[0]['Customer_Address_2']; ?></p>
                <p style="margin: 0;margin-bottom:5px;font-size: 14px;">Phone: <?php echo $bill_customer[0]['Customer_Phone']; ?></p>
                <p style="margin: 0;font-size: 14px;">GSTN: <?php echo $bill_customer[0]['Customer_GSTIN']; ?></p>

                <?php
            }
            ?>
        </div>
        <div style="width:30%;float: left;text-align: left; border-right: 1px solid #000; margin-left: 10px;">
            <h4 style="margin: 0;margin-bottom:5px;">Delivery Address</h4>
            <?php
            if($bill[0]['Delivery_Address'] == "")
            {
                ?>
                <p style="margin: 0;margin-bottom:5px;font-size: 14px; font-weight: bold;"><?php echo $invoice[0]['Customer_Company_Name']; ?></p>
                <p style="margin: 0;margin-bottom:5px;font-size: 14px;"><?php echo $invoice[0]['Customer_Address_1']; ?><?php echo $invoice[0]['Customer_Address_2']; ?></p>
                <p style="margin: 0;margin-bottom:5px;font-size: 14px;">City: <?php echo $invoice[0]['Customer_City']; ?></p>
                <p style="margin: 0;margin-bottom:5px;font-size: 14px;">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></p>
                <p style="margin: 0;font-size: 14px;">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></p>
                <?php
            }
            else
            {

                $myString = $bill[0]['Delivery_Address'];
                $myArray = explode(',', $myString);
                foreach ($myArray as $key)
                { ?>
                    <h5><?php echo $key; ?> </h5>
                <?php }

            } ?>
        </div>
        <div style="width:30%;float: left;text-align: left; margin-left: 10px;">
            <div class="flex"><p class="tile_1" style="">Date</p><span class="section3"><?php echo date("Y-m-d",strtotime($bill[0]['Created_On'])); ?></span></div>
            <div class="flex"><p class="tile_1" style="width: 200px;">PI.NO</p><span class="section3"><?php echo $invoice[0]['Proforma_Number']; ?></span></div>
            <div class="flex"><p class="tile_1" style="width: 200px;">Invoice No</p><span class="section3"><?php echo $bill[0]['Bill_Number']; ?></span></div>
            <div class="flex"><p class="tile_1" style="">Destination</p><span class="section3"><?php echo $bill[0]['Destination']; ?></span></div>
            <div class="flex"><p class="tile_1" style="">Motor Vehicle No</p><span class="section3"><?php echo $bill[0]['Vehicle_No']; ?></span></div>
        </div>
    </div>
    <br style="width:100%;clear:both;">
    <hr>
    <div class="row details_tag">
        <div><?php echo $invoice[0]['Material_Area']; ?></div>
    </div>
    <br style="width:100%;clear:both;">
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
                <th>Actucal Size(H)</th>
                <th>Actucal Size(W)</th>
                <th>Qty</th>
                <th>Special</th>
                <th>Area</th>
                <th>Rate</th>
                <th>Total</th>
            </tr>
            </thead>
            <?php $i=1; foreach ($invoice_item as $key) { ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td style="text-align: left;"><?php echo $key['Material_Name']; ?></td>
                    <td><?php echo $key['Proforma_Actual_Size_Height']; ?></td>
                    <td><?php echo $key['Proforma_Actual_Size_Width']; ?></td>
                    <td><?php echo $key['Proforma_Qty']; ?></td>
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
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" style="font-weight: bold;text-align: right;" >Total Summary</td>
                <td><input type="hidden" class="form-control pull-right" id="total_pic" value="<?php echo $invoice_total[0]['qty']; ?>"readonly/><?php echo $invoice_total[0]['qty']; ?></td>

                <td></td>
                <td><input type="hidden" class="form-control pull-right" id="total_area" value="<?php echo round($invoice_total[0]['area'], 2); ?>"   readonly/><?php echo round($invoice_total[0]['area'], 3); ?></td>
                <td></td>
                <td><?php echo round($invoice_total[0]['rate'], 3); ?></td>

            </tr>

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
                <th>Qty</th>
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
                <td colspan="6" style="font-weight: bold;text-align: right;" >Total Summary</td>
                <td class="total"><?php echo $invoice_total[0]['qty']; ?></td>

                <td></td>
                <td class="total"><?php echo round($invoice_total[0]['area'], 3); ?></td>
                <td></td>
                <td class="total"><?php echo round($invoice_total[0]['rate'],3); ?></td>
            </tr>
        </table>
    <?php } ?>
    <!--    <br style="width:100%;">-->
    <hr>
    <div id="page"style="display: block; vertical-align: top;">
        <div style="width: 49.5%; text-align: left; display: inline-block; vertical-align: top;">
            <h3 style="font-weight: normal;font-size: 12px;">Delivery Period: <span style="font-weight: bold; padding-left: 5px;"><?php echo $invoice[0]['Delivery_Days']; ?> </span>Working Days </h3>
            <h3 style="font-size: 12px;">Terms & Conditions</h3>
            <p style="font-size: 8px;text-align: justify;">
                We declare that thi invoice shows the actual price of the goods described and that all particulars are true and correct. Interest @2% per month will be charged for the payment delayed beyond the terms agreed from the date of invoice. All payments made by third
                party/consumer/contractor interested in the transaction shall be adjusted against
                supplies made to buyer/consignee
            </p>
            <p style="float: left; font-size: 12px;padding-left: 5px; font-weight: bold;">Amount in Words: <?php echo $bill[0]['Amt_Words'];?></p>

        </div>
        <div style="width: 49.5%; display: inline-block; vertical-align: top;">
            <?php
            if(empty($bill_Charges))
            {
            ?>
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Select Charges</th>
                    <th>Qty</th>
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
                        <td style="text-align: left;"><?php echo $key['charge_name']; ?></td>
                        <td><?php echo $key['Proforma_Charge_Count']; ?></td>
                        <td><?php echo $key['Proforma_Charge_Value']; ?></td>
                        <td><?php echo $key['Proforma_Charge_Cost']; ?></td>
                    </tr>
                    <?php
                    $i++;
                }
                }
                else
                {
                ?>
                <table>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Select Charges</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total(INR)</th>
                    </tr>
                    </thead>
                    <?php
                    $i=1;
                    foreach ($bill_Charges as $key) {
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

                     }
                if($bill[0]['Sub_Total'] == "")
                                            {
                ?>

                    <tr>
                        <td colspan="4" align="right">SUB-TOTAL</td>
                        <td><input class="form-control" type="hidden" name="sub_tot" id="sub_tot" value="<?php echo $invoice[0]['Sub_Total']; ?>" readonly ><?php echo $invoice[0]['Sub_Total']; ?></td>

                    </tr>
                    <tr>
                        <td colspan="4" align="right">HANDLING CHARGE @2.42%</td>

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
                            <td colspan="4" align="right">SGST @<?php echo $tax[0]['SGST%']; ?>%</td>

                            <td><?php echo $invoice[0]['SGST_Value']; ?></td>

                        </tr>
                        <tr>
                            <td colspan="4" align="right">CGST @<?php echo $tax[0]['CGST%']; ?>%
                                <input type="hidden" id="gst" value="<?php echo $tax[0]['CGST%']; ?>">
                            </td>
                            <td><?php echo $invoice[0]['CGST_Value']; ?></td>

                        </tr>

                    <?php }
                    else
                    {?>
                        <tr>
                            <td colspan="4" align="right">IGST @18%
                                <input type="hidden" id="gst" value="18">
                            </td>
                            <td><?php echo $invoice[0]['IGST_Value']; ?></td>

                        </tr>
                        <?php
                    }
                    ?>
                    <tr>

                        <td colspan="4" align="right">GROSS TOTAL</td>
                        <td style="font-size: 15px;font-weight: bold;"><?php echo $invoice[0]['GrossTotal_Value']; ?>(INR)</td>

                    </tr>
                </table>
                <?php
                }
                else
                {
                ?>
                <tr>
                    <td colspan="4" align="right">SUB-TOTAL</td>
                    <td><input class="form-control" type="hidden" name="sub_tot" id="sub_tot" value="<?php echo $bill[0]['Sub_Total']; ?>" readonly ><?php echo $bill[0]['Sub_Total']; ?></td>

                </tr>
                <tr>
                    <td colspan="4" align="right">HANDLING CHARGE @2.42 %</td>

                    <td><input class="form-control" type="hidden" name="insurance" id="insurance" value="<?php echo $bill[0]['Insurance_Value']; ?>" required readonly><?php echo $bill[0]['Insurance_Value']; ?></td>

                </tr>
                <tr>
                    <td colspan="4" align="right">TRANSPORT</td>

                    <td><input class="form-control" type="hidden" name="transport" id="transport"  value="<?php echo $bill[0]['Transport']; ?>" readonly><?php echo $bill[0]['Transport']; ?></td>

                </tr>
                <?php
                if($bill[0]['IGST_Value'] == '0')
                { ?>
                    <tr>
                        <td colspan="4" align="right">SGST @<?php echo $tax[0]['SGST%']; ?>%</td>

                        <td><?php echo $bill[0]['SGST_Value']; ?></td>

                    </tr>
                    <tr>
                        <td colspan="4" align="right">CGST @<?php echo $tax[0]['CGST%']; ?>%
                            <input type="hidden" id="gst" value="<?php echo $tax[0]['CGST%']; ?>">
                        </td>
                        <td><?php echo $bill[0]['CGST_Value']; ?></td>

                    </tr>

                <?php }
                else
                {?>
                    <tr>
                        <td colspan="4" align="right">IGST @18%
                            <input type="hidden" id="gst" value="18">
                        </td>
                        <td><?php echo $bill[0]['IGST_Value']; ?></td>

                    </tr>
                    <?php
                }
                ?>
                <tr>

                    <td colspan="4" align="right">GROSS TOTAL</td>
                    <td style="font-size: 15px;font-weight: bold;"><?php echo $bill[0]['GrossTotal_Value']; ?>(INR)</td>

                </tr>
            </table>

        <?php
        } ?>


        </div>
    </div>
    <div id="page"style="display: block;vertical-align: top;">
        <div style="width: 49.5%; text-align: left; display: inline-block;vertical-align: top;">
            <?php
            if($invoice[0]['Customer_State'] == 'kerala') { ?>
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
            <?php }
            ?>
        </div>
    </div>
    <div id="Signature" style="margin-top: 20px; border: 1px solid ">

        <div class="row"  >
            <div class="col-md-6" style="width: 49.5%; text-align: left; display: inline-block;vertical-align: top;" >
                <p style="padding-left: 10px; font-weight: bold;">Customer Seal and Signature</p>
            </div>

            <div class="col-md-6" style="width: 49.5%; text-align: left; display: inline-block;vertical-align: top;" >
                <p  style="margin-bottom:80px; text-align: right;margin-right: 10px; font-weight: bold;">For Stronglass Tough</p>

                <p style="font-weight: bold;text-align: right;" class="float-right">(Authorised Signatory)</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
