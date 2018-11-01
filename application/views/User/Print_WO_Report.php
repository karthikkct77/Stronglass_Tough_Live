<style></style>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> Work Order Summery</h1>
        </div>

    </div>
    <div class="row">
        <!-- view Stock Details -->
        <div class="col-md-12">

            <div class="tile" id="pagewidth">
                <img style="width: 5%;height: auto;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
                <h3 class="tile-title" style="text-align: center;">Work Order Summary</h3>
                <div class="tile-body" >
                    <input  type="button" id="with_print" class="btn btn-primary pi_button" onclick="window.print()" value="Print">
                    <a class="btn btn-success pi_button" id="with_print" href="<?php echo site_url('User_Controller/Print_PDF_WO/' .$from_date. '/' .$to_date. ''); ?>">PDF</a>
<!--                    <h3>Date: --><?php //echo date('d-m-Y'); ?><!--</h3>-->

                    <!-- <div class="col-md-3">
                         <h5>NO.PI:<span style="font-weight: bold; font-size: 24px;"><?php /*echo $pi_count[0]['pi_count']; */?></span></h5>
                        </div>
                        <div class="col-md-3">
                            <h5>Amount:<span style="font-weight: bold; font-size: 24px;"><?php /*echo $pi_count[0]['pi_amount']; */?></span></h5>
                        </div>
                        <div class="col-md-3">
                            <h4>NO.WO:<span style="font-weight: bold; font-size: 24px;"><?php /*echo $wo_count[0]['wo_count']; */?></span></h4>
                        </div>
                        <div class="col-md-3">
                            <h4>Amount:<span style="font-weight: bold; font-size: 24px;"><?php /*echo $wo_count[0]['wo_amount']; */?></span></h4>
                        </div>-->
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="font-weight: bold; font-size: 16px;">From Date</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo  date("d-m-Y", strtotime($from_date)); ?></td>
                            <td style="font-weight: bold; font-size: 16px;">To Date</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo  date("d-m-Y", strtotime($to_date)); ?></td>
                            <td style="font-weight: bold; font-size: 16px;">NO.WO:</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $wo_count[0]['wo_count']; ?></td>
                            <td style="font-weight: bold; font-size: 16px;">Amount:</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $wo_count[0]['wo_amount']; ?></td>
                        </tr>
                    </table>

                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>S.No</th>
                            <th>WO.NO</th>
                            <th>PI.NO</th>
                            <th>Customer</th>
                            <th>Thickness</th>
                            <th>Special</th>
                            <th>Qty</th>
                            <th>SQ.M</th>

                            <th>Amount</th>


                        </tr>
                        </thead>
                        <tbody style="font-weight: bold;">
                        <?php $i=1;
                        foreach ($wo_details as $val)
                        {
                            $area =  number_format((float)$val['area'], 2, '.', '');
                            $thicks =  $val['thickness'];


                            ?>

                            <tr>

                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['WO_Number']; ?></td>
                                <td><?php echo $val['Proforma_Number']; ?></td>
                                <td><?php echo $val['Customer_Company_Name']; ?></td>
                                <td><?php echo $thicks;?>
                                <td><?php echo $val['special'];   ?>

                                <td><?php echo $val['Total_Qty']; ?>
                                    <input type="hidden" name="qty[]" value="<?php echo $val['Total_Qty']; ?>">
                                </td>
                                <td><?php echo $area ; ?>
                                    <input type="hidden" name="area[]" value="<?php echo $val['area']; ?>">

                                </td>

                                <td><?php echo $val['GrossTotal_Value']; ?>
                                    <input type="hidden" name="total[]" value="<?php echo $val['GrossTotal_Value']; ?>">

                                </td>


                            </tr>

                            <?php
                            $i++;
                        }
                        ?>
                        <tr>
                            <td colspan="6" style="text-align: right; font-weight: bold;">Total Summary</td>
                            <td id="tot_qty" style="font-weight: bold; font-size: 24px;"></td>
                            <td id="area_sqm" style="font-weight: bold; font-size: 24px;"></td>

                            <td id="total_amt" style="font-weight: bold; font-size: 24px;"></td>
                            <td></td>
                        </tr>
                        </tbody>

                    </table>

                    <table class="table table-hover table-bordered" id="sampleTable1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Material Name</th>
                                <th>Special</th>
                                <th>Qty</th>
                                <th>Area(Sq.mt)</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php $i=1;
                        foreach ($material_details as $val)
                        {
                            $area =  number_format((float)$val['area'], 2, '.', '');
                        


                            ?>

                            <tr>

                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['Material_Name']; ?></td>                        
                                <td><?php echo $val['special'];   ?>
                                <td><?php echo $val['Total_Qty']; ?>
                                    <input type="hidden" name="material_qty[]" value="<?php echo $val['Total_Qty']; ?>">
                                </td>
                                <td><?php echo $area ; ?>
                                    <input type="hidden" name="material_area[]" value="<?php echo $val['area']; ?>">

                                </td>


                            </tr>

                            <?php
                            $i++;
                        }
                        ?>
                            
                       <tr>
                            <td colspan="3" style="text-align: right; font-weight: bold;">Total Summary</td>
                            <td id="tot_material_qty" style="font-weight: bold; font-size: 24px;"></td>
                            <td id="area_material_qty" style="font-weight: bold; font-size: 24px;"></td>
                            <td></td>
                        </tr>
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>
<style type="text/css" media="print">
    #pagewidth {
        overflow: hidden ;
    }
    @media print {
        #with_print {
            display: none;
        }
        table { page-break-after:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        td    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        /*tfoot { display:table-footer-group }*/
        #page_inside {  page-break-inside: avoid; }
        #Signature { page-break-inside: avoid;}


    }
