<style type="text/css" media="print">
    @page
    {
        margin: 0mm;  /* this affects the margin in the printer settings */
    }
</style>
<style>
    @media print {
        #with_print {
            display: none;
        }
    }
    #search_data {
        width: 200px;
        padding: 5px;
        margin: 5px 0;
        box-sizing: border-box;
    }
    #autoSuggestionsList > li {
        background: none repeat scroll 0 0 #F3F3F3;
        border-bottom: 1px solid #E3E3E3;
        list-style: none outside none;
        padding: 3px 15px 3px 15px;
        text-align: left;
    }

    #autoSuggestionsList > li a { color: #800000; }

    .auto_list {
        border: 1px solid #E3E3E3;
        border-radius: 5px 5px 5px 5px;
        position: absolute;
    }
    .pi_button{
        margin-right: 15px;
        float: right;
    }
    .st_check{
        padding-top: 15px;
        border-top: 1px solid #000000;
        text-align: center;
    }
</style>
<main class="app-content">
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>Profoma Invoice</h1>
            </div>
        </div>
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
            <div class="col-md-12" >

                <div class="tile">
                    <div class="row invoice">
                        <img style="position: absolute;width: 100px;height: auto;top: 1%;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
                        <h4><?php echo $st[0]['ST_Name']; ?></h4>
                        <h5><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?></h5>
                        <h6><span>Mob: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
                    </div>
                    <hr>
                    <form method="post" class="login-form" action="<?php echo site_url('User_Controller/Update_Sheet_Invoice'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Save ?');">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Consignee</h5>
                                <input  class="form-control" style="display: none;" name="search_data" id="search_data" type="text" value="<?php echo $invoice[0]['Customer_Company_Name']; ?>" required readonly>
                                <input  class="form-control" name="company_name" id="company_name" type="hidden" value="<?php echo $invoice[0]['consignee']; ?>">

                                <div id="consign">
                                    <h5 id="coustomer"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
                                    <h5 id="address"><?php echo $invoice[0]['Customer_Address_1']; echo '&nbsp'; ?>,<?php echo $invoice[0]['Customer_Address_2']; echo '&nbsp';?>,<?php echo $invoice[0]['Customer_Area']; ?></h5>
                                    <h5> <?php echo $invoice[0]['Customer_City']; echo '&nbsp'; ?><?php echo $invoice[0]['Customer_State']; ?></h5>
                                    <h5 id="phone">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></h5>
                                    <h5 id="email">Email: <?php echo $invoice[0]['Customer_Email_Id_1']; ?></h5>
                                    <h5 id="gstn">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></h5>
                                    <input type="hidden" name="email" value="<?php echo $invoice[0]['Customer_Email_Id_1']; ?>">
                                </div>

                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <!--                                <input type="checkbox" name="check" id="check" checked onclick="FillBilling()">-->
                                    <!--                                <em>Check this box if Current Address and Mailing permanent are the same.</em>-->
                                </div>

                            </div>
                            <div class="col-md-4">
                                <h5>Buyer (if other than consignee)</h5>
                                <div id="Buyer">
                                    <?php
                                    if($invoice[0]['Customer_Address_Icode'] == "")
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
                                        ?>
                                        <h5 id="coustomer"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
                                        <h5 id="address"><?php echo $invoice[0]['Customer_Add_Address_1']; ?>&nbsn;<?php echo $invoice[0]['Customer_Add_Address_2']; ?></h5>
                                        <h5 id="phone">City: <?php echo $invoice[0]['Customer_Add_City']; ?></h5>
                                        <h5 id="phone">Phone: <?php echo $invoice[0]['Customer_Add_Phone']; ?></h5>
                                        <h5 id="gstn">GSTN: <?php echo $invoice[0]['Customer_Add_Email_Id_1']; ?></h5>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" type="hidden" name="PI_Icode"  id="PI_Icode" value="<?php echo $invoice[0]['Proforma_Icode']; ?>" >
                                <h4><span>P.INV.No</span>: <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice[0]['Proforma_Number']; ?>" readonly><?php echo $invoice[0]['Proforma_Number']; ?></h4>
                                <h4><span>Date </span>:<input type="hidden" name="invoice_date" id="invoice_date" value="<?php echo $invoice[0]['Proforma_Date']; ?>" readonly><?php echo $invoice[0]['Proforma_Date']; ?></h4>
                                <h6><span>Total Outstanding</span>:<input type="text" class="form-control" name="outstanding" id="outstanding" value="<?php echo $invoice[0]['Total_Outstanding']; ?>" required> </h6>
                                <h6><span>Credit Limit Amt</span>:<input type="text" class="form-control" name="credit_limit" id="credit_limit" value="<?php echo $invoice[0]['Credit_Limit']; ?>" required> </h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-6">
                                <textarea class="form-control" name="material_area"  placeholder="Enter Extra Glass" value="<?php echo $invoice[0]['Material_Area']; ?>"><?php echo $invoice[0]['Material_Area']; ?></textarea>
                            </div>
                        </div>
                        <br>
                        <h6 style="text-align: center">Total Number of Sheets used to Cut the following glasses</h6>
                        <div class="row">
                            <table class="table table-hover table-bordered" id="sampleTable2">
                                <thead>
                                <th>#</th>
                                <th>Select Material</th>
                                <th style="width: 6%;">No.of<br>sheet</th>
                                <th>Act<br>Size(h)</th>
                                <th>Act<br>Size(w)</th>
                                <th>cha<br>Size(h)</th>
                                <th>cha<br>Size(w)</th>
                                <th>Area</th>
                                <th>Rate</th>
                                <th>Amount</th>

                                </thead>
                                <tbody>
                                <?php $i=1; foreach ($sheet as $key) { ?>
                                <tr>
                                    <td><?php echo $i; ?><input type="hidden" name="sheet_icode[]" value="<?php echo $key['pi_sheet_icode']; ?>"></td>
                                    <td>     <div class="form-group">
                                            <select name="sheet_material[]" class="form-control" id="sheet_material<?php echo $i; ?>"  required >
                                                <option value="<?php echo $key['Proforma_Material_Icode']; ?>" ><?php echo $key['Material_Name']; ?></option>
                                                <?php foreach ($stock as $row):
                                                {
                                                    echo '<option value= "'.$row['Material_Icode'].'">' . $row['Material_Name'] . '</option>';
                                                }
                                                endforeach; ?>
                                            </select>
                                        </div>

                                    </td>

                                    <td><input class="form-control" type="number" name="sheet_pieces[]" id="sheet_pieces<?php echo $i; ?>"  value="<?php echo $key['No_Of_Sheet']; ?>"  onkeyup="change_sheet_qty('<?php echo $i; ?>')" required></td>
                                    <td><input class="form-control" type="number" name="sheet_Act_Size_H[]" id="sheet_Act_Size_H<?php echo $i; ?>"  value="<?php echo $key['Actual_Height']; ?>"  onkeyup="change_sheet_height('<?php echo $i; ?>')" required ></td>
                                    <td><input class="form-control" type="number" name="sheet_Act_Size_W[]" id="sheet_Act_Size_W<?php echo $i; ?>"  value="<?php echo $key['Actual_Width']; ?>" onkeyup="change_sheet_width('<?php echo $i; ?>')" required ></td>
                                    <td><input class="form-control" type="number" name="sheet_Cha_Size_H[]" id="sheet_Cha_Size_H<?php echo $i; ?>"  value="<?php echo $key['Chargable_Height']; ?>" readonly required ></td>
                                    <td><input class="form-control" type="number" name="sheet_Cha_Size_W[]" id="sheet_Cha_Size_W<?php echo $i; ?>"  value="<?php echo $key['Chargable_Width']; ?>" readonly  required></td>
                                    <td><input class="form-control" type="text" name="sheet_Area[]" id="sheet_Area<?php echo $i; ?>"  value="<?php echo $key['Area']; ?>" required readonly ></td>
                                    <td><input class="form-control" type="number" name="sheet_Rate[]" id="sheet_Rate<?php echo $i; ?>"  value="<?php echo $key['Rate']; ?>"  onkeyup="change_sheet_rate('<?php echo $i; ?>')" required ></td>
                                    <td><input class="form-control" type="text" name="sheet_Rate_Amt[]" id="sheet_Rate_Amt<?php echo $i; ?>"  value="<?php echo $key['Total_Amount']; ?>"  readonly></td>
                                </tr>
                                </tbody>
                                <tfoot>

                                </tfoot>
                                <?php
                                $i++;
                                }
                                ?>
                            </table>
                        </div>
                        <div class="row">
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                <th>#</th>
                                <th>Material</th>
                                <th style="width: 10%;">Actual<br>size(H)</th>
                                <th style="width: 10%;">Actual<br>size(W)</th>
                                <th style="width: 6%;">No.of<br>Pieces</th>
                                <th style="width: 6%;">No.of<br>Holes</th>
                                <th style="width: 6%;">Cutouts</th>
                                <th style="width: 6%;">Special</th>
                                <th>Area<br>(SQMTR)</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach ($invoice_item as $key) { ?>

                                    <tr id="row<?php echo $i; ?>">

                                        <td><?php echo $i; ?>
                                            <input type="hidden" name="item_icode[]" value="<?php echo $key['pi_item_sheet_icode']; ?>" >

                                        </td>
                                        <td><select id="material<?php echo $i; ?>" name="material[]" class="form-control">
                                                <option value="<?php echo $key['Proforma_Material_Icode']; ?>" ><?php echo $key['Material_Name']; ?></option>


                                            </select>
                                        </td>
                                        <td><input class="form-control" type="text" name="height[]" id="height<?php echo $i; ?>" value="<?php echo $key['Proforma_Actual_Size_Height']; ?>" onkeyup="change_Charge_Height('<?php echo $i; ?>')"   required></td>
                                        <td><input class="form-control" type="text" name="width[]" id="width<?php echo $i; ?>" value="<?php echo $key['Proforma_Actual_Size_Width']; ?>" onkeyup="change_Charge_Width('<?php echo $i; ?>')" required></td>
                                        <td><input class="form-control" type="text" name="pics[]" id="pics<?php echo $i; ?>" value="<?php echo $key['Proforma_Qty']; ?>" onkeyup="change_no_piece('<?php echo $i; ?>')" required></td>
                                        <td><input class="form-control" type="text" name="holes[]" id="holes<?php echo $i; ?>" value="<?php echo $key['Proforma_Holes']; ?>" onkeyup="change_no_holes('<?php echo $i; ?>')" required></td>
                                        <td><input class="form-control" type="text" name="cutout[]" id="cutout<?php echo $i; ?>" value="<?php echo $key['Proforma_Cutout']; ?>" onkeyup="change_cutout('<?php echo $i; ?>')" required></td>
                                        <td><input class="form-control" type="text" name="type[]" id="type<?php echo $i; ?>" value="<?php echo $key['Proforma_Special']; ?>" required></td>

                                        <?php
                                        if($key['Proforma_Area_SQMTR'] > 5)
                                        {
                                            ?>
                                            <td><input class="form-control new_area pi_textbox" style="color: red;" type="text" name="area[]" id="area<?php echo $i; ?>" value="<?php echo $key['Proforma_Area_SQMTR']; ?>" readonly></td>

                                            <?php
                                        }
                                        else{
                                            ?>
                                            <td><input class="form-control new_area1 pi_textbox" type="text"  name="area[]" id="area<?php echo $i; ?>" value="<?php echo $key['Proforma_Area_SQMTR']; ?>" readonly></td>

                                        <?php }
                                        ?>
                                        <td><input class="form-control" type="text" name="rate[]" value="<?php echo $key['Proforma_Material_Rate']; ?>" id="rate<?php echo $i; ?>" onkeyup="change_rate('<?php echo $i; ?>')" ></td>
                                        <td><input class="form-control" type="text" name="total[]" value="<?php echo $key['Proforma_Material_Cost']; ?>" id="total<?php echo $i; ?>" readonly  ></td>



                                    </tr>
                                    <?php $i++; } ?>
                                <tr>
                                    <td colspan="4" align="right" style="font-weight: bold;" >Total Summary</td>
                                    <td><input type="text" class="form-control pull-right" id="total_pic" value="<?php echo $invoice_total[0]['qty']; ?>"readonly/></td>
                                    <td><input type="text" class="form-control pull-right" id="total_holes" value="<?php echo $invoice_total[0]['holes']; ?>"   readonly/></td>
                                    <td><input type="text" class="form-control pull-right" id="total_cutout" value="<?php echo $invoice_total[0]['cutout']; ?>"readonly/></td>
                                    <td></td>
                                    <td><input type="text" class="form-control pull-right" id="total_area" value="<?php echo round($invoice_total[0]['area'], 2); ?>"   readonly/></td>
                                    <td></td>
                                    <td> <input type="text" class="form-control pull-right" id="grand_total" value="<?php echo round($invoice_total[0]['rate'],2); ?>"   readonly/>(INR)</td>

                                </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div style="" class="form-group row">
                                    <label class="control-label" style="font-weight: bold;">Delivery Period</label>
                                    <div class="col-md-8">
                                        <input class="form-control col-md-3" type="text" name="delivery"  value="<?php echo $invoice[0]['Delivery_Days']; ?>" required>
                                    </div>
                                </div>
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
                                <h4>Bank Details</h4>
                                <h5>Stronglass Tough</h5>
                                <h5>A/C Type: <span><?php echo $st[0]['ST_Bank_Account_Type']; ?></span></h5>
                                <h5>A/C Number: <span><?php echo $st[0]['ST_Bank_Account_Number']; ?></span></h5>
                                <h5>Name: <span><?php echo $st[0]['ST_Bank']; ?></span></h5>
                                <h5>IFSC:<span><?php echo $st[0]['ST_Bank_Account_IFSC_Code']; ?></span> </h5>

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
                                    <tbody>
                                    <?php
                                    $i=1;
                                    foreach ($invoice_Charges as $key) {
                                        ?>
                                        <tr id="charge<?php echo $key['Proforma_Material_PC_Icode']; ?>">
                                            <td><input type="hidden" name="Delete_charges[]" class="form-control" value="<?php echo $key['charge_icode']; ?>" ><?php echo $key['charge_name']; ?>
                                                <input type="hidden" name="charge_icode[]" class="form-control" value="<?php echo $key['Proforma_Material_PC_Icode']; ?>" >
                                            </td>
                                            <td><input type="text" id="charges_count<?php echo $key['Proforma_Material_PC_Icode']; ?>" name="Delete_charges_count[]" class="form-control" value="<?php echo $key['Proforma_Charge_Count']; ?>" onkeyup="change_charge_count('<?php echo $key['Proforma_Material_PC_Icode']; ?>')"  ></td>
                                            <td><input type="text" id="charges_value<?php echo $key['Proforma_Material_PC_Icode']; ?>" name="Delete_charges_value[]" class="form-control" value="<?php echo $key['Proforma_Charge_Value']; ?>" onkeyup="change_charge_value('<?php echo $key['Proforma_Material_PC_Icode']; ?>')"  ></td>
                                            <td><input class="form-control" type="text" name="tot_charge_amt[]" id="tot_charge_amt<?php echo $key['Proforma_Material_PC_Icode']; ?>" value="<?php echo $key['Proforma_Charge_Cost']; ?>"  readonly></td>
                                            <td><input type="button" onclick="delete_charges('<?php echo $key['Proforma_Material_PC_Icode']; ?>')" value="Delete"></input>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>

                                        <td><div class="form-group">
                                                <select name="charges[]" class="form-control" id="charges"   >
                                                    <option value="" >Select Charges</option>
                                                    <?php foreach ($charges as $row):
                                                    {
                                                        echo '<option value= "'.$row['charge_icode'].'">' . $row['charge_name'] . '</option>';
                                                    }
                                                    endforeach; ?>
                                                </select>
                                            </div></td>
                                        <td><input class="form-control" type="text" name="no_holes[]" id="no_holes" ></td>
                                        <td><input class="form-control" type="text" name="charge_amt[]" id="charge_amt"  ></td>
                                        <td><input class="form-control" type="text" name="tot_charge_amt[]" id="tot_charge_amount"  >
                                            <input class="form-control" type="hidden" name="tot_charge_amounts[]" id="tot_charge_amount1"
                                        </td>
                                        <td><input type="button" onclick="Add_one()" value="Add" id="Add" /></td>
                                    </tr>

                                    <tr>
                                        <td colspan="4" align="right">SUB-TOTAL</td>

                                        <td><input class="form-control" type="text" name="sub_tot" id="sub_tot" value="<?php echo $invoice[0]['Sub_Total']; ?>" readonly ></td>

                                    </tr>
                                    <tr>
                                        <td colspan="4" align="right">HANDLING CHARGE</td>

                                        <td><input class="form-control" type="text" name="insurance" id="insurance" value="<?php echo $invoice[0]['Insurance_Value']; ?>" required readonly></td>

                                    </tr>
                                    <tr>
                                        <td colspan="4" align="right">TRANSPORT</td>

                                        <td><input class="form-control" type="text" name="transport" id="transport" onkeyup="change_transport(this.value)"   value="<?php echo $invoice[0]['Transport']; ?>" required></td>

                                    </tr>
                                    <?php
                                    if($invoice[0]['IGST_Value'] == '0' || $invoice[0]['IGST_Value'] == '')
                                    { ?>
                                        <tr>
                                            <td colspan="4" align="right">SGST @<?php echo $tax[0]['SGST%']; ?>
                                                <input type="hidden" id="igst" value=""></td>

                                            <td><input class="form-control" type="text" name="sgst" id="sgst" value="<?php echo $invoice[0]['SGST_Value']; ?>"readonly ></td>

                                        </tr>
                                        <tr>
                                            <td colspan="4" align="right">CGST @<?php echo $tax[0]['CGST%']; ?>
                                                <input type="hidden" id="gst" value="<?php echo $tax[0]['CGST%']; ?>"
                                                >
                                            </td>
                                            <td><input class="form-control" type="text" name="cgst" id="cgst" value="<?php echo $invoice[0]['CGST_Value']; ?>" readonly ></td>

                                        </tr>

                                    <?php }
                                    else
                                    {?>
                                        <tr>
                                            <td colspan="4" align="right">IGST @18%
                                                <input type="hidden" id="gst" value="18">
                                            </td>
                                            <td><input class="form-control" type="text" name="igst" id="igst" value="<?php echo $invoice[0]['IGST_Value']; ?>" readonly ></td>

                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>

                                        <td colspan="4" align="right">GROSS TOTAL</td>
                                        <td><input class="form-control" type="text" name="gross_tot" id="gross_tot" readonly value="<?php echo $invoice[0]['GrossTotal_Value']; ?>" >(INR)</td>

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
                            <div>Amount in Words: <span id="word" style="font-size: 20px;margin-left: 10px;"></span>
                                <input type="hidden" name="amt_words" id="amt_words"></div>
                            <script>
                                $("#insurance").on('change keyup paste', function() {
                                    var sub_tot =document.getElementById('sub_tot').value;
                                    var insurance =document.getElementById('insurance').value;
                                    var gst = document.getElementById('gst').value;
                                    var sum = ((parseFloat(sub_tot) + parseFloat(insurance)) * gst / 100 );
                                    document.getElementById('sgst').value = parseFloat(sum).toFixed(2);
                                    document.getElementById('cgst').value = parseFloat(sum).toFixed(2);
                                    var sgst = document.getElementById('sgst').value;
                                    var cgst = document.getElementById('cgst').value;
                                    var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(sgst) + parseFloat(cgst));
                                    document.getElementById('gross_tot').value = parseInt(grant);
                                });
                            </script>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-danger pull-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update PI</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<script>

    $( document ).ready(function() {
        number_to_words();
    });

    $("#company_name2").change(function () {
        $.ajax({
            url:"<?php echo site_url('Admin_Controller/get_Customer_Address_Details'); ?>",
            data: {id:
                $(this).val()},
            type: "POST",
            success:function(server_response){
                var data = $.parseJSON(server_response);
                $('#Buyer').show();
                document.getElementById('coustomer1').innerHTML = data[0]['Customer_Company_Name'];
                document.getElementById('address1').innerHTML = data[0]['Customer_Add_Address_1'] + data[0]['Customer_Add_Area'] + data[0]['Customer_Add_City'] ;
                document.getElementById('phone1').innerHTML = "Mob :" + data[0]['Customer_Add_Phone'];
                document.getElementById('gstn1').innerHTML = "GSTIN :" + data[0]['Customer_Add_GSTIN'];
            }
        });
    });
    $("#no_holes").on('change keyup paste', function() {
        var holes = parseFloat($(this).val());
        var amt = parseFloat($('#charge_amt').val());
        var total =  parseFloat(holes * amt);
        document.getElementById('tot_charge_amount').value = parseFloat(total).toFixed(3);
        document.getElementById('tot_charge_amount1').value = parseFloat(total).toFixed(3);

        var totals =document.getElementsByName("tot_charge_amt[]");
        var sum1 = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum1 +=val;
            }
        }
        var totals_amt =document.getElementsByName("sheet_Rate_Amt[]");
        var sum_amt = 0;
        for (var j = 0, iLen = totals_amt.length; j < iLen; j++) {
            if (totals_amt[j].value!==""){
                val=parseFloat(totals_amt[j].value);
                sum_amt +=val;
            }
        }
        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot = parseFloat(sum1) + parseFloat(grant_tot) + parseFloat(sum_amt) ;
        document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
        var sub_tot =document.getElementById('sub_tot').value;
        var insurance =document.getElementById('insurance').value;
        var igst =document.getElementById('igst').value;
        if(igst == '')
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

    });
    $("#charges").change(function () {
        $.ajax({
            url:"<?php echo site_url('Admin_Controller/Edit_Charges'); ?>",
            data: {id:
                $(this).val()},
            type: "POST",
            success:function(server_response){
                var data = $.parseJSON(server_response);
                var  price = data[0]['charge_current_price'];
                document.getElementById('charge_amt').value = price;
            }
        });
    });
    // Charge Amount
    $("#charge_amt").on('change keyup paste', function() {
        var amt = parseFloat($('#charge_amt').val());
        var holes = parseFloat($('#no_holes').val());
        var total =  parseFloat(holes * amt);
        document.getElementById('tot_charge_amount').value =parseFloat(total).toFixed(3);
        document.getElementById('tot_charge_amount1').value =parseFloat(total).toFixed(3);

        var totals =document.getElementsByName("tot_charge_amt[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }
        var totals_amt =document.getElementsByName("sheet_Rate_Amt[]");
        var sum_amt = 0;
        for (var j = 0, iLen = totals_amt.length; j < iLen; j++) {
            if (totals_amt[j].value!==""){
                val=parseFloat(totals_amt[j].value);
                sum_amt +=val;
            }
        }
        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot = parseFloat(sum) + parseFloat(grant_tot) + parseFloat(sum_amt) ;
        document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
        var tax = 2.42;
        var totals = parseFloat (sub_tot * tax / 100);
        document.getElementById('insurance').value = parseFloat(totals).toFixed(3);
        var insurance = totals;
        var igst =document.getElementById('igst').value;
        if(igst == '')
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


    });

    $("#Add").click(function () {
        if($('#charges').val() == "")
        {
            alert("Please Select Charges...");
        }
        else if($('#no_holes').val() == ""){
            alert("Please enter No.of pieces...");
        }
        else
        {
            var chrgs = $("#charges option:selected").text();
            AddRow($('#charges').val(), $("#no_holes").val(),$("#charge_amt").val(),$("#tot_charge_amount").val(),chrgs);
            $("#charges").val("");
            $("#no_holes").val("");
            $("#charge_amt").val("");
            $("#tot_charge_amount").val("");
        }
    });
    function AddRow(charges,no_holes,charge_amt,tot_charge_amt,chrgs) {
        var tBody = $("#sampleTable1 > TBODY")[0];
        //Add Row.
        row = tBody.insertRow(-1);
        //Add Name cell.
        var cell = $(row.insertCell(-1));
        var stock = $("<input />");
        stock.attr("type", "hidden");
        stock.attr("name", "charges[]");
        stock.val(charges);
        cell.append(stock);

        var tech1 = $("<input />");
        tech1.attr("type", "text");
        tech1.attr("name", "test");
        tech1.attr("class", "form-control");
        tech1.attr('readonly', true);
        tech1.val(chrgs);
        cell.append(tech1);

        var cell = $(row.insertCell(-1));
        var cty = $("<input />");
        cty.attr("type", "text");
        cty.attr("class", "form-control");
        cty.attr("name", "no_holes[]");
        cty.attr('readonly', true);
        cty.val(no_holes);
        cell.append(cty);

        var cell = $(row.insertCell(-1));
        var cty1 = $("<input />");
        cty1.attr("type", "text");
        cty1.attr("class", "form-control");
        cty1.attr("name", "charge_amt[]");
        cty1.attr('readonly', true);
        cty1.val(charge_amt);
        cell.append(cty1);

        var cell = $(row.insertCell(-1));
        var cty2 = $("<input />");
        cty2.attr("type", "text");
        cty2.attr("class", "form-control");
        cty2.attr("name", "tot_charge_amt[]");
        cty2.attr('readonly', true);
        cty2.val(tot_charge_amt);
        cell.append(cty2);

        var cell = $(row.insertCell(-1));
        var cty3 = $("<input />");
        cty3.attr("type", "hidden");
        cty3.attr("class", "form-control");
        cty3.attr("name", "tot_charge_amounts[]");
        cty3.attr('readonly', true);
        cty3.val(tot_charge_amt);
        cell.append(cty3);

        cell = $(row.insertCell(-1));
        var btnRemove = $("<input />");
        btnRemove.attr("type", "button");
        btnRemove.attr("onclick", "Remove(this);");
        btnRemove.val("Remove");
        cell.append(btnRemove);
    };
    function Remove(button) {
        //Determine the reference of the Row using the Button.
        var row = $(button).closest("TR");
        var name = $("TD", row).eq(0).html();
        if (confirm("Do you want to delete: ")) {
            //Get the reference of the Table.
            var table = $("#sampleTable1")[0];
            //Delete the Table row using it's Index.
            table.deleteRow(row[0].rowIndex);
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
        }
    };
    function FillBilling() {
        if($('#check').is(":checked"))
        {
            $('#Buyer').show();
            $('#company_name2').hide();
            document.getElementById('coustomer1').innerHTML =  document.getElementById('coustomer').innerHTML;
            document.getElementById('address1').innerHTML  = document.getElementById('address').innerHTML;
            document.getElementById('phone1').innerHTML =  document.getElementById('phone').innerHTML
            document.getElementById('gstn1').innerHTML =  document.getElementById('gstn').innerHTML;
        }
        else
        {
            $('#Buyer').hide();
            $('#company_name2').show();
        }
    }
    function get_result(id) {
        var pcs = document.getElementById('pics'+id).value;
        var area = document.getElementById('area'+id).value;
        $("#material"+id).change(function () {
            $.ajax({
                url:"<?php echo site_url('Admin_Controller/Edit_Material'); ?>",
                data: {id:
                    $(this).val()},
                type: "POST",
                success:function(server_response){
                    var data = $.parseJSON(server_response);
                    var amount = data[0]['Material_Current_Price'];
                    var total = pcs * area * amount;
                    document.getElementById('total'+id).value = total.toFixed(2);
                    document.getElementById('rate'+id).value = amount;
                    // Grand Total
                    var totals =document.getElementsByName("total[]");
                    var sum = 0;
                    for (var j = 0, iLen = totals.length; j < iLen; j++) {
                        if (totals[j].value!==""){
                            val=parseFloat(totals[j].value);
                            sum +=val;
                        }
                    }
                    document.getElementById('grand_total').value = parseFloat(sum).toFixed(2);

                    // total pices
                    var pices =document.getElementsByName("pics[]");
                    var sum_pic = 0;
                    for (var j = 0, iLen = pices.length; j < iLen; j++) {
                        if (pices[j].value!==""){
                            val=parseFloat(pices[j].value);
                            sum_pic +=val;
                        }
                    }
                    document.getElementById('total_pic').value = parseInt(sum_pic);

                    //total area
                    var areas =document.getElementsByName("area[]");
                    var sum_area = 0;
                    for (var j = 0, iLen = areas.length; j < iLen; j++) {
                        if (areas[j].value!==""){
                            val=parseFloat(areas[j].value);
                            sum_area +=val;
                        }
                    }
                    document.getElementById('total_area').value = parseFloat(sum_area).toFixed(2);

                }
            });
        });
    }

    function change_rate(id) {
        var pcs = document.getElementById('pics'+id).value;
        var area = document.getElementById('area'+id).value;
        var rate = document.getElementById('rate'+id).value;
        var total = (pcs * area * rate);
        document.getElementById('total'+id).value = total;
    }

    function ajaxSearch()
    {
        var input_data = $('#search_data').val();

        if (input_data.length === 0)
        {
            $('#suggestions').hide();
        }
        else
        {

            var post_data = {
                'search_data': input_data,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            };

            $.ajax({
                type: "POST",

                url:"<?php echo site_url('Admin_Controller/GetCountryName'); ?>",
                data: post_data,
                success: function (data) {
                    // return success
                    if (data.length > 0) {
                        $('#suggestions').show();
                        $('#autoSuggestionsList').addClass('auto_list');
                        $('#autoSuggestionsList').html(data);
                    }
                }
            });

        }
    }

    function get_row(id) {
        $.ajax({
            url:"<?php echo site_url('Admin_Controller/get_Customer_Address'); ?>",
            data: {id:
            id},
            type: "POST",
            success:function(server_response){
                $("#company_name2").html(server_response);
                $('#suggestions').hide();
                $('#Buyer').show();
                document.getElementById('coustomer1').innerHTML =  document.getElementById('coustomer').innerHTML;
                document.getElementById('address1').innerHTML  = document.getElementById('address').innerHTML;
                document.getElementById('phone1').innerHTML =  document.getElementById('phone').innerHTML
                document.getElementById('gstn1').innerHTML =  document.getElementById('gstn').innerHTML;
            }
        });
        $.ajax({
            url:"<?php echo site_url('Admin_Controller/get_Customer_Details'); ?>",
            data: {id:
            id},
            type: "POST",
            success:function(server_response){
                $('#suggestions').hide();
                var data = $.parseJSON(server_response);
                document.getElementById('search_data').value = data[0]['Customer_Company_Name'];
                document.getElementById('company_name').value = data[0]['Customer_Icode'];
                document.getElementById('coustomer').innerHTML = data[0]['Customer_Company_Name'];
                document.getElementById('address').innerHTML = data[0]['Customer_Address_1'] + data[0]['Customer_Area']  + data[0]['Customer_City'];
                document.getElementById('phone').innerHTML = "Mob :" + data[0]['Customer_Phone'];
                document.getElementById('gstn').innerHTML = "GSTIN :" + data[0]['Customer_GSTIN'];
                $('#Buyer').show();
                $('#company_name2').hide();
                document.getElementById('coustomer1').innerHTML =  document.getElementById('coustomer').innerHTML;
                document.getElementById('address1').innerHTML  = document.getElementById('address').innerHTML;
                document.getElementById('phone1').innerHTML =  document.getElementById('phone').innerHTML
                document.getElementById('gstn1').innerHTML =  document.getElementById('gstn').innerHTML;
            }
        });
    }

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

    /** Sheet Charge Height */
    function change_sheet_height(id) {
        var actual_H = document.getElementById('sheet_Act_Size_H'+id).value;
        document.getElementById('sheet_Cha_Size_H'+id).value = actual_H;
        var actual_w = document.getElementById('sheet_Act_Size_W'+id).value;
        document.getElementById('sheet_Cha_Size_W'+id).value = actual_w;
        var Charge_H = document.getElementById('sheet_Cha_Size_H'+id).value;
        var Charge_W = document.getElementById('sheet_Cha_Size_W'+id).value;
        var pcs = document.getElementById('sheet_pieces'+id).value;
        var areas =parseFloat(Charge_W)/1000 * parseFloat(Charge_H)/1000 * parseInt(pcs) ;

        var tot_area = parseFloat(areas);
        document.getElementById('sheet_Area'+id).value = parseFloat(tot_area).toFixed(3);;
        var rate = document.getElementById('sheet_Rate'+id).value;
        var total = (tot_area * rate);
        document.getElementById('sheet_Rate_Amt'+id).value =  parseFloat(total).toFixed(3);
        var totals =document.getElementsByName("sheet_Rate_Amt[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }

        var totals_amt =document.getElementsByName("tot_charge_amt[]");
        var sum_amt = 0;
        for (var j = 0, iLen = totals_amt.length; j < iLen; j++) {
            if (totals_amt[j].value!==""){
                val=parseFloat(totals_amt[j].value);
                sum_amt +=val;
            }
        }

        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot = parseFloat(sum) + parseFloat(grant_tot) + parseFloat(sum_amt) ;
        document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
        var sub_tot =document.getElementById('sub_tot').value;

        var tax = 2.42;
        var total = parseFloat (sub_tot * tax / 100);
        document.getElementById('insurance').value = parseFloat(total).toFixed(3);
        var insurance =parseFloat(total).toFixed(3);
        var igst =document.getElementById('igst').value;
        if(igst == '')
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
    /** Sheet Charge Height */
    function change_sheet_width(id) {
        var actual_H = document.getElementById('sheet_Act_Size_H'+id).value;
        document.getElementById('sheet_Cha_Size_H'+id).value = actual_H;
        var actual_w = document.getElementById('sheet_Act_Size_W'+id).value;
        document.getElementById('sheet_Cha_Size_W'+id).value = actual_w;
        var Charge_H = document.getElementById('sheet_Cha_Size_H'+id).value;
        var Charge_W = document.getElementById('sheet_Cha_Size_W'+id).value;


        var pcs = document.getElementById('sheet_pieces'+id).value;
        var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000 *  parseInt(pcs);
        var tot_area = parseFloat(areas);
        document.getElementById('sheet_Area'+id).value = parseFloat(tot_area).toFixed(3);;
        var rate = document.getElementById('sheet_Rate'+id).value;
        var total = (tot_area * rate);
        document.getElementById('sheet_Rate_Amt'+id).value =  parseFloat(total).toFixed(3);
        var totals =document.getElementsByName("sheet_Rate_Amt[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }

        var totals_amt =document.getElementsByName("tot_charge_amt[]");
        var sum_amt = 0;
        for (var j = 0, iLen = totals_amt.length; j < iLen; j++) {
            if (totals_amt[j].value!==""){
                val=parseFloat(totals_amt[j].value);
                sum_amt +=val;
            }
        }

        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot = parseFloat(sum) + parseFloat(grant_tot) + parseFloat(sum_amt) ;
        document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
        var sub_tot =document.getElementById('sub_tot').value;

        var tax = 2.42;
        var total = parseFloat (sub_tot * tax / 100);
        document.getElementById('insurance').value = parseFloat(total).toFixed(3);
        var insurance =parseFloat(total).toFixed(3);
        var igst =document.getElementById('igst').value;
        if(igst == '')
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
    //** Sheet rate Chage**/
    function change_sheet_rate(id) {

        var tot_area = document.getElementById('sheet_Area'+id).value;
        var rate = document.getElementById('sheet_Rate'+id).value;
        var total = parseFloat(parseFloat(tot_area) * parseFloat(rate));
        document.getElementById('sheet_Rate_Amt'+id).value =  parseFloat(total).toFixed(3);

        var totals =document.getElementsByName("sheet_Rate_Amt[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }

        var totals_amt =document.getElementsByName("tot_charge_amt[]");
        var sum_amt = 0;
        for (var j = 0, iLen = totals_amt.length; j < iLen; j++) {
            if (totals_amt[j].value!==""){
                val=parseFloat(totals_amt[j].value);
                sum_amt +=val;
            }
        }

        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot = parseFloat(sum) + parseFloat(grant_tot) + parseFloat(sum_amt) ;
        document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
        var sub_tot =document.getElementById('sub_tot').value;

        var tax = 2.42;
        var total = parseFloat (sub_tot * tax / 100);
        document.getElementById('insurance').value = parseFloat(total).toFixed(3);
        var insurance =parseFloat(total).toFixed(3);

        var igst =document.getElementById('igst').value;
        if(igst == '')
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

    //**  Change Sheet QTTY**/
    function change_sheet_qty(id) {

        var Charge_H = document.getElementById('sheet_Cha_Size_H'+id).value;
        var Charge_W = document.getElementById('sheet_Cha_Size_W'+id).value;

        var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000;
        var pcs = document.getElementById('sheet_pieces'+id).value;
        var tot_area = parseFloat(areas) * parseInt(pcs);
        document.getElementById('sheet_Area'+id).value = parseFloat(tot_area).toFixed(3);;
        var rate = document.getElementById('sheet_Rate'+id).value;
        var total = (tot_area * rate);
        document.getElementById('sheet_Rate_Amt'+id).value =  parseFloat(total).toFixed(3);
        var totals =document.getElementsByName("sheet_Rate_Amt[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }

        var totals_amt =document.getElementsByName("tot_charge_amt[]");
        var sum_amt = 0;
        for (var j = 0, iLen = totals_amt.length; j < iLen; j++) {
            if (totals_amt[j].value!==""){
                val=parseFloat(totals_amt[j].value);
                sum_amt +=val;
            }
        }

        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot = parseFloat(sum) + parseFloat(grant_tot) + parseFloat(sum_amt) ;
        document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
        var sub_tot =document.getElementById('sub_tot').value;

        var tax = 2.42;
        var total = parseFloat (sub_tot * tax / 100);
        document.getElementById('insurance').value = parseFloat(total).toFixed(3);
        var insurance =parseFloat(total).toFixed(3);
        var igst =document.getElementById('igst').value;
        if(igst == '')
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

    // get Charges
    $("#sheet_material").change(function () {
        var mater =document.getElementsByName("sheet_material[]");
        var material = [];
        for (var j = 0, iLen = mater.length; j < iLen; j++) {
            if (mater[j].value!==""){
                material.push(mater[j].value);
            }
        }
        var counts = document.getElementsByName("pics[]");

        $.ajax({
            url:"<?php echo site_url('User_Controller/get_material'); ?>",
            data: {Material: material},
            type: "POST",
            cache: false,
            success:function(data){

                for (var j = 0, iLen = counts.length; j <= iLen; j++) {
                    $("#material"+j).html(data);
                }

            }
        });

    });
    //** Delete Charges **//
    function delete_charges(id) {
        if (confirm("Do you Want to Delete This Charges...!")) {
            var tBody = $("#my_table > TBODY")[0];
            //Add Row.
            row = tBody.insertRow(-1);
            //Add Name cell.
            var cell = $(row.insertCell(-1));
            var stock = $("<input />");
            stock.attr("type", "text");
            stock.attr("name", "Delete_Charge_Icode[]");
            stock.val(id);
            cell.append(stock);
            $('table#sampleTable1 tr#charge'+id).remove();
            var totals =document.getElementsByName("tot_charge_amt[]");
            var sum1 = 0;
            for (var j = 0, iLen = totals.length; j < iLen; j++) {
                if (totals[j].value!==""){
                    val=parseFloat(totals[j].value);
                    sum1 +=val;
                }
            }

            var totals_amt =document.getElementsByName("sheet_Rate_Amt[]");
            var sum_amt = 0;
            for (var j = 0, iLen = totals_amt.length; j < iLen; j++) {
                if (totals_amt[j].value!==""){
                    val=parseFloat(totals_amt[j].value);
                    sum_amt +=val;
                }
            }
            var grant_tot = document.getElementById('grand_total').value;
            var sub_tot1 = parseFloat(sum1) + parseFloat(grant_tot) + parseFloat(sum_amt) ;
            document.getElementById('sub_tot').value = parseFloat(sub_tot1).toFixed(2);
            var sub_tot =document.getElementById('sub_tot').value;
            var tax = 2.42;
            var total = parseFloat (sub_tot * tax / 100);
            document.getElementById('insurance').value = parseFloat(total).toFixed(3);
            var insurance =parseFloat(total).toFixed(3);
            var igst =document.getElementById('igst').value;
            if(igst == '')
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


    /** Change Charge count */
    function change_charge_count(id) {
        var holes = document.getElementById('charges_count'+id).value;
        var amt = document.getElementById('charges_value'+id).value;
        var total =  parseFloat(holes * amt);
        document.getElementById('tot_charge_amt'+id).value=parseFloat(total).toFixed(3);
        var totals =document.getElementsByName("tot_charge_amt[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }
        var totals_amt =document.getElementsByName("sheet_Rate_Amt[]");
        var sum_amt = 0;
        for (var j = 0, iLen = totals_amt.length; j < iLen; j++) {
            if (totals_amt[j].value!==""){
                val=parseFloat(totals_amt[j].value);
                sum_amt +=val;
            }
        }
        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot = parseFloat(sum) + parseFloat(grant_tot) + parseFloat(sum_amt) ;
        document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
        var sub_tot1 =document.getElementById('sub_tot').value;

        var tax = 2.42;
        var total = parseFloat (sub_tot1 * tax / 100);
        document.getElementById('insurance').value = parseFloat(total).toFixed(3);
        var insurance =parseFloat(total).toFixed(3);
        var igst =document.getElementById('igst').value;
        if(igst == '')
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
        var total =  parseFloat(holes * amt);
        document.getElementById('tot_charge_amt'+id).value=parseFloat(total).toFixed(3);
        var totals =document.getElementsByName("tot_charge_amt[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }
        var totals_amt =document.getElementsByName("sheet_Rate_Amt[]");
        var sum_amt = 0;
        for (var j = 0, iLen = totals_amt.length; j < iLen; j++) {
            if (totals_amt[j].value!==""){
                val=parseFloat(totals_amt[j].value);
                sum_amt +=val;
            }
        }
        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot = parseFloat(sum) + parseFloat(grant_tot) + parseFloat(sum_amt) ;
        document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
        var sub_tot1 =document.getElementById('sub_tot').value;

        var tax = 2.42;
        var total = parseFloat (sub_tot1 * tax / 100);
        document.getElementById('insurance').value = parseFloat(total).toFixed(3);
        var insurance =parseFloat(total).toFixed(3);
        var igst =document.getElementById('igst').value;
        if(igst == '')
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

    //** Chasnge Transport**/
    function change_transport(val) {
        var igst =document.getElementById('igst').value;
        var sub_tot =document.getElementById('sub_tot').value;
        var insurance =document.getElementById('insurance').value;
        var igst =document.getElementById('igst').value;
        if(igst == '')
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

    /** Change Charge Width */
    function change_Charge_Width(id) {
        var Charge_W = document.getElementById('width'+id).value;
        var Charge_H = document.getElementById('height'+id).value;
        var pcs = document.getElementById('pics'+id).value;

        var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000;
        var tot_area =parseInt(pcs) * parseFloat(areas);
        document.getElementById('area'+id).value = parseFloat(tot_area).toFixed(3);
        var totals_area =document.getElementsByName("area[]");
        var sum_area = 0;
        for (var j = 0, iLen = totals_area.length; j < iLen; j++) {
            if (totals_area[j].value!==""){
                val=parseFloat(totals_area[j].value);
                sum_area +=val;
            }
        }
        document.getElementById('total_area').value = parseFloat(sum_area).toFixed(2);

        var rate = document.getElementById('rate'+id).value;
        var total = (tot_area * rate);
        document.getElementById('total'+id).value =  parseFloat(total).toFixed(2);
        // Grand Total
        var totals =document.getElementsByName("total[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }
        document.getElementById('grand_total').value = parseFloat(sum).toFixed(2);
        // total pices
        var pices =document.getElementsByName("pics[]");
        var sum_pic = 0;
        for (var j = 0, iLen = pices.length; j < iLen; j++) {
            if (pices[j].value!==""){
                val=parseFloat(pices[j].value);
                sum_pic +=val;
            }
        }
        document.getElementById('total_pic').value = parseInt(sum_pic);
        var charge =document.getElementsByName("tot_charge_amt[]");
        var sum_charge = 0;
        for (var j = 0, iLen = charge.length; j < iLen; j++) {
            if (charge[j].value!==""){
                val=parseFloat(charge[j].value);
                sum_charge +=val;
            }
        }

        var totals_amt =document.getElementsByName("sheet_Rate_Amt[]");
        var sum_amt = 0;
        for (var j = 0, iLen = totals_amt.length; j < iLen; j++) {
            if (totals_amt[j].value!==""){
                val=parseFloat(totals_amt[j].value);
                sum_amt +=val;
            }
        }
        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot = parseFloat(sum_charge) + parseFloat(grant_tot) + parseFloat(sum_amt) ;
        document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
        var sub_tot =document.getElementById('sub_tot').value;

        var tax = 2.42;
        var total = parseFloat (sub_tot * tax / 100);
        document.getElementById('insurance').value = parseFloat(total).toFixed(3);
        var insurance =parseFloat(total).toFixed(3);

        var igst =document.getElementById('igst').value;
        if(igst == '')
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
            var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst) + parseFloat(trans));
            document.getElementById('gross_tot').value = parseInt(grant);
        }
        number_to_words();


    }
    /** Change Charge Width */

    /** Change Charge Height */
    function change_Charge_Height(id) {
        var Charge_W = document.getElementById('width'+id).value;
        var Charge_H = document.getElementById('height'+id).value;
        var pcs = document.getElementById('pics'+id).value;

            var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000;
            var tot_area =parseInt(pcs) * parseFloat(areas);
            document.getElementById('area'+id).value = parseFloat(tot_area).toFixed(3);
        var totals_area =document.getElementsByName("area[]");
        var sum_area = 0;
        for (var j = 0, iLen = totals_area.length; j < iLen; j++) {
            if (totals_area[j].value!==""){
                val=parseFloat(totals_area[j].value);
                sum_area +=val;
            }
        }
        document.getElementById('total_area').value = parseFloat(sum_area).toFixed(2);

        var rate = document.getElementById('rate'+id).value;
        var total = (tot_area * rate);
        document.getElementById('total'+id).value =  parseFloat(total).toFixed(2);
        // Grand Total
        var totals =document.getElementsByName("total[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }
        document.getElementById('grand_total').value = parseFloat(sum).toFixed(2);
        // total pices
        var pices =document.getElementsByName("pics[]");
        var sum_pic = 0;
        for (var j = 0, iLen = pices.length; j < iLen; j++) {
            if (pices[j].value!==""){
                val=parseFloat(pices[j].value);
                sum_pic +=val;
            }
        }
        document.getElementById('total_pic').value = parseInt(sum_pic);
        var charge =document.getElementsByName("tot_charge_amt[]");
        var sum_charge = 0;
        for (var j = 0, iLen = charge.length; j < iLen; j++) {
            if (charge[j].value!==""){
                val=parseFloat(charge[j].value);
                sum_charge +=val;
            }
        }

        var totals_amt =document.getElementsByName("sheet_Rate_Amt[]");
        var sum_amt = 0;
        for (var j = 0, iLen = totals_amt.length; j < iLen; j++) {
            if (totals_amt[j].value!==""){
                val=parseFloat(totals_amt[j].value);
                sum_amt +=val;
            }
        }
        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot = parseFloat(sum_charge) + parseFloat(grant_tot) + parseFloat(sum_amt) ;
        document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
        var sub_tot =document.getElementById('sub_tot').value;

        var tax = 2.42;
        var total = parseFloat (sub_tot * tax / 100);
        document.getElementById('insurance').value = parseFloat(total).toFixed(3);
        var insurance =parseFloat(total).toFixed(3);

        var igst =document.getElementById('igst').value;
        if(igst == '')
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
            var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst) + parseFloat(trans));
            document.getElementById('gross_tot').value = parseInt(grant);
        }
        number_to_words();

    }
    /** Change Charge Height */

    /** Change no of pieces */
    function change_no_piece(id) {
        var Charge_W = document.getElementById('width'+id).value;
        var Charge_H = document.getElementById('height'+id).value;
        var pcs = document.getElementById('pics'+id).value;

        var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000;
        var tot_area =parseInt(pcs) * parseFloat(areas);
        document.getElementById('area'+id).value = parseFloat(tot_area).toFixed(3);
        var totals_area =document.getElementsByName("area[]");
        var sum_area = 0;
        for (var j = 0, iLen = totals_area.length; j < iLen; j++) {
            if (totals_area[j].value!==""){
                val=parseFloat(totals_area[j].value);
                sum_area +=val;
            }
        }
        document.getElementById('total_area').value = parseFloat(sum_area).toFixed(2);

        var rate = document.getElementById('rate'+id).value;
        var total = ( tot_area * rate);
        document.getElementById('total'+id).value =  parseFloat(total).toFixed(2);
        // Grand Total
        var totals =document.getElementsByName("total[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }
        document.getElementById('grand_total').value = parseFloat(sum).toFixed(2);
        // total pices
        var pices =document.getElementsByName("pics[]");
        var sum_pic = 0;
        for (var j = 0, iLen = pices.length; j < iLen; j++) {
            if (pices[j].value!==""){
                val=parseFloat(pices[j].value);
                sum_pic +=val;
            }
        }
        document.getElementById('total_pic').value = parseInt(sum_pic);
        var charge =document.getElementsByName("tot_charge_amt[]");
        var sum_charge = 0;
        for (var j = 0, iLen = charge.length; j < iLen; j++) {
            if (charge[j].value!==""){
                val=parseFloat(charge[j].value);
                sum_charge +=val;
            }
        }

        var totals_amt =document.getElementsByName("sheet_Rate_Amt[]");
        var sum_amt = 0;
        for (var j = 0, iLen = totals_amt.length; j < iLen; j++) {
            if (totals_amt[j].value!==""){
                val=parseFloat(totals_amt[j].value);
                sum_amt +=val;
            }
        }
        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot = parseFloat(sum_charge) + parseFloat(grant_tot) + parseFloat(sum_amt) ;
        document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
        var sub_tot =document.getElementById('sub_tot').value;

        var tax = 2.42;
        var total = parseFloat (sub_tot * tax / 100);
        document.getElementById('insurance').value = parseFloat(total).toFixed(3);
        var insurance =parseFloat(total).toFixed(3);

        var igst =document.getElementById('igst').value;
        if(igst == '')
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
            var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst) + parseFloat(trans));
            document.getElementById('gross_tot').value = parseInt(grant);
        }
        number_to_words();
    }
    /** Change  no of pieces */
    // change Cutout
    function change_cutout(id) {
        var cutout =document.getElementsByName("cutout[]");
        var sum_cutout = 0;
        for (var j = 0, iLen = cutout.length; j < iLen; j++) {
            if (cutout[j].value!==""){
                val=parseFloat(cutout[j].value);
                sum_cutout +=val;
            }
        }
        document.getElementById('total_cutout').value = parseInt(sum_cutout);
    }

    function change_no_holes(id) {
        var cutout =document.getElementsByName("holes[]");
        var sum_cutout = 0;
        for (var j = 0, iLen = cutout.length; j < iLen; j++) {
            if (cutout[j].value!==""){
                val=parseFloat(cutout[j].value);
                sum_cutout +=val;
            }
        }
        document.getElementById('total_holes').value = parseInt(sum_cutout);
    }

    function change_rate(id) {
        var pcs = document.getElementById('pics'+id).value;
        var area = document.getElementById('area'+id).value;
        var rate = document.getElementById('rate'+id).value;
        var total = (area * rate);
        document.getElementById('total'+id).value =  parseFloat(total).toFixed(2);
        // Grand Total
        var totals =document.getElementsByName("total[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }
        document.getElementById('grand_total').value = parseFloat(sum).toFixed(2);
        // total pices
        var pices =document.getElementsByName("pics[]");
        var sum_pic = 0;
        for (var j = 0, iLen = pices.length; j < iLen; j++) {
            if (pices[j].value!==""){
                val=parseFloat(pices[j].value);
                sum_pic +=val;
            }
        }
        document.getElementById('total_pic').value = parseInt(sum_pic);
        var charge =document.getElementsByName("tot_charge_amt[]");
        var sum_charge = 0;
        for (var j = 0, iLen = charge.length; j < iLen; j++) {
            if (charge[j].value!==""){
                val=parseFloat(charge[j].value);
                sum_charge +=val;
            }
        }

        var totals_amt =document.getElementsByName("sheet_Rate_Amt[]");
        var sum_amt = 0;
        for (var j = 0, iLen = totals_amt.length; j < iLen; j++) {
            if (totals_amt[j].value!==""){
                val=parseFloat(totals_amt[j].value);
                sum_amt +=val;
            }
        }
        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot = parseFloat(sum_charge) + parseFloat(grant_tot) + parseFloat(sum_amt) ;
        document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
        var sub_tot =document.getElementById('sub_tot').value;

        var tax = 2.42;
        var total = parseFloat (sub_tot * tax / 100);
        document.getElementById('insurance').value = parseFloat(total).toFixed(3);
        var insurance =parseFloat(total).toFixed(3);

        var igst =document.getElementById('igst').value;
        if(igst == '')
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
            var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst) + parseFloat(trans));
            document.getElementById('gross_tot').value = parseInt(grant);
        }
        number_to_words();

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
        document.getElementById('amt_words').value = str;
        if (x != s.length) {
            var y = s.length;
            str += 'point ';
            for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
        }
        return str.replace(/\s+/g, ' ');
    }

</script>

