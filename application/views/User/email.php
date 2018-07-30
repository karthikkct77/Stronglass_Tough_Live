<html>
<head>
</head>
<body>
<div style="width: 100%; display: block;text-align: center;">
    <img style="position: absolute;width: 100px;height: auto;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
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
            <h4 style="margin: 0;">Date/Number</h4>
            <p style="margin: 0 0 15px 0;margin-bottom:5px;font-size: 14px;">Proforma Invoice No:<br><span style="font-size: 18px !important;font-weight: bold;"><?php echo $invoice[0]['Proforma_Number']; ?></span></p>
            <p style="margin: 0;margin-bottom:5px;font-size: 14px;">Proforma Invoice Date:<br><span style="font-size: 18px !important;font-weight: bold;"><?php echo $invoice[0]['Proforma_Date']; ?></span></p>
        </div>
    </div>
    <br style="width:100%;clear:both;">
    <hr>
    <br>
    <table border="1" >
        <thead>
        <tr style="background-color:#FFFF00;color:#0000FF;">
            <td width="10" align="center">#</td>
            <td width="10" align="center">Material</td>
            <td width="10" align="center">Special</td>
            <td width="10" align="center">Pieces</td>
            <td width="10" align="center"> Holes</td>
            <td width="10" align="center">Actucal Size(W)</td>
            <td width="10" align="center">Actucal Size(H)</td>
            <td width="30" align="center">Chargable Size(W)</td>
            <td width="30" align="center">Chargable Size(H)</td>
            <td width="30" align="center">Area</td>
            <td width="30" align="center">Rate</td>
            <td width="30" align="center">Total</td>
        </tr>
        </thead>
        <?php $i=1; foreach ($invoice_item as $key) { ?>
            <tr>
                <td width="10"><?php echo $i; ?></td>
                <td width="10"><?php echo $key['Material_Name']; ?></td>
                <td width="10"><?php echo $key['Proforma_Special']; ?></td>
                <td width="10"><?php echo $key['Proforma_Qty']; ?></td>
                <td width="10"><?php echo $key['Proforma_Holes']; ?></td>
                <td width="10"><?php echo $key['Proforma_Actual_Size_Width']; ?></td>
                <td width="30"><?php echo $key['Proforma_Actual_Size_Height']; ?></td>
                <td width="30"><?php echo $key['Proforma_Chargeable_Size_Width']; ?></td>
                <td width="30"><?php echo $key['Proforma_Chargeable_Size_Height']; ?></td>
                <td width="30"><?php echo $key['Proforma_Area_SQMTR']; ?></td>
                <td width="30"><?php echo $key['Proforma_Material_Rate']; ?></td>
                <td width="30"><?php echo $key['Proforma_Material_Cost']; ?></td>
            </tr>
            <?php $i++; } ?>



    </table>
</div>
</body>
</html>