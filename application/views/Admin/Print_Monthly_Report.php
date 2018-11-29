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
                <h3 class="tile-title" style="text-align: center;">Monthly Summary</h3>
                <h4  class="tile-title" style="text-align: center;"><?php echo date('F'); ?></h4>
                <div class="tile-body" >
                    <input  type="button" id="with_print" class="btn btn-primary pi_button" onclick="window.print()" value="Print">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="font-weight: bold; font-size: 16px;">Total PI Issued</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $pi_count[0]['pi_count']; ?></td>
                            <td style="font-weight: bold; font-size: 16px;">PI Amount</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $pi_count[0]['pi_amount']; ?></td>

                        </tr>
                        <tr>
                            <td style="font-weight: bold; font-size: 16px;">Total W/O Confirmed</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $wo_count[0]['wo_count']; ?></td>
                            <td style="font-weight: bold; font-size: 16px;">W/O Amount:</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $wo_count[0]['wo_amount']; ?></td>
                        </tr>


                        <tr>
                            <td style="font-weight: bold; font-size: 16px;">No.of Replacement Glass</td>
                            <td style="font-weight: bold; font-size: 24px;">0</td>
                            <td style="font-weight: bold; font-size: 16px;">Sq.Mt:</td>
                            <td style="font-weight: bold; font-size: 24px;">0</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; font-size: 16px;">No.of Recut Glass</td>
                            <td style="font-weight: bold; font-size: 24px;">0</td>
                            <td style="font-weight: bold; font-size: 16px;">Sq.Mt:</td>
                            <td style="font-weight: bold; font-size: 24px;">0</td>
                        </tr>

                        <tr>
                            <td style="font-weight: bold; font-size: 16px;">Total Bill Amount</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $total_bill[0]['total_amt']; ?></td>
                            <td style="font-weight: bold; font-size: 16px;">Total Sq.Mt</td>
                            <td id="total_area_material_qty" style="font-weight: bold; font-size: 24px;"></td>
                        </tr>

                        <tr>
                            <td style="font-weight: bold; font-size: 16px;">Chennai</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $wo_count_locations[0]['Chennai']; ?></td>
                            <td style="font-weight: bold; font-size: 16px;">Local</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $wo_count_locations[0]['Locals']; ?></td>
                            <td style="font-weight: bold; font-size: 16px;">Kerala</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $wo_count_locations[0]['Kerala']; ?></td>
                        </tr>
                    </table>

                    <h4>Normal Thickness Report</h4>
                    <table class="table table-hover table-bordered" id="sampleTable1">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Material Name</th>
                            <th>Qty</th>
                            <th>Area(Sq.mt)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($normal_material as $val)
                        {
                            $area =  number_format((float)$val['area'], 2, '.', '');
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['Material_Name']; ?></td>
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
                            <td colspan="2" style="text-align: right; font-weight: bold;">Total Summary</td>
                            <td id="tot_material_qty" style="font-weight: bold; font-size: 24px;"></td>
                            <td id="area_material_qty" style="font-weight: bold; font-size: 24px;"></td>

                        </tr>
                        </tbody>

                    </table>

                    <h4>Sheet Thickness Report</h4>
                    <table class="table table-hover table-bordered" id="sampleTable1">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Material Name</th>
                            <th>Qty</th>
                            <th>Area(Sq.mt)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($sheet_material as $val)
                        {
                            $area =  number_format((float)$val['area'], 2, '.', '');



                            ?>

                            <tr>

                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['Material_Name']; ?></td>
                                <td><?php echo $val['Total_Qty']; ?>
                                    <input type="hidden" name="material_qty1[]" value="<?php echo $val['Total_Qty']; ?>">
                                </td>
                                <td><?php echo $area ; ?>
                                    <input type="hidden" name="material_area1[]" value="<?php echo $val['area']; ?>">

                                </td>


                            </tr>

                            <?php
                            $i++;
                        }
                        ?>

                        <tr>
                            <td colspan="2" style="text-align: right; font-weight: bold;">Total Summary</td>
                            <td id="tot_material_qty1" style="font-weight: bold; font-size: 24px;"></td>
                            <td id="area_material_qty1" style="font-weight: bold; font-size: 24px;"></td>

                        </tr>
                        </tbody>

                    </table>

                    <h4>DG Thickness Report</h4>
                    <table class="table table-hover table-bordered" id="sampleTable1">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Material Name</th>
                            <th>Qty</th>
                            <th>Area(Sq.mt)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($dg_material as $val)
                        {
                            $area =  number_format((float)$val['area'], 2, '.', '');



                            ?>

                            <tr>

                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['Material_Name']; ?></td>
                                <td><?php echo $val['Total_Qty']; ?>
                                    <input type="hidden" name="material_qty2[]" value="<?php echo $val['Total_Qty']; ?>">
                                </td>
                                <td><?php echo $area ; ?>
                                    <input type="hidden" name="material_area2[]" value="<?php echo $val['area']; ?>">

                                </td>


                            </tr>

                            <?php
                            $i++;
                        }
                        ?>

                        <tr>
                            <td colspan="2" style="text-align: right; font-weight: bold;">Total Summary</td>
                            <td id="tot_material_qty2" style="font-weight: bold; font-size: 24px;"></td>
                            <td id="area_material_qty2" style="font-weight: bold; font-size: 24px;"></td>

                        </tr>
                        </tbody>

                    </table>

                    <h4>Lamination Thickness Report</h4>
                    <table class="table table-hover table-bordered" id="sampleTable1">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Material Name</th>
                            <th>Qty</th>
                            <th>Area(Sq.mt)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($lamination_material as $val)
                        {
                            $area =  number_format((float)$val['area'], 2, '.', '');



                            ?>

                            <tr>

                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['Material_Name']; ?></td>
                                <td><?php echo $val['Total_Qty']; ?>
                                    <input type="hidden" name="material_qty3[]" value="<?php echo $val['Total_Qty']; ?>">
                                </td>
                                <td><?php echo $area ; ?>
                                    <input type="hidden" name="material_area3[]" value="<?php echo $val['area']; ?>">

                                </td>


                            </tr>

                            <?php
                            $i++;
                        }
                        ?>

                        <tr>
                            <td colspan="2" style="text-align: right; font-weight: bold;">Total Summary</td>
                            <td id="tot_material_qty3" style="font-weight: bold; font-size: 24px;"></td>
                            <td id="area_material_qty3" style="font-weight: bold; font-size: 24px;"></td>

                        </tr>
                        </tbody>

                    </table>


                    <h4>Expenses</h4>
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Expenses Name</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; foreach ($expenses as $key) { ?>
                            <tr id="row<?php echo $i; ?>">
                                <td  class="heading"><?php echo $i; ?></td>
                                <td><?php echo $key['Expenses_Name']; ?></td>
                                <td><?php echo $key['amounts']; ?></td>

                            </tr>
                            <?php $i++; } ?>
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
        document.getElementById('area_material_qty').innerHTML = parseFloat(sum_mat_area).toFixed(2);


        var mqty1 =document.getElementsByName("material_qty1[]");
        var sum_qty1 = 0;
        for (var j = 0, iLen = mqty1.length; j < iLen; j++) {
            if (mqty1[j].value!==""){
                val=parseFloat(mqty1[j].value);
                sum_qty1 +=val;
            }
        }
        document.getElementById('tot_material_qty1').innerHTML = parseFloat(sum_qty1);

        var material_area1 = document.getElementsByName("material_area1[]");
        var sum_mat_area1=0;
        for (var j = 0, iLen = material_area1.length; j < iLen; j++) {
            if (material_area1[j].value!==""){
                val=parseFloat(material_area1[j].value);
                sum_mat_area1 +=val;
            }
        }
        document.getElementById('area_material_qty1').innerHTML = parseFloat(sum_mat_area1).toFixed(2);
        document.getElementById('area_material_qty1').innerHTML = parseFloat(sum_mat_area1).toFixed(2);



        var mqty2 =document.getElementsByName("material_qty2[]");
        var sum_qty2 = 0;
        for (var j = 0, iLen = mqty2.length; j < iLen; j++) {
            if (mqty2[j].value!==""){
                val=parseFloat(mqty2[j].value);
                sum_qty2 +=val;
            }
        }
        document.getElementById('tot_material_qty2').innerHTML = parseFloat(sum_qty2);

        var material_area2 = document.getElementsByName("material_area2[]");
        var sum_mat_area2=0;
        for (var j = 0, iLen = material_area2.length; j < iLen; j++) {
            if (material_area2[j].value!==""){
                val=parseFloat(material_area2[j].value);
                sum_mat_area2 +=val;
            }
        }
        document.getElementById('area_material_qty2').innerHTML = parseFloat(sum_mat_area2).toFixed(2);
        document.getElementById('area_material_qty2').innerHTML = parseFloat(sum_mat_area2).toFixed(2);


        var mqty3 =document.getElementsByName("material_qty3[]");
        var sum_qty3 = 0;
        for (var j = 0, iLen = mqty3.length; j < iLen; j++) {
            if (mqty3[j].value!==""){
                val=parseFloat(mqty3[j].value);
                sum_qty3 +=val;
            }
        }
        document.getElementById('tot_material_qty3').innerHTML = parseFloat(sum_qty3);

        var material_area3 = document.getElementsByName("material_area3[]");
        var sum_mat_area3=0;
        for (var j = 0, iLen = material_area3.length; j < iLen; j++) {
            if (material_area3[j].value!==""){
                val=parseFloat(material_area3[j].value);
                sum_mat_area3 +=val;
            }
        }
        document.getElementById('area_material_qty3').innerHTML = parseFloat(sum_mat_area3).toFixed(2);
        document.getElementById('area_material_qty3').innerHTML = parseFloat(sum_mat_area3).toFixed(2);

        var total_area = sum_mat_area + sum_mat_area1 + sum_mat_area2 + sum_mat_area3;

        document.getElementById('total_area_material_qty').innerHTML = parseFloat(total_area).toFixed(2);




































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


