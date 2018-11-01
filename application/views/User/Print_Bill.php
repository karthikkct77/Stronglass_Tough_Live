<main class="app-content">
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>Invoice</h1>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12" >

                <?php
                $cars = array("original copy", "Trasport copy", "office copy");
                foreach ($cars as $key)
                {
                ?>
                    <div class="tile"  id="pagewidth">
                        <div class="row invoice">
                            <img style="position: absolute; width: 10% !important;height: auto;top: 1%;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
                            <h6>Invoice <span style="position: absolute; right: 20px;"><?php echo $key; ?></span></h6>
                            <h4><?php echo $st[0]['ST_Name']; ?></h4>
                            <h5><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?></h5>
                            <h6><span>Phone: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
                            <h6 style="margin: 0;"> Mob: <?php echo $st[0]['ST_Alternate_Phone']; ?> </h6>
                            <h6>GSTN: 33ACYFS4034L2ZJ</h6>
                            <h6>ECC-NO: ACYFS4034LEM001</h6>
                        </div>
                        <hr>
                        <form method="post" class="login-form" action="<?php echo site_url('User_Controller/save_bill'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Save ?');">
                            <div class="row">
                                <div class="col-md-4" style="border-right: 1px solid #000;">
                                    <h5>Consignee</h5>
                                    <div id="consign">

                                        <?php
                                        if($bill[0]['Customer_Address'] == "")
                                        {
                                            ?>
                                            <h5 id="coustomer" style="font-weight: bold;"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
                                            <h5 id="address" style="font-size: 14px"><?php echo $invoice[0]['Customer_Address_1']; echo '&nbsp'; ?>,<?php echo $invoice[0]['Customer_Address_2']; echo '&nbsp';?>,<?php echo $invoice[0]['Customer_Area']; ?></h5>
                                            <h5> <?php echo $invoice[0]['Customer_City']; echo '&nbsp'; ?><?php echo $invoice[0]['Customer_State']; ?></h5>
                                            <h5 id="phone">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></h5>
                                            <h5 id="email">Email: <?php echo $invoice[0]['Customer_Email_Id_1']; ?></h5>
                                            <h5 id="gstn">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></h5>
                                            <input type="hidden" name="email" value="<?php echo $invoice[0]['Customer_Email_Id_1']; ?>">
                                            <?php
                                        }
                                        else
                                        { ?>
                                            <h5 id="coustomer" style="font-weight: bold;"><?php echo $bill_customer[0]['Customer_Company_Name']; ?></h5>
                                            <h5 id="address"><?php echo $bill_customer[0]['Customer_Address_1']; echo '&nbsp'; ?>,<?php echo $bill_customer[0]['Customer_Address_2']; echo '&nbsp';?>,<?php echo $invoice[0]['Customer_Area']; ?></h5>
                                            <h5> <?php echo $bill_customer[0]['Customer_City']; echo '&nbsp'; ?><?php echo $bill_customer[0]['Customer_State']; ?></h5>
                                            <h5 id="phone">Phone: <?php echo $bill_customer[0]['Customer_Phone']; ?></h5>
                                            <h5 id="email">Email: <?php echo $bill_customer[0]['Customer_Email_Id_1']; ?></h5>
                                            <h5 id="gstn">GSTN: <?php echo $bill_customer[0]['Customer_GSTIN']; ?></h5>

                                            <?php
                                        }
                                        ?>

                                    </div>

                                </div>
                                <div class="col-md-4" style="border-right: 1px solid #000;">
                                    <h5>Delivery Address</h5>
                                    <div id="Buyer">
                                        <?php
                                        if($bill[0]['Delivery_Address'] == "")
                                        {
                                            ?>
                                            <h5 id="coustomer"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
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
                                            $myString = $bill[0]['Delivery_Address'];
                                            $myArray = explode(',', $myString);
                                            foreach ($myArray as $key)
                                            { ?>
                                                <h5><?php echo $key; ?> </h5>
                                            <?php }
                                            ?>

                                            <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" type="hidden" name="PI_Icode"  id="PI_Icode" value="<?php echo $invoice[0]['Proforma_Icode']; ?>" >
                                    <h5><span>Date</span><input type="hidden" name="invoice_date" id="invoice_date" value="<?php echo date("Y-m-d",strtotime($bill[0]['Created_On']));?>" readonly><?php echo date("Y-m-d",strtotime($bill[0]['Created_On'])); ?></h5>
                                    <h5><span>PI.NO</span><input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice[0]['Proforma_Number']; ?>" readonly><?php echo $invoice[0]['Proforma_Number']; ?></h5>
                                    <h5><span>Invoice No</span> <span style=" font-size: 26px; float: none;"><?php echo $bill[0]['Bill_Number']; ?></span></h5>
                                    <h5><span>Destination</span><?php echo $bill[0]['Destination']; ?></h5>
                                    <h5><span>Motor Vehicle No</span><?php echo $bill[0]['Vehicle_No']; ?></h5>
                                    <input type="hidden" name="work_order_no" value="<?php echo $work_order[0]['WO_Icode']; ?>">

                                </div>
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
                                    <div>Amount in Words: <span id="word" style="font-size: 15px;"><?php echo $bill[0]['Amt_Words']; ?> </span></div>


                                </div>
                                <div class="col-md-6">
                                    <?php
                                    if(empty($bill_Charges))
                                    {
                                    ?>
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


                                        <?php
                                        }
                                        else
                                        {
                                        ?>

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
                                            ?>
                                            <?php
                                            }

                                            if($bill[0]['Sub_Total'] == "")
                                            {
                                            ?>

                                            <tr>
                                                <td colspan="4" style="text-align: right;">SUB-TOTAL</td>

                                                <td><input class="form-control" type="hidden" name="sub_tot" id="sub_tot" value="<?php echo $invoice[0]['Sub_Total']; ?>" readonly ><?php echo $invoice[0]['Sub_Total']; ?></td>

                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align: right;">HANDLING CHARGE @2.42%</td>

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
                                                    <td colspan="4" style="text-align: right;">SGST @<?php echo $tax[0]['SGST%']; ?>%</td>

                                                    <td><input class="form-control" type="hidden" name="sgst" id="sgst" value="<?php echo $invoice[0]['SGST_Value']; ?>"readonly ><?php echo $invoice[0]['SGST_Value']; ?></td>

                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="text-align: right;">CGST @<?php echo $tax[0]['CGST%']; ?> %
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

                                        <?php
                                        }
                                        else
                                        {
                                        ?>

                                        <tr>
                                            <td colspan="4" style="text-align: right;">SUB-TOTAL</td>

                                            <td><input class="form-control" type="hidden" name="sub_tot" id="sub_tot" value="<?php echo $bill[0]['Sub_Total']; ?>" readonly ><?php echo $bill[0]['Sub_Total']; ?></td>

                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align: right;">HANDLING CHARGE @2.42%</td>

                                            <td><input class="form-control" type="hidden" name="insurance" id="insurance" value="<?php echo $bill[0]['Insurance_Value']; ?>" required readonly><?php echo $bill[0]['Insurance_Value']; ?></td>

                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align: right;">TRANSPORT</td>

                                            <td><input class="form-control" type="hidden" name="transport" id="transport"  value="<?php echo $bill[0]['Transport']; ?>" readonly><?php echo $bill[0]['Transport']; ?></td>

                                        </tr>
                                        <?php
                                        if($bill[0]['IGST_Value'] == '0')
                                        { ?>
                                            <tr>
                                                <td colspan="4" style="text-align: right;">SGST @<?php echo $tax[0]['SGST%']; ?>%</td>

                                                <td><input class="form-control" type="hidden" name="sgst" id="sgst" value="<?php echo $bill[0]['SGST_Value']; ?>"readonly ><?php echo $bill[0]['SGST_Value']; ?></td>

                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align: right;">CGST @<?php echo $tax[0]['CGST%']; ?>%
                                                    <input type="hidden" id="gst" value="<?php echo $tax[0]['CGST%']; ?>">
                                                </td>
                                                <td><input class="form-control" type="hidden" name="cgst" id="cgst" value="<?php echo $bill[0]['CGST_Value']; ?>" readonly ><?php echo $bill[0]['CGST_Value']; ?></td>

                                            </tr>

                                        <?php }
                                        else
                                        {?>
                                            <tr>
                                                <td colspan="4" style="text-align: right;">IGST @18%
                                                    <input type="hidden" id="gst" value="18">
                                                </td>
                                                <td><input class="form-control" type="hidden" name="igst" id="igst" value="<?php echo $bill[0]['IGST_Value']; ?>" readonly ><?php echo $bill[0]['IGST_Value']; ?></td>

                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>

                                            <td colspan="4" style="text-align: right;">GROSS TOTAL</td>
                                            <td><input class="form-control" type="hidden" name="gross_tot" id="gross_tot" readonly value="<?php echo $bill[0]['GrossTotal_Value']; ?>" ><h4><?php echo $bill[0]['GrossTotal_Value']; ?> /-</h4></td>

                                        </tr>
                                        </tfoot>
                                    </table>


                                <?php
                                }
                                ?>


                                </div>
                            </div>
                            <div id="Signature" style="margin-top: 20px; border: 1px solid ">

                                <div class="row"  style="height: 150px; padding: 10px;" >
                                    <div class="col-md-6">
                                        <p style="padding-left: 10px; font-weight: bold;">Customer Seal and Signature</p>
                                    </div>

                                    <div class="col-md-6">
                                        <p  style="margin-bottom:80px; text-align: right;margin-right: 10px; font-weight: bold;">For Stronglass Tough</p>

                                        <p style="font-weight: bold;" class="float-right">(Authorised Signatory)</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="with_print">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-danger pi_button " type="submit" id="with_print"><i class="fa fa-fw fa-lg fa-check-circle"></i>Delete Bill</button>

                                    <a class="btn btn-info" href="<?php echo site_url('User_Controller/Print_Bill/') . $invoice[0]['Proforma_Icode']; ?>">print</a>

                                </div>
                            </div>
                        </form>
                    </div>




                <?php
                }
                ?>


            </div>
        </div>
    </div>
</main>
<style type="text/css" media="print">
    .app-content{
        margin: 0px;
        padding: 0px;
    }
    #pagewidth {
        overflow: hidden ;


    }
    @media print {

        #with_print {
            display: none;
        }
        #pagewidth {   page-break-before: always;
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


<script>

    $(document).ready(function(){

        window.print();
        history.back();
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

