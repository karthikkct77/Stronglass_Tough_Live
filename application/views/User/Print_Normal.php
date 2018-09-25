<main class="app-content">
    <div  class="output" >
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>Work Order Print</h1>
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
            <div class="col-md-12" >
                <?php
                foreach ($print as $val)
                { ?>
                <div class="tile" id="page_setup">
                    <div class="row invoice">
                        <img style="position: absolute;width: 100px;height: auto;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
                        <h5><?php echo $st[0]['ST_Name']; ?></h5>
                        <h6><?php echo $st[0]['ST_Address_1']; ?>,&nbsp;<?php echo $st[0]['ST_Area']; ?>,&nbsp;<?php echo $st[0]['ST_City']; ?></h6>
                        <h6><span>Mob: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
                        <h6 style="text-align: right; padding-right: 1%;">Department: <?php echo $val['print_type']; ?></h6>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="consign">
                                <h6 class="heading"><span>Work Order No</span>: <?php echo $wo[0]['WO_Number']; ?></h6>
                                <h6 class="heading"><span>Proforma No</span>  :<?php echo $wo[0]['WO_Number']; ?></h6>
                                <h6 class="heading"><span>Work Order Date</span> :<?php $date = $wo[0]['WO_Created_On']; echo date("H:i",strtotime($date)); ?></h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="heading"><span>Project </span>:<?php echo $invoice[0]['Customer_Company_Name']; ?></h6>
                            <h6 class="heading"><span>Prepared Date</span>  :<?php echo date($wo[0]['WO_Date']); ?></h6>
                            <h6 class="heading"><span>Work Order Date</span> :<?php $date = $wo[0]['WO_Date']; echo date('Y-m-d', strtotime($date. ' + 2 days')); ?></h6>
                        </div>
                    </div>
                    <hr>
                    <?php
                    if($val['print_id'] == '5')  // FABRICATION
                    {
                        if($invoice[0]['PI_Type'] == '2' || $invoice[0]['PI_Type'] == '3'  )
                        { ?>
                            <div class="row">
                                <div class="col-md-10">
                                    <table class="table table-hover table-bordered" id="sampleTable">
                                        <thead>
                                        <th  class="heading">#</th>
                                        <th  class="heading">Materialssssss</th>
                                        <th  class="heading">Actual<br>size(h)</th>
                                        <th  class="heading">Actual<br>size(w)</th>
                                        <th  class="heading">No.of<br>Pieces</th>
                                        <th  class="heading">No.of<br>Holes</th>
                                        <th  class="heading">Cutouts</th>
                                        <th  class="heading">Special</th>
                                        <th  class="heading">Area<br>(sqmtr)</th>
                                        </thead>
                                        <tbody>
                                        <?php $i=1; foreach ($fab as $key) {
                                            $qty = $key['Proforma_Qty'] + $key['Proforma_Qty'];
                                            $tot_qty = $invoice_total[0]['qty'] + $invoice_total[0]['qty'];

                                            ?>
                                            <tr id="row<?php echo $i; ?>">
                                                <td  class="heading"><?php echo $i; ?></td>
                                                <td class="heading"><?php echo $key['Material_Name']; ?></td>
                                                <td class="heading"><?php echo $key['Proforma_Actual_Size_Width']; ?></td>
                                                <td class="heading"><?php echo $key['Proforma_Actual_Size_Height']; ?></td>
                                                <td class="heading"><?php echo $qty; ?></td>
                                                <td class="heading"><input type="hidden" name="holes_print[]" value="<?php echo $key['Proforma_Holes']; ?>" ><?php echo $key['Proforma_Holes']; ?></td>
                                                <td class="heading"><input type="hidden" name="cutout_print[]" value="<?php echo $key['Proforma_Cutout']; ?>" ><?php echo $key['Proforma_Cutout']; ?></td>
                                                <td class="heading"><?php echo $key['Proforma_Special']; ?></td>
                                                <td class="heading"><?php echo $key['Proforma_Area_SQMTR']; ?></td>
                                            </tr>
                                            <?php $i++; } ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="heading"><?php echo $tot_qty; ?></td>
                                            <td id="holes_print" class="heading"></td>
                                            <td id="cutout_print" class="heading"></td>
                                            <td></td>
                                            <td class="heading"><?php echo round($invoice_total[0]['area'], 2); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="col-md-2">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="heading">Exta</th>
                                            <th class="heading">Count</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i=1;
                                        foreach ($invoice_Charges as $key) {
                                            ?>
                                            <tr>
                                                <td class="heading"><?php echo $key['charge_name']; ?></td>
                                                <td class="heading"><?php echo $key['Proforma_Charge_Count']; ?></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                       <?php }
                       else
                       { ?>

                           <div class="row">
                               <div class="col-md-10">
                                   <table class="table table-hover table-bordered" id="sampleTable">
                                       <thead>
                                       <th  class="heading">#</th>
                                       <th  class="heading">Material</th>
                                       <th  class="heading">Actual<br>size(h)</th>
                                       <th  class="heading">Actual<br>size(w)</th>
                                       <th  class="heading">No.of<br>Pieces</th>
                                       <th  class="heading">No.of<br>Holes</th>
                                       <th  class="heading">Cutouts</th>
                                       <th  class="heading">Special</th>
                                       <th  class="heading">Area<br>(sqmtr)</th>
                                       </thead>
                                       <tbody>
                                       <?php $i=1; foreach ($fab as $key) {
                                           ?>
                                           <tr id="row<?php echo $i; ?>">
                                               <td  class="heading"><?php echo $i; ?></td>
                                               <td class="heading"><?php echo $key['Material_Name']; ?></td>
                                               <td class="heading"><?php echo $key['Proforma_Actual_Size_Width']; ?></td>
                                               <td class="heading"><?php echo $key['Proforma_Actual_Size_Height']; ?></td>
                                               <td class="heading"><?php echo$key['Proforma_Qty']; ?></td>
                                               <td class="heading"><input type="hidden" name="holes_print[]" value="<?php echo $key['Proforma_Holes']; ?>" ><?php echo $key['Proforma_Holes']; ?></td>
                                               <td class="heading"><input type="hidden" name="cutout_print[]" value="<?php echo $key['Proforma_Cutout']; ?>" ><?php echo $key['Proforma_Cutout']; ?></td>
                                               <td class="heading"><?php echo $key['Proforma_Special']; ?></td>
                                               <td class="heading"><?php echo $key['Proforma_Area_SQMTR']; ?></td>
                                           </tr>
                                           <?php $i++; } ?>
                                       <tr>
                                           <td></td>
                                           <td></td>
                                           <td></td>
                                           <td></td>
                                           <td class="heading"><?php echo $invoice_total[0]['qty']; ?></td>
                                           <td id="holes_print" class="heading"></td>
                                           <td id="cutout_print" class="heading"></td>
                                           <td></td>
                                           <td class="heading"><?php echo round($invoice_total[0]['area'], 2); ?></td>
                                       </tr>
                                       </tbody>
                                   </table>

                               </div>
                               <div class="col-md-2">
                                   <table class="table table-hover table-bordered">
                                       <thead>
                                       <tr>
                                           <th class="heading">Exta</th>
                                           <th class="heading">Count</th>
                                       </tr>
                                       </thead>
                                       <tbody>
                                       <?php
                                       $i=1;
                                       foreach ($invoice_Charges as $key) {
                                           ?>
                                           <tr>
                                               <td class="heading"><?php echo $key['charge_name']; ?></td>
                                               <td class="heading"><?php echo $key['Proforma_Charge_Count']; ?></td>
                                           </tr>
                                           <?php
                                           $i++;
                                       }
                                       ?>

                                       </tbody>
                                   </table>
                               </div>
                           </div>

                      <?php }
                        ?>


                    <?php }
                    else
                    {

                        if($invoice[0]['PI_Type'] == '2' || $invoice[0]['PI_Type'] == '3'  ) {
                          ?>

                            <div class="row">
                                <div class="col-md-10">
                                    <table class="table table-hover table-bordered" id="sampleTable">
                                        <thead>
                                        <th  class="heading">#</th>
                                        <th  class="heading">Material</th>
                                        <th  class="heading">Actual<br>size(h)</th>
                                        <th  class="heading">Actual<br>size(w)</th>
                                        <th  class="heading">No.of<br>Pieces</th>
                                        <th  class="heading">No.of<br>Holes</th>
                                        <th  class="heading">Cutouts</th>
                                        <th  class="heading">Special</th>
                                        <th  class="heading">Area<br>(sqmtr)</th>
                                        </thead>
                                        <tbody>
                                        <?php $i=1; foreach ($invoice_item as $key) {
                                            $tot =$key['Proforma_Qty'] + $key['Proforma_Qty'];
                                            $tot_qty = $invoice_total[0]['qty'] + $invoice_total[0]['qty'];
                                            ?>
                                            <tr id="row<?php echo $i; ?>">
                                                <td  class="heading"><?php echo $i; ?></td>
                                                <td class="heading"><?php echo $key['Material_Name']; ?></td>
                                                <td class="heading"><?php echo $key['Proforma_Actual_Size_Width']; ?></td>
                                                <td class="heading"><?php echo $key['Proforma_Actual_Size_Height']; ?></td>
                                                <td class="heading"><?php echo $tot;  ?></td>
                                                <td class="heading"><input type="hidden" name="holes_print[]" value="<?php echo $key['Proforma_Holes']; ?>" ><?php echo $key['Proforma_Holes']; ?></td>
                                                <td class="heading"><input type="hidden" name="cutout_print[]" value="<?php echo $key['Proforma_Cutout']; ?>" ><?php echo $key['Proforma_Cutout']; ?></td>
                                                <td class="heading"><?php echo $key['Proforma_Special']; ?></td>
                                                <td class="heading"><?php echo $key['Proforma_Area_SQMTR']; ?></td>
                                            </tr>
                                            <?php $i++; } ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="heading"><?php echo $tot_qty; ?></td>
                                            <td id="holes_print" class="heading"></td>
                                            <td id="cutout_print" class="heading"></td>
                                            <td></td>
                                            <td class="heading"><?php echo round($invoice_total[0]['area'], 2); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="col-md-2">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="heading">Exta</th>
                                            <th class="heading">Count</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i=1;
                                        foreach ($invoice_Charges as $key) {
                                            ?>
                                            <tr>
                                                <td class="heading"><?php echo $key['charge_name']; ?></td>
                                                <td class="heading"><?php echo $key['Proforma_Charge_Count']; ?></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <?php
                        }
                        else
                        {
                             ?>
                            <div class="row">
                                <div class="col-md-10">
                                    <table class="table table-hover table-bordered" id="sampleTable">
                                        <thead>
                                        <th  class="heading">#</th>
                                        <th  class="heading">Material</th>
                                        <th  class="heading">Actual<br>size(h)</th>
                                        <th  class="heading">Actual<br>size(w)</th>
                                        <th  class="heading">No.of<br>Pieces</th>
                                        <th  class="heading">No.of<br>Holes</th>
                                        <th  class="heading">Cutouts</th>
                                        <th  class="heading">Special</th>
                                        <th  class="heading">Area<br>(sqmtr)</th>
                                        </thead>
                                        <tbody>
                                        <?php $i=1; foreach ($invoice_item as $key) { ?>
                                            <tr id="row<?php echo $i; ?>">
                                                <td  class="heading"><?php echo $i; ?></td>
                                                <td class="heading"><?php echo $key['Material_Name']; ?></td>
                                                <td class="heading"><?php echo $key['Proforma_Actual_Size_Width']; ?></td>
                                                <td class="heading"><?php echo $key['Proforma_Actual_Size_Height']; ?></td>
                                                <td class="heading"><?php echo $key['Proforma_Qty']; ?></td>
                                                <td class="heading"><input type="hidden" name="holes_print[]" value="<?php echo $key['Proforma_Holes']; ?>" ><?php echo $key['Proforma_Holes']; ?></td>
                                                <td class="heading"><input type="hidden" name="cutout_print[]" value="<?php echo $key['Proforma_Cutout']; ?>" ><?php echo $key['Proforma_Cutout']; ?></td>
                                                <td class="heading"><?php echo $key['Proforma_Special']; ?></td>
                                                <td class="heading"><?php echo $key['Proforma_Area_SQMTR']; ?></td>
                                            </tr>
                                            <?php $i++; } ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="heading"><?php echo $invoice_total[0]['qty']; ?></td>
                                            <td id="holes_print" class="heading"></td>
                                            <td id="cutout_print" class="heading"></td>
                                            <td></td>
                                            <td class="heading"><?php echo round($invoice_total[0]['area'], 2); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="col-md-2">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="heading">Exta</th>
                                            <th class="heading">Count</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i=1;
                                        foreach ($invoice_Charges as $key) {
                                            ?>
                                            <tr>
                                                <td class="heading"><?php echo $key['charge_name']; ?></td>
                                                <td class="heading"><?php echo $key['Proforma_Charge_Count']; ?></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                       <?php }
                            ?>

                    <?php } ?>

                    <hr>
                    <div class="row" style="margin-top: 150px;">
                        <div class="col-md-3">

                            <h4 class="st_check">Prepared By</h4>

                        </div>
                        <div class="col-md-3">
                            <h4 class="st_check">Checked By</h4>
                        </div>
                        <div class="col-md-3">
                            <h4 class="st_check">Production Manager</h4>
                        </div>
                    </div>

                </div>
                <?php }
                ?>
            </div>
        </div>
    </div>
    </div>
</main>

<style>
    @media print {
        #with_print {
            display: none;
        }
        #page_setup {   page-break-before: always;
        }

    }
    h4 span{
        width: 185px;
        float: left;
    }
    .pi_button{
        margin-right: 15px;
        float: right;
    }
    .heading {
        font-size: 12px;
    }
    /* In CSS, not JavaScript */

</style>
<script type="text/javascript">
    $(document).ready(function(){
        window.print();
        history.back();
    });
</script>



