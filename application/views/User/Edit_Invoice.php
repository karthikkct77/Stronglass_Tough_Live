<style>
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

    /* For Firefox */
    input[type='number'] {
        -moz-appearance:textfield;
    }
    /* Webkit browsers like Safari and Chrome */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    h4 span{
        float: left;
        width: 100px;
    }
    #account h5 span {
        float: left;
        width: 150px;
        font-weight: normal;
    }
</style>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>Edit PI</h1>

        </div>
        <div class="row invoice">
            <h4><?php echo $st[0]['ST_Name']; ?></h4>
            <h5><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?></h5>
            <h6><span>Mob: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
        </div>
        <ul class="app-breadcrumb breadcrumb">

        </ul>
    </div>
    <div class="row">
        <div class="col-md-12" >
            <div class="tile">
                <form method="post" class="login-form" action="<?php echo site_url('User_Controller/Update_Invoice'); ?>" name="data_register" onsubmit="return confirm('Do you really want to Save ?');">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Consignee</h5>
                            <input  class="form-control" style="display: none;" name="search_data" id="search_data" type="text" value="<?php echo $invoice[0]['Customer_Company_Name']; ?>" required readonly>
                            <input  class="form-control" name="company_name" id="company_name" type="hidden" value="<?php echo $invoice[0]['consignee']; ?>">
                            <div id="suggestions">
                                <div id="autoSuggestionsList"></div>
                            </div>
                            <div id="consign">
                                <h5 id="coustomer"><?php echo $invoice[0]['Customer_Company_Name']; ?></h5>
                                <h5 id="address"><?php echo $invoice[0]['Customer_Address_1']; echo '&nbsp'; ?><?php echo $invoice[0]['Customer_Address_2']; ?></h5>
                                <h5 id="phone">Phone: <?php echo $invoice[0]['Customer_Phone']; ?></h5>
                                <h5 id="email">Email: <?php echo $invoice[0]['Customer_Email_Id_1']; ?></h5>
                                <h5 id="gstn">GSTN: <?php echo $invoice[0]['Customer_GSTIN']; ?></h5>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <input type="checkbox" name="check" id="check" checked onclick="FillBilling()">
                            <em>Edit.</em>
                            <h5>Delivery Address</h5>
                            <div id="Buyer">
                                <?php
                                if($invoice[0]['Proforma_Delivery_Address_Icode'] == "0")
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
                                    $myString = $invoice[0]['Proforma_Delivery_Address_Icode'];
                                    $myArray = explode(',', $myString);
                                    foreach ($myArray as $key)
                                    { ?>
                                        <h5><?php echo $key; ?> </h5>


                                    <?php }
                                    ?>
                                    <input type="hidden" name="company_address" value="<?php echo $invoice[0]['Proforma_Delivery_Address_Icode']; ?>">


                                    <?php
                                }
                                ?>

                            </div>

                            <div id="edit" style="display: none;">
                                <textarea class="form-control"  name="company_address" value="<?php echo $invoice[0]['Proforma_Delivery_Address_Icode']; ?>"><?php echo $invoice[0]['Proforma_Delivery_Address_Icode']; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control" type="hidden" name="PI_Icode"  value="<?php echo $invoice[0]['Proforma_Icode']; ?>" >
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
                    <div class="row">
                        <table class="table table-hover table-bordered" id="sampleTabless">
                            <thead>
                            <th>#</th>
                            <th>Material</th>
                            <th>Actucal<br>size(h)</th>
                            <th>Actucal<br>size(w)</th>
                            <th>Charge<br>size(h)</th>
                            <th>Charge<br>size(w)</th>
                            <th style="width: 5%;">No.of<br>Pcs</th>
                            <th style="width: 6%;">No.of<br>Holes</th>
                            <th style="width: 5%;">Cutout</th>
                            <th>Special</th>
                            <th>Area<br>(sqmtr)</th>
                            <th>Rate<br>(sqmtr)</th>
                            <th style="width: 10%;">Total Rs</th>
                            <th></th>
                            </thead>
                            <tbody>
                            <?php $i=1; foreach ($invoice_item as $key) { ?>
                                <tr id="row<?php echo $i; ?>">
                                    <!--                                    <input class="form-control" type="hidden" name="material[]"  value="" >-->
                                    <input class="form-control" type="hidden" name="qty[]"  value="<?php echo $key['Proforma_Qty']; ?>" >
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <input type="hidden" name="item_icode[]" value="<?php echo $key['Proforma_Invoice_Items_Icode']; ?>" >
                                        <div class="form-group">
                                            <select name="material[]" class="form-control" id="material<?php echo $i; ?>"  required >
                                                <option value="<?php echo $key['Proforma_Material_Icode']; ?>" ><?php echo $key['Material_Name']; ?></option>
                                                <?php foreach ($stock as $row):
                                                {
                                                    echo '<option value= "'.$row['Material_Icode'].'">' . $row['Material_Name'] . '</option>';
                                                }
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td><input class="form-control" type="number" id="Actual_height<?php echo $i; ?>" name="Actual_height[]"  value="<?php echo $key['Proforma_Actual_Size_Height']; ?>"  onkeyup="change_Actual_Height('<?php echo $i; ?>')" ></td>

                                    <td><input class="form-control" type="number" id="Actual_width<?php echo $i; ?>" name="Actual_width[]"  value="<?php echo $key['Proforma_Actual_Size_Width']; ?>"  onkeyup="change_Actual_Width('<?php echo $i; ?>')" ></td>
                                    <td><input class="form-control" type="number" id="Charge_height<?php echo $i; ?>" name="Charge_height[]"  value="<?php echo $key['Proforma_Chargeable_Size_Height']; ?>"  onkeyup="change_Charge_Height('<?php echo $i; ?>')" ></td>
                                    <td><input class="form-control" type="number" id="Charge_width<?php echo $i; ?>" name="Charge_width[]"  value="<?php echo $key['Proforma_Chargeable_Size_Width']; ?>"  onkeyup="change_Charge_Width('<?php echo $i; ?>')" ></td>

                                    <td><input class="form-control" type="number" id="pics<?php echo $i; ?>"  name="pics[]"  value="<?php echo $key['Proforma_Qty']; ?>" onkeyup="change_pices('<?php echo $i; ?>')" ></td>
                                    <td><input class="form-control" type="number" name="holes[]"  value="<?php echo $key['Proforma_Holes']; ?>" onkeyup="change_holes('<?php echo $i; ?>')" ></td>
                                    <td><input class="form-control" type="number" name="cutout[]"  value="<?php echo $key['Proforma_Cutout']; ?>" onkeyup="change_cutout('<?php echo $i; ?>')" ></td>
                                    <td><input class="form-control" type="text" name="special[]"  value="<?php echo $key['Proforma_Special']; ?>"  ></td>
                                    <td><input class="form-control" type="number" name="area[]" id="area<?php echo $i; ?>" value="<?php echo $key['Proforma_Area_SQMTR']; ?>" readonly></td>
                                    <td><input class="form-control" type="number" name="rate[]" value="<?php echo $key['Proforma_Material_Rate']; ?>" id="rate<?php echo $i; ?>" onkeyup="change_rate('<?php echo $i; ?>')" ></td>
                                    <td><input class="form-control" type="number" name="total[]" value="<?php echo $key['Proforma_Material_Cost']; ?>" id="total<?php echo $i; ?>" readonly  ></td>
                                    <td><a  style="color: red;" href="javascript:;"><i class="fa fa-trash"  onclick="delete_items('<?php echo $i; ?>','<?php echo $key['Proforma_Invoice_Items_Icode']; ?>')" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <select name="new_material[]" class="form-control" id="new_material"   >
                                            <option value="" ></option>
                                            <?php foreach ($stock as $row):
                                            {
                                                echo '<option value= "'.$row['Material_Icode'].'">' . $row['Material_Name'] . '</option>';
                                            }
                                            endforeach; ?>
                                        </select>
                                    </div>
                                </td>
                                <td><input class="form-control" type="number" id="new_Actual_height" name="new_Actual_height[]"  onkeyup="change_new_Actual_height()" ></td>

                                <td><input class="form-control" type="number" id="new_Actual_width" name="new_Actual_width[]" onkeyup="change_new_Actual_Width()" ></td>
                                <td><input class="form-control" type="number" id="new_Charge_height" name="new_Charge_height[]"  onkeyup="change_new_Charge_Height()" ></td>
                                <td><input class="form-control" type="number" id="new_Charge_width" name="new_Charge_width[]"  onkeyup="change_new_Charge_Width()" ></td>
                                <td><input class="form-control" type="number" id="new_pics"  name="new_pics[]"  onkeyup="change_new_pices()" ></td>
                                <td><input class="form-control" type="number" name="new_holes[]" id="new_holes" onkeyup="change_new_holes()" ></td>
                                <td><input class="form-control" type="number" name="new_cutout[]" id="new_cutout" onkeyup="change_new_cutout()" ></td>
                                <td><input class="form-control" type="text" name="new_special[]" id="new_special"  ></td>
                                <td><input class="form-control" type="number" name="new_area[]" id="new_area"  readonly></td>
                                <td><input class="form-control" type="number" name="new_rate[]" id="new_rate" onkeyup="change_new_rate()" ></td>
                                <td><input class="form-control" type="number" name="new_total[]" id="new_total" readonly  ></td>
                                <td> <input type="button" onclick="Add_new_one()" value="NewAdd" id="NewAdd" /> </td>
                            </tr>


                            <tr>
                                <td colspan="6" align="right" style="font-weight: bold;" >Total Summary</td>
                                <td><input type="text" class="form-control pull-right" id="total_pic" value="<?php echo $invoice_total[0]['qty']; ?>"   readonly/></td>
                                <td><input type="text" class="form-control pull-right" id="total_holes" value="<?php echo $invoice_total[0]['holes']; ?>"   readonly/></td>
                                <td><input type="text" class="form-control pull-right" id="total_cutout" value="<?php echo $invoice_total[0]['cutout']; ?>"   readonly/></td>
                                <td></td>
                                <td><input type="text" class="form-control pull-right" id="total_area" value="<?php echo round($invoice_total[0]['area'], 2); ?>"   readonly/></td>
                                <td></td>
                                <td> <input type="text" class="form-control pull-right" id="grand_total" value="<?php echo round($invoice_total[0]['rate'],2); ?>"   readonly/>(INR)</td>
                            </tr>


                            </tfoot>
                        </table>
                        <div >
                            <table id="my_item_table">
                                <thead></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <script>
                            $("#grand_total").on('click', function() {
                                var total =document.getElementsByName("total[]");
                                var sum = 0;
                                for (var j = 0, iLen = total.length; j < iLen; j++) {
                                    val=parseFloat(total[j].value);
                                    sum +=val;
                                }
                                document.getElementById('grand_total').value = parseFloat(sum).toFixed(2);
                            });
                        </script>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div style="" class="form-group row">
                                <label class="control-label" style="font-weight: bold;">Delivery Period</label>
                                <div class="col-md-8">
                                    <input class="form-control col-md-3" type="text" name="delivery"  value="<?php echo $invoice[0]['Delivery_Days']; ?>" required>
                                </div>
                            </div>
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
                            <div id="account">
                                <h3 style="font-size: 13px;">Bank Details</h3>
                                <h5><span>Account Name</span> :STRONGLASS TOUGH</h5>
                                <h5><span>Bank Name</span>:<?php echo $st[0]['ST_Bank']; ?></span></h5>
                                <h5><span>Account Number</span>:<?php echo $st[0]['ST_Bank_Account_Number']; ?></h5>
                                <h5><span>IFSC</span>:<?php echo $st[0]['ST_Bank_Account_IFSC_Code']; ?></h5>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                <th>Select Charges</th>
                                <th>No.of pieces</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th></th>
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
                                    <td><input class="form-control" type="text" name="tot_charge_amt[]" id="tot_charge_amount"  readonly>
                                        <input class="form-control" type="hidden" name="tot_charge_amounts[]" id="tot_charge_amount1"  readonly>

                                    </td>
                                    <td><input type="button" onclick="Add_one()" value="Add" id="Add" /></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">SUB-TOTAL</td>

                                    <td><input class="form-control" type="text" name="sub_tot" id="sub_tot" value="<?php echo $invoice[0]['Sub_Total']; ?>" readonly ></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">HANDLING CHARGES</td>
                                    <td><input class="form-control" type="text" name="insurance" id="insurance" value="<?php echo $invoice[0]['Insurance_Value']; ?>" required readonly></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="right">TRANSPORT</td>
                                    <td><input class="form-control" type="text" name="transport" id="transport" onkeyup="change_transport(this.value)"  value="<?php echo $invoice[0]['Transport']; ?>" ></td>
                                    <td></td>
                                </tr>

                                <?php
                                if($invoice[0]['IGST_Value'] == '0' || $invoice[0]['IGST_Value'] == ''  )
                                { ?>
                                    <tr>

                                        <td colspan="3" align="right">SGST @<?php echo $tax[0]['SGST%']; ?></td>

                                        <td><input class="form-control" type="text" name="sgst" id="sgst" value="<?php echo $invoice[0]['SGST_Value']; ?>"readonly ></td>
                                        <td> <input type="hidden" id="igst" value=""></td>
                                    </tr>
                                    <tr>

                                        <td colspan="3" align="right">CGST @<?php echo $tax[0]['CGST%']; ?>
                                            <input type="hidden" id="gst" value="<?php echo $tax[0]['CGST%']; ?>">
                                        </td>
                                        <td><input class="form-control" type="text" name="cgst" id="cgst" value="<?php echo $invoice[0]['CGST_Value']; ?>" readonly ></td>
                                        <td></td>
                                    </tr>

                                <?php }
                                else
                                { ?>
                                    <tr>
                                        <td colspan="3" align="right">IGST @18%
                                            <input type="hidden" id="igst1" value="18">
                                        </td>
                                        <td><input class="form-control" type="text" name="igst" id="igst" value="<?php echo $invoice[0]['IGST_Value']; ?>" readonly ></td>
                                        <td></td>
                                    </tr>
                                <?php }
                                ?>
                                <tr>

                                    <td colspan="3" align="right">GROSS TOTAL</td>
                                    <td><input class="form-control" type="text" name="gross_tot" id="gross_tot" readonly value="<?php echo $invoice[0]['GrossTotal_Value']; ?>" ></td>
                                    <td></td>
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
                        <div>Amount in Words: <span id="word"></span>
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
</main>
<script>
    $( document ).ready(function() {
        number_to_words();
    });

    $("#company_name2").change(function () {
        $.ajax({
            url:"<?php echo site_url('User_Controller/get_Customer_Address_Details'); ?>",
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
        document.getElementById('tot_charge_amount').value =parseFloat(total).toFixed(3);
        document.getElementById('tot_charge_amount1').value =parseFloat(total).toFixed(3);

        var totals =document.getElementsByName("tot_charge_amt[]");
        var sum1 = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum1 +=val;
            }
        }
        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot1 = parseFloat(sum1) + parseFloat(grant_tot);
        document.getElementById('sub_tot').value = parseFloat(sub_tot1).toFixed(2);
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
            url:"<?php echo site_url('User_Controller/Edit_Charges'); ?>",
            data: {id:
                $(this).val()},
            type: "POST",
            success:function(server_response){
                var data = $.parseJSON(server_response);
                var  price = data[0]['charge_current_price'];
                document.getElementById('charge_amt').value = price;
                var total =  parseInt(pics * price);
                document.getElementById('tot_charge_amt').value = total;
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
                var tax = 2.42;
                var totals = parseFloat (sub_tot * tax / 100);
                document.getElementById('insurance').value = parseFloat(totals).toFixed(3);
                var insurance = totals;
                if(res == 'gst')
                {

                    var gst = document.getElementById('gst').value;
                    var trans =parseFloat(document.getElementById('transport').value);
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
                    var trans =parseFloat(document.getElementById('transport').value);
                    var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
                    document.getElementById('igst').value = parseFloat(sum).toFixed(2);
                    var iisgst = document.getElementById('igst').value;
                    var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst)+ parseFloat(trans));
                    document.getElementById('gross_tot').value = parseInt(grant);
                }
                number_to_words();

            }
        });
    });

    // Charge Amount
    $("#charge_amt").on('change keyup paste', function() {
        var amt = parseFloat($(this).val());
        var holes = parseFloat($('#no_holes').val());

        var total =  parseFloat(holes * amt);
        document.getElementById('tot_charge_amount').value = parseFloat(total).toFixed(3);
        document.getElementById('tot_charge_amount1').value = parseFloat(total).toFixed(3);

        var totals =document.getElementsByName("tot_charge_amt[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }
        var totals =document.getElementsByName("tot_charge_amt[]");
        var sum1 = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum1 +=val;
            }
        }
        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot1 = parseFloat(sum1) + parseFloat(grant_tot);
        document.getElementById('sub_tot').value = parseFloat(sub_tot1).toFixed(2);
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
        var tBody = $("#sampleTable > TBODY")[0];
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
            var table = $("#sampleTable")[0];
            //Delete the Table row using it's Index.
            table.deleteRow(row[0].rowIndex);
            var totals =document.getElementsByName("tot_charge_amt[]");
            var sum1 = 0;
            for (var j = 0, iLen = totals.length; j < iLen; j++) {
                if (totals[j].value!==""){
                    val=parseFloat(totals[j].value);
                    sum1 +=val;
                }
            }
            var grant_tot = document.getElementById('grand_total').value;
            var sub_tot1 = parseFloat(sum1) + parseFloat(grant_tot);
            document.getElementById('sub_tot').value = parseFloat(sub_tot1).toFixed(2);
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
        }
    };
    function FillBilling() {
        if($('#check').is(":checked"))
        {
            $('#Buyer').show();
            $('#edit').hide();

        }
        else
        {
            $('#Buyer').hide();
            $('#edit').show();
        }
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
        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot = parseFloat(sum_charge) + parseFloat(grant_tot);
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

    function change_pices(id) {
        var pcs = document.getElementById('pics'+id).value;
        var area = document.getElementById('area'+id).value;
        var rate = document.getElementById('rate'+id).value;

        var Charge_H = document.getElementById('Charge_height'+id).value;
        var Charge_w = document.getElementById('Charge_width'+id).value;

        var areas =parseInt(Charge_w)/1000 * parseInt(Charge_H)/1000 * pcs;
        document.getElementById('area'+id).value = parseFloat(areas).toFixed(3);
        var total = (areas * rate);
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
        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot = parseFloat(sum_charge) + parseFloat(grant_tot);
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
    function change_holes(id) {
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

                url:"<?php echo site_url('User_Controller/GetCountryName'); ?>",
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
            url:"<?php echo site_url('User_Controller/get_Customer_Address'); ?>",
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
            url:"<?php echo site_url('User_Controller/get_Customer_Details'); ?>",
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
    function isgt() {
        $('#igst1').show();
        $('#sgst1').hide();
        $('#cgst1').hide();
        var sub_tot =document.getElementById('sub_tot').value;
        var insurance =document.getElementById('insurance').value;
        var trans =document.getElementById('transport').value;
        var sum = ((parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(trans) ) * 18 / 100 );
        document.getElementById('igst').value = parseFloat(sum).toFixed(2);
        var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(trans) + parseFloat(sum));
        document.getElementById('gross_tot').value = parseInt(grant);
        number_to_words();
    }
    function GST() {
        $('#igst1').hide();
        $('#sgst1').show();
        $('#cgst1').show();
        var sub_tot =document.getElementById('sub_tot').value;
        var insurance =document.getElementById('insurance').value;
        var gst = document.getElementById('gst').value;
        var trans =document.getElementById('transport').value;
        var sum = ((parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans)) * gst / 100 );
        document.getElementById('sgst').value = parseFloat(sum).toFixed(2);
        document.getElementById('cgst').value = parseFloat(sum).toFixed(2);
        var sgst = document.getElementById('sgst').value;
        var cgst = document.getElementById('cgst').value;
        var grant = (parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(sgst) + parseFloat(cgst) + parseFloat(trans));
        document.getElementById('gross_tot').value = parseInt(grant);
        number_to_words();
    }

    /** Change Actual Width */
    function change_Actual_Width(id) {
        var actual_W = document.getElementById('Actual_width'+id).value;
        var Charge_W = parseInt(actual_W) + 30;
        document.getElementById('Charge_width'+id).value = Charge_W;
        var Charge_H = document.getElementById('Charge_height'+id).value;
        var pcs = document.getElementById('pics'+id).value;
        var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000 * pcs;
        document.getElementById('area'+id).value = parseFloat(areas).toFixed(3);

        var rate = document.getElementById('rate'+id).value;
        var total = (areas * rate);
        document.getElementById('total'+id).value =  parseFloat(total).toFixed(3);

//            // Grand Total
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
    /** Change Actual Width */

    /** Change Actual Height */
    function change_Actual_Height(id) {
        var actual_H = document.getElementById('Actual_height'+id).value;
        var Charge_H = parseInt(actual_H) + 30;
        document.getElementById('Charge_height'+id).value = Charge_H;
        var Charge_W = document.getElementById('Charge_width'+id).value;
        var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000;
        document.getElementById('area'+id).value = parseFloat(areas).toFixed(3);
        var pcs = document.getElementById('pics'+id).value;
        var rate = document.getElementById('rate'+id).value;
        var total = (pcs * areas * rate);
        document.getElementById('total'+id).value =  parseFloat(total).toFixed(3);

//            // Grand Total
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
    /** Change Actual Height */

    /** Change Charge Width */
    function change_Charge_Width(id) {
        var actual_W = document.getElementById('Actual_width'+id).value;
        var Charge_W = document.getElementById('Charge_width'+id).value;
        var Charge_H = document.getElementById('Charge_height'+id).value;

            var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000;
            document.getElementById('area'+id).value = parseFloat(areas).toFixed(3);
            var pcs = document.getElementById('pics'+id).value;
            var rate = document.getElementById('rate'+id).value;
            var total = (pcs * areas * rate);
            document.getElementById('total'+id).value =  parseFloat(total).toFixed(3);

//            // Grand Total
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
        var actual_H = document.getElementById('Actual_height'+id).value;
        var Charge_W = document.getElementById('Charge_width'+id).value;
        var Charge_H = document.getElementById('Charge_height'+id).value;

            var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000;
            document.getElementById('area'+id).value = parseFloat(areas).toFixed(3);;
            var pcs = document.getElementById('pics'+id).value;
            var rate = document.getElementById('rate'+id).value;
            var total = (pcs * areas * rate);
            document.getElementById('total'+id).value =  parseFloat(total).toFixed(3);

//            // Grand Total
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
    /** Change Charge Height */

    //** Delete Item **/
    function delete_items (id,item_icode) {
        if (confirm("Do you Want to Delete This Material...!")) {
            var tBody = $("#my_item_table > TBODY")[0];
            //Add Row.
            row = tBody.insertRow(-1);
            //Add Name cell.
            var cell = $(row.insertCell(-1));
            var stock = $("<input />");
            stock.attr("type", "hidden");
            stock.attr("name", "Delete_Item_Icode[]");
            stock.val(item_icode);
            cell.append(stock);

            $('table#sampleTabless tr#row'+id).remove();
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

            var totals =document.getElementsByName("tot_charge_amt[]");
            var charge = 0;
            for (var j = 0, iLen = totals.length; j < iLen; j++) {
                if (totals[j].value!==""){
                    val=parseFloat(totals[j].value);
                    charge +=val;
                }
            }
            var grant_tot = document.getElementById('grand_total').value;
            var sub_tot = parseFloat(charge) + parseFloat(grant_tot);
            document.getElementById('sub_tot').value = parseFloat(sub_tot).toFixed(2);
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
                var sum = parseFloat(sub_tot) + parseFloat(insurance)+ parseFloat(trans);
                var sum_tot =parseFloat(sum) * gst / 100 ;
                document.getElementById('igst').value = parseFloat(sum_tot).toFixed(2);
                var iisgst = document.getElementById('igst').value;
                var grant = parseFloat(sub_tot) + parseFloat(insurance) + parseFloat(iisgst) + parseFloat(trans);
                document.getElementById('gross_tot').value = parseInt(grant);

            }
            number_to_words();


        }
    }

    //** Delete Item **/

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
            $('table#sampleTable tr#charge'+id).remove();
            var totals =document.getElementsByName("tot_charge_amt[]");
            var sum1 = 0;
            for (var j = 0, iLen = totals.length; j < iLen; j++) {
                if (totals[j].value!==""){
                    val=parseFloat(totals[j].value);
                    sum1 +=val;
                }
            }
            var grant_tot = document.getElementById('grand_total').value;
            var sub_tot1 = parseFloat(sum1) + parseFloat(grant_tot);
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
    //** Chasnge Transport**/
    function change_transport(val) {
        var igst =document.getElementById('igst').value;
        var sub_tot =document.getElementById('sub_tot').value;
        var insurance =document.getElementById('insurance').value;
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
        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot = parseFloat(sum) + parseFloat(grant_tot);
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
        var grant_tot = document.getElementById('grand_total').value;
        var sub_tot = parseFloat(sum) + parseFloat(grant_tot);
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

    $("#NewAdd").click(function () {
        if($('#new_material').val() == "")
        {
            alert("Please Select Material...");
        }
        else if($('#new_pics').val() == ""){
            alert("Please enter No.of pieces...");
        }
        else if($('#new_Actual_height').val() == '')
        {
            alert("Please Enter All Size..")
        }
        else if($('#new_rate').val() == "")
        {
            alert("Please Enter Rate..")
        }
        else
        {
            var material = $("#new_material option:selected").text();
            AddNewRow($('#new_material').val(), $("#new_pics").val(),$("#new_Actual_height").val(),$("#new_Actual_width").val(),$("#new_Charge_height").val(),
                $("#new_Charge_width").val(),$("#new_holes").val(),$("#new_cutout").val(),$("#new_special").val(),$("#new_area").val(),$("#new_rate").val(),$("#new_total").val(),
                material);
            $("#new_material").val("");
            $("#new_pics").val("");
            $("#new_Actual_height").val("");
            $("#new_Actual_width").val("");
            $("#new_Charge_height").val("");
            $("#new_Charge_width").val("");
            $("#new_holes").val("");
            $("#new_cutout").val("");
            $("#new_special").val("");
            $("#new_area").val("");
            $("#new_rate").val("");
            $("#new_total").val("");

        }
    });

    //Add AddRow_sheet Row
    function AddNewRow(materials,pice,act_h,act_w,cha_h,cha_w,holes,cutout,special,area,rate,amt,material) {
        var tBody = $("#sampleTabless > TBODY")[0];
        //Add Row.
        row = tBody.insertRow(-1);
        //Add Name cell.

        var cell = $(row.insertCell(-1));
        var news = $("<input />");
        news.attr("type", "hidden");
        news.attr("name", "");
        news.val();
        cell.append(news);


        var cell = $(row.insertCell(-1));
        var stock = $("<input />");
        stock.attr("type", "hidden");
        stock.attr("name", "new_material[]");
        stock.val(materials);
        cell.append(stock);

        var tech1 = $("<input />");
        tech1.attr("type", "text");
        tech1.attr("name", "test");
        tech1.attr("class", "form-control");
        tech1.attr('readonly', true);
        tech1.val(material);
        cell.append(tech1);


        var cell = $(row.insertCell(-1));
        var cty1 = $("<input />");
        cty1.attr("type", "text");
        cty1.attr("class", "form-control");
        cty1.attr("name", "new_Actual_height[]");
        cty1.attr('readonly', true);
        cty1.val(act_h);
        cell.append(cty1);

        var cell = $(row.insertCell(-1));
        var cty2 = $("<input />");
        cty2.attr("type", "text");
        cty2.attr("class", "form-control");
        cty2.attr("name", "new_Actual_width[]");
        cty2.attr('readonly', true);
        cty2.val(act_w);
        cell.append(cty2);

        var cell = $(row.insertCell(-1));
        var cha_h1 = $("<input />");
        cha_h1.attr("type", "text");
        cha_h1.attr("class", "form-control");
        cha_h1.attr("name", "new_Charge_height[]");
        cha_h1.attr('readonly', true);
        cha_h1.val(cha_h);
        cell.append(cha_h1);

        var cell = $(row.insertCell(-1));
        var cha_w1 = $("<input />");
        cha_w1.attr("type", "text");
        cha_w1.attr("class", "form-control");
        cha_w1.attr("name", "new_Charge_width[]");
        cha_w1.attr('readonly', true);
        cha_w1.val(cha_w);
        cell.append(cha_w1);

        var cell = $(row.insertCell(-1));
        var cty = $("<input />");
        cty.attr("type", "text");
        cty.attr("class", "form-control");
        cty.attr("name", "new_pics[]");
        cty.attr('readonly', true);
        cty.val(pice);
        cell.append(cty);

        var cell = $(row.insertCell(-1));
        var hols = $("<input />");
        hols.attr("type", "text");
        hols.attr("class", "form-control");
        hols.attr("name", "new_holes[]");
        hols.attr('readonly', true);
        hols.val(holes);
        cell.append(hols);

        var cell = $(row.insertCell(-1));
        var cut = $("<input />");
        cut.attr("type", "text");
        cut.attr("class", "form-control");
        cut.attr("name", "new_cutout[]");
        cut.attr('readonly', true);
        cut.val(cutout);
        cell.append(cut);


        var cell = $(row.insertCell(-1));
        var spc = $("<input />");
        spc.attr("type", "text");
        spc.attr("class", "form-control");
        spc.attr("name", "new_special[]");
        spc.attr('readonly', true);
        spc.val(special);
        cell.append(spc);



        var cell = $(row.insertCell(-1));
        var areas = $("<input />");
        areas.attr("type", "text");
        areas.attr("class", "form-control");
        areas.attr("name", "new_area[]");
        areas.attr('readonly', true);
        areas.val(area);
        cell.append(areas);

        var cell = $(row.insertCell(-1));
        var rates = $("<input />");
        rates.attr("type", "text");
        rates.attr("class", "form-control");
        rates.attr("name", "new_rate[]");
        rates.attr('readonly', true);
        rates.val(rate);
        cell.append(rates);

        var cell = $(row.insertCell(-1));
        var amts = $("<input />");
        amts.attr("type", "text");
        amts.attr("class", "form-control");
        amts.attr("name", "new_total[]");
        amts.attr('readonly', true);
        amts.val(amt);
        cell.append(amts);

        cell = $(row.insertCell(-1));
        var btnRemove = $("<input />");
        btnRemove.attr("type", "button");
        btnRemove.attr("onclick", "Remove_sheet(this);");
        btnRemove.val("Remove");
        cell.append(btnRemove);
    };
    //Remove Charges
    function Remove_sheet(button) {
        //Determine the reference of the Row using the Button.
        var row = $(button).closest("TR");
        var name = $("TD", row).eq(0).html();
        if (confirm("Do you want to delete: ")) {
            //Get the reference of the Table.
            var table = $("#sampleTabless")[0];
            //Delete the Table row using it's Index.
            table.deleteRow(row[0].rowIndex);

            var Charge_H = document.getElementById('new_Charge_height').value;
            var Charge_W = document.getElementById('new_Charge_width').value;

            var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000 ;
            var pcs = document.getElementById('new_pics').value;
            var tot_area = parseFloat(areas) * parseInt(pcs);
            document.getElementById('new_area').value = parseFloat(tot_area).toFixed(3);;
            var rate = document.getElementById('new_rate').value;
            var total = (tot_area * rate);
            document.getElementById('new_total').value =  parseFloat(total).toFixed(3);


            var oldareas =document.getElementsByName("area[]");
            var sum_oldarea = 0;
            for (var j = 0, iLen = oldareas.length; j < iLen; j++) {
                if (oldareas[j].value!==""){
                    val=parseFloat(oldareas[j].value);
                    sum_oldarea +=val;
                }
            }
            var newareas =document.getElementsByName("new_area[]");
            var sum_newarea = 0;
            for (var j = 0, iLen = newareas.length; j < iLen; j++) {
                if (newareas[j].value!==""){
                    val=parseFloat(newareas[j].value);
                    sum_newarea +=val;
                }
            }

            var tot_area = parseFloat(sum_oldarea + sum_newarea);
            document.getElementById('total_area').value = parseFloat(tot_area).toFixed(2);

//            // Grand Total
            var totals =document.getElementsByName("total[]");
            var sum = 0;
            for (var j = 0, iLen = totals.length; j < iLen; j++) {
                if (totals[j].value!==""){
                    val=parseFloat(totals[j].value);
                    sum +=val;
                }
            }

            var totals1 =document.getElementsByName("new_total[]");
            var sum_new = 0;
            for (var j = 0, iLen = totals1.length; j < iLen; j++) {
                if (totals1[j].value!==""){
                    val=parseFloat(totals1[j].value);
                    sum_new +=val;
                }
            }
            var new_sum = parseFloat(sum + sum_new).toFixed(2) ;
            document.getElementById('grand_total').value =new_sum;
            // total pices
            var pices =document.getElementsByName("pics[]");
            var sum_pic = 0;
            for (var j = 0, iLen = pices.length; j < iLen; j++) {
                if (pices[j].value!==""){
                    val=parseFloat(pices[j].value);
                    sum_pic +=val;
                }
            }
            var new_pices =document.getElementsByName("new_pics[]");
            var sum_new_pic = 0;
            for (var j = 0, iLen = new_pices.length; j < iLen; j++) {
                if (new_pices[j].value!==""){
                    val=parseFloat(new_pices[j].value);
                    sum_new_pic +=val;
                }
            }

            var tot_qty = parseInt(sum_pic) + parseInt(sum_new_pic);
            document.getElementById('total_pic').value = parseInt(tot_qty);
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
    };

    function change_new_Actual_height() {
        var actual_H = document.getElementById('new_Actual_height').value;
        var chg_H = parseInt(actual_H) + 30;
        document.getElementById('new_Charge_height').value = chg_H;

        var Charge_H = document.getElementById('new_Charge_height').value;
        var Charge_W = document.getElementById('new_Charge_width').value;

        var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000 ;
        var pcs = document.getElementById('new_pics').value;
        var tot_area = parseFloat(areas) * parseInt(pcs);
        document.getElementById('new_area').value = parseFloat(tot_area).toFixed(3);;
        var rate = document.getElementById('new_rate').value;
        var total = (tot_area * rate);
        document.getElementById('new_total').value =  parseFloat(total).toFixed(3);


        var oldareas =document.getElementsByName("area[]");
        var sum_oldarea = 0;
        for (var j = 0, iLen = oldareas.length; j < iLen; j++) {
            if (oldareas[j].value!==""){
                val=parseFloat(oldareas[j].value);
                sum_oldarea +=val;
            }
        }
        var newareas =document.getElementsByName("new_area[]");
        var sum_newarea = 0;
        for (var j = 0, iLen = newareas.length; j < iLen; j++) {
            if (newareas[j].value!==""){
                val=parseFloat(newareas[j].value);
                sum_newarea +=val;
            }
        }

        var tot_area = parseFloat(sum_oldarea + sum_newarea);
        document.getElementById('total_area').value = parseFloat(tot_area).toFixed(2);

//            // Grand Total
        var totals =document.getElementsByName("total[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }

        var totals1 =document.getElementsByName("new_total[]");
        var sum_new = 0;
        for (var j = 0, iLen = totals1.length; j < iLen; j++) {
            if (totals1[j].value!==""){
                val=parseFloat(totals1[j].value);
                sum_new +=val;
            }
        }
        var new_sum = parseFloat(sum + sum_new).toFixed(2) ;
        document.getElementById('grand_total').value =new_sum;
        // total pices
        var pices =document.getElementsByName("pics[]");
        var sum_pic = 0;
        for (var j = 0, iLen = pices.length; j < iLen; j++) {
            if (pices[j].value!==""){
                val=parseFloat(pices[j].value);
                sum_pic +=val;
            }
        }
        var new_pices =document.getElementsByName("new_pics[]");
        var sum_new_pic = 0;
        for (var j = 0, iLen = new_pices.length; j < iLen; j++) {
            if (new_pices[j].value!==""){
                val=parseFloat(new_pices[j].value);
                sum_new_pic +=val;
            }
        }

        var tot_qty = parseInt(sum_pic) + parseInt(sum_new_pic);
        document.getElementById('total_pic').value = parseInt(tot_qty);
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

    function change_new_Actual_Width() {
        var actual_W = document.getElementById('new_Actual_width').value;
        var chg_W = parseInt(actual_W) + 30;
        document.getElementById('new_Charge_width').value = chg_W;

        var Charge_H = document.getElementById('new_Charge_height').value;
        var Charge_W = document.getElementById('new_Charge_width').value;

        var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000 ;
        var pcs = document.getElementById('new_pics').value;
        var tot_area = parseFloat(areas) * parseInt(pcs);
        document.getElementById('new_area').value = parseFloat(tot_area).toFixed(3);
        var rate = document.getElementById('new_rate').value;
        var total = (tot_area * rate);
        document.getElementById('new_total').value =  parseFloat(total).toFixed(3);

        var oldareas =document.getElementsByName("area[]");
        var sum_oldarea = 0;
        for (var j = 0, iLen = oldareas.length; j < iLen; j++) {
            if (oldareas[j].value!==""){
                val=parseFloat(oldareas[j].value);
                sum_oldarea +=val;
            }
        }
        var newareas =document.getElementsByName("new_area[]");
        var sum_newarea = 0;
        for (var j = 0, iLen = newareas.length; j < iLen; j++) {
            if (newareas[j].value!==""){
                val=parseFloat(newareas[j].value);
                sum_newarea +=val;
            }
        }

        var tot_area = parseFloat(sum_oldarea + sum_newarea);
        document.getElementById('total_area').value = parseFloat(tot_area).toFixed(2);






//            // Grand Total
        var totals =document.getElementsByName("total[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }

        var totals1 =document.getElementsByName("new_total[]");
        var sum_new = 0;
        for (var j = 0, iLen = totals1.length; j < iLen; j++) {
            if (totals1[j].value!==""){
                val=parseFloat(totals1[j].value);
                sum_new +=val;
            }
        }
        var new_sum = parseFloat(sum + sum_new).toFixed(2) ;
        document.getElementById('grand_total').value =new_sum;
        // total pices
        var pices =document.getElementsByName("pics[]");
        var sum_pic = 0;
        for (var j = 0, iLen = pices.length; j < iLen; j++) {
            if (pices[j].value!==""){
                val=parseFloat(pices[j].value);
                sum_pic +=val;
            }
        }
        var new_pices =document.getElementsByName("new_pics[]");
        var sum_new_pic = 0;
        for (var j = 0, iLen = new_pices.length; j < iLen; j++) {
            if (new_pices[j].value!==""){
                val=parseFloat(new_pices[j].value);
                sum_new_pic +=val;
            }
        }

        var tot_qty = parseInt(sum_pic) + parseInt(sum_new_pic);
        document.getElementById('total_pic').value = parseInt(tot_qty);
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

    //** Change New Qty //
    function change_new_pices() {

        var Charge_H = document.getElementById('new_Charge_height').value;
        var Charge_W = document.getElementById('new_Charge_width').value;

        var areas =parseInt(Charge_W)/1000 * parseInt(Charge_H)/1000 ;
        var pcs = document.getElementById('new_pics').value;
        var tot_area = parseFloat(areas) * parseInt(pcs);
        document.getElementById('new_area').value = parseFloat(tot_area).toFixed(3);

        var rate = document.getElementById('new_rate').value;
        var areas = document.getElementById('new_area').value;
        var totals = (areas * rate);
        document.getElementById('new_total').value =  parseFloat(totals).toFixed(2);


        var pices =document.getElementsByName("pics[]");
        var sum_pic = 0;
        for (var j = 0, iLen = pices.length; j < iLen; j++) {
            if (pices[j].value!==""){
                val=parseFloat(pices[j].value);
                sum_pic +=val;
            }
        }

        var new_pices =document.getElementsByName("new_pics[]");
        var sum_new_pic = 0;
        for (var j = 0, iLen = new_pices.length; j < iLen; j++) {
            if (new_pices[j].value!==""){
                val=parseFloat(new_pices[j].value);
                sum_new_pic +=val;
            }
        }

        var tot_qty = parseInt(sum_pic) + parseInt(sum_new_pic);
        document.getElementById('total_pic').value = parseInt(tot_qty);

        var oldareas =document.getElementsByName("area[]");
        var sum_oldarea = 0;
        for (var j = 0, iLen = oldareas.length; j < iLen; j++) {
            if (oldareas[j].value!==""){
                val=parseFloat(oldareas[j].value);
                sum_oldarea +=val;
            }
        }
        var newareas =document.getElementsByName("new_area[]");
        var sum_newarea = 0;
        for (var j = 0, iLen = newareas.length; j < iLen; j++) {
            if (newareas[j].value!==""){
                val=parseFloat(newareas[j].value);
                sum_newarea +=val;
            }
        }

        var tot_area = parseFloat(sum_oldarea + sum_newarea);
        document.getElementById('total_area').value = parseFloat(tot_area).toFixed(2);
        var totals =document.getElementsByName("total[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }

        var totals1 =document.getElementsByName("new_total[]");
        var sum_new = 0;
        for (var j = 0, iLen = totals1.length; j < iLen; j++) {
            if (totals1[j].value!==""){
                val=parseFloat(totals1[j].value);
                sum_new +=val;
            }
        }
        var new_sum = parseFloat(sum + sum_new).toFixed(2) ;
        document.getElementById('grand_total').value =new_sum;
        // total pices
        var pices =document.getElementsByName("pics[]");
        var sum_pic = 0;
        for (var j = 0, iLen = pices.length; j < iLen; j++) {
            if (pices[j].value!==""){
                val=parseFloat(pices[j].value);
                sum_pic +=val;
            }
        }
        var new_pices =document.getElementsByName("new_pics[]");
        var sum_new_pic = 0;
        for (var j = 0, iLen = new_pices.length; j < iLen; j++) {
            if (new_pices[j].value!==""){
                val=parseFloat(new_pices[j].value);
                sum_new_pic +=val;
            }
        }

        var tot_qty = parseInt(sum_pic) + parseInt(sum_new_pic);
        document.getElementById('total_pic').value = parseInt(tot_qty);
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
    
    function change_new_holes() {

        var pices =document.getElementsByName("holes[]");
        var sum_pic = 0;
        for (var j = 0, iLen = pices.length; j < iLen; j++) {
            if (pices[j].value!==""){
                val=parseFloat(pices[j].value);
                sum_pic +=val;
            }
        }
        var new_pices =document.getElementsByName("new_holes[]");
        var sum_new_pic = 0;
        for (var j = 0, iLen = new_pices.length; j < iLen; j++) {
            if (new_pices[j].value!==""){
                val=parseFloat(new_pices[j].value);
                sum_new_pic +=val;
            }
        }

        var tot_qty = parseInt(sum_pic) + parseInt(sum_new_pic);
        document.getElementById('total_holes').value = parseInt(tot_qty);

    }

    function change_new_cutout() {

        var pices =document.getElementsByName("cutout[]");
        var sum_pic = 0;
        for (var j = 0, iLen = pices.length; j < iLen; j++) {
            if (pices[j].value!==""){
                val=parseFloat(pices[j].value);
                sum_pic +=val;
            }
        }
        var new_pices =document.getElementsByName("new_cutout[]");
        var sum_new_pic = 0;
        for (var j = 0, iLen = new_pices.length; j < iLen; j++) {
            if (new_pices[j].value!==""){
                val=parseFloat(new_pices[j].value);
                sum_new_pic +=val;
            }
        }

        var tot_qty = parseInt(sum_pic) + parseInt(sum_new_pic);
        document.getElementById('total_cutout').value = parseInt(tot_qty);

    }
    
    function change_new_rate() {

        var rate = document.getElementById('new_rate').value;
        var areas = document.getElementById('new_area').value;
        var total = (areas * rate);
        document.getElementById('new_total').value =  parseFloat(total).toFixed(2);

        var oldareas =document.getElementsByName("area[]");
        var sum_oldarea = 0;
        for (var j = 0, iLen = oldareas.length; j < iLen; j++) {
            if (oldareas[j].value!==""){
                val=parseFloat(oldareas[j].value);
                sum_oldarea +=val;
            }
        }
        var newareas =document.getElementsByName("new_area[]");
        var sum_newarea = 0;
        for (var j = 0, iLen = newareas.length; j < iLen; j++) {
            if (newareas[j].value!==""){
                val=parseFloat(newareas[j].value);
                sum_newarea +=val;
            }
        }

        var tot_area = parseFloat(sum_oldarea + sum_newarea);
        document.getElementById('total_area').value = parseFloat(tot_area).toFixed(2);






//            // Grand Total
        var totals =document.getElementsByName("total[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }

        var totals1 =document.getElementsByName("new_total[]");
        var sum_new = 0;
        for (var j = 0, iLen = totals1.length; j < iLen; j++) {
            if (totals1[j].value!==""){
                val=parseFloat(totals1[j].value);
                sum_new +=val;
            }
        }
        var new_sum = parseFloat(sum + sum_new).toFixed(2) ;
        document.getElementById('grand_total').value =new_sum;
        // total pices
        var pices =document.getElementsByName("pics[]");
        var sum_pic = 0;
        for (var j = 0, iLen = pices.length; j < iLen; j++) {
            if (pices[j].value!==""){
                val=parseFloat(pices[j].value);
                sum_pic +=val;
            }
        }
        var new_pices =document.getElementsByName("new_pics[]");
        var sum_new_pic = 0;
        for (var j = 0, iLen = new_pices.length; j < iLen; j++) {
            if (new_pices[j].value!==""){
                val=parseFloat(new_pices[j].value);
                sum_new_pic +=val;
            }
        }

        var tot_qty = parseInt(sum_pic) + parseInt(sum_new_pic);
        document.getElementById('total_pic').value = parseInt(tot_qty);
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

