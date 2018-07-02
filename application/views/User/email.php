<html>
<body>
<div style="width: auto; background: #9e8b70; display: block;  padding: 15px; text-align: center;float: left; ">
    <img class="app-sidebar__user-avatar" src="<?php echo base_url('img/st.jpg'); ?>" alt="User Image">
    <h4><?php echo $st[0]['ST_Name']; ?></h4>
    <h5><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?></h5>
    <h6><span>Mob: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
    <hr>
    <div style="width: 33.3%;float: left;">
        <h5>Consignee</h5>
        <div id="consign">
            <h5 style="margin: 0;"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
            <h5 style="margin: 0;"><?php echo $invoice[0]['Customer_Company_Name']; ?>$nbsn;<?php echo $invoice[0]['Customer_Address_1']; ?>$nbsn;<?php echo $invoice[0]['Customer_Address_2']; ?></h5>
            <h5 style="margin: 0;">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></h5>
            <h5 style="margin: 0;">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></h5>
        </div>
    </div>
    <div style="width: 33.3%;float: left;">
        <h5>Buyer (if other than consignee)</h5>
        <div id="consign">
            <h5 style="margin: 0;"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
            <h5 style="margin: 0;"><?php echo $invoice[0]['Customer_Address_1']; ?>$nbsn;<?php echo $invoice[0]['Customer_Address_2']; ?></h5>
            <h5 style="margin: 0;">City: <?php echo $invoice[0]['Customer_City']; ?></h5>
            <h5 style="margin: 0;">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></h5>
            <h5 style="margin: 0;">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></h5>
        </div>
    </div>
    <div style="width: 33.3%;float: left;">
        <h5>Date/Number</h5>
        <input class="form-control" type="hidden" name="PI_Icode"  id="PI_Icode" value="<?php echo $invoice[0]['Proforma_Icode']; ?>" >
        <h4 style="margin: 0 0 15px 0; ">Proforma Invoice No:<span style="background: #fff;font-size: 25px;padding: 5px;"><?php echo $invoice[0]['Proforma_Number']; ?></span></h4>
        <h4 style="margin: 0;">Proforma Invoice Date:<span style="background: #fff;font-size: 25px;padding: 5px;"><?php echo $invoice[0]['Proforma_Date']; ?></span></h4>
    </div>
    <hr>
    <table border="1" style="width: 100%">
        <thead>
        <th>#</th>
        <th>Material</th>
        <th>Hsn code</th>
        <th>Special</th>
        <th>No.of Pieces</th>
        <th>No.of Holes</th>
        <th>Actucal Size(W)(MM)</th>
        <th>Actucal Size(H)(MM)</th>
        <th>Chargable Size(W)(MM)</th>
        <th>Chargable Size(H)(MM)</th>
        <th>Area(SQMTR)</th>
        <th>Rate(SQMTR)</th>
        <th>Total(INR)</th>
        </thead>
        <tbody>
        <?php $i=1; foreach ($invoice_item as $key) { ?>
            <tr id="row<?php echo $i; ?>">
                <input class="form-control" type="hidden" name="material[]"  value="<?php echo $key['Proforma_Invoice_Items_Icode']; ?>" >
                <input class="form-control" type="hidden" name="pics[]"  value="<?php echo $key['Proforma_Qty']; ?>" >
                <td><?php echo $i; ?></td>
                <td><?php echo $key['Material_Name']; ?></td>
                <td><?php echo $key['Proforma_HSNCode']; ?></td>
                <td><?php echo $key['Proforma_Special']; ?></td>
                <td><?php echo $key['Proforma_Qty']; ?></td>
                <td><?php echo $key['Proforma_Holes']; ?></td>
                <td><?php echo $key['Proforma_Actual_Size_Width']; ?></td>
                <td><?php echo $key['Proforma_Actual_Size_Height']; ?></td>
                <td><?php echo $key['Proforma_Chargeable_Size_Width']; ?></td>
                <td><?php echo $key['Proforma_Chargeable_Size_Height']; ?></td>
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
            <td><?php echo $invoice_total[0]['qty']; ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?php echo round($invoice_total[0]['area'], 2); ?></td>
            <td></td>
            <td> <?php echo round($invoice_total[0]['rate'],2); ?>(INR)</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <div style="width: 50%;float: left;">
        <h3>Terms & Conditions</h3>
        <p style="font-size: 16px;text-align: justify; padding-right: 15px;">
            We Shall not be responsible for any type of Breakage/Loss in Transit.
            At the time of transit Breakage/Loss insurance claim will be done by
            the customer and not by the company.
            Any discrepancies observed in the supply like quantity,specification,
            quality, etc.
        </p>
      <div style="text-align: left!important;float: left;">
          <h4>Bank Details</h4>
          <h5>Stronglass Tough</h5>
          <h5>A/C Type: <span><?php echo $st[0]['ST_Bank_Account_Type']; ?></span></h5>
          <h5>A/C Number: <span><?php echo $st[0]['ST_Bank_Account_Number']; ?></span></h5>
          <h5>Name: <span><?php echo $st[0]['ST_Bank']; ?></span></h5>
          <h5>IFSC:<span><?php echo $st[0]['ST_Bank_Account_IFSC_Code']; ?></span> </h5>

      </div>

    </div>
    <div >
        <table border="1" style="width: 50%;float: left;" >
            <thead>
            <th>#</th>
            <th>Select Charges</th>
            <th>No.of pieces</th>
            <th>Price</th>
            <th>Total</th>
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
                <td colspan="4"  align="right">SUB-TOTAL</td>

                <td><?php echo $invoice[0]['Sub_Total']; ?></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4"  align="right">HANDLING CHARGE</td>

                <td><?php echo $invoice[0]['Insurance_Value']; ?></td>
                <td></td>
            </tr>
            <tr>
                <td  colspan="4" align="right">TRANSPORT</td>

                <td><?php echo $invoice[0]['Transport']; ?></td>
                <td></td>
            </tr>
            <?php
            if($invoice[0]['IGST_Value'] == '0')
            { ?>
                <tr>
                    <td colspan="4" align="right">SGST @<?php echo $tax[0]['SGST%']; ?></td>

                    <td><?php echo $invoice[0]['SGST_Value']; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4" align="right">CGST @<?php echo $tax[0]['CGST%']; ?>
                        <input type="hidden" id="gst" value="<?php echo $tax[0]['CGST%']; ?>">
                    </td>
                    <td><?php echo $invoice[0]['CGST_Value']; ?></td>
                    <td></td>
                </tr>

            <?php }
            else
            {?>
                <tr>
                    <td colspan="4" align="right">IGST @18%
                        <input type="hidden" id="gst" value="18">
                    </td>
                    <td><?php echo $invoice[0]['IGST_Value']; ?></td>
                    <td></td>
                </tr>
                <?php
            }
            ?>
            <tr>

                <td colspan="4" align="right">GROSS TOTAL</td>
                <td><h3 style="background: #fff;font-size: 25px;padding: 5px;"><?php echo $invoice[0]['GrossTotal_Value']; ?></h3></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
    <hr>
</div>
</body>
</html>