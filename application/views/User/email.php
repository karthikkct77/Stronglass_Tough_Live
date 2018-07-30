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
            text-align: center;

        }
    </style>
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
                   <td><?php echo $key['Material_Name']; ?></td>
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
       </table>

   <?php } ?>




</div>
</body>
</html>