</style>
<script>
    $( document ).ready(function() {

        var mqty =document.getElementsByName("material_qty[]");
          var sum_qty = 0;
        for (var j = 0, iLen = mqty.length; j < iLen; j++) {
            if (mqty[j].value!==""){
                val=parseFloat(mqty[j].value);
                sum_qty +=val;
            }
        }
   document.getElementById('tot_material_qty').innerHTML = parseFloat(sum_qty);

        var material_area = document.getElementsByName("material_area[]");
        var sum_mat_area=0;
           for (var j = 0, iLen = material_area.length; j < iLen; j++) {
            if (material_area[j].value!==""){
                val=parseFloat(material_area[j].value);
                sum_mat_area +=val;
            }
        }
           document.getElementById('area_material_qty').innerHTML = parseFloat(sum_mat_area).toFixed(2);

      


     

        var totals =document.getElementsByName("total[]");
        var sum = 0;
        for (var j = 0, iLen = totals.length; j < iLen; j++) {
            if (totals[j].value!==""){
                val=parseFloat(totals[j].value);
                sum +=val;
            }
        }
        document.getElementById('total_amt').innerHTML = parseFloat(sum);

        var pices =document.getElementsByName("qty[]");
        var sum_pic = 0;
        for (var j = 0, iLen = pices.length; j < iLen; j++) {
            if (pices[j].value!==""){
                val=parseFloat(pices[j].value);
                sum_pic +=val;
            }
        }
        document.getElementById('tot_qty').innerHTML = parseFloat(sum_pic);

        var area =document.getElementsByName("area[]");
        var sum_area = 0;
        for (var j = 0, iLen = area.length; j < iLen; j++) {
            if (area[j].value!==""){
                val=parseFloat(area[j].value);
                sum_area +=val;
            }
        }
        document.getElementById('area_sqm').innerHTML = parseFloat(sum_area).toFixed(2);

        var areamm =document.getElementsByName("area_mm[]");
        var sum_areamm = 0;
        for (var j = 0, iLen = areamm.length; j < iLen; j++) {
            if (areamm[j].value!==""){
                val=parseFloat(areamm[j].value);
                sum_areamm +=val;
            }
        }
        
        document.getElementById('area_sqmm').innerHTML = parseFloat(sum_areamm);

    });
</script>


