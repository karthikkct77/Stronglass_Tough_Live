<main class="app-content">
    <div   >
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i>Work Order Barcode</h1>
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
                            <h6><span>Phone: <?php echo $st[0]['ST_Phone']; ?></span> &nbsp;&nbsp; <span>Email :<?php echo $st[0]['ST_Email_ID1']; ?></span></h6>
                            <h6 style="margin: 0;"> Mob: <?php echo $st[0]['ST_Alternate_Phone']; ?> </h6>
                            <h6 style="text-align: right; padding-right: 1%;">Department: <?php echo $val['print_type']; ?></h6>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div id="consign">
                                    <h4  class="heading"><span>Work Order No</span>: <?php echo $wo[0]['WO_Number']; ?></h4>
                                    <h4  class="heading"><span>Proforma No</span>  :<?php echo $wo[0]['WO_Number']; ?></h4>
                                    <h4  class="heading"><span>Work Order Date</span> :<?php $date = $wo[0]['WO_Created_On']; echo date("H:i",strtotime($date)); ?></h4>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <h4  class="heading"><span>Project </span>:<?php echo $invoice[0]['Customer_Company_Name']; ?></h4>
                                <h4  class="heading"><span>Prepared Date</span>  :<?php echo date($wo[0]['WO_Date']); ?></h4>
                                <h4  class="heading"><span>Work Order Date</span> :<?php $date = $wo[0]['WO_Date']; echo date('Y-m-d', strtotime($date. ' + 2 days')); ?></h4>

                            </div>
                        </div>
                        <hr>
                        <?php
                        if($val['print_id'] == '5')  // FABRICATION
                        {  if($invoice[0]['PI_Type'] == '2' || $invoice[0]['PI_Type'] == '3'  )
                        { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="sampleTable" border="1" style="border-collapse: collapse;">
                                        <thead>
                                        <th  class="heading">#</th>
                                        <th  class="heading">Material</th>
                                        <th  class="heading">Qty</th>
                                        <th  class="heading">Width<br>mm</th>
                                        <th  class="heading">Height<br>mm</th>
                                        <th  class="heading">Area<br>(sqmtr)</th>
                                        <th  class="heading">No.of<br>Holes</th>
                                        <th  class="heading">Cutouts</th>
                                        <th  class="heading">Edge<br>finish</th>
                                        <th  class="heading">Drawing</th>
                                        <th  class="heading">Special</th>
                                        </thead>
                                        <tbody>
                                        <?php $i=1; foreach ($fab as $key) {
                                            $qty = $key['Proforma_Qty'] + $key['Proforma_Qty'];
                                            $tot_qty = $invoice_total[0]['qty'] + $invoice_total[0]['qty'];
                                            $tot_cutout = $invoice_total[0]['cutout'] + $invoice_total[0]['cutout'];
                                            $tot_holes = $invoice_total[0]['holes'] + $invoice_total[0]['holes'];
                                            $holes = $key['Proforma_Holes'] + $key['Proforma_Holes'];
                                            $cutout = $key['Proforma_Cutout'] + $key['Proforma_Cutout']; ?>

                                        <td id="row<?php echo $i; ?>">
                                                <td  class="heading"><?php echo $i; ?></td>
                                        <td class="heading" style="font-size: 12px; text-align: left;"><?php echo $key['Material_Name']; ?></td>
                                            <td class="heading"><?php echo $qty; ?></td>


                                            <?php
                                        if($key['Proforma_Special'] == 'T')
                                        {
                                            $height = $key['Proforma_Actual_Size_Height'] - 25;
                                            $width = $key['Proforma_Actual_Size_Width'] - 25;

                                            ?>
                                            <td class="heading"><?php echo $width; ?></td>

                                            <td class="heading"><?php echo $height; ?></td>

                                        <?php }
                                        else
                                        { ?>
                                            <td class="heading"><?php echo $key['Proforma_Actual_Size_Width']; ?></td>

                                            <td class="heading"><?php echo $key['Proforma_Actual_Size_Height']; ?></td>

                                        <?php }
                                        ?>
                                            <td class="heading"><?php echo round($totarea, 2); ?>      </td>


                                        <td class="heading"><?php echo $holes; ?></td>
                                        <td class="heading"><?php echo $cutout; ?></td>
                                            <td class="heading"></td>
                                            <td class="heading"></td>
                                        <td class="heading"><?php echo $key['Proforma_Special']; ?></td>
                                            <?php $i++; } ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="heading summary"><?php echo $invoice_total[0]['qty']; ?></td>

                                            <td></td>
                                            <td></td>
                                            <td class="heading summary"><?php echo round($invoice_total[0]['area'], 2); ?></td>

                                            <td id="holes_print" class="heading summary"><?php echo $invoice_total[0]['holes']; ?></td>
                                            <td id="cutout_print" class="heading summary"><?php echo $invoice_total[0]['cutout']; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="col-md-6">
                                    <table border="1" style="border-collapse: collapse; margin-top: 20px; ">
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
                                <div class="col-md-12">
                                    <table id="sampleTable" border="1" style="border-collapse: collapse;">
                                        <thead>
                                        <th  class="heading">#</th>
                                        <th  class="heading">Material</th>
                                        <th  class="heading">Qty</th>
                                        <th  class="heading">Width<br>mm</th>
                                        <th  class="heading">Height<br>mm</th>
                                        <th  class="heading">Area<br>(sqmtr)</th>
                                        <th  class="heading">No.of<br>Holes</th>
                                        <th  class="heading">Cutouts</th>
                                        <th  class="heading">Edge<br>finish</th>
                                        <th  class="heading">Drawing</th>
                                        <th  class="heading">Special</th>
                                        </thead>
                                        <tbody>
                                        <?php $i=1; foreach ($fab as $key) {
                                            ?>
                                            <tr id="row<?php echo $i; ?>">
                                                <td  class="heading"><?php echo $i; ?></td>
                                                <td class="heading" style="font-size: 12px; text-align: left;"><?php echo $key['Material_Name']; ?></td>
                                                <td class="heading"><?php echo$key['Proforma_Qty']; ?></td>

                                                <?php
                                                if($key['Proforma_Special'] == 'T')
                                                {
                                                    $height = $key['Proforma_Actual_Size_Height'] - 25;
                                                    $width = $key['Proforma_Actual_Size_Width'] - 25;

                                                    ?>
                                                    <td class="heading"><?php echo $width; ?></td>

                                                    <td class="heading"><?php echo $height; ?></td>

                                                <?php }
                                                else
                                                { ?>
                                                    <td class="heading"><?php echo $key['Proforma_Actual_Size_Width']; ?></td>

                                                    <td class="heading"><?php echo $key['Proforma_Actual_Size_Height']; ?></td>

                                                <?php }
                                                ?>
                                                <td class="heading"><?php echo round($totarea, 2); ?></td>

                                                <td class="heading"><input type="hidden" name="holes_print[]" value="<?php echo $key['Proforma_Holes']; ?>" ><?php echo $key['Proforma_Holes']; ?></td>
                                                <td class="heading"><input type="hidden" name="cutout_print[]" value="<?php echo $key['Proforma_Cutout']; ?>" ><?php echo $key['Proforma_Cutout']; ?></td>
                                                <td class="heading"></td>
                                                <td class="heading"></td>
                                                <td class="heading"><?php echo $key['Proforma_Special']; ?></td>
                                            </tr>
                                            <?php $i++; } ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="heading summary"><?php echo $invoice_total[0]['qty']; ?></td>

                                            <td></td>
                                            <td></td>
                                            <td class="heading summary"><?php echo round($invoice_total[0]['area'], 2); ?></td>

                                            <td id="holes_print" class="heading summary"><?php echo $invoice_total[0]['holes']; ?></td>
                                            <td id="cutout_print" class="heading summary"><?php echo $invoice_total[0]['cutout']; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="col-md-6">
                                    <table border="1" style="border-collapse: collapse; margin-top: 20px; ">
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
                       {  if($invoice[0]['PI_Type'] == '2' || $invoice[0]['PI_Type'] == '3'  ) {

                           ?>

                           <div class="row">
                               <div class="col-md-12">
                                   <table id="sampleTable" border="1" style="border-collapse: collapse;">
                                       <thead>
                                       <th  class="heading">#</th>
                                       <th  class="heading">Material</th>
                                       <th  class="heading">Qty</th>
                                       <th  class="heading">Width<br>mm</th>
                                       <th  class="heading">Height<br>mm</th>
                                       <th  class="heading">Area<br>(sqmtr)</th>
                                       <th  class="heading">No.of<br>Holes</th>
                                       <th  class="heading">Cutouts</th>
                                       <th  class="heading">Edge<br>finish</th>
                                       <th  class="heading">Drawing</th>
                                       <th  class="heading">Special</th>
                                       </thead>
                                       <tbody>
                                       <?php $i=1; foreach ($invoice_item as $key) {
                                           $tot =$key['Proforma_Qty'] + $key['Proforma_Qty'];
                                           $tot_qty = $invoice_total[0]['qty'] + $invoice_total[0]['qty'];
                                           $tot_cutout = $invoice_total[0]['cutout'] + $invoice_total[0]['cutout'];
                                           $tot_holes = $invoice_total[0]['holes'] + $invoice_total[0]['holes'];
                                           $holes = $key['Proforma_Holes'] + $key['Proforma_Holes'];
                                           $cutout = $key['Proforma_Cutout'] + $key['Proforma_Cutout'];
                                           ?>
                                           <td id="row<?php echo $i; ?>">
                                               <td  class="heading"><?php echo $i; ?></td>
                                               <td class="heading" style="font-size: 12px; text-align: left;"><?php echo $key['Material_Name']; ?></td>
                                               <td class="heading"><?php echo $qty; ?></td>


                                               <?php
                                               if($key['Proforma_Special'] == 'T')
                                               {
                                                   $height = $key['Proforma_Actual_Size_Height'] - 25;
                                                   $width = $key['Proforma_Actual_Size_Width'] - 25;

                                                   ?>
                                                   <td class="heading"><?php echo $width; ?></td>

                                                   <td class="heading"><?php echo $height; ?></td>

                                               <?php }
                                               else
                                               { ?>
                                                   <td class="heading"><?php echo $key['Proforma_Actual_Size_Width']; ?></td>

                                                   <td class="heading"><?php echo $key['Proforma_Actual_Size_Height']; ?></td>

                                               <?php }
                                               ?>
                                           <td class="heading"><?php echo round($totarea, 2); ?>      </td>

                                               <td class="heading"><?php echo $holes; ?></td>
                                               <td class="heading"><?php echo $cutout; ?></td>
                                           <td class="heading"></td>
                                           <td class="heading"></td>
                                               <td class="heading"><?php echo $key['Proforma_Special']; ?></td>
                                           <?php $i++; } ?>
                                       <tr>
                                           <td></td>
                                           <td></td>
                                           <td class="heading summary"><?php echo $invoice_total[0]['qty']; ?></td>

                                           <td></td>
                                           <td></td>
                                           <td class="heading summary"><?php echo round($invoice_total[0]['area'], 2); ?></td>

                                           <td id="holes_print" class="heading summary"><?php echo $invoice_total[0]['holes']; ?></td>
                                           <td id="cutout_print" class="heading summary"><?php echo $invoice_total[0]['cutout']; ?></td>
                                           <td></td>
                                           <td></td>
                                           <td></td>

                                       </tr>
                                       </tbody>
                                   </table>

                               </div>
                               <div class="col-md-6">
                                   <table border="1" style="border-collapse: collapse; margin-top: 20px; ">
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
                               <div class="col-md-12">
                                   <table id="sampleTable" border="1" style="border-collapse: collapse;">
                                       <thead>
                                       <th  class="heading">#</th>
                                       <th  class="heading">Material</th>
                                       <th  class="heading">Qty</th>
                                       <th  class="heading">Width<br>mm</th>
                                       <th  class="heading">Height<br>mm</th>
                                       <th  class="heading">Area<br>(sqmtr)</th>
                                       <th  class="heading">No.of<br>Holes</th>
                                       <th  class="heading">Cutouts</th>
                                       <th  class="heading">Edge<br>finish</th>
                                       <th  class="heading">Drawing</th>
                                       <th  class="heading">Special</th>
                                       </thead>
                                       <tbody>
                                       <?php $i=1; foreach ($invoice_item as $key) { ?>
                                           <tr id="row<?php echo $i; ?>">
                                               <td  class="heading"><?php echo $i; ?></td>
                                               <td class="heading"><?php echo $key['Material_Name']; ?></td>
                                               <td class="heading"><?php echo $key['Proforma_Qty']; ?></td>

                                               <?php
                                               if($key['Proforma_Special'] == 'T')
                                               {
                                                   $height = $key['Proforma_Actual_Size_Height'] - 25;
                                                   $width = $key['Proforma_Actual_Size_Width'] - 25;

                                                   ?>
                                                   <td class="heading"><?php echo $width; ?></td>
                                                   <td class="heading"><?php echo $height; ?></td>


                                               <?php }
                                               else
                                               { ?>
                                                   <td class="heading"><?php echo $key['Proforma_Actual_Size_Width']; ?></td>
                                                   <td class="heading"><?php echo $key['Proforma_Actual_Size_Height']; ?></td>


                                               <?php }
                                               ?>
                                               <td class="heading"><?php echo $key['Proforma_Area_SQMTR']; ?></td>

                                               <td class="heading"><input type="hidden" name="holes_print[]" value="<?php echo $key['Proforma_Holes']; ?>" ><?php echo $key['Proforma_Holes']; ?></td>
                                               <td class="heading"><input type="hidden" name="cutout_print[]" value="<?php echo $key['Proforma_Cutout']; ?>" ><?php echo $key['Proforma_Cutout']; ?></td>
                                               <td class="heading"></td>
                                               <td class="heading"></td>
                                               <td class="heading"><?php echo $key['Proforma_Special']; ?></td>
                                           </tr>
                                           <?php $i++; } ?>
                                       <tr>
                                           <td></td>
                                           <td></td>
                                           <td class="heading summary"><?php echo $invoice_total[0]['qty']; ?></td>

                                           <td></td>
                                           <td></td>
                                           <td class="heading summary"><?php echo round($invoice_total[0]['area'], 2); ?></td>

                                           <td id="holes_print" class="heading summary"><?php echo $invoice_total[0]['holes']; ?></td>
                                           <td id="cutout_print" class="heading summary"><?php echo $invoice_total[0]['cutout']; ?></td>
                                           <td></td>
                                           <td></td>
                                           <td></td>

                                       </tr>
                                       </tbody>
                                   </table>

                               </div>
                               <div class="col-md-6">
                                   <table border="1" style="border-collapse: collapse; margin-top: 20px; ">
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
                       <?php } ?>

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
                            <div class="col-md-3">
                                <input type="button" id="with_print" class="btn btn-primary pi_button" onclick="window.print()"value="Print"/>
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

    .heading {
        font-size: 10px;
        text-align: center;
    }
    .heading material {
        font-size: 10px;
        text-align: left;
    }
    /* In CSS, not JavaScript */
    @media print{@page {size: landscape}}

    .invoice h5 {
        font-size: 10px;
    }
    .invoice h4 {
        font-size: 10px;
    }
    table{
        width: 100%;
        font-size: 10px;
    }

    .st_check{
        font-size: 12px;
    }
    .summary{
        font-weight: bold;
    }
</style>

<script type="text/javascript">
    $(document).ready(function(){
        window.print();
        history.back();
    });


</script>



