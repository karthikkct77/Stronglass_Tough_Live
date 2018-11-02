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
        #page1 {
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
        .dynamic_data{
            position: relative;
            top: -90px;
            text-align: center;
            font-weight: bold;
            font-size: 20px;
            margin: 0px;
            margin-top: 5px;
        }
        .st_check{
            padding-top: 15px;
            border-top: 1px solid #000000;
            text-align: center;
        }
    </style>
</head>
<body>
<div style="width: 100%; display: block;text-align: center;">
    <img style="position: absolute;width: 20%;height: auto;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
    <h6 style=" margin-bottom:0px; ">Proforma Invoice</h6>
    <h4 style=" margin-top:5px; margin-bottom: 2px; font-size: 20px"><?php echo $st[0]['ST_Name']; ?></h4>
    <h5 style="margin: 0;"><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?></h5>
    <h6 style="margin: 0;"><span>Phone: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
    <h6 style="margin: 0;"> Mob: <?php echo $st[0]['ST_Alternate_Phone']; ?> </h6>
    <br>
    <hr>
    <br>
    <div style="width:100%;clear:both;">
        <div style="width:40%;float: left;text-align: left;">
            <h4 style="margin: 0;margin-bottom:5px;">Consignee</h4>
            <p style="margin: 0;margin-bottom:5px;font-size: 16px; font-weight: bold;"><?php echo $invoice[0]['Customer_Company_Name']; ?></p>
            <p style="margin: 0;margin-bottom:5px;font-size: 14px; "><?php echo $invoice[0]['Customer_Address_1'];?><?php echo $invoice[0]['Customer_Address_2']; ?></p>
            <p style="margin: 0;margin-bottom:5px;font-size: 14px;">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></p>
            <p style="margin: 0;font-size: 14px; ">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></p>
        </div>
        <div style="width:40%;float: left;text-align: left;">
            <h4 style="margin: 0;margin-bottom:5px;">Buyer (if other than consignee)</h4>
            <p style="margin: 0;margin-bottom:5px;font-size: 14px; font-weight: bold;"><?php echo $invoice[0]['Customer_Company_Name']; ?></p>
            <p style="margin: 0;margin-bottom:5px;font-size: 14px; "><?php echo $invoice[0]['Customer_Address_1']; ?><?php echo $invoice[0]['Customer_Address_2']; ?></p>
            <p style="margin: 0;margin-bottom:5px;font-size: 14px; ">City: <?php echo $invoice[0]['Customer_City']; ?></p>
            <p style="margin: 0;margin-bottom:5px;font-size: 14px; ">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></p>
            <p style="margin: 0;font-size: 14px; ">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></p>
        </div>
        <div style="width:20%;float: left;text-align: left;">
            <p style="margin: 0;margin-bottom:5px;font-size: 14px;">Date<br><span style="font-size: 18px !important;font-weight: bold;"><?php echo $invoice[0]['Export_Date']; ?></span></p>
            <p style="margin: 0 0 15px 0;margin-bottom:5px;font-size: 14px;">P.INV. NO<br><span style="font-size: 18px !important;font-weight: bold;"><?php echo $invoice[0]['Export_Invoice_Number']; ?></span></p>
                 </div>
    </div>
    <br style="width:100%;clear:both;">
    <hr>

    <br style="width:100%;clear:both;">

        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Material</th>
                <th>Actual<br>size(h)</th>
                <th>Actual<br>size(w)</th>
                <th>Chargable<br>size(h)</th>
                <th>Chargable<br>size(w)</th>

                <th>No.of<br>Holes</th>
                <th>Cutouts</th>
                <th>Special</th><th>Qty</th>

                <th>Area<br>(sqmtr)</th>
                <th>UNIT Price<br>(USD M2)</th>
                <th>Amount<br>(USD)</th>
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
                    <td><?php echo $key['Proforma_Holes']; ?></td>
                    <td><?php echo $key['Proforma_Cutout']; ?></td>
                    <td><?php echo $key['Proforma_Special']; ?></td>
                    <td><?php echo $key['Proforma_Qty']; ?></td>

                    <td><?php echo $key['Proforma_Area_SQMTR']; ?></td>
                    <td><?php echo $key['Proforma_Material_Rate']; ?></td>
                    <td><?php echo $key['Proforma_Material_Cost']; ?></td>
                </tr>
                <?php $i++; } ?>
            <tr>
                <td colspan="9" style="font-weight: bold;text-align: right;" >Total Summary</td>

                <td class="total"><?php echo $invoice_total[0]['qty']; ?></td>
                <td class="total"><?php echo round($invoice_total[0]['area'], 3); ?></td>
                <td></td>
                <td class="total"><?php echo round($invoice_total[0]['rate'],3); ?></td>
            </tr>
        </table>

    <!--    <br style="width:100%;">-->
    <hr>
    <div id="page1" style="width: 100%;display: block; vertical-align: top;">
        <div style="width: 100%; text-align: left; display: inline-block; vertical-align: top;">

                      <div id="account">
                <h5><span>Delivery Period</span> : <?php echo $invoice[0]['Delivery_Period']; ?> Days</h5>
                <h5><span>Container Type</span> : <?php echo $invoice[0]['Container_Type']; ?></h5>
                <h5><span>Payment Terms</span>: <?php echo $invoice[0]['Payment_Terms']; ?></span></h5>
                <h5><span>Price Term</span>: <?php echo $invoice[0]['Price_Term']; ?></h5>
                <h5><span>Delivery Route</span>: <?php echo $invoice[0]['Delivery_Route']; ?></h5>
            </div>
        </div>

    </div>
    <hr>

    <div id="page1" style="width: 100%;display: block; vertical-align: top;">
        <div style="width: 100%; text-align: left; display: inline-block; vertical-align: top;">
            <div id="account">
                <h3 style="font-size: 13px;">Bank Details</h3>
                <h5><span>Account Name</span> : STRONGLASS TOUGH</h5>
                <h5><span>Bank Name</span>: <?php echo $st[0]['ST_Bank']; ?></span></h5>
                <h5><span>Account Number</span>: <?php echo $st[0]['ST_Bank_Account_Number']; ?></h5>
                <h5><span>IFSC</span>: <?php echo $st[0]['ST_Bank_Account_IFSC_Code']; ?></h5>
            </div>
        </div>
    </div>

</div>
</body>
</html>
