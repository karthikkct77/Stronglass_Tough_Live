<style></style>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i> Sales Summery</h1>
        </div>

    </div>
    <div class="row">
        <!-- view Stock Details -->
        <div class="col-md-12">

            <div class="tile" id="pagewidth">
                <img style="width: 5%;height: auto;left: 1%;" src="<?php echo base_url('img/strong.png'); ?>" alt="User Image">
                <h3 class="tile-title" style="text-align: center;">Monthly Sales Summary</h3>
                <h4  class="tile-title" style="text-align: center;"><?php echo date('F'); ?></h4>

                <h4  class="tile-title" style="text-align: center;">Kerala</h4>
                <div class="tile-body">
                    <input  type="button" id="with_print" class="btn btn-primary pi_button" onclick="window.print()" value="Print">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="font-weight: bold; font-size: 16px;">Total Amount Net</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $wo_count_locations[0]['Kerala']; ?></td>

                        </tr>
                        <?php
                        $tot = $wo_count_locations[0]['Kerala'];
                        $gst = ($tot * 18) / 100;
                        $actual = $tot - $gst;

                        $sum_area = 0;
                        foreach ($material_details as $item) {
                            $sum_area += $item['area'];
                        }
                        ?>
                        <tr>
                            <td style="font-weight: bold; font-size: 16px;">Amount Without GST</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $actual; ?></td>
                            <td style="font-weight: bold; font-size: 16px;">GST Amount:</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $gst; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; font-size: 16px;">Transport Amount</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $transport[0]['Transport']; ?></td>
                            <td style="font-weight: bold; font-size: 16px;">Total Sqmt</td>
                            <td style="font-weight: bold; font-size: 24px;"><?php echo $sum_area; ?></td>
                        </tr>

                    </table>

                    <h4>Additional Charging List</h4>
                    <table class="table table-hover table-bordered" id="sampleTable1">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Charge Name</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;
                        foreach ($charges_location as $val)
                        {
                            $area =  number_format((float)$val['amount'], 2, '.', '');
                            ?>
                            <tr>

                                <td><?php echo $i; ?></td>
                                <td><?php echo $val['charge_name']; ?></td>
                                <td><?php echo $area; ?> </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>

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
        document.getElementById('area_material_qty1').innerHTML = parseFloat(sum_mat_area).toFixed(2);


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


